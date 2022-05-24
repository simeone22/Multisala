<?php
session_start();
//$_SESSION["carrello"] = array(array("id" => 1, "posti" => [2]));
//aggiungere le prenotazioni
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != "1"){
    header("Location: home.php");
    exit();
}
$connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
or die("Errore di connessione al database");
$query = "SELECT IDUtente FROM Utenti WHERE Username = '".$_SESSION["username"]."'";
$result = mysqli_query($connessione, $query);
if(!$result){
    $_SESSION["error"] = "Errore di connessione al database";
    header("Location: carrello.php");
    exit();
}
$id = $result->fetch_assoc()["IDUtente"];
$vals = "";
for ($i = 0; $i < count($_SESSION["carrello"]); $i++){
    for ($j = 0; $j < count($_SESSION["carrello"][$i]["posti"]); $j++) {
        $vals .= "(" . $_SESSION["carrello"][$i]["id"] . ", " . $_SESSION["carrello"][$i]["posti"][$j] . ", " . $id . ", now()),";
    }
}
$vals = substr($vals, 0, -1);
$result = mysqli_query($connessione, "INSERT INTO Prenotazioni(idFProiezione, idFPosto, idFUtente, DataPrenotazione) VALUES" . $vals);
mysqli_close($connessione);
if(!$result){
    $_SESSION["error"] = "Errore di connessione al database";
    header("Location: carrello.php");
    exit();
}
$_SESSION["success"] = "Prenotazione effettuata con successo";
header("Location: carrello.php");
exit();