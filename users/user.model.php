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
    $findUserIdResult = $usersCollection->findOne(['entityId' => $natid]);
    $findUserResult = $usersCollection->findOne(['username' => $user]);
    $findEmailResult = $usersCollection->findOne(['email' => $email]);

    // check if the nationalID the user entered is a valid id of a person, and that the user doesn't exist already
    if ($findPersonIdResult && !$findUserIdResult && !$findUserResult && !$findEmailResult){

      //encrypt the password
      $hash = password_hash($psw, PASSWORD_DEFAULT, ['cost' => 10]);

      // $now specifies the time of creation
      $now = new MongoDB\BSON\UTCDateTime((new DateTime($now))->getTimestamp()*1000);

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


  public function createRepUser($license, $id, $email, $code){
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;

    $orgsCollection = $db->organizations;
    $peopleCollection = $db->people;
    $usersCollection = $db->users;

    $findOrgResult = $orgsCollection->findOne(['license' => $license]);
    $findPersonResult = $peopleCollection->findOne(['natId' => $id]);
    $findUserResult = $usersCollection->findOne(['entityId' => $license]);

    // check if the user exists
    foreach ($findOrgResult['employees'] as $key => $value) {
      if ($value['empId'] == $id){}
        return $key;
      }
    }

    $hash = password_hash($psw, PASSWORD_DEFAULT, ['cost' => 10]);

    // $now specifies the time of creation
    $now = new MongoDB\BSON\UTCDateTime((new DateTime($now))->getTimestamp()*1000);

    // if both the organization and the person are valid
    if ($findOrgResult && $findPersonResult){
     $doc = array(
       "personId" => $id,
       "email" => $email,
       "password" => $hash,
       "CreatedAt" => $now
     );

      // check if the organization has an account, if it has, update it, if not then create it
      if ($findUserResult){

        // find the wanted document using the entityid, then make sure the personId and email doesn't exist in the DB already
        $filter = array('entityId'=>$license,
        'users.personId' => array('$ne' => $id),
        'users.email' => array('$ne' => $email));

        // what to update
        $update = array('$addToSet'=>array('users'=>$doc));

        // send query to the database
        $updateResult = $usersCollection->updateOne($filter,$update);
        return $updateResult->getModifiedCount();

      } else {
        $insertUserResult = $usersCollection->insertOne(
          ['entityId'=>$license,
          'userType'=>'rep',
          'users' => array(array(
            'personId' => $id,
            'email' => $email,
            'password' => $hash,
            'CreatedAt' => $now
          ))
          ]
        );

        return $insertUserResult->getInsertedCount();
      }
    }

    elseif (!$findOrgResult) {
      // the organization doesn't exist
      return -1;
    } elseif (!$findPersonResult) {
      // the id is Wrong
      return -2;
    } else {
      // an error occured
      return -3;
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
  $now = null;
  $now = new MongoDB\BSON\UTCDateTime((new DateTime($now))->getTimestamp()*1000);

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

    //$findOrgResult = $orgsCollection->findOne(['license' => $license]);
    $findUserResult = $usersCollection->findOne(['entityId' => $natId]);
    $hashedPass = $findUserResult['password'];

    // check if license is valid, and the id exists, and the user exists
    if ($findUserResult){

      // verify the password with the password of the username in the database (it's encrypted)
      $verifyPassword = password_verify($password, $hashedPass);

      if ($verifyPassword) {
        // and assigned the sessionName of "this" object to its _id
        $_SESSION[$this->sessionName]["userId"] = $entityId;
        $this->logged_in = true;

        return 1;
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

  // these function are to come
  public function logoutUser()
  {
    # code...
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

    $insertHRCResult = $HRC->insertOne(['personId' => $id]);
    $insertERCResult = $ERC->insertOne(['personId' => $id]);
    $insertWRCResult = $WRC->insertOne(['personId' => $id]);

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
    echo "<br><br><br>";
    var_dump($updatePersonRecords);

  }

  public function updateHealthRecord($id)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    $HRC = $db->healthRecords;
  }

  public function displayHealthRecords($id)
  {
    $mongo = new MongoDB\Client;
    $db = $mongo->egov;
    $HRC = $db->healthRecords;

    return $HRC->findOne(['personId' => $id]);
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
