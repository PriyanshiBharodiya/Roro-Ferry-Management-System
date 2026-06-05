<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "inc/connection.php";

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['seats'], $_POST['passengers'], $_POST['total_amount'])) {
    header("Location: index.php");
    exit;
}

$uid = intval($_POST['uid']);
$pid = intval($_POST['pid']);
$trip_id = intval($_POST['trip_id'] ?? 0);
$seats = $_POST['seats'];
$passengers = $_POST['passengers'];
$total_amount = intval($_POST['total_amount']);
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';

// Fetch package name
$pkg_q = mysqli_query($con, "SELECT name FROM package WHERE pid = '$pid'");
$pkg = mysqli_fetch_assoc($pkg_q);

// Fetch trip details
$trip_q = mysqli_query($con, "SELECT * FROM trip WHERE trip_id = '$trip_id'");
$trip = mysqli_fetch_assoc($trip_q);

// Store in session for access in payment.php
$_SESSION['booking'] = [
    'uid' => $uid,
    'pid' => $pid,
    'trip_id' => $trip_id,
    'seats' => $seats,
    'passengers' => $passengers,
    'total_amount' => $total_amount,
    'email' => $email,
    'mobile' => $mobile,
    'package_name' => $pkg['name'] ?? '',
    'trip' => $trip
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Review & Confirm - RoRoFerry</title>
    <?php include "inc/links.php"; ?>
    <style>
        .summary-box {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }
        .summary-box table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .summary-box th, .summary-box td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .summary-box th {
            background-color: #f5f5f5;
            font-weight: 600;
        }
        .action-btns {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
    </style>
</head>
<body>
    <?php include "inc/header.php"; ?>
    <div class="container">
        <div class="summary-box">
            <h3 class="text-center mb-4">🚢 Review Your Booking</h3>
            <table>
                <tr><th>Package</th><td><?= htmlspecialchars($pkg['name']) ?></td></tr>
                <?php if ($trip): ?>
                    <tr><th>From</th><td><?= htmlspecialchars($trip['dep_place']) ?></td></tr>
                    <tr><th>To</th><td><?= htmlspecialchars($trip['arr_place']) ?></td></tr>
                    <tr><th>Departure Date</th><td><?= htmlspecialchars($trip['dep_date']) ?></td></tr>
                    <tr><th>Departure Time</th><td><?= htmlspecialchars($trip['dep_time']) ?></td></tr>
                    <tr><th>Arrival Time</th><td><?= htmlspecialchars($trip['arr_time']) ?></td></tr>
                <?php endif; ?>
                <tr><th>Seats</th><td><?= implode(', ', array_map('htmlspecialchars', $seats)) ?></td></tr>
                <tr><th>Total Amount</th><td>₹<?= $total_amount ?></td></tr>
                <tr><th>Email</th><td><?= htmlspecialchars($email) ?></td></tr>
                <tr><th>Mobile</th><td><?= htmlspecialchars($mobile) ?></td></tr>
            </table>

            <h5 class="mt-4">👤 Passenger Details</h5>
            <table>
                <thead>
                    <tr><th>#</th><th>Full Name</th><th>Age</th><th>Gender</th><th>Seat</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($passengers as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['age']) ?></td>
                            <td><?= htmlspecialchars($p['gender']) ?></td>
                            <td><?= htmlspecialchars($p['seat']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="action-btns">
                <a href="seat_selection.php?pid=<?= $pid ?>&trip_id=<?= $trip_id ?>" class="btn btn-outline-secondary">← Back</a>

                <form action="payment.php" method="POST">
                    <input type="hidden" name="confirm" value="1" />
                    <button type="submit" class="btn btn-success">✅ Confirm & Pay</button>
                </form>
            </div>
        </div>
    </div>
    <?php include "inc/footer.php"; ?>
</body>
</html>
