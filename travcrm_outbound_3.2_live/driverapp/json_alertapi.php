<?php
include "../inc.php";
header("Content-Type: application/json");

$roleId=$_REQUEST['roleId'];

$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if($roleId==1){

$pendingStatusDataaaq=GetPageRecord('id,guideQuoteId,quotationId,queryId,name,mobileNo,finalActive,appStatus,allocationStatus,readalert','tourManagerAllocation','1 and ((finalActive=1 and appStatus=0 and allocationStatus=1 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=1 and allocationStatus=0 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=2 and allocationStatus=2 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=3 and allocationStatus=3 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'")) order by id desc'); 
while($pendingStatusDataaa=mysqli_fetch_array($pendingStatusDataaaq)){
$driverallocationId=$pendingStatusDataaa['id'];
$appStatus=$pendingStatusDataaa['appStatus'];
$allocationStatus=$pendingStatusDataaa['allocationStatus'];

$message='';
$dutystatus='';
if($appStatus=='1' && $allocationStatus=='0'){
    $dutystatus="Pending";
    $message="You have a duty assigned to you.";
}else{
    $dutystatus="Completed";
    $message="Congrats! Duty Completed.";
}

$json_alert.= '{
    "id":"'.$driverallocationId.'",
    "dutystatus":"'.$dutystatus.'",
    "message":"'.$message.'"
},';
} 
$alert=trim($json_alert, ',');  
}elseif($roleId==2){

$pendingStatusDataaaq=GetPageRecord('*','driverAllocationDetails','1 and ((finalActive=0 and appStatus=1 and allocationStatus=0 and readalert=0 and driverId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=1 and allocationStatus=0 and readalert=0 and driverId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=2 and allocationStatus=2 and readalert=0 and driverId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=3 and allocationStatus=3 and readalert=0 and driverId="'.$_REQUEST['driverId'].'")) order by id desc'); 
while($pendingStatusDataaa=mysqli_fetch_array($pendingStatusDataaaq)){
$driverallocationId=$pendingStatusDataaa['id'];
$appStatus=$pendingStatusDataaa['appStatus'];
$allocationStatus=$pendingStatusDataaa['allocationStatus'];
$show=$pendingStatusDataaa['showid'];


$message='';
$dutystatus='';
if($appStatus=='1' && $allocationStatus=='0'){
    $dutystatus="Pending";
    $message="You have a duty assigned to you.";
}else{
    $dutystatus="Completed";
    $message="Congrats! Duty Completed.";
}
$json_alert.= '{
    "id":"'.$driverallocationId.'",
    "dutystatus":"'.$dutystatus.'",
    "message":"'.$message.'",
    "show": "'.$show.'"
},'; 
}
$alert=trim($json_alert, ',');
}elseif($roleId==3){
$pendingStatusDataaaq=GetPageRecord('*','guideAllocation','1 and ((finalActive=1 and appStatus=0 and allocationStatus=1 and readalert=0 and GuideId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=1 and allocationStatus=0 and readalert=0 and GuideId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=2 and allocationStatus=2 and readalert=0 and GuideId="'.$_REQUEST['driverId'].'") or (finalActive=1 and appStatus=3 and allocationStatus=3 and readalert=0 and GuideId="'.$_REQUEST['driverId'].'")) order by id desc'); 
while($pendingStatusDataaa=mysqli_fetch_array($pendingStatusDataaaq)){
$driverallocationId=$pendingStatusDataaa['id'];
$appStatus=$pendingStatusDataaa['appStatus'];
$allocationStatus=$pendingStatusDataaa['allocationStatus'];
$showId=$pendingStatusDataaa['showId'];

$message='';
$dutystatus='';
if($appStatus=='1' && $allocationStatus=='0'){
    $dutystatus="Pending";
    $message="You have a duty assigned to you.";
}else{
    $dutystatus="Completed";
    $message="Congrats! Duty Completed.";
}
$json_alert.= '{
    "id":"'.$driverallocationId.'",
    "dutystatus":"'.$dutystatus.'",
    "message":"'.$message.'",
    "show": "'.$showId.'"
},'; 
}
$alert=trim($json_alert, ',');
}

$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$alert.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>
{
		"status":"true",
		"alertDetails":[<?php echo trim($alert, ',');?>]
}