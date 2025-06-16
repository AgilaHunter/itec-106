<?php
session_start();
include("../dbconnect.php");
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT c_id, c_fname, c_mname, c_lname FROM customer 
        ORDER BY c_id ASC LIMIT 5";
$result = $conn->query($sql);
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
        <link rel="stylesheet" type="text/css" href="../assets/admindash_style.css">


    <title>Staff Dashboard</title>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebarstaff.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-wrapper p-2">

                <h5 style="font-size: 30px; font-weight: bolder">Welcome,  <?php echo $_SESSION['username']; ?>!</h5><br>

                <div class="container p-0 mt-2" style="background-color: #f7f3ff; border-radius: 5px; margin-top: 30px; ">
                    <h5>Staff Dashboard</h5>
                </div>
                <br>
    
                <!-- customer table dashboard -->
                <div class="p-2" style="border-radius: 5px;">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="margin-top: 10px;">
                        <h5 class="m-0">Manage Customers</h5>
                        <a href="customerAdd.php" class="btn" role="button">+ Add New Customer</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover w-100 m-0">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>

                            <?php
                                if($result->num_rows>0)
                                while($row=$result->fetch_assoc()){
                            ?>

                            <tbody>
                                <tr class="text-center">
                                    <td class="sale"><?php echo $row['c_id'] ?></td>
                                    <td class="sale"><?php echo $row['c_fname'] ?></td>
                                    <td class="sale"><?php echo $row['c_mname'] ?></td>
                                    <td class="sale"><?php echo $row['c_lname'] ?></td>
                                </tr>   
                            </tbody>

                            <?php
                                }
                            ?>
                            
                        </table>
                    </div>
                </div>

                <div class="text-center p-2">
                    <p><a href="customerRead.php" class="text-secondary">View more</a></p>
                </div>

                <!-- orders table dashboard -->
                <div class="p-2" style="border-radius: 5px;">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="margin-top: 5px;">
                        <h5 class="m-0">Manage Orders</h5>
                        <a href="orderAdd.php" class="btn" role="button" name="adds">+ Add Order</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover w-100 m-0">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>0001</td>
                                    <td>Regencia</td>
                                    <td>Samantha Arabella</td>
                                    <td>Redilla</td>
                                </tr>      
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center p-2">
                    <p><a href="orderRead.php" class="text-secondary"> View more</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fontawesome Bundle -->
    <script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.querySelector(".main-content");

        // Check localStorage on load
        const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
        if (isCollapsed) {
          sidebar.classList.add("collapsed");
          mainContent.classList.add("expanded");
        }

        // Toggle sidebar and save state
        toggleButton.addEventListener("click", () => {
          sidebar.classList.toggle("collapsed");
          mainContent.classList.toggle("expanded");
          const collapsedNow = sidebar.classList.contains("collapsed");
          localStorage.setItem("sidebarCollapsed", collapsedNow);
        });
      });
    </script>


</body>
</html>