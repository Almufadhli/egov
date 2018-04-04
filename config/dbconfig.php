<?php

require 'vendor/autoload.php';
$mongo = new MongoDB\Client("mongodb://Almufadhli:AMsa1405747@cluster0-shard-00-00-qcbzr.mongodb.net:27017,cluster0-shard-00-01-qcbzr.mongodb.net:27017,cluster0-shard-00-02-qcbzr.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");
$db = $mongo->egov;

$peopleCollection = $db->people;
$usersCollection = $db->users;


 ?>
