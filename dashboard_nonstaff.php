<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: nonstaff_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Non-Staff Portal - College</title>
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
        .notice, .events {
            margin-bottom: 30px;
        }
        .notice h3, .events h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .notice p, .events p {
            color: #555;
        }
        .important {
            font-weight: bold;
            font-size: 1.2em;
            color: red;
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
        <h1>Non-Staff Portal</h1>

        <div class="profile-info">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <p>Session: 2024-2025</p>
            <p>Role: Non-Staff</p>
        </div>

        <div class="options">
            <div class="option"><a href="nprofile.php">View Personal Details</a></div>
            <div class="option"><a href="calculate_salary.php">Salary</a></div>
            <div class="option"><a href="nleave.php">Apply for Leave</a></div>
            <div class="option"><a href="logout.php">Logout</a></div>
        </div>

        <div class="panel">
            <h2>Important Notice</h2>
            <ul>
                <li class="important"><a href="#" style="text-decoration: none;">Submit monthly report before 25th.</a></li>
            </ul>
        </div>

        <div class="panel">
            <h3>Today's Events</h3>
            <p>Staff Workshop on Time Management at 2:00 PM in Hall B.</p>
        </div>
    </div>
</body>
</html>
