<?php
session_start();
include "../inc/connection.php";
include "../inc/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];  // The recipient email (newly registered user)
    $phonenum = $_POST['phonenum'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $dob = $_POST['dob'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];

    // Validate passwords
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if email already exists
    $check_email = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        echo "error_email_exists";
        exit();
    }

    // Handle Image Upload
    $profile_image = ""; // Default empty profile image
    if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        $target_dir = "../images/USER_PROFILE_IMAGE/"; // Make sure this directory exists!
        $file_name = basename($_FILES["profile"]["name"]);
        $file_tmp = $_FILES["profile"]["tmp_name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ["jpg", "jpeg", "png", "gif"];

        if (in_array($file_ext, $allowed_ext)) {
            $new_filename = uniqid("IMG_", true) . "." . $file_ext;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($file_tmp, $target_file)) {
                $profile_image = $new_filename; // Save only the filename
            } else {
                echo "error_image_upload";
                exit();
            }
        } else {
            echo "error_invalid_image";
            exit();
        }
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate verification token
    $token = bin2hex(random_bytes(50));
    $token_expire = date("Y-m-d H:i:s", strtotime("+1 day"));

    // Insert into database (including profile image)
    $sql = "INSERT INTO users (name, email, phonenum, address, pincode, dob, password, is_verified, token, token_expire, profile) 
            VALUES ('$name', '$email', '$phonenum', '$address', '$pincode', '$dob', '$hashed_password', 0, '$token', '$token_expire', '$profile_image')";

    if (mysqli_query($con, $sql)) {
        // Send verification email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;  // Always send from fixed email
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);  // Sender (always same)
            $mail->addAddress($email, $name);  // Receiver (new user email)
            $mail->isHTML(true);
            $mail->Subject = "Verify Your Email";
            $mail->Body = "Thank You! Welcome TO RoroFerry Service! Click the link below to verify your email:<br><br>
                <a href='http://localhost/roroferry/ajax/verify.php?token=$token'>Verify Email</a>";

            $mail->send();
            echo "success";
        } catch (Exception $e) {
            echo "Mail Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
