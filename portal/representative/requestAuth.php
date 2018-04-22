<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();
$referer = $_SERVER['HTTP_REFERER'];

$mongo = new MongoDB\Client;
$db = $mongo->egov;


$usersCollection = $db->users;
$orgsCollection = $db->organizations;
$peopleCollection = $db->people;


if (isset($_POST['authRequester']) && isset($_POST['userId']) && isset($_POST['instType'])) {
  $authRequester = $_POST['authRequester'];
  $userId = $_POST['userId'];
  $instType = $_POST['instType'];
  $requestResult = $User->requestAuth($authRequester, $userId, $instType);

  if ($requestResult == 1) {
    echo "<script>
    alert('Request was sent successfully');
    window.location.href = '$referer';
    </script>";
  } elseif ($requestResult == -1) {
    echo "<script>
    alert('You have sent a request already, awaiting user response');
    window.location.href = '$referer';
    </script>";
  } else {
    echo "<script>
    alert('You have been blocked from requesting authorization for this user');
    window.location.href = '$referer';
    </script>";
  }

} else {
  echo "nothing to see here";
}


 ?>
