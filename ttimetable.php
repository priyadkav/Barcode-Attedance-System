<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Teacher's Timetable - Today</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fb;
      background-image: url('image6.jpg');
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1000px;
      margin: 30px auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
    }

    h1 {
      text-align: center;
      font-size: 28px;
      color: #2c3e50;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th, table td {
      padding: 12px;
      text-align: center;
      font-size: 16px;
      color: #555;
      border: 1px solid #ddd;
    }

    table th {
      background-color: #2c3e50;
      color: white;
      font-weight: bold;
    }

    table td {
      background-color: #f9f9f9;
    }

    table tr:nth-child(even) td {
      background-color: #f1f1f1;
    }

    .no-classes {
      font-size: 18px;
      color: #e74c3c;
      text-align: center;
      margin-top: 30px;
    }

    .back-btn {
      margin-top: 30px;
      padding: 12px 24px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      align-self: center;
      text-decoration: none;
      text-align: center;
      transition: background-color 0.3s;
    }

    .back-btn:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Teacher's Timetable - Today's Classes</h1>

    <div id="timetableContainer">
      <table id="timetableTable">
        <thead>
          <tr>
            <th>Time</th>
            <th>Subject</th>
            <th>Room</th>
          </tr>
        </thead>
        <tbody id="timetableBody">
          <!-- Rows will be dynamically populated here -->
        </tbody>
      </table>

      <div id="noClasses" class="no-classes" style="display:none;">
        No classes scheduled for today.
      </div>
    </div>

    <!-- Back to Dashboard Button -->
    <button class="back-btn" onclick="window.location.href='dashboard_teacher.php'">
      ← Back to Dashboard
    </button>
  </div>

  <script>
    const timetable = {
      "Monday": [
        { time: '9:00 AM - 10:00 AM', subject: 'Mathematics', room: '101' },
        { time: '10:30 AM - 12:00 PM', subject: 'Physics',     room: '102' },
        { time: '1:00 PM - 2:00 PM',  subject: 'Computer Science', room: '103' }
      ],
      "Tuesday": [
        { time: '7:30 AM - 09:30 AM', subject: 'STQA', room: '301' },
        { time: '10:00 AM - 12:00 PM', subject: 'C++', room: '202' },
        { time: '12:00 PM - 1:00 PM', subject: 'BIDA', room: '203' },
        { time: '1:30 PM - 2:00 PM', subject: 'PYTHON', room: '204' }
      ],
      "Wednesday": [
        { time: '9:00 AM - 10:00 AM', subject: 'English', room: '301' },
        { time: '10:30 AM - 12:00 PM', subject: 'Physics', room: '302' }
      ],
      "Thursday": [
        { time: '11:00 AM - 12:00 PM', subject: 'Chemistry', room: '401' },
        { time: '2:00 PM - 3:00 PM', subject: 'Math', room: '402' }
      ],
      "Friday": [
        { time: '9:00 AM - 10:00 AM', subject: 'Computer Science', room: '501' },
        { time: '10:30 AM - 12:00 PM', subject: 'Engineering', room: '502' }
      ]
    };

    const daysOfWeek = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    const currentDay = daysOfWeek[new Date().getDay()];
    const classes = timetable[currentDay] || [];

    const table = document.getElementById('timetableTable');
    const body  = document.getElementById('timetableBody');
    const noCls = document.getElementById('noClasses');

    if (!classes.length) {
      table.style.display = 'none';
      noCls.style.display = 'block';
    } else {
      classes.forEach(c => {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${c.time}</td><td>${c.subject}</td><td>${c.room}</td>`;
        body.appendChild(row);
      });
    }
  </script>

</body>
</html>
