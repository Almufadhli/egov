<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();


echo "Welcome to your dashboard<br>";


$mongo = new MongoDB\Client("mongodb://Almufadhli:AMsa1405747@cluster0-shard-00-00-qcbzr.mongodb.net:27017,cluster0-shard-00-01-qcbzr.mongodb.net:27017,cluster0-shard-00-02-qcbzr.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");
$db = $mongo->egov;

$peopleCollection = $db->people;
$usersCollection = $db->users;



if (isset($_SESSION[""]["userId"])){
  $userId = $_SESSION[""]["userId"];
  echo "Note*: Press CTRL+U to view the retrived info from the database in a readable format<br><br>";

  $person = $peopleCollection->findOne(['natId'=>$userId]);



  echo $person["natId"];


} else {
  echo "not set";
}
//$person = $User->getUser($_SESSION['userId']);

 ?>
