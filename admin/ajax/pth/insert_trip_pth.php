<?php
include "../../../inc/connection.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $trip_day = $_POST['trip_day'];
    $dep_place = "Porbandar"; // Fixed departure place
    $arr_place = "Hajira"; // Fixed arrival place
    $dep_date = $_POST['dep_date'];
    $dep_time = $_POST['dep_time'];
    $arr_time = $_POST['arr_time'];
    $status = 1; // Default status as active

    // Insert Query
    $sql = "INSERT INTO trip (trip_day, dep_place, arr_place, dep_date, dep_time, arr_time, status) 
            VALUES ('$trip_day', '$dep_place', '$arr_place', '$dep_date', '$dep_time', '$arr_time', $status)";

    $res = mysqli_query($con, $sql);

    if ($res) {
        $trip_id = mysqli_insert_id($con);

        // Fetch all packages
        $package_res = mysqli_query($con, "SELECT * FROM package");
    
        while ($package = mysqli_fetch_assoc($package_res)) {
            $pid = $package['pid']; 
            $quantity = $package['quantity'];
    
            // Insert seats for this package for the new trip
            for ($i = 1; $i <= $quantity; $i++) {
                $seat_no = 'P' . $pid . '-T' . $trip_id . '-A' . $i;
    
                mysqli_query($con, "INSERT INTO seats (trip_id, package_id, seat_number) 
                                    VALUES ('$trip_id', '$pid', '$seat_no')");
            }
        }
        echo "1"; // Success response for AJAX
    } else {
        echo "Error: " . mysqli_error($con); // Debugging error
    }
}
?>
