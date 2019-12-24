<?php
function require_login() {
  if(!is_logged_in()) {
    redirect_to('login.php');
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

//Performs all actions necessary to log out an user
function log_in_user($user) {
  // Renerating the ID protects the admin from session fixation.
  session_regenerate_id();
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['last_login'] = time();
  $_SESSION['username'] = $user['username'];


  return true;
}

// Performs all actions necessary to log out an user
function log_out_user() {
  unset($_SESSION['user_id']);
  unset($_SESSION['last_login']);
  unset($_SESSION['username']);
  // session_destroy(); // optional: destroys the whole session
  return true;
}

function has_unique_username($username, $current_id="0") {
  global $db;

  $sql = "SELECT * FROM admins ";
  $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
  $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

  $result = mysqli_query($db, $sql);
  $admin_count = mysqli_num_rows($result);
  mysqli_free_result($result);

  return $admin_count === 0;
}

function validate_user($user, $options=[]) {

  $password_required =  isset ($options['password_required']) ? $options['password_required'] : true;

  if(is_blank($user['first_name'])) {
    $errors[] = "First name cannot be blank.";
  } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
    $errors[] = "First name must be between 2 and 255 characters.";
  }

  if(is_blank($user['last_name'])) {
    $errors[] = "Last name cannot be blank.";
  } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
    $errors[] = "Last name must be between 2 and 255 characters.";
  }

  if(is_blank($user['email'])) {
    $errors[] = "Email cannot be blank.";
  } elseif (!has_length($user['email'], array('max' => 255))) {
    $errors[] = "Last name must be less than 255 characters.";
  } elseif (!has_valid_email_format($user['email'])) {
    $errors[] = "Email must be a valid format.";
  }

  if(is_blank($user['username'])) {
    $errors[] = "Username cannot be blank.";
  } elseif (!has_length($user['username'], array('min' => 8, 'max' => 255))) {
    $errors[] = "Username must be between 8 and 255 characters.";
  } elseif (!has_unique_username($user['username'], isset ($user['id']) ? $user['id'] : 0))  {
    $errors[] = "Username not allowed. Try another.";
  }

  if($password_required) {
    if(is_blank($user['password'])) {
      $errors[] = "Password cannot be blank.";
    } elseif (!has_length($user['password'], array('min' => 12))) {
      $errors[] = "Password must contain 12 or more characters";
    } elseif (!preg_match('/[A-Z]/', $user['password'])) {
      $errors[] = "Password must contain at least 1 uppercase letter";
    } elseif (!preg_match('/[a-z]/', $user['password'])) {
      $errors[] = "Password must contain at least 1 lowercase letter";
    } elseif (!preg_match('/[0-9]/', $user['password'])) {
      $errors[] = "Password must contain at least 1 number";
    } elseif (!preg_match('/[^A-Za-z0-9\s]/', $user['password'])) {
      $errors[] = "Password must contain at least 1 symbol";
    }

    if(is_blank($user['confirm_password'])) {
      $errors[] = "Confirm password cannot be blank.";
    } elseif ($user['password'] !== $user['confirm_password']) {
      $errors[] = "Password and confirm password must match.";
    }
  }

  return $errors;
}

function is_logged_in() {
  // Having a admin_id in the session serves a dual-purpose:
  // - Its presence indicates the admin is logged in.
  // - Its value tells which admin for looking up their record.
  return isset($_SESSION['user_id']);
}




 ?>
