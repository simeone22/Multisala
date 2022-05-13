<?php
session_start();

if (isset($_POST["username"], $_POST["password"], $_POST["codiceFiscale"], $_POST["nome"], $_POST["cognome"], $_POST["dataNascita"], $_POST["email"])){
    $query = "INSERT INTO Utenti(Username, Password, CodiceFiscale, Nome, Cognome, DataNascita, Email, Telefono, idFRuolo) VALUES ('" . $_POST["username"] . "','" . md5($_POST["password"]) . "', '" . $_POST["codiceFiscale"] . "', '" . $_POST["nome"] . "', '" . $_POST["cognome"] . "', '" . $_POST["dataNascita"] . "', '" . $_POST["email"] . "', ";
    if(isset($_POST["telefono"])) $query .= "'" . $_POST["telefono"] . "', 3);";
    else $query .= "NULL, 3);";
}
else {
    $_SESSION["error"] = "Errore nel controllo delle credenziali!";
    header("Location: registrazione.php");
    exit();
}
$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
OR die("errore nella connessione al DB");
$risultato = mysqli_query($connessione, $query);
if($risultato == false){
    $_SESSION["error"] = "L'username è già utilizzato oppure c'è errore durante la connessione!";
    header("Location: registrazione.php");
    exit();
}
copy("Media/Utenti/default.png", "Media/Utenti/" . $connessione->insert_id . ".png");
$_SESSION["username"] = $_POST["username"];
$_SESSION["tipoutente"] = 3;
$_SESSION["logged"] = true;
$_SESSION["success"] = "Registrazione effettuata con successo!";
header("Location: home.php");