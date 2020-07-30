<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset=" UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAS @yield('title')</title>
    @include('frontpage_def.layouts.head')
</head>
<body>
    <div class="body-wrapper">
        @include('frontpage_def.layouts.header')

        @section('content')

        @show

        @include('frontpage_def.layouts.footer')
    </div>
    @include('frontpage_def.layouts.scripts')
</body>
</html>
