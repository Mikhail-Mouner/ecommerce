@extends('back-end.layouts.app')
@section('title','| Product')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Products</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Products</h6>
            <div class="ml-auto">
                @ability( 'admin', 'create_products' )
                <a href="{{ route('backend.product.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._product')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Tags</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Created At</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($item->firstMedia != NULL)
                                    <img src="{{ asset("/assets/products/{$item->firstMedia->file_name}") }}"
                                         class="img-fluid rounded-top d-block m-auto" alt="{{ $item->name }}" width="50"
                                         height="50">
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ \Str::words($item->description,3) }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{!! "<span class='badge badge-info w-100'>{$item->category->name}</span>" !!}</td>
                            <td>
                                @forelse($item->tags as $tag)
                                    <span class='badge badge-secondary w-100'>{{ $tag->name }}</span>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>
                                {!! $item->status?'<span class="badge badge-success w-100">Active</span>':'<span class="badge badge-warning w-100">Inactive</span>' !!}
                            </td>
                            <td>
                                {!! $item->featured?'<span class="badge badge-success w-100">Yes</span>':'<span class="badge badge-warning w-100">No</span>' !!}
                            </td>
                            <td>{{ $item->created_at?$item->created_at->diffForHumans():NULL }}</td>
                            <td>
                                @ability( 'admin', 'display_product' )
                                <a href="{{ route('backend.product.show',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-primary"><i class="fa fa-eye fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'update_products' )
                                <a href="{{ route('backend.product.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_products' )
                                <a href="{{ route('backend.product.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->name }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.product.destroy',$item->id) }}" method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('delete')
                                </form>
                                @endability
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-capitalize text-center text-warning font-weight-bold h4">
                                Empty
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="12">
                            <div class="float-right">
                                {!! isset($request)?$products->appends($request->all())->links():$products->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
