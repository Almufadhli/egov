<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();
$referer = $_SERVER['HTTP_REFERER'];
$userId = $_SESSION['egov']['userid'];


if (isset($_POST['requestId']) && isset($_POST['recordType']) && isset($_POST['response'])) {
  $reqId = $_POST['requestId'];
  $reqType = $_POST['recordType'];
  $response = $_POST['response'];

  echo "reqId: ".$reqId."<br>";
  echo "reqType: ".$reqType."<br>";
  echo "response: ".$response."<br>";


  $processRequest = $User->authorizeRepresentative($userId, $reqId, $reqType, $response);

  if ($processRequest) {
    echo "<script>
    window.location.href='$referer';
    </script>";
  } elseif ($processRequest == -1) {
    echo "<script>
    alert('This user is already authorized!');
    window.location.href='$referer';
    </script>";
  } else {
    echo "<script>
    window.location.href='$referer';
    </script>";
  }
}


 ?>
