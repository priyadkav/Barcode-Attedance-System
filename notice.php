<!DOCTYPE html>
<html>
<head>
    <title>Manage Events & Notices</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image:url("image6.jpg");
            padding: 30px;
        }
        .container {
            max-width: 800px;
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
            margin-bottom: 15px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #ecf0f1;
        }
        .delete-link {
            color: red;
            text-decoration: none;
        }
        .delete-link:hover {
            text-decoration: underline;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }
        .back-btn a {
            background: #3498db;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-btn a:hover {
            background: #2980b9;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            display: none;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Events & Notices</h2>

        <div class="success-message" id="successMessage">Event/Notice added successfully!</div>

        <form id="eventForm">
            <div class="form-group">
                <label>Type</label>
                <select id="type" required>
                    <option value="">--Select--</option>
                    <option value="Event">Event</option>
                    <option value="Notice">Notice</option>
                </select>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="title" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea id="description" rows="3" placeholder="Enter description" required></textarea>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" id="date" required>
            </div>
            <button type="submit">Add</button>
        </form>

        <h3 style="margin-top: 40px;">All Events & Notices</h3>
        <table id="eventsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Entries will appear here -->
            </tbody>
        </table>

        <div class="back-btn">
            <a href="dashboard_admin.html">Back to Dashboard</a>
        </div>
    </div>

    <script>
        let count = 0;

        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const type = document.getElementById('type').value;
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const date = document.getElementById('date').value;

            if (type && title && description && date) {
                count++;

                const table = document.getElementById('eventsTable').getElementsByTagName('tbody')[0];
                const newRow = table.insertRow();

                newRow.innerHTML = `
                    <td>${count}</td>
                    <td>${type}</td>
                    <td>${title}</td>
                    <td>${description}</td>
                    <td>${date}</td>
                    <td><a href="#" class="delete-link" onclick="deleteRow(this)">Delete</a></td>
                `;

                // Show success message
                const successMsg = document.getElementById('successMessage');
                successMsg.style.display = 'block';
                setTimeout(() => successMsg.style.display = 'none', 3000);

                // Reset form
                document.getElementById('eventForm').reset();
            }
        });

        function deleteRow(link) {
            const row = link.closest('tr');
            row.remove();
            // Recalculate numbers
            const rows = document.querySelectorAll('#eventsTable tbody tr');
            count = 0;
            rows.forEach((r, i) => r.cells[0].innerText = ++count);
        }
    </script>
</body>
</html>
