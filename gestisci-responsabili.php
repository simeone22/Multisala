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
    <title>Responsabili - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["logged"] == false || $_SESSION["tipoutente"] != 1){
    header("Location: home.php");
    exit();
}?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-user-tie me-2"></i>Gestisci responsabili</p>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Codice Fiscale</th>
                    <th>Telefono</th>
                    <th>Data di nascita</th>
                    <th>Gestisci</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $sql = "SELECT * FROM Utenti WHERE idFRuolo = 2";
                $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
                or die("Errore di connessione al database");
                $result = $connessione->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["IDUtente"]."</td>";
                        echo "<td>".$row["Username"]."</td>";
                        echo "<td>".$row["Nome"]."</td>";
                        echo "<td>".$row["Cognome"]."</td>";
                        echo "<td>".$row["Email"]."</td>";
                        echo "<td>".$row["CodiceFiscale"]."</td>";
                        echo "<td>".$row["Telefono"]."</td>";
                        echo "<td>". (new DateTime($row["DataNascita"]))->format("d/m/Y")."</td>";
                        echo "<td><a href='gestisci-responsabile.php?id=" . $row["IDUtente"] . "' class='btn btn-primary'>Gestisci</a></td>";
                        echo "</tr>";
                    }
                }else{
                    echo "<tr><td colspan='5'>Nessun responsabile presente</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <a class="btn btn-primary" href="gestisci-responsabile.php"><i class="fa-solid fa-plus"></i></a>
</div>
</body>
</html>
