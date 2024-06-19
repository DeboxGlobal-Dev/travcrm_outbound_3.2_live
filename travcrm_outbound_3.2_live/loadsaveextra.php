<?php
include "inc.php";

if($_REQUEST['additionalId']!='' && $_REQUEST['action'] == 'loadAdditionalCost'){
 	$rs1=GetPageRecord('*','extraQuotation','id="'.$_REQUEST['additionalId'].'"');
	$otherActivityData1=mysqli_fetch_array($rs1);
	$childCost=addslashes($otherActivityData1['childCost']);
	$adultCost=addslashes($otherActivityData1['adultCost']);
	$groupCost=addslashes($otherActivityData1['groupCost']);

	$currencyId = ($otherActivityData1['currencyId']>0) ? $otherActivityData1['currencyId'] : $baseCurrencyId;
	$currencyValue = getCurrencyVal($currencyId);

	if($otherActivityData1['costType']==1){
	?>
	<script type="text/javascript">
		parent.$('#additionalAdultCost').val(<?php echo $adultCost; ?>);
		parent.$('#additionalChildCost').val(<?php echo $childCost; ?>);
		parent.$('#additionalCurrency').val('<?php echo $currencyId; ?>');
		parent.$('#additionalcostType').val(1);

		parent.$('.pp').show();
		parent.$('.tot').hide();
		parent.$('#additionalGroupCost').val('');
		parent.$('#additionalCurrency').val("<?php echo $currencyId; ?>");
	</script>
	<?php
   }
   if($otherActivityData1['costType']==2){
    ?>
	<script type="text/javascript">

		parent.$('#additionalAdultCost').val('');
		parent.$('#additionalChildCost').val('');
		parent.$('#additionalcostType').val(2);
		parent.$('#additionalGroupCost').val(<?php echo $groupCost; ?>);
		parent.$('#additionalCurrency').val("<?php echo $currencyId; ?>");
		parent.$('.pp').hide();
		parent.$('.tot').show();
	</script>
	<?php
   }
}

if($_REQUEST['add']=='yes' && $_REQUEST['action']=='addedit_QuotationExtra' && $_REQUEST['quotationId']!='' && $_REQUEST['additionalId']!=0){

	$rs1=GetPageRecord(' * ','newQuotationDays','id="'.$_REQUEST['dayId'].'"');
	$newQuoteData = mysqli_fetch_array($rs1);
	$quotationId = $newQuoteData['quotationId'];
	$queryId = $newQuoteData['queryId'];
	$srdate = $newQuoteData['srdate'];
	$cityId = $newQuoteData['cityId'];
	$tableN = $_REQUEST['tableN'];
 	
	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData = mysqli_fetch_array($rs1); 

	$escortQuery='';
	$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$quotationId.'" and status=1');
	$escortData=mysqli_fetch_array($escortQuery);

	$additionalId = $_REQUEST['additionalId'];
	$rateId = $_REQUEST['rateId'];
	$destinationId = getDestination($cityId);
 
	if($tableN==1){
		$rs1=GetPageRecord('*','extraQuotation',"id='".$additionalId."'");
		$sighseeinginfo=mysqli_fetch_array($rs1);
		$additionalId= $additionalId;

		$adultPax=addslashes($quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']); 
		$childPax=addslashes($quotationData['child']);
		$infantPax=addslashes($quotationData['infant']);

		$supplierId = $sighseeinginfo['supplierId'];
		if($supplierId < 1){ 			
			$suppSql=""; 
			$suppSql=GetPageRecord('id','suppliersMaster',' self=1'); 
			$supplierData=mysqli_fetch_array($suppSql);
			$supplierId = $supplierData['id'];
		} 
		
	}elseif($tableN==2){
		$rs1=GetPageRecord('*','quotationAdditionalRateMaster',"id='".$additionalId."'");
		$sighseeinginfo=mysqli_fetch_array($rs1);
		$additionalId = $sighseeinginfo['additionalId'];

		$adultPax = $sighseeinginfo['adultPax'];
		$childPax = $sighseeinginfo['childPax'];
		$infantPax = $sighseeinginfo['infantPax'];
		
		$supplierId=$sighseeinginfo['supplierId'];
	}

	$name=addslashes($sighseeinginfo['name']);
	
	$gstTax=$sighseeinginfo['gstTax'];
	$isMarkupApply=$sighseeinginfo['isMarkupApply'];
	$remark=$sighseeinginfo['remark'];

	$adultCost2=$sighseeinginfo['adultCost'];
	$childCost2=$sighseeinginfo['childCost']; 
	$infantCost2=$sighseeinginfo['infantCost'];
	
	$groupCost2=$sighseeinginfo['groupCost'];

	// $groupMarkup =  getMarkupCost($groupCost21,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
	// $adultMarkup =  getMarkupCost($adultCost21,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
	// $childMarkup =  getMarkupCost($childCost21,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);
	// $infantMarkup =  getMarkupCost($infantCost21,$sighseeinginfo['markupCost'],$sighseeinginfo['markupType']);

    // $groupCost = $groupCost21+$groupMarkup;
	// $adultCost = $adultCost21+$adultMarkup;
	// $childCost = $childCost21+$childMarkup;
	// $infantCost = $infantCost21+$infantMarkup;


    //  $groupCost2= round(($groupCost*$gstValue/100)+$groupCost); 
    //  $adultCost2= round(($adultCost*$gstValue/100)+$adultCost); 
    //  $childCost2= round(($childCost*$gstValue/100)+$childCost); 
    //  $infantCost2= round(($infantCost*$gstValue/100)+$infantCost); 

	$otherInfo=$sighseeinginfo['otherInfo'];

	$currencyId = ($_REQUEST['currencyId']>0) ? $_REQUEST['currencyId'] : $baseCurrencyId; 
	$currencyValue = ($sighseeinginfo['currencyValue']>0)?$sighseeinginfo['currencyValue']:getCurrencyVal($currencyId);
	
	$costType=$sighseeinginfo['costType'];
	$markupCost=$sighseeinginfo['markupCost'];
	$markupType=$sighseeinginfo['markupType'];
	if($costType == 2){
        $adultCost = 0;
        $childCost = 0;
        $infantCost = 0;
        $groupCost = $groupCost2;
	}else{
        $adultCost = $adultCost2;
        $childCost = $childCost2;
        $infantCost = $infantCost2;
        $groupCost = 0;
	}

	if($currencyValue>0){
		$namevalue ='adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",name="'.$name.'",additionalId="'.$additionalId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$cityId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",costType="'.$costType.'",groupCost="'.$groupCost.'",gstTax="'.$gstTax.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",isMarkupApply="'.$isMarkupApply.'",supplierId="'.$supplierId.'",remark="'.$remark.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",dayId="'.$newQuoteData['id'].'",information="'.$otherInfo.'"';
		$lastid = addlistinggetlastid(_QUOTATION_EXTRA_MASTER_,$namevalue);

		$namevalue1 ='serviceId="'.$lastid.'",serviceType="additional", dayId="'.$newQuoteData['id'].'",startDate="'.$srdate.'",endDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$newQuoteData['id'].'"'; 
		addlisting('quotationItinerary',$namevalue1);
		?>
		<script>
		// closeinbound();
		loadquotationmainfile();
		</script>
		<?php
	}else{
		?>
		<script>
		alert('Currency ROE Not found in master currency rate sheet.');
		</script>
		<?php
	}
}



if($_REQUEST['additionalRateId']!='' && $_REQUEST['action'] == 'loadHotelAdditionalCost'){
	$costType=1;
	$HAGST=0;
	$additionalCost=0;

	if($_REQUEST['isRateId']==0){

		$rs=GetPageRecord('*','additionalHotelMaster','id="'.$_REQUEST['additionalRateId'].'"'); 
		$additinalres=mysqli_fetch_array($rs);

		$result1=GetPageRecord('*','dmcAdditionalHotelRate','additionalName="'.$additinalres['id'].'" and isQuoteRate=1');
		if(mysqli_num_rows($result1)>0){
			$hotelAdditional=mysqli_fetch_array($result1);
			$costType=addslashes($hotelAdditional['personWise']);
			$HAGST=addslashes($hotelAdditional['gsttax']);
			$additionalCost=addslashes($hotelAdditional['additionalCost']); 
		}
 	}else{
	 	$result1=GetPageRecord('*','dmcAdditionalHotelRate','id="'.$_REQUEST['additionalRateId'].'"');
		$hotelAdditional=mysqli_fetch_array($result1);
		$costType=addslashes($hotelAdditional['personWise']);
		$HAGST=addslashes($hotelAdditional['gsttax']);
		$additionalCost=addslashes($hotelAdditional['additionalCost']);
 	}
	?>
	<script type="text/javascript">
		parent.$('#costType').val('<?php echo $costType; ?>');
		parent.$('#additionalcost').val('<?php echo $additionalCost; ?>');
		<?php if($HAGST>0){ ?>
		parent.$('#HAGST').val('<?php echo $HAGST; ?>'); 
		<?php } ?>
	</script>
 	<?php
}


if($_REQUEST['add']=='yes' && $_REQUEST['action']=='addedit_additionalHotelQuotation' && $_REQUEST['hotelQuoteId']!='' && $_REQUEST['additionalRateId']!=''){

	$res12=GetPageRecord(' * ','newQuotationDays','id="'.$_REQUEST['dayId'].'"');
	$newQuoteData = mysqli_fetch_array($res12);
	$quotationId = $newQuoteData['quotationId'];
	$queryId = $newQuoteData['queryId'];
	$srdate = $newQuoteData['srdate'];
	$cityId = $newQuoteData['cityId']; 

	$isRateId = $_REQUEST['isRateId'];
	$additionalRateId = $_REQUEST['additionalRateId'];
	$destinationId = getDestination($cityId);

	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"');
	$quotationData = mysqli_fetch_array($rs1);


	$c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$_REQUEST['hotelQuoteId'].'"');
	$hotelQuotData=mysqli_fetch_array($c);

	$hotelId=addslashes($hotelQuotData['supplierId']);
	$hotelQuoteId=addslashes($hotelQuotData['id']);
	$costType=addslashes($_REQUEST['costType']);
	$gstTaxId=addslashes($_REQUEST['HAGST']);
	$additionalCost=addslashes($_REQUEST['additionalCost']);


	if($isRateId == 1){
		$rs22=GetPageRecord('*','dmcAdditionalHotelRate',"id='".$additionalRateId."'");
		$sighseeinginfo=mysqli_fetch_array($rs22);


		$rs33=GetPageRecord('*','additionalHotelMaster',"id='".$sighseeinginfo['additionalName']."'");
		$additionalHData=mysqli_fetch_array($rs33);

		$name=addslashes($additionalHData['name']);
		// $gstTaxId=addslashes($sighseeinginfo['gsttax']);  
		$gstTaxV=getGstValueById($gstTaxId);  
		$currencyId = $sighseeinginfo['currencyId'];

		$gstTaxAmount = 0;
		if($gstTaxV > 0){
			$gstTaxAmount = ($additionalCost*$gstTaxV/100);
		}
		$additionalCost= round($additionalCost+$gstTaxAmount);

	}else{

		$rs33=GetPageRecord('*','additionalHotelMaster'," id='".$additionalRateId."'");
		$additionalHData=mysqli_fetch_array($rs33);

		$name=addslashes($additionalHData['name']);
		$currencyId = $baseCurrencyId;
 		
		$gstTaxV=getGstValueById($gstTaxId);  
 		$gstTaxAmount = 0;
		if($gstTaxV > 0){
			$gstTaxAmount = ($additionalCost*$gstTaxV/100);
		}
		$additionalCost= round($additionalCost+$gstTaxAmount);
		$modifyDate = time();

		$allvaluephone ='hotelId="'.$hotelId.'",rateId="'.$hotelQuotData['roomTariffId'].'",additionalName="'.$additionalHData['id'].'",gsttax="'.$gstTaxId.'",personWise="'.$costType.'",additionalCost="'.$additionalCost.'",dateAdded="'.$modifyDate.'",addedBy="'.$_SESSION['userid'].'",status=1,isQuoteRate=1';
		$additionalRateId = addlistinggetlastid('dmcAdditionalHotelRate',$allvaluephone);

	}

	$namevalue ='hotelId="'.$hotelId.'",hotelQuotId="'.$hotelQuoteId.'",gstTax="'.$gstTaxId.'",additionalCost="'.$additionalCost.'",name="'.$name.'",additionalId="'.$additionalHData['id'].'",costType="'.$costType.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",destinationId="'.$cityId.'",fromDate="'.$srdate.'",toDate="'.$srdate.'",currencyId="'.$currencyId.'",dayId="'.$newQuoteData['id'].'",rateId="'.$additionalRateId.'"';
	$lastid = addlistinggetlastid('quotationHotelAdditionalMaster',$namevalue);

	//   quotationRoomSupplimentMaster
	// $namevalue1 ='serviceId="'.$lastid.'",serviceType="hotelAdditional", dayId="'.$newQuoteData['id'].'",startDate="'.$srdate.'",endDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$newQuoteData['id'].'"'; 
	
	// addlisting('quotationItinerary',$namevalue1);
	?>
	<script>
	closeinbound();
	loadquotationmainfile();
	</script>
	<?php
}
?>
