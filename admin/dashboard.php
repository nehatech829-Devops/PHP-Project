<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['admin_id'])){
    //header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Dashboard</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

body{
    margin:0;
    font-family:'Segoe UI';
    background:#f4f6f9;
}

/* SIDEBAR */
.sidebar{
    width:240px;
    height:100vh;
    position:fixed;
    background:linear-gradient(180deg,#667eea,#764ba2);
    color:white;
    padding-top:20px;
    transition:0.3s;
}

.sidebar.collapsed{
    width:70px;
}

.sidebar h4{
    text-align:center;
    margin-bottom:20px;
}

.sidebar a{
    display:flex;
    align-items:center;
    padding:12px 20px;
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a i{
    margin-right:10px;
}

.sidebar.collapsed a span{
    display:none;
}

.sidebar a.active{
    background:rgba(255,255,255,0.3);
    border-left:4px solid #fff;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.2);
}

/* HEADER */
.header{
    margin-left:240px;
    height:60px;
    background:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 20px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
    transition:0.3s;
}

/* CONTENT */
.content{
    margin-left:240px;
    padding:20px;
    margin-top:10px;
    transition:0.3s;
}

.sidebar.collapsed ~ .header,
.sidebar.collapsed ~ .content{
    margin-left:70px;
}

/* CARDS */
.card-box{
    border-radius:12px;
    padding:20px;
    color:white;
    transition:0.3s;
}

.card-box:hover{
    transform:translateY(-5px);
}

.bg1{ background:linear-gradient(45deg,#36d1dc,#5b86e5); }
.bg2{ background:linear-gradient(45deg,#ff6a00,#ee0979); }
.bg3{ background:linear-gradient(45deg,#11998e,#38ef7d); }
.bg4{ background:linear-gradient(45deg,#fc4a1a,#f7b733); }

</style>
</head>

<body>

<?php include('sidebar.php'); ?>
<?php include('header.php'); ?>
<div class="content">
<h4 class="mb-4">Dashboard</h4>
<div class="row">
<?php
$q1=mysqli_query($con,"SELECT * FROM slots WHERE status='free'");
$q2=mysqli_query($con,"SELECT * FROM slots WHERE status='occupied'");
$q3=mysqli_query($con,"SELECT * FROM bookings");
$q4=mysqli_query($con,"SELECT * FROM tblusers");
?>
<div class="col-md-3">
<div class="card-box bg1">
<i class="fas fa-parking"></i>
<h4><?php echo mysqli_num_rows($q1); ?></h4>
<p>Free Slots</p>
</div>
</div>

<div class="col-md-3">
<div class="card-box bg2">
<i class="fas fa-car"></i>
<h4><?php echo mysqli_num_rows($q2); ?></h4>
<p>Occupied Slots</p>
</div>
</div>

<div class="col-md-3">
<div class="card-box bg3">
<i class="fas fa-ticket-alt"></i>
<h4><?php echo mysqli_num_rows($q3); ?></h4>
<p>Total Bookings</p>
</div>
</div>

<div class="col-md-3">
<div class="card-box bg4">
<i class="fas fa-users"></i>
<h4><?php echo mysqli_num_rows($q4); ?></h4>
<p>Total Users</p>
</div>
</div>

</div>

</div>

<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
}

let links = document.querySelectorAll(".nav-link");
let current = window.location.href;

links.forEach(link => {
    if(current.includes(link.getAttribute("href"))){
        link.classList.add("active");
    }
});

</script>

</body>
</html>