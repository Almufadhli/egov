<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/users/user.model.php"));
$User = new User();
$referer = $_SERVER['HTTP_REFERER'];



    if (isset($_POST["submitpass"])) {
     $id = $_POST['id'];
     $email = $_POST['email'];
     $type = $_POST['type'];

    $newPass = $User->recoverPassword($id, $type, $email);

    //var_dump($newPass);

    if ($newPass != -1 && $newPass != -2) {
      $pass = $newPass;
      $em = $_POST["email"];
      $to = $em;
      $from = "almufadhli@gmail.com";
      $message = $pass;
      $message = wordwrap($message, 70);
      $headers = "From:" . $from;
      $subject = "Password recovery";
      $test = mail($to , $subject, $message, $headers);


    } elseif ($newPass == -1) {
      echo "<script>alert('The email you entered is wrong')</script>";
    } else {
      echo "<script>alert('You entered a wrong ID or Username')</script>";
    }

    }

 ?>
