<?php
session_start();

// Dummy role for demo; replace with actual login session role
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'student';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination Page</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('image6.jpg'); 
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        h1, h2 {
            color: #333;
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
            font-size: 1.5em;
            margin-top: 0;
            color: #4CAF50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .important {
            color: red;
            font-weight: bold;
        }

        .exam-details {
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .center-btn {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1>Examination Page</h1>

    <!-- Exam Schedule Panel -->
    <div class="panel">
        <h2>Upcoming Exam Schedule</h2>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $exam_schedule = [
                    ["subject" => "Computer Networks", "date" => "2025-05-20", "time" => "10:00 AM - 12:00 PM", "location" => "Room 101, Block A"],
                    ["subject" => "Information Security", "date" => "2025-05-22", "time" => "02:00 PM - 04:00 PM", "location" => "Room 202, Block B"],
                    ["subject" => "Fundamental of GIS", "date" => "2025-05-24", "time" => "11:00 AM - 01:00 PM", "location" => "Room 303, Block C"],
                    ["subject" => "Software Testing and Quality Assurence", "date" => "2025-05-25", "time" => "11:00 AM - 01:00 PM", "location" => "Room 304, Block C"],
                    ["subject" => "Cyber Law", "date" => "2025-05-26", "time" => "11:00 AM - 01:00 PM", "location" => "Room 301, Block A"]
                ];

                foreach ($exam_schedule as $exam): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exam['subject']); ?></td>
                        <td><?php echo htmlspecialchars($exam['date']); ?></td>
                        <td><?php echo htmlspecialchars($exam['time']); ?></td>
                        <td><?php echo htmlspecialchars($exam['location']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Exam Results Panel -->
    <div class="panel">
        <h2>Previous Exam Results</h2>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Marks Obtained</th>
                    <th>Total Marks</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $exam_results = [
                    ["subject" => "Artificial Intelligence", "marks_obtained" => 85, "total_marks" => 150, "grade" => "B"],
                    ["subject" => "Enterprizes Technologies", "marks_obtained" => 92, "total_marks" => 150, "grade" => "A"],
                    ["subject" => "Internet of Things", "marks_obtained" => 75, "total_marks" => 150, "grade" => "D"],
                    ["subject" => "Advanced Web Programming", "marks_obtained" => 75, "total_marks" => 150, "grade" => "D"],
                    ["subject" => "Software Project Development", "marks_obtained" => 125, "total_marks" => 150, "grade" => "A+"]
                ];

                foreach ($exam_results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['subject']); ?></td>
                        <td><?php echo htmlspecialchars($result['marks_obtained']); ?></td>
                        <td><?php echo htmlspecialchars($result['total_marks']); ?></td>
                        <td><?php echo htmlspecialchars($result['grade']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Admit Card Panel -->
    <div class="panel">
        <h2>Download Admit Card</h2>
        <p class="exam-details">Your admit card for the upcoming exams is now available. Please download it below:</p>
        <a href="#" class="btn">Download Admit Card</a>
    </div>

    <!-- Notifications Panel -->
    <div class="panel">
        <h2>Exam Notifications</h2>
        <p><span class="important">Important:</span> The examination schedule has been updated. Please check the new dates for your upcoming exams.</p>
    </div>

    <!-- Back Button -->
    <div class="center-btn">
        <button class="btn" onclick="goBack()">← Back to Dashboard</button>
    </div>

    <script>
        const userRole = "<?php echo $role; ?>";

        function goBack() {
            if (userRole === "teacher") {
                window.location.href = "dashboard_teacher.php";
            } else if (userRole === "admin") {
                window.location.href = "dashboard_admin.php";
            } else {
                window.location.href = "dashboard_student.php";
            }
        }
    </script>

</body>
</html>
