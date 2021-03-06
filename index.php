<?php
session_start();
define("ROOT_PATH", __DIR__);
require_once(ROOT_PATH."/users/user.model.php");
$User = new User();

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Service Center</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

<link href="./css/main.css" rel="stylesheet" type="text/css">
	 <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


 </head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60" onpageshow="myFunction()">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#myPage"><img src="./resources/images/logo.png"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#news">NEWS</a></li>
         <li><a href="#goal">GOALS</a></li>
        <li><a href="#contact">CONTACT</a></li>
        <li><a href="#signup1" onclick="signupnav();">Sign Up</a></li>



      </ul>
    </div>
  </div>
</nav>


<div class="jumbotron text-center">
  <h1>Service Center</h1>
  <p>Your online profile</p>

</div>

<!-- *************************************************** sign up*************************************************** -->
<!-- Container (sing up Section) -->
<div id="signup1" class="container-fluid text-center" id="login1">
  <h2>sign up</h2>
  <div class="row slideanim">
    <div class="col-sm-4">
    <a   href="#" onclick="login()" ><img src="./resources/images/imgMp/login.png" ></a>
       <h4>login</h4>
    </div>
    <div class="col-sm-4">
     <a href="#" onclick="newuser()"><img src="./resources/images/imgMp/newuser.png" ></a>
      <h4>New user</h4>
    </div>
    <div class="col-sm-4">
     <a href="#" onclick="newpass()" > <img src="./resources/images/imgMp/Password.png"> </a>
      <h4>Password Recovery </h4>
    </div>
       <br><br>
   </div>
</div>
 <!-- *************************************************** login *************************************************** -->
<div id="signup2" class="container-fluid text-center"  style="display:none;">
  <h2>sign up</h2>
  <div class="row slideanim">
  <div class="col-sm-4">
    <h4 style="background-color: green ;color: white ">Login</h4>

      <form  name="fromlogin"  action = "./portal/login_action.php" method="post" >
        <select id="soflow-color" name="type">
           login as
           <option value="1" name="t">individual user</option>
           <option value="2" name="t">representative user or owner</option>
        </select>
        <br>
       Username:  <br>  <input type="text" placeholder="For representatives enter your ID"  name="iduser" id="iduser"  required="required">
       <br>
       Password: <br> <input type="password" name="password"  required="required" id="password">
       <br>
        <input type="submit"  name="login" id="submit" value="Login" >
        <?php if(isset($_SESSION['ErrorMsg'])) { ?>
          <span class="errorMsg" color="red" id="validation" value="$_SESSION['ErrorMsg']"></span>
        <?php } unset($_SESSION['ErrorMsg']) ?>

      </form>

    </div>


     <div class="col-sm-4">
         <a href="#" onclick="newuser()"><img src="./resources/images/imgMp/newuser.png" ></a>
      <h4>New user</h4>
    </div>
    <div class="col-sm-4">
     <a href= "#" onclick="newpass()" > <img src="./resources/images/imgMp/Password.png"> </a>
      <h4>Password Recovery </h4>
    </div>
   </div>
   </div>







   <!--   *****************************************  newuser *****************************************************  -->



   <div id="newuser2" class="container-fluid text-center"  style="display:none;">
  <h2>sign up</h2>
  <div class="row slideanim">
     <div class="col-sm-4">
    <a   href="#" onclick="login()" ><img src="./resources/images/imgMp/login.png" ></a>
       <h4>login</h4>
    </div>
     <div class="col-sm-4">



      <div id="divusertype">

     <button style="background-color: green ; width:150px;" > <a href="#" style="color: white ; text-decoration: none; " onclick="iuser()"> individual user</a> </button>
      <br>

      <br>
      <button style="background-color: green ; width: 150px;"> <a href="#" style="color: white ;text-decoration :none" onclick="ruser()">representative user</a> </button>
      <br>
        <br>
        <button style="background-color: green ; width: 150px;"> <a href="#" style="color: white ;text-decoration :none" onclick="ins()">Institution</a> </button>
        <br>
      You have an account? <a   href="#" onclick="login()" >login</a>
      </div>

<!--  **************************************  individual   **************************************************** -->
 <div id="individualtype" style="display: none;">
   <h4 style="background-color: green ;color: white ">individual user</h4>

   <div class="ind-reg-container">
      <form name="" action="./portal/register_action.php" method='post' onsubmit="return chk()" >
      ID:  <br>  <input type="text" name="iduser" required="required" maxlength="10" manlength="10" id="iduser" pattern="^(0|[1-9][0-9]*)$"
       title="Must be number">
      <br>
      Username:  <br>  <input type="text" name="username"required  >
      <br>
      Email:  <br>  <input type="email" name="email"  required>
      <br>
      Password: <br> <input id="password" type="password" name="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  >
      <br>
      Repeat Password: <br> <input type="password" name="rpassword" required="required" id="rpassword2" onkeyup="checkPass(); return false;"
      pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
      <br>
      <input type="submit"  style="position: center; background-color:green color:white" onclick="check();" value="SIGN UP">
      </form>
        <br>
      Register as  <a href="#" onclick="ruser()">representative user</a>
      Or <a href="#"onclick="ins()">Institution owner</a>
      <br>
      Have an account already? <a href="#" onclick="ins()" >Login</a>
    </div>
</div>

<script type="text/javascript">
  function checkPass()
{    var pass1 = document.getElementById('password1');
     var pass2 = document.getElementById('rpassword2');
     var message = document.getElementById('confirmMessage');

    var goodColor = "#99CC99";
    var badColor = "#DC1D1D";

    if(pass1.value == pass2.value){
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
        }else{

        pass2.style.backgroundColor = badColor;

        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
}
</script>
<!--*********************************************representative******************************************************** -->
<div id="representativetype" style="display: none;">
   <h4 style="background-color: green ;color: white ">representative user</h4>

      <form  name="" action="./portal/repregister_action.php" method='post' >
         Employee ID:<br>  <input placeholder="Enter your national ID" type="text" name="empid" required="required" maxlength="10" minlength="10" pattern="^(0|[1-9][0-9]*)$" >
         <br>
         Username: <br> <input type="text" name="username" placeholder="Set a username" required="required">
         <br>
         Password: <br> <input type="password" name="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="password3">
         <br>
         Repeat Password: <br> <input type="password" name="rpassword" required="required" id="rpassword4" onkeyup="checkPass2(); return false;">
		 <span id="confirmMessage2" class="confirmMessage"></span>
         <br>
         Authorization Code: <input placeholder="Enter the code you were given, Example: 123456" type="text" name="authcode" minlength="6" maxlength="6"  pattern="^(0|[1-9][0-9]*)$">
         <br>
         <input type="hidden" name="ref" value="rep">
         <input type="submit"  style="position: center; background-color:green color:white" onsubmit="return validateForm()" value="SIGN up">
      </form>


 <br>
Register as <a href="#"onclick="iuser()">individual user</a>
Or <a href="#"onclick="ins()">Institution owner</a>
<br>
You have an account? <a   href="#" onclick="login()">login</a>
</div>

<script type="text/javascript">
  function checkPass2()
{    var pass1 = document.getElementById('password3');
     var pass2 = document.getElementById('rpassword4');
     var message = document.getElementById('confirmMessage2');

    var goodColor = "#99CC99";
    var badColor = "#DC1D1D";

    if(pass1.value == pass2.value){
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
        }else{

        pass2.style.backgroundColor = badColor;

        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
}
</script>
 <!-- *****************************************  Institution  ********************************************************* -->

 <div id="Institutionreg" style="display: none;">
     <h4 style="background-color: green ;color: white ">Institution owner</h4>
       <form  name="" action="./portal/newinst.php" method='post' >
            Institution ID:<br>  <input type="text" name="idinst" pattern="^(0|[1-9][0-9]*)$" maxlength="7" minlength="7" required="required">
            <br>
            Personal ID:<br>  <input type="text" name="iduser" maxlength="10" maxlength="10" pattern="^(0|[1-9][0-9]*)$" required="required">
            <br>
            Email:  <br>  <input type="email" name="email" required="required">
            <br>
            password: <br> <input type="password" name="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="password5">
            <br>
            Repeat Password: <br> <input type="password" name="rpassword" required="required" onkeyup="checkPass3(); return false;"
            pattern ="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="rpassword6">
            <br>
			<span id="confirmMessage3" class="confirmMessage"></span>
            <input type="submit"  style="position: center; background-color:green color:white" onsubmit="return validateForm()" value="Sign up">
       </form>
      <br>
      Register as  <a href="#" onclick="ruser()">representative user</a>
      Or <a href="#"onclick="iuser()">individual user</a>
      <br>
      You have an account? <a   href="#" onclick="login()" >login</a>
 </div>

<script type="text/javascript">
  function checkPass3()
{    var pass1 = document.getElementById('password5');
     var pass2 = document.getElementById('rpassword6');
     var message = document.getElementById('confirmMessage3');

    var goodColor = "#99CC99";
    var badColor = "#DC1D1D";

    if(pass1.value == pass2.value){
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
        }else{

        pass2.style.backgroundColor = badColor;

        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
}
</script>

 <!-- ********************************************************************************************************************************* -->



<script>
      function iuser() {
          document.getElementById('Institutionreg').style.display ="none";
         document.getElementById('representativetype').style.display ="none";
         document.getElementById('divusertype').style.display = "none";
         document.getElementById('individualtype').style.display = "block";
      }
   function ruser(){
           document.getElementById('Institutionreg').style.display ="none";
          document.getElementById('divusertype').style.display ="none";
          document.getElementById('individualtype').style.display="none";
          document.getElementById('representativetype').style.display ="block";

      }
      function ins(){

          document.getElementById('divusertype').style.display ="none";
          document.getElementById('individualtype').style.display="none";
          document.getElementById('representativetype').style.display ="none";
          document.getElementById('Institutionreg').style.display ="block";
      }


</script>

  </div>





    <div class="col-sm-4">
     <a href= "#" onclick="newpass()"> <img src="./resources/images/imgMp/Password.png"> </a>
      <h4>Password Recovery </h4>
    </div>
   </div>
   </div>


 <?php

#new user  php


    ?>

     <!--   ************************************new password**************************************************  -->


<div id="newpasword" class="container-fluid text-center"  style="display:none;">
  <h2>sign up</h2>
  <div class="row slideanim">
  <div class="col-sm-4"  >
    <a   href="#" onclick="login()" ><img src="./resources/images/imgMp/login.png" ></a>
       <h4>login</h4>
    </div>
     <div class="col-sm-4">
         <a href="#" onclick="newuser()"><img src="./resources/images/imgMp/newuser.png" ></a>
      <h4>New user</h4>
    </div>
    <div class="col-sm-4">

       <div>
      <h4 style="background-color: green ;color: white">Password Recovery </h4>
      <form action="" method="post">
		<select id="soflow-color" name="type">
           Account as
           <option value="ind" name="ind">Individual User</option>
           <option value="rep" name="rep">Representative User</option>
           <option value="owner" name="owner">Institution Owner</option>
        </select>
       Username:<br> <input type="text" name="id" required="required" placeholder="For representatives and owners, enter your ID">
       <br>
       Email:<br>  <input type="email" name="email" required="required">
       <br>
       <input type="submit" name="submitpass"  value="send"  style="position: center; background-color:green">
      </form>

    </div>
	<!-- comment1 -->

   </div>
   </div>

<?php

if (isset($_POST["submitpass"])) {
 $id = $_POST['id'];
 $email = $_POST['email'];
 $type = $_POST['type'];

$newPass = $User->recoverPassword($id, $type, $email);

if ($newPass != -1 && $newPass != -2) {
  $pass = $newPass;
  $em = $_POST["email"];
  $to = $em;
  $from = "almufadhli@gmail.com";
  $message = $pass;
  $message = wordwrap($message, 70);
  $headers = "From:" . $from;
  $subject = "Password recovery";
  $test = mail($to , $subject, $message, $headers);


} elseif ($newPass == -1) {
  echo "<script>alert('The email you entered is wrong')</script>";
} else {
  echo "<script>alert('You entered a wrong ID or Username')</script>";
}

}

 ?>

</div>





<script>
      function login() {
         document.getElementById('newuser2').style.display = "none";
        document.getElementById('newpasword').style.display = "none"
        document.getElementById('signup1').style.display = "none";
        document.getElementById('signup2').style.display = "block";
      }
   function newuser() {
         document.getElementById('signup1').style.display = "none";
         document.getElementById('signup2').style.display = "none";
          document.getElementById('newpasword').style.display ="none";
         document.getElementById('newuser2').style.display = "block";
      }
        function newpass() {
         document.getElementById('signup1').style.display = "none";
         document.getElementById('signup2').style.display = "none";
         document.getElementById('newuser2').style.display = "none";
        document.getElementById('newpasword').style.display = "block";
      }

 function signupnav() {
         document.getElementById('signup1').style.display = "block";
         document.getElementById('signup2').style.display = "none";
          document.getElementById('newpasword').style.display ="none";
         document.getElementById('newuser2').style.display = "none";
      }

</script>



 <!-- -------------------------------------------------------------------------------------------------- -->


<script>


</script>


<div class="container-fluid bg-grey">

<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2  style="color: green">About </h2><br>
		<div  style="border: 2px solid green;">
      <p>This site is a site to save user data. It is a file cabinet that the user can get his files at any time and at any place.</p><br>
		<hr color ="green">
      <p>It includes files for several specific sections: eg health section, scientific section and practical section. In addition, each of these sections can view their own reports related to this person in the presence of the protection and confidentiality of information.</p>
	</div>
    </div>
    <div class="col-sm-4">
      <span class="img"><img src="./resources/images/logo.png" height="200" width="200"></span>
    </div>
  </div>
</div>

</div>



<div id="news" class="container-fluid   text-center ">
  <h2 style="color: green">NEWS</h2><br>

  <div class="row text-center slideanim">
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="./resources/images/imgMp/ed.png" alt="kau"  width="50px" height="50px" style="height:150px;">
        <p><strong style="color: green">Education</strong></p>
        <p style="color: green">King Abdulaziz University </p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="./resources/images/imgMp/ws.jpg" alt="Kau hospatil" width="50px" height="60px" style="height: 150px;">
        <p><strong style="color: green">Health</strong></p>
        <p style="color: green">Kau Hospital</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="./resources/images/imgMp/wa.jpg" alt="JOB3" width="50px" height="50px"  style="height: 150px;">
        <p><strong style="color: green">work </strong></p>
        <p style="color: green">KAU</p>
      </div>
    </div>
  </div><br>


  <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>


    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <h4 style="color: green">"Health"<br><span>Kau Hospital</span></h4>
      </div>
      <div class="item">
        <h4 style="color: green">"work."<br><span>KAU</span></h4>
      </div>
      <div class="item">
        <h4 style="color: green">"Education"<br><span>King Abdulaziz University</span></h4>
      </div>
    </div>


    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only" style="color: green">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only" style="color: green">Next</span>
    </a>
  </div>
</div>


<div id="goal" class="container-fluid bg-grey">
  <div class="text-center">
    <h2 style="color: green">OUR GOAL</h2>

  </div>
  <div class="row slideanim">
    <div class="col-sm-4 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1> For Public</h1>
        </div>
       <div class="panel-body">
          <p> Easy access to reports </p>
          <p> All information is in one place </p>
          <p> Conduct transactions at any time and any place </p>
          <p> Save previous reports </p>
          <p> Goodbye paperwork </p>
        </div>

      </div>
    </div>
    <div class="col-sm-4 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>For  User</h1>
        </div>
        <div class="panel-body">
          <p> Saving data </p>
          <p> Easy access to data</p>
          <p> Access files at any time</p>
          <p> Access files anywhere</p>
          <p> Completion of transactions without effort</p>
        </div>

      </div>
    </div>
    <div class="col-sm-4 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>For Institutions</h1>
        </div>
         <div class="panel-body">
          <p> Get a background for the user </p>
          <p> Completion of transactions without effort</p>
          <p> All information is in one place</p>
          <p> writing reports</p>
          <p>Reading old  reports</p>
        </div>

      </div>
    </div>
  </div>
</div>


<div id="contact" class="container-fluid ">
  <h2 class="text-center" style="color: green">CONTACT</h2>
  <div class="row">
    <div class="col-sm-5">
      <p>Contact us.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span> jaddah, KSA</p>
      <p><span class="glyphicon glyphicon-phone"></span> +00966571405435</p>
      <p><span class="glyphicon glyphicon-envelope"></span> cpcs_499@gmail.com </p>
    </div>
    <div class="col-sm-7 slideanim">
      <div class="row">
       <form action="" method="post">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required="required">
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required="required">
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" maxlength="70" placeholder="Comment" rows="5" required="required"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit" name="send">Send</button>
        </div>
      </div>

    </div>
    </form>
  </div>
</div>


	<?php

if (isset($_POST["send"])) {

//if and else
 $text =$_POST["comments"];;
 $em= "almufadhli@gmail.com";
 $to = $em;
 $from = $_POST["email"];
 $message ="Hi ".$em.", \r\n "
   .$text.". \r\n Thanks, \r\n".$from;
 $message = wordwrap($message, 70);
 $headers = "From:" . $to;
 $subject = "تواصل معنا ";
 mail($to , $subject, $message, $headers);
 }
 ?>
<footer class="container-fluid bg-grey text-center bg-grey" style="background-color: green;  color:white">
  <a href="#myPage" title="To Top" style="background-color: white">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>design  By M and A for cpcs_499</p>
</footer>

<script>
$(document).ready(function(){

  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

    if (this.hash !== "") {

      event.preventDefault();


      var hash = this.hash;


      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){


        window.location.hash = hash;
      });
    } // End if
  });

  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})
</script>





</body>
</html>
