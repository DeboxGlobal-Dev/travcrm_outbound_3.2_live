<?php  
include "inc.php";   
ini_set("max_execution_time",360);  
include "config/mail.php"; 
//------------------------------------licence Report Master--------------------------------------------
$select=$rs=$where='';
$select='*'; 
$where='id="'.$_SESSION['userid'].'" '; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$adminData=mysqli_fetch_array($rs);  
if( date('H:i:s') > '18:01:00' && date('Y-m-d',strtotime($adminData['expiryDate'])) < date('Y-m-d',strtotime(' +15 days')) ){ 

	$rs1=GetPageRecord('*','companySettingsMaster','id=1');
	$CMSData=mysqli_fetch_array($rs1);
	$fromemail='';  
	
	//$mailto=strip($CMSData['licenceExpiryEmail']);
	$mailto='samay.dbox@gmail.com';
	$ccmail='';   
	$mailsubject='Licence Expire Report - Travcrm';  
	
	$maildescription=url_get_contents(''.$fullurl.'report/licence.php'); 
	send_template_mail($fromemail,$mailto,$mailsubject,$maildescription,$ccmail); 
} 

?>

