<?php
	session_start();
	include("../dbconnect.php");
	if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
	$sql = "SELECT id, fname, mname, lname FROM staff 
			WHERE position = 'staff' 
			ORDER BY id ASC LIMIT 5";
	$result = $conn->query($sql);

	$orders_sql = 
		"
	    SELECT 
	        DATE(o.order_date) AS order_date,
	        SUM(o.total) AS total_sales
	    FROM orders o
	    LEFT JOIN customer c ON o.cid = c.c_id
	    GROUP BY DATE(order_date)
	    ORDER BY order_date DESC;
		";
   	$orders_result = $conn->query($orders_sql);

	// Total Staff Count
	$staffCountQuery = "SELECT COUNT(*) as total_staff FROM staff WHERE position = 'staff'";
	$staffCountResult = $conn->query($staffCountQuery);
	$staffCount = $staffCountResult->fetch_assoc()['total_staff'];

	// Daily Sales Count
	$dailySalesQuery = "SELECT COALESCE(SUM(total), 0) AS daily_sales 
	                   FROM orders 
	                   WHERE DATE(order_date) = CURDATE()";
	$dailySalesResult = $conn->query($dailySalesQuery);
	$today_sales = 0;
	if ($dailySalesResult) {
	    $row = $dailySalesResult->fetch_assoc();
	    $today_sales = (float)$row['daily_sales'];
	}

	// Daily Sales Count
	$dailyTransQuery = "SELECT COUNT(id) AS daily_trans
	                   FROM orders
	                   WHERE DATE(order_date) = CURDATE()";
	$dailyTransResult = $conn->query($dailyTransQuery);
	$today_trans = 0;
	if ($dailyTransResult) {
	    $row = $dailyTransResult->fetch_assoc();
	    $today_trans = (int)$row['daily_trans'];
	}

	// Monthly Sales Calculation
	$currentMonth = date('M Y');
	$monthlySalesQuery = "SELECT SUM(total) AS monthly_sales 
	                      FROM orders 
	                      WHERE MONTH(order_date) = MONTH(CURRENT_DATE())
	                      AND YEAR(order_date) = YEAR(CURRENT_DATE())";
	$monthlySalesResult = $conn->query($monthlySalesQuery);
	$monthlySales = 0;
	if ($monthlySalesResult && $monthlySalesResult->num_rows > 0) {
	    $row = $monthlySalesResult->fetch_assoc();
	    $monthlySales = $row['monthly_sales'] ?? 0;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- css bootstrap -->
		<link rel="stylesheet" type="text/css" href="../bootstrap-5.0.2-dist\css\bootstrap.min.css">
		<script type="text/javascript" src="../bootstrap-5.0.2-dist\js\bootstrap.min.js"></script>

	<!-- external css -->
		<link rel="stylesheet" type="text/css" href="../assets/admindash_style.css">


	<title>Admin Dashboard</title>
</head>

<body>

	<div class="d-flex">
		<!-- Sidebar -->
		<?php include 'sidebar.php'; ?>

	  	<!-- Main Content -->
	  	<div class="main-content">
			<div class="dashboard-wrapper p-2">
				<div class="container p-0 mt-4" style="background-color: #f7f3ff; border-radius: 5px;">
					<h5>Admin Dashboard</h5>
				</div>
				<br>
				<div class="card-container d-flex flex-wrap gap-3">
					<div class="dashboard-card shadow d-flex align-items-center p-3">
						<i class="fa-solid fa-user-group me-3 ms-3 mt-2 fs-4"></i>
						<div>
							<div class="card-title"><?php echo $staffCount; ?></div>
							<div class="card-subtitle">Staff</div>
						</div>
					</div>

					<div class="dashboard-card shadow d-flex align-items-center p-3">
						<i class="fa fa-money me-3 ms-3 mt-2 fs-2"></i>
						<div>
							<div class="card-title">₱ <?php echo number_format($today_sales, 2); ?></div>
							<div class="card-subtitle">Daily Sales</div>
						</div>
					</div>
	
					<div class="dashboard-card shadow d-flex align-items-center p-3">
						<i class="fa fa-exchange me-3 ms-3 mt-2 fs-4"></i>
						<div>
							<div class="card-title"><?php echo $today_trans; ?></div>
							<div class="card-subtitle">Daily Transactions</div>
						</div>
					</div>


					<div class="dashboard-card shadow d-flex align-items-center p-3">
						<i class="fa fa-bar-chart me-3 ms-3 mt-2 fs-4"></i>
						<div>
							<div class="card-title">₱ <?php echo number_format($monthlySales, 2); ?></div>
							<div class="card-subtitle">Monthly Sales (<?php echo $currentMonth; ?>)</div>
						</div>
					</div>
				</div>

				<!-- staff table dashboard -->
				<div class="p-2" style="border-radius: 5px;">
				    <div class="d-flex justify-content-between align-items-center mb-2" style="margin-top: 55px;">
				    	<h5 class="m-0">Manage Staff</h5>
				        <a href="register.php" class="btn" role="button">+ Add New Staff</a>
				    </div>

				    <div class="table-responsive">
				        <table class="table table-hover w-100 m-0">
				            <thead class="align-middle">
				                <tr class="text-center">
				                    <th class="p-2">ID</th>
				                    <th class="p-2">Last Name</th>
				                    <th class="p-2">First Name</th>
				                    <th class="p-2">Middle Name</th>
				                </tr>
				            </thead>

				            <tbody class="align-middle">
				            	<?php
				            		if($result->num_rows>0)
				            		while($row=$result->fetch_assoc()){
				            	?>
				                <tr class="text-center">
				                    <td class="sale p-2"><?php echo $row['id'] ?></td>
				                    <td class="sale p-2"><?php echo $row['lname'] ?></td>
				                    <td class="sale p-2"><?php echo $row['fname'] ?></td>
				                    <td class="sale p-2"><?php echo $row['mname'] ?></td>
				                </tr> 
				                <?php
				                	}
				                ?>  
	            			</tbody>
	       				</table>
    				</div>
				</div>

				<div class="text-center p-2">
					<p><a href="staffRead.php" class="text-secondary">View more</a></p>
				</div>


				<!-- sales table dashboard -->
				<div class="p-2" style="border-radius: 5px;">
				    <div class="d-flex justify-content-between align-items-center mb-2" style="margin-top: 5px;">
				    	<h5 class="m-0">Sales</h5>
				       	<button class="btn" data-bs-toggle="modal" data-bs-target="#reportModal">Generate Sales Report</button>

				       	<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
				       	    <div class="modal-dialog">
				       	        <div class="modal-content">
				       	            <div class="modal-header">
				       	                <h5 class="modal-title">Generate Sales Report</h5>
				       	                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				       	            </div>
				       	            <div class="modal-body">
				       	                <form id="reportForm" method="post" action="generate_report.php" target="_blank">
				       	                    <div class="mb-3">
				       	                        <label for="reportMonth" class="form-label">Select Month</label>
				       	                        <input type="month" class="form-control" id="reportMonth" name="reportMonth" 
				       	                               max="<?php echo date('Y-m'); ?>">
				       	                    </div>
				       	                    <div class="form-check mb-3">
				       	                        <input class="form-check-input" type="checkbox" id="includeDetails" name="includeDetails">
				       	                        <label class="form-check-label" for="includeDetails">Include transaction details</label>
				       	                    </div>
				       	                </form>
				       	            </div>
				       	            <div class="modal-footer">
				       	                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				       	                <button type="submit" form="reportForm" class="btn btn-primary">Generate Report</button>
				       	            </div>
				       	        </div>
				       	    </div>
				       	</div>
				    </div>

				    <div class="table-responsive">
				        <table class="table table-hover w-100 m-0">
				            <thead class="align-middle">
				                <tr class="text-center">
				                    <th class="p-2">Date</th>
				                    <th class="p-2">Total Sales</th>
				                </tr>
				            </thead>
				            <tbody class="align-middle">
				            	<?php
				            		if($orders_result->num_rows>0)
				            		while($order=$orders_result->fetch_assoc()){
				            	?>
				                <tr class="text-center">
				                    <td class="p-2"><?php echo date("F j, Y", strtotime($order['order_date'])); ?></td>
				                     <td class="p-2">₱<?php echo number_format($order['total_sales'], 2); ?></td>
				                </tr>      
	            			</tbody>
	            			<?php
	            				}
	            			?>
	       				</table>
    				</div>
				</div>

				<div class="text-center p-2">
					<p><a href="#" class="text-secondary"> View more</a></p>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Fontawesome Bundle -->
	<script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>

	<script>
	  document.addEventListener("DOMContentLoaded", function () {
	    const toggleButton = document.getElementById("toggleSidebar");
	    const sidebar = document.getElementById("sidebar");
	    const mainContent = document.querySelector(".main-content");

	    // Check localStorage on load
	    const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
	    if (isCollapsed) {
	      sidebar.classList.add("collapsed");
	      mainContent.classList.add("expanded");
	    }

	    // Toggle sidebar and save state
	    toggleButton.addEventListener("click", () => {
	      sidebar.classList.toggle("collapsed");
	      mainContent.classList.toggle("expanded");
	      const collapsedNow = sidebar.classList.contains("collapsed");
	      localStorage.setItem("sidebarCollapsed", collapsedNow);
	    });
	  });

	</script>

	<script>
	document.addEventListener("DOMContentLoaded", function() {
	    // Get the report modal element
	    const reportModal = document.getElementById('reportModal');
	    
	    // Only proceed if the modal exists on the page
	    if (reportModal) {
	        // When modal is about to be shown
	        reportModal.addEventListener('show.bs.modal', function() {
	            // Create date string in YYYY-MM format
	            const currentMonth = new Date().toISOString().slice(0, 7);
	            
	            // Set the input value to current month
	            document.getElementById('reportMonth').value = currentMonth;
	        });
	    }
	});
	</script>


</body>
</html>