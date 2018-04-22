<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();
$referer = $_SERVER['HTTP_REFERER'];

if (isset($_POST['type'])) {
  $userId = $_SESSION['egov']['userid'];

  if ($_POST['type'] == "HS") {

    if (isset($_POST['schoolName']) && isset($_POST['dateStarted']) && isset($_POST['dateEnded']) && isset($_POST['location']) && isset($_POST['status'])) {
      $sn = $_POST['schoolName'];
      $ds = $_POST['dateStarted'];
      $de = $_POST['dateEnded'];
      $loc = $_POST['location'];
      $sts = $_POST['status'];


      if (isset($_POST['fileToUpload'])) {
        $file = $_POST['fileToUpload'];
      }

      // save data to the database
      $addNewSchoolResult = $User->addNewHighSchool($userId, $sn, $ds, $de, $sts, $loc, null);

    if ($addNewSchoolResult) {
      echo "<script>
      alert('Successfully added a new highschool!');
      window.location.href='$referer';
      </script>";
    } else {
      echo "<script>
      window.location.href='$referer';
      </script>";
      }
    }
  } elseif ($_POST['type'] == "Uni") {
    $un = $_POST['uniName'];
    $ufrom = $_POST['uniFrom'];
    $uto = $_POST['uniTo'];
    $udeg = $_POST['uniDegree'];
    $ugpa = $_POST['uniGPA'];
    $umjr = $_POST['uniMajor'];
    $usts = $_POST['uniStatus'];

    if (isset($_POST['fileToUpload'])) {
      $file = $_POST['fileToUpload'];
    }

    $addNewUniResult = $User->addNewUnivesity($userId, $un, $ufrom, $uto, $udeg, $ugpa, $umjr, $usts, null);

    if ($addNewUniResult) {
      echo "<script>
      alert('Successfully added a new university!');
      window.location.href='$referer';
      </script>";
    } else {
      echo "<script>
      window.location.href='$referer';
      </script>";
      }
  }
}

 ?>
