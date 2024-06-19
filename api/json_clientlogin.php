<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobRefId=$_REQUEST['mobRefId'];
//for reference number
if($mobRefId!=''){
$where2='referanceNumber="'.$mobRefId.'" order by id desc';
$rs2=GetPageRecord('*',queryMaster,$where2);
$refid= mysqli_num_rows($rs2);
if($refid>0){
$resListing=mysqli_fetch_array($rs2); 
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
$json_result.= '{
        "mobRefId" : "'.$referanceNumber.'",
		"id" : "'.$masterId.'",
		"type" : "'.$clienttype.'",
		"otp" : "'.$otp.'"
	},';
}else{
      $json_result.= '{
		"error" : "Reference Id Does Not Exist"
	},';
}	    
}else{
$json_result.= '{
		"error" : "Reference Id Does Not Exist"
	},';    
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
