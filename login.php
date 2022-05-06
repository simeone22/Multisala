<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Multisala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
    <form class="position-absolute top-50 start-50 translate-middle border border-3 px-3 py-4 rounded-3 w-25 h-50" action="verifica.php" method="post">
        <h1 class="mb-4 text-center py-1">Login</h1>
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
        <p><input type="checkbox" name="ricordami"> Ricordami (Per 30 giorni).</p>
        <p class="mb-0">Non hai un account? <a href="registrazione.php">Registrati</a>.</p>
        <p class="mb-3">Dimenticato la password? <a class="link-primary" onclick="$('#reimpostaPassword').modal('show');" style="cursor: pointer">Recupera</a>.</p>
        <input type="submit" value="Login" class="btn btn-primary mb-3 text-center w-100 py-2">
    </form>
    <div class="modal" tabindex="-1" id="reimpostaPassword">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reimposta la password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="password-reset.php" method="post">
                        <div class="form-floating mb-3">
                            <input name="username" id="usernamem" type="text" placeholder="username" class="form-control" required="">
                            <label for="usernamem">Username</label>
                            <div class="invalid-feedback">Lo username non può essere vuoto.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="this.parentElement.parentElement.getElementsByTagName('form')[0].reset();">Annulla</button>
                    <button type="button" class="btn btn-primary" onclick="checkForm(this.parentElement.parentElement.getElementsByTagName('form')[0])">Reset</button>
                </div>
            </div>
        </div>
    </div>
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
    </script>
</body>
</html>

