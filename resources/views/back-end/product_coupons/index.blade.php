@extends('back-end.layouts.app')
@section('title','| Product Coupons')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Coupons</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Product Coupons</h6>
            <div class="ml-auto">
                @ability( 'admin', 'create_product_coupons' )
                <a href="{{ route('backend.product_coupons.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._product_coupon')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>code</th>
                        <th>type</th>
                        <th>value</th>
                        <th>description</th>
                        <th>use_times</th>
                        <th>used_times</th>
                        <th>start_date</th>
                        <th>expire_date</th>
                        <th>greater_than</th>
                        <th>Created At</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($coupons as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->value }}</td>
                            <td>{{ \Illuminate\Support\Str::words($item->description,2) }}</td>
                            <td>{{ $item->use_times }}</td>
                            <td>{{ $item->used_times }}</td>
                            <td>{{ $item->start_date->diffForHumans() }}</td>
                            <td>{{ $item->expire_date->diffForHumans() }}</td>
                            <td>{{ $item->greater_than }}</td>
                            <td>
                                {!! $item->status?'<span class="badge badge-success w-100">Active</span>':'<span class="badge badge-warning w-100">Inactive</span>' !!}
                            </td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>
                                @ability( 'admin', 'update_product_coupons' )
                                <a href="{{ route('backend.product_coupons.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_product_coupons' )
                                <a href="{{ route('backend.product_coupons.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->code }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.product_coupons.destroy',$item->id) }}" method="POST"
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
                                {!! $coupons->appends(request()->all())->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
