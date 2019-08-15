<?php
session_start();
if (!isset($_SESSION["code"])) {
    header("location: admin-login.php"); 
    exit();
}
?><?php
if(isset($_POST["fname"])){
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$number = $_POST['number'];
	$type = $_POST['type'];
	$email = $_POST['email'];
	$rand_pass = "sP".rand(100,999)."";
	if($lname == "" || $number == "" || $fname == "" || $type == "" || $email == ""){
		echo "error_occurred";
        exit();
	} else {
		include_once("php_files/db_connection.php");
		 $sql = "INSERT INTO specialist (firstname, lastname ,email, password, phone_number, specialist_type)       
		        VALUES('$fname','$lname','$email','$rand_pass',$number,'$type')";
        $query = mysqli_query($conn_str, $sql);
		$message .= 'Hello Dr. '.$fname.' '.$lname.', your account has been created successfully.<br>';
		$message .= 'Here are your login details:<br>';
		$message .= 'Email: '.$email.'<br>';
		$message .= 'Key: '.$rand_pass.'';
		$sql0 = "INSERT INTO email (email_type, email ,text)VALUES('Account Details','$email','$message')";
        $_query = mysqli_query($conn_str, $sql0);	
		
		$to = "$email";							 
		$from = "noreply@healthysmiles.com";
		$subject = 'Healthy Smiles Account Details';
		$email_message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
		$email_message .= '<div style="padding: 20px;background-color: rgb(217, 226, 245);">'.$message.'</div>';
		$email_message .= '<br /><br /><br /><b>Healthy Smiles Administrator</b></span></body></html>';

		$headers = "From: noreply@healthysmiles.com\r\n";
		$headers .= "Reply-To: noreply@healthysmiles.com\r\n";
		$headers .= "Return-Path: noreply@healthysmiles.com\r\n";
		$headers .= "CC: noreply@healthysmiles.com\r\n";
		$headers .= "BCC: noreply@healthysmiles.com\r\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $email_message, $headers);
		
		echo "done";
        exit();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Healthy Smiles | Administrator</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="page">
  <div id="header"><a href="index.php" id="logo"><img src="images/logo.gif" alt=""/></a>
    <ul id="navigation">
      <li><a href="index.php">You are logged in as Administrator</a></li>
    </ul>
  </div>
  <div class="content" style="min-height: 600px;">
    <div class="navigation">
      <ul>
        <li id="link1"><a href="administrator.php">Dashboard</a></li>
		<li id="link2" style="margin-left: 5px;"><a href="pending-appointment.php" style="width: 240px;margin-right: 4px;">Appointments</a></li>
		<li id="link3"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
    <div>
	<h2>Add Specialist</h2>
	<form method="post" onSubmit="return false;">
        <table cellspacing="10">
          <tbody>
            <tr>
              <td><label>Firstname</label></td>
              <td><input type="text" name="fname" id="fname" class="txtfield" /></td>
            </tr>
			 <tr>
              <td><label>Lastname</label></td>
              <td><input type="text" name="lname" id="lname" class="txtfield" /></td>
            </tr>
			 <tr>
              <td><label>Email</label></td>
              <td><input type="email" name="email" id="email" class="txtfield" /></td>
            </tr>
            <tr>
              <td><label>Number</label></td>
              <td><input type="text" name="number" id="number" class="txtfield" maxlength="10" /></td>
            </tr>
			 <tr>
              <td><label>Type</label></td>
              <td>
				 <select name="type" id="type" class="txtfield" style="width: 100%;">
				  <option selected disabled value="">Select specialist type:</option>
				  <option value="Medical Oncologist">Medical Oncologist</option>
				  <option value="Pediatric Oncologist">Pediatric Oncologist</option>
				  <option value="Radiation Oncologist">Radiation Oncologist</option>
				  <option value="Gynecologic Oncologist">Gynecologic Oncologist</option>
				</select> 
			  
			  </td>
            </tr>
            <tr>
              <td colspan="10" align="right"><button type="submit" onclick="addSpecialist()" style="width: 100px;height: 40px;font-size: 16px;">Add</button></td>
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
function addSpecialist(){
	var fname = get("fname").value;
	var lname = get("lname").value;
	var email = get("email").value;
	var number = get("number").value;
	var type = get("type").value;
	if(fname == "" || lname == "" || email == "" || number == "" || type == ""){
		alert("Please fill all textboxes");
	} else {
		var ajax = ajaxObj("POST", "add-specialist.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "error_occurred"){
					alert("An uunknown error occurred. Please try again");
				}else{
					window.location = "administrator.php";
				}
	        }
        }
        ajax.send("fname="+fname+"&lname="+lname+"&number="+number+"&type="+type+"&email="+encodeURIComponent(email));
	}
}
</script>
</body>
</html>
