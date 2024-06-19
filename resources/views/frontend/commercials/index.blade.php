@extends('frontend.layouts.commercials')
@section('title', 'همه آگهی‌ها')
@section('styles')
    <style>
        .ajax-load{
            background: #e1e1e1;
            padding: 10px 0px;
            width: 100%;
        }
    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        var page = 1;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                page++;
                loadMoreData(page);
            }
        });
        var category, district, phrase, hasImage, isFeatured, isImmediate, dynamicFields = [], dynamicSwitches = [];
        function findDynamicFileds() {
            dynamicFields = [];
            $('.fieldFilter').each(function() {
                var id     = $(this).data('field');
                var value  = $(this).val();
                if (value != '') {
                    dynamicFields.push({id: id, value: value});
                }
            });
        }
        function findDynamicSwitches() {
            dynamicSwitches = [];
            $('.switchFilter:checked').each(function() {
                dynamicSwitches.push($(this).val());
            });
        }
        function changeHasImageStatus() {
            hasImage    = false;
            if($('#stock_status-param-1'). prop("checked") == true){
                hasImage = true;
            }
        }
        function changeIsFeaturedStatus() {
            isFeatured  = false;
            if($('#stock_status-param-2'). prop("checked") == true){
                isFeatured = true;
            }
        }
        function changeIsImmediateStatus() {
            isImmediate  = false;
            if($('#isImmediate'). prop("checked") == true){
                isImmediate = true;
            }
        }
        function applySearch() {
            category    = $('#categoryFilter').val();
            district    = $('#districtFilter').val();
            phrase      = $('#phrase').val();
        }
        function resetPage() {
            $('#commercial-data').html('');
            page = 1;
        }
        function loadMoreData(page){
            $.ajax({
                    url: '?page=' + page,
                    data: {
                        category: category,
                        district: district,
                        phrase: phrase,
                        hasImage: hasImage,
                        isFeatured: isFeatured,
                        isImmediate: isImmediate,
                        dynamicFields: dynamicFields,
                        dynamicSwitches: dynamicSwitches
                    },
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data) {
                    if(data.html == ""){
                        $('.ajax-load').html("آگهی دیگری وجود ندارد.");
                        return;
                    }
                    $('.ajax-load').hide();
					$("#filterModal").modal('hide');
                    $("#commercial-data").append(data.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    iziToast.error({
                        message: 'متاسفانه مشکلی در دریافت آگهی‌ها پیش آمد.',
                        'position': 'topLeft'
                    });
                });
        }
        $('#stock_status-param-1').change(function () {
            resetPage();
            changeHasImageStatus();
            loadMoreData(page);
        });
        $('#stock_status-param-2').change(function () {
            resetPage();
            changeIsFeaturedStatus();
            loadMoreData(page);
        });
        $('#isImmediate').change(function () {
            resetPage();
            changeIsImmediateStatus();
            loadMoreData(page);
        });
		
        $('#isImmediate2').change(function () {
            resetPage();
            changeIsImmediateStatus();
            loadMoreData(page);
        });
        $('#applyFilter').click(function () {
            resetPage();
            applySearch();
            loadMoreData(page);
            findDynamicFileds();
            findDynamicSwitches();
        });
        $('.applyFilter').change(function() {
            resetPage();
            applySearch();
            loadMoreData(page);
            findDynamicFileds();
            findDynamicSwitches();
        });

    </script>
@endsection
@section('seo')
    <meta name="keywords" content="آگهی,کشتی,لنج">
    <meta name="description" content="آگهی‌های مرتبط با حوزه‌های مختلف را در کشتی داران بیابید.">
    <meta name="og:title" content="همه آگهی‌ها">
    <meta name="og:description" content="آگهی‌های مرتبط با حوزه‌های مختلف را در کشتی داران بیابید.
@endsection
@section('content')
<div class="col-lg-9 col-md-8" id="product-list">
    <div id="commercial-data" class="row">
        @include('frontend.partials.city-commercials')
    </div>
    <div id="loading" class="ajax-load text-center" style="display:none">
        <p>
            <img src="{{ asset('images/loader.gif') }}">
            در حال بارگذاری آگهی‌های بیشتر
        </p>
    </div>
</div>
@endsection
