<?php
include "inc.php";    
 
if($_REQUEST['add']=='yes'){
       
		$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
		$newQuotationData=mysqli_fetch_array($dayQuery); 

		$rateId = clean($_REQUEST['rateId']);  
		$ferryTimeId = clean($_REQUEST['ferryTimeId']);  
		$ferryServiceId = clean($_REQUEST['ferryServiceId']);
		$todestination = clean($_REQUEST['todestination']);
		$fromDestination = clean($_REQUEST['cityId']);
	
	// die('fff');
	

		$getres = GetPageRecord('*','ferryServiceTiming','id="'.$ferryTimeId.'"');
		$timeres = mysqli_fetch_assoc($getres);
		$pickUpTime = $timeres['pickupTime'];
		$dropTime = $timeres['dropTime'];
		
		$quotationId = $newQuotationData['quotationId'];  
		$queryId = $newQuotationData['queryId']; 

		$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
		$quotationData = mysqli_fetch_array($rs1); 
			
		$escortQuery='';
		$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$quotationId.'" and status=1');
		$escortData=mysqli_fetch_array($escortQuery);
		
		$dayId = $_REQUEST['dayId'];
		$fromDate=date("Y-m-d", strtotime($newQuotationData['srdate'])); 
		$toDate=date("Y-m-d", strtotime($newQuotationData['srdate']));
		$cityId = $newQuotationData['cityId']; 
		
		$rsa2s="";
		$rsa2s=GetPageRecord('*',_QUOTATION_FERRY_RATE_MASTER_,'id="'.$rateId.'"');  
	if(mysqli_num_rows($rsa2s)>0 && $_REQUEST['tableN'] == 2){  
		$dmcroommastermain=mysqli_fetch_array($rsa2s);

		$adultPax = $dmcroommastermain['adultPax'];
		$childPax = $dmcroommastermain['childPax'];
		$infantPax = $dmcroommastermain['infantPax'];
	}else{
		$rs1=GetPageRecord('*',_DMC_FERRY_RATE_MASTER_,'id="'.$rateId.'"'); 
		$dmcroommastermain=mysqli_fetch_array($rs1);

		$adultPax=addslashes($quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']); 
		$childPax=addslashes($quotationData['child']);
		$infantdPax=addslashes($quotationData['infant']);
	}
		$currencyId=strip($dmcroommastermain['currencyId']); 
		$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);

		$supplierId=clean($dmcroommastermain['supplierId']);   
		$remark=clean($dmcroommastermain['remark']);     
		
		$gstTax = strip($dmcroommastermain['gstTax']); 
		
		// $processingfee = strip($dmcroommastermain['processingfee']); 
		$miscCost = strip($dmcroommastermain['miscCost']); 
		$adultCost = strip($dmcroommastermain['adultCost']); 
		$childCost = strip($dmcroommastermain['childCost']); 
		$infantCost = strip($dmcroommastermain['infantCost']); 
		$markupCost = strip($dmcroommastermain['markupCost']); 
		$markupType = strip($dmcroommastermain['markupType']); 
		
		$ferryCost = round($adultCost+$processingfee+$miscCost);

	/////////////////////////////////////////////////////////////
	$namevalue = 'fromDate="'.$fromDate.'",timeId="'.$ferryTimeId.'",pickupTime="'.$pickUpTime.'",dropTime="'.$dropTime.'",toDate="'.$toDate.'",destinationId="'.$fromDestination.'",todestination="'.$todestination.'",serviceid="'.$ferryServiceId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",ferryCost="'.$ferryCost.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",remark="'.$remark.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",supplierId="'.$supplierId.'",rateId="'.$dmcroommastermain['id'].'",ferryClass="'.$dmcroommastermain['ferryClass'].'",ferryNameId="'.$dmcroommastermain['ferryNameId'].'",processingfee="'.$processingfee.'",miscCost="'.$miscCost.'",gstTax="'.$gstTax.'",dayId="'.$dayId.'"';

	$lastid = addlistinggetlastid(_QUOTATION_FERRY_MASTER_,$namevalue);
 
	$namevalue1 ='serviceId="'.$lastid.'",serviceType="ferry", dayId="'.$dayId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1);   
	?>
	<script> 
	//closeinbound();
	loadquotationmainfile(); 
	</script>
<?php
}
?>
	
	 