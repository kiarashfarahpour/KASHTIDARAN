@foreach($commercials as $commercial)
<div class="col-lg-3 col-md-6 mb-4 hvr-float">
    <div class="card lift h-100">
        <div class="ac-img">
            <a href="{{ route('frontend.commercials.show', $commercial->slug) }}">
                <img class="card-img-top" src="{{ asset(image_resize($commercial->image->name ?? $commercial->category->image->name ?? 'image/Rectangle-4.png', ['width' => 194, 'height' => 175])) }}" alt="{{ $commercial->title }}">
                <span class="r">{{ $commercial->id }}</span>
            </a>
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
                <i class="fas fa-map-marker-alt"></i>
                {{ $commercial->city->name }} @if($commercial->district_id) ، {{ $commercial->district->name }} @endif
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