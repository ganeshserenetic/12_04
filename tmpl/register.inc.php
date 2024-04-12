
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
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
                            <form id="registationform">

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                        <label class="form-label" for="firstName">First Name</label>
                                            <input type="text" name="firstName" id="firstName"
                                                class="form-control form-control-lg" />
                                                <span id="firstName-error" class="error-message" style="color: red;"></span>

                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                        <label class="form-label" for="lastName">Last Name</label>
                                            <input type="text" name="lastName" id="lastName"
                                                class="form-control form-control-lg" />
                                            <span id="lastName-error" class="error-message" style="color: red;"></span>
                                        </div>

                                    </div>
                                </div>

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

                                      

                                        <label for="cars">Gender:</label>

                                        <select name="gender" id="gender">
                                            <option value="male">male</option>
                                            <option value="female">female</option>
                                            <option value="other">other</option>

                                        </select>
                                        <span id="gender-error" class="error-message" style="color: red;"></span>



                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div class="form-outline">
                                            <label class="form-label" for="phoneNumber">Phone Number</label>
                                                <input type="tel" name="phoneNumber" id="phoneNumber"
                                                    class="form-control form-control-lg" />
                                                
                                                <span id="phoneNumber-error" class="error-message" style="color: red;"></span>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">


                                            <div class="form-outline">
                                            <label class="form-label" for="password">Password</label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control form-control-lg" />
                                                
                                                <span id="password-error" class="error-message" style="color: red;"></span>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">


                                        <!-- </div> -->
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div class="form-outline">
                                            <label class="form-label" for="ConfirmPassword"> Confirm
                                                    Password</label>
                                                <input type="password" id="ConfirmPassword" name="ConfirmPassword"
                                                    class="form-control form-control-lg" />
                                               
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input class="form-check-input me-2" type="checkbox" value="1" name="terms"
                                            id="form2Example3cg" style="position: unset;" />
                                        <label class="form-check-label" for="form2Example3g">
                                            I agree all statements in <a href="#!" class="text-body"><u>Terms of
                                                    service</u></a>
                                        </label>
                                    </div>
                                    <div class="mt-4 pt-2">
                                        <input class="btn btn-primary btn-lg" type="submit" />
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
            $('#registationform').submit(function (e) {
                e.preventDefault();
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var gender = $('#gender').val();
                var phoneNumber = $('#phoneNumber').val();

                $.ajax({
                    type: 'POST',
                    url: 'ajax_register.php',
                    data: {
                        firstName: firstName,
                        lastName: lastName,
                        email: email,
                        password: password,
                        gender: gender,
                        phoneNumber: phoneNumber,
                    },
                    dataType: 'json',
                    cache: false,
                    success: function (dataResult) {

                        if (dataResult && dataResult.statusCode == 200) {

                            // Display a success message using Toastr store mate
                            sessionStorage.setItem('successMessage', dataResult.message);
                            // Clear form fields
                            $('#registationform')[0].reset();
                            // window.location.reload();

                            // console.log(dataResult);
                            window.location.href = "login.php";

                            
                        } else {
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
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText); // Log detailed error response


                        if (xhr.status === 400) {
                            // Bad request, handle the error message
                            var errorMessage = JSON.parse(xhr.responseText);
                            alert("Bad Request: " + errorMessage[
                                0
                            ]); // Assuming the error message is in the first position of the array
                        } else {
                            // Ajax request failed for other reasons
                            toastr.error(error);
                            console.error("An error occurred: ", error);
                        }
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

