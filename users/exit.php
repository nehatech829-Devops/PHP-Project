<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

if(isset($_GET['booking_id'])){

    $id = $_GET['booking_id'];

    
    $query = mysqli_query($con, "
    SELECT bookings.*, slots.vehicle_type 
    FROM bookings 
    JOIN slots ON bookings.slot_id = slots.slot_id
    WHERE bookings.booking_id='$id'
    ");

    $row = mysqli_fetch_array($query);

    if(!$row){
        die("Invalid Booking");
    }

    
    $entry = strtotime($row['entry_time']);
    $exit = strtotime(date('Y-m-d H:i:s'));

    if(!$entry){
        $entry = $exit; // avoid huge values
    }

$seconds = $exit - $entry;
$hours = ceil($seconds / 3600);

if($hours <= 0){
    $hours = 1;
}

   
    if($row['vehicle_type'] == 'Car'){
        $rate = 20;
    } else if($row['vehicle_type'] == 'Bike'){
        $rate = 10;
    } else {
        $rate = 15; // default
    }

    $amount = $hours * $rate;

    
    mysqli_query($con, "
    UPDATE bookings 
    SET exit_time = NOW(), amount='$amount', status='out' 
    WHERE booking_id='$id'
    ");

    mysqli_query($con, "
    INSERT INTO bills 
    (booking_id, user_id, vehicle_no, entry_time, exit_time, total_hours, rate_per_hour, amount, created_at)
    VALUES (
    '$id',
    '".$row['user_id']."',
    '".$row['vehicle_no']."',
    '".$row['entry_time']."',
    NOW(),
    '$hours',
    '$rate',
    '$amount',
    NOW()
    )
    ");
   
    mysqli_query($con, "
    UPDATE slots 
    SET status='free' 
    WHERE slot_id='".$row['slot_id']."'
    ");

} else {
    header("location:payment-success.php?id=".$id);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Parking Bill</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family:'Segoe UI', sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.bill-box{
    width:420px;
    background:white;
    padding:30px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.bill-box h2{
    color:#28a745;
    margin-bottom:20px;
}

.bill-box p{
    font-size:16px;
    margin:6px 0;
}

.amount{
    font-size:22px;
    font-weight:bold;
    color:#e74c3c;
    margin-top:15px;
}

.btn-back{
    margin-top:15px;
    background:#667eea;
    color:white;
    padding:10px 20px;
    border-radius:8px;
    text-decoration:none;
}

.btn-back:hover{
    background:#5a67d8;
    color:white;
}
</style>

</head>

<body>

<div class="bill-box">

<h2>Parking Bill</h2>

<p><b>Vehicle:</b> <?php echo $row['vehicle_no']; ?></p>
<p><b>Type:</b> <?php echo $row['vehicle_type']; ?></p>
<p><b>Entry Time:</b> <?php echo $row['entry_time']; ?></p>
<p><b>Exit Time:</b> <?php echo date('Y-m-d H:i:s'); ?></p>
<p><b>Total Hours:</b> <?php echo $hours; ?></p>
<p><b>Rate:</b> ₹<?php echo $rate; ?> / hour</p>

<div class="amount">
Total Amount: ₹<?php echo $amount; ?>
</div>
</br>

<a href="dashboard.php" class="btn-back">Go to Dashboard</a>

</div>

</body>
</html>