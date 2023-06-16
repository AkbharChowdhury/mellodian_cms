@inject('helper', 'App\Models\CustomHelper')
@extends('layouts.app')
@section('title')
    Admin dashboard
@endsection

@section('content')

    <div class="container">
        @if (Session::has('message'))
            @include('messages.message')
        @endif


        <section class="pt-3 pb-3" id="title">
            <h1 class="text-capitalize text-dark p-2">Admin Panel</h1>

            <div class="border-bottom border-3 border-dark mb-4"></div>
            <section class="pt-3 pb-3" id="students">
                <h1 class="text-capitalize p-2">Events</h1>
                <div class="border-bottom border-3 border-dark"></div>
                <div class="col-sm-6 pt-3">
            <span class="float-left text-capitalize">
                    <a href="{{ route('admin.addEvent') }}" class="btn btn-dark text-capitalise">add event</a>
            </span>
                </div>
            </section>

            <p class="text-muted">Total Number of events: {{ count( $eventDetails ) }}</p>

            <table class="table table-striped table-bordered table-responsive">
                <caption>List of Events</caption>
                <thead>
                <tr>
                    <th scope="col">Event</th>
                    <th scope="col">Date & time</th>
                    <th scope="col">Adult Supervision</th>

                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($eventDetails as $event)

                    <tr>
                        <td>{{ $event->event_title }}</td>
                        <td>{{ $event->event_date->toFormattedDateString() }}
                            , {{ $helper->formatTime($event->start_time) }}
                            - {{ $helper->formatTime($event->end_time) }}</td>
                        <td>{{ $event->adult_supervision }}</td>
                        <td class="text-capitalize">
                            <a href="{{ route('admin.editEvent', $event->id) }}" class="btn btn-info">edit</a>


                            <form action="{{ route('admin.deleteEvent', $event->id) }}" id="deleteEvents" method="post" onsubmit="return confirm('Are you sure you want to delete this event? doing so will delete all bookings associated with this event.')? true: false">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>


            <div class="border-bottom border-3 border-dark mb-4"></div>
            <section class="pt-3 pb-3" id="students">
                <h1 class="text-capitalize p-2">customers</h1>
                <div class="border-bottom border-3 border-dark"></div>
                <div class="col-sm-6 pt-3">
            <span class="float-left text-capitalize">
                    <a href="{{ route('admin.addUser') }}" class="btn btn-dark text-capitalise">add customer</a>
            </span>
                </div>
            </section>

            <p class="text-muted">Total Number of customers: {{ count( $userDetails ) }}</p>

            <table class="table table-striped table-bordered table-responsive">
                <caption>List of Customers</caption>
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">address</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($userDetails as $user)

                    <tr>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                        <td>{{ $user->house_number }} {{ $user->street }} <br>
                            {{ $user->city }} <br>
                            {{ $user->postcode }}

                        </td>
                        <td class="text-capitalize">
                            <a href="{{ route('admin.edit_customer', $user->id) }}" class="btn btn-info">edit</a>

                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this customer? doing so will delete all bookings associated with this customer.')? true: false">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>


            <h1 class="text-capitalize p-2">Event Bookings</h1>
            <div class="border-bottom border-3 border-dark"></div>

            <p class="text-muted">Total Number of event booking: {{ count( $userBookings) }}</p>

            <table class="table table-striped table-bordered table-responsive">
                <caption>List of Event Sales</caption>
                <thead>
                <tr>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Event</th>
                    <th scope="col">Booking Date</th>
                    <th scope="col">Ticket Details</th>
                    <th scope="col">Seat Details</th>
                </tr>
                </thead>
                <tbody>
                @foreach($userBookings as $row)

                    <tr>
                        <td>{{ $row->firstname }} {{ $row->lastname }}</td>
                        <td>{{ $row->event_title }}</td>
                        <td>{{ \App\Models\CustomHelper::formatDate($row->sales_date) }}</td>
                        <td>
                            @php $total = 0 @endphp
                            @php $ticketStr = ''; @endphp
                            @foreach(\App\Http\Controllers\Admin\AdminController::getUserEventTickets($row->event_id, $row->user_id)  as $ticket)
                                @php
                                    $total+= doubleval($ticket->price) * intval($ticket->quantity);
                                @endphp

                                <p>{{ $ticket->type }}: {{ $ticket->quantity }}</p>

                            @endforeach
                            <strong>Total {{ $helper->formatMoney($total) }}</strong>

                        </td>
                        <td>

                            @foreach(\App\Http\Controllers\Admin\AdminController::getUserEventSeats($row->event_id, $row->user_id)  as $seat)
                                <p>{{ $seat->seat_type }}: {{ $seat->quantity }}</p>
                            @endforeach
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </section>
    </div>

@endsection
