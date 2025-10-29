<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['role'] !== 'parent') {
    header("Location: login.php");
    exit();
}

$parentUsername = $_SESSION['username'];

include 'db.php';

$sql = "SELECT * FROM detail WHERE parent_username = :parent_username";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':parent_username', $parentUsername);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile (Parent View)</title>
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
        }
        .profile-header {
            background: linear-gradient(135deg, #2196f3, #0d47a1);
            padding: 50px 20px;
            color: white;
            text-align: center;
        }
        .profile-pic {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        .profile-header h1 {
            margin: 10px 0 5px;
            font-size: 32px;
            font-weight: 600;
        }
        .profile-body {
            padding: 40px 50px;
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
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
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
        .btn {
            display: inline-block;
            background: #2196f3;
            color: white;
            padding: 12px 24px;
            margin: 30px auto 40px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #1976d2;
        }
    </style>
</head>
<body>
    <?php if ($students): ?>
        <?php foreach ($students as $student): ?>
        <div class="container">
            <div class="profile-header">
                
                <h1><?= htmlspecialchars($student['full_name']) ?></h1>
                <p>Roll No: <?= htmlspecialchars($student['roll_no']) ?> | PRN: <?= htmlspecialchars($student['prn_number']) ?></p>
            </div>

            <div class="profile-body">
                <h2 class="section-header">📘 Student Details</h2>

                <?php
                $fields = [
                    '👨 Father Name' => 'father_name',
                    '👩 Mother Name' => 'mother_name',
                    '⚧ Gender' => 'gender',
                    '🎂 Date of Birth' => 'dob',
                    '📞 Phone' => 'phone',
                    '📧 Email' => 'email',
                    '🏠 Address' => 'address',
                    '🎓 Course' => 'course',
                    '🆔 Username' => 'username',
                    '👤 Parent Username' => 'parent_username',
                ];

                foreach ($fields as $label => $key) {
                    if (!empty($student[$key])) {
                        $value = $key === 'dob' ? date('F j, Y', strtotime($student[$key])) : nl2br(htmlspecialchars($student[$key]));
                        echo "<div class='detail-row'>
                                <div class='detail-label'>{$label}:</div>
                                <div class='detail-value'>{$value}</div>
                              </div>";
                    }
                }
                ?>
            </div>

            <div style="text-align:center;">
                <a href="dashboard_parent.php" class="btn">⬅ Back to Dashboard</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align:center; margin-top: 50px;">
            <h2 style="color: red;">No student data found for this parent.</h2>
        </div>
    <?php endif; ?>
</body>
</html>
