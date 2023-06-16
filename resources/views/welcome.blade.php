@inject('helper', 'App\Models\CustomHelper')

@extends('layouts.app')
@section('title')
    Welcome to {{ config('app.name') }}
@endsection
@section('content')
    <div class="flex-center ">
        <div class="content">
            <img src="{{ $helper->getPublicImage('logo.png') }}" alt="logo">

            <div class="title m-b-md">
                {{ config('app.name') }}

            </div>
            <h3>Ticket prices</h3>
            <hr>
            @foreach($ticketDetails as $row)
                <p>{{  $row->type }}- {{ $helper->formatMoney($row['price']) }}</p>
            @endforeach
            <p>

                <span>
                    <button class="btn btn-success text-capitalize"
                            onclick="window.location.href='{{ route('events.index') }}'"> search events</button>
                </span>

            </p>

        </div>
    </div>
@endsection
