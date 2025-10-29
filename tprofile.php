<?php
session_start();
require 'db.php';

// Teacher authentication
if (!isset($_SESSION['user_id']) ) {
    header("Location: login.php");
    exit();
}

// Fetch teacher data
$stmt = $conn->prepare("SELECT * FROM teacher_detail");
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$teachers) {
    echo "<div style='text-align:center;margin-top:50px;color:red;'>
            <h2>No teacher records found</h2>
            <p>Please contact the administrator.</p>
          </div>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profiles</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('image6.jpg'); 
            
        }
        .container {
            max-width: 900px;
            margin: 60px auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding-bottom: 30px;
        }
        .profile-header {
            background: linear-gradient(135deg, #2196f3, #0d47a1);
            padding: 40px 20px;
            color: white;
            text-align: center;
        }
        .profile-header h1 {
            font-size: 32px;
            font-weight: 600;
        }
        .profile-body {
            padding: 30px 40px;
        }
        .section-header {
            font-size: 24px;
            font-weight: 600;
            color: #0d47a1;
            margin-bottom: 30px;
            position: relative;
        }
        .section-header::before {
            content: '';
            width: 8px;
            height: 100%;
            background-color: #1e88e5;
            position: absolute;
            left: -20px;
            top: 0;
        }
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            background: #f9f9f9;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-label {
            font-weight: 600;
            color: #555;
        }
        .detail-value {
            color: #222;
            text-align: right;
            max-width: 60%;
        }
        .btn {
            display: inline-block;
            background: #2196f3;
            color: white;
            padding: 12px 24px;
            margin: 30px auto 0;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #1976d2;
        }
        @media (max-width: 600px) {
            .profile-body {
                padding: 25px;
            }
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 0;
            }
            .detail-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1>📚 Teacher Profiles</h1>
        </div>

        <div class="profile-body">
            <h2 class="section-header">👨‍🏫 Teacher Information</h2>
            <?php
            foreach ($teachers as $teacher) {
                echo "<div class='card'>";
                $fields = [
                    '👤 Full Name' => 'fullname',
                    '🧑‍💻 Username' => 'username',
                    '📧 Email' => 'email',
                    '📱 Phone' => 'phone',
                    '🏡 Address' => 'address',
                    '🎓 Course' => 'course',
                    '📘 Subject' => 'subject'
                ];
                foreach ($fields as $label => $key) {
                    if (!empty($teacher[$key])) {
                        echo "<div class='detail-row'>
                                <div class='detail-label'>{$label}:</div>
                                <div class='detail-value'>" . nl2br(htmlspecialchars($teacher[$key])) . "</div>
                              </div>";
                    }
                }
                echo "</div>";
            }
            ?>
        </div>

        <div style="text-align:center;">
            <a href="dashboard_teacher.php" class="btn">⬅ Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
