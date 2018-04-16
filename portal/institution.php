<!DOCTYPE html>
<html lang="en">
<head>
  <title>hospital</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 

    
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: green;
      color: white;
    }
    .active a{

        background-color: green;
    }
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height:100%;}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: white;
      height: 100%;
    }
    col-sm-7{

        background-color: white;
    }
.al{

    background-color: white;
    color: green;
    
    border: 1px solid green;
    height: 30px;
    position: center;
    float: center;
}  

.al a {

    color: green;
    direction: none;
}
    
   
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
    float:button;
      }
      .row.content {height:auto;} 
      .al{

    position: center;
 padding: 0px  20px 0px  40px;
}  
    }

    input[type=text] {
    width: 100%;
    padding: 5px 5px;
    margin: 8px 0;
    box-sizing: border-box;
}

input[type=password] {
    width: 20%;
    padding: 5px 5px;
    margin: 8px 0;
    box-sizing: border-box;
}

input[type=email] {
    width: 20%;
    padding: 5px 5px;
    margin: 8px 0;
    box-sizing: border-box;
}


select#soflow-color {
   color: white;
     width:20%;
    background-color: green;
  font-size: 12pt;
  
   height: 40px;
   text-align: center;
   position: center;
}
input[type=submit] {
    width: 20%;
    padding: 5px 5px;
    margin: 8px 0;
    box-sizing: border-box;
    color: white;
    background-color: green;
}
input[type=email] {
    width:100%;
    padding: 5px 5px;
    margin: 8px 0;
    box-sizing: border-box;
}

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
