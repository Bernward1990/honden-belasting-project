<?php
define("servername", "127.0.0.1:3306");
define("username","root");
define("password", "");
define("dbname", "honden_belasting");

//connect the database
function db_connect(){
  $connection = mysqli_connect(servername, username, password, dbname);
  return $connection;
}

//closing database conection if there is any
function db_close($db_connection){
  if(empty($db_connection)){
      mysqli_close($db_connection);
  }
}

function confirm_result_set($result_set) {
  if (!$result_set) {
    exit("Database query failed.");
  }
}

?>
