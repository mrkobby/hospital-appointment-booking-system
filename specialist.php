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
if (!isset($_SESSION["spid"])) {
    header("location: specialist_login.php"); 
    exit();
}
include_once("php_files/db_connection.php");
$sid = preg_replace('#[^0-9]#i', '', $_SESSION["spid"]);
$session_email = $_SESSION["email"];
$session_pass = $_SESSION["pass"];
$sql = mysqli_query($conn_str, "SELECT * FROM specialist WHERE id='$sid' AND email='$session_email' AND password='$session_pass' LIMIT 1");
$existCount = mysqli_num_rows($sql);
if ($existCount == 0) { 
	 echo "Your login session data is not on record in the database.";
	 header("location: specialist_login.php"); 
     exit();
}
?><?php
if(isset($_POST["date_day"])){
	$date_day = $_POST['date_day'];
	$date_month = $_POST['date_month'];
	$hour = $_POST['hour'];
	$minute = $_POST['minute'];
	$am_pm = $_POST['am_pm'];
	$mail = $_POST['mail'];
	if($date_month == "" || $hour == "" || $mail == ""){
		echo "error_occurred";
        exit();
	}else {
		$date_string = '2018-'.$date_month.'-'.$date_day.'';
		$time_string = ''.$hour.':'.$minute.' '.$am_pm.'';
		$sql1 = "UPDATE appointments SET date='$date_string',time='$time_string' WHERE email='$mail' LIMIT 1";
		$query = mysqli_query($conn_str, $sql1);
		
		$o_message .= 'Hi there, your appointment was re-schduled by your specialist.<br>';
		$o_message .= 'Here are your updated booking details: <br>';
		$o_message .= 'Date: '.$date_string.'<br>';
		$o_message .= 'Time: '.$time_string.'';
		$sql = "INSERT INTO email (email_type, email ,text)VALUES('Appointment Updated','$mail','$o_message')";
        $query = mysqli_query($conn_str, $sql);	

		$to = "$mail";							 
		$from = "noreply@healthysmiles.com";
		$subject = 'Appointment Updated';
		$email_message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
		$email_message .= '<div style="padding: 20px;background-color: rgb(217, 226, 245);">'.$o_message.'</div>';
		$email_message .= '<br /><br /><br /><b>Healthy Smiles</b></span></body></html>';

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
?><?php
$specialist_name = '';
$today_time = date("D - d - M - Y", strtotime("now"));
$sql = "SELECT * FROM specialist WHERE id='$sid' LIMIT 1";
$_query = mysqli_query($conn_str, $sql);
while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
	$s_id = $row["id"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$email = $row["email"];
	$phone_number = $row["phone_number"];
	$specialist_type = $row["specialist_type"];
	
	$specialist_name = 'Dr. '.$firstname.' '.$lastname.'';
}
?><?php
$list_appointments = "";
$sql0 = "SELECT * FROM appointments WHERE approved='1' AND specialist='$specialist_name' ORDER BY date ASC";
$query = mysqli_query($conn_str, $sql0);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$p_id = $row["id"];
	$p_firstname = $row["firstname"];
	$p_lastname = $row["lastname"];
	$p_email = $row["email"];
	$p_concern = $row["concern"];
	$p_date = $row["date"];
	$p_time = $row["time"];
	
	$list_appointments .= '<tr id="p_id'.$p_id.'"><td>'.$p_firstname.' '.$p_lastname.'</td>
							<td>'.$p_concern.'</td><td><span id="date'.$p_id.'">'.$p_date.'</span>
								<select name="date_day" id="date_day'.$p_id.'" class="txtfield" style="display:none;width: 45px;height: 26px;margin-bottom: 10px;">
								<option Selected disabled value="">Day</option>
								<option disabled value="1">1</option><option disabled value="2">2</option><option disabled value="3">3</option><option disabled value="4">4</option>
								<option disabled value="5">5</option><option disabled value="6">6</option><option disabled value="7">7</option><option disabled value="8">8</option>
								<option disabled value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
								<option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option>
								<option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option>
								<option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option>
								<option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option>
								<option value="29">29</option><option value="30">30</option><option value="31">31</option>
								</select> 
								<select name="date_month" id="date_month'.$p_id.'" class="txtfield" style="display:none;width: 78px;height: 26px;">
								<option Selected disabled value="">Month</option>
								<option disabled value="1">January</option><option disabled value="2">February</option><option disabled value="3">March</option><option disabled value="4">April</option>
								<option disabled value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option>
								<option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>
								</select> 	
							</td>
							<td><span id="time'.$p_id.'">'.$p_time.'</span>
								<input type="number" name="hour" id="hour'.$p_id.'" style="display:none;width: 40px;margin-bottom: 5px;height: 22px;" placeholder="00" class="txtfield" min="1" max="12" maxlength="2" />
								<select name="minute" id="minute'.$p_id.'" class="txtfield" style="display:none;width: 65px;height: 26px;margin-bottom: 8px;">
								<option value="00">00</option><option value="05">05</option><option value="10">10</option><option value="15">15</option>
								<option value="20">20</option><option value="25">25</option><option value="30">30</option><option value="45">45</option>
								</select> 
								<select name="am_pm" id="am_pm'.$p_id.'" class="txtfield" style="display:none;width: 65px;height: 26px;">
								<option Selected disabled value="">am/pm</option>
								<option value="AM">AM</option><option value="PM">PM</option>
								</select> 
							</td>
						<td><button id="btn1'.$p_id.'" style="display:;width: 100%" onclick="reschedule(\'p_id'.$p_id.'\',\'date'.$p_id.'\',\'time'.$p_id.'\',\'date_day'.$p_id.'\',\'date_month'.$p_id.'\',\'hour'.$p_id.'\',\'minute'.$p_id.'\',\'am_pm'.$p_id.'\',\'btn1'.$p_id.'\',\'btn2'.$p_id.'\',\'btn3'.$p_id.'\');" style="width: 100%;">Edit</button>
						<button id="btn2'.$p_id.'" style="display:none;width: 100%;margin-bottom: 10px;" onclick="submitSchedule(\'date_day'.$p_id.'\',\'date_month'.$p_id.'\',\'hour'.$p_id.'\',\'minute'.$p_id.'\',\'am_pm'.$p_id.'\',\''.$p_email.'\');" style="width: 100%;">Update</button>
						<button id="btn3'.$p_id.'" style="display:none;width: 100%;" onclick="cancelSchedule(\'p_id'.$p_id.'\',\'date'.$p_id.'\',\'time'.$p_id.'\',\'date_day'.$p_id.'\',\'date_month'.$p_id.'\',\'hour'.$p_id.'\',\'minute'.$p_id.'\',\'am_pm'.$p_id.'\',\'btn1'.$p_id.'\',\'btn2'.$p_id.'\',\'btn3'.$p_id.'\');" style="width: 100%;">Cancel</button>
						
						</td></tr>';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Healthy Smiles | Specialist</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="page">
  <div id="header"><a href="index.php" id="logo"><img src="images/logo.gif" alt=""/></a>
    <ul id="navigation">
      <li><a href="index.php">You are logged in as <?php echo $email;?></a></li>
      <li><a href="index.php"><?php echo $specialist_name;?></a></li>
      <li><a href="index.php"><?php echo $specialist_type;?></a></li>
      <li><a href="index.php">Phone: 0<?php echo $phone_number;?></a></li>
      <li><a><?php echo $today_time;?></a></li>
    </ul>
  </div>
  <div class="content" style="min-height: 920px;">
    <div class="navigation">
      <ul>
        <li class="selected" id="link2"><a style="width: 253px;" href="#">Hello Dr. <?php echo $firstname;?></a></li>
		<li id="link2"><a href="javascript:void(0)" onclick="printAppointments('appointmentsTable')" style="width: 230px;margin-left: -55px;">Print Appointments</a></li>
		<li id="link3"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
    <div id="appointmentsTable">
	<h2 style="text-align: center;">Your Appointments</h2>
	<h5 style="text-align: center;margin-top: -15px;">Date: <?php echo $today_time;?></h5>
	<table id="t01" style="width:100%">
		<tr>
			<th>Patient</th>
			<th>Concern</th>
			<th>Date</th>
			<th>Time</th>
		</tr>
		<?php echo $list_appointments;?>
	</table> 
	
    </div>
  </div>
</div>
<div align=center></div>
<script src="javascript/main.js"></script>
<script type="text/javascript">
function reschedule(trid,dateid,timeid,datedayid,datemonthid,hourid,minuteid,ampmid,btn1,btn2,btn3){
	document.getElementById(dateid).style.display = "none";	
	document.getElementById(timeid).style.display = "none";	
	document.getElementById(datedayid).style.display = "block";	
	document.getElementById(datemonthid).style.display = "block";	
	document.getElementById(hourid).style.display = "block";	
	document.getElementById(minuteid).style.display = "block";	
	document.getElementById(ampmid).style.display = "block";	
	document.getElementById(btn1).style.display = "none";	
	document.getElementById(btn2).style.display = "block";	
	document.getElementById(btn3).style.display = "block";	
}
function cancelSchedule(trid,dateid,timeid,datedayid,datemonthid,hourid,minuteid,ampmid,btn1,btn2,btn3){
	document.getElementById(dateid).style.display = "block";	
	document.getElementById(timeid).style.display = "block";	
	document.getElementById(datedayid).style.display = "none";	
	document.getElementById(datemonthid).style.display = "none";	
	document.getElementById(hourid).style.display = "none";	
	document.getElementById(minuteid).style.display = "none";	
	document.getElementById(ampmid).style.display = "none";	
	document.getElementById(btn1).style.display = "block";	
	document.getElementById(btn2).style.display = "none";	
	document.getElementById(btn3).style.display = "none";	
}
function submitSchedule(datedayid,datemonthid,hourid,minuteid,ampmid,mail){
	var date_day = get(datedayid).value;
	var date_month = get(datemonthid).value;
	var hour = get(hourid).value;
	var minute = get(minuteid).value;
	var am_pm = get(ampmid).value;
	if(date_day == "" || date_month == "" || hour == "" || minute == "" || am_pm == ""){
		alert("Please fill all");
	}else{
		var ajax = ajaxObj("POST", "specialist.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "error_occurred"){
					alert("Form submission was unsuccessful");
				} else {
					alert("Update was successful!");
					window.location = "specialist.php";
				}
	        }
        }
        ajax.send("date_day="+date_day+"&date_month="+date_month+"&hour="+hour+"&minute="+minute+"&am_pm="+am_pm+"&mail="+mail);
	}
}
function printAppointments(el){
	var mainpage = document.body.innerHTML;
	var printcontent = get(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = mainpage;
}
</script>
</body>
</html>
