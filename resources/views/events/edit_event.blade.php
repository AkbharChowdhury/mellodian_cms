@inject('helper', 'App\Models\CustomHelper')
@extends('layouts.app')
@section('title')
    edit event
@endsection

@section('content')

    <div class="container">
        <input type="hidden" id="oldDate" value="{{Request::old('event_date')}}">
        <input type="hidden" id="oldStartTime" value="{{Request::old('start_time')}}">
        <input type="hidden" id="oldEndTime" value="{{Request::old('end_time')}}">

        <input type="hidden" value="{{ date('Y-m-d', strtotime($event->event_date)) }}" id="event_date_original">
        <input type="hidden" value="{{ date('H:i', strtotime($event->start_time)) }}" id="event_start_time_original">
        <input type="hidden" value="{{ date('H:i', strtotime($event->end_time)) }}" id="event_end_time_original">


        @include('recycler.admin_breadcrumb',  ['title' =>  'Add Event','homeLink' =>  'admin.home'])

        @if (Session::has('message'))
            @include('messages.message')
        @endif

        @include('errors.form_errors')

        <div class="content">
            <div class="title m-b-md">
                edit event
            </div>
        </div>
    </div>
    <div class="container py-5">
        <form class="row g-3 text-capitalize" action="{{ route('admin.updateEvent', $event->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ $event->id }}" name="event_id">
            <div class="col-md-6">
                <label for="event_title" class="form-label text-capitalize">event title</label>
                <input type="text" class="form-control @error('event_title') is-invalid @enderror" name="event_title"
                       id="event_title" autofocus value="{{ $event->event_title }}">
                @include('errors.span_error', ['errorField' =>'event_title'])


            </div>
            <div class="col-md-6">
                <label for="event_date" class="form-label">date</label>
                <input type="text" class="form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date', $event->start_time) }}">
                @include('errors.event_date_validation')
            </div>

            <div class="col-md-6">
                <label for="start_time" class="form-label">start time</label>
                <input type="text" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time) }}">
                @include('errors.span_error', ['errorField' =>'start_time'])

            </div>

            <div class="col-md-6">
                <label for="end_time" class="form-label">end time</label>
                <input type="text" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time) }}">
                @include('errors.span_error', ['errorField' =>'end_time'])

            </div>
            <div class="col-12">
                <label for="event_description" class="form-label">Event description</label>
                <textarea class="form-control editor @error('event_description') is-invalid @enderror" id="event_description" name="event_description" rows="3">{{ old('event_description', $event->event_description) }}</textarea>
                @include('errors.span_error', ['errorField' =>'event_description'])

            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"  name="adult_supervision" id="adult_supervision"
                           value="{{   old('adult_supervision', $event->adult_supervision )   == \App\Enums\AdultSupervision::Yes ? \App\Enums\AdultSupervision::Yes : \App\Enums\AdultSupervision::No }}"
                            {{ old('adult_supervision', $event->adult_supervision ) == \App\Enums\AdultSupervision::Yes ? ' checked': ''}}
                    >
                    <label class="form-check-label" for="adult_supervision">
                        Adult Supervision
                    </label>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-dark text-capitalize">update Event</button>
            </div>
        </form>

    </div>

@endsection

@section('scripts')

    <script>
        const oldDate = document.getElementById('oldDate');
        const eventDateOriginal = document.getElementById('event_date_original').value;

        // event_date_original
        const startTimeOriginal = document.getElementById('event_start_time_original').value;
        const endTimeOriginal = document.getElementById('event_end_time_original').value;

        const oldStartTime = document.getElementById('oldStartTime');
        const oldEndTime = document.getElementById('oldEndTime');

        // const oldStartIme = document.getElementById('oldStartIme');
        flatpickr('#event_date', {
            dateFormat: 'Y-m-d', // format for database input
            enableTime: false,
            altInput: true,
            altFormat: 'l J F, Y', // used to display the date and time in a user friendly format
            defaultDate: oldDate.value == '' ?eventDateOriginal: oldDate.value,
            minDate: 'today'
        });


        let startTime = flatpickr('#start_time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "6:00",
            maxTime: "23:30",
            defaultDate: oldStartTime.value == '' ?startTimeOriginal: oldStartTime.value,
            //startTimeOriginal
            altInput: true,
            altFormat: 'h:i K',
            maxTime: '14:00',

            onChange: (selectedDates, dateStr, instance) => endTime.set('minTime', dateStr)

        });


        let endTime = flatpickr('#end_time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "6:00",
            maxTime: "23:30",
            altInput: true,
            altFormat: 'h:i K',
            defaultDate: oldEndTime.value == '' ?endTimeOriginal: oldEndTime.value,

            minTime: '13:00',
            onChange: (selectedDates, dateStr, instance) => startTime.set('maxTime', dateStr)

        });
    </script>
@endsection

