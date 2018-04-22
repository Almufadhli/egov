
<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();

$referer = $_SERVER['HTTP_REFERER'];
$ownerPage = realpath(dirname(__FILE__)."\owner.php");
$homepage = realpath(dirname(__FILE__)."\../");


if (isset($_POST) && isset($_POST['ref'])){

  // check if this page was opened from owner.php
  if ($_SESSION['owner'] && isset($_SESSION['egov']['inst']) && $_POST['ref'] == 'owner'){
  $empid  = $_POST['empid'];
  $email = $_POST['email'];
  $code = $_POST['authcode'];
  $inst = $_SESSION['egov']['inst'];
  $assignNewRep = $User->assignRep($inst, $empid, $email, $code);

  if ($assignNewRep == 1) {
    echo "<script>
    alert('Successfully added the new representative');
    window.location.href='$referer';
    </script>";

  } elseif ($assignNewRep == -1) {
    echo "<script>
    alert('The employee ID you entered is invalid');
    window.location.href='$referer';
    </script>";

  } elseif ($assignNewRep == -2) {
    echo "<script>
    alert('The person you entered has an account already');
    window.location.href='$referer';
    </script>";

  } elseif ($assignNewRep == -3) {
    echo "<script>
    alert('You can't assign the owner of another company to be your representative');
    window.location.href='$referer';
    </script>";

  } else {
    echo "<script>
    alert('Something went wrong, please try again');
    window.location.href='$referer';
    </script>";

  }


} elseif ($_POST['ref'] == 'rep') {

  $empid  = $_POST['empid'];
  $username  = $_POST['username'];
  $psw = $_POST['password'];
  $code = $_POST['authcode'];

  $createRepUser = $User->createRepUser($empid, $username, $psw, $code);

  if ($createRepUser == 1) {
      header("Location: $referer");
  } elseif ($createRepUser == -1) {
      echo "<script>
      alert('You entered a wrong authoriztion code, try again!');
      window.location.href='$referer';
      </script>";
  } elseif ($createRepUser == -2) {
    echo "<script>
    alert('You're not a representative!');
    window.location.href='$referer';
    </script>";
  } elseif ($createRepUser == -3) {
    echo "<script>
    alert('You're already authorizaed, try signing in!');
    window.location.href='$homepage';
    </script>";
  } elseif ($createRepUser == -4) {
    echo "<script>
    alert('You entered a wrong ID number!');
    window.location.href='$referer';
    </script>";
  }
}
  //$createRepUserRes = $User->createRepUser($empid, $uname, $email, $code);

  // if ($createRepUserRes == 1){
  //   echo "Account created succefully";
  //   //header("Location: replogin.html");
  // } elseif ($createRepUserRes == -1) {
  //   echo "<script>
  //   alert('The organization ID you entered doesn't exist or is invalid!');
  //   window.location.href='repregister.html';
  //   </script>";
  // } elseif ($createRepUserRes == -2) {
  //   echo "<script>
  //   alert('You entered an invalid ID!');
  //   window.location.href='repregister.html';
  //   </script>";
  // } else {
  //   echo "<script>
  //   alert('The ID or Email you entered is already used!');
  //   window.location.href='repregister.html';
  //   </script>";
  // }

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
  header("Location: $homepage");
}



?>
