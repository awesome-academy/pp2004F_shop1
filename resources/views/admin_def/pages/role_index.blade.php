@extends('admin_master_def')

@section('title', '| Role List')

@section('content')
    <div class="col-xs-12">
        <h3>Role List</h3>
        <div class="row">
            <div class="col-xs-12 col-md-9">
                <div class="box box-warning">
                    <div class="box-body">
                        <table id="table-roles" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Active</th>
                                    <th width="30%">Description</th>
                                    <th width="110px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $role->title }}</td>
                                    <td>{{ !empty($role->deleted_at) ? 'Unactive' : 'Active'}}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        @if ($role->id > 3)
                                        <a href="{{ route('admin.role.show', $role->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="box box-default">
                    <div class="box-header">
                        <p class="lead">Add New Role</p>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('admin.role.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="" class="control-label">Role Name</label>
                                <input type="text" name="title" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Description</label>
                                <textarea name="description" id="" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Add Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('lib-css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@push('lib-js')
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endpush

@push('js')
    <script>
        $('#table-brands').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'columns'     : [
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: false},
            ],
            order: [0, 'desc'],
        });
    </script>
@endpush