@extends('frontend.layouts.shop')
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function filter() {
            var manufacturers = [];
            $('.manufacturer:checked').each(function () {
                manufacturers.push($(this).val());
            });

            var filters = [];
            $('.filter_checkbox:checked').each(function() {
                filters.push($(this).val());
            });

            var filterLimit = $('#input-limit').val();

            var filterOrder = false;
            $('.button_radio.filter').each(function () {
                if( $(this).is(":checked") ) {
                    filterOrder = $(this).val();
                }
            });

            if($('#stock_status-param-1').prop('checked') == true){
                var stockStatus = 1;
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('frontend.shop.categories.filter', $category->slug) }}",
                data: {
                    'filters': filters,
                    'limit': filterLimit,
                    'order': filterOrder,
                    'stockStatus': stockStatus,
                    'manufacturers': manufacturers,
                    'minPrice': $(".min-value").val(),
                    'maxPrice': $(".max-value").val(),
                },
                success: function(products) {
                    $('#products_wrapper').html(products);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

        $('.filter').change(function () {
            filter();
        });

        $('.btn-filter').click(function(){
            filter();
        });

            var slider = document.getElementById('filter_price_slider');

            var min = 0;
            {{--var max = {{ number_format($mostExpensiveProduct->price, 0, '', '') }};--}}
            if(min == max)
                // max = min +1;
            noUiSlider.create(slider, {
                {{--start: [0, {{ number_format($mostExpensiveProduct->price, 0, '', '') }}],--}}
                connect: true,
                tooltips: [true, wNumb({ decimals: 0 })],
                format: wNumb({
                    decimals: 0
                }),
                range: {
                    'min': min,
                    'max': max
                }
            });

            var inputNumber = document.getElementById('input-number');

            slider.noUiSlider.on('update', function( values, handle ) {
                var value = values[handle];
                if ( handle ) {
                    $(".txt_price_max").val(value);
                } else {
                    $(".txt_price_min").val(Math.round(value));
                }
            });

            $("body").delegate(".txt_price_min",'change', function(){
                slider.noUiSlider.set([null,this.value]);
            });

            $("body").delegate(".txt_price_max",'change', function(){
                slider.noUiSlider.set([this.value,null]);
            });

            var min_filter_price = 0;
            {{--var max_filter_price = {{ number_format($mostExpensiveProduct->price, 0, '', '') }};--}}
            slider.noUiSlider.on('change', function( values, handle ) {
                min_filter_price = values[0];
                max_filter_price = values[1];
                filter();
            });
            $('#list-view').click(function(event){
                event.preventDefault();
                $('.product-layout').addClass('col-xs-12 col-lg-12 col-md-12 list-group-item');
                $('.product-layout').removeClass('col-xs-12 col-lg-4 grid-group-item');
                $('.product-layout').removeClass('col-md-4');
            });
            $('#grid-view').click(function(event){
                event.preventDefault();
                $('.product-layout').removeClass('col-xs-12 col-lg-12 col-md-12  list-group-item');
                $('.product-layout').addClass('col-xs-12 col-lg-4 grid-group-item');
                $('.product-layout').addClass('col-md-4');
            });
        });
    </script>
    <script src="/js/nouislider.min.js"></script>
    <script src="/js/wNumb.js"></script>

    <script src="/js/mCustomScrollbar.concat.min.js"></script>
    <script src="/js/jquery.twbsPagination.js"></script>

    <script>

        if (matchMedia('only screen and (min-width:768px)').matches) {
            $('#collapseTwo').addClass('show');
        }
        if (matchMedia('only screen and (max-width:767px)').matches) {
            $('#collapseTwo').removeClass('show');
        }
        <!---->


        ///اسکریپت مربوط به دکمه تغییر حالت لیست و گرید نمایش محصولات/////
        $(document).ready(function() {
            $('#list').click(function(event){
                event.preventDefault();
                $('#products .item').addClass('col-xs-12 col-lg-12 list-group-item');
                $('#products .item').removeClass('col-xs-12 col-lg-4 product-grid');
            });
            $('#grid').click(function(event){
                event.preventDefault();
                $('#products .item').removeClass('col-xs-12 col-lg-12 list-group-item');
                $('#products .item').addClass('col-xs-12 col-lg-4 product-grid');
            });
        });

        $(document).ready(function() {
            $('#list').click(function(event){
                event.preventDefault();
                $('#products .item').addClass('col-xs-12 col-lg-12 list-group-item');
                $('#products .item').removeClass('col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 product-grid');
            });
            $('#grid').click(function(event){
                event.preventDefault();
                $('#products .item').removeClass('col-xs-12 col-lg-12 list-group-item');
                $('#products .item').addClass('col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 product-grid');
            });
        });

        <!---->


        ///اسکریپت نمایش بیشتر در لیست نام مجموعه ها///
        $('.c-catalog__list--depth').each(function(){
            var LiN = $(this).find('li').length;
            if( LiN > 5){
                $('li', this).eq(4).nextAll().hide().addClass('toggleable');
                $(this).append('<li class="more">مشاهده همه دسته‌بندی‌ها</li>');

            }
        });
        $('.c-catalog__list--depth').on('click','.more', function(){
            if( $(this).hasClass('less') ){
                $(this).text('مشاهده همه دسته‌بندی‌ها').removeClass('less');
            }else{
                $(this).text('بستن').addClass('less');
            }
            $(this).siblings('li.toggleable').slideToggle();
        });
        <!---->


        ///اسکریپت نمایش اسکرول وقتی لیست فیلتر هر بخش طولانی می شود///
        function AutoScrollOff() {
            clearTimeout(autoScroll);
            content.removeClass("auto-scrolling-on").mCustomScrollbar("stop");
        }

        var content=$(".admin-content"),autoScrollTimer=8000,autoScrollTimerAdjust,autoScroll;
        content.mCustomScrollbar({
            scrollButtons:{enable:true},
            autoHideScrollbar:true,
            callbacks:{
                whileScrolling:function(){
                    autoScrollTimerAdjust=autoScrollTimer*this.mcs.topPct/100;
                },
                onScroll:function(){
                    if($(this).data("mCS").trigger==="internal"){AutoScrollOff();}
                }
            }
        });
        function AutoScrollOff() {
            clearTimeout(autoScroll);
            content.removeClass("auto-scrolling-on").mCustomScrollbar("stop");
        }

        var content1=$(".scroll .options"),autoScrollTimer=8000,autoScrollTimerAdjust,autoScroll;
        content1.mCustomScrollbar({
            scrollButtons:{enable:true},
            autoHideScrollbar:true,
            callbacks:{
                whileScrolling:function(){
                    autoScrollTimerAdjust=autoScrollTimer*this.mcs.topPct/100;
                },
                onScroll:function(){
                    if($(this).data("mCS").trigger==="internal"){AutoScrollOff();}
                }
            }
        });
        <!---->


        ///اسکریپت مربوط به صفحه بندی///
        $('#pagination-categori').twbsPagination({
            totalPages: 4,
// the current page that show on start
            startPage: 1,

// maximum visible pages
            visiblePages: 2,

            initiateStartPageClick: true,

// template for pagination links
            href: false,

// variable name in href template for page number
            {{--hrefVariable: '{{number}}',--}}

            // Text labels
            prev: 'قبلی',
            next: 'بعدی',
            last:'آخری',
            first:'اولی',

// carousel-style pagination
            loop: false,

// callback function
            onPageClick: function (event, page) {
                $('.page-active').removeClass('page-active');
                $('#page'+page).addClass('page-active');
            },

// pagination Classes
            paginationClass: 'pagination',
            nextClass: 'بعدی',
            prevClass: 'قبلی',
            pageClass: 'page',
            activeClass: 'active',
            disabledClass: 'disabled'

        });
        <!---->

        ///اسکریپت نمایش اسکرول قیمت///
        ;(function(){

            var doubleHandleSlider = document.querySelector('.double-handle-slider');
            var minValInput = document.querySelector('.min-value');
            var maxValInput = document.querySelector('.max-value');


            noUiSlider.create(doubleHandleSlider, {
                start: [0, {{ number_format($mostExpensiveProduct->price ?? 0, 0, '', '') }}],
                connect: true,
                tooltips: true,
                step: 1,
                range: {
                    'min': [ 0 ],
                    'max': [ {{ number_format($mostExpensiveProduct->price ?? 0, 0, '', '') }} ]
                },
                tooltips: [true, wNumb({ decimals: 0 })],
                format: wNumb({
                    decimals: 0
                }),

            });

            doubleHandleSlider.noUiSlider.on('change', function( values, handle ) {

                // This version updates both inputs.
                var rangeValues = values;
                minValInput.value = rangeValues[0];
                maxValInput.value = rangeValues[1];

            });

            minValInput.addEventListener('change', function(){
                doubleHandleSlider.noUiSlider.set([this.value, null]);
            });

            maxValInput.addEventListener('change', function(){
                doubleHandleSlider.noUiSlider.set([null, this.value]);
            });

        })();

        $(".close-flter").on("click", function() {
            $("#collapseTwo").collapse('hide');
        });



    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function filter() {
            var manufacturers = [];
            $('.manufacturer:checked').each(function () {
                manufacturers.push($(this).val());
            });

            var filters = [];
            $('.filter_checkbox:checked').each(function() {
                filters.push($(this).val());
            });

            var filterLimit = $('#input-limit').val();

            var filterOrder = false;
            $('.button_radio.filter').each(function () {
                if( $(this).is(":checked") ) {
                    filterOrder = $(this).val();
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('frontend.shop.categories.filter', $category->slug) }}",
                data: {
                    'filters': filters,
                    'limit': filterLimit,
                    'order': filterOrder,
                    'manufacturers': manufacturers,
                    'minPrice': $(".min-value").val(),
                    'maxPrice': $(".max-value").val(),
                },
                success: function(products) {
                    $('#products_wrapper').html(products);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

        $('.filter').change(function () {
            filter();
        });

        $('.btn-filter').click(function(){
            filter();
        });

        var slider = document.getElementById('filter_price_slider');

        var min = 0;
        var max = {{ number_format($mostExpensiveProduct->price ?? 0, 0, '', '') }};
        if(min == max)
            max = min +1;
        noUiSlider.create(slider, {
            start: [0, {{ number_format($mostExpensiveProduct->price ?? 0, 0, '', '') }}],
            connect: true,
            tooltips: [true, wNumb({ decimals: 0 })],
            format: wNumb({
                decimals: 0
            }),
            range: {
                'min': min,
                'max': max
            }
        });

        var inputNumber = document.getElementById('input-number');

        slider.noUiSlider.on('update', function( values, handle ) {
            var value = values[handle];
            if ( handle ) {
                $(".max-value").val(value);
            } else {
                $(".min-value").val(Math.round(value));
            }
        });

        $("body").delegate(".min-value",'change', function(){
            slider.noUiSlider.set([null,this.value]);
        });

        $("body").delegate(".max-value",'change', function(){
            slider.noUiSlider.set([this.value,null]);
        });

        var min_filter_price = 0;
        var max_filter_price = {{ number_format($mostExpensiveProduct->price ?? 0, 0, '', '') }};
        slider.noUiSlider.on('change', function( values, handle ) {
            min_filter_price = values[0];
            max_filter_price = values[1];
            filter();
        });
        $('#list-view').click(function(event){
            event.preventDefault();
            $('.product-layout').addClass('col-xs-12 col-lg-12 col-md-12 list-group-item');
            $('.product-layout').removeClass('col-xs-12 col-lg-4 grid-group-item');
            $('.product-layout').removeClass('col-md-4');
        });
        $('#grid-view').click(function(event){
            event.preventDefault();
            $('.product-layout').removeClass('col-xs-12 col-lg-12 col-md-12  list-group-item');
            $('.product-layout').addClass('col-xs-12 col-lg-4 grid-group-item');
            $('.product-layout').addClass('col-md-4');
        });
    </script>
@endsection
@section('styles')
    <link href="/css/nouislider.min.css" rel="stylesheet">
    <link href="/css/filter.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/mCustomScrollbar.css"/>
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/category.css" rel="stylesheet">
    <link href="/css/nouislider.min.css" rel="stylesheet">
@endsection
@section('title', $category->name)
@section('seo')
    <meta name="keywords" content="{{ $category->meta_keywords }}">
    <meta name="description" content="{{ $category->meta_description }}">
    <meta name="og:title" content="{{ $category->name }}">
    <meta name="og:description" content="{{ $category->meta_description }}">
@endsection
@section('content')
    <!--content-start-->
    <div class="container-fliud cont-categori ">
       
            <div class="row">
                <div class="col-sm-12 col-xs-12 ">
                    <ul class="filter-category">
                        <li class="filter-item">
                            <p class="filter-caption d-none d-md-block">جستجو پیشرفته</p>
                            <div class="row filter-box">
                                <div class="panel-group accordion-section" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ">
                                            <h4 class="panel-title">
                                                <ul>
                                                    <li>
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" class="">
                                                            <button class="btn btn-filter">
                                                                <i class="fas fa-filter"></i>
                                                                <span>فیلتر محصولات</span>
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>
                                                        </a>
                                                    </li>
                                                    <li class="sort-option">
                                                        <div class="center"><button data-toggle="modal" data-target="#sortModal" class="btn btn-sort"><i class="fas fa-sort-amount-down"></i>مرتب سازی</button></div>
                                                        <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p class="sort-caption">مرتب سازی</p>
                                                                        <div class="radio radio-primary">
                                                                            <label class="checkbox-icon customradio">
                                                                                <span class="radiotextsty"> پر بازدید ترین ها</span>
                                                                                <input id="sort-1" name="radio-talar" value=" پر بازدید ترین ها" type="radio">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio radio-primary">
                                                                            <label class="checkbox-icon customradio">
                                                                                <span class="radiotextsty">  جدید ترین ها</span>
                                                                                <input id="sort-2" name="radio-talar" value=" جدید ترین ها" type="radio">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio radio-primary">
                                                                            <label class="checkbox-icon customradio">
                                                                                <span class="radiotextsty">محبوب ترین ها</span>
                                                                                <input id="sort-3" name="radio-talar" value=" محبوب ترین ها" type="radio">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio radio-primary">
                                                                            <label class="checkbox-icon customradio">
                                                                                <span class="radiotextsty">  پرفروش ترین ها</span>
                                                                                <input id="sort-4" name="radio-talar" value=" پرفروش ترین ها" type="radio">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio radio-primary">
                                                                            <label class="checkbox-icon customradio">
                                                                                <span class="radiotextsty"> قیمت نزولی</span>
                                                                                <input id="sort-5" name="radio-talar" value=" قیمت نزولی" type="radio">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio radio-primary">
                                                                            <label class="checkbox-icon customradio">
                                                                                <span class="radiotextsty"> قیمت صعودی</span>
                                                                                <input id="sort-6" name="radio-talar" value=" قیمت صعودی" type="radio">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                                            <div class="btn-group btn-delete " role="group">
                                                                                <button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal" role="button">اعمال</button>
                                                                            </div>
                                                                            <div class="btn-group" role="group">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal" role="button">انصراف</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>

                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="row filter-top d-lg-none d-md-none  d-sm-none">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2 gap-col-mob form-control  close-flter">
                                                            <span class="action-button"><i class="fas fa-times"></i></span>
                                                        </div>
                                                        <div class="col-5 action-filter-box">
                                                            <span class="form-control action-filter">
                                                                <a href="#" class="action-button ">فیلتر</a>
                                                            </span>
                                                        </div>
                                                        <div class="col-5 clear-filter-box">
                                                            <span class="clear-filter form-control">
                                                                <a href="#" class="action-button">پاک کردن</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="panel panel-default filter_pannel">
                                                    <ul>
                                                       <!-- <li class="block cat-filter">
                                                            <p class="cat-filter-name">دسته بندی محصولات</p>
                                                            <ol>
                                                                <li class="main-categori">
                                                                    @foreach($categories as $theCategory)
                                                                        @if(count($theCategory->activeChildren) > 0)
                                                                            <div class="categori-name">
                                                                                <ul>
                                                                                    <li>
                                                                                        <a href="{{ route('category.show', ['category' => $theCategory->slug]) }}"><i class="fas fa-chevron-down"></i>{{ $theCategory->name }}</a>
                                                                                        <ul class="c-catalog__list--depth">
                                                                                            @foreach($theCategory->activeChildren as $child)
                                                                                            <li>
                                                                                                <a href="{{ route('category.show', ['category' => $child->slug]) }}">{{ $child->name }}</a>
                                                                                            </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        @else
                                                                            <a href="{{ route('category.show', ['category' => $theCategory->slug]) }}"><i class="fas fa-chevron-left"></i>{{ $theCategory->name }}</a>
                                                                        @endif
                                                                    @endforeach
                                                                </li>
                                                            </ol>
                                                        </li>-->
                                                        @foreach($category->filterGroups as $group)
                                                        <li class="block cat-filter scroll">
                                                            <input type="checkbox" name="item" id="off_filter_part" checked="checked">
                                                            <i></i>
                                                            <label class="filter-cation" for="off_filter_part">جستجو بر اساس {{ $group->name }}</label>
                                                            <div class="input-quick-search" style="border:0">
                                                            </div>
                                                            <div class="options">
                                                                <ul class="li-item">
                                                                    @foreach($group->filters as $filter)
                                                                    <li>
                                                                        <label class="checkbox-icon customradio">
                                                                            <span class="name-factur">{{ $filter->name }}</span>
                                                                            <input id="off-1" name="" class="filter filter_checkbox cmb_filter_category" value="{{ $filter->id }}" type="checkbox">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                        <li class="block cat-filter">
                                                            <label class="c-ui-statusswitcher">
                                                                <input type="checkbox" name="stock" class="filter" value="1" id="stock_status-param-1">
                                                                <span class="c-ui-statusswitcher__slider">
                                                                    <span class="c-ui-statusswitcher__slider__toggle"></span>
                                                                </span>
                                                            </label>
                                                            <span class="status">  فقط کالاهای موجود</span>
                                                        </li>
                                                        <li class="block cat-filter">
                                                            <input type="checkbox" name="item" id="cost_filter_part" checked="checked">
                                                            <i></i>
                                                            <label class="filter-cation" for="cost_filter_part">جستجو بر اساس قیمت محصول</label>
                                                            <div class="options">
                                                                <div class="double-handle-slider"></div>
                                                                <ul class="cost-rang">
                                                                    <li>
                                                                        <p class="lbl-prise"> از</p>
                                                                        <input type="number" class="min-value" value="0">
                                                                        <p>ریال</p>
                                                                    </li>
                                                                    <li>
                                                                        <p class="lbl-prise">تا</p>
                                                                        <input type="number" class="max-value" value="{{ number_format($mostExpensiveProduct->price ?? 0, 0, '', '') }}">
                                                                        <p>ریال</p>
                                                                    </li>
                                                                </ul>
                                                                <p class="btn-action">
                                                                    <button class="btn btn-filter-cost btn-filter">
                                                                        <i class="fas fa-filter"></i>
                                                                        <span>اعمال محدوه قیمت</span>
                                                                    </button>
                                                                </p>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="category-container">
                            <div id="products" class="row">
                                <p class="filter-caption form-control">محصولات</p>
                                <div class="col-sm-12 d-none d-md-block gap-col">
                                    <div class="row row-sort-top">
                                        <div class="col-sm-9">
                                            <div class="btn-filter">
                                                <label class="icon-sort" >
                                                    <span></span>مرتب سازی
                                                </label>
                                                <label class="sort_label">
                                                    <input class="button_radio filter" value="most_viewed" name="filter_sort" type="radio">
                                                    <span>پربازديد ترين</span>
                                                </label>
                                                <label class="sort_label">
                                                    <input class="button_radio filter" value="latest" name="filter_sort" type="radio">
                                                    <span>جديدترين‌ها</span>
                                                </label>
                                                <label class="sort_label">
                                                    <input class="button_radio filter" value="price_desc" name="filter_sort" type="radio">
                                                    <span>قيمت نزولی</span>
                                                </label>
                                                <label class="sort_label">
                                                    <input class="button_radio filter" value="price_asc" name="filter_sort" type="radio">
                                                    <span>قيمت صعودی</span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-sm-2 gap-col sort-icon">
                                            <div class="btn-group btn-grid">
                                                <span class="text-page hidden">
                                                   <label class="control-label" for="input-limit">نمايش:</label>
                                                </span>
                                                <span class="drop-page">
                                                   <select id="input-limit" class="form-control filter">
                                                       <option value="15" selected="selected">15</option>
                                                       <option value="25">25</option>
                                                       <option value="50">50</option>
                                                       <option value="75">75</option>
                                                       <option value="100">100</option>
                                                   </select>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 gap-col sort-icon">
                                            <div class="btn-group btn-grid">
                                                <a href="#" id="grid" class="btn btn-default btn-sm">
                                                    <i class="fas fa-th-large"></i>
                                                </a>
                                                <a href="#" id="list" class="btn btn-default btn-sm">
                                                    <i class="fas fa-th-list"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="page" id="products_wrapper">
                                    @include('frontend.shop.categories.products', compact('products', 'highlightAttributes'))
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
       
    </div>
    <!--content-end-->
@endsection
