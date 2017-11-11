<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="Styles/mystyle.css">
<style>
#div1 {
    width: 350px;
    height: 70px;
    padding: 10px;
    border: 1px solid #aaaaaa;
}
#div2 {
    width: 350px;
    height: 70px;
    padding: 10px;
    border: 1px solid #aaaaab;
}
.data-label {
    text-align: center;
    font-size: 15px;
    color: #0a8193;
}
</style>
<script>
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
    this.changeText(e);
}

function changeText(e){
    var target = document.getElementById(e.target.id);
    var dragId = e.dataTransfer.getData("text");
    var textLabel = target.getElementsByClassName("data-label")[0];
    textLabel.innerHTML = "Ostatnio opuszczony element: " + dragId;
    console.log(textLabel);

}
</script>
</head>
<body>
<?php
ob_start();
phpinfo();
$info = ob_end_clean();
?>
</body>
</html>
