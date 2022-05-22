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
    <title>Aggiungi film - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["logged"] == false || $_SESSION["tipoutente"] != 1){
    header("Location: home.php");
    exit();
}
$nome = "";
$trama = "";
$durata = "";
$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
or die("Connessione fallita: " . mysqli_connect_error());
if(isset($_GET["id"])){
    $result = mysqli_query($connessione, "SELECT * FROM Film WHERE IDFilm = " . $_GET["id"])
    or die("Query fallita: " . mysqli_error($connessione));
    $row = mysqli_fetch_array($result);
    $nome = $row["NomeFilm"];
    $trama = $row["Trama"];
    $durata = $row["Durata"];
    $result = mysqli_query($connessione, "SELECT * FROM CategorieFilm WHERE idFFilm = " . $_GET["id"] . " ORDER BY idFCategoria");
    $categorie = $result->fetch_all(MYSQLI_ASSOC);
    $result = mysqli_query($connessione, "SELECT * FROM AttoriFilm WHERE idFFilm = " . $_GET["id"] . " ORDER BY idFAttore");
    $attori = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-camera-movie me-3"></i>Aggiungi film</p>
<a href="gestisci-tutti-film.php" class="btn btn-outline-dark m-3 w-25 mb-5"><i class="fa-solid fa-circle-arrow-left me-2"></i>Torna indietro</a>
<div class="w-75 m-auto mb-5">
    <form action="modifica-film.php" enctype="multipart/form-data" method="post">
        <?php
        if(!isset($_GET["id"])){
            echo "<input type='hidden' name='add' value='true'>";
        }
        ?>
        <div>
            <img src="Media/Film/<?php
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
            <input type="text" class="form-control" name="nome" placeholder="Nome del film" id="nome" value="<?php echo $nome?>" required>
            <label for="nome">Nome del film</label>
            <div class="invalid-feedback">Il nome del film non può essere vuoto.</div>
        </div>
        <div class="form-floating mb-3">
            <select name="categoria" id="categoria" class="form-select" multiple required>
                <?php
                $sql = mysqli_query($connessione, "SELECT * FROM Categorie ORDER BY IDCategoria");
                $pcat = 0;
                while($row = $sql->fetch_assoc()){?>
                    <?php
                    echo "<option value=\"" . $row["IDCategoria"] . "\"";
                    if(isset($_GET["id"])){
                        if($pcat < count($categorie)) {
                            if ($row["IDCategoria"] == $categorie[$pcat]["idFCategoria"]) {
                                echo " selected";
                                $pcat++;
                            }
                        }
                    }
                    echo ">" . $row["NomeCategoria"] . "</option>";
                } ?>
                <div class="invalid-feedback">Il film deve appartene almeno ad una categoria.</div>
            </select>
        </div>
        <div class="input-group row g-1 mb-3">
            <div class="form-floating col-11">
                <select name="attori" id="attori" class="form-select" multiple required >
                    <?php
                    $sql = mysqli_query($connessione, "SELECT * FROM Attori");
                    $pcat = 0;
                    while($row = $sql->fetch_assoc()){?>
                        <?php
                        echo "<option value=\"" . $row["IDAttore"] . "\"";
                        if(isset($_GET["id"])){
                            if($pcat < count($attori)) {
                                if ($row["IDAttore"] == $attori[$pcat]["idFAttore"]) {
                                    echo " selected";
                                    $pcat++;
                                }
                            }
                        }
                        echo ">" . $row["Nome"] . " " . $row["Cognome"] . "</option>";
                    } ?>
                    <div class="invalid-feedback">Il film deve avere almeno un attore.</div>
                </select>
            </div>
            <button type="button" class="btn btn-primary input-group-append col-1" onclick="$('#aggiungiAttore').modal('show');"><i class="fa-solid fa-plus-large"></i></button>
        </div>
        <div class="form-floating my-3">
            <textarea class="form-control" placeholder="Trama" type="text" name="trama" id="trama" style="height: 310px;" required><?php echo $trama?></textarea>
            <label for="trama">Trama</label>
            <div class="invalid-feedback">La trama non può essere vuota.</div>
        </div>
        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="durata" placeholder="durata" id="durata" value="<?php echo $durata?>" required>
            <label for="durata">Durata</label>
            <div class="invalid-feedback">Il film deve avere una durata.</div>
        </div>
    </form>
    <button class="btn btn-danger" onclick="<?php if(isset($_GET["id"])) echo "eliminaFilm()"; else echo "location.href='gestisci-tutti-film.php';";?>"><?php if(isset($_GET["id"])) echo "Elimina"; else echo "Annulla";?></button>
    <button class="btn btn-primary float-end" onclick="checkForm()">Salva</button>
</div>
<div class="modal" tabindex="-1" id="aggiungiAttore">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aggiungi un attore</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="password-reset.php" method="post">
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input name="nomeAttore" id="nomeAttore" type="text" placeholder="Nome" class="form-control" required>
                            <label for="nomeAttore">Nome</label>
                            <div class="invalid-feedback">Il nome non può essere vuoto.</div>
                        </div>
                        <div class="form-floating">
                            <input name="cognomeAttore" id="cognomeAttore" type="text" placeholder="Cognome" class="form-control" required>
                            <label for="cognomeAttore">Cognome</label>
                            <div class="invalid-feedback">Il cognome non può essere vuoto.</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="this.parentElement.parentElement.getElementsByTagName('form')[0].reset();">Annulla</button>
                <button type="button" class="btn btn-primary" onclick="checkFormAttore(this.parentElement.parentElement.getElementsByTagName('form')[0])">Aggiungi</button>
            </div>
        </div>
    </div>
</div>
<script>
    let immagineUp = document.getElementById('immagine');
    immagineUp.onchange = evt => {
        const [file] = immagineUp.files;
        if(file){
            document.getElementById('imgCop').src = URL.createObjectURL(file);
        }
    }
    function checkFormAttore(form){
        let inputs = form.getElementsByTagName('input');
        let valid = true;
        for(let i = 0; i < inputs.length; i++){
            if(!inputs[i].checkValidity()){
                valid = false;
                inputs[i].classList.add('is-invalid');
            }else{
                inputs[i].classList.remove('is-invalid');
            }
        }
        if(valid){
            $.post("modifica-film.php", {
                nome: inputs[0].value,
                cognome: inputs[1].value,
                attore: true
            }, () => {
                location.reload();
            });
        }
    }
    //TODO: generare in json php
    function checkForm(){
        let form = document.getElementsByTagName("form")[0]
        let inputs = form.getElementsByTagName('input');
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

        if(valid) {
            let dati = {
                nome: document.getElementById("nome").value,
                trama: document.getElementById("trama").value,
                durata: document.getElementById("durata").value,
                categorie: Array.from(document.getElementById('categoria').options).filter(opt => opt.selected).map(opt => opt.value),
                attori: Array.from(document.getElementById('attori').options).filter(opt => opt.selected).map(opt => opt.value),
                <?php if(!isset($_GET["id"])) { echo "add: true"; } else{ echo "edit: true, id: " . $_GET["id"]; } ?>
            };
            $.post("modifica-film.php", dati, function (data, status) {
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
                    frm.action = "modifica-film.php";
                    frm.method = "post";
                    frm.append(immagineUp);
                    frm.append(img);
                    frm.append(id);
                    frm.classList.add("d-none");
                    document.body.append(frm);
                    frm.submit();
                }
            });
        }
    }

    <?php
    if(isset($_GET["id"])){?>
    function eliminaFilm(){
        let form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "modifica-film.php");
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
    <?php } ?>
</script>
</body>
</html>