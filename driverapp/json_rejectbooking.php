<?php
include "../inc.php";
header("Content-Type: application/json");

$driverId=$_REQUEST['driverId'];
$roleId=$_REQUEST['roleId'];
$queryId=$_REQUEST['queryId'];
$rejectReason=$_REQUEST['rejectReason'];
$transferQuotId=$_REQUEST['transferQuotId'];
$quotationId=$_REQUEST['quotationId'];
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');

$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($roleId==1){

$update = updatelisting('tourManagerAllocation','finalActive=0','guideQuoteId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus=2,appStatus=2,queryId="'.$queryId.'",guideQuoteId="'.$transferQuotId.'",quotationId="'.$quotationId.'",TourManagerId="'.$driverId.'",rejectReason="'.$rejectReason.'"'; 
$lastId = addlistinggetlastid('tourManagerAllocation',$acceptbooking);

if($roleId!=''){
$rejectStatus.= '{
		"message" : "Thank You for rejected order"
	},';    
}else{
$rejectStatus.= '{
	"message" : "Error try again"
},';
}
$rejectStatus=trim($rejectStatus, ','); 
}elseif($roleId==2){

$update = updatelisting('driverAllocationDetails','finalActive=0','transferQuotId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus=2,appStatus=2,queryId="'.$queryId.'",transferQuotId="'.$transferQuotId.'",quotationId="'.$quotationId.'",driverId="'.$driverId.'",rejectReason="'.$rejectReason.'", fromDate ="'.$currentDate.'"'; 
$lastId = addlistinggetlastid('driverAllocationDetails',$acceptbooking);  
    
if($roleId!=''){
$rejectStatus.= '{
		"message" : "Thank You for rejected order"
	},';    
}else{
$rejectStatus.= '{
	"message" : "Error try again"
},';
}
$rejectStatus=trim($rejectStatus, ','); 
}elseif($roleId==3){
$update = updatelisting('guideAllocation','finalActive=0','guideQuoteId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus=2,appStatus=2,queryId="'.$queryId.'",guideQuoteId="'.$transferQuotId.'",quotationId="'.$quotationId.'", dateAdded ="'.$currentDate.'" GuideId="'.$driverId.'",rejectReason="'.$rejectReason.'" fromDate ="'.$currentDate.'"'; 
$lastId = addlistinggetlastid('guideAllocation',$acceptbooking);  
    
if($roleId!=''){
$rejectStatus.= '{
		"message" : "Thank You for rejected order"
	},';    
}else{
$rejectStatus.= '{
	"message" : "Error try again"
},';
}
$rejectStatus=trim($rejectStatus, ','); 
}

$jsonmain.='{ 
    "status" : "true",
	"comment" : "JSON",
	"rejectBooking" : ['.$rejectStatus.']
	
}';
echo $jsonmain; 
$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$jsonmain.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>