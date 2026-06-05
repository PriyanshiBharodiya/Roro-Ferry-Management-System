<?php
include "../../../inc/connection.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['member_name']) || !isset($_FILES['member_picture'])) {
        die("Error: Missing fields.");
    }

    $name = mysqli_real_escape_string($con, $_POST['member_name']);
    $uploadDir = "../../../uploads/";

    // Ensure uploads directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imageName = time() . "_" . basename($_FILES['member_picture']['name']);
    $imageTmp = $_FILES['member_picture']['tmp_name'];
    $imagePath = $uploadDir . $imageName;
    $dbImagePath = "uploads/" . $imageName; // Relative path for database

    // Upload image
    if (move_uploaded_file($imageTmp, $imagePath)) {
        $q = "INSERT INTO team (name, picture) VALUES ('$name', '$dbImagePath')";
        $res = mysqli_query($con, $q);

        echo ($res) ? "1" : "Error: " . mysqli_error($con);
    } else {
        die("Error uploading file.");
    }
}
?>
