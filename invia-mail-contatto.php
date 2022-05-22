<?php
session_start();
if(!isset($_POST["email"], $_POST["oggetto"], $_POST["messaggio"])){
    $_SESSION["error"] = "La mail non è stata inviata!";
    header("location: contatti.php");
    exit();
}
if(!mail("matthias.baroni@edu.cobianchi.it", $_POST["oggetto"], $_POST["messaggio"], "From: " . $_POST["email"] . "\r\n")){
    $_SESSION["error"] = "La mail non è stata inviata!";
    header("location: contatti.php");
    exit();
}
$_SESSION["success"] = "La mail è stata inviata!";
header("location: contatti.php");
exit();