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
    $categorie = $_POST["categorie"];
    $attori = $_POST["attori"];

    if(empty($nome) || empty($trama) || empty($durata) || empty($categorie) || empty($attori)){
        $_SESSION["error"] = "Compilare tutti i campi";
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Film(NomeFilm, Trama, Durata) VALUES('" . mysqli_real_escape_string($connessione, $nome) . "', '" . mysqli_real_escape_string($connessione, $trama) . "', $durata)";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento del film";
        http_response_code(404);
        exit();
    }
    $id = $connessione->insert_id;
    $query2 = "INSERT INTO CategorieFilm(idFFilm, idFCategoria) VALUES ";
    for($i = 0; $i < count($categorie); $i++){
        $query2 .= "($id, " . $categorie[$i] . "),";
    }
    $query2 = substr($query2, 0, -1);
    $query3 = "INSERT INTO AttoriFilm(idFFilm, idFAttore) VALUES ";
    for($i = 0; $i < count($attori); $i++){
        $query3 .= "($id, " . $attori[$i] . "),";
    }
    $query3 = substr($query3, 0,-1);
    $result2 = mysqli_query($connessione, $query2);

    if(!$result2){
        $_SESSION["error"] = "Errore nell'inserimento del film";
        http_response_code(404);
        exit();
    }

    $result3 = mysqli_query($connessione, $query3);

    if (!$result3){
        $_SESSION["error"] = "Errore nell'inserimento del film";
        http_response_code(404);
        exit();
    }
    echo $id;
    $_SESSION["success"] = "Film inserito con successo";
    exit();

}elseif (isset($_POST["edit"])){
    $nome = $_POST["nome"];
    $durata = $_POST["durata"];
    $trama = $_POST["trama"];
    $categorie = $_POST["categorie"];
    $attori = $_POST["attori"];
    $id = $_POST["id"];
    if(empty($nome) || empty($trama) || empty($durata) || empty($categorie) || empty($attori) || empty($id)){
        $_SESSION["error"] = "Compilare tutti i campi";
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");

    $query = "UPDATE Film SET NomeFilm = '" . mysqli_real_escape_string($connessione, $nome) . "', Trama = '" . mysqli_real_escape_string($connessione, $trama) . "', Durata = $durata WHERE IDFilm = " . $id;
    $result = mysqli_query($connessione, $query);

    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        exit();
    }
    $query = "DELETE FROM AttoriFilm WHERE idFFilm = $id";
    mysqli_query($connessione, $query);

    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        exit();
    }
    $query = "INSERT INTO AttoriFilm(idFFilm, idFAttore) VALUES ";
    for($i = 0; $i < count($attori); $i++){
        $query .= "(" . $id . ", " . $attori[$i] . "),";
    }
    $query = substr($query, 0, -1);
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        exit();
    }
    $query = "DELETE FROM CategorieFilm WHERE idFFilm = $id";
    mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        exit();
    }
    $query = "INSERT INTO CategorieFilm(idFFilm, idFCategoria) VALUES ";
    for($i = 0; $i < count($categorie); $i++){
        $query .= "(" . $id . ", " . $categorie[$i] . "),";
    }
    $query = substr($query, 0, -1);
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        exit();
    }

    echo $id;
    $_SESSION["success"] = "Film modificato con successo";
    exit();

}elseif(isset($_POST["elimina"])){
    $id = $_POST["id"];
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "DELETE FROM Film WHERE IDFilm = '$id'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'eliminazione del film" ;
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $_SESSION["success"] = "Film eliminato con successo";
    header("Location: gestisci-tutti-film.php");
    exit();
}elseif(isset($_POST["attore"])){
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Attori(Nome, Cognome) VALUES('" . mysqli_real_escape_string($connessione, $nome) . "', '" . mysqli_real_escape_string($connessione, $cognome ) . "')";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'inserimento dell'attore" ;
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $_SESSION["success"] = "Attore aggiunto con successo";
    header("Location: gestisci-tutti-film.php");
    exit();
}elseif(isset($_POST["img"])){
    $id = $_POST["id"];
    if(!copy($_FILES["immagine"]["tmp_name"], "Media/Film/" . $id . ".png")){
        $_SESSION["error"] = "Errore nella modifica dell'immagine";
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $_SESSION["success"] = "Immagine modificata con successo";
    header("Location: gestisci-tutti-film.php");
    exit();
}