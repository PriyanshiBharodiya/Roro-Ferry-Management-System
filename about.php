<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoRoferry-About us</title>

    <!-- js file  -->

    <!-- swiper js cdn link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <?php include('inc/links.php'); ?>
    <style>
    .box {
        border-top-color: var(--teal) !important;
    }

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .content {
        flex: 1;
    }

    footer {
        width: 100%;
        margin-top: auto; /* 👈 this is the key to stick it to the bottom */
    }

    .swiper-slide {
        max-width: 260px;
    }
</style>

</head>

<body class="bg-light">
    <?php
    require('inc/header.php');
    include "inc/connection.php"
    ?>

    <!-- Begin content wrapper -->
    <div class="content">
        <div class="my-5 px-4">
            <h2 class="fw-bold h-font text-center">ABOUT-US</h2>
            <div class="h-line bg-dark"></div>
            <br>
            <p class="text-center mt-3">
                <center>
                    <h4>Meet Your Travel Partner – RoRoferry 🧳</h4>
                </center>
            </p>
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <img src="images/about/ship.jpg" style="height: 300px;" class="img-fluid " />
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                        RoRoferry is India’s first RORO ferry service, launched in 2017. 
                        It helps save travel time and makes journeys faster and easier. 
                        Our mission is to care for the environment, ensure safety, offer shipping insurance, 
                        and follow high ethical standards while always improving our service. 
                        We aim to give you a smooth and secure travel experience. 
                        With RoRoferry, your journey becomes more comfortable, safe, and reliable.
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                        <h2 class="mb-3"> <b>RoRoferry at a Glance</b></h2>
                        <p>We provide a website for customers who wish to travel by ship through RoRoferry. 
                            Our system offers complete information about available ships, travel schedules, and seat availability — 
                            all managed by the admin. Users can easily check ship schedules and book tickets for the number of passengers they need.</p>

                        <h5>Why Choose Us</h5>

                        <div class="our-mission">
                            <li style="list-style:none;" class="our-"><i class="bi bi-caret-right-fill"
                                    aria-hidden="true"></i></i> <a href="#" style="text-decoration:none;" class="text-dark">
                                    Wide Range of Destinations</a></li>
                            <li style="list-style:none;"><i class="bi bi-caret-right-fill" aria-hidden="true"></i> <a
                                    href="#" style="text-decoration:none;" class="text-dark"> Honest and Reliable Service</a>
                            </li>
                            <li style="list-style:none;"><i class="bi bi-caret-right-fill" aria-hidden="true"></i> <a
                                    href="#" style="text-decoration:none;" class="text-dark"> Largest Ship Network</a></li>
                            <li style="list-style:none;"><i class="bi bi-caret-right-fill" aria-hidden="true"></i> <a
                                    href="#" style="text-decoration:none;" class="text-dark"> Goods tracking Support</a>
                            </li>
                            <li style="list-style:none;"><i class="bi bi-caret-right-fill" aria-hidden="true"></i> <a
                                    href="#" style="text-decoration:none;" class="text-dark"> Strong Sea Security</a></li>
                            <li style="list-style:none;"><i class="bi bi-caret-right-fill" aria-hidden="true"></i> <a
                                    href="#" style="text-decoration:none;" class="text-dark"> 24/7 Customer Support</a></li>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                        <img src="images/carousel/ab.jpg" class="w-100">
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4 px-4 ">
                        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                            <img src="images/about/gift.jpg" width="70px">
                            <h4 class="mt-3"> Packages</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 px-4 ">
                        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                            <img src="images/about/customers.jpg" width="70px">
                            <h4 class="mt-3"> Customers</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 px-4 ">
                        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                            <img src="images/carousel/rew3.jpg" width="70px">
                            <h4 class="mt-3"> Reviews</h4>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 px-4 ">
                        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                            <img src="images/carousel/FERRY.jpg" width="70px">
                            <h4 class="mt-3">Ferry</h4>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="my-4 fw-bold h-font text-center">OUR MANAGEMENT TEAM</h3>
            <div class="container px-2">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php
                        $team_q = mysqli_query($con, "SELECT * FROM `team`");
                        while ($row = mysqli_fetch_assoc($team_q)) {
                            echo <<<HTML
                                    <div class="swiper-slide bg-white text-center overflow-hidden p-4 shadow-sm mx-auto"
                                        style="max-width: 260px; margin: 5%;">
                                        <img src="{$row['picture']}"
                                            class="w-100 d-block mx-auto"
                                            style="height: 240px; object-fit: cover; object-position: top;"
                                            alt="{$row['name']}">
                                        <h6 class="mt-3 mb-0" style="font-size: 14px;">{$row['name']}</h6>
                                    </div>
                              HTML;
                        }
                        ?>
                    </div>
                    <br><br>
                    <div class="swiper-pagination mt-2"></div>
                </div>
            </div>
        </div> <!-- End .content -->

    <?php require('inc/footer.php'); ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 40,
            centeredSlides: true,
            initialSlide: 1,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>
</body>

</html>
