<?php
// Include the database connection file
include "../../../inc/connection.php";

// ---------- FEATURES & FACILITIES SECTION ----------

// Handle POST requests (Insertion & Deletion)
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // ----- ADD FEATURE -----
    if (isset($_POST['feature_name'])) {
        $feature_name = mysqli_real_escape_string($con, $_POST['feature_name']);
        $q = "INSERT INTO features(name) VALUES ('$feature_name')";
        echo mysqli_query($con, $q) ? "success: Feature added!" : "error: Operation failed!";
        exit;
    }

    // ----- ADD FACILITY -----
    if (isset($_POST['facility_name'])) {
        $facility_name = mysqli_real_escape_string($con, $_POST['facility_name']);
        $facility_desc = mysqli_real_escape_string($con, $_POST['facility_desc']);

        // ✅ Corrected path to upload inside /admin/uploads/
        $upload_dir = "../../../admin/uploads/";
        $file = $_FILES['facility_icon'];

        if ($file['error'] === 0) {
            $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_ext = ["jpg", "jpeg", "png", "webp"];

            if (in_array($file_ext, $allowed_ext)) {
                $new_filename = uniqid("facility_", true) . "." . $file_ext;
                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $q = "INSERT INTO facilities(icon, name, description) 
                          VALUES ('$new_filename', '$facility_name', '$facility_desc')";
                    echo mysqli_query($con, $q) ? "success: Facility added!" : "error: Operation failed!";
                } else {
                    echo "error: Image upload failed!";
                }
            } else {
                echo "error: Invalid image format!";
            }
        } else {
            echo "error: File upload error!";
        }
        exit;
    }

    // ----- DELETE FEATURE -----
    if (isset($_POST['id']) && $_POST['type'] === 'delete_feature') {
        $id = intval($_POST['id']);
        $q = "DELETE FROM features WHERE feid = $id";
        echo mysqli_query($con, $q) ? "success: Feature deleted!" : "error: Delete failed!";
        exit;
    }

    // ----- DELETE FACILITY -----
    if (isset($_POST['id']) && $_POST['type'] === 'delete_facility') {
        $id = intval($_POST['id']);

        // Delete image from disk
        $get_icon = mysqli_query($con, "SELECT icon FROM facilities WHERE fid = $id");
        if (mysqli_num_rows($get_icon) == 1) {
            $icon_data = mysqli_fetch_assoc($get_icon);
            $icon_path = "../../../admin/uploads/" . $icon_data['icon'];
            if (file_exists($icon_path)) {
                unlink($icon_path);
            }
        }

        // Delete from DB
        $q = "DELETE FROM facilities WHERE fid = $id";
        echo mysqli_query($con, $q) ? "success: Facility deleted!" : "error: Delete failed!";
        exit;
    }
}

// Handle GET requests (Display Data)
if (isset($_GET['get'])) {

    // ----- GET FEATURES -----
    if ($_GET['get'] === 'features') {
        $q = "SELECT * FROM features ORDER BY feid DESC";
        $res = mysqli_query($con, $q);
        $data = "";

        if (mysqli_num_rows($res) > 0) {
            $i = 1;
            while ($row = mysqli_fetch_assoc($res)) {
                $data .= "<tr>
                            <td>{$i}</td>
                            <td>{$row['name']}</td>
                            <td>
                                <button class='btn btn-sm btn-danger delete-feature' data-id='{$row['feid']}'>
                                    <i class='bi bi-trash'></i>
                                </button>
                            </td>
                          </tr>";
                $i++;
            }
        } else {
            $data = "<tr><td colspan='3'>No features found</td></tr>";
        }

        echo $data;
        exit;
    }

    // ----- GET FACILITIES -----
    if ($_GET['get'] === 'facilities') {
        $q = "SELECT * FROM facilities ORDER BY fid DESC";
        $res = mysqli_query($con, $q);
        $data = "";

        if (mysqli_num_rows($res) > 0) {
            $i = 1;
            while ($row = mysqli_fetch_assoc($res)) {
                // ✅ This should match your frontend URL path
                $icon_path = "/roroferry/admin/uploads/" . $row['icon'];

                $data .= "<tr>
                            <td>{$i}</td>
                            <td><img src='{$icon_path}' width='50'></td>
                            <td>{$row['name']}</td>
                            <td>{$row['description']}</td>
                            <td>
                                <button class='btn btn-sm btn-danger delete-facility' data-id='{$row['fid']}'>
                                    <i class='bi bi-trash'></i>
                                </button>
                            </td>
                          </tr>";
                $i++;
            }
        } else {
            $data = "<tr><td colspan='5'>No facilities found</td></tr>";
        }

        echo $data;
        exit;
    }
}
?>
