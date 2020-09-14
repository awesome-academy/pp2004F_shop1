@extends('frontpage_master_def')

@section('title', '| Edit Profile')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>My Account</li>
                <li class="active">Edit Profile</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!--Checkout Area Strat-->
<div class="checkout-area pt-60 pb-30">
    <div class="container">
        <div class="row">
            @include('frontpage_def.layouts.user_sidenav')
            <div class="col-lg-8 col-md-9 col-12 user-account-right">
                <span class="page-title bg-warning text-white">Edit Profile</span>
                <form action="{{ route('user.account.update', $user->id) }}" method="POST" class="form-vertical pt-40">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row align-items-center">
                        <label for="" class="col-form-label col-4"><strong>First Name</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="" class="col-form-label col-4"><strong>Last Name</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-form-label col-4"><strong>Avatar</strong></label>
                        <div class="col-8">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-light">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </div>
                                <input id="thumbnail" class="form-control" type="text" name="image" readonly
                                    @if(!empty(old('image'))) value="{{ old('image') }}" @endif>
                            </div>
                            <div id="holder" style="margin-top:15px; max-height:100px;">
                                @if(!empty(old('image'))) <img src="{{ old('image') }}" style="height: 6rem"> @endif
                            </div>
                            @error('image')
                            <div class="help-block">
                                {{ $errors->first('image') }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="" class="col-form-label col-4"><strong>Phone</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="" class="col-form-label col-4"><strong>Primary Address</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="address1" value="{{ $user->address1 ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="" class="col-form-label col-4"><strong>Secondary Address</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="address2" value="{{ $user->address2 ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="" class="col-form-label col-4"><strong>City</strong></label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="city" value="{{ $user->city ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="" class="col-form-label col-4"></label>
                        <button type="submit" class="btn-cart ml-15">Update Profile</button>
                        <a href="javascript: history.back()" class="btn-cart ml-15">&times; Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Checkout Area End-->
@endsection

@push('styles')
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/72px color.png') }}">
@endpush

@push('js')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script>
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
    </script>
     <script>
        var route_prefix = "/filemanager";
        $('#lfm').filemanager('image', {prefix: route_prefix});
    </script>
@endpush
