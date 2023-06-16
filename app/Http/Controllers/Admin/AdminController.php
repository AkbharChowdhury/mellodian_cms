<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\StoreCreateEventRequest;
use App\Http\Requests\StoreCreateUserRequest;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\CustomHelper;
use App\Models\Event;
use App\Models\Salutation;
use App\Models\Seat;
use App\Models\User;
use Faker\Extension\Helper;
use Illuminate\Http\Request;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register()
    {

        return view('dashboard.admin.register');
    }



    public function create(StoreAdminRequest $request){



        if (Admin::create([

            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))// . CustomHelper::getPasswordSalt())

        ])) {
            return view('thank-you_admin');


        }

        $message = CustomHelper::setErrorMessage( 'Unable to register your admin account');


        return back()->with($message);

    }


    public static function getUserEventTickets($eventID, $userID): \Illuminate\Support\Collection
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
                ['u.id', '=', $userID],


            ])
            ->groupBy('t.type')
            ->get();
    }

    private function getAllUserEvents(): \Illuminate\Support\Collection
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
                'e.adult_supervision',
                'u.firstname',
                'u.lastname',

                's.title'
            )
            ->join('events AS e', 'e.id', '=', 'es.event_id')
            ->join('users AS u', 'es.user_id', '=', 'u.id')
            ->join('salutations AS s', 's.id', '=', 'u.salutation_id')
            ->get();
    }


    public static function getUserEventSeats($eventID, $userID)
    {
        return DB::table('event_seats', 'evt_seats')
            ->select('evt_seats.*', 's.seat_type')
            ->join('event_sales AS es', 'es.event_id', '=', 'evt_seats.event_id')
            ->join('seats AS s', 's.id', '=', 'evt_seats.seat_id')
            ->join('users AS u', 'u.id', '=', 'evt_seats.user_id')
            ->where([
                ['es.event_id', '=', $eventID],
                ['u.id', '=', $userID],


            ])
            ->groupBy('s.seat_type')

            ->get();

    }

    function index()
    {

        $data = [
            'eventDetails' => Event::all(),
            'seatDetails' => Seat::all(),
            'userDetails' => User::all(),
            'userBookings' => $this->getAllUserEvents(),


        ];

        return view('dashboard.admin.index', $data);

    }

    public function addEvent() {
        return view('events.create');
    }


    public function addUser() {
        $salutation = Salutation::all();


        return view('dashboard.admin.createUser', compact('salutation'));
    }

    function check(Request $request){
         //Validate Inputs
         $request->validate([
            'email'=>'required|email|exists:admins,email',
            'password'=>'required'
         ],[
         'email.exists' => 'This email does not exist in our system'

         ]);

         $creds = $request->only('email','password');

         if(Auth::guard('admin')->attempt($creds) ) return redirect()->route('admin.home');

         return redirect()->route('admin.login')->with('fail', 'The supplied email and password is incorrect');

    }

    function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }

//php artisan make:request StoreEventRequest

    public function createEvent(StoreCreateEventRequest $request) {
        // validate form
        $request->validated();
        // check if adult_supervision is checked otherwise the default value is N
        $adult_supervision = $request->input('adult_supervision') ?? 'N';

         if (Event::create([
             'event_title' => $request->input('event_title'),
             'event_description' => $request->input('event_description'),
             'event_date' => $request->input('event_date'),
             'start_time' => $request->input('start_time'),
             'end_time' => $request->input('end_time'),
             'adult_supervision' => $adult_supervision

         ])){
             $message = CustomHelper::setWarningMessage('event ' .$request->input('event_title'). ' added');
             return redirect()->route('admin.home')->with($message);

         }

    }


    public function editCustomer($id)
    {

        $data = [
             'customer' => User::findOrFail($id),
            'salutation' => Salutation::all()

        ];
        return view('dashboard.admin.edit_customer', $data);
    }


    public function editEvent($id)
    {

        $event = Event::findOrFail($id);
        return view('events.edit_event', compact('event'));
    }



   public function updateEvent(StoreCreateEventRequest $request, $id){


       if(Event::where('id', $id)->update([

           'event_title' => $request->input('event_title'),
             'event_description' => $request->input('event_description'),
             'event_date' => $request->input('event_date'),
             'start_time' => $request->input('start_time'),
             'end_time' => $request->input('end_time'),
             'adult_supervision' => $request->input('adult_supervision')
      ])){
           $message = CustomHelper::setWarningMessage('event updated');

           return redirect()->route('admin.home')->with($message);

       } else{

           $message = CustomHelper::setErrorMessage('unable to update event');
           return redirect()->route('admin.home')->with($message);


       }


   }


    public function deleteEvent($id) {
        $event = Event::findOrFail($id);
        $event->delete();
        $message = CustomHelper::setErrorMessage('event deleted');

        return back()->with($message);
    }


    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->delete();
        $message = CustomHelper::setErrorMessage('customer deleted');

        return back()->with($message);
    }



    public function updateCustomer(StoreUpdateUserRequest $request, $id){


        if (!empty($request->input('password'))){
            User::where('id', $id)->update([
                'password' => Hash::make($request->input('password').'ijdb'),

            ]);

        }

            if ($request->hasFile('passport_image')){
            $passportImage = file_get_contents($_FILES['passport_image']['tmp_name']);//$_FILES['passport_image']['size'] == 0 ? null : file_get_contents($_FILES['passport_image']['tmp_name']);

            User::where('id', $id)->update([
                'passport_image' => $passportImage

            ]);

        }

//        if (!empty($request->input('password'))){
//
//            User::where('id', $id)->update([
//                    'password' => Hash::make($request->input('password')),
//
//            ]);
//
//        }



//                    'password' => Hash::make($request->input('password')),




        if(User::where('id', $id)->update([

            'salutation_id' => $request->input('salutation_id'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
//            'passport_image' => $passportImage,
            'house_number' => $request->input('house_number'),
            'street' => $request->input('street_address'),
            'city' => $request->input('city'),
            'postcode' => $request->input('postcode'),
        ])){
            $message = CustomHelper::setWarningMessage('User updated');

//                [
//                'message' => 'User updated',
//                'type' => 'warning',
//                'icon' => CustomHelper::getMessageIcon('success')
//
//            ];

            return redirect()->route('admin.home')->with($message);

        } else{
            $message = CustomHelper::setErrorMessage('unable to updared user');
            return redirect()->route('admin.home')->with($message);


        }


    }



}