<?php 


include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");
$id=$_REQUEST['Refid'];
$select='*';
$where='referanceNumber="'.$id.'"';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$displayid=makeQueryId($querydata['id']);
$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$querydata['id'].'" and status=1');  
$quotationData=mysqli_fetch_array($rs1);
$queryId=$quotationData['queryId'];
$quotationId=$quotationData['id'];
$fromDate=$quotationData['fromDate'];
$toDate=$quotationData['toDate'];
$proposalPhoto=$quotationData['image'];
if($quotationData['quotationSubject'] != ''){
	$subject = $quotationData['quotationSubject'];
}else{
	$subject = $querydata['subject'];
} 
$day=1;
$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by id asc'); 
while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
	$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
	$cityId = getDestination($QueryDaysData['cityId']);
	if($querydata['dayWise'] == 1 && $dayDate!='01-01-1970'){
		$date=date('d-m-Y', strtotime($dayDate));
	}
	$dayId = $QueryDaysData['id'];
 	$json_entrance = "";
	$itiQuery = ' quotationId="'.$quotationId.'"  and startDate="'.$dayDate.'" group by serviceType order by startDate asc';
	$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
	while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
	
	if($itineryDayData['serviceType']=='entrance'){  
    $wherent='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate="'.$dayDate.'" order by id desc'; 
    $rsent=GetPageRecord('*','quotationEntranceMaster',$wherent);  
    if(mysqli_num_rows($rsent) > 0){
    	
    while($entrancelisting=mysqli_fetch_array($rsent)){
    $EfromDate = date('d', strtotime($entrancelisting['fromDate']));
    $EtoDate = date('d F,Y', strtotime($entrancelisting['toDate']));    
	$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
	$entranceData=mysqli_fetch_array($rsentn); 
	if($entranceData['entranceImage']!='NULL'){
	$entranceImage=$entranceData['entranceImage'];
	$EntranceImage="".$fullurl."packageimages/$entranceImage";
	}
	$entranceName=strip($entranceData['entranceName']);
	$entranceDetail=strip($entranceData['entranceDetail']);
	
	$query=GetPageRecord('*',quotationEntranceTimelineDetails,'hotelQuoteId="'.$entrancelisting['id'].'"');  
	$entranceTime=mysqli_fetch_array($query);
	$startTime=$entranceTime['startTime'];
	$endTime=$entranceTime['endTime'];
	$json_entrance.= '{
						"entranceImage" : "'.$EntranceImage.'",
                		"tripName" : "'.$entranceName.'",
                		"tripDuration" : "'.$EfromDate.' to '.$EtoDate.'",
                		"startTime" : "'.$startTime.'",
                		"endTime" : "'.$endTime.'",
                		"description" : "'.$entranceDetail.'"			
					},';
    }}}
	} 
	$json_daywise.= '{
	    "dayId" : "'.$dayId.'",
		"day" : "'.$day.'", 
		"date" : "'.$date.'",
		"queryId" : "'.$displayid.'",
		"cityId" : "'.ucfirst($cityId).'",
		"entrance" : ['.rtrim($json_entrance, ',').']
	},';
 	$day++;
}
$json_result.= '{
    "status" : "true",
	"days" : ['.rtrim($json_daywise, ',').']
	
}';
echo $json_result;
?>