<?php
include "../../../inc/connection.php";
if (isset($_POST['trip_id'])) {

    $tripId = $_POST['trip_id'];

    $sql = "DELETE FROM trip WHERE trip_id = '$tripId'";
    $res = mysqli_query($con, $sql);

    if ($res) {
      
        echo "Deleted";
        $sql2 = "DELETE from seats where trip_id='$trip_id'";
        $res2 = mysqli_query($con, $sql2);

    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "Invalid request";
}
?>