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
if(isset($_POST["fname"])){
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$date_day = $_POST['date_day'];
	$date_month = $_POST['date_month'];
	$hour = $_POST['hour'];
	$minute = $_POST['minute'];
	$am_pm = $_POST['am_pm'];
	$concern = $_POST['concern'];
	if($email == "" || $fname == "" || $lname == "" || $date_month == "" || $hour == ""){
		echo "error_occurred";
        exit();
	}else {
		include_once("php_files/db_connection.php");
		$date_string = '2018-'.$date_month.'-'.$date_day.'';
		$time_string = ''.$hour.':'.$minute.' '.$am_pm.'';
		$sql = "INSERT INTO appointments (firstname, lastname ,email, date, time, concern, approved)       
		        VALUES('$fname','$lname','$email','$date_string','$time_string','$concern','0')";
        $query = mysqli_query($conn_str, $sql);
		echo "done";
        exit();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Healthy Smiles | Booking</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="page">
  <div id="header"><a href="index.php" id="logo"><img src="images/logo.gif" alt=""/></a>
    <ul id="navigation">
       <li><a href="index.php">home</a></li>
      <li><a href="about.php">about us</a></li>
      <li><a href="specialist_login.php">specialist login</a></li>
      <li class="selected"><a href="book-appointment.php">book an appointment</a></li>
    </ul>
  </div>
  <div class="content" style="min-height: 580px;">
    <div class="navigation">
      <ul>
		<li id="link1"><a href="aim.php">Our Aim</a></li>
		<li id="link2"><a href="about-specialists.php">Our Specialists</a></li>
      </ul>
    </div>
    <div>
      <p style="text-align:center;"><b style="margin-right: 90px;">Fill Up Form</b></p>
      <form id="booking-form" method="post" onSubmit="return false;">
        <table cellspacing="10">
          <tbody>
            <tr>
              <td><label>FirstName</label></td>
              <td><input type="text" name="fname" id="fname" class="txtfield" /></td>
            </tr>
            <tr>
              <td><label>SurName</label></td>
              <td><input type="text" name="lname" id="lname"  class="txtfield" /></td>
            </tr>
			<tr>
              <td><label>Email</label></td>
              <td><input type="email" name="email" id="email"  class="txtfield" /></td>
            </tr>
            <tr>
              <td><label>Date</label></td>
              <td style="display: inline-flex;">
				<select name="date_day" id="date_day" class="txtfield" style="width: 110px;height: 31px;margin-right: 7px;">
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
				<select name="date_month" id="date_month" class="txtfield" style="width: 204px;height: 31px;">
				<option Selected disabled value="">Month</option>
				<option disabled value="1">January</option><option disabled value="2">February</option><option disabled value="3">March</option><option disabled value="4">April</option>
				<option disabled value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option>
				<option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>
				</select> 
			  </td>
            </tr>
            <tr>
              <td><label>Time</label></td>
              <td style="display: inline-flex;">
				<input type="number" name="hour" id="hour" style="width: 40px;margin-right: 5px;" placeholder="00" class="txtfield" min="1" max="12" maxlength="2" />
				<select name="minute" id="minute" class="txtfield" style="width: 65px;height: 31px;margin-right: 5px;">
				<option value="00">00</option><option value="05">05</option><option value="10">10</option><option value="15">15</option>
				<option value="20">20</option><option value="25">25</option><option value="30">30</option><option value="45">45</option>
				</select> 
				<select name="am_pm" id="am_pm" class="txtfield" style="width: 183px;height: 31px;">
				<option Selected disabled value="">am/pm</option>
				<option value="AM">AM</option><option value="PM">PM</option>
				</select> 
			</td>
            </tr>
            <tr>
              <td class="concern"><label>Concern</label></td>
              <td><textarea name="concern" id="concern" style="padding: 5px 10px 5px 10px;height: 125px;" class="txtfield" ></textarea></td>
            </tr>
            <tr>
              <td colspan="10" align="right"><button type="submit" onclick="book()" style="width: 100px;height: 40px;font-size: 16px;">Submit</button></td>
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
function book(){
	var fname = get("fname").value;
	var lname = get("lname").value;
	var email = get("email").value;
	var date_day = get("date_day").value;
	var date_month = get("date_month").value;
	var hour = get("hour").value;
	var minute = get("minute").value;
	var am_pm = get("am_pm").value;
	var concern = get("concern").value;
	if(fname == "" || lname == "" || email == "" || date_day == "" || date_month == "" || hour == "" || minute == "" || am_pm == "" || concern == ""){
		alert("Please fill all");
	} else {
		var ajax = ajaxObj("POST", "book-appointment.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "error_occurred"){
					alert("Form submission was unsuccessful");
				} else {
					window.scrollTo(0,0);	
					get("booking-form").innerHTML = '<div style="padding:20px;text-align:center;background-color:#afecaf;width: 95%;font-size: 20px;">'+
													'Your appointment was submitted successful. We will send you an email as soon as your '+
													'appointment is accessed and approved.</div>';
				}
	        }
        }
        ajax.send("fname="+fname+"&lname="+lname+"&date_day="+date_day+"&date_month="+date_month+"&hour="+hour+"&minute="+minute+"&am_pm="+am_pm+"&email="+encodeURIComponent(email)+"&concern="+encodeURIComponent(concern));
	}
}
</script>
</body>
</html>
