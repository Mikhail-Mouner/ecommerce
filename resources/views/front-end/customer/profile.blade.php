@extends('front-end.layouts.app')
@section('content')

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ auth()->user()->full_name }}</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div </div>
            </div>
    </section>
    <section class="py-5">
        <div class="row">
            <div class="col-md-8">
                <h2 class="h5 text-uppercase mb-4">Profile</h2>
                <form action="{{ route('frontend.customer.update_profile') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            @if (auth()->user()->user_image != 'user.png')
                                <img src="{{ asset('/assets/users/' . auth()->user()->user_image) }}"
                                    class="img-fluid rounded-top d-block m-auto" alt="{{ auth()->user()->fullname }}" 
                                    width="150" height="150"/>
                                <div class="mt-2">
                                    <a href="{{ route('frontend.customer.profile.remove_image') }}" class="btn btn-outline-danger">
                                        Remove Image
                                    </a>
                                </div>
                            @else
                                <img src="{{ asset('/assets/users/user.png') }}"
                                    alt="user-image"
                                    width="150" height="150" />
                            @endif
                        </div>
                        @php
                            $form_inputs = [
                                ['label'=>'First Name','prefix'=>'first_name','value'=>old('first_name',auth()->user()->first_name),'type'=>'text','col'=>'col-md-6'],
                                ['label'=>'Last Name','prefix'=>'last_name','value'=>old('last_name',auth()->user()->last_name),'type'=>'text','col'=>'col-md-6'],
                                ['label'=>'Email Address','prefix'=>'email','value'=>old('email',auth()->user()->email),'type'=>'email','col'=>'col-md-6'],
                                ['label'=>'Mobile','prefix'=>'phone','value'=>old('phone',auth()->user()->phone),'type'=>'tel','col'=>'col-md-6'],
                                ['label'=>'New Password','prefix'=>'password','value'=>old('password'),'type'=>'password','col'=>'col-md-6'],
                                ['label'=>'Re-Password','prefix'=>'password_confirmation','value'=>old('password_confirmation'),'type'=>'password','col'=>'col-md-6'],
                                ['label'=>'New Image','prefix'=>'user_image','value'=>old('user_image',auth()->user()->user_image),'type'=>'file','col'=>'col-md-12'],
                            ];
                        @endphp
                        @foreach ($form_inputs as $input)                            
                            <div class="{{ $input['col'] }}">
                                <div class="form-group">
                                    <label class="text-uppercase d-flex text-small" for="{{ $input['prefix'] }}">{{ $input['label'] }}</label>
                                    <input type="{{ $input['type'] }}"
                                    class="form-control" name="{{ $input['prefix'] }}" id="{{ $input['prefix'] }}" value="{{ $input['value'] }}" />
                                    @error($input['prefix']) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Update Profile</button>
                        </div>
                        
                    </div>
                </form>

            </div>
            <div class="col-md-4">
                @include('front-end.includes.customer._sidebar')
            </div>
        </div>
    </section>
@endsection
