<div class="row">
    @foreach($commercials as $commercial)
<div class="col-sm-3">
    <a class="Bx-pro-sl" href="{{ route('frontend.commercials.show', $commercial->slug) }}">
        <div class="tp-pic">
            <img class="pic-pro" src="{{ asset(image_resize($commercial->image->name ?? $commercial->category->image->name ?? 'images/mob/pic/pc1.png', ['width' => 201, 'height' => 155])) }}" alt="{{ $commercial->title }}">
            <div class="ad-abs"><p>آگهی فروش {{ $commercial->id }}</p></div>
        </div>
        <div class="btm-explain">
            <h5 class="title-pro">{{ $commercial->title }}</h5>
            <div class="row-time-loc">
                <p>
                    <span class="Location">{{ $commercial->city->name }} @if($commercial->district_id) ، {{ $commercial->district->name }} @endif</span>
                    @if($commercial->created_at->diffInDays(now()) <= 10)
                    / <span class="Time">{{ jdate($commercial->created_at)->ago() }}</span>
                    @endif
                </p>
            </div>
        </div>
    </a>
</div>
@endforeach

</div>
