<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();
$url = $_SERVER['HTTP_REFERER'];

if (isset($_REQUEST)){

  $natId = $_REQUEST['iduser'];
  $user = $_REQUEST['username'];
  $email = $_REQUEST['email'];
  $psw = $_REQUEST['password'];


  $createUserRes = $User->createUser($natId, $user, $email, $psw);
  //var_dump($createUserRes);

  if ($createUserRes == 1) {
    header("Location: $url");
  } elseif ($createUserRes == -1) {
    echo "<script>
    alert('The ID you entered doesn't exist or is invalid!');
    window.location.href='$url';
    </script>";  } elseif ($createUserRes == -2) {
    echo "<script>
    alert('The username you entered is already used!');
    window.location.href='$url';
    </script>";
  } elseif ($createUserRes == -3) {
    echo "<script>
    alert('The email you entered is already used!');
    window.location.href='$url';
    </script>";
  } elseif ($createUserRes == -4) {
    echo "<script>
    alert('The ID you entered is already used!');
    window.location.href='$url';
    </script>";
  } else {
    header("Location: $url");
  }

} else {
  echo "Error: 400";
  var_dump($_REQUEST);
}



?>
