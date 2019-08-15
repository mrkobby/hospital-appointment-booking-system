<?php 
session_start();
if (isset($_SESSION["code"])) {
    header("location: administrator.php"); 
    exit();
}else if (isset($_SESSION["spid"])) {
    header("location: specialist.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Medical Appointment System</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div id="page">
  <div id="header"><a href="index.php" id="logo"><img src="images/logo.gif" alt=""/></a>
    <ul id="navigation">
      <li class="selected"><a href="index.php">home</a></li>
      <li><a href="about.php">about us</a></li>
      <li><a href="specialist_login.php">specialist login</a></li>
      <li><a href="book-appointment.php">book an appointment</a></li>
      <!-- <li><a href="fake_email.php">fake email</a></li> -->
    </ul>
  </div>
  <div id="content">
    <div id="news">
      <h4>This is a medical appointment platform where you can book an appointment to see a Specialist.</h4>
      <p>This is a medical platform where you can book an appointment and see a specialist about your cancer condition who will guide you.           Specialists will provide you with all the required and necessary help you may need for your condition.</p>
    </div>
    <ul class="navigation">
      <li id="link1"><a href="aim.php">Our Aim</a></li>
      <li style="margin-left:-29px;" id="link2"><a href="about-specialists.php">Our Specialists</a></li>
    </ul>
    <div id="figure"> <img src="images/home-model.jpg" alt=""/> </div>
    <div id="section">
      <div id="article">
        <h2>Cancer Condition</h2>
        <p>Cancer is one of the commonest causes of patient death in the clinic and a complex disease occurring in multiple organs per system, multiple systems per organ, or both, in the body. The poor diagnoses, therapies and prognoses of the disease could be mainly due to the variation of severities, durations, locations, sensitivity and resistance against drugs, cell differentiation and origin, and understanding of pathogenesis. (Chang Gung Med J. 2005 Apr;28(4):201-11.) </p>
      </div>
      <ul id="buttons">
        <li><a href="book-appointment.php">book an appointment</a></li>
        <li><a href="admin-login.php">Administrator</a></li>
      </ul>
    </div>
  </div>
<?php include_once("php_files/footer_stuff.php");?>
</div>
<div align=center></div>

</body>    
</html>  
