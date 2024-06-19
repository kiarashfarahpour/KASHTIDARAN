<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
                              
    @include('frontend.layouts.meta')
    @include('frontend.layouts.styles')
    @yield('meta')
    @yield('seo')
    @yield('styles')
<style type="text/css">
</style>
</head>
<body>
    <header>
        <nav class="site-header fixed-top">
            <div class=" container navbar navbar-expand-lg ">
                <a class="navbar-brand d-lg-none" href="#">
                    <img class="logo-mob" src="{{ asset('image/logo.png') }}" alt="لوگو کشتی داران">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fas fa-bars"></span>
                </button>
                <!--  Use flexbox utility classes to change how the child elements are justified  -->
                <div class="collapse navbar-collapse justify-content-between site-nav" id="navbarToggle">
                    <ul class="navbar-nav" style="width: 40%;">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('frontend.app.index') }}">صفحه اصلی
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.commercials.index') }}">همه آگهی ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://video.kashtidaran.com/">ویدیو دریایی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.pages.show', 'tos') }}">قوانین و پشتیبانی</a>
                        </li>
                    </ul>
                    
                    <!--   Show this only lg screens and up   -->
                    <a class="navbar-brand d-none d-lg-block" href="{{ route('frontend.app.index') }}">
                        <img class="logo" src="{{ asset('image/logo.png') }}" alt="لوگو کشتی داران">
                    </a>
                    <ul class="navbar-nav" style="width: 40%; direction: ltr;">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">عضویت</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ورود</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.my.show') }}">پنل کاربری</a>
                            </li>
                            @permission('dashboard-access')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.app.index') }}">پنل مدیریت</a>
                            </li>
                            @endpermission
                        @endguest
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#CityModal">انتخاب شهر
                                <i class="fas fa-map-marker-alt"></i>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </header>
    <!-- Modal -->
        <div class="modal fade" id="CityModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="lineModalLabel">{{ $currentCity->name ?? 'انتخاب شهر' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: 0;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ui fluid left icon input">
                            <input id="searchHomeCities" placeholder="جست‌و‌جوی سریع نام شهر..." class="form-control" type="text" onkeyup="filterHomeCities()">
                        </div>
                        <p class="pt-2">استان‌ها</p>
                            <ul id="selectedPopularCities" class="select-city">
                                @foreach($provinces as $prov)
                                    <li class="active">
                                        <a href="{{ route('frontend.provinces.show', $prov->code) }}">{{ $prov->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        <p>همه شهرها</p>
                        <ul id="selectedHomeCities" class="select-city py-4">
                            @foreach($cities as $city)
                                <li class="active">
                                    <a href="{{ route('frontend.cities.show', $city->slug) }}">{{ $city->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /modal -->
    @yield('content')
@include('frontend.layouts.footer')
@include('frontend.layouts.scripts')
@yield('scripts')
</body>
</html>
