@extends('frontend.layouts.app')
@section('title', 'نتایج جستجو')
@section('content')
<section class=" mt-4 container nav-container" id="archive">
    <div class="row">
        @include('frontend.partials.sidebar')
        <div class="col-lg-9 col-md-8" id="product-list">
            <div id="commercial-data" class="row">
                @include('frontend.partials.city-commercials')
            </div>
            {{ $commercials->links() }}
        </div>
    </div>
</section>
@endsection
