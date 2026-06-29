<?php
include('../includes/dbconnection.php');

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $q = mysqli_query($con,"SELECT * FROM bookings WHERE id='$id'");
    $row = mysqli_fetch_array($q);

    $in = strtotime($row['booking_time']);
    $out = time();

    $hours = ceil(($out-$in)/3600);
    $amount = $hours * 20;

    mysqli_query($con,"UPDATE bookings 
    SET exit_time=NOW(), amount='$amount', status='completed'
    WHERE id='$id'");

    mysqli_query($con,"UPDATE slots SET status='free' WHERE id='".$row['slot_id']."'");
}