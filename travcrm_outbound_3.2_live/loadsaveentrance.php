<?php
include "inc.php"; 
 
if($_REQUEST['add']=='yes' && $_REQUEST['action'] == 'addedit_QuotationEntrance'){ 

	$startDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['startDayId'].'" ');  
	$startDayData=mysqli_fetch_array($startDayQuery);
	
	$endDayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['endDayId'].'" ');  
	$endDayData=mysqli_fetch_array($endDayQuery);

	$startDayDate = $startDayData['srdate'];
    $endDayDate = $endDayData['srdate'];
    $noOfVehicle = $_REQUEST['noOfVehicle'];
 	
	$dayQuery="";
	$dayQuery=GetPageRecord('*','newQuotationDays','quotationId="'.$startDayData['quotationId'].'" and srdate >= "'.$startDayDate.'" and  srdate <= "'.$endDayDate.'" order by srdate asc'); 
	while($dayData=mysqli_fetch_array($dayQuery)){
		
		  
		$quotationId= $dayData['quotationId'];   
		$queryId = $dayData['queryId'];

		$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
		$quotationData = mysqli_fetch_array($rs1); 

		$escortQuery='';
		$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$quotationId.'" and status=1');
		$escortData=mysqli_fetch_array($escortQuery);
		
		$dayId= $dayData['id']; 
		$startDate=date('Y-m-d',strtotime($dayData['srdate'])); 
		$destinationId = $_REQUEST['cityId'];

		$dmcId = $_REQUEST['dmcId']; 
		$tableN = $_REQUEST['tableN']; 
		$calculationType = $_REQUEST['calculationType']; 
		$entranceNameId = trim($_REQUEST['entranceId']); 
		
		if($calculationType!=3){

			if($dmcId>0 && $tableN==2){
				$select1 = '*';  
				$where1= 'id="'.$dmcId.'"'; 
				$rs1 = GetPageRecord($select1,'quotationEntranceRateMaster',$where1); 
				$dmcRateD = mysqli_fetch_array($rs1); 

				$adultPax = $dmcRateD['adultPax'];
				$childPax = $dmcRateD['childPax'];
				$infantPax = $dmcRateD['infantPax'];
				
				$entranceNameId=addslashes($dmcRateD['serviceId']);   
			}else{
				$select1 = '*';  
				$where1= 'id="'.$dmcId.'"'; 
				$rs1 = GetPageRecord($select1,_DMC_ENTRANCE_RATE_MASTER_,$where1); 
				$dmcRateD = mysqli_fetch_array($rs1); 


				$adultPax=addslashes($quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']); 
				$childPax=addslashes($quotationData['child']);
				$infantPax=addslashes($quotationData['infant']);

				$entranceNameId=addslashes($dmcRateD['entranceNameId']);   
			}

			$supplierId = $dmcRateD['supplierId']; 
			$entranceType=addslashes($dmcRateD['entranceType']);
			$transferType=addslashes($dmcRateD['transferType']);

			$gstTax=addslashes($dmcRateD['gstTax']);
			$markupType=addslashes($dmcRateD['markupType']);
			$markupCost=addslashes($dmcRateD['markupCost']);
			
			$ticketAdultCost = round($dmcRateD['ticketAdultCost']);
			$ticketchildCost = round($dmcRateD['ticketchildCost']);
			$ticketinfantCost = round($dmcRateD['ticketinfantCost']);
			

			$adultCost=$childCost=$infantCost=$vehicleId=$vehicleCost=0;
			if($transferType==1){
				$adultCost = round($dmcRateD['adultCost']);
				$childCost = round($dmcRateD['childCost']);
				$infantCost = round($dmcRateD['infantCost']);
			}elseif($transferType==2){
				$vehicleId=addslashes($dmcRateD['vehicleId']);   
				$vehicleCost = round($dmcRateD['vehicleCost']);
			}
			if($transferType!=3){
				$repCost = round($dmcRateD['repCost']);
			}
			$detail=addslashes($dmcRateD['remark']);   
			$currencyId=addslashes($dmcRateD['currencyId']);  
			$currencyValue = ($dmcRateD['currencyValue']>0)?$dmcRateD['currencyValue']:getCurrencyVal($currencyId);
			// $currencyValue=addslashes($dmcRateD['currencyValue']);  
		}else{
			// complete package costing
			$checkPackageRateQuery="";
			$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'"');
			if(mysqli_num_rows($checkPackageRateQuery) > 0){
	 			$getPackageRateData=mysqli_fetch_array($checkPackageRateQuery);	

			    $currencyId = $getPackageRateData['currencyId'];
			    $currencyValue = $getPackageRateData['currencyValue'];
			    $supplierId = $getPackageRateData['supplierId'];
			}

			$dmcId  = 0;
			$price  = 0;
			$paxRange  = 0;
			$transferType=1;
			
		}
		//$rs121=GetPageRecord('id',_QUOTATION_ENTRANCE_MASTER_,'entranceNameId="'.$entranceNameId.'" and quotationId="'.$quotationId.'"');	
		//$isAlreadyAdded=mysqli_num_rows($rs121);	 
	 
		 $namevalue ='fromDate="'.$startDate.'",toDate="'.$startDate.'",destinationId="'.$destinationId.'",entranceNameId="'.$entranceNameId.'",entranceType="'.$entranceType.'",transferType="'.$transferType.'",markupType="'.$markupType.'",markupCost="'.$markupCost.'",gstTax="'.$gstTax.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",vehicleId="'.$vehicleId.'",vehicleCost="'.$vehicleCost.'",repCost="'.$repCost.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",detail="'.$detail.'",ticketAdultCost="'.$ticketAdultCost.'",ticketchildCost="'.$ticketchildCost.'",ticketinfantCost="'.$ticketinfantCost.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",dmcId="'.$dmcId.'",dayId="'.$dayData['id'].'",startDayDate="'.$startDayDate.'",endDayDate="'.$endDayDate.'",noOfVehicles="'.$noOfVehicle.'"';
		$lastid = addlistinggetlastid(_QUOTATION_ENTRANCE_MASTER_,$namevalue); 
		// loop for hotel query inserting number of date 
	 
		$namevalue1 ='serviceId="'.$lastid.'",serviceType="entrance", dayId="'.$dayId.'",startDate="'.$startDate.'",endDate="'.$startDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
		addlisting('quotationItinerary',$namevalue1); 
	
		?> 
		<script> 
			//closeinbound();
			 loadquotationmainfile(); 
		</script>
		<?php
	} 

}
?>
<style>
	/*	 .topaboxlist {
	    border: 1px #e8e8e8 solid;
	    padding: 10px;
	    margin-bottom: 0px;
	    box-sizing: border-box;
	    background: #fbfbfb;
	}
	 
	.tooltip {
	  position: relative;
	  display: inline-block;
	  border-bottom: 1px dotted black;
	  cursor:pointer;
	}

	.tooltip .tooltiptext123 {
	  visibility: hidden;
	    width: fit-content;
	    background-color: black;
	    color: #fff;
	    text-align: center;
	    border-radius: 6px;
	    padding: 10px;
	    position: absolute;
	    z-index: 1;
	    bottom: 20px;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	}

	.tooltip:hover .tooltiptext123 {
	  visibility: visible;
	}*/
</style>