<?php
$position = explode(".php", array_slice(explode("/", $_SERVER["REQUEST_URI"]), -1)[0])[0];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
            <img src="Media/Immagini/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top me-2">
            Multisala
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a <?php if($position === 'home'){ echo 'class="nav-link active" aria-current="page"';}else echo 'class="nav-link"';?> class="nav-link" aria-current="page" href="home.php"> Home</a>
                </li>
                <li class="nav-item">
                    <a <?php if($position === 'film'){ echo 'class="nav-link active" aria-current="page"';}else echo 'class="nav-link"';?> class="nav-link" aria-current="page" href="film.php"> Film</a>
                </li>
                <li class="nav-item">
                    <a <?php if($position === 'eventi'){ echo 'class="nav-link active" aria-current="page"';}else echo 'class="nav-link"';?> class="nav-link" aria-current="page" href="eventi.php"> Eventi</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdowni" data-bs-toggle="dropdown" role="button" aria-expanded="false"> Info</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdowni">
                        <li><a class="dropdown-item" href="contatti.php">Contatti</a></li>
                        <li><a class="dropdown-item" href="faq.php">Faq</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION["logged"])){?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION["username"];?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="area-personale.php"><i class="fa-solid fa-user me-2"></i>Area personale</a></li>
                        <?php if ($_SESSION["tipoutente"] == 3) {?>
                        <li>
                            <a class="dropdown-item" href="prenotazioni.php"><i class="fa-solid fa-ticket me-2"></i>Prenotazioni</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="recensioni.php"><i class="fa-solid fa-star me-2"></i>Recensioni</a>
                        </li>
                        <?php }elseif($_SESSION["tipoutente"] == 2){?>
                        <li>
                            <a class="dropdown-item" href="statistiche.php"><i class="fa-solid fa-chart-line-up me-2"></i>Statistiche prenotazioni</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#controlla-biglietti" data-bs-toggle="offcanvas" role="button" aria-controls="controlla-biglietti"><i class="fa-solid fa-clipboard-check me-2"></i>Controlla biglietti</a>
                        </li>
                        <?php }else{?>
                            <li>
                                <a class="dropdown-item" href="gestisci-tutti-film.php"><i class="fa-solid fa-films me-2"></i>Film</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="gestisci-tutti-responsabili.php"><i class="fa-solid fa-user-tie me-2"></i>Responsabili</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="gestisci-tutti-cinema.php"><i class="fa-solid fa-camera-movie me-2"></i>Cinema</a>
                            </li>
                        <?php }?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</a></li>
                    </ul>
                </li>
                <?php if ($_SESSION["tipoutente"] == 3) {?>
                <li class="nav-item mx-3">
                    <a href="Carrello.jsp" class="mt-1 btn btn-outline-primary py-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php
                        $PCount = 0;
                        if (isset($_SESSION["carrello"]) && $_SESSION["carrello"] > 0) {
                            for ($i = 0; $i < count($_SESSION["carrello"]); $i++) {
                                $PCount += $_SESSION["carrello"][$i]["quantita"];
                            }
                        }
                        echo '<span class="badge bg-secondary">' . $PCount . '</span>';
                        ?>
                    </a>
                </li>
                <?php }
                }else{?>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="registrazione.php" class="nav-link">Registrazione</a>
                </li>
                <?php }?>
            </ul>
        </div>
        </div>
    </div>
</nav>
<?php
if(isset($_SESSION["tipoutente"]) && $_SESSION["tipoutente"] == 2){?>
<div class="offcanvas offcanvas-start" tabindex="-1" id="controlla-biglietti" aria-labelledby="controlla-biglietti-label" style="width: 28%">
    <div class="offcanvas-header">
        <p class="offcanvas-title fs-5" id="controlla-biglietti-label"><i class="fa-solid fa-ticket me-3"></i>Controlla biglietti</p>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mx-auto mt-5">
            <div style="width:500px;" id="reader"></div>
        </div>
        <!-- Mostra informazioni ultimo biglietto controllato -->
        <div class="mx-auto mt-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ultimo biglietto controllato</h5>
                    <div class="card-text" id="infoBiglietto">
                        <p class="card-text">Cinema: <span></span></p>
                        <p class="card-text">Film: <span></span></p>
                        <p class="card-text">Ora inizio: <span></span></p>
                        <p class="card-text">Sala: <span></span></p>
                        <p class="card-text">Posto: <span></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute top-0 start-0 bg-light align-items-center justify-content-center w-100 h-100" id="cBanner" style="display: none">
            <svg class="checkmark translate-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <div class="position-absolute top-0 start-0 bg-light align-items-center justify-content-center w-100 h-100" id="xBanner" style="display: none">
            <svg class="xmark translate-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="xmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="xmark__X" fill="none" d="M16 16 36 36 M36 16 16 36"/>
            </svg>
        </div>
        <script src="https://reeteshghimire.com.np/wp-content/uploads/2021/05/html5-qrcode.min_.js"></script>
        <script type="text/javascript">
            function onScanSuccess(qrCodeMessage) {
                $.get("controlla-biglietto.php?codice=" + qrCodeMessage, (dt) => {
                    console.log(dt);
                    if(dt == "NO"){
                        document.getElementById("xBanner").style.display = "flex";
                        $("#xBanner").delay(2000).fadeOut(500);
                        let p = document.getElementById("infoBiglietto").children;
                        for (let i = 0; i < p.length; i++) {
                            p[i].children[0].innerText = "";
                        }
                    }else {
                        let data = JSON.parse(dt);
                        document.getElementById("cBanner").style.display = "flex";
                        $("#cBanner").delay(2000).fadeOut(500);
                        let p = document.getElementById("infoBiglietto").children;
                        p[0].children[0].innerText = data.NomeCinema;
                        p[1].children[0].innerText = data.NomeFilm;
                        p[2].children[0].innerText = data.OraInizio;
                        p[3].children[0].innerText = data.CodiceSala;
                        p[4].children[0].innerText = data.Riga + data.Colonna;
                    }
                });
            }
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 10, qrbox: 250 });
            html5QrcodeScanner.render(onScanSuccess);
            document.querySelectorAll('#reader>div:first-child>span:first-child')[0].remove()
            document.querySelectorAll('#reader__dashboard_section_csr>div>button')[0].click();
        </script>
    </div>
</div>
<?php }?>