<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch admin username
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$adminDetails = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('image3.jpeg');
            background-color: #f7f9fc;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .profile-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-info h2 {
            color: #333;
            font-size: 22px;
        }

        .option {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-bottom: 15px;
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

        .panel {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            padding: 20px;
            border-left: 5px solid #4CAF50;
        }

        .panel h2 {
            font-size: 1.5em;
            color: #4CAF50;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 8px 0;
        }

        .important {
            font-weight: bold;
            color: red;
        }

        .no-events {
            color: #888;
            font-style: italic;
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
</head>
<body>
<div class="container">
    <h1>Admin Portal</h1>

    <div class="profile-info">
        <h2>Welcome, <?php echo htmlspecialchars($adminDetails['username']); ?></h2>
        <p>Session: 2024-2025</p>
    </div>

    <!-- Options -->
    <div class="option"><a href="aprofile.php">View Profile</a></div>
    <div class="option"><a href="add_student1.php">Add Student</a></div>
    <div class="option"><a href="add_teacher.php">Add Teacher</a></div>
    <div class="option"><a href="abarcode.php">Generate QR</a></div>
    <div class="option"><a href="teacherviewstudent.php">View student Attendance</a></div>
    <div class="option"><a href="adminviewteacher.php">View Teacher Attendance</a></div>
    <div class="option"><a href="addcourse.php">Add Course</a></div>
    <div class="option"><a href="notice.php">Generate Notice</a></div>
    <div class="option"><a href="logout.php">Logout</a></div>

    <!-- Notice Panel -->
</div>
</body>
</html>
