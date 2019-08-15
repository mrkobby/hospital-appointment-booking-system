<?php
include_once("db_connection.php");
$specialist = "CREATE TABLE IF NOT EXISTS specialist (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  firstname VARCHAR(50) NOT NULL,
			  lastname VARCHAR(50) NOT NULL,
			  email VARCHAR(255) NOT NULL,
			  password VARCHAR(255) NOT NULL,
			  phone_number VARCHAR(255) NOT NULL,
			  specialist_type VARCHAR(255) NOT NULL,
              PRIMARY KEY (id),
			  UNIQUE KEY email (email,id)
             )";
$query = mysqli_query($conn_str, $specialist);
if ($query === TRUE) {echo "<h6 style='color:green;'>specialist table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>specialist table NOT created :( </h6>"; }

$appointments = "CREATE TABLE IF NOT EXISTS appointments (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  firstname VARCHAR(50) NOT NULL,
			  lastname VARCHAR(50) NOT NULL,
			  email VARCHAR(255) NOT NULL,
			  date DATE NOT NULL,
			  time VARCHAR(10) NOT NULL,
			  concern TEXT NOT NULL,
			  specialist VARCHAR(255) NOT NULL,
			  approved ENUM('0','1') NOT NULL DEFAULT '0',
              PRIMARY KEY (id),
			  UNIQUE KEY email (email,id)
             )";
$query = mysqli_query($conn_str, $appointments);
if ($query === TRUE) {echo "<h6 style='color:green;'>appointments table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>appointments table NOT created :( </h6>"; }

$email = "CREATE TABLE IF NOT EXISTS email (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  email_type VARCHAR(50) NOT NULL,
			  email VARCHAR(255) NOT NULL,
			  text TEXT NOT NULL,
              PRIMARY KEY (id)
             )";
$query = mysqli_query($conn_str, $email);
if ($query === TRUE) {echo "<h6 style='color:green;'>email table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>email table NOT created :( </h6>"; }


$admin = "CREATE TABLE IF NOT EXISTS admin (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  code VARCHAR(50) NOT NULL,
			  password VARCHAR(255) NOT NULL,
              PRIMARY KEY (id)
             )";
$query = mysqli_query($conn_str, $admin);
if ($query === TRUE) {echo "<h6 style='color:green;'>admin table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>admin table NOT created :( </h6>"; }

$sql = "INSERT INTO admin (code, password) VALUES ('HS94','a127fd1f86e4ab650f2216f09992afa4')";
$q = mysqli_query($conn_str, $sql);
if ($q === TRUE) {echo "<h6 style='color:blue;'>admin table filled with data :) </h6>"; } else {echo "<h6 style='color:red;'>admin table NOT filled with data :( </h6>"; }


?>