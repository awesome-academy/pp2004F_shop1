@extends('admin_master_auth')

@section('title', '| Login')

@section('content')
<div class="custom-login-box">
    <div class="login-logo">
        <h4>Welcome to Administrator System of</h4>
        <a href="{{ url('/') }}">VietAnhStore</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h4 class="login-box-msg">Sign in to start your session</h4>

        <form action="../../index2.html" method="post">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email">
                <i class="fa fa-envelope-o form-control-feedback"></i>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password">
                <i class="fa fa-lock form-control-feedback"></i>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-warning btn-lg btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <div class="form-group">
            <a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Register a new membership</a>
        </div>

    </div>
    <!-- /.login-box-body -->
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/iCheck/square/yellow.css') }}">
<style>
    body.login-page {
        font-size: 16px;
        background-color: #282828;
    }
    .login-logo, .login-logo a {
        color: #FFF;
    }
    .custom-login-box {
        width: 480px;
        margin: 8% auto;
        color: #ccc;
    }
    .login-box-body {
        background: #1c1c1c;
        color: #ccc;
    }
    form + div {
        margin-top: 20px;
    }
    [class*=icheckbox_square] {
        margin-right: 10px;
    }
    .login-box-body input.form-control {
        background-color: #282828;
        border: 1px solid #222;
        color: #DDD;
    }
    .login-box-body input.form-control:focus {
        background-color: #FFF;
        color: #111;
    } 
    a>i {
        margin-right: 8px;
    }
    a {
        color: #f39c12;
    }
</style>
@endpush

@push('js')
    <script src="{{ asset('vendor/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-yellow'
                , radioClass: 'iradio_square-yellow'
                , increaseArea: '20%'
            });
        });

    </script>
@endpush