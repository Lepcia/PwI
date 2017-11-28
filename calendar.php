<!DOCTYPE HTML>
<?php
    include("Config/Session.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="Styles/page.css">
<link rel="stylesheet" type="text/css" href="Styles/month-calendar.css">
<link rel="stylesheet" type="text/css" href="Styles/modal-box.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
</style>
<script src="JS/tabSideMenu.js"></script>
<script>
window.onload = function(){
    var today = new Date();
    document.getElementById("defaultOpen").click();
    createCalendarHeader(today);
    createCalendarTable();
    createMonthView(today);
    getEvents();

    var modal = document.getElementById('eventModal');
    
    var saveBtn = document.getElementById("saveEventBtn");
    saveBtn.addEventListener('click', function(){addEvent()});

    var span = document.getElementsByClassName("close")[0];
    span.onclick = function(){
        modal.style.display = "none";
    }

    window.onclick = function(event) {
    if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var cancelBtn = document.getElementById("cancelBtn");
    cancelBtn.onclick = function(){
        modal.style.display = "none";
    }  
}
function redirect(path){
    document.location.href = "/" + path;
}

function allowDrop(e) {
    e.preventDefault();
}

function drag(e) {
    e.dataTransfer.setData("text", e.target.id);
}

function drop(e, target) {
    e.preventDefault();
    var eventBoxID = e.dataTransfer.getData("text");
    e.target.appendChild(document.getElementById(eventBoxID));
    this.changeText(e);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            console.log(this.response);
        }
    };
    var strDate = document.getElementById(e.target.id).getElementsByTagName("input")[0].value;
    var id_event = document.getElementById(eventBoxID).getElementsByTagName("input")[0].value;
    var updateObj = {};
    updateObj.id_event = id_event;
    updateObj.date = strDate;
    updateObj.type = "Simple";
    var myJSON = JSON.stringify(updateObj);
    console.log(myJSON);
    var url = "updateEvent.php";
    
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("params="+myJSON);
}

function changeText(e){
    var target = document.getElementById(e.target.id);
    var dragId = e.dataTransfer.getData("text");
}

function closeModal(){
    var modal = document.getElementById('eventModal');
    modal.style.display = "none";
}

function openModal(event){
    var modal = document.getElementById('eventModal');
    modal.style.display = "block";    

    var date = document.getElementById(event.target.id).childNodes[0].childNodes[0].value;
    console.log(date);
    setFormDate(date);
}

function setFormDate(date){
    document.getElementById("eventDateField").value = date;
    document.getElementById("descriptionField").value = "wfwefwefwf";
    document.getElementById("eventNameField").value = "Event";
    document.getElementById("placeField").value = "place";
}

function addEventToCalendar(e, target){ 
    var day = e.date.split("-")[2];
    var target = document.getElementById("day-"+day).parentElement;
    var div = document.createElement('div');
    var startTime = e.start_time.substr(0, e.start_time.lastIndexOf(":"));
    var endTime = e.end_time.substr(0, e.end_time.lastIndexOf(":"));
    div.id="event" + e.id_event;
    div.innerHTML = "<input type='hidden' name='id_event' value='" + e.id_event + "'> <h5>" + e.name+"</h5><h5>" + startTime + "-" + endTime + "</h5>";
    div.setAttribute("class", "event-box col-7");
    div.setAttribute("draggable", true);
    div.setAttribute("ondragstart", "drag(event)");
    div.setAttribute("style", "background-color: " + e.color_hex + "!Important; border-color: " + e.color_hex + ";");
    target.appendChild(div);
}

function addEvent(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var e = JSON.parse(this.response);
            addEventToCalendar(e);
            closeModal();
        }
    };
    var myJSON = getEventFormData();
    var url = "addEvent.php";
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("params="+myJSON);
}

function getEventFormData(){
    var inputs = document.forms["eventForm"].getElementsByTagName('input');
    var data = {};
    for(var i = 0; i < inputs.length; i++){
        data[inputs[i].name] = inputs[i].value;
    }
    data["description"] = document.getElementById("descriptionField").value;
    var myJSON = JSON.stringify(data);
    return myJSON;
}

function getEvents(){
    console.log("get events");
    var dateStr = document.getElementById('hiddenDate').value.split('-');
    var date = new Date(dateStr[0], dateStr[1] - 1, dateStr[2]);
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var daysInMonth = new Date(year, month, 0).getDate();
    var params = "year="+year+"&month="+month+"&days="+daysInMonth;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            if(this.response !== ""){
                var arrayOfObjects = JSON.parse(this.responseText);
                for(var i = 0; i < arrayOfObjects.length; i++){
                    var addEvent = arrayOfObjects[i];
                    addEventToCalendar(addEvent);
                }
            }
        }
    };
    var url = "getEvents.php";
    xhttp.open("GET", url+"?" + params, true);
    xhttp.send();
}

function createCalendarHeader(date){
    var year = date.getFullYear();
    var month = date.getMonth();
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var strDate = "" + months[month] + " " + year;
    var calendarSection = document.getElementById("calendarTable");
    var header = document.createElement('div');
    header.className="calendar-header";
    header.innerHTML = "<input id='hiddenDate' type='hidden' value='" + date.toISOString().slice(0,10) + "'>"
    + "<h1><span><i onClick='prevMonth()' class='fa fa-caret-square-o-left'></i></span>" 
        + strDate + "<span><i onClick='nextMonth()' class='fa fa-caret-square-o-right'></i></span></h1>";
    calendarSection.appendChild(header);
}

function prevMonth(){
    var dateStr = document.getElementById("hiddenDate").value.split("-");
    var date = new Date(dateStr[0], dateStr[1] - 2, dateStr[2]);
    var calendarSection = document.getElementById("calendarTable");
    calendarSection.innerHTML = "";
    createCalendarHeader(date);
    createCalendarTable();
    createMonthView(date);
    getEvents();
}

function nextMonth(){
    var dateStr = document.getElementById("hiddenDate").value.split("-");
    var date = new Date(dateStr[0], dateStr[1], dateStr[2]);
    var calendarSection = document.getElementById("calendarTable");
    calendarSection.innerHTML = "";
    createCalendarHeader(date);
    createCalendarTable();
    createMonthView(date);
    getEvents();
}

function createCalendarTable(){
    var calendarSection = document.getElementById("calendarTable");
    var weekDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    for(var i = 0; i < 7; i++){
        var weekBox = document.createElement('div');
        weekBox.className = "week-day-box col-1";
        
        var headerBox = document.createElement('div');
        headerBox.className="day-box-header";
        headerBox.innerHTML = "<h4>" + weekDays[i] + "</h4>"

        weekBox.appendChild(headerBox);
        var day = i;
        for(var days = 1+i, j = 0; j < 5; days+=7, j++){
            var dayBox = document.createElement('div');
            dayBox.className = "day-box";
            dayBox.addEventListener("dblclick", function(event){openModal(event)});
            dayBox.setAttribute("ondrop", "drop(event, this)");
            dayBox.setAttribute("ondragover", "allowDrop(event)");
            dayBox.id="dayBox"+days;
            dayBox.name=days;
            weekBox.appendChild(dayBox);
        }
    calendarSection.appendChild(weekBox);
    }
}

function createMonthView(date){
    var month = date.getMonth()+1;
    var year = date.getFullYear();
    var monthBegin = new Date(""+year+"-"+month+"-01");
    var dayOfWeek = monthBegin.getDay() == 0 ? 7 : monthBegin.getDay();
    var daysInMonth = new Date(year, month, 0).getDate();
    var daysInPrevMonth = new Date(year, month-1, 0).getDate();
    var daysInNextMonth = new Date(year, month+1, 0).getDate();
    
    for(var i = 1; i < dayOfWeek; i++){        
        var dayBox = document.getElementById("dayBox"+i);        
        dayBox.className = "day-box hidden-box";
    }
    for(var i = 35; i >= daysInMonth+dayOfWeek; i--){
        var dayBox = document.getElementById("dayBox"+i);        
        dayBox.className = "day-box hidden-box";
    }
    for(var i = 1, j = dayOfWeek; i <= daysInMonth ; i++, j++){
        var boxDate = new Date();
        boxDate.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        boxDate.setDate(i);
        var strDate = boxDate.toISOString().slice(0,10);
        var div = document.createElement('div');
        div.id = i <10 ? "day-0"+i : "day-"+i;
        div.name = i;
        div.className="day";
        div.innerHTML = "<input type='hidden' value='" + strDate + "'> " + i;
        var dayBox = document.getElementById("dayBox"+j);
        dayBox.appendChild(div);
    }
}

</script>
<title>Calendar</title>
</head>
<body>
<header>
    <h2>Calendar</h2>
</header>
<nav>
<ul>
    <li><a href="/calendar.php" class="active">Calendar</a></li>
    <li><a href="/friends.php">Friends</a></li>
    <li><a href="/settings.php">Settings</a></li>
</ul>
</nav>
<section class="left-tabs">
    <button class="tab-link" id="defaultOpen" onClick="changeTab(event,'calendarTab')">Calendar View</button>
    <button class="tab-link" onClick="changeTab(event, 'eventsTab')">Events List</button>
    <button class="tab-link" onClick="changeTab(event, 'eventTab')">Create Event</button>

</section>
<section class="tab-content" id="calendarTab">
    <section class="month-calendar">
        <div id="eventModal" class="modal">
            <div class="modal-content small">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h3>Add event</h3>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" name="id_event" value="">
                        <p>Event name:</p>
                        <input id="eventNameField" type="text" name="eventName" class="text-field">
                        <p>Event date</p>
                        <input id="eventDateField" type="date" name="date" class="text-field">
                        <p>Event date start:</p>
                        <input id="eventStartField" type="time" name="startTime" class="text-field" value="08:00">
                        <p>Event date end:</p>
                        <input id="eventEndField" type="time" name="endTime" class="text-field" value="09:00">
                        <p>Place</p>
                        <input id="placeField" type="text" name="place" class="text-field">
                        <p>Description</p>
                        <textarea rows="2" cols="50" id="descriptionField" name="description" class="text-field"></textarea>
                        <p>Color</p>
                        <input type="color" name="color">                    
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="button" id="saveEventBtn">Save</button>
                    <button class="button" id="cancelBtn">Cancel</button>    
                </div>
            </div>
        </div>
        <div id="calendarTable"></div>
    </section>
</section>
<footer>
<p>&copy; 2017 Daria Lepa. All rights reserved.
</footer>
</body>
</html>