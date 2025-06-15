<?php
	include("../dbconnect.php");
	if(isset($_GET['c_id'])){
		$id = $_GET['c_id'];

		$sql = "DELETE FROM customer WHERE c_id=$c_id";
		$result = $conn->query($sql);

		if($result){
			header('Location:customerRead.php');
		}
		else{
			die(mysqli_error($conn));
		}
		$conn->close();
	}
?>