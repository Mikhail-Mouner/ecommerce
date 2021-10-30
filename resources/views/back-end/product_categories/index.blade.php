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
                <a href="{{ route('backend.product_categories.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Products Count</th>
                        <th>Status</th>
                        <th>Parent</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->products_count }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->parent->name??NULL }}</td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>{{ $item->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('backend.product_categories.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                <a href="{{ route('backend.product_categories.destroy',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
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
                            {{ $categories->links() }}
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
