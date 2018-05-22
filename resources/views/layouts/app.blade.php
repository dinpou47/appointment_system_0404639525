@include('includes.header.header')
<div style="background:#FFFFFF" class="navbar-inverse container-nav" id="nav-bar">
    <!-- blue line -->
    <div class="col-lg-12-top">

    </div>
    <!-- End of blue line -->

    <div style="margin-bottom:0px" class="navbar navbar-merab">
        <div class="page-top">
            <div class="col-lg-12">
                <div class="social-media">
                    <i style="color:#1da1f2;font-size:2em" class="fa fa-twitter-square fa-lg"></i>
                    <i style="color:#3b5998;font-size:2em" class="fa fa-facebook-square fa-lg"></i>
                    <i style="color:#db4437;font-size:2em" class="fa fa-google-plus-square fa-lg"></i>
                </div>

                <div class="phtext1" id="contact-info">
                    <i class="fa fa-phone fa-lg"> </i> 03 9809 9090 | <i class="fa fa-envelope-o fa-lg"></i>
                    enquiry@7-day.com
                </div>
            </div>
        </div>

    </div>
    <div style="margin-bottom:0px" class="navbar navbar-undermerabi">
        <div class="container-logo">
            <div class="col-lg-12">
                <div class="logo-icon">
                    <a href="{{route('homePage')}}"><i class="fa fa-medkit fa-3x"></i></a>
                </div>
                <div class="logotext">
                    7-Day Psychology
                </div>


                <div style="float:left; margin-left: 30px;" class="phtext3">
                    <?php
                    $start = '08:00:00';
                    $end = '2:00:00';
                    $now = Carbon\Carbon::now('UTC');
                    $time = $now->format('H:i:s');
                    ?>

                    <span class="btn btn-success">
                            @if ($time >= $start || $time <= $end)
                            Open Now
                        @else
                            Close
                        @endif

                        </span>

                    <div class="btn btn-default hidden-xs">{{Carbon\Carbon::now(new DateTimeZone('Australia/Melbourne'))}}</div>
                    @if (auth::guard('patient')->check())
                        <a href="{{route('appointment.create')}}" class="btn btn-info ">
                            <span class="glyphicon glyphicon-plus-sign"></span> Make Apppointment
                        </a>
                    @endif

                </div>

                <!--start noticication -->
                @if(auth::guard('doctor')->check()||auth::guard('admin')->check()||auth::guard('patient')->check())
                    <div style="float:right; right: -10px;">
                        <div id="noti-container">
                            <div id="noti-counter"></div>   <!--show noti count.-->

                            <!--noti icon.-->
                            <a href="{{route('notification')}}" id="noti-button" href="">
                                <i class="fa fa-bell fa-lg"></i> </a>

                            <div id="notifications">
                                <p style="padding: 2px;font-size: 0.9em" class="ui btn-info">Notifications</p>
                                <div id="notification-message" style="height:200px;margin-left: 4px;">

                                </div>
                                <div class="seeAll"><a class="seeAllNoti" href="{{route('notification.all')}}">See All</a></div>
                            </div>
                        </div>
                    </div>
            @endif

            <!--end notification -->


                <div class="auth-buttons">
                    <ul>
                        <!-- Authentication Links -->

                        @if (Auth::guard('admin')->check())

                            <li>
                                <a href="#" class="btn btn-primary" role="button" aria>
                                    WELCOME {{ Auth::guard('admin')->user()->name }} </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('admin.logout') }}" class="btn btn-default">
                                    Logout
                                </a>
                            </li>

                        @elseif(Auth::guard('patient')->check())


                            <li>
                                <a href="#" class="btn btn-primary" role="button" aria>
                                    WELCOME {{ Auth::guard('patient')->user()->name }} </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('patient.logout') }}" class="btn btn-default">
                                    Logout
                                </a>
                            </li>


                        @elseif(Auth::guard('doctor')->check())

                            <li>
                                <a href="#" class="btn btn-primary" role="button" aria>
                                    WELCOME {{ Auth::guard('doctor')->user()->name }} </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('doctor.logout') }}" class="btn btn-default">
                                    Logout
                                </a>
                            </li>
                        @else
                            <li><a class="btn btn-success" href="{{ route('patient.login') }}">LOGIN AS PATIENT</a></li>
                            <li><a class="btn btn-primary" href="{{ route('patient.register') }}">REGISTER AS
                                    PATIENT</a></li>
                            <li><a class="btn btn-primary" href="{{ route('doctor.login') }}">LOGIN AS DOCTOR</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navi">
        <div style="background:#35608C" class="row">
            <div class="col-lg-12 gverd">
                <div class="navbar-header">
                    <button style="color: red" type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#responsive-menu">
                        <span class="sr-only">open navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="responsive-menu">
                    <ul class="nav navbar-nav menu-list">
                        @if(auth::guard('admin')->check())

                            <li><a class="homes" href="{{route('homePage')}}">HOME</a></li>
                            <li><a class="homes" href="{{route('admin.dashboard')}}">ADMIN DASHBOARD</a></li>
                            <li><a href="{{route('patient')}}">VIEW PATIENTS</a></li>
                            <li><a href="{{route('doctorList')}}">VIEW DOCTORS</a></li>
                            <li><a href="{{route('allAppointment')}}">VIEW APPOINTMENTS</a></li>

                            <li>
                                <a href="{{route('createSchedule')}}">
                                    DOCTOR SCHEDULE
                                </a>
                            </li>
                            <li><a href="{{route('userList')}}">USERS</a></li>
                            <li>

                            </li>
                            <li><a href="{{url('/contact')}}">CONTACT</a></li>

                        @elseif(auth::guard('doctor')->check())
                            <li><a class="homes" href="{{route('homePage')}}">HOME</a></li>
                            <li><a href="{{route('doctor.dashboard')}}">DOCTOR DASHBOARD</a></li>
                            <li><a href="{{route('patient')}}">VIEW PATIENTS</a></li>
                            <li><a href="{{route('appointment.show',['id' => Auth::guard('doctor')->id()])}}">VIEW
                                    APPOINTMENTS</a>
                            </li>

                            <li><a href="{{route('doctor.viewDoctorSchedule')}}">VIEW SCHEDULE</a></li>
                            <li><a href="{{route('doctor.changePass')}}">CHANGE PASSWORD</a></li>

                            <li><a href="{{url('/contact')}}">CONTACT</a></li>

                        @elseif(auth::guard('patient')->check())
                            <li><a class="homes" href="{{route('homePage')}}">HOME</a></li>
                            <li><a href="{{route('patient.dashboard')}}">PATIENT DASHBOARD</a></li>
                            <li><a href="{{route('doctorList')}}">VIEW DOCTORS</a></li>
                            <li><a href="{{route('appointment.create')}}">APPOINTMENT</a></li>
                            <li><a href="{{route('patient.changePass')}}">CHANGE PASSWORD</a></li>
                            <li><a href="{{url('/contact')}}">CONTACT</a></li>
                        @else
                            <li><a class="homes" href="{{route('homePage')}}">HOME</a></li>
                            <li><a href="{{route('doctorList')}}">VIEW DOCTORS</a></li>
                            <li><a href="{{route('patient.login')}}">BOOK APPOINTMENT</a></li>
                            <li><a href="{{url('/contact')}}">CONTACT</a></li>

                        @endif

                    </ul>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    @yield('content')
</div>

<footer>
    <div class="footer navbar-fixed-bottom navi ">
        <div style="background:#35608C" class="row">
            <div class="col-lg-12 copyright">
                <p>&#169; 7 Day Psychology 2018</p>
            </div>

        </div>
    </div>
</footer>
@include('includes.footer.footer')
