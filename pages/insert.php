<?php
require 'vendor/autoload.php';

$m = new MongoDB\Client;
$db = $m->egovApp;
$people = $db->people;
$user = $db->users;

if ($_POST) {
  $natid = $_POST['nationalid'];
  $usr = $_POST['username'];
  $psw = $_POST['password'];

  if (!$user->findOne(['natid' => $natid]) && $people->findOne(['natid' => $natid])) {
    echo "able to insert";
    $user->insertOne(['_id'=>$natid, 'username'=>$usr, 'password'=>$psw]);

  } else {
    echo "person with id %s already exists!".$natid;
  }


};
//
//
// if ($_POST) {
//   $user = array(
//   'name' => $_POST['name'],
//   'mb' => $_POST['mobile'],
//   'em' => $_POST['email']);
//
// $inserted = $employee->insertOne($user);
// var_dump($inserted);
//
// } else {
//   echo "No data was sent";
// }




//
// $insertManyResult = $employee->insertMany([
//   ['_id' => 1,'name' => 'ali','age' => 25, 'skill' => 'php'],
//   ['_id' => 2,'name' => 'ahmad','age' => 52, 'skill' => 'java'],
//   ['_id' => 3,'name' => 'saleh','age' => 15, 'skill' => 'node'],
//   ['_id' => 4,'name' => 'khalid','age' => 22, 'skill' => 'mongo'],
//   ['_id' => 5,'name' => 'dohmi','age' => 23, 'skill' => 'php']
// ]);
//
// printf("inserted %d documents: ", $insertManyResult->getInsertedCount());
// var_dump($insertManyResult->getInsertedIds());

//
// $insertOneRes = $employee->insertOne(
//   ['_id' => 1,'name' => 'ali','age' => 25, 'skill' => 'php']
// );
//
// printf("inserted %d documents", $insertOneRes->getInsertedCount());
// var_dump($insertOneRes->getInsertedId());

 ?>
