<?php
//$conn_str = mysqli_connect("localhost","id6273184_healthy_smiles","capslock","id6273184_healthy_smiles");
$conn_str = mysqli_connect("localhost","root","","healthy_smiles");
if (mysqli_connect_errno()){
		echo mysqli_connect_error();
		exit();
}
?>