<?php

include "../../../inc/connection.php";

define('PACKAGES_FOLDER', dirname(__DIR__, 2) . '/uploads/');
define('PACKAGES_IMG_PATH', '/roroferry/admin/uploads/');

// Upload helper
function uploadImage($file, $folder)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = mime_content_type($file['tmp_name']);
    if (!in_array($img_mime, $valid_mime))
        return 'inv_img';
    if ($file['size'] > 2 * 1024 * 1024)
        return 'inv_size';

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $rname = 'IMG_' . random_int(11111, 99999) . '.' . $ext;
    $img_path = $folder . $rname;

    if (move_uploaded_file($file['tmp_name'], $img_path))
        return $rname;
    return 'upd_failed';
}

// Delete helper
function deleteImage($image, $folder)
{
    return unlink($folder . $image);
}

// Main AJAX logic
$action = $_REQUEST['action'] ?? '';

if ($action === 'add') {
    $name = $_POST['name'];
    $area = $_POST['area'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $adult = $_POST['adult'];
    $children = $_POST['children'];
    $desc = $_POST['desc'];
    $features = json_decode($_POST['features'] ?? '[]');
    $facilities = json_decode($_POST['facilities'] ?? '[]');

    $q = "INSERT INTO `package`(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) 
          VALUES ('$name','$area','$price','$quantity','$adult','$children','$desc')";
    if (mysqli_query($con, $q)) {
        $pid = mysqli_insert_id($con);


        // ✅ Fetch all existing trips
        $res_trips = mysqli_query($con, "SELECT * FROM `trip`");

        // ✅ Insert only this new package's quantity of seats for each trip
        while ($trip = mysqli_fetch_assoc($res_trips)) {
            $trip_id = $trip['trip_id'];

           
            for ($i = 1; $i <= $quantity; $i++) {
                
                // Generate a unique seat number, including package and trip info (optional but safe)
                $seat_no = 'P' . $pid . '-T' . $trip_id . '-A' . $i;

                mysqli_query($con, "INSERT INTO `seats`(`trip_id`, `package_id`, `seat_number`) 
                            VALUES ('$trip_id', '$pid', '$seat_no')");
            }
        }


        foreach ($features as $feid) {
            mysqli_query($con, "INSERT INTO `package_features`(`pid`, `feid`) VALUES ('$pid','$feid')");
        }
        foreach ($facilities as $fid) {
            mysqli_query($con, "INSERT INTO `package_facilities`(`pid`, `fid`) VALUES ('$pid','$fid')");
        }
        echo 1;
    } else {
        echo 0;
    }
} elseif ($action === 'display') {
    $res = mysqli_query($con, "SELECT * FROM `package`");
    $data = '';
    $i = 1;

    while ($row = mysqli_fetch_assoc($res)) {
        $status_btn = $row['status'] == 1 ?
            "<button onclick='toggle_status($row[pid],0)' class='btn btn-dark btn-sm'>active</button>" :
            "<button onclick='toggle_status($row[pid],1)' class='btn btn-warning btn-sm'>inactive</button>";

        $data .= "
        <tr>
            <td>{$i}</td>
            <td>{$row['name']}</td>
            <td>{$row['area']} sq.ft.</td>
            <td>
                <span class='badge bg-light text-dark'>Adult: {$row['adult']}</span><br>
                <span class='badge bg-light text-dark'>Children: {$row['children']}</span>
            </td>
            <td>Rs. {$row['price']}</td>
            <td>{$row['quantity']}</td>
            <td>{$status_btn}</td>
            <td>
                <button class='btn btn-primary btn-sm edit-package' data-id='{$row['pid']}'><i class='bi bi-pencil-square'></i></button>
                <button class='btn btn-info btn-sm manage-images' data-id='{$row['pid']}'><i class='bi bi-images'></i></button>
                <button class='btn btn-danger btn-sm delete-package' data-id='{$row['pid']}'><i class='bi bi-trash'></i></button>
            </td>
        </tr>";
        $i++;
    }

    echo $data;
} elseif ($action === 'get_package') {
    $pid = $_GET['package_id'];
    $package = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `package` WHERE `pid`='$pid'"));

    $features = [];
    $facilities = [];

    $res1 = mysqli_query($con, "SELECT `feid` FROM `package_features` WHERE `pid`='$pid'");
    while ($r = mysqli_fetch_assoc($res1))
        $features[] = $r['feid'];

    $res2 = mysqli_query($con, "SELECT `fid` FROM `package_facilities` WHERE `pid`='$pid'");
    while ($r = mysqli_fetch_assoc($res2))
        $facilities[] = $r['fid'];

    $package['features'] = $features;
    $package['facilities'] = $facilities;

    echo json_encode($package);
} elseif ($action === 'update') {
    $pid = $_POST['package_id'];
    $name = $_POST['name'];
    $area = $_POST['area'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $adult = $_POST['adult'];
    $children = $_POST['children'];
    $desc = $_POST['desc'];
    $features = json_decode($_POST['features'] ?? '[]');
    $facilities = json_decode($_POST['facilities'] ?? '[]');

    $q = "UPDATE `package` SET `name`='$name', `area`='$area', `price`='$price', 
          `quantity`='$quantity', `adult`='$adult', `children`='$children', `description`='$desc' 
          WHERE `pid`='$pid'";
    if (mysqli_query($con, $q)) {
        mysqli_query($con, "DELETE FROM `package_features` WHERE `pid`='$pid'");
        mysqli_query($con, "DELETE FROM `package_facilities` WHERE `pid`='$pid'");
        mysqli_query($con, "DELETE FROM `seats` WHERE `package_id`='$pid'");

        // ✅ Fetch all existing trips
        $res_trips = mysqli_query($con, "SELECT * FROM `trip`");

        // ✅ Insert only this new package's quantity of seats for each trip
        while ($trip = mysqli_fetch_assoc($res_trips)) {
            $trip_id = $trip['trip_id'];

           
            for ($i = 1; $i <= $quantity; $i++) {
                
                // Generate a unique seat number, including package and trip info (optional but safe)
                $seat_no = 'P' . $pid . '-T' . $trip_id . '-A' . $i;

                mysqli_query($con, "INSERT INTO `seats`(`trip_id`, `package_id`, `seat_number`) 
                            VALUES ('$trip_id', '$pid', '$seat_no')");
            }
        }

        foreach ($features as $feid) {
            mysqli_query($con, "INSERT INTO `package_features`(`pid`, `feid`) VALUES ('$pid','$feid')");
        }
        foreach ($facilities as $fid) {
            mysqli_query($con, "INSERT INTO `package_facilities`(`pid`, `fid`) VALUES ('$pid','$fid')");
        }
        echo 1;
    } else {
        echo 0;
    }
} elseif ($action === 'delete') {
    $pid = $_POST['package_id'];

    $res = mysqli_query($con, "SELECT * FROM `package_image` WHERE `pid`='$pid'");
    while ($r = mysqli_fetch_assoc($res)) {
        deleteImage($r['image'], PACKAGES_FOLDER);
    }

    mysqli_query($con, "DELETE FROM `package_image` WHERE `pid`='$pid'");
    mysqli_query($con, "DELETE FROM `package_features` WHERE `pid`='$pid'");
    mysqli_query($con, "DELETE FROM `package_facilities` WHERE `pid`='$pid'");
    mysqli_query($con, "DELETE FROM `seats` WHERE `package_id`='$pid'");


    echo mysqli_query($con, "DELETE FROM `package` WHERE `pid`='$pid'") ? 1 : 0;
} elseif ($action === 'toggle_status') {
    $pid = $_POST['package_id'];
    $value = $_POST['value'];
    echo mysqli_query($con, "UPDATE `package` SET `status`='$value' WHERE `pid`='$pid'") ? 1 : 0;
} elseif ($action === 'add_image') {
    $pid = $_POST['package_id'];
    $img_r = uploadImage($_FILES['image'], PACKAGES_FOLDER);

    if (in_array($img_r, ['inv_img', 'inv_size', 'upd_failed'])) {
        echo json_encode(['status' => 'error', 'message' => $img_r]);
    } else {
        $q = "INSERT INTO `package_image`(`pid`, `image`) VALUES ('$pid', '$img_r')";
        echo json_encode(['status' => mysqli_query($con, $q) ? 'success' : 'error']);
    }
} elseif ($action === 'load_images') {
    $pid = $_GET['package_id'];
    $res = mysqli_query($con, "SELECT * FROM `package_image` WHERE `pid`='$pid'");
    $path = PACKAGES_IMG_PATH;
    $html = '';

    while ($row = mysqli_fetch_assoc($res)) {
        $thumbBadge = $row['thumb'] ? "<span class='badge bg-success'>Thumbnail</span>" : '';
        $thumbBtnClass = $row['thumb'] ? 'btn btn-success' : 'btn btn-secondary';
        $thumbBtnDisabled = $row['thumb'] ? 'disabled' : '';

        $html .= "
        <tr>
            <td>
                <img src='{$path}{$row['image']}' class='img-fluid' style='max-height:80px;'>
                <div class='mt-1'>{$thumbBadge}</div>
            </td>
            <td>
                <button onclick='thumb_image({$row['piid']}, {$row['pid']})' class='{$thumbBtnClass}' {$thumbBtnDisabled}><i class='bi bi-hand-thumbs-up'></i></button>
            </td>
            <td>
                <button class='btn btn-danger delete-image' data-id='{$row['piid']}' data-package-id='{$row['pid']}'><i class='bi bi-trash'></i></button>
            </td>
        </tr>";
    }

    echo $html;
} elseif ($action === 'delete_image') {
    $piid = $_POST['image_id'];
    $pid = $_POST['package_id'];

    $res = mysqli_query($con, "SELECT * FROM `package_image` WHERE `piid`='$piid' AND `pid`='$pid'");
    $img = mysqli_fetch_assoc($res);
    if (deleteImage($img['image'], PACKAGES_FOLDER)) {
        mysqli_query($con, "DELETE FROM `package_image` WHERE `piid`='$piid' AND `pid`='$pid'");
        echo 1;
    } else {
        echo 0;
    }
} elseif ($action === 'thumb_image') {
    $piid = $_POST['image_id'];
    $pid = $_POST['package_id'];

    mysqli_query($con, "UPDATE `package_image` SET `thumb`=0 WHERE `pid`='$pid'");
    echo mysqli_query($con, "UPDATE `package_image` SET `thumb`=1 WHERE `piid`='$piid' AND `pid`='$pid'") ? 1 : 0;
}

?>