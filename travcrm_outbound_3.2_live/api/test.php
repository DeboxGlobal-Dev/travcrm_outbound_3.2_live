<?php 
//only for testing
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$id=$_REQUEST['Refid'];
$day=0;
$GetQuoationIDQuery="SELECT QM.id as QuotationId,QM.queryId as QueryId,NQD.srdate as SrDate,NQD.id as DayId from queryMaster Q inner join quotationMaster QM on Q.id=QM.queryId inner join newQuotationDays NQD on QM.quotationId=NQD.quotationId WHERE Q.referanceNumber='".$id."' and QM.status=1";

$getQuotationData=mysqli_query(db(),$GetQuoationIDQuery) or die(mysqli_error(db()));
while($QuotationMasterData = mysqli_fetch_array ($getQuotationData)){ 

$query="SELECT * from quotationItinerary QI WHERE QI.quotationId='".$QuotationMasterData['QuotationId']."' group by QI.serviceType order by QI.startDate";
$getData=mysqli_query(db(),$query) or die(mysqli_error(db()));
while($QuotationData = mysqli_fetch_array ($getData)){
    
$json_data.= '{
    "service" : "'.$QuotationData['serviceType'].'",
},';
} 
$json_service.= '{
    "day" : "'.$QuotationMasterData['DayId'].'",
    "service":"'.$json_data.'"
},';
$day++;
echo $json_service;
}
?>
