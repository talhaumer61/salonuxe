<!doctype html><html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!-- Web Fonts  -->		
        <link href="../../../css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<!-- Vendor CSS -->
		
        <link rel="stylesheet" href="dashboard/vendor/bootstrap/css/bootstrap.css">		
        <link rel="stylesheet" href="dashboard/vendor/animate/animate.compat.css">		
        <link rel="stylesheet" href="dashboard/vendor/font-awesome/css/all.min.css">		
        <link rel="stylesheet" href="dashboard/vendor/boxicons/css/boxicons.min.css">		
        <link rel="stylesheet" href="dashboard/vendor/magnific-popup/magnific-popup.css">		
        <link rel="stylesheet" href="dashboard/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css">
		<!-- Specific Page Vendor CSS -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

		<!-- Theme CSS -->
		
        <link rel="stylesheet" href="dashboard/css/theme.css">
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="dashboard/css/custom.css">
		<!-- Head Libs -->
		<script src="dashboard/vendor/modernizr/modernizr.js"></script>
		<script src="dashboard/master/style-switcher/style.switcher.localstorage.js"></script>
        <title>Register Salon | Salonuxe</title>
	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<div class="panel card-sign">
					<div class="card-body">
                        <h2 class="text-center text-dark">Signup</h2>
                        <p class="text-center text-dark">Welcome & Join Us!</p>
						<form action="{{ route('salonSignup') }}" method="post" onsubmit="return validateSignupForm()">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="signup-firstname">Full Name<sup>*</sup></label>
                                <input name="name" type="text" class="form-control form-control-lg" id="signup-firstname">
                                <small class="text-danger d-none" id="name-error"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="signup-email">E-mail Address<sup>*</sup></label>
                                <input name="email" type="text" class="form-control form-control-lg" id="signup-email">
                                <small class="text-danger d-none" id="email-error"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="signup-username">Username<sup>*</sup></label>
                                <input name="username" type="text" class="form-control form-control-lg" id="signup-username">
                                <small class="text-danger d-none" id="username-error"></small>
                            </div>
                            <div class="form-group mb-0">
                                <label for="signup-password">Password<sup>*</sup></label>
                                <div class="position-relative">
                                    <input name="password" type="password" class="form-control form-control-lg pe-5" id="signup-password">
                                    <a href="javascript:void(0);" class="show-password-button text-muted position-absolute end-0 top-50 translate-middle-y me-3" onclick="createpassword('signup-password',this)">
                                        <i class="ri-eye-off-line align-middle"></i>
                                    </a>
                                </div>
                                <small class="text-danger d-none" id="password-error"></small>
                            </div>
                            
                            <div class="form-group mb-0">
                                <label for="signup-confirmpassword">Confirm Password<sup>*</sup></label>
                                <div class="position-relative">
                                    <input name="password_confirmation" type="password" class="form-control form-control-lg pe-5" id="signup-confirmpassword">
                                    <a href="javascript:void(0);" class="show-password-button text-muted position-absolute end-0 top-50 translate-middle-y me-3" onclick="createpassword('signup-confirmpassword',this)">
                                        <i class="ri-eye-off-line align-middle"></i>
                                    </a>
                                </div>
                                <small class="text-danger d-none" id="confirm-password-error"></small>
                            </div>
                            
                            <div class="row justify-content-center">
                                <div class="col-sm-4 text-end">
                                    <button type="submit" class="btn btn-primary mt-2">Sign Up</button>
                                </div>
                            </div>
                            <div class="text-center my-3">
                                <a href="{{ route('google.salon.redirect') }}" class="btn btn-outline-danger w-100">
                                    <i class="fab fa-google me-2"></i> Sign up with Google
                                </a>
                            </div>

                            {{-- <p class="text-center">Already have an account? <a href="/login">Sign In!</a></p> --}}
                        </form>
					</div>
				</div>
				{{-- <p class="text-center text-muted mt-3 mb-3">&copy; Copyright 2023. All Rights Reserved.</p> --}}
			</div>
		</section>
		<!-- end: page -->
		<!-- Vendor -->
		<script src="dashboard/vendor/jquery/jquery.js"></script>		
        <script src="dashboard/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>		
        <script src="dashboard/vendor/jquery-cookie/jquery.cookie.js"></script>		
        <script src="dashboard/master/style-switcher/style.switcher.js"></script>		
        <script src="dashboard/vendor/popper/umd/popper.min.js"></script>		
        <script src="dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>		
        <script src="dashboard/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>		
        <script src="dashboard/vendor/common/common.js"></script>		
        <script src="dashboard/vendor/nanoscroller/nanoscroller.js"></script>		
        <script src="dashboard/vendor/magnific-popup/jquery.magnific-popup.js"></script>		
        <script src="dashboard/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<!-- Specific Page Vendor -->

		<!-- Theme Base, Components and Settings -->
        <script src="dashboard/js/theme.js"></script>
		<!-- Theme Custom -->
		<script src="dashboard/js/custom.js"></script>
		<!-- Theme Initialization Files -->
		<script src="dashboard/js/theme.init.js"></script>
		<!-- Analytics to Track Preview Website -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-42715764-8', 'auto');
		  ga('send', 'pageview');
		</script>

        {{-- Show Password --}}
        <script>
            function createpassword(inputId, icon) {
                const inputField = document.getElementById(inputId);
                const iconElement = icon.querySelector('i');

                if (inputField.type === "password") {
                    inputField.type = "text";  // Show password
                    iconElement.classList.remove("ri-eye-off-line");  // Remove "eye-off" icon
                    iconElement.classList.add("ri-eye-line");  // Add "eye" icon
                } else {
                    inputField.type = "password";  // Hide password
                    iconElement.classList.remove("ri-eye-line");  // Remove "eye" icon
                    iconElement.classList.add("ri-eye-off-line");  // Add "eye-off" icon
                }
            }
        </script>

        {{-- Password Confirmation --}}
        <script>
            function validateSignupForm() {
                let isValid = true;

                // Get field values
                const name = document.getElementById('signup-firstname').value.trim();
                const email = document.getElementById('signup-email').value.trim();
                const username = document.getElementById('signup-username').value.trim();
                const password = document.getElementById('signup-password').value.trim();
                const confirmPassword = document.getElementById('signup-confirmpassword').value.trim();

                // Clear previous errors
                clearErrors();

                // Validate Name
                if (name === '') {
                    showError('name-error', 'Full Name is required.');
                    isValid = false;
                }

                // Validate Email
                if (email === '') {
                    showError('email-error', 'Email is required.');
                    isValid = false;
                } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                    showError('email-error', 'Invalid email format.');
                    isValid = false;
                }

                // Validate Username
                if (username === '') {
                    showError('username-error', 'Username is required.');
                    isValid = false;
                }

                // Validate Password
                if (password === '') {
                    showError('password-error', 'Password is required.');
                    isValid = false;
                } else if (password.length < 8) {
                    showError('password-error', 'Password must be at least 8 characters long.');
                    isValid = false;
                }

                // Validate Confirm Password
                if (confirmPassword === '') {
                    showError('confirm-password-error', 'Confirm Password is required.');
                    isValid = false;
                } else if (password !== confirmPassword) {
                    showError('confirm-password-error', 'Passwords do not match.');
                    isValid = false;
                }

                return isValid;
            }

            function showError(elementId, message) {
                const errorElement = document.getElementById(elementId);
                errorElement.textContent = message;
                errorElement.classList.remove('d-none');
            }

            function clearErrors() {
                const errorElements = document.querySelectorAll('.text-danger');
                errorElements.forEach((element) => {
                    element.textContent = '';
                    element.classList.add('d-none');
                });
            }
        </script>

        {{-- Check Email & Username Availability --}}
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                function checkAvailability(field, value, errorElement) {
                    if (value.length < 3) {
                        document.getElementById(errorElement).classList.add("d-none");
                        return;
                    }

                    fetch("{{ route('checkAvailability') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ field: field, value: value })
                    })
                    .then(response => response.json())
                    .then(data => {
                        let errorEl = document.getElementById(errorElement);
                        if (data.exists) {
                            errorEl.textContent = field.charAt(0).toUpperCase() + field.slice(1) + " is already taken.";
                            errorEl.classList.remove("d-none");
                        } else {
                            errorEl.classList.add("d-none");
                        }
                    })
                    .catch(error => console.error("Error:", error));
                }

                document.getElementById("signup-username").addEventListener("input", function () {
                    checkAvailability("username", this.value, "username-error");
                });

                document.getElementById("signup-email").addEventListener("input", function () {
                    checkAvailability("email", this.value, "email-error");
                });
            });
        </script>
	</body>
</html>