<?php
$sql = "SELECT * FROM Film WHERE IDFilm = " .$_GET["id"];
$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
or die("Errore di connessione al database");
$result = $connessione->query($sql);
if($result->num_rows > 0){
$row = $result->fetch_assoc();
?>
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
    <title><?php echo $row["NomeFilm"]?> - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php include "navbar.php" ?>
<div class="container text-center mb-5" style="max-width: 200%; margin-top: 20px;">
    <div aria-labelledby="<?php echo $row["IDFilm"];?>" id="<?php echo $row["IDFilm"];?>">
        <div class="card card-body" data-parent="<?php echo $row["IDFilm"];?>" style="position: relative; height: 620px;">
            <div class="row d-flex" style="overflow: scroll">
                <div class="col-3 d-flex justify-content-center">
                    <img src="<?php echo "Media/Film/". $row["IDFilm"]?>.png" alt="..." style="height: 500px; width: 350px;">
                </div>
                <div class="col-9 text-start fs-6 mt-3" style="padding-left: 100px;">
                    <h2 class="visible text-start" style="padding-bottom: 3px;">
                        <strong><?php echo $row["NomeFilm"] ?></strong>
                    </h2>
                    <strong>Durata</strong>
                    <p><?php echo $row["Durata"]?> min </p>
                    <strong>Valutazione</strong>
                    <p>
                        <?php
                        $q = "SELECT AVG(Voto) AS media FROM Recensioni INNER JOIN Film ON Recensioni.idFFilm = Film.IDFilm WHERE idFFilm = " . $row["IDFilm"];
                        $ris = $connessione->query($q);
                        if ($ris->num_rows > 0){
                            $rw = $ris->fetch_assoc();
                            $voto = $rw["media"];
                            for ($i = 0; $i < 5; $i++){
                                if($i < $voto)
                                    echo "<i class='fa-solid fa-star me-1' style='color: #f1c40f'></i>";
                                else
                                    echo "<i class='fa-solid fa-star me-1 text-secondary'></i>";
                            }
                        }
                        ?>
                    </p>
                    <strong>Trama</strong>
                    <p>
                        <?php echo $row["Trama"]; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion mt-5" id="accordionCinemaRecensioni">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne">
                    Cinema
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionCinemaRecensioni">
                <div class="accordion-body">
                    <p class="fs-1">Cinema</p>
                    <div class="row px-5">
                        <?php
                        $query = "SELECT * FROM ((Cinema INNER JOIN Sale S on Cinema.IDCinema = S.idFCinema) INNER JOIN Proiezioni P ON S.IDSala = P.idFSala) INNER JOIN Film ON P.idFFilm = Film.IDFilm WHERE idFFilm = ". $row["IDFilm"] . " AND OraInizio > now() AND OraInizio < DATE_ADD(now(), INTERVAL 1 WEEK) ORDER BY OraInizio";
                        $risultato = $connessione->query($query);
                        if($risultato->num_rows > 0){
                        $idcinema = -1;
                        while($r = $risultato->fetch_assoc()){
                        if($idcinema != $r["IDCinema"]){
                        if($idcinema != -1)
                            echo "</div></div></div></div>";
                        $idcinema = $r["IDCinema"];?>
                        <div class="card card-body my-2" data-parent="1" style="position: relative; height: 620px; overflow: scroll">
                            <div class="container align-middle" style="padding-top: 50px;">
                                <div class="row d-flex">
                                    <div class="col-6 text-start fs-6 mt-3" style="padding-left: 100px;">
                                        <h2 class="visible text-start" style="padding-bottom: 3px;">
                                            <strong><?php echo $r["NomeCinema"]?></strong>
                                        </h2>
                                        <img src="Media/Cinema/<?php echo $r["IDCinema"]?>.png" style="height: 30%"><br>
                                        <strong class="pt-3">Indirizzo</strong>
                                        <p><?php echo $r["Indirizzo"] . ", " . $r["Comune"] . " (" . $r["CAP"] . ")"?></p>
                                    </div>
                                    <div class="col-6 fs-6 mt-3 accordion" id="accordion-cinema-<?php echo $idcinema;?>">
                                        <?php }
                                        $idcollapse = "collapse-". $r["IDProiezione"];
                                        ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $idcollapse;?>" onclick="genPosti(this)">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1">
                                                            Sala: <?php echo $r["CodiceSala"]?>
                                                        </h5>
                                                        <small><?php echo (new DateTime($r["OraInizio"]))->format("H:i d/m/Y")?><br><?php echo number_format($r["Prezzo"], 2)?>€</small>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="<?php echo $idcollapse;?>" class="accordion-collapse collapse" data-bs-parent="#accordion-cinema-<?php echo $idcinema;?>">
                                                <div class="accordion-body">
                                                    <div class="alert alert-danger d-none" role="alert">
                                                        Il posto è già stato scelto.
                                                    </div>
                                                    <div id="graficoPosti-<?php echo $idcollapse?>" class="m-1 mx-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        echo "</div></div></div></div>";
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Recensioni
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionCinemaRecensioni">
                                <div class="accordion-body text-start">
                                    <?php
                                    $query = "SELECT * FROM Recensioni R INNER JOIN Utenti U on R.idFUtente = U.IDUtente WHERE idFFilm = ". $row["IDFilm"] . " ORDER BY DataRecensione DESC";
                                    $risultato = $connessione->query($query);
                                    if(isset($_SESSION["logged"]) && $_SESSION["tipoutente"] == 3){
                                        ?>
                                        <div class="mb-2">
                                            <div class="ms-1 mb-2">
                                                <span>Voto:</span>
                                                <i class="fa-solid fa-star me-1 stars" style="color: #6c757d" data-bs-toggle="tooltip" data-bs-placement="top" title="" onclick="impostaVoto(this)" data-bs-original-title="1" aria-label="1"></i>
                                                <i class="fa-solid fa-star me-1 stars" style="color: #6c757d" data-bs-toggle="tooltip" data-bs-placement="top" title="" onclick="impostaVoto(this)" data-bs-original-title="2" aria-label="2"></i>
                                                <i class="fa-solid fa-star me-1 stars" style="color: #6c757d" data-bs-toggle="tooltip" data-bs-placement="top" title="" onclick="impostaVoto(this)" data-bs-original-title="3" aria-label="3"></i>
                                                <i class="fa-solid fa-star me-1 stars" style="color: #6c757d" data-bs-toggle="tooltip" data-bs-placement="top" title="" onclick="impostaVoto(this)" data-bs-original-title="4" aria-label="4"></i>
                                                <i class="fa-solid fa-star me-1 stars" style="color: #6c757d" data-bs-toggle="tooltip" data-bs-placement="top" title="" onclick="impostaVoto(this)" data-bs-original-title="5" aria-label="5"></i>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea name="testo" id="testoRecensione" placeholder="Testo" class="form-control" style="height: 15vh;" required></textarea>
                                                <label for="testoRecensione">Testo</label>
                                                <div class="invalid-feedback">Il testo non può essere vuoto e il voto deve essere maggiore di zero.</div>
                                            </div>
                                            <button type="button" class="btn btn-primary" onclick="inserisciRecensione()">Commenta</button>
                                        </div>
                                    <?php }
                                    while ($recensione = $risultato->fetch_assoc()){?>
                                        <div class='card'>
                                            <div class='card-body'>
                                                <p>
                                                    <img src="Media/Utenti/<?php echo $recensione["IDUtente"]?>.png" class="rounded-circle me-2" style="width: 5%; aspect-ratio: 1/1;">
                                                    <strong><?php echo $recensione["Username"]?></strong>
                                                </p>
                                                <div class='row'>
                                                    <div class="col-4">
                                                        <span>Voto:</span>
                                                        <?php for ($i = 0; $i < 5; $i++) {
                                                            if ($i < $recensione["Voto"])
                                                                echo "<i class='fa-solid fa-star me-1' style='color: #f1c40f'></i>";
                                                            else
                                                                echo "<i class='fa-solid fa-star me-1 text-secondary'></i>";
                                                        }?>
                                                    </div>
                                                    <div class="col-8">
                                                        <p class="card-text"><?php echo $recensione["Testo"]?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }?>
            </div>
            <script>
                let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
                let gray= "#6c757d";
                let yellow = "#f1c40f";
                let stars = document.querySelectorAll(".stars");
                function impostaVoto(el){
                    let gr = false;
                    stars.forEach(function (star) {
                        if(!gr) star.style.color = yellow;
                        else star.style.color = gray;
                        if(el === star)
                            gr = true;
                    });
                }
                function inserisciRecensione(){
                    let testo = $('#testoRecensione').val();
                    let voto = 0;
                    for(let i = 0; i < stars.length; i++){
                        if(stars[i].style.color === hexToRGB(yellow))
                            voto = i + 1;
                    }
                    if(voto == 0){
                        $('#testoRecensione').addClass("is-invalid");
                        return;
                    }
                    if(testo.length === 0){
                        $('#testoRecensione').addClass("is-invalid");
                        return;
                    }
                    $.post('modifica-recensione.php', {add: true, testo: testo, voto: voto, film: <?php echo $_GET["id"]?>}, () => {
                        location.reload();
                    });
                }
                const hexToRGB = hex => {
                    let r = 0, g = 0, b = 0;
                    // handling 3 digit hex
                    if(hex.length == 4){
                        r = "0x" + hex[1] + hex[1];
                        g = "0x" + hex[2] + hex[2];
                        b = "0x" + hex[3] + hex[3];
                        // handling 6 digit hex
                    }else if (hex.length == 7){

                        r = "0x" + hex[1] + hex[2];
                        g = "0x" + hex[3] + hex[4];
                        b = "0x" + hex[5] + hex[6];
                    };

                    let rgb = {
                        red: +r,
                        green: +g,
                        blue: +b
                    };
                    return "rgb(" + rgb.red + ", " + rgb.green + ", " + rgb.blue + ")"
                };
                function genPosti(acc){
                    if(acc.classList.contains("collapsed")){
                        return;
                    }
                    let gposti = document.querySelectorAll("#graficoPosti-" + $(acc).attr("data-bs-target").substring(1))[0];
                    gposti.innerHTML = "";
                    let idProiezione = $(acc).attr("data-bs-target").split("-")[1];
                    $.get("gestisci-posti.php?id=" + idProiezione, (data) => {
                        let dati = JSON.parse(data);
                        for (let i = 0; i < dati.length; i++) {
                            genPosto(dati[i], gposti);
                        }
                    });
                }
                function genPosto(posto, graficoPosti){
                    let postoEl = document.createElement("i");
                    postoEl.classList.add("fa-solid", "fa-loveseat", "fs-4", "ms-1");
                    if(posto.Disponibile !== null){
                        postoEl.classList.add("text-secondary");
                    }else {
                        postoEl.classList.add("text-primary");
                    }
                    postoEl.setAttribute("data-bs-toggle", "tooltip");
                    postoEl.setAttribute("data-bs-placement", "top");
                    postoEl.setAttribute("title", posto.riga + posto.colonna);
                    postoEl.onclick = function (){
                        if(posto.Disponibile !== null){
                            return;
                        }
                        <?php
                        if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 3){?>
                        location.href = "login.php";
                        <?php }else{?>
                        $.post("gestisci-posti.php", {
                            id: graficoPosti.id.substring(graficoPosti.id.lastIndexOf("-") + 1),
                            posto: posto.IDPosto,
                            prenota: true
                        }, () => location.reload()).fail(() => {
                            graficoPosti.previousSibling.previousSibling.classList.remove("d-none");
                            setTimeout(() => graficoPosti.previousSibling.previousSibling.classList.add("d-none"), 3000);

                        });
                        <?php }?>
                    };
                    let riga = graficoPosti.getElementsByClassName("r-" + posto.riga)[0];
                    if(riga === undefined){
                        riga = document.createElement("div");
                        riga.classList.add("r-" + posto.riga);
                        let gpch = graficoPosti.children;
                        let len = gpch.length;
                        for(let i = 0; i < len; i++){
                            if(gpch[i].className.slice(2) > posto.riga){
                                gpch[i].before(riga);
                                break;
                            }
                        }
                        if(riga.parentElement === null) graficoPosti.appendChild(riga);
                        riga.appendChild(postoEl);
                    }else{
                        let elColonna = riga.children;
                        let len = elColonna.length;
                        for(let i = 0; i < len; i++){
                            if(parseInt(elColonna[i].ariaLabel.slice(1)) > posto.colonna){
                                elColonna[i].before(postoEl);
                                break;
                            }
                        }
                        if(postoEl.parentElement === null) riga.appendChild(postoEl);
                    }
                    new bootstrap.Tooltip(postoEl);
                }
            </script>
</body>
</html>