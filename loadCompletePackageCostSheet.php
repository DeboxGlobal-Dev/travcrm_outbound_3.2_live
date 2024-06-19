<?php
// FOR USE SAME FILE IN PROPOSALS and FIT 
if(isset($_REQUEST['quotationId'])){
    include "inc.php";
    $quotationId = $_REQUEST['quotationId'];
    
    // $quotationType = $_REQUEST['quotationType'];
    // $hotelCategory = $_REQUEST['hotelCategory'];
    // $hotelType = $_REQUEST['hotelType'];
  

    $rsp = "";
    $rsp = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.$quotationId.'"');
    $resultpageQuotation = mysqli_fetch_array($rsp);
    $quotationType = $resultpageQuotation['quotationType'];
    $hotelCategory =  $resultpageQuotation['hotCategory'];
    $hotelType =  $resultpageQuotation['hotelType'];

    $rs = '';
    $rs = GetPageRecord('*', _QUERY_MASTER_, 'id="'.($resultpageQuotation['queryId']).'"');
    $resultpage = mysqli_fetch_array($rs);
}

$paxAdult = ($resultpageQuotation['adult']);
$paxChild = ($resultpageQuotation['child']);
$paxInfant = ($resultpageQuotation['infant']);
$totalPax = ($paxAdult + $paxChild + $paxInfant);
if($totalPax == 0){
    $totalPax =  2;
}



$singleRoom = $resultpageQuotation['sglRoom'];
$doubleRoom = $resultpageQuotation['dblRoom'];
$twinRoom   = $resultpageQuotation['twinRoom'];
$tripleRoom = $resultpageQuotation['tplRoom'];
// $quadBedRoom = $resultpageQuotation['quadNoofRoom'];
$sixBedRoom = $resultpageQuotation['sixNoofBedRoom'];
$eightBedRoom = $resultpageQuotation['eightNoofBedRoom'];
$tenBedRoom = $resultpageQuotation['tenNoofBedRoom'];
$teenBedRoom = $resultpageQuotation['teenNoofRoom'];
$EBedChild = $resultpageQuotation['childwithNoofBed'];
$NBedChild = $resultpageQuotation['childwithoutNoofBed'];
$EBedAdult = $resultpageQuotation['extraNoofBed'];
$sixNoofBed = $resultpageQuotation['sixNoofBedRoom'];
$eightNoofBed = $resultpageQuotation['eightNoofBedRoom'];
$tenNoofBed = $resultpageQuotation['tenNoofBedRoom'];
$teenNoofBed = $resultpageQuotation['teenNoofRoom'];
$quadNoofBed = $resultpageQuotation['quadNoofRoom'];
$infantNoofBed = $resultpageQuotation['infant'];
$serviceTax = $resultpageQuotation['serviceTax'];
$serviceTcs = $resultpageQuotation['tcs'];

$isChildBFQ = $resultpageQuotation['isChildBreakfast'];
$isChildDNQ = $resultpageQuotation['isChildDinner'];
$isChildLHQ = $resultpageQuotation['isChildLunch'];

// No CATEGORY IN SINGLE HHOTEL CATEGORY QUOTATION AND FIT QUOTATION
$multihotelQuery = $MultiQuotPreview = $val = "";
$gstType = 1;
$travelType = 2; 

$slabAndRoomType = $resultpageQuotation['slabAndRoomType'];
$calculationType = $resultpageQuotation['calculationType'];
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


// SLAB AND ESCORT DETAILS
$defaultSlabSql = "";
$totalDF = 2; 
$totalDF = $DF_SGL = $DF_DBL = $DF_TWN = $DF_TPL = $DF_QUAD = $DF_SIX = $DF_EIGHT = $DF_TEN = $DF_ABED = $DF_CBED = 0;
$defaultSlabSql = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1 ');
if (mysqli_num_rows($defaultSlabSql)>0){
    $defaultSlabData = mysqli_fetch_array($defaultSlabSql);
    $dividingFactor = $defaultSlabData['dividingFactor'];  

    $DF_SGL = clean($defaultSlabData['DF_SGL']);
    $DF_DBL = clean($defaultSlabData['DF_DBL']);
    $DF_TWN = clean($defaultSlabData['DF_TWN']);
    $DF_TPL = clean($defaultSlabData['DF_TPL']);
    $DF_QUAD = clean($defaultSlabData['DF_QUAD']);
    $DF_SIX = clean($defaultSlabData['DF_SIX']);
    $DF_EIGHT = clean($defaultSlabData['DF_EIGHT']);
    $DF_TEN = clean($defaultSlabData['DF_TEN']);
    $DF_ABED = clean($defaultSlabData['DF_ABED']);
    $DF_CBED = clean($defaultSlabData['DF_CBED']);

    $totalDF = round($DF_SGL+$DF_DBL+$DF_TWN+$DF_TPL+$DF_QUAD+$DF_SIX+$DF_EIGHT+$DF_TEN+$DF_ABED+$DF_CBED);


    $slabId = $defaultSlabData['id'];
    $paxAdultLE = $defaultSlabData['localEscort'];
    $paxAdultFE = $defaultSlabData['foreignEscort'];

    $esQLE = "";
    // echo ' 1 and slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"';
    $esQLE = GetPageRecord('*', 'quotationFOCRates',' 1 and slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"');
    if (mysqli_num_rows($esQLE)>0 && $paxAdultLE>0) {
        $escortDataLE = mysqli_fetch_array($esQLE);
        $sglRoomLE = $escortDataLE['sglNORoom'];
        $dblRoomLE = $escortDataLE['dblNORoom'];
        $tplRoomLE = $escortDataLE['tplNORoom'];
        // cost discount
        $focTypeLE="LE";
        $hotelCostLE=$escortDataLE['hotelCost'];
        $guideCostLE=$escortDataLE['guideCost'];
        $activityCostLE=$escortDataLE['activityCost'];
        $entranceCostLE=$escortDataLE['entranceCost'];
        $transferCostLE=$escortDataLE['transferCost'];
        $ferryCostLE=$escortDataLE['ferryCost'];
        $trainCostLE=$escortDataLE['trainCost'];
        $flightCostLE=$escortDataLE['flightCost'];
        $restaurantCostLE=$escortDataLE['restaurantCost'];
        $otherCostLE=$escortDataLE['otherCost'];

        $hotelCalTypeLE=$escortDataLE['hotelCalType'];
        $guideCalTypeLE=$escortDataLE['guideCalType'];
        $activityCalTypeLE=$escortDataLE['activityCalType'];
        $entranceCalTypeLE=$escortDataLE['entranceCalType'];
        $transferCalTypeLE=$escortDataLE['transferCalType'];
        $ferryCalTypeLE=$escortDataLE['ferryCalType'];
        $trainCalTypeLE=$escortDataLE['trainCalType'];
        $flightCalTypeLE=$escortDataLE['flightCalType'];
        $restaurantCalTypeLE=$escortDataLE['restaurantCalType'];
        $otherCalTypeLE=$escortDataLE['otherCalType'];
    }
    $esQFE = "";
    $esQFE = GetPageRecord('*', 'quotationFOCRates', ' 1 and slabId="'.$slabId.'" and focType="FE" and quotationId="'.$quotationId.'"');
    if (mysqli_num_rows($esQFE)>0 && $paxAdultFE>0) {
        $escortDataFE = mysqli_fetch_array($esQFE);
        $sglRoomFE = $escortDataFE['sglNORoom'];
        $dblRoomFE = $escortDataFE['dblNORoom'];
        $tplRoomFE = $escortDataFE['tplNORoom'];

        // cost discount
        $focTypeFE="FE";
        $hotelCostFE=$escortDataFE['hotelCost'];
        $guideCostFE=$escortDataFE['guideCost'];
        $activityCostFE=$escortDataFE['activityCost'];
        $entranceCostFE=$escortDataFE['entranceCost'];
        $transferCostFE=$escortDataFE['transferCost'];
        $ferryCostFE=$escortDataFE['ferryCost'];
        $trainCostFE=$escortDataFE['trainCost'];
        $flightCostFE=$escortDataFE['flightCost'];
        $restaurantCostFE=$escortDataFE['restaurantCost'];
        $otherCostFE=$escortDataFE['otherCost'];

        $hotelCalTypeFE=$escortDataFE['hotelCalType'];
        $guideCalTypeFE=$escortDataFE['guideCalType'];
        $activityCalTypeFE=$escortDataFE['activityCalType'];
        $entranceCalTypeFE=$escortDataFE['entranceCalType'];
        $transferCalTypeFE=$escortDataFE['transferCalType'];
        $ferryCalTypeFE=$escortDataFE['ferryCalType'];
        $trainCalTypeFE=$escortDataFE['trainCalType'];
        $flightCalTypeFE=$escortDataFE['flightCalType'];
        $restaurantCalTypeFE=$escortDataFE['restaurantCalType'];
        $otherCalTypeFE=$escortDataFE['otherCalType'];
    }

    if ($defaultSlabData['fromRange'] == $defaultSlabData['toRange'] || $defaultSlabData['toRange'] == 0) {
        $paxrange = $defaultSlabData['fromRange'];
    } else {
        $paxrange = $defaultSlabData['fromRange'] . '-' . $defaultSlabData['toRange'];
    }
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
if ($resultpageQuotation['serviceTax']>0) {
    $serviceTax = $resultpageQuotation['serviceTax'];
} else {
    $serviceTax = 0;
}

// GST DATA 
if ($resultpageQuotation['tcs']>0) {
    $tcsTax = $resultpageQuotation['tcs'];
} else {
    $tcsTax = 0;
}


// DISCOUNT DATA
$discountType = $resultpageQuotation['discountType'];
$discount = $resultpageQuotation['discount'];
$serviceTaxDivident=100;
$isUni_Mark = $resultpageQuotation['isUni_Mark'];
 
if($isUni_Mark == 0){ 
    // MARKUP DAta
    $c12 = GetPageRecord('*', 'quotationServiceMarkup', ' quotationId="' . $quotationId . '"');
    $serviceMarkuD = mysqli_fetch_array($c12);

    $package = $serviceMarkuD['package'];
    $packageMarkupType = $serviceMarkuD['packageMarkupType'];

    $train = $serviceMarkuD['train'];
    $trainMarkupType = $serviceMarkuD['trainMarkupType'];

    $flight = $serviceMarkuD['flight'];
    $flightMarkupType = $serviceMarkuD['flightMarkupType'];

    $visa = $serviceMarkuD['visa'];
    $visaMarkupType = $serviceMarkuD['visaMarkupType'];

    $passport = $serviceMarkuD['passport'];
    $passportMarkupType = $serviceMarkuD['passportMarkupType'];

    $insurance = $serviceMarkuD['insurance'];
    $insuranceMarkupType = $serviceMarkuD['insuranceMarkupType'];
    
    $uniMarkup = 0;
    $uniMarkupType = 1;
    
}else{
    $package = 0;
    $packageMarkupType = 1;

    $train = 0;
    $trainMarkupType = 1;

    $flight = 0;
    $flightMarkupType = 1;

    $visa = 0;
    $visaMarkupType = 1;

    $passport = 0;
    $passportMarkupType = 1;

    $insurance = 0;
    $insuranceMarkupType = 1;

    $uniMarkup = $resultpageQuotation['markup'];
    $uniMarkupType = $resultpageQuotation['markupType'];

}
  
?>
<table width="100%" cellpadding="0" cellspacing="0" >
    <tr>
    <td width="2%" >&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="88%" colspan="3">
        <h3 style="text-align:left; position:relative;">Cost&nbsp;Sheet&nbsp;|&nbsp;<?php echo $quotPreviewId; ?></h3>
    </td>
    <td width="10%">
        <?php if($_REQUEST['export']!='yes'){ ?>
        <a href="loadCompletePackageCostSheet.php?export=yes&quotationId=<?php echo $_REQUEST['quotationId']; ?>&finalcategory=<?php echo $_REQUEST['finalcategory']; ?>">
        <input name="Cancel" type="button" class="whitembutton"  value="Export"  style="background-color: #fff !important; padding: 4px 20px;">
        </a>            
        <?php } ?>      
    </td>
    </tr>
</table>
<!-- Value Added Services Start -->
<?php
$visaCostType = $resultpageQuotation['visaCostType'];
$passportCostType = $resultpageQuotation['passportCostType'];
$insuranceCostType = $resultpageQuotation['insuranceCostType'];
$flightCostType = $resultpageQuotation['flightCostType'];
$flightRequired = $resultpageQuotation['flightRequired'];
$transferRequired = $resultpageQuotation['transferRequired'];

$visaRequired = $resultpageQuotation['visaRequired'];
$insuranceRequired = $resultpageQuotation['insuranceRequired'];
$passportRequired = $resultpageQuotation['passportRequired'];
$calculationType = $resultpageQuotation['calculationType'];

if($flightCostType==0 || $flightRequired==2 || $visaCostType==1 || $insuranceCostType==1){
?>
<div style="padding-top:10px; margin-top:10px; border-top:1px solid #ccc;"></div>

    <?php 

    $purchaseFlightApp = $purchaseFlightCpp = $purchaseFlightEpp=$flightPPCostA=$flightPPCostC=$flightPPCostE=$grandFlightCostA=0;
    if($flightRequired==2){
        $qflightQuery=''; 
        $qflightQuery = GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'quotationId="'.$quotationId.'" and isFlightTaken="yes" and dayId=0 order by id asc');
        while($getFlightCost = mysqli_fetch_array($qflightQuery)){
            $flightACost = convert_to_base($getFlightCost['currencyValue'], $baseCurrencyVal, ($getFlightCost['adultCost']+$getFlightCost['adultTax']));
            $flightCCost = convert_to_base($getFlightCost['currencyValue'], $baseCurrencyVal,($getFlightCost['childCost']+$getFlightCost['childTax']));   
            $flightECost = convert_to_base($getFlightCost['currencyValue'], $baseCurrencyVal,($getFlightCost['infantCost']+$getFlightCost['infantTax']));   

            $flyadultPax = $getFlightCost['adultPax'];
            $flychildPax = $getFlightCost['childPax'];
            $flyinfantPax = $getFlightCost['infantPax'];
            $gstTax = getGstValueById($getFlightCost['gstTax']);
            // Adult cost
            $flightmarkupCostA = getMarkupCost($flightACost, $getFlightCost['markupCost'], $getFlightCost['markupType']);
            $gstTaxCostA = getMarkupCost(($flightACost+$flightmarkupCostA),$gstTax,1);
            $tcsTaxCostFA = getMarkupCost(($flightACost+$flightmarkupCostA),$tcsTax,1);
            $purchaseFlightApp = $purchaseFlightApp + $flightACost;  
            $flightMarkupCostApp = $flightMarkupCostApp+$flightmarkupCostA;

            $totalFlightCostA = ($flightACost+$flightmarkupCostA+$gstTaxCostA+$tcsTaxCostFA)*$flyadultPax;
            $grandFlightCostA = $grandFlightCostA+$totalFlightCostA;
            // Child Cost
            $flightmarkupCostC = getMarkupCost($flightCCost, $getFlightCost['markupCost'], $getFlightCost['markupType']);
            $gstTaxCostC = getMarkupCost(($flightCCost+$flightmarkupCostC),$gstTax,1);
            $tcsTaxCostFC = getMarkupCost(($flightCCost+$flightmarkupCostC),$tcsTax,1);
            $purchaseFlightCpp = $purchaseFlightCpp + $flightCCost;
            $flightMarkupCostCpp = $flightMarkupCostCpp+$flightmarkupCostC;

            $totalFlightCostC = ($flightCCost+$flightmarkupCostC+$gstTaxCostC+$tcsTaxCostFC)*$flychildPax;
            $grandFlightCostC = $grandFlightCostC+$totalFlightCostC;
            // Infant Cost
            $flightmarkupCostE = getMarkupCost($flightECost, $getFlightCost['markupCost'], $getFlightCost['markupType']);
            $gstTaxCostE = getMarkupCost(($flightECost+$flightmarkupCostE),$gstTax,1);
            $tcsTaxCostFE = getMarkupCost(($flightECost+$flightmarkupCostE),$tcsTax,1);
            $purchaseFlightEpp = $purchaseFlightEpp + $flightECost;
            $flightMarkupCostEpp = $flightMarkupCostEpp+$flightmarkupCostE;

            $totalFlightCostE = ($flightECost+$flightmarkupCostE+$gstTaxCostE+$tcsTaxCostFE)*$flyinfantPax;
            $grandFlightCostE = $grandFlightCostE+$totalFlightCostE;
        }
        
        $flightPPCostA = $grandFlightCostA/$paxAdult;
        $flightPPCostC = $grandFlightCostC/$paxChild;
        $flightPPCostE = $grandFlightCostE/$paxInfant;
    } 

    $purchaseVisaApp = $purchaseVisaCpp = $purchaseVisaEpp=$grandVisaCostA=$grandVisaCostC=$grandVisaCostE=$visaPPCostA=$visaPPCostC
    =$visaPPCostE=0;
    if($visaCostType==1){
        // visaRequired
        $qVisaQuery=''; 
        $qVisaQuery = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
        while($getVisaCost = mysqli_fetch_array($qVisaQuery)){
            
            $visaACost = convert_to_base($getVisaCost['currencyValue'], $baseCurrencyVal, ($getVisaCost['adultCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));
            $visaCCost = convert_to_base($getVisaCost['currencyValue'], $baseCurrencyVal, ($getVisaCost['childCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));   
            $visaECost = convert_to_base($getVisaCost['currencyValue'], $baseCurrencyVal, ($getVisaCost['infantCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));  

            $visaadultPax = $getVisaCost['adultPax'];
            $visachildPax = $getVisaCost['childPax'];
            $visainfantPax = $getVisaCost['infantPax'];
            $taxApplicable = $getVisaCost['taxApplicable'];
            $gstTax = getGstValueById($getVisaCost['gstTax']);
            //Adult Cost
            $visamarkupCostA = getMarkupCost($visaACost, $getVisaCost['processingFee'], $getVisaCost['markupType']);
            // if($taxApplicable!=1){
            $gstTaxCostA = getMarkupCost(($visaACost+$visamarkupCostA),$gstTax,1);
            $tcsTaxCostVA = getMarkupCost(($visaACost+$visamarkupCostA),$tcsTax,1);
            $purchaseVisaApp = $purchaseVisaApp + $visaACost;  
            $visaMarkupCostApp = $visaMarkupCostApp+$visamarkupCostA;

            $totalVisaCostA = ($visaACost+$visamarkupCostA+$gstTaxCostA+$tcsTaxCostVA)*$visaadultPax;
            $grandVisaCostA = $grandVisaCostA+$totalVisaCostA;
            // Child Cost
            $visamarkupCostC = getMarkupCost($visaCCost, $getVisaCost['processingFee'], $getVisaCost['markupType']);
            // if($taxApplicable!=1){
            $gstTaxCostC = getMarkupCost(($visaCCost+$visamarkupCostC),$gstTax,1);
            $tcsTaxCostVC = getMarkupCost(($visaCCost+$visamarkupCostC),$tcsTax,1);
            $purchaseVisaCpp = $purchaseVisaCpp + $visaCCost;
            $visaMarkupCostCpp = $visaMarkupCostCpp+$visamarkupCostC;

            $totalVisaCostC = ($visaCCost+$visamarkupCostC+$gstTaxCostC+$tcsTaxCostVC)*$visachildPax;
            $grandVisaCostC = $grandVisaCostC+$totalVisaCostC;
            //Infant Cost
            $visamarkupCostE = getMarkupCost($visaECost, $getVisaCost['processingFee'], $getVisaCost['markupType']);
            // if($taxApplicable!=1){
            $gstTaxCostE = getMarkupCost(($visaECost+$visamarkupCostE),$gstTax,1);
            $tcsTaxCostVE = getMarkupCost(($visaECost+$visamarkupCostE),$tcsTax,1);
            $purchaseVisaEpp = $purchaseVisaEpp + $visaECost;
            $visaMarkupCostEpp = $visaMarkupCostEpp+$visamarkupCostE;

            $totalVisaCostE = ($visaECost+$visamarkupCostE+$gstTaxCostE+$tcsTaxCostVE)*$visainfantPax;
            $grandVisaCostE = $grandVisaCostE+$totalVisaCostE;
        }
        $visaPPCostA = $grandVisaCostA/$paxAdult;
        $visaPPCostC = $grandVisaCostC/$paxChild;
        $visaPPCostE = $grandVisaCostE/$paxInfant;
    } 

    if($insuranceCostType==1){
        $grandInsCostA=$insPPCostA=$insPPCostC=$insPPCostE=0;
        $qInsQuery=''; 
        $qInsQuery = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
        while($getInsuranceCost = mysqli_fetch_array($qInsQuery)){
            $insACost = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, $getInsuranceCost['adultCost']);
            $insCCost = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, $getInsuranceCost['childCost']);   
            $insECost = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, $getInsuranceCost['infantCost']);
            
            $insadultPax = $getInsuranceCost['adultPax'];
            $inschildPax = $getInsuranceCost['childPax'];
            $insinfantPax = $getInsuranceCost['infantPax'];
            $gstTax = getGstValueById($getInsuranceCost['gstTax']);

            // /Adult Cost
            $insmarkupCostA = getMarkupCost($insACost, $getInsuranceCost['processingFee'], $getInsuranceCost['markupType']);
            $gstTaxCostA = getMarkupCost(($insACost+$insmarkupCostA),$gstTax,1);
            $tcsTaxCostA = getMarkupCost(($insACost+$insmarkupCostA),$tcsTax,1);
            $purchaseInsApp = $purchaseInsApp + $insACost;  
            $insMarkupCostApp = $insMarkupCostApp+$insmarkupCostA;

            $totalInsCostA = ($insACost+$insmarkupCostA+$gstTaxCostA+$tcsTaxCostA)*$insadultPax;
            $grandInsCostA = $grandInsCostA+$totalInsCostA;
            // Child Cost
            $insmarkupCostC = getMarkupCost($insCCost, $getInsuranceCost['processingFee'], $getInsuranceCost['markupType']);
            $gstTaxCostC = getMarkupCost(($insCCost+$insmarkupCostC),$gstTax,1);
            $tcsTaxCostC = getMarkupCost(($insCCost+$insmarkupCostC),$tcsTax,1);
            $purchaseInsCpp = $purchaseInsCpp + $insCCost;
            $insMarkupCostCpp = $insMarkupCostCpp+$insmarkupCostC;

            $totalInsCostC = ($insCCost+$insmarkupCostC+$gstTaxCostC+$tcsTaxCostC)*$inschildPax;
            $grandInsCostC = $grandInsCostC+$totalInsCostC;

            $insmarkupCostE = getMarkupCost($insECost, $getInsuranceCost['processingFee'], $getInsuranceCost['markupType']);
            $gstTaxCostE = getMarkupCost(($insECost+$insmarkupCostE),$gstTax,1);
            $tcsTaxCostE = getMarkupCost(($insECost+$insmarkupCostE),$tcsTax,1);
            $purchaseInsEpp = $purchaseInsEpp + $insECost;
            $insMarkupCostEpp = $insMarkupCostEpp+$insmarkupCostE;

            $totalInsCostE = ($insECost+$insmarkupCostE+$gstTaxCostE+$tcsTaxCostE)*$insinfantPax;
            $grandInsCostE = $grandInsCostE+$totalInsCostE;
        }
            $insPPCostA = $grandInsCostA/$paxAdult;
            $insPPCostC = $grandInsCostC/$paxChild;
            $insPPCostE = $grandInsCostE/$paxInfant;
    } 

    $purchaseTransferApp = $purchaseTransferCpp = $purchaseTransferEpp=$transfermarkupCostA=$transfermarkupCostE=$transfermarkupCostE=0;
    if($transferRequired==2){
        $qtransferQuery=''; 
        $qtransferQuery = GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and transferType=1 and isTransferTaken="yes" and dayId=0 order by id asc');
        $sicrecord = mysqli_num_rows($qtransferQuery);
        if($sicrecord>0){
        while($getTransferCost = mysqli_fetch_array($qtransferQuery)){
            $adultCost = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, ($getTransferCost['adultCost']+$getTransferCost['representativeEntryFee']));
            $childCost = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, ($getTransferCost['childCost']+$getTransferCost['representativeEntryFee']));
            $infantCost = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, ($getTransferCost['infantCost']+$getTransferCost['representativeEntryFee']));
            
            $purchaseTransferApp = $purchaseTransferApp + $adultCost; 
            $transfermarkupCostApp = $transfermarkupCostApp + (getMarkupCost($adultCost,$getTransferCost['markupCost'],$getTransferCost['markupType']));

            $purchaseTransferCpp = $purchaseTransferCpp + $childCost;  
            $transfermarkupCostCpp = $transfermarkupCostCpp + (getMarkupCost($childCost,$getTransferCost['markupCost'],$getTransferCost['markupType']));

            $purchaseTransferEpp = $purchaseTransferEpp + $infantCost;
            $transfermarkupCostEpp = $transfermarkupCostEpp + (getMarkupCost($infantCost,$getTransferCost['markupCost'],$getTransferCost['markupType']));
  
        } 
    }

//     $qpvtQuery=''; 
//     $qpvtQuery = GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and transferType=2 order by id asc');
//     $pvtrecord = mysqli_num_rows($qpvtQuery);
//     if($sicrecord>0){
//     while($getTransferCost = mysqli_fetch_array($qpvtQuery)){
//         $vehicleCost = ($getTransferCost['vehicleCost']+$getTransferCost['representativeEntryFee']+$getTransferCost['parkingFee']+$getTransferCost['assistance']+$getTransferCost['guideAllowance']+$getTransferCost['interStateAndToll']+$getTransferCost['miscellaneous'])*$getTransferCost['noOfVehicles'];
        
//         $purchaseTransferApp = $purchaseTransferApp + $adultCost; 
//         $transfermarkupCostApp = $transfermarkupCostApp + (getMarkupCost($adultCost,$getTransferCost['markupCost'],$getTransferCost['markupType']));

//         $purchaseTransferCpp = $purchaseTransferCpp + $childCost;  
//         $transfermarkupCostCpp = $transfermarkupCostCpp + (getMarkupCost($childCost,$getTransferCost['markupCost'],$getTransferCost['markupType']));

//         $purchaseTransferEpp = $purchaseTransferEpp + $infantCost;
//         $transfermarkupCostEpp = $transfermarkupCostEpp + (getMarkupCost($infantCost,$getTransferCost['markupCost'],$getTransferCost['markupType']));

//     } 
// }
    } 
    $perPaxCost=$ADDPPCostA=$ADDPPCostC=$ADDPPCostE=0;
    $checcGroupRateQuery="";
    $checcGroupRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="2" and costTypeId="2"');
        if(mysqli_num_rows($checcGroupRateQuery) > 0){
            while($getGroupRateData=mysqli_fetch_array($checcGroupRateQuery)){
  
                  $currencyId = $getGroupRateData['currencyId'];
                  $currencyValue = $getGroupRateData['currencyValue'];

                  $adultPaxAD = $getGroupRateData['adultPax'];

                if($getGroupRateData['costTypeId']==2 && $getGroupRateData['groupCost']>0){
                    $adultPaxAD = $getGroupRateData['adultPax'];
                    $groupCost = convert_to_base($getGroupRateData['ROE'], $baseCurrencyVal,$getGroupRateData['groupCost']);
                    $adultCostGPP= $groupCost/$totalPax;
                }
                 
                // $adultCost = $adultCost+$adultCostGP;
             
                    // Adult Cost
                  $markupCostGA = getMarkupCost($adultCostGPP,$getGroupRateData['markupValue'],$getGroupRateData['markupType']);
                  $gstCostGA = getMarkupCost(($adultCostGPP+$markupCostGA),$getGroupRateData['serviceTax'],1);
                  $tcsCostGA = getMarkupCost(($adultCostGPP+$markupCostGA),$tcsTax,1);

                  $totalGroupCost = ($adultCostGPP+$markupCostGA+$gstCostGA+$tcsCostGA)*$totalPax;
                  $grandGroupCost = $grandGroupCost+$totalGroupCost;
                  }
                
                $ADDPPCostA = $grandGroupCost/$totalPax;
                $ADDPPCostC = $grandGroupCost/$totalPax;
                $ADDPPCostE = $grandGroupCost/$totalPax;
              } 


    $adultCost=$childCost=$infantCost=$adultCostPP=$childCostPP=$infantCostPP=0;
    $checkAdditionalRateQuery="";
    $checkAdditionalRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="2" and costTypeId="1"');
        if(mysqli_num_rows($checkAdditionalRateQuery) > 0){
            while($getAddiRateData=mysqli_fetch_array($checkAdditionalRateQuery)){
  
                  $currencyId = $getAddiRateData['currencyId'];
                  $currencyValue = $getAddiRateData['currencyValue'];

                  $adultPaxAD = $getAddiRateData['adultPax'];
                  $ChildPaxAD = $getAddiRateData['ChildPax'];
                  $infantPaxAD = $getAddiRateData['infantPax'];

                if($getAddiRateData['costTypeId']==1){
                    $adultCostPP = convert_to_base($getAddiRateData['ROE'], $baseCurrencyVal,$getAddiRateData['adultCost']);
                    $childCostPP = convert_to_base($getAddiRateData['ROE'], $baseCurrencyVal,$getAddiRateData['ChildCost']);
                    $infantCostPP = convert_to_base($getAddiRateData['ROE'], $baseCurrencyVal,$getAddiRateData['infantCost']);
                }
           
                // $adultCost = $adultCost+$adultCostPP;
                // $childCost = $childCost+$childCostPP;
                // $infantCost = $infantCost+$infantCostPP;
                    // Adult Cost
                  $markupCostA = getMarkupCost($adultCostPP,$getAddiRateData['markupValue'],$getAddiRateData['markupType']);
                  $gstCostA = getMarkupCost(($adultCostPP+$markupCostA),$getAddiRateData['serviceTax'],1);
                  $tcsCostA = getMarkupCost(($adultCostPP+$markupCostA),$tcsTax,1);

                  $totalAdultCost = ($adultCostPP+$markupCostA+$gstCostA+$tcsCostA)*$adultPaxAD;
                  $grandAdultCost = $grandAdultCost+$totalAdultCost;
                    // Child Cost
                  $markupCostC = getMarkupCost($childCostPP,$getAddiRateData['markupValue'],$getAddiRateData['markupType']);
                  $gstCostC = getMarkupCost(($childCostPP+$markupCostC),$getAddiRateData['serviceTax'],1);
                  $tcsCostC = getMarkupCost(($childCostPP+$markupCostC),$tcsTax,1);
                  $totalChildCost = ($childCostPP+$markupCostC+$gstCostC+$tcsCostC)*$ChildPaxAD;
                  $grandChildCost = $grandChildCost+$totalChildCost;
                     // Infant Cost
                    $markupCostE = getMarkupCost($infantCostPP,$getAddiRateData['markupValue'],$getAddiRateData['markupType']);
                    $gstCostE = getMarkupCost(($infantCostPP+$markupCostC),$getAddiRateData['serviceTax'],1);
                    $tcsCostE = getMarkupCost(($infantCostPP+$markupCostC),$tcsTax,1);

                    $totalInfantCost = ($infantCostPP+$markupCostE+$gstCostE+$tcsCostE)*$infantPaxAD;
                    $grandInfantCost = $grandInfantCost+$totalInfantCost;
                  }
                
                $ADDPPCostA = $ADDPPCostA+($grandAdultCost/$paxAdult);
                $ADDPPCostC = $ADDPPCostC+($grandChildCost/$paxChild);
                $ADDPPCostE = $ADDPPCostE+($grandInfantCost/$paxInfant);

              } 
              $singleBasisPR=$doubleBasisPR=0;
              $packageRateQuery="";
              $packageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="1"');
              if(mysqli_num_rows($packageRateQuery) > 0){
                  while($getPackageData=mysqli_fetch_array($packageRateQuery)){
            
                  $currencyId = $getPackageData['currencyId'];
                  $currencyValue = $getPackageData['ROE'];
                   
                  $singleBasisPR = $singleBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['singleBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));
                  $doubleBasisPR = $doubleBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['doubleBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));
                  $twinBasisPR = $twinBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['twinBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $tripleBasisPR = $tripleBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['tripleBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $quadBasisPR = $quadBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['quadBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $sixBedBasisPR = $sixBedBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['sixBedBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $eightBedBasisPR = $eightBedBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['eightBedBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $tenBedBasisPR = $tenBedBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['tenBedBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $extraBedABasisPR = $extraBedABasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['extraBedABasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $childwithbedBasisPR = $childwithbedBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['childwithbedBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $childwithoutbedBasisPR = $childwithoutbedBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['childwithoutbedBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $infantBedBasisPR = $infantBedBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['infantBedBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  $teenBedBasisPR = $teenBedBasisPR+(getCostWithGSTID_Markup(convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['teenBedBasis']),$getPackageData['gstTax'],$getPackageData['markupValue'],$getPackageData['markupType'],'0','0',$tcsTax));

                  }
              } 
      
    ?>
<?php } 
$rowspan=0;
if($singleRoom>0){
    $rowspan =  $rowspan+1;
} if($doubleRoom>0){
    $rowspan = $rowspan+1;
} //  if($twinRoom>0){
//     echo $rowspan = $rowspan+1;
//}
 if($tripleRoom>0){
    $rowspan = $rowspan+1;
} if($sixBedRoom>0){
    $rowspan = $rowspan+1;
} if($eightBedRoom>0){
    $rowspan = $rowspan+1;
} if($tenBedRoom>0){
    $rowspan = $rowspan+1;
}  if($teenBedRoom>0){
    $rowspan = $rowspan+1;
}  if($EBedChild>0){
    $rowspan = $rowspan+1;
}  if($NBedChild>0){
    $rowspan = $rowspan+1;
}  if($EBedAdult>0){
    $rowspan = $rowspan+1;
}  if($quadNoofBed>0){
    $rowspan = $rowspan+1;
} if($infantNoofBed>0){
    $rowspan = $rowspan+1;
}  if($resultpageQuotation['flightRequired']==2 && $paxAdult>0){
    $rowspan = $rowspan+1;
}  if($resultpageQuotation['flightRequired']==2 && $paxChild>0){
    $rowspan = $rowspan+1;
}  if($resultpageQuotation['flightRequired']==2 && $paxInfant>0){
    $rowspan = $rowspan+1;
} if($resultpageQuotation['transferRequired']==2 && $paxAdult>0 && $sicrecord){
    $rowspan = $rowspan+1;
}  if($resultpageQuotation['transferRequired']==2 && $paxChild>0 && $sicrecord){
    $rowspan = $rowspan+1;
}  if($resultpageQuotation['transferRequired']==2 && $paxInfant>0 && $sicrecord){
    $rowspan = $rowspan+1;
}


    if($resultpageQuotation['quotationType']==2 || $resultpageQuotation['quotationType']==3){
        ?>
<div>
    <h2>General Infomation</h2>
<table width="80%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;border-collapse: collapse;margin:10px auto 20px auto;text-align:center;">
        <tr>
            <td align="center" bgcolor="#ddd" ><strong>Adult&nbsp;Pax</strong></td>

            <td align="center" bgcolor="#ddd" ><strong>Child&nbsp;Pax</strong></td>
        <?php if( $paxInfant >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Infant&nbsp;Pax</strong></td>
        <?php } if( $singleRoom >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Single&nbsp;Room</strong></td>
        <?php } if( $doubleRoom >0){ ?>
       
            <td align="center" bgcolor="#ddd" ><strong>Double&nbsp;Room</strong></td>
        <?php } if( $tripleRoom >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Triple&nbsp;Room</strong></td>
        <?php } if( $twinRoom >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Twin&nbsp;Room</strong></td>
        <?php } if( $EBedAdult >0){ ?>
 
            <td align="center" bgcolor="#ddd" ><strong>Extra-Bed(A)</strong></td>    
      
        <?php }  if( $quadNoofBed >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Quad&nbsp;Room</strong></td>
        <?php } if( $EBedChild >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>ChildWBed</strong></td>
        <?php } if( $NBedChild >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>ChildNBed</strong></td>      
        <?php } if( $infantNoofBed >0){ ?>
             <td align="center" bgcolor="#ddd" ><strong>Infant&nbsp;Bed</strong></td>
        <?php } if( $teenNoofBed >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Teen&nbsp;Room</strong></td>
        <?php } if( $sixNoofBed >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Six&nbsp;Bed&nbsp;Room</strong></td>
        <?php } if( $eightNoofBed >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Eight&nbsp;Bed&nbsp;Room</strong></td>
        <?php } if( $tenNoofBed >0){ ?>
            <td align="center" bgcolor="#ddd" ><strong>Ten&nbsp;Bed&nbsp;Room</strong></td>
        <?php } ?>
        </tr>

        <tr>
            <td align="center" ><?php echo $paxAdult; ?></td> 
            <td align="center" ><?php echo $paxChild; ?></td> 
        <?php if( $paxInfant >0){ ?>
            <td align="center" ><?php echo $paxInfant; ?></td> 
        <?php } if( $singleRoom >0){ ?>
            <td align="center" ><?php echo $singleRoom; ?></td> 
        <?php } if( $doubleRoom >0){ ?>
            <td align="center" ><?php echo $doubleRoom; ?></td> 
        <?php } if( $tripleRoom >0){ ?>
            <td align="center" ><?php echo $tripleRoom; ?></td> 
        <?php } if( $twinRoom >0){ ?>
            <td align="center" ><?php echo $twinRoom; ?></td> 
        <?php } if( $EBedAdult >0){ ?>
            <td align="center" ><?php echo $EBedAdult; ?></td> 
        <?php }  if( $quadNoofBed >0){ ?>
            <td align="center" ><?php echo $quadNoofBed; ?></td> 
        <?php } if( $EBedChild >0){ ?>
            <td align="center" ><?php echo $EBedChild; ?></td> 
        <?php } if( $NBedChild >0){ ?>
            <td align="center" ><?php echo $NBedChild; ?></td> 
        <?php } if( $infantNoofBed >0){ ?>
            <td align="center" ><?php echo $infantNoofBed; ?></td> 
        <?php } if( $teenNoofBed >0){ ?>
            <td align="center" ><?php echo $teenNoofBed; ?></td> 
        <?php } if( $sixNoofBed >0){ ?>
            <td align="center" ><?php echo $sixNoofBed; ?></td> 
        <?php } if( $eightNoofBed >0){ ?>
            <td align="center" ><?php echo $eightNoofBed; ?></td> 
        <?php } if( $tenNoofBed >0){ ?>
            <td align="center" ><?php echo $tenNoofBed; ?></td> 
        <?php } ?>
        </tr>
    </table>

    </div>

        <?php
    }
?>

<table width="100%" cellpadding="0" cellspacing="0" style="padding-top:10px; margin-top:10px; border-top:1px solid #ccc;border-collapse: collapse;">
<tr>
    <td width="auto" valign="top">
        <!-- start Total tour cost -->
        <div style="text-align:center;font-size: 18px;margin: 0;padding:10px;"><strong><?php if($resultpageQuotation['quotationType']==1){ echo 'Land Arrangement'; }else{ echo 'Total Tour Cost'; } ?></strong></div>
        <?php 
        $hotelCategoryArr=0;
        $hotelCategoryId = '';

        if($resultpageQuotation['quotationType']==2){
            $hotelCategoryArr = explode(',',$resultpageQuotation['hotCategory']);
        }elseif($resultpageQuotation['quotationType']==3){
            $hotelCategoryArr = explode(',',$resultpageQuotation['hotelType']);
        }elseif($resultpageQuotation['quotationType']==1){
            // For single hotel category
            $hotelCategoryArr = explode(',',0);
        }else{
           
              // FOR Loop on multiple proposal costsheet
            if($resultpageQuotation['quotationType']==3){
                $hotelCategoryArr = explode(',',$resultpageQuotation['hotelType']);
            }else{
                $hotelCategoryArr = explode(',',$resultpageQuotation['hotCategory']);
            }
        }
   
     foreach($hotelCategoryArr as $val){
                
                if($resultpageQuotation['quotationType']==2){
                    $hotelTypeId = '';
                    $hotelCategoryId = 'and hotelCategoryId="'.$val.'"';

                    $HQuery = GetPageRecord('id,hotelCategory',_HOTEL_CATEGORY_MASTER_,' 1 and deletestatus=0 and status=1 and id="'.$val.'" order by hotelCategory asc');
					$hotelCategoryData = mysqli_fetch_array($HQuery);
                    $CategoryName = $hotelCategoryData['hotelCategory'].' Star';
                }

                if($resultpageQuotation['quotationType']==3){
                    $hotelCategoryId = '';
                    $hotelTypeId = 'and hotelTypeId="'.$val.'"';
                    $HQuery = GetPageRecord('id,name','hotelTypeMaster',' 1 and deletestatus=0 and status=1 and id="'.$val.'" order by name asc');
					$hotelTypeData = mysqli_fetch_array($HQuery);
                    $CategoryName = $hotelTypeData['name'];
                }
                
            $singleBasis=$doubleBasis=$twinBasis=$tripleBasis=$quadBasis=$sixBedBasis=$eightBedBasis=$tenBedBasis=$extraBedABasis=$childwithbedBasis=$childwithoutbedBasis=$infantBedBasis=$teenBedBasis=$servicePurchase=$serviceMarkup=$totalServiceSale=0;

            ${'ppCostONSingleBasis'.$val}=${'ppCostONDoubleBasis'.$val}=${'ppCostOnTripleBasis'.$val}=${'ppCostOnQuadBasis'.$val}=${'ppCostOnExtraBedABasis'.$val}=${'pcCostOnExtraBedCBasis'.$val}=${'pcCostOnExtraNBedCBasis'.$val}=${'peCostBasis'.$val}=0;
            ${"proposalCost".$val} =0;
            $checkPackageRateQuery="";
            $checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" '.$hotelCategoryId.' '.$hotelTypeId.' ');
            if(mysqli_num_rows($checkPackageRateQuery) > 0){
                $getPackageRateData=mysqli_fetch_array($checkPackageRateQuery); 
                $editId = $getPackageRateData['id'];

                $currencyId = $getPackageRateData['currencyId'];
                $currencyValue = $getPackageRateData['currencyValue'];
                $supplierId = $getPackageRateData['supplierId'];

                $singleBasis = clean($getPackageRateData['singleBasis']);
                $doubleBasis = clean($getPackageRateData['doubleBasis']);
                $twinBasis = clean($getPackageRateData['twinBasis']);
                $tripleBasis = clean($getPackageRateData['tripleBasis']); 
                $quadBasis = clean($getPackageRateData['quadBasis']);
                $sixBedBasis = clean($getPackageRateData['sixBedBasis']);
                $eightBedBasis = clean($getPackageRateData['eightBedBasis']);
                $tenBedBasis = clean($getPackageRateData['tenBedBasis']);
                $extraBedABasis = clean($getPackageRateData['extraBedABasis']);
                $childwithbedBasis = clean($getPackageRateData['childwithbedBasis']);
                $childwithoutbedBasis = clean($getPackageRateData['childwithoutbedBasis']);
                $infantBedBasis = clean($getPackageRateData['infantBedBasis']);
                $teenBedBasis = clean($getPackageRateData['teenBedBasis']);
            } 
        $grandSingle=$grandDouble=$grandTwin=$grandTriple=$grandAWB=$grandChildWB=$grandChildNB=$serviceTaxCost=$serviceTCSCost=0; 
        $singleBasisPurchase=$totalSingleBasisMarkup=$totalSingleBasisSale=$grandFinaleCost=$hotelservicePurchase=$hotelserviceMarkup=0; 
        $hotelServiceSale=$grandPPCost=$serviceTaxCost=0;
        
        if($resultpageQuotation['quotationType']==3 || $resultpageQuotation['quotationType']==2){
            
        ?>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;border-collapse: collapse;margin-bottom:30px;">
            <tr>
            <td align="left" bgcolor="#ddd"></td>
            <td align="left" bgcolor="#ddd"></td>
            <td align="center" bgcolor="#ddd" colspan="7"><strong>Purchase Cost and Markup Cost</strong></td>
            <td align="center" colspan="2" bgcolor="#ddd"><strong>Tax and TCS</strong></td>                      
            <td align="center" bgcolor="#ddd" colspan="3"><strong>PP and Total Cost</strong></td>
            </tr>
            <tr>
           
            <td align="left" bgcolor="#ddd"><strong>Hotel Category</strong></td>

            <td align="left" bgcolor="#ddd"><strong>Occupancy&nbsp;Type</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Purchase&nbsp;Cost</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Pax</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Purchase&nbsp;Cost</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Markup&nbsp;Cost(PP)</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Markup</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Sale&nbsp;Cost(PP)</strong></td>
            <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Sale&nbsp;Cost</strong></td>
         
            <td align="right" bgcolor="#ddd"><strong>Tax</strong></td>
            <td align="right" bgcolor="#ddd"><strong>TCS</strong></td>

            <td align="right" bgcolor="#ddd"><strong>PP&nbsp;Cost</strong></td>
            
            <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Tour&nbsp;Cost</strong></td>
            <!-- <td align="right" bgcolor="#ddd"><strong>Sale&nbsp;Cost</strong></td> -->
            </tr>

            <?php 
            if($singleRoom >0){ 
                $singleBasisMarkup = getMarkupCost($singleBasis, $package, $packageMarkupType);
                $singleBasisSale = $singleBasis+$singleBasisMarkup;
                $totalSingleBasis = ($singleBasis*$singleRoom);
                $totalSingleBasisMarkup = $singleBasisMarkup*$singleRoom;
                $totalSignleSale = $singleBasisSale*$singleRoom;

                $singleBasisTax = getMarkupCost($singleBasisSale, $serviceTax, 1);
                $singleBasisTcs = getMarkupCost($singleBasisSale, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalSingleBasis;
                $serviceMarkup = $serviceMarkup+$totalSingleBasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalSignleSale;

                $singlePPCost=($singleBasisSale+$singleBasisTax+$singleBasisTcs);
                $singleFinalCost = ($singlePPCost*$singleRoom);
                $grandFinaleCost = $grandFinaleCost+$singleFinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($singleBasisTax*$singleRoom);
                $serviceTCSCost = $serviceTCSCost+($singleBasisTcs*$singleRoom);
                ?>
                <tr>
             
                <td rowspan="<?php echo $rowspan; ?>"><strong><?php echo $CategoryName; ?></strong></td>
           
                <td align="left" bgcolor="#deb887"><strong>Single&nbsp;Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($singleRoom); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSingleBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleBasisMarkup); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSingleBasisMarkup); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleBasisSale); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSignleSale); ?></td>
         
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleBasisTax*$singleRoom); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleBasisTcs*$singleRoom); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singlePPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleFinalCost); ?></td>
               
                </tr>
                <?php 
            }

            if($doubleRoom >0){ 
                $doubleBasisMarkup = getMarkupCost($doubleBasis, $package, $packageMarkupType);
                $doubleBasisSale = $doubleBasis+$doubleBasisMarkup;
                $totaldoubleBasis = $doubleBasis*$doubleRoom*2;
                $totaldoubleBasisMarkup = $doubleBasisMarkup*$doubleRoom*2;
                $totalDoubleSale = $doubleBasisSale*$doubleRoom*2;

                $doubleBasisTax = getMarkupCost($doubleBasisSale, $serviceTax, 1);
                $doubleBasisTcs = getMarkupCost($doubleBasisSale, $serviceTcs, 1);

                $servicePurchase =  $servicePurchase+$totaldoubleBasis;
                $serviceMarkup = $serviceMarkup+$totaldoubleBasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalDoubleSale;
                
                $doublePPCost=($doubleBasisSale+$doubleBasisTax+$doubleBasisTcs);
                $doublefinalCost = ($doublePPCost*$doubleRoom*2);
                $grandFinaleCost = $grandFinaleCost+$doublefinalCost;
               
                $serviceTaxCost = $serviceTaxCost+($doubleBasisTax*$doubleRoom*2);
                $serviceTCSCost = $serviceTCSCost+($doubleBasisTcs*$doubleRoom*2);
                ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Double&nbsp;Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doubleBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($doubleRoom*2); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaldoubleBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doubleBasisMarkup); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaldoubleBasisMarkup); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doubleBasisSale); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalDoubleSale); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doubleBasisTax*$doubleRoom*2); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doubleBasisTcs*$doubleRoom*2); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doublePPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doublefinalCost); ?></td>
                </tr>
                <?php 
            }

            if($tripleRoom >0){ 
                $tripleBasisMarkup = getMarkupCost($tripleBasis, $package, $packageMarkupType);
                $tripleBasisSale = $tripleBasis+$tripleBasisMarkup;
                $totaltripleBasis = $tripleBasis*$tripleRoom*3;
                $totaltripleBasisMarkup = $tripleBasisMarkup*$tripleRoom*3;
                $totalTripleSale = $tripleBasisSale*$tripleRoom*3;
                
                $tripleBasisTax = getMarkupCost($tripleBasisSale, $serviceTax, 1);
                $tripleBasisTcs = getMarkupCost($tripleBasisSale, $serviceTcs, 1);

                $servicePurchase =  $servicePurchase+$totaltripleBasis;
                $serviceMarkup = $serviceMarkup+$totaltripleBasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalTripleSale;
                
                $triplePPCost=($tripleBasisSale+$tripleBasisTax+$tripleBasisTcs);
                $triplefinalCost = ($triplePPCost*$tripleRoom*3);
                $grandFinaleCost = $grandFinaleCost+$triplefinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($tripleBasisTax*$tripleRoom*3);
                $serviceTCSCost = $serviceTCSCost+($tripleBasisTcs*$tripleRoom*3);

                ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Triple&nbsp;Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($tripleBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($tripleRoom*3); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltripleBasis); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($tripleBasisMarkup); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaltripleBasisMarkup); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($tripleBasisSale); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTripleSale); ?></td>
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(($tripleBasisTax*$tripleRoom*3)); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(($tripleBasisTcs*$tripleRoom*3)); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($triplePPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($triplefinalCost); ?></td>
                </tr>
                <?php 
            }
 
            if($quadNoofBed >0){ 
                $quadBasisMarkup = getMarkupCost($quadBasis, $package, $packageMarkupType);
                $quadBasisSale = $quadBasis+$quadBasisMarkup;
                $totalquadBasis = $quadBasis*$quadNoofBed*4;
                $totalquadBasisMarkup = $quadBasisMarkup*$quadNoofBed*4;
                $totalquadSale = $quadBasisSale*$tripleRoom*4;
                
                $quadBasisTax = getMarkupCost($quadBasisSale, $serviceTax, 1);
                $quadBasisTcs = getMarkupCost($quadBasisSale, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalquadBasis;
                $serviceMarkup = $serviceMarkup+$totalquadBasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalquadSale;

                $quadPPCost=($quadBasisSale+$quadBasisTax+$quadBasisTcs);
                $quadfinalCost = ($quadPPCost*$quadNoofBed*4);
                $grandFinaleCost = $grandFinaleCost+$quadfinalCost;
                
                $grandPPCost = $grandPPCost+$quadPPCost;
                $serviceTaxCost = $serviceTaxCost+($quadBasisTax*$quadNoofBed*4);
                $serviceTCSCost = $serviceTCSCost+($quadBasisTcs*$quadNoofBed*4);
                ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Quad&nbsp;Bed Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($quadNoofBed*4); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalquadBasis); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadBasisMarkup); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalquadBasisMarkup); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadBasisSale); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalquadSale); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadBasisTax*$quadNoofBed*4); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadBasisTcs*$quadNoofBed*4); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadPPCost); ?></td>
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadfinalCost); ?></td>
                </tr>
                <?php 
            } 

            if($EBedAdult >0){ 
                $extraBedABasisMarkup = getMarkupCost($extraBedABasis, $package, $packageMarkupType);
                $extraBedABasisSale = $extraBedABasis+$extraBedABasisMarkup;
                $totalextraBedABasis = $extraBedABasis*$EBedAdult;
                $totalextraBedABasisMarkup = $extraBedABasisMarkup*$EBedAdult;
                $totalextraBedASale = $extraBedABasisSale*$EBedAdult;
               
                $extraBedABasisTax = getMarkupCost($extraBedABasisSale, $serviceTax, 1);
                $extraBedABasisTcs = getMarkupCost($extraBedABasisSale, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalextraBedABasis;
                $serviceMarkup = $serviceMarkup+$totalextraBedABasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalextraBedASale;

                $extraBAPPCost=($extraBedABasisSale+$extraBedABasisTax+$extraBedABasisTcs);
                $extraBAfinalCost = ($extraBAPPCost*$EBedAdult);
                $grandFinaleCost = $grandFinaleCost+$extraBAfinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($extraBedABasisTax*$EBedAdult);
                $serviceTCSCost = $serviceTCSCost+($extraBedABasisTcs*$EBedAdult);
                ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Extra&nbsp;Bed Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBedABasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($EBedAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraBedABasis); ?></td>

            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBedABasisMarkup); ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraBedABasisMarkup); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBedABasisSale); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraBedASale); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBedABasisTax*$EBedAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBedABasisTcs*$EBedAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBAPPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBAfinalCost); ?></td>
                </tr>
                <?php 
            } 
            if($EBedChild >0){ 
                $childwithbedBasisMarkup = getMarkupCost($childwithbedBasis, $package, $packageMarkupType);
                $childwithbedBasisSale = $childwithbedBasis+$childwithbedBasisMarkup;
                $totalchildwithbedBasis = $childwithbedBasis*$EBedChild;
                $totalchildwithbedBasisMarkup =  $childwithbedBasisMarkup*$EBedChild;
                $totalextraBedCSale =  $childwithbedBasisSale*$EBedChild;
                
                $extraCWBasisTax = getMarkupCost($childwithbedBasisSale, $serviceTax, 1);
                $extraCWBasisTcs = getMarkupCost($childwithbedBasisSale, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalchildwithbedBasis;
                $serviceMarkup = $serviceMarkup+$totalchildwithbedBasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalextraBedCSale;

                $extraCWPPCost=($childwithbedBasisSale+$extraCWBasisTax+$extraCWBasisTcs);
                $extraCWfinalCost = ($extraCWPPCost*$EBedChild);
                $grandFinaleCost = $grandFinaleCost+$extraCWfinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($extraCWBasisTax*$EBedChild);
                $serviceTCSCost = $serviceTCSCost+($extraCWBasisTcs*$EBedChild);
                ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Child-With&nbsp;Bed&nbsp;Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithbedBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($EBedChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalchildwithbedBasis); ?></td>

            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithbedBasisMarkup); ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalchildwithbedBasisMarkup); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithbedBasisSale); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraBedCSale); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCWBasisTax*$EBedChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCWBasisTcs*$EBedChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCWPPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCWfinalCost); ?></td>
                </tr>
                <?php 
            } 

            if($NBedChild >0){ 
                $childwithoutbedBasisMarkup = getMarkupCost($childwithoutbedBasis, $package, $packageMarkupType);
                $childwithoutbedBasisSale = $childwithoutbedBasis+$childwithoutbedBasisMarkup;
                $totalchildwithoutbedBasis = $childwithoutbedBasis*$NBedChild;
                $totalchildwithoutbedBasisMarkup = $childwithoutbedBasisMarkup*$NBedChild;
                $totalextraBedCNSale = $childwithoutbedBasisSale*$NBedChild;

                $extraCNBasisTax = getMarkupCost($childwithoutbedBasisSale, $serviceTax, 1);
                $extraCNBasisTcs = getMarkupCost($childwithoutbedBasisSale, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalchildwithoutbedBasis;
                $serviceMarkup = $serviceMarkup+$totalchildwithoutbedBasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalextraBedCNSale;

                $extraCNPPCost=($childwithoutbedBasisSale+$extraCNBasisTax+$extraCNBasisTcs);
                $extraCNfinalCost = ($extraCNPPCost*$NBedChild);
                $grandFinaleCost = $grandFinaleCost+$extraCNfinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($extraCNBasisTax*$NBedChild);
                $serviceTCSCost = $serviceTCSCost+($extraCNBasisTcs*$NBedChild);
                ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Child-No&nbsp;Bed&nbsp;Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithoutbedBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($NBedChild); ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalchildwithoutbedBasis); ?></td>

            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithoutbedBasisMarkup); ?></td>
        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalchildwithoutbedBasisMarkup); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithoutbedBasisSale); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraBedCNSale); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCNBasisTax*$NBedChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCNBasisTcs*$NBedChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCNPPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraCNfinalCost); ?></td>
                </tr>
                <?php 
            }  

            if($infantNoofBed >0){
                $infantBedBasisMarkup = getMarkupCost($infantBedBasis, $package, $packageMarkupType);
                $infantBedBasisSale = $infantBedBasis+$infantBedBasisMarkup;
                $totalinfantBedBasis = $infantBedBasis*$infantNoofBed;
                $totalinfantBedBasisMarkup = $infantBedBasisMarkup*$infantNoofBed;
                $totalInfantSale = $infantBedBasisSale*$infantNoofBed;
                
                $infantBasisTax = getMarkupCost($infantBedBasisSale, $serviceTax, 1);
                $infantBasisTcs = getMarkupCost($infantBedBasisSale, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalinfantBedBasis;
                $serviceMarkup = $serviceMarkup+$totalinfantBedBasisMarkup;
                $totalServiceSale = $totalServiceSale+$totalInfantSale;

                $infantPPCost=($infantBedBasisSale+$infantBasisTax+$infantBasisTcs);
                $infantfinalCost = ($infantPPCost*$infantNoofBed);
                $grandFinaleCost = $grandFinaleCost+$infantfinalCost;
                
                $grandPPCost = $grandPPCost+$infantPPCost;
                $serviceTaxCost = $serviceTaxCost+($infantBasisTax*$infantNoofBed);
                $serviceTCSCost = $serviceTCSCost+($infantBasisTcs*$infantNoofBed);
                ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Infant&nbsp;Bed&nbsp;Basis</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantBedBasis); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($infantNoofBed); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalinfantBedBasis); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantBedBasisMarkup); ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalinfantBedBasisMarkup); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantBedBasisSale); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalInfantSale); ?></td>


                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantBasisTax*$infantNoofBed); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantBasisTcs*$infantNoofBed); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantPPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantfinalCost); ?></td>
                </tr>
                <?php 
            }

            //  && $allAdultPaxF>0 
            if($resultpageQuotation['flightRequired']==2){
                
                $totalpurchaseFlightA = $purchaseFlightApp*$paxAdult;
                $totalFlightMarkupA = $flightMarkupCostApp*$paxAdult;
                $saleFlightApp = $purchaseFlightApp+$flightMarkupCostApp;
                $totalFlightSaleA = $saleFlightApp*$paxAdult;

                $flightABasisTax = getMarkupCost($saleFlightApp, $serviceTax, 1);
                $flightABasisTcs = getMarkupCost($saleFlightApp, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalpurchaseFlightA;
                $serviceMarkup = $serviceMarkup+$totalFlightMarkupA;
                $totalServiceSale = $totalServiceSale+$totalFlightSaleA;

                $flightAPPCost=($saleFlightApp+$flightABasisTax+$flightABasisTcs);
                $flightAfinalCost = ($flightAPPCost*$paxAdult);
                $grandFinaleCost = $grandFinaleCost+$flightAfinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($flightABasisTax*$paxAdult);
                $serviceTCSCost = $serviceTCSCost+($flightABasisTcs*$paxAdult);

                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Flight Services(Adult)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseFlightA); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightMarkupCostApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalFlightMarkupA); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalFlightSaleA); ?></td>
             
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightABasisTax*$paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightABasisTcs*$paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightAPPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightAfinalCost); ?></td>
                </tr>
                <?php 
            }
            //  && $allChildPaxF>0 
            if($resultpageQuotation['flightRequired']==2 && $paxChild>0){
                
                $saleFlightCpp = $purchaseFlightCpp+$flightMarkupCostCpp;
                $totalpurchaseFlightC=$purchaseFlightCpp*$paxChild;
                $totalFlightMarkupC = $flightMarkupCostCpp*$paxChild;
                $totalFlightSaleC = $saleFlightCpp*$paxChild;

                $flightCBasisTax = getMarkupCost($saleFlightCpp, $serviceTax, 1);
                $flightCBasisTcs = getMarkupCost($saleFlightCpp, $serviceTcs, 1);

                $servicePurchase =  $servicePurchase+$totalpurchaseFlightC;
                $serviceMarkup = $serviceMarkup+$totalFlightMarkupC;
                $totalServiceSale = $totalServiceSale+$totalFlightSaleC;

                $flightCPPCost=($saleFlightCpp+$flightCBasisTax+$flightCBasisTcs);
                $flightCfinalCost = ($flightCPPCost*$paxChild);
                $grandFinaleCost = $grandFinaleCost+$flightCfinalCost;
         
                $serviceTaxCost = $serviceTaxCost+($flightCBasisTax*$paxChild);
                $serviceTCSCost = $serviceTCSCost+($flightCBasisTcs*$paxChild);
                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Flight Services(Child)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightCpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseFlightC); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightMarkupCostCpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalFlightMarkupC); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightCpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalFlightSaleC); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightCBasisTax*$paxChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightCBasisTcs*$paxChild); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightCPPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightCfinalCost); ?></td>
                </tr>
                <?php 
            }
            //  && $allInfantPaxF>0 
            if($resultpageQuotation['flightRequired']==2 && $paxInfant>0){
      
                $saleFlightEpp = $purchaseFlightEpp+$flightMarkupCostEpp;
                $totalpurchaseFlightE = $purchaseFlightEpp*$paxInfant;
                $totalFlightMarkupE = $flightMarkupCostEpp*$paxInfant;
                $totalFlightSaleE = $saleFlightEpp*$paxInfant;

                $flightEBasisTax = getMarkupCost($saleFlightEpp, $serviceTax, 1);
                $flightEBasisTcs = getMarkupCost($saleFlightEpp, $serviceTcs, 1);
               
                $servicePurchase =  $servicePurchase+$totalpurchaseFlightE;
                $serviceMarkup = $serviceMarkup+$totalFlightMarkupE;
                $totalServiceSale = $totalServiceSale+$totalFlightSaleE;

                $flightEPPCost=($saleFlightEpp+$flightEBasisTax+$flightEBasisTcs);
                $flightEfinalCost = ($flightEPPCost*$paxInfant);
                $grandFinaleCost = $grandFinaleCost+$flightEfinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($flightEBasisTax*$paxInfant);
                $serviceTCSCost = $serviceTCSCost+($flightEBasisTcs*$paxInfant);
                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Flight Services(Infant)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseFlightE); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightMarkupCostEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalFlightMarkupE); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalFlightSaleE); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightEBasisTax*$paxInfant); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightEBasisTcs*$paxInfant); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightEPPCost); ?></td>
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightEfinalCost); ?></td>
                </tr>
                <?php 
            }
        
            //  && $allAdultPaxF>0 
            if($resultpageQuotation['transferRequired']==2 && $sicrecord>0){
                
                
                $saleTransferApp = $purchaseTransferApp+$transfermarkupCostApp;
                $totalpurchaseTransferA = $purchaseTransferApp*$paxAdult;
                $totalTransferMarkupA = $transfermarkupCostApp*$paxAdult;
                $totalTransferSaleA = $saleTransferApp*$paxAdult;

                $transferABasisTax = getMarkupCost($saleTransferApp, $serviceTax, 1);
                $transferABasisTcs = getMarkupCost($saleTransferApp, $serviceTcs, 1);
                
                $servicePurchase =  $servicePurchase+$totalpurchaseTransferA;
                $serviceMarkup = $serviceMarkup+$totalTransferMarkupA;
                $totalServiceSale = $totalServiceSale+$totalTransferSaleA;

                $transferAPPCost=($saleTransferApp+$transferABasisTax+$transferABasisTcs);
                $transferAfinalCost = ($transferAPPCost*$paxAdult);
                $grandFinaleCost = $grandFinaleCost+$transferAfinalCost;
                
                $serviceTaxCost = $serviceTaxCost+($transferABasisTax*$paxAdult);
                $serviceTCSCost = $serviceTCSCost+($transferABasisTcs*$paxAdult);

                ?>    
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Transfer Services(Adult)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseTransferA); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transfermarkupCostApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTransferMarkupA); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferApp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTransferSaleA); ?></td>

                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferABasisTax*$paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferABasisTcs*$paxAdult); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferAPPCost); ?></td>
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferAfinalCost); ?></td>
                </tr>
                <?php 
            }

               //  child
               if($resultpageQuotation['transferRequired']==2 && $paxChild>0 && $sicrecord>0){
                   
                   
                   $saleTransferCpp = $purchaseTransferCpp+$transfermarkupCostCpp;
                   $totalpurchaseTransferC = $purchaseTransferCpp*$paxChild;
                   $totalTransferMarkupC = $transfermarkupCostCpp*$paxChild;
                   $totalTransferSaleC = $saleTransferCpp*$paxChild;

                   $transferCBasisTax = getMarkupCost($saleTransferCpp, $serviceTax, 1);
                   $transferCBasisTcs = getMarkupCost($saleTransferCpp, $serviceTcs, 1);
                   
                   
                   $servicePurchase =  $servicePurchase+$totalpurchaseTransferC;
                   $serviceMarkup = $serviceMarkup+$totalTransferMarkupC;
                   $totalServiceSale = $totalServiceSale+$totalTransferSaleC;

                   $transferCPPCost=($saleTransferCpp+$transferCBasisTax+$transferCBasisTcs);
                   $transferCfinalCost = ($transferCPPCost*$paxChild);
                   $grandFinaleCost = $grandFinaleCost+$transferCfinalCost;
                   
                   $serviceTaxCost = $serviceTaxCost+($transferCBasisTax*$paxChild);
                   $serviceTCSCost = $serviceTCSCost+($transferCBasisTcs*$paxChild);
   
                   ?>    
                   <tr>
                   <td align="left" bgcolor="#deb887"><strong>Transfer Services(Child)</strong></td>
                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferCpp); ?></td>
                   <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseTransferC); ?></td>

                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transfermarkupCostCpp); ?></td>
                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTransferMarkupC); ?></td>

                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferCpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTransferSaleC); ?></td>

                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCBasisTax*$paxChild); ?></td>
                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCBasisTcs*$paxChild); ?></td>
                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCPPCost); ?></td>
                   
                   <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferCfinalCost); ?></td>
                   </tr>
                   <?php 
               }

                 // Infant
                 if($resultpageQuotation['transferRequired']==2 && $paxInfant>0 && $sicrecord>0){
                   
                   
                    $saleTransferEpp = $purchaseTransferEpp+$transfermarkupCostEpp;
                    $totalpurchaseTransferE = $purchaseTransferEpp*$paxInfant;
                    $totalTransferMarkupE = $transfermarkupCostEpp*$paxInfant;
                    $totalTransferSaleE = $saleTransferEpp*$paxInfant;

                    $transferEBasisTax = getMarkupCost($saleTransferEpp, $serviceTax, 1);
                    $transferEBasisTcs = getMarkupCost($saleTransferEpp, $serviceTcs, 1);
                    
                    
                   $servicePurchase =  $servicePurchase+$totalpurchaseTransferE;
                   $serviceMarkup = $serviceMarkup+$totalTransferMarkupE;
                   $totalServiceSale = $totalServiceSale+$totalTransferSaleE;

                    $transferEPPCost=($saleTransferEpp+$transferEBasisTax+$transferEBasisTcs);
                    $transferEfinalCost = ($transferEPPCost*$paxInfant);
                    $grandFinaleCost = $grandFinaleCost+$transferEfinalCost;
                    
                    $serviceTaxCost = $serviceTaxCost+($transferEBasisTax*$paxInfant);
                    $serviceTCSCost = $serviceTCSCost+($transferEBasisTcs*$paxInfant);
    
                    ?>    
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Transfer Services(Infant)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseTransferEpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpurchaseTransferE); ?></td>

                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transfermarkupCostEpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTransferMarkupE); ?></td>

                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleTransferEpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTransferSaleE); ?></td>
    
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferEBasisTax*$paxInfant); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferEBasisTcs*$paxInfant); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferEPPCost); ?></td>
                    
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($transferEfinalCost); ?></td>
                    </tr>
                    <?php 
                }
               
            ?>
            <tr>
                <td align="right" colspan="3" bgcolor="#ddd"><strong>Total Cost</strong></td>
                <td align="right" colspan="2" bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($servicePurchase); ?></strong></td>
                <td align="right" colspan="2" bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($serviceMarkup); ?></strong></td>
                <td align="right" colspan="2" bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($totalServiceSale); ?></strong></td>
                
                <td align="right" bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($serviceTaxCost); ?></strong></td>
                <td align="right" bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($serviceTCSCost); ?></strong></td>
                <td align="right" bgcolor="#ddd"><strong><?php //echo getTwoDecimalNumberFormat($grandPPCost); ?></strong></td>
                <td align="right" bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($grandFinaleCost); ?></strong></td>
                </tr>
            <tr>
           
            <?php 
            
                ${'ppCostONSingleBasis'.$val} = $singlePPCost+$flightAPPCost+$transferAPPCost;
                ${'ppCostONDoubleBasis'.$val} = $doublePPCost+$flightAPPCost+$transferAPPCost;
                ${'ppCostOnTripleBasis'.$val} = $triplePPCost+$flightAPPCost+$transferAPPCost;
                ${'ppCostOnQuadBasis'.$val} = $quadPPCost+$flightAPPCost+$transferAPPCost;
                ${'ppCostOnExtraBedABasis'.$val} = $extraBAPPCost+$flightAPPCost+$transferAPPCost;
                ${'pcCostOnExtraBedCBasis'.$val} = $extraCWPPCost+$flightCPPCost+$transferCPPCost;
                ${'pcCostOnExtraNBedCBasis'.$val} = $extraCNPPCost+$flightCPPCost+$transferCPPCost;
                ${'peCostBasis'.$val} = $infantPPCost+$flightEPPCost+$transferEPPCost;

                $grandMarkupCost = $grandTotalMarkupCost = $serviceMarkup;

                $totalCompanyCost = $servicePurchase;
                // $totalServiceSale
               $grandCostWithMarkup = $totalCompanyCost+$grandMarkupCost;
               

                $grandTotalServiceTaxCost = getMarkupCost($grandCostWithMarkup, $serviceTax, 1);
                $grandTotalTCSCost = getMarkupCost($grandCostWithMarkup, $serviceTcs, 1);

                $clientCost = $grandTotalCost = ($totalCompanyCost+$grandMarkupCost+$grandTotalServiceTaxCost+$grandTotalTCSCost);
                ${"proposalCost".$val} = $clientCost;
               $clientMarginCost = $grandMarkupCost-$grandTotalDiscountCost;

                ?>  
           
        
            </tr>
           
        </table>

        <?php }else{ 
            ?>
            <table width="90%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:14px;border-collapse: collapse;margin-bottom:30px;">
            
            <tr style="font-size: 14px;">
                <td align="right"><strong>Particular</strong></td>
                <td colspan="3" width="34%" align="right"><?php echo $paxAdult.'&nbsp;Adult(s),&nbsp;&nbsp;&nbsp;'.$paxChild.'&nbsp;Child(s),&nbsp;&nbsp;&nbsp;'.$paxInfant.'&nbsp;Infant(s)'; ?></td>
            </tr>
            <tr>
                <td  align="right">Additional</td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDPPCostA); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDPPCostC); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDPPCostE); ?></td>
            </tr>
           
            <tr>
                <td align="right"><strong>Value Added Service</strong></td>
                <td bgcolor="#deb887" colspan="3">&nbsp;</td>
            </tr>

            <tr>
                <td  align="right">Visa</td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaPPCostA); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaPPCostC); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaPPCostE); ?></td>
            </tr>

            <tr>
                <td  align="right">Insurance</td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insPPCostA); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insPPCostC); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insPPCostE); ?></td>
            </tr>
            <tr>
                <td  align="right">Flight</td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightPPCostA); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightPPCostC); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flightPPCostE); ?></td>
            </tr>
           
            <?php 
            $VIFCostA =  $visaPPCostA+$insPPCostA+$flightPPCostA;
            $VIFCostC =  $visaPPCostC+$insPPCostC+$flightPPCostC;
            $VIFCostE =  $visaPPCostE+$insPPCostE+$flightPPCostE;
            
            ?>
            <tr>
                <td align="right"><strong>Total Value Added Service Cost</strong></td>
                <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat($VIFCostA); ?></strong></td>
                <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat($VIFCostC); ?></strong></td>
                <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat($VIFCostE); ?></strong></td>
            </tr>
            </table>

            <table width="90%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:13px;border-collapse: collapse;margin-bottom:30px;font-weight:500;">

            <tr style="font-size: 13px;">
                <td colspan="4"><strong>Total Tour Cost</strong></td>
            </tr>
            <tr>
                <td align="left"><strong>Itinerary Services</strong></td>
                <td width="10%" align="right"><strong>Unit&nbsp;Cost</strong></td>
                <td width="10%" align="right"><strong>Volume&nbsp;Type</strong></td>
                <td width="10%" align="right"><strong>Qty&nbsp;Total</strong></td>
                <td width="15%" align="right"><strong>Total&nbsp;Cost</strong></td>
            </tr>

            <?php if($singleRoom>0){ ?> 
            <tr>
                <td align="left" bgcolor="#deb887"><strong>Signle Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $singleRoom; ?></td>
                <?php $totalSingleCost = $singleBasisPR*$singleRoom; ?>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSingleCost); ?></td>
            </tr>
            <?php } if($doubleRoom>0){ ?>
            <tr>
                <td align="left" bgcolor="#deb887"><strong>Double Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doubleBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $doubleRoom; ?></td>
                <?php $totalDoubleCost = $doubleBasisPR*$doubleRoom; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalDoubleCost); ?> </td>
            </tr>
            <?php } if($twinRoom>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Twin Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($twinBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $twinRoom; ?></td>
                <?php $totalTwinCost = $twinBasisPR*$twinRoom; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTwinCost); ?> </td>
            </tr>
            <?php } if($tripleRoom>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Triple Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($tripleBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $tripleRoom; ?></td>
                <?php $totalTripleCost = $tripleBasisPR*$tripleRoom; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTripleCost); ?> </td>
            </tr>
            <?php } if($quadNoofBed>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Quad Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $quadNoofBed; ?></td>
                <?php $totalQuadCost = $quadBasisPR*$quadNoofBed; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalQuadCost); ?> </td>
            </tr>
            <?php } if($sixNoofBed>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Six Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($sixBedBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $sixNoofBed; ?></td>
                <?php $totalSixCost = $sixBedBasisPR*$sixNoofBed; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSixCost); ?> </td>
            </tr>
            <?php } if($eightNoofBed>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Eight Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($eightBedBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $eightNoofBed; ?></td>
                <?php $totalEightCost = $eightBedBasisPR*$eightNoofBed; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalEightCost); ?> </td>
            </tr>
            <?php } if($tenNoofBed>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Ten Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($tenBedBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $tenNoofBed; ?></td>
                <?php $totalTenCost = $tenBedBasisPR*$tenNoofBed; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTenCost); ?> </td>
            </tr>
            <?php } if($EBedAdult>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Extra Bed(A) Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBedABasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $EBedAdult; ?></td>
                <?php $totalEBedACost = $extraBedABasisPR*$EBedAdult; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalEBedACost); ?> </td>
            </tr>
            <?php } if($teenNoofBed>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Teen Room</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($teenBedBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $teenNoofBed; ?></td>
                <?php $totalTeenBedCost = $teenBedBasisPR*$teenNoofBed; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTeenBedCost); ?> </td>
            </tr>
            <?php } if($EBedChild>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Child-With Bed</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithbedBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $EBedChild; ?></td>
                <?php $totalChildWBedCost = $childwithbedBasisPR*$EBedChild; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalChildWBedCost); ?> </td>
            </tr>
            <?php } if($NBedChild>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Child-Without Bed</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithoutbedBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $NBedChild; ?></td>
                <?php $totalChildNBedCost = $childwithoutbedBasisPR*$NBedChild; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalChildNBedCost); ?> </td>
            </tr>
            <?php } if($infantNoofBed>0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Infant Bed</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantBedBasisPR); ?></td>
                <td align="right" bgcolor="#deb887">Room</td>
                <td align="right" bgcolor="#deb887"><?php echo $infantNoofBed; ?></td>
                <?php $totalInfantBedCost = $infantBedBasisPR*$infantNoofBed; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalInfantBedCost); ?> </td>
            </tr>
            <?php } ?>
                <!-- Land Arrangement Cost -->
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Adult)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDPPCostA); ?></td>
                <td align="right" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo $paxAdult; ?></td>
                <?php $totalLAACost = $ADDPPCostA*$paxAdult; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalLAACost); ?> </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Child)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDPPCostC); ?></td>
                <td align="right" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo $paxChild; ?></td>
                <?php $totalLACCost = $ADDPPCostC*$paxChild; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalLACCost); ?> </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Infant)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDPPCostE); ?></td>
                <td align="right" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo $paxInfant; ?></td>
                <?php $totalLAECost = $ADDPPCostE*$paxInfant; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalLAECost); ?> </td>
            </tr>
            <!-- Value Added Services Cost -->
            <tr>
                <td align="left" bgcolor="#deb887"><strong>Value Added Services(Adult)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($VIFCostA); ?></td>
                <td align="right" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo $paxAdult; ?></td>
                <?php $totalVIFACost = $VIFCostA*$paxAdult; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalVIFACost); ?> </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#deb887"><strong>Value Added Services(Child)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($VIFCostC); ?></td>
                <td align="right" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo $paxChild; ?></td>
                <?php $totalVIFCCost = $VIFCostC*$paxChild; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalVIFCCost); ?> </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#deb887"><strong>Value Added Services(Infant)</strong></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($VIFCostE); ?></td>
                <td align="right" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo $paxInfant; ?></td>
                <?php $totalVIFECost = $VIFCostE*$paxInfant; ?> 
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalVIFECost); ?> </td>
            </tr>

            <?php 
            $grandTotalCost = $totalSingleCost+$totalDoubleCost+$totalTwinCost+$totalTripleCost+$totalQuadCost+$totalSixCost+$totalEightCost+$totalTenCost+$totalEBedACost+$totalTeenBedCost+$totalChildWBedCost+$totalChildNBedCost+$totalInfantBedCost+$totalLAACost+$totalLACCost+$totalLAECost+$totalVIFACost+$totalVIFCCost+$totalVIFECost;
            ?>
            <!-- Total Cost Calculation Block -->
            <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>Cost of Trip(INR)</strong></td>
                
                <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandTotalCost); ?></strong></td>
            </tr>

            <?php
         
            // if ($uniMarkup> 0 && $isUni_Mark == 1 && $isSer_Mark == 0) { 
            //     $serviceMarkupLable='';
            //     if ($financeresult['markupSerType'] == '1') {
            //         $serviceMarkupLable='(+) MarkUp ('.$uniMarkup.'';
            //     }
            //     if ($financeresult['markupSerType'] == '2') {
            //         $serviceMarkupLable='(+) Service Charge ('.$uniMarkup.'';
            //     }
            //     if($uniMarkupType == 1){
            //         $serviceMarkupLable  .= '%)';
            //         $serviceMarkup2 = $uniMarkup;
            //         $markupLable = $uniMarkup.'%';
            //     }else{
            //         $serviceMarkupLable  .= 'Flat) Per Pax For '.$totalPax.'pax';
            //         $serviceMarkup2 = $uniMarkup*$totalPax;
            //         $markupLable = $serviceMarkup.'Flat';
            //     }
                
                // $grandMarkupCost = getMarkupCost($grandTotalCost,$uniMarkup,$uniMarkupType);
                // $grandTotalCost = $grandTotalCost+$grandMarkupCost;
            ?>
            <!-- <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5"><strong><?php echo $serviceMarkupLable; ?></strong></td>
                
                <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandMarkupCost); ?></strong></td>
            </tr>
            
            <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>Total Cost With Markup(INR)</strong></td>
                
                <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandTotalCost); ?></strong></td>
            </tr> -->
            <?php //} 
            
            // if ($discount>0) {
            //     if ($discountType == '1') {
            //         $discountLable='(-) Discount ('.$discount.'%)';
            //     }else{
            //         $discountLable  = '(-) Discount ('.$discount.'Flat)';
            //     } 
                
            //     $grandTotalDiscountCost = getMarkupCost($grandTotalCost, $discount, $discountType);
            //     $grandTotalCost = $grandTotalCost-$grandTotalDiscountCost;
            ?>
             <!-- <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5"><strong><?php echo $discountLable; ?></strong></td>
                
                <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandTotalDiscountCost); ?></strong></td>
            </tr>
            
            <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>Total Cost With Discount(INR)</strong></td>
                
                <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandTotalCost); ?></strong></td>
            </tr> -->
            <?php //}  
                    
                    // if ($serviceTax>0 || $tcsTax>0) {
                        // if ($serviceTax>0) {
                        //     if ($financeresult['taxType'] == '1') {
                        //         $serviceMarkupLable  = '(+) GST ('.$serviceTax.'%)';
                        //     }
                        //     if ($financeresult['taxType'] == '2') {
                        //         $serviceMarkupLable  = '(+) VAT ('.$serviceTax.'%)';
                        //     }
                        // }

                        // $taxType = 1; 
                        // $grandTotalTCSCost = 0;
                        // if ($tcsTax>0){ 
                        //     $serviceTCSLable  = '(+) TCS ('.$tcsTax.'%)';
                        //     $grandTotalTCSCost = getMarkupCost($grandTotalCost, $tcsTax, $taxType);
                        // }

                        // $grandTotalServiceTaxCost = getMarkupCost($grandTotalCost, $serviceTax, $taxType);

                        // $grandTotalCost=$grandTotalCost+$grandTotalServiceTaxCost+$grandTotalTCSCost;

                        //if($serviceTax>0){ ?>
                        <!-- <tr>
                            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupLable;?></strong></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalServiceTaxCost);?></td> 
                        </tr> -->
                        <?php //} ?>
                        <?php //if ($tcsTax>0){ ?>
                        <!-- <tr>
                            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceTCSLable;?></strong></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalTCSCost);?></td> 
                        </tr> -->
                        <?php //} ?>
                        <!-- <tr>
                            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total Tour Cost(INR)</strong></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalCost);?></td> 
                        </tr> -->
                      <?php 
                    // } 
                    ?>
            </table>


            <!-- <table  width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;border-collapse: collapse;display:none;"> -->
                <?php 
            //      $qVisaQuery=''; 
            //      $getVisaCost=''; 
            //      $visaPurchaseCost=''; 
            //      $qVisaQuery = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            //      if(mysqli_num_rows($qVisaQuery)>0){
            //      while($getVisaCost = mysqli_fetch_array($qVisaQuery)){
                     
            //          $visaCostPA = convert_to_base($getVisaCost['currencyValue'], $baseCurrencyVal, ($getVisaCost['adultCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));
            //          $visaCostPC = convert_to_base($getVisaCost['currencyValue'], $baseCurrencyVal, ($getVisaCost['childCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));   
            //          $visaCostPE = convert_to_base($getVisaCost['currencyValue'], $baseCurrencyVal, ($getVisaCost['infantCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));  
         
            //          $visaadultPax = $getVisaCost['adultPax'];
            //          $visachildPax = $getVisaCost['childPax'];
            //          $visainfantPax = $getVisaCost['infantPax'];
            //          $taxApplicable = $getVisaCost['taxApplicable'];
            //          $gstTax = getGstValueById($getVisaCost['gstTax']);
            //          $gstTaxValue =  $gstTaxValue+$gstTax;
            //          $visaMarkupCostA = getMarkupCost($visaCostPA,$getVisaCost['processingFee'],$getVisaCost['markupType']);
            //          $visaMarkupAMTA = $visaMarkupAMTA+($visaMarkupCostA*$getVisaCost['adultPax']);
            //          $visaPurchaseCostA = $visaPurchaseCostA+($visaCostPA*$getVisaCost['adultPax']);
            //         // Child Cost
            //          $visaMarkupCostC = getMarkupCost($visaCostPC,$getVisaCost['processingFee'],$getVisaCost['markupType']);
            //          $visaMarkupAMTC = $visaMarkupAMTC+($visaMarkupCostC*$getVisaCost['childPax']);
            //          $visaPurchaseCostC = $visaPurchaseCostC+($visaCostPC*$getVisaCost['childPax']);
            //         // Infant Cost
            //          $visaMarkupCostE = getMarkupCost($visaCostPE,$getVisaCost['processingFee'],$getVisaCost['markupType']);
            //          $visaMarkupAMTE = $visaMarkupAMTE+($visaMarkupCostE*$getVisaCost['infantPax']);
            //          $visaPurchaseCostE = $visaPurchaseCostE+($visaCostPE*$getVisaCost['infantPax']);
                     
            //      }
            //      $visaPurchaseAMT = $visaPurchaseCostA+$visaPurchaseCostC+$visaPurchaseCostE;
            //      $vMCost = $visaMarkupAMTA+$visaMarkupAMTC+$visaMarkupAMTE;
            //      $visaSaleAMT = $visaPurchaseAMT+$vMCost;
            //      $visaTaxAMT = getMarkupCost($visaSaleAMT,$gstTaxValue,1);
            //      $TCSAMT = getMarkupCost($visaSaleAMT, $tcsTax, 1);
            //      $finalCost = $visaSaleAMT+$visaTaxAMT+$TCSAMT;
            //     }

            //     $qInsQuery=''; 
            //     $getInsuranceCost=''; 
            //     $insPurchaseCostA=''; 
            //     $qInsQuery = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            //     if(mysqli_num_rows($qInsQuery)>0){
            //     while($getInsuranceCost = mysqli_fetch_array($qInsQuery)){
                    
            //         $InsCostPA = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, ($getInsuranceCost['adultCost']));
            //         $InsCostPC = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal,($getInsuranceCost['childCost']));   
            //         $InsCostPE = convert_to_base($getInsuranceCost['currencyValue'], $baseCurrencyVal, ($getInsuranceCost['infantCost']));  
    
            //         $gstTax = getGstValueById($getInsuranceCost['gstTax']);
            //         $gstTaxValueI =  $gstTaxValueI+$gstTax;
            //         $insMarkupCostA = getMarkupCost($InsCostPA,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);
            //         $insMarkupAMTA = $insMarkupAMTA+($insMarkupCostA*$getInsuranceCost['adultPax']);
            //         $insPurchaseCostA = $insPurchaseCostA+($InsCostPA*$getInsuranceCost['adultPax']);
            //        // Child Cost
            //         $insMarkupCostC = getMarkupCost($InsCostPC,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);
            //         $insMarkupAMTC = $insMarkupAMTC+($insMarkupCostC*$getInsuranceCost['childPax']);
            //         $insPurchaseCostC = $insPurchaseCostC+($InsCostPC*$getInsuranceCost['childPax']);
            //        // Infant Cost
            //         $insMarkupCostE = getMarkupCost($InsCostPE,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);
            //         $insMarkupAMTE = $insMarkupAMTE+($insMarkupCostE*$getInsuranceCost['infantPax']);
            //         $insPurchaseCostE = $insPurchaseCostE+($InsCostPE*$getInsuranceCost['infantPax']);
                    
            //     }
            //     $insPurchaseAMT = $insPurchaseCostA+$insPurchaseCostC+$insPurchaseCostE;
            //     $insMCost = $insMarkupAMTA+$insMarkupAMTC+$insMarkupAMTE;
            //     $insSaleAMT = $insPurchaseAMT+$insMCost;
            //     $insTaxAMT = getMarkupCost($insSaleAMT,$gstTaxValueI,1);
            //     $TCSAMTI = getMarkupCost($insSaleAMT, $tcsTax, 1);
            //     $finalCostI = $insSaleAMT+$insTaxAMT+$TCSAMTI;
            //    }

            //    $qflightQuery=''; 
            //     $getFlightCost=''; 
            //     $flightPurchaseCostA=''; 
            //     $qflightQuery = GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'quotationId="'.$quotationId.'" and isFlightTaken="yes" and dayId=0 order by id asc');
            //     if(mysqli_num_rows($qflightQuery)>0){
            //     while($getFlightCost = mysqli_fetch_array($qflightQuery)){
            //         $fliCostA = convert_to_base($getFlightCost['currencyValue'], $baseCurrencyVal, ($getFlightCost['adultCost']+$getFlightCost['adultTax']));
            //         $fliCostC = convert_to_base($getFlightCost['currencyValue'], $baseCurrencyVal,($getFlightCost['childCost']+$getFlightCost['childTax']));   
            //         $fliCostE = convert_to_base($getFlightCost['currencyValue'], $baseCurrencyVal,($getFlightCost['infantCost']+$getFlightCost['infantTax']));   
    
            //         $gstTax = getGstValueById($getFlightCost['gstTax']);
            //         $gstTaxValueF =  $gstTaxValueF+$gstTax;
            //         $fliMarkupCostA = getMarkupCost($fliCostA,$getFlightCost['markupCost'],$getFlightCost['markupType']);
            //         $fliMarkupAMTA = $fliMarkupAMTA+($fliMarkupCostA*$getFlightCost['adultPax']);
            //         $fliPurchaseCostA = $fliPurchaseCostA+($fliCostA*$getFlightCost['adultPax']);
            //        // Child Cost
            //         $fliMarkupCostC = getMarkupCost($fliCostC,$getFlightCost['markupCost'],$getFlightCost['markupType']);
            //         $fliMarkupAMTC = $fliMarkupAMTC+($fliMarkupCostC*$getFlightCost['childPax']);
            //         $fliPurchaseCostC = $fliPurchaseCostC+($fliCostC*$getFlightCost['childPax']);
            //        // Infant Cost
            //         $fliMarkupCostE = getMarkupCost($fliCostE,$getFlightCost['markupCost'],$getFlightCost['markupType']);
            //         $fliMarkupAMTE = $fliMarkupAMTE+($fliMarkupCostE*$getFlightCost['infantPax']);
            //         $fliPurchaseCostE = $fliPurchaseCostE+($fliCostE*$getFlightCost['infantPax']);
                    
            //     }
            //     $fliPurchaseAMT = $fliPurchaseCostA+$fliPurchaseCostC+$fliPurchaseCostE;
            //     $fliMCost = $insMarkupAMTA+$insMarkupAMTC+$insMarkupAMTE;
            //     $fliSaleAMT = $fliPurchaseAMT+$fliMCost;
            //     $fliTaxAMT = getMarkupCost($fliSaleAMT,$gstTaxValueI,1);
            //     $TCSAMTF = getMarkupCost($fliSaleAMT, $tcsTax, 1);
            //     $finalCostF = $fliSaleAMT+$fliTaxAMT+$TCSAMTF;
            //    }

            //    $packageRateQuery=''; 
            //    $getPackageCost=''; 
            //    $flightPurchaseCostA=''; 
            //    $packageRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="1" and costTypeId="1"');
            //    if(mysqli_num_rows($packageRateQuery)>0){
            //    while($getPackageCost = mysqli_fetch_array($packageRateQuery)){
            //        $singleCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal, $getPackageCost['singleBasis']);
            //        $doubleCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['doubleBasis']);   
            //        $twinCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['twinBasis']);   
            //        $tripleCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['tripleBasis']);   
            //        $quadCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['quadBasis']);   
            //        $sixBedCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['sixBedBasis']);   
            //        $eightBedCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['eightBedBasis']);   
            //        $tenBedCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['tenBedBasis']);   
            //        $extraBedACost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['extraBedABasis']);   
            //        $childwithbedCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['childwithbedBasis']);   
            //        $childwithoutCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['childwithoutbedBasis']);   
            //        $infantBedCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['infantBedBasis']);   
            //        $teenBedCost = convert_to_base($getPackageCost['ROE'], $baseCurrencyVal,$getPackageCost['teenBedBasis']);   
   
            //        $gstTax = getGstValueById($getPackageCost['gstTax']);
            //        $pkggstTaxValue =  $pkggstTaxValue+$gstTax;
            //         // Single Room Cost
            //        $sglMarkupCost = getMarkupCost($singleCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $sglMarkupAMT = $sglMarkupAMT+($sglMarkupCost*$singleRoom);
            //        $sglPurchaseCost = $sglPurchaseCost+($singleCost*$singleRoom);

            //        $dblMarkupCost = getMarkupCost($doubleCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $dblMarkupAMT = $dblMarkupAMT+($dblMarkupCost*$doubleRoom);
            //        $dblPurchaseCost = $dblPurchaseCost+($doubleCost*$doubleRoom);

            //        $twinMarkupCost = getMarkupCost($twinCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $twinMarkupAMT = $twinMarkupAMT+($twinMarkupCost*$twinRoom);
            //        $twinPurchaseCost = $twinPurchaseCost+($twinCost*$twinRoom);

            //        $tplMarkupCost = getMarkupCost($tripleCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $tplMarkupAMT = $tplMarkupAMT+($tplMarkupCost*$tripleRoom);
            //        $tplPurchaseCost = $tplPurchaseCost+($tripleCost*$tripleRoom);

            //        $quadMarkupCost = getMarkupCost($quadCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $quadMarkupAMT = $quadMarkupAMT+($quadMarkupCost*$quadNoofBed);
            //        $quadPurchaseCost = $quadPurchaseCost+($quadCost*$quadNoofBed);

            //        $sixMarkupCost = getMarkupCost($sixBedCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $sixMarkupAMT = $sixMarkupAMT+($sixMarkupCost*$sixNoofBed);
            //        $sixPurchaseCost = $sixPurchaseCost+($sixBedCost*$sixNoofBed);

            //        $eightMarkupCost = getMarkupCost($eightBedCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $eightMarkupAMT = $eightMarkupAMT+($eightMarkupCost*$eightNoofBed);
            //        $eightPurchaseCost = $eightPurchaseCost+($eightBedCost*$eightNoofBed);

            //        $tenMarkupCost = getMarkupCost($tenBedCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $tenMarkupAMT = $tenMarkupAMT+($tenMarkupCost*$tenNoofBed);
            //        $tenPurchaseCost = $tenPurchaseCost+($tenBedCost*$tenNoofBed);

            //        $eBAMarkupCost = getMarkupCost($extraBedACost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $eBAMarkupAMT = $eBAMarkupAMT+($eBAMarkupCost*$EBedAdult);
            //        $eBAPurchaseCost = $eBAPurchaseCost+($extraBedACost*$EBedAdult);

            //        $teenMarkupCost = getMarkupCost($teenBedCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $teenMarkupAMT = $teenMarkupAMT+($teenMarkupCost*$teenNoofBed);
            //        $teenPurchaseCost = $teenPurchaseCost+($teenBedCost*$teenNoofBed);

            //        $eBCMarkupCost = getMarkupCost($childwithbedCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $eBCMarkupAMT = $eBCMarkupAMT+($eBCMarkupCost*$EBedChild);
            //        $eBCPurchaseCost = $eBCPurchaseCost+($childwithbedCost*$EBedChild);

            //        $eBNCMarkupCost = getMarkupCost($childwithoutCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $eBNCMarkupAMT = $eBNCMarkupAMT+($eBNCMarkupCost*$NBedChild);
            //        $eBNCPurchaseCost = $eBNCPurchaseCost+($childwithoutCost*$NBedChild);

            //        $iNFMarkupCost = getMarkupCost($infantBedCost,$getPackageCost['markupValue'],$getPackageCost['markupType']);
            //        $iNFMarkupAMT = $iNFMarkupAMT+($iNFMarkupCost*$infantNoofBed);
            //        $iNFPurchaseCost = $iNFPurchaseCost+($infantBedCost*$infantNoofBed);
                   
            //    }
            //    $pkgPurchaseAMT = $sglPurchaseCost+$dblPurchaseCost+$twinPurchaseCost+$tplPurchaseCost+$quadPurchaseCost+$sixPurchaseCost
            //    +$eightPurchaseCost+$tenPurchaseCost+$eBAPurchaseCost+$teenPurchaseCost+$eBCPurchaseCost+$eBNCPurchaseCost+$iNFPurchaseCost;
            //    $pkgMCost = $sglMarkupAMT+$dblMarkupAMT+$twinMarkupAMT+$tplMarkupAMT+$quadMarkupAMT+$sixMarkupAMT+$eightMarkupAMT+$tenMarkupAMT+$eBAMarkupAMT+$teenMarkupAMT+$eBCMarkupAMT+$eBNCMarkupAMT+$iNFMarkupAMT;

            //    $pkgSaleAMT = $pkgPurchaseAMT+$pkgMCost;
            //    $pkgTaxAMT = getMarkupCost($pkgSaleAMT,$pkggstTaxValue,1);
            //    $pkgTCSAMT = getMarkupCost($pkgSaleAMT, $tcsTax, 1);
            //    $pkgfinalCost = $pkgSaleAMT+$pkgTaxAMT+$pkgTCSAMT;
            //   }

            //   $additionalQuery=''; 
            //   $getFlightCost=''; 
            //   $flightPurchaseCostA=''; 
            //   $additionalQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="2"');
            //   if(mysqli_num_rows($additionalQuery)>0){
            //   while($getAdditionalCost = mysqli_fetch_array($additionalQuery)){

            //     if($getAdditionalCost['costTypeId']==1){
            //       $adultCostAD = convert_to_base($getAdditionalCost['ROE'], $baseCurrencyVal,$getAdditionalCost['adultCost']);
            //       $childCostAD = convert_to_base($getAdditionalCost['ROE'], $baseCurrencyVal,$getAdditionalCost['ChildCost']);   
            //       $infantCostAD = convert_to_base($getAdditionalCost['ROE'], $baseCurrencyVal,$getAdditionalCost['infantCost']);  

            //       $adultPaxAD = $getAddiRateData['adultPax'];
            //       $ChildPaxAD = $getAddiRateData['ChildPax'];
            //       $infantPaxAD = $getAddiRateData['infantPax'];

            //       $gstTax = getGstValueById($getAdditionalCost['gstTax']);
            //       $gstTaxValueADD =  $gstTaxValueADD+$gstTax;
            //       $ADDMarkupCostA = getMarkupCost($adultCostAD,$getAdditionalCost['markupValue'],$getAdditionalCost['markupType']);
            //       $ADDMarkupAMTA = $ADDMarkupAMTA+($ADDMarkupCostA*$getAdditionalCost['adultPax']);
            //       $ADDPurchaseCostA = $ADDPurchaseCostA+($adultCostAD*$getAdditionalCost['adultPax']);
            //      // Child Cost
            //       $ADDMarkupCostC = getMarkupCost($childCostAD,$getAdditionalCost['markupValue'],$getAdditionalCost['markupType']);
            //       $ADDMarkupAMTC = $ADDMarkupAMTC+($ADDMarkupCostC*$getAdditionalCost['ChildPax']);
            //       $ADDPurchaseCostC = $ADDPurchaseCostC+($childCostAD*$getAdditionalCost['ChildPax']);
            //      // Infant Cost
            //       $ADDMarkupCostE = getMarkupCost($infantCostAD,$getAdditionalCost['markupValue'],$getAdditionalCost['markupType']);
            //       $ADDMarkupAMTE = $ADDMarkupAMTE+($ADDMarkupCostE*$getAdditionalCost['infantPax']);
            //       $ADDPurchaseCostE = $ADDPurchaseCostE+($infantCostAD*$getAdditionalCost['infantPax']);
            //     }
            //     if($getAdditionalCost['costTypeId']==2){
            //         $ADDgroupCost = convert_to_base($getAdditionalCost['ROE'], $baseCurrencyVal,$getAdditionalCost['groupCost']);
    
            //         $ADDMarkupCostG = getMarkupCost($ADDgroupCost,$getAdditionalCost['markupValue'],$getAdditionalCost['markupType']);
            //         $ADDMarkupAMTG = $ADDMarkupAMTG+($ADDMarkupCostG*$getAddiRateData['adultPax']);
            //         $ADDPurchaseCostG = $ADDPurchaseCostG+($ADDgroupCost*$getAddiRateData['adultPax']);
            //     }
            //   }
            //   $ADDPurchaseAMT = $fliPurchaseCostA+$fliPurchaseCostC+$fliPurchaseCostE+$ADDPurchaseCostG;
            //   $ADDMCost = $insMarkupAMTA+$insMarkupAMTC+$insMarkupAMTE+$ADDMarkupAMTG;
            //   $ADDSaleAMT = $ADDPurchaseAMT+$ADDMCost;
            //   $ADDTaxAMT = getMarkupCost($ADDSaleAMT,$gstTaxValueADD,1);
            //   $ADDTCSAMT = getMarkupCost($ADDSaleAMT, $tcsTax, 1);
            //   $ADDfinalCost = $ADDSaleAMT+$ADDTaxAMT+$ADDTCSAMT;
            //  }

            //    $totaPurchaseAMT = $fliPurchaseAMT+$visaPurchaseAMT+$insPurchaseAMT+$pkgPurchaseAMT+$ADDPurchaseAMT;
            //    $totaMarkupAMT = $vMCost+$insMCost+$fliMCost+$pkgMCost+$ADDMCost;
            //    $totaSaleAMT = $visaSaleAMT+$insSaleAMT+$fliSaleAMT+$pkgSaleAMT+$ADDSaleAMT;
            //    $totalTaxAMT = $visaTaxAMT+$insTaxAMT+$fliTaxAMT+$pkgTaxAMT+$ADDTaxAMT;
            //    $totalTCSAMT = $TCSAMT+$TCSAMTI+$TCSAMTF+$pkgTCSAMT+$ADDTCSAMT;
            //    $totalFinalAMT = $finalCost+$finalCostI+$finalCostF+$pkgfinalCost+$ADDfinalCost;
                ?>
                <!-- <tr>
                    <td bgcolor="#ddd"><strong>Service Type</strong></td>
                    <td bgcolor="#ddd"><strong>Purchase Cost</strong></td>
                    <td bgcolor="#ddd"><strong>Markup Cost</strong></td>
                    <td bgcolor="#ddd"><strong>Sale Amount</strong></td>
                    <td bgcolor="#ddd"><strong>Tax</strong></td>
                    <td bgcolor="#ddd"><strong>TCS</strong></td>
                    <td bgcolor="#ddd"><strong>Final Cost</strong></td>
                </tr>
                <tr>
                    <td bgcolor="#deb887">Visa Service</td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaPurchaseAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($vMCost); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaSaleAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaTaxAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($TCSAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($finalCost); ?></td>
                </tr>

                <tr>
                    <td bgcolor="#deb887">Insurance Service</td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insPurchaseAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insMCost); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insSaleAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insTaxAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($TCSAMTI); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($finalCostI); ?></td>
                </tr>

                <tr>
                    <td bgcolor="#deb887">Flight Service</td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($fliPurchaseAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($fliMCost); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($fliSaleAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($fliTaxAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($TCSAMTF); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($finalCostF); ?></td>
                </tr>
                
                <tr>
                    <td bgcolor="#deb887">Package Cost</td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pkgPurchaseAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pkgMCost); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pkgSaleAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pkgTaxAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pkgTCSAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pkgfinalCost); ?></td>
                </tr>
                
                <tr>
                    <td bgcolor="#deb887">Additional Cost</td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDPurchaseAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDMCost); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDSaleAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDTaxAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDTCSAMT); ?></td>
                    <td bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($ADDfinalCost); ?></td>
                </tr>

                <tr>
                    <td bgcolor="#ddd"><strong>Total</strong></td>
                    <td bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($totaPurchaseAMT); ?></strong></td>
                    <td bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($totaMarkupAMT); ?></strong></td>
                    <td bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($totaSaleAMT); ?></strong></td>
                    <td bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($totalTaxAMT); ?></strong></td>
                    <td bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($totalTCSAMT); ?></strong></td>
                    <td bgcolor="#ddd"><strong><?php echo getTwoDecimalNumberFormat($totalFinalAMT); ?></strong></td>
                </tr>
            </table> -->
            
        <?php } } ?>
        <!-- end Total tour cost -->

        <!-- start Per pax basis cost -->
        <?php if($resultpageQuotation['quotationType']==1){ ?>
        <br>
        <div style="text-align:left!important;font-size: 15px;margin: 0;"><strong>Per Pax Cost on Occupancy Basis</strong></div>
        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;border-collapse: collapse;">
            <tr>
            <td align="left" bgcolor="#ddd" ><strong>Occupancy</strong></td>
            <td align="right" bgcolor="#ddd" ><strong>Cost&nbsp;(In&nbsp;<?php echo getCurrencyName($currencyId); ?>&nbsp;)</strong></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" bgcolor="#ddd" ><strong>Cost&nbsp;(In&nbsp;<?php echo getCurrencyName($newCurr); ?>&nbsp;)</strong></td> 
            <?php } ?>
            </tr>
            <?php
// sixNoofBed
// totalSixCost
// eightNoofBed
// totalEightCost
// tenNoofBed
// totalTenCost


// teenNoofBed
// totalTeenBedCost
            if ($singleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#ddd" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Single&nbsp;Basis</td>
            <td align="right" ><?php echo ${"ppCostONSingleBasis".$val} = getPerPersonBasisCost((($totalSingleCost/$singleRoom)+$ADDPPCostA+$VIFCostA),0,$uniMarkupType,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"ppCostONSingleBasis".$val}); ?></td> 
            <?php } ?>   
            </tr>

            <?php } if ($doubleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#ddd" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Double&nbsp;Basis</td>
            <td align="right" ><?php echo ${"ppCostONDoubleBasis".$val} = getPerPersonBasisCost((($totalDoubleCost/($doubleRoom*2))+$ADDPPCostA+$VIFCostA),0,0,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"ppCostONDoubleBasis".$val}); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($tripleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#ddd" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Triple&nbsp;Basis</td>
            <td align="right" ><?php echo ${"ppCostOnTripleBasis".$val} = getPerPersonBasisCost((($totalTripleCost/($tripleRoom*3))+$ADDPPCostA+$VIFCostA),0,$uniMarkupType,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"ppCostOnTripleBasis".$val}); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($quadNoofBed>0) { ?>
            <tr>
            <td align="left" bgcolor="#ddd" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;quad&nbsp;Basis</td>
            <td align="right" ><?php echo ${"ppCostOnQuadBasis".$val} = getPerPersonBasisCost((($totalQuadCost/($quadNoofBed*3))+$ADDPPCostA+$VIFCostA),0,$uniMarkupType,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"ppCostOnQuadBasis".$val}); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($EBedAdult>0) { ?>
            <tr>

            <td align="left" bgcolor="#ddd" >Per&nbsp;Adult&nbsp;Cost&nbsp;On&nbsp;ExtraBed&nbsp;Basis</td>
            <td align="right" ><?php echo ${"ppCostOnExtraBedABasis".$val} = getPerPersonBasisCost((($totalEBedACost/$EBedAdult)+$ADDPPCostA+$VIFCostA),0,$uniMarkupType,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"ppCostOnExtraBedABasis".$val}); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($EBedChild>0){ ?>

            <tr> 
            <td align="left" bgcolor="#ddd" >Per&nbsp;Child&nbsp;Cost&nbsp;On&nbsp;ExtraBed&nbsp;Basis</td>
            <td align="right" ><?php echo ${"pcCostOnExtraBedCBasis".$val} = getPerPersonBasisCost((($totalChildWBedCost/$EBedChild)+$ADDPPCostC+$VIFCostC),0,$uniMarkupType,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"pcCostOnExtraBedCBasis".$val}); ?></td> 
            <?php } ?>
            </tr>
            <?php } if($NBedChild>0){ ?>
            <tr> 
            <td align="left" bgcolor="#ddd" >Per&nbsp;Child&nbsp;No&nbsp;Bed&nbsp;Basis</td>
            <td align="right" ><?php echo ${"pcCostOnExtraNBedCBasis".$val} = getPerPersonBasisCost((($totalChildNBedCost/$NBedChild)+$ADDPPCostC+$VIFCostC),0,$uniMarkupType,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"pcCostOnExtraNBedCBasis".$val}); ?></td> 
            <?php } ?>
            </tr>
            <?php } if($infantNoofBed>0){ ?>
            <tr> 
            <td align="left" bgcolor="#ddd" >Per&nbsp;Infant&nbsp;Bed&nbsp;Basis</td>
            <td align="right" ><?php echo ${"peCostBasis".$val} = getPerPersonBasisCost((($totalInfantBedCost/$infantNoofBed)+$ADDPPCostE+$VIFCostE),0,$uniMarkupType,$discount,$discountType,0,0,0,$serviceTaxDivident);  ?></td> 
            <?php if($newCurr!=$currencyId){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"peCostBasis".$val}); ?></td> 
            <?php } ?>
            </tr>
            <?php } ?>
        </table>

        <?php } ?>

                <!-- Break up cost block -->
<table width="100%" cellpadding="0" cellspacing="0" style="padding-top:10px; margin-top:10px; border-collapse: collapse;">
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
            <!-- <td align="right" bgcolor="#ddd"><strong>TCS</strong></td> -->
            <td align="right" bgcolor="#ddd"><strong>Total&nbsp;Cost</strong></td>
            </tr>
            
            <?php
            // visa
            $visaMarkupCostApp = $saleVisaApp = $totalpurchaseVisaA = $totalvisaMarkupCostA = $totalSaleVisaA = 0;
            $visaMarkupCostCpp = $saleVisaCpp = $totalpurchaseVisaC = $totalvisaMarkupCostC = $totalSaleVisaC = 0;
            $visaMarkupCostEpp = $saleVisaEpp = $totalpurchaseVisaE = $totalvisaMarkupCostE = $totalSaleVisaE = 0;
            $totalserviceCostApp=$totalserviceCostCpp=$totalserviceCostEpp=$totalProcessingFee=0;$grandPurchaseSBCost=$totalVisaServiceCost=$visaFinalCostA=$visaServicePurchaseCost=$getVisaCost=0;
    
                $VR=''; 
                $VR = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
                while($getVisaCost = mysqli_fetch_array($VR)){
                   
                    $taxApplicable = $getVisaCost['taxApplicable'];
                    $gstValue = getGstValueById($getVisaCost['gstTax']);
                    $visaAdultPax = $getVisaCost['adultPax'];
                    $visaChildPax = $getVisaCost['childPax'];
                    $visaInfantPax = $getVisaCost['infantPax'];
                // vfsCharges embassyFee
                $currencyValue = $getVisaCost['currencyValue'];

                $purchaseVisaBApp = convert_to_base($currencyValue, $baseCurrencyVal,($getVisaCost['adultCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));        
                $purchaseVisaBCpp = convert_to_base($currencyValue, $baseCurrencyVal,($getVisaCost['childCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));        
                $purchaseVisaBEpp = convert_to_base($currencyValue, $baseCurrencyVal,($getVisaCost['infantCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee'])); 

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
                
                $visataxAmountBApp = getMarkupCost($saleVisaBApp, $gstValue, 1);
              
                $visatcsAmountBApp = getMarkupCost($saleVisaBApp, $tcsTax, 1);

                $visaFinalCostBA = $saleVisaBApp+$visataxAmountBApp+$visatcsAmountBApp;
                $totalVisaServiceBCostA = $totalVisaServiceBCostA + $visaFinalCostBA;

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
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visataxAmountBApp) ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visatcsAmountBApp) ?></td>
                <!-- <td align="right" bgcolor="#deb887"><?php if($visatcsAmountBApp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visatcsAmountBApp); } ?></td> -->
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaFinalCostBA) ?></td>
                </tr>
                <?php 
           
            if($visaChildPax>0){
               
                $saleVisaBCpp = $totalpurchaseVisaBC+$pFeeBC;
                // if($taxApplicable==0){
                // $visataxAmountBCpp = getMarkupCost($pFeeBC, $serviceTax, 1);
                $visataxAmountBCpp = getMarkupCost($saleVisaBCpp, $gstValue, 1);
                // }
                $visatcsAmountBCpp = getMarkupCost($saleVisaBCpp, $tcsTax, 1);

                $visaFinalCostBC = $saleVisaBCpp+$visataxAmountBCpp+$visatcsAmountBCpp;
                $totalVisaServiceBCostC = $totalVisaServiceBCostC + $visaFinalCostBC;

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
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visataxAmountBCpp) ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visatcsAmountBCpp) ?></td>
                <!-- <td align="right" bgcolor="#deb887"><?php if($visatcsAmountBCpp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visatcsAmountBCpp); } ?></td> -->
               
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visaFinalCostBC) ?></td>
                </tr>
                <?php 
            }
           
            if($visaInfantPax>0){
                
                $saleVisaBEpp = $totalpurchaseVisaBE+$pFeeBE;
                // if($taxApplicable==0){
                // $visataxAmountBEpp = getMarkupCost($pFeeBE, $serviceTax, 1);
                $visataxAmountBEpp = getMarkupCost($saleVisaBEpp, $gstValue, 1);
                // }
                $visatcsAmountBEpp = getMarkupCost($saleVisaBEpp, $tcsTax, 1);

                $visaFinalCostBE = $saleVisaBEpp+$visataxAmountBEpp+$visatcsAmountBEpp;
                $totalVisaServiceBCostE = $totalVisaServiceBCostE + $visaFinalCostBE;

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
                
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visataxAmountBEpp); ?></td>
                <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($visatcsAmountBEpp); ?></td>
                <!-- <td align="right" bgcolor="#deb887"><?php if($visatcsAmountBEpp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($visatcsAmountBEpp); } ?></td> -->
               
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
            <th align="right"><?php echo getTwoDecimalNumberFormat(($totalVisaServiceBCostA+$totalVisaServiceBCostC+$totalVisaServiceBCostE)) ?></th>
        </tr>
        <tr>
                <td align="right" bgcolor="#ffff00">Per person Cost</td>
                <td align="right" bgcolor="#ffff00">Per Adult</td>
                <td  align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($totalVisaServiceBCostA)) ?></td>
                <td  align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($totalVisaServiceBCostA/$paxAdult)) ?></td>
                <td align="right" bgcolor="#ffff00">Per Child</td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalVisaServiceBCostC) ?></td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalVisaServiceBCostC/$paxChild) ?></td>
                <td align="right" bgcolor="#ffff00">Per Infant</td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalVisaServiceBCostE) ?></td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalVisaServiceBCostE/$paxInfant) ?></td>
    
            </tr>
        <?php

                $totalCompanyCost = $totalCompanyCost+$grandPurchaseSBCost;
                $grandTotalMarkupCost = $grandTotalMarkupCost+$totalProcessingFee;
                $grandTotalServiceTaxCost = $grandTotalServiceTaxCost + $totalServiceBTax;
                $grandTotalTCSCost = $grandTotalTCSCost + $totalServiceBTcs;
    }
}

            // insurance
          
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
                    $gstValue = getGstValueById($getInsuranceCost['gstTax']);
 
                    $adultPax = $getInsuranceCost['adultPax'];
                    $childPax = $getInsuranceCost['childPax'];
                    $infantPax = $getInsuranceCost['infantPax'];
                    $currencyValue = $getInsuranceCost['currencyValue'];

                    $purchaseInsuranceBApp = (convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['adultCost']));        
                    $purchaseInsuranceBCpp = (convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['childCost']));        
                    $purchaseInsuranceBEpp = (convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['infantCost']));  

                    $purchaseInsuranceBA =  $purchaseInsuranceBApp*$adultPax;
                    $purchaseInsuranceBC =  $purchaseInsuranceBCpp*$childPax;
                    $purchaseInsuranceBE =  $purchaseInsuranceBEpp*$infantPax;

                    if($getInsuranceCost['markupType']==2){

                    $pInsFeeBA = $getInsuranceCost['processingFee']*$adultPax;  
                    $pInsFeeBC = $getInsuranceCost['processingFee']*$childPax;
                    $pInsFeeBE = $getInsuranceCost['processingFee']*$infantPax;
                     }else{
                    $pInsFeeBA = getMarkupCost($purchaseInsuranceBA,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);  
                    $pInsFeeBC = getMarkupCost($purchaseInsuranceBC,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);
                    $pInsFeeBE = getMarkupCost($purchaseInsuranceBE,$getInsuranceCost['processingFee'],$getInsuranceCost['markupType']);
                     }
                    $grandIPurchaseSBCost = $grandIPurchaseSBCost+($purchaseInsuranceBA+$purchaseInsuranceBE+$purchaseInsuranceBC);

                    $saleInsuranceBA = $purchaseInsuranceBA+$pInsFeeBA;
                    $instaxAmountBApp = getMarkupCost($saleInsuranceBA, $gstValue, 1);
                    // $instaxAmountBApp = getMarkupCost($pInsFeeBA, $serviceTax, 1);
                    $instcsAmountBApp = getMarkupCost($saleInsuranceBA, $tcsTax, 1);

                    $insFinalCostBA = $saleInsuranceBA+$instaxAmountBApp+$instcsAmountBApp;
                    $totalInsServiceBCostA = $totalInsServiceBCostA + $insFinalCostBA;

                    $totalSaleInsBCost = $totalSaleInsBCost+$saleInsuranceBA;
                    $insServicePurchaseCost = $insServicePurchaseCost + $purchaseInsuranceBApp;
                    $totalIProcessingFee = $totalIProcessingFee + $pInsFeeBA;
                    $totalIServiceBTax = $totalIServiceBTax + $instaxAmountBApp;
                    $totalIServiceBTcs = $totalIServiceBTcs + $instcsAmountBApp;

                    $rowspan=0;
                    if($childPax>0){
                        $rowspan = $rowspan+1;
                    }
                    if($infantPax>0){
                        $rowspan = $rowspan+1;
                    }
                    ?>
                    <tr>
                    <td align="left" rowspan="<?php echo $rowspan+1; ?>" bgcolor="#deb887"><strong><?php echo getCountryName($getInsuranceCost['countryId']) ?></strong></td>
                    <td align="left" bgcolor="#deb887"><strong>Insurance Services(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBApp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($adultPax); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pInsFeeBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleInsuranceBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($instaxAmountBApp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($instcsAmountBApp); ?></td>
                    <!-- <td align="right" bgcolor="#deb887"><?php if($instcsAmountBApp>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instcsAmountBApp); } ?></td> -->
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insFinalCostBA) ?></td>
                    </tr>
                    <?php 
               
                if($childPax>0){
                   
                    $saleInsuranceBC = $purchaseInsuranceBC+$pInsFeeBC;

                    // $instaxAmountBC = getMarkupCost($pInsFeeBC, $serviceTax, 1);
                    $instcsAmountBC = getMarkupCost($saleInsuranceBC, $tcsTax, 1);
                    $instaxAmountBC = getMarkupCost($saleInsuranceBC, $gstValue, 1);
                    $insFinalCostBC = $saleInsuranceBC+$instaxAmountBC+$instcsAmountBC;
                    $totalInsServiceBCostC = $totalInsServiceBCostC + $insFinalCostBC;

                    $totalSaleInsBCost = $totalSaleInsBCost+$saleInsuranceBC;
                    $insServicePurchaseCost = $insServicePurchaseCost + $purchaseInsuranceBCpp;
                    $totalIProcessingFee = $totalIProcessingFee + $pInsFeeBC;
                    $totalIServiceBTax = $totalIServiceBTax + $instaxAmountBC;
                    $totalIServiceBTcs = $totalIServiceBTcs + $instcsAmountBC;
    
                    ?>    
                    <tr>
                   
                    <td align="left" bgcolor="#deb887"><strong>Insurance Services(Child)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBCpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($childPax); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pInsFeeBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleInsuranceBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($instaxAmountBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($instcsAmountBC); ?></td>
                    <!-- <td align="right" bgcolor="#deb887"><?php if($instcsAmountBC>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instcsAmountBC); } ?></td> -->
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($insFinalCostBC) ?></td>
                    </tr>
                    <?php 
                }
               
                if($infantPax>0){
                    

                    $saleInsuranceBE = $purchaseInsuranceBE+$pInsFeeBE;

                    // $instaxAmountBE = getMarkupCost($pInsFeeBE, $serviceTax, 1);
                    $instcsAmountBE = getMarkupCost($saleInsuranceBE, $tcsTax, 1);
                    $instaxAmountBE = getMarkupCost($saleInsuranceBE, $gstValue, 1);
                    $insFinalCostBE = $saleInsuranceBE+$instaxAmountBE+$instcsAmountBE;
                    $totalInsServiceBCostE = $totalInsServiceBCostE + $insFinalCostBE;

                    $totalSaleInsBCost = $totalSaleInsBCost+$saleInsuranceBE;
                    $insServicePurchaseCost = $insServicePurchaseCost + $purchaseInsuranceBEpp;
                    $totalIProcessingFee = $totalIProcessingFee + $pInsFeeBE;
                    $totalIServiceBTax = $totalIServiceBTax + $instaxAmountBE;
                    $totalIServiceBTcs = $totalIServiceBTcs + $instcsAmountBE;
    
                    ?>    
                    <tr>
                    
                    <td align="left" bgcolor="#deb887"><strong>Insurance Services(Infant)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBEpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($infantPax); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseInsuranceBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pInsFeeBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleInsuranceBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($instaxAmountBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($instcsAmountBE); ?></td>
                    <!-- <td align="right" bgcolor="#deb887"><?php if($instcsAmountBE>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($instcsAmountBE); } ?></td> -->
                   
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
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalInsServiceBCostA+$totalInsServiceBCostC+$totalInsServiceBCostE) ?></th>
    
            </tr>
            <tr>
                <td align="right" bgcolor="#ffff00">Per person Cost</td>
                <td align="right" bgcolor="#ffff00">Per Adult</td>
                <td  align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($totalInsServiceBCostA)) ?></td>
                <td  align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($totalInsServiceBCostA/$paxAdult)) ?></td>
                <td align="right" bgcolor="#ffff00">Per Child</td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalInsServiceBCostC) ?></td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalInsServiceBCostC/$paxChild) ?></td>
                <td align="right" bgcolor="#ffff00">Per Infant</td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalInsServiceBCostE) ?></td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalInsServiceBCostE/$paxInfant) ?></td>
    
            </tr>
            <?php

            $totalCompanyCost = $totalCompanyCost+$grandIPurchaseSBCost;
            $grandTotalMarkupCost = $grandTotalMarkupCost+$totalIProcessingFee;
            $grandTotalServiceTaxCost = $grandTotalServiceTaxCost + $totalIServiceBTax;
            $grandTotalTCSCost = $grandTotalTCSCost + $totalIServiceBTcs;
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
                    
                    $gstValue = getGstValueById($getFlightCost['gstTax']);
                    $currencyValue = $getFlightCost['currencyValue'];
                    $purchaseFlightBApp = (convert_to_base($currencyValue, $baseCurrencyVal,$getFlightCost['totalAdultCost']));        
                    $purchaseFlightBCpp = (convert_to_base($currencyValue, $baseCurrencyVal,$getFlightCost['totalChildCost']));        
                    $purchaseFlightBEpp = (convert_to_base($currencyValue, $baseCurrencyVal,$getFlightCost['totalInfantCost']));  
                    $flightAdult = $getFlightCost['adultPax'];
                    $flightChild = $getFlightCost['childPax'];
                    $flightInfant = $getFlightCost['infantPax'];

                    $purchaseFlightBA =  $purchaseFlightBApp*$flightAdult;
                    $purchaseFlightBC =  $purchaseFlightBCpp*$flightChild;
                    $purchaseFlightBE =  $purchaseFlightBEpp*$flightInfant;
                    if($getFlightCost['markupType']==2){
                    $pFlyFeeBA = $getFlightCost['markupCost']*$flightAdult;  
                    $pFlyFeeBC = $getFlightCost['markupCost']*$flightChild;
                    $pFlyFeeBE = $getFlightCost['markupCost']*$flightInfant;
                    }else{
                    $pFlyFeeBA = getMarkupCost($purchaseFlightBA,$getFlightCost['markupCost'],$getFlightCost['markupType']);  
                    $pFlyFeeBC = getMarkupCost($purchaseFlightBC,$getFlightCost['markupCost'],$getFlightCost['markupType']);
                    $pFlyFeeBE = getMarkupCost($purchaseFlightBE,$getFlightCost['markupCost'],$getFlightCost['markupType']);
                    }
                    $grandFPurchaseSBCost = $grandFPurchaseSBCost+($purchaseFlightBA+$purchaseFlightBE+$purchaseFlightBC);

                    $saleFlightBA = $purchaseFlightBA+$pFlyFeeBA;

                    // $flytaxAmountBA = getMarkupCost($pFlyFeeBA, $serviceTax, 1);
                    $flytcsAmountBA = getMarkupCost($saleFlightBA, $tcsTax, 1);

                    $flytaxAmountBA = getMarkupCost($saleFlightBA, $gstValue, 1);

                    $flyFinalCostBA = $saleFlightBA+$flytaxAmountBA+$flytcsAmountBA;
                    $totalFlyServiceBCostA = $totalFlyServiceBCostA + $flyFinalCostBA;

                    $totalSaleFlyBCost = $totalSaleFlyBCost+$saleFlightBA;
                    $flyServicePurchaseCost = $flyServicePurchaseCost + $purchaseFlightBApp;
                    $totalFProcessingFee = $totalFProcessingFee + $pFlyFeeBA;
                    $totalFServiceBTax = $totalFServiceBTax + $flytaxAmountBA;
                    $totalFServiceBTcs = $totalFServiceBTcs + $flytcsAmountBA;
                    $rowspan=0;
                    if($flightChild>0){
                        $rowspan = $rowspan+1;
                    }
                    if($flightInfant>0){
                        $rowspan = $rowspan+1;
                    }
                    ?>
                    <tr>
                    <td align="left" rowspan="<?php echo $rowspan+1; ?>" bgcolor="#deb887"><strong><?php echo getDestination($getFlightCost['arrivalTo']) ?></strong></td>
                    <td align="left" bgcolor="#deb887"><strong>Flight Services(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBApp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($flightAdult); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFlyFeeBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flytaxAmountBA); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flytcsAmountBA); ?></td>
                    <!-- <td align="right" bgcolor="#deb887"><?php if($flytcsAmountBA>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytcsAmountBA); } ?></td> -->
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flyFinalCostBA) ?></td>
                    </tr>
                    <?php 
               
                if($flightChild>0){
                    
                    $saleFlightBC = $purchaseFlightBC+$pFlyFeeBC;

                    // $flytaxAmountBC = getMarkupCost($pFlyFeeBC, $serviceTax, 1);
                    $flytcsAmountBC = getMarkupCost($saleFlightBC, $tcsTax, 1);

                    $flytaxAmountBC = getMarkupCost($saleFlightBC, $gstValue, 1);

                    $flyFinalCostBC = $saleFlightBC+$flytaxAmountBC+$flytcsAmountBC;
                    $totalFlyServiceBCostC = $totalFlyServiceBCostC + $flyFinalCostBC;

                    $totalSaleFlyBCost = $totalSaleFlyBCost+$saleFlightBC;
                    $flyServicePurchaseCost = $flyServicePurchaseCost + $purchaseFlightBCpp;
                    $totalFProcessingFee = $totalFProcessingFee + $pFlyFeeBC;
                    $totalFServiceBTax = $totalFServiceBTax + $flytaxAmountBC;
                    $totalFServiceBTcs = $totalFServiceBTcs + $flytcsAmountBC;
                    ?>
                    <tr>
                   
                    <td align="left" bgcolor="#deb887"><strong>Flight Services(Child)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBCpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($flightChild); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFlyFeeBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flytaxAmountBC); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flytcsAmountBC); ?></td>
                    <!-- <td align="right" bgcolor="#deb887"><?php if($flytcsAmountBC>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytcsAmountBC); } ?></td> -->
                   
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flyFinalCostBC) ?></td>
                    </tr>
                    <?php 
                }
               
                if($flightInfant>0){
                    
                
                    $saleFlightBE = $purchaseFlightBE+$pFlyFeeBE;

                    // $flytaxAmountBE = getMarkupCost($pFlyFeeBE, $serviceTax, 1);
                    $flytcsAmountBE = getMarkupCost($saleFlightBE, $tcsTax, 1);
                    $flytaxAmountBE = getMarkupCost($saleFlightBE, $gstValue, 1);
                    $flyFinalCostBE = $saleFlightBE+$flytaxAmountBE+$flytcsAmountBE;
                    $totalFlyServiceBCostE = $totalFlyServiceBCostE + $flyFinalCostBE;

                    $totalSaleFlyBCost = $totalSaleFlyBCost+$saleFlightBE;
                    $flyServicePurchaseCost = $flyServicePurchaseCost + $purchaseFlightBEpp;
                    $totalFProcessingFee = $totalFProcessingFee + $pFlyFeeBE;
                    $totalFServiceBTax = $totalFServiceBTax + $flytaxAmountBE;
                    $totalFServiceBTcs = $totalFServiceBTcs + $flytcsAmountBE;
                    ?>
                    <tr>
                   
                    <td align="left" bgcolor="#deb887"><strong>Flight Services(Infant)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBEpp); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo ($flightInfant); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($purchaseFlightBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($pFlyFeeBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($saleFlightBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flytaxAmountBE); ?></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($flytcsAmountBE); ?></td>
                    <!-- <td align="right" bgcolor="#deb887"><?php if($flytcsAmountBE>0){ echo $tcsTaxTaxLable.'&nbsp;|&nbsp;'.getTwoDecimalNumberFormat($flytcsAmountBE); } ?></td> -->
                   
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
                <th align="right"><?php echo getTwoDecimalNumberFormat($totalFlyServiceBCostA+$totalFlyServiceBCostC+$totalFlyServiceBCostE) ?></th>
            </tr>
            <tr>
                <td align="right" bgcolor="#ffff00">Per person Cost</td>
                <td align="right" bgcolor="#ffff00">Per Adult</td>
                <td  align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($totalFlyServiceBCostA)) ?></td>
                <td  align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($totalFlyServiceBCostA/$paxAdult)) ?></td>
                <td align="right" bgcolor="#ffff00">Per Child</td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalFlyServiceBCostC) ?></td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalFlyServiceBCostC/$paxChild) ?></td>
                <td align="right" bgcolor="#ffff00">Per Infant</td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalFlyServiceBCostE) ?></td>
                <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($totalFlyServiceBCostE/$paxInfant) ?></td>
    
            </tr>
            <?php
             $totalCompanyCost = $totalCompanyCost+$grandFPurchaseSBCost;
             $grandTotalMarkupCost = $grandTotalMarkupCost+$totalFProcessingFee;
             $grandTotalServiceTaxCost = $grandTotalServiceTaxCost + $totalFServiceBTax;
             $grandTotalTCSCost = $grandTotalTCSCost + $totalFServiceBTcs;
        }
    }
      ?> 
</table>

    <?php 
    $packageRateQueryBr="";
    $packageRateQueryBr=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="1" order by id asc');
    if(mysqli_num_rows($packageRateQueryBr) > 0){
        ?>
        <br>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="padding-top:10px; margin-top:10px; border-collapse: collapse;font-size:13px;">
        <tr>
            <td colspan="13" align="center"><strong>Land Package Cost</strong></td>
        </tr>
        <tr>
            <td align="right"><strong>Service&nbsp;Name</strong></td>
            <td align="right"><strong>Single</strong></td>
            <td align="right"><strong>Double</strong></td>
            <td align="right"><strong>Twin</strong></td>
            <td align="right"><strong>Triple</strong></td>
            <td align="right"><strong>Quad</strong></td>
            <td align="right"><strong>Six</strong></td>
            <td align="right"><strong>Eight</strong></td>
            <td align="right"><strong>Ten</strong></td>
            <td align="right"><strong>Extra&nbsp;Bed(A)</strong></td>
            <td align="right"><strong>Extra&nbsp;Bed(C)</strong></td>
            <td align="right"><strong>Child&nbsp;No&nbsp;Bed(C)</strong></td>
            <td align="right"><strong>Infant</strong></td>
            <td align="right"><strong>Tax</strong></td>
            <td align="right"><strong>TCS</strong></td>
            <td align="right"><strong>Markup</strong></td>
        </tr>

        <?php
        $getPackageData='';
        $singleBasisPR=$doubleBasisPR=$twinBasisPR=$tripleBasisPR=$quadBasisPR=$sixBedBasisPR=$eightBedBasisPR=$tenBedBasisPR=$extraBedABasisPR=$childwithbedBasisPR=$childwithoutbedBasisPR=$infantBedBasisPR=$teenBedBasisPR=0;
        while($getPackageData=mysqli_fetch_array($packageRateQueryBr)){
  
        $currencyId = $getPackageData['currencyId'];
        $currencyValue = $getPackageData['ROE'];
        $singleBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['singleBasis']);

        $sglMarkup = getMarkupCost($singleBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $sglTCS = (getMarkupCost(($singleBasisR+$sglMarkup),$tcsTax,1)*$singleRoom);
        $sglTax = (getMarkupCost(($singleBasisR+$sglMarkup),$getPackageData['serviceTax'],1)*$singleRoom);
        $singleBasisRMT = ($singleBasisR*$singleRoom);
        $sglMarkupTotal = ($sglMarkup*$singleRoom);
        $singleBasisPR = $singleBasisPR+($singleBasisRMT+$sglMarkupTotal+$sglTax+$sglTCS);

        $doubleBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['doubleBasis']);

        $dblMarkup = getMarkupCost($doubleBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $dblTCS = (getMarkupCost(($doubleBasisR+$dblMarkup),$tcsTax,1)*$doubleRoom);
        $dblTax = (getMarkupCost(($doubleBasisR+$dblMarkup),$getPackageData['serviceTax'],1)*$doubleRoom);
        $doubleBasisRMT = $doubleBasisRMT+($doubleBasisR*$doubleRoom);
        $dblMarkupTotal = ($dblMarkup*$doubleRoom);
        $doubleBasisPR = $doubleBasisPR+($doubleBasisRMT+$dblMarkupTotal+$dblTax+$dblTCS);
        
        $twinBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['twinBasis']);

        $twinMarkup = getMarkupCost($twinBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $twinTCS = (getMarkupCost(($twinBasisR+$twinMarkup),$tcsTax,1)*$twinRoom);
        $twinTax = (getMarkupCost(($twinBasisR+$twinMarkup),$getPackageData['serviceTax'],1)*$twinRoom);
        $twinBasisRMT = $twinBasisRMT+($twinBasisR*$twinRoom);
        $twinMarkupTotal = ($twinMarkup*$twinRoom);
        $twinBasisPR = $twinBasisPR+($twinBasisRMT+$twinMarkupTotal+$twinTax+$twinTCS);
        
        $tripleBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['tripleBasis']);

        $tplMarkup = getMarkupCost($tripleBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $tplTCS = (getMarkupCost(($tripleBasisR+$tplMarkup),$tcsTax,1)*$tripleRoom);
        $tplTax = (getMarkupCost(($tripleBasisR+$tplMarkup),$getPackageData['serviceTax'],1)*$tripleRoom);
        $tripleBasisRMT = $tripleBasisRMT+($tripleBasisR*$tripleRoom);
        $tplMarkupTotal = ($tplMarkup*$tripleRoom);
        $tripleBasisPR = $tripleBasisPR+($tripleBasisRMT+$tplMarkupTotal+$tplTax+$tplTCS);

        $quadBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['quadBasis']);

        $quadMarkup = getMarkupCost($quadBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $quadTCS = (getMarkupCost(($quadBasisR+$quadMarkup),$tcsTax,1)*$quadNoofBed);
        $quadTax = (getMarkupCost(($quadBasisR+$quadMarkup),$getPackageData['serviceTax'],1)*$quadNoofBed);
        $quadBasisRMT = $quadBasisRMT+($quadBasisR*$quadNoofBed);
        $quadMarkupTotal = ($quadMarkup*$quadNoofBed);
        $quadBasisPR = $quadBasisPR+($quadBasisRMT+$quadMarkupTotal+$quadTax+$quadTCS);
        
        $sixBedBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['sixBedBasis']);

        $sixMarkup = getMarkupCost($sixBedBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $sixTCS = (getMarkupCost(($sixBedBasisR+$sixMarkup),$tcsTax,1)*$sixNoofBed);
        $sixTax = (getMarkupCost(($sixBedBasisR+$sixMarkup),$getPackageData['serviceTax'],1)*$sixNoofBed);
        $sixBedBasisRMT = $sixBedBasisRMT+($sixBedBasisR*$sixNoofBed);
        $sixMarkupTotal = ($sixMarkup*$sixNoofBed);
        $sixBedBasisPR = $sixBedBasisPR+($sixBedBasisRMT+$sixMarkupTotal+$sixTax+$sixTCS);
        
        $eightBedBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['eightBedBasis']);

        $eightMarkup = getMarkupCost($eightBedBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $eightTCS = (getMarkupCost(($eightBedBasisR+$eightMarkup),$tcsTax,1)*$eightNoofBed);
        $eightTax = (getMarkupCost(($eightBedBasisR+$eightMarkup),$getPackageData['serviceTax'],1)*$eightNoofBed);
        $eightBedBasisRMT = $eightBedBasisRMT+($eightBedBasisR*$eightNoofBed);
        $eightMarkupTotal = ($eightMarkup*$eightNoofBed);
        $eightBedBasisPR = $eightBedBasisPR+($eightBedBasisRMT+$eightMarkupTotal+$eightTax+$eightTCS);
        
        $tenBedBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['tenBedBasis']);

        $tenMarkup = getMarkupCost($tenBedBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $tenTCS = (getMarkupCost(($tenBedBasisR+$tenMarkup),$tcsTax,1)*$tenNoofBed);
        $tenTax = (getMarkupCost(($tenBedBasisR+$tenMarkup),$getPackageData['serviceTax'],1)*$tenNoofBed);
        $tenBedBasisRMT = $tenBedBasisRMT+($tenBedBasisR*$tenNoofBed);
        $tenMarkupTotal = ($tenMarkup*$tenNoofBed);
        $tenBedBasisPR = $tenBedBasisPR+($tenBedBasisRMT+$tenMarkupTotal+$tenTax+$tenTCS);
        
        $extraBedABasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['extraBedABasis']);

        $EBAMarkup = getMarkupCost($extraBedABasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $EBATCS = (getMarkupCost(($extraBedABasisR+$EBAMarkup),$tcsTax,1)*$EBedAdult);
        $EBATax = (getMarkupCost(($extraBedABasisR+$EBAMarkup),$getPackageData['serviceTax'],1)*$EBedAdult);
        $extraBedABasisRMT = ($extraBedABasisR*$EBedAdult);
        $EBAMarkupTotal = ($EBAMarkup*$EBedAdult);
        $extraBedABasisPR = $extraBedABasisPR+($extraBedABasisRMT+$EBAMarkupTotal+$EBATax+$EBATCS);

        
        $childwithbedBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['childwithbedBasis']);

        $EBCMarkup = getMarkupCost($childwithbedBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $EBCTCS = (getMarkupCost(($childwithbedBasisR+$EBCMarkup),$tcsTax,1)*$EBedChild);
        $EBCTax = (getMarkupCost(($childwithbedBasisR+$EBCMarkup),$getPackageData['serviceTax'],1)*$EBedChild);
        $childwithbedBasisRMT = ($childwithbedBasisR*$EBedChild);
        $EBCMarkupTotal = ($EBCMarkup*$EBedChild);
        $childwithbedBasisPR = $childwithbedBasisPR+($childwithbedBasisRMT+$EBCMarkupTotal+$EBCTax+$EBCTCS);
        
        $childwithoutbedBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['childwithoutbedBasis']);

        $ENBCMarkup = getMarkupCost($childwithoutbedBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $ENBCTCS = (getMarkupCost(($childwithoutbedBasisR+$ENBCMarkup),$tcsTax,1)*$NBedChild);
        $ENBCTax = (getMarkupCost(($childwithoutbedBasisR+$ENBCMarkup),$getPackageData['serviceTax'],1)*$NBedChild);
        $childwithoutbedBasisRMT = ($childwithoutbedBasisR*$NBedChild);
        $ENBCMarkupTotal = ($ENBCMarkup*$NBedChild);
        $childwithoutbedBasisPR = $childwithoutbedBasisPR+($childwithoutbedBasisRMT+$ENBCMarkupTotal+$ENBCTax+$ENBCTCS);

        $infantBedBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['infantBedBasis']);

        $enfantMarkup = getMarkupCost($infantBedBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $enfantTCS = (getMarkupCost(($infantBedBasisR+$enfantMarkup),$tcsTax,1)*$infantNoofBed);
        $enfantTax = (getMarkupCost(($infantBedBasisR+$enfantMarkup),$getPackageData['serviceTax'],1)*$infantNoofBed);
        $infantBedBasisRMT = ($infantBedBasisR*$infantNoofBed);
        $enfantMarkupTotal = ($enfantMarkup*$infantNoofBed);
        $infantBedBasisPR = $infantBedBasisPR+($infantBedBasisRMT+$enfantMarkupTotal+$enfantTax+$enfantTCS);
        
        $teenBedBasisR = convert_to_base($currencyValue, $baseCurrencyVal,$getPackageData['teenBedBasis']);

        $teenMarkup = getMarkupCost($teenBedBasisR,$getPackageData['markupValue'],$getPackageData['markupType']);
        $teenTCS = (getMarkupCost(($teenBedBasisR+$teenMarkup),$tcsTax,1)*$teenNoofBed);
        $teenTax = (getMarkupCost(($teenBedBasisR+$teenMarkup),$getPackageData['serviceTax'],1)*$teenNoofBed);
        $teenBedBasisRMT = ($teenBedBasisR*$teenNoofBed);
        $teenMarkupTotal = ($teenMarkup*$teenNoofBed);
        $teenBedBasisPR = $teenBedBasisPR+($teenBedBasisRMT+$teenMarkupTotal+$teenTax+$teenTCS);
        
        ?>
<!-- teenBedBasisR -->
        <tr>
            <td align="right" bgcolor="#deb887"><?php echo $getPackageData['serviceName']; ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($singleBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($doubleBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($twinBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($tripleBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($quadBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($sixBedBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($eightBedBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($tenBedBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($extraBedABasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithbedBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childwithoutbedBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantBedBasisPR) ?></td>
            <td align="right" bgcolor="#deb887"><?php echo ($getPackageData['serviceTax']>0)?$getPackageData['serviceTax'].'%':''; ?></td>
            <td align="right" bgcolor="#deb887"><?php echo ($tcsTax>0)?$tcsTax.'%':''; ?></td>
            <td align="right" bgcolor="#deb887"><?php echo ($getPackageData['markupType']==1)?$getPackageData['markupValue'].'%':$getPackageData['markupValue'].'Flat'; ?></td>
            
        </tr>

        <?php
            $grandTotalMarkupCost = $grandTotalMarkupCost+($sglMarkupTotal+$dblMarkupTotal+$twinMarkupTotal+$tplMarkupTotal+$quadMarkupTotal+$sixMarkupTotal+$eightMarkupTotal+$tenMarkupTotal+$EBAMarkupTotal+$EBCMarkupTotal+$ENBCMarkupTotal+$enfantMarkupTotal+$teenMarkupTotal);
            $totalCompanyCost = $totalCompanyCost+($singleBasisRMT+$doubleBasisRMT+$twinBasisRMT+$tripleBasisRMT+$quadBasisRMT+$sixBedBasisRMT+$eightBedBasisRMT+$tenBedBasisRMT+$extraBedABasisRMT+$childwithbedBasisRMT+$childwithoutbedBasisRMT+$infantBedBasisRMT+$teenBedBasisRMT);
            $grandTotalServiceTaxCost = $grandTotalServiceTaxCost + ($sglTax+$dblTax+$twinTax+$tplTax+$quadTax+$sixTax+$eightTax+$tenTax+$EBATax+$EBCTax+$ENBCTax+$enfantTax+$teenTax);

            $grandTotalTCSCost = $grandTotalTCSCost + ($sglTCS+$dblTCS+$twinTCS+$tplTCS+$quadTCS+$sixTCS+$eightTCS+$tenTCS+$EBATCS+$EBCTCS+$ENBCTCS+$enfantTCS+$teenTCS);
              
        }
        ?>
        
<!-- teenBedBasisPR -->
         <tr>
            <td align="right" ><strong>Total</strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($singleBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($doubleBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($twinBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($tripleBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($quadBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($sixBedBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($eightBedBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($tenBedBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($extraBedABasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($childwithbedBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($childwithoutbedBasisPR) ?></strong></td>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($infantBedBasisPR) ?></strong></td>
            <td align="right" colspan="2"></td>
        </tr>
        <?php
    } 
    
    
    ?>
    </table>
        <!-- end Total tour cost -->
    <?php 
          $checkADDRateQuery="";
          $totaladultCostPP=0;
          $checkADDRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="2" and costTypeId="1"');
          $checkADDGRateQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="2" and costTypeId="2"');
              if(mysqli_num_rows($checkADDRateQuery) > 0 || mysqli_num_rows($checkADDGRateQuery)>0){
                ?>
        <br>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="padding-top:10px; margin-top:10px; border-collapse: collapse;font-size:13px;">
        <tr>
            <td colspan="10" align="center"><strong>Additional Cost</strong></td>
        </tr>
        <tr>
            <td align="right"><strong>Service&nbsp;Name</strong></td>
            <td align="right"><strong>Service&nbsp;Type</strong></td>
            <td align="right"><strong>Purchase Cost</strong></td>
            <td align="right"><strong>Pax</strong></td>
            <td align="right"><strong>Total Cost</strong></td>
            <td align="right"><strong>Markup Cost</strong></td>
            <td align="right"><strong>Sale Cost</strong></td>
            <td align="right"><strong>Tax</strong></td>
            <td align="right"><strong>TCS</strong></td>
            <td align="right"><strong>Final Cost</strong></td>
        </tr>
                <?php
                $getAddiRateData='';
                  while($getAddiRateData=mysqli_fetch_array($checkADDRateQuery)){
        
                        $currencyId = $getAddiRateData['currencyId'];
                        $currencyValue = $getAddiRateData['currencyValue'];
      
                        $adultPaxAD = $getAddiRateData['adultPax'];
                        $ChildPaxAD = $getAddiRateData['ChildPax'];
                        $infantPaxAD = $getAddiRateData['infantPax'];
      
                      if($getAddiRateData['costTypeId']==1){
                          $adultCost = convert_to_base($getAddiRateData['ROE'], $baseCurrencyVal,$getAddiRateData['adultCost']);
                          $childCost = convert_to_base($getAddiRateData['ROE'], $baseCurrencyVal,$getAddiRateData['ChildCost']);
                          $infantCost = convert_to_base($getAddiRateData['ROE'], $baseCurrencyVal,$getAddiRateData['infantCost']);
                      }
                        // Adult Cost
                      $totalPurchaseA = $adultCost*$getAddiRateData['adultPax'];
                      $adultMarkup = getMarkupCost($adultCost,$getAddiRateData['markupValue'],$getAddiRateData['markupType']);
                      $totalMarkupA = $adultMarkup*$getAddiRateData['adultPax'];
                      $totalSaleCostA=$totalPurchaseA+$totalMarkupA;
                      $totalTaxCostA = getMarkupCost($totalSaleCostA,$getAddiRateData['serviceTax'],1);
                      $totalTCSCostA = getMarkupCost($totalSaleCostA,$tcsTax,1);

                      $finalCostA = $totalSaleCostA+$totalTaxCostA+$totalTCSCostA;
                      
                    // Child Cost
                    $totalPurchaseC = $childCost*$getAddiRateData['ChildPax'];
                    $childMarkup = getMarkupCost($childCost,$getAddiRateData['markupValue'],$getAddiRateData['markupType']);
                    $totalMarkupC = $childMarkup*$getAddiRateData['ChildPax'];
                    $totalSaleCostC=$totalPurchaseC+$totalMarkupC;
                    $totalTaxCostC = getMarkupCost($totalSaleCostC,$getAddiRateData['serviceTax'],1);
                    $totalTCSCostC = getMarkupCost($totalSaleCostC,$tcsTax,1);

                    $finalCostC = $totalSaleCostC+$totalTaxCostC+$totalTCSCostC;
                    // Infant Cost
                    $totalPurchaseE = $infantCost*$getAddiRateData['infantPax'];
                    $infantMarkup = getMarkupCost($infantCost,$getAddiRateData['markupValue'],$getAddiRateData['markupType']);
                    $totalMarkupE = $infantMarkup*$getAddiRateData['infantPax'];
                    $totalSaleCostE=$totalPurchaseE+$totalMarkupE;
                    $totalTaxCostE = getMarkupCost($totalSaleCostE,$getAddiRateData['serviceTax'],1);
                    $totalTCSCostE = getMarkupCost($totalSaleCostE,$tcsTax,1);

                    $finalCostE = $totalSaleCostE+$totalTaxCostE+$totalTCSCostE;
                  
                  
                    $grandADDAMTPP = $grandADDAMTPP+($adultCost+$childCost+$infantCost);
                    $grandADDAMTGP = $grandADDAMTGP+($totalPurchaseA+$totalPurchaseC+$totalPurchaseE);
                    $grandADDAMTM = $grandADDAMTM+($totalMarkupA+$totalMarkupC+$totalMarkupE);
                    $grandADDAMTS = $grandADDAMTS+($totalSaleCostA+$totalSaleCostC+$totalSaleCostE);
                    $grandADDAMTTAX = $grandADDAMTTAX+($totalTaxCostA+$totalTaxCostC+$totalTaxCostE);
                    $grandADDAMTTCS = $grandADDAMTTCS+($totalTCSCostA+$totalTCSCostC+$totalTCSCostE);
                    $finalACE = $finalACE+($finalCostA+$finalCostC+$finalCostE);
                    $GAdultCost = $GAdultCost+$finalCostA;
                    $GChildCost = $GChildCost+$finalCostC;
                    $GInfantCost = $GInfantCost+$finalCostE;
                    ?>
                    <tr>
                        <td align="right" bgcolor="#deb887" rowspan="3"><?php echo $getAddiRateData['serviceName']; ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo 'Additional Service(Adult)'; ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($adultCost) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($getAddiRateData['adultPax']) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalPurchaseA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalMarkupA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSaleCostA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTaxCostA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTCSCostA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($finalCostA) ?></td>
                    </tr>
                    <tr>
                       
                        <td align="right" bgcolor="#deb887"><?php echo 'Additional Service(Child)'; ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($childCost) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($getAddiRateData['ChildPax']) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalPurchaseC) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalMarkupC) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSaleCostC) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTaxCostC) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTCSCostC) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($finalCostC) ?></td>
                    </tr>
                    <tr>
                        
                        <td align="right" bgcolor="#deb887"><?php echo 'Additional Service(Infant)'; ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($infantCost) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($getAddiRateData['infantPax']) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalPurchaseE) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalMarkupE) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSaleCostE) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTaxCostE) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTCSCostE) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($finalCostE) ?></td>
                    </tr>
                   
                   <?php } }
                   $totaladultCostPP=0;
                   $checkADDGQuery=GetPageRecord('*','packageWiseRateMaster',' quotationId="'.$quotationId.'" and serviceType="2" and costTypeId="2"');
                       if(mysqli_num_rows($checkADDGQuery) > 0){
                        while($getAddGRateData=mysqli_fetch_array($checkADDGQuery)){
                            if($getAddGRateData['costTypeId']==2){
                      
                                $groupCost = convert_to_base($getAddGRateData['ROE'], $baseCurrencyVal,$getAddGRateData['groupCost']);
                                $adultGCost= $groupCost/$totalPax;
                                }
                                    // Adult Cost
                      $totalPurchaseGA = $adultGCost*$totalPax;
                      $adultMarkupG = getMarkupCost($adultGCost,$getAddGRateData['markupValue'],$getAddGRateData['markupType']);
                      $totalMarkupGA = $adultMarkupG*$totalPax;
                      $totalSaleCostGA=$totalPurchaseGA+$totalMarkupGA;
                      $totalTaxCostGA = getMarkupCost($totalSaleCostGA,$getAddGRateData['serviceTax'],1);
                      $totalTCSCostGA = getMarkupCost($totalSaleCostGA,$tcsTax,1);

                      $finalCostGA = $totalSaleCostGA+$totalTaxCostGA+$totalTCSCostGA;
                      $groupPPCost = $groupPPCost + $finalCostGA/$totalPax;
                    ?>
                    <tr>
                        <td align="right" bgcolor="#deb887"><?php echo $getAddGRateData['serviceName'];; ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo 'Additional Service(Group Cost)'; ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($adultGCost) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalPax) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalPurchaseGA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalMarkupGA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalSaleCostGA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTaxCostGA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalTCSCostGA) ?></td>
                        <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($finalCostGA) ?></td>
                    </tr>
                    <?php
                        $grandADDAMTPP= $grandADDAMTPP+$adultGCost;
                        $grandADDAMTGP= $grandADDAMTGP+$totalPurchaseGA;
                        $grandADDAMTM= $grandADDAMTM+$totalMarkupGA;
                        $grandADDAMTS= $grandADDAMTS+$totalSaleCostGA;
                        $grandADDAMTTAX= $grandADDAMTTAX+$totalTaxCostGA;
                        $grandADDAMTTCS= $grandADDAMTTCS+$totalTCSCostGA;
                        $finalACE= $finalACE+$finalCostGA;
                        }
                        $GAdultCost = $GAdultCost+($groupPPCost*$paxAdult);
                        $GChildCost = $GChildCost+($groupPPCost*$paxChild);
                        $GInfantCost = $GInfantCost+($groupPPCost*$paxInfant);
                       }
                       
                       if(mysqli_num_rows($checkADDGQuery) || mysqli_num_rows($checkADDRateQuery)){
                   ?>
                    <tr>
                        <td align="right" colspan="2"><strong>Total</strong></td>
                        <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandADDAMTPP) ?></strong></td>
                        <td align="right"><strong>&nbsp;</strong></td>
                        <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandADDAMTGP) ?></strong></td>
                        <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandADDAMTM) ?></strong></td>
                        <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandADDAMTS) ?></strong></td>
                        <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandADDAMTTAX) ?></strong></td>
                        <td align="right"><strong><?php echo getTwoDecimalNumberFormat($grandADDAMTTCS) ?></strong></td>
                        <td align="right"><strong><?php echo getTwoDecimalNumberFormat($finalACE) ?></strong></td>
                    </tr>
                    <tr style="border: none;">
                        <td align="right" bgcolor="#ffff00">Per Person Cost</td>
                        <td align="right" bgcolor="#ffff00">Per Adult</td>
                        <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($GAdultCost) ?></td>
                        <td align="right"  bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($GAdultCost/$paxAdult)) ?></td>
                        <td align="right" bgcolor="#ffff00">Per Child</td>
                        <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($GChildCost) ?></td>
                        <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($GChildCost/$paxChild)) ?></td>
                        <td align="right" bgcolor="#ffff00">Per Infant</td>
                        <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat($GInfantCost) ?></td>
                        <td align="right" bgcolor="#ffff00"><?php echo getTwoDecimalNumberFormat(($GInfantCost/$paxInfant)) ?></td>
                    </tr>
                    </table>
                    <?php
                      $totalCompanyCost = $totalCompanyCost+$grandADDAMTGP;
                      $grandTotalMarkupCost = $grandTotalMarkupCost+$grandADDAMTM;
                      $grandTotalServiceTaxCost = $grandTotalServiceTaxCost + $grandADDAMTTAX;
                      $grandTotalTCSCost = $grandTotalTCSCost + $grandADDAMTTCS;
                    } 
                    ?>
    </td>
</tr>
</table>
<!-- Break up cost block Ends-->
        <?php 
        $clientCost = ${"proposalCost".$val} = $grandTotalCost; 
        $clientMarginCost = $grandTotalMarkupCost;
        $nameinv = 'totalCompanyPackageCost="'.$grandPackageTotalCost.'",totalCompanyCost="'.$totalCompanyCost.'",totalQuotCost="'.$clientCost.'",totalMarkupCost="'.$grandTotalMarkupCost.'",totalDiscountCost="'.$grandTotalDiscountCost.'",totalServiceTaxCost="'.$grandTotalServiceTaxCost.'",totalTCSCost="'.$grandTotalTCSCost.'",sglBasisCost="'.${"ppCostONSingleBasis".$val}.'",dblBasisCost="'.${"ppCostONDoubleBasis".$val}.'",twinCost="'.${"ppCostONTwinBasis".$val}.'",tplBasisCost="'.${"ppCostOnTripleBasis".$val}.'",quadBasisCost="'.${"ppCostOnQuadBasis".$val}.'",extraAdultCost="'.${"ppCostOnExtraBedABasis".$val}.'",CWBCost="'.${"pcCostOnExtraBedCBasis".$val}.'",CNBCost="'.${"pcCostOnExtraNBedCBasis".$val}.'",infantBasisCost="'.${"peCostBasis".$val}.'"';
        updatelisting(_QUOTATION_MASTER_,$nameinv,'id="'.$quotationId.'"');
        ?>
        <!-- end basis wiose cost -->
    </td>

    <?php if($quotationType==1){ ?>
    <!-- <td width="2%">&nbsp;&nbsp;&nbsp;&nbsp;</td> -->
    <td width="25%" valign="top">
    <div style="text-align:left;font-size: 18px;margin: 0;padding: 8px 8px 8px 0;"><strong>General Information</strong></div>
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
     <!--    <tr>
        <td align="right" bgcolor="#ddd" ><strong>Local&nbsp;Escort&nbsp;Pax</strong></td>
        <td align="right" ><?php echo $paxAdultLE; ?></td> 
        </tr>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Foreign&nbsp;Escort&nbsp;Pax</strong></td>
        <td align="right" ><?php echo $paxAdultFE; ?></td> 
        </tr> -->
        <tr>
        <td align="right" colspan="2" bgcolor="#ddd" ></td>
        </tr>
        <?php if( $singleRoom >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Single&nbsp;Room</strong></td>
        <td align="right" ><?php echo $singleRoom; ?></td> 
        </tr>
        <?php } if( $doubleRoom >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Double&nbsp;Room</strong></td>
        <td align="right" ><?php echo $doubleRoom; ?></td> 
        </tr>
        <?php } if( $tripleRoom >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Triple&nbsp;Room</strong></td>
        <td align="right" ><?php echo $tripleRoom; ?></td> 
        </tr>
        <?php } if( $twinRoom >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Twin&nbsp;Room</strong></td>
        <td align="right" ><?php echo $twinRoom; ?></td> 
        </tr>
        <?php } if( $EBedAdult >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Extra-Bed(A)</strong></td>
        <td align="right" ><?php echo $EBedAdult; ?></td> 
        </tr>
        <?php }  if( $quadNoofBed >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Quad&nbsp;Room</strong></td>
        <td align="right" ><?php echo $quadNoofBed; ?></td> 
        </tr>
        <?php } if( $EBedChild >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>ChildWBed</strong></td>
        <td align="right" ><?php echo $EBedChild; ?></td> 
        </tr>
        <?php } if( $NBedChild >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>ChildNBed</strong></td>
        <td align="right" ><?php echo $NBedChild; ?></td> 
        </tr>
        <?php } if( $infantNoofBed >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Infant&nbsp;Bed</strong></td>
        <td align="right" ><?php echo $infantNoofBed; ?></td> 
        </tr>
        <?php } if( $teenNoofBed >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Teen&nbsp;Room</strong></td>
        <td align="right" ><?php echo $teenNoofBed; ?></td> 
        </tr>
        <?php } if( $sixNoofBed >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Six&nbsp;Bed&nbsp;Room</strong></td>
        <td align="right" ><?php echo $sixNoofBed; ?></td> 
        </tr>
        <?php } if( $eightNoofBed >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Eight&nbsp;Bed&nbsp;Room</strong></td>
        <td align="right" ><?php echo $eightNoofBed; ?></td> 
        </tr>
        <?php } if( $tenNoofBed >0){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Ten&nbsp;Bed&nbsp;Room</strong></td>
        <td align="right" ><?php echo $tenNoofBed; ?></td> 
        </tr>
        <?php } ?>
        <tr>
        <td align="right" colspan="2" bgcolor="#ddd" ></td>
        </tr>
 
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>
        <?php
        if ($discountType == 1) {
            echo'Discount(%)';
        }else{
            echo'Discount(Flat)';
        } 
        ?>
        </strong></td>
        <td align="right" ><?php echo $discount; ?></td> 
        </tr> 
    </table>
    <hr>
    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;border-collapse: collapse;">
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Client&nbsp;Cost(In <?php echo getCurrencyName($currencyId); ?>)</strong></td>
        <td align="right" ><?php echo getTwoDecimalNumberFormat($clientCost)?></td> 
        </tr>
        <?php if($paxAdultLE<1 && $paxAdultFE<1 ){ ?>
        <tr>
        <td align="right" bgcolor="#ddd" ><strong>Supplier&nbsp;Cost</strong></td>
        <td align="right" ><?php echo getTwoDecimalNumberFormat($totalCompanyCost); ?></td> 
        </tr>
         <tr>
        <td align="right" bgcolor="#ddd" ><strong>Margin</strong></td>
        <td align="right" ><?php echo getTwoDecimalNumberFormat($clientMarginCost); ?></td> 
        </tr>
        <?php } ?> 
    </table>  
    
    </td>
    <?php } ?> 
</tr>
</table> 
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
