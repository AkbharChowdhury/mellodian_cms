@extends('layouts.app')
@section('title')
    edit customer details
@endsection

@section('styles')

@endsection
@section('content')
    <div class="container">
        @if (Session::has('message'))
            @include('messages.message')
        @endif

        @include('recycler.admin_breadcrumb',  ['title' =>  'edit customer','homeLink' =>  'admin.home'])

        <div class="py-5 text-center">

            <img class="d-block mx-auto mb-4" src="{{ asset('images/logo.png') }}" alt="Logo" width="72" height="57">
            <h2 class="text-capitalize">edit Customer</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <h4 class="mb-3 text-success">Personal Details</h4>
                        <hr>

                        <form method="post" class="row g-3" action="{{ route('admin.updateCustomer', $customer->id) }}"
                              novalidate
                              autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="isAdminForm" value="true">

                            <div class="col-md-12">
                                <label for="salutation_id" class="form-label">Title <span
                                            class="text-danger">*</span></label>

                                <select class="form-select @error('salutation_id') is-invalid @enderror"
                                        aria-label="Select title" name="salutation_id">
                                    <option selected value="">Select Title</option>
                                    @foreach($salutation as $row)
                                        <option value="{{ $row['id'] }}" {{ old('salutation_id', $customer->salutation_id) == $row['id'] ? 'selected' : '' }}>{{ $row['title']  }}</option>
                                    @endforeach
                                </select>
                                @include('errors.span_error', ['errorField' =>'salutation_id'])
                            </div>

                            <div class="col-md-6">
                                <label for="firstname" class="form-label">FirstName <span
                                            class="text-danger">*</span></label>
                                <input id="firstname" type="text"
                                       class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                       value="{{ old('firstname', $customer->firstname) }}" required autofocus>
                                @include('errors.span_error', ['errorField' =>'firstname'])
                            </div>


                            <div class="col-md-6">
                                <label for="lastname" class="form-label">lastname <span
                                            class="text-danger">*</span></label>
                                <input id="lastname" type="text"
                                       class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                       value="{{ old('lastname', $customer->lastname) }}" required>
                                @include('errors.span_error', ['errorField' =>'lastname'])

                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">email <span class="text-danger">*</span></label>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email', $customer->email) }}" required>
                                <small id="emailHelpBlock" class="form-text text-muted">This email will be used to send
                                    you important updates</small>
                                @include('errors.span_error', ['errorField' =>'email'])

                            </div>


                            <div class="col-md-6">
                                <label for="phone" class="form-label">phone <span class="text-danger">*</span></label>
                                <input id="phone" oninput="validateNumber(this)" type="text"
                                       class="form-control @error('phone') is-invalid @enderror" maxlength="11"
                                       name="phone"
                                       value="{{ old('phone', $customer->phone) }}" required>
                                @include('errors.span_error', ['errorField' =>'phone'])


                            </div>

                            <div class="col-12">
                                <label for="password" class="form-label">change password</label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       value="{{ old('password') }}" required>
                                @include('errors.span_error', ['errorField' => 'password'])
                            </div>


                            <div class="col-md-6">
                                <label for="house_number" class="form-label text-capitalize">house Number <span
                                            class="text-danger">*</span></label>
                                <input id="house_number" type="text"
                                       class="form-control @error('house_number') is-invalid @enderror"
                                       name="house_number" value="{{ old('house_number', $customer->house_number) }}"
                                       required>
                                @include('errors.span_error', ['errorField' => 'house_number'])
                            </div>


                            <div class="col-12">
                                <label for="street_address" class="form-label text-capitalize">Street Address <span
                                            class="text-danger">*</span></label>
                                <input id="street_address" type="text"
                                       class="form-control @error('street_address') is-invalid @enderror"
                                       name="street_address" value="{{ old('street_address', $customer->street) }}"
                                       required>
                                @include('errors.span_error', ['errorField' => 'street_address'])

                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label text-capitalize">City <span
                                            class="text-danger">*</span></label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                       name="city" value="{{ old('city', $customer->city) }}" required>
                                @include('errors.span_error', ['errorField' => 'city'])

                            </div>

                            <div class="col-md-6">
                                <label for="postcode" class="form-label text-capitalize">Postcode <span
                                            class="text-danger">*</span></label>
                                <input id="postcode" type="text"
                                       class="form-control @error('postcode') is-invalid @enderror" name="postcode"
                                       value="{{ old('postcode', $customer->postcode) }}" required>
                                @include('errors.span_error', ['errorField' => 'postcode'])

                            </div>
                            <div class="mb-3">
                                <input type="hidden" id="customerPassportImage" value="data:image/png;base64,{{ chunk_split(base64_encode($customer->passport_image)) }}">
                                <div class="col-md-6" style="display: none" id="imageDiv">
                                    <img class="img-fluid img-rounded"
                                         id="customerImage"
                                         alt="customer passport image"
                                         height="100" width="100">
                                </div>
                                <label for="passport_image" class="form-label">Passport Image</label>
                                <input class="form-control" type="file" id="passport_image" name="passport_image" accept="image/jpeg, image/png, image/jpg">

                            </div>


                            <div class="col-12">
                                <button type="submit" class="btn btn-success text-capitalize">update customer details
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('scripts')
    <script  src="{{ asset('js/show_passport_live_preview.js') }}"></script>
@endsection
