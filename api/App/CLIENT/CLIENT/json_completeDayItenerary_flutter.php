<?php
//include "../inc.php";
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


//$select='*';
//$where='referanceNumber="'.$mobRefId.'" || guest1phone="'.$mobRefId.'" order by id desc';
//$rs=GetPageRecord($select,queryMaster,$where);

// --- Vraiable Declaration

$ReferenceNum = "";
$TourSubject = "";
$TourName = "";

$id=$_REQUEST['Refid'];
$WhereQueryRefere = "referanceNumber= '".$id."'";

$GetQuoationIDQuery="select qm.id Id,qr.Id queryId,qr.subject AS subject,qm.quotationType AS quotationType from quotationMaster qm inner join queryMaster qr on qm.queryId = qr.id and qm.status=1 and ".$WhereQueryRefere;
if($_REQUEST['debug']==1){

	echo $GetQuoationIDQuery;
} 
$getQuotationData=mysqli_query(db(),$GetQuoationIDQuery) or die(mysqli_error(db()));
//$getQuotationData=GetPageRecord('id,quotationId,subject','queryMaster',$WhereQueryRefere);
if (mysqli_num_rows($getQuotationData) >0)
{
$QuotationMasterData = mysqli_fetch_array ($getQuotationData);
$quotationId = $QuotationMasterData["Id"];
$ReferenceNum = $id;
$TourSubject = $QuotationMasterData["subject"];
$TourName = "";
$queryId=$QuotationMasterData["queryId"];
//$tmpQueryID=$QuotationMasterData["id"];
if($quotationData['quotationType'] == '2'){
	$quotationTypeN = "Multiple Hotel Category";
	}else{
	$quotationTypeN = "Single Hotel Category";
	} 
}
else
{ ?>
	{
	"status":"False", 
	"QuotationId":" ",
	"QuotationTitle":"",
	"QuotationRefNo":"",
	"QuotationFromDate":" ",
	"QuotationToDate":"",
	"Quotationsubject":"",
	"QuotationDocumentURL":" ",
	 
	"TripDetails": ""
    }
 <?php 	
	die;
}
?>

{ 
		"status":"true", 
		"QuotationId":"<?php echo $quotationId; ?>",
		"QuotationTitle":"<?Php echo $TourSubject ?>",
		"QuotationRefNo":"<?php echo $ReferenceNum; ?>",
		"QuotationFromDate":"<?php echo date('d-m-Y',strtotime($quotationData['fromDate'])); ?>",
		"QuotationToDate":"<?php echo date('d-m-Y',strtotime($quotationData['toDate'])); ?>",
		"Quotationsubject":"<?php echo $TourSubject; ?>",
		"QuotationDocumentURL":"<?php echo $fullurl; ?>inboundpackagehtml_06.php?id=<?php echo encode($quotationId); ?>",
<?php 
$sqlQueryDaysNew1 .= "Select * From newQuotationDays WHERE quotationId= '".$quotationId."'";
$DayWiseDataq1=mysqli_query(db(),$sqlQueryDaysNew1) or die(mysqli_error(db()));
$brijesh = array();
while($DayWiseData11=mysqli_fetch_array($DayWiseDataq1)){
$brijesh['title'][] = $DayWiseData11['title'];
$brijesh['description'][] = $DayWiseData11['description'];
} 
?>
		
		"Days": [
<?php

$No=0;		

$DataQuery="";
$DataQuery="Select ServiceID,QueryID,Srn,DayID,QuotationID, ServiceType, StartDate,ServiceName,serviceImage,StartTime,ServiceDescription from ";
$DataQuery .= " ( ";
// get the List of Hotels
$DataQuery .= "Select QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, 'Accommodation' AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBHM.hotelName AS ServiceName,PBHM.hotelImage AS serviceImage,PBHM.hoteldetail AS ServiceDescription";
$DataQuery .= " From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId inner join  hotelCategoryMaster HCAT on HCAT.id = QHM.categoryId inner join roomTypeMaster RTM on RTM.id = QHM.roomType LEFT join mealPlanMaster MPM on  QHM.mealPlan = MPM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType = 'hotel'";
$DataQuery .= " UNION  " ;
// get the list of Transfer and Transportation
$DataQuery .= "Select QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID,QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBTM.transferName As ServiceName,VM.image AS serviceImage,PBTM.transferDetail AS ServiceDescription";
$DataQuery .= " From quotationItinerary QI inner JOIN quotationTransferMaster QTM on QI.serviceId= QTM.id inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType inner join vehicleMaster VM on QTM.vehicleModelId = VM.id inner Join vehicleTypeMaster VTPM on VTPM.id =VM.carType where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('transfer','transportation')";
$DataQuery .= " UNION  " ;
// Get the List of enroutes
$DataQuery .= "Select QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBAM.enrouteName As ServiceName,PBAM.enrouteImage AS serviceImage,PBAM.enrouteDetail AS ServiceDescription From quotationItinerary QI inner JOIN quotationEnrouteMaster QAM on QI.serviceId = QAM.id inner join packageBuilderEnrouteMaster PBAM on QAM.enrouteId = PBAM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('enroutes')";
$DataQuery .= " UNION  " ;
// Get the List of entrance
$DataQuery .= "Select QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBEM.entranceName As ServiceName,PBEM.entranceImage AS serviceImage,PBEM.entranceDetail AS ServiceDescription From quotationItinerary QI inner JOIN quotationEntranceMaster QEM on QI.serviceId = QEM.id inner join packageBuilderEntranceMaster PBEM on QEM.entranceNameId = PBEM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('entrance') ";
$DataQuery .= " UNION  " ;
// Get the List of activity
$DataQuery .= "Select QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBOAM.otherActivityName As ServiceName,PBOAM.otherActivityImage AS serviceImage,PBOAM.otherActivityDetail AS ServiceDescription From quotationItinerary QI inner JOIN quotationOtherActivitymaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.otherActivityName where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('activity') ";
$DataQuery .= " UNION  " ;
// Get the List of train
$DataQuery .= "Select QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBTM.trainName  As ServiceName,PBTM.trainImage AS serviceImage,'' AS ServiceDescription From quotationItinerary QI inner JOIN quotationTrainsMaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderTrainsMaster PBTM on PBTM.id=QOAM.trainId  inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.trainId   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('train') ";
$DataQuery .= " UNION  " ;
//get list of flight
$DataQuery .= "Select QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime,PBFM.flightName As ServiceName,PBFM.flightImage AS serviceImage,'' AS packageBuilderAirlinesMaster From quotationItinerary QI inner JOIN quotationFlightMaster QFM on QI.serviceId=QFM.id inner join packageBuilderAirlinesMaster PBFM on QFM.flightId=PBFM.id ";
$DataQuery .= " INNER join destinationMaster DM on DM.id = QFM.departureFrom where 1=1 and QI.quotationId =~QID and QI.serviceType in ('flight')";

$DataQuery .= " ) MyTable order by DayID,Srn,StartTime ";

$sqlQueryDaysNew = str_replace ("~QID", $quotationId ,$DataQuery);

if($_REQUEST['debug']==1){

	echo $sqlQueryDaysNew;
} 
 
$DayWiseDataq=mysqli_query(db(),$sqlQueryDaysNew) or die(mysqli_error(db()));
$sNooo=0;
$tempDayId=0;
$i=0;
while($DayWiseData=mysqli_fetch_array($DayWiseDataq)){ 
$serviceImage='';
if($DayWiseData['serviceImage']!=''){
$Image2=$DayWiseData['serviceImage'];
$serviceImage="".$fullurl."packageimages/".$Image2;
}    
if($tempDayId!=$DayWiseData['DayID']){ ?>
<?php
		if($sNooo>0)
		{
		?>
]
<?php
		}
		?>
<?php
		if ($No>0){
		?>
}
		,{
<?php } else{ ?>
{
<?php } 

?>
"DayNumber": "<?php echo ++$No; ?>",
		"DayId": "<?php echo $DayWiseData['DayID']; ?>",
		"DayTitle": "<?php echo $brijesh['title'][$i]; ?>",
		"sortdescription": "<?php echo $brijesh['description'][$i]; ?>",
		"Date": "<?php echo date('d-M-Y',strtotime($DayWiseData['StartDate'])); ?>",
		"Services": [
<?php 
$tempDayId=$DayWiseData['DayID']; 
$serDayId=$DayWiseData['DayID'];
$sNooo=0;
$voucher=$DayWiseData['voucherURL'];
$i++;
//$fullurl."upload/".$ q['serviceVoucher']
//$voucher = $DayWiseData['voucherURL'] != '' ? $DayWiseData['voucherURL'] : 'https://travcrm.in/travcrm-dev/showpage.crm?module=ClientVoucher&qid='.encode($DayWiseData['QuotationID']).'&queryId='.encode($DayWiseData['QueryID']).'';
}
if ($sNooo>0){
?>
,{
<?php } else{ ?>
{
<?php } ?>
		"ID": "<?php echo ++$sNooo; ?>",
		"ServiceTypeId": "<?php echo ucwords($DayWiseData['ServiceType']); ?>",
		"ServiceTypeName": "<?php echo ucwords($DayWiseData['ServiceName']); ?>",
		"ServiceDescription" : "<?php $description = preg_replace( "/\r|\n/", " ", stripcslashes(strip_tags($DayWiseData['ServiceDescription']))); echo $description ; ?>",
		"ServiceImage" : "<?php echo $serviceImage; ?>"
		 
		}
<?php } ?>
]
<?php ?>
}]
		
 
} 