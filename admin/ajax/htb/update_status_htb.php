<?php
include "../../../inc/connection.php"; // Ensure correct DB connection

if (isset($_POST['trip_id'])) {
    $trip_id = $_POST['trip_id'];

    // Get the current status
    $query = "SELECT status FROM trip WHERE trip_id = '$trip_id'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            // Toggle status for HTB trip
            $new_status = ($row['status'] == 1) ? 0 : 1;

            // Update status in the database
            $update_query = "UPDATE trip SET status = '$new_status' WHERE trip_id = '$trip_id'";
            if (mysqli_query($con, $update_query)) {
                echo "Updated";
            } else {
                echo "Error updating status";
            }
        } else {
            echo "Trip not found";
        }
    } else {
        echo "Query error";
    }
} else {
    echo "Invalid request";
}
?>
