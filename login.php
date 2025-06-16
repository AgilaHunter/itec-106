<?php
session_start();
include("dbconnect.php");

if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // First, check admin table
    $query_admin = "SELECT * FROM login WHERE username=? AND password=?";
    $stmt_admin = mysqli_prepare($conn, $query_admin);
    mysqli_stmt_bind_param($stmt_admin, "ss", $username, $password);
    mysqli_stmt_execute($stmt_admin);
    $result_admin = mysqli_stmt_get_result($stmt_admin);

    if (mysqli_num_rows($result_admin) == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin'; // Manually set since login table has only admin

        header("Location: admin/admin.php"); // Redirect to admin dashboard
        exit();
    }

    // If not found in admin table, check staff table
    $query_staff = "SELECT * FROM staff WHERE username=? AND password=?";
    $stmt_staff = mysqli_prepare($conn, $query_staff);
    mysqli_stmt_bind_param($stmt_staff, "ss", $username, $password);
    mysqli_stmt_execute($stmt_staff);
    $result_staff = mysqli_stmt_get_result($stmt_staff);

    if (mysqli_num_rows($result_staff) == 1) {
        $user = mysqli_fetch_assoc($result_staff);

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['position']; // e.g., 'staff'

        header("Location: staff/staff.php"); // Redirect to staff dashboard
        exit();
    }

    else{// If neither admin nor staff found
    echo'<script>
				window.location.href = "index.php";
				alert("Login failed. Invalid username or password");
				</script>';
    }
}
?>
