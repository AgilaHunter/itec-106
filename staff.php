<?php
session_start();
include("dbconnect.php");
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Page</title>
</head>
<body>
    <h1>Staff Dashboard</h1>
    <p>Welcome <?php echo $_SESSION['username']; ?> (Staff)</p>
    <!-- Staff-specific content here -->
    <a href="logout.php">Logout</a>
</body>
</html>