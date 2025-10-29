<?php
require 'database.php';
require 'vendor/autoload.php'; // Include Twilio library (for SMS)

use Twilio\Rest\Client;

// Fetch students with attendance less than 75%
$stmt = $conn->prepare('
    SELECT s.student_id, u.name, u.email, COUNT(a.attendance_id) AS present_days
    FROM Students s
    JOIN Users u ON s.student_id = u.user_id
    LEFT JOIN Attendance a ON s.student_id = a.student_id AND a.status = "Present"
    GROUP BY s.student_id
    HAVING present_days < 15
');
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send SMS to parents
$twilio = new Client('TWILIO_ACCOUNT_SID', 'TWILIO_AUTH_TOKEN'); // Replace with your Twilio credentials

foreach ($students as $student) {
    $parent_id = $student['student_id']; // Assuming parent_id is linked to student_id
    $stmt = $conn->prepare('SELECT phone FROM Parents WHERE parent_id = :parent_id');
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->execute();
    $parent = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($parent) {
        $message = "Dear Parent, your child {$student['name']} has attendance less than 75%.";
        $twilio->messages->create(
            $parent['phone'], // Parent's phone number
            [
                'from' => 'TWILIO_PHONE_NUMBER', // Your Twilio phone number
                'body' => $message
            ]
        );
    }
}

echo "Alerts sent successfully!";
?>