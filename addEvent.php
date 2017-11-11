<?php
    include("Config/Session.php");

    $isValid = true;

    if(empty($_REQUEST['date']))
    {
        $isValid = false;
        echo "Date is required";
    }
    if(empty($_REQUEST['start_time']))
    {
        $isValid = false;
        echo "Start time is required";
    }
    if(empty($_REQUEST['end_time']))
    {
        $isValid = false;
        echo "End time is required";
    }
    if(empty($_REQUEST['name']))
    {
        $isValid = false;
        echo "Name is required";
    }
    
    if($isValid === TRUE){    
        $date = mysqli_real_escape_string(check_input($_REQUEST['date']));
        $startTime = mysqli_real_escape_string(check_input($_REQUEST['start_time']));
        $endTime = mysqli_real_escape_string(check_input($_REQUEST['end_time']));
        $name = mysqli_real_escape_string(check_input($_REQUEST['name']));
        $description = mysqli_real_escape_string(check_input($_REQUEST['description']));
        $id_color = mysqli_real_escape_string(check_input($_REQUEST['id_color']));
        $place = mysqli_real_escape_string(check_input($_REQUEST['place']));
        $id_organizer = mysqli_real_escape_string(check_input($_SESSION['logged_user_id']));

        $query = sprintf("INSERT INTO events (id_organizer, date, start_time, end_time, name, place, description, id_color)
        VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')", $id_organizer, $date, $startTime, $endTime, $name, $placem $description, $id_color);

        if(mysqli_query($db, $query) === TRUE){
            echo "Success";
        }
        else echo "failure";
    }

    function chech_input($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>