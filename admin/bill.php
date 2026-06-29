<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if (strlen($_SESSION['admin_id'])==0) {
  header('location:logout.php');
} else {

if(isset($_POST['generate'])){

    $bookingid = $_POST['bookingid'];

    $query = mysqli_query($con, "
        SELECT bookings.*, slots.slot_number 
        FROM bookings 
        JOIN slots ON bookings.slot_id = slots.id
        WHERE bookings.booking_id='$bookingid'
    ");

    $row = mysqli_fetch_array($query);

    $intime = strtotime($row['booking_time']);
    $outtime = time();

    $hours = ceil(($outtime - $intime) / 3600);

    $rate = 20; // ₹20 per hour
    $amount = $hours * $rate;

    mysqli_query($con, "
        UPDATE bookings 
        SET exit_time=NOW(), amount='$amount', status='completed' 
        WHERE id='$bookingid'
    ");
    mysqli_query($con, "
        UPDATE slots 
        SET status='free' 
        WHERE id='".$row['slot_id']."'
    ");

}
?>
<!DOCTYPE html>
<html>
<head>
<title>Billing</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background:#f5f6fa;
    font-family: Arial;
}
#left-panel{
    width:230px;
    height:100vh;
    position:fixed;
    background:#2c3e50;
}
#header{
    position:fixed;
    left:230px;
    top:0;
    width:calc(100% - 230px);
    height:60px;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:flex-end;
    padding:0 20px;
}
#right-panel{
    margin-left:230px;
    margin-top:70px;
    padding:20px;
}
.card{
    padding:20px;
    border-radius:10px;
}
</style>
</head>
<body>
<?php include_once('sidebar.php');?>
<?php include_once('header.php');?>
<div id="right-panel">
<h3 class="mb-4">Generate Bill</h3>
<div class="card">
<form method="post">
<div class="form-group">
<label>Select Vehicle</label>
<select name="bookingid" class="form-control" required>
<option value="">Choose Vehicle</option>

<?php
$q = mysqli_query($con, "SELECT * FROM bookings WHERE status='active'");
while($r = mysqli_fetch_array($q)){
?>
<option value="<?php echo $r['id']; ?>">
    <?php echo $r['vehicle_no']; ?>
</option>
<?php } ?>

</select>
</div>

<button type="submit" name="generate" class="btn btn-primary">
Generate Bill
</button>

</form>

</div>

<?php if(isset($amount)){ ?>

<div class="card mt-4">

<h5>Bill Details</h5>

<p><strong>Vehicle:</strong> <?php echo $row['vehicle_no']; ?></p>
<p><strong>Slot:</strong> <?php echo $row['slot_number']; ?></p>
<p><strong>Entry Time:</strong> <?php echo $row['booking_time']; ?></p>
<p><strong>Exit Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
<p><strong>Total Hours:</strong> <?php echo $hours; ?></p>

<h4>Total Amount: ₹<?php echo $amount; ?></h4>

</div>

<?php } ?>

</div>

</body>
</html>

<?php } ?>