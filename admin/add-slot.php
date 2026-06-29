<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['admin_id'])){
    //header('location:index.php');
    exit();
}

if(isset($_POST['submit'])){
    $slot = trim($_POST['slot_number']);
    $floor_id = $_POST['floor_id'];
    $vehicle_type = $_POST['vehicle_type'];

    $check = mysqli_query($con, "SELECT * FROM slots WHERE slot_number='$slot'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Slot already exists');</script>";
    } else {
        mysqli_query($con, "INSERT INTO slots(slot_number, floor_id, vehicle_type, status) 
        VALUES('$slot','$floor_id','$vehicle_type','free')");

        echo "<script>alert('Slot Added Successfully');</script>";
        echo "<script>window.location='add-slot.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Slot</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family: 'Segoe UI', sans-serif;
}

.content{
    max-width: 450px;
    margin: 80px auto;
}

.card-form{
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    animation:fadeIn 0.5s ease;
}

.card-form h4{
    font-weight:700;
    text-align:center;
    margin-bottom:25px;
}

.form-control{
    border-radius:8px;
    padding:10px;
}

.btn-custom{
    background:#667eea;
    color:white;
    border:none;
    padding:10px;
    border-radius:8px;
    font-weight:600;
    transition:0.3s;
}

.btn-custom:hover{
    background:#5a67d8;
}

.back-btn{
    margin-bottom:15px;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}
</style>

</head>

<body>

<div class="content">
<a href="dashboard.php" class="btn btn-light back-btn">
    <i class="fas fa-arrow-left"></i> Back
</a>
<div class="card-form">
<h4><i class="fas fa-plus-circle"></i>Add New Slot</h4>
<form method="post">

<div class="form-group">
    <label>Select Floor</label>
    <select name="floor_id" class="form-control" required>
        <option value="">Select Floor</option>

        <?php
        $fquery = mysqli_query($con, "SELECT * FROM floors");
        while($f = mysqli_fetch_array($fquery)){
        ?>
            <option value="<?php echo $f['floor_id']; ?>">
                <?php echo $f['floor_name']; ?>
            </option>
        <?php } ?>
    </select>
</div>

<div class="form-group">
    <label>Vehicle Type</label>
    <select name="vehicle_type" class="form-control" required>
        <option value="">Select Type</option>
        <option value="Car">Four-Wheeler</option>
        <option value="Bike">Two-Wheeler</option>
    </select>
</div>
<div class="form-group">
    <label>Slot Number</label>
    <input type="text" name="slot_number" class="form-control" 
    placeholder="Enter Slot Number (e.g. A1, B2)" required>
</div>

<button type="submit" name="submit" class="btn btn-custom btn-block">
    <i class="fas fa-plus-circle"></i> Add Slot
</button>
</form>
</div>
</div>
</body>
</html>