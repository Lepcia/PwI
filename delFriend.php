<?php
    include("Config/Session.php");

    $myId = mysqli_real_escape_string($db, $_SESSION["logged_user_id"]);
    $friendId = mysqli_real_escape_string($db, $_REQUEST["friend_id"]);

    $query = sprintf("DELETE FROM friends WHERE id_user = '%s' AND id_friend = '%s'", $myId, $friendId);
    if(mysqli_query($db, $query) === TRUE)
    {
        echo "Success";
    }
    else echo "Failure";
?>