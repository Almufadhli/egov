<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../users/user.model.php"));
$User = new User();

// this will be used to verify that the owner has added a representative
$_SESSION['owner'] = time();

$mongo = new MongoDB\Client;
$db = $mongo->egov;


$usersCollection = $db->users;
$orgsCollection = $db->organizations;
$peopleCollection = $db->people;

if (isset($_SESSION['egov']['entityId']) && isset($_SESSION['egov']['inst'])){
  $entityId = $_SESSION['egov']['entityId'];
  $inst = $_SESSION['egov']['inst'];

    $instData = $orgsCollection->findOne(['license' => $inst]);
    if (isset($instData['name']) && isset($instData['type']) && isset($instData['field']) && isset($instData['location'])) {
      $name = $instData['name'];
      $type = $instData['type'];
      $field = $instData['field'];
      $location = $instData['location'];

  }

}



 ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $name; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="./../css/insStyle.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style media="screen">
  table {
    width: 100%;
    border: 1px solid green;
  }

 th {
   padding-top: 12px;
   padding-bottom: 12px;
   text-align: center;
   background-color: #4CAF50;
   color: white;
 }

 th, td {
    padding: 7px;
    text-align: center;
    width: auto;
    border: 1px solid green;
}


 tr:hover {background-color: #f5f5f5;}

  </style>

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" ><?php echo $name; ?></a> <!--   THe name it will be change  by the id   we will calling name from data base -->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="#"onclick="adduser()" >Assign a new representative</a></li>
         <li><a href="#" onclick="deluser()" >Unassign a representative </a></li>
         <li><a href="#"onclick="showuser()" >Show representatives</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center" >
   <div class="row slideanim">
       <div id="adduser" style="display: none;">
    <div class="col-sm-12">


    <h4 style="background-color: green ;color: white ">Assign a representative</h4>
  <form  name="" action="./repregister_action.php" method='post' >
           representative ID:<br>  <input type="text" placeholder="Enter the representative national ID" name="empid">
           <br>
           Email:  <br>  <input type="email" placeholder="Enter his email" name="email">
           <br>
           Authorization Code: <br><input type="text" placeholder="Enter a 6 digit authorization code for him" name="authcode">
           <br>
           <input type="hidden" name="ref" value="owner">
         <br>
       <input type="submit"  style="position: center; background-color:green color:white" onsubmit="return validateForm()" value="Add">
      </form>
      </div>
      </div>


 <div id="deleteuser" style="display: none;">
  <div class="col-sm-12">

    <h4 style="background-color: green ;color: white ">Delete representative </h4>
    <form  name="" action="./repdelete.php" method='post' >
            Representative ID: <br>  <input type="text" name="empid">
           <br>
           <br>
       <input type="submit"  style="position: center; background-color:green color:white" onsubmit="return validateForm()" value="DELETE">
      </form>
      </div>
      </div>
<div id="SHOW" style="display: none" >
  <div class="col-sm-12" >

  <!-- <form action="#" method="get">
             <h3 style="text-align: center;">Search For </h3>
                <div class="input-group">

                    <input class="form-control" id="system-search" name="q" placeholder="Search for" required >
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form> -->
            <h4 style="background-color: green ;color: white ">Company representatives </h4>
            <?php


            echo "<table align='center'>";

            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Code</th>";
            echo "</tr>";

            $index = 1;

            if (isset($instData['reps'])) {
            foreach ($instData['reps'] as $key => $value) {
                echo "<tr>";
                echo "<td>".$index++."</td>";
                echo "<td>".$value['repId']."</td>";

                $personData = $User->getUser($value['repId']);
                if (isset($personData)) {
                  echo "<td>".$personData['firstName']." ".$personData['familyName']."</td>";
                } else {
                  echo "<td>-</td>";
                }

                $userData = $User->getUserData($value['repId']);
                if (isset($userData)) {
                  echo "<td>".$userData['email']."</td>";
                } else {
                  echo "<td>-</td>";
                }

                echo "<td>".$value['authCode']."</td>";
                echo "</tr>";
              }

            } else {
              echo "<tr>";
              echo "<td colspan='5'>No representatives yet</td>";
              echo "</tr>";
            }


            echo "</table>";


             ?>
      </div>




      </div>





<script>
      function adduser() {
        document.getElementById('SHOW').style.display ="none";
          document.getElementById('deleteuser').style.display ="none";
          document.getElementById('adduser').style.display ="block";

      }
   function deluser(){
             document.getElementById('SHOW').style.display ="none";
           document.getElementById('adduser').style.display ="none";
          document.getElementById('deleteuser').style.display ="block";


      }

            function showuser() {

          document.getElementById('deleteuser').style.display ="none";
          document.getElementById('adduser').style.display ="none";
           document.getElementById('SHOW').style.display ="block";

      }
      </script>

</div>

</div>


</body>
</html>
