<?php 
/*!
 * Developer (mtc) : Kwabena A. Dougan
 *
 *
 * Copyright Luci Foundation and other contributors
 * Released under the MIT license
 *
 * Date: 2018-06-05T19:26TM
 */
session_start();
if (isset($_SESSION["code"])) {
    header("location: administrator.php"); 
    exit();
}else if (isset($_SESSION["spid"])) {
    header("location: specialist.php"); 
    exit();
}
?><?php
if(isset($_POST["email"])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	if($email == "" || $password == ""){
		echo "error_occurred";
        exit();
	} else {
		include_once("php_files/db_connection.php");
		 $sql = mysqli_query($conn_str, "SELECT id FROM specialist WHERE email='$email' AND password='$password' LIMIT 1"); 
		$existCount = mysqli_num_rows($sql);
		if ($existCount == 1) { 
			 while($row = mysqli_fetch_array($sql)){ 
				 $id = $row["id"];
			 }
			 $_SESSION["spid"] = $id;
			 $_SESSION["email"] = $email;
			 $_SESSION["pass"] = $password;
			 echo 'done';
			 exit();
		} else {
			echo 'error_occurred';
			exit();
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Healthy Smiles | Doctor Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="page">
  <div id="header"><a href="index.php" id="logo"><img src="images/logo.gif" alt=""/></a>
    <ul id="navigation">
      <li><a href="index.php">home</a></li>
      <li><a href="about.php">about us</a></li>
      <li class="selected"><a href="specialist_login.php">specialist login</a></li>
      <li><a href="book-appointment.php">book an appointment</a></li>
    </ul>
  </div>
  <div class="content" style="min-height: 320px;">
    <div class="navigation">
      <ul>
        <li id="link2"><a href="about-specialists.php">Our Specialists</a></li>
      </ul>
    </div>
    <div>
	<h2>Specialist Login</h2>
	<form method="post" onSubmit="return false;">
        <table cellspacing="10">
          <tbody>
            <tr>
              <td><label>Email</label></td>
              <td><input type="text" name="email" id="email" class="txtfield" /></td>
            </tr>
            <tr>
              <td><label>Key</label></td>
              <td><input type="password" name="password" id="password" class="txtfield" /></td>
            </tr>
            <tr>
              <td colspan="10" align="right"><button type="submit" onclick="specialistLogin()" style="width: 100px;height: 40px;font-size: 16px;">Login</button></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<div align=center></div>
<script src="javascript/main.js"></script>
<script type="text/javascript">
function specialistLogin(){
	var email = get("email").value;
	var password = get("password").value;
	if(email == "" || password == ""){
		alert("Please enter your email and password");
	} else {
		var ajax = ajaxObj("POST", "specialist_login.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "error_occurred"){
					alert("Login was unsuccessful");
				}else{
					window.location = "specialist.php";
				}
	        }
        }
        ajax.send("email="+email+"&password="+encodeURIComponent(password));
	}
}
/*!
 * Developer (mtc) : Kwabena A. Dougan
 *
 *
 * Copyright Luci Foundation and other contributors
 * Released under the MIT license
 *
 * Date: 2018-06-05T19:26TM
 */
</script>
</body>
</html>
