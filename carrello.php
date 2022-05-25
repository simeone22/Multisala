<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Media/fontawesome/css/all.css">
    <link rel="stylesheet" href="Media/CSS/checkAnimation.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Carrello - Multisala</title>
    <style>
        .biglietto{
            width: 520px;
            height: 242px;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
        .biglietto p{
            font-weight: bold;
            font-size: .8rem;
            text-align: center;
            width: 40%;
            position: absolute;
            left: 40%;
            top: 25%;
        }
        .biglietto p:nth-child(2){
            top: 42.5%;
        }
        .biglietto p:nth-child(3){
            top: 56%;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
require_once "Media/Stripe/init.php";
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 3) {
    header("Location: home.php");
    exit();
}
$totale = 0;
$modificato = false;
if(isset($_SESSION["carrello"]) && count($_SESSION["carrello"]) > 0){
    function getElById($arr, $id) {
        foreach ($arr as $el) {
            if ($el["id"] == $id) {
                return $el;
            }
        }
        return null;
    }
    $proiezioni = "";
    //num posti
    //((SELECT COUNT(IDPosto) FROM Posti AS P2 WHERE P2.idFSala = PR.idFSala) - (SELECT COUNT(IDPrenotazione) FROM Prenotazioni AS PR2 WHERE PR2.idFProiezione = PR.IDProiezione)) > " . count($_SESSION["carrello"][$i]["posti"]) .
    for ($i = 0; $i < count($_SESSION["carrello"]); $i++) {
        $posti = "";
        for($j = 0; $j < count($_SESSION["carrello"][$i]["posti"]); $j++){
            $posti .= $_SESSION["carrello"][$i]["posti"][$j] . ",";
        }
        $posti = substr($posti, 0, -1);
        $proiezioni .= " (IDProiezione = " . $_SESSION["carrello"][$i]["id"] . " AND (SELECT COUNT(IDPrenotazione) FROM Prenotazioni AS PR2 WHERE PR2.idFProiezione = PR.IDProiezione AND PR2.idFPosto IN(" . $posti . ")) = 0 AND OraInizio > now()) OR";
    }
    $proiezioni = substr($proiezioni, 0, -2);
    $query = "SELECT IDProiezione, IDFilm, NomeFilm, IDCinema, NomeCinema, Indirizzo, Comune, CAP, OraInizio, Prezzo FROM ((Proiezioni PR INNER JOIN Film F on PR.idFFilm = F.IDFilm) INNER JOIN Sale S ON S.IDSala = PR.idFSala) INNER JOIN Cinema C ON C.IDCinema = S.idFCinema WHERE " . $proiezioni . " ORDER BY IDProiezione";
    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
    $result = mysqli_query($connessione, $query);
    $elementi = [];
    $idProiezioni = [];
    while($row = mysqli_fetch_assoc($result)){
        $quantita = count(getElById($_SESSION["carrello"], $row["IDProiezione"])["posti"]);
        $totale += $row["Prezzo"] * $quantita;
        $elementi[] = [
            "name" => $row["NomeFilm"],
            "amount" => $row["Prezzo"] * 100,
            "currency" => "eur",
            "quantity" => $quantita
        ];
        $idProiezioni[] = $row["IDProiezione"];
    }
    $carrello = [];
    for($i = 0; $i < count($idProiezioni); $i++){
        $carrello[] = array_filter($_SESSION["carrello"], function($el) use ($idProiezioni, $i){
            return $el["id"] == $idProiezioni[$i];
        })[0];
    }
    if($_SESSION["carrello"] != $carrello){
        $modificato = true;
    }
    $_SESSION["carrello"] = $carrello;
    $result1 = mysqli_query($connessione, "SELECT * FROM Utenti WHERE Username = '" . $_SESSION["username"] . "'");
    $utente = mysqli_fetch_assoc($result1);
    if(count($elementi) > 0) {
        \Stripe\Stripe::setApiKey("sk_test_51I8qSeAfwq1vwFIheK11FCMXaeso3dI1eaDW6yFKXIwFD5tTGoYEnmC6DRAy4zabBbFX5R1K0W9l0LUlH1bRXAbH00i60GNZjL");
        $urlbase = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $urlbase = substr($urlbase, 0, strpos($urlbase, "carrello.php"));
        $session = \Stripe\Checkout\Session::create([
            "payment_method_types" => ["card"],
            "customer_email" => $utente["Email"],
            "line_items" => $elementi,
            "success_url" => $urlbase . "pagamento.php",
            "cancel_url" => $urlbase . "carrello.php"
        ]);
    }
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-cart-shopping me-3"></i>Carrello</p>
<?php
if($modificato){?>
    <div class="alert alert-danger mx-5" role="alert">
        Uno o più biglietti non sono più disponibili!
        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }
if(isset($_SESSION["carrello"]) && count($_SESSION["carrello"]) > 0){
    $result->data_seek(0);
    $cont = 0;
    while($row = mysqli_fetch_assoc($result)){?>
    <div class="biglietto mx-auto my-5" style="background-image: url('Media/Immagini/biglietto-<?php echo ($cont % 8) + 1?>.png')">
        <p><?php echo $row["NomeFilm"]?></p>
        <p><?php echo "Cinema " . $row["NomeCinema"]?></p>
        <p>
            <font class="float-start">Posti:&nbsp;<span><?php echo count(getElById($_SESSION["carrello"], $row["IDProiezione"])["posti"])?></span></font>
            <font class="float-end">Ora:&nbsp;<span><?php echo (new DateTime($row["OraInizio"]))->format("H:i d/m/Y");?></span></font>
        </p>
    </div>
<?php
    $cont++;
    }
}else{?>
<p class="fs-1 bg-warning text-center position-absolute start-0 top-50 translate-middle-y py-2 w-100">Il carrello è vuoto!</p>
<?php }?>
<div class="position-fixed bottom-0 w-100 border border-2 p-5 bg-light" style="z-index: 2">
    <span class="fs-4">Totale previsto: <span class="fw-bold"><?php echo number_format($totale, 2); ?>€</span></span><br>
    <button type="button" class="position-absolute end-0 top-50 translate-middle-y me-5 btn btn-primary fs-4 w-25<?php if($totale == 0) echo " disabled";?>" id="procediPagamento">Procedi al pagamento</button>
</div>
<script>
    var stripe = Stripe('pk_test_51I8qSeAfwq1vwFIh2AoZx3vDXyV7GmJhwbTAo8lp9f1OWqLcXEiHTqh867OQDZkP5orgbb21H1DM7MYBfLBlqbpT00rJWSU82T');
    document.getElementById('procediPagamento').addEventListener("click", function (){
        stripe.redirectToCheckout({
            sessionId: '<?php echo $session->id; ?>'
        });
    });
</script>
</body>
</html>