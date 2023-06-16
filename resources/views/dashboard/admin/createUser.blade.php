@extends('layouts.app')
@section('title')
    {{ config('app.name') }} - register
@endsection

@section('content')
    <div class="container">

        @if (Session::has('message'))
            @include('messages.message')
        @endif

        @if (Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
        @endif


        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif


        <div class="py-5 text-center">

            <img class="d-block mx-auto mb-4" src="{{ asset('images/logo.png') }}" alt="Logo" width="72" height="57">
            <h2>Create an account for free today </h2>
            <p class="lead">Start exploring a wide range of exciting rides</p>


        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <h4 class="mb-3 text-success">Personal Details</h4>
                        <hr>

                        <form method="post" class="row g-3" action="{{ route('user.create') }}" novalidate
                              autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="true" name="isAdminForm">


                            <div class="col-md-12">
                                <label for="salutation_id" class="form-label">Title <span
                                            class="text-danger">*</span></label>

                                <select class="form-select @error('salutation_id') is-invalid @enderror"
                                        aria-label="Select title" name="salutation_id">
                                    <option selected value="">Select Title</option>
                                    @include('recycler.dropdown', ['data' => $salutation, 'selectedValue' => old('salutation_id') , 'fieldName'=>'title'])
                                </select>
                                @include('errors.span_error', ['errorField' =>'salutation_id'])
                            </div>


                            <div class="col-md-6">
                                <label for="firstname" class="form-label">First Name <span
                                            class="text-danger">*</span></label>
                                <input id="firstname" type="text"
                                       class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                       value="{{ old('firstname') }}" required autofocus>
                                @include('errors.span_error', ['errorField' =>'firstname'])
                            </div>


                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                <input id="lastname" type="text"
                                       class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                       value="{{ old('lastname') }}" required>
                                @include('errors.span_error', ['errorField' =>'lastname'])

                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">email <span class="text-danger">*</span></label>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required>
                                <small id="emailHelpBlock" class="form-text text-muted">This email will be used to send
                                    you important updates</small>
                                @include('errors.span_error', ['errorField' =>'email'])

                            </div>


                            <div class="col-md-6">
                                <label for="phone" class="form-label">phone <span class="text-danger">*</span></label>
                                <input id="phone" oninput="validateNumber(this)" type="text"
                                       class="form-control @error('phone') is-invalid @enderror" maxlength="11"
                                       name="phone"
                                       value="{{ old('phone') }}" required>
                                @include('errors.span_error', ['errorField' =>'phone'])


                            </div>

                            <div class="col-12">
                                <label for="password" class="form-label">password <span
                                            class="text-danger">*</span></label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       value="{{ old('password') }}" required>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="togglePassword">
                                    <label class="form-check-label" for="togglePassword">
                                        show password
                                    </label>
                                </div>
                                @include('errors.span_error', ['errorField' => 'password'])
                            </div>


                            <div class="col-md-6">
                                <label for="house_number" class="form-label text-capitalize">house Number <span
                                            class="text-danger">*</span></label>
                                <input id="house_number" type="text"
                                       class="form-control @error('house_number') is-invalid @enderror"
                                       name="house_number" value="{{ old('house_number') }}" required>
                                @include('errors.span_error', ['errorField' => 'house_number'])
                            </div>


                            <div class="col-12">
                                <label for="street_address" class="form-label text-capitalize">Street Address <span
                                            class="text-danger">*</span></label>
                                <input id="street_address" type="text"
                                       class="form-control @error('street_address') is-invalid @enderror"
                                       name="street_address" value="{{ old('street_address') }}" required>
                                @include('errors.span_error', ['errorField' => 'street_address'])

                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label text-capitalize">City <span
                                            class="text-danger">*</span></label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                       name="city" value="{{ old('city') }}" required>
                                @include('errors.span_error', ['errorField' => 'city'])

                            </div>

                            <div class="col-md-6">
                                <label for="postcode" class="form-label text-capitalize">Postcode <span
                                            class="text-danger">*</span></label>
                                <input id="postcode" type="text"
                                       class="form-control @error('postcode') is-invalid @enderror" name="postcode"
                                       value="{{ old('postcode') }}" required>
                                @include('errors.span_error', ['errorField' => 'postcode'])

                            </div>
                            <div class="mb-3">
                                <div class="col-md-6" style="display: none" id="imageDiv">
                                    <img class="img-fluid img-rounded"
                                         id="customerImage"
                                         alt="customer passport image"
                                         height="100" width="100">
                                </div>
                                <label for="passport_image" class="form-label">Passport Image</label>
                                <input class="form-control" type="file" id="passport_image" name="passport_image">
                                <small id="passportImageHelpBlock" class="form-text text-muted">Please ensure to take a
                                    clear photo of your passport to make the verification process faster</small>

                            </div>
                            <div class="col-12">
                                <h4 class="mb-3 text-success text-capitalize">Terms and conditions</h4>
                                <hr>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agree" name="agree[]">
                                    <label class="form-check-label" for="agree">
                                        I agree to the terms and conditions
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success text-capitalize">Let the journey begin
                                </button>
                            </div>
                        </form>
                        {!! \App\Models\CustomHelper::getRequiredFieldMessage()  !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script  src="{{ asset('js/show_passport_live_preview.js') }}"></script>
@endsection

