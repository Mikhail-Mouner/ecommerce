@extends('back-end.layouts.app')
@section('title','| Edit Product Review')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Reviews</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-edit-circle"></i> Product Reviews</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.product_reviews.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')

            <form action="{{ route('backend.product_reviews.update',$product_review->id) }}" method="post"
                  enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                @method('put')
                <div class="row">

                    <div class="col-6">
                        <div class="form-group">
                            <label for="product">Code</label>
                            <input readonly name="product" id="product" value="{{ $product_review->product->name }}"
                                   class="form-control">
                            <input hidden name="product_id" id="product_id" value="{{ $product_review->product->id }}"
                                   class="form-control">
                            @error('product_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input readonly name="user" id="user" value="{{ $product_review->user->full_name }}"
                                   class="form-control">
                            <input hidden name="user_id" id="user_id" value="{{ $product_review->user->id }}"
                                   class="form-control">
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name',$product_review->name) }}"
                                   class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email',$product_review->email) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status',$product_review->status) == 1 ? 'selected' : NULL }}>
                                Active
                            </option>
                            <option value="0" {{ old('status',$product_review->status) == 0 ? 'selected' : NULL }}>
                                Inactive
                            </option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="rating">Rating</label>
                        <select name="rating" id="rating" class="form-control">
                            @for($i=1;$i<6;$i++)
                                <option value="{{ $i }}" {{ old('rating',$product_review->rating) == $i ? 'selected' : NULL }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title"
                                   value="{{ old('title',$product_review->title) }}"
                                   class="form-control">
                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control summernote" name="message" id="message"
                                      rows="3">{!! old('message',$product_review->message) !!}</textarea>
                            @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                </div>


                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Edit Review</span>
                    </button>
                </div>
            </form>


        </div>
    </div>

@endsection
