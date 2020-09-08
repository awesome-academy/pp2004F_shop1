@extends('admin_master_def')

@section('title', '| Customer Details')

@section('content')
    <div class="col-xs-12">   
        <h3>Customer Details</h3>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="box box-warning">
            <div class="box-body">
                <h3 class="box-title lead"><b></b></h3>
                <div class="user-edit">
                    <form action="{{ route('admin.user.updateProfile', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error': '' }}">
                        <label for="" class="col-form-label col-4"><strong>First Name</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name ?? '' }}">
                            @error('first_name')
                                <div class="help-block">
                                    {{ $errors->first('first_name') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error': '' }}">
                        <label for="" class="col-form-label col-4"><strong>Last Name</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name ?? '' }}">
                            @error('last_name')
                                <div class="help-block">
                                    {{ $errors->first('last_name') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label col-4"><strong>Phone</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label col-4"><strong>Primary Address</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="address1" value="{{ $user->address1 ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label col-4"><strong>Secondary Address</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="address2" value="{{ $user->address2 ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label col-4"><strong>City</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="city" value="{{ $user->city ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label col-4"></label>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="javascript: history.back()" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
