<?php
    include("Config/Config.php");
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //Tworzenie stringa
        $myLogin = mysqli_real_escape_string($db, $_POST['login']);
        $myPassword = $_POST['password']; 

        $sql = "SELECT id_user, password FROM users WHERE login = '$myLogin'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);      
        $count = mysqli_num_rows($result);

        if($count == 1){
            if(password_verify($myPassword, $row['password'])){
                $_SESSION['logged_user'] = $myLogin;
                $_SESSION['logged_user_id'] = $row['id_user'];
                header("location: calendar.php");
            } else{
                $error = "Your password is invalid!";
            }
        } else{
            $error = "Your Login Name is invalid!";
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="Styles/page.css">
<style>
</style>
<script></script>
</head>
<body>
<header>
<h2>Login</h2>
</header>
<section class="login-form">
    <form action="" method="POST">
        <div class="form-row">
            <label>Login: </label>
            <input type="text" name="login" class="text-field" />
        </div>
        <div class="form-row">
            <label>Password: </label>
            <input type="password" name="password" class="text-field" />
        </div>
        <div class="form-button-row">
            <input type="submit" value="Submit" class="button" />
        </div>
    </form>    
    <a href="register.php">No account? Register</a>
    <div class="error">
        <?php echo $error; ?>
    </div> 
</section>
<footer>
<p>&copy; 2017 Daria Lepa. All rights reserved.
</footer>
</body>
</html>