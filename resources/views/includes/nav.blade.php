<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container" style="max-width: 90%">
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button> --}}

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Strona główna</a>
                </li>
            </ul>

            <!-- Middle Navbar -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link nav-link-active mr-4" href="/masazysci">Ogłoszenia masażystów</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-4" href="#">Ogłoszenia klientów</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Dyskusje</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto p-2 px-4" style="background-color:#7cd4fa">
                @guest
                    <li class="nav-item">
                        <a class="nav-link mr-4" href="{{ route('register') }}">{{ __('Zarejestruj się') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Zaloguj się') }}</a>
                    </li>
                @else
{{--                     <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li> --}}
                    <li class="nav-item d-flex px-2">
                        <a class="my-auto"><i style="color: #63326E" class="fas fa-bell"></i></a>
                    </li>
                    <li class="nav-item d-flex px-2">
                        <listen-for-messages csrf={{ csrf_token() }} :user-data="{{ Auth::user() }}"></listen-for-messages>
                    </li>

                    <li class="nav-item ml-1 mr-1" style="line-height: 30px">
                        @if (Auth::user()->role==0)
                            <a href="/masazysta/profil" class="nav-link">{{ Auth::user()->name }}</a>
                        @elseif(Auth::user()->role==1)
                            <a href="/klient/profil" class="nav-link">{{ Auth::user()->name }}</a>
                        @endif
                    </li>
                    <li class="nav-item pl-1 pr-1">
                        <img class="rounded-circle avatar" width="50" height="50" src="/storage/avatars/{{ Auth::user()->profile_img }}">
                    </li>
                    <li class="nav-item" style="line-height: 30px">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">Wyloguj</a>
                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@guest
<sidebar csrf={{ csrf_token() }} :user-data="{}"></sidebar>
@else
<sidebar csrf={{ csrf_token() }} :user-data="{{ Auth::user() }}"></sidebar>
@endguest
