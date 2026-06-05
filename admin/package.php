<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel -PACKAGE </title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-white">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <H3 class="mb-4">PACKAGE</H3>

                <!-- features -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="text-end mb-3">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-package">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody id="package-data">
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- add package modal -->

    <div class="modal fade" id="add-package" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_package_form" action="" method="POST" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Package</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Area</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adult (Max.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Children (Max.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>

                            <!-- Features Section -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    include '../inc/connection.php'; // Ensure correct path to the connection file
                                    
                                    $query = "SELECT feid, name FROM features"; // Query adjusted to use 'feid'
                                    $res = mysqli_query($con, $query);

                                    if ($res) {
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                            <div class='col-md-3 mb-1'>
                                                <label>
                                                    <input type='checkbox' name='features[]' value='{$opt['feid']}' class='form-check-input shadow-none'>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                        ";
                                        }
                                    } else {
                                        echo "Error: " . mysqli_error($con); // If there is an error, show it
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Facilities Section -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Facilities</label>
                                <div class="row">
                                    <?php
                                    // Query to select all facilities
                                    $query = "SELECT fid, name FROM facilities"; // Query adjusted to use 'fid'
                                    $res = mysqli_query($con, $query);

                                    if ($res) {
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                            <div class='col-md-3 mb-1'>
                                                <label>
                                                    <input type='checkbox' name='facilities[]' value='{$opt['fid']}' class='form-check-input shadow-none'>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                        ";
                                        }
                                    } else {
                                        echo "Error: " . mysqli_error($con); // If there is an error, show it
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadow-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none"
                            data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- edit package modal -->
    <div class="modal fade" id="edit-package" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_package_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Package</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Area</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adult (Max.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Children (Max.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    include '../inc/connection.php'; // Ensure correct path to the connection file
                                    
                                    $query = "SELECT feid, name FROM features"; // Query adjusted to use 'feid'
                                    $res = mysqli_query($con, $query);

                                    if ($res) {
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                            <div class='col-md-3 mb-1'>
                                                <label>
                                                    <input type='checkbox' name='features[]' value='{$opt['feid']}' class='form-check-input shadow-none'>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                        ";
                                        }
                                    } else {
                                        echo "Error: " . mysqli_error($con); // If there is an error, show it
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Facilities</label>
                                <div class="row">
                                    <?php
                                    // Query to select all facilities
                                    $query = "SELECT fid, name FROM facilities"; // Query adjusted to use 'fid'
                                    $res = mysqli_query($con, $query);

                                    if ($res) {
                                        while ($opt = mysqli_fetch_assoc($res)) {
                                            echo "
                                            <div class='col-md-3 mb-1'>
                                                <label>
                                                    <input type='checkbox' name='facilities[]' value='{$opt['fid']}' class='form-check-input shadow-none'>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                        ";
                                        }
                                    } else {
                                        echo "Error: " . mysqli_error($con); // If there is an error, show it
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadow-none"></textarea>
                            </div>
                            <input type="hidden" name="package_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none"
                            data-bs-dismiss="modal">CANCLE</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- manage package images modal -->

    <div class="modal fade" id="package-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PACKAGE NAME</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert">

                    </div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form">
                            <label class="form-label fw-bold">Add Image</label>
                            <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg"
                                class="form-control shadow-none mb-3" required>
                            <button class="btn custom-bg text-white shadow-none">ADD</button>
                            <input type="hidden" name="package_id">
                        </form>
                    </div>
                    <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col" width=60%>Image</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="package-image-data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            loadPackages();

            $('#add_package_form').submit(function (e) {
                e.preventDefault();

                var features = [];
                $('input[name="features[]"]:checked').each(function () {
                    features.push($(this).val());
                });

                var facilities = [];
                $('input[name="facilities[]"]:checked').each(function () {
                    facilities.push($(this).val());
                });

                var form = $(this).serialize();
                form += '&features=' + JSON.stringify(features);
                form += '&facilities=' + JSON.stringify(facilities);
                form += '&action=add';

                $.post('/roroferry/admin/ajax/package/package_action.php', form, function (response) {
                    if (response == 1) {
                        $('#add-package').modal('hide');
                        loadPackages();
                    } else {
                        alert('Failed to add package.');
                    }
                });
            });

            $(document).on('click', '.edit-package', function () {
                var packageId = $(this).data('id');
                $.get('/roroferry/admin/ajax/package/package_action.php', { action: 'get_package', package_id: packageId }, function (response) {
                    var data = JSON.parse(response);
                    $('#edit_package_form [name="package_id"]').val(data.pid);
                    $('#edit_package_form [name="name"]').val(data.name);
                    $('#edit_package_form [name="area"]').val(data.area);
                    $('#edit_package_form [name="price"]').val(data.price);
                    $('#edit_package_form [name="quantity"]').val(data.quantity);
                    $('#edit_package_form [name="adult"]').val(data.adult);
                    $('#edit_package_form [name="children"]').val(data.children);
                    $('#edit_package_form [name="desc"]').val(data.description);
                    $('#edit-package').modal('show');
                });
            });

            $('#edit_package_form').submit(function (e) {
                e.preventDefault();

                var features = [];
                $('input[name="features[]"]:checked').each(function () {
                    features.push($(this).val());
                });

                var facilities = [];
                $('input[name="facilities[]"]:checked').each(function () {
                    facilities.push($(this).val());
                });

                var form = $(this).serialize();
                form += '&features=' + JSON.stringify(features);
                form += '&facilities=' + JSON.stringify(facilities);
                form += '&action=update';

                $.post('/roroferry/admin/ajax/package/package_action.php', form, function (response) {
                    if (response == 1) {
                        $('#edit-package').modal('hide');
                        loadPackages();
                    } else {
                        alert('Failed to update package.');
                    }
                });
            });

            $(document).on('click', '.delete-package', function () {
                if (confirm('Are you sure you want to delete this package?')) {
                    var packageId = $(this).data('id');
                    $.post('/roroferry/admin/ajax/package/package_action.php', { action: 'delete', package_id: packageId }, function () {
                        loadPackages();
                    });
                }
            });

            $(document).on('click', '.manage-images', function () {
                var packageId = $(this).data('id');
                $('input[name="package_id"]').val(packageId);
                loadPackageImages(packageId);
                $('#package-images').modal('show');
            });

            function loadPackageImages(packageId) {
                $.get('/roroferry/admin/ajax/package/package_action.php', { action: 'load_images', package_id: packageId }, function (response) {
                    $('#package-image-data').html(response);
                });
            }

            $('#add_image_form').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'add_image');

                $.ajax({
                    url: '/roroferry/admin/ajax/package/package_action.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            var pid = $('input[name="package_id"]').val();
                            loadPackageImages(pid);
                        } else {
                            alert('Image error: ' + response.message);
                        }
                    }
                });
            });

            $(document).on('click', '.delete-image', function () {
                var imageId = $(this).data('id');
                var packageId = $(this).data('package-id');
                $.post('/roroferry/admin/ajax/package/package_action.php', {
                    action: 'delete_image',
                    image_id: imageId,
                    package_id: packageId
                }, function () {
                    loadPackageImages(packageId);
                });
            });

            function loadPackages() {
                $.get('/roroferry/admin/ajax/package/package_action.php', { action: 'display' }, function (response) {
                    $('#package-data').html(response);
                });
            }

            // ✅ Move these into ready block
            window.toggle_status = function (pid, value) {
                $.post('/roroferry/admin/ajax/package/package_action.php', {
                    action: 'toggle_status',
                    package_id: pid,
                    value: value
                }, function (response) {
                    if (response == 1) {
                        loadPackages();
                    } else {
                        alert('Failed to change status.');
                    }
                });
            }

            window.thumb_image = function (imageId, packageId) {
                $.post('/roroferry/admin/ajax/package/package_action.php', {
                    action: 'thumb_image',
                    image_id: imageId,
                    package_id: packageId
                }, function (response) {
                    if (response == 1) {
                        loadPackageImages(packageId);
                    } else {
                        alert('Failed to set thumbnail.');
                    }
                });
            }
        });
    </script>






    <?php require('inc/scripts.php'); ?>



</body>

</html>