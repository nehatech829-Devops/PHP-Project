<?php
session_start();
include('../includes/dbconnection.php');

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

$filter = "";
if(isset($_GET['type']) && $_GET['type'] != ""){
    $type = $_GET['type'];
    $filter = "WHERE slots.vehicle_type='$type'";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Parking Slots</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background:#f4f6f9;
    font-family:'Segoe UI';
}

.header{
    background:#667eea;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
}

.filter-box{
    margin-top:15px;
}

.floor-title{
    margin-top:25px;
    font-weight:600;
}

.slot-container{
    display:flex;
    flex-wrap:wrap;
}

.slot{
    width:80px;
    height:80px;
    margin:10px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-weight:bold;
    transition:0.3s;
}

.free.car{
    background:#3498db; /* Blue */
}

.free.bike{
    background:#f1c40f; /* Yellow */
    color:black;
}

.occupied{
    background:#e74c3c;
}

.free:hover{
    transform:scale(1.1);
    cursor:pointer;
}

.legend{
    margin-top:10px;
}
.legend span{
    margin-right:15px;
}
</style>
</head>
<body>
<div class="header">
    <h4>Parking Slots</h4>
    <a href="dashboard.php" style="color:white;">Back</a>
</div>
<div class="container">
<div class="filter-box">
    <form method="get">
        <select name="type" class="form-control w-25 d-inline">
            <option value="">All</option>
            <option value="Car">Car</option>
            <option value="Bike">Bike</option>
        </select>
        <button class="btn btn-primary">Filter</button>
    </form>
</div>
<div class="legend">
    <span><b style="color:#3498db;">■</b> Car (Free)</span>
    <span><b style="color:#f1c40f;">■</b> Bike (Free)</span>
    <span><b style="color:#e74c3c;">■</b> Occupied</span>
</div>
<?php
$query = mysqli_query($con, "
SELECT slots.*, floors.floor_name 
FROM slots 
JOIN floors ON slots.floor_id = floors.floor_id
$filter
ORDER BY floors.floor_id, slots.slot_number
");

$current_floor = "";

while($row = mysqli_fetch_array($query)){

    if($current_floor != $row['floor_name']){
        if($current_floor != ""){
            echo "</div>";
        }

        $current_floor = $row['floor_name'];

        echo "<h5 class='floor-title'>".$current_floor."</h5>";
        echo "<div class='slot-container'>";
    }
    $typeClass = strtolower($row['vehicle_type']);

    if($row['status'] == 'free'){

        echo "<a href='book-slot.php?slot_id=".$row['slot_id']."' style='text-decoration:none;'>
                <div class='slot free $typeClass'>".$row['slot_number']."</div>
              </a>";

    } else {

        echo "<div class='slot occupied'>".$row['slot_number']."</div>";
    }
}

echo "</div>";
?>

</div>

</body>
</html>