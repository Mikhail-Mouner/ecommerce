@extends('back-end.layouts.app')
@section('title','| Product Categories')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Categories</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Product Categories</h6>
            <div class="ml-auto">
                @ability( 'admin', 'create_product_categories' )
                <a href="{{ route('backend.product_categories.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._product_category')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th width="5">#</th>
                        <th width="20">Name</th>
                        <th width="15">Cover</th>
                        <th width="10">Products Count</th>
                        <th width="10">Status</th>
                        <th width="10">Parent</th>
                        <th width="20">Created At</th>
                        <th width="5">Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>@if($item->cover != NULL) <img
                                        src="{{ asset("/assets/product_categories/{$item->cover}") }}"
                                        class="img-fluid rounded-top d-block m-auto" alt="{{ $item->name }}" width="50"
                                        height="50"> @endif </td>
                            <td>{{ $item->products_count }}</td>
                            <td>
                                {!! $item->status?'<span class="badge badge-success w-100">Active</span>':'<span class="badge badge-warning w-100">Inactive</span>' !!}
                            </td>
                            <td>{{ $item->parent->name??NULL }}</td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>
                                @ability( 'admin', 'update_product_categories' )
                                <a href="{{ route('backend.product_categories.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_product_categories' )
                                <a href="{{ route('backend.product_categories.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->name }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.product_categories.destroy',$item->id) }}" method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('delete')
                                </form>
                                @endability
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-capitalize text-center text-warning font-weight-bold h4">
                                Empty
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="8">
                            <div class="float-right">
                                {!! $categories->appends(request()->all())->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
