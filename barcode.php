<?php
// generate_barcode.php
date_default_timezone_set('Asia/Kolkata');
$dateToday = date('Y-m-d');
$timeNow = date('H:i:s');

$encodedData = '';
$teacher = '';
$subject = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teacher']) && isset($_POST['subject'])) {
    // Get input data from the form
    $teacher = htmlspecialchars($_POST['teacher']);
    $subject = htmlspecialchars($_POST['subject']);
    
    // Prepare the data to encode in the QR code
    $qrData = array(
        "teacher" => $teacher,
        "subject" => $subject,
        "date" => $dateToday,
        "timestamp" => $timeNow
    );
    
    // Encode the data as JSON, then base64 encode
    $encodedData = base64_encode(json_encode($qrData));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        .qr-image {
            margin-top: 20px;
            text-align: center;
        }
        .qr-image img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background: white;
        }
        .details {
            margin-top: 15px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #4CAF50;
        }
        .details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Generate QR Code for Attendance</h2>
    <form method="post" action="">
        <label>Subject Teacher Name</label>
        <input type="text" name="teacher" required placeholder="Enter subject teacher name">
        
        <label>Subject</label>
        <input type="text" name="subject" required placeholder="Enter subject">
        
        <button type="submit">Generate QR Code</button>
    </form>

    <?php if (!empty($encodedData)) : ?>
        <div class="qr-image">
            <h3>Generated QR Code</h3>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?php echo urlencode($encodedData); ?>" alt="QR Code">
        </div>
        <div class="details">
            <h3>QR Code Details:</h3>
            <p><strong>Teacher:</strong> <?php echo htmlspecialchars($teacher); ?></p>
            <p><strong>Subject:</strong> <?php echo htmlspecialchars($subject); ?></p>
            <p><strong>Date:</strong> <?php echo $dateToday; ?></p>
            <p><strong>Time:</strong> <?php echo $timeNow; ?></p>
            <p><strong>Encoded Data:</strong> <code><?php echo $encodedData; ?></code></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>