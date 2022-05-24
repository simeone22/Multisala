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
    <link rel="stylesheet" href="Media/CSS/fade-text.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Eventi - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php include "navbar.php" ?>
<div class="container text-center" style="max-width: 200%; margin-top: 20px;">
    <?php
    $sql = "SELECT * FROM (Film INNER JOIN Proiezioni ON Film.IDFilm = Proiezioni.idFFilm) INNER JOIN Sale ON Proiezioni.idFSala = Sale.IDSala WHERE Privata = 1 AND IDFilm = " .$_GET["id"];
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $result = $connessione->query($sql);
    if($result->num_rows > 0){
    $row = $result->fetch_assoc()
    ?>
    <div aria-labelledby="<?php echo $row["IDFilm"]; ?>" id="<?php echo $row["IDFilm"]; ?>"/>
    <div class="card card-body" data-parent="<?php $row["IDFilm"];?>" style="position: relative; height: 600px;">
        <div class="container align-middle" style="padding-top: 50px;">
            <div class="row d-flex">
                <div class="col-3 d-flex justify-content-center">
                    <img src="<?php echo "Media/Film/". $row["IDFilm"]?>.png" alt="..." style="height: 500px;">
                </div>
                <div class="col-7 text-start fs-6 mt-3" style="padding-left: 100px;">
                    <h2 class="visible text-start" style="padding-bottom: 3px;">
                        <strong><?php echo $row["NomeFilm"] ?></strong>
                    </h2>
                    <strong>Sala</strong>
                    <p> <?php echo $row["CodiceSala"]?> </p>
                    <strong>Durata</strong>
                    <p> <?php echo $row["Durata"]?> min </p>
                    <strong>Attori</strong>
                    <p><?php
                        $query = "SELECT Nome, Cognome FROM Attori INNER JOIN AttoriFilm ON Attori.IDAttore = AttoriFilm.idFAttore WHERE idFFilm = ". $row["IDFilm"];
                        $risultato = $connessione->query($query);
                        if($risultato->num_rows > 0){
                            $attori = [];
                            while($r = $risultato->fetch_assoc()){
                                $attori[] = $r["Nome"] . " " . $r["Cognome"];
                            }
                            echo implode(", ", $attori);
                        }?></p>
                    <strong>Ora d'inizio</strong>
                    <p><?php
                        echo (new DateTime($row["OraInizio"]))->format('H:i d/m/Y')?></p>
                    <strong>Valutazione</strong>
                    <p>
                        <?php
                        $q = "SELECT AVG(Voto) AS media FROM Recensioni INNER JOIN Film ON Recensioni.idFFilm = Film.IDFilm WHERE idFFilm = " . $row["IDFilm"];
                        $ris = $connessione->query($q);
                        if ($ris->num_rows > 0){
                            $rw = $ris->fetch_assoc();
                            $voto = $rw["media"];
                            for ($i = 0; $i < 5; $i++){
                                if($i < $voto)
                                    echo "<i class='fa-solid fa-star me-1' style='color: #f1c40f'></i>";
                                else
                                    echo "<i class='fa-solid fa-star me-1 text-secondary'></i>";
                            }
                        }
                        ?>
                    </p>
                    <div id="example" class="accordion-item">
                        <p id="headingOne" class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#d-<?php echo $row["IDFilm"]; ?>" aria-expanded="false" aria-controls="d-<?php echo $row["IDFilm"]; ?>">
                                <strong>Descrizione</strong>
                            </button>
                        </p>
                        <div id="d-<?php

                        echo $row["IDFilm"]; ?>" class="accordion-collapse overflow-auto h-25 collapse" aria-labelledby="headingOne" data-bs-parent="#example">
                            <div class="accordion-body">
                                <p>
                                    <?php
                                    if(strlen($row["Trama"]) > 478){
                                        $row["Trama"] = substr($row["Trama"], 0, 478) . "...";
                                        echo $row["Trama"];
                                    }
                                    else {
                                        echo $row["Trama"];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}?>
</div>
</body>
</html>