<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];
$clientType=$_REQUEST['type'];
$select='*';
$where='companyId='.$masterid.' and clientType='.$clientType.' order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$tripName=$querydata['subject'];  

$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$querydata['id'].'"');  
$quotationData=mysqli_fetch_array($rs1);
$queryId=$quotationData['queryId'];
$quotationId=$quotationData['id'];
 
$startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($quotationData['fromDate']))); 

$day=1;
    $QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by id asc'); 
    
    while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
   
    $dayDate = date('Y-m-d', strtotime('+'.$day.' day', strtotime($startdatevar)));
    
    $destn = getDestination($QueryDaysData['cityId']);
    if($querydata['dayWise'] == 1){
    $date=date('d-m-Y', strtotime($dayDate));
    }
	
	$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
	$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
	while($itineryDayData = mysqli_fetch_array($itineryDay)){
        
    $id=$itineryDayData['id'];     
         
    if($itineryDayData['serviceType'] == 'hotel'){
    $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
    while($sorting1=mysqli_fetch_array($b1)){ 
    $where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"';   
    $rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
    if(mysqli_num_rows($rs22) > 0){
        
    while($hotellisting=mysqli_fetch_array($rs22)){  
	$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
	$hoteldetail=mysqli_fetch_array($rs1ee);      
	
	$rs112=GetPageRecord('*',finalQuote,'quotationId="'.$hotellisting['quotationId'].'" and hotelQuotationId="'.$hotellisting['id'].'"');  
	$rooms=mysqli_fetch_array($rs112);
	$totalrooms=$rooms['roomSingle']+$rooms['roomDouble']+$rooms['roomTriple']+$rooms['roomExtra'];
	
	$hotelImage=$hoteldetails['hotelImage'];
    $Images1="".$fullurl."packageimages/$hotelImage";
    $hotelname=strip($hoteldetail['hotelName']);
	
	$rs231er=GetPageRecord('*','hotelCategoryMaster','id='.$hoteldetail['hotelCategory'].'');  
    $hotelCatNam=mysqli_fetch_array($rs231er);  
    $hotelcategory=$hotelCatNam['name'];
	
	$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$hotellisting['roomType'].'');  
	$roomtype=mysqli_fetch_array($rs23qwe);  
	$roomtype=$roomtype['name']; 
	
	$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
 	$mealplan=mysqli_fetch_array($rssda24); 
 	$mealplan=$mealplan['name'].'-'.$mealplan['subname'];
 	 //==================download voucher============//
      $where11='queryId='.$sorting1['queryId'].' and status=1'; 
      $voucherData=GetPageRecord('*',voucherDetailsMaster,$where11); 
      $voucherlist=mysqli_fetch_array($voucherData);
      if($voucherlist['serviceType']=='hotel'){
       $downloadpdf="".$fullurl."upload/".$voucherlist['serviceVoucher']."";
      }
      if($voucherlist['serviceType']=='flight'){
       $flightVoucher="".$fullurl."upload/".$voucherlist['serviceVoucher']."";
      }
      //==============================================//    
    }}}}
	
	if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){
	$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc');
	if(mysqli_num_rows($rs22dd) > 0){
    while($transferlisting=mysqli_fetch_array($rs22dd)){  
	$rs2ss=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
	$transfergdetail=mysqli_fetch_array($rs2ss);
	$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleId'].'"');  
    $venamelist=mysqli_fetch_array($rs1aa);
    $vehicleImage=$venamelist['image'];
    $Images2="".$fullurl."packageimages/$vehicleImage";
    $transferName=$transfergdetail['transferName'];
    $type='Private';
    //$vename=$venamelist['name'];
    $vemaxpax=$venamelist['maxpax'];
    $vename=$venamelist['model'];
    $vetransferDetail=strip_tags($transfergdetail['transferDetail']);
    
    if($transferlisting['startTime']!=0){ 
     $vestarttime=date('h:i a',$transferlisting['startTime']); }
     
    if($transferlisting['endTime']!=0){ 
    $veendtime=date('h:i a',$transferlisting['endTime']); }
    
    $query=GetPageRecord('*',quotationTransferTimelineDetails,'hotelQuoteId="'.$transferlisting['id'].'"');  
	$entranceTime=mysqli_fetch_array($query);
	$pickupTime=$entranceTime['pickupTime'];
	$dropTime=$entranceTime['dropTime'];
	
	}}}
	
	if($itineryDayData['serviceType'] == 'enroutes'){ 
 	$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
	$rs22=GetPageRecord('*','quotationEnrouteMaster',$where22);  
	if(mysqli_num_rows($rs22) > 0){ 
	while($enroutelisting=mysqli_fetch_array($rs22)){  
	$rs1=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id='.$enroutelisting['enrouteId'].'');  
	$enrouteData=mysqli_fetch_array($rs1);
	$enrouteImage=$enrouteData['enrouteImage'];
	$Images3="".$fullurl."packageimages/$enrouteImage";
	$enrouteName=strip($enrouteData['enrouteName']);
	$enrouteDetail=strip_tags($enrouteData['enrouteDetail']);
	}}}    

    if($itineryDayData['serviceType'] == 'entrance'){  
    $wherent='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate="'.$dayDate.'" order by id desc'; 
    $rsent=GetPageRecord('*','quotationEntranceMaster',$wherent);  
    if(mysqli_num_rows($rsent) > 0){
    while($entrancelisting=mysqli_fetch_array($rsent)){  
	$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
	$entranceData=mysqli_fetch_array($rsentn);    
	$entranceImage=$entranceData['entranceImage'];
	$EntranceImage="".$fullurl."packageimages/$entranceImage";
	$entranceName=strip($entranceData['entranceName']);
	$entranceDetail=str_replace($entranceData['entranceDetail']);
	
	$query=GetPageRecord('*',quotationEntranceTimelineDetails,'hotelQuoteId="'.$entrancelisting['id'].'"');  
	$entranceTime=mysqli_fetch_array($query);
	$startTime=$entranceTime['startTime'];
	$endTime=$entranceTime['endTime'];
	
    }}}
    
    if($itineryDayData['serviceType'] == 'activity'){ 
	$where22='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate="'.$dayDate.'" order by id desc';   
	$rs22=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where22);  
	if(mysqli_num_rows($rs22) > 0){
	while($activitylisting=mysqli_fetch_array($rs22)){   
	$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' otherActivityName="'.$activitylisting['otherActivityName'].'"');  
	$quotationotherActivityData=mysqli_fetch_array($rs1);
	$otherActivityImage=$quotationotherActivityData['otherActivityImage'];
	$ActivityImage="".$fullurl."packageimages/$otherActivityImage";
	$otherActivityName=strip($quotationotherActivityData['otherActivityName']);
	$otherActivityDetail=str_replace($quotationotherActivityData['otherActivityDetail']);
    
    $query=GetPageRecord('*',quotationActivityTimelineDetails,'hotelQuoteId="'.$activitylisting['id'].'"');  
	$entranceTime=mysqli_fetch_array($query);
	$startTime=$entranceTime['startTime'];
	$endTime=$entranceTime['endTime'];
    
	}}}
	
	if($itineryDayData['serviceType'] == 'flight'){
	$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
	$rs22=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22);  
	if(mysqli_num_rows($rs22) > 0){
	while($activitylisting=mysqli_fetch_array($rs22)){  
	$select1='*';   
	$where1='id="'.$activitylisting['flightId'].'"';  
	$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_FLIGHT_MASTER_,$where1);  
	$activitydetail=mysqli_fetch_array($rs1);     
	$flightName=strip($activitydetail['flightName']);
	$flightNumber=strip_tags($activitylisting['flightNumber']);
	$flightClass=strip_tags($activitylisting['flightClass']);
	
	$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['departureFrom'].'"'); 
	$GuideData51=mysqli_fetch_array($rs51); 
	$Departure=strip($GuideData51['name']); 
	
	$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['arrivalTo'].'"'); 
	$GuideData51=mysqli_fetch_array($rs51); 
	$Arrival=strip($GuideData51['name']);
	    
	}}}
	
	if($itineryDayData['serviceType'] == 'train'){
 	$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
	$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
	if(mysqli_num_rows($rs22) > 0){
	while($activitylisting=mysqli_fetch_array($rs22)){  
	  
	$where1='id="'.$activitylisting['trainId'].'"';  
	$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,$where1);  
	$activitydetail=mysqli_fetch_array($rs1);
	$trainName=strip($activitydetail['trainName']);
	$trainNumber=strip_tags($activitylisting['trainNumber']);
	$trainClass=strip_tags($activitylisting['trainClass']);
	
	$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['departureFrom'].'"'); 
	$GuideData51=mysqli_fetch_array($rs51); 
	$trainDeparture=strip($GuideData51['name']);
	
	$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['arrivalTo'].'"'); 
	$GuideData51=mysqli_fetch_array($rs51); 
	$trainArrival=strip($GuideData51['name']);  
	
	}}}

	}
	
$json_result.= '{
        "id" : "'.$id.'",
        "date" : "'.$date.'",
		"day" : "'.$day.'",
		"tripName" : "'.$tripName.'",
		"destination" : "'.strtoupper($destn).'",
		"image1" : "'.$Images1.'",
		"hotelname" : "'.$hotelname.'",
		"hotelcategory" : "'.$hotelcategory.'",
		"roomtype" : "'.$roomtype.'",
		"noofrooms" : "'.$totalrooms.'",
		"mealplan" : "'.$mealplan.'",
		"veimage2" : "'.$Images2.'",
		"vetransferName" : "'.$transferName.'",
		"vetype" : "'.$type.'",
		"vename" : "'.$vename.'",
		"vemaxpax" : "'.$vemaxpax.'",
		"vestarttime" : "'.$vestarttime.'",
		"veendtime" : "'.$veendtime.'",
		"vetransferDetail" : "'.$vetransferDetail.'",
		"tpickupTime" : "'.$pickupTime.'",
		"tdropTime" : "'.$dropTime.'",
		"Images3" : "'.$Images3.'",
		"enrouteName" : "'.$enrouteName.'",
		"enrouteDetail" : "'.$enrouteDetail.'",
		"entranceImage" : "'.$EntranceImage.'",
		"entranceName" : "'.$entranceName.'",
		"estartTime" : "'.$startTime.'",
		"eendTime" : "'.$endTime.'",
		"entranceDetail" : "'.$entranceDetail.'",
		"activityImage" : "'.$ActivityImage.'",
		"otherActivityName" : "'.$otherActivityName.'",
		"otherActivityDetail" : "'.$otherActivityDetail.'",
		"astartTime" : "'.$startTime.'",
		"aendTime" : "'.$endTime.'",
		"flightName" : "'.$flightName.'",
		"flightNumber" : "'.$flightNumber.'",
		"flightClass" : "'.$flightClass.'",
		"departure" : "'.$Departure.'",
		"arrival" : "'.$Arrival.'",
		"trainName" : "'.$trainName.'",
		"trainNumber" : "'.$trainNumber.'",
		"trainClass" : "'.$trainClass.'",
		"trainDeparture" : "'.$trainDeparture.'",
		"trainArrival" : "'.$trainArrival.'",
		"downloadvoucher" : "'.$downloadpdf.'",
		"flightVoucher" : "'.$flightVoucher.'"
		
	},';
 $day++;

}

?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}