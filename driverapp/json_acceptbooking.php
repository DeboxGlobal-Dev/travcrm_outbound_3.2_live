<?php
include "../inc.php";
header("Content-Type: application/json");

$driverId=$_REQUEST['driverId'];
$roleId=$_REQUEST['roleId'];
$queryId=$_REQUEST['queryId'];
$transferQuotId=$_REQUEST['transferQuotId'];
$quotationId=$_REQUEST['quotationId'];
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');

$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($roleId==1){

$update = updatelisting('tourManagerAllocation','finalActive=0','guideQuoteId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus=0,appStatus=1,queryId="'.$queryId.'",guideQuoteId="'.$transferQuotId.'",quotationId="'.$quotationId.'",TourManagerId="'.$driverId.'"'; 
$lastId = addlistinggetlastid('tourManagerAllocation',$acceptbooking);

if($roleId!=''){
$acceptStatus.= '{
		"message" : "Thank You for accepted"
	},';    
}else{
    $acceptStatus.= '{
		"message" : "Error try again"
	},';
}
$json_acceptBooking=trim($acceptStatus, ','); 
}elseif($roleId==2){

$update = updatelisting('driverAllocationDetails','finalActive=0','transferQuotId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus=0,appStatus=1,queryId="'.$queryId.'",transferQuotId="'.$transferQuotId.'",quotationId="'.$quotationId.'",driverId="'.$driverId.'", fromDate ="'.$currentDate.'"'; 
$lastId = addlistinggetlastid('driverAllocationDetails',$acceptbooking);

if($lastId!=''){
$acceptStatus.= '{
		"message" : "Thank You for accepted"
	},';    
}else{
    $acceptStatus.= '{
		"message" : "Error try again"
	},';
}
$json_acceptBooking=trim($acceptStatus, ','); 
}elseif($roleId==3){

$update = updatelisting('guideAllocation','finalActive=0','guideQuoteId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus=0,appStatus=1,queryId="'.$queryId.'",guideQuoteId="'.$transferQuotId.'",quotationId="'.$quotationId.'",dateAdded ="'.$currentDate.'",GuideId="'.$driverId.'"'; 
$lastId = addlistinggetlastid('guideAllocation',$acceptbooking);

if($lastId!=''){
$acceptStatus.= '{
		"message" : "Thank You for accepted"
	},';    
}else{
    $acceptStatus.= '{
		"message" : "Error try again"
	},';
}
$json_acceptBooking=trim($acceptStatus, ','); 
}

$jsonmain.='{ 
    "status" : "true",
	"comment" : "JSON",
	"acceptBooking" : ['.$json_acceptBooking.']
	
}';
echo $jsonmain; 

$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$jsonmain.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>