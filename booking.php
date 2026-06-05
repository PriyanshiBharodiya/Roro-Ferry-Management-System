<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include required files
include "inc/links.php";
include "inc/header.php";
include "inc/connection.php";

// Get the logged-in user ID from session
$user_id = $_SESSION['user_id'];

// Fetch the bookings of the logged-in user
$query = "SELECT * FROM booking WHERE uid = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
    <h3 class="text-center mb-4">My Bookings</h3>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Booking ID</th>
                    <th>Seat Numbers</th>
                    <th>Passenger Details</th>
                    <th>Total Amount</th>
                    <th>Booking Date</th>
                    <th>Cancel</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php while ($booking = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $booking['id']; ?></td>
                        <td><?php echo $booking['seat_numbers']; ?></td>
                        <td>
                            <?php
                            $passengerDetails = json_decode($booking['passenger_details']);
                            foreach ($passengerDetails as $index => $passenger): ?>
                                <div class="mb-2 p-2 border rounded bg-light">
                                    <strong>Passenger <?php echo $index + 1; ?></strong><br>
                                    <span>Name:</span> <?php echo htmlspecialchars($passenger->name); ?><br>
                                    <span>Age:</span> <?php echo htmlspecialchars($passenger->age); ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                        <td>₹<?php echo $booking['total_amount']; ?></td>
                        <td><?php echo $booking['created_at']; ?></td>
                        <td>
                            <?php if ($booking['status'] == 1): ?>
                                <!-- Add confirmation prompt to the cancel button -->
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="confirmCancellation(<?php echo $booking['id']; ?>)">Cancel Ticket</a>
                            <?php else: ?>
                                <span class="text-danger fw-bold">Cancelled</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($booking['status'] == 1): ?>
                                <a href="generate_pdf.php?id=<?php echo $booking['id']; ?>" class="btn btn-primary btn-sm">Download Ticket</a>
                            <?php else: ?>
                                <span class="text-muted">Not available</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No bookings found.</p>
    <?php endif; ?>
</div>

<?php include "inc/footer.php"; ?>

<script>
    // Function to show the confirmation dialog before cancellation
    function confirmCancellation(bookingId) {
        const confirmAction = confirm("Are you sure you want to cancel the ticket?");
        if (confirmAction) {
            window.location.href = "cancel.php?id=" + bookingId;
        }
    }
</script>
