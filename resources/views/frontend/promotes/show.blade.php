@extends('frontend.layouts.app')
@section('styles')
    <style>
        .content {
            width: 100% !important;
            background-color: #fff !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
    </style>
@endsection
@section('scripts')
    <script>
        function checkboxCounter() {
            var len = $(".service:checked").length;
            $("#checkedCounter").text(len);
        }
        function checkboxSum() {
            var price = 0;
            $('.service:checked').each(function() {
                var $item = $(this).attr('id');
                price = +price + +$('#'+$item+'Price').val();
            });
            $('#totalPrice').text(number_format(price, 0));
        }
        $(document).ready(function(){
            $('input.service[type="checkbox"]').on('change', function() {
                checkboxCounter();
                checkboxSum();
                var $item = $(this);
                $itemId = $item.attr('id');
                if ($item.is(':checked'))
                {
                    $('#'+$itemId+'Box').removeClass('d-none');
                }
                else
                {
                    $('#'+$itemId+'Box').addClass('d-none');
                }
            });
        });
    </script>
@endsection
@section('content')
    <div class="container gap-col gap-col-mob my-4">
        <div class="py-3 text-center">
            <h2>ارتقای آگهی</h2>
            <p class="lead">پکیج‌های مورد نظر برای ارتقا را انتخاب کنید:</p>
        </div>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">خدمات</span>
                    <span id="checkedCounter" class="badge badge-secondary badge-pill">4</span>
                </h4>
                <ul class="list-group mb-3">
                    <div id="ladderBox">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">نردبان</h6>
                                <small class="text-muted">{{ $descriptions[1] }}</small>
                            </div>
                            <span class="text-muted">{{ number_format($services[1], 0) }} تومان</span>
                            <input type="hidden" id="ladderPrice" value="{{ number_format($services[1], 0, '', '') }}">
                        </li>
                    </div>
                    <div id="featuredBox" class="d-none">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">ویژه</h6>
                                <small class="text-muted">{{ $descriptions[2] }} </small>
                            </div>
                            <span class="text-muted">{{ number_format($services[2], 0) }} تومان</span>
                            <input type="hidden" id="featuredPrice" value="{{ number_format($services[2], 0, '', '') }}">
                        </li>
                    </div>
                    <div id="renewalBox" class="d-none">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">تمدید</h6>
                                <small class="text-muted">{{ $descriptions[3] }}</small>
                            </div>
                            <span class="text-muted">{{ number_format($services[3], 0) }} تومان</span>
                            <input type="hidden" id="renewalPrice" value="{{ number_format($services[3], 0, '', '') }}">
                        </li>
                    </div>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>جمع (تومان)</span>
                        <strong id="totalPrice">{{ number_format($services[1], 0) }}</strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">مشخصات آگهی</h4>
                <form action="{{ route('frontend.promotes.update', $commercial->slug) }}" method="post" class="needs-validation" novalidate>
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            {{ $commercial->title }}
                            <a href="{{ route('frontend.commercials.show', $commercial->slug) }}" class="btn btn-primary btn-sm">
                                <span class="fa fa-eye"></span>
                                مشاهده
                            </a>
                        </div>
                    </div>
                    @include('frontend.layouts.partials.input-errors')
                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input service" id="ladder" name="ladder" value="1"{{ old('ladder', 1) ? ' checked' : '' }}>
                        <label class="custom-control-label" for="ladder">نردبان</label>
                        @if ($errors->has('ladder'))
                            <p class="text-danger">{{ $errors->first('ladder') }}</p>
                        @endif
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input service" id="featured" name="featured" value="1"{{ old('featured') ? ' checked' : '' }}>
                        <label class="custom-control-label" for="featured">ویژه</label>
                        @if ($errors->has('featured'))
                            <p class="text-danger">{{ $errors->first('featured') }}</p>
                        @endif
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input service" id="renewal" name="renewal" value="1"{{ old('renewal') ? ' checked' : '' }}>
                        <label class="custom-control-label" for="renewal">تمدید</label>
                        @if ($errors->has('renewal'))
                            <p class="text-danger">{{ $errors->first('renewal') }}</p>
                        @endif
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-success btn-lg btn-block" type="submit">پرداخت به وسیله کارت‌های عضو شبکه شتاب</button>
                </form>
            </div>
        </div>
    </div>
@endsection
