<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['admin_id'])){
    //header('location:index.php');
    exit();
}

// DELETE SLOT
if(isset($_GET['del'])){
    $slot_id = $_GET['del'];
    mysqli_query($con, "DELETE FROM slots WHERE slot_id='$slot_id'");
    echo "<script>alert('Slot Deleted');</script>";
    echo "<script>window.location='manage-slots.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Manage Slots</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{
    background:#f0f2f5;
    font-family:'Segoe UI', sans-serif;
}

.page-title{
    font-weight:700;
    color:#34495e;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}

.table{
    background:white;
    border-radius:10px;
    overflow:hidden;
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

.badge-free{
    background:#2ecc71;
    color:white;
    padding:5px 12px;
    border-radius:12px;
    font-weight:500;
}

.badge-occupied{
    background:#e74c3c;
    color:white;
    padding:5px 12px;
    border-radius:12px;
    font-weight:500;
}

.btn-delete{
    background:#e74c3c;
    color:white;
    border:none;
    border-radius:5px;
    padding:5px 12px;
    transition:0.3s;
}

.btn-delete:hover{
    background:#c0392b;
    text-decoration:none;
    color:white;
}

.content{
    margin:50px auto;
    max-width:900px;
    padding:15px;
}
</style>
</head>
<body>

<div class="content">

<div class="card p-4">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title"><i class="fas fa-parking"></i> Manage Slots</h4>
    <a href="dashboard.php" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<table class="table table-hover table-responsive-md">
<thead>
<tr>
<th>#</th>
<th>Slot Number</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php
$query = mysqli_query($con, "SELECT * FROM slots");
$i = 1;

while($row = mysqli_fetch_assoc($query)){
?>
<tr>
<td><?php echo $i++; ?></td>
<td><b><?php echo htmlspecialchars($row['slot_number']); ?></b></td>
<td>
<?php if($row['status'] == 'free'){ ?>
<span class="badge-free">Free</span>
<?php } else { ?>
<span class="badge-occupied">Occupied</span>
<?php } ?>
</td>
<td>
<a href="?del=<?php echo $row['slot_id']; ?>" 
   class="btn btn-sm btn-delete"
   onclick="return confirm('Are you sure you want to delete this slot?')">
   <i class="fas fa-trash"></i> Delete
</a>
</td>
</tr>
<?php } ?>

</tbody>
</table>

</div>
</div>

</body>
</html>