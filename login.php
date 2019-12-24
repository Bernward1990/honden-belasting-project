<?php
session_start();
include 'includes/function.php';
include 'includes/query_function.php';
include 'includes/database.php';
 include_once("includes/auth_functions.php");
$db=db_connect();

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {
  //ingevoerde waardes worden in variablen opgeslagen
  $username =  isset ($_POST['username']) ? $_POST['username'] : '';
  $password =  isset ($_POST['password']) ? $_POST['password'] : '';


  // Validatie van de ingevoerde waardes
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }


  // als er geen errors waren, wordt er geprobeerd om in te loggen
if(empty($errors)) {

  //variable om error bericht te weergeven
  $login_failure_msg = "Log in was unsuccessful.";

  //functie die de database in gaat om te kijken of ingevoerde username in de database voorkomt
  $user = find_user_by_username($username);

  //als username inderdaad in de database voorkomt
  if($user) {

   //checkt of wachtwoord overeenkomt met wachtwoord die in de database staat
    if(password_verify($password, $user['hashed_password'])) {
      // wachtwoord komt overeen
      log_in_user($user);

      //na inloggen naar de homepage gaan
      redirect_to("home.php");
    } else {
      // username gevonden, maar wachtwoord komt niet overeen
      $errors[] = $login_failure_msg;
    }

  } else {
    // username niet gevonden
    $errors[] = $login_failure_msg;
  }

}

}

 ?>



<div id="content">

<a class="back-link" href="index.php">Home</a>

  <h1>Log in</h1>

  <!--laat errors zien als die er zijn-->
  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>
