
<?php
session_start();
if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Redirect to login page if not admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel - Schedule</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-white">

    <?php require('inc/header.php'); ?>

    <!-- hajira to Porbandar -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden   ">
                <H3 class="mb-4">Trip</H3>
                <!-- HAJIRA TO PORBANDAR -->
                <h5> Hajira To Porbandar</h5>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">

                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-schedule">

                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 200px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure time</th>
                                        <th scope="col">Arrival time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>

                                </thead>
                                <tbody id="schedule-data">

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add trip for htp modal -->
    <div class="modal fade" id="add-schedule" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="tripForm_add" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Add Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Day</label>
                            <select name="trip_day" class="form-control shadow-none" required>
                                <option value="">Select Day</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>



                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" name="dep_date" class="form-control shadow-none" required>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="time" name="dep_time" class="form-control shadow-none" required>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="time" name="arr_time" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-3">

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

    <!-- ajax for htp crud -->
    <script>
        $(document).ready(function () {
            // Function to fetch and display data
            function loadScheduleData() {
                $.ajax({
                    url: "ajax/htp/fetch_trip_htp.php",
                    method: "GET",
                    success: function (data) {
                        $("#schedule-data").html(data); // Update table body with new data
                    }
                });
            }

            // Load schedule data on page load
            loadScheduleData();

            //add trip
            $("#tripForm_add").submit(function (e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    type: "POST",
                    url: "ajax/htp/insert_trip_htp.php", // PHP file to handle insertion
                    data: $(this).serialize(), // Serialize form data
                    success: function (response) {
                        if (response === "1") {
                            alert('success', 'New Trip added!');
                            $("#tripForm_add")[0].reset(); // Reset form
                            loadScheduleData(); // Fetch and update schedule after insert
                        } else {
                            alert('error', 'Server down! Response: ' + response);
                        }
                    }
                });

                var myModal = document.getElementById('add-schedule');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
            });

            // Delete Trip
            $(document).ready(function () {
                $(document).on("click", ".delete-trip", function () {
                    var tripId = $(this).data("id");

                    if (confirm("Are you sure you want to delete this trip?")) {
                        $.ajax({
                            url: "ajax/htp/delete_trip_htp.php",
                            type: "POST",
                            data: { trip_id: tripId },
                            success: function (response) {

                               
                                    loadScheduleData(); // Reload table after deletion
                               
                            }
                        });
                    }
                });
            });


            // Edit Trip (Fetch Data for Edit Modal)
            $(document).on("click", ".edit-trip", function () {
                var tripId = $(this).data("id"); // Get trip ID from button

                console.log("Trip ID to edit:", tripId); // Debugging step

                $.ajax({
                    url: "ajax/htp/edit_trip_htp.php",
                    type: "POST",
                    data: { trip_id: tripId },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            console.log("Error:", data.error);
                            alert("Trip not found!");
                            return;
                        }

                        console.log("Data loaded:", data); // Debugging step

                        // Populate form fields
                        $("#schedule_id").val(data.trip_id);
                        $("#trip_day").val(data.trip_day);
                        $("#departure_date").val(data.dep_date);
                        $("#departure_time").val(data.dep_time);
                        $("#arrival_time").val(data.arr_time);

                        $("#edit-schedule").modal("show"); // Open modal
                    },
                    error: function () {
                        alert("Failed to load trip data!");
                    }
                });
            });

            $(document).on("submit", "#edit_schedule_form", function (e) {
                e.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Get form data
                console.log("Form Data Sent:", formData); // Debugging Step

                $.ajax({
                    url: "ajax/htp/update_trip_htp.php", // ✅ Update script path
                    type: "POST",
                    data: formData,
                    success: function (response) {

                        console.log("Response from server:", response); // Debugging Step

                        if (response === "success") {
                            $("#edit-schedule").modal("hide");
                            location.reload();
                        } else {
                            alert("Error updating trip: " + response);
                        }
                    }
                });
            });

            // Toggle Active/Inactive Status
            $(document).on("click", ".toggle-status", function () {
                var tripId = $(this).data("id");
                var currentStatus = $(this).data("status");

                $.ajax({
                    url: "ajax/htp/update_status_htp.php",
                    type: "POST",
                    data: { trip_id: tripId, status: currentStatus },
                    success: function (response) {
                        if (response.trim() === "Updated") {
                            loadScheduleData(); // Reload table to reflect status change
                        } else {
                            alert("Error updating status!");
                        }
                    }
                });
            });
        });
    </script>

    <!-- edit trip for htp modal -->
    <div class="modal fade" id="edit-schedule" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_schedule_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        ` <h5 class="modal-title">Edit schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <input type="text" id="trip_day" name="trip_day" class="form-control shadow-none"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" id="departure_date" name="departure_date"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="text" id="departure_time" name="departure_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="text" id="arrival_time" name="arrival_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" id="schedule_id" name="schedule_id">
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



    <!-- Porbandar to Hajira -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Trip</h3>

                <!-- PORBANDAR TO HAJIRA -->
                <h5>Porbandar To Hajira</h5>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-schedule-pth">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 200px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Arrival Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="schedule-data-pth"></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Trip for PTH Modal -->
    <div class="modal fade" id="add-schedule-pth" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="tripForm_add_pth" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Add Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Day</label>
                            <select name="trip_day" class="form-control shadow-none" required>
                                <option value="">Select Day</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" name="dep_date" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="time" name="dep_time" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="time" name="arr_time" class="form-control shadow-none" required>
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

    <!-- AJAX for PTH CRUD -->
    <script>
        $(document).ready(function () {
            function loadScheduleDataPth() {
                $.ajax({
                    url: "ajax/pth/fetch_trip_pth.php",
                    method: "GET",
                    success: function (data) {
                        $("#schedule-data-pth").html(data);
                    }
                });
            }

            loadScheduleDataPth();

            $("#tripForm_add_pth").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "ajax/pth/insert_trip_pth.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "1") {
                            alert('success', 'New Trip added!');
                            $("#tripForm_add_pth")[0].reset();
                            loadScheduleDataPth();
                        } else {
                            alert('error', 'Server down! Response: ' + response);
                        }
                    }
                });

                var myModal = document.getElementById('add-schedule-pth');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
            });

            $(document).on("click", ".delete-trip-pth", function () {
                var tripId = $(this).data("id");

                if (confirm("Are you sure you want to delete this trip?")) {
                    $.ajax({
                        url: "ajax/pth/delete_trip_pth.php",
                        type: "POST",
                        data: { trip_id: tripId },
                        success: function (response) {
                          
                                loadScheduleDataPth();
                           
                        }
                    });
                }
            });

            $(document).on("click", ".edit-trip-pth", function () {
                var tripId = $(this).data("id");

                $.ajax({
                    url: "ajax/pth/edit_trip_pth.php",
                    type: "POST",
                    data: { trip_id: tripId },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            alert("Trip not found!");
                            return;
                        }

                        $("#schedule_id_pth").val(data.trip_id);
                        $("#trip_day_pth").val(data.trip_day);
                        $("#departure_date_pth").val(data.dep_date);
                        $("#departure_time_pth").val(data.dep_time);
                        $("#arrival_time_pth").val(data.arr_time);

                        $("#edit-schedule-pth").modal("show");
                    },
                    error: function () {
                        alert("Failed to load trip data!");
                    }
                });
            });

            $(document).on("submit", "#edit_schedule_form_pth", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "ajax/pth/update_trip_pth.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "success") {
                            $("#edit-schedule-pth").modal("hide");
                            location.reload();
                        } else {
                            alert("Error updating trip: " + response);
                        }
                    }
                });
            });

            $(document).on("click", ".toggle-status-pth", function () {
                var tripId = $(this).data("id");
                var currentStatus = $(this).data("status");

                $.ajax({
                    url: "ajax/pth/update_status_pth.php",
                    type: "POST",
                    data: { trip_id: tripId, status: currentStatus },
                    success: function (response) {
                        if (response.trim() === "Updated") {
                            loadScheduleDataPth();
                        } else {
                            alert("Error updating status!");
                        }
                    }
                });
            });
        });
    </script>

    <!-- edit Trip for PTH Modal -->
    <div class="modal fade" id="edit-schedule-pth" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_schedule_form_pth" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <input type="text" id="trip_day_pth" name="trip_day" class="form-control shadow-none"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" id="departure_date_pth" name="departure_date"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="text" id="departure_time_pth" name="departure_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="text" id="arrival_time_pth" name="arrival_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" id="schedule_id_pth" name="schedule_id">
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



    <!-- Hajira to Bhavnagar -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Trip</h3>

                <h5>Hajira To Bhavnagar</h5>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-schedule-htb">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 200px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Arrival Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="schedule-data-htb"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Trip for HTB Modal -->
    <div class="modal fade" id="add-schedule-htb" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="tripForm_add_htb" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Add Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Day</label>
                            <select name="trip_day" class="form-control shadow-none" required>
                                <option value="">Select Day</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" name="dep_date" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="time" name="dep_time" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="time" name="arr_time" class="form-control shadow-none" required>
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

    <!-- AJAX for htb CRUD -->
    <script>
        $(document).ready(function () {
            function loadScheduleDataHtb() {
                $.ajax({
                    url: "ajax/htb/fetch_trip_htb.php",
                    method: "GET",
                    success: function (data) {
                        $("#schedule-data-htb").html(data);
                    }
                });
            }

            loadScheduleDataHtb();

            $("#tripForm_add_htb").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "ajax/htb/insert_trip_htb.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "1") {
                            alert('success', 'New Trip added!');
                            $("#tripForm_add_htb")[0].reset();
                            loadScheduleDataHtb();
                        } else {
                            alert('error', 'Server down! Response: ' + response);
                        }
                    }
                });

                var myModal = document.getElementById('add-schedule-htb');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
            });

            $(document).on("click", ".delete-trip-htb", function () {
                var tripId = $(this).data("id");

                if (confirm("Are you sure you want to delete this trip?")) {
                    $.ajax({
                        url: "ajax/htb/delete_trip_htb.php",
                        type: "POST",
                        data: { trip_id: tripId },
                        success: function (response) {
                          
                                loadScheduleDataHtb();
                           
                        }
                    });
                }
            });

            $(document).on("click", ".edit-trip-htb", function () {
                var tripId = $(this).data("id");

                $.ajax({
                    url: "ajax/htb/edit_trip_htb.php",
                    type: "POST",
                    data: { trip_id: tripId },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            alert("Trip not found!");
                            return;
                        }

                        $("#schedule_id_htb").val(data.trip_id);
                        $("#trip_day_htb").val(data.trip_day);
                        $("#departure_date_htb").val(data.dep_date);
                        $("#departure_time_htb").val(data.dep_time);
                        $("#arrival_time_htb").val(data.arr_time);

                        $("#edit-schedule-htb").modal("show");
                    },
                    error: function () {
                        alert("Failed to load trip data!");
                    }
                });
            });

            $(document).on("submit", "#edit_schedule_form_htb", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "ajax/htb/update_trip_htb.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "success") {
                            $("#edit-schedule-htb").modal("hide");
                            location.reload();
                        } else {
                            alert("Error updating trip: " + response);
                        }
                    }
                });
            });


            $(document).on("click", ".toggle-status-htb", function () {
                var tripId = $(this).data("id");
                var currentStatus = $(this).data("status");

                $.ajax({
                    url: "ajax/htb/update_status_htb.php",
                    type: "POST",
                    data: { trip_id: tripId, status: currentStatus },
                    success: function (response) {
                        if (response.trim() === "Updated") {
                            loadScheduleDataHtb();
                        } else {
                            alert("Error updating status!");
                        }
                    }
                });
            });
        });
    </script>

    <!-- Edit Trip for HTB Modal -->
    <div class="modal fade" id="edit-schedule-htb" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_schedule_form_htb" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <input type="text" id="trip_day_htb" name="trip_day" class="form-control shadow-none"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" id="departure_date_htb" name="departure_date"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="text" id="departure_time_htb" name="departure_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="text" id="arrival_time_htb" name="arrival_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" id="schedule_id_htb" name="schedule_id">
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




    <!-- Bhavnagar to Hajira -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Trip</h3>

                <h5>Bhavnagar To Hajira</h5>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-schedule-bth">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 200px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Arrival Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="schedule-data-bth"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Trip for Bhavnagar to Hajira Modal -->
    <div class="modal fade" id="add-schedule-bth" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="tripForm_add_bth" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- The form fields for day, departure date/time and arrival time -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <select name="trip_day" class="form-control shadow-none" required>
                                    <option value="">Select Day</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" name="dep_date" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="time" name="dep_time" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="time" name="arr_time" class="form-control shadow-none" required>
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

    <!-- AJAX for Bhavnagar to Hajira CRUD -->
    <script>
        $(document).ready(function () {
            function loadScheduleDataBth() {
                $.ajax({
                    url: "ajax/bth/fetch_trip_bth.php",
                    method: "GET",
                    success: function (data) {
                        $("#schedule-data-bth").html(data);
                    }
                });
            }

            loadScheduleDataBth();

            $("#tripForm_add_bth").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "ajax/bth/insert_trip_bth.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "1") {
                            alert('success', 'New Trip added!');
                            $("#tripForm_add_bth")[0].reset();
                            loadScheduleDataBth();
                        } else {
                            alert('error', 'Server down! Response: ' + response);
                        }
                    }
                });

                var myModal = document.getElementById('add-schedule-bth');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
            });

            $(document).on("click", ".delete-trip-bth", function () {
                var tripId = $(this).data("id");

                if (confirm("Are you sure you want to delete this trip?")) {
                    $.ajax({
                        url: "ajax/bth/delete_trip_bth.php",
                        type: "POST",
                        data: { trip_id: tripId },
                        success: function (response) {
                          
                                loadScheduleDataBth();
                          
                        }
                    });
                }
            });

            $(document).on("click", ".edit-trip-bth", function () {
                var tripId = $(this).data("id");

                $.ajax({
                    url: "ajax/bth/edit_trip_bth.php",
                    type: "POST",
                    data: { trip_id: tripId },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            alert("Trip not found!");
                            return;
                        }

                        $("#schedule_id_bth").val(data.trip_id);
                        $("#trip_day_bth").val(data.trip_day);
                        $("#departure_date_bth").val(data.dep_date);
                        $("#departure_time_bth").val(data.dep_time);
                        $("#arrival_time_bth").val(data.arr_time);

                        $("#edit-schedule-bth").modal("show");
                    },
                    error: function () {
                        alert("Failed to load trip data!");
                    }
                });
            });

            $(document).on("submit", "#edit_schedule_form_bth", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "ajax/bth/update_trip_bth.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "success") {
                            $("#edit-schedule-bth").modal("hide");
                            location.reload();
                        } else {
                            alert("Error updating trip: " + response);
                        }
                    }
                });
            });

            $(document).on("click", ".toggle-status-bth", function () {
                var tripId = $(this).data("id");
                var currentStatus = $(this).data("status");

                $.ajax({
                    url: "ajax/bth/update_status_bth.php",
                    type: "POST",
                    data: { trip_id: tripId, status: currentStatus },
                    success: function (response) {
                        if (response.trim() === "Updated") {
                            loadScheduleDataBth();
                        } else {
                            alert("Error updating status!");
                        }
                    }
                });
            });
        });
    </script>

    <!-- Edit Trip for Bhavnagar to Hajira Modal -->
    <div class="modal fade" id="edit-schedule-bth" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_schedule_form_bth" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Form fields for editing -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <input type="text" id="trip_day_bth" name="trip_day" class="form-control shadow-none"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" id="departure_date_bth" name="departure_date"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="text" id="departure_time_bth" name="departure_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="text" id="arrival_time_bth" name="arrival_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" id="schedule_id_bth" name="schedule_id">
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




    
    <!-- Hajira to Veraval -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Trip</h3>

                <h5>Hajira To Veraval</h5>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-schedule-htv">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 200px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Arrival Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="schedule-data-htv"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Trip for Hajira to Veraval Modal -->
    <div class="modal fade" id="add-schedule-htv" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="tripForm_add_htv" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Form fields for day, departure date/time and arrival time -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <select name="trip_day" class="form-control shadow-none" required>
                                    <option value="">Select Day</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" name="dep_date" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="time" name="dep_time" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="time" name="arr_time" class="form-control shadow-none" required>
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

    <!-- AJAX for Hajira to Veraval CRUD -->
    <script>
        $(document).ready(function () {
            function loadScheduleDataHtv() {
                $.ajax({
                    url: "ajax/htv/fetch_trip_htv.php",
                    method: "GET",
                    success: function (data) {
                        $("#schedule-data-htv").html(data);
                    }
                });
            }

            loadScheduleDataHtv();

            $("#tripForm_add_htv").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "ajax/htv/insert_trip_htv.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "1") {
                            alert('success', 'New Trip added!');
                            $("#tripForm_add_htv")[0].reset();
                            loadScheduleDataHtv();
                        } else {
                            alert('error', 'Server down! Response: ' + response);
                        }
                    }
                });

                var myModal = document.getElementById('add-schedule-htv');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
            });

            $(document).on("click", ".delete-trip-htv", function () {
                var tripId = $(this).data("id");

                if (confirm("Are you sure you want to delete this trip?")) {
                    $.ajax({
                        url: "ajax/htv/delete_trip_htv.php",
                        type: "POST",
                        data: { trip_id: tripId },
                        success: function (response) {
                           
                                loadScheduleDataHtv();
                          
                        }
                    });
                }
            });

            $(document).on("click", ".edit-trip-htv", function () {
                var tripId = $(this).data("id");

                $.ajax({
                    url: "ajax/htv/edit_trip_htv.php",
                    type: "POST",
                    data: { trip_id: tripId },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            alert("Trip not found!");
                            return;
                        }

                        $("#schedule_id_htv").val(data.trip_id);
                        $("#trip_day_htv").val(data.trip_day);
                        $("#departure_date_htv").val(data.dep_date);
                        $("#departure_time_htv").val(data.dep_time);
                        $("#arrival_time_htv").val(data.arr_time);

                        $("#edit-schedule-htv").modal("show");
                    },
                    error: function () {
                        alert("Failed to load trip data!");
                    }
                });
            });

            $(document).on("submit", "#edit_schedule_form_htv", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "ajax/htv/update_trip_htv.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "success") {
                            $("#edit-schedule-htv").modal("hide");
                            location.reload();
                        } else {
                            alert("Error updating trip: " + response);
                        }
                    }
                });
            });

            $(document).on("click", ".toggle-status-htv", function () {
                var tripId = $(this).data("id");
                var currentStatus = $(this).data("status");

                $.ajax({
                    url: "ajax/htv/update_status_htv.php",
                    type: "POST",
                    data: { trip_id: tripId, status: currentStatus },
                    success: function (response) {
                        if (response.trim() === "Updated") {
                            loadScheduleDataHtv();
                        } else {
                            alert("Error updating status!");
                        }
                    }
                });
            });
        });
    </script>

    <!-- Edit Trip for Hajira to Veraval Modal -->
    <div class="modal fade" id="edit-schedule-htv" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_schedule_form_htv" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Form fields for editing -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <input type="text" id="trip_day_htv" name="trip_day" class="form-control shadow-none"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" id="departure_date_htv" name="departure_date"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="text" id="departure_time_htv" name="departure_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="text" id="arrival_time_htv" name="arrival_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" id="schedule_id_htv" name="schedule_id">
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






    <!-- Veraval to Hajira -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Trip</h3>

                <h5>Veraval To Hajira</h5>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-schedule-vth">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 200px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Arrival Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="schedule-data-vth"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Trip for Veraval to Hajira Modal -->
    <div class="modal fade" id="add-schedule-vth" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="tripForm_add_vth" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Form fields for day, departure date/time and arrival time -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <select name="trip_day" class="form-control shadow-none" required>
                                    <option value="">Select Day</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" name="dep_date" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="time" name="dep_time" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="time" name="arr_time" class="form-control shadow-none" required>
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

    <!-- AJAX for Veraval to Hajira CRUD -->
    <script>
        $(document).ready(function () {
            function loadScheduleDataVth() {
                $.ajax({
                    url: "ajax/vth/fetch_trip_vth.php",
                    method: "GET",
                    success: function (data) {
                        $("#schedule-data-vth").html(data);
                    }
                });
            }

            loadScheduleDataVth();

            $("#tripForm_add_vth").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "ajax/vth/insert_trip_vth.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "1") {
                            alert('success', 'New Trip added!');
                            $("#tripForm_add_vth")[0].reset();
                            loadScheduleDataVth();
                        } else {
                            alert('error', 'Server down! Response: ' + response);
                        }
                    }
                });

                var myModal = document.getElementById('add-schedule-vth');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
            });

            $(document).on("click", ".delete-trip-vth", function () {
                var tripId = $(this).data("id");

                if (confirm("Are you sure you want to delete this trip?")) {
                    $.ajax({
                        url: "ajax/vth/delete_trip_vth.php",
                        type: "POST",
                        data: { trip_id: tripId },
                        success: function (response) {
                           
                                loadScheduleDataVth();
                           
                        }
                    });
                }
            });

            $(document).on("click", ".edit-trip-vth", function () {
                var tripId = $(this).data("id");

                $.ajax({
                    url: "ajax/vth/edit_trip_vth.php",
                    type: "POST",
                    data: { trip_id: tripId },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            alert("Trip not found!");
                            return;
                        }

                        $("#schedule_id_vth").val(data.trip_id);
                        $("#trip_day_vth").val(data.trip_day);
                        $("#departure_date_vth").val(data.dep_date);
                        $("#departure_time_vth").val(data.dep_time);
                        $("#arrival_time_vth").val(data.arr_time);

                        $("#edit-schedule-vth").modal("show");
                    },
                    error: function () {
                        alert("Failed to load trip data!");
                    }
                });
            });

            $(document).on("submit", "#edit_schedule_form_vth", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "ajax/vth/update_trip_vth.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response === "success") {
                            $("#edit-schedule-vth").modal("hide");
                            location.reload();
                        } else {
                            alert("Error updating trip: " + response);
                        }
                    }
                });
            });

            $(document).on("click", ".toggle-status-vth", function () {
                var tripId = $(this).data("id");
                var currentStatus = $(this).data("status");

                $.ajax({
                    url: "ajax/vth/update_status_vth.php",
                    type: "POST",
                    data: { trip_id: tripId, status: currentStatus },
                    success: function (response) {
                        if (response.trim() === "Updated") {
                            loadScheduleDataVth();
                        } else {
                            alert("Error updating status!");
                        }
                    }
                });
            });
        });
    </script>

    <!-- Edit Trip for Veraval to Hajira Modal -->
    <div class="modal fade" id="edit-schedule-vth" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_schedule_form_vth" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Schedule</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Form fields for editing -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Day</label>
                                <input type="text" id="trip_day_vth" name="trip_day" class="form-control shadow-none"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Date</label>
                                <input type="date" id="departure_date_vth" name="departure_date"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Departure Time</label>
                                <input type="text" id="departure_time_vth" name="departure_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Arrival Time</label>
                                <input type="text" id="arrival_time_vth" name="arrival_time"
                                    class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" id="schedule_id_vth" name="schedule_id">
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





    <?php require('inc/scripts.php'); ?>
</body>

</html>