<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $data = [

            'seatDetails' => Seat::all(),
            'ticketDetails' => Ticket::all(),

        ];

        return view('welcome', $data);
    }
}
