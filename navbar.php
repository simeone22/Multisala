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
                        <li><a class="dropdown-item" href="dove-siamo.php">Dove siamo</a></li>
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
                            <a class="dropdown-item" href="GestisciProdotti.jsp">Prodotti</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciFornitori.jsp">Fornitori</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciInterventi.jsp">Interventi</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciFatture.jsp">Fatture</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciClienti.jsp">Clienti</a>
                        </li>
                        <?php }else{?>
                            <li>
                                <a class="dropdown-item" href="gestisci-proiezioni.php"><i class="fa-solid fa-projector me-2"></i>Proiezioni</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="gestisci-responsabili.php"><i class="fa-solid fa-user-tie me-2"></i>Responsabili</a>
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
