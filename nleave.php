<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply Leave</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('image6.jpg'); 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 500px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 0;
        }

        label {
            font-weight: bold;
        }

        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        .btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        #leaveMessage {
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            background-color: #e8f5e9;
            color: #2e7d32;
            font-weight: bold;
            display: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        #leaveMessage.show {
            display: block;
            animation: fadeInSlide 0.6s ease forwards;
        }

        @keyframes fadeInSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            color: #2e7d32;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Apply for Leave</h2>
        <form id="leaveForm" onsubmit="return applyLeave();">
            <label for="leaveStartDate">Start Date of Leave:</label>
            <input type="date" id="leaveStartDate" name="leaveStartDate" required>

            <label for="leaveEndDate">End Date of Leave:</label>
            <input type="date" id="leaveEndDate" name="leaveEndDate" required>

            <label for="leaveReason">Reason:</label>
            <textarea id="leaveReason" name="leaveReason" rows="4" placeholder="Enter reason for leave" required></textarea>

            <div class="button-group">
                <button type="submit" class="btn">Apply Leave</button>
                <button type="button" class="btn" onclick="window.location.href='dashboard_nonstaff.php'">← Back to Dashboard</button>
            </div>
        </form>

        <div id="leaveMessage"></div>
    </div>
</div>

<script>
    function applyLeave() {
        const startDate = document.getElementById('leaveStartDate').value;
        const endDate = document.getElementById('leaveEndDate').value;
        const reason = document.getElementById('leaveReason').value;
        const messageBox = document.getElementById('leaveMessage');

        const start = new Date(startDate);
        const end = new Date(endDate);

        if (!startDate || !endDate || !reason) {
            messageBox.className = 'show';
            messageBox.style.backgroundColor = '#ffebee';
            messageBox.style.color = '#c62828';
            messageBox.innerHTML = '<span class="success-icon">⚠️</span>Please fill in all fields.';
        } else if (end < start) {
            messageBox.className = 'show';
            messageBox.style.backgroundColor = '#ffebee';
            messageBox.style.color = '#c62828';
            messageBox.innerHTML = '<span class="success-icon">⚠️</span>End date cannot be before start date.';
        } else {
            messageBox.className = 'show';
            messageBox.style.backgroundColor = '#e8f5e9';
            messageBox.style.color = '#2e7d32';
            messageBox.innerHTML = '<span class="success-icon">✅</span>Leave request submitted successfully from <strong>' + startDate + '</strong> to <strong>' + endDate + '</strong>.';
            document.getElementById('leaveForm').reset();
        }

        return false;
    }
</script>

</body>
</html>
