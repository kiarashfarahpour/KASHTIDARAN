@extends('frontend.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
    <style>
    .content {
        width: 100% !important;
    }
    ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
        color:    #ced4da !important;
    }
    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
       color:    #ced4da !important;
       opacity:  1;
    }
    ::-moz-placeholder { /* Mozilla Firefox 19+ */
       color:    #ced4da !important;
       opacity:  1;
    }
    :-ms-input-placeholder { /* Internet Explorer 10-11 */
       color:    #ced4da !important;
    }
    ::-ms-input-placeholder { /* Microsoft Edge */
       color:    #ced4da !important;
    }
    
    ::placeholder { /* Most modern browsers support this now. */
       color:    #ced4da !important;
    }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBUcxNAzDyoiTXUXpLwd1a-3jOwkQpDUs&callback=loadMap&language=fa"></script>
    <script>
        var map, marker;
        function loadMap() {
            var mapOptions = {
                center:new google.maps.LatLng(35.712991, 51.367627),
                zoom:13,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(35.712991, 51.367627),
                draggable:true,
                animation: google.maps.Animation.DROP,
                map: map,
            });
            marker.addListener('drag', handleEvent);
            marker.addListener('dragend', handleEvent);
        }
        google.maps.event.addDomListener(window, 'load', loadMap);
        function handleEvent(event) {
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();
        }
        $(document).ready(function(){
            $('#fields').select2({
                dir: "rtl",
            });
            $('.dropify').dropify({
                messages: {
                    'default': 'عکس را اینجا رها کرده یا کلیک کنید',
                    'replace': 'برای تغییر عکس، آن را اینجا رها کرده یا کلیک کنید',
                    'remove':  'حذف',
                    'error':   'اوپس، مشکلی پیش آمده است'
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#category').select2({
                dir: "rtl",
            });
            $('#city').select2({
                dir: "rtl",
            });

            $('#city').on('select2:select', function (e) {
                $("#district").val('').change();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('frontend.city-has-district') }}",
                    data: {
                        _method: "POST",
                        city: $('#city').val()
                    },
                    success: function(message) {
                        // Set sth
                        if(message.status == 'success') {
                            if(message.hasDistrict) {
                                $('#districtWrapper').removeClass('d-none');
                            } else {
                                $('#districtWrapper').addClass('d-none');
                            }
                            var latlng = new google.maps.LatLng(message.latitude, message.longitude);
                            map.setCenter(latlng);
                            marker.setPosition(latlng);
                        } else {
                            iziToast.error({
                                message: message.body,
                                'position': 'topLeft'
                            });
                        }
                    },
                    error: function(e) {
                        // Set sth
                        iziToast.error({
                            message: 'متاسفانه مشکلی در دریافت فیلدهای دسته‌بندی پیش آمد.',
                            'position': 'topLeft'
                        });
                    }
                });
            });

            $("#district").select2({
                placeholder : 'محله را انتخاب کنید',
                ajax: {
                    url: "{{ route('frontend.cities.districts') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            city: $('#city').val(),
                            search: params.term,
                        };
                    },
                    processResults: function (response) {
                        return {"results": response,};
                    },
                    cache: true
                }
            });
            $('#city').on('change', function (e) {
                var city = $(this).val();
                var url = $('#createCommercial').attr('action'),
                    shortUrl = url.substring(0, url.lastIndexOf("/")),
                    slug = url.substring(shortUrl.lastIndexOf("/") + 1 , url.lastIndexOf("/"));
                var newUrl = url.replace(slug, city);
                $('#createCommercial').attr('action', newUrl)
            });
        });
    </script>
@endsection
@section('content')
<h1 class="text-center pt-5 h6 txt-blue">ثبت آگهی رایگان در کشتی داران</h1>
<section class="container" id="wizard">
    @include('frontend.layouts.partials.input-errors')
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="wizard">
                <!--<div class="wizard-inner">
                     <div class="connecting-line"></div> 
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true">
                                <span class="round-tab">1 </span>
                                <span class="step-text">شهر و محل آگهی
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false">
                                <span class="round-tab">2</span>
                                <span class="step-text">بارگزاری تصویر
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab">
                                <span class="round-tab">3</span>
                                <span class="step-text">عنوان و توضیحات
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab">
                                <span class="round-tab">4</span>
                                <span class="step-text">مشخصات و ویژگی‌ها
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>-->
                 <form id="createCommercial" class="col-md-12 mt-4 form-horizontal gap-col-mob" action="{{ route('frontend.commercials.store', [$city->slug, $category->slug]) }}" method="post" enctype="multipart/form-data" role="form">
                    @csrf
                    <div class="tab-content" id="main_form">
                        <div class="tab-pane active" role="tabpanel" id="step1">
							<div class="col-md-12">
								<div class="form-group">
									<label for="title">عنوان آگهی *</label>
									<input type="text" name="title" id="title" class="form-control f-input" value="{{ old('title') }}">
								</div>
							</div>
                            <div class="row">
                                <div class="col-md-6 f-control form-group">
								<label for="title">انتخاب شهر</label>
                                    <select name="city" id="city" class="select2 f-select form-control">
                                        <option value="">شهر را انتخاب کنید</option>
                                        @foreach($cities as $cityId => $cityName)

                                        <option value="{{ $cityId }}"{{ old('city') == $cityId ? ' selected' : '' }}>{{ $cityName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                               <!-- <div class="col-md-6 f-control form-group">
                                    <select name="district" id="district" class="select2 f-select form-control">
                                        <option value="">محله را انتخاب کنید</option>
                                        @foreach($districts as $districtId => $district)
                                        <option value="{{ $districtId }}"{{ old('district') == $districtId ? ' selected' : '' }}>{{ $district }}</option>
                                        @endforeach
                                    </select>
                                </div>-->
                            </div>
                            <!--<div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">موقعیت</label>
                                        <div id="map" style="width:100%;min-height:300px"></div>
                                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-left">
                                <li>
                                    <button type="button" class="default-btn next-step">مرحله بعد</button>
                                </li>
                            </ul>-->
                            <label for="title">بارگذاری عکس</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="uploadOuter">
                                        <div class="dragBox">
                                            <input type="file" onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()" id="uploadFile" />
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <div class="">تصویر را در اینجا اپلود کنید</div>

                                            <span class="btn btn-outline-primary btn-upload my-4 small">تصویر را انتخاب کنید</span>
                                            <p class="upload-limit small">فقط فایل های pdf, jpg, png و حداکثر حجم 200 کیلوبایت</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mx-auto my-0 py-3" id="remove">
                                        <div class="prev"></div>
                                        <div class="prev" id="preview1"></div>
                                        <div class="prev" id="preview2"></div>
                                        <div class="prev" id="preview3"></div>
                                        <div class="prev" id="preview4"></div>
                                    </div>
                                    <div class="mx-auto my-0 py-3" id="preview"></div>
                                </div>
                            
                            <!--<ul class="list-inline pull-left">
                                <li>
                                    <button type="button" class="default-btn next-step">مرحله بعد</button>
                                </li>
                            </ul>-->
							<div class="col-md-12">
								<div class="form-group">
									<label for="content">توضیحات آگهی</label>
									<textarea name="content" id="content" rows="5" class="form-control f-input">{{ old('content') }}</textarea>
								</div>
							</div>
                        </div>
						<!--<ul class="list-inline pull-left">
							<li>
								<button type="button" class="default-btn next-step">ادامه</button>
							</li>
						</ul>
                        <div class="tab-pane" role="tabpanel" id="step4">
                            <div class="row text-right">
                                @foreach($fields as $field)
                                    @switch($field->type)
                                        @case('text')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field{{ $loop->iteration }}">{{ $field->label }}</label>
                                                <input type="text" name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" class="form-control f-input" placeholder="{{ $field->placeholder }}" value="{{ old('fields.' . $field->id, $field->value) ?? '' }}">
                                            </div>
                                        </div>
                                        @break
                                        @case('select')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field{{ $loop->iteration }}">{{ $field->label }}</label>
                                                <select name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" class="form-control f-input" dir="rtl">
                                                    @foreach($field->options as $option)
                                                        <option value="{{ $option }}"{{ (old('fields.' . $field->id) == $option ? ' selected' : '') }}>{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @break
                                        @case('checkbox')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="featured">{{ $field->label }}</label>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" value="1" class="flat"{{ (old('fields' . $field->id) ? ' checked' : '') }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                    @endswitch
                                @endforeach
                            </div>-->
                            <div class="row text-right">
                                <div class="form-group form-check mr-5">
                                    <input type="checkbox" class="form-check-input" id="accepted" name="accepted" value="1">
                                    <label class="form-check-label" for="accepted"><span style="color: #3366ff;"><span style="color: #000000;">با</span>&nbsp;<a style="color: #3366ff;" title="قوانین وشرایط کشتی داران را بخوانید" href="http://kashtidaran.com/page/tos-shipowners"><span style="text-decoration: underline;">قوانین</span><span style="color: #3366ff;"> و شرایط</span></a></span> استفاده از وب سایت کشتی داران&nbsp; موافق هستم.</label>
                                </div>
                            </div>
                            <ul class="list-inline pull-left">
                                <li>
                                    <button type="submit" class="default-btn next-step">تکمیل</button>
                                </li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
</section>
@endsection
