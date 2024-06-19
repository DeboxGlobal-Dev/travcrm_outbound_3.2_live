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
//for reference number

if($mobile!=""){
  $where1='phoneNo="'.$mobile.'" order by id desc';
$rs1=GetPageRecord('*','phoneMaster',$where1);
$refid1= mysqli_num_rows($rs1);
if($refid1>0){
$resListing1=mysqli_fetch_array($rs1); 


if($mobRefId!='' && strlen($mobRefId)>5){
$where2='referenceNo ="'.$mobRefId.'" and id ="'.$resListing1['masterId'].'" order by id desc';
$rs2=GetPageRecord('*','contactsMaster',$where2);
$refid2= mysqli_num_rows($rs2);
if($refid2>0){
$resListing2=mysqli_fetch_array($rs2);

$where4='referanceNumber="'.$mobRefId.'" order by id desc';
$rs4=GetPageRecord('*','queryMaster',$where4);
$refid4= mysqli_num_rows($rs4);
$resListing4=mysqli_fetch_array($rs4); 

$res3 = GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resListing4['id'].'" order by id asc');
$quotationData = mysqli_fetch_assoc($res3);
$otp=1010;   
// print_r($resListing2);die();

$json_result = '{
        "mobRefId" : "'.$resListing2['referenceNo'].'",
		"id" : "'.$resListing2['id'].'",
		"type" : "'.$resListing2['contactType'].'",
		"otp" : "'.$otp.'",
		"quotationId" : "'.encode($quotationData['id']).'"
	},';
}else{
      $json_result.= '{
		"error" : "This Reference Id Does Not Match"
	},';
}

}else{
$json_result.= '{
		"error" : "Please Enter Reference Id"
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
