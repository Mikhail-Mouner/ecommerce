@extends('back-end.layouts.app')
@section('title','| Orders')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Orders</h6>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._order')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>Ref. ID</th>
                        <th>User</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->ref_id }}</td>
                            <td>{{ $item->user->full_name }}</td>
                            <td>{{ $item->payment_method->name }}</td>
                            <td>{{ "{$item->currency} {$item->total}" }}</td>
                            <td>{!! $item->statusWithLabel() !!}</td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>
                                
                                @ability( 'admin', 'show_order' )
                                <a href="{{ route('backend.order.show',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-info"><i class="fa fa-eye fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_orders' )
                                <a href="{{ route('backend.order.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->name }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.order.destroy',$item->id) }}" method="POST"
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
                                {!! $orders->appends(request()->all())->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(function () {
            $("#category-image").fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            });
        });
    </script>
@endpush