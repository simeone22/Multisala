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
    $categorie = $_POST["categoria"];
    $attori = $_POST["attori"];

    if(empty($nome) || empty($trama) || empty($durata) || empty($categoria) || empty($attori)){
        $_SESSION["error"] = "Compilare tutti i campi";
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "INSERT INTO Film(NomeFilm, Trama, Durata) VALUES('$nome', '$trama', $durata)";
    $result = mysqli_query($connessione, $query);
    $query2 = "INSERT INTO CategoriaFilm(idFFilm, idFCategoria) VALUES ";
    for($i = 0; $i < count($categorie); $i++){
        $query2 .= "(" . $connessione->insert_id . ", " . $categoria[$i] . ")";
    }
    $query2 = substr($query2, -1);
    $query3 = "INSERT INTO AttoriFilm(idFFilm, idFAttore) VALUES (" . $connessione->insert_id . ", $attori)";
    for($i = 0; $i < count($attori); $i++){
        $query3 .= "(" . $connessione->insert_id . ", " . $attori[$i] . "),";
    }
    $query3 = substr($query3, -1);
    $result2 = mysqli_query($connessione, $query2);
    $result3 = mysqli_query($connessione, $query3);

    if(!$result || !$result2 || !$result3){
        $_SESSION["error"] = "Errore nell'inserimento del film";
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    if($_FILES["immagine"]){
        if(copy($_FILES["immagine"]["tmp_name"], "Media/Film/" . $connessione->insert_id . ".png")){
            $_SESSION["error"] = "Errore nell'inserimento dell'immagine";
            header("Location: gestisci-tutti-film.php");
            exit();
        }
    }

    $_SESSION["success"] = "Film inserito con successo";
    header("Location: gestisci-tutti-film.php");
    exit();

}elseif ($_POST["edit"]){
    $nome = $_POST["nome"];
    $durata = $_POST["durata"];
    $trama = $_POST["trama"];
    $categoria = $_POST["categoria"];
    $attori = $_POST["attori"];
    $id = $_POST["id"];

    if(empty($nome) || empty($trama) || empty($durata) || empty($categoria) || empty($attori)){
        $_SESSION["error"] = "Compilare tutti i campi";
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");

    $query = "UPDATE Film SET NomeFilm = '$nome', Trama = '$trama', Durata = $durata WHERE IDFilm = $connessione->insert_id";
    $result = mysqli_query($connessione, $query);

    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $query = "DELETE FROM AttoriFilm WHERE idFFilm = $id";
    mysqli_query($connessione, $query);

    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $query = "DELETE FROM CategorieFilm WHERE idFFilm = $id";
    if(!$result){
        $_SESSION["error"] = "Errore nella modifica del film" ;
        header("Location: gestisci-tutti-film.php");
        exit();
    }
    $query = "";
    if($_FILES["immagine"]){
        if(copy($_FILES["immagine"]["tmp_name"], "Media/Film/" . $connessione->insert_id . ".png")){
            $_SESSION["error"] = "Errore nella modifica dell'immagine";
            header("Location: gestisci-tutti-film.php");
            exit();
        }
    }

    $_SESSION["success"] = "Film modificato con successo";
    header("Location: gestisci-tutti-film.php");
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
}
