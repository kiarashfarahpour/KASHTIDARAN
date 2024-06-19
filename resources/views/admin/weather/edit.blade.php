


@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
        $('.toggle').addClass('pull-right');
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش استان</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.weather.index') }}"> هواشناسی
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.weather.update', $weather->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $weather->name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label col-md-3 col-sm-3 col-xs-12">اسلاگ *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $weather->slug) }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">تصویر</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="file" name="image" id="image" class="dropify" @if($weather->image_id) data-default-file="{{ asset($weather->image->name) }}" @endif>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">وضعیت</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" name="status" id="status" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> انتشار" data-off="<i class='fa fa-close text-red'></i> پیش‌نویس"{{ old('status', $weather->status) ? ' checked' : '' }}>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="submit" class="btn btn-success" value="ذخیره تغییرات">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection