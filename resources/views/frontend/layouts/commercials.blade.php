<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    @include('frontend.layouts.meta')
    @include('frontend.layouts.styles')
    @yield('meta')
    @yield('seo')
    @yield('styles')
</head>
<body style="border-top: solid 2px orange">
@include('frontend.layouts.header')
<section class=" mt-4 container nav-container" id="archive">
    <div class="row">
        @include('frontend.partials.filters')
        @yield('content')
    </div>
</div>
@include('admin.layouts.partials.message')
@include('frontend.layouts.scripts')
@yield('scripts')
</body>
</html>
