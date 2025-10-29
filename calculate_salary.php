<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Calculation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('image6.jpg'); 
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        .info {
            margin-bottom: 15px;
        }
        .info span {
            font-weight: bold;
            color: #333;
        }
        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e0f7fa;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Salary Calculation</h1>

    <!-- Predefined salary info -->
    <div class="info">
        <p><span>Base Salary:</span> ₹<span id="baseSalaryDisplay">30000</span></p>
        <p><span>Bonus:</span> ₹<span id="bonusDisplay">5000</span></p>
        <p><span>Deductions:</span> ₹<span id="deductionsDisplay">2000</span></p>
        <p><span>Working Days:</span> <span id="workingDaysDisplay">22</span> days</p>
    </div>

    <button type="button" onclick="calculateSalary()">Calculate Salary</button>

    <!-- Result Section -->
    <div id="result" class="result" style="display: none;">
        <p><strong>Total Salary:</strong> ₹<span id="totalSalary"></span></p>
    </div>
</div>

<script>
    function calculateSalary() {
        // Predefined values in INR
        var baseSalary = parseFloat(document.getElementById("baseSalaryDisplay").textContent);
        var bonus = parseFloat(document.getElementById("bonusDisplay").textContent);
        var deductions = parseFloat(document.getElementById("deductionsDisplay").textContent);
        var workingDays = parseInt(document.getElementById("workingDaysDisplay").textContent);

        // Calculate daily rate
        var dailyRate = baseSalary / 30;  // Assuming 30 days in a month
        var totalSalary = (dailyRate * workingDays) + bonus - deductions;

        // Display result
        document.getElementById("totalSalary").textContent = totalSalary.toFixed(2);
        document.getElementById("result").style.display = "block";
    }
</script>

</body>
</html>
