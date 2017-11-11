function changeTab(event, tabName){
     var tabContent = document.getElementsByClassName("tab-content")
    for(var i = 0; i < tabContent.length; i++){
        tabContent[i].style.display = "none";
    }
    var tabs = document.getElementsByClassName("tab-link");
    for(var i = 0; i < tabs.length; i++){
        tabs[i].className = tabs[i].className.replace("active", "");
    }
    var selectedTab = document.getElementById(tabName).style.display="block";
    event.currentTarget.className += " active";
}