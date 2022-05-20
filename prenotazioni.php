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
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Prenotazioni - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 3){
    header("Location: home.php");
    exit();
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-ticket me-3"></i>Prenotazioni</p>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Film</th>
                    <th scope="col">Ora inizio</th>
                    <th scope="col">Cinema</th>
                    <th scope="col">Sala</th>
                    <th scope="col">Posto</th>
                    <th scope="col">Data prenotazione</th>
                    <th scope="col">Scarica</th>
                    <th scope="col">Cancella</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
                or die("Errore di connessione al database");
                $query = "SELECT IDPrenotazione, DataPrenotazione, NomeFilm, Indirizzo, Comune, CAP, NomeCinema, CodiceSala, Riga, Colonna, OraInizio FROM (((((Prenotazioni AS P INNER JOIN Proiezioni AS PR ON P.idFProiezione = PR.IDProiezione) INNER JOIN Film AS F ON F.IDFilm = PR.idFFilm) INNER JOIN Sale AS S ON S.IDSala = PR.idFSala) INNER JOIN Cinema AS C ON C.IDCinema = S.idFCinema) INNER JOIN Posti AS PO ON PO.IDPosto = P.idFPosto) INNER JOIN Utenti AS U ON U.IDUtente = P.idFUtente WHERE U.Username = '".$_SESSION["username"]."'";
                $result = mysqli_query($connessione, $query);
                if(!$result){
                    echo "<p class='fs-1 bg-warning text-center w-100'>Non ci sono prenotazioni</p>";
                }
                elseif($result->num_rows == 0){
                    echo "<p class='fs-1 bg-warning text-center w-100'>Non ci sono prenotazioni</p>";
                }
                else{
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<th scope='row'>".$row["IDPrenotazione"]."</th>";
                        echo "<td>".$row["NomeFilm"]."</td>";
                        echo "<td>".(new DateTime($row["OraInizio"]))->format("H:i d/m/Y")."</td>";
                        echo "<td>".$row["NomeCinema"]. " (" . $row["Indirizzo"] . ", " . $row["Comune"] . ", " . $row["CAP"] . ")</td>";
                        echo "<td>".$row["CodiceSala"]."</td>";
                        echo "<td>".$row["Riga"].$row["Colonna"]."</td>";
                        echo "<td>".(new DateTime($row["DataPrenotazione"]))->format("H:i d/m/Y")."</td>";
                        echo "<td><a target='_blank' href='modifica-prenotazione.php?action=download&id=".$row["IDPrenotazione"]."' class='btn btn-primary'><i class='fa-solid fa-download me-2'></i>Scarica codice</a></td>";
                        echo "<td><a href='modifica-prenotazione.php?action=delete&id=".$row["IDPrenotazione"]."' class='btn btn-danger";
                        if(new DateTime() > new DateTime($row["OraInizio"])){
                            echo " disabled";
                        }
                        echo "'><i class='fa-solid fa-xmark-large me-2'></i>Cancella</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>