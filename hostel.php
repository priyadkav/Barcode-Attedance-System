<?php
// Sample data (this could normally come from a database)
$hostel_details = [
    "name" => "Green Meadows Hostel",
    "location" => "Block B, 3rd Floor, Main Campus",
    "room_number" => "306 (Single Occupancy)",
    "facilities" => "Wi-Fi, Gym, Mess, Laundry Service, 24/7 Security"
];

$fee_details = [
    ["fee_type" => "Room Rent", "amount" => "₹15,000", "status" => "Paid"],
    ["fee_type" => "Mess Fees", "amount" => "₹3,000", "status" => "Unpaid"],
    ["fee_type" => "Security Deposit", "amount" => "₹5,000", "status" => "Paid"]
];

$warden_info = [
    "name" => "Mrs. Shalini Deshmukh",
    "contact" => "+91 9876543210",
    "email" => "shalini.deshmukh@college.edu"
];

$events = [
    ["event" => "Annual Cultural Fest (2025)", "date" => "15th June, 2025"],
    ["event" => "Sports Meet", "date" => "25th July, 2025"],
    ["event" => "Hostel Decoration Competition", "date" => "1st August, 2025"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Hostel Information</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('image6.jpg'); 
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        h1, h2 {
            color: #333;
        }

        /* Panels */
        .panel {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            border-left: 5px solid #4CAF50;
        }

        .panel h2 {
            font-size: 1.5em;
            margin-top: 0;
            color: #4CAF50;
        }

        .panel ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .panel li {
            margin: 10px 0;
            font-size: 1.1em;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        /* Button styles */
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .important {
            color: red;
            font-weight: bold;
        }

        .center-btn {
            text-align: center;
            margin-top: 30px;
        }

        /* Hostels details styling */
        .hostel-details {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Hostel Information</h1>

    <!-- Hostel Information Panel -->
    <div class="panel">
        <h2>Hostel Details</h2>
        <ul>
            <li><strong>Hostel Name:</strong> <?php echo htmlspecialchars($hostel_details['name']); ?></li>
            <li><strong>Location:</strong> <?php echo htmlspecialchars($hostel_details['location']); ?></li>
            <li><strong>Room Number:</strong> <?php echo htmlspecialchars($hostel_details['room_number']); ?></li>
            <li><strong>Facilities:</strong> <?php echo htmlspecialchars($hostel_details['facilities']); ?></li>
        </ul>
    </div>

    <!-- Hostel Fee Panel -->
    <div class="panel">
        <h2>Hostel Fee Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Fee Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fee_details as $fee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fee['fee_type']); ?></td>
                        <td><?php echo htmlspecialchars($fee['amount']); ?></td>
                        <td><?php echo htmlspecialchars($fee['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Hostel Warden Panel -->
    <div class="panel">
        <h2>Hostel Warden Information</h2>
        <ul>
            <li><strong>Name:</strong> <?php echo htmlspecialchars($warden_info['name']); ?></li>
            <li><strong>Contact:</strong> <?php echo htmlspecialchars($warden_info['contact']); ?></li>
            <li><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($warden_info['email']); ?>"><?php echo htmlspecialchars($warden_info['email']); ?></a></li>
        </ul>
    </div>

    <!-- Hostel Events Panel -->
    <div class="panel">
        <h2>Hostel Events</h2>
        <ul>
            <?php foreach ($events as $event): ?>
                <li><strong>Event:</strong> <?php echo htmlspecialchars($event['event']); ?> <br> <strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Download Hostel Certificate Panel -->
    <div class="panel">
        <h2>Download Hostel Certificate</h2>
        <p class="hostel-details">You can download your hostel stay certificate if required:</p>
        <a href="#" class="btn">Download Hostel Certificate</a>
    </div>

    <!-- Back Button -->
    <div class="center-btn">
        <button class="btn" onclick="goBack()">← Back to Dashboard</button>
    </div>

    <script>
        function goBack() {
            window.location.href = "dashboard_student.php"; // Adjust according to the role
        }
    </script>

</body>
</html>
