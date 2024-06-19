<style>

.blinking{
    animation:blinkingText 1.2s infinite;
}
@keyframes blinkingText{
    100%{     color: #000;    }
    100%{    color: transparent; }
    100%{    color: transparent; }
    20%{    color:transparent;  }
   100%{   color: #000;    }
}

</style>

@extends('frontend.layouts.app')
@section('title', $commercial->title)
@section('seo')
    <meta name="keywords" content="{{ $commercial->meta_keywords }}">
    <meta name="description" content="{{ $commercial->meta_description }}">
    <meta name="og:title" content="{{ $commercial->title }}">
    <meta name="og:description" content="{{ $commercial->meta_description }}">
@endsection
@section('scripts')
    {{--<script>
	  	$(document).ready(function() {
		  var bigimage = $("#big");
		  var thumbs = $("#thumbs");
		  //var totalslides = 10;
		  var syncedSecondary = true;

		  bigimage
			.owlCarousel({
			items: 1,
			slideSpeed: 2000,
			nav: true,
			autoplay: false,
			rtl:true,
			dots: false,
			nav:false,
			loop: true,
			responsiveRefreshRate: 200,
			navText: [
			  '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
			  '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
			]
		  })
			.on("changed.owl.carousel", syncPosition);

		  thumbs
			.on("initialized.owl.carousel", function() {
			thumbs
			  .find(".owl-item")
			  .eq(0)
			  .addClass("current");
		  })
			.owlCarousel({
			items: 7,
			dots: false,
			nav: false,
			loop:false,

			navText: [
			  '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
			  '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
			],
			smartSpeed: 200,
			slideSpeed: 500,
			slideBy: 1,
			margin:0,
			responsiveRefreshRate: 100,
			responsive:{
                0:{
                    items:2,
                    dots:true,
                    nav:false
                },
                321:{
                    items:3,
                    dots:true,
                    nav:false
                },
                500:{
                    items:3,
                     dots:true,
                    nav:false
                },
                768:{
                    items:3,
                     dots:true,
                    nav:false
                },
                1200:{
                    items:7,
                    touchDrag: false,
                    mouseDrag: false
                }
            }
		  })
			.on("changed.owl.carousel", syncPosition2);

		  function syncPosition(el) {
			//if loop is set to false, then you have to uncomment the next line
			//var current = el.item.index;

			//to disable loop, comment this block
			var count = el.item.count - 1;
			var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

			if (current < 0) {
			  current = count;
			}
			if (current > count) {
			  current = 0;
			}
			//to this
			thumbs
			  .find(".owl-item")
			  .removeClass("current")
			  .eq(current)
			  .addClass("current");
			var onscreen = thumbs.find(".owl-item.active").length - 1;
			var start = thumbs
			.find(".owl-item.active")
			.first()
			.index();
			var end = thumbs
			.find(".owl-item.active")
			.last()
			.index();

			if (current > end) {
			  thumbs.data("owl.carousel").to(current, 100, true);
			}
			if (current < start) {
			  thumbs.data("owl.carousel").to(current - onscreen, 100, true);
			}
		  }

		  function syncPosition2(el) {
			if (syncedSecondary) {
			  var number = el.item.index;
			  bigimage.data("owl.carousel").to(number, 100, true);
			}
		  }

		  thumbs.on("click", ".owl-item", function(e) {
			e.preventDefault();
			var number = $(this).index();
			bigimage.data("owl.carousel").to(number, 300, true);
		  });
		});
    </script>--}}
    <script>
        $(document).on('click', '.replay a[href^="#"]', function (event) {
            event.preventDefault();

            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 500);
        });
    </script>
    <script>
        $(document).ready(function () {
            /**
             * Send report to moderator teams.
             *
             * @param reason id of the reason
             * @param content if there if no specific reason
             */
            function submitReport(reason, content, commercial) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('frontend.reports.store') }}",
                    data: {
                        _method: "POST",
                        reason: reason,
                        content: content,
                        commercial: commercial,
                    },
                    success: function (message) {
                        // Set sth
                        if (message.status == 'success') {
                            iziToast.success({
                                message: message.body,
                                'position': 'topLeft'
                            });
                            $('.commercialDetails').append(message.contact);
                        } else {
                            iziToast.error({
                                message: message.body,
                                'position': 'topLeft'
                            });
                        }
                    },
                    error: function (e) {
                        // Set sth
                        iziToast.error({
                            message: 'متاسفانه مشکلی در ارسال گزارش پیش آمد.',
                            'position': 'topLeft'
                        });
                    }
                });
                hideProcessing();
            }

            $('#reportReason').on('change', function () {
                if ($(this).val() == 9) {
                    $('#reportContentWrapper').removeClass('d-none');
                } else {
                    $('#reportContentWrapper').addClass('d-none');
                }
            });

            $('#submitReport').click(function () {
                var reason  = $('#reportReason').val();
                var content = $('#reportContent').val();
                var commercial = $('#commercialId').val();
                submitReport(reason, content, commercial);
            });
        });
    </script>
    @if($commercial->lat && $commercial->lng)
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBUcxNAzDyoiTXUXpLwd1a-3jOwkQpDUs&callback=loadMap&language=fa"></script>
        <script>
            function loadMap() {
                var mapOptions = {
                    center:new google.maps.LatLng({{ $commercial->lat }}, {{ $commercial->lng }}),
                    zoom:13,
                    mapTypeId:google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng({{ $commercial->lat }}, {{ $commercial->lng }}),
                    draggable:false,
                    animation: google.maps.Animation.DROP,
                    map: map,
                });
            }
            google.maps.event.addDomListener(window, 'load', loadMap);
        </script>
    @endif
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <style>
        .content {
            width: 100% !important;
            background-color: #fff !important;
        }
    </style>
@endsection
@section('content')
    <section class=" mt-4 container" id="product">
        <div class="row">
            <div class="col-md-6" id="product-gallery">
                <div id="sync1" class="owl-carousel owl-theme">
                    @foreach($commercial->images as $image)
                        <div class="item">
                            <img class="" src="{{ asset(fit($image->name, ['width' => 1100, 'height' => 1100])) }}" alt="{{ $commercial->title }}">
                            {{-- asset(image_resize($image->name, ['width' => 555, 'height' => 555])) --}}
                        </div>
                    @endforeach
                </div>
                <div id="sync2" class="owl-carousel owl-theme">
                    @foreach($commercial->images as $image)
                        <div class="item">
                            <img class="{{ $loop->first ? 'align-middle' : ''}}" src="{{ asset(image_resize($image->name, ['width' => 90, 'height' => 81])) }}" alt="{{ $commercial->title }}">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6" id="product-feature">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-3">
                        <li class="breadcrumb-item">
                            <a href="{{ route('frontend.app.index') }}">خانه</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('frontend.commercials.index') }}">آگهی</a>
                        </li>
                        @foreach($breadcrumb as $cat)
                            @if($loop->last)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('frontend.cities.category', [$commercial->city->slug, $cat['slug']]) }}">
                                        {{ $cat['name'] }}
                                    </a>
                                </li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $cat['name'] }}
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
                <h1 class="text-right mt-2 txt-blue">{{ $commercial->title }}</h1>
                <div class="location text-right mt-3 ">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $commercial->city->name }} @isset($commercial->district->name) / @endisset {{ $commercial->district->name ?? '' }}</span>
                    <span class="badge badge-primary h6">
                        آگهی کد:
                        {{ $commercial->id }}
                    </span>
                    <button id="i-am-ready" class="btn btn-success btn-sm float-left" type="button" data-com="{{ $commercial->slug }}">
                        من هستم
                    </button>
                </div>
                <div class="Responsibility  mt-3 ">
                    <span>
                        <i class="txt-red">*</i>
                      .کشتی داران هیچگونه مسئولیتی در قبال این آگهی ندارد
                    </span>
                    <br>
                    <span>
                        <i class="txt-red">*</i>
                        مشاهده شماره تماس به منزله قبول <a title="شرایط و قوانین کشتی داران" href="http://kashtidaran.com/page/tos-shipowners">شرایط و قوانین</a> کشتی داران می&zwnj;باشد.
                    </span>
                    <button style="font-size: 16px;padding: 8px 34px;border-radius: 7px;background-color: rgb(20, 115, 233);height: 40px;color: white;margin-top: 5px;border: 1px solid transparent;line-height: 1.5;" data-toggle="modal" data-target="#agreementModal"><img src="{{ asset('arrow.gif') }}" height="25px" /> شماره تماس آگهی دهنده</button>
                    <!--<button id="getCommercialContact" type="button" class="btn btn-primary movafegh">با
                        قوانین موافقم
                    </button>-->
                </div>
                
                <div class="row mx-1">
                    @foreach($commercial->fields->chunk(2) as $fields)
                        <div class="col-md-6 feature-table pl-4{{ $loop->index < 2 ? ' mt-3' : '' }}">
                        @foreach($fields as $field)
                            @if($field->pivot->value == '')
                                @continue
                            @endif
                            <div class="row feature-table-row">
                                <div class="col-6 col-right">{{ $field->name }}</div>
                                <div class="col-6">
                                    @if($field->is_price)
                                        @if($field->pivot->value && !$site_settings['noprice'])
                                            @if(ctype_digit($field->pivot->value))
                                                {{ number_format($field->pivot->value, 0) }} تومان
                                            @else
                                                {{ $field->pivot->value }}
                                            @endif
                                        @else
                                            تماس بگیرید
                                        @endif
                                    @else
                                        {{ $field->pivot->value }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="description  mt-3 ">
                    <h6 class="text-right">
                        توضیحات
                    </h6>
                    <div class="text-justify">
                        {!! nl2br($commercial->content) !!}
                    </div>
                </div>
                <div class="share mt-3">
                    <a class="float-right" data-toggle="modal" data-target="#modal-share">
                       اشتراک گذاری
                    </a>
                    <div class="bookmarkWrapper d-inline-block float-right mr-2">
                        <input type="hidden" class="commercialSlug" value="{{ $commercial->slug }}">
                        <a id="toggleBookmark" class="toggleBookmark pointer">
                            نشان کردن آگهی
                        </a>
                    </div>
                    <a class="btn btn-outline-danger text-danger px-4 btn-upload small float-left" data-toggle="modal" data-target="#modal-reports">گزارش خطا</a>
                    <div class="clearfix"></div>
                </div>
                <div class="d-flex justify-content-between share mt-3 border-top pt-3">
                    @if($next)
                    <div class="pager-button btn btn-outline-info btn-upload">
                        <a href="{{ route('frontend.commercials.show', $next->slug) }}">&rarr; بعدی</a>
                    </div>
                    @endif
                    @if($prev)
                    <div class="pager-button btn btn-outline-info btn-upload">
                        <a href="{{ route('frontend.commercials.show', $prev->slug) }}">قبلی &larr;</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @if($commercial->lat && $commercial->lng)
    <section class="container-fluid body-advert gap-col-mob">
        <div class="container gap-col gap-col-mob">
            <div class="row mt-4 row-info">
                <div class="col-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            @if($commercial->lat && $commercial->lng)
                            <a class="nav-item nav-link" id="nav-map-tab" data-toggle="tab" href="#tab-map" role="tab" aria-controls="tab-map" aria-selected="false">موقعیت مکانی</a>
                            @endif
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">

                        @if($commercial->lat && $commercial->lng)
                            <div class="tab-pane fade show" id="tab-map" role="tabpanel" aria-labelledby="nav-map-tab">
                                <div id="map" style="width:580px; height:400px;"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <section class=" mt-5 product">
        <div class="container">
            <div class="divided">
                <h2>آگهی‌های مرتبط</h2>
                <span class="divider"></span>
                <span>
                    <a href="#" class="hvr-icon-back">مشاهده بیشتر
                        <i class="fa fa-chevron-left  hvr-icon"></i>
                    </a>
                </span>
            </div>
            <div class="row" style="direction: ltr">
                <div class="owl-carousel owl-theme owl-sug">
                    @include('frontend.partials.commercials', ['commercials' => $relatedCommercials])
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="commercialSlug" value="{{ $commercial->slug }}">
    <div class="modal fade" id="modal-reports" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">بستن</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group text-right">
                        <label for="reportReason">دلیل گزارش</label>
                        <select id="reportReason" class="form-control">
                            @foreach($reportReasons as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="reportContentWrapper" class="form-group d-none">
                        <label for="reportContent">توضیحات</label>
                        <textarea id="reportContent" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <button id="submitReport" class="button-labelname btn btn-outline-primary btn-sm" data-dismiss="modal">ارسال گزارش</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">بستن</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="frmSocialShare" class="sharing-panel" aria-labelledby="SocialShare">
                        <div class="sharing-socials clearfix">
                            <span class="sharing-socials-label">اشتراک گذاری</span>
                            <ul class="item-share">
                                <li>
                                    <a class="fb" href="https://www.facebook.com/sharer/sharer.php?u={{ route('frontend.commercials.show', $commercial->slug) }}" onclick="" data-network="#" data-title="" data-image="" data-url="" title="به اشتراک گذاری در فیس بوک">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="tw" href="https://twitter.com/intent/tweet?text={{ route('frontend.commercials.show', $commercial->slug) }}" onclick="" data-network="#&quot;" data-title="" data-image="" title="به اشتراک گذاری در توییتر">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="wapp" href="https://pinterest.com/pin/create/button/?url={{ route('frontend.commercials.show', $commercial->slug) }}" onclick="" data-network="" data-title="#" data-image="" data-url="" title="به اشتراک گذاری در پینترست">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="sharing-shortlink clearfix">
                            <label for="shortlink">آدرس صفحه</label>
                            <input name="ShareUrl" value="{{ url()->current() }}" readonly dir="ltr" type="text">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="agreementModal" tabindex="-1" role="dialog" aria-labelledby="agreementModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agreementModalLabel">اطلاعات تماس</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-right">
                    <div>
                        @include('frontend.commercials.partials.contact')
                    </div>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="commercialId" value="{{ $commercial->id }}">
@endsection