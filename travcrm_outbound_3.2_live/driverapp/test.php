<?php
include "../inc.php";
header("Content-Type: application/json");

$DataQuery="SELECT id,transferQuotId,quotationId,queryId,name,mobileNo,finalActive,appStatus,bookingStatus FROM driverAllocationDetails WHERE finalActive=1 and appStatus=0 and bookingStatus=1 and driverId=1 order by id desc";
$pendingStatusDataaaq=mysqli_query(db(),$DataQuery) or die(mysqli_error(db()));
while($pendingStatusDataaa=mysqli_fetch_array($pendingStatusDataaaq)){
print_r($pendingStatusDataaa);    
$driverallocationId=$pendingStatusDataaa['id'];
$transferQuotId=$driverallocationId['transferQuotId'];
//queryData
$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$pendingStatusDataaa['queryId'].'"');  
$queryData=mysqli_fetch_array($rs);
$queryId=$queryData['id'];
$guestname=$queryData['guest1'];
$guestphone=$queryData['guest1phone'];
//$guest=$queryData['adult']+$queryData['child']+$queryData['infant'];
//$night=$queryData['night'];

/*if($queryData['fromDate']!='0' && $queryData['fromDate']!='' && $queryData['fromDate']!='0000-00-00'){
$queryDate=date('d M Y',strtotime($queryData['fromDate']));
$queryTime=date('h:i A',strtotime($queryData['fromDate']));
}*/
//hotelQuoteId	
$query=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$pendingStatusDataaa['transferQuotId'].'"');  
$transfertimeline=mysqli_fetch_array($query);
$transferQuotId=$transfertimeline['transferQuoteId'];
$pickupAddress=$transfertimeline['pickupAddress'];
$dropAddress=$transfertimeline['dropAddress'];
$pickupTime='';
if($transfertimeline['pickupTime']!=0){
$pickupTime=date('h:i A',strtotime($transfertimeline['pickupTime']));
}
$dropTime='';
if($transfertimeline['dropTime']!=0){
$dropTime=date('h:i A',strtotime($transfertimeline['dropTime']));
}
					
$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$pendingStatusDataaa['quotationId'].'" and queryId="'.$pendingStatusDataaa['queryId'].'" and status=1');  
$quotationData=mysqli_fetch_array($rs1);
$quotationId=$quotationData['id'];
$night=$quotationData['night'];
$days=$quotationData['night']+1;
$guest=$quotationData['adult']+$quotationData['child'];
$tourfromDate='';
$tourtoDate='';
if($quotationData['fromDate']!='0' && $quotationData['fromDate']!='' && $quotationData['fromDate']!='0000-00-00'){
$tourfromDate=date('d M Y',strtotime($quotationData['fromDate']));
}
if($quotationData['toDate']!='0' && $quotationData['toDate']!='' && $quotationData['toDate']!='0000-00-00'){
$tourtoDate=date('d M Y',strtotime($quotationData['toDate']));
}

if($quotationData['quotationSubject'] != ''){
	$subject = $quotationData['quotationSubject'];
}else{
	$subject = $querydata['subject'];
} 
if($resultpageQuotation['infant'] > 0) { 
$infant=$resultpageQuotation['infant']." Infant(s)"; 
}
//==================================
$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
$tdestination.= stripslashes(getDestination($QueryDaysData['cityId'])).', ';
}
}
?>

