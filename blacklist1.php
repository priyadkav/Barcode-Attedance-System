<?php
require('db.php');

// Step 1: Get total number of classes held (assuming each date is one class)
$totalStmt = $conn->prepare("SELECT COUNT(DISTINCT date) as total_classes FROM attendance");
$totalStmt->execute();
$totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
$total_classes = $totalRow['total_classes'];

// Step 2: Get each user's present count
$stmt = $conn->prepare("
    SELECT user, COUNT(*) AS present_count 
    FROM attendance 
    WHERE status = 'Present'
    GROUP BY user
");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Step 3: Identify users below 75%
$blacklist = [];

foreach ($results as $row) {
    $user = $row['user'];
    $present = $row['present_count'];
    $percentage = ($total_classes > 0) ? ($present / $total_classes) * 100 : 0;

    if ($percentage < 75) {
        $blacklist[] = [
            'user' => $user,
            'present' => $present,
            'percentage' => round($percentage, 2)
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blacklist - Low Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f0f2f5;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: red;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #e74c3c;
            color: white;
        }
        .btn-back {
            display: block;
            width: 200px;
            margin: 30px auto 0;
            padding: 12px;
            text-align: center;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Blacklist - Attendance Below 75%</h2>

    <?php if (count($blacklist) > 0): ?>
        <table>
            <tr>
                <th>Username</th>
                <th>Classes Attended</th>
                <th>Attendance %</th>
            </tr>
            <?php foreach ($blacklist as $entry): ?>
                <tr>
                    <td><?php echo htmlspecialchars($entry['user']); ?></td>
                    <td><?php echo $entry['present']; ?></td>
                    <td><?php echo $entry['percentage']; ?>%</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center; color:green;">All students have 75% or above attendance.</p>
    <?php endif; ?>

    <a href="admin_dashboard.php" class="btn-back">Back to Dashboard</a>
</div>
</body>
</html>
