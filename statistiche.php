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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Statistiche prenotazioni - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 2){
    header("Location: home.php");
    exit();
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-chart-line-up me-3"></i>Statistiche prenotazioni</p>
<div class="form-floating mx-3 mb-3">
    <input type="date" class="form-control" placeholder="Giorno" id="giornoProiezioni" onchange="impostaGiornoProiezioni()" value="<?php
    $data = date("Y-m-d");
    if(isset($_GET["data"])){
        $data = $_GET["data"];
    }
    echo $data;
    ?>" required>
    <label for="giornoProiezioni">Giorno</label>
    <div class="invalid-feedback">Il giorno non può essere vuoto.</div>
</div>
<?php
$connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
$query = "SELECT IDFilm, NomeFilm, COUNT(IDPrenotazione) AS NumeroPrenotazioni FROM ((((Film AS F INNER JOIN Proiezioni P on F.IDFilm = P.idFFilm) INNER JOIN Sale AS S ON S.IDSala = P.idFSala) INNER JOIN Cinema AS C ON C.IDCinema = S.idFCinema) INNER JOIN Utenti AS U ON U.IDUtente = C.idFResponsabile AND U.Username = '" . $_SESSION["username"] . "') LEFT JOIN Prenotazioni AS PR ON PR.idFProiezione = P.IDProiezione WHERE ";
if(!isset($_GET["tipo"]) || $_GET["tipo"] == "day"){
    $query .= "DATE(OraInizio) = '$data'";
}elseif($_GET["tipo"] == "week"){
    $query .= "GETSTARTWEEKDATE(OraInizio) = GETSTARTWEEKDATE('$data')";
}elseif($_GET["tipo"] == "month"){
    $query .= "MONTH(OraInizio) = MONTH('$data')";
}elseif($_GET["tipo"] == "all"){
    $query = substr($query, 0, -7);
}
$query .= " GROUP BY IDFilm";
$result = mysqli_query($connessione, $query);
if(!$result){
    echo "Errore nella query: " . mysqli_error($connessione);
}else{
    $ris = $result->fetch_all(MYSQLI_ASSOC);
    $labels = array();
    $dati = array();
    foreach ($ris as $r){
        $labels[] = $r["NomeFilm"];
        $dati[] = $r["NumeroPrenotazioni"];
    }
}
?>
<div class="ms-auto me-3">
    <button class="btn btn-outline-primary" onclick="impostaGiornoProiezioni('day')">Giorno</button>
    <button class="btn btn-outline-primary" onclick="impostaGiornoProiezioni('week')">Settimana</button>
    <button class="btn btn-outline-primary" onclick="impostaGiornoProiezioni('month')">Mese</button>
    <button class="btn btn-outline-primary" onclick="impostaGiornoProiezioni('all')">Tutto</button>
</div>
<canvas id="prenotazioniFilm" style="height: 70vh"></canvas>
<script>
    const ctx = document.getElementById('prenotazioniFilm').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels);?>,
            datasets: [{
                label: 'Prenotazioni',
                data: <?php echo json_encode($dati);?>,
                fill: true,
                backgroundColor: 'rgb(75, 192, 192)',
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    function impostaGiornoProiezioni(tipo){
        if(tipo === undefined){
            location.href = "statistiche.php?data=" + document.getElementById('giornoProiezioni').value;
        }else {
            location.href = "statistiche.php?data=" + document.getElementById('giornoProiezioni').value + "&tipo=" + tipo;
        }
    }
</script>
</body>
</html>
