@extends('frontend.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
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
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBUcxNAzDyoiTXUXpLwd1a-3jOwkQpDUs&callback=loadMap&language=fa"></script>
    <script>
        function loadMap() {
            var mapOptions = {
                center:new google.maps.LatLng({{ $commercial->lat ?? 35.712991 }}, {{ $commercial->lng ?? 51.367627 }}),
                zoom:13,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng({{ $commercial->lat ?? 35.712991 }}, {{ $commercial->lng ?? 51.367627 }}),
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
            $(document).on('change', '.dropify', function (event) {
                var clone = $('#imageHolder').clone();
                clone.attr('id', '').removeClass('d-none').appendTo('#galleryHolder');
                $('#galleryHolder input:last').addClass('dropify').dropify();
            });
        });
    </script>
@endsection
@section('content')
<div class="container gap-col gap-col-mob">
    <form id="createCommercial" class="col-md-12 mt-4 form-horizontal gap-col gap-col-mob" action="{{ route('frontend.commercials.update', $commercial->slug) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="row">
           <div class="col-12 gap-col ">
                <h1 class="edit-item">ویرایش آگهی: {{ $commercial->title }}
                @if($commercial->status == 0)
                <span class="badge badge-primary">در حال بررسی</span>
                @elseif($commercial->status == 1)
                <span class="badge badge-success">تایید شده</span>
                @elseif($commercial->status == 1)
                <span class="badge badge-danger">رد شده</span>
                @endif
            </h1>
           </div>
        </div>
        @include('frontend.layouts.partials.input-errors')
        <div class="row">
            <div class="col-12 gap-col gap-col-mob">
                <div class="card d-block">
     <div class="card-body commercial-box-body">
         <div class="row">
              <div class="col-12 gap-col gap-col-mob">
				<nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active show" id="nav-1" data-toggle="tab"
						   href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">ویرایش</a>
						<a class="nav-item nav-link" id="nav-2" href="{{ route('frontend.promotes.show', $commercial->slug) }}"
						   role="tab" aria-controls="tab-2" aria-selected="false">ارتقاء</a>
						<a class="nav-item nav-link" id="nav-3" href="{{ route('frontend.commercials.show', $commercial->slug) }}"
						   role="tab" aria-controls="tab-3" aria-selected="false">پیش نمایش</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade active show" id="tab-1" role="tabpanel"
						 aria-labelledby="nav-1">
						    <div class="row">
							   <div class="col-md-6 col-12 gap-col gap-col-mob">
									<div class="form-group">
									<label for="" class="control-label col-md-3 col-sm-3 col-xs-12">موقعیت</label>
									<div class="col-12 gap-col gap-col-mob">
										<div id="map" style="width:100%;min-height:300px"></div>
									</div>
									<input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $commercial->latitude) }}">
									<input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $commercial->longitude) }}">
								</div>
							   </div>
							   <div class="col-md-6 col-12 gap-col gap-col-mob">
									@foreach($fields as $field)
										@switch($field->type)
											@case('text')
											<div class="form-group">
												<label for="field{{ $loop->iteration }}" class="control-label col-md-6 col-sm-6 col-xs-12">{{ $field->label }}</label>
												<div class="col-12">
													<input type="text" name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" class="form-control" placeholder="{{ $field->placeholder }}" value="{{ old('fields.' . $field->id, $field->commercials->first()->pivot->value ?? '') ?? '' }}">
												</div>
											</div>
											@break
											@case('select')
											<div class="form-group">
												<label for="field{{ $loop->iteration }}" class="control-label col-md-6 col-sm-6 col-xs-12">{{ $field->label }}</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" class="form-control" dir="rtl">
														@foreach($field->options as $option)
															<option value="{{ $option }}"{{ old('fields.' . $field->id, $field->pivot->value ?? '') == $option ? ' selected' : '' }}>{{ $option }}</option>
														@endforeach
													</select>
												</div>
											</div>
											@break
											@case('checkbox')
											<div class="form-group">
												<label for="featured" class="control-label col-md-6 col-sm-6 col-xs-12">{{ $field->label }}</label>
												<div class="col-12">
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
							<div>
								<div class="form-group">
									<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">عنوان آگهی *</label>
									<div class="col-12">
										<input type="text" name="title" id="title" class="form-control" value="{{ old('title', $commercial->title) }}">
									</div>
								</div>
							</div>
							<div>
								<div class="form-group">
									<label for="content" class="control-label col-md-3 col-sm-3 col-xs-12">توضیحات آگهی *</label>
									<div class="col-12">
										<textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ strip_tags(old('content', $commercial->content)) }}</textarea>
									</div>
								</div>
							</div>
							<div>
								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
									</div>
								</div>
							</div>
							   </div>
                           </div>
                         <div class="row">
                            <div class="col-12 gap-col gap-col-mob">
                                <div id="galleryHolder" class="form-group row">
                                    @foreach($commercial->images as $image)
                                        <div class="col-md-3 col-sm-6 col-6">
                                            <input type="hidden" name="keeper[{{ $image->id }}]" value="{{ $image->id }}">
                                            <input type="file" name="images[]" data-default-file="/{{ $image->name }}" class="dropify">
                                        </div>
                                    @endforeach
                                    <div class="col-md-3 col-sm-6 col-6">
                                        <input type="file" name="images[]" class="dropify">
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="nav-2">
					</div>
					<div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="nav-3">
					</div>
				</div>
			</div>
          </div>
      </div>
 </div>
            </div>
        </div>

    </form>
    <div class="card my-2 d-block">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <span>تعداد بازدید آگهی:</span>
                    <strong>{{ $commercial->views_count }}</strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span>تعداد کلیک دکمه تماس:</span>
                    <strong>{{ $commercial->clicks_count }}</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-2 d-block">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                    حذف آگهی
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                        <form action="{{ route('frontend.commercials.destroy', $commercial->slug) }}" method="post" class="form-horizontal">
                        @csrf
                        @method('delete')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">حذف آگهی</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>بعد از حذف آگهی، برای زنده کردن این آگهی با شرکت تماس بگیرید.</p>
                                    به چه علتی می‌خواهید این آگهی را حذف نمایید:
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="reason" id="kashtidaran_sold" value="0" checked>
                                      <label class="form-check-label" for="kashtidaran_sold">
                                        در کشتی داران فروش نرفت
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="reason" id="anotherway_sold" value="1">
                                      <label class="form-check-label" for="anotherway_sold">
                                        از راه دیگری فروختم
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="reason" id="no_buyers" value="2">
                                      <label class="form-check-label" for="no_buyers">
                                        مشتری پیدا نشد
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="reason" id="canceled" value="3">
                                      <label class="form-check-label" for="canceled">
                                        از فروش منصرف شدم
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="reason" id="no_result" value="4">
                                      <label class="form-check-label" for="no_result">
                                        نتیجه نگرفتم
                                      </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بیخیال</button>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('آیا از حذف این آگهی اطمینان دارید؟');">حذف آگهی</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="imageHolder" class="d-none col-md-3 col-sm-6 col-xs-12">
    <input type="file" name="images[]">
</div>
@endsection
