@extends('frontend.layouts.app')
@section('styles')
<style>
    .content {
        width: 100% !important;
    }
</style>
@endsection
@section('scripts')
    <script>
        var categories = [];
        @foreach($allCategories as $id => $cat)
            categories[{{ $id }}] = {
            @isset($cat['parent'])
            'parent': '{{ $cat['parent'] }}',
            @endisset
            'name': '{{ $cat['name'] }}',
            'type': '{{ $cat['type'] }}',
            @isset($cat['href'])
            'href': '{{ $cat['href'] }}',
            @endisset
        };
        @endforeach

        function backToTopLevel(id) {
            var list = '';
            if('parent' in categories[id]) {
                list = makeBackButton(categories[id]['parent']);
                list += makeChildren(categories[id]['parent']);
            } else {
                categories.forEach(function (category, index) {
                    if('parent' in category) {
                    } else {
                        list += makeChildLi(index);
                    }
                })
            }
            return list;
        }

        function makeBackButton(id) {
            return '<li class="list-group-item active backToTopLevel pointer" data-id="' + id + '">' +
                '    <span class="fa fa-chevron-right"></span> ' +
                    categories[id]['name'] +
                '</li>';
        }

        function makeChildLi(id) {
            var content = '';
            if(categories[id]['type'] == 'child') {
                content = '<a href="' + categories[id]['href'] + '">' + categories[id]['name'] + '</a>';
            } else {
                content = '<span class="showChildren pointer" data-id="' + id + '">' + categories[id]['name'] + '</span>';
            }
            return '<li class="list-group-item">' + content + '</li>';
        }

        function makeChildren(id) {
            var list = '';
            categories.forEach(function (category, index) {
                if('parent' in category && category['parent'] == id)
                {
                    list += makeChildLi(index);
                }
            });
            return list;
        }

        function showList(list) {
            $('#listWrapper').html(list);
        }

        $(document).on('click', '.showChildren', function() {
            var id = $(this).data('id');
            var list = makeBackButton(id);
            list += makeChildren(id);
            showList(list);
        });

        $(document).on('click', '.backToTopLevel', function() {
            var id = $(this).data('id');
            var list = backToTopLevel(id);
            showList(list);
        });
        $(document).on('click', '.category-btn', function() {
            $('#trade-btns').removeClass('d-none');
            var saleHref = $(this).attr('data-sale-href');
            var buyHref  = $(this).attr('data-buy-href');
            var sale     = $(this).attr('data-sale');
            var buy      = $(this).attr('data-buy');
            $('#btn-buy').attr('href', buyHref);
            $('#btn-sale').attr('href', saleHref);
            $('#btn-buy').html(buy);
            $('#btn-sale').html(sale);
        });
        $(document).on('click', '#myTabs a', function() {
            $('#trade-btns').addClass('d-none');
        })
        // .category-btn
        // #myTabs a
    </script>
@endsection
@section('content')
<h1 class="text-center pt-5 h6 txt-blue">ثبت آگهی رایگان در کشتی داران</h1>
<section class=" mt-5 container" id="wizard">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="wizard">
                <div class="wizard-inner">
                    <!-- <div class="connecting-line"></div> -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true">
                                <span class="round-tab">1 </span>
                                <span class="step-text">دسته‌بندی موردنظر
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false">
                                <span class="round-tab">2</span>
                                <span class="step-text">شهر و محل آگهی
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#" data-toggle="tab" aria-controls="step3" role="tab">
                                <span class="round-tab">3</span>
                                <span class="step-text">بارگزاری عکس
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#" data-toggle="tab" aria-controls="step4" role="tab">
                                <span class="round-tab">4</span>
                                <span class="step-text">عنوان و توضیحات
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#" data-toggle="tab" aria-controls="step4" role="tab">
                                <span class="round-tab">5</span>
                                <span class="step-text">مشخصات و ویژگی‌ها
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#" data-toggle="tab" aria-controls="step4" role="tab" class="disabled">
                                <span class="round-tab">6</span>
                                <span class="step-text">ثبت نهایی
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="main_form">
                    <div id="trade-btns" class="text-center d-none">
                        <!--<a href="#" id="btn-buy" class="btn btn-buy mt-3 pt-1"></a>-->
                        <a href="#" id="btn-sale" class="btn btn-sale mt-3 pt-1"></a>
                    </div>
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <div class="row justify-content-center ">
                            <ul id="myTabs" class="nav nav-pills nav-justified no-padding" role="tablist" data-tabs="tabs">
                                @foreach($mainCategories as $category)
                                <li>
                                    <a href="#c-{{ $category->slug }}" data-toggle="tab" @if($loop->first) class="active" @endif>{{ $category->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab tab-content border-0 rounded-0 shadow-none w-90 px-0">
                                @foreach($mainCategories as $category)
                                <div id="c-{{ $category->slug }}" role="tabpanel" class="tab-pane fade in {{ $loop->first ? 'active show' : '' }} mt-3">
                                    <div class="w-100">
                                        @foreach($category->children as $child)
                                        <button class="btn category-btn mx-1 my-2 btn-" data-buy-href="{{ route('frontend.commercials.create', [$routeParameters['city'], $child->slug, 'buy']) }}" data-sale-href="{{ route('frontend.commercials.create', [$routeParameters['city'], $child->slug, 'sell']) }}" data-buy="{{ $child->buy ?? $category->buy ?? 'خریدار' }} هستم" data-sale="{{ $child->sell ?? $category->sell ?? 'فروشنده' }} هستم">
                                            {{ $child->name }}
                                        </button>
                                        {{--<a class="btn category-btn mx-1 my-2" href="{{ route('frontend.commercials.create', [$routeParameters['city'], $child->slug]) }}">
                                            @if($child->image_id)
                                            <img src="{{ asset(image_resize($child->image->name, ['width' => 45, 'height' => 45])) }}"><br>
                                            @endif
                                            {{ $child->name }}
                                        </a>--}}
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
