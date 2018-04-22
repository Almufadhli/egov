
<?php

session_start();
require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
$User = new User();

$mongo = new MongoDB\Client;
$db = $mongo->egov;

$peopleCollection = $db->people;
$usersCollection = $db->users;
$orgsCollection = $db->organizations;
$HealthcareRecordsCollection = $db->healthRecords;
$workRecordsCollection = $db->workRecords;
$educationRecordsCollection = $db->educationRecords;

if (isset($_SESSION['egov']['inst']) && isset($_SESSION['egov']['entityId'])){
  $repId = $_SESSION['egov']['entityId'];
  $instId = $_SESSION['egov']['inst'];

  $repUserInfo = $usersCollection->findOne(['entityId' => $repId, 'userType' => 'rep']);
  $repInfo = $peopleCollection->findOne(['natId' => $repId]);

  $instInfo = $orgsCollection->findOne(['license' => $instId]);

  if (isset($repInfo)) {
    $name = $repInfo['firstName'];
    $pic = $repInfo['picture'];
  }

  if (isset($instInfo)) {
    $instName = $instInfo['name'];
    $instType = $instInfo['field'];
  } else {
    $instName = "not name";
  }


} else {
  echo "userId is not set";
}




 ?>


 ?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>work</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
         textarea {
         resize: vertical;
         }
         button{
         background-color: green;
         color: white;
         }
         a{
         text-decoration: none;
         }
         input[type="submit"]{
         background-color: green;
         color: white;
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
         table{
         border: 1px solid green;
         width: 100%;
         }
         th{border: 1px solid green;
         text-align: center;}
         td{border: 1px solid green;}
         /* On small screens, set height to 'auto' for sidenav and grid */
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

     form.example input[type=text] {
    padding: 10px;
    font-size: 17px;
    border: 1px solid green;
    float: left;
    width: 90%;
    background: #f1f1f1;
}

form.example button {
    float: left;
    width: 10%;
    padding: 10px;
    background-color: green;
    color: white;
    font-size: 17px;
    border: 1px solid green;
    border-left: none;
    cursor: pointer;
}

form.example button:hover {
    background: green;
}

form.example::after {
    content: "";
    clear: both;
    display: table;
}
      </style>
   </head>
   <body>
      <!-- ################################################nav####################################################### -->
      <nav class="navbar navbar-inverse">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"><span class="icon-bar">
               </span><span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#">unvercity A</a>
               <!--   THe name it will be change  by the id   we will calling name from data base -->
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav">
                  <li class="active" ><a href="#" onclick="home()" style="background-color: green">HOME</a></li>
                  <li><a href="#" onclick="addrep()">Approval</a></li>
                  <li><a href="#" onclick="sor()">Show our Report</a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="./../logout.php" id="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
               </ul>
            </div>
         </div>
      </nav>




      <div class="container-fluid text-center">
         <div class="row slideanim">
            <div id="adduser" >

               <div class="col-sm-2" style="border: 0px 2px 2px 2px solid green ; height: auto;" >
                  <h4 style="background-color: green ;color: white ">Welcome Name</h4>
                  <p id="demo"></p>
                  <img src="C:\xampp\htdocs\Project\images\ImgUp/user.png" style="background-color: white ; height: 200px; width:200px;">
                  <p>Email</p>
                  <p>phone</p>
                  <p>address</p>
               </div>
               <div  id="home" class="col-md-10  sidenav" width="100%">


                  <div>
                     <form action="#" method="get">
                        <div class="input-group">
                           <input class="form-control" id="system-search" name="q" placeholder="Search for Emergency Contact:" required="required">
                           <span class="input-group-btn">
                           <button type="submit" class="btn btn-default" onclick="search()" ng-disabled="checkInputs()" >
                           <i class="glyphicon glyphicon-search"></i></button>
                           <button type="submit" class="btn btn-default" onclick="research()"><i class="glyphicon glyphicon-refresh""></i></button>
                           </span>
                        </div>
                     </form>
                  </div>
                  <!-- ############################################### ########################################################### -->
                  <div class="col-md-12  sidenav"  width="100%">
                     <div  id = "search" style="display: none;" width="100%">
                        <!--  this div  will be select information about who we want   his or her information  -->
                        <!-- if id are in DB PRINT TABLE -->
                        <table class="table table-list-search" style="border: 1px solid green" width="100%">
                           <thead style="border: 1px solid green">
                              <tr style="border: 1px solid green">
                                 <th style="border: 1px solid green ;text-align: center;">  ID </th>
                                 <th style="border: 1px solid green ;text-align: center; ">  Name </th>
                                 <th style="border: 1px solid green ;text-align: center; ">Request</th>
                                 <th style="border: 1px solid green ;text-align: center;">Emergency</th>
                                 </fieldset>
                              </tr>
                           </thead>
                           <tbody style="border: 1px solid green">
                              <tr style="border: 1px solid green">
                                 <td style="border: 1px solid green" >1111111111 </td>
                                 <!-- //php select   -->
                                 <td  style="border: 1px solid green">  Mohammed </td>
                                 <!-- //php select   -->
                                 <td style="border: 1px solid green"><button style="background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;" onclick="Request()">Request</button> </td>
                                 <td  style="border: 1px solid green"> <button style="background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;" onclick="Emergency()">Emergency</button> </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div   class="col-md-14  sidenav" id="Emergency" style="display: none; width: 100%;">
                     <table  style="border: 1px solid green" width="89%">
                        <tr style="border: 1px solid green">
                           <th style="border: 1px solid green ;text-align: center;">Name</th>
                           <th style="border: 1px solid green ;text-align: center; ">Phone </th>
                           <th style="border: 1px solid green ;text-align: center; ">Relationship</th>
                        </tr>
                        <tr style="border: 1px solid green">
                           <td  style="border: 1px solid green"> Mohammed </td>
                           <!-- //php select   -->
                           <td style="border: 1px solid green" >0571404435 </td>
                           <!-- //php select   -->
                           <td style="border: 1px solid green" >brother </td>
                           <!-- //php select   -->
                        </tr>
                     </table>

                  </div>
                  <!-- if  Emergency number are  true -->
                 </div>
               <!--  ##########################  add report page #####################################-->
               <div  class="col-md-9  sidenav" id="addrep" style="display: none;">
                  <div id="Approval">
                     <!-- select from Approval document  -->
                     <table>
                        <tr>
                           <th>ID</th>
                           <th>Status of the application</th>
                           <th>Date</th>
                           <th>Open</th>
                        </tr>
                        <tr>
                           <td>111111111111</td>
                           <td>Has approved</td>
                           <td>14/4/2018</td>
                           <td><button onclick="approved()">GO</button></td>
                        </tr>
                     </table>
                  </div>
                  <!-- display -->
                  <!-- if approved -->


                  <div   class="col-md-12  sidenav " id="Emnumberapprovel" style="display: none;" >







                     <div  class="col-md-9  sidenav " style="width:100%" id="div6">
                        <h3 style="background-color: green; color: white;">Report
                        </h3>
                        <table width="100%">
                           <tr>
                              <th>Type</th>
                              <th>Report</th>
                              <th>Date</th>
                              <th>From</th>
                           </tr>
                           <tr>
                              <!-- SELECT FROM DB -->
                              <td>aaaaa</td>
                              <td><a href="#">pdf</a></td>
                              <td> 18/4/2018</td>
                              <td>KAU H</td>
                           </tr>
                        </table>
                        <button onclick="Reportedit()">ADD</button>
                     </div>
                     <div  class="col-md-9  sidenav " style=" display:none; width:100%" id="div66">
                        <h3 style="background-color: green; color: white;">Report
                        </h3>
                        <form method="" action="">
                           Type <input type="text" name="type" required="required"><br>
                           <input type="file" name="filereport" required="required"  value="Add Report" style="text-align: center; margin:auto; margin-left: 400px;">
                           <br>
                           <input type="submit" name="send" value="send">
                           <button onclick="Reportprint()">Cancel</button>
                        </form>
                        <!-- we need cancel buttun -->
                     </div>



                        <div  class="col-md-9  sidenav " style="width:100%" id="div2">
                        <h3 style="background-color: green; color: white;">Collage</h3>

                        <table style="border: 1px solid green ;" width="100%">
                          <legend style="border: 1px solid black;">collage <a href="#" style="float: right; color: white;font-size:14px "
                            onclick="collageediteud()">Edit</a></legend>

                             <tr style="border: 1px solid green">
                             <th style="border: 1px solid green">  Name</th>
                             <th style="border: 1px solid green" >from Date </th>
                             <th style="border: 1px solid green" >to Date </th>
                             <th style="border: 1px solid green" >degree </th>
                             <th style="border: 1px solid green" >gpa </th>
                             <th style="border: 1px solid green">major</th>
                             <th style="border: 1px solid green">staus</th>
                             </tr>
                            <tr>
                             <td style="border: 1px solid green">nameselect</td>
                             <td style="border: 1px solid green" >fromselect</td>
                             <td  style="border: 1px solid green">to select</td>
                             <td style="border: 1px solid green">degree</td>
                             <td style="border: 1px solid green">gpa</td>
                             <td style="border: 1px solid green" >major </td>
                             <td style="border: 1px solid green">staus</td>
                           </tr>
                         </table>

                       </div>



                    <div  class="col-md-9  sidenav " style="width:100%" id="div4">
                         <h3 style="background-color: green; color: white;">Chronic Diseases
                         </h3>
                         <table>
                            <tr>
                               <th>Name</th>
                               <th>Description</th>
                            </tr>
                            <!-- select from db -->
                            <tr>
                               <td>name</td>
                               <td>description</td>
                            </tr>
                         </table>
                         <button onclick="ChronicDiseasesedit()">ADD</button>
                       </div>
                        <div class="col-sm-9" id="rc8" style=" width: 100%">
                                <legend style="border: 1px solid black;">previous Jobs <a href="#" style="float: right; color: white ; font-size: 14px;" onclick="previous2()">Edit</a></legend>
                                <table style="width:100%" border="1">
                                    <tr>
                                        <th style="text-align: center;">Occupation</th>
                                        <th style="text-align: center;">Employer</th>
                                        <th style="text-align: center;"> Strar date</th>
                                        <th style="text-align: center;"> End date</th>
                                        <th style="text-align: center;"> Reason of leaving</th>

                                    </tr>
                                    <tr>
                                        <td>KAU</td>
                                        <td>doctor</td>
                                        <td>0-01-2010</td>
                                        <td>0-01-2018</td>
                                        <td>Expiration of the contract</td>
                                    </tr>

                                </table>



                            </div>

                     </div>

                     <br>
                     <br>
                     <br>
                     <div>
                        <button onclick="home()" style="margin-top: 5px;">Back TO home</button>
                     </div>
                     <br>
                     <br>
                     <br>
                     <br>
                     <script>
                        function Reportedit(){
                          document.getElementById('div6').style.display ="none";
                          document.getElementById('div66').style.display ="block";

                        }
                        function Reportprint(){
                          document.getElementById('div66').style.display ="none";
                          document.getElementById('div6').style.display ="block";


                        }

                     </script>
                  </div>
               </div>


<div style="display: none;" id="sor" class="col-md-10  sidenav" width="100%">


<form class="example" action="#" method="post">
  <input type="text" placeholder="Search.." name="search">
  <button type="submit" name="search1"><i class="fa fa-search"></i></button>
</form>
</div>

         <script>
            function Emergency(){
              document.getElementById('Emergency').style.display ="block";


            }
            function newsearch(){
              document.getElementById('Emergency').style.display ="none";
              document.getElementById('search').style.display ="none";
              document.getElementById('home').style.display ="block";

            }

         </script>
         <script>

            function home(){
               document.getElementById('sor').style.display ="none";
             document.getElementById('addrep').style.display ="none";
             document.getElementById('home').style.display ="block";

            }
             function addrep(){
                document.getElementById('sor').style.display ="none";
              document.getElementById('home').style.display ="none";
              document.getElementById('addrep').style.display ="block";

            }

             function sor(){
             document.getElementById('addrep').style.display ="none";
             document.getElementById('home').style.display ="none";
              document.getElementById('sor').style.display ="block";

            }





         </script>
         <script type="text/javascript">

             function approved(){
             document.getElementById('Approval').style.display ="none";
             document.getElementById('Emnumberapprovel').style.display ="block";





            }
         </script>
         <script>
            function search() {

             document.getElementById('search').style.display ="block";

            }
            function research() {

             document.getElementById('search').style.display ="none";

            }


         </script>
         <script type="text/javascript">
            $(document).ready(function() {
              var activeSystemClass = $('.list-group-item.active');

              //something is entered in search form
              $('#system-search').keyup( function() {
               var that = this;
                  // affect all table rows on in systems table
                  var tableBody = $('.table-list-search tbody');
                  var tableRowsClass = $('.table-list-search tbody tr');
                  $('.search-sf').remove();
                  tableRowsClass.each( function(i, val) {

                      //Lower text for case insensitive
                      var rowText = $(val).text().toLowerCase();
                      var inputText = $(that).val().toLowerCase();
                      if(inputText != '')
                      {
                        $('.search-query-sf').remove();
                        tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Searching for: "'
                          + $(that).val()
                          + '"</strong></td></tr>');
                      }
                      else
                      {
                        $('.search-query-sf').remove();
                      }

                      if( rowText.indexOf( inputText ) == -1 )
                      {
                          //hide rows
                          tableRowsClass.eq(i).hide();

                        }
                        else
                        {
                          $('.search-sf').remove();
                          tableRowsClass.eq(i).show();
                        }
                      });
                  //all tr elements are hidden
                  if(tableRowsClass.children(':visible').length == 0)
                  {
                    tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No entries found.</td></tr>');
                  }
                });
               });
             </script>
             <script>
             var d = new Date();
             document.getElementById("demo").innerHTML = d;
             </script>
        </div>
       </div>
    </div>
  </body>
</html>
