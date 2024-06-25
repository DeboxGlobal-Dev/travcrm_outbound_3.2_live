<?php 
session_start(); 
ob_start(); 
function db() {
	static $conn;
		if ($conn===NULL){ 
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "travcrm_outbound_3.2_live"; 
			$conn = mysqli_connect ($servername, $username, $password, $dbname);
	}
	return $conn;
}

date_default_timezone_set('Asia/Calcutta'); 

?>