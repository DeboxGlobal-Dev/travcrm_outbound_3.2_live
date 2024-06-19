<?php 
ob_start(); 
session_start();
function db() {
	static $conn;
		if ($conn===NULL){ 
			$servername = "localhost";
			$username = "rhcrm_live";
			$password = "DeBoxS@0007!";
			$dbname = "rhcrm_live";; 
			$conn = mysqli_connect ($servername, $username, $password, $dbname);
	}
	return $conn;
}

date_default_timezone_set('Asia/Calcutta'); 

?>