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

 <!DOCTYPE html>
 <html lang="en">
    <head>
       <title><?php echo $instName; ?> Representative</title>
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
                <a class="navbar-brand" href="./Hdashboard.php"><?php echo $instName; ?></a>
                <!--   THe name it will be change  by the id   we will calling name from data base -->
             </div>
             <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                   <li class="active" ><a href="#" onclick="home()" style="background-color: green">HOME</a></li>
                   <li><a href="#" onclick="addrep()">Requests</a></li>
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
                   <h4 style="background-color: green ;color: white ">Welcome <?php echo $name; ?></h4>
                   <p id="demo"></p>
                   <img src=<?php echo $pic; ?> style="background-color: white ; height: 200px; width:200px;">
                </div>
                <div  id="home" class="col-md-10  sidenav" width="100%">
                       <div>
                      <form action="#" method="post">
                         <div class="input-group">
                            <input class="form-control" id="system-search" name="repSearch" placeholder="Search by national ID:" required="required">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" name="search" onclick="searchButtonAction()" ng-disabled="checkInputs()" >
                            <i class="glyphicon glyphicon-search"></i></button>
                            <button type="submit" class="btn btn-default" onclick="emergencyButtonAction()"><i class="glyphicon glyphicon-refresh"></i></button>
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
                        document.getElementById('user-found').style.display ='none';
                        alert('No user found with the specefied ID');
                        window.location.href='./Hdashboard.php';
                        </script>";
                      }
                    }

                    // print the table
                    // echo "<table class='table table-list-search'  width='100%'>";
                    // echo "<thead>";
                    // echo "<tr>";
                    // echo "<th>ID</th>";
                    // echo "<th>Name</th>";
                    // echo "<th>Request Access</th>";
                    // echo "<th>Emergency</th>";
                    // echo "</tr>";
                    // echo "</thead>";
                    // echo "<tbody>";
                    // echo "<tr>";
                    // echo "<td>".$searchedId."</td>";
                    // echo "<td>".$searchedName."</td>";
                    //
                    // // request access button
                    // echo '<td><button
                    // style="background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;"
                    // onclick="Request()">Request Access</button> </td>';
                    //
                    // // emergency button
                    // echo '<td><button
                    // style="background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;"
                    // onclick="Emergency()">Emergency</button> </td>';
                    // echo "</tr>";
                    // echo "</tbody>";
                    // echo "</table>";

                    // <table class="table table-list-search"  width="100%">
                    //    <thead >
                    //       <tr >
                    //          <th>ID </th>
                    //          <th>Name </th>
                    //          <th>Request Access</th>
                    //          <th>Emergency</th>
                    //       </tr>
                    //    </thead>
                    //    <tbody >
                    //       <tr >
                    //          <td  >1111111111 </td>
                    //          <!-- //php select   -->
                    //          <td  >  Mohammed </td>
                    //          <!-- //php select   -->
                    //          <td><button style="background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;" onclick="Request()">Request</button> </td>
                    //          <td><button style="background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;" onclick="Emergency()">Emergency</button> </td>
                    //       </tr>
                    //    </tbody>
                    // </table>
                     ?>
                   <!-- ############################################### ########################################################### -->
                   <div id="search" style="display: block;" class="col-md-12  sidenav"  width="100%">
                     <div  width="100%">
                        <!--  this div  will be select information about who we want   his or her information  -->
                        <!-- if id are in DB PRINT TABLE -->
                        <table class="table table-list-search" style="border: 1px solid green" width="100%">
                           <thead style="border: 1px solid green">
                              <tr style="border: 1px solid green">
                                 <th style="border: 1px solid green ;text-align: center;">ID </th>
                                 <th style="border: 1px solid green ;text-align: center; ">Name </th>
                                 <th style="border: 1px solid green ;text-align: center; ">Request</th>
                                 <th style="border: 1px solid green ;text-align: center;">Emergency</th>
                                 </fieldset>
                              </tr>
                           </thead>
                           <tbody style="border: 1px solid green">
                              <tr id="user-found" style="border: 1px solid green display: block;">
                                 <td style="border: 1px solid green"><?php if (isset($searchedId)) {
                                   echo $searchedId;
                                 }  ?></td>
                                 <!-- //php select   -->
                                 <td  style="border: 1px solid green"><?php if (isset($searchedName)) {
                                   echo $searchedName;
                                 } ?></td>
                                 <!-- //php select   -->
                                 <td style="border: 1px solid green">
                                   <?php if (isset($searchedName)) {
                                     echo "<form action='./requestAuth.php' method='POST'>";
                                     echo "<input style='background-color: green; text-decoration: none; color: white ;font-size: 14px ;width:150px;'
                                            type='submit' value='Request'>";
                                     echo "<input type='hidden' name='authRequester' value=".$repId.">";
                                     echo "<input type='hidden' name='userId' value=".$searchForId.">";
                                     echo "<input type='hidden' name='instType' value=".$instType.">";
                                     echo "</form>";
                                   } ?>
                                 </td>
                                 <td style="border: 1px solid green">
                                   <?php if (isset($searchedName)) {
                                     echo "<button style='background-color: red; text-decoration: none; color: white ;font-size: 14px ;width:150px;'
                                     onclick='Emergency()'>Emergency
                                   </button>";
                                   } ?>
                                    </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>


                  <div class="col-md-14  sidenav" id="Emergency" style="display: none; width: 100%;">
                     <table  style="border: 1px solid green" width="89%">
                        <tr style="border: 1px solid green">
                           <th style="border: 1px solid green ;text-align: center;">Name</th>
                           <th style="border: 1px solid green ;text-align: center; ">Phone </th>
                           <th style="border: 1px solid green ;text-align: center; ">Relationship</th>
                        </tr>
                        <tr style="border: 1px solid green">
                           <td  style="border: 1px solid green"><?php if (isset($emConName)) {
                             echo $emConName;
                           } ?></td>
                           <!-- //php select   -->
                           <td style="border: 1px solid green" ><?php if (isset($emConPhone)) {
                             echo $emConPhone;
                           } ?> </td>
                           <!-- //php select   -->
                           <td style="border: 1px solid green" ><?php if (isset($emConRS)) {
                             echo $emConRS;
                           } ?> </td>
                           <!-- //php select   -->
                        </tr>
                     </table>
                     <br>
                     <form  method="POST" action="">
                        Emergency code: <input type="text" title="Enter the user's emergency code to bypass authorization" name="Emnumber" required="required">
                        <input type="submit" name="Emnumberlogin"  value="Enter">
                        <input type="hidden" name="userId" value="<?php echo $searchForId ?>">
                        <input type="hidden" name="repId" value="<?php echo $repId ?>">
                        <input type="hidden" name="instType" value="<?php echo $instType ?>">
                        <button onclick="newsearch()">Reset</button>
                     </form>

                  </div>

                  <?php

                  if (isset($_POST['Emnumber']) && isset($_POST['Emnumberlogin'])) {
                    $emergCode = $_POST['Emnumber'];
                    $repId = $_POST['repId'];
                    $userId = $_POST['userId'];
                    $instType = $_POST['instType'];

                    $recordForEmergency = $User->emergencyBypass($repId, $userId, $instType, $emergCode);

                    //var_dump($recordForEmergency);

                    if ($recordForEmergency) {

                      if ($instType == "Healthcare") {
                        $emergHR = $recordForEmergency;
                        $height = $emergHR['height'];
                        $weight = $emergHR['weight'];
                        $bmi = $emergHR['bmi'];
                        $bloodType = $emergHR['bloodType'];

                        $medicalVisits = $emergHR['medicalVisits'];
                        $allergies = $emergHR['allergies'];
                           $foodAllerg = $allergies['foods'];
                           $drugAllerg = $allergies['drugs'];
                           $otherAllerg = $allergies['others'];
                        $surgeries = $emergHR['surgeries'];
                        $reports = $emergHR['reports'];

                      } elseif ($instType == "Education") {
                        $emergER = $recordForEmergency;


                      } elseif ($instType == "Work") {
                        $emergWR = $recordForEmergency;
                      }

                      echo "<script>
                      alert('Successfully recieved user data!');
                      document.getElementById('Emnumbertrue').style.display ='block';
                      </script>";
                    } else {
                      echo "<script>
                      alert('You entered wrong emergency code!');
                      </script>";
                    }
                  }



                   ?>

                   <!-- if  Emergency number are  true -->
                   <div   class="col-md-12  sidenav " id="Emnumbertrue" style="display: block;">




                      <div class="col-md-9  sidenav " style="width:100%" id="div1" >
                         <h3 style="background-color: green; color: white;">Information</h3>
                         <table>
                            <tr>
                               <th>height</th>
                               <td><?php if (isset($height)) {
                                 echo $height;
                               } ?></td>
                            </tr>
                            <tr>
                               <th>weight</th>
                               <td><?php if (isset($weight)) {
                                 echo $weight;
                               } ?></td>
                            </tr>
                            <tr>
                               <th>BMI</th>
                               <td><?php if (isset($bmi)) {
                                 echo $bmi;
                               } ?></td>
                            </tr>
                            <tr>
                               <th>Blood Type</th>
                               <td><?php if (isset($bloodType)) {
                                 echo $bloodType;
                               } ?></td>
                            </tr>
                         </table>
                      </div>
                      <div  class="col-md-9  sidenav " style="width:100%; display:block;" id="div2" >
                         <h3 style="background-color: green; color: white;">Medical Visits</h3>
                         <!-- select from db -->

                         <?php


                         echo "<table>";
                         echo "<tr>";
                         echo "<th style='border: 1px solid green ;'>#</th>";
                         echo "<th style='border: 1px solid green ;'>Date</th>";
                         echo "<th style='border: 1px solid green ;'>Description</th>";
                         echo "<th style='border: 1px solid green ;'>Hospital</th>";
                         echo "<th style='border: 1px solid green ;'>Diagnosis</th>";
                         echo "</tr>";
                         $index = 1;
                         foreach ($medicalVisits as $key => $value) {
                             echo "<tr>";
                             if ($value['desc'] != "") {
                               echo "<td style='border: 1px solid green ;'>".$index++."</td>";
                               echo "<td style='border: 1px solid green ;'>".$User->displayDate($value['date'])."</td>";
                               echo "<td style='border: 1px solid green ;'>".$value['desc']."</td>";
                               echo "<td style='border: 1px solid green ;'>".$value['hospital']."</td>";
                               echo "<td style='border: 1px solid green ;'>".$value['diagnosis']."</td>";
                             } else {
                               echo "<td colspan='5'>No record</td>";
                             }
                             echo "</tr>";

                         }

                         echo "</table>";

// OLD TABLE
                         // <table>
                         //    <tr>
                         //       <th>Date</th>
                         //       <th>description</th>
                         //       <th>Hospital</th>
                         //       <th>Dignosis</th>
                         //    </tr>
                         //    <tr>
                         //       <!-- SELECT FROM DB -->
                         //       <td>17/4/2018</td>
                         //       <td>SHORT DESCRIPTION </td>
                         //       <td>JAU H</td>
                         //       <td>Dignosis </td>
                         //    </tr>
                         // </table>

                          ?>
                         <button onclick="Medicaledit()">ADD</button>
                          </div>
                         <div  class="col-md-9  sidenav " style=" display:none; width:100%" id="div22">
                         <h3 style="background-color: green; color: white;">Medical Visits</h3>
                         <!-- insert into db -->
                         <form  method="" action="" name="Descriptionform">
                            <label for="Description">Description </label>
                            <br>
                            <textarea rows="1" cols="50"   charswidth="23" name="Description " form="Descriptionform" >

                             description here...</textarea>
                            <br>
                            <label for="Dignosis">Dignosis </label>
                            <input type="text" name="Dignosis" >
                              <br>
                           Test :
                           <table id="employee_table" align=center border="1px solid green;" style="width: 40%">
                            <tr id="row1">
                              <td> <input type="text" id="test" name="test[]" placeholder="Test Name" style="width: 100%;"></td><br/>
                              <td> <input type="text" id="test" name="Ruselttest[]"  placeholder="Ruselt" style="width:100%;"></td>

                            </tr>
                            </table>
                            <input type="button" onclick="add_row();" value="ADD ROW">
                            <br>
                            <hr>
                            Drugs:
                            <table id="employee_table2" align=center border="1px solid green;" style="width: 60%">
                              <tr id="row1">
                               <td> <input type="text" id="Durge" name="Durge[]" placeholder="Durge Name" style="width:100%;"></td><br/>
                               <td> <input type="text" id="Period" name="Period[]"  placeholder="Period" style="width:100%;"></td>
                               <td> <input type="text" id="Quantity" name="Quantity[]" placeholder="Quantity" style="width: 100%;"></td><br/>
                               <td> <input type="Date" id="sdate" name="sdate[]"  placeholder="Start" style="width:100%;"></td>
                               <td> <input type="Number" id="useday" name="useday[]" placeholder="Use By Day" style="width: 100%;"></td><br/>
                               </tr>
                              </table>
                               <input type="button" onclick="add_row2();" value="ADDROW">
                              <br>
                              <hr>
                              <input type="submit" name="save" value="Save">
                              <button onclick="Medicalprint()">Cancel</button>
                              </form>
                              </div>

                              <?php




                               ?>
						<!-- this div -->

						 <script type="text/javascript">
                            function add_row()
                            {
                             $rowno=$("#employee_table tr").length;
                             $rowno=$rowno+1;
                             $("#employee_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='test[]' placeholder='Test Name' style='width:100%'></td><td><input type='text' name='Ruselttest[]' placeholder='Ruselt' style='width:100%'></td><td><input type='button' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
                           }
                           function delete_row(rowno)
                           {
                             $('#'+rowno).remove();



                           }
                         </script>




                        <script type="text/javascript">
                            function add_row2()
                            {
                             $rowno=$("#employee_table2 tr").length;
                             $rowno=$rowno+1;
                             $("#employee_table2 tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='Durge[]' placeholder='Durge' style='width:100%'></td><td><input type='text' name='Period[]' placeholder='Period' style='width:100%'></td><td><input type='text' name='Quantity[]' placeholder='Quantity' style='width:100%'> </td><td><input type='date' name='sdate[]' placeholder='Start date' style='width:100%'></td><td><input type='Number' name='useday[]' placeholder='use by day' style='width:100%'></td><td><input type='button' value='DELETE' onclick=delete_row2('row"+$rowno+"')></td></tr>");
                           }
                           function delete_row2(rowno)
                           {
                             $('#'+rowno).remove();

                           }
                         </script>


                      <script type="text/javascript">
                         function yesnoCheck() {
                           if (document.getElementById('yesCheck').checked) {
                             document.getElementById('ifYes').style.visibility = 'visible';
                           }
                           else document.getElementById('ifYes').style.visibility = 'hidden';

                         }
                         function yesnoChecknew() {
                           if (document.getElementById('yesChecknew').checked) {
                             document.getElementById('ifYesnew').style.visibility = 'visible';
                           }
                           else document.getElementById('ifYesnew').style.visibility = 'hidden';

                         }

                      </script>
                      <script>
                         function Medicaledit(){
                           document.getElementById('div2').style.display ="none";
                           document.getElementById('div22').style.display ="block";

                         }
                         function Medicalprint(){
                           document.getElementById('div22').style.display ="none";
                           document.getElementById('div2').style.display ="block";


                         }

                      </script>





                      <div  class="col-md-9  sidenav " style="width:100%" id="div3">
                         <h3 style="background-color: green; color: white;">Allergies</h3>
                         <?php

                         echo '<table   width="89%">';
                        echo '<tr >';
                        echo '<th>Foods</th>';
                        echo '<th>Drugs</th>';
                        echo '<th>Others</th>';
                        echo '</tr>';

                        foreach ($allergies as $key => $allergy) {


                            echo "<tr>";
                            echo "<td>".$allergy['0']."</td>";
                            echo "<td>".$allergy['1']."</td>";
                            echo "<td>".$allergy['2']."</td>";
                            // echo "<td>$value</td>";
                            // echo "<td>$value</td>";
                            echo "</tr>";
                          // echo "<tr>";
                          // echo "<td>".$value['foods']."</td>";
                          // echo "<td>".$value['drugs']."</td>";
                          // echo "<td>".$value['others']."</td>";
                          // echo "</tr>";
                        }




                        echo '</table>';


                          ?>
                         <button onclick="Allergiesedit()">ADD</button>
                      </div>
                    <div  class="col-md-9  sidenav " style=" display:none; width:100%" id="div33">
                        <h3 style="background-color: green; color: white;">Allergies</h3>
                        <form  method="" action="">
                          Foods :<input type="text" name="Foods"><br>
                          Durge :<input type="text" name="Durge"><br>
                          Others :<input type="text" name="Others"><br>


                         <input type="submit" name="Allergies" value="submit">
                        <button onclick="Allergiesprint()">cancel</button>
                        </form>
                       </div>
                     <script>
                        function Allergiesedit(){
                          document.getElementById('div3').style.display ="none";
                          document.getElementById('div33').style.display ="block";

                        }
                        function Allergiesprint(){
                          document.getElementById('div33').style.display ="none";
                          document.getElementById('div3').style.display ="block";


                        }

                     </script>
                     <br>
                     <br>

                      <div  class="col-md-9  sidenav " style="width:100%" id="div4">
                         <h3 style="background-color: green; color: white;">Chronic Diseases
                         </h3>

                         <?php

                         // <table>
                         //    <tr>
                         //       <th>Name</th>
                         //       <th>Description</th>
                         //    </tr>
                         //    <!-- select from db -->
                         //    <tr>
                         //       <td>name</td>
                         //       <td>description</td>
                         //    </tr>
                         // </table>

                         echo "<table>";
                         echo "<tr>";
                         echo "<th>Name</th>";
                         echo "<th>Description</th>";
                         echo "</tr>";

                         if (isset($chronicDseases) && $chronicDseases[0]!=null) {
                           foreach ($chronicDseases as $key => $value) {
                             echo "<tr>";
                             echo "<td>$value</td>";
                             echo "<td>$value</td>";
                             echo "</tr>";
                           }
                         } else {
                           echo "<tr>";
                           echo "<td colspan='2'>No record</td> ";
                           echo "</tr>";
                         }

                         echo "</table>";
                          ?>


                         <button onclick="ChronicDiseasesedit()">ADD</button>
                      </div>
                      <div  class="col-md-9  sidenav " style=" display:none; width:100%" id="div44">
                         <h3 style="background-color: green; color: white;">Chronic Diseases</h3>
                         <form method="" action="">
                            Name : <input type="text" name="Diseasesname"> <br>
                            Description: <textarea rows="1" cols="25" name="Diseasesdescription"></textarea>
                            <br>
                            <input type="submit" name="save">
                         </form>
                         <button onclick="ChronicDiseasesprint()">cancel</button>
                      </div>
                      <script>
                         function ChronicDiseasesedit(){
                           document.getElementById('div4').style.display ="none";
                           document.getElementById('div44').style.display ="block";

                         }
                         function ChronicDiseasesprint(){
                           document.getElementById('div44').style.display ="none";
                           document.getElementById('div4').style.display ="block";


                         }

                      </script>
                      <div  class="col-md-9  sidenav " style="width:100%" id="div5">
                         <h3 style="background-color: green; color: white;">Surgeries
                         </h3>
                         <?php

                         // <table>
                         //    <tr>
                         //       <th>Name</th>
                         //       <th>Hospital</th>
                         //       <th>Docter</th>
                         //       <th>Date</th>
                         //    </tr>
                         //    <tr>
                         //       <td>Name</td>
                         //       <td>Hospital</td>
                         //       <td>Docter</td>
                         //       <td>Data</td>
                         //    </tr>
                         // </table>

                         echo "<table>";
                         echo "<tr>";
                         echo "<th>Name</th>";
                         echo "<th>Hospital</th>";
                         echo "<th>Docter</th>";
                         echo "<th>Date</th>";
                         echo "</tr>";

                         foreach ($surgeries as $key => $value) {
                           echo "<tr>";
                           if (isset($value['name']) && $value['name'] != "") {
                             echo "<td>".$value['name']."</td>";
                             echo "<td>".$value['hospital']."</td>";
                             echo "<td>".$value['doctor']."</td>";
                             echo "<td>".$User->displayDate($value['date'])."</td>";
                           } else {
                             echo "<td colspan='4'>No record</td>";
                           }
                           echo "</tr>";
                         }
                         echo "</table>";


                          ?>
                         <button onclick="Surgeriesedit()">ADD</button>
                      </div>
                      <div  class="col-md-9  sidenav " style=" display:none; width:100%"  id="div55">
                         <h3 style="background-color: green; color: white;">Surgeries
                         </h3>
                         <form>

                           Surgeries:<input type="text" name="surgeries" required="required">

                            <br>
                            <input type="submit" name="submit">
                            <button onclick="Surgeriesprint()">cancel</button>
                         </form>
                      </div>
                      <script>
                         function Surgeriesedit(){
                           document.getElementById('div5').style.display ="none";
                           document.getElementById('div55').style.display ="block";

                         }
                         function Surgeriesprint(){
                           document.getElementById('div55').style.display ="none";
                           document.getElementById('div5').style.display ="block";


                         }

                      </script>
                      <div  class="col-md-9  sidenav " style="width:100%"id="div6">
                         <h3 style="background-color: green; color: white;">Report
                         </h3>
                         <?php

                          echo '<table width="100%">';
                          echo '<tr>';
                          echo '<th>Type</th>';
                          echo '<th>Report</th>';
                          echo '<th>Date</th>';
                          echo '<th>From</th>';
                          echo '</tr>';
                          foreach ($reports as $key => $value) {
                            echo '<tr>';
                            if (isset($value['type']) && $value['type'] != "") {
                              echo "<td>".$value['type']."</td>";
                              echo "<td>".$value['location']."</td>";
                              echo "<td>".$value['from']."</td>";
                              echo "<td>".$User->displayDate($value['date'])."</td>";
                            } else {
                              echo "<td>No reports</td>";
                            }
                            echo '</tr>';
                          }
                          echo '</table>';


                          ?>
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
                      <div  class="col-md-9  sidenav " style="width:100%" id="div7">
                         <h3 style="background-color: green; color: white;">Tests</h3>
                         <?php

                               echo '<table>';
                              echo '<tr>';
                              echo '<th>Test Name</th>';
                              echo '<th>Test Result</th>';
                              echo '</tr>';
                              if (isset($tests)) {
                                foreach ($tests as $key => $value) {
                                  if (isset($value['testName']) && $value['testName'] != "") {
                                    echo "<td>".$value['testName']."</td>";
                                    echo "<td>".$value['testResult']."</td>";
                                  } else {
                                    echo "<td>No tests</td>";
                                  }
                                }
                              }

                              echo '</tr>';
                              echo '</table>';



                          ?>
                      </div>
                      <div  class="col-md-9  sidenav " style="width:100%" id="div8">
                         <h3 style="background-color: green; color: white;">Prescribed Drugs </h3>
                            <?php


                              echo '<table>';
                              echo '<tr>';
                              echo '<th>Drug Name</th>';
                              echo '<th>Period</th>';
                              echo '<th>Dosage</th>';
                              echo '<th>Starting Date</th>';
                              echo '<th>Times per day</th>';
                              echo '</tr>';
                              echo '<tr>';

                              if (isset($prescDrugs)) {
                                foreach ($prescDrugs as $key => $value) {
                                  if ($value['name'] != "") {
                                    echo "<td>".$value['name']."</td>";
                                    echo "<td>".$value['period']."</td>";
                                    echo "<td>".$value['dosage']."</td>";
                                    echo "<td>".$User->displayDate($value['dateStarted'])."</td>";
                                    echo "<td>".$value['timesPerDay']."</td>";
                                  } else {
                                    echo "<td>No record</td>";
                                  }
                                }
                              } else {
                                echo "<td colspan='5'>No drugs</td>";
                              }

                              echo '</tr>';
                              echo '</table>';


                             ?>

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
                      <!-- if  Emergency number are  false -->
                      <div  id="Emnumberfalse" style="display: none;">
                      </div>
                      <!-- if click Request  -->
                      <div  id="Request" style="display: none;">
                      </div>
                   </div>






                <!--  ##########################  add report page #####################################-->
                <div  class="col-md-9  sidenav" id="addrep" style="display: none;">
                   <div id="Approval">


                       Approval PAGE
                      <!-- select from Approval document  -->
                      <?php








                          // <table>
                          //    <tr>
                          //       <th>ID</th>
                      //       <th>Status of the application</th>
                      //       <th>Date</th>
                      //       <th>Open</th>
                      //    </tr>
                      //    <tr>
                      //       <td>111111111111</td>
                      //       <td>Has approved</td>
                      //       <td>14/4/2018</td>
                      //       <td><button onclick="approved()">GO</button></td>
                      //    </tr>
                      // </table>


                       ?>
                   </div>
                   <!-- display -->
                   <!-- if approved -->


                   <div   class="col-md-12  sidenav " id="Emnumberapprovel" style="display: none;" >
                      <div class="col-md-9  sidenav " style="width:100%" id="div1" >
                         <h3 style="background-color: green; color: white;">Information</h3>
                         <table>
                            <tr>
                               <th>height</th>
                               <td>172</td>
                            </tr>
                            <tr>
                               <th>weight</th>
                               <td>72</td>
                            </tr>
                            <tr>
                               <th>BMI</th>
                               <td>72</td>
                            </tr>
                            <tr>
                               <th>Blood Type</th>
                               <td>O+</td>
                            </tr>
                         </table>
                      </div>
                      <div  class="col-md-9  sidenav " style="width:100%" id="div2">
                         <h3 style="background-color: green; color: white;">Medical Visit</h3>
                         <!-- select from db -->
                         <table>
                            <tr>
                               <th>Date</th>
                               <th>description</th>
                               <th>Hospital</th>
                               <th>Dignosis</th>
                            </tr>
                            <tr>
                               <!-- SELECT FROM DB -->
                               <td>17/4/2018</td>
                               <td>SHORT DESCRIPTION </td>
                               <td>JAU H</td>
                               <td>Dignosis </td>
                            </tr>
                         </table>
                         <button onclick="Medicaledit()">ADD</button>
                      </div>
                      <div  class="col-md-9  sidenav " style=" display:none; width:100%" id="div22">
                         <h3 style="background-color: green; color: white;">Medical Visit</h3>
                         <!-- insert into db -->
                         <form  method="" action="" name="Descriptionform">
                            <label for="Description">Description </label>
                            <br>
                            <textarea rows="1" cols="50"   charswidth="23" name="Description " form="Descriptionform" >

             description here...</textarea>
                            <br>
                            <label for="Dignosis">Dignosis </label>
                            <input type="text" name="Dignosis" >
                            <br>
                            Number Test <input type="text" id="test" name="test" value=""><br/>
                            <a href="#" id="filldetails" onclick="ADDTEST()">Add</a>
                            <div id="container"> </div>
                            <script type='text/javascript'>
                               function ADDTEST(){
                               // Number of inputs to create
                               var number = document.getElementById("test").value;
                               // Container <div> where dynamic content will be placed
                               var container = document.getElementById("container");


                               // Clear previous contents of the container
                               while (container.hasChildNodes()) {
                               container.removeChild(container.lastChild);
                               }

                               for (i=0;i<number;i++){
                                 // Append a node with a random text
                                 container.appendChild(document.createTextNode("Test Name " + (i+1)));

                                 container.appendChild(document.createTextNode(" Prescriped Action" + (i+1)));

                                 container.appendChild(document.createElement("br"));
                                 var input = document.createElement("input");
                                 input.type = "text";
                                 input.name = "test[]";
                                // input.value = "Test Name"+i;

                                var inputAC = document.createElement("input");
                                inputAC.type = "text";
                                inputAC.name = "acation[]";
                                // inputAC.value= "Prescriped Action"+i;

                                container.appendChild(input);
                                container.appendChild(inputAC);
                                 // Append a line break
                                 container.appendChild(document.createElement("br"));


                               }
                               }
                            </script>
                            Prescriped durges <input type="text" id="durges" name="durges" value=""><br/>
                            <a href="#" id="filldetails" onclick="durges()">Insert</a>
                            <div id="containerB"> </div>
                            <script type='text/javascript'>
                               function durges(){
                               // Number of inputs to create
                               var number = document.getElementById("durges").value;
                               // Container <div> where dynamic content will be placed
                               var containerB = document.getElementById("containerB");


                               // Clear previous contents of the container
                               while (containerB.hasChildNodes()) {
                                 containerB.removeChild(containerB.lastChild);
                               }

                               for (i=0;i<number;i++){
                                   // Append a node with a random text
                                   containerB.appendChild(document.createTextNode("durges Name " + (i+1)));

                                   containerB.appendChild(document.createTextNode("Quantity" + (i+1)));
                                   containerB.appendChild(document.createTextNode("use by day" + (i+1)));

                                   containerB.appendChild(document.createElement("br"));
                                   var input = document.createElement("input");
                                   input.type = "text";
                                   input.name = "durgesname[]";
                                  // input.value = "Test Name"+i;

                                  var inputAC = document.createElement("input");
                                  inputAC.type = "Number";
                                  inputAC.name = "Quantity[]";
                                  // inputAC.value= "Prescriped Action"+i;


                                  var inputbyday = document.createElement("input");
                                  inputbyday.type = "Number";
                                  inputbyday.name = "byday[]";
                                  // inputAC.value= "Prescriped Action"+i;

                                  containerB.appendChild(input);
                                  containerB.appendChild(inputAC);
                                  containerB.appendChild(inputbyday);
                                   // Append a line break
                                   containerB.appendChild(document.createElement("br"));


                                 }
                               }
                            </script>
                            <input type="submit" name="save" value="Save">
                            <button onclick="Medicalprint()">Cancel</button>
                         </form>
                      </div>
                      <script type="text/javascript">
                         function yesnoCheck() {
                           if (document.getElementById('yesCheck').checked) {
                             document.getElementById('ifYes').style.visibility = 'visible';
                           }
                           else document.getElementById('ifYes').style.visibility = 'hidden';

                         }
                         function yesnoChecknew() {
                           if (document.getElementById('yesChecknew').checked) {
                             document.getElementById('ifYesnew').style.visibility = 'visible';
                           }
                           else document.getElementById('ifYesnew').style.visibility = 'hidden';

                         }

                      </script>
                      <script>
                         function Medicaledit(){
                           document.getElementById('div2').style.display ="none";
                           document.getElementById('div22').style.display ="block";

                         }
                         function Medicalprint(){
                           document.getElementById('div22').style.display ="none";
                           document.getElementById('div2').style.display ="block";


                         }

                      </script>
                      <div  class="col-md-9  sidenav " style="width:100%" id="div3">
                         <h3 style="background-color: green; color: white;">Allergies</h3>
                         <table>
                            <tr>
                               <th>Foods</th>
                               <th>Durge</th>
                               <th>Others</th>
                            </tr>
                            <tr>
                               <td>Foods</td>
                               <td>Durge</td>
                               <td>Others</td>
                            </tr>
                         </table>
                         <button onclick="Allergiesedit()">ADD</button>
                      </div>
                      <div  class="col-md-9  sidenav " style=" display:none; width:100%" id="div33">
                         <h3 style="background-color: green; color: white;">Allergies</h3>
                         <form  method="" action="">
                            <script type='text/javascript'>
                               function addFoods(){
                                 // Number of inputs to create
                                 var number = document.getElementById("Foods").value;
                                 // Container <div> where dynamic content will be placed
                                 var containerC = document.getElementById("containerC");
                                 // Clear previous contents of the container
                                 while (containerC.hasChildNodes()) {
                                   containerC.removeChild(containerC.lastChild);
                                 }
                                 for (i=0;i<number;i++){
                                     // Append a node with a random text
                                     containerC.appendChild(document.createTextNode("foods " + (i+1)));
                                     // Create an <input> element, set its type and name attributes
                                     var input = document.createElement("input");
                                     input.type = "text";
                                     input.name = "foods[]";
                                     containerC.appendChild(input);
                                     // Append a line break
                                     containerC.appendChild(document.createElement("br"));
                                   }
                                 }
                            </script>
                            Foods <input type="text" id="Foods" name="Foods" value=""><br />
                            <a href="#" id="fillfoods" onclick="addFoods()">Add Foods</a>
                            <div id="containerC"> </div>
                            <br>
                            <script type='text/javascript'>
                               function adddurge(){
                               // Number of inputs to create
                               var number = document.getElementById("Durge").value;
                               // Container <div> where dynamic content will be placed
                               var containerD = document.getElementById("containerD");
                               // Clear previous contents of the container
                               while (containerD.hasChildNodes()) {
                                 containerD.removeChild(containerD.lastChild);
                               }
                               for (i=0;i<number;i++){
                                   // Append a node with a random text
                                   containerD.appendChild(document.createTextNode("Durge " + (i+1)));
                                   // Create an <input> element, set its type and name attributes
                                   var input = document.createElement("input");
                                   input.type = "text";
                                   input.name = "Durge[]";
                                   containerD.appendChild(input);
                                   // Append a line break
                                   containerD.appendChild(document.createElement("br"));
                                 }
                               }
                            </script>
                            Durge <input type="text" id="Durge" name="Durge" value=""><br />
                            <a href="#" id="filldurge" onclick="adddurge()">Add Durge</a>
                            <div id="containerD"></div>
                            <br>
                            <script type='text/javascript'>
                               function addothers(){
                               // Number of inputs to create
                               var number = document.getElementById("Others").value;
                               // Container <div> where dynamic content will be placed
                               var containerE = document.getElementById("containerE");
                               // Clear previous contents of the container
                               while (containerE.hasChildNodes()) {
                                 containerE.removeChild(containerE.lastChild);
                               }
                               for (i=0;i<number;i++){
                                   // Append a node with a random text
                                   containerE.appendChild(document.createTextNode("Other " + (i+1)));
                                   // Create an <input> element, set its type and name attributes
                                   var input = document.createElement("input");
                                   input.type = "text";
                                   input.name = "Others[]";
                                   containerE.appendChild(input);
                                   // Append a line break
                                   containerE.appendChild(document.createElement("br"));
                                 }
                               }
                            </script>
                            Others<input type="text" id="Others" name="Others" value=""><br />
                            <a href="#" id="fillothers" onclick="addothers()">add Others</a>
                            <div id="containerE"> </div>
                            <br>
                            <input type="submit" name="submit">
                            <button onclick="Allergiesprint()">cancel</button>
                         </form>
                      </div>
                      <script>
                         function Allergiesedit(){
                           document.getElementById('div3').style.display ="none";
                           document.getElementById('div33').style.display ="block";

                         }
                         function Allergiesprint(){
                           document.getElementById('div33').style.display ="none";
                           document.getElementById('div3').style.display ="block";


                         }

                      </script>
                      <br>
                      <br>
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
                      <div  class="col-md-9  sidenav " style=" display:none; width:100%" id="div44">
                         <h3 style="background-color: green; color: white;">Chronic Diseases</h3>
                         <form method="" action="">
                            Name : <input type="text" name="Diseasesname"> <br>
                            Description: <textarea rows="1" cols="25" name="Diseasesdescription"></textarea>
                            <br>
                            <input type="submit" name="save">
                         </form>
                         <button onclick="ChronicDiseasesprint()">cancel</button>
                      </div>
                      <script>
                         function ChronicDiseasesedit(){
                           document.getElementById('div4').style.display ="none";
                           document.getElementById('div44').style.display ="block";

                         }
                         function ChronicDiseasesprint(){
                           document.getElementById('div44').style.display ="none";
                           document.getElementById('div4').style.display ="block";


                         }

                      </script>
                      <div  class="col-md-9  sidenav " style="width:100%" id="div5">
                         <h3 style="background-color: green; color: white;">Surgeries
                         </h3>
                         <table>
                            <tr>
                               <th>Name</th>
                               <th>Hospital</th>
                               <th>Docter</th>
                               <th>Date</th>
                            </tr>
                            <tr>
                               <td>Name</td>
                               <td>Hospital</td>
                               <td>Docter</td>
                               <td>Data</td>
                            </tr>
                         </table>
                         <button onclick="Surgeriesedit()">ADD</button>
                      </div>
                      <div  class="col-md-9  sidenav " style=" display:none; width:100%"  id="div55">
                         <h3 style="background-color: green; color: white;">Surgeries
                         </h3>
                         <form>
                            <script type='text/javascript'>
                               function addsurgeries(){
                               // Number of inputs to create
                               var number = document.getElementById("Surgeries").value;
                               // Container <div> where dynamic content will be placed
                               var containerF = document.getElementById("containerF");
                               // Clear previous contents of the container
                               while (containerF.hasChildNodes()) {
                               containerF.removeChild(containerF.lastChild);
                               }
                               for (i=0;i<number;i++){
                               // Append a node with a random text
                               containerF.appendChild(document.createTextNode("Surgeries " + (i+1)));
                               // Create an <input> element, set its type and name attributes
                               var input = document.createElement("input");
                               input.type = "text";
                               input.name = "surgeries[]";
                               containerF.appendChild(input);
                               // Append a line break
                               containerF.appendChild(document.createElement("br"));
                               }
                               }
                            </script>
                            Number Surgeries <input type="text" id="Surgeries" name="Surgeries" value=""><br />
                            <a href="#" id="fillsurgeries" onclick="addsurgeries()">add Surgeries</a>
                            <div id="containerF"> </div>
                            <br>
                            <input type="submit" name="submit" >
                            <button onclick="ASurgeriesprint()">cancel</button>
                         </form>
                      </div>
                      <script>
                         function Surgeriesedit(){
                           document.getElementById('div5').style.display ="none";
                           document.getElementById('div55').style.display ="block";

                         }
                         function Surgeriesprint(){
                           document.getElementById('div55').style.display ="none";
                           document.getElementById('div5').style.display ="block";


                         }

                      </script>
                      <div  class="col-md-9  sidenav " style="width:100%"id="div6">
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
                      <div  class="col-md-9  sidenav " style="width:100%" id="div7">
                         <h3 style="background-color: green; color: white;">Test</h3>
                         <table>
                            <tr>
                               <th>Test Name</th>
                               <th>Prescriped Acation </th>
                               <th>From</th>
                               <th>Date</th>
                            </tr>
                            <!-- select from db -->
                            <tr>
                               <td>Test Name</td>
                               <td>Prescriped Acation</td>
                               <td>From</td>
                               <td>Date</td>
                            </tr>
                         </table>
                      </div>
                      <div  class="col-md-9  sidenav " style="width:100%" id="div8">
                         <h3 style="background-color: green; color: white;">PRESCRIPED DURGES </h3>
                         <table>
                            <tr>
                               <th>durges Name</th>
                               <th>Quantity</th>
                               <th> use by day</th>
                            </tr>
                            <tr>
                               <td>durges Name</td>
                               <td>Quantity</td>
                               <td>use by day</td>
                            </tr>
                         </table>
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

             function Request(){
               alert("Request sent");
               newsearch();

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
             function searchButtonAction() {
              var id = document.forms["user-search"]["repSearch"].value;
              if (id == "") {
                alert("Please enter the ID first");
                return false;
              } else {
                document.getElementById('search').style.display ="block";
              }

             }
             function emergencyButtonAction() {

              document.getElementById('search').style.display ="none";

             }


          </script>
          <!-- <script type="text/javascript">
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
              </script> -->
              <script>
              var d = new Date();
              document.getElementById("demo").innerHTML = d;
              </script>
         </div>
        </div>
     </div>
   </body>
 </html>
