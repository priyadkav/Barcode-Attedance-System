<?php
session_start();
if (!isset($_SESSION['user_id']) || strtoupper($_SESSION['role']) !== 'STUDENT') {
    header("Location: login.php");
    exit();
}

// Get logged in user's details from session
$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['username'] ?? 'Unknown';
$student_email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
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
        .hidden {
            display: none;
        }
        .success {
            color: #2ecc71;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            padding: 15px;
            background-color: #e8f8f0;
            border-radius: 8px;
        }
        .error {
            color: #e74c3c;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            padding: 15px;
            background-color: #fdedec;
            border-radius: 8px;
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
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        video {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 2px solid #eee;
        }
        .user-info {
            margin-bottom: 25px;
            font-size: 16px;
            color: #333;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            text-align: left;
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
        .scanned-info strong {
            color: #2c3e50;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 25px;
        }
        #loading {
            display: none;
            margin: 15px 0;
        }
    </style>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Mark Your Attendance</h2>
    
    <video id="preview"></video>
    
    <div id="loading">Processing QR code...</div>
    
    <div id="scanned-data" class="hidden">
        <div class="scanned-info">
            <p><strong>Teacher:</strong> <span id="teacher"></span></p>
            <p><strong>Subject:</strong> <span id="subject"></span></p>
            <p><strong>Date:</strong> <span id="date"></span></p>
            <p><strong>Time:</strong> <span id="timestamp"></span></p>
        </div>

        <form method="post" action="student_attendance1.php">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
            <input type="hidden" name="student_name" value="<?php echo htmlspecialchars($student_name); ?>">
            <input type="hidden" name="teacher" id="teacherField">
            <input type="hidden" name="subject" id="subjectField">
            <input type="hidden" name="date" id="dateField">
            <input type="hidden" name="timestamp" id="timestampField">
            <input type="hidden" name="status" id="statusField" value="Present"> <!-- Default value -->
            
            <button type="submit" class="btn" id="submit-btn">
                <i class="fas fa-check-circle"></i> Confirm Attendance
            </button>
        </form>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="success">
                <i>✔</i><br>
                Attendance marked successfully!
            </div>
        <?php elseif ($_GET['status'] == 'error'): ?>
            <div class="error">
                <i>✖</i><br>
                <?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Error marking attendance'; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    let timeout;
    const scanner = new Instascan.Scanner({ 
        video: document.getElementById('preview'),
        mirror: false,
        captureImage: false,
        backgroundScan: true,
        refractoryPeriod: 5000,
        scanPeriod: 1
    });

    // Function to handle timeout and mark attendance as absent
    function markAbsent() {
        document.getElementById('statusField').value = 'Absent'; // Set status to Absent
        document.getElementById('submit-btn').click(); // Submit the form automatically
    }

    // Set timeout for 30 seconds
    timeout = setTimeout(markAbsent, 30000); // 30 seconds timeout

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
                // Clear timeout if QR code is scanned successfully
                clearTimeout(timeout);

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

                // Show the form
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

    function showError(message) {
        alert("❌ " + message);
        resetFields();
        document.getElementById('loading').style.display = 'none';
    }

    function resetFields() {
        // Clear displayed data
        document.getElementById('teacher').innerText = '';
        document.getElementById('subject').innerText = '';
        document.getElementById('date').innerText = '';
        document.getElementById('timestamp').innerText = '';

        // Clear form values
        document.getElementById('teacherField').value = '';
        document.getElementById('subjectField').value = '';
        document.getElementById('dateField').value = '';
        document.getElementById('timestampField').value = '';

        // Hide the form
        document.getElementById('scanned-data').classList.add('hidden');
    }

    // Initialize camera
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            // Prefer rear camera if available
            const rearCamera = cameras.find(c => c.name.toLowerCase().includes('back')) || cameras[0];
            scanner.start(rearCamera);
        } else {
            showError('No camera found. Please ensure your camera is connected and accessible.');
        }
    }).catch(function (e) {
        console.error(e);
        showError('Camera error: ' + e.message);
    });

    // Prevent form resubmission
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>
</html>
