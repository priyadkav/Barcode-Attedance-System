<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'teacher' && $_SESSION['role'] !== 'nonstaff')) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoursWorked = $_POST['hours_worked'];
    $hourlyRate = $_POST['hourly_rate'];
    $totalSalary = $hoursWorked * $hourlyRate;

    // Save salary data
    $stmt = $conn->prepare("INSERT INTO salary (user_id, hours_worked, hourly_rate, total_salary, date) VALUES (?, ?, ?, ?, CURDATE())");
    $stmt->execute([$_SESSION['user_id'], $hoursWorked, $hourlyRate, $totalSalary]);

    echo "Salary calculated: $totalSalary";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Calculation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Salary Calculation</h2>
        <form method="POST">
            <label for="hours_worked">Hours Worked:</label>
            <input type="number" id="hours_worked" name="hours_worked" required>
            
            <label for="hourly_rate">Hourly Rate:</label>
            <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" required>
            
            <button type="submit">Calculate Salary</button>
        </form>
        <a href="dashboard_teacher.php">Back to Dashboard</a>
    </div>
</body>
</html>