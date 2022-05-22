<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="Media/fontawesome/css/all.css">
    <link rel="stylesheet" href="Media/CSS/checkAnimation.css">
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Contatti - Multisala</title>
</head>
<body class="position-relative min-h-100">
<?php include "toasts.php";?>
<?php include "navbar.php" ?>
    <div class="container">
        <h2 class="page-heading mt-5 mb-5"><i class="fa-solid fa-circle-phone"></i> Pagina contatti </h2>
        <div class="min-h-85" style="margin-top: 20px;">
            <div class="w-50 float-start mb-5">
                <form action="invia-mail-contatto.php" class="w-50 m-auto border border-3 h-50 px-3 py-4 rounded-3" method="post">
                    <p class="fs-2 fw-bold text-center">Contattaci</p>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" placeholder="Email" id="email" class="form-control" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="oggetto" placeholder="Oggetto" id="oggetto" class="form-control" required>
                        <label for="oggetto">Oggetto</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="messaggio" placeholder="Messaggio" id="messaggio" class="form-control" style="height: 12em;" required></textarea>
                        <label for="messaggio">Messaggio</label>
                    </div>
                    <input type="submit" class="btn btn-primary p-3 w-100">
                </form>
            </div>
            <div class="w-50 float-end">
                <p class="fs-2 fw-bold text-center">Ulteriori contatti</p>
                <p class="fs-5">Per problematiche o ulteriori informazioni, contattare il direttore:</p>
                <p>Telefono: <a href="tel:<?php
                    $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
                    or die("Connessione fallita: " . mysqli_connect_error());
                    $sql = mysqli_query($connessione, "SELECT * FROM Utenti WHERE idFRuolo = 1");
                    $row = $sql->fetch_assoc();
                    echo $row["Telefono"];
                    ?>"><?php
                        echo $row["Telefono"];
                        ?></a></p>
                <p>Puoi trovarlo dalle 8.30 fino alle 16.00 nei giorni lavorativi.</p>
                <p>Dalle 9.00 alle 12.00 durante i giorni festivi.</p>
            </div>
        </div>
    </div>
</body>
</html>