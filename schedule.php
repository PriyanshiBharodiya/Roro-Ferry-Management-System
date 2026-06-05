<?php
include "inc/connection.php";
include('inc/links.php'); 
include('inc/header.php'); 

$from = $_POST['from_location'] ?? '';
$to = $_POST['to_location'] ?? '';
$date_raw = $_POST['travel_date'] ?? '';
$date = date('Y-m-d', strtotime($date_raw));

$show_notification = false;
$notification_msg = '';

if ($from && $to && $from === $to) {
    $show_notification = true;
    $notification_msg = "⚠️ 'From' and 'To' locations cannot be the same.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RoRoferry-Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; }
        main { flex: 1; }
        footer { background-color: #f8f9fa; padding: 20px 0; text-align: center; }
    </style>
</head>
<body class="bg-light">

<main>
    <div class="container py-4">

        <?php if ($show_notification): ?>
            <div class="alert alert-warning alert-dismissible fade show text-center fw-semibold" role="alert">
                <?= $notification_msg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="window.location.href='index.php'"></button>
            </div>
        <?php endif; ?>

        <?php if (!$show_notification): ?>
        <div class="col warehouse1 pb-3 pt-3 bg-white shadow rounded">
            <h2 class="text-center text-dark"><?= $from ?> to <?= $to ?></h2>
            <h5 class="text-center text-primary mb-3">Travel Date: <?= $date ?></h5>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Day</th>
                            <th>Departure Date</th>
                            <th>Departure Time</th>
                            <th>Arrival Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM `trip` 
                              WHERE status = 1 
                              AND dep_place = '$from' 
                              AND arr_place = '$to' 
                              AND dep_date = '$date'";

                    $result = mysqli_query($con, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['trip_day'] . '</td>';
                            echo '<td>' . $row['dep_date'] . '</td>';
                            echo '<td>' . $row['dep_time'] . '</td>';
                            echo '<td>' . $row['arr_time'] . '</td>';
                            echo '<td>
                                    <a href="package.php?trip_id=' . $row['trip_id'] . '" class="btn btn-sm btn-outline-dark shadow-none">Packages</a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-danger fw-bold">No schedule data available for this date and route.</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php include('inc/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
