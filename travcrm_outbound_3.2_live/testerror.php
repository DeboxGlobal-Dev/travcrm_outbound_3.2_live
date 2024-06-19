<?php  ob_start();
include "inc.php";   
error_reporting(E_ALL);
			 
			
			 $result =mysqli_query ("select * from queryMaster where and id='624' ");  
			$number =mysqli_num_rows($result); 
			
			  
			
			//$errorreport =  mysqli_error($conn);
			$errorreport = mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
			
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
	

				$content = $errorreport;
				$fp = fopen($_SERVER['DOCUMENT_ROOT']."/crm/textfile/myText.txt","w");
				fwrite($fp,$content);
				fclose($fp);
			
			 
?>	
