<?php
session_start();
require('db.php'); // Make sure this path is correct

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch attendance records
$stmt = $conn->prepare("SELECT teacher, subject, date, timestamp FROM attendance WHERE user = ? ORDER BY date DESC, timestamp DESC");
$stmt->execute([$username]);
$attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance Records</title>
    <style>
        /* RESET (to avoid browser inconsistencies) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background-image: url('image6.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .content {
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .no-records {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .welcome {
            font-size: 18px;
            color: #555;
        }
        
        /* BUTTON STYLES (DEBUG MODE) */
        .back-btn {
            text-align: center;
            margin-top: 30px;
            background: yellow; /* Debug: Should appear */
            padding: 10px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #3498db;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            border: 2px solid red; /* Debug: Force visibility */
        }
        
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My Attendance Records</h1>
            <div class="welcome">Welcome, <?php echo htmlspecialchars($username); ?></div>
        </div>

        <?php if (!empty($attendanceRecords)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendanceRecords as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['teacher']); ?></td>
                            <td><?php echo htmlspecialchars($record['subject']); ?></td>
                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                            <td><?php echo htmlspecialchars($record['timestamp']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-records">No attendance records found.</div>
        <?php endif; ?>

        <!-- BACK BUTTON (FORCED VISIBLE) -->
        
    </div>
    <div class="back-btn">
        <a href="dashboard_student.php" class="btn">← Back to Dashboard</a>
    </div>
</body>
</html>