@extends('back-end.layouts.app')
@section('title','| Product Reviews')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Reviews</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Product Reviews</h6>
            {{--<div class="ml-auto">
                @ability( 'admin', 'create_product_reviews' )
                <a href="{{ route('backend.product_reviews.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>--}}
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._product_coupon')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th>product</th>
                        <th>user</th>
                        <th>
                            title
                            <br />
                            message
                        </th>
                        <th>status</th>
                        <th>rating</th>
                        <th>Created At</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reviews as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>
                                {{ $item->name." | ".$item->email }}
                                <br />
                                <small>{{ $item->user->id? $item->user->full_name : '' }}</small>
                            </td>
                            <td>
                                <h5>{{ \Illuminate\Support\Str::words($item->title,2) }}</h5>
                                <h6>{{ \Illuminate\Support\Str::words($item->message,5) }}</h6>
                            </td>
                            <td>
                                {!! $item->status?'<span class="badge badge-success w-100">Active</span>':'<span class="badge badge-warning w-100">Inactive</span>' !!}
                            </td>
                            <td><span class="badge badge-info w-100">{{ $item->rating }}</span></td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>
                                @ability( 'admin', 'display_product_reviews' )
                                <a href="{{ route('backend.product_reviews.show',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-primary"><i class="fa fa-eye fa-fw"></i></span>
                                </a>
                                @endability
                                @ability( 'admin', 'update_product_reviews' )
                                <a href="{{ route('backend.product_reviews.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_product_reviews' )
                                <a href="{{ route('backend.product_reviews.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->code }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.product_reviews.destroy',$item->id) }}" method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('delete')
                                </form>
                                @endability
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-capitalize text-center text-warning font-weight-bold h4">
                                Empty
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="10">
                            <div class="float-right">
                                {!! $reviews->appends(request()->all())->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
