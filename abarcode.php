<?php
// admin_generate_teacher_qr.php
session_start();
date_default_timezone_set('Asia/Kolkata');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard_admin.php");
    exit();
}

require 'db.php';

$adminUsername = $_SESSION['username'];
$encodedData = '';
$teacherUsername = '';
$teacherName = '';
$department = '';
$dateToday = date('Y-m-d');
$timeNow = date('H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherUsername = htmlspecialchars($_POST['teacher_username']);
    $teacherName = htmlspecialchars($_POST['teacher_name']);
    $department = htmlspecialchars($_POST['department']);

    $qrData = [
        "admin_username" => $adminUsername,
        "teacher_username" => $teacherUsername,
        "teacher_name" => $teacherName,
        "department" => $department,
        "date" => $dateToday,
        "time" => $timeNow
    ];

    $encodedData = base64_encode(json_encode($qrData));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin: Generate Teacher QR Code</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h2 {
            color: #0d47a1;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #0d47a1;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        button:hover {
            background: #1565c0;
        }
        .qr-image {
            text-align: center;
            margin-top: 30px;
        }
        .details {
            background: #e3f2fd;
            border-left: 5px solid #1976d2;
            padding: 15px;
            margin-top: 20px;
            border-radius: 6px;
        }
        .details p {
            margin: 6px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📘 Generate Teacher Attendance QR</h2>
    <form method="post">
        <label>Teacher Username</label>
        <input type="text" name="teacher_username" placeholder="Enter teacher username" required>

        <label>Teacher Name</label>
        <input type="text" name="teacher_name" placeholder="Enter teacher full name" required>

        <label>Department</label>
        <input type="text" name="department" placeholder="Enter department" required>

        <button type="submit">Generate QR Code</button>
    </form>

    <?php if (!empty($encodedData)) : ?>
        <div class="qr-image">
            <h3>QR Code Preview</h3>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= urlencode($encodedData) ?>" alt="QR Code">
        </div>
        <div class="details">
            <h4>🔍 Encoded QR Details</h4>
            <p><strong>Admin:</strong> <?= htmlspecialchars($adminUsername) ?></p>
            <p><strong>Teacher:</strong> <?= htmlspecialchars($teacherUsername) ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($teacherName) ?></p>
            <p><strong>Department:</strong> <?= htmlspecialchars($department) ?></p>
            <p><strong>Date:</strong> <?= $dateToday ?></p>
            <p><strong>Time:</strong> <?= $timeNow ?></p>
            <p><strong>Encoded:</strong> <code><?= $encodedData ?></code></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
