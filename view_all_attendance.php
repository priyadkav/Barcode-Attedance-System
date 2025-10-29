<?php
session_start();
require 'db.php';

// Check if admin or teacher is logged in
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    header("Location: login.php");
    exit();
}

try {
    // Join attendance with detail table to show student and teacher info
    $stmt = $conn->query("
        SELECT 
            a.id,
            a.user AS student_username,
            s.full_name AS student_name,
            a.teacher AS teacher_username,
            t.full_name AS teacher_name,
            a.subject,
            a.date,
            a.timestamp,
            a.attendance_percentage
        FROM attendance a
        LEFT JOIN detail s ON a.user = s.username
        LEFT JOIN detail t ON a.teacher = t.username
        ORDER BY a.date DESC, a.timestamp DESC
    ");
    $attendanceData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Attendance Records</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a.back {
            display: block;
            margin: 20px auto;
            width: 200px;
            text-align: center;
            padding: 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.back:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Attendance Records</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Username</th>
                    <th>Student Name</th>
                    <th>Teacher Username</th>
                    <th>Teacher Name</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Attendance %</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($attendanceData) > 0): ?>
                    <?php foreach ($attendanceData as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['student_username']) ?></td>
                            <td><?= htmlspecialchars($row['student_name']) ?></td>
                            <td><?= htmlspecialchars($row['teacher_username']) ?></td>
                            <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                            <td><?= htmlspecialchars($row['subject']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['timestamp']) ?></td>
                            <td><?= htmlspecialchars($row['attendance_percentage']) ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9">No attendance records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a class="back" href="dashboard_admin.php">Back to Dashboard</a>
    </div>
</body>
</html>
