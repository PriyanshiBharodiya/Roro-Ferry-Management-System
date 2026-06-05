<?php
session_start();
include "../inc/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == "user") {
        $query = "SELECT * FROM users WHERE email='$email' AND is_verified=1"; // Check if user is verified
    } else if ($role == "admin") {
        $query = "SELECT * FROM admin WHERE username='$email'"; // Admin table only has 'username' and 'password'
    }

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($role == "user") {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['profile'] = $row['profile'] ?? ''; // Store profile image
                $_SESSION['role'] = 'user'; // Set user role
                $_SESSION['logged_in'] = true; // ✅ THIS LINE IS CRITICAL

                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Incorrect password"]);
            }
        } else {
            if ($password == $row['password']) {  // Make sure passwords are stored securely
                $_SESSION['admin_username'] = $row['username']; 
                $_SESSION['role'] = 'admin'; // Set admin role

                echo json_encode(["status" => "admin"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Incorrect password"]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid credentials or not verified"]);
    }
}
?>
