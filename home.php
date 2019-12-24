<?php session_start(); ?>
<?php include_once("includes/function.php"); ?>
<?php include_once("includes/database.php"); ?>
<?php include_once("includes/query_function.php"); ?>
<?php include_once("includes/auth_functions.php"); ?>

<div id="hero-image">
  <img src="images/belastingdienstfont.png" width="1500" height="100" alt="" />
</div>

<?php require_login(); ?>


<a href="formulier.php">Belasting</a>
<a href="logout.php">Logout</a>
<div id="content">









</div>
