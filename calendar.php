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
    createCalendarTable();
    createMonthView();  
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

function closeModal(){
    var modal = document.getElementById('eventModal');
    modal.style.display = "none";
}

function openModal(event){
    var modal = document.getElementById('eventModal');
    modal.style.display = "block";    
     
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

function addEvent(){
    console.log(e.target.id);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var div = document.createElement('div');
            var target = document.getElementById(e.target.id);
            target.appendChild(div);
            div.id="event" + e.target.id;
            div.innerHTML = "<h5>Nowy event!</h5>";
            div.setAttribute("class", "event-box col-7");
            div.setAttribute("draggable", true);
            div.sadeEventListener("ondragstart", function(){drag(event)});
        }
    }        
}

function createCalendarTable(){
    var calendarSection = document.getElementsByClassName("month-calendar")[0];
    for(var i = 0; i < 7; i++){
        var weekBox = document.createElement('div');
        weekBox.className = "week-day-box col-1";
        
        var headerBox = document.createElement('div');
        headerBox.className="day-box-header";
        headerBox.innerHTML = "<h4>Poniedziałek</h4>"

        weekBox.appendChild(headerBox);
        var day = i;
        for(var days = 1+i, j = 0; j < 5; days+=7, j++){
            var dayBox = document.createElement('div');
            dayBox.className = "day-box";
            dayBox.addEventListener("dblclick", function(){addEvent(event)});
            dayBox.addEventListener("ondrop", function(){drop(event)});
            dayBox.addEventListener("ondragover", function(){allowDrop(event)});
            dayBox.id="dayBox"+days;
            weekBox.appendChild(dayBox);
        }
    calendarSection.appendChild(weekBox);
    }
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
    for(var i = 1, j = dayOfWeek; i <= daysInMonth ; i++, j++){
        var div = document.createElement('div');
        div.className = "";
        div.id = "day-"+i;
        div.innerHTML = " " + i;
        var dayBox = document.getElementById("dayBox"+j);
        dayBox.appendChild(div);
    }
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
                    <input id="eventNameField" type="text" name="eventName">
                    <p>Event date</p>
                    <input id="eventDateField" type="date", name="date">
                    <p>Event date start:</p>
                    <input id="eventStartField" type="time" name="startTime">
                    <p>Event date end:</p>
                    <input id="eventEndField" type="time" name="endTime">
                </form>
            </div>
            <div class="modal-footer">
                <button class="button" id="saveEventBtn">Save</button>
                <button class="button" id="cancelBtn">Cancel</button>    
            </div>
        </div>
    </div>
    <!-- <div class="week-day-box col-1">
        <div class="day-box-header"><h4>Poniedziałek</h4></div>
        <div class="day-box" id="dayBox1" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox8" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox15" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox22" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox29" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>
    <div class="week-day-box col-1">
        <div class="day-box-header"><h4>Wtorek</h4></div>
        <div class="day-box" id="dayBox2"  ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox9"  ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox16"  ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox23"  ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox30" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>
    <div class="week-day-box col-1">
        <div class="day-box-header"><h4>Środa</h4></div>
        <div class="day-box" id="dayBox3" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox10" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox17" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox24" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox31" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>
    <div class="week-day-box col-1">
        <div class="day-box-header"><h4>Czwartek</h4></div>
        <div class="day-box" id="dayBox4" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox11" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox18" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox25" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox32" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>
    <div class="week-day-box col-1">
        <div class="day-box-header"><h4>Piątek</h4></div>
        <div class="day-box" id="dayBox5" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox12" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox19" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox26" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox33" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>
    <div class="week-day-box col-1">
        <div class="day-box-header"><h4>Sobota</h4></div>
        <div class="day-box" id="dayBox6" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox13" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox20" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox27" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox34" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>
    <div class="week-day-box col-1">
        <div class="day-box-header"><h4>Niedziela</h4></div>
        <div class="day-box" id="dayBox7" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox14" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox21" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox28" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <div class="day-box" id="dayBox35" ondblclick="addEvent(event)"   ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div> -->
</section>
</section>
<footer>
<p>&copy; 2017 Daria Lepa. All rights reserved.
</footer>
</body>
</html>