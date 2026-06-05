<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel -SETTINGS</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-white">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <H3 class="mb-4">SETTINGS</H3>




                <!-- contact details section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contacts settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#contacts-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1fw-bold">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1fw-bold">Phone Numbers</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>

                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1fw-bold">E-mail</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>

                            <div class="col-lg-6">

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-facebook me-1"></i>
                                        <span id="fb"></span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-instagram me-1"></i>
                                        <span id="insta"></span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-twitter-x me-1"></i>
                                        <span id="tw"></span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame</h6>
                                    <iframe id="iframe" class="border p-1 w-100" loading="lazy"></iframe>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- contact details modal -->
                <div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="contacts_s_form">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Contacts Settings</h5>
                                </div>

                                <div class="modal-body">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class=" mb-3">
                                                    <label class="form-label fw-bold">Address </label>
                                                    <input type="text" name="address" id="address_inp"
                                                        class="form-control shadow-none" required>
                                                </div>
                                                <div class=" mb-3">
                                                    <label class="form-label fw-bold">Google map link </label>
                                                    <input type="text" name="gmap" id="gmap_inp"
                                                        class="form-control shadow-none" required>
                                                </div>
                                                <div class=" mb-3">
                                                    <label class="form-label fw-bold">Phone Number (with country code)
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-telephone-fill"></i></span>
                                                        <input type="number" name="pn1" id="pn1_inp"
                                                            class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-telephone-fill"></i></span>
                                                        <input type="number" name="pn2" id="pn2_inp"
                                                            class="form-control shadow-none">
                                                    </div>
                                                </div>
                                                <div class=" mb-3">
                                                    <label class="form-label fw-bold">Email </label>
                                                    <input type="email" name="email" id="email_inp"
                                                        class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class=" mb-3">
                                                    <label class="form-label fw-bold">social links</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-facebook me-1"></i></span>
                                                        <input type="text" name="fb" id="fb_inp"
                                                            class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-instagram me-1"></i></span>
                                                        <input type="text" name="insta" id="insta_inp"
                                                            class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"> <i
                                                                class="bi bi-twitter-x me-1"></i></span>
                                                        <input type="text" name="tw" id="tw_inp"
                                                            class="form-control shadow-none">
                                                    </div>
                                                </div>
                                                <div class=" mb-3">
                                                    <label class="form-label fw-bold">iframe Src</label>
                                                    <input type="text" name="iframe" id="iframe_inp"
                                                        class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" onclick="contacts_inp(contacts_data)"
                                        class=" btn text-secondary shadow-none" data-bs-dismiss="modal">CANCLE</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <!-- contact details script ajax -->
                <script>
                    $(document).ready(function () {
                        get_contacts(); // Fetch contacts on page load

                        // Handle form submission
                        $("#contacts_s_form").submit(function (e) {
                            e.preventDefault(); // Prevent default form submission

                            var formData = $(this).serialize() + "&upd_contacts=1"; // Serialize the form data and add the upd_contacts flag

                            console.log("Form Data Sent:", formData); // Log form data to console

                            $.ajax({
                                url: "/roroferry/admin/ajax/contact/contact_update.php", // Point to the update file
                                type: "POST",
                                data: formData, // Send the serialized data
                                success: function (response) {
                                    get_contacts(); // Refresh the contact details
                                    $("#contacts-s").modal("hide"); // Close modal
                                },
                                error: function (xhr, status, error) {
                                    console.error('AJAX Error:', status, error); // Log AJAX error if any
                                }
                            });
                        });
                    });

                    // Function to fetch and display contact details
                    function get_contacts() {
                        $.ajax({
                            url: "/roroferry/admin/ajax/contact/contact_display.php", // Point to the display file
                            type: "POST",
                            data: { get_contacts: 1 },
                            dataType: "json",
                            success: function (response) {
                                console.log('Contacts Data:', response); // Log the fetched contacts data
                                $("#address").text(response.address);
                                $("#gmap").html(`<a href="${response.gmap}" target="_blank">View on Google Maps</a>`);
                                $("#pn1").text(response.pn1);
                                $("#pn2").text(response.pn2);
                                $("#email").text(response.email);
                                $("#fb").html(`<a href="${response.fb}" target="_blank">Facebook</a>`);
                                $("#insta").html(`<a href="${response.insta}" target="_blank">Instagram</a>`);
                                $("#tw").html(`<a href="${response.tw}" target="_blank">Twitter</a>`);
                                $("#iframe").attr("src", response.iframe);

                                // Populate modal form fields
                                $("#address_inp").val(response.address);
                                $("#gmap_inp").val(response.gmap);
                                $("#pn1_inp").val(response.pn1);
                                $("#pn2_inp").val(response.pn2);
                                $("#email_inp").val(response.email);
                                $("#fb_inp").val(response.fb);
                                $("#insta_inp").val(response.insta);
                                $("#tw_inp").val(response.tw);
                                $("#iframe_inp").val(response.iframe);
                            },
                            error: function (xhr, status, error) {
                                console.error('Error fetching contacts:', status, error); // Log errors if any
                            }
                        });
                    }

                </script>

                

                <!-- Management Team Section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Team</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#team-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="row" id="team-data">
                            <!-- Team members will be dynamically loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Management Team Modal -->
                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="team_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Team Member</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <input type="text" name="member_name" id="member_name_inp"
                                            class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Picture</label>
                                        <input type="file" name="member_picture" id="member_picture_inp"
                                            accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="document.getElementById('team_s_form').reset()"
                                        class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Management Team script ajax -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function () {
                        loadTeam(); // Load team members initially

                        // Add Member (Submit Form)
                        $("#team_s_form").submit(function (e) {
                            e.preventDefault();
                            let formData = new FormData(this);

                            $.ajax({
                                url: "/roroferry/admin/ajax/team/team_insert.php",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function () {
                                    $("#team_s_form")[0].reset();
                                    $("#team-s").modal("hide");
                                    loadTeam(); // Refresh data
                                }
                            });
                        });

                        // Load Members (Fetch Data)
                        function loadTeam() {
                            $.ajax({
                                url: "/roroferry/admin/ajax/team/team_display.php",
                                type: "GET",
                                success: function (data) {
                                    $("#team-data").html(data);
                                }
                            });
                        }

                        // Delete Member
                        $(document).on("click", ".delete-btn", function () {
                            let memberId = $(this).data("id");

                            $.ajax({
                                url: "/roroferry/admin/ajax/team/team_delete.php",
                                type: "POST",
                                data: { id: memberId },
                                success: function () {
                                    $("#team-" + memberId).fadeOut("slow", function () {
                                        $(this).remove(); // Remove from UI
                                    });
                                }
                            });
                        });
                    });
                </script>


                <!-- shutdown section -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">shutdown website</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox"
                                        id="shutdown-toggle">
                                </form>
                            </div>
                        </div>
                        <p class="card-text" id="site_about">
                            No customer will be allowed to book Fery when shutdown mode is turned on.
                        </p>
                    </div>
                </div>



            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>

</body>

</html>