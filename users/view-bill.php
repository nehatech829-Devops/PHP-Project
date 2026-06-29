<?php
include('../includes/dbconnection.php');

$id = $_GET['id'];

$query = mysqli_query($con, "
SELECT bookings.*, slots.slot_number 
FROM bookings 
JOIN slots ON bookings.slot_id = slots.slot_id
WHERE bookings.booking_id='$id'
");

$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Parking Receipt</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family: 'Segoe UI', sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.receipt-card{
    width:420px;
    background:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.receipt-title{
    text-align:center;
    font-weight:bold;
    color:#28a745;
    margin-bottom:20px;
}

.info p{
    margin:6px 0;
    font-size:15px;
}

.label{
    font-weight:600;
}

.amount-box{
    margin-top:15px;
    padding:12px;
    background:#f8f9fa;
    border-radius:8px;
    text-align:center;
    font-size:20px;
    font-weight:bold;
    color:#e74c3c;
}

.btn-custom{
    width:100%;
    margin-top:10px;
    border-radius:8px;
}

</style>
</head>

<body>

<div class="receipt-card">

<h3 class="receipt-title">Parking Receipt</h3>

<div class="info">
<p><span class="label">Booking ID:</span> <?php echo $row['booking_id']; ?></p>
<p><span class="label">Vehicle:</span> <?php echo $row['vehicle_no']; ?></p>
<p><span class="label">Slot Number:</span> <?php echo $row['slot_number']; ?></p>
<p><span class="label">Entry Time:</span> <?php echo $row['entry_time']; ?></p>
<p><span class="label">Exit Time:</span> <?php echo $row['exit_time']; ?></p>
</div>

<div class="amount-box">
Total Amount: ₹<?php echo $row['amount']; ?>
</div>

<a href="download-bill.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-success btn-custom">
Download PDF
</a>

<a href="dashboard.php" class="btn btn-primary btn-custom">
⬅ Back to Dashboard
</a>

</div>

</body>
</html>