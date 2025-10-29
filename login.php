<?php
session_start(); // Start session at the beginning

$error_message = ''; // Default empty error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php'; // Database connection

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // === Server-side validation ===
    if (!preg_match('/^[a-zA-Z]+[0-9]*$/', $username)) {
        $error_message = "❌ Username must start with letters and can include numbers (e.g., john123).";
    } elseif (strlen($password) < 8) {
        $error_message = "❌ Password must be at least 8 characters.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Role-based redirect
            switch ($user['role']) {
                case 'student':
                    header("Location: dashboard_student.php");
                    exit();
                case 'teacher':
                    header("Location: dashboard_teacher.php");
                    exit();
                case 'parent':
                    header("Location: dashboard_parent.php");
                    exit();
                case 'non-staff':
                    header("Location: dashboard_nonstaff.php");
                    exit();
                case 'admin':
                    header("Location:dashboard_admin.php");
                default:
                    $error_message = "❌ Invalid role.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('image1.jpg') no-repeat center center fixed;
            background-size: cover; /* Ensure the background image covers the entire screen */
            color: #333;
        }

        .container {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent background for container */
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 2rem;
            font-weight: 600;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: 500;
            color: #555;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #6a11cb;
        }

        button {
            padding: 0.75rem;
            background: #6a11cb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: #2575fc;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        p {
            margin-top: 1.5rem;
            color: #555;
        }

        a {
            color: #6a11cb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #2575fc;
        }

        .error-message {
            background-color: #ffe0e0;
            color: #d8000c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.95rem;
        }
    </style>

    <script>
        function validateForm() {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const usernamePattern = /^[a-zA-Z]+[0-9]*$/; // Letters + optional numbers

            if (!usernamePattern.test(username)) {
                alert("Username must start with letters and can include numbers (e.g., john123).");
                return false;
            }

            if (password.length < 8) {
                alert("Password must be at least 8 characters.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (!empty($error_message)) : ?>
            <div class="error-message">
                <span>❌</span> <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateForm()">
            <label for="username">Username:</label> <!-- Changed from "Email" to "Username" -->
            <input type="text" id="username" name="username" required placeholder="e.g., john123">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="signup1.php">Sign up</a></p>
    </div>
</body>
</html>
