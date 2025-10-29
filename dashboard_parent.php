<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'parent') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parent Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            background-image: url('image3.jpeg');
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 28px;
        }
        .profile-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-info h2 {
            margin: 0;
            color: #333;
        }
        .profile-info p {
            margin: 5px 0;
            color: #555;
        }
        .options {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }
        .option {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .option a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
        .panel {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            border-left: 5px solid #4CAF50;
        }
        .panel h2 {
            color: #4CAF50;
        }
        canvas {
            width: 100% !important;
            max-width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Parent Dashboard</h1>

        <div class="profile-info">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <p>Academic Year: 2024-2025</p>
        </div>

        <div class="options">
            <div class="option"><a href="pprofile.php"> Parent Profile</a></div>
            <div class="option"><a href="pattendance.php"> View Child Attendance</a></div>
            <div class="option"><a href="pleave.php"> Leave Application For Student</a></div>
            <div class="option"><a href="black.php"> Notification</a></div>
            <div class="option"><a href="fees_receipt1.php">Fees</a></div>
           
            <div class="option"><a href="examination.php">Exam Time Table</a></div>
        </div>

        <div class="panel">
            <h2> Semester Wise Attendance</h2>
            <canvas id="attendanceChart"></canvas>
        </div>

        <div class="panel">
            <h2> Important Notice</h2>
            <ul>
                <li><strong>Exam schedule will be released next week.</strong></li>
            </ul>
        </div>

        <div class="panel">
            <h2> Today's Event</h2>
            <p>PTA Meeting scheduled at 4 PM in Main Hall.</p>
        </div>
    </div>

    <script>
        const semesters = ['SEM 3', 'SEM 4', 'SEM 5', 'SEM 6'];
        const attendancePercentages = [85, 90, 88, 92]; // Replace with dynamic values if needed

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: semesters,
                datasets: [{
                    label: 'Attendance Percentage',
                    data: attendancePercentages,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Percentage (%)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Semester'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>
</html>
