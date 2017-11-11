<?php
    define('DB_SERVER', 'localhost');
    define('DB_DATABASE', 'calendar');
    define('DB_USERNAME', 'Admin');
    define('DB_PASSWORD', 'PwICal2017');
    
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>