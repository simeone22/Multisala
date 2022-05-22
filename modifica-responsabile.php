<?php
session_start();
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != "1"){
    header("Location: home.php");
    exit();
}
if (isset($_POST["add"])){
    $username = $_POST["username"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $codiceFiscale = $_POST["codiceFiscale"];
    $telefono = $_POST["telefono"];
    $dataNascita = $_POST["dataNascita"];

    if(empty($nome) || empty($cognome) || empty($email) || empty($codiceFiscale) || empty($telefono) || empty($dataNascita) || empty($username)){
        $_SESSION["error"] = "Compilare tutti i campi";
        header("Location: gestisci-responsabili.php");
        exit();
    }

    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Utenti(Username, Password, Nome, Cognome, Email, CodiceFiscale, Telefono, DataNascita, idFRuolo) VALUES ('$username', '" . md5($username) . "', '$nome', '$cognome', '$email', '$codiceFiscale', '$telefono', '$dataNascita', 2)";
    if(!mysqli_query($connessione, $query)){
        $_SESSION["error"] = "Errore nell'inserimento delle credenziali";
        header("Location: gestisci-responsabili.php");
        exit();
    }
    copy("Media/Utenti/default.png", "Media/Utenti/" . $connessione->insert_id . ".png");

    $_SESSION["success"] = "Responsabile inserito con successo";
    header("Location: gestisci-responsabili.php");
    exit();
}elseif (isset($_POST["edit"])){
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $codiceFiscale = $_POST["codiceFiscale"];
    $telefono = $_POST["telefono"];
    $dataNascita = $_POST["dataNascita"];

    if(empty($nome) || empty($cognome) || empty($email) || empty($codiceFiscale) || empty($telefono) || empty($dataNascita) || empty($id)){
        $_SESSION["error"] = "Compilare tutti i campi";
        http_response_code(403);
        exit();
    }

    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "UPDATE Utenti SET Nome = '$nome', Cognome = '$cognome', Email = '$email', CodiceFiscale = '$codiceFiscale', Telefono = '$telefono', DataNascita = '$dataNascita' WHERE IDUtente = '" . $_POST["id"] . "'";
    if(!mysqli_query($connessione, $query)){
        $_SESSION["error"] = "Errore nell'inserimento delle credenziali" . $query;
        header("Location: gestisci-responsabili.php");
        exit();
    }

    $_SESSION["success"] = "Responsabile inserito con successo";
    header("Location: gestisci-responsabili.php");
    exit();
}elseif (isset($_POST["elimina"])){
    $id = $_POST["id"];
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "DELETE FROM Utenti WHERE IDUtente = '$id'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'eliminazione del responsabile" . $query;
        header("Location: gestisci-responsabili.php");
        exit();
    }
    $_SESSION["success"] = "Responsabile eliminato con successo";
    header("Location: gestisci-responsabili.php");
    exit();
}