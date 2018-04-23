<?php

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


  $allergies = $hrc['allergies'];
  $chronicDseases = $hrc['chronicDiseases'];
  $surgeries = $hrc['surgeries'];
  $medicalReports = $hrc['reports'];

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




 ?>
