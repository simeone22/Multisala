<?php
$connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
if(!$connessione){
    die("Errore connessione: ".mysqli_connect_error());
}
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $query = "SELECT IDPosto, Riga AS riga, Colonna AS colonna, (SELECT 0 FROM Prenotazioni AS PR1 WHERE PR1.idFPosto = PO.IDPosto AND PR1.idFProiezione = $id) AS Disponibile FROM (Posti PO INNER JOIN Sale S on PO.idFSala = S.IDSala) INNER JOIN Proiezioni PR ON PR.idFSala = S.IDSala WHERE PR.IDProiezione = $id";
    $result = $connessione->query($query);
    if($result){
        $posti = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($posti);
        exit();
    }
    else{
        http_response_code(400);
    }
}elseif(isset($_POST["prenota"])){
    $id = $_POST["id"];
    $posto = $_POST["posto"];
    session_start();
    if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 3){
        http_response_code(403);
        exit();
    }
    if(empty($posto) || empty($id)){
        http_response_code(400);
        exit();
    }
    if(!isset($_SESSION["carrello"])){
        $_SESSION["carrello"] = array();
    }
    for($i = 0; $i < count($_SESSION["carrello"]); $i++){
        if($_SESSION["carrello"][$i]["id"] == $id){
            for($j = 0; $j < count($_SESSION["carrello"][$i]["posti"]); $j++){
                if($_SESSION["carrello"][$i]["posti"][$j] == $posto){
                    http_response_code(400);
                    exit();
                }
            }
            $_SESSION["carrello"][$i]["posti"][] = $posto;
            http_response_code(200);
            exit();
        }
    }
    $_SESSION["carrello"][] = array("id" => $id, "posti" => array($posto));
}