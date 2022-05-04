<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<style>
    .carousel-caption{
        margin-top: 3rem;
        top: 0;
    }
    .carousel-caption h1{
        font-weight: 300;
    }
</style>
<body class="d-flex flex-column h-100">
<?php include "navbar.php" ?>
    <div style="height:130%">
        <div class="carousel slide" data-bs-ride="carousel" style="height: 75vh">
            <div class="carousel-inner h-100">
                <div class="carousel-item active h-100">
                    <img class="d-block w-100" src="https://www.masisoft.it/immagini/thumb/xlarge/consulenza-informatica-ict-corporate-consulting.jpg" alt="Carosello immagini">
                    <div class="carousel-caption">
                        <h1></h1>
                    </div>
                </div>
                <div class="carousel-item h-100">
                    <img class="d-block w-100" src="https://www.ganzsecurity.it/images/assistenza-tecnica.jpg" alt="Carosello immagini">
                    <div class="carousel-caption">
                        <h1></h1>
                    </div>
                </div>
                <div class="carousel-item h-100">
                    <img class="d-block w-100" src="https://www.cryptonetlabs.it/wp-content/uploads/2019/01/DefensiveOk1920px.jpg" alt="Carosello immagini">
                    <div class="carousel-caption">
                        <h1></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-5">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-muted">Torna all'inizio</a>
                </li>
            </ul>
            <p class="text-center text-muted">© 2022 Multisala, tech</p>
        </footer>
    </div>
</body>
</html>
