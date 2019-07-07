<nav class="navbar navbar-expand-md navbar-light">
    <div class="container" style="max-width: 90%"> 
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Strona główna</a>
                </li>
            </ul>

            <!-- Middle Navbar -->
            <ul class="navbar-nav">
                {{-- <li class="nav-item"><img width="40" height="40" src="storage/logo.png"></li> --}}
                <li class="nav-item">
                    <a class="nav-link mr-4" href="/masazysci">Ogłoszenia masażystów i fizjoterapeutów</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-4" href="#">Ogłoszenia klientów</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Dyskusje</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
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
                    <li class="nav-item">
                        <a href="/" class="nav-link">{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item pl-1">
                        <img class="rounded-circle avatar" width="50" height="50" src="/storage/avatars/Vladimir_Putin_(2017-07-08).jpg">
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
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