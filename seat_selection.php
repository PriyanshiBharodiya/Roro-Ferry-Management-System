<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "inc/connection.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

$uid = $_SESSION['user_id'];
$user_q = mysqli_query($con, "SELECT email, phonenum FROM users WHERE id = '$uid'");
if (!$user_q || mysqli_num_rows($user_q) == 0) {
    header("Location: index.php");
    exit;
}
$user = mysqli_fetch_assoc($user_q);

if (!isset($_GET['pid']) || !is_numeric($_GET['pid'])) {
    header("Location: index.php");
    exit;
}
$pid = intval($_GET['pid']);

$trip = null;
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;
if ($trip_id) {
    $trip_q = mysqli_query($con, "SELECT * FROM trip WHERE trip_id = '$trip_id'");
    if ($trip_q && mysqli_num_rows($trip_q) > 0) {
        $trip = mysqli_fetch_assoc($trip_q);
    }
}

$package_q = mysqli_query($con, "SELECT * FROM package WHERE pid = '$pid'");
if (!$package_q || mysqli_num_rows($package_q) == 0) {
    header("Location: index.php");
    exit;
}
$package_data = mysqli_fetch_assoc($package_q);

// Fetch seats for this trip and package
$seats_q = mysqli_query($con, "SELECT * FROM seats WHERE package_id = '$pid' AND trip_id = '$trip_id'");
$seats = [];
while ($row = mysqli_fetch_assoc($seats_q)) {
    $seats[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Select Seats - RoRoFerry</title>
    <?php include "inc/links.php"; ?>
    <style>
        .seat {
            width: 70px;
            /* increased from 45px */
            height: 70px;
            /* increased from 45px */
            margin: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
            user-select: none;
            font-size: 13px;
            /* slightly larger */
            white-space: normal;
            /* allow wrapping if needed */
            text-align: center;
            padding: 5px;
        }

        .available {
            background-color: #28a745;
            color: white;
        }

        .available:hover {
            background-color: #218838;
        }

        .booked {
            background-color: #dc3545;
            color: white;
            cursor: not-allowed;
        }

        .selected {
            background-color: #007bff !important;
            color: white;
        }

        .seat-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .summary-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 40px auto 0;
        }

        .legend {
            text-align: center;
            margin-top: 20px;
        }

        .legend span {
            display: inline-block;
            margin: 0 10px;
        }

        .legend-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            vertical-align: middle;
            margin-right: 5px;
            border-radius: 4px;
        }

        .btn-link-style {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-link-style:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <?php include "inc/header.php"; ?>

    <div class="container my-5">
        <h2 class="text-center mb-4">Select Your Seats - <?= htmlspecialchars($package_data['name']); ?></h2>

        <?php if ($trip): ?>
            <div class="alert alert-info text-center">
                <strong>Trip:</strong> <?= $trip['dep_place'] ?> → <?= $trip['arr_place'] ?> |
                <strong>Date:</strong> <?= $trip['dep_date'] ?> |
                <strong>Time:</strong> <?= $trip['dep_time'] ?> - <?= $trip['arr_time'] ?>
            </div>
        <?php endif; ?>

        <form action="summary.php" method="POST">
            <input type="hidden" name="pid" value="<?= $pid; ?>">
            <input type="hidden" name="uid" value="<?= $uid; ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']); ?>">
            <input type="hidden" name="mobile" value="<?= htmlspecialchars($user['phonenum']); ?>">
            <input type="hidden" name="price" id="price-hidden" value="<?= $package_data['price']; ?>">
            <input type="hidden" name="trip_id" value="<?= $trip_id ?>">

            <div class="seat-layout d-flex flex-wrap justify-content-center">
                <?php
                $counter = 0;
                foreach ($seats as $seat) {
                    $seat_no = $seat['seat_number'];
                    $status = isset($seat['is_booked']) ? $seat['is_booked'] : 0;
                    $class = $status ? 'booked' : 'available';

                    if ($counter % 10 == 0)
                        echo "<div class='w-100 seat-row'></div>";

                    if (!$status) {
                        echo "
                    <label class='seat $class' data-seat='$seat_no' title='$seat_no'>
                        <input type='checkbox' name='seats[]' value='$seat_no' hidden>
                        $seat_no
                    </label>";
                    } else {
                        echo "<div class='seat $class' title='$seat_no'>$seat_no</div>";
                    }
                    $counter++;
                }
                ?>
            </div>

            <div class="legend">
                <span>
                    <div class="legend-box" style="background:#28a745;"></div> Available
                </span>
                <span>
                    <div class="legend-box" style="background:#dc3545;"></div> Booked
                </span>
                <span>
                    <div class="legend-box" style="background:#007bff;"></div> Selected
                </span>
            </div>

            <div id="passenger-info" class="mt-5"></div>

            <div class="summary-card text-center">
                <h5>Total Seats Selected: <span id="seat-count">0</span></h5>
                <h5>Price per Seat: ₹<?= $package_data['price']; ?></h5>
                <h4>Total Amount: ₹<span id="total-price">0</span></h4>
                <input type="hidden" name="total_amount" id="total-input" value="0">
                <button type="submit" class="btn-link-style mt-3" id="payBtn" disabled>Proceed to Summary</button>
            </div>
        </form>
    </div>

    <?php include "inc/footer.php"; ?>

    <script>
        const price = <?= $package_data['price']; ?>;
        const passengerDiv = document.getElementById('passenger-info');

        document.querySelectorAll('.seat.available').forEach(seat => {
            seat.addEventListener('click', function () {
                const checkbox = seat.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
                seat.classList.toggle('selected', checkbox.checked);
                updateSelection();
            });
        });

        function updateSelection() {
            const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked');
            const count = selectedSeats.length;
            const total = count * price;

            document.getElementById('seat-count').textContent = count;
            document.getElementById('total-price').textContent = total;
            document.getElementById('total-input').value = total;
            document.getElementById('payBtn').disabled = count === 0;

            passengerDiv.innerHTML = '';
            selectedSeats.forEach((seat, index) => {
                passengerDiv.innerHTML += `
                <div class="card p-3 mb-3">
                    <h5>Passenger ${index + 1} - Seat ${seat.value}</h5>
                    <input type="hidden" name="passengers[${index}][seat]" value="${seat.value}">
                    <input type="text" name="passengers[${index}][name]" placeholder="Full Name" required class="form-control mb-2">
                    <input type="number" name="passengers[${index}][age]" placeholder="Age" required class="form-control mb-2">
                    <select name="passengers[${index}][gender]" required class="form-control">
                        <option value="">Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>`;
            });
        }
    </script>
</body>

</html>