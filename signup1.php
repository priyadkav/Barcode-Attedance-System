<?php
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

    $username = trim($_POST['username']);
    $password_raw = $_POST['password'];
    $role = $_POST['role'];

    // === Updated Validation (Username: Letters + Optional Numbers) ===
    if (!preg_match('/^[a-zA-Z]+[0-9]*$/', $username)) {
        $error_message = "❌ Username must start with letters and can include numbers (e.g., john123).";
    } elseif (strlen($password_raw) < 8) {
        $error_message = "❌ Password must be at least 8 characters.";
    } elseif (!in_array($role, ['student', 'teacher', 'parent', 'non-staff', 'admin'])) {
        $error_message = "❌ Invalid role selected.";
    } else {
        $password = password_hash($password_raw, PASSWORD_BCRYPT);

        try {
            $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $check->execute([$username]);

            if ($check->rowCount() > 0) {
                $error_message = "❌ This username is already taken.";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->execute([$username, $password, $role]);

                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            $error_message = "❌ Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('image1.jpg') no-repeat center center fixed; /* Background Image */
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
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            margin-bottom: 1.2rem;
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
        input[type="password"],
        select {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
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
        }

        a:hover {
            color: #2575fc;
        }

        .error-message {
            background-color: #ffe0e0;
            color: #d8000c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>

        <?php if (!empty($error_message)) : ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="e.g., john123">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="parent">Parent</option>
                <option value="non-staff">Non-Staff</option>
                <option value="admin">Admin</option> <!-- ✅ Added Admin -->
            </select>

            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
