
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top text-capitalize">
    <div class="container">
        @php
        $homepageLink = '/';
        if(!empty(Auth::guard('web')->user()->id)){
            $homepageLink = route('user.home');

        } else if(!empty(Auth::guard('admin')->user()->id)){
            $homepageLink = route('admin.home');
        }


        @endphp
      
        <a class="navbar-brand" href="{{ $homepageLink}}">


            <img src="{{ $helper->getPublicImage('logo.png') }}" alt="logo" width="50" height="50"> {{ config('app.name', 'pizzahouse') }}
          </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->

            @guest
            <ul class="navbar-nav me-auto">
                <li class="nav-item p-1">
                    <a class="nav-link {{ $helper->activeLink('events.index') }}" href="{{ route('events.index') }}">{{ __('view events') }}</a>
                </li>
               
            </ul>
            @endguest
            @auth('web')
                <ul class="navbar-nav me-auto">
                    <li class="nav-item p-1">
                        <a class="nav-link {{ $helper->activeLink('events.index') }}" href="{{ route('events.index') }}">{{ __('view events') }}</a>
                    </li>
                </ul>

                @endauth

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('user.login'))
                        <li class="nav-item">
                            <a class="nav-link {{ $helper->activeLink('login') }}" href="{{ route('user.login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    

                    @if (Route::has('user.register'))
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ $helper->activeLink('register') }}" href="{{ route('register') }}">{{ __('Register') }} </a>
                        </li> --}}
                        <button class="btn btn-success text-capitalize" onclick="window.location.href='{{ route('user.register') }}'">register</button>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>