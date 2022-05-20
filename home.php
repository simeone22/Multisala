<!doctype html>
<html lang="en">
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
    <title>Home - Multisala</title>
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
<?php include "toasts.php"; ?>
<?php include "navbar.php" ?>
    <div style="height:130%" class="container">
        <div class="container text-center p-5">
            <h1 class="display-4 fw-bold">Sedi multisala</h1>
        </div>
        <div class="container">
            <hr class="featurette-divider">
        </div>
        <div style="padding-left: 30px">
            <div class="row" style="width: 100%;">
                <div class="col-sm-7" style="padding-bottom: 40px;">
                    <div class="card border-secondary" style="width: 30rem;">
                        <div id="caroselloImmagini" class="carousel slide card-img-top" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block" src="https://www.casaangelini.it/wp-content/uploads/2019/08/Dove-Andare-Cinema-Riccione-Cinepalace-Multisala-Centro.jpg" alt="..." style="width: 500px; height: 270px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                Cinepalace
                                <br>
                                Riccione
                            </h5>
                            <hr class="featurette-divider">
                            <p class="card-text">Viale Gramsci, 59 c, 47838</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5" style="padding-bottom: 40px;">
                    <div class="card border-secondary" style="width: 30rem;">
                        <div id="caroselloImmagini" class="carousel slide card-img-top" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block" src="https://zero-media.s3.amazonaws.com/uploads/2015/05/Eliseo-multisala-cinema-cultura-milano-film.jpg" alt="..." style="width: 500px; height: 270px;">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block" src="https://www.riminitoday.it/~media/horizontal-hi/50118623643228/palacongressi-riccione-3.jpg" alt="..." style="width: 500px; height: 270px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                Cinema Eliseo Multisala
                                <br>
                                Milano
                            </h5>
                            <hr class="featurette-divider">
                            <p class="card-text">Via Torino, 64</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7" style="padding-bottom: 40px;">
                    <div class="card border-secondary" style="width: 30rem;">
                        <div id="caroselloImmagini" class="carousel slide card-img-top" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block" src="https://www.cinepark.it/cento/image/slide/serizio-bar-cinepark-cento.jpg" alt="..." style="width: 500px; height: 270px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                Cinema Apollo
                                <br>
                                Comacchio
                            </h5>
                            <hr class="featurette-divider">
                            <p class="card-text">Via Matteo Loves, 17</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5" style="padding-bottom: 40px;">
                    <div class="card border-secondary" style="width: 30rem;">
                        <div id="caroselloImmagini" class="carousel slide card-img-top" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block" src="https://zero-media.s3.amazonaws.com/uploads/2015/06/Ducale-Multisala-Cinema-Milano-Cultura-Film.jpg" alt="..." style="width: 500px; height: 270px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                Cinema Ducale
                                <br>
                                Milano
                            </h5>
                            <hr class="featurette-divider">
                            <p class="card-text">Piazza Napoli, 27</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <hr class="featurette-divider">
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
