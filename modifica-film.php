<?php
session_start();
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != "1"){
    header("Location: home.php");
    exit();
}
if(isset($_POST["add"])){
    $nome = $_POST["nome"];
    $durata = $_POST["durata"];
    $trama = $_POST["trama"];
    if(empty($nome) || empty($trama) || empty($durata)){
        $_SESSION["error"] = "Compilare tutti i campi";
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Film(NomeFilm, Durata, Trama) VALUES('$nome', '$durata', '$trama')";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento del film" . $query;
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $_SESSION["success"] = "Film inserito con successo";
    header("Location: gestisci-tutti-film.php");
    exit();

}elseif(isset($_POST["elimina"])){
    $id = $_POST["id"];
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "DELETE FROM Film WHERE IDFilm = '$id'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'eliminazione del film" . $query;
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $_SESSION["success"] = "Film eliminato con successo";
    header("Location: gestisci-tutti-film.php");
    exit();
}
