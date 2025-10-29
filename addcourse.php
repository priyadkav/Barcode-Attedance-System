<?php
session_start();
require 'db.php';

// Only allow admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Add new course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseName = trim($_POST['course']);
    if (!empty($courseName)) {
        try {
            $stmt = $conn->prepare("INSERT INTO detail (course) VALUES (?)");
            $stmt->execute([$courseName]);
            $_SESSION['success'] = "Course added successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Course already exists or error occurred.";
        }
        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Delete a course
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $conn->prepare("DELETE FROM detail WHERE id = ?")->execute([$deleteId]);
    $_SESSION['success'] = "Course deleted successfully!";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch courses
$courses = $conn->query("SELECT * FROM detail ORDER BY course ASC")->fetchAll(PDO::FETCH_ASSOC);

// Get and clear flash messages
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image:url("image6.jpg");
            padding: 30px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        .form-group {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #ecf0f1;
        }
        a.delete-link {
            color: red;
            text-decoration: none;
        }
        a.delete-link:hover {
            text-decoration: underline;
        }
        .btn-dashboard {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn-dashboard:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Courses</h2>

        <?php if ($success): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Add New Course</label>
                <input type="text" name="course" placeholder="Enter course name" required>
            </div>
            <button type="submit">Add Course</button>
        </form>

        <!-- Courses Table -->
        <h3 style="margin-top: 40px;">Available Courses</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($courses) > 0): ?>
                    <?php foreach ($courses as $i => $course): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($course['course']) ?></td>
                            <td>
                                <a href="?delete=<?= $course['id'] ?>" class="delete-link" onclick="return confirm('Are you sure to delete this course?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align: center;">No courses found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="dashboard_admin.php" class="btn-dashboard">Back to Dashboard</a>
    </div>
</body>
</html>