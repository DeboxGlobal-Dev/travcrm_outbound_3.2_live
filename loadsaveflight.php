<?php
include "inc.php";  
 
if($_REQUEST['add']=='yes' && $_REQUEST['action'] == 'addedit_Quotationflight'){ 

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
		$flightId = $_REQUEST['flightId']; 
		$departureFrom = $_REQUEST['departureFrom']; 
		$arrivalTo = $_REQUEST['arrivalTo']; 

		if($dmcId>0 && $tableN==2){
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,_QUOTATION_FLIGHT_RATE_MASTER_,$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 
			$entranceNameId=addslashes($dmcRateD['serviceId']);   
			$detail=addslashes($dmcRateD['remark']);   

			$adultPax = $dmcRateD['adultPax'];
			$childPax = $dmcRateD['childPax'];
			$infantPax = $dmcRateD['infantPax'];
		}else{
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,_DMC_FLIGHT_RATE_MASTER_,$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 
			$entranceNameId=addslashes($dmcRateD['entranceNameId']);   
			$detail=addslashes($dmcRateD['remarks']);

			$adultPax=addslashes($quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']); 
			$childPax=addslashes($quotationData['child']);
			$infantPax=addslashes($quotationData['infant']);
		}

		$supplierId = $dmcRateD['supplierId']; 
		$gstTax = $dmcRateD['gstTax']; 
		$markupCost = $dmcRateD['markupCost']; 
		$markupType = $dmcRateD['markupType']; 

		$adultCost=$childCost=$infantCost=$baggageAllowance=0;

		// $markupCostA =  getMarkupCost($dmcRateD['adultCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
		// $markupCostC =  getMarkupCost($dmcRateD['childCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);
		// $markupCostE =  getMarkupCost($dmcRateD['infantCost'],$dmcRateD['markupCost'],$dmcRateD['markupType']);

		// $adultCost = getCostWithGST(($dmcRateD['adultCost']+$markupCostA),getGstValueById($dmcRateD['gstTax']),0);
		// $childCost = getCostWithGST(($dmcRateD['childCost']+$markupCostC),getGstValueById($dmcRateD['gstTax']),0);
		// $infantCost = getCostWithGST(($dmcRateD['infantCost']+$markupCostE),getGstValueById($dmcRateD['gstTax']),0);

		$adultCost = round($dmcRateD['adultCost']);
		$childCost = round($dmcRateD['childCost']);
		$infantCost = round($dmcRateD['infantCost']);

		$flightClass=addslashes($dmcRateD['flightClass']);
		$baggageAllowance=addslashes($dmcRateD['baggageAllowance']);
		$flightNumber=addslashes($dmcRateD['flightNumber']); 

		$currencyId=addslashes($dmcRateD['currencyId']);  
		$currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:getCurrencyVal($currencyId);
		// $hubId=addslashes($dmcRateD['hubId']);  
		// $flightHub=addslashes($dmcRateD['hubId']);
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

		$dmcId=$adultCost=$childCost=$infantCost=$infantCost=$baggageAllowance=0;
	}

	 $namevalue ='fromDate="'.$dayDate.'",toDate="'.$dayDate.'",destinationId="'.$destinationId.'",flightId="'.$flightId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",adult="'.$adult.'",child="'.$child.'",infant="'.$infant.'",departureFrom="'.$departureFrom.'",arrivalTo="'.$arrivalTo.'",departureTime="'.$departureTime.'",arrivalTime="'.$arrivalTime.'",arrivalDate="'.$arrivalDate.'",departureDate="'.$departureDate.'",isGuestType="'.$isGuestType.'",isLocalEscort="'.$isLocalEscort.'",isForeignEscort="'.$isForeignEscort.'",flightClass="'.$flightClass.'",flightNumber="'.$flightNumber.'",baggageAllowance="'.$baggageAllowance.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",gstTax="'.$gstTax.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",supplierId="'.$supplierId.'",dmcId="'.$dmcId.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",totalAdult="'.$adult.'",totalChild="'.$child.'",dayId="'.$dayId.'",remark="'.$detail.'"';
	$lastid = addlistinggetlastid(_QUOTATION_FLIGHT_MASTER_,$namevalue); 
	// loop for hotel query inserting number of date 
 
	$namevalue1 ='serviceId="'.$lastid.'",serviceType="flight", dayId="'.$dayId.'",startDate="'.$dayDate.'",endDate="'.$dayDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
	?> 
	<script type="text/javascript">
		closeinbound();
		loadquotationmainfile(); 
	</script>
	<?php

}
?>
