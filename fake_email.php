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
$email_rows = '';
$sql01 = "SELECT * FROM email ORDER BY id DESC";
$query = mysqli_query($conn_str, $sql01);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$email_type  = $row["email_type"];
	$u_email = $row["email"];
	$text = $row["text"];
	$email_rows .= '<tr><td>'.$email_type.'</td><td>'.$u_email.'</td><td>'.$text.'</td></tr>';	
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Records</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="page">
  <div id="header"><a href="index.php" id="logo"><img src="images/logo.gif" alt=""/></a>
    <ul id="navigation">
      <li><a href="index.php">back</a></li>
    </ul>
  </div>
   <div class="content" style="min-height: 920px;margin: 0px 0 42px;">
    <div style="width: 89%;">
	<h2>Records</h2>
	<br />
	  <table id="t01" style="width:100%">
		<tr>
			<th>Title</th>
			<th>Email</th>
			<th>Text</th>
		</tr>
		<?php echo $email_rows?>
	</table> 
    </div>
  </div>
<?php include_once("php_files/footer_stuff.php");?>
</div>
<div align=center></div>
</body>    
</html>  
