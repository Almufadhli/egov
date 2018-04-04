<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client;
$companydb = $client->companydb;
$employee = $companydb->employee;


$deleteResult = $employee->deleteMany(
  ['manager'=>'Tim']
);

printf("Delete %d documents: ", $deleteResult->getDeletedCount());


 ?>
