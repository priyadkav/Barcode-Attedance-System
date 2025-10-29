<?php
// Define an array with course details - Indian context (Mumbai University style)
$subjects = [
    [
        'subject_name' => 'Data Structures',
        'subject_code' => 'CSC401',
        'instructor' => 'Dr. Anjali Mehta',
        'credits' => 4,
        'schedule' => 'Monday, Wednesday, Friday - 10:00 AM to 12:00 PM',
        'location' => 'Room 201, Kalina Campus'
    ],
    [
        'subject_name' => 'Database Management Systems',
        'subject_code' => 'CSC402',
        'instructor' => 'Prof. Rajeev Patil',
        'credits' => 4,
        'schedule' => 'Tuesday, Thursday - 9:00 AM to 11:00 AM',
        'location' => 'Lab 3, Computer Science Dept., Kalina Campus'
    ],
    [
        'subject_name' => 'Operating Systems',
        'subject_code' => 'CSC403',
        'instructor' => 'Dr. Neha Shah',
        'credits' => 3,
        'schedule' => 'Monday, Wednesday - 2:00 PM to 4:00 PM',
        'location' => 'Room 105, Fort Campus'
    ],
    [
        'subject_name' => 'Computer Networks',
        'subject_code' => 'CSC404',
        'instructor' => 'Dr. Arjun Rane',
        'credits' => 3,
        'schedule' => 'Tuesday, Thursday - 11:00 AM to 1:00 PM',
        'location' => 'Room 302, Kalina Campus'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mumbai University - Even Semester Courses</title>
    <style>
         body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #fffdf2;
            background-image: url('image6.jpg');  
        }

        h1 {
            color: #b22222;
            text-align: center;
            margin-top: 20px;
        }

        .intro {
            text-align: center;
            font-size: 1.1em;
            color: #333;
            margin-bottom: 10px;
        }

        .subject-container {
            max-width: 900px;
            margin: 20px auto;
        }

        .subject-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .subject-card h2 {
            color: #4CAF50;
            font-size: 1.5em;
        }

        .subject-card .details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 1.1em;
        }

        .subject-card .details span {
            margin: 5px 0;
        }

        .subject-card .credits {
            font-weight: bold;
            color: #4CAF50;
        }

        .subject-card .schedule {
            font-style: italic;
            color: #888;
        }

        .subject-card .location,
        .subject-card .instructor {
            font-weight: bold;
            color: #333;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border-radius: 5px;
            text-decoration: none;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        .back-btn:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

    <h1>📚 Even Semester Subjects - Semester 4</h1>
    <p class="intro">Welcome to your academic journey at <strong>Mumbai University</strong>! Here are your subjects for this semester:</p>

    <div class="subject-container">
        <?php foreach ($subjects as $subject): ?>
        <div class="subject-card">
            <div class="details">
                <h2>📘 <?php echo $subject['subject_name']; ?></h2>
                <span>📎 Subject Code: <?php echo $subject['subject_code']; ?></span>
                <span class="instructor">👨‍🏫 Instructor: <?php echo $subject['instructor']; ?></span>
                <span class="credits">🎓 Credits: <?php echo $subject['credits']; ?></span>
                <span class="schedule">🕒 Schedule: <?php echo $subject['schedule']; ?></span>
                <span class="location">📍 Location: <?php echo $subject['location']; ?></span>
            </div>
        </div>
        <?php endforeach; ?>

        <a href="dashboard_student.php" class="back-btn">🔙 Back to Dashboard</a>
    </div>

</body>
</html>
