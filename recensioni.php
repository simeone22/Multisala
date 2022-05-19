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
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Recensioni - Multisala</title>
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
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-star me-3"></i>Recensioni</p>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recensioni</h5>
                </div>
                <div class="card-body">
                    <?php
                    $query = "SELECT * FROM Recensioni AS R INNER JOIN Utenti AS U ON R.idFUtente = U.IDUtente WHERE Username = '".$_SESSION["username"]."'";
                    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
                    $result = $connessione->query($query);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $id_recensione = $row["IDRecensione"];
                            $id_film = $row["idFFilm"];
                            $id_utente = $row["idFUtente"];
                            $voto = $row["Voto"];
                            $commento = $row["Testo"];
                            echo "<div class=\"row\">
                                    <div class=\"col-12\">
                                        <div class=\"card\">
                                            <div class=\"card-body\">
                                                <div class=\"row\">
                                                    <div class=\"col-12 col-md-4\">
                                                        <p class=\"card-text\">Voto: $voto</p>
                                                    </div>
                                                    <div class=\"col-12 col-md-8\">
                                                        <p class=\"card-text\">$commento</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=\"card-footer\">
                                                <div class=\"row\">
                                                    <div class=\"col-12 col-md-4\">
                                                        <a href=\"recensione.php?id_recensione=$id_recensione\" class=\"btn btn-primary\">Visualizza</a>
                                                    </div>
                                                    <div class=\"col-12 col-md-4\">
                                                        <a href=\"modificarecensione.php?id_recensione=$id_recensione\" class=\"btn btn-primary\">Modifica</a>
                                                    </div>
                                                    <div class=\"col-12 col-md-4\">
                                                        <a href=\"eliminarecensione.php?id_recensione=$id_recensione\" class=\"btn btn-primary\">Elimina</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
