<?php
	include("../dbconnect.php");
	$id = $_GET['id'];
	$sql = "SELECT * FROM `products` WHERE `id` = '$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$name = $row['name'];
	$price = $row['price'];
	$stock = $row['stock'];

	if(isset($_POST['update'])){
		$name = $_POST['name'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];

		$sql = "UPDATE `products` SET `name` = '$name',`price` = '$price',`stock` = '$stock' WHERE `id`='$id'";
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

	<title>Update Product Information</title>
</head>

<body>

  	<div class="dashboard-wrapper p-2">
  		<div class="card shadow">
  			<div class="container p-3">
  				<span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center bg-transparent shadow-sm" style="background-color: #493D9E; width: 50px; height: 50px;">
  					<a href="inventory.php"><i class="fa fa-arrow-left" aria-hidden="true"></a></i> 
  				</span>
	  			<div class="container p-3 mt-5 mb-5" style="background-color: #f7f3ff; border-radius: 5px;">
	  				<h5>Product Information Update</h5>
	  			</div>
	  			<form action="#" method="POST" id="myForm">

					<h5 class="divider">Details</h5>
					<div class="row g-2">
						<div class="col">
	  						<label>Product Name</label>
	  						<input type="text" class="form-control" placeholder="Product Name" id="name" name="name" value="<?php echo $name?>" required>
	  					</div>

	  					<div class="col">
	  						<label>Price</label>
	  						<input type="number" step="0.01" class="form-control" placeholder="99.99" id="price" name="price" value="<?php echo $price?>" required>
	  					</div>

	  					<div class="col">
	  						<label>Stock</label>
	  						<input type="number" id="stock" name="stock" class="form-control" value="<?php echo $stock?>" required><br>
	  					</div>

	  				<!-- Submit -->
	  				<input type="submit" id="update" name="update" value="Update" class="btn btn col-12">
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