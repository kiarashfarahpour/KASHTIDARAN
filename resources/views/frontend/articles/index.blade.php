@extends('frontend.layouts.app')
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
  <div class="container">
          <div class="row">
        <div class="col-md-12 my-4">
            <h1 class="main-title">مجله دریایی</h1>
        </div>
    </div>
    @forelse($articles as $article)
    <article class="row">
        <div class="col-md-3">
            <a href="{{ route('frontend.blog.show', $article->slug) }}">
                <img class="img-fluid rounded mb-3 mb-md-0" src="{{ asset(image_resize($article->image->name ?? 'images/default.jp', ['width' => 260, 'height' => 180])) }}" alt="{{ $article->title }}">
            </a>
        </div>
        <div class="col-md-8">
            <h3 class="sub-title">{{ $article->title }}</h3>
            <p>{!! words(strip_tags($article->content), 60) !!}</p>
            <hr>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('frontend.blog.show', $article->slug) }}">ادامه مطلب</a>
        </div>
    </article>
    <hr>
    @empty
        <div class="alert alert-warning">
            <p>هیچ مطلبی در مجله دریایی منتشر نشده است!</p>
        </div>
    @endforelse
    <div>
        {{ $articles->links() }}
    </div>
  </div>
@endsection
