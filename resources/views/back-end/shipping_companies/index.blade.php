@extends('back-end.layouts.app')
@section('title','| Shipping Companies')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Shipping Companies</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Shipping Companies</h6>
            <div class="ml-auto">
                @ability( 'admin', 'create_shipping_company' )
                <a href="{{ route('backend.shipping_company.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._shipping_company')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Fast</th>
                        <th>Cost</th>
                        <th>Status</th>
                        <th>No of Country</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($shipping_companies as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->description }}</td>

                            <td>
                                {!! $item->fast?'<span class="badge badge-info w-100">'.$item->fast_type.'</span>':'<span class="badge badge-secondary w-100">'.$item->fast_type.'</span>' !!}
                            </td>
                            <td>{{ $item->cost }}</td>
                            <td>
                                {!! $item->status?'<span class="badge badge-success w-100">Active</span>':'<span class="badge badge-warning w-100">Inactive</span>' !!}
                            </td>
                            <td>{{ $item->countries_count }}</td>
                            <td>
                                @ability( 'admin', 'update_shipping_company' )
                                <a href="{{ route('backend.shipping_company.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_shipping_company' )
                                <a href="{{ route('backend.shipping_company.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->name }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.shipping_company.destroy',$item->id) }}" method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('delete')
                                </form>
                                @endability
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-capitalize text-center text-warning font-weight-bold h4">
                                Empty
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="9">
                            <div class="float-right">
                                {!! $shipping_companies->appends(request()->all())->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection