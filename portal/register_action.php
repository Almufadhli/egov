<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();

if (isset($_POST)){
  $natid = $_POST['nationalID'];
  $user = $_POST['username'];
  $email = $_POST['email'];
  $psw = $_POST['psw'];

  //$userArray = array($natid, $user, $email, $psw);


  $createUserRes = $User->createUser($natid, $user, $email, $psw);
  var_dump($createUserRes);

  if ($createUserRes) {
    header("Location: login.html");
  } elseif ($createUserRes == -1) {
    header("Location: register.html");
  } elseif ($createUserRes == -1) {
    header("Location: register.html");
  } else {
    header("Location: register.html");
  }

} else {
  echo "Error: 400";
}



?>
