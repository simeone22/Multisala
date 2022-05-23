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
<h2 class="page-heading mt-5 mb-5" style="padding-left: 20px;"><i class="fa-solid fa-calendar"></i> Eventi </h2>
<div class="container text-center" style="max-width: 200%; margin-top: 20px;">
    <?php
    $sql = "SELECT * FROM (Film INNER JOIN Proiezioni ON Film.IDFilm = Proiezioni.idFFilm) INNER JOIN Sale ON Proiezioni.idFSala = Sale.IDSala WHERE Privata = 1";
    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
    or die("Errore di connessione al database");
    $result = $connessione->query($sql);
    if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    $row["IDFilm"];
    ?>
    <div aria-labelledby="<?php $row["IDFilm"]; ?>" id="<?php $row["IDFilm"]; ?>"/>
        <div class="card card-body" data-parent="<?php $row["IDFilm"];?>" style="position: relative; height: 600px;">
            <div class="container align-middle" style="padding-top: 50px;">
                <div class="row d-flex">
                    <div class="col-3 d-flex justify-content-center">
                        <a href="informazioni-eventi.php">
                            <img src="<?php echo "Media/Film/". $row["IDFilm"]?>.png" alt="..." style="height: 500px;">
                        </a>
                    </div>
                    <div class="col-7 text-start fs-6 mt-3" style="padding-left: 100px;">
                        <h2 class="visible text-start" style="padding-bottom: 3px;">
                            <strong><?php echo $row["NomeFilm"] ?></strong>
                        </h2>
                        <strong>Sala</strong>
                        <p> <?php echo $row["CodiceSala"]?> </p>
                        <strong>Durata</strong>
                        <p> <?php echo $row["Durata"]?> min </p>
                        <strong>Ora d'inizio</strong>
                        <p><?php echo $row["OraInizio"]?></p>
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
    }
    }?>
</div>
</body>
</html>