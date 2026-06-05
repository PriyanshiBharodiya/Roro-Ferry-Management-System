<?php

$id=intval($_GET['id']);;
include "../inc/connection.php";

$sql="update booking set status=0 where id=$id";
$res = mysqli_query($con,$sql);

if($res)
{
    
    $sql2 ="select seat_numbers from booking where id=$id";
    $res2= mysqli_query($con,$sql2);

    if ($res2 && mysqli_num_rows($res2) > 0) {
        $row = mysqli_fetch_assoc($res2);
        
        $seat_numbers = $row['seat_numbers']; // e.g., "P24-T67-A1, P24-T67-A2"
        $seatArray = array_map('trim', explode(',', $seat_numbers)); // ["P24-T67-A1", "P24-T67-A2"]
        $seatList = "'" . implode("','", $seatArray) . "'";           // "'P24-T67-A1','P24-T67-A2'"
        
        $sql3 = "UPDATE seats SET is_booked = 0 WHERE seat_number IN ($seatList)";
        $res3 = mysqli_query($con, $sql3);
        

        if($res3)
        {
            header("Location: booking_details.php");
        }
    }
    
}
?>
