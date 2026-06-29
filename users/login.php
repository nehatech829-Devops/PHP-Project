<?php
session_start();
include('../includes/dbconnection.php');

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($con, "SELECT * FROM tblusers WHERE email='$email'");
    $user = mysqli_fetch_array($query);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['fullname'] = $user['fullname'];

        header('location:dashboard.php');
    } else {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Login</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body{
    margin:0;
    height:100vh;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#0f2027,#2c5364);
    display:flex;
    justify-content:center;
    align-items:center;
}

/* CARD */
.login-card{
    width:350px;
    padding:30px;
    border-radius:15px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    box-shadow:0 8px 30px rgba(0,0,0,0.4);
    text-align:center;
    color:white;
}


.login-card h3{
    margin-bottom:20px;
}


.input-box{
    position:relative;
    margin-bottom:15px;
}

.input-box i{
    position:absolute;
    top:12px;
    left:10px;
    color:#2c5364;
}

.input-box input{
    width:100%;
    padding:10px 10px 10px 35px;
    border:none;
    border-radius:8px;
    outline:none;
}


.btn-login{
    background:#00c9a7;
    color:white;
    font-weight:bold;
    border-radius:25px;
    transition:0.3s;
}

.btn-login:hover{
    background:#00a88a;
}


.links{
    margin-top:15px;
}

.links a{
    color:#d1f7ff;
    text-decoration:none;
    display:block;
    margin-top:5px;
    font-size:14px;
}

.links a:hover{
    text-decoration:underline;
}

</style>

</head>

<body>

<div class="login-card">

<h3>User Login</h3>

<form method="post">

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
    <a href="register.php">New User? Register</a>
    <a href="../home.php">⬅ Back to Home</a>
</div>

</div>

</body>
</html>