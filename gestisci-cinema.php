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
    <title><?php if(isset($_GET["id"])) echo "Modifica"; else echo "Aggiungi"; ?> cinema - Multisala</title>
    <style>
        .grd{
            display: grid;
            grid-template-columns: repeat(14, 1fr);
            grid-column-gap: 1px;
            grid-row-gap: 1px;
            position: relative;
            overflow: hidden;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["logged"] == false || $_SESSION["tipoutente"] != 1){
    header("Location: home.php");
    exit();
}
$nome = "";
$indirizzo = "";
$comune = "";
$cap = "";
$responsabile = "";
$data = "";
$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
or die("Connessione fallita: " . mysqli_connect_error());
$resps = mysqli_query($connessione, "SELECT * FROM Utenti WHERE idFRuolo = 2")
or die("Query fallita: " . mysqli_error($connessione));
if(isset($_GET["id"])){
    $result = mysqli_query($connessione, "SELECT * FROM Cinema WHERE IDCinema = " . $_GET["id"])
    or die("Query fallita: " . mysqli_error($connessione));
    $row = mysqli_fetch_array($result);
    $nome = $row["NomeCinema"];
    $indirizzo = $row["Indirizzo"];
    $comune = $row["Comune"];
    $cap = $row["CAP"];
    $responsabile = $row["idFResponsabile"];
    $data = new DateTime();
    if(isset($_GET["date"])){
        $data = DateTime::createFromFormat("Y-m-d", $_GET["date"]);
    }
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-camera-movie me-3"></i><?php if(isset($_GET["id"])) echo "Modifica"; else echo "Aggiungi"; ?> cinema</p>
<a href="gestisci-tutti-cinema.php" class="btn btn-outline-dark m-3 mb-5" style="width: 15%"><i class="fa-solid fa-circle-arrow-left me-2"></i>Torna indietro</a>
<div class="w-75 m-auto pb-5">
    <form action="modifica-cinema.php" method="post">
        <?php
        if(!isset($_GET["id"])){
            echo "<input type='hidden' name='add' value='true'>";
        }
        ?>
        <div>
            <img src="Media/Cinema/<?php
            if(isset($_GET["id"])){
                echo $_GET["id"];
            }else {
                echo "default";
            }
            ?>.png" class="mb-3 w-25 mx-auto d-block" id="imgCop">
        </div>
        <div class="form-floating mb-3">
            <input type="file" class="form-control" name="immagine" placeholder="Copertina" id="immagine" accept="image/png">
            <label for="immagine">Copertina</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="nome" placeholder="Nome del cinema" id="nome" value="<?php echo $nome; ?>" required>
            <label for="nome">Nome del cinema</label>
            <div class="invalid-feedback">Il nome del cinema non pu?? essere vuoto.</div>
        </div>
        <div class="form-floating mb-3">
            <select name="responsabile" id="responsabile" class="form-control">
                <option value="-1" disabled selected>Responsabile</option>
                <?php
                while($row = mysqli_fetch_assoc($resps)){
                    echo "<option value='".$row["IDUtente"]."'";
                    if($responsabile == $row["IDUtente"]){
                        echo " selected";
                    }
                    echo ">".$row["Nome"]." ".$row["Cognome"]."</option>";
                }
                ?>
            </select>
            <label for="responsabile">Responsabile del cinema</label>
            <div class="invalid-feedback">Il responsabile deve essere selezionato.</div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="indirizzo" placeholder="Indirizzo" id="indirizzo" pattern="^(Via|Viale|Piazza|Strada|Corso|Piazzale|Arco|Autostrada|Borgo|Borghetto|Circonvallazione|Galleria|Giardino|Largo|Lungolago|Lungomare|Parco|Ponte|Porto|Riva|Salita|Vicolo)[ ]([A-z]|[ ])+,[ ]([0-9])+$" value="<?php echo $indirizzo; ?>" required>
            <label for="indirizzo">Indirizzo</label>
            <div class="invalid-feedback">L'indirizzo non ?? del formato valido.</div>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" pattern="^([A-z])+" placeholder="Comune" type="text" name="comune" id="comune" autocomplete="home city address-level-2" value="<?php echo $comune; ?>" required>
            <label for="comune">Comune</label>
            <div class="invalid-feedback">Il comune non ?? del formato valido.</div>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" pattern="^([0-9]{5})$" placeholder="CAP" type="text" name="cap" id="cap" value="<?php echo $cap; ?>" required>
            <label for="cap">CAP</label>
            <div class="invalid-feedback">Il CAP non ?? del formato valido.</div>
        </div>
    </form>
    <div class="alert alert-danger d-none" role="alert" id="alertSale">
        Ci deve essere almeno una sala e in ogni sala deve esserci almeno un posto.
    </div>
    <div class="list-group mb-2" id="listaSale">
        <div class="list-group-item list-group-item-primary">
            <h5 class="mb-1">Sale</h5>
        </div>
        <div class="list-group-item">
            <div class="alert alert-danger d-none" role="alert" id="alertSala">
                Le sale non possono avere lo stesso codice.
            </div>
            <div class="input-group mb-3">
                <div class="form-floating flex-grow-1" aria-describedby="aggiungiSala">
                    <input type="text" class="form-control" placeholder="Codice sala" id="codiceSala" pattern="([A-z]|[0-9])+" required>
                    <label for="codiceSala">Codice sala</label>
                    <div class="invalid-feedback">Il codice della sala non pu?? essere vuoto.</div>
                </div>
                <button class="btn btn-primary" type="button" id="aggiungiSala" onclick="aggiungiSala()"><i class="fa-solid fa-plus-large"></i></button>
            </div>
        </div>
        <?php
        if(isset($_GET["id"])){
            $query = "SELECT * FROM Sale WHERE idFCinema = '".$_GET["id"]."'";
            $result = mysqli_query($connessione, $query)
            or die("Query fallita!");
            if(mysqli_num_rows($result) > 0){
                $sale = $result->fetch_all(MYSQLI_ASSOC);
                for($i = 0; $i < count($sale); $i++){?>
                    <div class='list-group-item'>
                        <?php echo $sale[$i]["CodiceSala"];?>
                        <div class='float-end'>
                            <button class='btn btn-primary me-2' type='button' onclick='modSala("<?php echo $sale[$i]["CodiceSala"];?>")'>Modifica</button>
                            <button class='btn btn-danger' type='button' onclick='this.parentElement.parentElement.remove();sale = sale.filter(s => s.codice != "<?php echo $sale[$i]["CodiceSala"];?>");'><i class="fa-solid fa-xmark-large"></i></button>
                        </div>
                    </div>
                <?php
                }
            }
        }
        ?>
    </div>
    <?php if(isset($_GET["id"])){?>
    <div class="table-responsive mb-3">
        <div class="form-floating mb-3">
            <input type="date" class="form-control" placeholder="Giorno" id="giornoProiezioni" onchange="impostaGiornoProiezioni()" value="<?php echo $data->format("Y-m-d");?>" required>
            <label for="giornoProiezioni">Giorno</label>
            <div class="invalid-feedback">Il giorno non pu?? essere vuoto.</div>
        </div>
        <table class="table table-bordered table-striped table-hover caption-top mb-1">
            <thead class="table-dark">
                <tr><td colspan="25" class="text-center fw-bold"><i class="fa-solid fa-projector me-2"></i>Proiezioni</td></tr>
                <tr>
                    <th>Sala</th>
                    <?php
                        $result = mysqli_query($connessione, "SELECT IDProiezione, IDFilm, NomeFilm, IDSala, CodiceSala, Prezzo, OraInizio, Durata, Privata FROM ((Proiezioni AS P INNER JOIN Sale AS S ON P.idFSala = S.IDSala) INNER JOIN Cinema AS C ON S.idFCinema = C.IDCinema) INNER JOIN Film AS F ON P.idFFilm = F.IDFilm WHERE DATE(OraInizio) = '" . $data->format("Y-m-d") . "' AND C.IDCinema = '".$_GET["id"]."' ORDER BY CodiceSala, OraInizio");
                        $film = $result->fetch_all(MYSQLI_ASSOC);
                        for($i = 0; $i < 24; $i++){
                            echo "<th>". ($i + 1) ."</th>";
                        }
                    ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $colors = array("#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400");
                    $csala = "";
                    $f = 0;
                    for($i = 0; $i < count($sale); $i++){
                        if($csala != $sale[$i]["CodiceSala"]){
                            if($i != 0){
                                echo "</tr>";
                            }
                            echo "<tr>";
                            echo "<td>".$sale[$i]["CodiceSala"]."</td>";
                            $csala = $sale[$i]["CodiceSala"];
                        }
                        for($j = 1; $j <= 24; $j++){
                            if(!isset($film[$f]) || $film[$f]["CodiceSala"] != $csala) {
                                echo "<td></td>";
                                continue;
                            }
                            $dataFilm = new DateTime($film[$f]["OraInizio"]);
                            $dataFilm->modify("+".round($dataFilm->format("i"))." minutes");
                            $orainizio = round(date("H", $dataFilm->getTimestamp()));
                            $durata = round($film[$f]["Durata"] / 60);
                            if($j == $orainizio){
                                $fcolor = $colors[$j / 2];
                                $fcolor = hexdec(substr($fcolor, 1, 2)) + hexdec(substr($fcolor, 3, 2)) + hexdec(substr($fcolor, 5, 2));
                                if($fcolor > 500){
                                    $fcolor = "#000";
                                }else{
                                    $fcolor = "#fff";
                                }
                                echo "<td colspan='$durata' id='proiezione-" . $film[$f]["IDProiezione"] . "' onclick='modificaProiezione(" . $film[$f]["IDProiezione"] . ")' style='cursor: pointer; text-align: center; background: " . $colors[$j/2] . "; color: $fcolor'>".$film[$f]["NomeFilm"]."</td>";
                                $j += $durata - 1;
                                if($f + 1 < count($film)){
                                    $f++;
                                }
                            }elseif($j > $orainizio + $durata || $j <= $orainizio){
                                echo "<td></td>";
                            }
                        }
                    }
                    $query = "SELECT * FROM Film ORDER BY NomeFilm";
                    $result = $connessione->query($query);
                    $films = $result->fetch_all(MYSQLI_ASSOC);
                    ?>
            </tbody>
        </table>
        <button class="btn btn-primary float-end" onclick="aggiungiProiezione()"><i class="fa-solid fa-plus-large"></i></button>
    </div>
    <?php } ?>
    <button class="btn btn-danger" onclick="<?php if(isset($_GET["id"])) echo "eliminaCinema()"; else echo "location.href='gestisci-tutti-cinema.php';";?>"><?php if(isset($_GET["id"])) echo "Elimina"; else echo "Annulla";?></button>
    <button class="btn btn-primary float-end" onclick="checkForm()">Salva</button>
</div>
<div class="modal" tabindex="-1" id="modificaSala">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="gestisci-cinema.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Nome del cinema" id="nuovoCodiceSala" required>
                        <label for="nuovoCodiceSala">Codice sala</label>
                        <div class="invalid-feedback">Il nome del cinema non pu?? essere vuoto.</div>
                    </div>
                </form>
                <div class="alert alert-danger d-none" role="alert" id="alert">
                    I posti devono essere unici.
                </div>
                <div class="list-group mb-2" id="listaPosti">
                    <div class="list-group-item list-group-item-primary">
                        <h5 class="mb-1">Posti</h5>
                    </div>
                    <div class="list-group-item">
                        <div class="input-group row mx-auto">
                                <div class="form-floating col-4 p-0">
                                    <input type="text" class="form-control" placeholder="Riga" id="rigaPosto" style="text-transform: uppercase" pattern="[A-Z]" required>
                                    <label for="codiceSala">Riga</label>
                                    <div class="invalid-feedback">La riga del posto non ?? valida.</div>
                                </div>
                                <div class="form-floating col-4 p-0" aria-describedby="aggiungiPosto">
                                    <input type="number" class="form-control" placeholder="Colonna" id="colonnaPosto" min="0" required>
                                    <label for="colonnaPosto">Colonna</label>
                                    <div class="invalid-feedback">La colonna del posto non pu?? essere vuota.</div>
                                </div>
                            <button class="btn btn-primary col-2" type="button" id="aggiungiPosto" onclick="aggiungiPosto()"><i class="fa-solid fa-plus-large"></i></button>
                            <button class="btn btn-primary col-2" type="button" onclick="gridShow()"><i class="fs-3 fa-solid fa-table-cells"></i></button>
                        </div>
                        <div class="grd d-none mx-auto" id="grid" style="width: 50%;"></div>
                    </div>
                    <div id="graficoPosti" class="m-1 mx-auto"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modificaProiezione">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proiezione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="alert alert-danger d-none" role="alert" id="alertProiezione">
                        L'ora di fine della proiezione non pu?? essere sovrapposta a quella di inizio di un'altra.
                    </div>
                    <input type="hidden" name="idProiezione" id="idProiezione">
                    <div id="listaFilm" class="form-floating mb-3">
                        <select class="form-control" aria-label="Film" id="filmProiezione" onchange="impostaOraFineProiezione()" required>
                            <option value="" selected disabled>Film</option>
                            <?php
                            for ($i = 0; $i < count($films); $i++) {
                                echo "<option value='" . $films[$i]['IDFilm'] . "'>" . $films[$i]['NomeFilm'] . " (" . $films[$i]["Durata"] . "min)</option>";
                            }
                            ?>
                        </select>
                        <label for="filmProiezione">Film</label>
                    </div>
                    <div id="listaSale" class="form-floating mb-3">
                        <select class="form-control" aria-label="Sala" id="salaProiezione" required>
                            <option value="" selected disabled>Sala</option>
                            <?php
                            for ($i = 0; $i < count($sale); $i++) {
                                echo "<option value='" . $sale[$i]['IDSala'] . "'>" . $sale[$i]['CodiceSala'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="salaProiezione">Sala</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" min="0.01" step="0.01" class="form-control" placeholder="Prezzo" id="prezzo" required>
                        <label for="prezzo">Prezzo</label>
                        <div class="invalid-feedback">Il prezzo deve essere maggiore di 0???.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="datetime-local" class="form-control" placeholder="Ora inizio" id="dataProiezione" onchange="impostaOraFineProiezione()" required>
                        <label for="dataProiezione">Ora inizio</label>
                        <div class="invalid-feedback">L'ora di inizio non pu?? essere vuota e non pu?? essere pi?? recente di adesso.</div>
                    </div>
                    <div class="form-floating mb-3 d-none">
                        <input type="time" class="form-control" placeholder="Ora inizio" id="oraProiezione" onchange="impostaOraFineProiezione()" required>
                        <label for="dataProiezione">Ora inizio</label>
                        <div class="invalid-feedback">L'ora di inizio non pu?? essere vuota e non pu?? essere pi?? recente di adesso.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="datetime-local" class="form-control" placeholder="Ora fine" id="oraFineProiezione" readonly>
                        <label for="oraFineProiezione">Ora fine</label>
                    </div>
                    <p><input type="checkbox" id="proiezionePrivata"><label for="proiezionePrivata" class="ms-2">Privata</label></p>
                </form>
                <button type="button" class="btn btn-danger d-none" onclick="eliminaProiezione()" id="eliminaProiezione">Elimina</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary" onclick="salvaModificheProiezione()">Salva</button>
            </div>
        </div>
    </div>
</div>
<script>
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    let immagineUp = document.getElementById('immagine');
    immagineUp.onchange = evt => {
        const [file] = immagineUp.files;
        if(file){
            document.getElementById('imgCop').src = URL.createObjectURL(file);
        }
    };
    let sale = [];
    <?php
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $query = "SELECT IDPosto, Riga, Colonna, CodiceSala, IDSala FROM Posti AS P INNER JOIN Sale AS S ON P.idFSala = S.IDSala WHERE idFCinema = " . $_GET["id"];
        $result = mysqli_query($connessione, $query);
        $idsala = 0;
        $sale = "[";
        $posti = "";
        while($row = mysqli_fetch_assoc($result)){
            if($idsala != $row["IDSala"]){
                if($idsala != 0){
                    $posti = substr($posti, 0, -1);
                    $posti .= "]},";
                }
                $idsala = $row["IDSala"];
                $sale .= $posti;
                $sale .= "{codice: '" . $row["CodiceSala"] . "', posti: [";
                $posti = "";
            }
            $posti .= "{riga: '" . $row["Riga"] . "', colonna: " . $row["Colonna"] . "},";
        }
        $posti = substr($posti, 0, -1);
        $posti .= "]}";
        $sale .= $posti . "]";
        echo "sale = " . $sale . ";";?>
        function modSala(codsala){
            $("#modificaSala").modal("show");
            $("#nuovoCodiceSala").val(codsala);
            $("#rigaPosto").val("");
            $("#colonnaPosto").val("");
            let sala = sale.filter(s => s.codice == codsala)[0];
            document.getElementById('graficoPosti').innerHTML = "";
            for (let i = 0; i < sala.posti.length; i++) {
                genPosto(sala, sala.posti[i]);
            }
        }
    <?php } ?>
    function checkForm(){
        let form = document.getElementsByTagName("form")[0]
        let inputs = form.getElementsByTagName('input');
        let sel = form.getElementsByTagName('select')[0];
        let valid = true;
        for (let i = 0; i < inputs.length; i++){
            if (inputs[i].type == 'file') continue;
            if(!inputs[i].checkValidity()){
                valid = false;
                inputs[i].classList.add("is-invalid");
            }else {
                inputs[i].classList.remove("is-invalid");
            }
        }
        if(sel.value == -1){
            valid = false;
            sel.classList.add("is-invalid");
        }else {
            sel.classList.remove("is-invalid");
        }
        if(sale.length == 0){
            valid = false;
            document.querySelector('#alertSale').classList.remove("d-none");
            setTimeout(() => document.querySelector('#alertSale').classList.add("d-none"), 3000);
        }
        for (let i = 0; i < sale.length; i++) {
            if(sale[i].posti.length == 0){
                valid = false;
                document.querySelector('#alertSale').classList.remove("d-none");
                setTimeout(() => document.querySelector('#alertSale').classList.add("d-none"), 3000);
            }else {

            }
        }
        if(valid) {
            $.post("modifica-cinema.php", {
                nome: document.getElementById("nome").value,
                responsabile: document.getElementById("responsabile").value,
                indirizzo: document.getElementById("indirizzo").value,
                comune: document.getElementById("comune").value,
                cap: document.getElementById("cap").value,
                sale: sale,
                <?php if(!isset($_GET["id"])) { echo "add: true"; } else{ echo "edit: true, id: " . $_GET["id"]; } ?>
            }, function (data, status) {
                if(immagineUp.files[0]){
                    let frm = document.createElement("form");
                    let img = document.createElement("input");
                    let id = document.createElement("input");
                    img.type = "hidden";
                    img.name = "img";
                    img.value = true;
                    id.type = "hidden";
                    id.name = "id";
                    id.value = data;
                    frm.enctype = "multipart/form-data";
                    frm.action = "modifica-cinema.php";
                    frm.method = "post";
                    frm.append(immagineUp);
                    frm.append(img);
                    frm.append(id);
                    frm.classList.add("d-none");
                    document.body.append(frm);
                    frm.submit();
                }else{
                    location.href = "gestisci-tutti-cinema.php";
                }
            });
        }
    }
    function aggiungiPosto(){
        let v = true;
        let cp = document.getElementById("colonnaPosto");
        let rp = document.getElementById("rigaPosto");
        let ncs = document.getElementById("nuovoCodiceSala");
        if(!cp.checkValidity()){
            cp.classList.add("is-invalid");
            v = false;
        }else{
            cp.classList.remove("is-invalid");
        }
        if(!rp.checkValidity()){
            rp.classList.add("is-invalid");
            v = false;
        }else{
            rp.classList.remove("is-invalid");
        }
        if(!v) return;
        let sala = sale.filter(s => s.codice == ncs.value)[0];
        let posto = {
            riga: rp.value,
            colonna: cp.value
        };
        if(sala.posti.filter(p => p.riga == posto.riga && p.colonna == posto.colonna).length > 0){
            document.querySelector('#alert').classList.remove("d-none");
            setTimeout(() => document.querySelector('#alert').classList.add("d-none"), 3000);
            return;
        }
        let pos = sala.posti.push(posto);
        genPosto(sala, posto)
    }
    function aggiungiSala(){
        let cs = document.getElementById("codiceSala");
        if(!cs.checkValidity()){
            cs.classList.add("is-invalid");
            return;
        }else{
            cs.classList.remove("is-invalid");
        }
        let sala = {
            codice: cs.value,
            posti: []
        };
        if(sale.filter(s => s.codice == sala.codice).length > 0){
            document.querySelector('#alertSala').classList.remove("d-none");
            setTimeout(() => document.querySelector('#alertSala').classList.add("d-none"), 3000);
            return;
        }
        sale.push(sala);
        let el = document.createElement("div");
        el.className = "list-group-item";
        el.append(document.createTextNode(sala.codice));
        el.append(document.createElement("div"));
        el.getElementsByTagName("div")[0].className = "float-end";
        el.getElementsByTagName("div")[0].append(document.createElement("button"));
        el.getElementsByTagName("button")[0].className = "btn btn-primary me-2";
        el.getElementsByTagName("button")[0].append(document.createTextNode("Modifica"));
        el.getElementsByTagName("button")[0].addEventListener("click", function(){
            $("#modificaSala").modal("show");
            $('#nuovoCodiceSala').val(sala.codice);
            $("#rigaPosto").val("");
            $("#colonnaPosto").val("");
            $("#oraProiezione").parent().addClass("d-none");
            $("#dataProiezione").parent().removeClass("d-none");
            $("#eliminaProiezione").removeClass("d-none");
            document.getElementById('graficoPosti').innerHTML = "";
            for (let i = 0; i < sala.posti.length; i++) {
                genPosto(sala, sala.posti[i]);
            }
        });
        el.getElementsByTagName("div")[0].append(document.createElement("button"));
        el.getElementsByTagName("button")[1].className = "btn btn-danger me-2";
        el.getElementsByTagName("button")[1].className = "btn btn-danger";
        el.getElementsByTagName("button")[1].innerHTML = '<i class="fa-solid fa-xmark-large"></i>';
        el.getElementsByTagName("button")[1].addEventListener("click", function(){
            this.parentElement.parentElement.remove();
            sale.splice(sale.indexOf(sala), 1);
        });
        document.getElementById("listaSale").append(el);
        cs.value = "";
    }
    function eliminaPosto(sala, posto){
        let postoEl = document.querySelectorAll("[data-bs-toggle='tooltip']");
        for(let i = 0; i < postoEl.length; i++){
            if(postoEl[i].getAttribute("data-bs-title").split("&nbsp")[0] == posto.riga + posto.colonna){
                postoEl[i].parentElement.remove();
                break;
            }
        }
        sale[sale.indexOf(sala)].posti.splice(sala.posti.indexOf(posto), 1);
    }
    function genPosto(sala, posto){
        let postoEl = document.createElement("i");
        postoEl.classList.add("fa-solid", "fa-loveseat", "fs-4", "text-primary", "ms-1");
        postoEl.setAttribute("data-bs-toggle", "tooltip");
        postoEl.setAttribute("data-bs-placement", "top");
        postoEl.setAttribute("title", posto.riga + posto.colonna);
        postoEl.addEventListener("contextmenu", function(e){
            e.preventDefault();
            let pst = sala.posti.filter(p => p.riga == posto.riga && p.colonna == posto.colonna)[0];
            sala.posti.splice(sala.posti.indexOf(pst), 1);
            document.querySelectorAll('[role="tooltip"]').forEach(t => t.parentElement.removeChild(t));
            this.parentElement.removeChild(this);
        });
        let riga = document.getElementsByClassName("r-" + posto.riga)[0];
        if(riga === undefined){
            riga = document.createElement("div");
            riga.classList.add("r-" + posto.riga);
            let gpch = document.getElementById("graficoPosti").children;
            let len = gpch.length;
            for(let i = 0; i < len; i++){
                if(gpch[i].className.slice(2) > posto.riga){
                    gpch[i].before(riga);
                    break;
                }
            }
            if(riga.parentElement === null) document.getElementById("graficoPosti").appendChild(riga);
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
    function generateGrid(){
        let grid = document.getElementById("grid");
        for(let i = 0; i < 14; i++){
            let tdiv = document.createElement("div");
            tdiv.style.width = "12px";
            tdiv.style.height = "12px";
            tdiv.style.margin = "1px";
            tdiv.style.fontSize = "12px";
            if(i != 0) tdiv.innerText = i;
            grid.appendChild(tdiv);
        }
        for(let i = 0; i < 13; i++){
            let tdiv = document.createElement("div");
            tdiv.style.width = "12px";
            tdiv.style.height = "12px";
            tdiv.style.margin = "1px";
            tdiv.style.fontSize = "12px";
            tdiv.innerText = String.fromCharCode(65 + i);
            grid.appendChild(tdiv);
            for(let j = 0; j < 13; j++){
                let div = document.createElement("div");
                div.className = "border border-secondary";
                div.style.width = "12px";
                div.style.height = "12px";
                div.style.margin = "1px";
                div.id = "grid-element-" + i + "-" + j;
                div.onmouseover = function(){
                    let x = this.id.split("-")[2];
                    let y = this.id.split("-")[3];
                    for(let i = 0; i < 13; i++){
                        for(let j = 0; j < 13; j++){
                            let div = document.getElementById("grid-element-" + i + "-" + j);
                            if(i <= x && j <= y){
                                div.classList.add("bg-primary");
                            }
                        }
                    }
                }
                div.onmouseleave = function(){
                    let x = this.id.split("-")[2];
                    let y = this.id.split("-")[3];
                    for(let i = 0; i < 13; i++){
                        for(let j = 0; j < 13; j++){
                            let div = document.getElementById("grid-element-" + i + "-" + j);
                            if(i <= x && j <= y){
                                div.classList.remove("bg-primary");
                            }
                        }
                    }
                }
                div.onclick = function(){
                    document.getElementById("grid").classList.add("d-none");
                    let x = this.id.split("-")[2];
                    let y = this.id.split("-")[3];
                    generateSeats(x, y);
                }
                grid.appendChild(div);
            }
        }
    }
    function gridShow(){
        let grid = document.getElementById("grid");
        if(grid.classList.contains("d-none")){
            grid.classList.remove("d-none");
        }else{
            grid.classList.add("d-none");
        }
    }
    function generateSeats(x, y){
        let ncs = document.getElementById("nuovoCodiceSala");
        let sala = sale.filter(s => s.codice == ncs.value)[0];
        let graficoPosti = document.getElementById("graficoPosti");
        graficoPosti.innerHTML = "";
        sala.posti = [];
        for (let i = 0; i <= x; i++) {
            for (let j = 0; j <= y; j++) {
                let posto = {
                    riga: String.fromCharCode(i + 65),
                    colonna: j + 1,
                };
                sala.posti.push(posto);
                genPosto(sala, posto);
            }
        }
    }
    generateGrid();
    <?php
    if(isset($_GET["id"])){?>
        function eliminaCinema(){
            let form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", "modifica-cinema.php");
            form.classList.add("d-none");
            let input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "id");
            input.setAttribute("value", <?php echo $_GET["id"]; ?>);
            form.appendChild(input);
            let input2 = document.createElement("input");
            input2.setAttribute("type", "hidden");
            input2.setAttribute("name", "elimina");
            input2.setAttribute("value", "true");
            form.appendChild(input2);
            document.body.appendChild(form);
            form.submit();
        }
        let films = [];
        let proiezioni = [];
        let dataCont;
        <?php
        echo "films = " . json_encode($films) . ";";
        echo "proiezioni = " . json_encode($film) . ";";
        if(isset($_GET["date"])){
            echo "dataCont = " . json_encode($_GET["date"]) . ";";
        }
        ?>
        function modificaProiezione(id){
            $("#modificaProiezione").modal("show");
            $('#idProiezione').val(id);
            let proiezione = proiezioni.filter(p => p.IDProiezione == id)[0];
            $('#proiezionePrivata').attr("checked", proiezione.Privata != 0);
            $('#filmProiezione').val(proiezione.IDFilm);
            $('#salaProiezione').val(proiezione.IDSala);
            $('#prezzo').val(proiezione.Prezzo);
            let oraInizio = new Date(proiezione.OraInizio);
            oraInizio = new Date(oraInizio.getTime() - oraInizio.getTimezoneOffset() * 60000);
            $('#dataProiezione').val(oraInizio.toISOString().split("Z")[0]);
            $("#oraProiezione").parent().addClass("d-none");
            $("#dataProiezione").parent().removeClass("d-none");
            $("#eliminaProiezione").removeClass("d-none");
            impostaOraFineProiezione();
        }
        function salvaModificheProiezione(){
            let dataProiezione = document.getElementById('dataProiezione');
            if($('#idProiezione').val() == ""){
                dataProiezione = document.getElementById('oraProiezione');
            }
            let film = document.getElementById('filmProiezione');
            let salaProiezione = document.getElementById('salaProiezione');
            let prezzo = document.getElementById('prezzo');
            if(!dataProiezione.checkValidity()){
                dataProiezione.classList.add("is-invalid");
                return;
            }
            if(!film.checkValidity()){
                film.classList.add("is-invalid");
                return;
            }
            if(!salaProiezione.checkValidity()){
                salaProiezione.classList.add("is-invalid");
                return;
            }
            if(!prezzo.checkValidity()){
                prezzo.classList.add("is-invalid");
                return;
            }
            dataProiezione.classList.remove("is-invalid");
            film.classList.remove("is-invalid");
            salaProiezione.classList.remove("is-invalid");
            let valid = true;
            let dtf = new Date($('#oraFineProiezione').val());
            let dti;
            if($('#idProiezione').val() == ""){
                if(dataCont == undefined) dti = new Date();
                else dti = new Date(dataCont);
                let splitHour = $('#oraProiezione').val().split(":");
                dti.setHours(splitHour[0]);
                dti.setMinutes(splitHour[1]);
                dti.setSeconds(0);
                dti.setMilliseconds(0);
            }else{
                dti = new Date(dataProiezione.value);
            }
            for (let i = 0; i < proiezioni.length; i++) {
                if($('#idProiezione').val() != "" && proiezioni[i].IDProiezione != $('#idProiezione').val()){
                    if(proiezioni[i].IDSala == salaProiezione.value) {
                        let dti2 = new Date(proiezioni[i].OraInizio);
                        let film = films.filter(f => f.IDFilm == proiezioni[i].IDFilm)[0];
                        let dtf2 = new Date(dti2.getTime() + film.Durata * 60000);
                        if (dti2.getTime() > dti.getTime() && dti2.getTime() < dtf.getTime()) {
                            valid = false;
                            break;
                        } else if (dtf2.getTime() > dti.getTime() && dtf2.getTime() < dtf.getTime()) {
                            valid = false;
                            break;
                        }
                    }
                }else if(new Date() > new Date(proiezioni[i].OraInizio) || new Date() > dti){
                    dataProiezione.classList.add("is-invalid");
                    return;
                }
            }
            if(new Date() > dti){
                dataProiezione.classList.add("is-invalid");
                return;
            }
            if(!valid){
                $('#alertProiezione').removeClass("d-none");
                setTimeout(() => $('#alertProiezione').addClass("d-none"), 5000);
                return;
            }
            if($('#idProiezione').val() == ""){
                $.post("modifica-cinema.php", {
                    idFilm: $('#filmProiezione').val(),
                    idSala: $('#salaProiezione').val(),
                    prezzo: $('#prezzo').val(),
                    oraInizio: new Date(dti.getTime() - dti.getTimezoneOffset() * 60000).toISOString().split("Z")[0],
                    privata: $('#proiezionePrivata').prop("checked"),
                    aggiungiProiezione: true
                }, function (data) {
                    location.reload();
                });
            }else {
                $.post("modifica-cinema.php", {
                    id: $('#idProiezione').val(),
                    idFilm: $('#filmProiezione').val(),
                    idSala: $('#salaProiezione').val(),
                    prezzo: $('#prezzo').val(),
                    oraInizio: $('#dataProiezione').val(),
                    privata: $('#proiezionePrivata').prop("checked"),
                    modificaProiezione: true
                }, function (data) {
                    location.reload();
                });
            }
        }
        function impostaOraFineProiezione(){
            let oraInizio;
            if($('#idProiezione').val() == ""){
                if(dataCont == undefined) oraInizio = new Date();
                else oraInizio = new Date(dataCont);
                let splitHour = $('#oraProiezione').val().split(":");
                oraInizio.setHours(splitHour[0]);
                oraInizio.setMinutes(splitHour[1]);
                oraInizio.setSeconds(0);
                oraInizio.setMilliseconds(0);
            }else{
                oraInizio = new Date($("#dataProiezione").val());
            }
            let film = films.filter(film => film.IDFilm == $('#filmProiezione').val())[0];
            let oraFine = new Date(oraInizio.getTime() + film.Durata * 60000 - oraInizio.getTimezoneOffset() * 60000);
            $("#oraFineProiezione").val(oraFine.toISOString().split("Z")[0]);
        }
        function aggiungiProiezione(){
            $('#modificaProiezione').modal('show');
            $('#idProiezione').val("");
            $('#filmProiezione').val("");
            $('#salaProiezione').val("");
            $('#prezzo').val("");
            $('#dataProiezione').val("");
            $('#oraProiezione').val("");
            $('#oraFineProiezione').val("");
            $('#proiezionePrivata').prop("checked", false);
            $('#alertProiezione').addClass("d-none");
            $("#oraProiezione").parent().removeClass("d-none");
            $("#dataProiezione").parent().addClass("d-none");
            $("#eliminaProiezione").addClass("d-none");
        }
        function impostaGiornoProiezioni(){
            location.href='gestisci-cinema.php?id=<?php echo $_GET["id"] ?>&date=' + $('#giornoProiezioni').val();
        }
        function eliminaProiezione(){
            $.post("modifica-cinema.php", {
                id: $('#idProiezione').val(),
                eliminaProiezione: true
            }, function (data) {
                location.reload();
            });
        }
    <?php } ?>
</script>
</body>
</html>
