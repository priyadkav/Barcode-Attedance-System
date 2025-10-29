<?php
session_start();
require('db.php');  // Include the database connection file

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch attendance grouped by teacher_username only
$stmt = $conn->prepare("SELECT teacher_username, COUNT(*) AS attendance_count FROM teacher_attendance GROUP BY teacher_username");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare arrays for chart
$usernames = [];
$attendanceCounts = [];

foreach ($results as $row) {
    $usernames[] = $row['teacher_username'];
    $attendanceCounts[] = $row['attendance_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Attendance Overview</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-image:url("image6.jpg");
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
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        canvas {
            max-height: 600px;
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
    <h2>Teacher Attendance Overview</h2>
    <canvas id="attendanceChart"></canvas>

    <!-- Back Button -->
    <a href="dashboard_admin.php" class="btn-back">Back to Dashboard</a>
</div>

<script>
const ctx = document.getElementById('attendanceChart').getContext('2d');
const usernames = <?php echo json_encode($usernames); ?>;
const attendanceCounts = <?php echo json_encode($attendanceCounts); ?>;

// Generate colors
const colors = usernames.map((_, i) => {
    const palette = [
        '#1f77b4', '#2ca02c', '#d62728', '#9467bd',
        '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'
    ];
    return palette[i % palette.length];
});

const attendanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: usernames,
        datasets: [{
            label: 'Sessions Logged',
            data: attendanceCounts,
            backgroundColor: colors,
            borderColor: colors,
            borderWidth: 1,
            barPercentage: 0.5,
            categoryPercentage: 1.0
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
            beginAtZero: true,
            ticks: {
                stepSize: 1,
                callback: function(value) {
                    return Number.isInteger(value) ? value : '';
                }
            },
            title: {
                display: true,
                text: 'Number of Sessions'
            }
        },
            y: {
                title: {
                    display: true,
                    text: 'Teacher Usernames'
                }
            }
        }
    }
});
</script>
</body>
</html>
