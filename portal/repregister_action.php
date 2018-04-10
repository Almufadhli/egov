<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();

if (isset($_POST)){

  $license  = $_POST['license'];
  $natid = $_POST['natid'];
  $email = $_POST['email'];
  $password = $_POST['password'];


  $createRepUserRes = $User->createRepUser($license, $natid, $email, $password);

  if ($createRepUserRes == 1){
    echo "Account created succefully";
    header("Location: replogin.html");
  } elseif ($createRepUserRes == -1) {
    echo "<script>
    alert('The organization ID you entered doesn't exist or is invalid!');
    window.location.href='repregister.html';
    </script>";
  } elseif ($createRepUserRes == -2) {
    echo "<script>
    alert('You entered an invalid ID!');
    window.location.href='repregister.html';
    </script>";
  } else {
    echo "<script>
    alert('The ID or Email you entered is already used!');
    window.location.href='repregister.html';
    </script>";
  }

  // if ($createRepUserRes) {
  //   var_dump($createRepUserRes);
  //   //header("Location: replogin.html");
  // } elseif ($createRepUserRes == -1) {
  //   header("Location: repregister.html");
  // } elseif ($createRepUserRes == -2) {
  //   header("Location: repregister.html");
  // } elseif ($createRepUserRes == -3) {
  //   echo "Org doesn't exists";
  // } else {
  //   header("Location: repregister.html");
  // }

} else {
  echo "Error: 400";
}



?>
