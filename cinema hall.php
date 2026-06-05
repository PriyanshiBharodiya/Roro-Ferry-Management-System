<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROROferry-Cinema hall</title>


    <!-- swiper js cdn link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <?php include('inc/links.php'); ?>
    <style>
        .box {
            border-top-color: var(--teal) !important;
        }
    </style>

</head>

<body class="bg-light">
    <!-- header -->
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">CINEMA HALL</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Step into the cinema for a fun movie experience 🎥 and enjoy exciting films with your loved ones 🍿.</p>
    </div>

    <div class="container px-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/facilities/pvr101.jpeg" class="w-100">
                   
                </div>

                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/facilities/movie.jpeg.jpg" class="w-100">
                   
                </div>

                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="images/facilities/pvr104.jpeg" class="w-100">
                 
                </div>

              
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- footer -->

    <?php require('inc/footer.php'); ?>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 40,
            pagination: {
                el: ".swiper-pagination",
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