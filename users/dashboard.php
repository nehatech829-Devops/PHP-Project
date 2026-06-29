<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body{
    margin:0;
    background:#f5f6fa;
    font-family: Arial;
}

/* HEADER */
.header{
    background:#667eea;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header h4{
    margin:0;
}

/* CONTAINER */
.container-box{
    padding:30px;
}

/* CARD */
.card-box{
    background:white;
    padding:25px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card-box:hover{
    transform:translateY(-5px);
}

.card-box i{
    font-size:30px;
    margin-bottom:10px;
}

.btn-custom{
    margin-top:10px;
    border-radius:20px;
}

/* GRID */
.row{
    margin-top:20px;
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h4>Parking System</h4>
    <div>
        Welcome, <?php echo $_SESSION['fullname']; ?> |
        <a href="logout.php" style="color:white;">Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="container-box">

<h3>Dashboard</h3>

<div class="row">

<!-- VIEW SLOTS -->
<div class="col-md-4">
<div class="card-box">
<i class="fa fa-car text-primary"></i>
<h5>View Slots</h5>
<a href="slots.php" class="btn btn-primary btn-sm btn-custom">Open</a>
</div>
</div>

<!-- BOOK SLOT -->
<div class="col-md-4">
<div class="card-box">
<i class="fa fa-ticket text-success"></i>
<h5>Book Slot</h5>
<a href="book-slot.php" class="btn btn-success btn-sm btn-custom">Book Now</a>
</div>
</div>

<!-- MY BOOKINGS -->
<div class="col-md-4">
<div class="card-box">
<i class="fa fa-list text-info"></i>
<h5>My Bookings</h5>
<a href="my-bookings.php" class="btn btn-info btn-sm btn-custom">View</a>
</div>
</div>

</div>

<div class="row">

<!-- BILL -->
<div class="col-md-4">
<div class="card-box">
<i class="fa fa-money text-warning"></i>
<h5>My Bills</h5>
<a href="bill.php" class="btn btn-warning btn-sm btn-custom">Check</a>
</div>
</div>

<!-- PROFILE -->
<div class="col-md-4">
<div class="card-box">
<i class="fa fa-user text-dark"></i>
<h5>Profile</h5>
<a href="profile.php" class="btn btn-dark btn-sm btn-custom">Open</a>
</div>
</div>

</div>

</div>

</body>
</html>