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
    <title>Recensioni - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 3){
    header("Location: home.php");
    exit();
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-star me-3"></i>Recensioni</p>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recensioni</h5>
                </div>
                <div class="card-body">
                    <?php
                    $query = "SELECT IDRecensione, Voto, Testo, IDFilm, NomeFilm FROM (Recensioni AS R INNER JOIN Utenti AS U ON R.idFUtente = U.IDUtente) INNER JOIN Film AS F ON F.IDFilm = R.idFFilm WHERE Username = '".$_SESSION["username"]."'";
                    $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
                    $result = $connessione->query($query);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $id_recensione = $row["IDRecensione"];
                            $voto = $row["Voto"];
                            $commento = htmlspecialchars($row["Testo"]);
                            $idfilm = $row["IDFilm"];
                            $nomefilm = $row["NomeFilm"];
                            echo "<div class='row'>
                                    <div class='col-12'>
                                        <div class='card'>
                                            <div class='card-body'>
                                                <div class='row'>
                                                    <div class='col-12 col-md-4'>
                                                        <p class='card-text'>Film: $nomefilm</p>
                                                        <p class='card-text'>Voto:&nbsp;";
                            for ($i = 0; $i < 5; $i++){
                                if($i < $voto)
                                    echo "<i class='fa-solid fa-star me-1' style='color: #f1c40f'></i>";
                                else
                                    echo "<i class='fa-solid fa-star me-1 text-secondary'></i>";
                            }
                            echo "</p>
                                                    </div>
                                                    <div class='col-12 col-md-8'>
                                                        <p class='card-text testo-commento'>$commento</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='card-footer'>
                                                <div class='row'>
                                                    <div class='col-12 col-md-4'>
                                                        <button role='button' class='btn btn-primary' onclick='modificaRecensione($id_recensione, $voto, this.parentElement.parentElement.parentElement.parentElement)'><i class='fa-solid fa-pen-to-square me-2'></i>Modifica</button>
                                                    </div>
                                                    <div class='col-12 col-md-4'>
                                                        <a href='modifica-recensione.php?id=$id_recensione&delete=true' class='btn btn-danger'><i class='fa-solid fa-trash-can me-2'></i>Elimina</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modificaRecensione">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica recensione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="idRecensione" id="idRecensione">
                    <div class="mb-2 text-center">
                        <span class="float-start ms-1">Voto:</span>
                        <i class='fa-solid fa-star me-1 stars' style='color: #6c757d' data-bs-toggle="tooltip" data-bs-placement="top" title="1" onclick="impostaVoto(this)"></i>
                        <i class='fa-solid fa-star me-1 stars' style='color: #6c757d' data-bs-toggle="tooltip" data-bs-placement="top" title="2" onclick="impostaVoto(this)"></i>
                        <i class='fa-solid fa-star me-1 stars' style='color: #6c757d' data-bs-toggle="tooltip" data-bs-placement="top" title="3" onclick="impostaVoto(this)"></i>
                        <i class='fa-solid fa-star me-1 stars' style='color: #6c757d' data-bs-toggle="tooltip" data-bs-placement="top" title="4" onclick="impostaVoto(this)"></i>
                        <i class='fa-solid fa-star me-1 stars' style='color: #6c757d' data-bs-toggle="tooltip" data-bs-placement="top" title="5" onclick="impostaVoto(this)"></i>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="testo" id="testoRecensione" placeholder="Testo" class="form-control" style="height: 15vh;" required></textarea>
                        <label for="testoRecensione">Testo</label>
                        <div class="invalid-feedback">Il testo non può essere vuoto.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="salvaModifiche()">Salva</button>
            </div>
        </div>
    </div>
</div>
<script>
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    let gray= "#6c757d";
    let yellow = "#f1c40f";
    let stars = document.querySelectorAll(".stars");
    function modificaRecensione(idR, voto, card){
        let testo = card.querySelector(".testo-commento").innerHTML;
        for(let i = 0; i < stars.length; i++){
            if(i < voto)
                stars[i].style.color = yellow;
            else
                stars[i].style.color = gray;
        }
        $('#idRecensione').val(idR);
        $('#testoRecensione').val(testo);
        $('#modificaRecensione').modal('show');
    }
    function salvaModifiche(){
        let idr = $('#idRecensione').val();
        let testo = $('#testoRecensione').val();
        let voto = 0;
        for(let i = 0; i < stars.length; i++){
            if(stars[i].style.color === hexToRGB(yellow))
                voto = i + 1;
        }
        $.post('modifica-recensione.php', {id: idr, edit: true, testo: testo, voto: voto}, () => {
            location.reload();
        });
    }
    function impostaVoto(el){
        let gr = false;
        stars.forEach(function (star) {
            if(!gr) star.style.color = yellow;
            else star.style.color = gray;
            if(el === star)
                gr = true;
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
    }
</script>
</body>
</html>
