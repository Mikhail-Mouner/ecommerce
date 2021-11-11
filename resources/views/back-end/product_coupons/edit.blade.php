@extends('back-end.layouts.app')
@section('title','| Edit Product Coupon')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Coupons</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-edit-circle"></i> Product Coupons</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.product_coupons.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')

            <form action="{{ route('backend.product_coupons.update',$productCoupon->id) }}" method="post" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="code" value="{{ old('code',$productCoupon->code) }}" class="form-control">
                            @error('code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status',$productCoupon->status) == 1 ? 'selected' : NULL }}>Active</option>
                            <option value="0" {{ old('status',$productCoupon->status) == 0 ? 'selected' : NULL }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-3">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="fixed" {{ old('type',$productCoupon->type) == "fixed" ? 'selected' : NULL }}>Fixed</option>
                            <option value="percentage" {{ old('type',$productCoupon->type) == "percentage" ? 'selected' : NULL }}>
                                Percentage
                            </option>
                        </select>
                        @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>


                    <div class="col-4">
                        <div class="form-group">
                            <label for="value">Value</label>
                            <input type="text" name="value" id="value" value="{{ old('value',$productCoupon->value) }}" class="form-control">
                            @error('value')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="use_times">Use Times</label>
                            <input type="number" step="1" name="use_times" id="use_times" value="{{ old('use_times',$productCoupon->use_times) }}"
                                   class="form-control">
                            @error('use_times')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="greater_than">Greater Than</label>
                            <input type="number" name="greater_than" id="greater_than" value="{{ old('greater_than',$productCoupon->greater_than) }}"
                                   class="form-control">
                            @error('greater_than')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date',$productCoupon->start_date->format('Y-m-d')) }}"
                                   class="form-control datepicker">
                            @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="expire_date">Expire Date</label>
                            <input type="date" name="expire_date" id="expire_date" value="{{ old('expire_date',$productCoupon->expire_date->format('Y-m-d')) }}"
                                   class="form-control datepicker">
                            @error('expire_date')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control summernote" name="desc" id="desc"
                                      rows="3">{!! old('desc',$productCoupon->description) !!}</textarea>
                            @error('desc')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                </div>


                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Edit Coupon</span>
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
