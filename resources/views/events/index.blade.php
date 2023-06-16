@inject('helper', 'App\Models\CustomHelper')
@extends('layouts.app')
@section('title')
    {{ config('app.name') }} view events new
@endsection
{{-- // live search reference: https://www.webslesson.info/2018/04/live-search-in-laravel-using-ajax.htm --}}
@php
    use \App\Http\Controllers\User\UserController
@endphp

@section('content')

    <div class="container">
        {!! $helper->breadcrumb("browse events") !!}
        <h1 class="text-capitalize">browse events</h1>
        <hr>
        <form class="d-flex" role="search" id="productsSearchForm">
            <input type="hidden" id="searchRoute" value="{{ route('events.search_results') }}">
{{--            <input type="text" id="eventDetailsRoute" value="{{  route('user.app', 2) }}">--}}
            <input type="hidden" id="customer_id" value="{{ isset(Auth::guard('web')->user()->id) ? Auth::guard('web')->user()->id:  '0'  }}">
            <input type="hidden" id="booking_exists" value="{{ isset(Auth::guard('web')->user()->id) ? Auth::guard('web')->user()->id:  '0'  }}">

            <input class="form-control me-2" type="search" id="search" name="search"
                placeholder="Search Events" aria-label="Search" autofocus>
        </form>
        <div class="row pt-2" id="search_results"></div>
    </div>
    @section('scripts')
        <script type="module" src="{{ asset('js/search_events.js') }}"></script>
    @endsection
@endsection
