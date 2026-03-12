<?php
// dashboard/generate-bill.php
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    http_response_code(403);
    die('Forbidden');
}

require_once __DIR__ . '/../includes/connection.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

// get tr_id
$tr_id = isset($_GET['tr_id']) ? trim($_GET['tr_id']) : '';
if ($tr_id === '' || !preg_match('/^[a-zA-Z0-9\-_]+$/', $tr_id)) {
    http_response_code(400);
    die('Invalid or missing tr_id');
}

$userEmail = $_SESSION['username']; // email from session

// NOTE: changed ORDER BY id ASC -> ORDER BY timestamp ASC because table has no 'id' column
$sql = "SELECT order_id, name, email, address, item, quantity, total_price, timestamp 
        FROM orders WHERE tr_id = ? AND email = ? ORDER BY timestamp ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    // give helpful message for debugging (remove message in production)
    die('DB error (prepare failed): ' . htmlspecialchars($conn->error));
}
$stmt->bind_param('ss', $tr_id, $userEmail);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    $stmt->close();
    http_response_code(404);
    die('No orders found for this transaction.');
}

// collect rows and compute total
$rows = [];
$orderId = null; $name = null; $email = null; $address = null; $timestamp = null;
$grandTotal = 0.0;
while ($r = $res->fetch_assoc()) {
    $rows[] = $r;
    $orderId = $orderId ?? $r['order_id'];
    $name = $name ?? $r['name'];
    $email = $email ?? $r['email'];
    $address = $address ?? $r['address'];
    $timestamp = $timestamp ?? $r['timestamp'];
    $grandTotal += floatval($r['total_price']);
}
$stmt->close();

// PDF generation
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,7,'Order Bill',0,1,'C');
        $this->Ln(2);
    }
}
$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',11);

// Header info
$pdf->Cell(0,7,'Transaction ID: ' . $tr_id,0,1);
$pdf->Cell(0,7,'Order ID: ' . ($orderId ?? '-'),0,1);
$pdf->Cell(0,7,'Name: ' . ($name ?? '-'),0,1);
$pdf->Cell(0,7,'Email: ' . ($email ?? '-'),0,1);
$pdf->MultiCell(0,7,'Address: ' . ($address ?? '-'),0,1);
if ($timestamp) $pdf->Cell(0,7,'Date: ' . $timestamp,0,1);
$pdf->Ln(4);

// Table header
$pdf->SetFont('Arial','B',11);
$pdf->Cell(90,8,'Item',1,0,'L');
$pdf->Cell(25,8,'Qty',1,0,'C');
$pdf->Cell(35,8,'Unit (₹)',1,0,'R');
$pdf->Cell(40,8,'Total (₹)',1,1,'R');

$pdf->SetFont('Arial','',11);

// Items
foreach ($rows as $row) {
    $item = $row['item'];
    $qty = (int)$row['quantity'];
    $total_price = floatval($row['total_price']);
    $unit_price = $qty ? $total_price / $qty : $total_price;

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(90,7, $item, 1);
    $h = $pdf->GetY() - $y;
    $pdf->SetXY($x + 90, $y);
    $pdf->Cell(25, $h, $qty, 1, 0, 'C');
    $pdf->Cell(35, $h, number_format($unit_price, 2), 1, 0, 'R');
    $pdf->Cell(40, $h, number_format($total_price, 2), 1, 1, 'R');
}

$pdf->SetFont('Arial','B',12);
$pdf->Cell(150,10,'Grand Total',1,0,'R');
$pdf->Cell(40,10,'₹' . number_format($grandTotal,2),1,1,'R');

$pdf->Ln(6);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(0,6,'Thank you for your purchase!',0,1);

// Force download
$filename = 'Bill_' . $tr_id . '.pdf';
$pdf->Output('D', $filename);
exit;
