<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));

$User = new User();

if (isset($_POST)){
  $license = $_POST["license"];
  $natId = $_POST["natid"];
  $psw = $_POST["psw"];

  $loginRepUserRes = $User->loginRepUser($license, $natId ,$psw);

  if ($loginUserRes){
    echo "welcome";
    header("Location: representative/dashboard.php");
  } else {
    echo "wrong password or username";
  }


} else {
  header("Location: error.php");
}



 ?>
