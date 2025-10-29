<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Teacher session info
$teacher_username = $_SESSION['username'];
$teacher_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Attendance Scanner</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        video {
            width: 100%;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
        .info-box, .alert {
            margin-top: 20px;
            text-align: left;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }
        .btn {
            margin-top: 15px;
            padding: 12px 20px;
            background-color: #2ecc71;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #27ae60;
        }
        .success {
            background-color: #e8f8f5;
            color: #27ae60;
        }
        .error {
            background-color: #fdecea;
            color: #e74c3c;
        }
    </style>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Scan QR to Mark Attendance</h2>
    <video id="preview"></video>

    <div id="data-box" class="info-box" style="display:none;">
        <p><strong>Admin:</strong> <span id="admin"></span></p>
        <p><strong>Teacher Username:</strong> <span id="teacher_username"></span></p>
        <p><strong>Teacher Name:</strong> <span id="teacher_name"></span></p>
        <p><strong>Department:</strong> <span id="department"></span></p>
        <p><strong>Date:</strong> <span id="date"></span></p>
        <p><strong>Time:</strong> <span id="time"></span></p>

        <form method="post" action="submit_teacher_attendance.php" >
            <input type="hidden" name="admin_username" id="adminField">
            <input type="hidden" name="teacher_username" id="teacherUsernameField">
            <input type="hidden" name="teacher_name" id="teacherNameField">
            <input type="hidden" name="department" id="departmentField">
            <input type="hidden" name="date" id="dateField">
            <input type="hidden" name="time" id="timeField">
            <button type="submit" class="btn">Confirm Attendance</button>
        </form>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <div class="alert <?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>">
            <?php
            if ($_GET['status'] === 'success') {
                echo "✔ Attendance marked successfully!";
            } else {
                echo "✖ " . htmlspecialchars($_GET['message'] ?? "Error submitting attendance.");
            }
            ?>
        </div>
    <?php endif; ?>
</div>

<script>
    const scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });

    scanner.addListener('scan', function (content) {
        try {
            const decoded = atob(content);
            const data = JSON.parse(decoded);

            if (data.admin_username && data.teacher_username && data.teacher_name && data.department && data.date && data.time) {
                // Show values
                document.getElementById('admin').innerText = data.admin_username;
                document.getElementById('teacher_username').innerText = data.teacher_username;
                document.getElementById('teacher_name').innerText = data.teacher_name;
                document.getElementById('department').innerText = data.department;
                document.getElementById('date').innerText = data.date;
                document.getElementById('time').innerText = data.time;

                // Fill hidden form fields
                document.getElementById('adminField').value = data.admin_username;
                document.getElementById('teacherUsernameField').value = data.teacher_username;
                document.getElementById('teacherNameField').value = data.teacher_name;
                document.getElementById('departmentField').value = data.department;
                document.getElementById('dateField').value = data.date;
                document.getElementById('timeField').value = data.time;

                // Show data section
                document.getElementById('data-box').style.display = 'block';
            } else {
                alert("Invalid QR Code format.");
            }
        } catch (e) {
            console.error(e);
            alert("Failed to read QR Code. Ensure it's a valid one.");
        }
    });

    Instascan.Camera.getCameras().then(cameras => {
        if (cameras.length > 0) {
            const rear = cameras.find(c => c.name.toLowerCase().includes("back")) || cameras[0];
            scanner.start(rear);
        } else {
            alert("No cameras found.");
        }
    });
</script>

</body>
</html>
