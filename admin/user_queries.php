<?php

session_start();
if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Redirect to login page if not admin
    exit();
}


require('../inc/connection.php'); // Ensure correct database connection

// Handle Mark as Read
if (isset($_GET['seen'])) {
    $id = $_GET['seen'];

    if ($id == 'all') {
        mysqli_query($con, "UPDATE contacts SET seen = 1");
    } else {
        $id = intval($id);
        mysqli_query($con, "UPDATE contacts SET seen = 1 WHERE id = $id");
    }

    header("Location: user_queries.php");
    exit();
}

// Handle Delete
if (isset($_GET['del'])) {
    $id = $_GET['del'];

    if ($id == 'all') {
        mysqli_query($con, "DELETE FROM contacts");
    } else {
        $id = intval($id);
        mysqli_query($con, "DELETE FROM contacts WHERE id = $id");
    }

    header("Location: user_queries.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-white">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <h3 class="mb-4">USER QUERIES</h3>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                                <i class="bi bi-check-all"></i> Mark all read
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm"
                                onclick="return confirm('Are you sure you want to delete all messages?');">
                                <i class="bi bi-trash"></i> Delete all
                            </a>
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top bg-dark text-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width="10%">Subject</th>
                                        <th scope="col" width="30%">Message</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    
                                    $q = "SELECT * FROM `contacts` ORDER BY `id` DESC"; // Use `contacts` instead of `user_queries`
                                    $result = mysqli_query($con, $q);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($result)):
                                    ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><?= $row['subject'] ?></td>
                                            <td><?= $row['message'] ?></td>
                                            <td>
                                                <?php if ($row['seen'] != 1): ?>
                                                    <a href="?seen=<?= $row['id'] ?>" class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-circle"></i> <!-- Bootstrap Check Icon -->
                                                    </a>
                                                <?php endif; ?>
                                                <a href="?del=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?');">
                                                    <i class="bi bi-trash"></i> <!-- Bootstrap Trash Icon -->
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    endwhile;
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

</body>

</html>
