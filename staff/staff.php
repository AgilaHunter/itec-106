<?php
session_start();
include("../dbconnect.php");
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}

$staff_id = $_SESSION['staff_id'];

$sql = "
    SELECT 
        c.c_id, 
        c.c_fullname, 
        COUNT(o.id) AS order_count,
        MAX(o.order_date) AS last_order_date
    FROM customer c
    LEFT JOIN orders o ON o.cid = c.c_id
    GROUP BY c.c_id
    ORDER BY last_order_date DESC
    LIMIT 5
";
$result = $conn->query($sql);

 $orders_sql = "
    SELECT 
        o.id AS order_id,
        c.c_fullname,
        o.quantity,
        o.total,
        o.order_date
    FROM orders o
    LEFT JOIN customer c ON o.cid = c.c_id
    WHERE o.staff_id = ?
    ORDER BY o.order_date DESC
    LIMIT 5
";
$orders_stmt = $conn->prepare($orders_sql);
$orders_stmt->bind_param("i", $_SESSION['staff_id']); // Use the correct session variable
$orders_stmt->execute();
$orders_result = $orders_stmt->get_result();

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
                    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 10px;">
                        <h5 class="m-0">Customers</h5>
                        
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-hover m-0">
                            <thead class="align-middle">
                                <tr class="text-center">
                                    <th class="p-2">Customer ID</th>
                                    <th class="p-2">Full Name</th>
                                    <th class="p-2">Times Ordered</th>
                                    <th class="p-2">Last Ordered</th>
                                </tr>
                            </thead>

                            <?php
                                if($result->num_rows>0)
                                while($row=$result->fetch_assoc()){
                            ?>

                            <tbody class="align-middle">
                                <tr class="text-center">

                                    <td class="p-2"><?php echo $row['c_id']; ?></td>
                                    <td class="p-2"><?php echo $row['c_fullname']; ?></td>
                                    <td class="p-2"><?php echo $row['order_count']; ?></td>
                                    <td class="p-2"><?php echo date("F j, Y h:i A", strtotime($row['last_order_date'])); ?></td>

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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="m-0">Orders</h5>
                        <a href="orderAdd.php" class="btn" role="button" name="adds">+ Add Order</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-hover m-0">
                            <thead class="align-middle">
                                <tr class="text-center">
                                    <th class="p-2">Order ID</th>
                                    <th class="p-2">Product Quantity</th>
                                    <th class="p-2">Total</th>
                                    <th class="p-2">Order Date</th>
                                </tr>
                            </thead>
                            <?php
                                if($orders_result->num_rows>0)
                                while($order=$orders_result->fetch_assoc()){
                            ?>
                            <tbody>
                                <tr class="text-center">
                                     <td class="p-2"><?php echo $order['order_id']; ?></td>
                                     <td class="p-2"><?php echo $order['quantity']; ?></td>
                                     <td class="p-2">₱<?php echo $order['total']; ?></td>
                                     <td class="p-2"><?php echo date("F j, Y h:i A", strtotime($order['order_date'])); ?></td>
                                </tr>      
                            </tbody>
                            <?php
                                }
                            ?>
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