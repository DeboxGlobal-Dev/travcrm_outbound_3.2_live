<?php
include "../inc.php";
header("Content-Type: application/json");

$driverId=$_REQUEST['driverId'];
$roleId=$_REQUEST['roleId'];
$queryId=$_REQUEST['queryId'];
$transferQuotId=$_REQUEST['transferQuotId'];
$quotationId=$_REQUEST['quotationId'];
$endReading=$_REQUEST['endReading'];
date_default_timezone_set('Asia/kolkata');
$actualtime = date("h:i A");


$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($roleId==1){
$allocationStatus=3;
$appStatus=3;
$update = updatelisting('tourManagerAllocation','finalActive=0','guideQuoteId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus="'.$allocationStatus.'",appStatus="'.$appStatus.'",queryId="'.$queryId.'",guideQuoteId="'.$transferQuotId.'",quotationId="'.$quotationId.'",TourManagerId="'.$driverId.'"'; 
$lastId = addlistinggetlastid('tourManagerAllocation',$acceptbooking);

if($roleId!=''){
$acceptStatus.= '{
		"message" : "Thank You for completed Booking"
	},';    
}else{
    $acceptStatus.= '{
		"message" : "Error try again"
	},';
}
$json_acceptBooking=trim($acceptStatus, ','); 
}elseif($roleId==2){

$allocationStatus=3;
$appStatus=3;

	$where = 'queryId="'.$queryId.'" and transferQuotId="'.$transferQuotId.'" and quotationId="'.$quotationId.'" and driverId="'.$driverId.'"'; 
    
    $namevalue = 'endReading="'.$endReading.'",allocationStatus="'.$allocationStatus.'",appStatus="'.$appStatus.'",actualdroptime ="'.$actualtime.'"';
    $update = updatelisting('driverAllocationDetails',$namevalue,$where);


if($update=='yes'){
$acceptStatus.= '{
		"message" : "Thank You for completed Booking"
	},';    
}else{
    $acceptStatus.= '{
		"message" : "Error try again"
	},';
}
$json_acceptBooking=trim($acceptStatus, ','); 
}elseif($roleId==3){
$allocationStatus=3;
$appStatus=3;

$update = updatelisting('guideAllocation','finalActive=0','guideQuoteId="'.$transferQuotId.'"');

$acceptbooking = 'allocationStatus="'.$allocationStatus.'",appStatus="'.$appStatus.'",queryId="'.$queryId.'",guideQuoteId="'.$transferQuotId.'",quotationId="'.$quotationId.'",GuideId="'.$driverId.'"'; 
$lastId = addlistinggetlastid('guideAllocation',$acceptbooking);

if($lastId!=''){
$acceptStatus.= '{
		"message" : "Thank You for completed Booking"
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