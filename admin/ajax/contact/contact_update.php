<?php
include "../../../inc/connection.php"; // Include the correct database connection

if (isset($_POST['upd_contacts'])) {
    // Collect form data
    $address = $_POST['address'];
    $gmap = $_POST['gmap'];
    $pn1 = $_POST['pn1'];
    $pn2 = $_POST['pn2'];
    $email = $_POST['email'];
    $fb = $_POST['fb'];
    $insta = $_POST['insta'];
    $tw = $_POST['tw'];
    $iframe = $_POST['iframe'];

    // Update query
    $q = "UPDATE `admin_contact` 
          SET `address`='$address', `gmap`='$gmap', `pn1`='$pn1', `pn2`='$pn2', 
              `email`='$email', `fb`='$fb', `insta`='$insta', `tw`='$tw', `iframe`='$iframe' 
          WHERE `id`=1";

    // Execute the query
    if (mysqli_query($con, $q)) {
        echo json_encode(["success" => true]); // Return success if update is successful
    } else {
        echo json_encode(["error" => mysqli_error($con)]); // Return error if query fails
    }
} else {
    echo json_encode(["error" => "Invalid request"]); // Return error if upd_contacts is not set
}
?>
