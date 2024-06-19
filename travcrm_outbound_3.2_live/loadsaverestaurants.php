<?php
include "inc.php";  
// load meal plans and addedit
if($_REQUEST['add']=='yes' && $_REQUEST['action'] == 'addedit_QuotationRestaurant'){ 

	$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'" ');  
	$dayData=mysqli_fetch_array($dayQuery);
	
	$quotationId= $dayData['quotationId'];   
	$queryId = $dayData['queryId'];

	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData = mysqli_fetch_array($rs1); 
	$queryId = $quotationData['queryId']; 

	$dayId= $dayData['id']; 
	$dayDate=date('Y-m-d',strtotime($dayData['srdate'])); 
	$destinationId = $_REQUEST['cityId'];

	$escortQuery='';
	$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$quotationId.'" and status=1');
	$escortData=mysqli_fetch_array($escortQuery);

	if($calculationType!=3){

		$dmcId = $_REQUEST['dmcId']; 
		$tableN = $_REQUEST['tableN']; 
		$restaurantId = $_REQUEST['restaurantId']; 
		if($dmcId>0 && $tableN==2){
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,_QUOTATION_RESTAURANT_RATE_MASTER_,$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 
			$remark=addslashes($dmcRateD['remark']); 

			$adultPax = $dmcRateD['adultPax'];
			$childPax = $dmcRateD['childPax'];
			$infantPax = $dmcRateD['infantPax'];
		}else{
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,_DMC_RESTAURANT_RATE_MASTER_,$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 
			$remark=addslashes($dmcRateD['remarks']);

			$adultPax=addslashes($quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']); 
			$childPax=addslashes($quotationData['child']);
			$infantPax=addslashes($quotationData['infant']);
		}

		$rs2=GetPageRecord('mealPlanName,id',_INBOUND_MEALPLAN_MASTER_,'id="'.$restaurantId.'"'); 
		$activityData=mysqli_fetch_array($rs2); 

		$mealPlanName = $activityData['mealPlanName']; 
		$mealPlanId = $activityData['id']; 
		$supplierId = $dmcRateD['supplierId']; 

		$gstTax = $dmcRateD['gstTax']; 
		$markupType = $dmcRateD['markupType']; 
		$markupCost = $dmcRateD['markupCost']; 

		$adultCost=$childCost=$infantCost=0;
		$markupCostA=$markupCostC=$markupCostE=0;
		// $markupCostA =  getMarkupCost($dmcRateD['adultCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
		// $markupCostC =  getMarkupCost($dmcRateD['childCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
		// $markupCostE =  getMarkupCost($dmcRateD['infantCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);

		// $adultCost = getCostWithGST(($dmcRateD['adultCost']+$markupCostA),getGstValueById($dmcRateD['gstTax']),0);
		// $childCost = getCostWithGST(($dmcRateD['childCost']+$markupCostC),getGstValueById($dmcRateD['gstTax']),0); 
		// $infantCost = getCostWithGST(($dmcRateD['infantCost']+$markupCostE),getGstValueById($dmcRateD['gstTax']),0); 

		$adultCost = ($dmcRateD['adultCost']);
		$childCost = ($dmcRateD['childCost']);
		$infantCost = ($dmcRateD['infantCost']);

		$mealType=addslashes($dmcRateD['mealPlanType']);
		$currencyId=addslashes($dmcRateD['currencyId']);  
		$currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:getCurrencyVal($currencyId);
	}else{
		// complete package costing
		$checkPackageRateQuery="";
		$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($checkPackageRateQuery) > 0){
 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

		    $currencyId = $getPackageRateData['currencyId'];
		    $currencyValue = ($getPackageRateData['currencyValue']>0)?$getPackageRateData['currencyValue']:getCurrencyVal($currencyId);
		    $supplierId = $getPackageRateData['supplierId'];
		}

		$dmcId=$adultCost=$childCost=$infantCost=0;
	}	

	$namevalue ='fromDate="'.$dayDate.'",toDate="'.$dayDate.'",destinationId="'.$destinationId.'",mealPlanName="'.$mealPlanName.'",mealPlanId="'.$mealPlanId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",gstTax="'.$gstTax.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",remark="'.$remark.'",mealType="'.$mealType.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",dmcId="'.$dmcId.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",dayId="'.$dayId.'"';
	// exit;
	$lastid = addlistinggetlastid(_QUOTATION_RESTAURANT_MASTER_,$namevalue); 
	// loop for hotel query inserting number of date 
 
	$namevalue1 ='serviceId="'.$lastid.'",serviceType="mealplan", dayId="'.$dayId.'",startDate="'.$dayDate.'",endDate="'.$dayDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
	?> 
	<script type="text/javascript">
		closeinbound();
		loadquotationmainfile(); 
	</script>
	<?php

}
 
?>