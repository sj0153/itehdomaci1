<?php

require "config.php";
require "models/mediji.php";

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$result = Mediji::getAll($conn);

if (!$result) {
    echo "Nastala je greška pri izvođenju upita<br>";
    die();
}

if ($result->num_rows == 0) {
    echo "Nema medija";
    die();
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon-01.png" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        
        <title>MediaCentar</title>
    </head>

    <body>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a id="prikazi" href="#">Prikaži</a>
            <a href="#" onclick="document.getElementById('id01').style.display='block'">Dodaj</a>
            <a href="#" id="link-izmeni" onclick="document.getElementById('id02').style.display='block'">Izmeni</a>
            <a href="#" id="obrisi">Obriši</a>
            <a href="logout.php" class="five"> Odjavi se</a>

        </div>

        <div>
            <button class="w3-button w3-metro-darken w3-xlarge" onclick="openNav()" style="margin: 40px 40px 40px 40px;">☰</button>
            <div>
                <div class="jumbotron">
                    <h1>Dobrodošao, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
                    <br>
                    <h2>Ispod se nalazi tabela medija koji su podržali ovaj projekat</h2>
                </div>
            </div>
        </div>


        <div id="tabela" class="container">
            <div class="row">
                <input class="w3-input w3-border w3-padding" type="text" placeholder="Pretraga" id="myInput" onkeyup="pretraga()">
                <br>
                <div class="col-md-12">
                </div>
                <div id="no-more-tables">
                    <table class="w3-table-all w3-large w3-metro-darken" style="background-color: white;">
                        <thead class="cf">
                            <tr>
                                <th>ID</th>
                                <th>Naziv</th>
                                <th class="numeric">Zemlja</th>
                                <th class="numeric">Karakter medija</th>
                                <th class="numeric">Datum osnivanja medija</th>
                                <th class="numeric">Izaberi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($red = $result->fetch_array()) {
                            ?>
                                <tr>
                                    <td><?php echo $red["id"] ?></td>
                                    <td><?php echo $red["naziv"] ?></td>
                                    <td><?php echo $red["zemlja"] ?></td>
                                    <td><?php echo $red["karakter_medija"] ?></td>
                                    <td><?php echo $red["god_osnivanja"] ?></td>
                                    <td>
                                        <label class="custom-radio-btn">
                                            <input type="radio" name="checked-donut" value=<?php echo $red["id"] ?>>
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>

                                </tr>
                        <?php
                            }
                        } ?>
                        </tbody>
                    </table>
                    <br>
                    <form action="excel.php" method="post" style="text-align: center">
                        <input type="submit" name="izvestaj" class="w3-button w3-hover-white w3-right" style="color:red; " value="Preuzmi tabelu" />
                    </form>
                </div>
            </div>

        </div>

        <div id="id01" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-metro-darken">
                    <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <h2 style="text-align:center">Dodaj</h2>
                </header>
                <div class="w3-container">
                    <form action="#" method="post" id="dodajForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" style="border: 2px solid black" name="naziv" class="form-control" placeholder="Naziv medija *" />
                                </div>
                                <div class="form-group">
                                    <input type="text" style="border: 2px solid black" name="zemlja" class="form-control" placeholder="Zemlja osnivanja medija *" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="date" style="border: 2px solid black" name="god_osnivanja" class="form-control" placeholder="Datum osnivanja medija *" value="" />
                                </div>
                                <div class="form-group">
                                    <button id="btnAdd" type="submit" class="btn btn-success btn-block" style="background-color: black; border: 2px solid black;"><i class="glyphicon glyphicon-plus"></i> Dodaj Medij
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea name="karakter_medija" class="form-control" placeholder="Karakter medija *" style="width: 100%; height: 150px; border: 2px solid black;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="id02" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-metro-darken">
                    <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <h2 style="text-align:center">Izmeni</h2>
                </header>
                <div class="w3-container">
                    <form action="#" method="post" id="Izmeni">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="nazivMed" type="text" style="border: 2px solid black" name="nazivM" class="form-control" placeholder="Naziv medija *" />
                                </div>
                                <div class="form-group">
                                    <input id="zemljaMed" type="text" style="border: 2px solid black" name="zemljaM" class="form-control" placeholder="Zemlja osnivanja medija *" value="" />
                                </div>
                                <div class="form-group">
                                    <input id="godOsnMed" type="date" style="border: 2px solid black" name="god_osnivanjaM" class="form-control" placeholder="Datum osnivanja medija *" value="" />
                                </div>
                                <div class="form-group">
                                    <button id="btnChange" type="submit" class="btn btn-success btn-block" style="background-color: black; border: 2px solid black;"><i class="glyphicon glyphicon-plus"></i> Izmeni Medij
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea id="karakterMed" name="karakter_medija" class="form-control" placeholder="Karakter medija *" style="width: 100%; height: 150px; border: 2px solid black;"></textarea>
                                </div>
                                <div class="form-group">
                                    <input id="id" type="text" style="border: 2px solid black" name="idM" class="form-control" placeholder="Id medija *" value="" readonly />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="js/main.js"></script>

    </body>

    </html>