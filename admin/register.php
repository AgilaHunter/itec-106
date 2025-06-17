<?php
include("../dbconnect.php");
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
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- css bootstrap -->
    <link rel="stylesheet" type="text/css" href="../bootstrap-5.0.2-dist\css\bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-5.0.2-dist\js\bootstrap.min.js"></script>

   <!-- external css -->
    <link rel="stylesheet" type="text/css" href="../assets/forms.css">


   <title>Staff Registration</title>
</head>
<body>
    <div class="dashboard-wrapper p-2">
        <div class="card shadow">
            <div class="container p-3">
                <span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center bg-transparent shadow-sm" style="background-color: #493D9E; width: 50px; height: 50px;">
                    <a href="staffRead.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                </span>
                <div class="container p-3 mt-5 mb-5" style="background-color: #f7f3ff; border-radius: 5px;">
                    <h5>Staff Registration</h5>
                </div>
                <form action="#" method="POST" id="myForm">

                    <h5 class="divider">Work Credentials</h5>
                    <!-- Employee No. -->
                    <label>Employee ID</label>
                    <input type="text" id="id1" class="form-control mb-3" value="<?php echo $row['Auto_increment']; ?>" disabled>
                    <input type="hidden" id="id" name="id" value="<?php echo $row['Auto_increment']; ?>">
                
                    <!-- Position -->
                    <label>Position</label>
                    <input type="text" id="position1" class="form-control" name="position1" value="Staff" disabled><br>
                    <input type="hidden" id="position" class="form-control" name="position" value="staff">

                    <!-- Username -->
                    <label>Username</label>
                    <input type="text" id="user" name="user" class="form-control" placeholder="John" required>
                    <br><br>

                    <h5 class="divider">Personal Information</h5>
                    <!-- Name -->
                    <div class="row g-2">
                        <div class="col">
                            <label>First Name</label>
                            <input type="text" class="form-control" placeholder="First Name" id="fname" name="fname" required>
                        </div>
                        <div class="col">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" placeholder="Middle Name" id="mname" name="mname" required>
                        </div>
                        <div class="col">
                            <label>Last Name</label>
                            <input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname" required>
                        </div>
                    </div><br><br>

                    <h5 class="divider">Address and Contact Details</h5>
                    <!-- Address -->
                    <div class="row g-5">
                        <div class="col">
                            <label>Street Name</label>
                            <input type="text" id="street" name="street" class="form-control" placeholder="Blk 1 Lot 25" required><br>
                        </div>
                        <div class="col">
                            <label>Barangay</label>
                            <input type="text" id="barangay" name="barangay" class="form-control" placeholder="Navarro" required><br>
                        </div>
                        <div class="col">
                            <label>City</label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="General Trias" required><br>
                        </div>
                        <div class="col">
                            <label>Province</label>
                            <input type="text" id="province" name="province" class="form-control" placeholder="Cavite" required><br>
                        </div>
                        <div class="col">
                            <label>Postal Code</label>
                            <input type="number" id="postal" name="postal" class="form-control" placeholder="4107" required><br>
                        </div>
                    </div>

                    <label>Contact Number</label>
                    <input type="tel" pattern="^\d{11}$" name="contact" class="form-control" placeholder="09#########" required oninput="validateNumber(this)" /><br><br>

                    <h5 class="divider">Salary</h5>
                    <label>Monthly Salary</label>
                    <input type="number" step="0.01" id="salary" name="salary" class="form-control" placeholder="24000.00" required><br><br>

                    <!-- Password -->
                    <div class="row g-2">
                        <div class="col">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                            <small id="passwordError" style="color: red;"></small>
                        </div>
                        <div class="col">
                            <label>Confirm Password</label>
                            <input type="password" id="confirm" name="confirm" class="form-control" placeholder="Confirm Password" required>
                            <small id="confirmError" style="color: red;"></small><br>
                        </div>
                    </div><br><br>

                    <!-- Submit -->
                    <input type="submit" id="register" name="register" value="Register" class="btn btn btn col-12">
                    <input type="reset" id="clear" class="btn btn btn col-12">
                </form>

    <!-- Fontawesome Bundle -->
    <script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>   

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