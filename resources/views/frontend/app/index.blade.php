@extends('frontend.layouts.blank')
@section('scripts')
<script src="/js/select2.min.js" type="text/javascript"></script>
<script>

	$('.custom-select').select2({
        theme: 'bootstrap4',
        placeholder: 'انتخاب شهر'
    });
    $('#citiesList').on("change", function (e) {
        var cityUrl = $(this).val();
        window.location.replace(cityUrl);
    });
    $('#search-number').on('keydown', function() {
        $('#search-phrase').val('');
    });
    $('#search-phrase').on('keydown', function() {
        $('#search-number').val('');
    });
</script>
@endsection
@section('seo')
    <meta name="keywords" content="{{ $settings['meta_keywords'] }}">
    <meta name="description" content="کشتی داران - مرجع اصلی نیازمندیهای رایگان و خرید فروش کالای دریایی نو و دسته دوم- نیازمندی های شناور و تجهیزات دریایی- کاریابی و استخدام">
    <meta name="og:title" content="{{ $settings['title'] }}">
    <meta name="og:description" content="{{ $settings['meta_description'] }}">
@endsection
@section('content')

    <style>
        @media (max-width: 575px){
            .mgt-65{
                margin-top: 65px !important;
            }
        }
    </style>

    <main role="main">
        <section class="position-relative pt-7">
            <div class="position-absolute jarallax bg-gradient w-100" style="top: 0; left: 0; height: 600px;" data-jarallax data-speed="0.25">
                <span class="bg-overlay bg-gradient"></span>
                <div class="jarallax-img" style="background-image: url('image/OIFO250.jpg');"></div>
                <div class="cs-shape cs-shape-bottom cs-shape-curve-side bg-body">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor">
                        <path d="M145,14H0V1H145ZM0,1S32,11,73,14,145,1,145,1"></path>
                    </svg>
                </div>
            </div>
            <div class="container bg-overlay-content pt-lg-7">
                <div class="row justify-content-center pt-4 text-white">
                    <div class="col-xl-9 col-lg-10 text-center" style="margin-top: 5.4rem">
                        <h1 class="page-header-title">{{ $site_settings['title'] }}</h1>
                        <p class="page-header-text mb-5 d-none d-sm-block">{{ $site_settings['slogan'] }}</p>
                    </div>
                    <div class="col-xl-10 col-lg-10 text-center py-3">
                        <form method="post" action="{{ route('frontend.search.process') }}" class="search-form d-none d-md-block">
                            @csrf
                            <div class="input-group mb-3 ">
                                <!-- <div class="input-group-prepend ">   -->
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" class="form-control sa border-left" name="search-phrase" placeholder="جست و جو در همه آگهی ها">
                                <!-- </div> -->
                                <i class="fas fa-hashtag hashtag-icon"></i>
                                <input type="text" class="form-control" name="search-number" placeholder="جست و جو با شماره آگهی">
                                <button class="btn btn-orange" type="submit">جست و جو</button> <!--kf-->
                            </div>
                        </form>
                        <form method="post" action="{{ route('frontend.search.process') }}" class="d-block d-sm-none ">
                            @csrf
                            <div class="search-box-mob">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search-number" name="search-number" placeholder="جست و جو با شماره آگهی">
                                    <div class="input-group-addon btn-search-mob">
                                        <button type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="search-box-mob">
                                <div class="input-group">
                                    <input class="form-control" id="search-terms" name="search-phrase" placeholder="جست و جو در همه آگهی ها">
                                    <div class="input-group-addon btn-search-mob">
                                        <button type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-9 col-lg-10 text-center">
                        <a href="{{ route('frontend.commercials.new', ['city' => $currentCity->name ?? 'tehran']) }}" class="btn btn-orange btn-nav">
                            ثبت آگهی رایگان
                        </a>
                        <a href="https://plus.kashtidaran.com/" class="btn btn-orange btn-nav">
                            کشتی داران پلاس                         </a>
                        <a href="{{ route('frontend.weather.index') }}" class="btn btn-orange btn-nav">
                            هواشناسی دریایی
                        </a>
                    </div>

                </div>
            </div>
        </section>
        <div class="services py-0 py-sm-5">
            <div class="container">
                <div class="owl-carousel owl-theme owl-sug">
                    @foreach($categories as $category)
                        <div class="item">
                            <div class="s-card">
                                <div class="card-body">
                                    <div class="blue-circle">
                                        <a href="{{ route('frontend.cities.category', ['city' => $currentCity->name ?? 'all', 'category' => $category->slug]) }}">
                                            <img class="rounded-circle" src="{{ asset($category->image->name ?? 'image/ship.png') }}" style="width: 100px;" alt="{{ $category->name }}">
                                        </a>
                                    </div>
                                    <a class="relative" href="{{ route('frontend.cities.category', ['city' => $currentCity->name ?? 'all', 'category' => $category->slug]) }}">{{ $category->name }}</a>
                                    <div class="orange-bottom"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <section class=" mt-2 product mgt-65">
            <div class="container">
                <div class="divided">
                    <h2>آخرین آگهی‌ها</h2>
                    <span class="divider"></span>
                    <span>
                        <a href="{{ route('frontend.commercials.index') }}" class="hvr-icon-back">مشاهده بیشتر
                            <i class="fa fa-chevron-left  hvr-icon"></i>
                        </a>
                    </span>
                </div>
                <div class="row" style="direction: ltr">
                    <div class="owl-carousel owl-theme owl-sug">
                        @include('frontend.partials.commercials', ['commercials' => $latestCommercials])
                    </div>
                </div>
            </div>
        </section>
        <section class=" mt-2 product">
            <div class="container">
                <div class="divided">
                    <h2>فوری</h2>
                    <span class="divider"></span>
                    <span>
                        <a href="{{ route('frontend.commercials.index') }}" class="hvr-icon-back">مشاهده بیشتر
                            <i class="fa fa-chevron-left  hvr-icon"></i>
                        </a>
                    </span>
                </div>
                <div class="row" style="direction: ltr">
                    <div class="owl-carousel owl-theme owl-sug">
                        @include('frontend.partials.commercials', ['commercials' => $immediateCommercials])
                    </div>
                </div>
            </div>
        </section>
        <section class=" mt-2 product">
            <div class="container">
                <div class="divided">
                    <h2>کارشناسی شده</h2>
                    <span class="divider"></span>
                    {{--<span>
                        <a href="{{ route('frontend.commercials.index') }}" class="hvr-icon-back">مشاهده بیشتر
                            <i class="fa fa-chevron-left  hvr-icon"></i>
                        </a>
                    </span>--}}
                </div>
                <div class="row" style="direction: ltr">
                    <div class="owl-carousel owl-theme owl-sug">
                        @include('frontend.partials.commercials', ['commercials' => $expertisedCommercials])
                    </div>
                </div>
            </div>
        </section>
        @foreach($featuredCategories as $category)
        <section class=" mt-5 product">
            <div class="container">
                <div class="divided">
                    <h2>{{ $category->name }}</h2>
                    <span class="divider"></span>
                    <span>
                        <a href="{{ route('frontend.cities.category', ['city' => $currentCity->name ?? 'all', 'category' => $category->slug]) }}" class="hvr-icon-back">مشاهده بیشتر
                            <i class="fa fa-chevron-left hvr-icon"></i>
                        </a>
                    </span>
                </div>
                <div class="row" style="direction: ltr">
                    <div class="owl-carousel owl-theme owl-sug">
                        @include('frontend.partials.commercials', ['commercials' => $category->commercials])
                    </div>
                </div>
            </div>
        </section>
        @endforeach
        {{--For future usage
        <section class=" mt-2 product">
            <div class="container">
                <div class="divided">
                    <h2>آخرین آگهی‌ها</h2>
                    <span class="divider"></span>
                    <span>
                        <a href="#" class="hvr-icon-back">مشاهده بیشتر
                            <i class="fa fa-chevron-left  hvr-icon"></i>
                        </a>
                    </span>
                </div>
                <div class="row" style="direction: ltr">
                    <div class="owl-carousel owl-theme" id="#owl-sug">
                        <div class="item">
                            <div class="card h-100" href="#!">
                                <div class="ac-img">
                                    <img class="card-img-top" src="image/Layer-1.png" alt="...">
                                    <span class="r">25865</span>
                                </div>
                                <div class="card-body no-padding">
                                    <h4 class="mb-0">لنج چوبی باربری - کراچی</h4>
                                </div>
                                <div class="card-footer bg-transparent d-flex align-items-center justify-content-between">
                                    <span class="small ">
                                        <i class="fas fa-map-marker-alt"></i> قشم</span>
                                    <span class="small">
                                        <i class="far fa-clock"></i>
                                        لحظاتی پیش
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card h-100" href="#!">
                                <div class="ac-img">
                                    <img class="card-img-top" src="image/Layer-2.png" alt="...">
                                    <span class="r">25865</span>
                                </div>
                                <div class="card-body no-padding">
                                    <h4 class="mb-0">لنج چوبی باربری - کراچی</h4>
                                </div>
                                <div class="card-footer bg-transparent d-flex align-items-center justify-content-between">
                                    <span class="small ">
                                        <i class="fas fa-map-marker-alt"></i> قشم</span>
                                    <span class="small">
                                        <i class="far fa-clock"></i>
                                        لحظاتی پیش
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card h-100" href="#!">
                                <div class="ac-img">
                                    <img class="card-img-top" src="image/Rectangle-4.png" alt="...">
                                    <span class="r">25865</span>
                                </div>
                                <div class="card-body no-padding">
                                    <h4 class="mb-0">لنج چوبی باربری - کراچی</h4>
                                </div>
                                <div class="card-footer bg-transparent d-flex align-items-center justify-content-between">
                                    <span class="small ">
                                        <i class="fas fa-map-marker-alt"></i> قشم</span>
                                    <span class="small">
                                        <i class="far fa-clock"></i>
                                        لحظاتی پیش
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card  h-100" href="#!">
                                <div class="ac-img">
                                    <img class="card-img-top" src="image/Layer-3.png" alt="...">
                                    <span class="r">25865</span>
                                </div>
                                <div class="card-body no-padding">
                                    <h4 class="mb-0">لنج چوبی باربری - کراچی</h4>
                                </div>
                                <div class="card-footer bg-transparent d-flex align-items-center justify-content-between">
                                    <span class="small ">
                                        <i class="fas fa-map-marker-alt"></i> قشم</span>
                                    <span class="small">
                                        <i class="far fa-clock"></i>
                                        لحظاتی پیش
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card h-100" href="#!">
                                <div class="ac-img">
                                    <img class="card-img-top" src="image/Rectangle-4.png" alt="...">
                                    <span class="r">25865</span>
                                </div>
                                <div class="card-body no-padding">
                                    <h4 class="mb-0">لنج چوبی باربری - کراچی</h4>
                                </div>
                                <div class="card-footer bg-transparent d-flex align-items-center justify-content-between">
                                    <span class="small ">
                                        <i class="fas fa-map-marker-alt"></i> قشم</span>
                                    <span class="small">
                                        <i class="far fa-clock"></i>
                                        لحظاتی پیش
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        --}}
        @if($aboveFooter->status)
        <section class=" mt-2">
            <div class="container">
                <div class="row">
                    @foreach($aboveFooter->orderedItems as $item)
                        @if($item->image_id)
                        <div class="col-md-6 py-3">
                           <a href="{{ $item->url }}"><img class="img-fluid hvr-grow-shadow d-block rounded" src="{{ asset($item->image->name) }}" alt="{{ $item->title }}"></a>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>
    {{--
    <div class="PRT_menu-slider">
        <div class="container">
            <div class="owl-carousel owl-theme mob-sl-menu">
            @foreach($categories as $category)
            <div class="item">
                <a href="{{ route('frontend.cities.category', ['city' => $currentCity->name ?? 'all', 'category' => $category->slug]) }}">
                    <input type="radio" id="Radi-O1" name="tabs" checked>
                    <div for="Radi-O1" class="Bx-menu-sl">
                    <div class="tp-pic btn-5">
                        @if($category->image_id)
                        <img class="pic-pro" src="{{ $category->image->name }}" alt="image"/>
                        @endif
                    </div>
                    <div class="title-menu">{{ $category->name }}</div>
                </div>
                </a>
            </div>
            @endforeach
        </div>
        </div>
    </div>

    <div class="PRT_pro-slider">
        <div class="container">
            <div class="T-itle">
                <div class="row">
                    <div class="col-6 no-padding">
                        <div class="R-ight">
                            <h2>آگهی های فوری</h2>
                        </div>
                    </div>
                    <div class="col-6 no-padding">
                        <div class="L-eft">
                            <a href="#" class="See-all">مشاهده همه<i class="fas fa-angle-left"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="P-roduct-Slider">
            <div class="owl-carousel owl-theme mob-product">
                @include('frontend.partials.commercial', ['commercials' => $immediateCommercials])
            </div>
        </div>
        </div>
    </div>
    <div class="PRT_pro-slider">
        <div class="container">
            <div class="T-itle">
                <div class="row">
                    <div class="col-6 no-padding">
                        <div class="R-ight">
                            <h2>کارشناسی شده</h2>
                        </div>
                    </div>
                    <div class="col-6 no-padding">
                        <div class="L-eft">
                            <a href="#" class="See-all">مشاهده همه<i class="fas fa-angle-left"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="P-roduct-Slider">
            <div class="owl-carousel owl-theme mob-product">
                @include('frontend.partials.commercial', ['commercials' => $expertisedCommercials])
            </div>
        </div>
        </div>
    </div>--}}
@endsection
