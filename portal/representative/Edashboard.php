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
    $phone = $repInfo['phone'];
    $address = $repInfo['address'];
    $add = $address['city'];
  }

  if (isset($instInfo)) {
    $instName = $instInfo['name'];
    $instType = $instInfo['field'];
  } else {
    $instName = "not name";
  }

  // check his requests
  $approvalsStatus = $User->checkApprovals($repId, "Education");


} else {
  echo "userId is not set";
}




 ?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Education</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <style>

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

     form.searchreport input[type=text] {
    padding: 10px;
    font-size: 17px;
    border: 1px solid green;
    float: left;
    width: 90%;
    background: #f1f1f1;
}



form.searchreport button {
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



form.searchreport button:hover {
    background: green;
}



form.searchreport::after {
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
               <a class="navbar-brand" href="#"><?php if (isset($instName)) {
                 echo $instName;
               } ?></a>
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
                  <h4 style="background-color: green ;color: white ">Welcome <?php echo $name ?></h4>
                  <p id="demo"></p>
                  <img src="<?php echo $pic; ?>" style="background-color: white ; height: 200px; width:200px;">
                  <p><?php echo $phone; ?></p>
                  <p><?php echo $address['city']; ?></p>
               </div>
               <div  id="home" class="col-md-10  sidenav" width="100%">


                  <div>
                     <form action="#" method="post">
                        <div class="input-group">
                           <input class="form-control" id="system-search" name="repSearch" placeholder="Search for Emergency Contact:" required="required">
                           <span class="input-group-btn">
                           <button type="submit" class="btn btn-default" name="search" onclick="search()" ng-disabled="checkInputs()" >
                           <i class="glyphicon glyphicon-search"></i></button>
                           <button type="submit" class="btn btn-default" onclick="research()"><i class="glyphicon glyphicon-refresh"></i></button>
                           </span>
                        </div>
                     </form>



                  </div>

                  <?php
                  // after the rep clicks on search, basic user info will be displayed

                   if (isset($_POST['repSearch']) && isset($_POST['search'])) {
                     $searchForId = $_POST['repSearch'];

                     $findUser = $usersCollection->findOne(['entityId' => $searchForId, 'userType' => 'ind']);
                     if ($findUser) {


                       echo "<script>
                       document.getElementById('search').style.display ='block';
                       </script>";


                       // found user
                       $findPerson = $peopleCollection->findOne(['natId' => $searchForId]);
                       if ($findPerson) {
                         $searchedName = $findPerson['firstName'];
                         $searchedId = $findPerson['natId'];

                         $searchedHRCID = $findPerson['records']['hrc'];
                         $searchedERCID = $findPerson['records']['erc'];
                         $searchedWRCID = $findPerson['records']['wrc'];

                         //var_dump($searchedHRCID);

                         if ($instType == "Healthcare") {
                           $personRecord = $HealthcareRecordsCollection->findOne(['_id' => $searchedHRCID]);
                         } elseif ($instType == "Education") {
                           $personRecord = $educationRecordsCollection->findOne(['_id' => $searchedERCID]);
                         } elseif ($instType == "Work") {
                           $personRecord = $workRecordsCollection->findOne(['_id' => $searchedWRCID]);
                         } else {
                           echo "ERROR 133: No Institution type was specefied";
                         }
                         if ($personRecord) {
                           $emergencyContact = $personRecord['emergencyContact'];
                           $emConName = $emergencyContact['name'];
                           $emConPhone = $emergencyContact['phone'];
                           $emConRS = $emergencyContact['relationship'];
                         }
                       }
                     } else {
                       // no user found
                       //var_dump($findUser);
                       echo "<script>
                       document.getElementById('search').style.display ='none';
                       alert('No user found with the specefied ID');
                       window.location.href='./Edashboard.php';
                       </script>";
                     }
                   } else {
                     echo "<script>document.getElementById('search').style.display='none';</script>";
                   }

                    ?>
                  <!-- ############################################### ########################################################### -->
                  <div class="col-md-12  sidenav"  width="100%">
                     <div  id="search" style="display: block;" width="100%">
                        <!--  this div  will be select information about who we want   his or her information  -->
                        <!-- if id are in DB PRINT TABLE -->
                        <table class="table table-list-search" style="border: 1px solid green" width="100%">
                           <thead style="border: 1px solid green">
                              <tr style="border: 1px solid green">
                                 <th style="border: 1px solid green ;text-align: center;">ID </th>
                                 <th style="border: 1px solid green ;text-align: center;">Name </th>
                                 <th style="border: 1px solid green ;text-align: center; ">Request</th>
                                 <th style="border: 1px solid green ;text-align: center;">Emergency</th>
                                 </fieldset>
                              </tr>
                           </thead>
                           <tbody style="border: 1px solid green">
                              <tr style="border: 1px solid green">
                                 <td style="border: 1px solid green" ><?php if (isset($searchForId)) {
                                   echo $searchForId;
                                 } else {
                                   echo "not set";
                                 }?> </td>
                                 <!-- //php select   -->
                                 <td  style="border: 1px solid green">  <?php if (isset($searchedName)) {
                                   echo $searchedName;
                                 } else {
                                   echo "not set";
                                 }?> </td>
                                 <!-- //php select   -->
                                 <td style="border: 1px solid green"><?php if (isset($searchedName)) {
                                   echo "<form action='./requestAuth.php' method='POST'>";
                                   echo "<input style='background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;'
                                          type='submit' value='Request'>";
                                   echo "<input type='hidden' name='authRequester' value=".$repId.">";
                                   echo "<input type='hidden' name='userId' value=".$searchForId.">";
                                   echo "<input type='hidden' name='instType' value=".$instType.">";
                                   echo "</form>";
                                 } ?> </td>
                                 <td  style="border: 1px solid green"><?php if (isset($searchedName)) {
                                   echo "<button style='background-color: red; text-decoration: none; color: white ;font-size: 14px ;width:150px;'
                                   onclick='Emergency()'>Emergency
                                 </button>";
                                 } ?> </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div   class="col-md-14  sidenav" id="Emergency" style="display: none; width: 100%;">
                     <table  style="border: 1px solid green" width="89%">
                        <tr style="border: 1px solid green">
                           <th style="border: 1px solid green ;text-align: center;">Name</th>
                           <th style="border: 1px solid green ;text-align: center;">Phone </th>
                           <th style="border: 1px solid green ;text-align: center;">Relationship</th>
                        </tr>
                        <tr style="border: 1px solid green">
                           <td  style="border: 1px solid green"> <?php if (isset($emConName)) {
                            echo $emConName;
                          } else {
                            echo "not set";
                          }?> </td>
                           <!-- //php select   -->
                           <td style="border: 1px solid green" ><?php if (isset($emConPhone)) {
                            echo $emConPhone;
                          } else {
                            echo "not set";
                          }?> </td>
                           <!-- //php select   -->
                           <td style="border: 1px solid green" ><?php if (isset($emConRS)) {
                            echo $emConRS;
                          } else {
                            echo "not set";
                          }?> </td>
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
                     <!-- <table>
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
                     </table> -->


                     <?php

                     echo "<table>";
                     echo "<tr>";
                     echo "<th>ID</th>";
                     echo "<th>Status</th>";
                     echo "<th>Date</th>";
                     echo "<th>Open</th>";
                     echo "</tr>";

                     if (isset($approvalsStatus)) {
                       foreach ($approvalsStatus as $key => $value) {
                         echo "<tr>";
                         echo "<td>".$value['userId']."</td>";

                         if ($value['status'] == true) {
                           echo "<td>Approved</td>";

                           echo "<td>".$value['date']."</td>";
                           echo "<form action='' method='post'>";
                           echo "<input type='hidden' name='idOfApprovedUser' value=".$value['userId'].">";;
                           echo "<td>"."<button onclick='approved()'>Open</button>"."</td>";
                           echo "</form>";
                         } else {
                           echo "<td>Refused</td>";
                           echo "<td>".$value['date']."</td>";
                           echo "<td>-</td>";
                         }
                         echo "</tr>";
                       }
                     } else {
                       echo "<tr>";
                       echo "<td colspan='4'>No requests</td>";
                       echo "</tr>";
                     }


                     if (isset($_POST['idOfApprovedUser'])) {
                      $personEduRecord = $educationRecordsCollection -> findOne($_POST['idOfApprovedUser']);

                      $highschools = $personEduRecord['highSchool'];
                      $university = $personEduRecord['university'];
                      unset($_POST['idOfApprovedUser']);

                     }


                     echo "</table>";

                      ?>
                  </div>
                  <!-- display -->
                  <!-- if approved -->

                  <div class="" id="Emnumberapprovel" style="display: none;">

                  <div   class="col-md-12  sidenav " >
                     <div class="col-md-9  sidenav " style="width:100%" id="div1" >
                        <h3 style="background-color: green; color: white;">high school</h3>


                        <table style="border: 1px solid green ;" width="100%">
                          <legend style="border: 1px solid black;">high school <a href="#" style="float: right; color: white; font-size:14px " onclick="highscoolediteud()">Edit</a></legend>
                          <tr style="border: 1px solid green">
                           <th style="border: 1px solid green">high school Name</th>
                           <th style="border: 1px solid green" >from Date </th>
                           <th style="border: 1px solid green" >to Date </th>
                          </tr>
                          <?php

                          if (isset($personEduRecord)) {
                            echo "<tr>";

                            if (isset($highschools)) {
                              foreach ($highschools as $key => $value) {

                                  echo "<tr>";
                                  echo "<td>".$value['schoolName']."</td>";
                                  echo "<td>".$User->displayDate($value['dateStarted'])."</td>";
                                  echo "<td>".$User->displayDate($value['dateEnded'])."</td>";
                                  echo "</tr>";
                              }
                            }

                            echo "</tr>";
                          }

                           ?>
                       </table>
                      </div>
                        <div  class="col-md-9  sidenav " style="width:100%" id="div2">
                        <h3 style="background-color: green; color: white;">Collage</h3>

                        <table style="border: 1px solid green ;" width="100%">
                          <legend style="border: 1px solid black;">collage <a href="#" style="float: right; color: white;font-size:14px "
                            onclick="collageediteud()">Edit</a></legend>

                            <tr style="border: 1px solid green">
                             <th style="border: 1px solid green">Name</th>
                             <th style="border: 1px solid green">from Date </th>
                             <th style="border: 1px solid green">to Date </th>
                             <th style="border: 1px solid green">degree </th>
                             <th style="border: 1px solid green">gpa </th>
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

                              <div class="col-sm-9" id="rc8" style="width:100%;">
                               <legend style="border:1px solid green; background-color: green"> previous Jobs </legend>
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


<form class="searchreport" action=" " method="post">
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

             <script>
             var d = new Date();
             document.getElementById("demo").innerHTML = d;
             </script>
        </div>
       </div>
    </div>
  </body>
</html>
