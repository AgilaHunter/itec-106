<?php
	include("../dbconnect.php");
	$c_id = $_GET['c_id'];
	$sql = "SELECT * FROM `customer` WHERE `c_id` = '$c_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$c_lname = $row['c_lname'];
	$c_fname = $row['c_fname'];
	$c_mname = $row['c_mname'];
    $c_street = $row['c_street'];
	$c_barangay = $row['c_barangay'];
	$c_city = $row['c_city'];
    $c_province = $row['c_province'];
    $c_postal = $row['c_postal'];
	$c_contact = $row['c_contact'];

	if(isset($_POST['c_update'])){
		$c_lname = $_POST['c_lname'];
    	$c_fname = $_POST['c_fname'];
	    $c_mname = $_POST['c_mname'];
        $c_street = $_POST['c_street'];
	    $c_barangay = $_POST['c_barangay'];
	    $c_city = $_POST['c_city'];
        $c_province = $_POST['c_province'];
        $c_postal = $_POST['c_postal'];
	    $c_contact = $_POST['c_contact'];

		$sql = "UPDATE `customer` SET `c_lname` = '$c_lname',`c_fname` = '$c_fname', `c_mname` = '$c_mname', `c_street` = '$c_street', `c_barangay` = '$c_barangay', `c_city` = '$c_city', `c_province` = '$c_province', `c_postal` = '$c_postal', `c_contact` = '$c_contact' WHERE `c_id`='$c_id'";
		$result = $conn->query($sql);

		if($result){
			header('Location: customerRead.php');
		}
		else{
			die(mysqli_error($conn));
		}
		$conn->close();
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
		<link rel="stylesheet" type="text/css" href="../assets/forms.css">

	<title>Update Staff Information</title>
</head>

<body>

  	<div class="dashboard-wrapper p-2">
  		<div class="card shadow">
  			<div class="container p-3">
  				<span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center bg-transparent shadow-sm" style="background-color: #493D9E; width: 50px; height: 50px;">
  					<a href="customerRead.php"><i class="fa fa-arrow-left" aria-hidden="true"></a></i> 
  				</span>
	  			<div class="container p-3 mt-5 mb-5" style="background-color: #f7f3ff; border-radius: 5px;">
	  				<h5>Staff Information Update</h5>
	  			</div>
	  			<form action="#" method="POST" id="myForm">

					<h5 class="divider">Personal Information</h5>
	  				<!-- Name -->
	  				<div class="row g-2">
	  					<div class="col">
	  						<label>First Name</label>
	  						<input type="text" class="form-control" placeholder="First Name" id="c_fname" name="c_fname" value="<?php echo $c_fname?>" required>
	  					</div>
	  					<div class="col">
	  						<label>Middle Name</label>
	  						<input type="text" class="form-control" placeholder="Middle Name" id="c_mname" name="c_mname" value="<?php echo $c_mname?>" required>
	  					</div>
	  					<div class="col">
	  						<label>Last Name</label>
	  						<input type="text" class="form-control" placeholder="Last Name" id="c_lname" name="c_lname" value="<?php echo $c_lname?>" required>
	  					</div>
	  				</div><br><br>

	  				<h5 class="divider">Address and Contact Details</h5>
	  				<!-- Address -->
	  				<div class="row g-5">
	  					<div class="col">
	  						<label>Street Name</label>
	  						<input type="text" id="c_street" name="c_street" class="form-control" value="<?php echo $c_street?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>Barangay</label>
	  						<input type="text" id="c_barangay" name="c_barangay" class="form-control" value="<?php echo $c_barangay?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>City</label>
	  						<input type="text" id="c_city" name="c_city" class="form-control" placeholder="General Trias"  value="<?php echo $c_city?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>Province</label>
	  						<input type="text" id="c_province" name="c_province" class="form-control" placeholder="Cavite" value="<?php echo $c_province?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>Postal Code</label>
	  						<input type="number" id="c_postal" name="c_postal" class="form-control" placeholder="4107" value="<?php echo $c_postal?>" required><br>
	  					</div>
	  				</div>

	  				<label>Contact Number</label>
	  				<input type="tel" pattern="^\d{11}$" name="c_contact" class="form-control" value="0<?php echo $c_contact?>" required oninput="validateNumber(this)" /><br><br>


	  				<!-- Submit -->
	  				<input type="submit" id="c_update" name="c_update" value="Update" class="btn btn col-12">
	  				<input type="reset" id="clear" class="btn btn col-12">
	  			</form>

	  			<script>
	  			    document.getElementById("myForm").addEventListener("submit", function(event) {
	  			        let isValid = true;

	  			        if (!isValid) {
	  			            event.preventDefault();
	  			        }
	  			    })
	  			</script>
	  		</div>
  		</div>
  	</div>
	
	<!-- Fontawesome Bundle -->
	<script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>

</body>
</html>