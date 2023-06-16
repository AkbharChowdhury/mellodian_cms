@if ($errors->any())
    <div class="alert alert-danger mt-3" role="alert">
        <h4 class="alert-heading">whoops something went wrong!</h4>
        <p>this form contains the following errors:</p>
        <hr>
        @foreach ($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
        @endforeach
    </div>
@endif
