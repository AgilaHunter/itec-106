<?php
	include("../dbconnect.php");
	$id = $_GET['id'];
	$sql = "SELECT * FROM `staff` WHERE `id` = '$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$user = $row['username'];
	$password = $row['password'];
	$confirm = $row['confirm'];
	$lname = $row['lname'];
	$fname = $row['fname'];
	$mname = $row['mname'];
    $street = $row['street'];
	$barangay = $row['barangay'];
	$city = $row['city'];
    $province = $row['province'];
    $postal = $row['postal'];
	$contact = $row['contact'];
	$salary = $row['salary'];

	if(isset($_POST['update'])){
		$user = $_POST['user'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$lname = $_POST['lname'];
    	$fname = $_POST['fname'];
	    $mname = $_POST['mname'];
        $street = $_POST['street'];
	    $barangay = $_POST['barangay'];
	    $city = $_POST['city'];
        $province = $_POST['province'];
        $postal = $_POST['postal'];
	    $contact = $_POST['contact'];
	    $salary = $_POST['salary'];

		$sql = "UPDATE `staff` SET `username` = '$user',`lname` = '$lname',`fname` = '$fname', `mname` = '$mname', `street` = '$street', `barangay` = '$barangay', `city` = '$city', `province` = '$province', `postal` = '$postal', `contact` = '$contact', `salary` = '$salary', `password` = '$password', `confirm` = '$confirm' WHERE `id`='$id'";
		$result = $conn->query($sql);

		if($result){
			header('Location:staffRead.php');
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
  					<a href="staffRead.php"><i class="fa fa-arrow-left" aria-hidden="true"></a></i> 
  				</span>
	  			<div class="container p-3 mt-5 mb-5" style="background-color: #f7f3ff; border-radius: 5px;">
	  				<h5>Staff Information Update</h5>
	  			</div>
	  			<form action="#" method="POST" id="myForm">

					<h5 class="divider">Work Credentials</h5>
					<div class="row g-2">
						<div class="col">
	  						<label>Username</label>
	  						<input type="text" class="form-control" placeholder="First Name" id="user" name="user" value="<?php echo $user?>" required>
	  					</div>
						<div class="col">
	  						<label>Password</label>
	  						<input type="password" class="form-control" placeholder="First Name" id="password" name="password" value="<?php echo $password?>" required>
							<small id="passwordError" style="color: red;"></small>
	  					</div>
						<div class="col">
	  						<label>Confirm Password</label>
	  						<input type="password" class="form-control" placeholder="First Name" id="confirm" name="confirm" value="<?php echo $confirm?>" required>
							<small id="confirmError" style="color: red;"></small>
	  					</div>
					</div>

					<h5 class="divider">Personal Information</h5>
	  				<!-- Name -->
	  				<div class="row g-2">
	  					<div class="col">
	  						<label>First Name</label>
	  						<input type="text" class="form-control" placeholder="First Name" id="fname" name="fname" value="<?php echo $fname?>" required>
	  					</div>
	  					<div class="col">
	  						<label>Middle Name</label>
	  						<input type="text" class="form-control" placeholder="Middle Name" id="mname" name="mname" value="<?php echo $mname?>" required>
	  					</div>
	  					<div class="col">
	  						<label>Last Name</label>
	  						<input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname" value="<?php echo $lname?>" required>
	  					</div>
	  				</div><br><br>

	  				<h5 class="divider">Address and Contact Details</h5>
	  				<!-- Address -->
	  				<div class="row g-5">
	  					<div class="col">
	  						<label>Street Name</label>
	  						<input type="text" id="street" name="street" class="form-control" value="<?php echo $street?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>Barangay</label>
	  						<input type="text" id="barangay" name="barangay" class="form-control" value="<?php echo $barangay?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>City</label>
	  						<input type="text" id="city" name="city" class="form-control" placeholder="General Trias"  value="<?php echo $city?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>Province</label>
	  						<input type="text" id="province" name="province" class="form-control" placeholder="Cavite" value="<?php echo $province?>" required><br>
	  					</div>
	  					<div class="col">
	  						<label>Postal Code</label>
	  						<input type="number" id="postal" name="postal" class="form-control" placeholder="4107" value="<?php echo $postal?>" required><br>
	  					</div>
	  				</div>

	  				<label>Contact Number</label>
	  				<input type="tel" pattern="^\d{11}$" name="contact" class="form-control" value="0<?php echo $contact?>" required oninput="validateNumber(this)" /><br><br>

	  				<h5 class="divider">Salary</h5>
	  				<label>Monthly Salary</label>
	  				<input type="number" step="0.01" id="salary" name="salary" class="form-control" placeholder="24000.00" value="<?php echo $salary?>" required><br><br>


	  				<!-- Submit -->
	  				<input type="submit" id="update" name="update" value="Update" class="btn btn col-12">
	  				<input type="reset" id="clear" class="btn btn col-12">
	  			</form>

	  			<script>
	  			    //document.getElementById("myForm").addEventListener("submit", function(event) {
	  			        //let isValid = true;

	  			        //if (!isValid) {
	  			            //event.preventDefault();
	  			        //}
	  			    //})

					document.getElementById("myForm").addEventListener("submit", function(event) {
            const password = document.getElementById("password").value;
            const confirm = document.getElementById("confirm").value;
            let isValid = true;

            // Reset error messages
            document.getElementById("passwordError").textContent = "";
            document.getElementById("confirmError").textContent = "";

            // Validate password length
            if (password.length < 6) {
                document.getElementById("passwordError").textContent = "Password must be at least 6 characters";
                isValid = false;
            }

            // Check if passwords match
            if (password !== confirm) {
                document.getElementById("confirmError").textContent = "Passwords do not match";
                isValid = false;
            }

            // Check for at least one number, letter, and special character
            if (!/\d/.test(password)) {
                document.getElementById("passwordError").textContent = "Password must contain at least one number";
                isValid = false;
            }
            if (!/[A-Za-z]/.test(password)) {
                document.getElementById("passwordError").textContent = "Password must contain at least one letter";
                isValid = false;
            }
            if (!/[^\w]/.test(password)) {
                document.getElementById("passwordError").textContent = "Password must contain at least one special character";
                isValid = false;
            }

            // Stop submission if invalid
            if (!isValid) {
                event.preventDefault();
            }
        });
	  			</script>
	  		</div>
  		</div>
  	</div>
	
	<!-- Fontawesome Bundle -->
	<script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>

</body>
</html>