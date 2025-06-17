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
      <a href="admin.php" class="nav-link <?php echo ($currentPage == 'admin.php') ? 'active' : ''; ?>">
        <i class="fa fa-home pe-2"></i><span>Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="staffRead.php" class="nav-link <?php echo ($currentPage == 'staffRead.php') ? 'active' : ''; ?>">
        <i class="fa fa-user pe-2"></i><span>Staff Information</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="report.php" class="nav-link <?php echo ($currentPage == 'report.php') ? 'active' : ''; ?>">
        <i class="fa fa-chart-line pe-2"></i><span>Report</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="inventory.php" class="nav-link <?php echo ($currentPage == 'inventory.php') ? 'active' : ''; ?>">
        <i class="fa fa-list-alt pe-2"></i><span>Inventory</span>
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
