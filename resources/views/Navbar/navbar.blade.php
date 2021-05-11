<div class="loader-bg">
    <div class="loader-bar"></div>
</div>
<!-- [ Pre-loader ] end -->
<div id="nav_patch" class="nav_patch">
    <div class="nav_patch-overlay-box"></div>
    <div class="nav_patch-container navbar-wrapper">
        <!-- [ Header ] start -->
        <nav class="navbar header-navbar nav_patch-header backcolor">
            <div class="navbar-wrapper">
                <div class="navbar-logo">
                    <a href="index-2.html">
                        @php
                        $GETLOGO = Session::get('LOGO');
                        @endphp
                        @if ($GETLOGO != '')
                        <img class="img-fluid" src="{{$GETLOGO}}" alt="Theme-Logo" />
                        @else
                        <h2>lOGO</h2>
                        @endif
                    </a>
                    <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="feather icon-menu menu"></i>
                    </a>
                    <a class="mobile-options waves-effect waves-light">
                        <i class="feather icon-more-horizontal"></i>
                    </a>
                </div>
                <div class="navbar-container container-fluid">
                    <ul class="nav-right">
                        <li class="header-notification">
                            <div class="dropdown-primary dropdown">
                                <div class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="feather icon-bell"></i>
                                    <span class="badge bg-c-red">5</span>
                                </div>
                                <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn"
                                    data-dropdown-out="fadeOut" style="overflow: auto;height: 300px;">
                                    <li>
                                        <h6>Notifications</h6>
                                        <label class="label label-danger">New</label>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <img class="img-radius"
                                                src="{{asset('/public/assets/images/Avatar/user-4.png') }}"
                                                alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">John Doe</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                    elit.
                                                </p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <img class="img-radius"
                                                src="{{asset('/public/assets/images/Avatar/user-3.png') }}"
                                                alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">Joseph William</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                    elit.
                                                </p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <img class="img-radius"
                                                src="{{asset('/public/assets/images/Avatar/user-4.png') }}"
                                                alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">Sara Soudein</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                    elit.
                                                </p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="user-profile header-notification">

                            <div class="dropdown-primary dropdown">
                                <div class="dropdown-toggle" data-toggle="dropdown">
                                    @php
                                    $PROFILEPICTURE = Session::get('PROFILE');
                                    @endphp
                                    @if ($PROFILEPICTURE != '')
                                    <img src="{{$PROFILEPICTURE}}" class="img-radius"
                                    alt="User-Profile-Image">
                                    @else
                                    <img src="{{asset('/public/assets/images/Avatar/user-4.png') }}" class="img-radius"
                                    alt="User-Profile-Image">
                                    @endif

                                    <span>{{Session::get('Name')}}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <ul class="show-notification profile-notification dropdown-menu"
                                    data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <li>
                                        <a href="#!">
                                            <i class="feather icon-settings"></i> Settings

                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="feather icon-user"></i> Profile

                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="feather icon-mail"></i> My Messages

                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="feather icon-lock"></i> Lock Screen

                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/logout')}}">
                                            <i class="feather icon-log-out"></i> Logout

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="nav_patch-main-container">
            <div class="nav_patch-wrapper">
                <!-- [ navigation menu ] start -->
                <nav class="nav_patch-navbar">
                    <div class="nav-list">
                        <div class="nav_patch-inner-navbar main-menu">
                            {{-- Url For Main Superadmin Start Here --}}
                            @if (Session::get('RoleId') == 1)
                            <div class="nav_patch-navigation-label">
                                <ul class="nav_patch-item nav_patch-left-item">
                                    <li class="">
                                        <a href="{{url('/dashboard')}}" class="waves-effect waves-dark">
                                            <span class="nav_patch-micon">
                                                <i class="feather icon-layers"></i>
                                            </span>
                                            <span class="nav_patch-mtext">
                                                Dashboard
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="nav_patch-navigation-label">
                                <ul class="nav_patch-item nav_patch-left-item">
                                    <li class="">
                                        {{--  --}}
                                        <a href="{{url('SuperAdmin/show-all-superadmins')}}"
                                            class="waves-effect waves-dark">
                                            <span class="nav_patch-micon">
                                                <i class="feather icon-layers"></i>
                                            </span>
                                            <span class="nav_patch-mtext">
                                                Superadmins
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="nav_patch-navigation-label">Client</div>
                            <ul class="nav_patch-item nav_patch-left-item">
                                <li class="nav_patch-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="nav_patch-micon">
                                            <i class="feather icon-layers"></i>
                                        </span>
                                        <span class="nav_patch-mtext">Client</span>
                                    </a>
                                    <ul class="nav_patch-submenu">
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/client-creation')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Add Client
                                                </span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/show-clients')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Show Client
                                                </span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/stop-clients')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Force Stop
                                                </span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/update-clients-license')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Update License
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="nav_patch-navigation-label">Modules</div>
                            <ul class="nav_patch-item nav_patch-left-item">
                                <li class="nav_patch-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="nav_patch-micon"><i class="feather icon-sidebar"></i></span>
                                        <span class="nav_patch-mtext">Modules</span>
                                        {{-- <span class="nav_patch-badge label label-warning">NEW</span> --}}
                                    </a>
                                    <ul class="nav_patch-submenu">

                                        {{-- <li class="">
                                    <a href="#" class="waves-effect waves-dark">
                                        <span class="nav_patch-micon">
                                            <i class="feather icon-menu"></i>
                                        </span>
                                        <span class="nav_patch-mtext">Add Modules</span>
                                    </a>
                                </li> --}}

                                        <li class="">
                                            <a href="{{url('SuperAdmin/modules')}}"
                                                class="disabled waves-effect waves-dark">
                                                <span class="nav_patch-micon">
                                                    <i class="feather icon-power"></i>
                                                </span>
                                                <span class="nav_patch-mtext">Show Modules</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('SuperAdmin/show-all-clients')}}"
                                                class="disabled waves-effect waves-dark">
                                                <span class="nav_patch-micon">
                                                    <i class="feather icon-power"></i>
                                                </span>
                                                <span class="nav_patch-mtext">Asgin Modules</span>
                                            </a>
                                        </li>
                                </li>
                            </ul>
                            {{-- Url For main Superadmin Ends Here --}}
                            @elseif (Session::get('RoleId') == 2)
                            {{-- URl For Super Admin Start Here --}}
                            <div class="nav_patch-navigation-label">
                                <ul class="nav_patch-item nav_patch-left-item">
                                    <li class="">
                                        <a href="{{url('/dashboard')}}" class="waves-effect waves-dark">
                                            <span class="nav_patch-micon">
                                                <i class="feather icon-layers"></i>
                                            </span>
                                            <span class="nav_patch-mtext">
                                                Dashboard
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="nav_patch-navigation-label">Client</div>
                            <ul class="nav_patch-item nav_patch-left-item">
                                <li class="nav_patch-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="nav_patch-micon">
                                            <i class="feather icon-layers"></i>
                                        </span>
                                        <span class="nav_patch-mtext">Client</span>
                                    </a>
                                    <ul class="nav_patch-submenu">
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/client-creation')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Add Client
                                                </span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/show-clients')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Show Client
                                                </span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/stop-clients')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Force Stop
                                                </span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('/SuperAdmin/update-clients-license')}}"
                                                class="waves-effect waves-dark">
                                                <span class="nav_patch-mtext">
                                                    Update License
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="nav_patch-navigation-label">Modules</div>
                            <ul class="nav_patch-item nav_patch-left-item">
                                <li class="nav_patch-hasmenu">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="nav_patch-micon"><i class="feather icon-sidebar"></i></span>
                                        <span class="nav_patch-mtext">Modules</span>
                                        {{-- <span class="nav_patch-badge label label-warning">NEW</span> --}}
                                    </a>
                                    <ul class="nav_patch-submenu">

                                        {{-- <li class="">
                                    <a href="#" class="waves-effect waves-dark">
                                        <span class="nav_patch-micon">
                                            <i class="feather icon-menu"></i>
                                        </span>
                                        <span class="nav_patch-mtext">Add Modules</span>
                                    </a>
                                </li> --}}

                                        <li class="">
                                            <a href="{{url('SuperAdmin/modules')}}"
                                                class="disabled waves-effect waves-dark">
                                                <span class="nav_patch-micon">
                                                    <i class="feather icon-power"></i>
                                                </span>
                                                <span class="nav_patch-mtext">Show Modules</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{url('SuperAdmin/show-all-clients')}}"
                                                class="disabled waves-effect waves-dark">
                                                <span class="nav_patch-micon">
                                                    <i class="feather icon-power"></i>
                                                </span>
                                                <span class="nav_patch-mtext">Asgin Modules</span>
                                            </a>
                                        </li>
                                </li>
                            </ul>
                            {{-- Url For Super Admin Ends Here --}}
                            @endif
                        </div>
                    </div>
                </nav>
                <!-- [ navigation menu ] end -->

                <!-- [ Content section ] Start -->
                <div class="nav_patch-content">
                    <div class="padding_10_12">
                        @yield('content')
                    </div>
                </div>
                <!-- [ Content section ] End -->
                <!-- [ style Customizer ] start -->
                <div id="styleSelector">
                </div>
                <!-- [ style Customizer ] end -->
            </div>
        </div>
    </div>
</div>
