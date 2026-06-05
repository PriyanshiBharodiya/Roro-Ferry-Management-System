<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Features & Facilities</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-white">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">FEATURES & FACILITIES</h3>

                <!-- Features Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#feature-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="features-data">
                                    <!-- Features data loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Facilities Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#facility-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities-data">
                                    <!-- Facilities data loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Modal -->
    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="featureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="feature_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Feature</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="feature_name" class="form-control shadow-none" required>
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

    <!-- Facility Modal -->
    <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="facilityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="facility_s_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Facility</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="facility_name" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon</label>
                            <input type="file" name="facility_icon" accept=".jpg, .png, .webp, .jpeg"
                                class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="facility_desc" class="form-control" rows="3"></textarea>
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

    <script>
        function loadFeatures() {
            $.ajax({
                url: 'ajax/features_facilities/features_facilities_action.php',
                type: 'GET',
                data: { get: 'features' },
                success: function (data) {
                    $('#features-data').html(data);
                },
                error: function () {
                    alert('Failed to load features data.');
                }
            });
        }

        function loadFacilities() {
            $.ajax({
                url: 'ajax/features_facilities/features_facilities_action.php',
                type: 'GET',
                data: { get: 'facilities' },
                success: function (data) {
                    $('#facilities-data').html(data);
                },
                error: function () {
                    alert('Failed to load facilities data.');
                }
            });
        }

        $(document).ready(function () {
            loadFeatures();
            loadFacilities();

            $('#feature_s_form').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'ajax/features_facilities/features_facilities_action.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                     
                        $('#feature_s_form')[0].reset();
                        $('#feature-s').modal('hide');
                        loadFeatures();
                    },
                    error: function () {
                        alert('An error occurred while adding the feature.');
                    }
                });
            });

            $('#facility_s_form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'ajax/features_facilities/features_facilities_action.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                       
                        $('#facility_s_form')[0].reset();
                        $('#facility-s').modal('hide');
                        loadFacilities();
                    },
                    error: function () {
                        alert('An error occurred while adding the facility.');
                    }
                });
            });

            $(document).on('click', '.delete-feature', function () {
                var id = $(this).data('id');
                if (confirm("Are you sure you want to delete this feature?")) {
                    $.post('ajax/features_facilities/features_facilities_action.php', { id: id, type: 'delete_feature' }, function (response) {
                       
                        loadFeatures();
                    });
                }
            });

            $(document).on('click', '.delete-facility', function () {
                var id = $(this).data('id');
                if (confirm("Are you sure you want to delete this facility?")) {
                    $.post('ajax/features_facilities/features_facilities_action.php', { id: id, type: 'delete_facility' }, function (response) {
                       
                        loadFacilities();
                    });
                }
            });
        });
    </script>

    <?php require('inc/scripts.php'); ?>
</body>

</html>