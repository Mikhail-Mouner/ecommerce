@extends('front-end.layouts.app')

@section('title','| Register Page')
@section('content')


    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('Register') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <h2 class="h5 text-uppercase mb-4">{{ __('Register') }}</h2>
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf

                    <div class="form-group row">
                        <label for="username" class="col-md-12 col-form-label">{{ __('Username') }}</label>

                        <div class="col-md-12">
                            <input id="username" type="text"
                                   class="form-control @error('username') is-invalid @enderror"
                                   name="username" value="{{ old('username') }}" required autofocus>

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="firstname" class="col-md-12 col-form-label">{{ __('First Name') }}</label>

                        <div class="col-md-12">
                            <input id="firstname" type="text"
                                   class="form-control @error('firstname') is-invalid @enderror"
                                   name="firstname" value="{{ old('firstname') }}" required autofocus>

                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastname" class="col-md-12 col-form-label">{{ __('Last Name') }}</label>

                        <div class="col-md-12">
                            <input id="firstname" type="text"
                                   class="form-control @error('lastname') is-invalid @enderror"
                                   name="lastname" value="{{ old('lastname') }}" required autofocus>

                            @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                               class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>

                        <div class="col-md-12">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                               class="col-md-12 col-form-label">{{ __('Confirm Password') }}</label>

                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary rounded-pill ">
                                {{ __('Register') }}
                            </button>
                            <a class="btn btn-secondary rounded-pill float-right" href="{{ route('login') }}">
                                Do you have an account?
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection
