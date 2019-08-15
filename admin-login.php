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
if(isset($_POST["code"])){
	$code = $_POST['code'];
	$password = md5($_POST['password']);
	$today_time = date("Y-m-d H:i:s", strtotime("now"));
	if($code == "" || $password == ""){
		echo "error_occurred";
        exit();
	} else {
		include_once("php_files/db_connection.php");
		 $sql = mysqli_query($conn_str, "SELECT id FROM admin WHERE code='$code' AND password='$password' LIMIT 1"); 
		$existCount = mysqli_num_rows($sql);
		if ($existCount == 1) { 
			 while($row = mysqli_fetch_array($sql)){ 
				 $id = $row["id"];
			 }
			 $_SESSION["id"] = $id;
			 $_SESSION["code"] = $code;
			 $_SESSION["password"] = $password;
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
<title>Healthy Smiles | Administrator Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="page">
  <div id="header"><a href="index.php" id="logo"><img src="images/logo.gif" alt=""/></a>
    <ul id="navigation">
      <li><a href="index.php">home</a></li>
      <li><a href="about.php">about us</a></li>
      <li><a href="specialist_login.php">specialist login</a></li>
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
	<!-- <img src="images/services-model.jpg" alt="" /> -->
	<h2>Administrator Login</h2>
	<form method="post" onSubmit="return false;">
        <table cellspacing="10">
          <tbody>
            <tr>
              <td><label>Code</label></td>
              <td><input type="text" name="code" id="code" class="txtfield" /></td>
            </tr>
            <tr>
              <td><label>Password</label></td>
              <td><input type="password" name="password" id="password" class="txtfield" /></td>
            </tr>
            <tr>
              <td colspan="10" align="right"><button type="submit" onclick="adminLogin()" style="width: 100px;height: 40px;font-size: 16px;">Login</button></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
<?php include_once("php_files/footer_stuff.php");?>
</div>
<div align=center></div>
<script src="javascript/main.js"></script>
<script type="text/javascript">
function adminLogin(){
	var code = get("code").value;
	var password = get("password").value;
	if(code == "" || password == ""){
		alert("Please enter your code and password");
	} else {
		var ajax = ajaxObj("POST", "admin-login.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "error_occurred"){
					alert("Login was unsuccessful");
				}else{
					window.location = "administrator.php";
				}
	        }
        }
        ajax.send("code="+code+"&password="+encodeURIComponent(password));
	}
}
</script>
</body>
</html>
