<?php
include("../dbconnect.php");
$sql = "SHOW TABLE STATUS LIKE 'customer'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['c_register'])){
    $c_id = $_POST['c_id'];
    $c_fname = mysqli_real_escape_string($conn, $_POST['c_fname']);
    $c_mname = mysqli_real_escape_string($conn, $_POST['c_mname']);
    $c_lname = mysqli_real_escape_string($conn, $_POST['c_lname']);
    $c_street = mysqli_real_escape_string($conn, $_POST['c_street']);
    $c_barangay = mysqli_real_escape_string($conn, $_POST['c_barangay']);
    $c_city = mysqli_real_escape_string($conn, $_POST['c_city']);
    $c_province = mysqli_real_escape_string($conn, $_POST['c_province']);
    $c_postal = mysqli_real_escape_string($conn, $_POST['c_postal']);
    $c_contact = mysqli_real_escape_string($conn, $_POST['c_contact']);
    $date_created = mysqli_real_escape_string($conn, $_POST['date_created']);

    // Insert into DB (if JS validation passed)
    $query = "INSERT INTO customer VALUES('$c_id', '$c_fname', '$c_mname', '$c_lname', '$c_street', '$c_barangay', '$c_city', '$c_province', '$c_postal', '$c_contact', '$date_created')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Registration successful'); window.location.href='customerRead.php';</script>";
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


   <title>Customer Registration</title>
</head>
<body>
    <div class="dashboard-wrapper p-2">
        <div class="card shadow">
            <div class="container p-3">
                <span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center bg-transparent shadow-sm" style="background-color: #493D9E; width: 50px; height: 50px;">
                    <a href="customerRead.php"><i class="fa fa-arrow-left" aria-hidden="true"></a></i> 
                </span>
                <div class="container p-3 mt-5 mb-5" style="background-color: #f7f3ff; border-radius: 5px;">
                    <h5>Customer Registration</h5>
                </div>
                <form action="#" method="POST" id="myForm">

                    <!-- Customer No. -->
                    <label>Customer ID</label>
                    <input type="text" id="c_id1" class="form-control mb-3" value="<?php echo $row['Auto_increment']; ?>" disabled>
                    <input type="hidden" id="c_id" name="c_id" value="<?php echo $row['Auto_increment']; ?>">

                    <h5 class="divider">Personal Information</h5>
                    <!-- Name -->
                    <div class="row g-2">
                        <div class="col">
                            <label>First Name</label>
                            <input type="text" class="form-control" placeholder="First Name" id="c_fname" name="c_fname" required>
                        </div>
                        <div class="col">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" placeholder="Middle Name" id="c_mname" name="c_mname" required>
                        </div>
                        <div class="col">
                            <label>Last Name</label>
                            <input type="text" class="form-control" placeholder="Last Name" id="c_lname" name="c_lname" required>
                        </div>
                    </div><br><br>

                    <h5 class="divider">Address and Contact Details</h5>
                    <!-- Address -->
                    <div class="row g-5">
                        <div class="col">
                            <label>Street Name</label>
                            <input type="text" id="c_street" name="c_street" class="form-control" placeholder="Blk 1 Lot 25" required><br>
                        </div>
                        <div class="col">
                            <label>Barangay</label>
                            <input type="text" id="c_barangay" name="c_barangay" class="form-control" placeholder="Navarro" required><br>
                        </div>
                        <div class="col">
                            <label>City</label>
                            <input type="text" id="c_city" name="c_city" class="form-control" placeholder="General Trias" required><br>
                        </div>
                        <div class="col">
                            <label>Province</label>
                            <input type="text" id="c_province" name="c_province" class="form-control" placeholder="Cavite" required><br>
                        </div>
                        <div class="col">
                            <label>Postal Code</label>
                            <input type="number" id="c_postal" name="c_postal" class="form-control" placeholder="4107" required><br>
                        </div>
                    </div>

                    <label>Contact Number</label>
                    <input type="tel" pattern="^\d{11}$" name="c_contact" class="form-control" placeholder="09#########" required oninput="validateNumber(this)" /><br><br>

                    <label>Date Created</label>
                    <input type="date" id="date_created" name="date_created" value="<?php echo date('Y-m-d'); ?>" readonly class="form-control"><br><br>

                    <!-- Submit -->
                    <input type="submit" id="c_register" name="c_register" value="Register" class="btn btn btn col-12">
                    <input type="reset" id="clear" class="btn btn btn col-12">
                </form>   

    <!-- Fontawesome Bundle -->
    <script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>
    
</body>
</html>