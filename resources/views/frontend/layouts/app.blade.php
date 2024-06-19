<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('frontend.layouts.meta')
    @include('frontend.layouts.styles')
    @yield('meta')
    @yield('seo')
    @yield('styles')
</head>
<body style="border-top: solid 2px orange">
@include('frontend.layouts.header')
@yield('content')
@include('frontend.layouts.footer')
@include('admin.layouts.partials.message')
@include('frontend.layouts.scripts')
@yield('scripts')
</body>
</html>
