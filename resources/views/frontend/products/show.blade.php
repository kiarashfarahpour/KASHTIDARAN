@extends('frontend.layouts.shop')
@section('title', $product->name)
@section('seo')
    <meta name="keywords" content="{{ $product->meta_keywords }}">
    <meta name="description" content="{{ $product->meta_description }}">
    <meta name="og:title" content="{{ $product->name }}">
    <meta name="og:description" content="{{ $product->meta_description }}">
@endsection
@section('styles')
    <link href="/css/mCustomScrollbar.css" rel="stylesheet" type="text/css"/>
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/fotorama.css" rel="stylesheet">
    <link href="/css/foundation.css" rel="stylesheet">
    <link href="/css/product.css" rel="stylesheet">
@endsection
@section('scripts')
    <script src="/js/foundation.min.js"></script>
    <script src="/js/fotorama.js"></script>
    <script src="/js/zoom.js"></script>
    <script>
        $('#showmenu').click(function() {
            $('.menu-item').show();
            $('#showmenu').hide();
            $('.close-box').show();
        });
        $('.close-box').click(function() {
            $('.menu-item').hide();
            $('#showmenu').show();
            $('.close-box').hide();
        });
    </script>
    <script>
        var viewportWidth = $(window).width();
        if( viewportWidth > 767 ){
            $("#zoom_01").elevateZoom({
                zoomType: "inner",
                cursor: "crosshair"
            });
        }
    </script>
    <script>
        $(function(){
            var owl = $('.thumb-product3');
            owl.owlCarousel({
                rtl:true,
                margin:10,
                loop:false,
                nav:false,
                dots:false,
                autoplay:false,
                items:4,
                touchDrag: false,
                mouseDrag: false,
                navText:['<i class="fa fa-angle-left fa-2x fa-fw" aria-hidden="true"></i>','<i class="fa fa-angle-right fa-2x fa-fw" aria-hidden="true"></i>']
            });
        });
    </script>
    <script>
        $(function() {
            var $modal = $('#myModal3');
            var fotoramaOptions = {
                nav: 'thumbs',
                width: '100%',
                maxheight: '80%',
                //transition: 'crossfade',
                keyboard: true,
                allowfullscreen: true
            }

            $('[data-reveal]').on('click', revealModal)

            $('.close-reveal-modal').on('click', function() {
                $modal.foundation('reveal', 'close');
            })

            function revealModal() {
                $modal.foundation('reveal', 'open');
            }

            $modal.bind('opened', function() {
                $('#fotorama').fotorama(fotoramaOptions);
            })
        });


        $(document).ready(function() {
            var pw = $('.fotorama__nav--thumbs').innerWidth();
            var cw = $('.fotorama__nav__shaft').innerWidth();
            var offset = pw -cw;
            var negOffset = (-1 * offset) / 2;
            var totalOffset = negOffset + 'px';
            if (pw > cw) {
                $('.fotorama__nav__shaft').css('transform', 'translate3d(' + totalOffset + ', 0, 0)');
            }
            $('.fotorama__nav__frame--thumb, .fotorama__arr, .fotorama__stage__frame, .fotorama__img, .fotorama__stage__shaft').click(function() {
                if (pw > cw) {
                    $('.fotorama__nav__shaft').css('transform', 'translate3d(' + totalOffset + ', 0, 0)');
                }
            });
        });
    </script>
    <script>
        $("body").delegate(".thumbnail", "click", function (event) {
            event.preventDefault();
            var selected = $(this);

            new_html = '<a onclick="return false;" class="thumbnail first_thumbnail" href="' + selected.attr('href') + '" title="آرد ذرت (جعبه)گلها 200 گرمی">';
            new_html += '<img id="zoom_01" src="' + selected.attr('href') + '" alt="آرد ذرت (جعبه)گلها 200 گرمی" data-zoom-image="' + selected.attr('big_image') + '"/>';
            new_html += '</a>';

            $(".first_thumbnail").parent().html(new_html);
            $(".zoomContainer").remove();

            var viewportWidth = $(window).width();
            if( viewportWidth > 767 ){
                $('#zoom_01').elevateZoom({
                    scrollZoom: true,
                    zoomWindowPosition: 10
                });
            } else if( viewportWidth < 768 ) {
                $('#zoom_01').elevateZoom({
                    zoomType: "inner",
                    cursor: "crosshair"
                });
            }
        });
    </script>
    <script>
        var heroSlider = $('.owl-related');
        var owlCarouselTimeout = 1000;
        heroSlider.on('initialize.owl.carousel initialized.owl.carousel ' +
            'initialize.owl.carousel initialize.owl.carousel ' +
            'resize.owl.carousel resized.owl.carousel ' +
            'refresh.owl.carousel refreshed.owl.carousel ' +
            'update.owl.carousel updated.owl.carousel ' +
            'drag.owl.carousel dragged.owl.carousel ' +
            'translate.owl.carousel translated.owl.carousel ' +
            'to.owl.carousel changed.owl.carousel',
            function(e) {
                $('.' + e.type)
                    .removeClass('secondary')
                    .addClass('success');
                window.setTimeout(function() {
                    $('.' + e.type)
                        .removeClass('success')
                        .addClass('secondary');
                }, 500);
            });
        $('.owl-related').owlCarousel({
            loop: false,
            autoplayHoverPause: true,
            smartSpeed:450,
            rtl:true,
            margin:20,
            navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
            lazyLoad: true,
            responsive:{
                0:{
                    items:1,
                    dots:false,
                    nav:true
                },
                500:{
                    items:3,
                    dots:true,
                    nav:false
                },
                768:{
                    items:4,
                    dots:true,
                    nav:false

                },
                1200:{
                    items:5,
                    dots:true,
                    nav:false

                }

            }
        });
        heroSlider.on('mouseleave',function(){
            heroSlider.trigger('stop.owl.autoplay');
            heroSlider.trigger('play.owl.autoplay', [owlCarouselTimeout]);
        })

    </script>
    <script>
        var heroSlider = $('.owl-sugest');
        var owlCarouselTimeout = 1000;
        heroSlider.on('initialize.owl.carousel initialized.owl.carousel ' +
            'initialize.owl.carousel initialize.owl.carousel ' +
            'resize.owl.carousel resized.owl.carousel ' +
            'refresh.owl.carousel refreshed.owl.carousel ' +
            'update.owl.carousel updated.owl.carousel ' +
            'drag.owl.carousel dragged.owl.carousel ' +
            'translate.owl.carousel translated.owl.carousel ' +
            'to.owl.carousel changed.owl.carousel',
            function(e) {
                $('.' + e.type)
                    .removeClass('secondary')
                    .addClass('success');
                window.setTimeout(function() {
                    $('.' + e.type)
                        .removeClass('success')
                        .addClass('secondary');
                }, 500);
            });
        $('.owl-sugest').owlCarousel({
            loop: false,
            autoplayHoverPause: true,
            smartSpeed:450,
            rtl:true,
            margin:20,
            navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
            lazyLoad: true,
            responsive:{
                0:{
                    items:1,
                    dots:false,
                    nav:true
                },
                500:{
                    items:2,
                    dots:true,
                    nav:false
                },
                768:{
                    items:4,
                    dots:true,
                    nav:false

                },
                1200:{
                    items:5,
                    dots:true,
                    nav:false
                }
            }
        });
        heroSlider.on('mouseleave',function(){
            heroSlider.trigger('stop.owl.autoplay');
            heroSlider.trigger('play.owl.autoplay', [owlCarouselTimeout]);
        })

    </script>
    <script>
        $("[data-toggle=popover]").each(function(i, obj) {
            $(this).popover({
                html: true,
                content: function() {
                    var id = $(this).attr('id')
                    return $('#popover-content-' + id).html();
                }
            });
        });

        $('.productOption').on('click', function () {
            var productPrice = $(this).closest('.optionWrapper').find('.optionPrice').val();
            $('#productPrice').html(productPrice);
        });
    </script>
@endsection
@section('content')
    <!--content-start-->
    {{--<div class="container gap-col gap-col-mob">
        <div class="row">
            <div class="breadcrumb col-12 gap-col gap-col-mob m-4 p-0">
                <nav class="breadcrumbs-ov">
                    <ol class="breadcrumbs">
                        <li>
                            <a class="link" itemprop="item" href="{{ url('/') }}">
                                <span>صفحه اصلی</span>
                            </a>
                        </li>
                        <li>
                            <a class="link" itemprop="item" href="{{ url('/products') }}">
                                <span>تمام محصولات</span>
                            </a>
                        </li>
                        <li>
                            <a class="link" itemprop="item" href="{{ url('/products/' . $product->slug) }}">
                                <span>{{ $product->name }}</span>
                            </a>
                        </li>
                    </ol>
                </nav>
              </div>
        </div>
    </div>--}}
    <div class="container gap-col">
        <div class="row c-product">
            <div class="col-sm-4 col-12">
                <ul class="c-gallery__options">
                    <li class="addToWishlist">
                        <input type="hidden" class="productId" value="{{ $product->id }}">
                        <i class="fa fa-heart"></i>
                    </li>
                    <li data-toggle="modal" data-target="#modal-share">
                        <i class="fa fa-share-alt"></i>
                    </li>
                    <li class="addToCompare">
                        <input type="hidden" class="productId" value="{{ $product->id }}">
                        <i class="fa fa-balance-scale"></i>
                    </li>
                </ul>
                <ul class="thumbnails">
                    <li style="position: relative;" class="big-images">
                        <a class="thumbnail first_thumbnail" href="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 280, 'height' => 251])) }}">
                            <img id="zoom_01" src="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 280, 'height' => 251])) }}" alt="{{ $product->name }}" class="img-fluid" data-zoom-image="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 800, 'height' => 600])) }}"/>
                        </a>
                    </li>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 slide-image2 ">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="owl-carousel owl-theme thumb-product3">
                                    <div class="item">
                                        <div class="thumbnail2">
                                            <button type="button" class="show-gallery icon-gallery" data-reveal>
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <a class="thumbnail" big_image="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 800, 'height' => 600])) }}" href="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 280, 'height' => 251])) }}" title="">
                                            <img src="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 280, 'height' => 251])) }}" title="" alt="{{ $product->name }}"/>
                                        </a>
                                    </div>
                                    @foreach($product->images as $image)
                                        <div class="item">
                                            <a class="thumbnail" big_image="{{ asset(\App\ImageManager::resize($image->name, ['width' => 800, 'height' => 600])) }}" href="{{ asset(\App\ImageManager::resize($image->name, ['width' => 280, 'height' => 251])) }}" title="">
                                                <img src="{{ asset(\App\ImageManager::resize($image->name, ['width' => 280, 'height' => 251])) }}" title="" alt="{{ $product->name }}"/>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="myModal3" class="reveal-modal reveal-modal--gallery">
                            <div id="fotorama" class="fotorama " data-auto="false" data-navposition="bottom" data-ratio="15/6">
                                <a big_image="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 1200, 'height' => 1000])) }}" href="" title="">
                                    <img itemprop="image" src="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 280, 'height' => 251])) }}" title="" alt="" data-zoom-image="{{ asset(\App\ImageManager::resize($product->image->name, ['width' => 1200, 'height' => 1000])) }}"/>
                                </a>
                                @foreach($product->images as $image)
                                    <a big_image="{{ asset(\App\ImageManager::resize($image->name, ['width' => 1200, 'height' => 1000])) }}" href="" title="">
                                        <img itemprop="image" src="{{ asset(\App\ImageManager::resize($image->name, ['width' => 280, 'height' => 251])) }}" title="" alt="" data-zoom-image="{{ asset(\App\ImageManager::resize($image->name, ['width' => 1200, 'height' => 1000])) }}"/>
                                    </a>
                                @endforeach
                            </div>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>
                    </div>
                </ul>
            </div>
            <div class="col-sm-8 col-12">
                <div class="row row-pro-name">
                    <div class="col-sm-8 col-12">
                        <h1 class="c-product__title">
                            {{ $product->name }}
                            <span>{{ $product->model }}</span>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-12">
                        <ul class="c-product__directory">
                            <li>
                                <span><b>برند</b></span> :
                                <a href="{{ route('frontend.manufacturers.show', $product->manufacturer->slug) }}" class="btn-link-spoiler product-brand-title">{{ $product->manufacturer->name }}</a>
                            </li>
                            <li>
                                <span><b>دسته‌بندی</b></span> :
                                @foreach($productCategories as $productCategory)
                                    <a href="{{ route('frontend.shop.categories.show', $productCategory->slug) }}" class="btn-link-spoiler">{{ $productCategory->name }}</a>
                                @endforeach
                            </li>
                        </ul>
                        @foreach($product->options as $option)
                            @if($loop->index)
                                @php break; @endphp
                            @endif
                        <div class="c-product__variants">
                            <span><b>{{ $option->option->name }}:</b> </span>
                            <ul id="productOption{{ $product->id }}" class="js-product-variants">
                                @foreach($option->optionValues as $optionValue)
                                <li class="js-c-ui-variant optionWrapper">
                                    <label  class="c-ui-variant c-ui-variant--color" data-code="#212121">
                                        @if($optionValue->image)
                                            <img src="{{ asset(\App\ImageManager::resize($optionValue->image, ['width' => 17, 'height' => 17])) }}" alt="{{ $optionValue->name }}">
                                        @endif
                                        @if($optionValue->pivot->surplus_price)
                                            <input type="hidden" class="optionPrice" value="{{ number_format($product->price + $optionValue->pivot->price, 0, '.', ',')}}">
                                        @else
                                            <input type="hidden" class="optionPrice" value="{{ number_format($product->price - $optionValue->pivot->price, 0, '.', ',')}}">
                                        @endif
                                        <input type="radio" value="{{ $optionValue->id }}" name="optionValue" class="js-variant-selector productOption">
                                        <span class="c-ui-variant__check">{{ $optionValue->name }}</span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                        @if($product->warranty)
                            <div class="c-product__guarantee">
                                <span class="c-product__guarantee-text js-guarantee-text">
                                    <i class="fas fa-shield-alt"></i>
                                    <span><b>{{ $product->warranty }}</b></span>
                                </span>
                            </div>
                        @endif
                        @if($product->giftcard)
                            <div class="c-product__guarantee">
                                <span class="c-product__guarantee-text js-guarantee-text">
                                    <i class="fas fa-credit-card"></i>
                                    <span><b>{{ $product->giftcard }}</b></span>
                                </span>
                            </div>
                        @endif
                        <div>
                            <span>کد:</span>
                            <strong>{{ $product->code }}</strong>
                        </div>
                        <div class="c-product__delivery">
                            <div class="c-product__delivery-seller">
                                <i class="fas fa-store"></i>
                                @if($product->stock)
                                <b>موجود در فروشگاه اصلی</b>
                                @else
                                 <b>   ناموجود</b>
                                @endif
                            </div>
                            {{--<div class="c-product__delivery-warehouse js-warehouse-status ">--}}
                                {{--<i class="fas fa-truck-moving"></i>--}}
                                {{--<span class="js-lead-time-prefix ">آماده</span>--}}
                                {{--ارسال--}}
                                {{--<span class="js-variant-lead-time"> از--}}
                                    {{--<span class="js-variant-lead-time-value">۲</span> روز آینده--}}
                                {{--</span>--}}
                            {{--</div>--}}
                        </div>
                        @if($product->stock)
                            @if($product->special)
                                <del class=" price_value">{{ number_format($product->price, 0) }} ریال</del><br>
                            @endif
                            <ins class="text-danger price_value">
                                <span class="c-price__currency" id="productPrice">@if($product->special) {{ $product->special }} @else {{ number_format($product->price, 0) }} @endif</span>
                                <span class="c-price__currency">ریال</span>
                            </ins>
                        <div class="c-add-to-card ajax-form">
                            <input type="hidden" class="productId" value="{{ $product->id }}">
                            <input type="hidden" class="quantity" value="1">
                            <button class="btn-add-to-cart js-add-to-cart js-btn-add-to-cart addToCart text-light">
                                <span class="icon"><i class="fa fa-cart-plus"></i></span>
                                <span class="btn-add-to-cart__txt">افــزودن به سبــد خریــد</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="detail">
                            @if($highlightAttributes)
                                <ul class="product-detail">
                                    <p>ویژگی‌های محصول</p>
                                    @foreach($showAttributes as $name => $value)
                                        <li>
                                            <span>{{ $name }}: </span>
                                            <span>{{ $value }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <div id="showmenu">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    موارد بیشتر
                                </div>
                                <div class="menu-item" style="display: none;">
                                    <ul>
                                        @foreach($hideAttributes as $name => $value)
                                            <li>
                                                <span>{{ $name }}: </span>
                                                <span>{{ $value }}</span>
                                            </li>
                                        @endforeach
                                        <p>
                                            <span class="close-box">
                                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                            بستن</span>
                                        </p>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @isset($deliveryFeatures)
                <div class="row row-feature">
                    @foreach($deliveryFeatures->orderedItems as $item)
                    <div class="c-product__feature-col">
                        <a href="{{ $item->url }}" target="_blank" class="c-product__feature-item c-product__feature-item--1" title="{!! $item->title !!}">
                            <span class="icon"><img src="{{ asset($item->image) }}" alt="{!! $item->title !!}"></span>
                            <span>{!! $item->title !!}</span>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endisset
            </div>
        </div>
        <div class="row row-tab">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#tab1default" data-toggle="tab">توضیحات</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab5default" data-toggle="tab">مشخصات فنی</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab2default" data-toggle="tab">محصولات مرتبط</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab3default" data-toggle="tab">پیشنهاد ما</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane show in active" id="tab1default">
                            <div class="description">
                                {!! $product->description !!}
                            </div>
                            @if($product->src)
                                <br>
                                <a href="{{ $product->src }}" class="text-success" target="_blank">
                                    <span class="fa fa-external-link"></span>
                                </a>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="tab5default">
                            <article>
                                <h2 class="c-params__headline">
                                    مشخصات فنی <span>{{ $product->name }}</span>
                                </h2>
                                <section>
                                    @foreach($attributes as $attribute)
                                        <h3 class="c-params__title">{{ $attribute['group'] }}</h3>
                                        <ul class="c-params__list">
                                            @foreach($attribute['attributes'] as $name => $value)
                                                <li>
                                                    <div class="c-params__list-key">
                                                        <span class="block">
                                                            {{ $name }}
                                                            {{--<a href="#" title="توضیحات" data-toggle="popover" data-trigger="hover" data-content="{{ $attribute['attrs_desc'][$name] }}" class="pull-left">--}}
                                                                {{--<span class="fa fa-question-circle text-info"></span>--}}
                                                            {{--</a>--}}
                                                        </span>
                                                    </div>
                                                    <div class="c-params__list-value">
                                                        <span class="block">{!! nl2br($value) !!}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </section>

                            </article>
                        </div>
                        <div class="tab-pane fade" id="tab2default">
                            <div class="row">
                                <div class="col-12 col-sm-12 gap-col">
                                    <div class="owl-carousel owl-theme  owl-related">
                                        @foreach($relatedProducts as $relatedProduct)
                                            <div class="item">
                                                <div class="card-body product-main-categori" href="{{ route('products.show', ['slug' => $relatedProduct->slug]) }}">
                                                    <div class="img-pro text-center">
                                                        <img src="{{ asset(\App\ImageManager::resize($relatedProduct->image, ['width' => 167, 'height' => 167])) }}" class="img-fluid">
                                                    </div>
                                                    <ul class="desc-pro">
                                                        <li>
                                                            <p class="product-name">
                                                                {{ $relatedProduct->name }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p class="model-product">
                                                                {{ $relatedProduct->model }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                              
                                                  
													<ul class="icon">
														 <li class="add-to-card ajax-form">
															<input type="hidden" class="productId" value="{{ $relatedProduct->id }}">
															<input type="hidden" class="quantity" value="1">
															<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="اضافه به سبد خرید" class="addToCart">
															<i class="fa fa-cart-plus"></i>
															</a>
														</li>
														<li class="compare-list addToCompare">
															<input type="hidden" class="productId" value="{{ $relatedProduct->id }}">
															<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="مقایسه محصول">
															<i class="fa fa-balance-scale"></i>
															</a>
														</li>
														<li class="wish-list addToWishlist">
															<input type="hidden" class="productId" value="{{ $relatedProduct->id }}">
															<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="اضافه به لیست علاقه مندی">
															<i class="fa fa-heart"></i>
															</a>
														</li>
														<li class="view">
														 <a href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}" data-toggle="tooltip" data-placement="top" title="" class="red-tooltip" data-original-title="مشاهده جزئیات محصول">
									
														 <i class="fa fa-eye"></i>
														 </a>
														</li>
													</ul>
												
											  </div>
                                            </div>
                                        @endforeach
                                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3default">
                            <div class="row">
                                <div class="col-12 col-sm-12 gap-col">
                                    <div class="owl-carousel owl-theme  owl-sugest">
                                        @foreach($suggestedProducts as $suggestedProduct)
                                        <div class="item">
                                            <div class="card-body product-main-categori">
                                                <div class="img-pro text-center">
                                                    <img src="{{ asset(\App\ImageManager::resize($suggestedProduct->image, ['width' =>  167, 'height' => 167])) }}" class="img-fluid">
                                                </div>
                                                <ul class="desc-pro">
                                                    <li>
                                                        <p class="product-name">
                                                            {{ $suggestedProduct->name }}
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p class="model-product">
                                                            {{ $suggestedProduct->model }}
                                                        </p>
                                                    </li>
                                                    
                                                    {{--<li>--}}
                                                        {{--<ul class="color-pro">--}}
                                                            {{--<li><img src="/images/color/black.png"></li>--}}
                                                            {{--<li><img src="/images/color/green.png"></li>--}}
                                                            {{--<li><img src="/images/color/red.png"></li>--}}
                                                        {{--</ul>--}}
                                                    {{--</li>--}}
                                                  <!--  <li>
                                                        <div class="btn-sale ajax-form">
                                                            <input type="hidden" class="productId" value="{{ $suggestedProduct->id }}">
                                                            <input type="hidden" class="quantity" value="1">
                                                            <button type="button" class="add-to-card addToCart form-control">
                                                                <i class="icon"></i>
                                                                اضافه به سبد خرید
                                                            </button>
                                                        </div>
                                                    </li>-->
                                                </ul>
                                             <div class="box-content">
													<h3 class="title">{{ $product->name }}</h3>
													<ul class="icon">
														 <li class="add-to-card ajax-form">
															<input type="hidden" class="productId" value="{{ $product->id }}">
															<input type="hidden" class="quantity" value="1">
															<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="اضافه به سبد خرید" class="addToCart">
															<i class="fas fa-cart-plus"></i>
															</a>
														</li>
														<li class="compare-list addToCompare">
															<input type="hidden" class="productId" value="{{ $product->id }}">
															<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="مقایسه محصول">
															<i class="fas fa-balance-scale"></i>
															</a>
														</li>
														<li class="wish-list addToWishlist">
															<input type="hidden" class="productId" value="{{ $product->id }}">
															<a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="اضافه به لیست علاقه مندی">
															<i class="fas fa-heart"></i>
															</a>
														</li>
														<li class="view">
														 <a href="{{ route('products.show', ['product' => $product->slug]) }}" data-toggle="tooltip" data-placement="top" title="" class="red-tooltip" data-original-title="مشاهده جزئیات محصول">
									
														 <i class="far fa-eye"></i>
														 </a>
														</li>
													</ul>
												</div>
											</div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
     <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

		</div>
		<div class="modal-body">
			
          <div id="frmSocialShare" class="sharing-panel" aria-labelledby="SocialShare">

              <div class="sharing-socials clearfix">
                      <span class="title-modal" class="sharing-socials-label">اشتراک گذاری</span>
                      <ul class="item-share">
                          <li><a href="" onclick="" data-network="#" data-title="" data-image="" data-url="" class="icon icon-facebook" title="به اشتراک گذاری در فیس بوک"> <i class="fab fa-facebook"></i>facebook</a></li>
                          <li><a href="" onclick="" data-network="#&quot;" data-title="" data-image="" class="icon icon-twitter" title="به اشتراک گذاری در توییتر"> <i class="fab fa-twitter"></i>twitter</a></li>
                          <li><a href="" onclick="" data-network="https://plus.google.com/share?url=[>URL<]" data-title="#" data-image="" data-url="" class="icon icon-googleplus" title="به اشتراک گذاری در گوگل پلاس"> <i class="fab fa-google-plus-g"></i>googleplus</a></li>
                          <li><a href="" class="icon icon-telegram" title="" rel="nofollow"><i class="far fa-paper-plane"></i>telegram</a></li>
                      </ul>
                  </div>
                  <div class="sharing-shortlink clearfix">
                      <label class="title-modal" for="shortlink">آدرس صفحه</label>
                      <input class="adress-page" name="ShareUrl" value="/index.php?route=product/product&amp;path=25_36&amp;product_id=51" readonly="readonly" style="direction: ltr; text-align: left;" type="text">
                  </div>
                  <div class="sharing-friends clearfix">
                      <label class="title-modal" for="sharetofriend">معرفی به دوستان</label>
                      <input id="frmTbxFriendEmail" class="adress-page" style="direction: ltr;" placeholder="yourfriend@email.com : ایمیل دوستتان" type="text">
                  </div>
                  <div class="sharing-captcha"><div>
                          <img src="/images/chapcha.png"></div>
                      <div class="inputContainer">
                          <input id="TbxEmailSendCaptcha" type="text">
                      </div>
                  </div>
                  <div class="dk-sharing-submit clearfix">
                      <div id="SendToEMailMessages" class="message-container"></div>
                      <div class="button-container small">
                          <a id="AncSendToEMail" target="_blank" class="button blue" href="#">
                              <i class="button-icon dk-button-icon-cart"></i>
                              <div class="button-label clearfix">
                                  <div class="button-labelname">ارسال</div>
                              </div>
                          </a>
                      </div>
                  </div>
              </div>
		</div>

	</div>
  </div>
</div>
	<!--content-end-->
@endsection