<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();
$referer = $_SERVER['HTTP_REFERER'];

if (isset($_POST['empid']) && isset($_SESSION['egov']['inst'])){
  $empid  = $_POST['empid'];
  $instId = $_SESSION['egov']['inst'];

    $repDeleted = $User->deleteRep($instId, $empid);
    if ($repDeleted == 1) {
      echo "<script>
      alert('Successfully deleted the specified representative!');
      window.location.href='$referer';
      </script>";
    } else {
      echo "<script>
      alert('You entered an invalid ID or the person is not a representative of your company!');
      window.location.href='$referer';
      </script>";
    }
} else {
  echo "post not set";
}


 ?>
