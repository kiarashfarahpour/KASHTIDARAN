<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    @include('frontend.layouts.meta')
    @include('frontend.layouts.styles')
    @yield('meta')
    @yield('seo')
    @yield('styles')
</head>
<body>
@include('frontend.layouts.header')
<div id="myDiv">
    @yield('content')
    @include('frontend.layouts.footer')
</div>
@include('frontend.layouts.scripts')
@include('admin.layouts.partials.message')
@yield('scripts')
</body>
</html>
