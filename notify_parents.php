<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Check attendance for all students
$stmt = $conn->prepare("
    SELECT user_id, COUNT(*) as total, SUM(status = 'present') as present 
    FROM attendance 
    GROUP BY user_id
");
$stmt->execute();
$attendanceData = $stmt->fetchAll();

foreach ($attendanceData as $data) {
    $attendancePercentage = ($data['present'] / $data['total']) * 100;

    if ($attendancePercentage < 75) {
        // Notify parent (simulate sending a message)
        $parentStmt = $conn->prepare("SELECT username FROM users WHERE role = 'parent' AND id = ?");
        $parentStmt->execute([$data['user_id']]);
        $parent = $parentStmt->fetch();

        if ($parent) {
            $message = "Your child's attendance is below 75%. Current attendance: $attendancePercentage%.";
            echo "Notification sent to parent: " . $parent['username'] . " - " . $message . "<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notify Parents</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Notify Parents</h2>
        <p>Parents with children having attendance below 75% have been notified.</p>
        <a href="dashboard_teacher.php">Back to Dashboard</a>
    </div>
</body>
</html>