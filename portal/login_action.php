<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));

$User = new User();

if (isset($_POST)){
  $user = $_POST["username"];
  $psw = $_POST['psw'];

  $loginUserRes = $User->loginUser($user,$psw);

  if ($loginUserRes){
    echo "welcome";
    header("Location: dashboard.php");
  } else {
    echo "wrong password or username";
  }


} else {
  header("Location: wrong.php");
}



 ?>
