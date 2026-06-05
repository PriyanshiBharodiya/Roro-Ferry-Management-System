<?php
include "../../../inc/connection.php";

header('Content-Type: application/json');

if (!isset($_POST['get_contacts'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$query = "SELECT * FROM admin_contact WHERE id = 1";
$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($con)]);
    exit;
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo json_encode(["error" => "No data found"]);
} else {
    echo json_encode($data);
}
?>
