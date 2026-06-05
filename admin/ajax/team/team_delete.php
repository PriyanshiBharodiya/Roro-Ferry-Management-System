<?php
include "../../../inc/connection.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Fetch image path
    $q = "SELECT picture FROM team WHERE id = $id";
    $res = mysqli_query($con, $q);
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        $imagePath = "../../../" . $row['picture']; // Full image path

        // Delete image file
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete record from database
        $q = "DELETE FROM team WHERE id = $id";
        $res = mysqli_query($con, $q);

        echo ($res) ? "1" : "Error: " . mysqli_error($con);
    } else {
        echo "Error: Member not found.";
    }
}
?>
