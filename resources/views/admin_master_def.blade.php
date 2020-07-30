<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>VAS Admin @yield('title')</title>
    @include('admin_def.layouts.head')
</head>
<body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">
        @include('admin_def.layouts.header')
        @include('admin_def.layouts.sidenav')
        <div class="content-wrapper">
            @section('content')
                <div class="col-xs-12">
                    <h1>Welcome to VietAnhStore Dashboard System!</h1>
                </div>
            @show
        </div>
        @include('admin_def.layouts.control_sidebar')
    </div>
    @include('admin_def.layouts.scripts')
</body>
</html>
