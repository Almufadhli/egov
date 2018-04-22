<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();
$referer = $_SERVER['HTTP_REFERER'];

$mongo = new MongoDB\Client;
$db = $mongo->egov;


   if (isset($_POST['Emnumber']) && isset($_POST['Emnumberlogin'])) {
     $emergCode = $_POST['Emnumber'];
     $repId = $_POST['repId'];
     $userId = $_POST['userId'];
     $instType = $_POST['instType'];

     $recordForEmergency = $User->emergencyBypass($repId, $userId, $instType, $emergCode);

   }
 ?>
