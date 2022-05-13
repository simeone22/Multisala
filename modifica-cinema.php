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
    $sale = $_POST["sale"];
    if(empty($nome) || empty($indirizzo) || empty($comune) || empty($cap) || empty($responsabile) || empty($sale)){
        $_SESSION["error"] = "Compilare tutti i campi";
        header("Location: gestisci-tutti-cinema.php");
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Cinema(NomeCinema, Indirizzo, Comune, CAP, idFResponsabile) VALUES('$nome', '$indirizzo', '$comune', '$cap', '$responsabile')";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento del cinema";
        header("Location: gestisci-tutti-cinema.php");
        exit();
    }
    $query = "INSERT INTO Sale(CodiceSala, IDCinema) VALUES";
    $query1 = "INSERT INTO Posti(IDSala, Colonna, Riga) VALUES";
    for($i = 0; $i < count($sale); $i++){
        $query .= "('" . ($sale[$i]["codice"]) . "', $connessione->insert_id),";
        for($j = 0; $j < count($sale[$i]["posti"]); $j++){
            $query1 .= "((SELECT IDSala FROM Sale WHERE CodiceSala = '" + $sale[$i]["codice"] + "' AND IDCinema = $connessione->insert_id), '" . ($sale[$i]["posti"][$j]["colonna"]) . "', '" . ($sale[$i]["posti"][$j]["riga"]) . "'), ";
        }
    }
    $query = substr($query, 0, -1);
    $query1 = substr($query1, 0, -2);
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento delle sale";
        header("Location: gestisci-tutti-cinema.php");
        exit();
    }
    $result = mysqli_query($connessione, $query1);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento dei posti" .$query1;
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