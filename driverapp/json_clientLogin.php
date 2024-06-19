<?php 
include "../inc.php";
include 'appfunctions.php';
header("Content-Type: application/json");

$mobileNumber=$_REQUEST['mobileNumber'];
$userotp=$_REQUEST['userotp'];
$myotp=$_REQUEST['myotp'];
$roleId=$_REQUEST['roleId'];

if($_REQUEST['myotp']==$userotp && $userotp!='' && $roleId!='' && $mobileNumber!=''){

switch($roleId){
case 1:
tourManagerLogin($mobileNumber,$roleId);       
break;
case 2:
driverLogin($mobileNumber,$roleId); 
break;
case 3:
guideLogin($mobileNumber,$roleId); 
break;
default:
echo "try again";    
}

}else{
switch($roleId){
default:
echo "wrong otp";    
}    
}
?>