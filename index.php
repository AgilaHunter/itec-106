<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- css bootstrap -->
        <link rel="stylesheet" type="text/css" href="bootstrap-5.0.2-dist\css\bootstrap.min.css">
        <script type="text/javascript" src="bootstrap-5.0.2-dist\js\bootstrap.min.js"></script>

    <!-- external css -->
        <link rel="stylesheet" type="text/css" href="assets/logsign_style.css">


    <title>Login</title>
</head>

<body>

    <div class="container-fluid p-3 mb-5">
   
    </div>

        
    <div class="container my-5 px-3">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5">
                <div class="card show mx-auto">

                    <h4><b>Login</b></h4>
                    
                    <form name="form" action="login.php" method="POST">
                        <div class="container">
                            <label>Username</label><br>
                            <input type="text" class="form-control" id="user" name="user" placeholder="Enter username" required>
                        </div>

                        <div class="container">
                            <label>Password</label><br>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter password" required>
                        </div>
                        <br>

                        <div class="container">
                            <input type="submit" class="btn btn col-12" id="btn" name="submit" value="Login"></input><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Fontawesome Bundle -->
    <script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>

</body>
</html>
