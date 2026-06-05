<?php
	ob_start();
?>


<?php
// Start session if it's not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "inc/connection.php"; // Your database connection file
include "inc/links.php";
// Check if booking session exists
if (!isset($_SESSION['booking'])) {
    echo "No booking found.";
    exit;
}

$booking = $_SESSION['booking'];

// Extract customer details from the session
$name = htmlspecialchars($booking['passengers'][0]['name'] ?? 'RoRoFerry Customer');
$email = $booking['email'];
$mobile = $booking['mobile'];
$amount = (float)$booking['total_amount']; // Ensure it's a float
$orderId = "RoRo_" . time(); // Generate a unique order ID

// Cashfree API credentials
$cashfreeAppId = "TEST105523476dabc00510bb5a8d1c7874325501";  // Replace with your Cashfree App ID
$cashfreeSecretKey = "cfsk_ma_test_9ddc7854159df014b1d40b47c4fb39e2_467f0e4a";  // Replace with your Cashfree Secret Key
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cashfree PG TestForm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    /* Basic page style */
    body {
      background-color: #f4f4f4;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Sticky Header */
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #007bff;
      padding: 15px 0;
      color: #fff;
      text-align: center;
      z-index: 1000;
    }

    /* Sticky Footer */
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 10px 0;
      background-color: #333;
      color: #fff;
      text-align: center;
      z-index: 999;
    }

    /* Add space for content between sticky header and footer */
    .content {
      padding-top: 80px;  /* Space for sticky header */
      padding-bottom: 80px;  /* Space for sticky footer */
    }

    /* Form container */
    .form-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-container .form-group label {
      font-weight: bold;
    }

    .form-container .btn {
      background-color: #007bff;
      color: #fff;
      font-weight: bold;
    }

    .form-container .btn:hover {
      background-color: #0056b3;
    }

    h1 {
      margin-bottom: 30px;
      color: #007bff;
    }
  </style>
</head>
<body>

  <!-- Sticky Header -->
  <?php include "inc/header.php"; ?>

  <div class="content">
    <div class="container">
      <h1 align="center">Cashfree Test Form</h1>

      <!-- Payment Form -->
      <div class="form-container">
      <form id="redirectForm" method="post" action="request.php" style="display:none;">
        <input type="hidden" name="appId" value="<?= $cashfreeAppId ?>" />
        <input type="hidden" name="orderId" value="<?= $orderId ?>" />
        <input type="hidden" name="orderAmount" value="<?= $amount ?>" />
        <input type="hidden" name="orderCurrency" value="INR" />
        <input type="hidden" name="orderNote" value="RoRoFerry Booking Payment" />
        <input type="hidden" name="customerName" value="<?= htmlspecialchars($name) ?>" />
        <input type="hidden" name="customerEmail" value="<?= htmlspecialchars($email) ?>" />
        <input type="hidden" name="customerPhone" value="<?= htmlspecialchars($mobile) ?>" />
        <input type="hidden" name="returnUrl" value="http://localhost/roroferry/response.php" />
        <input type="hidden" name="notifyUrl" value="https://localhost/roroferry/notify.php" />
      </form>
      </div>
    </div>
  </div>

  <script>
    // Automatically submit the form on page load
    window.onload = function () {
      document.getElementById("redirectForm").submit();
    };
  </script>

  <!-- Sticky Footer -->
  <?php include "inc/footer.php"; ?>

</body>
</html>
