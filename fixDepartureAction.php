<?php
ob_start();
include "inc.php";

if($_REQUEST['action'] == 'saveHotelRequest'){
	$queryId = $_REQUEST['queryId'];
	$hotelId = $_REQUEST['hotelId'];
	$HotelSupplierStatus = $_REQUEST['status'];


	$rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'queryId="'.$queryId.'" and supplierId="'.$hotelId.'" order by id asc');
	while($hotelData=mysqli_fetch_array($rs)){
		$namevalue = 'HotelSupplierStatus="'.$HotelSupplierStatus.'"';
		$where='id='.$hotelData['id'].'';
		$update = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,$where);	
	}
}

if($_REQUEST['action'] == 'updateFixDeparture'){
	$subName = $_REQUEST['subName'];
	$issueDate = $_REQUEST['issueDate'];
	$fromDate = $_REQUEST['validFrom'];
	$toDate = $_REQUEST['validTo'];
	$quotationId = decode($_REQUEST['quotationId']);
	$queryId = decode($_REQUEST['queryId']);

	$namevalue = 'subName="'.$subName.'",issueDate="'.$issueDate.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'"';
	$where='id='.$quotationId.'';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);


	 $count = 0;
	
	$rs=GetPageRecord('*','newQuotationDays','queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus=0 order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($rs)){

		$srDaysDate  = date('Y-m-d', strtotime("+".$count." day", strtotime($fromDate)));
		
		$namevalue1 ='srdate="'.$srDaysDate.'"';
		$where1='id='.$QueryDaysData['id'].'';
		updatelisting('newQuotationDays',$namevalue1,$where1);

		

		$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) order by id asc');
		while($HotelRes=mysqli_fetch_array($b)) {
		
			$namevalue2 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where2 = 'id='.$HotelRes['id'].'';
			updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue2,$where2);
			updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$HotelRes['id'].'"');
		}

		$b='';
		$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
	
			$namevalue3 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where3 = 'id='.$transferRes['id'].'';
			updatelisting(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue3,$where3);

			updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');
			
		}

		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
			
				$namevalue4 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
				$where4 = 'id='.$transferRes['id'].'';
				updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue4,$where4);

				updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');
	
			}
		}

		$b=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="guide" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){

			$namevalue5 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where5 = 'id='.$transferRes['id'].'';
			updatelisting('quotationGuideMaster',$namevalue5,$where5);

			updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');

		}

		$b=GetPageRecord('*','quotationEnrouteMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="enroute" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			
			$namevalue6 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where6 = 'id='.$transferRes['id'].'';
			updatelisting('quotationEnrouteMaster',$namevalue6,$where6);

			updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');


		}

		$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){

			$namevalue7 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where7 = 'id='.$transferRes['id'].'';
			updatelisting('quotationEntranceMaster',$namevalue7,$where7);

			updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');


		}

		$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			
			$namevalue8 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where8 = 'id='.$transferRes['id'].'';
			 updatelisting(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue8,$where8);

			 updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');


		}

		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			
			$namevalue9 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where9 = 'id='.$transferRes['id'].'';
			 updatelisting(_QUOTATION_FLIGHT_MASTER_,$namevalue9,$where9);

			 updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');


		}

		$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			
			$namevalue10 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where10 = 'id='.$transferRes['id'].'';
			 updatelisting(_QUOTATION_TRAINS_MASTER_,$namevalue10,$where10);

			 updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');

		}

		$b='';
		$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
				
				$namevalue11 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
				$where11 = 'id='.$transferRes['id'].'';
				updatelisting(_QUOTATION_EXTRA_MASTER_,$namevalue11,$where11);

				updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$transferRes['id'].'"');

			}
		}

		$count++;

	}


?>
<script>
window.location="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['queryId']; ?>";
</script>
<?php 
}

if($_REQUEST['action'] == 'addFixDeparture'){ 

	$subName = $_REQUEST['subName'];
	$isFD = 1;
	$issueDate = $_REQUEST['issueDate'];
	$fromDate = $_REQUEST['validFrom'];
	$toDate = $_REQUEST['validTo'];
	
	$queryData=GetPageRecord('FDCode',_QUERY_MASTER_,'id='.decode($_REQUEST['queryId']).'');
	$queryDataq=mysqli_fetch_array($queryData);
	
	$countQuot='';
	$rs2=GetPageRecord('*',_QUOTATION_MASTER_,'id='.decode($_REQUEST['quotationId']).'');
	$countQuot=mysqli_num_rows($rs2);
	if($countQuot>0){
		$quotationData=mysqli_fetch_array($rs2);
	  	
		$queryId = $quotationData['queryId'];
		$quotationId = $quotationData['id'];
	
	
		$rsp1=GetPageRecord('quotationNo',_QUOTATION_MASTER_,' queryId="'.$queryId.'" order by quotationNo desc');
		$quotationNoD=mysqli_fetch_array($rsp1);
		//this is greater than first
		$letterAscii = ord($quotationNoD['quotationNo']);
		$letterAscii++;
		$quotationNo = chr($letterAscii);
	
		
	$namevalue='clientType="'.$quotationData['clientType'].'",queryId="'.$queryId.'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$quotationData['adult'].'",child="'.$quotationData['child'].'",night="'.$quotationData['night'].'",rooms="'.$quotationData['rooms'].'",infant="'.$quotationData['infant'].'",sglRoom="'.$quotationData['sglRoom'].'",dblRoom="'.$quotationData['dblRoom'].'",twinRoom="'.$quotationData['twinRoom'].'",tplRoom="'.$quotationData['tplRoom'].'",childwithNoofBed="'.$quotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$quotationData['childwithoutNoofBed'].'",extraNoofBed="'.$quotationData['extraNoofBed'].'",totalpax="'.$quotationData['totalpax'].'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",deletestatus="'.$quotationData['deletestatus'].'",quotationId="'.$quotationData['quotationId'].'",starRating="'.$quotationData['starRating'].'",totalAmount="'.$quotationData['totalAmount'].'",totalquotCostWithMarkup="'.$quotationData['totalquotCostWithMarkup'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'",inclusion="'.addslashes($quotationData['inclusion']).'",exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.$quotationData['isInc_exc'].'",quotationNo="'.$quotationNo.'",generateNo="'.$quotationData['generateNo'].'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'",languageId="'.$quotationData['languageId'].'",deletestatusDuplicate=1,subName="'.$subName.'",isFD="'.$isFD.'",issueDate="'.$issueDate.'"';
	
		$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);
	
	// duplicate pax slab lists
		$b='';
		$b=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationData['id'].'" order by fromRange asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';  
				$modevalue = 'quotationId="'.$lastQuotationId.'", fromRange="'.$transferRes['fromRange'].'", toRange="'.$transferRes['toRange'].'", localEscort="'.$transferRes['localEscort'].'", foreignEscort="'.$transferRes['foreignEscort'].'", dividingFactor="'.$transferRes['dividingFactor'].'", status="'.$transferRes['status'].'", deletestatus="'.$transferRes['deletestatus'].'", dateAdded="'.$transferRes['dateAdded'].'", modifyDate="'.$transferRes['modifyDate'].'", modifyBy="'.$transferRes['modifyBy'].'",dividingFactorC="'.$transferRes['dividingFactorC'].'", DF_SGL="'.$transferRes['DF_SGL'].'", DF_DBL="'.$transferRes['DF_DBL'].'", DF_TWN="'.$transferRes['DF_TWN'].'", DF_TPL="'.$transferRes['DF_TPL'].'", DF_QUAD="'.$transferRes['DF_QUAD'].'", DF_SIX="'.$transferRes['DF_SIX'].'", DF_EIGHT="'.$transferRes['DF_EIGHT'].'", DF_TEN="'.$transferRes['DF_TEN'].'", DF_ABED="'.$transferRes['DF_ABED'].'", DF_CBED="'.$transferRes['DF_CBED'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",sglRoom="'.$transferRes['sglRoom'].'",dblRoom="'.$transferRes['dblRoom'].'",twinRoom="'.$transferRes['twinRoom'].'",tplRoom="'.$transferRes['tplRoom'].'",quadNoofRoom="'.$transferRes['quadNoofRoom'].'",sixNoofBedRoom="'.$transferRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$transferRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$transferRes['tenNoofBedRoom'].'",teenNoofRoom="'.$transferRes['teenNoofRoom'].'",extraNoofBed="'.$transferRes['extraNoofBed'].'",childwithNoofBed="'.$transferRes['childwithNoofBed'].'",childwithoutNoofBed="'.$transferRes['childwithoutNoofBed'].'"';
				$slabId = addlistinggetlastid('totalPaxSlab',$modevalue);
				
				$esQ="";
				$esQ=GetPageRecord('*','quotationFOCRates',' slabId="'.$transferRes['id'].'" and quotationId="'.$transferRes['quotationId'].'"');
				if(mysqli_num_rows($esQ) > 0){
					while($escortData=mysqli_fetch_array($esQ)){
						$focRatesQuery = '';  
						$focRatesQuery ='quotationId="'.$lastQuotationId.'",slabId="'.$slabId.'",sglNORoom="'.$escortData['sglNORoom'].'",dblNORoom="'.$escortData['dblNORoom'].'",tplNORoom="'.$escortData['tplNORoom'].'",focType="'.$escortData['focType'].'",hotelCost="'.$escortData['hotelCost'].'",guideCost="'.$escortData['guideCost'].'",activityCost="'.$escortData['activityCost'].'",entranceCost="'.$escortData['entranceCost'].'",transferCost="'.$escortData['transferCost'].'",trainCost="'.$escortData['trainCost'].'",flightCost="'.$escortData['flightCost'].'",restaurantCost="'.$escortData['restaurantCost'].'",otherCost="'.$escortData['otherCost'].'",hotelCalType="'.$escortData['hotelCalType'].'",guideCalType="'.$escortData['guideCalType'].'",activityCalType="'.$escortData['activityCalType'].'",entranceCalType="'.$escortData['entranceCalType'].'",transferCalType="'.$escortData['transferCalType'].'",trainCalType="'.$escortData['trainCalType'].'",flightCalType="'.$escortData['flightCalType'].'",restaurantCalType="'.$escortData['restaurantCalType'].'",otherCalType="'.$escortData['otherCalType'].'"';
						$focRateId = addlistinggetlastid('quotationFOCRates',$focRatesQuery);
					} 
				}
			}
		}
	
	
		$count = 0; 
		$rs=GetPageRecord('*','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus=0 order by srdate asc');
		while($QueryDaysData=mysqli_fetch_array($rs)){

			$adddays='';
			$srDaysDate  = date('Y-m-d', strtotime("+".$count." day", strtotime($fromDate)));
			$namevalue =' queryId="'.$QueryDaysData['queryId'].'",packageId="'.$QueryDaysData['packageId'].'",cityId="'.$QueryDaysData['cityId'].'",title="'.$QueryDaysData['title'].'",description="'.$QueryDaysData['description'].'",quotationId="'.$lastQuotationId.'",srdate="'.$srDaysDate.'"';
			$adddays = addlistinggetlastid('newQuotationDays',$namevalue);

			$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
			while($HotelRes=mysqli_fetch_array($b)) {
				// sinMarkup="'.$HotelRes['sinMarkup'].'",douMarkup="'.$HotelRes['douMarkup'].'",triMarkup="'.$HotelRes['triMarkup'].'",cwMarkup="'.$HotelRes['cwMarkup'].'",quadMarkup="'.$HotelRes['quadMarkup'].'",cwtMarkup="'.$HotelRes['cwtMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",pacMarkup="'.$HotelRes['pacMarkup'].'",singleNoofRoomLE="'.$HotelRes['singleNoofRoomLE'].'",doubleNoofRoomLE="'.$HotelRes['doubleNoofRoomLE'].'",singleNoofRoomFE="'.$HotelRes['singleNoofRoomFE'].'",doubleNoofRoomFE="'.$HotelRes['doubleNoofRoomFE'].'",
				$namevalue ='';
				$addHotel ='';
				$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$lastQueryId.'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",currencyValue="'.$HotelRes['currencyValue'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomprice="'.$HotelRes['roomprice'].'",noofrooms="'.$HotelRes['noofrooms'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",singleNoofRoom="'.$HotelRes['singleNoofRoom'].'",doubleNoofRoom="'.$HotelRes['doubleNoofRoom'].'",tripleNoofRoom="'.$HotelRes['tripleNoofRoom'].'",twinNoofRoom="'.$HotelRes['twinNoofRoom'].'",childwithNoofBed="'.$HotelRes['childwithNoofBed'].'",childwithoutNoofBed="'.$HotelRes['childwithoutNoofBed'].'",extraNoofBed="'.$HotelRes['extraNoofBed'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",harrivalon="'.$HotelRes['harrivalon'].'",hfrom="'.$HotelRes['hfrom'].'",hbyfrom="'.$HotelRes['hbyfrom'].'",hatfrom="'.$HotelRes['hatfrom'].'",hdepartureon="'.$HotelRes['hdepartureon'].'",hto="'.$HotelRes['hto'].'",hbyto="'.$HotelRes['hbyto'].'",hatto="'.$HotelRes['hatto'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",rand_color="'.$HotelRes['rand_color'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",breakfast="'.$HotelRes['breakfast'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",escortHotelStatus="'.$HotelRes['escortHotelStatus'].'",escortType="'.$HotelRes['escortType'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isSelectedFinal="'.$HotelRes['isSelectedFinal'].'",isSelectedType="'.$HotelRes['isSelectedType'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);
				 
				$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$HotelRes['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
				if(mysqli_num_rows($check_h)==0){
					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
				}

				// supplement
				$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
				while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
					
					$namevalue ='';
					$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$lastQueryId.'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",currencyValue="'.$hotelSuppD['currencyValue'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",sinMarkup="'.$hotelSuppD['sinMarkup'].'",douMarkup="'.$hotelSuppD['douMarkup'].'",triMarkup="'.$hotelSuppD['triMarkup'].'",cwMarkup="'.$hotelSuppD['cwMarkup'].'",quadMarkup="'.$hotelSuppD['quadMarkup'].'",cwtMarkup="'.$hotelSuppD['cwtMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",pacMarkup="'.$hotelSuppD['pacMarkup'].'",singleNoofRoomLE="'.$hotelSuppD['singleNoofRoomLE'].'",doubleNoofRoomLE="'.$hotelSuppD['doubleNoofRoomLE'].'",singleNoofRoomFE="'.$hotelSuppD['singleNoofRoomFE'].'",doubleNoofRoomFE="'.$hotelSuppD['doubleNoofRoomFE'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",harrivalon="'.$hotelSuppD['harrivalon'].'",hfrom="'.$hotelSuppD['hfrom'].'",hbyfrom="'.$hotelSuppD['hbyfrom'].'",hatfrom="'.$hotelSuppD['hatfrom'].'",hdepartureon="'.$hotelSuppD['hdepartureon'].'",hto="'.$hotelSuppD['hto'].'",hbyto="'.$hotelSuppD['hbyto'].'",hatto="'.$hotelSuppD['hatto'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",escortHotelStatus="'.$hotelSuppD['escortHotelStatus'].'",escortType="'.$hotelSuppD['escortType'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isSelectedFinal="'.$hotelSuppD['isSelectedFinal'].'",isSelectedType="'.$hotelSuppD['isSelectedType'].'"';
					$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

					$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
					if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
						$namevalue ='';
						$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
						addlistinggetlastid('quotationItinerary',$namevalue);
					}

				} 


			}

			$b=""; 
			$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where ( serviceType="transfer" or serviceType="transportation" ) order by serviceId asc) and isGuestType=1 order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$slabId = $paxSlabData2['id']; 

				$serviceType = $transferRes['serviceType'];


				$transQuoId =''; 
				$normalvalue ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$adddays.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",totalPax="'.$slabId.'"';
				
				$transQuoId = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$normalvalue);
				
				$bSupp=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'"  and transferQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
				while($transferSuppRes=mysqli_fetch_array($bSupp)){
					$suppvalue ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferSuppRes['destinationId'].'",transferNameId="'.$transferSuppRes['transferNameId'].'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",vehicleId="'.$transferSuppRes['vehicleId'].'",vehicleModelId="'.$transferSuppRes['vehicleModelId'].'",currencyId="'.$transferSuppRes['currencyId'].'",currencyValue="'.$transferSuppRes['currencyValue'].'",transferToId="'.$transferSuppRes['transferToId'].'",transferFromId="'.$transferSuppRes['transferFromId'].'",transferType="'.$transferSuppRes['transferType'].'",adultCost="'.$transferSuppRes['adultCost'].'",childCost="'.$transferSuppRes['childCost'].'",infantCost="'.$transferSuppRes['infantCost'].'",roomPrice="'.$transferSuppRes['roomPrice'].'",detail="'.$transferSuppRes['detail'].'",vehicleCost="'.$transferSuppRes['vehicleCost'].'",transferQuotatoinType="'.$transferSuppRes['transferQuotatoinType'].'",dmcId="'.$transferSuppRes['dmcId'].'",pickupFrom="'.$transferSuppRes['pickupFrom'].'",pickupTime="'.$transferSuppRes['pickupTime'].'",duration="'.$transferSuppRes['duration'].'",vehicleMaxPax="'.$transferSuppRes['vehicleMaxPax'].'",adMarkup="'.$transferSuppRes['adMarkup'].'",chMarkup="'.$transferSuppRes['chMarkup'].'",vehMarkup="'.$transferSuppRes['vehMarkup'].'",remark="'.$transferSuppRes['remark'].'",confirmation="'.$transferSuppRes['confirmation'].'",tourManager="'.$transferSuppRes['tourManager'].'",driverId="'.$transferSuppRes['driverId'].'",vehicleType="'.$transferSuppRes['vehicleType'].'",parkingFee="'.$transferSuppRes['parkingFee'].'",representativeEntryFee="'.$transferSuppRes['representativeEntryFee'].'",assistance="'.$transferSuppRes['assistance'].'",guideAllowance="'.$transferSuppRes['guideAllowance'].'",interStateAndToll="'.$transferSuppRes['interStateAndToll'].'",miscellaneous="'.$transferSuppRes['miscellaneous'].'",gstTax="'.$transferSuppRes['gstTax'].'",transferName="'.$transferSuppRes['transferName'].'",noOfDays="'.$transferSuppRes['noOfDays'].'",dayId="'.$adddays.'",serviceType="'.$transferSuppRes['serviceType'].'",costType="'.$transferSuppRes['costType'].'",distance="'.$transferSuppRes['distance'].'",noOfVehicles="'.$transferSuppRes['noOfVehicles'].'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",transferQuoteId="'.$transQuoId.'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",isLocalEscort="'.$transferSuppRes['isLocalEscort'].'",isForeignEscort="'.$transferSuppRes['isForeignEscort'].'",totalPax="'.$slabId.'"';

					$addSuppHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$suppvalue);
				}

				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1);
					$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$transQuoId.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
		     	 	$hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					
				}

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$transferRes['queryId'].'",serviceId="'.$transQuoId.'",quotationId="'.$lastQuotationId.'",serviceType="'.$serviceType.'",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}

			$b=""; 
			$b=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="guide" order by serviceId asc) and isGuestType=1 order by id asc');
			while($quotGuideData=mysqli_fetch_array($b)){
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$slabId = $paxSlabData2['id']; 

				$guideQuoteId =''; 
				$transfernamevalue ='guideId="'.$quotGuideData['guideId'].'",slabId="'.$slabId.'",price="'.$quotGuideData['price'].'",guideName="'.$quotGuideData['guideName'].'",queryId="'.$quotGuideData['queryId'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",supplierId="'.$quotGuideData['supplierId'].'",tariffId="'.$quotGuideData['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$quotGuideData['srn'].'",destinationId="'.$quotGuideData['destinationId'].'",rules="'.$quotGuideData['rules'].'",category="'.$quotGuideData['category'].'",subcategory="'.$quotGuideData['subcategory'].'",totalDays="'.$quotGuideData['totalDays'].'",perDaycost="'.$quotGuideData['perDaycost'].'",serviceType="'.$quotGuideData['serviceType'].'",currencyId="'.$quotGuideData['currencyId'].'",currencyValue="'.$quotGuideData['currencyValue'].'",guideQuoteId="'.$guideQuoteId.'",isGuestType="'.$quotGuideData['isGuestType'].'",isSupplement="'.$quotGuideData['isSupplement'].'",isSelectedFinal="'.$quotGuideData['isSelectedFinal'].'",paxRange="'.$quotGuideData['paxRange'].'",dayType="'.$quotGuideData['dayType'].'",dayId="'.$adddays.'"';
				
				$guideQuoteId = addlistinggetlastid('quotationGuideMaster',$transfernamevalue);
				
				$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'"  and guideQuoteId="'.$quotGuideData['id'].'" and isSupplement=1 order by id asc');
				while($transferSuppRes=mysqli_fetch_array($bSupp)){
					$suppGuidevalue ='guideId="'.$transferSuppRes['guideId'].'",slabId="'.$slabId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$transferSuppRes['queryId'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",currencyValue="'.$transferSuppRes['currencyValue'].'",guideQuoteId="'.$guideQuoteId.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$adddays.'"';

					$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
				}

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$quotGuideData['queryId'].'",serviceId="'.$guideQuoteId.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}


			$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){

				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData4=mysqli_fetch_array($bb2);
				$slabId = $paxSlabData4['id'];

				
				$addHotel = '';
				$transfernamevalue ='otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",childCost="'.$transferRes['childCost'].'",groupCost="'.$transferRes['groupCost'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",activityCost="'.$transferRes['activityCost'].'",maxpax="'.$transferRes['maxpax'].'",perPaxCost="'.$transferRes['perPaxCost'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",slabId="'.$slabId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$transfernamevalue);
				
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="activity",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationActivityTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1); 
					 $namevalue ='quotationId="'.$add.'",dayId="'.$adddays.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
					 $entraceTimeId = addlistinggetlastid('quotationActivityTimelineDetails',$namevalue);

				}
			}


			$b=GetPageRecord('*','quotationEnrouteMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="enroute" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel ='';

				$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",dayId="'.$adddays.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}



			$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid('quotationEntranceMaster',$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="entrance",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$adddays.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
					 $entraceTimeId = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);

				}
			}
	 
			$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",quotationId="'.$lastQuotationId.'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",groupCost="'.$transferRes['groupCost'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srDaysDate.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",toDate="'.$srDaysDate.'",queryId="'.$queryId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}




			$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$srDaysDate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srDaysDate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
	 
			$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$srDaysDate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srDaysDate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",trainId="'.$transferRes['trainId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="train",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}


			$b='';
			$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
			if(mysqli_num_rows($b)>0){

				while($transferRes=mysqli_fetch_array($b)){
					$addHotel = '';
					$transfernamevalue ='name="'.$transferRes['name'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$queryId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",additionalId="'.$transferRes['additionalId'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$adddays.'"';

					$addHotel = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$transfernamevalue);


					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="additional",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);

				}
			}

			$b='';
			$b=GetPageRecord('*','quotationModeMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" order by id asc');
			if(mysqli_num_rows($b)>0){
				$transferRes=mysqli_fetch_array($b);
				$addHotel = '';
				$modevalue ='name="'.$transferRes['name'].'",dayId="'.$adddays.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'"';
				$modeId = addlistinggetlastid('quotationModeMaster',$modevalue);

			}
		}

		$b='';
		$b=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationId.'" order by id asc');
		if(mysqli_num_rows($b)>0){
			$transferRes=mysqli_fetch_array($b);
			$addHotel = '';
			$modevalue = 'markupType="'.$transferRes['markupType'].'", markupCost="'.$transferRes['markupCost'].'", curren="'.$transferRes['curren'].'", quotationId="'.$lastQuotationId.'", package="'.$transferRes['package'].'",hotel="'.$transferRes['hotel'].'", guide="'.$transferRes['guide'].'", activity="'.$transferRes['activity'].'", entrance="'.$transferRes['entrance'].'", transfer="'.$transferRes['transfer'].'", train="'.$transferRes['train'].'", flight="'.$transferRes['flight'].'", restaurant="'.$transferRes['restaurant'].'", other="'.$transferRes['other'].'",packageMarkupType="'.$transferRes['packageMarkupType'].'",hotelMarkupType="'.$transferRes['hotelMarkupType'].'",guideMarkupType="'.$transferRes['guideMarkupType'].'",activityMarkupType="'.$transferRes['activityMarkupType'].'",entranceMarkupType="'.$transferRes['entranceMarkupType'].'",transferMarkupType="'.$transferRes['transferMarkupType'].'",trainMarkupType="'.$transferRes['trainMarkupType'].'",flightMarkupType="'.$transferRes['flightMarkupType'].'",restaurantMarkupType="'.$transferRes['restaurantMarkupType'].'",otherMarkupType="'.$transferRes['otherMarkupType'].'", status="'.$transferRes['status'].'"';
			$markup = addlistinggetlastid('quotationServiceMarkup',$modevalue);
		}

		$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" order by id asc');
		if( mysqli_num_rows($c12) > 0){
			updatelisting(_QUOTATION_MASTER_,' isAddExp="1"','id="'.$lastQuotationId.'"');

			while($transferRes=mysqli_fetch_array($c12)){
				$namevalue ='additionalId="'.$transferRes['additionalId'].'",entranceId="'.$transferRes['entranceId'].'",groupCost="'.round($transferRes['groupCost']).'",adultCost="'.round($transferRes['adultCost']).'",childCost="'.round($transferRes['childCost']).'",quotationId="'.$lastQuotationId.'",serviceType="'.($transferRes['serviceType']).'",destinationId="'.($transferRes['destinationId']).'"';
				addlistinggetlastid('quotationAdditionalMaster',$namevalue);

			}
		}

		// update the status to that quottion generated successfully
		updatelisting(_QUOTATION_MASTER_,' deletestatusDuplicate=0','id="'.$lastQuotationId.'"');
	}
		?>
		<script>
	 	var subName = $('#subName').val();
	 	var conf=confirm(subName+' Successfully Added. You want to add new Fix Departure');
    	if(conf == true){
			$('#fromDate').val('');
			$('#toDate').val('');
			$('#subName').val('<?php echo $queryDataq['FDCode']; ?>');
 		}
		else{
			window.location="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['queryId']; ?>";
		}	
	</script>
	<?php 
} ?>