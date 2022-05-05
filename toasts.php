<?php
include "checkCookie.php";
if (isset($_SESSION["success"])){
    echo "<div class='toast align-items-center text-white bg-success border-0 position-absolute top-0 end-0 m-2' role='alert' aria-live='assertive' aria-atomic='true' id='errsave'>";
    echo "<div class='d-flex'>";
    echo "<div class='toast-body'>";
    echo $_SESSION["success"];
    echo "</div>";
    echo "<button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>";
    echo "</div>";
    echo "</div>";
    echo "<script>document.body.onload = () => $('.toast').toast('show')</script>";
    unset($_SESSION["success"]);
}
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