<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - College</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('image3.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
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
        /* Panels */
        .panel {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            border-left: 5px solid #4CAF50;
        }

        .panel h2 {
            font-size: 1.5em;
            margin-top: 0;
            color: #4CAF50;
        }

        /* Panel content */
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin: 10px 0;
            font-size: 1.1em;
        }

        .completed {
            color: green;
        }

        .pending {
            color: red;
        }

        .important {
            font-weight: bold;
            font-size: 1.2em;
        }

        .no-events {
            font-style: italic;
            color: #888;
        }
        .profile-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-info h2 {
            margin: 0;
            color: #333;
            font-size: 22px;
        }
        .profile-info p {
            margin: 5px 0;
            color: #555;
            font-size: 16px;
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
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .option:hover {
            background-color: #ecf0f1;
            transform: translateY(-4px);
        }
        .option a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            font-size: 16px;
            display: block;
        }
        .option a:hover {
            color: #2980b9;
        }

        .attendance-chart {
            margin-bottom: 30px;
        }
        .attendance-chart h3 {
            color: #333;
            margin-bottom: 15px;
        }
        .attendance-chart img {
            width: 100%;
            border-radius: 8px;
        }
        .notice {
            margin-bottom: 30px;
        }
        .notice h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .notice p {
            color: #555;
        }
        .events {
            margin-bottom: 30px;
        }
        .events h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .events p {
            color: #555;
        }

        @media (max-width: 768px) {
            .option {
                flex: 1 1 calc(50% - 15px);
            }
        }

        @media (max-width: 480px) {
            .option {
                flex: 1 1 100%;
            }
        }
    </style>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Student Dashboard</h1>

        <!-- Profile Information -->
        <div class="profile-info">
            <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
            <p>Session: 2024-2025</p>
            <p>Department: Computer Science</p>
        </div>

        <!-- Options -->
        <div class="options">
            <div class="option"><a href="sprofile.php">Profile</a></div>
            <div class="option"><a href="mark_attendance.php">Mark Attendance</a></div>
            <div class="option"><a href="viewattendance.php">View Attendance</a></div>
            <div class="option"><a href="apply_leave.php">Apply for Leave</a></div>
            <div class="option"><a href="examination.php">Examination</a></div>
            <div class="option"><a href="fees_receipt.php">Fees Receipt</a></div>
            <div class="option"><a href="feedback.php">Feedback</a></div>
            <div class="option"><a href="course_subjects.php">Course Subjects</a></div>
            <div class="option"><a href="online_registration.php">Online Registration</a></div>
            <div class="option"><a href="logout.php">Log Out</a></div>
        </div>

        <!-- Attendance Chart -->
        <div class="panel">
            <h2>Semester Wise Attendance</h2>
            <canvas id="attendanceChart"></canvas>
        </div>

        <script>
            // Data for the chart
            const semesters = ['SEM 3', 'SEM 4', 'SEM 5', 'SEM 6'];
            const attendancePercentages = [85, 90, 88, 92]; // Example percentages

            // Create the chart
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            const attendanceChart = new Chart(ctx, {
                type: 'bar', // Bar chart
                data: {
                    labels: semesters, // X-axis labels
                    datasets: [{
                        label: 'Attendance Percentage',
                        data: attendancePercentages, // Y-axis data
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

        <!-- Important Notice -->
        <div class="panel">
            <h2>Important Notice</h2>
            <ul>
                <li class="important"><a href="#">Notice about upcoming deadlines.</a></li>
            </ul>
        </div>

        <!-- Today's Events -->
        <div class="panel">
            <h3>Today's Events</h3>
            <p>No events for today.</p>
        </div>
    </div>
</body>
</html>
