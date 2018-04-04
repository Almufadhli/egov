<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client;
$companydb = $client->companydb;
$employee = $companydb->employee;


$replaceResult = $employee->replaceOne(
  ['_id'=>2],
  ['_id'=>2, 'facColor'=>'blue', 'height'=>180]
);

printf("Matched %d documents \n", $replaceResult->getMatchedCount());
printf("Modified %d documents \n", $replaceResult->getModifiedCount());


//
// $updateResult = $employee->updateMany(
//   ['skill' => 'php'],
//   ['$set' => ['manager' => 'Tim']]
// );
//
// printf("Matched %d documents \n", $updateResult->getMatchedCount());
// printf("Modified %d documents \n", $updateResult->getModifiedCount());

 ?>
