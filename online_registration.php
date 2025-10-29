<?php
$successMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $courses = isset($_POST['course']) ? $_POST['course'] : [];

    // Normally you'd save to a database here

    $successMessage = "✅ Saved successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Course Registration Form</title>
    <style>
        body {
            
            background-image: url('image6.jpg'); 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            border: 1px solid #ddd;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
            font-size: 1.8em;
            font-weight: bold;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: normal;
            font-size: 1em;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.4);
        }

        .course-options {
            margin-bottom: 20px;
        }

        .course-options label {
            display: block;
            margin-bottom: 12px;
            font-size: 1em;
            color: #555;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .success-message {
            margin-top: 20px;
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .back-btn {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            margin-top: 10px;
        }

        .back-btn:hover {
            background-color: #45a049;
        }

        @media (max-width: 500px) {
            .form-container {
                padding: 20px;
                width: 90%;
            }

            h2 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Online Course Registration</h2>
        <form method="post">
            <!-- Personal Details -->
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter your full name">

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email address">

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required placeholder="Enter your phone number">

            <!-- Course Selection -->
            <div class="course-options">
                <label>Select Courses:</label>
                <label><input type="checkbox" name="course[]" value="web-development"> Web Development</label>
                <label><input type="checkbox" name="course[]" value="data-science"> Data Science</label>
                <label><input type="checkbox" name="course[]" value="machine-learning"> Machine Learning</label>
                <label><input type="checkbox" name="course[]" value="digital-marketing"> Digital Marketing</label>
                <label><input type="checkbox" name="course[]" value="graphic-design"> Graphic Design</label>
            </div>

            <!-- Submit Button -->
            <input type="submit" value="Register">
        </form>

        <?php if (!empty($successMessage)) : ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <!-- Back Button -->
        <a href="dashboard_student.php" class="back-btn">Back to Dashboard</a> <!-- Adjust the path to your dashboard page -->
    </div>

</body>
</html>
