@extends('frontend.layouts.blank')
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
@section('content')
<div class="container gap-col gap-col-mob">
    <div class="row">
        <div class="col-12 gap-col gap-col-mob">
            <div class="card">
                <div class="card-body commercial-box-body">
                    <div class="alert alert-success">
                        <p>پرداخت شما با موفقیت انجام گردید.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
