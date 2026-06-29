<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($con, "
SELECT * FROM bookings 
WHERE user_id='$user_id' AND amount IS NOT NULL 
ORDER BY booking_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bills</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family:'Segoe UI', sans-serif;
}

.container{
    margin-top:50px;
}

/* CARD */
.card-box{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* TABLE */
.table{
    margin-bottom:0;
}

.table th{
    background:#f8f9fa;
    border:none;
    font-weight:600;
}

.table td{
    vertical-align:middle;
}

/* STATUS */
.status-paid{
    color:#28a745;
    font-weight:600;
}

.status-active{
    color:#f39c12;
    font-weight:600;
}

/* HOVER */
.table tr:hover{
    background:#f1f3f6;
    transition:0.2s;
}

/* BUTTON */
.btn{
    border-radius:20px;
}
</style>
</head>

<body>

<div class="container">

<a href="dashboard.php" class="btn btn-light mb-3">
    ← Back
</a>

<div class="card-box">

<h3 class="mb-4">My Bills</h3>

<table class="table text-center">
<tr>
<th>Booking ID</th>
<th>Vehicle</th>
<th>Amount</th>
<th>Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($query)){ ?>
<tr>
<td><?php echo $row['booking_id']; ?></td>
<td><?php echo $row['vehicle_no']; ?></td>
<td><b>₹<?php echo $row['amount']; ?></b></td>

<td>
<?php if($row['status']=='out'){ ?>
    <span class="status-paid">✔ Paid</span>
<?php } else { ?>
    <span class="status-active">● Pending</span>
<?php } ?>
</td>

</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>