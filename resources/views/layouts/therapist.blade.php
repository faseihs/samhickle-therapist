<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Find easily a therapist and book online an appointment">
    <meta name="author" content="sabsolutionspak.com">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Therapist @yield('title')</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="/theme/img/mainLogo.png" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="/theme/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="/theme/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="/theme/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="/theme/img/apple-touch-icon-144x144-precomposed.png">
    <link href="/admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="/theme/css/bootstrap.min.css" rel="stylesheet">
    <link href="/theme/css/style.css?v=1" rel="stylesheet">
    <link href="/theme/css/menu.css?v=1" rel="stylesheet">
    <link href="/theme/css/vendors.css" rel="stylesheet">
    <link href="/theme/css/icon_fonts/css/all_icons_min.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="/theme/css/custom.css" rel="stylesheet">
    @yield('styles')

</head>

<body>

<div class="layer"></div>
<!-- Mobile menu overlay mask -->

<div id="preloader">
    <div data-loader="circle-side"></div>
</div>
<!-- End Preload -->

<header  class="header_sticky">
    <div  class="container">
        <div class="row">
            <div class="col-lg-5 col-6">
                <div style="padding-bottom: 5px;" id="logo_home" >
                    <h1><a class="pb-4" style="height:40px;width:auto;background: url('/theme/img/mainLogo.png') no-repeat 0 0;background-size: 350px 40px" href="/" title="Therapist">Therapist</a></h1>
                </div>
            </div>
            <nav class="col-lg-7 col-6">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="#0"><span>Menu mobile</span></a>
                <ul id="top_access">
                    {{--@auth('therapist')
                        @else
                    <li><a data-toggle="tooltip" title="Therapist Login"  href="/therapist/login"><i class="pe-7s-user"></i></a></li>
                    <li><a data-toggle="tooltip" title="Therapist Register" href="/therapist/register"><i class="pe-7s-add-user"></i></a></li>
                    @endauth--}}
                    @auth('web')
                    <li><a data-toggle="tooltip" title="Logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" href="#"><i
                                    class="pe-7s-delete-user"></i></a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endauth
                    @auth('therapist')
                        <li><a data-toggle="tooltip" title="Therapist Logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" href="#"><i
                                        class="pe-7s-delete-user"></i></a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </ul>
                <div id="navbar-auth-div" class="main-menu">
                    <ul>
                        {{--<li class="submenu">
                            <a href="#0" class="show-submenu">Patient<i class="icon-down-open-mini"></i></a>
                            <ul>
                                @auth('web')
                                    <li><a href="/user/dashboard">Dashboard</a></li>
                                @else
                                <li><a href="/login">Login</a></li>
                                <li><a href="/register">Register</a></li>
                                @endauth


                            </ul>
                        </li>--}}
                        <li><a href="/therapist/register">List your practice on <span class="text-main">therapist.co.uk</span></a></li>
                        {{--<li class="submenu">
                            <a href="#0" class="show-submenu">Login/Signup<i class="icon-down-open-mini"></i></a>
                            <ul>
                               @guest('web')
--}}{{--
                                    <li><span class="menu-s">Patients </span> <a class="d-inline-block menu-a" href="/login">Login</a><a class="d-inline-block menu-a" href="/register">Register</a></li>
--}}{{--
                                   <navbar-auth name="patients"></navbar-auth>

                                @endguest
                                @guest('therapist')
                                <li><span class="menu-s">Therapist  </span> <a class="d-inline-block menu-a" href="/therapist/login">Login</a><a class="d-inline-block menu-a" href="/plans">Register</a></li>
                                @endguest


                            </ul>
                        </li>--}}
                        @if(!Auth::user() && !Auth::guard('therapist')->check())

                            <navbar-auth name="patients"></navbar-auth>

                        @endif

                        @auth('therapist')
                            <li class="submenu">
                                <a href="#0" class="show-submenu">Therapist<i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="/therapist/dashboard">Dashboard</a></li>
                                </ul>
                            </li>
                        @endauth
                        @auth('web')
                            <li class="submenu">
                                <a href="#0" class="show-submenu">Patients<i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="/user/dashboard">Dashboard</a></li>
                                </ul>
                            </li>
                        @endauth


                        {{--<li class="submenu">
                            <a href="#0" class="show-submenu">Pages<i class="icon-down-open-mini"></i></a>
                            <ul>
                                <li class="third-level"><a href="#0">List pages</a>
                                    <ul>
                                        <li><a href="list.html">List page</a></li>
                                        <li><a href="grid-list.html">List grid page</a></li>
                                        <li><a href="list-map.html">List map page</a></li>
                                    </ul>
                                </li>
                                <li class="third-level"><a href="#0">Detail pages</a>
                                    <ul>
                                        <li><a href="detail-page.html">Detail page 1</a></li>
                                        <li><a href="detail-page-2.html">Detail page 2</a></li>
                                        <li><a href="detail-page-3.html">Detail page 3</a></li>
                                        <li><a href="detail-page-working-booking.html">Detail working booking</a></li>
                                    </ul>
                                </li>
                                <li><a href="submit-review.html">Submit Review</a></li>
                                <li><a href="blog-1.html">Blog</a></li>
                                <li><a href="badges.html">Badges</a></li>
                                <li><a href="login.html">Login</a></li>
                                <li><a href="login-2.html">Login 2</a></li>
                                <li><a href="register-doctor.html">Register Doctor</a></li>
                                <li><a href="register-doctor-working.html">Working doctor register</a></li>
                                <li><a href="register.html">Register</a></li>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="contacts.html">Contacts</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#0" class="show-submenu">Extra Elements<i class="icon-down-open-mini"></i></a>
                            <ul>
                                <li><a href="booking-page.html">Booking page</a></li>
                                <li><a href="confirm.html">Confirm page</a></li>
                                <li><a href="faq.html">Faq page</a></li>
                                <li><a href="coming_soon/index.html">Coming soon</a></li>
                                <li class="third-level"><a href="#0">Pricing tables</a>
                                    <ul>
                                        <li><a href="pricing-tables-3.html">Pricing tables 1</a></li>
                                        <li><a href="pricing-tables.html">Pricing tables 2</a></li>
                                        <li><a href="pricing-tables-2.html">Pricing tables 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="icon-pack-1.html">Icon pack 1</a></li>
                                <li><a href="icon-pack-2.html">Icon pack 2</a></li>
                                <li><a href="icon-pack-3.html">Icon pack 3</a></li>
                                <li><a href="404.html">404 page</a></li>
                            </ul>
                        </li>
                        <li><a href="#0">Buy this template</a></li>--}}
                    </ul>
                </div>
                <style>
                    .menu-a{

                        color:#e74e84 !important;
                        display: inline-block !important;
                    }

                    .menu-s{

                        font-size: 14px;
                        display: inline-block;
                        min-width: 72px;
                        padding-left: 6px;
                    }

                    .menu-a:hover{
                        font-weight: bold;
                    }
                </style>
                <!-- /main-menu -->
            </nav>
        </div>
    </div>
    <!-- /container -->
</header>
<!-- /header -->

<main>
    @yield('content')
</main>
<!-- /main content -->

<footer>
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p>
                    <a href="/" title="Therapist.co.uk">
                        <img style="width: 350px;height: 40px;" src="/theme/img/mainLogo.png" data-retina="true" alt=""  class="img-fluid">
                    </a>
                </p>
            </div>
            <div class="col-lg-3 col-md-4">
{{--
                <h5>About</h5>
--}}
                <ul class="links">
                    <li><a href="#0">About us</a></li>
                    <li><a href="/register">Patient Register</a></li>
                    <li><a href="/login">Patient Login</a></li>
                    <li><a href="/therapist/register">Therapist Register</a></li>
                    <li><a href="/therapist/login">Therapist Login</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5>Contact with Us</h5>
                <ul class="contacts">
{{--
                    <li><a href="tel://61280932400"><i class="icon_mobile"></i> + 61 23 8093 3400</a></li>
--}}
                    <li><a href="mailto:help@therapist.co.uk"><i class="icon_mail_alt"></i> help@therapist.co.uk</a></li>
                </ul>
                <div class="follow_us">
                    <h5>Follow us</h5>
                    <ul>
                        <li><a href="#0"><i class="social_facebook"></i></a></li>
                        <li><a href="#0"><i class="social_twitter"></i></a></li>
                        <li><a href="#0"><i class="social_linkedin"></i></a></li>
                        <li><a href="#0"><i class="social_instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/row-->
        <hr>
        <div class="row">
            <div class="col-md-8">
                <ul id="additional_links">
                    <li><a href="/terms">Terms and conditions</a></li>
                    <li><a href="/privacy-policy">Privacy</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div id="copy">© 2019 Therapist.co.uk</div>
            </div>
        </div>
    </div>
</footer>
<!--/footer-->

<div id="toTop"></div>
<!-- Back to top button -->

<!-- COMMON SCRIPTS -->
<script src="/theme/js/jquery-2.2.4.min.js"></script>
<script src="/theme/js/common_scripts.min.js"></script>
<script src="/theme/js/functions.js?v=1"></script>
<script>
    window.auth = '{{Auth::user()?'true':'false'}}';
</script>
<script src="/js/navbar.js"></script>
@yield('scripts')

</body>

</html>