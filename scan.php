<?php
session_start();
require 'db.php'; // Your database connection file

// Authentication check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Process QR scan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $qrContent = $_POST['qr_content'];
    list($type, $subject, $timestamp) = explode(":", $qrContent);

    if ($type === 'ATTENDANCE') {
        try {
            // Begin transaction
            $conn->begin_transaction();

            // 1. Mark attendance
            $stmt = $conn->prepare("INSERT INTO attendance (user, teacher, subject, date, timestamp, status) 
                                  VALUES (?, ?, ?, CURDATE(), CURTIME(), 'present')");
            $stmt->bind_param("sss", $_SESSION['username'], $_SESSION['teacher'], $subject);
            $stmt->execute();

            // 2. Calculate new attendance percentage
            calculateAttendancePercentage($conn, $_SESSION['username']);

            // Commit transaction
            $conn->commit();
            
            $_SESSION['message'] = "Attendance marked for $subject successfully!";
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
        
        header("Location: dashboard_student.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid QR Code.";
    }
}

/**
 * Calculates and updates attendance percentage for a student
 */
function calculateAttendancePercentage($conn, $username) {
    // Get total classes for this student
    $total = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE user = '$username'")->fetch_assoc()['total'];
    
    // Get attended classes
    $attended = $conn->query("SELECT COUNT(*) as attended FROM attendance WHERE user = '$username' AND status = 'present'")->fetch_assoc()['attended'];
    
    // Calculate percentage
    $percentage = ($total > 0) ? round(($attended / $total) * 100, 2) : 0;
    
    // Update all records for this student (or consider using a summary table)
    $conn->query("UPDATE attendance SET attendance_percentage = $percentage WHERE user = '$username'");
    
    return $percentage;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Attendance QR</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        h2 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; gap: 15px; }
        input[type="text"] { padding: 10px; font-size: 16px; }
        button { padding: 10px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
        .message { color: green; margin: 10px 0; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Scan Attendance QR Code</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form method="POST" id="qrForm">
            <label for="qr_content">QR Code Content:</label>
            <input type="text" id="qr_content" name="qr_content" required placeholder="Scan QR code or enter manually">
            <button type="submit">Submit Attendance</button>
        </form>
        
        <p>Current Attendance Percentage: 
            <?php 
            $percentage = $conn->query("SELECT attendance_percentage FROM attendance WHERE user = '{$_SESSION['username']}' LIMIT 1")->fetch_assoc()['attendance_percentage'];
            echo $percentage ? $percentage.'%' : 'Not calculated yet';
            ?>
        </p>
        
        <a href="dashboard_student.php">Back to Dashboard</a>
    </div>

    <script>
        // Auto-focus the input field for better mobile experience
        document.getElementById('qr_content').focus();
        
        // Optional: Add QR scanner functionality using a library like Instascan
        // This would replace the manual input with camera scanning
    </script>
</body>
</html>