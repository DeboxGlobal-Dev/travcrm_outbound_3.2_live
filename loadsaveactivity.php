<?php
include "inc.php";  
if($_REQUEST['add']=='yes'){
		
	$quotationId= $_REQUEST['quotationId']; 
	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData = mysqli_fetch_array($rs1); 
	$queryId = $quotationData['queryId'];
	$calculationType = $quotationData['calculationType'];

	$escortQuery='';
	$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$quotationId.'" and status=1');
	$escortData=mysqli_fetch_array($escortQuery);

	// Service added in this day
	$dayIdQuery='';
	$dayIdQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'" ');  
	$dayIdData=mysqli_fetch_array($dayIdQuery);

	$dayId = $dayIdData['id'];
	$srdate = $dayIdData['srdate'];

	$totalDays = $_REQUEST['totalDays'];
	$destinationId = $_REQUEST['destinationId'];
	$slabId = $_REQUEST['slabId'];
	$dmcId = $_REQUEST['dmcId'];
	$tableN = $_REQUEST['tableN'];
	$serviceId = $_REQUEST['serviceId'];
	$noOfVehicles = $_REQUEST['noOfVehicles'];

	if($calculationType!=3){
		if($dmcId!='' && $tableN==2){
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,'quotationActivityRateMaster',$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 

			$adultPax = $dmcRateD['adultPax'];
			$childPax = $dmcRateD['childPax'];
			$infantPax = $dmcRateD['infantPax'];
			$noOfVehicles = $dmcRateD['noOfVehicles'];

		}else{
			$select1 = '*';  
			$where1= 'id="'.$dmcId.'"'; 
			$rs1 = GetPageRecord($select1,'dmcotherActivityRate',$where1); 
			$dmcRateD = mysqli_fetch_array($rs1); 

			$adultPax=$quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']; 
			$childPax=$quotationData['child'];
			$infantPax=$quotationData['infant'];
		}

		$dmcId = $dmcRateD['id'];
		$currencyId = $dmcRateD['currencyId'];
		$currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:getCurrencyVal($currencyId);
		$gstTax = $dmcRateD['gstTax'];

		$transferType=addslashes($dmcRateD['transferType']);

		$ticketAdultCost = round($dmcRateD['ticketAdultCost']);
		$ticketchildCost = round($dmcRateD['ticketchildCost']);
		$ticketinfantCost = round($dmcRateD['ticketinfantCost']);
		
		$adultCost=$childCost=$infantCost=$vehicleId=$vehicleCost=0;
		if($transferType==1){ 
			$adultCost = round($dmcRateD['adultCost']);
			$childCost = round($dmcRateD['childCost']);
			$infantCost = round($dmcRateD['infantCost']);
		}elseif($transferType==2 || $transferType==3){
			$vehicleId=addslashes($dmcRateD['vehicleId']);   
			$vehicleCost = round($dmcRateD['vehicleCost']);
		}
		if($transferType!=4){
			$repCost = round($dmcRateD['repCost']);
		}
		$supplierId = $dmcRateD['supplierId'];
	
		$markupType=addslashes($dmcRateD['markupType']);
		$markupCost=addslashes($dmcRateD['markupCost']);

	}else{
		// complete package costing
		$checkPackageRateQuery="";
		$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
		if(mysqli_num_rows($checkPackageRateQuery) > 0){
 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

		    $currencyId = $getPackageRateData['currencyId'];
		    // $currencyValue = getCurrencyVal($currencyId);
		    $currencyValue = $getPackageRateData['currencyValue'];
		    $supplierId = $getPackageRateData['supplierId'];
		}

		$dmcId  = 0;
		$price  = 0;
		$paxRange  = 0;
	}
	
	$namevalue ='fromDate="'.$srdate.'",toDate="'.$srdate.'",slabId="'.$slabId.'",transferType="'.$transferType.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",vehicleId="'.$vehicleId.'",vehicleCost="'.$vehicleCost.'",repCost="'.$repCost.'",ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",ticketinfantCost="'.$ticketinfantCost.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",gstTax="'.$gstTax.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",otherActivityName="'.$serviceId.'",otherActivityCity="'.$destinationId.'",dateotherActivity="'.$srdate.'",supplierId="'.$supplierId.'",tariffId="'.$dmcId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",dayId="'.$dayId.'",remark="'.$remarks.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",noOfVehicles="'.$noOfVehicles.'"';
	$lastid = addlistinggetlastid(_QUOTATION_OTHER_ACTIVITY_MASTER_,$namevalue); 

	$namevalue1 ='serviceId="'.$lastid.'",serviceType="activity",dayId="'.$dayId.'",startDate="'.$srdate.'",endDate="'.$srdate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
	?> 
	<script type="text/javascript"> 
	// closeinbound();
	selectthisE(<?php echo $dmcId; ?>,<?php echo $tableN; ?>)
	loadquotationmainfile(); 
	</script>
	
<?php 
} 
?>