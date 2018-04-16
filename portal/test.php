<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();


echo session_id();

echo "<br><br>++++++++++++++++++++++++++++++++++++<br><br>";
var_dump($_SESSION);



 ?>
