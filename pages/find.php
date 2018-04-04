<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client;
$companydb = $client->companydb;
$employee = $companydb->employee;
//
// $document = $employee->findOne(['_id'=>1]);
// var_dump($document);

$documentList = $employee->find([
  'skill' => 'php'
]);

foreach ($documentList as $doc) {
  var_dump($doc);
}


 ?>
