<?php
include "../../../inc/connection.php"; // Database connection

$q = "SELECT * FROM team ORDER BY id DESC";
$res = mysqli_query($con, $q);

while ($row = mysqli_fetch_assoc($res)) {
    echo <<<HTML
    <div class="col-md-2 mb-3" id="team-{$row['id']}">
        <div class="card bg-dark text-white">
            <img src="/roroferry/{$row['picture']}" class="card-img" style="border-radius: 10px; max-height: 100%; width: 100%; object-fit: cover;">
            <div class="card-img-overlay text-end">
                <button type="button" class="btn btn-danger btn-sm shadow-none delete-btn" data-id="{$row['id']}">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
            <p class="card-text text-center px-3 py-2">{$row['name']}</p>
        </div>
    </div>
    HTML;
}
?>
