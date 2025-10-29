<?php
// Start session and connect to DB
session_start();
require('db.php'); // Your database connection

// Fetch attendance count grouped by teacher name and department
$stmt = $conn->prepare("
    SELECT teacher_name, department, COUNT(*) as count
    FROM teacher_attendance
    GROUP BY teacher_name, department
    ORDER BY count DESC
");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$counts = [];
$colors = [];

foreach ($data as $row) {
    $labels[] = $row['teacher_name'] . " (" . $row['department'] . ")";
    $counts[] = $row['count'];

    // Assign random color for each bar (or department-wise if you prefer)
    $colors[] = sprintf('rgb(%d,%d,%d)', rand(50,200), rand(50,200), rand(50,200));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Attendance Overview</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 40px;
        }
        .chart-container {
            width: 90%;
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        canvas {
            max-height: 500px;
        }
        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 12px 20px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
<div class="chart-container">
    <h2 style="text-align: center;">Attendance Overview by Teacher</h2>
    <canvas id="attendanceChart"></canvas>
    <a href="dashboard_teacher.php" class="btn">Back to Dashboard</a>
</div>

<script>
const ctx = document.getElementById('attendanceChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Number of Classes Attended',
            data: <?php echo json_encode($counts); ?>,
            backgroundColor: <?php echo json_encode($colors); ?>
        }]
    },
    options: {
        indexAxis: 'y', // This makes the bars horizontal
        responsive: true,
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Classes Attended'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Teachers'
                }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
</body>
</html>
