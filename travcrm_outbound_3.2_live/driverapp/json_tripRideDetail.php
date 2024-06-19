<?php
include "../inc.php";
header("Content-Type: application/json");

$roleId=$_REQUEST['roleId'];
$driverId=$_REQUEST['driverId'];
$startReading=$_REQUEST['startReading'];
$endReading=$_REQUEST['endReading'];
$actualPickupTime=$_REQUEST['actualPickupTime'];
$actualdropTime=$_REQUEST['actualdropTime'];
$transferQuoteId = $_REQUEST['transferQuoteId'];

$message = "";

$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


// tour manager start

if($roleId==1){

$json_tripRideDetail.= '{
	"message" : "'.$message.'"
}';

}

// tour manager end



// driver start

if($roleId==2){
$namevalue = 'startReading="'.$startReading.'",endReading="'.$endReading.'",actualPickupTime="'.$actualPickupTime.'",actualdropTime="'.$actualdropTime.'"';
$where = ' transferQuoteId="'.$transferQuoteId.'"';
$res=updatelisting('quotationTransferTimelineDetails',$namevalue,$where);

if ($res == 'yes') {
	$message = "Update";
}else{
	$message = "Not Update";
}

$json_tripRideDetail.= '{
	"message" : "'.$message.'"
}'; 

}

// driver end


// guide start
if($roleId==3){

$json_tripRideDetail.= '{
	"message" : "'.$message.'"
}';

}
// guide end


$jsonmain.='{ 
    "status" : "true",
	"comment" : "JSON",
	"tripRideDetail" : ['.$json_tripRideDetail.']
	
}';
echo $jsonmain;  

$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$jsonmain.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);


?>