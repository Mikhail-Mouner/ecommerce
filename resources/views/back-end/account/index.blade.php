@extends('back-end.layouts.app')
@section('title','| Profile')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Profile</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-user"></i> Profile</h6>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')


            <form action="{{ route('backend.update_profile') }}" method="post"
                  enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name"
                                   value="{{ old('first_name',auth()->user()->first_name) }}"
                                   class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name"
                                   value="{{ old('last_name',auth()->user()->last_name) }}"
                                   class="form-control">
                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username"
                                   value="{{ old('username',auth()->user()->username) }}"
                                   class="form-control">
                            @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email',auth()->user()->email) }}"
                                   class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone',auth()->user()->phone) }}"
                                   class="form-control">
                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}"
                               class="form-control">
                        @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-6">
                        <label for="password_confirmation">Confirmation Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               value="{{ old('password_confirmation') }}" class="form-control">
                        @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="user-image-image">Profile</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="user_image" id="supervisor-image-preview"
                                   class="file-input-overview">
                            <span class="form-text text-muted">Image width should be 500px x 500px</span>
                            @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Edit Profile</span>
                    </button>
                </div>
            </form>


        </div>
    </div>

@endsection

@push('script')
    <script>

        $(function () {
            $("#supervisor-image-preview").fileinput({
                theme: "fa",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                @if(auth()->user()->user_image !== NULL)
                initialPreview: [
                    "{{ asset("/assets/users/".auth()->user()->user_image) }}"
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    {
                        caption: "{{ auth()->user()->user_image }}",
                        size: '2000',
                        width: "120px",
                        url: "{{ route('backend.profile.removeImage',['_token'=>csrf_token() ]) }}",
                        key: "{{ auth()->user()->id }}"
                    }
                ]
                @endif
            });
        });
    </script>
@endpush