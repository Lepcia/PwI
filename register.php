<?php
    include("Config/Config.php");
    session_start();
    
    $loginError = $fnError = $lnError = $passwordError = $cpassworderror = $emailError = "";
    $login = $firstname = $lastname = $password = $cpassword = $email = '';
    $isValid = true;
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        if(empty($_POST["login"])) {
            $isValid = false;
            $loginError = "Login jest wymagany!";
        } elseif(!preg_match('/^[a-zA-Z]\w{2,20}$/', $_POST["login"])){
            $isValid = false;            
            $loginError = "Login musi mieć przynajmniej 3 znaki w tym jedną literę na początku.\r\n";
        } else{            
            $login = chech_input($_POST['login']);
            $login = mysqli_real_escape_string($db,$login);
            $query = "SELECT id_user FROM users WHERE login = '$login'";
            $result = mysqli_query($db,$query);
            if( mysqli_num_rows($result) !== 0){
                $isValid=false;
                $loginError = "Wybrany login jest już zajęty.";
            }
        }
        if(empty($_POST["firstname"])) {
            $isValid = false;
            $fnError="Imie jest wymagane!";
        } elseif(!preg_match('/^[a-zA-Z\s]{2,30}$/', $_POST["firstname"])){
            $isValid = false;
            $firstname = chech_input($_POST["firstname"]);
            $fnError = "Imie może zawierać tylko litery i białe znaki.";
        }
        if(empty($_POST["lastname"])) {
            $isValid = false;
            $lnError = "Nazwisko jest wymagane!";
        } elseif(!preg_match('/^[a-zA-Z\s]{2,30}$/', $_POST["lastname"])){
            $isValid = false;            
            $lnError = "Nazwisko może zawierać tylko litery i białe znaki.";
        } 
        if(empty($_POST["email"])) {
            $isValid = false;
            $emailError = "Email jest wymagany!";
        } else{
            $email = chech_input($_POST["email"]);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $isValid = false;
                $emailError = "Zły format adresu email.";
            } else{
                $email = mysqli_real_escape_string($db,$email);
                $query = "SELECT id_user FROM users WHERE email = '$email'";
                $result = mysqli_query($db,$query);
                if(mysqli_num_rows($result) !== 0){
                    $isValid = false;
                    $emailError = "Email jest już zajęty.";
                }
            }
        }
        if(!empty($_POST["password"]) && ($_POST["password"] === $_POST["confirmpassword"])) {        
            if(strlen($_POST["password"]) < '8') {
                $isValid = false;
                $passwordError .= "Hasło musi mieć przynajmniej 8 znaków.\r\n";
            }
            if(!preg_match('/[0-9]+/',$_POST["password"]))
            {
                $isValid = false;
                $passwordError .= "Hasło musi zawierać przynajmniej jedną cyfre.\r\n";
            }
            if(!preg_match('/[A-Z]+/', $_POST["password"]))
            {
                $isValid = false;
                $passwordError .= "Hasło musi zawierać przynajmniej jedną dużą litere.\r\n";
            }
        } elseif(!empty($_POST["password"])){
            $isValid = false;
            $cpasswordError = "Hasła nie są zgodne!";
        } else{
            $isValid = false;
            $passwordError = "Hasło jest wymagane!";
        }
        
        if($isValid){
            $login = mysqli_real_escape_string($db,$_POST["login"]);
            $firstname = mysqli_real_escape_string($db,chech_input($_POST["firstname"]));
            $lastname = mysqli_real_escape_string($db,chech_input($_POST["lastname"]));
            $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $query = "INSERT INTO `users`(`login`,`firstname`,`lastname`,`email`,`password`) VALUES ('$login', '$firstname', '$lastname','$email','$hash_password')";
            $result = mysqli_query($db,$query);
            if($result){
                header("location: login.php");
            } else{
                $error = "Zarejestrowanie użytkownika nie powiodło się. Spróbuj ponownie.";
            }
        }
    }

    //zapobieganie sql injections
    function chech_input($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" type="text/css" href="Styles/page.css">
<style>
    
</style>
<script></script>
</head>
<body>
<header>
<h2>Register</h2>
</header>
<section class="login-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="form-row">
            <span class="error"><?php echo $error; ?></span>
        </div>
        <div class="form-row">
            <label>Login: </label>
            <input type="text" name="login" class="text-field" tabindex="1" value="<?php echo $_POST['login'];?>" />
        </div>
        <div class="form-row">
            <span class="error"><?php echo $loginError; ?></span>
        </div>
        <div class="form-row">
            <label>First name: </label>
            <input type="text" name="firstname" class="text-field" tabindex="2" value="<?php echo $_POST['firstname'];?>" />
        </div>
        <div class="form-row">
            <span class="error"><?php echo $fnError; ?></span>
        </div>
        <div class="form-row">
            <label>Last name: </label>
            <input type="text" name="lastname" class="text-field" tabindex="3" value="<?php echo $_POST['lastname'];?>" />
        </div>
        <div class="form-row">
            <span class="error"><?php echo $lnError; ?></span>        
        </div>
        <div class="form-row">
            <label>Password: </label>
            <input type="password" name="password" class="text-field" tabindex="4" />
        </div>
        <div class="form-row">
            <span class="error"><?php echo $passwordError; ?></span>
        </div>
        <div class="form-row">
            <label>Confirm Password: </label>
            <input type="password" name="confirmpassword" class="text-field" tabindex="5"/>
        </div>
        <div class="form-row">
            <span class="error"><?php echo $cpasswordError; ?></span>
        </div>
        <div class="form-row">
            <label>E-mail: </label>
            <input type="email" name="email" class="text-field" tabindex="6" value="<?php echo $_POST['email'];?>" />
        </div>
        <div class="form-row">
            <span class="error"><?php echo $emailError; ?></span>
        <div>
        <div class="form-button-row">
            <input type="submit" value="Register" class="button" />
        </div>
    </form>
</section>
<footer>
<p>&copy; 2017 Daria Lepa. All rights reserved.
</footer>
</body>
</html>