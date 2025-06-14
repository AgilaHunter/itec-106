<?php
session_start();
include("../dbconnect.php");

if(isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    
    // Use prepared statements for security
    $query = "SELECT * FROM staff WHERE username=? AND password=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['position']; // Assuming 'position' column stores role
        
        // Redirect based on role
        if($user['position'] == 'admin') {
            header("Location: admin/admin.php");
        } elseif($user['position'] == 'staff') {
            header("Location: staff.php");
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>