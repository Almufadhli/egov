function chk(){

var psw = document.getElementById("psw").value;
var rpsw = document.getElementById("rpsw").value;

    if(psw!=rpsw){
      document.getElementById("error").innerHTML = "Passwords do not match!";
        document.getElementById("rpsw").value = "";
    }
    else{
        document.getElementById("error").innerHTML = "Passwords match!";
    }
}
