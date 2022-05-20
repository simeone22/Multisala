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
    <script src="https://reeteshghimire.com.np/wp-content/uploads/2021/05/html5-qrcode.min_.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <title>Controlla biglietti - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php
if(!isset($_SESSION["logged"], $_SESSION["username"], $_SESSION["tipoutente"]) || $_SESSION["tipoutente"] != 2){
    header("Location: home.php");
    exit();
}
?>
<?php include "navbar.php" ?>
<p class="fs-1 m-3 mb-5"><i class="fa-solid fa-ticket me-3"></i>Controlla biglietti</p>
<div class="row">
    <div class="col">
        <div style="width:500px;" id="reader"></div>
    </div>
    <div class="col" style="padding:30px;">
        <h4>SCAN RESULT</h4>
        <div id="result">Result Here</div>
    </div>
</div>
<script type="text/javascript">
    function onScanSuccess(qrCodeMessage) {
        $.get("controlla-biglietto.php?codice=" + qrCodeMessage, (dt) => {
            document.getElementById('result').innerHTML = '<span class="result">'+dt+'</span>';
        });
    }
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
    document.querySelectorAll('#reader>div:first-child>span:first-child')[0].remove()
</script>
</body>
</html>