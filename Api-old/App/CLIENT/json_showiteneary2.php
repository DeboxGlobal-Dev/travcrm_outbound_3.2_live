<?php
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
// include "../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$ReferenceNum = "";
$TourSubject = "";
$TourName = "";


$id=$_REQUEST['Refid'];
$WhereQueryRefere = "referanceNumber= '".$id."'";

$GetQuoationIDQuery="select qm.id Id, qr.Id queryId,qr.displayId displayId,qr.subject AS subject,qm.quotationType AS quotationType from quotationMaster qm inner join queryMaster qr on qm.queryId = qr.id and qm.status=1 and ".$WhereQueryRefere;
if($_REQUEST['debug']==1){

	echo $GetQuoationIDQuery;
} 
$getQuotationData=mysqli_query(db(),$GetQuoationIDQuery) or die(mysqli_error(db()));
if (mysqli_num_rows($getQuotationData) >0)
{
$QuotationMasterData = mysqli_fetch_array ($getQuotationData);
$quotationId = $QuotationMasterData["Id"];
$displayId = $QuotationMasterData["displayId"];

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
		"QuotationRefNo":"<?php echo $ReferenceNum; ?>",
		"QuotationFromDate":"<?php echo date('d-m-Y',strtotime($quotationData['fromDate'])); ?>",
		"QuotationToDate":"<?php echo date('d-m-Y',strtotime($quotationData['toDate'])); ?>",
		"DisplayId":"<?php echo $displayId; ?>",
		
		
		"Days": [
<?php

$No=0;		

$DataQuery="";
$DataQuery="Select MyTable.serviceId,MyTable.QID,MyTable.QueryID,MyTable.Srn,MyTable.DayID,MyTable.QuotationID, MyTable.ServiceType,";
$DataQuery .= " MyTable.StartDate, MyTable.StartTime, MyTable.EndDate ,MyTable.EndTime, MyTable.ServiceName, MyTable.ServiceCategory ,"; 
$DataQuery .= " MyTable.ServiceDescription, MyTable.ServiceDescription_1,MyTable.ServiceDescription_2, MyTable.serviceImage,MyTable.voucherURL, ";
$DataQuery .= " Case ISNULL(clientfeedbackmaster.serviceId) when 1 then 0  ELSE 1 END AS Feedback  from ";
$DataQuery .= " ( ";

$DataQuery .= "Select  QI.id AS QID, QI.srn AS Srn, QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, 'Accommodation' AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBHM.hotelName AS ServiceName, HCAT.hotelCategory  As ServiceCategory, CONCAT('Room Type: ',RTM.name) AS ServiceDescription,CONCAT('Meal Plan : ', Case ISNULL(MPM.name) When 1 then 'No Meal' else MPM.name  end ) AS  ServiceDescription_1, '' AS ServiceDescription_2, PBHM.hotelImage AS serviceImage, QI.voucherURL AS voucherURL 
From quotationItinerary QI inner join quotationHotelMaster QHM on QI.dayId = QHM.dayId inner join packageBuilderHotelMaster PBHM on PBHM.id = QHM.supplierId inner join  hotelCategoryMaster HCAT on HCAT.id = QHM.categoryId inner join roomTypeMaster RTM on RTM.id = QHM.roomType LEFT join mealPlanMaster MPM on  QHM.mealPlan = MPM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType = 'hotel'";
$DataQuery .= " UNION  " ;

$DataQuery .= "Select
  QI.id AS QID,
  QI.srn AS Srn,
  QI.dayId AS DayID,
  QI.queryId AS QueryID,
  QI.quotationId AS QuotationID,
  QI.serviceType AS ServiceType,
  QI.serviceId ServiceID,
  QI.startDate AS StartDate,
  TTLD.arrivalTime AS StartTime,
  QI.endDate AS EndDate,
  TTLD.dropTime AS EndTime,
  PBTM.transferName As ServiceName,
  VTM.name As ServiceCategory,
  CONCAT('Model: ', VTM.name) AS ServiceDescription,
  Case VTM.capacity When 0 then 'Capacity : N/A ' else CONCAT('Capacity : ', VTM.capacity, ' Passengers') end AS ServiceDescription_1,
  '' AS ServiceDescription_2,
  '' AS serviceImage,
  QI.voucherURL AS voucherURL
From
  quotationItinerary QI
  inner JOIN quotationTransferMaster QTM on QI.serviceId = QTM.id
  inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id
  inner join quotationTransferTimelineDetails TTLD on QI.quotationId-1=TTLD.quotationId
  inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType
where
  1 = 1
  and QI.quotationId =~QID
  and QI.serviceType in ('transfer', 'transportation')
";

// $DataQuery .= "Select 
// QI.id AS QID,
// QI.srn AS Srn,
// QI.dayId AS DayID, 
// QI.queryId AS QueryID, 
// QI.quotationId AS QuotationID, 
// QI.serviceType AS ServiceType,
// QI.serviceId ServiceID, 
// QI.startDate AS StartDate,
// QI.startTime AS StartTime, 
// QI.endDate AS EndDate,
// QI.endTime AS EndTime, 
// PBTM.transferName As ServiceName,
// VTPM.name As ServiceCategory, 
// CONCAT('Model: ',VM.model) AS ServiceDescription ,
// Case VM.capacity When 0 then 'Capasity : N/A ' else CONCAT('Capasity : ', VM.capacity , ' Passengers')  end  AS ServiceDescription_1,
// '' AS ServiceDescription_2, VM.image 
// AS serviceImage, 
// QI.voucherURL AS voucherURL 
// From 
// quotationItinerary QI
// inner JOIN quotationTransferMaster QTM on QI.serviceId= QTM.id  
// inner join packageBuilderTransportMaster PBTM on QTM.transferNameId = PBTM.id 
// inner join vehicleTypeMaster VTM on VTM.id = QTM.vehicleType 
// where 1=1 and QI.quotationId = ~QID 
// and QI.serviceType in ('transfer','transportation')";

$DataQuery .= " UNION  " ;
// Get the List of enroutes
$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, PBAM.enrouteName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription, '' AS ServiceDescription_1,'' AS ServiceDescription_2, PBAM.enrouteImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationEnrouteMaster QAM on QI.serviceId = QAM.id inner join packageBuilderEnrouteMaster PBAM on QAM.enrouteId = PBAM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('enroutes') ";
$DataQuery .= " UNION  " ;
// Get the List of entrance
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,ETLD.startTime AS StartTime, QI.endDate AS EndDate,ETLD.endTime AS EndTime, PBEM.entranceName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, PBEM.entranceImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationEntranceMaster QEM on QI.serviceId = QEM.id inner join quotationEntranceTimelineDetails ETLD on QI.quotationId-1=ETLD.quotationId inner join packageBuilderEntranceMaster PBEM on QEM.entranceNameId = PBEM.id where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('entrance')";
$DataQuery .= " UNION  " ;
// Get the List of activity
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,ATLM.startTime AS StartTime, QI.endDate AS EndDate,ATLM.endTime AS EndTime, PBOAM.otherActivityName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription, '' AS ServiceDescription_1,'' AS ServiceDescription_2, PBOAM.otherActivityImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationOtherActivitymaster QOAM on QI.serviceId = QOAM.id inner join quotationActivityTimelineDetails ATLM on QI.quotationId-1=ATLM.quotationId inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.otherActivityName where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('activity')";
$DataQuery .= " UNION  " ;
// Get the List of train
$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, TLM.arrivalDate AS StartDate,TLM.arrivalTime AS StartTime, TLM.departureDate AS EndDate,TLM.departureTime AS EndTime, PBTM.trainName As ServiceName, CONCAT('Class: ', QOAM.trainClass) As ServiceCategory, CONCAT('Train No: ',QOAM.trainNumber) AS ServiceDescription, '' AS ServiceDescription_1,'' AS ServiceDescription_2, PBTM.trainImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationTrainsMaster QOAM on QI.serviceId = QOAM.id inner join packageBuilderTrainsMaster PBTM on PBTM.id=QOAM.trainId inner join trainTimeLineMaster TLM on QI.quotationId-1=TLM.quotationId inner join packageBuilderotherActivityMaster PBOAM on PBOAM.id=QOAM.trainId where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('train')";
$DataQuery .= " UNION  "  ;
// Get the List of flight

$DataQuery .= "Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, FTLM.arrivalDate AS StartDate,FTLM.arrivalTime AS StartTime, FTLM.departureDate AS EndDate,FTLM.departureTime AS EndTime, PBFM.flightName As ServiceName, CONCAT('Flight No: ',QFM.flightNumber) As ServiceCategory, CONCAT('Dept From: ', DM.name) AS ServiceDescription, CONCAT('Class: ',QFM.flightClass) AS ServiceDescription_1,'' AS ServiceDescription_2, PBFM.flightImage AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationFlightMaster QFM on QI.serviceId=QFM.id inner join packageBuilderAirlinesMaster PBFM on QFM.flightId=PBFM.id inner join flightTimeLineMaster FTLM on QI.quotationId-1=FTLM.quotationId inner join destinationMaster DM on DM.id = QFM.departureFrom where 1=1 and QI.quotationId =~QID and QI.serviceType in ('flight')";
$DataQuery .= " UNION  "  ;
//  Get the List of guide
// $DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, QI.serviceType AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime, tbGuid.name  As ServiceName, CONCAT('Phone: ' ,  tbGuid.phone) As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2,''  AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner JOIN quotationGuideMaster QOAM on  QI.serviceId = QOAM.id inner join tbl_guidemaster tbGuid  on QOAM.guideId  =tbGuid.id   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('guide')";
// $DataQuery .= " UNION  " ;
// Get the Name of Meal based on Meal id
$DataQuery .= " Select QI.id AS QID,QI.srn AS Srn,QI.dayId AS DayID, QI.queryId AS QueryID, QI.quotationId AS QuotationID, replace(QI.serviceType,'mealplan','restaurant') AS ServiceType,QI.serviceId ServiceID, QI.startDate AS StartDate,QI.startTime AS StartTime, QI.endDate AS EndDate,QI.endTime AS EndTime,   QIMP.mealPlanName As ServiceName,'' As ServiceCategory,'' AS ServiceDescription,'' AS ServiceDescription_1,'' AS ServiceDescription_2, ''  AS serviceImage , QI.voucherURL AS voucherURL From quotationItinerary QI inner join quotationInboundmealplanmaster QIMP on QI.serviceId = QIMP.id   where 1=1 and QI.quotationId = ~QID and QI.serviceType in ('mealplan') ";
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
        "QuotationTitle":"<?Php echo $TourSubject ?>",
        "Quotationsubject":"<?php echo $TourSubject; ?>",
		"Date": "<?php if($DayWiseData['StartDate'] !=''){ echo date('d-M-Y',strtotime($DayWiseData['StartDate']));}else{ echo '...'; } ?>",
		"Services": [
<?php 
$tempDayId=$DayWiseData['DayID']; 
$serDayId=$DayWiseData['DayID'];
$sNooo=0;
$voucher=$DayWiseData['voucherURL'];
$apiurl = 1;
$voucher =$fullurl.'loadcreatevoucher_client.php?module=ClientVoucher&quotationId='.($DayWiseData['QuotationID']).'&apiurl='.$apiurl;

}
if ($sNooo>0){
?>
,{
<?php } else{ ?>
{
<?php } ?>
		"ID": "<?php echo ++$sNooo; ?>",
		"ServiceTypeId": "<?php if($DayWiseData['ServiceType'] !='' ){echo ucwords($DayWiseData['ServiceType']);}else{ echo '...'; } ?>",
		"ServiceImage" : "",
		"ServiceTypeName": "<?php if($DayWiseData['ServiceName'] !='' ){ echo $DayWiseData['ServiceName'];}else{ echo '...'; }  ?>",
		"ServiceID": "<?php echo $DayWiseData['serviceId']; ?>",
		"ServiceCategory": "<?php echo $DayWiseData['ServiceCategory']; ?>",
		"ServiceDetails": "<?php if($DayWiseData['ServiceDescription'] !=''){echo $DayWiseData['ServiceDescription'];}else{ echo '...'; } ?>",
		"ServiceDetails_01": "<?php if($DayWiseData['ServiceDescription_1'] !=''){ echo $DayWiseData['ServiceDescription_1']; }else{ echo '...'; }?>",
		"StartDate": "<?php echo date('d-M-Y',strtotime($DayWiseData['StartDate'])); ?>",
		"EndDate": "<?php echo date('d-M-Y',strtotime($DayWiseData['EndDate'])); ?>",
		"StartTime": "<?php if($DayWiseData['StartTime']!=''){ echo date('h:i A',strtotime($DayWiseData['StartTime'])); }else{ echo '...'; }?>",
		"EndTime": "<?php if($DayWiseData['EndTime'] !='' ){ echo date('h:i A',strtotime($DayWiseData['EndTime'])); }else{ echo '...'; } ?>"
		
		}
<?php } ?>
]
<?php ?>
}]
		
		}
 

