@extends('admin.layouts.app')
@section('styles')
    <link  rel="stylesheet"href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
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
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#fields').select2({
                dir: "rtl",
            });
            $('#parent_id').select2();
        });
    </script>
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>افزودن آیتم به هواشناسی</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.items.store', $weather->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">عنوان *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" autocomplete="off" placeholder="هواشناسی استان خوزستان">
                                <small class="help-block">عنوان در صفحه اصلی هواشناسی نمایش داده می شود</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link" class="control-label col-md-3 col-sm-3 col-xs-12">لینک</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="url" name="link" id="link" class="form-control" value="{{ old('link') }}" dir="ltr" autocomplete="off" placeholder="http://hormozgan.ir/weather">
                                <small class="help-block">لینک صفحه هواشناسی در سایت مبدا، کاربرد لینک شدن و دریافت فایل از این صفحه دارد</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="suffix" class="control-label col-md-3 col-sm-3 col-xs-12">پسوند فایل</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="suffix" id="suffix" class="form-control" value="{{ old('suffix') }}" autocomplete="off" placeholder="pdf">
                                <small class="help-block">پسوند فایلی که باید دانلود شود</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site" class="control-label col-md-3 col-sm-3 col-xs-12">سایت</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="url" name="site" id="site" class="form-control" value="{{ old('site') }}" dir="ltr" autocomplete="off" placeholder="http://khozestan.ir">
                                <small class="help-block">نام دامنه سایت برای ریزالو کردن آدرس های نسبی</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort_order" class="control-label col-md-3 col-sm-3 col-xs-12">ترتیب</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order') }}" min="0" max="999" autocomplete="off" placeholder="0">
                                <small class="help-block">ترتیب قرارگیری آیتم ها، عددی بین 0 و 999 یا خالی رها شود</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="method" class="control-label col-md-3 col-sm-3 col-xs-12">متد</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="method" id="method" class="form-control" dir="rtl" autocomplete="off">
                                    <option value="0">ثابت و بدون آپدیت</option>
                                    <option value="1">دریافت فایل از لینک مستقیم</option>
                                    <option value="2">دریافت فایل از لینک داخل المان</option>
                                    <option value="3">دریافت محتوای یک المان</option>
                                    <option value="4">دریافت فایل از طریق لینک داینامیک</option>
                                </select>
                                <small class="help-block">متد پردازش این آیتم</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="element" class="control-label col-md-3 col-sm-3 col-xs-12">المان</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="element" id="element" class="form-control" value="{{ old('element') }}" dir="rtl" autocomplete="off" placeholder='id="contentDiv"'>
                                <small class="help-block">اولین فایل با پسوند مشخص شده در این المان، به کشتیداران منتقل می شود</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="duration" class="control-label col-md-3 col-sm-3 col-xs-12">دوره آپدیت</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration') }}" dir="rtl" autocomplete="off" placeholder="1800">
                                <small class="help-block">بر حسب دقیقه</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_link" class="control-label col-md-3 col-sm-3 col-xs-12">صفحه با محتوا داینامیک</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="url" name="last_link" id="last_link" class="form-control" value="{{ old('last_link') }}" dir="rtl" autocomplete="off" placeholder="http://sistan.ir/weather">
                                <small class="help-block">اگر وضعیت هواشناسی در قالب پست های داینامیک قرار می گیرد و فایل در آن پست ها قرار دارد، آدرس صفحه را وارد کنید</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_link_element" class="control-label col-md-3 col-sm-3 col-xs-12">المان حاوی محتوای داینامیک</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="last_link_element" id="last_link_element" class="form-control" value="{{ old('last_link_element') }}" dir="rtl" autocomplete="off" placeholder='id="contentDiv"'>
                                <small class="help-block">برای پست های داینامیک نزدیک ترین والدی که پست ها در آن آپدیت می شوند را وارد کنید</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="control-label col-md-3 col-sm-3 col-xs-12">محتوا</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="content" id="content" class="form-control tinymce">{{ old('content') }}</textarea>
                                <small class="help-block">محتوای دریافتی از سرور هواشناسی که قابل آپدیت است</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">تصویر</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="file" name="image" id="image" class="dropify">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="submit" class="btn btn-success" value="افزودن آیتم">
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
@include('admin/layouts/partials/tinymce')
