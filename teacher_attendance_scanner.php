<?php
session_start();
if (!isset($_SESSION['user_id']) || strtoupper($_SESSION['role']) !== 'TEACHER') {
    header("Location: login.php");
    exit();
}

$teacher_username = $_SESSION['username'] ?? 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Attendance Scanner</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        video {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 2px solid #eee;
        }
        .scanned-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
        }
        .scanned-info p {
            margin: 8px 0;
        }
        .btn {
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .success, .error {
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            font-weight: bold;
        }
        .success {
            background-color: #d4edda;
            color: #2e7d32;
        }
        .error {
            background-color: #f8d7da;
            color: #c62828;
        }
        .hidden {
            display: none;
        }
    </style>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Scan Admin QR to Mark Attendance</h2>
    
    <video id="preview"></video>
    <div id="loading" class="hidden">Processing QR code...</div>

    <div id="scanned-data" class="hidden">
        <div class="scanned-info">
            <p><strong>Admin:</strong> <span id="admin"></span></p>
            <p><strong>Department:</strong> <span id="department"></span></p>
            <p><strong>Date:</strong> <span id="date"></span></p>
            <p><strong>Time:</strong> <span id="time"></span></p>
        </div>

        <form method="post" action="submit_teacher_attendance.php">
            <input type="hidden" name="teacher_username" value="<?php echo htmlspecialchars($teacher_username); ?>">
            <input type="hidden" name="admin_username" id="adminField">
            <input type="hidden" name="department" id="departmentField">
            <input type="hidden" name="date" id="dateField">
            <input type="hidden" name="time" id="timeField">
            <button type="submit" class="btn">Confirm Attendance</button>
        </form>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="success">✔ Attendance marked successfully!</div>
        <?php elseif ($_GET['status'] == 'error'): ?>
            <div class="error">✖ <?php echo htmlspecialchars($_GET['message'] ?? 'Error'); ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    const scanner = new Instascan.Scanner({
        video: document.getElementById('preview'),
        mirror: false
    });

    scanner.addListener('scan', function (content) {
        document.getElementById('loading').classList.remove('hidden');

        try {
            const decoded = atob(content.trim());
            const data = JSON.parse(decoded);

            const required = ['admin_username', 'department', 'date', 'time'];
            if (!required.every(k => data[k])) {
                alert("QR Code missing required fields.");
                return;
            }

            // Display scanned data
            document.getElementById('admin').innerText = data.admin_username;
            document.getElementById('department').innerText = data.department;
            document.getElementById('date').innerText = data.date;
            document.getElementById('time').innerText = data.time;

            // Populate hidden fields
            document.getElementById('adminField').value = data.admin_username;
            document.getElementById('departmentField').value = data.department;
            document.getElementById('dateField').value = data.date;
            document.getElementById('timeField').value = data.time;

            document.getElementById('scanned-data').classList.remove('hidden');
            document.getElementById('loading').classList.add('hidden');
        } catch (err) {
            alert("Invalid QR code.");
            console.error(err);
            document.getElementById('loading').classList.add('hidden');
        }
    });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No camera found.');
        }
    }).catch(function (e) {
        console.error(e);
        alert('Camera error: ' + e.message);
    });
</script>

</body>
</html>
