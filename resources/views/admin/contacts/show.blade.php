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
                    <h2>مشاهده پیام</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.contacts.index') }}">پیام‌ها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>صفحه</th>
                                    <th>کاربر</th>
                                    <th class="text-left">ip</th>
                                    <th class="text-left">User Agent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.pages.edit', $contact->page->slug) }}" class="btn btn-link">{{ $contact->page->title }}</a>
                                    </td>
                                    <td>
                                        {{ $contact->user->name ?? 'کاربر مهمان' }}
                                    </td>
                                    <td class="text-left">{{ $contact->ip }}</td>
                                    <td class="text-left">{{ $contact->user_agent }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h2>{{ $contact->form->name }}</h2>
                    <div class="table-responsive">
                        <table class="table table-strip table-hover">
                            <tbody>
                                @foreach($contact->inputs as $input)
                                <tr>
                                    <th>{{ $input->label }}</th>
                                    <td>{{ $input->pivot->value }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection
@include('admin/layouts/partials/tinymce')
