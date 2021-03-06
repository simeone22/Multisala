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
    <title>Film - Multisala</title>
</head>
<body class="d-flex flex-column h-100">
<?php include "toasts.php";?>
<?php include "navbar.php" ?>

<h2 class="page-heading mt-5 mb-5" style="padding-left: 20px;"><i class="fa-solid fa-films"></i> Film </h2>
<div class="m-auto input-group w-75 justify-content-center mb-5 mt-2">
    <div class="form-floating w-25">
        <select id="RAttore" class="form-control">
            <option value="%" <?php if(!isset($_GET["attore"])) echo "selected"?>>Tutti</option>
            <?php
            $query = "SELECT * FROM Attori";
            $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
            $result = $connessione->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['IDAttore'] . "'";
                if(isset($_GET["attore"]) && $_GET["attore"] == $row['IDAttore']) echo "selected";
                echo ">" . $row['Nome'] . " " . $row['Cognome'] . "</option>";
            }
            ?>
        </select>
        <label class="form-label" for="RAttore">Attore</label>
    </div>
    <div class="form-floating w-25">
        <select id="RCategoria" class="form-control">
            <option value="%" <?php if(!isset($_GET["categoria"])) echo "selected"?>>Tutti</option>
            <?php
            $query = "SELECT * FROM Categorie";
            $connessione = mysqli_connect("localhost", "Lettiero", "Lettiero", "Multisala_Baroni_Lettiero", 12322);
            $result = $connessione->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['IDCategoria'] . "'";
                if(isset($_GET["categoria"]) && $_GET["categoria"] == $row['IDCategoria']) echo "selected";
                echo ">" . $row['NomeCategoria'] . "</option>";
            }
            ?>
        </select>
        <label class="form-label" for="RCategoria">Categoria</label>
    </div>
    <div class="form-floating" style="width: 10%">
        <input type="number" min="1" id="durata" class="form-control" placeholder="Durata" <?php if(isset($_GET["durata"])) echo "value='" . $_GET["durata"] . "'"?>>
        <label class="form-label" for="durata">Durata</label>
    </div>
    <div class="form-floating w-25">
        <input autocomplete="off" type="search" id="ricerca" class="form-control" placeholder="Nome del film" <?php if(isset($_GET["nome"])) echo "value='" . $_GET["nome"] . "'"?>>
        <label class="form-label" for="ricerca">Nome del film</label>
    </div>
    <button type="button" class="btn btn-dark" id="searchButton" onclick="cercaFilm()">
        <i class="fa-solid fa-search"></i>
    </button>
</div>
  <div class="container text-center" style="max-width: 200%; margin-top: 20px;">
      <?php
      $sql = "SELECT * FROM (((Film INNER JOIN AttoriFilm ON Film.IDFilm = AttoriFilm.idFFilm) INNER JOIN Attori ON AttoriFilm.idFAttore = Attori.IDAttore) INNER JOIN CategorieFilm CF ON CF.idFFilm = Film.IDFilm) LEFT OUTER JOIN Proiezioni ON Proiezioni.idFFilm = Film.IDFilm WHERE (Privata = 0  OR Privata IS NULL)";

      if(isset($_GET["nome"])){
          $sql .= " AND NomeFilm LIKE '%".$_GET["nome"]."%'";
      }
      if(isset($_GET["attore"])){
          $sql .= " AND Attori.IDAttore = ".$_GET["attore"];
      }
      if(isset($_GET["categoria"])){
          $sql .= " AND CF.idFCategoria = ".$_GET["categoria"];
      }
      if(isset($_GET["durata"])){
          $sql .= " AND Durata = ".$_GET["durata"];
      }
      $sql .= " GROUP BY IDFilm";
      $connessione = mysqli_connect("localhost", "Baroni", "Baroni", "Multisala_Baroni_Lettiero", 12322)
      or die("Errore di connessione al database");
      $result = $connessione->query($sql);
      if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
       $row["IDFilm"];
      ?>
      <div aria-labelledby="<?php echo $row["IDFilm"];?>" id="<?php echo $row["IDFilm"];?>"/>
          <div class="card card-body" data-parent="<?php echo $row["IDFilm"];?>" style="position: relative; height: 620px;">
             <div class="container align-middle" style="padding-top: 50px;">
                 <div class="row d-flex">
                     <div class="col-3 d-flex justify-content-center">
                         <a href='informazioni.php?id=<?php echo $row["IDFilm"]; ?>'>
                             <img src="<?php echo "Media/Film/". $row["IDFilm"]?>.png" alt="..." style="height: 500px; width: 350px;">
                         </a>
                     </div>
                     <div class="col-7 text-start fs-6 mt-3" style="padding-left: 100px;">
                             <h2 class="visible text-start" style="padding-bottom: 3px;">
                                 <strong><?php echo $row["NomeFilm"] ?></strong>
                             </h2>
                             <strong>Durata</strong>
                             <p><?php echo $row["Durata"]?> min </p>
                             <strong>Attori</strong>
                             <p><?php
                                 $query = "SELECT Nome, Cognome FROM Attori INNER JOIN AttoriFilm ON Attori.IDAttore = AttoriFilm.idFAttore WHERE idFFilm = ". $row["IDFilm"];
                                 $risultato = $connessione->query($query);
                                 if($risultato->num_rows > 0){
                                     $attori = [];
                                     while($r = $risultato->fetch_assoc()){
                                         $attori[] = $r["Nome"] . " " . $r["Cognome"];
                                     }
                                     echo implode(", ", $attori);
                                 }?></p>
                             <div id="example" class="accordion-item">
                                 <p id="headingOne" class="accordion-header">
                                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#d-<?php echo $row["IDFilm"]; ?>" aria-expanded="false" aria-controls="d-<?php echo $row["IDFilm"]; ?>">
                                        <strong>Trama</strong>
                                     </button>
                                 </p>
                                 <div id="d-<?php echo $row["IDFilm"]; ?>" class="accordion-collapse overflow-auto h-25 collapse" aria-labelledby="headingOne" data-bs-parent="#example">
                                     <div class="accordion-body">
                                         <p>
                                             <?php
                                             if(strlen($row["Trama"]) > 478){
                                                 $row["Trama"] = substr($row["Trama"], 0, 478) . "...";
                                                 echo $row["Trama"];
                                             }
                                             else {
                                                 echo $row["Trama"];
                                             }
                                             ?>
                                         </p>
                                     </div>
                                 </div>
                             </div>
                     </div>
                 </div>
             </div>
          </div>
      </div>
      <?php
      }
      }?>
  </div>
<script>
    function cercaFilm(){
        var nome = document.getElementById("ricerca").value;
        var categoria = document.getElementById("RCategoria").value;
        var attore = document.getElementById("RAttore").value;
        var durata = document.getElementById("durata").value;
        var url = "film.php?";
        if(nome != ""){
            url += "nome=" + nome + "&";
        }
        if(categoria != "%"){
            url += "categoria=" + categoria + "&";
        }
        if(attore != "%"){
            url += "attore=" + attore + "&";
        }
        if(durata != ""){
            url += "durata=" + durata + "&";
        }
        url = url.substring(0, url.length - 1);
        window.location.href = url;
    }
</script>
</body>
</html>
