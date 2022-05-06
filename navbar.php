<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="Home.php">Multisala</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a <?php if($_SESSION['position'] === 'home'){ echo 'class="nav-link active" aria-current="page"';}else echo 'class="nav-link"';?> class="nav-link" aria-current="page" href="home.php"> Home</a>
                </li>
                <li class="nav-item">
                    <a <?php if($_SESSION['position'] === 'prossimamente'){ echo 'class="nav-link active" aria-current="page"';}else echo 'class="nav-link"';?> class="nav-link" aria-current="page" href="prossimamente.php"> Prossimamente</a>
                </li>
                <li class="nav-item">
                    <a <?php if($_SESSION['position'] === 'eventi'){ echo 'class="nav-link active" aria-current="page"';}else echo 'class="nav-link"';?> class="nav-link" aria-current="page" href="eventi.php"> Eventi</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php
                if ($_SESSION["logged"] != null && $_SESSION[false] != null){
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        echo $_SESSION["username"];
                        ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="Area_Personale.jsp"><i class="bi bi-person-fill me-2"></i>Area personale</a></li>
                        <%if (session.getAttribute("loginType").equals("Cliente")){%>
                        <li>
                            <a class="dropdown-item" href="VisualizzaInterventi.jsp"><i class="bi bi-tools me-2"></i>Interventi</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="VisualizzaFatture.jsp"><i class="bi bi-receipt me-2"></i>Fatture</a>
                        </li>
                        <%}else{%>
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
                        <?php if ($_SESSION["admin"] == true) {?>
                        <li>
                            <a class="dropdown-item" href="GestisciDipendenti.jsp"><i class="bi bi-cone-striped me-2"></i>Dipendenti</a>
                        </li>
                        <?php
                        } ?>
                        <?php
                        } ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </li>
                <%if(session.getAttribute("loginType").equals("Cliente")){%>
                <li class="nav-item mx-3">
                    <a href="Carrello.jsp" class="mt-1 btn btn-outline-primary py-2">
                        <i class="bi bi-cart4"></i>
                        <%
                        int PCount = 0;
                        if(session.getAttribute("carrello") != null){
                        ArrayList<ProdottiBean> carr = (ArrayList<ProdottiBean>)session.getAttribute("carrello");
                                for (int i = 0; i < carr.size(); i++) {
                                PCount += carr.get(i).getNumeroArticoli();
                                }
                                }
                                %>
                                <span class="badge bg-secondary"><%=PCount%></span>
                    </a>
                </li>
                <%}%>
                <%}else{%>
                <li class="nav-item">
                    <a href="Login.jsp" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="Register.jsp" class="nav-link">Registrazione</a>
                </li>
                <%}%>
            </ul>
        </div>
        </div>
    </div>
</nav>
