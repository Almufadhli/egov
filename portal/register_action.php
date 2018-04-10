<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();

if (isset($_REQUEST)){

  $natId = $_REQUEST['myid'];
  $user = $_REQUEST['username'];
  $email = $_REQUEST['email'];
  $psw = $_REQUEST['psw'];


  $createUserRes = $User->createUser($natId, $user, $email, $psw);
  var_dump($createUserRes);

  if ($createUserRes == 1) {
    header("Location: login.html");
  } elseif ($createUserRes == -1) {
    echo "<script>
    alert('The ID you entered doesn't exist or is invalid!');
    window.location.href='register.html';
    </script>";
  } elseif ($createUserRes == -2) {
    echo "<script>
    alert('The username you entered is already used!');
    window.location.href='register.html';
    </script>";
  } elseif ($createUserRes == -3) {
    echo "<script>
    alert('The email you entered is already used!');
    window.location.href='register.html';
    </script>";
  } elseif ($createUserRes == -4) {
    echo "<script>
    alert('The ID you entered is already used!');
    window.location.href='register.html';
    </script>";
  } else {
    header("Location: register.html");
  }

} else {
  echo "Error: 400";
  var_dump($_REQUEST);
}



?>
