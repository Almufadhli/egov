<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <script src="./js/matchpasswords.js" language='javascript' type='text/javascript' ></script>
  </head>
  <body>

    <div class="container">
      <form onsubmit="return chk()" action="register_action.php"  style="border:1px solid #ccc" method="post">
      <div class="container">
        <h1>Sign Up</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="ID"><b>ID</b></label>
        <input type="text" placeholder="Enter your ID or Iqama" name="nationalID" required><br>

        <label for="ID"><b>Username</b></label>
        <input type="text" placeholder="Enter your desired username" name="username" required><br>

        <label for="email"><b>Email</b></label>
        <input type="email" placeholder="Enter a valid Email" name="email" required><br>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" id="psw" name="psw" required><br>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" id="rpsw" name="rpsw" required oninput="check(this)"><br>

        <label>
          <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
        </label>


        <div class="clearfix">
          <button type="button" class="cancelbtn">Cancel</button>
          <button type="submit" class="signupbtn">Sign Up</button>
        </div>
      </div>
    </form>



    </div>

  </body>
</html>
