@if (Session::has('message'))
    @include('messages.message-icons')
    <div class="alert alert-{{ Session::get('type') ?? 'primary' }} alert-dismissible  d-flex align-items-center fade show"
        role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
            aria-label="{{ ucfirst(Session::get('type') ?? 'info') }}:">
            <use xlink:href="#{{ Session::get('icon') ?? 'primary' }}" />
        </svg>
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
