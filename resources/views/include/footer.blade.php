<div class="footer-wrapper float-left">
    <div class="container">
        <div class="row footer-main  animated wow fade-up">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div>
                    <div class="footer-logo">
                        <img src="images/footer-logo.png" alt="img">
                    </div>
                    <div class="footer-pera">
                        <p>Lorem Ipsum is simply dummy text of the printing and
                            typesetting industry. Lorem Ipsum has been the industry's
                            standard dummy text ever since.</p>
                    </div>
                    <div class="footer-icon">
                        <ul>
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
            <div class="col-lg-2 col-md-6 col-sm-12">
                <div class="footer-link-wrapper">
                    <h5>Useful links</h5>
                    <ul>
                        <li><a href="index.html">
                                <span><i class="fas fa-chevron-right"></i></span> Home
                            </a></li>
                        <li><a href="about.html">
                                <span><i class="fas fa-chevron-right"></i></span> About Us
                            </a></li>
                        <li><a href="our-team.html">
                                <span><i class="fas fa-chevron-right"></i></span> Our Team
                            </a></li>
                        <li><a href="appointment.html">
                                <span><i class="fas fa-chevron-right"></i></span> Booking
                            </a></li>
                        <li><a href="contact.html">
                                <span><i class="fas fa-chevron-right"></i></span> Contact Us
                            </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="footer-insta">
                    <h5>Instagram post</h5>
                    <ul>
                        <li>
                            <a href="javascript:;"><img src="images/insta-blog1.png" alt="img">
                                <span><i class="fab fa-instagram"></i></span>
                            </a>

                        </li>
                        <li class="insta-post-gap">
                            <a href="javascript:;"> <img src="images/insta-blog4.png" alt="img">
                                <span><i class="fab fa-instagram"></i></span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="images/insta-blog2.png" alt="img">
                                <span><i class="fab fa-instagram"></i></span>
                            </a>

                        </li>
                        <li class="insta-post-gap">
                            <a href="javascript:;"> <img src="images/insta-blog5.png" alt="img">
                                <span><i class="fab fa-instagram"></i></span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="images/insta-blog3.png" alt="img">
                                <span><i class="fab fa-instagram"></i></span>
                            </a>
                        </li>
                        <li class="insta-post-gap">
                            <a href="javascript:;"><img src="images/insta-blog6.png" alt="img">
                                <span><i class="fab fa-instagram"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="footer-contact">
                    <h5>Contact Info</h5>
                    <ul>
                        <li>
                            <div class="address-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="address-content">
                                <a href="javascript:;">
                                    <span>Address</span>
                                    121 Waldeck Street, NY, USA
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="address-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="address-content">
                                <a href="javascript:;">
                                    <span>PHONE</span>
                                    0800-123456, 0800-123489
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="address-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="address-content">
                                <a href="javascript:;">
                                    <span>EMAIL</span>
                                    nailsalon@example.com
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <p>Copyright © 2025 <a href="/">Salonuxe.</a></p>
        </div>
    </div>
</div>

<!-- footer-section-end -->

<!-- Login Modal -->
<div class="login-wrapper">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close login-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel1"><span>Login</span></h3>
                </div>
                <div class="modal-body">
                    <div class="register-body">
                        {{-- <form action="{{ route('userLogin') }}" method="POST" id="login-form">
                            @csrf
                            <div>
                                <input type="text" name="username" placeholder="User Name*" value="{{ old('username') }}">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="position-relative">
                                <input type="password" name="password" id="login-password" placeholder="Password*">
                                <a href="javascript:void(0);" class="show-password-button position-absolute end-0 top-38 translate-middle-y me-3 text-muted" onclick="createpassword('login-password', this)">
                                    <i class="ri-eye-off-line align-middle"></i>
                                </a>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <ul>
                                    <li>
                                        <a href="javascript:;">Forgot Password?</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="sign-btn">
                                <button type="submit" class="main-btn-red">
                                    <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em><span>Log In</span>
                                </button>
                            </div>
                        </form> --}}
                        <form action="{{ route('userLogin') }}" method="POST" id="login-form">
                            @csrf
                            <div>
                                <input type="text" name="username" placeholder="User Name*" value="{{ old('username') }}">
                                <small class="text-danger error-message" id="username-error"></small> <!-- Error message placeholder -->
                            </div>
                            <div class="position-relative">
                                <input type="password" name="password" id="login-password" placeholder="Password*">
                                <a href="javascript:void(0);" class="show-password-button position-absolute end-0 top-38 translate-middle-y me-3 text-muted" onclick="createpassword('login-password', this)">
                                    <i class="ri-eye-off-line align-middle"></i>
                                </a>
                                <small class="text-danger error-message" id="password-error"></small> <!-- Error message placeholder -->
                            </div>
                            <div>
                                <ul>
                                    <li>
                                        <a href="javascript:;">Forgot Password?</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="sign-btn">
                                <button type="submit" class="main-btn-red">
                                    <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em><span>Log In</span>
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Register Modal -->
<div class="login-wrapper">
    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close login-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel"><span>Register</span></h3>
                </div>
                <div class="modal-body">
                    <div class="register-body">
                        <form id="signup-form" action="{{ route('clientSignup') }}" method="POST">
                            @csrf
                            <div class="position-relative">
                                <input type="text" class="form-control" name="name" id="signup-firstname" placeholder="Full Name*">
                                <small class="text-danger d-none" id="name-error"></small> <!-- Name error -->
                            </div>
                            
                            <div class="position-relative">
                                <input type="text" class="form-control" name="email" id="signup-email" placeholder="Email*">
                                <small class="text-danger d-none" id="email-error"></small> <!-- Email error -->
                            </div>
                            
                            <div class="position-relative">
                                <input type="text" class="form-control" name="username" id="signup-username" placeholder="Username*">
                                <small class="text-danger d-none" id="username-error"></small> <!-- Username error -->
                            </div>
                            
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-lg pe-5" name="password" id="signup-password" placeholder="Password">
                                <a href="javascript:void(0);" class="show-password-button position-absolute end-0 top-50 translate-middle-y me-3 text-muted" onclick="createpassword('signup-password', this)">
                                    <i class="ri-eye-off-line align-middle"></i>
                                </a>
                                <small class="text-danger d-none" id="password-error"></small> <!-- Password error -->
                                <small class="text-danger" id="length-error"></small> <!-- Password error -->
                            </div>
                            
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-lg pe-5" name="password_confirmation" id="signup-password-confirm" placeholder="Confirm Password">
                                <a href="javascript:void(0);" class="show-password-button position-absolute end-0 top-50 translate-middle-y me-3 text-muted" onclick="createpassword('signup-password-confirm', this)">
                                    <i class="ri-eye-off-line align-middle"></i>
                                </a>
                                <small class="text-danger d-none" id="confirm-password-error"></small> <!-- Confirm Password error -->
                            </div>    
                        
                            <div class="sign-btn">
                                <button type="submit" class="main-btn-red">
                                    <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em><span>Sign Up</span>
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <div class="sign-btn">
                        <a href="javascript:;" class="main-btn-red">
                            <em><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></em><span>Sign Up
                            </span>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@include('include.footer_links')
