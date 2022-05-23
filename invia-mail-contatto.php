<?php
session_start();
if(!isset($_POST["email"], $_POST["oggetto"], $_POST["messaggio"])){
    $_SESSION["error"] = "La mail non è stata inviata!";
    header("location: contatti.php");
    exit();
}
$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
or die("Connessione fallita: ");
$result = mysqli_query($connessione, "SELECT * FROM Utenti WHERE idFRuolo = 1");
$admin = $result->fetch_assoc();
if(!mail($admin["Email"], $_POST["oggetto"], $_POST["messaggio"], "From: " . $_POST["email"] . "\r\n")){
    $_SESSION["error"] = "La mail non è stata inviata!";
    header("location: contatti.php");
    exit();
}
$_SESSION["success"] = "La mail è stata inviata!";
header("location: contatti.php");
exit();