<?php
// FOR USE SAME FILE IN PROPOSALS and FIT 
if(isset($_REQUEST['quotationId'])){
    include "inc.php";
    $quotationId = $_REQUEST['quotationId'];
    
    $rsp = "";
    $rsp = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.$quotationId.'"');
    $resultpageQuotation = mysqli_fetch_array($rsp);

    $rs = '';
    $rs = GetPageRecord('*', _QUERY_MASTER_, 'id="'.($resultpageQuotation['queryId']).'"');
    $resultpage = mysqli_fetch_array($rs);
}

$paxAdult = ($resultpageQuotation['adult']);
$paxChild = ($resultpageQuotation['child']);
$paxInfant = ($resultpageQuotation['infant']);
$travelType = ($resultpageQuotation['travelType']);

$totalPax = ($paxAdult + $paxChild + $paxInfant);
if($totalPax == 0){
    $totalPax =  2;
}

// No CATEGORY IN SINGLE HHOTEL CATEGORY QUOTATION AND FIT QUOTATION
$multihotelQuery = $MultiQuotPreview = $val = "";
$gstType = 1;
$travelType = 2; 

$quotationId = $resultpageQuotation['id'];
$queryId = $resultpage['id'];

if($resultpage['displayId']==0){
    $quotPreviewId = makePackageId($resultpage['packageId']);
}else{
    $quotPreviewId = makeQuotationId($quotationId).$MultiQuotPreview;
}


// FOR USE SAME FILE TO EXPORTS
if($_REQUEST['export']=='yes'){
    //export code 
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=".$quotPreviewId.date('d-m-Y',strtotime($resultpageQuotation['fromDate'])).".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Cache-control: private");
}

// CURRENCY DETAILS
if ($resultpageQuotation['currencyId'] == '' && $resultpageQuotation['currencyId'] == 0) {
    $newCurr = $baseCurrencyId;
    $dayroe = $baseCurrencyVal;
} else {
    $newCurr = $resultpageQuotation['currencyId'];
    $dayroe = $resultpageQuotation['dayroe'];
}
 
// GST DATA 
$currencyId = $resultpageQuotation['currencyId'];

if ($resultpageQuotation['serviceTax']>0) {
    $serviceTax = $resultpageQuotation['serviceTax'];
    $serviceTaxLable = $serviceTax.'%';
} else {
    $serviceTax = 0;
}

// GST DATA 
if ($resultpageQuotation['tcs']>0) {
    $tcsTax = $resultpageQuotation['tcs'];
    $tcsTaxTaxLable = $tcsTax.'%';
} else {
    $tcsTax = 0;
}
 
// if($isUni_Mark == 0 && $isSer_Mark==1){ 
//     // MARKUP DAta
//     $c12 = GetPageRecord('*', 'quotationServiceMarkup', ' quotationId="' . $quotationId . '"');
//     $serviceMarkuD = mysqli_fetch_array($c12);

//     $package = $serviceMarkuD['package'];
//     $packageMarkupType = $serviceMarkuD['packageMarkupType'];

//     $train = $serviceMarkuD['train'];
//     $trainMarkupType = $serviceMarkuD['trainMarkupType'];

//     $transfer = $serviceMarkuD['transfer'];
//     $transferMarkupType = $serviceMarkuD['transferMarkupType'];

//     $flight = $serviceMarkuD['flight'];
//     $flightMarkupType = $serviceMarkuD['flightMarkupType'];

//     $visa = $serviceMarkuD['visa'];
//     $visaMarkupType = $serviceMarkuD['visaMarkupType'];

//     $passport = $serviceMarkuD['passport'];
//     $passportMarkupType = $serviceMarkuD['passportMarkupType'];

//     $insurance = $serviceMarkuD['insurance'];
//     $insuranceMarkupType = $serviceMarkuD['insuranceMarkupType'];
    
//     $uniMarkup = 0;
//     $uniMarkupType = 1;


    
// }else{
//     $package = 0;
//     $packageMarkupType = 1;

//     $train = 0;
//     $trainMarkupType = 1;

//     $transfer = 0;
//     $transferMarkupType = 1;

//     $flight = 0;
//     $flightMarkupType = 1;

//     $visa = 0;
//     $visaMarkupType = 1;

//     $passport = 0;
//     $passportMarkupType = 1;

//     $insurance = 0;
//     $insuranceMarkupType = 1;

//     $uniMarkup = $resultpageQuotation['markup'];
//     $uniMarkupType = $resultpageQuotation['markupType'];

// }
  
?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px 0;border-bottom:1px solid #eee;margin-bottom:20px;">
    <tr>
    <td width="2%" >&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="88%" colspan="3">
        <h3 style="text-align:center; position:relative;">Cost&nbsp;Sheet&nbsp;|&nbsp;<?php echo $quotPreviewId; ?></h3>
    </td>
    <td width="10%">
        <?php if($_REQUEST['export']!='yes'){ ?>
        <a href="loadMultiServicesCostSheet.php?export=yes&quotationId=<?php echo $_REQUEST['quotationId']; ?>">
        <input name="Cancel" type="button" class="whitembutton"  value="Export"  style="background-color: #fff !important; padding: 4px 20px;">
        </a>            
        <?php } ?>      
    </td>
    </tr>
</table>
<br>
<!-- Value Added Services Start -->
<?php
$trainNum=0;
$transferNum=0;
$rsTrain = GetPageRecord('id','quotationTrainsMaster','quotationId="'.$resultpageQuotation['id'].'"');
$trainNum = mysqli_num_rows($rsTrain);

$rstransfer = GetPageRecord('id','quotationTransferMaster','quotationId="'.$resultpageQuotation['id'].'" and transferType=1');
$transferSIC = mysqli_num_rows($rstransfer);

$rstransfer = GetPageRecord('id','quotationTransferMaster','quotationId="'.$resultpageQuotation['id'].'" and transferType=2');
$transferPVT = mysqli_num_rows($rstransfer);

$transferRequired = $resultpageQuotation['transferRequired'];
$trainRequired = $resultpageQuotation['trainRequired'];
$visaCostType = $resultpageQuotation['visaCostType'];
$passportCostType = $resultpageQuotation['passportCostType'];
$insuranceCostType = $resultpageQuotation['insuranceCostType'];
$flightRequired = $resultpageQuotation['flightCostType'];

$visaRequired = $resultpageQuotation['visaRequired'];
$insuranceRequired = $resultpageQuotation['insuranceRequired'];
$passportRequired = $resultpageQuotation['passportRequired'];
$flightRequired = $resultpageQuotation['flightRequired'];

// cost summary calculation
$visaPurchaseCost=$visaServicePCost=$totalFeeVisa=$visaFinalCost=$visaAdultPax=$visaChildPax=$visaInfantPax=0;
    if($visaRequired==2){
    $VR=''; 
    $VR = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
    while($getVisaCost = mysqli_fetch_array($VR)){

        $visaAdultPax = $getVisaCost['adultPax'];
        $visaChildPax = $getVisaCost['childPax'];
        $visaInfantPax = $getVisaCost['infantPax'];

     $processingFee = $getVisaCost['processingFee'];
     $taxApplicable = $getVisaCost['taxApplicable'];
     $processingFeetype = $getVisaCost['markupType'];

        $purchaseVisaApp = ($getVisaCost['adultCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']);        
        $purchaseVisaCpp = ($getVisaCost['childCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']);
        $purchaseVisaEpp = ($getVisaCost['infantCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']);   

    $totalpurchaseVisaA =  $purchaseVisaApp*$visaAdultPax;
    $totalpurchaseVisaC =  $purchaseVisaCpp*$visaChildPax;
    $totalpurchaseVisaE =  $purchaseVisaEpp*$visaInfantPax;

    $visaPurchaseCost = $totalpurchaseVisaA+$totalpurchaseVisaC+$totalpurchaseVisaE;
    if($processingFeetype==2){
  
        $pFeeVisa = ($processingFee*$visaAdultPax)+($processingFee*$visaChildPax)+($processingFee*$visaInfantPax);
        $pFeeVisppA = ($processingFee*$visaAdultPax);
        $pFeeVisppC = ($processingFee*$visaChildPax);
        $pFeeVisppE = ($processingFee*$visaInfantPax);
     }else{
        $pFeeVisa = getMarkupCost($visaPurchaseCost,$processingFee,$processingFeetype);
        $pFeeVisppA = getMarkupCost($totalpurchaseVisaA,$processingFee,$processingFeetype);
        $pFeeVisppC = getMarkupCost($totalpurchaseVisaC,$processingFee,$processingFeetype);
        $pFeeVisppE = getMarkupCost($totalpurchaseVisaE,$processingFee,$processingFeetype);
     }
   

    $visaServicePCost = $visaServicePCost+$visaPurchaseCost;
    $totalFeeVisa = $totalFeeVisa+$pFeeVisa;
    // Adult child infant PP Cost
   
    if($taxApplicable==0){
        $visataxAmountApp = getMarkupCost($pFeeVisppA, $serviceTax, 1);
        $visataxAmountCpp = getMarkupCost($pFeeVisppC, $serviceTax, 1);
        $visataxAmountEpp = getMarkupCost($pFeeVisppE, $serviceTax, 1);
    }else{
        $visataxAmountApp = '';
        $visataxAmountCpp = '';
        $visataxAmountEpp = '';
    }
    
    $visatcsAmountApp = getMarkupCost($pFeeVisppA, $tcsTax, 1);
    $visatcsAmountCpp = getMarkupCost($pFeeVisppC, $tcsTax, 1);
    $visatcsAmountEpp = getMarkupCost($pFeeVisppE, $tcsTax, 1);
    $totalvsA = ($totalpurchaseVisaA+$pFeeVisppA+$visataxAmountApp+$visatcsAmountApp)/$paxAdult;
    $totalvsC = ($totalpurchaseVisaC+$pFeeVisppC+$visataxAmountCpp+$visatcsAmountCpp)/$paxChild;
    $totalvsE = ($totalpurchaseVisaE+$pFeeVisppE+$visataxAmountEpp+$visatcsAmountEpp)/$paxInfant;

    $ppCostONAdultBasis = $ppCostONAdultBasis+$totalvsA;
    $ppCostONChildBasis = $ppCostONChildBasis+$totalvsC; 
    $ppCostOnInfantBasis = $ppCostOnInfantBasis+$totalvsE;
    }
    
    $saleVisaCost = $visaServicePCost+$totalFeeVisa;
    if($taxApplicable==0){
    $visataxAmount = getMarkupCost($totalFeeVisa, $serviceTax, 1);
    }
    $visatcsAmount = getMarkupCost($totalFeeVisa, $tcsTax, 1);

    $visaFinalCost = $saleVisaCost+$visataxAmount+$visatcsAmount;
    $totalVisaServiceCost = $totalVisaServiceCost + $visaFinalCost;
    }

    $purchaseInsuranceApp = $purchaseInsuranceCpp = $purchaseInsuranceEpp=$insuranceServicePCost=$totalpFeeins=0;
    if($insuranceRequired==2){
        $VR=''; 
        $VR = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
        while($getInsuranceCost = mysqli_fetch_array($VR)){
            
            $insProcessingFee = $getInsuranceCost['processingFee'];
            $insProcessingFeetype = $getInsuranceCost['markupType'];
      
            $purchaseInsuranceApp = ($getInsuranceCost['adultCost']);        
            $purchaseInsuranceCpp = ($getInsuranceCost['childCost']);        
            $purchaseInsuranceEpp = ($getInsuranceCost['infantCost']);  

            $purchaseInsuranceA =  $purchaseInsuranceApp*$paxAdult;
            $purchaseInsuranceC =  $purchaseInsuranceCpp*$paxChild;
            $purchaseInsuranceE =  $purchaseInsuranceEpp*$paxInfant;

            $totalInsuranceCost = $purchaseInsuranceA+$purchaseInsuranceC+$purchaseInsuranceE;
            if($insProcessingFeetype==2){
              
                $pFeeInsurance = ($insProcessingFee*$paxAdult)+($insProcessingFee*$paxChild)+($insProcessingFee*$paxInfant);
             }else{
            
                 $pFeeInsurance = getMarkupCost($totalInsuranceCost,$insProcessingFee,$insProcessingFeetype); 
             }
           

            $insuranceServicePCost= $insuranceServicePCost+$totalInsuranceCost;
            $totalpFeeins= $totalpFeeins+$pFeeInsurance;

         // Adult PP Cost
        $pFeeInsuranceApp = getMarkupCost($purchaseInsuranceApp,$insProcessingFee,$insProcessingFeetype); 
        
        $instaxAmountApp = getMarkupCost($pFeeInsuranceApp, $serviceTax, 1);
        $instcsAmountApp = getMarkupCost($pFeeInsuranceApp, $tcsTax, 1);
        $ppCostONAdultBasis = $ppCostONAdultBasis+($purchaseInsuranceApp+$pFeeInsuranceApp+$instaxAmountApp+$instcsAmountApp);
        
        // Child PP Cost
        $pFeeInsuranceCpp = getMarkupCost($purchaseInsuranceCpp,$insProcessingFee,$insProcessingFeetype); 
        
        $instaxAmountCpp = getMarkupCost($pFeeInsuranceCpp, $serviceTax, 1);
        $instcsAmountCpp = getMarkupCost($pFeeInsuranceCpp, $tcsTax, 1);
        $ppCostONChildBasis = $ppCostONChildBasis+($purchaseInsuranceCpp+$pFeeInsuranceCpp+$instaxAmountCpp+$instcsAmountCpp); 

        // Infant PP Cost
        $pFeeInsuranceEpp = getMarkupCost($purchaseInsuranceEpp,$insProcessingFee,$insProcessingFeetype); 
        
        $instaxAmountEpp = getMarkupCost($pFeeInsuranceEpp, $serviceTax, 1);
        $instcsAmountEpp = getMarkupCost($pFeeInsuranceEpp, $tcsTax, 1);
        $ppCostOnInfantBasis = $ppCostOnInfantBasis+($purchaseInsuranceEpp+$pFeeInsuranceEpp+$instaxAmountEpp+$instcsAmountEpp); 
            
        }
        $saleInsuranceCost = $insuranceServicePCost+$totalpFeeins;
        $instaxAmount = getMarkupCost($totalpFeeins, $serviceTax, 1);
        $instcsAmount = getMarkupCost($totalpFeeins, $tcsTax, 1);
    
        $insuranceFinalCost = $saleInsuranceCost+$instaxAmount+$instcsAmount;
    } 

    $purchaseFlightApp = $purchaseFlightCpp = $purchaseFlightEpp=$pFeeFlight=$flatMarkupCost=0;
 
    if($flightRequired==2){
        $qflightQuery=''; 
        $qflightQuery = GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'quotationId="'.$quotationId.'" order by id asc ');
        while($getFlightCost = mysqli_fetch_array($qflightQuery)){
            
            $purchaseFlightApp = ($getFlightCost['totalAdultCost']);        
            $purchaseFlightCpp = ($getFlightCost['totalChildCost']);        
            $purchaseFlightEpp = ($getFlightCost['totalInfantCost']);  

            $purchaseFlightA =  $purchaseFlightApp*$paxAdult;
            $purchaseFlightC =  $purchaseFlightCpp*$paxChild;
            $purchaseFlightE =  $purchaseFlightEpp*$paxInfant;
            $totalFlightCost = $purchaseFlightA+$purchaseFlightC+$purchaseFlightE;

            if($getFlightCost['markupType']==2){
              
               $pFeeFlight = ($getFlightCost['markupCost']*$paxAdult)+($getFlightCost['markupCost']*$paxChild)+($getFlightCost['markupCost']*$paxInfant);
            }else{
                $pFeeFlight = getMarkupCost($totalFlightCost,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            }

            $totalFeeFlight = $totalFeeFlight+$pFeeFlight;
            $flightServicePCost= $flightServicePCost+$totalFlightCost;

              // Adult PP Cost
            $pFeeFlightApp = getMarkupCost($purchaseFlightApp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $flighttaxAmountApp = getMarkupCost($pFeeFlightApp, $serviceTax, 1);
            $flighttcsAmountApp = getMarkupCost($pFeeFlightApp, $tcsTax, 1);
            $ppCostONAdultBasis = $ppCostONAdultBasis+($purchaseFlightApp+$pFeeFlightApp+$flighttaxAmountApp+$flighttcsAmountApp);
            
            // Child PP Cost
            $pFeeFlightCpp = getMarkupCost($purchaseFlightCpp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $flighttaxAmountCpp = getMarkupCost($pFeeFlightCpp, $serviceTax, 1);
            $flighttcsAmountCpp = getMarkupCost($pFeeFlightCpp, $tcsTax, 1);
            $ppCostONChildBasis = $ppCostONChildBasis+($purchaseFlightCpp+$pFeeFlightCpp+$flighttaxAmountCpp+$flighttcsAmountCpp); 

            // Infant PP Cost
            $pFeeFlightEpp = getMarkupCost($purchaseFlightEpp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $flighttaxAmountEpp = getMarkupCost($pFeeFlightEpp, $serviceTax, 1);
            $flighttcsAmountEpp = getMarkupCost($pFeeFlightEpp, $tcsTax, 1);
            $ppCostOnInfantBasis = $ppCostOnInfantBasis+($purchaseFlightEpp+$pFeeFlightEpp+$flighttaxAmountEpp+$flighttcsAmountEpp); 
        }

        $saleFlightCost = $flightServicePCost+$totalFeeFlight;
        $flighttaxAmount = getMarkupCost($totalFeeFlight, $serviceTax, 1);
        $flighttcsAmount = getMarkupCost($totalFeeFlight, $tcsTax, 1);
    
        $flightFinalCost = $saleFlightCost+$flighttaxAmount+$flighttcsAmount;


    } 

    $purchaseTrainApp = $purchaseTrainCpp = $purchaseTrainEpp=$pFeeTrain=$trainMarkupCost=0;
 
    if($trainRequired==2){
        $qflightQuery=''; 
        $getFlightCost='';
        $qflightQuery = GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'quotationId="'.$quotationId.'" order by id asc ');
        while($getFlightCost = mysqli_fetch_array($qflightQuery)){
            
            $purchaseTrainApp = ($getFlightCost['adultCost']);        
            $purchaseTrainCpp = ($getFlightCost['childCost']);        
            $purchaseTrainEpp = ($getFlightCost['infantCost']);  

            $purchaseTrainA =  $purchaseTrainApp*$paxAdult;
            $purchaseTrainC =  $purchaseTrainCpp*$paxChild;
            $purchaseTrainE =  $purchaseTrainEpp*$paxInfant;
            $totalTrainCost = $purchaseTrainA+$purchaseTrainC+$purchaseTrainE;

            if($getFlightCost['markupType']==2){
              
               $pFeeTrain = ($getFlightCost['markupCost']*$paxAdult)+($getFlightCost['markupCost']*$paxChild)+($getFlightCost['markupCost']*$paxInfant);
            }else{
                $pFeeTrain = getMarkupCost($totalTrainCost,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            }

            $totalFeeTrain = $totalFeeTrain+$pFeeTrain;
            $trainServicePCost= $trainServicePCost+$totalTrainCost;

              // Adult PP Cost
            $pFeeTrainApp = getMarkupCost($purchaseTrainApp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $traintaxAmountApp = getMarkupCost($pFeeTrainApp, $serviceTax, 1);
            $traintcsAmountApp = getMarkupCost($pFeeTrainApp, $tcsTax, 1);
            $ppCostONAdultBasis = $ppCostONAdultBasis+($purchaseTrainApp+$pFeeTrainApp+$traintaxAmountApp+$traintcsAmountApp);
            
            // Child PP Cost
            $pFeeTrainCpp = getMarkupCost($purchaseTrainCpp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $traintaxAmountCpp = getMarkupCost($pFeeTrainCpp, $serviceTax, 1);
            $traintcsAmountCpp = getMarkupCost($pFeeTrainCpp, $tcsTax, 1);
            $ppCostONChildBasis = $ppCostONChildBasis+($purchaseTrainCpp+$pFeeTrainCpp+$traintaxAmountCpp+$traintcsAmountCpp); 

            // Infant PP Cost
            $pFeeTrainEpp = getMarkupCost($purchaseTrainEpp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $traintaxAmountEpp = getMarkupCost($pFeeTrainEpp, $serviceTax, 1);
            $traintcsAmountEpp = getMarkupCost($pFeeTrainEpp, $tcsTax, 1);
            $ppCostOnInfantBasis = $ppCostOnInfantBasis+($purchaseTrainEpp+$pFeeTrainEpp+$traintaxAmountEpp+$traintcsAmountEpp); 
        }

        $saleTrainCost = $trainServicePCost+$totalFeeTrain;
        $traintaxAmount = getMarkupCost($totalFeeTrain, $serviceTax, 1);
        $traintcsAmount = getMarkupCost($totalFeeTrain, $tcsTax, 1);
    
        $trainFinalCost = $saleTrainCost+$traintaxAmount+$traintcsAmount;


    } 

    $purchaseTransferApp = $purchaseTransferCpp = $purchaseTransferEpp=$pFeeTransfer=$transferMarkupCost=0;
 
    if($transferRequired==2){
        $qflightQuery=''; 
        $getFlightCost='';
        $qflightQuery = GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" order by id asc ');
        while($getFlightCost = mysqli_fetch_array($qflightQuery)){
            if($getFlightCost['transferType']==1){
                $purchaseTransferApp = ($getFlightCost['adultCost']+$getFlightCost['representativeEntryFee']);        
                $purchaseTransferCpp = ($getFlightCost['childCost']+$getFlightCost['representativeEntryFee']);        
                $purchaseTransferEpp = ($getFlightCost['infantCost']+$getFlightCost['representativeEntryFee']);  
    
                $purchaseTransferA =  $purchaseTransferApp*$paxAdult;
                $purchaseTransferC =  $purchaseTransferCpp*$paxChild;
                $purchaseTransferE =  $purchaseTransferEpp*$paxInfant;
                $totalTransferCost = $purchaseTransferA+$purchaseTransferC+$purchaseTransferE;

                if($getFlightCost['markupType']==2){
              
                    $pFeeTransfer = ($getFlightCost['markupCost']*$paxAdult)+($getFlightCost['markupCost']*$paxChild)+($getFlightCost['markupCost']*$paxInfant);
                 }else{
                     $pFeeTransfer = getMarkupCost($totalTransferCost,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
                 }
            }

            if($getFlightCost['transferType']==2){
                $purchaseTransferApp = ($getFlightCost['vehicleCost']+$getFlightCost['parkingFee']+$getFlightCost['representativeEntryFee']+$getFlightCost['assistance']+$getFlightCost['guideAllowance']+$getFlightCost['interStateAndToll']+$getFlightCost['miscellaneous'])*$getFlightCost['noOfVehicles'];        
    
                $purchaseTransferA =  $purchaseTransferApp;
           
                $totalTransferCost = $purchaseTransferA;

                if($getFlightCost['markupType']==2){
              
                    $pFeeTransfer = ($getFlightCost['markupCost']*$getFlightCost['noOfVehicles']);
                 }else{
                     $pFeeTransfer = getMarkupCost($totalTransferCost,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
                 }
            }
          

          

            $totalFeeTransfer = $totalFeeTransfer+$pFeeTransfer;
            $transferServicePCost= $transferServicePCost+$totalTransferCost;

              // Adult PP Cost
            $pFeeTransferApp = getMarkupCost($purchaseTransferApp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $transfertaxAmountApp = getMarkupCost($pFeeTransferApp, $serviceTax, 1);
            $transfertcsAmountApp = getMarkupCost($pFeeTransferApp, $tcsTax, 1);
            $ppCostONAdultBasis = $ppCostONAdultBasis+($purchaseTransferApp+$pFeeTransferApp+$transfertaxAmountApp+$transfertcsAmountApp);
            
            // Child PP Cost
            $pFeeTransferCpp = getMarkupCost($purchaseTransferCpp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $transfertaxAmountCpp = getMarkupCost($pFeeTransferCpp, $serviceTax, 1);
            $transfertcsAmountCpp = getMarkupCost($pFeeTransferCpp, $tcsTax, 1);
            $ppCostONChildBasis = $ppCostONChildBasis+($purchaseTransferCpp+$pFeeTransferCpp+$transfertaxAmountCpp+$transfertcsAmountCpp); 

            // Infant PP Cost
            $pFeeTransferEpp = getMarkupCost($purchaseTransferEpp,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
            
            $transfertaxAmountEpp = getMarkupCost($pFeeTransferEpp, $serviceTax, 1);
            $transfercsAmountEpp = getMarkupCost($pFeeTransferEpp, $tcsTax, 1);
            $ppCostOnInfantBasis = $ppCostOnInfantBasis+($purchaseTransferEpp+$pFeeTransferEpp+$transfertaxAmountEpp+$transfercsAmountEpp); 
        }

        $saleTransferCost = $transferServicePCost+$totalFeeTransfer;
        $transfertaxAmount = getMarkupCost($totalFeeTransfer, $serviceTax, 1);
        $transfertcsAmount = getMarkupCost($totalFeeTransfer, $tcsTax, 1);
    
        $transferFinalCost = $saleTransferCost+$transfertaxAmount+$transfertcsAmount;


    } 
    ?>

<div style="width: 100%;display:grid; grid-template-columns:70% 27%; grid-gap:30px;border-bottom:1px solid #ccc;padding-bottom:15px;">
<div >
<div style="text-align:left;font-size: 18px;margin: 0;width:100%;"><strong>Cost Summary</strong></div>
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;border-collapse: collapse;">
    <tr><th colspan="7">Value Added Services Cost Summary</th></tr>
    <tr bgcolor="#ddd">
        <th>Service&nbsp;Type</th>
        <th>Purchase&nbsp;Cost</th>
        <th>Markup&nbsp;Cost</th>
        <th>Sale&nbsp;Amount</th>
        <th>Tax</th>
        <th>TCS</th>
        <th>Final&nbsp;Cost</th>
    </tr>
    

    <?php  if($visaRequired==2){ ?>
    <tr bgcolor="#deb887">
        <td>Visa Service</td>
        <td><?php echo getTwoDecimalNumberFormat($visaServicePCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($totalFeeVisa); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($saleVisaCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($visataxAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($visatcsAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($visaFinalCost); ?></td>
    
    </tr>
    <?php } if($insuranceRequired==2){ ?>
    <tr bgcolor="#deb887">
        <td>Insurance Service</td>
        <td><?php echo getTwoDecimalNumberFormat($insuranceServicePCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($totalpFeeins); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($saleInsuranceCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($instaxAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($instcsAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($insuranceFinalCost); ?></td>
    
    </tr>
    <?php } if($flightRequired==2){ ?>
    <tr bgcolor="#deb887">
        <td>Flight Service</td>
        <td><?php echo getTwoDecimalNumberFormat($flightServicePCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($totalFeeFlight); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($saleFlightCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($flighttaxAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($flighttcsAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($flightFinalCost); ?></td>
    </tr>
    <?php } if($trainRequired==2){ ?>
    <tr bgcolor="#deb887">
        <td>Train Service</td>
        <td><?php echo getTwoDecimalNumberFormat($trainServicePCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($totalFeeTrain); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($saleTrainCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($traintaxAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($traintcsAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($trainFinalCost); ?></td>
    </tr>
    <?php } if($transferRequired==2){ ?>
    <tr bgcolor="#deb887">
        <td>Transfer Service</td>
        <td><?php echo getTwoDecimalNumberFormat($transferServicePCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($totalFeeTransfer); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($saleTransferCost); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($transfertaxAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($transfertcsAmount); ?></td>
        <td><?php echo getTwoDecimalNumberFormat($transferFinalCost); ?></td>
    </tr>
    <?php } ?>

        <?php 

            $totalCompanyCost = $visaServicePCost+$insuranceServicePCost+$flightServicePCost+$trainServicePCost+$transferServicePCost;
            $grandTotalMarkupCost = $totalFeeVisa+$totalpFeeins+$totalFeeFlight+$totalFeeTrain+$totalFeeTransfer;
            $grandTotalServiceTaxCost = $visataxAmount+$instaxAmount+$flighttaxAmount+$traintaxAmount+$transfertaxAmount;
            $grandTotalTCSCost = $visatcsAmount+$instcsAmount+$flighttcsAmount+$traintcsAmount+$transfertcsAmount;
            $grandSaleCost = $saleVisaCost+$saleInsuranceCost+$saleFlightCost+$saleTrainCost+$saleTransferCost;
            $grandTotalCost = $visaFinalCost+$insuranceFinalCost+$flightFinalCost+$trainFinalCost+$transferFinalCost;
            $clientCost = $proposalCost = $grandTotalCost;
            $clientMarginCost = $grandTotalMarkupCost; 
         
        ?>
    <tr>
        <th>Total</th>
        <th><?php echo getTwoDecimalNumberFormat($totalCompanyCost); ?></th>
        <th><?php echo getTwoDecimalNumberFormat($grandTotalMarkupCost); ?></th>
        <th><?php echo getTwoDecimalNumberFormat($grandSaleCost); ?></th>
        <th><?php echo getTwoDecimalNumberFormat($grandTotalServiceTaxCost); ?></th>
        <th><?php echo getTwoDecimalNumberFormat($grandTotalTCSCost); ?></th>
        <th><?php echo getTwoDecimalNumberFormat($grandTotalCost); ?></th>
    </tr>
</table>
</div>
<div >
<div style="text-align:left;font-size: 18px;margin: 0;width:100%;"><strong>General Info.</strong></div>
    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;border-collapse: collapse;">
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Adult&nbsp;Pax</strong></td>
        <td align="right" ><?php echo $paxAdult; ?></td> 
        </tr>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Child&nbsp;Pax</strong></td>
        <td align="right" ><?php echo $paxChild; ?></td> 
        </tr> 
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Infant&nbsp;Pax</strong></td>
        <td align="right" ><?php echo $paxInfant; ?></td> 
        </tr> 
      
        </table>
    <hr>
    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;border-collapse: collapse;">
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Client&nbsp;Cost(In <?php echo getCurrencyName($currencyId); ?>)</strong></td>
        <td align="right" ><?php echo getTwoDecimalNumberFormat($clientCost)?></td> 
        </tr>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Supplier&nbsp;Cost</strong></td>
        <td align="right" ><?php echo getTwoDecimalNumberFormat($totalCompanyCost); ?></td> 
        </tr>
         <tr>
        <td align="right" bgcolor="#ddd" ><strong>Margin</strong></td>
        <td align="right" ><?php echo getTwoDecimalNumberFormat($clientMarginCost); ?></td> 
        </tr>
     
    </table> 
</div>
<div>
<div style="text-align:left!important;font-size: 18px;margin: 0;"><strong>Per Pax Cost</strong></div>
            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;border-collapse: collapse;">
            <tr>
            <td align="left" bgcolor="#ddd" ><strong>Occupancy</strong></td>
            <td align="right" bgcolor="#ddd" ><strong>Cost&nbsp;(In&nbsp;<?php echo getCurrencyName($currencyId); ?>&nbsp;)</strong></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" bgcolor="#ddd" ><strong>Cost&nbsp;(In&nbsp;<?php echo getCurrencyName($newCurr); ?>&nbsp;)</strong></td> 
            <?php } ?>
            </tr>
            <?php
          
            if ($paxAdult>0) { ?>
            <tr>
            <td align="left" bgcolor="#ddd" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Adult&nbsp;Basis</td>
       
            <td align="right" ><?php echo getTwoDecimalNumberFormat($ppCostONAdultBasis); ?></td> 
            </tr>

            <?php } if ($paxChild>0) { ?>
            <tr>
            <td align="left" bgcolor="#ddd" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Child&nbsp;Basis</td>
            
            <td align="right" ><?php echo getTwoDecimalNumberFormat($ppCostONChildBasis); ?></td> 

            </tr>
            <?php } if ($paxInfant>0) { ?>
            <tr>
            <td align="left" bgcolor="#ddd" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Infant&nbsp;Basis</td>
            
            <td align="right" ><?php echo getTwoDecimalNumberFormat($ppCostOnInfantBasis); ?></td> 
        
            </tr>
            
            </tr>
            <?php } ?>
        </table>
        </div>
</div>
<!-- Value Added Services End -->
<!-- START Break up cost BLOCK --> 
<br>
<table width="70%" cellpadding="0" cellspacing="0" style="padding-top:10px; margin-top:10px; border-collapse: collapse;">
<tr>
    <td width="auto" valign="top">
        <!-- start Total tour cost -->
        <div style="text-align:left;font-size: 18px;padding-bottom: 10px;"><strong>Break-Up&nbsp;Cost</strong></div>
        <?php 
        $grandSingle=$grandDouble=$grandTwin=$grandTriple=$grandAWB=$grandChildWB=$grandChildNB=0;
    
        ?>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;border-collapse: collapse;">
            <?php
            $vn=''; 
            $vn = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            if(mysqli_num_rows($vn)>0){
            if($visaRequired==2){ ?>
                <tr><td colspan="10" align="left"><strong>Value Added Services(VISA)</strong></td></tr>
            <tr>
            <td align="left" bgcolor="#ddd"><strong>Visa&nbsp;Country</strong></td>
            <td align="left" bgcolor="#ddd"><strong>Service&nbsp;Type</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Purchase&nbsp;Cost</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Pax</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Markup</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Sale&nbsp;Cost</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Tax</strong></td>
            <td align="right" bgcolor="#ddd"><strong>TCS</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
            </tr>
            
            <?php
            // visa
            $visaMarkupCostApp = $saleVisaApp = $totalpurchaseVisaA = $totalvisaMarkupCostA = $totalSaleVisaA = 0;
            $visaMarkupCostCpp = $saleVisaCpp = $totalpurchaseVisaC = $totalvisaMarkupCostC = $totalSaleVisaC = 0;
            $visaMarkupCostEpp = $saleVisaEpp = $totalpurchaseVisaE = $totalvisaMarkupCostE = $totalSaleVisaE = 0;
            $totalserviceCostApp=$totalserviceCostCpp=$totalserviceCostEpp=$totalProcessingFee=0;$grandPurchaseSBCost=$totalVisaServiceCost=$visaFinalCostA=$visaServicePurchaseCost=$getVisaCost=0;
            $visaAdultPax=$visaChildPax=$visaInfantPax='';
    
                $VR=''; 
                $VR = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
                while($getVisaCost = mysqli_fetch_array($VR)){
                    $taxApplicable = $getVisaCost['taxApplicable'];
                    $visaAdultPax = $getVisaCost['adultPax'];
                    $visaChildPax = $getVisaCost['childPax'];
                    $visaInfantPax = $getVisaCost['infantPax'];
                // vfsCharges embassyFee
                $purchaseVisaBApp = ($getVisaCost['adultCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']);        
                
                $purchaseVisaBCpp = ($getVisaCost['childCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']);
                $purchaseVisaBEpp = ($getVisaCost['infantCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']);   

                $totalpurchaseVisaBC =  $purchaseVisaBCpp*$visaChildPax;
                $totalpurchaseVisaBE =  $purchaseVisaBEpp*$visaInfantPax;
                $totalpurchaseVisaBA =  $purchaseVisaBApp*$visaAdultPax;
                
                if($getVisaCost['markupType']==2){
                    $pFeeBA = $getVisaCost['processingFee']*$visaAdultPax; 
                    $pFeeBE = $getVisaCost['processingFee']*$visaInfantPax;
                    $pFeeBC = $getVisaCost['processingFee']*$visaChildPax;
                 }else{
                
                    $pFeeBA = getMarkupCost($totalpurchaseVisaBA,$getVisaCost['processingFee'],$getVisaCost['markupType']); 

                    $pFeeBE = getMarkupCost($totalpurchaseVisaBE,$getVisaCost['processingFee'],$getVisaCost['markupType']);
                    
                    $pFeeBC = getMarkupCost($totalpurchaseVisaBC,$getVisaCost['processingFee'],$getVisaCost['markupType']);
                 }

              
                
                $grandPurchaseSBCost = $grandPurchaseSBCost+($totalpurchaseVisaBA+$totalpurchaseVisaBE+$totalpurchaseVisaBC);

                $saleVisaBApp = $totalpurchaseVisaBA+$pFeeBA;
                if($taxApplicable==0){
                $visataxAmountBApp = getMarkupCost($pFeeBA, $serviceTax, 1);
                }
                $visatcsAmountBApp = getMarkupCost($pFeeBA, $tcsTax, 1);

                $visaFinalCostBA = $saleVisaBApp+$visataxAmountBApp+$visatcsAmountBApp;
                $totalVisaServiceBCost = $totalVisaServiceBCost + $visaFinalCostBA;

                $totalSaleVisaBCost = $totalSaleVisaBCost+$saleVisaBApp;
                $visaServicePurchaseCost = $visaServicePurchaseCost + $purchaseVisaBApp;
                $totalProcessingFee = $totalProcessingFee + $pFeeBA;
                $totalServiceBTax = $totalServiceBTax + $visataxAmountBApp;
                $totalServiceBTcs = $totalServiceBTcs + $visatcsAmountBApp;

                $rowspan=0;
                if($visaChildPax>0){
                    $rowspan = $rowspan+1;
                }
                if($visaInfantPax>0){
                    $rowspan = $rowspan+1;
                }

                ?>    
                <tr>
                <td align="left" rowspan="<?php echo $rowspan+1; ?>" bgcolor="#deb887"><strong><?php echo getCountryName($getVisaCost['visaCountryId']) ?></strong></td>
                <td align="left" bgcolor="#deb887"><strong>Visa Services(Adult)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseVisaBApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($visaAdultPax); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseVisaBA); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFeeBA); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleVisaBApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php if($visataxAmountBApp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visataxAmountBApp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($visatcsAmountBApp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visatcsAmountBApp); } ?></td>
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaFinalCostBA) ?></td>
                </tr>
                <?php 
           
            if($visaChildPax>0){
               
                $saleVisaBCpp = $totalpurchaseVisaBC+$pFeeBC;
                if($taxApplicable==0){
                $visataxAmountBCpp = getMarkupCost($pFeeBC, $serviceTax, 1);
                }
                $visatcsAmountBCpp = getMarkupCost($pFeeBC, $tcsTax, 1);

                $visaFinalCostBC = $saleVisaBCpp+$visataxAmountBCpp+$visatcsAmountBCpp;
                $totalVisaServiceBCost = $totalVisaServiceBCost + $visaFinalCostBC;

                $totalSaleVisaBCost = $totalSaleVisaBCost+$saleVisaBCpp;
                $visaServicePurchaseCost = $visaServicePurchaseCost + $purchaseVisaBCpp;
                $totalProcessingFee = $totalProcessingFee + $pFeeBC;
                $totalServiceBTax = $totalServiceBTax + $visataxAmountBCpp;
                $totalServiceBTcs = $totalServiceBTcs + $visatcsAmountBCpp;

                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Visa Services(Child)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseVisaBCpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($visaChildPax); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseVisaBC); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFeeBC); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleVisaBCpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php if($visataxAmountBCpp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visataxAmountBCpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($visatcsAmountBCpp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visatcsAmountBCpp); } ?></td>
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaFinalCostBC) ?></td>
                </tr>
                <?php 
            }
           
            if($visaInfantPax>0){
                
                $saleVisaBEpp = $totalpurchaseVisaBE+$pFeeBE;
                if($taxApplicable==0){
                $visataxAmountBEpp = getMarkupCost($pFeeBE, $serviceTax, 1);
                }
                $visatcsAmountBEpp = getMarkupCost($pFeeBE, $tcsTax, 1);

                $visaFinalCostBE = $saleVisaBEpp+$visataxAmountBEpp+$visatcsAmountBEpp;
                $totalVisaServiceBCost = $totalVisaServiceBCost + $visaFinalCostBE;

                $totalSaleVisaBCost = $totalSaleVisaBCost+$saleVisaBEpp;
                $visaServicePurchaseCost = $visaServicePurchaseCost + $purchaseVisaBEpp;
                $totalProcessingFee = $totalProcessingFee + $pFeeBE;
                $totalServiceBTax = $totalServiceBTax + $visataxAmountBEpp;
                $totalServiceBTcs = $totalServiceBTcs + $visatcsAmountBEpp;

                ?>    
               <tr>
                <td align="left" bgcolor="#deb887"><strong>Visa Services(Infant)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseVisaBEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($visaInfantPax); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseVisaBE); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFeeBE); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleVisaBEpp); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php if($visataxAmountBEpp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visataxAmountBEpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($visatcsAmountBEpp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visatcsAmountBEpp); } ?></td>
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaFinalCostBE) ?></td>
                </tr>
                <?php 
            }
        }
        ?>
        <tr>
            <th colspan="2" align="right">Total</th>
            <th align="right"><?php echo getTwoDecimalNumberFormat($visaServicePurchaseCost) ?></th>
            <th  align="right">&nbsp;</th>
            <th align="right"><?php echo getTwoDecimalNumberFormat($grandPurchaseSBCost) ?></th>
            <th align="right"><?php echo getTwoDecimalNumberFormat($totalProcessingFee) ?></th>
            <th align="right"><?php echo getTwoDecimalNumberFormat($totalSaleVisaBCost) ?></th>
            <th align="right"><?php echo getTwoDecimalNumberFormat($totalServiceBTax) ?></th>
            <th align="right"><?php echo getTwoDecimalNumberFormat($totalServiceBTcs) ?></th>
            <th align="right"><?php echo getTwoDecimalNumberFormat($totalVisaServiceBCost) ?></th>

        </tr>
        <?php
    }
}

            // insurance
            $rowspan=0;
            if($paxChild>0){
                $rowspan = $rowspan+1;
            }
            if($paxInfant>0){
                $rowspan = $rowspan+1;
            }

            $vi=''; 
            $vi = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            if(mysqli_num_rows($vi)){
            if($insuranceRequired==2){
                ?>
                <tr><td colspan="10" align="left"><strong>Value Added Services(Insurance)</strong></td></tr>
                <tr>
                <td align="left" bgcolor="#ddd"><strong>Insurance&nbsp;Country</strong></td>
                <td align="left" bgcolor="#ddd"><strong>Service&nbsp;Type</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Purchase&nbsp;Cost</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Pax</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Markup</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Sale&nbsp;Cost</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Tax</strong></td>
                <td align="right" bgcolor="#ddd"><strong>TCS</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
                </tr>
                <?php
                $ProcessingFee=$ProcessingFeetype=$getInsuranceCost=0;
                $purchaseInsuranceBApp=$purchaseInsuranceBCpp=$purchaseInsuranceBEpp=$totalSaleInsBCost=0;
                $purchaseInsuranceBA=$purchaseInsuranceBC=$purchaseInsuranceBE=$grandIPurchaseSBCost=$insServicePurchaseCost=$totalIProcessingFee=$totalInsServiceBCost=$totalIServiceBTax=$totalIServiceBTcs=0;
                $VR=''; 
                $VR = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
                while($getInsuranceCost = mysqli_fetch_array($VR)){
                    
                    $ProcessingFee = $getInsuranceCost['processingFee'];
                    $ProcessingFeetype = $getInsuranceCost['markupType'];

                    $purchaseInsuranceBApp = ($getInsuranceCost['adultCost']);        
                    $purchaseInsuranceBCpp = ($getInsuranceCost['childCost']);        
                    $purchaseInsuranceBEpp = ($getInsuranceCost['infantCost']);  

                    $purchaseInsuranceBA =  $purchaseInsuranceBApp*$paxAdult;
                    $purchaseInsuranceBC =  $purchaseInsuranceBCpp*$paxChild;
                    $purchaseInsuranceBE =  $purchaseInsuranceBEpp*$paxInfant;

                    if($getInsuranceCost['markupType']==2){

                    $pInsFeeBA = $getInsuranceCost['processingFee']*$paxAdult;  
                    $pInsFeeBC = $getInsuranceCost['processingFee']*$paxChild;
                    $pInsFeeBE = $getInsuranceCost['processingFee']*$paxInfant;
                     }else{
                    $pInsFeeBA = getMarkupCost($purchaseInsuranceBA,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);  
                    $pInsFeeBC = getMarkupCost($purchaseInsuranceBC,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);
                    $pInsFeeBE = getMarkupCost($purchaseInsuranceBE,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);
                     }
                    $grandIPurchaseSBCost = $grandIPurchaseSBCost+($purchaseInsuranceBA+$purchaseInsuranceBE+$purchaseInsuranceBC);

                    $saleInsuranceBA = $purchaseInsuranceBA+$pInsFeeBA;

                    $instaxAmountBApp = getMarkupCost($pInsFeeBA, $serviceTax, 1);
                    $instcsAmountBApp = getMarkupCost($pInsFeeBA, $tcsTax, 1);

                    $insFinalCostBA = $saleInsuranceBA+$instaxAmountBApp+$instcsAmountBApp;
                    $totalInsServiceBCost = $totalInsServiceBCost + $insFinalCostBA;

                    $totalSaleInsBCost = $totalSaleInsBCost+$saleInsuranceBA;
                    $insServicePurchaseCost = $insServicePurchaseCost + $purchaseInsuranceBApp;
                    $totalIProcessingFee = $totalIProcessingFee + $pInsFeeBA;
                    $totalIServiceBTax = $totalIServiceBTax + $instaxAmountBApp;
                    $totalIServiceBTcs = $totalIServiceBTcs + $instcsAmountBApp;
                    ?>
                    <tr>
                    <td align="left" rowspan="<?php echo $rowspan+1; ?>" bgcolor="#deb887"><strong><?php echo getCountryName($getInsuranceCost['countryId']) ?></strong></td>
                    <td align="left" bgcolor="#deb887"><strong>Insurance Services(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBApp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pInsFeeBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleInsuranceBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($instaxAmountBApp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instaxAmountBApp); } ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($instcsAmountBApp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instcsAmountBApp); } ?></td>
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insFinalCostBA) ?></td>
                    </tr>
                    <?php 
               
                if($paxChild>0){
                   
                    $saleInsuranceBC = $purchaseInsuranceBC+$pInsFeeBC;

                    $instaxAmountBC = getMarkupCost($pInsFeeBC, $serviceTax, 1);
                    $instcsAmountBC = getMarkupCost($pInsFeeBC, $tcsTax, 1);

                    $insFinalCostBC = $saleInsuranceBC+$instaxAmountBC+$instcsAmountBC;
                    $totalInsServiceBCost = $totalInsServiceBCost + $insFinalCostBC;

                    $totalSaleInsBCost = $totalSaleInsBCost+$saleInsuranceBC;
                    $insServicePurchaseCost = $insServicePurchaseCost + $purchaseInsuranceBCpp;
                    $totalIProcessingFee = $totalIProcessingFee + $pInsFeeBC;
                    $totalIServiceBTax = $totalIServiceBTax + $instaxAmountBC;
                    $totalIServiceBTcs = $totalIServiceBTcs + $instcsAmountBC;
    
                    ?>    
                    <tr>
                   
                    <td align="left" bgcolor="#deb887"><strong>Insurance Services(Child)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBCpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pInsFeeBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleInsuranceBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($instaxAmountBC>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instaxAmountBC); } ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($instcsAmountBC>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instcsAmountBC); } ?></td>
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insFinalCostBC) ?></td>
                    </tr>
                    <?php 
                }
               
                if($paxInfant>0){
                    

                    $saleInsuranceBE = $purchaseInsuranceBE+$pInsFeeBE;

                    $instaxAmountBE = getMarkupCost($pInsFeeBE, $serviceTax, 1);
                    $instcsAmountBE = getMarkupCost($pInsFeeBE, $tcsTax, 1);

                    $insFinalCostBE = $saleInsuranceBE+$instaxAmountBE+$instcsAmountBE;
                    $totalInsServiceBCost = $totalInsServiceBCost + $insFinalCostBE;

                    $totalSaleInsBCost = $totalSaleInsBCost+$saleInsuranceBE;
                    $insServicePurchaseCost = $insServicePurchaseCost + $purchaseInsuranceBEpp;
                    $totalIProcessingFee = $totalIProcessingFee + $pInsFeeBE;
                    $totalIServiceBTax = $totalIServiceBTax + $instaxAmountBE;
                    $totalIServiceBTcs = $totalIServiceBTcs + $instcsAmountBE;
    
                    ?>    
                    <tr>
                    
                    <td align="left" bgcolor="#deb887"><strong>Insurance Services(Infant)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBEpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pInsFeeBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleInsuranceBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($instaxAmountBE>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instaxAmountBE); } ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($instcsAmountBE>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instcsAmountBE); } ?></td>
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insFinalCostBE) ?></td>
                    </tr>
                    <?php 
                }
            }

            ?>
            <tr>
                <th colspan="2" align="right">Total</th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($insServicePurchaseCost) ?></th>
                <th  align="right">&nbsp;</th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($grandIPurchaseSBCost) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalIProcessingFee) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalSaleInsBCost) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalIServiceBTax) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalIServiceBTcs) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalInsServiceBCost) ?></th>
    
            </tr>
            <?php
        }

    }       
            // flight
            $fn = GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            if(mysqli_num_rows($fn)>0){
            if($flightRequired==2){
                ?>
                <tr><td colspan="10" align="left"><strong>Value Added Services(Flight)</strong></td></tr>
                <tr>
                <td align="left" bgcolor="#ddd"><strong>Flight&nbsp;Destination</strong></td>
                <td align="left" bgcolor="#ddd"><strong>Service&nbsp;Type</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Purchase&nbsp;Cost</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Pax</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Markup</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Sale&nbsp;Cost</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Tax</strong></td>
                <td align="right" bgcolor="#ddd"><strong>TCS</strong></td>
                <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
                </tr>
                <?php
                $ProcessingFee=$ProcessingFeetype=$getFlightCost=0;
                $purchaseFlightBApp=$purchaseFlightBCpp=$purchaseFlightBEpp=$totalSaleFlyBCost=0;
                $purchaseFlightBA=$purchaseFlightBC=$purchaseFlightBE=$grandFPurchaseSBCost=$flyServicePurchaseCost=$totalFProcessingFee=$totalInsServiceBCost=$totalFServiceBTax=$totalFServiceBTcs=0;
                $qflightQuery=''; 
                $qflightQuery = GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
                while($getFlightCost = mysqli_fetch_array($qflightQuery)){
             
                    $purchaseFlightBApp = ($getFlightCost['totalAdultCost']);        
                    $purchaseFlightBCpp = ($getFlightCost['totalChildCost']);        
                    $purchaseFlightBEpp = ($getFlightCost['totalInfantCost']);  

                    $purchaseFlightBA =  $purchaseFlightBApp*$paxAdult;
                    $purchaseFlightBC =  $purchaseFlightBCpp*$paxChild;
                    $purchaseFlightBE =  $purchaseFlightBEpp*$paxInfant;
                    if($getFlightCost['markupType']==2){
                    $pFlyFeeBA = $getFlightCost['markupCost']*$paxAdult;  
                    $pFlyFeeBC = $getFlightCost['markupCost']*$paxChild;
                    $pFlyFeeBE = $getFlightCost['markupCost']*$paxInfant;
                    }else{
                    $pFlyFeeBA = getMarkupCost($purchaseFlightBA,$getFlightCost['markupCost'],$getFlightCost['markupType']);  
                    $pFlyFeeBC = getMarkupCost($purchaseFlightBC,$getFlightCost['markupCost'],$getFlightCost['markupType']);
                    $pFlyFeeBE = getMarkupCost($purchaseFlightBE,$getFlightCost['markupCost'],$getFlightCost['markupType']);
                    }
                    $grandFPurchaseSBCost = $grandFPurchaseSBCost+($purchaseFlightBA+$purchaseFlightBE+$purchaseFlightBC);

                    $saleFlightBA = $purchaseFlightBA+$pFlyFeeBA;

                    $flytaxAmountBA = getMarkupCost($pFlyFeeBA, $serviceTax, 1);
                    $flytcsAmountBA = getMarkupCost($pFlyFeeBA, $tcsTax, 1);

                    $flyFinalCostBA = $saleFlightBA+$flytaxAmountBA+$flytcsAmountBA;
                    $totalFlyServiceBCost = $totalFlyServiceBCost + $flyFinalCostBA;

                    $totalSaleFlyBCost = $totalSaleFlyBCost+$saleFlightBA;
                    $flyServicePurchaseCost = $flyServicePurchaseCost + $purchaseFlightBApp;
                    $totalFProcessingFee = $totalFProcessingFee + $pFlyFeeBA;
                    $totalFServiceBTax = $totalFServiceBTax + $flytaxAmountBA;
                    $totalFServiceBTcs = $totalFServiceBTcs + $flytcsAmountBA;
                    ?>
                    <tr>
                    <td align="left" rowspan="<?php echo $rowspan+1; ?>" bgcolor="#deb887"><strong><?php echo getDestination($getFlightCost['arrivalTo']) ?></strong></td>
                    <td align="left" bgcolor="#deb887"><strong>Flight Services(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBApp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFlyFeeBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($flytaxAmountBA>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytaxAmountBA); } ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($flytcsAmountBA>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytcsAmountBA); } ?></td>
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flyFinalCostBA) ?></td>
                    </tr>
                    <?php 
               
                if($paxChild>0){
                    
                    $saleFlightBC = $purchaseFlightBC+$pFlyFeeBC;

                    $flytaxAmountBC = getMarkupCost($pFlyFeeBC, $serviceTax, 1);
                    $flytcsAmountBC = getMarkupCost($pFlyFeeBC, $tcsTax, 1);

                    $flyFinalCostBC = $saleFlightBC+$flytaxAmountBC+$flytcsAmountBC;
                    $totalFlyServiceBCost = $totalFlyServiceBCost + $flyFinalCostBC;

                    $totalSaleFlyBCost = $totalSaleFlyBCost+$saleFlightBC;
                    $flyServicePurchaseCost = $flyServicePurchaseCost + $purchaseFlightBCpp;
                    $totalFProcessingFee = $totalFProcessingFee + $pFlyFeeBC;
                    $totalFServiceBTax = $totalFServiceBTax + $flytaxAmountBC;
                    $totalFServiceBTcs = $totalFServiceBTcs + $flytcsAmountBC;
                    ?>
                    <tr>
                   
                    <td align="left" bgcolor="#deb887"><strong>Flight Services(Child)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBCpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFlyFeeBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($flytaxAmountBC>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytaxAmountBC); } ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($flytcsAmountBC>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytcsAmountBC); } ?></td>
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flyFinalCostBC) ?></td>
                    </tr>
                    <?php 
                }
               
                if($paxInfant>0){
                    
                
                    $saleFlightBE = $purchaseFlightBE+$pFlyFeeBE;

                    $flytaxAmountBE = getMarkupCost($pFlyFeeBE, $serviceTax, 1);
                    $flytcsAmountBE = getMarkupCost($pFlyFeeBE, $tcsTax, 1);

                    $flyFinalCostBE = $saleFlightBE+$flytaxAmountBE+$flytcsAmountBE;
                    $totalFlyServiceBCost = $totalFlyServiceBCost + $flyFinalCostBE;

                    $totalSaleFlyBCost = $totalSaleFlyBCost+$saleFlightBE;
                    $flyServicePurchaseCost = $flyServicePurchaseCost + $purchaseFlightBEpp;
                    $totalFProcessingFee = $totalFProcessingFee + $pFlyFeeBE;
                    $totalFServiceBTax = $totalFServiceBTax + $flytaxAmountBE;
                    $totalFServiceBTcs = $totalFServiceBTcs + $flytcsAmountBE;
                    ?>
                    <tr>
                   
                    <td align="left" bgcolor="#deb887"><strong>Flight Services(Infant)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBEpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFlyFeeBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($flytaxAmountBE>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytaxAmountBE); } ?></td>
                    <td align="right" bgcolor="#deb887"><?php if($flytcsAmountBE>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytcsAmountBE); } ?></td>
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flyFinalCostBE) ?></td>
                    </tr>
                    <?php 
                }
            }

            ?>
            <tr>
                <th colspan="2" align="right">Total</th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($flyServicePurchaseCost) ?></th>
                <th  align="right">&nbsp;</th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($grandFPurchaseSBCost) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalFProcessingFee) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalSaleFlyBCost) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalFServiceBTax) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalFServiceBTcs) ?></th>
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalFlyServiceBCost) ?></th>
    
            </tr>
            <?php
        }
    }



      // Train Service
      $tn = GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
      if(mysqli_num_rows($tn)>0){
      if($trainRequired==2){

          ?>
          <tr><td colspan="10" align="left"><strong>Value Added Services(Train)</strong></td></tr>
          <tr>
          <td align="left" bgcolor="#ddd"><strong>Train&nbsp;Destination</strong></td>
          <td align="left" bgcolor="#ddd"><strong>Service&nbsp;Type</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Purchase&nbsp;Cost</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Pax</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Markup</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Sale&nbsp;Cost</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Tax</strong></td>
          <td align="right" bgcolor="#ddd"><strong>TCS</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
          </tr>
          <?php
          $ProcessingFee=$ProcessingFeetype=$getFlightCost=0;
          $purchaseTrainBApp=$purchaseTrainBCpp=$purchaseTrainBEpp=$totalSaleTrainBCost=0;
          $purchaseTrainBA=$purchaseTrainBC=$purchaseTrainBE=$grandFPurchaseSBCost=$trainServicePurchaseCost=$totalTProcessingFee=$totalTServiceBTax=$totalTServiceBTcs=0;
          $qflightQuery=''; 
          $qflightQuery = GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
          while($getFlightCost = mysqli_fetch_array($qflightQuery)){
       
              $purchaseTrainBApp = ($getFlightCost['adultCost']);        
              $purchaseTrainBCpp = ($getFlightCost['childCost']);        
              $purchaseTrainBEpp = ($getFlightCost['infantCost']);  

              $purchaseTrainBA =  $purchaseTrainBApp*$paxAdult;
              $purchaseTrainBC =  $purchaseTrainBCpp*$paxChild;
              $purchaseTrainBE =  $purchaseTrainBEpp*$paxInfant;
              if($getFlightCost['markupType']==2){
              $pTrainFeeBA = $getFlightCost['markupCost']*$paxAdult;  
              $pTrainFeeBC = $getFlightCost['markupCost']*$paxChild;
              $pTrainFeeBE = $getFlightCost['markupCost']*$paxInfant;
              }else{
              $pTrainFeeBA = getMarkupCost($purchaseTrainBA,$getFlightCost['markupCost'],$getFlightCost['markupType']);  
              $pTrainFeeBC = getMarkupCost($purchaseTrainBC,$getFlightCost['markupCost'],$getFlightCost['markupType']);
              $pTrainFeeBE = getMarkupCost($purchaseTrainBE,$getFlightCost['markupCost'],$getFlightCost['markupType']);
              }
              $grandTPurchaseSBCost = $grandTPurchaseSBCost+($purchaseTrainBA+$purchaseTrainBE+$purchaseTrainBC);

              $saleTrainBA = $purchaseTrainBA+$pTrainFeeBA;

              $traintaxAmountBA = getMarkupCost($pTrainFeeBA, $serviceTax, 1);
              $traintcsAmountBA = getMarkupCost($pTrainFeeBA, $tcsTax, 1);

              $trainFinalCostBA = $saleTrainBA+$traintaxAmountBA+$traintcsAmountBA;
              $totalTrainServiceBCost = $totalTrainServiceBCost + $trainFinalCostBA;

              $totalSaleTrainBCost = $totalSaleTrainBCost+$saleTrainBA;
              $trainServicePurchaseCost = $trainServicePurchaseCost + $purchaseTrainBApp;
              $totalTProcessingFee = $totalTProcessingFee + $pTrainFeeBA;
              $totalTServiceBTax = $totalTServiceBTax + $traintaxAmountBA;
              $totalTServiceBTcs = $totalTServiceBTcs + $traintcsAmountBA;
              ?>
              <tr>
              <td align="left" rowspan="<?php echo $rowspan+1; ?>" bgcolor="#deb887"><strong><?php echo getDestination($getFlightCost['arrivalTo']) ?></strong></td>
              <td align="left" bgcolor="#deb887"><strong>Train Services(Adult)</strong></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTrainBApp); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTrainBA); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pTrainFeeBA); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTrainBA); ?></td>
              <td align="right" bgcolor="#deb887"><?php if($traintaxAmountBA>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($traintaxAmountBA); } ?></td>
              <td align="right" bgcolor="#deb887"><?php if($traintcsAmountBA>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($traintcsAmountBA); } ?></td>
             
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($trainFinalCostBA) ?></td>
              </tr>
              <?php 
         
          if($paxChild>0 && $trainNum>0){
              
              $saleTrainBC = $purchaseTrainBC+$pTrainFeeBC;

              $traintaxAmountBC = getMarkupCost($pTrainFeeBC, $serviceTax, 1);
              $traintcsAmountBC = getMarkupCost($pTrainFeeBC, $tcsTax, 1);

              $trainFinalCostBC = $saleTrainBC+$traintaxAmountBC+$traintcsAmountBC;
              $totalTrainServiceBCost = $totalTrainServiceBCost + $trainFinalCostBC;

              $totalSaleTrainBCost = $totalSaleTrainBCost+$saleTrainBC;
              $trainServicePurchaseCost = $trainServicePurchaseCost + $purchaseTrainBCpp;
              $totalTProcessingFee = $totalTProcessingFee + $pTrainFeeBC;
              $totalTServiceBTax = $totalTServiceBTax + $traintaxAmountBC;
              $totalTServiceBTcs = $totalTServiceBTcs + $traintcsAmountBC;
              ?>
              <tr>
             
              <td align="left" bgcolor="#deb887"><strong>Train Services(Child)</strong></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTrainBCpp); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTrainBC); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pTrainFeeBC); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTrainBC); ?></td>
              <td align="right" bgcolor="#deb887"><?php if($traintaxAmountBC>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($traintaxAmountBC); } ?></td>
              <td align="right" bgcolor="#deb887"><?php if($traintcsAmountBC>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($traintcsAmountBC); } ?></td>
             
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($trainFinalCostBC) ?></td>
              </tr>
              <?php 
          }
         
          if($paxInfant>0 && $trainNum>0){
              
          
              $saleTrainBE = $purchaseTrainBE+$pTrainFeeBE;

              $traintaxAmountBE = getMarkupCost($pTrainFeeBE, $serviceTax, 1);
              $traintcsAmountBE = getMarkupCost($pTrainFeeBE, $tcsTax, 1);

              $trainFinalCostBE = $saleTrainBE+$traintaxAmountBE+$traintcsAmountBE;
              $totalTrainServiceBCost = $totalTrainServiceBCost + $trainFinalCostBE;

              $totalSaleTrainBCost = $totalSaleTrainBCost+$saleTrainBE;
              $trainServicePurchaseCost = $trainServicePurchaseCost + $purchaseTrainBEpp;
              $totalTProcessingFee = $totalTProcessingFee + $pTrainFeeBE;
              $totalTServiceBTax = $totalTServiceBTax + $traintaxAmountBE;
              $totalTServiceBTcs = $totalTServiceBTcs + $traintcsAmountBE;
              ?>
              <tr>
             
              <td align="left" bgcolor="#deb887"><strong>Train Services(Infant)</strong></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTrainBEpp); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTrainBE); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pTrainFeeBE); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTrainBE); ?></td>
              <td align="right" bgcolor="#deb887"><?php if($traintaxAmountBE>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($traintaxAmountBE); } ?></td>
              <td align="right" bgcolor="#deb887"><?php if($traintcsAmountBE>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($traintcsAmountBE); } ?></td>
             
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($trainFinalCostBE) ?></td>
              </tr>
              <?php 
          }
        }

      ?>
      <tr>
          <th colspan="2" align="right">Total</th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($trainServicePurchaseCost) ?></th>
          <th  align="right">&nbsp;</th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($grandTPurchaseSBCost) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTProcessingFee) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalSaleTrainBCost) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTServiceBTax) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTServiceBTcs) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTrainServiceBCost) ?></th>

      </tr>
      <?php
    }
}



      // Train Service
      $tpt = GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and transferType=1 order by id asc');
      if(mysqli_num_rows($tpt)>0){
      if($transferRequired==2){

          ?>
          <tr><td colspan="10" align="left"><strong>Value Added Services(Transfer)</strong></td></tr>
          <tr>
          <td align="left" bgcolor="#ddd"><strong>Transfer&nbsp;Destination</strong></td>
          <td align="left" bgcolor="#ddd"><strong>Service&nbsp;Type</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Purchase&nbsp;Cost</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Pax</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Markup</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Sale&nbsp;Cost</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Tax</strong></td>
          <td align="right" bgcolor="#ddd"><strong>TCS</strong></td>
          <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
          </tr>
          <?php
          $ProcessingFee=$ProcessingFeetype=$getFlightCost=0;
          $purchaseTransferBApp=$purchaseTransferBCpp=$purchaseTransferBEpp=$totalSaleTransferBCost=0;
          $purchaseTransferBA=$purchaseTransferBC=$purchaseTransferBE=$grandTPTPurchaseSBCost=$transferServicePurchaseCost=$totalTPTProcessingFee=$totalTPTServiceBTax=$totalTPTServiceBTcs=0;
          $qflightQuery=''; 
          $qflightQuery = GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and transferType=1 order by id asc');
          while($getFlightCost = mysqli_fetch_array($qflightQuery)){
            if($getFlightCost['transferType']==1){
              $purchaseTransferBApp = ($getFlightCost['adultCost']+$getFlightCost['representativeEntryFee']);        
              $purchaseTransferBCpp = ($getFlightCost['childCost']+$getFlightCost['representativeEntryFee']);        
              $purchaseTransferBEpp = ($getFlightCost['infantCost']+$getFlightCost['representativeEntryFee']);  

              $purchaseTransferBA =  $purchaseTransferBApp*$paxAdult;
              $purchaseTransferBC =  $purchaseTransferBCpp*$paxChild;
              $purchaseTransferBE =  $purchaseTransferBEpp*$paxInfant;

              if($getFlightCost['markupType']==2){
              $pTransferFeeBA = $getFlightCost['markupCost']*$paxAdult;  
              $pTransferFeeBC = $getFlightCost['markupCost']*$paxChild;
              $pTransferFeeBE = $getFlightCost['markupCost']*$paxInfant;
              }else{
              $pTransferFeeBA = getMarkupCost($purchaseTransferBA,$getFlightCost['markupCost'],$getFlightCost['markupType']);  
              $pTransferFeeBC = getMarkupCost($purchaseTransferBC,$getFlightCost['markupCost'],$getFlightCost['markupType']);
              $pTransferFeeBE = getMarkupCost($purchaseTransferBE,$getFlightCost['markupCost'],$getFlightCost['markupType']);
              }

              $grandTPTPurchaseSBCost = $grandTPTPurchaseSBCost+($purchaseTransferBA+$purchaseTransferBE+$purchaseTransferBC);
            }

            if($getFlightCost['transferType']==2){
                $purchaseTransferApp = ($getFlightCost['vehicleCost']+$getFlightCost['parkingFee']+$getFlightCost['representativeEntryFee']+$getFlightCost['assistance']+$getFlightCost['guideAllowance']+$getFlightCost['interStateAndToll']+$getFlightCost['miscellaneous'])*$getFlightCost['noOfVehicles'];        
    
                $purchaseTransferBA =  $purchaseTransferApp;
                $grandTPTPurchaseSBCost = $grandTPTPurchaseSBCost+($purchaseTransferBA);
                if($getFlightCost['markupType']==2){
              
                    $pTransferFeeBA = ($getFlightCost['markupCost']*$getFlightCost['noOfVehicles']);
                 }else{
                     $pTransferFeeBA = getMarkupCost($purchaseTransferBA,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
                 }
            }


              

              $saleTransferBA = $purchaseTransferBA+$pTransferFeeBA;

              $transfertaxAmountBA = getMarkupCost($pTransferFeeBA, $serviceTax, 1);
              $transfertcsAmountBA = getMarkupCost($pTransferFeeBA, $tcsTax, 1);

              $transferFinalCostBA = $saleTransferBA+$transfertaxAmountBA+$transfertcsAmountBA;
              $totalTransferServiceBCost = $totalTransferServiceBCost + $transferFinalCostBA;

              $totalSaleTransferBCost = $totalSaleTransferBCost+$saleTransferBA;
              $transferServicePurchaseCost = $transferServicePurchaseCost + $purchaseTransferBApp;
              $totalTPTProcessingFee = $totalTPTProcessingFee + $pTransferFeeBA;
              $totalTPTServiceBTax = $totalTPTServiceBTax + $transfertaxAmountBA;
              $totalTPTServiceBTcs = $totalTPTServiceBTcs + $transfertcsAmountBA;
              ?>
              <tr>
              <td align="left" rowspan="<?php echo $rowspan+1; ?>" bgcolor="#deb887"><strong><?php echo getDestination($getFlightCost['destinationId']) ?></strong></td>
              <td align="left" bgcolor="#deb887"><strong>Transfer Services(Adult)</strong></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferBApp); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferBA); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pTransferFeeBA); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferBA); ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountBA>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountBA); } ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountBA>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountBA); } ?></td>
             
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferFinalCostBA) ?></td>
              </tr>
              <?php 
         
          if($paxChild>0 && $transferSIC>0){
              
              $saleTransferBC = $purchaseTransferBC+$pTransferFeeBC;

              $transfertaxAmountBC = getMarkupCost($pTransferFeeBC, $serviceTax, 1);
              $transfertcsAmountBC = getMarkupCost($pTransferFeeBC, $tcsTax, 1);

              $transferFinalCostBC = $saleTransferBC+$transfertaxAmountBC+$transfertcsAmountBC;
              $totalTransferServiceBCost = $totalTransferServiceBCost + $transferFinalCostBC;

              $totalSaleTransferBCost = $totalSaleTransferBCost+$saleTransferBC;
              $transferServicePurchaseCost = $transferServicePurchaseCost + $purchaseTransferBCpp;
              $totalTPTProcessingFee = $totalTPTProcessingFee + $pTransferFeeBC;
              $totalTPTServiceBTax = $totalTPTServiceBTax + $transfertaxAmountBC;
              $totalTPTServiceBTcs = $totalTPTServiceBTcs + $transfertcsAmountBC;
              ?>
              <tr>
             
              <td align="left" bgcolor="#deb887"><strong>Transfer Services(Child)</strong></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferBCpp); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferBC); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pTransferFeeBC); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferBC); ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountBC>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountBC); } ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountBC>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountBC); } ?></td>
             
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferFinalCostBC) ?></td>
              </tr>
              <?php 
          }
         
          if($paxInfant>0 && $transferSIC>0){
              
          
              $saleTransferBE = $purchaseTransferBE+$pTransferFeeBE;

              $transfertaxAmountBE = getMarkupCost($pTransferFeeBE, $serviceTax, 1);
              $transfertcsAmountBE = getMarkupCost($pTransferFeeBE, $tcsTax, 1);

              $transferFinalCostBE = $saleTransferBE+$transfertaxAmountBE+$transfertcsAmountBE;
              $totalTransferServiceBCost = $totalTransferServiceBCost + $transferFinalCostBE;

              $totalSaleTransferBCost = $totalSaleTransferBCost+$saleTransferBE;
              $transferServicePurchaseCost = $transferServicePurchaseCost + $purchaseTransferBEpp;
              $totalTPTProcessingFee = $totalTPTProcessingFee + $pTransferFeeBE;
              $totalTPTServiceBTax = $totalTPTServiceBTax + $transfertaxAmountBE;
              $totalTPTServiceBTcs = $totalTPTServiceBTcs + $transfertcsAmountBE;
              ?>
              <tr>
             
              <td align="left" bgcolor="#deb887"><strong>Transfer Services(Infant)</strong></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferBEpp); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferBE); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pTransferFeeBE); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferBE); ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountBE>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountBE); } ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountBE>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountBE); } ?></td>
             
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferFinalCostBE) ?></td>
              </tr>
              <?php 
          }
        }

          $getFlightCost='';
          
          $qflightQuery=''; 
          $qflightQuery = GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and transferType=2 order by id asc');
          if(mysqli_num_rows($qflightQuery)>0){
          while($getFlightCost = mysqli_fetch_array($qflightQuery)){
           
            $noOfVehicles = $getFlightCost['noOfVehicles'];
            if($getFlightCost['transferType']==2){
                $purchaseTransferBV = ($getFlightCost['vehicleCost']+$getFlightCost['parkingFee']+$getFlightCost['representativeEntryFee']+$getFlightCost['assistance']+$getFlightCost['guideAllowance']+$getFlightCost['interStateAndToll']+$getFlightCost['miscellaneous']);        
    
                $purchaseTransferPVTB =  ($purchaseTransferBV*$getFlightCost['noOfVehicles']);
                $grandTPTPurchaseSBCost = $grandTPTPurchaseSBCost+($purchaseTransferPVTB);
                if($getFlightCost['markupType']==2){
              
                    $pTransferFeeBPVT = ($getFlightCost['markupCost']*$getFlightCost['noOfVehicles']);
                 }else{
                     $pTransferFeeBPVT = getMarkupCost($purchaseTransferPVTB,$getFlightCost['markupCost'],$getFlightCost['markupType']); 
                 }
            }

              $saleTransferBPVT = $purchaseTransferPVTB+$pTransferFeeBPVT;

              $transfertaxAmountBPVT = getMarkupCost($pTransferFeeBPVT, $serviceTax, 1);
              $transfertcsAmountBPVT = getMarkupCost($pTransferFeeBPVT, $tcsTax, 1);

              $transferFinalCostBPVT = $saleTransferBPVT+$transfertaxAmountBPVT+$transfertcsAmountBPVT;
              $totalTransferServiceBCost = $totalTransferServiceBCost + $transferFinalCostBPVT;

              $totalSaleTransferBCost = $totalSaleTransferBCost+$saleTransferBPVT;
              $transferServicePurchaseCost = $transferServicePurchaseCost + $purchaseTransferPVTB;
              $totalTPTProcessingFee = $totalTPTProcessingFee + $pTransferFeeBPVT;
              $totalTPTServiceBTax = $totalTPTServiceBTax + $transfertaxAmountBPVT;
              $totalTPTServiceBTcs = $totalTPTServiceBTcs + $transfertcsAmountBPVT;
              ?>
              <tr>
              <td align="left" bgcolor="#deb887"><strong><?php echo getDestination($getFlightCost['arrivalTo']) ?></strong></td>
              <td align="left" bgcolor="#deb887"><strong>Transfer Services(PVT)</strong></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferBV); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo ($noOfVehicles); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferPVTB); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pTransferFeeBPVT); ?></td>
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferBPVT); ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountBPVT>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountBPVT); } ?></td>
              <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountBPVT>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountBPVT); } ?></td>
             
              <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferFinalCostBPVT) ?></td>
              </tr>
            <?php } }  ?>
   
      <tr>
          <th colspan="2" align="right">Total</th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($transferServicePurchaseCost) ?></th>
          <th  align="right">&nbsp;</th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($grandTPTPurchaseSBCost) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTPTProcessingFee) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalSaleTransferBCost) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTPTServiceBTax) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTPTServiceBTcs) ?></th>
          <th align="right"><?php echo getTwoDecimalNumberFormat($totalTransferServiceBCost) ?></th>

      </tr>
      <?php
    }
}
           

            if($transferSIC>0 && $transferRequired==3){
                // $purchaseFlightEpp = $purchaseFlightE/$allInfantPaxF;

                $transferMarkupCostApp = getMarkupCost($purchaseTransferApp, $transfer, $transferMarkupType);
                $saleTransferApp = $purchaseTransferApp+$transferMarkupCostApp;

                $transfertaxAmountApp = getMarkupCost($saleTransferApp, $serviceTax, 1);
                $transfertcsAmountApp = getMarkupCost($saleTransferApp, $tcsTax, 1);
                $transferCostApp = $saleTransferApp+$transfertaxAmountApp+$transfertcsAmountApp;
                $totalserviceCostApp = $totalserviceCostApp + $transferCostApp;

                $totalpurchaseTransferA =  $purchaseTransferApp*$paxAdult;
                $totaltransferMarkupCostA = $transferMarkupCostApp*$paxAdult;
                $totalSaleTransferA =  $saleTransferApp*$paxAdult;

                $totaltransfertaxAmountA = $transfertaxAmountApp*$paxAdult;
                $totaltransfertcsAmountA = $transfertcsAmountApp*$paxAdult;

                $totaltransferCostA = $totalSaleTransferA+$totaltransfertaxAmountA+$totaltransfertcsAmountA;

                $totalServicePurchaseCost = $totalServicePurchaseCost + $totalpurchaseTransferA;
                $totalServiceMarkup = $totalServiceMarkup + $totaltransferMarkupCostA;
                $totalServiceTax = $totalServiceTax + $totaltransfertaxAmountA;
                $totalServiceTcs = $totalServiceTcs + $totaltransfertcsAmountA;

                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Transfer Services SIC(Adult)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferMarkupCostApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountApp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountApp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountApp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountApp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCostApp); ?></td>
                <!-- <td align="right" bgcolor="#deb887">Pax</td> -->
                <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseTransferA); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltransferMarkupCostA); ?></td>
                <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalSaleTransferA);?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertaxAmountA>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertaxAmountA); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertcsAmountA>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertcsAmountA); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltransferCostA); ?></td>
                </tr>
                <?php 
            }

            if($transferSIC>0 && $transferRequired==3 && $paxChild>0){
                // $purchaseFlightEpp = $purchaseFlightE/$allInfantPaxF;
                
                $transferMarkupCostCpp = getMarkupCost($purchaseTransferCpp, $transfer, $transferMarkupType);
                $saleTransferCpp = $purchaseTransferCpp+$transferMarkupCostCpp;

                $transfertaxAmountCpp = getMarkupCost($saleTransferCpp, $serviceTax, 1);
                $transfertcsAmountCpp = getMarkupCost($saleTransferCpp, $tcsTax, 1);
                $transferCostCpp = $saleTransferCpp+$transfertaxAmountCpp+$transfertcsAmountCpp;
                $totalserviceCostCpp = $totalserviceCostCpp + $transferCostCpp;

                $totalpurchaseTransferC =  $purchaseTransferCpp*$paxChild;
                $totaltransferMarkupCostC = $transferMarkupCostCpp*$paxChild;
                $totalSaleTransferC =  $saleTransferCpp*$paxChild;

                $totaltransfertaxAmountC = $transfertaxAmountCpp*$paxChild;
                $totaltransfertcsAmountC = $transfertcsAmountCpp*$paxChild;

                $totaltransferCostC = $totalSaleTransferC+$totaltransfertaxAmountC+$totaltransfertcsAmountC;

                $totalServicePurchaseCost = $totalServicePurchaseCost + $totalpurchaseTransferC;
                $totalServiceMarkup = $totalServiceMarkup + $totaltransferMarkupCostC;
                $totalServiceTax = $totalServiceTax + $totaltransfertaxAmountC;
                $totalServiceTcs = $totalServiceTcs + $totaltransfertcsAmountC;

                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Transfer Services SIC(Child)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferCpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferMarkupCostCpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferCpp); ?></td>
                <!-- <td align="right" bgcolor="#deb887">Pax</td> -->
                <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountCpp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountCpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountCpp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountCpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCostCpp); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseTransferC); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltransferMarkupCostC); ?></td>
                <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalSaleTransferC);?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertaxAmountC>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertaxAmountC); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertcsAmountC>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertcsAmountC); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltransferCostC); ?></td>
                </tr>
                <?php 
            }

            if($transferSIC>0 && $transferRequired==3 && $paxInfant>0){
                // $purchaseFlightEpp = $purchaseFlightE/$allInfantPaxF;
                
                $transferMarkupCostEpp = getMarkupCost($purchaseTransferEpp, $transfer, $transferMarkupType);
                $saleTransferEpp = $purchaseTransferEpp+$transferMarkupCostEpp;

                $transfertaxAmountEpp = getMarkupCost($saleTransferEpp, $serviceTax, 1);
                $transfertcsAmountEpp = getMarkupCost($saleTransferEpp, $tcsTax, 1);
                $transferCostEpp = $saleTransferEpp+$transfertaxAmountEpp+$transfertcsAmountEpp;
                $totalserviceCostEpp = $totalserviceCostEpp + $transferCostEpp;

                $totalpurchaseTransferE =  $purchaseTransferEpp*$paxInfant;
                $totaltransferMarkupCostE = $transferMarkupCostEpp*$paxInfant;
                $totalSaleTransferE =  $saleTransferEpp*$paxInfant;

                $totaltransfertaxAmountE = $transfertaxAmountEpp*$paxInfant;
                $totaltransfertcsAmountE = $transfertcsAmountEpp*$paxInfant;

                $totaltransferCostE = $totalSaleTransferE+$totaltransfertaxAmountE+$totaltransfertcsAmountE;

                $totalServicePurchaseCost = $totalServicePurchaseCost + $totalpurchaseTransferE;
                $totalServiceMarkup = $totalServiceMarkup + $totaltransferMarkupCostE;
                $totalServiceTax = $totalServiceTax + $totaltransfertaxAmountE;
                $totalServiceTcs = $totalServiceTcs + $totaltransfertcsAmountE;

                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Transfer Services SIC(Infant)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferMarkupCostEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferEpp); ?></td>
                <!-- <td align="right" bgcolor="#deb887">Pax</td> -->
                <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountEpp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountEpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountEpp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountEpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCostEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseTransferE); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltransferMarkupCostE); ?></td>
                <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalSaleTransferE);?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertaxAmountE>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertaxAmountE); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertcsAmountE>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertcsAmountE); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltransferCostE); ?></td>
                </tr>
                <?php 
            }

            if($transferPVT>0 && $transferRequired==3){
                // $purchaseFlightEpp = $purchaseFlightE/$allInfantPaxF;
                $VehicleCostPpp = $totalVehicleCost/$paxAdult;
                $vehicleMarkupCostPpp = getMarkupCost($VehicleCostPpp, $transfer, $transferMarkupType);
                $saleVehiclePpp = ($VehicleCostPpp+$vehicleMarkupCostPpp);

                $transfertaxAmountPpp = getMarkupCost($saleVehiclePpp, $serviceTax, 1);
                $transfertcsAmountPpp = getMarkupCost($saleVehiclePpp, $tcsTax, 1);
                $transferCostPpp = $saleVehiclePpp+$transfertaxAmountPpp+$transfertcsAmountPpp;
                $totalserviceCostApp = $totalserviceCostApp + $transferCostPpp;

                $totalpurchaseVehicleP =  $VehicleCostPpp*$paxAdult;
                $totalvehicleMarkupCostP = $vehicleMarkupCostPpp*$paxAdult;

                $totaltransfertaxAmountP = $transfertaxAmountPpp*$paxAdult;
                $totaltransfertcsAmountP = $transfertcsAmountPpp*$paxAdult;
                $transferSaleCostP = $totalpurchaseVehicleP+$totalvehicleMarkupCostP;

                $totalSaleVehicleCostP =  $transferSaleCostP+$totaltransfertaxAmountP+$totaltransfertcsAmountP;

                $totalServicePurchaseCost = $totalServicePurchaseCost + $totalpurchaseVehicleP;
                $totalServiceMarkup = $totalServiceMarkup + $totalvehicleMarkupCostP;
                $totalServiceTax = $totalServiceTax + $totaltransfertaxAmountP;
                $totalServiceTcs = $totalServiceTcs + $totaltransfertcsAmountP;

                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Transfer Services (PVT)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($VehicleCostPpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($vehicleMarkupCostPpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleVehiclePpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php if($transfertaxAmountPpp>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertaxAmountPpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($transfertcsAmountPpp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($transfertcsAmountPpp); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCostPpp); ?></td>
                <!-- <td align="right" bgcolor="#deb887">Pax</td> -->
                <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseVehicleP); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalvehicleMarkupCostP); ?></td>
                <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($transferSaleCostP);?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertaxAmountP>0){ echo $serviceTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertaxAmountP); } ?></td>
                <td align="right" bgcolor="#deb887"><?php if($totaltransfertcsAmountP>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($totaltransfertcsAmountP); } ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSaleVehicleCostP); ?></td>
                </tr>
                <?php 
            }

          ?>
        </table>

        <!-- end Total tour cost -->

   
    </td>
    
</tr>
</table> 
    
<br>

        <?php 
       
        $nameinv = 'totalCompanyCost="'.$totalCompanyCost.'",totalQuotCost="'.$clientCost.'",totalMarkupCost="'.$grandTotalMarkupCost.'",totalquotCostWithMarkup="'.$grandSaleCost.'",totalDiscountCost="'.$grandTotalDiscountCost.'",totalServiceTaxCost="'.$grandTotalServiceTaxCost.'",totalTCSCost="'.$grandTotalTCSCost.'",totalMargin="'.$clientMarginCost.'",sglBasisCost="'.$ppCostONSingleBasis.'",dblBasisCost="'.$ppCostONDoubleBasis.'",twinCost="'.$ppCostONTwinBasis.'",tplBasisCost="'.$ppCostOnTripleBasis.'",extraAdultCost="'.$ppCostOnExtraBedABasis.'",CWBCost="'.$pcCostOnExtraBedCBasis.'",CNBCost="'.$pcCostOnExtraNBedCBasis.'"';
        updatelisting(_QUOTATION_MASTER_,$nameinv,'id="'.$quotationId.'"');
        ?>
        <!-- end basis wiose cost -->
    
<!-- END PER PAX BLOCK AND TOTAL TOUR COST BLOCK -->
<br>

<div style="overflow:hidden; margin-top:20px;border-collapse: collapse;">
  <table border="0" align="right" cellpadding="5" cellspacing="0">
        <tbody><tr>
        <td> 
        <input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();"> 
        </td>
        </tr>
        </tbody>
    </table>
</div>
