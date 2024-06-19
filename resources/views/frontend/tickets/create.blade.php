@extends('frontend.layouts.shop')
@section('content')
    <div class="container">
        <div class="row">
            <div id="content" class="col-sm-12 card card-body my-4">
                <h1>تیکت‌ها</h1>
                <form action="{{ route('frontend.tickets.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <legend>ارسال تیکت جدید</legend>
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-3 control-label">عنوان</label>

                            <div class="col-md-9">
                                <input id="title" type="text" class="form-control f-input" name="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="col-md-3 control-label">الویت</label>

                            <div class="col-md-9">
                                <select id="priority" type="" class="form-control f-input" name="priority">
                                    <option value="">انتخاب کنید</option>
                                    <option {{ old('priority') == 'low' ? 'selected' : '' }} value="low">کم</option>
                                    <option {{ old('priority') == 'medium' ? 'selected' : '' }} value="medium">متوسط
                                    </option>
                                    <option {{ old('priority') == 'high' ? 'selected' : '' }} value="high">زیاد</option>
                                </select>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-3 control-label">متن شما</label>
                            <div class="col-md-9">
                                <textarea rows="10" id="message" class="form-control f-input" name="message"></textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        {{--<div id="attachment-wrapper" class="d-none">
                            <div class="form-group attachment">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <input type="file" class="form-control" name="attachment[]" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('attachment.1') ? ' has-error' : '' }} attachment">
                            <label for="attachment" class="col-md-3 control-label">فایل ضمیمه</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" name="attachment[]" value="{{ old('attachment.1') }}" multiple>

                                @if ($errors->has('attachment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('attachment.1') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>--}}
                    </fieldset>
                    <div class="buttons clearfix">
                        <div class="float-left">
                            <a href="{{ route('frontend.tickets.index') }}" class="btn btn-default">
                                <span class="fa fa-angle-right"></span>
                                بازگشت
                            </a>
                        </div>
                        <div class="float-right">
                            <input type="submit" value="ارسال تیکت" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
