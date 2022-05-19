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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Statistiche - Multisala</title>
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
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-chart-line-up me-3"></i>Statistiche</p>
<div class="form-floating mx-3 mb-3">
    <input type="date" class="form-control" placeholder="Giorno" id="giornoProiezioni" onchange="impostaGiornoProiezioni()" value="<?php
    if(isset($_GET["data"])){
        echo $_GET["data"];
    }
    else{
        echo date("Y-m-d");
    }
    ?>" required>
    <label for="giornoProiezioni">Giorno</label>
    <div class="invalid-feedback">Il giorno non può essere vuoto.</div>
</div>
<div class="ms-auto me-3">
    <button class="btn btn-outline-primary">Giorno</button>
    <button class="btn btn-outline-primary">Settimana</button>
    <button class="btn btn-outline-primary">Mese</button>
    <button class="btn btn-outline-primary">Tutto</button>
</div>
<canvas id="prenotazioniFilm" style="height: 70vh"></canvas>
<script>
    const ctx = document.getElementById('prenotazioniFilm').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'Prenotazioni',
                data: [12, 19, 3, 5, 2, 3],
                fill: false,
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
</script>
</body>
</html>
