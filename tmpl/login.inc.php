
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #f093fb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to bottom right, rgba(240, 147, 251, 1), rgba(0, 87, 108, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to bottom right, rgba(240, 147, 251, 1), rgba(0, 87, 108, 1))
        }

        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }
    </style>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Login</h3>
                            <form id="loginform">
                                <div class="row">
                                    <div class="col-md-6 mb-4 d-flex align-items-center">

                                        <div class="form-outline">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control form-control-lg" />
                                            <span id="email-error" class="error-message" style="color: red;"></span>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control form-control-lg" />

                                            <span id="password-error" class="error-message" style="color: red;"></span>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-2">
                                        <!-- <input class="btn btn-primary btn-lg" type="submit"/>login -->
                                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function () {
            $('#loginform').submit(function (e) {
                e.preventDefault();

                var email = $('#email').val();
                var password = $('#password').val();

                console.log(email);
                console.log(password);
                $.ajax({
                    type: 'POST',
                    url: 'ajax_login.php',
                    data: {
                        email: email,
                        password: password
                    },
                    dataType: 'json',
                    cache: false,
                    success: function (dataResult) {
                        console.log(dataResult); // Log detailed error response

                        if (dataResult && dataResult.statusCode == 200) {

                            // Display a success message using Toastr store mate
                            // sessionStorage.setItem('successMessage', dataResult.message);
                            // Clear form fields
                            // $('#registationform')[0].reset();
                            // window.location.reload();
                            // Headers("Location:registe.php");
                            window.location.href = "home.php";

                            toastr.success(dataResult.message);
                        }
                        else {
                            // Display an error message using Toastr

                            console.log(dataResult);
                            // toastr.error(dataResult.error);

                            $('.error-message').text('');

                            // Loop through the errors object
                            $.each(dataResult, function (fieldName, errorMessage) {
                                // Find the error message element corresponding to the field
                                var errorElement = $('#' + fieldName + '-error');
                                if (errorElement.length) {
                                    // Update the error message text
                                    errorElement.text(errorMessage);
                                }
                            });

                        }
                        console.log(dataResult);
                        toastr.error(dataResult.message);

                    },
                    error: function (xhr, status, error) {
                        console.error(xhr); // Log detailed error response
                        toastr.error(xhr.message);
                    }
                });
            });
        });

    </script>

    <script>
        // Check if there's a success message stored in sessionStorage
        var successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            // Display the success message using Toastr
            toastr.success(successMessage);

            // Clear the stored success message from sessionStorage
            sessionStorage.removeItem('successMessage');
        }
    </script>

