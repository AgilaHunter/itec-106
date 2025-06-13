<?php
	include("dbconnect.php");
	$id = $_GET['id'];
	$sql = "SELECT * FROM `staff` WHERE `id` = '$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

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

		$sql = "UPDATE `staff` SET `lname` = '$lname',`fname` = '$fname', `mname` = '$mname', `street` = '$street', `barangay` = '$barangay', `city` = '$city', `province` = '$province', `postal` = '$postal', `contact` = '$contact', `salary` = '$salary' WHERE `id`='$id'";
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
	<title>Update Staff</title>
</head>
<body>
    <h1>Update Staff</h1>

	<div id="table">
	<form class="reg-container" method="POST" id="myForm">

        <ul>
		<li><a href="admin.php">Home</a></li>
		<li><a href="index.php">Logout</a></li>
		<li><a href="register.php">Add Staff</a></li>
		<li><a href="staffRead.php">CRUD Staff Info</a></li>
	</ul><br>

        <!-- (Your existing HTML form fields remain the same) -->

        <label>First Name</label>
        <input type="text" id="fname" name="fname" value="<?php echo $fname?>" required><br>

        <label>Middle Name</label>
        <input type="text" id="mname" name="mname" value="<?php echo $mname?>" required><br>

        <label>Last Name</label>
        <input type="text" id="lname" name="lname" value="<?php echo $lname?>" required><br>

        <label>Street Name</label>
        <input type="text" id="street" name="street" value="<?php echo $street?>" required><br>
        
        <label>Barangay</label>
        <input type="text" id="barangay" name="barangay" value="<?php echo $barangay?>" required><br>

        <label>City</label>
        <input type="text" id="city" name="city" value="<?php echo $city?>" required><br>

        <label>Province</label>
        <input type="text" id="province" name="province" value="<?php echo $province?>" required><br>

        <label>Postal Code</label>
        <input type="number" id="postal" name="postal" value="<?php echo $postal?>" required><br>

        <label>Contact Number</label>
        <input type="tel" pattern="^\d{11}$" name="contact" value="0<?php echo $contact?>" required oninput="validateNumber(this)" /><br>

        <label>Monthly Salary</label>
        <input type="number" step="0.01" id="salary" name="salary" value="<?php echo $salary?>" required><br>

        <button type="submit" name="update" id="button">Update Staff</button>
        <input type="reset">
        <a href="staffRead.php">Back</a>
    </form>
	</div>
    <script>
        document.getElementById("myForm").addEventListener("submit", function(event) {
            let isValid = true;

            if (!isValid) {
                event.preventDefault();
            }
        })
    </script>
</body>
</html>