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
if (!isset($_SESSION["code"])) {
    header("location: admin-login.php"); 
    exit();
}
include_once("php_files/db_connection.php");
?><?php
if (isset($_POST["approve"]) && $_POST["pid"] != "" && $_POST['approve'] == "pat"){
	$pid = preg_replace('#[^0-9]#', '', $_POST["pid"]);
	$doc = $_POST["doc"];
	$_query = mysqli_query($conn_str, "SELECT * FROM appointments WHERE id='$pid' LIMIT 1");
	$rows = mysqli_num_rows($_query);
	if ($rows == 1) { 
		$sql0 = "UPDATE appointments SET approved='1',specialist='$doc' WHERE id='$pid' LIMIT 1";
		$query = mysqli_query($conn_str, $sql0);
		$_query0 = mysqli_query($conn_str, "SELECT * FROM appointments WHERE id='$pid' LIMIT 1");
		while ($row = mysqli_fetch_array($_query0, MYSQLI_ASSOC)) {
			$firstname = $row["firstname"];
			$lastname = $row["lastname"];
			$email = $row["email"];
			$concern = $row["concern"];
			$date = $row["date"];
			$time = $row["time"];
			$specialist = $row["specialist"];
		}
		$message .= 'Hi '.$firstname.' '.$lastname.', your appointment has been approved.<br>';
		$message .= 'Here are your updated booking details:<br>';
		$message .= 'Specialist: '.$specialist.'<br>';
		$message .= 'Date: '.$date.'<br>';
		$message .= 'Time: '.$time.'';
		$sql = "INSERT INTO email (email_type, email ,text)VALUES('Appointment Approval','$email','$message')";
        $query = mysqli_query($conn_str, $sql);	
		
		$to = "$email";							 
		$from = "noreply@healthysmiles.com";
		$subject = 'Appointment Approval';
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
		
		echo "approve_ok";
		exit();
	}else{
		echo "approve_failed";
		exit();
	}
}
?><?php
if (isset($_POST["disapprove"]) && $_POST["pid"] != "" && $_POST['disapprove'] == "cat"){
	$pid = preg_replace('#[^0-9]#', '', $_POST["pid"]);
	$_query = mysqli_query($conn_str, "SELECT * FROM appointments WHERE id='$pid' LIMIT 1");
	$rows = mysqli_num_rows($_query);
	if ($rows == 1) { 
		$_query0 = mysqli_query($conn_str, "SELECT * FROM appointments WHERE id='$pid' LIMIT 1");
		while ($row = mysqli_fetch_array($_query0, MYSQLI_ASSOC)) {
			$o_firstname = $row["firstname"];
			$o_lastname = $row["lastname"];
			$o_email = $row["email"];
		}
		$o_message .= 'Hi '.$o_firstname.' '.$o_lastname.', your appointment was disapproved.<br>';
		$o_message .= 'Please re-book your appointment and wait for feedback <br>';
		$sql = "INSERT INTO email (email_type, email ,text)VALUES('Appointment Disapproval','$o_email','$o_message')";
        $query = mysqli_query($conn_str, $sql);	
		$sql0 = "DELETE FROM appointments WHERE id='$pid' LIMIT 1";
		$query0 = mysqli_query($conn_str, $sql0);
		
		$to = "$o_email";							 
		$from = "noreply@healthysmiles.com";
		$subject = 'Appointment Disapproval';
		$email_message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
		$email_message .= '<div style="padding: 20px;background-color: rgb(217, 226, 245);">'.$o_message.'</div>';
		$email_message .= '<br /><br /><br /><b>Healthy Smiles Administrator</b></span></body></html>';

		$headers = "From: noreply@healthysmiles.com\r\n";
		$headers .= "Reply-To: noreply@healthysmiles.com\r\n";
		$headers .= "Return-Path: noreply@healthysmiles.com\r\n";
		$headers .= "CC: noreply@healthysmiles.com\r\n";
		$headers .= "BCC: noreply@healthysmiles.com\r\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $email_message, $headers);
		
		echo "disapprove_ok";
		exit();
	}else{
		echo "disapprove_failed";
		exit();
	}
}
?><?php
$list_pending_appointments = "";$list_specialists = "";
$sql1 = "SELECT * FROM specialist";
$query = mysqli_query($conn_str, $sql1);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	
	$list_specialists .= '<option value="Dr. '.$firstname.' '.$lastname.'">Dr. '.$firstname.' '.$lastname.'</option>';
}
$sql = "SELECT * FROM appointments WHERE approved='0'";
$_query = mysqli_query($conn_str, $sql);
while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
	$a_id = $row["id"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$email = $row["email"];
	$concern = $row["concern"];
	$date = $row["date"];
	$time = $row["time"];
	$list_pending_appointments .= '<tr id="a_id'.$a_id.'"><td>'.$firstname.' '.$lastname.'</td><td>'.$email.'</td><td>'.$concern.'</td>';
	$list_pending_appointments .= '<td>'.$date.'</td><td>'.$time.'</td>';
	$list_pending_appointments .= '<td><select name="specialist'.$a_id.'" id="specialist'.$a_id.'" class="txtfield" style="width: 100%;margin-bottom: 10px;">';	
	$list_pending_appointments .= '<option selected disabled value="">Select specialist:</option>'.$list_specialists.'</select> ';	
	$list_pending_appointments .= '<button onclick="approveUser(\''.$a_id.'\',\'a_id'.$a_id.'\',\'specialist'.$a_id.'\');" style="width: 100%;">Approve</button>';	
	$list_pending_appointments .= '<button onclick="disapproveUser(\''.$a_id.'\',\'a_id'.$a_id.'\');" style="width: 100%;background: #ed9e9e;">Disapprove</button></td></tr>';	
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
  <div class="content" style="min-height: 1000px;">
    <div class="navigation">
      <ul>
        <li id="link1"><a href="add-specialist.php">+ Add Specialist</a></li>
        <li id="link2"><a href="administrator.php">Dashboard</a></li>
		<li id="link3"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
    <div>
	<h2>Pending Appointments</h2>
	 <table id="t01" style="width:100%">
		<tr>
			<th>Patient</th>
			<th>Email</th>
			<th>Concern</th>
			<th>Date</th>
			<th>Time</th>
			<th>Approval</th>
		</tr>
		<?php echo $list_pending_appointments;?>
	</table> 
	
    </div>
  </div>
</div>
<div align=center></div>
<script src="javascript/main.js"></script>
<script type="text/javascript">
function approveUser(pid,pat,doc){
	var specailist = get(doc).value;
	if(specailist == ""){
		alert("Please selcet specialist for patient");
	}else{
		var ajax = ajaxObj("POST", "pending-appointment.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "approve_failed"){
					alert("Approval was unsuccessful");
				}else{
					alert("Approval was successful!");
					get(pat).style.display = "none";
				}
			}
		}
		ajax.send("approve=pat&pid="+pid+"&doc="+encodeURIComponent(specailist));
	}
}
function disapproveUser(pid,cat){
	var ajax = ajaxObj("POST", "pending-appointment.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "disapprove_failed"){
				alert("Disapproval was unsuccessful");
			}else{
				alert("Disapproval was successful!");
				get(cat).style.display = "none";
			}
		}
	}
	ajax.send("disapprove=cat&pid="+pid);
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
