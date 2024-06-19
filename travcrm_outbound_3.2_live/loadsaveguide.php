<?php
include "inc.php";  
if($_REQUEST['add']=='yes'){
	
	$quotationId= $_REQUEST['quotationId']; 
	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData = mysqli_fetch_array($rs1); 
	$queryId = $quotationData['queryId'];
	$calculationType = $quotationData['calculationType'];

	// Service added in this day
	$dayIdQuery='';
	$dayIdQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'" ');  
	$dayIdData=mysqli_fetch_array($dayIdQuery);

	$dayId = $dayIdData['id'];
	$srdate = $dayIdData['srdate'];
	$destinationId = $dayIdData['cityId'];
	
	// $serviceType = $_REQUEST['serviceType'];
	$isGuestType = $_REQUEST['isGuestType'];
	$isSupplement = $_REQUEST['isSupplement'];
	$guideQuoteId = $_REQUEST['guideQuoteId'];
	$slabId = $_REQUEST['slabId'];
	$totalDays = $_REQUEST['totalDays'];
	$select1 = '*';
	$tariffId = $_REQUEST['tariffId'];
	
	if($calculationType!=3){
		if($_REQUEST['tariffId']!='' && $_REQUEST['tableN']==2){

			$select1 = '*';  
			$where1= 'id="'.$tariffId.'"'; 
			$rs1 = GetPageRecord($select1,'quotationGuideRateMaster',$where1); 
			$dmcroommastermain = mysqli_fetch_array($rs1); 
			$tariffId = $dmcroommastermain['id'];
			$currencyId = $dmcroommastermain['currencyId'];
			$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
			// $currencyValue = $dmcroommastermain['currencyValue'];
			
			$startDate=date('Y-m-d',strtotime($startDate));  

			$gstValue=getGstValueById($dmcroommastermain['guideGST']); 

			$guideCost = $langAlloCost = $otherCost = 0;

			$guideCost = strip($dmcroommastermain['price']);
			$langAlloCost = strip($dmcroommastermain['languageAllowance']);
			$otherCost = strip($dmcroommastermain['otherCost']);

			// $guideMarkup =  getMarkupCost($guideCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
			// $langMarkup =  getMarkupCost($langAlloCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
			// $otherMarkup =  getMarkupCost($otherCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

			// $guideCost = $guideCost+$guideMarkup;
			// $langAlloCost = $langAlloCost+$langMarkup;
			// $otherCost = $otherCost+$otherMarkup;

			// $guideCost= round(($guideCost*$gstValue/100)+($guideCost)); 
			// $langAlloCost= round(($langAlloCost*$gstValue/100)+($langAlloCost)); 
			// $otherCost= round(($otherCost*$gstValue/100)+($otherCost)); 

		}else{

			$select1 = '*';  
			$where1= 'id="'.$tariffId.'"'; 
			$rs1 = GetPageRecord($select1,'dmcGuidePorterRate',$where1); 
			$dmcroommastermain = mysqli_fetch_array($rs1); 
			$tariffId = $dmcroommastermain['id'];
			$currencyId = $dmcroommastermain['currencyId'];
			$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
			// $currencyValue = $dmcroommastermain['currencyValue'];

			$startDate=date('Y-m-d',strtotime($startDate));  
			$gstValue=getGstValueById($dmcroommastermain['guideGST']); 

			$guideCost = $langAlloCost = $otherCost = 0;

			$guideCost = strip($dmcroommastermain['price']);
			$langAlloCost = strip($dmcroommastermain['languageAllowance']);
			$otherCost = strip($dmcroommastermain['otherCost']);

			// $guideMarkup =  getMarkupCost($guideCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
			// $langMarkup =  getMarkupCost($langAlloCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);
			// $otherMarkup =  getMarkupCost($otherCost,$dmcroommastermain['markupCost'],$dmcroommastermain['markupType']);

			// $guideCost = $guideCost+$guideMarkup;
			// $langAlloCost = $langAlloCost+$langMarkup;
			// $otherCost = $otherCost+$otherMarkup;

			// $guideCost= round(($guideCost*$gstValue/100)+($guideCost)); 
			// $langAlloCost= round(($langAlloCost*$gstValue/100)+($langAlloCost)); 
			// $otherCost= round(($otherCost*$gstValue/100)+($otherCost)); 

		}
		$guideId = $dmcroommastermain['serviceid'];
		$supplierId = $dmcroommastermain['supplierId'];
		$paxRange = $dmcroommastermain['paxRange'];
		$dayType = $dmcroommastermain['dayType'];

		$guideGST = $dmcroommastermain['guideGST'];
		$markupType = $dmcroommastermain['markupType'];
		$markupCost = $dmcroommastermain['markupCost'];
		 
		// $price= round($guideCost+$langAlloCost+$otherCost);

	}else{
		// complete package costing
		$checkPackageRateQuery="";
		$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($checkPackageRateQuery) > 0){
 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

		    $currencyId = $getPackageRateData['currencyId'];
		    $currencyValue = getCurrencyVal($currencyId);
		    $supplierId = $getPackageRateData['supplierId'];
		}

		$guideId  = $_REQUEST['serviceid'];
		$tariffId  = 0;
		$price  = 0;
		$paxRange  = 0;
		$dayType = 'fullday';
	}
	
	$rs11 = GetPageRecord('serviceType','tbl_guidesubcatmaster',' id = "'.$guideId.'"'); 
	$guideCat = mysqli_fetch_array($rs11); 
	$serviceType = $guideCat['serviceType'];
	
	// if supplement get same data 
	if($guideQuoteId>0 && $isSupplement==1){
		$rs12=GetPageRecord(' * ',_QUOTATION_GUIDE_MASTER_,'id="'.$guideQuoteId.'"'); 
		$guideQuoteData = mysqli_fetch_array($rs12); 

		$totalDays = $guideQuoteData['totalDays'];
		$dayId = $guideQuoteData['dayId'];
		$srdate = $guideQuoteData['fromDate'];
		$slabId = $guideQuoteData['slabId'];
		$destinationId = $guideQuoteData['destinationId'];
	}
	
	 $namevalue ='fromDate="'.$srdate.'",toDate="'.$srdate.'",slabId="'.$slabId.'",serviceType="'.$serviceType.'",paxRange="'.$paxRange.'",dayType="'.$dayType.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",destinationId="'.$destinationId.'",supplierId="'.$supplierId.'",guideId="'.$guideId.'",tariffId="'.$tariffId.'",price="'.$guideCost.'",languageAllowance="'.$langAlloCost.'",otherCost="'.$otherCost.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",totalDays="'.$totalDays.'",perDaycost="'.$guideCost.'",dayId="'.$dayId.'",isGuestType="'.$isGuestType.'",isSupplement="'.$isSupplement.'",guideQuoteId="'.$guideQuoteId.'",gstTax="'.$guideGST.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'"';
	$lastid = addlistinggetlastid(_QUOTATION_GUIDE_MASTER_,$namevalue); 
	// loop for hotel query inserting number of date 
	if($guideQuoteId==0 && $isGuestType==1){

		$namevalue1 ='serviceId="'.$lastid.'",serviceType="guide",dayId="'.$dayId.'",startDate="'.$srdate.'",endDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
		addlisting('quotationItinerary',$namevalue1); 

	}
	?> 
	<script type="text/javascript"> 
		closeinbound();
		selectthisE(<?php echo $tariffId; ?>,<?php echo $_REQUEST['tableN']; ?>)
		loadquotationmainfile(); 
	</script>
	
<?php 
} 
?>