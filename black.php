<?php
session_start();
require('db.php');  // Your database connection

// Ensure parent is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$parentUsername = $_SESSION['username'];

// Get the child username from the details tableb
$stmt = $conn->prepare("SELECT username FROM detail WHERE parent_username = ?");
$stmt->execute([$parentUsername]);
$child = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$child) {
    $message = "No child found for this parent.";
} else {
    $childUsername = $child['username'];

    // Get attendance sessions grouped by user
    $stmt = $conn->prepare("SELECT user, COUNT(*) AS sessions_attended FROM attendance GROUP BY user");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Find max attendance
    $maxSessions = 0;
    $childSessions = 0;

    foreach ($results as $row) {
        if ($row['sessions_attended'] > $maxSessions) {
            $maxSessions = $row['sessions_attended'];
        }

        if ($row['user'] === $childUsername) {
            $childSessions = $row['sessions_attended'];
        }
    }

    if ($childSessions === 0) {
        $message = "No attendance data found for your child.";
    } elseif ($childSessions < $maxSessions) {
        $message = "❌ Your child is blacklisted for low attendance.";
    } else {
        $message = "✅ Your child is not in the blacklist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blacklist Status</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
          
            background-image: url('image6.jpg'); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background: #fff;
            padding: 40px 60px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .box h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            font-size: 20px;
            font-weight: bold;
            color: #0d4c92;
        }

        .message.danger {
            color: #c0392b;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #0d4c92;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <div class="box">
        <h1>Blacklist Status</h1>
        <div class="message <?php echo strpos($message, 'not') === false ? 'danger' : ''; ?>">
            <?php echo $message; ?>
        </div>
        <a href="dashboard_parent.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
