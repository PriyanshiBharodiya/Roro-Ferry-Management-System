<?php
include "../../../inc/connection.php";

if (isset($_POST['trip_id'])) {
    $tripId = $_POST['trip_id'];

    $sql = "SELECT * FROM trip WHERE trip_id = '$tripId'";
    $res = mysqli_query($con, $sql);

    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode($row);
        } else {
            echo json_encode(["error" => "Trip not found"]);
        }
    } else {
        echo json_encode(["error" => "Query failed"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
