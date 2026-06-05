<?php
session_start();
include("inc/connection.php"); // Adjust path to database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: You must be logged in to submit a query.";
    exit;
}

// Check if all fields are set
if (!isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    echo "Error: Invalid Request"; 
    exit;
}

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Insert query
$sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

if (mysqli_query($con, $sql)) {
    echo "1"; // Success response
} else {
    echo "Error: " . mysqli_error($con); // Show detailed MySQL error
}
?>
