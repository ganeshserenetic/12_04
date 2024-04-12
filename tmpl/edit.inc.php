
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
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">edit Form</h3>
                            <form id="editform">

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                        <label class="form-label" for="firstName">First Name</label>
                                        <input type="hidden"  value="<?php echo $resQry['id']; ?>" name="id" id="id">
                                            <input type="text" name="firstName" id="firstName"
                                                class="form-control form-control-lg" value="<?php echo $resQry['firstname']; ?>" />
                                                <span id="firstname-error" class="error-message" style="color: red;"></span>

                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                        <label class="form-label" for="lastName">Last Name</label>
                                            <input type="text" name="lastName" id="lastName"
                                                class="form-control form-control-lg" value="<?php echo $resQry['lastname']; ?>" />
                                            <span id="lastname-error" class="error-message" style="color: red;"></span>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 d-flex align-items-center">

                                        <div class="form-outline">
                                        <label class="form-label" for="email">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control form-control-lg" value="<?php echo $resQry['email']; ?>" />
                                            <span id="email-error" class="error-message" style="color: red;"></span>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                      

                                        <label for="cars">Gender:</label>

                                        <select name="gender" id="gender"   >
                                            <option value="male" <?php if ($resQry['gender'] == 'male') echo 'selected'; ?>>male</option>
                                            <option value="female"<?php if ($resQry['gender'] == 'female') echo 'selected'; ?>>female</option>
                                            <option value="other"<?php if ($resQry['gender'] == 'other') echo 'selected'; ?>>other</option>

                                        </select>
                                        <span id="gender-error" class="error-message" style="color: red;"></span>



                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">

                                            <div class="form-outline">
                                            <label class="form-label" for="phoneNumber">Phone Number</label>
                                                <input type="tel" name="phoneNumber" id="phoneNumber"
                                                    class="form-control form-control-lg" value="<?php echo $resQry['phonenumber']; ?>" />
                                                
                                                <span id="phonenumber-error" class="error-message" style="color: red;"></span>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-4 pb-2">


                                            <!-- <div class="form-outline">
                                            <label class="form-label" for="password">Password</label>
                                                <input type="text" name="password" id="password"
                                                    class="form-control form-control-lg" value="<?php echo $resQry['password']; ?>" />
                                                
                                                <span id="password-error" class="error-message" style="color: red;"></span>
                                            </div> -->

                                        </div>

                                    </div>
                             
                                    <div class="mt-4 pt-2">
                                        <!-- <input class="btn btn-primary btn-lg" type="submit" /> -->
                                        <button type="submit" class="btn btn-primary btn-lg">Update</button>
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
            $('#editform').submit(function (e) {
                e.preventDefault();
                var id = $('#id').val();
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var email = $('#email').val();
                var gender = $('#gender').val();
                var phoneNumber = $('#phoneNumber').val();

                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: 'ajax_update.php',
                    data: {
                        id:id,
                        firstname: firstName,
                        lastname: lastName,
                        email: email,
                        gender: gender,
                        phonenumber: phoneNumber,
                    },
                    dataType: 'json',
                    cache: false,
                    success: function (dataResult) {

                        if (dataResult && dataResult.statusCode == 200) {

                            // Display a success message using Toastr store mate
                            sessionStorage.setItem('successMessage', dataResult.message);
                            // Clear form fields
                            // $('#registationform')[0].reset();
                            // window.location.reload();

                            // console.log(dataResult);
                            window.location.href = "home.php";

                            
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

