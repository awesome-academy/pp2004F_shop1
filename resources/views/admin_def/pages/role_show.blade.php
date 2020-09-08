@extends('admin_master_def')

@section('title', '| Role Details')

@section('content')
    <div class="col-xs-12">
        <h3>Role: {{ $role->title ?? '' }}
            <span class="btn-group pull-right">
                <a href="{{ route('admin.role.index') }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Back</a>
                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                <label for="btn-brand-delete" class="btn btn-default"><i class="fa fa-trash"></i> Delete</label>
            </span>
        </h3>
        <h4 style="margin-top: 20px">Details</h4>
        <div class="box box-warning">
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200px">Title</th>
                        <td>{{ $role->title ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $role->description ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Permissions</th>
                        <td>
                            This role have {{ count(explode(',', $role->role_permission)) }} permissions in total {{ count($permissions) }}
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center">Permissions</th>
                    </tr>
                    @foreach ($permissions->where('permission_group', '') as $group)
                    <tr>
                        <th>{{ $group->title }}</th>
                        <td class="row">
                            @foreach ($permissions->where('permission_group', $group->id) as $permission)
                                @if (in_array($permission->id, explode(',', $role->role_permission)))
                                <div class="col-md-3">
                                    <i class="fa fa-check-square text-green"></i> {{ $permission->title }}
                                </div>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
