<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "inc/connection.php";
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoRoferry - Packages</title>
    <?php include('inc/links.php'); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR PACKAGES</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 px-4">

                <?php
                $package_res = mysqli_query($con, "SELECT * FROM package WHERE status=1 AND removed=0");

                while ($package_data = mysqli_fetch_assoc($package_res)) {
                    $pid = $package_data['pid'];

                    // Features
                    $features_data = '';
                    $fea_q = mysqli_query($con, "SELECT f.name FROM features f 
                        INNER JOIN package_features pf ON f.feid = pf.feid 
                        WHERE pf.pid = '$pid'");
                    while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                        $features_data .= "<span class='badge bg-light text-dark text-wrap lh-base me-1 mb-1'>{$fea_row['name']}</span>";
                    }

                    // Facilities
                    $facilities_data = '';
                    $fac_q = mysqli_query($con, "SELECT f.name FROM facilities f 
                        INNER JOIN package_facilities pf ON f.fid = pf.fid 
                        WHERE pf.pid = '$pid'");
                    while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                        $facilities_data .= "<span class='badge bg-light text-dark text-wrap me-1 mb-1'>{$fac_row['name']}</span>";
                    }

                    // Thumbnail image
                    $package_thumb = "admin/uploads/thumbnail.jpg";
                    $img_q = mysqli_query($con, "SELECT image FROM package_image WHERE pid='$pid' AND thumb='1' LIMIT 1");
                    if ($img_row = mysqli_fetch_assoc($img_q)) {
                        $package_thumb = "admin/uploads/" . $img_row['image'];
                    }

                    // Book Now button - Only visible if the user is logged in
                    $book_button = '';
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        $book_link = "seat_selection.php?pid={$pid}&trip_id={$trip_id}"; // Redirect to seat_selection.php for both local and non-local packages
                        $book_button = "<a href='{$book_link}' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</a>";
                    }

                    echo <<<HTML
                    <div class="card mb-4 border-0 shadow">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                <img src="$package_thumb" class="img-fluid rounded w-100" style="height:250px; object-fit:cover;">
                            </div>
                            <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                <h5 class="mb-3">{$package_data['name']}</h5>
                                <div class="mb-2"><strong>Features:</strong><br>$features_data</div>
                                <div class="mb-2"><strong>Facilities:</strong><br>$facilities_data</div>
                                <div class="mb-2">
                                    <strong>Rating:</strong>
                                    <span class="badge rounded-pill bg-light">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                <h6 class="mb-4">₹{$package_data['price']} / person</h6>
                                $book_button
                                <a href="package_details.php?id={$pid}&trip_id={$trip_id}" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
                            </div>
                        </div>
                    </div>
HTML;
                }
                ?>

            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>
</body>
</html>
