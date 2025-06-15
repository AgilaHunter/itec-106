<?php
	include("../dbconnect.php");
    include("../login.php");
	$sql = "SELECT * FROM customer";
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


	<title>Customer Information Page</title>
</head>

<body>
	
  	<div class="d-flex">
  		<!-- Sidebar -->
  		<?php include 'sidebarstaff.php'; ?>	

	  	<!-- Main Content -->
	  	<div class="main-content">
			<div class="dashboard-wrapper p-2">
				<div class="container p-0 mt-4" style="background-color: #f7f3ff; border-radius: 5px;">
					<h5>Customer Information Tab</h5>
				</div>

				<!-- employee table dashboard -->
				<div class="p-2" style="border-radius: 5px;">
				    <div class="d-flex justify-content-between align-items-center mb-2" style="margin-top: 5px;">
				    	<h5 class="m-0">Manage Customers</h5>
				        <a href="customerAdd.php" class="btn" role="button">+ Add New Customer</a>
				    </div>

				    <div class="table-responsive">
				        <table class="table table-bordered m-0" id="performance">
				            <thead>
				                <tr class="text-center">
				                    <th>ID</th>
				                    <th>First Name</th>
				                    <th>Middle Name</th>
				                    <th>Last Name</th>
				                    <th>Street</th>
				                    <th>Barangay</th>
				                    <th>City</th>
				                    <th>Province</th>
				                    <th>Postal Code</th>
				                    <th>Contact No.</th>
				                    <th>Date</th>
				                    <th>Action</th>
				                </tr>
				            </thead>

				            <?php
				            	if($result->num_rows>0)
				            	while($row=$result->fetch_assoc()){
				            ?>

				            <tbody>
				                <tr class="text-center">
				                    <td class="sale"><?php echo $row['c_id'] ?></td>
				                    <td class="sale"><?php echo $row['c_fname'] ?></td>
				                    <td class="sale"><?php echo $row['c_mname'] ?></td>
				                    <td class="sale"><?php echo $row['c_lname'] ?></td>
				                    <td class="sale"><?php echo $row['c_street'] ?></td>
				                    <td class="sale"><?php echo $row['c_barangay'] ?></td>
				                    <td class="sale"><?php echo $row['c_city'] ?></td>
				                    <td class="sale"><?php echo $row['c_province'] ?></td>
				                    <td class="sale"><?php echo $row['c_postal'] ?></td>
				                    <td class="sale">0<?php echo $row['c_contact'] ?></td>
				                    <td class="sale"><?php echo $row['date_created'] ?></td>

				                    <td class="text-center">
				                    	<span class="rounded-circle p-1 me-2 d-inline-flex justify-content-center align-items-center" style="background-color: #c9af00;width: 30px; height: 30px;">
				                    		<a href="customerUpdate.php?c_id=<?php echo $row['c_id'] ?>"><i class="fa fa-pencil" aria-hidden="true"></a></i>
				                    	</span>
				                    	<span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center" style="background-color: #c9001a; width: 30px; height: 30px;">
				                    		<a href="customerDelete.php?c_id=<?php echo $row['c_id'] ?>"><i class="fa fa-trash" aria-hidden="true"></a></i>
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