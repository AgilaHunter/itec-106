<?php
	include("../dbconnect.php");
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$sql = "DELETE FROM orders WHERE id=$id";
		$result = $conn->query($sql);

		if($result){
			header('Location:report.php');
		}
		else{
			die(mysqli_error($conn));
		}
		$conn->close();
	}
?>