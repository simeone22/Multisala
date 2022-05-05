<?php
session_start();
session_destroy();
setcookie("username", "", 0, "/html/Lettiero/Esercizio%2029.04.2022/");
setcookie("token", "", 0, "/html/Lettiero/Esercizio%2029.04.2022/");
header('location: home.php');