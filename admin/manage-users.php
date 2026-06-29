<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['admin_id'])){
    //header('location:index.php');
    exit();
}

if(isset($_GET['del'])){
    $id = $_GET['del'];

    mysqli_query($con, "DELETE FROM tblusers WHERE user_id='$id'");

    echo "<script>alert('User Deleted Successfully');</script>";
    echo "<script>window.location='manage-users.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Users</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{
    background:#f0f2f5;
    font-family:'Segoe UI', sans-serif;
}

.content{
    max-width:1000px;
    margin:50px auto;
}

h4.page-title{
    font-weight:700;
    color:#34495e;
    margin-bottom:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
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

.user-icon{
    font-size:18px;
    margin-right:8px;
    color:#555;
}

.btn-delete{
    background:#ff6b81;
    color:white;
    font-weight:500;
    border-radius:6px;
    padding:5px 12px;
    transition:0.3s;
}

.btn-delete:hover{
    background:#e84118;
    color:white;
    text-decoration:none;
}

</style>
</head>
<body>

<div class="content">

<h4 class="page-title">
    <span><i class="fas fa-users"></i> Manage Users</span>
    <a href="dashboard.php" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</h4>

<table class="table table-bordered table-hover table-responsive-md">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$query = mysqli_query($con, "SELECT * FROM tblusers ORDER BY user_id DESC");
$i = 1;

while($row = mysqli_fetch_assoc($query)){
?>
<tr>
<td><?php echo $i++; ?></td>
<td><i class="fas fa-user user-icon"></i> <?php echo htmlspecialchars($row['fullname']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td><?php echo htmlspecialchars($row['mobile']); ?></td>
<td>
<a href="manage-users.php?del=<?php echo $row['user_id']; ?>" 
   class="btn btn-sm btn-delete"
   onclick="return confirm('Delete this user?')">
   Delete
</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</body>
</html>