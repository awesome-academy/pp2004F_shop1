@extends('admin_master_def')

@section('title', '| Role Details')

@section('content')
    <div class="col-xs-12">
        <h3>Role: {{ $role->title }}
            <span class="btn-group pull-right">
            </span>
        </h3>
        <h4 style="margin-top: 20px">Details</h4>
        <div class="box box-warning">
            <div class="box-body">
                <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <table class="table table-bordered">
                        <tr>
                            <th width="200px">Title</th>
                            <th>
                                <div class="col-xs-6">
                                    <input type="text" name="title" id="" class="form-control" value="{{ $role->title ?? '' }}">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>
                                <div class="col-xs-6">
                                    <textarea type="text" name="description" id="" class="form-control"
                                        rows="3">{{ $role->description ?? '' }}</textarea>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">Permissions</th>
                        </tr>
                        @foreach ($permissions->where('permission_group', '') as $group)
                        <tr>
                            <th>{{ $group->title }}</th>
                            <td class="row">
                                @foreach ($permissions->where('permission_group', $group->id) as $permission)
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <input type="checkbox" name="permissions[{{$permission->id}}]" id="{{ $id_input = Str::random(4) }}"
                                            {{ in_array($permission->id, explode(',', $role->role_permission)) ? 'checked' : '' }}> 
                                        <label for="{{ $id_input }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update</button>
                                <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
                                <a href="{{ route('admin.role.show', $role->id) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Back</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
