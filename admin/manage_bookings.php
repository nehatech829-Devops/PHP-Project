<?php   
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['admin_id'])){
    exit();
}

if(isset($_GET['exit'])){
    $id = $_GET['exit'];
    $data = mysqli_fetch_array(mysqli_query($con, "
        SELECT bookings.*, slots.vehicle_type 
        FROM bookings 
        JOIN slots ON bookings.slot_id = slots.slot_id
        WHERE bookings.id='$id'
    "));

    $slot = $data['slot_id'];
    $entry = strtotime($data['entry_time']);
    $exit = strtotime(date('Y-m-d H:i:s'));

    if(!$entry){
        $entry = $exit;
    }

    $seconds = $exit - $entry;
    $hours = ceil($seconds / 3600);

    if($hours <= 0){
        $hours = 1;
    }

    if($data['vehicle_type'] == 'Car'){
        $rate = 20;
    } else {
        $rate = 10;
    }

    $amount = $hours * $rate;

    mysqli_query($con, "
        UPDATE bookings 
        SET status='out', exit_time=NOW(), amount='$amount' 
        WHERE id='$id'
    ");

    mysqli_query($con, "
        UPDATE slots SET status='free' WHERE slot_id='$slot'
    ");

    echo "<script>alert('Vehicle Exited & Bill Generated');</script>";
    echo "<script>window.location='manage-bookings.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Bookings</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{
    background:#f0f2f5;
    font-family:'Segoe UI';
}
.content{
    max-width:1000px;
    margin:50px auto;
}
.table{
    background:white;
    border-radius:12px;
    overflow:hidden;
}
.status-in{
    background:#2ecc71;
    color:white;
    padding:5px 12px;
    border-radius:12px;
}
.status-out{
    background:#e74c3c;
    color:white;
    padding:5px 12px;
    border-radius:12px;
}
.btn-outline-primary{
    border-radius:8px;
    font-weight:500;
}
</style>
</head>

<body>

<div class="content">

<div class="d-flex justify-content-between align-items-center mb-3">
    
    <h4 style="font-weight:700; color:#34495e;">
        Manage Bookings
    </h4>

    <a href="dashboard.php" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Back
    </a>

</div>

<table class="table table-bordered mt-3">
<thead>
<tr>
<th>#</th>
<th>Vehicle No</th>
<th>Slot</th>
<th>Date & Time</th>
<th>Amount</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$query = mysqli_query($con, "
    SELECT bookings.*, slots.slot_number 
    FROM bookings 
    JOIN slots ON bookings.slot_id = slots.slot_id
    ORDER BY bookings.booking_id DESC
");

$i = 1;

while($row = mysqli_fetch_assoc($query)){
?>

<tr>
<td><?php echo $i++; ?></td>

<td><b><?php echo $row['vehicle_no']; ?></b></td>

<td><?php echo $row['slot_number']; ?></td>

<td>
<?php echo date('d-m-Y H:i', strtotime($row['entry_time'])); ?>
</td>

<td>
<?php 
if($row['status'] == 'out'){
    echo "₹".$row['amount'];
} else {
    echo "<span class='text-warning'>Pending</span>";
}
?>
</td>

<td>
<?php if($row['status'] == 'in'){ ?>
<span class="status-in">IN</span>
<?php } else { ?>
<span class="status-out">OUT</span>
<?php } ?>
</td>

<td>
<?php if($row['status'] == 'in'){ ?>
<a href="?exit=<?php echo $row['booking_id']; ?>" 
class="btn btn-sm btn-danger"
onclick="return confirm('Exit vehicle?')">
Exit
</a>
<?php } else { ?>
<span class="text-muted">Completed</span>
<?php } ?>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>

</body>
</html>