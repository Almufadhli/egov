<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();

$mongo = new MongoDB\Client;
$db = $mongo->egov;


$peopleCollection = $db->people;
$usersCollection = $db->users;

if (isset($_SESSION['egov']['userid'])){
  $userId = $_SESSION['egov']['userid'];
  $person = $peopleCollection->findOne(['natId'=>$userId]);


  var_dump($person);




} else {
  echo "not set";
}
//$person = $User->getUser($_SESSION['userId']);
