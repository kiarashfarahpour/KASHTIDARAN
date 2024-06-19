<header class="box-shadow-sm">
    <!-- Topbar-->
    <div class="topbar topbar-dark">
        <div class="container nav-container">
            <div class="topbar-text text-nowrap float-left">
                <button class="topbar-link" style="font-size:12px;padding: 0px;background-color: transparent;border: 1px solid transparent;line-height: 1.5;border-radius: .25rem;" data-toggle="modal" data-target="#educationModal"><i class="fas fa-graduation-cap"></i> آموزش</button>
				<a class="topbar-link mr-4" href="http://shipsowners.com/">
                    <i class="fas fa-anchor"></i>
                    فروشگاه
                </a>
                <a class="topbar-link mr-4" href="{{ route('frontend.weather.index') }}">
                    <i class="fas fa-cloud-sun"></i>
                    هواشناسی
                </a>
            </div>
            <div class="ml-3 text-nowrap d-sm-none d-md-block float-right">
                <a class="topbar-link ml-4 d-none d-md-inline-block" href="{{ route('frontend.app.index') }}">
                    <i class="czi-location"></i>
                    صفحه اصلی
                </a>
                <a class="topbar-link ml-4 d-none d-md-inline-block" href="{{ route('frontend.commercials.index') }}">
                    <i class="czi-location"></i>
                    همه آگهی ها
                </a>
                <a class="topbar-link ml-4 d-none d-md-inline-block" href="https://mag.kashtidaran.com/">
                    <i class="czi-location"></i>
                    مجله دریایی
                </a>
            </div>
        </div>
    </div>
    <!-- middle row -->
    <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
    <div class="navbar-sticky ">
        <div class="navbar navbar-expand-lg navbar-light py-3">
            <div class="container nav-container">
                <a class="navbar-brand d-none d-sm-block mr-3 flex-shrink-0" href="{{ route('frontend.app.index') }}" style="min-width: 7rem;">
                    <img width="142" src="{{ asset('logo.jpg') }}" alt="لوگو کشتی داران">
                </a>
                <a class="navbar-brand d-sm-none mr-2" href="{{ route('frontend.app.index') }}" style="min-width: 4.625rem;">
                    <img width="60" src="{{ asset('logo.jpg') }}" alt="لوگو کشتی داران">
                </a>
                <form method="post" action="{{ route('frontend.search.process') }}">
                    @csrf
                    <div class="input-group-overlay d-none d-lg-flex mx-4">
                    
                        
                        <i class="fas fa-search search-input-icon  mr-2"></i>
                        <input name="search-phrase" class="form-control appended-form-control search-input" type="text" placeholder="جستجو در همه آگهی‌ها">
						<i class="fas fa-hashtag search-input-icon mr-2"></i>
                        <input name="search-number" class="form-control appended-form-control search-input" type="text" placeholder="جستجو با شماره آگهی">
                        <button type="submit" class="btn mr-2 ml-5 btn-search">جستجو</button>
                    
                    </div>
                </form>
                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                    <div class="navbar-tool ml-1 ml-lg-0 mr-n1 mr-lg-2">
                        <div class="navbar-tool-text dropdown">
                            @guest
                                <button class="border-0 bg-white dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="far fa-user-circle" style="font-size: 20px;vertical-align: -4px; color: #dae2f3;"></i>
                                    ورود/ عضویت
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <a class="dropdown-item small" href="{{ route('login') }}">ورود</a>
                                    <a class="dropdown-item small" href="{{ route('register') }}">ثبت نام</a>
                                </div>
                            @else
                                <button class="border-0 bg-white dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="far fa-user-circle" style="font-size: 20px;vertical-align: -4px;color: #dae2f3;"></i>
                                    {{ auth()->user()->name }}
                                </button>
                                <div class="dropdown-menu text-right" aria-labelledby="dropdownMenu2">
                                    @permission('dashboard-access')
                                    <a class="dropdown-item small" href="{{ route('admin.app.index') }}">پنل مدیریت</a>
                                    @endpermission
                                    <a class="dropdown-item small" href="{{ route('frontend.my.show') }}">پنل کاربری</a>
                                    <a class="dropdown-item small" href="{{ route('frontend.tickets.index') }}">تیکت‌ها</a>
                                    <a class="dropdown-item small" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="d-none;">
                                        @csrf
                                    </form>
                                </div>
                            @endguest
                        </div>
                    </div>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Header-bottom -->
        <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-2 pb-2 " id="Primary-menu">
            <div class="container nav-container">
                <div class="navbar-collapse collapse" id="navbarCollapse" style="font-size: 14px;">
                    <!-- Search-->
                    <form method="post" action="{{ route('frontend.search.process') }}">
                        <div class="input-group-overlay d-lg-none my-3">
                            @csrf
                            <div class="input-group-prepend-overlay">
                            </div>
                            <input name="search-phrase" class="form-control prepended-form-control" type="text" placeholder="جستجو در همه آگهی‌ها">
                        
                        </div>
                    </form>
                    <!-- Primary menu-->
                    <ul class="navbar-nav ">
                        <li class="nav-item  active border-left-f">
                            <a class="nav-link ml-3" href="{{ route('frontend.app.index') }}">خانه</a>
                        </li>
                        @foreach($mainCategories as $cat)
                        <li class="nav-item border-left-f">
                            <a class="nav-link mx-3" href="{{ route('frontend.cities.category', ['city' => $currentCity->slug ?? 'all', 'category' => $cat->slug]) }}">{{ $cat->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <ul class="navbar-nav d-sm-block d-md-none">
                        <li class="nav-item border-left-f">
                            <a class="nav-link mx-3" href="{{ route('frontend.app.index') }}">
                                صفحه اصلی
                            </a>
                        </li>
                        <li class="nav-item border-left-f">
                            <a class="nav-link mx-3" href="{{ route('frontend.commercials.index') }}">
                                همه آگهی ها
                            </a>
                        </li>
                        <li class="nav-item border-left-f">
                            <a class="nav-link mx-3" href="video.kashtidaran.com">
                                ویدیو دریایی
                            </a>
                        </li>
                        <li class="nav-item border-left-f">
                            <a class="nav-link mx-3" href="{{ route('frontend.blog.index') }}">
                               برچسب ها
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex justify-content-center my-0 mx-auto">
                    <div class="menu-btn" data-toggle="modal" data-target="#CityModal">
                        <div class="city-btn-text">
                            <span>انتخاب شهر</span>
                        </div>
                        <div class=" city-btn-icon">
                            <i class="fas fa-sort-down"></i>
                        </div>
                    </div>
                    <a href="{{ route('frontend.commercials.new', ['city' => $currentCity->slug ?? 'tehran']) }}" class="menu-btn">
                        <div class="ac-btn-text-orange">
                            <span>ثبت آگهی رایگان</span>
                        </div>
                        <div class="ac-btn-icon-orange">
                            <i class="fa fa-plus"></i>
                        </div>
                    </a>
                </div>
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
            </div>
        </div>
        <!-- /Header-bottom -->
    </div>
</header>
 <div class="modal fade" id="educationModal" tabindex="-1" role="dialog" aria-labelledby="educationModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationModalLabel">آموزش</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-right">
                    <div id="12498072777"><script type="text/JavaScript" src="https://www.aparat.com/embed/zhv6k?data[rnddiv]=12498072777&data[responsive]=yes"></script></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">بستن</button>
                     <!--<button id="getCommercialContact" type="button" class="btn btn-primary movafegh">با
                        قوانین موافقم
                    </button> -->
                </div>
            </div>
        </div>
    </div>