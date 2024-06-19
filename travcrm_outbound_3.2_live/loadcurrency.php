<?php

include "inc.php"; 

if(trim($_REQUEST['action'])=='getROE_action' && trim($_REQUEST['currencyId'])!=''){ 

	$selectc='*';    
	$wherec=' id="'.$_REQUEST['currencyId'].'" and status=1 and deletestatus=0 order by id asc';  
	$rsc=GetPageRecord($selectc,_QUERY_CURRENCY_MASTER_,$wherec); 
	$currencyD=mysqli_fetch_array($rsc);
	if($currencyD['setDefault'] == 1){
		echo json_encode(array("dayroe" => '1.00', "asOnDate" => date('d-m-Y'))); 
	}else{
		$rs2=GetPageRecord('*','queryCurrencyRateMaster',' currencyId="'.trim($_REQUEST['currencyId']).'" and date="'.date('Y-m-d').'"'); 
		$editresult2=mysqli_fetch_array($rs2); 
		if( mysqli_num_rows($rs2) > 0){
			echo json_encode(array("dayroe" => number_format($editresult2['currencyValue'],2),"asOnDate" => date('d-m-Y',strtotime($editresult2['date'])))); 
	 	}else{
	        echo json_encode(array("dayroe" => 0, "asOnDate" => date('d-m-Y'))); 
	 	}   
	}

} 

if(trim($_REQUEST['action'])=='loadcurrency' && trim($_REQUEST['currencyId'])!=''){	
	
	
	$_REQUEST['currency'];
	$_REQUEST['packageId'];
	$_REQUEST['packagecost'];
	$_REQUEST['packagecostTax'];
	$selectq='*';    
	$whereq=' currencyTo = '.$_REQUEST['currency'].' ';  
	$rsq=GetPageRecord($selectq,_CURRENCY_CONVERSION_MASTER_,$whereq); 
	$currency=mysqli_fetch_array($rsq);
	
	$select='*';    
	$where=' id = '.$_REQUEST['currency'].' ';  
	$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
	$currencyName=mysqli_fetch_array($rs);
	$selectc='*';    
	$wherec=' deletestatus=0 and name="USD" order by id asc';  
	$rsc=GetPageRecord($selectc,_QUERY_CURRENCY_MASTER_,$wherec); 
	$currencies=mysqli_fetch_array($rsc);
	$usd = $currencies['currencyValue'];
	if($currencyName['name']=='INR'){
		echo round($_REQUEST['packagecost']*$usd/$currencyName['currencyValue']).'  '.'INR';
	}elseif($currencyName['name']=='USD'){
		echo round($_REQUEST['packagecost']*$usd/$currencyName['currencyValue']).'  '.'USD';
	}
	elseif($currencyName['name']=='HKD'){
		echo round($_REQUEST['packagecost']*$usd/$currencyName['currencyValue']).'  '.'HKD';
	}
	elseif($currencyName['name']=='EURO'){
		echo round($_REQUEST['packagecost']*$usd/$currencyName['currencyValue']).'  '.'EURO';
	}
	elseif($currencyName['name']=='AED'){
		echo round($_REQUEST['packagecost']*$usd/$currencyName['currencyValue']).'  '.'AED';
	}
	elseif($currencyName['name']=='SGD'){
		echo round($_REQUEST['packagecost']*$usd/$currencyName['currencyValue']).'  '.'SGD';
	}
	elseif($currencyName['name']=='CDR'){
		echo round($_REQUEST['packagecost']*$usd/$currencyName['currencyValue']).'  '.'CDR';
	}
	
	?>
	<script>
	//$('#queryPackageTotalCost').text('<?php echo round(($_REQUEST['packagecost']+$_REQUEST['packagecostTax'])*$usd/$currencyName['currencyValue']); ?>');
	</script> 
<?php } 

if(trim($_REQUEST['action'])=='getGTCost_action' && trim($_REQUEST['serviceId'])!='' && trim($_REQUEST['grandServiceCost'])!=0 ){	
	$GTCost = 0;
	$namevalue ='grandServiceCost="'.$_REQUEST['grandServiceCost'].'",gst="'.$_REQUEST['gst'].'"';
	$serviceType = trim($_REQUEST['serviceType']);
	if($serviceType == 'Hotel'){
		$updatelist = updatelisting('finalQuote',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuote','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteHotel = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteHotel['quotationId'];
		
	}
	elseif($serviceType == 'Transfer'){
 		$updatelist = updatelisting('finalQuotetransfer',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuotetransfer','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteTransfer = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteTransfer['quotationId'];
	}
	elseif($serviceType == 'Entrance'){
 		$updatelist = updatelisting('finalQuoteEntrance',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuoteEntrance','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteEntrance = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteEntrance['quotationId'];
	}
	elseif($serviceType == 'Activity'){
 		$updatelist = updatelisting('finalQuoteActivity',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuoteActivity','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteActivity = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteActivity['quotationId'];
	}
	elseif($serviceType == 'Trains'){
 		$updatelist = updatelisting('finalQuoteTrains',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuoteTrains','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteTrain = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteTrain['quotationId'];
	}
	elseif($serviceType == 'Flights'){
 		$updatelist = updatelisting('finalQuoteFlights',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuoteFlights','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteFlight = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteFlight['quotationId'];
	}
	elseif($serviceType == 'Guides'){	
 		$updatelist = updatelisting('finalQuoteGuides',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuoteGuides','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteGuides = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteGuides['quotationId'];
	}else{
		$updatelist = updatelisting('finalQuoteGuides',$namevalue,'id="'.($_REQUEST['serviceId']).'"'); 
	
		$rsh=GetPageRecord('*','finalQuoteGuides','id="'.$_REQUEST['serviceId'].'"'); 
		$finalQuoteGuides = mysqli_fetch_array($rsh);
		$quotationId = $finalQuoteGuides['quotationId'];
	} 
	
	$rs=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$quotationId.'" and status=1'); 
	$quotationData=mysqli_fetch_array($rs);
	$pax = trim($quotationData['adult']+$quotationData['child']);
	//echo $quotationId; 
	$singQuery = "";   
	if($quotationData['quotationType'] == 2){ 
		$singQuery = " and categoryId='".$quotationData['finalcategory']."'";
	} 
	
	
	//for gtCost
	$grandHotelCost = 0;
	$r1=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationData['id'].'" '.$singQuery.' order by fromDate asc '); 
	while($hotelQuotData=mysqli_fetch_array($r1)){
 		$r2=GetPageRecord('*','finalQuote',' quotationId="'.($quotationData['id']).'" and hotelQuotationId="'.$hotelQuotData['id'].'" order by id desc limit 1'); 
		$finalQuoteHotel = mysqli_fetch_array($r2);
		
		if(($finalQuoteHotel['roomSingleCost'])!=0 && ($finalQuoteHotel['roomSingle'])!=0 ){
			$roomSingleCost = ($finalQuoteHotel['roomSingleCost'])*($finalQuoteHotel['roomSingle']);
		}
		if(($finalQuoteHotel['roomDoubleCost'])!=0 && ($finalQuoteHotel['roomDouble'])!=0 ){
			$roomDoubleCost = ($finalQuoteHotel['roomDoubleCost'])*($finalQuoteHotel['roomDouble']);
		}
		if(($finalQuoteHotel['roomTripleCost'])!=0 && ($finalQuoteHotel['roomTriple'])!=0 ){
			$roomTripleCost = ($finalQuoteHotel['roomTripleCost'])*($finalQuoteHotel['roomTriple']);
		}
		if(($finalQuoteHotel['childWOBedCost'])!=0 && ($finalQuoteHotel['childWOBed'])!=0 ){
			$childWOBedCost = ($finalQuoteHotel['childWOBedCost'])*($finalQuoteHotel['childWOBed']);
		}
		if(($finalQuoteHotel['childWBedCost'])!=0 && ($finalQuoteHotel['childWBed'])!=0 ){
			$childWBedCost = ($finalQuoteHotel['childWBedCost'])*($finalQuoteHotel['childWBed']);
		}
		if(($finalQuoteHotel['roomExtraCost'])!=0 && ($finalQuoteHotel['roomExtra'])!=0 ){
			$roomExtraCost = ($finalQuoteHotel['roomExtraCost'])*($finalQuoteHotel['roomExtra']);
		}
	  
		echo $totalHotelCost = ($roomSingleCost+$roomDoubleCost+$roomTripleCost+$childWOBedCost+$childWBedCost+$roomExtraCost);
		$grandHotelCost = $grandHotelCost+$totalHotelCost;
	}	
	$grandTransferCost=0;
	$r3=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationData['id'].'" order by fromDate asc '); 
	while($transferQuotData=mysqli_fetch_array($r3)){
		$r4=GetPageRecord('*','finalQuotetransfer','quotationId="'.clean($quotationData['id']).'" and transferQuotationId="'.$transferQuotData['id'].'" order by id desc limit 1');
		$finalQuoteTransfer = mysqli_fetch_array($r4);	
		$grandTransferCost = $grandTransferCost+$finalQuoteTransfer['vehicleCost'];
	}
	 
	$grandEntranceCost =0;
	$r5=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,' quotationId="'.$quotationData['id'].'" order by fromDate asc '); 
	while($entranceQuotData=mysqli_fetch_array($r5)){		
		$r6=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.clean($quotationData['id']).'" and entranceQuotationId="'.$entranceQuotData['id'].'" order by id desc limit 1');
		$finalQuoteEntrance = mysqli_fetch_array($r6);
		$totalEntranceCost = ($finalQuoteEntrance['adultCost']*$pax)+($finalQuoteEntrance['adultCost']*$pax);	
		$grandEntranceCost = $grandEntranceCost+$totalEntranceCost;
		
	}
	
	$grandActivityCost =0;
	$r7=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationData['id'].'" order by fromDate asc '); 
	while($activityQuotData=mysqli_fetch_array($r7)){
		$r8=GetPageRecord('*','finalQuoteActivity','quotationId="'.clean($quotationData['id']).'" and activityQuotationId="'.$activityQuotData['id'].'" order by id desc limit 1');
		$finalQuoteActivity = mysqli_fetch_array($r8);	
		$totalActivityCost = ($finalQuoteActivity['adultCost']*$pax)+($finalQuoteActivity['adultCost']*$pax);	
		$grandActivityCost = $grandActivityCost+$totalActivityCost;
	}
	
	$grandTrainsCost = 0;
	$r9=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationData['id'].'" order by fromDate asc '); 
	while($trainQuotData=mysqli_fetch_array($r9)){
		$r10=GetPageRecord('*','finalQuoteTrains','quotationId="'.clean($quotationData['id']).'" and trainQuotationId="'.$trainQuotData['id'].'" order by id desc limit 1');
		$finalQuoteTrains = mysqli_fetch_array($r10);	
		$totalTrainsCost = ($finalQuoteTrains['adultCost']*$pax)+($finalQuoteTrains['adultCost']*$pax);	
		$grandTrainsCost = $grandTrainsCost+$totalTrainsCost;
	}
	
	$grandFlightsCost = 0;
	$r11=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationData['id'].'" order by fromDate asc '); 
	while($flightQuotData=mysqli_fetch_array($r11)){
		$r12=GetPageRecord('*','finalQuoteFlights','quotationId="'.clean($quotationData['id']).'" and flightQuotationId="'.$flightQuotData['id'].'" order by id desc limit 1');
		$finalQuoteFlights = mysqli_fetch_array($r12);	
		$totalFlightsCost = ($finalQuoteFlights['adultCost']*$pax)+($finalQuoteFlights['adultCost']*$pax);	
		$grandFlightsCost = $grandFlightsCost+$totalFlightsCost;	
	}
	
	$grandGuidesCost = 0;
	$r13=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' quotationId="'.$quotationId.'" order by fromDate asc '); 
	while($guideQuotData=mysqli_fetch_array($r13)){
		$s=GetPageRecord('*','finalQuoteGuides','quotationId="'.clean($guideQuotData['quotationId']).'" and guideQuotationId="'.$guideQuotData['id'].'" order by id desc limit 1');
		$finalQuoteGuides = mysqli_fetch_array($s);	
		$totalGuidesCost = ($finalQuoteGuides['adultCost']*$pax)+($finalQuoteGuides['adultCost']*$pax);	
		$grandGuidesCost = $grandGuidesCost+$totalGuidesCost;
	}
	 
	$GTCost = ($grandHotelCost+$grandTransferCost+$grandEntranceCost+$grandActivityCost+$grandTrainsCost+$grandFlightsCost+$grandGuidesCost);  
	if( $GTCost > 0){ 
         echo json_encode(array("gTCost" => round($GTCost,2))); 
	}else{
         echo json_encode(array("gTCost" => 0)); 
	}  
} 

?>