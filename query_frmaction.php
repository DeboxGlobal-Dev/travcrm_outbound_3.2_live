<?php
ob_start();
include "inc.php";
include "config/logincheck.php";
include 'smart_resize_image.function.php';
// autocrop the
?>
<script src="js/jquery-1.11.3.min.js"></script>
<?php 

if(trim($_REQUEST['action'])=='saveQueryDay' && trim($_REQUEST['queryId'])>0 && trim($_REQUEST['cityId']) > 0 && trim($_REQUEST['dayId']) > 0){

  	$queryId=trim($_REQUEST['queryId']);
	$cityId=trim($_REQUEST['cityId']);
	$dayId=trim($_REQUEST['dayId']);


	$where='id="'.trim($dayId).'" and queryId = "'.trim($queryId).'"';
	$namevalue ='cityId="'.$cityId.'"';
	$update = updatelisting('packageQueryDays',$namevalue,$where);
	if($update == 'yes'){
	?>
	<script>
		// $('#cityId<?php echo $dayId; ?>').css('border-color','#ccc');
		$('div[data-value="<?php echo $cityId; ?>"]').parent().css('border-color','#64f705');
	</script>
	<?php
	}
}

if($_REQUEST['action']=="getDestinationCities" && $_REQUEST['queryId']!='' && $_REQUEST['CountryId']!=''){
	
	if($_REQUEST['CountryId']=='All'){
		$coutryId='';
	}else{
		$coutryId = 'and countryId="'.$_REQUEST['CountryId'].'"';
	}
	?>
	<option value="">Select City</option>
	<?php 
	$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 '.$coutryId.' order by name asc'); 
	while($resListing=mysqli_fetch_array($rs)){  
	?>
	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$cityId){ ?>selected="selected"<?php } ?> style="color:#423e3e;"><?php echo strip($resListing['name']); ?></option><?php } ?>
		
	<?php
}

if(trim($_REQUEST['action'])=='saveTourDay' && trim($_REQUEST['queryId'])>0 && trim($_REQUEST['cityId']) > 0 && trim($_REQUEST['dayId']) > 0){

  	$queryId=trim($_REQUEST['queryId']);
	$cityId=trim($_REQUEST['cityId']);
	$dayId=trim($_REQUEST['dayId']);


	$where='id="'.trim($dayId).'" and queryId = "'.trim($queryId).'"';
	$namevalue ='cityId="'.$cityId.'"';
	$update = updatelisting('newQuotationDays',$namevalue,$where);
	if($update == 'yes'){
	?>
	<script>
		$('#cityId<?php echo $dayId; ?>').css('border-color','#ccc');
	</script>
	<?php
	}
}


if(trim($_REQUEST['action'])=='deleteQueryDay' && trim($_REQUEST['queryId'])>0 && trim($_REQUEST['dayId']) > 0){

  	$queryId=trim($_REQUEST['queryId']);
 	$dayId=trim($_REQUEST['dayId']);


	$where=' id="'.trim($dayId).'" and queryId = "'.trim($queryId).'" ';
	$sql_del = "delete from packageQueryDays where id='".trim($dayId)."' and queryId = '".trim($queryId)."' ";
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
	echo $status = mysqli_affected_rows(db());
	if($status > 0){
	?>
	<script>
		$('.row<?php echo $dayId; ?>').remove();
	</script>
	<?php
	}
}
if(trim($_REQUEST['action'])=='deleteTourDay' && trim($_REQUEST['queryId'])>0 && trim($_REQUEST['dayId']) > 0){

  	$queryId=trim($_REQUEST['queryId']);
 	$dayId=trim($_REQUEST['dayId']);


	$where=' id="'.trim($dayId).'" and queryId = "'.trim($queryId).'" ';
	$sql_del = "delete from newQuotationDays where id='".trim($dayId)."' and queryId = '".trim($queryId)."' ";
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
	echo $status = mysqli_affected_rows(db());
	if($status > 0){
	?>
	<script>
		$('.row<?php echo $dayId; ?>').remove();
	</script>
	<?php
	}
}


if(trim($_REQUEST['action'])=='tourDateChangeAction' && trim($_REQUEST['quotationId'])!='' && trim($_REQUEST['newTourDate'])!=''){

 	$newTourDate = date('Y-m-d',strtotime($_REQUEST['newTourDate']));
	$dayWise=trim($_REQUEST['newDayWise']);
 	$reservation=trim($_REQUEST['reservation']);
	$voucher=trim($_REQUEST['voucher']);
	$quotationId=decode($_REQUEST['quotationId']);

	$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$quotationId.'');
	$quotationData=mysqli_fetch_array($rs1);
 	$night = $quotationData['night'];

	$fromDate = $newTourDate;
	$toDate = date ("Y-m-d", strtotime("+".$night." days", strtotime($fromDate)));

	if(trim($quotationData['id']) > 0){

		$where='id='.trim($quotationData['id']).'';
		$namevalue ='fromDate="'.$fromDate.'",toDate="'.$toDate.'",dayWise="'.$dayWise.'",isRegenerated=1';
		$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);
		if($update == 'yes'){
		?>
		<script>
			// parent.setupbox('showpage.crm?module=quotations&view=yes&id=<?php echo $_REQUEST['quotationId']; ?>');
			parent.query_alertbox('action=askToRegenrateQuotation&quotationId=<?php echo ($_REQUEST['quotationId']); ?>','600px','auto');
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
		</script>
		<?php
		}
	}
}



if(trim($_REQUEST['action'])=='askToRegenrateQuotation' && trim($_REQUEST['quotationId'])!=''){

	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.decode($_REQUEST['quotationId']).'"  ');
	$quotationData=mysqli_fetch_array($rsp);

	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];


	$rsp1=GetPageRecord('generateNo',_QUOTATION_MASTER_,' queryId="'.clean($queryId).'" and quotationNo="'.$quotationData['quotationNo'].'" order by generateNo desc');
	$generateNoD=mysqli_fetch_array($rsp1);
	if($generateNoD['generateNo']!=0){
		$generateNo = $generateNoD['generateNo']+1;
	}else {
			$generateNo = 1;
	}

	$quotationNo = $quotationData['quotationNo'];

	//duplicate quotation with all servicess markup
	//------------------------------------------------------------------
	 $namevalue ='clientType="'.$quotationData['clientType'].'",queryId="'.$queryId.'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$quotationData['adult'].'",child="'.$quotationData['child'].'",infant="'.$quotationData['infant'].'",sglRoom="'.$quotationData['sglRoom'].'",dblRoom="'.$quotationData['dblRoom'].'",tplRoom="'.$quotationData['tplRoom'].'",twinRoom="'.$quotationData['twinRoom'].'",childwithNoofBed="'.$quotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$quotationData['childwithoutNoofBed'].'",extraNoofBed="'.$quotationData['extraNoofBed'].'",night="'.$quotationData['night'].'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",deletestatus="'.$quotationData['deletestatus'].'",quotationId="'.$quotationData['quotationId'].'",starRating="'.$quotationData['starRating'].'",status=0,viewQuotation="'.$quotationData['viewQuotation'].'",totalAmount="'.$quotationData['totalAmount'].'",totalquotCostWithMarkup="'.$quotationData['totalquotCostWithMarkup'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",hotelType="'.$quotationData['hotelType'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'", inclusion="'.addslashes($quotationData['inclusion']).'",serviceupgradationText="'.addslashes($quotationData['serviceupgradationText']).'",optionaltourText="'.addslashes($quotationData['optionaltourText']).'",remarks="'.addslashes($quotationData['remarks']).'",paymentpolicy="'.addslashes($quotationData['paymentpolicy']).'",fitGitId="'.addslashes($quotationData['fitGitId']).'", exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.addslashes($quotationData['isInc_exc']).'", quotationNo="'.$quotationNo.'", generateNo="'.$generateNo.'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'", overviewText="'.addslashes($quotationData['overviewText']).'", highlightsText="'.addslashes($quotationData['highlightsText']).'", tncText="'.addslashes($quotationData['tncText']).'", specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",saveQuotaiton="'.$quotationData['saveQuotaiton'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",isRegenerated=0,discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",languageId="'.$quotationData['languageId'].'",deletestatusDuplicate="'.$quotationData['deletestatusDuplicate'].'",propIMGNum3="'.$quotationData['propIMGNum3'].'",propIMGNum4="'.$quotationData['propIMGNum4'].'",propIMGNum6="'.$quotationData['propIMGNum6'].'",onlyTFS="'.$quotationData['onlyTFS'].'",visaRequired="'.$quotationData['visaRequired'].'",flightRequired="'.$quotationData['flightRequired'].'",transferRequired="'.$quotationData['transferRequired'].'",passportRequired="'.$quotationData['passportRequired'].'",insuranceRequired="'.$quotationData['insuranceRequired'].'",visaCostType="'.$quotationData['visaCostType'].'",passportCostType="'.$quotationData['passportCostType'].'",insuranceCostType="'.$quotationData['insuranceCostType'].'",dayWise="'.$quotationData['dayWise'].'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'",packageSupplier="'.$quotationData['packageSupplier'].'",tcs="'.$quotationData['tcs'].'"';
	$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);

	// update previous quotaion tourDate with his old date /
	$QueryDaysQuery1=GetPageRecord('min(srdate) as fromDate, max(srdate) as toDate ','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus = 0 ');
	$QueryDaysData1=mysqli_fetch_array($QueryDaysQuery1);

	$where='id='.trim($quotationId).'';
	$namevalue ='fromDate="'.$QueryDaysData1['fromDate'].'",toDate="'.$QueryDaysData1['toDate'].'",isRegenerated=0';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);

	//regenerate with new date
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);

	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];
	// use above var

	if($quotationData['flightRequired']==2){
		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isFlightTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)){
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$transferRes['toDate'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",totalAdultCost="'.$transferRes['totalAdultCost'].'",adultTax="'.$transferRes['adultTax'].'",totalChildCost="'.$transferRes['totalChildCost'].'",childTax="'.$transferRes['childTax'].'",totalInfantCost="'.$transferRes['totalInfantCost'].'",infantTax="'.$transferRes['infantTax'].'",cancellationPolicy="'.$transferRes['cancellationPolicy'].'",isFlightTaken="'.$transferRes['isFlightTaken'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}
	}
}
		

		// Transfer service Copy
		if($quotationData['transferRequired']==2){
		$b=''; 
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isTransferTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){ 
			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id']; 
				$addHotel = '';

				$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",tariffId="'.$transferRes['tariffId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isTransferTaken="'.$transferRes['isTransferTaken'].'",distance="'.$transferRes['distance'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
		
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}
	}

	// Value Added Services Start
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
	// Value Added Sevices End


	// duplicate pax slab lists
	$b='';
	$b=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" order by fromRange asc');
	if(mysqli_num_rows($b)>0){
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';  
			$modevalue = 'quotationId="'.$lastQuotationId.'", fromRange="'.$transferRes['fromRange'].'", toRange="'.$transferRes['toRange'].'", localEscort="'.$transferRes['localEscort'].'", foreignEscort="'.$transferRes['foreignEscort'].'", dividingFactor="'.$transferRes['dividingFactor'].'", status="'.$transferRes['status'].'", deletestatus="'.$transferRes['deletestatus'].'", dateAdded="'.$transferRes['dateAdded'].'", modifyDate="'.$transferRes['modifyDate'].'", modifyBy="'.$transferRes['modifyBy'].'",dividingFactorC="'.$transferRes['dividingFactorC'].'", DF_SGL="'.$transferRes['DF_SGL'].'", DF_DBL="'.$transferRes['DF_DBL'].'", DF_TWN="'.$transferRes['DF_TWN'].'", DF_TPL="'.$transferRes['DF_TPL'].'", DF_QUAD="'.$transferRes['DF_QUAD'].'", DF_SIX="'.$transferRes['DF_SIX'].'", DF_EIGHT="'.$transferRes['DF_EIGHT'].'", DF_TEN="'.$transferRes['DF_TEN'].'", DF_ABED="'.$transferRes['DF_ABED'].'", DF_CBED="'.$transferRes['DF_CBED'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",sglRoom="'.$transferRes['sglRoom'].'",dblRoom="'.$transferRes['dblRoom'].'",twinRoom="'.$transferRes['twinRoom'].'",tplRoom="'.$transferRes['tplRoom'].'",quadNoofRoom="'.$transferRes['quadNoofRoom'].'",sixNoofBedRoom="'.$transferRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$transferRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$transferRes['tenNoofBedRoom'].'",teenNoofRoom="'.$transferRes['teenNoofRoom'].'",extraNoofBed="'.$transferRes['extraNoofBed'].'",childwithNoofBed="'.$transferRes['childwithNoofBed'].'",childwithoutNoofBed="'.$transferRes['childwithoutNoofBed'].'"';
			$slabId = addlistinggetlastid('totalPaxSlab',$modevalue);
			
			$esQ="";
			$esQ=GetPageRecord('*','quotationFOCRates',' slabId="'.$transferRes['id'].'" and quotationId="'.$transferRes['quotationId'].'"');
			if(mysqli_num_rows($esQ) > 0){
				while($escortData=mysqli_fetch_array($esQ)){
					//quotation FOC rates should duplicated in quoation regeneration
					$focRatesQuery = '';
					$focRatesQuery ='quotationId="'.$lastQuotationId.'",slabId="'.$slabId.'",sglNORoom="'.$escortData['sglNORoom'].'",dblNORoom="'.$escortData['dblNORoom'].'",tplNORoom="'.$escortData['tplNORoom'].'",focType="'.$escortData['focType'].'",hotelCost="'.$escortData['hotelCost'].'",guideCost="'.$escortData['guideCost'].'",activityCost="'.$escortData['activityCost'].'",entranceCost="'.$escortData['entranceCost'].'",transferCost="'.$escortData['transferCost'].'",trainCost="'.$escortData['trainCost'].'",flightCost="'.$escortData['flightCost'].'",restaurantCost="'.$escortData['restaurantCost'].'",otherCost="'.$escortData['otherCost'].'",hotelCalType="'.$escortData['hotelCalType'].'",guideCalType="'.$escortData['guideCalType'].'",activityCalType="'.$escortData['activityCalType'].'",entranceCalType="'.$escortData['entranceCalType'].'",transferCalType="'.$escortData['transferCalType'].'",trainCalType="'.$escortData['trainCalType'].'",flightCalType="'.$escortData['flightCalType'].'",restaurantCalType="'.$escortData['restaurantCalType'].'",otherCalType="'.$escortData['otherCalType'].'"';
					$focRateId = addlistinggetlastid('quotationFOCRates',$focRatesQuery);
				} 
			}
		}
	}
	
	$day = 0;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){

		$date = date('Y-m-d', strtotime("+".$day." day", strtotime($fromDate)));

		$newDayId='';
		$namevalue =' queryId="'.$QueryDaysData['queryId'].'",cityId="'.$QueryDaysData['cityId'].'",title="'.$QueryDaysData['title'].'",description="'.$QueryDaysData['description'].'",quotationId="'.$lastQuotationId.'",srdate="'.$date.'"';
		$newDayId = addlistinggetlastid('newQuotationDays',$namevalue);

		$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
				while($HotelRes=mysqli_fetch_array($b)){
					// normal and escort
					$namevalue ='';
					$addHotel ='';
				
					$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$date.'",toDate="'.$date.'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$HotelRes['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",hotelTypeId="'.$HotelRes['hotelTypeId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",currencyValue="'.$HotelRes['currencyValue'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomprice="'.$HotelRes['roomprice'].'",noofrooms="'.$HotelRes['noofrooms'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",quadoccupancy="'.$HotelRes['quadoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'", sglMarkup="'.$HotelRes['sglMarkup'].'", dblMarkup="'.$HotelRes['dblMarkup'].'", tplMarkup="'.$HotelRes['tplMarkup'].'", cwbMarkup="'.$HotelRes['cwbMarkup'].'", quadMarkup="'.$HotelRes['quadMarkup'].'", cnbMarkup="'.$HotelRes['cnbMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",mealMarkup="'.$HotelRes['mealMarkup'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",rand_color="'.$HotelRes['rand_color'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",breakfast="'.$HotelRes['breakfast'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",taxType="'.$HotelRes['taxType'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",singleNoofRoom="'.$HotelRes['singleNoofRoom'].'",doubleNoofRoom="'.$HotelRes['doubleNoofRoom'].'",twinNoofRoom="'.$HotelRes['twinNoofRoom'].'",tripleNoofRoom="'.$HotelRes['tripleNoofRoom'].'",extraNoofBed="'.$HotelRes['extraNoofBed'].'",childwithNoofBed="'.$HotelRes['childwithNoofBed'].'",childwithoutNoofBed="'.$HotelRes['childwithoutNoofBed'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isEarlyCheckin="'.$HotelRes['isEarlyCheckin'].'",sixBedRoom="'.$HotelRes['sixBedRoom'].'",eightBedRoom="'.$HotelRes['eightBedRoom'].'",tenBedRoom="'.$HotelRes['tenBedRoom'].'",quadRoom="'.$HotelRes['quadRoom'].'",teenRoom="'.$HotelRes['teenRoom'].'",childBreakfast="'.$HotelRes['childBreakfast'].'",childDinner="'.$HotelRes['childDinner'].'",childLunch="'.$HotelRes['childLunch'].'",sixNoofBedRoom="'.$HotelRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$HotelRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$HotelRes['tenNoofBedRoom'].'",quadNoofRoom="'.$HotelRes['quadNoofRoom'].'",teenNoofRoom="'.$HotelRes['teenNoofRoom'].'",isChildBreakfast="'.$HotelRes['isChildBreakfast'].'",isChildLunch="'.$HotelRes['isChildLunch'].'",isChildDinner="'.$HotelRes['isChildDinner'].'"';
					$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

					$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
					if(mysqli_num_rows($check_h)==0){
						$namevalue ='';
						$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$date.'",endDate="'.$date.'"';
						addlistinggetlastid('quotationItinerary',$namevalue);
					}

					// supplement
					$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
					while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
						$namevalue ='';
						$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$date.'",toDate="'.$date.'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$hotelSuppD['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",hotelTypeId="'.$hotelSuppD['hotelTypeId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",currencyValue="'.$hotelSuppD['currencyValue'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",quadoccupancy="'.$hotelSuppD['quadoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'", sglMarkup="'.$hotelSuppD['sglMarkup'].'", dblMarkup="'.$hotelSuppD['dblMarkup'].'", tplMarkup="'.$hotelSuppD['tplMarkup'].'", cwbMarkup="'.$hotelSuppD['cwbMarkup'].'", quadMarkup="'.$hotelSuppD['quadMarkup'].'", cnbMarkup="'.$hotelSuppD['cnbMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",mealMarkup="'.$hotelSuppD['mealMarkup'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",taxType="'.$hotelSuppD['taxType'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isEarlyCheckin="'.$hotelSuppD['isEarlyCheckin'].'",sixBedRoom="'.$hotelSuppD['sixBedRoom'].'",eightBedRoom="'.$hotelSuppD['eightBedRoom'].'",tenBedRoom="'.$hotelSuppD['tenBedRoom'].'",quadRoom="'.$hotelSuppD['quadRoom'].'",teenRoom="'.$hotelSuppD['teenRoom'].'",childBreakfast="'.$hotelSuppD['childBreakfast'].'",childDinner="'.$hotelSuppD['childDinner'].'",childLunch="'.$hotelSuppD['childLunch'].'",sixNoofBedRoom="'.$hotelSuppD['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelSuppD['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelSuppD['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelSuppD['quadNoofRoom'].'",teenNoofRoom="'.$hotelSuppD['teenNoofRoom'].'",isChildBreakfast="'.$hotelSuppD['isChildBreakfast'].'",isChildLunch="'.$hotelSuppD['isChildLunch'].'",isChildDinner="'.$hotelSuppD['isChildDinner'].'"';
						$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

						$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
						if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
							$namevalue ='';
							$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$date.'",endDate="'.$date.'"';
							addlistinggetlastid('quotationItinerary',$namevalue);
						}
					}
		 

					$qhaQuery=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$HotelRes['id'].'"  and quotationId="'.$QueryDaysData['quotationId'].'" order by id asc');
					while($qhAData=mysqli_fetch_array($qhaQuery)){

						$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",hotelId="'.$qhAData['hotelId'].'",additionalCost="'.$qhAData['additionalCost'].'",name="'.$qhAData['name'].'",hotelQuotId="'.$addHotel.'",additionalId="'.$qhAData['additionalId'].'",costType="'.$qhAData['costType'].'",queryId="'.$qhAData['queryId'].'",destinationId="'.$qhAData['destinationId'].'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$qhAData['currencyId'].'",currencyValue="'.$qhAData['currencyValue'].'",rateId="'.$qhAData['rateId'].'"';
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
				$transfernamevalue ='fromDate="'.$date.'",toDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'"';
				
				//quotationTransferTimelineDetails   
				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					$transferTimelineData=mysqli_fetch_array($c1);

					$namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					$hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);

				}
				
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$date.'",endDate="'.$date.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="transportation" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){ 
			while($transferRes=mysqli_fetch_array($b)){

				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				

				$addHotel = ''; 
				$transfernamevalue ='fromDate="'.$date.'",toDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					 $transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					

				}
				
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$date.'",endDate="'.$date.'"';
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
			$transfernamevalue ='guideId="'.$transferRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferRes['price'].'",guideName="'.$transferRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$date.'",toDate="'.$date.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferRes['srn'].'",destinationId="'.$transferRes['destinationId'].'",rules="'.$transferRes['rules'].'",category="'.$transferRes['category'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",subcategory="'.$transferRes['subcategory'].'",totalDays="'.$transferRes['totalDays'].'",perDaycost="'.$transferRes['perDaycost'].'",serviceType="'.$transferRes['serviceType'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",guideQuoteId="'.$transferRes['guideQuoteId'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",paxRange="'.$transferRes['paxRange'].'",dayType="'.$transferRes['dayType'].'",dayId="'.$newDayId.'",markupCost="'.$transferRes['markupCost'].'"';

			$addHotel = addlistinggetlastid('quotationGuideMaster',$transfernamevalue);

			$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'"  and guideQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
			while($transferSuppRes=mysqli_fetch_array($bSupp)){
				$suppGuidevalue ='guideId="'.$transferSuppRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",currencyValue="'.$transferSuppRes['currencyValue'].'",guideQuoteId="'.$addHotel.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$newDayId.'",markupCost="'.$transferSuppRes['markupCost'].'"';
	
				$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
			
			}

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			// tariffId
			$transfernamevalue ='otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",fromDate="'.$date.'",toDate="'.$date.'",activityCost="'.$transferRes['activityCost'].'",maxpax="'.$transferRes['maxpax'].'",perPaxCost="'.$transferRes['perPaxCost'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",markupCost="'.$transferRes['markupCost'].'",transferType="'.$transferRes['transferType'].'",slabId="'.$transferRes['slabId'].'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",vehicleId="'.$transferRes['vehicleId'].'",repCost="'.$transferRes['repCost'].'",tarifType="'.$transferRes['tarifType'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",nationality="'.$transferRes['nationality'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$transfernamevalue);
			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="activity",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationActivityTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1); 
				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationActivityTimelineDetails',$namevalue);

			}

		}


		$b=GetPageRecord('*','quotationEnrouteMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="enroute" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel ='';
			$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$date.'",toDate="'.$date.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",destinationId="'.$transferRes['destinationId'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$date.'",toDate="'.$date.'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",transferType="'.$transferRes['transferType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid('quotationEntranceMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="entrance",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1);

				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);

			}
		}

		// Duplicate Ferry
		$b=GetPageRecord('*','quotationFerryMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="ferry" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$ferrynamevalue ='ferryNameId="'.$transferRes['ferryNameId'].'",serviceid="'.$transferRes['serviceid'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$date.'",toDate="'.$date.'",ferryClass="'.$transferRes['ferryClass'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",ferryCost="'.$transferRes['ferryCost'].'",processingfee="'.$transferRes['processingfee'].'",miscCost="'.$transferRes['miscCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",pickupTime="'.$transferRes['pickupTime'].'",dropTime="'.$transferRes['dropTime'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",remark="'.$transferRes['remark'].'",rateId="'.$transferRes['rateId'].'",timeId="'.$transferRes['timeId'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid('quotationFerryMaster',$ferrynamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="ferry",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
		}        

		$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",destinationId="'.$transferRes['destinationId'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",fromDate="'.$date.'",toDate="'.$date.'",queryId="'.$queryId.'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$date.'",quotationId="'.$lastQuotationId.'",toDate="'.$date.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$date.'",quotationId="'.$lastQuotationId.'",toDate="'.$date.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",trainId="'.$transferRes['trainId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="train",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='name="'.$transferRes['name'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$queryId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",costType="'.$transferRes['costType'].'",additionalId="'.$transferRes['additionalId'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';

				$addHotel = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$transfernamevalue);


				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="additional",startDate="'.$date.'",endDate="'.$date.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
		}

		$b='';
		$b=GetPageRecord('*','quotationModeMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" order by id asc');
		if(mysqli_num_rows($b)>0){
			$transferRes=mysqli_fetch_array($b);
			$addHotel = '';
			$modevalue ='name="'.$transferRes['name'].'",dayId="'.$newDayId.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'"';
			$modeId = addlistinggetlastid('quotationModeMaster',$modevalue);
		}



		$day++;
	}

	$b='';
	$b=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationId.'" order by id asc');
	if(mysqli_num_rows($b)>0){
		$transferRes=mysqli_fetch_array($b);
		$addHotel = '';
		$modevalue = ' markupCost="'.$transferRes['markupCost'].'", curren="'.$transferRes['curren'].'", quotationId="'.$lastQuotationId.'", package="'.$transferRes['package'].'", hotel="'.$transferRes['hotel'].'", guide="'.$transferRes['guide'].'", activity="'.$transferRes['activity'].'", entrance="'.$transferRes['entrance'].'", transfer="'.$transferRes['transfer'].'", train="'.$transferRes['train'].'",flight="'.$transferRes['flight'].'", restaurant="'.$transferRes['restaurant'].'",ferry="'.$transferRes['ferry'].'",visa="'.$transferRes['visa'].'",passport="'.$transferRes['passport'].'",insurance="'.$transferRes['insurance'].'",other="'.$transferRes['other'].'",packageMarkupType="'.$transferRes['packageMarkupType'].'",hotelMarkupType="'.$transferRes['hotelMarkupType'].'",guideMarkupType="'.$transferRes['guideMarkupType'].'",activityMarkupType="'.$transferRes['activityMarkupType'].'",entranceMarkupType="'.$transferRes['entranceMarkupType'].'",transferMarkupType="'.$transferRes['transferMarkupType'].'",trainMarkupType="'.$transferRes['trainMarkupType'].'",flightMarkupType="'.$transferRes['flightMarkupType'].'",restaurantMarkupType="'.$transferRes['restaurantMarkupType'].'",ferryMarkupType="'.$transferRes['ferryMarkupType'].'",visaMarkupType="'.$transferRes['visaMarkupType'].'",passportMarkupType="'.$transferRes['passportMarkupType'].'",insuranceMarkupType="'.$transferRes['insuranceMarkupType'].'",otherMarkupType="'.$transferRes['otherMarkupType'].'",status="'.$transferRes['status'].'"';
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
	//End of the duplicate part



	//star check for rate change
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);
	$dayWise = $queryData['dayWise'];
	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];

	date_default_timezone_set('Asia/Kolkata');
	$newfilez = makeQuotationId($lastQuotationData['id']);

 	// use above var
	$hotelError = $msgError = "";
	$newDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and addstatus=0 order by srdate asc');
	while($newDaysData=mysqli_fetch_array($newDaysQuery)){

		$cityId = $newDaysData['cityId'];
		$date = date('Y-m-d', strtotime($newDaysData['srdate']));
		$dayId = $newDaysData['id'];

		// check the service price difference
		//---------------------------------------------------------------------
		$b=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" group by serviceType order by srn asc,id desc');
		while($sorting=mysqli_fetch_array($b)){
			if($sorting['serviceType'] == 'hotel'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="hotel" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$sorting1['quotationId'].'" and supplierId="'.$sorting1['serviceId'].'" and dayId="'.$sorting1['dayId'].'" order by id desc');
					$hotelQuotData=mysqli_fetch_array($c);
					$prevSupplementCostAdded = $hotelQuotData['supplementCostAdded'];
					$roomTariffId = $hotelQuotData['roomTariffId'];
					$destinationId = $hotelQuotData['destinationId'];
					$tarifType = $hotelQuotData['tarifType'];
					$roomType = $hotelQuotData['roomType'];
				
					// hotel data
					$dh=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
					$hotelData=mysqli_fetch_array($dh);
					
					$seasonQuery = "";
					if($dayWise == 2){
						if($queryData['seasonType']!= 3 ){
							$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}else{
							$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}
					}else{
						 $seasonQuery = " and DATE(fromDate)<='".$date."' and  DATE(toDate)>='".$date."'";
					}

					// exit();

					//data from dmc
					//for normal each day
					$dmcrate=0;
 					$normalCheckQuery = "";
					$specialCheckQuery = "";

					// check for special days rate
					$roomTypeFilter = 'and roomType="'.$roomType.'"';
					$wherespc = ' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=3 '.$seasonQuery.' '.$roomTypeFilter.' ';
					
					 $specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$wherespc);
					
					if(mysqli_num_rows($specialCheckQuery)>0){
						// if special days rates exist
						$dmcSpecialrate=1;
						$dmcroommastermain=mysqli_fetch_array($specialCheckQuery);
						$dmcroommastermain['tarifType'];
					}else{
						// Check for Weekend Rates
						$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and tarifType="2" '.$seasonQuery.' '.$roomTypeFilter.' and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) ) ');

						if(mysqli_num_rows($weekendCheckQuery)>0){
						$dmcWeekendrate=1;
						$dmcroommastermain=mysqli_fetch_array($weekendCheckQuery);
						}else{
						// Check for Normal Rates
						$normalCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=1 '.$seasonQuery.' '.$roomTypeFilter.'');
						if(mysqli_num_rows($normalCheckQuery)>0){
						$dmcNormalrate=1;
						$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);
						}else{
							$normalratenotexist=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$hotelQuotData['quotationId'].'" and id="'.$hotelQuotData['id'].'" order by id desc');
							$dmcNormalratenotexit=1;
							$dmcroommastermain=mysqli_fetch_array($normalratenotexist);
						}
						
					}
				}
			
			
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);

					$supplementCostAdded = 0;
					if($dmcSpecialrate==1){
					$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
					$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);

				// }
			  }else{
				$msgError='';
				$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : Special Rate is not available, Normal rate rate is applicable.</p>";
				$hotelError .= $msgError;
				errorlogGenerateQuotation($msgError,$newfilez);
			 }

			 if($dmcWeekendrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
		//   else{
		// 	$msgError='';
		// 	$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : New Rate is not available, Previous rate rate is applicable.</p>";
		// 	$hotelError .= $msgError;
		// 	errorlogGenerateQuotation($msgError,$newfilez);
		//  }

			 if($dmcNormalrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
		//   else{
		// 	$msgError='';
		// 	$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : New Rate is not available, Previous rate rate is applicable.</p>";
		// 	$hotelError .= $msgError;
		// 	errorlogGenerateQuotation($msgError,$newfilez);
		//  }


		 if($dmcNormalratenotexit==1){
			$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
			$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

			$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
			addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
		//   else{
		// 	$msgError='';
		// 	$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : New Rate is not available, Previous rate rate is applicable.</p>";
		// 	$hotelError .= $msgError;
		// 	errorlogGenerateQuotation($msgError,$newfilez);
	 	// 	}


					// if(mysqli_num_rows($rssup1) > 0 && $dmcrate==1  ){
					// 	$supplementCost=mysqli_fetch_array($rssup1);
					// 	$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0,0,1);
					// 	$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0,0,1);
					// 	$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0,0,1);

					// 	$supplementCostAdded = 1;
					// }else{
					// 	$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					// 	$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					// 	$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					// 	$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					// 	$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					// 	$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					// 	$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					// 	$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);

					// 	$supplementCostAdded = 0;

					// }



					//data from dmc
					//for normal each day
  					// $qoutrate=0;
 					// $normalCheckQuery = "";
					// $normalCheckQuery=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$hotelData['id'].'" '.$tarifQuery.' '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' and status=1 and quotationId="'.$lastQuotationId.'"  and supplierId>0 and tarifType="'.$hotelQuotData['tariffType'].'" ');

					// if(mysqli_num_rows($normalCheckQuery)>0){

					// 	$qoutrate=1;
					// 	$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);

					// } else{
					// 	$qoutrate=0;
					// }

					// $rssup1 = "";
					// $rssup1=GetPageRecord('*','quotationHotelRateMaster',' serviceid="'.$hotelData['id'].'" '.$roomTypeQuery.' '.$mealPlan.' '.$seasonQuery.'  '.$whereMarket.' and quotationId="'.$lastQuotationId.'" and status=1 and supplierId>0 and tarifType="4"');

					// if(mysqli_num_rows($rssup1) > 0 && $qoutrate==1  ){
					// 	$supplementCost=mysqli_fetch_array($rssup1);
					// 	$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['singleoccupancy'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['childwithbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['extraBed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']) + getCostWithGST($supplementCost['childwithoutbed'],getGstValueById($supplementCost['roomGST']),$supplementCost['roomTAC'],$supplementCost['markupCost'],$supplementCost['markupType']);
					// 	$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1) + getCostWithGST($supplementCost['lunch'],getGstValueById($supplementCost['mealGST']),0,0,1);
					// 	$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1)+ getCostWithGST($supplementCost['dinner'],getGstValueById($supplementCost['mealGST']),0,0,1);
					// 	$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1) + getCostWithGST($supplementCost['breakfast'],getGstValueById($supplementCost['mealGST']),0,0,1);

					// 	$supplementCostAdded = 1;

 					// }else{
					// 	$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
					// 	$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
					// 	$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
					// 	$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
					// 	$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
					// 	$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					// 	$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					// 	$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);

					// 	$supplementCostAdded = 0;
					// }

					// $mealPlan = '';
					// 	if($hotelQuotData['mealPlan']!='' && $hotelQuotData['mealPlan']!=0){
					// 		$mealPlan = 'and mealPlan="'.$hotelQuotData['mealPlan'].'"';
					// 	}
	
					// 	$marketId = getQueryMaketType($queryId);
					// 	$whereMarket = '';
					// 	if($marketId>0){
					// 		$whereMarket = ' and marketType="'.$marketId.'"';
					// 	}
	
					// 	$roomTypeQuery = '';
					// 	if($hotelQuotData['roomType']!='' && $hotelQuotData['roomType']!=0){
					// 		$roomTypeQuery = ' and roomType="'.$hotelQuotData['roomType'].'" ';
					// 	}
	
					// 	$seasonQuery = "";
					// 	if($queryData['dayWise'] == 2){
					// 		if($queryData['seasonType']!= 3 ){
					// 			$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
					// 		}else{
					// 			$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
					// 		}
					// 	}else{
					// 		 $seasonQuery = " and DATE(fromDate)<='".$date."' and  DATE(toDate)>='".$date."'";
					// 	}
	
					// 	if($hotelQuotData['tariffType'] == 2){
					// 		$tarifQuery = "";
					// 		$tarifQuery = ' and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) ) ';
					// 	}
	
					// 	$normalCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0');
					// 	if(mysqli_num_rows($normalCheckQuery)<1){
					// 	$dmcNormalrate=1;
					// 	$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);
					// 	}

				// 	if($dmcNormalrate==1){

				// 		//supplemetn cost check up
				// 		if($supplementCostAdded == 1){
				// 			if($prevSupplementCostAdded == 0){
				// 				$msgError='';
				// 				$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : Supplement cost added.</p>";
				// 				//danger
				// 				$hotelError .= $msgError;
				// 				errorlogGenerateQuotation($msgError,$newfilez);
				// 			}
						
				// 		}
				// 		if($supplementCostAdded == 0){
				// 			if($prevSupplementCostAdded == 1){
				// 				$msgError='';
				// 				$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : No supplement cost found.</p>";
				// 				//danger
				// 				$hotelError .= $msgError;
				// 				errorlogGenerateQuotation($msgError,$newfilez);
				// 			}
				// 		}

				// 		//hotel restriction check
				// 		$rs21=GetPageRecord('*','hoteloperationRestriction',' hotelId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate  ');
				// 		$msgOpr = '';
				// 		if(mysqli_num_rows($rs21) > 0){
				// 			$oprResData=mysqli_fetch_array($rs21);
				// 			$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

				// 			$msgError='';
				// 			$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
				// 			$hotelError .= $msgError;
				// 			//danger
				// 			errorlogGenerateQuotation($msgError,$newfilez);

				// 		}



				// 		//check for duplicate
				// 		// $wheresup5="";
				// 		// $rs5="";
				// 		// $wheresup5='quotationId="'.$lastQuotationId.'" and queryId="'.$queryId.'" and dayId="'.$dayId.'" and supplierId="'.$hotelData['id'].'"';
				// 		// $rs5=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,$wheresup5);
				// 		// if(mysqli_num_rows($rs5) < 1 ){
						
				// 			$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				// 			$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				// 			$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				// 			addlisting('quotationItinerary',$namevalue1);

				// 		// }
  				// 	}else{
				// 		$msgError='';
				// 		$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : Rate is not available, Previous rate is applicable.</p>";
				// 		$hotelError .= $msgError;
				// 		errorlogGenerateQuotation($msgError,$newfilez);
 				// 	}

				// 	//end query--------------------
				}
			}
			// transfer rate starts
			if($sorting['serviceType'] == 'transfer' || $sorting['serviceType'] == 'transportation'){
				// quotation hotel data
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="transfer" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs2=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$newDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"');
					$transferQuotData=mysqli_fetch_array($rs2);

					$rs2=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');
					$transferData=mysqli_fetch_array($rs2);
					$transferName = ucfirst($transferData['transferCategory'])."-".clean($transferData['transferName']);

					//check for exitance
					$rsa2s=GetPageRecord('*','quotationTransferRateMaster','id="'.$transferQuotData['tariffId'].'"');
					if(mysqli_num_rows($rsa2s)>0){
						$dmcTransferData=mysqli_fetch_array($rsa2s);
					}else{
						$rs1=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$transferQuotData['tariffId'].'"');
						$dmcTransferData=mysqli_fetch_array($rs1);
					}

					if( $dmcTransferData['id'] > 0 && $dmcTransferData['id']!='' ){


						$tarifId = addslashes($dmcTransferData['id']);
						$supplierId = addslashes($dmcTransferData['supplierId']);
						$destinationId = $transferQuotData['destinationId'];
 						$transferCategory = $transferData['transferCategory'];
						$costType= $transferQuotData['costType'];
						$distance= $dmcTransferData['distance'];

						$transferNameId=addslashes($dmcTransferData['transferNameId']);
						$transferType='2';
						$infantsCost=addslashes($dmcTransferData['infantCost']);
						$vehicleTypeId=addslashes($dmcTransferData['vehicleTypeId']);
						$vehicleModelId=addslashes($dmcTransferData['vehicleModelId']);
						$gstTax=addslashes($dmcTransferData['gstTax']);
						$vehicleCost=0;

						if(trim($_REQUEST['noOfDays'])<1){ $noOfDays = 1; }else{ $noOfDays = trim($_REQUEST['noOfDays']); }

						if($dmcTransferData['serviceType']=='transfer'){
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$dmcTransferData['gstTax'])+$vehicleCost);
						}else{
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$gstTax)+$vehicleCost)*$noOfDays;
						}

						$detail=addslashes($dmcTransferData['detail']);
						$currencyId=addslashes($dmcTransferData['currencyId']);

						$namevalue = 'fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$destinationId.'",transferNameId="'.$transferNameId.'",transferType="'.$transferType.'",vehicleType="'.$vehicleTypeId.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",currencyId="'.$currencyId.'",detail="'.$detail.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",tariffId="'.$tarifId.'",parkingFee="'.$dmcTransferData['parkingFee'].'",representativeEntryFee="'.$dmcTransferData['representativeEntryFee'].'",assistance="'.$dmcTransferData['assistance'].'",guideAllowance="'.$dmcTransferData['guideAllowance'].'",interStateAndToll="'.$dmcTransferData['interStateAndToll'].'",miscellaneous="'.$dmcTransferData['miscellaneous'].'",gstTax="'.$dmcTransferData['gstTax'].'",costType="'.$costType.'",distance="'.$distance.'",noOfDays="'.trim($noOfDays).'",dayId="'.$dayId.'",serviceType="'.$transferCategory.'"';
						$lastid = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="'.$transferCategory.'", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);
					}else{

						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".strip($transferName)." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}




				}
			}
			// entrance rate starts
			if($sorting['serviceType'] == 'entrance'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="entrance" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'" ';
					$rs1=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$entranceQuotData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id ="'.$entranceQuotData['entranceNameId'].'" ');
						$entranceData=mysqli_fetch_array($otherActivitySql);

						$entranceName = strip($entranceData['entranceName']);
						$entranceNameId = strip($entranceData['id']);
						$marketId = getQueryMaketType($queryId);
						$supplierId = $entranceQuotData['supplierId'];
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
 						$rs1 = GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,' entranceNameId= "'.$entranceNameId.'" and supplierId = "'.$supplierId.'"  and "'.$date.'" BETWEEN fromDate and toDate '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcEntranceData = mysqli_fetch_array($rs1);

							$entranceId=addslashes($dmcEntranceData['id']);
							$detail=addslashes($dmcEntranceData['detail']);
							$ticketAdultCost=addslashes($dmcEntranceData['ticketAdultCost']);
							$ticketchildCost=addslashes($dmcEntranceData['ticketchildCost']);
							$currencyId=addslashes($dmcEntranceData['currencyId']);

							$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",entranceNameId="'.$entranceNameId.'",currencyId="'.$currencyId.'",detail="'.$detail.'",ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",dmcId="'.$entranceId.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_ENTRANCE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="entrance", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);

							// operation restriction detail
							$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}
						}else{
							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}

			if($sorting['serviceType'] == 'activity'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="activity" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);

					if(mysqli_num_rows($rs1)>0){
						$quotationActivityData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*','packageBuilderotherActivityMaster',' id ="'.$quotationActivityData['otherActivityName'].'" ');
						$activityData=mysqli_fetch_array($otherActivitySql);
						$otherActivityName=addslashes($activityData['otherActivityName']);

						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}

						$maxpax = $quotationActivityData['maxpax'];
						$supplierId = $quotationActivityData['supplierId'];
						$where11=' otherActivityNameId = "'.$activityData['id'].'" and "'.$date.'" BETWEEN fromDate and toDate and supplierId = "'.$supplierId.'" '.$whereMarket.' ';
						$rs11=GetPageRecord('*','dmcotherActivityRate',$where11);
						if(mysqli_num_rows($rs11)>0){

							$dmcActivityData=mysqli_fetch_array($rs11);
							
							$activityCost=addslashes($quotationActivityData['activityCost']);

							$cityName = getDestination($cityId);

							$otherActivityCity=addslashes($quotationActivityData['otherActivityCity']);
							$dateotherActivity=date('Y-m-d',strtotime($quotationActivityData['dateotherActivity']));
							$currencyId=$quotationActivityData['currencyId'];


							$namevalue ='activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",perPaxCost="'.$activityCost.'",otherActivityName="'.$dmcActivityData['otherActivityNameId'].'",otherActivityCity="'.$cityName.'",queryId="'.$queryId.'",dateotherActivity="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue);

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="activity", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);

							//show restriction alert
 							$rs21=GetPageRecord('*','hoteloperationRestriction','otheractivityId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate  ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}

				 		}else{
							// show not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}
				}
			}
			if($sorting['serviceType'] == 'guide'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="guide" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$quotationGuideData=mysqli_fetch_array($rs1);

						$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$quotationGuideData['guideId'].'"');
						$guideData = mysqli_fetch_array($rs11);


						$supplierId = $entranceQuotData['supplierId'];
						$guideId = $guideData['id'];
						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
												
						}
						$rs1 = GetPageRecord('*','dmcGuidePorterRate','  serviceid = "'.$guideId.'" and supplierId = "'.$quotationGuideData['supplierId'].'" '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcGuideData = mysqli_fetch_array($rs1);

							$tariffId = $dmcGuideData['id'];
							$tariffId = $guideData['id'];
							$supplierId = $dmcGuideData['supplierId'];
							$price=addslashes($dmcGuideData['price']);

							$serviceType = $guideCat['serviceType'];
							$totalDays = $quotationGuideData['totalDays'];

							$namevalue ='fromDate="'.$startDate.'",toDate="'.$startDate.'",serviceType="'.$serviceType.'",destinationId="'.$cityId.'",guideId="'.$guideId.'",tariffId="'.$tariffId.'",supplierId="'.$supplierId.'",price="'.($price*$totalDays).'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",totalDays="'.$totalDays.'",perDaycost="'.$price.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_GUIDE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="guide", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);



						}else{

							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Guide Service - ".strip($guideData['name'])." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}
			if($sorting['serviceType'] == 'enroute'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="enroute" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs1=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' id="'.$sorting1['serviceId'].'" and quotationId="'.$lastQuotationId.'" ');
					$quotationEnrouteData = mysqli_fetch_array($rs1);

					$enrouteSql=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$quotationEnrouteData['enrouteId'].'" ');
					if(mysqli_num_rows($enrouteSql)>0){

						$enrouteData=mysqli_fetch_array($enrouteSql);

						$enrouteName =  $enrouteData['enrouteName'];
						$adultCost=addslashes($enrouteData['adultCost']);
						$childCost=addslashes($enrouteData['childCost']);
						$currencyId=addslashes($enrouteData['currencyId']);

						$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",enrouteId="'.$enrouteId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$currencyId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",dayId="'.$startDayId.'"';
						$lastid = addlistinggetlastid(_QUOTATION_ENROUTE_MASTER_,$namevalue);
						// loop for hotel query inserting number of date

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="enroute", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						addlisting('quotationItinerary',$namevalue1);

						if($quotationEnrouteData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}else{
						// rate not available
						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}
				}
			}
			if($sorting['serviceType'] == 'flight'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$flightQuotData = mysqli_fetch_array($rs1);

					$flightId = $flightQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_AIRLINES_MASTER_,'id="'.$flightId.'"');
					$flightData=mysqli_fetch_array($rs1);

					$flightName=addslashes($flightData['flightName']);
					$flightId=addslashes($flightData['id']);
					$childCost=addslashes($flightQuotData['childCost']);
					$adultCost=addslashes($flightQuotData['adultCost']);
					$flightClass=addslashes($flightQuotData['flightClass']);
					$flightNumber=addslashes($flightQuotData['flightNumber']);
					$departureFrom=addslashes($flightQuotData['departureFrom']);
					$arrivalTo=addslashes($flightQuotData['arrivalTo']);
					$departureDate=date('Y-m-d',strtotime($flightQuotData['departureDate']));
					$departureTime=addslashes($flightQuotData['departureTime']);
					$arrivalTime=addslashes($flightQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($flightQuotData['arrivalDate']));

					 $namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",flightId="'.$flightId.'",queryId="'.$queryId.'",destinationId="'.$destinationId.'",quotationId="'.$quotationId.'",departureFrom="'.$departureFrom.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",flightClass="'.$flightClass.'",currencyId="'.$flightQuotData['currencyId'].'",currencyValue="'.$flightQuotData['currencyValue'].'",flightNumber="'.$flightNumber.'",arrivalDate="'.$arrivalDate.'",dayId="'.$dayId.'"';
					$lastid = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="flight", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);

					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Flight - ".$flightName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);

				}
			}
			if($sorting['serviceType'] == 'train'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$trainQuotData = mysqli_fetch_array($rs1);

					$trainId = $trainQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainId.'"');
					$trainData=mysqli_fetch_array($rs1);

					$trainName=addslashes($trainData['trainName']);
					$trainId=addslashes($trainData['id']);
					$childCost=addslashes($trainQuotData['childCost']);
					$adultCost=addslashes($trainQuotData['adultCost']);
					$trainClass=addslashes($trainQuotData['trainClass']);
					$trainNumber=addslashes($trainQuotData['trainNumber']);
					$journeyType=addslashes($trainQuotData['journeyType']);
					$departureFrom=addslashes($trainQuotData['departureFrom']);
					$departureTime=addslashes($trainQuotData['departureTime']);
					$arrivalTime=addslashes($trainQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($trainQuotData['arrivalDate']));
					$departureDate=date('Y-m-d',strtotime($trainQuotData['departureDate']));
					$arrivalTo=addslashes($trainQuotData['arrivalTo']);

					$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",trainId="'.$trainId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$destinationstart.'",departureFrom="'.$departureFrom.'",journeyType="'.$journeyType.'",arrivalTime="'.$arrivalTime.'",arrivalDate="'.$arrivalDate.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$trainQuotData['currencyId'].'",currencyValue="'.$trainQuotData['currencyValue'].'",trainClass="'.$trainClass.'",trainNumber="'.$trainNumber.'",dayId="'.$dayId.'"';
					$lastid = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="train", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);


					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Train - ".$trainName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);


				}
			}
			if($sorting['serviceType'] == 'mealplan'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					while($mealplanQuotData=mysqli_fetch_array($rs1)){

						$mealPlanId = $mealplanQuotData['mealPlanName'];
						$rs1=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,'id="'.$mealPlanId.'"');
						$mealplanData=mysqli_fetch_array($rs1);

						$mealPlanName=addslashes($mealplanData['mealPlanName']);
 						$mealType=addslashes($mealplanQuotData['mealPlanmealType']);
						$adultCost=addslashes($mealplanQuotData['mealPlanadultCost']);
						$childCost=addslashes($mealplanQuotData['mealPlanchildCost']);
						$currencyId=addslashes($mealplanQuotData['currencyId']);

						$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",mealType="'.$mealType.'",mealPlanName="'.$mealPlanName.'",destinationId="'.$cityId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
						$lastid = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="mealplan", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						//addlisting('quotationItinerary',$namevalue1);
			 			/*if($mealplanQuotData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Meal Plan - ".$mealPlanName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}*/

					}
				}
			}
			if($sorting['serviceType'] == 'additional'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="additional" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$ss1=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$lastQuotationData['id'].'" and id="'.$sorting1['serviceId'].'" ');
					$additionalQuotData = mysqli_fetch_array($ss1);

					$rs1=GetPageRecord('*','extraQuotation',"id='".$additionalQuotData['additionalId']."'");
					if(mysqli_num_rows($rs1)>0){
						$additionalData=mysqli_fetch_array($rs1);

						$name=addslashes($additionalData['name']);
						$childCost=addslashes($additionalQuotData['childCost']);
						$adultCost=addslashes($additionalQuotData['adultCost']);
						$groupCost=addslashes($additionalQuotData['groupCost']);
						$currencyValue=addslashes($additionalQuotData['currencyValue']);
						$costType=addslashes($additionalQuotData['costType']);

						$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",groupCost="'.$groupCost.'",name="'.$name.'",additionalId="'.$additionalId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$cityId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",costType="'.$costType.'",dayId="'.$dayId.'"';
						// $lastid = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="additional", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						// addlisting('quotationItinerary',$namevalue1);
					}
				}

			}

		}

	}

	// rate change after date change ends
	//get the alert after process
	//---------------------------------------------------------------------
	// if all day duplicated
	if(mysqli_num_rows($QueryDaysQuery) == $day ){
		if($hotelError != ''){
			$msgError='';
			$msgError = "<p style='color:#D8000C;'>----Log file End----.</p>";
			//danger
			errorlogGenerateQuotation($msgError,$newfilez);
			?>
			<script>
			parent.query_alertbox('action=regenrateQuotationInfo&quotationId=<?php echo encode($lastQuotationData['id']); ?>','700px','auto');
			setTimeout( function(){
				parent.$('#regenrateQuotationInfo').html("<?php echo addslashes($hotelError); ?>");
			}  , 1000 );
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
			</script>
			<?php
		}else{
			$msgError='';
			$msgError = "<p style='color:#D8000C;'>----Log file End----.</p>";
			//danger
			errorlogGenerateQuotation($msgError,$newfilez);
			?>
			<script>
			parent.setupbox('showpage.crm?module=quotations&view=yes&id=<?php echo encode($lastQuotationData['id']); ?>&alt=2');
			</script>
			<?php
		}
	}
}

if(trim($_REQUEST['action'])=='updateModifyRoute' && trim($_REQUEST['quotationId'])!='' ){

 	$dayIds=trim($_REQUEST['dayIdArr']);
 	$dayIdArray = explode(',',$dayIds);

	$quotationId=decode($_REQUEST['quotationId']);
	$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$quotationId.'');
	$quotationData=mysqli_fetch_array($rs1);
	$queryId = $quotationData['queryId'];

	$rs1=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($quotationData['queryId']).'');
	$queryData=mysqli_fetch_array($rs1);
	$dayWise = $queryData['dayWise'];
	?>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	<div class="labelBorder" >Current Accommondation</div>
	<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#DDD"  >
	<thead>
	<tr>
	<th width="70px">Sr.No.</th>
	<?php if($dayWise == 1){ ?><th width="120px">Date</th><?php } ?>
	<th width="180px" align="left">Destination</th>
	<th width="30px" align="center">&nbsp;</th>
	</tr>
	</thead>
	<tbody class="row_drag2" onclick="modifyRoute();" >
	<?php
	$n = 1;
	$rs1=GetPageRecord('min(srdate) as daydate','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc');
	$daydateD=mysqli_fetch_array($rs1);

	$daydate1 = date('Y-m-d', strtotime("-1 day", strtotime($daydateD['daydate'])));
	foreach($dayIdArray as $dayId) {

		$daydate = date('d-m-Y /D', strtotime("+".$n." day", strtotime($daydate1)));

	 	$rs1="";
		$rs1=GetPageRecord('*','newQuotationDays',' id = "'.$dayId.'" and  quotationId="'.$quotationId.'"');
		$newQuoteData=mysqli_fetch_array($rs1);

		$pqId= $newQuoteData["id"];
		$cityId= $newQuoteData["cityId"];
		?>
		<tr class="row<?php echo $pqId; ?>" dayId = "<?php echo trim($pqId); ?>">
		<td width="70px" >Day&nbsp;<?php echo $n; ?></td>
		<?php if($dayWise == 1){ ?>
		<td width="120px"><?php echo $daydate; ?></td>
		<?php } ?>
		<td width="180px"><?php echo getDestination($cityId); ?></td>
		<td width="30px" align="left"><a class="moveBtn drag-handler"><i class="fa fa-arrows-alt" style="color:#CCCCCC;transform: rotate(45deg);"></i></a></td>
		</tr>
		<?php
		$n++;
	}
	?>
	</tbody>
	</table>
	<?php

}

if(trim($_REQUEST['action'])=='askToRegenrateQuotation_updateModifyRoute' && trim($_REQUEST['quotationId'])!=''){

	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.decode($_REQUEST['quotationId']).'"  ');
	$quotationData=mysqli_fetch_array($rsp);

	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];

	$quotationNo = $quotationData['quotationNo'];

	$generateNo  = 1;
	$rsp1=GetPageRecord('generateNo',_QUOTATION_MASTER_,' queryId="'.clean($queryId).'" and quotationNo="'.$quotationNo.'"  order by generateNo desc');
	$generateNoD=mysqli_fetch_array($rsp1);
	if($generateNoD['generateNo']!=''){
		$generateNo = $generateNoD['generateNo']+1;
	}
 	//sglRoom

	//duplicate quotation with all servicess
	//------------------------------------------------------------------ 
	$namevalue ='clientType="'.$quotationData['clientType'].'",queryId="'.$queryId.'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$quotationData['adult'].'",child="'.$quotationData['child'].'",infant="'.$quotationData['infant'].'",sglRoom="'.$quotationData['sglRoom'].'",dblRoom="'.$quotationData['dblRoom'].'",tplRoom="'.$quotationData['tplRoom'].'",twinRoom="'.$quotationData['twinRoom'].'",childwithNoofBed="'.$quotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$quotationData['childwithoutNoofBed'].'",extraNoofBed="'.$quotationData['extraNoofBed'].'",night="'.$quotationData['night'].'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",deletestatus="'.$quotationData['deletestatus'].'",quotationId="'.$quotationData['quotationId'].'",starRating="'.$quotationData['starRating'].'",status=0,viewQuotation="'.$quotationData['viewQuotation'].'",totalAmount="'.$quotationData['totalAmount'].'",totalquotCostWithMarkup="'.$quotationData['totalquotCostWithMarkup'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",hotelType="'.$quotationData['hotelType'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'",inclusion="'.addslashes($quotationData['inclusion']).'",serviceupgradationText="'.addslashes($quotationData['serviceupgradationText']).'",optionaltourText="'.addslashes($quotationData['optionaltourText']).'",remarks="'.addslashes($quotationData['remarks']).'",paymentpolicy="'.addslashes($quotationData['paymentpolicy']).'",fitGitId="'.addslashes($quotationData['fitGitId']).'",exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.addslashes($quotationData['isInc_exc']).'",quotationNo="'.$quotationNo.'",generateNo="'.$generateNo.'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",saveQuotaiton="'.$quotationData['saveQuotaiton'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",languageId="'.$quotationData['languageId'].'",deletestatusDuplicate="'.$quotationData['deletestatusDuplicate'].'",propIMGNum3="'.$quotationData['propIMGNum3'].'",propIMGNum4="'.$quotationData['propIMGNum4'].'",propIMGNum6="'.$quotationData['propIMGNum6'].'",onlyTFS="'.$quotationData['onlyTFS'].'",visaRequired="'.$quotationData['visaRequired'].'",flightRequired="'.$quotationData['flightRequired'].'",transferRequired="'.$quotationData['transferRequired'].'",passportRequired="'.$quotationData['passportRequired'].'",insuranceRequired="'.$quotationData['insuranceRequired'].'",visaCostType="'.$quotationData['visaCostType'].'",passportCostType="'.$quotationData['passportCostType'].'",insuranceCostType="'.$quotationData['insuranceCostType'].'",dayWise="'.$quotationData['dayWise'].'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'",packageSupplier="'.$quotationData['packageSupplier'].'",tcs="'.$quotationData['tcs'].'"';

	$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);
	// update previous quotaion tourDate with his old date /
	$QueryDaysQuery1=GetPageRecord('min(srdate) as fromDate, max(srdate) as toDate ','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus=0');
	$QueryDaysData1=mysqli_fetch_array($QueryDaysQuery1);

	$where='id='.trim($quotationId).'';
	$namevalue ='fromDate="'.$QueryDaysData1['fromDate'].'",toDate="'.$QueryDaysData1['toDate'].'",isRegenerated=0';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);

	//regenerate with new date
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);

	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];
	// use above var

	if($quotationData['flightRequired']==2){
		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isFlightTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)){
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$transferRes['toDate'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",totalAdultCost="'.$transferRes['totalAdultCost'].'",adultTax="'.$transferRes['adultTax'].'",totalChildCost="'.$transferRes['totalChildCost'].'",childTax="'.$transferRes['childTax'].'",totalInfantCost="'.$transferRes['totalInfantCost'].'",infantTax="'.$transferRes['infantTax'].'",cancellationPolicy="'.$transferRes['cancellationPolicy'].'",isFlightTaken="'.$transferRes['isFlightTaken'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}
	}
}
		

		// Transfer service Copy
		if($quotationData['transferRequired']==2){
		$b=''; 
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isTransferTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){ 
			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id']; 
				$addHotel = '';

				$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",tariffId="'.$transferRes['tariffId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isTransferTaken="'.$transferRes['isTransferTaken'].'",distance="'.$transferRes['distance'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
		
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}
	}

	
	// Value Added Services Start
	
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


	// Value Added Sevices End



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
	
	$day = 0;
	$dayIds=trim($_REQUEST['dayIdArr']);
	$dayIdArr = explode(',',$dayIds);
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
		$srdate = date('Y-m-d',strtotime("+".$day." day", strtotime($fromDate)));
		$dayId  = $dayIdArr[$day];
		//$srdate = $QueryDaysData['srdate'];

		if($dayIdArr[$day] > 0){
			$rs1="";
			$rs1=GetPageRecord('*','newQuotationDays',' id = "'.$dayId.'" and quotationId="'.$quotationId.'" order by srdate asc');
			$newQuoteData=mysqli_fetch_array($rs1);

			$newDayId='';
			$namevalue =' queryId="'.$newQuoteData['queryId'].'",cityId="'.$newQuoteData['cityId'].'",title="'.$newQuoteData['title'].'",description="'.$newQuoteData['description'].'",quotationId="'.$lastQuotationId.'",srdate="'.$srdate.'"';
			$newDayId = addlistinggetlastid('newQuotationDays',$namevalue);
		}

		$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
		while($HotelRes=mysqli_fetch_array($b)){
			// normal and escort
			$namevalue ='';
			$addHotel ='';
			$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$HotelRes['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",hotelTypeId="'.$HotelRes['hotelTypeId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",currencyValue="'.$HotelRes['currencyValue'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomprice="'.$HotelRes['roomprice'].'",noofrooms="'.$HotelRes['noofrooms'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",quadoccupancy="'.$HotelRes['quadoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'", sglMarkup="'.$HotelRes['sglMarkup'].'", dblMarkup="'.$HotelRes['dblMarkup'].'", tplMarkup="'.$HotelRes['tplMarkup'].'", cwbMarkup="'.$HotelRes['cwbMarkup'].'", quadMarkup="'.$HotelRes['quadMarkup'].'", cnbMarkup="'.$HotelRes['cnbMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",mealMarkup="'.$HotelRes['mealMarkup'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",rand_color="'.$HotelRes['rand_color'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",breakfast="'.$HotelRes['breakfast'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",taxType="'.$HotelRes['taxType'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",singleNoofRoom="'.$HotelRes['singleNoofRoom'].'",doubleNoofRoom="'.$HotelRes['doubleNoofRoom'].'",twinNoofRoom="'.$HotelRes['twinNoofRoom'].'",tripleNoofRoom="'.$HotelRes['tripleNoofRoom'].'",extraNoofBed="'.$HotelRes['extraNoofBed'].'",childwithNoofBed="'.$HotelRes['childwithNoofBed'].'",childwithoutNoofBed="'.$HotelRes['childwithoutNoofBed'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isEarlyCheckin="'.$HotelRes['isEarlyCheckin'].'",sixBedRoom="'.$HotelRes['sixBedRoom'].'",eightBedRoom="'.$HotelRes['eightBedRoom'].'",tenBedRoom="'.$HotelRes['tenBedRoom'].'",quadRoom="'.$HotelRes['quadRoom'].'",teenRoom="'.$HotelRes['teenRoom'].'",childBreakfast="'.$HotelRes['childBreakfast'].'",childDinner="'.$HotelRes['childDinner'].'",childLunch="'.$HotelRes['childLunch'].'",sixNoofBedRoom="'.$HotelRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$HotelRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$HotelRes['tenNoofBedRoom'].'",quadNoofRoom="'.$HotelRes['quadNoofRoom'].'",teenNoofRoom="'.$HotelRes['teenNoofRoom'].'",isChildBreakfast="'.$HotelRes['isChildBreakfast'].'",isChildLunch="'.$HotelRes['isChildLunch'].'",isChildDinner="'.$HotelRes['isChildDinner'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

			// $check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
			// if(mysqli_num_rows($check_h)==0){
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			// }

			// supplement
			$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
			while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
				$namevalue ='';
				$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$hotelSuppD['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",hotelTypeId="'.$hotelSuppD['hotelTypeId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",currencyValue="'.$hotelSuppD['currencyValue'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",quadoccupancy="'.$hotelSuppD['quadoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'", sglMarkup="'.$hotelSuppD['sglMarkup'].'", dblMarkup="'.$hotelSuppD['dblMarkup'].'", tplMarkup="'.$hotelSuppD['tplMarkup'].'", cwbMarkup="'.$hotelSuppD['cwbMarkup'].'", quadMarkup="'.$hotelSuppD['quadMarkup'].'", cnbMarkup="'.$hotelSuppD['cnbMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",mealMarkup="'.$hotelSuppD['mealMarkup'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",taxType="'.$hotelSuppD['taxType'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isEarlyCheckin="'.$hotelSuppD['isEarlyCheckin'].'",sixBedRoom="'.$hotelSuppD['sixBedRoom'].'",eightBedRoom="'.$hotelSuppD['eightBedRoom'].'",tenBedRoom="'.$hotelSuppD['tenBedRoom'].'",quadRoom="'.$hotelSuppD['quadRoom'].'",teenRoom="'.$hotelSuppD['teenRoom'].'",childBreakfast="'.$hotelSuppD['childBreakfast'].'",childDinner="'.$hotelSuppD['childDinner'].'",childLunch="'.$hotelSuppD['childLunch'].'",sixNoofBedRoom="'.$hotelSuppD['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelSuppD['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelSuppD['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelSuppD['quadNoofRoom'].'",teenNoofRoom="'.$hotelSuppD['teenNoofRoom'].'",isChildBreakfast="'.$hotelSuppD['isChildBreakfast'].'",isChildLunch="'.$hotelSuppD['isChildLunch'].'",isChildDinner="'.$hotelSuppD['isChildDinner'].'"';
				$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

				// $check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
				// if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
					$namevalue ='';
					$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srdate.'",endDate="'.$srdate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
				// }
			}
 

			$qhaQuery=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$HotelRes['id'].'"  and quotationId="'.$QueryDaysData['quotationId'].'" order by id asc');
			while($qhAData=mysqli_fetch_array($qhaQuery)){

				$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",hotelId="'.$qhAData['hotelId'].'",additionalCost="'.$qhAData['additionalCost'].'",name="'.$qhAData['name'].'",hotelQuotId="'.$addHotel.'",additionalId="'.$qhAData['additionalId'].'",costType="'.$qhAData['costType'].'",queryId="'.$qhAData['queryId'].'",destinationId="'.$qhAData['destinationId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",currencyId="'.$qhAData['currencyId'].'",currencyValue="'.$qhAData['currencyValue'].'",rateId="'.$qhAData['rateId'].'"';
				addlistinggetlastid('quotationHotelAdditionalMaster',$namevalue);
			}

		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				
				$addHotel = ''; 
				$transfernamevalue ='fromDate="'.$srdate.'",toDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					 $transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					

				}
				
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}

		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="transportation" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				

				$addHotel = ''; 
				$transfernamevalue ='fromDate="'.$srdate.'",toDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'",isTransferTaken="'.$transferRes['isTransferTaken'].'",distance="'.$transferRes['distance'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					 $transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					

				}
				
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}


		$b=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="guide" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){

			
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				

			$addHotel =''; 
			$transfernamevalue ='guideId="'.$transferRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferRes['price'].'",guideName="'.$transferRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferRes['srn'].'",destinationId="'.$transferRes['destinationId'].'",rules="'.$transferRes['rules'].'",category="'.$transferRes['category'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",subcategory="'.$transferRes['subcategory'].'",totalDays="'.$transferRes['totalDays'].'",perDaycost="'.$transferRes['perDaycost'].'",serviceType="'.$transferRes['serviceType'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",guideQuoteId="'.$transferRes['guideQuoteId'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",paxRange="'.$transferRes['paxRange'].'",dayType="'.$transferRes['dayType'].'",markupCost="'.$transferRes['markupCost'].'",dayId="'.$newDayId.'"';

			$addHotel = addlistinggetlastid('quotationGuideMaster',$transfernamevalue);

			$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$dayId.'"  and guideQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
			while($transferSuppRes=mysqli_fetch_array($bSupp)){
				$suppGuidevalue ='guideId="'.$transferSuppRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",currencyValue="'.$transferSuppRes['currencyValue'].'",guideQuoteId="'.$addHotel.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",markupCost="'.$transferSuppRes['markupCost'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$newDayId.'"';
	
				$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
			
			} 

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			 

		}


		$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",activityCost="'.$transferRes['activityCost'].'",maxpax="'.$transferRes['maxpax'].'",perPaxCost="'.$transferRes['perPaxCost'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",markupCost="'.$transferRes['markupCost'].'",transferType="'.$transferRes['transferType'].'",slabId="'.$transferRes['slabId'].'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",vehicleId="'.$transferRes['vehicleId'].'",repCost="'.$transferRes['repCost'].'",tarifType="'.$transferRes['tarifType'].'",nationality="'.$transferRes['nationality'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$transfernamevalue);
			
			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="activity",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationActivityTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1); 
				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationActivityTimelineDetails',$namevalue);

			}

		}


		$b=GetPageRecord('*','quotationEnrouteMaster',' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="enroute" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel ='';
			$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",destinationId="'.$transferRes['destinationId'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",transferType="'.$transferRes['transferType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",markupCost="'.$transferRes['markupCost'].'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid('quotationEntranceMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="entrance",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1);

				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);

			}
			
		}

		// Duplicate Ferry
		$b=GetPageRecord('*','quotationFerryMaster','quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="ferry" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$ferrynamevalue ='ferryNameId="'.$transferRes['ferryNameId'].'",serviceid="'.$transferRes['serviceid'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",ferryClass="'.$transferRes['ferryClass'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",ferryCost="'.$transferRes['ferryCost'].'",processingfee="'.$transferRes['processingfee'].'",miscCost="'.$transferRes['miscCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",pickupTime="'.$transferRes['pickupTime'].'",dropTime="'.$transferRes['dropTime'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",remark="'.$transferRes['remark'].'",rateId="'.$transferRes['rateId'].'",timeId="'.$transferRes['timeId'].'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid('quotationFerryMaster',$ferrynamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="ferry",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
		}

		$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",destinationId="'.$transferRes['destinationId'].'",markupCost="'.$transferRes['markupCost'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$srdate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srdate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$srdate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srdate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",trainId="'.$transferRes['trainId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="train",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='name="'.$transferRes['name'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$queryId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",costType="'.$transferRes['costType'].'",additionalId="'.$transferRes['additionalId'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';

				$addHotel = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$transfernamevalue);


				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="additional",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
		}

		$b='';
		$b=GetPageRecord('*','quotationModeMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" order by id asc');
		if(mysqli_num_rows($b)>0){
			$transferRes=mysqli_fetch_array($b);
			$addHotel = '';
			$modevalue ='name="'.$transferRes['name'].'",dayId="'.$newDayId.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'"';
			$modeId = addlistinggetlastid('quotationModeMaster',$modevalue);
		}



		$day++;
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
	//End of the duplicate pard
	

	//star check for rate change
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);

	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];

	date_default_timezone_set('Asia/Kolkata');

	$newfilez = makeQuotationId($lastQuotationData['id']);
	// use above var
	$hotelError = $msgError = "";
	$newDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and addstatus=0 order by srdate asc');
	while($newDaysData=mysqli_fetch_array($newDaysQuery)){

		$cityId = $newDaysData['cityId'];
		$date = date('Y-m-d', strtotime($newDaysData['srdate']));
		$dayId = $newDaysData['id'];

		// check the service price difference
		//---------------------------------------------------------------------
		$b=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" group by serviceType order by srn asc,id desc');
		while($sorting=mysqli_fetch_array($b)){
			if($sorting['serviceType'] == 'hotel'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="hotel" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$sorting1['quotationId'].'" and supplierId="'.$sorting1['serviceId'].'" and dayId="'.$sorting1['dayId'].'" order by id desc');
					$hotelQuotData=mysqli_fetch_array($c);
					$prevSupplementCostAdded = $hotelQuotData['supplementCostAdded'];
					$roomTariffId = $hotelQuotData['roomTariffId'];
					$destinationId = $hotelQuotData['destinationId'];
					$tarifType = $hotelQuotData['tarifType'];
					$roomType = $hotelQuotData['roomType'];

					// hotel data
					$dh=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
					$hotelData=mysqli_fetch_array($dh);
					
					$seasonQuery = "";
					if($dayWise == 2){
						if($queryData['seasonType']!= 3 ){
							$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}else{
							$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}
					}else{
						 $seasonQuery = " and DATE(fromDate)<='".$date."' and  DATE(toDate)>='".$date."'";
					}

					// exit();

					//data from dmc
					//for normal each day
					$dmcrate=0;
 					$normalCheckQuery = "";
					$specialCheckQuery = "";
					$roomTypeFilter = 'and roomType="'.$roomType.'"';
					// check for special days rate
					$wherespc = ' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=3 '.$seasonQuery.' '.$roomTypeFilter.'';
					
					 $specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$wherespc);
				
					if(mysqli_num_rows($specialCheckQuery)>0){
						// if special days rates exist
						$dmcSpecialrate=1;
						$dmcroommastermain=mysqli_fetch_array($specialCheckQuery);
						$dmcroommastermain['tarifType'];
					}else{
						// Check for Weekend Rates
						$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and tarifType="2" '.$seasonQuery.' '.$roomTypeFilter.' and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) ) ');

						if(mysqli_num_rows($weekendCheckQuery)>0){
						$dmcWeekendrate=1;
						$dmcroommastermain=mysqli_fetch_array($weekendCheckQuery);
						}else{
						// Check for Normal Rates
						$normalCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=1 '.$seasonQuery.' '.$roomTypeFilter.'');
						if(mysqli_num_rows($normalCheckQuery)>0){
						$dmcNormalrate=1;
						$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);
						}else{
							$normalratenotexist=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$hotelQuotData['quotationId'].'" and id="'.$hotelQuotData['id'].'" order by id desc');
							$dmcNormalratenotexit=1;
							$dmcroommastermain=mysqli_fetch_array($normalratenotexist);
						}
						
					}
				}
			
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);

					$supplementCostAdded = 0;
					if($dmcSpecialrate==1){
					$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
					$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);

				// }
			  }else{
				$msgError='';
				$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : Special Rate is not available, Normal rate rate is applicable.</p>";
				$hotelError .= $msgError;
				errorlogGenerateQuotation($msgError,$newfilez);
			 }

			 if($dmcWeekendrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
	
			 if($dmcNormalrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  

		 if($dmcNormalratenotexit==1){
			$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
			$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

			$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
			addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
		  
				}
			}

			// hote rate ends

			if($sorting['serviceType'] == 'transfer' || $sorting['serviceType'] == 'transportation'){
				// quotation hotel data
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="transfer" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs2=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$newDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"');
					$transferQuotData=mysqli_fetch_array($rs2);

					$rs2=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');
					$transferData=mysqli_fetch_array($rs2);
					$transferName = ucfirst($transferData['transferCategory'])."-".clean($transferData['transferName']);

					//check for exitance
					$rsa2s=GetPageRecord('*','quotationTransferRateMaster','id="'.$transferQuotData['tariffId'].'"');
					if(mysqli_num_rows($rsa2s)>0){
						$dmcTransferData=mysqli_fetch_array($rsa2s);
					}else{
						$rs1=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$transferQuotData['tariffId'].'"');
						$dmcTransferData=mysqli_fetch_array($rs1);
					}

					if( $dmcTransferData['id'] > 0 && $dmcTransferData['id']!='' ){


						$tarifId = addslashes($dmcTransferData['id']);
						$supplierId = addslashes($dmcTransferData['supplierId']);
						$destinationId = $transferQuotData['destinationId'];
 						$transferCategory = $transferData['transferCategory'];
						$costType= $transferQuotData['costType'];
						$distance= $dmcTransferData['distance'];

						$transferNameId=addslashes($dmcTransferData['transferNameId']);
						$transferType='2';
						$infantsCost=addslashes($dmcTransferData['infantCost']);
						$vehicleTypeId=addslashes($dmcTransferData['vehicleTypeId']);
						$vehicleModelId=addslashes($dmcTransferData['vehicleModelId']);
						$gstTax=addslashes($dmcTransferData['gstTax']);
						$vehicleCost=0;

						if(trim($_REQUEST['noOfDays'])<1){ $noOfDays = 1; }else{ $noOfDays = trim($_REQUEST['noOfDays']); }

						if($dmcTransferData['serviceType']=='transfer'){
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$dmcTransferData['gstTax'])+$vehicleCost);
						}else{
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$gstTax)+$vehicleCost)*$noOfDays;
						}

						$detail=addslashes($dmcTransferData['detail']);
						$currencyId=addslashes($dmcTransferData['currencyId']);

						$namevalue = 'fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$destinationId.'",transferNameId="'.$transferNameId.'",transferType="'.$transferType.'",vehicleType="'.$vehicleTypeId.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",currencyId="'.$currencyId.'",detail="'.$detail.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",tariffId="'.$tarifId.'",parkingFee="'.$dmcTransferData['parkingFee'].'",representativeEntryFee="'.$dmcTransferData['representativeEntryFee'].'",assistance="'.$dmcTransferData['assistance'].'",guideAllowance="'.$dmcTransferData['guideAllowance'].'",interStateAndToll="'.$dmcTransferData['interStateAndToll'].'",miscellaneous="'.$dmcTransferData['miscellaneous'].'",gstTax="'.$dmcTransferData['gstTax'].'",costType="'.$costType.'",distance="'.$distance.'",noOfDays="'.trim($noOfDays).'",dayId="'.$dayId.'",serviceType="'.$transferCategory.'"';
						$lastid = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="'.$transferCategory.'", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);
					}else{

						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".strip($transferName)." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}




				}
			}

			if($sorting['serviceType'] == 'entrance'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="entrance" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'" ';
					$rs1=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$entranceQuotData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id ="'.$entranceQuotData['entranceNameId'].'" ');
						$entranceData=mysqli_fetch_array($otherActivitySql);

						$entranceName = strip($entranceData['entranceName']);
						$entranceNameId = strip($entranceData['id']);
						$marketId = getQueryMaketType($queryId);
						$supplierId = $entranceQuotData['supplierId'];
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
 						$rs1 = GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,' entranceNameId= "'.$entranceNameId.'" and supplierId = "'.$supplierId.'"  and "'.$date.'" BETWEEN fromDate and toDate '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcEntranceData = mysqli_fetch_array($rs1);

							$entranceId=addslashes($dmcEntranceData['id']);
							$detail=addslashes($dmcEntranceData['detail']);
							$ticketAdultCost=addslashes($dmcEntranceData['ticketAdultCost']);
							$ticketchildCost=addslashes($dmcEntranceData['ticketchildCost']);
							$currencyId=addslashes($dmcEntranceData['currencyId']);

							$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",entranceNameId="'.$entranceNameId.'",currencyId="'.$currencyId.'",detail="'.$detail.'",ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",dmcId="'.$entranceId.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_ENTRANCE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="entrance", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);

							// operation restriction detail
							$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}
						}else{
							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}

			if($sorting['serviceType'] == 'activity'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="activity" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);

					if(mysqli_num_rows($rs1)>0){
						$quotationActivityData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*','packageBuilderotherActivityMaster',' id ="'.$quotationActivityData['otherActivityName'].'" ');
						$activityData=mysqli_fetch_array($otherActivitySql);
						$otherActivityName=addslashes($activityData['otherActivityName']);

						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
						$maxpax = $quotationActivityData['maxpax'];
						$supplierId = $quotationActivityData['supplierId'];
						echo $where11=' otherActivityNameId = "'.$activityData['id'].'" and "'.$date.'" BETWEEN fromDate and toDate  and supplierId = "'.$supplierId.'" '.$whereMarket.' ';
						$rs11=GetPageRecord('*','dmcotherActivityRate',$where11);
						if(mysqli_num_rows($rs11)>0){
							$dmcActivityData=mysqli_fetch_array($rs11); 
							
							$activityCost=addslashes($quotationActivityData['activityCost']); 

							$cityName = getDestination($cityId);

							$otherActivityCity=addslashes($quotationActivityData['otherActivityCity']);
							$dateotherActivity=date('Y-m-d',strtotime($quotationActivityData['dateotherActivity']));
							$currencyId=$quotationActivityData['currencyId'];


							$namevalue ='activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",perPaxCost="'.$perPaxCost.'",otherActivityName="'.$dmcActivityData['otherActivityNameId'].'",otherActivityCity="'.$cityName.'",queryId="'.$queryId.'",dateotherActivity="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue);

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="activity", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);

							//show restriction alert
 							$rs21=GetPageRecord('*','hoteloperationRestriction','otheractivityId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate  ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}

				 		}else{
							// show not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}
				}
			}

			if($sorting['serviceType'] == 'guide'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="guide" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$quotationGuideData=mysqli_fetch_array($rs1);

						$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$quotationGuideData['guideId'].'"');
						$guideData = mysqli_fetch_array($rs11);


						$supplierId = $entranceQuotData['supplierId'];
						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
						$guideId = $guideData['id'];
						$rs1 = GetPageRecord('*','dmcGuidePorterRate','  serviceid = "'.$guideId.'" and supplierId = "'.$quotationGuideData['supplierId'].'" '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcGuideData = mysqli_fetch_array($rs1);

							$tariffId = $dmcGuideData['id'];
							$tariffId = $guideData['id'];
							$supplierId = $dmcGuideData['supplierId'];
							$price=addslashes($dmcGuideData['price']);

							$serviceType = $guideCat['serviceType'];
							$totalDays = $quotationGuideData['totalDays'];

							$namevalue ='fromDate="'.$startDate.'",toDate="'.$startDate.'",serviceType="'.$serviceType.'",destinationId="'.$cityId.'",guideId="'.$guideId.'",tariffId="'.$tariffId.'",supplierId="'.$supplierId.'",price="'.($price*$totalDays).'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",totalDays="'.$totalDays.'",perDaycost="'.$price.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_GUIDE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="guide", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);



						}else{

							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Guide Service - ".strip($guideData['name'])." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}

			if($sorting['serviceType'] == 'enroute'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="enroute" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs1=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' id="'.$sorting1['serviceId'].'" and quotationId="'.$lastQuotationId.'" ');
					$quotationEnrouteData = mysqli_fetch_array($rs1);

					$enrouteSql=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$quotationEnrouteData['enrouteId'].'" ');
					if(mysqli_num_rows($enrouteSql)>0){
						$enrouteData=mysqli_fetch_array($enrouteSql);

						$enrouteName =  $enrouteData['enrouteName'];
						$adultCost=addslashes($enrouteData['adultCost']);
						$childCost=addslashes($enrouteData['childCost']);
						$currencyId=addslashes($enrouteData['currencyId']);

						$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",enrouteId="'.$enrouteId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$currencyId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",dayId="'.$startDayId.'"';
						$lastid = addlistinggetlastid(_QUOTATION_ENROUTE_MASTER_,$namevalue);
						// loop for hotel query inserting number of date

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="enroute", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						addlisting('quotationItinerary',$namevalue1);

						if($quotationEnrouteData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}else{
						// rate not available
						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}
				}
			}

			if($sorting['serviceType'] == 'flight'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$flightQuotData = mysqli_fetch_array($rs1);

					$flightId = $flightQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_AIRLINES_MASTER_,'id="'.$flightId.'"');
					$flightData=mysqli_fetch_array($rs1);

					$flightName=addslashes($flightData['flightName']);
					$flightId=addslashes($flightData['id']);
					$childCost=addslashes($flightQuotData['childCost']);
					$adultCost=addslashes($flightQuotData['adultCost']);
					$flightClass=addslashes($flightQuotData['flightClass']);
					$flightNumber=addslashes($flightQuotData['flightNumber']);
					$departureFrom=addslashes($flightQuotData['departureFrom']);
					$arrivalTo=addslashes($flightQuotData['arrivalTo']);
					$departureDate=date('Y-m-d',strtotime($flightQuotData['departureDate']));
					$departureTime=addslashes($flightQuotData['departureTime']);
					$arrivalTime=addslashes($flightQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($flightQuotData['arrivalDate']));

					 $namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",flightId="'.$flightId.'",queryId="'.$queryId.'",destinationId="'.$destinationId.'",quotationId="'.$quotationId.'",departureFrom="'.$departureFrom.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",flightClass="'.$flightClass.'",flightNumber="'.$flightNumber.'",arrivalDate="'.$arrivalDate.'",dayId="'.$dayId.'"';
					$lastid = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="flight", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);

					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Flight - ".$flightName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);

				}
			}

			if($sorting['serviceType'] == 'train'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$trainQuotData = mysqli_fetch_array($rs1);

					$trainId = $trainQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainId.'"');
					$trainData=mysqli_fetch_array($rs1);

					$trainName=addslashes($trainData['trainName']);
					$trainId=addslashes($trainData['id']);
					$childCost=addslashes($trainQuotData['childCost']);
					$adultCost=addslashes($trainQuotData['adultCost']);
					$trainClass=addslashes($trainQuotData['trainClass']);
					$trainNumber=addslashes($trainQuotData['trainNumber']);
					$journeyType=addslashes($trainQuotData['journeyType']);
					$departureFrom=addslashes($trainQuotData['departureFrom']);
					$departureTime=addslashes($trainQuotData['departureTime']);
					$arrivalTime=addslashes($trainQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($trainQuotData['arrivalDate']));
					$departureDate=date('Y-m-d',strtotime($trainQuotData['departureDate']));
					$arrivalTo=addslashes($trainQuotData['arrivalTo']);

					$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",trainId="'.$trainId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$destinationstart.'",departureFrom="'.$departureFrom.'",journeyType="'.$journeyType.'",arrivalTime="'.$arrivalTime.'",arrivalDate="'.$arrivalDate.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",trainClass="'.$trainClass.'",trainNumber="'.$trainNumber.'",dayId="'.$dayId.'"';
					$lastid = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="train", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);


					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Train - ".$trainName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);


				}
			}

			if($sorting['serviceType'] == 'mealplan'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					while($mealplanQuotData=mysqli_fetch_array($rs1)){

						$mealPlanId = $mealplanQuotData['mealPlanName'];
						$rs1=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,'id="'.$mealPlanId.'"');
						$mealplanData=mysqli_fetch_array($rs1);

						$mealPlanName=addslashes($mealplanData['mealPlanName']);
 						$mealType=addslashes($mealplanQuotData['mealPlanmealType']);
						$adultCost=addslashes($mealplanQuotData['mealPlanadultCost']);
						$childCost=addslashes($mealplanQuotData['mealPlanchildCost']);
						$currencyId=addslashes($mealplanQuotData['currencyId']);

						$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",mealType="'.$mealType.'",mealPlanName="'.$mealPlanName.'",destinationId="'.$cityId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
						$lastid = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="mealplan", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						addlisting('quotationItinerary',$namevalue1);
			 			if($mealplanQuotData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Meal Plan - ".$mealPlanName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}
				}
			}

			if($sorting['serviceType'] == 'additional'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="additional" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$ss1=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$lastQuotationData['id'].'" and id="'.$sorting1['serviceId'].'" ');
					$additionalQuotData = mysqli_fetch_array($ss1);

					$rs1=GetPageRecord('*','extraQuotation',"id='".$additionalQuotData['additionalId']."'");
					if(mysqli_num_rows($rs1)>0){
						$additionalData=mysqli_fetch_array($rs1);

						$name=addslashes($additionalData['name']);
						$childCost=addslashes($additionalQuotData['childCost']);
						$adultCost=addslashes($additionalQuotData['adultCost']);
						$groupCost=addslashes($additionalQuotData['groupCost']);

						$namevalue ='adultCost="'.$adultCost.'",childCost="'.$childCost.'",groupCost="'.$groupCost.'",name="'.$name.'",additionalId="'.$additionalId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$cityId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
						// $lastid = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="additional", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						// addlisting('quotationItinerary',$namevalue1);
					}
				}
			}
		}
	}


	//get the alert after process
	//---------------------------------------------------------------------
	// if all day duplicated
	if(mysqli_num_rows($QueryDaysQuery) == $day ){
		if($hotelError != ''){
			$msgError='';
			$msgError = "<p style='color:#D8000C;'>----Log file End----.</p>";
			//danger
			errorlogGenerateQuotation($msgError,$newfilez);
			?>
			<script>
			parent.query_alertbox('action=regenrateQuotationInfo&quotationId=<?php echo encode($lastQuotationData['id']); ?>','700px','auto');
			setTimeout( function(){
				parent.$('#regenrateQuotationInfo').html("<?php echo addslashes($hotelError); ?>");
			}  , 1000 );
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
			</script>
			<?php
		}else{
			?>
			<script>
		 	parent.setupbox('showpage.crm?module=quotations&view=yes&id=<?php echo encode($lastQuotationData['id']); ?>&alt=2');
			</script>
			<?php
		}
	}
}

if(trim($_REQUEST['action'])=='updateAmendCityDrag' && trim($_REQUEST['quotationId'])!='' ){

 	$dayIds=trim($_REQUEST['dayIdArr']);
 	$dayIdArray = explode(',',$dayIds);

	$quotationId=decode($_REQUEST['quotationId']);
	$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$quotationId.'');
	$quotationData=mysqli_fetch_array($rs1);
	$queryId = $quotationData['queryId'];

	$rs1=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($quotationData['queryId']).'');
	$queryData=mysqli_fetch_array($rs1);
	$dayWise = $queryData['dayWise'];
	?>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	<div class="labelBorder" >Current Accommondation</div>
	<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#DDD"  >
	<thead>
	<tr>
	<th width="122px">Sr.No.</th>
	<?php if($dayWise == 1){ ?><th width="194px">Date</th><?php } ?>
	<th width="121px" align="left">Destination</th>
	<th width="131px" align="center">&nbsp;</th>
	</tr>
	</thead>
	<tbody class="row_drag2" onclick="modifyRoute();" >
	<?php
	$n = 1;
	$daydate1 = date('Y-m-d', strtotime("-1 day", strtotime($quotationData['fromDate'])));
	foreach($dayIdArray as $dayId) {
		$srdate = date('Y-m-d',strtotime("+".$n." day", strtotime($daydate1)));

	 	$rs1="";
		$rs1=GetPageRecord('*','newQuotationDays',' id = "'.$dayId.'" and  quotationId="'.$quotationId.'" and tempDeleteStatus!=1');
		if(mysqli_num_rows($rs1) > 0){
			$newQuoteData=mysqli_fetch_array($rs1);

			$NdayId= $newQuoteData["id"];
			$cityId= $newQuoteData["cityId"];
			//update date accordingly
			//$update = updatelisting('newQuotationDays',' srdate="'.$srdate.'" ','id="'.trim($NdayId).'" ');
			?>
			<tr class="row<?php echo $NdayId; ?>" dayId = "<?php echo trim($newQuoteData["id"]); ?>">
			<td width="122px" >Day&nbsp;<?php echo $n; ?></td>
			<?php if($dayWise == 1){ ?>
			<td width="194px"><?php echo date('d-m-Y /D', strtotime($srdate)); ?></td>
			<?php } ?>
			<td width="121px">
			<input type="hidden" value="<?php echo $dayId; ?>" name="dayIdArr[]" />
			<input type="hidden"  class="validate"  value="<?php echo $cityId; ?>" name="cityId[]" />
			<?php
			if($cityId == 0 || $cityId == ''){ ?>
			<select id="destinationId<?php echo $dayId; ?>" name="destinationId[]" class="selectBox" >
				<option value="">Select</option>
				<?php
				$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc');
				while($resListing=mysqli_fetch_array($rs)){
				?>
				<option value="<?php echo strip($resListing['id']); ?>" ><?php echo addslashes($resListing['name']); ?></option>
				<?php } ?>
			</select>
			<?php
			}else{
				echo getDestination($cityId);
			} ?>
			</td>
			<td width="131px" align="center">
				<a class="moveBtn2 drag-handler"><i class="fa fa-arrows-alt" style="color:#CCCCCC;transform: rotate(45deg);"></i></a>
				<?php if($cityId == 0 || $cityId == ''){ ?>
				<a class="moveBtn2 add-row-btn" onclick="saveAmendDay('<?php echo $dayId; ?>');"  ><i class="fa fa-save" style="color: #4caf50;"></i></a>
				<?php } else { ?>
				<a class="moveBtn2 add-row-btn" onclick="addAmendDay('<?php echo $dayId; ?>');";  ><i class="fa fa-plus" style="color: #4caf50;"></i></a>
				<?php } ?>
				<a class="moveBtn2 del-row-btn" onclick="deleteRow('<?php echo $NdayId; ?>');"; ><i class="fa fa-trash" style="color: #F44336;"></i></a>
			</td>
			</tr>
			<?php
		}
		$n++;
	}
	?>
	</tbody>
	</table>
	<?php

}

if(trim($_REQUEST['action'])=='askToRegenrateQuotation_updateAmendCityDrag' && trim($_REQUEST['quotationId'])!=''){

	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.decode($_REQUEST['quotationId']).'"  ');
	$quotationData=mysqli_fetch_array($rsp);

	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];

	$quotationNo = $quotationData['quotationNo'];

	$generateNo  = 1;
	$rsp1=GetPageRecord('generateNo',_QUOTATION_MASTER_,' queryId="'.clean($queryId).'" and quotationNo="'.$quotationNo.'"  order by generateNo desc');
	$generateNoD=mysqli_fetch_array($rsp1);
	if($generateNoD['generateNo']!=''){
		$generateNo = $generateNoD['generateNo']+1;
	}
	$nights = count($_REQUEST['dayIdArr']);

	//duplicate quotation with all servicess
	//------------------------------------------------------------------
	$namevalue ='clientType="'.$quotationData['clientType'].'",queryId="'.$queryId.'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$quotationData['adult'].'",child="'.$quotationData['child'].'",infant="'.$quotationData['infant'].'",sglRoom="'.$quotationData['sglRoom'].'",dblRoom="'.$quotationData['dblRoom'].'",tplRoom="'.$quotationData['tplRoom'].'",twinRoom="'.$quotationData['twinRoom'].'",childwithNoofBed="'.$quotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$quotationData['childwithoutNoofBed'].'",extraNoofBed="'.$quotationData['extraNoofBed'].'",night="'.$nights.'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",deletestatus="'.$quotationData['deletestatus'].'",quotationId="'.$quotationData['quotationId'].'",starRating="'.$quotationData['starRating'].'",status=0,viewQuotation="'.$quotationData['viewQuotation'].'",totalAmount="'.$quotationData['totalAmount'].'",totalquotCostWithMarkup="'.$quotationData['totalquotCostWithMarkup'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",hotelType="'.$quotationData['hotelType'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'",inclusion="'.addslashes($quotationData['inclusion']).'",serviceupgradationText="'.addslashes($quotationData['serviceupgradationText']).'",optionaltourText="'.addslashes($quotationData['optionaltourText']).'",remarks="'.addslashes($quotationData['remarks']).'",paymentpolicy="'.addslashes($quotationData['paymentpolicy']).'",fitGitId="'.addslashes($quotationData['fitGitId']).'",exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.addslashes($quotationData['isInc_exc']).'",quotationNo="'.$quotationNo.'",generateNo="'.$generateNo.'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",saveQuotaiton="'.$quotationData['saveQuotaiton'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",languageId="'.$quotationData['languageId'].'",deletestatusDuplicate="'.$quotationData['deletestatusDuplicate'].'",propIMGNum3="'.$quotationData['propIMGNum3'].'",propIMGNum4="'.$quotationData['propIMGNum4'].'",propIMGNum6="'.$quotationData['propIMGNum6'].'",onlyTFS="'.$quotationData['onlyTFS'].'",visaRequired="'.$quotationData['visaRequired'].'",flightRequired="'.$quotationData['flightRequired'].'",transferRequired="'.$quotationData['transferRequired'].'",passportRequired="'.$quotationData['passportRequired'].'",insuranceRequired="'.$quotationData['insuranceRequired'].'",visaCostType="'.$quotationData['visaCostType'].'",passportCostType="'.$quotationData['passportCostType'].'",insuranceCostType="'.$quotationData['insuranceCostType'].'",dayWise="'.$quotationData['dayWise'].'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'",packageSupplier="'.$quotationData['packageSupplier'].'",tcs="'.$quotationData['tcs'].'"';

	$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);

	// update previous quotaion tourDate with his old date /
	$QueryDaysQuery1=GetPageRecord('min(srdate) as fromDate, max(srdate) as toDate ','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus = 0');
	$QueryDaysData1=mysqli_fetch_array($QueryDaysQuery1);

	$where='id='.trim($quotationId).'';
	$namevalue ='fromDate="'.$QueryDaysData1['fromDate'].'",toDate="'.$QueryDaysData1['toDate'].'",isRegenerated=0';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);

	//regenerate with new date
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);

	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];
	// use above var

	if($quotationData['flightRequired']==2){
		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isFlightTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)){
			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$transferRes['toDate'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",totalAdultCost="'.$transferRes['totalAdultCost'].'",adultTax="'.$transferRes['adultTax'].'",totalChildCost="'.$transferRes['totalChildCost'].'",childTax="'.$transferRes['childTax'].'",totalInfantCost="'.$transferRes['totalInfantCost'].'",infantTax="'.$transferRes['infantTax'].'",cancellationPolicy="'.$transferRes['cancellationPolicy'].'",isFlightTaken="'.$transferRes['isFlightTaken'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
		}
	}
		

	// Transfer service Copy
	if($quotationData['transferRequired']==2){
		$b=''; 
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isTransferTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){ 
			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id']; 
				$addHotel = '';

				$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",tariffId="'.$transferRes['tariffId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isTransferTaken="'.$transferRes['isTransferTaken'].'",distance="'.$transferRes['distance'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}
	}

	
	// Value Added Services Start
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
	
	$day = 0;
	$dayIdArr = $_REQUEST['dayIdArr'];
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and tempDeleteStatus=0 order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
		$srdate = date('Y-m-d',strtotime("+".$day." day", strtotime($fromDate)));
		$dayId  = $dayIdArr[$day];
		//$srdate = $QueryDaysData['srdate'];
 		if($dayId > 0){
			$rs1="";
			$rs1=GetPageRecord('*','newQuotationDays',' id = "'.$dayId.'" and quotationId="'.$quotationId.'" and tempDeleteStatus=0 order by srdate asc');
			$newQuoteData=mysqli_fetch_array($rs1);

			$newDayId='';
			$namevalue =' queryId="'.$newQuoteData['queryId'].'",cityId="'.$newQuoteData['cityId'].'",title="'.$newQuoteData['title'].'",description="'.$newQuoteData['description'].'",quotationId="'.$lastQuotationId.'",srdate="'.$srdate.'"';
			$newDayId = addlistinggetlastid('newQuotationDays',$namevalue);
		}

		$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
		while($HotelRes=mysqli_fetch_array($b)){
			// normal and escort
			$namevalue ='';
			$addHotel ='';
			$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$HotelRes['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",hotelTypeId="'.$HotelRes['hotelTypeId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",currencyValue="'.$HotelRes['currencyValue'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomprice="'.$HotelRes['roomprice'].'",noofrooms="'.$HotelRes['noofrooms'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",quadoccupancy="'.$HotelRes['quadoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'", sglMarkup="'.$HotelRes['sglMarkup'].'", dblMarkup="'.$HotelRes['dblMarkup'].'", tplMarkup="'.$HotelRes['tplMarkup'].'", cwbMarkup="'.$HotelRes['cwbMarkup'].'", quadMarkup="'.$HotelRes['quadMarkup'].'", cnbMarkup="'.$HotelRes['cnbMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",mealMarkup="'.$HotelRes['mealMarkup'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",rand_color="'.$HotelRes['rand_color'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",breakfast="'.$HotelRes['breakfast'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",taxType="'.$HotelRes['taxType'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",singleNoofRoom="'.$HotelRes['singleNoofRoom'].'",doubleNoofRoom="'.$HotelRes['doubleNoofRoom'].'",twinNoofRoom="'.$HotelRes['twinNoofRoom'].'",tripleNoofRoom="'.$HotelRes['tripleNoofRoom'].'",extraNoofBed="'.$HotelRes['extraNoofBed'].'",childwithNoofBed="'.$HotelRes['childwithNoofBed'].'",childwithoutNoofBed="'.$HotelRes['childwithoutNoofBed'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isEarlyCheckin="'.$HotelRes['isEarlyCheckin'].'",sixBedRoom="'.$HotelRes['sixBedRoom'].'",eightBedRoom="'.$HotelRes['eightBedRoom'].'",tenBedRoom="'.$HotelRes['tenBedRoom'].'",quadRoom="'.$HotelRes['quadRoom'].'",teenRoom="'.$HotelRes['teenRoom'].'",childBreakfast="'.$HotelRes['childBreakfast'].'",childDinner="'.$HotelRes['childDinner'].'",childLunch="'.$HotelRes['childLunch'].'",sixNoofBedRoom="'.$HotelRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$HotelRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$HotelRes['tenNoofBedRoom'].'",quadNoofRoom="'.$HotelRes['quadNoofRoom'].'",teenNoofRoom="'.$HotelRes['teenNoofRoom'].'",isChildBreakfast="'.$HotelRes['isChildBreakfast'].'",isChildLunch="'.$HotelRes['isChildLunch'].'",isChildDinner="'.$HotelRes['isChildDinner'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

			$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
			if(mysqli_num_rows($check_h)==0){
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			} 
 

			// supplement
			$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
			while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
				$namevalue ='';
				$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$hotelSuppD['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",hotelTypeId="'.$hotelSuppD['hotelTypeId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",currencyValue="'.$hotelSuppD['currencyValue'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",quadoccupancy="'.$hotelSuppD['quadoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'", sglMarkup="'.$hotelSuppD['sglMarkup'].'", dblMarkup="'.$hotelSuppD['dblMarkup'].'", tplMarkup="'.$hotelSuppD['tplMarkup'].'", cwbMarkup="'.$hotelSuppD['cwbMarkup'].'", quadMarkup="'.$hotelSuppD['quadMarkup'].'", cnbMarkup="'.$hotelSuppD['cnbMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",mealMarkup="'.$hotelSuppD['mealMarkup'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",taxType="'.$hotelSuppD['taxType'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isEarlyCheckin="'.$hotelSuppD['isEarlyCheckin'].'",sixBedRoom="'.$hotelSuppD['sixBedRoom'].'",eightBedRoom="'.$hotelSuppD['eightBedRoom'].'",tenBedRoom="'.$hotelSuppD['tenBedRoom'].'",quadRoom="'.$hotelSuppD['quadRoom'].'",teenRoom="'.$hotelSuppD['teenRoom'].'",childBreakfast="'.$hotelSuppD['childBreakfast'].'",childDinner="'.$hotelSuppD['childDinner'].'",childLunch="'.$hotelSuppD['childLunch'].'",sixNoofBedRoom="'.$hotelSuppD['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelSuppD['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelSuppD['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelSuppD['quadNoofRoom'].'",teenNoofRoom="'.$hotelSuppD['teenNoofRoom'].'",isChildBreakfast="'.$hotelSuppD['isChildBreakfast'].'",isChildLunch="'.$hotelSuppD['isChildLunch'].'",isChildDinner="'.$hotelSuppD['isChildDinner'].'"';
				$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

				$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
				if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
					$namevalue ='';
					$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$srdate.'",endDate="'.$srdate.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
				}
			}


			$qhaQuery=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$HotelRes['id'].'"  and quotationId="'.$QueryDaysData['quotationId'].'" order by id asc');
			while($qhAData=mysqli_fetch_array($qhaQuery)){

				$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",hotelId="'.$qhAData['hotelId'].'",additionalCost="'.$qhAData['additionalCost'].'",name="'.$qhAData['name'].'",hotelQuotId="'.$addHotel.'",additionalId="'.$qhAData['additionalId'].'",costType="'.$qhAData['costType'].'",queryId="'.$qhAData['queryId'].'",destinationId="'.$qhAData['destinationId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",currencyId="'.$qhAData['currencyId'].'",currencyValue="'.$qhAData['currencyValue'].'",rateId="'.$qhAData['rateId'].'"';
				addlistinggetlastid('quotationHotelAdditionalMaster',$namevalue);
			}

		}

		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				 

				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				
				$addHotel = ''; 
				$transfernamevalue ='fromDate="'.$srdate.'",toDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					 $transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					
				}
				
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}

		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="transportation" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				
				$addHotel = ''; 
				$transfernamevalue ='fromDate="'.$srdate.'",toDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					 $transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					

				}
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}


		$b=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="guide" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			
			$bb2='';
			$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
			$paxSlabData2=mysqli_fetch_array($bb2);
			$totalPaxId = $paxSlabData2['id'];
			
			$addHotel =''; 
			$transfernamevalue ='guideId="'.$transferRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferRes['price'].'",guideName="'.$transferRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferRes['srn'].'",destinationId="'.$transferRes['destinationId'].'",rules="'.$transferRes['rules'].'",category="'.$transferRes['category'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",subcategory="'.$transferRes['subcategory'].'",totalDays="'.$transferRes['totalDays'].'",perDaycost="'.$transferRes['perDaycost'].'",serviceType="'.$transferRes['serviceType'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",guideQuoteId="'.$transferRes['guideQuoteId'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",paxRange="'.$transferRes['paxRange'].'",dayType="'.$transferRes['dayType'].'",markupCost="'.$transferRes['markupCost'].'",dayId="'.$newDayId.'"';

			$addHotel = addlistinggetlastid('quotationGuideMaster',$transfernamevalue);

			$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$dayId.'"  and guideQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
			while($transferSuppRes=mysqli_fetch_array($bSupp)){
				$suppGuidevalue ='guideId="'.$transferSuppRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",currencyValue="'.$transferSuppRes['currencyValue'].'",guideQuoteId="'.$addHotel.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",markupCost="'.$transferSuppRes['markupCost'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$newDayId.'"';
	
				$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
			
			}

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
		 
		}


		$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",activityCost="'.$transferRes['activityCost'].'",maxpax="'.$transferRes['maxpax'].'",perPaxCost="'.$transferRes['perPaxCost'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",markupCost="'.$transferRes['markupCost'].'",transferType="'.$transferRes['transferType'].'",slabId="'.$transferRes['slabId'].'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",vehicleId="'.$transferRes['vehicleId'].'",repCost="'.$transferRes['repCost'].'",tarifType="'.$transferRes['tarifType'].'",nationality="'.$transferRes['nationality'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$transfernamevalue);
			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="activity",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationActivityTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1); 
				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationActivityTimelineDetails',$namevalue);

			}
		}


		$b=GetPageRecord('*','quotationEnrouteMaster',' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="enroute" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel ='';
			$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
		}


		$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",destinationId="'.$transferRes['destinationId'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",transferType="'.$transferRes['transferType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",markupCost="'.$transferRes['markupCost'].'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid('quotationEntranceMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="entrance",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1);

				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);
			}
		}

		// Duplicate Ferry
		$b=GetPageRecord('*','quotationFerryMaster','quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="ferry" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$ferrynamevalue ='ferryNameId="'.$transferRes['ferryNameId'].'",serviceid="'.$transferRes['serviceid'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",ferryClass="'.$transferRes['ferryClass'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",ferryCost="'.$transferRes['ferryCost'].'",processingfee="'.$transferRes['processingfee'].'",miscCost="'.$transferRes['miscCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",pickupTime="'.$transferRes['pickupTime'].'",dropTime="'.$transferRes['dropTime'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",remark="'.$transferRes['remark'].'",rateId="'.$transferRes['rateId'].'",timeId="'.$transferRes['timeId'].'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid('quotationFerryMaster',$ferrynamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="ferry",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
		}


		$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",destinationId="'.$transferRes['destinationId'].'",markupCost="'.$transferRes['markupCost'].'",fromDate="'.$srdate.'",toDate="'.$srdate.'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$srdate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srdate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$srdate.'",quotationId="'.$lastQuotationId.'",toDate="'.$srdate.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",trainId="'.$transferRes['trainId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="train",startDate="'.$srdate.'",endDate="'.$srdate.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$dayId.'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='name="'.$transferRes['name'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$queryId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",costType="'.$transferRes['costType'].'",additionalId="'.$transferRes['additionalId'].'",markupCost="'.$transferRes['markupCost'].'",dayId="'.$newDayId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$transfernamevalue);


				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="additional",startDate="'.$srdate.'",endDate="'.$srdate.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
		}

		$b='';
		$b=GetPageRecord('*','quotationModeMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" order by id asc');
		if(mysqli_num_rows($b)>0){
			$transferRes=mysqli_fetch_array($b);
			$addHotel = '';
			$modevalue ='name="'.$transferRes['name'].'",dayId="'.$newDayId.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'"';
			$modeId = addlistinggetlastid('quotationModeMaster',$modevalue);
		}


		$day++;
	}

	// undelete the days which temp deleted of parent quotation
	updatelisting('newQuotationDays','tempDeleteStatus=0','tempDeleteStatus=1 and quotationId="'.$quotationId.'"');

	// update for amended day
	$rsp="";
	$rsp=GetPageRecord(' MIN(srdate) AS fromDate2, MAX(srdate) AS toDate2 ','newQuotationDays',' quotationId="'.$lastQuotationId.'"  ');
	$updQuoteDays=mysqli_fetch_array($rsp);
	$update = updatelisting(_QUOTATION_MASTER_,' fromDate="'.$updQuoteDays['fromDate2'].'",toDate="'.$updQuoteDays['toDate2'].'" ','id="'.trim($lastQuotationId).'" ');


	$b='';
	$b=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationId.'" order by id asc');
	if(mysqli_num_rows($b)>0){
		$transferRes=mysqli_fetch_array($b);
		$addHotel = '';
		$modevalue = ' markupCost="'.$transferRes['markupCost'].'", curren="'.$transferRes['curren'].'", quotationId="'.$lastQuotationId.'", package="'.$transferRes['package'].'", hotel="'.$transferRes['hotel'].'", guide="'.$transferRes['guide'].'", activity="'.$transferRes['activity'].'", entrance="'.$transferRes['entrance'].'", transfer="'.$transferRes['transfer'].'", train="'.$transferRes['train'].'",flight="'.$transferRes['flight'].'", restaurant="'.$transferRes['restaurant'].'",ferry="'.$transferRes['ferry'].'",visa="'.$transferRes['visa'].'",passport="'.$transferRes['passport'].'",insurance="'.$transferRes['insurance'].'",other="'.$transferRes['other'].'",packageMarkupType="'.$transferRes['packageMarkupType'].'",hotelMarkupType="'.$transferRes['hotelMarkupType'].'",guideMarkupType="'.$transferRes['guideMarkupType'].'",activityMarkupType="'.$transferRes['activityMarkupType'].'",entranceMarkupType="'.$transferRes['entranceMarkupType'].'",transferMarkupType="'.$transferRes['transferMarkupType'].'",trainMarkupType="'.$transferRes['trainMarkupType'].'",flightMarkupType="'.$transferRes['flightMarkupType'].'",restaurantMarkupType="'.$transferRes['restaurantMarkupType'].'",ferryMarkupType="'.$transferRes['ferryMarkupType'].'",otherMarkupType="'.$transferRes['otherMarkupType'].'",visaMarkupType="'.$transferRes['visaMarkupType'].'",passportMarkupType="'.$transferRes['passportMarkupType'].'",insuranceMarkupType="'.$transferRes['insuranceMarkupType'].'",status="'.$transferRes['status'].'"';
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
	//End of the duplicate pard



	//star check for rate change
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);

	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];

	date_default_timezone_set('Asia/Kolkata');

	$newfilez = makeQuotationId($lastQuotationData['id']);
	// use above var
	$hotelError = $msgError = "";
	$newDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and addstatus=0 order by srdate asc');
	while($newDaysData=mysqli_fetch_array($newDaysQuery)){

		$cityId = $newDaysData['cityId'];
		$date = date('Y-m-d', strtotime($newDaysData['srdate']));
		$dayId = $newDaysData['id'];

		// check the service price difference
		//---------------------------------------------------------------------
		$b=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" group by serviceType order by srn asc,id desc');
		while($sorting=mysqli_fetch_array($b)){
			if($sorting['serviceType'] == 'hotel'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="hotel" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$sorting1['quotationId'].'" and supplierId="'.$sorting1['serviceId'].'" and dayId="'.$sorting1['dayId'].'" order by id desc');
					$hotelQuotData=mysqli_fetch_array($c);
					$prevSupplementCostAdded = $hotelQuotData['supplementCostAdded'];
					$roomTariffId = $hotelQuotData['roomTariffId'];
					$destinationId = $hotelQuotData['destinationId'];
					$tarifType = $hotelQuotData['tarifType'];
					$roomType = $hotelQuotData['roomType'];
					// hotel data
					$dh=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
					$hotelData=mysqli_fetch_array($dh);
					
					$seasonQuery = "";
					if($dayWise == 2){
						if($queryData['seasonType']!= 3){
							$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}else{
							$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}
					}else{
						 $seasonQuery = " and DATE(fromDate)<='".$date."' and  DATE(toDate)>='".$date."'";
					}

					// exit();

					//data from dmc
					//for normal each day
					$dmcrate=0;
 					$normalCheckQuery = "";
					$specialCheckQuery = "";
					$roomTypeFilter = 'and roomType="'.$roomType.'"';
					// check for special days rate
					$wherespc = ' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=3 '.$seasonQuery.' '.$roomTypeFilter.'';
					
					 $specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$wherespc);
				
					if(mysqli_num_rows($specialCheckQuery)>0){
						// if special days rates exist
						$dmcSpecialrate=1;
						$dmcroommastermain=mysqli_fetch_array($specialCheckQuery);
						$dmcroommastermain['tarifType'];
					}else{
						// Check for Weekend Rates
						$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and tarifType="2" '.$seasonQuery.' '.$roomTypeFilter.' and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) ) ');

						if(mysqli_num_rows($weekendCheckQuery)>0){
						$dmcWeekendrate=1;
						$dmcroommastermain=mysqli_fetch_array($weekendCheckQuery);
						}else{
						// Check for Normal Rates
						$normalCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=1 '.$seasonQuery.' '.$roomTypeFilter.'');
						if(mysqli_num_rows($normalCheckQuery)>0){
						$dmcNormalrate=1;
						$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);
						}else{
							$normalratenotexist=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$hotelQuotData['quotationId'].'" and id="'.$hotelQuotData['id'].'" order by id desc');
							$dmcNormalratenotexit=1;
							$dmcroommastermain=mysqli_fetch_array($normalratenotexist);
						}
						
					}
				}
			
					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);

					$supplementCostAdded = 0;
					if($dmcSpecialrate==1){
					$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
					$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);

				// }
			  }else{
				$msgError='';
				$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : Special Rate is not available, Normal rate rate is applicable.</p>";
				$hotelError .= $msgError;
				errorlogGenerateQuotation($msgError,$newfilez);
			 }

			 if($dmcWeekendrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
	
			 if($dmcNormalrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  

		 if($dmcNormalratenotexit==1){
			$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
			$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

			$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
			addlisting('quotationItinerary',$namevalue1);

			// }
		  }

		//end query--------------------
				}
			}
			if($sorting['serviceType'] == 'transfer' || $sorting['serviceType'] == 'transportation'){
				// quotation hotel data
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="transfer" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs2=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$newDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"');
					$transferQuotData=mysqli_fetch_array($rs2);

					$rs2=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');
					$transferData=mysqli_fetch_array($rs2);
					$transferName = ucfirst($transferData['transferCategory'])."-".clean($transferData['transferName']);

					//check for exitance
					$rsa2s=GetPageRecord('*','quotationTransferRateMaster','id="'.$transferQuotData['tariffId'].'"');
					if(mysqli_num_rows($rsa2s)>0){
						$dmcTransferData=mysqli_fetch_array($rsa2s);
					}else{
						$rs1=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$transferQuotData['tariffId'].'"');
						$dmcTransferData=mysqli_fetch_array($rs1);
					}

					if( $dmcTransferData['id'] > 0 && $dmcTransferData['id']!='' ){


						$tarifId = addslashes($dmcTransferData['id']);
						$supplierId = addslashes($dmcTransferData['supplierId']);
						$destinationId = $transferQuotData['destinationId'];
 						$transferCategory = $transferData['transferCategory'];
						$costType= $transferQuotData['costType'];
						$distance= $dmcTransferData['distance'];

						$transferNameId=addslashes($dmcTransferData['transferNameId']);
						$transferType='2';
						$infantsCost=addslashes($dmcTransferData['infantCost']);
						$vehicleTypeId=addslashes($dmcTransferData['vehicleTypeId']);
						$vehicleModelId=addslashes($dmcTransferData['vehicleModelId']);
						$gstTax=addslashes($dmcTransferData['gstTax']);
						$vehicleCost=0;

						if(trim($_REQUEST['noOfDays'])<1){ $noOfDays = 1; }else{ $noOfDays = trim($_REQUEST['noOfDays']); }

						if($dmcTransferData['serviceType']=='transfer'){
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$dmcTransferData['gstTax'])+$vehicleCost);
						}else{
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$gstTax)+$vehicleCost)*$noOfDays;
						}

						$detail=addslashes($dmcTransferData['detail']);
						$currencyId=addslashes($dmcTransferData['currencyId']);

						$namevalue = 'fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$destinationId.'",transferNameId="'.$transferNameId.'",transferType="'.$transferType.'",vehicleType="'.$vehicleTypeId.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",currencyId="'.$currencyId.'",detail="'.$detail.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",tariffId="'.$tarifId.'",parkingFee="'.$dmcTransferData['parkingFee'].'",representativeEntryFee="'.$dmcTransferData['representativeEntryFee'].'",assistance="'.$dmcTransferData['assistance'].'",guideAllowance="'.$dmcTransferData['guideAllowance'].'",interStateAndToll="'.$dmcTransferData['interStateAndToll'].'",miscellaneous="'.$dmcTransferData['miscellaneous'].'",gstTax="'.$dmcTransferData['gstTax'].'",costType="'.$costType.'",distance="'.$distance.'",noOfDays="'.trim($noOfDays).'",dayId="'.$dayId.'",serviceType="'.$transferCategory.'"';
						//$lastid = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="'.$transferCategory.'", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						//	addlisting('quotationItinerary',$namevalue1);
					}else{

						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".strip($transferName)." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}




				}
			}
			if($sorting['serviceType'] == 'entrance'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="entrance" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'" ';
					$rs1=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$entranceQuotData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id ="'.$entranceQuotData['entranceNameId'].'" ');
						$entranceData=mysqli_fetch_array($otherActivitySql);

						$entranceName = strip($entranceData['entranceName']);
						$entranceNameId = strip($entranceData['id']);
						$marketId = getQueryMaketType($queryId);
						$supplierId = $entranceQuotData['supplierId'];
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
 						$rs1 = GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,' entranceNameId= "'.$entranceNameId.'" and supplierId = "'.$supplierId.'"  and "'.$date.'" BETWEEN fromDate and toDate '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcEntranceData = mysqli_fetch_array($rs1);

							$entranceId=addslashes($dmcEntranceData['id']);
							$detail=addslashes($dmcEntranceData['detail']);
							$ticketAdultCost=addslashes($dmcEntranceData['ticketAdultCost']);
							$ticketchildCost=addslashes($dmcEntranceData['ticketchildCost']);
							$currencyId=addslashes($dmcEntranceData['currencyId']);

							$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",entranceNameId="'.$entranceNameId.'",currencyId="'.$currencyId.'",detail="'.$detail.'",ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",dmcId="'.$entranceId.'",dayId="'.$dayId.'"';
							//$lastid = addlistinggetlastid(_QUOTATION_ENTRANCE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="entrance", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							//addlisting('quotationItinerary',$namevalue1);

							// operation restriction detail
							$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}
						}else{
							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}
			if($sorting['serviceType'] == 'activity'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="activity" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);

					if(mysqli_num_rows($rs1)>0){
						$quotationActivityData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*','packageBuilderotherActivityMaster',' id ="'.$quotationActivityData['otherActivityName'].'" ');
						$activityData=mysqli_fetch_array($otherActivitySql);
						$otherActivityName=addslashes($activityData['otherActivityName']);

						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
						$maxpax = $quotationActivityData['maxpax'];
						$supplierId = $quotationActivityData['supplierId'];
						echo $where11=' otherActivityNameId = "'.$activityData['id'].'" and "'.$date.'" BETWEEN fromDate and toDate and maxpax = "'.$maxpax.'" and supplierId = "'.$supplierId.'" '.$whereMarket.' ';
						$rs11=GetPageRecord('*','dmcotherActivityRate',$where11);
						if(mysqli_num_rows($rs11)>0){
							$dmcActivityData=mysqli_fetch_array($rs11);


							$activityCost=addslashes($quotationActivityData['activityCost']);
							$maxpax=addslashes($quotationActivityData['maxpax']);
							$perPaxCost=addslashes($quotationActivityData['perPaxCost']);

							$cityName = getDestination($cityId);

							$otherActivityCity=addslashes($quotationActivityData['otherActivityCity']);
							$dateotherActivity=date('Y-m-d',strtotime($quotationActivityData['dateotherActivity']));
							$currencyId=$quotationActivityData['currencyId'];


							$namevalue ='activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",perPaxCost="'.$perPaxCost.'",otherActivityName="'.$dmcActivityData['otherActivityNameId'].'",otherActivityCity="'.$cityName.'",queryId="'.$queryId.'",dateotherActivity="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
							//$lastid = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue);

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="activity", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							//addlisting('quotationItinerary',$namevalue1);

							//show restriction alert
 							$rs21=GetPageRecord('*','hoteloperationRestriction','otheractivityId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate  ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}

				 		}else{
							// show not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}
				}
			}
			if($sorting['serviceType'] == 'guide'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="guide" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$quotationGuideData=mysqli_fetch_array($rs1);

						$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$quotationGuideData['guideId'].'"');
						$guideData = mysqli_fetch_array($rs11);


						$supplierId = $entranceQuotData['supplierId'];
						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
						$guideId = $guideData['id'];
						$rs1 = GetPageRecord('*','dmcGuidePorterRate','  serviceid = "'.$guideId.'" and supplierId = "'.$quotationGuideData['supplierId'].'" '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcGuideData = mysqli_fetch_array($rs1);

							$tariffId = $dmcGuideData['id'];
							$tariffId = $guideData['id'];
							$supplierId = $dmcGuideData['supplierId'];
							$price=addslashes($dmcGuideData['price']);

							$serviceType = $guideCat['serviceType'];
							$totalDays = $quotationGuideData['totalDays'];

							$namevalue ='fromDate="'.$startDate.'",toDate="'.$startDate.'",serviceType="'.$serviceType.'",destinationId="'.$cityId.'",guideId="'.$guideId.'",tariffId="'.$tariffId.'",supplierId="'.$supplierId.'",price="'.($price*$totalDays).'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",totalDays="'.$totalDays.'",perDaycost="'.$price.'",dayId="'.$dayId.'"';
							//$lastid = addlistinggetlastid(_QUOTATION_GUIDE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="guide", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							//addlisting('quotationItinerary',$namevalue1);



						}else{

							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Guide Service - ".strip($guideData['name'])." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}
			if($sorting['serviceType'] == 'enroute'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="enroute" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs1=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' id="'.$sorting1['serviceId'].'" and quotationId="'.$lastQuotationId.'" ');
					$quotationEnrouteData = mysqli_fetch_array($rs1);

					$enrouteSql=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$quotationEnrouteData['enrouteId'].'" ');
					if(mysqli_num_rows($enrouteSql)>0){
						$enrouteData=mysqli_fetch_array($enrouteSql);

						$enrouteName =  $enrouteData['enrouteName'];
						$adultCost=addslashes($enrouteData['adultCost']);
						$childCost=addslashes($enrouteData['childCost']);
						$currencyId=addslashes($enrouteData['currencyId']);

						$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",enrouteId="'.$enrouteId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$currencyId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",dayId="'.$startDayId.'"';
						//$lastid = addlistinggetlastid(_QUOTATION_ENROUTE_MASTER_,$namevalue);
						// loop for hotel query inserting number of date

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="enroute", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						//addlisting('quotationItinerary',$namevalue1);

						if($quotationEnrouteData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}else{
						// rate not available
						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}
				}
			}
			if($sorting['serviceType'] == 'flight'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$flightQuotData = mysqli_fetch_array($rs1);

					$flightId = $flightQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_AIRLINES_MASTER_,'id="'.$flightId.'"');
					$flightData=mysqli_fetch_array($rs1);

					$flightName=addslashes($flightData['flightName']);
					$flightId=addslashes($flightData['id']);
					$childCost=addslashes($flightQuotData['childCost']);
					$adultCost=addslashes($flightQuotData['adultCost']);
					$flightClass=addslashes($flightQuotData['flightClass']);
					$flightNumber=addslashes($flightQuotData['flightNumber']);
					$departureFrom=addslashes($flightQuotData['departureFrom']);
					$arrivalTo=addslashes($flightQuotData['arrivalTo']);
					$departureDate=date('Y-m-d',strtotime($flightQuotData['departureDate']));
					$departureTime=addslashes($flightQuotData['departureTime']);
					$arrivalTime=addslashes($flightQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($flightQuotData['arrivalDate']));

					 $namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",flightId="'.$flightId.'",queryId="'.$queryId.'",destinationId="'.$destinationId.'",quotationId="'.$quotationId.'",departureFrom="'.$departureFrom.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",flightClass="'.$flightClass.'",flightNumber="'.$flightNumber.'",arrivalDate="'.$arrivalDate.'",dayId="'.$dayId.'"';
					//$lastid = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="flight", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					//addlisting('quotationItinerary',$namevalue1);

					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Flight - ".$flightName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);

				}
			}
			if($sorting['serviceType'] == 'train'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$trainQuotData = mysqli_fetch_array($rs1);

					$trainId = $trainQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainId.'"');
					$trainData=mysqli_fetch_array($rs1);

					$trainName=addslashes($trainData['trainName']);
					$trainId=addslashes($trainData['id']);
					$childCost=addslashes($trainQuotData['childCost']);
					$adultCost=addslashes($trainQuotData['adultCost']);
					$trainClass=addslashes($trainQuotData['trainClass']);
					$trainNumber=addslashes($trainQuotData['trainNumber']);
					$journeyType=addslashes($trainQuotData['journeyType']);
					$departureFrom=addslashes($trainQuotData['departureFrom']);
					$departureTime=addslashes($trainQuotData['departureTime']);
					$arrivalTime=addslashes($trainQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($trainQuotData['arrivalDate']));
					$departureDate=date('Y-m-d',strtotime($trainQuotData['departureDate']));
					$arrivalTo=addslashes($trainQuotData['arrivalTo']);

					$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",trainId="'.$trainId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$destinationstart.'",departureFrom="'.$departureFrom.'",journeyType="'.$journeyType.'",arrivalTime="'.$arrivalTime.'",arrivalDate="'.$arrivalDate.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",trainClass="'.$trainClass.'",trainNumber="'.$trainNumber.'",dayId="'.$dayId.'"';
					//$lastid = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="train", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					//addlisting('quotationItinerary',$namevalue1);


					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Train - ".$trainName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);


				}
			}
			if($sorting['serviceType'] == 'mealplan'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					while($mealplanQuotData=mysqli_fetch_array($rs1)){

						$mealPlanId = $mealplanQuotData['mealPlanName'];
						$rs1=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,'id="'.$mealPlanId.'"');
						$mealplanData=mysqli_fetch_array($rs1);

						$mealPlanName=addslashes($mealplanData['mealPlanName']);
 						$mealType=addslashes($mealplanQuotData['mealPlanmealType']);
						$adultCost=addslashes($mealplanQuotData['mealPlanadultCost']);
						$childCost=addslashes($mealplanQuotData['mealPlanchildCost']);
						$currencyId=addslashes($mealplanQuotData['currencyId']);

						$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",mealType="'.$mealType.'",mealPlanName="'.$mealPlanName.'",destinationId="'.$cityId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
						// $lastid = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="mealplan", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						//addlisting('quotationItinerary',$namevalue1);
			 			/*if($mealplanQuotData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Meal Plan - ".$mealPlanName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}*/

					}
				}
			}
			if($sorting['serviceType'] == 'additional'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="additional" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$ss1=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$lastQuotationData['id'].'" and id="'.$sorting1['serviceId'].'" ');
					$additionalQuotData = mysqli_fetch_array($ss1);

					$rs1=GetPageRecord('*','extraQuotation',"id='".$additionalQuotData['additionalId']."'");
					if(mysqli_num_rows($rs1)>0){
						$additionalData=mysqli_fetch_array($rs1);

						$name=addslashes($additionalData['name']);
						$childCost=addslashes($additionalQuotData['childCost']);
						$adultCost=addslashes($additionalQuotData['adultCost']);
						$groupCost=addslashes($additionalQuotData['groupCost']);

						$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",groupCost="'.$groupCost.'",name="'.$name.'",additionalId="'.$additionalId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$cityId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
						//$lastid = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="additional", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						//addlisting('quotationItinerary',$namevalue1);
					 }
				}

			}

		}

	}


	//get the alert after process
	//---------------------------------------------------------------------
	// if all day duplicated
	if(mysqli_num_rows($QueryDaysQuery) == $day ){
		if($hotelError != ''){
			$msgError='';
			$msgError = "<p style='color:#D8000C;'>----Log file End----.</p>";
			//danger
			errorlogGenerateQuotation($msgError,$newfilez);
			?>
			<script>
			parent.query_alertbox('action=regenrateQuotationInfo&quotationId=<?php echo encode($lastQuotationData['id']); ?>','700px','auto');
			setTimeout( function(){
				parent.$('#regenrateQuotationInfo').html("<?php echo addslashes($hotelError); ?>");
			}  , 1000 );
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
			</script>
			<?php
		}else{
			?>
			<script>
		 	parent.setupbox('showpage.crm?module=quotations&view=yes&id=<?php echo encode($lastQuotationData['id']); ?>&alt=2');
			</script>
			<?php
		}
	}
}

if(trim($_REQUEST['action'])=='addAmendCity_row' && trim($_REQUEST['quotationId'])!='' ){

	$quotationId=decode($_REQUEST['quotationId']);
	$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$quotationId.'');
	$quotationData=mysqli_fetch_array($rs1);
	$queryId = $quotationData['queryId'];

	$rs1=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($quotationData['queryId']).'');
	$queryData=mysqli_fetch_array($rs1);
	$dayWise = $queryData['dayWise'];
	$dayId = $_REQUEST['dayId'];

	$rs1=GetPageRecord('max(srdate) as daydate, count(id) as tn ','newQuotationDays',' quotationId="'.$quotationId.'"');
	$daydateD=mysqli_fetch_array($rs1);
	$dayDate1 = date('Y-m-d', strtotime("+1 day", strtotime($daydateD['daydate'])));
	$tn = $daydateD['tn'];

	$newDayId='';
	$namevalue =' queryId="'.$queryId.'",cityId="",quotationId="'.$quotationId.'",addstatus=1,srdate="'.$dayDate1.'"';
	$newDayId = addlistinggetlastid('newQuotationDays',$namevalue);

	$rs1="";
	$rs1=GetPageRecord('*','newQuotationDays',' id = "'.$newDayId.'" and  quotationId="'.$quotationId.'" and addstatus=1 order by id desc');
	$newQuoteData=mysqli_fetch_array($rs1);

	$n = $tn+1;
	$NdayId= $newQuoteData["id"];
	$dayDate= date('d-m-Y /D',strtotime($newQuoteData["srdate"]));
 	$row_html="";
	$row_html.='<tr class="row'.$NdayId.'" dayId = "'.$newQuoteData["id"].'">';
	$row_html.='<td width="122px" >Day&nbsp;'.$n.'</td>';
	if($dayWise == 1){
	$row_html.='<td width="194px">'.$dayDate.'</td>';
	}
	$row_html.='<td width="121px">';
	$row_html.='<input type="hidden" value="'.$NdayId.'" name="dayIdArr[]" />';
	$row_html.='<input type="hidden" class="validate"  value="0"  name="cityId[]" />';
	$row_html.='<select id="destinationId'.$NdayId.'" name="destinationId[]" class="selectBox" >';
	$row_html.='<option value="">Select</option>';
	$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc');
	while($resListing=mysqli_fetch_array($rs)){
	$row_html.='<option value="'.strip($resListing['id']).'" >'.addslashes($resListing['name']).'</option>';
	}
	$row_html.='</select>';
	$row_html.='</td>';
	$row_html.='<td width="131px" align="center">';
	$row_html.='<a class="moveBtn2 drag-handler"><i class="fa fa-arrows-alt" style="color:#CCCCCC;transform: rotate(45deg);"></i></a>';
	$row_html.='<a class="moveBtn2 add-row-btn" onclick="saveAmendDay('.$NdayId.');" ><i class="fa fa-save" style="color: #4caf50;"></i></a>';
	$row_html.='<a class="moveBtn2 del-row-btn" onclick="deleteRow('.$NdayId.');" ><i class="fa fa-trash" style="color: #F44336;"></i></a>';
	$row_html.='</td>';
	$row_html.='</tr';
	?>
	<script type="text/javascript">
		$('.row<?php echo $dayId; ?>').after('<?php echo $row_html; ?>');
	</script>
	<?php
}

if(trim($_REQUEST['action'])=='saveAmendCity_row' && trim($_REQUEST['cityId']) > 0 && trim($_REQUEST['dayId']) > 0){
	$quotationId=decode($_REQUEST['quotationId']);

	$cityId=trim($_REQUEST['cityId']);
	$dayId=trim($_REQUEST['dayId']);

	$where='id="'.trim($dayId).'" and quotationId = "'.trim($quotationId).'"';
	$namevalue ='cityId="'.$cityId.'"';
	$update = updatelisting('newQuotationDays',$namevalue,$where);
	if($update == 'yes'){
	?>
	<script>
		updateAmendCityDrag(1);
	</script>
	<?php
	}
}

if(trim($_REQUEST['action'])=='deleteAmendCity_row' && trim($_REQUEST['dayId']) > 0){

 	$dayId=trim($_REQUEST['dayId']);
 
	// $sql_del = "delete from newQuotationDays where id='".trim($dayId)."' ";
	$sql_del = "UPDATE newQuotationDays SET tempDeleteStatus=1 WHERE id='".trim($dayId)."'";
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
	$status = mysqli_affected_rows(db());
	if($status > 0){
	?>
	<script>
		$('.row<?php echo $dayId; ?>').remove();
		updateAmendCityDrag(1);
	</script>
	<?php
	}
}

if(trim($_REQUEST['action'])=='askToRegenrateQuotation_updatePaxRoom' && trim($_REQUEST['quotationId'])!='' ){


	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.decode($_REQUEST['quotationId']).'"  ');
	$quotationData=mysqli_fetch_array($rsp);

	$quotationId = $quotationData['id'];
	$queryId = $quotationData['queryId'];
	// updated pax
 	$newAdult=trim($_REQUEST['newAdult']);
	$newChild=trim($_REQUEST['newChild']);
	$newInfant=trim($_REQUEST['newInfant']);
	$newSingle=trim($_REQUEST['newSingle']);
	$newDouble=trim($_REQUEST['newDouble']);
	$newTriple=trim($_REQUEST['newTriple']);
	$newTwin=trim($_REQUEST['newTwin']);
	$newENoofBed=trim($_REQUEST['newENoofBed']);
	$newCWBed=trim($_REQUEST['newCWBed']);
	$newCNBed=trim($_REQUEST['newCNBed']);
	$newQuadNoofBed=trim($_REQUEST['newQuadNoofBed']);
	$newTeenNoofBed=trim($_REQUEST['newTeenNoofBed']);
	$newSixNoofBed=trim($_REQUEST['newSixNoofBed']);
	$newEightNoofBed=trim($_REQUEST['newEightNoofBed']);
	$newTenNoofBed=trim($_REQUEST['newTenNoofBed']);

	$rsp1=GetPageRecord('generateNo',_QUOTATION_MASTER_,' queryId="'.clean($queryId).'" and quotationNo="'.$quotationData['quotationNo'].'" order by generateNo desc');
	$generateNoD=mysqli_fetch_array($rsp1);
	if($generateNoD['generateNo']!=0){
	 		$generateNo = $generateNoD['generateNo']+1;
	}else {
			$generateNo = 1;
	}

	$quotationNo = $quotationData['quotationNo'];

	//duplicate quotation with all servicess 
	
	//------------------------------------------------------------------
	$namevalue ='clientType="'.$quotationData['clientType'].'",queryId="'.$queryId.'",companyId="'.$quotationData['companyId'].'",quotationSubject="'.$quotationData['quotationSubject'].'",travelDate="'.$quotationData['travelDate'].'",queryDate="'.$quotationData['queryDate'].'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",officeBranch="'.$quotationData['officeBranch'].'",destinationId="'.$quotationData['destinationId'].'",adult="'.$newAdult.'",child="'.$newChild.'",infant="'.$newInfant.'",sglRoom="'.$newSingle.'",dblRoom="'.$newDouble.'",tplRoom="'.$newTriple.'",twinRoom="'.$newTwin.'",childwithNoofBed="'.$newCWBed.'",childwithoutNoofBed="'.$newCNBed.'",extraNoofBed="'.$newENoofBed.'",sixNoofBedRoom="'.$newSixNoofBed.'",eightNoofBedRoom="'.$newEightNoofBed.'",tenNoofBedRoom="'.$newTenNoofBed.'",quadNoofRoom="'.$newQuadNoofBed.'",teenNoofRoom="'.$newTeenNoofBed.'",night="'.$quotationData['night'].'",departureDestinationId="'.$quotationData['departureDestinationId'].'",guest1="'.$quotationData['guest1'].'",categoryId="'.$quotationData['categoryId'].'",modifyBy="'.$_SESSION['userid'].'",markup="'.$quotationData['markup'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'",modifyDate="'.$quotationData['modifyDate'].'",deletestatus="'.$quotationData['deletestatus'].'",quotationId="'.$quotationData['quotationId'].'",starRating="'.$quotationData['starRating'].'",status=0,viewQuotation="'.$quotationData['viewQuotation'].'",totalAmount="'.$quotationData['totalAmount'].'",totalquotCostWithMarkup="'.$quotationData['totalquotCostWithMarkup'].'",markupType="'.$quotationData['markupType'].'",serviceTax="'.$quotationData['serviceTax'].'",finalQuotationType="'.$quotationData['finalQuotationType'].'",currencyId="'.$quotationData['currencyId'].'",queryType="'.$quotationData['queryType'].'",cost2person="'.$quotationData['cost2person'].'",image="'.$quotationData['image'].'",flightCostType="'.$quotationData['flightCostType'].'",quotationType="'.$quotationData['quotationType'].'",hotCategory="'.$quotationData['hotCategory'].'",hotelType="'.$quotationData['hotelType'].'",otherLocation="'.$quotationData['otherLocation'].'",otherLocationCost="'.$quotationData['otherLocationCost'].'",isOtherLocation="'.$quotationData['isOtherLocation'].'",inclusion="'.addslashes($quotationData['inclusion']).'",serviceupgradationText="'.addslashes($quotationData['serviceupgradationText']).'",optionaltourText="'.addslashes($quotationData['optionaltourText']).'",remarks="'.addslashes($quotationData['remarks']).'",paymentpolicy="'.addslashes($quotationData['paymentpolicy']).'",fitGitId="'.addslashes($quotationData['fitGitId']).'",exclusion="'.addslashes($quotationData['exclusion']).'",isInc_exc="'.addslashes($quotationData['isInc_exc']).'",quotationNo="'.$quotationNo.'",generateNo="'.$generateNo.'",finalcategory="'.$quotationData['finalcategory'].'",dayroe="'.$quotationData['dayroe'].'",isSer_Mark="'.$quotationData['isSer_Mark'].'",lostStatus="'.$quotationData['lostStatus'].'",isAddExp="'.$quotationData['isAddExp'].'",overviewText="'.addslashes($quotationData['overviewText']).'",highlightsText="'.addslashes($quotationData['highlightsText']).'",tncText="'.addslashes($quotationData['tncText']).'",specialText="'.addslashes($quotationData['specialText']).'",proposalType="'.$quotationData['proposalType'].'",isTransport="'.$quotationData['isTransport'].'",isUni_Mark="'.$quotationData['isUni_Mark'].'",isPaymentRequest="'.$quotationData['isPaymentRequest'].'",departureDate="'.$quotationData['departureDate'].'",saveQuotaiton="'.$quotationData['saveQuotaiton'].'",asOnDate="'.$quotationData['asOnDate'].'",voucherNumber="'.$quotationData['voucherNumber'].'",voucherReferanceNumber="'.$quotationData['voucherReferanceNumber'].'",voucherDate="'.$quotationData['voucherDate'].'",isSupp_TRR="'.$quotationData['isSupp_TRR'].'",isRegenerated=0,discount="'.$quotationData['discount'].'",discountType="'.$quotationData['discountType'].'",costType="'.$quotationData['costType'].'",languageId="'.$quotationData['languageId'].'",deletestatusDuplicate="'.$quotationData['deletestatusDuplicate'].'",propIMGNum3="'.$quotationData['propIMGNum3'].'",propIMGNum4="'.$quotationData['propIMGNum4'].'",propIMGNum6="'.$quotationData['propIMGNum6'].'",onlyTFS="'.$quotationData['onlyTFS'].'",visaRequired="'.$quotationData['visaRequired'].'",flightRequired="'.$quotationData['flightRequired'].'",transferRequired="'.$quotationData['transferRequired'].'",passportRequired="'.$quotationData['passportRequired'].'",insuranceRequired="'.$quotationData['insuranceRequired'].'",visaCostType="'.$quotationData['visaCostType'].'",passportCostType="'.$quotationData['passportCostType'].'",insuranceCostType="'.$quotationData['insuranceCostType'].'",dayWise="'.$quotationData['dayWise'].'",calculationType="'.$quotationData['calculationType'].'",slabAndRoomType="'.$quotationData['slabAndRoomType'].'",gstType="'.$quotationData['gstType'].'",packageSupplier="'.$quotationData['packageSupplier'].'",tcs="'.$quotationData['tcs'].'"';
	$lastQuotationId = addlistinggetlastid(_QUOTATION_MASTER_,$namevalue);

	// update previous quotaion tourDate with his old date /
	$QueryDaysQuery1=GetPageRecord('min(srdate) as fromDate, max(srdate) as toDate ','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" and addstatus = 0 ');
	$QueryDaysData1=mysqli_fetch_array($QueryDaysQuery1);

	$where='id='.trim($quotationId).'';
	$namevalue ='fromDate="'.$QueryDaysData1['fromDate'].'",toDate="'.$QueryDaysData1['toDate'].'",isRegenerated=0';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);

	//regenerate with new date
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);

	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];
	// use above var
	// duplicate pax slab lists
	$paxRange = $newAdult+$newChild;

	if($quotationData['flightRequired']==2){
		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isFlightTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)){
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",quotationId="'.$lastQuotationId.'",toDate="'.$transferRes['toDate'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",totalAdultCost="'.$transferRes['totalAdultCost'].'",adultTax="'.$transferRes['adultTax'].'",totalChildCost="'.$transferRes['totalChildCost'].'",childTax="'.$transferRes['childTax'].'",totalInfantCost="'.$transferRes['totalInfantCost'].'",infantTax="'.$transferRes['infantTax'].'",cancellationPolicy="'.$transferRes['cancellationPolicy'].'",isFlightTaken="'.$transferRes['isFlightTaken'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}
	}
}
		

		// Transfer service Copy
		if($quotationData['transferRequired']==2){
		$b=''; 
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationData['id'].'" and dayId="0" and isTransferTaken="yes" and id in (select serviceId from quotationItinerary where serviceType="transfer" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){ 
			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id']; 
				$addHotel = '';

				$transfernamevalue ='fromDate="'.$transferRes['fromDate'].'",toDate="'.$transferRes['toDate'].'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",tariffId="'.$transferRes['tariffId'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",taxType="'.$transferRes['taxType'].'",gstTax="'.$transferRes['gstTax'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isTransferTaken="'.$transferRes['isTransferTaken'].'",distance="'.$transferRes['distance'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
		
				$namevalue ='';
				$namevalue ='srn="'.$adddays.'",dayId="'.$adddays.'",queryId="'.$queryId.'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$transferRes['fromDate'].'",endDate="'.$transferRes['fromDate'].'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}
	}

	// Value Added Services Start
	
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


	// Value Added Sevices End

	$b='';
	$b=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationData['id'].'" and status=1 order by fromRange asc');
	if(mysqli_num_rows($b)>0){
		$transferRes=mysqli_fetch_array($b);
		$addHotel = '';  
		// $modevalue = 'quotationId="'.$lastQuotationId.'", fromRange="'.$transferRes['fromRange'].'", toRange="'.$transferRes['toRange'].'", localEscort="'.$transferRes['localEscort'].'", foreignEscort="'.$transferRes['foreignEscort'].'", dividingFactor="'.$transferRes['dividingFactor'].'", status="'.$transferRes['status'].'", deletestatus="'.$transferRes['deletestatus'].'", dateAdded="'.$transferRes['dateAdded'].'", modifyDate="'.$transferRes['modifyDate'].'", modifyBy="'.$transferRes['modifyBy'].'",dividingFactorC="'.$transferRes['dividingFactorC'].'", DF_SGL="'.$transferRes['DF_SGL'].'", DF_DBL="'.$transferRes['DF_DBL'].'", DF_TWN="'.$transferRes['DF_TWN'].'", DF_TPL="'.$transferRes['DF_TPL'].'", DF_QUAD="'.$transferRes['DF_QUAD'].'", DF_SIX="'.$transferRes['DF_SIX'].'", DF_EIGHT="'.$transferRes['DF_EIGHT'].'", DF_TEN="'.$transferRes['DF_TEN'].'", DF_ABED="'.$transferRes['DF_ABED'].'", DF_CBED="'.$transferRes['DF_CBED'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",sglRoom="'.$transferRes['sglRoom'].'",dblRoom="'.$transferRes['dblRoom'].'",twinRoom="'.$transferRes['twinRoom'].'",tplRoom="'.$transferRes['tplRoom'].'",quadNoofRoom="'.$transferRes['quadNoofRoom'].'",sixNoofBedRoom="'.$transferRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$transferRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$transferRes['tenNoofBedRoom'].'",teenNoofRoom="'.$transferRes['teenNoofRoom'].'",extraNoofBed="'.$transferRes['extraNoofBed'].'",childwithNoofBed="'.$transferRes['childwithNoofBed'].'",childwithoutNoofBed="'.$transferRes['childwithoutNoofBed'].'"';
 
		$modevalue = 'quotationId="'.$lastQuotationId.'", fromRange="'.$paxRange.'", toRange="'.$paxRange.'", localEscort="'.$transferRes['localEscort'].'", foreignEscort="'.$transferRes['foreignEscort'].'", dividingFactor="'.$paxRange.'", status="'.$transferRes['status'].'", deletestatus="'.$transferRes['deletestatus'].'", dateAdded="'.$transferRes['dateAdded'].'", modifyDate="'.$transferRes['modifyDate'].'", modifyBy="'.$transferRes['modifyBy'].'",dividingFactorC="'.$transferRes['dividingFactorC'].'", DF_SGL="'.$transferRes['DF_SGL'].'", DF_DBL="'.$transferRes['DF_DBL'].'", DF_TWN="'.$transferRes['DF_TWN'].'", DF_TPL="'.$transferRes['DF_TPL'].'", DF_QUAD="'.$transferRes['DF_QUAD'].'", DF_SIX="'.$transferRes['DF_SIX'].'", DF_EIGHT="'.$transferRes['DF_EIGHT'].'", DF_TEN="'.$transferRes['DF_TEN'].'", DF_ABED="'.$transferRes['DF_ABED'].'", DF_CBED="'.$transferRes['DF_CBED'].'",adult="'.$newAdult.'",child="'.$newChild.'",infant="'.$newInfant.'",sglRoom="'.$newSingle.'",dblRoom="'.$newDouble.'",twinRoom="'.$newTwin.'",tplRoom="'.$newTriple.'",quadNoofRoom="'.$newQuadNoofBed.'",sixNoofBedRoom="'.$newSixNoofBed.'",eightNoofBedRoom="'.$newEightNoofBed.'",tenNoofBedRoom="'.$newTenNoofBed.'",teenNoofRoom="'.$newTeenNoofBed.'",extraNoofBed="'.$newENoofBed.'",childwithNoofBed="'.$newCWBed.'",childwithoutNoofBed="'.$newCNBed.'"';
		
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


	$day = 0;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){

		$date = date('Y-m-d', strtotime("+".$day." day", strtotime($fromDate)));

		$newDayId='';
		$namevalue =' queryId="'.$QueryDaysData['queryId'].'",cityId="'.$QueryDaysData['cityId'].'",title="'.$QueryDaysData['title'].'",description="'.$QueryDaysData['description'].'",quotationId="'.$lastQuotationId.'",srdate="'.$date.'"';
		$newDayId = addlistinggetlastid('newQuotationDays',$namevalue);

		$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and supplierId in ( select serviceId from quotationItinerary where serviceType="hotel" order by serviceId asc ) and (isGuestType=1 or isLocalEscort=1 or isForeignEscort=1) and isRoomSupplement=0 and isHotelSupplement=0 order by id asc');
		while($HotelRes=mysqli_fetch_array($b)){
			// normal and escort
			$namevalue ='';
			$addHotel ='';
			$namevalue ='hotelName="'.$HotelRes['hotelName'].'",fromDate="'.$date.'",toDate="'.$date.'",checkin="'.$HotelRes['checkin'].'",checkout="'.$HotelRes['checkout'].'",queryId="'.$HotelRes['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$HotelRes['destinationId'].'",categoryId="'.$HotelRes['categoryId'].'",hotelTypeId="'.$HotelRes['hotelTypeId'].'",roomTariffId="'.$HotelRes['roomTariffId'].'",currencyId="'.$HotelRes['currencyId'].'",currencyValue="'.$HotelRes['currencyValue'].'",supplierId="'.$HotelRes['supplierId'].'",supplierMasterId="'.$HotelRes['supplierMasterId'].'",mealPlan="'.$HotelRes['mealPlan'].'",night="'.$HotelRes['night'].'",status="'.$HotelRes['status'].'",address="'.$HotelRes['address'].'",roomprice="'.$HotelRes['roomprice'].'",noofrooms="'.$HotelRes['noofrooms'].'",roomType="'.$HotelRes['roomType'].'",tariffType="'.$HotelRes['tariffType'].'",quotTotalNight="'.$HotelRes['quotTotalNight'].'",hotelQuotatoinType="'.$HotelRes['hotelQuotatoinType'].'",singleoccupancy="'.$HotelRes['singleoccupancy'].'",doubleoccupancy="'.$HotelRes['doubleoccupancy'].'",twinoccupancy="'.$HotelRes['twinoccupancy'].'",tripleoccupancy="'.$HotelRes['tripleoccupancy'].'",quadoccupancy="'.$HotelRes['quadoccupancy'].'",childwithbed="'.$HotelRes['childwithbed'].'",childwithoutbed="'.$HotelRes['childwithoutbed'].'",lunch="'.$HotelRes['lunch'].'",dinner="'.$HotelRes['dinner'].'",extraadult="'.$HotelRes['extraadult'].'",paymentMode="'.$HotelRes['paymentMode'].'",agentCode="'.$HotelRes['agentCode'].'",fileNo="'.$HotelRes['fileNo'].'",confirmation="'.$HotelRes['confirmation'].'",arrivalBy="'.$HotelRes['arrivalBy'].'",departureBy="'.$HotelRes['departureBy'].'",specialRequest="'.$HotelRes['specialRequest'].'", sglMarkup="'.$HotelRes['sglMarkup'].'", dblMarkup="'.$HotelRes['dblMarkup'].'", tplMarkup="'.$HotelRes['tplMarkup'].'", cwbMarkup="'.$HotelRes['cwbMarkup'].'", quadMarkup="'.$HotelRes['quadMarkup'].'", cnbMarkup="'.$HotelRes['cnbMarkup'].'",exMarkup="'.$HotelRes['exMarkup'].'",mealMarkup="'.$HotelRes['mealMarkup'].'",remark="'.$HotelRes['remark'].'",tourManager="'.$HotelRes['tourManager'].'",supplementCostAdded="'.$HotelRes['supplementCostAdded'].'",isHotelSupplement="'.$HotelRes['isHotelSupplement'].'",isRoomSupplement="'.$HotelRes['isRoomSupplement'].'",rand_color="'.$HotelRes['rand_color'].'",hotelQuoteId="'.$HotelRes['hotelQuoteId'].'",breakfast="'.$HotelRes['breakfast'].'",extraBed="'.$HotelRes['extraBed'].'",roomGST="'.$HotelRes['roomGST'].'",taxType="'.$HotelRes['taxType'].'",mealGST="'.$HotelRes['mealGST'].'",TAC="'.$HotelRes['TAC'].'",complimentaryLunch="'.$HotelRes['complimentaryLunch'].'",complimentaryDinner="'.$HotelRes['complimentaryDinner'].'",complimentaryBreakfast="'.$HotelRes['complimentaryBreakfast'].'",startDayDate="'.$HotelRes['startDayDate'].'",endDayDate="'.$HotelRes['endDayDate'].'",singleNoofRoom="'.$lastQuotationData['sglRoom'].'",doubleNoofRoom="'.$lastQuotationData['dblRoom'].'",twinNoofRoom="'.$lastQuotationData['twinRoom'].'",tripleNoofRoom="'.$lastQuotationData['tplRoom'].'",extraNoofBed="'.$lastQuotationData['extraNoofBed'].'",childwithNoofBed="'.$lastQuotationData['childwithNoofBed'].'",childwithoutNoofBed="'.$lastQuotationData['childwithoutNoofBed'].'",isGuestType="'.$HotelRes['isGuestType'].'",isLocalEscort="'.$HotelRes['isLocalEscort'].'",isForeignEscort="'.$HotelRes['isForeignEscort'].'",isEarlyCheckin="'.$HotelRes['isEarlyCheckin'].'",sixBedRoom="'.$HotelRes['sixBedRoom'].'",eightBedRoom="'.$HotelRes['eightBedRoom'].'",tenBedRoom="'.$HotelRes['tenBedRoom'].'",quadRoom="'.$HotelRes['quadRoom'].'",teenRoom="'.$HotelRes['teenRoom'].'",childBreakfast="'.$HotelRes['childBreakfast'].'",childDinner="'.$HotelRes['childDinner'].'",childLunch="'.$HotelRes['childLunch'].'",sixNoofBedRoom="'.$HotelRes['sixNoofBedRoom'].'",eightNoofBedRoom="'.$HotelRes['eightNoofBedRoom'].'",tenNoofBedRoom="'.$HotelRes['tenNoofBedRoom'].'",quadNoofRoom="'.$HotelRes['quadNoofRoom'].'",teenNoofRoom="'.$HotelRes['teenNoofRoom'].'",isChildBreakfast="'.$HotelRes['isChildBreakfast'].'",isChildLunch="'.$HotelRes['isChildLunch'].'",isChildDinner="'.$HotelRes['isChildDinner'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

			$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$HotelRes['supplierId'].'"');
			if(mysqli_num_rows($check_h)==0){
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$HotelRes['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$date.'",endDate="'.$date.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}

			// supplement
			$hotelSuppQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and hotelQuoteId="'.$HotelRes['id'].'" and (isRoomSupplement=1 or isHotelSupplement=1) order by id asc');
			while($hotelSuppD=mysqli_fetch_array($hotelSuppQuery)){
				$namevalue ='';
				$namevalue ='hotelName="'.$hotelSuppD['hotelName'].'",fromDate="'.$date.'",toDate="'.$date.'",checkin="'.$hotelSuppD['checkin'].'",checkout="'.$hotelSuppD['checkout'].'",queryId="'.$hotelSuppD['queryId'].'",quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",destinationId="'.$hotelSuppD['destinationId'].'",categoryId="'.$hotelSuppD['categoryId'].'",hotelTypeId="'.$hotelSuppD['hotelTypeId'].'",roomTariffId="'.$hotelSuppD['roomTariffId'].'",currencyId="'.$hotelSuppD['currencyId'].'",currencyValue="'.$hotelSuppD['currencyValue'].'",supplierId="'.$hotelSuppD['supplierId'].'",supplierMasterId="'.$hotelSuppD['supplierMasterId'].'",mealPlan="'.$hotelSuppD['mealPlan'].'",night="'.$hotelSuppD['night'].'",status="'.$hotelSuppD['status'].'",address="'.$hotelSuppD['address'].'",roomprice="'.$hotelSuppD['roomprice'].'",noofrooms="'.$hotelSuppD['noofrooms'].'",roomType="'.$hotelSuppD['roomType'].'",tariffType="'.$hotelSuppD['tariffType'].'",quotTotalNight="'.$hotelSuppD['quotTotalNight'].'",hotelQuotatoinType="'.$hotelSuppD['hotelQuotatoinType'].'",singleoccupancy="'.$hotelSuppD['singleoccupancy'].'",doubleoccupancy="'.$hotelSuppD['doubleoccupancy'].'",twinoccupancy="'.$hotelSuppD['twinoccupancy'].'",tripleoccupancy="'.$hotelSuppD['tripleoccupancy'].'",quadoccupancy="'.$hotelSuppD['quadoccupancy'].'",childwithbed="'.$hotelSuppD['childwithbed'].'",childwithoutbed="'.$hotelSuppD['childwithoutbed'].'",lunch="'.$hotelSuppD['lunch'].'",dinner="'.$hotelSuppD['dinner'].'",extraadult="'.$hotelSuppD['extraadult'].'",paymentMode="'.$hotelSuppD['paymentMode'].'",agentCode="'.$hotelSuppD['agentCode'].'",fileNo="'.$hotelSuppD['fileNo'].'",confirmation="'.$hotelSuppD['confirmation'].'",arrivalBy="'.$hotelSuppD['arrivalBy'].'",departureBy="'.$hotelSuppD['departureBy'].'",specialRequest="'.$hotelSuppD['specialRequest'].'", sglMarkup="'.$hotelSuppD['sglMarkup'].'", dblMarkup="'.$hotelSuppD['dblMarkup'].'", tplMarkup="'.$hotelSuppD['tplMarkup'].'", cwbMarkup="'.$hotelSuppD['cwbMarkup'].'", quadMarkup="'.$hotelSuppD['quadMarkup'].'", cnbMarkup="'.$hotelSuppD['cnbMarkup'].'",exMarkup="'.$hotelSuppD['exMarkup'].'",mealMarkup="'.$hotelSuppD['mealMarkup'].'",remark="'.$hotelSuppD['remark'].'",tourManager="'.$hotelSuppD['tourManager'].'",supplementCostAdded="'.$hotelSuppD['supplementCostAdded'].'",isHotelSupplement="'.$hotelSuppD['isHotelSupplement'].'",isRoomSupplement="'.$hotelSuppD['isRoomSupplement'].'",rand_color="'.$hotelSuppD['rand_color'].'",hotelQuoteId="'.$addHotel.'",breakfast="'.$hotelSuppD['breakfast'].'",extraBed="'.$hotelSuppD['extraBed'].'",roomGST="'.$hotelSuppD['roomGST'].'",taxType="'.$hotelSuppD['taxType'].'",mealGST="'.$hotelSuppD['mealGST'].'",TAC="'.$hotelSuppD['TAC'].'",complimentaryLunch="'.$hotelSuppD['complimentaryLunch'].'",complimentaryDinner="'.$hotelSuppD['complimentaryDinner'].'",complimentaryBreakfast="'.$hotelSuppD['complimentaryBreakfast'].'",startDayDate="'.$hotelSuppD['startDayDate'].'",endDayDate="'.$hotelSuppD['endDayDate'].'",singleNoofRoom="'.$hotelSuppD['singleNoofRoom'].'",doubleNoofRoom="'.$hotelSuppD['doubleNoofRoom'].'",twinNoofRoom="'.$hotelSuppD['twinNoofRoom'].'",tripleNoofRoom="'.$hotelSuppD['tripleNoofRoom'].'",extraNoofBed="'.$hotelSuppD['extraNoofBed'].'",childwithNoofBed="'.$hotelSuppD['childwithNoofBed'].'",childwithoutNoofBed="'.$hotelSuppD['childwithoutNoofBed'].'",isGuestType="'.$hotelSuppD['isGuestType'].'",isLocalEscort="'.$hotelSuppD['isLocalEscort'].'",isForeignEscort="'.$hotelSuppD['isForeignEscort'].'",isEarlyCheckin="'.$hotelSuppD['isEarlyCheckin'].'",sixBedRoom="'.$hotelSuppD['sixBedRoom'].'",eightBedRoom="'.$hotelSuppD['eightBedRoom'].'",tenBedRoom="'.$hotelSuppD['tenBedRoom'].'",quadRoom="'.$hotelSuppD['quadRoom'].'",teenRoom="'.$hotelSuppD['teenRoom'].'",childBreakfast="'.$hotelSuppD['childBreakfast'].'",childDinner="'.$hotelSuppD['childDinner'].'",childLunch="'.$hotelSuppD['childLunch'].'",sixNoofBedRoom="'.$hotelSuppD['sixNoofBedRoom'].'",eightNoofBedRoom="'.$hotelSuppD['eightNoofBedRoom'].'",tenNoofBedRoom="'.$hotelSuppD['tenNoofBedRoom'].'",quadNoofRoom="'.$hotelSuppD['quadNoofRoom'].'",teenNoofRoom="'.$hotelSuppD['teenNoofRoom'].'",isChildBreakfast="'.$hotelSuppD['isChildBreakfast'].'",isChildLunch="'.$hotelSuppD['isChildLunch'].'",isChildDinner="'.$hotelSuppD['isChildDinner'].'"';
				$addSuppId = addlistinggetlastid(_QUOTATION_HOTEL_MASTER_,$namevalue);

				$check_h=GetPageRecord('*','quotationItinerary',' queryId="'.$QueryDaysData['queryId'].'" and dayId="'.$newDayId.'" and quotationId="'.$lastQuotationId.'" and serviceId="'.$hotelSuppD['supplierId'].'"');
				if(mysqli_num_rows($check_h)==0 && $hotelSuppD['isHotelSupplement'] == 1){
					$namevalue ='';
					$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$hotelSuppD['supplierId'].'",quotationId="'.$lastQuotationId.'",serviceType="hotel",startDate="'.$date.'",endDate="'.$date.'"';
					addlistinggetlastid('quotationItinerary',$namevalue);
				}
			}
 

			$qhaQuery=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$HotelRes['id'].'"  and quotationId="'.$QueryDaysData['quotationId'].'" order by id asc');
			while($qhAData=mysqli_fetch_array($qhaQuery)){

				$namevalue ='quotationId="'.$lastQuotationId.'",dayId="'.$newDayId.'",hotelId="'.$qhAData['hotelId'].'",additionalCost="'.$qhAData['additionalCost'].'",name="'.$qhAData['name'].'",hotelQuotId="'.$addHotel.'",additionalId="'.$qhAData['additionalId'].'",costType="'.$qhAData['costType'].'",queryId="'.$qhAData['queryId'].'",destinationId="'.$qhAData['destinationId'].'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$qhAData['currencyId'].'",currencyValue="'.$qhAData['currencyValue'].'",rateId="'.$qhAData['rateId'].'"';
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
				$transfernamevalue ='fromDate="'.$date.'",toDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'"'; 

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					 $transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					

				}
				
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$date.'",endDate="'.$date.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}

		$b='';
		$b=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="transportation" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				

				
				
				$addHotel = ''; 
				$transfernamevalue ='fromDate="'.$date.'",toDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",transferNameId="'.$transferRes['transferNameId'].'",supplierId="'.$transferRes['supplierId'].'",tariffId="'.$transferRes['tariffId'].'",vehicleId="'.$transferRes['vehicleId'].'",vehicleModelId="'.$transferRes['vehicleModelId'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",transferToId="'.$transferRes['transferToId'].'",transferFromId="'.$transferRes['transferFromId'].'",transferType="'.$transferRes['transferType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",roomPrice="'.$transferRes['roomPrice'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",transferQuotatoinType="'.$transferRes['transferQuotatoinType'].'",dmcId="'.$transferRes['dmcId'].'",pickupFrom="'.$transferRes['pickupFrom'].'",pickupTime="'.$transferRes['pickupTime'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",vehMarkup="'.$transferRes['vehMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",driverId="'.$transferRes['driverId'].'",vehicleType="'.$transferRes['vehicleType'].'",parkingFee="'.$transferRes['parkingFee'].'",representativeEntryFee="'.$transferRes['representativeEntryFee'].'",assistance="'.$transferRes['assistance'].'",guideAllowance="'.$transferRes['guideAllowance'].'",interStateAndToll="'.$transferRes['interStateAndToll'].'",miscellaneous="'.$transferRes['miscellaneous'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",transferName="'.$transferRes['transferName'].'",noOfDays="'.$transferRes['noOfDays'].'",dayId="'.$newDayId.'",serviceType="'.$transferRes['serviceType'].'",costType="'.$transferRes['costType'].'",distance="'.$transferRes['distance'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",totalPax="'.$totalPaxId.'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",isSupplement="'.$transferRes['isSupplement'].'",transferQuoteId="'.$transferRes['transferQuoteId'].'",startDay="'.$transferRes['startDay'].'",endDay="'.$transferRes['endDay'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",isSupTPTType="'.$transferRes['isSupTPTType'].'",markupCost="'.$transferRes['markupCost'].'"';

				$addHotel = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$transfernamevalue);
				
				$c1="";
				$c1=GetPageRecord('*','quotationTransferTimelineDetails','transferQuoteId="'.$transferRes['id'].'" ');
				if(mysqli_num_rows($c1)>0){
					 $transferTimelineData=mysqli_fetch_array($c1);

					 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",supplierId="'.$transferTimelineData['supplierId'].'",transferQuoteId="'.$addHotel.'",arrivalFrom="'.$transferTimelineData['arrivalFrom'].'",trainName="'.$transferTimelineData['trainName'].'",trainNumber="'.$transferTimelineData['trainNumber'].'",flightName="'.$transferTimelineData['flightName'].'",flightNumber="'.$transferTimelineData['flightNumber'].'",vehicleName="'.$transferTimelineData['vehicleName'].'",airportName="'.$transferTimelineData['airportName'].'",pickupAddress="'.$transferTimelineData['pickupAddress'].'",dropAddress="'.$transferTimelineData['dropAddress'].'",VehicleModel="'.$transferTimelineData['VehicleModel'].'",arrivalTime="'.$transferTimelineData['arrivalTime'].'",dropTime="'.$transferTimelineData['dropTime'].'",mode="'.$transferTimelineData['mode'].'",pickupTime="'.$transferTimelineData['pickupTime'].'"';
					 $hotelSupHot = addlistinggetlastid('quotationTransferTimelineDetails',$namevalue);
					

				}
				
				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="'.$transferRes['serviceType'].'",startDate="'.$date.'",endDate="'.$date.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);
			}
		}


		$b=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="guide" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){

			
				$bb2='';
				$bb2=GetPageRecord('id','totalPaxSlab',' quotationId="'.$lastQuotationId.'" and status=1');
				$paxSlabData2=mysqli_fetch_array($bb2);
				$totalPaxId = $paxSlabData2['id'];
				
			
			$addHotel ='';
			$transfernamevalue ='guideId="'.$transferRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferRes['price'].'",guideName="'.$transferRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$date.'",toDate="'.$date.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferRes['srn'].'",destinationId="'.$transferRes['destinationId'].'",rules="'.$transferRes['rules'].'",category="'.$transferRes['category'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",subcategory="'.$transferRes['subcategory'].'",totalDays="'.$transferRes['totalDays'].'",perDaycost="'.$transferRes['perDaycost'].'",serviceType="'.$transferRes['serviceType'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",guideQuoteId="'.$transferRes['guideQuoteId'].'",isGuestType="'.$transferRes['isGuestType'].'",isSupplement="'.$transferRes['isSupplement'].'",isSelectedFinal="'.$transferRes['isSelectedFinal'].'",paxRange="'.$transferRes['paxRange'].'",dayType="'.$transferRes['dayType'].'",dayId="'.$newDayId.'",markupCost="'.$transferRes['markupCost'].'"';

			$addHotel = addlistinggetlastid('quotationGuideMaster',$transfernamevalue);

			$bSupp=GetPageRecord('*','quotationGuideMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'"  and guideQuoteId="'.$transferRes['id'].'" and isSupplement=1 order by id asc');
			while($transferSuppRes=mysqli_fetch_array($bSupp)){
				$suppGuidevalue ='guideId="'.$transferSuppRes['guideId'].'",slabId="'.$totalPaxId.'",price="'.$transferSuppRes['price'].'",guideName="'.$transferSuppRes['guideName'].'",queryId="'.$queryId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$transferSuppRes['supplierId'].'",tariffId="'.$transferSuppRes['tariffId'].'",quotationId="'.$lastQuotationId.'",srn="'.$transferSuppRes['srn'].'",destinationId="'.$transferSuppRes['destinationId'].'",rules="'.$transferSuppRes['rules'].'",category="'.$transferSuppRes['category'].'",subcategory="'.$transferSuppRes['subcategory'].'",totalDays="'.$transferSuppRes['totalDays'].'",perDaycost="'.$transferSuppRes['perDaycost'].'",serviceType="'.$transferSuppRes['serviceType'].'",currencyId="'.$transferSuppRes['currencyId'].'",currencyValue="'.$transferSuppRes['currencyValue'].'",guideQuoteId="'.$addHotel.'",isGuestType="'.$transferSuppRes['isGuestType'].'",isSupplement="'.$transferSuppRes['isSupplement'].'",isSelectedFinal="'.$transferSuppRes['isSelectedFinal'].'",paxRange="'.$transferSuppRes['paxRange'].'",dayType="'.$transferSuppRes['dayType'].'",dayId="'.$newDayId.'",markupCost="'.$transferSuppRes['markupCost'].'"';
	
				$addSuppHotel = addlistinggetlastid('quotationGuideMaster',$suppGuidevalue);
			}

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="guide",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="activity" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='otherActivityName="'.$transferRes['otherActivityName'].'",dateotherActivity="'.$transferRes['dateotherActivity'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",otherActivityCity="'.$transferRes['otherActivityCity'].'",fromDate="'.$date.'",toDate="'.$date.'",activityCost="'.$transferRes['activityCost'].'",maxpax="'.$transferRes['maxpax'].'",perPaxCost="'.$transferRes['perPaxCost'].'",quotationOtherActivitymaster="'.$transferRes['quotationOtherActivitymaster'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",tariffId="'.$transferRes['tariffId'].'",supplierId="'.$transferRes['supplierId'].'",markupCost="'.$transferRes['markupCost'].'",transferType="'.$transferRes['transferType'].'",slabId="'.$transferRes['slabId'].'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",vehicleId="'.$transferRes['vehicleId'].'",repCost="'.$transferRes['repCost'].'",tarifType="'.$transferRes['tarifType'].'",nationality="'.$transferRes['nationality'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$transfernamevalue);
			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="activity",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationActivityTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1); 
				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationActivityTimelineDetails',$namevalue);

			}
			
		}


		$b=GetPageRecord('*','quotationEnrouteMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="enroute" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel ='';
			$transfernamevalue ='enrouteId="'.$transferRes['enrouteId'].'",queryId="'.$transferRes['queryId'].'",quotationId="'.$lastQuotationId.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",destinationId="'.$transferRes['destinationId'].'",fromDate="'.$date.'",toDate="'.$date.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationEnrouteMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="enroute",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue); 

		}


		$b=GetPageRecord('*','quotationEntranceMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="entrance" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='entranceNameId="'.$transferRes['entranceNameId'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",destinationId="'.$transferRes['destinationId'].'",dmcId="'.$transferRes['dmcId'].'",vehicleId="'.$transferRes['vehicleId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$date.'",toDate="'.$date.'",ticketAdultCost="'.$transferRes['ticketAdultCost'].'",ticketchildCost="'.$transferRes['ticketchildCost'].'",ticketinfantCost="'.$transferRes['ticketinfantCost'].'",entranceType="'.$transferRes['entranceType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",repCost="'.$transferRes['repCost'].'",detail="'.$transferRes['detail'].'",vehicleCost="'.$transferRes['vehicleCost'].'",noOfVehicles="'.$transferRes['noOfVehicles'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",entranceQuotatoinType="'.$transferRes['entranceQuotatoinType'].'",transferType="'.$transferRes['transferType'].'",pickupTime="'.$transferRes['pickupTime'].'",pickupFrom="'.$transferRes['pickupFrom'].'",duration="'.$transferRes['duration'].'",vehicleMaxPax="'.$transferRes['vehicleMaxPax'].'",adMarkup="'.$transferRes['adMarkup'].'",chMarkup="'.$transferRes['chMarkup'].'",remark="'.$transferRes['remark'].'",confirmation="'.$transferRes['confirmation'].'",tourManager="'.$transferRes['tourManager'].'",guideCost="'.$transferRes['guideCost'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid('quotationEntranceMaster',$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="entrance",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
			$c1="";
			$c1=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$transferRes['id'].'"');  
			if(mysqli_num_rows($c1)>0){
				$transferTimelineData=mysqli_fetch_array($c1);

				 $namevalue ='quotationId="'.$add.'",dayId="'.$newDayId.'",hotelQuoteId="'.$addHotel.'",supplierId="'.$transferTimelineData['supplierId'].'",startTime="'.$transferTimelineData['startTime'].'",endTime="'.$transferTimelineData['endTime'].'"';
				 $entraceTimeId = addlistinggetlastid('quotationEntranceTimelineDetails',$namevalue);

			}
		
		}
		
		// Duplicate Ferry
		$b=GetPageRecord('*','quotationFerryMaster','quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="ferry" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$ferrynamevalue ='ferryNameId="'.$transferRes['ferryNameId'].'",serviceid="'.$transferRes['serviceid'].'",quotationId="'.$lastQuotationId.'",destinationId="'.$transferRes['destinationId'].'",supplierId="'.$transferRes['supplierId'].'",fromDate="'.$date.'",toDate="'.$date.'",ferryClass="'.$transferRes['ferryClass'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",ferryCost="'.$transferRes['ferryCost'].'",processingfee="'.$transferRes['processingfee'].'",miscCost="'.$transferRes['miscCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",pickupTime="'.$transferRes['pickupTime'].'",dropTime="'.$transferRes['dropTime'].'",markupType="'.$transferRes['markupType'].'",markupCost="'.$transferRes['markupCost'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",remark="'.$transferRes['remark'].'",rateId="'.$transferRes['rateId'].'",timeId="'.$transferRes['timeId'].'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid('quotationFerryMaster',$ferrynamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="ferry",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);
			
		}

		$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="mealplan" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='mealPlanName="'.$transferRes['mealPlanName'].'",quotationId="'.$lastQuotationId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",dateMealPlan="'.$transferRes['dateMealPlan'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",mealPlanCity="'.$transferRes['mealPlanCity'].'",mealType="'.$transferRes['mealType'].'",destinationId="'.$transferRes['destinationId'].'",markupCost="'.$transferRes['markupCost'].'",fromDate="'.$date.'",toDate="'.$date.'",queryId="'.$queryId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'",dayId="'.$newDayId.'"';
			$addHotel = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="mealplan",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="flight" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$date.'",quotationId="'.$lastQuotationId.'",toDate="'.$date.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",flightId="'.$transferRes['flightId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",destinationId="'.$transferRes['destinationId'].'",flightNumber="'.$transferRes['flightNumber'].'",flightClass="'.$transferRes['flightClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",adult="'.$transferRes['adult'].'",child="'.$transferRes['child'].'",infant="'.$transferRes['infant'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="flight",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="train" order by serviceId asc) order by id asc');
		while($transferRes=mysqli_fetch_array($b)){
			$addHotel = '';
			$transfernamevalue ='fromDate="'.$date.'",quotationId="'.$lastQuotationId.'",toDate="'.$date.'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",trainId="'.$transferRes['trainId'].'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",arrivalTo="'.$transferRes['arrivalTo'].'",departureFrom="'.$transferRes['departureFrom'].'",departureDate="'.$transferRes['departureDate'].'",arrivalDate="'.$transferRes['arrivalDate'].'",departureTime="'.$transferRes['departureTime'].'",arrivalTime="'.$transferRes['arrivalTime'].'",journeyType="'.$transferRes['journeyType'].'",destinationId="'.$transferRes['destinationId'].'",trainNumber="'.$transferRes['trainNumber'].'",trainClass="'.$transferRes['trainClass'].'",queryId="'.$queryId.'",dayId="'.$newDayId.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",isGuestType="'.$transferRes['isGuestType'].'",isLocalEscort="'.$transferRes['isLocalEscort'].'",isForeignEscort="'.$transferRes['isForeignEscort'].'",markupCost="'.$transferRes['markupCost'].'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
			$addHotel = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$transfernamevalue);

			$namevalue ='';
			$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="train",startDate="'.$date.'",endDate="'.$date.'"';
			addlistinggetlastid('quotationItinerary',$namevalue);

		}


		$b='';
		$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" and id in (select serviceId from quotationItinerary where serviceType="additional" order by serviceId asc) order by id asc');
		if(mysqli_num_rows($b)>0){

			while($transferRes=mysqli_fetch_array($b)){
				$addHotel = '';
				$transfernamevalue ='name="'.$transferRes['name'].'",dateExtra="'.$transferRes['dateExtra'].'",queryId="'.$queryId.'",gstTax="'.$transferRes['gstTax'].'",taxType="'.$transferRes['taxType'].'",adultCost="'.$transferRes['adultCost'].'",childCost="'.$transferRes['childCost'].'",infantCost="'.$transferRes['infantCost'].'",groupCost="'.$transferRes['groupCost'].'",destinationId="'.$transferRes['destinationId'].'",quotationId="'.$lastQuotationId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$transferRes['currencyId'].'",currencyValue="'.$transferRes['currencyValue'].'",costType="'.$transferRes['costType'].'",additionalId="'.$transferRes['additionalId'].'",markupCost="'.$transferRes['markupCost'].'",dayId="'.$newDayId.'",adultPax="'.$transferRes['adultPax'].'",childPax="'.$transferRes['childPax'].'",infantPax="'.$transferRes['infantPax'].'"';
				$addHotel = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$transfernamevalue);

				$namevalue ='';
				$namevalue ='srn="'.$newDayId.'",dayId="'.$newDayId.'",queryId="'.$QueryDaysData['queryId'].'",serviceId="'.$addHotel.'",quotationId="'.$lastQuotationId.'",serviceType="additional",startDate="'.$date.'",endDate="'.$date.'"';
				addlistinggetlastid('quotationItinerary',$namevalue);

			}
		}

		$b='';
		$b=GetPageRecord('*','quotationModeMaster',' quotationId="'.$quotationId.'" and dayId="'.$QueryDaysData['id'].'" order by id asc');
		if(mysqli_num_rows($b)>0){
			$transferRes=mysqli_fetch_array($b);
			$addHotel = '';
			$modevalue ='name="'.$transferRes['name'].'",dayId="'.$newDayId.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'"';
			$modeId = addlistinggetlastid('quotationModeMaster',$modevalue);
		}
		$day++;
	}

	$b='';
	$b=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationId.'" order by id asc');
	if(mysqli_num_rows($b)>0){
		$transferRes=mysqli_fetch_array($b);
		$addHotel = '';
		$modevalue = ' markupCost="'.$transferRes['markupCost'].'", curren="'.$transferRes['curren'].'", quotationId="'.$lastQuotationId.'", package="'.$transferRes['package'].'", hotel="'.$transferRes['hotel'].'", guide="'.$transferRes['guide'].'", activity="'.$transferRes['activity'].'", entrance="'.$transferRes['entrance'].'", transfer="'.$transferRes['transfer'].'", train="'.$transferRes['train'].'", flight="'.$transferRes['flight'].'", restaurant="'.$transferRes['restaurant'].'",ferry="'.$transferRes['ferry'].'",visa="'.$transferRes['visa'].'",passport="'.$transferRes['passport'].'",insurance="'.$transferRes['insurance'].'",other="'.$transferRes['other'].'",packageMarkupType="'.$transferRes['packageMarkupType'].'",hotelMarkupType="'.$transferRes['hotelMarkupType'].'",guideMarkupType="'.$transferRes['guideMarkupType'].'",activityMarkupType="'.$transferRes['activityMarkupType'].'",entranceMarkupType="'.$transferRes['entranceMarkupType'].'",transferMarkupType="'.$transferRes['transferMarkupType'].'",trainMarkupType="'.$transferRes['trainMarkupType'].'",flightMarkupType="'.$transferRes['flightMarkupType'].'",restaurantMarkupType="'.$transferRes['restaurantMarkupType'].'",ferryMarkupType="'.$transferRes['ferryMarkupType'].'",visaMarkupType="'.$transferRes['visaMarkupType'].'",passportMarkupType="'.$transferRes['passportMarkupType'].'",insuranceMarkupType="'.$transferRes['insuranceMarkupType'].'",otherMarkupType="'.$transferRes['otherMarkupType'].'", status="'.$transferRes['status'].'"';
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
	//End of the duplicate part


	
	//star check for rate change
	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$lastQuotationId.'"');
	$lastQuotationData=mysqli_fetch_array($rsp);

	$lastQuotationId = $lastQuotationData['id'];
	$queryId = $lastQuotationData['queryId'];

	$rs1q=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"');
	$queryData = mysqli_fetch_array($rs1q);
	$dayWise = $queryData['dayWise'];
	$fromDate = $lastQuotationData['fromDate'];
	$toDate = $lastQuotationData['toDate'];

	date_default_timezone_set('Asia/Kolkata');
	$newfilez = makeQuotationId($lastQuotationData['id']);

 	// use above var
	$hotelError = $msgError = "";
	$newDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and addstatus=0 order by srdate asc');
	while($newDaysData=mysqli_fetch_array($newDaysQuery)){

		$cityId = $newDaysData['cityId'];
		$date = date('Y-m-d', strtotime($newDaysData['srdate']));
		$dayId = $newDaysData['id'];

		// check the service price difference
		//---------------------------------------------------------------------
		$b=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" group by serviceType order by srn asc,id desc');
		while($sorting=mysqli_fetch_array($b)){
			if($sorting['serviceType'] == 'hotel'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="hotel" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$sorting1['quotationId'].'" and supplierId="'.$sorting1['serviceId'].'" and dayId="'.$sorting1['dayId'].'" order by id desc');
					$hotelQuotData=mysqli_fetch_array($c);
					$prevSupplementCostAdded = $hotelQuotData['supplementCostAdded'];
					$roomTariffId = $hotelQuotData['roomTariffId'];
					$destinationId = $hotelQuotData['destinationId'];
					$tarifType = $hotelQuotData['tarifType'];
					$roomType = $hotelQuotData['roomType'];
					// hotel data
					$dh=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
					$hotelData=mysqli_fetch_array($dh);
					
					$seasonQuery = "";
					if($dayWise == 2){
						if($queryData['seasonType']!= 3 ){
							$seasonQuery = " and seasonType='".$queryData['seasonType']."' and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}else{
							$seasonQuery = " and ( seasonType=1 or seasonType=2 ) and YEAR(fromDate) = '".$queryData['seasonYear']."'";
						}
					}else{
						 $seasonQuery = " and DATE(fromDate)<='".$date."' and  DATE(toDate)>='".$date."'";
					}

					// exit();

					//data from dmc
					//for normal each day
					$dmcrate=0;
 					$normalCheckQuery = "";
					$specialCheckQuery = "";
					$roomTypeFilter = 'and roomType="'.$roomType.'"';
					// check for special days rate
					$wherespc = ' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=3 '.$seasonQuery.' '.$roomTypeFilter.'';
					
					 $specialCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,$wherespc);
				
					if(mysqli_num_rows($specialCheckQuery)>0){
						// if special days rates exist
						$dmcSpecialrate=1;
						$dmcroommastermain=mysqli_fetch_array($specialCheckQuery);
						$dmcroommastermain['tarifType'];
					}else{
						// Check for Weekend Rates
						$weekendCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and tarifType="2" '.$seasonQuery.' '.$roomTypeFilter.' and serviceid in ( select id from packageBuilderHotelMaster where weekendDays in ( select id from weekendMaster where FIND_IN_SET("'.date("l", strtotime($date)).'", daysName) ) ) ');

						if(mysqli_num_rows($weekendCheckQuery)>0){
						$dmcWeekendrate=1;
						$dmcroommastermain=mysqli_fetch_array($weekendCheckQuery);
						}else{
						// Check for Normal Rates
						$normalCheckQuery=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$hotelData['id'].'" and status=1 and supplierId>0 and tarifType=1 '.$seasonQuery.' '.$roomTypeFilter.'');
						if(mysqli_num_rows($normalCheckQuery)>0){
						$dmcNormalrate=1;
						$dmcroommastermain=mysqli_fetch_array($normalCheckQuery);
						}else{
							$normalratenotexist=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$hotelQuotData['quotationId'].'" and id="'.$hotelQuotData['id'].'" order by id desc');
							$dmcNormalratenotexit=1;
							$dmcroommastermain=mysqli_fetch_array($normalratenotexist);
						}
						
					}
				}

					$singleoccupancy = getCostWithGST($dmcroommastermain['singleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$doubleoccupancy = getCostWithGST($dmcroommastermain['doubleoccupancy'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithbed =  getCostWithGST($dmcroommastermain['childwithbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$extraBed =  getCostWithGST($dmcroommastermain['extraBed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$childwithoutbed =  getCostWithGST($dmcroommastermain['childwithoutbed'],getGstValueById($dmcroommastermain['roomGST']),$dmcroommastermain['roomTAC'],$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

					$lunch =  getCostWithGST($dmcroommastermain['lunch'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$dinner =  getCostWithGST($dmcroommastermain['dinner'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);
					$breakfast =  getCostWithGST($dmcroommastermain['breakfast'],getGstValueById($dmcroommastermain['mealGST']),0,0,1);

					$supplementCostAdded = 0;
					if($dmcSpecialrate==1){
					$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
					$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);

				// }
			  }else{
				$msgError='';
				$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".$hotelData['hotelName']." : Special Rate is not available, Normal rate rate is applicable.</p>";
				$hotelError .= $msgError;
				errorlogGenerateQuotation($msgError,$newfilez);
			 }

			 if($dmcWeekendrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
	
			 if($dmcNormalrate==1){
				$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
				$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

				$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
				addlisting('quotationItinerary',$namevalue1);

			// }
		  }


		 if($dmcNormalratenotexit==1){
			$namevalue ='tariffType="'.$dmcroommastermain['tarifType'].'",supplementCostAdded="'.$supplementCostAdded.'",destinationId="'.$destinationId.'",categoryId="'.$hotelData['hotelCategory'].'",quotationId="'.$lastQuotationId.'",roomType="'.$dmcroommastermain['roomType'].'",checkin="'.$checkIn.'",checkout="'.$checkOut.'",night="'.$night.'",queryId="'.$queryId.'",dayId="'.$dayId.'",fromDate="'.$date.'",toDate="'.$date.'",supplierId="'.$hotelData['id'].'",mealPlan="'.$dmcroommastermain['mealPlan'].'",singleoccupancy="'.$singleoccupancy.'",doubleoccupancy="'.$doubleoccupancy.'",childwithbed="'.$childwithbed.'",extraBed="'.$extraBed.'",childwithoutbed="'.$childwithoutbed.'",lunch="'.$lunch.'",dinner="'.$dinner.'",breakfast="'.$breakfast.'",currencyId="'.$dmcroommastermain['currencyId'].'",supplierMasterId="'.$dmcroommastermain['supplierId'].'",roomTariffId="'.$roomTariffId.'",status="1"';
			$edit = updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,'id="'.trim($hotelQuotData['id']).'"');

			$namevalue1 ='serviceId="'.$lastid.'",serviceType="hotel", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$lastQuotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
			addlisting('quotationItinerary',$namevalue1);

			// }
		  }
		  
		
				}
			}
			// transfer rate starts
			if($sorting['serviceType'] == 'transfer' || $sorting['serviceType'] == 'transportation'){
				// quotation hotel data
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="transfer" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs2=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$newDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"');
					$transferQuotData=mysqli_fetch_array($rs2);

					$rs2=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');
					$transferData=mysqli_fetch_array($rs2);
					$transferName = ucfirst($transferData['transferCategory'])."-".clean($transferData['transferName']);

					//check for exitance
					$rsa2s=GetPageRecord('*','quotationTransferRateMaster','id="'.$transferQuotData['tariffId'].'"');
					if(mysqli_num_rows($rsa2s)>0){
						$dmcTransferData=mysqli_fetch_array($rsa2s);
					}else{
						$rs1=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$transferQuotData['tariffId'].'"');
						$dmcTransferData=mysqli_fetch_array($rs1);
					}

					if( $dmcTransferData['id'] > 0 && $dmcTransferData['id']!='' ){


						$tarifId = addslashes($dmcTransferData['id']);
						$supplierId = addslashes($dmcTransferData['supplierId']);
						$destinationId = $transferQuotData['destinationId'];
 						$transferCategory = $transferData['transferCategory'];
						$costType= $transferQuotData['costType'];
						$distance= $dmcTransferData['distance'];

						$transferNameId=addslashes($dmcTransferData['transferNameId']);
						$transferType='2';
						$infantsCost=addslashes($dmcTransferData['infantCost']);
						$vehicleTypeId=addslashes($dmcTransferData['vehicleTypeId']);
						$vehicleModelId=addslashes($dmcTransferData['vehicleModelId']);
						$gstTax=addslashes($dmcTransferData['gstTax']);
						$vehicleCost=0;

						if(trim($_REQUEST['noOfDays'])<1){ $noOfDays = 1; }else{ $noOfDays = trim($_REQUEST['noOfDays']); }

						if($dmcTransferData['serviceType']=='transfer'){
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$dmcTransferData['gstTax'])+$vehicleCost);
						}else{
							$vehicleCost=(addslashes($dmcTransferData['vehicleCost']))+addslashes($dmcTransferData['parkingFee'])+addslashes($dmcTransferData['representativeEntryFee'])+addslashes($dmcTransferData['assistance'])+addslashes($dmcTransferData['guideAllowance'])+addslashes($dmcTransferData['interStateAndToll'])+addslashes($dmcTransferData['miscellaneous']);
							$vehicleCost= round(($vehicleCost/100*$gstTax)+$vehicleCost)*$noOfDays;
						}

						$detail=addslashes($dmcTransferData['detail']);
						$currencyId=addslashes($dmcTransferData['currencyId']);

						$namevalue = 'fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$destinationId.'",transferNameId="'.$transferNameId.'",transferType="'.$transferType.'",vehicleType="'.$vehicleTypeId.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",currencyId="'.$currencyId.'",detail="'.$detail.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",tariffId="'.$tarifId.'",parkingFee="'.$dmcTransferData['parkingFee'].'",representativeEntryFee="'.$dmcTransferData['representativeEntryFee'].'",assistance="'.$dmcTransferData['assistance'].'",guideAllowance="'.$dmcTransferData['guideAllowance'].'",interStateAndToll="'.$dmcTransferData['interStateAndToll'].'",miscellaneous="'.$dmcTransferData['miscellaneous'].'",gstTax="'.$dmcTransferData['gstTax'].'",costType="'.$costType.'",distance="'.$distance.'",noOfDays="'.trim($noOfDays).'",dayId="'.$dayId.'",serviceType="'.$transferCategory.'"';
						$lastid = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="'.$transferCategory.'", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);
					}else{

						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | ".strip($transferName)." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}




				}
			}
			// entrance rate starts
			if($sorting['serviceType'] == 'entrance'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="entrance" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'" ';
					$rs1=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$entranceQuotData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id ="'.$entranceQuotData['entranceNameId'].'" ');
						$entranceData=mysqli_fetch_array($otherActivitySql);

						$entranceName = strip($entranceData['entranceName']);
						$entranceNameId = strip($entranceData['id']);
						$marketId = getQueryMaketType($queryId);
						$supplierId = $entranceQuotData['supplierId'];
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}
 						$rs1 = GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,' entranceNameId= "'.$entranceNameId.'" and supplierId = "'.$supplierId.'"  and "'.$date.'" BETWEEN fromDate and toDate '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcEntranceData = mysqli_fetch_array($rs1);

							$entranceId=addslashes($dmcEntranceData['id']);
							$detail=addslashes($dmcEntranceData['detail']);
							$ticketAdultCost=addslashes($dmcEntranceData['ticketAdultCost']);
							$ticketchildCost=addslashes($dmcEntranceData['ticketchildCost']);
							$currencyId=addslashes($dmcEntranceData['currencyId']);

							$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",entranceNameId="'.$entranceNameId.'",currencyId="'.$currencyId.'",detail="'.$detail.'",ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",dmcId="'.$entranceId.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_ENTRANCE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="entrance", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);

							// operation restriction detail
							$rs21=GetPageRecord('*','hoteloperationRestriction',' entranceId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}
						}else{
							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Entrance - ".$entranceName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}

			if($sorting['serviceType'] == 'activity'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="activity" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where1);

					if(mysqli_num_rows($rs1)>0){
						$quotationActivityData=mysqli_fetch_array($rs1);

						$otherActivitySql=GetPageRecord('*','packageBuilderotherActivityMaster',' id ="'.$quotationActivityData['otherActivityName'].'" ');
						$activityData=mysqli_fetch_array($otherActivitySql);
						$otherActivityName=addslashes($activityData['otherActivityName']);

						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
						}

						$maxpax = $quotationActivityData['maxpax'];
						$supplierId = $quotationActivityData['supplierId'];
						$where11=' otherActivityNameId = "'.$activityData['id'].'" and "'.$date.'" BETWEEN fromDate and toDate and supplierId = "'.$supplierId.'" '.$whereMarket.' ';
						$rs11=GetPageRecord('*','dmcotherActivityRate',$where11);
						if(mysqli_num_rows($rs11)>0){

							$dmcActivityData=mysqli_fetch_array($rs11);
							
							$activityCost=addslashes($quotationActivityData['activityCost']);

							$cityName = getDestination($cityId);

							$otherActivityCity=addslashes($quotationActivityData['otherActivityCity']);
							$dateotherActivity=date('Y-m-d',strtotime($quotationActivityData['dateotherActivity']));
							$currencyId=$quotationActivityData['currencyId'];


							$namevalue ='activityCost="'.$activityCost.'",maxpax="'.$maxpax.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",perPaxCost="'.$activityCost.'",otherActivityName="'.$dmcActivityData['otherActivityNameId'].'",otherActivityCity="'.$cityName.'",queryId="'.$queryId.'",dateotherActivity="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue);

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="activity", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);

							//show restriction alert
 							$rs21=GetPageRecord('*','hoteloperationRestriction','otheractivityId="'.$hotelData['id'].'" and "'.$date.'" BETWEEN startDate and endDate  ');
							$msgOpr = '';
							if(mysqli_num_rows($rs21) > 0){
								$oprResData=mysqli_fetch_array($rs21);
								$period = date('d-m-Y',strtotime($oprResData['startDate']))."&nbsp;to&nbsp;".date('d-m-Y',strtotime($oprResData['endDate']));

								$msgError='';
								$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Operation restriction!! Reason :- &nbsp".strip($oprResData['reason'])." Period: ".$period."</p>";
								$hotelError .= $msgError;
								//danger
								errorlogGenerateQuotation($msgError,$newfilez);

							}

				 		}else{
							// show not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Activity - ".$otherActivityName." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}
				}
			}
			if($sorting['serviceType'] == 'guide'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="guide" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and id="'.$sorting1['serviceId'].'"';
					$rs1=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where1);
					if(mysqli_num_rows($rs1)>0){
						$quotationGuideData=mysqli_fetch_array($rs1);

						$rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$quotationGuideData['guideId'].'"');
						$guideData = mysqli_fetch_array($rs11);


						$supplierId = $entranceQuotData['supplierId'];
						$guideId = $guideData['id'];
						$marketId = getQueryMaketType($queryId);
						$whereMarket = '';
						if($marketId>0){
							$whereMarket = ' and marketType="'.$marketId.'"';
												
						}
						$rs1 = GetPageRecord('*','dmcGuidePorterRate','  serviceid = "'.$guideId.'" and supplierId = "'.$quotationGuideData['supplierId'].'" '.$whereMarket.' ');
						if(mysqli_num_rows($rs1)>0){
							$dmcGuideData = mysqli_fetch_array($rs1);

							$tariffId = $dmcGuideData['id'];
							$tariffId = $guideData['id'];
							$supplierId = $dmcGuideData['supplierId'];
							$price=addslashes($dmcGuideData['price']);

							$serviceType = $guideCat['serviceType'];
							$totalDays = $quotationGuideData['totalDays'];

							$namevalue ='fromDate="'.$startDate.'",toDate="'.$startDate.'",serviceType="'.$serviceType.'",destinationId="'.$cityId.'",guideId="'.$guideId.'",tariffId="'.$tariffId.'",supplierId="'.$supplierId.'",price="'.($price*$totalDays).'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",totalDays="'.$totalDays.'",perDaycost="'.$price.'",dayId="'.$dayId.'"';
							$lastid = addlistinggetlastid(_QUOTATION_GUIDE_MASTER_,$namevalue);
							// loop for hotel query inserting number of date

							$namevalue1 ='serviceId="'.$lastid.'",serviceType="guide", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
							addlisting('quotationItinerary',$namevalue1);



						}else{

							// rate not available
							$msgError='';
							$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Guide Service - ".strip($guideData['name'])." : Rate is not available, Previous rate is applicable.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);

						}

					}
				}
			}
			if($sorting['serviceType'] == 'enroute'){
				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="enroute" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){

					$rs1=GetPageRecord('*',_QUOTATION_ENROUTE_MASTER_,' id="'.$sorting1['serviceId'].'" and quotationId="'.$lastQuotationId.'" ');
					$quotationEnrouteData = mysqli_fetch_array($rs1);

					$enrouteSql=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$quotationEnrouteData['enrouteId'].'" ');
					if(mysqli_num_rows($enrouteSql)>0){

						$enrouteData=mysqli_fetch_array($enrouteSql);

						$enrouteName =  $enrouteData['enrouteName'];
						$adultCost=addslashes($enrouteData['adultCost']);
						$childCost=addslashes($enrouteData['childCost']);
						$currencyId=addslashes($enrouteData['currencyId']);

						$namevalue ='fromDate="'.$date.'",toDate="'.$date.'",destinationId="'.$cityId.'",enrouteId="'.$enrouteId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$currencyId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",dayId="'.$startDayId.'"';
						$lastid = addlistinggetlastid(_QUOTATION_ENROUTE_MASTER_,$namevalue);
						// loop for hotel query inserting number of date

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="enroute", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						addlisting('quotationItinerary',$namevalue1);

						if($quotationEnrouteData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}

					}else{
						// rate not available
						$msgError='';
						$msgError = "<p style='color:#D8000C;'>".date('d-m-Y',strtotime($date))." | Enroute - ".$enrouteName." : Rate is not available, Previous rate is applicable.</p>";
						$hotelError .= $msgError;
						errorlogGenerateQuotation($msgError,$newfilez);
					}
				}
			}
			if($sorting['serviceType'] == 'flight'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$flightQuotData = mysqli_fetch_array($rs1);

					$flightId = $flightQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_AIRLINES_MASTER_,'id="'.$flightId.'"');
					$flightData=mysqli_fetch_array($rs1);

					$flightName=addslashes($flightData['flightName']);
					$flightId=addslashes($flightData['id']);
					$childCost=addslashes($flightQuotData['childCost']);
					$adultCost=addslashes($flightQuotData['adultCost']);
					$flightClass=addslashes($flightQuotData['flightClass']);
					$flightNumber=addslashes($flightQuotData['flightNumber']);
					$departureFrom=addslashes($flightQuotData['departureFrom']);
					$arrivalTo=addslashes($flightQuotData['arrivalTo']);
					$departureDate=date('Y-m-d',strtotime($flightQuotData['departureDate']));
					$departureTime=addslashes($flightQuotData['departureTime']);
					$arrivalTime=addslashes($flightQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($flightQuotData['arrivalDate']));

					 $namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",flightId="'.$flightId.'",queryId="'.$queryId.'",destinationId="'.$destinationId.'",quotationId="'.$quotationId.'",departureFrom="'.$departureFrom.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",flightClass="'.$flightClass.'",currencyId="'.$flightQuotData['currencyId'].'",currencyValue="'.$flightQuotData['currencyValue'].'",flightNumber="'.$flightNumber.'",arrivalDate="'.$arrivalDate.'",dayId="'.$dayId.'"';
					$lastid = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="flight", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);

					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Flight - ".$flightName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);

				}
			}
			if($sorting['serviceType'] == 'train'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'" and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					$trainQuotData = mysqli_fetch_array($rs1);

					$trainId = $trainQuotData['trainId'];
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainId.'"');
					$trainData=mysqli_fetch_array($rs1);

					$trainName=addslashes($trainData['trainName']);
					$trainId=addslashes($trainData['id']);
					$childCost=addslashes($trainQuotData['childCost']);
					$adultCost=addslashes($trainQuotData['adultCost']);
					$trainClass=addslashes($trainQuotData['trainClass']);
					$trainNumber=addslashes($trainQuotData['trainNumber']);
					$journeyType=addslashes($trainQuotData['journeyType']);
					$departureFrom=addslashes($trainQuotData['departureFrom']);
					$departureTime=addslashes($trainQuotData['departureTime']);
					$arrivalTime=addslashes($trainQuotData['arrivalTime']);
					$arrivalDate=date('Y-m-d',strtotime($trainQuotData['arrivalDate']));
					$departureDate=date('Y-m-d',strtotime($trainQuotData['departureDate']));
					$arrivalTo=addslashes($trainQuotData['arrivalTo']);

					$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",trainId="'.$trainId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$destinationstart.'",departureFrom="'.$departureFrom.'",journeyType="'.$journeyType.'",arrivalTime="'.$arrivalTime.'",arrivalDate="'.$arrivalDate.'",departureDate="'.$departureDate.'",departureTime="'.$departureTime.'",arrivalTo="'.$arrivalTo.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$trainQuotData['currencyId'].'",currencyValue="'.$trainQuotData['currencyValue'].'",trainClass="'.$trainClass.'",trainNumber="'.$trainNumber.'",dayId="'.$dayId.'"';
					$lastid = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$namevalue);

					$namevalue1 ='serviceId="'.$lastid.'",serviceType="train", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
					addlisting('quotationItinerary',$namevalue1);


					$msgError='';
					$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Train - ".$trainName." : Tour date changed, So update accordingly departure date and arrival date</p>";
					//warning
					$hotelError .= $msgError;
					errorlogGenerateQuotation($msgError,$newfilez);


				}
			}
			if($sorting['serviceType'] == 'mealplan'){
				$where1=' queryId="'.$lastQuotationData['queryId'].'"   and quotationId="'.$lastQuotationId.'"  and dayId="'.$dayId.'" order by id asc';
				$rs1=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where1);
				if(mysqli_num_rows($rs1)>0){
					while($mealplanQuotData=mysqli_fetch_array($rs1)){

						$mealPlanId = $mealplanQuotData['mealPlanName'];
						$rs1=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,'id="'.$mealPlanId.'"');
						$mealplanData=mysqli_fetch_array($rs1);

						$mealPlanName=addslashes($mealplanData['mealPlanName']);
 						$mealType=addslashes($mealplanQuotData['mealPlanmealType']);
						$adultCost=addslashes($mealplanQuotData['mealPlanadultCost']);
						$childCost=addslashes($mealplanQuotData['mealPlanchildCost']);
						$currencyId=addslashes($mealplanQuotData['currencyId']);

						$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",mealType="'.$mealType.'",mealPlanName="'.$mealPlanName.'",destinationId="'.$cityId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",dayId="'.$dayId.'"';
						$lastid = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="mealplan", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						//addlisting('quotationItinerary',$namevalue1);
			 			/*if($mealplanQuotData['adultCost'] <> $adultCost){
							// rate change available
							$msgError='';
							$msgError = "<p style='color:#9F6000;'>".date('d-m-Y',strtotime($date))." | Meal Plan - ".$mealPlanName." : Rate recently updated.</p>";
							$hotelError .= $msgError;
							errorlogGenerateQuotation($msgError,$newfilez);
						}*/

					}
				}
			}
			if($sorting['serviceType'] == 'additional'){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$lastQuotationData['id'].'" and queryId="'.$lastQuotationData['queryId'].'" and dayId="'.$dayId.'" and serviceType="additional" order by srn asc,id desc');
				while($sorting1=mysqli_fetch_array($b1)){
					$ss1=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$lastQuotationData['id'].'" and id="'.$sorting1['serviceId'].'" ');
					$additionalQuotData = mysqli_fetch_array($ss1);

					$rs1=GetPageRecord('*','extraQuotation',"id='".$additionalQuotData['additionalId']."'");
					if(mysqli_num_rows($rs1)>0){
						$additionalData=mysqli_fetch_array($rs1);

						$name=addslashes($additionalData['name']);
						$childCost=addslashes($additionalQuotData['childCost']);
						$adultCost=addslashes($additionalQuotData['adultCost']);
						$groupCost=addslashes($additionalQuotData['groupCost']);
						$currencyValue=addslashes($additionalQuotData['currencyValue']);
						$costType=addslashes($additionalQuotData['costType']);

						$namevalue ='childCost="'.$childCost.'",adultCost="'.$adultCost.'",groupCost="'.$groupCost.'",name="'.$name.'",additionalId="'.$additionalId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$cityId.'",fromDate="'.$date.'",toDate="'.$date.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",costType="'.$costType.'",dayId="'.$dayId.'"';
						// $lastid = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$namevalue);

						$namevalue1 ='serviceId="'.$lastid.'",serviceType="additional", dayId="'.$dayId.'",startDate="'.$date.'",endDate="'.$date.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';
						// addlisting('quotationItinerary',$namevalue1);
					}
				}

			}

		}

	}

 
	//get the alert after process
	//---------------------------------------------------------------------
	// if all day duplicated
	if(mysqli_num_rows($QueryDaysQuery) == $day){
 		
			$msgError='';
			$msgError = "<p style='color:#D8000C;'>----Log file End----.</p>";
			//danger
			errorlogGenerateQuotation($msgError,$newfilez);
			?>
			<script>
			parent.query_alertbox('action=regenrateQuotationInfo&quotationId=<?php echo encode($lastQuotationData['id']); ?>','700px','auto');
			setTimeout( function(){
				parent.$('#regenrateQuotationInfo').html("<?php echo addslashes($hotelError); ?>");
			}  , 1000 );
			parent.$('#pageloading').hide();
			parent.$('#pageloader').hide();
			</script>

		<!-- <script>
		parent.setupbox('showpage.crm?module=quotations&view=yes&id=<?php echo encode($lastQuotationData['id']); ?>&alt=2');
		</script> -->
		<?php 
	}

}

// Update subject from quotation
if(trim($_REQUEST['action'])=='editQuotationName'  && trim($_REQUEST['quotationSubject'])!='' && trim($_REQUEST['quotationId'])!=''){
	$proposalType=addslashes($_REQUEST['proposalType']);
	$namevalue ='quotationSubject="'.addslashes(urldecode($_REQUEST['quotationSubject'])).'"';
	$where='id="'.($_REQUEST['quotationId']).'"';
	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);
	if($update == 'yes'){
		$rsp=GetPageRecord('quotationSubject',_QUOTATION_MASTER_,'id="'.trim($_REQUEST['quotationId']).'"  ');
		$qtdata=mysqli_fetch_array($rsp);
		echo stripslashes($qtdata['quotationSubject']);
	}
}

// update lead pax name from quotation
if(trim($_REQUEST['action'])=='editQuotationLeadPaxName'  && trim($_REQUEST['quotationLeadPax'])!='' && trim($_REQUEST['quotationId'])!=''){
	$proposalType=addslashes($_REQUEST['proposalType']);
	$namevalue ='leadPaxName="'.addslashes(urldecode($_REQUEST['quotationLeadPax'])).'"';
	$where='id="'.($_REQUEST['quotationId']).'"';
	$wherequryId = 'id="'.$_REQUEST['queryId'].'"';

	$update = updatelisting(_QUOTATION_MASTER_,$namevalue,$where);
			 updatelisting(_QUERY_MASTER_,$namevalue,$wherequryId);
	if($update == 'yes'){
		$rsp=GetPageRecord('leadPaxName',_QUOTATION_MASTER_,'id="'.trim($_REQUEST['quotationId']).'"  ');
		$qtdata=mysqli_fetch_array($rsp);
		echo stripslashes($qtdata['leadPaxName']);
	}
}
?>
