<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: nonstaff_login.php");
    exit();
}

// Database connection (using PDO)
include 'db.php';  // Include your PDO connection

// Fetch the current user's details using PDO
$username = $_SESSION['username'];  // Using username as the identifier
$sql = "SELECT * FROM nonstaff_detail WHERE username = :username";  // Query with username as the key
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);  // Bind the username parameter
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle profile update
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $update_sql = "UPDATE nonstaff_detail SET full_name = :full_name, email = :email, contact = :contact, address = :address WHERE username = :username";
    $update_stmt = $conn->prepare($update_sql);

    // Bind parameters using bindParam for PDO
    $update_stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $update_stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $update_stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
    $update_stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $update_stmt->bindParam(':username', $username, PDO::PARAM_STR);  // Bind the username for update

    if ($update_stmt->execute()) {
        $_SESSION['message'] = "Profile updated successfully!";
    } else {
        $_SESSION['message'] = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Non-Staff Profile - College</title>
    <style>
        /* Example styles for layout */
        body {
            font-family: Arial, sans-serif;
            background-image: url('image6.jpg'); 
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .profile-info {
            margin-bottom: 30px;
            text-align: center;
        }

        .profile-info h2 {
            color: #2c3e50;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
        }

        input, textarea {
            padding: 10px;
            font-size: 14px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .options {
            text-align: center;
            margin-top: 30px;
        }

        .options .option {
            display: inline-block;
            margin: 10px;
            background-color: #3498db;
            padding: 10px 20px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
        }

        .options .option:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Non-Staff Profile</h1>

    <!-- Display any message after update -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>

    <!-- Profile Information -->
    <div class="profile-info">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <p>Session: 2024-2025</p>
        <p>Role: Non-Staff</p>
    </div>

    <!-- Profile Form -->
    <form action="nprofile.php" method="POST">
        <div>
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>
        <div>
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div>
            <label for="contact">Phone Number:</label>
            <input type="text" name="contact" id="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
        </div>
        <div>
            <label for="address">Address:</label>
            <textarea name="address" id="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>
        
    </form>

    <!-- Other Options -->
    <div class="options">
        <a class="option" href="dashboard_nonstaff.php">Back To Dashboard</a>
    </div>
</div>

</body>
</html>
