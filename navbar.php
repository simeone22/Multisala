<?php
$position = explode(".php", array_slice(explode("/", $_SERVER["REQUEST_URI"]), -1)[0])[0];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">Multisala</a>
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
                <li class="nav-item">
                    <a <?php if($position === 'info'){ echo 'class="nav-link active" aria-current="page"';}else echo 'class="nav-link"';?> class="nav-link" aria-current="page" href="info.php"> Info</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION["logged"])){?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION["username"];?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="area-personale.php"><i class="bi bi-person-fill me-2"></i>Area personale</a></li>
                        <?php if ($_SESSION["tipoutente"] == 3) {?>
                        <li>
                            <a class="dropdown-item" href="prenotazioni.php"><i class="bi bi-ticket-perforated me-2"></i>Prenotazioni</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="recensioni.php"><i class="bi bi-star-fill me-2"></i>Recensioni</a>
                        </li>
                        <?php }elseif($_SESSION["tipoutente"] == 2){?>
                        <li>
                            <a class="dropdown-item" href="GestisciProdotti.jsp"><i class="bi bi-box-seam me-2"></i>Prodotti</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciFornitori.jsp"><i class="bi bi-truck me-2"></i>Fornitori</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciInterventi.jsp"><i class="bi bi-tools me-2"></i>Interventi</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciFatture.jsp"><i class="bi bi-receipt me-2"></i>Fatture</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="GestisciClienti.jsp"><i class="bi bi-people-fill me-2"></i>Clienti</a>
                        </li>
                        <?php }else{?>
                            <li>
                                <a class="dropdown-item" href="VisualizzaInterventi.jsp"><i class="bi bi-tools me-2"></i>Interventi</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="VisualizzaFatture.jsp"><i class="bi bi-receipt me-2"></i>Fatture</a>
                            </li>
                        <?php }?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </li>
                <?php if ($_SESSION["tipoutente"] == 3) {?>
                <li class="nav-item mx-3">
                    <a href="Carrello.jsp" class="mt-1 btn btn-outline-primary py-2">
                        <i class="bi bi-cart4"></i>
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
