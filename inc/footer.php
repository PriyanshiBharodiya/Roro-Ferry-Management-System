<!-- footer -->
<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="h-font fw-bold fs-3 mb-2">Your Gateway to Travel 🚢</h3>
            <p>Travel with ease on our reliable RORO ferries, 
                offering seamless connections between destinations with comfort and efficiency...</p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Links</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilites</a><br>
            <a href="trip.php" class="d-inline-block mb-2 text-dark text-decoration-none">Trip</a><br>
            <a href="contact-us.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contect-Us</a><br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About-Us</a><br>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Follow Us</h5>
            <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none"> <i
                    class="bi bi-twitter-x me-1"></i>Twitter</a><br>
            <a href="https://www.facebook.com/people/Langkawi-Roro-Ferry-Services-Sdn-Bhd/100067903778418/"
                class="d-inline-block mb-2 text-dark text-decoration-none"> <i
                    class="bi bi-facebook me-1"></i>Facebook</a><br>
            <a href="https://www.instagram.com/dgseaconnect/"
                class="d-inline-block mb-2 text-dark text-decoration-none"> <i
                    class="bi bi-instagram me-1"></i>Instagram</a><br>
            <!-- <a href="#" class="d-inline-block  text-dark text-decoration-none"> <i
                    class="bi bi-threads me-1"></i>Threads</a><br> -->
        </div>
    </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0">Design and Develop by Roro Ferry Developer</h6>

<!-- script for bootstarp -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- register script -->
<script>
    $(document).ready(function () {
        $("#register-form").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this); // Create FormData from the form
            $.ajax({
                url: "ajax/register_user.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response); // Log response for debugging

                    if (response.trim() === "success") {
                        alert("A verification email has been sent. Please check your inbox and verify your account!");

                        // Clear the form after success
                        $("#register-form")[0].reset();

                        // Hide the modal
                        var myModal = document.getElementById('registermodal');
                        var modal = bootstrap.Modal.getInstance(myModal);
                        modal.hide();

                    } else if (response.trim() === "error_uploading_image") {
                        alert("Failed to upload image. Try again.");
                    } else {
                        alert("Error: " + response);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("AJAX Error: " + error);
                }
            });
        });
    });

</script>

<!-- login script -->
<script>
  $(document).ready(function () {
    $("#login-form").submit(function (e) {
        e.preventDefault();

        let email = $("#email").val();
        let password = $("#password").val();
        let role = $("#role").val();

        $.ajax({
            url: "ajax/login.php",
            type: "POST",
            data: { email: email, password: password, role: role },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    location.reload();
                } else if (response.status === "admin") {
                    window.location.href = "admin/dashboard.php"; 
                } else {
                    alert(response.message);
                }
            }
        });
    });
});

</script>


<!-- forgot password -->
<script>
    $(document).ready(function () {
        $("#forgot-password-form").submit(function (e) {
            e.preventDefault();
            let email = $("#forgot-email").val();

            $.ajax({
                type: "POST",
                url: "/roroferry/ajax/forgot_password.php",
                data: { email: email },
                success: function (response) {
                    alert(response);
                },
                error: function () {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>