<!DOCTYPE HTML>
<?php
    include("Config/Session.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="Styles/page.css">
<link rel="stylesheet" type="text/css" href="Styles/month-calendar.css">
<link rel="stylesheet" type="text/css" href="Styles/modal-box.css">
<style>
</style>
<script src="JS/tabSideMenu.js"></script>
<script>
window.onload = function(){
    document.getElementById("defaultOpen").click();
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

function drop(e) {
    e.preventDefault();
    var data = e.dataTransfer.getData("text");
	console.log(data);
    e.target.appendChild(document.getElementById(data));
    //this.changeText(e);
}

function changeText(e){
    var target = document.getElementById(e.target.id);
    var dragId = e.dataTransfer.getData("text");
    var textLabel = target.getElementsByClassName("data-label")[0];
    textLabel.innerHTML = "Ostatnio opuszczony element: " + dragId;

}

function addEvent(e){
    console.log(e.target.id);
    this.createMonthView();
    var modal = document.getElementById('eventModal');
    modal.style.display = "block";
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function(){
        modal.style.display = "none";
    }
    window.onclick = function(event) {
    if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var div = document.createElement('div');
    var target = document.getElementById(e.target.id);
    target.appendChild(div);
    div.id="event" + e.target.id;
    div.innerHTML = "<h5>Nowy event!</h5>";
    div.setAttribute("class", "event-box col-7");
    div.setAttribute("draggable", true);
    div.setAttribute("ondragstart", "drag(event)");
}
function createMonthView(){
    var date = new Date();
    var month = date.getMonth()+1;
    var year = date.getFullYear();
    var monthBegin = new Date(""+year+"-"+month+"-01");
    var dayOfWeek = monthBegin.getDay();
    var daysInMonth = new Date(year, month, 0).getDate();
    var daysInPrevMonth = new Date(year, month-1, 0).getDate();
    var daysInNextMonth = new Date(year, month+1, 0).getDate();
    console.log(daysInPrevMonth);
}

</script>
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
    <section class="inline">
    <section class="month-calendar">
    <div id="eventModal" class="modal">
        <div class="modal-content small">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>Add event</h3>
            </div>
            <div class="modal-body">
                <form>
                    <p>Event name:</p>
                    <input id="eventNameTextField" type="text" name="eventName">
                    <p>Event date start:</p>
                    <input id="eventStartTimeField" type="time" name="startTime">
                    <p>Event date end:</p>
                    <input id="eventEndTimeField" type="time" name="endTime">
                </form>
            </div>
            <div class="modal-footer">
    
            </div>
        </div>
    </div>
    <div class="week-day-box col-1">
    <div class="day-box-header"><h4>Poniedziałek</h4></div>
    <div class="day-box" id="dayBox1" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox2" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox3" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox4" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox5" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
<div class="week-day-box col-1">
    <div class="day-box-header"><h4>Wtorek</h4></div>
    <div class="day-box" id="dayBox6"  ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox7"  ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox8"  ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox9"  ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox10" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
<div class="week-day-box col-1">
    <div class="day-box-header"><h4>Środa</h4></div>
    <div class="day-box" id="dayBox11" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox12" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox13" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox14" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox15" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
<div class="week-day-box col-1">
    <div class="day-box-header"><h4>Czwartek</h4></div>
    <div class="day-box" id="dayBox16" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox17" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox18" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox19" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox20" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
<div class="week-day-box col-1">
    <div class="day-box-header"><h4>Piątek</h4></div>
    <div class="day-box" id="dayBox21" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox21" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox23" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox24" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox25" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
<div class="week-day-box col-1">
    <div class="day-box-header"><h4>Sobota</h4></div>
    <div class="day-box" id="dayBox26" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox27" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox28" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox29" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox30" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
<div class="week-day-box col-1">
    <div class="day-box-header"><h4>Niedziela</h4></div>
    <div class="day-box" id="dayBox31" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox32" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox33" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox34" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <div class="day-box" id="dayBox35" ondblclick="addEvent(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
</section>
<section class="side-list">sdfsdf<section>
</section>
</section>
<footer>
<p>&copy; 2017 Daria Lepa. All rights reserved.
</footer>
</body>
</html>