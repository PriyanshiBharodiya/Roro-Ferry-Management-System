
<?php
session_start();
if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Redirect to login page if not admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <?php require('inc/links.php'); ?>
    <style>
        body {
            height: 100vh;
            margin: 0;
            padding: 0;
            background-image: url('aaa.jpg');
            /* Replace with your background image */
            background-position: center;
            background-size: cover;
            backdrop-filter: blur(10px);
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: white;
            transition: 0.3s;
        }

        .card:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .text-blue {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="text-white">DASHBOARD</h3>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-4">
                        <a href="trip.php" class="text-decoration-none">
                            <div class="card">
                                <h4 class="text-blue">TRIP</h4>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-4">
                        <a href="booking_details.php" class="text-decoration-none">
                            <div class="card">
                                <h4 class="text-blue">BOOKING DETAILS</h4>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-4">
                        <a href="features_facilities.php" class="text-decoration-none">
                            <div class="card">
                                <h4 class="text-blue">Features & Facilities</h4>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-4">
                        <a href="package.php" class="text-decoration-none">
                            <div class="card">
                                <h4 class="text-blue">PACKAGE</h4>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card">
                                <h4 class="text-blue">USER QUERIES</h4>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-4">
                        <a href="carousel.php" class="text-decoration-none">
                            <div class="card">
                                <h4 class="text-blue">CAROUSEL</h4>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 mb-4">
                        <a href="settings.php" class="text-decoration-none">
                            <div class="card">
                                <h4 class="text-blue">SETTINGS</h4>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php');?>

</body>

</html>