<?php
include "../../../inc/connection.php";

if (isset($_POST['schedule_id'])) {
    $tripId = $_POST['schedule_id'];
    $tripDay = $_POST['trip_day'];
    $depDate = $_POST['departure_date'];
    $depTime = $_POST['departure_time'];
    $arrTime = $_POST['arrival_time'];

    $sql = "UPDATE trip SET 
                trip_day = '$tripDay', 
                dep_date = '$depDate', 
                dep_time = '$depTime', 
                arr_time = '$arrTime' 
            WHERE trip_id = '$tripId'";

    $res = mysqli_query($con, $sql);

    if ($res) {
        echo "success"; 
    } else {
        echo "error: " . mysqli_error($con); 
    }
} else {
    echo "Invalid request!";
}
?>
