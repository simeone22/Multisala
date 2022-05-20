<?php
session_start();
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 2){
    http_response_code(403);
    exit();
}
if(!isset($_GET["codice"])){
    http_response_code(400);
    exit();
}
$connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
$cinema = explode("/", $_GET["codice"])[0];
$prenotazione = explode("/", $_GET["codice"])[1];
$query = "SELECT 1 FROM ((((Utenti AS U INNER JOIN Cinema AS C ON C.idFResponsabile = U.IDUtente AND C.IDCinema = $cinema) INNER JOIN Sale AS S ON S.idFCinema = C.IDCinema) INNER JOIN Proiezioni AS P ON P.idFSala = S.IDSala) INNER JOIN Prenotazioni AS PR ON PR.idFProiezione = P.IDProiezione) INNER JOIN Utenti AS U2 ON U2.IDUtente = PR.idFUtente WHERE U.Username = '".$_SESSION["username"]."' AND MD5(CONCAT(PR.IDPrenotazione, U2.Username)) = '$prenotazione'";
$result = $connessione->query($query);
if($result->num_rows == 0){
    echo "NO";
    exit();
}
echo "OK";