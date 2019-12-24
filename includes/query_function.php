<?php

function insert_gebruiker($input) {
  global $db;



  $sql = "INSERT INTO gebruiker ";
  $sql .= "(sofi, voornaam, achternaam, voorletters, geboortedatum) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $input['Sofinummer']) . "',";
  $sql .= "'" . db_escape($db, $input['Voornaam']) . "',";
  $sql .= "'" . db_escape($db, $input['Achternaam']) . "',";
  $sql .= "'" . db_escape($db, $input['Voorletters']) . "',";
  $sql .= "'" . db_escape($db, $input['Geboortedatum']) . "'";
  $sql .= ")";



  $result = mysqli_query($db, $sql);
  // For INSERT statements, $result is true/false
  if($result) {
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function insert_adres($input) {
  global $db;


  $sql = "INSERT INTO adres ";
  $sql .= "(adres, postcode, woonplaats) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $input['Adres']) . "',";
  $sql .= "'" . db_escape($db, $input['Postcode']) . "',";
  $sql .= "'" . db_escape($db, $input['Woonplaats']) . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);
  // For INSERT statements, $result is true/false
  if($result) {
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function insert_bedrag($input) {
  global $db;


  /*$sql = "INSERT INTO bedrag ";
  $sql .= "(inkomen, aantal_honden) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $subject['Inkomen']) . "',";
  $sql .= "'" . db_escape($db, $subject['Aantal_honden']) . "'";
  $sql .= ")";*/


  $sql  = "INSERT INTO bedrag ";
  $sql .= "(inkomen, aantal_honden) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $input['Inkomen']) . "',";
  $sql .= "'" . db_escape($db, $input['Aantal_honden']) . "'";
  $sql .= ")";


  $result = mysqli_query($db, $sql);
  // For INSERT statements, $result is true/false
  if($result) {
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function insert_user($user) {
    global $db;



    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

function db_disconnect($connection) {
  if(isset($connection)) {
    mysqli_close($connection);
  }
}

function db_escape($connection, $string) {
  return mysqli_real_escape_string($connection, $string);
}


function find_user_by_username($username) {
  global $db;

  $sql = "SELECT * FROM admins ";
  $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $admin = mysqli_fetch_assoc($result); // find first
  mysqli_free_result($result);
  return $admin; // returns an assoc. array
}


 ?>
