<?php 
include "../inc.php";
header("Content-Type: application/json");

$roleId=$_REQUEST['roleId'];
$id=$_REQUEST['id'];

$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($roleId==1){

$namevalue ='readalert=1'; 
$where='id="'.$id.'"';   
$update = updatelisting('tourManagerAllocation',$namevalue,$where);

$StatusDataaaq=GetPageRecord('*','tourManagerAllocation','1 and id="'.$id.'" order by id desc'); 
while($dutyStatusDataaa=mysqli_fetch_array($StatusDataaaq)){

$select='*';
$where='id='.$dutyStatusDataaa['queryId'].'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$tourDate=date('d-M',strtotime($querydata['fromDate'])).' to '.date('d-M-Y',strtotime($querydata['toDate']));
$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$querydata['id'].'" and status=1');  
$quotationData=mysqli_fetch_array($rs1);
if($quotationData['quotationSubject']!=''){
	$subject = $quotationData['quotationSubject'];
}else{
	$subject = $querydata['subject'];
} 

if ($querydata['id'] != 0) {
    $tourId = makeQueryTourId($querydata['id']);
}

$dutyDetails.='{
                "id": "'.$dutyStatusDataaa['id'].'",
				"tourName": "'.$subject.'",
				"tourId" : "'.$tourId.'",
				"tourDate": "'.$tourDate.'"
        },';
}

}elseif($roleId==2){
$namevalue ='readalert=1'; 
$where='id="'.$id.'"';   
$update = updatelisting('driverAllocationDetails',$namevalue,$where);

$StatusDataaaq=GetPageRecord('*','driverAllocationDetails','1 and id="'.$id.'" order by id desc'); 
while($dutyStatusDataaa=mysqli_fetch_array($StatusDataaaq)){
$select='*';
$where='id='.$dutyStatusDataaa['queryId'].'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$tourDate=date('d-M',strtotime($querydata['fromDate'])).' to '.date('d-M-Y',strtotime($querydata['toDate']));
$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$querydata['id'].'" and status=1');  
$quotationData=mysqli_fetch_array($rs1);
if($quotationData['quotationSubject']!=''){
	$subject = $quotationData['quotationSubject'];
}else{
	$subject = $querydata['subject'];
} 

$transferQuotId=$dutyStatusDataaa['transferQuotId'];

$query=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferQuotId.'"');  
$transfertimeline=mysqli_fetch_array($query);

$pickupTime='';
if($transfertimeline['pickupTime']!=''){
$pickupTime=date('H:i',strtotime($transfertimeline['pickupTime']))." hrs";
}
$dropTime='';
if($transfertimeline['dropTime']!=''){
$dropTime=date('H:i',strtotime($transfertimeline['dropTime']))." hrs";
}

if ($querydata['id'] != 0) {
    $tourId = makeQueryTourId($querydata['id']);
}

$dutyDetails.='{
                "id": "'.$dutyStatusDataaa['id'].'",
				"tourName": "'.$subject.'",
				"tourId" : "'.$tourId.'",
				"pickupTime" : "'.$pickupTime.'",
				"dropTime" : "'.$dropTime.'",
				"startReading" : "'.$transfertimeline['startReading'].'",
			    "endReading" : "'.$transfertimeline['endReading'].'",
			    "actualPickupTime" : "'.$transfertimeline['actualPickupTime'].'",
			    "actualdropTime" : "'.$transfertimeline['actualdropTime'].'",
				"tourDate": "'.$tourDate.'"
        },';
}
}elseif($roleId==3){
$namevalue ='readalert=1'; 
$where='id="'.$id.'"';   
$update = updatelisting('guideAllocation',$namevalue,$where);

$StatusDataaaq=GetPageRecord('*','guideAllocation','1 and id="'.$id.'" order by id desc'); 
while($dutyStatusDataaa=mysqli_fetch_array($StatusDataaaq)){

$select='*';
$where='id='.$dutyStatusDataaa['queryId'].'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$tourDate=date('d-M',strtotime($querydata['fromDate'])).' to '.date('d-M-Y',strtotime($querydata['toDate']));
$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$querydata['id'].'" and status=1');  
$quotationData=mysqli_fetch_array($rs1);
if($quotationData['quotationSubject']!=''){
	$subject = $quotationData['quotationSubject'];
}else{
	$subject = $querydata['subject'];
} 

if ($querydata['id'] != 0) {
    $tourId = makeQueryTourId($querydata['id']);
}

$dutyDetails.='{
                "id": "'.$dutyStatusDataaa['id'].'",
				"tourName": "'.$subject.'",
				"tourId" : "'.$tourId.'",
				"tourDate": "'.$tourDate.'"
        },';
}    
}
$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$dutyDetails.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>
{
		"status":"true",
		"dutyDetails":[<?php echo trim($dutyDetails, ',');?>]
}