@extends('front-end.layouts.app')

@section('title','| Login Page')
@section('content')


    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Login</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <h2 class="h5 text-uppercase mb-4">Login</h2>

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <div class="form-group row">
                        <label for="email"
                               class="col-md-12 col-form-label ">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-12">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                   name="username" value="{{ old('username') }}" required autofocus
                                   list="browsers">

                            <datalist id="browsers">
                                <option value="admin">
                                <option value="supervisor">
                                <option value="customer">
                            </datalist>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-12 col-form-label ">{{ __('Password') }}</label>

                        <div class="col-md-12">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   value="123456">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                            <a class="btn btn-secondary rounded-pill float-right" href="{{ route('register') }}">
                                Have't an account?
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>

@endsection
