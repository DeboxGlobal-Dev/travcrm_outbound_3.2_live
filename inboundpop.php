<?php
include "inc.php";
ini_set('post_max_size', '10M');
ini_set('upload_max_filesize', '10M');
//actions for delete code or popup


if($_REQUEST['action'] == 'deleteQuotationHotel'){

	$serviceIdArr = explode('_', $_REQUEST['serviceId']);
	$serviceId = $serviceIdArr['0'];
	$hotelId = $serviceIdArr['1'];
	$quotationId = $_REQUEST['quotationId'];


	$quotQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$serviceId.'" and quotationId="'.$quotationId.'"');
	if(mysqli_num_rows($quotQuery) > 0){
		$qHotelData=mysqli_fetch_array($quotQuery);
		
		// Hotel Supplement
		// need to delete all the hotel supplement regarding the requested deleteId
		$quotHSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' hotelQuoteId="'.$serviceId.'" and dayId="'.$qHotelData['dayId'].'" and isHotelSupplement=1 and quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($quotHSuppQuery)>0){
			while($qHSuppData=mysqli_fetch_array($quotHSuppQuery)){ 

				$checkHSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' dayId="'.$qHSuppData['dayId'].'" and supplierId="'.$qHSuppData['supplierId'].'" and quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($checkHSuppQuery) == 1){
					$qHSuppData=mysqli_fetch_array($checkHSuppQuery); 
					// need to delete this entry because this entry having only one dependent rate
					deleteRecord('quotationItinerary',' serviceType="hotel" and quotationId="'.$quotationId.'" and serviceId="'.$qHSuppData['supplierId'].'"  and dayId="'.$qHSuppData['dayId'].'" ');
				}
				deleteRecord(_QUOTATION_HOTEL_MASTER_,'id="'.$qHSuppData['id'].'" and isHotelSupplement=1'); 
			}
		}
		// Room Supplement
		// need to delete all the Room supplement regarding the requested deleteId
		$quotRSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' hotelQuoteId="'.$serviceId.'" and dayId="'.$qHotelData['dayId'].'" and isRoomSupplement=1 and quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($quotRSuppQuery)>0){
			while($qRSuppData=mysqli_fetch_array($quotRSuppQuery)){ 

				$checkRSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' dayId="'.$qRSuppData['dayId'].'" and supplierId="'.$qRSuppData['supplierId'].'" and quotationId="'.$quotationId.'"');
				if(mysqli_num_rows($checkRSuppQuery) == 1){
					$qRSuppData=mysqli_fetch_array($checkRSuppQuery); 
					// need to delete this entry because this entry having only one dependent rate
					deleteRecord('quotationItinerary',' serviceType="hotel" and quotationId="'.$quotationId.'" and serviceId="'.$qRSuppData['supplierId'].'"  and dayId="'.$qRSuppData['dayId'].'" ');
				}
				deleteRecord(_QUOTATION_HOTEL_MASTER_,'id="'.$qRSuppData['id'].'" and isRoomSupplement=1'); 
			}
		}

		// Normal Supplement
		// need to delete this the Normal Rate
		$checkRSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' dayId="'.$qHotelData['dayId'].'" and supplierId="'.$qHotelData['supplierId'].'" and quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($checkRSuppQuery) == 1){
			$qRSuppData=mysqli_fetch_array($checkRSuppQuery); 
			// need to delete this entry because this entry having only one dependent rate
			deleteRecord('quotationItinerary',' serviceType="hotel" and quotationId="'.$quotationId.'" and serviceId="'.$qRSuppData['supplierId'].'"  and dayId="'.$qRSuppData['dayId'].'" ');
		}
		deleteRecord(_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
		?>
		<script>
			warningalert('Hotel Deleted!');
			loadquotationmainfile();
		</script>
		<?php
	}
}
if($_REQUEST['action'] == 'deleteQuotationFerry'){
 	deleteRecord('quotationFerryMaster','id="'.$_REQUEST['serviceId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
	?>	
	<script>
		warningalert('Room Supplement Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteQuotationCruise'){

	deleteRecord('quotationCruiseMaster','id="'.$_REQUEST['serviceId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord('quotationItinerary',' serviceType="cruise" and quotationId="'.$_REQUEST['quotationId'].'" and serviceId="'.$_REQUEST['serviceId'].'"  and dayId="'.$qRSuppData['dayId'].'" ');
   ?>	
   <script>
	   warningalert('Cruise Service Deleted!');
	   loadquotationmainfile();
   </script>
   <?php
}

if($_REQUEST['action'] == 'deleteQuotationRoomSupplement'){
	deleteRecord('quotationRoomSupplimentMaster','id="'.$_REQUEST['serviceId'].'"');
   ?>
   <script>
	   warningalert('Room Supplement Deleted!');
	   loadquotationmainfile();
   </script>
   <?php
}

if($_REQUEST['action'] == 'deleteQuotationHotelAdditional'){
	deleteRecord('quotationHotelAdditionalMaster','id="'.$_REQUEST['serviceId'].'"');
   ?>
   <script>
	   warningalert('Hotel Additional Deleted!');
	   loadquotationmainfile();
   </script>
   <?php
} 

if($_REQUEST['action'] == 'deleteQuotationTransfer'){

	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="transfer" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_TRANSFER_MASTER_,' id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
	warningalert('Transfer Deleted..!');
	loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteQuotationTransport'){

	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="transportation" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_TRANSFER_MASTER_,' id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
	warningalert('Transportation Deleted..!');
	loadquotationmainfile();
	</script>
	<?php
}


if($_REQUEST['action'] == 'deleteQuotationSightseeing'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="sightseeing" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_SIGHTSEEING_MASTER_,' id = '.$_REQUEST['serviceId'].'');
	?>
	<script>
	warningalert('Transportation Deleted..!');
	loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteActivityQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="activity" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_OTHER_ACTIVITY_MASTER_,' id = '.$_REQUEST['serviceId'].'');
	?>
	<script>
	warningalert('Sightseeing Deleted..!');
	loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteGuideQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="guide" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_GUIDE_MASTER_,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Tour Escort Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteEntranceQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="entrance" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_ENTRANCE_MASTER_,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Monument Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteEnrouteQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="enroute" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_ENROUTE_MASTER_,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Enroute Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteMealPlanQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="mealplan" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Restaurant Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteAdditionalQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="additional" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_EXTRA_MASTER_,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Additional Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteItineraryQuotation'){
	
	$namevalue='title="",description=""';
	
	updatelisting('newQuotationDays',$namevalue,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Itinerary Information Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteTrainQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="train" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_TRAINS_MASTER_,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Train Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteFlightQuotation'){
	deleteRecord('quotationItinerary','serviceId = "'.$_REQUEST['serviceId'].'" and serviceType="flight" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord(_QUOTATION_FLIGHT_MASTER_,'id = "'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Flight Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}


if($_REQUEST['action'] == 'deleteServiceMarkup' && $_REQUEST['serviceMarkId']!=''){
 	deleteRecord('quotationServiceMarkup','id = "'.$_REQUEST['serviceMarkId'].'"');
	?>
	<script>
		warningalert('Markup Deleted!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'editSupplimentService' && $_REQUEST['deleteid']!=''){
	$namevalue ='adultCost="'.$_REQUEST['adultCost'].'",childCost="'.$_REQUEST['childCost'].'",infantCost="'.$_REQUEST['infantCost'].'"';
	$updatelist = updatelisting('quotationAdditionalMaster',$namevalue,'id="'.decode($_REQUEST['deleteid']).'"');
	?>
	<script>
	parent.$('#inboundpopbg').hide();
	parent.$('#pageloader').hide();
	parent.$('#pageloading').hide();
	parent.loadAddtionalDatafun();
	// parent.location.reload();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteAdditionalExperience' && $_REQUEST['additionalId']!='' && $_REQUEST['quotationId']!='' ){
 	deleteRecord('quotationAdditionalMaster','id = "'.$_REQUEST['additionalId'].'"');
	deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['additionalId'].'" and serviceType="additional" and quotationId="'.$_REQUEST['quotationId'].'"');
	?>
	<script>
		warningalert('Additional Deleted!');
		loadquotationmainfile();
		// location.reload();
	</script>
	<?php
}

if($_REQUEST['action'] == 'deleteTransport' && $_REQUEST['transportId']!='' && $_REQUEST['quotationId']!='' ){
 	deleteRecord('quotationTransferMaster','id = "'.$_REQUEST['transportId'].'"');
	//echo 'serviceId="'.$_REQUEST['transportId'].'" and serviceType="transportation" and quotationId="'.$_REQUEST['quotationId'].'"';
	deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['transportId'].'" and serviceType="transportation" and quotationId="'.$_REQUEST['quotationId'].'"');
	?>
	<script>
		warningalert('Transportation Deleted!');
		//loadquotationmainfile();
		
	</script>
	<?php
}
 

//end actions for delete code or popup

// save actions

if($_REQUEST['action'] == 'saveQuotationHotel' && $_REQUEST['serviceId']!=''){
	$namevalue ='mealPlan="'.$_REQUEST['mealPlan'].'",roomType="'.$_REQUEST['roomType'].'",childwithbed="'.$_REQUEST['childwithbed'].'",childwithoutbed="'.$_REQUEST['childwithoutbed'].'",singleoccupancy="'.$_REQUEST['singleoccupancy'].'",doubleoccupancy="'.$_REQUEST['doubleoccupancy'].'",twinoccupancy="'.$_REQUEST['doubleoccupancy'].'",tripleoccupancy="'.($_REQUEST['doubleoccupancy']+$_REQUEST['extraBed']).'",breakfast="'.$_REQUEST['breakfast'].'",lunch="'.$_REQUEST['lunch'].'",dinner="'.$_REQUEST['dinner'].'",extraBed="'.$_REQUEST['extraBed'].'",sixBedRoom="'.$_REQUEST['sixBedRoomCost'].'",eightBedRoom="'.$_REQUEST['eightBedRoomCost'].'",tenBedRoom="'.$_REQUEST['tenBedRoomCost'].'",quadRoom="'.$_REQUEST['quadRoomCost'].'",teenRoom="'.$_REQUEST['teenRoomCost'].'",childDinner="'.$_REQUEST['childdinnerc'].'",childLunch="'.$_REQUEST['childlunchc'].'",childBreakfast="'.$_REQUEST['childbreakfastc'].'"';
	$updatelist = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.($_REQUEST['serviceId']).'"');
	?>
	<script>
		warningalert('Hotel Updated!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'saveQuotationRoomSupplement' && $_REQUEST['serviceId']!=''){
	$namevalue ='mealPlan="'.$_REQUEST['mealPlan'].'",roomType="'.$_REQUEST['roomType'].'",childwithbed="'.$_REQUEST['childwithbed'].'",childwithoutbed="'.$_REQUEST['childwithoutbed'].'",singleoccupancy="'.$_REQUEST['singleoccupancy'].'",doubleoccupancy="'.$_REQUEST['doubleoccupancy'].'",twinoccupancy="'.$_REQUEST['doubleoccupancy'].'",breakfast="'.$_REQUEST['breakfast'].'",lunch="'.$_REQUEST['lunch'].'",dinner="'.$_REQUEST['dinner'].'",tripleoccupancy="'.($_REQUEST['doubleoccupancy']+$_REQUEST['extraBed']).'",extraBed="'.$_REQUEST['extraBed'].'",teenRoom="'.$_REQUEST['suppTeenRoomCost'].'",quadRoom="'.$_REQUEST['suppQuadRoomCost'].'",sixBedRoom="'.$_REQUEST['suppSixRoomCost'].'",eightBedRoom="'.$_REQUEST['suppEightRoomCost'].'",tenBedRoom="'.$_REQUEST['suppTenRoomCost'].'",childLunch="'.$_REQUEST['suppLunchCost'].'",childDinner="'.$_REQUEST['suppdinnerCost'].'",childBreakfast="'.$_REQUEST['suppBRCost'].'"';

	$updatelist = updatelisting('quotationRoomSupplimentMaster',$namevalue,'id="'.($_REQUEST['serviceId']).'"');
	?>
	<script>
		warningalert('Hotel Updated!');
		loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'saveQuotationTransfer1111' && $_REQUEST['serviceId']!=''){

	$vehicleCost= $adultCost= $childCost= $infantCost= 0;
	if($_REQUEST['transferType']==2){
		$vehicleCost= $_REQUEST['vehicleCost'];
		$noOfVehicles= $_REQUEST['noOfVehicles'];
	}else{
		$adultCost= $_REQUEST['adultCost'];
		$childCost= $_REQUEST['childCost'];
		$infantCost= $_REQUEST['infantCost'];
	}
	//noOfVehicles
	$namevalue ='transferName="'.$_REQUEST['transferNameId'].'",vehicleCost="'.$vehicleCost.'",noOfVehicles="'.$noOfVehicles.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",totalPax="'.$_REQUEST['paxSlab'].'",vehicleModelId="'.$_REQUEST['vehicleModelId'].'"';
	$updatelist = updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue,'id="'.($_REQUEST['serviceId']).'"');
	?>
	<script>
	warningalert('Transport Updated!');
	loadquotationmainfile();
	</script>
	<?php
} 


if($_REQUEST['action'] == 'saveQuotationTransport' && $_REQUEST['serviceId']!=''){
	$namevalue ='transferName="'.$_REQUEST['transferNameId'].'",vehicleCost="'.$_REQUEST['vehicleCost'].'",distance="'.$_REQUEST['distance'].'",totalPax="'.$_REQUEST['paxSlab'].'",vehicleModelId="'.$_REQUEST['vehicleModelId'].'",noOfVehicles="'.$_REQUEST['noOfVehicles'].'",vehicleType="'.$_REQUEST['vehicleType'].'"';
	$updatelist = updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue,'id="'.($_REQUEST['serviceId']).'"');
	?>
	<script>
	warningalert('Transport Updated!');
	loadquotationmainfile();
	</script>
	<?php
} 
 
if($_REQUEST['action'] == 'saveEnrouteQuotation' && $_REQUEST['serviceId']!=''){
	$namevalue ='adultCost="'.$_REQUEST['adultCost'].'",childCost="'.$_REQUEST['childCost'].'",infantCost="'.$_REQUEST['infantCost'].'"';
	$updatelist = updatelisting(_QUOTATION_ENROUTE_MASTER_,$namevalue,'id="'.($_REQUEST['serviceId']).'"');
	?>
	<script>
	warningalert('Enroute Updated!');
	loadquotationmainfile();
	</script>
	<?php
}

if($_REQUEST['action'] == 'saveGuideQuotation' && $_REQUEST['serviceId']!=''){
	$namevalue ='perDaycost="'.$_REQUEST['perDaycost'].'",price="'.$_REQUEST['price'].'",slabId="'.$_REQUEST['slabId'].'"';
	$updatelist = updatelisting(_QUOTATION_GUIDE_MASTER_,$namevalue,'id="'.($_REQUEST['serviceId']).'"');
	?>
	<script>
		warningalert('Tour Escort Updated!');
		loadquotationmainfile();
	</script>
	<?php
}


if($_REQUEST['action'] == 'saveItineraryQuotation' && $_REQUEST['serviceId']!=''){
	

	$namevalue ='title="'.trim($_REQUEST['subjectTitle']).'",drivingDistance="'.trim($_REQUEST['distanceTitle']).'",description="'.trim($_REQUEST['description']).'"';
	$updatelist = updatelisting('newQuotationDays',$namevalue,'id="'.$_REQUEST['serviceId'].'"');
	?>
	<script>
		warningalert('Itinerary Infomation Updated!');
		loadquotationmainfile();
	</script>
	<?php
} 

//end of the save actions

//action for adding code or popup
if($_REQUEST['action'] == 'addServiceHotel' && $_REQUEST['dayId']!=''){ 
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	$lastDayQuery=GetPageRecord('*','newQuotationDays','  quotationId="'.$dayData['quotationId'].'" and addstatus=0  order by id desc limit 1');
	$lastDayData = mysqli_fetch_array($lastDayQuery);
	$lastDayId = $lastDayData['id'];

	
	 //for day serial
	$day1 = 1;
	$dayQuery1=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'"  and addstatus=0  order by id asc');
	while($dayData1 = mysqli_fetch_array($dayQuery1)){
		if(strip($dayData1['id']) == $_REQUEST['dayId']){ break; }
		$day1++;
	}

	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);
	
	//Query data
	$queQuery="";
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);
	$queryType = $queryData['queryType'];
	$paxType = $queryData['paxType'];
	$earlyCheckin = $queryData['earlyCheckin'];
	$moduleType = $queryData['moduleType'];

	$focQLE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$quotationData['id'].'" and focType="LE" ');
	$focQFE=GetPageRecord('*','quotationFOCRates','1 and quotationId="'.$quotationData['id'].'" and focType="FE" ');



 	?>
<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>
 	<div class="inboundheader" >
 		<!-- style="background-color: #ffffff;color: #233a49;" -->
 		<?php if(isset($_REQUEST['hotelQuoteId']) && $_REQUEST['stype'] == 'hotelSupplement'){
 			$headingName = 'Hotel Supplement';
 			$selectionType = 'isHotelSupplement';
 		}elseif(isset($_REQUEST['hotelQuoteId']) && $_REQUEST['stype'] == 'roomSupplement'){
 			$headingName = 'Room Supplement';
 			$selectionType = 'isRoomSupplement';
 		}else{
 			$headingName = 'Normal Hotel';
 			$selectionType = 'isGuestType';
 		} 
 		if($queryData['dayWise']==1){ $headingName = $headingName."&nbsp;|&nbsp;".date('D j M Y', strtotime($dayData['srdate'])); } 
 		?>&nbsp;<?php echo $headingName; ?>&nbsp;&nbsp;|&nbsp;&nbsp;Pax&nbsp;Type:&nbsp;<?php echo ($paxType == 1)?'GIT':'FIT'; ?>
 		<i class="fa fa-times" aria-hidden="true" style="position: absolute;top: 5px; right: 10px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;
 		
 		<input type="hidden" id="stype" name="stype" value="<?php echo $_REQUEST['stype']; ?>">
 		<input type="hidden" id="hotelQuoteId" name="hotelQuoteId" value="<?php echo $_REQUEST['hotelQuoteId']; ?>">
 		<input type="radio" id="isHotelSupplement" <?php echo ($selectionType=='isHotelSupplement')?'checked':'';?>>
 		<input type="radio" id="isRoomSupplement" <?php echo ($selectionType=='isRoomSupplement')?'checked':'';?>>
 		<?php if($selectionType == 'isGuestType'){ ?>
 		<table border="0" cellpadding="0" cellspacing="0"> 
 			<tr style="background-color: #233a49;color: white;"> 
 				<td>
 					<?php 
					$QueryDaysQuery=GetPageRecord('srdate','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus=0 and deletestatus=0  order by srdate asc limit 1');
			        $QueryDaysData=mysqli_fetch_array($QueryDaysQuery);
					$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
					$earlyArrivalDate = date("Y-m-d", strtotime("-1 days", strtotime($dayDate)));
					$b1q2="";
					$b1q2=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationData['id'].'" and queryId="'.$quotationData['queryId'].'" and startDate="'.$earlyArrivalDate.'" and serviceId in ( select id from quotationHotelMaster where isHotelSupplement=0 ) and serviceType="hotel" ');

					if( mysqli_num_rows($b1q2) < 1  && $_REQUEST['day'] == 1 && $earlyCheckin == 1){  ?>
						<input type="checkbox" name="earlyCheckin" id="earlyCheckin" style="display:inline-block;">&nbsp;Guest Immediate Hotel
					<?php } ?>	
				</td> 
				<?php if(mysqli_num_rows($focQFE) > 0 || mysqli_num_rows($focQLE) > 0 ){ ?> 
 				<td>
 					<input type="checkbox" name="isGuestType" id="isGuestType" style="display:inline-block;"  <?php echo ($selectionType=='isGuestType')?'checked':'';?>>&nbsp;Guest Hotel
 				</td>
 				<?php }else{ ?> 
 				<input type="checkbox" id="isGuestType" checked>
 				<?php } ?>
 				<td>
 					<?php if(mysqli_num_rows($focQFE) > 0 ){ ?>
 						<input type="checkbox" checked="checked" name="isForeignEscort" id="isForeignEscort" style="display:inline-block;" >&nbsp;Foreign Escort
 					<?php } ?>
 				</td>
 				<td>
 					<?php if(mysqli_num_rows($focQLE) > 0){ ?>
 						<input type="checkbox" checked="checked" name="isLocalEscort" id="isLocalEscort" style="display:inline-block;" >&nbsp;Local Escort
 					<?php } ?>
 				</td>
 			</tr>
 		</table>
 		<?php } ?>

	</div>	
	 
	<div style="padding:10px;" id="hotelBox">
		<?php if($selectionType!='isRoomSupplement'){ ?>
		<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px;">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
		 		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
		  			<tbody>
						<tr style="background-color:transparent !important;">
						<td width="100" align="left"><div class="griddiv" style="position:static;">
						<label> <div class="HeadingBOL">Select&nbsp;Destination</div>
							<select id="destWise" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%;">
							<option value="1">Selected Destination</option>
							<option value="2">All Destinations</option>
							</select>
						</label>
						<script>
							  function getdestWise(){
								if($('#destWise').val()==2){
									$('#destinationId').load('loadAllDestinations.php');
								}

								if($('#destWise').val()==1){
									$('#destinationId').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
								}

							  }
							  </script>
							  <style>
								.select2-selection--single {
									display: inline-block !important;
									outline: 0px;
									padding-bottom: 0px;
									width: 100%;
									background-color: #FFFFFF !important;
									font-size: 14px;
									border: 1px #e0e0e0 solid !important;
									box-sizing: border-box !important;
									height: auto !important;
									padding: 2px;
									margin-top: 4px;
									border-radius: 2px !important;
								}
								.select2-container--default .select2-selection--single .select2-selection__arrow {
								top: 9px !important;
								}
							  </style>
						</div></td>
						  <td width="100" align="left"><div class="griddiv" style="position:static;">
								<label>
								<div class="HeadingBOL">Destination</div>
								<select id="destinationId" name="destinationId" class="gridfield validate select2" displayname="Select Destination" autocomplete="off" style="width: 100%; ">
								<?php
									$day=1;
									$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and  cityId="'.$dayData['cityId'].'"  group by cityId order by id asc');
									while($QueryDaysData=mysqli_fetch_array($a)){
								?>
								<option value="<?php echo stripslashes(trim($QueryDaysData['cityId'])); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
								<?php
								$day++;
								} ?>
								</select>
								</label>
								<script src="plugins/select2/select2.full.min.js"></script>
								<script>
								$(document).ready(function() {
								$('.select2').select2();
								});
								</script>
								 <style>
								.select2-container--open{
								z-index: 9999999999 !important;
								width: 100%;
								}

								.select2-container {
									box-sizing: border-box;
									display: inline-block;
									margin: 0;
									position: relative;
									vertical-align: middle;
									width: 100% !important;
								}
								  </style>
								</div></td>

								<!-- add new search field locality -->
								<td width="100" align="left">
									<div class="griddiv" style="position:static;"><label>
									<div style="width:100%;" class="HeadingBOL">Locality</div>
									<input name="locality" type="text" class="gridfield " id="locality" placeholder="Search Locality "  displayname="Hotel Name" value="<?php echo urldecode($_REQUEST['locality']); ?>" style="width: 112px;"/>
									</label>
									</div>
								</td> 



							<?php if($queryData['seasonType'] == 3 && $queryData['seasonType'] != 0){ ?>
							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div class="HeadingBOL">Season&nbsp;Type</div>
								<select id="seasonType" name="seasonType" class="gridfield validate" displayname="Season&nbsp;Type" autocomplete="off" >
								<option value="<?php echo $queryData['seasonType']; ?>" ><?php if($queryData['seasonType'] == 2){ ?>Winter<?php } elseif($queryData['seasonType'] == 1){ ?>Summer <?php } else { ?>Both<?php } ?></option>
								</select>
								</label>
								</div>							
							</td>
							<?php } ?>
							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div class="HeadingBOL">Star Rating</div>
								<select id="categoryId" name="categoryId" class="gridfield validate" displayname="Hotel Category" autocomplete="off"   >
								<?php if($quotationData['quotationType']==1 || $quotationData['quotationType']==0 || $quotationData['quotationType']==3){ ?>	
								<option value="">All</option>
								<?php
								$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'  deletestatus=0 and status=1  order by hotelCategory asc');
								while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
								?>
								<option value="<?php echo strip($hotelCategoryData['id']); ?>"  <?php if($hotelCategoryData['id']==$queryData['hotelAccommodation']){ ?>  selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']).' Star'; ?></option>
								<?php }}?>

								<?php 
								if($quotationData['quotationType']==2){
									$hotelCategory = explode(',', $quotationData['hotCategory']);
									foreach ($hotelCategory as $hotelcat) {
									
 										$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' deletestatus=0 and status=1 and id="'.$hotelcat.'" '); 
 										while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){ ?>
										<option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($hotelCategoryData['id']==$queryData['hotelAccommodation']){ ?>  selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']).' Star'; ?></option>
										<?php 
										} 
									}
								} ?>
								</select>
								</label>
								</div>							
							</td>

							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div class="HeadingBOL">Hotel Type</div>
								<select id="hotelTypeId" name="hotelTypeId" class="gridfield validate" displayname="Hotel Category" autocomplete="off"   >
								<?php if($quotationData['quotationType']==1 || $quotationData['quotationType']==0 || $quotationData['quotationType']==2){ ?>	
								<option value="">All</option>
								<?php
								$hotelCatQuery=GetPageRecord('*','hotelTypeMaster','  deletestatus=0 and status=1  order by id asc');
								while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
								?>
								<option value="<?php echo strip($hotelCategoryData['id']); ?>"  <?php if($hotelCategoryData['id']==$queryData['hotelAccommodation']){ ?>  selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['name']); ?></option>
								<?php }}?>

								<?php 
								if($quotationData['quotationType']==3){
									$hotelType = explode(',', $quotationData['hotelType']);
									foreach ($hotelType as $typeId) {
									
 										$hotelTypeQuery=GetPageRecord('*','hotelTypeMaster',' deletestatus=0 and status=1 and id="'.$typeId.'" '); 
 										$hotelTypeWiseData=mysqli_fetch_array($hotelTypeQuery); ?>
										<option value="<?php echo strip($hotelTypeWiseData['id']); ?>" ><?php echo strip($hotelTypeWiseData['name']); ?></option>
										<?php 
										
									}
								} ?>
								</select>
								</label>
								</div>							
							</td>


							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div class="HeadingBOL">Room Type </div>
								<select id="roomTypeId" name="roomTypeId" class="gridfield " displayname="Room Type" autocomplete="off"   >
								<option value="">All</option>
								<?php
								$roomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,' deletestatus=0 and status=1 order by id asc');
								while($roomTypeData=mysqli_fetch_array($roomTypeQuery)){
								?>
								<option value="<?php echo strip($roomTypeData['id']); ?>" ><?php echo strip($roomTypeData['name']); ?></option>
								<?php } ?>
								</select>
								</label>
								</div>							</td> 
							<td width="100" align="left" >
								<div class="griddiv" style="position:static;"><label>
								<div class="HeadingBOL">From</div>
								<select id="startDay" name="startDay" class="gridfield validate" displayname="Start Day" autocomplete="off"   >
								<?php
								$day=$day1;
								$starDayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and id >= "'.$dayData['id'].'"  order by srdate asc');
								while($startDaysData=mysqli_fetch_array($starDayQuery)){
									if(($cityId==$startDaysData['cityId'] && $startDaysData['id']!=$lastDayId) || $lastDayId==$dayData['id']){
									?>
									<option value="<?php echo strip($startDaysData['id']); ?>"  <?php if(strip($startDaysData['id']) == $_REQUEST['dayId']){ ?>  selected="selected" <?php } ?> >Night <?php echo $day; ?> - <?php echo getDestination($startDaysData['cityId']);?></option>
									<?php
									} else{
										break;
									}
									$day++;

								} ?>
								</select>
								</label>
						  </div>
						  </td>
						  <td width="100" align="left" >
							  	<div class="griddiv" style="position:static;">
							  	<label>
									<div class="HeadingBOL">To</div>
									<select id="endDay" name="endDay" class="gridfield validate" displayname="End Day" autocomplete="off"   >
									<?php
									$day=$day1;
									$endDayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0   and id >= "'.$dayData['id'].'" order by srdate asc');
									while($endDaysData=mysqli_fetch_array($endDayQuery)){
										if(($cityId==$endDaysData['cityId'] && $endDaysData['id']!=$lastDayId) || $lastDayId==$dayData['id']){
										?>
										<option value="<?php echo strip($endDaysData['id']); ?>"  <?php ///if(strip($endDaysData['id']) == $_REQUEST['dayId']){ ?>  selected="selected" <?php //} ?> >Night <?php echo $day; ?> - <?php echo getDestination($endDaysData['cityId']);?></option>
										<?php
										} else{
											break;
										}
 										$day++;
									}
									?>
								</select>
								</label>
						  </div>
						  </td> 
							<td width="100" align="left">
								<div class="griddiv" style="position:static;"><label>
								<div style="width:100%;" class="HeadingBOL">Hotel Name</div>
								<input name="hotelName" type="text" class="gridfield " id="hotelName" placeholder="Search Hotel "  displayname="Hotel Name" value="<?php echo urldecode($_REQUEST['hotelname']); ?>" />
								</label>
						  </div>							</td> 
							<td width="100" align="left">
									<div class="griddiv" style="position:static;"><label>
									<div class="HeadingBOL">Meal&nbsp;Type </div>
									<select id="mealPlan" name="mealPlan" class="gridfield validate" displayname="Restaurant" autocomplete="off"   >
									<option value="0">All</option>
									<?php
									$mealPlanQuery =GetPageRecord('name,id',_MEAL_PLAN_MASTER_,'name!="" and deletestatus=0 and status=1 order by id asc');
									while($mealPlanData=mysqli_fetch_array($mealPlanQuery)){
									?>
									<option value="<?php echo strip($mealPlanData['id']); ?>" <?php if($queryData['mealPlanId']==$mealPlanData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($mealPlanData['name']); ?></option>
									<?php } ?>
									</select>
									</label>
									</div>
							</td>
						  
						  
						  <td width="100" align="left" style="<?php //if($moduleType==2 || $moduleType==3 ){ ?>display:none;<?php //} ?>">
						
						  <div class="griddiv" >
							<label> <div class="HeadingBOL">Pax&nbsp;Type</div>
							<select id="tourType" name="tourType" class="gridfield" autocomplete="off" style="width: 100%;">
							<?php if($paxType==1){ ?><option value="2">GIT</option><?php }
							else{ ?><option value="1">FIT</option><?php } ?>
							</select>
							</label> 
								</div>
							</td>
						 

							

							<td width="100" align="left" valign="middle">
								<!-- comment this -->
								<!-- <input type="button" name="Submit" value="   Search   " class="bluembutton"    onclick="loadsearchhotelfunction();"> -->
								<input type="hidden" name="quotationId"  id="quotationId" value="<?php echo $quotationData['id']; ?>">
								<input type="hidden" name="queryId"  id="queryId" value="<?php echo $quotationData['queryId']; ?>">
								<input type="hidden" name="dayId"  id="dayId" value="<?php echo $_REQUEST['dayId']; ?>"> 

								<!-- add this  -->
								<button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="<?php echo $quotationData['id']; ?>" class="whitembutton searchBtn"  onclick="loadsearchhotelfunction();">
								<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
								</button>
							</td>
					  	</tr> 
					</tbody>
			  </table>
			</form>
		</div>
		<?php } ?>
		<div style="background-color:#feffbc;display:none;" id="loadhotelsavehotel" ></div>
	  	<div style="background-color:#f7f7f7;" id="loadhotelsearch" >&nbsp;</div>
		<script type="text/javascript">
			function addhoteltoquotations(cityId,roomTariffId,tblNum,supplementId){
				var isHotelSupplement = ($('#isHotelSupplement').prop('checked'))? 1 : 0;
				var isRoomSupplement = ($('#isRoomSupplement').prop('checked'))? 1 : 0;
				var isGuestType = ($('#isGuestType').prop('checked'))? 1 : 0;

		 		var stype = encodeURI($('#stype').val());
		 		var hotelQuoteId = encodeURI($('#hotelQuoteId').val());
				
				var isLocalEscort  =  $('#isLocalEscort').prop('checked') ? 1 : 0;
				var isForeignEscort=$('#isForeignEscort').prop('checked') ? 1 : 0; 
				var earlyCheckin   =   $('#earlyCheckin').prop('checked') ? 1 : 0; 
		 		
				var quotationId = $('#quotationId').val();
		 		var startDay = encodeURI($('#startDay').val());
				var endDay = encodeURI($('#endDay').val());
				
				if(isGuestType>0 || isLocalEscort>0 || isForeignEscort>0 || isRoomSupplement>0 ||  isHotelSupplement>0 || earlyCheckin>0){
	 				$('#loadhotelsavehotel').load('loadsavehotel.php?add=yes&quotationId='+quotationId+'&cityId='+cityId+'&startDayId='+startDay+'&isGuestType='+isGuestType+'&isLocalEscort='+isLocalEscort+'&isForeignEscort='+isForeignEscort+'&isHotelSupplement='+isHotelSupplement+'&isRoomSupplement='+isRoomSupplement+'&earlyCheckin='+earlyCheckin+'&endDayId='+endDay+'&roomTariffId='+roomTariffId+'&tblNum='+tblNum+'&stype='+stype+'&hotelQuoteId='+hotelQuoteId+'&supplementId='+supplementId);
				}else{
					alert('Please choose hotel Type.');
					
				}
			}

			function addhoteltoquotations_package(cityId,serviceId){
				var isHotelSupplement = ($('#isHotelSupplement').prop('checked'))? 1 : 0;
				var isRoomSupplement = ($('#isRoomSupplement').prop('checked'))? 1 : 0;
				var isGuestType = ($('#isGuestType').prop('checked'))? 1 : 0;

		 		var stype = encodeURI($('#stype').val());
		 		var hotelQuoteId = encodeURI($('#hotelQuoteId').val());
				
				var isLocalEscort  =  $('#isLocalEscort').prop('checked') ? 1 : 0;
				var isForeignEscort=$('#isForeignEscort').prop('checked') ? 1 : 0; 
				var earlyCheckin   =   $('#earlyCheckin').prop('checked') ? 1 : 0; 
		 		
				var quotationId = $('#quotationId').val();
		 		var startDay = encodeURI($('#startDay').val());
				var endDay = encodeURI($('#endDay').val());
				
				if(isGuestType>0 || isLocalEscort>0 || isForeignEscort>0 || isRoomSupplement>0 ||  isHotelSupplement>0 || earlyCheckin>0){
	 				$('#loadhotelsavehotel').load('loadsavehotel.php?add=yes&quotationId='+quotationId+'&cityId='+cityId+'&startDayId='+startDay+'&isGuestType='+isGuestType+'&isLocalEscort='+isLocalEscort+'&isForeignEscort='+isForeignEscort+'&isHotelSupplement='+isHotelSupplement+'&isRoomSupplement='+isRoomSupplement+'&earlyCheckin='+earlyCheckin+'&endDayId='+endDay+'&stype='+stype+'&hotelQuoteId='+hotelQuoteId+'&serviceId='+serviceId);
				}else{
					alert('Please choose hotel Type.');
					
				}
			}

			function loadsearchhotelfunction(added){
				
				var categoryId = encodeURI($('#categoryId').val());
				var roomTypeId = encodeURI($('#roomTypeId').val());
				var hotelTypeId = encodeURI($('#hotelTypeId').val());
				var mealPlan = encodeURI($('#mealPlan').val());
				var startDayId = encodeURI($('#startDay').val());
				var endDayId = encodeURI($('#endDay').val());
				var hotelName = encodeURI($('#hotelName').val());
				var locality = encodeURI($('#locality').val());

				var stype = encodeURI($('#stype').val());
				var hotelQuoteId = encodeURI($('#hotelQuoteId').val());
				
				var isHotelSupplement = ($('#isHotelSupplement').prop('checked'))? 1 : 0;
				var isRoomSupplement = ($('#isRoomSupplement').prop('checked'))? 1 : 0;
				var isGuestType = ($('#isGuestType').prop('checked'))? 1 : 0;
				
				var isLocalEscort  =  $('#isLocalEscort').prop('checked') ? 1 : 0;
				var isForeignEscort=$('#isForeignEscort').prop('checked') ? 1 : 0; 
				var earlyCheckin   =   $('#earlyCheckin').prop('checked') ? 1 : 0; 

 				var cityId = $('#destinationId').val();
				var destWise = $('#destWise').val();
				var quotationId = $('#quotationId').val();
				var queryId = $('#queryId').val();
				var dayId = $('#dayId').val(); 
				var tourType = $('#tourType').val();
				// alert(hotelName);
				$('#loadhotelsearch').load('loadhotelsearch.php?categoryId='+categoryId+'&cityId='+cityId+'&isGuestType='+isGuestType+'&isLocalEscort='+isLocalEscort+'&isForeignEscort='+isForeignEscort+'&roomTypeId='+roomTypeId+'&hotelTypeId='+hotelTypeId+'&startDayId='+startDayId+'&endDayId='+endDayId+'&Hotel='+hotelName+'&locality='+locality+'&mealPlan='+mealPlan+'&destWise='+destWise+'&quotationId='+quotationId+'&queryId='+queryId+'&dayId='+dayId+'&tourType='+tourType+'&isHotelSupplement='+isHotelSupplement+'&isRoomSupplement='+isRoomSupplement+'&earlyCheckin='+earlyCheckin+'&stype='+stype+'&hotelQuoteId='+hotelQuoteId);
			}
			<?php if($_REQUEST['hotelname']!='' || (isset($_REQUEST['hotelQuoteId']) && $_REQUEST['stype'] == 'roomSupplement')){ ?>
			loadsearchhotelfunction('');
			<?php } ?>
		</script>
	</div>

	<?php
} 

if($_REQUEST['action'] == 'addhoteldetails' && $_REQUEST['hotelId'] != ''){

	// hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$_REQUEST['hotelId'].'"');
	$hotelData=mysqli_fetch_array($d);


	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Hotel T&C </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#CCCCCC" class="hotelds " style="font-size: 15px;">
		  <tr>
       <td><strong style="text-decoration: underline;">Hotel Information</strong><br><br><?php echo $hotelData['hoteldetail']; ?></td> 
     </tr>
     <tr>
       <td><strong style="text-decoration: underline;">Policy</strong><br><br><?php echo $hotelData['policy']; ?></td>
     </tr>
     <tr>
	 <td><strong style="text-decoration: underline;">T&C</strong><br><br><a target="_blank" href="packageimages/<?php echo $hotelData['hotelImage']; ?>"><?php echo $hotelData['hotelImage']; ?></a>
		<br><br>
	   <p><?php echo $hotelData['termAndCondition']; ?></p>
		</td>
     </tr>
	  </table>
	
	
	</div>

<?php
}



// internal Note started 
if($_REQUEST['action'] == 'addhoteldetailsInternalNote' && $_REQUEST['hotelId'] != ''){

	// hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$_REQUEST['hotelId'].'"');
	$hotelData=mysqli_fetch_array($d);


	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Hotel Internal Note</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#CCCCCC" class="hotelds " style="font-size: 15px;">
		  <tr>
       <td><strong style="text-decoration: underline;">Internal Note</strong><br><br><?php echo $hotelData['hotelInternalNote']; ?></td> 
     </tr>
    
	  </table>
	
	
	</div>

<?php
}

// internal note Ended



// add room type information in quatation
if($_REQUEST['action'] == 'addroomdetails' && $_REQUEST['roomId'] != ''){

	// hotel data
	$d=GetPageRecord('*','roomTypeMaster',' id="'.$_REQUEST['roomId'].'"');
	$roomData=mysqli_fetch_array($d);


	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">ROOM INFO. </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
	
		<table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#CCCCCC" class="hotelds " style="font-size: 15px;">
			<tr>
				<th>Room Type Name</th>
				<th>Size</th>
				<th>Maximum Occupancy</th>
				<th>Bedding</th>
			</tr>
			<tr style="background: #f4f0f0;">
				<td><?php echo $roomData['name']; ?></td>
				<td><?php echo $roomData['size']; ?></td>
				<td><?php echo $roomData['maxoccupancy']; ?></td>
				<td><?php echo $roomData['bedding']; ?></td>
			</tr>

	  </table>
	</div>

<?php
}

 
if($_REQUEST['action'] == 'addServiceEarlyHotel' && $_REQUEST['dayId']!=''){


	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];
	//for day serial
	$day1 = 1;
	$dayQuery1=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'"  and addstatus=0  order by id asc');
	while($dayData1 = mysqli_fetch_array($dayQuery1)){
	if(strip($dayData1['id']) == $_REQUEST['dayId']){ break ; }
	$day1++;
	}
	//echo $day1;
	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);
 
	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);
	$tourType = $queryData['queryType'];

	?>

 	<div style="display: grid;background-color: #ffffff;color: #233a49;" class="inboundheader"> Select&nbsp;Hotel for Immediate Occupancy <?php if($queryData['dayWise']==1){ echo "&nbsp;|&nbsp;".date('D j M Y', strtotime($dayData['srdate'])); } ?> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px;">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
		 		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
		  			<tbody>
						<tr style="background-color:transparent !important;">
						  <td width="100" align="left"><div class="griddiv" style="position:static;">
						<label> <div>Selected&nbsp;Destination</div>
							<select id="destWise" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
							<option value="1">Selected Destination</option>
							<option value="2">All Destinations</option>
							</select>
						</label>
						<script>
							  function getdestWise(){
								if($('#destWise').val()==2){
									$('#destinationId').load('loadAllDestinations.php');
								}

								if($('#destWise').val()==1){
									$('#destinationId').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
								}

							  }
							  </script>
						</div></td>
						  <td width="100" align="left"><div class="griddiv" style="position:static;">
								<label>
								<div>Destination</div>
								<select id="destinationId" name="destinationId" class="gridfield validate select2" displayname="Select Destination" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
								<?php
									$day=1;
									echo ' quotationId="'.$quotationData['id'].'"  and addstatus=0  and  cityId="'.$dayData['cityId'].'"  group by cityId order by id asc';
									$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and  cityId="'.$dayData['cityId'].'"  group by cityId order by id asc');
									while($QueryDaysData=mysqli_fetch_array($a)){
								?>
								<option value="<?php echo stripslashes(trim($QueryDaysData['cityId'])); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
								<?php
								$day++;
								} ?>
								</select>
								</label>
								<script src="plugins/select2/select2.full.min.js"></script>
								<script>
								$(document).ready(function() {
								$('.select2').select2();
								});
								</script>
								<style>
									.select2-selection--single {
										display: inline-block !important;
										outline: 0px;
										padding-bottom: 0px;
										width: 100%;
										background-color: #FFFFFF !important;
										font-size: 14px;
										border: 1px #e0e0e0 solid !important;
										box-sizing: border-box !important;
										height: auto !important;
										padding: 2px;
										margin-top: 4px;
										border-radius: 2px !important;
									}
									.select2-container--default .select2-selection--single .select2-selection__arrow {
										top: 9px !important;
									} 
									.select2-container--open{
										z-index: 9999999999 !important;
										width: 100%;
									} 
									.select2-container {
										box-sizing: border-box;
										display: inline-block;
										margin: 0;
										position: relative;
										vertical-align: middle;
										width: 100% !important;
									}
								  </style>
								</div></td>
							<?php if($queryData['queryType'] == 3 && $queryData['seasonType'] != 0){ ?>
							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div>Season&nbsp;Type</div>
								<select id="seasonType" name="seasonType" class="gridfield validate" displayname="Season&nbsp;Type" autocomplete="off" >
								<option value="<?php echo $queryData['seasonType']; ?>" ><?php if($queryData['seasonType'] == 2){ ?>Winter<?php } elseif($queryData['seasonType'] == 1){ ?>Summer <?php } else { ?>Both<?php } ?></option>
								</select>
								</label>
								</div>							</td>
							<?php } ?>
							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div>Star Rating </div>
								<select id="categoryId" name="categoryId" class="gridfield validate" displayname="Hotel Category" autocomplete="off"   >
								<?php if($quotationData['quotationType']==1){ ?>	
								<option value="">All</option>
								<?php
								$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'  deletestatus=0 and status=1 order by hotelCategory asc');
								while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
								?>
								<option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($hotelCategoryData['id']==$queryData['hotelAccommodation']){ ?>  selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']).' Star'; ?></option>
								<?php } }?>

								<?php 
								if($quotationData['quotationType']==2){
									$hotelCategory = explode(',', $quotationData['hotCategory']);
									foreach ($hotelCategory as $hotelcat) {
 										$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'deletestatus=0 and status=1 and id="'.$hotelcat.'" ');
										while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){ ?>
										<option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($hotelCategoryData['id']==$queryData['hotelAccommodation']){ ?>  selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']).' Star'; ?></option>
									<?php } } } ?>
								</select>
								</label>
								</div>							
							</td>
							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div>Hotel Type </div>
								<select id="hotelTypeId" name="hotelTypeId" class="gridfield" displayname="Hotel Type" autocomplete="off"   >
								<option value="">All</option>
								<?php
								$hotelTypeQuery=GetPageRecord('*','hotelTypeMaster',' 1 and deletestatus=0 and status=1 order by name asc ');
								while($hotelTypeData=mysqli_fetch_array($hotelTypeQuery)){
								?>
								<option value="<?php echo strip($hotelTypeData['id']); ?>" ><?php echo strip($hotelTypeData['name']); ?></option>
								<?php } ?>
								</select>
								</label>
								</div>							
							</td>
							<td width="100" align="left">
								<div class="griddiv" style="position:static;">
								<label>
								<div>Room Type </div>
								<select id="roomType" name="roomType" class="gridfield validate" displayname="Room Type" autocomplete="off"   >
								<option value="">All</option>
								<?php
								$roomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,' deletestatus=0 and status=1 order by id asc');
								while($roomTypeData=mysqli_fetch_array($roomTypeQuery)){
								?>
								<option value="<?php echo strip($roomTypeData['id']); ?>" ><?php echo strip($roomTypeData['name']); ?></option>
								<?php } ?>
								</select>
								</label>
								</div>							</td>
							<td width="100" align="left">
								<div class="griddiv" style="position:static;"><label>
								<div>Meal&nbsp;Type</div>
								<select id="mealPlan" name="mealPlan" class="gridfield validate" displayname="Restaurant" autocomplete="off"   >
								<option value="0">All</option>
								<?php
								$mealPlanQuery =GetPageRecord('name,id',_MEAL_PLAN_MASTER_,'1 and deletestatus=0');
								while($mealPlanData=mysqli_fetch_array($mealPlanQuery)){
								?>
								<option value="<?php echo strip($mealPlanData['id']); ?>" <?php if($queryData['mealPlanId']==$mealPlanData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($mealPlanData['name']); ?></option>
								<?php } ?>
								</select>
								</label>
								</div>
						  </td> 
						  <td width="100" align="left"><div class="griddiv" style="position:static;">
							<label> <div>Pax&nbsp;Type</div>
							<select id="tourType" name="tourType" class="gridfield" autocomplete="off" style="width: 100%;">
							<?php if($tourType==2){ ?><option value="1">FIT</option><?php } ?>
							<?php if($tourType==1){ ?><option value="2">GIT</option><?php } ?>
							</select>
							</label> 
							</div>
						</td>
						
						  <td width="100" align="left" >
								<div class="griddiv" style="position:static;">
							  	<label>
								<div>Check&nbsp;In&nbsp;</div>
								<input id="checkIn" name="checkIn" type="text" class="gridfield validate timepicker2"  data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"/>
 								</label>
								</div>
							</td>

							<td width="100" align="left">
								<div class="griddiv" style="position:static;"><label>
								<div style="width:100%;">Hotel Name</div>
								<input name="hotelName" type="text" class="gridfield" id="hotelName" placeholder="Search Hotel "  displayname="Hotel Name" value="<?php echo urldecode($_REQUEST['hotelname']); ?>" />
								</label>
						  </div>							</td>
							<td width="100" align="left" valign="middle">
						  <input type="button" name="Submit" value="   Search   " class="bluembutton"    onclick="loadsearchhotelfunction();">
						  </td>
					  </tr>
					</tbody>
			  </table>
			</form>
		</div>
		<div style="background-color:#feffbc;display:none;" id="loadhotelsavehotel" ></div>
	  	<div style="background-color:#f7f7f7;" id="loadhotelsearch" >&nbsp;</div>
		<script type="text/javascript" src="js/jquery.timepicker.js"></script> 
		<script type="text/javascript"> 
			$(document).ready(function(){
				$('.timepicker2').timepicker();	
			});   
			function addhoteltoquotations(cityId,roomTariffId,tblNum,supplementId){
 				var startDay = encodeURI(<?php echo $_REQUEST['dayId']; ?>);
				var endDay = encodeURI(<?php echo $_REQUEST['dayId']; ?>);
 				$('#loadhotelsavehotel').load('loadsavehotel.php?add=yes&earlyCheckin=1&cityId='+cityId+'&startDayId='+startDay+'&endDayId='+endDay+'&roomTariffId='+roomTariffId+'&tblNum='+tblNum+'&supplementId='+supplementId);
			}
			function loadsearchhotelfunction(added){
				var categoryId = encodeURI($('#categoryId').val());
				var roomType = encodeURI($('#roomType').val());
				var hotelTypeId = encodeURI($('#hotelTypeId').val());
				var mealPlan = encodeURI($('#mealPlan').val());
				var startDayId = encodeURI(<?php echo $_REQUEST['dayId']; ?>);
				var endDayId = encodeURI(<?php echo $_REQUEST['dayId']; ?>);
				var hotelName = encodeURI($('#hotelName').val());
 				var destinationId = $('#destinationId').val();
				var destWise = $('#destWise').val();
				var tourType = $('#tourType').val();
				
				$('#loadhotelsearch').load('loadhotelsearch.php?categoryId='+categoryId+'&earlyCheckin=1&hotelTypeId='+hotelTypeId+'&roomType='+roomType+'&startDayId='+startDayId+'&endDayId='+endDayId+'&Hotel='+hotelName+'&mealPlan='+mealPlan+'&destWise='+destWise+'&tourType='+tourType);
			 
			}

			<?php if($_REQUEST['hotelname']!=''){ ?>
			loadsearchhotelfunction('');
			<?php } ?>
		</script>
	</div>

	<?php
}

if($_REQUEST['action'] == 'addQuotationHotelSupplement' && $_REQUEST['dayId']!=''){

		$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
		$dayData = mysqli_fetch_array($dayQuery);
		$cityId = $dayData['cityId'];
		//for day serial
		$day1 = 1;
		$dayQuery1=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'"  and addstatus=0  order by id asc');
		while($dayData1 = mysqli_fetch_array($dayQuery1)){
			if(strip($dayData1['id']) == $_REQUEST['dayId']){ break ; }
			$day1++;
		}
		//echo $day1;
		//quotation data
		$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
		$quotationData=mysqli_fetch_array($quotQuery);
		 
		//Query data
		$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
		$queryData=mysqli_fetch_array($queQuery);

	?>

	 	<div class="inboundheader" >Select&nbsp;Supplement&nbsp;Hotel&nbsp;|&nbsp;<?php if($queryData['dayWise']==1){ echo date('D j M Y', strtotime($dayData['srdate'])); }?> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i></div>
		<div style="padding:10px;" id="hotelBox">
			<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px;">
				<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
			 		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
			  			<tbody>
							<tr style="background-color:transparent !important;">
							  <td width="100" align="left"><div class="griddiv" style="position:static;">
							<label> <div>Selected&nbsp;Destination</div>
								<select id="destWise" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
								<option value="1">Selected Destination</option>
								<option value="2">All Destinations</option>
								</select>
							</label>
							<script>
						  function getdestWise(){
							if($('#destWise').val()==2){
								$('#destinationId').load('loadAllDestinations.php');
							}

							if($('#destWise').val()==1){
								$('#destinationId').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
							}

						  }
						  </script>
				    </div></td>
							  <td width="100" align="left"><div class="griddiv" style="position:static;">
									<label>
									<div>Destination</div>
									<select id="destinationId" name="destinationId" class="gridfield validate select2" displayname="Select Destination" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
									<?php
										$day=1;
										$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and  cityId="'.$dayData['cityId'].'"  group by cityId order by id asc');
										while($QueryDaysData=mysqli_fetch_array($a)){
									?>
									<option value="<?php echo stripslashes(trim($QueryDaysData['cityId'])); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
									<?php
									$day++;
									} ?>
									</select>
									</label>
									<script src="plugins/select2/select2.full.min.js"></script>
									<script>
									$(document).ready(function() {
									$('.select2').select2();
									});
									</script>
									 <style>
									.select2-container--open{
									z-index: 9999999999 !important;
									width: 100%;
									}

									.select2-container {
									    box-sizing: border-box;
									    display: inline-block;
									    margin: 0;
									    position: relative;
									    vertical-align: middle;
									    width: 100% !important;
									}
									  </style>
									</div></td>
								<?php if($queryData['queryType'] == 3 && $queryData['seasonType'] != 0){ ?>
								<td width="100" align="left">
									<div class="griddiv" style="position:static;">
									<label>
									<div>Season&nbsp;Type</div>
									<select id="seasonType" name="seasonType" class="gridfield validate" displayname="Season&nbsp;Type" autocomplete="off" >
									<option value="<?php echo $queryData['seasonType']; ?>" ><?php if($queryData['seasonType'] == 2){ ?>Winter<?php } elseif($queryData['seasonType'] == 1){ ?>Summer <?php } else { ?>Both<?php } ?></option>
									</select>
									</label>
									</div>							</td>
								<?php } ?>
								<td width="100" align="left">
									<div class="griddiv" style="position:static;">
									<label>
									<div>Star Rating </div>
									<select id="categoryId" name="categoryId" class="gridfield validate" displayname="Hotel Category" autocomplete="off"   >
									<?php if($quotationData['quotationType']==1){ ?>	
									<option value="">All</option>
									<?php
									$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'  deletestatus=0 and status=1  order by hotelCategory asc');
									while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
									?>
									<option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($hotelCategoryData['id']==$queryData['hotelAccommodation']){ ?>  selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']).' Star'; ?></option>
									<?php }}?>

									<?php if($quotationData['quotationType']==2){
										$hotelCategory = explode(',', $quotationData['hotCategory']);
										foreach ($hotelCategory as $hotelcat) {
	 										$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'deletestatus=0 and status=1 and id="'.$hotelcat.'"  ');
											while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){ ?>
											<option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($hotelCategoryData['id']==$queryData['hotelAccommodation']){ ?>  selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']).' Star'; ?></option>
										<?php } }} ?>
									</select>
									</label>
									</div>							
								</td>
								<td width="100" align="left">
									<div class="griddiv" style="position:static;">
									<label>
									<div>Hotel Type </div>
									<select id="hotelTypeId" name="hotelTypeId" class="gridfield" displayname="Hotel Type" autocomplete="off"   >
									<option value="">All</option>
									<?php
									$hotelTypeQuery=GetPageRecord('*','hotelTypeMaster',' 1 and deletestatus=0 and status=1 order by name asc ');
									while($hotelTypeData=mysqli_fetch_array($hotelTypeQuery)){
									?>
									<option value="<?php echo strip($hotelTypeData['id']); ?>" ><?php echo strip($hotelTypeData['name']); ?></option>
									<?php } ?>
									</select>
									</label>
									</div>							
								</td>
								<td width="100" align="left">
									<div class="griddiv" style="position:static;">
									<label>
									<div>Room Type </div>
									<select id="roomType" name="roomType" class="gridfield validate" displayname="Room Type" autocomplete="off"   >
									<option value="">All</option>
									<?php
									$roomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,' deletestatus=0 and status=1 order by id asc');
									while($roomTypeData=mysqli_fetch_array($roomTypeQuery)){
									?>
									<option value="<?php echo strip($roomTypeData['id']); ?>" ><?php echo strip($roomTypeData['name']); ?></option>
									<?php } ?>
									</select>
									</label>
									</div>							
								</td>
								<td width="100" align="left">
									<div class="griddiv" style="position:static;"><label>
									<div>Meal&nbsp;Type </div>
									<select id="mealPlan" name="mealPlan" class="gridfield validate" displayname="Restaurant" autocomplete="off"   >
									<option value="0">All</option>
									<?php
									$mealPlanQuery =GetPageRecord('name,id',_MEAL_PLAN_MASTER_,'1 and deletestatus=0');
									while($mealPlanData=mysqli_fetch_array($mealPlanQuery)){
									?>
									<option value="<?php echo strip($mealPlanData['id']); ?>" <?php if($queryData['mealPlanId']==$mealPlanData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($mealPlanData['name']); ?></option>
									<?php } ?>
									</select>
									</label>
									</div>
									</td>
								<td width="100" align="left" >
									<div class="griddiv" style="position:static;"><label>
									<div>From</div>
									<select id="startDay" name="startDay" class="gridfield validate" displayname="Start Day" autocomplete="off"   >
									<?php
									$day=$day1;
									$starDayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0 and id >= "'.$dayData['id'].'"  order by srdate asc');
									while($QueryDaysData=mysqli_fetch_array($starDayQuery)){
										if($cityId==$QueryDaysData['cityId']){
										?>
										<option value="<?php echo strip($QueryDaysData['id']); ?>"  <?php if(strip($QueryDaysData['id']) == $_REQUEST['dayId']){ ?>  selected="selected" <?php } ?> >Night <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
										<?php
										} else{
											break;
										}
										$day++;

									} ?>
									</select>
									</label>
							  </div>
							  </td>
							  <td width="100" align="left" >
								  	<div class="griddiv" style="position:static;">
								  	<label>
										<div>To</div>
										<select id="endDay" name="endDay" class="gridfield validate" displayname="End Day" autocomplete="off"   >
										<?php
										$day=$day1;
										$starDayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0   and id >= "'.$dayData['id'].'" order by srdate asc');
										while($QueryDaysData=mysqli_fetch_array($starDayQuery)){
											if($cityId==$QueryDaysData['cityId']){
											?>
											<option value="<?php echo strip($QueryDaysData['id']); ?>"  <?php ///if(strip($QueryDaysData['id']) == $_REQUEST['dayId']){ ?>  selected="selected" <?php //} ?> >Night <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
											<?php
											} else{
												break;
											}
	 										$day++;
										}
										?>
									</select>
									</label>
							  </div>
							  </td>

								<td width="100" align="left">
									<div class="griddiv" style="position:static;"><label>
									<div style="width:100%;">Hotel Name</div>
									<input name="hotelName" type="text" class="gridfield " id="hotelName" placeholder="Search Hotel "  displayname="Hotel Name" value="<?php echo urldecode($_REQUEST['hotelname']); ?>" />
									</label>
							  </div>
							  </td>
							<td width="100" align="left" valign="middle">
							<input name="hotelQuoteId" type="hidden" id="hotelQuoteId" value="<?php echo  $_REQUEST['hotelQuoteId']; ?>">
							<input type="button" name="Submit" value="   Search   " class="bluembutton"    onclick="loadsearchhotelfunction();">							</td>
						  </tr>
						</tbody>
				  </table>
				</form>
			</div>

			<div style="background-color:#feffbc;display:none;" id="loadhotelsavehotel" ></div>
		  	<div style="background-color:#f7f7f7;" id="loadhotelsearch" >&nbsp;</div>
			<script type="text/javascript">
				function addSupplementhotel(cityId,roomTariffId,tblNum,supplementId){
	 				var startDay = encodeURI($('#startDay').val());
					var endDay = encodeURI($('#endDay').val());
	 				$('#loadhotelsavehotel').load('loadsaveSupplimenthotel.php?add=yes&cityId='+cityId+'&startDayId='+startDay+'&endDayId='+endDay+'&roomTariffId='+roomTariffId+'&tblNum='+tblNum+'&supplementId='+supplementId);
				}
				function loadsearchhotelfunction(added){
					var categoryId = encodeURI($('#categoryId').val());
					var roomType = encodeURI($('#roomType').val());
					var hotelTypeId = encodeURI($('#hotelTypeId').val());
					var mealPlan = encodeURI($('#mealPlan').val());
					var startDayId = encodeURI($('#startDay').val());
					var endDayId = encodeURI($('#endDay').val());
					var hotelName = encodeURI($('#hotelName').val());
	 				var destinationId = $('#destinationId').val();
					var destWise = $('#destWise').val();

					$('#loadhotelsearch').load('loadsupplimenthotelsearch.php?categoryId='+categoryId+'&roomType='+roomType+'&hotelTypeId='+hotelTypeId+'&startDayId='+startDayId+'&endDayId='+endDayId+'&Hotel='+hotelName+'&mealPlan='+mealPlan+'&destWise='+destWise);
				}

				<?php if($_REQUEST['hotelname']!=''){ ?>
				loadsearchhotelfunction('');
				<?php } ?>
			</script>

		</div>

		<?php
	}

if($_REQUEST['action'] == 'addRoomSupplement' && $_REQUEST['dayId'] != '' && $_REQUEST['hotelQuoteId'] != ''){

	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);
	// hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
	$hotelData=mysqli_fetch_array($d);


	?>
	<div class="inboundheader">
		<span id="hotelcounding">Add Room Supplement </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #ffffff; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#CCCCCC" class="hotelds " style="font-size: 15px;color: #589fa6;">
		<thead>
		<tr>
		<td  > <strong>Hotel&nbsp;Name:&nbsp;</strong><?php echo strip($hotelData['hotelName']);  ?></td>

		<td  ><strong>Category:&nbsp;</strong><?php
			$rs231=GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
			$hotelCatNam=mysqli_fetch_array($rs231);
			echo $hotelCatNam['hotelCategory'].'Star'; ?></td>

		<td ><strong>City:&nbsp;</strong><?php echo strip($hotelData['hotelCity']);  ?></td>

		<td  align="right"><span class="editbtnselect" onclick="addnewRates('<?php echo $hotelData['id']; ?>','0');" style=" padding: 6px 23px !important; background-color:#589fa6;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add&nbsp;Price</span>

		</td>
		</tr>
		</thead>
	  </table>
		<div style="background-color:#feffbc;display:none;" id="loadhotelsavehotel2" ></div>
	  	<div style="background-color:#f7f7f7;" id="loadhotelsearch2" >&nbsp;</div>
		<script type="text/javascript">
			// function addSupplementRoom(quotationId,roomTariffId,tblNum,supplementId){
			// 	//confirm('Click "OK" to Add');
			// 	$('#loadhotelsavehotel2').load('loadsave_Suppliment.php?action=add_RoomSupplement&dayId=<?php echo $_REQUEST['dayId']; ?>&hotelQuoteId=<?php echo $_REQUEST['hotelQuoteId']; ?>&quotationId='+quotationId+'&roomTariffId='+roomTariffId+'&tblNum='+tblNum+'&supplementId='+supplementId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
			// }
			function addhoteltoquotations(cityId,roomTariffId,tblNum,supplementId){
				if(roomTariffId>0){
	 				$('#loadhotelsavehotel').load('loadsavehotel.php?add=yes&action=saveRoomSupplement&cityId='+cityId+'&hotelQuoteId=<?php echo $_REQUEST['hotelQuoteId']; ?>&roomTariffId='+roomTariffId+'&tblNum='+tblNum+'&supplementId='+supplementId);
					selectthis(roomTariffId)
				}else{
					alert('Please select a valid rate.');
					
				}
			}

			function loadSearchSupplementRoom(hotelQuoteId){
				$('#loadhotelsearch2').load('loadhotelsearch.php?action=searchRoomSupplement&hotelQuoteId='+hotelQuoteId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
			}
			loadSearchSupplementRoom('<?php echo $_REQUEST['hotelQuoteId']; ?>');

			function selectthisH(ele){
				$(ele).html('Selected');
				$(ele).removeAttr('onclick');
				$(ele).css('background-color','#d88319');
			}
		</script>
	</div>

<?php
}

if($_REQUEST['action'] == 'selectAdultChildMeal' && $_REQUEST['dayId'] != '' && $_REQUEST['hotelQuoteId'] != '' && $_REQUEST['roomTariffId']!=''){

	$quotationId = $_REQUEST['quotationId'];
	$hotelQuoteId = $_REQUEST['hotelQuoteId'];

	$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" order by id desc');
	$quotationData = mysqli_fetch_assoc($rs1);

	$rs2=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and id="'.$hotelQuoteId.'" order by id desc');
	$hotelQuotData = mysqli_fetch_assoc($rs2);

	?>
	<div class="mealClass"><h4 style="display: inline-block;">Select Meal</h4><span class="closeBTN" onclick="closeinbound();"><i class="fa fa-times"></i></span></div>
	<div class="mainDiv">
		<div style="padding-bottom: 15px;">
		<div class="lunchdinner addBtnMeal"  ><input type="checkbox" id="lunch" style="display: block;" value="1" <?php if($hotelQuotData['complimentaryLunch']==1){ ?> checked="checked" <?php } ?> />Adult Lunch</div>

		<div class="lunchdinner addBtnMeal" ><input type="checkbox" id="dinner" style="display: block;" value="1" <?php if($hotelQuotData['complimentaryDinner']==1){ ?> checked="checked" <?php } ?> />Adult Dinner</div>

		<div class="lunchdinner addBtnMeal"  ><input type="checkbox" id="breakfastA" style="display: block;" value="1" <?php if($hotelQuotData['complimentaryBreakfast']==1){ ?> checked="checked" <?php } ?> />Adult Breakfast</div>
		</div>
		<div>
		<div class="lunchdinner addBtnMeal"  ><input type="checkbox" id="childLunch" style="display: block;" value="1" <?php if($hotelQuotData['isChildLunch']==1){ ?> checked="checked" <?php } ?> />Child Lunch</div>

		<div class="lunchdinner addBtnMeal"  ><input type="checkbox" id="childDinner" style="display: block;" value="1" <?php if($hotelQuotData['isChildDinner']==1){ ?> checked="checked" <?php } ?> />Child Dinner</div>

		<div class="lunchdinner addBtnMeal"  ><input type="checkbox" id="childBreakfast" style="display: block;" value="1" <?php if($hotelQuotData['isChildBreakfast']==1){ ?> checked="checked" <?php } ?> />Child Breakfast</div>
		</div>
		<div id="savelunchdinner" style="display:none;"></div>
	<script>
	$("#lunch").click(function(){
		if($(this).is(":checked")) {
			var lunch = 1;
		}else{
			var lunch = 0;
		}
		$('#savelunchdinner').load('frmaction.php?action=savelunchHotel&quotationId=<?php echo ($quotationData['id']); ?>&supplierId=<?php echo ($hotelQuotData['supplierId']); ?>&lunch='+lunch+'&lunchquoteId=<?php echo ($hotelQuotData['id']); ?>');
	});

	$("#dinner").click(function(){
		if($(this).is(":checked")) {
			var dinner = 1;
		}else{
			var dinner = 0;
		}
		$('#savelunchdinner').load('frmaction.php?action=savedinnerHotel&quotationId=<?php echo ($quotationData['id']); ?>&supplierId=<?php echo ($hotelQuotData['supplierId']); ?>&dinner='+dinner+'&dinnerquoteId=<?php echo ($hotelQuotData['id']); ?>');
	});

	// BreakFast
	$("#breakfastA").click(function(){
		if($(this).is(":checked")) {
			var breakfast = 1;
		}else{
			var breakfast = 0;
		}
		
		$('#savelunchdinner').load('frmaction.php?action=saveBreakfastHotel&quotationId=<?php echo ($quotationData['id']); ?>&supplierId=<?php echo ($hotelQuotData['supplierId']); ?>&breakfast='+breakfast+'&breakfastquotId=<?php echo ($hotelQuotData['id']); ?>');
	});

	$("#childLunch").click(function(){
		if($(this).is(":checked")) {
			var childLunch = 1;
		}else{
			var childLunch = 0;
		}
		$('#savelunchdinner').load('frmaction.php?action=saveChildLunchHotel&quotationId=<?php echo ($quotationData['id']); ?>&supplierId=<?php echo ($hotelQuotData['supplierId']); ?>&childlunch='+childLunch+'&childLunchquotId=<?php echo ($hotelQuotData['id']); ?>');
	});

	$("#childDinner").click(function(){
		if($(this).is(":checked")) {
			var childDinner = 1;
		}else{
			var childDinner = 0;
		}
		$('#savelunchdinner').load('frmaction.php?action=saveChildDinnerHotel&quotationId=<?php echo ($quotationData['id']); ?>&supplierId=<?php echo ($hotelQuotData['supplierId']); ?>&childdinner='+childDinner+'&childDinnerquotId=<?php echo ($hotelQuotData['id']); ?>');
	});

	$("#childBreakfast").click(function(){
		if($(this).is(":checked")) {
			var childBreakfast = 1;
		}else{
			var childBreakfast = 0;
		}
		$('#savelunchdinner').load('frmaction.php?action=saveChildBreakfastHotel&quotationId=<?php echo ($quotationData['id']); ?>&supplierId=<?php echo ($hotelQuotData['supplierId']); ?>&childbreakfast='+childBreakfast+'&childBreakfastquotId=<?php echo ($hotelQuotData['id']); ?>');
	});

	</script>
	
		<div id="savelunchdinner" style="display:none;"></div>
	</div>
	<style>
		.mealClass{
		background-color: #233a49 !important;
    	color: #fff;
    	padding: 10px;
    	font-size: 16px;
		border-radius: 3px;
		}
		.closeBTN{
			float: right;
    	font-weight: 600;
    	cursor: pointer;
    	width: 18px;
    	text-align: center;
		}
		.addBtnMeal{
			width: fit-content !important;
			padding: 8px 12px !important;
			background-color: #e7e7e7;
			box-shadow: -2px 3px 4px -3px black;
		}
		.mainDiv{
			margin-top: 20px;
    		margin-bottom: 20px;
		}
	</style>
<?php
}
 
if($_REQUEST['action'] == 'addHotelAdditionalService' && $_REQUEST['dayId'] != '' && $_REQUEST['hotelQuoteId'] != '' && $_REQUEST['roomTariffId']!=''){
		// Hotel Additional Start From Hotel 
		// quotation hotel data
		$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"');
		$hotelQuotData=mysqli_fetch_array($c);
		// hotel data
		$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
		$hotelData=mysqli_fetch_array($d);
		?>
		<div class="inboundheader">
			<span id="hotelcounding">Add Hotel Additional </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #ffffff; cursor:pointer; " onclick="closeinbound();"></i>
		</div>
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<table>
			<thead>
				<!--  and isQuoteRate=0 -->
			<tr>
			<th>
				<div class="griddiv" style="margin-left: 20px;"><label>
				<div class="gridlable" style="text-align: left;font-weight: 400;padding: 8px 0px;">Hotel Additional</div>
				<select name="additionalRateId" id="additionalRateId" onchange="getHotelAdditionalCost();" class="gridfield"  >
					<option value="">Select Hotel Additional</option>
					<?php 
					$hadditionaln = GetPageRecord('*','dmcAdditionalHotelRate','rateId="'.$_REQUEST['roomTariffId'].'" and isQuoteRate=0');
					if(mysqli_num_rows($hadditionaln)>0){

						$isRateId = 1;
						while($addhoname = mysqli_fetch_assoc($hadditionaln)){
							$hnameres = GetPageRecord('*','additionalHotelMaster','id="'.$addhoname['additionalName'].'" and status=1 and deletestatus=0');
							$gerahname = mysqli_fetch_assoc($hnameres );
							?>
							<option value="<?php echo $addhoname['id']; ?>"> <?php echo $gerahname['name']; ?> </option>
							<?php
						}

					}else{

						$isRateId = 0;
						$rs='';  
						$hotelAdditionalArray = explode(',',rtrim($hotelData['hotelAdditional'],','));
						foreach($hotelAdditionalArray as $roomArray){
							$rs=GetPageRecord('*','additionalHotelMaster','id="'.$roomArray.'"'); 
							if(mysqli_num_rows($rs)>0){
								$additinalres=mysqli_fetch_array($rs);	
								?>
								<option value="<?php echo strip($additinalres['id']); ?>" ><?php echo strip($additinalres['name']); ?></option>
								<?php 
							} 
						} 
					}
					?>
				</select>
				<input type="hidden" name="isRateId" id="isRateId" value="<?php echo $isRateId; ?>"   >
				</label>
				</div>
			</th>  
			<th style="padding-left: 6px;">
				<div class="griddiv"><label>
					<div class="gridlable" style="text-align: left;font-weight: 400;padding: 8px 0px;">Cost Type</div>
					<select name="costType" id="costType" value="<?php ?>" class="gridfield" >
						<option value="1">Per Pax Cost</option>
						<option value="2">Group Cost</option>
					</select>
					</label>
				</div>
			</th>
			<th style="padding-left: 6px;">
				<div class="griddiv"><label>
					<div class="gridlable" style="text-align: left;font-weight: 400;padding: 8px 0px;">GST SLAB</div>
					<select id="HAGST" name="HAGST" class="gridfield" displayname="Additional GST" autocomplete="off" style="width: 100%;">
						<?php
						$rs2 = "";												
						$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and serviceType="Restaurant" and status=1 order by gstSlabName asc');
						while ($gstSlabData = mysqli_fetch_array($rs2)) {
						?>
							<option value="<?php echo $gstSlabData['id']; ?>"><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
						<?php
						}
						?>
					</select>
					</label>
				</div>
			</th>
			<th style="padding-left: 6px;">
				<div class="griddiv"><label>
					<div class="gridlable" style="text-align:left; font-weight: 400; padding: 8px 0px;">Cost</div>
					<input type="text" name="additionalcost" id="additionalcost" value="<?php ?>" class="gridfield" >
					</label>
				</div>
			</th>
			<th>
				<input type="button" value="Save" onclick="savehoteladditionalcost();" class="whitembutton" style="margin-top: 25px;border-radius: 3px;background-color: #233a49;color: #fff;font-size: 14px;" /> 
				<input type="hidden" name="hotelQuoteId111" id="hotelQuoteId111" value="<?php echo $_REQUEST['hotelQuoteId']; ?>">

			</th>
			<th><input type="button" value="+ ADD NEW" onclick="openinboundpop('action=addMewHotelAdditional&dayId=<?php echo $_REQUEST['dayId']; ?>&hotelQuoteId=<?php echo $_REQUEST['hotelQuoteId']; ?>&roomTariffId=<?php echo $_REQUEST['roomTariffId']; ?>','1000px');" class="whitembutton" style="margin-top: 25px;border-radius: 3px;background-color: #233a49;color: #fff;font-size: 14px;" /> </th>
			</tr>
			</thead>
			</table>
			
		<div style="background-color:#f7f7f7;" id="loadhotelsearch2" >&nbsp;</div>
		<div style="background-color:#feffbc; display:none;" id="loadHotelAdditionalservices" ></div>
			<script type="text/javascript">
			function getHotelAdditionalCost(){
				var isRateId = $('#isRateId').val();
				var additionalRateId = $('#additionalRateId').val();
				$('#loadhotelsearch2').load('loadsaveextra.php?action=loadHotelAdditionalCost&additionalRateId='+additionalRateId+'&isRateId='+isRateId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
			}
			function savehoteladditionalcost(){
				var additionalRateId = $('#additionalRateId').val();
				var additionalCost = $('#additionalcost').val();
				var HAGST  = $('#HAGST').val();
				var isRateId  = $('#isRateId').val();
				var costType  = $('#costType').val();
				// var groupCost = $('#additionalGroupCost').val();
				var hotelQuoteId111 = $('#hotelQuoteId111').val(); 
				if(additionalRateId!='' ){
					$('#loadHotelAdditionalservices').load('loadsaveextra.php?action=addedit_additionalHotelQuotation&add=yes&additionalCost='+additionalCost+'&additionalRateId='+additionalRateId+'&hotelQuoteId='+hotelQuoteId111+'&isRateId='+isRateId+'&HAGST='+HAGST+'&costType='+costType+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
				}else{
					alert('All fields are required.'); 
				}
			}
			<?php if($_REQUEST['hotelQuoteId']!= ''){ ?>
				getHotelAdditionalCost();
			<?php } ?>
			</script>
		</div>
<?php
} 
 
if($_REQUEST['action'] == 'addMewHotelAdditional' && $_REQUEST['dayId'] != '' && $_REQUEST['hotelQuoteId'] != '' && $_REQUEST['roomTariffId']!=''){
	// Hotel Additional Start From Hotel 
	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);
	?>
	<div class="inboundheader">
		<span id="hotelcounding">Add New Hotel Additional </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #ffffff; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
		<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="addNewHotelAdditional" target="actoinfrm" id="addNewHotelAdditional">
	  	<table>
		  	<thead>
			  	<tr>
				<th>
					<div class="griddiv" style="margin-left: 20px;"><label>
						<div class="gridlable" style="text-align: left;font-weight: 400;padding: 8px 0px;">Additional Name</div>
						<input type="text" name="hotelAdditional" id="hotelAdditional" value="" class="gridfield validate"  displayname="Additional Name" >
						</label>
					</div> 
				</th>

				<th style="padding-left: 6px;"><div class="griddiv"><label>
					<div class="gridlable" style="text-align: left;font-weight: 400;padding: 8px 0px;">GST SLAB</div>		
					<select name="gstTax" id="gstTax" class="gridfield"  displayname="GST SLAB" style="padding:8px;">
						<option value="0">SELECT GST SLAB</option>
						<?php
						$rs2 = "";												
						$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and serviceType="Restaurant" and status=1 order by gstSlabName asc');
						while ($gstSlabData = mysqli_fetch_array($rs2)) {
						?>
							<option value="<?php echo $gstSlabData['id']; ?>"><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
						<?php
						}
						?>
					</select>
					</label>
					</div>
				</th>
				<th style="padding-left: 6px;"><div class="griddiv"><label>
					<div class="gridlable" style="text-align: left;font-weight: 400;padding: 8px 0px;">Currency</div>		
					<select name="currencyId" id="currencyId" class="gridfield validate"  displayname="Currency" style="padding:8px;">
						<option value="0">SELECT CURRENCY</option>
						<?php
						$currQuery='  status=1 and deletestatus=0 order by name asc';
						$currQuery2=GetPageRecord('*','queryCurrencyMaster',$currQuery);
						while($currencyData=mysqli_fetch_array($currQuery2)){
						?>
						<option value="<?php echo strip($currencyData['id']); ?>" <?php if($currencyData['setDefault']==1 ){ ?> selected="selected" <?php } ?> ><?php echo ucfirst($currencyData['name']); ?></option>
						<?php } ?>
					</select>
					</label>
					</div>
				</th>
				<th style="padding-left: 6px;">
					<div class="griddiv"><label>
						<div class="gridlable" style="text-align: left;font-weight: 400;padding: 8px 0px;">Cost Type</div>
						<select name="costType" id="costType"  class="gridfield validate"  displayname="Cost Type" >
							<option value="1">Per Pax Cost</option>
							<option value="2">Group Cost</option>
						</select>
						</label>
					</div>
				</th>
				<th style="padding-left: 6px;">
					<div class="griddiv"><label>
						<div class="gridlable" style="text-align:left; font-weight: 400; padding: 8px 0px;">Cost</div>
						<input type="text" name="additionalCost" id="additionalCost"   class="gridfield validate"  displayname="Cost" >
						</label>
					</div>
				</th>
				<th>
					<input type="button" name="Submit" value="   + ADD   " onclick="formValidation('addNewHotelAdditional','submitbtn','0');" class="whitembutton" style="margin-top: 25px;border-radius: 3px;background-color: #233a49;color: #fff;font-size: 14px;" /> 
					<input type="hidden" value="add_MewHotelAdditional" name="action"/>
					<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
					<input type="hidden" name="hotelId" id="hotelId" value="<?php echo $hotelQuotData['supplierId']; ?>">
					<input type="hidden" value="<?php echo $_REQUEST['roomTariffId']; ?>" name="roomTariffId"/>
					<input type="hidden" name="hotelQuoteId" id="hotelQuoteId" value="<?php echo $_REQUEST['hotelQuoteId']; ?>">
				</th>
				<th><input type="button" value=" BACK TO SEARCH" onclick="openinboundpop('action=addHotelAdditionalService&dayId=<?php echo $_REQUEST['dayId']; ?>&hotelQuoteId=<?php echo $_REQUEST['hotelQuoteId']; ?>&roomTariffId=<?php echo $_REQUEST['roomTariffId']; ?>','1000px');" class="whitembutton" style="margin-top: 25px;border-radius: 3px;background-color: #233a49;color: #fff;font-size: 14px;" /> </th>
			  	</tr>
		  	</thead>
	  	</table>
	  	</form>
	</div>
<?php
} 


if(trim($_REQUEST['action'])=='add_MewHotelAdditional' && trim($_REQUEST['hotelAdditional'])!='' && trim($_REQUEST['dayId'])!='' && trim($_REQUEST['hotelQuoteId'])!='' && trim($_REQUEST['hotelId'])!='' && trim($_REQUEST['roomTariffId'])!='' && trim($_REQUEST['costType'])!='' && trim($_REQUEST['currencyId'])!=''){

	$hotelAdditional=clean($_REQUEST['hotelAdditional']);
	$currencyId = $_REQUEST['currencyId'];
	$gstTax = $_REQUEST['gstTax'];
	$costType=clean($_REQUEST['costType']);
	$additionalCost = $_REQUEST['additionalCost'];

	$dayId = $_REQUEST['dayId'];
	$hotelQuoteId=clean($_REQUEST['hotelQuoteId']);
	$hotelId=clean($_REQUEST['hotelId']);
	$roomTariffId=clean($_REQUEST['roomTariffId']);
	$quotationId = $_REQUEST['quotationId'];

	$d="";
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelId.'"');
	$hotelData=mysqli_fetch_array($d);


	$dateAdded = time();

	$rsr=GetPageRecord('*','additionalHotelMaster','name="'.$hotelAdditional.'" '); 
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('Additional Hotel Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
    }
    else{
        $namevalue ='name="'.$hotelAdditional.'",dateAdded="'.$dateAdded.'",status=1,addedBy="'.$_SESSION['userid'].'"'; 
        $lastid = addlistinggetlastid('additionalHotelMaster',$namevalue); 

        $hotelAdditional = $hotelData['hotelAdditional'].','.$lastid;

		updatelisting(_PACKAGE_BUILDER_HOTEL_MASTER_,'hotelAdditional="'.$hotelAdditional.'"',' id="'.$hotelId.'"');
		
		$namevalue ='hotelId="'.$hotelId.'",rateId="'.$roomTariffId.'",gsttax="'.$gstTax.'",personWise="'.$costType.'",currencyId="'.$currencyId.'",status=1,isQuoteRate=1,additionalCost="'.$additionalCost.'",additionalName="'.$lastid.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
		$lastId2 = addlistinggetlastid('dmcAdditionalHotelRate',$namevalue);
        ?>
        <script>
        parent.openinboundpop('action=addHotelAdditionalService&dayId=<?php echo $_REQUEST['dayId']; ?>&hotelQuoteId=<?php echo $_REQUEST['hotelQuoteId']; ?>&roomTariffId=<?php echo $_REQUEST['roomTariffId']; ?>','1000px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
        </script> 
        <?php
    }

}


 
// Transfer
if($_REQUEST['action'] == 'addServiceTransfer' && $_REQUEST['dayId']!=''){


		$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
		$dayData = mysqli_fetch_array($dayQuery);
		$cityId = $dayData['cityId'];

		//quotation data
		$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
		$quotationData=mysqli_fetch_array($quotQuery);
		$totalPaxVal= $quotationData['adult'];
		//Query data
		$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
		$queryData=mysqli_fetch_array($queQuery);


	?>


 	<div class="inboundheader" > Select Transfer - <?php echo date('d-m-Y', strtotime($dayData['srdate'])); ?><i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i><span class="griddiv" style="position:static;">
 	     	</span></div>
	<div style="padding:10px;" id="transferbox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addtransferroomprice" target="actoinfrm" id="addtransferroomprice">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
			<tbody>
			<tr style="background-color:transparent !important;"> 
			<td width="200" align="left" style="display:none">
				<div class="griddiv" style="position:static;"><label>
					<div>From</div>
					<select id="startDay" name="startDay" class="gridfield validate" displayname="Start Day" autocomplete="off"   >
					<?php
					$day=1;
					$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0   order by id asc');
					while($QueryDaysData=mysqli_fetch_array($a)){
					if($dayData['cityId']==$QueryDaysData['cityId']){
					?>
					<option value="<?php echo strip($QueryDaysData['id']); ?>,<?php echo date('Y-m-d', strtotime($QueryDaysData['srdate'])); ?>,<?php echo strip($QueryDaysData['cityId']); ?>" <?php if(strip($QueryDaysData['id']) == $_REQUEST['dayId']){ ?> selected="selected" <?php } ?> >Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
					<?php
					}
					$day++;
					} ?>
					</select>
					</label>
					</div>			
			</td>

			<td width="100" align="left" style="display:none">
				<div class="griddiv" style="position:static;"><label>
				<div>To</div>
				<select id="endDay" name="endDay" class="gridfield validate" displayname="End Day" autocomplete="off"   >
				<?php
				$day=1;
				$b=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  order by id asc');
				while($QueryDaysData1=mysqli_fetch_array($b)){

				if($dayData['cityId']==$QueryDaysData1['cityId']){
				?>
				<option value="<?php echo strip($QueryDaysData1['id']); ?>,<?php echo date('Y-m-d', strtotime($QueryDaysData1['srdate'])); ?>,<?php echo strip($QueryDaysData1['cityId']); ?>"  <?php if($dayData['id']==$QueryDaysData1['id']){ ?>selected="selected" <?php } ?> >Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData1['cityId']);?></option>
				<?php
				}
				$day++;
				} ?>
				</select>
				</label>
				</div>			
			</td>
				

			<td width="10%" align="left">
				<div class="griddiv" style="position:static;">
					<label> <div>&nbsp;</div>
						<select id="destWise3" name="destWise3" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 3px;" >
						<option value="1">Selected Destination</option>
						<option value="2">All Destinations</option>
						</select>
					</label>
					<script>
					  function getdestWise(){
						if($('#destWise3').val()==2){
							$('#destinationId3').load('loadAllDestinations.php');
						}

						if($('#destWise3').val()==1){
							$('#destinationId3').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
						}
						$('#select2-destinationId3-container').attr('title','Select');
						$('#select2-destinationId3-container').text('Select');
					  }
					  </script>
			    </div>
			</td>
<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}
</style>
			<td width="10%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div class="HeadingBOL">Destination</div>
						<select id="destinationId3" name="destinationId3" class="gridfield validate select2" displayname="Select Destination" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" onchange="loadTransferfun();">
							<?php
							$day=1;
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and cityId="'.$cityId.'"  and addstatus=0  group by cityId order by id asc');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							$day++;
							} ?>
						</select>
					</label>
				</div>
			</td>
			<td width="7%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">Type</div>
				<select id="sic_pvt3" name="sic_pvt3" class="gridfield"  >
					<option value="2">PVT</option>
					<option value="1">SIC</option>
					
				</select>
				</label>
				</div>			
			</td>
			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">Transfer Type</div>
				<select id="transferType3" name="transferType3" class="gridfield" onchange="getTransferName();"  >
					<option value="">All TransferType</option>
					<?php
					$b=GetPageRecord('*','transferTypeMaster','deletestatus=0 and status=1 order by id asc');
					while($transferData=mysqli_fetch_array($b)){
					?>
					<option value="<?php echo strip($transferData['id']); ?>"><?php echo $transferData['name']; ?></option>
					<?php
					} ?>
				</select>
				</label>
				</div>			
			</td>
			
			<td width="25%" align="left">
				<div class="griddiv" style="position:static;"><label>
					<div class="gridlable" style="width:100%;color: #343131;font-weight: bold;">Transfer Name</div>
					<select id="transferId3" name="transferId3" class="gridfield"  autocomplete="off" >
					   
				  	</select>
					</label>
			    </div> 
			</td> 

			<!-- started vehicle type  -->
			<td width="15%" align="left" valign="middle">
              <div class="griddiv"><label>
               <div class="gridlable" style="color: #343131;font-weight: bold;color: #343131;font-weight: bold;">Vehicle Type</div>
			   <select id="vehicleType" name="vehicleType" class="gridfield " displayname="Title" autocomplete="off">
			   		<option value="0">All Vehicles</option>
					<?php

					$rs = GetPageRecord('*', 'vehicleTypeMaster', '1 and status=1 and deletestatus=0 order by name asc');

					while ($resListing = mysqli_fetch_array($rs)) {

					?>

						<option value="<?php echo $resListing['id']; ?>" 
						<?php if ($queryData['vehicleId'] == $resListing['id']) { ?> selected="selected" <?php } ?>>
							<?php echo strip($resListing['name'].' ('.$resListing['capacity']).' Pax )'; ?></option>

					<?php } ?>

					</select>
              </label>
             </div>
			</td>
			<!-- ended vehicle type  -->

			<td width="8%" align="left" valign="middle">
				<input name="transferCategory3" type="hidden" id="transferCategory3" value="transfer">
				<!-- comment this -->
			    <!-- <input style="margin-top: 10px;" type="button" name="Submit" value="   Search   " class="bluembutton" onclick="loadsearchtransferfunction();">		    -->

				<!-- add this  -->
				<button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchtransferfunction();">
				<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
				</button>
			
			
			</td>
			</tr>
			</tbody>
			</table>
			</form>
			<script src="plugins/select2/select2.full.min.js"></script>
			<script>
			$(document).ready(function() {
				$('.select2').select2();
			});
			</script>
			<style>
			.select2-container--open{
			z-index: 9999999999 !important;
			width: 100%;
			}

			.select2-container {
			box-sizing: border-box;
			display: inline-block;
			margin: 0;
			position: relative;
			vertical-align: middle;
			width: 100% !important;
			margin-top: 6px !important;
			}

			.select2-container--default .select2-selection--single {
			    HEIGHT: 35px;

				}
			</style>
		</div>
		<div style="background-color:#feffbc;display:none;" id="loadtransfersave" ></div>
	  	<div style="background-color:#f7f7f7;" id="loadtransfersearch3" >&nbsp;</div>
		<script type="text/javascript">

				function getTransferName(){

				let transferTypeId = $("#transferType3").val();
				$("#transferId3").load(`searchaction.php?action=getTransferNameAction&transferTypeId=${transferTypeId}&destinationId=<?php echo $dayData['cityId']; ?>`);
				}
				getTransferName();

			 function loadTransferfun(){
		   		var destinationId = $('#destinationId3').val(); 
		   		$('#transferId3').load('load_transfer.php?destinationId='+destinationId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
		    }
			function addtransfertoquotations(tarifId,supplierId,capacity,tableN){ 
				var totalPax=$('#totalPax2'+ tarifId).val(); 
				var cityId = $('#destinationId3').val();
				var transferType =$('#transferType3').val(); 
				var noOfVehicles =$('#noOfVehicles2'+tarifId).val(); 
				var totalPaxVal = '<?php echo $totalPaxVal; ?>';
				var vehicleconf = false;
				var vcapacity = Number(capacity*noOfVehicles); 
				if(vcapacity>=Number(totalPaxVal)){
					vehicleconf = true;
				}else{
					vehicleconf = confirm('Vehicle Capacity is less('+vcapacity+') than the total adult('+totalPaxVal+'). Do you still want to take this vehicle Type?');
				}	
				
				if(vehicleconf==true){
				if(tarifId > 0){
					$('#loadtransfersave').load('loadsavetransfer.php?add=yes&tarifId='+tarifId+'&serviceid='+tarifId+'&tableN='+tableN+'&costType=1&supplierId='+supplierId+'&cityId='+cityId+'&transferCategory=transfer&dayId=<?php echo $_REQUEST['dayId']; ?>&serviceType=transfer&totalPax='+totalPax+'&noOfVehicles='+noOfVehicles);
					selectthis2('#selectthis2'+tarifId);
				}else{
					alert('All fields are required.');
				}
			}

			}
			
			function loadsearchtransferfunction(){ 
				var vehicleTypeId = $('#vehicleType').val(); 
				var transferId =$('#transferId3').val();
				var destWise =$('#destWise3').val();
				var cityId =$('#destinationId3').val();
				var sic_pvt =$('#sic_pvt3').val();
				var transferType =$('#transferType3').val();
				$('#loadtransfersearch3').load('loadtransfersearch.php?destWise='+destWise+'&cityId='+cityId+'&vehicleTypeId='+encodeURI(vehicleTypeId)+'&transferId='+transferId+'&sic_pvt='+sic_pvt+'&transferType='+transferType+'&transferCategory=transfer&dayId=<?php echo $_REQUEST['dayId']; ?>');
			}
			<?php if($_REQUEST['transferCategory']!='' ){ ?>
			loadsearchtransferfunction();
			<?php } ?>
		</script>
	</div>
	<?php
}
// Transportation services start
if($_REQUEST['action'] == 'addServiceTransportation' && $_REQUEST['dayId']!=''){

		$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
		$dayData = mysqli_fetch_array($dayQuery);
		$cityId = $dayData['cityId'];

		//quotation data
		$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
		$quotationData=mysqli_fetch_array($quotQuery);
		$totalPaxVal = $quotationData['adult'];
		//Query data
		$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
		$queryData=mysqli_fetch_array($queQuery);

	?>
	<div class="inboundheader" style="position:relative;">
			<?php 
			$isSupplement = $isGuestType = $transferQuoteId = 0;
			if($_REQUEST['transferQuoteId']>0 && $_REQUEST['stype'] == 'transferSupplement'){
				$headingName = 'Supplement Transportation';
				$isSupplement = 1;
				$transferQuoteId = $_REQUEST['transferQuoteId'];

				$rs12=GetPageRecord(' * ',_QUOTATION_TRANSFER_MASTER_,'id="'.$transferQuoteId.'"'); 
				$transferQuoteData = mysqli_fetch_array($rs12); 
				$transferId=$transferQuoteData['transferNameId'];

			}else{
				$headingName = 'Transportation';
				$isGuestType = 1;
			} 
			echo $headingName; if($queryData['dayWise']==1){ echo "&nbsp;|&nbsp;".date('D j M Y', strtotime($dayData['srdate'])); }  ?><i class="fa fa-times" aria-hidden="true" style="position: absolute;top: 5px; right: 10px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;
	</div>

<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>

 	<div style="padding:10px;" id="transferbox">

		<input type="hidden" id="transferQuoteId3" value="<?php echo $transferQuoteId; ?>">
		<input type="hidden" id="isSupplement3" value="<?php echo $isSupplement; ?>">
		<input type="hidden" id="isGuestType3" value="<?php echo $isGuestType; ?>">
		<!-- hiddend fields -->
	
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addtransferroomprice" target="actoinfrm" id="addtransferroomprice">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
		<tbody>
		<tr style="background-color:transparent !important;">
 								
			<td width="15%" align="left">
				<div class="griddiv" style="position:static;">
					<label> <div class="HeadingBOL">Change&nbsp;Destination</div>
						<select id="destWise3" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 3px;" >
						<option value="1">Selected Destination</option>
						<option value="2">All Destinations</option>
						</select>
					</label>
					<script type="text/javascript">
					  function getdestWise(){
						if($('#destWise3').val()==2){
							$('#destinationId3').load('loadAllDestinations.php');
						}
						if($('#destWise3').val()==1){
							$('#destinationId3').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
						}
						$('#select2-destinationId3-container').attr('title','Select');
						$('#select2-destinationId3-container').text('Select');
					  }
					  </script> 
			    </div>
			</td>
			<td width="15%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div class="HeadingBOL">Current&nbsp;Destination</div>
						<select id="destinationId3" name="destinationId1" class="gridfield select2" displayname="Select Destination" autocomplete="off" onchange="loadTransferfun();">
							<?php
							$day=1;
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and cityId="'.$cityId.'"  and addstatus=0  group by cityId order by id asc');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							$day++;
							} ?>
						</select>
					</label>
				</div>
			</td>
			<td width="10%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">From&nbsp;Day</div>
				<select id="startDay3" name="startDay" class="gridfield validate" displayname="Start Day" autocomplete="off"   >
				<?php
				$day=1;
				$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0   order by id asc');
				while($QueryDaysData=mysqli_fetch_array($a)){
				// if($dayData['cityId']==$QueryDaysData['cityId']){
				?>
				<option value="<?php echo strip($QueryDaysData['id'].'_'.$day); ?>" <?php if(strip($QueryDaysData['id']) == $_REQUEST['dayId']){ ?> selected="selected" <?php } ?> >Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
				<?php
				// }
				$day++;
				} ?>
				</select>
				</label>
				</div>			
			</td> 
			<td width="10%" align="left" >
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">To&nbsp;Day</div>
				<select id="endDay3" name="endDay" class="gridfield validate" displayname="End Day" autocomplete="off"   >
				<?php
				$day=1;
				$b=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  order by id asc');
				while($QueryDaysData1=mysqli_fetch_array($b)){

				// if($dayData['cityId']==$QueryDaysData1['cityId']){
				?>
				<option value="<?php echo strip($QueryDaysData1['id'].'_'.$day); ?>"  <?php if($dayData['id']==$QueryDaysData1['id']){ ?>selected="selected" <?php } ?> >Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData1['cityId']);?></option>
				<?php
				// }
				$day++;
				} ?>
				</select>
				</label>
				</div>			
			</td>
			
			<td width="10%" align="left" valign="middle" rowspan="2">
				<input name="transferCategory" type="hidden" id="transferCategory3" value="transportation">

				<!-- comment this -->
			    <!-- <input style="margin-top: 10px;" type="button" name="Submit" value="   Search  " class="bluembutton" onclick="loadsearchtransferfunction();"> -->
				
				<!-- add this  -->
				<button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchtransferfunction();">
				<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
				</button>


			</td>
		</tr>
		<tr>
			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">Transfer&nbsp;Type</div>
				<select id="transferType3" name="transferType" class="gridfield"  >
					<option value="0">All Transfer Type</option>
					<?php
					$b=GetPageRecord('*','transferTypeMaster','deletestatus=0 and status=1 order by id asc');
					while($transferData=mysqli_fetch_array($b)){
					?>
					<option value="<?php echo strip($transferData['id']); ?>"><?php echo $transferData['name']; ?></option>
					<?php
					} ?>
				</select>
				</label>
				</div>			
			</td>

			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
					<div class="gridlable" style="width:100%;color: #343131;font-weight: bold;" class="HeadingBOL">Transportation&nbsp;Name</div>
					<select id="transferId3" name="transferId1" class="gridfield"  autocomplete="off" displayname="Transfer Name"   >
						<?php
			            $rstransfer=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' transferCategory="transportation"  and FIND_IN_SET("'.$dayData['cityId'].'",destinationId) or destinationId=0 and status=1 order by transferName asc');
			            while($transferD=mysqli_fetch_array($rstransfer)){
			            ?>
	                	<option value="<?php echo $transferD['id']; ?>" <?php if($transferId==$transferD['id']){?>selected<?php } ?>><?php echo $transferD['transferName']; ?></option>
	                	<?php } ?>
				  	</select>
					</label>
			    </div> 
			</td> 
			<td width="15%" align="left" valign="middle">
              <div class="griddiv"><label>
               <div class="gridlable" class="HeadingBOL" style="color: #343131;font-weight: bold;">Vehicle&nbsp;Type</div>
			   <select id="vehicleType" name="vehicleType" class="gridfield " displayname="Title" autocomplete="off">
			   		<option value="0">All Vehicles</option>
					<?php 
					$rs = GetPageRecord('*', 'vehicleTypeMaster', '1 and status=1 and deletestatus=0 order by name asc'); 
					while ($resListing = mysqli_fetch_array($rs)) { 
					?> 
						<option value="<?php echo $resListing['id']; ?>" <?php if ($queryData['vehicleId'] == $resListing['id']) { ?> selected="selected" <?php } ?>>
							<?php echo strip($resListing['name'].' ('.$resListing['capacity']).' Pax )'; ?></option>

					<?php } ?>

					</select>
              </label>
             </div>
			</td> 
         	<td width="15%" align="left" valign="middle">
         		<div class="griddiv">
				<label>
				<div class="gridlable" class="HeadingBOL"  style="color: #343131;font-weight: bold;">Cost&nbsp;Type</div>
				<select id="transferCostType3" name="transferCostType3" class="gridfield validate" displayname="Transfer Cost Type" autocomplete="off" style="width: 100% !important;">
				<option value="2">Package Cost</option>
				<option value="1">Per Day Cost</option>
				<option value="3">Per KM Cost</option>
				</select>
				</label>
				</div>
			</td>

		</tr>
			</tbody>
			</table>
			</form>
			<script src="plugins/select2/select2.full.min.js"></script>
			<script>
			$(document).ready(function() {
				$('.select2').select2();
			});
			</script>
			<style>
			.select2-container--open{
			z-index: 9999999999 !important;
			width: 100%;
			}

			.select2-container {
			box-sizing: border-box;
			display: inline-block;
			margin: 0;
			position: relative;
			vertical-align: middle;
			width: 100% !important;
			margin-top: 6px !important;
			}

			.select2-container--default .select2-selection--single {
			    HEIGHT: 35px;

				}
			</style>
		</div>
		<div style="background-color:#feffbc;display:none;" id="loadtransfersave" ></div>
	  	<div style="background-color:#f7f7f7;" id="loadtransfersearch" >&nbsp;</div>
		<script type="text/javascript">
 
		    function loadTransferfun(){ 
		   		var destinationId = $('#destinationId3').val(); 
		   		$('#transferId3').load('load_transfer.php?transferCategory=transportation&destinationId='+destinationId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
		    }
		    loadTransferfun(); 
		    	
			function addtransfertoquotations(tarifId,supplierId,capacity,tableN){
				var noOfVehicles=$('#noOfVehicles2'+ tarifId).val();
				var totalPax=$('#totalPax2'+ tarifId).val(); 
				var noOfDays =$('#noOfDays2'+tarifId).val(); 
				var startDay =$('#startDay3').val();
				var endDay =$('#endDay3').val();
				var cityId = $('#destinationId3').val();
				var costType =$('#transferCostType3').val();
				var isGuestType =$('#isGuestType3').val();
				var isSupplement =$('#isSupplement3').val();
				var transferQuoteId =$('#transferQuoteId3').val();

				var totalPaxVal = '<?php echo $totalPaxVal; ?>';
				var vehicleconf = false;
				var vcapacity = Number(capacity*noOfVehicles);

				if(Number(vcapacity)>=Number(totalPaxVal)){
					vehicleconf = true;
				}else{
					vehicleconf = confirm('Vehicle Capacity is less('+vcapacity+') than the total adult('+totalPaxVal+')');
				}	
				
				if(vehicleconf==true){

				if(tarifId > 0 ){
					$('#loadtransfersave').load('loadsavetransfer.php?add=yes&tarifId='+tarifId+'&serviceid='+tarifId+'&tableN='+tableN+'&supplierId='+supplierId+'&cityId='+cityId+'&transferCategory=transportation&isGuestType='+isGuestType+'&isSupplement='+isSupplement+'&transferQuoteId='+transferQuoteId+'&startDay='+startDay+'&endDay='+endDay+'&costType='+costType+'&noOfDays='+noOfDays+'&dayId=<?php echo $_REQUEST['dayId']; ?>&noOfVehicles='+noOfVehicles+'&totalPax='+totalPax);
				}else{
					alert('All fields are required.');
				}
			}
			}

			function loadsearchtransferfunction(){ 

				var startDay =$('#startDay3').val();
				var endDay =$('#endDay3').val(); 
				var vehicleTypeId = $('#vehicleType').val(); 
				var transferId = $('#transferId3').val();
				var destWise = $('#destWise3').val();
				var cityId = $('#destinationId3').val();
				var transferType = $('#transferType3').val();
				var costType =$('#transferCostType3').val();

				var isGuestType =$('#isGuestType3').val();
				var isSupplement =$('#isSupplement3').val();
				var transferQuoteId =$('#transferQuoteId3').val();

				if(transferId > 0 || isSupplement ==1 ){
					$('#loadtransfersearch').load('loadtransfersearch.php?destWise='+destWise+'&cityId='+cityId+'&vehicleTypeId='+encodeURI(vehicleTypeId)+'&transferId='+transferId+'&transferType='+transferType+'&costType='+costType+'&isGuestType='+isGuestType+'&isSupplement='+isSupplement+'&transferQuoteId='+transferQuoteId+'&transferCategory=transportation&startDay='+startDay+'&endDay='+endDay+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
				}else{
					alert("Please select Transportation Name!");
				}
			}
			<?php if($_REQUEST['transferCategory']!='' || (isset($_REQUEST['transferQuoteId']) && $_REQUEST['stype'] == 'transferSupplement')){ ?>
			loadsearchtransferfunction('');
			<?php } ?>

			function getVehicleModel1() {
             var vehicleId = $('#vehicleType3').val();
             $("#vehicleModelId3").load('loadvehiclemodel.php?vehicleTypeId='+vehicleId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
            }
            function selectthis(ele){
				$(ele).html('Selected');
				$(ele).removeAttr('onclick');
				$(ele).css('background-color','#d88319');
			}
		</script>
	</div>
	<?php
}
 
 
if($_REQUEST['action'] == 'addServiceFerry' && $_REQUEST['dayId']!=''){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery); 
	?>
 	<div class="inboundheader" > Select Ferry - <?php echo date('d-m-Y', strtotime($dayData['srdate'])); ?><i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i><span class="griddiv" style="position:static;">
 	     	</span></div>
<style>
.HeadingBOL{
	color: #343131;
	font-weight: bold;
}
</style>
	 <div style="padding:10px;" id="transferbox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addFerryService" target="actoinfrm" id="addFerryService">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
			<tbody>
			<tr style="background-color:transparent !important;">
				<td width="20%" align="left">
					<div class="griddiv" style="position:static;">
						<label> <div>&nbsp;</div>
							<select id="destWise" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 3px;" >
							<option value="1">Selected Destination</option>
							<option value="2">All Destinations</option>
							</select>
						</label>
						<script>
						  function getdestWise(){
							if($('#destWise').val()==2){
								$('#destinationId1').load('loadAllDestinations.php');
							}
							if($('#destWise').val()==1){
								$('#destinationId1').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
							}
							$('#select2-destinationId1-container').text('Select');

						  }
						  </script>
				    </div>
				</td>

			<td width="20%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div class="HeadingBOL">From Destination</div>
						<select id="destinationId1" name="destinationId1" class="gridfield validate select2" displayname="Select Destination" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" onchange="loadFerryfun();">
							<?php
							$day=1;
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and cityId="'.$cityId.'"  and addstatus=0  group by cityId order by id asc');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							$day++;
							} ?>
						</select>
					</label>
				</div>
			</td>
			<!-- To destination -->

		

			<td width="15%" align="left">
			  		<div class="griddiv" style="position:static;">
			  			<label>
						<div class="HeadingBOL">To Destination</div>
						<select id="todestination" name="todestination" class="gridfield validate select2" displayname="To Destination" autocomplete="off"   >
						<?php
						$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  group by cityId ');
						while($QueryDaysData=mysqli_fetch_array($a)){ ?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  ><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
						} ?>
						</select>
						</label>
					</div>
				</td> 


			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
					<div class="HeadingBOL" style="width:100%;" >Ferry Service Name</div>
					<select id="ferryServiceId" name="ferryServiceId" class="gridfield" onclick="getPickUptime();" onchange="getPickUptime();" autocomplete="off"    >
					    <option value="0">Select Ferry</option>
						<?php
			            $ferryServiceQ=GetPageRecord('*','ferryPriceMaster',' 1 and FIND_IN_SET("'.$dayData['cityId'].'",destinationId) and status=1 order by name asc');
			            while($ferryServiceData=mysqli_fetch_array($ferryServiceQ)){
			            ?>
	                	<option value="<?php echo $ferryServiceData['id']; ?>"><?php echo $ferryServiceData['name']; ?></option>
	                	<?php } ?>
				  	</select>
					</label>
			    </div> 
			</td>
			 
			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">Select Ferry Seat</div>
				<select id="ferrySeatId" name="ferrySeatId" class="gridfield" >
					<option value="0">All Ferry Seat</option>
					<?php
					$bc1='';
					$bc1=GetPageRecord('*','ferryClassMaster',' deletestatus=0 and status=1 order by name asc');
					while($ferrySeatData=mysqli_fetch_array($bc1)){
					?>
					<option value="<?php echo strip($ferrySeatData['id']); ?>"><?php echo $ferrySeatData['name']; ?></option>
					<?php
					} ?>
				</select>
				</label>
				</div>			
			</td>

			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">Select Departure Time</div>

				<select id="ferryTime" name="ferryTime" class="gridfield" >
					<option value="0">Select Time</option>
					
				</select>

				</label>
				</div>			
			</td>

			<td width="8%" align="left" valign="middle">
				<!-- comment this  -->
			    <!-- <input style="margin-top: 10px;" type="button" name="Submit" value="   Search   " class="bluembutton" onclick="loadsearchferryfunction();">	 -->

				<!-- add this  -->
				<button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchferryfunction();">
				<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
				</button>
			</td>
			</tr>
			</tbody>
			</table>
			</form>
			<script src="plugins/select2/select2.full.min.js"></script>
			<script>
			$(document).ready(function() {
				$('.select2').select2();
			});
			</script>
			<style>
			.select2-container--open{
				z-index: 9999999999 !important;
				width: 100%;
			}

			.select2-container {
				box-sizing: border-box;
				display: inline-block;
				margin: 0;
				position: relative;
				vertical-align: middle;
				width: 100% !important;
				margin-top: 6px !important;
			}
			.select2-container--default .select2-selection--single {
			    HEIGHT: 35px;
			}
			</style>
		</div>
		<div style="background-color:#feffbc;display:none;" id="loadferrytime" ></div>
		<div style="background-color:#feffbc;display:none;" id="loadferrysave" ></div>
	  	<div style="background-color:#f7f7f7;" id="loadferrysearch" >&nbsp;</div>
		<script type="text/javascript">
			 function loadFerryfun(){
		   		var destinationId = $('#destinationId1').val(); 
				   var ferryServiceIds =$('#ferryServiceId').val();
		   		$('#ferryServiceId').load('loadferryservices.php?action=getDestinations&destinationId='+destinationId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');   
				$('#ferryTime').load('loadferryservices.php?action=getferryTime&ferryServiceId='+ferryServiceIds+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
		    }
			function addferrytoquotations(rateId,tableN,ferryServiceId){
				var cityId = $('#destinationId1').val();
				var todestination = $('#todestination').val();
				var ferryTimeId = $('#ferryTime').val(); 
				if(rateId > 0 && tableN > 0){
					$('#loadferrysave').load('loadsaveferry.php?add=yes&ferryTimeId='+ferryTimeId+'&rateId='+rateId+'&tableN='+tableN+'&ferryServiceId='+ferryServiceId+'&cityId='+cityId+'&todestination='+todestination+'&dayId=<?php echo $_REQUEST['dayId']; ?>&currencyId=<?php echo $quotationData['currencyId']; ?>');
					selectthis('#selectthis'+rateId);
				}else{
					alert('All fields are required.');
				}
			}
			function loadsearchferryfunction(){ 
				var ferrySeatId = $('#ferrySeatId').val(); 
				var ferryTimeId = $('#ferryTime').val(); 
				var ferryServiceId =$('#ferryServiceId').val();
				var destWise =$('#destWise').val();
				var cityId =$('#destinationId1').val();
				var todestination =$('#todestination').val();
				$('#loadferrysearch').load('loadferrysearch.php?ferryTimeId='+ferryTimeId+'&destWise='+destWise+'&cityId='+cityId+'&todestination='+todestination+'&ferryServiceId='+ferryServiceId+'&ferrySeatId='+ferrySeatId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
			}
			// loadsearchferryfunction();
			
			function getPickUptime(){
				var ferryServiceIds =$('#ferryServiceId').val();
				$('#ferryTime').load('loadferryservices.php?action=getferryTime&ferryServiceId='+ferryServiceIds+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
			}

			// function loadFerryfun(){
			
			// }
		</script>
	</div>
	<?php
}
 
// sdfsdfs
if($_REQUEST['action'] == 'addServiceActivity' && $_REQUEST['dayId']!=''){

 	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];
	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);
	
	$pax = $quotationData['adult']+$quotationData['child'];
	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);
	?>
	<div class="inboundheader" style="position:relative;">
 		<?php echo 'SightSeeing'; if($queryData['dayWise']==1){ echo "&nbsp;|&nbsp;".date('D j M Y', strtotime($dayData['srdate'])); }  ?><i class="fa fa-times" aria-hidden="true" style="position: absolute;top: 5px; right: 10px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;
	</div>
<style>
.HeadingBOL{
	color: #343131;
	font-weight: bold;
}

</style>
	<div class="addeditpagebox " style="display:nones;position:relative;padding: 10px!important;">
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice" style="width: 100% !important;">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tablesorter ">
		  <tbody>
		  <tr style="background-color:transparent !important;">
			<td width="15%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div  class="HeadingBOL">Destination Type</div>
						<select id="destWise3" name="destWise3" class="gridfield validate" onChange="getdestWise();"  >
						<option value="1">Selected Destination</option>
						<option value="2">All Destinations</option>
						</select>
					</label>
					<script>
					  function getdestWise(){
						if($('#destWise3').val()==2){
							$('#destinationId3').load('loadAllDestinations.php');
						}

						if($('#destWise3').val()==1){
							$('#destinationId3').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
						}
						$('#select2-destinationId3-container').text('Select');
					  }
					  </script>
			    </div>
			</td>
			<td width="10%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div  class="HeadingBOL">Destination</div>
						<select id="destinationId3" name="destinationId3" class="gridfield validate select2" displayname="Select Destination" autocomplete="off" >
							<?php
							$day=1;
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and cityId="'.$cityId.'"  and addstatus=0  group by cityId order by id asc');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							$day++;
							} ?>
						</select>
					</label>
				</div>
			</td>
		    <td width="12%" align="left">
		    	<div class="griddiv" style="position:static;">
					<label>
						<div class="HeadingBOL">From&nbsp;Day</div>
						<select id="startDayId3" name="startDayId3" class="gridfield validate" displayname="Start Day" autocomplete="off" >
						<?php
						$day=1;
						$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  order by id asc');
						while($QueryDaysData=mysqli_fetch_array($a)){
						//if($dayData['cityId']==$QueryDaysData['cityId']){
						?>
						<option value="<?php echo strip($QueryDaysData['id']); ?>,<?php echo date('Y-m-d', strtotime($QueryDaysData['srdate'])); ?>,<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['srdate']==$QueryDaysData['srdate']){ ?>  selected="selected" <?php } ?>>Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
						<?php
						//}
						$day++;
						} ?>
						</select>
					</label>
				</div>
			</td>
		    <td width="12%" align="left">
		    	<div class="griddiv" style="position:static;">
					<label>
						<div  class="HeadingBOL">To&nbsp;Day</div>
						<select id="endDayId3" name="endDayId3" class="gridfield validate" displayname="Start Day" autocomplete="off" >
						<?php
						$day=1;
						$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  order by id asc');
						while($QueryDaysData=mysqli_fetch_array($a)){
						//if($dayData['cityId']==$QueryDaysData['cityId']){
						?>
						<option value="<?php echo strip($QueryDaysData['id']); ?>,<?php echo date('Y-m-d', strtotime($QueryDaysData['srdate'])); ?>,<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['srdate']==$QueryDaysData['srdate']){ ?>  selected="selected" <?php } ?>>Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
						<?php
						//}
						$day++;
						} ?>
						</select>
					</label>
				</div>
			</td>

			<td width="8%">
		<div class="griddiv"><label>

			<div  class="HeadingBOL">Transfer&nbsp;Type</div>

			<select id="ActransferType" name="ActransferType" class="gridfield " autocomplete="off">
				
				<option value="">Select</option>
				<option value="1" <?php if ($editresult['transferType'] == '1') { ?> selected="selected" <?php } ?>>SIC</option>
				
				<option value="2" <?php if ($editresult['transferType'] == '2') { ?> selected="selected" <?php } ?>>PVT</option>
				
				<option value="3" <?php if ($editresult['transferType'] == '3') { ?> selected="selected" <?php } ?>>VIP</option>

				<option value="4" <?php if ($editresult['transferType'] == '4') { ?> selected="selected" <?php } ?>>Ticket Only</option>
				
			</select>

			</label>

		</div>
	</td>

			<td width="10%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div class="gridlable">&nbsp;</div>
						<select id="defaultWise3" name="defaultWise3" class="gridfield" autocomplete="off"  >
							<option value="2">All Sightseeing</option>
							<option value="1" >Default Sightseeing</option>
						</select>
					</label>
				</div>
			</td>
			<td width="auto" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div  class="HeadingBOL">Sightseeing Name</div>
						<input name="activityName" type="text" class="gridfield " id="activityName" placeholder="Enter Keyword " value="<?php echo urldecode($_REQUEST['activityName']); ?>" />
					</label>
		  		</div>							
		 	</td> 
			<td width="8%" align="left" valign="middle">
				<input name="quotationId3" type="hidden" id="quotationId3" value="<?php echo  $quotationData['id']; ?>">
			    <button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchactivityfunction();"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   </button></td>
			</tr>
	</tbody></table>
		</form>
	</div>
	<div style="background-color:#feffbc; padding:0px; display:none;" id="loadsaveactivity" ></div>
	<div style="background-color:#f7f7f7; padding:10px;" id="loadactivitysearch" ></div>
	<script>
		// guide BOX
		//loadsearchactivityfunction();
		function loadsearchactivityfunction(){
			var startDayId = encodeURI($('#startDayId3').val());
			var endDayId = encodeURI($('#endDayId3').val());
			var defaultWise = encodeURI($('#defaultWise3').val());

			var destinationId = encodeURI($('#destinationId3').val());
			var destWise = encodeURI($('#destWise3').val());
			var ActransferType = encodeURI($('#ActransferType').val());
			var activityName = encodeURI($('#activityName').val());

			var dayId = encodeURI(<?php echo ($_REQUEST['dayId']>0)?$_REQUEST['dayId']:0; ?>);
			var quotationId = encodeURI($('#quotationId3').val());

			$('#loadactivitysearch').load('loadactivitysearch.php?startDayId='+startDayId+'&endDayId='+endDayId+'&defaultWise='+defaultWise+'&destinationId='+destinationId+'&destWise='+destWise+'&dayId='+dayId+'&quotationId='+quotationId+'&transferType='+ActransferType+'&activityName='+activityName);
		}

		function addguidetoquotations(dmcId,serviceId,totalDays,tableN){
			var quotationId = encodeURI($('#quotationId3').val());
			var destinationId = encodeURI($('#destinationId3').val());
			var noOfVehicles = encodeURI($('#noOfVehicles'+dmcId).val());
			var slabId = encodeURI($('#slabId3'+dmcId+serviceId).val());
			var dayId = encodeURI(<?php echo ($_REQUEST['dayId']>0)?$_REQUEST['dayId']:0; ?>);
			if(serviceId>0 && dayId>0){
				$('#loadsaveactivity').load('loadsaveactivity.php?add=yes&dmcId='+dmcId+'&serviceId='+serviceId+'&quotationId='+quotationId+'&slabId='+slabId+'&destinationId='+destinationId+'&dayId='+dayId+'&tableN='+tableN+'&totalDays='+totalDays+'&noOfVehicles='+noOfVehicles);
			}else{
				alert('All fields are required.');
			}
		}
		function selectthisE(ele,tblN){
			$('#selectBtnE'+ele+tblN).html('&nbsp;Selected');
			$('#selectBtnE'+ele+tblN).removeAttr('onclick');
			$('#selectBtnE'+ele+tblN).css('background-color','#d88319');
		}
	</script>
	<?php
}
 
if($_REQUEST['action'] == 'addServiceEntrance' && $_REQUEST['dayId']!=''  ){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	$day1 = 1;
	$dayQuery1=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'"  and addstatus=0  order by id asc');
	while($dayData1 = mysqli_fetch_array($dayQuery1)){
		if(strip($dayData1['id']) == $_REQUEST['dayId']){ break; }
		$day1++;
	}
	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	$nation=GetPageRecord('*','nationalityMaster','id ="'.$queryData['nationality'].'"');
	$nationData=mysqli_fetch_array($nation);
	
	if($nationData['countryId'] == $defaultCountryId || ($nationData['countryId'] == 0 && $nationData['name'] == 'Local')){
		$nationType = 'Local';
	}else if($nationData['countryId'] == 0 && $nationData['name'] == 'Foreign'){
		$nationType = 'Foreign';	
	}else if($nationData['countryId'] == 0 && $nationData['name'] == 'Bimstec'){
		$nationType = 'Bimstec';	
	}else{
		$nationType = 'Local';
	}

	if($nationData['countryId'] == $defaultCountryId || ($nationData['countryId'] == 0 && $nationData['name'] == 'Local')){
		$nationType = 'Local';
	}else if($nationData['countryId'] != $defaultCountryId || ($nationData['countryId'] == 0 && $nationData['name'] == 'Foreign')){
		$nationType = 'Foreign';	
	}else if($nationData['countryId'] == 0 && $nationData['name'] == 'Bimstec'){
		$nationType = 'Bimstec';	
	}else{
		$nationType = 'Local';
	}
	?>

<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>

 	<div class="inboundheader" > Add Monument &nbsp;&nbsp;Pax&nbsp;Nationality: <?php echo $nationType ?> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i></div>
		<div class="addeditpagebox addtopaboxlist" style="display:nonec;padding:10px">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
			<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="tablesorter gridtable">
			  	<tr style="background-color:transparent !important;">
				    <td width="15%" align="left" valign="top">
				    	<div class="griddiv" style="position:static;">
							<label>
								<div class="HeadingBOL">Location Type</div>
								<select id="destWise2" name="destWise2" class="gridfield validate" onChange="getdestWise();" autocomplete="off" >
									<option value="1">Selected Destination</option>
									<option value="2">All Destinations</option>
								</select>
							</label>
							<script>
							function getdestWise(){
								if($('#destWise2').val()==2){
									$('#destinationId2').load('loadAllDestinations.php');
								}
								if($('#destWise2').val()==1){
									$('#destinationId2').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
								}
							}
						  </script>
						  <style>
							.select2-selection--single {
								display: inline-block !important;
								outline: 0px;
								padding-bottom: 0px;
								width: 100%;
								background-color: #FFFFFF !important;
								font-size: 14px;
								border: 1px #e0e0e0 solid !important;
								box-sizing: border-box !important;
								height: auto !important;
								padding: 2px;
								margin-top: 4px;
								border-radius: 2px !important;
							}
							.select2-container--default .select2-selection--single .select2-selection__arrow {
							top: 9px !important;
							}
						  </style>
				    	</div>
					</td>
				    <td width="15%" align="left" valign="top">
						<!-- select destination -->
						<div class="griddiv" style="position:static;">
						<label>
						<div class="HeadingBOL">Destination</div>
						<select id="destinationId2" name="destinationId2" class="gridfield validate select2" displayname="Select Destination" autocomplete="off"   >
						<?php
						$day=1;
						$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and cityId="'.$cityId.'"  group by cityId  order by id asc');
						while($QueryDaysData=mysqli_fetch_array($a)){
						?>
						<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
						<?php
						$day++;
						} ?>
						</select>
						</label>
						</div>				
					</td>
				    <td width="10%" align="left" valign="top">
				    	<div class="griddiv" style="position:static;">
							<label>
								<div class="HeadingBOL">Transfer Type</div>
								<select id="transferType2" name="transferType2" class="gridfield validate" autocomplete="off"  >
								<option value="">Select</option>
								<option value="3">Ticket Only</option>
								<option value="1">SIC</option>
								<option value="2">PVT</option>
								</select>
							</label>
				    	</div>
					</td> 
					
					<td width="10%" align="left" valign="top" >
						<div class="griddiv" style="position:static;"><label>
							<div class="HeadingBOL">From Day</div>
							<select id="startDay2" name="startDay2" class="gridfield validate" displayname="Start Day" autocomplete="off"   >
							<?php
							$day = $day1;
							$starDayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and id >= "'.$dayData['id'].'"  order by srdate asc');
							while($QueryDaysData=mysqli_fetch_array($starDayQuery)){
								if($cityId==$QueryDaysData['cityId']){
								?>
								<option value="<?php echo strip($QueryDaysData['id']); ?>"  <?php if(strip($QueryDaysData['id']) == $_REQUEST['dayId']){ ?>  selected="selected" <?php } ?> >Night <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
								<?php
								} else{
									break;
								}
								$day++;
							} ?>
							</select>
							</label>
					  </div>
				  	</td>
				  	<td width="10%" align="left" valign="top" >
					  	<div class="griddiv" style="position:static;">
						  	<label>
								<div class="HeadingBOL">To Day</div>
								<select id="endDay2" name="endDay2" class="gridfield validate" displayname="End Day" autocomplete="off"   >
								<?php
								$day = $day1;
								$starDayQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0   and id >= "'.$dayData['id'].'" order by srdate asc');
								while($QueryDaysData=mysqli_fetch_array($starDayQuery)){
									if($cityId==$QueryDaysData['cityId']){
									?>
									<option value="<?php echo strip($QueryDaysData['id']); ?>"  <?php if(strip($QueryDaysData['id']) == $_REQUEST['dayId']){ ?>  selected="selected" <?php } ?> >Night <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
									<?php
									} else{
										break;
									}
									$day++;
								}
								?>
							</select>
							</label>
					  	</div>
				  	</td> 
				  	<td width="10%" align="left" valign="top">
				    	<div class="griddiv" style="position:static;">
							<label>
								<div class="gridlable">&nbsp;</div>
								<select id="defaultWise2" name="defaultWise2" class="gridfield validate" autocomplete="off"  >
								<option value="0">All Entrance</option>
								<option value="1">Default Entrance</option>
								</select>
							</label>
				    	</div>
					</td> 
					<td  align="left" valign="top">
						<div class="griddiv" style="position:static;margin-bottom: 0;"><label>
							<div style="width:100%;" class="HeadingBOL">Search..</div>
							<input name="entranceName2" type="text" class="gridfield " id="entranceName2" placeholder="Search Monument"  displayname="Monument Name" value="<?php echo urldecode($_REQUEST['entranceName']); ?>" />
							</label>
					  	</div>	
					</td>
					<td width="10%" align="left" valign="top" valign="middle">
						<br>

						<!-- comment this -->
			    		<!-- <button type="button"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchentrancefunction();"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   </button></td> -->
					    <!-- <input type="button" name="Submit" value="   Search   " class="bluembutton"  style="margin-top:6px;" onclick="loadsearchentrancefunction();"> -->


						<!-- add this  -->
						<button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchentrancefunction();">
						<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
						</button>
					</td>
				</tr>
				
			</table>
		</form>
		<script src="plugins/select2/select2.full.min.js"></script>
		<script>
		$(document).ready(function() {
		$('.select2').select2();
		});
		</script>
		<style>
		.select2-container--open{
		z-index: 9999999999 !important;
		width: 100%;
		}

		.select2-container {
		box-sizing: border-box;
		display: inline-block;
		margin: 0;
		position: relative;
		vertical-align: middle;
		width: 100% !important;
		}
		</style>

		</div>
		<div style="background-color:#feffbc; padding:0px; display:none;" id="loadentrancesaveentrance" ></div>
		<div style="background-color:#f7f7f7; " id="loadentrancesearch" ></div>
		<script>
			// ENTRANCE BOX
			// loadsearchentrancefunction();
			function loadsearchentrancefunction(){ 
				var destinationId =$('#destinationId2').val(); 
				var destWise =$('#destWise2').val(); 
				var startDayId = encodeURI($('#startDay2').val());
				var endDayId = encodeURI($('#endDay2').val());
				var transferType = encodeURI($('#transferType2').val());
				var defaultWise = encodeURI($('#defaultWise2').val());
				var entranceName =  $('#entranceName2').val(); 
				$('#loadentrancesearch').load('loadentrancesearch.php?entranceName='+encodeURI(entranceName)+'&destinationId='+destinationId+'&transferType='+transferType+'&defaultWise='+defaultWise+'&destWise='+destWise+'&startDayId='+startDayId+'&endDayId='+endDayId+'');
			}

			function addentrancetoquotations(entranceId,dmcId,tableN,cityId,isopen){
				if(isopen==0){ 
					if(entranceId!='' && cityId!=''){
 						var startDayId = encodeURI($('#startDay2').val());
 						var noOfVehicle = encodeURI($('#noOfVehicle'+dmcId).val());
						var endDayId = encodeURI($('#endDay2').val());
						var transferType = encodeURI($('#transferType2').val());
						$('#loadentrancesaveentrance').load('loadsaveentrance.php?action=addedit_QuotationEntrance&add=yes&entranceId='+entranceId+'&dmcId='+dmcId+'&tableN='+tableN+'&cityId='+cityId+'&transferType='+transferType+'&startDayId='+startDayId+'&endDayId='+endDayId+'&noOfVehicle='+noOfVehicle+'&calculationType=<?php echo $quotationData['calculationType'];?>');
						selectthis('#selectthis'+dmcId);
					}else{
						alert('All fields are required.');
					}
				}else{
					// alert('Monument is remain closed on every <?php echo date('l', strtotime($dayData['srdate'])); ?>...!');



					let text = "<Monument> is remain closed on every <?php echo date('l', strtotime($dayData['srdate'])); ?>...!\n Do you still want to add";
					// confirm('' );
					
					if (confirm(text) == true) {
						var startDayId = encodeURI($('#startDay2').val());
						var endDayId = encodeURI($('#endDay2').val());
						var transferType = encodeURI($('#transferType2').val());
						$('#loadentrancesaveentrance').load('loadsaveentrance.php?action=addedit_QuotationEntrance&add=yes&entranceId='+entranceId+'&dmcId='+dmcId+'&tableN='+tableN+'&cityId='+cityId+'&transferType='+transferType+'&startDayId='+startDayId+'&endDayId='+endDayId+'');
						selectthis('#selectthis'+dmcId);
					} else {
						"You canceled!";
					}
					
				}
			}
		</script>
	<?php

}




// Transfer edit start 
if($_REQUEST['action'] == 'editQuotationTransferRate' && $_REQUEST['transferQuoteId'] != ''){


	$dQuery2='';
	$dQuery2=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'id="'.$_REQUEST['transferQuoteId'].'"');
	$qActData2=mysqli_fetch_array($dQuery2);
	$destinationId = $qActData2['destinationId']; 

	$gstValue=getGstValueById($qActData2['gstTax']); 
	$quotationId=$qActData2['quotationId']; 
	$perPaxCostWithGst = $qActData2['perPaxCost']; 
	$vehicleCost = $qActData2['vehicleCost'];
	$noOfVehicles = $qActData2['noOfVehicles']; 
	$transferId = $qActData2['transferId']; 
	$adultCost = $qActData2['adultCost']; 
	$childCost = $qActData2['childCost']; 
	$infantCost = $qActData2['infantCost'];
	$totalPax = $qActData2['totalPax'];
	$paxSlab = $qActData2['paxSlab']; 
	$vehicleType = $qActData2['vehicleType'];

	$representativeEntryFee = $qActData2['representativeEntryFee'];
	$parkingFee = $qActData2['parkingFee'];
	$assistance = $qActData2['assistance'];
	$guideAllowance = $qActData2['guideAllowance'];
	$interStateAndToll = $qActData2['interStateAndToll'];
	$miscellaneous = $qActData2['miscellaneous'];

	$vehicleType = $qActData2['vehicleType'];
	$TransferSupplierId = $qActData2['supplierId'];
	$transferType = $qActData2['transferType'];

	$transferNameId = $qActData2['transferNameId'];

	$perPaxCostWithoutGst = $perPaxCostWithGst / (1 + $gstValue/100); 

	$cityName = getCityNameByDayId($qActData2['dayId']);
	
    // Transfer data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$qActData2['transferNameId'].'"');
	$activityData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$activityData['transferName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
		<div class="addeditpagebox addtopaboxlist">	
<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  	<tr style="background-color: transparent !important;">
		<td width="150"  align="left">
		<div class="griddiv" style="border-bottom: 0px #eee solid;"><label>

				<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
				<select id="TransferSupplierId" name="TransferSupplierId3" class="gridfield validate" displayname="Suppliers" autocomplete="off" style=" width:150px;"  >  
				<?php 
				$where='status=1 and deletestatus=0 and name!="" and transferType=5 '.$whereDest.' order by name asc';  
				$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
				while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
				<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$TransferSupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
				<?php  } ?>
				</select>

				</label>
				</div>  
		</td>    
<?php 
// if($transferType==2){
?>
  	<td width="150" align="left">
  		<script>
			function showmaxpax(){
			var vehicleId = $('#vehicleId').val();
			//$('#maxpaxbox').load('loadmaxpaxdmcbox.php?id='+vehicleId);
			}
		</script>
		<div class="griddiv"><label>
			<div class="gridlable">Vehicle&nbsp;Type</div>
			<select id="vehicleTypeId2" name="vehicleTypeId2" class="gridfield"  autocomplete="off" style="width: 100%;" >
			<?php    
			$rs=GetPageRecord('name,id','vehicleTypeMaster',' 1 and status=1 and deletestatus=0 and name!="" order by name asc'); 
			while($editVehicleTypeData=mysqli_fetch_array($rs)){  
			?>
			<option value="<?php echo strip($editVehicleTypeData['id']); ?>" <?php if($editVehicleTypeData['id']==$vehicleType){ ?>selected="selected"<?php } ?>><?php echo strip($editVehicleTypeData['name']); ?></option>
			<?php } ?> 
		 	</select>
			</label>
		</div>
	</td>
<?php
//  } 
?>

	<!-- <td width="150" align="left" >
	<script type="text/javascript">
	// getVehicleModel(<?php echo $vehicleTypeId; ?>);
	function getVehicleModel(vehicleTypeId) {
		$("#vehicleModelId2").load('loadvehiclemodel.php?action=loadVehicleModel&vehicleTypeId='+vehicleTypeId);
	}
	</script>
	<div class="griddiv"><label>
	<div class="gridlable">Vehicle&nbsp;Name</div>
	<select id="vehicleModelId2" name="vehicleModelId3" class="gridfield"  autocomplete="off" style="width: 100% ;">  
	<?php 
	$select='*';    
	 $where=' 1 and status=1 and deletestatus=0 order by name asc';  
	$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 
	while($editVehicleMData=mysqli_fetch_array($rs)){  
	?>
	<option value="<?php echo $editVehicleMData['id']; ?>" <?php if($editVehicleMData['id']==$vehicleModelId){ ?>selected="selected"<?php } ?>><?php echo $editVehicleMData['model']; ?></option>
	<?php } ?>
	</select>
	</label>
	</div></td> -->


	<td width="100" align="left"><div class="griddiv">
		<label> 
		<div class="gridlable">TAX&nbsp;SLAB (%)<span class="redmind"></span></div>
		
		<select id="gstTax" name="gstTax3" class="gridfield " displayname="GST Tax" autocomplete="off" style="width: 100% !important;"> 
		<?php 
		$rs2="";
		$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Transfer" and status=1 order by gstSlabName asc'); 
		while($gstSlabData=mysqli_fetch_array($rs2)){
		?>
		<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$qActData2['gstTax']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
		<?php
		}	
		?>
		</select>
		</label>
		</div>
	</td>
	<td width="100"  align="left">
		<div class="griddiv">
			<label>  
			<div class="gridlable">Pax Slab<span class="redmind"></span></div>
			<select name="totalPax2" id="totalPax2" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
			<?php
			$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
			while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
				if($totalPaxData['fromRange']==$totalPaxData['toRange']){
					$paxName=$totalPaxData['fromRange'].' Pax';
				}else{
					$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
				} 
				?> 
				<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
				<?php 
			} ?>
			</select>
			</label>
		</div>		
	</td>

	<td width="100" align="left"><div class="griddiv">
		<label>
		<div class="gridlable">Tarif&nbsp;Type<span class="redmind"></span></div>
		<select id="tarifType" name="tarifType3" class="gridfield" displayname="Tarif Type" autocomplete="off" >
			<option value="1" <?php if('1'==$qActData2['tarifType']){ ?>selected="selected"<?php } ?>>Normal</option>
			<option value="2" <?php if('2'==$qActData2['tarifType']){ ?>selected="selected"<?php } ?>>Weekend</option>
		</select>
		</label>
		</div>
	</td>
	<td width="100" align="left" >
		<div class="griddiv">
		<label> 
		<div class="gridlable">Type<span class="redmind"></span></div>
		<select id="transferType" name="transferType3" class="gridfield validate" displayname="Transfer Type" onchange="selectTransferType3(this.value);"> 
		 <option value="1" <?php if($transferType=='1'){ ?>selected="selected"<?php } ?>>SIC</option>
		<option value="2" <?php if($transferType=='2'){ ?>selected="selected"<?php } ?>>PVT</option>
		</select>
		</label>
		</div>	
	</td>
	<td width="100" align="left">
		<div class="griddiv">
			<label>  
			<div class="gridlable">Currency<span class="redmind"></span></div>
			<select name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"  onchange="getROE(this.value,'currencyVal122');"    >
			 <option value="">Select</option>
				<?php 
				$currencyId = ($qActData2['currencyId']>0)?$qActData2['currencyId']:$baseCurrencyId;
				$currencyValue = ($qActData2['currencyValue']>0)?$qActData2['currencyValue']:getCurrencyVal($currencyId);
				$select=''; 
				$where=''; 
				$rs='';  
				$select='*';    
				$where=' deletestatus=0 and status=1 order by name asc';  
				$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
				while($resListing=mysqli_fetch_array($rs)){   
				?>
				<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
				<?php } ?>
				</select>
			</label>
		</div>			
	</td> 
	<td width="100"  align="left">
		<div class="griddiv" >
		<label> 
			<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
			<input class="gridfield validate" name="currencyValue3" displayname="ROI Value"  id="currencyVal122" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
		</label>
		</div>
	</td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
<tr style="background-color: transparent !important;">
	<td width="100" align="left"  class="PVT3" ><div class="griddiv"><label>
		<div class="gridlable">Vehicle&nbsp;Cost </div>
		<input name="vehicleCost" type="text" class="gridfield"  id="vehicleCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $vehicleCost; ?>" />
		</label>
		</div>
	</td>

	<td width="100" align="left"  class="PVT33" ><div class="griddiv"><label>
		<div class="gridlable">No. of Vehicle</div>
		<input name="noOfVehicles" type="text" class="gridfield"  id="noOfVehicles" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $noOfVehicles; ?>" />
		</label>
		</div>
	</td>
	<td align="left" width="100"><div class="griddiv"><label>
		<div class="gridlable">Rep.&nbsp;Cost</div>
		<input name="representativeEntryFee" type="text" class="gridfield"  id="representativeEntryFee" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $representativeEntryFee; ?>" />
		</label>
		</div>
	</td>
	  	
	<td width="70" align="left" class="SIC3"><div class="griddiv"><label>
		<div class="gridlable">Adult&nbsp;Cost</div>
		<input name="adultCost" type="text" class="gridfield"  id="adultCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $adultCost; ?>" />
		</label>
		</div>
	</td> 
  	<td width="70" align="left" class="SIC3"><div class="griddiv"><label>
		<div class="gridlable">Child&nbsp;Cost</div>
		<input name="childCost" type="text" class="gridfield"  id="childCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $childCost; ?>" />
		</label>
		</div>
	</td>  
  	<td width="70" align="left" class="SIC3"><div class="griddiv"><label>
		<div class="gridlable">Infant&nbsp;Cost</div>
		<input name="infantCost" type="text" class="gridfield"  id="infantCost" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $infantCost; ?>" />
		</label>
		</div>
	</td> 
  
	<td width="70" align="left" class="PVT3"><div class="griddiv"><label>
		<div class="gridlable">Parking&nbsp;Fee</div>
		<input name="parkingFee" type="text" class="gridfield"  id="parkingFee" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $parkingFee; ?>" />
		</label>
		</div>
	</td> 
  	  <td align="left" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Assistance</div>
	<input name="assistance" type="text" class="gridfield"  id="assistance" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $assistance; ?>" />
	</label>
	</div></td>
  	  <td align="left" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Additional&nbsp;Allowance</div>
	<input name="guideAllowance" type="text" class="gridfield"  id="guideAllowance" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $guideAllowance; ?>" />
	</label>
	</div></td>
  	  <td align="left" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Inter&nbsp;State&nbsp;&&nbsp;Toll </div>
	<input name="interStateAndToll" type="text" class="gridfield"  id="interStateAndToll" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $interStateAndToll; ?>" />
	</label>
	</div></td>
  	  <td align="left" width="70" class="PVT3"><div class="griddiv"><label>
	<div class="gridlable">Misc. Cost</div>
	<input name="miscellaneous" type="text" class="gridfield"  id="miscellaneous" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $miscellaneous; ?>" />
	</label>
	</div></td>
	</tr>
	<tr>
	<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($qActData2['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($qActData2['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $qActData2['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td> 
  	  <td align="left" width="70" colspan="10" ><div class="griddiv" ><label>
	<div class="gridlable">Remarks </div>
	<input name="detail3" type="text" class="gridfield"  id="detail" maxlength="220"   style="width: 100%;" value="<?php echo $qActData2['detail']; ?>"/>
	</label>
	</div></td>
	 <td align="left" >
		
	 <!-- <input type="button" name="Submit" value=" Save " class="bluembutton"  onclick="formValidation('addhotelroomprice2222','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;"> -->
		<input name="fromDatetrn3" type="hidden" id="fromDate" value="<?php echo $newQuotationData['srdate']; ?>"> 
		<input name="toDatetrn3" type="hidden" id="toDate" value="<?php echo $newQuotationData['srdate']; ?>"> 
		<input name="quotationId3" type="hidden" id="quotationId" value="<?php echo $newQuotationData['quotationId']; ?>"> 
		<input name="queryId3" type="hidden" id="queryId" value="<?php echo $newQuotationData['queryId']; ?>"> 
		<input name="transferNameId3" type="hidden" id="transferNameId" value="<?php echo $transferId; ?>"> 
		<input name="tariffId3" type="hidden" id="tariffId" value="<?php echo $qActData2['id']; ?>">
		<input name="tableN3" type="hidden" id="tableN" value="<?php echo $_REQUEST['tableN']; ?>">
		<!-- <input name="action" type="hidden" id="action" value="addTransferPriceforQuotaion"></td> -->
		<!-- <input type="hidden" name="transferType" id="transferType" value="2"> -->
		<input type="hidden" id="status" name="status3"  value="1">
		<input type="hidden" id="marketType" name="marketType3"  value="<?php echo $marketId; ?>">
		<input type="hidden" id="capacity" name="capacity3"  value="<?php echo $capacity; ?>">
		<input type="hidden" id="status" name="status3"  value="1">

		<input type="hidden" id="status" name="status3"  value="1">

		<input name="activityQuoteId2" type="hidden" id="activityQuoteId2" value="<?php echo $qActData2['id']; ?>" />
		<input name="action" type="hidden" id="action" value="saveQuotationTransfer" />
  	  </tr>
  	
	</tbody>
	</table>

</form>
</div>
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 


	<script>
 $(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');
}); 
	function selectTransferType3(transferType){
		if(transferType == 1){
			$('.SIC3').css('display','table-cell');
			$('.PVT3').css('display','none');
		}else{
			$('.PVT3').css('display','table-cell');
			$('.SIC3').css('display','none');
		}
	}
selectTransferType3(<?php echo trim($transferType); ?>);
</script>
<style>
.SIC3{display:none;}
.PVT3{display:none;}
</style>


	<?php
} 
if($_REQUEST['action'] == 'saveQuotationTransfer' && $_REQUEST['activityQuoteId2'] != ''){  

	$vehicleCost=0;
		$vehicleCost= $_REQUEST['vehicleCost'];
		$noOfVehicles= $_REQUEST['noOfVehicles'];


		$adultCost= $_REQUEST['adultCost'];
		$childCost= $_REQUEST['childCost'];
		$infantCost= $_REQUEST['infantCost'];


		$representativeEntryFee= $_REQUEST['representativeEntryFee'];
		$parkingFee= $_REQUEST['parkingFee'];
		$assistance= $_REQUEST['assistance'];
		$guideAllowance= $_REQUEST['guideAllowance'];
		$interStateAndToll= $_REQUEST['interStateAndToll'];
		$miscellaneous= $_REQUEST['miscellaneous'];

		$TransferSupplierId= $_REQUEST['TransferSupplierId3'];
		$markupCost= $_REQUEST['markupCost'];
		$markupType= $_REQUEST['markupType'];
	


		$gstTax= $_REQUEST['gstTax3'];
		$totalPax2= $_REQUEST['totalPax2'];
		// $vehicleType= $_REQUEST['vehicleTypeId2'];

		// representativeEntryFee,parkingFee,assistance,guideAllowance,interStateAndToll,miscellaneous
	

		
		


		//noOfVehicles
		$namevalue ='transferName="'.$_REQUEST['transferNameId'].'",vehicleCost="'.$vehicleCost.'",noOfVehicles="'.$noOfVehicles.'",adultCost="'.$adultCost.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",representativeEntryFee="'.$representativeEntryFee.'",parkingFee="'.$parkingFee.'",assistance="'.$assistance.'",guideAllowance="'.$guideAllowance.'",interStateAndToll="'.$interStateAndToll.'",miscellaneous="'.$miscellaneous.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",supplierId="'.$TransferSupplierId.'",gstTax="'.$gstTax.'",totalPax="'.$totalPax2.'",vehicleType="'.$_REQUEST['vehicleTypeId2'].'"';
		$updatelist = updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue,'id="'.($_REQUEST['activityQuoteId2']).'"');
		?>
		<script>
		// warningalert('Transfer Updated!');
		// loadquotationmainfile();
	
			parent.$('#pageloading').hide(); 
			parent.$('#pageloader').hide(); 
			parent.warningalert('Transfer Rate Updated!');
			parent.closeinbound();
			parent.loadquotationmainfile();
		</script>
		</script>
		<?php
} 

// Transfer edit end





// Transport edit start 
if($_REQUEST['action'] == 'editQuotationTransportRate' && $_REQUEST['transportQuoteId'] != ''){


	$dQuery2='';
	$dQuery2=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'id="'.$_REQUEST['transportQuoteId'].'"');
	$qActData2=mysqli_fetch_array($dQuery2);
	$destinationId = $qActData2['destinationId']; 

	$gstValue=getGstValueById($qActData2['gstTax']); 
	$quotationId=$qActData2['quotationId']; 
	$perPaxCostWithGst = $qActData2['perPaxCost']; 
	$vehicleCost = $qActData2['vehicleCost'];
	$noOfVehicles = $qActData2['noOfVehicles']; 
	$transferId = $qActData2['transferId']; 
	$adultCost = $qActData2['adultCost']; 
	$childCost = $qActData2['childCost']; 
	$infantCost = $qActData2['infantCost'];
	$totalPax = $qActData2['totalPax'];
	$paxSlab = $qActData2['paxSlab']; 
	$vehicleType = $qActData2['vehicleType'];
	$transferCostType = $qActData2['costType'];
	

	$representativeEntryFee = $qActData2['representativeEntryFee'];
	$parkingFee = $qActData2['parkingFee'];
	$assistance = $qActData2['assistance'];
	$guideAllowance = $qActData2['guideAllowance'];
	$interStateAndToll = $qActData2['interStateAndToll'];
	$miscellaneous = $qActData2['miscellaneous'];

	// $vehicleType = $qActData2['vehicleType'];
	$SupplierId = $qActData2['supplierId'];
	$capacity = $qActData2['capacity'];

	
	

	$transferNameId = $qActData2['transferNameId'];

	

	$perPaxCostWithoutGst = $perPaxCostWithGst / (1 + $gstValue/100); 

	$cityName = getCityNameByDayId($qActData2['dayId']);
	
    // Transfer data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$qActData2['transferNameId'].'"');
	$activityData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$activityData['transferName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
		
<div class="addeditpagebox addtopaboxlist">	
<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  <tbody> 
  	<tr style="background-color: transparent !important;">
  	   <td width="10%"  align="left">
		<div class="griddiv"><label>

		<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>

		<select id="TransferSupplierId" name="TransferSupplierId3" class="gridfield validate" displayname="Suppliers" autocomplete="off" style=" width:150px;"  >  
			<?php 
			$where='status=1 and deletestatus=0 and name!="" and transferType=5 '.$whereDest.' order by name asc';  
			$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
			while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
				<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$SupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
				<?php  } ?>
		</select>

	</label>
	</div>
	   <div class="griddiv" style="display:none;"> 
		<label> 
		<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div> 
		<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
		<?php   
		$rs=GetPageRecord('*','marketMaster',' deletestatus=0 order by name asc');  
		while($resListing=mysqli_fetch_array($rs)){   
		?> 
		<option value="1" <?php if($resListing['id']==$qActData2['marketType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
		<?php } ?>
		</select></label>  
		</div> 
		<div class="griddiv" style="display:none;">
	<label> 
	<div class="gridlable">Currency<span class="redmind"></span></div>
	<select id="currencyId" name="currencyId" class="gridfield vaidate" displayname="Currency" autocomplete="off"  style="width:100%;"  > 
	<?php 
	$requestedCurr = ($_REQUEST['currencyId']!='')?$_REQUEST['currencyId']:1; 
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	$where=' deletestatus=0 and status=1 order by name asc';  
	$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){
	?>
	<option value="1" <?php if($resListing['id']==$qActData2['currencyId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
	<?php } ?>
	</select>
	</label>
	</div><div class="griddiv" style="display:none;">
	<label> 
	<div class="gridlable">Type <span class="redmind"></span></div>
	<select id="transferType" name="transferType" class="gridfield" displayname="Transfer Type" autocomplete="off" style="width: 100% !important;"> 
	<option value="2" <?php if('2'==$_REQUEST['transferType']){ ?>selected="selected"<?php } ?>>Private</option>
	<!-- <option value="1" <?php if('1'==$_REQUEST['transferType']){ ?>selected="selected"<?php } ?>>SIC</option>-->
	</select>
	</label>
	</div><div class="griddiv" style="display:none;">
	<label>
	<div class="gridlable"> Name<span class="redmind"></span></div>
	<select id="transferNameId" name="transferNameId" class="gridfield validate" displayname="Transfer Name" autocomplete="off" style="width: 150px !important;" > 
	<?php 
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	$where=' id="'.$transferId.'" order by transferName asc';  
	$rs=GetPageRecord($select,_PACKAGE_BUILDER_TRANSFER_MASTER,$where); 
	while($editTransferData=mysqli_fetch_array($rs)){  
	?>
	<option value="<?php echo strip($editTransferData['id']); ?>" ><?php echo strip($editTransferData['transferName']); ?></option>
	<?php } ?>
	</select>
	</label>
	</div> 
	<div class="griddiv" style="display:none;">
	<label> 
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off"   style="width: 100%;"> 	
	<option value="1" <?php if(1==$qActData2['status']){ ?>selected="selected"<?php } ?>>Active</option> 
	</select></label>
	</div></td>    
  	   <td width="100" align="left"><div class="griddiv">
	<label> 
	<div class="gridlable">Type <span class="redmind"></span></div>
	<select id="transferCostType" name="transferCostType" class="gridfield validate" displayname="Transfer Cost Type" autocomplete="off" style="width: 100% !important;" onchange="costType3(this.value);"> 
	<option value="1" <?php if($transferCostType == 1){ ?>selected="selected"<?php } ?>>Per Day Cost</option>
	<option value="2" <?php if($transferCostType == 2){ ?>selected="selected"<?php } ?>>Package Cost</option> 
	<option value="3" <?php if($transferCostType == 3){ ?>selected="selected"<?php } ?>>Per KM Cost</option> 
	</select>
	</label>
	</div></td>
	<td width="100" align="left">
	<div class="griddiv"><label>
	<div class="gridlable">Vehicle&nbsp;Type</div>
	<select id="vehicleTypeId2" name="vehicleTypeId2" class="gridfield" style="width: 100%;" onchange="getVehicleModel(this.value);">
	<?php    
	$rs="";
	$rs=GetPageRecord('*','vehicleTypeMaster','1 and name!="" and status=1 and deletestatus=0 order by name asc'); 
	while($editVehicleTypeData=mysqli_fetch_array($rs)){  ?>
	<option value="<?php echo strip($editVehicleTypeData['id']); ?>" <?php if($editVehicleTypeData['id']==$vehicleType){ ?>selected="selected"<?php } ?>><?php echo strip($editVehicleTypeData['name']); ?></option>
	<?php } ?> 
 	</select>
	</label>
	</div></td>
	
	<td width="85" align="left" class=" "><div class="griddiv"><label>
		<div class="gridlable">Capacity</div>
			<input type="text" class="gridfield" maxlength="6"  value="<?php echo $capacity; ?>" disabled/>
			<input name="capacity" type="hidden" class="gridfield"  id="capacity" value="<?php echo $capacity; ?>"/>
		</label>
		</div>
	</td> 

	<td width="100" align="left"><div class="griddiv">
	<label> 
	<div class="gridlable">Tax <span class="redmind"></span></div>
	<select id="gstTaxttpt" name="gstTaxttpt" class="gridfield" displayname="Tax" autocomplete="off" style="width: 100% !important;"> 
 	<?php  
	$rs2="";
	$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Transfer" and status=1 order by gstSlabName asc'); 
	while($gstSlabData=mysqli_fetch_array($rs2)){
	?>
	<option value="<?php echo $gstSlabData['id']; ?>" <?php if($gstSlabData['id'] == $qActData2['gstTax']){ ?> selected="selected" <?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
	<?php
	}	
	?> 
	</select>
	</label>
	</div></td>

    <td width="100" align="left">
		<div class="griddiv">
			<label>  
			<div class="gridlable">Currency<span class="redmind"></span></div>
			<select name="currencyId3" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'currencyVal121');"    >
			 <option value="">Select</option>
				<?php 
				$currencyId = ($qActData2['currencyId']>0)?$qActData2['currencyId']:$baseCurrencyId;
				$currencyValue = ($qActData2['currencyValue']>0)?$qActData2['currencyValue']:getCurrencyVal($currencyId);
				$select=''; 
				$where=''; 
				$rs='';  
				$select='*';    
				$where=' deletestatus=0 and status=1 order by name asc';  
				$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
				while($resListing=mysqli_fetch_array($rs)){   
				?>
				<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
				<?php } ?>
				</select>
			</label>
		</div>			
	</td> 
	<td width="100"  align="left">
		<div class="griddiv" >
		<label> 
			<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
			<input class="gridfield validate" name="currencyValue3" displayname="ROI Value" id="currencyVal121" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
		</label>
		</div>
	</td>

	<td width="100"  align="left">
		<div class="griddiv">
			<label>  
			<div class="gridlable">Pax Slab<span class="redmind"></span></div>
			<select name="totalPax" id="totalPax" style="width: 90px; border: 1px solid #ccc; padding: 5px 10px;">
			<?php
			$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
			while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
				if($totalPaxData['fromRange']==$totalPaxData['toRange']){
					$paxName=$totalPaxData['fromRange'].' Pax';
				}else{
					$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
				} 
				?> 
				<option value="<?php echo $totalPaxData['id']; ?>"><?php echo $paxName; ?></option>
				<?php 
			} ?>
			</select>
			</label>
		</div>		
	</td>



	</tr>
  	<tr style="background-color: transparent !important;">

  	
	
	<td width="100" align="left"  class="" ><div class="griddiv"><label>
	<div class="gridlable" id="costTypeLable3">Vehicle&nbsp;Cost </div>
	<input name="vehicleCost" type="text" class="gridfield"  id="vehicleCost" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $vehicleCost; ?>" />
	</label>
	</div></td>


	<td width="85" align="left" id="distanceBox3" style="display:none;">
		<div class="griddiv"><label>
			<div class="gridlable">Distance</div>
			<input name="distance" type="text" class="gridfield"  id="distance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $qActData2['distance']; ?>" />
			</label>
		</div>
	</td> 
 
 <td align="left"><div class="griddiv"><label>
	<div class="gridlable">Representative&nbsp;Entry&nbsp;Fee</div>
	<input name="representativeEntryFee" type="text" class="gridfield"  id="representativeEntryFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $representativeEntryFee; ?>" />
	</label>
	</div></td>
	<td align="left" class=" "><div class="griddiv"><label>
	<div class="gridlable">Parking&nbsp;Fee</div>
	<input name="parkingFee" type="text" class="gridfield"  id="parkingFee" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $parkingFee; ?>" />
	</label>
	</div></td> 

  	   <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Additional&nbsp;Allowance</div>
  	    <input name="guideAllowance" type="text" class="gridfield"  id="guideAllowance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $guideAllowance; ?>" />
        </label>
      </div></td>
  	  <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Assistance</div>
  	    <input name="assistance" type="text" class="gridfield"  id="assistance" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $assistance; ?>" />
        </label>
      </div></td>
  	 
  	  <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Inter&nbsp;State&nbsp;&amp;&nbsp;Toll </div>
  	    <input name="interStateAndToll" type="text" class="gridfield"  id="interStateAndToll" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $interStateAndToll; ?>" />
        </label>
      </div></td>

	  <td align="left"><div class="griddiv">
  	    <label>
        <div class="gridlable">Misc. Cost</div>
  	    <input name="miscellaneous" type="text" class="gridfield"  id="miscellaneous" maxlength="6"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $miscellaneous; ?>" />
        </label>
      </div></td>
  	  </tr> 
  	  <tr>

		


	  <td width="100" align="left"  class="" ><div class="griddiv"><label>
		<div class="gridlable">No. of Vehicle</div>
		<input name="noOfVehicles" type="text" class="gridfield"  id="noOfVehicles" maxlength="12"  onkeyup="numericFilter(this);"  style="width: 100%;" value="<?php echo $noOfVehicles; ?>" />
		</label>
		</div>
	</td>


		<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($qActData2['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($qActData2['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $qActData2['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td> 
  	
  	  <td align="left" width="70" colspan="3"><div class="griddiv" >
  	    <label>
        <div class="gridlable">Remarks </div>
  	    <input name="detail" type="text" class="gridfield"  id="detail" maxlength="220"   style="width: 100%;" value="<?php echo $qActData2['detail']; ?>"/>
        </label>
      </div></td>
  	  	<td align="left" colspan="7">
		<!-- <input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addhotelroomprice','saveflight','0');" style="padding: 8px 30px !important; border-radius: 5px !important;"> -->
		<input name="fromDatetrn" type="hidden" id="fromDate" value="<?php echo $newQuotationData['srdate']; ?>"> 
		<input name="toDatetrn" type="hidden" id="toDate" value="<?php echo $newQuotationData['srdate']; ?>">  
		<input name="quotationId" type="hidden" id="quotationId" value="<?php echo $newQuotationData['quotationId']; ?>"> 
		<input name="tariffId" type="hidden" id="tariffId" value="<?php echo $qActData2['id']; ?>">
		<input name="tableN" type="hidden" id="tableN" value="<?php echo $_REQUEST['tableN']; ?>">
		<input name="transferNameId" type="hidden" id="transferNameId" value="<?php echo $transferId; ?>">
		
		<!-- <input name="action" type="hidden" id="action" value="addTransPortationPriceforQuotaion"> -->

		<input type="hidden" id="status" name="status3"  value="1">

		<input name="activityQuoteId2" type="hidden" id="activityQuoteId2" value="<?php echo $qActData2['id']; ?>" />
		<input name="action" type="hidden" id="action" value="saveQuotationTransport" /> 
	</td>
  	  </tr>
	</tbody>
	</table>
</form>
</div>
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 



	<div id="vehicleTypeName"></div>
<script>

	function getVehicleModel(vehicleTypeId) {
	 var vehicleTypeId = $('#vehicleTypeId2').val(); 
	 $("#vehicleTypeName").load('searchaction.php?action=loadVehicleModeltyp&vehicleTypeId='+vehicleTypeId);
	}
 

	function costType3(transferCostType){ 
		if(transferCostType == 3){
			$('#distanceBox3').show();
			$('#costTypeLable3').text('Per KM Cost');
		}else if(transferCostType == 1){
			$('#distanceBox3').hide();
			$('#costTypeLable3').text('Per Day Cost');
		}else{
			$('#distanceBox3').hide();
			$('#costTypeLable3').text('Vehical Cost');
		}
	}

	costType3(<?php echo $transferCostType; ?>);
	getVehicleModel1();
	 
	 $(document).on("input", ".numeric", function() {
	    this.value = this.value.replace(/\D/g,'');
	}); 
 </script>
<style>
.SIC{display:none;}
</style>


	<?php
} 


if($_REQUEST['action'] == 'saveQuotationTransport' && $_REQUEST['activityQuoteId2'] != ''){  

	$vehicleCost=0;
		$vehicleCost= $_REQUEST['vehicleCost'];
		$noOfVehicles= $_REQUEST['noOfVehicles'];

		$adultCost= $_REQUEST['adultCost'];
		$childCost= $_REQUEST['childCost'];
		$infantCost= $_REQUEST['infantCost'];
		$transferCostType= $_REQUEST['transferCostType'];
		// $vehicleType= $_REQUEST['vehicleTypeId2'];
		$vehiclecapacity= $_REQUEST['vehiclecapacity'];

		// transferCostType,vehicleTypeId2,vehiclecapacity

		$representativeEntryFee= $_REQUEST['representativeEntryFee'];
		$parkingFee= $_REQUEST['parkingFee'];
		$assistance= $_REQUEST['assistance'];
		$guideAllowance= $_REQUEST['guideAllowance'];
		$interStateAndToll= $_REQUEST['interStateAndToll'];
		$miscellaneous= $_REQUEST['miscellaneous'];

		$TransferSupplierId= $_REQUEST['TransferSupplierId3'];

		$markupCost= $_REQUEST['markupCost'];
		$markupType= $_REQUEST['markupType'];

		
		
		$gstTaxttpt= $_REQUEST['gstTaxttpt'];
		$totalPax2= $_REQUEST['totalPax'];
		// $vehicleType= $_REQUEST['vehicleTypeId2'];

		// representativeEntryFee,parkingFee,assistance,guideAllowance,interStateAndToll,miscellaneous
	

		
		
		


		//noOfVehicles
		$namevalue ='transferName="'.$_REQUEST['transferNameId'].'",vehicleCost="'.$vehicleCost.'",noOfVehicles="'.$noOfVehicles.'",adultCost="'.$adultCost.'",representativeEntryFee="'.$representativeEntryFee.'",parkingFee="'.$parkingFee.'",assistance="'.$assistance.'",guideAllowance="'.$guideAllowance.'",interStateAndToll="'.$interStateAndToll.'",miscellaneous="'.$miscellaneous.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",supplierId="'.$TransferSupplierId.'",gstTax="'.$gstTaxttpt.'",totalPax="'.$totalPax2.'",vehicleType="'.$_REQUEST['vehicleTypeId2'].'"';
		$updatelist = updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue,'id="'.($_REQUEST['activityQuoteId2']).'"');
		?>
		<script>
		// warningalert('Transfer Updated!');
		// loadquotationmainfile();
	
			parent.$('#pageloading').hide(); 
			parent.$('#pageloader').hide(); 
			parent.warningalert('Transfer Rate Updated!');
			parent.closeinbound();
			parent.loadquotationmainfile();
		</script>
		</script>
		<?php
} 

// Transport edit end




// Guide edit start 
if($_REQUEST['action'] == 'editQuotationGuideRate' && $_REQUEST['GuideQuoteId'] != ''){

	$qActData2='';
	$dQuery2='';
	$dQuery2=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,'id="'.$_REQUEST['GuideQuoteId'].'"');
	$qActData2=mysqli_fetch_array($dQuery2);
	$destinationId = $qActData2['destinationId']; 
	$guideSupplierId = $qActData2['supplierId'];
	$gstValue=getGstValueById($qActData2['gstTax']); 
	$perPaxCostWithGst = $qActData2['perPaxCost']; 

	$perPaxCostWithoutGst = $perPaxCostWithGst / (1 + $gstValue/100); 

	$cityName = getCityNameByDayId($qActData2['dayId']);
	
    // activity data
	$d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$qActData2['guideId'].'"');
	$activityData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$activityData['name']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			
			<div class="addeditpagebox addtopaboxlist">	
<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
  		<tbody> 
		  
	  		<tr  class="tourEscort_cls">
			  <?php 
				if($_REQUEST['serviceType']!= 2){ ?>
					<td width="10%"  align="left">
					<div class="griddiv"><label>
						<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
						<select id="guideSupplierId" name="guideSupplierId" class="gridfield validate" displayname="Suppliers" autocomplete="off" style=" width:150px;"  >  
							<?php 
							$where='status=1 and deletestatus=0 and name!="" and guideType=2 order by name asc';  
							$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
							while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
								<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$guideSupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
							<?php  } ?>
						</select>

						</label>
					</div>
				</td>    
					<?php } ?>
					<?php //if($_REQUEST['serviceType']!= 2){ ?>
		  	<td width="170" align="left" style="min-width:95px; display:none;">
				<div class="griddiv"><label>
				<div class="gridlable">Guide Name</div>
				<select id="guideNameId" name="guideNameId" class="gridfield"  autocomplete="off" style="width: 100%;" >
				<?php    
				$rs=GetPageRecord('name,id',_GUIDE_SUB_CAT_MASTER_,' 1  order by name asc'); 
				while($guideCmpData=mysqli_fetch_array($rs)){  
				?>
				<option value="<?php echo strip($guideCmpData['id']); ?>" <?php if($guideCmpData['id']==$ferryNameId){ ?>selected="selected"<?php } ?>><?php echo strip($guideCmpData['name']); ?></option>
				<?php } ?> 
			 	</select>
				</label>
				</div>
			</td>

            <td width="100" align="left" class="tourEscort_cls"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
	<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php if($qActData2['fromDate']!=''){ echo date('d-m-Y',strtotime($qActData2['fromDate'])); }else{ echo date('d-m-Y',strtotime($dayDate));} ?>"  style="width: 100%;" />
	</label>
	</div></td>
	
	<td width="100" align="left" class="tourEscort_cls"><div class="griddiv">
	<label>
	<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
	<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php if($qActData2['toDate']!=''){ echo date('d-m-Y',strtotime($qActData2['toDate'])); }else{ echo date('d-m-Y',strtotime($dayDate)); }?>" style="width: 100%;"/>
	</label>
	</div></td>


			
			<td width="100" align="left"  class="tourEscort_cls">
				<div class="griddiv">
					<label>
						<div class="gridlable">Pax&nbsp;Range<span class="redmind"></span></div>
						<select id="paxRange" name="paxRange" class="gridfield " autocomplete="off" >
							<option value="0" >All Pax</option>
							<option value="1_5" <?php if($pax >= 1 && $pax <= 5){ ?>selected="selected"<?php } ?>>1-5 Pax</option>
							<option value="6_14" <?php if($pax >= 6 && $pax <= 14){ ?>selected="selected"<?php } ?>>6-14 Pax</option>
							<option value="15_40" <?php if($pax >= 15 && $pax <= 40){ ?>selected="selected"<?php } ?>>15-40 Pax</option>
						</select>
					</label>
				</div>			</td>
			<?php //} ?>
			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Day&nbsp;Type<span class="redmind"></span></div>
						<select id="dayType" name="dayType" class="gridfield " displayname="Day Type" autocomplete="off" >  
							<option value="halfday" <?php if($qActData2['dayType']==='halfday'){ ?> selected="selected" <?php } ?> >Half Day</option>  
							<option value="fullday" <?php if($qActData2['dayType']==='fullday'){ ?> selected="selected" <?php } ?> >Full Day</option> 
						</select>
					</label>
					
				</div></td> 
			<td width="100" align="left" >
				<div class="griddiv">
					<label>
						<div class="gridlable">Universal&nbsp;Cost<span class="redmind"></span></div>
						<select id="universalCost" name="universalCost" class="gridfield " autocomplete="off" onchange="showGuide(this.value);"  >
							<option value="0">Yes</option>
							<option value="1">No</option> 						
						</select> 
					</label>
				</div>			</td>
			<td width="100" align="left" id="guidePorterDiv" style="display:none;">
				<div class="griddiv">
					<label>
						<div class="gridlable">Select&nbsp;Guide/Porter<span class="redmind"></span></div>
						<select id="guidePorterId" name="guidePorterId" class="gridfield " autocomplete="off"   >
							<option value="">None</option>
							<?php
							$rs2=GetPageRecord('*',_GUIDE_MASTER_,' 1 and serviceType = "'.trim($subCatData['serviceType']).'" order by name asc'); 
							while($guideData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $guideData['id']; ?>"><?php echo $guideData['name'];?></option> 
							<?php } ?>
						</select> 
					</label>
				</div>			
			</td> 

			<td width="100" align="left">
				<div class="griddiv">
					<label>  
						<div class="gridlable">Currency<span class="redmind"></span></div>
						<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off"  onchange="getROE(this.value,'currencyVal124');"    >
						<option value="">Select</option>
							<?php 
							$currencyId = ($qActData2['currencyId']>0)?$qActData2['currencyId']:$baseCurrencyId;
							$currencyValue = ($qActData2['currencyValue']>0)?$qActData2['currencyValue']:getCurrencyVal($currencyId);
							$select=''; 
							$where=''; 
							$rs='';  
							$select='*';    
							$where=' deletestatus=0 and status=1 order by name asc';  
							$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
							while($resListing=mysqli_fetch_array($rs)){   
							?>
							<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
							<?php } ?>
							</select>
						</label>
				</div>			
			</td> 
	 
      
		</tr> 
		
		<tr>
		<?php if($_REQUEST['serviceType']== 2){ ?>
			<td width="10%"  align="left">
						<div class="griddiv"><label>
							<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
							<select id="guideSupplierId" name="guideSupplierId" class="gridfield" displayname="Suppliers" autocomplete="off" style=" width:150px;"  > 
							<!-- <option value="">Select&nbsp;Supplier </option>  -->
								<?php 
								$where='status=1 and deletestatus=0 and name!="" and guideType=2 and FIND_IN_SET("'.$destinationId.'",destinationId) order by name asc';  
								$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
								while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
									<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$guideSupplierId){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
								<?php  } ?>
							</select>

							</label>
						</div>
			</td>  
			<?php } ?>
			
			<td width="100"  align="left">
				<div class="griddiv" >
				<label> 
					<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input class="gridfield validate" name="currencyValue" displayname="ROI Value"  id="currencyVal124" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
				</label>
				</div>
			</td>

			<td width="100" align="left" ><div class="griddiv"><label>
				<div class="gridlable" id="guidLable">Guide Cost</div>
				<input name="price" type="text" class="gridfield" oninput="getGuideTotalCost();" id="price" value="<?php echo $qActData2['price'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>

			
			
			<td style="display:none;" width="100" align="left" class="tourEscort_cls2"><div class="griddiv"><label>
				<div class="gridlable">No.&nbsp;Of Days</div>
				<input name="daysNumber" type="text" class="gridfield" readonly id="daysNumber" value="<?php echo $_REQUEST['days']; ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>
			<td style="display:none;" width="100" align="left" class="tourEscort_cls2"><div class="griddiv"><label>
				<div class="gridlable">totalCost</div>
				<input name="totalCost" type="text" class="gridfield" readonly id="totalCost" value="" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>

			<td width="100" align="left" class="tourEscort_cls"><div class="griddiv"><label>
				<div class="gridlable">L.A.</div>
				<input name="languageAllowance" type="text" class="gridfield"  id="languageAllowance" value="<?php echo $qActData2['languageAllowance'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>

			<td width="100" align="left" class="tourEscort_cls"><div class="griddiv"><label>
				<div class="gridlable">Other Cost</div>
				<input name="otherCost" type="text" class="gridfield"  id="otherCost" value="<?php echo $qActData2['otherCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td> 
			<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">GST&nbsp;SLAB(%)</div>
				<select id="guideGST" name="guideGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;">
	      <?php
	      $rs2 = "";
	       $rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Guide"');
	      while ($gstSlabData = mysqli_fetch_array($rs2)) {
	                          ?>
	      <option value="<?php echo $gstSlabData['id']; ?>" <?php if($gstSlabData['id']==$qActData2['gstTax']){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
	       <?php
	      }
	       ?>
	      </select>
				</label>
				</div>
			</td> 


			<td align="left" valign="middle"  style="width: 60px;">
                		<div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1" <?php if($qActData2['markupType']==1){ echo 'selected'; } ?>>%</option>
                        <option value="2" <?php if($qActData2['markupType']==2){ echo 'selected'; } ?>>Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
		
            <td align="left" valign="middle" style="width: 60px;" >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" value="<?php echo $qActData2['markupCost']; ?>" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td> 
                                   
			
			<td width="100" align="left" valign="middle"  >
				<!-- <input type="button" name="Submit" value="   Save   " class="bluembutton"  onclick="formValidation('addguiderate','saveflight','0');">  -->
			  <!-- <input name="action" type="hidden" id="action" value="addQuotationGuidePrice"> -->
			  <input name="serviceType" type="hidden" id="serviceType" value="<?php echo $subCatData['serviceType']; ?>">
			  <input name="serviceid" type="hidden" id="serviceid" value="<?php echo $guideserviceid; ?>">
			  <input name="editId" type="hidden" id="editId" value="<?php echo $editId ; ?>">
			  <input name="quotationId" type="hidden" id="quotationId" value="<?php echo $quotationId ; ?>">
			  <input name="rateId" type="hidden" id="rateId" value="<?php echo $_REQUEST['rateid'] ; ?>">
			  <input name="serviceType2" type="hidden" id="serviceType2" value="<?php echo $_REQUEST['serviceType'] ; ?>">

			  <input name="GuideQuoteId2" type="hidden" id="GuideQuoteId2" value="<?php echo $qActData2['id']; ?>" />
			  <input name="slabId" type="hidden" id="slabId" value="<?php echo $qActData2['slabId']; ?>" />
			<input name="action" type="hidden" id="action2" value="saveQuotationGuideRate" /> 
       </td>
			</tr> 
		</tbody>
	</table>
</form>
</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 
if($_REQUEST['action'] == 'saveQuotationGuideRate' && $_REQUEST['GuideQuoteId2'] != ''){  

	// $gstValue=getGstValueById($_REQUEST['act_gstTax2']); 

	$fromDate=date('Y-m-d',strtotime($_REQUEST['fromDate'])); 
	$toDate=date('Y-m-d',strtotime($_REQUEST['toDate'])); 
	$paxRange=$_REQUEST['paxRange']; 
	$dayType=$_REQUEST['dayType']; 
	
	$languageAllowance=$_REQUEST['languageAllowance']; 
	$otherCost=$_REQUEST['otherCost']; 
	$guideGST=$_REQUEST['guideGST']; 
	$guideSupplierId=$_REQUEST['guideSupplierId']; 

	$markupType=$_REQUEST['markupType']; 
	$markupCost=$_REQUEST['markupCost']; 


	// fromDate,toDate,paxRange,dayType,price,languageAllowance,otherCost


	$namevalue ='supplierId="'.$guideSupplierId.'",perDaycost="'.$_REQUEST['price'].'",price="'.$_REQUEST['price'].'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",paxRange="'.$paxRange.'",dayType="'.$dayType.'",languageAllowance="'.$languageAllowance.'",otherCost="'.$otherCost.'",slabId="'.$_REQUEST['slabId'].'",gstTax="'.$guideGST.'"';
	$updatelist = updatelisting(_QUOTATION_GUIDE_MASTER_,$namevalue,'id="'.($_REQUEST['GuideQuoteId2']).'"');
	
	?>
	<script>
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Guide Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} // Guide edit end






if($_REQUEST['action'] == 'addServiceFlight' && $_REQUEST['dayId']!=''  ){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	$day1 = 1;
	$dayQuery1=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'"  and addstatus=0  order by id asc');
	while($dayData1 = mysqli_fetch_array($dayQuery1)){
		if(strip($dayData1['id']) == $_REQUEST['dayId']){ break; }
		$day1++;
	}
	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$dayData['quotationId'].'" and status=1');
	$escortData=mysqli_fetch_array($escortQuery);
	?>
 	<div class="inboundheader" style="position:relative;">Add Flight 
		<div style="display: initial;margin-left: 30px;">
			<?php if($escortData['foreignEscort']>0 || $escortData['localEscort']>0 ) { ?>
			<input type="checkbox" style="display:initial;" checked name="isGuestType" id="isGuestType">Guest
			<?php }if($escortData['foreignEscort']>0) { ?>
			<input type="checkbox" style="display:initial;" checked name="isForeignEscort" id="isForeignEscort">Foreign&nbsp;Escort <?php } ?>
			<?php if($escortData['localEscort']>0) { ?>
			<input type="checkbox" style="display:initial;" checked name="isLocalEscort" id="isLocalEscort">Local&nbsp;Escort <?php } ?>
		</div>
		<i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i>
	</div>
<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>

	<div class="addeditpagebox addtopaboxlist" style="display:nonec;padding:10px">
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
		<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="tablesorter gridtable">
		  	<tr style="background-color:transparent !important;">
			    
				<td width="15%" align="left">
					<div class="griddiv" style="position:static;">
					<label> 
						<div class="gridlable">&nbsp;</div>
						<select id="destWise2" name="destWise2" class="gridfield validate" onChange="getdestWise2();" autocomplete="off" >
						<option value="1">Selected Destination</option>
						<option value="2">All Destinations</option>
						</select>
					</label>
					<script type="text/javascript">
					  	function getdestWise2(){
							if($('#destWise2').val()==2){
								$('#departureFrom2').load('loadAllDestinations.php');
								$('#arrivalTo2').load('loadAllDestinations.php');
							}
							if($('#destWise2').val()==1){
								$('#departureFrom2').load('loadAllDestinations.php?serviceType=flight&dayId=<?php echo $_REQUEST['dayId']; ?>');
								$('#arrivalTo2').load('loadAllDestinations.php?serviceType=flight&dayId=<?php echo $_REQUEST['dayId']; ?>');
							}
							$('#select2-departureFrom2-container').attr('title','Select');
							$('#select2-departureFrom2-container').text('Select');

							$('#select2-arrivalTo2-container').attr('title','Select');
							$('#select2-arrivalTo2-container').text('Select');
						}
					</script>
				    </div>
				</td>
			    <td width="15%" align="left">
			    	<div class="griddiv" style="position:static;">
			    		<label>
						<div class="HeadingBOL" >Departure&nbsp;From</div>
						<select id="departureFrom2" name="departureFrom2" class="gridfield validate select2" displayname="Departure From" >
							<?php
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0 group by cityId ');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  ><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							} ?>
						</select>
						</label>
					</div>
				</td>
			  	<td width="15%" align="left">
			  		<div class="griddiv" style="position:static;">
			  			<label>
						<div class="HeadingBOL">Arrival&nbsp;To</div>
						<select id="arrivalTo2" name="arrivalTo2" class="gridfield validate select2" displayname="Arrival To" autocomplete="off"   >
						<?php
						$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  group by cityId ');
						while($QueryDaysData=mysqli_fetch_array($a)){ ?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  ><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
						} ?>
						</select>
						</label>
					</div>
				</td>  
				<td align="left" valign="top">
					<div class="griddiv" style="position:static;margin-bottom: 0;"><label>
						<div style="width:100%;" class="HeadingBOL">Search..</div>
						<input name="flightName2" type="text" class="gridfield " id="flightName2" placeholder="Search Flight"  displayname="Flight Name" value="<?php echo urldecode($_REQUEST['flightName']); ?>" />
						</label>
				  	</div>	
				</td>
				<td width="10%" align="left" valign="top" valign="middle">
					<br>
		    		<button style="background:#233a49; color:#fff;" type="button"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchflightfunction();"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   </button>
		    	</td> 
				</td>
			</tr>
			
		</table>
	</form>
	<script src="plugins/select2/select2.full.min.js"></script>
	<script>
	$(document).ready(function() {
	$('.select2').select2();
	});
	</script>
	<style>
		.select2-container--open{
		z-index: 9999999999 !important;
		width: 100%;
		}

		.select2-container {
		box-sizing: border-box;
		display: inline-block;
		margin: 0;
		position: relative;
		vertical-align: middle;
		width: 100% !important;
		}
	</style>

	</div>
	<div style="background-color:#feffbc; padding:0px; display:none;" id="loadflightsaveflight" ></div>
	<div style="background-color:#f7f7f7; " id="loadflightsearch" ></div>
	<script>
		// flight BOX
		loadsearchflightfunction();
		function loadsearchflightfunction(){ 
			var departureFrom =$('#departureFrom2').val(); 
			var destWise =$('#destWise2').val(); 
			var flightName =  $('#flightName2').val(); 
			$('#loadflightsearch').load('loadflightsearch.php?flightName='+encodeURI(flightName)+'&departureFrom='+departureFrom+'&destWise='+destWise+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
		}

		function addflighttoquotations(flightId,dmcId,tableN,cityId){

			var isGuestType = $('#isGuestType2').prop('checked') ? 1 : 0;
			var isLocalEscort = $('#isLocalEscort2').prop('checked') ? 1 : 0;
			var isForeignEscort = $('#isForeignEscort2').prop('checked') ? 1 : 0;

			var departureFrom = $('#departureFrom2').val();
			var arrivalTo = $('#arrivalTo2').val(); 
				
			if(flightId!='' && cityId!=''){
				$('#loadflightsaveflight').load('loadsaveflight.php?action=addedit_Quotationflight&add=yes&flightId='+flightId+'&dmcId='+dmcId+'&tableN='+tableN+'&isGuestType='+isGuestType+'&isLocalEscort='+isLocalEscort+'&isForeignEscort='+isForeignEscort+'&departureFrom='+departureFrom+'&arrivalTo='+arrivalTo+'&cityId='+cityId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
				selectthis('#selectthis'+dmcId);
			}else{
				alert('All fields are required.');
			}
		}  
	</script>
	<?php
}

if($_REQUEST['action'] == 'addServiceTrains' && $_REQUEST['dayId']!=''  ){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	$day1 = 1;
	$dayQuery1=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'"  and addstatus=0  order by id asc');
	while($dayData1 = mysqli_fetch_array($dayQuery1)){
		if(strip($dayData1['id']) == $_REQUEST['dayId']){ break; }
		$day1++;
	}
	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$dayData['quotationId'].'" and status=1');
	$escortData=mysqli_fetch_array($escortQuery);
	?>

<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>
 	<div class="inboundheader" style="position:relative;">Add Train 
		<div style="display: initial;margin-left: 30px;">
			<?php if($escortData['foreignEscort']>0 || $escortData['localEscort']>0 ) { ?>
			<input type="checkbox" style="display:initial;" checked name="isGuestType" id="isGuestType">Guest
			<?php }if($escortData['foreignEscort']>0) { ?>
			<input type="checkbox" style="display:initial;" checked name="isForeignEscort" id="isForeignEscort">Foreign&nbsp;Escort <?php } ?>
			<?php if($escortData['localEscort']>0) { ?>
			<input type="checkbox" style="display:initial;" checked name="isLocalEscort" id="isLocalEscort">Local&nbsp;Escort <?php } ?>
		</div>
		<i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i>
	</div>

	<div class="addeditpagebox addtopaboxlist" style="display:nonec;padding:10px">
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
		<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="tablesorter gridtable">
		  	<tr style="background-color:transparent !important;">
			    
				<td width="15%" align="left">
					<div class="griddiv" style="position:static;">
					<label> 
						<div class="gridlable">&nbsp;</div>
						<select id="destWise2" name="destWise2" class="gridfield validate" onChange="getdestWise2();" autocomplete="off" >
						<option value="1">Selected Destination</option>
						<option value="2">All Destinations</option>
						</select>
					</label>
					<script type="text/javascript">
					  	function getdestWise2(){
							if($('#destWise2').val()==2){
								$('#departureFrom2').load('loadAllDestinations.php');
								$('#arrivalTo2').load('loadAllDestinations.php');
							}
							if($('#destWise2').val()==1){
								$('#departureFrom2').load('loadAllDestinations.php?serviceType=train&dayId=<?php echo $_REQUEST['dayId']; ?>');
								$('#arrivalTo2').load('loadAllDestinations.php?serviceType=train&dayId=<?php echo $_REQUEST['dayId']; ?>');
							}
							$('#select2-departureFrom2-container').attr('title','Select');
							$('#select2-departureFrom2-container').text('Select');

							$('#select2-arrivalTo2-container').attr('title','Select');
							$('#select2-arrivalTo2-container').text('Select');
						}
					</script>
				    </div>
				</td>
			    <td width="15%" align="left">
			    	<div class="griddiv" style="position:static;">
			    		<label>
						<div class="HeadingBOL">Departure&nbsp;From</div>
						<select id="departureFrom2" name="departureFrom2" class="gridfield validate select2" displayname="Departure From" >
							<?php
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0 group by cityId ');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  ><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							} ?>
						</select>
						</label>
					</div>
				</td>
			  	<td width="15%" align="left">
			  		<div class="griddiv" style="position:static;">
			  			<label>
						<div class="HeadingBOL">Arrival&nbsp;To</div>
						<select id="arrivalTo2" name="arrivalTo2" class="gridfield validate select2" displayname="Arrival To" autocomplete="off"   >
						<?php
						$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  group by cityId ');
						while($QueryDaysData=mysqli_fetch_array($a)){ ?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  ><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
						} ?>
						</select>
						</label>
					</div>
				</td> 
				 
				<td align="left" valign="top">
					<div class="griddiv" style="position:static;margin-bottom: 0;"><label>
						<div style="width:100%;" class="HeadingBOL">Search..</div>
						<input name="trainName2" type="text" class="gridfield " id="trainName2" placeholder="Search train"  displayname="train Name" value="<?php echo urldecode($_REQUEST['trainName']); ?>" />
						</label>
				  	</div>	
				</td>
				<td width="10%" align="left" valign="top" valign="middle">
					<br>
		    		<button style="background:#233a49; color:#fff;" type="button"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchtrainfunction();"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   </button>
		    	</td> 
				</td>
			</tr>
			
		</table>
	</form>
	<script src="plugins/select2/select2.full.min.js"></script>
	<script>
	$(document).ready(function() {
	$('.select2').select2();
	});
	</script>
	<style>
		.select2-container--open{
		z-index: 9999999999 !important;
		width: 100%;
		}

		.select2-container {
		box-sizing: border-box;
		display: inline-block;
		margin: 0;
		position: relative;
		vertical-align: middle;
		width: 100% !important;
		}
	</style>

	</div>
	<div style="background-color:#feffbc; padding:0px; display:none;" id="loadtrainsavetrain" ></div>
	<div style="background-color:#f7f7f7; " id="loadtrainsearch" ></div>
	<script>
		// train BOX
		loadsearchtrainfunction();
		function loadsearchtrainfunction(){ 
			var departureFrom =$('#departureFrom2').val(); 
			var destWise =$('#destWise2').val(); 
			var trainName =  $('#trainName2').val(); 
			$('#loadtrainsearch').load('loadtrainsearch.php?trainName='+encodeURI(trainName)+'&departureFrom='+departureFrom+'&destWise='+destWise+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
		}

		function addtraintoquotations(trainId,dmcId,tableN,cityId){

			var isGuestType = $('#isGuestType2').prop('checked') ? 1 : 0;
			var isLocalEscort = $('#isLocalEscort2').prop('checked') ? 1 : 0;
			var isForeignEscort = $('#isForeignEscort2').prop('checked') ? 1 : 0;

			var departureFrom = $('#departureFrom2').val();
			var arrivalTo = $('#arrivalTo2').val();
			if(trainId!='' && cityId!=''){
				$('#loadtrainsavetrain').load('loadsavetrains.php?action=addedit_Quotationtrain&add=yes&trainId='+trainId+'&dmcId='+dmcId+'&tableN='+tableN+'&isGuestType='+isGuestType+'&isLocalEscort='+isLocalEscort+'&isForeignEscort='+isForeignEscort+'&departureFrom='+departureFrom+'&arrivalTo='+arrivalTo+'&cityId='+cityId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
				selectthis('#selectthis'+dmcId);
			}else{
				alert('All fields are required.');
			}
		} 

	</script>
	<?php

} 

if($_REQUEST['action'] == 'addServiceMealPlan' && $_REQUEST['dayId']!=''  ){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	$day1 = 1;
	$dayQuery1=GetPageRecord('*','newQuotationDays',' quotationId="'.$dayData['quotationId'].'"  and addstatus=0  order by id asc');
	while($dayData1 = mysqli_fetch_array($dayQuery1)){
		if(strip($dayData1['id']) == $_REQUEST['dayId']){ break; }
		$day1++;
	}
	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$dayData['quotationId'].'" and status=1');
	$escortData=mysqli_fetch_array($escortQuery);
	?>
 	<div class="inboundheader" style="position:relative;">Add Restaurant 
		<i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>
	</div>

<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>

	<div class="addeditpagebox addtopaboxlist" style="display:nonec;padding:10px">
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
		<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="tablesorter gridtable">
		  	<tr style="background-color:transparent !important;">
			    
				<td width="15%" align="left" valign="top">
			    	<div class="griddiv" style="position:static;">
						<label>
							<div class="HeadingBOL">Location Type</div>
							<select id="destWise2" name="destWise2" class="gridfield validate" onChange="getdestWise();" autocomplete="off" >
								<option value="1">Selected Destination</option>
								<option value="2">All Destinations</option>
							</select>
						</label>
						<script>
						function getdestWise(){
							if($('#destWise2').val()==2){
								$('#destinationId2').load('loadAllDestinations.php');
							}
							if($('#destWise2').val()==1){
								$('#destinationId2').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
							}
						}
					  </script>
					  <style>
						.select2-selection--single {
							display: inline-block !important;
							outline: 0px;
							padding-bottom: 0px;
							width: 100%;
							background-color: #FFFFFF !important;
							font-size: 14px;
							border: 1px #e0e0e0 solid !important;
							box-sizing: border-box !important;
							height: auto !important;
							padding: 2px;
							margin-top: 4px;
							border-radius: 2px !important;
						}
						.select2-container--default .select2-selection--single .select2-selection__arrow {
						top: 9px !important;
						}
					  </style>
			    	</div>
				</td>
			    <td width="15%" align="left" valign="top">
					<!-- select destination -->
					<div class="griddiv" style="position:static;">
					<label>
					<div class="HeadingBOL">Destination</div>
					<select id="destinationId2" name="destinationId2" class="gridfield validate select2" displayname="Select Destination" autocomplete="off"   >
					<?php
					$day=1;
					$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and cityId="'.$cityId.'"  group by cityId  order by id asc');
					while($QueryDaysData=mysqli_fetch_array($a)){
					?>
					<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
					<?php
					$day++;
					} ?>
					</select>
					</label>
					</div>				
				</td>

				<td align="left" valign="top">
					<div class="griddiv" style="position:static;margin-bottom: 0;"><label>
						<div style="width:100%;" class="HeadingBOL">Search..</div>
						<input name="restaurantName2" type="text" class="gridfield " id="restaurantName2" placeholder="Search train"  displayname="train Name" value="<?php echo urldecode($_REQUEST['restaurantName']); ?>" />
						</label>
				  	</div>	
				</td>
				<td width="10%" align="left" valign="top" valign="middle">
					<br>
		    		<button style="background:#233a49; color:#fff;" type="button"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchrestaurantfunction();"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   </button>
		    	</td> 
				</td>
			</tr>
			
		</table>
	</form>
	<script src="plugins/select2/select2.full.min.js"></script>
	<script>
	$(document).ready(function() {
	$('.select2').select2();
	});
	</script>
	<style>
		.select2-container--open{
		z-index: 9999999999 !important;
		width: 100%;
		}

		.select2-container {
		box-sizing: border-box;
		display: inline-block;
		margin: 0;
		position: relative;
		vertical-align: middle;
		width: 100% !important;
		}
	</style>

	</div>
	<div style="background-color:#feffbc; padding:0px; display:none;" id="loadsaverestaurant" ></div>
	<div style="background-color:#f7f7f7; " id="loadrestaurantsearch" ></div>
	<script>
		// restaurant BOX
		loadsearchrestaurantfunction();
		function loadsearchrestaurantfunction(){ 
			var destinationId =$('#destinationId2').val(); 
			var destWise =$('#destWise2').val(); 
			var restaurantName =  $('#restaurantName2').val(); 
			$('#loadrestaurantsearch').load('loadrestaurantsearch.php?restaurantName='+encodeURI(restaurantName)+'&destinationId='+destinationId+'&destWise='+destWise+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
		}

		function addrestauranttoquotations(restaurantId,dmcId,tableN,cityId){
			if(restaurantId!='' && cityId!=''){
				$('#loadsaverestaurant').load('loadsaverestaurants.php?action=addedit_QuotationRestaurant&add=yes&restaurantId='+restaurantId+'&dmcId='+dmcId+'&tableN='+tableN+'&cityId='+cityId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
				selectthis('#selectthis'+dmcId);
			}else{
				alert('All fields are required.');
			}
		} 

	</script>
	<?php
}

// Additional Requirements block starts
if($_REQUEST['action'] == 'addServiceAdditional' && $_REQUEST['dayId']!=''){

	$dayId = $_REQUEST['dayId'];
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	?>
		
	<div class="inboundheader" > Additional  <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #ffffff; cursor:pointer; " onClick="closeinbound();"></i></div>

<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>

	<div class="addeditpagebox addtopaboxlist"style=" padding:0px;">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice3">
				<table width="100%" border="0" cellpadding="8" cellspacing="10" style="margin-top: 20px;">
					<tr>
						<!-- new added fields	 -->
						<td align="left" style="padding: 0px; width: 23%;">
						<div class="griddiv"><label>
						<div class="HeadingBOL" >Destinations<span class="redmind"></span></div>
					<select id="destWise" name="destWise"  class="gridfield validate" displayname="Destination" autocomplete="off" onChange="getdestWise();" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
								<option value="1">Selected Destination</option>
								<option value="2">All Destination</option>
					</select>
						</label>
						<script>
						function getdestWise(){
								if($('#destWise').val()==2){
									$('#destinationId').load('loadadditionaldestination.php?action=allDestination&dayId=<?php echo $_REQUEST['dayId']; ?>');
								}

								if($('#destWise').val()==1){
									$('#destinationId').load('loadadditionaldestination.php?action=selectedDestination&dayId=<?php echo $_REQUEST['dayId']; ?>');
								}

							}
					  </script>

							</div>
						</td>
						<!-- new added destination -->
						
						<td align="left" style="padding: 0px; width: 23%;">
						<div class="griddiv"><label>
							<div class="HeadingBOL">Destination Name<span class="redmind"></span></div>
							<select id="destinationId" name="destinationId" class="gridfield validate select2" displayname="Select Destination" autocomplete="off"   >
								
					<?php
					
					$day=1;
					$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  and cityId="'.$cityId.'"  group by cityId order by id asc');
					while($QueryDaysData=mysqli_fetch_array($a)){
						
					?>
					<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($_REQUEST['dayId']==$QueryDaysData['id']){ ?> selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
					<?php
					$day++;
					} ?>
					</select>
							</label>
							</div>
						</td>
					<td >
					<div class="griddiv" style="position:static;">
						<label>
							<div class="HeadingBOL">Additional Name</div>
						<input type="text" id="additionalName" name="additionalName" class="gridfield" displayname="Additional Name">
						</label>
						</div>
					</td>
						<td style=" width:20%;">

						<!-- comment this -->
						<!-- <button style="background:#233a49; color:#fff;" class="bluembutton" type="button" onclick="SearchAdditionRequirement('<?php echo $dayId; ?>','<?php echo $cityId; ?>','<?php echo $dayData['quotationId']; ?>','<?php echo $dayData['queryId']; ?>');"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp; Search</button> -->


						<!-- add this  -->
						<button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="<?php echo $quotationData['id']; ?>" class="whitembutton searchBtn"  onclick="SearchAdditionRequirement('<?php echo $dayId; ?>','<?php echo $cityId; ?>','<?php echo $dayData['quotationId']; ?>','<?php echo $dayData['queryId']; ?>');">
						<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
						</button>



					</td>

					<td align="left" style="padding: 0px; width: 35%; display:none;">
						<div class="griddiv" style="position:static;">
						<label>
							<div class="gridlable">Additional</div>
							<select id="additionalId2" name="additionalId2" class="gridfield validate" displayname="Additional Name" onchange="getAdditionalCost(this.value)" autocomplete="off" >
							<option value="0">Select </option>
								<?php
								$select='';
								$where='';
								$rs='';
								$select='*';
						
								$wheres=' deletestatus=0 and status=1 order by name asc';
								$rs=GetPageRecord($select,_EXTRA_QUOTATION_MASTER_,$wheres);
								while($resListings=mysqli_fetch_array($rs)){
								?>
								<option value="<?php echo strip($resListings['id']); ?>"><?php echo strip($resListings['name']); ?></option>
								<?php } ?>
							</select>
							<select id="startDay" name="startDay" class="gridfield validate" displayname="Start Day" autocomplete="off" style="display:none;" >
									<?php
									$day=1;
									$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  order by id asc');
									while($QueryDaysData=mysqli_fetch_array($a)){
									if($dayData['cityId']==$QueryDaysData['cityId']){
									?>
									<option value="<?php echo strip($QueryDaysData['id']); ?>,<?php echo date('Y-m-d', strtotime($QueryDaysData['srdate'])); ?>,<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['srdate']==$QueryDaysData['srdate']){ ?>  selected="selected" <?php } ?>>Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
									<?php
									}
									$day++;
									} ?>
						  </select>
						</label>
						</div>					
					</td>
					<td align="left" style="padding: 0px; display:none;">
						<div class="griddiv" style="position:static;">
							<label>
								<div class="gridlable">Cost Type</div>
								<select id="additionalcostType" name="additionalcostType" class="gridfield validate" onchange="selectcost();">
									<option value="1">Per Person</option>
									<option value="2">Total Cost</option>
							 	</select>
							</label>
						</div>					
					</td>
					
					</tr>
					<tr>
					<td align="left" style="padding: 0px; display:none;">
						<div class="griddiv" style="position:static;">
							<label>
								<div class="gridlable">Currency</div>
								<input type="text" id="additionalCurrency" class="gridfield" name="additionalCurrency" value="">
								
							</label>
						</div>					
					</td>

					<td align="left" style="padding: 0px; display:none;">
						<div class="griddiv" style="position:static;">
							<label>
								<div class="gridlable"> Per&nbsp;Pax&nbsp;Cost </div>
								<input name="adultCost" type="text" class="gridfield number_only " id="additionalAdultCost" displayname="Per Pax Cost" value="" />
							</label>
						</div>					
					</td>
					<td align="left"  style="display: none;">
						<div class="griddiv" style="position:static;">
							<label>
								<div class="gridlable">Child Cost </div>
								<input name="childCost" type="text" class="gridfield number_only " id="additionalchildCost" displayname="Per Pax Cost" value="" />
							</label>
						</div>					
					</td>
				 
					<td align="left" class="tot" style="padding: 0px; display:none;">
						<div class="griddiv" style="position:static;">
							<label>
								<div class="gridlable">Group&nbsp;Cost </div>
								<input name="groupCost" type="text" class="gridfield number_only " id="additionalGroupCost" displayname="Group Cost" value="" />
							</label>
						</div>					
					</td>
				
						<td colspan="5" style="background-color: #f7f7f7;">
							<span id="numrowsfound" style="font-size: 16px; font-weight: 500;background-color: #f7f7f7;line-height: 3;"></span>
							<div class="addBtn addBtn2222" onclick="openinboundpop('action=addadditionaltomaster&dayId=<?php echo $_REQUEST['dayId']; ?>&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $queryData['id']; ?>&destinationId=<?php echo $dayData['cityId']; ?>&d=<?php echo $startdatevar; ?>','400px');"> + Add New </div>
					
						</td>
					</tr>
					
					<!-- <td width="79" valign="top" style="padding-left:0px;">
						<input name="queryId" type="hidden" id="queryId" value="<?php echo $queryData['id']; ?>">
						<input name="quotationId" type="hidden" id="quotationId" value="<?php echo  $quotationData['id']; ?>">
						<input type="button" name="Submit" value=" + Add New "class="bluembutton"  style="margin-top:20px;" onclick="openinboundpop('action=addadditionaltomaster&dayId=<?php echo $_REQUEST['dayId']; ?>&quotationId=<?php echo $quotationData['id']; ?>&queryId=<?php echo $queryData['id']; ?>&destinationId=<?php echo $dayData['cityId']; ?>&d=<?php echo $startdatevar; ?>','400px');"></td> -->
						
					
				</table>
			</form>
		</div>

		<script src="plugins/select2/select2.full.min.js"></script>
		<script>
		$(document).ready(function() {
		$('.select2').select2();
		});
		</script>
		<style>

			
			.addBtn2222{
				padding: 8px 12px !important;
				background-color: #7a96ff;
				color: #fff!important;
				font-weight: 500;
				float: right;
			}
		.select2-container--open{
			z-index: 9999999999 !important;
			width: 100%;
		}

		.select2-container {
			box-sizing: border-box;
			display: inline-block;
			margin: 0;
			position: relative;
			vertical-align: middle;
			width: 100% !important;
		}
		.select2-selection--single{
			height: 33px !important;
    		margin-top: 5px !important;
		}
		.select2-selection--single .select2-selection__arrow {
		    height: 26px;
		    position: absolute;
		    top: 6px !important;
		}
		.select2-container--default .select2-selection--single .select2-selection__rendered{
			line-height: 30px;
		}
		.searchAdd{
			color: #ffffff;
			font-size: 17px;
			font-weight: 500;
			padding: 6px 17px;
			margin-top: 10px;
			border-radius: 3px;
			cursor: pointer;
			background-color: #333333!important;
    		border: 1px solid #7a96ff!important;
    		border-bottom: 2px solid #fdbd0e!important;
		}
		.addBtn1{
			width: fit-content !important;
			/* position: absolute; */
			right: 30px;
			top: 2px;
			padding: 8px 12px !important;
			background-color: #7a96ff;
			color: #fff;
			border-color:  #7a96ff;
			cursor: pointer;
		} 

		#inboundpopbg .inboundpop{
			padding:10px 10px 40px 10px !important; 
			margin-bottom: 40px !important;
			/* padding: 10px !important; */
		}
		#inboundpopbg .inboundheader{
			position: relative;
			background-color: #233a49 !important;
			padding: 10px !important;
			color: #fff !important;
			font-weight: 600 !important;
			border-radius: 4px !important;
			font-size: 15px !important;
			text-transform: uppercase;
			overflow: hidden;
			border-bottom: 1px solid #ddd !important;
		}

		</style>
		<div id="loadadditionalsearch" style="display:noane; max-height: 270px; margin: 0px 9px; overflow: auto; background: #f7f7f7;">
		</div>
		<div id="loadmealplanboxgetMealCost" style="display:none;"></div>
		<div style="background-color:#feffbc; padding:0px; display:none;" id="loadmealplanbox"></div>
		<script>
			function selectcost(){ 
				var costType = $('#additionalcostType').val();
				if(costType==1){
					$('.pp').show();
					$('.tot').hide();
					$('#additionalGroupCost').val('');
				}
				if(costType==2){
					$('.pp').hide();
					$('.tot').show();
					$('#additionalAdultCost').val('');
				}
			} 

			selectcost();

			function SearchAdditionRequirement(dayId,cityId,quotationId,queryId){
					var destWise = $("#destWise").val();
					var destinationId = $("#destinationId").val();
					var additionalId2 = $("#additionalId2").val();
					var additionalcostType = $("#additionalcostType").val();
					var additionalAdultCost = $("#additionalAdultCost").val();
					var startDay = $("#startDay").val();
					var additionalName = $("#additionalName").val();

					$("#loadadditionalsearch").load('loadadditionalsearch.php?&destWise='+destWise+'&destinationId='+destinationId+'&additionalId2='+additionalId2+'&additionalcostType='+additionalcostType+'&additionalAdultCost='+additionalAdultCost+'&startDay='+startDay+'&additionalName='+encodeURI(additionalName)+'&cityId=<?php echo $cityId ?>&queryId=<?php echo $queryData['id'] ?>&quotationId=<?php echo $quotationData['id'] ?>&dayId=<?php echo $_REQUEST['dayId']; ?>');
			}

				if(destinationId!=''){
			SearchAdditionRequirement();
				}
		

			// function getAdditionalCost(additionalId){
			// 	//var additionalId = $('#additionalId').val();
			// 	$('#loadmealplanbox').load('loadsaveextra.php?action=loadAdditionalCost&additionalId='+additionalId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
			// }


			// MEALPLAN BOX
			function addadditionaltoquotations(additionalId,currencyId,quotationId,queryId,dayId,startDay,tableN){
				var startDay = $('#startDay').val();

					$('#loadmealplanbox').load('loadsaveextra.php?action=addedit_QuotationExtra&queryId='+queryId+'&add=yes&additionalId='+additionalId+'&startDay='+encodeURI(startDay)+'&quotationId='+quotationId+'&currencyId='+currencyId+'&dayId='+dayId+'&startDay='+startDay+'&tableN='+tableN);
				
				}
				function selectthis(ele){
								$(ele).html('Selected');
								$(ele).removeAttr('onclick');
								$(ele).css('background-color','#d88319');
							}

			<?php if($_REQUEST['additionalId'] = ''){ ?>
			getAdditionalCost();
			<?php } ?>

		</script>
	<?php
}
// Additional Requirements Block ends


// sdfsdf
if($_REQUEST['action'] == 'addServiceEnroute' && $_REQUEST['dayId']!=''){

 	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	$enrouteId = 0;
	if($_REQUEST['enrouteId'] != '' && $_REQUEST['enrouteId'] != 0 ){
		$enrouteId = $_REQUEST['enrouteId'];
	}
	?>

 	<div class="inboundheader" > Add Enroute <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i></div>

		<div class="addeditpagebox addtopaboxlist" style="display:nones;padding:10px">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
 			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
				<tbody>
					<tr style="background-color:transparent !important;">
					<td width="24%" align="left"><div class="griddiv" style="position:static;">
						<label> <div>&nbsp;</div>
							<select id="destWise" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
							<option value="1">Selected Destination</option>
							<option value="2">All Destinations</option>
							</select>
						</label>
						<script>
					  function getdestWise(){
						if($('#destWise').val()==2){
							$('#destinationId').load('loadAllDestinations.php');
						}

						if($('#destWise').val()==1){
							$('#destinationId').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
						}

					  }
					  </script>
			    </div></td>
					<td width="21%" align="left"> 
					<!-- select destination -->
					<div class="griddiv" style="position:static;">
					<label>
					<div>Destination</div>
					<select id="destinationId" name="destinationId" class="gridfield validate select2" displayname="Select Destination" autocomplete="off"   >
					<?php 
					$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0   and cityId = "'.$dayData['cityId'].'"  group by cityId  order by id asc');
					while($QueryDaysData=mysqli_fetch_array($a)){
					?>
					<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
					<?php 
					} ?>
					</select>
					</label>
					</div>
					</td>
					 <td width="21%" align="left"><div class="griddiv" style="position:static;">
						<label> <div>&nbsp;</div>
							<select id="defaultWise" name="defaultWise" class="gridfield validate" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
							<option value="1">Default Enroute</option>
							<option value="2">All Enroute</option>
							</select>
						</label>
			    </div></td>
					<td width="8%" align="left" valign="middle">
						<input name="enrouteId" type="hidden" id="enrouteId" value="<?php echo $enrouteId; ?>">
						<input name="queryId" type="hidden" id="queryId" value="<?php echo $queryData['id']; ?>">
						<input name="quotationId" type="hidden" id="quotationId" value="<?php echo  $quotationData['id']; ?>">
						<input type="button" name="Submit" value="   Search   " class="bluembutton"  style="margin-top:20px;" onclick="loadsearchenroutefunction();"></td>
					</tr>
				</tbody>
			</table>
			</form>
			<script src="plugins/select2/select2.full.min.js"></script>
			<script>
			$(document).ready(function() {
			$('.select2').select2();
			});
			</script>
			<style>
			.select2-container--open{
			z-index: 9999999999 !important;
			width: 100%;
			}

			.select2-container {
			box-sizing: border-box;
			display: inline-block;
			margin: 0;
			position: relative;
			vertical-align: middle;
			width: 100% !important;
			}
			</style>
		</div>
		<div style="background-color:#f7f7f7; padding:10px;" id="loadenroutesearch" ></div>
		<script>
			// ENROUTE BOX
			loadsearchenroutefunction();
			function loadsearchenroutefunction(){
				var dayId = '<?php echo $dayData['id']; ?>';
				var queryId =$('#queryId').val();
				var defaultWise =$('#defaultWise').val();
				var destinationId =$('#destinationId').val();
				var quotationId =$('#quotationId').val();
				$('#loadenroutesearch').load('loadenroutesearch.php?dayId='+dayId+'&destinationId='+destinationId+'&defaultWise='+defaultWise);
			}

			function addenroutetoquotations(enrouteId,destinationId){
				var dayId = '<?php echo $dayData['id']; ?>';
				if(enrouteId > 0 && destinationId > 0){
					$('#loadenroutesaveenroute').load('loadsaveenroute.php?add=yes&enrouteId='+enrouteId+'&dayId='+dayId+'&destinationId='+destinationId);
				selectthis('#selectthis'+enrouteId);
				}else{
					alert('All fields are required.');
				}
			}
			function selectthis(ele){
				$(ele).html('Selected');
				$(ele).removeAttr('onclick');
				$(ele).css('background-color','#d88319');
			}

		</script>
	<?php

}

if($_REQUEST['action'] == 'addServiceGuide' && $_REQUEST['dayId']!=''){

 	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];
	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);
	
	$pax = $quotationData['adult']+$quotationData['child'];
	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery);

	$guideId = 0;
	if($_REQUEST['guideId'] != '' && $_REQUEST['guideId'] != 0 ){
		$guideId = $_REQUEST['guideId'];
	}
	?>
	<div class="inboundheader" style="position:relative;">
 		<?php 
 		$isSupplement = $isGuestType = $guideQuoteId = 0;
 		if($_REQUEST['guideQuoteId']>0 && $_REQUEST['stype'] == 'guideSupplement'){
 			$headingName = 'Supplement Tour Escort';
 			$isSupplement = 1;
 			$guideQuoteId = $_REQUEST['guideQuoteId'];
 		}else{
 			// $headingName = 'Guide';
 			$headingName = 'Tour Escort';
 			$isGuestType = 1;
 		} 
 		echo $headingName; if($queryData['dayWise']==1){ echo "&nbsp;|&nbsp;".date('D j M Y', strtotime($dayData['srdate'])); }  ?><i class="fa fa-times" aria-hidden="true" style="position: absolute;top: 5px; right: 10px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;
	</div>

	<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}

</style>
	<div class="addeditpageboxs addtopaboxlist" style="display:nones;position:relative;padding: 10px!important;">
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice" style="width: 100% !important;">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tablesorter ">
		  <tbody>
		  <tr style="background-color:transparent !important;">
		  	<td width="20%" align="left" style="display:nonse;">
				<input type="hidden" id="guideQuoteId3" value="<?php echo $guideQuoteId; ?>">
				<input type="hidden" id="isSupplement3" value="<?php echo $isSupplement; ?>">
				<input type="hidden" id="isGuestType3" value="<?php echo $isGuestType; ?>">
				<!-- hiddend fields -->
				<span class="HeadingBOL">Service&nbsp;Type</span> <br>
				<select id="serviceType3" name="serviceType3" class="gridfield guideselect" displayname="Service Type" onChange="showPaxRange(this.value,'showPaxRange_div');" autocomplete="off" >
				<option value="0"><?php echo $headingName; ?> </option>
				<!-- <option value="1">Porter </option> -->
				</select>
			</td>
			<script>
			function showPaxRange(val,id){
				if(val == 1){
					$('#'+id).hide();
				}else{
					$('#'+id).show()
				}
			}
			</script>
			<td width="20%" align="left">
				<div class="griddiv" style="position:static;">
					<label> <div class="HeadingBOL"  style="font-size: 11px;">Destination Type</div>
						<select id="destWise3" name="destWise3" class="gridfield validate" onChange="getdestWise();" style="width:128px;" >
						<option value="2">All Destinations</option>
						<option value="1">Selected Destination</option>
						</select>
					</label>
					<script>
					  function getdestWise(){
						if($('#destWise3').val()==2){
							$('#destinationId3').load('loadAllDestinations.php');
						}

						if($('#destWise3').val()==1){
							$('#destinationId3').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
						}
						$('#select2-destinationId3-container').text('Select');

					  }
					  </script>
			    </div>
			</td>
			<td width="20%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div class="HeadingBOL" style="font-size: 11px;">Destination</div>
						<select id="destinationId3" name="destinationId3" class="gridfield validate select2" displayname="Select Destination" autocomplete="off"  >
							<?php
							$day=1;
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and cityId="'.$cityId.'"  and addstatus=0  group by cityId order by id asc');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							$day++;
							} ?>
						</select>
						<script src="plugins/select2/select2.full.min.js"></script>
						<script>
						$(document).ready(function() {
							$('.select2').select2();
						});
						</script>
						<style>
						 	.select2-selection--single {
								display: inline-block !important;
								outline: 0px;
								padding-bottom: 0px;
								width: 100%;
								background-color: #FFFFFF !important;
								font-size: 14px;
								border: 1px #e0e0e0 solid !important;
								box-sizing: border-box !important;
								height: auto !important;
								padding: 2px;
								margin-top: 4px;
								border-radius: 2px !important;
							}
							.select2-container--default .select2-selection--single .select2-selection__arrow {
								top: 9px !important;
							}
							.select2-container--open{
								z-index: 9999999999 !important;
								width: 100%;
							}

							.select2-container {
								box-sizing: border-box;
								display: inline-block;
								margin: 0;
								position: relative;
								vertical-align: middle;
								width: 100% !important;
							}

							.select2-container--default .select2-selection--single .select2-selection__rendered {
								color: #444;
								line-height: 22px!important;
							}
						  </style>
					</label>
				</div>
			</td>
			<td width="12%" align="left" id="showPaxRange_div">
				<span class="HeadingBOL">Pax&nbsp;Range</span> <br>
				<select id="paxRange3" name="paxRange3" class="gridfield guideselect" autocomplete="off"  >
					<option value="0" >All Pax</option>
					<option value="1_5" <?php if($pax >= 1 && $pax <= 5){ ?>selected="selected"<?php } ?>>1-5 Pax</option>
					<option value="6_14" <?php if($pax >= 6 && $pax <= 14){ ?>selected="selected"<?php } ?>>6-14 Pax</option>
					<option value="15_40" <?php if($pax >= 15 && $pax <= 40){ ?>selected="selected"<?php } ?>>15-40 Pax</option>
				</select>
			</td>
			<td width="10%" align="left">
				<span>&nbsp;</span> <br>
				<select id="defaultWise3" name="defaultWise3" class="gridfield" autocomplete="off" style="width: 123px;" >
					<option value="2">All Tour Escort</option>
						<option value="1" >Default Tour Escort</option>
				</select>
			</td>
		    <td width="17%" align="left">
				<span class="HeadingBOL">From&nbsp;Day</span> <br>
				<select id="startDayId3" name="startDayId3" class="gridfield validate" displayname="Start Day" autocomplete="off" style="display:none1; padding: 5px 5px; border-radius: 3px;" >
				<?php
				$day=1;
				$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  order by id asc');
				while($QueryDaysData=mysqli_fetch_array($a)){
				//if($dayData['cityId']==$QueryDaysData['cityId']){
				?>
				<option value="<?php echo strip($QueryDaysData['id']); ?>,<?php echo date('Y-m-d', strtotime($QueryDaysData['srdate'])); ?>,<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['srdate']==$QueryDaysData['srdate']){ ?>  selected="selected" <?php } ?>>Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
				<?php
				//}
				$day++;
				} ?>
				</select></td>
		    <td width="17%" align="left">
				<span class="HeadingBOL">To&nbsp;Day</span> <br>
				<select id="endDayId3" name="endDayId3" class="gridfield validate" displayname="Start Day" autocomplete="off" style="display:none1; padding: 5px 5px; border-radius: 3px;" >
				<?php
				$day=1;
				$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0  order by id asc');
				while($QueryDaysData=mysqli_fetch_array($a)){
				//if($dayData['cityId']==$QueryDaysData['cityId']){
				?>
				<option value="<?php echo strip($QueryDaysData['id']); ?>,<?php echo date('Y-m-d', strtotime($QueryDaysData['srdate'])); ?>,<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['srdate']==$QueryDaysData['srdate']){ ?>  selected="selected" <?php } ?>>Day <?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?></option>
				<?php
				//}
				$day++;
				} ?>
				</select> </td>

				<td width="10%" align="left">
				<span class="HeadingBOL">Language&nbsp;Type</span> <br>
				<select id="languageType" name="languageType" class="gridfield" displayname="Language Type" autocomplete="off" style="padding: 5px 5px; border-radius: 3px;" >
				<?php
				$day=1;
				$ab=GetPageRecord('*','tbl_languagemaster',' deletestatus=0 and status=1 order by id asc');
				while($langData=mysqli_fetch_array($ab)){
				?>
				<option value="<?php echo strip($langData['id']); ?>"  <?php if($langData['id']==$_REQUEST['languageType']){ ?>  selected="selected" <?php } ?>> <?php echo $langData['name'];?></option>
				<?php } ?>
				</select> </td>
				<td>
					<span class="HeadingBOL">Guide&nbsp;Name</span> <br>
					<input type="text" name="guideSearch" class="gridfield"  id="guideSearch" placeholder="Enter Keyword" style="padding: 5px 5px; border-radius: 3px; width: 100px;">
				</td>
			<td width="8%" align="left" valign="middle">
				<br>
				<input name="guideId3" type="hidden" id="guideId3" value="<?php echo $guideId; ?>">
				<input name="queryId3" type="hidden" id="queryId3" value="<?php echo $queryData['id']; ?>">
				<input name="quotationId3" type="hidden" id="quotationId3" value="<?php echo  $quotationData['id']; ?>">
				<!-- comment this  -->
			    <!-- <input type="button" name="Submit" value="   Search   " class="bluembutton"  style="padding: 4px 1px !important; margin: 0; border-radius: 3px;" onclick="loadsearchguidefunction();"></td> -->

				<!-- add this  -->
				<button type="button" style="background:#233a49; color:#fff;margin: 0px 6px 0px 6px;"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchguidefunction();">
				<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
				</button>


			</tr>
	</tbody></table>
		</form>
	</div>
	<div style="background-color:#feffbc; padding:0px; display:none;" id="loadguidesaveguide" ></div>
	<div style="background-color:#f7f7f7; padding:10px;" id="loadguidesearch" ></div>
	<script>
		// guide BOX
		loadsearchguidefunction();
		function loadsearchguidefunction(){
			var isGuestType =$('#isGuestType3').val();
			var isSupplement =$('#isSupplement3').val();
			var guideQuoteId =$('#guideQuoteId3').val();
			
			var startDayId =$('#startDayId3').val();
			var endDayId =$('#endDayId3').val();
			var queryId =$('#queryId3').val();
			var defaultWise =$('#defaultWise3').val();

			var destinationId =$('#destinationId3').val();
			var destWise =$('#destWise3').val();
			var guideSearch =$('#guideSearch').val();

			var dayId = <?php echo ($_REQUEST['dayId']>0)?$_REQUEST['dayId']:0; ?>;

			var serviceType =$('#serviceType3').val();
			var paxRange =$('#paxRange3').val();
			var quotationId =$('#quotationId3').val();
			$('#loadguidesearch').load('loadguidesearch.php?startDayId='+startDayId+'&endDayId='+endDayId+'&serviceType='+serviceType+'&paxRange='+paxRange+'&defaultWise='+defaultWise+'&isGuestType='+isGuestType+'&isSupplement='+isSupplement+'&guideQuoteId='+guideQuoteId+'&destinationId='+destinationId+'&destWise='+destWise+'&dayId='+dayId+'&quotationId='+quotationId+'&guideKeyword='+encodeURI(guideSearch));
		}

		function addguidetoquotations(tariffId,dayId,destinationId,totalDays,tableN){
			var quotationId =$('#quotationId3').val();
			var isGuestType =$('#isGuestType3').val();
			var isSupplement =$('#isSupplement3').val();
			var guideQuoteId =$('#guideQuoteId3').val();
			var slabId =$('#slabId3'+tariffId).val();
			if(tariffId>0 && dayId>0){
				$('#loadguidesaveguide').load('loadsaveguide.php?add=yes&tariffId='+tariffId+'&serviceid='+tariffId+'&quotationId='+quotationId+'&slabId='+slabId+'&isGuestType='+isGuestType+'&isSupplement='+isSupplement+'&guideQuoteId='+guideQuoteId+'&destinationId='+destinationId+'&dayId='+dayId+'&tableN='+tableN+'&totalDays='+totalDays);
			}else{
				alert('All fields are required.');
			}
		}
		function selectthisE(ele,tblN){
			$('#selectBtnE'+ele+tblN).html('&nbsp;Selected');
			$('#selectBtnE'+ele+tblN).removeAttr('onclick');
			$('#selectBtnE'+ele+tblN).css('background-color','#d88319');
		}
	</script>
	<?php
} 

// Cruise Service
// if($_REQUEST['action'] == 'addServiceCruise' && $_REQUEST['dayId']!=''){

// 	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
//    $dayData = mysqli_fetch_array($dayQuery);

//    //quotation data
//    $quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
//    $quotationData=mysqli_fetch_array($quotQuery);

//    //Query data
//    $queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
//    $queryData=mysqli_fetch_array($queQuery);

//    $cruiseId = 0;
//    if($_REQUEST['cruiseId'] != '' && $_REQUEST['cruiseId']!= 0 ){
// 	   $cruiseId = $_REQUEST['cruiseId'];
//    }
//    ?>

<!-- // 	<div class="inboundheader" > Add Cruise <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #ffffff; cursor:pointer; " onClick="closeinbound();"></i></div>

// 	   <div class="addeditpagebox addtopaboxlist" style="display:nones;padding:10px">
// 		   <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addhotelroomprice" target="actoinfrm" id="addhotelroomprice">
// 			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
// 			   <tbody>
// 				   <tr style="background-color:transparent !important;">
// 				   <td width="24%" align="left"><div class="griddiv" style="position:static;">
// 					   <label> <div>&nbsp;</div>
// 						   <select id="destWise" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
// 						   <option value="1">Selected Destination</option>
// 						   <option value="2">All Destinations</option>
// 						   </select>
// 					   </label>
// 					   <script>
// 					 function getdestWise(){
// 					   if($('#destWise').val()==2){
// 						   $('#destinationId').load('loadAllDestinations.php');
// 					   }

// 					   if($('#destWise').val()==1){
// 						   $('#destinationId').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
// 					   }

// 					 }
// 					 </script>
// 			   </div></td>
// 				   <td width="21%" align="left"> 
// 				 
// 				   <div class="griddiv" style="position:static;">
// 				   <label>
// 				   <div>Destination</div>
// 				   <select id="destinationId" name="destinationId" class="gridfield validate select2" displayname="Select Destination" autocomplete="off"   >
// 				   <?php 
// 				   $a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'"  and addstatus=0   and cityId = "'.$dayData['cityId'].'"  group by cityId  order by id asc');
// 				   while($QueryDaysData=mysqli_fetch_array($a)){
// 				   ?>
// 				   <option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
// 				   <?php 
// 				   } ?>
// 				   </select>
// 				   </label>
// 				   </div>
// 				   </td>
// 					<td width="21%" align="left"><div class="griddiv" style="position:static;">
// 					   <label> <div>&nbsp;</div>
// 						   <select id="defaultWise" name="defaultWise" class="gridfield validate" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
// 						   <option value="1">Default Enroute</option>
// 						   <option value="2">All Enroute</option>
// 						   </select>
// 					   </label>
// 			   			</div>
// 					</td>
// 					<td width="21%" align="left"><div class="griddiv" style="position:static;">
// 					   <label> <div>&nbsp;</div>
// 				   			<input type="text" id="nameKeyword" name="nameKeyword" class="gridfield validate" autocomplete="off" placeholder="Enter Keyword" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
						
// 					   </label>
// 			   			</div>
// 					</td>
// 				   <td width="8%" align="left" valign="middle">
// 					   <input name="cruiseId" type="hidden" id="cruiseId" value="<?php echo $cruiseId; ?>">
// 					   <input name="queryId" type="hidden" id="queryId" value="<?php echo $queryData['id']; ?>">
// 					   <input name="quotationId" type="hidden" id="quotationId" value="<?php echo  $quotationData['id']; ?>">
// 					   <input type="button" name="Submit" value="   Search   " class="bluembutton"  style="margin-top:20px;" onclick="loadsearchcruisefunction();"></td>
// 				   </tr>
// 			   </tbody>
// 		   </table>
// 		   </form>
// 		   <script src="plugins/select2/select2.full.min.js"></script>
// 		   <script>
// 		   $(document).ready(function() {
// 		   $('.select2').select2();
// 		   });
// 		   </script>
// 		   <style>
// 		   .select2-container--open{
// 		   z-index: 9999999999 !important;
// 		   width: 100%;
// 		   }

// 		   .select2-container {
// 		   box-sizing: border-box;
// 		   display: inline-block;
// 		   margin: 0;
// 		   position: relative;
// 		   vertical-align: middle;
// 		   width: 100% !important;
// 		   }
// 		   </style>
// 	   </div>
// 	   <div style="background-color:#f7f7f7; padding:10px;" id="loadcruisesearch" ></div>
// 	   <div style="background-color:#f7f7f7; padding:10px;" id="loadsavecruise" ></div>  -->
   <script>
// 		   // ENROUTE BOX
// 		   loadsearchcruisefunction();
// 		   function loadsearchcruisefunction(){
// 			   var dayId = '<?php echo $dayData['id']; ?>';
// 			   var queryId =$('#queryId').val();
// 			   var defaultWise =$('#defaultWise').val();
// 			   var destinationId =$('#destinationId').val();
// 			   var quotationId =$('#quotationId').val();
// 			   var nameKeyword =$('#nameKeyword').val();
// 			   $('#loadcruisesearch').load('loadcruisesearch.php?dayId='+dayId+'&destinationId='+destinationId+'&defaultWise='+defaultWise+'&nameKeyword='+encodeURI(nameKeyword));
// 		   }
	
// 		   function addcruisetoquotations(cruiseId,destinationId,tableN,dmcId){
// 			   var dayId = '<?php echo $dayData['id']; ?>';
// 			   if(cruiseId > 0 && destinationId > 0){
// 				   $('#loadsavecruise').load('loadsavecruise.php?add=yes&action=addedit_QuotationCruise&cruiseId='+cruiseId+'&dayId='+dayId+'&destinationId='+destinationId+'&tableN='+tableN+'&dmcId='+dmcId+'&cityId=<?php $_REQUEST['cityId'] ?>');
// 			   selectthis('#selectthis'+cruiseId);
// 			   }else{
// 				   alert('All fields are required.');
// 			   }
// 		   }
// 		   function selectthis(ele){
// 			   $(ele).html('Selected');
// 			   $(ele).removeAttr('onclick');
// 			   $(ele).css('background-color','#d88319');
// 		   }

// 	   </script>
   <?php

// }


if($_REQUEST['action'] == 'addServiceCruise' && $_REQUEST['dayId']!=''){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$cityId = $dayData['cityId'];

	//quotation data
	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id ="'.$dayData['quotationId'].'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	//Query data
	$queQuery=GetPageRecord('*',_QUERY_MASTER_,'id ="'.$dayData['queryId'].'"');
	$queryData=mysqli_fetch_array($queQuery); 
	?>

<style>
.HeadingBOL{
color: #343131;
font-weight: bold;
}
</style>

 	<div class="inboundheader" > Select Cruise - <?php echo date('d-m-Y', strtotime($dayData['srdate'])); ?><i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i><span class="griddiv" style="position:static;">
 	     	</span></div>
	 <div style="padding:10px;" id="transferbox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addFerryService" target="actoinfrm" id="addFerryService">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
			<tbody>
			<tr style="background-color:transparent !important;">
				<td width="20%" align="left">
					<div class="griddiv" style="position:static;">
						<label> <div>&nbsp;</div>
							<select id="destWise" name="destWise" class="gridfield validate" onChange="getdestWise();" autocomplete="off" style="width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 3px;" >
							<option value="1">Selected Destination</option>
							<option value="2">All Destinations</option>
							</select>
						</label>
						<script>
						  function getdestWise(){
							if($('#destWise').val()==2){
								$('#destinationId1').load('loadAllDestinations.php');
							}
							if($('#destWise').val()==1){
								$('#destinationId1').load('loadAllDestinations.php?dayId=<?php echo $_REQUEST['dayId']; ?>');
							}
							$('#select2-destinationId1-container').text('Select');

						  }
						  </script>
				    </div>
				</td>

			<td width="12%" align="left">
				<div class="griddiv" style="position:static;">
					<label>
						<div class="HeadingBOL">Destination</div>
						<select id="destinationId1" name="destinationId1" class="gridfield validate select2" displayname="Select Destination" onchange="loadCruiseNamefun();" autocomplete="off" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
							<?php
							$day=1;
							$a=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and cityId="'.$cityId.'"  and addstatus=0  group by cityId order by id asc');
							while($QueryDaysData=mysqli_fetch_array($a)){
							?>
							<option value="<?php echo strip($QueryDaysData['cityId']); ?>"  <?php if($dayData['dayId']==$QueryDaysData['id']){ ?>  selected="selected" <?php } ?>><?php echo getDestination($QueryDaysData['cityId']);?></option>
							<?php
							$day++;
							} ?>
						</select>
					</label>
				</div>
			</td>
			
			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
					<div class="HeadingBOL" style="width:100%;">Cruise Package Name</div>
					<select id="cruiseServiceId" name="cruiseServiceId" class="gridfield" autocomplete="off" onchange="getDurationDate();"   >
					    <option value="0">Select Cruise</option>
						<?php
			            $cruiseServiceQ=GetPageRecord('*','cruiseMaster',' 1 and FIND_IN_SET("'.$dayData['cityId'].'",destination) and status=1 order by cruiseName asc');
			            while($cruiseServiceData=mysqli_fetch_array($cruiseServiceQ)){
			            ?>
	                	<option value="<?php echo $cruiseServiceData['id']; ?>"><?php echo $cruiseServiceData['cruiseName']; ?></option>
	                	<?php } ?>
				  	</select>
					</label>
			    </div> 
			</td>

			<td width="8%" align="left">
				<div class="griddiv" style="position:static;"><label>
					<div class="HeadingBOL" style="width:100%;">Duration</div>
					
					<input type="text" readonly id="cruiseduration" name="cruiseduration" class="gridfield" autocomplete="off">
					</label>
			    </div> 
			</td>

			<td width="10%" align="left">
				<div class="griddiv" style="position:static;"><label>
					<div class="HeadingBOL" style="width:100%;">Departure&nbsp;Date</div>
					
					<input type="text" readonly id="departureDate" name="departureDate" class="gridfield" autocomplete="off">
					</label>
			    </div> 
			</td>

			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">Cruise Name</div>

				<select id="cruiseNameId" name="cruiseNameId" class="gridfield" >
					<option value="0">Select Cruise Name</option>
					<?php
					$bc2='';
					$bc2=GetPageRecord('*','cruiseNameMaster',' name!="" and status=1 order by name asc');
					while($cruiseNameData=mysqli_fetch_array($bc2)){
					?>
					<option value="<?php echo strip($cruiseNameData['id']); ?>"><?php echo $cruiseNameData['name']; ?></option>
					<?php
					} ?>
				</select>

				</label>
				</div>			
			</td>

			<td width="15%" align="left">
				<div class="griddiv" style="position:static;"><label>
				<div class="HeadingBOL">Cabin Type</div>
				<select id="cabinTypeId" name="cabinTypeId" class="gridfield" >
					<option value="0">Select Cabin Type</option>
					<?php
					$bc1='';
					$bc1=GetPageRecord('*',_CABIN_TYPE_,' name!="" and status=1 order by name asc');
					while($cabinTypeData=mysqli_fetch_array($bc1)){
					?>
					<option value="<?php echo strip($cabinTypeData['id']); ?>"><?php echo $cabinTypeData['name']; ?></option>
					<?php
					} ?>
				</select>
				</label>
				</div>			
			</td>

			<td width="8%" align="left" valign="middle">
			    <!-- <input style="margin-top: 10px;" type="button" name="Submit" value="Search" class="bluembutton" onclick="loadsearchcruisefunction();">	 -->


				<!-- add this  -->
				<button type="button" style="background:#233a49; color:#fff;"  name="Submit" value="" class="whitembutton searchBtn"  onclick="loadsearchcruisefunction();">
				<i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search   
				</button>


			</td>
			</tr>
			</tbody>
			</table>
			</form>
			<script src="plugins/select2/select2.full.min.js"></script>
			<script>
			$(document).ready(function() {
				$('.select2').select2();
			});
			</script>
			<style>
			.select2-container--open{
				z-index: 9999999999 !important;
				width: 100%;
			}

			.select2-container {
				box-sizing: border-box;
				display: inline-block;
				margin: 0;
				position: relative;
				vertical-align: middle;
				width: 100% !important;
				margin-top: 6px !important;
			}
			.select2-container--default .select2-selection--single {
			    HEIGHT: 35px;
			}
			</style>
		</div>
		<div style="background-color:#feffbc;display:none;" id="loadCruiseDuration" ></div>
		<div style="background-color:#feffbc;display:none;" id="loadCruisesave" ></div>
	  	<div style="background-color:#f7f7f7;" id="loadcruiseSearch" >&nbsp;</div>
		<script type="text/javascript">

			 function loadCruiseNamefun(){
		
		   		var destinationId = $('#destinationId1').val(); 
				
		   		$('#cruiseServiceId').load(`loadcruiseservices.php?action=getDestinations&destinationId=${destinationId}&dayId=<?php echo $_REQUEST['dayId']; ?>`);   
		    }

			function getDurationDate(){
				var cruiseServiceId = $("#cruiseServiceId").val();
				$('#loadCruiseDuration').load(`loadcruiseservices.php?action=getCruiseDurationDate&cruiseServiceId=${cruiseServiceId}&dayId=<?php echo $_REQUEST['dayId']; ?>&travelDate=<?php echo $quotationData['fromDate']; ?>`);   
			}


			function addCruiseToQuotation(rateId,tableN,cruiseServiceId){
				var cityId = $('#destinationId1').val();
				var cruiseduration = $('#cruiseduration').val(); 
				var departureDate = $('#departureDate').val(); 
				
				if(rateId > 0 && tableN > 0){
					$('#loadCruisesave').load(`loadsavecruise.php?add=yes&rateId=${rateId}&tableN=${tableN}&cruiseServiceId=${cruiseServiceId}&cityId=${cityId}&dayId=<?php echo $_REQUEST['dayId']; ?>&currencyId=<?php echo $quotationData['currencyId']; ?>&departureDate=${departureDate}&cruiseduration=${cruiseduration}`);
					selectthis('#selectthis'+rateId);
				}else{
					alert('All fields are required.');
				}
			}
			function loadsearchcruisefunction(){ 
				
				var cruiseServiceId = $('#cruiseServiceId').val(); 
				var cabinTypeId = $('#cabinTypeId').val(); 
				var cruiseNameId =$('#cruiseNameId').val();
				var destWise =$('#destWise').val();
				var cityId =$('#destinationId1').val();
				$('#loadcruiseSearch').load(`loadcruisesearch.php?cruiseServiceId=${cruiseServiceId}&cabinTypeId=${cabinTypeId}&cruiseNameId=${cruiseNameId}&destWise=${destWise}&destinationId=${cityId}&dayId=<?php echo $_REQUEST['dayId']; ?>`);
			}
			// loadsearchferryfunction();
	

			// function loadFerryfun(){
			
			// }
		</script>
	</div>
	<?php
}

// end of the add service to quotations

// start add to master alert action and frmaction
if($_REQUEST['action'] == 'addhoteltomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

	if ($_GET['id'] != '') {

			$id = clean($_GET['id']);

			$select1 = '*';

			$where1 = 'id=' . $id . '';

			$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_HOTEL_MASTER_, $where1);
			$editresult = mysqli_fetch_array($rs1);


			$rs1 = '';

			$rs1 = GetPageRecord('*', _ADDRESS_MASTER_, ' addressParent="' . $editresult['id'] . '" and addressType="hotel"');

			$addressData = mysqli_fetch_array($rs1);
		}

	?>

	<div class="contentclass" style="overflow:auto;">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
			echo 'Edit';
		} else {
			echo 'Add';
		} ?> Hotel</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:scroll; text-align:left; margin-bottom:0px;">

			<form action="inboundpop.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">



			<table style="width:100%;">
				<tr style="width:100%;">
					<td style="width:12%;">
						<div class="griddiv"><label>
							<div class="gridlable">Hotel&nbsp;Chain</div>
							<select id="hotelChain" name="hotelChain" class="gridfield " displayname="Hotel Chain">
								<option value="">Select</option>
								<?php
								$rs = GetPageRecord('*', 'chainhotelmaster', ' 1 and status=1 order by name asc');
								while ($resListing = mysqli_fetch_array($rs)) {
								?>
									<option value="<?php echo ($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['hotelChain']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>

					<td style="width:30%;">
						<div class="griddiv"><label>
							<div class="gridlable"> Hotel &nbsp;Name<span class="redmind"></span></div>
								<input name="hotelName" type="text" class="gridfield validate" id="hotelName1" displayname="Hotel Name" value="<?php echo stripslashes($editresult['hotelName']); ?>" />
							</label>
						</div>
					</td>

					<td style="width:8%;">
						<div class="griddiv"><label>
							<div class="gridlable">Hotel&nbsp;Category</div>
								<select id="hotelCategoryId" name="hotelCategoryId" class="gridfield " autocomplete="off" displayname="Hotel Category">
									<?php
									$rs3 = '';
									$rs3 = GetPageRecord('*', 'hotelCategoryMaster', ' 1 and deletestatus=0 and status=1 order by hotelCategory asc');
									while ($hotelCategoryData = mysqli_fetch_array($rs3)) {
									?>
										<option value="<?php echo $hotelCategoryData['id']; ?>" <?php if ($hotelCategoryData['id'] == $editresult['hotelCategoryId']) { ?>selected="selected" <?php } ?>><?php echo $hotelCategoryData['hotelCategory'] . " Star"; ?></option>
									<?php
									}
									?>
								</select>
							</label>
						</div>
					</td>

					<td style="width:10%;">
						<div class="griddiv"><label>
							<div class="gridlable">Hotel&nbsp;Type</div>
							<select id="hotelTypeId" name="hotelTypeId" class="gridfield " autocomplete="off" displayname="Hotel Category">
								<?php
								$rs3 = '';
								$rs3 = GetPageRecord('*', 'hotelTypeMaster', ' 1 and deletestatus=0 and status=1 order by name asc');
								while ($hotelTypeData = mysqli_fetch_array($rs3)) {
								?>
									<option value="<?php echo $hotelTypeData['id']; ?>" <?php if ($hotelTypeData['id'] == $editresult['hotelTypeId']) { ?>selected="selected" <?php } ?>><?php echo $hotelTypeData['name']; ?></option>
								<?php
								}
								?>
							</select>
							</label>
						</div>
					</td>

					<td style="width:15%;">
						<div class="griddiv"><label>
							<div class="gridlable">Destination<span class="redmind"></span></div>
							<select id="hotelCity" name="hotelCity" class="gridfield validate" displayname="Destination" autocomplete="off">
									<option value="">Select</option>
									<?php
									$select = '';
									$where = '';
									$rs = '';
									$cityId = $_REQUEST['cityId'];
									
									$select = '*';
									$where = ' 1 and deletestatus = 0 order by name asc';
									$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
									while ($resListing = mysqli_fetch_array($rs)) {
									?>
										<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['id'] == $_REQUEST['cityId']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

									<?php } ?>
								</select>
							</label>
						</div>
					</td>
						
					<td style="width:15%;">
						<div class="griddiv" style=""><label>
							<div class="gridlable" style="width: 100px;"> Locality<span class=""></span></div>
							<input name="locality" type="text" class="gridfield" id="locality" displayname="Locality" value="<?php echo stripslashes($editresult['locality']); ?>" />
							</label>

						</div>
					</td>

				</tr>

				<tr>
					<table>
						<tr>
						<td>
						<div class="griddiv">
							<label>
								<div class="gridlable">Room Type</div>
								<select name="roomType[]" multiple="multiple" class="gridfield validate js-example-basic-multiple" id="roomtypeId" displayname="Room Type" autocomplete="off">
									<option value="">Select</option>
									<?php
									$select = '';
									$where = '';
									$rs = '';
									$select = '*';
									$where = ' name!="" and deletestatus=0 and status=1 order by name asc';
									$rs = GetPageRecord($select, _ROOM_TYPE_MASTER_, $where);
									while ($resListing = mysqli_fetch_array($rs)) {
										$roomTypeArrya = array_map('trim', explode(",", $editresult['roomType']));
									?>
										<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($roomTypeArrya as $key => $value) {
											if ($resListing['id'] == $value) {
												echo 'selected="selected"';
											}
											} ?>><?php echo strip($resListing['name']); ?>
										</option>
									<?php } ?>
								</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv">
							<label>
								<div class="gridlable">Self Supplier</div>
								<select id="supplier" name="supplier" class="gridfield " autocomplete="off">
									<!--only use for supplier status-->
									<option value="1" <?php if ($editresult['supplier'] == 1) { ?> selected="selected" <?php } ?>>Yes</option>
									<option value="0" <?php if ($editresult['supplier'] == 0) { ?> selected="selected" <?php } ?>>No</option>
								</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv">
							<div class="gridlable" style="">Status<span class="redmind"></span></div>
							<label>
								<!--for status-->
								<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">
									<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>
									<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>
								</select>
							</label>
						</div>
					</td>
						</tr>
					</table>
				</tr>

			</table>

			<div class="griddiv">
				<table width="100%" border="0" cellspacing="2" cellpadding="0" id="contactpersonIdTable">
				<tr><td colspan="6">Contact Person<span class="redmind"></span>&nbsp;&nbsp;&nbsp;<span onclick="addMoreContactPerson()" class="ppbtn"> + Add More</span> </td></tr>
				<?php 
				$countCP = 1;
				$rs1 = '';
				$rs1 = GetPageRecord('*', 'hotelContactPersonMaster', ' corporateId="' . $editresult['id'] . '" and corporateId>0 order by primaryvalue asc');
				if(mysqli_num_rows($rs1)>0){
					while($suppCPData = mysqli_fetch_array($rs1)){ 
						?>
						<input type="hidden" name="contactPId<?php echo $countCP; ?>" id="contactPId<?php echo $countCP; ?>" value="<?php echo $suppCPData['id']; ?>">
						<tr id="contactPersonId<?php echo $countCP; ?>">
							<td width="70">
								<div class="griddiv">
									<label>
										<div class=""></div>
										<select id="division<?php echo $countCP; ?>" name="division<?php echo $countCP; ?>" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">
											<?php  
											$selectd='*';    
											$whered=' deletestatus=0 and status=1 order by name asc';  
											$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
											while($resListingd=mysqli_fetch_array($rsd)){  
											?>
											<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($suppCPData['division'] == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
											<?php } ?>
										</select>
									</label>
								</div>
							</td>
							<td width="70">
								<div class="griddiv"><label>
										<input name="contactPerson<?php echo $countCP; ?>" type="text" class="gridfield validate" id="contactPerson<?php echo $countCP; ?>" value="<?php echo $suppCPData['contactPerson']; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" >
									</label>
								</div>
							</td>
							<td width="70">
								<div class="griddiv"><label>
										<input name="designation<?php echo $countCP; ?>" type="text" class="gridfield " id="designation<?php echo $countCP; ?>" value="<?php echo $suppCPData['designation']; ?>" displayname="Designation" placeholder="Designation" >
									</label>
								</div>
							</td>
							<td width="40">
							<?php 
									$rsn="";
									$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
									$cmpcountryData=mysqli_fetch_array($rs1cmp);
									$compcountryCode = $cmpcountryData['compcountryCode'];
								?>
								<div class="griddiv"><label>
										<input name="countryCode<?php echo $countCP; ?>" type="text" class="gridfield validate" id="countryCode<?php echo $countCP; ?>" value="<?php echo '+'.$compcountryCode;?>" displayname="Country Code" placeholder="+91" >
									</label>
								</div>
							</td>
							<td width="80">
								<div class="griddiv"><label>
										<input name="phone<?php echo $countCP; ?>" type="text" class="gridfield validate" id="phone<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone']; ?>" displayname="Phone" placeholder="Phone" >
									</label>
								</div>
							</td>
							<td width="120">
								<div class="griddiv"><label>
										<input name="email<?php echo $countCP; ?>" type="email" class="gridfield validate " id="email<?php echo $countCP; ?>" value="<?php echo $suppCPData['email']; ?>" displayname="Email" placeholder="Email"  required />
									</label>
								</div>
							</td>
							<td width="25" align="center">
								<img src="images/deleteicon.png" onclick="removeContactPerson(<?php echo $countCP; ?>);" style="cursor:pointer;">'
							</td>
						</tr>
						<?php 
						$countCP++;
					} 
				}else{ ?>
					<tr id="contactPersonId<?php echo $countCP; ?>">
						<td width="70">
							<div class="griddiv">
								<label>
									<select id="division<?php echo $countCP; ?>" name="division<?php echo $countCP; ?>" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">
										<?php  
										$selectd='*';    
										$whered=' deletestatus=0 and status=1 order by name asc';  
										$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
										while($resListingd=mysqli_fetch_array($rsd)){  
										?>
										<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($suppCPData['division'] == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
										<?php } ?> 
									</select>
								</label>
							</div>
						</td>
						<td width="70">
							<div class="griddiv"><label>
									<input name="contactPerson<?php echo $countCP; ?>" type="text" class="gridfield validate" id="contactPerson<?php echo $countCP; ?>" value="<?php echo $suppCPData['contactPerson']; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" >
								</label>
							</div>
						</td>
						<td width="70">
							<div class="griddiv"><label>
									<input name="designation<?php echo $countCP; ?>" type="text" class="gridfield " id="designation<?php echo $countCP; ?>" value="<?php echo $suppCPData['designation']; ?>" displayname="Designation" placeholder="Designation" >
								</label>
							</div>
						</td>
						<td width="40">
								<?php 
									$rsn="";
									$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
									$cmpcountryData=mysqli_fetch_array($rs1cmp);
									$compcountryCode = $cmpcountryData['compcountryCode'];
								?>
							<div class="griddiv"><label>
									<input name="countryCode<?php echo $countCP; ?>" type="text" class="gridfield validate" id="countryCode<?php echo $countCP; ?>" value="<?php echo '+'.$compcountryCode; ?>" displayname="Country Code" placeholder="+91" >
								</label>
							</div>
						</td>
						<td width="80">
							<div class="griddiv"><label>
									<input name="phone<?php echo $countCP; ?>" type="text" class="gridfield validate" id="phone<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone']; ?>" displayname="Phone" placeholder="Phone" >
								</label>
							</div>
						</td>
						<td width="120">
							<div class="griddiv"><label>
									<input name="email<?php echo $countCP; ?>" type="email" class="gridfield validate " id="email<?php echo $countCP; ?>" value="<?php echo $suppCPData['email']; ?>" displayname="Email" placeholder="Email"  required />
								</label>
							</div>
						</td>
					</tr>
				<?php $countCP++;
				} ?>
				</table>
			<input type="hidden" name="countCP" id="countCP" value="<?php echo $countCP; ?>">
			<script>
			function removeContactPerson(countCP) {
				$('#contactPersonId'+countCP).remove();
			}	
			function addMoreContactPerson() {

				var countCP = $('#countCP').val();
				$('#countCP').val(parseInt(countCP, 10)+1);
				$("#contactpersonIdTable").append('<tr id="contactPersonId'+countCP+'">'
						+'<td width="70">'
							+'<div class="griddiv mb2">'
								+'<label>'
									+'<select id="division'+countCP+'" name="division'+countCP+'" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">'
										<?php  
										$selectd='*';    
										$whered=' deletestatus=0 and status=1 order by name asc';  
										$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
										while($resListingd=mysqli_fetch_array($rsd)){  
										?>
										+'<option value="<?php echo strip($resListingd['id']); ?>"><?php echo strip($resListingd['name']); ?></option>'
										<?php } ?>
									+'</select>'
								+'</label>'
							+'</div>'
						+'</td>'
						+'<td width="70">'
							+'<div class="griddiv mb2"><label>'
									+'<input name="contactPerson'+countCP+'" type="text" class="gridfield validate" id="contactPerson'+countCP+'" value="" displayname="Contact Person" maxlength="100" placeholder="Contact Person">'
								+'</label>'
							+'</div>'
						+'</td>'
						+'<td width="70">'
							+'<div class="griddiv mb2"><label>'
									+'<input name="designation'+countCP+'" type="text" class="gridfield " id="designation'+countCP+'" value="" displayname="Designation" placeholder="Designation">'
								+'</label>'
							+'</div>'
						+'</td>'
						+'<td width="40">'
							+'<div class="griddiv mb2"><label>'
									+'<input name="countryCode'+countCP+'" type="text" class="gridfield validate" id="countryCode'+countCP+'" value="<?php echo '+'.$compcountryCode; ?>" displayname="Country Code" placeholder="+91">'
								+'</label>'
							+'</div>'
						+'</td>'
						+'<td width="80">'
							+'<div class="griddiv mb2"><label>'
									+'<input name="phone'+countCP+'" type="text" class="gridfield validate" id="phone'+countCP+'" value="" displayname="Phone" placeholder="Phone">'
								+'</label>'
							+'</div>'
						+'</td>'
						+'<td width="120">'
							+'<div class="griddiv mb2"><label>'
									+'<input name="email'+countCP+'" type="email" class="gridfield validate " id="email'+countCP+'" value="" displayname="Email" placeholder="Email" required />'
								+'</label>'
							+'</div>'
						+'</td>'
						+'<td width="25" align="center">'
							+'<img src="images/deleteicon.png" onclick="removeContactPerson('+countCP+');" style="cursor:pointer;">'
						+'</td>'
					+'</tr>');
			}
			</script>
			<style type="text/css">
				.ppbtn {
				    background-color: #7a96ff;
				    padding: 1px 6px !important;
				    margin-left: 10px;
				    color: #FFFFFF!important;
				    font-size: 10px;
				    border: 1px #7a96ff solid;
				    cursor: pointer;
				}
				.mb2 {
				    margin-bottom: 2px!important;
				}
			</style>
		</div>


		<!-- Hotel Address Sec Started -->
		<div class="hiddenSecAddHotel">
			<div class="innerAddHotelAddressSec">
				<div class="addnewaddSecBtn"><h1 style="color: green;font-weight: bold;margin-bottom: 20px;cursor: pointer;font-size: 14px;" onclick="myAddressFunShowQuotation()">+ Add Addess</h1></div>

				<div class="addAddressSecInner" id="addAddressShowHideQuot" style="display:none;">
					
				<table width="100%" border="0" cellspacing="0" cellpadding="1">
					<tr>
						<td style="width: 15%;">
							<div class="griddiv">
								<label>
									<div class="gridlable">Country<span class=""></span></div>
									<select id="countryId2" name="countryId2" class="gridfield " displayname="Country" autocomplete="off" onchange="selectstate();">
										<option value="0">Select Country</option>
										<?php
										$rs = "";
										$DefaultCountry = 'India';
										$rs = GetPageRecord('*', _COUNTRY_MASTER_, ' deletestatus=0 and status=1 order by name asc');
										while ($countryData = mysqli_fetch_array($rs)) {
											if ($addressData['countryId'] != '') {
												$isDefaultCountry = $countryData['id'] == $addressData['countryId'];
											} else {
												$isDefaultCountry = $countryData['name'] === $DefaultCountry;
											}
										?>
											<option value="<?php echo strip($countryData['id']); ?>" <?php if ($countryData['id'] == $isDefaultCountry) { ?>selected="selected" <?php } ?>><?php echo strip($countryData['name']); ?></option>
										<?php } ?>
									</select>
								</label>
							</div>
						</td>
						<td style="width: 15%;">
							<div class="griddiv">
								<label>
									<div class="gridlable">State </div>
									<select id="stateId2" name="stateId2" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();">
										<?php
										$rs = "";
										$rs = GetPageRecord('*', _STATE_MASTER_, ' id="' . $addressData['stateId'] . '" order by name asc');
										while ($stateData = mysqli_fetch_array($rs)) {
										?>
											<option value="<?php echo strip($stateData['id']); ?>"><?php echo strip($stateData['name']); ?></option>
										<?php } ?>
									</select>
								</label>
							</div>
						</td>
					
						<td style="width: 15%;">
							<div class="griddiv">
								<label>
									<div class="gridlable">City </div>
									<select id="cityId2" name="cityId2" class="gridfield" displayname="City" autocomplete="off">
										<?php
										$rs = "";
										$rs = GetPageRecord('*', _STATE_MASTER_, ' id="' . $addressData['cityId'] . '" order by name asc');
										while ($cityData = mysqli_fetch_array($rs)) {
										?>
											<option value="<?php echo strip($cityData['id']); ?>"><?php echo strip($cityData['name']); ?></option>
										<?php } ?>
									</select>
								</label>
							</div>
						</td>

						<td style="width: 20%;">
							<div class="griddiv"><label>
								<div class="gridlable">Address</div>
								<input name="hotelAddress" type="text" class="gridfield" id="hotelAddress" value="<?php echo $editresult['hotelAddress']; ?>" />
								</label>
							</div>
						</td>
						<td style="width: 15%;">
							<div class="griddiv"><label>
									<div class="gridlable">Pin&nbsp;Code </div>
									<input name="pinCode" type="text" class="gridfield" id="pinCode" value="<?php echo $addressData['pinCode']; ?>" maxlength="15" />
								</label>
							</div>
						</td>


						<td style="width: 15%;">
							<div class="griddiv"><label>
								<div class="gridlable">GSTN</div>
								<input name="gstn" type="text" class="gridfield" id="gstn" value="<?php echo $editresult['gstn']; ?>" />
								</label>
							</div>
						</td>
					</tr>
					</table>
				
				</div>


			</div>
		</div>

		<!-- Hotel Address Sec Ended -->

		<script>
			function myAddressFunShowQuotation() {
			var x = document.getElementById("addAddressShowHideQuot");
			if (x.style.display === "none") {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
			}
		</script>


<!-- Add more Information Sec Started  -->
<div class="addMoreInfoSecQuot">
	<div class="addMoreInfoSecBtnQuot">
		<h1 style="color: black;font-weight: bold;margin-bottom: 20px;cursor: pointer;font-size: 16px;" onclick="myMoreInfoQuotFunShow()">More Information <img class="BussinesSecDown errow-drop" style="height: 25px;position: relative;top: 9px;" src="images/down-arrow-30.png" >
		</h1>
	</div>

	<div class="myMoreInfo_hideQuotSec" id="myMoreInfo_hideQuot" style="display:none;">
	<table>
			<tr>
				<td style="">
					<div class="griddiv" style="border-bottom: 0px #eee solid;"><label>
						<div class="gridlable">Weekend Days<span class=""></span></div>
						<select id="weekend" name="weekend" class="gridfield " autocomplete="off" displayname="Weekend Days" onchange="allweekend(this)" onclick="allweekend(this)">
							<?php
							$select1 = '*';
							$where1 = ' 1 and deletestatus=0 and status=1';
							$rs1 = GetPageRecord($select1, _WEEKEND_MASTER_, $where1);
							while ($resListing11 = mysqli_fetch_array($rs1)) {
							?>
								<option value="<?php echo ($resListing11['id']); ?>" <?php if ($resListing11['id'] == $editresult['weekendDays']) { ?>selected="selected" <?php } ?>><?php echo ($resListing11['name']); ?></option>
							<?php } ?>
						</select>
						</label>
						
						</div>
						
				</td>

				<td  style="width: 10%;">
					<!--only use for check in time-->
					<div class="griddiv"><label>
						<div class="gridlable" style="width: 100%;">Check-In&nbsp;Time <span class=""></span></div>
						<input type="text" id="checkInTime" name="checkInTime" value="<?php if ($editresult['checkInTime'] != '') {
							echo  date('H:i', strtotime($editresult['checkInTime']));
						} else {
							echo "12:00";
						}  ?>" class="gridfield  timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59" data-show-2400="true" />
						</label>
					</div>
				</td>

				<td style="width: 10%;">
					<div class="griddiv" >
						<div class="gridlable" style="width: 100%;">Check-Out&nbsp;Time <span class=""></span></div>
						<label>
							<!--for checkout time-->
							<input type="text" id="checkOutTime" name="checkOutTime" value="<?php if ($editresult['checkOutTime'] != '') { echo  date('H:i', strtotime($editresult['checkOutTime']));
							} else { echo "11:00"; } ?>" class="gridfield  timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="11:00" data-max-time="10:59" data-show-2400="true" />
						</label>
					</div>
				</td>

				<td>
					<div class="griddiv"><label>
						<div class="gridlable">Hotel Link</div>
						<input name="url" type="text" class="gridfield" id="url" value="<?php echo $editresult['url']; ?>" />
						</label>
					</div>
				</td>

				<td>
					<div class="griddiv">
						<label>
							<div class="gridlable">Hotel Amenities</div>
							<select name="hotel_amenities[]" multiple="multiple" class="gridfield js-example-basic-multiple" id="hotel_amenitiesId" displayname="Hotel Amenities" autocomplete="off">
								<option value="">Select</option>
								<?php
								$select = '';
								$where = '';
								$rs = '';
								$select = '*';
								$where = ' 1 order by name asc';
								$rs = GetPageRecord($select, _AMENITIES_MASTER_, $where);
								while ($resListing = mysqli_fetch_array($rs)) {
									$hotelamenities = array_map('trim', explode(",", $editresult['amenities']));
								?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($hotelamenities as $key => $value) {
										if ($resListing['id'] == $value) {
											echo 'selected="selected"';
										}
									} ?>><?php echo strip($resListing['name']); ?></option>
								<?php } ?>
							</select>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>
				<div id="loadweekend" style="margin-top: -20px"><br>
						<div class="gridlable">
							<!-- Days -->
							<span class="redmind"></span></div>
						<div style="border:0px #e0e0e0 solid;margin-top:5px;background-color:#FFFFFF;padding:2px;overflow: auto;height: 29px;">
							<?php
							if ($editresult['weekendDays'] != '') { ?>
								<?php
								$select = '';
								$where = '';
								$rs = '';
								$select = '*';
								$where = ' name!="" and deletestatus=0 and id="' . $editresult['weekendDays'] . '" order by id desc';
								$rs = GetPageRecord($select, _WEEKEND_MASTER_, $where);
								$resListing = mysqli_fetch_array($rs);
								$weekendDays = explode(",", $resListing['weekendDays']);
								foreach ($weekendDays as $key => $value) {
									if ($value == 1) {
										$days = 'Monday';
									}
									if ($value == 2) {
										$days = 'Tuesday';
									}
									if ($value == 3) {
										$days = 'Wednesday';
									}
									if ($value == 4) {
										$days = 'Thursday';
									}
									if ($value == 5) {
										$days = 'Friday';
									}
									if ($value == 6) {
										$days = 'Saturday';
									}
									if ($value == 7) {
										$days = 'Sunday';
									}
								?><div style="padding:3px 10px; float:left; color:#FFFFFF; background-color:#2C8CB1; width:fit-content; margin:3px; border-radius:3px;"><?php echo  $days; ?></div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					<script type="text/javascript" src="js/jquery.timepicker.js"></script>
						<script type="text/javascript">
						$(document).ready(function() {
						$('.timepicker2').timepicker();
						$('.select2').select2();
						});
						</script>
				</td>
			</tr>
	</table>
		<div class="hotelInfoTextArea" style="width: 100%;margin-top: 20px;">
			<table style="width: 100%;">
				<tr>
					<td>
							<div class="griddiv"><label>
								<div class="gridlable">Hotel Information</div>
								<textarea name="hoteldetail" rows="2" class="gridfield" id="hoteldetail"><?php echo stripslashes(stripslashes($editresult['hoteldetail'])); ?></textarea>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="griddiv"><label>
								<div class="gridlable">Policy</div>
								<textarea name="hotelpolicy" rows="2" class="gridfield" id="hotelpolicy"><?php echo $editresult['policy']; ?></textarea>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="griddiv"><label>
								<div class="gridlable">T&C </div>
								<textarea name="hoteltermandcondition" rows="2" class="gridfield" id="hoteltermandcondition"><?php echo stripslashes($editresult['termAndCondition']); ?></textarea>
								</label>
							</div>
						</td>
					</tr>
			</table>
		</div>
	</div>

</div>
<!-- Add more Information Sec Ended  -->






				<div style="display: inline-block;width: 47%;">
					<div class="griddiv" style="display:none;"><label>

							<div class="gridlable">Photo Upload</div>

							<input name="hotelImage" type="file" class="gridfield" id="hotelImage" />

							<input type="hidden" name="oldhotleImage" id="oldhotleImage" value="<?php echo $editresult['hotelImage']; ?>" />

						</label>

					</div>
				</div>


				<script>
					function selectcity() {

						var stateId = $('#stateId2').val();

						$('#cityId2').load('loadcity.php?id=' + stateId + '&selectId=<?php echo $addressData['cityId']; ?>');

					}

					function selectstate() {

						var countryId = $('#countryId2').val();

						$('#stateId2').load('loadstate.php?action=hotelstateselection&id=' + countryId + '&selectId=<?php echo $addressData['stateId']; ?>');

					}
					selectstate();
					<?php

					if ($_GET['id'] != '') {

					?>

						selectstate();

						selectcity();

					<?php } ?>
				</script>
	<div style="display: block;width: 100%;">

		
	</div>


	<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
	<input name="action" type="hidden" id="action" value="add_hoteltomaster" />
	<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
	</form>
	</div>
		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>

				</tr>

			</table>

		</div>
	</div>



	<!--<link href="css/main.css" rel="stylesheet" type="text/css" />

	-->


	<!-- address show hide sec Started Js -->
<script>
function myMoreInfoQuotFunShow() {
var x = document.getElementById("myMoreInfo_hideQuot");

if (x.style.display === "none") {
	x.style.display = "block";
} else {
	x.style.display = "none";
}
}
</script>
<!-- address show hide sec Ended Js -->


	<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.js-example-basic-multiple').select2();

			$('.js-example-basic-single').select2();

		});

		$(document).ready(function() {


			$("#checkallroomType").click(function() {

				if (this.checked) {

					$('.Checkedrmtype').each(function() {

						this.checked = true;

					})

				} else {

					$('.Checkedrmtype').each(function() {

						this.checked = false;

					})

				}

			});

			$("#checkallamnties").click(function() {

				if (this.checked) {

					$('.Checkedamen').each(function() {

						this.checked = true;

					})

				} else {

					$('.Checkedamen').each(function() {

						this.checked = false;

					})

				}

			});



		});

		function allweekend(e) {

			var weekendid = e.value;

			$("#loadweekend").load('loadWeekendDays.php?id=' + weekendid);

			$("#editweekend").hide();

		}
	</script>


	<style>
		.select2-container {

			width: 100% !important;
			;

		}

		.select2-container--open {

			z-index: 9999999999 !important;

		}
	</style>

	<?php
}

if(trim($_REQUEST['action'])=='add_hoteltomaster' && trim($_REQUEST['hotelName'])!=''){


	$hotelName=clean($_POST['hotelName']); 
	$url=clean($_POST['url']); 
  
	$locality=clean($_POST['locality']);
	$hotelCity=clean($_POST['hotelCity']); 
	$hotelChain=clean($_POST['hotelChain']); 
   	$hotelchainname=clean($_POST['name']); 
	$showOnHome=clean($_POST['showOnHome']);  
	$hotelAddress=clean($_POST['hotelAddress']);  
	$hotelCategoryId=clean($_POST['hotelCategoryId']); 
	$hotelTypeId=clean($_POST['hotelTypeId']); 
	$hoteldetail=cleanNonAsciiCharactersInString($_POST['hoteldetail']);
	$hotelpolicy=clean($_POST['hotelpolicy']);
	$hoteltermandcondition=clean($_POST['hoteltermandcondition']);
	//$hotelImage=clean($_POST['hotelImage']);
	$gstn=clean($_POST['gstn']);
	$supplier=$_POST['supplier'];
	//add checkin and check out code
	$checkInTime=date('H:i:s', strtotime($_POST['checkInTime']));
	$checkOutTime=date('H:i:s', strtotime($_POST['checkOutTime']));
    
	
	$weekendid=$_POST['weekend'];
	$hoteldetail=clean($_POST['hoteldetail']);
	$hotel_amenities = implode(',', $_POST['hotel_amenities']);  
	$roomType = implode(',', $_POST['roomType']); 
	// $weekendDays = implode(',', $_POST['weekendDays']); 
	$status=clean($_POST['status']); 
	 
	$countryId=($_POST['countryId2']); 
	$stateId=clean($_POST['stateId2']);
	$cityId=clean($_POST['cityId2']);  
	$pinCode=clean($_POST['pinCode']); 
	 
	 
	if(!empty($_FILES['hotelImage']['name'])){  
		$hotelImageN = str_replace(" ","_",trim($_FILES['hotelImage']['name']));
		$file_name=time().$hotelImageN;  
		copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name);
		$hotelIMagName=$file_name; 
	}
	
	$dateAdded=time();


	$addnewyes = checkduplicate(_PACKAGE_BUILDER_HOTEL_MASTER_,' hotelName="'.$hotelName.'" and hotelCity="'.$hotelCity.'" ');
	if($addnewyes=='yes'){ ?>
		<script>
		alert('Hotel is already exist!!');
		</script>
	 	<?php 
	}else{
		$namevalue ='hotelName="'.$hotelName.'",locality="'.$locality.'",hotelCity="'.$hotelCity.'",policy="'.$hotelpolicy.'",termAndCondition="'.$hoteltermandcondition.'",hotelChain="'.$hotelChain.'",hotelAddress="'.$hotelAddress.'",hoteldetail="'.$hoteldetail.'",hotelCategoryId="'.$hotelCategoryId.'",hotelTypeId="'.$hotelTypeId.'",hotelImage="'.$hotelIMagName.'",gstn="'.$gstn.'",status="'.$status.'",url="'.$url.'",roomType="'.$roomType.'",supplier="'.$supplier.'",amenities="'.$hotel_amenities.'",weekendDays="'.$weekendid.'",hotelCategoryName="'.$reCateHot['name'].'",checkInTime="'.$checkInTime.'",checkOutTime="'.$checkOutTime.'"';  
		$HlastId = addlistinggetlastid(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue); 

		$namevalue ='addressParent="'.$HlastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1,addressType="hotel"';
	    addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);

	    // email shoud add if already added as an operations and now adding with non-operations
	    // Loop for all contact person details
	    $countCP = 1;
	    while($countCP <= $_POST['countCP']){
			$cp_person=trim($_POST["contactPerson".$countCP]);
			$cp_designation=trim($_POST["designation".$countCP]);
			$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
			$cp_email=trim($_POST["email".$countCP]);
			$cp_id=trim($_POST["contactPId".$countCP]);
			$cp_countryCode=trim($_POST["countryCode".$countCP]);
			$cp_division=trim($_POST["division".$countCP]);
			if($cp_division>0 && $cp_email!=''){
				$primaryval=trim($_POST["primaryvalue"]);
				if($countCP==1){
					$cp_primaryvalue=1;
				} else {
					$cp_primaryvalue=0;
				}
				$addnewyes = checkduplicate('hotelContactPersonMaster','email="'.$cp_email.'" and division=3');
				if($addnewyes=='yes' && $cp_division==3){ ?>
					<script>
					// alert('Unable to add hotel details, Email is already exist used as an operations.');
					</script>
				 	<?php 
				}else{
					 
					$cp_allvalue ='contactPerson="'.$cp_person.'",corporateId="'.$HlastId.'",designation="'.$cp_designation.'",phone="'.trim($cp_phone).'",email="'.trim($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
					$cp_id2 = addlisting('hotelContactPersonMaster',$cp_allvalue);

				}
			}
			$countCP++;
		} 

		if($supplier=='1'){ 
		
			$select1='*';  
			$where1='name="'.$hotelCity.'"'; 
			$rs1=GetPageRecord($select1,'destinationMaster',$where1); 
			$destD=mysqli_fetch_array($rs1); 
			
			$rs2='';
			$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' name="'.$hotelName.'" and destinationId="'.$destD['id'].'" '); 
			$suppD=mysqli_fetch_array($rs2); 
			if($suppD['id']>0){ 
				$lastId = $suppD['id'];
				$countCP = 1;
			    while($countCP <= $_POST['countCP']){
					$cp_person=trim($_POST["contactPerson".$countCP]);
					$cp_designation=trim($_POST["designation".$countCP]);
					$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
					$cp_email=trim($_POST["email".$countCP]);
					$cp_id=trim($_POST["contactPId".$countCP]);
					$cp_countryCode=trim($_POST["countryCode".$countCP]);
					$cp_division=trim($_POST["division".$countCP]);
					if($cp_division>0 && $cp_email!=''){
						$primaryval=trim($_POST["primaryvalue"]);
						if($countCP==1){
							$cp_primaryvalue=1;
						} else {
							$cp_primaryvalue=0;
						}

						$addnewyes3 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and division=3 and corporateId!="'.$lastId.'"');
						if($addnewyes3=='yes' && $cp_division==3){ ?>
							<script>
							// alert('Unable to add contact detail, Email is already exist used as an operations.');
							</script>
						 	<?php 
						}else{
							$addnewyes4 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and corporateId="'.$lastId.'"');
							if($addnewyes4=='yes'){
							 	$allcountCP ='contactPerson="'.$cp_person.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
								updatelisting('suppliercontactPersonMaster',$allcountCP,' email="'.encode($cp_email).'" and corporateId="'.$lastId.'"');
							}else{
							 	$allcountCP ='contactPerson="'.$cp_person.'",corporateId="'.$lastId.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",email="'.encode($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
								addlisting('suppliercontactPersonMaster',$allcountCP);
							}
						}
					}
					$countCP++;
				} 
			}else{

				$dateAdded=time();
				$namevalue ='name="'.$hotelName.'",aliasname="'.$hotelName.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',companyTypeId=1,supplierMainType=1,paymentTerm=1,agreement=0,destinationId="'.$destD['id'].'"'; 
				$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);  
				
				$namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  
				addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
					
				$countCP = 1;
			    while($countCP <= $_POST['countCP']){
					$cp_person=trim($_POST["contactPerson".$countCP]);
					$cp_designation=trim($_POST["designation".$countCP]);
					$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
					$cp_email=trim($_POST["email".$countCP]);
					$cp_id=trim($_POST["contactPId".$countCP]);
					$cp_countryCode=trim($_POST["countryCode".$countCP]);
					$cp_division=trim($_POST["division".$countCP]);
					if($cp_division>0 && $cp_email!=''){
						$primaryval=trim($_POST["primaryvalue"]);
						if($countCP==1){
							$cp_primaryvalue=1;
						} else {
							$cp_primaryvalue=0;
						}

						$addnewyes3 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and division=3');
						if($addnewyes3=='yes' && $cp_division==3){ ?>
							<script>
							// alert('Unable to add contact detail, Email is already exist used as an operations.');
							</script>
						 	<?php 
						}else{
						 	$allcountCP ='contactPerson="'.$cp_person.'",corporateId="'.$lastId.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",email="'.encode($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
							addlisting('suppliercontactPersonMaster',$allcountCP);
						}
					}
					$countCP++;
				}

				$gotohotelprice='';
				if($lastIdSupplier!=''){
					//packagehotelmaster&view=yes&hotelId=VGxFOVBRPT0=&supplierId=VGxFOVBRPT0=
					$gotohotelprice = "&view=yes&hotelId=".encode($addid)."&supplierId=".encode($lastId);
				}
			}
		} ?>

		<script>
		//parent.closeinbound();
		//parent.loadquotationmainfile();
		var hotelname = encodeURI('<?php echo $hotelName; ?>');
		 parent.openinboundpop('action=addServiceHotel&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $_REQUEST['daydate']; ?>&hotelname='+hotelname+'','1200px');
		//parent.$('#pageloading').hide();
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();


	</script>

	<?php	} 
	exit();

 }
//for addTransferTimeDetails
if($_REQUEST['action'] == 'addTransferTimeDetails' && $_REQUEST['transferQuoteId'] != ''){ 
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
		$dayData = mysqli_fetch_array($dayQuery);

	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'id="'.$_REQUEST['transferQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);
	// hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$hotelQuotData['transferNameId'].'"');
	$transferData=mysqli_fetch_array($d); 
	
	$dv=GetPageRecord('*','vehicleTypeMaster',' id="'.$hotelQuotData['vehicleType'].'"');
	$vehicleData=mysqli_fetch_array($dv); 
	

	$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'"');
	$transferTimelineData=mysqli_fetch_array($c1);

	if($transferTimelineData['departureDate']!=NULL && $transferTimelineData['departureDate']!='1970-01-01'){
		$departureDate = date('Y-m-d',strtotime($transferTimelineData['departureDate']));
	}else{
		$departureDate = date('Y-m-d',strtotime($dayData['srdate']));
	}
	

 
	?>
	<style>
		.addeditpagebox .griddiv{
			border: none;
		}
	</style>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Transfer Timeline Details | <?php echo date('d M Y ',strtotime($dayData['srdate']))?></span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<thead>
					<tr style="background-color:transparent !important;">
					<td width="13%"><strong>Transfer&nbsp;Name</strong><br>
					<?php echo strip($transferData['transferName']);  ?>
					</td>
					<td width="13%"><strong>Transfer&nbsp;Type</strong><br>
					<?php if($hotelQuotData['transferType']==1){ echo 'SIC'; }elseif($hotelQuotData['transferType']==2){ echo 'PVT'; }  ?>
					<input type="hidden" name="TransferTypeName" value="<?php echo $hotelQuotData['transferType']; ?>">
					</td>
					<!-- <td colspan="4" width="50px"><strong>&nbsp;&nbsp;&nbsp;</strong></td> -->
					<td width="13%">
						<div class="griddiv" style="position:static;color: #333333;">
						<label for="mode" style="font-size:12px;">
						<div class="gridlable"><strong>Mode</strong></div>
						<select id="mode" name="mode" class="gridfield validate" displayname="Mode" autocomplete="off" onchange="transferMode()" style="width: 120px;">
							<option value="">Select Mode</option>
							<option value="flight" <?php if($transferTimelineData['mode']  == 'flight') {  ?> selected="selected" <?php } ?> >Flight</option>
							<option value="train"  <?php if($transferTimelineData['mode']  == 'train') {  ?> selected="selected" <?php } ?> >Train</option>
							<option value="Local"  <?php if($transferTimelineData['mode']  == 'Local') {  ?> selected="selected" <?php } ?> >Local</option>
						</select>
						</label>
						</div>
					</td>
					<!-- <td id="transferTypeId" style="display:none;">
						<div class="griddiv" style="position:static;color: #333333;">
						<label for="mode" style="font-size:12px;">
						<div class="gridlable"><strong>Transfer&nbsp;Type</strong></div>
						<select id="TransferTypeName" name="TransferTypeName" class="gridfield validate" displayname="Transfer Type" autocomplete="off" style="width: 120px;">
							<option value="SIC" <?php if($transferTimelineData['TransferType']  == 'SIC') {  ?> selected="selected" <?php } ?> >SIC</option>
							<option value="PVT"  <?php if($transferTimelineData['TransferType']  == 'PVT') {  ?> selected="selected" <?php } ?> >PVT</option>
							
						</select>
						</label>
						</div>
					</td> -->
					<td colspan="3">&nbsp;</td>
					</tr>
				</thead>
				<tbody>
				<tr id="firstrowId" style="background-color:transparent !important;">
					<td>
						<div class="griddiv" style="position:static;color: #333333;">
						<label for="arrivalFrom" style="font-size:12px;"><strong>Arrival From</strong></label>
						<input name="arrivalFrom" type="text" class="gridfield" id="arrivalFrom" value="<?php echo strip($transferTimelineData['arrivalFrom']);  ?>" > 
						</div>
					</td>

					<td>
					 <div class="griddiv"><label for="arrivalTime" style="font-size:12px;color: #333333;"><strong>ARV/DPT&nbsp;Time</strong></label>
					   <input type="text" id="arrivalTime" name="arrivalTime" style="text-align:left;width:90%;padding: 3px;
    border: 1px solid #ccc;border-radius: 2px;" value="<?php if($transferTimelineData['arrivalTime']!='') { echo  date('H:i',strtotime($transferTimelineData['arrivalTime'])); }  ?>"  class="gridfield  timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"/>
                     </div>
                    </td>
					
					<td width="14%"	>
						<div class="griddiv" id="flightName">
							<label for="flightName" style="font-size:12px;color: #333333;"><strong>Flight&nbsp; Name</strong></label>
 							<input name="flightName" type="text" class="gridfield" id="flightName" value="<?php echo strip($transferTimelineData['flightName']);  ?>">
						</div>
						<div class="griddiv"  id="trainName" style="display: none;">
							<label for="trainName" style="font-size:12px;color: #333333;"><strong>Train&nbsp; Name</strong></label>
 							<input name="trainName" type="text" class="gridfield" id="trainName" value="<?php echo strip($transferTimelineData['trainName']);  ?>">
						</div>

					</td>
					<td>
						<div class="griddiv"  id="flightNumber">
							<label for="flightNumber" style="font-size:12px;color: #333333;"><strong>Flight&nbsp; Number</strong></label>
 								<input name="flightNumber" type="text" class="gridfield" id="flightNumber" value="<?php echo strip($transferTimelineData['flightNumber']);  ?>">
						</div>

						<div class="griddiv" style="display: none;" id="TrainNumber">
							<label for="TrainNumber" style="font-size:12px;color: #333333;"><strong>Train&nbsp; Number</strong></label>
 								<input name="TrainNumber" type="text" class="gridfield" id="TrainNumber" value="<?php echo strip($transferTimelineData['trainNumber']);  ?>">
						</div>

					</td>

					<td id="airportNameId">
						<div class="griddiv"  >
							<label for="airportName" style="font-size:12px;color: #333333;"><strong>Airport Name</strong></label>
 							<input name="airportName" type="text" class="gridfield" id="airportName" value="<?php echo strip($transferTimelineData['airportName']);  ?>">
						</div>

					</td>
  

			  	</tr> 
			  	<tr style="background-color:transparent !important;">
				
				<td id="firstrowId1" style="display:none;">
				<div class="griddiv"  >
							<label for="pickupAddress" style="font-size:12px;color: #333333;"><strong>Date</strong></label>
							<input type="date" name="departureDate" class="gridfield" id="departureDate" value="<?= $departureDate; ?>">
						</div>
				
				</td>
				<?php if($hotelQuotData['transferType']==2){ ?>
				<td id="firstrowId2" style="display:none;">
				<div class="griddiv"  >
							<label for="pickupAddress" style="font-size:12px;color: #333333;"><strong>Vehicle Type</strong></label>
							<input type="text" name="vehicleTypeName" class="gridfield" id="vehicleTypeName" value="<?php echo $vehicleData['name']; ?>">
						</div>
				
				</td>
				<?php  } ?>
				  <td><div class="griddiv"><label for="pickupTime" style="font-size:12px;color: #333333;"><strong>Pick&nbsp;Up&nbsp;Time</strong></label>
 					    <input type="text" id="pickupTime" name="pickupTime" style="text-align:left;width:90%;padding: 3px;
    border: 1px solid #ccc;border-radius: 2px;" value="<?php if($transferTimelineData['pickupTime']!='') { echo  date('H:i',strtotime($transferTimelineData['pickupTime'])); }  ?>"  class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"/>
                       </div>
                    </td>

                    <td><div class="griddiv"><label for="dropTime" style="font-size:12px;color: #333333;"><strong>Drop&nbsp;Time</strong></label> 
					   <input type="text" id="dropTime" name="dropTime" style="text-align:left;width:90%;padding: 3px;
    border: 1px solid #ccc;border-radius: 2px;" value="<?php if($transferTimelineData['dropTime']!='') { echo  date('H:i',strtotime($transferTimelineData['dropTime'])); }  ?>"  class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"/>
                       </div>
                    </td> 
					
					<td>
						<div class="griddiv"  >
							<label for="pickupAddress" style="font-size:12px;color: #333333;"><strong>Pickup Address</strong></label>
 							<input name="pickupAddress" type="text" class="gridfield" id="pickupAddress" value="<?php echo strip($transferTimelineData['pickupAddress']);  ?>">
						</div>

					</td>
					<td>
						<div class="griddiv"  >
							<label for="dropAddress" style="font-size:12px;color: #333333;"><strong>Drop Address</strong></label>
 							<input name="dropAddress" type="text" class="gridfield" id="dropAddress" value="<?php echo strip($transferTimelineData['dropAddress']);  ?>">
						</div>
					</td> 

					<td >
						<label for="dropAddress" style="font-size:12px;color: #333333;"><strong>&nbsp;</strong></label>
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_hoteltomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
 						<input type="hidden" value="<?php echo $hotelQuotData['id']; ?>" name="transferQuoteId"/>
						<input name="action" type="hidden" id="action" value="add_TransferTimeline">
  					</td>

			  	</tr>    
		  		<script type="text/javascript">
                	function transferMode(){
                		var mode = $('#mode').val();
                		
                		if (mode == 'train') {
                		   $('#trainName').show();
                		   $('#TrainNumber').show();
                		   $('#airportNameId').hide();

                		   $('#flightName').hide();
                		   $('#flightNumber').hide();
						   $('#firstrowId1').hide();
						   $('#firstrowId2').hide();
						   $('#secrowId').show();
                		   $('#firstrowId').show();
                		}
                		if (mode == 'flight') {
                		   $('#flightName').show();
                		   $('#flightNumber').show();

						   $('#airportNameId').show();

                		   $('#trainName').hide();
                		   $('#TrainNumber').hide();
						   $('#firstrowId1').hide();
						   $('#firstrowId2').hide();
						   $('#secrowId').show();
                		   $('#firstrowId').show();
                		}
						if (mode == 'Local') {
                		   $('#firstrowId1').show();
                		   $('#firstrowId2').show();
                		   $('#secrowId').hide();
                		   $('#firstrowId').hide();
							
                		}

                	}
                	transferMode();
				
                </script>
				<script type="text/javascript" src="js/jquery.timepicker.js"></script> 
				<script type="text/javascript"> 
					$(document).ready(function(){
						$('.timepicker2').timepicker();	
					});  
				</script>
				</tbody>
			</table>
			</form>
		</div>
	</div>

	<?php
}

if(trim($_REQUEST['action'])=='add_TransferTimeline' && trim($_REQUEST['transferQuoteId'])!=''){

	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' id="'.$_REQUEST['transferQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);

	$c1=GetPageRecord('id','quotationTransferTimelineDetails',' transferQuoteId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'"');
	if(mysqli_num_rows($c1) == 0){

		
		if(!empty($_REQUEST['arrivalTime'])){
			$arrivalTime = date('H:i:s', strtotime($_REQUEST['arrivalTime']));
		}else{
			$arrivalTime = '';
		}
		if(!empty($_REQUEST['dropTime'])){
           $dropTime = date('H:i:s', strtotime($_REQUEST['dropTime']));
		}else{
           $dropTime = '';
		}
		if(!empty($_REQUEST['pickupTime'])){
		   $pickupTime = date('H:i:s', strtotime($_REQUEST['pickupTime']));
		}else{
           $pickupTime = '';
		}
		if(!empty($_REQUEST['departureDate'])){
			$departureDate = date('Y-m-d', strtotime($_REQUEST['departureDate']));
		 }else{
			$departureDate = '';
		 }

		$namevalue ='quotationId="'.$hotelQuotData['quotationId'].'",departureDate="'.$departureDate.'",transferType="'.$_REQUEST['TransferTypeName'].'",dayId="'.$_REQUEST['dayId'].'",supplierId="'.$hotelQuotData['supplierId'].'",transferQuoteId="'.$hotelQuotData['id'].'",arrivalFrom="'.$_REQUEST['arrivalFrom'].'",trainName="'.$_REQUEST['trainName'].'",trainNumber="'.$_REQUEST['TrainNumber'].'",flightName="'.$_REQUEST['flightName'].'",flightNumber="'.$_REQUEST['flightNumber'].'",vehicleName="'.$_REQUEST['vehicleName'].'",airportName="'.$_REQUEST['airportName'].'",pickupAddress="'.$_REQUEST['pickupAddress'].'",dropAddress="'.$_REQUEST['dropAddress'].'",VehicleModel="'.$_REQUEST['VehicleModel'].'",arrivalTime="'.$arrivalTime.'",dropTime="'.$dropTime.'",mode="'.$_REQUEST['mode'].'",pickupTime="'.$pickupTime.'"';
		$hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);

	}else{
		$transferTimelineData=mysqli_fetch_array($c1);
		$where = " id ='".$transferTimelineData['id']."'";

		
		if(!empty($_REQUEST['arrivalTime'])){
			$arrivalTime = date('H:i:s', strtotime($_REQUEST['arrivalTime']));
		}else{
			$arrivalTime = '';
		}
		if(!empty($_REQUEST['dropTime'])){
           $dropTime = date('H:i:s', strtotime($_REQUEST['dropTime']));
		}else{
           $dropTime = '';
		}
		if(!empty($_REQUEST['pickupTime'])){
		   $pickupTime = date('H:i:s', strtotime($_REQUEST['pickupTime']));
		}else{
           $pickupTime = '';
		}
		if(!empty($_REQUEST['departureDate'])){
			$departureDate = date('Y-m-d', strtotime($_REQUEST['departureDate']));
		 }else{
			$departureDate = '';
		 }


		$namevalue ='quotationId="'.$hotelQuotData['quotationId'].'",departureDate="'.$departureDate.'",transferType="'.$_REQUEST['TransferTypeName'].'",dayId="'.$_REQUEST['dayId'].'",supplierId="'.$hotelQuotData['supplierId'].'",transferQuoteId="'.$hotelQuotData['id'].'",arrivalFrom="'.$_REQUEST['arrivalFrom'].'",trainName="'.$_REQUEST['trainName'].'",trainNumber="'.$_REQUEST['TrainNumber'].'",flightName="'.$_REQUEST['flightName'].'",flightNumber="'.$_REQUEST['flightNumber'].'",vehicleName="'.$_REQUEST['vehicleName'].'",airportName="'.$_REQUEST['airportName'].'",pickupAddress="'.$_REQUEST['pickupAddress'].'",dropAddress="'.$_REQUEST['dropAddress'].'",VehicleModel="'.$_REQUEST['VehicleModel'].'",arrivalTime="'.$arrivalTime.'",dropTime="'.$dropTime.'",mode="'.$_REQUEST['mode'].'",pickupTime="'.$pickupTime.'"';
		$hotelSupHot = updatelisting('quotationTransferTimelineDetails',$namevalue,$where);
	}
 	?>
	<script>
		parent.closeinbound();
		parent.loadquotationmainfile();
  		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}

if(trim($_REQUEST['action'])=='add_SupplementHotel' && trim($_REQUEST['hotelQuoteId'])!=''){

	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);

	$c1=GetPageRecord('*','quotationRoomSupplimentMaster',' hotelQuoteId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'"');
	if(mysqli_num_rows($c1) == 0){

		$namevalue ='quotationId="'.$hotelQuotData['quotationId'].'",dayId="'.$_REQUEST['dayId'].'",supplierId="'.$hotelQuotData['supplierId'].'",supplierMasterId="'.$hotelQuotData['supplierMasterId'].'",hotelQuoteId="'.$hotelQuotData['id'].'",mealPlan="'.$_REQUEST['mealPlan'].'",roomType="'.$_REQUEST['roomType'].'",singleoccupancy="'.$_REQUEST['singleoccupancy'].'",doubleoccupancy="'.$_REQUEST['doubleoccupancy'].'",twinoccupancy="'.$_REQUEST['doubleoccupancy'].'",tripleoccupancy="'.$_REQUEST['tripleoccupancy'].'",childwithbed="'.$_REQUEST['childwbed'].'",childwithoutbed="'.$_REQUEST['childwobed'].'",lunch="'.$_REQUEST['lunch'].'",dinner="'.$_REQUEST['dinner'].'",extraadult="'.$_REQUEST['extraadult'].'"';
		$hotelSupHot = addlistinggetlastid('quotationRoomSupplimentMaster',$namevalue);

	}
	?>
	<script>
		parent.closeinbound();
		parent.loadquotationmainfile();
  		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}

if($_REQUEST['action'] == 'addtransfertomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Transfer/Transportation</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_transfertomaster" target="actoinfrm" id="add_transfertomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="    float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Transfer/Transportation Name<span class="redmind"></span></div>
						<input name="transferName" type="text" class="gridfield validate" id="transferName" displayname="Transfer Name" value="">
						</label>
						</div>

						<div class="griddiv" style="position:static;">
							<label>
								<div>Category</div>
									<select id="transferCategory" name="transferCategory" class="gridfield" displayname="Transfer Category" autocomplete="off"  >
									<option value="transportation" <?php if($_REQUEST['tc']==3){ ?> selected="selected" <?php } ?> >Transportation</option>
									<option value="transfer" <?php if($_REQUEST['tc']==1){ ?> selected="selected" <?php } ?> >Transfer</option>
									</select>
							</label>
						</div>  
						<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;">

						<div class="griddiv">
							<label>
								<div class="gridlable">Vehical Type</div>
								<select id="vehicleId" name="vehicleId" class="gridfield"  autocomplete="off" onchange="getVehicleModel()">
									<option value="all">All Vehicle Type</option>
									<?php
									$rs=GetPageRecord('name,id','vehicleTypeMaster',' 1 order by name asc');
									while($resListing=mysqli_fetch_array($rs)){
									?>
									<option value="<?php echo strip($resListing['id']); ?>"><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
							  </select>
							</label>
						</div>

						<div class="griddiv">
							<label>
								<div class="gridlable">Transfer Type</div>
								<select id="transferType" name="transferType" class="gridfield"  autocomplete="off">
									<?php
									$rs=GetPageRecord('name,id','transferTypeMaster','1 and deletestatus=0 and status=1 order by id asc');
									while($resListing=mysqli_fetch_array($rs)){
									?>
									<option value="<?php echo strip($resListing['id']); ?>"><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
							  </select>
							</label>
						</div>
					</div>

						<div class="griddiv" style="display:none;">
								<label>
									<div class="gridlable">Vehical Model</div>
									<select id="vehicleModelId" name="vehicleModelId" class=" gridfield"  autocomplete="off">
										<option value="all">All Vehicles</option>
										<?php
										$select='*';
										$where=' 1 order by id asc';
										$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where);
										while($resListing=mysqli_fetch_array($rs)){
										?>
										<option value="<?php echo $resListing['id']; ?>" <?php if($queryData['vehicleId']==$resListing['id']){ ?> selected="selected" <?php } ?>><?php echo $resListing['model']; ?></option>
										<?php } ?>
									</select>
								</label>
							</div>

						<script type="text/javascript">
                                 function getVehicleModel() {
						              var vehicleId = $('#vehicleId').val();
						              $("#vehicleModelId").load('loadvehiclemodel.php?vehicleTypeId='+vehicleId+'&dayId=<?php echo $_REQUEST['dayId']; ?>');
						            }
						</script>

					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
					<tr style="background-color:transparent !important;">
						<td width="100" align="left">
							<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_transfertomaster','submitbtn','0');">
							<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
							<input type="hidden" value="<?php echo $_REQUEST['cityId']; ?>" name="cityId"/>
							<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
							<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
							<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
							<input type="hidden" value="<?php echo $_REQUEST['tc']; ?>" name="tc"/>
							<input name="action" type="hidden" id="action" value="add_transfertomaster">
							<?php if($_REQUEST['tc'] == 3){ ?>
							<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceTransportation&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','1200px');">
							<?php } else{ ?>
							<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceTransfer&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','1200px');">
							<?php } ?>
							

						</td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>

	<?php
}
if(trim($_REQUEST['action'])=='add_transfertomaster' && trim($_REQUEST['transferName'])!=''){

	$transferName=clean($_REQUEST['transferName']);
	$vehicleId=clean($_REQUEST['vehicleId']);
	$vehicleModelId=clean($_REQUEST['vehicleModelId']);
	$transferCategory=clean($_REQUEST['transferCategory']);
	$transferType=clean($_REQUEST['transferType']);

	$quotationId = $_REQUEST['quotationId'];
	$cityId = $_REQUEST['cityId'];
	$queryId = $_REQUEST['queryId'];
	$startDayId = $_REQUEST['dayId'];
	$fromDate = $_REQUEST['daydate'];

	$selfSupplier = getSelfSupplier();
	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	$dateAdded=time();
	$namevalue ='transferName="'.$transferName.'",transferType="'.$transferType.'",destinationId="'.$cityId.'",transferCategory="'.$transferCategory.'",status="1"';
	$lastid=addlistinggetlastid(_PACKAGE_BUILDER_TRANSFER_MASTER,$namevalue);

		$namevalue ='fromDate="'.date('Y-m-d').'",toDate="'.date('Y-m-d', strtotime('12/31')).'",vehicleTypeId="'.$vehicleId.'",vehicleModelId="'.$vehicleModelId.'",transferType="'.$transferType.'",currencyId="'.$resListing['id'].'",status="1",supplierId="'.$selfSupplier.'",serviceid="'.$lastid.'",transferNameId="'.$lastid.'"';
	 	$lastId2 = addlistinggetlastid(_DMC_TRANSFER_RATE_MASTER_,$namevalue);


 
	?>
	<script>
		//parent.closeinbound();
			parent.loadquotationmainfile();
			<?php if($_REQUEST['tc'] == 3){ ?>
			var action = "addServiceTransportation";
			<?php } else{ ?>
			var action = "addServiceTransfer";
			<?php } ?>	
			var transferNameId = encodeURI('<?php echo $lastid; ?>'); 
			parent.openinboundpop('action='+action+'&dayId=<?php echo $_REQUEST['dayId']; ?>&transferNameId='+transferNameId+'','1200px');
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();

	</script>
	<?php
}

 
// Add New restaurant Form start here============================

if($_REQUEST['action'] == 'addNewRestaurant'){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add New Restaurant</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="loadsaveMealplans.php" method="get"  name="addedit_newQuotationMeals" target="actoinfrm" id="addedit_newQuotationMeals">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Restaurant Name<span class="redmind"></span></div>
						<input type="text" name="newmealPlanName" class="gridfield validate" id="newmealPlanName" displayname="Restaurant Name" value="">
						</label>
						</div>
						
						<div class="griddiv" style="position:static;">
						<label>
							<div class="gridlable">Meal&nbsp;Type</div> 
							<select id="mealPlanmealType" name="mealPlanmealType" class="gridfield validate" displayname="Meal Type" autocomplete="off">
							<option value="">Select Meal Type</option>
							<?php   
							$rs2=GetPageRecord('*','restaurantsMealPlanMaster','status = 1 and deletestatus=0'); 
							while($userss=mysqli_fetch_array($rs2)){
								?>
								<option value="<?Php echo $userss['id']; ?>"><?Php echo $userss['name']; ?></option>
								<?php 
							} ?>
							</select>
						</label>
					  </div>

						<div class="griddiv"><label> 
						<div class="gridlable">Currency<span class="redmind"></span></div> 
						<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off" >  
						 <?php  
						
						 $select=''; 
						 $where=''; 
						 $rs='';  
						 $select='*';    
						 $where=' deletestatus=0 and status=1 order by name asc';  
						 $rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
						 while($resListing=mysqli_fetch_array($rs)){   
						?> 
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault'] == 1){ echo "selected"; } ?> ><?php echo strip($resListing['name']); ?></option> 
						<?php } ?> 
						</select> 
						</label>  
						</div>

						<div class="griddiv">
							<label>
								<div class="gridlable"> Per Pax Cost <span class="redmind"></div>
								<input name="mealPlanadultCost" type="number" class="gridfield number_only "  id="mealPlanadultCost" displayname="Per Pax Cost" value="">
							</label>
						</div>

					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value=" Save" onclick="formValidation('addedit_newQuotationMeals','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $_REQUEST['destinationId']; ?>" name="destinationId"/>
						<input type="hidden" value="<?php echo $dayData['cityId']; ?>" name="cityId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input name="action" type="hidden" id="action" value="addedit_newQuotationMeals">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
<?php

}
// Add New restuarant Form end here ============================
if(trim($_REQUEST['action'])=='add_NewRestaurant' && trim($_REQUEST['newrestaurant'])!=''){


	$newrestaurant=clean($_REQUEST['newrestaurant']);
 	$ContactPerson=clean($_REQUEST['ContactPerson']);
	$restuarantprice=clean($_REQUEST['restuarantprice']);


	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$destinationId = $_REQUEST['destinationId'];

	$rs1=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.clean($_REQUEST['destinationId']).'"');
	$destData=mysqli_fetch_array($rs1);
	$additionalCity = stripslashes($destData['name']);

	$startDayId = $_REQUEST['dayId'];
	$fromDate = $_REQUEST['daydate'];


	$dateAdded=time();
	$namevalue ='name="'.$newrestaurant.'",contactperson="'.$ContactPerson.'",price="'.$restuarantprice.'",status="1"';
	$lastid=addlistinggetlastid('suppliersMaster',$namevalue);

	?>
<script>
	parent.openinboundpop('action=addServiceMealPlan&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $fromDate; ?>&additionalId=<?php echo $lastid; ?>','800px');
	parent.$('#pageloading').hide();
	parent.$('#pageloader').hide();

	</script>

	<?php
}

// Add New restuarant end here ============================
if($_REQUEST['action'] == 'addadditionaltomaster'){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	$editdestinationId = $dayData['cityId'];
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Additional</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
	
			<form action="inboundpop.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
				<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
				<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
				<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
				 
				<div class="griddiv"><label>
					<div class="gridlable">Additional Name<span class="redmind"></span></div>
					<input name="name" type="text" class="gridfield validate" id="name" displayname="Additional Name" value="" maxlength="100" />
					</label>
				</div>
				<!-- new added for destination fields by islam -->
				
				<div class="griddiv"><label>
					<!-- destination code -->
						<div class="gridlable">Destination<span class="redmind"></span></div>
						<select id="destinationIda" multiple="multiple" name="destinationId[]" class="gridfield js-example-basic-multiple" displayname="Destination" autocomplete="off">
						<option value="All" <?php if($editdestinationId=='All') { echo 'selected="selected"';} ?> >All</option>
							<?php
							$select = '';
							$where = '';
							$rs = '';
							$select = '*';
							$where = ' 1 and deletestatus = 0 order by name asc';
							$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
							$alldest=explode(',',$editdestinationId);  
							while ($resListing = mysqli_fetch_array($rs)) {
							?>
							<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> <?php } ?> 
						</select>
					</label>
				</div>

				<div class="grid-container">	

					<div class="griddiv grid-box" ><label>
						<div class="">Tax&nbsp;SLAB(%)<span class="redmind"></span></div>
						<select id="gstTax" name="gstTax" class="gridfield" displayname="Tax SLAB" autocomplete="off" style="width: 100%;" >
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1 order by gstValue asc'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){ ?>
								<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
					</div>

					<div class="griddiv grid-box" >
						<label>
							<div class="gridlable">Markup&nbsp;Apply</div>
							<select id="isMarkupApply" type="text" class="gridfield" name="isMarkupApply" autocomplete="off" style="width: 100%;" onchange="markupApplyStatus(this.value)">
								<option value="0" <?php if ($editresult['isMarkupApply'] == '0') { ?>selected="selected" <?php } ?>>YES</option>
								<option value="1" <?php if ($editresult['isMarkupApply'] == '1') { ?>selected="selected" <?php } ?>>NO</option>
							</select>
						</label> 
					</div>

				</div>

				<div class="grid-container">	
					<div class="griddiv grid-box" ><label>
							<div class="gridlable">Currency<span class="redmind"></span></div>
							<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off">
								<?php
								$rs = '';
								$rs = GetPageRecord('*', _QUERY_CURRENCY_MASTER_, ' deletestatus=0 and status=1 order by name asc');
								while ($resListing = mysqli_fetch_array($rs)) {
								?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $baseCurrencyId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
								<?php } ?>
							</select>
						</label>
					</div>
					<div class="griddiv grid-box" >
						<label>
							<div class="gridlable">Cost&nbsp;Type</div>
							<select id="costType" type="text" class="gridfield" name="costType" autocomplete="off" style="width: 100%;" onchange="selectcost(this.value);">
								<option value="1" <?php if ($editresult['costType'] == '1') { ?>selected="selected" <?php } ?>>Per Person</option>
								<option value="2" <?php if ($editresult['costType'] == '2') { ?>selected="selected" <?php } ?>>Group Cost</option>
							</select>
						</label>
					</div>
				</div>

				<div class="griddiv pp" style="display:none;"><label>

						<div class="gridlable" style="width:100%">Adult&nbsp;Cost</div>
						<input name="adultCost" type="number" class="gridfield" id="adultCost" displayname="Adult Cost" value="<?php echo $adultCost; ?>" maxlength="6" />

					</label>

				</div>

				<div class="griddiv pp" style="display:none;"><label>

					<div class="gridlable" style="width:100%">Child&nbsp;Cost</div>

					<input name="childCost" type="number" class="gridfield" id="childCost" displayname="Child Cost" value="<?php echo $childCost; ?>" maxlength="6" />

					</label>

				</div>

				<div class="griddiv pp" style="display:none;"><label>

					<div class="gridlable" style="width:100%">Infant&nbsp;Cost</div>

					<input name="infantCost" type="number" class="gridfield" id="infantCost" displayname="Infant Cost" value="<?php echo $infantCost; ?>" maxlength="6" />

					</label>

				</div>


				<div class="griddiv tot" style="display:none;"><label>

					<div class="gridlable">Group/Total&nbsp;Cost</div>

					<input name="groupCost" type="number" class="gridfield" id="groupCost" displayname="Group Cost" value="<?php echo $groupCost; ?>" maxlength="6" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Show in Proposal</div>

						<select id="proposalService" type="text" class="gridfield" name="proposalService" displayname="Status" autocomplete="off" style="width: 100%;">

							<option value="1" <?php if ($editresult['proposalService'] == '1') { ?>selected="selected" <?php } ?>>Yes</option>

							<option value="0" <?php if ($editresult['proposalService'] == '0') { ?>selected="selected" <?php } ?>>No</option>

						</select>
					</label>

				</div>

				<div class="griddiv"><label>
						<div class="gridlable">Status</div>
						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

							<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<div class="griddiv"><label>
						<div class="gridlable">Add Image</div>
						<input name="AdditionalImage" type="file" class="gridfield" id="trainImage" />
					</label>
				</div>

				<div class="griddiv"><label>

					<div class="gridlable">Description</div>
					<textarea name="additionalDetail" rows="5" class="gridfield" id="additionalDetail"><?php echo strip($editresult['otherInfo']); ?></textarea>
						</label>
				</div>

				<input type="hidden" name="fromQuotation" id="fromQuotation" value="<?php echo 'fromQuotation' ?>">
				<input name="action" type="hidden" id="action" value="addedit_additionalRequirement" />

			</form>
			<style>
				.select2-container {
					width: 100% !important;
				}
				.select2-container--open {
					z-index: 9999999999 !important;
				} 
				.grid-container{
					display: grid;
					grid-template-columns:49% 49%;	
					grid-gap:10px; 
				} 
				.grid-box{
					width: 165px;
				}
			</style>
			<script>
				$('.js-example-basic-multiple').select2();  
		 		// $('.js-example-basic-multiple').on("select2:select", function (e) { 
		        //    var data = e.params.data.text;
		        //    if(data=='All'){
		        //     $(".js-example-basic-multiple > option").prop("selected","selected");
		        //     $(".js-example-basic-multiple").trigger("change");
		        //    }
		    	//   }); 
			 	
			 	function selectcost(costType) {
					if (costType == 1 || costType == 0) {
						$('.pp').show();
						$('.tot').hide(); 
						$('#groupCost').val('');
					}
					if (costType == 2) {
						$('.pp').hide();
						$('.tot').show(); 
						$('#adultCost').val('');
						$('#childCost').val('');
						$('#infantCost').val('');
					}
				} 
				selectcost(<?php echo ($editresult['costType']>0) ? $editresult['costType'] : 1; ?>);

				function markupApplyStatus(selectedValue) {
				    if (selectedValue == 1) {
				        console.log("The selected value is "+selectedValue+". Passing value 2 to the function.");
				        selectcost(2);
				        $('#costType').val(2)
				    } else {
				        console.log("The selected value is "+selectedValue+". Passing the original value to the function.");
				    }
				}

			</script>
			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>

					</tr>

				</table>

				</div>

		</div>
	</div>
<?php
} 
if(trim($_POST['action'])=='addedit_additionalRequirement' && trim($_POST['name'])!=''){ 
	$name=clean($_POST['name']);
	$fromDate = $_REQUEST['daydate'];
	$status=clean($_POST['status']);
	$adultCost=clean($_POST['adultCost']);  
	$childCost=clean($_POST['childCost']);  
	$infantCost=clean($_POST['infantCost']);  
	$groupCost=clean($_POST['groupCost']);  
	$costType=clean($_POST['costType']);  
	$gstTax=clean($_POST['gstTax']);  
	$isMarkupApply=clean($_POST['isMarkupApply']);  

	$currencyId=clean($_POST['currencyId']);
	$additionalDetail=clean($_POST['additionalDetail']);
	$destinationList = implode(',', $_POST['destinationId']); 

	if(!empty($_FILES['AdditionalImage']['name'])){  
		$file_name=time().$_FILES['AdditionalImage']['name'];  
		copy($_FILES['AdditionalImage']['tmp_name'],"packageimages/".$file_name); 
	}else{ 
		$file_name=$_REQUEST['AdditionalImage2'];
	}
	$dateAdded=time();
	
	// duplicate added code
	$rsr=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,'name="'.$name.'" ');
	// $editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('This name Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }else{
		$namevalue ='name="'.$name.'",status="'.$status.'",gstTax="'.$gstTax.'",isMarkupApply="'.$isMarkupApply.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",groupCost="'.$groupCost.'",costType="'.$costType.'",currencyId="'.$currencyId.'",file_extra="'.$file_name.'",destinationId="'.$destinationList.'",additionalId="'.$additionalDetail.'"';  

			$adds = addlisting(_EXTRA_QUOTATION_MASTER_,$namevalue); 
	
		}
		?>
		<script>
			// parnt.closeinbound();
			// parent.loadquotationmainfile(); 
			parent.openinboundpop('action=addServiceAdditional&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $fromDate; ?>','800px');
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
			
		</script>	
		<?php
	 } 
 
if($_REQUEST['action'] == 'addflighttomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Flight</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_flighttomaster" target="actoinfrm" id="add_flighttomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="    float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Flight Name<span class="redmind"></span></div>
						<input name="flightName" type="text" class="gridfield validate" id="flightName" displayname="Flight Name" value="">
						</label>
						</div>

					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_flighttomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $dayData['cityId']; ?>" name="destinationId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input name="action" type="hidden" id="action" value="add_flighttomaster">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>

<?php
}

if(trim($_REQUEST['action'])=='add_flighttomaster' && trim($_REQUEST['flightName'])!=''){


	$flightName=clean($_REQUEST['flightName']);
	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$startDayId = $_REQUEST['dayId'];
	$fromDate = $_REQUEST['daydate'];


	$dateAdded=time();
	$namevalue ='flightName="'.$flightName.'",status="1"';
	$lastid=addlistinggetlastid('packageBuilderAirlinesMaster',$namevalue);

	?>
	<script>
		parent.openinboundpop('action=addServiceFlight&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $fromDate; ?>&flightId=<?php echo $lastid; ?>','1200px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();

	</script>
	<?php
}


if($_REQUEST['action'] == 'addtraintomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Train</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_traintomaster" target="actoinfrm" id="add_traintomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="    float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Train Name<span class="redmind"></span></div>
						<input name="trainName" type="text" class="gridfield validate" id="trainName" displayname="Train Name" value="">
						</label>
						</div>

					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_traintomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $dayData['cityId']; ?>" name="destinationId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input name="action" type="hidden" id="action" value="add_traintomaster">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>

<?php
}

if(trim($_REQUEST['action'])=='add_traintomaster' && trim($_REQUEST['trainName'])!=''){


	$trainName=clean($_REQUEST['trainName']);
	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$startDayId = $_REQUEST['dayId'];
	$fromDate = $_REQUEST['daydate'];


	$dateAdded=time();
	$namevalue ='trainName="'.$trainName.'",status="1"';
	$lastid=addlistinggetlastid('packageBuilderTrainsMaster',$namevalue);

	?>
	<script>
		parent.openinboundpop('action=addServiceTrains&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $fromDate; ?>&trainId=<?php echo $lastid; ?>','1200px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}

// Add Guide to Master
if($_REQUEST['action'] == 'addguidetomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add TourEscort</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="tomasterform" target="actoinfrm" id="tomasterform">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Guide Name<span class="redmind"></span></div>
						<input name="guideName" type="text" class="gridfield validate" id="guideName" displayname="Guide Name" value="">
						</label>
						</div>
 
					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('tomasterform','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['cityId']; ?>" name="cityId"/>
 						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input name="action" type="hidden" id="action" value="add_guidetomaster">
 						<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceGuide&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','1000px');">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
	<?php
}

if(trim($_REQUEST['action'])=='add_guidetomaster' && trim($_REQUEST['guideName'])!=''){

	$guideName=clean($_REQUEST['guideName']);
	$perPaxCost = clean($_REQUEST['perPaxCost']);
	if($perPaxCost>0){
		$adultCost = $perPaxCost;
	}else{
		$adultCost = clean($_REQUEST['adultCost']);
	}
	
	$childCost = clean($_REQUEST['childCost']);
	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$fromDate = $_REQUEST['daydate'];
	$cityId = $_REQUEST['cityId'];
	$selfSupplier = getSelfSupplier();
	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	$dateAdded=time();

	$rsr=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'name="'.$guideName.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('This Guide Name Already Exist !');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }
    else{

		$namevalue ='name="'.$guideName.'",destinationId="'.$cityId.'",status="1"';
		$lastid=addlistinggetlastid(_GUIDE_SUB_CAT_MASTER_,$namevalue);
		?>
		<script>
			parent.openinboundpop('action=addServiceGuide&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $dayData['cityId']; ?>','1000px');
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
		</script>
		<?php
	}


	// $namevalue ='fromDate="'.date('Y-m-d',strtotime($fromDate)).'",toDate="'.date('Y-m-d',strtotime($fromDate)).'",ticketAdultCost="'.$adultCost.'",ticketchildCost="'.$childCost.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$resListing['id'].'",status=1,supplierId="'.$selfSupplier.'",serviceid="'.$lastid.'",entranceNameId="'.$lastid.'"';
	 // $lastId2 = addlistinggetlastid(_DMC_ENTRANCE_RATE_MASTER_,$namevalue);
	?>
	<script>
		parent.openinboundpop('action=addServiceGuide&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $dayData['cityId']; ?>','1000px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}

// Add Guide to Master
if($_REQUEST['action'] == 'addactivitytomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Sightseeing</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="tomasterform" target="actoinfrm" id="tomasterform">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Sightseeing Name<span class="redmind"></span></div>
						<input name="activityName" type="text" class="gridfield validate" id="activityName" displayname="Activity Name" value="">
						</label>
						</div>
 
					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('tomasterform','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['cityId']; ?>" name="cityId"/>
 						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input name="action" type="hidden" id="action" value="add_activitytomaster">
 						<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceActivity&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','1000px');">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
	<?php
}

if(trim($_REQUEST['action'])=='add_activitytomaster' && trim($_REQUEST['activityName'])!=''){

	$activityName=clean($_REQUEST['activityName']);
	$perPaxCost = clean($_REQUEST['perPaxCost']);
	if($perPaxCost>0){
		$adultCost = $perPaxCost;
	}else{
		$adultCost = clean($_REQUEST['adultCost']);
	}
	
	$childCost = clean($_REQUEST['childCost']);
	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$fromDate = $_REQUEST['daydate'];
	$cityId = $_REQUEST['cityId'];
	$otherActivityCity = getDestination($_REQUEST['cityId']);
	$selfSupplier = getSelfSupplier();
	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	$dateAdded=time();

	$rsr=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'otherActivityName="'.$activityName.'" and otherActivityCity="'.$otherActivityCity.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('This Activity Name Already Exist !');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }
    else{
	    	
		$namevalue ='otherActivityName="'.$activityName.'",otherActivityCity="'.$otherActivityCity.'",status=1';
		$lastid=addlistinggetlastid(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$namevalue);

		?>
		<script>
			parent.openinboundpop('action=addServiceActivity&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $dayData['cityId']; ?>','1000px');
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
		</script>
		<?php
	}


	// $namevalue ='fromDate="'.date('Y-m-d',strtotime($fromDate)).'",toDate="'.date('Y-m-d',strtotime($fromDate)).'",ticketAdultCost="'.$adultCost.'",ticketchildCost="'.$childCost.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$resListing['id'].'",status=1,supplierId="'.$selfSupplier.'",serviceid="'.$lastid.'",entranceNameId="'.$lastid.'"';
	 // $lastId2 = addlistinggetlastid(_DMC_ENTRANCE_RATE_MASTER_,$namevalue);
	?>
	<script>
		parent.openinboundpop('action=addServiceActivity&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $dayData['cityId']; ?>','1000px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
} 

if($_REQUEST['action'] == 'addentrancetomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Entrance</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_entrancetomaster" target="actoinfrm" id="add_entrancetomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Entrance Name<span class="redmind"></span></div>
						<input name="entranceName" type="text" class="gridfield validate" id="entranceName" displayname="Entrance Name" value="">
						</label>
						</div>
 
					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_entrancetomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input type="hidden" value="<?php echo $dayData['cityId']; ?>" name="cityId"/>
 						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input name="action" type="hidden" id="action" value="add_entrancetomaster">
 						<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceEntrance&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','800px');">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
	<?php
}

if(trim($_REQUEST['action'])=='add_entrancetomaster' && trim($_REQUEST['entranceName'])!=''){

	$entranceName=clean($_REQUEST['entranceName']);
	$perPaxCost = clean($_REQUEST['perPaxCost']);
	if($perPaxCost>0){
		$adultCost = $perPaxCost;
	}else{
		$adultCost = clean($_REQUEST['adultCost']);
	}
	
	$childCost = clean($_REQUEST['childCost']);
	

	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$startDayId = $_REQUEST['dayId'];
	$fromDate = $_REQUEST['daydate'];
	$cityId = $_REQUEST['cityId'];
	$entranceCity = getDestination($cityId);
	$selfSupplier = getSelfSupplier();
	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	$dateAdded=time();

	$rsr=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'entranceName="'.$entranceName.'" and entranceCity="'.$entranceCity.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('This Activity Name Already Exist !');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }
    else{
	    	
		$namevalue ='entranceName="'.$entranceName.'",entranceCity="'.$entranceCity.'",status="1"';
		$lastid=addlistinggetlastid(_PACKAGE_BUILDER_ENTRANCE_MASTER_,$namevalue);

		?>
		<script>
			parent.openinboundpop('action=addServiceGuide&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $dayData['cityId']; ?>','1000px');
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
		</script>
		<?php
	}


	// $namevalue ='fromDate="'.date('Y-m-d',strtotime($fromDate)).'",toDate="'.date('Y-m-d',strtotime($fromDate)).'",ticketAdultCost="'.$adultCost.'",ticketchildCost="'.$childCost.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$resListing['id'].'",status="1",supplierId="'.$selfSupplier.'",serviceid="'.$lastid.'",entranceNameId="'.$lastid.'"';
	 // $lastId2 = addlistinggetlastid(_DMC_ENTRANCE_RATE_MASTER_,$namevalue);

	?>
	<script>
		parent.openinboundpop('action=addServiceEntrance&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $dayData['cityId']; ?>','1200px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}
 
if($_REQUEST['action'] == 'addactivitiestomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);

	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Activity</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>

	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_entrancetomaster" target="actoinfrm" id="add_entrancetomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Activity Name<span class="redmind"></span></div>
						<input name="activityName" type="text" class="gridfield validate" id="activityName" displayname="Activity Name" value="">
						</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Supplier<span class="redmind"></span></div>
						<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Supplier" autocomplete="off" > 
						<?php     
						$rs1a=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and name!="" and activityType=3  order by name asc'); 
						while($supplierData=mysqli_fetch_array($rs1a)){   
						?>
						<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
						<?php } ?>
						</select>
						</label>
						</div>

						<div class="griddiv">
						<label>
						  <table width="100%">
						  	 <tr>
						  	 	<td width="33%"><div class="gridlable">Activity Cost(<?php echo trim($resListing['name']); ?>)</div>
						<input name="activityCost" type="text" class="gridfield" id="activityCost" displayname="Activity Cost" value="" onkeyup="getPerPaxCost();" ></td>
						  	 	<td width="33%"><div class="gridlable">Pax Range</div>
						<input name="maxPax" type="text" class="gridfield" id="maxPax" displayname="Pax Range" value="" onkeyup="getPerPaxCost();" ></td>
						  	 	
						  	 	<td width="33%"><div class="gridlable">Per Pax Cost(<?php echo trim($resListing['name']); ?>)</div>
						<input name="perPaxCost" type="text" class="gridfield" id="perPaxCost" displayname="Per Pax Cost" value="" onkeyup="getPerPaxCost();" ></td>
						  	 </tr>
						  </table>
						</label>
						</div>
					</td>
			  	</tr>
				</tbody>
			</table>
			
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_entrancetomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input type="hidden" value="<?php echo $dayData['cityId']; ?>" name="cityId"/>
 						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input name="action" type="hidden" id="action" value="add_acticitiestomaster">
 						<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceActivity&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','800px');">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	<script>
		function getPerPaxCost(){ 
		    var activityCost = $('#activityCost').val();
			var maxpax = $('#maxPax').val();  
			var ppCost = Math.round(activityCost/maxpax);
			if(ppCost == 'NaN' || ppCost== Infinity){
			$('#perPaxCost').val(activityCost);
			}else{
			$('#perPaxCost').val(ppCost);
			}
		}
	</script>		
	</div>  
	<?php
}
if(trim($_REQUEST['action'])=='add_acticitiestomaster' && trim($_REQUEST['activityName'])!=''){

	$activityName=clean($_REQUEST['activityName']);
	$activityCost = clean($_REQUEST['activityCost']);
	$supplierId = clean($_REQUEST['supplierId']);
	$perPaxCost = clean($_REQUEST['perPaxCost']);
	$maxPax = clean($_REQUEST['maxPax']);

	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$startDayId = $_REQUEST['dayId'];
	$fromDate = $_REQUEST['daydate'];
	$cityId = $_REQUEST['cityId'];
	$activityCity = getDestination($cityId);
	$rs="";
	$rs=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' setDefault=1 order by name asc');  
	$resListing=mysqli_fetch_array($rs);

	$dateAdded=time();
	// duplicate added code quatation started
	$rsr=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'otherActivityName="'.$activityName.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('This Activity Name Already Exist !');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }
    else{
		$namevalue ='otherActivityName="'.$activityName.'",otherActivityCity="'.$activityCity.'",status="1"';
		$lastid=addlistinggetlastid(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$namevalue);

		$namevalue ='fromDate="'.date('Y-m-d',strtotime($fromDate)).'",toDate="'.date('Y-m-d',strtotime($fromDate)).'",activityCost="'.$activityCost.'",currencyId="'.$resListing['id'].'",status="1",supplierId="'.$supplierId.'",serviceid="'.$lastid.'",otherActivityNameId="'.$lastid.'",maxpax="'.$maxPax.'",perPaxCost="'.$perPaxCost.'"';
		$lastId2 = addlistinggetlastid('dmcotherActivityRate',$namevalue);

		?>
		<script>
			parent.openinboundpop('action=addServiceActivity&dayId=<?php echo $_REQUEST['dayId']; ?>&cityId=<?php echo $dayData['cityId']; ?>','800px');
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
		</script>
		<?php
	}
	// duplicate added code quatation ended
} 

if($_REQUEST['action'] == 'addenroutetomaster'){
	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Enroute</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_enroutetomaster" target="actoinfrm" id="add_enroutetomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">

						<div class="griddiv"><label>
						<div class="gridlable">Enroute Name<span class="redmind"></span></div>
						<input name="enrouteName" type="text" class="gridfield validate" id="enrouteName" displayname="Enroute Name" value="">
						</label>
						</div>

						<div class="griddiv"><label>
						<div class="gridlable">Per Pax Cost(<?php echo getCurrencyName($defualtCurrencyId);?>)<span class="redmind"></span></div>
						<input name="adultCost" type="text" class="gridfield" id="adultCost" displayname="Per Pax Cost" value="">
						</label>
						</div>
 
					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 50%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td width="100" align="left">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_enroutetomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $dayData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
						<input type="hidden" value="<?php echo $_REQUEST['destId']; ?>" name="destinationId"/>
						<input type="hidden" value="<?php echo $dayData['queryId']; ?>" name="queryId"/>
						<input name="action" type="hidden" id="action" value="add_enroutetomaster">
 						<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceEnroute&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','600px');">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div> 
	<?php
}
if(trim($_REQUEST['action'])=='add_enroutetomaster' && trim($_REQUEST['enrouteName'])!=''){

	$enrouteName=clean($_REQUEST['enrouteName']);
	$adultCost = clean($_REQUEST['adultCost']);
	$childCost = clean($_REQUEST['childCost']);

	$quotationId = $_REQUEST['quotationId'];
	$queryId = $_REQUEST['queryId'];
	$startDayId = $_REQUEST['dayId'];
	$fromDate = $_REQUEST['daydate'];
	$destinationId = $_REQUEST['destinationId'];

	$rs1=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.clean($_REQUEST['destinationId']).'"');
	$destData=mysqli_fetch_array($rs1);
	$enrouteCity = stripslashes($destData['name']);
 
	$dateAdded=time();
	$namevalue ='enrouteName="'.$enrouteName.'",enrouteCity="'.$enrouteCity.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",status="1"';
	$lastid=addlistinggetlastid(_PACKAGE_BUILDER_ENROUTE_MASTER_,$namevalue);

	?>
	<script>
		parent.openinboundpop('action=addServiceEnroute&enrouteId=<?php echo $lastid; ?>&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $_REQUEST['daydate']; ?>','1200px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}
 

// Edit Quotation aDDED Service Rate actions ******************************
// HOtel start
if($_REQUEST['action'] == 'editQuotationHotelRate' && $_REQUEST['hotelQuoteId'] != ''){

		$qhQuery2='';
		$qhQuery2=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$_REQUEST['hotelQuoteId'].'"');
		$qhData2=mysqli_fetch_array($qhQuery2);


		$c="";
		$c=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$qhData2['quotationId'].'"'); 
		$quotationData=mysqli_fetch_array($c);

		$singleRoom = $quotationData['sglRoom'];
		$doubleRoom = $quotationData['dblRoom'];
		$tripleRoom = $quotationData['tplRoom'];
		$twinRoom   = $quotationData['twinRoom'];
		$EBedChild = $quotationData['childwithNoofBed'];
		$NBedChild = $quotationData['childwithoutNoofBed'];
		$EBedAdult = $quotationData['extraNoofBed'];
		$sixBedRoom = $quotationData['sixNoofBedRoom'];
		$eightBedRoom = $quotationData['eightNoofBedRoom'];
		$tenBedRoom = $quotationData['tenNoofBedRoom'];
		$quadBedRoom = $quotationData['quadNoofRoom'];
		$teenBedRoom = $quotationData['teenNoofRoom'];

		$isChildBFQ = $quotationData['isChildBreakfast'];
		$isChildDNQ = $quotationData['isChildDinner'];
		$isChildLHQ = $quotationData['isChildLunch'];

		$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'"'); 
		$queryData = mysqli_fetch_array($rs1);


    // hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$qhData2['supplierId'].'"');
	$hotelData=mysqli_fetch_array($d);
	?>

	<div class="inboundheader"><?php echo $hotelData['hotelName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></div>

	<div style="padding: 10px 0;" class="inboundContent divBox">
		<style type="text/css">
			.divBox .w150{
				width: 150px;
			    display: inline-block;
			    border: 1px solid #DDD;
			    PADDING: 5PX;
			}
		</style>
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
		<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editQuotationHotelRate" target="actoinfrm" id="editQuotationHotelRate"> 

			<div class="griddiv w150" >
			<label>
			<div class="gridlable">Room&nbsp;Type <span class="redmind"></span></div>
			<select id="roomType2" name="roomType2" class="gridfield" displayname="Room Type" onchange="getRoomPrice<?php echo ($qhData2['id']); ?>(this.value)"  > 
			<?php  
			$roomTypeArray = explode(',',rtrim($hotelData['roomType'],','));
			foreach($roomTypeArray as $roomArray){
			$rs="";  
			$rs=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$roomArray.'"'); 
			$resListing=mysqli_fetch_array($rs);	
			?>
			<option value="<?php echo strip($resListing['id']); ?>"  <?php if($resListing['id']==$qhData2['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
			<?php } ?>
			</select>
			</label>
			</div>
		
			<div class="griddiv w150" >
			<label> 
			<div class="gridlable">Meal&nbsp;Plan <span class="redmind"></span></div>
			<select id="mealPlan22" name="mealPlan2" class="gridfield  " displayname="Meal Plan" autocomplete="off"    > 
			<?php   
			$rs='';  
			$rs=GetPageRecord('*',_MEAL_PLAN_MASTER_,' deletestatus=0 and status=1 order by id asc'); 
			while($resListing=mysqli_fetch_array($rs)){  

			?>
			<option value="<?php echo strip($resListing['id']); ?>"  <?php if($resListing['id']==$qhData2['mealPlan']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
			<?php } ?>
			</select></label>
			</div>
 

			<div class="griddiv w150">
				<label>  
				<div class="gridlable">Currency<span class="redmind"></span></div>
				<select id="currencyId2" name="currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off"  onchange="getROE(this.value,'currencyVal124');"    >
				 <option value="">Select</option>
					<?php 
					$currencyId = ($qhData2['currencyId']>0)?$qhData2['currencyId']:$baseCurrencyId;
					$currencyValue = ($qhData2['currencyValue']>0)?$qhData2['currencyValue']:getCurrencyVal($currencyId);
					$select=''; 
					$where=''; 
					$rs='';  
					$select='*';    
					$where=' deletestatus=0 and status=1 order by name asc';  
					$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
					while($resListing=mysqli_fetch_array($rs)){   
					?>
					<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
					<?php } ?>
					</select>
				</label>
			</div>	

			<div class="griddiv w150" >
			<label> 
				<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
				<input class="gridfield validate" name="currencyValue2" displayname="ROI Value"  id="currencyVal124" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;width: 100px;" >
			</label>
			</div>

			<div class="griddiv w150" ><label>
			<div class="gridlable">Single</div>
			<input name="singleoccupancy2" type="text" class="gridfield"  id="singleoccupancy2" maxlength="12" onkeyup="numericFilter(this);" style="width: 100px;" value="<?php echo $qhData2['singleoccupancy']; ?>"/>
			<input name="singleNoofRoom2" type="text" class="gridfield"  id="singleNoofRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['singleNoofRoom']; ?>"/>
			</label>
			</div>

		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Double</div>
			<input name="doubleoccupancy2" type="text" class="gridfield"  id="doubleoccupancy2" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $qhData2['doubleoccupancy']; ?>"/>
			<input name="doubleNoofRoom2" type="text" class="gridfield"  id="doubleNoofRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['doubleNoofRoom']; ?>"/>
			</label>
			</div>
		
			<?php  if($twinRoom>0){ ?>
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Twin</div>
			<input name="twinoccupancy2" type="text" class="gridfield"  id="twinoccupancy2" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $qhData2['twinoccupancy']; ?>"/>
			<input name="twinNoofRoom2" type="text" class="gridfield"  id="twinNoofRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['twinNoofRoom']; ?>"/>
			</label>
			</div>
		
			<?php } if($tripleRoom>0){ ?>
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Triple Room</div>
			<input name="tripleoccupancy2" type="text" class="gridfield"  id="tripleoccupancy2" value="<?php echo $qhData2['tripleoccupancy']; ?>" maxlength="12" onkeyup="numericFilter(this);"   style="width: 100px;" />
			<input name="tripleNoofRoom2" type="text" class="gridfield"  id="tripleNoofRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['tripleNoofRoom']; ?>"/>
			</label>
			</div>
		
   	 		<?php } if($quadBedRoom>0){ ?>
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Quad Room</div>
			<input name="quadRoomCost2" type="text" class="gridfield"  id="quadRoomCost2" value="<?php echo $qhData2['quadRoom']; ?>" maxlength="12" onkeyup="numericFilter(this);"   style="width: 100px;" />
			<input name="quadNoofRoom2" type="text" class="gridfield"  id="quadNoofRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['quadNoofRoom']; ?>"/>
			</label>
			</div>
		
    		<?php } if($sixBedRoom>0){ ?>
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Six&nbsp;Bed&nbsp;Room</div>
			<input name="sixBedRoomCost2" type="text" class="gridfield"  id="sixBedRoomCost2" value="<?php echo $qhData2['sixBedRoom']; ?>" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;"/>
			<input name="sixNoofBedRoom2" type="text" class="gridfield"  id="sixNoofBedRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['sixNoofBedRoom']; ?>"/>
			</label>
			</div>
    		<?php } if($eightBedRoom>0){ ?>
			<div class="griddiv w150" ><label>
			<div class="gridlable">Eight&nbsp;Bed&nbsp;Room</div>
			<input name="eightBedRoomCost2" type="text" class="gridfield"  id="eightBedRoomCost2" value="<?php echo $qhData2['eightBedRoom']; ?>" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;"/>
			<input name="eightNoofBedRoom2" type="text" class="gridfield"  id="eightNoofBedRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['eightNoofBedRoom']; ?>"/>
			</label>
			</div>
    		<?php } if($tenBedRoom>0){ ?>
			<div class="griddiv w150" ><label>
			<div class="gridlable">Ten&nbsp;Bed&nbsp;Room</div>
			<input name="tenBedRoomCost2" type="text" class="gridfield"  id="tenBedRoomCost2" value="<?php echo $qhData2['tenBedRoom']; ?>" maxlength="12" onkeyup="numericFilter(this);"  style="width:100px;"/>
			<input name="tenNoofBedRoom2" type="text" class="gridfield"  id="tenNoofBedRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['tenNoofBedRoom']; ?>"/>
			</label>
			</div>
   	 		<?php } if($teenBedRoom>0){ ?>
			<div class="griddiv w150" ><label>
			<div class="gridlable">Teen Room</div>
			<input name="teenRoomCost2" type="text" class="gridfield"  id="teenRoomCost2" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $qhData2['teenRoom']; ?>"/>
			<input name="teenNoofRoom2" type="text" class="gridfield"  id="teenNoofRoom2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['teenNoofRoom']; ?>"/>
			</label>
			</div>
    		<?php } if($EBedAdult>0){ ?>
			<div class="griddiv w150" ><label>
			<div class="gridlable">Extra&nbsp;Bed&nbsp;(Adult)</div>
			<input name="extraBed2" type="text" class="gridfield"  id="extraBed2" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $qhData2['extraBed']; ?>"/>
			<input name="extraNoofBed2" type="text" class="gridfield"  id="extraNoofBed2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['extraNoofBed']; ?>"/>
			</label>
			</div>
    		<?php } if($EBedChild>0){ ?>
			<div class="griddiv w150" ><label>
			<div class="gridlable">Extra&nbsp;Bed&nbsp;(Child)</div>
			<input name="childwithbed2" type="text" class="gridfield"  id="childwithbed2" maxlength="12" onkeyup="numericFilter(this);" style="width: 100px;" value="<?php echo $qhData2['childwithbed']; ?>"/>
			<input name="childwithNoofBed2" type="text" class="gridfield"  id="childwithNoofBed2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['childwithNoofBed']; ?>"/>
			</label>
			</div>
    		<?php } if($NBedChild>0){ ?>
			<div class="griddiv w150" ><label>
			<div class="gridlable">Child&nbsp;W/B</div>
			<input name="childwithoutbed2" type="text" class="gridfield"  id="childwithoutbed2" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $qhData2['childwithoutbed']; ?>"/>
			<input name="childwithoutNoofBed2" type="text" class="gridfield"  id="childwithoutNoofBed2" maxlength="12" onkeyup="numericFilter(this);" style="width: 40px;" value="<?php echo $qhData2['childwithoutNoofBed']; ?>"/>
			</label>
			</div>
    		<?php }  ?>

			<div class="griddiv w150" ><label>
			<div class="gridlable">Breakfast(A)</div>
			<input name="breakfast2" type="text" class="gridfield"  id="breakfast2" maxlength="12" onkeyup="numericFilter(this);"  style="width: 100px;" value="<?php echo $qhData2['breakfast']; ?>"/>
			</label>
			</div>
		
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Lunch(A) </div>
			<input name="lunch2" type="text" class="gridfield"  id="lunch2"  style="width: 100px;" onkeyup="numericFilter(this);" maxlength="12" value="<?php echo $qhData2['lunch']; ?>"/>
			</label>
			</div>
		
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Dinner(A)</div>
			<input name="dinner2" type="text" class="gridfield"  id="dinner2" maxlength="12" onkeyup="numericFilter(this);" style="width: 120px;" value="<?php echo $qhData2['dinner']; ?>" />
			</label>
			</div>
		
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Breakfast(C)</div>
			<input name="breakfastChild2" type="text" class="gridfield"  id="breakfastChild2" value="<?php echo $qhData2['childBreakfast']; ?>"  maxlength="12" onkeyup="numericFilter(this);" style="width: 100px;" />
			</label>
			</div>
		
		
			<div class="griddiv w150" ><label>
			<div class="gridlable">Lunch(C)</div>
			<input name="lunchChild2" type="text" class="gridfield"  id="lunchChild2" value="<?php echo $qhData2['childLunch']; ?>" onkeyup="numericFilter(this);" maxlength="12" style="width: 100px;" />
			</label>
			</div>
		
		
		
			<div class="griddiv w150"  ><label>
			<div class="gridlable">Dinner(C)</div>
			<input name="dinnerChild2" type="text" class="gridfield" id="dinnerChild2" value="<?php echo $qhData2['childDinner']; ?>" maxlength="12" onkeyup="numericFilter(this);" style="width: 100px;" />
			</label>
			</div>
		
		
			<div class="griddiv w150"  style="width: 639px;" ><label>
			<div class="gridlable">Remarks</div>
			<input name="remarks2" type="text" class="gridfield"  id="remarks2"  value="<?php echo $qhData2['remark']; ?>" />
			</label>
			</div>
			<!-- new added for hotel checkin and checkout fields-->
			
			<div class="griddiv w150"  style="" ><label>
			<div class="gridlable">Check In</div>
			<input name="checkIn"  id="checkIn" type="text" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $qhData2['checkin']; ?>" />
			</label>
			</div>
			<div class="griddiv w150"  style="" ><label>
			<div class="gridlable">Check Out</div>
			<input name="checkOut"  id="checkOut" type="text" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $qhData2['checkout']; ?>" />
			</label>
			</div>
				 
			<input name="hotelQuoteId2" type="hidden" id="hotelQuoteId2" value="<?php echo $_REQUEST['hotelQuoteId']; ?>" />
			<input name="action" type="hidden" id="action2" value="saveQuotationHotelRate" />
		</form>
		</div>
		<script type="text/javascript">
			function getRoomPrice<?php echo ($qhData2['id']); ?>(roomTypeId) {
				$.ajax({
					url: "loadQuotationCodes.php",
					type: "POST",
					data: { 'action' : 'editHotelPrice', 'serviceid' : '<?php echo ($qhData2['supplierId']);?>','fromDate' : '<?php echo strtotime($queryData['fromDate']);?>','toDate' : '<?php echo strtotime($queryData['fromDate']);?>','roomTypeId' : roomTypeId },
					dataType: 'json',
					cache: false,
					success: function(data) {
						$('#singleoccupancy2').val(data.singleoccupancy);
						$('#doubleoccupancy2').val(data.doubleoccupancy);
						$('#twinoccupancy2').val(data.twinoccupancy);
						$('#tripleoccupancy2').val(data.tripleoccupancy);
						$('#quadRoom2').val(data.quadRoom);
						$('#sixBedRoom2').val(data.sixBedRoom);
						$('#eightBedRoom2').val(data.eightBedRoom);
						$('#tenBedRoom2').val(data.tenBedRoom);
						$('#teenRoom2').val(data.teenRoom);
						$('#extraBed2').val(data.extraBed);
						$('#childwithbed2').val(data.childwithbed);
						$('#childwithoutbed2').val(data.childwithoutbed);


						$('#breakfast2').val(data.breakfast);
						$('#lunch2').val(data.lunch);
						$('#dinner2').val(data.dinner);

						
						$('#breakfastChild2').val(data.breakfastChild);
						$('#lunchChild2').val(data.lunchChild);
						$('#dinnerChild2').val(data.dinnerChild);


						$('#remarks2').val(data.remarks); 
					}
				});
			}
		</script>
		<style type="text/css">
			.inboundContent .griddiv{
				min-width: 130px;
			}
		</style>
	</div>
	<div id="buttonsbox" class="inboundfooter">
		<table border="0" align="right" cellpadding="0" cellspacing="0">
			<tr>
				<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('editQuotationHotelRate','submitbtn','0');" /></td>
				<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
			</tr>
		</table>
	</div>
	<?php
}
if($_REQUEST['action'] == 'saveQuotationHotelRate' && $_REQUEST['hotelQuoteId2'] != ''){

	$namevalue ='mealPlan="'.$_REQUEST['mealPlan2'].'",roomType="'.$_REQUEST['roomType2'].'",singleoccupancy="'.$_REQUEST['singleoccupancy2'].'",singleNoofRoom="'.$_REQUEST['singleNoofRoom2'].'",doubleoccupancy="'.$_REQUEST['doubleoccupancy2'].'",doubleNoofRoom="'.$_REQUEST['doubleNoofRoom2'].'",twinoccupancy="'.$_REQUEST['twinoccupancy2'].'",twinNoofRoom="'.$_REQUEST['twinNoofRoom2'].'",tripleoccupancy="'.$_REQUEST['tripleoccupancy2'].'",tripleNoofRoom="'.$_REQUEST['tripleNoofRoom2'].'",extraBed="'.$_REQUEST['extraBed2'].'",extraNoofBed="'.$_REQUEST['extraNoofBed2'].'",childwithbed="'.$_REQUEST['childwithbed2'].'",childwithNoofBed="'.$_REQUEST['childwithNoofBed2'].'",childwithoutbed="'.$_REQUEST['childwithoutbed2'].'",childwithoutNoofBed="'.$_REQUEST['childwithoutNoofBed2'].'",sixBedRoom="'.$_REQUEST['sixBedRoomCost2'].'",sixNoofBedRoom="'.$_REQUEST['sixNoofBedRoom2'].'",eightBedRoom="'.$_REQUEST['eightBedRoomCost2'].'",eightNoofBedRoom="'.$_REQUEST['eightNoofBedRoom2'].'",tenBedRoom="'.$_REQUEST['tenBedRoomCost2'].'",tenNoofBedRoom="'.$_REQUEST['tenNoofBedRoom2'].'",quadRoom="'.$_REQUEST['quadRoomCost2'].'",quadNoofRoom="'.$_REQUEST['quadNoofRoom2'].'",teenRoom="'.$_REQUEST['teenRoomCost2'].'",teenNoofRoom="'.$_REQUEST['teenNoofRoom2'].'",breakfast="'.$_REQUEST['breakfast2'].'",lunch="'.$_REQUEST['lunch2'].'",dinner="'.$_REQUEST['dinner2'].'",childBreakfast="'.$_REQUEST['breakfastChild2'].'",childLunch="'.$_REQUEST['lunchChild2'].'",childDinner="'.$_REQUEST['dinnerChild2'].'",remark="'.$_REQUEST['remarks2'].'",checkin="'.$_REQUEST['checkIn'].'",checkout="'.$_REQUEST['checkOut'].'",currencyId="'.$_REQUEST['currencyId2'].'",currencyValue="'.$_REQUEST['currencyValue2'].'"';

	// die("try it please check");
	$updatelist = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($_REQUEST['hotelQuoteId2']).'"');
	?>
	<script>
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Hotel Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
}
if($_REQUEST['action'] == 'vewsupplementcostofHotel' && $_REQUEST['id'] != ''){

   $select1='*';
   $where1='id="'.$_REQUEST['hotelQuoteId'].'"';
   $rs1=GetPageRecord($select1,_QUOTATION_HOTEL_MASTER_,$where1);
   $dmcroommastermain=mysqli_fetch_array($rs1);

   $wheresupc='id='.$_REQUEST['id'].'';
   $rssupc=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$wheresupc);
   $supplementCostc=mysqli_fetch_array($rssupc);

   // hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$dmcroommastermain['supplierId'].'"');
	$hotelData=mysqli_fetch_array($d);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding"><?php echo $hotelData['hotelName']; ?> Supplement Cost</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding: 10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" class="hotelds tablesorter gridtable">
				<thead style="font-weight:500;">
				   <tr>
 					  <th width="6%" align="left" bgcolor="#F4F4F4" >Single</th>
					  <th width="6%" align="left" bgcolor="#F4F4F4" >Double</th> 
					  <th width="12%" align="left" bgcolor="#F4F4F4" >Extra&nbsp;Bed(Adult)</th>
				  	  <th width="12%" align="left" bgcolor="#F4F4F4" >Extra&nbsp;Bed(Child)</th>
					  <th width="8%" align="left" bgcolor="#F4F4F4" >Child W/O</th>
				   </tr>
		      </thead>
				   <tbody>
				   	<tr>
		   	  		  <td align="left"><?php if ($dmcroommastermain['singleoccupancy']!=0) { echo $supplementCostc['singleoccupancy']; }?></td>
				   	  <td align="left"><?php if ($dmcroommastermain['doubleoccupancy']!=0) { echo $supplementCostc['doubleoccupancy'];} ?></td> 
				   	  <td align="left"><?php if ($dmcroommastermain['extraBed']!=0) {echo $supplementCostc['extraBed'];} ?></td>
				   	  <td align="left"><?php if ($dmcroommastermain['childwithbed']!=0) { echo $supplementCostc['childwithbed'];}  ?></td>
				   	  <td align="left"><?php if ($dmcroommastermain['childwithoutbed']!=0) { echo $supplementCostc['childwithoutbed'];} ?></td>
 				   </tr>
				   </tbody>
		   </table>
			</form>
		</div>
	</div>

	<?php
}

if($_REQUEST['action'] == 'editQuotationHotelRate2' && $_REQUEST['hotelQuoteId'] != ''){

	$qhQuery2='';
	$qhQuery2=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$_REQUEST['hotelQuoteId'].'"');
	$qhData2=mysqli_fetch_array($qhQuery2);

	$c="";
	$c=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$qhData2['quotationId'].'"'); 
	$quotationData=mysqli_fetch_array($c);

	$markupCalType = $quotationData['markupCalType'];
	$singleRoom = $quotationData['sglRoom'];
	$doubleRoom = $quotationData['dblRoom'];
	$tripleRoom = $quotationData['tplRoom'];
	$twinRoom   = $quotationData['twinRoom'];
	$EBedChild = $quotationData['childwithNoofBed'];
	$NBedChild = $quotationData['childwithoutNoofBed'];
	$EBedAdult = $quotationData['extraNoofBed'];

	$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'"'); 
	$queryData = mysqli_fetch_array($rs1);


    // hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$qhData2['supplierId'].'"');
	$hotelData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $hotelData['hotelName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editQuotationHotelRate" target="actoinfrm" id="editQuotationHotelRate"> 

				<div class="griddiv inline-box f-left" >
				<label>
				<div class="gridlable">Room&nbsp;Type <span class="redmind"></span></div>
				<select id="roomType2" name="roomType2" class="gridfield f-left" displayname="Room Type" onchange="getRoomPrice<?php echo ($qhData2['id']); ?>(this.value)"  > 
				<?php  
				$roomTypeArray = explode(',',rtrim($hotelData['roomType'],','));
				foreach($roomTypeArray as $roomArray){
				$rs="";  
				$rs=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$roomArray.'"'); 
				$resListing=mysqli_fetch_array($rs);	
				?>
				<option value="<?php echo strip($resListing['id']); ?>"  <?php if($resListing['id']==$qhData2['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
				<?php } ?>
				</select>
				</label>
				</div>
			
				<div class="griddiv inline-box f-left" >
				<label> 
				<div class="gridlable">Meal&nbsp;Plan <span class="redmind"></span></div>
				<select id="mealPlan22" name="mealPlan2" class="gridfield f-left " displayname="Meal Plan" autocomplete="off"    > 
				<?php   
				$rs='';  
				$rs=GetPageRecord('*',_MEAL_PLAN_MASTER_,' deletestatus=0 and status=1 order by id asc'); 
				while($resListing=mysqli_fetch_array($rs)){  

				?>
				<option value="<?php echo strip($resListing['id']); ?>"  <?php if($resListing['id']==$qhData2['mealPlan']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
				<?php } ?>
				</select></label>
				</div>

				<div class="griddiv inline-box f-left">
					<label>  
					<div class="gridlable">Currency<span class="redmind"></span></div>
					<select id="currencyId2" name="currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off"  onchange="getROE(this.value,'currencyVal124');"    >
					 <option value="">Select</option>
						<?php 
						$currencyId = ($qhData2['currencyId']>0)?$qhData2['currencyId']:$baseCurrencyId;
						$currencyValue = ($qhData2['currencyValue']>0)?$qhData2['currencyValue']:getCurrencyVal($currencyId);
						$select=''; 
						$where=''; 
						$rs='';  
						$select='*';    
						$where=' deletestatus=0 and status=1 order by name asc';  
						$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
						while($resListing=mysqli_fetch_array($rs)){   
						?>
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
						</select>
					</label>
				</div>		

				<div class="griddiv inline-box f-left" >
				<label> 
					<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input class="gridfield validate" name="currencyValue2" displayname="currencyValue"  id="currencyVal124" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
				</label>
				</div>

				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Single</div>
				<input name="singleoccupancy2" type="text" class="gridfield f-left w70"  id="singleoccupancy2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['singleoccupancy']; ?>"/>
				<input name="singleNoofRoom2" type="text" class="gridfield f-left w30"  id="singleNoofRoom2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['singleNoofRoom']; ?>"/>
				</label>
				</div>

			
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Double</div>
				<input name="doubleoccupancy2" type="text" class="gridfield f-left w70"  id="doubleoccupancy2" maxlength="12" onkeyup="numericFilter(this);"   value="<?php echo $qhData2['doubleoccupancy']; ?>"/>
				<input name="doubleNoofRoom2" type="text" class="gridfield f-left w30"  id="doubleNoofRoom2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['doubleNoofRoom']; ?>"/>
				</label>
				</div>
			
				<?php  if($twinRoom>0){ ?>
			
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Twin</div>
				<input name="twinoccupancy2" type="text" class="gridfield f-left w70"  id="twinoccupancy2" maxlength="12" onkeyup="numericFilter(this);"   value="<?php echo $qhData2['twinoccupancy']; ?>"/>
				<input name="twinNoofRoom2" type="text" class="gridfield f-left w30"  id="twinNoofRoom2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['twinNoofRoom']; ?>"/>
				</label>
				</div>
			
				<?php } if($tripleRoom>0){ ?>
			
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Triple Room</div>
				<input name="tripleoccupancy2" type="text" class="gridfield f-left w70"  id="tripleoccupancy2" value="<?php echo $qhData2['tripleoccupancy']; ?>" maxlength="12" onkeyup="numericFilter(this);"    />
				<input name="tripleNoofRoom2" type="text" class="gridfield f-left w30"  id="tripleNoofRoom2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['tripleNoofRoom']; ?>"/>
				</label>
				</div>
			
	   	 		<?php } if($EBedAdult>0){ ?>
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Extra&nbsp;Bed&nbsp;(Adult)</div>
				<input name="extraBed2" type="text" class="gridfield f-left w70"  id="extraBed2" maxlength="12" onkeyup="numericFilter(this);"   value="<?php echo $qhData2['extraBed']; ?>"/>
				<input name="extraNoofBed2" type="text" class="gridfield f-left w30"  id="extraNoofBed2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['extraNoofBed']; ?>"/>
				</label>
				</div>
	    		<?php } if($EBedChild>0){ ?>
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Extra&nbsp;Bed&nbsp;(Child)</div>
				<input name="childwithbed2" type="text" class="gridfield f-left w70"  id="childwithbed2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['childwithbed']; ?>"/>
				<input name="childwithNoofBed2" type="text" class="gridfield f-left w30"  id="childwithNoofBed2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['childwithNoofBed']; ?>"/>
				</label>
				</div>
	    		<?php } if($NBedChild>0){ ?>
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Child&nbsp;W/B</div>
				<input name="childwithoutbed2" type="text" class="gridfield f-left w70"  id="childwithoutbed2" maxlength="12" onkeyup="numericFilter(this);"   value="<?php echo $qhData2['childwithoutbed']; ?>"/>
				<input name="childwithoutNoofBed2" type="text" class="gridfield f-left w30"  id="childwithoutNoofBed2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['childwithoutNoofBed']; ?>"/>
				</label>
				</div>
	    		<?php }  ?>

				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Breakfast(A)</div>
				<input name="breakfast2" type="text" class="gridfield f-left"  id="breakfast2" maxlength="12" onkeyup="numericFilter(this);"   value="<?php echo $qhData2['breakfast']; ?>"/>
				</label>
				</div>
			
			
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Lunch(A) </div>
				<input name="lunch2" type="text" class="gridfield f-left"  id="lunch2"   onkeyup="numericFilter(this);" maxlength="12" value="<?php echo $qhData2['lunch']; ?>"/>
				</label>
				</div>
			
			
				<div class="griddiv inline-box f-left" ><label>
				<div class="gridlable">Dinner(A)</div>
				<input name="dinner2" type="text" class="gridfield f-left"  id="dinner2" maxlength="12" onkeyup="numericFilter(this);"  value="<?php echo $qhData2['dinner']; ?>" />
				</label>
				</div>
				<?php
				if($markupCalType == 1){   ?>
				<div class="griddiv inline-box f-left">
					<label>
					<div class="gridlable">Markup Type</div>
					<select name="markupType2" id="markupType2" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;">
					 	<option value="1" <?php if($qhData2['markupType'] == 1){ ?> selected="selected" <?php } ?>>%</option>
					 	<option value="2" <?php if($qhData2['markupType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
					</select>
					</label>
				</div>
				<div class="griddiv inline-box f-left">
					<label>
						<div class="gridlable">Markup Cost</div>
						<input name="markupCost2" type="text" class="gridfield f-left"  id="markupCost2" maxlength="6" onkeyup="numericFilter(this);" style="width: 100px;" value="<?php echo $qhData2['markupCost']; ?>" />
					</label>
				</div>
				<?php
				}
				?> 
			
				<div class="griddiv inline-box f-left"   ><label>
				<div class="gridlable">Remarks</div>
				<input name="remarks2" type="text" class="gridfield f-left"  id="remarks2"  value="<?php echo $qhData2['remarks']; ?>" />
				</label>
				</div>
					 
				<input name="hotelQuoteId2" type="hidden" id="hotelQuoteId2" value="<?php echo $_REQUEST['hotelQuoteId']; ?>" />
				<input name="action" type="hidden" id="action2" value="saveQuotationHotelRate" />
			</form>
			</div>
			<script type="text/javascript">
				function getRoomPrice<?php echo ($qhData2['id']); ?>(roomTypeId) {
					$.ajax({
						url: "loadQuotationCodes.php",
						type: "POST",
						data: { 'action' : 'editHotelPrice', 'serviceid' : '<?php echo ($qhData2['supplierId']);?>','fromDate' : '<?php echo strtotime($queryData['fromDate']);?>','toDate' : '<?php echo strtotime($queryData['fromDate']);?>','roomTypeId' : roomTypeId },
						dataType: 'json',
						cache: false,
						success: function(data) {
							$('#singleoccupancy2').val(data.singleoccupancy);
							$('#doubleoccupancy2').val(data.doubleoccupancy);
							$('#twinoccupancy2').val(data.twinoccupancy);
							$('#tripleoccupancy2').val(data.tripleoccupancy);
							$('#quadRoom2').val(data.quadRoom);
							$('#sixBedRoom2').val(data.sixBedRoom);
							$('#eightBedRoom2').val(data.eightBedRoom);
							$('#tenBedRoom2').val(data.tenBedRoom);
							$('#teenRoom2').val(data.teenRoom);
							$('#extraBed2').val(data.extraBed);
							$('#childwithbed2').val(data.childwithbed);
							$('#childwithoutbed2').val(data.childwithoutbed);


							$('#breakfast2').val(data.breakfast);
							$('#lunch2').val(data.lunch);
							$('#dinner2').val(data.dinner);

							
							$('#breakfastChild2').val(data.breakfastChild);
							$('#lunchChild2').val(data.lunchChild);
							$('#dinnerChild2').val(data.dinnerChild);


							$('#remarks2').val(data.remarks); 
						}
					});
				}
			</script>
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editQuotationHotelRate','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div>
 
	<?php
} 
if($_REQUEST['action'] == 'saveQuotationHotelRate2' && $_REQUEST['hotelQuoteId2'] != ''){

	$namevalue ='mealPlan="'.$_REQUEST['mealPlan2'].'",roomType="'.$_REQUEST['roomType2'].'",currencyId="'.$_REQUEST['currencyId2'].'",currencyValue="'.$_REQUEST['currencyValue2'].'",singleoccupancy="'.$_REQUEST['singleoccupancy2'].'",singleNoofRoom="'.$_REQUEST['singleNoofRoom2'].'",doubleoccupancy="'.$_REQUEST['doubleoccupancy2'].'",doubleNoofRoom="'.$_REQUEST['doubleNoofRoom2'].'",twinoccupancy="'.$_REQUEST['twinoccupancy2'].'",twinNoofRoom="'.$_REQUEST['twinNoofRoom2'].'",tripleoccupancy="'.$_REQUEST['tripleoccupancy2'].'",tripleNoofRoom="'.$_REQUEST['tripleNoofRoom2'].'",extraBed="'.$_REQUEST['extraBed2'].'",extraNoofBed="'.$_REQUEST['extraNoofBed2'].'",childwithbed="'.$_REQUEST['childwithbed2'].'",childwithNoofBed="'.$_REQUEST['childwithNoofBed2'].'",childwithoutbed="'.$_REQUEST['childwithoutbed2'].'",childwithoutNoofBed="'.$_REQUEST['childwithoutNoofBed2'].'",breakfast="'.$_REQUEST['breakfast2'].'",lunch="'.$_REQUEST['lunch2'].'",dinner="'.$_REQUEST['dinner2'].'",markupType="'.$_REQUEST['markupType2'].'",markupCost="'.$_REQUEST['markupCost2'].'",remark="'.$_REQUEST['remarks2'].'"';

	$updatelist = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($_REQUEST['hotelQuoteId2']).'"');
	?>
	<script>
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Hotel Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} 
if($_REQUEST['action'] == 'vewsupplementcostofHotel2' && $_REQUEST['id'] != ''){

   $select1='*';
   $where1='id="'.$_REQUEST['hotelQuoteId'].'"';
   $rs1=GetPageRecord($select1,_QUOTATION_HOTEL_MASTER_,$where1);
   $dmcroommastermain=mysqli_fetch_array($rs1);

   $wheresupc='id='.$_REQUEST['id'].'';
   $rssupc=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$wheresupc);
   $supplementCostc=mysqli_fetch_array($rssupc);

   // hotel data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$dmcroommastermain['supplierId'].'"');
	$hotelData=mysqli_fetch_array($d);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding"><?php echo $hotelData['hotelName']; ?> Supplement Cost</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding: 10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" class="hotelds tablesorter gridtable">
				<thead style="font-weight:500;">
				   <tr>
 					  <th width="6%" align="left" bgcolor="#F4F4F4" >Single</th>
					  <th width="6%" align="left" bgcolor="#F4F4F4" >Double</th>
					  <th width="6%" align="left" bgcolor="#F4F4F4" >Twin</th>
					  <th width="12%" align="left" bgcolor="#F4F4F4" >Extra&nbsp;Bed(Adult)</th><!--
				  	  <th width="12%" align="left" bgcolor="#F4F4F4" >Extra&nbsp;Bed(Child)</th>
					  <th width="8%" align="left" bgcolor="#F4F4F4" >Child W/O</th>-->
				   </tr>
		      </thead>
				   <tbody>
				   	<tr>
		   	  		  <td align="left"><?php if ($dmcroommastermain['singleoccupancy']!=0) { echo $supplementCostc['singleoccupancy']; }?></td>
				   	  <td align="left"><?php if ($dmcroommastermain['doubleoccupancy']!=0) { echo $supplementCostc['doubleoccupancy'];} ?></td>
					  <td align="left"><?php if ($dmcroommastermain['twinoccupancy']!=0) { echo $supplementCostc['twinoccupancy'];} ?></td>
				   	  <td align="left"><?php if ($dmcroommastermain['extraBed']!=0) {echo $supplementCostc['extraBed'];} ?></td>
				   	 <!-- <td align="left"><?php if ($dmcroommastermain['childwithbed']!=0) { echo $supplementCostc['childwithbed'];}  ?></td>
				   	  <td align="left"><?php if ($dmcroommastermain['childwithoutbed']!=0) { echo $supplementCostc['childwithoutbed'];} ?></td>-->
 				   </tr>
				   </tbody>
		   </table>
			</form>
		</div>
	</div>

	<?php
}

if($_REQUEST['action'] == 'saveMealType2' && $_REQUEST['quotationId'] != ''){
	$quotationId=($_REQUEST['quotationId']);
	$supplierId=($_REQUEST['supplierId']);
	$hotelQuoteId=($_REQUEST['hotelQuoteId']);
	
	$breakfast = $lunch = $dinner = 0;
	if(isset($_REQUEST['meal_breakfast']) && $_REQUEST['meal_breakfast']==1){
		$breakfast = 1;
	}

	if(isset($_REQUEST['meal_lunch']) && $_REQUEST['meal_lunch']==1){
		$lunch = 1;
	}

	if(isset($_REQUEST['meal_dinner']) && $_REQUEST['meal_dinner']==1){
		$dinner = 1;
	}

	if($breakfast == 1 || $lunch == 1 || $dinner == 1){
		$namevalue ='complimentaryBreakfast="'.$breakfast.'",complimentaryLunch="'.$lunch.'",complimentaryDinner="'.$dinner.'"';
		$where=' supplierId="'.$supplierId.'" and quotationId = "'.$quotationId.'" and id="'.$hotelQuoteId.'" ';
		$update = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,$where);
		if($update == 'yes'){
			$msg = "Meal Type Updated!";
		}else{
			$msg = "Something went wronge!";
		}
		?>
		<script>
			parent.$('#pageloading').hide(); 
			parent.$('#pageloader').hide(); 
			parent.warningalert('<?php echo $msg; ?>');
			parent.closeinbound();
			parent.loadquotationmainfile();
		</script>
		<?php
	}else{  ?>
		<script>
			parent.$('#pageloading').hide(); 
			parent.$('#pageloader').hide(); 
			parent.warningalert('Please select any meal type.');
		</script>
		<?php
	}
} 
if($_REQUEST['action'] == 'selectAdultChildMeal2' && $_REQUEST['dayId'] != '' && $_REQUEST['hotelQuoteId'] != '' && $_REQUEST['roomTariffId']!=''){

	$quotationId = $_REQUEST['quotationId'];
	$hotelQuoteId = $_REQUEST['hotelQuoteId'];

	$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" order by id desc');
	$quotationData = mysqli_fetch_assoc($rs1);

	$rs2=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and id="'.$hotelQuoteId.'" order by id desc');
	$hotelQuotData = mysqli_fetch_assoc($rs2);

	?>
	<div class="contentdiv ">
		<h1 class="contentheader" >Select Meal Type <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody ">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editMealType" target="actoinfrm" id="editMealType">
				
				<label class="form-control-151 w40 f-left">
					<input type="checkbox" name="meal_breakfast"  value="1" <?php if($hotelQuotData['complimentaryBreakfast']==1){ ?> checked="checked" <?php } ?>>Breakfast
				</label> 
				<label class="form-control-151 w30 f-left">
					<input type="checkbox" name="meal_lunch"  value="1" <?php if($hotelQuotData['complimentaryLunch']==1){ ?> checked="checked" <?php } ?>>Lunch
				</label>
				<label class="form-control-151 w30 f-left">
					<input type="checkbox" name="meal_dinner"  value="1" <?php if($hotelQuotData['complimentaryDinner']==1){ ?> checked="checked" <?php } ?>>Dinner
				</label>
				<input type="hidden" name="action" value="saveMealType">
				<input type="hidden" name="quotationId" value="<?php echo $quotationId; ?>">
				<input type="hidden" name="supplierId" value="<?php echo $hotelQuotData['supplierId']; ?>">
				<input type="hidden" name="dayId" value="<?php echo $_REQUEST['dayId']; ?>">
				<input type="hidden" name="hotelQuoteId" value="<?php echo $_REQUEST['hotelQuoteId']; ?>">
				<input type="hidden" name="roomTariffId" value="<?php echo $_REQUEST['roomTariffId']; ?>">
			</form>
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="left" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="  Confirm  " onclick="formValidation('editMealType','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 
// hotel edit end

// entrance edit start  
if($_REQUEST['action'] == 'editQuotationEntranceRate' && $_REQUEST['entranceQuoteId'] != ''){

	$qEntQuery2='';
	$qEntQuery2=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,'id="'.$_REQUEST['entranceQuoteId'].'"'); 
	$qEntData2=mysqli_fetch_array($qEntQuery2); 

	$cityName = getCityNameByDayId($qEntData2['dayId']);

    // entrance data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$qEntData2['entranceNameId'].'"');
	$activityData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$entranceData['entranceName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100"  align="left" >
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="ent_supplierId2" name="ent_supplierId2" class="gridfield validate" displayname="Suppliers" autocomplete="off"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( activityType=3 or activityType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qEntData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 

						<td width="100" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Tarif Type<span class="redmind"></span></div>
							<select id="ent_tarifType2" name="ent_tarifType2" class="gridfield" displayname="Tarif Type" autocomplete="off">
								<option value="1" <?php if(1==$qEntData2['tarifType']){ ?>selected="selected"<?php } ?>>Normal</option>
								<option value="2" <?php if(2==$qEntData2['tarifType']){ ?>selected="selected"<?php } ?>>Weekend</option>
							</select>
							</label>
							</div>
						</td>
						 
						<td width="100"  align="left">
							<div class="griddiv">
							<label>
								<div class="gridlable">Cost&nbsp;Type</div>
								<select id="ent_transferType2" name="ent_transferType2" class="gridfield " autocomplete="off" onchange="selectQuotActTPType(this.value);">
									<option value="1" <?php if($qEntData2['transferType']==1){ ?> selected="selected" <?php } ?>>SIC</option>
									<option value="2" <?php if($qEntData2['transferType']==2){ ?> selected="selected" <?php } ?>>PVT</option>
									<option value="3" <?php if($qEntData2['transferType']==3){ ?> selected="selected" <?php } ?> >Ticket Only</option>
								</select>
							</label>
							</div>
							<script type="text/javascript">
								function selectQuotActTPType(transType) {
									if(transType == 1 || transType == 0){
										$('.sic').show();
										$('.rep').show();
										$('.pvt').hide(); 
									}
									if(transType == 2) {
										$('.sic').hide();
										$('.pvt').show(); 
										$('.rep').show(); 
									}
									if(transType == 3) {
										$('.sic').hide();
										$('.pvt').hide(); 
										$('.rep').hide(); 
									}
								}
								selectQuotActTPType(<?php echo $qEntData2['transferType']; ?>);
							</script>
						</td>
					</tr>
					<tr>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ent_ticketAdultCost2" type="text" class="gridfield"  id="ent_ticketAdultCost2" value="<?php echo ($qEntData2['ticketAdultCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ent_adultPax2" type="text" class="gridfield"  id="ent_adultPax2" value="<?php echo $qEntData2['adultPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ent_ticketchildCost2" type="text" class="gridfield"  id="ent_ticketchildCost2" value="<?php echo ($qEntData2['ticketchildCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ent_childPax2" type="text" class="gridfield"  id="ent_childPax2" value="<?php echo $qEntData2['childPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ent_ticketinfantCost2" type="text" class="gridfield"  id="ent_ticketinfantCost2" value="<?php echo ($qEntData2['ticketinfantCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ent_infantPax2" type="text" class="gridfield"  id="ent_infantPax2" value="<?php echo $qEntData2['infantPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="50" align="left">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="ent_currencyId2" name="ent_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'ent_currencyVal127');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qEntData2['currencyId']>0)?$qEntData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qEntData2['currencyValue']>0)?$qEntData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="50" align="left">
							<div class="griddiv">
							<label> 
							<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
							<input class="gridfield validate" name="ent_currencyValue2" displayname="ROI Value"  id="ent_currencyVal127" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100" align="left" class="rep" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Rep. Cost</div>
									<input class="gridfield " name="ent_repCost2" displayname="Representative Cost"  id="ent_repCost2" value="<?php echo trim($qEntData2['repCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr> 		
					<tr>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Adult Transfer</div>
									<input class="gridfield " name="ent_transferAdultCost2" displayname="Adult Transfer"  id="ent_transferAdultCost2" value="<?php echo trim($qEntData2['adultCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Child Transfer</div>
									<input class="gridfield " name="ent_transferChildCost2" displayname="Child Transfer"  id="ent_transferChildCost2" value="<?php echo trim($qEntData2['childCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Infant Transfer</div>
									<input class="gridfield " name="ent_transferInfantCost2" displayname="Infant Transfer"  id="ent_transferInfantCost2" value="<?php echo trim($qEntData2['infantCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>  
						<!-- PVT -->
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Type</div>
									<select id="ent_vehicleType2" name="ent_vehicleType2" class="gridfield " displayname="Vehicle Type" autocomplete="off" width="100%" >
										<?php 
										$rs = '';
										$rs = GetPageRecord('*','vehicleTypeMaster','name!="" and status=1');
										while($tptTypeData = mysqli_fetch_assoc($rs)){
										?>
										<option value="<?php echo $tptTypeData['id']; ?>" <?php if($qEntData2['vehicleType']==$tptTypeData['id']){ echo 'selected'; } ?>><?php echo $tptTypeData['name']; ?></option>
										<?php } ?>
									</select> 
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Cost</div>
									<input class="gridfield " name="ent_vehicleCost2" displayname="Vehicle Cost "  id="ent_vehicleCost2" value="<?php echo trim($qEntData2['vehicleCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">No of Vehicles</div>
									<input class="gridfield " name="ent_noOfVehicles2" displayname="noOfVehicles "  id="ent_noOfVehicles2" value="<?php echo trim($qEntData2['noOfVehicles']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr>			
					<tr> 	
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Type</div>
							<select name="ent_markupType2" id="ent_markupType2" class="gridfield " displayname="Markup Type" autocomplete="off" style="width: 100%;">
							 	<option value="1" <?php if($qEntData2['markupType'] == 1){ ?> selected="selected" <?php } ?>>%</option>
							 	<option value="2" <?php if($qEntData2['markupType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
							</select>
							</label>
							</div>
						</td>
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Cost</div>
							<input name="ent_markupCost2" type="text" class="gridfield"  id="ent_markupCost2" maxlength="6" onkeyup="numericFilter(this);" value="<?php echo $qEntData2['markupCost']; ?>" />
							</label>
							</div>
						</td>
						<td width="50" align="left"><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="ent_gstTax2" name="ent_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Entrance"');
								while($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($qEntData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								}
								?>
							</select>
							</label>
							</div>
						</td>  
					</tr>
					<tr> 
						<td width="100" colspan="3">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="ent_remark2" type="text" class="gridfield" id="ent_remark2" value="<?php echo $qEntData2['detail'] ?>" style="width: 99%;">
								</label>
							</div> 
 							<input name="entranceQuoteId2" type="hidden" id="entranceQuoteId2" value="<?php echo $qEntData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationEntranceRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 
if($_REQUEST['action'] == 'saveQuotationEntranceRate' && $_REQUEST['entranceQuoteId2'] != ''){  

	$namevalue ='supplierId="'.$_REQUEST['ent_supplierId2'].'",tarifType="'.$_REQUEST['ent_tarifType2'].'",transferType="'.$_REQUEST['ent_transferType2'].'",vehicleId="'.$_REQUEST['ent_vehicleType2'].'",gstTax="'.$_REQUEST['ent_gstTax2'].'",markupCost="'.$_REQUEST['ent_markupCost2'].'",markupType="'.$_REQUEST['ent_markupType2'].'",currencyId="'.$_REQUEST['ent_currencyId2'].'",currencyValue="'.$_REQUEST['ent_currencyValue2'].'",ticketAdultCost="'.$_REQUEST['ent_ticketAdultCost2'].'",adultPax="'.$_REQUEST['ent_adultPax2'].'",ticketchildCost="'.$_REQUEST['ent_ticketchildCost2'].'",childPax="'.$_REQUEST['ent_childPax2'].'",ticketinfantCost="'.$_REQUEST['ent_ticketinfantCost2'].'",infantPax="'.$_REQUEST['ent_infantPax2'].'",adultCost="'.$_REQUEST['ent_transferAdultCost2'].'",ChildCost="'.$_REQUEST['ent_transferChildCost2'].'",infantCost="'.$_REQUEST['ent_transferInfantCost2'].'",vehicleCost="'.$_REQUEST['ent_vehicleCost2'].'",noOfVehicles="'.$_REQUEST['ent_noOfVehicles2'].'",repCost="'.$_REQUEST['ent_repCost2'].'",detail="'.$_REQUEST['ent_remark2'].'"';
	$updatelist = updatelisting(_QUOTATION_ENTRANCE_MASTER_,$namevalue,'id="'.trim($_REQUEST['entranceQuoteId2']).'"');
	?>
	<script>
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Entrance Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} 
// entrance edit end

// activity edit start 
if($_REQUEST['action'] == 'editQuotationActivityRate' && $_REQUEST['activityQuoteId'] != ''){

	$qActQuery2='';
	$qActQuery2=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,'id="'.$_REQUEST['activityQuoteId'].'"');
	$qActData2=mysqli_fetch_array($qActQuery2);

	$cityName = getCityNameByDayId($qActData2['dayId']);

    // entrance data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_ACTIVITY_MASTER_,' id="'.$qActData2['otherActivityName'].'"');
	$activityData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$activityData['otherActivityName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100"  align="left" >
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="act_supplierId2" name="act_supplierId2" class="gridfield validate" displayname="Suppliers" autocomplete="off"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( activityType=3 or activityType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qActData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 

						<td width="100" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Tarif Type<span class="redmind"></span></div>
							<select id="act_tarifType2" name="act_tarifType2" class="gridfield" displayname="Tarif Type" autocomplete="off">
								<option value="1" <?php if(1==$qActData2['tarifType']){ ?>selected="selected"<?php } ?>>Normal</option>
								<option value="2" <?php if(2==$qActData2['tarifType']){ ?>selected="selected"<?php } ?>>Weekend</option>
							</select>
							</label>
							</div>
						</td>
						 
						<td width="100"  align="left">
							<div class="griddiv">
							<label>
								<div class="gridlable">Cost&nbsp;Type</div>
								<select id="act_transferType2" name="act_transferType2" class="gridfield " autocomplete="off" onchange="selectQuotActTPType(this.value);">
									<option value="1" <?php if($qActData2['transferType']==1){ ?> selected="selected" <?php } ?>>SIC</option>
									<option value="2" <?php if($qActData2['transferType']==2){ ?> selected="selected" <?php } ?>>PVT</option>
									<option value="3" <?php if($qActData2['transferType']==3){ ?> selected="selected" <?php } ?>>VIP</option>
									<option value="4" <?php if($qActData2['transferType']==4){ ?> selected="selected" <?php } ?> >Ticket Only</option>
								</select>
							</label>
							</div>
							<script type="text/javascript">
								function selectQuotActTPType(transType) {
									if(transType == 1 || transType == 0){
										$('.sic').show();
										$('.rep').show();
										$('.pvt').hide(); 
									}
									if(transType == 2 || transType == 3) {
										$('.sic').hide();
										$('.pvt').show(); 
										$('.rep').show(); 
									}
									if(transType == 4) {
										$('.sic').hide();
										$('.pvt').hide(); 
										$('.rep').hide(); 
									}
								}
								selectQuotActTPType(<?php echo $qActData2['transferType']; ?>);
							</script>
						</td>
					</tr>
					<tr>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="act_ticketAdultCost2" type="text" class="gridfield"  id="act_ticketAdultCost2" value="<?php echo ($qActData2['ticketAdultCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="act_adultPax2" type="text" class="gridfield"  id="act_adultPax2" value="<?php echo $qActData2['adultPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="act_ticketchildCost2" type="text" class="gridfield"  id="act_ticketchildCost2" value="<?php echo ($qActData2['ticketchildCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="act_childPax2" type="text" class="gridfield"  id="act_childPax2" value="<?php echo $qActData2['childPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="act_ticketinfantCost2" type="text" class="gridfield"  id="act_ticketinfantCost2" value="<?php echo ($qActData2['ticketinfantCost']) ?>" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="act_infantPax2" type="text" class="gridfield"  id="act_infantPax2" value="<?php echo $qActData2['infantPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="50" align="left">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="act_currencyId2" name="act_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'act_currencyVal127');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qActData2['currencyId']>0)?$qActData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qActData2['currencyValue']>0)?$qActData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="50" align="left">
							<div class="griddiv">
							<label> 
							<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
							<input class="gridfield validate" name="act_currencyValue2" displayname="ROI Value"  id="act_currencyVal127" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100" align="left" class="rep" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Rep. Cost</div>
									<input class="gridfield " name="act_repCost2" displayname="Representative Cost"  id="act_repCost2" value="<?php echo ($qActData2['repCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Adult Transfer</div>
									<input class="gridfield " name="act_transferAdultCost2" displayname="Adult Transfer"  id="act_transferAdultCost2" value="<?php echo ($qActData2['adultCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Child Transfer</div>
									<input class="gridfield " name="act_transferChildCost2" displayname="Child Transfer"  id="act_transferChildCost2" value="<?php echo ($qActData2['childCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="sic" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Infant Transfer</div>
									<input class="gridfield " name="act_transferInfantCost2" displayname="Infant Transfer"  id="act_transferInfantCost2" value="<?php echo ($qActData2['infantCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td> 

						<!-- PVT -->
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Type</div>
									<select id="act_vehicleType2" name="act_vehicleType2" class="gridfield " displayname="Vehicle Type" autocomplete="off" width="100%" >
										<?php 
										$rs = '';
										$rs = GetPageRecord('*','vehicleTypeMaster','name!="" and status=1');
										while($tptTypeData = mysqli_fetch_assoc($rs)){
										?>
										<option value="<?php echo $tptTypeData['id']; ?>" <?php if($qActData2['vehicleId']==$tptTypeData['id']){ echo 'selected'; } ?>><?php echo $tptTypeData['name']; ?></option>
										<?php } ?>
									</select> 
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">Vehicle Cost</div>
									<input class="gridfield " name="act_vehicleCost2" displayname="Vehicle Cost "  id="act_vehicleCost2" value="<?php echo ($qActData2['vehicleCost']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
						<td width="100" align="left" class="pvt" style="display:none;" >
							<div class="griddiv">
								<label> 
									<div class="gridlable">No of Vehicles</div>
									<input class="gridfield " name="act_noOfVehicles2" displayname="noOfVehicles"  id="act_noOfVehicles2" value="<?php echo trim($qActData2['noOfVehicles']); ?>" style="display:inline-block;" >
								</label>
							</div>
						</td>
					</tr>			
					<tr> 	
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Type</div>
							<select name="act_markupType2" id="act_markupType2" class="gridfield " displayname="Markup Type" autocomplete="off" style="width: 100%;">
							 	<option value="1" <?php if($qActData2['markupType'] == 1){ ?> selected="selected" <?php } ?>>%</option>
							 	<option value="2" <?php if($qActData2['markupType'] == 2){ ?> selected="selected" <?php } ?>>Flat</option>
							</select>
							</label>
							</div>
						</td>
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">Markup&nbsp;Cost</div>
							<input name="act_markupCost2" type="text" class="gridfield"  id="act_markupCost2" maxlength="6" onkeyup="numericFilter(this);" value="<?php echo $qActData2['markupCost']; ?>" />
							</label>
							</div>
						</td>
						<td width="50" align="left"><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="act_gstTax2" name="act_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Activity"');
								while($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($qActData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								}
								?>
							</select>
							</label>
							</div>
						</td>  
					</tr>
					<tr> 
						<td width="100" colspan="3">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="act_remark2" type="text" class="gridfield" id="act_remark2" value="<?php echo $qActData2['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
 							<input name="activityQuoteId2" type="hidden" id="activityQuoteId2" value="<?php echo $qActData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationActivityRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 
if($_REQUEST['action'] == 'saveQuotationActivityRate' && $_REQUEST['activityQuoteId2'] != ''){  

	$namevalue ='supplierId="'.$_REQUEST['act_supplierId2'].'",tarifType="'.$_REQUEST['act_tarifType2'].'",transferType="'.$_REQUEST['act_transferType2'].'",vehicleId="'.$_REQUEST['act_vehicleType2'].'",gstTax="'.$_REQUEST['act_gstTax2'].'",markupCost="'.$_REQUEST['act_markupCost2'].'",markupType="'.$_REQUEST['act_markupType2'].'",currencyId="'.$_REQUEST['act_currencyId2'].'",currencyValue="'.$_REQUEST['act_currencyValue2'].'",ticketAdultCost="'.$_REQUEST['act_ticketAdultCost2'].'",adultPax="'.$_REQUEST['act_adultPax2'].'",ticketchildCost="'.$_REQUEST['act_ticketchildCost2'].'",childPax="'.$_REQUEST['act_childPax2'].'",ticketinfantCost="'.$_REQUEST['act_ticketinfantCost2'].'",infantPax="'.$_REQUEST['act_infantPax2'].'",adultCost="'.$_REQUEST['act_transferAdultCost2'].'",childCost="'.$_REQUEST['act_transferChildCost2'].'",infantCost="'.$_REQUEST['act_transferInfantCost2'].'",vehicleCost="'.$_REQUEST['act_vehicleCost2'].'",noOfVehicles="'.$_REQUEST['act_noOfVehicles2'].'",repCost="'.$_REQUEST['act_repCost2'].'",remark="'.$_REQUEST['act_remark2'].'"';
	$updatelist = updatelisting(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue,'id="'.trim($_REQUEST['activityQuoteId2']).'"');
	?>
	<script>
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Activity Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} 
// activity edit end

// flight edit start 
if($_REQUEST['action'] == 'editQuotationFlightRate' && $_REQUEST['flightQuoteId'] != ''){

	$qFlightQuery2='';
	$qFlightQuery2=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'id="'.$_REQUEST['flightQuoteId'].'"');
	$qFlightData2=mysqli_fetch_array($qFlightQuery2);

	$cityName = getCityNameByDayId($qFlightData2['dayId']);
    // entrance data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$qFlightData2['flightNameId'].'"');
	$entranceData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$entranceData['flightName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100" colspan="2" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="ft_supplierId2" name="ft_supplierId2" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( airlinesType=7 or airlinesType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qFlightData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 

						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Flight&nbsp;Number<span class="redmind"></span></div>
							<input type="text" class="gridfield validate" name="ft_flightNumber2" displayname="Flight Number"  id="ft_flightNumber2" value="<?php echo trim($qFlightData2['flightNumber']); ?>"  >
							</label>
							</div>
						</td> 
						
						<td width="50" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Flight&nbsp;Class</div>
								<select id="ft_flightClass2" name="ft_flightClass2" class="gridfield" displayname="Flight Class"  autocomplete="off" >
									<option value="First_Class" <?php if($qFlightData2['id']=='First_Class'){ ?>selected="selected"<?php } ?>>First Class</option>
									<option value="Business_Class" <?php if($qFlightData2['id']=='Business_Class'){ ?>selected="selected"<?php } ?>>Business Class</option>
									<option value="Economy_Class" <?php if($qFlightData2['id']=='Economy_Class'){ ?>selected="selected"<?php } ?>>Economy Class</option>
									<option value="Premium_Economy_Class" <?php if($qFlightData2['id']=='Premium_Economy_Class'){ ?>selected="selected"<?php } ?>>Premium Economy Class</option>

									<option value="E" <?php if($qFlightData2['flightClass'] == 'E'){?> selected="selected" <?php } ?>>E</option>
									<option value="F" <?php if($qFlightData2['flightClass'] == 'F'){?> selected="selected" <?php } ?>>F</option>
									<option value="G" <?php if($qFlightData2['flightClass'] == 'G'){?> selected="selected" <?php } ?>>G</option>
									<option value="Y" <?php if($qFlightData2['flightClass'] == 'Y'){?> selected="selected" <?php } ?>>Y</option>
									<option value="N" <?php if($qFlightData2['flightClass'] == 'N'){?> selected="selected" <?php } ?>>N</option>
									<option value="E1" <?php if($qFlightData2['flightClass'] == 'E1'){?> selected="selected" <?php } ?>>E1</option>
									<option value="H" <?php if($qFlightData2['flightClass'] == 'H'){?> selected="selected" <?php } ?>>H</option>
									<option value="S" <?php if($qFlightData2['flightClass'] == 'S'){?> selected="selected" <?php } ?>>S</option>


								</select></label>
							</div>
						</td>

						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Bagg.&nbsp;Allowance</div>
							<input type="text" class="gridfield" name="ft_baggageAllowance2" displayname="Baggage Allowance" id="ft_baggageAllowance2" value="<?php echo trim($qFlightData2['baggageAllowance']); ?>">
							</label>
							</div>
						</td>
						
						<td width="50" align="left"><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="ft_gstTax2" name="ft_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Airlines"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($qFlightData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>  
					</tr> 
					<tr>
						<td width="100" align="left"  colspan="2" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ft_adultCost2" type="text" class="gridfield"  id="ft_adultCost2" value="<?php echo $qFlightData2['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ft_adultPax2" type="text" class="gridfield"  id="ft_adultPax2" value="<?php echo $qFlightData2['adultPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left" colspan="2"  >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ft_childCost2" type="text" class="gridfield"  id="ft_childCost2" value="<?php echo $qFlightData2['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ft_childPax2" type="text" class="gridfield"  id="ft_childPax2" value="<?php echo $qFlightData2['childPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td width="100" align="left"  colspan="2" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ft_infantCost2" type="text" class="gridfield"  id="ft_infantCost2" value="<?php echo $qFlightData2['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ft_infantPax2" type="text" class="gridfield"  id="ft_infantPax2" value="<?php echo $qFlightData2['infantPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="100" align="left" colspan="2" >
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="ft_currencyId2" name="ft_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'ft_currencyValue2');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qFlightData2['currencyId']>0)?$qFlightData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qFlightData2['currencyValue']>0)?$qFlightData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="100"  align="left" colspan="2" >
							<div class="griddiv"  >
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="ft_currencyValue2" displayname="ROI Value"  id="ft_currencyValue2" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100"  colspan="2" >
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="ft_remark2" type="text" class="gridfield" id="ft_remark2" value="<?php echo $qFlightData2['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
 							<input name="flightQuoteId2" type="hidden" id="flightQuoteId2" value="<?php echo $qFlightData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationFlightRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 
if($_REQUEST['action'] == 'saveQuotationFlightRate' && $_REQUEST['flightQuoteId2'] != ''){  
	
	 $namevalue ='supplierId="'.$_REQUEST['ft_supplierId2'].'",flightClass="'.$_REQUEST['ft_flightClass2'].'",flightNumber="'.$_REQUEST['ft_flightNumber2'].'",baggageAllowance="'.$_REQUEST['ft_baggageAllowance2'].'",flightNumber="'.$_REQUEST['ft_flightNumber2'].'",gstTax="'.$_REQUEST['ft_gstTax2'].'",currencyId="'.$_REQUEST['ft_currencyId2'].'",currencyValue="'.$_REQUEST['ft_currencyValue2'].'",adultCost="'.$_REQUEST['ft_adultCost2'].'",adultPax="'.$_REQUEST['ft_adultPax2'].'",childCost="'.$_REQUEST['ft_childCost2'].'",childPax="'.$_REQUEST['ft_childPax2'].'",infantCost="'.$_REQUEST['ft_infantCost2'].'",infantPax="'.$_REQUEST['ft_infantPax2'].'",remark="'.$_REQUEST['ft_remark2'].'"';  
	$updatelist = updatelisting(_QUOTATION_FLIGHT_MASTER_,$namevalue,'id="'.trim($_REQUEST['flightQuoteId2']).'"'); ?>
	<script>
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Flight Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} // flight edit end


// train edit start 
if($_REQUEST['action'] == 'editQuotationTrainRate' && $_REQUEST['trainQuoteId'] != ''){

	$qTrainQuery2='';
	$qTrainQuery2=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'id="'.$_REQUEST['trainQuoteId'].'"');
	$qTrainData2=mysqli_fetch_array($qTrainQuery2);

	$cityName = getCityNameByDayId($qTrainData2['dayId']);
    // entrance data
	$d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$qTrainData2['trainNameId'].'"');
	$entranceData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$entranceData['trainName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100"  align="left" colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="tr_supplierId2" name="tr_supplierId2" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( trainType=8 or trainType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qTrainData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 
						
						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Train&nbsp;Number<span class="redmind"></span></div>
							<input type="text" class="gridfield validate" name="tr_trainNumber2" displayname="Train Number"  id="tr_trainNumber2" value="<?php echo trim($qTrainData2['trainNumber']); ?>"  >
							</label>
							</div>
						</td> 
						
						<td width="50" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Train&nbsp;Class</div>
								<select id="tr_trainClass2" name="tr_trainClass2" class="gridfield" displayname="Train Class"  autocomplete="off" >
									<option value="AC First Class"  <?php if($qTrainData2['id']=='AC First Class'){ ?>selected="selected"<?php } ?>>AC First Class</option>
									<option value="AC 2-Tier"  <?php if($qTrainData2['id']=='AC 2-Tier'){ ?>selected="selected"<?php } ?>>AC 2-Tier</option>
									<option value="AC 3-Tier"  <?php if($qTrainData2['id']=='AC 3-Tier'){ ?>selected="selected"<?php } ?>>AC 3-Tier	</option>
									<option value="First Class"  <?php if($qTrainData2['id']=='First Class'){ ?>selected="selected"<?php } ?>>First Class	</option>
									<option value="AC Chair Car"  <?php if($qTrainData2['id']=='AC Chair Car'){ ?>selected="selected"<?php } ?>>AC Chair Car</option>
									<option value="Second Sitting"  <?php if($qTrainData2['id']=='Second Sitting'){ ?>selected="selected"<?php } ?>>Second Sitting</option>
									<option value="Sleeper"  <?php if($qTrainData2['id']=='Sleeper'){ ?>selected="selected"<?php } ?>>Sleeper</option>
								</select></label>
							</div>
						</td>
						
						<td width="50" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Journey&nbsp;Type</div>
							<select id="tr_journeyType2" name="tr_journeyType2" class="gridfield validate" displayname="Journey Type" autocomplete="off" >
 								<option value="day_journey"  <?php if($qTrainData2['id']=='day_journey'){ ?>selected="selected"<?php } ?>>day_journey</option>
								<option value="overnight_journey"  <?php if($qTrainData2['id']=='overnight_journey'){ ?>selected="selected"<?php } ?>>overnight_journey</option>
							</select>
							</label>
							</div>
						</td>
						
						<td width="50" align="left">
							<div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="tr_gstTax2" name="tr_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Train"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($qTrainData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>

					</tr>
					<tr> 
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_adultCost2" type="text" class="gridfield"  id="tr_adultCost2" value="<?php echo $qTrainData2['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_adultPax2" type="text" class="gridfield"  id="tr_adultPax2" value="<?php echo $qTrainData2['adultPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_childCost2" type="text" class="gridfield"  id="tr_childCost2" value="<?php echo $qTrainData2['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_childPax2" type="text" class="gridfield"  id="tr_childPax2" value="<?php echo $qTrainData2['childPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_infantCost2" type="text" class="gridfield"  id="tr_infantCost2" value="<?php echo $qTrainData2['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_infantPax2" type="text" class="gridfield"  id="tr_infantPax2" value="<?php echo $qTrainData2['infantPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="200" align="left" colspan="2" >
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="tr_currencyId2" name="tr_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'tr_currencyValue2');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qTrainData2['currencyId']>0)?$qTrainData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qTrainData2['currencyValue']>0)?$qTrainData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="200"  align="left" colspan="2" >
							<div class="griddiv">
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="tr_currencyValue2" displayname="ROI Value"  id="tr_currencyValue2" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="200"  align="left" colspan="2" >
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="tr_remark2" type="text" class="gridfield" id="tr_remark2" value="<?php echo $qTrainData2['remark'] ?>" >
								</label>
							</div> 
 							<input name="trainQuoteId2" type="hidden" id="trainQuoteId2" value="<?php echo $qTrainData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationTrainRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 
if($_REQUEST['action'] == 'saveQuotationTrainRate' && $_REQUEST['trainQuoteId2'] != ''){  
	$namevalue ='supplierId="'.$_REQUEST['tr_supplierId2'].'",trainClass="'.$_REQUEST['tr_trainClass2'].'",trainNumber="'.$_REQUEST['tr_trainNumber2'].'",journeyType="'.$_REQUEST['tr_journeyType2'].'",trainNumber="'.$_REQUEST['tr_trainNumber2'].'",gstTax="'.$_REQUEST['tr_gstTax2'].'",currencyId="'.$_REQUEST['tr_currencyId2'].'",currencyValue="'.$_REQUEST['tr_currencyValue2'].'",adultCost="'.$_REQUEST['tr_adultCost2'].'",adultPax="'.$_REQUEST['tr_adultPax2'].'",childCost="'.$_REQUEST['tr_childCost2'].'",childPax="'.$_REQUEST['tr_childPax2'].'",infantCost="'.$_REQUEST['tr_infantCost2'].'",infantPax="'.$_REQUEST['tr_infantPax2'].'",remark="'.$_REQUEST['tr_remark2'].'"';  
	$updatelist = updatelisting(_QUOTATION_TRAINS_MASTER_,$namevalue,'id="'.trim($_REQUEST['trainQuoteId2']).'"'); ?>
	<script>
	parent.$('#pageloading').hide(); 
	parent.$('#pageloader').hide(); 
	parent.warningalert('Train Rate Updated!');
	parent.closeinbound();
	parent.loadquotationmainfile();
	</script>
	<?php
} 
// train edit end

// ferry edit start 
if($_REQUEST['action'] == 'editQuotationFerryRate' && $_REQUEST['ferryQuoteId'] != ''){

	$qFerryQuery2='';
	$qFerryQuery2=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,'id="'.$_REQUEST['ferryQuoteId'].'"');
	$qFerryData2=mysqli_fetch_array($qFerryQuery2);

	$cityName = getCityNameByDayId($qFerryData2['dayId']);

	$res3='';
	$res3=GetPageRecord('*','ferryServiceTiming','id="'.$ferryTimeId.'"'); 
	$ferryServicetimeData=mysqli_fetch_array($res3); 

    // ferry data
	$rs2='';
	$rs2=GetPageRecord('name,id',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$qFerryData2['serviceid'].'"'); 
	$ferryServiceData=mysqli_fetch_array($rs2); 

	if($qFerryData2['capacity']>0){
		$capacity = ($qFerryData2['capacity']);
	}else{
		$capacity = ($ferryNamD['capacity']);
	}
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$ferryServiceData['name']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100" align="left" colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="fr_supplierId2" name="fr_supplierId2" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( ferryType=10 or ferryType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qFerryData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 
						<td width="100" align="left" colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable">Ferry&nbsp;Name<span class="redmind"></span></div>
								<select id="fr_ferryNameId2" name="fr_ferryNameId2" class="gridfield" autocomplete="off" style="width: 100%;" >
								<?php    
								$rs=GetPageRecord('name,id',_FERRY_NAME_MASTER_,' 1  order by name asc'); 
								while($ferryCnpData=mysqli_fetch_array($rs)){  
								?>
								<option value="<?php echo strip($ferryCnpData['id']); ?>" <?php if($ferryCnpData['id']==$qFerryData2['ferryNameId']){ ?>selected="selected"<?php } ?>><?php echo strip($ferryCnpData['name']); ?></option>
								<?php } ?> 
							 	</select>
								</label>
							</div>
						</td> 
						<td width="100" align="left" colspan="2">
							<div class="griddiv" style="width:200px;"><label>
								<div class="gridlable">Ferry&nbsp;Seat<span class="redmind"></span></div>
								<select id="fr_ferryClass2" name="fr_ferryClass2" class="gridfield"  autocomplete="off" style="width: 100%;" >
								<?php    
								$rs=GetPageRecord('name,id',_FERRY_CLASS_MASTER_,' 1  order by name asc'); 
								while($ferryClmData=mysqli_fetch_array($rs)){  
								?>
								<option value="<?php echo strip($ferryClmData['id']); ?>" <?php if($ferryClmData['id']==$qFerryData2['ferryClass']){ ?>selected="selected"<?php } ?>><?php echo strip($ferryClmData['name']); ?></option>
								<?php } ?> 
							 	</select>
								</label>
							</div>
						</td>    
					</tr> 
					<tr>
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="fr_adultCost2" type="text" class="gridfield"  id="fr_adultCost2" value="<?php echo $qFerryData2['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="fr_adultPax2" type="text" class="gridfield"  id="fr_adultPax2" value="<?php echo $qFerryData2['adultPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="100" align="left"  colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="fr_childCost2" type="text" class="gridfield"  id="fr_childCost2" value="<?php echo $qFerryData2['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="fr_childPax2" type="text" class="gridfield"  id="fr_childPax2" value="<?php echo $qFerryData2['childPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td width="100" align="left"  colspan="2">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Ticket</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="fr_infantCost2" type="text" class="gridfield"  id="fr_infantCost2" value="<?php echo $qFerryData2['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="fr_infantPax2" type="text" class="gridfield"  id="fr_infantPax2" value="<?php echo $qFerryData2['infantPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="50" align="left" colspan="2">
							<div class="griddiv">
							<label>
							<div class="gridlable">Processing&nbsp;Fee</div>
							<input type="text" class="gridfield" name="fr_processingfee2" displayname="Processing fee" id="fr_processingfee2" value="<?php echo trim($qFerryData2['processingfee']); ?>">
							</label>
							</div>
						</td>

						<td width="50" align="left" colspan="2">
							<div class="griddiv">
							<label>
							<div class="gridlable">Misc&nbsp;Cost</div>
							<input type="text" class="gridfield" name="fr_miscCost2" displayname="Misc Cost" id="fr_miscCost2" value="<?php echo trim($qFerryData2['miscCost']); ?>">
							</label>
							</div>
						</td>
						
						<td width="50" align="left" colspan="2">
							<div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="fr_gstTax2" name="fr_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Ferry"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($qFerryData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>  
					</tr> 
					<tr> 
						<td>
						<div class="griddiv">
							<label>
							<div class="gridlable">Departure&nbsp;Time</div>
								<input type="text" id="arrivalTime" name="departureTime" value="<?php echo $qFerryData2['dropTime']; ?>" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2 ui-timepicker-input" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59" data-show-2400="true" value="" fdprocessedid="01vcrm" autocomplete="off">
							</label>
							</div>
					</td>

						<td>
						<div class="griddiv">
							<label>
							<div class="gridlable">Arrival&nbsp;Time</div>
								<input type="text" id="arrivalTime" name="arrivalTime" value="<?php echo $qFerryData2['pickupTime']; ?>" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2 ui-timepicker-input" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59" data-show-2400="true" value="" fdprocessedid="01vcrm" autocomplete="off">
							</label>
							</div>
						</td>
						

						<td width="100" align="left" >
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="fr_currencyId2" name="fr_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'fr_currencyValue2');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qFerryData2['currencyId']>0)?$qFerryData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qFerryData2['currencyValue']>0)?$qFerryData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="100"  align="left">
							<div class="griddiv"  >
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="fr_currencyValue2" displayname="ROI Value"  id="fr_currencyValue2" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="fr_remark2" type="text" class="gridfield" id="fr_remark2" value="<?php echo $qFerryData2['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
 							<input name="ferryQuoteId2" type="hidden" id="ferryQuoteId2" value="<?php echo $qFerryData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationFerryRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 

	<script type="text/javascript" src="js/jquery.timepicker.js"></script>
					<script type="text/javascript">
						$(document).ready(function() {
							$('.timepicker2').timepicker();
							$('.select2').select2();
						});
					</script>

	<?php
} 
if($_REQUEST['action'] == 'saveQuotationFerryRate' && $_REQUEST['ferryQuoteId2'] != ''){  
	
	$namevalue ='supplierId="'.$_REQUEST['fr_supplierId2'].'",ferryNameId="'.$_REQUEST['fr_ferryNameId2'].'",ferryClass="'.$_REQUEST['fr_ferryClass2'].'",processingfee="'.$_REQUEST['fr_processingfee2'].'",miscCost="'.$_REQUEST['fr_miscCost2'].'",gstTax="'.$_REQUEST['fr_gstTax2'].'",currencyId="'.$_REQUEST['fr_currencyId2'].'",currencyValue="'.$_REQUEST['fr_currencyValue2'].'",adultCost="'.$_REQUEST['fr_adultCost2'].'",adultPax="'.$_REQUEST['fr_adultPax2'].'",childCost="'.$_REQUEST['fr_childCost2'].'",childPax="'.$_REQUEST['fr_childPax2'].'",infantCost="'.$_REQUEST['fr_infantCost2'].'",infantPax="'.$_REQUEST['fr_infantPax2'].'",remark="'.$_REQUEST['fr_remark2'].'"';  
	$updatelist = updatelisting(_QUOTATION_FERRY_MASTER_,$namevalue,'id="'.trim($_REQUEST['ferryQuoteId2']).'"'); ?>
	<script>
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Ferry Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} 
// ferry edit end

if($_REQUEST['action'] == 'editQuotationCruiseRate' && $_REQUEST['cruiseQuoteId'] != ''){

	$qCruiseQuery2='';
	$qCruiseQuery2=GetPageRecord('*',_QUOTATION_CRUISE_MASTER_,'id="'.$_REQUEST['cruiseQuoteId'].'"');
	$qCruiseData2=mysqli_fetch_array($qCruiseQuery2);

	$cityName = getCityNameByDayId($qCruiseData2['dayId']);
    // entrance data
	$d=GetPageRecord('*',_CRUISE_MASTER_,' id="'.$qCruiseData2['cruiseNameId'].'"');
	$cruiseData=mysqli_fetch_array($d);
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$cruiseData['cruiseName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">

			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="180" align="left" colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="cr_supplierId2" name="cr_supplierId2" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( cruiseType=15 or cruiseType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qCruiseData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td>  

						<td width="180" align="left" colspan="2">
							<div class="griddiv">
								<label>
								<div class="gridlable">Cruise Name <span class="redmind"></span></div>
								<select name="cr_cruiseNameId2" class="gridfield validate" displayname="Cruise Name" id="cr_cruiseNameId2">
									<option value="">Select Cruise Name</option>
									<?php
									$rescr = GetPageRecord('name,id',_CRUISE_NAME_MASTER_,'deletestatus=0 and status=1');
									while($resultcruise = mysqli_fetch_assoc($rescr)){
									?>
									<option value="<?php echo $resultcruise['id']; ?>" <?php if($resultcruise['id']==$qCruiseData2['cruiseNameId']){ echo 'selected'; } ?> ><?php echo $resultcruise['name']; ?></option>
									<?php
									}
									
									?>
								</select>
								</label>
							</div>
						</td> 
						
						<td width="90" align="left">
							<div class="griddiv"><label>
								<div class="gridlable">Cabin&nbsp;Type</div>
								<select id="cr_cabinType2" name="cr_cabinType2" class="gridfield" displayname="Cabin Type"  autocomplete="off" >
									<option value="">Select Cabin Type</option>
									<?php
									$resseat = GetPageRecord('*',_CABIN_TYPE_,'name!="" and status=1');
									while($cabinTypeData = mysqli_fetch_assoc($resseat)){
									?>
									<option value="<?php echo $cabinTypeData['id']; ?>" <?php if($cabinTypeData['id']==$qCruiseData2['cabinTypeId']){ echo "selected"; } ?> > <?php echo $cabinTypeData['name']; ?></option>
									<?php
									}
									?>
								</select>
								</label>
							</div>
						</td>
						
						<td width="90" align="left">
							<div class="griddiv">
							<label>
							<div class="gridlable">Tariff&nbsp;Type<span class="redmind"></span></div>
								<select id="cr_tariffType2" name="cr_tariffType2" class="gridfield " displayname="Tariff Type" autocomplete="off" >
									<option value="1" <?php if($qCruiseData2['tariffTypeId'] == 1){ ?>selected="selected"<?php } ?>>Normal</option>
									<option value="2" <?php if($qCruiseData2['tariffTypeId'] == 2){ ?>selected="selected"<?php } ?>>Weekend</option>
								</select>
			           		</label>
							</div>
						</td> 

						<td width="90" align="left" >
							<div class="griddiv">
							<label>
								<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div>
								<select id="cr_marketType2" name="cr_marketType2" class="gridfield" displayname="Market Type" autocomplete="off">
									<?php
									$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by id asc');
									while($marketD=mysqli_fetch_array($rs)){
									?>
									<option value="<?php echo strip($marketD['id']); ?>" <?php if($marketD['id']==$qCruiseData2['marketType']){ ?>selected="selected"<?php } ?>><?php echo strip($marketD['name']); ?></option>
									<?php } ?>
								</select>
							</label>
							</div>
						</td> 

						<td width="90" align="left"><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="cr_gstTax2" name="cr_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Cruise"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($qCruiseData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>   
					</tr> 
					<tr>
						<td width="90" align="left">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="cr_currencyId2" name="cr_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'cr_currencyValue2');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qCruiseData2['currencyId']>0)?$qCruiseData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qCruiseData2['currencyValue']>0)?$qCruiseData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="90"  align="left"><div class="griddiv">
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="cr_currencyValue2" displayname="ROI Value"  id="cr_currencyValue2" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>

						<td width="180" align="left" colspan="2">
							<div class="griddiv" style="width:190px">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="cr_adultCost2" type="text" class="gridfield"  id="cr_adultCost2" value="<?php echo $qCruiseData2['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="cr_adultPax2" type="text" class="gridfield"  id="cr_adultPax2" value="<?php echo $qCruiseData2['adultPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td width="180" align="left" colspan="2">
							<div class="griddiv"  style="width:190px">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="cr_childCost2" type="text" class="gridfield"  id="cr_childCost2" value="<?php echo $qCruiseData2['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="cr_childPax2" type="text" class="gridfield"  id="cr_childPax2" value="<?php echo $qCruiseData2['childPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>

						<td width="180" align="left" colspan="2">
							<div class="griddiv"  style="width:190px">
								<label>  
									<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="cr_infantCost2" type="text" class="gridfield"  id="cr_infantCost2" value="<?php echo $qCruiseData2['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="cr_infantPax2" type="text" class="gridfield"  id="cr_infantPax2" value="<?php echo $qCruiseData2['infantPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="630" colspan="7" >
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="cr_remark2" type="text" class="gridfield" id="cr_remark2" value="<?php echo $qCruiseData2['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
 							<input name="cruiseQuoteId2" type="hidden" id="cruiseQuoteId2" value="<?php echo $qCruiseData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationCruiseRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 

if($_REQUEST['action'] == 'saveQuotationCruiseRate' && $_REQUEST['cruiseQuoteId2'] != ''){  
	
	$namevalue ='supplierId="'.$_REQUEST['cr_supplierId2'].'",cruiseNameId="'.$_REQUEST['cr_cruiseNameId2'].'",cabinTypeId="'.$_REQUEST['cr_cabinType2'].'",tariffTypeId="'.$_REQUEST['cr_tariffType2'].'",marketType="'.$_REQUEST['cr_marketType2'].'",gstTax="'.$_REQUEST['cr_gstTax2'].'",currencyId="'.$_REQUEST['cr_currencyId2'].'",currencyValue="'.$_REQUEST['cr_currencyValue2'].'",adultCost="'.$_REQUEST['cr_adultCost2'].'",adultPax="'.$_REQUEST['cr_adultPax2'].'",childCost="'.$_REQUEST['cr_childCost2'].'",childPax="'.$_REQUEST['cr_childPax2'].'",infantCost="'.$_REQUEST['cr_infantCost2'].'",infantPax="'.$_REQUEST['cr_infantPax2'].'",remark="'.$_REQUEST['cr_remark2'].'"';  
   $updatelist = updatelisting(_QUOTATION_CRUISE_MASTER_,$namevalue,'id="'.trim($_REQUEST['flightQuoteId2']).'"'); ?>
   <script>
	   parent.warningalert('Cruise Rate Updated!');
	   parent.closeinbound();
	   parent.loadquotationmainfile();
	   
	   parent.$('#pageloading').hide(); 
	   parent.$('#pageloader').hide(); 
	   
   </script>
   <?php
} 

if($_REQUEST['action'] == 'addCruiseTimeDetails' && $_REQUEST['cruiseQuoteId'] != ''){


	$c=GetPageRecord('*','quotationCruiseMaster','id="'.$_REQUEST['cruiseQuoteId'].'"');
	$cruiseQuotData=mysqli_fetch_array($c);

	
	if($cruiseQuotData['departureDate']!='1970-01-01' && $cruiseQuotData['departureDate']!='0000-00-00'){

		$departureDate = date('Y-m-d', strtotime($cruiseQuotData['departureDate'])); 
	}else{
		$departureDate = date('Y-m-d',strtotime($cruiseQuotData['fromDate']));
	}
	if($cruiseQuotData['departureTime']!='' && $cruiseQuotData['departureTime']!='00:00:00'){
		$departureTime = date('H:i', strtotime($cruiseQuotData['departureTime']));
	}else{
		$departureTime = date('H:i'); 
	}
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Departure Cruise Timeline  </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_Cruisetomaster" target="actoinfrm" id="add_Cruisetomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr >

                    <td width="40%">
                    	<div class="griddiv" style="border:none;">
                    		<label for="ArribleTime" style="font-size:12px;color: #333333;">
	                    		<div class="gridlable">Departure&nbsp;Date</div>
								<input type="date" id="departureDate_CR" name="departureDate_CR" class="gridfield" value="<?=  $departureDate ?>" style="text-align:left;width:90%;padding: 6px;border: 1px solid #ccc;border-radius: 2px;"/>
	                    	</label>
                       </div>
                    </td>
 
                    <td width="40%">
                    	<div class="griddiv" style="border:none;">
                    		<label for="departureTime" style="font-size:12px;color: #333333;">
	                    		<div class="gridlable">Departure&nbsp;Time</div>
								<input type="text" id="departureTime_CR" name="departureTime_CR" value="<?=  $departureTime ?>" style="text-align:left;width:90%;padding: 6px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" />
	                    	</label>
                       </div>
                    </td>

					<td  width="15%">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="  Save  " onclick="formValidation('add_Cruisetomaster','submitbtn','0');">
						<!-- <input type="button" class="whitembutton submitbtn" id="addnewuserbtn" value="  Close  " onclick="closeinbound()"> -->
					</td>
                </tr>
 					<input type="hidden" value="<?php echo $cruiseQuotData['id']; ?>" name="cruiseQuoteId"/>
					<input name="action" type="hidden" id="action" value="addUpdate_CruiseTimeline">
				</tbody>
			</table>
			</form>
			
			<script type="text/javascript" src="js/jquery.timepicker.js"></script>  
			<script type="text/javascript"> 
				$(document).ready(function(){
					$('.timepicker2').timepicker();	
				});  
			</script>

		</div>
	</div>
	<?php
}

if($_REQUEST['action'] == 'addUpdate_CruiseTimeline' && $_REQUEST['cruiseQuoteId']!= ''){
	
	$departureDate_CR = $_REQUEST['departureDate_CR'];
	$departureTime_CR = $_REQUEST['departureTime_CR'];
	$cruiseQuoteId = $_REQUEST['cruiseQuoteId'];
	
	$nameValue = 'departureDate="'.$departureDate_CR.'",departureTime="'.$departureTime_CR.'"';
	
	updatelisting('quotationCruiseMaster',$nameValue,'id="'.$cruiseQuoteId.'"');
	
	?>
		<script>
			parent.closeinbound();
			parent.loadquotationmainfile();
			  parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
		</script>
		<?php
	}

// restaurant edit start 
if($_REQUEST['action'] == 'editQuotationRestaurantRate' && $_REQUEST['restaurantQuoteId'] != ''){

	$qRestQuery2='';
	$qRestQuery2=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,'id="'.$_REQUEST['restaurantQuoteId'].'"');
	$qRestData2=mysqli_fetch_array($qRestQuery2);

	$cityName = getCityNameByDayId($qRestData2['dayId']);
	 
    // entrance data
	$resrestmeal = GetPageRecord('*','restaurantsMealPlanMaster','id="'.$qRestData2['mealType'].'"');
	$resmealres = mysqli_fetch_assoc($resrestmeal); 
	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$qRestData2['mealPlanName']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="100"  align="left" >
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="tr_supplierId2" name="tr_supplierId2" class="gridfield validate" displayname="Suppliers"  >  
									<?php 
									$where=' deletestatus=0 and name!="" and ( mealType=6 or mealType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qRestData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div>
						</td> 
						 
						<td align="left"  ><div class="griddiv">
							<label>
							<div class="gridlable">Meal&nbsp;Type</div>
							<select id="tr_mealPlanType2" name="tr_mealPlanType2" class="gridfield validate" displayname="Meal Type" autocomplete="off" >
 								<option value="">Select</option>
								<?php 
								$rs='';    
								$rs=GetPageRecord('*',_PACKAGE_BUILDER_RESTAURANT_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
								while($mealTypeD=mysqli_fetch_array($rs)){   
								?>
								<option value="<?php echo $mealTypeD['id']; ?>"  <?php if($mealTypeD['id']==$qRestData2['mealType']){ ?>selected="selected"<?php } ?>><?php echo $mealTypeD['name']; ?></option>
								<?php } ?>
							</select>
							</label>
							</div>
						</td>
						
						<td align="left"  ><div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="tr_gstTax2" name="tr_gstTax2" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Restaurant"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($qRestData2['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>

					</tr>
					<tr>  
						<td align="left" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; " width="100%;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_adultCost2" type="text" class="gridfield"  id="tr_adultCost2" value="<?php echo $qRestData2['adultCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_adultPax2" type="text" class="gridfield"  id="tr_adultPax2" value="<?php echo $qRestData2['adultPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td align="left" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" width="100%;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_childCost2" type="text" class="gridfield"  id="tr_childCost2" value="<?php echo $qRestData2['childCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_childPax2" type="text" class="gridfield"  id="tr_childPax2" value="<?php echo $qRestData2['childPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td align="left" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff;" width="100%;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="tr_infantCost2" type="text" class="gridfield"  id="tr_infantCost2" value="<?php echo $qRestData2['infantCost'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="tr_infantPax2" type="text" class="gridfield"  id="tr_infantPax2" value="<?php echo $qRestData2['infantPax'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="100" align="left">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="tr_currencyId2" name="tr_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'tr_currencyValue2');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qRestData2['currencyId']>0)?$qRestData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qRestData2['currencyValue']>0)?$qRestData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="100"  align="left">
							<div class="griddiv">
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="tr_currencyValue2" displayname="ROI Value"  id="tr_currencyValue2" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
							</label>
							</div>
						</td>
						<td width="100" >
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="tr_remark2" type="text" class="gridfield" id="tr_remark2" value="<?php echo $qRestData2['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
 							<input name="restaurantQuoteId2" type="hidden" id="restaurantQuoteId2" value="<?php echo $qRestData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationRestaurantRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
} 
if($_REQUEST['action'] == 'saveQuotationRestaurantRate' && $_REQUEST['restaurantQuoteId2'] != ''){  

	$namevalue ='supplierId="'.$_REQUEST['tr_supplierId2'].'",mealType="'.$_REQUEST['tr_mealPlanType2'].'",gstTax="'.$_REQUEST['tr_gstTax2'].'",currencyId="'.$_REQUEST['tr_currencyId2'].'",currencyValue="'.$_REQUEST['tr_currencyValue2'].'",adultCost="'.$_REQUEST['tr_adultCost2'].'",adultPax="'.$_REQUEST['tr_adultPax2'].'",childCost="'.$_REQUEST['tr_childCost2'].'",infantCost="'.$_REQUEST['tr_infantCost2'].'",childPax="'.$_REQUEST['tr_childPax2'].'",infantPax="'.$_REQUEST['tr_infantPax2'].'",remark="'.$_REQUEST['tr_remark2'].'"';  
	$updatelist = updatelisting(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue,'id="'.trim($_REQUEST['restaurantQuoteId2']).'"'); ?>

	<script type="text/javascript">
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Restaurant Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} 
// restaurant edit end

// extra edit start 
if($_REQUEST['action'] == 'editQuotationAdditionalRate' && $_REQUEST['additionalQuoteId'] != ''){
	
	$qAddsQuery2='';
	$qAddsQuery2=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,'id="'.$_REQUEST['additionalQuoteId'].'"');
	$qAddsData2=mysqli_fetch_array($qAddsQuery2);

	$quotationId = $qAddsData2['quotationId']; 

	// print_r($qAddsData2);
	// echo '<pre>';
	// echo exit;

	$groupCost = $qAddsData2['groupCost']; 
	$adultCost = $qAddsData2['adultCost']; 
	$childCost = $qAddsData2['childCost']; 
	$infantCost = $qAddsData2['infantCost']; 

	if($qAddsData2['costType'] == 2){
		$rs1='';
		$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
		$quotationData2 = mysqli_fetch_array($rs1);

		$adultPax2 = $quotationData2['adult'];
		$childPax2 = $quotationData2['child'];
		$infantPax2 = $quotationData2['infant'];
	}else{
		$adultPax2 = $qAddsData2['adultPax'];
		$childPax2 = $qAddsData2['childPax'];
		$infantPax2 = $qAddsData2['infantPax'];
	}

	$cityName = getCityNameByDayId($qAddsData2['dayId']);
 	?>
	<div class="contentdiv ">
		<h1 class="contentheader" ><?php echo $cityName.' | '.$qAddsData2['name']; ?> Edit Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i></h1>
		<div class="contentbody "> 
			<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="editServiceForm" target="actoinfrm" id="editServiceForm"> 
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" > 
					<tbody> 
					<tr>
						<td width="300" colspan="6" >
							<div class="griddiv">
								<label>
									<div class="gridlable">Additional Service Name</div>
									<input name="ad_additionalName2" type="text" class="gridfield validate" id="ad_additionalName2" value="<?php echo clean($qAddsData2['name']) ; ?>">
								</label>
							</div>  
						</td>
					</tr>
					<tr>
						<td width="100" colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable">Supplier&nbsp;Name<span class="redmind"></span></div>
								<select id="ad_supplierId2" name="ad_supplierId2" class="gridfield validate" displayname="Suppliers"  >  
									<?php
									$where=' deletestatus=0 and name!="" and ( otherType=13 or otherType=1 ) and status=1 order by name asc';  
									$rs=GetPageRecord('id,name',_SUPPLIERS_MASTER_,$where);   
									while($editSupplierData=mysqli_fetch_array($rs)){   ?> 
										<option value="<?php echo strip($editSupplierData['id']); ?>"  <?php if($editSupplierData['id']==$qAddsData2['supplierId']){ ?>selected="selected"<?php } ?>><?php echo strip($editSupplierData['name']); ?></option> 
									<?php } ?>
								</select> 
								</label>
							</div> 
						</td>
						<td width="100" align="left" colspan="2">
							<div class="griddiv">
								<label>  
								<div class="gridlable">Currency<span class="redmind"></span></div>
								<select id="ad_currencyId2" name="ad_currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" onchange="getROE(this.value,'ad_currencyValue2');"    >
									<option value="">Select</option>
									<?php 
									$currencyId = ($qAddsData2['currencyId']>0)?$qAddsData2['currencyId']:$baseCurrencyId;
									$currencyValue = ($qAddsData2['currencyValue']>0)?$qAddsData2['currencyValue']:getCurrencyVal($currencyId);
									$select=''; 
									$where=''; 
									$rs='';  
									$select='*';    
									$where=' deletestatus=0 and status=1 order by name asc';  
									$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
									while($resListing=mysqli_fetch_array($rs)){   
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									</select>
								</label>
							</div>			
						</td> 
						<td width="100"  align="left" colspan="2">
							<div class="griddiv">
							<label> 
								<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
								<input class="gridfield validate" type="text" name="ad_currencyValue2" displayname="ROI Value"  id="ad_currencyValue2" value="<?php echo trim($currencyValue); ?>" >
							</label>
							</div>
						</td>  
					</tr>
					<tr>
						 <td width="100"  align="left" colspan="2">
							<div class="griddiv" >
								<label>
									<div class="gridlable">Markup&nbsp;Apply</div>
									<select id="ad_isMarkupApply2" type="text" class="gridfield" name="ad_isMarkupApply2" autocomplete="off" style="width: 100%;" onchange="markupApplyStatus3(this.value)">
										<option value="0" <?php if($qAddsData2['isMarkupApply']=='0'){ ?>selected="selected"<?php } ?>>Yes</option>
										<option value="1" <?php if($qAddsData2['isMarkupApply']=='1'){ ?>selected="selected"<?php } ?>>No</option>
									</select>
								</label> 
							</div>
						</td> 
						<td width="100"  align="left" colspan="2">
							<div class="griddiv">
							<label>
								<div class="gridlable">Cost&nbsp;Type</div>
								<select id="ad_costType2" type="text" class="gridfield" name="ad_costType2" onchange="selectcost3(this.value);">
									<option value="1" <?php if($qAddsData2['costType']==1){ ?> selected="selected" <?php } ?>>Per Person</option>
									<option value="2" <?php if($qAddsData2['costType']==2){ ?> selected="selected" <?php } ?> >Group Cost</option>
								</select>
							</label>
							</div>
							<script type="text/javascript">
								function selectcost3(costType) {
									if (costType == 1 || costType == 0) {
										$('.pp').show();
										$('.tot').hide(); 
									}
									if (costType == 2) {
										$('.pp').hide();
										$('.tot').show(); 
									}
								}
								selectcost3(<?php echo ($qAddsData2['costType']>0) ? $qAddsData2['costType'] : 1; ?>);

								function markupApplyStatus3(selectedValue) {
								    if (selectedValue == 1) {
								        console.log("The selected value is "+selectedValue+". Passing value 2 to the function.");
								        selectcost3(2);
								        $('#ad_costType').val(2)
								    } else {
								        console.log("The selected value is "+selectedValue+". Passing the original value to the function.");
								    }
								}
							</script>
						</td>
						<td width="100"  align="left" colspan="2">
							<div class="griddiv"><label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="ad_gstTax2" name="ad_gstTax2" class="gridfield" displayname="Tax Slab" ><?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Other"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($additionalData['gstTax'] == $gstSlabData['id']){?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								} ?>
							</select>
							</label>
							</div>
						</td>
					</tr>
					<tr>
						<td align="left" colspan="6" class="tot">
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; " bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td align="center">Cost Type</td></tr>  
										<tr><td align="center">Group Cost</td></tr> 
										<tr>
											<td>
												<input name="ad_groupCost2" type="text" class="gridfield"  id="ad_groupCost2" value="<?php echo ($groupCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td> 
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td align="left" class="pp" colspan="2" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; width: 170px;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Adult Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ad_adultCost2" type="text" class="gridfield"  id="ad_adultCost2" value="<?php echo ($adultCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ad_adultPax2" type="text" class="gridfield"  id="ad_adultPax2" value="<?php echo $adultPax2 ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td>
						<td align="left" class="pp" colspan="2" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; width: 170px;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Child Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ad_childCost2" type="text" class="gridfield"  id="ad_childCost2" value="<?php echo ($childCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ad_childPax2" type="text" class="gridfield"  id="ad_childPax2" value="<?php echo $childPax2 ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
						<td align="left" class="pp" colspan="2" >
							<div class="griddiv">
								<label>  
									<table border="0" style="border-color: #d4ebff; width: 170px;" bgColor="#d4ebff" cellpadding="0" cellspacing="0"  >
										<tr><td colspan="2" align="center">Infant Cost</td></tr>  
										<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
										<tr>
											<td>
												<input name="ad_infantCost2" type="text" class="gridfield"  id="ad_infantCost2" value="<?php echo ($infantCost) ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
											<td>
												<input name="ad_infantPax2" type="text" class="gridfield"  id="ad_infantPax2" value="<?php echo $infantPax2 ?>" maxlength="6" onkeyup="numericFilter(this);" />
											</td>
										</tr>
									</table> 
								</label>
							</div>
						</td> 
					</tr> 					
					<tr> 
						<td width="100" align="left" colspan="6">
							<div class="griddiv">
								<label>
									<div class="gridlable">REMARKS</div>
									<input name="ad_remark2" type="text" class="gridfield" id="ad_remark2" value="<?php echo $qAddsData2['remark'] ?>" style="width: 99%;">
								</label>
							</div> 
 							<input name="additionalQuoteId2" type="hidden" id="additionalQuoteId2" value="<?php echo $qAddsData2['id']; ?>" />
							<input name="action" type="hidden" id="action2" value="saveQuotationAdditionalRate" /> 
						</td>
					</tr> 
					</tbody>
				</table>  
			</form>
			</div> 
		</div>
		<div class="contentfooter" id="buttonsbox">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('editServiceForm','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>
				</tr>
			</table> 
		</div>
	</div> 
	<?php
}
if($_REQUEST['action'] == 'saveQuotationAdditionalRate' && $_REQUEST['additionalQuoteId2'] != ''){   
	

	if($_REQUEST['ad_costType2'] == 1){
		$groupCost2 = 0;
		$adultCost2 = $_REQUEST['ad_adultCost2']; 
		$childCost2 = $_REQUEST['ad_childCost2']; 
		$infantCost2 = $_REQUEST['ad_infantCost2']; 
	}else{
		$groupCost2 = $_REQUEST['ad_groupCost2']; 
		$adultCost2 = $childCost2 = $infantCost2 = $_REQUEST['ad_adultPax2'] = $_REQUEST['ad_childPax2'] = $_REQUEST['ad_infantPax2'] = 0;
	}
	$namevalue ='name="'.$_REQUEST['ad_additionalName2'].'",supplierId="'.$_REQUEST['ad_supplierId2'].'",costType="'.$_REQUEST['ad_costType2'].'",isMarkupApply="'.$_REQUEST['ad_isMarkupApply2'].'",gstTax="'.$_REQUEST['ad_gstTax2'].'",groupCost="'.$groupCost2.'",currencyId="'.$_REQUEST['ad_currencyId2'].'",currencyValue="'.$_REQUEST['ad_currencyValue2'].'",adultCost="'.$adultCost2.'",adultPax="'.$_REQUEST['ad_adultPax2'].'",childCost="'.$childCost2.'",childPax="'.$_REQUEST['ad_childPax2'].'",infantCost="'.$infantCost2.'",infantPax="'.$_REQUEST['ad_infantPax2'].'",remark="'.$_REQUEST['ad_remark2'].'"';
	$updatelist = updatelisting(_QUOTATION_EXTRA_MASTER_,$namevalue,'id="'.trim($_REQUEST['additionalQuoteId2']).'"'); ?>
	<script type="text/javascript">
		parent.$('#pageloading').hide(); 
		parent.$('#pageloader').hide(); 
		parent.warningalert('Additional Rate Updated!');
		parent.closeinbound();
		parent.loadquotationmainfile();
	</script>
	<?php
} 
// extra edit end

/////////////////////
if(trim($_REQUEST['action'])=='saveQuotationDetails' && trim($_REQUEST['quotationId'])!='' && trim($_REQUEST['dayroe'])!=''){
 
	$currencyId = $_REQUEST['curren'];
	$dayroe = $_REQUEST['dayroe'];
	if($_REQUEST['asOnDate'] == '01-01-1970'){
		$asOnDate = date('Y-m-d');
	}else{
		$asOnDate = date('Y-m-d',strtotime($_REQUEST['asOnDate']));
	}

	$isInc_exc = $_REQUEST['isInc_exc'];
	// $isUni_Mark = $_REQUEST['isUni_Mark'];
	$markup = $_REQUEST['markup'];
	$markupType = $_REQUEST['markupType'];
	$languageType = $_REQUEST['languageType'];
	$otherLocation = $_REQUEST['otherLocation'];
	$otherLocationCost = $_REQUEST['otherLocationCost'];
	$isOtherLocation = $_REQUEST['isOtherLocation'];
	$isSupp_TRR = $_REQUEST['isSupp_TRR'];
	$flightCostType = $_REQUEST['flightcosttype'];
	$visacosttype = $_REQUEST['visacosttype'];
	$passportcosttype = $_REQUEST['passportcosttype'];
	$insurancecosttype = $_REQUEST['insurancecosttype'];
	$viewQuotation = $_REQUEST['viewQuotation'];
	$costType = $_REQUEST['costType'];
	$discountType = $_REQUEST['discountType'];
	$serviceTaxDivident = $_REQUEST['serviceTaxDivident'];
	$priceSenValue = $_REQUEST['priceSenValue'];
	$discount = $_REQUEST['discount'];
	$gitincexNameId = $_REQUEST['gitincexNameId'];
	$fitincexNameId = $_REQUEST['fitincexNameId'];
	$overviewNameId = $_REQUEST['overviewNameId'];

	if($gitincexNameId>0 && $gitincexNameId!='undefined'){
		$fitGitId=$gitincexNameId;
	}elseif($fitincexNameId>0 && $fitincexNameId!='undefined'){
		$fitGitId=$fitincexNameId;
	}

	if($overviewNameId>0 && $overviewNameId!='undefined'){
		$overviewId=$overviewNameId;
	}

	if($_REQUEST['isOtherLocation']==0){
		$otherLocation = 0;
		$otherLocationCost = 0;
	}
	// $itineraryintrText
	// $itinerarysummText

	// serviceupgradationText,optionaltourText

	$overviewText=$highlightsText=$inclusion=$exclusion=$tncText=$specialText=$paymentpolicy=$remarks=$itineraryintrText=$itinerarysummText=$serviceupgradationText=$optionaltourText='';
	if($isInc_exc == 1){
		$overviewText = mysqli_real_escape_string(db(),urldecode($_REQUEST['overviewText']));
		$itineraryintrText = mysqli_real_escape_string(db(),urldecode($_REQUEST['itineraryintrText']));
		$itineraryintrText = mysqli_real_escape_string(db(),urldecode($_REQUEST['itineraryintrText']));
		
		$itinerarysummText = mysqli_real_escape_string(db(),urldecode($_REQUEST['itinerarysummText']));
		$highlightsText = mysqli_real_escape_string(db(),urldecode($_REQUEST['highlightsText']));
		$inclusion = mysqli_real_escape_string(db(),urldecode($_REQUEST['inclusionText']));
		$serviceupgradationText = mysqli_real_escape_string(db(),urldecode($_REQUEST['serviceupgradationText']));
		$optionaltourText = mysqli_real_escape_string(db(),urldecode($_REQUEST['optionaltourText']));
		$exclusion = mysqli_real_escape_string(db(),urldecode($_REQUEST['exclusionText']));
		$tncText = mysqli_real_escape_string(db(),urldecode($_REQUEST['termsconditionText']));
		$specialText = mysqli_real_escape_string(db(),urldecode($_REQUEST['cancelationText']));
		$paymentpolicy = mysqli_real_escape_string(db(),urldecode($_REQUEST['paymentpolicyText']));
		$remarks = mysqli_real_escape_string(db(),urldecode($_REQUEST['remarksText']));
	} 

	// isUni_Mark="'.$isUni_Mark.'",isSer_Mark="'.$isSer_Mark.'", 
	$quoteQuery = 'currencyId="'.$currencyId.'",isTransport="'.$_REQUEST['isTransport'].'",serviceTax="'.$_REQUEST['serviceTax'].'",gstType="'.$_REQUEST['gstType'].'",discount="'.$discount.'",tcs="'.$_REQUEST['tcsTax'].'",dayroe="'.$dayroe.'",asOnDate="'.$asOnDate.'",flightCostType="'.$flightCostType.'",overviewText="'.$overviewText.'",itineraryintrText="'.$itineraryintrText.'",itinerarysummText="'.$itinerarysummText.'",highlightsText="'.$highlightsText.'",inclusion="'.$inclusion.'",exclusion="'.$exclusion.'",serviceupgradationText="'.$serviceupgradationText.'",optionaltourText="'.$optionaltourText.'",tncText="'.$tncText.'",specialText="'.$specialText.'",paymentpolicy="'.$paymentpolicy.'",remarks="'.$remarks.'",isInc_exc="'.$isInc_exc.'",isOtherLocation="'.$isOtherLocation.'",languageId="'.$languageType.'",otherLocation="'.$otherLocation.'",otherLocationCost="'.$otherLocationCost.'",isSupp_TRR="'.$isSupp_TRR.'",viewQuotation="'.$viewQuotation.'",saveQuotaiton="1",costType="'.$costType.'",discountType="'.$discountType.'",serviceTaxDivident="'.$serviceTaxDivident.'",priceSenValue="'.$priceSenValue.'",discount="'.$discount.'",markup="'.$markup.'",markupType="'.$markupType.'",visaCostType="'.$visacosttype.'",passportCostType="'.$passportcosttype.'",insuranceCostType="'.$insurancecosttype.'",fitGitId="'.$fitGitId.'",overviewId="'.$overviewId.'"';
	$wheretnc = 'id="'.decode($_REQUEST['quotationId']).'"';
	// die("testing");
	$edit = updatelisting(_QUOTATION_MASTER_,$quoteQuery,$wheretnc);
}

if(trim($_REQUEST['action'])=='addServiceTypeMarkup' && trim($_REQUEST['quotationId'])!='' ){

	$hotel = $_REQUEST['serMarkup_hotel'];
	$hotelMarkupType = $_REQUEST['hotelMarkupType'];
	$package = $_REQUEST['serMarkup_package'];
	$packageMarkupType = $_REQUEST['packageMarkupType'];
	$guide = $_REQUEST['serMarkup_guide'];
	$guideMarkupType = $_REQUEST['guideMarkupType'];
	$activity = $_REQUEST['serMarkup_activity'];
	$activityMarkupType = $_REQUEST['activityMarkupType'];
	$entrance = $_REQUEST['serMarkup_entrance'];
	$entranceMarkupType = $_REQUEST['entranceMarkupType'];
	$transfer = $_REQUEST['serMarkup_transfer'];
	$transferMarkupType = $_REQUEST['transferMarkupType'];
	$ferry = $_REQUEST['serMarkup_ferry'];
	$ferryMarkupType = $_REQUEST['ferryMarkupType'];
	$cruise = $_REQUEST['serMarkup_cruise'];
	$cruiseMarkupType = $_REQUEST['cruiseMarkupType'];
	$train = $_REQUEST['serMarkup_train'];
	$trainMarkupType = $_REQUEST['trainMarkupType'];
	$flight = $_REQUEST['serMarkup_flight'];
	$flightMarkupType = $_REQUEST['flightMarkupType'];
	$restaurant = $_REQUEST['serMarkup_restaurant'];
	$restaurantMarkupType = $_REQUEST['restaurantMarkupType'];
	$other = $_REQUEST['serMarkup_other'];
	$otherMarkupType = $_REQUEST['otherMarkupType'];
	$visa = $_REQUEST['serMarkup_visa'];
	$visaMarkupType = $_REQUEST['visaMarkupType'];
	$passport = $_REQUEST['serMarkup_passport'];
	$passportMarkupType = $_REQUEST['passportMarkupType'];
	$insurance = $_REQUEST['serMarkup_insurance'];
	$insuranceMarkupType = $_REQUEST['insuranceMarkupType'];

	$namevalue11 =' markupType="'.$_REQUEST['markupType'].'",markup="'.$_REQUEST['markup'].'",isUni_Mark="'.$_REQUEST['isUni_Mark'].'",isSer_Mark="'.$_REQUEST['isSer_Mark'].'"';
	$where11='id="'.decode($_REQUEST['quotationId']).'"';
	$update11 = updatelisting(_QUOTATION_MASTER_,$namevalue11,$where11);

	$c12=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.decode($_REQUEST['quotationId']).'"');
	if( mysqli_num_rows($c12) > 0){
	    $namevalue ='package="'.$package.'",hotel="'.$hotel.'",guide="'.$guide.'",activity="'.$activity.'",entrance="'.$entrance.'",transfer="'.$transfer.'",ferry="'.$ferry.'",cruise="'.$cruise.'",train="'.$train.'",flight="'.$flight.'",restaurant="'.$restaurant.'",other="'.$other.'",visa="'.$visa.'",passport="'.$passport.'",insurance="'.$insurance.'",packageMarkupType="'.$packageMarkupType.'",hotelMarkupType="'.$hotelMarkupType.'",guideMarkupType="'.$guideMarkupType.'",activityMarkupType="'.$activityMarkupType.'",entranceMarkupType="'.$entranceMarkupType.'",transferMarkupType="'.$transferMarkupType.'",ferryMarkupType="'.$ferryMarkupType.'",trainMarkupType="'.$trainMarkupType.'",flightMarkupType="'.$flightMarkupType.'",restaurantMarkupType="'.$restaurantMarkupType.'",otherMarkupType="'.$otherMarkupType.'",visaMarkupType="'.$visaMarkupType.'",passportMarkupType="'.$passportMarkupType.'",insuranceMarkupType="'.$insuranceMarkupType.'",cruiseMarkupType="'.$cruiseMarkupType.'"';
		
		$where='quotationId="'.decode($_REQUEST['quotationId']).'"';
		$update = updatelisting('quotationServiceMarkup',$namevalue,$where);
	}
	?>
	<script>
		loadquotationmainfile();
	</script>
	<?php
}

if(trim($_REQUEST['action'])=='addAdditionalExperience' && trim($_REQUEST['quotationId'])!='' && trim($_REQUEST['additionalId'])!=''){

	$quotationId=clean(decode($_REQUEST['quotationId']));
	$update = updatelisting(_QUOTATION_MASTER_,' isAddExp="'.$_REQUEST['isAddExp'].'"','id="'.$quotationId.'"');

	$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationData['id'].'" and additionalId="'.$_REQUEST['additionalId'].'" and adultCost="'.$_REQUEST['adultCost'].'" ');
	if( mysqli_num_rows($c12) > 0){
		$namevalue ='additionalId="'.$_REQUEST['additionalId'].'",adultCost="'.$_REQUEST['adultCost'].'",childCost="'.$_REQUEST['childCost'].'",infantCost="'.$_REQUEST['infantCost'].'",quotationId="'.$quotationId.'"';
		$where = 'quotationId="'.$quotationData['id'].'" and additionalId="'.$_REQUEST['additionalId'].'" ';
		$update = updatelisting('quotationAdditionalMaster',$namevalue,$where); //Corrrection made here!
	}else{
		$namevalue ='additionalId="'.$_REQUEST['additionalId'].'",adultCost="'.$_REQUEST['adultCost'].'",childCost="'.$_REQUEST['childCost'].'",infantCost="'.$_REQUEST['infantCost'].'",quotationId="'.$quotationId.'"';
		$add=addlistinggetlastid('quotationAdditionalMaster',$namevalue);
	}
	?>
	<script>
		loadAddtionalDatafun();
	</script>
	<?php
}

if(trim($_REQUEST['action'])=='upload_quotBannerAction' && trim($_REQUEST['quotationId'])!='' && ($_FILES["file"]["name"])!=''){
	if($_FILES['file']['name']!=''){
		$file_name=$_FILES['file']['name'];
		$file_name=time().'_'.$file_name;
		copy($_FILES['file']['tmp_name'],"dirfiles/".$file_name);
	}else{
		$file_name = "";
	}

	$add = updatelisting(_QUOTATION_MASTER_,'image="'.$file_name.'"','id="'.$_REQUEST['quotationId'].'"');
	if($add == 'yes'){
         echo json_encode(array("color" => 'blue',"msgs" => "Uploaded"));
	}else{
         echo json_encode(array("color" => 'red',"msgs" => "Error"));
	}
	?>
	<script type="text/javascript">
		$('#showaddmarkup').show();
	</script>
	<?php
}

if(trim($_REQUEST['action'])=='additinerary_plan'  && trim($_REQUEST['dayId'])!=''){

	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' id="'.trim($_REQUEST['dayId']).'"');
	$QueryDaysData=mysqli_fetch_array($QueryDaysQuery);

	$dayTitle=preg_replace('/\\\\/','',urldecode($QueryDaysData['title']));
	$daydrivingDistance=preg_replace('/\\\\/','',urldecode($QueryDaysData['drivingDistance']));
	$dayDescription=preg_replace('/\\\\/','',urldecode($QueryDaysData['description']));

	?>
	<div style="border: 1px solid #3b4fb5;margin-top: 10px;"> 
	<script type="text/javascript">
	textEditor1();
	function textEditor1(){
		tinymce.remove(".textEditor1");
		tinymce.init({
			selector: ".textEditor1",
			themes: "modern",
			plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
	}
	
	</script>
	<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#3b4fb5">
	<tr>
	<td width="66%"  style="color:#fff;position: relative;"><?php echo getDestination($QueryDaysData['cityId']);?> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; cursor:pointer; " onclick="loadoverviewpage('<?php echo $QueryDaysData['quotationId']; ?>');"></i></td>
	</tr>
	</table>
	</div>
 
	<div style="padding:10px;position: relative;border: 1px solid #3b4fb5;padding-top: 0;display:none;" id="listBox2" >
	<i class="fa fa-plus" onclick="showBox(1);" style="position:absolute;top: -33px;right: 43px;color: white;font-size: 15px;cursor:pointer;padding: 5px;border: 1px solid;"><span style="font-size: 20px;font-weight: bold;"> Add New</span></i>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable addeditpagebox">
	<thead>
    <tr>
    <th width="4%" align="center" valign="middle" class="header" style="padding-bottom: 10px;">#</th>
    <!--<th align="left" class="header" style="padding-bottom: 10px;">image</th>-->
    <th align="left" class="header" style="padding-bottom: 10px;">Title/Description</th>
    <th align="left" class="header" style="padding-bottom: 10px;">Language</th>
	<th align="left" class="header" style="padding-bottom: 10px;">Action</th>
    </tr>
    </thead>	
	<tbody>
	<?php
	$no=1;
	$rssa1=GetPageRecord('*','iti_subjectmaster','1 and ( fromDestinationId="'.$QueryDaysData['cityId'].'" or toDestinationId="'.$QueryDaysData['cityId'].'" ) and deletestatus=0 and status=1 order by dateAdded desc');
	if(mysqli_num_rows($rssa1) > 0){
		while($resultlists1=mysqli_fetch_array($rssa1)){
			$name = $resultlists1['otherTitle'];
			$description = $resultlists1['description'];
			$drivingDistance = $resultlists1['drivingDistance'];
			?>
			<tr>
			<td align="center" valign="middle"><?php echo $no; ?></td>
			<td width="85%" align="left">
				<textarea  rows="5" id="selectTitle<?php echo $resultlists1['id']; ?>" style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;display:none;"  placeholder="Remark"><?php echo stripslashes(($name)); ?>
				</textarea>
				<textarea  rows="5" id="drivingDistance<?php echo $resultlists1['id']; ?>" style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;display:none;"  placeholder="Remark"><?php echo stripslashes(($drivingDistance)); ?>
				</textarea>
				<textarea rows="5" id="selectDescription<?php echo $resultlists1['id']; ?>" style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;display:none;"  placeholder="Remark"><?php echo stripslashes($description); ?></textarea>


				<div id="Title<?php echo $resultlists1['id']; ?>"><strong><?php echo strip_tags($name); ?></strong></div>
				<div style="display:none;" id="drivingDistance<?php echo $resultlists1['id']; ?>"><strong><?php echo strip_tags($drivingDistance); ?></strong></div>
				<div id="lanDesc<?php echo $resultlists1['id'];?>"><?php echo substr(strip_tags($description),0,400); ?></div>

				<textarea id="hidddenTitle<?php echo $resultlists1['id']; ?>" style="display: none;visibility: hidden;"><?php echo stripslashes($name); ?></textarea>
				<textarea id="hidddenDistance<?php echo $resultlists1['id']; ?>" style="display: none;visibility: hidden;"><?php echo stripslashes($drivingDistance); ?></textarea>
				<textarea id="hidddenDesc<?php echo $resultlists1['id']; ?>" style="display: none;visibility: hidden;"><?php echo stripslashes($description); ?></textarea>
			</td>
			<td align="left">
			<select id="languageType<?php echo $resultlists1['id']; ?>" name="languageType" class="gridfield" displayname="Language Type" autocomplete="off" onchange="changeLang<?php echo $resultlists1['id']; ?>(this.value);"  style="padding: 8px; border: 1px #ccc solid; width: 160px;"  >
			 	<option value="0">Default</option>
				<?php 
				 $rs=GetPageRecord('id,name','tbl_languagemaster','1 and status=1 and deletestatus=0');
				$totalrow = mysqli_num_rows($rs);
				while($languageDetails=mysqli_fetch_array($rs)){
				?>
				<option value="<?php echo $languageDetails['id']; ?>"><?php echo trim($languageDetails['name']); ?></option>
				<?php } ?>
			</select>	
			</td>
			<td width="10%" align="left">
			<input  type="button" class="whitembutton submitBtn" id="selectTitle<?php echo $resultlists1['id']; ?>" value="&nbsp;Select&nbsp;" onclick="selectTitle(<?php echo $resultlists1['id']; ?>);" style="background-color: #3b4fb5 !important;margin: 0;color: white;border-radius:2px;">
			

			<?php
			$rs=GetPageRecord('id,title,description,languageId','subjectLanguageMaster','1 and status=1 and subjectId="'.$resultlists1['id'].'"');
			while($languageTitle=mysqli_fetch_array($rs)){

				$rts=GetPageRecord('*','tbl_languagemaster','1 and id="'.$languageTitle['languageId'].'"');
				$languageId=mysqli_fetch_array($rts);
				?>
				<textarea  id="language<?php echo $resultlists1['id']; ?>Title<?php echo $languageId['id'] ?>" style="display: none;visibility: hidden;"><?php echo trim(stripslashes($languageTitle['title'])) ?></textarea>
				<textarea  id="language<?php echo $resultlists1['id']; ?>Title<?php echo $languageId['id'] ?>" style="display: none;visibility: hidden;"><?php echo trim(stripslashes($languageTitle['title'])) ?></textarea>
				<textarea  id="language<?php echo $resultlists1['id']; ?>Desc<?php echo $languageId['id'] ?>" style="display: none;visibility: hidden;"><?php echo stripslashes($languageTitle['description']) ?></textarea>
				<?php
			}	
			?>
			<script>
				function changeLang<?php echo $resultlists1['id']; ?>(id){
					if(id == 0){ 
						var newtitle = $("#hidddenTitle<?php echo $resultlists1['id']; ?>").val();
						var newtitle = $("#hidddenDistance<?php echo $resultlists1['id']; ?>").val();
						var newdesc = $("#hidddenDesc<?php echo $resultlists1['id']; ?>").val();
					}else{
						var newwtitle = $("#language<?php echo  $resultlists1['id']; ?>Title"+id).val();
						if(newwtitle == "" || newwtitle == undefined){
							var newtitle = "";    
						}else{
							var newtitle = $("#language<?php echo  $resultlists1['id']; ?>Title"+id).val();    
						} 

						var newwdesc  = $("#language<?php echo  $resultlists1['id']; ?>Desc"+id).val();
						if(newwdesc == "" || newwdesc == undefined){
							var newdesc = "";    
						}else{
							var newdesc = $("#language<?php echo  $resultlists1['id']; ?>Desc"+id).val();    
						}
					}
					$("#Title<?php echo $resultlists1['id']; ?>").html('<strong>'+newtitle+'</strong>');
					$("#selectTitle<?php echo $resultlists1['id']; ?>").val(newtitle);

					$("#lanDesc<?php echo $resultlists1['id']; ?>").html('<p>'+newdesc.substring(0, 300)+'</p>');
					$("#selectDescription<?php echo $resultlists1['id']; ?>").val(newdesc);
				} 		
			</script>
			</td>
			</tr>
			
			
			<?php 
			$no++;  
		}
	}
	else{ ?>
		<tr>
		<td colspan="4" align="center" >No Data Found !</td>
		</tr>
		<?php
	} ?>
	</tbody>
	</table>
	</div>

	<div style="padding:10px;border: 1px solid #3b4fb5;" id="detailBox">
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
	  	<tr>
			<td width="50%"><div style="font-size:12px;">Title</div>
				<input name="daySubject" type="text" id="daySubject"  style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;"  value="<?php echo trim(stripslashes($dayTitle)); ?>" >
				<input name="drivingDistance" type="text" id="drivingDistance"  style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;display:none;"  value="<?php echo trim(stripslashes($drivingDistance)); ?>" >
			</td>
	  	</tr>
	  	<tr>
			<td>
				<div style="font-size:12px;">Description</div>
			  	<textarea name="dayDescription" class="textEditor1" rows="5" id="dayDescription" style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;box-shadow:none;"  placeholder="Remark"><?php echo trim(stripslashes($dayDescription)); ?></textarea> 
			</td>
		</tr>
		 <tr>
		<td>
		<input  type="button" class="whitembutton" value=" + Title/Description" onclick="showBox(2);">
		<!-- <input  type="button" class="whitembutton" value=" + Description" onclick="showBox(4);">  &nbsp; -->
		<input  type="button" class="whitembutton"  value="&nbsp;Close&nbsp;" onclick="loadoverviewpage('<?php echo $QueryDaysData['quotationId']; ?>');" style=" margin: 0; ">&nbsp;
		<input name="Save" type="button" class="whitembutton submitBtn" id="Save" value="&nbsp;Save&nbsp;" onclick="saveitinerarydata();" style="background-color: #3b4fb5 !important;margin: 0;color: white;">

        &nbsp;
        <span id="msgShow" style="color:green;display:none;">Successfully Added.</span>

 		 </td>
		</tr>
	</table>

	</div>
	<script>

		<?php
		//echo $QueryDaysData['title'];
		if($QueryDaysData['title']==''){ ?>
			showBox(2);
		<?php } else { ?>
			showBox(1);
		<?php } ?>

		function showBox(box){
			$('#listBox2').hide();
			if(box == 2){
			 	$('#listBox2').show();
				$('#detailBox').hide();
			}
			if(box == 1){
				$('#listBox2').hide();
				$('#detailBox').show();
			}
		}

		function selectDesc(id){
			var selectDesc = $('#selectDescription'+id).val(); 
			//$('#dayDescription').text(decodeURI(selectDesc));
			tinymce.get('dayDescription').setContent(selectDesc);
  
			$('#listBox2').hide();
			$('#detailBox').show();
		}

		function selectTitle(id){
			var selectTitle = $('#selectTitle'+id).val();
			$('#daySubject').val(decodeURI(selectTitle));
			var drivingDistance = $('#drivingDistance'+id).val();
			// alert(drivingDistance);
			$('#drivingDistance').val(decodeURI(drivingDistance));
			
			var selectDesc = $('#selectDescription'+id).val(); 
			tinymce.get('dayDescription').setContent(selectDesc);
			 
			$('#listBox2').hide();
			$('#detailBox').show();
			
		}

		function saveitinerarydata(){
			var daySubject = $('#daySubject').val();
			var drivingDistance = $('#drivingDistance').val();
			var dayDescription = tinymce.get("dayDescription").getContent();
			var savequotationitinerary = 'savequotationitinerary';
			$.ajax({
				type: "POST",
				url: 'inboundpop.php',
				data: {title: encodeURI(daySubject),drivingDistance: encodeURI(drivingDistance), description: encodeURI(dayDescription), dayid: <?php echo $QueryDaysData['id']; ?>, action: savequotationitinerary, quotationId: '<?php echo $QueryDaysData['quotationId']; ?>'},
				success: function(data){
				    $('#msgShow').show();
				    setTimeout(function(){
				        $('#msgShow').hide(); 
				    }, 1000);  
				    loadquotationmainfile();

				}
			});
		}

		function loadoverviewpage(id){
			tinymce.remove(".textEditor1"); 
	  		closeinbound();
	  		loadquotationmainfile(); 
	  	}
		</script>
	<?php

}

if(trim($_REQUEST['action'])=='savequotationitinerary'  && $_REQUEST['dayid']!=''){
	$namevalue ='title="'.addslashes($_REQUEST['title']).'",drivingDistance="'.addslashes($_REQUEST['drivingDistance']).'",description="'.addslashes($_REQUEST['description']).'"';
	$where='id="'.$_REQUEST['dayid'].'"';
	updatelisting('newQuotationDays',$namevalue,$where);
	 
} 
if(trim($_REQUEST['action'])=='selectDescription'  && $_REQUEST['dayid']!=''){
    
    $rs=GetPageRecord('*','iti_subjectmaster','id="'.$_REQUEST['itineryinfoId'].'"');
    $itineryinfoDetails=mysqli_fetch_array($rs);
    $description = $itineryinfoDetails['description'];	
    echo $description;die();
}

//select Mode
if(trim($_REQUEST['action'])=='addtransferMode' && trim($_REQUEST['dayId'])!='' ){

	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' id="'.trim($_REQUEST['dayId']).'"');
	$QueryDaysData=mysqli_fetch_array($QueryDaysQuery);
?>

	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Select Mode</span>
		<i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer;" onclick="closeinbound();"></i>
	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_transferMode" target="actoinfrm" id="add_transferMode">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<?php
				$modeSql=GetPageRecord('*','quotationModeMaster',' 1 and quotationId="'.$QueryDaysData['quotationId'].'" and dayId ="'.$_REQUEST['dayId'].'"');
				$modeData=mysqli_fetch_array($modeSql);
				?>
				<tr style="background-color:transparent !important;"> 
					<td width="30" align="left">
						<div class="griddiv labelbox">
							<input name="mode" type="radio" id="train" value="train" <?php if($modeData['name'] == 'train'){ echo "checked";} ?> >
							<label class="label" for="train">Train</label>
						</div>
					</td>
					<td width="30" align="left">
						<div class="griddiv labelbox">
							<input name="mode" type="radio" id="flight" value="flight" <?php if($modeData['name'] == 'flight'){ echo "checked";} ?> >
							<label class="label" for="flight">Flight</label>
						</div>
					</td>
			  	</tr>
				</tbody>
			</table>
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style=" float: left;width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">
					<td  align="right" colspan="3" style="    border-bottom: #ffffff 1px solid;">
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_transferMode','submitbtn','0');">
						<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
						<input type="hidden" value="<?php echo $QueryDaysData['srdate']; ?>" name="daydate"/>
						<input type="hidden" value="<?php echo $QueryDaysData['quotationId']; ?>" name="quotationId"/>
						<input type="hidden" value="<?php echo $QueryDaysData['queryId']; ?>" name="queryId"/>
 						<input name="action" type="hidden" id="action" value="add_transferMode">
 					</td>
			  	</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
	<style>
	.labelbox{
	    border-radius: 5px;
		border: 1px solid;
		overflow: hidden;
	    border-bottom: 3px #7a96ff solid!important;
		text-align: center;
	}

	.labelbox input + .label {
		color: #000!important;
		background-color: #fff;
	}
	.labelbox input:checked + .label {
		color: #fff!important;
		background-color: #233a49;
	}
	.labelbox input{
		position: absolute;
    	visibility: hidden;
	}
	.labelbox .label {
		display: inline-block;
		max-width: 100%;
		width: 100%;
		font-size: 12px;
		height: 20px;
		padding: 7px 0 0;
	}
	</style>
	<?php
}

if(trim($_REQUEST['action'])=='add_transferMode'){

 	if(trim($_REQUEST['mode'])!=''){
		$mode=clean($_REQUEST['mode']);

		$quotationId = $_REQUEST['quotationId'];
		$queryId = $_REQUEST['queryId'];
		$dayId = $_REQUEST['dayId'];
		$dateAdded=time();
		$namevalue ='name="'.$mode.'",quotationId="'.$quotationId.'",queryId="'.$queryId.'",dayId="'.$dayId.'",dateAdded="'.$dateAdded.'"';
		$where1 = 'quotationId="'.$_REQUEST['quotationId'].'" and dayId ="'.$_REQUEST['dayId'].'"';

		$modeSql=GetPageRecord('*','quotationModeMaster',$where1);
		$modenum=mysqli_num_rows($modeSql);

		if($modenum > 0){
			$update=updatelisting('quotationModeMaster',$namevalue,$where1);
		}else{
			$add=addlistinggetlastid('quotationModeMaster',$namevalue);
		}
	}
	?>
	<script>
	parent.closeinbound();
	parent.loadquotationmainfile();
	parent.$('#pageloading').hide();
	parent.$('#pageloader').hide();
  	</script>
	<?php
}


//for addFlightTimeDetails
if($_REQUEST['action'] == 'addFlightTimeDetails' && $_REQUEST['flightQuoteId'] != ''){
	$c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$_REQUEST['flightQuoteId'].'" ');
	
	

	$c=GetPageRecord('*','quotationFlightMaster',' id="'.$_REQUEST['flightQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);
	
// 		from and to geting 
		$jfrom = getDestination($hotelQuotData['departureFrom']); 
		$jto= getDestination($hotelQuotData['arrivalTo']);

	if(mysqli_num_rows($c1) > 0){
		$entTimeData= mysqli_fetch_array($c1);
		$id = $entTimeData['id'];
		$departureDate = date('Y-m-d', strtotime($entTimeData['departureDate']));
		$departureTime = date('H:i', strtotime($entTimeData['departureTime'])); 
		$arrivalTime = date('H:i', strtotime($entTimeData['arrivalTime'])); 
		$arrivalDate = date('Y-m-d', strtotime($entTimeData['arrivalDate'])); 
		$via = $entTimeData['via'];
		$remark = $entTimeData['remark'];
	}else{
		$id = "";
		$departureDate = date('Y-m-d',strtotime($hotelQuotData['fromDate']));
		$departureTime = date('H:i'); 
		$arrivalTime = date('H:i'); 
		$arrivalDate = date('Y-m-d'); 
		$via = $entTimeData['via'];
		$remark = $entTimeData['remark']; 

	}
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Flight Timeline  </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">


                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Departure&nbsp;From</strong></label>
					<input type="text" id="departurefrom" name="departurefrom" value="<?=  $jfrom ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
					   
                       </div>
                    </td>



                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Departure&nbsp;To</strong></label>
					<input type="text" id="departureto" name="departureto" value="<?=  $jto ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
					   
                       </div>
                    </td>
                    
                    
                    
                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Via&nbsp;</strong></label>
					<input type="text" id="via" name="via" value="<?php echo $via ;?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
					   
                       </div>
                    </td>


                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Departure&nbsp;Date</strong></label>
					<input type="date" id="departureDate" name="departureDate" value="<?=  $departureDate ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
					   
                       </div>
                    </td>
                   
					

                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Departure&nbsp;Time</strong></label>
                    <input type="text" id="departuretime" name="departuretime" value="<?=  $departureTime ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;" 
					class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"/>
                    
                    </div>
                    </td>
                    

                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>ARRIVAL&nbsp;DATE</strong></label>
					<input type="date" id="Arrivaldate" name="Arrivaldate" value="<?=  $arrivalDate ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
					   
                       </div>
                    </td>
                    
					<td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>ARRIVAL&nbsp;TIME</strong></label>
 					   <input type="text" id="Arrivaltime" name="Arrivaltime" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $arrivalTime; ?>"/>
					   
                       </div>
                    </td>
                    
                    </tr>
                    <!--<tr>-->

                    <!-- <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Arrival&nbsp;Date</strong></label> 
					<input type="date" id="arrivalDate" name="arrivalDate" value="<?= $arrivalDate; ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
                       </div>
                    </td>

					<td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Arrival&nbsp;Time</strong></label> 
					   <input type="text" id="arrivalTime" name="arrivalTime" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"  value="<?php echo $arrivalTime; ?>"/>
                       </div>
                    </td> -->

					

			  	<!--</tr>-->
			  	<tr>
			  	    <table>
			  	        <tr>
			  	            <td width="90%"><div class="griddiv" style="border:none;">
						<label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Remark&nbsp;</strong></label> 
				 <input type="text" id="remark" name="remark" value="<?php echo $remark;?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield" />
                       </div>
                    </td>
					<td >
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_hoteltomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $id; ?>" name="flightTimeId"/>
						<input type="hidden" value="<?php echo $_REQUEST['flightId'] ?>" name="flightId"/>
						<input type="hidden" value="<?php echo $_REQUEST['dayId'] ?>" name="dayId"/>
 						<input type="hidden" value="<?php echo $_REQUEST['flightQuoteId']; ?>" name="flightQuoteId"/>
						<input name="action" type="hidden" id="action" value="add_FlightTimeline">
  					</td>

			  	        </tr>
			  	    </table>
			  	</tr>
				</tbody>
			</table>
			<script type="text/javascript" src="js/jquery.timepicker.js"></script>  
			<script type="text/javascript"> 
				$(document).ready(function(){
					$('.timepicker2').timepicker();	
				});  
			</script>
			</form>
		</div>
	</div>
	<?php
}

// train time line
if($_REQUEST['action'] == 'addTrainTimeDetails' && $_REQUEST['trainQuoteId'] != ''){
	$c1=GetPageRecord('*','trainTimeLineMaster',' trainQuoteId="'.$_REQUEST['trainQuoteId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');

	$c=GetPageRecord('*','quotationTrainsMaster',' id="'.$_REQUEST['trainQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);

	if(mysqli_num_rows($c1) > 0){
		$entTimeData= mysqli_fetch_array($c1);
		$id = $entTimeData['id'];
		$departureDate = date('Y-m-d', strtotime($entTimeData['departureDate']));
		$departureTime = date('H:i', strtotime($entTimeData['departureTime'])); 
		$arrivalTime = date('H:i', strtotime($entTimeData['arrivalTime'])); 
		$arrivalDate = date('Y-m-d', strtotime($entTimeData['arrivalDate'])); 
		$remark = $entTimeData['remark']; 
	}else{
		$id = "";
		$departureDate = date('Y-m-d',strtotime($hotelQuotData['fromDate']));
		$departureTime = date('H:i'); 
		$arrivalTime = date('H:i'); 
		$arrivalDate = date('Y-m-d'); 
		$remark = $entTimeData['remark']; 

	}
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Train Timeline  </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">

                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Departure&nbsp;Date</strong></label>
					<input type="date" id="departureDate" name="departureDate" value="<?=  $departureDate ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
					   
                       </div>
                    </td>

					<td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Departure&nbsp;Time</strong></label>
 					   <input type="text" id="departureTime" name="departureTime" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $departureTime; ?>"/>
					   
                       </div>
                    </td>

                    <td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Arrival&nbsp;Date</strong></label> 
					<input type="date" id="arrivalDate" name="arrivalDate" value="<?= $arrivalDate; ?>" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;"/>
                       </div>
                    </td>

					<td width="15%"><div class="griddiv" style="border:none;"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Arrival&nbsp;Time</strong></label> 
					   <input type="text" id="arrivalTime" name="arrivalTime" style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"  value="<?php echo $arrivalTime; ?>"/>
                       </div>
                    </td>

					<td width="40%"><div class="griddiv" style="border:none;">
						<label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Remark&nbsp;</strong></label> 
				 <input type="text" id="remark" name="remark" <?php 
				echo $remark; ?> style="text-align:left;width:90%;padding: 3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield"/>
                       </div>
                    </td>
					<td >
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_hoteltomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $id; ?>" name="trainTimeId"/>
						<input type="hidden" value="<?php echo $_REQUEST['trainId'] ?>" name="trainId"/>
						<input type="hidden" value="<?php echo $_REQUEST['dayId'] ?>" name="dayId"/>
 						<input type="hidden" value="<?php echo $_REQUEST['trainQuoteId']; ?>" name="trainQuoteId"/>
						<input name="action" type="hidden" id="action" value="add_TrainTimeline">
  					</td>


			  	</tr>
				</tbody>
			</table>
			<script type="text/javascript" src="js/jquery.timepicker.js"></script>  
			<script type="text/javascript"> 
				$(document).ready(function(){
					$('.timepicker2').timepicker();	
				});  
			</script>
			</form>
		</div>
	</div>
	<?php
}

		if(trim($_REQUEST['action'])=='add_TrainTimeline' && trim($_REQUEST['trainQuoteId'])!=''){


			$departureTime = date('H:i:s', strtotime($_REQUEST['departureTime']));
			$arrivalTime = date('H:i:s', strtotime($_REQUEST['arrivalTime']));
			$departureDate = date('Y-m-d', strtotime($_REQUEST['departureDate']));
			$arrivalDate = date('Y-m-d', strtotime($_REQUEST['arrivalDate']));
			$remark = $_REQUEST['remark'];
			$trainId = $_REQUEST['trainId'];
			$dayId = $_REQUEST['dayId'];

		$c=GetPageRecord('*','quotationTrainsMaster',' id="'.$_REQUEST['trainQuoteId'].'"');
		$trainQuotData=mysqli_fetch_array($c);

		$c1=GetPageRecord('*','trainTimeLineMaster',' trainQuoteId="'.$_REQUEST['trainQuoteId'].'"');
		if(mysqli_num_rows($c1) == 0 && trim($_REQUEST['trainTimeId']) < 1){

			$namevalue ='quotationId="'.$trainQuotData['quotationId'].'",trainQuoteId="'.$_REQUEST['trainQuoteId'].'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",departureDate="'.$departureDate.'",arrivalDate="'.$arrivalDate.'",remark="'.$remark.'",trainId="'.$trainId.'",dayId="'.$dayId.'",status=1';
			$hotelSupHot = addlistinggetlastid('trainTimeLineMaster',$namevalue);
		}else{
			$namevalue ='quotationId="'.$trainQuotData['quotationId'].'",trainQuoteId="'.$_REQUEST['trainQuoteId'].'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",departureDate="'.$departureDate.'",arrivalDate="'.$arrivalDate.'",remark="'.$remark.'",trainId="'.$trainId.'",dayId="'.$dayId.'",status=1';
			$updatelist = updatelisting('trainTimeLineMaster',$namevalue,'id="'.trim($_REQUEST['trainTimeId']).'"');
		}
		?>
		<script>
			parent.closeinbound();
			parent.loadquotationmainfile();
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
		</script>
		<?php
		}


//for addEntranceTimeDetails
if($_REQUEST['action'] == 'addEntranceTimeDetails' && $_REQUEST['entranceQuoteId'] != ''){

	
	$c=GetPageRecord('*','quotationEntranceMaster',' id="'.$_REQUEST['entranceQuoteId'].'" ');
	$entQuoteData = mysqli_fetch_assoc($c);

	$e=GetPageRecord('*','packageBuilderEntranceMaster',' id="'.$entQuoteData['entranceNameId'].'" ');
	$entData = mysqli_fetch_assoc($e);

	if($entQuoteData['transferType']==1){
		$tranferType = 'SIC';
	}elseif($entQuoteData['transferType']==2){
		$tranferType = 'PVT';
	}


	$c1=GetPageRecord('*','quotationEntranceTimelineDetails',' hotelQuoteId="'.$_REQUEST['entranceQuoteId'].'" ');
	if(mysqli_num_rows($c1) > 0){
		$entTimeData= mysqli_fetch_array($c1);
		$id = $entTimeData['id'];
		$startTime = date('H:i', strtotime($entTimeData['startTime']));
		$endTime = date('H:i', strtotime($entTimeData['endTime'])); 
		$dropTime = date('H:i', strtotime($entTimeData['dropTime'])); 
		$pickupTime = date('H:i', strtotime($entTimeData['pickupTime'])); 
		$departureDate = date('Y-m-d', strtotime($entTimeData['departureDate'])); 
		$pickupAddress = $entTimeData['pickupAddress']; 
		$dropAddress = $entTimeData['dropAddress']; 
	}else{
		$id = "";
		$startTime = "";
		$endTime = "";
		$dropTime = "";
		$pickupTime = "";
		$departureDate = $entQuoteData['fromDate'];
	}
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Monument Timeline  </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
					<tr>
						<td align="left" colspan="7" style="font-weight: 500;font-size:15px;">Monument Name:- <?php echo $entData['entranceName'].' | '.$tranferType; ?></td>
					</tr>
				<tr style="background-color:transparent !important;">

                    <td width=" 15%;">
						<div class="griddiv"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Start&nbsp;Time</strong><br></label>
 					   <input type="text" id="startTime" name="startTime" style="text-align:left;width:100%;padding: 3px;
    border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $startTime; ?>"/>
					   
                       </div>
                    </td>

                    <td width=" 15%;"><div class="griddiv"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>End&nbsp;Time</strong><br></label> 
					   <input type="text" id="endTime" name="endTime" style="text-align:left;width:100%;padding: 3px;
    border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"  value="<?php echo $endTime; ?>"/>
                       </div>
                    </td>

					<td colspan="5">&nbsp;</td>

					
			  	</tr>

				<tr>
				<td colspan="7" ><div style="font-weight:500;font-size: 15px;">Transfer Information</div></td>
				</tr>
				<tr>
				<td>
						<div class="griddiv">
						<label>
							<div class="gridlable">Date</div>
						<input type="date" id="departureDate" name="departureDate" class="gridfield" value="<?= $departureDate; ?>"/>
						</label>
						</div>
					</td>

					<td>
						<div class="griddiv">
						<label>
							<div class="gridlable">Pick-up Time</div>
						<input type="text" id="pickupTime" name="pickupTime" style="text-align:left;width:100%;padding:3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"  value="<?php echo $pickupTime; ?>"/>
						</label>
						</div>
					</td>

					<td>
						<div class="griddiv">
						<label>
							<div class="gridlable">Drop Time</div>
						<input type="text" id="dropTime" name="dropTime" style="text-align:left;width:100%;padding:3px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true"  value="<?php echo $dropTime; ?>"/>
						</label>
						</div>
					</td>

					<td>
						<div class="griddiv">
						<label>
							<div class="gridlable">Pick-up Address</div>
						<input type="text" id="pickupAddress" name="pickupAddress" class="gridfield"  value="<?php echo $pickupAddress; ?>"/>
						</label>
						</div>
					</td>

					<td>
						<div class="griddiv">
						<label>
							<div class="gridlable">Drop Address</div>
						<input type="text" id="dropAddress" name="dropAddress" class="gridfield" value="<?php echo $dropAddress; ?>"/>
						</label>
						</div>
					</td>

					<td >
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_hoteltomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $id; ?>" name="entranceTimeId"/>
 						<input type="hidden" value="<?php echo $_REQUEST['entranceQuoteId']; ?>" name="entranceQuoteId"/>
						<input name="action" type="hidden" id="action" value="add_EntranceTimeline">
  					</td>
				</tr>
				</tbody>
			</table>
			<script type="text/javascript" src="js/jquery.timepicker.js"></script>  
			<script type="text/javascript"> 
				$(document).ready(function(){
					$('.timepicker2').timepicker();	
				});  
			</script>
			</form>
		</div>
	</div>

<?php
}
?>


<?php
if(trim($_REQUEST['action'])=='add_EntranceTimeline' && trim($_REQUEST['entranceQuoteId'])!=''){
	// quotation hotel data entranceTimeId 
	$c=GetPageRecord('*','quotationEntranceMaster',' id="'.$_REQUEST['entranceQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);

	$c1=GetPageRecord('*','quotationEntranceTimelineDetails',' hotelQuoteId="'.$_REQUEST['entranceQuoteId'].'"');
	if(mysqli_num_rows($c1) == 0 && trim($_REQUEST['entranceTimeId']) < 1){

		if($_REQUEST['startTime']!=''){
		$startTime = date('H:i:s', strtotime($_REQUEST['startTime']));
		}else{
			$startTime='';
		}

		if($_REQUEST['endTime']!=''){
			$endTime = date('H:i:s', strtotime($_REQUEST['endTime']));
		}else{
			$endTime = '';
		}
		
		if($_REQUEST['dropTime']!=''){
			$dropTime = date('H:i:s', strtotime($_REQUEST['dropTime']));
		}else{
			$dropTime = '';
		}
		if($_REQUEST['pickupTime']!=''){
			$pickupTime = date('H:i:s', strtotime($_REQUEST['pickupTime']));
		}else{
			$pickupTime = '';	
		}
		
		$departureDate = date('Y-m-d', strtotime($_REQUEST['departureDate']));
		$pickupAddress = $_REQUEST['pickupAddress'];
		$dropAddress = $_REQUEST['dropAddress'];

		$namevalue ='quotationId="'.$hotelQuotData['quotationId'].'",supplierId="'.$hotelQuotData['supplierId'].'",hotelQuoteId="'.$_REQUEST['entranceQuoteId'].'",startTime="'.$startTime.'",endTime="'.$endTime.'",dropTime="'.$dropTime.'",pickupTime="'.$pickupTime.'",departureDate="'.$departureDate.'",pickupAddress="'.$pickupAddress.'",dropAddress="'.$dropAddress.'"';
		$hotelSupHot = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);
	}else{
		if($_REQUEST['startTime']!=''){
			$startTime = date('H:i:s', strtotime($_REQUEST['startTime']));
			}else{
				$startTime='';
			}
	
			if($_REQUEST['endTime']!=''){
				$endTime = date('H:i:s', strtotime($_REQUEST['endTime']));
			}else{
				$endTime = '';
			}
			
			if($_REQUEST['dropTime']!=''){
				$dropTime = date('H:i:s', strtotime($_REQUEST['dropTime']));
			}else{
				$dropTime = '';
			}
			if($_REQUEST['pickupTime']!=''){
				$pickupTime = date('H:i:s', strtotime($_REQUEST['pickupTime']));
			}else{
				$pickupTime = '';	
			}
			
			$departureDate = date('Y-m-d', strtotime($_REQUEST['departureDate']));
			$pickupAddress = $_REQUEST['pickupAddress'];
			$dropAddress = $_REQUEST['dropAddress'];
	
		$namevalue ='startTime="'.$_REQUEST['startTime'].'",endTime="'.$_REQUEST['endTime'].'",dropTime="'.$dropTime.'",pickupTime="'.$pickupTime.'",departureDate="'.$departureDate.'",pickupAddress="'.$pickupAddress.'",dropAddress="'.$dropAddress.'"';
		$updatelist = updatelisting('quotationEntranceTimelineDetails',$namevalue,'id="'.trim($_REQUEST['entranceTimeId']).'"');
	}
	?>
	<script>
		parent.closeinbound();
		parent.loadquotationmainfile();
  		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}
?>


<?php
if(trim($_REQUEST['action'])=='add_FlightTimeline' && trim($_REQUEST['flightQuoteId'])!=''){
	// quotation hotel data entranceTimeId 


// departurefrom,departureto,via,departureDate,departuretime,Arrivaldate, Arrivaltime,remark


        $departurefrom = $_REQUEST['departurefrom'];
        $departureto = $_REQUEST['departureto'];
        $via = $_REQUEST['via'];
        
		$departureTime = date('H:i:s', strtotime($_REQUEST['departuretime']));
		$arrivalTime = date('H:i:s', strtotime($_REQUEST['Arrivaltime']));
		$departureDate = date('Y-m-d', strtotime($_REQUEST['departureDate']));
		$arrivalDate = date('Y-m-d', strtotime($_REQUEST['Arrivaldate']));
		$remark = $_REQUEST['remark'];
		
		$flightId = $_REQUEST['flightId'];
		$dayId = $_REQUEST['dayId'];

	$c=GetPageRecord('*','quotationFlightMaster',' id="'.$_REQUEST['flightQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);
	
	

	$c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$_REQUEST['flightQuoteId'].'"');
	if(mysqli_num_rows($c1) == 0 && trim($_REQUEST['flightTimeId']) < 1){

		$namevalue ='quotationId="'.$hotelQuotData['quotationId'].'",flightQuoteId="'.$_REQUEST['flightQuoteId'].'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",departureDate="'.$departureDate.'",arrivalDate="'.$arrivalDate.'",remark="'.$remark.'",departurefrom="'.$departurefrom.'",departureto="'.$departureto.'",via="'.$via.'",flightId="'.$flightId.'",dayId="'.$dayId.'",status=1';
		$hotelSupHot = addlistinggetlastid('flightTimeLineMaster',$namevalue);
	}else{
		$namevalue ='quotationId="'.$hotelQuotData['quotationId'].'",flightQuoteId="'.$_REQUEST['flightQuoteId'].'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",departureDate="'.$departureDate.'",arrivalDate="'.$arrivalDate.'",remark="'.$remark.'",departurefrom="'.$departurefrom.'",departureto="'.$departureto.'",via="'.$via.'",flightId="'.$flightId.'",dayId="'.$dayId.'",status=1';
		$updatelist = updatelisting('flightTimeLineMaster',$namevalue,'id="'.trim($_REQUEST['flightTimeId']).'"');
	}
	?>
	<script>
		parent.closeinbound();
		parent.loadquotationmainfile();
  		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}
?>


<?php
//for addEntranceTimeDetails
if($_REQUEST['action'] == 'addActivityTimeDetails' && $_REQUEST['activityQuoteId'] != ''){
	$c1=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$_REQUEST['activityQuoteId'].'" ');
	if(mysqli_num_rows($c1) > 0){
		$entTimeData= mysqli_fetch_array($c1);
		$startTime = date('H:i', strtotime($entTimeData['startTime']));
		$endTime = date('H:i', strtotime($entTimeData['endTime'])); 
		$id = $entTimeData['id'];
	}else{
		$id = "";
		$startTime = "";
		$endTime = "";
	}
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add SightSeeing Timeline  </span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>	</div>
	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
			<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
			<table  border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="width: 100%!important; padding:5px; border:0px #e3e3e3 solid;background-color: #fff;">
				<tbody>
				<tr style="background-color:transparent !important;">

                    <td><div class="griddiv"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>Start&nbsp;Time</strong></label>
 					   <input type="text" id="startTime" name="startTime" style="text-align:left;width:90%;padding: 3px;
    border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $startTime;?>"/>
                       </div>
                    </td>

                    <td><div class="griddiv"><label for="ArribleTime" style="font-size:12px;color: #333333;"><strong>End&nbsp;Time</strong></label>
 					   <input type="text" id="endTime" name="endTime" style="text-align:left;width:90%;padding: 3px;
    border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $endTime;?>"/>
                       </div>
                    </td>

					<td >
						<input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_hoteltomaster','submitbtn','0');">
						<input type="hidden" value="<?php echo $id; ?>" name="activityTimeId"/>
 						<input type="hidden" value="<?php echo $_REQUEST['activityQuoteId']; ?>" name="activityQuoteId"/>
						<input name="action" type="hidden" id="action" value="add_ActivityTimeline">
  					</td>
			  	</tr>
				</tbody>
			</table>
			<script type="text/javascript" src="js/jquery.timepicker.js"></script>   
			<script type="text/javascript"> 
				$(document).ready(function(){
				 	$('.timepicker2').timepicker();	
					
				});  
			</script>
			</form>
		</div>
	</div>

<?php
}
?>

<?php
if(trim($_REQUEST['action'])=='add_ActivityTimeline' && trim($_REQUEST['activityQuoteId'])!=''){
	// quotation hotel data
	$c=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' id="'.$_REQUEST['activityQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);

	$c1=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$_REQUEST['activityQuoteId'].'" ');
	if(mysqli_num_rows($c1) == 0 && trim($_REQUEST['activityTimeId']) < 1){ 
		$startTime = date('H:i:s', strtotime($_REQUEST['startTime']));
		$endTime = date('H:i:s', strtotime($_REQUEST['endTime'])); 
		$namevalue ='quotationId="'.$hotelQuotData['quotationId'].'",dayId="'.$_REQUEST['dayId'].'",hotelQuoteId="'.$hotelQuotData['id'].'",startTime="'.$startTime.'",endTime="'.$endTime.'"';
		$hotelSupHot = addlistinggetlastid('quotationActivityTimelineDetails',$namevalue); 
	}else{
		$namevalue ='startTime="'.$_REQUEST['startTime'].'",endTime="'.$_REQUEST['endTime'].'"';
		$updatelist = updatelisting('quotationActivityTimelineDetails',$namevalue,'id="'.trim($_REQUEST['activityTimeId']).'"');
	}
	?>
	<script>
		parent.closeinbound();
		parent.loadquotationmainfile();
  		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
	</script>
	<?php
}

// Add New Restaurant end here ============================
if($_REQUEST['action'] == 'addeditrestauranttomaster'){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Restaurant</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:20px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
	
			<form action="inboundpop.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable">Restaurant Name<span class="redmind"></span></div>
						<input name="serviceName" type="text" class="gridfield validate" id="serviceName" displayname="Restaurant Name" value="<?php echo $serviceName; ?>" maxlength="100" />
					</label>
				</div>
				

				<div class="griddiv"><label>
					<div class="gridlable">Destination<span class="redmind"></span></div>
					<select id="hotelCity" name="hotelCity" class="gridfield validate" displayname="Destination" autocomplete="off">
							<option value="">Select</option>
							<?php
							$select = '';
							$where = '';
							$rs = '';
							$select = '*';
							$where = ' 1 and deletestatus = 0 order by name asc';
							$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
							while ($resListing = mysqli_fetch_array($rs)) {
							?>
								<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['id'] == $_REQUEST['cityId']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

							<?php } ?>
						</select>
					</label>
				</div>


				<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
				<input type="hidden" value="<?php echo $_REQUEST['destinationId']; ?>" name="cityId"/>
				<input type="hidden" value="<?php echo $_REQUEST['cityId']; ?>" name="destId"/>
				<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
				<input name="action" type="hidden" id="action" value="addedit_restauranttomaster" />
			</form>
			<div id="buttonsbox" style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td> 
						<td style="padding-right:20px;">
							<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceMealPlan&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','800px');">
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php
}



// Add New Ferry end here ============================
if($_REQUEST['action'] == 'addferrytomaster'){

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
	$dayData = mysqli_fetch_array($dayQuery);
	?>
	<div style="font-size:16px;padding:10px;position:relative;background-color: #f1f1f1;">
		<span id="hotelcounding">Add Ferry Transfer Name</span> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onclick="closeinbound();"></i>
	</div>
	<div style="padding:20px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" style="padding:0px;">
	
			<form action="inboundpop.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable">Ferry Transfer Name<span class="redmind"></span></div>
						<input name="serviceName" type="text" class="gridfield validate" id="serviceName" displayname="Restaurant Name" value="<?php echo $serviceName; ?>" maxlength="100" />
					</label>
				</div>
				

				
								
				<div class='ferrytime' style="width: 100%;display:flex">
				
					<div class="griddiv" style="width: 40%;"><label>
						<div class="gridlable">Destination<span class="redmind"></span></div>
						<select id="hotelCity" name="hotelCity" class="gridfield validate" displayname="Destination" autocomplete="off">
								<option value="">Select</option>
								<?php
								$select = '';
								$where = '';
								$rs = '';
								$select = '*';
								$where = ' 1 and deletestatus = 0 order by name asc';
								$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
								while ($resListing = mysqli_fetch_array($rs)) {
								?>
									<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['id'] == $_REQUEST['cityId']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

								<?php } ?>
							</select>
						</label>
					</div>

					<div class="griddiv" style="width: 30%;"><label>
						<div class="gridlable" style="margin-left: 10px;">Arrival&nbsp;Time</span></div>
						<input type="text" id="arrivalTime" name="arrivalTime[]" style="text-align:left;width:90%;padding: 7px;border: 1px solid #ccc;border-radius: 2px;    margin-left: 10px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $startTime;?>"/>
						</label>
					</div>

					<div class="griddiv" style="width: 30%;"><label>
						<div class="gridlable" style="margin-left: 10px;">Departure&nbsp;Time</span></div>
						<input type="text" id="departureTime" name="departureTime[]" style="text-align:left;width:90%;padding: 7px;border: 1px solid #ccc;border-radius: 2px;margin-left: 10px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $endTime;?>"/>
						</label>
					</div>
				</div>
				<script type="text/javascript" src="js/jquery.timepicker.js"></script>   
				<script type="text/javascript"> 
				$(document).ready(function(){
				 	$('.timepicker2').timepicker();	
					
				});
				</script> 


				<input type="hidden" value="<?php echo $_REQUEST['dayId']; ?>" name="dayId"/>
				<input type="hidden" value="<?php echo $_REQUEST['destinationId']; ?>" name="cityId"/>
				<input type="hidden" value="<?php echo $_REQUEST['cityId']; ?>" name="destId"/>
				<input type="hidden" value="<?php echo $dayData['quotationId']; ?>" name="quotationId"/>
				<input name="action" type="hidden" id="action" value="addedit_ferrytomaster" />
			</form>
			<div id="buttonsbox" style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td> 
						<td style="padding-right:20px;">
							<input type="button" name="Submit" value=" Back To Search " class="bluembutton" onclick="openinboundpop('action=addServiceFerry&dayId=<?php echo $_REQUEST['dayId']; ?>&d=<?php echo $dayData['srdate']; ?>','1200px');">
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php
}




	// Ferry Transfer start
if(trim($_POST['action'])=='addedit_ferrytomaster' && trim($_POST['serviceName'])!=''){ 
	$serviceName=clean($_POST['serviceName']);
	$hotelCity=clean($_POST['hotelCity']);
	$destId=clean($_POST['destId']);
	$destinationId = $_POST['destinationId']; 

	$arrivalTime1=$_POST['arrivalTime']; 
	$departureTime1=$_POST['departureTime']; 


	$dateAdded=time();

	
	// duplicate added code
	$rsr=GetPageRecord('*','ferryPriceMaster','name="'.$serviceName.'" ');
	// $editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('This Ferry Name Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }
    else{
		$namevalue ='name="'.$serviceName.'",status=1,deletestatus=0,destinationId="'.$destId.'"';  
		$lastId  = addlistinggetlastid('ferryPriceMaster',$namevalue);

		$msg = 1;

		foreach( $arrivalTime1 as $key => $value){

			$arrivalTime1 = $value;
			$departureTime2 = $departureTime1[$key];
			$allvalueferryTime ='ferrypriceId="'.$lastId.'",pickupTime="'.$arrivalTime1.'",dropTime="'.$departureTime2.'",status=1,deletestatus=0';
			$add = addlisting('ferryServiceTiming',$allvalueferryTime);
		}
	}
	?>
	<script>
		parent.openinboundpop('action=addServiceFerry&dayId=<?php echo $_REQUEST['dayId']; ?>','1200px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
		
	</script>	
	<?php
} 






// Additional Restaurant start
if(trim($_POST['action'])=='addedit_restauranttomaster' && trim($_POST['serviceName'])!=''){ 
	$serviceName=clean($_POST['serviceName']);
	$hotelCity=clean($_POST['hotelCity']);
	$destId=clean($_POST['destId']);
	$destinationId = $_POST['destinationId']; 
	$dateAdded=time();
	
	// duplicate added code
	$rsr=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,'mealPlanName="'.$serviceName.'" ');
	// $editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('This Restaurant Name Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }
    else{
		$namevalue ='mealPlanName="'.$serviceName.'",hotelCity="'.$hotelCity.'",status=1,destinationId="'.$destId.'"';  
		$adds = addlisting(_INBOUND_MEALPLAN_MASTER_,$namevalue); 
	}
	?>
	<script>
		parent.openinboundpop('action=addServiceMealPlan&dayId=<?php echo $_REQUEST['dayId']; ?>','800px');
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
		
	</script>	
	<?php
} 

// Optional experiences

if($_REQUEST['action'] == 'supplimentServiceType' && trim($_REQUEST['destinationId'])!='' && trim($_REQUEST['serviceType'])!='' ){

	$rs=GetPageRecord('*',_DESTINATION_MASTER_,' id="'.trim($_REQUEST['destinationId']).'" order by id asc');
	$resListing=mysqli_fetch_array($rs);

	$queQuery=GetPageRecord('nationality',_QUERY_MASTER_,'id in ( select queryId from quotationMaster where id="'.$_REQUEST['quotationId'].'") ');
	$queryData=mysqli_fetch_array($queQuery);

	$nation=GetPageRecord('countryId','nationalityMaster','id ="'.$queryData['nationality'].'"');
	$nationData=mysqli_fetch_array($nation);
	$counNation = mysqli_num_rows($nation);

	$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.trim($_REQUEST['quotationId']).'"');
	$quotationData=mysqli_fetch_array($quotQuery);

	if($counNation > 0){
		if($nationData['countryId'] == $defaultCountryId){
			$nationType = getCountryName($defaultCountryId);
		}else{
			$nationType = 'Foreign';	
		}
	}
	$quotationId=$quotationData['id'];
	$queryId=$quotationData['queryId'];
	?>

 	<div class="inboundheader" style="position:relative;"> <?php 
 	if($_REQUEST['serviceType']==1){ echo 'Activity'; }
 	elseif($_REQUEST['serviceType']==2){ echo 'Guide'; }
 	elseif($_REQUEST['serviceType']==3){ echo 'Entrance'.'&nbsp;&nbsp;&nbsp;&nbsp;Guest Type: '.$nationType; } 
 	elseif($_REQUEST['serviceType']==4){ echo 'Restaurant'; }
 	elseif($_REQUEST['serviceType']==5){ echo 'Additional'; }
 	?> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>

	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
		<?php 
		if($_REQUEST['serviceType']==1){ ?>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#E6E6E6" class="tablesorter gridtable" id="entrancesicTable">
			<thead>
			<tr style="border: 1px solid #fff;border-bottom: 1px solid #E6E6E6;">
				<th align="left">&nbsp;&nbsp;Name</th>
				<th align="center"> Supplier </th>
				<th align="center"> Activity&nbsp;Cost </th>
				<th align="center"> Pax&nbsp;Range</th>
				<th align="center"> PerPax&nbsp;Cost</th>
				<th align="center" colspan="2">Action</th>
				
			</tr>
			</thead>
			<tbody>
			<?php
			$where='';
			$rs=''; 
			$where=' otherActivityCity = "'.trim($resListing['name']).'" and status=1  order by otherActivityName asc';
			$rsw=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$where);
			if(mysqli_num_rows($rsw)>0){
				while($resListing=mysqli_fetch_array($rsw)){

 					$rs121=GetPageRecord('id',_QUOTATION_OTHER_ACTIVITY_MASTER_,'otherActivityName="'.$resListing['id'].'" and quotationId="'.$quotationData['id'].'"');
					$isAlreadyAdded=mysqli_num_rows($rs121);
					if($isAlreadyAdded == 0){

					$where1=' otherActivityNameId = "'.$resListing['id'].'"  and status=1 and id not in (select additionalId from quotationAdditionalMaster where quotationId="'.$_REQUEST['quotationId'].'" and serviceType="Activity") order by maxpax asc';
					$rs11=GetPageRecord('*','dmcotherActivityRate',$where1);
					if(mysqli_num_rows($rs11)>0){
					while($dmcroommastermain=mysqli_fetch_array($rs11)){

							$rs11=GetPageRecord('*','optionalServicesRateMaster','dmcId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationData['id'].'" and serviceType="Activity"');
							if(mysqli_num_rows($rs11)>0){
								$table=2;
								$quoterateData=mysqli_fetch_array($rs11);
								$supplierId = $quoterateData['supplierId'];
								$currencyId = $quoterateData['currencyId'];
								$maxpax = $quoterateData['maxpax'];
								$perPaxCost = $quoterateData['perPaxCost'];
								$activityCost = ($perPaxCost*$maxpax);
								
								
								$activityNameId = $quoterateData['serviceId'];
								$editId  = $quoterateData['id'];
								$rateId  = $quoterateData['id'];
							}else{
								$table=1;
								$supplierId = $dmcroommastermain['supplierId'];
								$currencyId = $dmcroommastermain['currencyId'];
								$maxpax = $dmcroommastermain['maxpax'];
								$perPaxCost = $dmcroommastermain['perPaxCost'];
								$activityCost = ($perPaxCost*$maxpax);
								
								
								$activityNameId = $dmcroommastermain['otherActivityNameId'];
								$rateId  = $dmcroommastermain['id'];
							}
					
					?>
 					<tr>
					<td align="left"><?php echo strip($resListing['otherActivityName']); ?></td>
					<td align="center"><?php echo getsupplierCompany($supplierId); ?></td>
					<td align="center"><?php echo  getCurrencyName($currencyId).'&nbsp;'.strip($activityCost); ?></td>

					<td align="center">Upto&nbsp;<?php echo strip($maxpax); ?>&nbsp;Pax</td>

					<td align="center"><?php echo getCurrencyName($currencyId).'&nbsp;'.round($perPaxCost); ?></td>
				

		           	<td align="center" valign="middle"><div style="width:65px !important; padding: 8px !important;" class="editbtnselect" id="selectbut<?php echo urlencode($resListing['id']); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo urlencode($resListing['id']); ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

					<div class="editbtnselect" id="selectedbut<?php echo urlencode($resListing['id']); ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div></td>

					<td>
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcroommastermain['id'];?>&serviceType=Activity&serviceId=<?php echo $activityNameId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','600px');">+Edit&nbsp;Price</div>
					</td>
				</tr>
				<?php } }else{
					
					$rs112=GetPageRecord('*','optionalServicesRateMaster','dmcId="0" and quotationId="'.$quotationData['id'].'" and serviceId="'.$resListing['id'].'" and serviceType="Activity"');
					if(mysqli_num_rows($rs112)>0){
						
					
						while($quoterateData=mysqli_fetch_array($rs112)){
						$supplierId = $quoterateData['supplierId'];
						$currencyId = $quoterateData['currencyId'];
						$perPaxCost = $quoterateData['perPaxCost'];
						$maxpax = $quoterateData['maxpax'];
						$activityCost = ($perPaxCost*$maxpax);
						
						$activityNameId = $quoterateData['serviceId'];
						$editId  = $quoterateData['id'];
						$rateId  = $quoterateData['id'];
						$table=2;
						?>

					<tr>
					<td align="left"><?php echo strip($resListing['otherActivityName']); ?></td>
					<td align="center"><?php echo getsupplierCompany($supplierId); ?></td>
					<td align="center"><?php echo  getCurrencyName($currencyId).'&nbsp;'.strip($activityCost); ?></td>

					<td align="center">Upto&nbsp;<?php echo strip($maxpax); ?>&nbsp;Pax</td>

					<td align="center"><?php echo getCurrencyName($currencyId).'&nbsp;'.round($perPaxCost); ?></td>
				

		           	<td align="center" valign="middle"><div style="width: 65px !important; padding: 8px !important;" class="editbtnselect" id="selectbut<?php echo urlencode($resListing['id']); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo urlencode($resListing['id']); ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

					<div class="editbtnselect" id="selectedbut<?php echo urlencode($resListing['id']); ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div></td>

					<td>
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcroommastermain['id'];?>&serviceType=Activity&serviceId=<?php echo $activityNameId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','600px');">+Edit&nbsp;Price</div>
					</td>
				</tr>

						<?php
						}
					}else{

				
					?>
 					<tr>
					<td align="left"><?php echo strip($resListing['otherActivityName']); ?></td>
					<td align="center">N/A</td>
					<td align="center">N/A</td>
						
					<td align="center">N/A</td>

					<td align="center">N/A</td>  
					
					<td align="center" valign="middle">&nbsp;</td>
					<td>
					<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcroommastermain['id'];?>&serviceType=Activity&serviceId=<?php echo $resListing['id']; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>','600px');">+Edit&nbsp;Price</div>
					</td>
		           	
					</tr>
					<?php } ?>
					
				
				<?php 
				} 
				} }
			}else{
				?>
				<tr>
					<td align="center" colspan="4">&nbsp;No Active Rates Found!!</td>
				</tr>
				<?php
			} 
			?>
			</tbody>
			</table>
		 	<?php 
		} elseif($_REQUEST['serviceType']==2){  ?>
			<table border="1" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4" class="tablesorter gridtable"  id="entrancesicTable" >
			<thead>
				<tr>
				  <th height="20" align="left" >&nbsp;</th>
 					<th height="20" align="left" style="border-left:hidden; padding-left:5px;"> Guide&nbsp;Name</th>
					<th height="20" width="150" align="left" > Day Type</th>
					<th height="20" width="200" align="left" > Cost</th>
					<th height="20" colspan="2" align="center" style="border-left:hidden;">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$c1=0;

			$rs2=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'status=1 and deletestatus=0 and name!=""');
			while($guideData = mysqli_fetch_assoc($rs2)){
			$whereDate = ' and "'.$quotationData['fromDate'].'" BETWEEN fromDate and toDate and "'.$quotationData['toDate'].'" BETWEEN fromDate and toDate ';

			$where1=' serviceid="'.$guideData['id'].'" and status=1 '.$whereDate.' order by id desc';
			$rs1=GetPageRecord('*','dmcGuidePorterRate',$where1);
			if(mysqli_num_rows($rs1)>0){ 	
				while($dmcroommastermain=mysqli_fetch_array($rs1)){

					$rs11=GetPageRecord('*','optionalServicesRateMaster','dmcId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationData['id'].'" and serviceType="Guide"');
					if(mysqli_num_rows($rs11)>0){
						$table = 2;
						$dmcroommastermain=mysqli_fetch_array($rs11);
						$currencyId = $dmcroommastermain['currencyId'];
						$guideNameId = $dmcroommastermain['serviceId'];
						$serviceCost = $dmcroommastermain['serviceCost'];
						$rateId = $dmcroommastermain['id'];
						$editId  = $dmcroommastermain['id'];
								
					 }else{
						$table = 1;
						$currencyId = $dmcroommastermain['currencyId'];
						$serviceCost = $dmcroommastermain['price'];
						$dmcId = $dmcroommastermain['id'];
						$rateId  = $dmcroommastermain['id'];
						$guideNameId = $dmcroommastermain['serviceid'];
					 }
					if(trim($dmcroommastermain['dayType']) == 'fullday'){
						$dayType = "Full Day";
					}else{
						$dayType = "Half Day";
					}

					?>
				  	<tr>
				    <td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
					<td align="left"><?php echo clean($guideData['name']);  ?></td>
					<td align="left"><?php echo ($dayType);  ?></td>
					<td align="left"><?php echo getCurrencyName($currencyId).' '.clean($serviceCost);  ?></td>
				    
				
					
					<td align="center"><div class="editbtnselect" style="width:65px !important;" id="selectbut<?php echo urlencode($guideData['id']); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo urlencode($guideData['id']); ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

					<div class="editbtnselect" id="selectedbut<?php echo urlencode($guideData['id']); ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div></td>

					<td>
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Guide&serviceId=<?php echo $guideNameId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','1000px');">+Edit&nbsp;Price</div>
					</td>
				  	</tr>
					<?php
				} 
			}else{
					
					 $rs112=GetPageRecord('*','optionalServicesRateMaster','dmcId="0" and quotationId="'.$quotationData['id'].'" and serviceId="'.$guideData['id'].'" and serviceType="Guide"');
					if(mysqli_num_rows($rs112)>0){
						
						$table=2;
						while($dmcroommastermain=mysqli_fetch_array($rs112)){
						$currencyId = $dmcroommastermain['currencyId'];
						$guideNameId = $dmcroommastermain['serviceId'];
						$serviceCost = $dmcroommastermain['serviceCost'];
						$rateId = $dmcroommastermain['id'];
						$editId  = $dmcroommastermain['id'];

						if(trim($dmcroommastermain['dayType']) == 'fullday'){
							$dayType = "Full Day";
						}else{
							$dayType = "Half Day";
						}

				?>
				  	<tr>
				    <td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
					<td align="left"><?php echo clean($guideData['name']);  ?></td>
					<td align="left"><?php echo ($dayType);  ?></td>
					<td align="left"><?php echo getCurrencyName($currencyId).' '.clean($serviceCost);  ?></td>
					
					<td align="center"><div style="width:65px !important;" class="editbtnselect" id="selectbut<?php echo urlencode($guideData['id']); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo urlencode($guideData['id']); ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

					<div class="editbtnselect" id="selectedbut<?php echo urlencode($guideData['id']); ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div></td>

					<td>
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Guide&serviceId=<?php echo $guideNameId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','1000px');">+Edit&nbsp;Price</div>
					</td>
				  	</tr>
					<?php
						}
					}else{

						if(trim($dmcroommastermain['dayType']) == 'fullday'){
							$dayType = "Full Day";
						}else{
							$dayType = "Half Day";
						}
						?>
						<tr>
						<td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
						<td align="left"><?php echo clean($guideData['name']);  ?></td>
						<td align="left"><?php echo ($dayType);  ?></td>
						<td align="left">N/A</td>
						<td align="left">&nbsp;</td>
						
						<td><div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Guide&serviceId=<?php echo $guideData['id']; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>','1000px');">+Edit&nbsp;Price</div>
						</td>
						
					</tr>
						<?php
					}
			}
			}
			?>
			</tbody>
			</table>
			<?php 
		}elseif($_REQUEST['serviceType']==3){  ?>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4" class="tablesorter gridtable"  id="entrancesicTable">
			<thead>
				<tr>
				  <th height="20" align="left"  >&nbsp;</th>
					<th height="20" align="left" style="border-left:hidden; padding-left:5px;">Name</th>
					<th height="30" align="center" > Entrance Adult Fees</th>
					<th height="20" align="center" > Entrance Child Fees</th>
					<th height="20" colspan="2" align="center" style="border-left:hidden;">Action</th>
					
				</tr>
			</thead>
			<tbody>
			<?php
			$c1=0;
			$select1='';
			$wher1='';
			$rs1='';
			$select1='*';

			$rscs=GetPageRecord('queryId',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"');  
	        $queryResult=mysqli_fetch_array($rscs);
	        $queryId=$queryResult['queryId'];

			$marketTypeId = getQueryMaketType($queryId);
	        $whereMarket = ' and marketType=1';
	        if($marketTypeId>0){
		    $whereMarket = ' and marketType="'.$marketTypeId.'"';
	        }
	 
			if($nationData['countryId'] == $defaultCountryId || $counNation == 0){
				$whereNationalityType = ' and nationalityType=1';
			}else{
				$whereNationalityType = ' and nationalityType=2';
			}

			$whereDate = ' and "'.$quotationData['fromDate'].'" BETWEEN fromDate and toDate and "'.$quotationData['toDate'].'" BETWEEN fromDate and toDate ';

			$where12='entranceCity="'.trim($resListing['name']).'" and status=1  and deletestatus=0 and entranceName!="" order by entranceName asc';
			$rs12=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,$where12);
			while($editresult2=mysqli_fetch_array($rs12)){

				$entranceId=$editresult2['id'];
				$entranceName=$editresult2['entranceName'];

			 	$where1=' supplierId in (select id from '._SUPPLIERS_MASTER_.' where  deletestatus=0 and (entranceType=4  or entranceType=1 )) and status=1 and entranceNameId="'.$editresult2['id'].'"  and supplierId>0 '.$whereNationalityType.' '.$whereMarket.' '.$whereDate.' order by id desc';
				$rs1=GetPageRecord($select1,_DMC_ENTRANCE_RATE_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){ 
					while($dmcroommastermain=mysqli_fetch_array($rs1)){

						$rs11=GetPageRecord('*','optionalServicesRateMaster','dmcId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationData['id'].'" and serviceType="Entrance"');
						if(mysqli_num_rows($rs11)>0){
							$table = 2;
							$dmcroommastermain=mysqli_fetch_array($rs11);
							$currencyId = $dmcroommastermain['currencyId'];
							$entranceNameId = $dmcroommastermain['serviceId'];
							$ticketchildCost = $dmcroommastermain['adultCost'];
							$ticketAdultCost = $dmcroommastermain['childCost'];
							$rateId = $dmcroommastermain['id'];
							$editId  = $dmcroommastermain['id'];
									
						 }else{
							$table = 1;
							$currencyId = $dmcroommastermain['currencyId'];
							$ticketchildCost = $dmcroommastermain['ticketchildCost'];
							$ticketAdultCost = $dmcroommastermain['ticketAdultCost'];
							$dmcId = $dmcroommastermain['id'];
							$rateId  = $dmcroommastermain['id'];
							
							$entranceNameId = $dmcroommastermain['entranceNameId'];
						 }

						$rs121=GetPageRecord('id','quotationEntranceMaster','entranceNameId="'.$editresult2['id'].'" and quotationId="'.$quotationId.'"');
						$isAlreadyAdded=mysqli_num_rows($rs121);
						if($isAlreadyAdded == 0){

							$isClosed=0;
							$rs2xs=GetPageRecord('id',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id='.$dmcroommastermain['entranceNameId'].' and FIND_IN_SET("'.date("l", strtotime($datestart)).'", closeDaysname)');
							if(mysqli_num_rows($rs2xs)>0){ $isClosed=1;  }
							?>
							<tr>
							  <td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
							<td align="left"><?php
							echo clean($entranceName);
							?></td>
							<td align="center"><?php
					
							?><?php echo getCurrencyName($currencyId).' '.strip($ticketAdultCost); ?></td>

							<td align="center"><?php echo getCurrencyName($currencyId).' '.strip($ticketchildCost); ?></td>

							<td align="center" valign="middle"><div style="width:65px !important; " class="editbtnselect" id="selectbut<?php echo urlencode($entranceId); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo $entranceId; ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

							<div class="editbtnselect" id="selectedbut<?php echo $entranceId; ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div>
							</td>

						<td align="center">
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Entrance&serviceId=<?php echo $entranceNameId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','600px');">Edit</div>
						</td>

						  	</tr>
							<?php
						} 
					} 
				}else{

					$rs112=GetPageRecord('*','optionalServicesRateMaster','dmcId="0" and quotationId="'.$quotationData['id'].'" and serviceId="'.$entranceId.'" and serviceType="Entrance"');
					if(mysqli_num_rows($rs112)>0){
						
						while($dmcroommastermain=mysqli_fetch_array($rs112)){
						$currencyId = $dmcroommastermain['currencyId'];
						$guideNameId = $dmcroommastermain['serviceId'];
						$ticketAdultCost = $dmcroommastermain['adultCost'];
						$ticketchildCost = $dmcroommastermain['childCost'];
						$entranceNameId = $dmcroommastermain['serviceId'];
						$rateId = $dmcroommastermain['id'];
						$editId  = $dmcroommastermain['id'];
						$table=2;

						?>
					<tr>
							  <td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
							<td align="left"><?php echo clean($entranceName); ?></td>
							<td align="center"><?php echo getCurrencyName($currencyId).' '.strip($ticketAdultCost); ?></td>

							<td align="center"><?php echo getCurrencyName($currencyId).' '.strip($ticketchildCost); ?></td>

					

						<td align="center" valign="middle"><div style="width:65px !important; " class="editbtnselect" id="selectbut<?php echo $entranceId; ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo $entranceId; ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

						<div class="editbtnselect" id="selectedbut<?php echo $entranceId; ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div>
					</td>

					<td align="center">
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Entrance&serviceId=<?php echo $entranceNameId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','600px');">+Edit&nbsp;Price</div>
						</td>

				</tr>

						<?php
					}
					}else{
				?>

					<tr>
				  	<td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
					<td align="left"><?php echo clean($entranceName); ?></td>
				
					<td align="center">N/A</td> 
					<td align="center">N/A</td> 
					<td align="center" valign="middle">&nbsp;</td>
					<td align="center">
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Entrance&serviceId=<?php echo $entranceId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>','600px');">+Edit&nbsp;Price</div>
					</td>

					
					</tr>
					<?php
			}
		}
	}
			?>
			</tbody>
			</table>
			<?php 
		}elseif($_REQUEST['serviceType']==4){  ?>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4" class="tablesorter gridtable"  id="entrancesicTable">
			<thead>
				<tr>
				  <th height="20" align="left"  >&nbsp;#</th>
					<th height="20" align="left" style="border-left:hidden; padding-left:5px;">Restaurant&nbsp;Name</th>
					<th height="30" align="left" >Meal Type</th>
					<th height="30" align="center" >Adult Cost</th>
					<th height="20" align="center" >Child Cost</th>
					<th height="20" colspan="2" align="center" style="border-left:hidden;">&nbsp;Action</th>
					
				</tr>
			</thead>
			<tbody>
			<?php 
			

				// restaurant master
				$restmasterQuery = GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,'mealPlanName!="" and status=1 and deletestatus=0');
    			while($restmasterData = mysqli_fetch_assoc($restmasterQuery)){

				$dmcMQuery=GetPageRecord('*','dmcRestaurantsMealPlanRate','restaurantId="'.$restmasterData['id'].'" ');
				if(mysqli_num_rows($dmcMQuery)>0){
				$dmcroommastermain=mysqli_fetch_array($dmcMQuery);

				$rs11=GetPageRecord('*','optionalServicesRateMaster','dmcId="'.$dmcroommastermain['id'].'" and quotationId="'.$quotationData['id'].'" and serviceType="Restaurant"');
				if(mysqli_num_rows($rs11)>0){
					$table = 2;
					$dmcroommastermain=mysqli_fetch_array($rs11);
					$currencyId = $dmcroommastermain['currencyId'];
					$restaurantId = $dmcroommastermain['serviceId'];
					$adultCost = $dmcroommastermain['adultCost'];
					$childCost = $dmcroommastermain['childCost'];
					$rateId = $dmcroommastermain['id'];
					$editId  = $dmcroommastermain['id'];
							
				 }else{
					$table = 1;
					$currencyId = $dmcroommastermain['currencyId'];
					$adultCost = $dmcroommastermain['adultCost'];
					$childCost = $dmcroommastermain['childCost'];
					$dmcId = $dmcroommastermain['id'];
					$rateId  = $dmcroommastermain['id'];
					
					$restaurantId = $dmcroommastermain['restaurantId'];
					$mealPlanType = $dmcroommastermain['mealPlanType'];
				 }

				// mealtype
				$mealTypeQuery=GetPageRecord('*','restaurantsMealPlanMaster','id="'.$mealPlanType.'" and deletestatus=0'); 
				$mealTypeD=mysqli_fetch_array($mealTypeQuery);
				?>
				<tr>
					<td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
					<td align="left"><?php echo clean($restmasterData['mealPlanName']); ?></td>
					<td align="left"><?php echo clean($mealTypeD['name']); ?></td>
					<td align="center"><?php echo getCurrencyName($currencyId).' '.strip($adultCost); ?></td>

					<td align="center"><?php echo getCurrencyName($currencyId).' '.strip($childCost); ?></td>
	
					<td align="center" valign="middle"><div style="width:65px !important;" class="editbtnselect" id="selectbut<?php echo urlencode($restmasterData['id']); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo $restmasterData['id']; ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

					<div class="editbtnselect" id="selectedbut<?php echo urlencode($restmasterData['id']); ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div>
					</td>

					<td align="center">
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Restaurant&serviceId=<?php echo $restaurantId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','600px');">+Edit&nbsp;Price</div>
						</td>
				</tr>
				<?php
				}else{
					 
					$rs112=GetPageRecord('*','optionalServicesRateMaster','dmcId=0 and quotationId="'.$quotationData['id'].'" and serviceId="'.$restmasterData['id'].'" and serviceType="Restaurant"');
					if(mysqli_num_rows($rs112)>0){
					$table = 2;
					while($dmcroommastermain=mysqli_fetch_array($rs112)){
					$currencyId = $dmcroommastermain['currencyId'];
					$restaurantId = $dmcroommastermain['serviceId'];
					$adultCost = $dmcroommastermain['adultCost'];
					$childCost = $dmcroommastermain['childCost'];
					$rateId = $dmcroommastermain['id'];
					$editId  = $dmcroommastermain['id'];
					?>

					<tr>
					<td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
					<td align="left"><?php echo clean($restmasterData['mealPlanName']); ?></td>
					<td align="left"><?php echo clean($mealTypeD['name']); ?></td>
					<td align="center"><?php echo getCurrencyName($currencyId).' '.strip($adultCost); ?></td>

					<td align="center"><?php echo getCurrencyName($currencyId).' '.strip($childCost); ?></td>

					<td align="center" valign="middle"><div style="width:65px !important;" class="editbtnselect" id="selectbut<?php echo urlencode($restmasterData['id']); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo $restmasterData['id']; ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

					<div class="editbtnselect" id="selectedbut<?php echo urlencode($restmasterData['id']); ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div>
					</td>

					<td align="center">
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Restaurant&serviceId=<?php echo $restaurantId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','600px');">+Edit&nbsp;Price</div>
					</td>
				</tr>

					<?php
					}		
				 }else{
					?>

				<tr>		
					<td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
					<td align="left"><?php echo clean($restmasterData['mealPlanName']); ?></td>
					<td align="left"><?php echo clean($mealTypeD['name']); ?></td>
					<td align="center">N/A</td>
					<td align="center">N/A</td>
					<td align="center" valign="middle">&nbsp;</td>
					<td align="center">
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Restaurant&serviceId=<?php echo $restmasterData['id']; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>','600px');">+Edit&nbsp;Price</div>
					</td>

				
				</tr>
					<?php 
				}
			}
		} 
			?>
			</tbody>
			</table>
			<?php 

		}elseif($_REQUEST['serviceType']==5){  ?>

			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4" class="tablesorter gridtable"  id="entrancesicTable">
			<thead>
				<tr>
				  <th height="20" align="left"  >&nbsp;#</th>
					<th height="20" align="left" style="border-left:hidden; padding-left:5px;">Additional&nbsp;</th>
					<th height="30" align="center" >Cost Type</th>
					<th height="30" align="center" >Service Cost</th>
					<th height="20" colspan="2" align="center" style="border-left:hidden;">&nbsp;Action</th>
				
				</tr>
			</thead>
			<tbody>
			<?php 
			$dmcMQuery=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,' 1  and status=1 and ( find_in_set("'.$_REQUEST['destinationId'].'", destinationId) or destinationId="All" )');
			if(mysqli_num_rows($dmcMQuery)>0){

			while($dmcAdditionalData=mysqli_fetch_array($dmcMQuery)){

				$rs11=GetPageRecord('*','optionalServicesRateMaster','dmcId="'.$dmcAdditionalData['id'].'" and quotationId="'.$quotationData['id'].'" and serviceType="Additional"');
				if(mysqli_num_rows($rs11)>0){
					$table = 2;
					$dmcroommastermain=mysqli_fetch_array($rs11);
					$currencyId = $dmcroommastermain['currencyId'];
					$additionalId = $dmcroommastermain['serviceId'];
					$adultCost = $dmcroommastermain['adultCost'];
					$childCost = $dmcroommastermain['childCost'];
					$groupCost = $dmcroommastermain['groupCost'];
					$costType = $dmcroommastermain['costType'];
					$rateId = $dmcroommastermain['id'];
					$editId  = $dmcroommastermain['id'];
							
				 }else{
					$table = 1;
					$currencyId = $dmcAdditionalData['currencyId'];
					$adultCost = $dmcAdditionalData['adultCost'];
					$childCost = $dmcAdditionalData['childCost'];
					$groupCost = $dmcAdditionalData['groupCost'];
					$costType = $dmcAdditionalData['costType'];

					$dmcId = $dmcAdditionalData['id'];
					$rateId  = $dmcAdditionalData['id'];
					
					$additionalId = $dmcAdditionalData['id'];
					$mealPlanType = $dmcAdditionalData['mealPlanType'];
				 }

				?>
				<tr>
					<td align="left"><strong><?php echo ++$c1; ?>.</strong></td>
					<td align="left"><?php echo clean($dmcAdditionalData['name']); ?></td>
					<td align="left"><?php if($costType==1){ echo "Per Person"; }else{ echo "Group Cost"; }  ?></td>
					<td align="center"><?php echo getCurrencyName($currencyId); if($costType==1){ echo $adultCost; }else{ echo $groupCost; } ?></td>
	
					<td align="center" valign="middle"><div style="width: 65px !important;" class="editbtnselect" id="selectbut<?php echo urlencode($dmcAdditionalData['id']); ?>" onclick="savesaveSupplimentfun('<?php echo urlencode($rateId); ?>','<?php echo urlencode($_REQUEST['destinationId']); ?>','<?php echo urlencode($_REQUEST['serviceType']); ?>','<?php echo urlencode($table); ?>','<?php echo $dmcAdditionalData['id']; ?>');"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div>

					<div class="editbtnselect" id="selectedbut<?php echo urlencode($dmcAdditionalData['id']); ?>" style="border-radius: 50% !important; display:none;" ><i class="fa fa-check" aria-hidden="true"></i></div>
					</td>
					<td align="center">
						<div class="editbtnselectprice" onclick="openinboundpop('action=editSupplimentServiceCost&dmcId=<?php echo $dmcId;?>&serviceType=Additional&serviceId=<?php echo $additionalId; ?>&quotationId=<?php echo $quotationData['id'] ?>&destinationId=<?php echo $_REQUEST['destinationId']; ?>&tableN=<?php echo $table; ?>&editId=<?php echo $editId; ?>','600px');">+Edit&nbsp;Price</div>
						</td>
				</tr>
				<?php
				} 

				
			}
			?>
			</tbody>
			</table>
			<?php 
		} 
		?>
		<div id="saveSuppliment" style="display:none;"></div>
		<script type="text/javascript">


		function savesaveSupplimentfun(id,destId,serviceType,tableN,serviceId){
			$('#selectbut'+serviceId).hide();
			$('#selectedbut'+serviceId).show();

			$('#saveSuppliment').load('saveSupplimentAcytivities.php?action=savesaveSupplimentdata&id='+id+'&destId='+destId+'&serviceType='+serviceType+'&quotationId=<?php echo encode($_REQUEST['quotationId']); ?>&isAddExp=<?php echo $_REQUEST['isAddExp']; ?>&dayId=<?php echo $_REQUEST['dayId']; ?>&tableN='+tableN);

		}

		function savesaveSupplimentfunNull(activityId,destId,serviceType){
			$('#selectbut'+activityId).hide();
			$('#selectedbut'+activityId).show(); 
			
			var activityCost = Number($('#activityCost'+activityId).val());
			var maxPax = Number($('#maxPax'+activityId).val());
			var perPaxCost = Number($('#perPaxCost'+activityId).val());
			var supplierId = Number($('#supplierId'+activityId).val());
			
			$('#saveSuppliment').load('saveSupplimentAcytivities.php?action=savesaveSupplimentdataNull&add=yes&quotationId=<?php echo encode($_REQUEST['quotationId']); ?>&activityId='+activityId+'&destId='+destId+'&activityCost='+activityCost+'&maxPax='+maxPax+'&perPaxCost='+perPaxCost+'&supplierId='+supplierId+'&serviceType='+serviceType+'&isAddExp=<?php echo $_REQUEST['isAddExp']; ?>&dayId=<?php echo $_REQUEST['dayId']; ?>');
			 
		}

		function addentrancetoquotationsNull(entranceId,serviceType,destId,isClosed){ 
			if(isClosed == 1){
				alert('Entrance is remain closed on every <?php echo date('l', strtotime($dayData['srdate'])); ?>...!');
			}else{

				$('#selectthis'+entranceId).hide();
				$('#selectedthis'+entranceId).show();

				var adultCost = Number($('#adultCostSearchPage'+entranceId).val());
				var childCost = Number($('#childCostSearchPage'+entranceId).val());
				console.log(adultCost,childCost,destId,serviceType,entranceId);

				$('#saveSuppliment').load('saveSupplimentAcytivities.php?action=saveNewSupplimentdata&destId='+destId+'&serviceType='+serviceType+'&quotationId=<?php echo encode($_REQUEST['quotationId']); ?>&isAddExp=<?php echo $_REQUEST['isAddExp']; ?>'+'&adultCost='+adultCost+'&childCost='+childCost+'&entranceId='+entranceId);
			}
		}
		</script>
		</div>
	</div>

	<?php
}




// Add Rate Started 

if($_REQUEST['action']=="saveOptionalServicesCost" && $_REQUEST['supplimentServiceType']!=""){
	
	$quotationId = $_REQUEST['quotationId'];
	$tableN = $_REQUEST['tableN'];
	$editId = $_REQUEST['editId'];

	if($_REQUEST['supplimentServiceType']=="1"){
			$currencyId = $_POST['currencyId'];
			$activity_maxpax = $_POST['activity_maxpax'];
			$dayroe = $_POST['dayroe'];
			$perPaxCost = $_POST['activity_perPaxCost'];
			$dmcId = $_REQUEST['dmcId'];
			$serviceId = $_REQUEST['serviceId'];
			$supplierId = $_REQUEST['supplierId'];
			$activity_gstTax = $_REQUEST['activity_gstTax'];
			$activity_slabId = $_REQUEST['activity_slabId'];
			$remarks = $_REQUEST['remarks'];
		
			if($tableN==2 && $editId!=''){

				$nameValue = 'quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",serviceCost="'.$activityCost.'",perPaxCost="'.$perPaxCost.'",maxpax="'.$activity_maxpax.'",serviceType="Activity",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",currencyValue="'.$dayroe.'",gstTax="'.$activity_gstTax.'",slabId="'.$activity_slabId.'",remarks="'.$remarks.'"';

				$where = 'id="'.$editId.'" and quotationId="'.$quotationId.'" and serviceType="Activity"';
				updatelisting('optionalServicesRateMaster',$nameValue,$where);
			}else{

				$nameValue = 'dmcId="'.$dmcId.'",quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",serviceCost="'.$activityCost.'",perPaxCost="'.$perPaxCost.'",maxpax="'.$activity_maxpax.'",serviceType="Activity",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",currencyValue="'.$dayroe.'",gstTax="'.$activity_gstTax.'",slabId="'.$activity_slabId.'",remarks="'.$remarks.'"';

				addlisting('optionalServicesRateMaster',$nameValue);
			}
		
		}

		if($_REQUEST['supplimentServiceType']=="2"){
			$currencyId = $_POST['currencyId'];
			$guideCost = $_POST['guideCost'];
			$otherCost = $_POST['otherCost'];
			$totalPax = $_POST['totalPax'];
			$dmcId = $_REQUEST['dmcId'];
			$serviceId = $_REQUEST['serviceId'];
			$supplierId = $_REQUEST['supplierId'];
			$paxRange = $_REQUEST['paxRange'];
			$dayType = $_REQUEST['dayType'];
			$universalCost = $_REQUEST['universalCost'];
			$currencyValue = $_REQUEST['currencyValue'];
			$guideGST = $_REQUEST['guideGST'];
			$languageAllowance = $_REQUEST['languageAllowance'];
			$fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
			$toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
			
			if($tableN==2 && $editId!=''){
				$nameValue = 'quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",serviceCost="'.$guideCost.'",perPaxCost="'.$perPaxCost.'",maxpax="'.$totalPax.'",serviceType="Guide",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",gstTax="'.$guideGST.'",currencyValue="'.$currencyValue.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",universalCost="'.$universalCost.'",dayType="'.$dayType.'",paxRange="'.$paxRange.'",languageAllowance="'.$languageAllowance.'",otherCost="'.$otherCost.'"';

				$where = 'id="'.$editId.'" and quotationId="'.$quotationId.'" and serviceType="Guide"';
				updatelisting('optionalServicesRateMaster',$nameValue,$where);
			}else{
				$nameValue = 'dmcId="'.$dmcId.'",quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",serviceCost="'.$guideCost.'",perPaxCost="'.$perPaxCost.'",maxpax="'.$totalPax.'",serviceType="Guide",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",gstTax="'.$guideGST.'",currencyValue="'.$currencyValue.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",universalCost="'.$universalCost.'",dayType="'.$dayType.'",paxRange="'.$paxRange.'",languageAllowance="'.$languageAllowance.'",otherCost="'.$otherCost.'"';

				addlisting('optionalServicesRateMaster',$nameValue);
			}
		
		}


		
		if($_REQUEST['supplimentServiceType']=="3"){
			$currencyId = $_POST['currencyId'];
			$entranceCostA = $_POST['entranceCostA'];
			$entranceCostC = $_POST['entranceCostC'];
			
			$dmcId = $_REQUEST['dmcId'];
			$serviceId = $_REQUEST['serviceId'];
			$tariffType = $_REQUEST['tariffType'];
			$entranceGST = $_REQUEST['entranceGST'];
			$currencyValue = $_REQUEST['currencyValue2'];
			$adultPax = $_REQUEST['adultPax'];
			$childPax = $_REQUEST['childPax'];
			$supplierId = $_REQUEST['supplierId'];
			$remarks = $_REQUEST['remarks'];
			if($tableN==2 && $editId!=''){

				$nameValue = 'quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",adultCost="'.$entranceCostA.'",childCost="'.$entranceCostC.'",maxpax="'.$totalPax.'",serviceType="Entrance",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",currencyValue="'.$currencyValue.'",gstTax="'.$entranceGST.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",tariffType="'.$tariffType.'",remarks="'.$remarks.'"';

				$where = 'id="'.$editId.'" and quotationId="'.$quotationId.'" and serviceType="Entrance"';
				updatelisting('optionalServicesRateMaster',$nameValue,$where);
			}else{

				$nameValue = 'dmcId="'.$dmcId.'",quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",adultCost="'.$entranceCostA.'",childCost="'.$entranceCostC.'",maxpax="'.$totalPax.'",serviceType="Entrance",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",currencyValue="'.$currencyValue.'",gstTax="'.$entranceGST.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",tariffType="'.$tariffType.'",remarks="'.$remarks.'"';

				addlisting('optionalServicesRateMaster',$nameValue);
			}
		
		}


		if($_REQUEST['supplimentServiceType']=="4"){
			$currencyId = $_POST['currencyId'];
			$currencyValue = $_POST['currencyValueR'];
			$supplierId = $_POST['supplierId'];
			$restaurantCostA = $_POST['restaurantCostA'];
			$restaurantCostC = $_POST['restaurantCostC'];
			
			$dmcId = $_REQUEST['dmcId'];
			$serviceId = $_REQUEST['serviceId'];
			$mp_mealPlanType = $_REQUEST['mp_mealPlanType2'];
			$restaurantGST = $_REQUEST['restaurantGST'];
			$adultPax = $_REQUEST['adultPaxR'];
			$childPax = $_REQUEST['childPaxR'];
			$remarks = $_REQUEST['remarks'];
			
			
			if($tableN==2 && $editId!=''){
				$nameValue = 'quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",adultCost="'.$restaurantCostA.'",childCost="'.$restaurantCostC.'",maxpax="'.$totalPax.'",serviceType="Restaurant",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",currencyValue="'.$currencyValue.'",mealType="'.$mp_mealPlanType.'",gstTax="'.$restaurantGST.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",remarks="'.$remarks.'"';

				$where = 'id="'.$editId.'" and quotationId="'.$quotationId.'" and serviceType="Restaurant"';
				updatelisting('optionalServicesRateMaster',$nameValue,$where);
			}else{

				$nameValue = 'dmcId="'.$dmcId.'",quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",adultCost="'.$restaurantCostA.'",childCost="'.$restaurantCostC.'",maxpax="'.$totalPax.'",serviceType="Restaurant",serviceId="'.$serviceId.'",supplierId="'.$supplierId.'",currencyValue="'.$currencyValue.'",mealType="'.$mp_mealPlanType.'",gstTax="'.$restaurantGST.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",remarks="'.$remarks.'"';

				addlisting('optionalServicesRateMaster',$nameValue);
			}
		
		}

		if($_REQUEST['supplimentServiceType']=="5"){
			$currencyId = $_POST['currencyId'];
			$perPersonCost = $_POST['perPersonCostA'];
			$groupCostAD = $_POST['groupCostAD'];
			$costType = $_POST['costType'];
			
			$dmcId = $_REQUEST['dmcId'];
			$serviceId = $_REQUEST['serviceId'];
			$supplierId = $_REQUEST['supplierId'];
			$additionalGST = $_REQUEST['additionalGST'];
			$currencyValue = $_REQUEST['currencyValueAD'];
			if($costType==1){
				$adultPax = $_REQUEST['adultPaxAD'];
			}else{
				$adultPax = $_REQUEST['maxPaxAD'];
				$maxPaxAD = $_REQUEST['maxPaxAD'];
			}
			
			$remarks = $_REQUEST['remarks'];
		
			if($tableN==2 && $editId!=''){
				$nameValue = 'quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",adultCost="'.$perPersonCost.'",groupCost="'.$groupCostAD.'",maxpax="'.$maxPaxAD.'",serviceType="Additional",serviceId="'.$serviceId.'",costType="'.$costType.'",supplierId="'.$supplierId.'",currencyValue="'.$currencyValue.'",gstTax="'.$additionalGST.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",remarks="'.$remarks.'"';

				$where = 'id="'.$editId.'" and quotationId="'.$quotationId.'" and serviceType="Additional"';
				updatelisting('optionalServicesRateMaster',$nameValue,$where);
			}else{

				$nameValue = 'dmcId="'.$dmcId.'",quotationId="'.$quotationId.'",currencyId="'.$currencyId.'",adultCost="'.$perPersonCost.'",groupCost="'.$groupCostAD.'",maxpax="'.$totalPax.'",serviceType="Additional",serviceId="'.$serviceId.'",costType="'.$costType.'",supplierId="'.$supplierId.'",currencyValue="'.$currencyValue.'",gstTax="'.$additionalGST.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",remarks="'.$remarks.'"';

				addlisting('optionalServicesRateMaster',$nameValue);
			}
		
		}

			?>
			<script>
				parent.closeinbound();

				parent.openinboundpop('action=supplimentServiceType&destinationId=1&serviceType=<?php echo $_REQUEST['supplimentServiceType']; ?>&quotationId=<?php echo $quotationId; ?>&isAddExp=1','1200px');
				parent.$("#pageloader").hide();
				parent.$("#pageloading").hide();
			</script>
			<?php

		
}



// Add Rate Enede





// STARTED QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ


// edit optional experiences ------------------
if($_REQUEST['action'] == 'editSupplimentServiceCost' && trim($_REQUEST['serviceId'])!='' ){

	$quotationId = $_REQUEST['quotationId'];
	if($_REQUEST['serviceType']=='Activity'){

		$c121=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$_REQUEST['serviceId'].'" order by id asc');
		$activityDataName=mysqli_fetch_array($c121);
		$activityName=ucwords($activityDataName['otherActivityName']);
		$serviceId=$activityDataName['id'];

	}

	if($_REQUEST['serviceType']=='Guide'){

		$c121=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$_REQUEST['serviceId'].'" order by id asc');
		$activityDataName=mysqli_fetch_array($c121);
		$activityName=ucwords($activityDataName['name']);
		$serviceId=$activityDataName['id'];
	}

	if($_REQUEST['serviceType']=='Entrance'){

		
			$c121=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$_REQUEST['serviceId'].'" ');
			$activityDataName=mysqli_fetch_array($c121);
			$activityName=ucwords($activityDataName['entranceName']);	
			$serviceId = $activityDataName['id'];
	}

	if($_REQUEST['serviceType']=='Restaurant'){

		$mealpQuery='';
		$mealpQuery=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,' id="'.$_REQUEST['serviceId'].'"'); 
		$activityDataName=mysqli_fetch_array($mealpQuery);	
		$activityName=ucwords($activityDataName['mealPlanName']);
		$serviceId=$activityDataName['id'];
	}

	if($_REQUEST['serviceType']=='Additional'){

		$c121=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,' 1 and id="'.$_REQUEST['serviceId'].'"');
		$activityDataName=mysqli_fetch_array($c121);
		$activityName=ucwords($activityDataName['name']);
		$serviceId=$activityDataName['id'];
	
	}
	?>

 	<div class="inboundheader" style="position:relative;">Edit <?php echo $_REQUEST['serviceType']; ?> Service <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox" class="contentdiv">
		<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
		<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;">
			<label style="background: #4d94ff;color: white;">#<?php echo $activityName; ?></label>
		</div>
		<form action="inboundpop.php" method="POST" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
  			
    			<td style="display:none;">
    				<div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Service&nbsp;Type</div>
							<select id="supplimentServiceType" name="supplimentServiceType" class="gridfield " autocomplete="off" >
							<?php if($_REQUEST['serviceType']=='Activity'){ ?><option value="1">Activity</option><?php } ?>
							<?php if($_REQUEST['serviceType']=='Guide'){ ?><option value="2">Guide</option><?php } ?>
							<?php if($_REQUEST['serviceType']=='Entrance'){ ?><option value="3">Entrance</option><?php } ?>
							<?php if($_REQUEST['serviceType']=='Restaurant'){ ?><option value="4">Restaurant</option><?php } ?>
							<?php if($_REQUEST['serviceType']=='Additional'){ ?><option value="5">Additional</option><?php } ?>
							</select>
						</label>
				    </div>
				</td>
    			<!-- <td>
    				<div class="griddiv" style="position:static;">
						<label> <div class="gridlable" style="width:100%;">Service Name</div>
							<input  name="activityName" type="text" id="activityName" class="gridfield" readonly=""  value="<?php echo $activityName; ?>" readonly="" >
						</label>
			    	</div>
				</td> -->

				<?php if($_REQUEST['serviceType']=="Activity"){
					
					if($_REQUEST['tableN']==2 && $_REQUEST['editId']!=''){
						$rs1 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['editId'].'" and serviceType="Activity"');
						$quoterateData = mysqli_fetch_assoc($rs1);

						$table=2;
						
						$supplierId = $quoterateData['supplierId'];
						$currencyId = $quoterateData['currencyId'];
						$activityCost = $quoterateData['serviceCost'];
						$maxpax = $quoterateData['maxpax'];
						$perPaxCost = $quoterateData['perPaxCost'];
						$serviceId = $quoterateData['serviceId'];
						$editId  = $quoterateData['id'];
						$slabId = $quoterateData['slabId'];
						$gstTaxId = $quoterateData['gstTaxId'];
						$currencyValue = $quoterateData['currencyValue'];
					}

					if($_REQUEST['tableN']==1 && $_REQUEST['dmcId']!=''){
						$rs1 = GetPageRecord('*','dmcotherActivityRate','id="'.$_REQUEST['dmcId'].'"');
						$quoterateData = mysqli_fetch_assoc($rs1);

						$table=1;
						$supplierId = $quoterateData['supplierId'];
						$currencyId = $quoterateData['currencyId'];
						$activityCost = $quoterateData['activityCost'];
						$maxpax = $quoterateData['maxpax'];
						$perPaxCost = $quoterateData['perPaxCost'];
						$serviceId = $quoterateData['otherActivityNameId'];
						$slabId = $quoterateData['slabId'];
						$gstTaxId = $quoterateData['gstTaxId'];
						$currencyValue = $quoterateData['currencyValue'];
					}
					
				?>
				<tr>
					<td colspan="2"><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Supplier</div>
						<select name="supplierId" class="gridfield" id="supplierId">
						<?php 	$rsaa=GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 and deletestatus=0 and name!="" and activityType=3 order by name asc');
							while($suppData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $suppData['id'] ?>" <?php if($supplierId==$suppData['id']){ echo "selected"; } ?>><?php echo $suppData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td>

					<td><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Currency</div>
						<select name="currencyId" class="gridfield" id="currencyId" onchange="getROE(this.value,'currncyValue');" >
						<?php 	
						
						$currencyValue = getCurrencyVal($currencyId);
						
						$rsaa=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
							while($currencyData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $currencyData['id'] ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td> 

				<td><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">R.O.E</div>
							<input  name="dayroe" type="number" id="currncyValue" class="gridfield" onkeyup="numericFilter(this);"  value="<?php echo $currencyValue; ?>" >
						</label>
			    	</div>
				</td>
				</tr>

				<tr>


				<td width="200" align="left" colspan="2">
					<div class="griddiv">
						<label>   
							<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="5" cellspacing="0"  >
								<tr><td colspan="2" align="center">Activity&nbsp;Cost</td></tr>  
								<tr><td align="center">Per&nbsp;Pax&nbsp;Cost</td><td align="center">NO.&nbsp;Pax</td></tr> 
								<tr>
									<td>
										<input name="activity_perPaxCost" type="text" class="gridfield"  id="activity_perPaxCost" value="<?php echo $perPaxCost; ?>" maxlength="6" onkeyup="numericFilter(this);" />
									</td>
									<td>
										<input name="activity_maxpax" type="text" class="gridfield"  id="activity_maxpax" value="<?php echo $maxpax ?>" maxlength="6" onkeyup="numericFilter(this);" />
									</td>
								</tr>
							</table>
						</label>
					</div>
				</td> 

				<td width="100" align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable">TAX&nbsp;SLAB(%)</div>
							<select id="activity_gstTax" name="activity_gstTax" class="gridfield" displayname="Tax Slab" autocomplete="off" style="width: 100%;">
								<?php
								$rs2 = "";
								$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Activity"');
								while ($gstSlabData = mysqli_fetch_array($rs2)) { ?>
									<option value="<?php echo $gstSlabData['id']; ?>" <?php if($gstTaxId == $gstSlabData['id']){?> selected="selected" <?php }elseif($gstSlabData['setDefault']=='1'){ ?> selected="selected" <?php }?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
									<?php
								}
								?>
							</select>
						</label>
					</div>
				</td>  
				
				<td width="100" align="left">
					<div class="griddiv">
						<label>  
						<div class="gridlable">Pax&nbsp;Range</div>
						<select id="activity_slabId"  name="activity_slabId" class="gridfield " >
							<option value="0">All Pax</option>
							<?php
							$totalPaxDataq=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
							while($totalPaxData=mysqli_fetch_array($totalPaxDataq)){
								if($totalPaxData['fromRange']==$totalPaxData['toRange']){
									$paxName=$totalPaxData['fromRange'].' Pax';
								}else{
									$paxName=$totalPaxData['fromRange'].'-'.$totalPaxData['toRange'].' Pax';
								} 
								?> 
								<option value="<?php echo $totalPaxData['id']; ?>" <?php if($totalPaxData['id']==$slabId){ ?>selected="selected"<?php } ?>><?php echo $paxName; ?></option>
								<?php 
							} ?>
						</select>
						</label>
					</div>
				</td>  

			
				</tr>
    			<td colspan="3"><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Remark</div>
							<input  name="remarks" type="text" id="remarks" class="gridfield"  value="<?php echo $quoterateData['remarks']; ?>" >
						</label>
			    	</div>
				</td>
				
				<!-- <script>
					function divideperpaxCost(){
						var activityCost = Number($("#activityCost").val());
						var totalPax = Number($("#totalPax").val());
						var perpaxCost = activityCost/totalPax;
						$("#perPaxCost").val(perpaxCost);
					}
				</script> -->

			<?php } ?>

			<?php if($_REQUEST['serviceType']=="Guide"){
					
					if($_REQUEST['tableN']==2 && $_REQUEST['editId']!=''){
						$rs112 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['editId'].'" and serviceType="Guide"');
						
						$table=2;
						$dmcroommastermain=mysqli_fetch_array($rs112);
						$currencyId = $dmcroommastermain['currencyId'];
						$serviceId = $dmcroommastermain['serviceId'];
						$guideCost = $dmcroommastermain['serviceCost'];
						$editId  = $dmcroommastermain['id'];
						$destinationId  = $dmcroommastermain['destinationId'];
						$fromDate  = $dmcroommastermain['fromDate'];
						$toDate  = $dmcroommastermain['toDate'];
						$pax  = $dmcroommastermain['paxRange'];
						$currencyValue  = $dmcroommastermain['currencyValue'];
				
					}

					if($_REQUEST['tableN']==1 && $_REQUEST['dmcId']!=''){
						$rs1 = GetPageRecord('*','dmcGuidePorterRate','id="'.$_REQUEST['dmcId'].'"');
						
						$dmcroommastermain=mysqli_fetch_array($rs1);
						$table=1;
						$currencyId = $dmcroommastermain['currencyId'];
						$serviceId = $dmcroommastermain['serviceid'];
						$guideCost = $dmcroommastermain['price'];
						$destinationId  = $dmcroommastermain['destinationId'];
						$fromDate  = $dmcroommastermain['fromDate'];
						$toDate  = $dmcroommastermain['toDate'];
						$pax  = $dmcroommastermain['paxRange'];
						$currencyValue  = $dmcroommastermain['currencyValue'];
					
					
					}
					
				?>
					<tr>
					<td width="100" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Supplier</div>
						<select name="supplierId" class="gridfield" id="supplierId">
						<?php 
						$where='status=1 and deletestatus=0 and name!="" and guideType=2 and FIND_IN_SET("'.$destinationId.'",destinationId) order by name asc';
						$rsaa=GetPageRecord('*',_SUPPLIERS_MASTER_,$where);
							while($suppData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $suppData['id'] ?>" <?php if($supplierId==$suppData['id']){ echo "selected"; } ?>><?php echo $suppData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td>

				<td width="100" align="left" class="tourEscort_cls"><div class="griddiv">
				<label>
				<div class="gridlable">Rate&nbsp;Valid&nbsp;From <span class="redmind"></span></div>
				<input name="fromDate" type="text" id="fromDate"  class="gridfield calfieldicon validate"  displayname="Rate Valid From"   autocomplete="off" value="<?php if($dmcroommastermain['fromDate']!=''){ echo date('d-m-Y',strtotime($dmcroommastermain['fromDate'])); }else{ echo date('d-m-Y',strtotime('now'));} ?>"  style="width: 100%;" />
				</label>
				</div></td>

				<td width="100" align="left" class="tourEscort_cls"><div class="griddiv">
				<label>
				<div class="gridlable">Rate&nbsp;Valid&nbsp;To<span class="redmind"></span>  </div>
				<input name="toDate" type="text" id="toDate" class="gridfield calfieldicon validate" displayname="Rate Valid To" autocomplete="off" value="<?php if($dmcroommastermain['toDate']!=''){ echo date('d-m-Y',strtotime($dmcroommastermain['toDate'])); }else{ echo date('d-m-Y',strtotime('now')); }?>" style="width: 100%;"/>
				</label>
				</div></td>

				<script src="js/jquery-3.6.0.min.js"></script> 
				<script src="js/zebra_datepicker.js"></script>
				<script type="text/javascript">
					$(function() {
						$('#toDate').Zebra_DatePicker({ 
						format: 'd-m-Y', 
					});
					});

					$(function(){
					$('#fromDate').Zebra_DatePicker({ 
						format: 'd-m-Y',  
						pair: $('#toDate'),
					});
					});

					comtabopenclose('linkbox', 'op2');


				</script>

				<td width="100" align="left"  class="tourEscort_cls">
				<div class="griddiv">
					<label>
						<div class="gridlable">Pax&nbsp;Range<span class="redmind"></span></div>
						<select id="paxRange" name="paxRange" class="gridfield " autocomplete="off" >
							<option value="0" >All Pax</option>
							<option value="1_5" <?php if($pax >= 1 && $pax <= 5){ ?>selected="selected"<?php } ?>>1-5 Pax</option>
							<option value="6_14" <?php if($pax >= 6 && $pax <= 14){ ?>selected="selected"<?php } ?>>6-14 Pax</option>
							<option value="15_40" <?php if($pax >= 15 && $pax <= 40){ ?>selected="selected"<?php } ?>>15-40 Pax</option>
						</select>
					</label>
				</div>
			</td>

			<td width="100" align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable">Day&nbsp;Type<span class="redmind"></span></div>
						<select id="dayType" name="dayType" class="gridfield " displayname="Day Type" autocomplete="off" >  
							<option value="halfday" <?php if($dmcroommastermain['dayType']==='halfday'){ ?> selected="selected" <?php } ?> >Half Day</option>  
							<option value="fullday" <?php if($dmcroommastermain['dayType']==='fullday'){ ?> selected="selected" <?php } ?> >Full Day</option> 
						</select>
					</label>
				</div></td> 


				<td width="100" align="left" >
				<div class="griddiv">
					<label>
						<div class="gridlable">Universal&nbsp;Cost<span class="redmind"></span></div>
						<select id="universalCost" name="universalCost" class="gridfield " autocomplete="off" onchange="showGuide(this.value);"  >
							<option value="0" <?php if($dmcroommastermain['universalCost']==0){ echo "selected"; } ?>>Yes</option>
							<option value="1" <?php if($dmcroommastermain['universalCost']==1){ echo "selected"; } ?>>No</option> 						
						</select> 
					</label>
				</div></td>

			</tr>
			<tr>
					<td><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Currency</div>
						<select name="currencyId" class="gridfield" id="currencyId"  onchange="getROE(this.value,'currencyVal124');">
						<?php 	$rsaa=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
							while($currencyData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $currencyData['id'] ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td> 

    			<td width="100"  align="left">
				<div class="griddiv" >
				<label> 
					<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input class="gridfield validate" name="currencyValue" displayname="ROI Value"  id="currencyVal124" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
				</label>
				</div>
			</td>

			<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable" id="guidLable" style="width:100%;">Guide Cost</div>
				<input name="guideCost" type="text" class="gridfield" id="guideCost" value="<?php echo $guideCost; ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>

			<td width="100" align="left" class="tourEscort_cls"><div class="griddiv"><label>
				<div class="gridlable">L.A.</div>
				<input name="languageAllowance" type="text" class="gridfield"  id="languageAllowance" value="<?php echo $dmcroommastermain['languageAllowance'] ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td>

			<td width="100" align="left" class="tourEscort_cls"><div class="griddiv"><label>
				<div class="gridlable" style="width:100%;">Other Cost</div>
				<input name="otherCost" type="text" class="gridfield"  id="otherCost" value="<?php echo $dmcroommastermain['otherCost']; ?>" maxlength="6" onkeyup="numericFilter(this);" />
				</label>
				</div>
			</td> 
			<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">GST&nbsp;SLAB(%)</div>
				<select id="guideGST" name="guideGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;">
					<?php
					$rs2 = "";
					$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Guide"');
					while ($gstSlabData = mysqli_fetch_array($rs2)) {
						if($dmcroommastermain['gstTax']!=''){
							$setDefault = $gstSlabData['id']==$dmcroommastermain['gstTax'];
						}else{
							$setDefault = $gstSlabData['setDefault']=='1';
						}
						
					?>
					<option value="<?php echo $gstSlabData['id']; ?>" <?php if($setDefault){ ?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
					<?php
					}
					?>
	      		</select>
				</label>
				</div>
			</td>  
				</tr>
			<?php } ?>


			<?php if($_REQUEST['serviceType']=="Entrance"){
					
					if($_REQUEST['tableN']==2 && $_REQUEST['editId']!=''){
						$rs1 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['editId'].'" and serviceType="Entrance"');
						$quoterateData = mysqli_fetch_assoc($rs1);

						$table=2;
						
						$supplierId = $quoterateData['supplierId'];
						$currencyId = $quoterateData['currencyId'];
						$ticketAdultCost = $quoterateData['adultCost'];
						$ticketchildCost = $quoterateData['childCost'];
						$gstTax = $quoterateData['gstTax'];
						$serviceId = $quoterateData['serviceId'];
						$editId  = $quoterateData['id'];
						$currencyValue = $quoterateData['currencyValue'];
						$tariffType = $quoterateData['tariffType'];
					}

					if($_REQUEST['tableN']==1 && $_REQUEST['dmcId']!=''){
						$rs1 = GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,'id="'.$_REQUEST['dmcId'].'"');
						$quoterateData = mysqli_fetch_assoc($rs1);

						$table=1;
						$supplierId = $quoterateData['supplierId'];
						$currencyId = $quoterateData['currencyId'];
						$ticketAdultCost = $quoterateData['ticketAdultCost'];
						$ticketchildCost = $quoterateData['ticketchildCost'];
						$perPaxCost = $quoterateData['perPaxCost'];
						$serviceId = $quoterateData['otherActivityNameId'];
						$gstTax = $quoterateData['gstTax'];
						$currencyValue = $quoterateData['currencyValue'];
						$tariffType = $quoterateData['tariffType'];
					}
					
				?>
					<tr>
					<td  width="100" colspan="2" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Supplier</div>
						<select name="supplierId" class="gridfield" id="supplierId">
						<?php 
						
						$rsaa=GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 and deletestatus=0 and name!="" and  ( entranceType=4 or entranceType=1 ) order by name asc');
							while($suppData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $suppData['id'] ?>" <?php if($supplierId==$suppData['id']){ echo "selected"; } ?>><?php echo $suppData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td>

				<td  width="100" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Tariff&nbsp;Type</div>
						<select name="tariffType" class="gridfield" id="tariffType">
						<option value="1" <?php if($tariffType==1){ echo "selected"; } ?>>Normal</option>
						<option value="2" <?php if($tariffType==2){ echo "selected"; } ?>>Weekend</option>
						</select>
						
						</label>
			    	</div>
				</td>

				<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">GST&nbsp;SLAB(%)</div>
				<select id="entranceGST" name="entranceGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;">
					<?php
					$rs2 = "";
					$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Guide"');
					while ($gstSlabData = mysqli_fetch_array($rs2)) {
						if($gstTax!=''){
							$setDefault = $gstSlabData['id']==$gstTax;
						}else{
							$setDefault = $gstSlabData['setDefault']=='1';
						}
						
					?>
					<option value="<?php echo $gstSlabData['id']; ?>" <?php if($setDefault){ ?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
					<?php
					}
					?>
	      		</select>
				</label>
				</div>
			</td> 
			</tr>
			<tr>
					<td width="100" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Currency</div>
						<select name="currencyId" class="gridfield" id="currencyId" onchange="getROE(this.value,'currencyVal126');" >
						<?php 	$rsaa=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
							while($currencyData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $currencyData['id'] ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td> 

				<td width="50"  align="left"><div class="griddiv">
				<label> 
				<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
				<input class="gridfield validate" name="currencyValue2" displayname="ROI Value"  id="currencyVal126" value="<?php echo trim($currencyValue); ?>" style="display:inline-block;" >
				</label>
				</div>
			</td>


			<td width="100" align="left">
				<div class="griddiv">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="5" cellspacing="0"  >
							<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="entranceCostA" type="text" class="gridfield"  id="entranceCostA" value="<?php echo $ticketAdultCost; ?>"  onkeyup="numericFilter(this);" />
								</td>
								
								<td>
									<input name="adultPax" type="text" class="gridfield"  id="adultPax" value="<?php echo $quoterateData['adultPax']; ?>"  onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="5" cellspacing="0"  >
							<tr><td colspan="2" align="center">Child Ticket</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="entranceCostC" type="text" class="gridfield"  id="entranceCostC" value="<?php echo $ticketchildCost; ?>"  onkeyup="numericFilter(this);" />
								</td>
								<td>
									<input name="childPax" type="text" class="gridfield"  id="childPax" value="<?php echo $quoterateData['childPax'] ?>"  onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>
		
	
				</tr>
				<td colspan="3"><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Remark</div>
							<input  name="remarks" type="text" id="remarks" class="gridfield"  value="<?php echo $quoterateData['remarks']; ?>" >
						</label>
			    	</div>
				</td>
			<?php } ?>


			<?php if($_REQUEST['serviceType']=="Restaurant"){
					
					if($_REQUEST['tableN']==2 && $_REQUEST['editId']!=''){
						$rs1 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['editId'].'" and serviceType="Restaurant"');
						$quoterateData = mysqli_fetch_assoc($rs1);
						$table=2;
						$currencyId = $quoterateData['currencyId'];
						$supplierId = $quoterateData['supplierId'];
						$adultCost = $quoterateData['adultCost'];
						$childCost = $quoterateData['childCost'];
						$serviceId = $quoterateData['serviceId'];
						$editId  = $quoterateData['id'];
				
					}

					if($_REQUEST['tableN']==1 && $_REQUEST['dmcId']!=''){
						$rs1 = GetPageRecord('*','dmcRestaurantsMealPlanRate','id="'.$_REQUEST['dmcId'].'"');
						$quoterateData = mysqli_fetch_assoc($rs1);

						$table=1;
						$currencyId = $quoterateData['currencyId'];
						$adultCost = $quoterateData['adultCost'];
						$childCost = $quoterateData['childCost'];
						$serviceId = $quoterateData['restaurantId'];
						$supplierId = $quoterateData['supplierId'];
					}
					
				?>

			<tr>
					<td  width="100" colspan="2" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Supplier</div>
						<select name="supplierId" class="gridfield" id="supplierId">
						<?php 
						
						$rsaa=GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 and deletestatus=0 and name!="" and ( mealType=6 or mealType=1 ) order by name asc');
							while($suppData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $suppData['id'] ?>" <?php if($supplierId==$suppData['id']){ echo "selected"; } ?>><?php echo $suppData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td>

				<td width="100" align="left"><div class="griddiv">
							<label>
							<div class="gridlable">Meal&nbsp;Type</div>
							<select id="mp_mealPlanType2" name="mp_mealPlanType2" class="gridfield validate" displayname="Meal Type" autocomplete="off" >
								<option value="">Select</option>
								<?php 
								$rs='';    
								$rs=GetPageRecord('*',_PACKAGE_BUILDER_RESTAURANT_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
								while($mealTypeD=mysqli_fetch_array($rs)){   
								?>
								<option value="<?php echo $mealTypeD['id']; ?>"  <?php if($mealTypeD['id']==$quoterateData['mealType']){ ?>selected="selected"<?php } ?>><?php echo $mealTypeD['name']; ?></option>
								<?php } ?>
							</select>
							</label>
							</div>
						</td>

				<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">GST&nbsp;SLAB(%)</div>
				<select id="restaurantGST" name="restaurantGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;">
					<?php
					$rs2 = "";
					$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Guide"');
					while ($gstSlabData = mysqli_fetch_array($rs2)) {
						if($quoterateData['gstTax']!=''){
							$setDefault = $gstSlabData['id']==$quoterateData['gstTax'];
						}else{
							$setDefault = $gstSlabData['setDefault']=='1';
						}
						
					?>
					<option value="<?php echo $gstSlabData['id']; ?>" <?php if($setDefault){ ?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
					<?php
					}
					?>
	      		</select>
				</label>
				</div>
			</td> 
			</tr>
			<tr>
					<td width="100" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Currency</div>
						<select name="currencyId" class="gridfield" id="currencyId" onchange="getROE(this.value,'currencyVal127');" >
						<?php 	$rsaa=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
							while($currencyData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $currencyData['id'] ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td> 

				<td width="50"  align="left"><div class="griddiv">
				<label> 
				<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
				<input class="gridfield validate" name="currencyValueR" displayname="ROI Value"  id="currencyVal127" value="<?php echo trim($quoterateData['currencyValue']); ?>" style="display:inline-block;" >
				</label>
				</div>
			</td>


			<td width="100" align="left">
				<div class="griddiv">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="5" cellspacing="0"  >
							<tr><td colspan="2" align="center">Adult Ticket</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="restaurantCostA" type="text" class="gridfield"  id="restaurantCostA" value="<?php echo $quoterateData['adultCost']; ?>"  onkeyup="numericFilter(this);" />
								</td>
								
								<td>
									<input name="adultPaxR" type="text" class="gridfield"  id="adultPaxR" value="<?php echo $quoterateData['adultPax']; ?>"  onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>
			<td width="100" align="left">
				<div class="griddiv">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="5" cellspacing="0"  >
							<tr><td colspan="2" align="center">Child Cost</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="restaurantCostC" type="text" class="gridfield"  id="restaurantCostC" value="<?php echo $quoterateData['childCost']; ?>"  onkeyup="numericFilter(this);" />
								</td>
								<td>
									<input name="childPaxR" type="text" class="gridfield"  id="childPaxR" value="<?php echo $quoterateData['childPax']; ?>"  onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>

	
				</tr>
				<td colspan="3"><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Remark</div>
							<input  name="remarks" type="text" id="remarks" class="gridfield"  value="<?php echo $quoterateData['remarks']; ?>" >
						</label>
			    	</div>
				</td> 

			<?php } ?>

			
			<?php if($_REQUEST['serviceType']=="Additional"){
					
					if($_REQUEST['tableN']==2 && $_REQUEST['editId']!=''){
						$rs1 = GetPageRecord('*','optionalServicesRateMaster','id="'.$_REQUEST['editId'].'" and serviceType="Additional"');
						$quoterateData = mysqli_fetch_assoc($rs1);
						$table=2;
						$currencyId = $quoterateData['currencyId'];
						$adultCost = $quoterateData['adultCost'];
						$childCost = $quoterateData['childCost'];
						$groupCost = $quoterateData['groupCost'];
						$costType = $quoterateData['costType'];
						$serviceId = $quoterateData['serviceId'];
						$editId  = $quoterateData['id'];
						$supplierId = $quoterateData['supplierId'];
				
					}

					if($_REQUEST['tableN']==1 && $_REQUEST['dmcId']!=''){
						$rs1 = GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,'id="'.$_REQUEST['dmcId'].'"');
						$quoterateData = mysqli_fetch_assoc($rs1);

						$table=1;
						$currencyId = $quoterateData['currencyId'];
						$adultCost = $quoterateData['adultCost'];
						$childCost = $quoterateData['childCost'];
						$groupCost = $quoterateData['groupCost'];
						$costType = $quoterateData['costType'];
						$serviceId = $quoterateData['id'];
						$supplierId = $quoterateData['supplierId'];
					}
					
				?>

				
				<tr>
					<td  width="100" colspan="2" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Supplier</div>
						<select name="supplierId" class="gridfield" id="supplierId">
						<?php 
						
						$rsaa=GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 and deletestatus=0 and name!="" and ( mealType=6 or mealType=1 ) order by name asc');
							while($suppData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $suppData['id'] ?>" <?php if($supplierId==$suppData['id']){ echo "selected"; } ?>><?php echo $suppData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td>

				<td><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Cost&nbsp;Type</div>
							<select name="costType" id="costType" onchange="selectCostType();">
								<option value="1" <?php if($costType==1){ echo "selected"; } ?>>Per Person Cost</option>
								<option value="2" <?php if($costType==2){ echo "selected"; } ?>>Group Cost</option>
							</select>
						</label>
			    	</div>
				</td> 

				<td width="100" align="left"><div class="griddiv"><label>
				<div class="gridlable">GST&nbsp;SLAB(%)</div>
				<select id="additionalGST" name="additionalGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;">
					<?php
					$rs2 = "";
					$rs2 = GetPageRecord('*', 'gstMaster', ' 1 and status=1 and serviceType="Guide"');
					while ($gstSlabData = mysqli_fetch_array($rs2)) {
						if($quoterateData['gstTax']!=''){
							$setDefault = $gstSlabData['id']==$quoterateData['gstTax'];
						}else{
							$setDefault = $gstSlabData['setDefault']=='1';
						}
						
					?>
					<option value="<?php echo $gstSlabData['id']; ?>" <?php if($setDefault){ ?> selected="selected" <?php } ?> ><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
					<?php
					}
					?>
	      		</select>
				</label>
				</div>
			</td> 
			</tr>
			<tr>
					<td width="100" ><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Currency</div>
						<select name="currencyId" class="gridfield" id="currencyId" onchange="getROE(this.value,'currencyVal127');" >
						<?php 	$rsaa=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
							while($currencyData=mysqli_fetch_array($rsaa)){
								?>
								<option value="<?php echo $currencyData['id'] ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name'] ?></option>
								<?php
							} ?>
							</select>
						
						</label>
			    	</div>
				</td> 

				<td width="50"  align="left"><div class="griddiv">
				<label> 
				<div class="gridlable">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
				<input class="gridfield validate" name="currencyValueAD" displayname="ROI Value"  id="currencyVal127" value="<?php echo trim($quoterateData['currencyValue']); ?>" style="display:inline-block;" >
				</label>
				</div>
			</td>


			<td width="100" align="left" id="perPersonId">
				<div class="griddiv">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="5" cellspacing="0"  >
							<tr><td colspan="2" align="center">Per Person Cost</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input name="perPersonCostA" type="text" class="gridfield"  id="perPersonCostA" value="<?php echo $quoterateData['adultCost']; ?>"  onkeyup="numericFilter(this);" />
								</td>
								
								<td>
									<input name="adultPaxAD" type="text" class="gridfield"  id="adultPaxAD" value="<?php echo $quoterateData['adultPax']; ?>"  onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>
			<td width="100" align="left" id="groupCostId">
				<div class="griddiv">
					<label>  
						<table border="0" style="border-color: #d4ebff;" bgColor="#d4ebff" cellpadding="5" cellspacing="0"  >
							<tr><td colspan="2" align="center">Group Cost</td></tr>  
							<tr><td align="center">Cost</td><td align="center">Pax</td></tr> 
							<tr>
								<td>
									<input  name="groupCostAD" type="number" id="groupCostAD" class="gridfield" onkeyup="numericFilter(this);"  value="<?php echo $groupCost; ?>" >
								</td>
								<td>
									<input name="maxPaxAD" type="text" class="gridfield"  id="maxPaxAD" value="<?php echo $quoterateData['adultPax']; ?>"  onkeyup="numericFilter(this);" />
								</td>
							</tr>
						</table> 
					</label>
				</div>
			</td>

	
				</tr>
				<td colspan="3"><div class="griddiv" style="position:static;">
						<label> <div class="gridlable">Remark</div>
							<input  name="remarks" type="text" id="remarks" class="gridfield"  value="<?php echo $quoterateData['remarks']; ?>" >
						</label>
			    	</div>
				</td> 


				<script>
					function selectCostType(){
						var costType = Number($("#costType").val());

						if(costType==1){
							$("#perPersonId").show();
							$("#groupCostId").hide();
						}

						if(costType==2){
							$("#perPersonId").hide();
							$("#groupCostId").show();
						}
					}

					selectCostType();
				</script>

			<?php } ?>

			<input type="hidden" name="quotationId" id="quotationId" value="<?php echo $_REQUEST['quotationId']; ?>">
			<input type="hidden" name="dmcId" id="dmcId" value="<?php echo $_REQUEST['dmcId']; ?>">
			<input type="hidden" name="serviceId" id="serviceId" value="<?php echo $serviceId; ?>">
			<input type="hidden" name="tableN" id="tableN" value="<?php echo $_REQUEST['tableN']; ?>">
			<input type="hidden" name="editId" id="editId" value="<?php echo $_REQUEST['editId']; ?>">
			<input type="hidden" name="action" id="action" value="saveOptionalServicesCost">
				<td>
					<input name="Submit" type="button" class="blackbutton" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_hoteltomaster','submitbtn','0');">
					
				</td>
  			</tr>
		</table>
		</form>
		
	</div>
	<?php
} 



// ENDED QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ

// quotation Overview not in use this block
if($_REQUEST['action'] == 'Itineraryoverview' && trim($_REQUEST['overviewNameId'])!='' && trim($_REQUEST['quotationId'])!=''){


	$rso=GetPageRecord('*',_OVERVIEW_MASTER_,' id="'.trim($_REQUEST['overviewNameId']).'" order by id asc');
	$resListingo=mysqli_fetch_array($rso);

	$rsq=GetPageRecord('*','quotationOverview',' quotationId="'.trim($_REQUEST['quotationId']).'" and overviewNameId="'.trim($_REQUEST['overviewNameId']).'"order by id asc');
	$editoverview=mysqli_fetch_array($rsq);

	?>

	<script type="text/javascript">
		// addTinyMCE(); 
	</script>

 	<div class="inboundheader" style="position:relative;background-color: #3b4fb5;color:#fff; ">Overview/ Inc&Exc/ T&C <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinboundoverview();"></i></div>

	<div style="padding:10px;" id="hotelBox">
		<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
   <div id="detailBox">	 
   <div style="text-align: center;padding: 10px 0;font-size: 14px;"> Do you want to save the Data </div>      
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr style="display: none;">
		<td width="50%"><div style="font-size:12px;">Highlight</div>
			<?php if($_REQUEST['languageType'] == "0") { ?>	
			<input name="itiSubject" type="text" id="itiSubject"  style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;"  value="<?php if(!empty($editoverview['highlight'])){ echo $editoverview['highlight']; }else{ echo stripslashes($resListingo['highlight']); } ?>"  >
			<?php } else { 
			$rsql=GetPageRecord('*','overviewLanguageMaster','overviewId="'.trim($_REQUEST['overviewNameId']).'" and languageId="'.trim($_REQUEST['languageType']).'"');
			$lanoverview=mysqli_fetch_array($rsql);	
			?>
				<input name="itiSubject" type="text" id="itiSubject"  style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;"  value="<?php if(!empty($lanoverview['highlight'])){ echo $lanoverview['highlight']; }else{ echo stripslashes($lanoverview['highlight']); } ?>"  >
		<?php } ?>
		</td>
	  </tr>
	  <tr style="display: none;">
		<td>
			<div style="font-size:12px;">Overview</div>
			<?php if($_REQUEST['languageType'] == "0") { ?>	
			<textarea name="itiOverview" class="textEditor" rows="5" id="itiOverview" style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;box-shadow:none;"  placeholder="Remark"><?php if(!empty($editoverview['overview'])) { echo $editoverview['overview']; }else{ echo stripslashes($resListingo['overview']);} ?></textarea> 
			<?php } else { 
				$rsql=GetPageRecord('*','overviewLanguageMaster','overviewId="'.trim($_REQUEST['overviewNameId']).'" and languageId="'.trim($_REQUEST['languageType']).'"');
				$lanoverview=mysqli_fetch_array($rsql); 
				?>
				<textarea name="itiOverview" class="textEditor" rows="5" id="itiOverview" style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;box-shadow:none;"  placeholder="Remark"><?php echo stripslashes($lanoverview['overview']); ?></textarea>	
			 
			<?php } ?>
	  	 </td>
	  </tr>
		 <tr>
		<td>

		<input  type="button" class="whitembutton"  value="&nbsp;Close&nbsp;" onclick="closeinboundoverview();" style=" margin: 0; ">&nbsp;
		<input name="Save" type="button" class="whitembutton submitBtn" id="Save" value="&nbsp;Save&nbsp;" onclick="saveitineraryoverview('<?php echo $editoverview['id']; ?>');" style="background-color: #3b4fb5 !important;margin: 0;color: white;">
        &nbsp;
        <span id="msgShow" style="color:green;display:none;">Successfully Added.</span>

 		 </td>
		</tr>
	</table>
	</div>
	    <script type="text/javascript">
	    
	    	function saveitineraryoverview(id){
				var itiSubject = $('#itiSubject').val();
				var itiOverview = $('#itiOverview').val(); 
				var saveitineraryoverview = 'saveitineraryoverview';
				$.ajax({
					type: "POST",
					url: 'frmaction.php',
					data: {highlight: itiSubject,editId: id, overview: itiOverview, isAddOverview: '<?php echo $_REQUEST['isAddOverview']; ?>',overviewNameId: '<?php echo $_REQUEST['overviewNameId']; ?>', action: saveitineraryoverview, quotationId: '<?php echo $_REQUEST['quotationId']; ?>'},
					success: function(data){ 
						loadQuotationIncExc();
					  
					     tinymce.get('overviewText').setContent(itiOverview);
					     tinymce.get('highlightsText').setContent(itiSubject);
						closeinbound();
					}
				});
			}
			function closeinboundoverview() { 
				closeinbound();	
			}
	    </script>
	

		</div>
	</div>

	<?php
}

 
if($_REQUEST['action'] == 'editSupplimentService' && trim($_REQUEST['id'])!='' ){

	$rs=GetPageRecord('*','quotationAdditionalMaster',' id="'.trim($_REQUEST['id']).'" order by id asc');
	$resListing=mysqli_fetch_array($rs);

	if($resListing['serviceType']=='Activity'){

	$c121=GetPageRecord('*','packageBuilderotherActivityMaster',' id in (select otherActivityNameId from dmcotherActivityRate where id="'.$resListing['additionalId'].'") order by id asc');
	$activityDataName=mysqli_fetch_array($c121);
	$activityName=ucwords($activityDataName['otherActivityName']);
	}

	if($resListing['serviceType']=='Guide'){

	$c121=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id in (select serviceid from dmcGuidePorterRate where id="'.$resListing['additionalId'].'") order by id asc');
	$activityDataName=mysqli_fetch_array($c121);
	$activityName=ucwords($activityDataName['name']);
	}

	if($resListing['serviceType']=='Entrance'){

		if($resListing['additionalId'] != 0){
			$c121=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id in (select entranceNameId from '._DMC_ENTRANCE_RATE_MASTER_.' where id="'.$resListing['additionalId'].'") order by id asc');
			$activityDataName=mysqli_fetch_array($c121);
			$activityName=ucwords($activityDataName['entranceName']);	
		}else{
			$c121=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$resListing['entranceId'].'"'); 
			$entranceDataName=mysqli_fetch_array($c121);	
			$activityName=ucwords($entranceDataName['entranceName']);
		}

	}


	?>

	<div class="inboundheader" >Edit <?php echo $resListing['serviceType']; ?> <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #666666; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
	<form action="inboundpop.php" method="get" enctype="multipart/form-data" name="add_hoteltomaster" target="actoinfrm" id="add_hoteltomaster">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
	<td><div class="griddiv" style="position:static;">
	<label> <div>Service&nbsp;Type</div>
	<select id="supplimentServiceType" name="supplimentServiceType" class="gridfield " autocomplete="off" style="width: 110px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" >
	<?php if($resListing['serviceType']=='Activity'){ ?><option value="1">SightSeeing</option><?php } ?>
	<?php if($resListing['serviceType']=='Guide'){ ?><option value="2">Tour Escort</option><?php } ?>
	<?php if($resListing['serviceType']=='Entrance'){ ?><option value="3">Monument</option><?php } ?>
	</select>
	</label>
	</div></td>
	<td><div class="griddiv" style="position:static;">
	<label> <div><?php if($resListing['serviceType']=='Activity'){ ?>SightSeeing<?php } ?>
	<?php if($resListing['serviceType']=='Guide'){ ?>Tour Escort<?php } ?>
	<?php if($resListing['serviceType']=='Entrance'){ ?>Monument<?php } ?></div>
	<input  name="activityName" type="text" id="activityName" style="padding: 8px;border:1px #ccc solid; padding-top: 7px;" readonly=""  value="<?php echo $activityName; ?>" readonly="" >
	</label>
	</div></td>
	<td><div class="griddiv" style="position:static;">
	<label> <div>Adult Cost (PP)</div>
	<input  name="adultCost" type="number" id="actadultCost" style="padding: 8px;border:1px #ccc solid; padding-top: 7px;width: 110px;" onkeyup="numericFilter(this);"  value="<?php echo $resListing['adultCost']; ?>" >
	</label>
	</div></td> 
	<?php  if($resListing['serviceType']=='Entrance'){ ?>
	<td><div class="griddiv" style="position:static;">
	<label> <div>Child Cost (PP)</div>
	<input  name="childCost" type="number" id="actchildCost" style="padding: 8px;border:1px #ccc solid; padding-top: 7px;width: 110px;" onkeyup="numericFilter(this);"  value="<?php echo $resListing['childCost']; ?>" >
	</label>
	</div></td> 
	<td><div class="griddiv" style="position:static;">
	<label> <div>Infant Cost (PP)</div>
	<input  name="infantCost" type="number" id="actinfantCost" style="padding: 8px;border:1px #ccc solid; padding-top: 7px;width: 110px;" onkeyup="numericFilter(this);"  value="<?php echo $resListing['infantCost']; ?>" >
	</label>
	</div></td> 
	<?php } ?>
	</tr>
	<tr>
	<td colspan="4"><input name="Submit" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('add_hoteltomaster','submitbtn','0');">
	<input type="hidden" value="<?php echo encode($_REQUEST['id']); ?>" name="deleteid"/></td>
	<input type="hidden" value="editSupplimentService" name="action"/></td>
	</tr>
	</table>

	</form>


	<div id="saveSuppliment" style="display:none;"></div>
	<script>
	function savesaveSupplimentfun(id,destId,servicType){
		$('#selectbut'+id).hide();
		$('#selectedbut'+id).show();

		$('#saveSuppliment').load('saveSupplimentAcytivities.php?action=savesaveSupplimentdata&id='+id+'&destId='+destId+'&servicType='+servicType+'&quotationId=<?php echo encode($_REQUEST['quotationId']); ?>&isAddExp=<?php echo $_REQUEST['isAddExp']; ?>&dayId=<?php echo $_REQUEST['dayId']; ?>');

	}
	</script>
	</div>
	</div>

	<?php
}

// Domestic query Service Wise Markup file load
if($_REQUEST['action'] == 'addServiceWiseMarkup' && trim($_REQUEST['quotationId'])!='' ){ ?>
	<div class="inboundheader">Service&nbsp;Wise&nbsp;Markup<i class="fa fa-times" aria-hidden="true" onClick="closeinbound();"></i>&nbsp;</div>
	<div class="inboundbody">
		<div id="loadServiceWiseMarkupGst"></div>
		<script type="text/javascript">
			$('#loadServiceWiseMarkupGst').load('loadServiceWiseMarkupGst.php?quotationId=<?php echo trim($_REQUEST['quotationId']); ?>');
		</script>
	</div>
	<div class="inboundfooter">
		<table border="0" align="right" cellpadding="0" cellspacing="0">
		    <tbody>
		    	<tr>
	        	<td>
	        		<input name="cancel" type="button" class="whitembutton" id="cancel" value="Close" onclick="closeinbound();">
	        	</td>
	        	<td>
	        		<input name="submit" type="button" class="whitembutton saved" id="submit" value="Save All" onclick="updateSWMG();">
	        	</td>
		      </tr>
		   </tbody>
		</table>
	</div>
	<?php
}


if($_REQUEST['action']=="addNewVisaToMaster" || $_REQUEST['action']=="addNewPassportToMaster" || $_REQUEST['action']=="addNewInsuranceToMaster" && $_REQUEST['quotationId']!=''){

	?>

<div class="inboundheader" ><?php if($_REQUEST['action']=="addNewVisaToMaster"){ echo "Add New Visa"; }elseif($_REQUEST['action']=="addNewPassportToMaster"){ echo "Add New Passport"; }elseif($_REQUEST['action']=="addNewInsuranceToMaster"){ echo "Add New Insurance"; } ?><i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
	<form action="frm_action.crm" method="post" target="actoinfrm" name="addValueAddedServices" id="addValueAddedServices">
<table cellpadding="5" cellspacing="0" >	
<!-- <span class="redmind"></span> -->
			<div class="griddiv"><label>
				<div class="gridlable gridlable1"><?php if($_REQUEST['action']=="addNewVisaToMaster"){ echo "Visa Name"; }elseif($_REQUEST['action']=="addNewPassportToMaster"){ echo "Passport Name"; }elseif($_REQUEST['action']=="addNewInsuranceToMaster"){ echo "Insurance Name"; } ?></div>
					<input type="text" name="valueAddedCostName" id="valueAddedCostName" class="gridfield1" displayname="Visa Type" style="padding: 6px !important;width: 263px;">
				</label>
			</div>
			
			<div class="griddiv "><label>
				<div class="gridlable gridlable1"><?php if($_REQUEST['action']=="addNewVisaToMaster"){ echo "Visa Type"; }elseif($_REQUEST['action']=="addNewPassportToMaster"){ echo "Passport Type"; }elseif($_REQUEST['action']=="addNewInsuranceToMaster"){ echo "Insurance Type"; } ?></div>
				<?php if($_REQUEST['action']=="addNewVisaToMaster"){?>
				<select name="valueAddedTypeName" id="valueAddedTypeName" class="gridfield1" displayname="Visa Type" style="padding: 6px !important;width: 280px;">
				<option value="">Select</option>
				<?php 
					$vrs1 = GetPageRecord('*','visaTypeMaster','status=1');
					while($visad = mysqli_fetch_assoc($vrs1)){
						?>
						<option value="<?php echo $visad['id'] ?>"><?php echo $visad['name']; ?></option>
						<?php
					}
				
				?>
				</select>
				<?php }elseif($_REQUEST['action']=="addNewPassportToMaster"){ ?>
					<select name="valueAddedTypeName" id="valueAddedTypeName" class="gridfield1" displayname="Visa Type" style="padding: 6px !important;width: 280px;">
				<option value="">Select</option>
				<?php 
					$vrs1 = GetPageRecord('*','passportTypeMaster','status=1');
					while($visad = mysqli_fetch_assoc($vrs1)){
						?>
						<option value="<?php echo $visad['id'] ?>"><?php echo $visad['name']; ?></option>
						<?php
					}
				
				?>
				</select>
					
					<?php }elseif($_REQUEST['action']=="addNewInsuranceToMaster"){?>

						<select name="valueAddedTypeName" id="valueAddedTypeName" class="gridfield1" displayname="Visa Type" style="padding: 6px !important;width: 280px;">
				<option value="">Select</option>
				<?php 
					$vrs1 = GetPageRecord('*','InsuranceTypeMaster','status=1');
					while($visad = mysqli_fetch_assoc($vrs1)){
						?>
						<option value="<?php echo $visad['id'] ?>"><?php echo $visad['name']; ?></option>
						<?php
					}
				
				?>
				</select>
						
						<?php } ?>
				</label>
			</div>

			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Status</div>
				<select id="valueAddedstatus" type="text" class="gridfield" name="valueAddedstatus" displayname="Status" autocomplete="off" style="width: 280px;padding: 6px !important;">
				<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>
				<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>
				</select>

				</label>
			</div>

			<input type="hidden" name="action" id="action" value="<?php echo $_REQUEST['action']; ?>">
		<input type="hidden" name="quotationId" id="quotationId" value="<?php echo $_REQUEST['quotationId']; ?>">

			<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save " onclick="formValidation('addValueAddedServices','submitbtn','0');" /></td>

					<td><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="closeinbound();" /></td>

				</tr>
			</table>
		</div>

			</table>
	</form>
			<style>
				#inboundpopbg .inboundpop {
					width: 300px;
				}
			</style>
	
<?php
}



if($_REQUEST['action']=="editQuotationVisaCost" && $_REQUEST['editId']!='' && $_REQUEST['quotationId']!=''){
	$editId = $_REQUEST['editId'];
	$quotationId = $_REQUEST['quotationId'];

$rsqv = GetPageRecord('*','quotationVisaRateMaster','quotationId="'.$_REQUEST['quotationId'].'" and id="'.$editId.'"');
$visaQuotData = mysqli_fetch_assoc($rsqv)
?>
<style>
	.inboundpop{
		width: 82% !important;
	}
</style>
<div class="inboundheader" >Update Visa Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
<table width="60%" cellpadding="5" cellspacing="0" >
		<tr>
		<td >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="visaSupplierId" id="visaSupplierId" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 137px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && visaType="11" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$visaQuotData['supplierId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
		<td align="left"  >
				<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Date</div>
							<input type="date" name="visaDateV" id="visaDateV" class="gridfield1" value="<?= date('Y-m-d',strtotime($visaQuotData['visaDate'])); ?>" displayname="Processing Fee" style="width: 130px !important;">
						</label>
					</div>
				</td> 
			<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Country<span class="redmind"></span></div>
						<select name="visaCountryIdV" id="visaCountryIdV" class="gridfield1 validate" displayname="Visa Name" style="padding: 6px !important; width: 140px !important;">
						<!-- <option value="0">Select</option> -->
					<?php 

					$rsV = GetPageRecord('id,name',_COUNTRY_MASTER_,'status=1 && deletestatus=0 && name!=""');
					 while($visaCData = mysqli_fetch_assoc($rsV)){
						?>
						<option value="<?php echo $visaCData['id']; ?>" <?php if($visaQuotData['visaCountryId']==$visaCData['id']){ ?> selected="selected" <?php } ?>><?php echo $visaCData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>
			<td style="width: 100px;display:none;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Visa&nbsp;Name<span class="redmind"></span></div>
					<select name="visaNameId" id="visaNameId2" class="gridfield1 validate" onchange="selectVisaCost(this.value);" displayname="Visa Name" style="padding: 6px !important; width: 136px !important;">
					<option value="0">Select Visa Cost</option>
				<?php 
				$rsV = GetPageRecord('*','visaCostMaster','status=1 && deletestatus=0');
				 while($visaData = mysqli_fetch_assoc($rsV)){
					?>
					<option value="<?php echo $visaData['id']; ?>" <?php if($visaQuotData['serviceid']==$visaData['id']){ ?> selected="selected" <?php } ?> ><?php echo $visaData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Visa&nbsp;Type<span class="redmind"></span></div>
				<select name="visaTypeId" id="visaTypeId" class="gridfield1 validate" displayname="Visa Type" style="padding: 6px !important; width: 105px !important;">
					<option value="0">Select Visa Type</option>
				<?php 
				$rsV = GetPageRecord('*','visaTypeMaster','status=1 && deletestatus=0');
				 while($visatypeData = mysqli_fetch_assoc($rsV)){
					?>
					<option value="<?php echo $visatypeData['id']; ?>" <?php if($visaQuotData['visaTypeId']==$visatypeData['id']){ ?> selected="selected" <?php } ?> ><?php echo $visatypeData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>

			<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Validity</div>
							<input type="text" name="visaValidityV" id="visaValidityV" class="gridfield1" value="<?php echo $visaQuotData['visaValidity']; ?>" displayname="Visa Validity">
						</label>
					</div>
				</td> 
				<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Entry&nbsp;Type</div>
							<select name="entryTypeV" class="gridfield1" id="entryTypeV" style="padding: 6px !important; width: 105px !important;">

							<option value="1" <?php if($visaQuotData['entryType']==1){ echo 'selected'; } ?> >Single Entry</option>
							<option value="2" <?php if($visaQuotData['entryType']==2){ echo 'selected'; } ?> >Multiple Entry</option>
						
							</select>
						</label>
					</div>
				</td> 

			<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
					
					<select name="vscurrencyId" id="vscurrencyId" class="gridfield1 validate" onchange="getROE(this.value,'vscurrencyValue133');"displayname="Currency" style="padding: 6px !important;width:91px;">
					<option value="">Select</option>
				<?php 

					$currencyId = ($visaQuotData['currencyId']>0)?$visaQuotData['currencyId']:$baseCurrencyId;
					$currencyValue = ($visaQuotData['currencyValue']>0)?$visaQuotData['currencyValue']:getCurrencyVal($currencyId);

					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
				
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($visaQuotData['currencyId']==$currencyData['id']){ echo 'selected'; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>

			<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="vscurrencyValue" id="vscurrencyValue133" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value" style="width: 100px;">
					</label>
				</div>
			</td>
			<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="visaServiceTaxId" name="visaServiceTaxId" class="gridfield" displayname="GST" autocomplete="off" style="width: 120px;padding: 6px !important;">
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($visaQuotData['gstTax']==$gstSlabData['id']){ echo 'selected'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
			</tr>
			<tr>
			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="adultCost1" id="adultCost1" value="<?php echo $visaQuotData['adultCost'] ?>" class="gridfield1" displayname="Adult Cost" style="display:inline-block;">
					<input type="text" class="gridfield1" name="adultPaxVE" id="adultPaxVE" value="<?php echo $visaQuotData['adultPax'] ?>" style="width: 45px;display: inline-block;">
				</label>
			</div>
			</td>
		

			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="childCost1" id="childCost1" value="<?php echo $visaQuotData['childCost'] ?>" class="gridfield1" displayname="Child Cost" style="display:inline-block;">
					<input type="text" class="gridfield1" name="childPaxVE" id="childPaxVE" value="<?php echo $visaQuotData['childPax'] ?>" style="width: 45px;display: inline-block;">
				</label>
			</div>
			</td>

			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
					<input type="text" name="infantCost1" id="infantCost1" value="<?php echo $visaQuotData['infantCost'] ?>" class="gridfield1" displayname="Infant Cost" style="display:inline-block;width:72px;">
					<input type="text" class="gridfield1" name="infantPaxVE" id="infantPaxVE" value="<?php echo $visaQuotData['infantPax'] ?>" style="width: 45px;display: inline-block;">
				</label>
			</div>
			</td>
			
		<td align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable gridlable1">Fee&nbsp;Type<span class="redmind"></span></div>
						<select name="markupTypevisa" id="markupTypevisa" class="gridfield1 validate" style="padding: 6px !important;width: 105px !important;">
							<option value="1" <?php if($visaQuotData['markupType']=='1'){ echo "selected"; } ?>>%</option>
							<option value="2" <?php if($visaQuotData['markupType']=='2'){ echo "selected"; } ?>>Flat</option>
						</select>
					</label>
				</div>
			</td> 

			<td align="left"  >
				<div class="griddiv">
					<label>
						<div class="gridlable gridlable1">P.&nbsp;Fee</div>
						<input type="text" name="processingFee" id="processingFee" value="<?php echo $visaQuotData['processingFee'] ?>" class="gridfield1" displayname="Processing Fee" style="width: 70px !important;">
					</label>
				</div>
			</td> 
			<td align="left">
				<div class="griddiv">
					<label>
						<div class="gridlable gridlable1">Embassy&nbsp;Fee</div>
						<input type="text" name="embassyFee" id="embassyFee" value="<?php echo $visaQuotData['embassyFee'] ?>" class="gridfield1" displayname="Embassy Fee" style="width: 94px;">
					</label>
				</div>
			</td> 
			<td align="left" >
				<div class="griddiv">
					<label>
						<div class="gridlable gridlable1">VFS&nbsp;Charges</div>
						<input type="text" name="vfsCharges" id="vfsCharges" value="<?php echo $visaQuotData['vfsCharges'] ?>" class="gridfield1" displayname="VFS Charges" style="width: 80px;">
					</label>
				</div>
			</td> 
			<td align="left">
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Tax&nbsp;Applicable</div>
							<select name="taxApplicableVisa" class="gridfield1" id="taxApplicableVisa" style="padding: 6px !important; width: 110px !important;">

							<option value="0" <?php if($visaQuotData['taxApplicable']==0){ echo 'selected'; } ?> >Yes</option>
							<option value="1" <?php if($visaQuotData['taxApplicable']==1){ echo 'selected'; } ?> >No</option>
						
							</select>
						</label>
					</div>
				</td> 

			<td align="center">
				<div class="editbtnselect" id="selectthis" style="background: #233A49 !important;width:70px !important;margin-top: 5px;"  onclick="EditVisaCostToQuotation();" >Save
				</div>
			</td>
		</tr>
	
		

			<input type="hidden" name="visaRateId" id="visaRateId" value="<?php echo $visaQuotData['rateId']; ?>">
			<input type="hidden" name="editId" id="editId" value="<?php echo $visaQuotData['id']; ?>">
		
		<!-- <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp; -->
	</tbody>
</table>
	<script>
		function EditVisaCostToQuotation(){
		var visaRateId = $("#visaRateId").val();
		var adultCost = $("#adultCost1").val();
		var childCost = $("#childCost1").val();
		var infantCost = $("#infantCost1").val();
		var adultPax = $("#adultPaxVE").val();
		var childPax = $("#childPaxVE").val();
		var infantPax = $("#infantPaxVE").val();
		var visaTypeId = $("#visaTypeId").val();
		var visaNameId2 = $("#visaNameId2").val();
		var vscurrencyId = $("#vscurrencyId").val();
		var vscurrencyValue = $("#vscurrencyValue133").val();
		
		var vfsChargesv = $("#vfsCharges").val();
		var embassyFeev = $("#embassyFee").val();
		var processingFee = $("#processingFee").val();
		var ProcessingFeeType = $("#markupTypevisa").val();
		var visaCountryId = $("#visaCountryIdV").val();
		var visaDate = $("#visaDateV").val();
		var visaValidity = $("#visaValidityV").val();
		var entryType = $("#entryTypeV").val();
		var taxApplicableVisa = $("#taxApplicableVisa").val();
		var visaSupplierId = $("#visaSupplierId").val();
		var visaGstTax = $("#visaServiceTaxId").val();

		if(visaTypeId>0 && visaNameId2>0){

		$("#selectVisacost").load('loadValueAddedserviceCost.php?action=saveVisaCosttoQuotation&visaRateId='+visaRateId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&visaNameId='+visaNameId2+'&visaType='+visaTypeId+'&currencyId='+vscurrencyId+'&currencyValue='+vscurrencyValue+'&markupType='+ProcessingFeeType+'&markupCost='+processingFee+'&embassyFeev='+embassyFeev+'&vfsChargesv='+vfsChargesv+'&quotationId=<?php echo $quotationId; ?>&editId=<?php echo $visaQuotData['id']; ?>&visaCountryId='+visaCountryId+'&visaDate='+encodeURI(visaDate)+'&visaValidity='+visaValidity+'&entryType='+entryType+'&taxApplicable='+taxApplicableVisa+'&supplierId='+visaSupplierId+'&gstTax='+visaGstTax);

		}else{
			alert('Please, Select Visa Name or Type');
		}
	}
	</script>
	</div>
	</div>

<?php
}



if($_REQUEST['action']=="editQuotationInsuranceCost" && $_REQUEST['editId']!='' && $_REQUEST['quotationId']!=''){
	$editId = $_REQUEST['editId'];
	$quotationId = $_REQUEST['quotationId'];

$rsqI = GetPageRecord('*','quotationInsuranceRateMaster','quotationId="'.$_REQUEST['quotationId'].'" and id="'.$editId.'"');
$insuranceQuotData = mysqli_fetch_assoc($rsqI)
?>
<style>
	.inboundpop{
		width: 85% !important;
	}
</style>
<div class="inboundheader" >Update Insurance Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff !important; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
<table width="65%" cellpadding="5" cellspacing="0" >
		<tr>
		<td style="width: 100px" colspan="2">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="insuranceSupplierId" id="insuranceSupplierId" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 137px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && insuranceType="14" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$insuranceQuotData['supplierId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
		<td style="width: 100px" colspan="2">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Country<span class="redmind"></span></div>
						<select name="travellingcountryIdIN" id="travellingcountryIdIN" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 137px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_COUNTRY_MASTER_,'status=1 && deletestatus=0 && name!=""');
					 while($insCountryData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insCountryData['id']; ?>" <?php if($insCountryData['id']==$insuranceQuotData['countryId']){ echo 'selected'; } ?>><?php echo $insCountryData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
				</td>


				<td colspan="2"  style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">From&nbsp;Date<span class="redmind"></span></div>
						<input type="text" name="insuranceFromDateIN" id="insuranceFromDateIN" value="<?php if($insuranceQuotData['insuranceStartDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($insuranceQuotData['insuranceStartDate'])); } ?>" class="gridfield1 calfieldicon" displayname="From Date" readonly  style="width:133px; border: 1px solid #ccc;">
					
					</label>
				</div>
				</td>

				<td style="padding-right:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">To&nbsp;Date<span class="redmind"></span></div>
						<input type="text" name="insuranceToDateIN" id="insuranceToDateIN" value="<?php if($insuranceQuotData['insuranceEndDate']!='0000-00-00'){ echo date('d-m-Y',strtotime($insuranceQuotData['insuranceEndDate'])); } ?>" class="gridfield1 calfieldicon" displayname="To Date" readonly style="width:120px; border: 1px solid #ccc;">
						
					</label>
				</div>
				</td>
					 
				<script src="js/zebra_datepicker.js"></script>

				<script type="text/javascript">
					$('#insuranceToDateIN').Zebra_DatePicker({
						format: 'd-m-Y',
					});
					$('#insuranceFromDateIN').Zebra_DatePicker({
						format: 'd-m-Y',
					});
					
					 </script>
			<td style="width: 100px">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Insurance&nbsp;Name<span class="redmind"></span></div>
					<select name="insuranceNameIdIN" id="insuranceNameIdIN" class="gridfield1 validate" onchange="selectInsuranceCost(this.value);" displayname="Insurance Name" style="padding: 6px !important; width: 130px !important;">
					<option value="0">Select Insurance Cost</option>
				<?php 
				$rsV = GetPageRecord('*','insuranceCostMaster','status=1 && deletestatus=0 and name!=""');
				 while($insData = mysqli_fetch_assoc($rsV)){
					?>
					<option value="<?php echo $insData['id']; ?>" <?php if($insuranceQuotData['serviceid']==$insData['id']){ ?> selected="selected" <?php } ?> ><?php echo $insData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Insurance&nbsp;Type<span class="redmind"></span></div>
				<select name="insuranceTypeIdIN" id="insuranceTypeIdIN" class="gridfield1 validate" displayname="Visa Type" style="padding: 6px !important; width: 130px !important;">
					<option value="0">Select Insurance Type</option>
				<?php 
				$rsV = GetPageRecord('*','InsuranceTypeMaster','status=1 && deletestatus=0 and name!=""');
				 while($insurancetypeData = mysqli_fetch_assoc($rsV)){
					?>
					<option value="<?php echo $insurancetypeData['id']; ?>" <?php if($insuranceQuotData['insuranceTypeId']==$insurancetypeData['id']){ ?> selected="selected" <?php } ?> ><?php echo $insurancetypeData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
					
					<select name="inscurrencyId" id="inscurrencyId" class="gridfield1 validate" onchange="getROE(this.value,'inscurrencyValue134');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
				<?php 

				$currencyId = ($insuranceQuotData['currencyId']>0)?$insuranceQuotData['currencyId']:$baseCurrencyId;
				$currencyValue = ($insuranceQuotData['currencyValue']>0)?$insuranceQuotData['currencyValue']:getCurrencyVal($currencyId);
					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
				
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($insuranceQuotData['currencyId']==$currencyData['id']){ echo 'selected'; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>

			<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="inscurrencyValue" id="inscurrencyValue134" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
					</label>
				</div>
			</td>

			
			</tr>
			<tr>
			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="insadultCostIN" id="insadultCostIN" value="<?php echo $insuranceQuotData['adultCost'] ?>" class="gridfield1" displayname="Adult Cost">
				</label>
			</div>
			</td>
			<td>
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(A)</div>	
						<input type="text" name="insadultPax" id="insadultPax" value="<?php echo $insuranceQuotData['adultPax'] ?>" placeholder="Adult Pax" class="gridfield1" style="width:40px !important;">
					 </label>
				</div>
				</td>
			

			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="inschildCostIN" id="inschildCostIN" value="<?php echo $insuranceQuotData['childCost'] ?>" class="gridfield1" displayname="Child Cost">
				</label>
			</div>
			</td>

			<td style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(C)</div>	
						<input type="text" name="inschildPax" id="inschildPax" value="<?php echo $insuranceQuotData['childPax']; ?>" placeholder="Child Pax" class="gridfield1" style="width:40px !important;" >
					 </label>
				</div>
				</td>
		

			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
					<input type="text" name="insinfantCostIN" id="insinfantCostIN" value="<?php echo $insuranceQuotData['infantCost'] ?>" class="gridfield1" displayname="Infant Cost">
				</label>
			</div>
			</td>

			<td style="padding-left:0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Pax(I)</div>	
					<input type="text" name="insinfantPax" id="insinfantPax" value="<?php echo  $insuranceQuotData['infantPax'] ?>" placeholder="Infant Pax" class="gridfield1" style="width:40px !important;">	
					</label>
				</div>
				</td>

				<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="insuranceGstTax" name="insuranceGstTax" class="gridfield" displayname="GST" autocomplete="off" style="width: 120px;padding: 6px !important;">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($insuranceQuotData['gstTax']==$gstSlabData['id']){ echo 'selected'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Markup&nbsp;Type<span class="redmind"></span></div>
							<select name="inProcessingFeeType" id="inProcessingFeeType" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1" <?php if($insuranceQuotData['markupType']==1){ echo "selected"; } ?>>%</option>
								<option value="2" <?php if($insuranceQuotData['markupType']==2){ echo "selected"; } ?> >Flat</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="inprocessingFee" id="inprocessingFee" class="gridfield1" displayname="Processing Fee" value="<?php echo $insuranceQuotData['processingFee']; ?>" style="width: 95px !important;">
						</label>
					</div>
				</td>
			
			<td align="center">
				<div class="editbtnselect" id="selectthis" style="background:#233A49 ;width:70px !important; margin-top:5px; " onclick="EditInsuranceCostToQuotation();" >Save
				</div>
				</td>
		</tr>

			<input type="hidden" name="insuranceRateId" id="insuranceRateId" style="background: #233A49 !important;" value="<?php echo $insuranceQuotData['rateId']; ?>">
			<input type="hidden" name="editId" id="editId" value="<?php echo $insuranceQuotData['id']; ?>">
		
		<!-- <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp; -->
	</tbody>
</table>
	<script>
		function EditInsuranceCostToQuotation(){
		var insuranceRateId = $("#insuranceRateId").val();
		var insadultCost1 = $("#insadultCostIN").val();
		var inschildCost1 = $("#inschildCostIN").val();
		var insinfantCost1 = $("#insinfantCostIN").val();
		var adultPax = $("#insadultPax").val();
		var childPax = $("#inschildPax").val();
		var infantPax = $("#insinfantPax").val();
		var insuranceType = $("#insuranceTypeIdIN").val();
		var insuranceNameId2 = $("#insuranceNameIdIN").val();
		var inscurrencyId = $("#inscurrencyId").val();
		var inscurrencyValue = $("#inscurrencyValue134").val();
		var travellingcountryId = $("#travellingcountryIdIN").val();
		var insuranceFromDate = $("#insuranceFromDateIN").val();
		var insuranceToDate = $("#insuranceToDateIN").val();
		var ProcessingFeeType = $("#inProcessingFeeType").val();
		var processingFee = $("#inprocessingFee").val();
		var insuranceSupplierId = $("#insuranceSupplierId").val();
		var insuranceGstTax = $("#insuranceGstTax").val();
		


		if(insuranceType>0 && insuranceNameId2>0){

		$("#selectInsurancecost").load('loadValueAddedserviceCost.php?action=saveInsuranceCosttoQuotation&insuranceRateId='+insuranceRateId+'&adultCost='+insadultCost1+'&childCost='+inschildCost1+'&infantCost='+insinfantCost1+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&insuranceNameId='+insuranceNameId2+'&currencyId='+inscurrencyId+'&currencyValue='+inscurrencyValue+'&insuranceType='+insuranceType+'&quotationId=<?php echo $quotationId; ?>&editId=<?php echo $insuranceQuotData['id']; ?>&travellingcountryId='+travellingcountryId+'&insuranceFromDate='+encodeURI(insuranceFromDate)+'&insuranceToDate='+encodeURI(insuranceToDate)+'&ProcessingFeeType='+encodeURI(ProcessingFeeType)+'&processingFee='+encodeURI(processingFee)+'&insGstTax='+encodeURI(insuranceGstTax)+'&insuranceSupplier='+encodeURI(insuranceSupplierId));

		}else{
			alert('Please, Select Insurance Name or Type');
		}
	}
	</script>
	</div>
	</div>

<?php
}


if($_REQUEST['action']=="editQuotationPassCost" && $_REQUEST['editId']!='' && $_REQUEST['quotationId']!=''){
	$editId = $_REQUEST['editId'];
	$quotationId = $_REQUEST['quotationId'];

$rsqP = GetPageRecord('*','quotationPassportRateMaster','quotationId="'.$_REQUEST['quotationId'].'" and id="'.$editId.'"');
$passportQuotData = mysqli_fetch_assoc($rsqP)
?>
<style>
	.inboundpop{
		width: 80% !important;
	}
</style>
<div class="inboundheader" >Update Passport Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
<table width="65%" cellpadding="5" cellspacing="0" >
		<tr>
			<td style="width: 100px">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Passport&nbsp;Name<span class="redmind"></span></div>
					<select name="passNameId2" id="passNameId2" class="gridfield1 validate" onchange="selectInsuranceCost(this.value);" displayname="Insurance Name" style="padding: 6px !important; width: 170px !important;">
					<option value="0">Select Passport Name</option>
				<?php 
				$rsV = GetPageRecord('*','passportCostMaster','status=1 && deletestatus=0');
				 while($passData = mysqli_fetch_assoc($rsV)){
					?>
					<option value="<?php echo $passData['id']; ?>" <?php if($passportQuotData['serviceid']==$passData['id']){ ?> selected="selected" <?php } ?> ><?php echo $passData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Passport&nbsp;Type<span class="redmind"></span></div>
				<select name="passportTypeId" id="passportTypeId" class="gridfield1 validate" displayname="Visa Type" style="padding: 6px !important; width: 170px !important;">
					<option value="0">Select Passport Type</option>
				<?php 
				$rsP = GetPageRecord('*','passportTypeMaster','status=1 && deletestatus=0');
				 while($passtypeData = mysqli_fetch_assoc($rsP)){
					?>
					<option value="<?php echo $passtypeData['id']; ?>" <?php if($passportQuotData['passportTypeId']==$passtypeData['id']){ ?> selected="selected" <?php } ?> ><?php echo $passtypeData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>
			<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
					
					<select name="pascurrencyId" id="pascurrencyId" class="gridfield1 validate" onchange="getROE(this.value,'pascurrencyValue135');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
				<?php 

$currencyId = ($passportQuotData['currencyId']>0)?$passportQuotData['currencyId']:$baseCurrencyId;
$currencyValue = ($passportQuotData['currencyValue']>0)?$passportQuotData['currencyValue']:getCurrencyVal($currencyId);

					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
				
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($passportQuotData['currencyId']==$currencyData['id']){ echo 'selected'; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 }
				?>
				</select>
				</label>
			</div>
			</td>

			<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="pascurrencyValue" id="pascurrencyValue135" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
					</label>
				</div>
			</td>

			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="passadultCost1" id="passadultCost1" value="<?php echo $passportQuotData['adultCost'] ?>" class="gridfield1" displayname="Adult Cost">
				</label>
			</div>
			</td>
			<td style="padding-left:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">No Of&nbsp;Pax</div>	
					<input type="text" name="adultPaxP" id="adultPaxP" value="<?php echo $passportQuotData['adultPax'] ?>" placeholder="Adult Pax" class="gridfield1" style="width:56px !important;">
				 </label>
			</div>
			</td>

			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="passchildCost1" id="passchildCost1" value="<?php echo $passportQuotData['childCost'] ?>" class="gridfield1" displayname="Child Cost">
				</label>
			</div>
			</td>
			<td style="padding-left:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">No Of&nbsp;Pax</div>	
					<input type="text" name="childPaxP" id="childPaxP" value="<?php echo $passportQuotData['childPax'] ?>" placeholder="Child Pax" class="gridfield1" style="width:56px !important;">
				 </label>
			</div>
			</td>

			<td style="padding-right:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
					<input type="text" name="passinfantCost1" id="passinfantCost1" value="<?php echo $passportQuotData['infantCost'] ?>" class="gridfield1" displayname="Infant Cost">
				</label>
			</div>
			</td>
			<td style="padding-left:0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">No Of&nbsp;Pax</div>	
				<input type="text" name="infantPaxP" id="infantPaxP" value="<?php echo $passportQuotData['infantPax'] ?>" placeholder="Infant Pax" class="gridfield1" style="width:56px !important;">
				</label>
			</div>
			</td>
			<td align="center">
				<div class="editbtnselect" id="selectthis" style="background: #233A49 !important;" onclick="EditPassCostToQuotation();" >Save
				</div>
				</td>
		</tr>
	
		
			<input type="hidden" name="passportRateId" id="passportRateId" value="<?php echo $passportQuotData['rateId']; ?>">
			<input type="hidden" name="editId" id="editId" value="<?php echo $passportQuotData['id']; ?>">
		
		<!-- <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp; -->
	</tbody>
</table>
	<script>
		function EditPassCostToQuotation(){
		var passportRateId = $("#passportRateId").val();
		var passadultCost1 = $("#passadultCost1").val();
		var passchildCost1 = $("#passchildCost1").val();
		var passinfantCost1 = $("#passinfantCost1").val();
		var adultPax = $("#adultPaxP").val();
		var childPax = $("#childPaxP").val();
		var infantPax = $("#infantPaxP").val();
		var passportTypeId = $("#passportTypeId").val();
		var passNameId2 = $("#passNameId2").val();
		var pascurrencyId = $("#pascurrencyId").val();
		var pascurrencyValue = $("#pascurrencyValue135").val();

		if(passportTypeId>0 && passNameId2>0){

		$("#selectPasscost").load('loadValueAddedserviceCost.php?action=savePassportCosttoQuotation&passportRateId='+passportRateId+'&adultCost='+passadultCost1+'&childCost='+passchildCost1+'&infantCost='+passinfantCost1+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&passportNameId='+passNameId2+'&passportType='+passportTypeId+'&currencyId='+pascurrencyId+'&currencyValue='+pascurrencyValue+'&quotationId=<?php echo $quotationId; ?>&editId=<?php echo $passportQuotData['id']; ?>');

		}else{
			alert('Please, Select Passport Name or Type');
		}
	}
	</script>
	</div>
	</div>

<?php
}

// flight block

if($_REQUEST['action']=="editQuotationFlightCost" && $_REQUEST['editId']!='' && $_REQUEST['quotationId']!=''){
	$editId = $_REQUEST['editId'];
	$quotationId = $_REQUEST['quotationId'];

	$rsqv = GetPageRecord('*','quotationFlightMaster','quotationId="'.$_REQUEST['quotationId'].'" and id="'.$editId.'"');
	$flightQuotData = mysqli_fetch_assoc($rsqv)
?>
<style>
	.inboundpop{
		max-width: 1326px !important;
	}
</style>
<div class="inboundheader" >Update Flight Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff !important; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
	<table width="60%" cellpadding="5" cellspacing="0" >
		
		<tr>
		<td >
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
						<select name="flightSupplierId<?php echo $fNum; ?>" id="flightSupplierId<?php echo $fNum; ?>" class="gridfield1 validate" displayname="Travelling Country" style="padding: 6px !important; width: 141px !important;">
						<option value="0">Select</option>
					<?php 
					$rsc = GetPageRecord('*',_SUPPLIERS_MASTER_,'status=1 && airlinesType="7" && name!=""');
					 while($insSuppData = mysqli_fetch_assoc($rsc)){
						?>
						<option value="<?php echo $insSuppData['id']; ?>" <?php if($insSuppData['id']==$flightQuotData['supplierId']){ echo 'selected'; } ?>><?php echo $insSuppData['name']; ?></option>
						<?php
					 }
					?>
					</select>
					</label>
				</div>
			</td>
		<td colspan="2">
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Flight&nbsp;Date<span class="redmind"></span></div>
					<input type="date" name="flightDateU" id="flightDateU" value="<?= date('Y-m-d',strtotime($flightQuotData['departureDate'])); ?>" class="gridfield1" displayname="ROI Value" style="width:130px;">
				</label>
			</div>
			</td>
			<td >
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">From<span class="redmind"></span></div>
					
					<select name="flightFromDestionationU" id="flightFromDestionationU" value="0" class="gridfield1" displayname="Flight Destination" style="padding: 6px !important; width: 141px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($fromDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $fromDestD['id']; ?>" <?php if($flightQuotData['departureFrom']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td colspan="2">
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">To&nbsp;<span class="redmind"></span></div>
					
					<select name="flightToDestionationU" id="flightToDestionationU" class="gridfield1" displayname="Flight Destination" style="padding: 6px !important; width: 141px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($toDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $toDestD['id']; ?>" <?php if($flightQuotData['arrivalTo']==$toDestD['id']){ echo 'selected'; } ?> ><?php echo $toDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td style="width: 100px">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Flight&nbsp;Name<span class="redmind"></span></div>
				<select name="flightNameIdU" id="flightNameIdU" class="gridfield1 validate" displayname="Flight Name" style="padding: 6px !important; width: 141px !important;">
					<option value="0">Select</option>
					<?php 
					$rsFQuery = GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' flightName!="" and status=1 order by flightName asc');
				 	while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){

						?>
						<option value="<?php echo $GuideData5['id']; ?>" <?php if($flightQuotData['flightId']==$GuideData5['id']){ echo 'selected="selected"'; } ?> ><?php echo strip($GuideData5['flightName']); ?></option>
						<?php
					}
					?>
				</select>
				</label>
			</div>
			</td> 

			<td colspan="2">
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Flight&nbsp;Number<span class="redmind"></span></div>
					<input type="text" name="fflightNumberU" id="fflightNumberU" value="<?php echo $flightQuotData['flightNumber']; ?>" class="gridfield1" displayname="ROI Value" style="width:130px;">
				</label>
			</div>
			</td>

			<td >
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Flight&nbsp;Class<span class="redmind"></span></div>
					<select id="fflightClassU" name="fflightClassU" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:118px;">
						<option value="First_Class" <?php if($flightQuotData['flightClass']=='First_Class'){ echo 'selected="selected"'; } ?>>First Class</option>
						<option value="Business_Class" <?php if($flightQuotData['flightClass']=='Business_Class'){ echo 'selected="selected"'; } ?> >Business Class</option>
						<option value="Economy_Class" <?php if($flightQuotData['flightClass']=='Economy_Class'){ echo 'selected="selected"'; } ?>>Economy Class</option>
						<option value="Premium_Economy_Class" <?php if($flightQuotData['flightClass']=='Premium_Economy_Class'){ echo 'selected="selected"'; } ?> >Premium Economy Class</option>
					</select> 
				</label>
			</div>
			</td>

			<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
				<select name="fcurrencyIdU" id="fcurrencyIdU" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
					<?php  
					$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
					$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);

					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 	}
					?>
				</select>
				</label>
			</div>
			</td>
			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input type="text" name="fcurrencyValueU" id="fcurrencyValue132U" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
				</label>
			</div>
			</td>
			</tr>
			<tr>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1" style="text-align:center;">Adult&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="fadultCostU" id="fadultCostU" oninput="calculateAdultCostF();" value="<?php echo $flightQuotData['adultCost']; ?>" class="gridfield1" displayname="Adult Cost" style="width:60px; display:inline-block;">
					
					<input type="text" name="airlineTaxFA" oninput="calculateAdultCostF();" id="airlineTaxFA" value="<?php echo $flightQuotData['adultTax']; ?>" class="gridfield1" placeholder="Airline Tax" displayname="Adult Cost" style="width:60px; display:inline-block;">
				</label>
			</div>
			</td>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
					<input type="text" name="totalCostFA" id="totalCostFA" value="<?php echo $visaRq['totalAdultCost'] ?>" class="gridfield1" style="width: 70px !important;">
				 </label>
			</div>
			</td>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Pax(A)</div>	
					<input type="text" name="flightAdultA" id="flightAdultA" value="<?php echo $flightQuotData['adultPax'] ?>" class="gridfield1" style="width: 40px !important;">
				 </label>
			</div>
			</td>
		
			<script>
				function calculateAdultCostF(){
					var fAdultCost = Number($("#fadultCostU").val());
					var fAdultTax = Number($("#airlineTaxFA").val());

					var ftotalCost = fAdultCost+fAdultTax;
					$("#totalCostFA").val(ftotalCost);
				}

				calculateAdultCostF();
			</script>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1" style="text-align:center;">Child&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="fchildCostU" oninput="calculateChildCostF();" id="fchildCostU" value="<?php echo $flightQuotData['childCost']; ?>" class="gridfield1" displayname="Child Cost" style="width:60px; display:inline-block;">

					<input type="text" name="airlineTaxFC" oninput="calculateChildCostF();" id="airlineTaxFC" value="<?php echo $flightQuotData['childTax']; ?>" class="gridfield1" placeholder="Airline Tax" displayname="Child Cost" style="width:60px; display:inline-block;">
				
				</label>
			</div>
			</td>
		

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
					<input type="text" name="totalCostFC" id="totalCostFC" value="<?php echo $visaRq['totalChildCost'] ?>" class="gridfield1" style="width: 70px !important;">
				 </label>
			</div>
			</td>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Pax(C)</div>	
					<input type="text" name="flightChildC" id="flightChildC" value="<?php echo $flightQuotData['childPax'] ?>" class="gridfield1" style="width: 40px !important;">
				 </label>
			</div>
			</td>
		
			<script>
				function calculateChildCostF(){
					var fChildCost = Number($("#fchildCostU").val());
					var fChildTax = Number($("#airlineTaxFC").val());

					var ftotalCost = fChildCost+fChildTax;
					$("#totalCostFC").val(ftotalCost);
				}

				calculateChildCostF();
			</script>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1" style="text-align:center;">Infant&nbsp;Cost</div>
					<input type="text" name="finfantCostU" id="finfantCostU" oninput="calculateInfantCostF();" value="<?php echo $flightQuotData['infantCost']; ?>" placeholder="Base Fare" class="gridfield1" displayname="Infant Cost" style="width:60px; display:inline-block;">

					<input type="text" name="airlineTaxFE" oninput="calculateInfantCostF();" id="airlineTaxFE" value="<?php echo $flightQuotData['infantTax']; ?>" class="gridfield1" placeholder="Airline Tax" displayname="Child Cost" style="width:60px; display:inline-block;">
					
				</label>
			</div>
			</td>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Total&nbsp;Cost</div>	
					<input type="text" name="totalCostFE" id="totalCostFE" value="<?php echo $visaRq['totalInfantCost'] ?>" class="gridfield1" style="width: 70px !important;">
				 </label>
			</div>
			</td>

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Pax(I)</div>	
					<input type="text" name="flightInfantE" id="flightInfantE" value="<?php echo $flightQuotData['infantPax'] ?>" class="gridfield1" style="width: 40px !important;">
				 </label>
			</div>
			</td>
		
			<script>
				function calculateInfantCostF(){
					var fInfantCost = Number($("#finfantCostU").val());
					var fInfantTax = Number($("#airlineTaxFE").val());

					var ftotalCost = fInfantCost+fInfantTax;
					$("#totalCostFE").val(ftotalCost);
				}

				calculateInfantCostF();
			</script>
				<td >
				<div class="griddiv">
					<label>
						<div class="gridlable">TAX&nbsp;SLAB(%)</div>
						<select id="flightServiceTax" name="flightServiceTax" class="gridfield" displayname="GST" autocomplete="off" style="width: 120px;padding: 6px !important;">
												<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($flightQuotData['gstTax']==$gstSlabData['id']){ echo 'selected'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Fee&nbsp;Type<span class="redmind"></span></div>
							<select name="vsProcessingFeeType" id="vsProcessingFeeType" class="gridfield1 validate" style="padding: 6px !important;width: 70px !important;">
								<option value="1" <?php if($flightQuotData['markupType']==1){ echo "selected"; } ?>>%</option>
								<option value="2" <?php if($flightQuotData['markupType']==2){ echo "selected"; } ?>>Flat</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">P.&nbsp;Fee</div>
							<input type="text" name="vsprocessingFee" id="vsprocessingFee" class="gridfield1" displayname="Processing Fee" value="<?php echo $flightQuotData['markupCost']; ?>" style="width: 70px !important;">
						</label>
					</div>
				</td>
		
			<td align="center">
				<div class="editbtnselect" id="selectthis" style="background: #233A49 !important;width:70px !important;margin-top: 5px;"  onclick="EditFlightCostToQuotation();" >Save
				</div>
			</td>
		</tr>
	
			<input type="hidden" name="flightRateId" id="flightRateId" value="<?php echo $flightQuotData['rateId']; ?>">
			<input type="hidden" name="editId" id="editId" value="<?php echo $flightQuotData['id']; ?>">
		
		<!-- <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp; -->
	</tbody>
</table>
<div id="selectFlightCost" style="display:none;">loading...</div>
	<script>
	
		function EditFlightCostToQuotation(){
		var flightRateId = $("#flightRateId").val();
		var adultCost = $("#fadultCostU").val();
		var childCost = $("#fchildCostU").val();
		var infantCost = $("#finfantCostU").val();
		var flightFromDestionation = $("#flightFromDestionationU").val();
		var flightToDestionation = $("#flightToDestionationU").val();
		var flightNameId = $("#flightNameIdU").val();
		var fflightNumber = $("#fflightNumberU").val();
		var fflightClass = $("#fflightClassU").val();
		
		var fcurrencyId = $("#fcurrencyIdU").val();
		var currencyValue = $("#fcurrencyValue132U").val();

		
		var flightDate = $("#flightDateU").val();
		var ProcessingFeeType = $("#vsProcessingFeeType").val();
		var processingFee = $("#vsprocessingFee").val();

		var airlineTaxA = $("#airlineTaxFA").val();
		var totalCostA = $("#totalCostFA").val();
		var airlineTaxC = $("#airlineTaxFC").val();
		var totalCostC = $("#totalCostFC").val();
		var airlineTaxE = $("#airlineTaxFE").val();
		var totalCostE = $("#totalCostFE").val();
		var flightAdultA = $("#flightAdultA").val();
		var flightInfantE = $("#flightInfantE").val();
		var flightChildC = $("#flightChildC").val();
		var flightSupplierId = $("#flightSupplierId").val();
		var flightServiceTax = $("#flightServiceTax").val();

		if(fflightNumber>0 && flightNameId>0){

		$("#selectFlightCost").load('loadValueAddedserviceCost.php?action=saveFlightCosttoQuotation&flightRateId='+flightRateId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&flightToDestionation='+flightToDestionation+'&flightFromDestionation='+flightFromDestionation+'&flightNameId='+flightNameId+'&flightNumber='+fflightNumber+'&currencyId='+fcurrencyId+'&currencyValue='+currencyValue+'&flightClass='+fflightClass+'&quotationId=<?php echo $quotationId; ?>&editId=<?php echo $flightQuotData['id']; ?>&flightDate='+encodeURI(flightDate)+'&ProcessingFeeType='+encodeURI(ProcessingFeeType)+'&processingFee='+encodeURI(processingFee)+'&airlineTaxA='+airlineTaxA+'&totalCostA='+totalCostA+'&airlineTaxC='+airlineTaxC+'&totalCostC='+totalCostC+'&airlineTaxE='+airlineTaxE+'&totalCostE='+totalCostE+'&adult='+flightAdultA+'&child='+flightChildC+'&infant='+flightInfantE+'&flightSupplier='+flightSupplierId+'&visaGstTaxId='+flightServiceTax);

		}else{
			alert('Please, Select Flight Name or Number');
		}
	}
	</script>
	</div>
	</div>

<?php
}


// Train block

if($_REQUEST['action']=="editQuotationTrainCost" && $_REQUEST['editId']!='' && $_REQUEST['quotationId']!=''){
	$editId = $_REQUEST['editId'];
	$quotationId = $_REQUEST['quotationId'];

	$rsqv = GetPageRecord('*','quotationTrainsMaster','quotationId="'.$_REQUEST['quotationId'].'" and id="'.$editId.'"');
	$trainQuotData = mysqli_fetch_assoc($rsqv)
?>
<style>
	.inboundpop{
		width: 80% !important;
	}
</style>
<div class="inboundheader" >Update Train Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
	<table width="60%" cellpadding="5" cellspacing="0" >
	
		<tr>
		<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Date<span class="redmind"></span></div>
					<input type="date" name="trainDateU" id="trainDateU" value="<?= date('Y-m-d',strtotime($trainQuotData['departureDate'])); ?>" class="gridfield1" displayname="ROI Value" style="width:105px;">
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">From&nbsp;Destination<span class="redmind"></span></div>
					
					<select name="trainFromDestionationU" id="trainFromDestionationU" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 114px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($fromDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $fromDestD['id']; ?>" <?php if($trainQuotData['departureFrom']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">To&nbsp;Destination<span class="redmind"></span></div>
					
					<select name="trainToDestionationU" id="trainToDestionationU" value="0" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 112px !important;">
					<?php 
					$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
					while($toDestD = mysqli_fetch_assoc($rsFD)){
						?>
						<option value="<?php echo $toDestD['id']; ?>" <?php if($trainQuotData['arrivalTo']==$toDestD['id']){ echo 'selected'; } ?> ><?php echo $toDestD['name']; ?></option>
						<?php
					}
					?>
					</select>
				</label>
			</div>
			</td>

			<td style="width: 100px">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Train&nbsp;Name<span class="redmind"></span></div>
				<select name="trainNameIdU" id="trainNameIdU" class="gridfield1 validate" displayname="Train Name" style="padding: 6px !important; width: 136px !important;">
					<option value="0">Select</option>
					<?php 
					$rsFQuery = GetPageRecord('*','packageBuilderTrainsMaster',' trainName!="" and status=1 order by trainName asc');
				 	while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){

						?>
						<option value="<?php echo $GuideData5['id']; ?>" <?php if($trainQuotData['trainId']==$GuideData5['id']){ echo 'selected'; } ?> ><?php echo strip($GuideData5['trainName']); ?></option>
						<?php
					}
					?>
				</select>
				</label>
			</div>
			</td> 

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Number<span class="redmind"></span></div>
					<input type="text" name="ftrainNumberU" id="ftrainNumberU" value="<?php echo $trainQuotData['trainNumber']; ?>" class="gridfield1" displayname="ROI Value" style="width:100px;">
				</label>
			</div>
			</td>

			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Train&nbsp;Class<span class="redmind"></span></div>
					<select id="ftrainClassU" name="ftrainClassU" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:110px;">
						<option value="AC First Class" <?php if($trainQuotData['trainClass']=='AC First Class'){ echo 'selected'; } ?> >AC First Class</option>
						<option value="AC 2-Tier" <?php if($trainQuotData['trainClass']=='AC 2-Tier'){ echo 'selected'; } ?> >AC 2-Tier</option>
						<option value="AC 3-Tier" <?php if($trainQuotData['trainClass']=='AC 3-Tier'){ echo 'selected'; } ?> >AC 3-Tier</option>
						<option value="First Class" <?php if($trainQuotData['trainClass']=='First Class'){ echo 'selected'; } ?>>First Class</option>
						<option value="AC Chair Car" <?php if($trainQuotData['trainClass']=='AC Chair Car'){ echo 'selected'; } ?>>AC Chair Car</option>
						<option value="Second Sitting" <?php if($trainQuotData['trainClass']=='Second Sitting'){ echo 'selected'; } ?>>Second Sitting</option>
						<option value="Sleeper" <?php if($trainQuotData['trainClass']=='Sleeper'){ echo 'selected'; } ?>>Sleeper</option>
					</select> 
				</label>
			</div>
			</td>

			<td style="width: 10%;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
				<select name="tcurrencyIdU" id="tcurrencyIdU" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
					<option value="">Select</option>
					<?php  
					$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
					$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);

					$rsc2='';
					$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
				 	while($currencyData=mysqli_fetch_array($rsc2)){
					?>
					<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
					<?php
				 	}
					?>
				</select>
				</label>
			</div>
			</td>
			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
					<input type="text" name="tcurrencyValueU" id="tcurrencyValueU" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
				</label>
			</div>
			</td>
			</tr>
			<tr>
			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="tadultCostU" id="tadultCostU" value="<?php echo $trainQuotData['adultCost']; ?>" class="gridfield1" displayname="Adult Cost" style="width:103px;">
					
				</label>
			</div>
			</td>
		

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
					<input type="text" name="tchildCostU" id="tchildCostU" value="<?php echo $trainQuotData['childCost']; ?>" class="gridfield1" displayname="Child Cost" style="width:100px;">
				</label>
			</div>
			</td>
		

			<td style="padding-right: 0px;">
			<div class="griddiv"><label>
				<div class="gridlable">Infant&nbsp;Cost</div>
					<input type="text" name="tinfantCostU" id="tinfantCostU" value="<?php echo $trainQuotData['infantCost']; ?>" class="gridfield1" displayname="Infant Cost" style="width:100px;">
				</label>
			</div>
			</td>

			<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee&nbsp;Type<span class="redmind"></span></div>
							<select name="TrainProcessingFeeType" id="TrainProcessingFeeType" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1" <?php if($trainQuotData['markupType']==1){ echo 'selected'; } ?> >%</option>
								<option value="2" <?php if($trainQuotData['markupType']==2){ echo 'selected'; } ?> >Flat(PP)</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="trainprocessingFee" id="trainprocessingFee" class="gridfield1" displayname="Processing Fee" value="<?php echo $trainQuotData['markupCost']; ?>" style="width: 104px !important;">
						</label>
					</div>
				</td>

			<td align="center">
				<div class="editbtnselect" id="selectthis" style="background: #233A49 !important;width:70px !important;margin-top: 5px;"  onclick="EditTrainCostToQuotation();" >Save
				</div>
			</td>
		
		</tr> 
	
			<input type="hidden" name="trainRateId" id="trainRateId" value="<?php echo $trainQuotData['rateId']; ?>">
			<input type="hidden" name="editId" id="editId" value="<?php echo $trainQuotData['id']; ?>">
		
		<!-- <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp; -->
	</tbody>
</table>
<div id="selectFlightCost" style="display:none;">loading...</div>
	<script>
	
		function EditTrainCostToQuotation(){
			
		var trainRateId = $("#trainRateId").val();
		var adultCost = $("#tadultCostU").val();
		var childCost = $("#tchildCostU").val();
		var infantCost = $("#tinfantCostU").val();
		var trainFromDestionation = $("#trainFromDestionationU").val();
		var trainToDestionation = $("#trainToDestionationU").val();
		var trainNameId = $("#trainNameIdU").val();
		var trainNumber = $("#ftrainNumberU").val();
		var trainClass = $("#ftrainClassU").val();
		
		var tcurrencyId = $("#tcurrencyId").val();
		var currencyValue = $("#tcurrencyValueU").val();

		var trainDate = $("#trainDateU").val();
		var TrainProcessingFeeType = $("#TrainProcessingFeeType").val();
		var trainprocessingFee = $("#trainprocessingFee").val();
		
		if(trainNumber>0 && trainNameId>0){

		$("#selectFlightCost").load('loadValueAddedserviceCost.php?action=saveTrainCosttoQuotation&trainRateId='+trainRateId+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&trainFromDestionation='+trainFromDestionation+'&trainToDestionation='+trainToDestionation+'&trainNameId='+trainNameId+'&ftrainNumber='+trainNumber+'&currencyId='+tcurrencyId+'&currencyValue='+currencyValue+'&ftrainClass='+encodeURI(trainClass)+'&quotationId=<?php echo $quotationId; ?>&editId=<?php echo $trainQuotData['id']; ?>&trainDate='+encodeURI(trainDate)+'&markupCost='+encodeURI(trainprocessingFee)+'&markupType='+encodeURI(TrainProcessingFeeType));

		}else{
			alert('Please, Select Train Name or Number');
		}
	}
	</script>
	</div>
	</div>

<?php
}


// Train block

if($_REQUEST['action']=="editQuotationTransferCost" && $_REQUEST['editId']!='' && $_REQUEST['quotationId']!=''){
	$editId = $_REQUEST['editId'];
	$quotationId = $_REQUEST['quotationId'];

	$rsqv = GetPageRecord('*','quotationTransferMaster','quotationId="'.$_REQUEST['quotationId'].'" and id="'.$editId.'"');
	$transferQuotData = mysqli_fetch_assoc($rsqv)
?>
<style>
	.inboundpop{
		width: 80% !important;
	}
</style>
<div class="inboundheader" >Update Transfer Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
	<table width="60%" cellpadding="5" cellspacing="0" >

			<tr>

			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Date<span class="redmind"></span></div>
						<input type="date" name="ttransferDateU" id="ttransferDateU"  class="gridfield1" value="<?= date('Y-m-d',strtotime($transferQuotData['fromDate'])); ?>" displayname="Train Date" style="width:100px;">
					</label>
				</div>
				</td>
	
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Destination<span class="redmind"></span></div>
						
						<select name="TransferDestionationU" id="TransferDestionationU" class="gridfield1" displayname="Train Destination" style="padding: 6px !important; width: 114px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id',_DESTINATION_MASTER_,'name!="" and status=1 and deletestatus=0 order by name asc');
						while($fromDestD = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $fromDestD['id']; ?>" <?php if($transferQuotData['destinationId']==$fromDestD['id']){ echo 'selected'; } ?> ><?php echo $fromDestD['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Transfer&nbsp;Type<span class="redmind"></span></div>
						
						<select name="transferTypeU" id="transferTypeU" value="0" class="gridfield1" displayname="Transfer Type" style="padding: 6px !important; width: 112px !important;">
						<?php 
						$rsFD = GetPageRecord('name,id','transferTypeMaster','name!="" and status=1 and deletestatus=0 order by name asc');
						while($transferType = mysqli_fetch_assoc($rsFD)){
							?>
							<option value="<?php echo $transferType['id']; ?>" <?php if($transferQuotData['transferQuotatoinType']==$transferType['id']){ echo 'selected'; } ?> ><?php echo $transferType['name']; ?></option>
							<?php
						}
						?>
						</select>
					</label>
				</div>
				</td>
	
				<td style="width: 100px">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Transfer&nbsp;Name<span class="redmind"></span></div>
					<select name="transferNameIdU" id="transferNameIdU" class="gridfield1 validate" displayname="Train Name" style="padding: 6px !important; width: 136px !important;">
						<option value="0">Select</option>
						<?php 
						$rsFQuery = GetPageRecord('*','packageBuilderTransportMaster',' transferName!="" and status=1 order by transferName asc');
						 while($GuideData5 = mysqli_fetch_assoc($rsFQuery)){
	
							?>
							<option value="<?php echo $GuideData5['id']; ?>" <?php if($transferQuotData['transferNameId']==$GuideData5['id']){ echo 'selected'; } ?> ><?php echo strip($GuideData5['transferName']); ?></option>
							<?php
						}
						?>
					</select>
					</label>
				</div>
				</td> 
	
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Type<span class="redmind"></span></div>
						<select name="sicpvtTypeU" id="sicpvtTypeU" onchange="selectTransferType();" style="width:112px;">
						<option value="1" <?php if($transferQuotData['transferType']==1){ echo 'selected'; } ?>>SIC</option>

						<!-- <option value="2" <?php if($transferQuotData['transferType']==2){ echo 'selected'; } ?>>PVT</option> -->
						</select>
					</label>
				</div>
				</td>
	
				<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Vehicle&nbsp;Type<span class="redmind"></span></div>
						<select id="vehicleTypeIdU" name="vehicleTypeIdU" class="gridfield1 validate" displayname="Flight Class" autocomplete="off" style="width:100px;padding:6px;">
							<?php 
								$rs = '';
								$rs = GetPageRecord('*','vehicleTypeMaster','name!="" and status=1');
								while($tptTypeData = mysqli_fetch_assoc($rs)){
							?>
							<option value="<?php echo $tptTypeData['id']; ?>" <?php if($transferQuotData['vehicleType']==$tptTypeData['id']){ echo 'selected'; } ?>><?php echo $tptTypeData['name']; ?></option>
							<?php } ?>
						</select> 
					</label>
				</div>
				</td>
	
				<td style="width: 10%;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div> 
					<select name="tfcurrencyIdU" id="tfcurrencyIdU" class="gridfield1 validate" onchange="getROE(this.value,'fcurrencyValue132');" displayname="Currency" style="padding: 6px !important;">
						<option value="">Select</option>
						<?php  
						$currencyId = ($visaRq['currencyId']>0)?$visaRq['currencyId']:$baseCurrencyId;
						$currencyValue = ($visaRq['currencyValue']>0)?$visaRq['currencyValue']:getCurrencyVal($currencyId);
	
						$rsc2='';
						$rsc2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,'status=1'); 
						 while($currencyData=mysqli_fetch_array($rsc2)){
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyId==$currencyData['id']){ echo "selected"; } ?> ><?php echo $currencyData['name']; ?></option>
						<?php
						 }
						?>
					</select>
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">R.O.E(<?php echo getCurrencyName($baseCurrencyId); ?>)<span class="redmind"></span></div>
						<input type="text" name="tfcurrencyValueU" id="tfcurrencyValueU" value="<?php echo trim($currencyValue); ?>" class="gridfield1" displayname="ROI Value">
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Rep&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="repCosttU" id="repCosttU" value="<?php echo $transferQuotData['representativeEntryFee']; ?>" class="gridfield1" displayname="Rep Cost">
						
					</label>
				</div>
				</td>
				</tr>

				<tr>
				<td style="padding-right: 0px;" class="SICClass">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="tfadultCostU" id="tfadultCostU" value="<?php echo $transferQuotData['adultCost']; ?>" class="gridfield1" displayname="Adult Cost" >
						
					</label>
				</div>
				</td>
	
				<td style="padding-right: 0px;" class="SICClass">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="text" name="tfchildCostU" id="tfchildCostU" value="<?php echo $transferQuotData['childCost']; ?>" class="gridfield1" displayname="Child Cost" style="width:100px;">
						
					</label>
				</div>
				</td>
			
	
				<td style="padding-right: 0px;" class="SICClass">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost</div>
						<input type="text" name="tfinfantCostU" id="tfinfantCostU" value="<?php echo $transferQuotData['infantCost']; ?>" class="gridfield1" displayname="Infant Cost" style="width:100px;">
						
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="PVTClass" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Vehicle&nbsp;Cost</div>
						<input type="text" name="vehicleCostU" id="vehicleCostU" value="<?php echo $transferQuotData['vehicleCost']; ?>" class="gridfield1" displayname="Vehicle Cost">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Parking&nbsp;Fee</div>
						<input type="text" name="parkingFeeU" id="parkingFeeU" value="<?php echo $transferQuotData['parkingFee']; ?>" class="gridfield1" displayname="Parking Fee" style="width:100px;">
					
					</label>
				</div>
				</td>
				
				<td style="padding-right: 0px;" class="PVTClass" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Assistance&nbsp;Fee</div>
						<input type="text" name="AssistanceFeeU" id="AssistanceFeeU" value="<?php echo $transferQuotData['assistance']; ?>" class="gridfield1" displayname="Assistance Fee" style="width:100px;">
					
					</label>
				</div>
				</td>

				<td style="padding-right: 0px;" class="PVTClass" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Additional&nbsp;Allowance</div>
						<input type="text" name="additionalAllowanceU" id="additionalAllowanceU" value="<?php echo $transferQuotData['guideAllowance']; ?>" class="gridfield1" displayname="Additional&nbsp;Allowance" style="width:123px;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Inter&nbsp;State&nbsp;&&nbsp;Toll</div>
						<input type="text" name="interStateU" id="interStateU" value="<?php echo $transferQuotData['interStateAndToll']; ?>" class="gridfield1" displayname="Additional&nbsp;Allowance" style="width:100px;">
					
					</label>
				</div>
				</td>
				<td style="padding-right: 0px;" class="PVTClass" style="display:none;">
				<div class="griddiv"><label>
					<div class="gridlable gridlable1">Misc&nbsp;Cost</div>
						<input type="text" name="misslaneousCostU" id="misslaneousCostU" value="<?php echo $transferQuotData['miscellaneous']; ?>" class="gridfield1" displayname="Additional&nbsp;Allowance">
					
					</label>
				</div>
				</td>

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee&nbsp;Type<span class="redmind"></span></div>
							<select name="TptProcessingFeeType" id="TptProcessingFeeType" class="gridfield1 validate" style="padding: 6px !important;width: 136px !important;">
								<option value="1" <?php if($transferQuotData['markupType']==1){ echo 'selected'; } ?> >%</option>
								<option value="2" <?php if($transferQuotData['markupType']==2){ echo 'selected'; } ?> >Flat(PP)</option>
							</select>
						</label>
					</div>
				</td> 

				<td align="left"  >
					<div class="griddiv">
						<label>
							<div class="gridlable gridlable1">Processing&nbsp;Fee</div>
							<input type="text" name="tptprocessingFee" id="tptprocessingFee" class="gridfield1" displayname="Processing Fee" value="<?php echo $transferQuotData['markupCost']; ?>" style="width: 104px !important;">
						</label>
					</div>
				</td>
				<td align="center">
				<div class="editbtnselect" id="selectthis" style="background: #233A49 !important;width:70px !important;margin-top: 5px;"  onclick="EditTrasferCostToQuotation();" >Save
				</div>
			</td>
			</tr> 
			<script>
					function selectTransferType(){
					var type = $("#sicpvtTypeU").val();
					if(type==1){
						$(".SICClass").show();
						$(".PVTClass").hide();
					}
					if(type==2){
						$(".SICClass").hide();
						$(".PVTClass").show();
					}
				}
				selectTransferType();
			</script>
	
			<input type="hidden" name="transferRateId" id="transferRateId" value="<?php echo $transferQuotData['rateId']; ?>">
			<input type="hidden" name="editId" id="editId" value="<?php echo $transferQuotData['id']; ?>">
		
		<!-- <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp; -->
	</tbody>
</table>
<div id="selectFlightCost" style="display:none;">loading...</div>
	<script>
	
		function EditTrasferCostToQuotation(){
			
			var transferNameId = $("#transferNameIdU").val();
			var ttransferDate = $("#ttransferDateU").val();
			var destinationId = $("#TransferDestionationU").val();
			var transferType = $("#transferTypeU").val();
			var sicpvtType = $("#sicpvtTypeU").val();
			var vehicleTypeId = $("#vehicleTypeIdU").val();
			var repCostt = $("#repCosttU").val();
			var adultCost = $("#tfadultCostU").val();
			var childCost = $("#tfchildCostU").val();
			var infantCost = $("#tfinfantCostU").val();
			var vehicleCost = $("#vehicleCostU").val();
			var parkingFee = $("#parkingFeeU").val();
			var AssistanceFee = $("#AssistanceFeeU").val();
			var additionalAllowance = $("#additionalAllowanceU").val();
			var interState = $("#interStateU").val();
			var misslaneousCost = $("#misslaneousCostU").val();
			var adultPax = $("#FadultPaxU").val();
			var childPax = $("#FchildPaxU").val();
			var infantPax = $("#FinfantPaxU").val();
			var tfcurrencyId = $("#tfcurrencyIdU").val();
			var currencyValue132 = $("#tcurrencyValue132U").val();
			var tfcurrencyValue = $("#tfcurrencyValueU").val();
			var TptProcessingFeeType = $("#TptProcessingFeeType").val();
			var tptprocessingFee = $("#tptprocessingFee").val();

			if(transferNameId>0){
	
			$("#selectTraincost").load('loadValueAddedserviceCost.php?action=saveTransferCosttoQuotation&transferNameId='+transferNameId+'&transferType='+transferType+'&sicpvtType='+encodeURI(sicpvtType)+'&adultCost='+adultCost+'&childCost='+childCost+'&infantCost='+infantCost+'&adultPax='+adultPax+'&childPax='+childPax+'&infantPax='+infantPax+'&currencyId='+tfcurrencyId+'&currencyValue='+currencyValue132+'&quotationId=<?php echo $quotationId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&ttransferDate='+encodeURI(ttransferDate)+'&destinationId='+encodeURI(destinationId)+'&vehicleTypeId='+vehicleTypeId+'&repCost='+repCostt+'&vehicleCost='+vehicleCost+'&parkingFee='+parkingFee+'&AssistanceFee='+AssistanceFee+'&additionalAllowance='+additionalAllowance+'&interState='+interState+'&misslaneousCost='+misslaneousCost+'&markupType='+TptProcessingFeeType+'&markupCost='+tptprocessingFee+'&editId=<?php echo $transferQuotData['id']; ?>');
			}else{
				alert('Please, Select Transfer Name');
			}
	}
	</script>
	</div>
	</div>

<?php
}

if($_REQUEST['action']=="editCompletePackageCost" && $_REQUEST['editId']>0 && $_REQUEST['quotationId']!=''){

	$checkPackageRateQuery="";
	$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster','id="'.$_REQUEST['editId'].'" and quotationId="'.$_REQUEST['quotationId'].'" order by id asc');
	$packageRateData=mysqli_fetch_array($checkPackageRateQuery);
?>
<style>
	.gridfield1 {
    padding: 4px;
    width: 70px;
}
</style>
<div class="inboundheader" >Update Package Rate <i class="fa fa-times" aria-hidden="true" style="position: absolute; right: 15px; font-size: 18px; color: #fff; cursor:pointer; " onClick="closeinbound();"></i>&nbsp;</div>
	<div style="padding:10px;" id="hotelBox">
	<div class="addeditpagebox addtopaboxlist" id="hotelBoxSearch" style="padding:0px; max-height: 500px; overflow: auto;">
	<table width="60%" cellpadding="5" cellspacing="0" >

			<tr>

			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Supplier<span class="redmind"></span></div>
					<select name="PKGsupplierId" id="PKGsupplierId" style="width:160px;">
						<?php 
						$supplierQuery = GetPageRecord('id,name',_SUPPLIERS_MASTER_,' 1 and name!="" and deletestatus=0 and status=1 order by name asc');
						while($supplierData = mysqli_fetch_array($supplierQuery)){ ?>
						<option value="<?php echo $supplierData['id']; ?>" <?php if($packageRateData['supplierId']==$supplierData['id']){ echo 'selected'; } ?>><?php echo $supplierData['name']; ?></option>
						<?php } ?>
						</select>
					</label>
				</div>
			</td>
			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Service&nbsp;Type<span class="redmind"></span></div>
					<select name="PKGserviceTypeID" id="PKGserviceTypeID" onchange="showAdditionalCost2();" class="packageCostDiv_selectbox">
						<option value="1" <?php if($packageRateData['serviceType']==1){ echo 'selected'; } ?>>Land Package</option>
						<option value="2" <?php if($packageRateData['serviceType']==2){ echo 'selected'; } ?>>Additional</option>
						</select>
					</label>
				</div>
			</td>
			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Service&nbsp;Name<span class="redmind"></span></div>
					<input type="text" name="PKGserviceName" id="PKGserviceName" class="gridfield1" value="<?php echo $packageRateData['serviceName']; ?>" style="width:110px;">
					</label>
				</div>
			</td>
			<?php if($quotationData['quotationType']==2 || $quotationData['quotationType']==3){ ?>
			<td>
			<div class="griddiv "><label>
				<div class="gridlable gridlable1">Package&nbsp;Category<span class="redmind"></span></div>
					<?php if($quotationData['quotationType']==2){ ?>
						<select name="hotelCategoryId" id="hotelCategoryId1" class="packageCostDiv_selectbox">
							<option value="">Select Category</option>
							<?php 
							$hotelCategory = explode(',',$quotationData['hotCategory']);
							foreach($hotelCategory as $val){
							$HQuery = GetPageRecord('id,hotelCategory',_HOTEL_CATEGORY_MASTER_,' 1 and deletestatus=0 and status=1 and id="'.$val.'" order by hotelCategory asc');
							$hotelCategoryData = mysqli_fetch_array($HQuery); ?>
							<option value="<?php echo $hotelCategoryData['id']; ?>" ><?php echo $hotelCategoryData['hotelCategory'].' Star'; ?></option>
							<?php } ?>
						</select>
						<?php } ?>

						<?php if($quotationData['quotationType']==3){ ?>
						<select name="hotelTypeId" id="hotelTypeId1" class="packageCostDiv_selectbox">
							<option value="">Select Category</option>
							<?php 
							$hotelType = explode(',',$quotationData['hotelType']);
							foreach($hotelType as $val2){
							$HQuery = GetPageRecord('id,name','hotelTypeMaster',' 1 and deletestatus=0 and status=1 and id="'.$val2.'" order by name asc');
							$hotelTypeData = mysqli_fetch_array($HQuery); ?>
							<option value="<?php echo $hotelTypeData['id']; ?>"><?php echo $hotelTypeData['name']; ?></option>
							<?php } ?>
						</select>
					<?php } ?>
					</label>
			</div>
			</td>
			<?php } ?>
			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Markup&nbsp;Type<span class="redmind"></span></div>
					<select name="PKGmarkupType" id="PKGmarkupType" class="gridfield1 validate" style="padding: 6px !important;width: 92px !important;">
						<option value="1" <?php if($packageRateData['markupType']==1){ echo 'selected'; } ?>>%</option>
						<option value="2" <?php if($packageRateData['markupType']==2){ echo 'selected'; } ?>>Flat(PP)</option>
					</select>
					</label>
				</div>
			</td>
			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Markup&nbsp;Value<span class="redmind"></span></div>
					<input type="text" name="PKGmarkupValue" id="PKGmarkupValue" value="<?php echo $packageRateData['markupValue']; ?>" class="gridfield1" displayname="Processing Fee" style="width: 85px !important;">
					</label>
				</div>
			</td>
			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Tax&nbsp;Slab<span class="redmind"></span></div>
					<select id="PKGserviceTaxId" name="PKGserviceTaxId" class="gridfield" displayname="GST" autocomplete="off" style="padding: 6px !important;width:120px">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($packageRateData['gstTax']==$gstSlabData['id']){ echo 'selected'; } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
					</label>
				</div>
			</td>
			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Currency<span class="redmind"></span></div>
					<select name="PKGcurrencyId" id="PKGcurrencyId" class="packageCostDiv_selectbox" onchange="getROE(this.value,'PKGcurrencyIdVal');" style="width: 70px;">
							<option disabled value="">Select Currency</option>
							<?php 
							$currencyQuery = GetPageRecord('id,name',_CURRENCY_MASTER_,' 1  and name!="" and deletestatus=0 and status=1 order by setDefault desc');
							while($currencyData = mysqli_fetch_array($currencyQuery)){ ?>
							<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyData['id']==$packageRateData['currencyId']){ echo "selected"; } ?>><?php echo $currencyData['name']; ?></option>
							<?php } ?>
						</select>
					</label>
				</div>
			</td>
			<td>
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">ROE<span class="redmind"></span></div>
					<input type="text" name="dayroe" id="PKGcurrencyIdVal" class="gridfield1" value="<?php echo $packageRateData['ROE']; ?>" style="width: 74px; padding: 4px;">
					</label>
				</div>
			</td>
			<td style="display: none;" class="costTypeCls">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Cost&nbsp;Type<span class="redmind"></span></div>
					<select name="PKGcostTypeId" id="PKGcostTypeId" onchange="getGroupCost2();" class="additionalCost packageCostDiv_selectbox">
							<option value="1" <?php if($packageRateData['costTypeId']==1){ echo 'selected'; } ?>>Per Person Cost</option>
							<option value="2" <?php if($packageRateData['costTypeId']==2){ echo 'selected'; } ?>>Group Cost</option>
						</select>
					</label>
				</div>
			</td>

			</tr>
			<tr>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Single&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGsingleBasis" id="PKGsingleBasis" class="gridfield1" value="<?php echo $packageRateData['singleBasis']; ?>" style="width: 150px;">
					</label>
				</div>
			</td>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Double&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGdoubleBasis" id="PKGdoubleBasis" class="gridfield1" value="<?php echo $packageRateData['doubleBasis']; ?>" style="width: 112px;">
					</label>
				</div>
			</td>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Triple&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGtripleBasis" id="PKGtripleBasis" class="gridfield1" value="<?php echo $packageRateData['tripleBasis']; ?>" style="width: 110px;">
					</label>
				</div>
			</td>
			<?php if(isRoomActive('quadroom')==true){ ?>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Quad&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGquadBasis" id="PKGquadBasis" class="gridfield1" value="<?php echo $packageRateData['quadBasis']; ?>"  style="width: 80px;">
						
					</label>
				</div>
			</td>
			<?php } if(isRoomActive('sixbedroom')==true){  ?>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Six&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGsixBedBasis" id="PKGsixBedBasis" class="gridfield1" value="<?php echo $packageRateData['sixBedBasis']; ?>">
						
					</label>
				</div>
			</td>
			<?php } if(isRoomActive('eightbedroom')==true){  ?>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Eight&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGeightBedBasis" id="PKGeightBedBasis" class="gridfield1" value="<?php echo $packageRateData['eightBedBasis']; ?>">
						
					</label>
				</div>
			</td>
			<?php } if(isRoomActive('tenbedroom')==true){  ?>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Ten&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGtenBedBasis" id="PKGtenBedBasis" class="gridfield1" value="<?php echo $packageRateData['tenBedBasis']; ?>">
						
					</label>
				</div>
			</td>
			<?php } if(isRoomActive('teenbed')==true){  ?>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Teen&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGteenBedBasis" id="PKGteenBedBasis" class="gridfield1" value="<?php echo $packageRateData['teenBedBasis']; ?>">
						
					</label>
				</div>
			</td>
			<?php } ?>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">ExtraBA&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGextraBedABasis" id="PKGextraBedABasis" class="gridfield1" value="<?php echo $packageRateData['extraBedABasis']; ?>" style="width: 108px;">
						
					</label>
				</div>
			</td>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">ExtraB(C)<span class="redmind"></span></div>
						<input type="number" name="PKGchildwithbedBasis" id="PKGchildwithbedBasis" class="gridfield1" value="<?php echo $packageRateData['childwithbedBasis']; ?>" style="width: 63px;">
						
					</label>
				</div>
			</td>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">ExtraNB(C)<span class="redmind"></span></div>
						<input type="number" name="PKGchildwithoutbedBasis" id="PKGchildwithoutbedBasis" class="gridfield1" value="<?php echo $packageRateData['childwithoutbedBasis']; ?>">
						
					</label>
				</div>
			</td>
			<td class="landPKGCLS">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Infant&nbsp;Basis<span class="redmind"></span></div>
						<input type="number" name="PKGinfantBasisCost" id="PKGinfantBasisCost" class="gridfield1" value="<?php echo $packageRateData['infantBedBasis']; ?>">
						
					</label>
				</div>
			</td>
			<td class="addPKGCLSGP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Group&nbsp;Cost<span class="redmind"></span></div>
						<input type="number" name="PKGgroupCost" id="PKGgroupCost" placeholder="Group Cost" class="gridfield1" value="<?php echo $packageRateData['groupCost']; ?>">
						
					</label>
				</div>
			</td>
			<?php if($packageRateData['costTypeId']==2){ ?>
			<td class="addPKGCLSGP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Total&nbsp;Pax<span class="redmind"></span></div>
						<input type="number" name="PKGadultPax" id="PKGadultPax" placeholder="Adult Pax" class="gridfield1" value="<?php echo $packageRateData['adultPax']; ?>">
						
					</label>
				</div>
			</td>
			<?php } ?>
			<td class="addPKGCLSPP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Adult&nbsp;Cost<span class="redmind"></span></div>
						<input type="number" name="PKGadultCost" id="PKGadultCost" placeholder="Adult Cost" class="gridfield1" value="<?php echo $packageRateData['adultCost']; ?>">
						
					</label>
				</div>
			</td>
			<?php if($packageRateData['costTypeId']==1){ ?>
			<td class="addPKGCLSPP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Adult&nbsp;Pax<span class="redmind"></span></div>
						<input type="number" name="PKGadultPax" id="PKGadultPax" placeholder="Adult Pax" class="gridfield1" value="<?php echo $packageRateData['adultPax']; ?>">
						
					</label>
				</div>
			</td>
			<?php } ?>
			<td class="addPKGCLSPP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Child&nbsp;Cost<span class="redmind"></span></div>
						<input type="number" name="PKGchildCost" id="PKGchildCost" placeholder="Adult Cost" class="gridfield1" value="<?php echo $packageRateData['ChildCost']; ?>">
						
					</label>
				</div>
			</td>
			<td class="addPKGCLSPP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Child&nbsp;Pax<span class="redmind"></span></div>
						<input type="number" name="PKGchildPax" id="PKGchildPax" placeholder="Adult Pax" class="gridfield1" value="<?php echo $packageRateData['ChildPax']; ?>">
						
					</label>
				</div>
			</td>
			<td class="addPKGCLSPP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Infant&nbsp;Cost<span class="redmind"></span></div>
						<input type="number" name="PKGinfantCost" id="PKGinfantCost" placeholder="Adult Cost" class="gridfield1" value="<?php echo $packageRateData['infantCost']; ?>">
						
					</label>
				</div>
			</td>
			<td class="addPKGCLSPP" style="display:none;">
				<div class="griddiv "><label>
					<div class="gridlable gridlable1">Infant&nbsp;Pax<span class="redmind"></span></div>
						<input type="number" name="PKGinfantPax" id="PKGinfantPax" placeholder="Adult Pax" class="gridfield1" value="<?php echo $packageRateData['infantPax']; ?>">
						
					</label>
				</div>
			</td>
			<td align="center">
				<div class="editbtnselect" id="selectthis" style="background: #233A49 !important;width:70px !important;margin-top: 5px;"  onclick="updateCompletePackageCost();" >Save
				</div>
			</td>
			</tr>
	</table>
	<div id="updatePackageRate"></div>
	<script>
		
		function updateCompletePackageCost(){
				var supplierId = $('#PKGsupplierId').val();
  				var currencyId = $('#PKGcurrencyId').val();
  				var singleBasis = $('#PKGsingleBasis').val();
				var doubleBasis = $('#PKGdoubleBasis').val();
				var twinBasis = $('#PKGtwinBasis').val();
				var tripleBasis = $('#PKGtripleBasis').val();

				var quadBasis = $('#PKGquadBasis').val();
				var sixBedBasis = $('#PKGsixBedBasis').val();
				var eightBedBasis = $('#PKGeightBedBasis').val();
				var tenBedBasis = $('#PKGtenBedBasis').val();

				var extraBedABasis = $('#PKGextraBedABasis').val();
				var childwithbedBasis = $('#PKGchildwithbedBasis').val();
				var childwithoutbedBasis = $('#PKGchildwithoutbedBasis').val();
				var infantBasisCost = $('#PKGinfantBasisCost').val();
				var teenBedBasis = $('#PKGteenBedBasis').val();
				var hotelCategoryId = $('#PKGhotelCategoryId').val();
				var hotelTypeId = $('#PKGhotelTypeId').val();
				var loopNum = $('#PKGloopNum').val();
				var rateNumloop = $('#PKGrateNumloop').val();
				var serviceTypeID = $('#PKGserviceTypeID').val();
			
				var serviceName = $('#PKGserviceName').val();
				var markupType = $('#PKGmarkupType').val();
				var markupValue = $('#PKGmarkupValue').val();
				var serviceTaxId = $('#PKGserviceTaxId').val();
				var currencyIdVal = $('#PKGcurrencyIdVal').val();
				var costTypeId = $('#PKGcostTypeId').val();

				var groupCost = $('#PKGgroupCost').val();
				var adultCost = $('#PKGadultCost').val();
				var adultPax = $('#PKGadultPax').val();
				var ChildCost = $('#PKGchildCost').val();
				var ChildPax = $('#PKGchildPax').val();
				var infantCost = $('#PKGinfantCost').val();
				var infantPax = $('#PKGinfantPax').val();
				
				$('#updatePackageRate').load('loadPackageWiseCost.php?action=cp_PPCost&calculationType=3&quotationId=<?php echo encode($packageRateData['quotationId']); ?>&supplierId='+supplierId+'&currencyId='+currencyId+'&singleBasis='+singleBasis+'&doubleBasis='+doubleBasis+'&twinBasis='+twinBasis+'&tripleBasis='+tripleBasis+'&quadBasis='+quadBasis+'&sixBedBasis='+sixBedBasis+'&eightBedBasis='+eightBedBasis+'&tenBedBasis='+tenBedBasis+'&extraBedABasis='+extraBedABasis+'&childwithbedBasis='+childwithbedBasis+'&childwithoutbedBasis='+childwithoutbedBasis+'&infantBasisCost='+infantBasisCost+'&teenBedBasis='+teenBedBasis+'&hotelCategoryId='+hotelCategoryId+'&hotelTypeId='+hotelTypeId+'&loop='+rateNumloop+'&loopNum='+loopNum+'&serviceTypeID='+serviceTypeID+'&serviceName='+encodeURI(serviceName)+'&markupType='+markupType+'&markupValue='+markupValue+'&serviceTax='+serviceTaxId+'&currencyIdVal='+currencyIdVal+'&costTypeId='+costTypeId+'&adultCost='+adultCost+'&adultPax='+adultPax+'&ChildCost='+ChildCost+'&ChildPax='+ChildPax+'&infantCost='+infantCost+'&infantPax='+infantPax+'&groupCost='+groupCost+'&editId=<?php echo $packageRateData['id']; ?>');
		}

		function showAdditionalCost2(){
			var serviceType = $("#PKGserviceTypeID").val();
			if(serviceType==1){
				$(".costTypeCls").hide();
				$(".addPKGCLSPP").hide();
				$(".landPKGCLS").show();
			}
			if(serviceType==2){
				$(".costTypeCls").show();
				$(".addPKGCLSPP").show();
				$(".landPKGCLS").hide();
			}
		}
		showAdditionalCost2();

		function getGroupCost2(){
			var costType = $("#PKGcostTypeId").val();
			if(costType==1){
				$(".addPKGCLSGP").hide();
				$(".addPKGCLSPP").show();
			}
			if(costType==2){
				$(".addPKGCLSGP").show();
				$(".addPKGCLSPP").hide();
			}
		}
		<?php if($packageRateData['serviceType']==2){ ?>
		getGroupCost2();
		<?php } ?>
	</script>
	</div>
	</div>
	
<?php
}

if($_REQUEST['action'] == 'deletePassQuotationRate' && $_REQUEST['quoteRateId']!='' && $_REQUEST['quotationId']!='' ){
	deleteRecord('quotationPassportRateMaster','id = "'.$_REQUEST['quoteRateId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['quoteRateId'].'" and serviceType="passport" and quotationId="'.$_REQUEST['quotationId'].'"');
   ?>
   <script>
	   warningalert('Passport Rate Deleted!');
	//    loadquotationmainfile();
	//    needValueAddedServices('passportRequirementAct');
	   window.location.reload();
   </script>
   <?php
}


if($_REQUEST['action'] == 'deleteVisaQuotationRate' && $_REQUEST['quoteRateId']!='' && $_REQUEST['quotationId']!='' ){
	deleteRecord('quotationVisaRateMaster','id = "'.$_REQUEST['quoteRateId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
	deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['quoteRateId'].'" and serviceType="visa" and quotationId="'.$_REQUEST['quotationId'].'"');
   ?>
   <script>
	   warningalert('Visa Rate Deleted!');
	//    loadquotationmainfile();
	//    needValueAddedServices('visaRequirementAct');
	   window.location.reload();
   </script>
   <?php
}


if($_REQUEST['action'] == 'deleteInsuranceQuotationRate' && $_REQUEST['quoteRateId']!='' && $_REQUEST['quotationId']!='' ){
	deleteRecord('quotationInsuranceRateMaster','id = "'.$_REQUEST['quoteRateId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
   deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['quoteRateId'].'" and serviceType="insurance" and quotationId="'.$_REQUEST['quotationId'].'"');
   ?>
   <script>
	   warningalert('Insurance Rate Deleted!');
	//    loadquotationmainfile();
	//    needValueAddedServices('insuranceRequirementAct');
	window.location.reload();
   </script>
   <?php
}

if($_REQUEST['action'] == 'deleteFlightQuotationRate' && $_REQUEST['quoteRateId']!='' && $_REQUEST['quotationId']!='' ){
	deleteRecord('quotationFlightMaster','id = "'.$_REQUEST['quoteRateId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
   deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['quoteRateId'].'" and serviceType="flight" and quotationId="'.$_REQUEST['quotationId'].'"');
   ?>
   <script>
	   warningalert('Flight Rate Deleted!');
	//    loadquotationmainfile();
	//    needValueAddedServices('insuranceRequirementAct');
	window.location.reload();
   </script>
   <?php
}

if($_REQUEST['action'] == 'deleteTrainQuotationRate' && $_REQUEST['quoteRateId']!='' && $_REQUEST['quotationId']!='' ){
	deleteRecord('quotationTrainsMaster','id = "'.$_REQUEST['quoteRateId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
   deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['quoteRateId'].'" and serviceType="train" and quotationId="'.$_REQUEST['quotationId'].'"');
   ?>
   <script>
	   warningalert('Train Rate Deleted!');
	//    loadquotationmainfile();
	//    needValueAddedServices('insuranceRequirementAct');
	window.location.reload();
   </script>
   <?php
}

if($_REQUEST['action'] == 'deleteTransferQuotationRate' && $_REQUEST['quoteRateId']!='' && $_REQUEST['quotationId']!='' ){
	deleteRecord('quotationTransferMaster','id = "'.$_REQUEST['quoteRateId'].'" and quotationId="'.$_REQUEST['quotationId'].'"');
   deleteRecord('quotationItinerary','serviceId="'.$_REQUEST['quoteRateId'].'" and serviceType="transfer" and quotationId="'.$_REQUEST['quotationId'].'"');
   ?>
   <script>
	   warningalert('Transfer Rate Deleted!');
	//    loadquotationmainfile();
	//    needValueAddedServices('insuranceRequirementAct');
	window.location.reload();
   </script>
   <?php
}


if($_REQUEST['serviceId']=='' && $_REQUEST['action']!='' ){ ?>
<style>
.gridtable td {
    padding: 0px 2px;
}
.addeditpagebox .griddiv {
    margin-bottom: 10px;
}
.editbtnselect {
    border: 1px solid;
    text-align: center;
    font-size: 13px;
    border-radius: 3px;
    background-color: #4caf50;
    cursor: pointer;
    color: #fff;
    width: fit-content !important;
    padding: 8px !important;
}
.griddiv{font-size:12px; text-transform:uppercase; color:#999999;}
.addeditpagebox .griddiv .gridlable {
    width: 100% !important;
}
.editbtnselect, .addBtn1{
	border: 1px solid;
	padding: 8px 15px;
	text-align: center;
	font-size: 13px;
	border-radius: 3px;
	background-color: #4caf50;
	cursor: pointer;
	color: #fff;
}
.addBtn1{
	width: fit-content !important;
	position: absolute;
	right: 30px;
	top: 2px;
	padding: 8px 12px !important;
	background-color: #7a96ff;
}
.guideselect{
	padding: 5px 10px;
    border-radius: 3px;
    width: 96%;
}
.guideformbox{
	/*position: absolute;
    top: -34px;
    width: 30%;
    right: 54px;
	*/
	position: absolute;
    top: -50px;
    left: 10px;
    width: 30%;
    right: auto;
}


.editbtnselectprice{
		padding: 8px 13px !important;
    background-color: #589fa6;
    width: 67px;
    color: #fff;
    font-size: 13px;
    border-radius: 3px;
    cursor: pointer;
	}
</style>


<?php }



?>
