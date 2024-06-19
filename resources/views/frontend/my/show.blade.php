@extends('frontend.layouts.shop')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/nouislider.min.css') }}">
    <style>
        .content {
            width: 100% !important;
            background-color: #fff !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
@endsection
@section('content')
    @if($settings['notice'])
    <div class="container">
        <div class="row mt-2">
            <div class="col-12 gap-col-mob">
                {!! $settings['notice'] !!}
            </div>
        </div>
    </div>
    @endif
    <section class=" mt-4 container nav-container" id="profile">
        <div class="row">
            <!-- sidebar -->
            <div class="col-lg-3 col-md-4 text-right" id="sidebar">
                <div class="card profile-panel mb-3 w-100">
                    <div class="card-body">
                        <div class="pro-card-head d-flex align-items-center flex-column">
                            <img calss="profile-image" src="image/Layer-1.png" alt="">
                            <span class="txt-blue">{{ $auth_user->name }}</span>
                            <span class="txt-blue">{{ $auth_user->mobile }}</span>
                        </div>
                        <div class="pro-card-body txt-grey small">
                            <div class="row  d-flex align-items-center justify-content-between py-2 border-bottom">
                                <span class="col-6">آگهی های ثبت شده</span>
                                <span class="col-6 text-left">{{ $count['commercial'] }}</span>
                            </div>
                            <div class="row  d-flex align-items-center justify-content-between py-2 border-bottom">
                                <span class="col-6">تعداد بازدیدهای شما</span>
                                <span class="col-6 text-left">{{ $count['view_counts'] }}</span>
                            </div>
                            <div class="row  d-flex align-items-center justify-content-between py-2 border-bottom">
                                <span class="col-6">آگهی های نشان شده</span>
                                <span class="col-6 text-left">{{ $count['bookmarks'] }}</span>
                            </div>
                            <div class="row  d-flex align-items-center justify-content-between py-2 ">
                                <span class="col-6">پرداخت ها</span>
                                <span class="col-6 text-left">{{ $count['payments'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /sidebar -->
            <!-- content -->
            <div class="col-lg-9 col-md-8" id="profile-content">
                <div class="row">
                    <div class="w-100">
                        <ul id="myTabs" class="nav nav-pills nav-justified no-padding" role="tablist" data-tabs="tabs">
                            <li class="active">
                                <a href="#my-adv" data-toggle="tab">آگهی‌های من </a>
                            </li>
                            <li>
                                <a href="#bookmarks" data-toggle="tab">نشان شده</a>
                            </li>
                            <li>
                                <a href="#info" data-toggle="tab">ویرایش اطلاعات</a>
                            </li>
                        </ul>
                        <div class="tab tab-content border-0 rounded-0 shadow-none p-0">
                            <div id="my-adv" role="tabpanel" class="tab-pane fade in active show mt-3">
                                <div class="table-responsive" style="overflow-x: auto;">
                                    <table class="table text-right my-adv-tb">
                                        <thead class="my-adv-table-head text-center no-border">
                                            <tr>
                                                <th style="background: white;"></th>
                                                <th scope="col bg-white" style="background: white;">تصویر</th>
                                                <th scope="col">عنوان آگهی</th>
                                                <th scope="col">شهر</th>
                                                <th scope="col">تاریخ انتشار</th>
                                                <th scope="col">وضعیت</th>
                                                <th scope="col">تعداد بازدید</th>
                                                <th scope="col">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($commercials as $commercial)
                                            <tr>
                                                <th scope="row bg-white">1</th>
                                                <td scope=" bg-white" style="background: white;">
                                                    <a href="{{ route('frontend.commercials.show', $commercial->slug) }}">
                                                        <img calss="tbl-image" src="{{ asset(image_resize($commercial->image->name ?? 'image/Rectangle-4.png', ['width' => 80, 'height' => 80])) }}" alt="{{ $commercial->title }}">
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('frontend.commercials.show', $commercial->slug) }}">{{ $commercial->title }}<a/>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('frontend.cities.show', $commercial->city->slug) }}">{{ $commercial->city->name ?? '' }}</a>
                                                </td>
                                                <td class="text-center">{{ $commercial->created_at->ago() }}</td>
                                                @if($commercial->status == 0)
                                                    <td class="text-primary text-center">
                                                        در حال بررسی
                                                    </td>
                                                @elseif($commercial->status == 1)
                                                    <td class="text-success text-center">
                                                        تایید شده
                                                    </td>
                                                @elseif($commercial->status == 1)
                                                    <td class="text-danger text-center">
                                                        رد شده
                                                    </td>
                                                @endif
                                                <td class="text-center">0</td>
                                                <td class="text-center">
                                                    <a href="">
                                                        <i class="far fa-trash-alt text-danger"></i>
                                                    </a>
                                                    <a href="{{ route('frontend.commercials.edit', $commercial->slug) }}" class="mr-1" title="ویرایش">
                                                        <i class="fas fa-pen text-primary"></i>
                                                    </a>
                                                    <button type="button" class="border-0 bg-white text-info" data-toggle="modal" data-target="#manHastam{{ $loop->index }}" title="من هستم">
                                                      <span class="fas fa-bell"></span>
                                                    </button>
                                                    <a href="{{ route('frontend.promotes.show', $commercial->slug) }}" title="ارتقا آگهی">
                                                        <i class="fas fa-layer-group text-primary"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">
                                                        هنوز آگهی ارسال نکرده‌اید!
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $commercials->links() }}
                                </div>
                            </div>
                            <div id="bookmarks" role="tabpanel" class="tab-pane fade in mt-3">
                                <div class="table-responsive" style="overflow-x: auto;">
                                    <table class="table text-right my-adv-tb">
                                        <thead class="my-adv-table-head text-center no-border">
                                            <tr>
                                                <th style="background: white;"></th>
                                                <th scope="col bg-white" style="background: white;">تصویر</th>
                                                <th scope="col">عنوان آگهی</th>
                                                <th scope="col">شهر</th>
                                                <th scope="col">تاریخ انتشار</th>
                                                <th scope="col">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($bookmarks as $commercial)
                                            <tr>
                                                <th scope="row bg-white">1</th>
                                                <td scope=" bg-white" style="background: white;">
                                                    <img calss="tbl-image" src="{{ asset(image_resize($commercial->image->name ?? 'image/Rectangle-4.png', ['width' => 80, 'height' => 80])) }}" alt="{{ $commercial->title }}">
                                                </td>
                                                <td class="text-center">{{ $commercial->title }}</td>
                                                <td class="text-center">{{ $commercial->city->name ?? '' }}</td>
                                                <td class="text-center">{{ $commercial->created_at->ago() }}</td>
                                                <td class="text-center">
                                                    <span class="bookmarkWrapper">
                                                        <input type="hidden" class="commercialSlug" value="{{ $commercial->slug }}">
                                                        <button span class="toggleBookmark border-0" type="button" style="background: none;" title="حذف نشان">
                                                          <span class="fas fa-bookmark text-danger"></span>
                                                        </buttonspan>
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">
                                                        هنوز آگهی نشان نکرده‌اید!
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="info" role="tabpanel" class="tab-pane fade in mt-3">
                                <form action="{{ route('frontend.my.update') }}" method="post" class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-1"></div>
                                        <label class="col-md-2 col-form-label text-md-left" for="name">نام</label>
                                        <div class="col-md-8">
                                            <input id="name" type="text" class="form-control f-input @error('name') is-invalid @enderror" name="name" value="{{ old('name', $auth_user->name) }}" required autofocus>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-1"></div>
                                        <label for="mobile" class="col-md-2 col-form-label text-md-left">موبایل</label>
                                        <div class="col-md-8">
                                            <input id="mobile" type="text" class="form-control f-input @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile', $auth_user->mobile) }}" required autofocus>
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-1"></div>
                                        <label for="password" class="col-md-2 col-form-label text-md-left">پسورد</label>
                                        <div class="col-md-8">
                                            <input id="password" type="password" class="form-control f-input @error('password') is-invalid @enderror" name="name" autofocus>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-1"></div>
                                        <label for="password-confirm" class="col-md-2 col-form-label text-md-left">تکرار پسورد</label>
                                        <div class="col-md-8">
                                            <input id="password-confirm" type="password" class="form-control f-input" name="password_confirmation" autocomplete="new-password">
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /content -->
            </div>
    </section>
    <!-- more product -->
    @if($relatedCommercials->count())
    <section class=" mt-5 product">
        <div class="container">
            <div class="divided">
                <h2>آگهی‌های مرتبط</h2>
                <span class="divider"></span>
                {{--<span>
                    <a href="#" class="hvr-icon-back">مشاهده بیشتر
                        <i class="fa fa-chevron-left  hvr-icon"></i>
                    </a>
                </span>--}}
            </div>
            <div class="row" style="direction: ltr">
                <div class="owl-carousel owl-theme owl-loaded" id="#owl-sug">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1150px;">
                            @include('frontend.partials.owl-commercials', ['commercials' => $relatedCommercials])
                        </div>
                    </div>
                    <div class="owl-nav disabled">
                        <button type="button" role="presentation" class="owl-prev">
                            <span aria-label="Previous">‹</span>
                        </button>
                        <button type="button" role="presentation" class="owl-next">
                            <span aria-label="Next">›</span>
                        </button>
                    </div>
                    <div class="owl-dots disabled">
                        <button role="button" class="owl-dot active">
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @forelse($commercials as $commercial)
    <div id="manHastam{{ $loop->index }}" class="modal fade man-hastam" tabindex="-1" role="dialog" aria-labelledby="manHastamModalLabel" aria-hidden="true">
        <div class="modal-dialog man-modal modal-lg">
            <div class="modal-header" style="border-bottom:none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-shadow:none; color:#fff; font-size: 12px;">
                  <span aria-hidden="true">&times; بستن</span>
                </button>
            </div>
            <div class="modal-content">
                <div class="row">
                    <div class="col-4 no-padding">
                        <div class="card h-100 w-100 " href="#!">
                            <div class="ac-img">
                                <img class="card-img-top" src="{{ asset(image_resize($commercial->image->name ?? 'image/Rectangle-4.png', ['width' => 266, 'height' => 240])) }}" alt="{{ $commercial->title }}">
                                <span class="r">{{ $commercial->id }}</span>
                            </div>
                            <div class="card-body no-padding">
                                <h4 class="mb-0">{{ $commercial->title }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 mt-1" style="border-radius: 10px;">
                        <table class="table text-right">
                            <thead class="thead-man">
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col">نام مشتری</th>
                                    <th scope="col">شماره تلفن </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commercial->iams as $iam)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $iam->name }}</td>
                                    <td>{{ $iam->mobile }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">هنوز هیچ کاربری اعلام آمادگی نکرده است.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- more product -->
@endsection
