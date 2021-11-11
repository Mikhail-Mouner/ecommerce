@extends('back-end.layouts.app')
@section('title','| Product Review')
@section('style')
    <style>
    </style>
@endsection
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Review</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-eye"></i> Product Review</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.product_reviews.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    @if($product_review->product->firstMedia != NULL)
                        <img src="{{ asset("/assets/products/{$product_review->product->firstMedia->file_name}") }}"
                             class="img-fluid rounded-top d-block m-auto" alt="{{ $product_review->product->name }}"
                             style="max-height: 300px">
                        <br />
                    @endif
                    <h3 class="text-center text-primary"><span
                                class="text-gray-600 h5">Product :</span> {{ $product_review->product->name }}</h3>
                    <hr />
                </div>
                <div class="col-sm-12 col-md-8">
                    <h5 class="text-gray-600">User:</h5>
                    <p>
                        {{ $product_review->name." | Email: ".$product_review->email }}
                        <br />
                        <small>{{ $product_review->user->id? $product_review->user->full_name : '' }}</small>
                    </p>
                    <hr />
                    <h5 class="text-gray-600">Title:</h5>
                    <p>{{ $product_review->title }}</p>
                    <hr />
                    <h5 class="text-gray-600">Message:</h5>
                    <p>{{ $product_review->message }}</p>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">
                                Status: {!! $product_review->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Inactive</span>' !!}
                            </h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">
                                Rating: <span class="badge badge-info">{{ $product_review->rating }}</span>
                            </h5>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Created At: <span
                                        class="text-dark h3">{{ $product_review->created_at?$product_review->created_at->diffForHumans():NULL }}</span>
                            </h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Updated At: <span
                                        class="text-dark h3">{{ $product_review->updated_at?$product_review->created_at->diffForHumans():NULL }}</span>
                            </h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
