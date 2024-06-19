@extends('frontend.layouts.blank')
@section('title', 'نتیجه جستجو یافت نشد')
@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <p>متاسفانه آگهی با این کد وجود ندارد.</p>
            </div>
            <div class="PRT_prt-search">
                <div class="container">
                    <form action="{{ route('frontend.search.process') }}" method="post" class="row pt-4">
                        @csrf
                        <div class="col-3">
                            <div class="number-adv">
                                <input id="search-number" name="search-number" class="numb-adv" placeholder="شماره آگهی">
                            </div>
                        </div>
                        <div class="col-1">
                            <button class="d-inline-flex btn-search"><i class="fas fa-search"></i><span class="tx-search">جستجو</span></button>
                        </div>
                        <div class="col-8">
                            <div class="search-col">
                                <input id="search-phrase" name="search-phrase" class="d-inline-flex input-search" placeholder="جستجو در همه آگهی ها">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="col-4">
                <a href="{{ url('/') }}" class="btn btn-success">
                    بازگشت به صفحه نخست
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
