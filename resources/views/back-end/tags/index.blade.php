@extends('back-end.layouts.app')
@section('title','| Tags')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tags</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-list"></i> Tags</h6>
            <div class="ml-auto">
                @ability( 'admin', 'create_tags' )
                <a href="{{ route('backend.tag.create') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-plus-circle fa-fw"></i></span>
                    <span class="text">Add</span>
                </a>
                @endability
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes.filter._tag')

            @include('back-end.includes._alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-capitalize">
                        <th width="5">#</th>
                        <th width="30">Name</th>
                        <th width="25">Products Count</th>
                        <th width="25">Status</th>
                        <th width="15">Controller</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tags as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->products_count }}</td>
                            <td>
                                {!! $item->status?'<span class="badge badge-success w-100">Active</span>':'<span class="badge badge-warning w-100">Inactive</span>' !!}
                            </td>
                            <td>
                                @ability( 'admin', 'update_tags' )
                                <a href="{{ route('backend.tag.edit',$item->id) }}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-success"><i class="fa fa-edit fa-fw"></i></span>
                                </a>
                                @endability

                                @ability( 'admin', 'delete_tags' )
                                <a href="{{ route('backend.tag.destroy',$item->id) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure to remove ({{ $item->name }})? ')){document.getElementById('{{ "delete-data{$item->id}" }}').submit();}"
                                   class="btn btn-link btn-sm">
                                    <span class="icon text-danger"><i class="fa fa-trash fa-fw"></i></span>
                                </a>
                                <form id="{{ "delete-data{$item->id}" }}"
                                      action="{{ route('backend.tag.destroy',$item->id) }}" method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('delete')
                                </form>
                                @endability
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-capitalize text-center text-warning font-weight-bold h4">
                                Empty
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="6">
                            <div class="float-right">
                                {!! $tags->appends(request()->all())->links() !!}
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