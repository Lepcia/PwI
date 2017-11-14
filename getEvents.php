<?php
    include("Config/Session.php");

    header("Content-Type: application/json; charset=UTF-8");
    $id_user = mysqli_real_escape_string($db,$_SESSION['logged_user_id']);
    
    $query = sprintf("SELECT e.id_event, e.id_organizer, e.name, 
    e.date, e.start_time, e.end_time, e.place, e.description, e.color_hex 
    FROM events e LEFT JOIN users_to_events ute ON e.id_event = ute.id_event
    WHERE e.id_organizer = '%s' OR ute.id_user = '%s'", $id_user, $id_user);

    $result = mysqli_query($db,$query);
    $rows = array();
    if(mysqli_num_rows($result) !== 0){
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        echo json_encode($rows);
    }
?>