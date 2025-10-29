<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data'])) {
    $encodedData = $_GET['data'];
    $decodedData = json_decode(base64_decode($encodedData), true);
    
    // Extract data from the decoded QR
    $adminUsername = $decodedData['admin_username'] ?? '';
    $teacherUsername = $decodedData['teacher_username'] ?? '';
    $teacherName = $decodedData['teacher_name'] ?? '';
    $department = $decodedData['department'] ?? '';
    $date = $decodedData['date'] ?? '';
    $time = $decodedData['time'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Attendance</title>
    <style>
        /* Add your styling here */
    </style>
</head>
<body>

<div class="container">
    <h2>📘 Teacher Attendance</h2>
    <form action="submit_teacher_attendance.php" method="POST">
        <input type="hidden" name="admin_username" value="<?= htmlspecialchars($adminUsername) ?>">
        <input type="hidden" name="teacher_username" value="<?= htmlspecialchars($teacherUsername) ?>">
        <input type="hidden" name="teacher_name" value="<?= htmlspecialchars($teacherName) ?>">
        <input type="hidden" name="department" value="<?= htmlspecialchars($department) ?>">
        <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
        <input type="hidden" name="time" value="<?= htmlspecialchars($time) ?>">

        <h3>Confirm Attendance Details</h3>
        <p><strong>Admin Username:</strong> <?= htmlspecialchars($adminUsername) ?></p>
        <p><strong>Teacher Username:</strong> <?= htmlspecialchars($teacherUsername) ?></p>
        <p><strong>Teacher Name:</strong> <?= htmlspecialchars($teacherName) ?></p>
        <p><strong>Department:</strong> <?= htmlspecialchars($department) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
        <p><strong>Time:</strong> <?= htmlspecialchars($time) ?></p>

        <button type="submit">Submit Attendance</button>
    </form>
</div>

</body>
</html>
