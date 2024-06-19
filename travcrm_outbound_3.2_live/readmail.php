<?php 
ob_start();   
include "inc.php";  

$where='id='.$_REQUEST['id'].'';  
$namevalue ='clientReadmail=1';   
$update = updatelisting(_QUERYMAILS_MASTER_,$namevalue,$where);
?>