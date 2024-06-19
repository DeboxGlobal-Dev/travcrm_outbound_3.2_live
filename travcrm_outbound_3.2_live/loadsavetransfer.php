<?php
include "inc.php";    
 
if($_REQUEST['add']=='yes'){

	if($_REQUEST['transferCategory'] == 'transportation'){
		$transferCategory = 'transportation';
	}else{
		$transferCategory = 'transfer';
	}

	$transferQuoteId = 0;
     
	$startDay = explode('_',$_REQUEST['startDay']);
	$startDayId = $startDay['0'];
	$startDayNum = $startDay['1'];
 
	$endDay = explode('_',$_REQUEST['endDay']);
	$endDayId = $endDay['0'];
	$endDayNum = $endDay['1'];
	
	$departureFrom = $_REQUEST['cityId']; 
	$arrivalTo = $_REQUEST['arrivalTo']; 
	
	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 

	$tarifId = addslashes($_REQUEST['tarifId']); 
	$supplierId = addslashes($_REQUEST['supplierId']); 
	
	$transferType = $_REQUEST['transferType'];    
	$costType= $_REQUEST['costType'];
   
	$quotationId = $newQuotationData['quotationId'];  
	$queryId = $newQuotationData['queryId']; 
	
	$rs12=GetPageRecord('*',_QUERY_MASTER_,'id="'.$queryId.'"'); 
	$queryData=mysqli_fetch_array($rs12); 

	$quotQurey='';
	$quotQurey=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" ');  
	$quotationData=mysqli_fetch_array($quotQurey);

	$calculationType = $quotationData['calculationType'];

	$dayId = $_REQUEST['dayId'];

	$dayQuerys=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['startDay'].'"'); 
	$newQuotationDatas=mysqli_fetch_array($dayQuerys);
    $startDatetp = $newQuotationDatas['srdate'];

	$dayQueryt=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['endDay'].'"'); 
	$newQuotationDatat=mysqli_fetch_array($dayQueryt);
	$endDatetp = $newQuotationDatat['srdate'];

    $destinatonr ="";
	$dayQuerydes=GetPageRecord('*','newQuotationDays','id BETWEEN "'.$newQuotationDatas['id'].'" AND "'.$newQuotationDatat['id'].'" group by cityId'); 
	while ($queryDestinationResult=mysqli_fetch_array($dayQuerydes)) {
		$destinatonr.=$queryDestinationResult['cityId'].',';
	}
	
	if($transferCategory=='transportation'){

		$fromDate=$startDatetp; 
	    $toDate=$endDatetp; 
		$cityId = $newQuotationDatas['cityId'];
		
    	$isGuestType = $_REQUEST['isGuestType'];
    	$isSupplement = $_REQUEST['isSupplement'];
    	$transferQuoteId = $_REQUEST['transferQuoteId'];

		
	}else{

		$fromDate=date("Y-m-d", strtotime($newQuotationData['srdate'])); 
	    $toDate=date("Y-m-d", strtotime($newQuotationData['srdate']));
	    $cityId = $newQuotationData['cityId'];
	    $isGuestType = 1;
	    $isSupplement = $transferQuoteId = 0;
		
	} 

	if($calculationType!=3){
		$rsa2s="";
		$rsa2s=GetPageRecord('*','quotationTransferRateMaster','id="'.$tarifId.'"');  
		if(mysqli_num_rows($rsa2s)>0 && $_REQUEST['tableN'] == 2){  
			$sighseeinginfo=mysqli_fetch_array($rsa2s);
		}else{
			$rs1=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$tarifId.'"'); 
			$sighseeinginfo=mysqli_fetch_array($rs1);
		}
		
		$distance = $sighseeinginfo['distance'];

		$transferNameId=addslashes($sighseeinginfo['transferNameId']); 
		$transferType=addslashes($sighseeinginfo['transferType']); 
		$detail=addslashes($sighseeinginfo['detail']);  
		$vehicleTypeId=addslashes($sighseeinginfo['vehicleTypeId']); 
		$vehicleModelId=addslashes($sighseeinginfo['vehicleModelId']);  
		$gstTax=addslashes($sighseeinginfo['gstTax']);  
		$markupCost=addslashes($sighseeinginfo['markupCost']);  
		$markupType=addslashes($sighseeinginfo['markupType']);  
	}else{
		$transferNameId=addslashes($_REQUEST['serviceid']); 
	}

	$vehicleCost=0;
	
	if(trim($_REQUEST['noOfDays'])<1){ $noOfDays = 1; }else{ $noOfDays = trim($_REQUEST['noOfDays']); }
	
	if($transferCategory=='transfer'){ 
		$transferType = $sighseeinginfo['transferType'];
		if($transferType==1){
			// SIC
			$adultCost = $sighseeinginfo['adultCost'];
			$childCost = $sighseeinginfo['childCost'];
			$infantCost = $sighseeinginfo['infantCost'];

			$adultCost = strip($adultCost)+strip($sighseeinginfo['representativeEntryFee']); 
			$childCost = strip($childCost)+strip($sighseeinginfo['representativeEntryFee']); 
			$infantCost = strip($infantCost)+strip($sighseeinginfo['representativeEntryFee']);
			
			// $markupCostA =  getMarkupCost($adultCost,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
			// $markupCostC =  getMarkupCost($childCost,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
			// $markupCostE =  getMarkupCost($infantCost,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
			// $adultCost = $adultCost+$markupCostA;
			// $childCost = $childCost+$markupCostC;
			// $infantCost = $infantCost+$markupCostE;
			
			// $adultCost= ($adultCost*$gstTax/100)+$adultCost; 
			// $childCost= ($childCost*$gstTax/100)+$childCost; 
			// $infantCost= ($infantCost*$gstTax/100)+$infantCost; 
			$vehicleCost = 0;
		}
		if($transferType==2){
			//PVT
			$adultCost = $childCost =  $infantCost = 0;
			$vehicleCost = $sighseeinginfo['vehicleCost'];
			// $vehicleCost = strip($vehicleCost)+strip($sighseeinginfo['parkingFee'])+strip($sighseeinginfo['representativeEntryFee'])+strip($sighseeinginfo['assistance'])+strip($sighseeinginfo['guideAllowance'])+strip($sighseeinginfo['interStateAndToll'])+strip($sighseeinginfo['miscellaneous']); 
			// $markupCostV =  getMarkupCost($vehicleCost,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
			// $vehicleCost = ($vehicleCost+$markupCostV);
			// $vehicleCost= ($vehicleCost*$gstTax/100)+$vehicleCost; 
		}
		
	}else{
		$transferType = 2;
		$adultCost = $childCost = $infantCost = 0;
		$vehicleCost=(addslashes($sighseeinginfo['vehicleCost']));
		// +addslashes($sighseeinginfo['parkingFee'])+addslashes($sighseeinginfo['representativeEntryFee'])+addslashes($sighseeinginfo['assistance'])+addslashes($sighseeinginfo['guideAllowance'])+addslashes($sighseeinginfo['interStateAndToll'])+addslashes($sighseeinginfo['miscellaneous']);
		// $markupCostV =  getMarkupCost($vehicleCost,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
		// $vehicleCost = ($vehicleCost+$markupCostV);
		$gstTaxAmount = 0;
		// if($gstTax > 0){
		// 	$gstTaxAmount = ($vehicleCost*$gstTax/100);
		// }
		if($costType == 3){
			$vehicleCost= $vehicleCost+$gstTaxAmount;
		}elseif($costType == 1){
			$vehicleCost= ($vehicleCost+$gstTaxAmount)*$noOfDays;
		}else{
			$vehicleCost= $vehicleCost+$gstTaxAmount;
		}
	} 
	
	
	  
	$detail=addslashes($sighseeinginfo['detail']);     
	$currencyId=addslashes($sighseeinginfo['currencyId']);
	// $currencyValue = getCurrencyVal($currencyId);
	$currencyValue = ($sighseeinginfo['currencyValue']>0)?$sighseeinginfo['currencyValue']:getCurrencyVal($currencyId);

	///////////////////////////////////////////////////////////////
	$noOfVehicles = ($_REQUEST['noOfVehicles']>0)?$_REQUEST['noOfVehicles']:1;
	$totalPax = addslashes($_REQUEST['totalPax']);
	// if supplement get same data 
	if($transferQuoteId>0 && $isSupplement==1){
		$rs12=GetPageRecord(' * ',_QUOTATION_TRANSFER_MASTER_,'id="'.$transferQuoteId.'"'); 
		$transferQuoteData = mysqli_fetch_array($rs12); 

		$dayId = $transferQuoteData['dayId'];
		$fromDate = $transferQuoteData['fromDate'];
		$toDate = $transferQuoteData['toDate'];
		$noOfVehicles = $transferQuoteData['noOfVehicles'];
		$noOfDays = $transferQuoteData['noOfDays'];
		$totalPax = $transferQuoteData['totalPax'];
	}

	if($calculationType == 3){
		// complete package costing
		$checkPackageRateQuery="";
		$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($checkPackageRateQuery) > 0){
 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

		    $currencyId = $getPackageRateData['currencyId'];
		    $currencyValue = getCurrencyVal($currencyId);
		    $supplierId = $getPackageRateData['supplierId'];
		}
	}

 	$namevalue = 'fromDate="'.$fromDate.'",toDate="'.$toDate.'",destinationId="'.$cityId.'",transferFromId="'.$transferFromId.'",transferToId="'.$transferToId.'",transferNameId="'.$transferNameId.'",transferType="'.$transferType.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",vehicleType="'.$vehicleTypeId.'",vehicleModelId="'.$vehicleModelId.'",vehicleCost="'.$vehicleCost.'",distance="'.$distance.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",transferQuoteId="'.$transferQuoteId.'",detail="'.$detail.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",tariffId="'.$sighseeinginfo['id'].'",parkingFee="'.$sighseeinginfo['parkingFee'].'",representativeEntryFee="'.$sighseeinginfo['representativeEntryFee'].'",assistance="'.$sighseeinginfo['assistance'].'",guideAllowance="'.$sighseeinginfo['guideAllowance'].'",interStateAndToll="'.$sighseeinginfo['interStateAndToll'].'",miscellaneous="'.$sighseeinginfo['miscellaneous'].'",gstTax="'.$gstTax.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",costType="'.$costType.'",noOfDays="'.$noOfDays.'",dayId="'.$dayId.'",serviceType="'.$transferCategory.'",noOfVehicles="'.$noOfVehicles.'",totalPax="'.$totalPax.'",startDay="'.$startDayNum.'",endDay="'.$endDayNum.'",isSupplement="'.$isSupplement.'",isGuestType="'.$isGuestType.'",capacity="'.$sighseeinginfo['capacity'].'"'; 
	$lastid = addlistinggetlastid(_QUOTATION_TRANSFER_MASTER_,$namevalue);
 
	$namevalue1 ='serviceId="'.$lastid.'",serviceType="'.$transferCategory.'", dayId="'.$dayId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"';  
	addlisting('quotationItinerary',$namevalue1);   
	?>
	<script> 
	<?php if($queryData['queryType']!=3){ ?> 
		<?php } ?>
		closeinbound();
		loadquotationmainfile(); 
	</script>
	<?php
	}	
?>
	
	 