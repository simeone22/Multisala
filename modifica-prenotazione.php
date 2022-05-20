<?php
session_start();
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 3){
    header("Location: home.php");
    exit();
}
if(!isset($_GET["id"], $_GET["action"])){
    $_SESSION["error"] = "Devono essere passati i parametri richiesti";
    header("Location: prenotazioni.php");
    exit();
}
if($_GET["action"] == "delete"){
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "DELETE FROM Prenotazioni WHERE DataPrenotazione < now() AND IDPrenotazione = ".$_GET["id"];
    $result = mysqli_query($connessione, $query);
    mysqli_close($connessione);
    if(!$result){
        $_SESSION["error"] = "Errore nella cancellazione della prenotazione";
    }
    else{
        $_SESSION["success"] = "Prenotazione cancellata con successo";
    }
    header("Location: prenotazioni.php");
    exit();
}
elseif ($_GET["action"] == "download"){
    include "Media/phpqrcode/qrlib.php";
    $filepath = getcwd() . "/Media/QR/" . $_GET["id"] . ".png";
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "SELECT idFCinema FROM (Prenotazioni AS PR INNER JOIN Proiezioni PO ON PR.idFProiezione = PO.IDProiezione) INNER JOIN Sale AS S ON S.IDSala = PO.idFSala WHERE IDPrenotazione = ".$_GET["id"];
    $result = mysqli_query($connessione, $query);
    if($result->num_rows == 0){
        $_SESSION["error"] = "Errore nella generazione del codice QR";
        header("Location: prenotazioni.php");
        exit();
    }
    $row = mysqli_fetch_assoc($result);
    QRcode::png($row["idFCinema"]."/".md5($_GET["id"] . $_SESSION["username"]), $filepath);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    flush();
    readfile($filepath);
    die();
}
