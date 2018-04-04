<?php

define("ROOT_PATH", __DIR__);

session_start();
require_once(ROOT_PATH."/users/user.model.php");
$User = new User();

//echo ROOT_PATH . '/test';
;

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Welcome to the Integrated Service Center</title>
</head>
<body>
  <div class="">


    <div id="main">
      <p>Welcome to the service center.</p>
      <p>Please <a href="./login.html">log in</a> or <a href="./register.php">register</a>.</p>
    </div><!-- end "main" container -->

  </div>

</body>
</html>
