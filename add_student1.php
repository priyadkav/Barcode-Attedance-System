<?php
session_start();
require 'db.php';

// Teacher authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullName = $_POST['full_name'];
    $userName = $_POST['username'];
    $rollNo = $_POST['roll_no'];
    $course = $_POST['course'];
    $dob = $_POST['dob'];
    $prnNumber = $_POST['prn_number'];
    $gender = $_POST['gender'] ?? null;
    $fatherName = $_POST['father_name'] ?? null;
    $motherName = $_POST['mother_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $parentUsername = $_POST['parent_username'] ?? null;
    $address = $_POST['address'] ?? null;
    $teacherId = $_SESSION['user_id'];

    // Insert into DB
    try {
        $stmt = $conn->prepare("INSERT INTO detail (
            full_name, username, roll_no, course, dob, prn_number, gender, father_name, mother_name,
            parent_username, email, phone, address
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $fullName, $userName, $rollNo, $course, $dob, $prnNumber, $gender,
            $fatherName, $motherName, $parentUsername, $email, $phone, $address
        ]);
        
        $success = "Student added successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Student</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
           
            background-image:url("image6.jpg");
            padding: 20px;
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
            background-color: #3498db; /* Blue color as used previously */
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
            background-color: #2980b9; /* Darker blue when hovered */
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
            background-color: #3498db; /* Same Blue color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            width: 60%;
            margin: auto; /* Full width for Back to Dashboard button */
        }
        .btn-back:hover {
            background-color: #2980b9; /* Darker blue on hover */
        }
        .btn-add {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db; /* Same Blue color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            width: 48%; /* Adjust width to fit both buttons in the row */
        }
        .btn-add:hover {
            background-color: #2980b9; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Student</h1>

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
                <label>Roll Number</label>
                <input type="text" name="roll_no" required>
            </div>

            <div class="form-group">
                <label>Course</label>
                <select name="course" required>
                    <option value="">Select Course</option>
                    <option value="B.Tech">B.Tech</option>
                    <option value="BScIT">BScIT</option>
                    <option value="BBA">BBA</option>
                    <option value="BCA">BCA</option>
                    <option value="MBA">MBA</option>
                    <option value="MCA">MCA</option>
                </select>
            </div>

            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" required>
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
                <label>PRN Number</label>
                <input type="text" name="prn_number" required>
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
                <label>Father's Name</label>
                <input type="text" name="father_name">
            </div>

            <div class="form-group">
                <label>Mother's Name</label>
                <input type="text" name="mother_name">
            </div>
            <div class="form-group">
    <label>Parent Username</label>
    <input type="text" name="parent_username" required>
</div>

            

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3"></textarea>
            </div>

            <button type="submit">Add New Record</button>
        </form>
            <br>
        <!-- Buttons in a single row -->
        <div class="button-container">
            <a href="dashboard_admin.php" class="btn-back">Back to Dashboard</a>
            
        </div>
    </div>
</body>
</html>