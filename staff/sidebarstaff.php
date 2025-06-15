<?php
  $currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar d-flex flex-column shadow bg-light p-3" id="sidebar">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="m-0"><b>POS System</b></h5>
    <button id="toggleSidebar" class="btn bg-transparent">
      <i class="fas fa-bars" style="color: #7107d0; font-size: 20px;"></i>
    </button>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="staff.php" class="nav-link <?php echo ($currentPage == 'staff.php') ? 'active' : ''; ?>">
        <i class="fa fa-home pe-2"></i><span>Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="customerRead.php" class="nav-link <?php echo ($currentPage == 'customerRead.php') ? 'active' : ''; ?>">
        <i class="fa fa-user-group pe-2"></i><span>Customer Information</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="orderRead.php" class="nav-link <?php echo ($currentPage == 'orderRead.php') ? 'active' : ''; ?>">
        <i class="fa fa-cart-shopping"></i><span>Orders</span>
      </a>
    </li>
    <hr>
    <li class="nav-item">
      <a href="../logout.php" class="nav-link">
        <i class="fa fa-sign-out pe-2"></i><span>Logout</span>
      </a>
    </li>
  </ul>
</div>
