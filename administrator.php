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
if (isset($_POST["delete"]) && $_POST["sid"] != "" && $_POST['delete'] == "doc"){
	$sid = preg_replace('#[^0-9]#', '', $_POST["sid"]);
	$query = mysqli_query($conn_str, "SELECT * FROM specialist WHERE id='$sid' LIMIT 1");
	$rows = mysqli_num_rows($query);
	
	$sql0 = "DELETE FROM specialist WHERE id='$sid' LIMIT 1";
	$query = mysqli_query($conn_str, $sql0);
	mysqli_close($conn_str);
	echo "deleted_ok";
	exit();
}
?><?php
$list_all_specailists = "";
$sql = "SELECT * FROM specialist";
$_query = mysqli_query($conn_str, $sql);
while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
	$s_id = $row["id"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$email = $row["email"];
	$phone_number = $row["phone_number"];
	$specialist_type = $row["specialist_type"];
	
	$list_all_specailists .= '<tr id="s_id'.$s_id.'"><td>Dr. '.$firstname.' '.$lastname.'</td><td>'.$email.'</td><td>'.$specialist_type.'</td><td>0'.$phone_number.'</td>';
	$list_all_specailists .= '<td><button type="submit"  onmousedown="deleteUser(\''.$s_id.'\',\'s_id'.$s_id.'\');" >Remove</button></td></tr>';	
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
  <div class="content" style="min-height: 500px;">
    <div class="navigation">
      <ul>
        <li id="link1"><a href="add-specialist.php">+ Add Specialist</a></li>
        <li id="link2" style="margin-left: 5px;"><a href="pending-appointment.php" style="width: 240px;margin-right: 4px;">Appointments</a></li>
        <li id="link2" style="margin-left: 5px;"><a href="fake_email.php" style="width: 194px;margin-right: 51px;">View Records</a></li>
		<li id="link3" style="margin-left: -63px;"><a href="logout.php" >Logout</a></li>
      </ul>
    </div>
    <div>
	<h2>Dashboard</h2>
	 <table id="t01" style="width:100%">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Specialist Type</th>
			<th>Number</th>
			<th>...</th>
		</tr>
		<?php echo $list_all_specailists;?>
	</table> 
	
    </div>
  </div>
</div>
<div align=center></div>
<script src="javascript/main.js"></script>
<script type="text/javascript">
function deleteUser(sid,doc){
	var conf = confirm("Press OK to confirm removal of this specialist.");
	if(conf != true){
		return false;
	}else{
	var ajax = ajaxObj("POST", "administrator.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "deleted_ok"){
				alert("Specialist has been removed successfully.");
				get(doc).style.display = "none";
			}
		}
	}
	ajax.send("delete=doc&sid="+sid);
	}
}
</script>
</body>
</html>
