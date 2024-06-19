<?php
include "inc.php";    

if($_REQUEST['add']=='yes'){
       
	$dayQuery=GetPageRecord('*','newQuotationDays','id ="'.$_REQUEST['dayId'].'"'); 
	$newQuotationData=mysqli_fetch_array($dayQuery); 

	$quotationId= $newQuotationData['quotationId'];   

	$rs1=GetPageRecord(' * ',_QUOTATION_MASTER_,'id="'.$quotationId.'"'); 
	$quotationData = mysqli_fetch_array($rs1); 
	$queryId = $quotationData['queryId']; 

	$rateId = clean($_REQUEST['rateId']);  

	$escortQuery='';
	$escortQuery=GetPageRecord('*','totalPaxSlab','quotationId ="'.$quotationId.'" and status=1');
	$escortData=mysqli_fetch_array($escortQuery);

	$adult=addslashes($quotationData['adult']+$escortData['localEscort']+$escortData['foreignEscort']); 
	$child=addslashes($quotationData['child']);
	$infant=addslashes($quotationData['infant']);
	
	
	$cruiseServiceId = clean($_REQUEST['cruiseServiceId']); 
	if($_REQUEST['departureDate']!='' && $_REQUEST['departureDate']!='1970-01-01' && $_REQUEST['departureDate']!='0000-00-00'){
		$departureDate = date('Y-m-d',strtotime($_REQUEST['departureDate'])); 
	}else{
		$departureDate = date('Y-m-d',strtotime($quotationData['fromDate'])); 
	}
	 
	$cruiseduration = clean($_REQUEST['cruiseduration']);  

	// $getres = GetPageRecord('*','ferryServiceTiming','id="'.$ferryTimeId.'"');
	// $timeres = mysqli_fetch_assoc($getres);
	// $pickUpTime = $timeres['pickupTime'];
	// $dropTime = $timeres['dropTime'];
	
	$dayId = $_REQUEST['dayId'];
	$fromDate=date("Y-m-d", strtotime($newQuotationData['srdate'])); 
    $toDate=date("Y-m-d", strtotime($newQuotationData['srdate']));
    $cityId = $newQuotationData['cityId']; 
	
	$rsa2s="";
	$rsa2s=GetPageRecord('*',_QUOTATION_CRUISE_RATE_MASTER_,'id="'.$rateId.'" and quotationId="'.$quotationId.'"');  
	if(mysqli_num_rows($rsa2s)>0 && $_REQUEST['tableN'] == 2){  
		$dmcroommastermain=mysqli_fetch_array($rsa2s);


		$adultPax = $dmcroommastermain['adultPax'];
		$childPax = $dmcroommastermain['childPax'];
		$infantPax = $dmcroommastermain['infantPax'];
	}else{
		$rs1=GetPageRecord('*',_DMC_CRUISE_RATE_MASTER_,'id="'.$rateId.'"'); 
		$dmcroommastermain=mysqli_fetch_array($rs1);


		$adultPax = $adult;
		$childPax = $child;
		$infantPax = $infant;

	}

	$currencyId=strip($dmcroommastermain['currencyId']); 
	$currencyValue = ($dmcroommastermain['currencyValue']>0)?$dmcroommastermain['currencyValue']:getCurrencyVal($currencyId);
	// $currencyValue = getCurrencyVal($currencyId);

	$supplierId=clean($dmcroommastermain['supplierId']);   
	$gstTax=clean($dmcroommastermain['gstTax']);   
	$remark=clean($dmcroommastermain['remark']);     
	
	$adultCost = strip($dmcroommastermain['adultCost']); 
	$childCost = strip($dmcroommastermain['childCost']); 
	$infantCost = strip($dmcroommastermain['infantCost']); 
    $markupCost = $dmcroommastermain['markupCost'];
    $markupType = $dmcroommastermain['markupType'];

    // $adultCost = getMarkupCost($adultCost,$markupCost,$markupType)+$adultCost;
    // $childCost = getMarkupCost($childCost,$markupCost,$markupType)+$childCost;

	// $gstValueFerry=getGstValueById($dmcroommastermain['gstTax']); 
	// $adultCost= round(($adultCost*$gstValueFerry/100)+$adultCost); 
	// $childCost= round(($childCost*$gstValueFerry/100)+$childCost);
	// $infantCost= round(($infantCost*$gstValueFerry/100)+$infantCost);
 	
	// $ferryCost = round($adultCost+$processingfee+$miscCost);

	/////////////////////////////////////////////////////////////
	$namevalue = 'fromDate="'.$fromDate.'",serviceId="'.$cruiseServiceId.'",toDate="'.$toDate.'",destinationId="'.$cityId.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",remark="'.$remark.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",supplierId="'.$supplierId.'",rateId="'.$dmcroommastermain['id'].'",cabinTypeId="'.$dmcroommastermain['cabinTypeId'].'",cruiseNameId="'.$dmcroommastermain['cruiseNameId'].'",tariffTypeId="'.$dmcroommastermain['tariffTypeId'].'",gstTax="'.$gstTax.'",dayId="'.$dayId.'",duration="'.$cruiseduration.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'",departureDate="'.$departureDate.'",startDayDate="'.$fromDate.'",endDayDate="'.$toDate.'",isGuestType=1,status=1,deletestatus=0,addedBy="'.$_SESSION['userid'].'",dateAdded="'.date('Y-m-d').'"';
	$lastid = addlistinggetlastid(_QUOTATION_CRUISE_MASTER_,$namevalue);
 
	$namevalue1 ='serviceId="'.$lastid.'",serviceType="cruise", dayId="'.$dayId.'",startDate="'.$fromDate.'",endDate="'.$toDate.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1);   
	?>
	<script>
	//closeinbound();
	loadquotationmainfile(); 
	</script>
<?php
}
?>
	
	 