<?php 
include "../inc.php";
header("Content-Type: application/json");

$mobileNumber=$_REQUEST['mobileNumber'];
$roleId=$_REQUEST['roleId'];

if($_REQUEST['roleId']==1 && $_REQUEST['mobileNumber']!=''){
//tour manager code here
}elseif($_REQUEST['roleId']==2 && $_REQUEST['mobileNumber']!=''){
$mobileNumber=$_REQUEST['mobileNumber'];
$changeStatus=mysqli_query(db(),"UPDATE driverMaster SET onlineStatus = '0' WHERE mobile = $mobileNumber");	
}elseif($_REQUEST['roleId']==3 && $_REQUEST['mobileNumber']!=''){
$mobileNumber=$_REQUEST['mobileNumber'];
$changeStatus=mysqli_query(db(),"UPDATE tbl_guidemaster SET onlineStatus = '0' WHERE phone = $mobileNumber");    
}
if($changeStatus!=''){
$json_logout.= '{
		"message" : "logout successfullly"
	},';   
}
session_destroy();
?>
{
		"status":"true",
		"results":[<?php echo trim($json_logout, ',');?>]
}