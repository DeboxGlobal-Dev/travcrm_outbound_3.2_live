<?php
include "../inc.php";
header("Content-Type: application/json");

$driverId=$_REQUEST['driverId'];
// print_r($driverId);die();
$roleId=$_REQUEST['roleId'];
$orderRequestcall = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if($_REQUEST['startDate']!=''){
$dateQ = date('Y-m-d',strtotime($_REQUEST['startDate']));
}
if($roleId==1){

$DataQuery="SELECT id,guideQuoteId,quotationId,queryId,name,mobileNo,finalActive,appStatus,allocationStatus,TourManagerId FROM tourManagerAllocation WHERE finalActive=1 and appStatus=0 and allocationStatus=1 and TourManagerId='".$driverId."' and dateAdded='".$dateQ."' order by id desc";
$pendingStatusDataaaq=mysqli_query(db(),$DataQuery  or die(mysqli_error(db())));
while($pendingStatusDataaa=mysqli_fetch_array($pendingStatusDataaaq)){
$guideQuoteId=$pendingStatusDataaa['guideQuoteId'];
$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$pendingStatusDataaa['queryId'].'"');  
$queryData=mysqli_fetch_array($rs);
$queryId=$queryData['id'];
$guestname=$queryData['guest1'];
$guestphone=$queryData['guest1phone'];
 
 
$query=GetPageRecord('*','quotationGuideMaster','id="'.$guideQuoteId.'"');  
$resultlists=mysqli_fetch_array($query);
$sele='*';
$whereDest=' id="'.$resultlists['destinationId'].'" ';   
$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
$ddest=mysqli_fetch_array($rsDest); 

$selectd = '*';   
$whered= 'id="'.$resultlists['tariffId'].'"'; 
$rsd = GetPageRecord($selectd,'dmcGuidePorterRate',$whered); 
$guideDate = mysqli_fetch_array($rsd);

$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$resultlists['guideId'].'"'); 
$guideCat = mysqli_fetch_array($rs11); 

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
$infant="/".$resultpageQuotation['infant']." Infant(s)";
}

if ($queryData['id'] != 0) {
    $tourId = makeQueryTourId($queryData['id']);
}
if ($queryData['leadPaxName'] != '') {
    $leadPaxName = $queryData['leadPaxName'];
}




$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by srdate asc'); 
$no= 0;
$srdate = '';
$tdestination = '';
while ($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)) {
    


    $tdestination.= stripslashes(getDestination($QueryDaysData['cityId'])).', ';
    $no++;    
}

if ($no > 1) {
    $serviceType= 'transportation';
    $tourDate = $tourfromDate.' to '.$tourtoDate;
}else{
    $serviceType= 'transfer';
    $tourDate = $tourfromDate;
}


$rs2=GetPageRecord('*',_GUIDE_MASTER_,' id="'.$pendingStatusDataaa['TourManagerId'].'"');
$tourManagerData=mysqli_fetch_array($rs2);



$json_pending.= '{
    "id":"'.$pendingStatusDataaa['id'].'",
    "quotationId":"'.$quotationId.'",
    "queryId":"'.$queryId.'",
    "transferQuotId":"'.$guideQuoteId.'",
    "subject":"'.$subject.'in '.$days.' days",
    "destination":"'.rtrim($tdestination,',').'",
    "tourDate":"'.$tourDate.'",
    "guest":"'.$guest.' Adults'.$infant.'",
    "guestname":"'.$guestname.'",
    "guestphone":"'.$guestphone.'",
    "night":"'.$guideDate['dayType'].'",
    "service":"'.$guideCat['name'].'",
    "tourId" : "'.$tourId.'",
    "leadPaxName" : "'.$leadPaxName.'",
    "TourManagerId" : "'.$pendingStatusDataaa['TourManagerId'].'",
    "TourManagerName" : "'.$tourManagerData['name'].'",
    "pickupAndDropTime" : "",
    "$pickupAndDropAddress" : ""
},';
} 
$json_pendingList=trim($json_pending, ',');     
}elseif($roleId==2){
 
// $DataQuery="SELECT id,transferQuotId,quotationId,queryId,name,mobileNo,finalActive,appStatus,allocationStatus FROM driverAllocationDetails WHERE finalActive=1 and appStatus=0 and allocationStatus=1 and driverId='".$driverId."' or dateAdded ='".$dateQ."' order by id desc";
$DataQuery = "SELECT * FROM `driverAllocationDetails` WHERE driverId ='".$driverId."' and fromDate ='".$dateQ."' and finalActive=1 and appStatus=0 and allocationStatus=1";
$pendingStatusDataaaq=mysqli_query(db(),$DataQuery) or die(mysqli_error(db()));
$tourfromDate1 ='';
$tourtoDate1="";
while($pendingStatusDataaa=mysqli_fetch_assoc($pendingStatusDataaaq)){
    if($pendingStatusDataaa['fromDate']!='0' && $pendingStatusDataaa['fromDate']!='' && $pendingStatusDataaa['fromDate']!='0000-00-00'){
        $tourfromDate1=date('d-M-Y',strtotime($pendingStatusDataaa['fromDate']));
}
if($pendingStatusDataaa['toDate']!='0' && $pendingStatusDataaa['toDate']!='' && $pendingStatusDataaa['toDate']!='0000-00-00'){
$tourtoDate1=date('d-M-Y',strtotime($pendingStatusDataaa['toDate']));
}
    // print_r($pendingStatusDataaa);die();
$transferQuotId=$pendingStatusDataaa['transferQuotId'];
//queryData
$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$pendingStatusDataaa['queryId'].'"');  
$queryData=mysqli_fetch_array($rs);
$queryId=$queryData['id'];
$guestname=$queryData['guest1'];
$guestphone=$queryData['guest1phone'];


	
$query=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferQuotId.'"');  
$transfertimeline=mysqli_fetch_array($query);
//$transferQuotId=$transfertimeline['transferQuoteId'];
$pickupAddress=strip($transfertimeline['pickupAddress']);
$dropAddress=strip($transfertimeline['dropAddress']);
//$pickupTime=$transfertimeline['pickupTime'];
$pickupTime='';
if($transfertimeline['pickupTime']!=''){
$pickupTime=$transfertimeline['pickupTime'];
}
$dropTime='';
if($transfertimeline['dropTime']!=''){
$dropTime=$transfertimeline['dropTime'];
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
	$subject = $queryData['subject'];
} 
if($resultpageQuotation['infant'] > 0) { 
$infant="/".$resultpageQuotation['infant']." Infant(s)"; 
}

if ($queryData['id'] != 0) {
    $tourId = makeQueryTourId($queryData['id']);
}
if ($queryData['leadPaxName'] != '') {
    $leadPaxName = $queryData['leadPaxName'];
}


$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by srdate asc'); 
$no= 0;
$srdate = '';
$tdestination = '';
while ($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)) {

    if ($srdate == '') {
        $srdate = $QueryDaysData['srdate'];
        $srdate.= '['.$srdate.'] =>';
    }elseif ($srdate == $QueryDaysData['srdate']) {
        
    }elseif($srdate != $QueryDaysData['srdate']){
        $srdate = $QueryDaysData['srdate'];
        $srdate.= '['.$srdate.'] =>';
    }

    $tdestination.= stripslashes(getDestination($QueryDaysData['cityId'])).', ';
    $no++;    
}

if ($no > 1) {
    $serviceType= 'transportation';
    $tourDate = $tourfromDate1.' to '.$tourtoDate1;
}else{
    $serviceType= 'transfer';
    $tourDate = $tourfromDate1;
}



$json_pending.= '{
    "id":"'.$pendingStatusDataaa['id'].'",
    "quotationId":"'.$quotationId.'",
    "queryId":"'.$queryId.'",
    "transferQuotId":"'.$transferQuotId.'",
    "subject":"'.$subject.'in '.$days.' days",
    "destination":"'.rtrim($tdestination,',').'",
    "tourDate":"'.$tourfromDate1.'",
    "guest":"'.$guest.' Adults'.$infant.'",
    "guestname":"'.$guestname.'",
    "guestphone":"'.$guestphone.'",
    "night":"'.$night.' Night/'.$days.' Days",
    "pickupDate" : "'.$tourfromDate1.'",
    "pickupTime" : "'.$pickupTime.'",
	"dropTime" : "'.$dropTime.'",
	"pickupAddress" : "'.$pickupAddress.'",
    "tourId" : "'.$tourId.'",
    "leadPaxName" : "'.$leadPaxName.'",
    "serviceType" : "'.$serviceType.'",
	"dropAddress" : "'.$dropAddress.'"
},'; 
}
$json_pendingList=trim($json_pending, ',');
}elseif($roleId==3){
 
$DataQuery="SELECT * FROM guideAllocation WHERE finalActive=1 and appStatus=0 and allocationStatus=1 and GuideId='".$driverId."' and fromDate ='".$dateQ."' order by id desc";
$pendingStatusDataaaq=mysqli_query(db(),$DataQuery) or die(mysqli_error(db()));
while($pendingStatusDataaa=mysqli_fetch_assoc($pendingStatusDataaaq)){
    // print_r($pendingStatusDataaa);die();
$guideQuoteId=$pendingStatusDataaa['guideQuoteId'];


$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$pendingStatusDataaa['queryId'].'"');  
$queryData=mysqli_fetch_array($rs);
$queryId=$queryData['id'];
$guestname=$queryData['guest1'];
$guestphone=$queryData['guest1phone'];


$query=GetPageRecord('*','quotationGuideMaster','id="'.$guideQuoteId.'"');  
$resultlists=mysqli_fetch_array($query);
$sele='*';
$whereDest=' id="'.$resultlists['destinationId'].'" ';   
$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
$ddest=mysqli_fetch_array($rsDest);	

$selectd = '*';   
$whered= 'id="'.$resultlists['tariffId'].'"'; 
$rsd = GetPageRecord($selectd,'dmcGuidePorterRate',$whered); 
$guideDate = mysqli_fetch_array($rsd);

$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$resultlists['guideId'].'"'); 
$guideCat = mysqli_fetch_array($rs11); 

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
$infant="/".$resultpageQuotation['infant']." Infant(s)";
}

if ($queryData['id'] != 0) {
    $tourId = makeQueryTourId($queryData['id']);
}
if ($queryData['leadPaxName'] != '') {
    $leadPaxName = $queryData['leadPaxName'];
}


$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by srdate asc'); 
$no= 0;
$srdate = '';
$tdestination = '';
while ($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)) {

    if ($srdate == '') {
        $srdate = $QueryDaysData['srdate'];
        $srdate.= '['.$srdate.'] =>';
    }elseif ($srdate == $QueryDaysData['srdate']) {
        
    }elseif($srdate != $QueryDaysData['srdate']){
        $srdate = $QueryDaysData['srdate'];
        $srdate.= '['.$srdate.'] =>';
    }

    $tdestination.= stripslashes(getDestination($QueryDaysData['cityId'])).', ';
    $no++;    
}

if ($no > 1) {
    $serviceType= 'transportation';
    $tourDate = $tourfromDate.' to '.$tourtoDate;
}else{
    $serviceType= 'transfer';
    $tourDate = $tourfromDate;
}

$json_pending.= '{
    "id":"'.$pendingStatusDataaa['id'].'",
    "quotationId":"'.$quotationId.'",
    "queryId":"'.$queryId.'",
    "transferQuotId":"'.$guideQuoteId.'",
    "subject":"'.$subject.'in '.$days.' days",
    "destination":"'.rtrim($tdestination,',').'",
    "tourDate":"'.$tourDate.'",
    "guest":"'.$guest.' Adults'.$infant.'",
    "guestname":"'.$guestname.'",
    "guestphone":"'.$guestphone.'",
    "night":"'.$guideDate['dayType'].'",
    "service":"'.$guideCat['name'].'",
    "tourId" : "'.$tourId.'",
    "leadPaxName" : "'.$leadPaxName.'",
    "pickupAndDropTime" : "",
	"$pickupAndDropAddress" : ""
},'; 
}
$json_pendingList=trim($json_pending, ',');
}

$jsonmain.='{ 
    "status" : "true",
	"comment" : "JSON",
	"pending" : ['.$json_pendingList.']
	
}';
echo $jsonmain;  
$namevalue2 ="requestString='.$orderRequestcall.',responseString='.$jsonmain.'"; 
addlistinggetlastid('apicallingLog',$namevalue2);
?>