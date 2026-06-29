<?php
include('../includes/dbconnection.php');

if(isset($_POST['submit'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($con, "SELECT * FROM tblusers WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already exists');</script>";
    } else {

        $query = mysqli_query($con, "INSERT INTO `tblusers`(`fullname`, `email`, `password`, `mobile`) 
        VALUES ('$fullname','$email','$password','$mobile')");

        if($query){
            echo "<script>alert('Registration Successful');</script>";
            echo "<script>window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Register</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background: linear-gradient(135deg, #667eea, #764ba2);
    height:100vh;
}

.box{
    width:400px;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
}

h3{
    text-align:center;
    margin-bottom:20px;
}

.btn-primary{
    background:#667eea;
    border:none;
}

.btn-primary:hover{
    background:#5a67d8;
}
</style>

</head>

<body>

<div class="box">

<h3>Create Account</h3>

<form method="post">

<input type="text" name="fullname" class="form-control mb-3" placeholder="Full Name" required>

<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

<input type="text" name="mobile" class="form-control mb-3" placeholder="Mobile Number" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" name="submit" class="btn btn-primary btn-block">
Register
</button>

</form>

<p class="text-center mt-3">
Already have an account? <a href="login.php">Login</a>
</p>

</div>

</body>
</html>