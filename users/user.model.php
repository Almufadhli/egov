<?php
///require_once($_SERVER['DOCUMENT_ROOT']."/phpmongodb/vendor/autoload.php");
require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
echo "USERMODEL HERE";

//require_once(LIBRARY_PATH . "/templateFunctions.php");



/**
*
*/
class User
{

  private $sessionName;

  public $logged_in = false;
  public $userData;



  function __construct()
  {

    // get the session_ID and then check if it's empty (empty means no session was started)
    $sessionId = session_id();
    if(strlen($sessionId) == 0)
    throw new Exception("No session has been started.\n<br />Please add `session_start();` initially in your file before any output.");

    $mongo = new MongoDB\Client("mongodb://Almufadhli:AMsa1405747@cluster0-shard-00-00-qcbzr.mongodb.net:27017,cluster0-shard-00-01-qcbzr.mongodb.net:27017,cluster0-shard-00-02-qcbzr.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");
    $db = $mongo->egov;

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
    $mongo = new MongoDB\Client("mongodb://Almufadhli:AMsa1405747@cluster0-shard-00-00-qcbzr.mongodb.net:27017,cluster0-shard-00-01-qcbzr.mongodb.net:27017,cluster0-shard-00-02-qcbzr.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");
    $db = $mongo->egov;
    $peopleCollection = $db->people;
    $usersCollection = $db->users;

    $findIdResult = $peopleCollection->findOne(['natId' => $natid]);
    $findUserResult = $usersCollection->findOne(['username' => $user]);

    // check if the nationalID the user entered is a valid id of a person, and that the user doesn't exist already
    if ($findIdResult && !$findUserResult){
      //encrypt the password
      $hash = password_hash($psw, PASSWORD_DEFAULT, ['cost' => 10]);

      // $now specifies the time of creation
      $now = new MongoDB\BSON\UTCDateTime((new DateTime($now))->getTimestamp()*1000);

      $insertUserResult = $usersCollection->insertOne(
        ['personId'=>$natid,
        'userType'=>'ind',
        'username'=>$user,
        'email'=>$email,
        'password'=>$hash,
        'createdAt'=>$now]
      );

      return $insertUserResult;

    } elseif (!$findIdResult) {
      return -1;
    } elseif ($findUserResult) {
      return -2;
    } else {
      return $error = "You have to choose a username and a password";
    }
  }


  public function createRepUser($license, $user, $email, $psw, $person){
    $mongo = new MongoDB\Client("mongodb://Almufadhli:AMsa1405747@cluster0-shard-00-00-qcbzr.mongodb.net:27017,cluster0-shard-00-01-qcbzr.mongodb.net:27017,cluster0-shard-00-02-qcbzr.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");
    $db = $mongo->egov;
    $peopleCollection = $db->people;
    $usersCollection = $db->users;




  }

  /**
  * return true if the user was logged in succefully
  * If not, it returns (bool)false.
  *
  *	This function takes two parameters, username and password
  *
  */

  public function loginUser( $username, $password ){
    $mongo = new MongoDB\Client("mongodb://Almufadhli:AMsa1405747@cluster0-shard-00-00-qcbzr.mongodb.net:27017,cluster0-shard-00-01-qcbzr.mongodb.net:27017,cluster0-shard-00-02-qcbzr.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");
    $db = $mongo->egov;

    $peopleCollection = $db->people;
    $usersCollection = $db->users;

    // Check if the username exists
    $findUsernameResult = $usersCollection->findOne(['username' => $username]);
    // then verify the password with the password of the username in the database (it's encrypted)
    $verifyPassword = password_verify($password, $findUsernameResult['password']);
    if ($findUsernameResult && $verifyPassword){
      // if the username exists and the password is correct, get the _id
      $personId = $findUsernameResult['personId'];
      // then match that _id with the natioanlId of the person in the people collection
      $person = $peopleCollection->findOne(['natId'=>$personId]);
      // and assigned the sessionName of "this" object to its _id
      $_SESSION[$this->sessionName]["userId"] = $personId;
      $this->logged_in = true;
      // so that we can retirieve all of his/her information
      // Header(Location: dashboard.php)
      echo "Logged in";
      return true;
    } else {
      echo "Wrong password or username";
      return false;
    }
  }


  // these function are to come
  public function logoutUser($value='')
  {
    # code...
  }

  public function getUser($userId)
  {
    $mongo = new MongoDB\Client("mongodb://Almufadhli:AMsa1405747@cluster0-shard-00-00-qcbzr.mongodb.net:27017,cluster0-shard-00-01-qcbzr.mongodb.net:27017,cluster0-shard-00-02-qcbzr.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin");
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
