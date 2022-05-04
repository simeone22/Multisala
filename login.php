<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Gestione eventi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="home.php" class="btn btn-outline-dark m-3"><i class="bi bi-arrow-left-circle-fill me-2"></i>Torna alla Home</a>
    <form class="position-absolute top-50 start-50 translate-middle border border-3 form-h-50 px-3 py-4 rounded-3 form-responsive-25" action="verifica.php" method="post">
    <h1 class="mb-4 text-center py-1">Login</h1>
    <div class="form-floating mb-3">
        <select name="tipoutente" class="form-select form-select mb-3" id="tipoutente" onchange="changeUsername()">
            <option value="1" id="studente" selected>Studente</option>
            <option value="2" id="scuola">Scuola</option>
            <option value="3" id="ente">Ente</option>
            <option value="4" id="admin">Amministratore</option>
        </select>
        <label for="tipoutente">Tipologia utente</label>
    </div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="username" placeholder="Username" id="username" required>
        <label for="username">Username</label>
    </div>
    <div class="input-group my-3 row g-1">
        <div class="form-floating col-md-11 m-0">
            <input id="password" type="password" name="password" class="form-control" placeholder="password" required>
            <label for="password">Password</label>
        </div>
        <div class="input-group-append col-md-1 pb-0 m-0">
            <span id="showhide" class="input-group-text d-flex justify-content-center h-100"><i class="bi bi-eye-fill"></i></span>
        </div>
    </div>
    <input type="submit" value="Login" class="btn btn-primary mb-3 text-center w-100 py-2">
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
    function changeUsername(){
        if(document.getElementById("tipoutente").value == 2){
            document.getElementById("username").parentElement.children[1].innerText = "Codice meccanografico";
        }
        else{
            document.getElementById("username").parentElement.children[1].innerText = "Username";
        }
    }
        </script>
    <?php
        session_start();
        if (isset($_SESSION["error"])){
            echo "<div class='toast align-items-center text-white bg-danger border-0 position-absolute top-0 end-0 m-2' role='alert' aria-live='assertive' aria-atomic='true' id='errsave'>";
            echo "<div class='d-flex'>";
            echo "<div class='toast-body'>";
            echo $_SESSION["error"];
            echo "</div>";
            echo "<button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>";
            echo "</div>";
            echo "</div>";
            echo "<script>document.body.onload = () => $('.toast').toast('show')</script>";
            unset($_SESSION["error"]);
        }
    ?>
    </body>
</html>

