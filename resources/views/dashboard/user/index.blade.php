@inject('helper', 'App\Models\CustomHelper')
@extends('layouts.app')
@section('title')
    My Dashboard
@endsection

@php
    use \App\Http\Controllers\User\UserController
@endphp

@section('content')

    <div class="container">

        @if (Session::has('message'))
            @include('messages.message')
        @endif

        <h1>My Bookings</h1>
        <hr>
        @if ($userEvents->isEmpty())
            <div class="alert alert-warning" role="alert">
                You have not made any bookings yet. Why not view our <a href=" {{route('events.index')  }}"
                                                                        class="alert-link">events</a>?
            </div>
        @endif

        <div class="row">
            @foreach($userEvents as $row)
                @php
                    $eventID =  $row->event_id;
                @endphp

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $row->event_title }} {{ $row->event_id }}</h5>
                            <p class="card-text"> {!! \App\Models\CustomHelper::snippet($row->event_description) !!} </p>
                            <strong>{{ date('D d M Y', strtotime($row->event_date)) }} {{ $helper->formatTime($row->start_time) }}
                                - {{ $helper->formatTime($row->end_time) }} {{ Carbon::parse($row->event_date)->diffForHumans()}}</strong>
                            <p>
                                <small class="text-muted">{{ $row->adult_supervision == 'Y'? 'Requires adult supervision':'' }}</small>
                            </p>

                            <h4 class="text-capitalize">ticket details</h4>
                            <hr>
                            @php $total = 0 @endphp
                            @php $ticketStr = ''; @endphp
                            @foreach(UserController::getUserTickets($eventID)  as $ticket)
                                @php
                                    $total+= doubleval($ticket->price) * intval($ticket->quantity);
                                @endphp

                                <p>{{ $ticket->type }}: {{ $ticket->quantity }}</p>
                            @endforeach
                            <p>{{ $helper->formatMoney($total) }}</p>
                            <h4 class="text-capitalize">seat details</h4>
                            <hr>
                            @foreach(UserController::getUserSeats($eventID)  as $seat)
                                <p>{{ $seat->seat_type }}: {{ $seat->quantity }}</p>

                            @endforeach


                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection




