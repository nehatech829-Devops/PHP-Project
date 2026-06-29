<?php
session_start();
include('../includes/dbconnection.php');

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {

    $aid = $_SESSION['vpmsaid'];

    if(isset($_POST['update'])){
        $adminName = $_POST['adminName'];
        $email = $_POST['email'];

        $query = mysqli_query($con, "UPDATE admin SET adminName='$adminName', email='$email' WHERE id='$aid'");
        if($query){
            $msg = "Profile updated successfully!";
        } else {
            $err = "Something went wrong. Please try again.";
        }
    }
    $query = mysqli_query($con, "SELECT * FROM admin WHERE id='$aid'");
    $row = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

    <style>
        body{ background:#f5f6fa; }
        .profile-box{ max-width:600px; margin:auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);}
        .profile-box h3{ margin-bottom:20px; }
        .btn-custom{ background:#2c3e50; color:white; }
    </style>
</head>
<body>

<?php include_once('slidebar.php'); ?>
<?php include_once('header.php'); ?>

<div id="right-panel">
    <div class="content mt-4">
        <div class="profile-box">
            <h3>Admin Profile</h3>

            <?php if(isset($msg)){ ?>
                <div class="alert alert-success"><?php echo $msg; ?></div>
            <?php } ?>
            <?php if(isset($err)){ ?>
                <div class="alert alert-danger"><?php echo $err; ?></div>
            <?php } ?>

            <form method="POST">
                <div class="form-group">
                    <label for="adminName">Admin Name</label>
                    <input type="text" name="adminName" class="form-control" id="adminName" value="<?php echo $row['adminName']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?php echo $row['email']; ?>" required>
                </div>

                <button type="submit" name="update" class="btn btn-custom">Update Profile</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php } ?>