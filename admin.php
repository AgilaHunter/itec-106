<?php
	session_start();
	include("dbconnect.php");
	if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Page</title>
	<!-- <link rel="stylesheet" type="text/css" href="styke.css"> -->
</head>
<body>
	<h1>Admin Page</h1>
	<p>Welcome <?php echo $_SESSION['username']; ?> (Admin)</p>
    <ul>
		<li><a href="admin.php">Home</a></li>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="register.php">Add Staff</a></li>
		<li><a href="staffRead.php">CRUD Staff Info</a></li>
	</ul><br>
</body>
</html>