<?php
session_start();
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 3){
    header("Location: home.php");
    exit();
}
if(isset($_GET["delete"], $_GET["id"])){
    $id = $_GET["id"];
    $query = "DELETE FROM Recensioni WHERE IDRecensione = $id";
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
    $result = $connessione->query($query);
    if($result){
        $_SESSION["success"] = "Recensione eliminata con successo!";
        header("Location: recensioni.php");
        exit();
    }
    else{
        $_SESSION["error"] = "Errore nell'eliminazione della recensione!";
        header("Location: recensioni.php");
        exit();
    }
}
if(isset($_POST["edit"], $_POST["id"], $_POST["voto"], $_POST["testo"])){
    $id = $_POST["id"];
    $voto = $_POST["voto"];
    $commento = $_POST["testo"];
    $query = "UPDATE Recensioni SET Voto = $voto, Testo = '$commento' WHERE IDRecensione = $id";
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
    $result = $connessione->query($query);
    if($result){
        $_SESSION["success"] = "Recensione modificata con successo!";
        header("Location: recensioni.php");
        exit();
    }
    else{
        $_SESSION["error"] = "Errore nella modifica della recensione!";
        header("Location: recensioni.php");
        exit();
    }
}
if(isset($_POST["add"], $_POST["voto"], $_POST["testo"], $_POST["film"])){
    $film = $_POST["film"];
    $voto = $_POST["voto"];
    $commento = $_POST["testo"];
    $query = "INSERT INTO Recensioni(Voto, Testo, idFFilm, idFUtente) SELECT $voto, '$commento', $film, IDUtente FROM Utenti WHERE Username = '".$_SESSION["username"]."'";
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
    $result = $connessione->query($query);
    if($result){
        $_SESSION["success"] = "Recensione modificata con successo!";
        header("Location: recensioni.php");
        exit();
    }
    else{
        $_SESSION["error"] = "Errore nella modifica della recensione!";
        header("Location: recensioni.php");
        exit();
    }
}