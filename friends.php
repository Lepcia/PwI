<?php
    include("Config/Session.php");


?>
<!DOCTYPE HTML>
<html>
<head>
<title>Friends</title>
<link rel="stylesheet" type="text/css" href="Styles/page.css">
<link rel="stylesheet" type="text/css" href="Styles/grid.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
</style>
<script src="JS/tabSideMenu.js"></script>
<script>
    window.onload= function (){
        document.getElementById("searchBtnU").onclick = filterUsers;
        document.getElementById("searchBtnF").onclick = filterFriends;
        document.getElementById("defaultOpen").click();
    }

    function filterUsers(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                document.getElementById("tableUsers").innerHTML = this.responseText;
            }
        };
        var login = document.getElementById("loginTextfieldU").value;
        var firstname = document.getElementById("nameTextfieldU").value;
        var lastname = document.getElementById("lastnameTextfieldU").value;
        var email = document.getElementById("emailTextfieldU").value;

        var getStr = "getUsers.php?login="+login+"&fname="+firstname+"&lname="+lastname+"&email="+email;
        xhttp.open("GET",getStr, true);
        xhttp.send();
    }

    function filterFriends(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                document.getElementById("tableFriends").innerHTML = this.responseText;
            }
        };
        var login = document.getElementById("loginTextfieldF").value;
        var firstname = document.getElementById("nameTextfieldF").value;
        var lastname = document.getElementById("lastnameTextfieldF").value;
        var email = document.getElementById("emailTextfieldF").value;

        var getStr = "getFriends.php?login="+login+"&fname="+firstname+"&lname="+lastname+"&email="+email;
        xhttp.open("GET",getStr, true);
        xhttp.send();
    }

    function addFriend(event){
        var btnId = event.target.id;
        var id_friend = btnId.substring(btnId.indexOf('-')+1);        
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var type = document.getElementsByClassName("tab-link active")[0].value;
                switch(type){
                    case "allUsers":
                        filterUsers();
                        break;
                    case "myFriends":
                        filterFriends();
                        break;
                }
            }
        };
        var url = "addFriend.php";
        var params = "friend_id="+id_friend;
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(params);
    }

    function delFriend(event){
        var btnId = event.target.id;
        var id_friend = btnId.substring(btnId.indexOf('-')+1);
        console.log(event);        
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var type = document.getElementsByClassName("tab-link active")[0].value;

                switch(type){
                    case "allUsers":
                        filterUsers();
                        break;
                    case "myFriends":
                        filterFriends();
                        break;
                }
            }
        };
        var url = "delFriend.php";
        var params = "friend_id="+id_friend;
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(params);
    }

</script>
</head>
<body>
<header>
<h2>Friends</h2>
</header>
<nav>
<ul>
    <li><a href="/calendar.php">Calendar</a></li>
    <li><a href="/friends.php" class="active">Friends</a></li>
    <li><a href="/settings.php">Settings</a></li>
</ul>
</nav>
<section class="left-tabs">
    <button class="tab-link" id="defaultOpen" value="allUsers" onClick="changeTab(event,'allUsersTab')">All users</button>
    <button class="tab-link" value="myFriends" onClick="changeTab(event, 'myFriendsTab')">My friends</button>
</section>
<section id="allUsersTab" class="tab-content">
    <div>
    <ul class="search-panel">
        <li>
            <div class="field">
                <label>Login:</label><input id="loginTextfieldU" type="text" class="search-field" />
            </div>
        </li>
        <li>
            <div class="field">
                <label>Firstname:</label><input type="text" id="nameTextfieldU" class="search-field">
            </div>
        </li>
        <li>
            <div class="field">    
                <label>Lastname:</label><input type="text" id="lastnameTextfieldU" class="search-field">
            </div>
        </li>        
        <li>
            <div class="field">
                <label>E-mail:</label><input type="text" id="emailTextfieldU" class="search-field">
            </div>
        </li>
        <button id="searchBtnU" class="button">Search</button>
    </ul>
    </div>
    <div id="tableUsers"></div>
</section>
<section id="myFriendsTab" class="tab-content">
<div>
    <ul class="search-panel">
        <li>
            <div class="field">
                <label>Login:</label><input id="loginTextfieldF" type="text" class="search-field" />
            </div>
        </li>
        <li>
            <div class="field">
                <label>Firstname:</label><input type="text" id="nameTextfieldF" class="search-field">
            </div>
        </li>
        <li>
            <div class="field">    
                <label>Lastname:</label><input type="text" id="lastnameTextfieldF" class="search-field">
            </div>
        </li>        
        <li>
            <div class="field">
                <label>E-mail:</label><input type="text" id="emailTextfieldF" class="search-field">
            </div>
        </li>
        <button id="searchBtnF" class="button">Search</button>
    </ul>
    </div>
    <div id="tableFriends"></div>
</section>
<footer>
<p>&copy; 2017 Daria Lepa. All rights reserved.
</footer>
</body>
</html>