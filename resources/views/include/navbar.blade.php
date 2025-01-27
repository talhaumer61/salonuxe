<div class="main-header-wrapper float-left">
    <div class="main-menu float-left">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                    <a class="navbar-brand" href="/">
                        <img src="{{asset('images/logo.png')}}" alt="logo">
                    </a>
                </div>
                <div class="col-lg-10 col-md-6 d-xl-block d-lg-block d-md-none d-sm-none d-none">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="/">Home
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/services">Services
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/salons">Salons
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">Gallery
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="gallery.html">3 Column</a></li>
                                        <li><a href="gallery2.html">4 Column</a></li>
                                        <li><a href="gallery3.html">5 Column</a></li>
                                        <li><a href="gallery4.html">Masonry Gallery</a></li>
                                    </ul>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">Blog
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="blog.html">Blog Left Sidebar</a></li>
                                        <li><a href="blog-detail.html">Blog Details</a></li>
                                        <li><a href="blog-rightsidebar.html">Blog Right Sidebar</a></li>
                                    </ul>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">Shortcode
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <div class="sub-menu mega-menu">
                                        <ul>
                                            <li><a href="accordion.html">
                                                    Accordion
                                                </a></li>
                                            <li><a href="alert.html">
                                                    Alert
                                                </a></li>
                                            <li><a href="button.html">
                                                    Button
                                                </a></li>
                                            <li><a href="client.html">
                                                    Client
                                                </a></li>
                                            <li><a href="counter.html">
                                                    Counter
                                                </a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="form.html">
                                                    Form
                                                </a></li>
                                            <li><a href="icon.html">
                                                    Icon
                                                </a></li>
                                            <li><a href="list.html">
                                                    List
                                                </a></li>
                                            <li><a href="pricing.html">
                                                    Pricing Table
                                                </a></li>
                                            <li><a href="social-icon.html">
                                                    Social Icon
                                                </a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="tab.html">
                                                    Tab
                                                </a></li>
                                            <li><a href="team.html">
                                                    Team
                                                </a></li>
                                            <li><a href="testimonial.html">
                                                    Testimonial
                                                </a></li>
                                            <li><a href="gallery-short.html">
                                                    Gallery
                                                </a></li>
                                        </ul>
                                    </div>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact Us</a>
                                </li>
                                <li class="nav-item dashboard-btn">
                                    <a class="nav-link" href="/client-dashboard">Dashboard</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <div class="search">
                                        <div class="search-box">
                                            <input type="search" class="search-input" placeholder="Search Here">
                                            <a href="javascript:;" class="search-btn"><i
                                                    class="fas fa-search"></i></a>

                                        </div>
                                    </div>
                                </li> --}}
                                <li class="nav-item d-flex">
                                    <a class="nav-link" href="javascript:;">
                                        <div class="main-btn">
                                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                            <span data-bs-toggle="modal" data-bs-target="#staticBackdrop">Login</span>
                                        </div>
                                    </a>
                                    <a class="nav-link" href="javascript:;">
                                        <div class="main-btn">
                                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em>
                                            <span data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Register</span>
                                        </div>
                                    </a>
                                </li>
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
            <img src="images/logo.png" alt="logo">
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
                <li class="nav-item">
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