<?php
function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function has_valid_email_format($value) {
  $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
  return preg_match($email_regex, $value) === 1;
}

function has_length_greater_than($value, $min) {
  $length = strlen($value);
  return $length > $min;
}

function has_length_less_than($value, $max) {
  $length = strlen($value);
  return $length < $max;
}


function has_length($value, $options) {
  if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
    return false;
  } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
    return false;
  } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
    return false;
  } else {
    return true;
  }
}

function h($string="") {
  return htmlspecialchars($string);
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

//specific validate functions
function has_length_exactly($value, $exact) {
  $length = strlen($value);
  return $length == $exact;
}

function is_blank($value) {
  return !isset($value) || trim($value) === '';
}

function calculate_age($birthDateInput){
  //explode the date to get month, day and year
  $birthDate = explode("/", $birthDateInput);

  @$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
  ? ((date("Y") - $birthDate[0]) - 1)
  : (date("Y") - $birthDate[0]));

  return $age;
}

function belasting_berekenen($input_inkomen, $input_honden){
  $belasting;
  if ($input_inkomen <= 12000) {
    if ($input_honden <= 1) {
      $belasting=   0;
    } elseif ($input_honden == 2) {
      $belasting= ($input_honden * 100);
    } elseif ($input_honden <= "5") {
      $belasting= ($input_honden * 200);
    }elseif ($input_honden > 5) {
      $belasting= ($input_honden * 400);
    }
  }elseif ($input_inkomen <= 24000) {
    if ($input_honden <= 1) {
      $belasting= "100";
    } elseif ($input_honden == 2) {
      $belasting= ($input_honden * 200);
    } elseif ($input_honden <= 5) {
      $belasting= ($input_honden * 400);
    }elseif ($input_honden > 5) {
      $belasting= ($input_honden * 500);
    }
  }elseif ($input_inkomen > 24000) {
    if ($input_honden <= 1) {
      $belasting= "200";
    } elseif ($input_honden == 2) {
      $belasting= ($input_honden * 400);
    } elseif ($input_honden <= 5) {
      $belasting= ($input_honden * 500);
    }elseif ($input_honden > 5) {
      $belasting= ($input_honden * 600);
    }
  }
  return $belasting;
}

//handle form input functions
function handle_form_gebruiker($input){
  $input = [];
  $input['Sofinummer'] = isset ($_POST['Sofinummer']) ? $_POST['Sofinummer'] : '';
  $input['Voornaam'] = isset ($_POST['Voornaam']) ? $_POST['Voornaam'] : '';
  $input['Achternaam'] = isset ($_POST['Achternaam']) ? $_POST['Achternaam'] : '';
  $input['Voorletters'] = isset ($_POST['Voorletters']) ? $_POST['Voorletters'] : '';
  $input['Geboortedatum'] = isset ($_POST['Geboortedatum']) ? $_POST['Geboortedatum'] : '';

  return $input;
}

function handle_form_adres($input){
  $input = [];
  $input['Adres'] = isset ($_POST['Adres']) ? $_POST['Adres'] : '';
  $input['Postcode'] = isset ($_POST['Postcode']) ? $_POST['Postcode'] : '';
  $input['Woonplaats'] = isset ($_POST['Woonplaats']) ? $_POST['Woonplaats'] : '';
  $input['Voorvoegsels'] = isset ($_POST['Voorvoegsels']) ? $_POST['Voorvoegsels'] : '';

  return $input;
}

function handle_form_bedrag($input){
  $input = [];
  $input['Inkomen'] = isset ($_POST['Inkomen']) ? $_POST['Inkomen'] : '';
  $input['Aantal_honden'] = isset ($_POST['Aantal_honden']) ? $_POST['Aantal_honden'] : '';
  return $input;
}

//validate form input function
function validate_gebruiker_input($input){
  $errors = [];

  // Sofinummer validatie

  if(is_blank($input['Sofinummer'])) {
    $errors['sofinummer']  = "Invullen van sofinummer is verplicht.";
  }elseif(!has_length_exactly($input['Sofinummer'], 9)) {
    $errors['sofinummer'] = "Sofinummer moet uit 9 cijfers bestaan.";
  }elseif(!preg_match('/^[0-9]*$/',$input['Sofinummer'])){
    $errors['sofinummer'] = "Sofinummer mag alleen uit cijfers bestaan.";
  }

  // Voornaam validatie
  if(is_blank($input['Voornaam'])) {
    $errors['Voornaam']  = "Invullen van Voornaam is verplicht.";
  }elseif(!preg_match("/^[a-zA-Z ]*$/",$input['Voornaam'])){
    $errors['Voornaam']  = "Voornaam mag alleen bestaan uit letters.";
  }


  // Achternaam validatie
  if(is_blank($input['Achternaam'])) {
    $errors['Achternaam']  = "Invullen van Achternaam is verplicht.";
  }elseif(!preg_match("/^[a-zA-Z ]*$/",$input['Achternaam'])){
    $errors['Achternaam']  = "Achternaam mag alleen bestaan uit letters.";
  }

  // Voorletter validatie
  if(is_blank($input['Voorletters'])) {
    $errors['Voorletters']  = "Invullen van Voorletters is verplicht.";
  }elseif(!preg_match("/^[a-zA-Z ]*$/",$input['Voorletters'])){
    $errors['Voorletters']  = "Voorletters mag alleen bestaan uit letters.";
  }

  // geboortedatum validatie
  $age=calculate_age($input['Geboortedatum']);
  echo $age;
  if(is_blank($input['Geboortedatum'])) {
    $errors['Geboortedatum']  = "Invullen van Geboortedatum is verplicht.";
  }elseif (@$age <= 17) {
    // code...
    $errors['Geboortedatum'] = "Je moet 18 jaar of ouder zijn";
  }
  return $errors ;
}

function validate_adres_input($input){
  $errors = [];

  // Adres validatie
  if(is_blank($input['Adres'])) {
    $errors['Adres']  = "Adres verplicht vullen.";
  }elseif(!preg_match("/^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$/i",$input['Adres'])){
    $errors['Adres']  = "Eerst straatnaam(mag niet numeriek zijn), dan huisnummer.";
  }

  // Postcode validatie
  if(is_blank($input['Postcode'])) {
    $errors['Postcode']  = "Invullen van Postcode is verplicht.";
  }elseif(!preg_match("/^[1-9][0-9]{3}[\s]?[A-Za-z]{2}$/i",$input['Postcode'])){
    $errors['Postcode']  = "Postcode moet uit vier cijfer en twee letters bestaan.";
  }

  //woonplaats validatie
  if(is_blank($input['Woonplaats'])) {
    $errors['Woonplaats']  = "Invullen van Woonplaats is verplicht.";
  }elseif(!preg_match("/^[a-zA-Z ]*$/",$input['Woonplaats'])){
    $errors['Woonplaats']  = "Woonplaats mag alleen bestaan uit letters.";
  }
  return $errors;
}

function validate_bedrag_input($input){
  $errors = [];

  // inkomen valideren
  if(is_blank($input['Inkomen'])) {
    $errors['Inkomen']  = "Invullen van Inkomen is verplicht.";
  }elseif ($input['Inkomen'] <= 0) {
    $errors['Inkomen']  = "Inkomen moet positief zijn.";
  }

  // aantal honden
  if(is_blank($input['Aantal_honden'])) {
    $errors['Aantal_honden']  = "Invullen van Aantal honden is verplicht.";
  }elseif ($input['Aantal_honden'] <= 0) {
    $errors['Aantal_honden']  = "Moet minimaal 1 hond invullen.";
  }
  return $errors;
}





 ?>
