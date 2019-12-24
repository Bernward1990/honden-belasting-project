<?php
session_start();
include("includes/function.php");
include("includes/database.php");
include_once("includes/auth_functions.php");
$db = db_connect();

//moet ingelogd zijn om deze pagina te bekijken
require_login();

//query die gebruikers uit de database haalt
$query_gebruiker = "SELECT * FROM gebruiker";
$result_set = mysqli_query($db, $query_gebruiker);

//query die het adres uit de database haalt
$query_adres = "SELECT * FROM adres";
$result_set_adres = mysqli_query($db, $query_adres);

//query die aantal honden uit de database haalt
$query_bedrag = "SELECT * FROM bedrag";
$result_set_bedrag = mysqli_query($db, $query_bedrag);

//associative array die het resultaat van de queries heeft.
$subject = mysqli_fetch_assoc($result_set);
$subject_adres = mysqli_fetch_assoc($result_set_adres);
$result_set_bedrag = mysqli_fetch_assoc($result_set_bedrag);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <div class="">
    <div class="">

<a class="back-link" href="home.php">&laquo; Back to home</a>
        <br>  AANSLAGFORMULIER Hondenbelasting </br><br><br>

        Hasewind, <?php echo date("d-m-y"); ?> <br><br><br>

        Bestemd voor: <br>



        <?php
        echo $subject["voorletters"] . " ";
        echo $subject["achternaam"] . "<br> ";

        ?>

        <?php echo $subject_adres['postcode'] . " " . $subject_adres['woonplaats']; ?><br><br><br>

        Geboortedatum:  <?php echo $subject["geboortedatum"]; ?><br>

        Aantal honden: <?php echo $result_set_bedrag['aantal_honden']; ?><br>
        Bedrag aanslag: <?php echo $_SESSION["bedrag"];//$belasting_bedrag; ?><br><br><br><br>

        Deze aanslag betreft de periode 1 januari <?php echo date("Y"); ?> tm 31 december <?php echo date("Y"); ?>.<br>
        Gelieve het bovenstaande bedrag binnen 4 weken over te maken op gironr. 12311322 of bankrek. nr. 51.51.13.885 ten name van:<br><br>

        Dienst gemeentelijke belastingen <br>
        Afdeling HondenbelastingSt.Bernardhof 1-5 <br>
        2233 WG Hasewind




    </div>
  </div>
</body>
</html>
<?php unset($_SESSION["bedrag"]); ?>
