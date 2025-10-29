<?php
session_start();
require 'db.php';

// Admin authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$adminUsername = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM admin_detail WHERE username = ?");
$stmt->execute([$adminUsername]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "<div style='text-align:center;margin-top:50px;color:red;'>
            <h2>Profile not found</h2>
            <p>Please contact the system administrator.</p>
          </div>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
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
    <div class="container">
        <div class="profile-header">
            
            <h1><?= htmlspecialchars($admin['fullname']) ?></h1>
            <p class="admin-id">Admin Username: <?= htmlspecialchars($admin['username']) ?></p>
        </div>

        <div class="profile-body">
            <h2 class="section-header">🛠️ Admin Profile Details</h2>
            <?php
            $adminFields = [
                '📧 Email' => 'email',
                '📱 Phone' => 'phone',
                '🏡 Address' => 'address',
                '⚧ Gender' => 'gender',
                '🎂 Date of Birth' => 'dob',
                '🎓 Qualification' => 'qualification',
                '🏢 Department' => 'department'
            ];

            foreach ($adminFields as $label => $key) {
                if (!empty($admin[$key])) {
                    $value = $key === 'dob' ? date('F j, Y', strtotime($admin[$key])) : nl2br(htmlspecialchars($admin[$key]));
                    echo "<div class='detail-row'>
                            <div class='detail-label'>{$label}:</div>
                            <div class='detail-value'>{$value}</div>
                          </div>";
                }
            }

            if (isset($_SESSION['last_login'])) {
                $lastLogin = date('F j, Y, g:i a', $_SESSION['last_login']);
                echo "<div class='detail-row'>
                        <div class='detail-label'>🕒 Last Login:</div>
                        <div class='detail-value'>{$lastLogin}</div>
                      </div>";
            }
            ?>
        </div>

        <div style="text-align:center;">
            <a href="dashboard_admin.php" class="btn">⬅ Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
