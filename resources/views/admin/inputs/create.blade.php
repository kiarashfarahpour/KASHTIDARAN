@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#add-option').click(function(e) {
                e.preventDefault();
                $("#clone-option").clone().attr('id', '').appendTo("#options tbody");
            });
            $('#add-rule').click(function(e) {
                e.preventDefault();
                $("#clone-rule").clone().attr('id', '').appendTo("#rules tbody");
            });
            $(document).on('click', '.remove-item',function () {
                $(this).closest('tr').remove();
            });
            $('#type').change(function () {
                if($(this).val() == 'select') {
                    $('#selectOptions').removeClass('hide')
                } else {
                    $('#selectOptions').addClass('hide')
                }
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
                        <h2>افزودن فیلد داینامیک</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a href="{{ route('admin.inputs.index', $form->id) }}">فیلدها
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="nav-tabs-custom no-shadow">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_general" data-toggle="tab" aria-expanded="true">عمومی</a>
                                </li>
                                <li>
                                    <a href="#tab_terms" data-toggle="tab" aria-expanded="false">قوانین</a>
                                </li>
                                <li id="selectOptions" class="hide">
                                    <a href="#tab_select" data-toggle="tab" aria-expanded="false">گزینه‌ها</a>
                                </li>
                            </ul>
                            <br>
                            <form action="{{ route('admin.inputs.store', $form->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                                @csrf
                                <div class="tab-content">
                                    <div id="tab_general" class="tab-pane active">
                                        <div class="form-group">
                                            <label for="label" class="control-label col-md-3 col-sm-3 col-xs-12">لیبل فیلد *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" name="label" id="label" class="form-control" value="{{ old('label') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">نوع فیلد *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select name="type" id="type" class="form-control">
                                                    <option value="text"{{ old('type') == 'text' ? ' selected' : '' }}>متن</option>
                                                    <option value="select"{{ old('type') == 'select' ? ' selected' : '' }}>انتخابی</option>
                                                    <option value="checkbox"{{ old('type') == 'checkbox' ? ' selected' : '' }}>چکباکس</option>
                                                    <option value="textarea"{{ old('type') == 'textarea' ? ' selected' : '' }}>تکست</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeholder" class="control-label col-md-3 col-sm-3 col-xs-12">متن جایگزین</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" name="placeholder" id="placeholder" class="form-control" value="{{ old('placeholder') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="sort_order" class="control-label col-md-3 col-sm-3 col-xs-12">ترتیب</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order') }}" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab_terms" class="tab-pane">
                                        <div class="table-responsive">
                                            <table id="rules" class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>قانون</th>
                                                    <th>مقدار</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td>
                                                        <button type="button" id="add-rule" class="btn btn-default btn-xs"><span class="fa fa-plus"></span> افزودن</button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="tab_select" class="tab-pane">
                                        <div class="table-responsive">
                                            <table id="options" class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>مقدار</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <button type="button" id="add-option" class="btn btn-default btn-xs"><span class="fa fa-plus"></span> افزودن</button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="submit" class="btn btn-success" value="افزودن فیلد">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <table class="hide">
        <tbody>
        <tr id="clone-rule">
            <td>
                <select name="rules[]" class="form-control">
                    <option value="required">اجباری</option>
                    <option value="min">حداقل طول</option>
                    <option value="max">حداکثر طول</option>
                    <option value="accepted">پذیرفتن</option>
                    <option value="url">لینک</option>
                    <option value="iran_phone">تلفن</option>
                    <option value="iran_mobile">موبایل</option>
                    <option value="address">آدرس</option>
                    <option value="iran_postal_code">کد پستی</option>
                    <option value="email">ایمیل</option>
                    <option value="numeric">اعداد صحیح</option>
                    <option value="digits_between">بازه عددی</option>
                    <option value="starts_with">شروع با</option>
                    <option value="alpha">حروف الفبای انگلیسی</option>
                    <option value="persian_alpha">حروف الفبای فارسی</option>
                    <option value="regex">عبارت باقاعده</option>
                </select>
            </td>
            <td><input type="text" name="values[]" class="form-control" dir="ltr"></td>
            <td>
                <button type="button" class="btn btn-danger btn-xs remove-item">
                    <span class="fa fa-trash"></span> حذف
                </button>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="hide">
        <tbody>
        <tr id="clone-option">
            <td><input type="text" name="options[]" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-danger btn-xs remove-item">
                    <span class="fa fa-trash"></span> حذف
                </button>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
