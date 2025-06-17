<?php 
    include("../dbconnect.php");
    include("../login.php");
    if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'staff') {
        header("Location: login.php");
        exit();
    }

    $staff_id = $_SESSION['staff_id'];

    $sql = "
        SELECT 
            c.*,
            COUNT(o.id) AS order_count,
            MAX(o.order_date) AS last_order_date
        FROM customer c
        LEFT JOIN orders o ON o.cid = c.c_id
        WHERE o.staff_id = ? 
        GROUP BY c.c_id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();
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
				    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 5px;">
				    	<h5 class="m-0">Manage Customers</h5>

				    </div>

				    <div class="table-responsive">
				        <table class="table table-sm table-hover m-0" id="performance">
				            <thead class="align-middle">
				                <tr class="text-center">
				                    <th class="p-2">Customer ID</th>
				                    <th class="p-2">Full Name</th>
				                    <th class="p-2">Email</th>
				                    <th class="p-2">Contact</th>
				                    <th class="p-2">Address</th>
				                    <th class="p-2">Date Created</th>
				                    <th class="p-2">Times Ordered</th>
				                    <th class="p-2">Last Ordered</th>

				                </tr>
				            </thead>

				            <?php
				            	if($result->num_rows>0)
				            	while($row=$result->fetch_assoc()){
				            ?>

				            <tbody class="align-middle">
				                <tr class="text-center">
				                    <td class="sale p-2"><?php echo $row['c_id'] ?></td>
				                    <td class="sale p-2"><?php echo $row['c_fullname'] ?></td>
				                    <td class="sale p-2"><?php echo $row['c_email'] ?></td>
				                    <td class="sale p-2"><?php echo $row['c_contact'] ?></td>
				                    <td class="sale p-2"><?php echo $row['c_address'] ?></td>
				                    <td class="sale p-2"><?php echo $row['date_created'] ?></td>
				                    <td class="sale p-2"><?php echo $row['order_count'] ?></td>
				                    <td class="sale p-2"><?php echo $row['last_order_date'] ?></td>

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