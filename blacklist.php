<?php
session_start();
require('db.php');  // Your DB connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get student attendance counts
$stmt = $conn->prepare("SELECT user, teacher, COUNT(*) AS sessions_attended FROM attendance GROUP BY user");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Determine the maximum sessions attended by any student
$maxSessions = 0;
foreach ($results as $row) {
    if ($row['sessions_attended'] > $maxSessions) {
        $maxSessions = $row['sessions_attended'];
    }
}

// Collect blacklisted students (less than max)
$blacklisted = [];
foreach ($results as $row) {
    if ($row['sessions_attended'] < $maxSessions) {
        $blacklisted[] = [
            'teacher' => $row['teacher'],
            'username' => $row['user'],
            'sessions_attended' => $row['sessions_attended']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blacklisted Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-image: url('image6.jpg'); 
            
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #c0392b;
            text-align: center;
        }
        .blacklist-entry {
            color: red;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .btn-back {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            margin-top: 20px;
            text-align: center;
        }
        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Blacklisted Students</h2>

    <?php if (empty($blacklisted)): ?>
        <p style="color: green;">All students have attended the maximum number of sessions!</p>
    <?php else: ?>
        <?php foreach ($blacklisted as $student): ?>
            <div class="blacklist-entry">
            <?php echo htmlspecialchars($student['username']) . " has only attended " . $student['sessions_attended'] . " out of $maxSessions sessions."; ?>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="dashboard_teacher.php" class="btn-back">Back to Dashboard</a>
</div>
</body>
</html>
