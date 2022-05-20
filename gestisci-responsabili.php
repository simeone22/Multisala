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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Responsabili - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["logged"] == false || $_SESSION["tipoutente"] != 1){
    header("Location: home.php");
    exit();
}
$nome = "";
$cognome = "";
$email = "";
$password = "";
$codicefiscale = "";
$telefono = "";
$datanascita = "";

$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
or die("Connessione fallita: " . mysqli_connect_error());
if(isset($_GET["id"])){
    $result = mysqli_query($connessione, "SELECT * FROM Utenti WHERE IDUtente = ". $_GET["id"])
    or die("Query fallita: " . mysqli_error($connessione));
    $row = mysqli_fetch_array($result);
    $nome = $row["Nome"];
    $cognome = $row["Cognome"];
    $email = $row["Email"];
    $password = $row["Password"];
    $codicefiscale = $row["CodiceFiscale"];
    $telefono = $row["Telefono"];
    $datanascita = $row["DataNascita"];
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-user-tie me-3"></i>Gestisci responsabili</p>
<a href="gestisci-tutti-responsabili.php" class="btn btn-outline-dark m-3 w-25 mb-5"><i class="fa-solid fa-circle-arrow-left me-2"></i>Torna indietro</a>
<div class="w-75 m-auto">
    <form action="modifica-responsabile.php" method="post">
        <?php
        if(!isset($_GET["id"])){
            echo "<input type='hidden' name='add' value='true'>";
        }
        ?>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="nome" placeholder="Nome" id="nome" value="<?php echo $nome?>" required>
            <label for="nome">Nome</label>
            <div class="invalid-feedback">Il responsabile deve avere un nome.</div>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" placeholder="cognome" type="text" name="cognome" id="cognome" value="<?php echo $cognome?>" required>
            <label for="cognome">Cognome</label>
            <div class="invalid-feedback">Il responsabile deve avere un cognome.</div>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" placeholder="email" id="email" value="<?php echo $email?>" required>
            <label for="email">Email</label>
            <div class="invalid-feedback">Il responsabile deve avere una mail.</div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="codicefiscale" placeholder="codicefiscale" id="codiceFiscale" maxlength="16" minlength="16" value="<?php echo $codicefiscale?>" required>
            <label for="codiceFiscale">Codice fiscale</label>
            <div class="invalid-feedback">Il responsabile deve avere un codice fiscale.</div>
        </div>
        <div class="form-floating mb-3">
            <input type="tel" class="form-control" name="telefono" placeholder="telefono" id="telefono" pattern="([0-9]{10})" value="<?php echo $telefono?>" required>
            <label for="telefono">Telefono </label>
            <div class="invalid-feedback">Inserire il numero di telefono.</div>
        </div>
        <div class="form-floating mb-3">
            <input type="date" class="form-control" name="dataNascita" placeholder="dataNascita" id="dataNascita" value="<?php echo $datanascita?>" required>
            <label for="dataNascita">Data di nascita </label>
            <div class="invalid-feedback">Inserire la data di nascita.</div>
        </div>
    </form>
    <button class="btn btn-danger" onclick="<?php if(isset($_GET["id"])) echo "eliminaResponsabile()"; else echo "location.href='gestisci-tutti-responsabili.php';";?>"><?php if(isset($_GET["id"])) echo "Elimina"; else echo "Annulla";?></button>
    <?php
    if (isset($_GET["id"]))
    {
    ?>
        <a type="submit" class="btn btn-primary mx-auto" name="reset" placeholder="reset" id="reset" href="password-reset.php">Reset password</a>
    <?php
    }
    ?>
    <button class="btn btn-primary float-end" onclick="checkForm()">Salva</button>
</div>

<script>
    //TODO: generare in json php
    function controllaValidita(){
        let p1 = document.getElementById('password')
        let p2 = document.getElementById('ripetiPassword');
        if(p1.value !== p2.value){
            $('#passwordErr').show();
            return false;
        }
        return true;
    }

    function checkForm(){
        let form = document.getElementsByTagName("form")[0]
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

        if(valid) {
            $.post("modifica-responsabile.php", {
                nome: document.getElementById("nome").value,
                cognome: document.getElementById("cognome").value,
                email: document.getElementById("email").value,
                codicefiscale: document.getElementById("codiceFiscale").value,
                datanascita: document.getElementById("dataNascita").value,
                telefono: document.getElementById("telefono").value,
                <?php if(!isset($_GET["id"])) { echo "add: true"; } else{ echo "edit: true, id: " . $_GET["id"]; } ?>
            }, function (data, status) {
                location.href = "gestisci-tutti-responsabili.php";
            });
        }
    }
    <?php
    if(isset($_GET["id"])){?>
    function eliminaResponsabile(){
        let form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "modifica-responsabile.php");
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
