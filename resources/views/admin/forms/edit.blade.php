@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش فرم</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.forms.index') }}">فرم‌ها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.forms.update', $form->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="name" class="control-label col-md-1 col-sm-3 col-xs-12">نام فرم *</label>
                            <div class="col-md-11 col-sm-9 col-xs-12">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $form->name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="checkbox" name="authenticated" id="authenticated" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-lock'></i> کاربران عضو" data-off="<i class='fa fa-global text-red'></i> فرم عمومی" data-width="125"{{ old('authenticated', $form->authenticated) ? ' checked' : '' }}>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="submit" class="btn btn-primary" value="ذخیره تغییرات">
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
