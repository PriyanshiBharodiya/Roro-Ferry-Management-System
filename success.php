<?php
require 'vendor/autoload.php'; // Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "inc/connection.php";

if (!isset($_SESSION['booking'])) {
   header("Location:index.php");
    exit;
}

// // Prevent double submission
// if (isset($_SESSION['booking_complete'])) {
//     header("Location: index.php");
//     exit;
// }
// $_SESSION['booking_complete'] = true;

$booking = $_SESSION['booking'];

// Extract booking details
$uid = $booking['uid'];
$pid = $booking['pid'];
$trip_id = $booking['trip_id'];
$seats = $booking['seats'];
$passengers = $booking['passengers'];
$total_amount = $booking['total_amount'];
$email = $booking['email'];
$mobile = $booking['mobile'];
$package_name = $booking['package_name'];
$trip = $booking['trip'];

$seat_str = implode(', ', array_map('htmlspecialchars', $seats));
$passenger_json = json_encode($passengers);

// Save to booking table
$insert = mysqli_query($con, "INSERT INTO booking (uid, pid, trip_id, seat_numbers, passenger_details, total_amount) 
VALUES ('$uid', '$pid', '$trip_id', '".mysqli_real_escape_string($con, $seat_str)."', '".mysqli_real_escape_string($con, $passenger_json)."', '$total_amount')");


if (!$insert) {
    echo "Failed to save booking.";
    exit;
}

// ✅ Update booked seats by trip_id instead of package_id
foreach ($seats as $seat) {
    $seat_safe = mysqli_real_escape_string($con, $seat);
    $trip_id_safe = mysqli_real_escape_string($con, $trip_id);

    $result = mysqli_query($con, "UPDATE seats 
                                  SET is_booked = 1 
                                  WHERE trip_id = '$trip_id_safe' AND seat_number = '$seat_safe'");

    // Optional debug
    if (!$result) {
        echo "Failed to book seat $seat_safe: " . mysqli_error($con);
    }
}

// ✅ Generate PDF
$logoPath = __DIR__ . "/ship_logo.png";
$logoBase64 = base64_encode(file_get_contents($logoPath));
$logoSrc = 'data:image/png;base64,' . $logoBase64;

$pdf_html = '
<style>
    body { font-family: DejaVu Sans, sans-serif; }
    .invoice-box { max-width: 800px; margin: auto; padding: 30px; font-size: 14px; color: #333; border: 1px solid #eee; }
    .header { text-align: center; margin-bottom: 20px; }
    .header img { width: 120px; margin-bottom: 10px; }
    .header h1 { font-size: 24px; margin: 5px 0; color: #0d6efd; }
    .section-title { background: #f2f2f2; padding: 8px; font-weight: bold; margin-top: 25px; }
    table { width: 100%; border-collapse: collapse; }
    table tr td, table tr th { border: 1px solid #ddd; padding: 8px; }
    .total { font-weight: bold; text-align: right; }
    .footer { margin-top: 40px; text-align: center; padding: 15px; background-color: #f0f8ff; border: 1px dashed #0d6efd; border-radius: 10px; font-size: 14px; color: #0d6efd; font-style: normal; }
</style>

<div class="invoice-box">
    <div class="header">
        <img src="' . $logoSrc . '" alt="Logo" />
        <h1>🧾 RoRoFerry Booking Receipt</h1>
        <small>Generated on ' . date("d M Y, h:i A") . '</small>
    </div>

    <div class="section-title">🚢 Package Details</div>
    <table>
        <tr>
            <td><strong>Package:</strong> ' . htmlspecialchars($package_name) . '</td>
            <td><strong>Date:</strong> ' . htmlspecialchars($trip["dep_date"]) . '</td>
        </tr>
        <tr>
            <td><strong>From:</strong> ' . htmlspecialchars($trip["dep_place"]) . '</td>
            <td><strong>To:</strong> ' . htmlspecialchars($trip["arr_place"]) . '</td>
        </tr>
        <tr>
            <td><strong>Departure:</strong> ' . htmlspecialchars($trip["dep_time"]) . '</td>
            <td><strong>Arrival:</strong> ' . htmlspecialchars($trip["arr_time"]) . '</td>
        </tr>
    </table>

    <div class="section-title">👤 Contact Info</div>
    <table>
        <tr>
            <td><strong>Email:</strong> ' . htmlspecialchars($email) . '</td>
            <td><strong>Mobile:</strong> ' . htmlspecialchars($mobile) . '</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Seats:</strong> ' . $seat_str . '</td>
        </tr>
    </table>

    <div class="section-title">👥 Passenger Details</div>
    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Seat</th>
        </tr>';

foreach ($passengers as $i => $p) {
    $pdf_html .= '<tr>
        <td>' . ($i + 1) . '</td>
        <td>' . htmlspecialchars($p["name"]) . '</td>
        <td>' . htmlspecialchars($p["age"]) . '</td>
        <td>' . htmlspecialchars($p["gender"]) . '</td>
        <td>' . htmlspecialchars($p["seat"]) . '</td>
    </tr>';
}

$pdf_html .= '
    </table>

    <div class="section-title">💰 Payment Summary</div>
    <table>
        <tr>
            <td class="total">Total Amount:</td>
            <td class="total">₹' . htmlspecialchars($total_amount) . '</td>
        </tr>
    </table>

    <div class="footer">
        <strong>
            Thank you for choosing <span style="color:#212529;">RoRoFerry</span>!<br>
            Wishing you a very happy and safe journey. 🚢⚓
        </strong>
    </div>
</div>';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($pdf_html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Save PDF
if (!file_exists("downloads")) {
    mkdir("downloads", 0777, true);
}
$pdfName = "ticket_" . time() . ".pdf";
$pdfPath = "downloads/{$pdfName}";
if (!file_put_contents($pdfPath, $dompdf->output())) {
    echo "Failed to generate PDF.";
    exit;
}

// Optional: update PDF path in booking table
// $escaped_pdfPath = mysqli_real_escape_string($con, $pdfPath);
// mysqli_query($con, "UPDATE booking SET pdf_path = '$escaped_pdfPath' 
//                     WHERE uid = '$uid' AND seat_numbers = '".mysqli_real_escape_string($con, $seat_str)."' LIMIT 1");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // 🔁 Your SMTP host (e.g., smtp.gmail.com)
    $mail->SMTPAuth   = true;
    $mail->Username   = 'krunalkaklotar2283@gmail.com';     // 🔁 Your SMTP username
    $mail->Password   = 'zxtqfgkbnqklpito';              // 🔁 Your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or PHPMailer::ENCRYPTION_SMTPS
    $mail->Port       = 587; // Or 465 for SSL

    //Recipients
    $mail->setFrom('krunalkaklotar2283@gmail.com', 'roroferry');
    $mail->addAddress($email); // 👤 Customer's email

    //Attachments
    $mail->addAttachment($pdfPath); // PDF file

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Your RoRoFerry Booking Ticket';
    $mail->Body    = "
        <h3>Hello,</h3>
        <p>Thank you for booking with <strong>RoRoFerry</strong>.</p>
        <p>Your ticket is attached to this email as a PDF.</p>
        <p>We wish you a smooth and enjoyable journey! ⚓</p>
        <br>
        <p>Regards,<br>RoRoFerry Team</p>
    ";

    $mail->send();
    // echo "Email sent.";
} catch (Exception $e) {
    error_log("Mail error: {$mail->ErrorInfo}");
}


// Clear booking session
unset($_SESSION['booking']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking Success</title>
    <?php include "inc/links.php"; ?>
    <style>
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; }
        .wrapper { flex: 1; display: flex; flex-direction: column; }
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 50px 15px;
        }
        footer {
            background: #f8f9fa;
            text-align: center;
            padding: 15px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include "inc/header.php"; ?>

    <div class="content">
        <div>
            <h2>✅ Booking Confirmed!</h2>
            <p>Your booking was successful. Your ticket is ready for download below.</p>
            <a href="<?= $pdfPath ?>" class="btn btn-primary" download>📥 Download Ticket (PDF)</a>
        </div>
    </div>

    <?php include "inc/footer.php"; ?>
</div>
</body>
</html>
