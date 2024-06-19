<?php
include "../inc.php";
header("Content-Type: application/json");

$roleId=$_REQUEST['roleId'];
$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if($_REQUEST['startDate']!=''){
$dateQ='and DATE(dateAdded) ="'.date('Y-m-d',strtotime($_REQUEST['startDate'])).'"';
}

$totalbookingasign=4;
$totalduty=5;
$pendingDuty=4;

if($roleId==1){
$asignDataq = GetPageRecord('COUNT(allocationStatus) as totalasign','tourManagerAllocation','finalActive=1 and allocationStatus=1 and appStatus=0 and TourManagerId="'.$_REQUEST['driverId'].'" '.$dateQ.' order by id desc'); 
$countforasign=mysqli_fetch_array($asignDataq); 
$totalbookingasign=$countforasign['totalasign'];
//for total completed duty
$completeduty = GetPageRecord('*','tourManagerAllocation','1 and TourManagerId="'.$_REQUEST['driverId'].'" and allocationStatus=3 and appstatus=3 '.$dateQ.' order by id desc'); 
$totalduty=mysqli_num_rows($completeduty); 
//for total pending orders 
$pendingDutys = GetPageRecord('id','tourManagerAllocation','1 and ((allocationStatus=0 and appstatus=1 and TourManagerId="'.$_REQUEST['driverId'].'" and finalActive=1)) '.$dateQ.' order by id desc');  
$pendingDuty=mysqli_num_rows($pendingDutys);
	
$CircleData.= '{
		"totalasign" : "'.$totalbookingasign.'",
		"totalcompletedduty" : "'.$totalduty.'",
		"pendingDuty" : "'.$pendingDuty.'"
	},'; 
}elseif($roleId==2){
//for total booking assign
$asignDataq = GetPageRecord('COUNT(allocationStatus) as totalasign','driverAllocationDetails','finalActive=1 and allocationStatus=1 and appStatus=0 and driverId="'.$_REQUEST['driverId'].'" '.$dateQ.' order by id desc'); 
$countforasign=mysqli_fetch_array($asignDataq); 
$totalbookingasign=$countforasign['totalasign'];
//for total completed duty
$completeduty = GetPageRecord('*','driverAllocationDetails','1 and driverId="'.$_REQUEST['driverId'].'" and allocationStatus=3 and appstatus=3 '.$dateQ.' order by id desc'); 
$totalduty=mysqli_num_rows($completeduty); 
//for total pending orders 
$pendingDutys = GetPageRecord('id','driverAllocationDetails','1 and ((allocationStatus=0 and appstatus=1 and driverId="'.$_REQUEST['driverId'].'" and finalActive=1)) '.$dateQ.' order by id desc');  
$pendingDuty=mysqli_num_rows($pendingDutys);  
$CircleData.= '{
		"totalasign" : "'.$totalbookingasign.'",
		"totalcompletedduty" : "'.$totalduty.'",
		"pendingDuty" : "'.$pendingDuty.'"
	},';     
}elseif($roleId==3){
//for total booking assign
$asignDataq = GetPageRecord('COUNT(allocationStatus) as totalasign','guideAllocation','finalActive=1 and allocationStatus=1 and appStatus=0 and GuideId="'.$_REQUEST['driverId'].'" '.$dateQ.' order by id desc'); 
$countforasign=mysqli_fetch_array($asignDataq); 
$totalbookingasign=$countforasign['totalasign'];
//for total completed duty
$completeduty = GetPageRecord('*','guideAllocation','1 and GuideId="'.$_REQUEST['driverId'].'" and allocationStatus=3 and appstatus=3 '.$dateQ.' order by id desc'); 
$totalduty=mysqli_num_rows($completeduty); 
//for total pending orders 
$pendingDutys = GetPageRecord('id','guideAllocation','1 and ((allocationStatus=0 and appstatus=1 and GuideId="'.$_REQUEST['driverId'].'" and finalActive=1)) '.$dateQ.' order by id desc');  
$pendingDuty=mysqli_num_rows($pendingDutys);  
$CircleData.= '{
		"totalasign" : "'.$totalbookingasign.'",
		"totalcompletedduty" : "'.$totalduty.'",
		"pendingDuty" : "'.$pendingDuty.'"
	},';         
}	
$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$CircleData.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>
{
		"status":"true",
		"CircleList":[<?php echo trim($CircleData, ',');?>]
}