<?php
session_start();
include "../inc/connection.php";
include "../inc/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Set Indian Standard Time (IST)
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST["email"]);

    // Check if the email exists
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate a reset token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // 1-hour expiry in IST

        // Store token in database (Keeping column names unchanged)
        $update_query = "UPDATE users SET reset_token='$token', token_expire='$expiry' WHERE email='$email'";
        mysqli_query($con, $update_query);

        // Reset password link
        $reset_link = "http://localhost/roroferry/ajax/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = "Click the link below to reset your password:<br><br>
                <a href='$reset_link'>$reset_link</a><br><br>
                This link will expire at <b>$expiry IST</b>.";

            $mail->send();
            echo "A reset link has been sent to your email.";
        } catch (Exception $e) {
            echo "Mail Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "No account found with this email.";
    }
}
?>
