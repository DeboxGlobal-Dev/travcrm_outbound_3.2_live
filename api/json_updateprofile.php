<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];
if($masterid!=''){
$firstName=clean($_REQUEST['firstName']);
$lastName=clean($_REQUEST['lastName']);
$birthDate=clean($_REQUEST['birthDate']);
$anniversaryDate=clean($_REQUEST['anniversaryDate']);
$address1=clean($_REQUEST['address1']);
$email=clean($_REQUEST['email']);
$phoneNo=clean($_REQUEST['phoneNo']);

$namevalue2 ='email="'.$email.'"';
$where2='masterId="'.$masterid.'" and primaryvalue=1'; 
$updateemail=updatelisting(_EMAIL_MASTER_,$namevalue2,$where2);

$namevalue3 ='phoneNo="'.$phoneNo.'"';
$where3='masterId="'.$masterid.'" and primaryvalue=1'; 
$updatephone=updatelisting(_PHONE_MASTER_,$namevalue3,$where3);

$namevalue ='firstName="'.$firstName.'",lastName="'.$lastName.'",birthDate="'.$birthDate.'",anniversaryDate="'.$anniversaryDate.'",address1="'.$address1.'"';
$where='id="'.$masterid.'"'; 
$updatecont=updatelisting(_CONTACT_MASTER_,$namevalue,$where);

if($updateemail!='' && $updatephone!='' && $updatecont!=''){
$json_result.= '{
		"update" : "Profile Update Succesfully",
	},';
}else{
    $json_result.= '{
		"error" : "Please Try Again!",
	},';
}
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
