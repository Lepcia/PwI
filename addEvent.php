<?php
    include("Config/Session.php");
    $isValid = true;
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode($_POST["params"], false);
    
    if(empty($data->eventName))
    {
        $isValid = false;
        echo "Name is required";
    }
    if(empty($data->date) && !preg_match('^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$', $data->date))
    {
        $isValid = false;
        echo "Start time is required";
    }
    if(empty($data->startTime) && !preg_match('^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$', $data->startTime))
    {
        $isValid = false;
        echo "End time is required";
    }
    if(empty($data->endTime) && !preg_match('^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$', $data->endTime))
    {
        $isValid = false;
        echo "Name is required";
    }
    
    if($isValid === TRUE){   

        $date = mysqli_real_escape_string($db,$data->date);
        $startTime = mysqli_real_escape_string($db,$data->startTime);
        $endTime = mysqli_real_escape_string($db,$data->endTime);
        $name = mysqli_real_escape_string($db, check_input($data->eventName));
        $description = mysqli_real_escape_string($db,check_input($data->description));
        $color_hex = mysqli_real_escape_string($db,check_input($data->color));
        $place = mysqli_real_escape_string($db,check_input($data->place));
        $id_organizer = mysqli_real_escape_string($db,$_SESSION['logged_user_id']);

        $query = sprintf("INSERT INTO events (id_organizer, `date`, start_time, end_time, `name`, place, `description`, color_hex)
        VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')", $id_organizer, $date, $startTime, $endTime, $name, $place, $description, $color_hex);

        if(mysqli_query($db, $query) === TRUE){
            echo "Success";
        }
        else echo "failure";
    }

    function check_input($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>