<?php

namespace App\Http\Controllers;

use App\Enums\AdultSupervision;
use App\Http\Controllers\User\UserController;
use App\Models\CustomHelper;
use App\Models\Event;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{

    public function index(Request $request)
    {

        $userID = 1;

        return view('events.index', compact('userID'));
    }



    private function renderBuyButton($eventID)
    {
        $btn = '';
        if (!isset(Auth::guard('web')->user()->id)) {
            $btn .= '<button class="btn btn-success text-capitalize" disabled>buy ticket</button>';

        } else if (UserController::userBookingExists($eventID)->isNotEmpty()) {
            $btn .= '<button class="btn btn-danger text-capitalize" disabled>booked</button>';
        } else {
            $buyLink = route('user.app', $eventID);

            $btn .= ' <a class="btn btn-success text-capitalize" href="' . $buyLink . '">buy ticket</a>';

        }


//    else if (isset(Auth::guard('admin')->user()->id)){
//            $btn.='';
//
//
//        }
        return $btn;


    }

    public function eventSearchResults(Request $request)
    {
        $events = $this->getEventResults($request);
        $output = '';
        if($events->isEmpty()){
            $error = CustomHelper::setError('no events found for this month') ;
            return "<div class='mt-2'>$error </div>";

        }

        foreach ($events as $row) {
            $btnBuy = $this->renderBuyButton($row->id);

            $adultSupervision =  $row->adult_supervision == AdultSupervision::Yes ? CustomHelper::getAdultSupervisionIcon() : '';


            $timeDifference = Carbon::parse($row->start_time)->diffInMinutes($row->end_time);
            $hours = $timeDifference / 60; // decimal hours
            $hoursStr = $hours == 1 ? $hours. ' hour' :  $hours. ' hours';

            $output .= '<div class="col-sm-6 pt-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize"> ' . $row->event_title . '</h5>    
                         <p>
                         ' . $adultSupervision . '
                        </p>                     
                        <h6>' . CustomHelper::formatDate($row->event_date) . '  ' . CustomHelper::formatTime($row->start_time) . ' - ' . CustomHelper::formatTime($row->end_time) . ' <span><small>' . $hoursStr . '</small></h6>
                        <p>' . $row->event_date->diffForHumans() . '</p>
                        <p class="card-text">' . $row->event_description . '</p>
                        ' . $btnBuy . '
                        
                    </div>
                </div>
            </div>    ';

        }
        return $output;
    }

    public function getEventResults(Request $request)
    {
        return Event::from('events' ,'e')
                ->select('e.*')
                ->when($request->input('txtSearch'), fn($query, $txtSearch) => $query->where('e.event_title', 'LIKE', '%' . $txtSearch . '%'))
                ->where('e.event_date', '>=', date('Y-m-d'))
                ->orderby('e.event_date')
                ->get();
    }
}
