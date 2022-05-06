<?php
$username = $_POST["username"];
$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
OR die("errore nella connessione al DB");
$risultato = mysqli_query($connessione, "SELECT * FROM Utenti WHERE Username = '" . $username . "';") or function(){
    $_SESSION["error"] = "Errore nella connessione!";
    header("Location: login.php");
    exit();
};
if($risultato == false){
    $_SESSION["error"] = "Errore nella connessione!";
    header("Location: login.php");
    exit();
}
$ris = $risultato->fetch_assoc();
if (!isset($ris)){
    $_SESSION["error"] = "Non ci sono utenti della tipologia selezionata!";
    header("Location: login.php");
    exit();
}
$pass = md5(rand());
$risultato = mysqli_query($connessione, "UPDATE Utenti SET Password = '" . $pass . "' WHERE Username = '" . $username . "';") or function(){
    $_SESSION["error"] = "Errore nella connessione!";
    header("Location: login.php");
    exit();
};
mail($ris["Email"], "Password reset", "La tua password è: " . $pass);
$_SESSION["success"] = "Password resettata correttamente!";
header("Location: login.php");