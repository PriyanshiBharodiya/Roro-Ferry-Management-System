<?php
session_start();
include "../inc/connection.php";

// Set Indian Standard Time (IST)
date_default_timezone_set("Asia/Kolkata");

if (!isset($_GET["token"])) {
    die("Invalid request.");
}

$token = $_GET["token"];
$query = "SELECT * FROM users WHERE reset_token='$token' AND token_expire > NOW()";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 0) {
    die("Invalid or expired token.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = mysqli_real_escape_string($con, $_POST["password"]);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update_query = "UPDATE users SET password='$hashed_password', reset_token=NULL, token_expire=NULL WHERE reset_token='$token'";
    if (mysqli_query($con, $update_query)) {
        echo "<script>
            alert('Password updated successfully!'); 
            window.location.href='/roroferry/index.php';
        </script>";
        exit();
    }    
    else {
        echo "Error updating password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons (Required for Eye Icon) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="card shadow p-4" style="width: 350px;">
        <h3 class="text-center">Reset Password</h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye"></i> <!-- Eye icon -->
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>

    <script>
        // Toggle password visibility
        $("#togglePassword").click(function() {
            let passwordField = $("#password");
            let icon = $(this).find("i");

            // Toggle input type
            let type = passwordField.attr("type") === "password" ? "text" : "password";
            passwordField.attr("type", type);

            // Change icon
            icon.toggleClass("bi-eye bi-eye-slash");
        });
    </script>

</body>
</html>
