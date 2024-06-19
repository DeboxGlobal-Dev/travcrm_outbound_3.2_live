<?php
include "inc.php";  
// load meal plans and addedit
if($_REQUEST['add']=='yes' && $_REQUEST['action'] == 'addedit_Quotationtrain'){ 

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
	 
	$isGuestType=$isLocalEscort=$isForeignEscort=0;
	if($_REQUEST['isLocalEscort'] == 0 && $_REQUEST['isForeignEscort'] == 0 ){
		$isGuestType = 1; 
	}else{
		$isGuestType = $_REQUEST['isGuestType']; 
		$isLocalEscort = $_REQUEST['isLocalEscort']; 
		$isForeignEscort = $_REQUEST['isForeignEscort']; 
	}

	if($calculationType!=3){

		$dmcId = $_REQUEST['dmcId']; 
		$tableN = $_REQUEST['tableN']; 
		$trainId = $_REQUEST['trainId']; 
		$departureFrom = $_REQUEST['departureFrom']; 
		$arrivalTo = $_REQUEST['arrivalTo']; 

		$trainHub=addslashes($_REQUEST['trainHub']);

		if($dmcId>0 && $tableN==2){
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,_QUOTATION_TRAIN_RATE_MASTER_,$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 
			$entranceNameId=addslashes($dmcRateD['serviceId']);   
			$detail=addslashes($dmcRateD['remark']);  

			$adultPax = $dmcRateD['adultPax'];
			$childPax = $dmcRateD['childPax'];
			$infantPax = $dmcRateD['infantPax'];
		}else{
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,_DMC_TRAIN_RATE_MASTER_,$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 
			$entranceNameId=addslashes($dmcRateD['entranceNameId']);   
			$detail=addslashes($dmcRateD['remarks']);

			$adultPax=addslashes($quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']); 
			$childPax=addslashes($quotationData['child']);
			$infantPax=addslashes($quotationData['infant']);
		}

		$supplierId = $dmcRateD['supplierId']; 
		$gstTax = $dmcRateD['gstTax']; 
		$markupType = $dmcRateD['markupType']; 
		$markupCost = $dmcRateD['markupCost']; 
		$remark = $dmcRateD['remark']; 

		$adultCost=$childCost=$infantCost=0;

		// $markupCostA =  getMarkupCost($dmcRateD['adultCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
		// $markupCostC =  getMarkupCost($dmcRateD['childCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
		// $markupCostE =  getMarkupCost($dmcRateD['infantCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);

		// $adultCost = getCostWithGST(($dmcRateD['adultCost']+$markupCostA),getGstValueById($dmcRateD['gstTax']),0);
		// $childCost = getCostWithGST(($dmcRateD['childCost']+$markupCostC),getGstValueById($dmcRateD['gstTax']),0);
		// $infantCost = getCostWithGST(($dmcRateD['infantCost']+$markupCostE),getGstValueById($dmcRateD['gstTax']),0);

		$adultCost = round($dmcRateD['adultCost']);
		$childCost = round($dmcRateD['childCost']);
		$infantCost = round($dmcRateD['infantCost']);

		$trainClass=addslashes($dmcRateD['trainClass']);
		$journeyType=addslashes($dmcRateD['journeyType']);
		$trainNumber=addslashes($dmcRateD['trainNumber']); 
   
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
	
	$namevalue ='fromDate="'.$dayDate.'",toDate="'.$dayDate.'",destinationId="'.$destinationId.'",trainId="'.$trainId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",gstTax="'.$gstTax.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",adult="'.$adult.'",child="'.$child.'",departureFrom="'.$departureFrom.'",arrivalTo="'.$arrivalTo.'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",arrivalDate="'.$arrivalDate.'",departureDate="'.$departureDate.'",isGuestType="'.$isGuestType.'",isLocalEscort="'.$isLocalEscort.'",isForeignEscort="'.$isForeignEscort.'",trainClass="'.$trainClass.'",trainNumber="'.$trainNumber.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",dmcId="'.$dmcId.'",remark="'.$remark.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",dayId="'.$dayId.'"';
	
	$lastid = addlistinggetlastid(_QUOTATION_TRAINS_MASTER_,$namevalue); 
	// loop for hotel query inserting number of date 
 
	$namevalue1 ='serviceId="'.$lastid.'",serviceType="train", dayId="'.$dayId.'",startDate="'.$dayDate.'",endDate="'.$dayDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
	?> 
	<script type="text/javascript">
		closeinbound();
		loadquotationmainfile(); 
	</script>
	<?php

}
 
?>