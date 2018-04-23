<?php
   include("./dashProc.php");
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>home user</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="./../../css/insStyle.css" rel="stylesheet" type="text/css">
      <link href="./../../css/dashboard.css" rel="stylesheet" type="text/css">
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
               <a class="navbar-brand" href="#myPage"><img src="./../../resources/images/logo.png" style="background-color: white ; height: 30px; width:80px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav">
                  <li style="margin-left: 120px;"><a href="#" onclick="home()">HOME</a></li>
                  <li><a href="#" onclick="HRC()">Health Record </a></li>
                  <li><a href="#" onclick="ERC()">Educational Record</a></li>
                  <li><a href="#" onclick="WRC()">Work Record </a></li>
                  <li><a href="#" onclick="Requests()">Requests</a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="./../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="container-fluid text-center">
         <div class="row slideanim">
            <div id="adduser">
               <div class="col-sm-2">
                  <h4 style="background-color: green ;color: white ">Welcome  <?php echo $firstName; ?></h4>
                  <p id="demo"></p>
                  <img src="<?php echo $picture; ?>" style="background-color: white ; height: 200px; width:200px;">
                  <p>phone:
                     <?php echo $phone; ?>
                  </p>
                  <p>Address:
                     <?php echo $addCity." ".$addPostalCode; ?>
                  </p>
               </div>
            </div>
            <div class="col-sm-10">
               <div id="home">
                  <h4 style="background-color: green ;color: white ">Home</h4>
                  <div id="sterment">
                     <div class="slideshow-container">
                        <div class="mySlides fade">
                           <div class="numbertext">1 / 3</div>
                           <img src="./../../resources/images/ImgUp/health.jpg">
                           <div class="text">Health Record </div>
                        </div>
                        <div class="mySlides fade">
                           <div class="numbertext">2 / 3</div>
                           <img src="./../../resources/images/ImgUp/education.jpg">
                           <div class="text">Educational Record</div>
                        </div>
                        <div class="mySlides fade">
                           <div class="numbertext">3 / 3</div>
                           <img src="./../../resources/images/ImgUp/work.jpg">
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
                            if (slideIndex > slides.length) {
                                slideIndex = 1
                            }
                            for (i = 0; i < dots.length; i++) {
                                dots[i].className = dots[i].className.replace(" active", "");
                            }
                            slides[slideIndex - 1].style.display = "block";
                            dots[slideIndex - 1].className += " active";
                            setTimeout(showSlides, 2000); // Change image every 2 seconds
                        }
                     </script>
                  </div>
                  <div class="col-sm-9" id="homehr">
                     <h4 style="background-color: green ;color: white ">Health Record</h4>
                     <fieldset>
                        <legend>Emergency Contact:</legend>
                        <td> Name:
                           <?php echo $hEC['name']; ?>
                        </td>
                        <td> Phone:
                           <?php echo $hEC['phone']; ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Relationship:
                           <?php echo $hEC['relationship']; ?>
                        </td>
                        <!-- //php select   -->
                        <br>
                     </fieldset>
                     <fieldset>
                        <legend>General health information:</legend>
                        <td> Height:
                           <?php echo $height; ?> cm
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Weight:
                           <?php echo $weight; ?> kg
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> BMI:
                           <?php echo $bmi; ?>
                        </td>
                        <!-- //php select   -->
                        <br>
                        <td style="border:1px solid black;"> Blood Type:
                           <?php echo $bloodType; ?>
                        </td>
                        <!-- //php select   -->
                        <br>
                     </fieldset>
                     <fieldset>
                        <legend>Last Medical Visit:</legend>
                        <td> Date:
                           <?php if (isset($desc)) {
                              echo $lastDate['date'];
                              } ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Description:
                           <?php echo $desc; ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Hospital:
                           <?php echo $hospital; ?>
                        </td>
                        <!-- //php select   -->
                        <br>
                        <td> Diagnosis:
                           <?php echo $diagnosis; ?>
                        </td>
                        <!-- //php select   -->
                        <br>
                     </fieldset>
                     <br>
                  </div>
                  <div class="col-sm-9" id="homeer">
                     <h4 style="background-color: green ;color: white ">Educational Record</h4>
                     <fieldset>
                        <legend>Emergency Contact:</legend>
                        <td> Name:
                           <?php echo $eEC['name']; ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Phone:
                           <?php echo $eEC['phone']; ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Relationship:
                           <?php echo $eEC['relationship']; ?>
                        </td>
                        <!-- //php select   -->
                        <br>
                     </fieldset>
                     <fieldset>
                        <legend>Current Status</legend>
                        <td>
                           <?php if (isset($currentStatus)) {
                              echo $currentStatus;
                              } else {
                              echo "unknown";
                              } ?>
                        </td>
                     </fieldset>
                     <fieldset>
                        <legend>Last Reports:</legend>
                        <td> Date:
                           <?php if (isset($EduReports)) {
                              echo "nothing yet";
                              } else {
                              echo "none";
                              } ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> From:
                           <?php if (isset($EduReports)) {
                              echo "nothing yet";
                              } else {
                              echo "none";
                              } ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                     </fieldset>
                  </div>
                  <div class="col-sm-9" id="homewr">
                     <h4 style="background-color: green ;color: white ">Work Record</h4>
                     <fieldset>
                        <legend>Emergency Contact:</legend>
                        <td> Name:
                           <?php echo $wEC['name']; ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Phone:
                           <?php echo $wEC['phone']; ?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Relationship:
                           <?php echo $wEC['relationship']; ?>
                        </td>
                        <!-- //php select   -->
                     </fieldset>
                     <legend>Information</legend>
                     <td>Occupation:
                        <?php echo $occupation; ?>
                     </td>
                     <fieldset>
                        <legend>Last Reports:</legend>
                        <td> Date:
                           <?php if (isset($lastDocDate)) {
                              echo $lastDocDate['date'];
                              } else {
                              echo "none";
                              }?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> From:
                           <?php if (isset($documents)) {
                              echo $documents[0]['uploadedBy'];
                              } else {
                              echo "none";
                              }?>
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td>Link:
                           <?php if (isset($documents)) {
                              $url = $documents[0]['location'];
                              echo "<a href=".$url.">".$documents[0]['docName']."</a>";
                              } else {
                              echo "none";
                              }?>
                        </td>
                        <br>
                     </fieldset>
                     <br>
                  </div>
               </div>
               <!-- **************************************************************************************************  -->
               <div id="HRC" style="display: none">
                  <h4 style="background-color: green ;color: white ">Health Record</h4>
                  <!--  <div id="sterment">
                     <img src="..\images\ImgUp\health.jpg"  style="width: 100%; height: 200px;">

                      </div>
                      <br>
                      <br>
                     -->
                  <div class="col-sm-9" id="rc">
                     <div id="HEDIV1">
                        <table style="border: 1px solid green ;" width="100%">
                           <legend style="border: solid black;">Emergency Contact: <a href="#" style="float: right; color: white ;font-size:14px " onclick="Emedithelt()">Edit</a> </legend>
                           <tr>
                              <th>Name </th>
                              <th>Phone </th>
                              <th>Relationship </th>
                           </tr>
                           <tr>
                              <td>
                                 <?php echo $hEC['name']; ?>
                              </td>
                              <!-- //php select   -->
                              <td>
                                 <?php echo $hEC['phone']; ?>
                              </td>
                              <!-- //php select   -->
                              <td>
                                 <?php echo $hEC['relationship']; ?>
                              </td>
                              <!-- //php select   -->
                           </tr>
                           <br>
                        </table>
                     </div>
                     <br>
                     <!--           EDIT DIV 1            -->
                     <div id="HEDIT1" style="display: none;">
                        <form method="POST" action="">
                           Name:
                           <input type="text" name="HRCECName">
                           <br> Phone :
                           <input type="text" name="HRCECPhone">
                           <br> Relationship:
                           <input type="text" name="HRCECRS">
                           <br> Emergency Code:
                           <input type="number" name="HRCEmConCode" value="0000" title="Set an emergency code for your record" required>
                           <input type="submit" name="Emsaveed" value="save" onclick="savehelth()">
                           <a href="#" style="float: right;" onclick="cancelemhelth()">cancel</a>
                        </form>
                        <?php
                           if (isset($_POST['HRCECName']) && isset($_POST['HRCECPhone']) && isset($_POST['HRCECRS']) && isset($_POST['HRCEmConCode'])) {
                             $updateHREmergencyContact = $User->updateHREmCon($userId,
                             $_POST['HRCECName'],
                             $_POST['HRCECPhone'],
                             $_POST['HRCECRS'],
                             $_POST['HRCEmConCode']
                           );
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

                            document.getElementById('HEDIV1').style.display = "none";
                            document.getElementById('HEDIT1').style.display = "block";

                        }

                        function savehelth() {

                            document.getElementById('HEDIT1').style.display = "none";
                            document.getElementById('HEDIV1').style.display = "block";

                        }

                        function cancelemhelth() {

                            document.getElementById('HEDIT1').style.display = "none";
                            document.getElementById('HEDIV1').style.display = "block";

                        }
                     </script>
                     <div id="HEDIV2">
                        <legend>General health information:
                           <a href="#" style="float: right; color: white ;font-size:14px " onclick="Emedithelt2()">Edit</a>
                        </legend>
                        <td> Height:
                           <?php echo $height; ?> cm
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> Weight:
                           <?php echo $weight; ?> kg
                        </td>
                        <br>
                        <!-- //php select   -->
                        <td> BMI:
                           <?php echo $bmi ?>
                        </td>
                        <!-- //php select   -->
                        <br>
                        <td style="border:1px solid black;"> Blood Type:
                           <?php echo $bloodType; ?>
                        </td>
                        <!-- //php select   -->
                     </div>
                     <br>
                     <div id="HEDIT2" style="display: none;">
                        <form action="" method="POST">
                           Height:
                           <input type="Number" name="height" max="220" min="50">
                           <br> Weight:
                           <input type="Number" name="weight" max="220" min="20">
                           <br>
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

                            document.getElementById('HEDIV2').style.display = "none";
                            document.getElementById('HEDIT2').style.display = "block";

                        }

                        function savehelth2() {

                            document.getElementById('HEDIT2').style.display = "none";
                            document.getElementById('HEDIV2').style.display = "block";

                        }

                        function cancelemhelth2() {

                            document.getElementById('HEDIT2').style.display = "none";
                            document.getElementById('HEDIV2').style.display = "block";

                        }
                     </script>
                  </div>
                  <div class="col-sm-9" id="rc">
                     <button onclick="report()">Reports</button>
                     <button onclick="Medical()">Medical Visits </button>
                     <button onclick="Test()">Tests </button>
                     <button onclick="Chronic()">Chronic Diseases </button>
                     <button onclick="Surgeries()">Surgeries</button>
                     <button onclick="Prescriped()">Prescribed Drugs </button>
                  </div>
                  <div class="col-sm-9" id="rc1">
                     <h4 style="background-color: green ;color: white ">Reports</h4>
                     <?php
                        echo "<table style='width:100%' border='1'>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Type</th>";
                        echo "<th>From</th>";
                        echo "<th>Date</th>";
                        echo "</tr>";
                        $index = 1;
                        foreach ($medicalReports as $key => $value) {
                          echo "<tr>";
                          if ($value['type'] != "") {
                            echo "<td>".$index++."</td>";
                            echo "<td>".$value['type']."</td>";
                            echo "<td>".$value['from']."</td>";
                            echo "<td>".$User->displayDate($value['date'])."</td>";
                          } else {
                            echo "<td colspan='4'>No reports yet</td>";
                          }
                          echo "</tr>";

                        }

                        echo "</table>";

                         ?>
                  </div>
                  <!-- Medical Visit -->
                  <div class="col-sm-9" style="display: none" id="rc2">
                     <h3 style="background-color: green; color: white;">Medical Visits</h3>
                     <?php
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Date</th>";
                        echo "<th>Description</th>";
                        echo "<th>Hospital</th>";
                        echo "<th>Diagnosis</th>";
                        echo "</tr>";
                        $index = 1;
                        $tests = array();
                        foreach ($medicalVisits as $key => $value) {
                          if ($value['desc'] != "") {
                            if (!isset($value['desc'])) {
                              $value['desc'] = "-";
                            }
                            if (!isset($value['hospital'])) {
                              $value['hospital'] = "-";
                            }
                            if (!isset($value['diagnosis'])) {
                              $value['diagnosis'] = "-";
                            }
                            echo "<tr>";
                            echo "<td>".$index++."</td>";
                            echo "<td>".$User->displayDate($value['date'])."</td>";
                            echo "<td>".$value['desc']."</td>";
                            echo "<td>".$value['hospital']."</td>";
                            echo "<td>".$value['diagnosis']."</td>";
                            echo "</tr>";

                            if (isset($value['tests'])) {

                            }
                          } else {
                            echo "<td colspan='5'>No recorded visits</td>";
                          }

                        }

                        echo "</table>";

                        ?>
                  </div>
                  <div class="col-sm-9" style="display: none" id="rc3">
                     <h3 style="background-color: green; color: white;">Tests</h3>
                     <?php
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>Date</th>";
                        echo "<th>Name</th>";
                        echo "<th>Result</th>";
                        echo "</tr>";
                        $index = 1;
                        $tests = array();
                        foreach ($medicalVisits as $key => $value) {
                          $testDate = $value['date'];
                          $visitId = $key;
                          $visitId++;
                          if (isset($value['tests'])) {
                            if (isset($value['testName']) && $value['testName'] != "") {
                              echo "<th height='4' colspan='4'>Medival Visit ".$visitId."</th>";
                              foreach ($value['tests'] as $key => $value) {
                                echo "<tr>";
                                echo "<td>".$User->displayDate($testDate)."</td>";
                                echo "<td>".$value['testName']."</td>";
                                echo "<td>".$value['testResult']."</td>";
                                echo "</tr>";
                              }
                            } else {
                              echo "<tr>";
                              echo "<td colspan='3'>No tests</td>";
                              echo "</tr>";
                            }

                          }
                        }

                        echo "</table>";

                           ?>
                  </div>
                  <!-- Chronic Diseases -->
                  <div class="col-sm-9" style="display: none" id="rc4">
                     <h3 style="background-color: green; color: white;">Chronic Diseases
                     </h3>
                     <?php
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Name</th>";
                        echo "</tr>";
                        $index = 1;
                        foreach ($chronicDseases as $key => $value) {
                          echo "<tr>";
                          if ($value != "" && isset($value)) {
                            $index += $key;
                            echo "<td>".$index."</td>";
                            echo "<td>$value</td>";
                            echo "</tr>";
                          } else {
                            echo "<td colspan='2'>No Diseases</td>";
                          }
                          echo "</tr>";

                        }

                        echo "</table>";

                          ?>
                  </div>
                  <!-- Surgeries -->
                  <div class="col-sm-9" style="display: none" id="rc5">
                     <h3 style="background-color: green; color: white;">Surgeries</h3>
                     <?php
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Name</th>";
                        echo "<th>Hospital</th>";
                        echo "<th>Doctor</th>";
                        echo "<th>Date</th>";
                        echo "</tr>";
                        $index = 1;
                        foreach ($surgeries as $key => $value) {
                          $index += $key;
                          echo "<tr>";
                          if (isset($value['name']) && isset($value['date']) && $value['name']!="") {
                            echo "<td>".$index."</td>";
                            echo "<td>".$value['name']."</td>";
                            echo "<td>".$value['hospital']."</td>";
                            echo "<td>".$value['doctor']."</td>";
                            echo "<td>".$User->displayDate($value['date'])."</td>";
                          } else {
                            echo "<td colspan='5'>No Surgeries</td>";
                          }
                          echo "</tr>";
                        }
                        echo "</table>";

                           ?>
                  </div>
                  <!-- Prescriped Drugs -->
                  <div class="col-sm-9" style="display: none" id="rc6">
                     <h3 style="background-color: green; color: white;">Prescribed Drugs </h3>
                     <?php
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>Name</th>";
                        echo "<th>Period</th>";
                        echo "<th>Dosage</th>";
                        echo "<th>Date Started</th>";
                        echo "</tr>";
                        $index = 1;
                        foreach ($medicalVisits as $key => $value) {
                          $visitId = $key;
                          $visitId++;
                          $visitDate = $value['date'];
                          if (isset($value['prescribedDrugs'])) {
                            if (isset($value['name']) && $value['name'] != "") {
                            echo "<th height='4' colspan='4'>Medival Visit ".$visitId."</th>";
                            foreach ($value['prescribedDrugs'] as $key => $value) {
                                echo "<tr>";
                                echo "<td>".$value['name']."</td>";
                                echo "<td>".$value['period']."</td>";
                                echo "<td>".$value['dosage']."</td>";
                                echo "<td>".$User->displayDate($visitDate)."</td>";
                                echo "</tr>";
                              }
                            }  else {
                              echo "<tr>";
                              echo "<td colspan='4'>No drugs</td>";
                              echo "</tr>";
                            }
                          }
                        }

                        echo "</table>";

                         ?>
                  </div>
                  <script>
                     function report() {

                         document.getElementById('rc6').style.display = "none";
                         document.getElementById('rc5').style.display = "none";
                         document.getElementById('rc4').style.display = "none";
                         document.getElementById('rc3').style.display = "none";
                         document.getElementById('rc2').style.display = "none";
                         document.getElementById('rc1').style.display = "block";

                     }

                     function Medical() {
                         document.getElementById('rc1').style.display = "none";
                         document.getElementById('rc6').style.display = "none";
                         document.getElementById('rc5').style.display = "none";
                         document.getElementById('rc4').style.display = "none";
                         document.getElementById('rc3').style.display = "none";
                         document.getElementById('rc2').style.display = "block";

                     }

                     function Test() {
                         document.getElementById('rc2').style.display = "none";
                         document.getElementById('rc1').style.display = "none";
                         document.getElementById('rc6').style.display = "none";
                         document.getElementById('rc5').style.display = "none";
                         document.getElementById('rc4').style.display = "none";
                         document.getElementById('rc3').style.display = "block";

                     }

                     function Chronic() {
                         document.getElementById('rc3').style.display = "none";
                         document.getElementById('rc2').style.display = "none";
                         document.getElementById('rc1').style.display = "none";
                         document.getElementById('rc6').style.display = "none";
                         document.getElementById('rc5').style.display = "none";
                         document.getElementById('rc4').style.display = "block";

                     }

                     function Surgeries() {
                         document.getElementById('rc4').style.display = "none";
                         document.getElementById('rc3').style.display = "none";
                         document.getElementById('rc2').style.display = "none";
                         document.getElementById('rc1').style.display = "none";
                         document.getElementById('rc6').style.display = "none";
                         document.getElementById('rc5').style.display = "block";

                     }

                     function Prescriped() {
                         document.getElementById('rc5').style.display = "none";
                         document.getElementById('rc4').style.display = "none";
                         document.getElementById('rc3').style.display = "none";
                         document.getElementById('rc2').style.display = "none";
                         document.getElementById('rc1').style.display = "none";
                         document.getElementById('rc6').style.display = "block";

                     }
                  </script>
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
                    $EduReports = $erc['reports'];
                    }
                  }
                  ?>
               <div id="ERC" style="display: none">
                  <h4 style="background-color: green ;color: white ">Education Record</h4>
                  <!--  <div id="sterment">
                     <img src="..\images\ImgUp\education.jpg"  style="width: 100%; height: 200px;">

                       </div>  -->
                  <div class="col-sm-9" id="rc">
                     <!-- ##################################################################################################### -->
                     <div id="EDDIV1">
                        <table style="border: 1px solid green ;" width="100%">
                           <legend style="border: solid black;">Emergency Contact: <a href="#" style="float: right; color: white ;font-size:14px " onclick="Emediteud()">Edit</a> </legend>
                           <tr>
                              <th> Name: </th>
                              <th>Phone: </th>
                              <th>Relationship: </th>
                           </tr>
                           <tr>
                              <td>
                                 <?php echo $eEC['name']; ?>
                              </td>
                              <!-- //php select   -->
                              <td>
                                 <?php echo $eEC['phone']; ?>
                              </td>
                              <!-- //php select   -->
                              <td>
                                 <?php echo $eEC['relationship']; ?>
                              </td>
                              <!-- //php select   -->
                           </tr>
                           <br>
                        </table>
                     </div>
                     <br>
                     <!--           EDIT DIV 1            -->
                     <div id="edit1" style="display: none;">
                        <form method="POST" action="">
                           Name:
                           <input type="text" name="EDRCEmConName" required>
                           <br> Phone :
                           <input type="text" name="EDRCEmConPhone" required>
                           <br> Relationship:
                           <input type="text" name="EDRCEmConRS" required>
                           <br> Emergency Code:
                           <input type="number" name="EDRCEmConCode" value="0000" title="Set an emergency code for your record" required>
                           <input type="submit" name="Emsaveed" value="save" onclick="saveedu()">
                           <a href="#" style="float: right;" onclick="cancelemedu()">cancel</a>
                        </form>
                        <?php
                           if (isset($_POST['EDRCEmConName']) && isset($_POST['EDRCEmConPhone']) && isset($_POST['EDRCEmConRS']) && isset($_POST['EDRCEmConCode'])) {
                             $updateHREmergencyContact = $User->updateEREmCon($userId, $_POST['EDRCEmConName'], $_POST['EDRCEmConPhone'], $_POST['EDRCEmConRS'], $_POST['EDRCEmConCode']);
                             echo "<script>
                             alert('Successfully updated Education Record emergency contact!');
                             window.location.href='./dashboard.php';
                             </script>";
                           }

                           ?>
                     </div>
                     <br>
                     <br>
                     <script>
                        function Emediteud() {

                            document.getElementById('EDDIV1').style.display = "none";
                            document.getElementById('edit1').style.display = "block";

                        }

                        function saveedu() {

                            document.getElementById('edit1').style.display = "none";
                            document.getElementById('EDDIV1').style.display = "block";

                        }

                        function cancelemedu() {

                            document.getElementById('edit1').style.display = "none";
                            document.getElementById('EDDIV1').style.display = "block";

                        }

                        function refreshPage() {
                            window.location.reload(false);
                        }
                     </script>
                     <!-- ##################################################################################################### -->
                     <div id="EDDIV2">
                        <table style="border: 1px solid green ;" width="100%">
                           <legend style="border: 1px solid black; background-color: green ;color: white">Current Status <a href="#" style="float: right; color: white;font-size:14px " onclick="Emediteud1()">Edit</a></legend>
                           <tr>
                              <td>
                                 <?php echo $currentStatus; ?>
                              </td>
                           </tr>
                        </table>
                     </div>
                     <br>
                     <!--           EDIT DIV2            -->
                     <div id="edit2" style="display: none;">
                        <legend style="border: 1px solid black; background-color: green ;color: white">Change current Status</legend>
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

                            document.getElementById('EDDIV2').style.display = "none";
                            document.getElementById('edit2').style.display = "block";

                        }

                        function saveedu1() {

                            document.getElementById('edit2').style.display = "none";
                            document.getElementById('EDDIV2').style.display = "block";

                        }

                        function cancelemedu1() {

                            document.getElementById('edit2').style.display = "none";
                            document.getElementById('EDDIV2').style.display = "block";

                        }
                     </script>
                     <br>
                     <!-- ##################################################################################################### -->
                     <div id="EDDIV3">
                        <?php
                           echo "<table id='schools'>";
                           echo "<legend style='border: 1px solid black;'>Highschools Attended <a href='#' style='float: right; color: white;font-size:14px'
                           onclick='highscoolediteud()'>New</a></legend>";
                           echo "<tr>";
                           echo "<th>#</th>";
                           echo "<th>Name</th>";
                           echo "<th>Date Started</th>";
                           echo "<th>Date Ended</th>";
                           echo "<th>Status</th>";
                           echo "<th>Delete</th>";
                           echo "</tr>";
                           $index = 1;
                           foreach ($highSchools as $key => $value) {
                             echo "<tr>";
                             if ($value['schoolName'] != "") {
                               echo "<td>".$index++."</td>";
                               echo "<td>".$value['schoolName']."</td>";
                               echo "<td>".$User->displayDate($value['dateStarted'])."</td>";
                               echo "<td>".$User->displayDate($value['dateEnded'])."</td>";
                               echo "<td>".$value['status']."</td>";

                               echo "<td>";
                               echo "<form name='deleteSchool' method='POST'>";
                               echo "<input style='background:red' id='deleteSchool' name='deleteSchool' type='submit' value='X'>";
                               echo "<input name='schoolId' type='hidden' value='".$value['_id']."'>";
                               echo "</form>";
                               echo "</td>";

                             } else {
                               echo "<td colspan='6'>No record</td>";
                             }

                             echo "</tr>";
                           }

                           echo "</table>";

                           if (isset($_POST['deleteSchool']) && isset($_POST['schoolId'])) {
                             $deleteSchool = $User->deleteSchool($userId, $_POST['schoolId'], "HS");
                             if ($deleteSchool) {
                               echo "<script>
                               alert('Successfully deleted School!');
                               window.location.href='./redirect.php';
                               </script>";
                             } else {
                               echo "<script>
                               window.location.href='./redirect.php';
                               </script>";

                             }
                           }

                            ?>
                     </div>
                     <br>
                     <!--           EDIT DIV3            -->
                     <div id="edit3" style="display: none;">
                        <legend>Add a new highschool</legend>
                        <form action="./newSchool.php" method="post" enctype="multipart/form-data">
                           School Name:
                           <input type="name" name="schoolName" required>
                           <br> Date started:
                           <input type="date" name="dateStarted" required>
                           <br> Date ended:
                           <input type="date" name="dateEnded" required>
                           <br> status:
                           <select name="status" required>
                              <option value="Graduated">Graduated</option>
                              <option value="Transferred">Transferred</option>
                              <option value="Dropped">Dropped</option>
                              <option value="Expelled">Expelled</option>
                              <option value="Other">Other</option>
                           </select>
                           <br> Location:
                           <input type="Address" name="location" required>
                           <br>
                           <br> Select file to upload:
                           <input type="file" name="fileToUpload" id="fileToUpload"> Types allowed: JPG, JPEG, PNG, PDF, DOC.
                           <br>
                           <input type="hidden" name="type" value="HS">
                           <input type="submit" name="Emsaveed" value="Submit" onclick="saveedu2()">
                           <a href="#" style="float: right;" onclick="cancelemedu2()">Cancel</a>
                           <br>
                        </form>
                     </div>
                     <script>
                        function highscoolediteud() {

                            document.getElementById('EDDIV3').style.display = "none";
                            document.getElementById('edit3').style.display = "block";

                        }

                        function saveedu2() {

                            document.getElementById('edit3').style.display = "none";
                            document.getElementById('EDDIV3').style.display = "block";

                        }

                        function cancelemedu2() {

                            document.getElementById('edit3').style.display = "none";
                            document.getElementById('EDDIV3').style.display = "block";

                        }
                     </script>
                     <!-- ##################################################################################################### -->
                     <div id="EDDIV4">
                        <?php
                           echo "<table id='universities'>";
                           echo "<legend>Universities attended <a href='#' style='float: right; color: white;font-size:14px'
                           onclick='collageediteud()'>New</a></legend>";
                           echo "<tr>";
                           echo "<th>#</th>";
                           echo "<th>Name</th>";
                           echo "<th>Date Started</th>";
                           echo "<th>Date Ended</th>";
                           echo "<th>Degree</th>";
                           echo "<th>Major</th>";
                           echo "<th>GPA</th>";
                           echo "<th>Status</th>";
                           echo "<th>Delete</th>";
                           echo "</tr>";
                           $index = 1;
                           foreach ($universities as $key => $value) {
                             echo "<tr>";

                             if ($value['universityName'] != "") {
                               echo "<td>".$index++."</td>";
                               echo "<td>".$value['universityName']."</td>";
                               echo "<td>".$User->displayDate($value['dateStarted'])."</td>";
                               echo "<td>".$User->displayDate($value['dateEnded'])."</td>";
                               echo "<td>".$value['degree']."</td>";
                               echo "<td>".$value['major']."</td>";
                               echo "<td>".$value['gpa']."</td>";
                               echo "<td>".$value['status']."</td>";

                               echo "<td>";
                               echo "<form name='deleteSchool' method='POST' action=''>";
                               echo "<input style='background:red' id='deleteSchool' name='deleteSchool' type='submit' value='X'>";
                               echo "<input name='schoolId' type='hidden' value='".$value['_id']."'>";
                               echo "</form>";
                               echo "</td>";
                             } else {
                               echo "<td colspan='9'>No record</td>";
                             }

                             echo "</tr>";
                           }

                           echo "</table>";

                           if (isset($_POST['deleteSchool']) && isset($_POST['schoolId'])) {
                             $deleteSchool = $User->deleteSchool($userId, $_POST['schoolId'], "Uni");
                             if ($deleteSchool) {
                               echo "<script>
                               alert('Successfully deleted University!');
                               window.location.href='./redirect.php';
                               </script>";
                             } else {
                               echo "<script>
                               window.location.href='./redirect.php';
                               </script>";
                             }
                           }

                            ?>
                     </div>
                     <br>
                     <!--           EDIT DIV4            -->
                     <div id="edit4" style="display: none;">
                        <legend>Add a new University/College</legend>
                        <form action="./newSchool.php" method="post" enctype="multipart/form-data">
                           Name:
                           <input type="text" name="uniName" required>
                           <br> Date Started:
                           <input type="date" name="uniFrom" required>
                           <br> Date Ended:
                           <input type="date" name="uniTo" required>
                           <br> Degree:
                           <select name="uniDegree" required>
                              <br>
                              <option value="Diploma">Diploma</option>
                              <br>
                              <option value="Bachelor">Bachelor</option>
                              <br>
                              <option value="Master">Master</option>
                              <br>
                              <option value="PHD">PHD</option>
                              <br>
                           </select>
                           GPA:
                           <input type="Number" name="uniGPA" max="5" min="0" required> Major:
                           <input type="text" name="uniMajor" required> Status:
                           <select name="uniStatus" required>
                              <br>
                              <option value="Undergraduate">Undergraduate</option>
                              <br>
                              <option value="Graduate">Graduate</option>
                              <br>
                              <option value="Dropped">Dropped</option>
                              <br>
                              <option value="Other">Other</option>
                              <br>
                           </select>
                           <br> Select file to upload:
                           <input type="file" name="fileToUpload" id="fileToUpload"> Types allowed: JPG, JPEG, PNG, PDF, DOC.
                           <br>
                           <input type="hidden" name="type" value="Uni">
                           <input type="submit" name="Emsaveed" value="save" onclick="saveedu3()">
                           <a href="#" style="float: right;" onclick="cancelemedu3()">Cancel</a>
                        </form>
                     </div>
                     <script>
                        function collageediteud() {

                            document.getElementById('EDDIV4').style.display = "none";
                            document.getElementById('edit4').style.display = "block";

                        }

                        function saveedu3() {

                            document.getElementById('edit4').style.display = "none";
                            document.getElementById('EDDIV4').style.display = "block";

                        }

                        function cancelemedu3() {

                            document.getElementById('edit4').style.display = "none";
                            document.getElementById('EDDIV4').style.display = "block";

                        }
                     </script>
                  </div>
                  <!--  #################################################################################### -->
                  <div class="col-sm-9" id="rc">
                     <h4 style="background-color: green ;color: white ">Reports</h4>
                     <table style="width:100%" border="1">
                        <tr>
                           <th style="text-align: center;">Report</th>
                           <th style="text-align: center;">Date</th>
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
               <div id="WRC" style="display: none; width:100%">
                  <h4 style="background-color: green ;color: white ">Work Record</h4>
                  <div id="sterment">
                     <!--    <img src="..\images\ImgUp\work.jpg" style="width: 100%; height: 200px;">   -->
                  </div>
                  <div class="col-sm-9" id="rc" style="width: 50%">
                     <div id="em">
                        <fieldset>
                           <legend>Emergency Contact: <a href="#" style="float: right; color: white ; font-size: 14px;" onclick="Emedit()">Edit</a></legend>
                           <td> Name:
                              <?php if (isset($wEC['name'])) {
                                 echo $wEC['name'];
                                 } else {
                                 echo "Not set";
                                 } ?>
                           </td>
                           <br>
                           <!-- //php select   -->
                           <td> Phone:
                              <?php if (isset($wEC['phone'])) {
                                 echo $wEC['phone'];
                                 } else {
                                 echo "Not set";
                                 } ?>
                           </td>
                           <br>
                           <!-- //php select   -->
                           <td> Relationship:
                              <?php if (isset($wEC['relationship'])) {
                                 echo $wEC['relationship'];
                                 } else {
                                 echo "Not set";
                                 } ?>
                           </td>
                           <!-- //php select   -->
                        </fieldset>
                     </div>
                     <div id="eme" style="display: none;">
                        <form method="post" action="#">
                           <!-- edit form work -->
                           <fieldset>
                              <legend>Edit Emergency Contact: </legend>
                              <td>Name:
                                 <input type="text" name="WRCEmConName">
                                 <br>
                              </td>
                              <td>Phone:
                                 <input type="phone" name="WRCEmConPhone">
                                 <br>
                              </td>
                              <td>Relationship:
                                 <input type="text" name=" WRCEmConRS">
                                 <br>
                              </td>
                              <td>Emergency Code:
                                 <input type="number" name="WRCEmConCode" value="0000" title="Set an emergency code for your record" required>
                                 <br>
                              </td>
                           </fieldset>
                           <input type="submit" name="send" value="Save">
                           <a href="#" style="float: right;" onclick="Emsave()"></a>
                           <a href="#" style="float: right;" onclick="Emcancel()">Cancel</a>
                        </form>
                        <?php
                           if (isset($_POST['WRCEmConName']) && isset($_POST['WRCEmConPhone']) && isset($_POST['WRCEmConRS']) && isset($_POST['WRCEmConCode'])) {
                             $updateHREmergencyContact = $User->updateWREmCon($userId, $_POST['WRCEmConName'],
                             $_POST['WRCEmConPhone'],
                             $_POST['WRCEmConRS'],
                             $_POST['WRCEmConCode']
                             );
                             echo "<script>
                             alert('Successfully updated Work Record emergency contact!');
                             window.location.href='./dashboard.php';
                             </script>";
                           }

                           ?>
                     </div>
                     <br>
                     <br>
                     <script>
                        function Emedit() {
                            document.getElementById('em').style.display = "none";
                            document.getElementById('eme').style.display = "block";

                        }

                        function Emsave() {
                            document.getElementById('eme').style.display = "none";
                            document.getElementById('em').style.display = "block";

                        }

                        function Emcancel() {
                            document.getElementById('eme').style.display = "none";
                            document.getElementById('em').style.display = "block";

                        }
                     </script>
                     <legend>Information</legend>
                     <td>Current Status:
                        <?php if (isset($occupation) && $occupation != "") {
                           echo "Working";
                           } else {
                           echo "Not working";
                           } ?>
                     </td>
                     <!-- //php select   -->
                     <br>
                     <td>Occupation:
                        <?php if (isset($occupation)) {
                           echo $occupation;
                           } else {
                           echo "-";
                           } ?>
                     </td>
                     <br>
                     <td>Employer:
                        <?php if (isset($employerName)) {
                           echo $employerName;
                           } ?>
                     </td>
                     <br>
                     <td>Field:
                        <?php if (isset($employerField)) {
                           echo $employerField;
                           } ?>
                     </td>
                     <br>
                     <td>Salary:
                        <?php if (isset($salary)) {
                           echo $salary;
                           } ?>
                     </td>
                     <br>
                     <td>Office Phone:
                        <?php if (isset($officePhone)) {
                           echo $officePhone;
                           } ?>
                     </td>
                  </div>
                  <!-- ***************************************************************************************************** -->
                  <div class="col-sm-9" id="rc" style="width: 50%">
                     <div style="width: 100%">
                        <button onclick="report2()"> Reports </button>
                        <button onclick="previous()">previousJobs </button>
                     </div>
                     <div class="col-sm-9" id="rc7" style="width:100%;">
                        <h4 style="background-color: green ;color: white ">Documents</h4>
                        <?php
                           //  <table style="width:100%" border="1">
                           //   <tr>
                           //     <th style="text-align: center;">Report</th>
                           //     <th style="text-align: center;" >Date</th>
                           //     <th style="text-align: center;"> From</th>
                           //   </tr>
                           //   <tr>
                           //     <td><a href="#">report.pdf</a></td>
                           //     <td>15/4/2018</td>
                           //     <td>KAU</td>
                           //   </tr>
                           //    <tr>
                           //     <td><a href="#">report.pdf</a></td>
                           //     <td>15/4/2018</td>
                           //     <td>KAU</td>
                           //   </tr>
                           //
                           // </table>

                           echo "<table style='width:100%' border='1'>";
                           echo "<tr>";
                           echo "<th>#</th>";
                           echo "<th>Document</th>";
                           echo "<th>uploadedBy</th>";
                           echo "<th>Date</th>";
                           echo "<th>Notes</th>";
                           echo "</tr>";
                           $index = 1;
                           foreach ($documents as $key => $value) {
                             echo "<tr>";
                             echo "<td>".$index++."</td>";
                             echo "<td><a href='".$value['location']."'>".$value['docName']."</a></td>";
                             echo "<td>".$value['uploadedBy']."</td>";
                             echo "<td>".$User->displayDate($value['date'])."</td>";
                             echo "<td>".$value['notes']."</td>";
                             echo "</tr>";
                           }

                           echo "</table>";

                             ?>
                     </div>
                     <div class="col-sm-9" id="rc8" style="width: 100%; display: none">
                        <legend>Previous Jobs <a href="#" style="float: right; color: white ; font-size: 14px;" onclick="previous2()">New</a></legend>
                        <?php
                           if (isset($previousjobs)) {
                             echo "<table style='width:100%' border='1'>";
                             echo "<tr>";
                             echo "<th>#</th>";
                             echo "<th>Occupation</th>";
                             echo "<th>Employer</th>";
                             echo "<th>Start Date</th>";
                             echo "<th>End Date</th>";
                             echo "<th>Reason for leaving</th>";
                             echo "<th>Delete</th>";
                             echo "</tr>";
                             $index = 1;
                             foreach ($previousjobs as $key => $value) {
                               $employerInfo = $User->getEmployerInfo($userId, $value['employer']);
                               if ($employerInfo) {
                                 $employerName = $employerInfo['name'];
                               } else {
                                 $employerName = $value['employer'];
                               }
                               echo "<tr>";
                               echo "<td>".$index++."</td>";
                               echo "<td>".$value['occupation']."</td>";
                               echo "<td>".$employerName."</td>";
                               echo "<td>".$User->displayDate($value['startDate'])."</td>";
                               echo "<td>".$User->displayDate($value['endDate'])."</td>";
                               echo "<td>".$value['reasonForLeaving']."</td>";

                               echo "<td>";
                               echo "<form name='deleteJob' method='POST' action=''>";
                               echo "<input style='background:red' id='deleteJob' name='deleteJob' type='submit' value='X'>";
                               echo "<input name='jobId' type='hidden' value='".$value['_id']."'>";
                               echo "</form>";
                               echo "</td>";

                               echo "</tr>";
                             }
                             echo "</table>";

                             if (isset($_POST['deleteJob']) && isset($_POST['jobId'])) {
                               $deleteJob = $User->deleteJob($userId, $_POST['jobId']);
                               if ($deleteJob) {
                                 echo "<script>
                                 alert('Successfully deleted job!');
                                 window.location.href='./redirect.php';
                                 </script>";
                               } else {
                                 echo "<script>
                                 window.location.href='./redirect.php';
                                 </script>";
                               }
                             }

                           } else {
                             echo "Have not worked previously";
                           }

                           ?>
                     </div>
                     <script>
                        function report2() {
                            document.getElementById('rc9').style.display = "none";
                            document.getElementById('rc8').style.display = "none";
                            document.getElementById('rc7').style.display = "block";

                        }

                        function previous() {
                            document.getElementById('rc9').style.display = "none";
                            document.getElementById('rc7').style.display = "none";
                            document.getElementById('rc8').style.display = "block";

                        }
                     </script>
                     <script>
                        function previous2() {
                            document.getElementById('rc8').style.display = "none";
                            document.getElementById('rc9').style.display = "block";
                        }
                     </script>
                     <div class="col-sm-9" id="rc9" style="display: none; width: 100%">
                        <legend>Add a new job</legend>
                        <form action="./newJob.php" method="post">
                           Occupation:
                           <input type="text" name="occupation" required>
                           <br> Employer:
                           <input type="text" name="employer" title="You may enter the company ID" required>
                           <br> Start Date:
                           <input type="date" name="startDate" required>
                           <br> End Date:
                           <input type="date" name="endDate" required>
                           <br> Reason for leaving:
                           <input type="text" name="reason" required>
                           <br>
                           <input type="submit" name="Emsaveed" value="Submit" onclick="previous2()">
                           <a href="#" style="float: right;" onclick="previous()">Cancel</a>
                           <br>
                        </form>
                        <?php
                           ?>
                        <!-- <form>
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
                           <a href="#" onclick="previous()">Cancel</a>
                           </form> -->
                        <br>
                        <!-- ***************************************************************************************************** -->
                     </div>
                  </div>
               </div>
               <div style="display: none" id="Requests">
                  <div lass="col-sm-9" id="rc" style="width:100%">
                     <br>
                     <h4 style="background-color: green; color: white">Requests</h4>
                     <br>
                     <?php
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Request Date</th>";
                        echo "<th>From</th>";
                        echo "<th>By</th>";
                        echo "<th>Status</th>";
                        echo "<th>Approve</th>";
                        echo "<th>Refuse</th>";
                        echo "<th>Block</th>";
                        echo "</tr>";
                        $index = 1;

                        // Health record Requests
                        echo "<tr><th colspan='8'>Health record requests</th></tr>";
                        if (isset($hrcAuths)) {
                          foreach ($hrcAuths as $key => $value) {

                            echo "<tr>";
                            echo "<td>".$index++."</td>";
                            echo "<td>".$User->displayDate($value['requestDate'])."</td>";

                            // inst name
                            $instdata = $User->getRepInst($value['authRequester']);
                            $instname = $instdata['name'];
                            echo "<td>$instname</td>";

                            // rep name
                            $repdata = $User->getUser($value['authRequester']);
                            $repname = $repdata['firstName'];
                            echo "<td>$repname</td>";

                            if ($value['authorized'] == false && !isset($value['responseDate'])) {
                              echo "<td>Waiting response</td>";
                            } elseif ($value['authorized'] == true && ( !isset($value['block']) || $value['block'] == false)) {
                              echo "<td>Approved on ".$User->displayDate($value['responseDate'])."</td>";
                            } elseif ($value['authorized'] == false && $value['block'] == false) {
                              echo "<td>refused on ".$User->displayDate($value['responseDate'])."</td>";
                            } elseif ($value['block'] == false) {
                              echo "<td>This user is block from requesting access</td>";
                            } else {
                              echo "<td>-</td>";
                            }

                            echo "<td>";
                            // approve
                            echo "<form name='processRequestHRC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/yes.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Healthcare'>";
                            echo "<input name='response' type='hidden' value='yes'>";
                            echo "</form>";
                            echo "</td>";

                            // Refuse
                            echo "<td>";
                            echo "<form name='processRequestHRC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/no.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Healthcare'>";
                            echo "<input name='response' type='hidden' value='no'>";
                            echo "</form>";
                            echo "</td>";

                            // block
                            echo "<td>";
                            echo "<form name='processRequestHRC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/block.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Healthcare'>";
                            echo "<input name='response' type='hidden' value='block'>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr>";
                          echo "<td colspan='8'>No requests</td>";
                          echo "</tr>";
                        }

                        /// Education record
                        echo "<tr><th colspan='8'>Education record requests</th></tr>";
                        if (isset($ercAuths)) {
                          foreach ($ercAuths as $key => $value) {
                            echo "<tr>";
                            echo "<td>".$index++."</td>";
                            echo "<td>".$User->displayDate($value['requestDate'])."</td>";

                             // inst name
                             $instdata = $User->getRepInst($value['authRequester']);
                             $instname = $instdata['name'];
                             echo "<td>$instname</td>";

                             // rep name
                             $repdata = $User->getUser($value['authRequester']);
                             $repname = $repdata['firstName'];
                             echo "<td>$repname</td>";

                            if ($value['authorized'] == false && !isset($value['responseDate'])) {
                              echo "<td>Waiting response</td>";
                            } elseif ($value['authorized'] == true && ( !isset($value['block']) || $value['block'] == false)) {
                              echo "<td>Approved on ".$User->displayDate($value['responseDate'])."</td>";
                            } elseif ($value['authorized'] == false && $value['block'] == false) {
                              echo "<td>refused on ".$User->displayDate($value['responseDate'])."</td>";
                            } elseif ($value['block'] == true) {
                              echo "<td>Blocked</td>";
                            } else {
                              echo "<td>-</td>";
                            }

                            echo "<td>";
                            // approve
                            echo "<form name='processRequestERC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/yes.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Education'>";
                            echo "<input name='response' type='hidden' value='yes'>";
                            echo "</form>";
                            echo "</td>";

                            // Refuse
                            echo "<td>";
                            echo "<form name='processRequestERC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/no.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Education'>";
                            echo "<input name='response' type='hidden' value='no'>";
                            echo "</form>";
                            echo "</td>";

                            // block
                            echo "<td>";
                            echo "<form name='processRequestERC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/block.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Education'>";
                            echo "<input name='response' type='hidden' value='block'>";
                            echo "</form>";
                            echo "</td>";

                            echo "</tr>";
                          }
                        } else {
                          echo "<tr>";
                          echo "<td colspan='8'>No requests</td>";
                          echo "</tr>";
                        }

                        /// Work record
                        echo "<tr><th colspan='8'>Work record requests</th></tr>";
                        if (isset($wrcAuths)) {
                          foreach ($wrcAuths as $key => $value) {
                            echo "<tr>";
                            echo "<td>".$index++."</td>";
                            echo "<td>".$User->displayDate($value['requestDate'])."</td>";

                            // inst name
                            $instdata = $User->getRepInst($value['authRequester']);
                            $instname = $instdata['name'];
                            echo "<td>$instname</td>";

                            // rep name
                            $repdata = $User->getUser($value['authRequester']);
                            $repname = $repdata['firstName'];
                            echo "<td>$repname</td>";

                            if ($value['authorized'] == false && !isset($value['responseDate'])) {
                              echo "<td>Waiting response</td>";
                            } elseif ($value['authorized'] == true && ( !isset($value['block']) || $value['block'] == false)) {
                              echo "<td>Approved on ".$User->displayDate($value['responseDate'])."</td>";
                            } elseif ($value['authorized'] == false && $value['block'] == false) {
                              echo "<td>refused on ".$User->displayDate($value['responseDate'])."</td>";
                            } elseif ($value['block'] == false) {
                              echo "<td>This user is block from requesting access</td>";
                            } else {
                              echo "<td>-</td>";
                            }

                            echo "<td>";
                            // approve
                            echo "<form name='processRequestWRC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/yes.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Business'>";
                            echo "<input name='response' type='hidden' value='yes'>";
                            echo "</form>";
                            echo "</td>";

                            // Refuse
                            echo "<td>";
                            echo "<form name='processRequestWRC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/no.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Business'>";
                            echo "<input name='response' type='hidden' value='no'>";
                            echo "</form>";
                            echo "</td>";

                            // block
                            echo "<td>";
                            echo "<form name='processRequestWRC' method='POST' action='./processRequest.php'>";
                            echo "<input id='yes' type='image' alt='approve' src='./../../resources/images/ImgUp/block.png'  style='width: 30px;height: 30px;'";
                            echo "<input name='requestId' type='hidden' value='".$value['_id']."'>";
                            echo "<input name='recordType' type='hidden' value='Business'>";
                            echo "<input name='response' type='hidden' value='block'>";
                            echo "</form>";
                            echo "</td>";

                            echo "</tr>";
                          }
                        } else {
                          echo "<tr>";
                          echo "<td colspan='8'>No requests</td>";
                          echo "</tr>";
                        }

                        echo "</table>";

                        ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script>
         function home() {
             document.getElementById('Requests').style.display = "none";
             document.getElementById('WRC').style.display = "none";
             document.getElementById('ERC').style.display = "none";
             document.getElementById('HRC').style.display = "none";
             document.getElementById('home').style.display = "block";

         }

         function HRC() {
             document.getElementById('Requests').style.display = "none";
             document.getElementById('WRC').style.display = "none";
             document.getElementById('ERC').style.display = "none";
             document.getElementById('home').style.display = "none";
             document.getElementById('HRC').style.display = "block";

         }

         function ERC() {
             document.getElementById('Requests').style.display = "none";
             document.getElementById('WRC').style.display = "none";
             document.getElementById('home').style.display = "none";
             document.getElementById('HRC').style.display = "none";
             document.getElementById('ERC').style.display = "block";

         }

         function WRC() {
             document.getElementById('Requests').style.display = "none";
             document.getElementById('ERC').style.display = "none";
             document.getElementById('home').style.display = "none";
             document.getElementById('HRC').style.display = "none";
             document.getElementById('WRC').style.display = "block";

         }

         function Requests() {
             document.getElementById('ERC').style.display = "none";
             document.getElementById('home').style.display = "none";
             document.getElementById('HRC').style.display = "none";
             document.getElementById('WRC').style.display = "none";
             document.getElementById('Requests').style.display = "block";

         }
      </script>
      <script>
         var d = new Date();
         document.getElementById("demo").innerHTML = d;
      </script>
   </body>
</html>
