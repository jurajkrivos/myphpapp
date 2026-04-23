<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrovať sa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">myPHPapp</a>
            <form class="d-flex" role="login">
            <a class="btn btn-outline-primary me-2">Prihlásiť sa</a>
            <a class="btn btn-primary">Registrovať</a>
            </form>
        </div>
    </nav>


<form class="row g-3 m-5 p-5 bg-body-tertiary rounded" method="post">
  <div class="col-md-6">
    <label for="ziskajEmail" class="form-label">Email</label>
    <input type="email" class="form-control" id="ziskajEmail" required>
  </div>
  <div class="col-md-6">
    <label for="ziskajHeslo" class="form-label">Heslo</label>
    <input type="password" class="form-control" id="ziskajHeslo" required>
  </div>
  <div class="col-12">
    <label for="ziskajAdresa" class="form-label">Adresa</label>
    <input type="text" class="form-control" id="ziskajAdresa" required>
  </div>
  <div class="col-md-6">
    <label for="ziskajMesto" class="form-label">Mesto</label>
    <input type="text" class="form-control" id="ziskajMesto" required>
  </div>
  <div class="col-md-4">
    <label for="ziskajStat" class="form-label">Štát</label>
    <input type="text" class="form-control" id="ziskajStat" required>
  </div>
  <div class="col-md-2">
    <label for="ziskajPSC" class="form-label">PSČ</label>
    <input type="text" class="form-control" id="ziskajPSC" required>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck" required>
      <label class="form-check-label" for="gridCheck">
        Súhlasím so spracovaním osobných údajov
      </label>
    </div>
  </div>
  <div class="col-12">
    <button type="register" class="btn btn-primary">Registrovať sa</button>
  </div>
</form>

<?php

    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "root";

    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword);

    if ($conn->connect_error) {
        die("Nepodarilo sa pripojiť k DB") . $conn->connect_error();
    }
    else{
        echo "HOORAY! Pripojené k DB";
    };


    if (isset($_POST["register"])) {
      $email = $_POST['ziskajEmail'];
      $heslo = $_POST['ziskajHeslo'];
      $heslo_hash = password_hash($heslo, PASSWORD_DEFAULT);
      $adresa = $_POST['ziskajAdresa'];
      $mesto = $_POST['ziskajMesto'];
      $stat = $_POST['ziskajStat'];
      $psc = $_POST['ziskajPSC'];

      $sql = 
        "INSERT INTO pouzivatel (email, heslo_hash, adresa, mesto, stat, psc)
        VALUES $email, $heslo_hash, $adresa, $mesto, $stat, $psc";
      }
?>
</body>
</html>