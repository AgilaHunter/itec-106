<?php
include("dbconnect.php");
$sql = "SHOW TABLE STATUS LIKE 'staff'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['register'])){
    $id = $_POST['id'];
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $postal = mysqli_real_escape_string($conn, $_POST['postal']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm']);

    // Hash password (SECURITY FIX)
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB (if JS validation passed)
    $query = "INSERT INTO staff VALUES('$id', '$position', '$user', '$fname', '$mname', '$lname', '$street', '$barangay', '$city', '$province', '$postal', '$contact', '$salary', '$password', '$confirm')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Registration successful'); window.location.href='staffRead.php';</script>";
    } else {
        echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Registration</title>
    <link rel="stylesheet" href="reg1.css">
</head>
<body>
    <form class="reg-container" method="POST" id="myForm">
        <h1>Account Registration</h1>

        <ul>
		<li><a href="admin.php">Home</a></li>
		<li><a href="index.php">Logout</a></li>
		<li><a href="register.php">Add Staff</a></li>
		<li><a href="staffRead.php">CRUD Staff Info</a></li>
	</ul><br>

        <!-- (Your existing HTML form fields remain the same) -->
        <label>ID</label>
        <input type="text" id="id1" name="id1" value="<?php echo $row['Auto_increment']; ?>" disabled><br>
        <input type="hidden" id="id" name="id" value="<?php echo $row['Auto_increment']; ?>">

        <label>Position</label>
        <input type="text" id="position1" name="position1" value="Staff" disabled><br>
        <input type="hidden" id="position" name="position" value="staff">

        <label>Username</label>
        <input type="text" id="user" name="user" placeholder="John" required><br>

        <label>First Name</label>
        <input type="text" id="fname" name="fname" placeholder="John" required><br>

        <label>Middle Name</label>
        <input type="text" id="mname" name="mname" placeholder="Herman" required><br>

        <label>Last Name</label>
        <input type="text" id="lname" name="lname" placeholder="Doe" required><br>

        <label>Street Name</label>
        <input type="text" id="street" name="street" placeholder="Blk 1 Lot 25" required><br>
        
        <label>Barangay</label>
        <input type="text" id="barangay" name="barangay" placeholder="Navarro" required><br>

        <label>City</label>
        <input type="text" id="city" name="city" placeholder="General Trias" required><br>

        <label>Province</label>
        <input type="text" id="province" name="province" placeholder="Cavite" required><br>

        <label>Postal Code</label>
        <input type="number" id="postal" name="postal" placeholder="4107" required><br>

        <label>Contact Number</label>
        <input type="tel" pattern="^\d{11}$" name="contact" placeholder="09#########" required oninput="validateNumber(this)" /><br>

        <label>Monthly Salary</label>
        <input type="number" step="0.01" id="salary" name="salary" placeholder="24000.00" required><br>

        <label>Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <small id="passwordError" style="color: red;"></small><br>

        <label>Confirm Password</label>
        <input type="password" id="confirm" name="confirm" placeholder="Confirm Password" required>
        <small id="confirmError" style="color: red;"></small><br>

        <input type="submit" id="register" name="register" value="Register">
        <input type="reset">
        <a href="staffRead.php">Back</a>
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