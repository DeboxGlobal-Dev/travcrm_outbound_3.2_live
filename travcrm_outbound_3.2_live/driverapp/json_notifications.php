
<?php 
include "../inc.php";
header("Content-Type: application/json");
//driver and guide 
$roleId = $_REQUEST['roleId'];
$driverid = $_REQUEST['driverId'];


$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($roleId==1){
$deliveryStatusDataaaq=GetPageRecord('id,guideQuoteId,quotationId,queryId,name,mobileNo,finalActive,appStatus,allocationStatus','tourManagerAllocation','1 and ((allocationStatus=1 and appStatus=0 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'" and finalActive=1) or (allocationStatus=0 and appStatus=1 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'" and finalActive=1) or (allocationStatus=3 and appStatus=3 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'") or (allocationStatus=2 and appStatus=2 and readalert=0 and TourManagerId="'.$_REQUEST['driverId'].'")) order by id desc'); 
$countNotification=mysqli_num_rows($deliveryStatusDataaaq);
print_r($countNotification);die();
if($countNotification>0){ 
$toNotification=$countNotification;	
$json_notification.= '{
	"countorders": "'.$toNotification.'"
		
},';
}    
}elseif($roleId==2){
    $deliveryStatusDataaaq=GetPageRecord('*','driverAllocationDetails','(allocationStatus=0 or allocationStatus=3) and driverId="'.$driverid.'" and finalActive=1 and readalert=0 order by id desc'); 
    $countNotification=mysqli_num_rows($deliveryStatusDataaaq);
    // print_r($countNotification);die();
    if($countNotification>0){ 
    $toNotification=$countNotification; 
    
    }else{
        $toNotification=""; 
    }
    
    $json_notification.= '{
        "countorders": "'.$toNotification.'"		
    },';
    
    
}elseif($roleId==3){
$deliveryStatusDataaaq=GetPageRecord('*','guideAllocation','1 and ((allocationStatus=1 and readalert=0 and GuideId="'.$driverid.'" and finalActive=1) or (allocationStatus=0 and readalert=0 and GuideId="'.$_REQUEST['driverId'].'" and finalActive=1) or (allocationStatus=3 and readalert=0 and GuideId="'.$_REQUEST['driverId'].'") or (allocationStatus=2 and readalert=0 and GuideId="'.$_REQUEST['driverId'].'")) order by id desc'); 
$countNotification=mysqli_num_rows($deliveryStatusDataaaq);
if($countNotification>0){ 
    $toNotification=$countNotification; 
    
    }else{
        $toNotification=""; 
    }
    
    $json_notification.= '{
        "countorders": "'.$toNotification.'"		
    },';
}        

$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$json_notification.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>
{
		"status":"true",
		"notifications":[<?php echo trim($json_notification, ',');?>]
}