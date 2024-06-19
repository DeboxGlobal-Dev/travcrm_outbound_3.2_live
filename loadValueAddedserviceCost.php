<?php 
include 'inc.php';

if($_REQUEST['action']=="saveVisaCosttoQuotation" && $_REQUEST['visaNameId']!='' && $_REQUEST['quotationId']!=''){

    $rateId = $_REQUEST['visaRateId'];
    $quotationId = $_REQUEST['quotationId'];
    $visaNameId = $_REQUEST['visaNameId'];
    $rs = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
    $quotationData = mysqli_fetch_assoc($rs);
    $queryId = $quotationData['queryId'];

    $rs1 = GetPageRecord('*','visaCostMaster','id="'.$visaNameId.'"');
    $visanameData = mysqli_fetch_assoc($rs1);

    $rs1 = GetPageRecord('*','visaRateMaster','id="'.$rateId.'"');
    $visaRateData = mysqli_fetch_assoc($rs1);

    $visaType = $_REQUEST['visaType'];
    $adultCost = $_REQUEST['adultCost'];
    $childCost = $_REQUEST['childCost'];
    $infantCost = $_REQUEST['infantCost'];
    $adultPax = $_REQUEST['adultPax'];
    $childPax = $_REQUEST['childPax'];
    $infantPax = $_REQUEST['infantPax'];
    $currencyId = $_REQUEST['currencyId'];
    $ProcessingFeeType = $_REQUEST['markupType'];
    $processingFee = $_REQUEST['markupCost'];
    $gstTax = $_REQUEST['gstTax'];
    $embassyFee = $_REQUEST['embassyFeev'];
    $vfsCharges = $_REQUEST['vfsChargesv'];
    $entryType = $_REQUEST['entryType'];
    $visaValidity = $_REQUEST['visaValidity'];
    $visaDate = date('Y-m-d',strtotime($_REQUEST['visaDate']));
    $visaCountryId = $_REQUEST['visaCountryId'];
    $taxApplicable = $_REQUEST['taxApplicable'];
    $supplierId = $_REQUEST['supplierId'];
    
    $currencyValue = $_REQUEST['currencyValue'];
    if($currencyId>0){
        
        $currencyId = $_REQUEST['currencyId'];
    }else{
        $currencyId = $visaRateData['currencyId'];
    }

    if($currencyValue>0){
          $currencyValue = $_REQUEST['currencyValue'];
      }else{
          $currencyValue = getCurrencyVal($currencyId);
      }

    $currentDate = date('Y-m-d');

     $nameValue = 'name="'.$visanameData['name'].'",rateId="'.$rateId.'",quotationId="'.$quotationId.'",serviceid="'.$visaNameId.'",supplierId="'.$supplierId.'",visaTypeId="'.$visaType.'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",startDate="'.$currentDate.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",gstTax="'.$gstTax.'",markupType="'.$ProcessingFeeType.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",processingFee="'.$processingFee.'",vfsCharges="'.$vfsCharges.'",embassyFee="'.$embassyFee.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",status="1",deletestatus=0,rateAdded="1",queryId="'.$queryId.'",visaCountryId="'.$visaCountryId.'",visaDate="'.$visaDate.'",visaValidity="'.$visaValidity.'",entryType="'.$entryType.'",taxApplicable="'.$taxApplicable.'"';

    if($_REQUEST['editId']==''){
     $lastid = addlistinggetlastid('quotationVisaRateMaster',$nameValue);

    $namevalue1 ='serviceId="'.$lastid.'",serviceType="visa", dayId="'.$dayId.'",startDate="'.$quotationData['fromDate'].'",endDate="'.$quotationData['toDate'].'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 

    }else{
        $where = 'id="'.$_REQUEST['editId'].'" and quotationId="'.$quotationId.'"';
        updatelisting('quotationVisaRateMaster',$nameValue,$where);
        ?>
        <script>
            alert('Visa Rate Updated');
            parent.closeinbound();
        </script>
        <?php
    }
    ?>
    <script>
        needValueAddedServices('visaRequirementAct');
    </script>
    <?php

}

if($_REQUEST['action']=="saveFlightCosttoQuotation" && $_REQUEST['flightNameId']!='' && $_REQUEST['quotationId']!=''){

    $quotationId = $_REQUEST['quotationId'];
    $rs = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
    $quotationData = mysqli_fetch_assoc($rs);
    $queryId = $quotationData['queryId'];
    $fromDate = $quotationData['fromDate'];
    $toDate = $quotationData['toDate'];
    $adultPax = $_REQUEST['adult'];
    $childPax = $_REQUEST['child'];
    $infantPax = $_REQUEST['infant'];
    
    $ProcessingFeeType = $_REQUEST['ProcessingFeeType'];
    $processingFee = $_REQUEST['processingFee'];
    $flightNumber = $_REQUEST['flightNumber'];
    $flightClass = $_REQUEST['flightClass'];
    $quotationId = $_REQUEST['quotationId'];
    $flightNameId = $_REQUEST['flightNameId'];

    $adultCost = $_REQUEST['adultCost'];
    $childCost = $_REQUEST['childCost'];
    $infantCost = $_REQUEST['infantCost'];

    $airlineTaxA = $_REQUEST['airlineTaxA'];
    $totalCostA = $_REQUEST['totalCostA'];

    $airlineTaxC = $_REQUEST['airlineTaxC'];
    $totalCostC = $_REQUEST['totalCostC'];

    $airlineTaxE = $_REQUEST['airlineTaxE'];
    $totalCostE = $_REQUEST['totalCostE'];

    $currencyId = $_REQUEST['currencyId'];
    $GstTaxId = $_REQUEST['visaGstTaxId'];
    $flightSupplier = $_REQUEST['flightSupplier'];
    $flightFromDestionation = $_REQUEST['flightFromDestionation'];
    $flightToDestionation = $_REQUEST['flightToDestionation'];
    $flightDate = date('Y-m-d',strtotime($_REQUEST['flightDate']));
    
    if($_REQUEST['currencyValue']>0){
        $currencyValue = $_REQUEST['currencyValue'];
    }else{
        $currencyValue = getCurrencyVal($currencyId);
    }

    $currentDate = date('Y-m-d');

    $nameValue = 'flightNumber="'.$flightNumber.'",flightClass="'.$flightClass.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",departureFrom="'.$flightFromDestionation.'",arrivalTo="'.$flightToDestionation.'",flightId="'.$flightNameId.'",quotationId="'.$quotationId.'",isGuestType="1",departureDate="'.$flightDate.'",queryId="'.$queryId.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",markupCost="'.$processingFee.'",markupType="'.$ProcessingFeeType.'",totalAdultCost="'.$totalCostA.'",adultTax="'.$airlineTaxA.'",totalChildCost="'.$totalCostC.'",childTax="'.$airlineTaxC.'",totalInfantCost="'.$totalCostE.'",infantTax="'.$airlineTaxE.'",supplierId="'.$flightSupplier.'",gstTax="'.$GstTaxId.'",isFlightTaken="yes"';

    if($_REQUEST['editId']==''){
    $lastid = addlistinggetlastid('quotationFlightMaster',$nameValue);
    
    $namevalue1 ='serviceId="'.$lastid.'",serviceType="flight", dayId="'.$dayId.'",startDate="'.$quotationData['fromDate'].'",endDate="'.$quotationData['toDate'].'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
    ?>
    <script>
        warningalert('Flight Rate Added');
        // parent.closeinbound();
        needValueAddedServices('flightRequirementAct');
    </script>
    <?php
    }else{
         $where = 'id="'.$_REQUEST['editId'].'"';
        updatelisting('quotationFlightMaster',$nameValue,$where);
        ?>
        <script>
            warningalert('Flight Rate Updated');
            parent.closeinbound();
            needValueAddedServices('flightRequirementAct');
        </script>
        <?php
    }
   
}

if($_REQUEST['action']=="saveTrainCosttoQuotation" && $_REQUEST['trainNameId']!='' && $_REQUEST['quotationId']!=''){

    $quotationId = $_REQUEST['quotationId'];
    $rs = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
    $quotationData = mysqli_fetch_assoc($rs);
    $queryId = $quotationData['queryId'];

    $trainNumber = $_REQUEST['ftrainNumber'];
    $trainClass = $_REQUEST['ftrainClass'];
    $quotationId = $_REQUEST['quotationId'];
    $trainNameId = $_REQUEST['trainNameId'];

    $adultCost = $_REQUEST['adultCost'];
    $childCost = $_REQUEST['childCost'];
    $infantCost = $_REQUEST['infantCost'];
    $adultPax = $_REQUEST['adultPax'];
    $childPax = $_REQUEST['childPax'];
    $infantPax = $_REQUEST['infantPax'];
    $currencyId = $_REQUEST['currencyId'];

    $markupType = $_REQUEST['markupType'];
    $markupCost = $_REQUEST['markupCost'];

    $trainFromDestionation = $_REQUEST['trainFromDestionation'];
    $trainToDestionation = $_REQUEST['trainToDestionation'];
    $trainDate = date('Y-m-d',strtotime($_REQUEST['trainDate']));
    

    if($_REQUEST['currencyValue']>0){
        $currencyValue = $_REQUEST['currencyValue'];
    }else{
        $currencyValue = getCurrencyVal($currencyId);
    }

    $currentDate = date('Y-m-d');

    $nameValue = 'trainNumber="'.$trainNumber.'",trainClass="'.$trainClass.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",adult="'.$adultPax.'",child="'.$childPax.'",departureFrom="'.$trainFromDestionation.'",arrivalTo="'.$trainToDestionation.'",trainId="'.$trainNameId.'",quotationId="'.$quotationId.'",isGuestType="1",departureDate="'.$trainDate.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'"';

    
    if($_REQUEST['editId']==''){
    $lastid = addlistinggetlastid('quotationTrainsMaster',$nameValue);
    
    $namevalue1 ='serviceId="'.$lastid.'",serviceType="train", dayId="'.$dayId.'",startDate="'.$quotationData['fromDate'].'",endDate="'.$quotationData['toDate'].'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
    ?>
    <script>
        warningalert('Train Rate Added');
        // parent.closeinbound();
        needValueAddedServices('trainRequirementAct');
    </script>
    <?php
    }else{

        $where = 'id="'.$_REQUEST['editId'].'"';
        updatelisting('quotationTrainsMaster',$nameValue, $where);
        ?>
        <script>
            warningalert('Train Rate Updated');
            parent.closeinbound();
            needValueAddedServices('trainRequirementAct');
        </script>
        <?php
    }
  
}

// Transfer cost
if($_REQUEST['action']=="saveTransferCosttoQuotation" && $_REQUEST['transferNameId']!='' && $_REQUEST['quotationId']!=''){

    $quotationId = $_REQUEST['quotationId'];
    $rs = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
    $quotationData = mysqli_fetch_assoc($rs);
    $queryId = $quotationData['queryId'];

    $transferType = $_REQUEST['transferType'];
    $sicpvtType = $_REQUEST['sicpvtType'];
    $quotationId = $_REQUEST['quotationId'];
    $transferNameId = $_REQUEST['transferNameId'];
    $vehicleTypeId = $_REQUEST['vehicleTypeId'];
    $repCost = $_REQUEST['repCost'];
    $vehicleCost = $_REQUEST['vehicleCost'];
    $parkingFee = $_REQUEST['parkingFee'];
    $AssistanceFee = $_REQUEST['AssistanceFee'];
    $additionalAllowance = $_REQUEST['additionalAllowance'];
    $interState = $_REQUEST['interState'];
    $misslaneousCost = $_REQUEST['misslaneousCost'];

    $adultCost = $_REQUEST['adultCost'];
    $childCost = $_REQUEST['childCost'];
    $infantCost = $_REQUEST['infantCost'];
    $adultPax = $_REQUEST['adultPax'];
    $childPax = $_REQUEST['childPax'];
    $infantPax = $_REQUEST['infantPax'];
    $currencyId = $_REQUEST['currencyId'];
    $destinationId = $_REQUEST['destinationId'];
    $transferDate = date('Y-m-d',strtotime($_REQUEST['ttransferDate']));
    
    $markupType = $_REQUEST['markupType'];
    $markupCost = $_REQUEST['markupCost'];

    if($_REQUEST['currencyValue']>0){
        $currencyValue = $_REQUEST['currencyValue'];
    }else{
        $currencyValue = getCurrencyVal($currencyId);
    }

    $currentDate = date('Y-m-d');

    $nameValue = 'transferType="'.$sicpvtType.'",transferQuotatoinType="'.$transferType.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",vehicleType="'.$vehicleTypeId.'",fromDate="'.$transferDate.'",vehicleCost="'.$vehicleCost.'",representativeEntryFee="'.$repCost.'",parkingFee="'.$parkingFee.'",assistance="'.$AssistanceFee.'",guideAllowance="'.$additionalAllowance.'",interStateAndToll="'.$interState.'",miscellaneous="'.$misslaneousCost.'",destinationId="'.$destinationId.'",transferNameId="'.$transferNameId.'",quotationId="'.$quotationId.'",serviceType="transfer",isGuestType="1",markupCost="'.$markupCost.'",markupType="'.$markupType.'",isTransferTaken="yes"';

  
    if($_REQUEST['editId']==''){
    $lastid = addlistinggetlastid('quotationTransferMaster',$nameValue); 
    
    $namevalue1 ='serviceId="'.$lastid.'",serviceType="transfer", dayId="'.$dayId.'",startDate="'.$quotationData['fromDate'].'",endDate="'.$quotationData['toDate'].'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 
    ?>
    <script>
        warningalert('Transfer Rate Added');
        // parent.closeinbound();
        needValueAddedServices('transferRequirementAct');
    </script>
    <?php
    }else{
        $where = 'id="'.$_REQUEST['editId'].'"';
        updatelisting('quotationTransferMaster',$nameValue,$where);
        ?>
        <script>
            warningalert('Transfer Rate Updated');
            parent.closeinbound();
            needValueAddedServices('transferRequirementAct');
        </script>
        <?php
    }
  
}

// Passport Rate save code
if($_REQUEST['action']=="savePassportCosttoQuotation" && $_REQUEST['passportNameId']!='' && $_REQUEST['quotationId']!=''){

    $passRateId = $_REQUEST['passRateId'];
    $quotationId = $_REQUEST['quotationId'];
    $passportNameId = $_REQUEST['passportNameId'];
    $rs = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
    $quotationData = mysqli_fetch_assoc($rs);
    $queryId = $quotationData['queryId'];
    $inrs1 = GetPageRecord('*','passportCostMaster','id="'.$passportNameId.'"');
    $passnameData = mysqli_fetch_assoc($inrs1);

    $rs1 = GetPageRecord('*','passportRateMaster','id="'.$passRateId.'"');
    $passRateData = mysqli_fetch_assoc($rs1);

    
    $passportType = $_REQUEST['passportType'];
    $adultCost = $_REQUEST['adultCost'];
    $childCost = $_REQUEST['childCost'];
    $infantCost = $_REQUEST['infantCost'];
    $adultPax = $_REQUEST['adultPax'];
    $childPax = $_REQUEST['childPax'];
    $infantPax = $_REQUEST['infantPax'];
    $currencyValue = $_REQUEST['currencyValue'];
    $currencyId = $_REQUEST['currencyId'];
    if($currencyId>0){
        $currencyId = $_REQUEST['currencyId'];
    }else{
        $currencyId = $passRateData['currencyId'];
    }
    if($currencyValue>0){
        $currencyValue = $_REQUEST['currencyValue'];
    }else{
        $currencyValue = getCurrencyVal($currencyId);
    }
    
    $markupType = $_REQUEST['markupType'];
    $markupCost = $_REQUEST['markupCost'];

    $currentDate = date('Y-m-d');

    $nameValue = 'name="'.$passnameData['name'].'",rateId="'.$passRateId.'",quotationId="'.$quotationId.'",serviceid="'.$passportNameId.'",supplierId="'.$passRateData['supplierId'].'",passportTypeId="'.$passportType.'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",startDate="'.$currentDate.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",gstTax="'.$passRateData['gstTax'].'",markupType="'.$passRateData['markupType'].'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",processingFee="'.$passRateData['processingFee'].'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'.$infantPax.'",status="1",deletestatus=0,queryId="'.$queryId.'",markupCost="'.$markupCost.'",markupType="'.$markupType.'"';

    if($_REQUEST['editId']==''){
    $lastid = addlistinggetlastid('quotationPassportRateMaster',$nameValue);

    $namevalue1 ='serviceId="'.$lastid.'",serviceType="passport", dayId="'.$dayId.'",startDate="'.$quotationData['fromDate'].'",endDate="'.$quotationData['toDate'].'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 

    }else{
        $where = 'id="'.$_REQUEST['editId'].'" and quotationId="'.$quotationId.'"';
        updatelisting('quotationPassportRateMaster',$nameValue,$where);
        ?>
        <script>
            alert('Passport Rate Updated');
            parent.closeinbound();
        </script>
        <?php
    }
    ?>
    <script>
        needValueAddedServices('passportRequirementAct');
    </script>
    <?php

}
// Insurance code end
if($_REQUEST['action']=="saveInsuranceCosttoQuotation" && $_REQUEST['insuranceNameId']!='' && $_REQUEST['quotationId']!=''){

    $insuranceRateId = $_REQUEST['insuranceRateId'];
    $quotationId = $_REQUEST['quotationId'];
    $insuranceNameId = $_REQUEST['insuranceNameId'];
    $rs = GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
    $quotationData = mysqli_fetch_assoc($rs);
    $queryId = $quotationData['queryId'];
    $inrs1 = GetPageRecord('*','insuranceCostMaster','id="'.$insuranceNameId.'"');
    $insurancenameData = mysqli_fetch_assoc($inrs1);

    $rs1 = GetPageRecord('*','insuranceRateMaster','id="'.$insuranceRateId.'"');
    $insuranceRateData = mysqli_fetch_assoc($rs1);

    $ProcessingFeeType = $_REQUEST['ProcessingFeeType'];
    $processingFee = $_REQUEST['processingFee'];
    $insGstTax = $_REQUEST['insGstTax'];
    $supplierId = $_REQUEST['insuranceSupplier'];
    
    $insuranceType = $_REQUEST['insuranceType'];
    $adultCost = $_REQUEST['adultCost'];
    $childCost = $_REQUEST['childCost'];
    $infantCost = $_REQUEST['infantCost'];
    $adultPax = $_REQUEST['adultPax'];
    $childPax = $_REQUEST['childPax'];
    $infantPax = $_REQUEST['infantPax'];
    $currencyId = $_REQUEST['currencyId'];
    $currencyValue = $_REQUEST['currencyValue'];
    $countryId = $_REQUEST['travellingcountryId'];
    $insuranceFromDate = date('Y-m-d',strtotime($_REQUEST['insuranceFromDate']));
    $insuranceToDate = date('Y-m-d',strtotime($_REQUEST['insuranceToDate']));
    if($currencyId>0){
        
        $currencyId = $_REQUEST['currencyId'];
    }else{
        $currencyId = $insuranceRateData['currencyId'];
    }


    if($currencyValue>0){
        $currencyValue = $_REQUEST['currencyValue'];
    }else{
        $currencyValue = getCurrencyVal($currencyId);
    }
   

    $currentDate = date('Y-m-d');

    $nameValue = 'name="'.$insurancenameData['name'].'",rateId="'.$insuranceRateId.'",quotationId="'.$quotationId.'",serviceid="'.$insuranceNameId.'",insuranceTypeId="'.$insuranceType.'",fromDate="'.$quotationData['fromDate'].'",toDate="'.$quotationData['toDate'].'",startDate="'.$currentDate.'",currencyId="'.$currencyId.'",currencyValue="'.$currencyValue.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",adultPax="'.$adultPax.'",childPax="'.$childPax.'",infantPax="'. $infantPax.'",status="1",deletestatus=0,rateAdded="1",queryId="'.$queryId.'",countryId="'.$countryId.'",insuranceStartDate="'.$insuranceFromDate.'",insuranceEndDate="'.$insuranceToDate.'",processingFee="'.$processingFee.'",markupType="'.$ProcessingFeeType.'",gstTax="'.$insGstTax.'",supplierId="'.$supplierId.'"';

    if($_REQUEST['editId']==''){

    $lastid = addlistinggetlastid('quotationInsuranceRateMaster',$nameValue);

    $namevalue1 ='serviceId="'.$lastid.'",serviceType="insurance", dayId="'.$dayId.'",startDate="'.$quotationData['fromDate'].'",endDate="'.$quotationData['toDate'].'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",startTime="'.date('Y-m-d H:i:s').'",endTime="'.date('Y-m-d H:i:s').'",srn="'.$dayId.'"'; 
	addlisting('quotationItinerary',$namevalue1); 

    }else{
        $where = 'id="'.$_REQUEST['editId'].'" and quotationId="'.$quotationId.'"';
        updatelisting('quotationInsuranceRateMaster',$nameValue,$where);
        ?>
        <script>
            alert('Insurance Rate Updated');
            parent.closeinbound();
        </script>
        <?php
    }
    ?>
    <script>
        needValueAddedServices('insuranceRequirementAct');
    </script>
    <?php

}

?>