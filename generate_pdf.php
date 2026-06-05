<?php
require 'vendor/autoload.php'; // Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

include "inc/connection.php";



$booking_id = intval($_GET['id']);

// Fetch booking with user, package, trip details
$query = "SELECT b.*, 
                 u.email, u.phonenum, 
                 p.name AS package_name, 
                 t.dep_place, t.arr_place, t.dep_date, t.dep_time, t.arr_time 
          FROM booking b
          JOIN users u ON b.uid = u.id
          JOIN package p ON b.pid = p.pid
          LEFT JOIN trip t ON b.trip_id = t.trip_id
          WHERE b.id = $booking_id
          LIMIT 1";

$result = mysqli_query($con, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    die("Booking not found.");
}

$booking = mysqli_fetch_assoc($result);

$seats = explode(',', $booking['seat_numbers']);
$passengers = json_decode($booking['passenger_details'], true);
$trip = [
    'dep_place' => $booking['dep_place'],
    'arr_place' => $booking['arr_place'],
    'dep_date' => $booking['dep_date'],
    'dep_time' => $booking['dep_time'],
    'arr_time' => $booking['arr_time']
];

$seat_str = htmlspecialchars($booking['seat_numbers']);
$email = htmlspecialchars($booking['email']);
$mobile = htmlspecialchars($booking['phonenum']);
$package_name = htmlspecialchars($booking['package_name']);
$total_amount = htmlspecialchars($booking['total_amount']);

// Embed logo as base64
$logoPath = __DIR__ . "/ship_logo.png";
$logoBase64 = base64_encode(file_get_contents($logoPath));
$logoSrc = 'data:image/png;base64,' . $logoBase64;

// Start HTML for PDF
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
            <td><strong>Package:</strong> ' . $package_name . '</td>
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
            <td><strong>Email:</strong> ' . $email . '</td>
            <td><strong>Mobile:</strong> ' . $mobile . '</td>
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
            <td class="total">₹' . $total_amount . '</td>
        </tr>
    </table>

    <div class="footer">
        <strong>
            Thank you for choosing <span style="color:#212529;">RoRoFerry</span>!<br>
            Wishing you a very happy and safe journey. 🚢⚓
        </strong>
    </div>
</div>';

// Generate and output PDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($pdf_html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF directly for download
$filename = "ticket_{$booking_id}.pdf";
$dompdf->stream($filename, ["Attachment" => true]); // true = force download
exit;
