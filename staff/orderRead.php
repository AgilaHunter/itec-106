<?php
    session_start();
    include("../dbconnect.php");
    if(!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'staff') {
        header("Location: login.php");
        exit();
    }
    $orders_sql = 
        "
        SELECT 
            o.*
        FROM orders o
        LEFT JOIN customer c ON o.cid = c.c_id
        WHERE o.staff_id = ?
        ORDER BY o.order_date DESC
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

    <title>Order Information Page</title>
</head>

<body>
    
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebarstaff.php'; ?>    

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-wrapper p-2">
                <div class="container p-0 mt-4" style="background-color: #f7f3ff; border-radius: 5px;">
                    <h5>Order Information Tab</h5>
                </div>

                <!-- order table dashboard -->
                <div class="p-2" style="border-radius: 5px;">
                    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 5px;">
                        <h5 class="m-0">Manage Order</h5>
                        <a href="orderAdd.php" class="btn" role="button">+ Add Order</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-hover m-0" id="performance">
                            <thead class="align-middle">
                                <tr class="text-center">
                                    <th class="p-2">Order ID</th>
                                    <th class="p-2">Name</th>
                                    <th class="p-2">Email</th>
                                    <th class="p-2">Contact Number</th>
                                    <th class="p-2">Address</th>
                                    <th class="p-2">Product ID</th>
                                    <th class="p-2">Quantity</th>
                                    <th class="p-2">Total</th>
                                    <th class="p-2">Order Date</th>
                                </tr>
                            </thead>

                            <?php
                                if($orders_result->num_rows>0)
                                while($order=$orders_result->fetch_assoc()){
                            ?>

                            <tbody class="align-middle">
                                <tr class="text-center">
                                    <td class="sale p-2"><?php echo $order['id'] ?></td>
                                    <td class="sale p-2"><?php echo $order['customer_name'] ?></td>
                                    <td class="sale p-2"><?php echo $order['email'] ?></td>
                                    <td class="sale p-2"><?php echo $order['contact'] ?></td>
                                    <td class="sale p-2"><?php echo $order['address'] ?></td>
                                    <td class="sale p-2"><?php echo $order['product_id'] ?></td>
                                    <td class="sale p-2"><?php echo $order['quantity'] ?></td>
                                    <td class="sale p-2">₱<?php echo $order['total'] ?></td>
                                    <td class="sale p-2"><?php echo date("F j, Y h:i A", strtotime($order['order_date'])); ?></td>
                                </tr>   
                            </tbody>
                            <?php
                                }
                            ?>
                        </table>
                    </div>
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