@extends('frontend.layouts.app')
@section('title', $category->title)
@section('seo')
    <meta name="keywords" content="{{ $category->meta_keywords }}">
    <meta name="description" content="{{ $category->meta_description }}">
    <meta name="og:title" content="{{ $category->title }}">
    <meta name="og:description" content="{{ $category->meta_description }}">
@endsection
@section('styles')
      <style>
        .content {
            width: 100% !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
            min-height: 100vh;
        }
    </style>
@endsection
@section('content')

       <div class="container gap-col gap-col-mob mt-3">
        <div class="row mt-5">
            <div class="col-md-12">
                <h1 class="title-news">{{ $category->name }}</h1>
            </div>
        </div>
        @foreach($category->articles->chunk(3) as $items)
        <div class="row">
            @foreach($items as $article)
            <div class="col-md-4 my-4">
                <article class="card">
                   <div class="card-body">
                        <h1 class="main-title">{{ $article->title }}</h1>
                    @if($article->image_id)
                        <div>
                            <img src="{{ asset(image_resize($article->image->name, ['width' => 200, 'height' =>200])) }}" class="img-fluid rounded mb-3 mb-md-0" alt="{{ $article->title }}">
                        </div>
                    @endif
                    <div>
                        {!! words(strip_tags($article->content)) !!}
                    </div>
                    <a href="{{ route('frontend.blog.show', $article->slug) }}" class="btn btn-primary btn-sm">ادامه مطلب</a>
                   </div>
                </article>
            </div>
            @endforeach
        </div>
        @endforeach
        <hr>
        {{ $category->articles->links() }}
    </div>

@endsection
