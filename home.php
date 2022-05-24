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
    <h2 class="page-heading mt-5 mb-5" style="margin-left: 70px;"><i class="fa-solid fa-house-chimney"></i> Home </h2>
    <div style="height:130%" class="container">
        <div id="carouselVideoExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <!-- Inner -->
            <div class="carousel-inner">
                <!-- Single item -->
                <div class="carousel-item active" data-mdb-interval="30000" >
                    <video class="img-fluid" autoplay loop muted >
                        <source src="Media/Immagini/1.mp4" type="video/mp4"/>
                    </video>
                </div>

                <!-- Single item -->
                <div class="carousel-item" data-mdb-interval="31000">
                    <video class="img-fluid" autoplay loop muted>
                        <source src="Media/Immagini/2.mp4" type="video/mp4"/>
                    </video>
                </div>

                <!-- Single item -->
                <div class="carousel-item" data-mdb-interval="45000">
                    <video class="img-fluid" autoplay loop muted>
                        <source src="Media/Immagini/3.mp4" type="video/mp4"/>
                    </video>
                </div>
            </div>
            <!-- Inner -->

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container text-center p-5">
            <h1 class="display-4 fw-bold">Sedi multisala</h1>
        </div>
        <div class="container">
            <hr class="featurette-divider">
        </div>
        <div style="padding-left: 30px">
            <div class="row" style="width: 100%;">
        <?php
        $sql = "SELECT * FROM Cinema";
        $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
        or die("Errore di connessione al database");
        $result = $connessione->query($sql);
        if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
        ?>
                <div class="col-sm-6 justify-content-center d-flex" style="padding-bottom: 40px;">
                    <div class="card border-secondary" style="width: 30rem;">
                        <div id="caroselloImmagini" class="carousel slide card-img-top" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block" src="Media/Cinema/<?php echo $row["IDCinema"]?>.png" alt="..." style="width: 500px; height: 270px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $row["NomeCinema"]?>
                                <br>
                                <?php echo $row["Comune"]?>
                            </h5>
                            <hr class="featurette-divider">
                            <p class="card-text"><?php echo $row["Indirizzo"] .  ", " .  $row["CAP"]?></p>
                        </div>
                    </div>
                </div>
        <?php
        }}?>
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

<script src="Media/JS/mdb.min.js"></script>
</body>
</html>

