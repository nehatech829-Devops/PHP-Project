<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['admin_id'])){
    header('location:index.php');
    exit();
}

if(!isset($_GET['booking_id'])){
    die("Invalid QR");
}

$booking_id = mysqli_real_escape_string($con, $_GET['booking_id']);
$query = mysqli_query($con, "
SELECT bookings.*, slots.slot_number 
FROM bookings 
JOIN slots ON bookings.slot_id = slots.slot_id
WHERE bookings.booking_id='$booking_id'
");
if(!$query){
    die("Query Error: ".mysqli_error($con));
}
$row = mysqli_fetch_assoc($query);
if(!$row){
    die("Booking not found");
}
$message = "";
$amount = 0;

if(empty($row['entry_time'])){

    mysqli_query($con, "
    UPDATE bookings 
    SET entry_time = NOW(), status='in' 
    WHERE booking_id='$booking_id'
    ");

    $message = "Entry Recorded Successfully";
}
else if(empty($row['exit_time'])){

    $entry_time = strtotime($row['entry_time']);
    $exit_time  = time();

    $hours = ceil(($exit_time - $entry_time) / 3600);
    if($hours < 1) $hours = 1;

    $rate = 20;
    $amount = $hours * $rate;

    mysqli_query($con, "
    UPDATE bookings 
    SET exit_time = NOW(), status='out', amount='$amount' 
    WHERE booking_id='$booking_id'
    ");

    mysqli_query($con, "
    UPDATE slots 
    SET status='free' 
    WHERE slot_id='".$row['slot_id']."'
    ");

    $message = "Exit Recorded & Bill Generated";
}

else{
    $message = "This booking is already completed";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Scan Result</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family:'Segoe UI', sans-serif;
    color:white;
    text-align:center;
}

.box{
    max-width:420px;
    margin:80px auto;
    background:white;
    color:black;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.success{
    font-size:18px;
    font-weight:600;
    margin-bottom:15px;
}

.info{
    text-align:left;
    margin-top:15px;
}
</style>

</head>

<body>

<div class="box">

<div class="success"><?php echo $message; ?></div>

<div class="info">
<p><b>Booking ID:</b> <?php echo $booking_id; ?></p>
<p><b>Slot:</b> <?php echo $row['slot_number']; ?></p>
<p><b>Vehicle:</b> <?php echo $row['vehicle_no']; ?></p>
<p><b>Entry Time:</b> <?php echo $row['entry_time'] ?? '---'; ?></p>
<p><b>Exit Time:</b> <?php echo $row['exit_time'] ?? '---'; ?></p>

<?php if($amount > 0){ ?>
<p><b>Total Amount:</b> ₹<?php echo $amount; ?></p>
<?php } ?>

</div>

<a href="scan.php" class="btn btn-primary btn-block mt-3">Scan Again</a>
<a href="dashboard.php" class="btn btn-secondary btn-block">Back to Dashboard</a>

</div>

</body>
</html>