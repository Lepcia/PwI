<?php
    include("Config/Session.php");

    $myId = mysqli_real_escape_string($db, $_SESSION["logged_user_id"]);
    $friendId = mysqli_real_escape_string($db, $_POST["friend_id"]);

    $query = sprintf("INSERT INTO friends (id_user, id_friend) VALUES('%s', '%s')", $myId, $friendId);
    if(mysqli_query($db, $query) === TRUE)
    {
        echo "Success";
    }
    else echo "Failure";
?>