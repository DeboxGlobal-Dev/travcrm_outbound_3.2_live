<?php
include "inc.php";  

if($_REQUEST['queryId']!=''){
	$namevalue ='clientReadmail=1'; 
	$where='queryId='.strip($_REQUEST['queryId']).'';   
	$update = updatelisting(_QUERYMAILS_MASTER_,$namevalue,$where); 
}
?>