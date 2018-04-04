<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client;
$companydb = $client->companydb;
$employee = $companydb->employee;

$documentList = $employee->find(
  [],
  [
    'limit' => 4,
    'skip' => 2,
    'sort' => ['age' => 1]
  ]
);

foreach ($documentList as $doc) {
  var_dump($doc);
}


 ?>
