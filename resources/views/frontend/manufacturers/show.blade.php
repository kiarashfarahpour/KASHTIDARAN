@extends('frontend.layouts.shop')
@section('title', $manufacturer->name)
@section('seo')
    <meta name="og:title" content="{{ $manufacturer->name }}">
@endsection
@section('styles')
    <link href="/css/category.css" rel="stylesheet">
@endsection
@section('content')
<div class="container-fliud cont-categori gap-col gap-col-mob">
    <div class="container ">
        <div class="row ">
            <div id="content" class="col-sm-12">
                <h2  class="title-page">{{ $manufacturer->name }}</h2>
                @if($manufacturer->image_id)
                <div class="part-img">
                    <img class="img-article" src="{{ asset(image_resize($manufacturer->image->name, ['width' => 200, 'height' => 120])) }}" class="img-fluid">
                </div>
                @endif
                <p>{{ $manufacturer->description }}</p>
                <div class="row">
					@foreach($products as $product)
						<div class="product-layout product-grid item col-lg-4 grid-group-item col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3  ">
							<div class="product-thumb list-view product-main-categori">
								<div class="image">
									<a href="{{ url('products/' . $product->slug) }}">
										<img src="{{ asset(image_resize($product->image_id, ['width' => 228, 'height' => 228])) }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-fluid">
									</a>
								</div>
								<div class="name-category">
									<a href="{{ url('products/' . $product->slug) }}">{{ $product->name }}</a>
								</div>
								<div class="desc-category">
									<div class="name-category lst-view">
										<a href="{{ url('products/' . $product->slug) }}">{{ $product->name }}</a>
									</div>
									<p>{{ str_limit(strip_tags($product->description)) }}</p>
								</div>
								<div class="price">
									<span class="price-new">{{ number_format($product->special ?? $product->price, 0) }} ریال</span>
									@unless(is_null($product->special))
										<span class="price-old">{{ number_format($product->price, 0) }} ریال</span>
									@endunless
								</div>
								@unless(is_null($product->special))
									<p class="off"><span>%{{ number_format(100 - $product->special * 100 / $product->price) }}<em>OFF</em></span></p>
								@endunless

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
										<a href="{{ route('frontend.products.show', ['product' => $product->slug]) }}" data-toggle="tooltip" data-placement="top" title="" class="red-tooltip" data-original-title="مشاهده جزئیات محصول">

											<i class="far fa-eye"></i>
										</a>
									</li>
								</ul>

							</div>
						</div>
					@endforeach
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left"></div>
                    <div class="col-sm-6 text-right">{{ $products->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>	
@endsection
