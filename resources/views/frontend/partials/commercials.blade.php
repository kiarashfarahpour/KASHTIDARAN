@foreach($commercials as $commercial)
<div class="item">
    <div class="card h-100">
        <div class="ac-img">
            <a href="{{ route('frontend.commercials.show', $commercial->slug) }}">
                <img class="card-img-top" src="{{ asset(image_resize($commercial->image->name ?? $commercial->category->image->name ?? 'image/Rectangle-4.png', ['width' => 194, 'height' => 175])) }}" alt="{{ $commercial->title }}">
            </a>
            <span class="r">{{ $commercial->id }}</span>
        </div>
        <div class="card-body no-padding">
            <h4 class="mb-0">
                <a href="{{ route('frontend.commercials.show', $commercial->slug) }}">
                {{ $commercial->title }}
                </a>
            </h4>
        </div>
        <div class="card-footer bg-transparent d-flex align-items-center justify-content-between">
            <span class="small ">
                <i class="fas fa-map-marker-alt"></i> {{ $commercial->city->name }} @if($commercial->district_id) ، {{ $commercial->district->name }} @endif
            </span>
            @if($commercial->created_at->diffInDays(now()) <= 10)
                <span class="small">
                <i class="far fa-clock"></i>
                {{ jdate($commercial->created_at)->ago() }}
                </span>
            @endif
        </div>
    </div>
</div>
@endforeach
{{--<div class="row">
    @foreach($commercials as $commercial)
    <div class="col-sm-3">
        <a class="Bx-pro-sl" href="">
            <div class="tp-pic">
                <img class="pic-pro" src="{{ asset(image_resize($commercial->image->name ?? $commercial->category->image->name ?? 'images/mob/pic/pc1.png', ['width' => 201, 'height' => 155])) }}" alt="{{ $commercial->title }}">
                <div class="ad-abs"><p>آگهی فروش {{ $commercial->id }}</p></div>
            </div>
            <div class="btm-explain">
                <h5 class="title-pro">{{ $commercial->title }}</h5>
                <div class="row-time-loc">
                    <p>
                        <span class="Location"></span>
                        @if($commercial->created_at->diffInDays(now()) <= 10)
                        / <span class="Time">{{ jdate($commercial->created_at)->ago() }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </a>
    </div>
    @endforeach

</div>--}}
