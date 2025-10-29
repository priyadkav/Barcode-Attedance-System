<?php
require 'db.php';
require 'phpqrcode/qrlib.php'; // Include QR code library

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Teacher') {
    die("Access denied!");
}

$teacher_id = $_SESSION['user_id'];
$qr_data = uniqid(); // Generate unique QR code data
$expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // QR code expires in 1 hour

// Save QR code to database
$stmt = $conn->prepare('INSERT INTO QR_Codes (teacher_id, qr_data, generated_at, expires_at) VALUES (:teacher_id, :qr_data, NOW(), :expires_at)');
$stmt->bindParam(':teacher_id', $teacher_id);
$stmt->bindParam(':qr_data', $qr_data);
$stmt->bindParam(':expires_at', $expires_at);
$stmt->execute();

// Generate QR code image
QRcode::png($qr_data, 'qrcodes/' . $qr_data . '.png'); // Save QR code image
echo "QR code generated: <img src='qrcodes/$qr_data.png' alt='QR Code'>";
?>