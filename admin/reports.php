<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['admin_id'])){
    //header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reports</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{
    background:#f0f2f5;
    font-family:'Segoe UI', sans-serif;
}

.content{
    max-width:1100px;
    margin:50px auto;
}

.card{
    background:white;
    border:none;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.card h5{
    font-weight:600;
    color:#34495e;
}

.form-control{
    border-radius:8px;
    padding:10px 12px;
}

.btn-search{
    background:#667eea;
    color:white;
    font-weight:600;
    border-radius:8px;
    padding:10px 15px;
    transition:0.3s;
}

.btn-search:hover{
    background:#5a67d8;
    color:white;
}

.table{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
}

.table thead{
    background:#667eea;
    color:white;
    font-weight:600;
}

.table td, .table th{
    vertical-align:middle;
}

.table-hover tbody tr:hover{
    background:#f2f6ff;
}

.total-row{
    background:#f1f1f1;
    font-weight:600;
}

.back-btn{
    margin-bottom:20px;
}
</style>
</head>
<body>

<div class="content">

<!-- Back Button -->
<a href="dashboard.php" class="btn btn-outline-primary back-btn">
    <i class="fas fa-arrow-left"></i> Back
</a>

<!-- Date Selection Form -->
<div class="card p-4">
<h4 class="mb-4"><i class="fas fa-file-alt"></i> Between Dates Report</h4>
<form method="post">
<div class="row">
    <div class="col-md-4 mb-3">
        <label>From Date</label>
        <input type="date" name="fromdate" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>To Date</label>
        <input type="date" name="todate" class="form-control" required>
    </div>
    <div class="col-md-4 d-flex align-items-end mb-3">
        <button type="submit" name="search" class="btn btn-search btn-block">
            <i class="fas fa-search"></i> Search
        </button>
    </div>
</div>
</form>
</div>

<?php
if(isset($_POST['search'])){
    $from = $_POST['fromdate'];
    $to = $_POST['todate'];

    $query = mysqli_query($con, "SELECT * FROM bookings WHERE DATE(entry_time) BETWEEN '$from' AND '$to'");

    $total = 0;
?>

<div class="card p-3">
<h5>Report from <?php echo $from; ?> to <?php echo $to; ?></h5>

<table class="table table-bordered table-hover table-responsive-md mt-3">
<thead>
<tr>
<th>#</th>
<th>Vehicle No</th>
<th>Slot</th>
<th>Date & Time</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
while($row = mysqli_fetch_assoc($query)){
    $total += $row['amount'];
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo htmlspecialchars($row['vehicle_no']); ?></td>
<td><?php echo htmlspecialchars($row['slot_id']); ?></td>
<td><?php echo $row['entry_time']; ?></td>
<td>₹<?php echo $row['amount']; ?></td>
</tr>
<?php } ?>

<tr class="total-row">
<td colspan="4" class="text-right">Total Revenue</td>
<td>₹<?php echo $total; ?></td>
</tr>
</tbody>
</table>
</div>

<?php } ?>

</div>
</body>
</html>