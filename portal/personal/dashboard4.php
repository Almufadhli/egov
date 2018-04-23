<?php
   session_start();
   require_once(realpath(dirname(__FILE__) . "/../../users/user.model.php"));
   $User = new User();

   $mongo = new MongoDB\Client;
   $db = $mongo->egov;

   $peopleCollection = $db->people;
   $usersCollection = $db->users;
   $healthRecordsCollection = $db->healthRecords;
   $workRecordsCollection = $db->workRecords;
   $educationRecordsCollection = $db->educationRecords;

   if (isset($_SESSION['egov']['userid'])){
     $userId = $_SESSION['egov']['userid'];
     $person = $peopleCollection->findOne(['natId'=>$userId]);

     // person details //
     $firstName = $person['firstName'];
     $secondName = $person['secondName'];
     $familyName = $person['familyName'];
     $sex = $person['sex'];

     // birth data
     $birthdate = $person['birth']['date'];
     $birthplace = $person['birth']['place'];
     $birthcountry = $person['birth']['country'];

     // address details
     $addBuildNum = $person['address']['buildingNum'];
     $addStreetName = $person['address']['streetName'];
     $addDistrict = $person['address']['district'];
     $addCity = $person['address']['city'];
     $addPostalCode = $person['address']['postalCode'];
     $addAddNum = $person['address']['addNum'];

     // additional details
     $phone = $person['phone'];
     $maritalStatus = $person['maritalStatus'];
     $picture = $person['picture'];


     if (isset($person['records'])){
       $hrc = $healthRecordsCollection->findOne(['_id'=> $person['records']['hrc']]);
       $wrc = $workRecordsCollection->findOne(['_id'=> $person['records']['wrc']]);
       $erc = $educationRecordsCollection->findOne(['_id'=> $person['records']['erc']]);
     }
   } else {
     echo "Please try again";
   }

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>home user</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="./../../css/insStyle.css" rel="stylesheet" type="text/css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <style type="text/css">
         legend {
         background-color:green;
         color:#FFF;
         }
         #rc1,#rc2, #rc3, #rc4 ,#rc5,#rc6 ,#rc7 ,#rc8 ,#rc9{
         border: 1px solid green ;
         width:50% ;
         height :auto;
         }
         #rc button {
         background-color: green;
         color: white;
         }
         .mySlides {
         display:block;
         }
         .mySlides img {
         vertical-align:left;
         width:100%;
         height:200px;
         }
         .slideshow-container {
         position:relative;
         margin:auto;
         }
         .text {
         color:#f2f2f2;
         font-size:15px;
         position:absolute;
         bottom:8px;
         width:100%;
         text-align:center;
         padding:8px 12px;
         }
         #customers {
         font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
         border-collapse: collapse;
         width: 100%;
         }
         #schools td, #schools th {
         border: 1px solid #ddd;
         padding: 8px;
         }
         #schools tr:nth-child(even){background-color: #f2f2f2;}
         #schools tr:hover {background-color: #ddd;}
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
         .numbertext {
         color:#f2f2f2;
         font-size:12px;
         position:absolute;
         top:0;
         padding:8px 12px;
         }
         .dot {
         height:15px;
         width:15px;
         background-color:#bbb;
         border-radius:50%;
         display:inline-block;
         transition:background-color .6s ease;
         margin:0 2px;
         }
         .active {
         background-color:#717171;
         }
         .fade {
         -webkit-animation-name:fade;
         -webkit-animation-duration:1.5s;
         animation-name:fade;
         animation-duration:1.5s;
         }
         to {
         opacity:1;
         }
         #homehr {
         border:1px solid green;
         width:100%;
         }
         fieldset {
         display:block;
         margin-left:2px;
         margin-right:2px;
         border:2px groove (internalvalue);
         padding:.35em .75em .625em;
         }
         #rc,#rcrcoinformation {
         border:1px solid green;
         height:auto;
         width:100%;
         }
         @media only screen and max-width 300px{
         .text {
         font-size:11px;
         }
         }
         @media screen and max-width 768px{
         .col-sm-9 {
         width:100%;
         }
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
               <a class="navbar-brand" href="#myPage"><img src="./../../resources/images/logo.png" style="background-color: white ; height: 30px; width:80px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav">
                  <li style="margin-left: 120px;"><a href="#"onclick="home()" >HOME</a></li>
                  <li><a href="#" onclick="HRC()" >Health Record </a></li>
                  <li><a href="#"onclick="ERC()" >Educational Record</a></li>
                  <li><a href="#" onclick="WRC()" >Work Record </a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="./../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="container-fluid text-center" >
         <div class="row slideanim">
            <div id="adduser" >
               <div class="col-sm-2" style="border: 0px 2px 2px 2px solid green ; height: auto;" >
                  <h4 style="background-color: green ;color: white ">Welcome  <?php echo $firstName; ?></h4>
                  <p id="demo"></p>
                  <img src="<?php echo $picture; ?>" style="background-color: white ; height: 200px; width:200px;">
                  <p>phone: <?php echo $phone; ?></p>
                  <p>Address: KSA JEDDAH</p>
               </div>
            </div>
            <div class="col-sm-10">
               <div  id="home" >
                  <h4 style="background-color: green ;color: white ">Home</h4>
                  <div id="sterment">
                     <div class="slideshow-container">
                        <div class="mySlides fade">
                           <div class="numbertext">1 / 3</div>
                           <img src="./../../resources/images/ImgUp/health.jpg" >
                           <div class="text">Health Record </div>
                        </div>
                        <div class="mySlides fade">
                           <div class="numbertext">2 / 3</div>
                           <img src="./../../resources/images/ImgUp/education.jpg" >
                           <div class="text">Educational Record</div>
                        </div>
                        <div class="mySlides fade">
                           <div class="numbertext">3 / 3</div>
                           <img src="./../../resources/images/ImgUp/work.jpg" >
                           <div class="text">Work Record </div>
                        </div>
                     </div>
                     <br>
                     <div style="text-align:center">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                     </div>
                     <script>
                        var slideIndex = 0;
                        showSlides();

                        function showSlides() {
                            var i;
                            var slides = document.getElementsByClassName("mySlides");
                            var dots = document.getElementsByClassName("dot");
                            for (i = 0; i < slides.length; i++) {
                               slides[i].style.display = "none";
                            }
                            slideIndex++;
                            if (slideIndex > slides.length) {slideIndex = 1}
                            for (i = 0; i < dots.length; i++) {
                                dots[i].className = dots[i].className.replace(" active", "");
                            }
                            slides[slideIndex-1].style.display = "block";
                            dots[slideIndex-1].className += " active";
                            setTimeout(showSlides, 2000); // Change image every 2 seconds
                        }
                     </script>
                     <?php
                        // \\\\\\\ Health Information Retrival \\\\\\\\\ //

                        if (isset($hrc)){

                          $hEC = $hrc['emergencyContact'];
                          $height  = $hrc['height'];
                          $weight = $hrc['weight'];
                          $bmi = $hrc['bmi'];
                          $bloodType = $hrc['bloodType'];

                          $medicalVisits = $hrc['medicalVisits'];

                          $lastDate = $User->getLastDate($medicalVisits);
                          $keyOfLastDate = $lastDate['index'];
                          $desc = "";
                          $hospital = "Unknown";
                          $diagnosis = "Unknown";
                          $tests = array(array(
                            'testName' => null,
                            'testResult' => null
                          ));
                          $prescAction = null;
                          $prescDrugs = null;

                          if (isset($medicalVisits[$keyOfLastDate]['desc'])){
                            $desc = $medicalVisits[$keyOfLastDate]['desc'];
                          }
                          if (isset($medicalVisits[$keyOfLastDate]['hospital'])){
                            $hospital = $medicalVisits[$keyOfLastDate]['hospital'];
                          }
                          if (isset($medicalVisits[$keyOfLastDate]['diagnosis'])){
                            $diagnosis = $medicalVisits[$keyOfLastDate]['diagnosis'];
                          }


                          $allergies = $hrc['allergies'];
                          $surgeries = $hrc['surgeries'];
                          $reports = $hrc['reports'];

                        }

                         ?>
                  </div>
                  <div  class="col-sm-9" id="homehr" >
                     <h4 style="background-color: green ;color: white ">Health Record</h4>
                     <fieldset >
                        <legend style="border: 1px solid black;">Emergency Contact:</legend>
                        <td style="border: 1px solid black;">   Name: <?php echo $hEC['name']; ?> </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;">   Phone: <?php echo $hEC['phone']; ?></td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;">   Relationship: <?php echo $hEC['relationship']; ?></td>
                        <!-- //php select   -->
                        <br>
                     </fieldset>
                     <fieldset >
                        <legend style="border: 1px solid black;">General health information:</legend>
                        <td style="border: 1px solid black;"> Height: <?php echo $height; ?> cm </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> Weight: <?php echo $weight; ?> kg </td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;"> BMI: <?php echo $bmi; ?></td>
                        <!-- //php select   --> <br>
                        <td style="border:1px solid black;"> Blood Type: <?php echo $bloodType; ?></td>
                        <!-- //php select   -->
                        <br>
                     </fieldset>
                     <fieldset >
                        <legend style="border: 1px solid black;">Last Medical Visit:</legend>
                        <td style="border: 1px solid black;"> Date: <?php echo $lastDate['date'] ?> </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> Description: <?php echo $desc; ?> </td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;"> Hospital: <?php echo $hospital; ?></td>
                        <!-- //php select   --> <br>
                        <td style="border: 1px solid black;"> Diagnosis: <?php echo $diagnosis; ?></td>
                        <!-- //php select   --> <br>
                     </fieldset>
                     <fieldset >
                        <legend style="border: 1px solid black;">Last Reports:</legend>
                        <td style="border: 1px solid black;"> Date:12/4/2018 </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> From:KAU hospital</td>
                        <br>   <!-- //php select   -->
                     </fieldset>
                     <br>
                  </div>
                  <div class="col-sm-9"  id="homehr"  >
                     <h4 style="background-color: green ;color: white ">Educational Record</h4>
                     <fieldset >
                        <legend style="border: 1px solid black;">Emergency Contact:</legend>
                        <td style="border: 1px solid black;">   Name: Mohammed </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;">   Phone: 057405435</td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;">   Relationship: Brother</td>
                        <!-- //php select   -->
                        <br>
                     </fieldset>
                     <legend style="border: 1px solid black;">Current Status</legend>
                     <td>Doctor</td>
                     <!-- //php select   -->
                     <fieldset >
                        <legend style="border: 1px solid black;">Last Reports:</legend>
                        <td style="border: 1px solid black;"> Date:12/4/2018 </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> From:KAU FCIT</td>
                        <br>   <!-- //php select   -->
                     </fieldset>
                  </div>
                  <div  class="col-sm-9" id="homehr" >
                     <h4 style="background-color: green ;color: white ">Work Record</h4>
                     <fieldset >
                        <legend style="border: 1px solid black;">Emergency Contact:</legend>
                        <td style="border: 1px solid black;">   Name: Mohammed </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;">   Phone: 057405435</td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;">   Relationship: Brother</td>
                        <!-- //php select   -->
                     </fieldset>
                     <legend style="border: 1px solid black;">Information</legend>
                     <td>Current Status :Employee</td>
                     <!-- //php select   -->
                     <td>Occupation:KAU</td>
                     <td>Field:CS</td>
                     <fieldset>
                        <legend style="border: 1px solid black;">Last Reports:</legend>
                        <td style="border: 1px solid black;"> Date:12/4/2018 </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> From:KAU FCIT</td>
                        <br>   <!-- //php select   -->
                     </fieldset>
                     <br>
                  </div>
               </div>
               <!-- **************************************************************************************************  -->
               <div id="HRC" style="display: none" >
                  <h4 style="background-color: green ;color: white ">Health Record</h4>
                  <!--  <div id="sterment">
                     <img src="..\images\ImgUp\health.jpg"  style="width: 100%; height: 200px;">

                      </div>
                      <br>
                      <br>
                     -->
                  <div  class="col-sm-9" id="rc">
                     <div id="HEDIV1">
                        <table style="border: 1px solid green ;" width="100%">
                           <legend style="border: solid black;">Emergency Contact:   <a href="#" style="float: right; color: white ;font-size:14px "
                              onclick="Emedithelt()">Edit</a> </legend>
                           <tr>
                              <th style="border: 1px solid green" >Name </th>
                              <th style="border: 1px solid green" >Phone </th>
                              <th style="border: 1px solid green" >Relationship </th>
                           </tr>
                           <tr>
                              <td style="border: 1px solid black;"><?php echo $hEC['name']; ?></td>
                              <!-- //php select   -->
                              <td style="border: 1px solid black;"><?php echo $hEC['phone']; ?></td>
                              <!-- //php select   -->
                              <td style="border: 1px solid black;"><?php echo $hEC['relationship']; ?></td>
                              <!-- //php select   -->
                           </tr>
                           <br>
                        </table>
                     </div>
                     <br>
                     <!--           EDIT DIV 1            -->
                     <div id="HEDIT1"  style="display: none;">
                        <form  method="POST" action="">
                           Name: <input type="text" name="HRCECName"><br>
                           Phone :<input type="text" name="HRCECPhone"> <br>
                           Relationship: <input type="text" name="HRCECRS"><br>
                           <input type="submit" name="Emsaveed" value="save" onclick="savehelth()">
                           <a href="#" style="float: right;" onclick="cancelemhelth()">cancel</a>
                        </form>
                        <?php
                           if (isset($_POST['HRCECName']) && isset($_POST['HRCECPhone']) && isset($_POST['HRCECRS'])) {
                             $updateHREmergencyContact = $User->updateHREmCon($userId, $_POST['HRCECName'], $_POST['HRCECPhone'], $_POST['HRCECRS']);
                             echo "<script>
                             alert('Successfully updated Health Record emergency contact!');
                             window.location.href='./dashboard.php';
                             </script>";
                           }

                           ?>
                     </div>
                     <br>
                     <script>
                        function Emedithelt() {

                             document.getElementById('HEDIV1').style.display ="none";
                             document.getElementById('HEDIT1').style.display ="block";

                        }
                        function savehelth(){

                             document.getElementById('HEDIT1').style.display ="none";
                             document.getElementById('HEDIV1').style.display ="block";


                        }
                          function cancelemhelth(){

                              document.getElementById('HEDIT1').style.display ="none";
                              document.getElementById('HEDIV1').style.display ="block";

                        }
                     </script>
                     <div id="HEDIV2">
                        <legend style="border: 1px solid black;">General health information:
                           <a href="#" style="float: right; color: white ;font-size:14px "
                              onclick="Emedithelt2()">Edit</a>
                        </legend>
                        <td style="border: 1px solid black;"> Height: <?php echo $height; ?> cm</td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> Weight: <?php echo $weight; ?> kg</td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;"> BMI: <?php echo $bmi ?></td>
                        <!-- //php select   --> <br>
                        <td style="border:1px solid black;"> Blood Type: <?php echo $bloodType; ?></td>
                        <!-- //php select   -->
                     </div>
                     <br>
                     <div  id="HEDIT2" style="display: none;">
                        <form action="" method="POST">
                           Height: <input type="Number" name="height" max="220" min="50"> <br>
                           Weight: <input type="Number" name="weight" max="220" min="20"> <br>
                           <input type="submit" name="Emsaveed" value="save" onclick="savehelth2()">
                           <a href="#" style="float: right;" onclick="cancelemhelth2()">cancel</a>
                        </form>
                        <?php
                           if (isset($_POST['height']) && isset($_POST['height'])){
                             $updateHeightAndWeight = $User->updateHAndW($userId, $_POST['height'], $_POST['weight']);
                             echo "<script>
                             alert('Successfully updated height and weight!');
                             window.location.href='./dashboard.php';
                             </script>";
                           }
                            ?>
                     </div>
                     <script>
                        function Emedithelt2() {

                             document.getElementById('HEDIV2').style.display ="none";
                             document.getElementById('HEDIT2').style.display ="block";

                        }
                        function savehelth2(){

                             document.getElementById('HEDIT2').style.display ="none";
                             document.getElementById('HEDIV2').style.display ="block";


                        }
                          function cancelemhelth2(){

                              document.getElementById('HEDIT2').style.display ="none";
                              document.getElementById('HEDIV2').style.display ="block";

                        }
                     </script>
                     <fieldset >
                        <legend style="border: 1px solid black;">Last Medical:</legend>
                        <td style="border: 1px solid black;"> Visit Date:12/4/2018 </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> Visit Description:short Description </td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;"> Visit Hospital: KAU hospital</td>
                        <!-- //php select   --> <br>
                        <td style="border: 1px solid black;"> Visit Diagnosis: 13-4-2018</td>
                        <!-- //php select   --> <br>
                     </fieldset>
                     <fieldset >
                        <legend style="border: 1px solid black;">Last Reports:</legend>
                        <td style="border: 1px solid black;"> Date:12/4/2018 </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;"> From:KAU hospital</td>
                        <br>   <!-- //php select   -->
                     </fieldset>
                  </div>
                  <div class="col-sm-9"  id="rc">
                     <button onclick="report()">Reports</button>
                     <button onclick="Medical()">Medical Visit </button>
                     <button onclick="Test()">Test </button>
                     <button onclick="Chronic()">Chronic Diseases </button>
                     <button onclick="Surgeries()">Surgeries</button>
                     <button onclick="Prescriped()"> Prescriped Durges </button>
                  </div>
                  <div class="col-sm-9"  id="rc1">
                     <h4 style="background-color: green ;color: white ">Reports</h4>
                     <table style="width:100%" border="1">
                        <tr>
                           <th style="text-align: center;">Report</th>
                           <th style="text-align: center;" >Date</th>
                           <th style="text-align: center;"> From</th>
                        </tr>
                        <tr>
                           <td><a href="#">report.pdf</a></td>
                           <td>15/4/2018</td>
                           <td>KAU</td>
                        </tr>
                        <tr>
                           <td><a href="#">report.pdf</a></td>
                           <td>15/4/2018</td>
                           <td>KAU</td>
                        </tr>
                     </table>
                  </div>
                  <!-- Medical Visit -->
                  <div  class="col-sm-9"  style="display: none" id="rc2" >
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
                  </div>
                  <!-- Test -->
                  <div  class="col-sm-9" style="display: none" id="rc3" >
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
                  <!-- Chronic Diseases -->
                  <div   class="col-sm-9"  style="display: none" id="rc4" >
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
                  </div>
                  <!-- Surgeries -->
                  <div  class="col-sm-9" style="display: none" id="rc5" >
                     <h3 style="background-color: green; color: white;">Surgeries</h3>
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
                  </div>
                  <!-- Prescriped Durges -->
                  <div  class="col-sm-9"  style="display: none" id="rc6">
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
                  <script>
                     function report() {

                          document.getElementById('rc6').style.display ="none";
                          document.getElementById('rc5').style.display ="none";
                          document.getElementById('rc4').style.display ="none";
                          document.getElementById('rc3').style.display ="none";
                          document.getElementById('rc2').style.display ="none";
                          document.getElementById('rc1').style.display ="block";

                     }
                     function Medical(){
                          document.getElementById('rc1').style.display ="none";
                          document.getElementById('rc6').style.display ="none";
                          document.getElementById('rc5').style.display ="none";
                          document.getElementById('rc4').style.display ="none";
                          document.getElementById('rc3').style.display ="none";
                          document.getElementById('rc2').style.display ="block";



                     }
                       function Test(){
                          document.getElementById('rc2').style.display ="none";
                          document.getElementById('rc1').style.display ="none";
                          document.getElementById('rc6').style.display ="none";
                          document.getElementById('rc5').style.display ="none";
                          document.getElementById('rc4').style.display ="none";
                          document.getElementById('rc3').style.display ="block";

                     }

                        function Chronic() {
                          document.getElementById('rc3').style.display ="none";
                          document.getElementById('rc2').style.display ="none";
                          document.getElementById('rc1').style.display ="none";
                          document.getElementById('rc6').style.display ="none";
                          document.getElementById('rc5').style.display ="none";
                          document.getElementById('rc4').style.display ="block";


                     }
                      function Surgeries(){
                            document.getElementById('rc4').style.display ="none";
                            document.getElementById('rc3').style.display ="none";
                            document.getElementById('rc2').style.display ="none";
                            document.getElementById('rc1').style.display ="none";
                            document.getElementById('rc6').style.display ="none";
                            document.getElementById('rc5').style.display ="block";



                     }
                       function Prescriped(){
                            document.getElementById('rc5').style.display ="none";
                            document.getElementById('rc4').style.display ="none";
                            document.getElementById('rc3').style.display ="none";
                            document.getElementById('rc2').style.display ="none";
                            document.getElementById('rc1').style.display ="none";
                            document.getElementById('rc6').style.display ="block";


                     }
                  </script>
               </div>
            </div>
            <!-- *************************************************************************************************************************************************** -->
            <?php
               if (isset($erc)) {

                 $eEC = $erc['emergencyContact'];

                 if (isset($erc['currentStatus'])){
                   $currentStatus = $erc['currentStatus'];
                 }

                 if (isset($erc['highSchool'])){
                 $highSchools = $erc['highSchool'];
                 }

                 if (isset($erc['university'])){
                 $universities = $erc['university'];
                 }

                 if (isset($erc['reports'])){
                 $reports = $erc['reports'];
                 }
               }
               ?>
            <div id="ERC" style="display: none" >
               <h4 style="background-color: green ;color: white ">Education Record</h4>
               <!--  <div id="sterment">
                  <img src="..\images\ImgUp\education.jpg"  style="width: 100%; height: 200px;">


                    </div>  -->
               <div  class="col-sm-9"  id="rc" >
                  <!-- ##################################################################################################### -->
                  <div id="EDDIV1">
                     <table style="border: 1px solid green ;" width="100%">
                        <legend style="border: solid black;">Emergency Contact:   <a href="#" style="float: right; color: white ;font-size:14px "
                           onclick="Emediteud()">Edit</a> </legend>
                        <tr>
                           <th style="border: 1px solid green"> Name: </th>
                           <th style="border: 1px solid green" >Phone: </th>
                           <th style="border: 1px solid green" >Relationship: </th>
                        </tr>
                        <tr>
                           <td style="border: 1px solid black;">Mohammed</td>
                           <!-- //php select   -->
                           <td style="border: 1px solid black;">057405435</td>
                           <!-- //php select   -->
                           <td style="border: 1px solid black;">Brother</td>
                           <!-- //php select   -->
                        </tr>
                        <br>
                     </table>
                  </div>
                  <br>
                  <!--           EDIT DIV 1            -->
                  <div id="edit1"  style="display: none;">
                     <form  method="" action="">
                        Name: <input type="text" name="name"><br>
                        Phone :<input type="text" name="phone"> <br>
                        Relationship: <input type="text" name="Relationship"><br>
                        <input type="submit" name="Emsaveed" value="save" onclick="saveedu()">
                        <a href="#" style="float: right;" onclick="cancelemedu()">cancel</a>
                     </form>
                  </div>
                  <br>
                  <br>
                  <script>
                     function Emediteud() {

                          document.getElementById('EDDIV1').style.display ="none";
                          document.getElementById('edit1').style.display ="block";

                     }
                     function saveedu(){

                          document.getElementById('edit1').style.display ="none";
                          document.getElementById('EDDIV1').style.display ="block";


                     }
                       function cancelemedu(){

                           document.getElementById('edit1').style.display ="none";
                           document.getElementById('EDDIV1').style.display ="block";

                     }
                  </script>
                  <!-- ##################################################################################################### -->
                  <div id="EDDIV2">
                     <table style="border: 1px solid green ;" width="100%">
                        <legend style="border: 1px solid black; background-color: green ;color: white">Current Status  <a href="#" style="float: right; color: white;font-size:14px " onclick="Emediteud1()">Edit</a></legend>
                        <tr style="border: 1px solid green">
                           <td style="border: 1px solid green"><?php echo $currentStatus; ?></td>
                        </tr>
                     </table>
                  </div>
                  <br>
                  <!--           EDIT DIV2            -->
                  <div id="edit2"  style="display: none;">
                     <form method="POST" action="">
                        Current Status:
                        <select name="currentStatus">
                           <option value="Student">Student</option>
                           <option value="Graduate">Graduated</option>
                           <option value="Dropout">Dropout</option>
                           <option value="None">None</option>
                        </select>
                        <input type="submit" name="Emsaveed" value="save" onclick="saveedu1()">
                        <a href="#" style="float: right;" onclick="cancelemedu1()">cancel</a>
                     </form>
                     <?php
                        $statusOption = isset($_POST['currentStatus']) ? $_POST['currentStatus'] : false;
                         if ($statusOption) {
                           $updateStatus = $User->updateEducationStatus($userId, $statusOption);
                           echo "<script>
                           alert('Successfully updated status!');
                           window.location.href='./dashboard.php';
                           </script>";
                         }

                         ?>
                  </div>
                  <script>
                     function Emediteud1() {

                          document.getElementById('EDDIV2').style.display ="none";
                          document.getElementById('edit2').style.display ="block";

                     }
                     function saveedu1(){

                          document.getElementById('edit2').style.display ="none";
                          document.getElementById('EDDIV2').style.display ="block";


                     }
                       function cancelemedu1(){

                           document.getElementById('edit2').style.display ="none";
                           document.getElementById('EDDIV2').style.display ="block";

                     }
                  </script>
                  <br>
                  <!--
                     <table style="border: 1px solid green ;" width="100%">
                      <legend style="border: 1px solid black;">Highschools attended<a href="#" style="float: right; color: white; font-size:14px " onclick="highscoolediteud()">Edit</a></legend>
                      <tr>
                      <th style="border: 1px solid green" >#</th>
                      <th style="border: 1px solid green">School Name</th>
                      <th style="border: 1px solid green">Start Date </th>
                      <th style="border: 1px solid green">End Date </th>
                      <th style="border: 1px solid green">Status </th>
                      </tr>
                      <tr>
                      <th style="border: 1px solid green" >#</th>
                      <th style="border: 1px solid green">School Name</th>
                      <th style="border: 1px solid green">Start Date </th>
                      <th style="border: 1px solid green">End Date </th>
                      <th style="border: 1px solid green">Status </th>
                      </tr>
                     </table> -->
                  <!-- ##################################################################################################### -->
                  <div id="EDDIV3">
                     <?php
                        echo "<table id='schools'>";
                        echo "<legend style='border: 1px solid black;'>Highschools Attended</legend>";
                        echo "<tr>";
                        echo "<th style='border: 1px solid green ;'>#</th>";
                        echo "<th style='border: 1px solid green ;'>School Name</th>";
                        echo "<th style='border: 1px solid green ;'>Date Started</th>";
                        echo "<th style='border: 1px solid green ;'>Date Ended</th>";
                        echo "<th style='border: 1px solid green ;'>Status</th>";
                        echo "</tr>";
                        $index = 1;
                        foreach ($highSchools as $key => $value) {
                          echo "<tr>";
                          echo "<td style='border: 1px solid green ;'>".$index++."</td>";
                          echo "<td style='border: 1px solid green ;'>".$value['schoolName']."</td>";
                          echo "<td style='border: 1px solid green ;'>".$User->displayDate($value['dateStarted'])."</td>";
                          echo "<td style='border: 1px solid green ;'>".$User->displayDate($value['dateEnded'])."</td>";
                          echo "<td style='border: 1px solid green ;'>".$value['status']."</td>";
                          echo "</tr>";
                        }

                        echo "</table>";

                         ?>
                  </div>
                  <br>
                  <!--           EDIT DIV3            -->
                  <div id="edit3"  style="display: none;">
                     <form >
                        School Name : <input type="name" name="sname[]"> <br>
                        From :  <input type="date" name="datefrom[]"> <br>
                        TO : <input type="date" name="dateto[]"><br>
                        Location :  <input type="Address" name="Address[]"><br>
                        <br>
                        <input type="submit" name="Emsaveed" value="save" onclick="saveedu2()">
                        <a href="#" style="float: right;" onclick="cancelemedu2()">cancel</a>
                        <br>
                        <br>
                     </form>
                  </div>
                  <script>
                     function highscoolediteud() {

                          document.getElementById('EDDIV3').style.display ="none";
                          document.getElementById('edit3').style.display ="block";

                     }
                     function saveedu2(){

                          document.getElementById('edit3').style.display ="none";
                          document.getElementById('EDDIV3').style.display ="block";


                     }
                       function cancelemedu2(){

                           document.getElementById('edit3').style.display ="none";
                           document.getElementById('EDDIV3').style.display ="block";

                     }
                  </script>
                  <!-- ##################################################################################################### -->
                  <div id="EDDIV4">
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
                        <td style="border: 1px solid green">nameselect</td>
                        <td style="border: 1px solid green" >fromselect</td>
                        <td  style="border: 1px solid green">to select</td>
                        <td style="border: 1px solid green">degree</td>
                        <td style="border: 1px solid green">gpa</td>
                        <td style="border: 1px solid green" >major </td>
                        <td style="border: 1px solid green">staus</td>
                     </table>
                  </div>
                  <br>
                  <!--           EDIT DIV4            -->
                  <div id="edit4"  style="display: none;">
                     <form>
                        Name        <input type="text" name="namecollage[]"> <br>
                        from Date   <input type="date" name="datefrom2[]"> <br>
                        to Date     <input type="date" name="dateto2[]"> <br>
                        degree
                        <select name="degree[]">
                           <br>
                           <option value="1"> D</option>
                           <br>
                           <option value="1"> B</option>
                           <br>
                           <option value="1"> M</option>
                           <br>
                           <option value="1">PHD</option>
                           <br>
                        </select>
                        gpa            <input type="Number" name="gba[]" max="5" min="0">
                        major          <input type="text" name="major[]">
                        staus
                        <select  name="staus[]">
                           <br>
                           <option value="1"> undergraduate</option>
                           <br>
                           <option value="2"> graduate</option>
                           <br>
                        </select>
                        <input type="submit" name="Emsaveed" value="save" onclick="saveedu3()">
                        <a href="#" style="float: right;" onclick="cancelemedu3()">cancel</a>
                     </form>
                  </div>
                  <script>
                     function collageediteud() {

                          document.getElementById('EDDIV4').style.display ="none";
                          document.getElementById('edit4').style.display ="block";

                     }
                     function saveedu3(){

                          document.getElementById('edit4').style.display ="none";
                          document.getElementById('EDDIV4').style.display ="block";


                     }
                       function cancelemedu3(){

                           document.getElementById('edit4').style.display ="none";
                           document.getElementById('EDDIV4').style.display ="block";

                     }
                  </script>
                  <!-- ##################################################################################################### -->
                  <div id="EDDIV5">
                     <table style="border: 1px solid green ;" width="100%">
                        <legend style="border: 1px solid black;">Last Reports:</legend>
                        <tr>
                           <th style="border: 1px solid green" > Date </th>
                           <th style="border: 1px solid green" >From </th>
                        </tr>
                        <td style="border: 1px solid black;"> 12/4/2018 </td>
                        <!-- //php select   -->
                        <td style="border: 1px solid black;"> KAU FCIT</td>
                        <!-- //php select   -->
                     </table>
                  </div>
                  <!-- ##################################################################################################### -->
               </div>
               <!--  #################################################################################### -->
               <div class="col-sm-9"  id="rc">
                  <h4 style="background-color: green ;color: white ">Reports</h4>
                  <table style="width:100%" border="1">
                     <tr>
                        <th style="text-align: center;">Report</th>
                        <th style="text-align: center;" >Date</th>
                        <th style="text-align: center;"> From</th>
                     </tr>
                     <tr>
                        <td><a href="#">report.pdf</a></td>
                        <td>15/4/2018</td>
                        <td>KAU</td>
                     </tr>
                     <tr>
                        <td><a href="#">report.pdf</a></td>
                        <td>15/4/2018</td>
                        <td>KAU</td>
                     </tr>
                  </table>
               </div>
            </div>
            <!-- ***************************************************************************************************** -->
            <div id="WRC" style="display: none" >
               <h4 style="background-color: green ;color: white ">Work Record</h4>
               <div id="sterment">
                  <!--    <img src="..\images\ImgUp\work.jpg" style="width: 100%; height: 200px;">   -->
               </div>
               <div  class="col-sm-9"  id="rc">
                  <div id="em">
                     <fieldset >
                        <legend style="border: 1px solid black;">Emergency Contact: <a href="#" style="float: right; color: white ; font-size: 14px;" onclick="Emedit()">Edit</a></legend>
                        <td style="border: 1px solid black;">   Name: Mohammed </td>
                        <br><!-- //php select   -->
                        <td style="border: 1px solid black;">   Phone: 057405435</td>
                        <br>   <!-- //php select   -->
                        <td style="border: 1px solid black;">   Relationship: Brother</td>
                        <!-- //php select   -->
                     </fieldset>
                  </div>
                  <div id="eme"  style="display: none;">
                     <form method="post" action="#">
                        <!-- edit form work -->
                        <fieldset >
                           <legend style="border: 1px solid black;">Emergency Contact: </legend>
                           <td style="border: 1px solid black;">   Name:<input type="text" name="Emname"></td>
                           <br><!-- //php insert  -->
                           <td style="border: 1px solid black;">   Phone:<br> <input type="phone" name="Emphone"> </td>
                           <!-- //php insert   -->
                           <td style="border: 1px solid black;">   Relationship:<br><input type="text" name=" Relationship"></td>
                           <!-- //php insert   -->
                        </fieldset>
                        <input type="submit" name="send" value="Save">
                        <a href="#" style="float: right;" onclick="Emsave()"></a>
                        <a href="#" style="float: right;" onclick="Emcancel()">cancel</a>
                     </form>
                  </div>
                  <br>
                  <br>
                  <script>
                     function Emedit() {
                          document.getElementById('em').style.display ="none";
                         document.getElementById('eme').style.display ="block";

                     }
                       function Emsave() {
                          document.getElementById('eme').style.display ="none";
                         document.getElementById('em').style.display ="block";

                     }
                       function Emcancel() {
                          document.getElementById('eme').style.display ="none";
                          document.getElementById('em').style.display ="block";

                     }
                  </script>
                  <legend style="border: 1px solid black;">Information</legend>
                  <td>Current Status :Employee</td>
                  <!-- //php select   -->
                  <br>
                  <td>Occupation:KAU</td>
                  <br>
                  <td>Field:CS</td>
                  <fieldset >
                     <legend style="border: 1px solid black;">Last Reports:</legend>
                     <td style="border: 1px solid black;"> Date:12/4/2018 </td>
                     <br><!-- //php select   -->
                     <td style="border: 1px solid black;"> From:KAU FCIT</td>
                     <br>   <!-- //php select   -->
                  </fieldset>
               </div>
               <div class="col-sm-9"   id="rc">
                  <button  onclick="report2()"> Reports </button>
                  <button onclick="previous()">previousJobs </button>
               </div>
               <div class="col-sm-9"   id="rc7">
                  <h4 style="background-color: green ;color: white ">Reports</h4>
                  <table style="width:100%" border="1">
                     <tr>
                        <th style="text-align: center;">Report</th>
                        <th style="text-align: center;" >Date</th>
                        <th style="text-align: center;"> From</th>
                     </tr>
                     <tr>
                        <td><a href="#">report.pdf</a></td>
                        <td>15/4/2018</td>
                        <td>KAU</td>
                     </tr>
                     <tr>
                        <td><a href="#">report.pdf</a></td>
                        <td>15/4/2018</td>
                        <td>KAU</td>
                     </tr>
                  </table>
               </div>
               <div class="col-sm-9"   id="rc8"  style="display: none;">
                  <legend style="border: 1px solid black;">previous Jobs <a href="#" style="float: right; color: white ; font-size: 14px;" onclick="previous2()">Edit</a></legend>
                  <table style="width:100%" border="1">
                     <tr>
                        <th style="text-align: center;">Occupation</th>
                        <th style="text-align: center;" >Employer</th>
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
               <script>
                  function report2() {
                      document.getElementById('rc9').style.display ="none";
                       document.getElementById('rc8').style.display ="none";
                      document.getElementById('rc7').style.display ="block";

                  }
                    function previous() {
                          document.getElementById('rc9').style.display ="none";
                       document.getElementById('rc7').style.display ="none";
                       document.getElementById('rc8').style.display ="block";

                  }

               </script>
               <script>
                  function previous2() {
                     document.getElementById('rc8').style.display ="none";
                     document.getElementById('rc9').style.display ="block";
                  }


               </script>
               <div class="col-sm-9"   id="rc9" style="display: none;">
                  <form>
                     <script type='text/javascript'>
                        function addjobs(){
                        // Number of inputs to create
                        var number = document.getElementById("Jobs").value;
                        // Container <div> where dynamic content will be placed
                        var containerjob = document.getElementById("jobcontainer");
                        // Clear previous contents of the container
                        while (containerjob.hasChildNodes()) {
                          containerjob.removeChild(containerjob.lastChild);
                        }
                        for (i=0;i<number;i++){

                            var input = document.createElement("input");
                            input.type = "text";
                            input.name = "Jobname[]";
                            input.value ="job name";
                            var input2 = document.createElement("input");
                            input2.type = "text";
                            input2.name = "Employer[]";
                            input2.value ="Employer";
                            var input3 = document.createElement("input");
                            input3.type = "date";
                            input3.name = "sdate[]";
                            input3.value ="start date";
                            var input4 = document.createElement("input");
                            input4.type = "date";
                            input4.name = "fdate[]";
                            input4.value ="End date";

                            var input5 = document.createElement("input");
                            input5.type = "text";
                            input5.name = "Reason[]";
                            input5.value ="Reason of leaving";

                            containerjob.appendChild(input);
                            containerjob.appendChild(input2);
                            containerjob.appendChild(input3);
                            containerjob.appendChild(input4);
                            containerjob.appendChild(input5);
                            // Append a line break
                            containerjob.appendChild(document.createElement("br"));
                          }
                        }
                     </script>
                     Number previous jobs: <input type="text" id="Jobs" name="Jobs" value=""><br />
                     <a href="#" id="filljobs" onclick="addjobs()">Add Jobs</a>
                     <div id="jobcontainer"></div>
                     <input type="submit" name="send">
                     <a href="#" onclick="previous()">cancel</a>
                  </form>
                  <br>
               </div>
            </div>
         </div>
      </div>
      <script>
         function home() {
              document.getElementById('WRC').style.display ="none";
              document.getElementById('ERC').style.display ="none";
              document.getElementById('HRC').style.display ="none";
              document.getElementById('home').style.display ="block";

         }
         function HRC(){
              document.getElementById('WRC').style.display ="none";
              document.getElementById('ERC').style.display ="none";
              document.getElementById('home').style.display ="none";
              document.getElementById('HRC').style.display ="block";


         }
           function ERC(){
               document.getElementById('WRC').style.display ="none";
               document.getElementById('home').style.display ="none";
               document.getElementById('HRC').style.display ="none";
               document.getElementById('ERC').style.display ="block";


         }

         function WRC(){
               document.getElementById('ERC').style.display ="none";
               document.getElementById('home').style.display ="none";
               document.getElementById('HRC').style.display ="none";
              document.getElementById('WRC').style.display ="block";


         }

      </script>
      <script>
         var d = new Date();
         document.getElementById("demo").innerHTML = d;
      </script>
   </body>
</html>
