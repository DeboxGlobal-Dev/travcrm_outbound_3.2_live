<?php
ob_start();
include "inc.php";
include "config/logincheck.php";

if(trim($_REQUEST['action'])=='addServices' && $_REQUEST['queryId']!='' && $_REQUEST['cityId']!='' && $_REQUEST['sType']!=''){
	$sType = $_REQUEST['sType'];
	if($sType == 'hotel'){
		$cityId = $_REQUEST['cityId'];
		$serviceId = $_REQUEST['serviceId'];
		$rateId = $_REQUEST['rateId'];
		$roomTypeId = $_REQUEST['roomTypeId'];
		$mealPlanId = $_REQUEST['mealPlanId'];
		$serviceCost = $_REQUEST['totalHotelCost'];
		$mealCost = $_REQUEST['totalMealCost'];
		$GST = $_REQUEST['roomGST'];
		$mealGST = $_REQUEST['mealGST'];
		$roomTAC = $_REQUEST['roomTAC'];
		$markupCost = $_REQUEST['markupCost'];
		$markupType = $_REQUEST['markupType'];
		$fromDate = date('Y-m-d',($_REQUEST['fromDate']));
		$toDate = date('Y-m-d',($_REQUEST['toDate']));
		$queryId = $_REQUEST['queryId'];
		$namevalue1 ='cityId="'.$cityId.'",serviceId="'.$serviceId.'",serviceType="'.$sType.'",serviceCost="'.$serviceCost.'",mealCost="'.$mealCost.'",GST="'.$GST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",roomTypeId="'.$roomTypeId.'",mealPlanId="'.$mealPlanId.'",rateId="'.$rateId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$srn.'"'; 
	}
	if($sType == 'transportation'){
		$cityId = $_REQUEST['cityId'];
		$serviceId = $_REQUEST['serviceId'];
		$rateId = $_REQUEST['rateId'];
		$serviceCost = $_REQUEST['serviceCost'];
		$GST = $_REQUEST['gstTax'];
		$markupCost = $_REQUEST['markupCost'];
		$markupType = $_REQUEST['markupType'];
		$fromDate = date('Y-m-d',($_REQUEST['fromDate']));
		$toDate = date('Y-m-d',($_REQUEST['toDate']));
		$queryId = $_REQUEST['queryId'];
		$namevalue1 ='cityId="'.$cityId.'",serviceId="'.$serviceId.'",serviceType="'.$sType.'",serviceCost="'.$serviceCost.'",mealCost="'.$mealCost.'",GST="'.$GST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",roomTypeId="'.$roomTypeId.'",mealPlanId="'.$mealPlanId.'",rateId="'.$rateId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$srn.'"'; 
	}
	if($sType == 'restaurant'){
		$cityId = $_REQUEST['cityId'];
		$serviceId = $_REQUEST['serviceId'];
		$rateId = $_REQUEST['rateId'];
		$serviceCost = $_REQUEST['serviceCost'];
		$GST = $_REQUEST['GST'];
		$markupCost = $_REQUEST['markupCost'];
		$markupType = $_REQUEST['markupType'];
		$fromDate = date('Y-m-d',($_REQUEST['fromDate']));
		$toDate = date('Y-m-d',($_REQUEST['toDate']));
		$queryId = $_REQUEST['queryId'];
		$namevalue1 ='cityId="'.$cityId.'",serviceId="'.$serviceId.'",serviceType="'.$sType.'",serviceCost="'.$serviceCost.'",mealCost="'.$mealCost.'",GST="'.$GST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",roomTypeId="'.$roomTypeId.'",mealPlanId="'.$mealPlanId.'",rateId="'.$rateId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$srn.'"'; 
	}
	if($sType == 'entrance'){
		$cityId = $_REQUEST['cityId'];
		$serviceId = $_REQUEST['serviceId'];
		$rateId = $_REQUEST['rateId'];
		$serviceCost = $_REQUEST['serviceCost'];
		$GST = $_REQUEST['GST'];
		$markupCost = $_REQUEST['markupCost'];
		$markupType = $_REQUEST['markupType'];
		$fromDate = date('Y-m-d',($_REQUEST['fromDate']));
		$toDate = date('Y-m-d',($_REQUEST['toDate']));
		$queryId = $_REQUEST['queryId'];
		$namevalue1 ='cityId="'.$cityId.'",serviceId="'.$serviceId.'",serviceType="'.$sType.'",serviceCost="'.$serviceCost.'",mealCost="'.$mealCost.'",GST="'.$GST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",roomTypeId="'.$roomTypeId.'",mealPlanId="'.$mealPlanId.'",rateId="'.$rateId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$srn.'"'; 
	}
	if($sType == 'activity'){
		$cityId = $_REQUEST['cityId'];
		$serviceId = $_REQUEST['serviceId'];
		$rateId = $_REQUEST['rateId'];
		$serviceCost = $_REQUEST['serviceCost'];
		$GST = $_REQUEST['GST'];
		$markupCost = $_REQUEST['markupCost'];
		$markupType = $_REQUEST['markupType'];
		$fromDate = date('Y-m-d',($_REQUEST['fromDate']));
		$toDate = date('Y-m-d',($_REQUEST['toDate']));
		$queryId = $_REQUEST['queryId'];
		$namevalue1 ='cityId="'.$cityId.'",serviceId="'.$serviceId.'",serviceType="'.$sType.'",serviceCost="'.$serviceCost.'",mealCost="'.$mealCost.'",GST="'.$GST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",roomTypeId="'.$roomTypeId.'",mealPlanId="'.$mealPlanId.'",rateId="'.$rateId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$srn.'"'; 
	}

	// add services 
	$lastid=addlistinggetlastid('docketServiceItinerary',$namevalue1); 

	if($lastid> 0){
		$updateDateQuery=GetPageRecord('min(startDate) as fromDate, max(endDate) as toDate','docketServiceItinerary','queryId="'.$queryId.'"'); 
		$updateData=mysqli_fetch_array($updateDateQuery); 

		$editfromDate = date('Y-m-d',($updateData['fromDate']));
		$edittoDate = date('Y-m-d',($updateData['toDate']));


		$objec=date_diff(date_create($editfromDate),date_create($edittoDate));
		$editnight = $objec->format("%a");

		//provisino to edit for this quotation
		updatelisting(_QUERY_MASTER_,'fromDate="'.$editfromDate.'",toDate="'.$edittoDate.'",night="'.$editnight.'",travelDate="'.$editfromDate.'",queryDate="'.$editfromDate.'"','id="'.$queryId.'"');

		?>
		<script type="text/javascript"> 
			loadDocketServices(); 
		</script>
		<?php
	}
}

if(trim($_REQUEST['action'])=='deleteService' && $_REQUEST['DLT_Id']!='' ){

	deleteRecord('docketServiceItinerary','id="'.$_REQUEST['DLT_Id'].'"');
	?>
	<script type="text/javascript"> 
		parent.docket_alertboxClose();
		parent.loadDocketServices(); 
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
	</script>
	<?php

}

if(trim($_REQUEST['action'])=='changeDocketStatus' && $_REQUEST['queryId']!='' ){
	$queryStatus = $_REQUEST['queryStatus'];
	$queryId = $_REQUEST['queryId'];
	//provisino to edit for this quotation
	updatelisting(_QUERY_MASTER_,'queryStatus="'.$queryStatus.'"','id="'.$queryId.'"');

}

if(trim($_REQUEST['action'])=='loadDocketHotelBreakupCost' && $_REQUEST['BKP_serviceId']!='' && $_REQUEST['BKP_queryId']!=''){
	$editId=clean($_REQUEST['BKP_editId']);
	$rateId=clean($_REQUEST['BKP_rateId']);
	$serviceId=clean($_REQUEST['BKP_serviceId']);
	$fromDate=clean($_REQUEST['BKP_fromDate']);
	$toDate=clean($_REQUEST['BKP_toDate']);
	$queryId=clean($_REQUEST['BKP_queryId']);
	$seasonType=clean($_REQUEST['BKP_seasonType']);
	$supplierId=clean($_REQUEST['BKP_supplierId']);
	$currencyId=clean($_REQUEST['BKP_currencyId']);
	$markupType=clean($_REQUEST['BKP_MarkupType']);
	$markupCost=clean($_REQUEST['BKP_Markup']);
	$roomGST=clean($_REQUEST['BKP_RoomGST']);
	$mealGST=clean($_REQUEST['BKP_mealGST']);
	$roomTypeId=clean($_REQUEST['BKP_RoomTypeId']);
	$mealPlanId=clean($_REQUEST['BKP_MealPlanId']);
	$singleCost=clean($_REQUEST['BKP_singleCost']);
	$doubleCost=clean($_REQUEST['BKP_doubleCost']);
	$extraBedACost=clean($_REQUEST['BKP_ExtraBedACost']);
	$extraBedCCost=clean($_REQUEST['BKP_ExtraBedCCost']);
	$breakfastCost=clean($_REQUEST['BKP_breakfastCost']);
	$lunchCost=clean($_REQUEST['BKP_lunchCost']);
	$dinnerCost=clean($_REQUEST['BKP_dinnerCost']);
	$roomTAC=clean($_REQUEST['BKP_TAC']);
	$remarks=clean($_REQUEST['BKP_remarks']);



	if($editId>0 && $queryId!=''){
		//provisino to edit for this quotation
		$namevalue ='fromDate="'.$fromDate.'",toDate="'.$toDate.'",roomType="'.$roomTypeId.'",mealPlan="'.$mealPlanId.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",singleoccupancy="'.$singleCost.'",doubleoccupancy="'.$doubleCost.'",extraBedA="'.$extraBedACost.'",extraBedC="'.$extraBedCCost.'",breakfast="'.$breakfastCost.'",lunch="'.$lunchCost.'",dinner="'.$dinnerCost.'",currencyId="'.$currencyId.'",status=1,supplierId="'.$supplierId.'",serviceId="'.$serviceId.'",tarifType=1,seasonType="'.$seasonType.'",marketType="'.$marketId.'",roomGST="'.$roomGST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",remarks="'.$remarks.'"';
		$where='id="'.$editId.'" and queryId="'.$queryId.'"';
		updatelisting('docketHotelRateMaster',$namevalue,$where);
	}else{
	 	//provisino to add new for this quotation
		$namevalue ='rateId="'.$rateId.'",queryId="'.$queryId.'",marketType="'.$marketId.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",roomType="'.$roomTypeId.'",mealPlan="'.$mealPlanId.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",singleoccupancy="'.$singleCost.'",doubleoccupancy="'.$doubleCost.'",extraBedA="'.$extraBedACost.'",extraBedC="'.$extraBedCCost.'",breakfast="'.$breakfastCost.'",lunch="'.$lunchCost.'",dinner="'.$dinnerCost.'",currencyId="'.$currencyId.'",status=1,supplierId="'.$supplierId.'",serviceId="'.$serviceId.'",tarifType=1,seasonType="'.$seasonType.'",roomGST="'.$roomGST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",remarks="'.$remarks.'"';
		$lastid = addlistinggetlastid('docketHotelRateMaster',$namevalue);
	}
	?>
	<script type="text/javascript">
	parent.$('#pageloader').hide();
	parent.$('#pageloading').hide();
	parent.docket_alertboxClose();
	parent.loadSearchServicesRates();
	</script>
	<?php
}

if(trim($_REQUEST['action'])=='loadDocketTransportBreakupCost' && $_REQUEST['BKP_serviceId']!='' && $_REQUEST['BKP_queryId']!=''){
	$editId=clean($_REQUEST['BKP_editId']);
	$rateId=clean($_REQUEST['BKP_rateId']);
	$serviceId=clean($_REQUEST['BKP_serviceId']);
	$fromDate=clean($_REQUEST['BKP_fromDate']);
	$toDate=clean($_REQUEST['BKP_toDate']);
	$queryId=clean($_REQUEST['BKP_queryId']);
	$supplierId=clean($_REQUEST['BKP_supplierId']);
	$currencyId=clean($_REQUEST['BKP_currencyId']);
	$markupType=clean($_REQUEST['BKP_MarkupType']);
	$markupCost=clean($_REQUEST['BKP_Markup']);
	$gstTax=clean($_REQUEST['BKP_gstTax']);
	$remarks=clean($_REQUEST['BKP_remarks']);
	$transferCategory=clean($_REQUEST['BKP_transferCategory']);
	$vehicleModelId = clean($_REQUEST['BKP_vehicleModelId']);	
	$vehicleCost = clean($_REQUEST['BKP_vehicleCost']);	
	$parkingFee = clean($_REQUEST['BKP_parkingFee']);	
	$capacity = clean($_REQUEST['BKP_capacity']);	
	$representativeEntryFee = clean($_REQUEST['BKP_representativeEntryFee']);	
	$assistance = clean($_REQUEST['BKP_assistance']);	
	$guideAllowance = clean($_REQUEST['BKP_guideAllowance']);	
	$interStateAndToll = clean($_REQUEST['BKP_interStateAndToll']);	
	$miscellaneous = clean($_REQUEST['BKP_miscellaneous']);	
	if($editId>0 && $queryId!=''){
		//provisino to edit for this quotation
		$namevalue ='serviceId="'.$serviceId.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",queryId="'.$queryId.'",supplierId="'.$supplierId.'",currencyId="'.$currencyId.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",gstTax="'.$gstTax.'",remarks="'.$remarks.'",transferCategory="'.$transferCategory.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",parkingFee="'.$parkingFee.'",capacity="'.$capacity.'",representativeEntryFee="'.$representativeEntryFee.'",assistance="'.$assistance.'",guideAllowance="'.$guideAllowance.'",interStateAndToll="'.$interStateAndToll.'",miscellaneous="'.$miscellaneous.'"';
		$where='id="'.$editId.'" and queryId="'.$queryId.'"';
		updatelisting('docketTransportRateMaster',$namevalue,$where);
	}else{
	 	//provisino to add new for this quotation
	 	$namevalue ='rateId="'.$rateId.'",serviceId="'.$serviceId.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",queryId="'.$queryId.'",supplierId="'.$supplierId.'",currencyId="'.$currencyId.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",gstTax="'.$gstTax.'",transferCategory="'.$transferCategory.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",parkingFee="'.$parkingFee.'",capacity="'.$capacity.'",representativeEntryFee="'.$representativeEntryFee.'",assistance="'.$assistance.'",guideAllowance="'.$guideAllowance.'",interStateAndToll="'.$interStateAndToll.'",miscellaneous="'.$miscellaneous.'",remarks="'.$remarks.'"';
		$lastid = addlistinggetlastid('docketTransportRateMaster',$namevalue);
	}
	?>
	<script type="text/javascript">
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.docket_alertboxClose();
		parent.loadSearchServicesRates();
	</script>
	<?php
}


if(trim($_REQUEST['action'])=='AddNewServiceRate' && $_REQUEST['ADD_sType']!=''){

	$sType=clean($_REQUEST['ADD_sType']);
	if($sType == 'hotel'){

		$hotelName = clean($_REQUEST['ADD_hotelName']);
		$hotelCategoryId = clean($_REQUEST['ADD_hotelCategoryId']);
		$hotelTypeId = clean($_REQUEST['ADD_hotelTypeId']);
		$supplier = clean($_REQUEST['ADD_supplier']);
		$detail = clean($_REQUEST['ADD_detail']);
		$cityId = clean($_REQUEST['ADD_cityId']);

		$division = clean($_REQUEST['ADD_division']);
		$contactPerson = clean($_REQUEST['ADD_contactPerson']);
		$designation = clean($_REQUEST['ADD_designation']);
		$countryCode = clean($_REQUEST['ADD_countryCode']);
		$phone = clean($_REQUEST['ADD_phone']);
		$email = clean($_REQUEST['ADD_email']);
		
		$countryId = clean($_REQUEST['ADD_countryId']);
		$stateId = clean($_REQUEST['ADD_stateId']);
		$cityMasterId = clean($_REQUEST['ADD_cityMasterId']);
		$pinCode = clean($_REQUEST['ADD_pincode']);
		$gstn = clean($_REQUEST['ADD_gstn']);
		$address = clean($_REQUEST['ADD_address']);
		
		$fromDate=date('Y-m-d',strtotime($_REQUEST['ADD_fromDate']));
		$toDate=date('Y-m-d',strtotime($_REQUEST['ADD_toDate']));
		$seasonType=clean($_REQUEST['ADD_seasonType']);
		$marketType=clean($_REQUEST['ADD_marketType']);
		$supplierId=clean($_REQUEST['ADD_supplierId']);
		$currencyId=clean($_REQUEST['ADD_currencyId']);
		$markupType=clean($_REQUEST['ADD_MarkupType']);
		$markupCost=clean($_REQUEST['ADD_Markup']);
		$roomGST=clean($_REQUEST['ADD_RoomGST']);
		$mealGST=clean($_REQUEST['ADD_mealGST']);
		$roomTypeId=clean($_REQUEST['ADD_RoomTypeId']);
		$mealPlanId=clean($_REQUEST['ADD_MealPlanId']);
		$singleCost=clean($_REQUEST['ADD_singleCost']);
		$doubleCost=clean($_REQUEST['ADD_doubleCost']);
		$extraBedACost=clean($_REQUEST['ADD_ExtraBedACost']);
		$extraBedCCost=clean($_REQUEST['ADD_ExtraBedCCost']);
		$breakfastCost=clean($_REQUEST['ADD_breakfastCost']);
		$lunchCost=clean($_REQUEST['ADD_lunchCost']);
		$dinnerCost=clean($_REQUEST['ADD_dinnerCost']);
		$roomTAC=clean($_REQUEST['ADD_TAC']);
		$remarks=clean($_REQUEST['ADD_remarks']);

		$dateAdded=time();
		//check dublicate entry for add hotel
		$hotelEmailCheck = checkduplicate('hotelContactPersonMaster','email="'.$email.'" and division=3');
		$supplierEmailCheck = checkduplicate('suppliercontactPersonMaster','email="'.$email.'" and division=3');
		$hotelCheck = checkduplicate(_PACKAGE_BUILDER_HOTEL_MASTER_,' hotelName="'.$hotelName.'" and hotelCity="'.getDestination($cityId).'"');
		if($hotelEmailCheck=='yes' || $supplierEmailCheck=='yes'  || $hotelCheck=='yes' ){ 
			$errMsg = '';
			if ($hotelEmailCheck=='yes') {
				$errMsg .= ' Hotel Email,';
			}
			if ($supplierEmailCheck=='yes') {
				$errMsg .= ' Supplier Email,';
			}
			if($hotelCheck == 'yes'){
				$errMsg2 = ' Hotel is already exist!!';
			}else{
				$errMsg2 = rtrim($errMsg,',').' already registered as an operations, Pls use another one or use with another division.';
			}
			?>
			<script>
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			parent.alert('<?php echo $errMsg2;?> ');
			</script>
		 	<?php 
		}else{
			$namevalue ='hotelName="'.$hotelName.'",hotelCity="'.getDestination($cityId).'",policy="'.$hotelpolicy.'",termAndCondition="'.$hoteltermandcondition.'",hotelChain="'.$hotelChain.'",hotelAddress="'.$address.'",hoteldetail="'.$hoteldetail.'",hotelCategoryId="'.$hotelCategoryId.'",hotelTypeId="'.$hotelTypeId.'",hotelImage="'.$hotelIMagName.'",gstn="'.$gstn.'",url="'.$url.'",roomType="'.$roomType.'",supplier="'.$supplier.'",contactPerson="'.$contactPerson.'",supplierPhone="'.$phone.'",supplierEmail="'.$email.'",status=1,amenities="'.$hotel_amenities.'",weekendDays="'.$weekendid.'",hotelCategoryName="'.$reCateHot['name'].'",checkInTime="'.$checkInTime.'",checkOutTime="'.$checkOutTime.'"';  
			$serviceId = addlistinggetlastid(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue); 
			 
			$chkscp = checkduplicate('hotelContactPersonMaster','email="'.$email.'"');
			if($chkscp=='no'){   
				$scpmn ='contactPerson="'.$contactPerson.'",corporateId="'.$serviceId.'",designation="'.$designation.'",countryCode="'.$countryCode.'",phone="'.$phone.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
				addlisting('hotelContactPersonMaster',$scpmn); 
				
			    $namevalue ='addressParent="'.$serviceId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityMasterId.'",address="'.$address.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1,addressType="hotel"';
			    addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
			   
			}
			if($supplier=='1'){ 

				$checkduplicate = checkduplicate(_SUPPLIERS_MASTER_,'name="'.$hotelName.'"'); 
				if($checkduplicate=='no'){ 
					$namevalue ='name="'.$hotelName.'",aliasname="'.$hotelName.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.time().',companyTypeId=1,supplierMainType=1,deletestatus=0,status=1,paymentTerm=1,agreement=0,destinationId="'.$cityId.'"'; 
					$supplierId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);  

					$spNum = 'S'.str_pad($supplierId, 6, '0', STR_PAD_LEFT); 
					$update = updatelisting(_SUPPLIERS_MASTER_,'supplierNumber="'.$spNum.'"','id="'.$supplr_id.'"');
					
					$namevalue3 ='contactPerson="'.$contactPerson.'",corporateId="'.$supplierId.'",designation="'.$designation.'",countryCode="'.$countryCode.'",phone="'.$phone.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
					addlisting('suppliercontactPersonMaster',$namevalue3); 
					
					$rs1="";
					$rs1=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$supplierId.'" and addressType="supplier"');
					if(mysqli_num_rows($rs1) > 0){
						$addrData=mysqli_fetch_array($rs1); 
						$namevalue4 ='addressParent="'.$supplierId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityMasterId.'",address="'.$address.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1';
						updatelisting(_ADDRESS_MASTER_,$namevalue4,"id='".$addrData['id']."'");
					}else{
						$namevalue5 ='addressParent="'.$supplierId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityMasterId.'",address="'.$address.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1,addressType="supplier"';
						addlistinggetlastid(_ADDRESS_MASTER_,$namevalue5);
					
					} 	
					
				}else{
					$rsup=GetPageRecord('id',_SUPPLIERS_MASTER_,'name="'.$hotelName.'"'); 
					$getSup=mysqli_fetch_array($rsup);
					$supplierId = $getSup['id'];
					
					$namevalue6 = 'contactPerson="'.$contactPerson.'",corporateId="'.$supplierId.'",designation="'.$designation.'",countryCode="'.$countryCode.'",phone="'.$phone.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
					addlisting('suppliercontactPersonMaster',$namevalue6); 
					
					$rs1="";
					$rs1=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$supplierId.'" and addressType="supplier"');
					if(mysqli_num_rows($rs1) > 0){
						$addrData=mysqli_fetch_array($rs1); 
						$namevalue7 ='addressParent="'.$supplierId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityMasterId.'",address="'.$address.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1';
						updatelisting(_ADDRESS_MASTER_,$namevalue7,"id='".$addrData['id']."'");
					}else{
						$namevalue8 ='addressParent="'.$supplierId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityMasterId.'",address="'.$address.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1,addressType="supplier"';
						addlistinggetlastid(_ADDRESS_MASTER_,$namevalue8);
					} 	
				} 
			}
		
			//add new rate to masters
			$namevalue9 ='marketType="'.$marketType.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",roomType="'.$roomTypeId.'",mealPlan="'.$mealPlanId.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",singleoccupancy="'.$singleCost.'",doubleoccupancy="'.$doubleCost.'",extraBed="'.$extraBedACost.'",childwithbed="'.$extraBedCCost.'",breakfast="'.$breakfastCost.'",lunch="'.$lunchCost.'",dinner="'.$dinnerCost.'",currencyId="'.$currencyId.'",status=1,supplierId="'.$supplierId.'",serviceId="'.$serviceId.'",tarifType=1,seasonType="'.$seasonType.'",roomGST="'.$roomGST.'",mealGST="'.$mealGST.'",roomTAC="'.$roomTAC.'",remarks="'.$remarks.'"';
			$lastid = addlistinggetlastid(_DMC_ROOM_TARIFF_MASTER_,$namevalue9);
			?>
			<script type="text/javascript">
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			parent.docket_alertboxClose();
			parent.loadServices(<?php echo $cityId; ?>,'hotel');
			parent.loadSearchServicesRates();
			</script>
			<?php
		}
	}
	if($sType == 'transportation'){

		$transferName = clean($_REQUEST['ADD_transferName']);
		$detail = clean($_REQUEST['ADD_detail']);
		$cityId = clean($_REQUEST['ADD_cityId']);
		
		$fromDate=date('Y-m-d',strtotime($_REQUEST['ADD_fromDate']));
		$toDate=date('Y-m-d',strtotime($_REQUEST['ADD_toDate']));

		$supplierId=clean($_REQUEST['ADD_supplierId']);
		$currencyId=clean($_REQUEST['ADD_currencyId']);
		$markupType=clean($_REQUEST['ADD_MarkupType']);
		$markupCost=clean($_REQUEST['ADD_Markup']);
		$gstTax=clean($_REQUEST['ADD_gstTax']);
		$remarks=clean($_REQUEST['ADD_remarks']);
		$transferCategory=clean($_REQUEST['ADD_transferCategory']);
		$vehicleModelId = clean($_REQUEST['ADD_vehicleModelId']);	
		$vehicleCost = clean($_REQUEST['ADD_vehicleCost']);	
		$parkingFee = clean($_REQUEST['ADD_parkingFee']);	
		$capacity = clean($_REQUEST['ADD_capacity']);	
		$representativeEntryFee = clean($_REQUEST['ADD_representativeEntryFee']);	
		$assistance = clean($_REQUEST['ADD_assistance']);	
		$guideAllowance = clean($_REQUEST['ADD_guideAllowance']);	
		$interStateAndToll = clean($_REQUEST['ADD_interStateAndToll']);	
		$miscellaneous = clean($_REQUEST['ADD_miscellaneous']);	

		$dateAdded=time();
		//check dublicate entry for add hotel
		$transfCheck = checkduplicate(_PACKAGE_BUILDER_TRANSFER_MASTER,' transferName="'.$transferName.'"');
		if($transfCheck=='yes' ){ 
			?>
			<script>
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			parent.alert('Transportation is already exist!!');
			</script>
		 	<?php 
		}else{
			$namevalue ='transferName="'.$transferName.'",transferCategory="'.$transferCategory.'",transferDetail="'.$detail.'",transferType="'.$transferType.'",destinationId="'.$cityId.'"';  
			$serviceId = addlistinggetlastid(_PACKAGE_BUILDER_TRANSFER_MASTER,$namevalue); 
		
			//add new rate to masters
			$namevalue ='serviceId="'.$serviceId.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",supplierId="'.$supplierId.'",currencyId="'.$currencyId.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",gstTax="'.$gstTax.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",parkingFee="'.$parkingFee.'",capacity="'.$capacity.'",representativeEntryFee="'.$representativeEntryFee.'",assistance="'.$assistance.'",guideAllowance="'.$guideAllowance.'",interStateAndToll="'.$interStateAndToll.'",miscellaneous="'.$miscellaneous.'",remarks="'.$remarks.'"';
			$lastid = addlistinggetlastid(_DMC_TRANSFER_RATE_MASTER_,$namevalue);
			?>
			<script type="text/javascript">
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			parent.docket_alertboxClose();
			parent.loadServices(<?php echo $cityId; ?>,'transportation');
			parent.loadSearchServicesRates();
			</script>
			<?php
		}
	}

}