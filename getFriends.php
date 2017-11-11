<?php    
    include("Config/Session.php");
    
        $myLogin = mysqli_real_escape_string($db,$_SESSION["logged_user"]);
        $myId = mysqli_real_escape_string($db, $_SESSION["logged_user_id"]);
        $login = mysqli_real_escape_string($db,$_REQUEST["login"]);
        $fname = mysqli_real_escape_string($db,$_REQUEST["fname"]);
        $lname = mysqli_real_escape_string($db,$_REQUEST["lname"]);
        $email = mysqli_real_escape_string($db,$_REQUEST["email"]);
        
        $query = sprintf("SELECT users.id_user, users.login, users.firstname, users.lastname, users.email FROM `users`
        INNER join friends on users.id_user = friends.id_friend
        WHERE friends.id_user = '%s'
        AND login like '%s%%'
        AND firstname like '%s%%'
        AND lastname like '%s%%'
        AND email like '%s%%'", $myId, $login, $fname, $lname, $email);
        
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) !== 0){
            echo "<table>
            <tr>            
            <th></th>
            <th>Login</th>
            <th>Fristname</th>
            <th>Lastname</th>
            <th>Email</th>
            </tr>";
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td class='icon-column'>
                <span><i id='del-".$row['id_user']."' onClick='delFriend(event)' class='fa fa-user-times'style='color:red'></i></span></td>";
                echo "<td>". $row['login']."</td>";
                echo "<td>". $row['firstname']."</td>";
                echo "<td>". $row['lastname']."</td>";
                echo "<td>". $row['email']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else echo "Nothing was found";

?>