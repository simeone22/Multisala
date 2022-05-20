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
    <title>Area Personale - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"])){
    header("Location: home.php");
    exit();
}
$connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
or die("Connessione non riuscita: " . mysqli_connect_error());
$risultati = mysqli_query($connessione, "SELECT * FROM Utenti WHERE username = '".$_SESSION["username"]."'") or die("Query non riuscita: " . mysqli_error($connessione));
$utente = $risultati->fetch_assoc();
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-user me-3"></i>Area personale</p>
<div class="w-50 mx-auto mb-5">
    <form method="post" action="modifica-dati-utente.php" class="w-100 px-3 mx-5 my-2">
        <p class="fs-1">Modifica i dati personali</p>
        <div class="row">
            <img src="Media/Utenti/<?php echo $utente["IDUtente"] ?>.png" alt="Immagine utente" class="col-sm-2 rounded-circle">
            <div class="form-floating my-3 w-75 col">
                <input class="form-control" placeholder="Immagine del profilo" type="file" accept="image/png" name="immagine" id="immagine" onchange="cambiaImmagine(this)">
                <label for="immagine">Immagine del profilo</label>
            </div>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" placeholder="Nome" type="text" name="nome" id="nome" value="<?php echo $utente["Nome"]?>" required>
            <label for="nome">Nome</label>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" placeholder="Cognome" type="text" name="cognome" id="cognome" value="<?php echo $utente["Cognome"]?>" required>
            <label for="cognome">Cognome</label>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" placeholder="Email" type="email" name="email" id="email" value="<?php echo $utente["Email"]?>" required>
            <label for="email">Email</label>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" pattern="([0-9]{10})" placeholder="Telefono" type="tel" name="telefono" id="telefono" value="<?php echo $utente["Telefono"]?>">
            <label for="telefono">Telefono</label>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" placeholder="Codice fiscale" type="text" maxlength="16" minlength="16" name="codiceFiscale" id="codiceFiscale" value="<?php echo $utente["CodiceFiscale"]?>" required>
            <label for="codiceFiscale">Codice fiscale</label>
        </div>
        <div class="form-floating my-3">
            <input class="form-control" placeholder="Data di nascita" type="date" name="dataNascita" id="dataNascita" value="<?php echo $utente["DataNascita"]?>" required>
            <label for="dataNascita">Data di nascita</label>
        </div>
        <input class="btn btn-danger w-25 mb-4" type="button" value="Elimina account" onclick="eliminaCliente()">
        <input class="float-end btn btn-primary w-25 mb-4" type="submit" value="Salva">
    </form>
    <form method="post" action="modifica-dati-utente.php" class="w-100 px-3 mx-5 my-2" onsubmit="return controllaValidita();">
        <p class="fs-1 mt-5">Modifica la password</p>
        <input name="pass" type="hidden" value="true">
        <div class="input-group w-100 my-3">
            <div class="form-floating w-50">
                <input class="form-control" placeholder="Password" type="password" name="password" id="password" required>
                <label for="password">Password</label>
                <div id="passwordErr" class="invalid-feedback">
                    Le password non corrispondono.
                </div>
            </div>
            <div class="form-floating w-50">
                <input class="form-control" placeholder="Ripeti password" type="password" id="ripetiPassword" required>
                <label for="ripetiPassword">Ripeti password</label>
            </div>
        </div>
        <div class="d-flex flex-row-reverse">
            <input class="btn btn-primary w-25" type="submit" value="Salva">
        </div>
    </form>
</div>
<script>
    function controllaValidita(){
        let p1 = document.getElementById('password')
        let p2 = document.getElementById('ripetiPassword');
        if(p1.value !== p2.value){
            $('#passwordErr').show();
            return false;
        }
        return true;
    }
    function eliminaCliente(){
        $.post({url: "modifica-dati-utente.php", data: {elimina: true}, success: (dt) => {
                location.href = "logout.php";
        }})
    }
    function cambiaImmagine(input){
        let form = document.createElement("form");
        let img = document.createElement("input");
        img.type = "hidden";
        img.name = "img";
        img.value = true;
        form.enctype = "multipart/form-data";
        form.action = "modifica-dati-utente.php";
        form.method = "post";
        form.append(input);
        form.append(img);
        form.classList.add("d-none");
        document.body.append(form);
        form.submit();
    }
</script>
</body>
</html>
