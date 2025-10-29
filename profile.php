<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch student's profile data using the correct column (assuming 'username')
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$studentData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$studentData) {
    die("Student data not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <style>
        /* Reset and general body styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Main container styling */
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        /* Title Styling */
        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        /* Profile Header Styling (Image and Name) */
        .profile-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            text-align: center;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #4CAF50;
            margin-right: 20px;
            transition: transform 0.3s ease;
        }

        .profile-header img:hover {
            transform: scale(1.1);
        }

        .profile-header h2 {
            font-size: 26px;
            color: #333;
            font-weight: bold;
        }

        .profile-header p {
            color: #777;
            font-size: 16px;
        }

        /* Information Section */
        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 5px solid #4CAF50;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .info-section label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .info-section p {
            color: #555;
            font-size: 16px;
        }

        /* Edit Button Styling */
        .edit-button {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        /* Form Section Styling */
        .form-section {
            margin-top: 20px;
            display: none;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 8px;
            font-size: 16px;
            transition: border 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #4CAF50;
        }

        .form-section label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-top: 12px;
        }

        .form-section textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-section button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            width: 100%;
            font-size: 18px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .form-section button:hover {
            background-color: #45a049;
        }
        
        /* Media Query for small screens */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-header img {
                margin-bottom: 15px;
            }

            .container {
                padding: 20px;
            }

            .info-section {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Profile</h1>

        <!-- Profile Header Section -->
        <div class="profile-header">
            <img src="https://via.placeholder.com/120" alt="Profile Picture">
            <div>
                <h2><?php echo htmlspecialchars($studentData['full_name']); ?></h2>
                <p>TYBISQT SBM 9</p>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="info-section">
            <label for="studentId">Student ID:</label>
            <p><?php echo htmlspecialchars($studentData['student_id']); ?></p>
        </div>

        <div class="info-section">
            <label for="rollNo">Roll No:</label>
            <p><?php echo htmlspecialchars($studentData['roll_no']); ?></p>
        </div>

        <div class="info-section">
            <label for="prnNumber">PRN Number:</label>
            <p><?php echo htmlspecialchars($studentData['prn_number']); ?></p>
        </div>

        <div class="info-section">
            <label for="fullName">Full Name:</label>
            <p><?php echo htmlspecialchars($studentData['full_name']); ?></p>
        </div>

        <div class="info-section">
            <label for="dob">Date of Birth:</label>
            <p><?php echo htmlspecialchars($studentData['date_of_birth']); ?></p>
        </div>

        <div class="info-section">
            <label for="email">Email Address:</label>
            <p><?php echo htmlspecialchars($studentData['email']); ?></p>
        </div>

        <div class="info-section">
            <label for="contact">Phone Number:</label>
            <p><?php echo htmlspecialchars($studentData['contact']); ?></p>
        </div>

        <div class="info-section">
            <label for="address">Address:</label>
            <p><?php echo htmlspecialchars($studentData['address']); ?></p>
        </div>

        <!-- Edit Button -->
        <button class="edit-button" onclick="toggleEditForm()">Edit Profile</button>

        <!-- Edit Form Section -->
        <div class="form-section" id="editProfileForm">
            <form action="update_profile.php" method="POST">
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($studentData['full_name']); ?>" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($studentData['dob']); ?>" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($studentData['email']); ?>" required>

                <label for="contact">Phone Number:</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($studentData['contact']); ?>" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($studentData['address']); ?></textarea>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function toggleEditForm() {
            const form = document.getElementById('editProfileForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
