<div class="top_nav hidden-print">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ $auth_user->name }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="{{ route('frontend.app.index') }}">صفحه اصلی</a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.my.show') }}">حساب کاربری</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out pull-right"></i> خروج
                            </a>
                        </li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bullhorn"></i>
                        <span class="badge bg-blue">{{ $pending_commercials_count }}</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        @foreach($pending_commercials as $com)
                        <li>
                            <a href="{{ route('admin.commercials.edit', $com->slug) }}">
                                <span>
                                  <span>{{ $com->user->name }}</span>
                                  <span class="time">{{ jdate($com->created_at)->ago() }}</span>
                                </span>
                                <span class="message">
                                  {{ words(strip_tags($com->content), 25) }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                        <li>
                            <div class="text-center">
                                <a href="{{ route('admin.commercials.index') }}">
                                    <strong>مشاهده تمام اعلان ها</strong>
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>