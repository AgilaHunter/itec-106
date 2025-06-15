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

	<!-- google fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,600;1,600&family=Roboto&display=swap" rel="stylesheet">

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
							<div class="card-title">10</div>
							<div class="card-subtitle">Staff</div>
						</div>
					</div>
					<div class="dashboard-card shadow d-flex align-items-center p-3">
						<i class="fa fa-money me-3 ms-3 mt-2 fs-2"></i>
						<div>
							<div class="card-title">10000.0</div>
							<div class="card-subtitle">Daily Sales</div>
						</div>
					</div>
					<div class="dashboard-card shadow d-flex align-items-center p-3">
						<i class="fa fa-exchange me-3 ms-3 mt-2 fs-4"></i>
						<div>
							<div class="card-title">15</div>
							<div class="card-subtitle">Daily Transactions</div>
						</div>
					</div>
					<div class="dashboard-card shadow d-flex align-items-center p-3">
						<i class="fa fa-bar-chart me-3 ms-3 mt-2 fs-4"></i>
						<div>
							<div class="card-title">15000.0</div>
							<div class="card-subtitle">Total Sales</div>
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
				        <table class="table table-bordered w-100 m-0">
				            <thead>
				                <tr class="text-center">
				                    <th>ID</th>
				                    <th>Last Name</th>
				                    <th>First Name</th>
				                    <th>Middle Name</th>
				                </tr>
				            </thead>

				            <?php
				            	if($result->num_rows>0)
				            	while($row=$result->fetch_assoc()){
				            ?>

				            <tbody>
				                <tr class="text-center">
				                    <td class="sale"><?php echo $row['id'] ?></td>
				                    <td class="sale"><?php echo $row['lname'] ?></td>
				                    <td class="sale"><?php echo $row['fname'] ?></td>
				                    <td class="sale"><?php echo $row['mname'] ?></td>
				                </tr>   
	            			</tbody>

	            			<?php
	            				}
	            			?>
	            			
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
				        <a href="#" class="btn" role="button" name="adds">Generate Sales Report</a>
				    </div>

				    <div class="table-responsive">
				        <table class="table table-bordered w-100 m-0">
				            <thead>
				                <tr class="text-center">
				                    <th>ID</th>
				                    <th>Last Name</th>
				                    <th>First Name</th>
				                    <th>Middle Name</th>
				                </tr>
				            </thead>
				            <tbody>
				                <tr class="text-center">
				                    <td>0001</td>
				                    <td>Regencia</td>
				                    <td>Samantha Arabella</td>
				                    <td>Redilla</td>
				                </tr>      
	            			</tbody>
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


</body>
</html>