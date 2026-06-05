<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel - Schedule</title>
    <?php require('inc/links.php');
    include "../inc/connection.php";

    ?>
    <!-- <style>
       .row {
            padding-left: 50px;
            /* Adjust based on your sidebar width */
        }
    </style> -->
</head>

<?php
// Fetch the bookings of the logged-in user
$query = "SELECT * FROM booking";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php
require('inc/header.php');
require('inc/links.php');
?>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-2"> <!-- Adjust based on your sidebar width -->
            <h3 class="text-center mb-4">User Bookings</h3>

            <div style="overflow-x: auto; max-height: 80vh;">
                <table class="table table-bordered table-striped text-center" style="min-width: 1200px;">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Booking ID</th>
                            <th>Seat Numbers</th>
                            <th>Passenger Details</th>
                            <th>Total Amount</th>
                            <th>Booking Date</th>
                            <th>Cancel</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        while ($booking = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $booking['id']; ?></td>
                                <td><?php echo $booking['seat_numbers']; ?></td>
                                <td class="text-start">
                                    <?php
                                    $passengerDetails = json_decode($booking['passenger_details']);
                                    foreach ($passengerDetails as $index => $passenger): ?>
                                        <div class="mb-2 p-2 border rounded bg-light">
                                            <strong>Passenger <?php echo $index + 1; ?></strong><br>
                                            Name: <?php echo htmlspecialchars($passenger->name); ?><br>
                                            Age: <?php echo htmlspecialchars($passenger->age); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <td><?php echo $booking['total_amount']; ?></td>
                                <td><?php echo $booking['created_at']; ?></td>
                                <td>
                                    <?php if ($booking['status'] == 1): ?>
                                        <a href="admin_cancel.php?id=<?php echo $booking['id']; ?>"
                                            class="btn btn-sm btn-primary">Cancel</a>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                             
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

require('inc/scripts.php'); ?>

<!-- <script src="schedule.js"></script> -->

</body>

</html>