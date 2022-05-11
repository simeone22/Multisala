<?php
session_start();
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != "1"){
    header("Location: home.php");
    exit();
}
if(isset($_POST["add"])){
    $nome = $_POST["nome"];
    $indirizzo = $_POST["indirizzo"];
    $comune = $_POST["comune"];
    $cap = $_POST["cap"];
    $responsabile = $_POST["responsabile"];
    if(empty($nome) || empty($indirizzo) || empty($comune) || empty($cap) || empty($responsabile)){
        $_SESSION["error"] = "Compilare tutti i campi";
        header("Location: gestisci-tutti-cinema.php");
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Cinema(NomeCinema, Indirizzo, Comune, CAP, idFResponsabile) VALUES('$nome', '$indirizzo', '$comune', '$cap', '$responsabile')";

    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento del cinema" . $query;
        header("Location: gestisci-tutti-cinema.php");
        exit();
    }
    $_SESSION["success"] = "Cinema inserito con successo";
    header("Location: gestisci-tutti-cinema.php");
    exit();
}elseif(isset($_POST["elimina"])){
    $id = $_POST["id"];
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "DELETE FROM Cinema WHERE IDCinema = '$id'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'eliminazione del cinema" . $query;
        header("Location: gestisci-tutti-cinema.php");
        exit();
    }
    $_SESSION["success"] = "Cinema eliminato con successo";
    header("Location: gestisci-tutti-cinema.php");
    exit();
}