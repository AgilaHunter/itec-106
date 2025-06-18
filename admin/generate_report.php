<?php
session_start();
include("../dbconnect.php");

// Verify admin access
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get report parameters with proper initialization
$month = isset($_POST['month']) ? $_POST['month'] : date('m');
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$includeDetails = isset($_POST['includeDetails']);

// Validate inputs
if (!is_numeric($month)) $month = date('m');
if (!is_numeric($year)) $year = date('Y');
$month = str_pad($month, 2, '0', STR_PAD_LEFT);

// Ensure valid ranges
$month = max(1, min(12, $month));
$year = max(2010, min(date('Y')+1, $year));

// Format month with leading zero
$monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);

// Query for monthly summary
$summaryQuery = "SELECT 
                    DATE(order_date) AS date,
                    COUNT(id) AS transaction_count,
                    SUM(total) AS daily_total
                FROM orders
                WHERE MONTH(order_date) = ? AND YEAR(order_date) = ?
                GROUP BY DATE(order_date)
                ORDER BY date DESC";
$stmt = $conn->prepare($summaryQuery);
$stmt->bind_param("ss", $month, $year);
$stmt->execute();
$summaryResult = $stmt->get_result();

// Query for detailed transactions
if ($includeDetails) {
    $detailsQuery = "SELECT 
                        o.id,
                        o.order_date,
                        c.c_fullname,
                        o.total
                    FROM orders o
                    LEFT JOIN customer c ON o.cid = c.c_id
                    WHERE MONTH(o.order_date) = ? AND YEAR(o.order_date) = ?
                    ORDER BY o.order_date DESC";
    $stmt = $conn->prepare($detailsQuery);
    $stmt->bind_param("ss", $month, $year);
    $stmt->execute();
    $detailsResult = $stmt->get_result();
}

// Calculate monthly total
$monthlyTotalQuery = "SELECT SUM(total) AS monthly_total
                     FROM orders
                     WHERE MONTH(order_date) = ? AND YEAR(order_date) = ?";
$stmt = $conn->prepare($monthlyTotalQuery);
$stmt->bind_param("ss", $month, $year);
$stmt->execute();
$monthlyTotal = $stmt->get_result()->fetch_assoc()['monthly_total'] ?? 0;

$monthName = date('F', mktime(0, 0, 0, $month, 1));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report - <?php echo "$monthName $year"; ?></title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 20px; font-size: 12px; }
        }
        .report-header { border-bottom: 2px solid #333; margin-bottom: 20px; }
        .total-row { font-weight: bold; background-color: #f8f9fa; }
        .form-select { width: auto; display: inline-block; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="report-header">
            <h2 style="color: #493D9E;">Sales Report: <?php echo "$monthName $year"; ?></h2>
            <p>Generated on: <?php echo date('F j, Y'); ?></p>
        </div>

        <div class="no-print mb-4 p-3">
            <form method="post" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="month" class="form-label">Month:</label>
                    <select name="month" id="month" class="form-select">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo $m; ?>" <?php echo $m == $month ? 'selected' : ''; ?>>
                            <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="col-auto">
                    <label for="year" class="form-label">Year:</label>
                    <select name="year" id="year" class="form-select">
                        <?php 
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= $currentYear - 5; $y--): ?>
                        <option value="<?php echo $y; ?>" <?php echo $y == $year ? 'selected' : ''; ?>>
                            <?php echo $y; ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeDetails" name="includeDetails" <?php echo $includeDetails ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="includeDetails">Show Details</label>
                    </div>
                </div>
                
                <div class="col-auto">
                    <button type="submit" class="btn text-white" style="background-color:#c9af00;">Generate</button>
                    <button onclick="window.print()" class="btn text-white" style="background-color: #7fc900;">Print</button>
                    <a href="admin.php" class="btn btn-secondary">Close</a>
                </div>
            </form>
        </div>

        <?php if ($summaryResult->num_rows > 0): ?>
        <h4 style="color: #493D9E;">Daily Summary</h4>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Transactions</th>
                    <th>Daily Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $summaryResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('M j, Y', strtotime($row['date'])); ?></td>
                    <td><?php echo $row['transaction_count']; ?></td>
                    <td>₱<?php echo number_format($row['daily_total'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
                <tr class="total-row">
                    <td colspan="2">Monthly Total</td>
                    <td>₱<?php echo number_format($monthlyTotal, 2); ?></td>
                </tr>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-warning">No sales data found for <?php echo "$monthName $year"; ?></div>
        <?php endif; ?>

        <?php if ($includeDetails && isset($detailsResult) && $detailsResult->num_rows > 0): ?>
        <h4 class="mt-5" style="color: #493D9E;">Transaction Details</h4>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Order ID</th>
                    <th>Date/Time</th>
                    <th>Customer</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $detailsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo date('M j, Y h:i A', strtotime($row['order_date'])); ?></td>
                    <td><?php echo htmlspecialchars($row['c_fullname']); ?></td>
                    <td>₱<?php echo number_format($row['total'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php elseif ($includeDetails): ?>
        <div class="alert alert-info mt-4">No transaction details available</div>
        <?php endif; ?>
    </div>
</body>
</html>