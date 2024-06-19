<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <div class="site-filtering">
                <h2 class="main-title-box">جستجو پیشرفته</h2>
                <div class="accordian-filter" id="accordion" role="tablist" aria-multiselectable="true">
                    <!-- Accordion Item 1 -->
                    <div class="card">
                        <div class="card-header" role="tab" id="accordionHeadingOne">
                            <a data-toggle="collapse" data-parent="#accordion" href="#accordionBodyOne" aria-expanded="false" aria-controls="accordionBodyOne" class="collapsed ">
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                <h3 class="title-filter">جستجو بر اساس قدرت موتور</h3>
                            </a>
                        </div>
                        <div id="accordionBodyOne" class="collapse" role="tabpanel" aria-labelledby="accordionHeadingOne" aria-expanded="false" data-parent="accordion">
                            <div class="accordionBody">
                                <form>
                                  <input class="check-box" type="checkbox" id="item1" name="item-1" value="Apple">
                                  <label class="title-checkBox" for="item1">110 kW</label>
                                  <input class="check-box" type="checkbox" id="item2" name="item-2" value="Banana">
                                  <label class="title-checkBox" for="item2">120 kW</label>
                                  <input class="check-box" type="checkbox" id="item3" name="item-3" value="Cherry">
                                  <label class="title-checkBox" for="item3">130 kW</label>
                                  <input class="check-box" type="checkbox" id="item4" name="item-4" value="Strawberry">
                                  <label class="title-checkBox" for="item4">140 kW</label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion Item 2 -->
                    <div class="card">
                        <div id="accordionBodyTwo" class="" role="tabpanel" aria-labelledby="accordionHeadingTwo" aria-expanded="false" data-parent="accordion">
                            <div class="accordionBody">
                                <label class="switch-OffOn">
                                  <input type="checkbox">
                                  <div class="circle"></div>
                                  <div class="rope"></div>
                                </label>
                                <h3 class="title-filter">فقط کالاهای موجود</h3>
                            </div>
                        </div>
                    </div>
                    @isset($category)
                        @if($category->fields->count())
                            @foreach($category->fields as $field)
                                <div class="card">
                                @switch($field->type)
                                    @case('select')
                                    <div class="card-header" role="tab" id="accordionHeading{{ $loop->iteration }}">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#accordionBody{{ $loop->iteration }}" aria-expanded="false" aria-controls="accordionBody{{ $loop->iteration }}" class="collapsed ">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            <h3 class="title-filter">جستجو بر اساس {{ $field->label }}</h3>
                                        </a>
                                    </div>
                                    <div id="accordionBody{{ $loop->iteration }}" class="collapse" role="tabpanel" aria-labelledby="accordionHeading{{ $loop->iteration }}" aria-expanded="false" data-parent="accordion">
                                        <div class="accordionBody">
                                            <div class="form-group">
                                                <label for="field{{ $loop->iteration }}"
                                                       class="control-label col-12">{{ $field->label }}</label>
                                                <select name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" data-field="{{ $field->id }}" class="form-control fieldFilter applyFilter" dir="rtl">
                                                    <option value="">{{ $field->label }} را انتخاب کنید</option>
                                                    @foreach($field->options as $option)
                                                        <option value="{{ $option }}" {{ (old('fields.' . $field->id) == $option ? '
                                                        selected' : '') }}>{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                    @case('checkbox')
                                    <div class="card-header" role="tab" id="accordionHeading{{ $loop->iteration }}">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#accordionBody{{ $loop->iteration }}" aria-expanded="false" aria-controls="accordionBody{{ $loop->iteration }}" class="collapsed ">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            <h3 class="title-filter">جستجو بر اساس  {{ $field->label }}</h3>
                                        </a>
                                    </div>
                                    <div id="accordionBody{{ $loop->iteration }}" class="collapse" role="tabpanel" aria-labelledby="accordionHeading{{ $loop->iteration }}" aria-expanded="false" data-parent="accordion">
                                        <div class="accordionBody">
                                            <div class="c-filter c-filter--switcher js-box-content-items">
                                                <label class="c-ui-statusswitcher">
                                                    <span>{{ $field->label }}</span>
                                                    <input type="checkbox" value="{{ $field->id }}" id="field{{ $loop->iteration }}-param-2" class="applyFilter switchFilter filterSwitcher">
                                                    <span class="c-ui-statusswitcher__slider">
                                                        <span class="c-ui-statusswitcher__slider__toggle"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @endswitch
                                </div>
                            @endforeach
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="Ad-category">
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
                            <div class="PRT_sel-buy-btn">
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
                            </div>
                            @foreach($category->children as $child)
                            <a class="box-linkS d-block" href="#">{{ $child->name }}</a>
                            @endforeach
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
        </div>
        </div>
    </div>
</div>
