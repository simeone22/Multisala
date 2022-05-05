<?php
session_start();

if (isset($_POST["username"], $_POST["password"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
}
else {
    $_SESSION["error"] = "Errore nel controllo delle credenziali!";
    header("Location: login.php");
}

$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
OR die("errore nella connessione al DB");

$risultato = mysqli_query($connessione, "SELECT * FROM Utenti WHERE Username = '" . $username . "' AND Password = '" . md5($password) . "';") or function(){
    $_SESSION["error"] = "Errore nella connessione!";
   header("Location: login.php");
    exit();
};

$ris = mysqli_fetch_array($risultato);

if (!isset($ris)){
    $_SESSION["error"] = "Non ci sono utenti della tipologia selezionata!";
    header("Location: login.php");
    exit();
}

$_SESSION["username"] = $username;
$_SESSION["tipoutente"] = $ris["idFRuolo"];
$_SESSION["logged"] = true;
$_SESSION["success"] = "Login effettuato correttamente!";
if($_POST["ricordami"] == "on"){
    $token = md5(rand());
    $risultato = mysqli_query($connessione, "INSERT INTO TokenCookieUtente(idFUtente, Token) SELECT IDUtente, '" . $token . "' FROM Utenti WHERE Username = '" . $username . "';");
    if($risultato == false){
        $_SESSION["error"] = "Errore nella connessione!";
        header("Location: login.php");
        exit();
    }
    setcookie("username", $username, time() + (86400 * 30), "/html/Lettiero/Esercizio%2029.04.2022/");
    setcookie("token", $token, time() + (86400 * 30), "/html/Lettiero/Esercizio%2029.04.2022/");
}
header("Location: home.php");