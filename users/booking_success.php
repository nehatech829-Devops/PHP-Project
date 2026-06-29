<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}


$user_id = $_SESSION['user_id'];

$query = mysqli_query($con, "
SELECT bookings.*, slots.slot_number 
FROM bookings 
JOIN slots ON bookings.slot_id = slots.slot_id
WHERE bookings.user_id='$user_id'
ORDER BY bookings.booking_id DESC LIMIT 1
");

$row = mysqli_fetch_array($query);

if(!$row){
    echo "<script>alert('No booking found'); window.location='dashboard.php';</script>";
    exit();
}

$qrData = "BookingID: ".$row['booking_id'].
          "\nVehicle: ".$row['vehicle_no'].
          "\nSlot: ".$row['slot_number'].
          "\nEntry: ".$row['entry_time'].
          "\nStatus: Active";


$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=".urlencode($qrData);
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking Success</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#667eea,#764ba2);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.success-box{
    width:420px;
    background:white;
    border-radius:15px;
    padding:30px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.success-box h2{
    color:#28a745;
}

.success-box img{
    margin:20px 0;
    border:6px solid #eee;
    border-radius:10px;
}

.btn-dashboard{
    background:#667eea;
    color:white;
    padding:10px 20px;
    border-radius:8px;
    text-decoration:none;
}

.btn-dashboard:hover{
    background:#5a67d8;
}
</style>

</head>

<body>

<div class="success-box">

<h2>Booking Successful</h2>

<p><b>Booking ID:</b> <?php echo $row['booking_id']; ?></p>
<p><b>Vehicle:</b> <?php echo $row['vehicle_no']; ?></p>
<p><b>Slot:</b> <?php echo $row['slot_number']; ?></p>
<p><b>Entry Time:</b> <?php echo $row['entry_time'] ?? 'Not Available'; ?></p>

<img src="<?php echo $qrUrl; ?>">

<p style="font-size:13px;color:#777;">
Scan this QR at exit for billing
</p>

<a href="dashboard.php" class="btn-dashboard">Go to Dashboard</a>

</div>

</body>
</html>