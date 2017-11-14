<?php
    include("Config/Session.php");

    header("Content-Type: application/json; charset=UTF-8");
    $id_user = mysqli_real_escape_string($db,$_SESSION['logged_user_id']);
    $data = json_decode($_POST["params"], false);
    $isValid = true;
    $simple = "Simple";
    $full = "Full";
    $type = $data->type;

    if(empty($data->eventName) && $data->type == $full)
    {
        $isValid = false;
        echo "Name is required";
    }
    if(empty($data->date) && !preg_match('^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$', $data->date))
    {
        $isValid = false;
        echo "Date is required";
    }
    if(empty($data->startTime) && !preg_match('^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$', $data->startTime) && $data->type == $full)
    {
        $isValid = false;
        echo "Start time is required";
    }
    if(empty($data->endTime) && !preg_match('^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$', $data->endTime) && $data->type == $full)
    {
        $isValid = false;
        echo "End time is required";
    }
    
    if($isValid === TRUE){   
        $date = mysqli_real_escape_string($db,$data->date);
        $startTime = mysqli_real_escape_string($db,$data->startTime);
        $endTime = mysqli_real_escape_string($db,$data->endTime);
        $name = mysqli_real_escape_string($db, check_input($data->eventName));
        $description = mysqli_real_escape_string($db,check_input($data->description));
        $color_hex = mysqli_real_escape_string($db,check_input($data->color));
        $place = mysqli_real_escape_string($db,check_input($data->place));
        $id_event = mysqli_real_escape_string($db, check_input($data->id_event));

        $query=sprintf("UPDATE events SET name = COALESCE(NULLIF('%s', ''), name),
        date = COALESCE(NULLIF('%s', ''), date),
        start_time = COALESCE(NULLIF('%s', ''), start_time),
        end_time = COALESCE(NULLIF('%s', ''), end_time),
        place = COALESCE(NULLIF('%s', ''), place),
        description = COALESCE(NULLIF('%s', ''), description), 
        color_hex = COALESCE(NULLIF('%s', ''), color_hex)
        WHERE id_event = '%s'", $name, $date, $startTime, $endTime, $place, $description, $color_hex, $id_event);
    
        if(mysqli_query($db, $query) === TRUE){
            echo "Success";
        }
        else {
            echo "Failure";
        }
    }

    function check_input($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>