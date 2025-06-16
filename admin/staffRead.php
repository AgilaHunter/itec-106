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
				    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 5px;">
				    	<h5 class="m-0">Manage Staff</h5>
				        <a href="register.php" class="btn" role="button">+ Add New Staff</a>
				    </div>

				    <div class="table-responsive">
				        <table class="table table-sm table-hover m-0" id="performance">
				            <thead class="align-middle">
				                <tr class="text-center">
				                    <th class="p-2">ID</th>
				                    <th class="p-2">Last Name</th>
				                    <th class="p-2">First Name</th>
				                    <th class="p-2">Middle Name</th>
				                    <th class="p-2">Street</th>
				                    <th class="p-2">Barangay</th>
				                    <th class="p-2">City</th>
				                    <th class="p-2">Province</th>
				                    <th class="p-2">Postal Code</th>
				                    <th class="p-2">Contact Number</th>
				                    <th class="p-2">Monthly Salary</th>
				                    <th class="p-2">Action</th>
				                </tr>
				            </thead>

				            <?php
				            	if($result->num_rows>0)
				            	while($row=$result->fetch_assoc()){
				            ?>

				            <tbody class="align-middle">
				                <tr class="text-center">
				                    <td class="sale p-2"><?php echo $row['id'] ?></td>
				                    <td class="sale p-2"><?php echo $row['lname'] ?></td>
				                    <td class="sale p-2"><?php echo $row['fname'] ?></td>
				                    <td class="sale p-2"><?php echo $row['mname'] ?></td>
				                    <td class="sale p-2"><?php echo $row['street'] ?></td>
				                    <td class="sale p-2"><?php echo $row['barangay'] ?></td>
				                    <td class="sale p-2"><?php echo $row['city'] ?></td>
				                    <td class="sale p-2"><?php echo $row['province'] ?></td>
				                    <td class="sale p-2"><?php echo $row['postal'] ?></td>
				                    <td class="sale p-2">0<?php echo $row['contact'] ?></td>
				                    <td class="sale p-2"><?php echo $row['salary'] ?></td>

				                    <td class="text-center">
				                    	<div class="d-flex justify-content-center gap-2 flex-wrap p-1">
				                    		<a href="staffUpdate.php?id=<?php echo $row['id'] ?>" class="d-inline-flex justify-content-center align-items-center rounded-circle text-decoration-none" style="background-color: #c9af00; width: 30px; height: 30px;">
				                    			<i class="fa fa-pencil text-white" aria-hidden="true"></i>
				                    		</a>
				                    		<a href="staffDelete.php?id=<?php echo $row['id'] ?>" class="d-inline-flex justify-content-center align-items-center rounded-circle text-decoration-none" style="background-color: #c9001a; width: 30px; height: 30px;">
				                    			<i class="fa fa-trash text-white" aria-hidden="true"></i>
				                    		</a>
				                    	</div>
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