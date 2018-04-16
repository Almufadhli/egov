<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();
$url = $_SERVER['HTTP_REFERER'];


$instid = $_POST['idinst'];
$idowner = $_POST['iduser'];
$email = $_POST['email'];
$psw = $_POST['password'];


if (isset($_POST)){

  $newInstResult = $User->createNewInst($instid, $idowner, $email, $psw);

  var_dump($newInstResult);

  if ($newInstResult == 1) {
    header("Location: $url");
  } elseif ($newInstResult) {
    return -1; // invalid organization id
    echo "<script>
    alert('The institution ID you entered is invalid!');
    window.location.href='$url';
    </script>";
  } elseif ($newInstResult) {
    echo "<script>
    alert('The institution already has an account!');
    window.location.href='$url';
    </script>";
  } elseif ($newInstResult) {
    echo "<script>
    alert('You're not the owner of this institution!');
    window.location.href='$url';
    </script>";
  } else {
    echo "<script>
    alert('Something went wrong, please try again!');
    window.location.href='$url';
    </script>";

}} else {
  echo "something went wrong, go back and try again.";
}

?>
