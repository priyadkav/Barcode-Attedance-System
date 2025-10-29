<?php
// Start session to handle login or other dynamic content if needed
session_start();

// You can add any session checks or data fetching here (e.g., user data, form processing, etc.)
// Example: If user isn't logged in, redirect to login page.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// If any specific action needs to be performed, you can add that logic here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjectic Security</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            background-image: url('image6.jpg'); 
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-top: 20px;
            font-size: 2.5em;
        }
        ul {
            list-style-type: none;
            padding: 0;
            max-width: 600px;
            margin: 20px auto;
        }
        li {
            margin: 10px 0;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        li:hover {
            background-color: #f1f1f1;
            transform: translateY(-2px);
        }
        li a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            display: block;
        }
        li a:hover {
            color: #2980b9;
        }

        .back-btn {
            display: inline-block;
            width: 200px;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .back-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>SUBJECTIC SECURITY</h1>

    <ul>
        <li><a href="apply_for_certificate.php">Apply For Certificate</a></li>
        <li><a href="apply_for_bonafide.php">Apply For Bonafide</a></li>
        <li><a href="railway_concession_form.php">Railway Concession Form</a></li>
        <li><a href="apply_for_admission.php">Apply For Admission</a></li>
        <li><a href="cancellation.php">Cancellation</a></li>
        <li><a href="apply_for_grievance.php">Apply For Grievance</a></li>
        <li><a href="insurance_policy.php">Insurance Policy</a></li>
        <li><a href="scholarship_details.php">Scholarship Details Entry</a></li>
        <li><a href="apply_for_hostel.php">Apply For Hostel</a></li>
        <li><a href="no_dues_certificate.php">No Dues Certificate</a></li>
    </ul>

    <!-- Example form for applying for a certificate -->
    <?php
    // Handle form submission for applying for a certificate
    if (isset($_POST['apply_certificate'])) {
        $certificate_type = $_POST['certificate_type'];

        // Process the data here, for example, save it to the database or perform an action
        echo "<p>Your application for a '$certificate_type' certificate has been submitted.</p>";

        // Here you could add logic for storing this info in the database or sending a confirmation email
    }
    ?>

    <!-- Back Button -->
    <a href="dashboard_student.php" class="back-btn">Back to Dashboard</a> <!-- Adjust the path to your dashboard page -->
</body>
</html>
