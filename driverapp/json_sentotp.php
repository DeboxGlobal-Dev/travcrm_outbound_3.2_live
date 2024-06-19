<?php 
include "../inc.php";
header("Content-Type: application/json");
$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($_REQUEST['roleId']==1 && $_REQUEST['mobileNumber']!=''){
$mobileNumber=$_REQUEST['mobileNumber'];
$addnewyes = checkduplicate(' tbl_guidemaster','phone="'.$mobileNumber.'"');
}elseif($_REQUEST['roleId']==2 && $_REQUEST['mobileNumber']!=''){
$mobileNumber=$_REQUEST['mobileNumber'];
$addnewyes = checkduplicate('driverMaster','mobile="'.$mobileNumber.'"');		
}elseif($_REQUEST['roleId']==3 && $_REQUEST['mobileNumber']!=''){
$mobileNumber=$_REQUEST['mobileNumber'];
$addnewyes = checkduplicate(' tbl_guidemaster','phone="'.$mobileNumber.'"');		
}

$mobileNumber=$_REQUEST['mobileNumber'];
$rand = rand (1000,9999);

if($addnewyes == 'yes'){
    $json_otp.= '{
    "userotp":"'.$rand.'",
    "mobileNumber":"'.$mobileNumber.'",
	"message" : "OTP has been sent to your mobile No."
   },'; 
}else{
$json_otp.= '{
"message" : "OTP not sent to your mobile No."
},'; 
}
$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$json_otp.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>
{
		"status":"true",
		"results":[<?php echo trim($json_otp, ',');?>]
}