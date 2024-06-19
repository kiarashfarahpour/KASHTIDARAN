@extends('frontend.layouts.shop')
@section('title', 'محصولات')
@section('seo')
    <meta name="og:title" content="محصولات">
@endsection
@section('styles')
    <link href="/css/category.css" rel="stylesheet">
    @endsection
@section('content')
<div class="container container-pro">
    <div class="row mt-4 mb-4">
        <div id="content" class="col-sm-12">
            <h2 class="title-page">محصولات</h2>
            <div class="row">
                @foreach($products as $product)
                <div class="product-layout product-grid item  grid-group-item  col-md-3   col-12">
                    <div class="product-thumb list-view product-main-categori">
                        @if($product->image_id)
                        <div class="image">
                            <a href="{{ url('products/' . $product->slug) }}">
                                <img src="{{ asset(image_resize($product->image->name, ['width' => 228, 'height' => 228])) }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-fluid">
                            </a>
                        </div>
                        @endif
                        <div class="img-brand">
                            <a href="{{ url('manufacturers/' . $product->manufacturer->slug) }}">
                                <!--{{ $product->manufacturer->name}}-->
                                @if($product->manufacturer->logo)
                                <img src="{{ asset(\App\ImageManager::resize($product->manufacturer->logo, ['width' => 100, 'height' => 30])) }}" alt="{{ $product->manufacturer->name }}" title="{{ $product->manufacturer->name }}" class="img-fluid">
                                @endif
                                <span class="name-pr">{{ $product->manufacturer->name }}</span>
                            </a>
                        </div>
                        <div class="name-category">
                            <a href="{{ url('products/' . $product->slug) }}">{{ $product->name }}</a>
                        </div>
                        <div class="desc-category">
                            <!--<div class="name-category lst-view">-->
                            <!--    <a href="{{ url('products/' . $product->slug) }}">{{ $product->name }}</a>-->
                            <!--</div>-->
                            <p>{{ str_limit(strip_tags($product->description)) }}</p>
                        </div>
                        @unless($product->stock)
                        <p class="price-product">
                            <strong class="text-muted">ناموجود</strong>
                        </p>
                        @else
                        <div class="price__product">
                            <span>
                                @unless(is_null($product->special))
                                <span class="offer"> %
                                    <span class="offer-value">{{ number_format(100 - $product->special * 100 / $product->price) }}</span>
                                </span>
                                @endunless
                                @unless(is_null($product->special))
                                <span class="price-old">{{ number_format($product->price, 0) }} </span>
                                @endunless
                            </span>
                            <span>
                                <span class="price-product">{{ number_format($product->special ?? $product->price, 0) }} </span>
                                ریال
                            </span>
                        </div>
                        @endunless
                        @unless(is_null($product->special))
                        <p class="off"><span>فروش ویژه</span></p>
                        @endunless
                        <div class="row d-none-xl d-none-lg d-none-md lst-mob">
                            <ul class="icon">
                                <li class="add-to-card ajax-form">
                                    <input type="hidden" class="productId" value="{{ $product->id }}">
                                    <input type="hidden" class="quantity" value="1">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title data-original-title="اضافه به سبد خرید" class="addToCart">
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                </li>
                                <li class="compare-list addToCompare">
                                    <input type="hidden" class="productId" value="{{ $product->id }}">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="مقایسه محصول">
                                        <i class="fas fa-balance-scale"></i>
                                    </a>
                                </li>
                                <li class="wish-list addToWishlist">
                                    <input type="hidden" class="productId" value="{{ $product->id }}">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="اضافه به لیست علاقه مندی">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                </li>
                                <li class="view">
                                    <a href="{{ route('frontend.products.show', $product->slug) }}" data-toggle="tooltip" data-placement="top" title="" class="red-tooltip" data-original-title="مشاهده جزئیات محصول">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <ul class="icon">
                            <li class="add-to-card ajax-form">
                                <input type="hidden" class="productId" value="{{ $product->id }}">
                                <input type="hidden" class="quantity" value="1">
                                <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="اضافه به سبد خرید" class="addToCart">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </li>
                            <li class="compare-list addToCompare">
                                <input type="hidden" class="productId" value="{{ $product->id }}">
                                <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="مقایسه محصول">
                                    <i class="fas fa-balance-scale"></i>
                                </a>
                            </li>
                            <li class="wish-list addToWishlist">
                                <input type="hidden" class="productId" value="{{ $product->id }}">
                                <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="اضافه به لیست علاقه مندی">
                                    <i class="fas fa-heart"></i>
                                </a>
                            </li>
                            <li class="view">
                                <a href="{{ route('frontend.products.show', $product->slug) }}" data-toggle="tooltip" data-placement="top" title="" class="red-tooltip" data-original-title="مشاهده جزئیات محصول">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 text-center">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
