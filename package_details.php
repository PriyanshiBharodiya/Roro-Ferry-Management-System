<?php
include "inc/connection.php";

$package_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;

$package_q = mysqli_query($con, "SELECT * FROM `package` WHERE `pid`='$package_id' AND `status`=1 AND `removed`=0");
if (mysqli_num_rows($package_q) == 0) {
    header("Location: package.php");
    exit;
}

$package_data = mysqli_fetch_assoc($package_q);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoRoferry - PACKAGE DETAILS</title>
    <?php include('inc/links.php'); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold"><?php echo $package_data['name']; ?></h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="package.php?trip_id=<?php echo $trip_id; ?>" class="text-secondary text-decoration-none">PACKAGES</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <div id="packagecarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $img_q = mysqli_query($con, "SELECT image FROM `package_image` WHERE `pid`='$package_id'");
                        if (mysqli_num_rows($img_q) > 0) {
                            $active = 'active';
                            while ($img = mysqli_fetch_assoc($img_q)) {
                                echo "<div class='carousel-item $active'>
                                        <img src='admin/uploads/{$img['image']}' class='d-block w-100'>
                                      </div>";
                                $active = '';
                            }
                        } else {
                            echo "<div class='carousel-item active'>
                                    <img src='admin/uploads/thumbnail.jpg' class='d-block w-100'>
                                  </div>";
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#packagecarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#packagecarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h4>₹<?php echo $package_data['price']; ?> to start</h4>

                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>

                        <div class="feature mb-3">
                            <h6 class="mb-1">Features</h6>
                            <?php
                            $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                                INNER JOIN `package_features` pf ON f.feid = pf.feid 
                                WHERE pf.pid = '$package_id'");
                            while ($fea = mysqli_fetch_assoc($fea_q)) {
                                echo "<span class='badge bg-light text-dark text-wrap me-1 mb-1'>{$fea['name']}</span>";
                            }
                            ?>
                        </div>

                        <div class="facility mb-3">
                            <h6 class="mb-1">Facilities</h6>
                            <?php
                            $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                                INNER JOIN `package_facilities` pf ON f.fid = pf.fid 
                                WHERE pf.pid = '$package_id'");
                            while ($fac = mysqli_fetch_assoc($fac_q)) {
                                echo "<span class='badge bg-light text-dark text-wrap me-1 mb-1'>{$fac['name']}</span>";
                            }
                            ?>
                        </div>

                        <div class="mb-3">
                            <h6 class="mb-1">Area</h6>
                            <span class="badge bg-light text-dark text-wrap me-1 mb-1">
                                <?php echo $package_data['area']; ?> sq.ft.
                            </span>
                        </div>

                        <!-- Back button with trip_id -->
                        <a href="package.php?trip_id=<?= $trip_id ?>" class="btn btn-outline-secondary w-100 shadow-none mb-2">
                            ← Back to Booking
                        </a>

                    </div>
                </div>
            </div>

            <div class="mb-4 mt-5 px-4">
                <h4>Description</h4>
                <p><?php echo $package_data['description']; ?></p>
            </div>

            <!-- Static review (demo) -->
            <div class="px-4 mb-5">
                <h4 class="mb-3">Reviews & Ratings</h4>
                <div class="d-flex align-items-center mb-2">
                    <img src="images/facilities/star.png" width="30px">
                    <h6 class="m-0 ms-2">@hitesh_patel</h6>
                </div>
                <p>The journey was smooth and enjoyable. The staff was friendly and the service exceeded expectations.</p>
                <div class="rating">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>
</body>
</html>
