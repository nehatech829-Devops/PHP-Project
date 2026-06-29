<?php
session_start();
include('../includes/dbconnection.php');

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($con, "SELECT * FROM tbladmin WHERE email='$email'");
    $admin = mysqli_fetch_array($query);

    if($admin && $password == $admin['password']){
        $_SESSION['admin_id'] = $admin['admin_id'];
        echo "<script>window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Invalid Login Details');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body{
    margin:0;
    height:100vh;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#000000,#333333); /* black gradient */
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-card{
    width:380px;
    padding:40px 30px;
    border-radius:20px;
    background: rgba(255,255,255,0.95); /* mostly white */
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    text-align:center;
    color:black;
}

.login-card h3{
    margin-bottom:25px;
    color:#000;
}
.input-box{
    position:relative;
    margin-bottom:20px;
}
.input-box i{
    position:absolute;
    top:12px;
    left:10px;
    color:black;
    opacity:0.7;
}
.input-box input{
    width:100%;
    padding:10px 10px 10px 35px;
    border:1px solid #ccc;
    border-radius:10px;
    outline:none;
    background: #fff;
    color:black;
}
.btn-login{
    background:#000;
    color:white;
    font-weight:bold;
    border-radius:25px;
    transition:0.3s;
}

.btn-login:hover{
    background:#333;
    color:white;
}
.links{
    margin-top:15px;
}

.links a{
    color:black;
    opacity:0.7;
    text-decoration:none;
    display:block;
    margin-top:5px;
    font-size:14px;
}

.links a:hover{
    opacity:1;
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="login-card">

<h3>Admin Login</h3>

<form method="post" >

<div class="input-box">
    <i class="fa fa-envelope"></i>
    <input type="email" name="email" placeholder="Enter Email" required>
</div>

<div class="input-box">
    <i class="fa fa-lock"></i>
    <input type="password" name="password" placeholder="Enter Password" required>
</div>

<button type="submit" name="login" class="btn btn-login btn-block">
Login
</button>

</form>

<div class="links">
    <a href="../home.php">⬅ Back to Home</a>
</div>

</div>

</body>
</html>