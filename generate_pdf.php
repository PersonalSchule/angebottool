<?php
// Verarbeitung des Formulars und Generierung des PDF-Angebots

require_once 'fpdf.php'; // FPDF einbinden, Pfad in /usr/share/php

function format_euro(float $value): string {
    return number_format($value, 2, ',', '.') . ' \xE2\x82\xAC';
}

$customer = isset($_POST['customer']) ? trim($_POST['customer']) : '';
$services = isset($_POST['service']) ? $_POST['service'] : [];

if ($customer === '') {
    die('Kein Kundenname angegeben.');
}

$total = 0.0;
foreach ($services as $service) {
    $price = isset($service['price']) ? (float)$service['price'] : 0.0;
    $total += $price;
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Optionales Logo oben rechts
// $pdf->Image('logo.png', 150, 10, 40);

$pdf->Cell(0, 10, 'Angebot', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Datum: ' . date('d.m.Y'), 0, 1);
$pdf->Cell(0, 10, 'Kunde: ' . htmlspecialchars($customer), 0, 1);
$pdf->Ln(5);

$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(120, 10, 'Leistung', 1, 0, 'L', true);
$pdf->Cell(60, 10, 'Preis', 1, 1, 'R', true);

foreach ($services as $service) {
    $desc = $service['desc'] ?? '';
    $price = isset($service['price']) ? (float)$service['price'] : 0.0;
    if ($desc === '' && $price == 0.0) {
        continue;
    }
    $pdf->Cell(120, 10, htmlspecialchars($desc), 1);
    $pdf->Cell(60, 10, format_euro($price), 1, 1, 'R');
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(120, 10, 'Gesamt', 1);
$pdf->Cell(60, 10, format_euro($total), 1, 1, 'R');

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="angebot.pdf"');
$pdf->Output('D', 'angebot.pdf');
exit;
?>
