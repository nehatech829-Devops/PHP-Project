<?php
include('../includes/dbconnection.php');

require_once('../fpdf/fpdf.php');

$id = $_GET['id'];


$query = mysqli_query($con, "
SELECT bookings.*, slots.slot_number 
FROM bookings 
JOIN slots ON bookings.slot_id = slots.slot_id
WHERE bookings.booking_id='$id'
");

$row = mysqli_fetch_array($query);


$pdf = new FPDF();
$pdf->AddPage();


$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,'Parking Receipt',0,1,'C');
$pdf->Ln(5);


$pdf->SetFont('Arial','',12);


$pdf->Cell(50,10,'Booking ID:',0);
$pdf->Cell(100,10,$row['booking_id'],0,1);

$pdf->Cell(50,10,'Vehicle:',0);
$pdf->Cell(100,10,$row['vehicle_no'],0,1);

$pdf->Cell(50,10,'Slot:',0);
$pdf->Cell(100,10,$row['slot_number'],0,1);

$pdf->Cell(50,10,'Entry Time:',0);
$pdf->Cell(100,10,$row['entry_time'],0,1);

$pdf->Cell(50,10,'Exit Time:',0);
$pdf->Cell(100,10,$row['exit_time'],0,1);

$pdf->Cell(50,10,'Amount:',0);
$pdf->Cell(100,10,'Rs '.$row['amount'],0,1);


$pdf->Ln(10);
$pdf->Cell(0,10,'Thank you for using our parking system!',0,1,'C');


$pdf->Output('D','Parking_Bill.pdf');
?>