<?php
include("../dbconnect.php");
$sql = "SHOW TABLE STATUS LIKE 'products'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['register'])){
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // Hash password (SECURITY FIX)
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB (if JS validation passed)
    $query = "INSERT INTO products VALUES('$id', '$name', '$price', '$stock')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Product Added'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- css bootstrap -->
    <link rel="stylesheet" type="text/css" href="../bootstrap-5.0.2-dist\css\bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-5.0.2-dist\js\bootstrap.min.js"></script>

   <!-- external css -->
    <link rel="stylesheet" type="text/css" href="../assets/forms.css">


   <title>Add Product</title>
</head>
<body>
    <div class="dashboard-wrapper p-2">
        <div class="card shadow">
            <div class="container p-3">
                <span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center bg-transparent shadow-sm" style="background-color: #493D9E; width: 50px; height: 50px;">
                    <a href="staffRead.php"><i class="fa fa-arrow-left" aria-hidden="true"></a></i> 
                </span>
                <div class="container p-3 mt-5 mb-5" style="background-color: #f7f3ff; border-radius: 5px;">
                    <h5>Add Product</h5>
                </div>
                <form action="#" method="POST" id="myForm">

                    <h5 class="divider">Details</h5>
                    <!-- ID -->
                    <label>Product ID</label>
                    <input type="text" id="id1" class="form-control mb-3" value="<?php echo $row['Auto_increment']; ?>" disabled>
                    <input type="hidden" id="id" name="id" value="<?php echo $row['Auto_increment']; ?>">
                
                    <!-- Name -->
                    <label>Product Name</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Product Name" required><br>

                    <!-- Price -->
                    <label>Price</label>
                    <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="99.99" required><br>

                    <!-- Stock -->
                    <label>Stock</label>
                    <input type="number" id="stock" name="stock" class="form-control" placeholder="99" required>
                    <br><br>

                    <!-- Submit -->
                    <input type="submit" id="register" name="register" value="Register" class="btn btn btn col-12">
                    <input type="reset" id="clear" class="btn btn btn col-12">
                </form>   

    <!-- JavaScript Validation -->
    <script>
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
</body>
</html>