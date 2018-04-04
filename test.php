<?php

$options = ['cost' => 10];
$pass1 = "abcd";
$pass2 = "abcd";
$hash1 = password_hash($pass1, PASSWORD_DEFAULT, ['cost' => 10]);
$hash2 = password_hash($pass2, PASSWORD_DEFAULT, ['cost' => 12]);

echo "Hashed pass1: ".$hash1;
echo "<br>";
echo "Hashed pass2: ".$hash2;

echo "<br> Verify h1";
echo password_verify($pass1, $hash1);


echo "<br> Verify h2";
echo password_verify("abcd", $hash2);



 ?>
