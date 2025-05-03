<header class="header header-nav-menu admin-header">
    <div class="logo-container">
        <a href="../" class="logo">
            <img src="{{asset('images/logo.png')}}" width="75" height="35" alt="Porto Admin">
        </a>
        <button class="btn header-btn-collapse-nav d-lg-none" data-bs-toggle="collapse" data-bs-target=".header-nav" aria-expanded="true">
            <i class="fas fa-bars"></i>
        </button>
        <!-- start: header nav menu -->
        <div class="header-nav collapse" style="">
            <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
                <nav>
                    <ul class="nav nav-pills" id="mainNav">
                        <li class="">
                            <a class="nav-link" href="/admin">
                                Dashboard
                            </a>    
                        </li>
                        <li class="">
                            <a class="nav-link" href="/users">
                                Users
                            </a>    
                        </li>
                        <li class="">
                            <a class="nav-link" href="#">
                                Salons
                            </a>    
                        </li>
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
                                Bookings
                            <i class="fas fa-caret-down"></i></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="/appointments">
                                        List
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
                                Services
                            <i class="fas fa-caret-down"></i></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="/added-services">
                                        List
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="/service-types">
                                        Types
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
                                Payments
                            <i class="fas fa-caret-down"></i></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="#">
                                        Completed
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#">
                                        Pending
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle">More<i class="fas fa-caret-down"></i></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="nav-link" href="#">
                                        Setting
                                    <i class="fas fa-caret-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="nav-link" href="#">
                                                Basic
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="#">
                                                Area Setting
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="#">
                                                Region
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="nav-link" href="#">
                                        Help & Support
                                    </a>            
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- end: header nav menu -->
    </div>
    <!-- start: search & user box -->
    <div class="header-right">
        <a class="btn search-toggle d-none d-md-inline-block d-xl-none" data-toggle-class="active" data-target=".search"><i class="bx bx-search"></i></a>
        
        <span class="separator"></span>
        <ul class="notifications">
            {{-- <li>
                <a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                    <i class="bx bx-list-ol"></i>
                    <span class="badge">3</span>
                </a>
                <div class="dropdown-menu notification-menu large">
                    <div class="notification-title">
                        <span class="float-end badge badge-default">3</span>
                        Tasks
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <p class="clearfix mb-1">
                                    <span class="message float-start">Generating Sales Report</span>
                                    <span class="message float-end text-dark">60%</span>
                                </p>
                                <div class="progress progress-xs light">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                </div>
                            </li>
                            <li>
                                <p class="clearfix mb-1">
                                    <span class="message float-start">Importing Contacts</span>
                                    <span class="message float-end text-dark">98%</span>
                                </p>
                                <div class="progress progress-xs light">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
                                </div>
                            </li>
                            <li>
                                <p class="clearfix mb-1">
                                    <span class="message float-start">Uploading something big</span>
                                    <span class="message float-end text-dark">33%</span>
                                </p>
                                <div class="progress progress-xs light mb-1">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li> --}}
            <li>
                <a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                    <i class="bx bx-envelope"></i>
                    <span class="badge">4</span>
                </a>
                <div class="dropdown-menu notification-menu">
                    <div class="notification-title">
                        <span class="float-end badge badge-default">230</span>
                        Messages
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <a href="#" class="clearfix">
                                    <figure class="image">
                                        <img src="dashboard/img/!sample-user.jpg" alt="Joseph Doe Junior" class="rounded-circle">
                                    </figure>
                                    <span class="title">Joseph Doe</span>
                                    <span class="message">Lorem ipsum dolor sit.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <figure class="image">
                                        <img src="dashboard/img/!sample-user.jpg" alt="Joseph Junior" class="rounded-circle">
                                    </figure>
                                    <span class="title">Joseph Junior</span>
                                    <span class="message truncate">Truncated message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam, nec venenatis risus. Vestibulum blandit faucibus est et malesuada. Sed interdum cursus dui nec venenatis. Pellentesque non nisi lobortis, rutrum eros ut, convallis nisi. Sed tellus turpis, dignissim sit amet tristique quis, pretium id est. Sed aliquam diam diam, sit amet faucibus tellus ultricies eu. Aliquam lacinia nibh a metus bibendum, eu commodo eros commodo. Sed commodo molestie elit, a molestie lacus porttitor id. Donec facilisis varius sapien, ac fringilla velit porttitor et. Nam tincidunt gravida dui, sed pharetra odio pharetra nec. Duis consectetur venenatis pharetra. Vestibulum egestas nisi quis elementum elementum.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <figure class="image">
                                        <img src="dashboard/img/!sample-user.jpg" alt="Joe Junior" class="rounded-circle">
                                    </figure>
                                    <span class="title">Joe Junior</span>
                                    <span class="message">Lorem ipsum dolor sit.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <figure class="image">
                                        <img src="dashboard/img/!sample-user.jpg" alt="Joseph Junior" class="rounded-circle">
                                    </figure>
                                    <span class="title">Joseph Junior</span>
                                    <span class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam.</span>
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="text-end">
                            <a href="#" class="view-more">View All</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                    <i class="bx bx-bell"></i>
                    <span class="badge">3</span>
                </a>
                <div class="dropdown-menu notification-menu">
                    <div class="notification-title">
                        <span class="float-end badge badge-default">3</span>
                        Alerts
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <a href="#" class="clearfix">
                                    <div class="image">
                                        <i class="fas fa-thumbs-down bg-danger"></i>
                                    </div>
                                    <span class="title">Server is Down!</span>
                                    <span class="message">Just now</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <div class="image">
                                        <i class="bx bx-lock bg-warning"></i>
                                    </div>
                                    <span class="title">User Locked</span>
                                    <span class="message">15 minutes ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <div class="image">
                                        <i class="fas fa-signal bg-success"></i>
                                    </div>
                                    <span class="title">Connection Restaured</span>
                                    <span class="message">10/10/2023</span>
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="text-end">
                            <a href="#" class="view-more">View All</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <span class="separator"></span>
        <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="">
                <figure class="profile-picture">
                    <img src="{{ session('user')->photo }}" alt="Joseph Doe" class="rounded-circle" data-lock-picture="dashboard/img/!logged-user.jpg">
                </figure>
                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span class="name">{{ session('user')->name }}</span>
                    {{-- <span class="role">administrator</span> --}}
                </div>
                <i class="fa custom-caret"></i>
            </a>
            <div class="dropdown-menu" style="">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="/admin-profile"><i class="bx bx-user-circle"></i> My Profile</a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="bx bx-lock"></i> Lock Screen</a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="logout"><i class="bx bx-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<div class="inner-wrapper">
    <section role="main" class="content-body content-body-modern mt-0">