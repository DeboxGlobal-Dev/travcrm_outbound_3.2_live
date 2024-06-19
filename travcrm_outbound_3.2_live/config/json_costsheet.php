<?php 
include "../inc.php";

$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'"');  
$quotationData=mysqli_fetch_array($rs1);
$queryId=$quotationData['queryId'];
$quotationId=$quotationData['id'];

$rs='';
$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$queryId.'"'); 
$querydata=mysqli_fetch_array($rs);


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
	
 	$json_hotel = $json_transfer = $json_enroute = $json_entrance = $json_activity = $json_flight = $json_train = $json_guide = $json_mealplan = $json_additional = "";

	
	$itiQuery = ' quotationId="'.$quotationId.'" and startDate="'.$dayDate.'" group by serviceType order by startDate asc';
	$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
	while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
	
		
		if($itineryDayData['serviceType'] == 'hotel'){
			$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
			while($sorting1=mysqli_fetch_array($b1)){ 
				$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"';   
				$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
				if(mysqli_num_rows($rs22) > 0){
					
					while($quotationHotelD=mysqli_fetch_array($rs22)){
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$quotationHotelD['supplierId'].'"');  
						$hoteldetail=mysqli_fetch_array($rs1ee);      
						
						$rs112=GetPageRecord('*',finalQuote,'quotationId="'.$quotationHotelD['quotationId'].'" and hotelQuotationId="'.$quotationHotelD['id'].'"');  
						$rooms=mysqli_fetch_array($rs112);
						$totalrooms=$rooms['roomSingle']+$rooms['roomDouble']+$rooms['roomTriple']+$rooms['roomTwin'];
					
						$hotelName=strip($hoteldetail['hotelName']);
						
						$rs231er='';
						$rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategoryId'].'"');  
						$hotelCatNam=mysqli_fetch_array($rs231er);  
						$hotelcategory=$hotelCatNam['hotelCategory'].' Star';
						
						$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$quotationHotelD['roomType'].'');  
						$roomtype=mysqli_fetch_array($rs23qwe);  
						$roomType=$roomtype['name'];
						
						$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$quotationHotelD['mealPlan'].''); 
						$mealplan=mysqli_fetch_array($rssda24); 
						$mealPlan=$mealplan['name'];
					
						$json_hotel.= '{
							"hotelQuoteId" : "'.$quotationHotelD['id'].'",
							"serviceType" : "hotel", 
							"hotelName" : "'.$hotelName.'",
							"hotelcategory" : "'.$hotelcategory.'",
							"roomType" : "'.$roomType.'",
							"mealPlan" : "'.$mealPlan.'" 
						},';
					}
				}
			}
			
		}
		
		if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){
			$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc');
			if(mysqli_num_rows($rs22dd) > 0){
			
				while($quotationTransferD=mysqli_fetch_array($rs22dd)){  
					$rs2ss=GetPageRecord('transferName,transferDetail',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$quotationTransferD['transferNameId'].'"'); 
					$transfergdetail=mysqli_fetch_array($rs2ss);
			
					$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$quotationTransferD['vehicleModelId'].'"');  
					$venamelist=mysqli_fetch_array($rs1aa);
			    
					$transferName=$transfergdetail['transferName'];
					$vemaxpax=$venamelist['maxpax'];
					$model=$venamelist['model'];
					if($quotationTransferD['startTime']!=0){ 
						$vestarttime=date('H:i',strtotime($quotationTransferD['startTime']))." hrs"; 
					}
				 
					if($quotationTransferD['endTime']!=0){ 
						$veendtime=date('H:i',strtotime($quotationTransferD['endTime']))." hrs"; 
					}
					
					//hotelQuoteId	
					$query=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$quotationTransferD['id'].'"');  
					$entranceTime=mysqli_fetch_array($query);
					if($entranceTime['dropTime']!=0){
					$pickupTime=date('H:i',strtotime($entranceTime['dropTime']))." hrs";
					}
					if($entranceTime['pickupTime']!=0){
					$dropTime=date('H:i',strtotime($entranceTime['pickupTime']))." hrs";
					}
					$json_transfer.= '{
						"transferQuoteId" : "'.$quotationTransferD['id'].'",
						"serviceType" : "'.ucfirst($itineryDayData['serviceType']).'", 
						"transferName" : "'.$transferName.'",
						"vemaxpax" : "'.$vemaxpax.'",
						"model" : "'.$model.'",
						"vetransferDetail" : "'.$vetransferDetail.'",
						"vestarttime" : "'.$vestarttime.'",
						"veendtime" : "'.$veendtime.'",
						"pickupTime" : "'.$pickupTime.'",
						"dropTime" : "'.$dropTime.'"
						
					},';
					
				}
			}
		}
		
		if($itineryDayData['serviceType'] == 'enroute'){ 
			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
			$rs22=GetPageRecord('*','quotationEnrouteMaster',$where22);  
			if(mysqli_num_rows($rs22) > 0){ 
				while($enroutelisting=mysqli_fetch_array($rs22)){  
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id='.$enroutelisting['enrouteId'].'');  
					$enrouteData=mysqli_fetch_array($rs1);
				
					$enrouteName=strip($enrouteData['enrouteName']);
					$json_enroute.= '{
						"enrouteQuoteId" : "'.$enroutelisting['id'].'",
						"serviceType" : "Enroute", 
						"enrouteName" : "'.$enrouteName.'",
						"enrouteDetail" : "'.$enrouteDetail.'" 						
					},';
				}
			}
		}    
	
		if($itineryDayData['serviceType'] == 'entrance'){  
			$wherent='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate="'.$dayDate.'" order by id desc'; 
			$rsent=GetPageRecord('*','quotationEntranceMaster',$wherent);  
			if(mysqli_num_rows($rsent) > 0){
				while($entrancelisting=mysqli_fetch_array($rsent)){  
					$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
					$entranceData=mysqli_fetch_array($rsentn);    
					$entranceName=strip($entranceData['entranceName']);
					$query=GetPageRecord('*','quotationEntranceTimelineDetails','hotelQuoteId="'.$entrancelisting['id'].'"');  
					$entranceTime=mysqli_fetch_array($query);
					if($entranceTime['startTime']!=0){
						$startTime=date('H:i',strtotime($entranceTime['startTime']))." hrs";
					}
					if($entranceTime['endTime']!=0){
						$endTime=date('H:i',strtotime($entranceTime['endTime']))." hrs";
					}
					$json_entrance.= '{
						"entranceQuoteId" : "'.$entrancelisting['id'].'",
						"serviceType" : "Entrance", 
						"entranceName" : "'.$entranceName.'",
						"entranceDetail" : "'.$entranceDetail.'", 
						"startTime" : "'.$startTime.'",
						"endTime" : "'.$endTime.'"						
					},';
				}
			}
		}
		
		if($itineryDayData['serviceType'] == 'activity'){ 
			$where22='quotationId="'.$QueryDaysData['quotationId'].'" and fromDate="'.$dayDate.'" order by id desc';   
			$rs22=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where22);  
			if(mysqli_num_rows($rs22) > 0){
				while($activitylisting=mysqli_fetch_array($rs22)){   
 					$rs1=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$activitylisting['otherActivityName'].'"');  
					$quotationotherActivityData=mysqli_fetch_array($rs1);
				
					$activityName =$quotationotherActivityData['otherActivityName'];
					$query=GetPageRecord('*','quotationActivityTimelineDetails','hotelQuoteId="'.$activitylisting['id'].'"');  
					$entranceTime=mysqli_fetch_array($query);
					if($entranceTime['startTime']!=0){
					$startTime=date('H:i',strtotime($entranceTime['startTime']))." hrs";
					}
					if($entranceTime['endTime']!=0){
					$endTime=date('H:i',strtotime($entranceTime['endTime']))." hrs";
					}
					$json_activity.= '{
						"activityQuoteId" : "'.$activitylisting['id'].'",
						"serviceType" : "Activity", 
						"activityName" : "'.$activityName.'",
						"activityDetail" : "'.$activityDetail.'", 
						"startTime" : "'.$startTime.'",
						"endTime" : "'.$endTime.'"						
					},';
					
				}
			}
		}
		
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
					if($activitylisting['arrivalDate']!='0000-00-00' && $activitylisting['arrivalDate']!='1970-01-01' && $activitylisting['arrivalDate']!=''){
					$arrivalDate=date('d-m-Y',strtotime($activitylisting['arrivalDate']));
					}
					$arrivalTime=date("g:i", strtotime($activitylisting['arrivalTime']));
					if($activitylisting['departureDate']!='0000-00-00' && $activitylisting['departureDate']!='1970-01-01' && $activitylisting['departureDate']!=''){
					$departureDate=date('d-m-Y',strtotime($activitylisting['departureDate']));
					}
					if($activitylisting['departureTime']!=0){
					$departureTime=date("g:i", strtotime($activitylisting['departureTime']));
					}
					$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['departureFrom'].'"'); 
					$GuideData51=mysqli_fetch_array($rs51); 
					$fromDest = strip($GuideData51['name']); 
					
					$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['arrivalTo'].'"'); 
					$GuideData51=mysqli_fetch_array($rs51); 
					$toDest = strip($GuideData51['name']);
					 
					
					$json_flight.= '{
						"flightQuoteId" : "'.$activitylisting['id'].'",
						"serviceType" : "Flight", 
						"flightName" : "'.$flightName.'",
						"flightClass" : "'.$flightClass.'",
						"flightNumber" : "'.$flightNumber.'",
						"fromDest" : "'.$fromDest.'",
						"toDest" : "'.$toDest.'",
						"arrivalDate" : "'.$arrivalDate.'",
						"arrivalTime" : "'.$arrivalTime.'",
						"departureDate" : "'.$departureDate.'",
						"departureTime" : "'.$departureTime.'"						
					},';
					
				}
			}
		}
		
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
					if($activitylisting['arrivalDate']!='1970-01-01' && $activitylisting['arrivalDate']!=''){
					$arrivalDate=date('d-m-Y',strtotime($activitylisting['arrivalDate']));
					}
					$arrivalTime=date("g:i", strtotime($activitylisting['arrivalTime']));
					if($activitylisting['departureDate']!='1970-01-01' && $activitylisting['departureDate']!=''){
					$departureDate=date('d-m-Y',strtotime($activitylisting['departureDate']));
					}
					if($activitylisting['departureTime']!=0){
					$departureTime=date("g:i", strtotime($activitylisting['departureTime']));
					}
					$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['departureFrom'].'"'); 
					$GuideData51=mysqli_fetch_array($rs51); 
					$fromDest=strip($GuideData51['name']);
					
					$rs51=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$activitylisting['arrivalTo'].'"'); 
					$GuideData51=mysqli_fetch_array($rs51); 
					$toDest=strip($GuideData51['name']);  
					
					$json_train.= '{
						"trainQuoteId" : "'.$activitylisting['id'].'",
						"serviceType" : "Train", 
						"trainName" : "'.$trainName.'",
						"trainClass" : "'.$trainClass.'",
						"trainNumber" : "'.$trainNumber.'",
						"fromDest" : "'.$fromDest.'",
						"toDest" : "'.$toDest.'",
						"arrivalDate" : "'.$arrivalDate.'",
						"arrivalTime" : "'.$arrivalTime.'",
						"departureDate" : "'.$departureDate.'",
						"departureTime" : "'.$departureTime.'"				
					},';
				}
			}
		}
		
	//==============================================//    rtrim($string, ',')
	} 
	$json_daywise.= '{
		"day" : "'.$day.'", 
		"date" : "'.$date.'",
		"dayId" : "'.$dayId.'",
		"cityId" : "'.ucfirst($cityId).'",
		"hotel" : ['.rtrim($json_hotel, ',').'],
		"transfer" : ['.rtrim($json_transfer, ',').'],
		"enroute" : ['.rtrim($json_enroute, ',').'],
		"entrance" : ['.rtrim($json_entrance, ',').'],
		"activity" : ['.rtrim($json_activity, ',').'],
		"flight" : ['.rtrim($json_flight, ',').'],
		"train" : ['.rtrim($json_train, ',').'],
		"guide" : ['.rtrim($json_guide, ',').'],
		"mealplan" : ['.rtrim($json_mealplan, ',').'],
		"additional" : ['.rtrim($json_additional, ',').'] 
	},';
 	$day++;

}
$json_result.= '{
	"quotationId" : "'.$quotationId.'",
	"fromDate" : "'.$fromDate.'",
	"toDate" : "'.$toDate.'",
	"subject" : "'.$subject.'",
	"proposalPhoto" : "'.$proposalPhoto.'",
	"days" : ['.rtrim($json_daywise, ',').']
	
}';

?>
{
		"status":"true",
		"results":[<?php echo trim($json_result);?>]
}