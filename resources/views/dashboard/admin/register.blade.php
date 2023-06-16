@inject('helper', 'App\Models\CustomHelper')
@extends('layouts.app')
@section('title')
    {{ config('app.name') }} - admin register
@endsection

@section('content')
    <div class="container">
        {!! $helper->breadcrumb('Admin register') !!}

        <h1>Admin register</h1>
        <form class="row g-3 needs-validation" method="post" novalidate autocomplete="off" action="{{ route('admin.create') }}">
            @csrf

            <div class="col-md-6">
                <label for="firstname" class="form-label">FirstName <span
                            class="text-danger">*</span></label>
                <input id="firstname" type="text"
                       class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                       value="{{ old('firstname') }}" required autofocus>
                @include('errors.span_error', ['errorField' =>'firstname'])
                <div class="invalid-feedback">firstname is required</div>
            </div>
            <div class="col-md-6">
                <label for="lastname" class="form-label">lastname <span
                            class="text-danger">*</span></label>
                <input id="lastname" type="text"
                       class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                       value="{{ old('lastname') }}" required autofocus>
                @include('errors.span_error', ['errorField' =>'lastname'])
                <div class="invalid-feedback">lastname is required</div>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">email <span
                            class="text-danger">*</span></label>
                <input id="email" type="text"
                       class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{ old('email') }}" required autofocus>
                @include('errors.span_error', ['errorField' =>'email'])
                <div class="invalid-feedback">email is required</div>
            </div>


            <div class="col-md-6">
                <label for="password" class="form-label">password <span
                            class="text-danger">*</span></label>
                <input id="admin" type="password"
                       class="form-control @error('password') is-invalid @enderror" name="password"
                       value="{{ old('password') }}" required autofocus>
                @include('errors.span_error', ['errorField' =>'password'])
                <div class="invalid-feedback">password is required</div>
            </div>

            <div class="col-12">
                <button class="btn btn-success" type="submit">create account</button>
            </div>
        </form>
{{--        --}}
{{--        <form class="row g-3 needs-validation" action="{{ route('user.check') }}" method="post" novalidate>--}}
{{--            @csrf--}}
{{--            <div class="col-md-8">--}}
{{--                <label for="email" class="form-label">email</label>--}}
{{--                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email" value="{{ old('email') }}" autofocus required>--}}
{{--                @include('errors.span_error', ['errorField' =>'email'])--}}

{{--                <div class="invalid-feedback">email is required</div>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <label for="password" class="form-label">password</label>--}}
{{--                <input type="password" class="form-control" maxlength="20" id="password" name="password" placeholder="password" required>--}}
{{--                @include('errors.span_error', ['errorField' =>'password'])--}}

{{--                <div class="invalid-feedback">password is required</div>--}}
{{--            </div>--}}

{{--            <div class="col-12">--}}
{{--                <input type="submit" class="btn btn-success" name="login" value="Login">--}}

{{--                <p class="text-danger mt-3">@if (Session::get('fail')) {{ Session::get('fail') }} @endif</p>--}}
{{--                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('user.register') }}" class="link-success">Register</a></p>--}}
{{--            </div>--}}
{{--        </form>--}}


    </div>
@endsection







{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <title>User Login</title>--}}
{{--    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">--}}
{{--</head>--}}
{{--<body>--}}

{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-4 offset-md-4" style="margin-top: 45px;">--}}
{{--            <h4>User Login</h4><hr>--}}
{{--            <form action="{{ route('user.check') }}" method="post" autocomplete="off">--}}
{{--                @if (Session::get('fail'))--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        {{ Session::get('fail') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @csrf--}}
{{--                <div class="form-group">--}}
{{--                    <label for="email">Email</label>--}}
{{--                    <input type="text" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">--}}
{{--                    <span class="text-danger">@error('email'){{ $message }}@enderror</span>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="password">Password</label>--}}
{{--                    <input type="password" class="form-control" name="password" placeholder="Enter password" value="{{ old('password') }}">--}}
{{--                    <span class="text-danger">@error('password'){{ $message }}@enderror</span>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <button type="submit" class="btn btn-primary">Login</button>--}}
{{--                </div>--}}
{{--                <br>--}}
{{--                <a href="{{ route('user.register') }}">Create new Account</a>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--</body>--}}
{{--</html>--}}