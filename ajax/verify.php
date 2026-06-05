<?php
include "../inc/connection.php"; // Database connection

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and is not expired
    $query = "SELECT * FROM users WHERE token='$token' AND token_expire >= NOW() AND is_verified=0";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Update user as verified
        $update = "UPDATE users SET is_verified=1, token=NULL, token_expire=NULL WHERE token='$token'";
        if (mysqli_query($con, $update)) {
            echo "<script>alert('Email verified successfully! You can now log in.'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again later.'); window.location.href='../index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid or expired token. Please register again.'); window.location.href='../register.php';</script>";
    }
} else {
    echo "<script>alert('No token provided!'); window.location.href='../index.php';</script>";
}
?>
