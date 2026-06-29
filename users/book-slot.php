<?php
session_start();
include('../includes/dbconnection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

if(isset($_GET['slot_id'])){
    $slot_id = $_GET['slot_id'];

    $check = mysqli_query($con, "SELECT * FROM slots WHERE slot_id='$slot_id' AND status='free'");
    
    if(!$check){
        die("Slot Query Error: ".mysqli_error($con));
    }

    $slot = mysqli_fetch_array($check);

    if(!$slot){
        echo "<script>alert('Slot not available'); window.location='slots.php';</script>";
        exit();
    }

} else {
    header('location:slots.php');
    exit();
}


if(isset($_POST['submit'])){

    $vehicle = mysqli_real_escape_string($con, $_POST['vehicle']);
    $user_id = $_SESSION['user_id'];

    
    $userQuery = mysqli_query($con, "SELECT email FROM tblusers WHERE user_id='$user_id'");
    $userData = mysqli_fetch_assoc($userQuery);
    $user_email = $userData['email'];

    $query = mysqli_query($con, "
    INSERT INTO bookings (user_id, slot_id, vehicle_no, status)
    VALUES ('$user_id', '$slot_id', '$vehicle', 'in')
    ");

    if($query){

        $booking_id = mysqli_insert_id($con);

        mysqli_query($con, "UPDATE slots SET status='occupied' WHERE slot_id='$slot_id'");

        
        include('../includes/phpqrcode/qrlib.php');

        $qrData = $booking_id;

        $qrFolder = "../qrcodes/";
        if (!file_exists($qrFolder)) {
            mkdir($qrFolder, 0777, true);
        }

        $qrFile = $qrFolder.$booking_id.".png";
        QRcode::png($qrData, $qrFile);

       
        require '../includes/PHPMailer/src/Exception.php';
        require '../includes/PHPMailer/src/PHPMailer.php';
        require '../includes/PHPMailer/src/SMTP.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'projectneha259@gmail.com'; 
            $mail->Password = 'qyyd rpwr pjxh pobb';    

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Smart Parking');
            $mail->addAddress($user_email);

            $mail->isHTML(true);
            $mail->Subject = 'Parking Booking Confirmation';

            $mail->Body = "
                <h2>Booking Confirmed</h2>
                <p><b>Slot:</b> ".$slot['slot_number']."</p>
                <p><b>Vehicle:</b> $vehicle</p>
                <p><b>Entry Time:</b> ".date('d-m-Y H:i')."</p>
                <p>Show this QR at entry:</p>
                <img src='cid:qrimg'>
            ";

            $mail->addEmbeddedImage($qrFile, 'qrimg');

            $mail->send();

        } catch (\Exception $e) {
            
        }

        
        $_SESSION['last_booking'] = [
            'slot_number' => $slot['slot_number'],
            'vehicle' => $vehicle,
            'qr' => $qrFile
        ];

        echo "<script>alert('Slot Booked Successfully');</script>";
        echo "<script>window.location='booking_success.php';</script>";
        exit();

    } else {
        die("Booking Error: ".mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Slot</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family:'Segoe UI', sans-serif;
}

.header{
    background: rgba(0,0,0,0.2);
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
    width:420px;
    margin:80px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.btn-custom{
    background:#667eea;
    color:white;
    border:none;
    padding:10px;
    border-radius:8px;
    font-weight:600;
}
</style>

</head>

<body>

<div class="header">
    <h4>Book Slot</h4>
    <a href="slots.php">Back</a>
</div>

<div class="box">

<h4 class="text-center">Enter Vehicle Details</h4>

<div class="alert alert-info text-center">
    Slot: <b><?php echo $slot['slot_number']; ?></b><br>
    Type: <b><?php echo $slot['vehicle_type'] ?? 'N/A'; ?></b>
</div>

<form method="post">
<input type="text" name="vehicle" class="form-control mb-3" placeholder="Vehicle Number" required>
<button type="submit" name="submit" class="btn btn-custom btn-block">
Confirm Booking
</button>
</form>

</div>

</body>
</html>