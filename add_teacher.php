<?php
session_start();
require 'db.php';

// Admin authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $dob = $_POST['dob'] ?? null;
    $department = $_POST['department'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $address = $_POST['address'] ?? null;

    try {
        $stmt = $conn->prepare("INSERT INTO teachers (
            full_name, username, email, phone, dob, department, gender, address
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $fullName, $username, $email, $phone, $dob, $department, $gender, $address
        ]);

        $success = "Teacher added successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Teacher</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            background-image:url("image6.jpg");
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }
        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .radio-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        button {
            width: 60%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            margin: auto;
            display: block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #2980b9;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .btn-back {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            width: 60%;
            margin: auto;
        }
        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Teacher</h1>

        <?php if (isset($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone">
            </div>

            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob">
            </div>

            <div class="form-group">
                <label>Department</label>
                <select name="department" required>
                    <option value="">Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Business">Business</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Male" required> Male</label>
                    <label><input type="radio" name="gender" value="Female" required> Female</label>
                    <label><input type="radio" name="gender" value="Other" required> Other</label>
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3"></textarea>
            </div>

            <button type="submit">Add Teacher</button>
        </form>

        <br>
        <div class="button-container">
            <a href="dashboard_admin.php" class="btn-back">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
