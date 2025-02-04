<script src="js/jquery-3.6.4.min.js"></script>
<script src="js/jquery.magnific-popup.js"></script>
<!-- Bootstrap JS-->
<script src="js/bootstrap.min.js"></script>
<script src="js/swiper.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<!-- Owl Carousel JS -->
<script src="js/owl.carousel.js"></script>
<script src="js/owl.carousel.min.js"></script>
<!-- Animation Js -->
<script src="js/wow.js"></script>
<!-- Custom Js -->
<script src="js/custom.js"></script>
<!-- contact form js start -->
<script src="js/contact_form.js"></script>
<script>
    $(".youtube-link").grtyoutube({
        autoPlay: true,
        theme: "dark",
    });
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

{{-- Password Confirmation & Validation --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script>
    $(document).ready(function () {
        $("#signup-form").on("submit", function (event) {
            let isValid = true;
            event.preventDefault(); // Prevent default form submission

            // Get field values
            let name = $.trim($("#signup-firstname").val());
            let email = $.trim($("#signup-email").val());
            let username = $.trim($("#signup-username").val());
            let password = $.trim($("#signup-password").val());
            let confirmPassword = $.trim($("#signup-password-confirm").val());
            alert(password.length);

            // Clear previous errors
            clearErrors();

            // Validate Name
            if (name === "") {
                showError("#name-error", "Full Name is required.");
                isValid = false;
            }

            // Validate Email
            if (email === "") {
                showError("#email-error", "Email is required.");
                isValid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                showError("#email-error", "Invalid email format.");
                isValid = false;
            }

            // Validate Username
            if (username === "") {
                showError("#username-error", "Username is required.");
                isValid = false;
            }

            // Validate Password
            if (password === "") {
                showError("#password-error", "Password is required.");
                isValid = false;
            } else if (password.length < 8) {
                showError("#password-error", "Password must be at least 8 characters long.");
                isValid = false;
            }

            // Validate Confirm Password
            if (confirmPassword === "") {
                showError("#confirm-password-error", "Confirm Password is required.");
                isValid = false;
            } else if (password !== confirmPassword) {
                showError("#confirm-password-error", "Passwords do not match.");
                isValid = false;
            }

            // Submit form if all validations pass
            if (isValid) {
                this.submit();
            }
        });

        function showError(selector, message) {
            $(selector).text(message).removeClass("d-none");
        }

        function clearErrors() {
            $(".text-danger").text("").addClass("d-none");
        }
    });
</script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#signup-form").on("submit", function (event) {
            console.log($("#password-error").length ? "Found #password-error" : "Did NOT find #password-error");
            let isValid = true;
            event.preventDefault(); // Stop form submission for testing

            // Get input values
            let name = $.trim($("#signup-firstname").val());
            let email = $.trim($("#signup-email").val());
            let username = $.trim($("#signup-username").val());
            let UserPassword = $.trim($("#signup-password").val());
            let confirmPassword = $.trim($("#signup-password-confirm").val());

            // Debugging: Log values
            console.log("Name:", name);
            console.log("Email:", email);
            console.log("Username:", username);
            console.log("Password:", UserPassword, "| Length:", UserPassword.length);
            console.log("Confirm Password:", confirmPassword);

            // Clear previous errors
            clearErrors();

            // Validate Name
            if (name === "") {
                showError("#name-error", "Full Name is required.");
                isValid = false;
            }

            // Validate Email
            if (email === "") {
                showError("#email-error", "Email is required.");
                isValid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                showError("#email-error", "Invalid email format.");
                isValid = false;
            }

            // Validate Username
            if (username === "") {
                showError("#username-error", "Username is required.");
                isValid = false;
            }

            // ✅ Debugging: Log password validation condition
            if (UserPassword === "") {
                console.log("Password is empty!");
                $("#length-error").text("Password is required.");
                showError("#password-error", "Password is required.");
                isValid = false;
            } else if (UserPassword.length < 8) {
                console.log("Password length issue detected!");
                $("#length-error").text("Password must be at least 8 characters long.");
                showError("#password-error", "Password must be at least 8 characters long.");
                isValid = false;
            }

            // ✅ Validate Confirm Password
            if (confirmPassword === "") {
                showError("#confirm-password-error", "Confirmation Password is required.");
                isValid = false;
            } else if (UserPassword !== confirmPassword) {
                console.log("Password mismatch detected!");
                showError("#confirm-password-error", "Passwords do not match.");
                isValid = false;
            }

            // ✅ Stop submission if invalid
            if (!isValid) {
                console.log("Form validation failed. Errors shown.");
                return false;
            }

            console.log("Form validation passed! Submitting...");
            this.submit();
        });

        function showError(selector, message) {
            $(selector).text(message).removeClass("d-none").css("display", "block");
        }

        function clearErrors() {
            $(".text-danger").text("").addClass("d-none");
        }
    });
</script>


{{-- Check Email & Username Availability --}}
<script>
    $(document).ready(function () {
        function checkAvailability(field, value, errorElement) {
            if (value.length < 3) {
                $(errorElement).addClass("d-none");
                return;
            }

            $.ajax({
                url: "{{ route('checkAvailability') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $("input[name='_token']").val()
                },
                contentType: "application/json",
                data: JSON.stringify({ field: field, value: value }),
                success: function (data) {
                    if (data.exists) {
                        $(errorElement).text(field.charAt(0).toUpperCase() + field.slice(1) + " is already taken.").removeClass("d-none");
                    } else {
                        $(errorElement).addClass("d-none");
                        $(errorElement).removeClass("text-danger");
                    }
                },
                error: function (xhr) {
                    console.error("Error:", xhr);
                }
            });
        }

        $("#signup-username").on("input", function () {
            checkAvailability("username", $(this).val(), "#username-error");
        });

        $("#signup-email").on("input", function () {
            checkAvailability("email", $(this).val(), "#email-error");
        });
    });
</script>

{{-- Login --}}
<script>
    $(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("Success Response:", response);
                if (response.success) {
                    window.location.href = '/'; // Redirect if login is successful
                    
                }
                
            },
            error: function(xhr) {
                console.log("Error Response:", xhr.responseText); // Debugging

                var errors = xhr.responseJSON.errors;

                // Remove previous error messages
                $('.error-message').remove();

                // Display new error messages
                $.each(errors, function(field, message) {
                    $('[name="' + field + '"]').after('<small class="text-danger error-message my-3">' + message + '</small>');
                });
            }
        });
    });
    }); 
</script>

</body>


</html>