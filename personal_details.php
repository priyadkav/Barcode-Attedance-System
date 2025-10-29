<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch student's personal details
$stmt = $conn->prepare("SELECT username, student_id, roll_no, prn_number, full_name, date_of_birth FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$personalDetails = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: left;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }

        strong {
            color: #333;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Profile</h2>
        <?php if ($personalDetails): ?>
            <p><strong>Student ID:</strong> <?php echo htmlspecialchars($personalDetails['student_id']); ?></p>
            <p><strong>Roll No:</strong> <?php echo htmlspecialchars($personalDetails['roll_no']); ?></p>
            <p><strong>PRN Number:</strong> <?php echo htmlspecialchars($personalDetails['prn_number']); ?></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($personalDetails['full_name']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($personalDetails['date_of_birth']); ?></p>
        <?php else: ?>
            <p>No personal details found.</p>
        <?php endif; ?>
        <a href="dashboard_student.php">Back to Dashboard</a>
    </div>
</body>
</html>