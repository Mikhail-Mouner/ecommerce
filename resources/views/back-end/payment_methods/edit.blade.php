@extends('back-end.layouts.app')
@section('title','| Edit Payment Method')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Cities</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-edit"></i> Cities</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.payment_method.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')

            <form action="{{ route('backend.payment_method.update',$payment_method->id) }}" method="post"
                  enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                @method('put')
                <div class="row">

                    @php
                    $form_iputs = [
                        ['label'=>'Name','prefix'=>'name','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Code','prefix'=>'code','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Driver Name','prefix'=>'driver_name','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Merchant Email','prefix'=>'merchant_email','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Username','prefix'=>'username','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Password','prefix'=>'password','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Secret','prefix'=>'secret','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Sandbox Username','prefix'=>'sandbox_username','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Sandbox Password','prefix'=>'sandbox_password','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Sandbox Secret','prefix'=>'sandbox_secret','col'=>'col-md-4','type'=>'text'],
                        ['label'=>'Sandbox','prefix'=>'sandbox','col'=>'col-md-4','type'=>'text'],
                    ];
                    @endphp
                    @foreach($form_iputs as $input)
                        <div class="{{ $input['col'] }}">
                            <div class="form-group">
                                <label for="{{ $input['prefix'] }}">{{ $input['label'] }}</label>
                                <input type="{{ $input['type'] }}" name="{{ $input['prefix'] }}" value="{{ old($input['prefix'],$payment_method->{$input['prefix']}) }}" class="form-control">
                                @error($input['prefix'])<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-4">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status',$payment_method->status) == 1 ? 'selected' : NULL }}>Active</option>
                            <option value="0" {{ old('status',$payment_method->status) == 0 ? 'selected' : NULL }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Edit Payment Method</span>
                    </button>
                </div>
            </form>


        </div>
    </div>
@endsection