<?php
// Include the Barcode library (ensure the path is correct)
require_once('generate_qr.php');

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorHTML;

// Create the barcode generator
$generator = new BarcodeGeneratorPNG();

// Data to encode (attendance marks)
$attendanceData = "StudentID: 12345, Subject: Math, Attendance: Present";

// Generate the barcode (Code 128 format)
$barcode = $generator->getBarcode($attendanceData, $generator::TYPE_CODE_128);

// Save the barcode image
file_put_contents('barcodes/attendance_barcode.png', $barcode);

// Output the barcode image to the browser (optional)
echo '<img src="data:image/png;base64,' . base64_encode($barcode) . '" alt="Barcode for Attendance">';
?>
