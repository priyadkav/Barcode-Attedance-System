<?php
session_start();
require('db.php'); // Ensure $conn is the PDO object

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? null;
    $student_name = $_POST['student_name'] ?? null;
    $teacher = $_POST['teacher'] ?? null;
    $subject = $_POST['subject'] ?? null;
    $date = $_POST['date'] ?? null;
    $timestamp = $_POST['timestamp'] ?? null;

    $user = $student_name; // Or use $student_id if preferred

    if (empty($user) || empty($teacher) || empty($subject) || empty($date) || empty($timestamp)) {
        header("Location: student_attendance.php?status=error&message=" . urlencode("Missing required fields"));
        exit();
    }

    try {
        $stmt = $conn->prepare("INSERT INTO attendance (user, teacher, subject, date, timestamp) 
                                VALUES (:user, :teacher, :subject, :date, :timestamp)");
        
        $stmt->execute([
            ':user' => $user,
            ':teacher' => $teacher,
            ':subject' => $subject,
            ':date' => $date,
            ':timestamp' => $timestamp
        ]);
        
        echo '<div style="margin: 20px auto; max-width: 600px; padding: 15px; background-color: #e0f8e0; border: 1px solid #4CAF50; border-radius: 8px; color: #2e7d32; font-size: 18px; display: flex; align-items: center;">
        <span style="font-size: 24px; margin-right: 10px;">✅</span>
        Attendance submitted successfully!
    </div>';
        header("Location: student_attendance.php?status=success");
        exit();
       

    } catch (PDOException $e) {
        header("Location: student_attendance.php?status=error&message=" . urlencode("Database error: " . $e->getMessage()));
        exit();
    }
}
?>
