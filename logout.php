<?php
session_start();
include 'includes/function.php';
include 'includes/query_function.php';
include 'includes/database.php';
include_once("includes/auth_functions.php"); 
log_out_user();
redirect_to("index.php"); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h3>U bent uitgelogd</h3>
  </body>
</html>
