<?php
session_start();
require('db.php'); // Ensure $conn is the PDO object

// Check for session and user roles (e.g., student)
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user']; // Get user info
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your stylesheet -->
    <script src="https://cdn.jsdelivr.net/npm/instascan@1.0.0/dist/instascan.min.js"></script>
</head>
<body>
    <h1>Mark Attendance</h1>
    <div id="loading" style="display:none;">Scanning...</div>
    <div id="scanned-data" class="hidden">
        <p>Teacher: <span id="teacher"></span></p>
        <p>Subject: <span id="subject"></span></p>
        <p>Date: <span id="date"></span></p>
        <p>Timestamp: <span id="timestamp"></span></p>

        <form id="attendance-form" method="POST" action="mark_attendance1.php">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($user['student_id']); ?>">
            <input type="hidden" name="student_name" value="<?php echo htmlspecialchars($user['student_name']); ?>">
            <input type="hidden" name="teacher" id="teacherField">
            <input type="hidden" name="subject" id="subjectField">
            <input type="hidden" name="date" id="dateField">
            <input type="hidden" name="timestamp" id="timestampField">
            <input type="hidden" name="status" id="statusField" value="present">

            <button type="submit">Submit Attendance</button>
        </form>
    </div>

    <video id="preview" width="100%" height="auto"></video>

    <script>
        const scanner = new Instascan.Scanner({ 
            video: document.getElementById('preview'),
            mirror: false,
            captureImage: false,
            backgroundScan: true,
            refractoryPeriod: 5000,
            scanPeriod: 1
        });

        let scanned = false; // Flag to track if QR code is scanned

        // Timeout function for marking as absent if no QR code is scanned in 30 seconds
        setTimeout(function () {
            if (!scanned) {
                markAbsent(); // Automatically submit as absent after 30 seconds
            }
        }, 30000); // 30 seconds timeout

        scanner.addListener('scan', function (content) {
            document.getElementById('loading').style.display = 'block';
            const trimmed = content.trim();
            console.log("Scanned QR:", trimmed);

            try {
                const decoded = atob(trimmed);
                const data = JSON.parse(decoded);

                // Validate required fields
                const requiredFields = ['teacher', 'subject', 'date', 'timestamp'];
                const isValid = requiredFields.every(field => data[field]);
                
                if (isValid) {
                    // Display scanned data
                    document.getElementById('teacher').innerText = data.teacher;
                    document.getElementById('subject').innerText = data.subject;
                    document.getElementById('date').innerText = data.date;
                    document.getElementById('timestamp').innerText = data.timestamp;

                    // Set form values
                    document.getElementById('teacherField').value = data.teacher;
                    document.getElementById('subjectField').value = data.subject;
                    document.getElementById('dateField').value = data.date;
                    document.getElementById('timestampField').value = data.timestamp;

                    // Mark as scanned successfully
                    scanned = true;

                    // Show the form to confirm attendance
                    document.getElementById('scanned-data').classList.remove('hidden');
                    document.getElementById('loading').style.display = 'none';
                } else {
                    showError("Invalid QR: Missing required fields.");
                }
            } catch (error) {
                console.error(error);
                showError("QR Decode Error. Please scan a valid QR code.");
            }
        });

        // Function to submit form as absent if no QR is scanned
        function markAbsent() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'mark_attendance1.php';

            // Add hidden fields for absent status
            form.appendChild(createInput('student_id', '<?php echo $user['student_id']; ?>'));
            form.appendChild(createInput('student_name', '<?php echo $user['student_name']; ?>'));
            form.appendChild(createInput('teacher', ''));
            form.appendChild(createInput('subject', ''));
            form.appendChild(createInput('date', ''));
            form.appendChild(createInput('timestamp', ''));
            form.appendChild(createInput('status', 'absent'));

            document.body.appendChild(form);
            form.submit();
        }

        // Utility function to create hidden input fields
        function createInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }

        // Show error message
        function showError(message) {
            alert(message);
            document.getElementById('loading').style.display = 'none';
        }
    </script>
</body>
</html>
