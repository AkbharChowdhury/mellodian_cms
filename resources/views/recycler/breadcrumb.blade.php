<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href=".">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route($subLink ) }}">{{ $subtitle  }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>