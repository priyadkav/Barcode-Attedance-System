<?php
session_start();
require('db.php'); // Your database connection file

// Check if user is logged in and is a parent
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$parentUsername = $_SESSION['username'];

// Fetch attendance records for all children of this parent
$stmt = $conn->prepare("
    SELECT a.teacher, a.subject, a.date, a.timestamp, a.user AS student_username
    FROM attendance a
    JOIN detail d ON a.user = d.username
    WHERE d.parent_username = ?
    ORDER BY a.date DESC, a.timestamp DESC
");
$stmt->execute([$parentUsername]);
$attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Child's Attendance</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('image6.jpg');
        }

        .header {
            background: #0d4c92;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .subject-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #0d4c92;
        }

        .faculty {
            font-size: 15px;
            color: #666;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 8px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: bold;
            color: #0d4c92;
            position: relative;
            flex-shrink: 0;
        }

        .circle::after {
            content: '%';
            position: absolute;
            right: 12px;
            font-size: 14px;
            color: #888;
        }

        .details {
            text-align: left;
            font-size: 16px;
        }

        .detail-row {
            margin-bottom: 6px;
        }

        .date-list {
            margin-top: 20px;
            font-size: 15px;
            color: #444;
            line-height: 1.6;
        }

        .date-item {
            margin-left: 10px;
        }

        .no-records {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
            color: #555;
        }

        .back-button-container {
            text-align: center;
            margin: 30px 0;
        }

        .back-button {
            color: #0d4c92;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            display: inline-block;
        }

        .back-button:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .stats {
                flex-direction: column;
            }

            .details {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">Welcome, <?php echo htmlspecialchars($parentUsername); ?> | My Child's Attendance</div>
    <div class="container">

    <?php
    if (count($attendanceRecords) > 0):
        // Group attendance by student + subject + teacher
        $grouped = [];

        foreach ($attendanceRecords as $record) {
            $key = $record['student_username'] . '|' . $record['subject'] . '|' . $record['teacher'];
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'student' => $record['student_username'],
                    'teacher' => $record['teacher'],
                    'subject' => $record['subject'],
                    'present' => 0,
                    'total' => 0,
                    'dates' => []
                ];
            }
            $grouped[$key]['present']++;
            $grouped[$key]['total']++;
            $grouped[$key]['dates'][] = $record['date'] . ' - ' . date('h:i A', strtotime($record['timestamp']));
        }

        foreach ($grouped as $data):
            $present = $data['present'];
            $total = $data['total'];
            $absent = $total - $present;
            $percentage = $total > 0 ? round(($present / $total) * 100) : 0;
    ?>
        <div class="card">
            <div class="subject-title"><?php echo htmlspecialchars($data['subject']); ?></div>
            <div class="faculty">Student: <?php echo htmlspecialchars($data['student']); ?> | Faculty: <?php echo htmlspecialchars($data['teacher']); ?></div>
            <div class="stats">
                <div class="circle" style="border-color: <?php echo $percentage >= 75 ? '#4caf50' : ($percentage >= 50 ? '#ffc107' : '#f44336'); ?>">
                    <?php echo $percentage; ?>
                </div>
                <div class="details">
                    <div class="detail-row">Total: <?php echo $total; ?></div>
                    <div class="detail-row">Present: <?php echo $present; ?></div>
                    <div class="detail-row">Absent: <?php echo $absent; ?></div>
                </div>
            </div>
            <div class="date-list">
                <strong>Dates:</strong><br>
                <?php foreach ($data['dates'] as $d): ?>
                    <div class="date-item">• <?php echo htmlspecialchars($d); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; else: ?>
        <div class="no-records">No attendance records found for your child(ren).</div>
    <?php endif; ?>

    <div class="back-button-container">
        <a href="dashboard_parent.php" class="back-button">← Back to Dashboard</a>
    </div>

    </div>
</body>
</html>
