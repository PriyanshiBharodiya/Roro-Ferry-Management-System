<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROROferry - FACILITIES</title>

    <!-- js file  -->

    <?php include('inc/links.php'); ?>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>

</head>

<body class="bg-light">
    <!-- header -->
    <?php require('inc/header.php');
    include "inc/connection.php"
        ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">A variety of facilities designed to enhance comfort and convenience, 
            ensuring a seamless and enjoyable travel experience for all passengers.</p>

    </div>
    <div class="container">
        <div class="row">
            <?php
            $query = "SELECT * FROM facilities";
            $res = mysqli_query($con, $query);
            $path = 'admin/uploads/';

            while ($row = mysqli_fetch_assoc($res)) {
                echo '
            <div class="col-lg-4 col-mg-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="' . $path . $row['icon'] . '" width="100px" alt="' . $row['name'] . '">
                        <h5 class="m-0 ms-3">' . strtoupper($row['name']) . '</h5>
                    </div>
                    <p>' . $row['description'] . '</p>
                </div>
            </div>';
            }
            ?>
        </div>
    </div>


    <!-- footer -->

    <?php require('inc/footer.php'); ?>

</body>

</html>