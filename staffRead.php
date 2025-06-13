<?php
	include("dbconnect.php");
    include("login.php");
	$sql = "SELECT * FROM staff WHERE position = 'staff'";
	$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD Staff</title>
</head>
<body>
    <h1>CRUD Staff</h1>
	<ul>
		<li><a href="admin.php">Home</a></li>
		<li><a href="index.php">Logout</a></li>
		<li><a href="register.php">Add Staff</a></li>
		<li><a href="staffRead.php">CRUD Staff Info</a></li>
	</ul>
	<div id="table">
	<table id="performance">
		<tr>
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
		</tr>
		<?php
			if($result->num_rows>0)
			while($row=$result->fetch_assoc()){
		?>
		<tr>
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
			<td><a href="staffUpdate.php?id=<?php echo $row['id'] ?>">Update</td>
				<td><a href="staffDelete.php?id=<?php echo $row['id'] ?>">Delete</td>
		</tr>
		<?php
			}
		?>

	</table><br>
	</div>
	
</body>
</html>