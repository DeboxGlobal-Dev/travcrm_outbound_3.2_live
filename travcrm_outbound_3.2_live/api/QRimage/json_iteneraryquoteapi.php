<?php
include "../inc.php";
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

$GetQuoationIDQuery="select qm.id Id,qr.Id queryId,qr.subject AS subject,qm.quotationType AS quotationType from quotationMaster qm inner join queryMaster qr on qm.queryId = qr.id and qm.status=2 and ".$WhereQueryRefere;
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

//$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$tmpQueryID.'"');  
//$quotationData=mysqli_fetch_array($rs1);
//$queryId=$quotationData['queryId'];
//$quotationId=$quotationData['id'];

//$select='*'; 
//$where='id="'.$tmpQueryID.'"';  
//$quotationDataq=GetPageRecord('*','quotationMaster',$where); 
//$quotationData=mysqli_fetch_array($quotationDataq);  
//$queryId=$quotationData['queryId'];
//$quotationId=$quotationData['id'];
//$makeQueryId = makeQuotationId($quotationData['id']);
//$QuotationSubject = makeQuotationId($quotationData['quotationSubject']);

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
		 
		"TripDetails": {
		"Days": [
<?php

$No=0;		
//$sqlQueryDays="Select serviceId,QID,QueryID,Srn,DayId,QuotationID, ServiceType,  StartDate, StartTime, EndDate ,EndTime, ServiceName from (Select QI.id AS QID, QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBHM.hotelName AS ServiceName From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId where 1=1 and QI.quotationId=~QID and QI.serviceType = 'hotel' UNION all Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.transferName As ServiceName From quotationItinerary QI inner JOIN quotationTransferMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('transfer','transportation') Union ALL Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.enrouteName As ServiceName From
//quotationItinerary QI inner JOIN quotationEnrouteMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderEnrouteMaster PBTM on QTM.enrouteId = PBTM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('enroutes') Union ALL Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.entranceName As ServiceName From quotationItinerary QI inner JOIN quotationEntranceMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderEntranceMaster PBTM on QTM.entranceNameId = PBTM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('entrance') Union ALL Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.otherActivityName As ServiceName From quotationItinerary QI inner JOIN quotationOtherActivitymaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderotherActivityMaster PBTM on QTM.otherActivityName = PBTM.id inner join quotationActivityTimelineDetails QATD on QATD.quotationId = QI.quotationId where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('activity')
//) MyTable order by DayId,Srn,StartTime";

// Query to get the Servicewise list. Idea is to get the all the list of service from different service table set and 
// then union these all.. finally extract the data from result set
$DataQuery="";
$DataQuery="Select serviceId,QID,QueryID,Srn,DayID,QuotationID, ServiceType, StartDate, StartTime, EndDate ,EndTime, ServiceName, ServiceCategory ,ServiceDescription, ServiceDescription_1, serviceImage,voucherURL  from ";
$DataQuery .= " ( ";
// get the List of Hotels
//$DataQuery .= "Select  QI.id AS QID, QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, CONCAT(PBHM.hotelName,' (',HCAT.hotelCategory,'-STAR )') AS ServiceName, '' AS ServiceDescription,PBHM.hotelImage AS serviceImage, QI.voucherURL AS voucherURL From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId inner join  hotelCategoryMaster HCAT on HCAT.id = QHM.categoryId where 1=1 and QI.quotationId = ~QID and QI.serviceType = 'hotel'";
$DataQuery .= "Select  QI.id AS QID, QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, CONCAT(PBHM.hotelName,' (',HCAT.hotelCategory,'-STAR )') AS ServiceName, HCAT.hotelCategory  As ServiceCategory, CONCAT('Room Type: ',RTM.name) AS ServiceDescription,CONCAT('Meal Type: ', Case ISNULL(MPM.name) when 1 then 'No Meal' else CONCAT(MPM.name ,'(', MPM.subname,')')  end ) AS  ServiceDescription_1, '' AS ServiceDescription_2, PBHM.hotelImage AS serviceImage, QI.voucherURL AS voucherURL ";
$DataQuery .= " From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId inner join  hotelCategoryMaster HCAT on HCAT.id = QHM.categoryId inner join roomTypeMaster RTM on RTM.id = QHM.roomType LEFT join mealPlanMaster MPM on  QHM.mealPlan = MPM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType = 'hotel'";
$DataQuery .= " UNION  " ;
// get the list of Transfer and Transportation
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.transferName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, VM.image AS serviceImage, QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationTransferMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType inner join vehicleMaster VM on QTM.vehicleModelId = VM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('transfer','transportation')";
$DataQuery .= " UNION  " ;
// Get the List of enroutes
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBAM.enrouteName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription, '' AS ServiceDescription_1,'' AS ServiceDescription_2, PBAM.enrouteImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationEnrouteMaster QAM on QI.quotationId = QAM.quotationId inner join packageBuilderEnrouteMaster PBAM on QAM.enrouteId = PBAM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('enroutes') ";
$DataQuery .= " UNION  " ;
// Get the List of entrance
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBEM.entranceName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, PBEM.entranceImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationEntranceMaster QEM on QI.serviceId = QEM.id inner join packageBuilderEntranceMaster PBEM on QEM.entranceNameId = PBEM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('entrance') ";
$DataQuery .= " UNION  " ;
// Get the List of activity
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBOAM.otherActivityName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription, '' AS ServiceDescription_1,'' AS ServiceDescription_2, PBOAM.otherActivityImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationOtherActivitymaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.otherActivityName where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('activity') ";
$DataQuery .= " UNION  " ;
// Get the List of train
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, CONCAT(PBTM.trainName , ' (Train No: ' , QOAM.trainNumber , ' Class: ' , QOAM.trainClass,' )' ) As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, PBTM.trainImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationTrainsMaster QOAM on QI.quotationId = QOAM.quotationId inner join packageBuilderTrainsMaster PBTM on PBTM.id=QOAM.trainId  inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.trainId   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('train') ";
$DataQuery .= " UNION  "  ;
// Get the List of flight
$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBAM.flightName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, PBFM.flightImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationFlightMaster QFM on QI.serviceId=QFM.id inner join packageBuilderAirlinesMaster PBFM on QFM.flightId=PBFM.id inner join packageBuilderAirlinesMaster PBAM on PBAM.id= QFM.flightId where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('flight') ";
$DataQuery .= " UNION  "  ;
// Get the List of guide
$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, CONCAT(tbGuid.name ,' (Phone: ' ,  tbGuid.phone ,') ' )  As ServiceName, '' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2,''  AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationGuideMaster QOAM on  QI.serviceId = QOAM.id inner join tbl_guidemaster tbGuid  on QOAM.guideId  =tbGuid.id   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('guide')";
$DataQuery .= " UNION  " ;
// Get the Name of Meal based on Meal id
$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime,   QIMP.mealPlanName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, ''  AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner join quotationInboundmealplanmaster QIMP on QI.serviceId = QIMP.id   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('mealplan') ";
$DataQuery .= " ) MyTable order by DayId,Srn,StartTime ";





$sqlQueryDaysNew = str_replace ("~QID", $quotationId ,$DataQuery);

if($_REQUEST['debug']==1){

	echo $sqlQueryDaysNew;
} 
 
$DayWiseDataq=mysqli_query(db(),$sqlQueryDaysNew) or die(mysqli_error(db()));
$sNooo=0;
$tempDayId=0;




while($DayWiseData=mysqli_fetch_array($DayWiseDataq)){ 
   
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
<?php } ?>
"DayNumber": "<?php echo ++$No; ?>",
		"DayId": "<?php echo $DayWiseData['DayID']; ?>",
		"Day1Title": "",
		"Date": "<?php echo date('d-M-Y',strtotime($DayWiseData['StartDate'])); ?>",
	
		"Services": [
<?php 
		 $tempDayId=$DayWiseData['DayID']; 
$serDayId=$DayWiseData['DayID'];
$sNooo=0;
$voucher=$DayWiseData['voucherURL'];
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
		"ServiceTypeName": "<?php echo $DayWiseData['ServiceName']; ?>",
		"ServiceID": "<?php echo $DayWiseData['serviceId']; ?>",
		"ServiceCategory": "<?php echo $DayWiseData['ServiceCategory']; ?>",
		"ServiceDetails": "<?php echo $DayWiseData['ServiceDescription']; ?>",
		"ServiceDetails_01": "<?php echo $DayWiseData['ServiceDescription_1']; ?>",
		"StartDate": "<?php echo date('d-M-Y',strtotime($DayWiseData['StartDate'])); ?>",
		"EndDate": "<?php echo date('d-M-Y',strtotime($DayWiseData['EndDate'])); ?>",
		"StartTime": "<?php echo date('d-M-Y h:i:s',strtotime($DayWiseData['StartDate'])); ?>",
		"EndTime": "<?php echo date('d-M-Y h:i:s',strtotime($DayWiseData['EndTime'])); ?>",
		"VoucherURL": "<?php echo $voucher; ?>"
		}
<?php } ?>
]
<?php ?>
}]
		
		}
 
} 