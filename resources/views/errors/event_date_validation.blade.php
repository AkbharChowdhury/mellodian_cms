@error('event_date')
<span class="invalid-feedback" role="alert">
    @if('event_date:after')
        <strong>The minimum event date must be today or after today's date</strong>
    @else
        <strong>{{ $message }}</strong>
    @endif
</span>
@enderror