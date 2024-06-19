<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$queryId=$_REQUEST['queryId'];
$mobile=$_REQUEST['mobile'];
// print_r($mobile);die();

if($mobile!="" && $queryId!=''){
  $where1='mobile_number="'.$mobile.'" and queryId="'.$queryId.'" order by id desc';
$rs1=GetPageRecord('*','mice_guestListMaster',$where1);
$refid1= mysqli_num_rows($rs1);
if($refid1>0){
$resListing1=mysqli_fetch_array($rs1); 

$json_result = '{
		"aadharStatus" : "'.$resListing1['aadhar_status'].'",
		"panStatus" : "'.$resListing1['pan_status'].'",
		"voterStatus" : "'.$resListing1['voter_status'].'",
		"vaccinationStatus" : "'.$resListing1['vaccination_status'].'",
		"passportStatus" : "'.$resListing1['passport_status'].'"
	},';
}else{
      $json_result.= '{
		"error" : "This Mobile No Does Not Match"
	},';
}
}else{
$json_result.= '{
		"error" : "Please Enter Mobile No or Query ID"
	},';    
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
