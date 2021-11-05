@extends('back-end.layouts.app')
@section('title','| Product')
@section('style')
    <style>
        .product-image-view {
            width: 100%;
            height: 150px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-color: #d1d3e2;
        }
    </style>
@endsection
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-eye"></i> Product</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.product.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <h3 class="text-center text-primary">{{ $product->name }}</h3>
                    <hr />
                    <div class="row">
                        @forelse($product->media as $image)
                            <div class="{{ $loop->iteration == 1?'col-md-12':'col-md-6' }}">
                                <div class="product-image-view"
                                     style="background-image: url('{{ asset("/assets/products/{$image->file_name}") }}');{{ $loop->iteration == 1?'height: 270px;':'' }}"></div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <h5 class="text-gray-600">Description:</h5>
                    <p>{{ $product->description }}</p>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Price: <span class="text-dark h3">{{ $product->price }}</span>
                            </h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Quantity: <span class="text-dark h3">{{ $product->qty }}</span>
                            </h5>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Status: {!! $product->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Inactive</span>' !!}
                            </h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Featured: {!! $product->featured?'<span class="badge badge-success">Yes</span>':'<span class="badge badge-warning">No</span>' !!}
                            </h5>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">
                                Category: {!! "<span class='badge badge-info '>{$product->category->name}</span>" !!}</h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Tags:
                                @forelse($product->tags as $tag)
                                    <span class='badge badge-secondary'>{{ $tag->name }}</span>
                                @empty
                                      -
                                @endforelse
                            </h5>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Created At: <span class="text-dark h3">{{ $product->created_at?$product->created_at->diffForHumans():NULL }}</span>
                            </h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h5 class="text-gray-600">Updated At: <span class="text-dark h3">{{ $product->updated_at?$product->created_at->diffForHumans():NULL }}</span>
                            </h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
