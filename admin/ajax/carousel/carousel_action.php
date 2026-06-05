<?php
// DB Connection
include "../../../inc/connection.php";

// ----- ADD IMAGE -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['carousel_picture'])) {
    $upload_dir = "../../uploads/";  // uploads folder inside /admin
    $file = $_FILES['carousel_picture'];

    if ($file['error'] === 0) {
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_ext = ["jpg", "jpeg", "png", "webp"];

        if (in_array($file_ext, $allowed_ext)) {
            $new_filename = uniqid("carousel_", true) . "." . $file_ext;
            $destination = $upload_dir . $new_filename;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $q = "INSERT INTO carousel (image) VALUES ('$new_filename')";
                echo mysqli_query($con, $q) ? "success" : "error: Insert failed!";
            } else {
                echo "error: Upload failed!";
            }
        } else {
            echo "error: Invalid format!";
        }
    } else {
        echo "error: File error!";
    }
    exit;
}

// ----- GET IMAGES -----
if (isset($_GET['get_carousel'])) {
    $q = "SELECT * FROM carousel ORDER BY cid DESC";
    $res = mysqli_query($con, $q);
    $output = "";
    $path = "/roroferry/admin/uploads/";

    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $output .= "
            <div class='col-md-3 mb-3'>
                <div class='card bg-dark text-white'>
                    <img src='{$path}{$row['image']}' class='card-img'>
                    <div class='card-img-overlay text-end'>
                        <button type='button' onclick='remove_carousel({$row['cid']})' class='btn btn-danger btn-sm shadow-none'>
                            <i class='bi bi-trash'></i> Delete
                        </button>
                    </div>
                </div>
            </div>";
        }
    } else {
        $output = "<div class='col-12'><p>No images found.</p></div>";
    }

    echo $output;
    exit;
}

// ----- DELETE IMAGE -----
if (isset($_POST['id']) && $_POST['type'] === 'delete_carousel') {
    $id = intval($_POST['id']);

    $get_img = mysqli_query($con, "SELECT image FROM carousel WHERE cid = $id");
    if (mysqli_num_rows($get_img) === 1) {
        $img_data = mysqli_fetch_assoc($get_img);
        $img_path = "../../uploads/" . $img_data['image'];

        if (file_exists($img_path)) {
            unlink($img_path);
        }
    }

    $del_q = "DELETE FROM carousel WHERE cid = $id";
    echo mysqli_query($con, $del_q) ? "success" : "error: Delete failed!";
    exit;
}
?>
