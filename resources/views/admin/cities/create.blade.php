@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <style>
        .select2-selection__choice {
            color: #666 !important;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-search__field {
            width: 100% !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#province').select2({
                placeholder : 'استان محصول را انتخاب کنید',
                dir: "rtl",
            });
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>افزودن شهر</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.cities.index') }}">شهرها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.cities.store') }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام شهر *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label col-md-3 col-sm-3 col-xs-12">اسلاگ *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">عنوان  *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="province_id" class="control-label col-md-3 col-sm-3 col-xs-12">استان *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="province_id" id="province_id" class="form-control" dir="rtl">
                                    <option value="">استان را انتخاب کنید</option>
                                    @foreach($provinces as $id => $name)
                                        <option value="{{ $id }}"{{ (old('province_id') == $id ? 'selected' : '') }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="latitude" class="control-label col-md-3 col-sm-3 col-xs-12">عرض جغرافیایی  *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="longitude" class="control-label col-md-3 col-sm-3 col-xs-12">طول جغرافیایی  *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort_order" class="control-label col-md-3 col-sm-3 col-xs-12">ترتیب</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order') }}" min="0" max="999">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">کلمات کلیدی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_description" class="control-label col-md-3 col-sm-3 col-xs-12">متای توضیحات</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="meta_description" id="meta_description" class="form-control" value="{{ old('meta_description') }}">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="submit" class="btn btn-success" value="افزودن شهر">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection
