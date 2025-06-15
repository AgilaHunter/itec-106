<?php
	include("../dbconnect.php");
    include("../login.php");
	$sql = "SELECT * FROM staff WHERE position = 'staff'";
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

	<title>Staff Information Page</title>
</head>

<body>
	
  	<div class="d-flex">
  		<!-- Sidebar -->
  		<?php include 'sidebar.php'; ?>	

	  	<!-- Main Content -->
	  	<div class="main-content">
			<div class="dashboard-wrapper p-2">
				<div class="container p-0 mt-4" style="background-color: #f7f3ff; border-radius: 5px;">
					<h5>Staff Information Tab</h5>
				</div>

				<!-- employee table dashboard -->
				<div class="p-2" style="border-radius: 5px;">
				    <div class="d-flex justify-content-between align-items-center mb-2" style="margin-top: 5px;">
				    	<h5 class="m-0">Manage Staff</h5>
				        <a href="register.php" class="btn" role="button">+ Add New Staff</a>
				    </div>

				    <div class="table-responsive">
				        <table class="table table-bordered m-0" id="performance">
				            <thead>
				                <tr class="text-center">
				                    <th>ID</th>
				                    <th>Last Name</th>
				                    <th>First Name</th>
				                    <th>Middle Name</th>
				                    <th>Street</th>
				                    <th>Barangay</th>
				                    <th>City</th>
				                    <th>Province</th>
				                    <th>Postal Code</th>
				                    <th>Contact Number</th>
				                    <th>Monthly Salary</th>
				                    <th>Action</th>
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
				                    <td class="sale"><?php echo $row['street'] ?></td>
				                    <td class="sale"><?php echo $row['barangay'] ?></td>
				                    <td class="sale"><?php echo $row['city'] ?></td>
				                    <td class="sale"><?php echo $row['province'] ?></td>
				                    <td class="sale"><?php echo $row['postal'] ?></td>
				                    <td class="sale">0<?php echo $row['contact'] ?></td>
				                    <td class="sale"><?php echo $row['salary'] ?></td>

				                    <td class="text-center">
				                    	<span class="rounded-circle p-1 me-2 d-inline-flex justify-content-center align-items-center" style="background-color: #c9af00;width: 30px; height: 30px;">
				                    		<a href="staffUpdate.php?id=<?php echo $row['id'] ?>"><i class="fa fa-pencil" aria-hidden="true"></a></i>
				                    	</span>
				                    	<span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center" style="background-color: #c9001a; width: 30px; height: 30px;">
				                    		<a href="staffDelete.php?id=<?php echo $row['id'] ?>"><i class="fa fa-trash" aria-hidden="true"></a></i>
				                    	</span>
				                    </td>
				                </tr>   
	            			</tbody>
	            			<?php
	            				}
	            			?>
	       				</table>
    				</div>
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