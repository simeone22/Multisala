<?php
session_start();
if(!isset($_SESSION["username"], $_SESSION["tipoutente"], $_SESSION["logged"])){
    if(isset($_COOKIE["username"], $_COOKIE["token"])){
        $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
        OR die("errore nella connessione al DB");

        $risultato = mysqli_query($connessione, "SELECT * FROM TokenCookieUtente AS T INNER JOIN Utenti AS U ON U.IDUtente = T.idFUtente WHERE Username = '" . $_COOKIE["username"] . "' AND Token = '" . $_COOKIE["token"] . "';");
        if($risultato == false){
            $_SESSION["error"] = "Errore nella connessione!";
            header("Location: login.php");
            exit();
        }
        $row = $risultato->fetch_assoc();
        $_SESSION["username"] = $_COOKIE["username"];
        $_SESSION["tipoutente"] = $row["idFRuolo"];
        $_SESSION["logged"] = true;
    }
}