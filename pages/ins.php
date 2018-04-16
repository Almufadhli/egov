<!DOCTYPE html>
<html lang="en">
<head>
  <title>hospital</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="C:\xampp\htdocs\Project\css\insStyle.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
      <a class="navbar-brand" href="#">Hospital A</a> <!--   THe name it will be change  by the id   we will calling name from data base -->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
          <li><a href="#"onclick="adduser()" >ADD User</a></li>
         <li><a href="#" onclick="deluser()" >Delete User </a></li>
       
         <li><a href="#"onclick="showuser()" >Show Useres</a></li>
         <li><a href="#" onclick="infouser()" >About user </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center" >
   <div class="row slideanim">
       <div id="adduser" style="display: none;"> 
    <div class="col-sm-12">


    <h4 style="background-color: green ;color: white ">Add Employee</h4>
  <form  name="" action="" method='post' >
            ID Employee :<br>  <input type="text" name="iduser">
           <br>
           ID Employee  Institution :<br>  <input type="text" name="iduser">
           <br>
           User Name: <br>  <input type="text" name="nmae">
           <br>
           Email:  <br>  <input type="email" name="email">
          <br>
        
          Code Institution <br><input type="text" name="Code" value="######">
         <br>
       
         <br>
       <input type="submit"  style="position: center; background-color:green color:white" onsubmit="return validateForm()" value="ADD">
      </form>
      </div>
      </div>
    
     
 <div id="deleteuser" style="display: none;"> 
  <div class="col-sm-12">

    <h4 style="background-color: green ;color: white ">Delete Employee </h4>
  <form  name="" action="" method='post' >
            ID Employee Institution <br>  <input type="text" name="iduser">
           <br>
           <br>
       <input type="submit"  style="position: center; background-color:green color:white" onsubmit="return validateForm()" value="DELETE">
      </form>
      </div>
      </div>
<div id="SHOW" style="display: none" > 
  <div class="col-sm-12" >
 
  <form action="#" method="get">
             <h3 style="text-align: center;">Search For </h3>
                <div class="input-group">
                
                    <input class="form-control" id="system-search" name="q" placeholder="Search for" required >
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>

      </div>
      </div>
<div id="INOF" style="display: none;"> 
  <div class="col-sm-12">
 
     <form action="#" method="get">
             <h3 style="text-align: center;">Information For </h3>
                <div class="input-group">
                
                    <input class="form-control" id="system-search" name="q" placeholder="Search for" required >
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>

      </div>
      </div>





<script>
      function adduser() {
        document.getElementById('SHOW').style.display ="none";

        document.getElementById('INOF').style.display ="none";
          document.getElementById('deleteuser').style.display ="none";
          document.getElementById('adduser').style.display ="block";
  
      }
   function deluser(){
             document.getElementById('SHOW').style.display ="none";
             document.getElementById('INOF').style.display ="none";
           document.getElementById('adduser').style.display ="none";
          document.getElementById('deleteuser').style.display ="block";
        
      
      }

            function showuser() {
       

        document.getElementById('INOF').style.display ="none";
          document.getElementById('deleteuser').style.display ="none";
          document.getElementById('adduser').style.display ="none";
           document.getElementById('SHOW').style.display ="block";
  
      }
   function infouser(){
             document.getElementById('SHOW').style.display ="none";
          
           document.getElementById('adduser').style.display ="none";
          document.getElementById('deleteuser').style.display ="none";
        
         document.getElementById('INOF').style.display ="block";
      }
      </script>

</div>

</div>
  

</body>
</html>
