<!DOCTYPE html>
<html>
<head>
    <title>Manage Subjects</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
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
        form, table {
            margin-top: 25px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 25px;
            background-color: #3498db;
            border: none;
            color: white;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 35px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-btns a {
            margin-right: 10px;
            color: #3498db;
            text-decoration: none;
        }
        .action-btns a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Subjects</h2>

    <!-- Add Subject Form -->
    <form>
        <div class="form-group">
            <label>Subject Name</label>
            <input type="text" name="subject_name" required>
        </div>
        <div class="form-group">
            <label>Course</label>
            <input type="text" name="course" required>
        </div>
        <div class="form-group">
            <label>Semester</label>
            <select name="semester" required>
                <option value="">Select Semester</option>
                <option value="Sem 1">Sem 1</option>
                <option value="Sem 2">Sem 2</option>
                <option value="Sem 3">Sem 3</option>
                <option value="Sem 4">Sem 4</option>
                <option value="Sem 5">Sem 5</option>
                <option value="Sem 6">Sem 6</option>
            </select>
        </div>
        <button type="submit">Add Subject</button>
    </form>

    <!-- Subjects Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Subject Name</th>
                <th>Course</th>
                <th>Semester</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row (static) -->
            <tr>
                <td>1</td>
                <td>Mathematics</td>
                <td>BCA</td>
                <td>Sem 1</td>
                <td class="action-btns">
                    <a href="#">Edit</a>
                    <a href="#">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
