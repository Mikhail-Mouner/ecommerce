@extends('back-end.layouts.app')
@section('title','| Edit Product')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-edit"></i> Product</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.product.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')

            <form action="{{ route('backend.product.update',$product->id) }}" method="post" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name',$product->name) }}"
                                   class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status',$product->status) == 1 ? 'selected' : NULL }}>Active
                            </option>
                            <option value="0" {{ old('status',$product->status) == 0 ? 'selected' : NULL }}>Inactive
                            </option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="featured">Featured</label>
                        <select name="featured" id="featured" class="form-control">
                            <option value="1" {{ old('featured',$product->featured) == 1 ? 'selected' : NULL }}>Yes
                            </option>
                            <option value="0" {{ old('featured',$product->featured) == 0 ? 'selected' : NULL }}>No
                            </option>
                        </select>
                        @error('featured')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input type="text" name="qty" id="qty" value="{{ old('qty',$product->qty) }}"
                                   class="form-control">
                            @error('qty')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" value="{{ old('price',$product->price) }}"
                                   class="form-control">
                            @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control select-2">
                            <option value="">---</option>
                            @forelse($main_categories as $main_category)
                                <option value="{{ $main_category->id }}" {{ old('category_id',$product->product_category_id) == $main_category->id ? 'selected' : NULL }}>{{ $main_category->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-3">
                        <label for="tag_id">Tag</label>
                        <select name="tag_id[]" id="tag_id" class="form-control select-2" multiple="multiple">
                            <option value="">---</option>
                            @forelse($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id,old( 'tag_id', $product->tags->pluck('id')->toArray() ) ) ? 'selected' : NULL }}>{{ $tag->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('tag_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control summernote" name="desc" id="desc"
                                      rows="3">{!! old('desc',$product->description) !!}</textarea>
                            @error('desc')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-12">
                        <label for="product-image">Images</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="img[]" id="product-image-preview" class="file-input-overview"
                                   multiple="multiple">
                            @error('img')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Edit Product</span>
                    </button>
                </div>
            </form>


        </div>
    </div>



@endsection

@push('script')
    <script>
        $(function () {
            $("#product-image-preview").fileinput({
                theme: "fas",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @forelse( $product->media as $image)
                        "{{ asset("/assets/products/{$image->file_name}") }}",
                    @empty
                        ""
                    @endforelse
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                        @forelse( $product->media as $image)
                    {
                        caption: "{{ $image->file_name }}",
                        size: "{{ $image->file_size }}",
                        width: "120px",
                        url: "{{ route('backend.product.remove_image',['id'=>$image->id,'_token'=>csrf_token() ]) }}",
                        key: "{{ $product->id }}"
                    },
                        @empty
                    {}
                    @endforelse

                ]
            });
        });
    </script>
@endpush