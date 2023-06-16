<?php

namespace App\Http\Controllers\User;

use App\Enums\AdultSupervision;
use App\Enums\Tickets;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSales;
use App\Models\EventSeats;
use App\Models\EventTickets;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Salutation;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCreateUserRequest;
use App\Models\CustomHelper;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{

    public function dashboard()
    {
        $userEvents = $this->getUserEvents();

        $data = [
            'userEvents' => $userEvents,

        ];


        return view('dashboard.user.index', $data);

    }

    function index()
    {
        $salutation = Salutation::all();

        return view('dashboard.user.register', compact('salutation'));
    }


    public function bookEvent(Request $request)
    {
        define('MAX_TICKETS', CustomHelper::MAX_TICKETS);
        $tickets = $request->input('tickets');
        $numberOfTickets = array_sum($tickets);

        if ($numberOfTickets < 1) {
            $message = CustomHelper::setErrorMessage('Error: the number of tickets are missing');
            return redirect()->back()->with($message)->withInput();
        }

        $numAdults = $request->input('tickets')[Tickets::AdultIndex];

        if ($request->input('adult_supervision') == AdultSupervision::Yes && $numAdults < 1) {
            $message = CustomHelper::setErrorMessage('You must purchase at least one adult seat');
            return redirect()->back()->with($message)->withInput();
        }

        if ($numberOfTickets > MAX_TICKETS) {
            $message = CustomHelper::setErrorMessage('You can only purchase 8 tickets');
            return redirect()->back()->with($message)->withInput();
        }


        if (empty($request->input('seats'))) {
            $message = CustomHelper::setErrorMessage('You must select at least one seat');
            return redirect()->back()->with($message)->withInput();
        }


        $seatNum = $request->input('seatNum');
        $numberOfSeats = array_sum($seatNum);

        if ($numberOfTickets != $numberOfSeats) {
            $message = CustomHelper::setErrorMessage('The number of seats does not match the number adults and children tickets purchased');
            return redirect()->back()->with($message)->withInput();

        }


        $this->addEventSales($request);
        $this->addTicketDetails($request);
        $this->addSeatDetails($request);

        $message = CustomHelper::setSuccessMessage('booking confirmed');
//        ddd

        return redirect()->route('user.home')->with($message);


    }

    private function addEventSales(Request $request)
    {
        EventSales::create([
            'event_id' => $request->input('event_id'),
            'user_id' => Auth::guard('web')->user()->id,
            'sales_date' => date("Y/m/d"),

        ]);
    }

    private function addTicketDetails(Request $request)
    {
        $ticketIDList = $request->input('ticketIDList');
        $tickets = $request->input('tickets');

        foreach ($tickets as $k => $v) {

            $ticketQuantity = $v;

            if ($ticketQuantity > 0) {

                EventTickets::create([
                    'event_id' => $request->input('event_id'),
                    'user_id' => Auth::guard('web')->user()->id,
                    'ticket_id' => $ticketIDList[$k],
                    'quantity' => $ticketQuantity
                ]);
            }


        }

    }


    private function addSeatDetails(Request $request)
    {
        $seats = $request->input('seats');
        $seatNum = $request->input('seatNum');
        foreach ($seats as $k => $v) {
            $seatID = $v;

            EventSeats::create([
                'event_id' => $request->input('event_id'),
                'user_id' => Auth::guard('web')->user()->id,

                'seat_id' => $seatID,
                'quantity' => $seatNum[$k]
            ]);


        }
    }

    public function create(StoreCreateUserRequest $request)
    {

        $passportImage = $_FILES['passport_image']['size'] == 0 ? null : file_get_contents($_FILES['passport_image']['tmp_name']);


        if (User::create([
            'salutation_id' => $request->input('salutation_id'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),//. CustomHelper::getPasswordSalt()),
            'phone' => $request->input('phone'),
            'passport_image' => $passportImage,
            'house_number' => $request->input('house_number'),
            'street' => $request->input('street_address'),
            'city' => $request->input('city'),
            'postcode' => $request->input('postcode'),

        ])) {

            if ($request->has('isAdminForm')) {

                $message = CustomHelper::setSuccessMessage('customer account created');
                return redirect()->route('admin.home')->with($message);


            }
            return view('thank-you');


        }

        $message = CustomHelper::setErrorMessage('unable to add customer');


        return back()->with($message);

    }


    function check(Request $request)
    {
        //Validate inputs
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.exists' => 'This email does not exist in our system'
        ]);


        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {

            return redirect()->route('user.home');
        }
        return redirect()->route('user.login')->with('fail', 'The supplied email and password is incorrect');

    }

    function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    function showEventDetails($id)
    {


        $eventData = [
            'eventDetails' => Event::findOrFail($id),
            'seatDetails' => Seat::all(),
            'ticketDetails' => Ticket::all(),



        ];

        return view('events.show', $eventData);
    }
    public static function userBookingExists($eventID)
    {
        return DB::table('event_sales', 'es')
            ->select('es.*')
            ->join('users AS u', 'es.user_id', '=', 'u.id')
            ->where([

                ['u.id', '=', Auth::guard('web')->user()->id],
                ['event_id', '=', $eventID]

            ])
            ->get();

    }


    private function getUserEvents(): \Illuminate\Support\Collection
    {
        return DB::table('event_sales', 'es')
            ->select(
                'es.event_id',
                'es.user_id',
                'es.sales_date',
                'e.event_title',
                'e.event_description',
                'e.event_date',
                'e.start_time',
                'e.end_time',
                'e.adult_supervision'
            )
            ->join('events AS e', 'e.id', '=', 'es.event_id')
            ->join('users AS u', 'es.user_id', '=', 'u.id')
            ->where('es.user_id', '=', Auth::guard('web')->user()->id)
            ->get();
    }





    public static function getUserTickets($eventID): \Illuminate\Support\Collection
    {
        return DB::table('event_tickets', 'et')
            ->select(
                'et.event_id',

                'et.quantity',
                't.type',
                't.price'

            )
            ->join('event_sales AS e', 'e.event_id', '=', 'et.event_id')
            ->join('tickets AS t', 't.id', '=', 'et.ticket_id')
            ->join('users AS u', 'e.user_id', '=', 'u.id')

            ->where([

                ['e.event_id', '=', $eventID],
                ['u.id', '=', Auth::guard('web')->user()->id],


            ])
            ->groupBy('t.type')
            ->get();
    }


    public static function getUserSeats($eventID)
    {
        return DB::table('event_seats', 'evt_seats')
            ->select('evt_seats.*', 's.seat_type')
            ->join('event_sales AS es', 'es.event_id', '=', 'evt_seats.event_id')
            ->join('seats AS s', 's.id', '=', 'evt_seats.seat_id')
            ->join('users AS u', 'u.id', '=', 'evt_seats.user_id')
            ->where([
                ['es.event_id', '=', $eventID],
                ['u.id', '=', Auth::guard('web')->user()->id],


            ])
            ->groupBy('s.seat_type')

            ->get();

    }



}