<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    //header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>QR Scanner</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<script src="https://unpkg.com/html5-qrcode"></script>

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family:'Segoe UI', sans-serif;
    color:white;
    text-align:center;
}

.container-box{
    max-width:400px;
    margin:50px auto;
    background:white;
    color:black;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

h3{
    margin-bottom:20px;
}

#reader{
    width:100%;
}
</style>

</head>

<body>

<div class="container-box">

<h3>Scan Parking QR</h3>

<div id="reader"></div>

<p class="mt-3 text-muted">Scan user QR to mark Entry / Exit</p>

<a href="dashboard.php" class="btn btn-secondary btn-sm mt-2">Back</a>

</div>

<script>
function onScanSuccess(decodedText) {

    html5QrcodeScanner.clear();
    window.location.href = "process-scan.php?booking_id=" + decodedText;
}

function onScanError(errorMessage) {
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 },
    false
);

html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>

</body>
</html>