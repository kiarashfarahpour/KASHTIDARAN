<div id="accordion" class="myaccordion">
    @foreach($mainCategories as $category)
    <div class="body">
        <div class="card-header" id="heading-{{ $loop->iteration }}">
            <h2 class="mb-0">
                <button type="button" class="d-flex align-items-center justify-content-between btn btn-link" data-toggle="collapse" data-target="#collapse-{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse-{{ $loop->iteration }}">
                    @if($category->image_id)
                    <img class="Ad-icon" src="{{ asset(image_resize($category->image->name, ['width' => 45, 'height' => 45])) }}" alt="image">
                    @else
                    <img class="Ad-icon" src="/images/icons/ic1.png">
                    @endif
                    <span class="nam-e">{{ $category->name }}</span>
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                    </span>
                </button>
            </h2>
        </div>
        <div id="collapse-{{ $loop->iteration }}" class="collapse" aria-labelledby="heading-{{ $loop->iteration }}" data-parent="#accordion">
            <div class="card-body">
                {{--<div class="PRT_sel-buy-btn">
                    <div class="container">
                        <div class="content Radi-O">
                    		<div class="segmentedControl">
                    			<span class="segmentedControl--group">
                    				<input type="radio" name="aspectRatio" id="aspectRatio-1" />
                    				<label class="label label-one" for="aspectRatio-1">خریدار هستم</label>
                    			</span>
                    			<span class="segmentedControl--group">
                    				<input type="radio" name="aspectRatio" id="aspectRatio-2" />
                    				<label class="label label-two" for="aspectRatio-2">فروشنده هستم</label>
                    			</span>
                    		</div>
                        </div>
                    </div>
                </div>--}}
                @foreach($category->children as $child)
                <a class="box-linkS d-block" href="{{ route('frontend.commercials.create', [$routeParameters['city'], $child->slug]) }}">
                    @if($child->image_id)
                    <img src="{{ asset(image_resize($child->image->name, ['width' => 45, 'height' => 45])) }}"><br>
                    @endif
                    {{ $child->name }}
                </a>
                @endforeach
                {{--<div class="text-center float-right" style="width:100%">
                    <a href="#" class="other-item">سایر  {{ $category->name }}</a>
                </div>--}}
            </div>
        </div>
    </div>
    @endforeach
</div>
<script>
    $(".myaccordion").on("hide.bs.collapse show.bs.collapse", e => {
        $(e.target).
        prev().
        find("i:last-child").
        toggleClass("fa-minus fa-plus");
    });
</script>