<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();

$mongo = new MongoDB\Client;
$db = $mongo->egov;

if (isset($_POST)) {

  // update emergency contact details



} else {
  echo "Nothing was sent, try again";
}






 ?>
