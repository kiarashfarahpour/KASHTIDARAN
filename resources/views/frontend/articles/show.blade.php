@extends('frontend.layouts.app')
@section('title', $article->title)
@section('seo')
    <meta name="keywords" content="{{ $article->meta_keywords }}">
    <meta name="description" content="{{ $article->meta_description }}">
    <meta name="og:title" content="{{ $article->title }}">
    <meta name="og:description" content="{{ $article->meta_description }}">
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
    <div class="container gap-col gap-col-mob mt-4">
      <div class="card ">
          <div class="card-body">
                     <div class="row">
        <div class="col-md-12 my-4">
            <article>
                <h1 class="main-title">{{ $article->title }}</h1>
                <div>
                    <span class="fa fa-clock-o"></span>
                    <span>تاریخ انتشار:</span>
                    <span>{{ jdate($article->created_at)->format('d F Y ساعت H:i') }}</span>
                    <span class="fa fa-clock-o"></span>
                    <span>تاریخ آپدیت:</span>
                    <span>{{ jdate($article->updated_at)->format('d F Y ساعت H:i') }}</span>
                </div>
                @if($article->image_id)
                    <div>
                        <img src="{{ asset($article->image->name) }}" class="img-fluid rounded mb-3 mb-md-0" alt="{{ $article->title }}">
                    </div>
                @endif
                <div>
                    {!! $article->content !!}
                </div>
                <div>
                    @foreach($article->groups as $group)
                        <a href="{{ route('frontend.categories.show', $group->slug) }}" class="btn btn-link">{{ $group->name }}</a>
                    @endforeach
                </div>
            </article>
        </div>
    </div>
    <hr>
    <div class="row row-message">
        <div class="row">
            <div class="col-md-12">
                @foreach($article->reviews as $review)
                    @if($loop->first)
                        <h4>نظرات</h4>
                    @endif
                    <div class="row my-2">
                        <div class="col-md-8 mr-auto ml-auto col-12">
                            <div class="card-body thumb-user">
                                <div class="row">
                                    <div class="col-sm-9 col-12 col-name">
                                        <small class="user-name text-muted">{{ $review->name }}</small>
                                    </div>
                                    <div class="col-sm-3 col-12 gap-col col-date">
                                        <p class="date-review color">{{ jdate($review->created_at)->format('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-12 content-review">
                                        <p>{!! nl2br(strip_tags($review->content)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($loop->last)
                        <hr>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-md-8 mr-auto ml-auto col-12">
            <p class="caption-sec" id="caption-sec">ثبت نظر </p>
            <form role="form" action="{{ route('frontend.reviews.store', $article->slug) }}" method="post" class="form-horizontal">
                @csrf
                <input type="hidden" id="article_slug" value="{{ $article->slug }}">
                <div class="row">
                    <div class="col-12 gap-col gap-col-mob">
                        <div class="form-group row">
                            <label for="name" class="label-control col-md-3">نام شما</label>
                            <input type="text" name="name" id="name" class="form-control input-sm col-md-9" placeholder="نام شما">
                        </div>
                    </div>
                    <div class="col-12 gap-col gap-col-mob">
                        <div class="form-group row">
                            <label for="mobile" class="label-control col-md-3">موبایل</label>
                            <input type="text" name="mobile" id="mobile" class="form-control input-sm col-md-9" placeholder="09123456789">
                        </div>
                    </div>
                    <div class="col-12 gap-col gap-col-mob">
                        <div class="form-group row">
                            <label for="content" class="label-control col-md-3">دیدگاه</label>
                            <textarea name="content" id="content" class="form-control message-box-review col-md-9" placeholder="متن پیام" cols="5" rows="8"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 gap-col gap-col-mob">
                        <div class="form-group">
                            <button type="button" id="submitReview" class="btn btn-comment">ارسال نظر</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
          </div>
      </div>
    </div>
@endsection
