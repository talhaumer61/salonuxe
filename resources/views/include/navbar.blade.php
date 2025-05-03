@include('include.header')
<div class="main-header-wrapper float-left">
    <div class="main-menu float-left">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" height="70px">
                    </a>
                </div>
                <div class="col-lg-10 col-md-6 d-xl-block d-lg-block d-md-none d-sm-none d-none">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="/">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/available-services">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/salons">Salons</a>
                                </li>
                                <!-- About and Contact Us links -->
                                <li class="nav-item">
                                    <a class="nav-link" href="/contact">Contact Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">More
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a  href="about">About Us</a>
                                        </li>
                                        @if(session()->has('user'))
                                        <li>
                                            <a  href="/logout">Logout</a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>

                                <!-- Show Dashboard link only if user is logged in as client-->
                                @if(session()->has('user') && session('user')->login_type==2)
                                <li class="nav-item d-flex">
                                    <a class="nav-link" href="/client-dashboard">
                                        <div class="main-btn">
                                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                            <span>Dashboard</span>
                                        </div>
                                    </a>
                                </li>
                                @endif
                                
                                <!-- Show Dashboard link only if user is logged in salon-->
                                @if(session()->has('user') && session('user')->login_type==3)
                                <li class="nav-item d-flex">
                                    <a class="nav-link" href="/salon-dashboard">
                                        <div class="main-btn">
                                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                            <span>Dashboard</span>
                                        </div>
                                    </a>
                                </li>
                                @endif
                                
                                <!-- Show Dashboard link only if user is logged in salon-->
                                @if(session()->has('user') && session('user')->login_type==1)
                                <li class="nav-item d-flex">
                                    <a class="nav-link" href="/admin">
                                        <div class="main-btn">
                                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                            <span>Dashboard</span>
                                        </div>
                                    </a>
                                </li>
                                @endif

                                <!-- Show Login and Register links only if user is NOT logged in -->
                                @if(!session()->has('user'))
                                    <li class="nav-item d-flex">
                                        {{-- <a class="nav-link" href="/login">
                                            <div class="main-btn">
                                                <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                                <span>Login</span>
                                            </div>
                                        </a> --}}
                                        {{-- <a class="nav-link" href="/signup">
                                            <div class="main-btn">
                                                <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                                <span>Register</span>
                                            </div>
                                        </a> --}}
                                        <a class="nav-link" href="javascript:;">
                                            <div class="main-btn">
                                                <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                                <span data-bs-toggle="modal" data-bs-target="#staticBackdrop">Login</span>
                                            </div>
                                        </a>
                                        <a class="nav-link" href="javascript:;">
                                            <div class="main-btn">
                                                <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                                <span data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Register</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-6 col-6 d-xl-none d-lg-none">
                    <button class="nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar"
                        aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="nav-toggle__text">Toggle Menu</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Mobile Navbar Start --}}
<div class="mobile-menu-wrapper">
    <div id="sidebar">
        <div class="logo">
            <img src="{{asset('images/logo.png')}}" alt="logo" height="70px">
        </div>
        <div id="toggle-close">&times;</div>
        <div id="cssmenu">
            {{-- <input type="search" placeholder="Search Here...."> --}}
            <ul class="float-left">
                <li>
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="about.html">About Us</a>
                </li>
                <li>
                    <a href="/services">Services</a>
                </li>
                <li>
                    <a href="/salons">Salons</a>
                </li>
                {{-- <li class="has-sub">
                    <a href="javascript:;">Gallery</a>
                    <ul>
                        <li><a href="gallery.html">3 Column</a></li>
                        <li><a href="gallery2.html">4 Column</a></li>
                        <li><a href="gallery3.html">5 Column</a></li>
                        <li><a href="gallery4.html">Masonry Gallery</a></li>
                    </ul>
                </li> --}}
                <li>
                    <a href="#">About Us</a>
                </li>
                <li>
                    <a  href="#">Contact Us</a>
                </li>
                <li>
                    <a class="text-primary" href="/client-dashboard">Dasboard</a>
                </li>
                <li>
                    <a class="nav-link" href="javascript:;">
                        <div class="main-btn">
                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em><span data-bs-toggle="modal" data-bs-target="#staticBackdrop">Login/Register</span>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="sidebar-social float-left">
                <ul class="float-left">
                    <li><a href="javascript:;">
                            <i class="fab fa-facebook-f"></i>
                        </a></li>
                    <li><a href="javascript:;">
                            <i class="fab fa-twitter"></i>
                        </a></li>
                    <li><a href="javascript:;">
                            <i class="fab fa-instagram"></i>
                        </a></li>
                    <li><a href="javascript:;">
                            <i class="fab fa-pinterest-p"></i>
                        </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>