<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();


echo "Welcome to your dashboard<br>";


$db = $_SESSION["db"];

$peopleCollection = $db->people;
$usersCollection = $db->users;

var_dump($_SESSION);
echo "<br><br>";



if (isset($_SESSION[""]["userId"])){
  $userId = $_SESSION[""]["userId"];
  echo "Note*: Press CTRL+U to view the retrived info from the database in a readable format<br><br>";

  $person = $peopleCollection->findOne(['natId'=>$userId]);
  var_dump($person);




} else {
  echo "not set";
}
//$person = $User->getUser($_SESSION['userId']);

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
   <title>user home</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <style>

     .navbar {
       margin-bottom: 0;
       border-radius: 0;
            background-color: green;
             margin-bottom: 10px;

     }
     .row.content {
       margin-bottom: 50px;

     }

      .col-sm-2 {

       margin-left: 6px;
       border: 1px solid green;
       width: auto;
       height: 610px;
       color: white;}
       .col-sm-3 {
        margin-left: 6px;
       border: 1px solid green;
      width: auto;
      }
       .col-sm-4{
        margin-left: 6px;
       border: 1px solid green;
      width: auto;}
     .col-sm-8 text-left {

      position: center;
      border: 1px solid green ;
     margin-top: 5px;

     }
      .col-sm-5 {
       margin-left: 6px;
  border: 1px solid green;
       width: auto;}
       .col-sm-6 {
        margin-left: 6px;
     border: 1px solid green;
      width: auto;}
       .col-sm-7 {
        margin-left: 6px;
     border: 1px solid green;
      width: auto;}
       .col-sm-8 {
        margin-left: 6px;
     border: 1px solid green;
      width: auto;}
     .col-sm-8 text-left {

      position: center;
      border: 1px solid green ;
     margin-top: 20px;

     }

    .al { color:  green;
     margin-top: 20px; }

     @media screen and (max-width: 767px) {
       .sidenav {
         height: auto;
         padding: 15px;
       }
       .row.content {height:auto;}
        .col-sm-2 {

       border: 1px solid green;
       width: auto;}
       .col-sm-3 {

       border: 1px solid green;
      width: auto;}
       .col-sm-4{

       border: 1px solid green;
      width: auto;}
     }


   </style>
 </head>
 <body>

 <nav class="navbar navbar-inverse">
   <div class="container-fluid">
     <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
         <span class="icon-bar">|</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
         <a class="navbar-brand" href="#"><img src="../../images/logo.png" width="40" height="30" style="background-color: white;" ></a>
       <a class="navbar-brand" href="#">MOHAMMED Alnaqash</a>
     </div>
     <div class="collapse navbar-collapse" id="myNavbar">
       <ul class="nav navbar-nav" >
         <li class="active"><a href="pdata.html" style="background-color: green"> Personal data</a></li>
         <li class="active"><a href="#" style="background-color: green" >Work reports</a></li>
         <li class="active"><a href="health.php" style="background-color: green" >Health reports</a></li>
         <li class="active"><a href="#" style="background-color: green">Education reports</a></li>


       </ul>
       <ul class="nav navbar-nav navbar-right">
         <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
       </ul>
     </div>
   </div>
 </nav>

 <div class="container-fluid text-center">
   <div class="row content">

     <div class="col-sm-2 sidenav" style="background-color:white">
       <p class= "al">HOME</p>
        <p class= "al"><img src="/../../images/usergreen.png" style="height: 100px; width: 100px"></p>
       <p class= "al">malnqash2012@gmail.com</p>
     </div>



       <div class="col-sm-3 sidenav">
       <p class= "al">Personal data</p>
        <p class= "al"><img src="/../../images/puser.png" style="height: 100px; width: 100px" </p>

     </div>
       <div class="col-sm-4 sidenav" >
       <p class= "al">Work reports</p>
        <p class= "al"><img src="/../../images/work.png" style="height:  100px; width: 150px" ></p>

     </div>
     <div class="col-sm-5 sidenav" >
       <p class= "al">Health reports</p>
        <p class= "al"><img src="h.png"  style="height: 100px; width: 100px"></p>

     </div>
     <div class="col-sm-6 sidenav" >
       <p class= "al">Education reports</p>
        <p class= "al"><img src="edu.png"  style="height: 100px; width: 100px"></p>

     </div>
      <div class="col-sm-7 sidenav" >
       <p class= "al">Excuses</p>
        <p class= "al"><img src="excuses.png"  style="height: 100px; width: 100px"></p>

     </div>
      <div class="col-sm-8 sidenav" >
       <p class= "al">Recommendations</p>
        <p class= "al"><img src="recommend.png"  style="height: 100px; width: 100px"></p>

     </div>

       </div>



 </div>
     </body>




 </html>
