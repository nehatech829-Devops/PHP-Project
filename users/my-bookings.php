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
ORDER BY booking_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family:'Segoe UI', sans-serif;
}

.container{
    margin-top:50px;
}

.card-box{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

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

.btn{
    border-radius:20px;
    padding:5px 12px;
    font-size:14px;
}

.status-active{
    color:#f39c12;
    font-weight:600;
}

.status-complete{
    color:#28a745;
    font-weight:600;
}

.table tr:hover{
    background:#f1f3f6;
    transition:0.2s;
}
</style>
</head>

<body>

<div class="container">

<a href="dashboard.php" class="btn btn-light mb-3">
    ← Back
</a>

<div class="card-box">

<h3 class="mb-4">My Bookings</h3>

<table class="table text-center">
<tr>
<th>ID</th>
<th>Slot</th>
<th>Vehicle</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($query)){ ?>
<tr>
    <td><?php echo $row['booking_id']; ?></td>
    <td><?php echo $row['slot_number']; ?></td>
    <td><?php echo $row['vehicle_no']; ?></td>
    <td>
        <?php if($row['status']=='out'){ ?>
            <span class="status-complete">✔ Completed</span>
        <?php } else { ?>
            <span class="status-active">● Active</span>
        <?php } ?>
    </td>

    <td>

        <?php if($row['status'] != 'out'){ ?>

            <a href="exit.php?booking_id=<?php echo $row['booking_id']; ?>" 
            class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Exit
            </a>

        <?php } else { ?>

            <a href="view-bill.php?id=<?php echo $row['booking_id']; ?>" 
            class="btn btn-success btn-sm">
            <i class="fas fa-eye"></i> Bill
            </a>

        <?php } ?>

    </td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>