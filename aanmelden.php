<?php
session_start();
include 'includes/function.php';
include 'includes/query_function.php';
include 'includes/database.php';

$db=db_connect();
  $errors=[];
//require_login();
if(is_post_request()) {

  $admin['first_name'] = isset ($_POST['first_name']) ? $_POST['first_name'] : '';
  $admin['last_name'] = isset ($_POST['last_name']) ? $_POST['last_name'] : '';
  $admin['email'] = isset ($_POST['email']) ? $_POST['email'] : '';
  $admin['username'] = isset ($_POST['username']) ? $_POST['username'] : '';
  $admin['password'] = isset ($_POST['password']) ? $_POST['password'] : '';
  $admin['confirm_password'] = isset ($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

  $result = insert_admin($admin);
  if($result === true) {
  header("Location: ");
  } else {

    $errors = $result;
  }

}else {
  // display the blank form
  $admin = [];
  $admin["first_name"] = '';
  $admin["last_name"] = '';
  $admin["email"] = '';
  $admin["username"] = '';
  $admin['password'] = '';
  $admin['confirm_password'] = '';
}

?>

<div id="content">

  <a class="back-link" href="home.php">&laquo; Back to List</a>

  <div class="admin new">
    <h1>Aanmelden</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php //echo url_for('/staff/admins/new.php'); ?>" method="post">
      <dl>
        <dt>First name</dt>
        <dd><input type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>" /></dd>
      </dl>

      <dl>
        <dt>Last name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>" /></dd>
      </dl>

      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo h($admin['username']); ?>" /></dd>
      </dl>

      <dl>
        <dt>Email </dt>
        <dd><input type="text" name="email" value="<?php echo h($admin['email']); ?>" /><br /></dd>
      </dl>

      <dl>
        <dt>Password</dt>
        <dd><input type="password" name="password" value="" /></dd>
      </dl>

      <dl>
        <dt>Confirm Password</dt>
        <dd><input type="password" name="confirm_password" value="" /></dd>
      </dl>
      <p>
        Passwords should be at least 12 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
      </p>
      <br />

      <div id="operations">
        <input type="submit" value="Create Admin" />
      </div>
    </form>

  </div>

</div>
