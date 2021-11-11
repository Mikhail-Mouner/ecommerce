@extends('back-end.layouts.app')
@section('title','| Supervisors')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Supervisors</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Supervisors</h6>
            <div class="ml-auto">
                @ability( 'admin', 'create_supervisor' )
                <a href="{{ route('backend.supervisor.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._supervisor')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Profile</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Permissions</th>
                        <th>Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($supervisors as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td>@if($item->user_image != NULL) <img
                                        src="{{ asset("/assets/users/{$item->user_image}") }}"
                                        class="img-fluid rounded-top d-block m-auto" alt="{{ $item->user_image }}"
                                        width="50"
                                        height="50"> @endif </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                {!! $item->status?'<span class="badge badge-success w-100">Active</span>':'<span class="badge badge-warning w-100">Inactive</span>' !!}
                            </td>
                            <td>
                                @forelse($item->permissions as $permission)
                                    {!! '<span class="badge badge-info w-100">'.$permission->display_name.'</span>' !!}
                                @empty
                                    <span class="badge badge-warning-light w-100">No Permission Found</span>
                                @endforelse
                            </td>
                            <td>
                                @ability( 'admin', 'update_supervisor' )
                                <a href="{{ route('backend.supervisor.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_supervisor' )
                                <a href="{{ route('backend.supervisor.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->full_name }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.supervisor.destroy',$item->id) }}" method="POST"
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
                                {!! $supervisors->appends(request()->all())->links() !!}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
