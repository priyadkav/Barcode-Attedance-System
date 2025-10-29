<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch student's attendance data
$stmt = $conn->prepare("SELECT subject, status, date FROM attendance WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$attendanceData = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Attendance Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($attendanceData) > 0): ?>
                    <?php foreach ($attendanceData as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['subject']); ?></td>
                            <td><?php echo htmlspecialchars($record['status']); ?></td>
                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No attendance records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard_student.php">Back to Dashboard</a>
    </div>
</body>
</html>