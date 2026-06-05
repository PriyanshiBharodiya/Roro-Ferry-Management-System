<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <img src="images/carousel/ship_logo.png" style="height:50px" class="me-2">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">
            <span style="color: #004080;">Roro</span><span style="color: #20b2aa;">Ferry</span>
        </a>

        <button class="navbar-toggler shadow-sm" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-2"><a class="nav-link active" href="index.php">Home</a></li>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Facilities
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="club1.php">Club</a></li>
                        <li><a class="dropdown-item" href="pool.php">Swimming pool</a></li>
                        <li><a class="dropdown-item" href="cinema hall.php">Cinema hall</a></li>
                        <li><a class="dropdown-item" href="gym.php">Gym</a></li>
                        <li><a class="dropdown-item" href="hotel.php">Hotel</a></li>
                        <li><a class="dropdown-item" href="hall.php">Dining hall</a></li>
                        <li><a class="dropdown-item" href="gamezone.php">Game zone</a></li>
                    </ul>
                </div>
                <li class="nav-item me-2"><a class="nav-link" href="trip.php">Trip</a></li>
                <li class="nav-item me-2"><a class="nav-link" href="contact-us.php">Contact-Us</a></li>
                <li class="nav-item me-2"><a class="nav-link" href="about.php">About-Us</a></li>
            </ul>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- My Bookings Button -->
                <a href="booking.php" class="btn btn-outline-primary me-3">
                    My Bookings
                </a>

                <!-- Show Profile Image & Name for Logged-in Users -->
                <div class="d-flex align-items-center">
                    <?php
                    $profileImage = 'images/USER_PROFILE_IMAGE/default.jpg';
                    if (!empty($_SESSION['profile'])) {
                        $imagePath = 'images/USER_PROFILE_IMAGE/' . $_SESSION['profile'];
                        if (file_exists($imagePath)) {
                            $profileImage = $imagePath;
                        }
                    }
                    ?>
                    <img src="<?php echo $profileImage; ?>" alt="Profile" class="rounded-circle me-2" width="40" height="40"
                        onerror="this.onerror=null;this.src='images/USER_PROFILE_IMAGE/aaa.jpg';">
                    <span class="fw-bold"><?php echo $_SESSION['name'] ?? 'User'; ?></span>

                    <?php if (!empty($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <a href="admin/dashboard.php" class="btn btn-outline-primary ms-3">Admin Panel</a>
                    <?php endif; ?>

                    <a href="ajax/logout.php" class="btn btn-outline-dark ms-3">Logout</a>
                </div>
            <?php else: ?>
                <!-- Show Login & Register Buttons if Not Logged In -->
                <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal"
                    data-bs-target="#loginmodal">Login</button>

                <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal"
                    data-bs-target="#registermodal">Register</button>
            <?php endif; ?>
        </div>
    </div>
</nav>


<!-- Login Modal -->
<div class="modal fade" id="loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4"
            style="border-radius: 12px; background: #ffffff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">

            <!-- Close Button -->
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                aria-label="Close"></button>

            <form id="login-form" class="p-3">
                <h4 class="text-center text-dark mb-3 fw-bold">Login</h4>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label text-dark">E-mail</label>
                    <input type="email" id="email" class="form-control shadow-none text-dark border"
                        placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label text-dark">Password</label>
                    <input type="password" id="password" class="form-control shadow-none text-dark border"
                        placeholder="Enter your password" required>
                </div>

                <!-- Role Selection -->
                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold fs-5">Login As:</label>
                    <select id="role" class="form-select shadow-none border text-dark" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>


                <!-- Forgot Password -->
                <div class="text-end mb-3">
                    <a href="javascript:void(0);" class="text-primary text-decoration-none" data-bs-toggle="modal"
                        data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal" style="font-size: 14px;">
                        Forgot password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn w-100 shadow-none text-white"
                    style="background: linear-gradient(to right, #007BFF, #C32BAD); border-radius: 25px; font-weight: bold; padding: 10px 0;">
                    Login
                </button>

                <!-- Not Registered? -->
                <div class="text-center mt-3">
                    <small class="text-dark">Not have an account?
                        <a href="javascript:void(0);" class="text-primary text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#registermodal" data-bs-dismiss="modal">Register now</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register Modal -->
<!-- Register Modal -->
<div class="modal fade" id="registermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4"
            style="border-radius: 12px; background: #ffffff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">

            <!-- Close Button -->
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                aria-label="Close"></button>

            <form class="p-3 needs-validation" id="register-form" novalidate>
                <h4 class="text-center text-dark mb-3 fw-bold">Register Your Profile</h4>

                <!-- Name & Email -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark">Name</label>
                        <input type="text" class="form-control shadow-none text-dark border" name="name"
                            placeholder="Enter full name" required pattern="^[A-Za-z\s]{2,50}$"
                            title="Name should be 2-50 alphabetic characters">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Enter a valid name (2-50 letters).</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark">Email</label>
                        <input type="email" class="form-control shadow-none text-dark border" name="email"
                            placeholder="Enter email" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Enter a valid email address.</div>
                    </div>
                </div>

                <!-- Phone & Picture -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark">Phone Number</label>
                        <input type="tel" class="form-control shadow-none text-dark border" name="phonenum"
                            placeholder="Enter phone number" required pattern="^[0-9]{10}$"
                            title="Phone number should be 10 digits">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Phone number should be 10 digits.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark">Picture</label>
                        <input type="file" name="profile" class="form-control shadow-none text-dark border"
                            accept="image/*">
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label class="form-label text-dark">Address</label>
                    <textarea class="form-control shadow-none text-dark border" name="address" rows="2"
                        placeholder="Enter your address" required></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Address cannot be empty.</div>
                </div>

                <!-- Pincode & DOB -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark">Pincode</label>
                        <input type="text" class="form-control shadow-none text-dark border" name="pincode"
                            placeholder="Enter pincode" required pattern="^[1-9][0-9]{5}$"
                            title="Pincode must be 6 digits starting with 1-9">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Enter a valid 6-digit pincode.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark">Date of Birth</label>
                        <input type="date" name="dob" class="form-control shadow-none text-dark border" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select your date of birth.</div>
                    </div>
                </div>

                <!-- Password & Confirm Password -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark">Password</label>
                        <input type="password" name="pass" class="form-control shadow-none text-dark border"
                            placeholder="Enter password" required
                            pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                            title="At least 8 chars, 1 letter, 1 number, 1 special char">
                        <div class="valid-feedback">Strong password!</div>
                        <div class="invalid-feedback">Must be 8+ chars with letter, number & special char.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark">Confirm Password</label>
                        <input type="password" name="cpass" class="form-control shadow-none text-dark border"
                            placeholder="Confirm password" required>
                        <div class="valid-feedback">Passwords match!</div>
                        <div class="invalid-feedback" id="cpass-feedback">Passwords do not match.</div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn w-100 shadow-none text-white"
                    style="background: linear-gradient(to right, #007BFF, #C32BAD); border-radius: 25px; border: none; font-weight: bold; padding: 10px 0;">
                    Register
                </button>

                <!-- Login redirect -->
                <div class="text-center mt-3">
                    <small class="text-dark">Already have an account?
                        <a href="javascript:void(0);" class="text-primary text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#loginmodal" data-bs-dismiss="modal">Login here</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4"
            style="border-radius: 12px; background: #ffffff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">

            <!-- Close Button -->
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                aria-label="Close"></button>

            <form id="forgot-password-form" class="p-3">
                <h4 class="text-center text-dark mb-3 fw-bold">Reset Password</h4>

                <!-- Email Input -->
                <div class="mb-3">
                    <label class="form-label text-dark">Enter your registered email</label>
                    <input type="email" id="forgot-email" class="form-control shadow-none text-dark border"
                        placeholder="Enter your email" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn w-100 shadow-none text-white"
                    style="background: linear-gradient(to right, #007BFF, #C32BAD); border-radius: 25px; font-weight: bold; padding: 10px 0;">
                    Send Reset Link
                </button>

                <!-- Back to Login -->
                <div class="text-center mt-3">
                    <small class="text-dark">Remembered your password?
                        <a href="javascript:void(0);" class="text-primary text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#loginmodal" data-bs-dismiss="modal">Login here</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Profile Update Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="updateProfileForm" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label>Name</label><input type="text" name="name" id="name" class="form-control" required></div>
          <div class="col-md-6"><label>Email</label><input type="email" name="email" id="email" class="form-control" required></div>
          <div class="col-md-6"><label>Phone</label><input type="text" name="phonenum" id="phonenum" class="form-control" required></div>
          <div class="col-md-6"><label>Address</label><input type="text" name="address" id="address" class="form-control" required></div>
          <div class="col-md-6"><label>Pincode</label><input type="text" name="pincode" id="pincode" class="form-control" required></div>
          <div class="col-md-6"><label>Date of Birth</label><input type="date" name="dob" id="dob" class="form-control" required></div>
          <div class="col-md-6"><label>Profile Image</label><input type="file" name="profile" id="profile" class="form-control" accept="image/*"></div>
          <div class="col-md-6"><img id="previewImage" src="" alt="Preview" class="img-thumbnail mt-3" width="100"></div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="action" value="update_profile">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- jQuery + AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  $('#profileModal').on('show.bs.modal', function () {
    $.post('ajax/profile.php', { action: 'fetch_profile' }, function (res) {
      $('#name').val(res.name);
      $('#email').val(res.email);
      $('#phonenum').val(res.phonenum);
      $('#address').val(res.address);
      $('#pincode').val(res.pincode);
      $('#dob').val(res.dob);
      $('#previewImage').attr('src', 'images/USER_PROFILE_IMAGE/' + res.profile);
    }, 'json');
  });

  $('#updateProfileForm').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: 'profile.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (res) {
        alert('Profile Updated!');
        $('#profileModal').modal('hide');
        location.reload();
      }
    });
  });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');
    const inputs = form.querySelectorAll('input, textarea');
    const password = form.querySelector('input[name="pass"]');
    const confirmPassword = form.querySelector('input[name="cpass"]');
    const cpassFeedback = document.getElementById('cpass-feedback');

    // Validate inputs on change
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            validateField(input);
            if (input.name === 'cpass' || input.name === 'pass') {
                checkPasswordMatch();
            }
        });
    });

    function validateField(input) {
        if (input.checkValidity()) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    }

    function checkPasswordMatch() {
        if (confirmPassword.value === password.value && confirmPassword.value !== '') {
            confirmPassword.classList.remove('is-invalid');
            confirmPassword.classList.add('is-valid');
            cpassFeedback.textContent = 'Passwords match!';
        } else {
            confirmPassword.classList.remove('is-valid');
            confirmPassword.classList.add('is-invalid');
            cpassFeedback.textContent = 'Passwords do not match.';
        }
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let isValid = true;

        inputs.forEach(input => {
            validateField(input);
            if (!input.checkValidity()) {
                isValid = false;
            }
        });

        checkPasswordMatch();

        if (isValid && confirmPassword.value === password.value) {
            alert('Form is valid and ready to be submitted!');
            // form.submit(); // Uncomment this to allow real submission
        } else {
            alert('Fix the errors before submitting.');
        }
    });
});
</script>
