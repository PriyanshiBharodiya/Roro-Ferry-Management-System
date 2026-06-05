<?php
if (isset($_SESSION['password_reset_success'])) {
    echo "<script>alert('" . $_SESSION['password_reset_success'] . "');</script>";
    unset($_SESSION['password_reset_success']); // Remove message after displaying
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roro Ferry-Home</title>

    <!-- links -->
    <?php require('inc/links.php') ?>
    <?php include "inc/connection.php" ?>
    <style>
        .availablity-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and(max-width: 575px) {
            .availablity-form {
                margin-top: 25px;
                padding: 0 35px;
            }
        }

        .card {
            height: 100%; /* ensures card takes full height of its container */
            min-height: 600px; /* adjust as needed */
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

    </style>

</head>

<body class="bg-light">

    <!-- For Header -->
    <?php require('inc/header.php'); ?>

    <!-- swiper js html code for image slideing -->
    <div class="container-fluid" px-lg-4 mt-4>
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php
                $query = "SELECT * FROM `carousel`";
                $result = mysqli_query($con, $query);

                $path = 'admin/uploads/';

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $img = htmlspecialchars($row['image']);
                        $src = $path . $img;

                        echo <<<HTML
                            <div class="swiper-slide">
                                <img src="{$src}" class="w-100 d-block" alt="carousel image">
                            </div>
                            HTML;
                    }
                }
                ?>

                <!-- <div class="swiper-slide">
                    <img src="images/carousel/JAHAJ1.jpg" class="w-100 d-block">
                </div>
                <div class="swiper-slide">
                    <img src="images/carousel/JAHAJ2.jpg" class="w-100 d-block">
                </div>
                <div class="swiper-slide">
                    <img src="images/carousel/JAHAJ3.jpg" class="w-100 d-block">
                </div> -->
            </div>

        </div>
    </div>

    <!-- ckeck availablity form -->
    <div class="container availablity-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Schedule Availability</h5>
                <form action="schedule.php" method="POST">
                    <div class="row align-items-end">

                        <!-- From Dropdown -->
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" style="font-weight: 500;">From</label>
                            <select name="from_location" class="form-select shadow-none" required>
                                <option value="" selected disabled>Select Departure Location</option>
                                <option value="Bhavnagar">Bhavnagar</option>
                                <option value="Hajira">Hajira</option>
                                <option value="Porbandar">Porbandar</option>
                                <option value="Veraval">Veraval</option>
                            </select>
                        </div>

                        <!-- To Dropdown -->
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" style="font-weight: 500;">To</label>
                            <select name="to_location" class="form-select shadow-none" required>
                                <option value="" selected disabled>Select Destination</option>
                                <option value="Bhavnagar">Bhavnagar</option>
                                <option value="Hajira">Hajira</option>
                                <option value="Porbandar">Porbandar</option>
                                <option value="Veraval">Veraval</option>
                            </select>
                        </div>

                        <!-- Date Selection -->
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight:500">Date</label>
                            <input type="date" id="travel_date" name="travel_date" class="form-control shadow-none"
                                required>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- our packages -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR PACKAGES</h2>
    <div class="container">
        <div class="row">

            <?php
            // Fetch 3 latest packages with status=1 and removed=0
            $package_q = mysqli_query($con, "SELECT * FROM `package` WHERE `status`=1 AND `removed`=0 ORDER BY `pid` DESC LIMIT 3");

            while ($package_data = mysqli_fetch_assoc($package_q)) {
                $pid = $package_data['pid'];

                // Fetch features
                $features_data = "";
                $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                INNER JOIN `package_features` pf ON f.feid = pf.feid 
                WHERE pf.pid = '$pid'");
                while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                    $features_data .= "<span class='badge bg-light text-dark text-wrap lh-base me-1 mb-1'>{$fea_row['name']}</span>";
                }

                // Fetch facilities
                $facilities_data = "";
                $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                INNER JOIN `package_facilities` pf ON f.fid = pf.fid 
                WHERE pf.pid = '$pid'");
                while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                    $facilities_data .= "<span class='badge bg-light text-dark text-wrap me-1 mb-1'>{$fac_row['name']}</span>";
                }

                // Fetch thumbnail
                $package_thumb = 'admin/uploads/thumbnail.jpg'; // default thumbnail
                $thumb_q = mysqli_query($con, "SELECT image FROM `package_image` WHERE `pid`='$pid' AND `thumb`=1 LIMIT 1");
                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_data = mysqli_fetch_assoc($thumb_q);
                    $package_thumb = 'admin/uploads/' . $thumb_data['image'];
                }

                // Print package card
                echo <<<HTML
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="card border-0 shadow" style="max-width: 500px; margin: auto;">
                                    <img src="$package_thumb" class="card-img-top" alt="Package Image">
                                    <div class="card-body">
                                        <h5>{$package_data['name']}</h5>
                                        <h6 class="mb-4">₹{$package_data['price']} to start</h6>

                            HTML;

                // Show features section only if available
                if (!empty($features_data)) {
                    echo <<<HTML
                                <div class="features mb-4">
                                    <h6 class="mb-1">Features</h6>
                                    $features_data
                                </div>
                            HTML;
                }

                // Show facilities section only if available
                if (!empty($facilities_data)) {
                    echo <<<HTML
                                <div class="facilities mb-4">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                             HTML;
                }

                echo <<<HTML
                                        <div class="rating mb-4">
                                            <h6 class="mb-1">Rating</h6>
                                            <span class="badge rounded-pill bg-light">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span>
                                        </div>

                                        <!-- <div class="d-flex justify-content-evenly mb-2">
                                            <a href="package_details.php" class="btn w-100 text-white custom-bg shadow-none mb-1">More details</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        HTML;
            }
            ?>
        </div>
    </div>


    <!-- our Facilities -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
            $query = "SELECT * FROM facilities LIMIT 6"; // limit to 6 for this section
            $res = mysqli_query($con, $query);

            $path = 'admin/uploads/';

            while ($row = mysqli_fetch_assoc($res)) {
                echo '
                <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                    <img src="' . $path . $row['icon'] . '" width="80px" alt="' . $row['name'] . '">
                    <h5 class="mt-3">' . $row['name'] . '</h5>
                </div>
            ';
            }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">
                    More Facilities >>
                </a>
            </div>
        </div>
    </div>

    <!-- REVIEWS -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REVIEWS</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">

                <!-- First Review -->
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/facilities/star.png" width="30px" alt="Star Icon">
                        <h6 class="m-0 ms-2">@raj_radadiya</h6>
                    </div>
                    <p>The RORO ferry service was smooth and enjoyable, making for a comfortable and hassle-free journey. 
                        It’s a great option for families looking for a reliable travel experience.</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>

                <!-- Second Review -->
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/facilities/star.png" width="30px" alt="Star Icon">
                        <h6 class="m-0 ms-2">@sahil_gediya14</h6>
                    </div>
                    <p>Fun trip with family and friends. 
                        The ferry was comfortable, had a small cafeteria, and was reasonably priced.</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-half text-warning"></i>
                    </div>
                </div>

                <!-- Third Review -->
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/facilities/star.png" width="30px" alt="Star Icon">
                        <h6 class="m-0 ms-2">@krishaboghra</h6>
                    </div>
                    <p>We’ve visited this beach many times — it’s a great spot for family and friends. 
                        Definitely worth a visit! Just wish the cleanliness was a bit better.</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-half text-warning"></i>
                    </div>
                </div>

            </div>
            <div class="swiper-pagination"></div>
        </div>

    
    </div><br>

    <!-- about us  -->
    <div class="container-fluid "
        style="background: -moz-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(241,241,241,1) 50%, rgba(225,225,225,1) 51%, rgba(246,246,246,1) 100%); /* FF3.6-15 */ background: -webkit-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(241,241,241,1) 50%, rgba(225,225,225,1) 51%, rgba(246,246,246,1) 100%); /* FF3.6-15 */">
        <div class="container py-5">

            <center>
                <h1>Who We Are<span style="font-size:15px; color:#000;" class="ml-3 ms-3"> Where Roads Meet the Sea!</span></h1>
            </center>

            <hr>
            </hr>

            <div class="row">
                <div class="col-12 col-md-6 col-lg-8 ">

                    <div class="ferry">
                        <h3 class="text-center">Connecting Gujarat 🌐 Bridging Distances</h3>
                    </div>
                    <div class="ferry-effect"></div>
                    <hr>
                    </hr>

                    <p><span style="font-size:20px; color:#F00;">Prime Minister Narendra Modi </span>  inaugurated Phase 1 of the ‘roll-on, roll-off (Ro-Ro)’ ferry service between Ghogha and Dahej in Gujarat.
                        The Ro-Ro ferry transports both people and vehicles across the Gulf of Khambhat, linking Ghogha in Bhavnagar with Dahej in Bharuch district.</p>
                        <p>This service significantly reduces travel time between peninsular Saurashtra and South Gujarat by approximately five hours.
                           It's the first project of its kind in India and spans a 31 km route.</p>
                        <p>The first phase of the project was completed at a cost of ₹615 crore. 
                            Although the concept dates back to the 1960s, the foundation stone for the current initiative was laid by Narendra Modi in 2012, during his tenure as Chief Minister of Gujarat.</p>
                        
                    <button class="button button01 mb-2"><a href="about.php"
                            style="text-decoration:none; color:black; ">Read More..</a></button>


                </div>
                <div class="col-12 col-md-6 col-lg-4">

                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" style="border-radius:15px;">
                            <div class="carousel-item active">
                                <img class="d-block w-100 mt-5" src="images/about/SHIPDIAGRAM.png" alt="First slide">
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Reach Us Section -->
    <?php
    $q = "SELECT * FROM admin_contact WHERE id=1";
    $res = mysqli_query($con, $q);
    $contact_r = mysqli_fetch_assoc($res);
    ?>
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
    <div class="container">
        <div class="row">

            <!-- Map -->
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" height="320px" src="<?php echo $contact_r['iframe'] ?>"
                    loading="lazy"></iframe>
            </div>

            <!-- Contact & Social -->
            <div class="col-lg-4 col-md-4">

                <!-- Call Us -->
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call Us</h5>
                    <a href="tel:+<?php echo $contact_r['pn1'] ?>"
                        class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +91<?php echo $contact_r['pn1'] ?>
                    </a><br>

                    <?php if (!empty($contact_r['pn2'])): ?>
                        <a href="tel:+<?php echo $contact_r['pn2'] ?>"
                            class="d-inline-block text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> +91<?php echo $contact_r['pn2'] ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Follow Us -->
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow Us</h5>

                    <?php if (!empty($contact_r['tw'])): ?>
                        <a href="<?php echo $contact_r['tw'] ?>" class="d-inline-block mb-3">
                            <span class="badge bg-white text-dark fs-6 p-2">
                                <i class="bi bi-twitter-x me-1"></i> Twitter
                            </span>
                        </a><br>
                    <?php endif; ?>

                    <?php if (!empty($contact_r['fb'])): ?>
                        <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3">
                            <span class="badge bg-white text-dark fs-6 p-2">
                                <i class="bi bi-facebook me-1"></i> Facebook
                            </span>
                        </a><br>
                    <?php endif; ?>

                    <?php if (!empty($contact_r['insta'])): ?>
                        <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block">
                            <span class="badge bg-white text-dark fs-6 p-2">
                                <i class="bi bi-instagram me-1"></i> Instagram
                            </span>
                        </a><br>
                    <?php endif; ?>

                    <?php if (!empty($contact_r['threads'])): ?>
                        <a href="<?php echo $contact_r['threads'] ?>" class="d-inline-block">
                            <span class="badge bg-white text-dark fs-6 p-2">
                                <i class="bi bi-threads me-1"></i> Threads
                            </span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>


    <!-- footer -->
    <?php require('inc/footer.php'); ?>


    <!-- script for swiper js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- swiper js script for image slideing -->
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }

        });
    </script>

    <!-- swiper js script for image slideing for reviews -->
    <script>

        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 3,  // Show 3 reviews on page load
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,  // Show 1 review on smaller screens
                },
                640: {
                    slidesPerView: 1,  // Show 1 review on medium screens
                },
                768: {
                    slidesPerView: 2,  // Show 2 reviews on larger tablets
                },
                1024: {
                    slidesPerView: 3,  // Show 3 reviews on desktops
                },
            }
        });

    </script>

</body>

</html>