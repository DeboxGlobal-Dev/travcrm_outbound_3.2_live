<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobRefId= $_REQUEST['id'];
$type= $_REQUEST['type'];
// print_r($mobRefId);die();
//for reference number
if($mobRefId!='' && $type!=""){
    $where2='id="'.$mobRefId.'" and serviceType="'.$type.'" order by id desc';
$rs2=GetPageRecord('*','tbl_guidemaster',$where2);
$resListing=mysqli_fetch_array($rs2); 

    
    
     $json_result.= '{
        "id" : "'.$resListing['id'].'",
		"name" : "'.$resListing['name'].'",
		"country" : "'.$resListing['countryId'].'",
		"mobile" : "'.$resListing['phone'].'",
		"email" : "'.$resListing['email'].'",
		"address" : "'.$resListing['address'].'"
	},';

    
}
else{
	$json_result.='{
			"error" : "Please Enter Reference Id"
	},';
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}