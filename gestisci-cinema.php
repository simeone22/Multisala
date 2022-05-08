<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="Media/fontawesome/css/all.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Aggiungi cinema - Multisala</title>
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
if(isset($_GET["id"])){

}
?>
<?php include "navbar.php" ?>
    <p class="fs-1 m-3 mb-5"><i class="fa-solid fa-camera-movie me-3"></i>Aggiungi cinema</p>
<div class="w-75 m-auto">
    <form action="gestisci-cinema.php" method="post">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="nome" placeholder="Nome del cinema" id="nome" required>
            <label for="nome">Nome del cinema</label>
            <div class="invalid-feedback">Il nome del cinema non può essere vuoto.</div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="indirizzo" placeholder="Indirizzo" id="indirizzo" pattern="^(Via|Viale|Piazza|Strada|Corso|Piazzale|Arco|Autostrada|Borgo|Borghetto|Circonvallazione|Galleria|Giardino|Largo|Lungolago|Lungomare|Parco|Ponte|Porto|Riva|Salita|Vicolo)[ ]([A-z]|[ ])+,[ ]([0-9])+$" required>
            <label for="indirizzo">Indirizzo</label>
            <div class="invalid-feedback">L'indirizzo non è del formato valido.</div>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" pattern="^([A-z])+" placeholder="Comune" type="text" name="comune" id="comune" autocomplete="address-level-2" required>
            <label for="comune">Comune</label>
            <div class="invalid-feedback">Il comune non è del formato valido.</div>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" pattern="^([0-9]{5})$" placeholder="CAP" type="text" name="cap" id="cap" required>
            <label for="fax">CAP</label>
            <div class="invalid-feedback">Il CAP non è del formato valido.</div>
        </div>
    </form>
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
                    <div class="invalid-feedback">Il codice della sala non può essere vuoto.</div>
                </div>
                <button class="btn btn-primary" type="button" id="aggiungiSala" onclick="aggiungiSala()"><i class="fa-solid fa-plus-large"></i></button>
            </div>
        </div>
        <?php
        if(isset($_GET["id"])){
            $query = "SELECT * FROM Sale WHERE idFCinema = '".$_GET["id"]."'";
            $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
            or die("Connessione fallita: " . mysqli_connect_error());
            $result = mysqli_query($connessione, $query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){?>
                    <div class='list-group-item'>
                        <?php echo $row["CodiceSala"];?>
                        <div class='float-end'>
                            <button class='btn btn-primary me-2' type='button' onclick='$("#modificaSala").modal("show");$("#nuovoCodiceSala").val(<?php echo $row["CodiceSala"];?>);'>Modifica</button>
                            <!-- TODO: controllare che funzioni -->
                            <!--button class='btn btn-danger' type='button' onclick='this.parentElement.parentElement.remove();sale.splice(sale.indexOf(sale.filter(s => s.codice == <?php echo $row["CodiceSala"];?>)[0]), 1);'><i class="fa-solid fa-xmark-large"></i></button-->
                            <button class='btn btn-danger' type='button' onclick='this.parentElement.parentElement.remove();sale = sale.filter(s => s.codice != <?php echo $row["CodiceSala"];?>);'><i class="fa-solid fa-xmark-large"></i></button>
                        </div>
                    </div>
                <?php
                }
            }
        }
        ?>
    </div>
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
                        <div class="invalid-feedback">Il nome del cinema non può essere vuoto.</div>
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
                                <div class="form-floating col-5 p-0">
                                    <input type="text" class="form-control" placeholder="Riga" id="rigaPosto" style="text-transform: uppercase" pattern="[A-Z]" required>
                                    <label for="codiceSala">Riga</label>
                                    <div class="invalid-feedback">La riga del posto non è valida.</div>
                                </div>
                                <div class="form-floating col-5 p-0" aria-describedby="aggiungiPosto">
                                    <input type="number" class="form-control" placeholder="Colonna" id="colonnaPosto" required>
                                    <label for="colonnaPosto">Colonna</label>
                                    <div class="invalid-feedback">La colonna del posto non può essere vuota.</div>
                                </div>
                            <button class="btn btn-primary col-2" type="button" id="aggiungiPosto" onclick="aggiungiPosto()"><i class="fa-solid fa-plus-large"></i></button>
                        </div>
                    </div>
                    <div id="graficoPosti" class="m-1"></div>
                    <?php
                    /*if(isset($_GET["id"])){
                        $query = "SELECT * FROM Sale WHERE idFCinema = '".$_GET["id"]."'";
                        $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
                        $result = mysqli_query($connessione, $query);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<a href='#' class='list-group-item list-group-item-action flex-column align-items-start'>";
                                echo "<div class='d-flex w-100 justify-content-between'>";
                                echo "<h5 class='mb-1'>".$row["CodiceSala"]."</h5>";
                                echo "<small>".$row["posto"]." posti</small>";
                                echo "</div>";
                                echo "<p class='mb-1'>".$row["indirizzo"]."</p>";
                                echo "<small>".$row["comune"]." (".$row["cap"].")</small>";
                                echo "</a>";
                            }
                        }
                    }*/
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="this.parentElement.parentElement.getElementsByTagName('form')[0].reset();">Annulla</button>
                <button type="button" class="btn btn-primary" onclick="">Salva</button>
            </div>
        </div>
    </div>
</div>
<script>
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    let sale = [];
    function checkForm(form){
        let inputs = form.getElementsByTagName('input');
        let valid = true;
        for (let i = 0; i < inputs.length; i++){
            if(!inputs[i].checkValidity()){
                valid = false;
                inputs[i].classList.add("is-invalid");
            }else {
                inputs[i].classList.remove("is-invalid");
            }
        }
        if(valid) form.submit();
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
        //TODO: Inserimento posto in base alla riga e colonna
        document.getElementById("graficoPosti").appendChild(postoEl);
        new bootstrap.Tooltip(postoEl);
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
    function eliminaPosto(posto){
        let postoEl = document.querySelectorAll("[data-bs-toggle='tooltip']");
        for(let i = 0; i < postoEl.length; i++){
            if(postoEl[i].getAttribute("data-bs-title").split("&nbsp")[0] == posto.riga + posto.colonna){
                postoEl[i].parentElement.remove();
                break;
            }
        }
        sale[sale.indexOf(sala)].posti.splice(sala.posti.indexOf(posto), 1);
    }
</script>
</body>
</html>
