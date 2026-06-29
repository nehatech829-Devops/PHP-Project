<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($con, "SELECT * FROM tblusers WHERE user_id='$user_id'");
$user = mysqli_fetch_array($query);

if(isset($_POST['update'])){
    $name = $_POST['fullname'];
    $mobile = $_POST['mobile'];

    mysqli_query($con, "UPDATE tblregusers 
    SET fullname='$name', mobile='$mobile'
    WHERE user_id='$user_id'");

    echo "<script>alert('Profile Updated');</script>";
    echo "<script>window.location.href='profile.php';</script>";
}

if(isset($_POST['change_pass'])){
    $old = $_POST['oldpass'];
    $new = $_POST['newpass'];

    if(password_verify($old, $user['password'])){
        $newpass = password_hash($new, PASSWORD_DEFAULT);

        mysqli_query($con, "UPDATE tblusers 
        SET password='$newpass' WHERE user_id='$user_id'");

        echo "<script>alert('Password Changed');</script>";
    } else {
        echo "<script>alert('Old Password Incorrect');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background:#f5f6fa;
}

.header{
    background:#667eea;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
}

.header a{
    color:white;
    text-decoration:none;
}

.box{
    width:450px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<div class="header">
    <h4>User Profile</h4>
    <a href="dashboard.php">Back</a>
</div>

<div class="box">

<h5>Update Profile</h5>

<form method="post">

<input type="text" name="fullname" class="form-control mb-3"
value="<?php echo $user['fullname']; ?>" required>

<input type="text" name="mobile" class="form-control mb-3"
value="<?php echo $user['mobile']; ?>" required>

<input type="email" class="form-control mb-3"
value="<?php echo $user['email']; ?>" disabled>

<button type="submit" name="update" class="btn btn-primary btn-block">
Update Profile
</button>

</form>

<hr>

<h5>Change Password</h5>

<form method="post">

<input type="password" name="oldpass" class="form-control mb-3"
placeholder="Old Password" required>

<input type="password" name="newpass" class="form-control mb-3"
placeholder="New Password" required>

<button type="submit" name="change_pass" class="btn btn-danger btn-block">
Change Password
</button>

</form>

</div>

</body>
</html>