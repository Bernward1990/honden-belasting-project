<?php session_start(); ?>
<?php include_once("includes/function.php"); ?>
<?php include_once("includes/database.php") ?>
<?php include_once("includes/query_function.php") ?>
<?php include_once("includes/auth_functions.php"); ?>
<?php $db = db_connect();?>

<?php
//moet ingelogd zijn om deze pagina te bekijken
require_login();

if(is_post_request()) {

  // Handelt de form values die gestuurd wordt door formulier.php
  if(!empty($_POST) ){
    $form_input_gebruiker = handle_form_gebruiker($_POST);
    $form_input_adres = handle_form_adres($_POST);
    $form_input_bedrag = handle_form_bedrag($_POST);

    //valideert de form values
    $errors_gebruiker = validate_gebruiker_input($form_input_gebruiker);
    $errors_adres = validate_adres_input($form_input_adres);
    $errors_bedrag = validate_bedrag_input($form_input_bedrag);




    // Als er geen errors zijn, dan wordt de form values in de database opgeslagen
    if (empty($errors_gebruiker && $errors_adres && $errors_bedrag)) {
      //berekend het bedrag die betaald moet worden
      $_SESSION["bedrag"] = belasting_berekenen($form_input_bedrag['Inkomen'], $form_input_bedrag['Aantal_honden']);

      insert_gebruiker($form_input_gebruiker);
      insert_adres($form_input_adres);
      insert_bedrag($form_input_bedrag);

      header("Location: aanslag.php");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <a class="back-link" href="home.php">Home</a>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <ul style="list-style-type:disc">
      <!-- Sofinummer-->
      <li>  Sofinummer	  : <input type="text" placeholder="9 cijfers" name="Sofinummer" value="<?php if(!empty($form_input)){echo $form_input['Sofinummer'];} ?>"></li>
      <span class="error">* <?php if (isset($errors_gebruiker['sofinummer'])){echo $errors_gebruiker['sofinummer'];} echo "";?></span>

      <!-- Naam-->
      <li>   Voornaam	  : <input type="text" name="Voornaam" value="<?php if(!empty($form_input)){echo $form_input['Voornaam'];}?>"></li>
      <span class="error">* <?php if (isset($errors_gebruiker['Voornaam'])){echo $errors_gebruiker['Voornaam'];} echo "";?></span>

      <li>   Achternaam	  : <input type="text" name="Achternaam" value="<?php if(!empty($form_input)){echo $form_input['Achternaam'];}?>"></li>
      <span class="error">* <?php if (isset($errors_gebruiker['Achternaam'])){echo $errors_gebruiker['Achternaam'];} echo "";?></span>

      <!-- Voorletters-->
      <li>   Voorletters	  : <input type="text" name="Voorletters" value="<?php if(!empty($form_input)){echo $form_input['Voorletters'];}?>"></li>
      <span class="error">* <?php if (isset($errors_gebruiker['Voorletters'])){echo $errors_gebruiker['Voorletters'];} echo "";?></span>

      <!-- Adres-->
      <li>   Adres	  : <input type="text" placeholder="straat-huisnr"name="Adres" value="<?php  if(!empty($form_input)){echo $form_input['Adres'];}?>"></li>
      <span class="error">* <?php if (isset($errors_adres['Adres'])){echo $errors_adres['Adres'];} echo "";?></span>

      <!-- Postcode-->
      <li>   Postcode	  : <input type="text" name="Postcode" value="<?php if(!empty($form_input)){echo $form_input['Postcode'];}?>"></li>
      <span class="error">* <?php if (isset($errors_adres['Postcode'])){echo $errors_adres['Postcode'];} echo "";?></span>

      <!-- Inkomen-->
      <li>   Inkomen	  : <input type="text" name="Inkomen" value="<?php if(!empty($form_input)){echo $form_input['Inkomen'];}?>"></li>
      <span class="error">* <?php if (isset($errors_bedrag['Inkomen'])){echo $errors_bedrag['Inkomen'];} echo "";?></span>

      <!-- Aantal honden-->
      <li>   Aantal honden	  : <input type="text" name="Aantal_honden" value="<?php if(!empty($form_input)){echo $form_input['Aantal_honden'];}?>"></li>
      <span class="error">* <?php if (isset($errors_bedrag['Aantal_honden'])){echo $errors_bedrag['Aantal_honden'];} echo "";?></span>

      <!-- Voorvoegsels; is optioneel -->
      <li>   Voorvoegsels	  : <input type="text" name="Voorvoegsels" value="<?php  if(!empty($form_input)){echo $form_input['Voorvoegsels'];}?>"></li>

      <!-- Woonplaats-->
      <li>   Woonplaats	  : <input type="text" name="Woonplaats" value="<?php if(!empty($form_input)){echo $form_input['Woonplaats'];}?>"></li>
      <span class="error">* <?php if (isset($errors_adres['Woonplaats'])){echo $errors_adres['Woonplaats'];} echo "";?></span>

      <!-- Geboortedatum-->
      <li>   Geboortedatum	  : <input type="text" placeholder="yy-mm-dd"name="Geboortedatum" value="<?php if(!empty($form_input)){echo $form_input['Geboortedatum'];}?>"></li>
      <span class="error">* <?php if (isset($errors_gebruiker['Geboortedatum'])){echo $errors_gebruiker['Geboortedatum'];} echo "";?></span>



    </ul>
    <input type="submit" value="submit">
  </form>
</body>
</html>
