@extends('back-end.layouts.app')
@section('title','| New Product Category')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Categories</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-plus-circle"></i> Product Categories</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.product_categories.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')

            <form action="{{ route('backend.product_categories.store') }}" method="post" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="parent_id">Parent</label>
                        <select name="parent_id" class="form-control">
                            <option value="">---</option>
                            @forelse($main_categories as $main_category)
                                <option value="{{ $main_category->id }}" {{ old('parent_id') == $main_category->id ? 'selected' : NULL }}>{{ $main_category->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('parent_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : NULL }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : NULL }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="cover">Cover</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="cover" id="category-image" class="file-input-overview">
                            <span class="form-text text-muted">Image width should be 500px x 500px</span>
                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Add Category</span>
                    </button>
                </div>
            </form>


        </div>
    </div>



@endsection
