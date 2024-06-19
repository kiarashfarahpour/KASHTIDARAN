<!-- product filter shows in sm and smaller -->
<div class="col-sm-12 d-block d-sm-none py-3 d-flex justify-content-center">
    <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#filterModal">
        جستجوی پیشرفته
        <i class="fas fa-filter"></i>
        <!-- <i class="fas fa-list-ul"></i> -->
    </button>
</div>
<!-- /product filter sm  -->
<!-- product filter shows in md and larger -->
<div class="col-lg-3 col-md-4 text-right d-none d-md-block" id="feature">
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>دسته بندی</h2>
                <span class="divider"></span>
            </div>
            <div class="form-group frm-city">
                <select id="categoryFilter" class="custom-select f-input all-categori form-control applyFilter">
                    <option value="" selected>همه دسته‌بندی‌ها</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if($districts->count())
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>دسته بندی</h2>
                <span class="divider"></span>
            </div>
            <div class="form-group frm-city">
                <select id="districtFilter" class="custom-select f-input all-city form-control applyFilter">
                    <option value="">محله را انتخاب کنید</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endif
    @isset($category)
        @if($category->fields->count())
            @foreach($category->fields as $field)
                @switch($field->type)
                    @case('select')
                    <div class="card filter-panel mb-3">
                        <div class="card-body">
                            <div class="divided">
                                <h2>دسته بندی</h2>
                                <span class="divider"></span>
                            </div>
                            <div class="form-group">
                                <label for="field{{ $loop->iteration }}"
                                       class="control-label col-12">{{ $field->label }}</label>
                                <select name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" data-field="{{ $field->id }}" class="form-control f-input fieldFilter applyFilter" dir="rtl">
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
                    <div class="card filter-panel mb-3">
                        <div class="card-body">
                            <div class="divided">
                                <h2>دسته بندی</h2>
                                <span class="divider"></span>
                            </div>
                            <li>
                                <label class="fa-check-form">
                                    <input type="checkbox" value="{{ $field->id }}" id="field{{ $loop->iteration }}-param-2" class="applyFilter f-input switchFilter filterSwitcher">
                                    <span class="checkmark"></span>
                                </label>
                                <span>{{ $field->label }}</span>
                            </li>
                            <li>
                                <label class="fa-check-form">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <span>شناور</span>
                            </li>
                            <li>
                                <label class="fa-check-form">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <span>شناور</span>
                            </li>
                        </div>
                    </div>
                    @break
                @endswitch
            @endforeach
        @endif
    @endisset
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>عکس دار</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox" value="1" name="has_selling_stock" id="stock_status-param-1" class="filterSwitcher">
                    <span class="checkmark"></span>
                </label>
                <span>عکس دار</span>
            </li>
        </div>
    </div>
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>فوری</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox" value="1" name="has_selling_stock" id="isImmediate" class="filterSwitcher">
                    <span class="checkmark"></span>
                </label>
                <span>VIP</span>
            </li>
        </div>
    </div>
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>ویژه</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox" value="1" name="has_selling_stock" id="stock_status-param-2" class="filterSwitcher">
                    <span class="checkmark"></span>
                </label>
                <span>ویژه</span>
            </li>
        </div>
    </div>
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>جستجو</h2>
                <span class="divider"></span>
            </div>
            <li>
                <input type="text" class="form-control f-input" id="phrase2" name="phrase" placeholder="جستجو کنید...">
            </li>
            <li class="search-btn">
                <button id="applyFilter2" class="btn btn-search form-control" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </li>
        </div>
    </div>
    {{--<div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>دسته بندی</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <span>شناور</span>
            </li>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <span>شناور</span>
            </li>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <span>شناور</span>
            </li>
        </div>
    </div>
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>دسته بندی</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <span>شناور</span>
            </li>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <span>شناور</span>
            </li>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <span>شناور</span>
            </li>
            <div class="collapse" id="collapseExample">
                <li>
                    <label class="fa-check-form">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <span>شناور</span>
                </li>
            </div>
        </div>
        <div class="card-footer bg-transparent  d-flex justify-content-center">
            <span class="small " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                مشاهده بیشتر
                <i class="fas fa-angle-down"></i>
            </span>
        </div>
    </div>
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h6>قیمت</h6>
                <span class="divider"></span>
            </div>
            <!-- <div class="price-range wrapper m-b-50 p-l-r">
                <div class="slider-keypress m-b-20"></div>
                <ul class="cost-rang mt-4 d-flex justify-content-around">
                    <li>
                       از
                       <input class="form-control f-input" type="number" class="min-value" value="">
                    </li>
                    <li>
                       تا
                       <input class="form-control f-input" type="number" class="max-value" value="">
                    </li>
                  </ul>
              </div> -->
        </div>
    </div>--}}
    <div class=" filter-panel mb-4">
        <img class="w-100" src="{{ asset('image/Layer 4.png') }}" alt="">
    </div>
    <div class=" filter-panel mb-3 px-2 no-box-shadow">
        <div class=" d-flex justify-content-around">
            <img class="" src="{{ asset('image/logo-copy.png') }}" alt="">
            <img class="" src="{{ asset('image/97734e8887c3f9459e78a4a6db37ce16.png') }}" alt="">
            <img class="" src="{{ asset('image/enamad2.d5a09dbe435d2af85eaa9db515c95fcb.png') }}" alt="">
        </div>
        <p class="txt-grey text-center mt-3">تمامی حقوق مادی و معنوی برای سایت کشتی داران محفوظ است</p>
    </div>
</div>
<!-- product filter md -->
<!-- /filter -->
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="feature">
                <div class="text-right">
                     <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>دسته بندی</h2>
                <span class="divider"></span>
            </div>
            <div class="form-group frm-city">
                <select id="categoryFilter" class="custom-select f-input all-categori form-control applyFilter">
                    <option value="" selected>همه دسته‌بندی‌ها</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if($districts->count())
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>دسته بندی</h2>
                <span class="divider"></span>
            </div>
            <div class="form-group frm-city">
                <select id="districtFilter" class="custom-select f-input all-city form-control applyFilter">
                    <option value="">محله را انتخاب کنید</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endif
    @isset($category)
        @if($category->fields->count())
            @foreach($category->fields as $field)
                @switch($field->type)
                    @case('select')
                    <div class="card filter-panel mb-3">
                        <div class="card-body">
                            <div class="divided">
                                <h2>دسته بندی</h2>
                                <span class="divider"></span>
                            </div>
                            <div class="form-group">
                                <label for="field{{ $loop->iteration }}"
                                       class="control-label col-12">{{ $field->label }}</label>
                                <select name="fields[{{ $field->id }}]" id="field{{ $loop->iteration }}" data-field="{{ $field->id }}" class="form-control f-input fieldFilter applyFilter" dir="rtl">
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
                    <div class="card filter-panel mb-3">
                        <div class="card-body">
                            <div class="divided">
                                <h2>دسته بندی</h2>
                                <span class="divider"></span>
                            </div>
                            <li>
                                <label class="fa-check-form">
                                    <input type="checkbox" value="{{ $field->id }}" id="field{{ $loop->iteration }}-param-2" class="applyFilter f-input switchFilter filterSwitcher">
                                    <span class="checkmark"></span>
                                </label>
                                <span>{{ $field->label }}</span>
                            </li>
                            <li>
                                <label class="fa-check-form">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <span>شناور</span>
                            </li>
                            <li>
                                <label class="fa-check-form">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <span>شناور</span>
                            </li>
                        </div>
                    </div>
                    @break
                @endswitch
            @endforeach
        @endif
    @endisset
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>عکس دار</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox" value="1" name="has_selling_stock" id="stock_status-param-1" class="filterSwitcher">
                    <span class="checkmark"></span>
                </label>
                <span>عکس دار</span>
            </li>
        </div>
    </div>
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>ویژه</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox" value="1" name="has_selling_stock" id="stock_status-param-2" class="filterSwitcher">
                    <span class="checkmark"></span>
                </label>
                <span>ویژه</span>
            </li>
        </div>
    </div>
	    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>فوری</h2>
                <span class="divider"></span>
            </div>
            <li>
                <label class="fa-check-form">
                    <input type="checkbox" value="1" name="has_selling_stock" id="isImmediate2" class="filterSwitcher">
                    <span class="checkmark"></span>
                </label>
                <span>VIP</span>
            </li>
        </div>
    </div>
    <div class="card filter-panel mb-3">
        <div class="card-body">
            <div class="divided">
                <h2>جستجو</h2>
                <span class="divider"></span>
            </div>
            <li>
                <input type="text" class="form-control f-input" id="phrase" name="phrase" placeholder="جستجو کنید...">
            </li>
            <li class="search-btn">
                <button id="applyFilter" class="btn btn-search form-control" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </li>
        </div>
    </div>
 
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /modal -->
