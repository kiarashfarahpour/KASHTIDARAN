<!-- Footer -->
<footer class="page-footer font-small mt-5">
    <div class="footer-nav">
        <div class="container">
            <!-- Grid row-->
            <div class="row d-flex align-items-center">
                <!-- Grid column -->
                <div class="col-md-6 col-lg-5 mb-4 mb-md-0  align-items-center no-padding">
                    <nav class="">
                        <ul class="list-group list-group-horizontal-sm text-right">
                            <li class="border-left">
                                <a class="nav-link" href="{{ url('/') }}">صفحه اصلی
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="border-left">
                                <a class="nav-link" href="{{ route('frontend.commercials.index') }}">همه آگهی ها</a>
                            </li>
                            <li class="border-left">
                                <a class="nav-link" href="https://mag.kashtidaran.com/contact/">تماس با ما </a>
                            </li>
                            <li class="border-left">
                                <a class="nav-link" href="{{ route('frontend.pages.show', 'tos') }}">قوانین و پشتیبانی</a>
                            </li>
                            
                        </ul>
                    </nav>
                </div>
                <!-- Grid column -->
                <div class="col-md-6 col-lg-7 text-center text-md-right footer-adv d-flex justify-content-start">
                    <div class="support">
                    <a href="mailto:kashtidaran@gmail.com"><strong class="callus">Email: kashtidaran@gmail.com</strong></a>
                    <a href="Tel:+989170025800"><strong class="callus">call us:+989170025800</strong></a>
                        
                    </div>
                    <a href="{{ route('frontend.commercials.new', ['city' => $currentCity->name ?? 'tehran']) }}" class="ac-btn ">
                        <div class="ac-btn-icon">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="ac-btn-text">
                            <span>ثبت آگهی رایگان</span>
                        </div>
                    </a>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row-->
        </div>
    </div>
    <!-- Footer Links -->
    <div class="container mt-5 ">
        <!-- Grid row -->
        <div class="row mt-3 text-right footer-link">
            @if($footerCol1->status)
                <!-- Grid column -->
                <div class="col-lg-3 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class=" font-weight-bold">{{ $footerCol1->name }}</h6>
                    <ul class="footer-list">
                        @foreach($footerCol1->orderedItems as $item)
                            <li>
                                <a href="{{ $item->url }}">{{ $item->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($footerCol2->status)
                <!-- Grid column -->
                <div class="col-lg-3 col-xl-3 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class=" font-weight-bold">{{ $footerCol2->name }}</h6>
                    <ul class="footer-list">
                        @foreach($footerCol2->orderedItems as $item)
                            <li>
                                <a href="{{ $item->url }}" class="item-mnu-ft">{{ $item->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Grid column -->
            @endif
            @if($footerCol3->status)
                <!-- Grid column -->
                <div class="col-lg-3 col-xl-3 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class=" font-weight-bold">{{ $footerCol3->name }}</h6>
                    <ul class="footer-list">
                        @foreach($footerCol3->orderedItems as $item)
                            <li>
                                <a href="{{ $item->url }}" class="item-mnu-ft">{{ $item->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Grid column -->
            @endif
            <!-- Grid column -->
            <div class="col-lg-3 col-xl-3 mx-auto mb-4 social-link">
                <!-- Links -->
                <h6 class=" font-weight-bold">
                    ما را دنبال کنید
                </h6>
                @if($site_settings['twitter'])
                    <a href="{{ $site_settings['twitter'] }}">
                        <i class="fab fa-twitter"></i>
                    </a>
                @endif
                @if($site_settings['facebook'])
                    <a href="{{ $site_settings['facebook'] }}">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                @endif
                @if($site_settings['telegram'])
                    <a href="{{ $site_settings['telegram'] }}">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                @endif
                @if($site_settings['instagram'])
                    <a href="{{ $site_settings['instagram'] }}">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif
                @if($site_settings['whatsapp'])
                    <a href="{{ $site_settings['whatsapp'] }}">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                @endif
                @if($site_settings['pinterest'])
                    <a href="{{ $site_settings['pinterest'] }}">
                        <i class="fab fa-pinterest"></i>
                    </a>

                @endif
            </div>
            <div class="col-lg-3 col-xl-3 mx-auto mt-4 text-center ">
                <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=166421&amp;Code=Cz5uyO2l2tNQ7JownYVP">
                    <img referrerpolicy="origin" src="{{ asset('image/namad1.png') }}" style="cursor:pointer" id="Cz5uyO2l2tNQ7JownYVP"class="img-fluid" alt="اینماد">
                </a>

                
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
    </div>
    <!-- Footer Links -->
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3 mt-5">{{ $site_settings['copyright'] }}</div>
    <!-- Developed by <a href="https://vediana.com">Vediana</a> -->
    <!-- Copyright -->
</footer>
<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
</div>
