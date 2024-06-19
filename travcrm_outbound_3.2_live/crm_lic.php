<?php
include "inc.php";

$expiry=$_REQUEST['expiry'];
$status=$_REQUEST['status']; 
$noofusers=$_REQUEST['noofusers']; 


echo $namevalue ='noofusers="'.$noofusers.'",expiryDate='.$expiry.'';  
$where='id=37';  
$update = updatelisting(_USER_MASTER_,$namevalue,$where);  

?>