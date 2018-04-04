<?php

require 'vendor/autoload.php';

// projection, unlike find, allows us to choose which properties to return


$client = new MongoDB\Client;
$companydb = $client->companydb;
$employee = $companydb->employee;

$documentList = $employee->find(
  ['skill' => 'php'], // here we only want the name, we also want to hide the id
['projection' => ['_id' => 0, 'name' => 1]]);

foreach ($documentList as $doc) {
  var_dump($doc);
}


 ?>
