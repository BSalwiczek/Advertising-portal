@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="container auth-container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-12 text-center mt-1">
            <h1 class="pb-3">Logowanie</h1>
            <hr>
            <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="form-group mt-4 align-items-center" style="font-size: 1.1em">
                    <div class="d-flex justify-content-center" style="margin-top: 3rem;">
                        {{-- <div class="mr-5">
                            <label for="email" class="col-form-label">Email</label>
                        </div>
                        <div style="min-width: 40%">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div> --}}
                        <div style="width:33%">
                            {{-- <label for="email" class="col-fo rm-label">Hasło</label> --}}
                            <label for="email" class="inp d-block">
                              <input id="password" type="email" placeholder=" " class="better-input @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" required autocomplete="email">
                                {{--  <input required type="password" id="email" class="better-input" name="email" > --}}
                                <span class="label">Email</span>
                                <span class="border-b"></span>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center" style="margin-top: 2rem;">
                        <div style="width:33%">
                            {{-- <label for="email" class="col-form-label">Hasło</label> --}}
                            <label for="email" class="inp d-block">
                              <input id="password" type="password" placeholder=" " class="better-input @error('email') is-invalid @enderror" name="password" required autocomplete="current-password">
                                {{-- <input required type="password" id="email" class="better-input" name="email" > --}}
                                <span class="label">Hasło</span>
                                <span class="border-b"></span>
                            </label>
                        </div>
                        {{-- <div style="min-width: 40%">
                            <input id="password" type="password" class="form-control @error('email') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div> --}}
                    </div>
                    @error('email')
                    <br>
                        <span class="error">Logowanie nie powiodło się! Sprawdz czy dobrze wpisałeś email i hasło.</span>
                    @enderror
                    <div class="align-items-center" style="margin-top: 3rem;">
                      Nie masz jeszcze konta? Kliknij <a href="/register">tutaj</a> aby je założyć
                    </div>
                    <div class="align-items-center" style="margin-top: 3rem;">
                        <button class="btn btn-first mx-auto" style="width: 30%;font-size: 1.4em">
                            Zaloguj się!
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
