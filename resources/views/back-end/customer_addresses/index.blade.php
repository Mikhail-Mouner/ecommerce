@extends('back-end.layouts.app')
@section('title','| Customer Addresses')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Customer Addresses</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Customer Addresses</h6>
            <div class="ml-auto">
                @ability( 'admin', 'create_customer_address' )
                <a href="{{ route('backend.customer_address.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._customer_address')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>Customer</th>
                        <th>Title</th>
                        <th>Shipping Info</th>
                        <th>Location</th>
                        <th>Address</th>
                        <th>ZIP Code</th>
                        <th>POBox</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($customer_addresses as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('backend.customer.show',$item->user->id) }}"
                                   class="btn btn-link text-primary">{{ $item->user->full_name }}</a></td>
                            <td>
                                <a href="{{ route('backend.customer_address.show',$item->id) }}"
                                   class="btn btn-link text-primary">{{ $item->address_title }}</a>
                                {!! $item->default_address?'<span class="badge badge-success w-100">Default</span>':'' !!}
                            </td>
                            <td>
                                {{ $item->first_name." ".$item->last_name }}
                                <p class="text-gray-400">{{ $item->email." ".$item->phone }}</p>
                            </td>
                            <td>
                                {{ $item->country->name." - ".$item->state->name." - ".$item->city->name }}
                            </td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->zip_code }}</td>
                            <td>{{ $item->po_box }}</td>
                            <td>
                                @ability( 'admin', 'update_customer_address' )
                                <a href="{{ route('backend.customer_address.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_customer_address' )
                                <a href="{{ route('backend.customer_address.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->name }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.customer_address.destroy',$item->id) }}" method="POST"
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
                                {!! $customer_addresses->appends(request()->all())->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection