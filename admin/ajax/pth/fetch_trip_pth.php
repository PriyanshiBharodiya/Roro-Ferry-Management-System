<?php
include "../../../inc/connection.php"; // Ensure correct DB connection

// Fetch schedule data for PTH (Porbandar to Hajira)
$sql = "SELECT * FROM trip WHERE dep_place='Porbandar' AND arr_place='Hajira' ORDER BY trip_id DESC"; 
$res = mysqli_query($con, $sql);

if (!$res) {
    die("Error in Query: " . mysqli_error($con)); // Debugging: Show MySQL error
}

while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr>
        <td>{$row['trip_id']}</td>
        <td>{$row['trip_day']}</td>
        <td>{$row['dep_date']}</td>
        <td>{$row['dep_time']}</td>
        <td>{$row['arr_time']}</td>
        <td>
            <button class='btn " . ($row['status'] == 1 ? 'btn-success' : 'btn-danger') . " btn-sm toggle-status-pth' 
                data-id='{$row['trip_id']}' data-status='{$row['status']}'>
                " . ($row['status'] == 1 ? 'Active' : 'Inactive') . "
            </button>
        </td>
        <td>
            <button class='btn btn-primary btn-sm edit-trip-pth' data-id='{$row['trip_id']}'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-trip-pth' data-id='{$row['trip_id']}'>
                <i class='fas fa-trash'></i>
            </button>
        </td>
    </tr>";
}
?>
