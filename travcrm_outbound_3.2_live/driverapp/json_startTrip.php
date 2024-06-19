<?php

include "../inc.php";

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");




$driverId=$_REQUEST['driverId'];
$roleId=$_REQUEST['roleId'];
$queryId=$_REQUEST['queryId'];
$transferQuotId=$_REQUEST['transferQuotId'];
$quotationId=$_REQUEST['quotationId'];
$startreading=$_REQUEST['startreading'];
date_default_timezone_set('Asia/kolkata');
$actualtime = date("h:i A");
// print_r($actualtime);die();

// upladeted for 
if($roleId==2){

    
    $where = 'queryId="'.$queryId.'" and transferQuotId="'.$transferQuotId.'" and quotationId="'.$quotationId.'" and driverId="'.$driverId.'"'; 
    
    $namevalue = 'startreading="'.$startreading.'",actualpickuptime ="'.$actualtime.'"';
    $update = updatelisting('driverAllocationDetails',$namevalue,$where);
    
    if($update=='yes'){
   
      $json_result.= '{
		"message" : "Trip Started"
	},';
}else{
$json_result.= '{
		"message" : "Something went wrong"
	},';    
}
}
?>

{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}

