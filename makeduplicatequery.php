<?php
ob_start();

include "inc.php";

// error_reporting(E_ALL);
// ini_set('log_errors', 1);
// ini_set('error_log', '/path/to/error.log');

if($_REQUEST['action']=='makeDuplicateModule' && $_REQUEST['queryId']!='' && $_REQUEST['updateqId']!=''){
	$oldqueryId = $_REQUEST['queryId'];
	$newqueryId = $_REQUEST['updateqId'];

	$countQuot='';

	$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$oldqueryId.'" and status=1 and isTourEx=0 order by id desc');
	$countQuot=mysqli_num_rows($rs2);

	if($countQuot>0){

		$quotationData=mysqli_fetch_array($rs2);
		$quotationId = $quotationData['id'];
 
		$rsu = GetPageRecord('*',_QUERY_MASTER_,'id="'.$oldqueryId.'"');
	    $queryData = mysqli_fetch_assoc($rsu);
	    $tat = $queryData['tat'];
	    $night = $quotationData['night'];
	    $destinationId = $quotationData['destinationId'];

		$fromDate = date('Y-m-d',strtotime($quotationData['fromDate']));
	    $toDate   = date('Y-m-d',strtotime($quotationData['toDate']));

	    // displayId and financial year should from current date.
		$queryDate=date('Y-m-d');
		$displayId = generateQueryId($queryDate);
		// get the right financial year
		$financeYear = getFinancialYear($queryDate);

		// seasonType
		$qnamevalue ='displayId="'.$displayId.'",night="'.$night.'",queryDate="'.$queryDate.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",companyId="'.$queryData['companyId'].'",leadPaxName="'.addslashes($queryData['leadPaxName']).'",deletestatus=0,adult="'.$queryData['adult'].'",child="'.$queryData['child'].'",infant="'.$queryData['infant'].'",categoryId="'.$queryData['categoryId'].'",mealPlanId="'.$queryData['mealPlanId'].'",officeBranch="'.$queryData['officeBranch'].'",assignTo="'.$queryData['assignTo'].'",paxType="'.$queryData['paxType'].'",description="'.$queryData['description'].'",tourType="'.$queryData['tourType'].'",subTourType="'.$queryData['subTourType'].'",hotelTypeId="'.$queryData['hotelTypeId'].'",subject="'.$queryData['subject'].'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.time().'",destinationId="'.$destinationId.'",guest1="'.$queryData['guest1'].'",guest2="'.$queryData['guest2'].'",queryPriority="'.$queryData['queryPriority'].'",clientType="'.$queryData['clientType'].'",rooms="'.$queryData['rooms'].'",hotelBudget="'.$queryData['hotelBudget'].'",guest1phone="'.$queryData['guest1phone'].'",guest1email="'.$queryData['guest1email'].'",paymentMode="'.$queryData['paymentMode'].'",queryTimer="'.time().'",closerDate="'.$queryData['closerDate'].'",leadsource="'.$queryData['leadsource'].'",campaign="'.$queryData['campaign'].'",competitor="'.$queryData['competitor'].'",subDestination="'.$queryData['subDestination'].'",age1="'.$queryData['age1'].'",age2="'.$queryData['age2'].'",age3="'.$queryData['age3'].'",filecode="'.$queryData['filecode'].'",referanceno="'.$queryData['referanceno'].'",single="'.$queryData['single'].'",doubleocp="'.$queryData['doubleocp'].'",quotationYes="'.$queryData['quotationYes'].'",triple="'.$queryData['triple'].'",servicePrice="'.$queryData['servicePrice'].'",queryOrder="'.time().'",tatDate="'.date('Y-m-d H:i:s', strtotime("+".$tat." min")).'",tatNumber=0,queryStatus="'.$queryData['queryStatus'].'",quotationDate="'.date('Y-m-d').'",tat="'.$tat.'",hotelAccommodation="'.$queryData['hotelAccommodation'].'",needFlight="'.$queryData['needFlight'].'",earlyCheckin="'.$queryData['earlyCheckin'].'",hotelCategory="'.$queryData['hotelCategory'].'",cabforLocal="'.$queryData['cabforLocal'].'",gstState="'.$queryData['gstState'].'",uploadPhoto="'.$queryData['uploadPhoto'].'",queryType="'.$queryData['queryType'].'",travelType="'.$queryData['travelType'].'",seasonType="'.$queryData['seasonType'].'",seasonYear="'.$queryData['seasonYear'].'",additionalInfo="'.addslashes($queryData['additionalInfo']).'",groupName="'.addslashes($queryData['groupName']).'",groupCode="'.addslashes($queryData['groupCode']).'",preferredLang="'.addslashes($queryData['preferredLang']).'",nationality="'.$queryData['nationality'].'",marketType="'.$queryData['marketType'].'",sglRoom="'.addslashes($queryData['sglRoom']).'",dblRoom="'.addslashes($queryData['dblRoom']).'",tplRoom="'.addslashes($queryData['tplRoom']).'",twinRoom="'.addslashes($queryData['twinRoom']).'",cwbRoom="'.$queryData['cwbRoom'].'",cnbRoom="'.$queryData['cnbRoom'].'",extraNoofBed="'.$queryData['extraNoofBed'].'",vehicleId="'.$queryData['vehicleId'].'",departureDest="'.$queryData['departureDest'].'",salesPersonId="'.$queryData['salesPersonId'].'",salesassignTo="'.$queryData['salesassignTo'].'",seriesCode="'.$queryData['seriesCode'].'",FDCode="'.$queryData['FDCode'].'",packageSupplier="'.$queryData['packageSupplier'].'",packageCode="'.$queryData['packageCode'].'",subName="'.$queryData['subName'].'",expectedSales="'.$queryData['expectedSales'].'",moduleType="'.$queryData['moduleType'].'",sixNoofBedRoom="'.$queryData['sixNoofBedRoom'].'",eightNoofBedRoom="'.$queryData['eightNoofBedRoom'].'",tenNoofBedRoom="'.$queryData['tenNoofBedRoom'].'",teenNoofRoom="'.$queryData['teenNoofRoom'].'",quadNoofRoom="'.$queryData['quadNoofRoom'].'",childAge="'.$queryData['childAge'].'",financeYear="'.$financeYear.'",packageId="'.$queryData['packageId'].'",childAge="'.$queryData['childAge'].'",parentQueryId="'.$queryData['id'].'",isDuplicate="Yes"';

		$where='id="'.$newqueryId.'"';
		$update = updatelisting(_QUERY_MASTER_,$qnamevalue,$where);
		// end query updation
 
		// add quotation 
		$q_token = mt_rand(10000000, 99999999); 

		$namevalue='clientType="'.$quotationData['clientType'].'",queryId="'.$newqueryId.'",tcs="'.$quotationData['tcs'].'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$quotationData['adult'].'",child="'.$quotationData['child'].'",night="'.$quotationData['night'].'",rooms="'.$quotationData['rooms'].'",infant="'.$quotationData['infant'].'",sglRoom="'.$quotationData['sglRoom'].'",dblRoom="'.$quotationData['dblRoom'].'",twinRoom="'.$quotationData['twinRoom'].'",tplRoom="'.$quotationData['tplRoom'].'",childwithNoofBed="'.$quotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$quotationData['childwithoutNoofBed'].'",extraNoofBed="'.$quotationData['extraNoofBed'].'",sixNoofBedRoom="'.$quotationData['sixNoofBedRoom'].'",eightNoofBedRoom="'.$quotationData['eightNoofBedRoom'].'",tenNoofBedRoom="'.$quotationData['tenNoofBedRoom'].'",quadNoofRoom="'.$quotationData['quadNoofRoom'].'",teenNoofRoom="'.$quotationData['teenNoofRoom'].'",totalpax="'.$quotationData['totalpax'].'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",deletestatus="'.$quotationData['deletestatus'].'",quotationId="'.$quotationId.'",starRating="'.$quotationData['starRating'].'",totalAmount="'.$quotationData['totalAmount'].'",totalquotCostWithMarkup="'.$quotationData['totalquotCostWithMarkup'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'",inclusion="'.addslashes($quotationData['inclusion']).'",exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.$quotationData['isInc_exc'].'",quotationNo="'.$quotationData['quotationNo'].'",generateNo="'.$quotationData['generateNo'].'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",languageId="'.$quotationData['languageId'].'",deletestatusDuplicate="'.$quotationData['deletestatusDuplicate'].'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'",salesPersonId="'.$quotationData['salesPersonId'].'",parentQuotationId="'.$quotationData['id'].'"';
		
		$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);

		$esQ="";
		$esQ=GetPageRecord('*','contactsMaster',' 1 and queryId2="'.$oldqueryId.'" and status=1');
		if(mysqli_num_rows($esQ) > 0){
			while($guestListData=mysqli_fetch_array($esQ)){

				$guestListQuery = '';  
				$guestListQuery ='contacttitleId="'.$guestListData['contacttitleId'].'",queryId2="'.$newqueryId.'",agentName="'.$guestListData['agentName'].'",referenceNo="",queryId="'.makeQueryId($newqueryId).'",tourId="",firstName="'.$guestListData['firstName'].'",middleName="'.$guestListData['middleName'].'",lastName="'.$guestListData['lastName'].'",gender="'.$guestListData['gender'].'", designation="'.$guestListData['designation'].'",birthPlace="'.$guestListData['birthPlace'].'",birthDate="'.$guestListData['birthDate'].'",guestAge="'.$guestListData['guestAge'].'",leadpaxstatus="'.$guestListData['leadpaxstatus'].'",anniversaryDate="'.$guestListData['anniversaryDate'].'",marketType="'.$guestListData['marketType'].'",countryId="'.$guestListData['countryId'].'",stateId="'.$guestListData['stateId'].'",cityId="'.$guestListData['cityId'].'",pinzip="'.$guestListData['pinzip'].'",assignTo="'.$guestListData['assignTo'].'",address1="'.$guestListData['address1'].'",address2="'.$guestListData['address2'].'",address3="'.$guestListData['address3'].'",modifyBy="'.$guestListData['modifyBy'].'",modifyDate="'.$guestListData['modifyDate'].'",pinCode="'.$guestListData['pinCode'].'",facebook="'.$guestListData['facebook'].'",Instagram="'.$guestListData['Instagram'].'",twitter="'.$guestListData['twitter'].'",linkedIn="'.$guestListData['linkedIn'].'",SkypeId="'.$guestListData['SkypeId'].'",MSNId="'.$guestListData['MSNId'].'",nationality="'.$guestListData['nationality'].'",familyCode="'.$guestListData['familyCode'].'",tourType="'.$guestListData['tourType'].'",familyRelation="'.$guestListData['familyRelation'].'",mealPreference="'.$guestListData['mealPreference'].'",physicalCondition="'.$guestListData['physicalCondition'].'",holyDayPacId="'.$guestListData['holyDayPacId'].'",preAccomodationMaster="'.$guestListData['preAccomodationMaster'].'",seatPreference="'.$guestListData['seatPreference'].'",mobilePin="'.$guestListData['mobilePin'].'",contactType="'.$guestListData['contactType'].'",corporateId="'.$guestListData['corporateId'].'",gradeId="'.$guestListData['gradeId'].'",designationName="'.$guestListData['designationName'].'",CovidVaccin="'.$guestListData['CovidVaccin'].'",Newsletter="'.$guestListData['Newsletter'].'",emergencyName="'.$guestListData['emergencyName'].'",emergencyRelation="'.$guestListData['emergencyRelation'].'",emergencyContact="'.$guestListData['emergencyContact'].'",remark1="'.$guestListData['remark1'].'",remark2="'.$guestListData['remark2'].'",remark3="'.$guestListData['remark3'].'",status="'.$guestListData['status'].'"';
				
				addlistinggetlastid('contactsMaster',$guestListQuery);
			}
		}
		// duplicate pax slab lists
		$b='';
		$b=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationData['id'].'" order by fromRange asc');
		if(mysqli_num_rows($b)>0){
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';  
				$modevalue ='quotationId="'.$lastQuotationId.'", fromRange="'.$transferRes['fromRange'].'", toRange="'.$transferRes['toRange'].'",localEscort="'.$transferRes['localEscort'].'", foreignEscort="'.$transferRes['foreignEscort'].'", dividingFactor="'.$transferRes['dividingFactor'].'", status="'.$transferRes['status'].'", deletestatus="'.$transferRes['deletestatus'].'", dateAdded="'.$transferRes['dateAdded'].'", modifyDate="'.$transferRes['modifyDate'].'", modifyBy="'.$transferRes['modifyBy'].'",dividingFactorC="'.$transferRes['dividingFactorC'].'", DF_SGL="'.$transferRes['DF_SGL'].'", DF_DBL="'.$transferRes['DF_DBL'].'", DF_TWN="'.$transferRes['DF_TWN'].'", DF_TPL="'.$transferRes['DF_TPL'].'", DF_QUAD="'.$transferRes['DF_QUAD'].'", DF_SIX="'.$transferRes['DF_SIX'].'", DF_EIGHT="'.$transferRes['DF_EIGHT'].'", DF_TEN="'.$transferRes['DF_TEN'].'", DF_ABED="'.$transferRes['DF_ABED'].'", DF_CBED="'.$transferRes['DF_CBED'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",sglRoom="'.$transferRes['sglRoom'].'",dblRoom="'.$transferRes['dblRoom'].'",twinRoom="'.$transferRes['twinRoom'].'",tplRoom="'.$transferRes['tplRoom'].'",quadNoofRoom="'.$transferRes['quadNoofRoom'].'",sixNoofBedRoom="'.$transferRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$transferRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$transferRes['tenNoofBedRoom'].'",teenNoofRoom="'.$transferRes['teenNoofRoom'].'",extraNoofBed="'.$transferRes['extraNoofBed'].'",childwithNoofBed="'.$transferRes['childwithNoofBed'].'",childwithoutNoofBed="'.$transferRes['childwithoutNoofBed'].'"';
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

		$olddaysrs = GetPageRecord('*','newQuotationDays',' queryId="'.$oldqueryId.'" and quotationId in ( select id from quotationMaster where queryId="'.$oldqueryId.'" and status=1 and isTourEx=0 ) and addstatus=0 order by srdate asc');
		if(mysqli_num_rows($olddaysrs)>0){ 
	    while($QueryDaysData = mysqli_fetch_array($olddaysrs)){

			$srdate = $QueryDaysData['srdate']; 

			$namevalue1 = 'cityId="'.$QueryDaysData['cityId'].'",packageId="'.$newqueryId.'",queryId="'.$newqueryId.'",srn="'.$QueryDaysData['srn'].'",srdate="'.$srdate.'"';
			addlisting('packageQueryDays',$namevalue1);

			$namevalue2 ='queryId="'.$newqueryId.'",cityId="'.$QueryDaysData['cityId'].'",quotationId="'.$lastQuotationId.'",srdate="'.$srdate.'",title="'.$QueryDaysData['title'].'",description="'.$QueryDaysData['description'].'"';
			$adddays = addlistinggetlastid('newQuotationDays',$namevalue2);
			
			$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
			while($HotelRes=mysqli_fetch_array($b)){
				// normal and escort
				$namevalue ='';
				$addHotel ='';
				$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$newqueryId.'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",hotelTypeId="'.$HotelRes['hotelTypeId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",currencyValue="'.$HotelRes['currencyValue'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",quadoccupancy="'.$HotelRes['quadoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",taxType="'.$HotelRes['taxType'].'",markupType="'.$HotelRes['markupType'].'",sglMarkup="'.$HotelRes['sglMarkup'].'",dblMarkup="'.$HotelRes['dblMarkup'].'",twinMarkup="'.$HotelRes['twinMarkup'].'",tplMarkup="'.$HotelRes['tplMarkup'].'",cwbMarkup="'.$HotelRes['cwbMarkup'].'",quadMarkup="'.$HotelRes['quadMarkup'].'",sixMarkup="'.$HotelRes['sixMarkup'].'",eightMarkup="'.$HotelRes['eightMarkup'].'",tenMarkup="'.$HotelRes['tenMarkup'].'",teenMarkup="'.$HotelRes['teenMarkup'].'",cnbMarkup="'.$HotelRes['cnbMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",mealMarkup="'.$HotelRes['mealMarkup'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",harrivalon="'.$HotelRes['harrivalon'].'",hfrom="'.$HotelRes['hfrom'].'",hbyfrom="'.$HotelRes['hbyfrom'].'",hatfrom="'.$HotelRes['hatfrom'].'",hdepartureon="'.$HotelRes['hdepartureon'].'",hto="'.$HotelRes['hto'].'",hbyto="'.$HotelRes['hbyto'].'",hatto="'.$HotelRes['hatto'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",rand_color="'.$HotelRes['rand_color'].'",escortHotelStatus="'.$HotelRes['escortHotelStatus'].'",breakfast="'.$HotelRes['breakfast'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",isChildBreakfast="'.$HotelRes['isChildBreakfast'].'",isChildDinner="'.$HotelRes['isChildDinner'].'",isChildLunch="'.$HotelRes['isChildLunch'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",singleNoofRoom="'.$HotelRes['singleNoofRoom'].'",doubleNoofRoom="'.$HotelRes['doubleNoofRoom'].'",twinNoofRoom="'.$HotelRes['twinNoofRoom'].'",tripleNoofRoom="'.$HotelRes['tripleNoofRoom'].'",childwithNoofBed="'.$HotelRes['childwithNoofBed'].'",childwithoutNoofBed="'.$HotelRes['childwithoutNoofBed'].'",extraNoofBed="'.$HotelRes['extraNoofBed'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isEarlyCheckin="'.$HotelRes['isEarlyCheckin'].'",sixNoofBedRoom="'.$HotelRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$HotelRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$HotelRes['tenNoofBedRoom'].'",quadNoofRoom="'.$HotelRes['quadNoofRoom'].'",teenNoofRoom="'.$HotelRes['teenNoofRoom'].'",sixBedRoom="'.$HotelRes['sixBedRoom'].'",eightBedRoom="'.$HotelRes['eightBedRoom'].'",tenBedRoom="'.$HotelRes['tenBedRoom'].'",quadRoom="'.$HotelRes['quadRoom'].'",teenRoom="'.$HotelRes['teenRoom'].'",childBreakfast="'.$HotelRes['childBreakfast'].'",childLunch="'.$HotelRes['childLunch'].'",childDinner="'.$HotelRes['childDinner'].'",isSelectedFinal=1';
				$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue); 

				$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
				if(mysqli_num_rows($check_h)==0){
					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$HotelRes['fromDate'].'",endDate="'.$HotelRes['fromDate'].'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
				}

				// supplement
				$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
				while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
					$namevalue ='';
					$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$newqueryId.'",quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",hotelTypeId="'.$hotelSuppD['hotelTypeId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",currencyValue="'.$hotelSuppD['currencyValue'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",quadoccupancy="'.$hotelSuppD['quadoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'", taxType="'.$hotelSuppD['taxType'].'",markupType="'.$hotelSuppD['markupType'].'",sglMarkup="'.$hotelSuppD['sglMarkup'].'",dblMarkup="'.$hotelSuppD['dblMarkup'].'",twinMarkup="'.$hotelSuppD['twinMarkup'].'",tplMarkup="'.$hotelSuppD['tplMarkup'].'",cwbMarkup="'.$hotelSuppD['cwbMarkup'].'",quadMarkup="'.$hotelSuppD['quadMarkup'].'",sixMarkup="'.$hotelSuppD['sixMarkup'].'",eightMarkup="'.$hotelSuppD['eightMarkup'].'",tenMarkup="'.$hotelSuppD['tenMarkup'].'",teenMarkup="'.$hotelSuppD['teenMarkup'].'",cnbMarkup="'.$hotelSuppD['cnbMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",mealMarkup="'.$hotelSuppD['mealMarkup'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",taxType="'.$hotelSuppD['taxType'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isEarlyCheckin="'.$hotelSuppD['isEarlyCheckin'].'",sixBedRoom="'.$hotelSuppD['sixBedRoom'].'",eightBedRoom="'.$hotelSuppD['eightBedRoom'].'",tenBedRoom="'.$hotelSuppD['tenBedRoom'].'",quadRoom="'.$hotelSuppD['quadRoom'].'",teenRoom="'.$hotelSuppD['teenRoom'].'",childBreakfast="'.$hotelSuppD['childBreakfast'].'",childDinner="'.$hotelSuppD['childDinner'].'",childLunch="'.$hotelSuppD['childLunch'].'",sixNoofBedRoom="'.$hotelSuppD['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelSuppD['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelSuppD['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelSuppD['quadNoofRoom'].'",teenNoofRoom="'.$hotelSuppD['teenNoofRoom'].'",isChildBreakfast="'.$hotelSuppD['isChildBreakfast'].'",isChildLunch="'.$hotelSuppD['isChildLunch'].'",isChildDinner="'.$hotelSuppD['isChildDinner'].'"'; //hotelQuoteId
					$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

					$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$adddays.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
					if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
						$namevalue ='';
						$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srdate.'",endDate="'.$srdate.'"';
						addlistinggetlastid('quotationItinerary',$namevalue);
					}

				}

				
				$qhaQuery=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$HotelRes['id'].'"  and quotationId="'.$QueryDaysData['quotationId'].'" order by id asc');
				while($qhAData=mysqli_fetch_array($qhaQuery)){

					$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",hotelId="'.$qhAData['hotelId'].'",additionalCost="'.$qhAData['additionalCost'].'",name="'.$qhAData['name'].'",hotelQuotId="'.$addHotel.'",additionalId="'.$qhAData['additionalId'].'",costType="'.$qhAData['costType'].'",queryId="'.$newqueryId.'",destinationId="'.$qhAData['destinationId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",currencyId="'.$qhAData['currencyId'].'",currencyValue="'.$qhAData['currencyValue'].'",rateId="'.$qhAData['rateId'].'"';
					addlistinggetlastid('quotationHotelAdditionalMaster',$namevalue);
				}
			}

			$b='';
			$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where (serviceType="transfer" or serviceType="transportation") order by serviceId asc) order by id asc');
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
					$transfernamevalue ='currencyValue="'.$transferRes['currencyValue'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",queryId="'.$newqueryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$adddays.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",isGuestType="'.$transferRes['isGuestType'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",totalPax="'.$totalPaxId.'"';

					$transQuoteId = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
					$c1="";
					$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
					if(mysqli_num_rows($c1)>0){
						$transferTimelineData=mysqli_fetch_array($c1);
	 
						$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$transQuoteId.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
						$hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue); 
					}

					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$transQuoteId.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$srdate.'",endDate="'.$srdate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);

				}
			}

			$b=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="guide" order by serviceId asc) and isGuestType=1 order by id asc');
			while($transferRes=mysqli_fetch_array($b)){

				$bb='';
				$bb=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and  id="'.$transferRes['slabId'].'"');
				if(mysqli_num_rows($bb)>0){
					$paxSlabData=mysqli_fetch_array($bb);
					$bb2='';
					$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and  fromRange="'.$paxSlabData['fromRange'].'" and  toRange="'.$paxSlabData['toRange'].'"  and  dividingFactor="'.$paxSlabData['dividingFactor'].'"  and  status="'.$paxSlabData['status'].'" ');
					$paxSlabData2=mysqli_fetch_array($bb2);
					$totalPaxId = $paxSlabData2['id'];
				}
				
				$addHotel ='';
				$transfernamevalue ='currencyValue="'.$transferRes['currencyValue'].'",guideId="'.$transferRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferRes['price'].'",guideName="'.$transferRes['guideName'].'",queryId="'.$newqueryId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferRes['srn'].'",destinationId="'.$transferRes['destinationId'].'",rules="'.$transferRes['rules'].'",category="'.$transferRes['category'].'",subcategory="'.$transferRes['subcategory'].'",totalDays="'.$transferRes['totalDays'].'",perDaycost="'.$transferRes['perDaycost'].'",serviceType="'.$transferRes['serviceType'].'",currencyId="'.$transferRes['currencyId'].'",guideQuoteId="'.$transferRes['guideQuoteId'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",paxRange="'.$transferRes['paxRange'].'",dayType="'.$transferRes['dayType'].'",dayId="'.$adddays.'"';

				$addHotel = addlistinggetlastid('quotationGuideMaster',$transfernamevalue); 
				
				$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'"  and guideQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
				while($transferSuppRes=mysqli_fetch_array($bSupp)){
					$suppGuidevalue ='currencyValue="'.$transferSuppRes['currencyValue'].'",guideId="'.$transferSuppRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$newqueryId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",guideQuoteId="'.$addHotel.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$adddays.'"';
		
					$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
				
				}

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}

			$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				// tarifId

				$bb='';
				$bb=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and  id="'.$transferRes['slabId'].'"');
				if(mysqli_num_rows($bb)>0){
					$paxSlabData=mysqli_fetch_array($bb);
					$bb2='';
					$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and  fromRange="'.$paxSlabData['fromRange'].'" and  toRange="'.$paxSlabData['toRange'].'"  and  dividingFactor="'.$paxSlabData['dividingFactor'].'"  and  status="'.$paxSlabData['status'].'" ');
					$paxSlabData2=mysqli_fetch_array($bb2);
					$slabId = $paxSlabData2['id'];
				}

				$addHotel = '';
				$transfernamevalue ='currencyValue="'.$transferRes['currencyValue'].'",otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$newqueryId.'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleCost="'.$transferRes['vehicleCost'].'",repCost="'.$transferRes['repCost'].'",slabId="'.$transferRes['slabId'].'",transferType="'.$transferRes['transferType'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",tarifType="'.$transferRes['tarifType'].'",maxpax="'.$transferRes['maxpax'].'",nationality="'.$transferRes['nationality'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",remark="'.$transferRes['remark'].'",dayId="'.$adddays.'"';
				$addHotel = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$transfernamevalue);
				
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="activity",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationActivityTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1); 
					 $namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
					 $entraceTimeId = addlistinggetlastid('quotationActivityTimelineDetails',$namevalue);

				}
			}

			$b=GetPageRecord('*','quotationEnrouteMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="enroute" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel ='';

				$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",currencyValue="'.$transferRes['currencyValue'].'",queryId="'.$newqueryId.'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",dayId="'.$adddays.'",currencyId="'.$transferRes['currencyId'].'"';
				$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}

			$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){


				$addHotel = '';
				$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",currencyValue="'.$transferRes['currencyValue'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferType="'.$transferRes['transferType'].'",currencyId="'.$transferRes['currencyId'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",repCost="'.$transferRes['repCost'].'",queryId="'.$newqueryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",startDayDate="'.$transferRes['startDayDate'].'",endDayDate="'.$transferRes['endDayDate'].'",noOfVehicles="'.$transferRes['noOfVehicle'].'",dayId="'.$adddays.'"';
 
				$addHotel = addlistinggetlastid('quotationEntranceMaster',$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="entrance",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$adddays.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
					 $entraceTimeId = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);

				}
			}
			
			$b=GetPageRecord('*','quotationFerryMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="ferry" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){

				$addHotel = '';
				$ferrynamevalue ='ferryNameId="'.$transferRes['ferryNameId'].'",serviceid="'.$transferRes['serviceid'].'",quotationId="'.$lastQuotationId.'",currencyValue="'.$transferRes['currencyValue'].'",destinationId="'.$transferRes['destinationId'].'",todestination="'.$transferRes['todestination'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",ferryClass="'.$transferRes['ferryClass'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",ferryCost="'.$transferRes['ferryCost'].'",processingfee="'.$transferRes['processingfee'].'",miscCost="'.$transferRes['miscCost'].'",currencyId="'.$transferRes['currencyId'].'",pickupTime="'.$transferRes['pickupTime'].'",dropTime="'.$transferRes['dropTime'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",remark="'.$transferRes['remark'].'",rateId="'.$transferRes['rateId'].'",timeId="'.$transferRes['timeId'].'",queryId="'.$newqueryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$adddays.'"';
				$addHotel = addlistinggetlastid('quotationFerryMaster',$ferrynamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="ferry",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
				
			}
			
			$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",currencyValue="'.$transferRes['currencyValue'].'",quotationId="'.$lastQuotationId.'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",dmcId="'.$transferRes['dmcId'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srdate.'",currencyId="'.$transferRes['currencyId'].'",toDate="'.$srdate.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",queryId="'.$newqueryId.'",dayId="'.$adddays.'"';
				$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}

			$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$srdate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srdate.'",adultCost="'.$transferRes['adultCost'].'",currencyValue="'.$transferRes['currencyValue'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$newqueryId.'",dayId="'.$adddays.'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",supplierId="'.$transferRes['supplierId'].'",dmcId="'.$transferRes['dmcId'].'",taxType="'.$transferRes['taxType'].'",currencyId="'.$transferRes['currencyId'].'",isGuestType="'.$transferRes['isGuestType'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",totalAdult="'.$transferRes['adult'].'",totalChild="'.$transferRes['child'].'",remark="'.$transferRes['remark'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
	 
			$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$srdate.'",quotationId="'.$lastQuotationId.'",currencyValue="'.$transferRes['currencyValue'].'",toDate="'.$srdate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",trainId="'.$transferRes['trainId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",currencyId="'.$transferRes['currencyId'].'",queryId="'.$newqueryId.'",dayId="'.$adddays.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",supplierId="'.$transferRes['supplierId'].'",dmcId="'.$transferRes['dmcId'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="train",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}


			$b='';
			$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
			if(mysqli_num_rows($b)>0){

				while($transferRes=mysqli_fetch_array($b)){
					$addHotel = '';
					$transfernamevalue ='name="'.$transferRes['name'].'",costType="'.$transferRes['costType'].'",currencyValue="'.$transferRes['currencyValue'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$newqueryId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",currencyId="'.$transferRes['currencyId'].'",additionalId="'.$transferRes['additionalId'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$adddays.'"';
					$addHotel = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$transfernamevalue);

					$namevalue ='';
					$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="additional",startDate="'.$srdate.'",endDate="'.$srdate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);

				}
			}

			$b='';
			$b=GetPageRecord('*','quotationModeMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" order by id asc');
			if(mysqli_num_rows($b)>0){
				$transferRes=mysqli_fetch_array($b);
				$addHotel = '';
				$modevalue ='name="'.$transferRes['name'].'",dayId="'.$adddays.'",queryId="'.$newqueryId.'",quotationId="'.$lastQuotationId.'"';
				$modeId = addlistinggetlastid('quotationModeMaster',$modevalue);

			}
		}

		$b='';
		$b=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationId.'" order by id asc');
		if(mysqli_num_rows($b)>0){
			$transferRes=mysqli_fetch_array($b);
			$addHotel = '';
			$modevalue='markupCost="'.$transferRes['markupCost'].'", curren="'.$transferRes['curren'].'", quotationId="'.$lastQuotationId.'", hotel="'.$transferRes['hotel'].'",package="'.$transferRes['package'].'",guide="'.$transferRes['guide'].'",activity="'.$transferRes['activity'].'",entrance="'.$transferRes['entrance'].'",transfer="'.$transferRes['transfer'].'",ferry="'.$transferRes['ferry'].'",train="'.$transferRes['train'].'",flight="'.$transferRes['flight'].'",restaurant="'.$transferRes['restaurant'].'",visa="'.$transferRes['visa'].'",passport="'.$transferRes['passport'].'",insurance="'.$transferRes['insurance'].'",other="'.$transferRes['other'].'",packageMarkupType="'.$transferRes['packageMarkupType'].'",hotelMarkupType="'.$transferRes['hotelMarkupType'].'",guideMarkupType="'.$transferRes['guideMarkupType'].'",activityMarkupType="'.$transferRes['activityMarkupType'].'",entranceMarkupType="'.$transferRes['entranceMarkupType'].'",transferMarkupType="'.$transferRes['transferMarkupType'].'",ferryMarkupType="'.$transferRes['ferryMarkupType'].'",trainMarkupType="'.$transferRes['trainMarkupType'].'",flightMarkupType="'.$transferRes['flightMarkupType'].'",restaurantMarkupType="'.$transferRes['restaurantMarkupType'].'",visaMarkupType="'.$transferRes['visaMarkupType'].'",passportMarkupType="'.$transferRes['passportMarkupType'].'",insuranceMarkupType="'.$transferRes['insuranceMarkupType'].'",otherMarkupType="'.$transferRes['otherMarkupType'].'",status="'.$transferRes['status'].'"';
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

		}

		if($lastQuotationId>0){
			$whereQ='id="'.$newqueryId.'"';
			$updateStatus = updatelisting(_QUERY_MASTER_,'queryStatus="5"',$whereQ);
		}

		}

	?>
	<script>
	window.location="<?php echo $fullurl; ?>showpage.crm?module=query&edit=yes&id=<?php echo encode($newqueryId) ?>";
	</script>
	<?php
}
?>

