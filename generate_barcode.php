<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $barcodeContent = "ATTENDANCE:" . $subject . ":" . time(); // Unique barcode content

    try {
        // Save barcode data in the database
        $stmt = $conn->prepare("INSERT INTO barcodes (teacher_id, subject, barcode_content) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $subject, $barcodeContent]);

        // Include the phpqrcode library
        include 'C:/xampp/htdocs/barcode/phpqrcode-2010100721_1.1.4 (3)/phpqrcode/qrlib.php'; // Correct path

        // Generate barcode and save it as an image
        $barcodeFile = 'barcodes/' . uniqid() . '.png'; // Save barcode as an image
        QRcode::png($barcodeContent, $barcodeFile);

        echo "Barcode Generated: <img src='$barcodeFile' alt='Barcode'>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Generate Barcode</h2>
        <form method="POST">
            <label for="subject">Subject:</label>
            <select id="subject" name="subject">
                <option value="math">Math</option>
                <option value="science">Science</option>
                <option value="history">History</option>
            </select>
            <button type="submit">Generate Barcode</button>
        </form>
        <a href="dashboard_teacher.php">Back to Dashboard</a>
    </div>
</body>
</html>