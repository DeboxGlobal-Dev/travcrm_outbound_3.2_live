<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobRefId=$_REQUEST['mobRefId'];
//for reference number
if($mobRefId!='' && strlen($mobRefId)>5){
$where2='referanceNumber="'.$mobRefId.'" order by id desc';
$rs2=GetPageRecord('*','queryMaster',$where2);
$refid= mysqli_num_rows($rs2);
if($refid>0){
$resListing=mysqli_fetch_array($rs2); 

$res3 = GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$resListing['id'].'" order by id asc');
$quotationData = mysqli_fetch_assoc($res3);
$otp=1010;   
if ($resListing['clientType']=='2'){
	$clienttype='2';
	$referanceNumber=$resListing['referanceNumber'];
    $masterId=$resListing['companyId'];

}
if ($resListing['clientType']=='1'){
	$clienttype='1';
	$referanceNumber=$resListing['referanceNumber'];
    $masterId=$resListing['companyId'];
} 
$json_result = '{
        "mobRefId" : "'.$referanceNumber.'",
		"id" : "'.$masterId.'",
		"type" : "'.$clienttype.'",
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
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
