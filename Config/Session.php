<?php
    include('config.php');

    session_start();

    $chceck_user = $_SESSION['login_user'];

    $sql_session = mysqli_query($db, "SELECT login FROM Users WHERE login - '$check_user' ");
    $row = mysqli_fetch_array($sql_session, MYSQLI_ASSOC);
    $login_session = $row['login'];

    
   if(!isset($_SESSION['login_user'])){
        header("location:login.php");
    }
?>