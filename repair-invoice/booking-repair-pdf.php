<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
require('../fpdf/fpdf.php');

$rp_id = $_SESSION['rp_id'];
$query = "SELECT * FROM rprq
LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
LEFT JOIN defects ON rprq.defect_id = defects.defect_id
LEFT JOIN customer ON customer.cust_id=rprq.cust_id
WHERE id='{$rp_id}'";

$result = mysqli_query($conn, $query);

// Function to generate confirmation ticket PDF
function generateConfirmationTicket($transaction_code, $status, $etype, $defective, $shipping, $date_req, $name) {
    // Create new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();
    // Set logo and company name
    $pdf->Image('../img/proton-logo.png',10,10,30);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'PROTON ELECTRONICS AND SERVICES',0,1,'C');
    // Set customer name, transaction ID, and date requested
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,'Confirmation Ticket',0,1,'C');
    $pdf->Ln();
    $pdf->Cell(60,10,'Customer Name:',0,0);
    $pdf->Cell(60,10,'Transaction ID:',0,0);
    $pdf->Cell(60,10,'Date Requested:',0,1);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,10,$name,0,0);
    $pdf->Cell(60,10,$transaction_code,0,0);
    $pdf->Cell(60,10,$date_req,0,1);
    // Set transaction details
    $pdf->Ln();
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,'Transaction Details',0,1);
    $pdf->Ln();
    $pdf->Cell(60,10,'Status:',0,0);
    $pdf->Cell(60,10,'Electronic Type:',0,0);
    $pdf->Cell(60,10,'Defects:',0,1);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,10,$status,0,0);
    $pdf->Cell(60,10,$etype,0,0);
    $pdf->Cell(60,10,$defective,0,1);
    $pdf->Ln();
    $pdf->Cell(60,10,'Shipping:',0,0);
    $pdf->Cell(60,10,'',0,0);
    $pdf->Cell(60,10,'',0,1);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,10,$shipping,0,0);
    // Output PDF file
    $pdf->Output('Confirmation Ticket.pdf', 'D');
}

// Check if "Download Ticket" button is clicked
if (isset($_POST['download'])) {
    $_SESSION['rp_id'] = $_POST['download'];
    $row = mysqli_fetch_assoc($result);
    // Get transaction details
    $transaction_code = $row['transaction_code'];
    $status = $row['status'];
    $etype = $row['elec_name'];
    $defective = $row['defect_name'];
    $shipping = $row['shipping'];
    $date_req = $row['date_req'];
    $name = $row['fname'] ." " .  $row['lname'];
    // Generate confirmation ticket PDF
    generateConfirmationTicket($transaction_code, $status, $etype, $defective, $shipping, $date_req, $name);
}

?>
