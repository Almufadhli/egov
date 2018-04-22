<?php
require_once(realpath(dirname(__FILE__)."/../vendor/autoload.php"));
require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
//require_once(LIBRARY_PATH . "/templateFunctions.php");



/**
*
*/
class User
{

  private $sessionName = "egov";

  public $logged_in = false;
  public $userData;



  function __construct()
  {
    //session_start();
    // get the session_ID and then check if it's empty (empty means no session was started)
    $sessionId = session_id();
    if(strlen($sessionId) == 0)
    throw new Exception("No session has been started.<br>Please add `session_start();` initially in your file before any output.");

    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    //$_SESSION["db"] = $db;

    $peopleCollection = $db->people;
    $usersCollection = $db->users;

  }


  /**
  * Returns true if the user was created succesfully.
  * If not, it returns (bool)false.
  *
  *	userarr: this is an array of user data (_id, username, email, password)
  *	return	The user id or -1 if the ID is not valid or not in the database, -2 if the username is taken
  */

  public function createUser($natid, $user, $email, $psw){
  $mongo = new MongoDB\Client;
  $db = $mongo->egov;
  $peopleCollection = $db->people;
  $usersCollection = $db->users;


  $findPersonIdResult = $peopleCollection->findOne(['natId' => $natid]);
  $findUserIdResult = $usersCollection->findOne(['entityId' => $natid, 'UserType' => 'ind']);
  $findUserResult = $usersCollection->findOne(['username' => $user]);
  $findEmailResult = $usersCollection->findOne(['email' => $email]);

  // check if the nationalID the user entered is a valid id of a person, and that the user doesn't exist already
  if ($findPersonIdResult && !$findUserIdResult && !$findUserResult && !$findEmailResult){

    //encrypt the password
    $hash = password_hash($psw, PASSWORD_DEFAULT, ['cost' => 10]);

    // $now specifies the time of creation
    $now = $this->getCurrentTime();

    // Insert to the database
    $insertUserResult = $usersCollection->insertOne(
      ['entityId'=>$natid,
      'userType'=>'ind',
      'username'=>$user,
      'email'=>$email,
      'password'=>$hash,
      'createdAt'=>$now]
    );

    // initialize the records
    $this->newRecord($natid);
    return $insertUserResult->getInsertedCount();

  } elseif (!$findPersonIdResult) {
    // ID doesn't exist
    return -1;
  } elseif ($findUserResult) {
    // User is used already
    return -2;
  } elseif ($findEmailResult) {
    // The email is used
    return -3;
  } elseif ($findUserIdResult) {
    // the ID is used
    return -4;
  } else {
    return $error = "You have to choose a username and a password";
  }
  }


  public function createRepUser($empid, $username, $psw, $code){
  $mongo = new MongoDB\Client;
  $db = $mongo->egov;

  $orgsCollection = $db->organizations;
  $peopleCollection = $db->people;
  $usersCollection = $db->users;

  $findUserResult = $usersCollection->findOne(['entityId' => $empid, 'userType' => 'rep']);

  $hash = password_hash($psw, PASSWORD_DEFAULT, ['cost' => 10]);

  // $now specifies the time of creation
  $now = $this->getCurrentTime();

  // if the user exists
  if ($findUserResult && $findUserResult['authorized'] == false){
    // if the user exists, check if he entered the correct auth code
    $instId = $findUserResult['inst'];
    $findInst = $orgsCollection->findOne(['license' => $instId]);

    // if the institution has representatives
    if ($findInst['reps']){
      $index = null;
      $authenticateID = false;
      $authenticateCode = false;

      // look for the Id of the representative and validate the authentication code
      foreach($findInst['reps'] as $key => $product)
      {
         if ($product['repId'] === $empid){
            $authenticateID = true;
            $index = $key;
            if ($product['authCode'] === $code)
              $authenticateCode = true;
          }
      }

      // check if the ID exists in the representatives ids
      if ($authenticateID && $authenticateCode) {
        $updateRepResult = $usersCollection->UpdateOne(
          ['entityId' => $empid, 'userType' => 'rep'],
          [ '$set' => ["password" => $hash, "createdAt" => $now, 'authorized' => true]]);
          return 1;
      } elseif ($authenticateID && !$authenticateCode) {
        return -1; // wrong auth code
      }
    } else {
      return -2; // this inst has no reps
    }
  } elseif ($findUserResult['authorized'] == true) {
    return -3; // this user is already authorized
  } else {
    return -4; // user not found
  }
  }


  public function assignRep($inst, $empid, $email, $code){
  $mongo = new MongoDB\Client;
  $db = $mongo->egov;

  $orgsCollection = $db->organizations;
  $peopleCollection = $db->people;
  $usersCollection = $db->users;

  // find if the id is actually of a person
  $personExists = $peopleCollection->findOne(['natId' => $empid]);

  // find if the user doesn't exist already
  $userNotExist = $usersCollection->findOne(['entityId' => $empid, 'userType' => 'rep']);

  // make sure he's not an owner
  $notAnOwner = $orgsCollection->findOne(['owner' => $empid]);


  if ($personExists && !$userNotExist && !$notAnOwner) {
    $userDoc = array(
      'entityId' => $empid,
      'userType' => 'rep',
      'inst' => $inst,
      'email' => $email,
      'authorized' => false
    );

    $repAuth = array(
      'repId' => $empid,
      'authCode' => $code
    );

    $insertIntoUsers = $usersCollection->insertOne($userDoc);
    if ($insertIntoUsers){
      $updateEmployees = $orgsCollection->updateOne(['license' => $inst], array('$addToSet' => array("reps" => $repAuth)));
    }

    return 1; // successfully assigned user
  } elseif (!$personExists) {
    return -1; // person doesn't exist
  } elseif ($userNotExist) {
    return -2; // user exists already
  } elseif ($notAnOwner) {
    return -3; // can't add rep because he's an owner of another inst
  }

  }

  public function deleteRep($inst, $repId)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $orgsCollection = $db->organizations;
    $usersCollection = $db->users;

    $findInst = $orgsCollection->findOne(['license' => $inst]);
    $findRep = $usersCollection->findOne(['entityId' => $repId, 'inst' => $inst]);

    $filter = array(
            'license' => $inst,
            'reps.repId' => $repId,
          );

    $update = array(
      '$pull' => array('reps' => array('repId' => $repId))
    );


    if ($findRep) {
      $removeRepResult = $orgsCollection->findOneAndUpdate($filter, $update);
      $removeRepUser = $usersCollection->findOneAndDelete(['entityId' => $repId, 'userType' => 'rep']);

      if ($removeRepResult && $removeRepUser) {
        return 1; // successfully removed representative
      }
    } else {
      return -1; // no rep was found with this Id
    }

  }


  public function createNewInst($instid, $idowner, $email, $psw)
  {
  $mongo = new MongoDB\Client;
  $db = $mongo->egov;

  $orgsCollection = $db->organizations;
  $peopleCollection = $db->people;
  $usersCollection = $db->users;

  // check if the institution exists and doesn't ahve an account
  $findOrgResult = $orgsCollection->findOne(['license' => $instid]);
  $findUserResult = $usersCollection->findOne(['entityId' => $idowner, 'userType' => 'owner']);

  // validate the owner id
  $validOwner = $findOrgResult['owner'] == $idowner;

  $hash = password_hash($psw, PASSWORD_DEFAULT, ['cost' => 10]);

  // $now specifies the time of creation
  $now = $this->getCurrentTime();

  if ($findOrgResult && !$findUserResult && $validOwner) {

  $orgDoc = array(
    "entityId" => $idowner,
    "userType" => "owner",
    "inst" => $instid,
    "email" => $email,
    "password" => $hash,
    "createdAt" => $now
  );


  $insertOrg = $usersCollection->insertOne($orgDoc);
  return 1;

  } elseif (!$findOrgResult) {
  return -1; // invalid organization id
  } elseif ($findUserResult) {
  return -2; // org already has an account
  } elseif (!$validOwner) {
  return -3; // you're not the owner
  } else {
  return -4; // error
  }


  }


  /**
  * return true if the user was logged in succefully
  * If not, it returns (bool)false.
  *
  *	This function takes two parameters, username and password
  *
  */

  public function loginUser( $username, $password ){
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $peopleCollection = $db->people;
    $usersCollection = $db->users;

    // Check if the username exists
    $findUsernameResult = $usersCollection->findOne(['username' => $username]);
    // then verify the password with the password of the username in the database (it's encrypted)
    $verifyPassword = password_verify($password, $findUsernameResult['password']);

    if ($findUsernameResult && $verifyPassword){
      // if the username exists and the password is correct, get the _id
      $entityId = $findUsernameResult['entityId'];
      // then match that _id with the natioanlId of the person in the people collection
      //$person = $peopleCollection->findOne(['natId'=>$entityId]);
      // and assigned the sessionName of "this" object to its _id
      //$_SESSION[$this->sessionName]["userId"] = $entityId;
      $_SESSION[$this->sessionName]['userid'] = $entityId;
      $this->logged_in = true;
      // so that we can retirieve all of his/her information

      //echo "Logged in";
      return "1".$entityId;
    } elseif (!$findUsernameResult && $verifyPassword) {
      //echo "Username doesn't exist";
      return -1;
    } elseif ($findUsernameResult && !$verifyPassword) {
      //echo "Wrong password";
      return -2;
    } else {
      //echo "Invalid username or password, please try again";
      return -3;
    }
  }

  public function loginRepUser( $natId, $password ){
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $usersCollection = $db->users;
    $orgsCollection = $db->organizations;

    //$findOrgResult = $orgsCollection->findOne(['license' => $license]);
    $findUserResult = $usersCollection->findOne(array(
      '$or' => array(
        ['entityId' => $natId, 'userType' => 'owner'],
        ['entityId' => $natId, 'userType' => 'rep']
      )
    ));

    $hashedPass = $findUserResult['password'];
    // check if license is valid, and the id exists, and the user exists
    if ($findUserResult){
      // verify the password with the password of the username in the database (it's encrypted)
      $verifyPassword = password_verify($password, $hashedPass);
      $instId = $findUserResult['inst'];

      if ($verifyPassword) {
        if ($findUserResult['userType'] == 'owner') {
          $_SESSION[$this->sessionName]["inst"] = $instId;
          $_SESSION[$this->sessionName]["entityId"] = $natId;
          $this->logged_in = true;

          return 1; // 1 for owner page redirect
        } elseif ($findUserResult['userType'] == 'rep') {
          $instInfo = $orgsCollection->findOne(['license' => $instId]);
          $instType = $instInfo['field'];

          $_SESSION[$this->sessionName]["inst"] = $instId;
          $_SESSION[$this->sessionName]["entityId"] = $natId;
          $this->logged_in = true;

          if ($instType == "Healthcare") {
            return 21;
          } elseif ($instType == "Education") {
            return 22;
          } elseif ($instType == "Business") {
            return 23;
          }
        } else {
          return 0; // an error
        }
      } else {
        return -1; // wrong password
      }
    } else {
      return -2; // wrong username
    }
  }

public function saveSession()
{
  $_SESSION["savetest"] = "saved";
}

public function newInstitution($instId, $ownerId, $name, $email, $pass, $field, $location)
{
  $mongo = new MongoDB\Client;
  $db = $mongo->egov;

  $orgsCollection = $db->organizations;
  $peopleCollection = $db->people;
  $usersCollection = $db->users;

  $validOwnerId = $peopleCollection->findOne(['natId' => $ownerId]);

  return $validOwnerId;
}

public function recoverPassword($id, $type, $email)
{
  $mongo = new MongoDB\Client;
  $db = $mongo->egov;

  $orgsCollection = $db->organizations;
  $usersCollection = $db->users;

  if ($type == 'rep' || $type == 'owner') {
    $filter = array(
      'entityId' => $id,
      'userType' => $type,
    );
  } elseif ($type == 'ind') {
    $filter = array(
      'username' => $id,
      'userType' => $type,
    );
  }


  $user = $usersCollection->findOne($filter);

  if ($user) {
    if ($user['email'] == $email) {
      // genereate random password
      $newPass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
      $hash = password_hash($newPass, PASSWORD_DEFAULT, ['cost' => 10]);

      $updateNewPass = $usersCollection->findOneAndUpdate($filter, array('$set' => ['password' => $hash] ));
      return $newPass;
    } else {
      return -1; // wrong email
    }
  } else {
    return -2;
  }
}

  // these function are to come
  public function logoutUser()
  {
    if( isset($_SESSION[$this->sessionName]) ){
        unset($_SESSION[$this->sessionName]);
        $this->logged_in = false;
        return true;
      } else {
        return false;
      }
  }

  public function getUser($userId)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    $peopleCollection = $db->people;

    if (!$userId == 0) {

      $person = $peopleCollection->findOne(['natId'=>$userId]);

      return $person;
    } else {
      return null;
    }

  }

  public function getUserData($userId)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    $usersCollection = $db->users;

    if (!$userId == 0) {

      $user = $usersCollection->findOne(['entityId'=>$userId, 'userType' => 'rep']);

      return $user;
    } else {
      return null;
    }

  }


  public function getRepInst($repId)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    $orgsCollection = $db->organizations;
    $usersCollection = $db->users;

    if (isset($repId)) {
      $repInfo = $usersCollection->findOne(['entityId' => $repId, 'userType' => 'rep']);
      $inst = $repInfo['inst'];
      $instInfo = $orgsCollection->findOne(['license' => $inst]);

      if ($instInfo) {
        return $instInfo;
      } else {
        return null;
      }
    }


  }



  public function findAndReplace($value='')
  {
    # code...
  }

  public function setInfo($value='')
  {
    # code...
  }

  public function newRecord($id)
  {

    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $HRC = $db->healthRecords;
    $ERC = $db->educationRecords;
    $WRC = $db->workRecords;
    $peopleCollection = $db->people;


    // initial health record
    $hrcRecord = array(
      'personId' => $id,
      'emergencyContact' => array(
        '_id' => new MongoDB\BSON\ObjectId(),
        'name' => '',
        'phone' => '',
        'relationship' => '',
        'code' => 0000
      ),
      'height' => 0,
      'weight' => 0,
      'bmi' => 0,
      'bloodType' => '',
      'medicalVisits' => array(
        array(
          '_id' => new MongoDB\BSON\ObjectId(),
          'date' => new MongoDB\BSON\UTCDateTime,
          'desc' => '',
          'hospital' => '',
          'diagnosis' => '',
          'tests' => array(
            array(
              '_id' => new MongoDB\BSON\ObjectId(),
              'testName' => '',
              'testResult' => ''
            )
          ),
          'prescribedAction' => '',
          'prescribedDrugs' => array(
            array(
              '_id' => new MongoDB\BSON\ObjectId(),
              'name' => '',
              'period' => 0,
              'dosage' => 0,
              'timesPerDay' => 0,
              'dateStarted' => new MongoDB\BSON\UTCDateTime,

            )
          )
        )
      ),
      'allergies' => array(
        'foods' => array(),
        'drugs' => array(),
        'others' => array()
      ),
      'surgeries' => array(
        array(
          '_id' => new MongoDB\BSON\ObjectId(),
          'date' => new MongoDB\BSON\UTCDateTime,
          'name' => '',
          'hospital' => '',
          'doctor' => ''
        )
      ),
      'chronicDiseases' => array(),
      'reports' => array(
        array(
          '_id' => new MongoDB\BSON\ObjectId(),
          'date' => new MongoDB\BSON\UTCDateTime,
          'type' => '',
          'from' => '',
          'location' => ''
        )
      )
    );


    // initial education record
    $ercRecord = array(
      'personId' => $id,
      'emergencyContact' => array(
        '_id' => new MongoDB\BSON\ObjectId(),
        'name' => '',
        'phone' => '',
        'relationship' => '',
        'code' => 0000
      ),
      'currentStatus' => '',
      'highSchool' => array(
       array(
         '_id' => new MongoDB\BSON\ObjectId(),
         'schoolName' => '',
         'dateStarted' => new MongoDB\BSON\UTCDateTime,
         'dateEnded' => new MongoDB\BSON\UTCDateTime,
         'status' => '',
         'reports' => array(
           array(
             '_id' => new MongoDB\BSON\ObjectId(),
             'date' => new MongoDB\BSON\UTCDateTime,
             'from' => '',
             'type' => '',
             'location' => ''
           )
         )
       )
      ),
      'university' => array(
       array(
         '_id' => new MongoDB\BSON\ObjectId(),
         'universityName' => '',
         'dateStarted' => new MongoDB\BSON\UTCDateTime,
         'dateEnded' => new MongoDB\BSON\UTCDateTime,
         'degree' => '',
         'gpa' => 0,
         'major' => '',
         'status' => '',
         'reports' => array(
           array(
             '_id' => new MongoDB\BSON\ObjectId(),
             'date' => new MongoDB\BSON\UTCDateTime,
             'from' => '',
             'type' => '',
             'location' => ''
           )
         )
       )
     )
   );


      // initial work records
      $wrcRecord = array(
        'personId' => $id,
        'emergencyContact' => array(
          '_id' => new MongoDB\BSON\ObjectId(),
          'name' => '',
          'phone' => '',
          'relationship' => '',
          'code' => 0000
        ),
        'occupation' => '',
        'employer' => '',
        'dateStarted' => new MongoDB\BSON\UTCDateTime,
        'salary' => 0.00,
        'officePhone' => '',
        'documents' => array(
          array(
            '_id' => new MongoDB\BSON\ObjectId(),
            'date' => new MongoDB\BSON\UTCDateTime,
            'docName' => '',
            'uploadedBy' => '',
            'notes' => '',
            'location' => ''
          )
        ),
        'vacations' => array(
          array(
            '_id' => new MongoDB\BSON\ObjectId(),
            'leaveType' => '',
            'startDate' => new MongoDB\BSON\UTCDateTime,
            'endDate' => new MongoDB\BSON\UTCDateTime,
            'reason' => '',
            'attachments' => array(
              array(
                '_id' => new MongoDB\BSON\ObjectId(),
                'fileName' => '',
                'desc' => '',
                'location' => ''
              )
            )
          )
        ),
        'previousJobs' => array(
          array(
            '_id' => new MongoDB\BSON\ObjectId(),
            'occupation' => '',
            'employer' => '',
            'startDate' => new MongoDB\BSON\UTCDateTime,
            'endDate' => new MongoDB\BSON\UTCDateTime,
            'reasonForLeaving' => ''
          )
        )
      );

    $insertHRCResult = $HRC->insertOne($hrcRecord);
    $insertERCResult = $ERC->insertOne($ercRecord);
    $insertWRCResult = $WRC->insertOne($wrcRecord);

    //var_dump();
    $HRCID = $insertHRCResult->getInsertedId();
    $ERCID = $insertERCResult->getInsertedId();
    $WRCID = $insertWRCResult->getInsertedId();

    $filter = array('natId'=>$id, 'records.hrc' => array('$ne' => $HRCID));

    $records = array(
    'hrc' => $insertHRCResult->getInsertedId(),
    'erc' => $insertERCResult->getInsertedId(),
    'wrc' => $insertWRCResult->getInsertedId()
    );

    $updatePersonRecords = $peopleCollection->UpdateOne(['natId' => $id], [ '$set' => ['records' => $records]]);
    //echo "<br><br><br>";
    //var_dump($updatePersonRecords);

  }

  public function updateHealthRecord($id)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    $HRC = $db->healthRecords;
  }

  public function updateHREmCon($id, $name, $phone, $relationship, $code)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $HRC = $db->healthRecords;

    $findUserRecord = $HRC->findOneAndUpdate(
      ['personId' => $id ],
      ['$set' => [
        'emergencyContact.name' => $name,
        'emergencyContact.phone' => $phone,
        'emergencyContact.relationship' => $relationship,
        'emergencyContact.code' => $code
        ]]
    );
    return $findUserRecord;
  }

  public function updateEREmCon($id, $name, $phone, $relationship, $code)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $ERC = $db->educationRecords;

    $findUserRecord = $ERC->findOneAndUpdate(
      ['personId' => $id ],
      ['$set' => [
        'emergencyContact.name' => $name,
        'emergencyContact.phone' => $phone,
        'emergencyContact.relationship' => $relationship,
        'emergencyContact.code' => $code
        ]]
    );
    return $findUserRecord;
  }

  public function updateWREmCon($id, $name, $phone, $relationship, $code)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $WRC = $db->workRecords;

    $findUserRecord = $WRC->findOneAndUpdate(
      ['personId' => $id ],
      ['$set' => [
        'emergencyContact.name' => $name,
        'emergencyContact.phone' => $phone,
        'emergencyContact.relationship' => $relationship,
        'emergencyContact.code' => $code
        ]]
    );
    return $findUserRecord;
  }

  public function updateHAndW($id, $height, $weight)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $HRC = $db->healthRecords;
    $BMI = $this->getBMI($height, $weight);
    $findAndUpdate = $HRC->findOneAndUpdate(
      ['personId' => $id ],
      ['$set' => [
        'height' => $height,
        'weight' => $weight,
        'bmi' => round($BMI, 2)
        ]]
    );

    return $findAndUpdate;
  }

  public function updateEducationStatus($id, $status)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $ERC = $db->educationRecords;

    $updateCurrentStatus = $ERC->findOneAndUpdate(
      ['personId' => $id],
      ['$set' => ['currentStatus' => $status]]
    );

    var_dump($updateCurrentStatus);

    return $updateCurrentStatus;
  }

  public function displayHealthRecords($id)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    $HRC = $db->healthRecords;

    return $HRC->findOne(['_id' => $id]);
  }

  public function addNewHighSchool($userId, $schoolName, $dateStarted, $dateEnded, $status, $loc, $reports)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $ERC = $db->educationRecords;
    $id = new MongoDB\BSON\ObjectId();

    $ds = new MongoDB\BSON\UTCDateTime((new DateTime($dateStarted))->getTimestamp()*1000);
    $de = new MongoDB\BSON\UTCDateTime((new DateTime($dateEnded))->getTimestamp()*1000);


    $filter = array('personId' => $userId);
    $update = array('$addToSet' =>
     array( 'highSchool' =>
       array(
        '_id' => $id,
        'schoolName' => $schoolName,
        'dateStarted' => $ds,
        'dateEnded' => $de,
        'status' => $status,
        'location' => $loc,
        'reports' => array()
      )
    ));

    $updateSchool = $ERC->findOneAndUpdate($filter, $update);
    return $updateSchool;

  }
  public function addNewUnivesity($userId, $uniName, $dateStarted, $dateEnded, $degree, $gpa, $major, $status, $reports)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $ERC = $db->educationRecords;
    $id = new MongoDB\BSON\ObjectId();

    $ds = new MongoDB\BSON\UTCDateTime((new DateTime($dateStarted))->getTimestamp()*1000);
    $de = new MongoDB\BSON\UTCDateTime((new DateTime($dateEnded))->getTimestamp()*1000);


    $filter = array('personId' => $userId);
    $update = array('$addToSet' =>
     array( 'university' =>
       array(
        '_id' => $id,
        'universityName' => $uniName,
        'dateStarted' => $ds,
        'dateEnded' => $de,
        'degree' => $degree,
        'gpa' => $gpa,
        'major' => $major,
        'status' => $status,
        'reports' => array()
      )
    ));

    $updateUni = $ERC->findOneAndUpdate($filter, $update);
    return $updateSchool;

  }

  public function addNewJob($userId, $occ, $emp, $sd, $ed, $rsn)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $WRC = $db->workRecords;
    $id = new MongoDB\BSON\ObjectId();

    $ds = new MongoDB\BSON\UTCDateTime((new DateTime($sd))->getTimestamp()*1000);
    $de = new MongoDB\BSON\UTCDateTime((new DateTime($ed))->getTimestamp()*1000);


    $filter = array('personId' => $userId);
    $update = array('$addToSet' =>
     array( 'previousJobs' =>
       array(
        '_id' => $id,
        'occupation' => $occ,
        'employer' => $emp,
        'startDate' => $ds,
        'endDate' => $de,
        'reasonForLeaving' => $rsn,
      )
    ));

    $updateJobs = $WRC->findOneAndUpdate($filter, $update);
    return $updateJobs;

  }



  public function deleteSchool($userId, $schoolId, $type)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $ERC = $db->educationRecords;
    $id = new MongoDB\BSON\ObjectId($schoolId);


    if ($type == "HS") {
      $filter = array(
              'personId' => $userId,
              'highSchool._id' => $id
            );
      $update = array(
        '$pull' => array('highSchool' => array('_id' => $id))
      );

      $result = $ERC->findOneAndUpdate($filter, $update);
    } elseif ($type == "Uni") {
      $filter = array(
              'personId' => $userId,
              'university._id' => $id
            );
      $update = array(
        '$pull' => array('university' => array('_id' => $id))
      );

      $result = $ERC->findOneAndUpdate($filter, $update);
    }

    if ($result) {
      return 1; // success
    } else {
      return -1; // failed
    }


  }


    public function deleteJob($userId, $jobId)
    {
      $mongo = new MongoDB\Client;
      $db = $mongo->egov;

      $WRC = $db->workRecords;
      $id = new MongoDB\BSON\ObjectId($jobId);

        $filter = array(
                'personId' => $userId,
                'previousJobs._id' => $id
              );

        $update = array(
          '$pull' => array('previousJobs' => array('_id' => $id))
        );

        $result = $WRC->findOneAndUpdate($filter, $update);
        return $result;

    }

  public function getLastDate($array)
  {
    if (isset($array)) {
      $mostRecent= $array[0]['date'];
      $index = -1;
      foreach($array as $key => $product)
      {
        $currDate = $product['date'];
        if ($currDate > $mostRecent){
          $mostRecent = $currDate;
          $index = $key;
        }
      }
      $datetime = $mostRecent->toDateTime();
      $time=$datetime->format(DATE_RSS);
      /********************Convert time local timezone*******************/
      $dateInUTC=$time;
      $time = strtotime($dateInUTC.' UTC');
      $dateInLocal = date('l, F d, Y', $time);

      $dateKeyAndVal = array(
        'index' => $index,
        'date' => $dateInLocal
      );

      return $dateKeyAndVal;
    } else {
      echo "Date not set";
    }
  }


  public function displayDate($date)
  {
      $datetime = $date->toDateTime();
      $time=$datetime->format(DATE_RSS);
      /********************Convert time local timezone*******************/
      $dateInUTC=$time;
      $time = strtotime($dateInUTC.' UTC');
      $dateInLocal = date('Y-m-d', $time);

      return $dateInLocal;
  }

  public function getEmployerInfo($userId, $employer)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $orgsCollection = $db->organizations;

    $employerInfo = $orgsCollection->findOne(['license' => $employer]);
    return $employerInfo;
  }

  public function requestAuth($repId, $recordId, $recordType)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $usersCollection = $db->users;
    $HRC = $db->healthRecords;
    $ERC = $db->educationRecords;
    $WRC = $db->workRecords;

    $now = $this->getCurrentTime();

    $AuthRequester = array(
      '_id' => new MongoDB\BSON\ObjectId(),
      'authRequester' => $repId,
      'requestDate' => $now,
      'authorized' => false
    );

    // filter options to make sure the rep haven't requested authorization yet
    $filter = array('personId'=>$recordId, 'authorizations.authRequester' => array('$ne' => $repId));


    if ($recordType == "Healthcare") {
      $findandUpdate = $HRC->findOneAndUpdate(
        $filter,
        array('$addToSet' => array('authorizations' => $AuthRequester))
      );

    } elseif ($recordType == "Education") {
      $findandUpdate = $ERC->findOneAndUpdate(
        $filter,
        array('$addToSet' => array('authorizations' => $AuthRequester))
      );


    } elseif ($recordType == "Work") {
      $findandUpdate = $WRC->findOneAndUpdate(
        $filter,
        array('$addToSet' => array('authorizations' => $AuthRequester))
      );


    } else {
      return 0; // no record type chosen
    }

    if ($findandUpdate) {
      return 1; // request sent
    } else {
      return -1; // you have sent a request already
    }

  }

  public function displayAllRequests($repId, $recordType)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $usersCollection = $db->users;
    $HRC = $db->healthRecords;
    $ERC = $db->educationRecords;
    $WRC = $db->workRecords;


  }

  public function checkApprovals($repId, $type)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $usersCollection = $db->users;
    $HRC = $db->healthRecords;
    $ERC = $db->educationRecords;
    $WRC = $db->workRecords;

    $filter = array(
      'authorizations.authRequester' => $repId
    );


    if ($type == "Healthcare") {
      $userRecord = $HRC->find($filter);
    } elseif ($type == "Education") {
      $userRecord = $ERC->find($filter);
    } elseif ($type == "Business") {
      $userRecord = $WRC->find($filter);
    }

    $requests = array();

    foreach ($userRecord as $key => $value) {
      $requestedUserId = $value['personId'];
      $request = $value['authorizations'];


      if (isset($request)) {

          $newStatu = array(
            'userId' => $requestedUserId,
            'status' => $request[0]['authorized'],
            'date' => $this->displayDate($request[0]['requestDate'])
          );

          array_push($requests,$newStatu);

      }
    }

    return $requests;

  }

  public function authorizeRepresentative($userId, $reqId, $recordType, $userResponse)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $usersCollection = $db->users;
    $HRC = $db->healthRecords;
    $ERC = $db->educationRecords;
    $WRC = $db->workRecords;

    $block = ($userResponse == "block") ? true : false;
    $response = ($userResponse == "yes") ? true : false;

    // if the user blocked this rep, then make the auth false
    if ($block == true) {
      $response = false;
      echo "string";
    }
    if ($response == true) {
      $block = false;
      echo "string2";
    }

    echo "block is: ".$block;

    $requestId = new MongoDB\BSON\ObjectId($reqId);

    // authorization and repeat auth request will depend on user response
    // if userResponse was true then auth granted,
    // if userResponse was false then he may block the auth requester
    $newData = array(
      'authorizations.$.authorized' => $response,
      'authorizations.$.block' => $block,
      'authorizations.$.responseDate' => $this->getCurrentTime()
    );

    $update = array('$set' => $newData);

    $filterUpdate = array(
      'personId' => $userId,
      'authorizations._id' => $requestId
    );

    $filterFind = array(
      'personId' => $userId,
      'authorizations._id' => $requestId
    );



    if ($recordType == "Healthcare") {
      $findRequest = $HRC->findOne($filterFind);
      if (isset($findRequest['authorized']) && $findRequest['authorized'] == true && $response == true) {
        return -1; // this user is already authorized
      } else {
        $authorizeResult = $HRC->findOneAndUpdate($filterUpdate, $update);
      }

    } elseif ($recordType == "Education") {
      $findRequest = $ERC->findOne($filterFind);
      if (isset($findRequest['authorized']) && $findRequest['authorized'] == true && $response == true) {
        return -1; // this user is already authorized
      } else {
        $authorizeResult = $ERC->findOneAndUpdate($filterUpdate, $update);
      }
    } elseif ($recordType == "Business") {
      $findRequest = $WRC->findOne($filterFind);
      if (isset($findRequest['authorized']) && $findRequest['authorized'] == true && $response == true) {
        return -1; // this user is already authorized
      } else {
        $authorizeResult = $WRC->findOneAndUpdate($filterUpdate, $update);
      }
    } else {
      return 0; // no record type chosen
    }

    return $authorizeResult;
  }

  public function emergencyBypass($repId, $recordId, $recordType, $emergCode)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $usersCollection = $db->users;
    $HRC = $db->healthRecords;
    $ERC = $db->educationRecords;
    $WRC = $db->workRecords;

    $now = $this->getCurrentTime();

    $filter = array('personId' => $recordId);

    $bypassDoc = array(
      'repId' => $repId,
      'date' => $now
    );

    $update = array('$addToSet' =>
      array('emergencyContact.bypasses' => $bypassDoc ));

    if ($recordType == "Healthcare") {
      $record = $HRC->findOne($filter);
      $userECCode = $record['emergencyContact']['code'];
      if ($userECCode == $emergCode) {
        $bypassed = $HRC->updateOne($filter, $update);
        return $record;
      } else {
        return null; // wrong emergency code
      }
    } elseif ($recordType == "Education") {
      $record = $ERC->findOne($filter);
      $userECCode = $record['emergencyContact']['code'];
      if ($userECCode == $emergCode) {
        $bypassed = $ERC->updateOne($filter, $update);
        return $record;
      } else {
        return null; // wrong emergency code
      }
    } elseif ($recordType == "Work") {
      $record = $WRC->findOne($filter);
      $userECCode = $record['emergencyContact']['code'];
      if ($userECCode == $emergCode) {
        $bypassed = $WRC->updateOne($filter, $update);
        return $record;
      } else {
        return null; // wrong emergency code
      }
    } else {
      return null; // some error
    }
  }

  public function getInfo($value='')
  {
    # code...
  }

  public function setPassword($value='')
  {
    # code...
  }

  public function getToken($value='')
  {
    # code...
  }

  public function getCurrentTime()
  {
    $today = null;
    $now = new MongoDB\BSON\UTCDateTime((new DateTime($today))->getTimestamp()*1000);
    return $now;
  }


  public function getBMI($height, $weight)
  {
    // divide your weight in kilograms (kg) by your height in metres (m)
    $temp = $weight/($height/100);

    // then divide the answer by your height again to get your BMI
    return $temp/($height/100);
  }



  private function _validateUser()
  {
    if( !isset($_SESSION[$this->sessionName]["_id"]) )
    return;
    if( !$this->_validateUserId() )
    return;
    $this->logged_in = true;
  }


  private function _generateSalt()
  {
    $salt = null;
    while( strlen($salt) < 128 )
    $salt = $salt.uniqid(null, true);
    return substr($salt, 0, 128);
  }


}




?>
