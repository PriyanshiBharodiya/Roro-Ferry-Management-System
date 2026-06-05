<?php
session_start();
include "inc/connection.php";

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;

// Fetch the package and trip details
$pkg_q = mysqli_query($con, "SELECT name, price, quantity FROM package WHERE pid = '$pid'");
$pkg = mysqli_fetch_assoc($pkg_q);

$trip_q = mysqli_query($con, "SELECT * FROM trip WHERE trip_id = '$trip_id'");
$trip = mysqli_fetch_assoc($trip_q);

// Fetch user data based on user_id from session
$user_id = $_SESSION['user_id'];  // Assuming user_id is stored in the session
$user_q = mysqli_query($con, "SELECT email, phonenum FROM users WHERE id = '$user_id'");

if ($user_q) {
    $user_data = mysqli_fetch_assoc($user_q);
    if ($user_data) {
        $user_email = $user_data['email'];
        $user_phone = $user_data['phonenum'];
    } else {
        $user_email = '';
        $user_phone = '';
    }
} else {
    die('Error executing query: ' . mysqli_error($con));
}

// Fetch the booked seats for this trip
$booked_seats = [];
$seats_q = mysqli_query($con, "SELECT seat_number FROM bookings WHERE trip_id = '$trip_id' AND status = 1"); // Assuming status 1 means booked
while ($row = mysqli_fetch_assoc($seats_q)) {
    $booked_seats[] = $row['seat_number'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seats = $_POST['seats'];
    $passengers = $_POST['passengers'];
    $total_amount = $_POST['total_amount'];
    $email = $_POST['email'];
    $phone = $_POST['phonenum'];

    // Redirect to the summary page
    header("Location: summary.php?pid=$pid&trip_id=$trip_id&seats=" . implode(',', $seats) . "&passengers=" . urlencode(json_encode($passengers)) . "&total_amount=$total_amount&email=$email&phonenum=$phone");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection - RoRoFerry</title>
    <?php include "inc/links.php"; ?>
    <style>
        .unavailable {
            background-color: red;
            color: white;
            pointer-events: none;
        }
    </style>
</head>
<body>
<?php include "inc/header.php"; ?>

<div class="container my-5">
    <h2 class="text-center">Select Seats & Enter Details</h2>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <form method="POST">
                <div class="mb-4">
                    <h4>Package: <?= htmlspecialchars($pkg['name']) ?></h4>
                    <p><strong>Price per person:</strong> ₹<?= htmlspecialchars($pkg['price']) ?></p>
                </div>

                <!-- Select Seats -->
                <div class="mb-4">
                    <h5>Select Seats</h5>
                    <div class="row">
                        <?php
                        // Assuming the quantity column tells us how many seats we have in total
                        $totalSeats = $pkg['quantity']; 
                        for ($i = 1; $i <= $totalSeats; $i++) {  // Example: limit to package quantity
                            $isBooked = in_array($i, $booked_seats);
                            $disabledClass = $isBooked ? 'unavailable' : '';
                            echo "<div class='col-md-2 mb-2'>
                                    <label class='btn btn-outline-primary w-100 $disabledClass'>
                                        <input type='checkbox' name='seats[]' value='Seat $i' " . ($isBooked ? 'disabled' : '') . "> Seat $i
                                    </label>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Passenger Details -->
                <div class="mb-4">
                    <h5>Passenger Details</h5>
                    <div id="passenger-fields">
                        <div class="passenger-field mb-3">
                            <input type="text" name="passengers[0][name]" class="form-control" placeholder="Full Name" required>
                            <input type="number" name="passengers[0][age]" class="form-control mt-2" placeholder="Age" required>
                            <select name="passengers[0][gender]" class="form-select mt-2" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary" id="add-passenger">Add Passenger</button>
                </div>

                <!-- Contact Information -->
                <div class="mb-4">
                    <h5>Contact Information</h5>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $user_email ?>" readonly>
                    <input type="text" name="phonenum" class="form-control mt-2" placeholder="Mobile Number" value="<?= $user_phone ?>" readonly>
                </div>

                <!-- Total Amount -->
                <div class="mb-4">
                    <h5>Total Amount: ₹<span id="total-amount"><?= $pkg['price'] ?></span></h5>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success w-100">Proceed to Review</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Add passenger fields dynamically
    let passengerCount = 1;
    document.getElementById('add-passenger').addEventListener('click', function () {
        passengerCount++;
        const passengerFields = document.createElement('div');
        passengerFields.classList.add('passenger-field', 'mb-3');
        passengerFields.innerHTML = ` 
            <input type="text" name="passengers[${passengerCount}][name]" class="form-control" placeholder="Full Name" required>
            <input type="number" name="passengers[${passengerCount}][age]" class="form-control mt-2" placeholder="Age" required>
            <select name="passengers[${passengerCount}][gender]" class="form-select mt-2" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        `;
        document.getElementById('passenger-fields').appendChild(passengerFields);
    });

    // Calculate the total amount based on selected seats
    document.querySelector('form').addEventListener('submit', function (e) {
        const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked').length;
        const pricePerPerson = <?= $pkg['price'] ?>;
        const totalAmount = selectedSeats * pricePerPerson;
        document.getElementById('total-amount').innerText = totalAmount;
        // Add the total amount to the form data before submission
        const totalAmountInput = document.createElement('input');
        totalAmountInput.type = 'hidden';
        totalAmountInput.name = 'total_amount';
        totalAmountInput.value = totalAmount;
        this.appendChild(totalAmountInput);
    });
</script>

<?php include "inc/footer.php"; ?>
