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
        http_response_code(403);
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Cinema(NomeCinema, Indirizzo, Comune, CAP, idFResponsabile) VALUES('$nome', '$indirizzo', '$comune', '$cap', '$responsabile')";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento del cinema";
        http_response_code(400);
        exit();
    }
    $query = "INSERT INTO Sale(CodiceSala, idFCinema) VALUES";
    $query1 = "INSERT INTO Posti(idFSala, Colonna, Riga) VALUES";
    for($i = 0; $i < count($sale); $i++){
        $query .= "('" . ($sale[$i]["codice"]) . "', $connessione->insert_id),";
        for($j = 0; $j < count($sale[$i]["posti"]); $j++){
            $query1 .= "((SELECT IDSala FROM Sale WHERE CodiceSala = '" . $sale[$i]["codice"] . "' AND idFCinema = " . $connessione->insert_id . "), '" . ($sale[$i]["posti"][$j]["colonna"]) . "', '" . ($sale[$i]["posti"][$j]["riga"]) . "'), ";
        }
    }
    $query = substr($query, 0, -1);
    $query1 = substr($query1, 0, -2);
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento delle sale";
        http_response_code(400);
        exit();
    }
    $result = mysqli_query($connessione, $query1);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento dei posti";
        http_response_code(400);
        exit();
    }
    $_SESSION["success"] = "Cinema inserito con successo";
    exit();
}elseif(isset($_POST["edit"])){
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $indirizzo = $_POST["indirizzo"];
    $comune = $_POST["comune"];
    $cap = $_POST["cap"];
    $responsabile = $_POST["responsabile"];
    $sale = $_POST["sale"];
    if(empty($nome) || empty($indirizzo) || empty($comune) || empty($cap) || empty($responsabile) || empty($sale) || empty($id)){
        $_SESSION["error"] = "Compilare tutti i campi";
        http_response_code(403);
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "UPDATE Cinema SET NomeCinema = '$nome', Indirizzo = '$indirizzo', Comune = '$comune', CAP = $cap, idFResponsabile = $responsabile WHERE IDCinema = $id";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'aggiornamento del cinema";
        echo $query;
        http_response_code(400);
        exit();
    }
    $query = "INSERT INTO Sale (CodiceSala, idFCinema) VALUES";
    $query1 = "INSERT INTO Posti(idFSala, Colonna, Riga) VALUES";
    $query2 = "DELETE FROM Sale WHERE idFCinema = $id AND CodiceSala NOT IN (";
    for($i = 0; $i < count($sale); $i++){
        $query .= "('" . ($sale[$i]["codice"]) . "', $id),";
        for($j = 0; $j < count($sale[$i]["posti"]); $j++){
            $query1 .= "((SELECT IDSala FROM Sale WHERE CodiceSala = '" . $sale[$i]["codice"] . "' AND idFCinema = $id), '" . ($sale[$i]["posti"][$j]["colonna"]) . "', '" . ($sale[$i]["posti"][$j]["riga"]) . "'), ";
        }
        $query2 .= "'" . ($sale[$i]["codice"]) . "',";
    }
    $query = substr($query, 0, -1) . " ON DUPLICATE KEY UPDATE CodiceSala = VALUES(CodiceSala)";
    $query1 = substr($query1, 0, -2) . " ON DUPLICATE KEY UPDATE Colonna = VALUES(Colonna), Riga = VALUES(Riga)";
    $query2 = substr($query2, 0, -1) . ")";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'aggiornamento delle sale";
        http_response_code(400);
        exit();
    }
    $result = mysqli_query($connessione, $query1);
    if(!$result){
        $_SESSION["error"] = "Errore nell'aggiornamento dei posti";
        http_response_code(400);
        exit();
    }
    $result = mysqli_query($connessione, $query2);
    if(!$result){
        $_SESSION["error"] = "Errore nell'aggiornamento delle sale";
        http_response_code(400);
        exit();
    }
    $_SESSION["success"] = "Cinema aggiornato con successo";
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
}elseif (isset($_POST["modificaProiezione"])){
    $id = $_POST["id"];
    $oraInizio = $_POST["oraInizio"];
    $privata = $_POST["privata"];
    $idSala = $_POST["idSala"];
    $idFilm = $_POST["idFilm"];
    echo $privata;
    echo $idSala;
    if(empty($id) || empty($oraInizio) || empty($privata) || empty($idSala) || empty($idFilm)){
        $_SESSION["error"] = "Errore nell'inserimento dei dati";
        http_response_code(400);
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "UPDATE Proiezioni SET OraInizio = '$oraInizio', Privata = $privata, idFSala = '$idSala', idFFilm = '$idFilm' WHERE IDProiezione = '$id'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'aggiornamento della proiezione";
        http_response_code(400);
        exit();
    }
    $_SESSION["success"] = "Proiezione aggiornata con successo";
    exit();
}elseif (isset($_POST["aggiungiProiezione"])){
    $oraInizio = $_POST["oraInizio"];
    $privata = $_POST["privata"];
    $idSala = $_POST["idSala"];
    $idFilm = $_POST["idFilm"];
    if(empty($oraInizio) || empty($privata) || empty($idSala) || empty($idFilm)){
        $_SESSION["error"] = "Errore nell'inserimento dei dati";
        http_response_code(400);
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Proiezioni (OraInizio, Privata, idFSala, idFFilm) VALUES ('$oraInizio', $privata, '$idSala', '$idFilm')";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'aggiunta della proiezione";
        http_response_code(400);
        exit();
    }
    $_SESSION["success"] = "Proiezione aggiunta con successo";
    exit();
}elseif (isset($_POST["eliminaProiezione"])){
    $id = $_POST["id"];
    if(empty($id)){
        $_SESSION["error"] = "Errore nell'inserimento dei dati";
        http_response_code(400);
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "DELETE FROM Proiezioni WHERE IDProiezione = '$id'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'eliminazione della proiezione";
        http_response_code(400);
        exit();
    }
    $_SESSION["success"] = "Proiezione eliminata con successo";
    exit();
}