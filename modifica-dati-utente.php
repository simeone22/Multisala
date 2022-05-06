<?php
session_start();
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"])){
    header("Location: home.php");
    exit();
}
if(isset($_POST["img"])){
    $query = "SELECT * FROM Utenti WHERE Username = '".$_SESSION["username"]."'";
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore nell'esecuzione della query";
        header("Location: area-personale.php");
        exit();
    }
    $id = $result->fetch_assoc()["IDUtente"];
    move_uploaded_file($_FILES["immagine"]["tmp_name"], "Media/Utenti/" . $id . ".png");
    $_SESSION["success"] = "Immagine modificata con successo";
    header("Location: area-personale.php");
    exit();
}
elseif(isset($_POST["pass"])){
    $pass = md5($_POST["password"]);
    $query = "UPDATE Utenti SET Password = '$pass' WHERE Username = '".$_SESSION["username"]."'";
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore di connessione al database";
        header("Location: area-personale.php");
        exit();
    }
    $_SESSION["success"] = "Password modificata con successo";
    mysqli_close($connessione);
    header("Location: area-personale.php");
}elseif (isset($_POST["elimina"])){
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $query = "SELECT IDUtente FROM Utenti WHERE Username = '".$_SESSION["username"]."'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore di connessione al database";
        header("Location: area-personale.php");
        exit();
    }
    $id = $result->fetch_assoc()["IDUtente"];
    $query = "DELETE FROM Utenti WHERE Username = '".$_SESSION["username"]."'";
    $result = mysqli_query($connessione, $query);
    if(!$result){
        $_SESSION["error"] = "Errore di eliminazione";
        exit(400);
    }
    unlink("Media/Utenti/".$id.".png");
    $_SESSION["success"] = "Account eliminato con successo";
    mysqli_close($connessione);
}
else{
    if(!isset($_POST["nome"], $_POST["cognome"], $_POST["email"], $_POST["codiceFiscale"], $_POST["dataNascita"])){
        $_SESSION["error"] = "Dati mancanti";
        header("Location: area-personale.php");
        exit();
    }
    $query = "UPDATE Utenti SET Nome = ?, Cognome = ?, Email = ?, CodiceFiscale = ?, DataNascita = ?";
    if(isset($_POST["telefono"])){
        $query .= ", Telefono = ?";
    }
    $query .= " WHERE Username = ?";
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $stmt = mysqli_prepare($connessione, $query);
    $cf = strtoupper($_POST["codiceFiscale"]);
    if(isset($_POST["telefono"])){
        mysqli_stmt_bind_param($stmt, "sssssss", $_POST["nome"], $_POST["cognome"], $_POST["email"], $cf, $_POST["dataNascita"], $_POST["telefono"], $_SESSION["username"]);
    }else {
        mysqli_stmt_bind_param($stmt, "ssssss", $_POST["nome"], $_POST["cognome"], $_POST["email"], $cf, $_POST["dataNascita"], $_SESSION["username"]);
    }
    if(mysqli_stmt_execute($stmt) == false){
        $_SESSION["error"] = "Errore di esecuzione della query";
        header("Location: area-personale.php");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connessione);
    $_SESSION["success"] = "Dati aggiornati";
    header("Location: area-personale.php");
}
exit();