@extends('frontend.layouts.app')
@section('scripts')
    <script>
        $('.owl-weather').owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            rtl: true,
            nav: true,
            dot: false,
            items: 5,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5,
                    // loop: false,
                    autoplay: false,
                    // mouseDrag: false,
                    autoplayTimeout: 5000,
                    nav: true,
                    dot: false,
                }
            }
        })
    </script>
@endsection
@section('content')
    <section id="province-head" class="container-fluid">
        <h1 class="h5 text-center">{{ $weather->name }}</h1>
        <p class="text-center"><i class="fa fa-clock"></i> {{ jdate()->format('l d F Y | H:i:s') }}</p>
    </section>
    <section class="container py-5">
        <div class="row" style="direction: ltr">
            <div class="owl-carousel owl-theme owl-weather owl-loaded" id="owl-w" >
                <div class="owl-stage-outer ">
                    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2070px;">
                        @foreach($weather->items as $item)
                            <div class="owl-item" style="width: 220px; margin-right: 10px;">
                                <div class="item card card-body">
                                    <div class="w-card h-100">
                                        <div class="w-ac-img">
                                            <a href="{{ $item->link }}">
                                                <img class="w-card-img-top" src="{{ asset(image_resize($item->image->name ?? 'image/Rectangle-4.png', ['width' => 175, 'height' => 175])) }}" alt="{{ $item->name }}">
                                            </a>
                                        </div>
                                        <div class="w-card-body no-padding">
                                            <h4 class="mb-0 text-center w-card-text">
                                                <a href="{{ $item->link }}">
                                                {{ $item->title }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="owl-nav disabled ">
                    <button type="button" role="presentation" class="owl-prev w-prev">
                        <span aria-label="Previous">‹</span>
                    </button>
                    <button type="button" role="presentation" class="owl-next w-next">
                        <span aria-label="Next">›</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
