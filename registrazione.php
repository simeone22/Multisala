<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrazione - Multisala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
</head>
<body>
<?php include "toasts.php";?>
<?php
if(isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"])){
    header("Location: home.php");
    exit();
}
?>
<a href="home.php" class="btn btn-outline-dark m-3"><i class="bi bi-arrow-left-circle-fill me-2"></i>Torna alla Home</a>
<form class="position-absolute top-50 start-50 translate-middle border border-3 vw-50 px-3 py-4 rounded-3 h-83" action="registra.php" method="post" id="studente">
    <h1 class="mb-4 text-center py-1">Registrazione</h1>
    <div>
    <input type="hidden" value="1" name="tipoutente"/>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="username" placeholder="Username" id="username" required>
        <label for="username">Username</label>
    </div>
    <div class="input-group row g-1 mb-3">
        <div class="form-floating col-md-11">
            <input id="password" type="password" name="password" class="form-control" placeholder="password" required>
            <label for="password">Password</label>
        </div>
        <div class="input-group-append col-md-1 pb-0">
            <span id="showhide" class="input-group-text d-flex justify-content-center h-100"><i class="bi bi-eye-fill"></i></span>
        </div>
    </div>
    <div class="input-group row g-3 mb-3">
        <div class="form-floating col-sm">
            <input type="text" class="form-control" name="nome" placeholder="nome" id="nome" required>
            <label for="nome">Nome</label>
        </div>
        <div class="form-floating col-sm">
            <input type="text" class="form-control" name="cognome" placeholder="cognome" id="cognome" required>
            <label for="cognome">Cognome</label>
        </div>
    </div>
    <div class="input-group row g-3 mb-3">
        <div class="form-floating col-sm">
            <input type="text" maxlength="16" minlength="16" class="form-control" name="codiceFiscale" placeholder="codicefiscale" id="codicefiscale" required>
            <label for="codicefiscale">Codice Fiscale</label>
        </div>
        <div class="form-floating col-sm">
            <input type="date" class="form-control" name="dataNascita" placeholder="Data di nascita" id="dataNascita" required>
            <label for="dataNascita">Data di nascita</label>
        </div>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control" name="email" placeholder="email" id="email" required>
        <label for="email">Email</label>
    </div>
    <div class="form-floating mb-3">
        <input type="tel" pattern="([0-9]{10})" class="form-control" name="telefono" placeholder="telefono" id="telefono">
        <label for="telefono">Telefono</label>
    </div>
    <p class="mb-3">Hai già un account? <a href="login.php">Login</a>.</p>
    <input type="submit" value="Registrazione" class="btn btn-primary mb-3 text-center w-100 py-2">
    </div>
</form>
<script>
    $('#showhide').on('click', function (){
        let pass = document.getElementById("password");
        let sh = document.getElementById('showhide').children[0];
        if(pass.type == 'text') {
            pass.type = 'password';
            sh.classList.remove("bi-eye-slash-fill");
            sh.classList.add("bi-eye-fill");
        }
        else {
            pass.type = 'text';
            sh.classList.remove("bi-eye-fill");
            sh.classList.add("bi-eye-slash-fill");
        }
    });
</script>
</body>
</html>
