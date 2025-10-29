<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $qrContent = $_POST['qr_content'];
    list($type, $subject, $timestamp) = explode(":", $qrContent);

    if ($type === 'ATTENDANCE') {
        // Mark attendance
        $stmt = $conn->prepare("INSERT INTO attendance (user_id, subject, status, date) VALUES (?, ?, 'present', CURDATE())");
        $stmt->execute([$_SESSION['user_id'], $subject]);

        echo "Attendance marked for $subject.";
    } else {
        echo "Invalid QR Code.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Scan QR Code</h2>
        <form method="POST">
            <label for="qr_content">QR Code Content:</label>
            <input type="text" id="qr_content" name="qr_content" required>
            <button type="submit">Submit</button>
        </form>
        <a href="dashboard_student.php">Back to Dashboard</a>
    </div>
</body>
</html>