<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROROferry - FACILITIES</title>

    <!-- js file  -->

    <?php 
    include('inc/links.php');
    include "inc/connection.php"
     ?>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>

</head>
<?php
session_start();

if (isset($_SESSION['logged_in'])) {
    
?>
    <script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/67f9fe44db1039190df385be/1iok8ifu8';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
    </script>
<?php
}
?>


<body class="bg-light">
    <!-- header -->
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Your feedback matters to us. Contact us anytime, and we’ll be happy to assist.</p>

    </div>
    <div class="container">
        <div class="row">



            <?php
            $contact_r = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM admin_contact WHERE id=1"));
            ?>

            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">

                    <!-- Google Map -->
                    <iframe class="w-100 rounded" height="320px" src="<?= $contact_r['iframe'] ?>" loading="lazy"
                        allowfullscreen></iframe>

                    <!-- Address -->
                    <h5 class="mt-4">HEAD OFFICE</h5>
                    <a href="<?= $contact_r['gmap'] ?>" target="_blank"
                        class="d-inline-block text-decoration-none text-dark mb-2">
                        <i class="bi bi-geo-alt"></i> <?= $contact_r['address'] ?>
                    </a>

                    <!-- Phone -->
                    <h5 class="mt-4">Call Us</h5>
                    <a href="tel:+<?= $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91<?= $contact_r['pn1'] ?>
                    </a>
                    <?php if (!empty($contact_r['pn2'])): ?>
                        <br>
                        <a href="tel:+<?= $contact_r['pn2'] ?>" class="d-inline-block text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> +91<?= $contact_r['pn2'] ?>
                        </a>
                    <?php endif; ?>

                    <!-- Email -->
                    <h5 class="mt-4">E-mail</h5>
                    <a href="mailto:<?= $contact_r['email'] ?>"
                        class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-envelope"></i> <?= $contact_r['email'] ?>
                    </a>

                    <!-- Social Media -->
                    <h5 class="mt-4">Follow Us</h5>
                    <?php if (!empty($contact_r['tw'])): ?>
                        <a href="<?= $contact_r['tw'] ?>" class="d-inline-block mb-3 text-dark fs-5 me-2">
                            <i class="bi bi-twitter-x me-1"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($contact_r['fb'])): ?>
                        <a href="<?= $contact_r['fb'] ?>" class="d-inline-block mb-3 text-dark fs-5 me-2">
                            <i class="bi bi-facebook"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($contact_r['insta'])): ?>
                        <a href="<?= $contact_r['insta'] ?>" class="d-inline-block text-dark fs-5">
                            <i class="bi bi-instagram"></i>
                        </a>
                    <?php endif; ?>

                </div>
            </div>


            <div class="col-lg-6 col-mg-6  px-4">
                <div class="bg-white rounded shadow p-4">
                    <form id="contactForm" action="#" method="POST">
                        <h5>Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500">Name</label>
                            <input name="name" required type="text" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500">E-mail</label>
                            <input name="email" required type="email" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500">Subject</label>
                            <input name="subject" required type="text" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500">Message</label>
                            <textarea name="message" required class="form-control" rows="5"
                                style="resize: none"></textarea>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow mt-3">SEND</button>
                    </form>
                </div>
            </div>



        </div>
    </div>



    <script>
        $(document).ready(function () {
            $("#contactForm").on("submit", function (e) {
                e.preventDefault(); // Prevent page refresh

                $.ajax({
                    type: "POST",
                    url: "insert_contact.php", // Corrected path
                    data: $(this).serialize(),
                    success: function (response) {
                        response = response.trim(); // Trim any whitespace
                        if (response === "1") {
                            alert("Message sent successfully!");
                            $("#contactForm")[0].reset(); // Reset form
                        } else {
                            alert("Error: " + response);
                        }
                    },
                    error: function () {
                        alert("An AJAX error occurred.");
                    }
                });
            });
        });
    </script>


    <?php require('inc/footer.php'); ?>

</body>

</html>