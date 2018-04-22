<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();
$referer = $_SERVER['HTTP_REFERER'];

  $userId = $_SESSION['egov']['userid'];

    if (isset($_POST['occupation']) && isset($_POST['employer']) && isset($_POST['startDate']) && isset($_POST['endDate']) && isset($_POST['reason'])) {
      $occ = $_POST['occupation'];
      $emp = $_POST['employer'];
      $sd = $_POST['startDate'];
      $ed = $_POST['endDate'];
      $rsn = $_POST['reason'];

      // save data to the database
      $addNewJobResult = $User->addNewJob($userId, $occ, $emp, $sd, $ed, $rsn);

    if ($addNewSchoolResult) {
      echo "<script>
      alert('Successfully added a new job!');
      window.location.href='$referer';
      </script>";
    } else {
      echo "<script>
      window.location.href='$referer';
      </script>";
      }
    }


 ?>
