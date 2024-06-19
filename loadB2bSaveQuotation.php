<?php
ob_start();
include "inc.php";

$countQuot='';
//echo 'id='.decode($_GET['id']).'';
$rs2=GetPageRecord('*',_QUOTATION_MASTER_,'id='.decode($_GET['id']).'');
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
	
	$namevalue='clientType="'.$quotationData['clientType'].'",queryId="'.$queryId.'",tcs="'.$quotationData['tcs'].'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$quotationData['adult'].'",child="'.$quotationData['child'].'",night="'.$quotationData['night'].'",rooms="'.$quotationData['rooms'].'",infant="'.$quotationData['infant'].'",sglRoom="'.$quotationData['sglRoom'].'",dblRoom="'.$quotationData['dblRoom'].'",twinRoom="'.$quotationData['twinRoom'].'",tplRoom="'.$quotationData['tplRoom'].'",childwithNoofBed="'.$quotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$quotationData['childwithoutNoofBed'].'",extraNoofBed="'.$quotationData['extraNoofBed'].'",sixNoofBedRoom="'.$quotationData['sixNoofBedRoom'].'",eightNoofBedRoom="'.$quotationData['eightNoofBedRoom'].'",tenNoofBedRoom="'.$quotationData['tenNoofBedRoom'].'",quadNoofRoom="'.$quotationData['quadNoofRoom'].'",teenNoofRoom="'.$quotationData['teenNoofRoom'].'",totalpax="'.$quotationData['totalpax'].'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",quotationId="'.$quotationData['quotationId'].'",starRating="'.$quotationData['starRating'].'",totalAmount="'.$quotationData['totalAmount'].'",totalquotCostWithMarkup="'.$quotationData['totalquotCostWithMarkup'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'",inclusion="'.addslashes($quotationData['inclusion']).'",exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.$quotationData['isInc_exc'].'",quotationNo="'.$quotationNo.'",generateNo="'.$quotationData['generateNo'].'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",languageId="'.$quotationData['languageId'].'",deletestatusDuplicate="'.$quotationData['deletestatusDuplicate'].'",propIMGNum3="'.$quotationData['propIMGNum3'].'",propIMGNum4="'.$quotationData['propIMGNum4'].'",propIMGNum6="'.$quotationData['propIMGNum6'].'",onlyTFS="'.$quotationData['onlyTFS'].'",visaRequired="'.$quotationData['visaRequired'].'",passportRequired="'.$quotationData['passportRequired'].'",flightRequired="'.$quotationData['flightRequired'].'",insuranceRequired="'.$quotationData['insuranceRequired'].'",visaCostType="'.$quotationData['visaCostType'].'",passportCostType="'.$quotationData['passportCostType'].'",insuranceCostType="'.$quotationData['insuranceCostType'].'",dayWise="'.$quotationData['dayWise'].'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'",packageSupplier="'.$quotationData['packageSupplier'].'",deletestatus=1';
	
	$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);

	$b='';
	$b=GetPageRecord('*',_QUOTATION_VISA_MASTER_,' quotationId="'.$quotationData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="visa" order by serviceId asc) order by id asc');
	while($visaRes=mysqli_fetch_array($b)){
		$addVisa = '';
		$visanamevalue ='fromDate="'.$visaRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$visaRes['toDate'].'",adultCost="'.$visaRes['adultCost'].'",childCost="'.$visaRes['childCost'].'",serviceid="'.$visaRes['serviceid'].'",name="'.$visaRes['name'].'",rateId="'.$visaRes['rateId'].'",visaTypeId="'.$visaRes['visaTypeId'].'",supplierId="'.$visaRes['supplierId'].'",startDate="'.$visaRes['startDate'].'",currencyId="'.$visaRes['currencyId'].'",currencyValue="'.$visaRes['currencyValue'].'",gstTax="'.$visaRes['gstTax'].'",infantCost="'.$visaRes['infantCost'].'",adultPax="'.$visaRes['adultPax'].'",childPax="'.$visaRes['childPax'].'",infantPax="'.$visaRes['infantPax'].'",queryId="'.$visaRes['queryId'].'",markupType="'.$visaRes['markupType'].'",processingFee="'.$visaRes['processingFee'].'",vfsCharges="'.$visaRes['vfsCharges'].'",embassyFee="'.$visaRes['embassyFee'].'",status="'.$visaRes['status'].'",deletestatus="'.$visaRes['deletestatus'].'",addedBy="'.$visaRes['addedBy'].'",dateAdded="'.$visaRes['dateAdded'].'",modifyBy="'.$visaRes['modifyBy'].'",modifyDate="'.$visaRes['modifyDate'].'"';
		$addVisa = addlistinggetlastid(_QUOTATION_VISA_MASTER_,$visanamevalue);
		
		$namevalue ='';
		$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$visaRes['queryId'].'",serviceId="'.$addVisa.'",quotationId="'.$lastQuotationId.'",serviceType="visa",startDate="'.$visaRes['fromDate'].'",endDate="'.$visaRes['toDate'].'",startTime="'.$visaRes['startTime'].'",endTime="'.$visaRes['endTime'].'"';
		addlistinggetlastid('quotationItinerary',$namevalue);

	}

	$b='';
	$b=GetPageRecord('*',_QUOTATION_PASSPORT_MASTER_,' quotationId="'.$quotationData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="passport" order by serviceId asc) order by id asc');
	while($passportRes=mysqli_fetch_array($b)){
		$addPass = '';
		$passnamevalue ='fromDate="'.$passportRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$passportRes['toDate'].'",adultCost="'.$passportRes['adultCost'].'",childCost="'.$passportRes['childCost'].'",serviceid="'.$passportRes['serviceid'].'",name="'.$passportRes['name'].'",rateId="'.$passportRes['rateId'].'",passportTypeId="'.$passportRes['passportTypeId'].'",supplierId="'.$passportRes['supplierId'].'",startDate="'.$passportRes['startDate'].'",currencyId="'.$passportRes['currencyId'].'",currencyValue="'.$passportRes['currencyValue'].'",gstTax="'.$passportRes['gstTax'].'",infantCost="'.$passportRes['infantCost'].'",adultPax="'.$passportRes['adultPax'].'",childPax="'.$passportRes['childPax'].'",infantPax="'.$passportRes['infantPax'].'",queryId="'.$passportRes['queryId'].'",markupType="'.$passportRes['markupType'].'",processingFee="'.$passportRes['processingFee'].'",status="'.$passportRes['status'].'",deletestatus="'.$passportRes['deletestatus'].'",addedBy="'.$passportRes['addedBy'].'",dateAdded="'.$passportRes['dateAdded'].'",modifyBy="'.$passportRes['modifyBy'].'",modifyDate="'.$passportRes['modifyDate'].'"';
		$addPass = addlistinggetlastid(_QUOTATION_PASSPORT_MASTER_,$passnamevalue);
		
		$namevalue ='';
		$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$passportRes['queryId'].'",serviceId="'.$addPass.'",quotationId="'.$lastQuotationId.'",serviceType="passport",startDate="'.$passportRes['fromDate'].'",endDate="'.$passportRes['toDate'].'",startTime="'.$passportRes['startTime'].'",endTime="'.$passportRes['endTime'].'"';
		addlistinggetlastid('quotationItinerary',$namevalue);

	}

	$b='';
	$b=GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,' quotationId="'.$quotationData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="insurance" order by serviceId asc) order by id asc');
	while($insuranceRes=mysqli_fetch_array($b)){
		$addInsurance = '';
		$insurancenamevalue ='fromDate="'.$insuranceRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$insuranceRes['toDate'].'",adultCost="'.$insuranceRes['adultCost'].'",childCost="'.$insuranceRes['childCost'].'",serviceid="'.$insuranceRes['serviceid'].'",name="'.$insuranceRes['name'].'",rateId="'.$insuranceRes['rateId'].'",insuranceTypeId="'.$insuranceRes['insuranceTypeId'].'",supplierId="'.$insuranceRes['supplierId'].'",startDate="'.$insuranceRes['startDate'].'",currencyId="'.$insuranceRes['currencyId'].'",currencyValue="'.$insuranceRes['currencyValue'].'",gstTax="'.$insuranceRes['gstTax'].'",infantCost="'.$insuranceRes['infantCost'].'",adultPax="'.$insuranceRes['adultPax'].'",childPax="'.$insuranceRes['childPax'].'",infantPax="'.$insuranceRes['infantPax'].'",queryId="'.$insuranceRes['queryId'].'",markupType="'.$insuranceRes['markupType'].'",processingFee="'.$insuranceRes['processingFee'].'",status="'.$insuranceRes['status'].'",deletestatus="'.$insuranceRes['deletestatus'].'",addedBy="'.$insuranceRes['addedBy'].'",dateAdded="'.$insuranceRes['dateAdded'].'",modifyBy="'.$insuranceRes['modifyBy'].'",modifyDate="'.$insuranceRes['modifyDate'].'"';
		$addInsurance = addlistinggetlastid(_QUOTATION_INSURANCE_MASTER_,$insurancenamevalue);
		
		$namevalue ='';
		$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$insuranceRes['queryId'].'",serviceId="'.$addInsurance.'",quotationId="'.$lastQuotationId.'",serviceType="insurance",startDate="'.$insuranceRes['fromDate'].'",endDate="'.$insuranceRes['toDate'].'",startTime="'.$insuranceRes['startTime'].'",endTime="'.$insuranceRes['endTime'].'"';
		addlistinggetlastid('quotationItinerary',$namevalue);

	}


	// duplicate pax slab lists
	$b='';
	$b=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationData['id'].'" order by fromRange asc');
	if(mysqli_num_rows($b)>0){
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';  
			$modevalue = 'quotationId="'.$lastQuotationId.'", fromRange="'.$transferRes['fromRange'].'", toRange="'.$transferRes['toRange'].'", localEscort="'.$transferRes['localEscort'].'", foreignEscort="'.$transferRes['foreignEscort'].'", dividingFactor="'.$transferRes['dividingFactor'].'", status="'.$transferRes['status'].'", deletestatus="'.$transferRes['deletestatus'].'", dateAdded="'.$transferRes['dateAdded'].'", modifyDate="'.$transferRes['modifyDate'].'", modifyBy="'.$transferRes['modifyBy'].'", dividingFactorC="'.$transferRes['dividingFactorC'].'", DF_SGL="'.$transferRes['DF_SGL'].'", DF_DBL="'.$transferRes['DF_DBL'].'", DF_TWN="'.$transferRes['DF_TWN'].'", DF_TPL="'.$transferRes['DF_TPL'].'", DF_QUAD="'.$transferRes['DF_QUAD'].'", DF_SIX="'.$transferRes['DF_SIX'].'", DF_EIGHT="'.$transferRes['DF_EIGHT'].'", DF_TEN="'.$transferRes['DF_TEN'].'", DF_ABED="'.$transferRes['DF_ABED'].'", DF_CBED="'.$transferRes['DF_CBED'].'" ,adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",sglRoom="'.$transferRes['sglRoom'].'",dblRoom="'.$transferRes['dblRoom'].'",twinRoom="'.$transferRes['twinRoom'].'",tplRoom="'.$transferRes['tplRoom'].'",quadNoofRoom="'.$transferRes['quadNoofRoom'].'",sixNoofBedRoom="'.$transferRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$transferRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$transferRes['tenNoofBedRoom'].'",teenNoofRoom="'.$transferRes['teenNoofRoom'].'",extraNoofBed="'.$transferRes['extraNoofBed'].'",childwithNoofBed="'.$transferRes['childwithNoofBed'].'",childwithoutNoofBed="'.$transferRes['childwithoutNoofBed'].'"';
			$slabId = addlistinggetlastid('totalPaxSlab',$modevalue);
			 

			$esQ="";
			$esQ=GetPageRecord('*','quotationFOCRates',' slabId="'.$transferRes['id'].'" and quotationId="'.$transferRes['quotationId'].'"');
			if(mysqli_num_rows($esQ) > 0){
				while($escortData=mysqli_fetch_array($esQ)){
					$focRatesQuery = '';  
					$focRatesQuery ='quotationId="'.$lastQuotationId.'",slabId="'.$slabId.'",sglNORoom="'.$escortData['sglNORoom'].'",dblNORoom="'.$escortData['dblNORoom'].'",tplNORoom="'.$escortData['tplNORoom'].'",focType="'.$escortData['focType'].'",hotelCost="'.$escortData['hotelCost'].'",guideCost="'.$escortData['guideCost'].'",activityCost="'.$escortData['activityCost'].'",entranceCost="'.$escortData['entranceCost'].'",transferCost="'.$escortData['transferCost'].'",ferryCost="'.$escortData['ferryCost'].'",trainCost="'.$escortData['trainCost'].'",flightCost="'.$escortData['flightCost'].'",restaurantCost="'.$escortData['restaurantCost'].'",otherCost="'.$escortData['otherCost'].'",hotelCalType="'.$escortData['hotelCalType'].'",guideCalType="'.$escortData['guideCalType'].'",activityCalType="'.$escortData['activityCalType'].'",entranceCalType="'.$escortData['entranceCalType'].'",transferCalType="'.$escortData['transferCalType'].'",ferryCalType="'.$escortData['ferryCalType'].'",trainCalType="'.$escortData['trainCalType'].'",flightCalType="'.$escortData['flightCalType'].'",restaurantCalType="'.$escortData['restaurantCalType'].'",otherCalType="'.$escortData['otherCalType'].'"';
					$focRateId = addlistinggetlastid('quotationFOCRates',$focRatesQuery);
				} 
			}
		}
	}

	$rs=GetPageRecord('*','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus=0 order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($rs)){

		$adddays='';
		$namevalue =' queryId="'.$QueryDaysData['queryId'].'",cityId="'.$QueryDaysData['cityId'].'",quotationId="'.$lastQuotationId.'",srdate="'.$QueryDaysData['srdate'].'",title="'.$QueryDaysData['title'].'",description="'.$QueryDaysData['description'].'"';
		$adddays = addlistinggetlastid('newQuotationDays',$namevalue);

		$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
		while($HotelRes=mysqli_fetch_array($b)){
			// normal and escort isSelectedType
			$namevalue ='';
			$addHotel ='';
			$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$HotelRes['fromDate'].'",toDate="'.$HotelRes['toDate'].'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$HotelRes['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",currencyValue="'.$HotelRes['currencyValue'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomprice="'.$HotelRes['roomprice'].'",noofrooms="'.$HotelRes['noofrooms'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",quadoccupancy="'.$HotelRes['quadoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'", taxType="'.$HotelRes['taxType'].'",markupType="'.$HotelRes['markupType'].'",sglMarkup="'.$HotelRes['sglMarkup'].'",dblMarkup="'.$HotelRes['dblMarkup'].'",twinMarkup="'.$HotelRes['twinMarkup'].'",tplMarkup="'.$HotelRes['tplMarkup'].'",cwbMarkup="'.$HotelRes['cwbMarkup'].'",quadMarkup="'.$HotelRes['quadMarkup'].'",sixMarkup="'.$HotelRes['sixMarkup'].'",eightMarkup="'.$HotelRes['eightMarkup'].'",tenMarkup="'.$HotelRes['tenMarkup'].'",teenMarkup="'.$HotelRes['teenMarkup'].'",cnbMarkup="'.$HotelRes['cnbMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",mealMarkup="'.$HotelRes['mealMarkup'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",rand_color="'.$HotelRes['rand_color'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",breakfast="'.$HotelRes['breakfast'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",singleNoofRoom="'.$HotelRes['singleNoofRoom'].'",doubleNoofRoom="'.$HotelRes['doubleNoofRoom'].'",twinNoofRoom="'.$HotelRes['twinNoofRoom'].'",tripleNoofRoom="'.$HotelRes['tripleNoofRoom'].'",extraNoofBed="'.$HotelRes['extraNoofBed'].'",childwithNoofBed="'.$HotelRes['childwithNoofBed'].'",childwithoutNoofBed="'.$HotelRes['childwithoutNoofBed'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isSelectedFinal="'.$HotelRes['isSelectedFinal'].'",isSelectedType="'.$HotelRes['isSelectedType'].'",isEarlyCheckin="'.$HotelRes['isEarlyCheckin'].'",sixBedRoom="'.$HotelRes['sixBedRoom'].'",eightBedRoom="'.$HotelRes['eightBedRoom'].'",tenBedRoom="'.$HotelRes['tenBedRoom'].'",quadRoom="'.$HotelRes['quadRoom'].'",teenRoom="'.$HotelRes['teenRoom'].'",childBreakfast="'.$HotelRes['childBreakfast'].'",childDinner="'.$HotelRes['childDinner'].'",childLunch="'.$HotelRes['childLunch'].'",sixNoofBedRoom="'.$HotelRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$HotelRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$HotelRes['tenNoofBedRoom'].'",quadNoofRoom="'.$HotelRes['quadNoofRoom'].'",teenNoofRoom="'.$HotelRes['teenNoofRoom'].'",isChildBreakfast="'.$HotelRes['isChildBreakfast'].'",isChildLunch="'.$HotelRes['isChildLunch'].'",isChildDinner="'.$HotelRes['isChildDinner'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

			$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
			if(mysqli_num_rows($check_h)==0){
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$HotelRes['fromDate'].'",endDate="'.$HotelRes['fromDate'].'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}

			// supplement
			$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
			while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
				$namevalue ='';
				$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$hotelSuppD['fromDate'].'",toDate="'.$hotelSuppD['toDate'].'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$hotelSuppD['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",currencyValue="'.$hotelSuppD['currencyValue'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",quadoccupancy="'.$hotelSuppD['quadoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'", taxType="'.$hotelSuppD['taxType'].'",markupType="'.$hotelSuppD['markupType'].'",sglMarkup="'.$hotelSuppD['sglMarkup'].'",dblMarkup="'.$hotelSuppD['dblMarkup'].'",twinMarkup="'.$hotelSuppD['twinMarkup'].'",tplMarkup="'.$hotelSuppD['tplMarkup'].'",cwbMarkup="'.$hotelSuppD['cwbMarkup'].'",quadMarkup="'.$hotelSuppD['quadMarkup'].'",sixMarkup="'.$hotelSuppD['sixMarkup'].'",eightMarkup="'.$hotelSuppD['eightMarkup'].'",tenMarkup="'.$hotelSuppD['tenMarkup'].'",teenMarkup="'.$hotelSuppD['teenMarkup'].'",cnbMarkup="'.$hotelSuppD['cnbMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",mealMarkup="'.$hotelSuppD['mealMarkup'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",taxType="'.$hotelSuppD['taxType'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isSelectedFinal="'.$hotelSuppD['isSelectedFinal'].'",isSelectedType="'.$hotelSuppD['isSelectedType'].'",isEarlyCheckin="'.$hotelSuppD['isEarlyCheckin'].'",sixBedRoom="'.$hotelSuppD['sixBedRoom'].'",eightBedRoom="'.$hotelSuppD['eightBedRoom'].'",tenBedRoom="'.$hotelSuppD['tenBedRoom'].'",quadRoom="'.$hotelSuppD['quadRoom'].'",teenRoom="'.$hotelSuppD['teenRoom'].'",childBreakfast="'.$hotelSuppD['childBreakfast'].'",childDinner="'.$hotelSuppD['childDinner'].'",childLunch="'.$hotelSuppD['childLunch'].'",sixNoofBedRoom="'.$hotelSuppD['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelSuppD['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelSuppD['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelSuppD['quadNoofRoom'].'",teenNoofRoom="'.$hotelSuppD['teenNoofRoom'].'",isChildBreakfast="'.$hotelSuppD['isChildBreakfast'].'",isChildLunch="'.$hotelSuppD['isChildLunch'].'",isChildDinner="'.$hotelSuppD['isChildDinner'].'"';
				$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

				$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
				if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$hotelSuppD['fromDate'].'",endDate="'.$hotelSuppD['fromDate'].'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
				}
			}
 

			$qhaQuery=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$HotelRes['id'].'"  and quotationId="'.$QueryDaysData['quotationId'].'" order by id asc');
			while($qhAData=mysqli_fetch_array($qhaQuery)){

				$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",hotelId="'.$qhAData['hotelId'].'",additionalCost="'.$qhAData['additionalCost'].'",name="'.$qhAData['name'].'",hotelQuotId="'.$addHotel.'",additionalId="'.$qhAData['additionalId'].'",costType="'.$qhAData['costType'].'",queryId="'.$qhAData['queryId'].'",destinationId="'.$qhAData['destinationId'].'",fromDate="'.$qhAData['fromDate'].'",toDate="'.$qhAData['toDate'].'",currencyId="'.$qhAData['currencyId'].'",currencyValue="'.$qhAData['currencyValue'].'",rateId="'.$qhAData['rateId'].'"';
				addlistinggetlastid('quotationHotelAdditionalMaster',$namevalue);
			}

		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
			
				 
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id']; 

					
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",distance="'.$transferRes['distance'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$adddays.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'"';

				$transQuoteId = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1);
 
					$namevalue ='quotationId="'.$add.'",dayId="'.$adddays.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$transQuoteId.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					$hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue); 
				}

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$transQuoteId.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
		}
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="transportation" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
			
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$adddays.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'"';

				$transQuoteId = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1);

					$namevalue ='quotationId="'.$add.'",dayId="'.$adddays.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$transQuoteId.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					$hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
				
				}

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$transQuoteId.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
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
			$transfernamevalue ='guideId="'.$transferRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferRes['price'].'",guideName="'.$transferRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferRes['srn'].'",destinationId="'.$transferRes['destinationId'].'",rules="'.$transferRes['rules'].'",category="'.$transferRes['category'].'",subcategory="'.$transferRes['subcategory'].'",totalDays="'.$transferRes['totalDays'].'",perDaycost="'.$transferRes['perDaycost'].'",serviceType="'.$transferRes['serviceType'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",guideQuoteId="'.$transferRes['guideQuoteId'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",paxRange="'.$transferRes['paxRange'].'",dayType="'.$transferRes['dayType'].'",dayId="'.$adddays.'"';

			$addHotel = addlistinggetlastid('quotationGuideMaster',$transfernamevalue);

			$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'"  and guideQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
			while($transferSuppRes=mysqli_fetch_array($bSupp)){
				$suppGuidevalue ='guideId="'.$transferSuppRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",markupType="'.$transferSuppRes['markupType'].'",markupCost="'.$transferSuppRes['markupCost'].'",taxType="'.$transferSuppRes['taxType'].'",gstTax="'.$transferSuppRes['gstTax'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",currencyValue="'.$transferSuppRes['currencyValue'].'",guideQuoteId="'.$addHotel.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$adddays.'"';
	
				$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
			}
			
			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}

		$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			// tarifId
			$addHotel = '';
			$transfernamevalue ='otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",activityCost="'.$transferRes['activityCost'].'",maxpax="'.$transferRes['maxpax'].'",perPaxCost="'.$transferRes['perPaxCost'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferType="'.$transferRes['transferType'].'",slabId="'.$transferRes['slabId'].'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",vehicleId="'.$transferRes['vehicleId'].'",repCost="'.$transferRes['repCost'].'",tarifType="'.$transferRes['tarifType'].'",nationality="'.$transferRes['nationality'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$adddays.'"'; 
			$addHotel = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$transfernamevalue);
			
			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="activity",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
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

			$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",dayId="'.$adddays.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}



		$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",repCost="'.$transferRes['repCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferType="'.$transferRes['transferType'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationEntranceMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="entrance",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1);

				 $namevalue ='quotationId="'.$add.'",dayId="'.$adddays.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);

			}
		}
		// Duplicate Ferry
		$b=GetPageRecord('*','quotationFerryMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="ferry" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$ferrynamevalue ='ferryNameId="'.$transferRes['ferryNameId'].'",serviceid="'.$transferRes['serviceid'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",ferryClass="'.$transferRes['ferryClass'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",ferryCost="'.$transferRes['ferryCost'].'",processingfee="'.$transferRes['processingfee'].'",miscCost="'.$transferRes['miscCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",pickupTime="'.$transferRes['pickupTime'].'",dropTime="'.$transferRes['dropTime'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",remark="'.$transferRes['remark'].'",rateId="'.$transferRes['rateId'].'",timeId="'.$transferRes['timeId'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationFerryMaster',$ferrynamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="ferry",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
		}
 
		$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",quotationId="'.$lastQuotationId.'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$transferRes['fromDate'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",toDate="'.$transferRes['toDate'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$transferRes['toDate'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",markupType="'.$transferRes['markupType'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}
 
		$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$transferRes['toDate'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",trainId="'.$transferRes['trainId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",markupType="'.$transferRes['markupType'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",queryId="'.$queryId.'",dayId="'.$adddays.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="train",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
				
				$addHotel = '';
				$transfernamevalue ='name="'.$transferRes['name'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$queryId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",costType="'.$transferRes['costType'].'",additionalId="'.$transferRes['additionalId'].'",dayId="'.$adddays.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="additional",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
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
		$modevalue = ' markupCost="'.$transferRes['markupCost'].'", curren="'.$transferRes['curren'].'", quotationId="'.$lastQuotationId.'", package="'.$transferRes['package'].'", hotel="'.$transferRes['hotel'].'", guide="'.$transferRes['guide'].'", activity="'.$transferRes['activity'].'", entrance="'.$transferRes['entrance'].'", transfer="'.$transferRes['transfer'].'", train="'.$transferRes['train'].'",flight="'.$transferRes['flight'].'", restaurant="'.$transferRes['restaurant'].'",ferry="'.$transferRes['ferry'].'",visa="'.$transferRes['visa'].'",passport="'.$transferRes['passport'].'",insurance="'.$transferRes['insurance'].'",other="'.$transferRes['other'].'",packageMarkupType="'.$transferRes['packageMarkupType'].'",hotelMarkupType="'.$transferRes['hotelMarkupType'].'",guideMarkupType="'.$transferRes['guideMarkupType'].'",activityMarkupType="'.$transferRes['activityMarkupType'].'",entranceMarkupType="'.$transferRes['entranceMarkupType'].'",transferMarkupType="'.$transferRes['transferMarkupType'].'",trainMarkupType="'.$transferRes['trainMarkupType'].'",flightMarkupType="'.$transferRes['flightMarkupType'].'",restaurantMarkupType="'.$transferRes['restaurantMarkupType'].'",ferryMarkupType="'.$transferRes['ferryMarkupType'].'",visaMarkupType="'.$transferRes['visaMarkupType'].'",passportMarkupType="'.$transferRes['passportMarkupType'].'",insuranceMarkupType="'.$transferRes['insuranceMarkupType'].'",otherMarkupType="'.$transferRes['otherMarkupType'].'", status="'.$transferRes['status'].'"';
		$markup = addlistinggetlastid('quotationServiceMarkup',$modevalue);
	}

	$getPackageRateQuery="";
	$getPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
	if(mysqli_num_rows($getPackageRateQuery) > 0){
	    $transferRes=mysqli_fetch_array($getPackageRateQuery); 

		$addHotel = '';
		$modevalue = 'queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",singleCost="'.$transferRes['singleCost'].'",doubleCost="'.$transferRes['doubleCost'].'",tripleCost="'.$transferRes['tripleCost'].'",twinCost="'.$transferRes['twinCost'].'",quadCost="'.$transferRes['quadCost'].'",sixBedCost="'.$transferRes['sixBedCost'].'",eightBedCost="'.$transferRes['eightBedCost'].'",tenBedCost="'.$transferRes['tenBedCost'].'",teenBedCost="'.$transferRes['teenBedCost'].'",extraBedACost="'.$transferRes['extraBedACost'].'",childwithbedCost="'.$transferRes['childwithbedCost'].'",childwithoutbedCost="'.$transferRes['childwithoutbedCost'].'",guideA="'.$transferRes['guideA'].'",activityA="'.$transferRes['activityA'].'",entranceA="'.$transferRes['entranceA'].'",enrouteA="'.$transferRes['enrouteA'].'",transferA="'.$transferRes['transferA'].'",trainA="'.$transferRes['trainA'].'",flightA="'.$transferRes['flightA'].'",restaurantA="'.$transferRes['restaurantA'].'",otherA="'.$transferRes['otherA'].'",guideC="'.$transferRes['guideC'].'",activityC="'.$transferRes['activityC'].'",entranceC="'.$transferRes['entranceC'].'",enrouteC="'.$transferRes['enrouteC'].'",transferC="'.$transferRes['transferC'].'",trainC="'.$transferRes['trainC'].'",flightC="'.$transferRes['flightC'].'",restaurantC="'.$transferRes['restaurantC'].'",otherC="'.$transferRes['otherC'].'",supplierId="'.$transferRes['supplierId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",singleBasis="'.$transferRes['singleBasis'].'",doubleBasis="'.$transferRes['doubleBasis'].'",tripleBasis="'.$transferRes['tripleBasis'].'",twinBasis="'.$transferRes['twinBasis'].'",quadBasis="'.$transferRes['quadBasis'].'",sixBedBasis="'.$transferRes['sixBedBasis'].'",eightBedBasis="'.$transferRes['eightBedBasis'].'",tenBedBasis="'.$transferRes['tenBedBasis'].'",teenBedBasis="'.$transferRes['teenBedBasis'].'",extraBedABasis="'.$transferRes['extraBedABasis'].'",childwithbedBasis="'.$transferRes['childwithbedBasis'].'",childwithoutbedBasis="'.$transferRes['childwithoutbedBasis'].'",infantBedBasis="'.$transferRes['infantBedBasis'].'"';
		$addHotel = addlistinggetlastid('packageWiseRateMaster',$modevalue);
	} 

	$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" order by id asc');
	if( mysqli_num_rows($c12) > 0){
		updatelisting(_QUOTATION_MASTER_,' isAddExp="1"','id="'.$lastQuotationId.'"');

		while($transferRes=mysqli_fetch_array($c12)){
			$namevalue ='additionalId="'.$transferRes['additionalId'].'",adultCost="'.round($transferRes['adultCost']).'",childCost="'.round($transferRes['childCost']).'",infantCost="'.round($transferRes['infantCost']).'",quotationId="'.$lastQuotationId.'",serviceType="'.($transferRes['serviceType']).'",destinationId="'.($transferRes['destinationId']).'"';
			addlistinggetlastid('quotationAdditionalMaster',$namevalue);

		}
	}
	// mark as created succesffully
	updatelisting(_QUOTATION_MASTER_,' deletestatus=0','id="'.$lastQuotationId.'"');

}

?>
<script>
window.location="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&b2bquotation=1&qtype=1";
</script>
