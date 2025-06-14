<?php
	include("../dbconnect.php");
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$sql = "DELETE FROM staff WHERE id=$id";
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