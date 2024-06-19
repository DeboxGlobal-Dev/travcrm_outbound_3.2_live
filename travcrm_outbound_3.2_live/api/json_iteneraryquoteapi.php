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
//$sqlQueryDays="Select MyTable.serviceId,MyTable.QID,MyTable.QueryID,MyTable.Srn,MyTable.DayId,MyTable.QuotationID, ServiceType,  StartDate, StartTime, EndDate ,EndTime, ServiceName from (Select QI.id AS QID, QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBHM.hotelName AS ServiceName From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId where 1=1 and QI.quotationId=~QID and QI.serviceType = 'hotel' UNION all Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.transferName As ServiceName From quotationItinerary QI inner JOIN quotationTransferMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('transfer','transportation') Union ALL Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.enrouteName As ServiceName From
//quotationItinerary QI inner JOIN quotationEnrouteMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderEnrouteMaster PBTM on QTM.enrouteId = PBTM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('enroutes') Union ALL Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.entranceName As ServiceName From quotationItinerary QI inner JOIN quotationEntranceMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderEntranceMaster PBTM on QTM.entranceNameId = PBTM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('entrance') Union ALL Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.otherActivityName As ServiceName From quotationItinerary QI inner JOIN quotationOtherActivitymaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderotherActivityMaster PBTM on QTM.otherActivityName = PBTM.id inner join quotationActivityTimelineDetails QATD on QATD.quotationId = QI.quotationId where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('activity')
//) MyTable order by DayId,Srn,StartTime";

// Query to get the Servicewise list. Idea is to get the all the list of service from different service table set and 
// then union these all.. finally extract the data from result set

$DataQuery="";
$DataQuery="Select MyTable.serviceId,MyTable.QID,MyTable.QueryID,MyTable.Srn,MyTable.DayID,MyTable.QuotationID, MyTable.ServiceType,";
$DataQuery .= " MyTable.StartDate, MyTable.StartTime, MyTable.EndDate ,MyTable.EndTime, MyTable.ServiceName, MyTable.ServiceCategory ,"; 
$DataQuery .= " MyTable.ServiceDescription, MyTable.ServiceDescription_1, MyTable.serviceImage,MyTable.voucherURL,MyTable.fromTime,MyTable.toTime,";
$DataQuery .= " Case ISNULL(clientfeedbackmaster.serviceId) when 1 then 0  ELSE 1 END AS Feedback  from";
$DataQuery .= " ( ";
// get the List of Hotels


//$DataQuery .= "Select  QI.id AS QID, QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, CONCAT(PBHM.hotelName,' (',HCAT.hotelCategory,'-STAR )') AS ServiceName, '' AS ServiceDescription,PBHM.hotelImage AS serviceImage, QI.voucherURL AS voucherURL From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId inner join  hotelCategoryMaster HCAT on HCAT.id = QHM.categoryId where 1=1 and QI.quotationId = ~QID and QI.serviceType = 'hotel'";
$DataQuery .= "Select  QI.id AS QID, QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, 'Accommodation' AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBHM.hotelName AS ServiceName, HCAT.hotelCategory  As ServiceCategory, CONCAT('Room Type: ',RTM.name) AS ServiceDescription,CONCAT('Meal Plan : ', Case ISNULL(MPM.name) When 1 then 'No Meal' else MPM.name  end ) AS  ServiceDescription_1, '' AS ServiceDescription_2, PBHM.hotelImage AS serviceImage, QI.voucherURL AS voucherURL,'' AS fromTime,'' AS toTime";
$DataQuery .= " From quotationItinerary QI inner join quotationHotelMaster QHM on QI.serviceId = QHM.id inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId inner join  hotelCategoryMaster HCAT on HCAT.id = QHM.categoryId inner join roomTypeMaster RTM on RTM.id = QHM.roomType LEFT join mealPlanMaster MPM on  QHM.mealPlan = MPM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType = 'hotel'";
$DataQuery .= " UNION  " ;
// get the list of Transfer and Transportation
//$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.transferName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, VM.image AS serviceImage, QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationTransferMaster QTM on QI.quotationId = QTM.quotationId inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType inner join vehicleMaster VM on QTM.vehicleModelId = VM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('transfer','transportation')";
$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.transferName As ServiceName,VTPM.name As ServiceCategory, CONCAT('Model: ',VM.model) AS ServiceDescription ,Case VM.capacity When 0 then 'Capasity : N/A ' else CONCAT('Capasity : ', VM.capacity , ' Passengers') end  AS ServiceDescription_1,'' AS ServiceDescription_2, VM.image AS serviceImage, QI.voucherURL AS voucherURL,QTTD.pickupTime AS fromTime,QTTD.dropTime AS toTime";
$DataQuery .= " From quotationItinerary QI inner JOIN quotationTransferMaster QTM on QI.serviceId= QTM.id inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType inner join vehicleMaster VM on QTM.vehicleModelId = VM.id inner Join vehicleTypeMaster VTPM on VTPM.id =VM.carType left JOIN quotationTransferTimelineDetails QTTD on QTM.id=QTTD.transferQuoteId where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('transfer','transportation')";

$DataQuery .= " UNION  " ;
// Get the List of enroutes
/*$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBAM.enrouteName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription, '' AS ServiceDescription_1,'' AS ServiceDescription_2, PBAM.enrouteImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationEnrouteMaster QAM on QI.serviceId = QAM.id inner join packageBuilderEnrouteMaster PBAM on QAM.enrouteId = PBAM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('enroutes') ";
$DataQuery .= " UNION  " ;*/
// Get the List of entrance
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBEM.entranceName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, PBEM.entranceImage AS serviceImage , QI.voucherURL AS voucherURL,QETD.startTime AS fromTime,QETD.endTime AS toTime From quotationItinerary QI inner JOIN quotationEntranceMaster QEM on QI.serviceId = QEM.id inner join packageBuilderEntranceMaster PBEM on QEM.entranceNameId = PBEM.id left JOIN quotationEntranceTimelineDetails QETD on QETD.hotelQuoteId=QEM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('entrance') ";
$DataQuery .= " UNION  " ;
// Get the List of activity
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBOAM.otherActivityName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription, '' AS ServiceDescription_1,'' AS ServiceDescription_2, PBOAM.otherActivityImage AS serviceImage , QI.voucherURL AS voucherURL,QATD.startTime AS fromTime,QATD.endTime AS toTime From quotationItinerary QI inner JOIN quotationOtherActivitymaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.otherActivityName left JOIN quotationActivityTimelineDetails QATD on QATD.hotelQuoteId = QOAM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('activity')";
$DataQuery .= " UNION  " ;
//echo $DataQuery ; die();
// Get the List of train
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBTM.trainName  As ServiceName,CONCAT('Class: ', QOAM.trainClass) As ServiceCategory,CONCAT('Train No: ',QOAM.trainNumber) AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, PBTM.trainImage AS serviceImage , QI.voucherURL AS voucherURL,QOAM.arrivalTime AS fromTime,QOAM.departureTime AS toTime From quotationItinerary QI inner JOIN quotationTrainsMaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderTrainsMaster PBTM on PBTM.id=QOAM.trainId  inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.trainId   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('train') ";
$DataQuery .= " UNION  "  ;
// Get the List of flight
//$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBAM.flightName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, PBFM.flightImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationFlightMaster QFM on QI.serviceId=QFM.id inner join packageBuilderAirlinesMaster PBFM on QFM.flightId=PBFM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('flight') ";
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBFM.flightName As ServiceName, CONCAT('Flight No: ',QFM.flightNumber) As ServiceCategory, CONCAT('Dept From: ', DM.name) AS ServiceDescription, CONCAT('Class: ',QFM.flightClass) AS ServiceDescription_1,'' AS ServiceDescription_2, PBFM.flightImage AS serviceImage , QI.voucherURL AS voucherURL,QFM.arrivalTime AS fromTime,QFM.departureTime AS toTime From quotationItinerary QI inner JOIN quotationFlightMaster QFM on QI.serviceId=QFM.id inner join packageBuilderAirlinesMaster PBFM on QFM.flightId=PBFM.id ";
$DataQuery .= " INNER join destinationMaster DM on DM.id = QFM.departureFrom where 1=1 and QI.quotationId =~QID and QI.serviceType in ('flight')";
$DataQuery .= " UNION  "  ;
// Get the List of guide
/*$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, tbGuid.name  As ServiceName, CONCAT('Phone: ' ,  tbGuid.phone) As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2,''  AS serviceImage , QI.voucherURL AS voucherURL,'' AS fromTime,'' AS toTime From quotationItinerary QI inner JOIN quotationGuideMaster QOAM on  QI.serviceId = QOAM.id inner join tbl_guidemaster tbGuid  on QOAM.guideId  =tbGuid.id   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('guide')";
$DataQuery .= " UNION  " ;*/
// Get the Name of Meal based on Meal id
$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, replace(QI.serviceType,'mealplan','restaurant') AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime,   QIMP.mealPlanName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, ''  AS serviceImage , QI.voucherURL AS voucherURL,'' AS fromTime,'' AS toTime From quotationItinerary QI inner join quotationInboundmealplanmaster QIMP on QI.serviceId = QIMP.id   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('mealplan') ";
$DataQuery .= " ) MyTable left JOIN clientfeedbackmaster ON clientfeedbackmaster.serviceId = MyTable.ServiceID  order by DayId,Srn,StartTime ";
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
"DayTitle": "",
"Date": "<?php echo date('d-M-Y',strtotime($DayWiseData['StartDate'])); ?>",
"Services": [
<?php 
$tempDayId=$DayWiseData['DayID']; 
$serDayId=$DayWiseData['DayID'];
$sNooo=0;
$voucher=$DayWiseData['voucherURL'];
//$fullurl."upload/".$ q['serviceVoucher']
// $voucher = $DayWiseData['voucherURL'] != '' ? $DayWiseData['voucherURL'] : 'https://travcrm.in/travcrm-dev/showpage.crm?module=ClientVoucher&qid='.encode($DayWiseData['QuotationID']).'&queryId='.encode($DayWiseData['QueryID']).'&serviceId='.encode($DayWiseData['QID']).'&serviceType='.encode($DayWiseData['ServiceType']).'';
}
if ($sNooo>0){
?>
,{
<?php } else{ ?>
{
<?php } ?>
"ID": "<?php echo ++$sNooo; ?>",
"ServiceTypeId": "<?php echo ucwords($DayWiseData['ServiceType']); ?>",
"ServiceImage" : "",
"ServiceTypeName": "<?php echo $DayWiseData['ServiceName']; ?>",
"ServiceID": "<?php echo $DayWiseData['serviceId']; ?>",
"ServiceCategory": "<?php echo $DayWiseData['ServiceCategory']; ?>",
"ServiceDetails": "<?php echo $DayWiseData['ServiceDescription']; ?>",
"ServiceDetails_01": "<?php echo $DayWiseData['ServiceDescription_1']; ?>",

"StartDate": "<?php echo date('d-M-Y',strtotime($DayWiseData['startDate'])); ?>",
"EndDate": "<?php echo date('d-M-Y',strtotime($DayWiseData['endDate'])); ?>",
"StartTime": "<?php if($DayWiseData['fromTime']!=''){
					$fromTime=date('H:i',strtotime($DayWiseData['fromTime']))." hrs";
					echo $fromTime;
					} ?>",
"EndTime": "<?php if($DayWiseData['toTime']!=''){
					$toTime=date('H:i',strtotime($DayWiseData['toTime']))." hrs";
					echo $toTime;
					}  ?>",
"Feedback": "<?php echo $DayWiseData['Feedback']; ?>",
"VoucherURL": "<?php echo $DayWiseData['voucherURL']; ?>"
}
<?php } ?>
]
<?php ?>
}]
}
} 