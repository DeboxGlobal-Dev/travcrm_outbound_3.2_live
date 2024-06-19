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

if($_REQUEST['action'] == 'updateSubSeries'){
	$subName = $_REQUEST['subName'];
	$subSeriesCode = $_REQUEST['subSeriesCode'];
	$issueDate = $_REQUEST['issueDate'];
	$fromDate = date('Y-m-d',strtotime($_REQUEST['validFrom']));
	$toDate = date('Y-m-d',strtotime($_REQUEST['validTo']));
	$quotationId = decode($_REQUEST['quotationId']);
	$queryId = decode($_REQUEST['queryId']);
	
	$countQuot='';
	$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' subSeriesCode="'.$subSeriesCode.'"');
	$countQuot=mysqli_num_rows($rs2);
	
	if($countQuot<1){
	
	$namevalue = 'subName="'.$subName.'",subSeriesCode="'.$subSeriesCode.'",issueDate="'.$issueDate.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'"';
	$where='id='.$quotationId.'';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);
	
	
	$count = 0; 
	$rs=GetPageRecord('*','newQuotationDays','queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus=0 order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($rs)){

		$srDaysDate  = date('Y-m-d', strtotime("+".$count." day", strtotime($fromDate)));
		
		$namevalue1 ='srdate="'.$srDaysDate.'"';
		$where1='id='.$QueryDaysData['id'].'';
		updatelisting('newQuotationDays',$namevalue1,$where1);

		$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) order by id asc');
		while($HotelRes=mysqli_fetch_array($b)) {
		
			$namevalue2 ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'"';
			$where2 = 'id='.$HotelRes['id'].'';
			updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue2,$where2);
			updatelisting('quotationItinerary','startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"','serviceId="'.$HotelRes['supplierId'].'"');
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
	}else{
		?>
		<script>
		alert('Sub Series Code is already exist, Try with another one.');
		</script>
		<?php 
	}
}

if($_REQUEST['action'] == 'addSubSeries'){ 
	$subName = $_REQUEST['subName'];
	$subSeriesCode = $_REQUEST['subSeriesCode'];
	$isSeries = 1;
	$issueDate = $_REQUEST['issueDate'];
	$fromDate = $_REQUEST['validFrom'];
	$toDate = $_REQUEST['validTo'];
	
	$queryData=GetPageRecord('seriesCode',_QUERY_MASTER_,'id='.decode($_REQUEST['queryId']).'');
	$queryDataq=mysqli_fetch_array($queryData);
	
	$countQuot='';
	$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' subSeriesCode="'.$subSeriesCode.'"');
	$countQuot=mysqli_num_rows($rs2);
	
	if($countQuot<1){
		$quoteQuery='';
		$quoteQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id='.decode($_REQUEST['quotationId']).'');
		$quotationData=mysqli_fetch_array($quoteQuery);
	  	
		$queryId = $quotationData['queryId'];
		$quotationId = $quotationData['id'];
	
	
		$rsp1=GetPageRecord('quotationNo',_QUOTATION_MASTER_,' queryId="'.$queryId.'" order by quotationNo desc');
		$quotationNoD=mysqli_fetch_array($rsp1);
		//this is greater than first
		$letterAscii = ord($quotationNoD['quotationNo']);
		$letterAscii++;
		$quotationNo = chr($letterAscii); 
		$namevalue='clientType="'.$quotationData['clientType'].'",queryId="'.$queryId.'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$quotationData['adult'].'",child="'.$quotationData['child'].'",night="'.$quotationData['night'].'",rooms="'.$quotationData['rooms'].'",infant="'.$quotationData['infant'].'",sglRoom="'.$quotationData['sglRoom'].'",dblRoom="'.$quotationData['dblRoom'].'",twinRoom="'.$quotationData['twinRoom'].'",tplRoom="'.$quotationData['tplRoom'].'",childwithNoofBed="'.$quotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$quotationData['childwithoutNoofBed'].'",extraNoofBed="'.$quotationData['extraNoofBed'].'",totalpax="'.$quotationData['totalpax'].'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",deletestatus="'.$quotationData['deletestatus'].'",quotationId="'.$quotationData['quotationId'].'",starRating="'.$quotationData['starRating'].'",totalQuotCost="'.$quotationData['totalQuotCost'].'",totalQuotCostwithoutpercent="'.$quotationData['totalQuotCostwithoutpercent'].'",totalCompanyCost="'.$quotationData['totalCompanyCost'].'",totalMargin="'.$quotationData['totalMargin'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'",inclusion="'.addslashes($quotationData['inclusion']).'",exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.$quotationData['isInc_exc'].'",quotationNo="'.$quotationNo.'",generateNo="'.$quotationData['generateNo'].'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",languageId="'.$quotationData['languageId'].'",searchKeyword="'.$quotationData['searchKeyword'].'",deletestatusDuplicate="'.$quotationData['deletestatusDuplicate'].'",subSeriesCode="'.$subSeriesCode.'",subName="'.$subName.'",isSeries="'.$isSeries.'",issueDate="'.$issueDate.'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'"';
	
		$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);
	
	// duplicate pax slab lists
		$b='';
		$b=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationData['id'].'" order by fromRange asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';  
				$modevalue = 'quotationId="'.$lastQuotationId.'", fromRange="'.$transferRes['fromRange'].'", toRange="'.$transferRes['toRange'].'", localEscort="'.$transferRes['localEscort'].'", foreignEscort="'.$transferRes['foreignEscort'].'", dividingFactor="'.$transferRes['dividingFactor'].'", status="'.$transferRes['status'].'", deletestatus="'.$transferRes['deletestatus'].'", dateAdded="'.$transferRes['dateAdded'].'", modifyDate="'.$transferRes['modifyDate'].'", modifyBy="'.$transferRes['modifyBy'].'"dividingFactorC="'.$transferRes['dividingFactorC'].'", DF_SGL="'.$transferRes['DF_SGL'].'", DF_DBL="'.$transferRes['DF_DBL'].'", DF_TWN="'.$transferRes['DF_TWN'].'", DF_TPL="'.$transferRes['DF_TPL'].'", DF_QUAD="'.$transferRes['DF_QUAD'].'", DF_SIX="'.$transferRes['DF_SIX'].'", DF_EIGHT="'.$transferRes['DF_EIGHT'].'", DF_TEN="'.$transferRes['DF_TEN'].'", DF_ABED="'.$transferRes['DF_ABED'].'", DF_CBED="'.$transferRes['DF_CBED'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",sglRoom="'.$transferRes['sglRoom'].'",dblRoom="'.$transferRes['dblRoom'].'",twinRoom="'.$transferRes['twinRoom'].'",tplRoom="'.$transferRes['tplRoom'].'",quadNoofRoom="'.$transferRes['quadNoofRoom'].'",sixNoofBedRoom="'.$transferRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$transferRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$transferRes['tenNoofBedRoom'].'",teenNoofRoom="'.$transferRes['teenNoofRoom'].'",extraNoofBed="'.$transferRes['extraNoofBed'].'",childwithNoofBed="'.$transferRes['childwithNoofBed'].'",childwithoutNoofBed="'.$transferRes['childwithoutNoofBed'].'"';
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
			$namevalue =' queryId="'.$QueryDaysData['queryId'].'",cityId="'.$QueryDaysData['cityId'].'",quotationId="'.$lastQuotationId.'",srdate="'.$srDaysDate.'"';
			$adddays = addlistinggetlastid('newQuotationDays',$namevalue);
			$count++;
			
			$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
			while($HotelRes=mysqli_fetch_array($b)){
				// normal and escort
				$namevalue ='';
				$addHotel ='';
				$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$HotelRes['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomprice="'.$HotelRes['roomprice'].'",noofrooms="'.$HotelRes['noofrooms'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",quadoccupancy="'.$HotelRes['quadoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'", sglMarkup="'.$HotelRes['sglMarkup'].'", dblMarkup="'.$HotelRes['dblMarkup'].'", tplMarkup="'.$HotelRes['tplMarkup'].'", cwbMarkup="'.$HotelRes['cwbMarkup'].'", quadMarkup="'.$HotelRes['quadMarkup'].'", cnbMarkup="'.$HotelRes['cnbMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",mealMarkup="'.$HotelRes['mealMarkup'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",rand_color="'.$HotelRes['rand_color'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",breakfast="'.$HotelRes['breakfast'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",taxType="'.$HotelRes['taxType'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",singleNoofRoom="'.$HotelRes['singleNoofRoom'].'",doubleNoofRoom="'.$HotelRes['doubleNoofRoom'].'",twinNoofRoom="'.$HotelRes['twinNoofRoom'].'",tripleNoofRoom="'.$HotelRes['tripleNoofRoom'].'",extraNoofBed="'.$HotelRes['extraNoofBed'].'",childwithNoofBed="'.$HotelRes['childwithNoofBed'].'",childwithoutNoofBed="'.$HotelRes['childwithoutNoofBed'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isEarlyCheckin="'.$HotelRes['isEarlyCheckin'].'",sixBedRoom="'.$HotelRes['sixBedRoom'].'",eightBedRoom="'.$HotelRes['eightBedRoom'].'",tenBedRoom="'.$HotelRes['tenBedRoom'].'",quadRoom="'.$HotelRes['quadRoom'].'",teenRoom="'.$HotelRes['teenRoom'].'",childBreakfast="'.$HotelRes['childBreakfast'].'",childDinner="'.$HotelRes['childDinner'].'",childLunch="'.$HotelRes['childLunch'].'",sixNoofBedRoom="'.$HotelRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$HotelRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$HotelRes['tenNoofBedRoom'].'",quadNoofRoom="'.$HotelRes['quadNoofRoom'].'",teenNoofRoom="'.$HotelRes['teenNoofRoom'].'",isChildBreakfast="'.$HotelRes['isChildBreakfast'].'",isChildLunch="'.$HotelRes['isChildLunch'].'",isChildDinner="'.$HotelRes['isChildDinner'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

				$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
				if(mysqli_num_rows($check_h)==0){
					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
				}

				// supplement
				$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
				while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
					$namevalue ='';
					$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$hotelSuppD['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",quadoccupancy="'.$hotelSuppD['quadoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'", sglMarkup="'.$hotelSuppD['sglMarkup'].'", dblMarkup="'.$hotelSuppD['dblMarkup'].'", tplMarkup="'.$hotelSuppD['tplMarkup'].'", cwbMarkup="'.$hotelSuppD['cwbMarkup'].'", quadMarkup="'.$hotelSuppD['quadMarkup'].'", cnbMarkup="'.$hotelSuppD['cnbMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",mealMarkup="'.$hotelSuppD['mealMarkup'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",taxType="'.$hotelSuppD['taxType'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isEarlyCheckin="'.$hotelSuppD['isEarlyCheckin'].'",sixBedRoom="'.$hotelSuppD['sixBedRoom'].'",eightBedRoom="'.$hotelSuppD['eightBedRoom'].'",tenBedRoom="'.$hotelSuppD['tenBedRoom'].'",quadRoom="'.$hotelSuppD['quadRoom'].'",teenRoom="'.$hotelSuppD['teenRoom'].'",childBreakfast="'.$hotelSuppD['childBreakfast'].'",childDinner="'.$hotelSuppD['childDinner'].'",childLunch="'.$hotelSuppD['childLunch'].'",sixNoofBedRoom="'.$hotelSuppD['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelSuppD['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelSuppD['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelSuppD['quadNoofRoom'].'",teenNoofRoom="'.$hotelSuppD['teenNoofRoom'].'",isChildBreakfast="'.$hotelSuppD['isChildBreakfast'].'",isChildLunch="'.$hotelSuppD['isChildLunch'].'",isChildDinner="'.$hotelSuppD['isChildDinner'].'"';
					$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

					$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
					if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
						$namevalue ='';
						$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
						addlistinggetlastid('quotationItinerary',$namevalue);
					}
				}
	 

				$qhaQuery=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$HotelRes['id'].'"  and quotationId="'.$QueryDaysData['quotationId'].'" order by id asc');
				while($qhAData=mysqli_fetch_array($qhaQuery)){

					$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",hotelId="'.$qhAData['hotelId'].'",additionalCost="'.$qhAData['additionalCost'].'",name="'.$qhAData['name'].'",hotelQuotId="'.$addHotel.'",additionalId="'.$qhAData['additionalId'].'",costType="'.$qhAData['costType'].'",queryId="'.$qhAData['queryId'].'",destinationId="'.$qhAData['destinationId'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",currencyId="'.$qhAData['currencyId'].'",rateId="'.$qhAData['rateId'].'"';
					addlistinggetlastid('quotationHotelAdditionalMaster',$namevalue);
				}

			}

			$b='';
			$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="transfer" or serviceType="transportation"  order by serviceId asc) order by id asc');
			if(mysqli_num_rows($b)>0){
				while($transferRes=mysqli_fetch_array($b)){
				
					$bb='';
					$bb=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and  id="'.$transferRes['totalPax'].'"');
					if(mysqli_num_rows($bb)>0){
						$paxSlabData=mysqli_fetch_array($bb);
						$bb2='';
						$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and  fromRange="'.$paxSlabData['fromRange'].'" and  toRange="'.$paxSlabData['toRange'].'"  and  dividingFactor="'.$paxSlabData['dividingFactor'].'"  and  status="'.$paxSlabData['status'].'" ');
						$paxSlabData2=mysqli_fetch_array($bb2);
						$totalPaxId = $paxSlabData2['id'];
						
					}
					$addHotel = '';
					$transfernamevalue ='fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$adddays.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'"';
	
					$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
					$c1="";
					$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
					if(mysqli_num_rows($c1)>0){
						 $transferTimelineData=mysqli_fetch_array($c1);
	
						 $namevalue ='quotationId="'.$add.'",dayId="'.$adddays.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
						 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
						
	
					}
	
					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
	
				}
			}
	
			$b=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="guide" order by serviceId asc) and isGuestType=1 order by id asc');
			while($transferRes=mysqli_fetch_array($b)){

				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id']; 

				$addHotel =''; 
				$transfernamevalue ='guideId="'.$transferRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferRes['price'].'",guideName="'.$transferRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferRes['srn'].'",destinationId="'.$transferRes['destinationId'].'",rules="'.$transferRes['rules'].'",category="'.$transferRes['category'].'",subcategory="'.$transferRes['subcategory'].'",totalDays="'.$transferRes['totalDays'].'",perDaycost="'.$transferRes['perDaycost'].'",serviceType="'.$transferRes['serviceType'].'",currencyId="'.$transferRes['currencyId'].'",guideQuoteId="'.$transferRes['guideQuoteId'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",paxRange="'.$transferRes['paxRange'].'",dayType="'.$transferRes['dayType'].'",dayId="'.$adddays.'"';
				
				$addHotel = addlistinggetlastid('quotationGuideMaster',$transfernamevalue);

				$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'"  and guideQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
				while($transferSuppRes=mysqli_fetch_array($bSupp)){
					$suppGuidevalue ='guideId="'.$transferSuppRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",guideQuoteId="'.$addHotel.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$adddays.'"';
		
					$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
				
				}
 
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
				 
	
			}
	
			$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				// tarifId
				$addHotel = '';
				$transfernamevalue ='otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",activityCost="'.$transferRes['activityCost'].'",maxpax="'.$transferRes['maxpax'].'",perPaxCost="'.$transferRes['perPaxCost'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
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
	
				$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",dayId="'.$adddays.'",currencyId="'.$transferRes['currencyId'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);
	
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
	
			}
	
	
	
			$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",currencyId="'.$transferRes['currencyId'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
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
				$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",quotationId="'.$lastQuotationId.'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srDaysDate.'",currencyId="'.$transferRes['currencyId'].'",toDate="'.$srDaysDate.'",queryId="'.$queryId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);
	
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
	
			}
	
	
	
	
			$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$srDaysDate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srDaysDate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",isGuestType="'.$transferRes['isGuestType'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);
	
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$srDaysDate.'",endDate="'.$srDaysDate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
	
			}
	 
			$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$srDaysDate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srDaysDate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",trainId="'.$transferRes['trainId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
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
					$transfernamevalue ='name="'.$transferRes['name'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$queryId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$srDaysDate.'",toDate="'.$srDaysDate.'",currencyId="'.$transferRes['currencyId'].'",additionalId="'.$transferRes['additionalId'].'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
	
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
			$modevalue = 'markupCost="'.$transferRes['markupCost'].'", curren="'.$transferRes['curren'].'", quotationId="'.$lastQuotationId.'", hotel="'.$transferRes['hotel'].'", package="'.$transferRes['package'].'", guide="'.$transferRes['guide'].'", activity="'.$transferRes['activity'].'", entrance="'.$transferRes['entrance'].'", transfer="'.$transferRes['transfer'].'", train="'.$transferRes['train'].'", flight="'.$transferRes['flight'].'", restaurant="'.$transferRes['restaurant'].'", other="'.$transferRes['other'].'",hotelMarkupType="'.$transferRes['hotelMarkupType'].'",packageMarkupType="'.$transferRes['packageMarkupType'].'",guideMarkupType="'.$transferRes['guideMarkupType'].'",activityMarkupType="'.$transferRes['activityMarkupType'].'",entranceMarkupType="'.$transferRes['entranceMarkupType'].'",transferMarkupType="'.$transferRes['transferMarkupType'].'",trainMarkupType="'.$transferRes['trainMarkupType'].'",flightMarkupType="'.$transferRes['flightMarkupType'].'",restaurantMarkupType="'.$transferRes['restaurantMarkupType'].'",otherMarkupType="'.$transferRes['otherMarkupType'].'", status="'.$transferRes['status'].'"';
			$markup = addlistinggetlastid('quotationServiceMarkup',$modevalue);
		}
		
		$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" order by id asc');
		if( mysqli_num_rows($c12) > 0){
			updatelisting(_QUOTATION_MASTER_,' isAddExp="1"','id="'.$lastQuotationId.'"');
		
			while($transferRes=mysqli_fetch_array($c12)){
		
				$namevalue ='additionalId="'.$transferRes['additionalId'].'",adultCost="'.round($transferRes['adultCost']).'",childCost="'.round($transferRes['childCost']).'",infantCost="'.round($transferRes['infantCost']).'",quotationId="'.$lastQuotationId.'",serviceType="'.($transferRes['serviceType']).'",destinationId="'.($transferRes['destinationId']).'"';
				addlistinggetlastid('quotationAdditionalMaster',$namevalue);
		
			}
		}
		
		?>
		<script>
		var subName = $('#subName').val();
		var conf=confirm(subName+' Successfully Added. You want to add new Sub Series');
		if(conf == true){
			$('#fromDate').val('');
			$('#toDate').val('');
			$('#subName').val('<?php echo $queryDataq['seriesCode']; ?>');
		}
		else{
			window.location="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['queryId']; ?>";
		}	
		</script>
		<?php 
	}
	else{
		?>
		<script>
		alert('Sub Series Code is already exist, Try with another one.');
		</script>
		<?php 
	}
} 

if($_REQUEST['action'] == 'changeConfirmStatus'){ 
	$quotationId = $_REQUEST['quotationId'];
	$status = $_REQUEST['status'];
		
	$quoteQuery='';
	$quoteQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$quotationId.'');
	$quotationData=mysqli_fetch_array($quoteQuery);
	
	$ConfirmingTourId = 0;
	$wherel=' status=1 and MONTH(fromDate)="'.date('m',strtotime($quotationData['fromDate'])).'" and YEAR(fromDate)="'.date('Y',strtotime($quotationData['fromDate'])).'" order by ConfirmedTourId desc';
	$rsl=GetPageRecord('id,ConfirmedTourId',_QUOTATION_MASTER_,$wherel); 
	if(mysqli_num_rows($rsl)>0){
		$restti=mysqli_fetch_array($rsl);
		$ConfirmingTourId = $restti['ConfirmedTourId']+1;
	}else{
		if($status == 1){
			$ConfirmingTourId = 1;
		}
	}
	 
	$namevalue = 'status="'.$status.'",ConfirmedTourId="'.$ConfirmingTourId.'",ConfirmedBy="'.$_SESSION['userid'].'",ConfirmedDate="'.date('Y-m-d').'"';
	$where='id='.$quotationId.'';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);
	?>
	<script>
	window.location="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($quotationData['queryId']); ?>";
	</script>
	<?php 
}
 
?>