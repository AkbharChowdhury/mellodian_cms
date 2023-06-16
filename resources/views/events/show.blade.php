@inject('helper', 'App\Models\CustomHelper')
@extends('layouts.app')
@section('title')
   {{ $eventDetails->event_title }}
@endsection

@php
    use \App\Http\Controllers\User\UserController
@endphp

@section('scripts')

    <script>
        let adultPrice = 0;
        let childPrice = 0;
        function calcTotal(qtyStr, priceStr, type){
            const price = parseFloat(priceStr);
            const qty = parseInt(qtyStr);
            const total = price * qty;
            type === 'Adult' ?  adultPrice = total: childPrice = total;
            document.getElementById('total').innerText = adultPrice + childPrice;
        }

        function toggleSeat(seatID) {
            const id = 'seat_' + seatID;
            document.getElementById(id).toggleAttribute('disabled');
        }

    </script>

@endsection

@section('content')

    <div class="container">
        @include('recycler.breadcrumb',  ['subLink' =>  'events.index','subtitle' =>  'Browse Events','title' =>  $eventDetails->event_title])
        @if (Session::has('message'))
            @include('messages.message')
        @endif


        @if(UserController::userBookingExists($eventDetails->id)->isNotEmpty())
            <div class="alert alert-danger" role="alert">
                You have already booked for this event
            </div>
            @else


        <div class="card">
            <div class="card-header">
                <strong>{{ $eventDetails->event_title }}</strong>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $eventDetails->event_date->toFormattedDateString() }} <small>{{ $eventDetails->event_date->diffForHumans() }} </small></h5>
                <p>{{ $helper->formatTime($eventDetails->start_time) }} - {{ $helper->formatTime($eventDetails->end_time) }}</p>
                <p>{!! $eventDetails->adult_supervision == \App\Enums\AdultSupervision::Yes ? $helper->getAdultSupervisionIcon(): ''   !!} </p>

                <h3>How many?</h3>
                <hr>
                <form method="post" class="row g-3" action="{{ route('user.bookEvent') }}" novalidate  autocomplete="off">
                    @csrf
                    <input type="hidden" name="adult_supervision" value="{{ $eventDetails->adult_supervision }}">
                    <input type="hidden" name="event_id" value="{{ $eventDetails->id }}">


                    @foreach($ticketDetails as $row)
                    <div class="mb-3">
                        <div class="col-md-6">
                            <input type="hidden" name="ticketIDList[]" value="{{ $row->id  }}">
                            <label for="{{ $row->type  }}" class="form-label text-capitalize">{{ $row->type }} {{ $helper->formatMoney($row->price) }}</label>

                            <input type="number" maxlength="1" name="tickets[]" class="form-control" id="{{ $row->type  }}"
                                   min="0" max="8"
                                   value="{{ old('tickets.'.$loop->index, 0) }}"
                                   oninput="validateNumber(this)"
                                   data-type="{{ $row->type }}"
                                   onchange="calcTotal(this.value, {{ $row->price }}, this.dataset.type)"
                            >

                            @if($row->type =='Adult')
                                <div class="form-text pt-1">Please note that where adult supervision is required at least one adult ticket must be purchased and you must have valid photo present</div>
                            @endif


                        </div>
                    </div>
                    @endforeach

                    <h3 class="text-capitalize">seat details</h3>
                    <hr>

                    @foreach($seatDetails as $seat)

                        <div class="row g-3">
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" name="seats[]" type="checkbox" value="{{ $seat->id }}"
                                           id="{{ $seat->id }}"
                                           onchange="toggleSeat({{ $seat->id }})"
                                            @checked(old('seatNum.'.$loop->index) == $seat->id )>

                                    <label class="form-check-label" for="{{ $seat->id }}">
                                        {{ $seat->seat_type }}
                                    </label>
                                </div>

                            </div>
                            <div class="col-auto pb-2">
                                <label for="{{ $seat->id }}" class="visually-hidden">{{ $seat->seat_type }}</label>
                                <input type="number" name="seatNum[]" class="form-control"
                                       id="seat_{{ $seat->id }}"{{ $seat->id }}"
                                        name="{{ $seat->id }}"
                                        min="1"
                                        max="8"
                                        value="{{ old('seatNum.'.$loop->index, 1) }}"
                                @disabled(old('seatNum.'.$loop->index) != $seat->id )
                            </div>

                        </div>
                    @endforeach

                    <div class="col-12">
                        <h3>Total £<span id="total"></span></h3>
                    </div>
                    <div class="mt-3">
                       <input type="submit" value="confirm booking" class="btn btn-success">
                   </div>

                </form>
            </div>
        </div>
        @endif

    </div>


@endsection






