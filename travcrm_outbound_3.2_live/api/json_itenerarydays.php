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
$where='companyId='.$masterid.' and clientType='.$clientType.' and fromDate >= "'.date('Y-m-d').'" order by fromDate asc limit 1';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
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
					
					while($hotellisting=mysqli_fetch_array($rs22)){
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hoteldetail=mysqli_fetch_array($rs1ee);      
						
						$rs112=GetPageRecord('*',finalQuote,'quotationId="'.$hotellisting['quotationId'].'" and hotelQuotationId="'.$hotellisting['id'].'"');  
						$rooms=mysqli_fetch_array($rs112);
						$totalrooms=$rooms['roomSingle']+$rooms['roomDouble']+$rooms['roomTriple']+$rooms['roomExtra'];
						if($hoteldetail['hotelImage']!=''){
						$hotelImage2=$hoteldetail['hotelImage'];
						$hotelImage="".$fullurl."packageimages/".$hotelImage2;
						}else{
						$hotelImage=''.$fullurl.'images/hotel.jpeg';
						}
						$hotelName=strip($hoteldetail['hotelName']);
						
						$rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategory'].'"');  
						$hotelCatNam=mysqli_fetch_array($rs231er);  
						$hotelcategory=$hotelCatNam['name'];
						
						$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$hotellisting['roomType'].'');  
						$roomtype=mysqli_fetch_array($rs23qwe);  
						$roomType=$roomtype['name'];
						
						$vrs1=GetPageRecord('*','voucherDetailsMaster','serviceId="'.$hotellisting['id'].'" and quotationId = "'.$hotellisting['quotationId'].'" and serviceType="hotel" and serviceVoucher!=""');  
						$voucherData=mysqli_fetch_array($vrs1);
						$voucherUrl = $fullurl."upload/".$voucherData['serviceVoucher'];
						
						$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
						$mealplan=mysqli_fetch_array($rssda24); 
						$mealPlan=$mealplan['name'];
					
						$json_hotel.= '{
							"hotelQuoteId" : "'.$hotellisting['id'].'",
							"serviceType" : "hotel", 
							"hotelName" : "'.$hotelName.'",
							"voucherUrl" : "'.$voucherUrl.'",
							"hotelImage" : "'.$hotelImage.'",
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
			
				while($transferlisting=mysqli_fetch_array($rs22dd)){  
					$rs2ss=GetPageRecord('transferName,transferDetail',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
					$transfergdetail=mysqli_fetch_array($rs2ss);
			
					$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');  
					$venamelist=mysqli_fetch_array($rs1aa);
			        if($venamelist['image']!=''){
					$vehicleImage2=$venamelist['image'];
					$vehicleImage=$fullurl."packageimages/".$vehicleImage2;
			        }else{
			        $vehicleImage=''.$fullurl.'images/transfer.jpeg';
			        }
					$transferName=$transfergdetail['transferName'];
					//$type='Private';
					//$vename=$venamelist['name'];
					$vemaxpax=$venamelist['maxpax'];
					$model=$venamelist['model'];
					//$vetransferDetail=strip_tags($transfergdetail['transferDetail']);
				
					if($transferlisting['startTime']!=0){ 
						$vestarttime=date('H:i',strtotime($transferlisting['startTime']))." Hrs"; 
					}
				 
					if($transferlisting['endTime']!=0){ 
						$veendtime=date('H:i',strtotime($transferlisting['endTime']))." Hrs"; 
					}
					
					//hotelQuoteId	
					$query=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferlisting['id'].'"');  
					$entranceTime=mysqli_fetch_array($query);
					if($entranceTime['dropTime']!=0){
					$pickupTime=date('H:i',strtotime($entranceTime['dropTime']))." Hrs";
					}
					if($entranceTime['pickupTime']!=0){
					$dropTime=date('H:i',strtotime($entranceTime['pickupTime']))." Hrs";
					}
					$json_transfer.= '{
						"transferQuoteId" : "'.$transferlisting['id'].'",
						"serviceType" : "'.ucfirst($itineryDayData['serviceType']).'", 
						"transferName" : "'.$transferName.'",
						"vehicleImage" : "'.$vehicleImage.'",
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
					if($enrouteData['enrouteImage']!=''){
					$enrouteImage2=$enrouteData['enrouteImage'];
					$enrouteImage="".$fullurl."packageimages/".$enrouteImage2;
					}else{
					$enrouteImage=''.$fullurl.'images/sightseeingthumbpackage.png';
					}
					$enrouteName=strip($enrouteData['enrouteName']);
					//$enrouteDetail=strip_tags($enrouteData['enrouteDetail']);
					
					$json_enroute.= '{
						"enrouteQuoteId" : "'.$enroutelisting['id'].'",
						"serviceType" : "Enroute", 
						"enrouteName" : "'.$enrouteName.'",
						"enrouteImage" : "'.$enrouteImage.'",
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
					if($entranceData['entranceImage']!=''){
					$entranceImage2=$entranceData['entranceImage'];
					$entranceImage="".$fullurl."packageimages/".$entranceImage2;
					}else{
					$entranceImage=''.$fullurl.'images/entrance.jpeg';    
					}
					$entranceName=strip($entranceData['entranceName']);
					//$entranceDetail=str_replace($entranceData['entranceDetail']);
					
					$query=GetPageRecord('*','quotationEntranceTimelineDetails','hotelQuoteId="'.$entrancelisting['id'].'"');  
					$entranceTime=mysqli_fetch_array($query);
					if($entranceTime['startTime']!=0){
					$startTime=date('H:i',strtotime($entranceTime['startTime']))." Hrs";
					}
					if($entranceTime['endTime']!=0){
					$endTime=date('H:i',strtotime($entranceTime['endTime']))." Hrs";
					}
					$json_entrance.= '{
						"entranceQuoteId" : "'.$entrancelisting['id'].'",
						"serviceType" : "Entrance", 
						"entranceName" : "'.$entranceName.'",
						"entranceImage" : "'.$entranceImage.'",
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
					if($quotationotherActivityData['otherActivityImage']!=''){
					$activityImage2=$quotationotherActivityData['otherActivityImage'];
					$activityImage=$fullurl."packageimages/".$activityImage2;
					}else{
					$activityImage=''.$fullurl.'images/activity.jpeg';     
					}
					$activityName =$quotationotherActivityData['otherActivityName'];
					//$activityDetail=$quotationotherActivityData['otherActivityDetail'];
					
					$query=GetPageRecord('*','quotationActivityTimelineDetails','hotelQuoteId="'.$activitylisting['id'].'"');  
					$entranceTime=mysqli_fetch_array($query);
					if($entranceTime['startTime']!=0){
					$startTime=date('H:i',strtotime($entranceTime['startTime']))." Hrs";
					}
					if($entranceTime['endTime']!=0){
					$endTime=date('H:i',strtotime($entranceTime['endTime']))." Hrs";
					}
					$json_activity.= '{
						"activityQuoteId" : "'.$activitylisting['id'].'",
						"serviceType" : "Activity", 
						"activityName" : "'.$activityName.'",
						"activityImage" : "'.$activityImage.'",
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
					
					if($activitydetail['flightImage']!=''){
					$flightImage2=$activitydetail['flightImage'];
					$flightImage="".$fullurl."packageimages/".$flightImage2;
					}else{
					$flightImage=''.$fullurl.'images/flight.jpg';    
					}  
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
					
					$vrs1=GetPageRecord('*','voucherDetailsMaster','serviceId="'.$activitylisting['id'].'" and quotationId = "'.$activitylisting['quotationId'].'" and serviceType="flight" and serviceVoucher!=""');  
					$voucherData=mysqli_fetch_array($vrs1);
					$voucherUrl = $fullurl."upload/".$voucherData['serviceVoucher'];
					
					$json_flight.= '{
						"flightQuoteId" : "'.$activitylisting['id'].'",
						"serviceType" : "Flight", 
						"flightName" : "'.$flightName.'",
						"flightClass" : "'.$flightClass.'",
						"flightNumber" : "'.$flightNumber.'",
						"flightImage" : "'.$flightImage.'",
						"voucherUrl" : "'.$voucherUrl.'",
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
					
					if($activitydetail['trainImage']!=''){
					$trainImage2=$activitydetail['trainImage'];
					$trainImage="".$fullurl."packageimages/".$trainImage2;
					}else{
					$trainImage=''.$fullurl.'images/train.jpg';    
					}  
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
						"trainImage" : "'.$trainImage.'",
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
		
     	//==================download voucher============//
		$where11='quotationId='.$itineryDayData['quotationId'].' and status=1 order by id desc'; 
		$voucherData=GetPageRecord('*','voucherDetailsMaster',$where11); 
		while($voucherlist=mysqli_fetch_array($voucherData)){
		  if($voucherlist['serviceType']=='hotel'){
		   	$downloadpdf= $fullurl."upload/".$voucherlist['serviceVoucher']."";
		  }
		  if($voucherlist['serviceType']=='flight'){
			$flightVoucher= $fullurl."upload/".$voucherlist['serviceVoucher']."";
		  }
		  if($voucherlist['serviceType']=='transfer'){
			$transferVoucher= $fullurl."upload/".$voucherlist['serviceVoucher']."";
		  }
		  if($voucherlist['serviceType']=='activity'){
		   $activityVoucher= $fullurl."upload/".$voucherlist['serviceVoucher']."";
		  }
		  if($voucherlist['serviceType']=='entrance'){
		   $entranceVoucher= $fullurl."upload/".$voucherlist['serviceVoucher']."";
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