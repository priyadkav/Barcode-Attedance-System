<?php
// Check if the form is submitted
$showSuccessMessage = false;
$showErrorMessage = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect the form data
    $name = htmlspecialchars($_POST['name']);
    $studentID = htmlspecialchars($_POST['studentID']);
    $course = htmlspecialchars($_POST['course']);
    $feedbackType = htmlspecialchars($_POST['feedbackType']);
    $courseRating = htmlspecialchars($_POST['courseRating']);
    $comments = htmlspecialchars($_POST['comments']);

    // Simulated submission logic
    $successMessage = "🎉 Thank you for your feedback!";
    $errorMessage = "❌ There was an issue submitting your feedback. Please try again.";

    // Basic validation
    if (!empty($name) && !empty($studentID) && !empty($course) && !empty($feedbackType) && !empty($comments)) {
        $showSuccessMessage = true;

        // You can insert this data into a database here
        // Example: INSERT INTO feedback (name, studentID, course, feedbackType, courseRating, comments) VALUES (...)

        // Optionally: clear POST data
        $_POST = [];
    } else {
        $showErrorMessage = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form - Student Portal</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('image6.jpg');  
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .feedback-form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }

        .feedback-form h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 1.1em;
            color: #333;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group .rating {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .rating label {
            font-size: 1.5em;
            cursor: pointer;
        }

        .submit-btn, .back-btn {
            width: 48%;
            padding: 12px;
            font-size: 1.2em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .back-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .back-btn:hover {
            background-color: #45a049;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .back-btn {
            margin-left: 10px;
        }

        .success-message {
            color: green;
            font-size: 1.2em;
            text-align: center;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            font-size: 1.2em;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>📋 Feedback Form</h1>

    <div class="feedback-form">
        <h2>Your Feedback Matters</h2>
        
        <?php if ($showSuccessMessage): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php elseif ($showErrorMessage): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (!$showSuccessMessage): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name" value="<?php echo isset($name) ? $name : ''; ?>">
            </div>
            <div class="form-group">
                <label for="studentID">Student ID</label>
                <input type="text" id="studentID" name="studentID" required placeholder="Enter your student ID" value="<?php echo isset($studentID) ? $studentID : ''; ?>">
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" id="course" name="course" required placeholder="Enter your course name" value="<?php echo isset($course) ? $course : ''; ?>">
            </div>
            <div class="form-group">
                <label for="feedbackType">Feedback Type</label>
                <select id="feedbackType" name="feedbackType" required>
                    <option value="">-- Select Type --</option>
                    <option value="General" <?php echo (isset($feedbackType) && $feedbackType == 'General') ? 'selected' : ''; ?>>General Feedback</option>
                    <option value="Suggestion" <?php echo (isset($feedbackType) && $feedbackType == 'Suggestion') ? 'selected' : ''; ?>>Suggestion</option>
                    <option value="Complaint" <?php echo (isset($feedbackType) && $feedbackType == 'Complaint') ? 'selected' : ''; ?>>Complaint</option>
                </select>
            </div>
            <div class="form-group">
                <label>Course Rating</label>
                <div class="rating">
                    <label>⭐</label>
                    <label>⭐⭐</label>
                    <label>⭐⭐⭐</label>
                    <label>⭐⭐⭐⭐</label>
                    <label>⭐⭐⭐⭐⭐</label>
                </div>
                <input type="range" id="courseRating" name="courseRating" min="1" max="5" step="1" value="<?php echo isset($courseRating) ? $courseRating : '3'; ?>">
            </div>
            <div class="form-group">
                <label for="comments">Additional Comments</label>
                <textarea id="comments" name="comments" rows="4" placeholder="Write your feedback or suggestions here..."><?php echo isset($comments) ? $comments : ''; ?></textarea>
            </div>

            <div class="button-container">
                <button type="submit" class="submit-btn">Submit Feedback</button>
                <a href="dashboard_student.php" class="back-btn">Back to Dashboard</a>
            </div>
        </form>
        <?php endif; ?>
    </div>

</body>
</html>
