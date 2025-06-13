<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <div id="form">
        <h1 id="loginText">Login Form</h1>
        <?php if(isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form name="form" action="login.php" method="POST">
            <input type="text" id="user" name="user" required placeholder="Enter Username"><br><br>
            <input type="password" id="pass" name="pass" required placeholder="Enter Password"><br><br>
            <input type="submit" id="btn" value="Login" name="submit">
        </form>
    </div>
</body>
</html>