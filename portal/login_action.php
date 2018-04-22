<?php
// session_start();
// require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
// $User = new User();
session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();

$referer = $_SERVER['HTTP_REFERER'];
$msg = '';
$url = $_SERVER['HTTP_REFERER'];
if (isset($_POST["iduser"]) && isset($_POST["password"])) {

 $user = $_POST["iduser"];
 $psw = $_POST["password"];

 if ($_POST["type"] == 1){
   $loginUserRes = $User->loginUser($user, $psw);

   if ($loginUserRes[0] == 1) {
     header("Location: ./personal/dashboard.php");
   } elseif ($loginUserRes == -1) {
     $msg = "Username doesn't exist";
     $_SESSION['ErrorMsg'] = $msg;
   } elseif ($loginUserRes == -2) {
     $msg = "Password is wrong";
     $_SESSION['ErrorMsg'] = $msg;
   } else {
     $msg = "Sorry, something went wrong. Please try again";
     $_SESSION['ErrorMsg'] = $msg;
     header("Location: $url");
   }


 } else {
   $loginRepUserRes = $User->loginRepUser($user, $psw);

   if ($loginRepUserRes == 1) {
     header("Location: ./owner.php");
   } elseif ($loginRepUserRes == 21) {
     header("Location: ./representative/Hdashboard.php");
   } elseif ($loginRepUserRes == 22) {
     header("Location: ./representative/Edashboard.php");
   } elseif ($loginRepUserRes == 23) {
     header("Location: ./representative/Wdashboard.php");
   } elseif ($loginRepUserRes == -1) {
     $msg = "The password is wrong";
     //$_SESSION['ErrorMsg'] = $msg;
   } elseif ($loginRepUserRes == -2) {
     $msg = "Username is wrong";
     //$_SESSION['ErrorMsg'] = $msg;
   } else {
     $msg = "Sorry, something went wrong. Please try again";
     //$_SESSION['ErrorMsg'] = $msg;
   }

   echo "<script>
   alert('$msg!');
   window.location.href='$referer';
   </script>";
 }

  } else {
    echo "not set";
 }




// if (isset($_POST)){
//   $user = $_POST["iduser"];
//   $psw = $_POST["password"];
//   $type = $_POST["type"];
//
// }

  //$loginUserRes = $User->loginUser($user,$psw);
  //$test = $User->saveSession();
  //session_regenerate_id(true);
  //var_dump($_SESSION);
//
//   //$_SESSION["testtest"] = $loginUserRes;
// //echo $loginUserRes;
//   if ($loginUserRes){
//     //echo "test";
//     //$_SESSION["userId"] = $loginUserRes;
// //session_write_close();
//     //session_regenerate_id(true);
//
//     header("Location: personal/dashboard.php");
//     //session_write_close();
//     //session_regenerate_id(true);
//     exit();
//   } else {
//     echo "wrong password or username";
//   }
//
//
// } else {
//   header("Location: error.php");
// }

//exit();

 ?>
