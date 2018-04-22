<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();

if (isset($_SESSION['egov'])) {
  unset($_SESSION['egov']);
}
session_destroy();
header("Location: ./../index.php");
die();


 ?>
