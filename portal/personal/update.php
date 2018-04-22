<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();

$mongo = new MongoDB\Client;
$db = $mongo->egov;

$peopleCollection = $db->people;

if (isset($_SESSION['egov']['userid'])){
  $userId = $_SESSION['egov']['userid'];
  $person = $peopleCollection->findOne(['natId'=>$userId]);



   var_dump($updateStatus);

 }
 ?>
