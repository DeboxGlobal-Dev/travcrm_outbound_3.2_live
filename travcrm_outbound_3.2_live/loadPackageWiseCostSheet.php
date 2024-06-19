<?php
// FOR USE SAME FILE IN PROPOSALS and FIT 
if(isset($_REQUEST['quotationId'])){
    
    include("inc.php");

    $quotationId = $_REQUEST['quotationId'];
    
    $rsp = "";
    $rsp = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.$quotationId.'"');
    $resultpageQuotation = mysqli_fetch_array($rsp);

    $rs = '';
    $rs = GetPageRecord('*', _QUERY_MASTER_, 'id='.($resultpageQuotation['queryId']).'');
    $resultpage = mysqli_fetch_array($rs);

}
// No CATEGORY IN SINGLE HHOTEL CATEGORY QUOTATION AND FIT QUOTATION
$multihotelQuery = $MultiQuotPreview = $val = "";

$slabAndRoomType = $resultpageQuotation['slabAndRoomType'];
$calculationType = $resultpageQuotation['calculationType'];
$quotationId = $resultpageQuotation['id'];
$queryId = $resultpage['id'];
$quotPreviewId = makeQuotationId($quotationId).$MultiQuotPreview;

$paxAdult = ($resultpageQuotation['adult']);
$paxChild = ($resultpageQuotation['child']);
$paxInfant = ($resultpageQuotation['infant']);
$totalPax = ($paxAdult + $paxChild + $paxInfant);
if($totalPax == 0){
    $totalPax =  2;
}

$moduleType = $resultpage['moduleType'];
$singleRoom = $resultpageQuotation['sglRoom'];
$doubleRoom = $resultpageQuotation['dblRoom'];
$twinRoom   = $resultpageQuotation['twinRoom'];
$tripleRoom = $resultpageQuotation['tplRoom'];
$quadBedRoom = $resultpageQuotation['quadNoofRoom'];
$sixBedRoom = $resultpageQuotation['sixNoofBedRoom'];
$eightBedRoom = $resultpageQuotation['eightNoofBedRoom'];
$tenBedRoom = $resultpageQuotation['tenNoofBedRoom'];
$teenBedRoom = $resultpageQuotation['teenNoofRoom'];
$EBedChild = $resultpageQuotation['childwithNoofBed'];
$NBedChild = $resultpageQuotation['childwithoutNoofBed'];
$EBedAdult = $resultpageQuotation['extraNoofBed'];

$isChildBFQ = $resultpageQuotation['isChildBreakfast'];
$isChildDNQ = $resultpageQuotation['isChildDinner'];
$isChildLHQ = $resultpageQuotation['isChildLunch'];

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
$newCurr = ($resultpageQuotation['currencyId']>0)?$resultpageQuotation['currencyId']:$baseCurrencyId;

// GST DATA 
$serviceTax = ($resultpageQuotation['serviceTax']>0)?$resultpageQuotation['serviceTax']:0;
 
if ($resultpageQuotation['tcs']>0){
    $tcsTax = $resultpageQuotation['tcs'];
} else {
    $tcsTax = 0;
}

$totalServiceTax=0;
$totalServiceTax = $tcsTax+$serviceTax;

// Commission DATA
$commissionType = $resultpageQuotation['commissionType'];
$ISOCommission = $resultpageQuotation['ISOCommission'];
$ConsortiaCommission = $resultpageQuotation['ConsortiaCommission'];
$ClientCommission = $resultpageQuotation['ClientCommission'];
$tcs = $resultpageQuotation['tcs'];

// DISCOUNT DATA
$discountType = $resultpageQuotation['discountType'];
$discount = $resultpageQuotation['discount'];

// MARKUP DAta
$c12 = GetPageRecord('*', 'quotationServiceMarkup', ' quotationId="' . $quotationId . '"');
$serviceMarkuD = mysqli_fetch_array($c12);

$isUni_Mark = $resultpageQuotation['isUni_Mark'];
$isSer_Mark = $resultpageQuotation['isSer_Mark'];

if($isSer_Mark == 1 && $isUni_Mark == 0){
    $hotel = $serviceMarkuD['hotel'];
    $hotelMarkupType = $serviceMarkuD['hotelMarkupType'];
    $transfer = $serviceMarkuD['transfer'];
    $transferMarkupType = $serviceMarkuD['transferMarkupType'];
    $ferry = $serviceMarkuD['ferry'];
    $ferryMarkupType = $serviceMarkuD['ferryMarkupType'];
    $train = $serviceMarkuD['train'];
    $trainMarkupType = $serviceMarkuD['trainMarkupType'];
    $flight = $serviceMarkuD['flight'];
    $flightMarkupType = $serviceMarkuD['flightMarkupType'];
    $guide = $serviceMarkuD['guide'];
    $guideMarkupType = $serviceMarkuD['guideMarkupType'];
    $activity = $serviceMarkuD['activity'];
    $activityMarkupType = $serviceMarkuD['activityMarkupType'];
    $entrance = $serviceMarkuD['entrance'];
    $entranceMarkupType = $serviceMarkuD['entranceMarkupType'];
    $restaurant = $serviceMarkuD['restaurant'];
    $restaurantMarkupType = $serviceMarkuD['restaurantMarkupType'];
    $visa = $serviceMarkuD['visa'];
    $visaMarkupType = $serviceMarkuD['visaMarkupType'];
    $passport = $serviceMarkuD['passport'];
    $passportMarkupType = $serviceMarkuD['passportMarkupType'];
    $insurance = $serviceMarkuD['insurance'];
    $insuranceMarkupType = $serviceMarkuD['insuranceMarkupType'];
    $other = $serviceMarkuD['other']; 
    $otherMarkupType = $serviceMarkuD['otherMarkupType']; 
    // $markupType = $serviceMarkuD['hotelMarkupType'];
}else{
    $serviceMarkup = $serviceMarkuD['hotel'];
    $markupType = $serviceMarkuD['hotelMarkupType'];
}

$checkPackageRateQuery="";
$checkPackageRateQuery=GetPageRecord('*','packageWiseRateMaster',' queryId="'.$queryId.'"');
if(mysqli_num_rows($checkPackageRateQuery) > 0){
    $getPackageRateData=mysqli_fetch_array($checkPackageRateQuery); 
    $editId = $getPackageRateData['id'];

    $totalsingle = clean($getPackageRateData['singleCost']);
    $totaldouble = clean($getPackageRateData['doubleCost']*2);
    $totalTriple = clean($getPackageRateData['tripleCost']*3);
    $totalquad = clean($getPackageRateData['quadCost']*4);
    $totalsixBed = clean($getPackageRateData['sixBedCost']*6);
    $totaleightBed = clean($getPackageRateData['eightBedCost']*8);
    $totaltenBed = clean($getPackageRateData['tenBedCost']*10);
    $totalteenBed = clean($getPackageRateData['teenBedCost']);
    $totalextraBedA = clean($getPackageRateData['extraBedACost']);
    $totalextraBedC = clean($getPackageRateData['childwithbedCost']);
    $totalextraNBedC = clean($getPackageRateData['childwithoutbedCost']);

    $totalguideA = clean($getPackageRateData['guideA']);
    $totalactivityA = clean($getPackageRateData['activityA']);
    $totalentranceA = clean($getPackageRateData['entranceA']);
    $totaltransferA = clean($getPackageRateData['transferA']);
    $totaltrainA = clean($getPackageRateData['trainA']);
    $totalflightA = clean($getPackageRateData['flightA']);
    $totalrestaurantA = clean($getPackageRateData['restaurantA']);
    $totalotherA = clean($getPackageRateData['otherA']);

    $totalguideC = clean($getPackageRateData['guideC']);
    $totalactivityC = clean($getPackageRateData['activityC']);
    $totalentranceC = clean($getPackageRateData['entranceC']);
    $totaltransferC = clean($getPackageRateData['transferC']);
    $totaltrainC = clean($getPackageRateData['trainC']);
    $totalflightC = clean($getPackageRateData['flightC']);
    $totalrestaurantC = clean($getPackageRateData['restaurantC']);
    $totalotherC = clean($getPackageRateData['otherC']);

    $singleBasis = clean($getPackageRateData['singleBasis']);
    $doubleBasis = clean($getPackageRateData['doubleBasis']);
    $tripleBasis = clean($getPackageRateData['tripleBasis']);
    $quadBasis = clean($getPackageRateData['quadBasis']);
    $sixBedBasis = clean($getPackageRateData['sixBedBasis']);
    $eightBedBasis = clean($getPackageRateData['eightBedBasis']);
    $tenBedBasis = clean($getPackageRateData['tenBedBasis']);
    $teenBedBasis = clean($getPackageRateData['teenBedBasis']);
    $extraBedABasis = clean($getPackageRateData['extraBedABasis']);
    $childwithbedBasis = clean($getPackageRateData['childwithbedBasis']);
    $childwithoutbedBasis = clean($getPackageRateData['childwithoutbedBasis']);
} 

// function getPerPersonBasisCost($ppCostONXYZBasis,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs){
//     if($serviceMarkup!= 0 && $isUni_Mark==1) {
//       $ppCostONXYZBasisMarkup = getMarkupCost($ppCostONXYZBasis, $serviceMarkup, $markupType);  // single markup
//       $ppCostONXYZBasis = $ppCostONXYZBasis + $ppCostONXYZBasisMarkup; //single with markup
//     }
//     if($ISOCommission!= 0) {
//       $ppCostONXYZBasisISOCommission = getMarkupCost($ppCostONXYZBasis, $ISOCommission, $markupType);  // single markup
//       $ppCostONXYZBasis = $ppCostONXYZBasis + $ppCostONXYZBasisISOCommission; //single with markup
//     }
//     if($ConsortiaCommission!= 0) {
//       $ppCostONXYZBasisConsortiaCommission = getMarkupCost($ppCostONXYZBasis, $ConsortiaCommission, $markupType);  // single markup
//       $ppCostONXYZBasis = $ppCostONXYZBasis + $ppCostONXYZBasisConsortiaCommission; //single with markup
//     }
//     if($ClientCommission!= 0) {
//       $ppCostONXYZBasisClientCommission = getMarkupCost($ppCostONXYZBasis, $ClientCommission, $markupType);  // single markup
//       $ppCostONXYZBasis = $ppCostONXYZBasis + $ppCostONXYZBasisClientCommission; //single with markup
//     }
//     if ($discount>0) {
//       $ppCostONXYZBasisDiscount = getMarkupCost($ppCostONXYZBasis, $discount, $discountType);  // single Discount
//       $ppCostONXYZBasis = $ppCostONXYZBasis - $ppCostONXYZBasisDiscount; //single with Discount
//     }
//     if ($serviceTax>0) {
//       $ppCostONXYZBasisTax = getMarkupCost($ppCostONXYZBasis, $serviceTax, 1);  // single Discount
//     }
//     if ($tcs>0) {
//       $ppCostONXYZBasistcs = getMarkupCost($ppCostONXYZBasis, $tcs, 1);  // single Discount
//     }
//     $ppCostONXYZBasis = $ppCostONXYZBasis + $ppCostONXYZBasisTax + $ppCostONXYZBasistcs; //single with Discount
//     return getTwoDecimalNumberFormat($ppCostONXYZBasis); 
// }


// END QUOTATION DATA CONTAINERS 
if(isset($_REQUEST['quotationId'])){
    ?> 
    <h1 style="text-align:left; position:relative;">Cost&nbsp;Sheet&nbsp;|&nbsp;<?php echo $quotPreviewId; ?>
    <?php if($_REQUEST['export']!='yes'){ ?>
    <a href="loadPackageWiseCostSheet.php?export=yes&quotationId=<?php echo $_REQUEST['quotationId']; ?>&finalcategory=<?php echo $_REQUEST['finalcategory']; ?>" style="position:absolute; right:3px; top:2px;">
    <input name="Cancel" type="button" class="whitembutton"  value="Export"  style="background-color: #fff !important; padding: 4px 20px;"></a>
    <?php } ?>
    </h1>
    <table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">
       <tr>
         <td width="10%" align="left" valign="middle"><strong>Tour Id : </strong></td>
         <td align="left" valign="middle"><?php
         if($resultpage['queryStatus'] == 3){
            echo makeQueryTourId($resultpage['id']);
         }
        ?></td>
          <td width="10%" align="left" valign="middle"><strong>Operation Person </strong></td>
          <td align="left" valign="middle"><?php echo getUserName($resultpage['assignTo']); ?></td>
      </tr>



      <tr>
        <td align="left" valign="middle"><strong>Arrival Date :</strong></td>
        <td align="left" valign="middle"><?php
            echo date('j F, Y', strtotime($resultpage['fromDate']));
        ?></td>
        <td align="left" valign="middle"><strong>Sales Person </strong></td>
        <td align="left" valign="middle"><?php echo trim($resultpage['salesassignTo']);?></td>
      </tr>
      <tr>



        <td align="left" valign="middle"><strong>Agent Name: </strong></td>



        <td align="left" valign="middle"><?php
        echo showClientTypeUserName($resultpage['clientType'], $resultpage['companyId']);
        ?></td>



        <td align="left" valign="middle"><strong>R.O.E:</strong></td>
        <td align="left" valign="middle"><?php
            echo getCurrencyName($baseCurrencyId);
            ?>&nbsp;<?php
            echo $resultpageQuotation['dayroe'];
            ?>&nbsp;As&nbsp;on:&nbsp;
            <?php
            if (date('d-m-Y', strtotime($resultpageQuotation['asOnDate'])) == "01-01-1970") {
                echo date('d-m-Y');
            } else {
                echo date('d-m-Y', strtotime($resultpageQuotation['asOnDate']));
            }
            ?>
        </td>
        </tr>



        <tr>



        <td align="left" valign="middle"><strong>Lead Pax Name </strong></td>



        <td align="left" valign="middle"><?php
        echo trim($resultpage['leadPaxName']);
        ?></td>



        <td align="left" valign="middle"><strong>Printed On:</strong></td>
        <td align="left" valign="middle"><?php
        echo date('d-m-Y h:i A');
        ?></td>
      </tr>
    </table>
    <?php 
} ?>
<div style="padding-top:10px; margin-top:10px; border-top:1px solid #ccc;">

    <!-- Cost sheet service list -->
    <!-- START PER PAX BLOCK --> 
    <table width="100%" cellpadding="0" cellspacing="0" >
    <tr>
        <td valign="top" width="40%">
            <div style="text-align:left;font-size: 18px;margin: 0;"><strong>Per Pax Cost</strong></div>
            <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000"  style="font-size:12px;"> 
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PARTICULARS</strong></td>
                    <?php
                    $totalPaxFE = $totalPaxLE = $totalpaxA= $totalpaxC = 0;
                    ?>
                    <td align="center" colspan="2" bgcolor="#F5F5F5"><strong><?php echo $paxrange."&nbsp;PAX( D.F-".$dividingFactor.")";?></strong></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="center" colspan="<?php echo ($paxAdultLE+$paxAdultFE);?>" bgcolor="#F5F5F5"><strong>ESCORTS</strong></td>
                    <?php } ?>
                  </tr>
                   <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong></strong></td>
                    <td align="center" bgcolor="#deb887" ><strong>ADULT&nbsp;COST</strong></td>
                    <td align="center" bgcolor="#deb887" ><strong>CHILD&nbsp;COST</strong></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="center" bgcolor="#dec7c7"><strong>LOCAL</strong></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="center" bgcolor="#d4d5f0"><strong>FORIEGN</strong></td>
                    <?php } ?>
                  </tr>
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>RESTAURANT</strong></td>
                    <?php 
                    $totalrestaurantALE = getMarkupCost($totalrestaurantA,$restaurantCostLE,$restaurantCalTypeLE);
                    $totalrestaurantAFE = getMarkupCost($totalrestaurantA,$restaurantCostFE,$restaurantCalTypeFE);
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalrestaurantA); $totalpaxA = $totalpaxA + $totalrestaurantA;?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalrestaurantC); $totalpaxC = $totalpaxC + $totalrestaurantC;?></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalrestaurantALE); $totalPaxLE = $totalPaxLE + $totalrestaurantALE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalrestaurantAFE); $totalPaxFE = $totalPaxFE + $totalrestaurantAFE;?></td>
                    <?php } ?>
                </tr>

                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>TRAIN</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat($totaltrainA); 
                        $totalpaxA = $totalpaxA + $totaltrainA;

                        $totaltrainALE = getMarkupCost($totaltrainA,$trainCostLE,$trainCalTypeLE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        $totaltrainAFE = getMarkupCost($totaltrainA,$trainCostFE,$trainCalTypeFE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        
                        ?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totaltrainC); $totalpaxC = $totalpaxC + $totaltrainC;?></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat($totaltrainALE);$totalPaxLE=$totalPaxLE+$totaltrainALE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totaltrainAFE); $totalPaxFE = $totalPaxFE + $totaltrainAFE;?></td>
                    <?php } ?>
                </tr>

                <?php
                if ($resultpageQuotation['flightCostType'] == 0) {
                ?>
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>FLIGHT</strong></td>
                    <td align="right"  bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat($totalflightA); 
                        $totalpaxA = $totalpaxA + $totalflightA;
                        
                        $totalflightALE = getMarkupCost($totalflightA,$flightCostLE,$flightCalTypeLE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        $totalflightAFE = getMarkupCost($totalflightA,$flightCostFE,$flightCalTypeFE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        ?>
                        
                    </td>
                    <td align="right"  bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalflightC); $totalpaxC = $totalpaxC + $totalflightC;?></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalflightALE); $totalPaxLE = $totalPaxLE + $totalflightALE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalflightAFE); $totalPaxFE = $totalPaxFE + $totalflightAFE;?></td>
                    <?php } ?>
                </tr>
                <?php
                }
                ?>

                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>TRANSPORT</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php    
                    echo getTwoDecimalNumberFormat($totaltransferA);
                    $totalpaxA = $totalpaxA + $totaltransferA;

                    $totalTransportCostLE = getMarkupCost($totaltransferA,$transferCostLE,$transferCalTypeLE);
                    // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                    $totalTransportCostFE = getMarkupCost($totaltransferA,$transferCostFE,$transferCalTypeFE);
                    // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                    ?></td>

                    <td align="right" bgcolor="#deb887" ><?php  
                    echo getTwoDecimalNumberFormat($totaltransferC); 
                    $totalpaxC = $totalpaxC + $totaltransferC;?></td>
                    <?php if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalTransportCostLE); $totalPaxLE = $totalPaxLE + $totalTransportCostLE;?></td>
                    <?php } if($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalTransportCostFE); $totalPaxFE = $totalPaxFE + $totalTransportCostFE;?></td>
                    <?php } ?>
                </tr>

                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>GUIDE</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php  
                    echo getTwoDecimalNumberFormat($totalguideA);
                    $totalpaxA = $totalpaxA + $totalguideA;

                    $totalGuideCostLE = getMarkupCost($totalguideA,$guideCostLE,$guideCalTypeLE);
                    // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                    $totalGuideCostFE = getMarkupCost($totalguideA,$guideCostFE,$guideCalTypeFE);
                    // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                    ?></td>
                    <td align="right" bgcolor="#deb887" ><?php
                    echo getTwoDecimalNumberFormat($totalguideC);
                    $totalpaxC = $totalpaxC + $totalguideC;?></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalGuideCostLE); $totalPaxLE = $totalPaxLE + $totalGuideCostLE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalGuideCostFE); $totalPaxFE = $totalPaxFE + $totalGuideCostFE;?></td>
                    <?php } ?>
                </tr>
                  
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PORTER</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat($totalporterA); 
                        $totalpaxA = $totalpaxA + $totalporterA;

                        $totalporterCostLE = getMarkupCost($totalporterA,$guideCostLE,$guideCalTypeLE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        $totalporterCostFE = getMarkupCost($totalporterA,$guideCostFE,$guideCalTypeFE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        ?>
                    </td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalporterC); $totalpaxC = $totalpaxC + $totalporterC;?></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalporterCostLE);$totalPaxLE = $totalPaxLE + $totalporterCostLE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalporterCostFE);$totalPaxFE = $totalPaxFE + $totalporterCostFE;?></td>
                    <?php } ?>
                  </tr>
                  
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ENTRANCE</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat($totalentranceA); 
                        $totalpaxA = $totalpaxA + $totalentranceA;

                        $totalentranceALE = getMarkupCost($totalentranceA,$entranceCostLE,$entranceCalTypeLE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        $totalentranceAFE = getMarkupCost($totalentranceA,$entranceCostFE,$entranceCalTypeFE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        ?>
                    </td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalentranceC); $totalpaxC = $totalpaxC + $totalentranceC;?></td>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalentranceALE);$totalPaxLE = $totalPaxLE + $totalentranceALE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalentranceAFE);$totalPaxFE = $totalPaxFE + $totalentranceAFE;?></td>
                    <?php } ?>
                </tr>
                  
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ENROUTES</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php
                        echo getTwoDecimalNumberFormat($totalenrouteA);
                        $totalpaxA = $totalpaxA + $totalenrouteA;
                        
                        $totalenrouteALE = getMarkupCost($totalenrouteA,$entranceCostLE,$entranceCalTypeLE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        // echo $enrouteCostFE."-".$enrouteCalTypeFE;

                        $totalenrouteAFE = getMarkupCost($totalenrouteA,$entranceCostFE,$entranceCalTypeFE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;

                    ?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalenrouteC); $totalpaxC = $totalpaxC + $totalenrouteC;?></td>

                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalenrouteALE);$totalPaxLE = $totalPaxLE + $totalenrouteALE; ?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalenrouteAFE);$totalPaxFE = $totalPaxFE + $totalenrouteAFE; ?></td>
                    <?php } ?>
                </tr>
                   
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ACTIVITIES</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php
                        echo getTwoDecimalNumberFormat($totalactivityA);
                        $totalpaxA = $totalpaxA + $totalactivityA;
                        
                        $totalactivityACostLE = getMarkupCost($totalactivityA,$activityCostLE,$activityCalTypeLE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        $totalactivityACostFE = getMarkupCost($totalactivityA,$activityCostFE,$activityCalTypeFE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;

                    ?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalactivityC);$totalpaxC = $totalpaxC + $totalactivityC;?></td>

                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalactivityACostLE);$totalPaxLE = $totalPaxLE + $totalactivityACostLE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalactivityACostFE);$totalPaxFE = $totalPaxFE + $totalactivityACostFE;?></td>
                    <?php } ?>
                </tr>
                  
                <tr height="18">
                    <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ADDITIONALS</strong></td>
                    <td align="right" bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat($totalotherA);
                        $totalpaxA = $totalpaxA + $totalotherA;
                        
                        $totalotherACostLE = getMarkupCost($totalotherA,$otherCostLE,$otherCalTypeLE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        $totalotherACostFE = getMarkupCost($totalotherA,$otherCostFE,$otherCalTypeFE);
                        // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                        ?>
                    </td> 
                    <td align="right" bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat($totalotherC);
                        $totalpaxC = $totalpaxC + $totalotherC;?></td>

                    <?php if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalotherACostLE);$totalPaxLE = $totalPaxLE + $totalotherACostLE;?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalotherACostFE);$totalPaxFE = $totalPaxFE + $totalotherACostFE;?></td>
                    <?php } ?>
                </tr>
                <tr height="18">

                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5">
                    <strong>TOTAL COST (&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>&nbsp;)</strong>
                </td>
                <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalpaxA);?></td>
                <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalpaxC);?></td>
                <?php  if ($paxAdultLE >0) { ?>
                <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat($totalPaxLE); $totalFOCCost = $totalPaxLE;?></td>
                <?php } if ($paxAdultFE >0) { ?>
                <td align="right" bgcolor="#d4d5f0"><?php echo getTwoDecimalNumberFormat($totalPaxFE); $totalLOCCost = $totalPaxFE;?></td>
                <?php } ?>
             </tr>
            </table> 
        </td>
         <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td valign="top">
        <!-- start Total tour cost -->
        <div style="text-align:left;font-size: 18px;margin: 0;"><strong>Total Tour Cost</strong></div>
        <?php 
        $grandSingle=$grandDouble=$grandTwin=$grandTriple=$grandAWB=$grandChildWB=$grandChildNB=$grandTotalPaxA=$grandTotalPaxC=0;  
        $grandSingleLE = $grandDoubleLE = $grandSingleFE = $grandDoubleFE = $grandTotalPaxLE = $grandTotalPaxFE = 0;
        ?>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
            <tr>
            <td align="center" bgcolor="#F5F5F5"><strong>Itinerary&nbsp;Services</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Unit&nbsp;Cost</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Volume&nbsp;Type</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Qty&nbsp;Total</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Total&nbsp;Cost</strong></td>
            </tr>
            <?php if($singleRoom >0){ ?>
            <tr >
            <td align="left" bgcolor="#deb887"><strong>Single&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalsingle); ?></td>
            <td align="center" bgcolor="#deb887">Room</td>
            <td align="right" bgcolor="#deb887"><?php echo ($singleRoom); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandSingle=$totalsingle*$singleRoom;echo getTwoDecimalNumberFormat($grandSingle);?></td>
            </tr>
            <?php }if($doubleRoom >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Double&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totaldouble); ?></td>
            <td align="center" bgcolor="#deb887">Room</td>
            <td align="right" bgcolor="#deb887"><?php echo ($doubleRoom); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandDouble =$totaldouble*$doubleRoom; echo getTwoDecimalNumberFormat($grandDouble);?></td>
            </tr>
            <?php }if($twinRoom >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Twin&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $totalTwin = $totaldouble; echo getTwoDecimalNumberFormat($totalTwin);?></td>
            <td align="center" bgcolor="#deb887">Room</td>
            <td align="right" bgcolor="#deb887"><?php echo ($twinRoom); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandTwin =$totalTwin*$twinRoom; echo getTwoDecimalNumberFormat($grandTwin);?></td>
            </tr>
            <?php }if($tripleRoom >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Triple&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php  echo getTwoDecimalNumberFormat($totalTriple);?></td>
            <td align="center" bgcolor="#deb887">Room</td>
            <td align="right" bgcolor="#deb887"><?php echo ($tripleRoom); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandTriple =$totalTriple*$tripleRoom; echo getTwoDecimalNumberFormat($grandTriple); ?></td>
            </tr>
            <?php }if($EBedAdult >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Extra&nbsp;Bed(A)</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraBedA);?></td>
            <td align="center" bgcolor="#deb887">Bed</td>
            <td align="right" bgcolor="#deb887"><?php echo ($EBedAdult); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandAWB =$totalextraBedA*$EBedAdult; echo getTwoDecimalNumberFormat($grandAWB);?></td>
            </tr>
            <?php }if($EBedChild >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Child-With&nbsp;Bed</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraBedC);?></td>
            <td align="center" bgcolor="#deb887">Room</td>
            <td align="right" bgcolor="#deb887"><?php echo ($EBedChild); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandChildWB =$totalextraBedC*$EBedChild; echo getTwoDecimalNumberFormat($grandChildWB);?></td>
            </tr>
            <?php } if($NBedChild >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Child-No&nbsp;Bed</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalextraNBedC);?></td>
            <td align="center" bgcolor="#deb887">Room</td>
            <td align="right" bgcolor="#deb887"><?php echo ($NBedChild); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandChildNB =$totalextraNBedC*$NBedChild; echo getTwoDecimalNumberFormat($grandChildNB);?></td>
            </tr>
            <?php } ?>
            <?php if($paxAdult >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Monuments(Adult)</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpaxA); ?></td>
            <td align="center" bgcolor="#deb887">Pax</td>
            <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandTotalPaxA=$totalpaxA*$paxAdult; echo getTwoDecimalNumberFormat($grandTotalPaxA);?></td>
            </tr>
            <?php } if($paxChild >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Monuments(Child)</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpaxC); ?></td>
            <td align="center" bgcolor="#deb887">Pax</td>
            <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandTotalPaxC =$totalpaxC*$paxChild; echo getTwoDecimalNumberFormat($grandTotalPaxC);?></td>
            </tr>
            <?php } ?>
            <?php 
            if(($isTotalLE >0 && $paxAdultLE > 0 ) || ( $isTotalFE >0 && $paxAdultFE > 0)){ 
                ?>
                <tr>
                <td align="left" colspan="4" ><strong>Escort</strong><hr style="float:right;width: 88%;"></td>
                <td align="left" ></td>
                </tr>
                <?php 
                if($sglRoomLE >0){ ?>
                <tr>
                <td align="left" bgcolor="#dec7c7"><strong>Single&nbsp;Room(Local)</strong></td>
                <td align="right" bgcolor="#dec7c7"><?php  $totalsingleLE = getMarkupCost($totalsingleLE,$hotelCostLE,$hotelCalTypeLE);
                echo getTwoDecimalNumberFormat($totalsingleLE); ?></td>
                <td align="center" bgcolor="#dec7c7">Room</td>
                <td align="right" bgcolor="#dec7c7"><?php echo ($sglRoomLE); ?></td>
                <td align="right" bgcolor="#dec7c7"><?php $grandSingleLE =$totalsingleLE*$sglRoomLE;echo getTwoDecimalNumberFormat($grandSingleLE);?></td>
                </tr>
                <?php }if($dblRoomLE >0){ ?>
                <tr>
                <td align="left" bgcolor="#dec7c7"><strong>Double&nbsp;Room(Local)</strong></td>
                <td align="right" bgcolor="#dec7c7"><?php $totaldoubleLE = getMarkupCost($totaldoubleLE,$hotelCostLE,$hotelCalTypeLE);
                echo getTwoDecimalNumberFormat($totaldoubleLE); ?></td>
                <td align="center" bgcolor="#dec7c7">Room</td>
                <td align="right" bgcolor="#dec7c7"><?php echo ($dblRoomLE); ?></td>
                <td align="right" bgcolor="#dec7c7"><?php $grandDoubleLE =$totaldoubleLE*$dblRoomLE; echo getTwoDecimalNumberFormat($grandDoubleLE);?></td>
                </tr>
                <?php } if($sglRoomFE >0){ ?>
                <tr>
                <td align="left" bgcolor="#d4d5f0"><strong>Single&nbsp;Room(Foriegn)</strong></td>
                <td align="right" bgcolor="#d4d5f0"><?php 
                    $totalsingleFE = getMarkupCost($totalsingleFE,$hotelCostFE,$hotelCalTypeFE);
                    echo getTwoDecimalNumberFormat($totalsingleFE); ?></td>
                <td align="center" bgcolor="#d4d5f0">Room</td>
                <td align="right" bgcolor="#d4d5f0"><?php echo ($sglRoomFE); ?></td>
                <td align="right" bgcolor="#d4d5f0"><?php $grandSingleFE =$totalsingleFE*$sglRoomFE;echo getTwoDecimalNumberFormat($grandSingleFE);?></td>
                </tr>
                <?php }if($dblRoomFE >0){ ?>
                <tr>
                <td align="left" bgcolor="#d4d5f0"><strong>Double&nbsp;Room(Foriegn)</strong></td>
                <td align="right" bgcolor="#d4d5f0"><?php 
                    $totaldoubleFE = getMarkupCost($totaldoubleFE,$hotelCostFE,$hotelCalTypeFE);
                    echo getTwoDecimalNumberFormat($totaldoubleFE); ?></td>
                <td align="center" bgcolor="#d4d5f0">Room</td>
                <td align="right" bgcolor="#d4d5f0"><?php echo ($dblRoomFE); ?></td>
                <td align="right" bgcolor="#d4d5f0"><?php $grandDoubleFE =$totaldoubleFE*$dblRoomFE; echo getTwoDecimalNumberFormat($grandDoubleFE);?></td>
                </tr>
                <?php }  
            }
            if($totalPaxLE >0 && $paxAdultLE > 0){ ?>
                <tr>
                <td align="left" bgcolor="#dec7c7"><strong>Monuments(Local)</strong></td>
                <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat($totalPaxLE); ?></td>
                <td align="center" bgcolor="#dec7c7">Pax</td>
                <td align="right" bgcolor="#dec7c7"><?php echo ($paxAdultLE); ?></td>
                <td align="right" bgcolor="#dec7c7"><?php $grandTotalPaxLE=$totalPaxLE*$paxAdultLE; echo getTwoDecimalNumberFormat($grandTotalPaxLE);?></td>
                </tr>
                <?php 
            } 
                
            
            if($totalPaxFE >0 && $paxAdultFE>0){ ?>
                <tr>
                <td align="left" bgcolor="#d4d5f0"><strong>Monuments(Foriegn)</strong></td>
                <td align="right" bgcolor="#d4d5f0"><?php echo getTwoDecimalNumberFormat($totalPaxFE); ?></td>
                <td align="center"bgcolor="#d4d5f0">Pax</td>
                <td align="right" bgcolor="#d4d5f0"><?php echo ($paxAdultFE); ?></td>
                <td align="right" bgcolor="#d4d5f0"><?php $grandTotalPaxFE=$totalPaxFE*$paxAdultFE; echo getTwoDecimalNumberFormat($grandTotalPaxFE);?></td>
                </tr>   
                <?php  
            }
            ?>
            <tr>
            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Cost&nbsp;of the Trip (<?php echo getCurrencyName($baseCurrencyId); ?>) </strong></td>
            <td align="right" ><?php 
                // TOTAL COST WITH ESCORT AND ALL MONUMENTS
                $grandTotalCost = $grandSingle+$grandDouble+$grandTwin+$grandTriple+$grandAWB+$grandChildWB+$grandChildNB+$grandTotalPaxA+$grandTotalPaxC+$grandSingleLE+$grandDoubleLE+$grandSingleFE+$grandDoubleFE+$grandTotalPaxLE+$grandTotalPaxFE+0;; 
                echo $supplierCost = getTwoDecimalNumberFormat($grandTotalCost);
                ?> 
            </td> 
            </tr>
            <?php 
            if ($serviceMarkup > 0 && $isUni_Mark == 1 && $isSer_Mark == 0) { 
                $serviceMarkupLable='';
                if ($financeresult['markupSerType'] == '1') {
                    $serviceMarkupLable  = '(+) MarkUp ('.$serviceMarkup.'';
                }
                if ($financeresult['markupSerType'] == '2') {
                    $serviceMarkupLable  = '(+) Service Charge ('.$serviceMarkup.'';
                }
                $serviceMarkupLable  .= ($markupType == 1) ? '%)' : 'Flat)';
                $grandTotalMarkupCost = getMarkupCost($grandTotalCost, $serviceMarkup, $markupType);
                $grandTotalCost = $grandTotalCost + $grandTotalMarkupCost;

                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupLable;?></strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalMarkupCost);?></td> 
                </tr>
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Markup (<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalCost);?></td> 
                </tr>
                <?php 
            }

            if ($ISOCommission > 0) { 
                $commissionLable='';
                $commissionLable  = '(+) ISO ('.$ISOCommission.'';
                $commissionLable  .= ($commissionType == 1) ? '%)' : 'Flat)';
                $grandTotalISOCost = getMarkupCost($grandTotalCost, $ISOCommission, $commissionType);
                $grandTotalCost = $grandTotalCost + $grandTotalISOCost;
                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $commissionLable;?></strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalISOCost);?></td> 
                </tr>
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With ISO (<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalCost);?></td> 
                </tr>
                <?php 
            }  

            if ($ConsortiaCommission > 0) { 
                $commissionLable='';
                $commissionLable  = '(+) Consortia ('.$ConsortiaCommission.'';
                $commissionLable  .= ($commissionType == 1) ? '%)' : 'Flat)';
                $grandTotalConsortiaCost = getMarkupCost($grandTotalCost, $ConsortiaCommission, $commissionType);
                $grandTotalCost = $grandTotalCost + $grandTotalConsortiaCost;
                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $commissionLable;?></strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalConsortiaCost);?></td> 
                </tr>
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Consortia (<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalCost);?></td> 
                </tr>
                <?php 
            } 

            if ($ClientCommission > 0) { 
                $commissionLable='';
                $commissionLable  = '(+) Client Commission ('.$ClientCommission.'';
                $commissionLable  .= ($commissionType == 1) ? '%)' : 'Flat)';
                $grandTotalClientCost = getMarkupCost($grandTotalCost, $ClientCommission, $commissionType);
                $grandTotalCost = $grandTotalCost + $grandTotalClientCost;
                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $commissionLable;?></strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalClientCost);?></td> 
                </tr>
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Client Commission (<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalCost);?></td> 
                </tr>
                <?php 
            } 

            if ($discount>0) {
                if ($discountType == '1') {
                    $discountLable  = '(-) Discount ('.$discount.'%)';
                }else{
                    $discountLable  = '(-) Discount ('.$discount.'Flat)';
                } 
                // echo ($discountType == 1) ? '&nbsp;(%)' : '&nbsp;(Flat)';
                $grandTotalDiscount = getMarkupCost($grandTotalCost, $discount, $discountType);
                $grandTotalCost = $grandTotalCost - $grandTotalDiscount;
                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $discountLable; ?></strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalDiscount);?></td> 
                </tr>
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Discount &nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalCost);?></td> 
                </tr>
                <?php 
            }  

            if ($serviceTax>0) {
                if ($financeresult['taxType'] == '1') {
                    $serviceTaxLable  = '(+) GST ('.$serviceTax.'%)';
                }
                if ($financeresult['taxType'] == '2') {
                    $serviceTaxLable  = '(+) VAT ('.$serviceTax.'%)';
                } 
                // echo ($taxType == 1) ? '&nbsp;(%)' : '&nbsp;(Flat)';
                $grandTotalTax = getMarkupCost($grandTotalCost, $serviceTax, 1);

                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceTaxLable;?></strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalTax);?></td> 
                </tr> 
                <?php 
            } 

            if ($tcsTax>0) { 
                $tcsLable  = '(+) TCS ('.$tcsTax.'%)';
                $grandTotalTCS = getMarkupCost($grandTotalCost, $tcsTax, 1);
                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $tcsLable;?></strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($grandTotalTCS);?></td> 
                </tr>
                <?php
            }  
            $grandTotalCost = $grandTotalCost + $grandTotalTax + $grandTotalTCS;

            ?>
            <tr>
            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Tour&nbsp;Cost&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
            <td align="right" ><?php echo  getTwoDecimalNumberFormat($grandTotalCost);
            ?></td> 
            </tr>
           
            <?php if($newCurr!=$baseCurrencyId){ ?>
            <tr>
            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Tour&nbsp;Cost&nbsp;(In <?php echo getCurrencyName($newCurr); ?>)</strong></td>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$grandTotalCost); ?></td> 
            </tr>
            <?php } ?>
        </table>
        <!-- end Total tour cost -->

        <!-- start Per pax basis cost -->
        <br>
        <div style="text-align:left!important;font-size: 15px;margin: 0;"><strong>Per Pax Cost on Occupancy Basis</strong></div>
        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
            <?php 
            // Per pax basis cost
            $ppCostONSingleBasis1 = ($totalsingle+$totalpaxA);
            $ppCostONDoubleBasis1 = (($totaldouble/2)+$totalpaxA);
            $ppCostOnTripleBasis1 = (($totalTriple/3)+$totalpaxA);
            $ppCostOnExtraBedABasis1 = ($totalextraBedA+$totalpaxA);
            $pcCostOnExtraBedCBasis1 = ($totalextraBedC+$totalpaxC);
            ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" ><strong>Occupancy</strong></td>
            <td align="right" bgcolor="#F5F5F5" ><strong>Cost&nbsp;(In&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>&nbsp;)</strong></td> 
            <?php if($newCurr!=$baseCurrencyId){ ?>
            <td align="right" bgcolor="#F5F5F5" ><strong>Cost&nbsp;(In&nbsp;<?php echo getCurrencyName($newCurr); ?>&nbsp;)</strong></td> 
            <?php } ?>   
            </tr>
            <?php
            if ($ppCostONSingleBasis1>0 &&  $singleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Single&nbsp;Basis</td>
            <td align="right" ><?php echo $ppCostONSingleBasis = getPerPersonBasisCost($ppCostONSingleBasis1,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);  ?></td> 

            <?php if($newCurr!=$baseCurrencyId){ ?>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$ppCostONSingleBasis); ?></td> 
            <?php } ?>   
            </tr>

            <?php } if ($ppCostONDoubleBasis1>0 && $doubleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Double&nbsp;Basis</td>
            <td align="right" ><?php echo $ppCostONDoubleBasis = getPerPersonBasisCost($ppCostONDoubleBasis1,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);  ?></td> 

            <?php if($newCurr!=$baseCurrencyId){ ?>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$ppCostONDoubleBasis); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($ppCostONDoubleBasis1>0 && $twinRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Twin&nbsp;Basis</td>
            <td align="right" ><?php echo $ppCostONTwinBasis = getPerPersonBasisCost($ppCostONDoubleBasis1,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);  ?></td> 

            <?php if($newCurr!=$baseCurrencyId){ ?>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$ppCostONTwinBasis); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($ppCostOnTripleBasis1>0 && $tripleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Triple&nbsp;Basis</td>
            <td align="right" ><?php echo $ppCostOnTripleBasis = getPerPersonBasisCost($ppCostOnTripleBasis1,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);  ?></td> 

            <?php if($newCurr!=$baseCurrencyId){ ?>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$ppCostOnTripleBasis); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($ppCostOnExtraBedABasis1>0 && $EBedAdult>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Adult&nbsp;Cost&nbsp;On&nbsp;ExtraBed&nbsp;Basis</td>
            <td align="right" ><?php echo $ppCostOnExtraBedABasis = getPerPersonBasisCost($ppCostOnExtraBedABasis1,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);  ?></td> 

            <?php if($newCurr!=$baseCurrencyId){ ?>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$ppCostOnExtraBedABasis); ?></td> 
            <?php } ?>
            </tr>
            <?php } if ($pcCostOnExtraBedCBasis1>0 && $EBedChild>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;On&nbsp;ExtraBed&nbsp;Basis</td>
            <td align="right" ><?php echo $pcCostOnExtraBedCBasis = getPerPersonBasisCost($pcCostOnExtraBedCBasis1,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);  ?></td> 

            <?php if($newCurr!=$baseCurrencyId){ ?>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$pcCostOnExtraBedCBasis); ?></td> 
            <?php } ?>
            </tr>
            <?php } ?>
        </table>
        <?php 
        $clientCost = $proposalCost = $grandTotalCost;
        $totalMargin = $grandTotalCost-$supplierCost;
        updatelisting(_QUOTATION_MASTER_,'totalCompanyCost="'.round($supplierCost).'",totalQuotCost="'.round($grandTotalCost).'",totalMargin="'.round($totalMargin).'"',' id="'.$quotationId.'"');
        ?>
        <!-- end basis wiose cost -->
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td valign="top">
        <div style="text-align:left;font-size: 18px;margin: 0;"><strong>Genral Info.</strong></div>
        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Adult&nbsp;Pax</strong></td>
            <td align="right" ><?php echo $paxAdult; ?></td> 
            </tr>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Child&nbsp;Pax</strong></td>
            <td align="right" ><?php echo $paxChild; ?></td> 
            </tr> 
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Local&nbsp;Escort&nbsp;Pax</strong></td>
            <td align="right" ><?php echo $paxAdultLE; ?></td> 
            </tr>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Foreign&nbsp;Escort&nbsp;Pax</strong></td>
            <td align="right" ><?php echo $paxAdultFE; ?></td> 
            </tr>
            <tr>
            <td align="right" colspan="2" bgcolor="#F5F5F5" ></td>
            </tr>
            <?php if( $singleRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Single&nbsp;Room</strong></td>
            <td align="right" ><?php echo $singleRoom; ?></td> 
            </tr>
            <?php } if( $doubleRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Double&nbsp;Room</strong></td>
            <td align="right" ><?php echo $doubleRoom; ?></td> 
            </tr>
            <?php } if( $tripleRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Triple&nbsp;Room</strong></td>
            <td align="right" ><?php echo $tripleRoom; ?></td> 
            </tr>
            <?php } if( $twinRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Twin&nbsp;Room</strong></td>
            <td align="right" ><?php echo $twinRoom; ?></td> 
            </tr>
            <?php } if( $EBedAdult >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Extra-Bed(A)</strong></td>
            <td align="right" ><?php echo $EBedAdult; ?></td> 
            </tr>
            <?php } if( $EBedChild >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>ChildWBed</strong></td>
            <td align="right" ><?php echo $EBedChild; ?></td> 
            </tr>
            <?php } if( $NBedChild >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>ChildNBed</strong></td>
            <td align="right" ><?php echo $NBedChild; ?></td> 
            </tr>
            <?php } ?>
            <tr>
            <td align="right" colspan="2" bgcolor="#F5F5F5" ></td>
            </tr>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>
            <?php
            if ($financeresult['markupSerType'] == '1') {
                echo'MarkUp(%)';
            }
            if ($financeresult['markupSerType'] == '2') {
                echo'Service&nbsp;Charge(%)';
            }
            ?>
            </strong></td>
            <td align="right" ><?php echo $serviceMarkup; ?></td> 
            </tr>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>
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
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>
                <?php
                if ($financeresult['taxType'] == '1') {
                    $serviceMarkupLable  = 'GST(%)';
                }
                if ($financeresult['taxType'] == '2') {
                    $serviceMarkupLable  = 'VAT(%)';
                }
                echo $serviceMarkupLable;
                ?>
            </strong></td>
            <td align="right" ><?php echo $serviceTax; ?></td> 
            </tr>
        </table>
        <hr>
        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Client&nbsp;Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></td>
            <td align="right" ><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$clientCost); ?></td> 
            </tr>
            <?php if($paxAdultLE<1 && $paxAdultFE<1 ){ ?>
            <!-- <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Supplier&nbsp;Cost</strong></td>
            <td align="right" ><?php echo $supplierCost; ?></td> 
            </tr>
             <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Margin</strong></td>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($clientCost-$supplierCost); ?></td> 
            </tr> -->
            <?php } ?> 
        </table>    
        </td>
    </tr>
    </table> 
    <!-- END PER PAX BLOCK AND TOTAL TOUR COST BLOCK -->
    <br>

    <div style="overflow:hidden; margin-top:20px;">
      <table border="0" align="right" cellpadding="5" cellspacing="0">
            <tbody><tr>
            <td> 
            <input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();"> 
            </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
 