<?php 
session_start(); 
ob_start(); 
function db() {
	static $conn;
		if ($conn===NULL){ 
			$servername = "localhost";
			$username = "travcrm_demo";
			$password = "DeBoxD@1010!";
			$dbname = "travcrm_Outbound_3.2_live"; 
			$conn = mysqli_connect ($servername, $username, $password, $dbname);
	}
	return $conn;
}

date_default_timezone_set('Asia/Calcutta'); 

?>