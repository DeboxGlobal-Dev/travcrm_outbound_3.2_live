<?php 
session_start();
session_regenerate_id(); 
error_reporting(0);   
setcookie("username", '', time() -3600);
setcookie("password", '', time() -3600);
unset($_SESSION['sessionid']); 
unset($_SESSION['username']); 
unset($_SESSION['otpsession']);
unset($_SESSION['userid']);
unset($_SESSION['companymastersettingsId']);
$_SESSION['sessionid']=''; 
$_SESSION['username']=''; 
$_SESSION['otpsession']='';
$_SESSION['userid']='';
$_SESSION['companymastersettingsId']='';
session_destroy(); 
header('Location: login.crm'); 
exit;  
?>