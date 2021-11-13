@extends('back-end.layouts.app')
@section('title','| New Shipping Company')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Shipping Company</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-plus-circle"></i> Shipping Company</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.shipping_company.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')

            <form action="{{ route('backend.shipping_company.store') }}" method="post" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                   class="form-control">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}"
                                   class="form-control">
                            @error('code')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0" {{ old('status') == '0' ? 'selected' : NULL }}>No</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : NULL }}>Yes</option>
                            </select>
                            @error('status')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}"
                                   class="form-control">
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="number" step="any" name="cost" id="cost" value="{{ old('cost') }}"
                                   class="form-control">
                            @error('cost')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="fast">Fast Delivery</label>
                            <select name="fast" id="fast" class="form-control">
                                <option value="0" {{ old('fast') == '0' ? 'selected' : NULL }}>No</option>
                                <option value="1" {{ old('fast') == '1' ? 'selected' : NULL }}>Yes</option>
                            </select>
                            @error('fast')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="country_id">Country</label>
                            <select name="country_id[]" id="country_id" class="form-control select-2" multiple="multiple">
                                <option value=""> ---</option>
                                @forelse($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') && in_array($country->id,old('country_id'))  ? 'selected' : NULL }}>{{ $country->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('country_id')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>


                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Add Shipping Company</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function () {
            $('#code').keyup(function () {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
@endpush
