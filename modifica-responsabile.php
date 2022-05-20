<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != "1"){
    header("Location: home.php");
    exit();
}
if (isset($_POST["add"])){
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $codiceFiscale = $_POST["codiceFiscale"];
    $telefono = $_POST["telefono"];
    $dataNascita = $_POST["dataNascita"];

  /*  if(empty($nome) || empty($cognome) || empty($email) || empty($codiceFiscale) || empty($telefono) || empty($dataNascita)){
        $_SESSION["error"] = "Compilare tutti i campi";
        http_response_code(403);
        exit();
    }
*/
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Utenti(Nome, Cognome, Email, CodiceFiscale, Telefono, DataNascita, idFRuolo) VALUES ('. $nome. ', '. $cognome. ', '. $email. ', '. $codiceFiscale. ', '. $telefono. ', '. $dataNascita. ',' . '$connessione->insert_id ' .')";
    /*if(!mysqli_query($connessione, $query)){
        $_SESSION["error"] = "Errore nell'inserimento delle credenziali" . $query;
        header("Location: gestisci-tutti-responsabili.php");
        exit();
    }*/

    $_SESSION["success"] = "Responsabile inserito con successo";
    header("Location: gestisci-tutti-responsabili.php");
    exit();


}elseif (isset($_POST["elimina"])){
    $id = $_POST["id"];
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "DELETE FROM Utenti WHERE IDUtente = '$id'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'eliminazione del responsabile" . $query;
        header("Location: gestisci-tutti-responsabili.php");
        exit();
    }
    $_SESSION["success"] = "Responsabile eliminato con successo";
    header("Location: gestisci-tutti-responsabili.php");
    exit();
}