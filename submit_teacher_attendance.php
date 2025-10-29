<?php
session_start();

require('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch POST data
    $teacher_username = trim($_POST['teacher_username'] ?? '');
    $teacher_name = trim($_POST['teacher_name'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $admin_username = trim($_POST['admin_username'] ?? '');

    // Check if all fields are filled
    if (!$teacher_username || !$teacher_name || !$department || !$date || !$time || !$admin_username) {
        header("Location: tmark_attendance.php?status=error&message=All fields are required.");
        exit;
    }

    try {
        // Optional: prevent duplicate attendance for same teacher and date
       // $checkStmt = $conn->prepare("SELECT * FROM teacher_attendance WHERE teacher_username = :teacher_username AND date = :date");
        //$checkStmt->execute([
          //  ':teacher_username' => $teacher_username,
            //':date' => $date
        //]);

        //if ($checkStmt->rowCount() > 0) {
          //  header("Location: tmark_attendance.php?status=error&message=Attendance already submitted for today.");
            //exit;
        //}

        // Insert into teacher_attendance table
        $stmt = $conn->prepare("
            INSERT INTO teacher_attendance (teacher_username, teacher_name, department, date, time, admin_username) 
            VALUES (:teacher_username, :teacher_name, :department, :date, :time, :admin_username)
        ");

        $stmt->execute([
            ':teacher_username' => $teacher_username,
            ':teacher_name' => $teacher_name,
            ':department' => $department,
            ':date' => $date,
            ':time' => $time,
            ':admin_username' => $admin_username
        ]);
        
        // Display success message with green check mark
        echo '<div style="margin: 20px auto; max-width: 600px; padding: 15px; background-color: #e0f8e0; border: 1px solid #4CAF50; border-radius: 8px; color: #2e7d32; font-size: 18px; display: flex; align-items: center;">
            <span style="font-size: 24px; margin-right: 10px;">✅</span>
            Attendance submitted successfully!
        </div>';
        
    } catch (PDOException $e) {
        // Log error or display detailed message for development
        echo '<div style="margin: 20px auto; max-width: 600px; padding: 15px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24; font-size: 18px; display: flex; align-items: center;">
            <span style="font-size: 24px; margin-right: 10px;">❌</span>
            Database error: ' . htmlspecialchars($e->getMessage()) . '
        </div>';
    }
} else {
    echo '<div style="margin: 20px auto; max-width: 600px; padding: 15px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24; font-size: 18px; display: flex; align-items: center;">
        <span style="font-size: 24px; margin-right: 10px;">❌</span>
        Invalid request method.
    </div>';
}
?>
