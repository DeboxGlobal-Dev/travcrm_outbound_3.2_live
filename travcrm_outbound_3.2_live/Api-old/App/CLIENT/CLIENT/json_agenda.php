<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobRefId=$_REQUEST['mobRefId'];
$mobile=$_REQUEST['mobile'];

if($mobile!=""){
  $where1='mobile_number="'.$mobile.'" order by id desc';
$rs1=GetPageRecord('*','mice_guestListMaster',$where1);
$refid1= mysqli_num_rows($rs1);
if($refid1>0){
$resListing1=mysqli_fetch_array($rs1); 


if($mobRefId!='' && strlen($mobRefId)>5){
$where4='referanceNumber="'.$mobRefId.'" and id="'.$resListing1['queryId'].'" order by id desc';
$rs4=GetPageRecord('*','queryMaster',$where4);
$refid4= mysqli_num_rows($rs4);
$resListing4=mysqli_fetch_array($rs4); 
$documentType =$resListing4['selectedGuestCols'];
$agenda =$resListing4['agendaAttachment'];
// print_r($documentType);die();





$otp=1010;   

$json_result = '{
        "mobRefId" : "'.$resListing4['referanceNumber'].'",
        "queryId" : "'.$resListing4['id'].'",
		"mobile" : "'.$resListing1['mobile_number'].'",
		"agenda" : "https://inboundcrm.in/travcrm-mice_2.2/packageimages/'.$agenda.'"
	},';
}else{
      $json_result.= '{
		"error" : "This Reference Id Does Not Match"
	},';
}


}else{
      $json_result.= '{
		"error" : "This Mobile No Does Not Match"
	},';
}
}else{
$json_result.= '{
		"error" : "Please Enter Mobile No"
	},';    
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
