<?php
// Sample data (this would normally come from a database or form submission)
$receipt_number = "12345";
$date = "20th February 2025";
$student_id = "S202400123";
$fees_breakdown = [
    ["fee_type" => "Tuition Fees", "amount" => 30000],
    ["fee_type" => "Hostel Fees", "amount" => 12000],
    ["fee_type" => "Examination Fees", "amount" => 2500],
    ["fee_type" => "Library Fees", "amount" => 1000],
    ["fee_type" => "Other Fees", "amount" => 500]
];

$total_amount = 0;
foreach ($fees_breakdown as $fee) {
    $total_amount += $fee['amount'];
}

$payment_status = "Paid";
$payment_method = "Credit Card";
$payment_date = "20th February 2025";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Receipt - Student Portal</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('image6.jpg');  
          
        }

        h1, h2 {
            color: #333;
        }

        .receipt {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            padding: 20px;
            max-width: 800px;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            margin-bottom: 20px;
        }

        .receipt-header h2 {
            color: #4CAF50;
            margin: 0;
        }

        .receipt-header p {
            font-size: 1.1em;
            margin: 5px 0;
        }

        .fees-breakdown {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .fees-breakdown th, .fees-breakdown td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .fees-breakdown th {
            background-color: #4CAF50;
            color: white;
        }

        .fees-breakdown .total {
            font-weight: bold;
        }

        .receipt-footer {
            margin-top: 30px;
            text-align: center;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .center-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="receipt">
        <div class="receipt-header">
            <h2>Fees Receipt</h2>
            <p><strong>Receipt Number:</strong> <?php echo $receipt_number; ?></p>
            <p><strong>Date:</strong> <?php echo $date; ?></p>
        </div>

        <!-- Student Information -->
        <h2>Student Information</h2>
        <p><strong>Student ID:</strong> <?php echo $student_id; ?></p>
        
        <!-- Fees Breakdown -->
        <h2>Fees Breakdown</h2>
        <table class="fees-breakdown">
            <thead>
                <tr>
                    <th>Fee Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees_breakdown as $fee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fee['fee_type']); ?></td>
                        <td>₹<?php echo number_format($fee['amount']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="total">Total Amount</td>
                    <td class="total">₹<?php echo number_format($total_amount); ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Payment Status -->
        <h2>Payment Status</h2>
        <p><strong>Status:</strong> <?php echo $payment_status; ?></p>
        <p><strong>Payment Method:</strong> <?php echo $payment_method; ?></p>
        <p><strong>Payment Date:</strong> <?php echo $payment_date; ?></p>

        <!-- Footer -->
        <div class="receipt-footer">
            <a href="javascript:window.print()" class="btn">Print Receipt</a>
            <a href="#" class="btn">Download PDF</a>
        </div>

        <!-- Back Button -->
        <div class="center-btn">
            <button class="btn" onclick="goBack()">← Back to Dashboard</button>
        </div>
    </div>

    <script>
        function goBack() {
            window.location.href = "dashboard_parent.php"; // Adjust according to your page routing
        }
    </script>

</body>
</html>
