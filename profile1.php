<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Database connection with error handling
require 'db.php';

// Fetch only the current user's data
try {
    $stmt = $conn->prepare("SELECT id, username, email, role, full_name, created_at FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        // User not found - possible session tampering
        session_unset();
        session_destroy();
        header("Location: login.php?error=session_invalid");
        exit();
    }
    
    // Verify session consistency
    if ($user['username'] !== $_SESSION['username'] || $user['id'] !== $_SESSION['user_id']) {
        session_unset();
        session_destroy();
        header("Location: login.php?error=session_mismatch");
        exit();
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}

// Calculate account age
$created = new DateTime($user['created_at']);
$now = new DateTime();
$accountAge = $created->diff($now)->format('%y years, %m months');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;">
    <title>My Profile - <?php echo htmlspecialchars($user['username']); ?></title>
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --error-color: #d8000c;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-radius: 8px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .profile-title {
            color: var(--primary-color);
            margin: 0;
        }
        
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .profile-card {
            background: var(--light-gray);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-color);
        }
        
        .profile-card h3 {
            margin-top: 0;
            color: var(--primary-color);
        }
        
        .profile-info {
            margin-bottom: 1rem;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            word-break: break-word;
        }
        
        .action-buttons {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }
        
        .btn-secondary:hover {
            background: var(--light-gray);
        }
        
        .btn-danger {
            background: #f8d7da;
            color: var(--error-color);
            border: 1px solid #f5c6cb;
        }
        
        .btn-danger:hover {
            background: #f1b0b7;
        }
        
        @media (max-width: 600px) {
            .profile-container {
                padding: 1rem;
                margin: 1rem;
            }
            
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1 class="profile-title">My Profile</h1>
            <div class="account-age">Member for <?php echo htmlspecialchars($accountAge); ?></div>
        </div>
        
        <div class="profile-grid">
            <div class="profile-card">
                <h3>Personal Information</h3>
                <div class="profile-info">
                    <span class="info-label">Full Name</span>
                    <div class="info-value"><?php echo htmlspecialchars($user['full_name'] ?? 'Not provided'); ?></div>
                </div>
                <div class="profile-info">
                    <span class="info-label">Username</span>
                    <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                </div>
                <div class="profile-info">
                    <span class="info-label">Email</span>
                    <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
            </div>
            
            <div class="profile-card">
                <h3>Account Details</h3>
                <div class="profile-info">
                    <span class="info-label">Account Type</span>
                    <div class="info-value"><?php echo htmlspecialchars(ucfirst($user['role'])); ?></div>
                </div>
                <div class="profile-info">
                    <span class="info-label">Account Created</span>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></div>
                </div>
                <div class="profile-info">
                    <span class="info-label">Last Login</span>
                    <div class="info-value">
                        <?php 
                        if (isset($_SESSION['last_login'])) {
                            echo date('F j, Y g:i a', $_SESSION['last_login']);
                        } else {
                            echo 'First login';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            <a href="change_password.php" class="btn btn-secondary">Change Password</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>