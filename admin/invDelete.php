<?php
	include("../dbconnect.php");
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$sql = "DELETE FROM products WHERE id=$id";
		$result = $conn->query($sql);

		if($result){
			header('Location:inventory.php');
		}
		else{
			die(mysqli_error($conn));
		}
		$conn->close();
	}
?>