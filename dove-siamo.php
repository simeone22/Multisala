<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="icon" href="Media/Immagini/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <title>Dove siamo - Multisala</title>
</head>
<body class="position-relative min-h-100">
<?php include "toasts.php";?>
<?php include "navbar.php" ?>
<div class="container min-h-85">
    <i class="fa-solid fa-circle-location-arrow"><h3 class="page-heading mt-5 mb-5"> Dove siamo</h3></i>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="m18-content-content">
                <p style="text-align: center">
                    <strong style="margin: 0px; padding: 0px; border: 0px; outline: 0px;">Multisala Verbania</strong>
                    <br>
                    <span style="display: inline; float: none;">Via S. Bernardino, 47</span>
                    <br>
                    <span style="display: inline; float: none;">28922 Verbania</span>
                </p>
                <div id="map" class="w-600 vh-450"></div>
                <script>
                    function sample() {
                        let ll = new google.maps.LatLng(45.93068854564178, 8.571895042620316);
                        var m1 = {
                            center: ll,
                            zoom: 18,
                            streetViewControl: false,
                            mapTypeControl: false,
                            fullscreenControl: false,
                            gestureHandling: "none"
                        }
                        var m2 = new google.maps.Map(document.getElementById("map"), m1);
                        m2.setMapTypeId(google.maps.MapTypeId.SATELLITE);
                        m2.setStreetView(null);
                        let infoW = new google.maps.InfoWindow({
                            content: "<h4>Multisala</h4><p>Via S. Bernardino, 47, 28922 Verbania VB</p>"
                        });
                        let marker = new google.maps.Marker({
                            position: ll,
                            title: "Siamo qui!",
                            label: "Noi"
                        });
                        marker.setMap(m2);
                        infoW.open({
                            anchor: marker,
                            m2,
                            shouldFocus: false
                        });
                        marker.addListener("click", () => {
                            infoW.open({
                                anchor: marker,
                                m2,
                                shouldFocus: false
                            })
                        });
                    }
                </script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARj9nBTsaNu68PoKv-LFkdbA_Y4FgYFtc&callback=sample"></script>
            </div>
        </div>
    </div>
</div>
</body>
</html>
