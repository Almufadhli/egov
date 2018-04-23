<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();

$mongo = new MongoDB\Client;
$db = $mongo->egov;

$peopleCollection = $db->people;
$usersCollection = $db->users;
$healthRecordsCollection = $db->healthRecords;
$workRecordsCollection = $db->workRecords;
$educationRecordsCollection = $db->educationRecords;

if (isset($_SESSION['egov']['userid'])){
  $userId = $_SESSION['egov']['userid'];
  $person = $peopleCollection->findOne(['natId'=>$userId]);


  // person details //
  $firstName = $person['firstName'];
  $secondName = $person['secondName'];
  $familyName = $person['familyName'];
  $sex = $person['sex'];

  // birth data
  $birthdate = $person['birth']['date'];
  $birthplace = $person['birth']['place'];
  $birthcountry = $person['birth']['country'];

  // address details
  $addBuildNum = $person['address']['buildingNum'];
  $addStreetName = $person['address']['streetName'];
  $addDistrict = $person['address']['district'];
  $addCity = $person['address']['city'];
  $addPostalCode = $person['address']['postalCode'];
  $addAddNum = $person['address']['addNum'];

  // additional details
  $phone = $person['phone'];
  $maritalStatus = $person['maritalStatus'];
  $picture = $person['picture'];


  // records retirval
  if (isset($person['records'])){
    $hrc = $healthRecordsCollection->findOne(['_id'=> $person['records']['hrc']]);
    $wrc = $workRecordsCollection->findOne(['_id'=> $person['records']['wrc']]);
    $erc = $educationRecordsCollection->findOne(['_id'=> $person['records']['erc']]);

    // \\\\\\\ Records retrieval \\\\\\\\\ //

    if (isset($hrc)){

      $hEC = $hrc['emergencyContact'];
      $height  = $hrc['height'];
      $weight = $hrc['weight'];
      $bmi = $hrc['bmi'];
      $bloodType = $hrc['bloodType'];

      $medicalVisits = $hrc['medicalVisits'];

      $lastDate = $User->getLastDate($medicalVisits);

      $keyOfLastDate = $lastDate['index'];
      $desc = "";
      $hospital = "Unknown";
      $diagnosis = "Unknown";
      $tests = array(array(
        'testName' => null,
        'testResult' => null
      ));
      $prescAction = null;
      $prescDrugs = null;

      if (isset($medicalVisits[$keyOfLastDate]['desc'])){
        $desc = $medicalVisits[$keyOfLastDate]['desc'];
      }
      if (isset($medicalVisits[$keyOfLastDate]['hospital'])){
        $hospital = $medicalVisits[$keyOfLastDate]['hospital'];
      }
      if (isset($medicalVisits[$keyOfLastDate]['diagnosis'])){
        $diagnosis = $medicalVisits[$keyOfLastDate]['diagnosis'];
      }

      if (isset($hrc['authorizations'])) {
        $hrcAuths = $hrc['authorizations'];
      }

      if (isset($hrc['allergies'])) {
        $allergies = $hrc['allergies'];
      }

      if (isset($hrc['chronicDiseases'])) {
        $chronicDseases = $hrc['chronicDiseases'];
      }

      if (isset($hrc['surgeries'])) {
        $surgeries = $hrc['surgeries'];
      }

      if (isset($hrc['reports'])) {
        $medicalReports = $hrc['reports'];
      }





    }

    if (isset($erc)) {

      $eEC = $erc['emergencyContact'];
      $currentEduStatus = $erc['currentStatus'];

      $highSchools = $erc['highSchool'];
      $universities = $erc['university'];

      if (isset($erc['authorizations'])) {
        $ercAuths = $erc['authorizations'];
      }


    }

    if (isset($wrc)) {
      $wEC = $wrc['emergencyContact'];

      $occupation = $wrc['occupation'];
      $employer = $wrc['employer'];
      $dateStarted = $wrc['dateStarted'];
      $dateStartedUTC = $User->displayDate($dateStarted);
      $salary = $wrc['salary'];
      $officePhone = $wrc['officePhone'];
      $documents = $wrc['documents'];
      $lastDocDate = $User->getLastDate($documents);
      $vacations = $wrc['vacations'];
      $previousjobs = $wrc['previousJobs'];

      // employer info
      $employerInfo = $User->getEmployerInfo($userId, $employer);
      if ($employerInfo) {
        $employerName = $employerInfo['name'];
        $employerId = $employerInfo['license'];
        $employerField = $employerInfo['field'];
        $employerType = $employerInfo['type'];
        $employerLoc = $employerInfo['location'];
      } else {
        $employerName = "Not registered in the database";
      }

      if (isset($wrc['authorizations'])) {
        $wrcAuths = $wrc['authorizations'];
      }

    }


  }


} else {
  echo "Please try again";
}


?>
