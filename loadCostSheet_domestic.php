<?php
// FOR USE SAME FILE IN PROPOSALS and FIT 
if(isset($_REQUEST['quotationId'])){
    include "inc.php";
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
    $gstType = 1;

    $travelType = 2; 
    // because this is the seprate file for the domestic
     
    $moduleType = $resultpage['moduleType'];
    $paxAdult = ($resultpageQuotation['adult']);
    $paxChild = ($resultpageQuotation['child']);
    $paxInfant = ($resultpageQuotation['infant']);
    $totalPax = ($paxAdult + $paxChild + $paxInfant);
    $totalPaxAC = ($paxAdult + $paxChild);
    if($totalPax == 0){
        $totalPax =  2;
    }

    if($totalPaxAC == 0){
        $totalPaxAC =  2;
    }

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
    $queryType = $resultpageQuotation['queryType'];


    $hotelRatesCols = 9;
    if($twinRoom>0){
        $hotelRatesCols = $hotelRatesCols+1; 
    } 
    if($tripleRoom>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($EBedChild>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($NBedChild>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($EBedAdult>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($sixBedRoom>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($eightBedRoom>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($tenBedRoom>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($quadBedRoom>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    } 
    if($teenBedRoom>0){ 
        $hotelRatesCols = $hotelRatesCols+1;
    }


    if ($singleRoom<1 && $doubleRoom<1 && $tripleRoom<1) {
        $hotelIncluded = 0;
    } else {
        $hotelIncluded = 1;
    }

    $quotationId = $resultpageQuotation['id'];
    $queryId = $resultpage['id'];
    $quotPreviewId = makeQuotationId($quotationId).$MultiQuotPreview;

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
    $totalDF = $DF_SGL = $DF_DBL = $DF_TWN = $DF_TPL = $DF_QUAD = $DF_SIX = $DF_EIGHT = $DF_TEN = $DF_ABED = $DF_CBED = $DF_INF = 0;

    $defaultSlabSql = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1 ');
    if (mysqli_num_rows($defaultSlabSql)>0) {
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
        $DF_INF = clean($defaultSlabData['DF_INF']);
        $discount_INF = clean($defaultSlabData['discount_INF']);

        $totalPaxDiscount = $paxAdult+$paxChild+$discount_INF;

        if($queryType==14){
            $totalDFACI = $totalPaxACI = $totalDF = $defaultSlabData['adult']+$defaultSlabData['child']+$defaultSlabData['infant'];
        }else{
            $totalDF = ($DF_SGL+$DF_DBL+$DF_TWN+$DF_TPL+$DF_QUAD+$DF_SIX+$DF_EIGHT+$DF_TEN+$DF_ABED+$DF_CBED);
            $totalPaxACI = $totalPaxAC+$DF_INF;
            $totalDFACI = $paxAdult+$DF_CBED+$DF_INF;
        }
        

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
    } else {
        $newCurr = $resultpageQuotation['currencyId'];
    }

    // GST DATA 
  

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
        $other = $serviceMarkuD['other']; 
        $otherMarkupType = $serviceMarkuD['otherMarkupType']; 
        $markupTypeMain = $serviceMarkuD['hotelMarkupType'];
    }else{
        $serviceMarkupMain = $resultpageQuotation['markup'];
        $markupTypeMain = $resultpageQuotation['markupType'];
       
        // GST DATA 
        $serviceTax = 0;
        if ($resultpageQuotation['serviceTax']>0) {
            $serviceTax = $resultpageQuotation['serviceTax'];
        }

        //On TOur Value DATA 
        $serviceTaxDivident = 100;
        if ($financeresult['taxType'] == '2') {
            if ($resultpageQuotation['serviceTaxDivident']>0) {
                $serviceTaxDivident = $resultpageQuotation['serviceTaxDivident'];
            } 
        }

        $tcsTax = 0;
        if ($resultpageQuotation['tcs']>0 && $financeresult['taxType']!=2){
            $tcsTax = $resultpageQuotation['tcs'];
        }


    }


    if(isset($_REQUEST['finalcategory']) && $_REQUEST['finalcategory']==0){
        $hotCategory = explode(',', 0);
        // FOR single hotel Category one costsheet
    }
    
    // if(isset($_REQUEST['finalcategory']) && $_REQUEST['finalcategory']>0){
    //         $hotCategory = explode(',',$_REQUEST['finalcategory']);
    //     // FOR multiple hotel Category one costsheet
    // }elseif($resultpageQuotation['quotationType']==1){
    //     $hotCategory = explode(',', 0);
    //     // FOR single  hotel Category proposal costsheet
    // }else{
    //     // FOR Loop on multiple proposal costsheet
    //     $hotCategory = explode(',',$resultpageQuotation['hotCategory']);
    // }

    if(isset($_REQUEST['finalcategory']) && $_REQUEST['finalcategory']>0 && $resultpageQuotation['quotationType']==2){
        $hotCategory = explode(',',$_REQUEST['finalcategory']);
        // FOR multiple hotel Category one costsheet
    }elseif(isset($_REQUEST['hotelTypeWise']) && $_REQUEST['hotelTypeWise']>0 && $resultpageQuotation['quotationType']==3){
        $hotCategory = explode(',',$_REQUEST['hotelTypeWise']);
        // FOR multiple hotel Type one costsheet
    }elseif($resultpageQuotation['quotationType']==1){
        $hotCategory = explode(',', 0);
        // FOR single  hotel Category proposal costsheet
    }else{
        // FOR Loop on multiple proposal costsheet
        if($resultpageQuotation['quotationType']==3){
            $hotCategory = explode(',',$resultpageQuotation['hotelType']);
        }else{
            $hotCategory = explode(',',$resultpageQuotation['hotCategory']);
        }
    }

// END QUOTATION DATA CONTAINERS 

foreach($hotCategory as $val){
    $finalcategory = 0;
    $multihotelQuery =$MultiQuotPreview= "";
    if($val>0 && $resultpageQuotation['quotationType']==2){
        $hcQ=GetPageRecord('*','hotelCategoryMaster',' id="'.$val.'"');
        $hcData=mysqli_fetch_array($hcQ);

        if($hcData['hotelCategory']>0){
            $multihotelQuery = ' and categoryId= "'.$hcData['id'].'"'; 
            $MultiQuotPreview = " | ".$hcData['hotelCategory']." Star";
            $finalcategory = $hcData['id']; 
        }
    }

    $hotelTypeWise = 0;
    $hotelTypeQuery = $MultiQuotPreview= "";
    if($val>0 && $resultpageQuotation['quotationType']==3){
        $htQ=GetPageRecord('*','hotelTypeMaster',' id="'.$val.'"');
        $htypeData=mysqli_fetch_array($htQ);

        if(strlen($htypeData['name'])>0){
            $hotelTypeQuery = ' and hotelTypeId= "'.$htypeData['id'].'"'; 
            $MultiQuotPreview = " | ".$htypeData['name'];
            $hotelTypeWise = $htypeData['id']; 
        }
    }
?> 
<h1 style="text-align:left; position:relative;">Cost&nbsp;Sheet&nbsp;|&nbsp;<?php echo $quotPreviewId; ?>
<?php if($_REQUEST['export']!='yes'){ ?>
<a href="loadCostSheet_domestic.php?export=yes&quotationId=<?php echo $_REQUEST['quotationId']; ?>&finalcategory=<?php echo $_REQUEST['finalcategory']; ?>" style="position:absolute; right:3px; top:2px; ">
<input name="Cancel" type="button" class="whitembutton"  value="Export"  style="backgtrim-color: #fff !important; padding: 4px 20px;color: #fff !important;"></a>
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
            ?>
        </td>
    </tr>
</table> 
<div style="padding-top:10px; margin-top:10px; border-top:1px solid #ccc;">

<!-- Cost sheet service list -->
<div style="text-align:center;font-size: 18px;margin-bottom:10px;"><strong>Cost Sheet Detail <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?> Including Markup & GST <?php } ?></strong></div>
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000" style="font-size:12px;">
    <tr>
        <td width="45" align="left" bgcolor="#F5F5F5"><strong>Day/Date</strong></td>
        <td align="left" bgcolor="#F5F5F5"><strong>City </strong></td>
        <td width="93" align="left" bgcolor="#F5F5F5"><strong>Hotels</strong></td>
        <td colspan="<?php echo $hotelRatesCols ?>" align="center" bgcolor="#F5F5F5"><strong>Hotel Rates</strong></td>
        <td width="104" align="center" bgcolor="#F5F5F5"><strong></strong></td>
        <td width="48" align="center" bgcolor="#F5F5F5"><strong></strong></td>
        <td width="48"  colspan="3" align="center" bgcolor="#F5F5F5"><strong>Ferry</strong></td>
        <?php
        if ($resultpageQuotation['flightCostType'] == 0) {
        ?>
        <td width="48" colspan="3" align="center" bgcolor="#F5F5F5"><strong>Flight</strong></td>
        <?php
        }
        ?>
        <td width="48"  colspan="3" align="center" bgcolor="#F5F5F5"><strong>Train</strong></td>
        <td width="48"  colspan="3" align="center" bgcolor="#F5F5F5"><strong>Monuments</strong></td>
        <td width="48"  colspan="3" align="center" bgcolor="#F5F5F5"><strong>Sightseeing</strong></td>
        <td width="48"  colspan="4" align="center" bgcolor="#F5F5F5"><strong>Additional</strong></td>
        <td width="48"  colspan="3" align="center" bgcolor="#F5F5F5"><strong>Restaurant</strong></td>
        <!-- <td align="center" bgcolor="#F5F5F5" > <strong>Per Person</strong></td> -->
    </tr>
    <tr>
        <td width="118" align="left" bgcolor="#F5F5F5">&nbsp;</td>
        <td width="94" align="left" bgcolor="#F5F5F5">&nbsp;</td>
        <td align="left" bgcolor="#F5F5F5">&nbsp;</td>
        <td width="32" align="right" bgcolor="#F5F5F5"><strong>SGL</strong></td>
        <td width="32" align="right" bgcolor="#F5F5F5"><strong>DBL</strong></td>
        <?php  if($twinRoom>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>TWN</strong></td>
        <?php } if($tripleRoom>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>TPL</strong></td>
        <?php } if($quadBedRoom>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>Quad</strong></td>
        <?php } if($sixBedRoom>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>Six</strong></td>
        <?php } if($eightBedRoom>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>Eight</strong></td>
        <?php } if($tenBedRoom>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>Ten</strong></td>
        <?php } if($teenBedRoom>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>Teen</strong></td>
        <?php } if($EBedAdult>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>E.Bed</strong></td>
        <?php } if($EBedChild>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>CWB</strong></td>
        <?php } if($NBedChild>0){ ?>
        <td width="40" align="right" bgcolor="#F5F5F5"><strong>CNB</strong></td>
        <?php } ?>
        <td width="24" align="right" bgcolor="#F5F5F5"><strong>AB</strong></td>
        <td width="24" align="right" bgcolor="#F5F5F5"><strong>AL</strong></td>
        <td width="24" align="right" bgcolor="#F5F5F5"><strong>AD</strong></td>
        <td width="24" align="right" bgcolor="#F5F5F5"><strong>CB</strong></td>
        <td width="24" align="right" bgcolor="#F5F5F5"><strong>CL</strong></td>
        <td width="24" align="right" bgcolor="#F5F5F5"><strong>CD</strong></td>
        <td width="24" align="right" bgcolor="#F5F5F5"><strong>A</strong></td>
        <td align="right" bgcolor="#F5F5F5"><strong>Transport</strong></td>
        <td align="right" bgcolor="#F5F5F5"><strong>Guide</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td> 
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td> 
        <?php
        if ($resultpageQuotation['flightCostType'] == 0) {
        ?>
        <!-- below flight cols -->
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
        <?php
        }
        ?>
        <!-- Below Train cols -->
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
        <!-- Below Monuments cols-->
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>

         <!-- Below Sightseeing cols-->
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>

         <!-- Below Addtional cols-->
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Group</strong></td>

         <!-- Below Restaurant cols-->
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
        <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>

        <!-- <td width="44" align="right" bgcolor="#F5F5F5"><strong>Porter</strong></td> -->
    </tr> 
    <?php
    $totalsingle=$totaldouble=$totaltwin=$totaltriple=$totalquad=$totalsixBed=$totaleightBed=$totaltenBed=$totalteenBed=$totalextraBedA=$totalextraBedC=$totalextraNBedC=$totalBreakfast=$totalLunch=$totalDinner=$totalHACost=0;

    $totalTransportCost=$totalGuideCost=$totalFerryCostA=$totalFerryCostC=$totalFerryCostE=$totalflightA=$totalflightC=$totalflightE=$totaltrainA=$totaltrainC=$totaltrainE=$totalentcostA=$totalentcostC=$totalentcostE=$totalActcostA=$totalActcostC=$totalActcostE=$totalPorter=0;
    $totalExtraCostA=$totalExtraCostC=$totalExtraCostE=$totalExtraCostG=$totalRestaurantCostA=$totalRestaurantCostC=$totalRestaurantCostE=0;    

    $totalsingleLE=$totalsingleFE=$totaldoubleLE=$totaldoubleFE=0;
    $totalBreakfastALE=$totalBreakfastAFE=0;
    $totalLunchALE=$totalLunchAFE=0;
    $totalDinnerALE=$totalDinnerAFE=0; 
    $totalHACostLE=$totalHACostFE=0; 

    //____NEW LOOP__________________________________________________________________________
    $rsp = GetPageRecord('*', _QUOTATION_MASTER_, ' id="' . $quotationId . '"');
    $quotationData = mysqli_fetch_array($rsp);
    $quotationId = $quotationData['id'];
    $day = 1;
    $QueryDaysQuery = GetPageRecord('*', 'newQuotationDays', ' quotationId="' . $quotationData['id'] . '" and addstatus=0 order by srdate asc');
    while ($QueryDaysData = mysqli_fetch_array($QueryDaysQuery)) {
        $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
        if ($day == 1) {
            $startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($dayDate)));
        }

        $rows=1;
        $bbb = 0;
        $bbb = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '" and isHotelSupplement!=1 and isGuestType = 1 and fromDate="' . $dayDate . '" '.$multihotelQuery.' '.$hotelTypeQuery.' order by id asc');
        if(mysqli_num_rows($bbb)>0) {
            $rows = mysqli_num_rows($bbb);
        }

        $rowspan = ' rowspan="'.$rows.'" '; 
        ?>

        <tr>
        <td width="118" <?php echo $rowspan; ?> align="left">D<?php
        echo str_pad($day, 2, '0', STR_PAD_LEFT);
        if ($resultpage['dayWise'] == 1) {
            echo " - " . date('d-m-Y', strtotime($dayDate));
        }
        ?>
        </td>

        <td width="94" <?php echo $rowspan; ?> align="left">
        <?php
        echo getDestination($QueryDaysData['cityId']);
        ?>  
        </td>

         
     
        <?php
        $singleNoofRoom = $doubleNoofRoom = $twinNoofRoom = $tripleNoofRoom = $quadNoofRoom = $sixNoofBedRoom = $eightNoofBedRoom = $tenNoofBedRoom = $teenNoofRoom = $extraNoofBed = $childwithNoofBed = $childwithoutNoofBed = 0;
        
        $singleNoofRoom3 = $doubleNoofRoom3 = $twinNoofRoom3 = $tripleNoofRoom3 = $quadNoofRoom3 = $sixNoofBedRoom3 = $eightNoofBedRoom3 = $tenNoofBedRoom3 = $teenNoofRoom3 = $extraNoofBed3 = $childwithNoofBed3 = $childwithoutNoofBed3 = 0;

        $single=$double=$twin=$triple=$quad=$sixBed=$eightBed=$tenBed=$teenBed=$extraBedA=$extraBedC=$extraNBedC=$breakfastA=$lunchA=$dinnerA=$breakfastC=$lunchC=$dinnerC=$dayTotalHACost=0;
        $single3=$double3=$triple3=$quad3=$sixBed3=$eightBed3=$tenBed3=$teenBed3=$extraBedA3=$extraBedC3=$extraNBedC3=$breakfastA3=$lunchA3=$dinnerA3=$breakfastC3=$lunchC3=$dinnerC3=$dayTotalHACost3=0;
        $singleLE=$doubleLE=$breakfastLE=$lunchLE=$dinnerLE=$dayTotalHACostLE=0;
        $singleLE3=$doubleLE3=$breakfastLE3=$lunchLE3=$dinnerLE3=$dayTotalHACostLE3=0;
        $singleFE=$doubleFE=$breakfastFE=$lunchFE=$dinnerFE=$dayTotalHACostFE=0;
        $singleFE3=$doubleFE3=$breakfastFE3=$lunchFE3=$dinnerFE3=$dayTotalHACostFE3=0; 
        
        // $totalLunchA=$totalDinnerA=$totalBreakfastC=$totalLunchC=$totalDinnerC=0;
        
        $samedayCnt = 1;
        // $rows=1;
        $b ="";
        $b = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '" and isHotelSupplement!=1 and isGuestType = 1 and fromDate="'.$dayDate.'" '.$multihotelQuery.' '.$hotelTypeQuery.' order by id asc');
        if(mysqli_num_rows($b) > 0){ 
            // $rowspan = ' rowspan="'.$rows.'" '; 
            while($qhotel = mysqli_fetch_array($b)){

            $sglMarkup = $qhotel['sglMarkup'];
            $dblMarkup = $qhotel['dblMarkup'];
            $twinMarkup = $qhotel['twinMarkup'];
            $tplMarkup = $qhotel['tplMarkup'];
            $quadMarkup = $qhotel['quadMarkup'];
            $sixMarkup = $qhotel['sixMarkup'];
            $eightMarkup = $qhotel['eightMarkup'];
            $tenMarkup = $qhotel['tenMarkup'];
            $teenMarkup = $qhotel['teenMarkup'];

            $cwbMarkup = $qhotel['cwbMarkup'];
            $cnbMarkup = $qhotel['cnbMarkup'];
            $exMarkup = $qhotel['exMarkup'];
            $mealMarkup = $qhotel['mealMarkup'];

            $markupType = $qhotel['markupType'];
            $gstTax = getGstValueById($qhotel['roomGST']);
            $gstType = 1;
            $taxType = $qhotel['taxType'];

        
            $singleNoofRoom = $qhotel['singleNoofRoom'];
            $single = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['singleoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$singleNoofRoom));
            
            $doubleNoofRoom = $qhotel['doubleNoofRoom'];
            $double = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['doubleoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$doubleNoofRoom));

            $twinNoofRoom = $qhotel['twinNoofRoom'];
            $twin = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['twinoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$twinNoofRoom));

            $tripleNoofRoom = $qhotel['tripleNoofRoom'];
            $triple = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['tripleoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$tripleNoofRoom));

            $quadNoofRoom = $qhotel['quadNoofRoom'];
            $quad = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['quadRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$quadNoofRoom));
            
            $sixNoofBedRoom = $qhotel['sixNoofBedRoom'];
            $sixBed = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['sixBedRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$sixNoofBedRoom));

            $eightNoofBedRoom = $qhotel['eightNoofBedRoom'];
            $eightBed = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['eightBedRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$eightNoofBedRoom));

            $tenNoofBedRoom = $qhotel['tenNoofBedRoom'];
            $tenBed = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['tenBedRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$tenNoofBedRoom));

            $teenNoofRoom = $qhotel['teenNoofRoom'];
            $teenBed = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['teenRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$teenNoofRoom));

            $extraNoofBed = $qhotel['extraNoofBed'];
            $extraBedA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['extraBed'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$extraNoofBed));

            $childwithNoofBed = $qhotel['childwithNoofBed'];
            $extraBedC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['childwithbed'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$childwithNoofBed));

            $childwithoutNoofBed = $qhotel['childwithoutNoofBed'];
            $extraNBedC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($qhotel['childwithoutbed'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$childwithoutNoofBed));
            
            $breakfastC=$lunchC=$dinnerC=$breakfastA=$lunchA=$dinnerA=0;

            if ($qhotel['isChildBreakfast'] == 1) { 
                $breakfastC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,getCostWithGSTID_Markup($qhotel['childBreakfast'],$qhotel['mealGST'],0,1,0,0));
            }
            if ($qhotel['isChildLunch'] == 1) { 
                $lunchC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,getCostWithGSTID_Markup($qhotel['childLunch'],$qhotel['mealGST'],0,1,0,0));
            }
            if ($qhotel['isChildDinner'] == 1) { 
                $dinnerC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,getCostWithGSTID_Markup($qhotel['childDinner'],$qhotel['mealGST'],0,1,0,0));
            }

            if ($qhotel['complimentaryBreakfast'] == 1) { 
                $breakfastA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,getCostWithGSTID_Markup($qhotel['breakfast'],$qhotel['mealGST'],0,1,0,0));
            }
            if ($qhotel['complimentaryLunch'] == 1) { 
                $lunchA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,getCostWithGSTID_Markup($qhotel['lunch'],$qhotel['mealGST'],0,1,0,0));
            }
            if ($qhotel['complimentaryDinner'] == 1) { 
                $dinnerA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal,getCostWithGSTID_Markup($qhotel['dinner'],$qhotel['mealGST'],0,1,0,0));
            }  


            $d = '';
            $d = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$qhotel['id'].'" and fromDate="' . $dayDate . '" order by id asc');
            while ($qHAdditionalData = mysqli_fetch_array($d)) {
                if ($qHAdditionalData['costType']==2) {
                    $additionalCost = convert_to_base($qHAdditionalData['currencyValue'], $baseCurrencyVal,  $qHAdditionalData['additionalCost']);
                    $perPaxCost = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                } else {
                    $perPaxCost = convert_to_base($qHAdditionalData['currencyValue'], $baseCurrencyVal,  $qHAdditionalData['additionalCost']);
                }
                $dayTotalHACost = ($dayTotalHACost + trim($perPaxCost));
            } 

            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                if($markupType == 2){
                    $singleMarkup = (getMarkupCost($single,$sglMarkup,$markupType)*$singleNoofRoom);
                }else{
                    $singleMarkup = getMarkupCost($single,$sglMarkup,$markupType);
                }
                // end markup calc
                $single = $single+$singleMarkup;
                if($taxType == 2){
                    $singleTax = getMarkupCost($singleMarkup,$gstTax,$gstType);
                }else{
                    $singleTax = getMarkupCost($single,$gstTax,$gstType);
                }
                $single = $single+$singleTax;
                

                if($markupType == 2){
                    $doubleMarkup = (getMarkupCost($double,$dblMarkup,$markupType)*$doubleNoofRoom);
                }else{
                    $doubleMarkup = getMarkupCost($double,$dblMarkup,$markupType);
                }
                // end markup calc
                $double = $double+$doubleMarkup;
                if($taxType == 2){
                    $doubleTax = getMarkupCost($doubleMarkup,$gstTax,$gstType);
                }else{
                    $doubleTax = getMarkupCost($double,$gstTax,$gstType);
                }
                $double = $double+$doubleTax;
                

                if($markupType == 2){
                    $twinRoomMarkup = (getMarkupCost($twin,$twinMarkup,$markupType)*$twinNoofRoom);
                }else{
                    $twinRoomMarkup = getMarkupCost($twin,$twinMarkup,$markupType);
                }
                // end markup calc
                $twin = $twin+$twinRoomMarkup;
                if($taxType == 2){
                    $twinTax = getMarkupCost($twinRoomMarkup,$gstTax,$gstType);
                }else{
                    $twinTax = getMarkupCost($twin,$gstTax,$gstType);
                }
                $twin = $twin+$twinTax;


                if($markupType == 2){
                    $tripleMarkup = (getMarkupCost($triple,$tplMarkup,$markupType)*$tripleNoofRoom);
                }else{
                    $tripleMarkup = getMarkupCost($triple,$tplMarkup,$markupType);
                }
                // end markup calc
                $triple = $triple+$tripleMarkup;
                if($taxType == 2){
                    $tripleTax = getMarkupCost($tripleMarkup,$gstTax,$gstType);
                }else{
                    $tripleTax = getMarkupCost($triple,$gstTax,$gstType);
                }
                $triple = $triple+$tripleTax;
                

                if($markupType == 2){
                    $quadBedMarkup = (getMarkupCost($quad,$quadMarkup,$markupType)*$quadNoofRoom);
                }else{
                    $quadBedMarkup = getMarkupCost($quad,$quadMarkup,$markupType);
                }
                // end markup calc
                $quad = $quad+$quadBedMarkup;
                if($taxType == 2){
                    $quadTax = getMarkupCost($quadBedMarkup,$gstTax,$gstType);
                }else{
                    $quadTax = getMarkupCost($quad,$gstTax,$gstType);
                }
                $quad = $quad+$quadTax;
                

                if($markupType == 2){
                    $sixBedMarkup = (getMarkupCost($sixBed,$sixMarkup,$markupType)*$sixNoofBedRoom);
                }else{
                    $sixBedMarkup = getMarkupCost($sixBed,$sixMarkup,$markupType);
                }
                // end markup calc
                $sixBed = $sixBed+$sixBedMarkup;
                if($taxType == 2){
                    $sixBedTax = getMarkupCost($sixBedMarkup,$gstTax,$gstType);
                }else{
                    $sixBedTax = getMarkupCost($sixBed,$gstTax,$gstType);
                }
                $sixBed = $sixBed+$sixBedTax;
                

                if($markupType == 2){
                    $eightBedMarkup = (getMarkupCost($eightBed,$eightMarkup,$markupType)*$eightNoofBedRoom);
                }else{
                    $eightBedMarkup = getMarkupCost($eightBed,$eightMarkup,$markupType);
                }
                // end markup calc
                $eightBed = $eightBed+$eightBedMarkup;
                if($taxType == 2){
                    $eightBedTax = getMarkupCost($eightBedMarkup,$gstTax,$gstType);
                }else{
                    $eightBedTax = getMarkupCost($eightBed,$gstTax,$gstType);
                }
                $eightBed = $eightBed+$eightBedTax;
                
                
                if($markupType == 2){
                    $tenBedMarkup = (getMarkupCost($tenBed,$tenMarkup,$markupType)*$tenNoofBedRoom);
                }else{
                    $tenBedMarkup = getMarkupCost($tenBed,$tenMarkup,$markupType);
                }
                // end markup calc
                $tenBed = $tenBed+$tenBedMarkup;
                if($taxType == 2){
                    $tenBedTax = getMarkupCost($tenBedMarkup,$gstTax,$gstType);
                }else{
                    $tenBedTax = getMarkupCost($tenBed,$gstTax,$gstType);
                }
                $tenBed = $tenBed+$tenBedTax;
                
                
                if($markupType == 2){
                    $teenBedMarkup = (getMarkupCost($teenBed,$teenMarkup,$markupType)*$teenNoofRoom);
                }else{
                    $teenBedMarkup = getMarkupCost($teenBed,$teenMarkup,$markupType);
                }
                // end markup calc
                $teenBed = $teenBed+$teenBedMarkup;
                if($taxType == 2){
                    $teenBedTax = getMarkupCost($teenBedMarkup,$gstTax,$gstType);
                }else{
                    $teenBedTax = getMarkupCost($teenBed,$gstTax,$gstType);
                }
                $teenBed = $teenBed+$teenBedTax;
                

                if($markupType == 2){
                    $extraBedAMarkup = (getMarkupCost($extraBedA,$exMarkup,$markupType)*$extraNoofBed);
                }else{
                    $extraBedAMarkup = getMarkupCost($extraBedA,$exMarkup,$markupType);
                }
                // end markup calc
                $extraBedA = $extraBedA+$extraBedAMarkup;
                if($taxType == 2){
                    $extraBedATax = getMarkupCost($extraBedAMarkup,$gstTax,$gstType);
                }else{
                    $extraBedATax = getMarkupCost($extraBedA,$gstTax,$gstType);
                }
                $extraBedA = $extraBedA+$extraBedATax;


                if($markupType == 2){
                    $extraBedCMarkup = (getMarkupCost($extraBedC,$cwbMarkup,$markupType)*$childwithNoofBed);
                }else{
                    $extraBedCMarkup = getMarkupCost($extraBedC,$cwbMarkup,$markupType);
                }
                // end markup calc
                $extraBedC = $extraBedC+$extraBedCMarkup;
                if($taxType == 2){
                    $extraBedCTax = getMarkupCost($extraBedCMarkup,$gstTax,$gstType);
                }else{
                    $extraBedCTax = getMarkupCost($extraBedC,$gstTax,$gstType);
                }
                $extraBedC = $extraBedC+$extraBedCTax;

                
                if($markupType == 2){
                    $extraNBedCMarkup = (getMarkupCost($extraNBedC,$cnbMarkup,$markupType)*$childwithoutNoofBed);
                }else{
                    $extraNBedCMarkup = getMarkupCost($extraNBedC,$cnbMarkup,$markupType);
                }
                // end markup calc
                $extraNBedC = $extraNBedC+$extraNBedCMarkup;
                if($taxType == 2){
                    $extraNBedCTax = getMarkupCost($extraNBedCMarkup,$gstTax,$gstType);
                }else{
                    $extraNBedCTax = getMarkupCost($extraNBedC,$gstTax,$gstType);
                }
                $extraNBedC = $extraNBedC+$extraNBedCTax;
                

                if ($qhotel['complimentaryBreakfast'] == 1) {
                    $breakfastAMarkup = getMarkupCost($breakfastA,$mealMarkup,$markupType);
                    $breakfastA = $breakfastA+$breakfastAMarkup;
                    if($taxType == 2){
                        $breakfastATax = getMarkupCost($breakfastAMarkup,$gstTax,$gstType);
                    }else{
                        $breakfastATax = getMarkupCost($breakfastA,$gstTax,$gstType);
                    }
                    $breakfastA = $breakfastA+$breakfastATax;
                } 

                if ($qhotel['complimentaryLunch'] == 1) {
                    $lunchAMarkup = getMarkupCost($lunchA,$mealMarkup,$markupType);
                    $lunchA = $lunchA+$lunchAMarkup;
                    if($taxType == 2){
                        $lunchATax = getMarkupCost($lunchAMarkup,$gstTax,$gstType);
                    }else{
                        $lunchATax = getMarkupCost($lunchA,$gstTax,$gstType);
                    }
                    $lunchA = $lunchA+$lunchATax;
                } 

                if ($qhotel['complimentaryDinner'] == 1) {
                    $dinnerAMarkup = getMarkupCost($dinnerA,$mealMarkup,$markupType);
                    $dinnerA = $dinnerA+$dinnerAMarkup;
                    if($taxType == 2){
                        $dinnerATax = getMarkupCost($dinnerAMarkup,$gstTax,$gstType);
                    }else{
                        $dinnerATax = getMarkupCost($dinnerA,$gstTax,$gstType);
                    }
                    $dinnerA = $dinnerA+$dinnerATax;
                } 
                if ($qhotel['isChildBreakfast'] == 1) {
                    $breakfastCMarkup = getMarkupCost($breakfastC,$mealMarkup,$markupType);
                    $breakfastC = $breakfastC+$breakfastCMarkup;
                    if($taxType == 2){
                        $breakfastCTax = getMarkupCost($breakfastCMarkup,$gstTax,$gstType);
                    }else{
                        $breakfastCTax = getMarkupCost($breakfastC,$gstTax,$gstType);
                    }
                    $breakfastC = $breakfastC+$breakfastCTax;
                } 

                if ($qhotel['isChildLunch'] == 1) {
                    $lunchCMarkup = getMarkupCost($lunchC,$mealMarkup,$markupType);
                    $lunchC = $lunchC+$lunchCMarkup;
                    if($taxType == 2){
                        $lunchCTax = getMarkupCost($lunchCMarkup,$gstTax,$gstType);
                    }else{
                        $lunchCTax = getMarkupCost($lunchC,$gstTax,$gstType);
                    }
                    $lunchC = $lunchC+$lunchCTax;
                } 

                if ($qhotel['isChildDinner'] == 1) {
                    $dinnerCMarkup = getMarkupCost($dinnerC,$mealMarkup,$markupType);
                    $dinnerC = $dinnerC+$dinnerCMarkup;
                    if($taxType == 2){
                        $dinnerCTax = getMarkupCost($dinnerCMarkup,$gstTax,$gstType);
                    }else{
                        $dinnerCTax = getMarkupCost($dinnerC,$gstTax,$gstType);
                    }
                    $dinnerC = $dinnerC+$dinnerCTax;
                }

                $HAMarkup = getMarkupCost($dayTotalHACost,$mealMarkup,$markupType);
                $dayTotalHACost = $dayTotalHACost+$HAMarkup;
                if($taxType == 2){
                    $HATax = getMarkupCost($HAMarkup,$gstTax,$gstType);
                }else{
                    $HATax = getMarkupCost($dayTotalHACost,$gstTax,$gstType);
                }
                $dayTotalHACost = $dayTotalHACost+$HATax;
            } 
            // end domestice markup and gst calculatino
            

            $totalsingle = $totalsingle + trim($single);
            $totaldouble = $totaldouble + trim($double);
            $totaltwin = $totaltwin + trim($twin);
            $totaltriple = $totaltriple + trim($triple);
            $totalquad = $totalquad + trim($quad);
            $totalsixBed = $totalsixBed + trim($sixBed);
            $totaleightBed = $totaleightBed + trim($eightBed);
            $totaltenBed = $totaltenBed + trim($tenBed);
            $totalteenBed = $totalteenBed + trim($teenBed);

            $totalextraBedA = $totalextraBedA + trim($extraBedA);
            $totalextraBedC = $totalextraBedC + trim($extraBedC);
            $totalextraNBedC = $totalextraNBedC + trim($extraNBedC);
            $totalBreakfastA = $totalBreakfastA + trim($breakfastA);
            $totalLunchA = $totalLunchA + trim($lunchA);
            $totalDinnerA = $totalDinnerA + trim($dinnerA);
            $totalBreakfastC = $totalBreakfastC + trim($breakfastC);
            $totalLunchC = $totalLunchC + trim($lunchC);
            $totalDinnerC = $totalDinnerC + trim($dinnerC);
            $totalHACost = $totalHACost + $dayTotalHACost;
            // echo $samedayCnt;
          

            if($samedayCnt<=$rows && $samedayCnt!=1){
                echo '<tr>';
            }
            ?>
    <td align="left">
        <?php 
       
    
            $bbb = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotel['supplierId'] . '"');
            $hotelname = mysqli_fetch_array($bbb);
            echo "Guest:-".stripslashes($hotelname['hotelName']);

        ?>
     </td>
    <td align="right"><?php
        if($single>0){
            echo getTwoDecimalNumberFormat($single).'/'.$singleNoofRoom; // GUEST RATE
        }
    ?></td>
    <td align="right"><?php
        if($double>0){
            echo getTwoDecimalNumberFormat($double).'/'.$doubleNoofRoom; // GUEST RATE
        }
    ?></td>
    <?php if($twinRoom>0){ ?>
    <td align="right"><?php
        if($twin>0){
            echo getTwoDecimalNumberFormat($twin).'/'.$twinNoofRoom; 
        }
    // GUEST RATE
    ?></td>
    <?php } if($tripleRoom>0){ ?>
    <td align="right"><?php
        if($triple>0){
            echo getTwoDecimalNumberFormat($triple).'/'.$tripleNoofRoom; 
        }
    // GUEST RATE
    ?></td>
    <?php } if($quadBedRoom>0){ ?>
    <td align="right"><?php 
        if($quad>0){
        echo getTwoDecimalNumberFormat($quad).'/'.$quadNoofRoom; 
        }
        // GUEST RATE quad
    ?></td>
    <?php } if($sixBedRoom>0){ ?>
    <td align="right"><?php
        if($sixBed>0){
            echo getTwoDecimalNumberFormat($sixBed).'/'.$sixNoofBedRoom; 
        }
    // GUEST RATE six   
    ?></td>
    <?php } if($eightBedRoom>0){ ?>
    <td align="right"><?php 
        if($eightBed>0){
            echo getTwoDecimalNumberFormat($eightBed).'/'.$eightNoofBedRoom; 
        }
    // GUEST RATE eight
    ?></td>
    <?php } if($tenBedRoom>0){ ?>
    <td align="right"><?php 
        if($tenBed>0){
            echo getTwoDecimalNumberFormat($tenBed).'/'.$tenNoofBedRoom; 
        }
    // GUEST RATE ten
    ?></td>
    <?php } if($teenBedRoom>0){ ?>
    <td align="right"><?php 
        if($teenBed>0){
            echo getTwoDecimalNumberFormat($teenBed).'/'.$teenNoofRoom; 
        }
    // GUEST RATE teen
    ?></td>
    <?php } if($EBedAdult>0){ ?>
    <td align="right"><?php
        if($extraBedA>0){
            echo getTwoDecimalNumberFormat($extraBedA).'/'.$extraNoofBed; 
        }
    // GUEST RATE
    ?></td>
    <?php } if($EBedChild>0){ ?>
    <td align="right"><?php
        if($extraBedC>0){
            echo getTwoDecimalNumberFormat($extraBedC).'/'.$childwithNoofBed; 
        }
    // GUEST RATE
    ?></td>
    <?php } if($NBedChild>0){ ?>
    <td align="right"><?php
        if($extraNBedC>0){
            echo getTwoDecimalNumberFormat($extraNBedC).'/'.$childwithoutNoofBed; 
        }
    // GUEST RATE
    ?></td>
    <?php } ?> 
    <td align="right"><?php 
    echo getTwoDecimalNumberFormat($breakfastA); // GUEST RATE
    ?></td>
    <td align="right"><?php
    echo getTwoDecimalNumberFormat($lunchA); // GUEST RATE
    ?></td>
    <td align="right"><?php
    echo getTwoDecimalNumberFormat($dinnerA); // GUEST RATE
    ?></td>
    <td align="right"><?php 
    echo getTwoDecimalNumberFormat($breakfastC); // GUEST RATE
    ?></td>
    <td align="right"><?php
    echo getTwoDecimalNumberFormat($lunchC); // GUEST RATE
    ?></td>
    <td align="right"><?php
    echo getTwoDecimalNumberFormat($dinnerC); // GUEST RATE
    ?></td>
    <td align="right"><?php
    echo getTwoDecimalNumberFormat($dayTotalHACost); // GUEST RATE
    ?></td>
  
    <?php
    if($samedayCnt==1){ ?>
        <td align="right" <?php echo $rowspan; ?> > 
        <?php
        $totaltransportSameDay = 0;
        $rsa2 = "";
        $rsa2 = GetPageRecord('*', _QUOTATION_TRANSFER_MASTER_, ' quotationId="'.$quotationId.'" and fromDate="' . $dayDate . '" and totalPax in ( select id from totalPaxSlab where status = 1 and quotationId = "' . $quotationId . '" ) order by fromDate asc');
        while ($qTransferData = mysqli_fetch_array($rsa2)) {
            //cost break up info
            $markupCost = $qTransferData['markupCost'];
            $markupType = $qTransferData['markupType'];
            $gstTax = getGstValueById($qTransferData['gstTax']);
            $gstType = 1;
            $taxType = $qTransferData['taxType'];

            if($qTransferData['transferType'] == 1){
                $transportCost=($qTransferData['adultCost']*$paxAdult)+($qTransferData['childCost']*$paxChild)+($qTransferData['infantCost']*$paxInfant);
            }else{
                if ($qTransferData['costType'] == 3) {
                    $transportCost = ($qTransferData['vehicleCost'] * $qTransferData['noOfVehicles'] * $qTransferData['distance']);
                }else{ 
                    $transportCost = ($qTransferData['vehicleCost'] * $qTransferData['noOfVehicles']);
                }
            }
            $transportCost = getCostWithGSTID_Markup($transportCost,$qTransferData['gstTax'],$qTransferData['markupCost'],$qTransferData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $transportCostMarkup = getMarkupCost($transportCost,$markupCost,$markupType);
                if($markupType==1){
                    $transportCost = $transportCost+($transportCostMarkup);
                }else{

                    if($qTransferData['transferType'] == 1){
                        $transportCostMarkup = $transportCostMarkup*$totalDFACI;
                    }else{
                        $transportCostMarkup = $transportCostMarkup*$qTransferData['noOfVehicles'];
                    }
                    // $transportCostMarkup = $transportCostMarkup*$totalDFACI;
                    $transportCost = $transportCost+$transportCostMarkup;
                }
                if($taxType == 2){
                    $transportCostTax = getMarkupCost($transportCostMarkup,$gstTax,$gstType);
                }else{
                    $transportCostTax = getMarkupCost($transportCost,$gstTax,$gstType);
                }
                $transportCost = $transportCost+$transportCostTax;
            }
            $totaltransportSameDay=$totaltransportSameDay+convert_to_base($qTransferData['currencyValue'],$baseCurrencyVal,trim($transportCost));
        }
        echo getTwoDecimalNumberFormat($totaltransportSameDay);
        $totalTransportCost = $totalTransportCost + $totaltransportSameDay;
        ?>
    </td>

    <td align="right" <?php echo $rowspan; ?>><?php
        $totalGuideSameDay = 0;
        $ddd2 = "";
        $ddd2 = GetPageRecord('*', 'quotationGuideMaster', ' 1 and fromDate="' . $dayDate . '" and quotationId="' . $quotationId . '" and serviceType=0  and isGuestType=1 and slabId in ( select id from totalPaxSlab where status=1 and quotationId = "' . $quotationId . '" )');
        while ($qGuideData = mysqli_fetch_array($ddd2)) {

            $markupCost = $qGuideData['markupCost'];
            $markupType = $qGuideData['markupType'];
            $gstTax = getGstValueById($qGuideData['gstTax']);
            $gstType = 1;
            $taxType = $qGuideData['taxType'];

            $priceCost = getCostWithGSTID_Markup($qGuideData['price'],$qGuideData['gstTax'],$qGuideData['markupCost'],$qGuideData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
                $priceCostMarkup = getMarkupCost($priceCost,$markupCost,$markupType);

                if($markupType==1){
                    $priceCost = $priceCost+($priceCostMarkup);
                }else{
                    $priceCostMarkup = $priceCostMarkup*$totalDFACI;
                    $priceCost = $priceCost+$priceCostMarkup;
                }

                // $priceCost = $priceCost+$priceCostMarkup;
                if($taxType == 2){
                    $priceCostTax = getMarkupCost($priceCostMarkup,$gstTax,$gstType);
                }else{
                    $priceCostTax = getMarkupCost($priceCost,$gstTax,$gstType);
                }
                $priceCost = $priceCost+$priceCostTax; 
            }    

            $totalGuideSameDay = $totalGuideSameDay + convert_to_base($qGuideData['currencyValue'],$baseCurrencyVal,trim($priceCost));
        }
        echo getTwoDecimalNumberFormat($totalGuideSameDay);
        $totalGuideCost = $totalGuideCost + $totalGuideSameDay;
        ?>
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        $totalFerrySameDayA = 0;
        $totalFerrySameDayC = 0;
        $totalFerrySameDayE = 0;
        $ddd2 = "";
        $ddd2 = GetPageRecord('*', _QUOTATION_FERRY_MASTER_, ' 1 and fromDate="' . $dayDate . '" and quotationId="' . $quotationId . '" ');
        while ($qFerryData = mysqli_fetch_array($ddd2)) {

            $markupCost = $qFerryData['markupCost'];
            $markupType = $qFerryData['markupType'];
            $gstTax = getGstValueById($qFerryData['gstTax']);
            $gstType = 1;
            $taxType = $qFerryData['taxType'];

            $ferryCostAA = trim($qFerryData['adultCost']+$qFerryData['miscCost']);

            $ferryCostA = getCostWithGSTID_Markup($ferryCostAA,$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
                $ferryCostAMarkup = getMarkupCost($ferryCostA,$markupCost,$markupType);
                $ferryCostA = $ferryCostA+$ferryCostAMarkup;
                if($taxType == 2){
                    $ferryCostATax = getMarkupCost($ferryCostAMarkup,$gstTax,$gstType);
                }else{
                    $ferryCostATax = getMarkupCost($ferryCostA,$gstTax,$gstType);
                }
                $ferryCostA = $ferryCostA+$ferryCostATax; 
            }


            $ferryCostCC = trim($qFerryData['childCost']+$qFerryData['miscCost']);
            $ferryCostC = getCostWithGSTID_Markup($ferryCostCC,$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){                 
                $ferryCostCMarkup = getMarkupCost($ferryCostC,$markupCost,$markupType);
                $ferryCostC = $ferryCostC+$ferryCostCMarkup;
                if($taxType == 2){
                    $ferryCostCTax = getMarkupCost($ferryCostCMarkup,$gstTax,$gstType);
                }else{
                    $ferryCostCTax = getMarkupCost($ferryCostC,$gstTax,$gstType);
                }
                $ferryCostC = $ferryCostC+$ferryCostCTax; 
            }

            $ferryCostEE = trim($qFerryData['infantCost']+$qFerryData['miscCost']);
            $ferryCostE = getCostWithGSTID_Markup($ferryCostEE,$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
                $ferryCostEMarkup = getMarkupCost($ferryCostE,$markupCost,$markupType);
                $ferryCostE = $ferryCostE+$ferryCostEMarkup;
                if($taxType == 2){
                    $ferryCostETax = getMarkupCost($ferryCostEMarkup,$gstTax,$gstType);
                }else{
                    $ferryCostETax = getMarkupCost($ferryCostE,$gstTax,$gstType);
                }
                $ferryCostE = $ferryCostE+$ferryCostETax; 
            }

            $totalFerrySameDayA = $totalFerrySameDayA + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,$ferryCostA);
            $totalFerrySameDayC = $totalFerrySameDayC + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,$ferryCostC);
            $totalFerrySameDayE = $totalFerrySameDayE + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,$ferryCostE);
        }
        echo getTwoDecimalNumberFormat($totalFerrySameDayA);
        $totalFerryCostA = ($totalFerryCostA + $totalFerrySameDayA);
        $totalFerryCostC = ($totalFerryCostC + $totalFerrySameDayC);
        $totalFerryCostE = ($totalFerryCostE + $totalFerrySameDayE);
        ?>
    </td>
    <td <?php echo $rowspan; ?> align="right" ><?php
        echo getTwoDecimalNumberFormat($totalFerrySameDayC);
        ?>
    </td>
    <td <?php echo $rowspan; ?> align="right" ><?php
        echo getTwoDecimalNumberFormat($totalFerrySameDayE);
        ?>
    </td>
    <?php
    if ($resultpageQuotation['flightCostType'] == 0) {
    ?>
     
    <td align="right" <?php echo $rowspan; ?> ><?php
        $totalflightSamDayC = 0;
        $totalflightSamDayA = 0;
        $totalflightSamDayE = 0;
        $d = GetPageRecord('*', 'quotationFlightMaster', 'quotationId="' . $quotationId . '"  and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
        while ($qflightD = mysqli_fetch_array($d)) {

            $markupCost = $qflightD['markupCost'];
            $markupType = $qflightD['markupType'];
            $gstTax = getGstValueById($qflightD['gstTax']);
            $gstType = 1;
            $taxType = $qflightD['taxType'];

            // $flightCostA = trim($qflightD['adultCost']);
            $flightCostA = getCostWithGSTID_Markup($qflightD['adultCost'],$qflightD['gstTax'],$qflightD['markupCost'],$qflightD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
                $flightCostAMarkup = getMarkupCost($flightCostA,$markupCost,$markupType);
                $flightCostA = $flightCostA+$flightCostAMarkup;
                if($taxType == 2){
                    $flightCostATax = getMarkupCost($flightCostAMarkup,$gstTax,$gstType);
                }else{
                    $flightCostATax = getMarkupCost($flightCostA,$gstTax,$gstType);
                }
                $flightCostA = $flightCostA+$flightCostATax; 
            }


            // $flightCostC = trim($qflightD['childCost']);
            $flightCostC = getCostWithGSTID_Markup($qflightD['childCost'],$qflightD['gstTax'],$qflightD['markupCost'],$qflightD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
                $flightCostCMarkup = getMarkupCost($flightCostC,$markupCost,$markupType);
                $flightCostC = $flightCostC+$flightCostCMarkup;
                if($taxType == 2){
                    $flightCostCTax = getMarkupCost($flightCostCMarkup,$gstTax,$gstType);
                }else{
                    $flightCostCTax = getMarkupCost($flightCostC,$gstTax,$gstType);
                }
                $flightCostC = $flightCostC+$flightCostCTax; 
            }

            $flightCostE = getCostWithGSTID_Markup($qflightD['infantCost'],$qflightD['gstTax'],$qflightD['markupCost'],$qflightD['markupType']);
            // $flightCostE = trim($qflightD['infantCost']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
                $flightCostEMarkup = getMarkupCost($flightCostE,$markupCost,$markupType);
                $flightCostE = $flightCostE+$flightCostEMarkup;
                if($taxType == 2){
                    $flightCostETax = getMarkupCost($flightCostEMarkup,$gstTax,$gstType);
                }else{
                    $flightCostETax = getMarkupCost($flightCostE,$gstTax,$gstType);
                }
                $flightCostE = $flightCostE+$flightCostETax; 
            }


            $totalflightSamDayA = convert_to_base($qflightD['currencyValue'], $baseCurrencyVal, trim($totalflightSamDayA + $flightCostA));
            $totalflightSamDayC = convert_to_base($qflightD['currencyValue'], $baseCurrencyVal, trim($totalflightSamDayC + $flightCostC));
            $totalflightSamDayE = convert_to_base($qflightD['currencyValue'], $baseCurrencyVal, trim($totalflightSamDayE + $flightCostE));
        }
        echo getTwoDecimalNumberFormat($totalflightSamDayA);
        $totalflightA = ($totalflightA + $totalflightSamDayA);
        $totalflightC = ($totalflightC + $totalflightSamDayC);
        $totalflightE = ($totalflightE + $totalflightSamDayE);

        ?>
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        echo getTwoDecimalNumberFormat($totalflightSamDayC);
        ?>
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        echo getTwoDecimalNumberFormat($totalflightSamDayE);
        ?>
    </td>
    <?php
    }
    ?>
    <td align="right" <?php echo $rowspan; ?> ><?php
        $d = "";
        $totaltrainSameDayA = 0;
        $totaltrainSameDayC = 0;
        $totaltrainSameDayE = 0;
        $d = GetPageRecord('*', 'quotationTrainsMaster', 'quotationId="' . $quotationId . '" and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
        while ($qtrainD = mysqli_fetch_array($d)) {

            $markupCost = $qtrainD['markupCost'];
            $markupType = $qtrainD['markupType'];
            $gstTax = getGstValueById($qtrainD['gstTax']);
            $gstType = 1;
            $taxType = $qtrainD['taxType'];

            // $trainCostA = trim($qtrainD['adultCost']);
            $trainCostA = getCostWithGSTID_Markup($qtrainD['adultCost'],$qtrainD['gstTax'],$qtrainD['markupCost'],$qtrainD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $trainCostAMarkup = getMarkupCost($trainCostA,$markupCost,$markupType);
                $trainCostA = $trainCostA+$trainCostAMarkup;
                if($taxType == 2){
                    $trainCostATax = getMarkupCost($trainCostAMarkup,$gstTax,$gstType);
                }else{
                    $trainCostATax = getMarkupCost($trainCostA,$gstTax,$gstType);
                }
                $trainCostA = $trainCostA+$trainCostATax;
            } 


            // $trainCostC = trim($qtrainD['childCost']);
            $trainCostC = getCostWithGSTID_Markup($qtrainD['childCost'],$qtrainD['gstTax'],$qtrainD['markupCost'],$qtrainD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $trainCostCMarkup = getMarkupCost($trainCostC,$markupCost,$markupType);
                $trainCostC = $trainCostC+$trainCostCMarkup;
                if($taxType == 2){
                    $trainCostCTax = getMarkupCost($trainCostCMarkup,$gstTax,$gstType);
                }else{
                    $trainCostCTax = getMarkupCost($trainCostC,$gstTax,$gstType);
                }
                $trainCostC = $trainCostC+$trainCostCTax;
            }


            // $trainCostE = trim($qtrainD['infantCost']);
            $trainCostE = getCostWithGSTID_Markup($qtrainD['infantCost'],$qtrainD['gstTax'],$qtrainD['markupCost'],$qtrainD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $trainCostEMarkup = getMarkupCost($trainCostE,$markupCost,$markupType);
                $trainCostE = $trainCostE+$trainCostEMarkup;
                if($taxType == 2){
                    $trainCostETax = getMarkupCost($trainCostEMarkup,$gstTax,$gstType);
                }else{
                    $trainCostETax = getMarkupCost($trainCostE,$gstTax,$gstType);
                }
                $trainCostE = $trainCostE+$trainCostETax;
            }

            $totaltrainSameDayA = convert_to_base($qtrainD['currencyValue'], $baseCurrencyVal, trim($totaltrainSameDayA + $trainCostA));
            $totaltrainSameDayC = convert_to_base($qtrainD['currencyValue'], $baseCurrencyVal, trim($totaltrainSameDayC + $trainCostC));
            $totaltrainSameDayE = convert_to_base($qtrainD['currencyValue'], $baseCurrencyVal, trim($totaltrainSameDayE + $trainCostE));
        }
        echo getTwoDecimalNumberFormat($totaltrainSameDayA);
        $totaltrainA = ($totaltrainA + $totaltrainSameDayA);
        $totaltrainC = ($totaltrainC + $totaltrainSameDayC);
        $totaltrainE = ($totaltrainE + $totaltrainSameDayE);
        ?>
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        if($paxChild>0){
        echo getTwoDecimalNumberFormat($totaltrainSameDayC);
        } 
        ?>
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        if($paxInfant>0){
        echo getTwoDecimalNumberFormat($totaltrainSameDayE);
        }
        ?>
    </td>

    <td align="right" <?php echo $rowspan; ?> ><?php
        $totalEntSameDayA = 0;
        $totalEntSameDayC = 0;
        $totalEntSameDayE = 0;
        $d = GetPageRecord('*', 'quotationEntranceMaster', 'quotationId="'.$quotationId.'" and fromDate="'.$dayDate.'" order by id asc');
        while ($qEntranceD = mysqli_fetch_array($d)) {
            if($qEntranceD['transferType']!=2){
            $markupCostEnt = $qEntranceD['markupCost'];
            $markupTypeEnt = $qEntranceD['markupType'];
            $gstTaxEnt = $qEntranceD['gstTax'];
            }
            $gstTax = getGstValueById($qEntranceD['gstTax']);
            $gstType = 1;
            $taxType = $qEntranceD['taxType'];
        
            if($qEntranceD['transferType'] == 1){
                $entranceCostA = ($qEntranceD['ticketAdultCost']+$qEntranceD['adultCost']+$qEntranceD['repCost'])*$qEntranceD['adultPax'];            
            }else{
                $qEntranceTPTCostA = 0;
                if($DF_SGL>0 || $DF_DBL>0 || $DF_TWN>0 || $DF_TPL>0 || $DF_QUAD>0 || $DF_SIX>0 || $DF_EIGHT>0 || $DF_TEN>0 || $DF_ABED>0){
                    $qEntranceTPTCostA = getCostWithGSTID_Markup(($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles']),$qEntranceD['gstTax'],$qEntranceD['markupCost'],$qEntranceD['markupType']);
                    $qEntranceTPTCostA = $qEntranceTPTCostA/$totalDF;

                }
                $entranceCostA = ($qEntranceD['ticketAdultCost']+$qEntranceTPTCostA+$qEntranceD['repCost'])*$qEntranceD['adultPax'];
            } 
            $entranceCostA = getCostWithGSTID_Markup($entranceCostA,$gstTaxEnt,$markupCostEnt,$markupTypeEnt);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $entranceCostAMarkup = getMarkupCost($entranceCostA,$markupCost,$markupType);
                $entranceCostA = $entranceCostA+$entranceCostAMarkup;
                if($taxType == 2){
                    $entranceCostATax = getMarkupCost($entranceCostAMarkup,$gstTax,$gstType);
                }else{
                    $entranceCostATax = getMarkupCost($entranceCostA,$gstTax,$gstType);
                }
                $entranceCostA = $entranceCostA+$entranceCostATax; 
            }



            if($qEntranceD['transferType'] == 1){
                $entranceCostC = ($qEntranceD['ticketchildCost']+$qEntranceD['childCost']+$qEntranceD['repCost'])*$qEntranceD['childPax'];            
            }else{
                $qEntranceTPTCostC = 0;
                if($DF_CBED>0){
                    // (($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles'])/$totalDF);
                    $qEntranceTPTCostC = getCostWithGSTID_Markup(($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles']),$qEntranceD['gstTax'],$qEntranceD['markupCost'],$qEntranceD['markupType']);
                    $qEntranceTPTCostC = $qEntranceTPTCostC/$totalDF;
                }
                $entranceCostC = ($qEntranceD['ticketchildCost']+$qEntranceTPTCostC+$qEntranceD['repCost'])*$qEntranceD['childPax'];
            } 
            $entranceCostC = getCostWithGSTID_Markup($entranceCostC,$gstTaxEnt,$markupCostEnt,$markupTypeEnt);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $entranceCostCMarkup = getMarkupCost($entranceCostC,$markupCost,$markupType);
                $entranceCostC = $entranceCostC+$entranceCostCMarkup;
                if($taxType == 2){
                    $entranceCostCTax = getMarkupCost($entranceCostCMarkup,$gstTax,$gstType);
                }else{
                    $entranceCostCTax = getMarkupCost($entranceCostC,$gstTax,$gstType);
                }
                $entranceCostC = $entranceCostC+$entranceCostCTax;
            }

            if($qEntranceD['transferType'] == 1){
                $entranceCostE = ($qEntranceD['ticketinfantCost']+$qEntranceD['infantCost']+$qEntranceD['repCost'])*$qEntranceD['infantPax'];            
            }else{
                $qEntranceTPTCostE = 0;
                // if($DF_CBED>0){
                //     $qEntranceTPTCostE = (($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles'])/$totalDF);
                // }
              
                $entranceCostE = ($qEntranceD['ticketinfantCost']+$qEntranceTPTCostE+$qEntranceD['repCost'])*$qEntranceD['infantPax'];
            }
            $entranceCostE = getCostWithGSTID_Markup($entranceCostE,$gstTaxEnt,$markupCostEnt,$markupTypeEnt);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $entranceCostEMarkup = getMarkupCost($entranceCostE,$markupCost,$markupType);
                $entranceCostE = $entranceCostE+$entranceCostEMarkup;
                if($taxType == 2){
                    $entranceCostETax = getMarkupCost($entranceCostEMarkup,$gstTax,$gstType);
                }else{
                    $entranceCostETax = getMarkupCost($entranceCostE,$gstTax,$gstType);
                }
                $entranceCostE = $entranceCostE+$entranceCostETax;
            }

            $totalEntSameDayA = $totalEntSameDayA + convert_to_base($qEntranceD['currencyValue'], $baseCurrencyVal,trim($entranceCostA));
            $totalEntSameDayC = $totalEntSameDayC + convert_to_base($qEntranceD['currencyValue'], $baseCurrencyVal,trim($entranceCostC));
            $totalEntSameDayE = $totalEntSameDayE + convert_to_base($qEntranceD['currencyValue'], $baseCurrencyVal,trim($entranceCostE));
        }
        if($totalPax>0){
            echo getTwoDecimalNumberFormat($totalEntSameDayA);
        }    
        $totalentcostA = ($totalentcostA + trim($totalEntSameDayA));
        $totalentcostC = ($totalentcostC + trim($totalEntSameDayC));
        $totalentcostE = ($totalentcostE + trim($totalEntSameDayE));
        ?>  
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        if($paxChild>0){
            echo getTwoDecimalNumberFormat($totalEntSameDayC);
        }
        ?>  
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        if($paxInfant>0){
            echo getTwoDecimalNumberFormat($totalEntSameDayE);
        }
        ?>  
    </td>

    <!-- sightseeing cost --> 
    <td align="right" <?php echo $rowspan; ?> ><?php
        $totalActSameDayA = 0;
        $totalActSameDayC = 0;
        $totalActSameDayE = 0;
        $e ='';
        $e = GetPageRecord('*', 'quotationOtherActivitymaster', 'quotationId="'.$quotationId.'" and fromDate="'.$dayDate.'" order by id asc');
        while ($qActivityD = mysqli_fetch_array($e)){
            if($qActivityD['transferType']!=2){
            $markupCostAct = $qActivityD['markupCost'];
            $markupTypeAct = $qActivityD['markupType'];
            $gstTaxAct = $qActivityD['gstTax'];
            }
            $gstTax = getGstValueById($qActivityD['gstTax']);
            $gstType = 1;
            $taxType = $qActivityD['taxType'];
            $totalPaxAct = $qActivityD['adultPax']+$qActivityD['childPax'];
             
            if($qActivityD['transferType'] == 1){
                $activityCostA = ($qActivityD['ticketAdultCost']+$qActivityD['adultCost']+$qActivityD['repCost'])*$qActivityD['adultPax'];            
                $activityCostC = ($qActivityD['ticketchildCost']+$qActivityD['childCost']+$qActivityD['repCost'])*$qActivityD['childPax'];            
                $activityCostE = ($qActivityD['ticketinfantCost']+$qActivityD['infantCost']+$qActivityD['repCost'])*$qActivityD['infantPax'];            
            }else{      
                $vehicleCostACtPur = $qActivityD['vehicleCost']*$qActivityD['noOfVehicles'];
 
                $vehicleCostM = getMarkupCost($vehicleCostACtPur,$qActivityD['markupCost'],$qActivityD['markupType']);
                $vehicleCostAct = $vehicleCostM+$vehicleCostACtPur;
                $activityCostA = ($qActivityD['ticketAdultCost']+(($vehicleCostAct)/$totalPaxAct)+$qActivityD['repCost'])*$qActivityD['adultPax'];
                $activityCostC = ($qActivityD['ticketchildCost']+(($vehicleCostAct)/$totalPaxAct)+$qActivityD['repCost'])*$qActivityD['childPax'];
                $activityCostE = ($qActivityD['ticketinfantCost']+$qActivityTPTCostE+$qActivityD['repCost'])*$qActivityD['infantPax'];
            }
            $activityCostA = getCostWithGSTID_Markup($activityCostA,$gstTaxAct,$markupCostAct,$markupTypeAct);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $activityCostAMarkup = getMarkupCost($activityCostA,$markupCost,$markupType);
                $activityCostA = $activityCostA+$activityCostAMarkup;
                if($taxType == 2){
                    $activityCostATax = getMarkupCost($activityCostAMarkup,$gstTax,$gstType);
                }else{
                    $activityCostATax = getMarkupCost($activityCostA,$gstTax,$gstType);
                }
                $activityCostA = $activityCostA+$activityCostATax; 
            }
            
            $activityCostC = getCostWithGSTID_Markup($activityCostC,$gstTaxAct,$markupCostAct,$markupTypeAct);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $activityCostCMarkup = getMarkupCost($activityCostC,$markupCost,$markupType);
                $activityCostC = $activityCostC+$activityCostCMarkup;
                if($taxType == 2){
                    $activityCostCTax = getMarkupCost($activityCostCMarkup,$gstTax,$gstType);
                }else{
                    $activityCostCTax = getMarkupCost($activityCostC,$gstTax,$gstType);
                }
                $activityCostC = $activityCostC+$activityCostCTax;
            } 

            $activityCostE = getCostWithGSTID_Markup($activityCostE,$gstTaxAct,$markupCostAct,$markupTypeAct);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $activityCostEMarkup = getMarkupCost($activityCostE,$markupCost,$markupType);
                $activityCostE = $activityCostE+$activityCostEMarkup;
                if($taxType == 2){
                    $activityCostETax = getMarkupCost($activityCostEMarkup,$gstTax,$gstType);
                }else{
                    $activityCostETax = getMarkupCost($activityCostE,$gstTax,$gstType);
                }
                $activityCostE = $activityCostE+$activityCostETax;
            }

            $totalActSameDayA = $totalActSameDayA + convert_to_base($qActivityD['currencyValue'],$baseCurrencyVal,trim($activityCostA));
            $totalActSameDayC = $totalActSameDayC + convert_to_base($qActivityD['currencyValue'],$baseCurrencyVal,trim($activityCostC));
            $totalActSameDayE = $totalActSameDayE + convert_to_base($qActivityD['currencyValue'],$baseCurrencyVal,trim($activityCostE));

        }
        if($totalPax>0){
            echo getTwoDecimalNumberFormat($totalActSameDayA);
        }    
        $totalActcostA = ($totalActcostA + trim($totalActSameDayA));
        $totalActcostC = ($totalActcostC + trim($totalActSameDayC));
        $totalActcostE = ($totalActcostE + trim($totalActSameDayE));
        ?>  
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        if($paxChild>0){
            echo getTwoDecimalNumberFormat($totalActSameDayC);
        }
        ?>  
    </td>
    <td align="right" <?php echo $rowspan; ?> ><?php
        if($paxInfant>0){
            echo getTwoDecimalNumberFormat($totalActSameDayE);
        }
        ?>  
    </td>
    <!-- sightseeing block end -->



    <!-- additional block start -->
    <td align="right" ><?php
    $totalDayExtraA = 0;
    $totalDayExtraC = 0;
    $totalDayExtraE = 0;
    $totalDayExtraG = 0;
    $d21 = GetPageRecord('*', 'quotationExtraMaster', 'quotationId="' . $quotationId . '" and  fromDate="' . $dayDate . '" and isMarkupApply=0  order by id asc');
    while ($quotExtraData = mysqli_fetch_array($d21)) {
        $markupCost = $quotExtraData['markupCost'];
        $markupType = $quotExtraData['markupType'];
        $gstTax = getGstValueById($quotExtraData['gstTax']);
        $gstType = 1;
        $taxType = $quotExtraData['taxType'];
     
        if ($quotExtraData['costType']==2){
            $totalDayExtraG = $totalDayExtraG + convert_to_base($quotExtraData['currencyValue'],$baseCurrencyVal, getCostWithGSTID_Markup($quotExtraData['groupCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']));
        }else {
            $totalDayExtraA = $totalDayExtraA + convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, ( getCostWithGSTID_Markup($quotExtraData['adultCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType'])*$quotExtraData['adultPax']));
            $totalDayExtraC = $totalDayExtraC + convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotExtraData['childCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType'])*$quotExtraData['childPax']));
            $totalDayExtraE = $totalDayExtraE + convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotExtraData['infantCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType'])*$quotExtraData['infantPax']));
        }
        // if domestic service wise markup
        if($isSer_Mark == 1 && $isUni_Mark == 0){
            $totalDayExtraGMarkup = getMarkupCost($totalDayExtraG,$markupCost,$markupType);
            $totalDayExtraG = $totalDayExtraG+$totalDayExtraGMarkup;
            if($taxType == 2){
                $totalDayExtraGTax = getMarkupCost($totalDayExtraGMarkup,$gstTax,$gstType);
            }else{
                $totalDayExtraGTax = getMarkupCost($totalDayExtraG,$gstTax,$gstType);
            }
            $totalDayExtraG = $totalDayExtraG+$totalDayExtraGTax; 
        }
        // if domestic service wise markup
        if($isSer_Mark == 1 && $isUni_Mark == 0){
            $totalDayExtraAMarkup = getMarkupCost($totalDayExtraA,$markupCost,$markupType);
            $totalDayExtraA = $totalDayExtraA+$totalDayExtraAMarkup;
            if($taxType == 2){
                $totalDayExtraATax = getMarkupCost($totalDayExtraAMarkup,$gstTax,$gstType);
            }else{
                $totalDayExtraATax = getMarkupCost($totalDayExtraA,$gstTax,$gstType);
            }
            $totalDayExtraA = $totalDayExtraA+$totalDayExtraATax; 
        }
        // if domestic service wise markup
        if($isSer_Mark == 1 && $isUni_Mark == 0){
            $totalDayExtraCMarkup = getMarkupCost($totalDayExtraC,$markupCost,$markupType);
            $totalDayExtraC = $totalDayExtraC+$totalDayExtraCMarkup;
            if($taxType == 2){
                $totalDayExtraCTax = getMarkupCost($totalDayExtraCMarkup,$gstTax,$gstType);
            }else{
                $totalDayExtraCTax = getMarkupCost($totalDayExtraC,$gstTax,$gstType);
            }
            $totalDayExtraC = $totalDayExtraC+$totalDayExtraCTax;
        }
        // if domestic service wise markup
        if($isSer_Mark == 1 && $isUni_Mark == 0){
            $totalDayExtraEMarkup = getMarkupCost($totalDayExtraE,$markupCost,$markupType);
            $totalDayExtraE = $totalDayExtraE+$totalDayExtraEMarkup;
            if($taxType == 2){
                $totalDayExtraETax = getMarkupCost($totalDayExtraEMarkup,$gstTax,$gstType);
            }else{
                $totalDayExtraETax = getMarkupCost($totalDayExtraE,$gstTax,$gstType);
            }
            $totalDayExtraE = $totalDayExtraE+$totalDayExtraETax;
        }
            
        // $totalDayExtraA = getCostWithGSTID_Markup($totalDayExtraA,$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);
        // $totalDayExtraC = getCostWithGSTID_Markup($totalDayExtraC,$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);
        // $totalDayExtraE = getCostWithGSTID_Markup($totalDayExtraE,$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);
        // $totalDayExtraG = getCostWithGSTID_Markup($totalDayExtraG,$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);
    }
    $totalExtraCostA = ($totalExtraCostA + $totalDayExtraA);
    $totalExtraCostC = ($totalExtraCostC + $totalDayExtraC);
    $totalExtraCostE = ($totalExtraCostE + $totalDayExtraE);
    $totalExtraCostG = ($totalExtraCostG + $totalDayExtraG);
    echo  getTwoDecimalNumberFormat($totalDayExtraA);
    ?>
    </td>
    <?php //if($paxChild>0){ ?>
    <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayExtraC); ?></td>
    <?php //}if ($paxInfant>0) { ?>
    <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayExtraE); ?></td> 
    <?php //}if ($totalPax>0) { ?>
    <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayExtraG); ?></td>
    <?php //} ?>
    <!-- additional block end -->

    <!-- restaurant block start -->
    <td align="right" ><?php
    $totalDayRestaurantA = 0;
    $totalDayRestaurantC = 0;
    $totalDayRestaurantE = 0;
    $d21 = GetPageRecord('*', 'quotationInboundmealplanmaster', 'quotationId="' . $quotationId . '" and  fromDate="' . $dayDate . '" order by id asc');
    while ($quotRestData = mysqli_fetch_array($d21)) {
        $markupCost = $quotRestData['markupCost'];
        $markupType = $quotRestData['markupType'];
        $gstTax = getGstValueById($quotRestData['gstTax']);
        $gstType = 1;
        $taxType = $quotRestData['taxType'];

        $totalDayRestaurantA = $totalDayRestaurantA + convert_to_base($quotRestData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotRestData['adultCost'],$quotRestData['gstTax'],$quotRestData['markupCost'],$quotRestData['markupType'])*$quotRestData['adultPax']));
        $totalDayRestaurantC = $totalDayRestaurantC + convert_to_base($quotRestData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotRestData['childCost'],$quotRestData['gstTax'],$quotRestData['markupCost'],$quotRestData['markupType'])*$quotRestData['childPax']));
        $totalDayRestaurantE = $totalDayRestaurantE + convert_to_base($quotRestData['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($quotRestData['infantCost'],$quotRestData['gstTax'],$quotRestData['markupCost'],$quotRestData['markupType'])*$quotRestData['infantPax']));

        // if domestic service wise markup
        if($isSer_Mark == 1 && $isUni_Mark == 0){
            $totalDayRestaurantAMarkup = getMarkupCost($totalDayRestaurantA,$markupCost,$markupType);
            $totalDayRestaurantA = $totalDayRestaurantA+$totalDayRestaurantAMarkup;
            if($taxType == 2){
                $totalDayRestaurantATax = getMarkupCost($totalDayRestaurantAMarkup,$gstTax,$gstType);
            }else{
                $totalDayRestaurantATax = getMarkupCost($totalDayRestaurantA,$gstTax,$gstType);
            }
            $totalDayRestaurantA = $totalDayRestaurantA+$totalDayRestaurantATax; 
        }
        // if domestic service wise markup
        if($isSer_Mark == 1 && $isUni_Mark == 0){
            $totalDayRestaurantCMarkup = getMarkupCost($totalDayRestaurantC,$markupCost,$markupType);
            $totalDayRestaurantC = $totalDayRestaurantC+$totalDayRestaurantCMarkup;
            if($taxType == 2){
                $totalDayRestaurantCTax = getMarkupCost($totalDayRestaurantCMarkup,$gstTax,$gstType);
            }else{
                $totalDayRestaurantCTax = getMarkupCost($totalDayRestaurantC,$gstTax,$gstType);
            }
            $totalDayRestaurantC = $totalDayRestaurantC+$totalDayRestaurantCTax;
        }
        // if domestic service wise markup
        if($isSer_Mark == 1 && $isUni_Mark == 0){
            $totalDayRestaurantEMarkup = getMarkupCost($totalDayRestaurantE,$markupCost,$markupType);
            $totalDayRestaurantE = $totalDayRestaurantE+$totalDayRestaurantEMarkup;
            if($taxType == 2){
                $totalDayRestaurantETax = getMarkupCost($totalDayRestaurantEMarkup,$gstTax,$gstType);
            }else{
                $totalDayRestaurantETax = getMarkupCost($totalDayRestaurantE,$gstTax,$gstType);
            }
            $totalDayRestaurantE = $totalDayRestaurantE+$totalDayRestaurantETax;
        } 
    }
    $totalRestaurantCostA = ($totalRestaurantCostA + $totalDayRestaurantA);
    $totalRestaurantCostC = ($totalRestaurantCostC + $totalDayRestaurantC);
    $totalRestaurantCostE = ($totalRestaurantCostE + $totalDayRestaurantE); 
    echo  getTwoDecimalNumberFormat($totalDayRestaurantA);
    ?>
    </td>
    <?php //if($paxChild>0){ ?>
    <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayRestaurantC); ?></td>
    <?php //}if ($paxInfant>0) { ?>
    <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayRestaurantE); ?></td> 
    <?php //} ?>
    <!-- restaurant block end -->
 
    <?php
    } 
    if($samedayCnt<$rows){
        echo '</tr>';
    }
    $samedayCnt++; }
    
    }else{
            ?>
            <td></td>
            <td>0</td>
            <td>0</td>

            <?php if($twinRoom>0){ ?>
            <td>0</td>
            <?php } if($tripleRoom>0){?>
            <td>0</td>
            <?php } if($quadBedRoom>0){?>
            <td>0</td>
            <?php } if($sixBedRoom>0){?>
            <td>0</td>
            <?php } if($eightBedRoom>0){?>
            <td>0</td>
            <?php } if($tenBedRoom>0){?>
            <td>0</td>
            <?php } if($teenBedRoom>0){?>
            <td>0</td>
            <?php } if($EBedAdult>0){?>
            <td>0</td>
            <?php } if($EBedChild>0){?>
            <td>0</td>
            <?php } if($NBedChild>0){?>
            <td>0</td>
            <?php } ?>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td> 

            <td align="right" <?php echo $rowspan; ?> > 
            <?php
            $totaltransportSameDay = 0;
            $rsa2 = "";
            $rsa2 = GetPageRecord('*', _QUOTATION_TRANSFER_MASTER_, ' quotationId="'.$quotationId.'" and fromDate="' . $dayDate . '" and totalPax in ( select id from totalPaxSlab where status = 1 and quotationId = "' . $quotationId . '" ) order by fromDate asc');
            while ($qTransferData = mysqli_fetch_array($rsa2)) {
            //cost break up info
            $markupCost = $qTransferData['markupCost'];
            $markupType = $qTransferData['markupType'];
            $gstTax = getGstValueById($qTransferData['gstTax']);
            $gstType = 1;
            $taxType = $qTransferData['taxType'];

            if($qTransferData['transferType'] == 1){
            $transportCost=($qTransferData['adultCost']*$paxAdult)+($qTransferData['childCost']*$paxChild)+($qTransferData['infantCost']*$paxInfant);
            }else{
            $transportCost = ($qTransferData['vehicleCost'] * $qTransferData['noOfVehicles']);
            }
            $transportCost = getCostWithGSTID_Markup($transportCost,$qTransferData['gstTax'],$qTransferData['markupCost'],$qTransferData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
            $transportCostMarkup = getMarkupCost($transportCost,$markupCost,$markupType);

            if($markupType==1){
                $transportCost = $transportCost+($transportCostMarkup);
            }else{
                if($qTransferData['transferType'] == 1){
                    $transportCostMarkup = $transportCostMarkup*$totalDFACI;
                }else{
                    $transportCostMarkup = $transportCostMarkup*$qTransferData['noOfVehicles'];
                }

                
                $transportCost = $transportCost+$transportCostMarkup;
            }

            // $transportCost = $transportCost+$transportCostMarkup;
            if($taxType == 2){
                $transportCostTax = getMarkupCost($transportCostMarkup,$gstTax,$gstType);
            }else{
                $transportCostTax = getMarkupCost($transportCost,$gstTax,$gstType);
            }
            $transportCost = $transportCost+$transportCostTax;
            }
            $totaltransportSameDay=$totaltransportSameDay+convert_to_base($qTransferData['currencyValue'],$baseCurrencyVal,trim($transportCost));
            }
            echo getTwoDecimalNumberFormat($totaltransportSameDay);
            $totalTransportCost = $totalTransportCost + $totaltransportSameDay;
            ?>
            </td>

            <td align="right" <?php echo $rowspan; ?>><?php
            $totalGuideSameDay = 0;
            $ddd2 = "";
            $ddd2 = GetPageRecord('*', 'quotationGuideMaster', ' 1 and fromDate="' . $dayDate . '" and quotationId="' . $quotationId . '" and serviceType=0  and isGuestType=1 and slabId in ( select id from totalPaxSlab where status=1 and quotationId = "' . $quotationId . '" )');
            while ($qGuideData = mysqli_fetch_array($ddd2)) {

            $markupCost = $qGuideData['markupCost'];
            $markupType = $qGuideData['markupType'];
            $gstTax = getGstValueById($qGuideData['gstTax']);
            $gstType = 1;
            $taxType = $qGuideData['taxType'];

            $priceCost = getCostWithGSTID_Markup($qGuideData['price'],$qGuideData['gstTax'],$qGuideData['markupCost'],$qGuideData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
            $priceCostMarkup = getMarkupCost($priceCost,$markupCost,$markupType);
            if($markupType==1){
                $priceCost = $priceCost+($priceCostMarkup);
            }else{
                $priceCostMarkup = $priceCostMarkup*$totalDFACI;
                $priceCost = $priceCost+$priceCostMarkup;
            }
           
            if($taxType == 2){
                $priceCostTax = getMarkupCost($priceCostMarkup,$gstTax,$gstType);
            }else{
                $priceCostTax = getMarkupCost($priceCost,$gstTax,$gstType);
            }
            $priceCost = $priceCost+$priceCostTax; 
            }    

            $totalGuideSameDay = $totalGuideSameDay + convert_to_base($qGuideData['currencyValue'],$baseCurrencyVal,trim($priceCost));
            }
            echo getTwoDecimalNumberFormat($totalGuideSameDay);
            $totalGuideCost = $totalGuideCost + $totalGuideSameDay;
            ?>
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            $totalFerrySameDayA = 0;
            $totalFerrySameDayC = 0;
            $totalFerrySameDayE = 0;
            $ddd2 = "";
            $ddd2 = GetPageRecord('*', _QUOTATION_FERRY_MASTER_, ' 1 and fromDate="' . $dayDate . '" and quotationId="' . $quotationId . '" ');
            while ($qFerryData = mysqli_fetch_array($ddd2)) {

            $markupCost = $qFerryData['markupCost'];
            $markupType = $qFerryData['markupType'];
            $gstTax = getGstValueById($qFerryData['gstTax']);
            $gstType = 1;
            $taxType = $qFerryData['taxType'];

            $ferryCostAA = trim($qFerryData['adultCost']+$qFerryData['miscCost']);
            $ferryCostA = getCostWithGSTID_Markup($ferryCostAA,$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
            $ferryCostAMarkup = getMarkupCost($ferryCostA,$markupCost,$markupType);
            $ferryCostA = $ferryCostA+$ferryCostAMarkup;
            if($taxType == 2){
                $ferryCostATax = getMarkupCost($ferryCostAMarkup,$gstTax,$gstType);
            }else{
                $ferryCostATax = getMarkupCost($ferryCostA,$gstTax,$gstType);
            }
            $ferryCostA = $ferryCostA+$ferryCostATax; 
            }


            $ferryCostCC = trim($qFerryData['childCost']+$qFerryData['miscCost']); 
            $ferryCostC = getCostWithGSTID_Markup($ferryCostCC,$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){                 
            $ferryCostCMarkup = getMarkupCost($ferryCostC,$markupCost,$markupType);
            $ferryCostC = $ferryCostC+$ferryCostCMarkup;
            if($taxType == 2){
                $ferryCostCTax = getMarkupCost($ferryCostCMarkup,$gstTax,$gstType);
            }else{
                $ferryCostCTax = getMarkupCost($ferryCostC,$gstTax,$gstType);
            }
            $ferryCostC = $ferryCostC+$ferryCostCTax; 
            }

            $ferryCostEE = trim($qFerryData['infantCost']+$qFerryData['miscCost']);
            $ferryCostE = getCostWithGSTID_Markup($ferryCostEE,$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
            $ferryCostEMarkup = getMarkupCost($ferryCostE,$markupCost,$markupType);
            $ferryCostE = $ferryCostE+$ferryCostEMarkup;
            if($taxType == 2){
                $ferryCostETax = getMarkupCost($ferryCostEMarkup,$gstTax,$gstType);
            }else{
                $ferryCostETax = getMarkupCost($ferryCostE,$gstTax,$gstType);
            }
            $ferryCostE = $ferryCostE+$ferryCostETax; 
            }

            $totalFerrySameDayA = $totalFerrySameDayA + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,$ferryCostA);
            $totalFerrySameDayC = $totalFerrySameDayC + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,$ferryCostC);
            $totalFerrySameDayE = $totalFerrySameDayE + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,$ferryCostE);
            }
            echo getTwoDecimalNumberFormat($totalFerrySameDayA);
            $totalFerryCostA = ($totalFerryCostA + $totalFerrySameDayA);
            $totalFerryCostC = ($totalFerryCostC + $totalFerrySameDayC);
            $totalFerryCostE = ($totalFerryCostE + $totalFerrySameDayE);
            ?>
            </td>
            <td <?php echo $rowspan; ?> align="right" ><?php
            echo getTwoDecimalNumberFormat($totalFerrySameDayC);
            ?>
            </td>
            <td <?php echo $rowspan; ?> align="right" ><?php
            echo getTwoDecimalNumberFormat($totalFerrySameDayE);
            ?>
            </td>
            <?php
            if ($resultpageQuotation['flightCostType'] == 0) {
            ?>

            <td align="right" <?php echo $rowspan; ?> ><?php
            $totalflightSamDayC = 0;
            $totalflightSamDayA = 0;
            $totalflightSamDayE = 0;
            $d = GetPageRecord('*', 'quotationFlightMaster', 'quotationId="' . $quotationId . '"  and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
            while ($qflightD = mysqli_fetch_array($d)) {

            $markupCost = $qflightD['markupCost'];
            $markupType = $qflightD['markupType'];
            $gstTax = getGstValueById($qflightD['gstTax']);
            $gstType = 1;
            $taxType = $qflightD['taxType'];

            // $flightCostA = trim($qflightD['adultCost']);
            $flightCostA = getCostWithGSTID_Markup($qflightD['adultCost'],$qflightD['gstTax'],$qflightD['markupCost'],$qflightD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
            $flightCostAMarkup = getMarkupCost($flightCostA,$markupCost,$markupType);
            $flightCostA = $flightCostA+$flightCostAMarkup;
            if($taxType == 2){
                $flightCostATax = getMarkupCost($flightCostAMarkup,$gstTax,$gstType);
            }else{
                $flightCostATax = getMarkupCost($flightCostA,$gstTax,$gstType);
            }
            $flightCostA = $flightCostA+$flightCostATax; 
            }

            $flightCostC = getCostWithGSTID_Markup($qflightD['childCost'],$qflightD['gstTax'],$qflightD['markupCost'],$qflightD['markupType']);
            // $flightCostC = trim($qflightD['childCost']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
            $flightCostCMarkup = getMarkupCost($flightCostC,$markupCost,$markupType);
            $flightCostC = $flightCostC+$flightCostCMarkup;
            if($taxType == 2){
                $flightCostCTax = getMarkupCost($flightCostCMarkup,$gstTax,$gstType);
            }else{
                $flightCostCTax = getMarkupCost($flightCostC,$gstTax,$gstType);
            }
            $flightCostC = $flightCostC+$flightCostCTax; 
            }


            // $flightCostE = trim($qflightD['infantCost']);
            $flightCostE = getCostWithGSTID_Markup($qflightD['infantCost'],$qflightD['gstTax'],$qflightD['markupCost'],$qflightD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){ 
            $flightCostEMarkup = getMarkupCost($flightCostE,$markupCost,$markupType);
            $flightCostE = $flightCostE+$flightCostEMarkup;
            if($taxType == 2){
                $flightCostETax = getMarkupCost($flightCostEMarkup,$gstTax,$gstType);
            }else{
                $flightCostETax = getMarkupCost($flightCostE,$gstTax,$gstType);
            }
            $flightCostE = $flightCostE+$flightCostETax; 
            }


            $totalflightSamDayA = convert_to_base($qflightD['currencyValue'], $baseCurrencyVal, trim($totalflightSamDayA + $flightCostA));
            $totalflightSamDayC = convert_to_base($qflightD['currencyValue'], $baseCurrencyVal, trim($totalflightSamDayC + $flightCostC));
            $totalflightSamDayE = convert_to_base($qflightD['currencyValue'], $baseCurrencyVal, trim($totalflightSamDayE + $flightCostE));
            }
            echo getTwoDecimalNumberFormat($totalflightSamDayA);
            $totalflightA = ($totalflightA + $totalflightSamDayA);
            $totalflightC = ($totalflightC + $totalflightSamDayC);
            $totalflightE = ($totalflightE + $totalflightSamDayE);

            ?>
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            echo getTwoDecimalNumberFormat($totalflightSamDayC);
            ?>
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            echo getTwoDecimalNumberFormat($totalflightSamDayE);
            ?>
            </td>
            <?php
            }
            ?>
            <td align="right" <?php echo $rowspan; ?> ><?php
            $d = "";
            $totaltrainSameDayA = 0;
            $totaltrainSameDayC = 0;
            $totaltrainSameDayE = 0;
            $d = GetPageRecord('*', 'quotationTrainsMaster', 'quotationId="' . $quotationId . '" and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
            while ($qtrainD = mysqli_fetch_array($d)) {

            $markupCost = $qtrainD['markupCost'];
            $markupType = $qtrainD['markupType'];
            $gstTax = getGstValueById($qtrainD['gstTax']);
            $gstType = 1;
            $taxType = $qtrainD['taxType'];

            // $trainCostA = trim($qtrainD['adultCost']);
            $trainCostA = getCostWithGSTID_Markup($qtrainD['adultCost'],$qtrainD['gstTax'],$qtrainD['markupCost'],$qtrainD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
            $trainCostAMarkup = getMarkupCost($trainCostA,$markupCost,$markupType);
            $trainCostA = $trainCostA+$trainCostAMarkup;
            if($taxType == 2){
                $trainCostATax = getMarkupCost($trainCostAMarkup,$gstTax,$gstType);
            }else{
                $trainCostATax = getMarkupCost($trainCostA,$gstTax,$gstType);
            }
            $trainCostA = $trainCostA+$trainCostATax;
            } 


            // $trainCostC = trim($qtrainD['childCost']);
            $trainCostC = getCostWithGSTID_Markup($qtrainD['childCost'],$qtrainD['gstTax'],$qtrainD['markupCost'],$qtrainD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
            $trainCostCMarkup = getMarkupCost($trainCostC,$markupCost,$markupType);
            $trainCostC = $trainCostC+$trainCostCMarkup;
            if($taxType == 2){
                $trainCostCTax = getMarkupCost($trainCostCMarkup,$gstTax,$gstType);
            }else{
                $trainCostCTax = getMarkupCost($trainCostC,$gstTax,$gstType);
            }
            $trainCostC = $trainCostC+$trainCostCTax;
            }


            // $trainCostE = trim($qtrainD['infantCost']);
            $trainCostE = getCostWithGSTID_Markup($qtrainD['infantCost'],$qtrainD['gstTax'],$qtrainD['markupCost'],$qtrainD['markupType']);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
            $trainCostEMarkup = getMarkupCost($trainCostE,$markupCost,$markupType);
            $trainCostE = $trainCostE+$trainCostEMarkup;
            if($taxType == 2){
                $trainCostETax = getMarkupCost($trainCostEMarkup,$gstTax,$gstType);
            }else{
                $trainCostETax = getMarkupCost($trainCostE,$gstTax,$gstType);
            }
            $trainCostE = $trainCostE+$trainCostETax;
            }

            $totaltrainSameDayA = convert_to_base($qtrainD['currencyValue'], $baseCurrencyVal, trim($totaltrainSameDayA + $trainCostA));
            $totaltrainSameDayC = convert_to_base($qtrainD['currencyValue'], $baseCurrencyVal, trim($totaltrainSameDayC + $trainCostC));
            $totaltrainSameDayE = convert_to_base($qtrainD['currencyValue'], $baseCurrencyVal, trim($totaltrainSameDayE + $trainCostE));
            }
            echo getTwoDecimalNumberFormat($totaltrainSameDayA);
            $totaltrainA = ($totaltrainA + $totaltrainSameDayA);
            $totaltrainC = ($totaltrainC + $totaltrainSameDayC);
            $totaltrainE = ($totaltrainE + $totaltrainSameDayE);
            ?>
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            echo getTwoDecimalNumberFormat($totaltrainSameDayC);
            ?>
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            echo getTwoDecimalNumberFormat($totaltrainSameDayE);
            ?>
            </td>

            <td align="right" <?php echo $rowspan; ?> ><?php
            $totalEntSameDayA = 0;
            $totalEntSameDayC = 0;
            $totalEntSameDayE = 0;
            $d = GetPageRecord('*', 'quotationEntranceMaster', 'quotationId="'.$quotationId.'" and fromDate="'.$dayDate.'" order by id asc');
            while ($qEntranceD = mysqli_fetch_array($d)) {

                if($qEntranceD['transferType']!=2){
                    $markupCostEnt = $qEntranceD['markupCost'];
                    $markupTypeEnt = $qEntranceD['markupType'];
                    $gstTaxEnt = $qEntranceD['gstTax'];
                    }
            $gstTax = getGstValueById($qEntranceD['gstTax']);
            $gstType = 1;
            $taxType = $qEntranceD['taxType'];

            if($qEntranceD['transferType'] == 1){
                $entranceCostA = ($qEntranceD['ticketAdultCost']+$qEntranceD['adultCost']+$qEntranceD['repCost'])*$qEntranceD['adultPax'];            
            }else{
                $qEntranceTPTCostA = 0;
                if($DF_SGL>0 || $DF_DBL>0 || $DF_TWN>0 || $DF_TPL>0 || $DF_QUAD>0 || $DF_SIX>0 || $DF_EIGHT>0 || $DF_TEN>0 || $DF_ABED>0){
                    // $qEntranceTPTCostA = (($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles'])/$totalDF);
                    $qEntranceTPTCostA = getCostWithGSTID_Markup(($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles']),$qEntranceD['gstTax'],$qEntranceD['markupCost'],$qEntranceD['markupType']);
                    $qEntranceTPTCostA = $qEntranceTPTCostA/$totalDF;
                } 
                $entranceCostA = ($qEntranceD['ticketAdultCost']+$qEntranceTPTCostA+$qEntranceD['repCost'])*$qEntranceD['adultPax'];
            }
            $entranceCostA = getCostWithGSTID_Markup($entranceCostA,$gstTaxEnt,$markupCostEnt,$markupTypeEnt);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $entranceCostAMarkup = getMarkupCost($entranceCostA,$markupCost,$markupType);
                $entranceCostA = $entranceCostA+$entranceCostAMarkup;
                if($taxType == 2){
                    $entranceCostATax = getMarkupCost($entranceCostAMarkup,$gstTax,$gstType);
                }else{
                    $entranceCostATax = getMarkupCost($entranceCostA,$gstTax,$gstType);
                }
                $entranceCostA = $entranceCostA+$entranceCostATax; 
            }
            if($qEntranceD['transferType'] == 1){
                $entranceCostC = ($qEntranceD['ticketchildCost']+$qEntranceD['childCost']+$qEntranceD['repCost'])*$qEntranceD['childPax'];            
            }else{
                $qEntranceTPTCostC = 0;
                if($DF_CBED>0){
                    // $qEntranceTPTCostC = (($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles'])/$totalDF);
                    $qEntranceTPTCostC = getCostWithGSTID_Markup(($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles']),$qEntranceD['gstTax'],$qEntranceD['markupCost'],$qEntranceD['markupType']);
                    $qEntranceTPTCostC = $qEntranceTPTCostC/$totalDF;
                }
                $entranceCostC = ($qEntranceD['ticketchildCost']+$qEntranceTPTCostC+$qEntranceD['repCost'])*$qEntranceD['childPax'];
            }
            $entranceCostC = getCostWithGSTID_Markup($entranceCostC,$gstTaxEnt,$markupCostEnt,$markupTypeEnt);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
                $entranceCostCMarkup = getMarkupCost($entranceCostC,$markupCost,$markupType);
                $entranceCostC = $entranceCostC+$entranceCostCMarkup;
                if($taxType == 2){
                    $entranceCostCTax = getMarkupCost($entranceCostCMarkup,$gstTax,$gstType);
                }else{
                    $entranceCostCTax = getMarkupCost($entranceCostC,$gstTax,$gstType);
                }
                $entranceCostC = $entranceCostC+$entranceCostCTax;
            }

            if($qEntranceD['transferType'] == 1){
                $entranceCostE = ($qEntranceD['ticketinfantCost']+$qEntranceD['infantCost']+$qEntranceD['repCost'])*$qEntranceD['infantPax'];            
            }else{
                $qEntranceTPTCostE = 0;
                // if($DF_CBED>0){
                //     $qEntranceTPTCostE = (($qEntranceD['vehicleCost']*$qEntranceD['noOfVehicles'])/$totalDF);
                // }
                $entranceCostE = ($qEntranceD['ticketinfantCost']+$qEntranceTPTCostE+$qEntranceD['repCost'])*$qEntranceD['childPax'];
            }

            $entranceCostE = getCostWithGSTID_Markup($entranceCostE,$gstTaxEnt,$markupCostEnt,$markupTypeEnt);
            // if domestic service wise markup
            if($isSer_Mark == 1 && $isUni_Mark == 0){
            $entranceCostEMarkup = getMarkupCost($entranceCostE,$markupCost,$markupType);
            $entranceCostE = $entranceCostE+$entranceCostEMarkup;
            if($taxType == 2){
                $entranceCostETax = getMarkupCost($entranceCostEMarkup,$gstTax,$gstType);
            }else{
                $entranceCostETax = getMarkupCost($entranceCostE,$gstTax,$gstType);
            }
            $entranceCostE = $entranceCostE+$entranceCostETax;
            }

            $totalEntSameDayA = $totalEntSameDayA + convert_to_base($qEntranceD['currencyValue'], $baseCurrencyVal,trim($entranceCostA));
            $totalEntSameDayC = $totalEntSameDayC + convert_to_base($qEntranceD['currencyValue'], $baseCurrencyVal,trim($entranceCostC));
            $totalEntSameDayE = $totalEntSameDayE + convert_to_base($qEntranceD['currencyValue'], $baseCurrencyVal,trim($entranceCostE));
            }
            if($totalPax>0){
            echo getTwoDecimalNumberFormat($totalEntSameDayA);
            }    
            $totalentcostA = ($totalentcostA + trim($totalEntSameDayA));
            $totalentcostC = ($totalentcostC + trim($totalEntSameDayC));
            $totalentcostE = ($totalentcostE + trim($totalEntSameDayE));
            ?>  
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            // if($paxChild>0){
            echo getTwoDecimalNumberFormat($totalEntSameDayC);
            // }
            ?>  
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            // if($paxInfant>0){
            echo getTwoDecimalNumberFormat($totalEntSameDayE);
            // }
            ?>  
            </td>

            <!-- sightseeing cost -->

            <td align="right" <?php echo $rowspan; ?> ><?php
            $totalActSameDayA = 0;
            $totalActSameDayC = 0;
            $totalActSameDayE = 0;
            $e = GetPageRecord('*', 'quotationOtherActivitymaster', 'quotationId="'.$quotationId.'" and fromDate="'.$dayDate.'" order by id asc');
            while ($qActivityD = mysqli_fetch_array($e)){

                if($qActivityD['transferType']!=2){
                    $markupCostAct = $qActivityD['markupCost'];
                    $markupTypeAct = $qActivityD['markupType'];
                    $gstTaxAct = $qActivityD['gstTax'];
                    }
                $gstTax = getGstValueById($qActivityD['gstTax']);
                $gstType = 1;
                $taxType = $qActivityD['taxType'];
                $totalPaxAct = $qActivityD['adultPax']+$qActivityD['childPax'];
                 
                if($qActivityD['transferType'] == 1){
                    $activityCostA = ($qActivityD['ticketAdultCost']+$qActivityD['adultCost']+$qActivityD['repCost'])*$qActivityD['adultPax'];            
                    $activityCostC = ($qActivityD['ticketchildCost']+$qActivityD['childCost']+$qActivityD['repCost'])*$qActivityD['childPax'];            
                    $activityCostE = ($qActivityD['ticketinfantCost']+$qActivityD['infantCost']+$qActivityD['repCost'])*$qActivityD['infantPax'];            
                }else{  
                    $vehicleCostACtPur = $qActivityD['vehicleCost']*$qActivityD['noOfVehicles'];
                    $vehicleCostM = getMarkupCost($vehicleCostACtPur,$qActivityD['markupCost'],$qActivityD['markupType']);
                     $vehicleCostAct = $vehicleCostM+$vehicleCostACtPur;
                    $activityCostA = ($qActivityD['ticketAdultCost']+(($vehicleCostAct)/$totalPaxAct)+$qActivityD['repCost'])*$qActivityD['adultPax'];
                    $activityCostC = ($qActivityD['ticketchildCost']+(($vehicleCostAct)/$totalPaxAct)+$qActivityD['repCost'])*$qActivityD['childPax'];
                    $activityCostE = ($qActivityD['ticketinfantCost']+$qActivityTPTCostE+$qActivityD['repCost'])*$qActivityD['infantPax'];
                }
                $activityCostA = getCostWithGSTID_Markup($activityCostA,$gstTaxAct,$markupCostAct,$markupTypeAct);
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $activityCostAMarkup = getMarkupCost($activityCostA,$markupCost,$markupType);
                    $activityCostA = $activityCostA+$activityCostAMarkup;
                    if($taxType == 2){
                        $activityCostATax = getMarkupCost($activityCostAMarkup,$gstTax,$gstType);
                    }else{
                        $activityCostATax = getMarkupCost($activityCostA,$gstTax,$gstType);
                    }
                    $activityCostA = $activityCostA+$activityCostATax; 
                }
     
                $activityCostC = getCostWithGSTID_Markup($activityCostC,$gstTaxAct,$markupCostAct,$markupTypeAct);
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $activityCostCMarkup = getMarkupCost($activityCostC,$markupCost,$markupType);
                    $activityCostC = $activityCostC+$activityCostCMarkup;
                    if($taxType == 2){
                        $activityCostCTax = getMarkupCost($activityCostCMarkup,$gstTax,$gstType);
                    }else{
                        $activityCostCTax = getMarkupCost($activityCostC,$gstTax,$gstType);
                    }
                    $activityCostC = $activityCostC+$activityCostCTax;
                } 
                $activityCostE = getCostWithGSTID_Markup($activityCostE,$gstTaxAct,$markupCostAct,$markupTypeAct);
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $activityCostEMarkup = getMarkupCost($activityCostE,$markupCost,$markupType);
                    $activityCostE = $activityCostE+$activityCostEMarkup;
                    if($taxType == 2){
                        $activityCostETax = getMarkupCost($activityCostEMarkup,$gstTax,$gstType);
                    }else{
                        $activityCostETax = getMarkupCost($activityCostE,$gstTax,$gstType);
                    }
                    $activityCostE = $activityCostE+$activityCostETax;
                }

                $totalActSameDayA = $totalActSameDayA + convert_to_base($qActivityD['currencyValue'], $baseCurrencyVal,trim($activityCostA));
                $totalActSameDayC = $totalActSameDayC + convert_to_base($qActivityD['currencyValue'], $baseCurrencyVal,trim($activityCostC));
                $totalActSameDayE = $totalActSameDayE + convert_to_base($qActivityD['currencyValue'], $baseCurrencyVal,trim($activityCostE));
            } 
            echo getTwoDecimalNumberFormat($totalActSameDayA);
                
            $totalActcostA = ($totalActcostA + trim($totalActSameDayA));
            $totalActcostC = ($totalActcostC + trim($totalActSameDayC));
            $totalActcostE = ($totalActcostE + trim($totalActSameDayE));
            ?>  
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            // if($paxChild>0){
            echo getTwoDecimalNumberFormat($totalActSameDayC);
            // }
            ?>  
            </td>
            <td align="right" <?php echo $rowspan; ?> ><?php
            // if($paxInfant>0){
            echo getTwoDecimalNumberFormat($totalActSameDayE);
            // }
            ?>  
            </td>
            <!-- sightseeing block end -->

            <!-- additional block start -->
            <td align="right" ><?php
            $totalDayExtraA = 0;
            $totalDayExtraC = 0;
            $totalDayExtraE = 0;
            $totalDayExtraG = 0;
            $d21 = GetPageRecord('*', 'quotationExtraMaster', 'quotationId="' . $quotationId . '" and  fromDate="' . $dayDate . '" and isMarkupApply=0  order by id asc');
            while ($quotExtraData = mysqli_fetch_array($d21)) {
                $markupCost = $quotExtraData['markupCost'];
                $markupType = $quotExtraData['markupType'];
                $gstTax = getGstValueById($quotExtraData['gstTax']);
                $gstType = 1;
                $taxType = $quotExtraData['taxType'];

                if ($quotExtraData['costType']==2){
                    $totalDayExtraG = $totalDayExtraG + convert_to_base($quotExtraData['currencyValue'],$baseCurrencyVal, getCostWithGSTID_Markup($quotExtraData['groupCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']));
                }else {
                    $totalDayExtraA = $totalDayExtraA + convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, ( getCostWithGSTID_Markup($quotExtraData['adultCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType'])*$quotExtraData['adultPax']));
                    $totalDayExtraC = $totalDayExtraC + convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotExtraData['childCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType'])*$quotExtraData['childPax']));
                    $totalDayExtraE = $totalDayExtraE + convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotExtraData['infantCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType'])*$quotExtraData['infantPax']));
                }
               
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $totalDayExtraGMarkup = getMarkupCost($totalDayExtraG,$markupCost,$markupType);
                    $totalDayExtraG = $totalDayExtraG+$totalDayExtraGMarkup;
                    if($taxType == 2){
                        $totalDayExtraGTax = getMarkupCost($totalDayExtraGMarkup,$gstTax,$gstType);
                    }else{
                        $totalDayExtraGTax = getMarkupCost($totalDayExtraG,$gstTax,$gstType);
                    }
                    $totalDayExtraG = $totalDayExtraG+$totalDayExtraGTax; 
                }
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $totalDayExtraAMarkup = getMarkupCost($totalDayExtraA,$markupCost,$markupType);
                    $totalDayExtraA = $totalDayExtraA+$totalDayExtraAMarkup;
                    if($taxType == 2){
                        $totalDayExtraATax = getMarkupCost($totalDayExtraAMarkup,$gstTax,$gstType);
                    }else{
                        $totalDayExtraATax = getMarkupCost($totalDayExtraA,$gstTax,$gstType);
                    }
                    $totalDayExtraA = $totalDayExtraA+$totalDayExtraATax; 
                }
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $totalDayExtraCMarkup = getMarkupCost($totalDayExtraC,$markupCost,$markupType);
                    $totalDayExtraC = $totalDayExtraC+$totalDayExtraCMarkup;
                    if($taxType == 2){
                        $totalDayExtraCTax = getMarkupCost($totalDayExtraCMarkup,$gstTax,$gstType);
                    }else{
                        $totalDayExtraCTax = getMarkupCost($totalDayExtraC,$gstTax,$gstType);
                    }
                    $totalDayExtraC = $totalDayExtraC+$totalDayExtraCTax;
                }
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $totalDayExtraEMarkup = getMarkupCost($totalDayExtraE,$markupCost,$markupType);
                    $totalDayExtraE = $totalDayExtraE+$totalDayExtraEMarkup;
                    if($taxType == 2){
                        $totalDayExtraETax = getMarkupCost($totalDayExtraEMarkup,$gstTax,$gstType);
                    }else{
                        $totalDayExtraETax = getMarkupCost($totalDayExtraE,$gstTax,$gstType);
                    }
                    $totalDayExtraE = $totalDayExtraE+$totalDayExtraETax;
                } 
            }
            $totalExtraCostA = ($totalExtraCostA + $totalDayExtraA);
            $totalExtraCostC = ($totalExtraCostC + $totalDayExtraC);
            $totalExtraCostE = ($totalExtraCostE + $totalDayExtraE);
            $totalExtraCostG = ($totalExtraCostG + $totalDayExtraG);
            echo  getTwoDecimalNumberFormat($totalDayExtraA);
            ?>
            </td>
            <?php //if($paxChild>0){ ?>
            <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayExtraC); ?></td>
            <?php //}if ($paxInfant>0) { ?>
            <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayExtraE); ?></td> 
            <?php //}if ($totalPax>0) { ?>
            <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayExtraG); ?></td>
            <?php //} ?>
            <!-- additional block end -->

            <!-- restaurant block start -->
            <td align="right" ><?php
            $totalDayRestaurantA = 0;
            $totalDayRestaurantC = 0;
            $totalDayRestaurantE = 0;
            $d21 = GetPageRecord('*', 'quotationInboundmealplanmaster', 'quotationId="' . $quotationId . '" and  fromDate="' . $dayDate . '" order by id asc');
            while ($quotRestData = mysqli_fetch_array($d21)) {
                $markupCost = $quotRestData['markupCost'];
                $markupType = $quotRestData['markupType'];
                $gstTax = getGstValueById($quotRestData['gstTax']);
                $gstType = 1;
                $taxType = $quotRestData['taxType'];

                $totalDayRestaurantA = $totalDayRestaurantA + convert_to_base($quotRestData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotRestData['adultCost'],$quotRestData['gstTax'],$quotRestData['markupCost'],$quotRestData['markupType'])*$quotRestData['adultPax']));
                $totalDayRestaurantC = $totalDayRestaurantC + convert_to_base($quotRestData['currencyValue'], $baseCurrencyVal, (getCostWithGSTID_Markup($quotRestData['childCost'],$quotRestData['gstTax'],$quotRestData['markupCost'],$quotRestData['markupType'])*$quotRestData['childPax']));
                $totalDayRestaurantE = $totalDayRestaurantE + convert_to_base($quotRestData['currencyValue'], $baseCurrencyVal,(getCostWithGSTID_Markup($quotRestData['infantCost'],$quotRestData['gstTax'],$quotRestData['markupCost'],$quotRestData['markupType'])*$quotRestData['infantPax']));

                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $totalDayRestaurantAMarkup = getMarkupCost($totalDayRestaurantA,$markupCost,$markupType);
                    $totalDayRestaurantA = $totalDayRestaurantA+$totalDayRestaurantAMarkup;
                    if($taxType == 2){
                        $totalDayRestaurantATax = getMarkupCost($totalDayRestaurantAMarkup,$gstTax,$gstType);
                    }else{
                        $totalDayRestaurantATax = getMarkupCost($totalDayRestaurantA,$gstTax,$gstType);
                    }
                    $totalDayRestaurantA = $totalDayRestaurantA+$totalDayRestaurantATax; 
                }
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $totalDayRestaurantCMarkup = getMarkupCost($totalDayRestaurantC,$markupCost,$markupType);
                    $totalDayRestaurantC = $totalDayRestaurantC+$totalDayRestaurantCMarkup;
                    if($taxType == 2){
                        $totalDayRestaurantCTax = getMarkupCost($totalDayRestaurantCMarkup,$gstTax,$gstType);
                    }else{
                        $totalDayRestaurantCTax = getMarkupCost($totalDayRestaurantC,$gstTax,$gstType);
                    }
                    $totalDayRestaurantC = $totalDayRestaurantC+$totalDayRestaurantCTax;
                }
                // if domestic service wise markup
                if($isSer_Mark == 1 && $isUni_Mark == 0){
                    $totalDayRestaurantEMarkup = getMarkupCost($totalDayRestaurantE,$markupCost,$markupType);
                    $totalDayRestaurantE = $totalDayRestaurantE+$totalDayRestaurantEMarkup;
                    if($taxType == 2){
                        $totalDayRestaurantETax = getMarkupCost($totalDayRestaurantEMarkup,$gstTax,$gstType);
                    }else{
                        $totalDayRestaurantETax = getMarkupCost($totalDayRestaurantE,$gstTax,$gstType);
                    }
                    $totalDayRestaurantE = $totalDayRestaurantE+$totalDayRestaurantETax;
                } 
            }
            $totalRestaurantCostA = ($totalRestaurantCostA + $totalDayRestaurantA);
            $totalRestaurantCostC = ($totalRestaurantCostC + $totalDayRestaurantC);
            $totalRestaurantCostE = ($totalRestaurantCostE + $totalDayRestaurantE); 
            echo  getTwoDecimalNumberFormat($totalDayRestaurantA);
            ?>
            </td>
            <?php //if($paxChild>0){ ?>
            <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayRestaurantC); ?></td>
            <?php //}if ($paxInfant>0) { ?>
            <td align="right" <?php echo $rowspan; ?>><?php echo getTwoDecimalNumberFormat($totalDayRestaurantE); ?></td> 
            <?php //} ?>
            <!-- restaurant block end -->
 
            <?php
        } 

        ?>
        </tr>
        <?php
        // early checkin for guest
        if($resultpage['earlyCheckin'] == 1 && $day == 1 && $moduleType != 2){
            $earlyQuery = $earlyCheckInHotel = ""; 
            $earlyQuery = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '"  and isHotelSupplement != 1 and isRoomSupplement!= 1 and isGuestType= 1 and fromDate="' . $startdatevar . '" '.$multihotelQuery.' '.$hotelTypeQuery.'  order by id asc');
                if (mysqli_num_rows($earlyQuery)>0){
                    ?>
                    <tr>
                    <td width="118" align="left"></td>
                    <td width="94" align="left"></td>
                    <td align="left"><?php
                    echo "Guest&nbsp;Early&nbsp;Arrival:-&nbsp;";
                    // DATA FROM Early Arrival HOTEL SERVICE 
                    $qhotel3 = mysqli_fetch_array($earlyQuery);

                    $sglMarkup = $qhotel3['sglMarkup'];
                    $dblMarkup = $qhotel3['dblMarkup'];
                    $twinMarkup = $qhotel3['twinMarkup'];
                    $tplMarkup = $qhotel3['tplMarkup'];
                    $quadMarkup = $qhotel3['quadMarkup'];
                    $sixMarkup = $qhotel3['sixMarkup'];
                    $eightMarkup = $qhotel3['eightMarkup'];
                    $tenMarkup = $qhotel3['tenMarkup'];
                    $teenMarkup = $qhotel3['teenMarkup'];

                    $cwbMarkup = $qhotel3['cwbMarkup'];
                    $cnbMarkup = $qhotel3['cnbMarkup'];
                    $exMarkup = $qhotel3['exMarkup'];
                    $mealMarkup = $qhotel3['mealMarkup'];

                    $markupType = $qhotel3['markupType'];
                    $gstTax = getGstValueById($qhotel3['roomGST']);
                    $gstType = 1;
                    $taxType = $qhotel3['taxType'];


                    $singleNoofRoom3 = $qhotel3['singleNoofRoom'];
                    $single3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['singleoccupancy']*$singleNoofRoom3));
                    
                    $doubleNoofRoom3 = $qhotel3['doubleNoofRoom'];
                    $double3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['doubleoccupancy']*$doubleNoofRoom3));

                    $twinNoofRoom3 = $qhotel3['twinNoofRoom'];
                    $twin3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['twinoccupancy']*$twinNoofRoom3));

                    $tripleNoofRoom3 = $qhotel3['tripleNoofRoom'];
                    $triple3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['tripleoccupancy']*$tripleNoofRoom3));

                    $quadNoofRoom3 = $qhotel3['quadNoofRoom'];
                    $quad3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['quadRoom']*$quadNoofRoom3));
                    
                    $sixNoofBedRoom3 = $qhotel3['sixNoofBedRoom'];
                    $sixBed3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['sixBedRoom']*$sixNoofBedRoom3));

                    $eightNoofBedRoom3 = $qhotel3['eightNoofBedRoom'];
                    $eightBed3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['eightBedRoom']*$eightNoofBedRoom3));

                    $tenNoofBedRoom3 = $qhotel3['tenNoofBedRoom'];
                    $tenBed3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['tenBedRoom']*$tenNoofBedRoom3));

                    $teenNoofRoom3 = $qhotel3['teenNoofRoom'];
                    $teenBed3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['teenRoom']*$teenNoofRoom3));

                    $extraNoofBed3 = $qhotel3['extraNoofBed'];
                    $extraBedA3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['extraBed']*$extraNoofBed3));

                    $childwithNoofBed3 = $qhotel3['childwithNoofBed'];
                    $extraBedC3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['childwithbed']*$childwithNoofBed3));

                    $childwithoutNoofBed3 = $qhotel3['childwithoutNoofBed'];
                    $extraNBedC3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($qhotel3['childwithoutbed']*$childwithoutNoofBed3));

                    if ($qhotel3['isChildBreakfast'] == 1) {
                        $breakfastC3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal,  trim($qhotel3['childBreakfast']));
                    }
                    if ($qhotel3['isChildLunch'] == 1) {
                        $lunchC3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal,  trim($qhotel3['childLunch']));
                    }
                    if ($qhotel3['isChildDinner'] == 1) {
                        $dinnerC3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal,  trim($qhotel3['childDinner']));
                    }

                    if ($qhotel3['complimentaryBreakfast'] == 1) {
                        $breakfastA3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal,  trim($qhotel3['breakfast']));
                    }
                    if ($qhotel3['complimentaryLunch'] == 1) {
                        $lunchA3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal,  trim($qhotel3['lunch']));
                    }
                    if ($qhotel3['complimentaryDinner'] == 1) {
                        $dinnerA3 = convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal,  trim($qhotel3['dinner']));
                    }  

                    $d = '';
                    $d = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$qhotel3['id'].'" and fromDate="' . $dayDate . '" order by id asc');
                    while ($qHAdditionalData = mysqli_fetch_array($d)) {
                        if ($qHAdditionalData['costType']==2) {
                            $additionalCost3 = convert_to_base($qHAdditionalData['currencyValue'], $baseCurrencyVal,  $qHAdditionalData['additionalCost']);
                            $perPaxCost3 = ($additionalCost3 /($totalPax+$paxAdultLE+$paxAdultFE));
                        } else {
                            $perPaxCost3 = convert_to_base($qHAdditionalData['currencyValue'], $baseCurrencyVal,  $qHAdditionalData['additionalCost']);
                        }
                        $dayTotalHACost3 = ($dayTotalHACost3 + trim($perPaxCost3));
                    } 

                    // if domestic service wise markup
                    if($isSer_Mark == 1 && $isUni_Mark == 0){

                        $singleMarkup3 = getMarkupCost($single3,$sglMarkup,$markupType);
                        $single3 = $single3+$singleMarkup3;
                        if($taxType == 2){
                            $singleTax3 = getMarkupCost($singleMarkup3,$gstTax,$gstType);
                        }else{
                            $singleTax3 = getMarkupCost($single3,$gstTax,$gstType);
                        }
                        $single3 = $single3+$singleTax3;
                        
                        $doubleMarkup3 = getMarkupCost($double3,$dblMarkup,$markupType);
                        $double3 = $double3+$doubleMarkup3;
                        if($taxType == 2){
                            $doubleTax3 = getMarkupCost($doubleMarkup3,$gstTax,$gstType);
                        }else{
                            $doubleTax3 = getMarkupCost($double3,$gstTax,$gstType);
                        }
                        $double3 = $double3+$doubleTax3;
                        
                        $twinRoomMarkup3 = getMarkupCost($twin3,$twinMarkup3,$markupType);
                        $twin3 = $twin3+$twinRoomMarkup3;
                        if($taxType == 2){
                            $twinTax3 = getMarkupCost($twinRoomMarkup3,$gstTax,$gstType);
                        }else{
                            $twinTax3 = getMarkupCost($twin3,$gstTax,$gstType);
                        }
                        $twin3 = $twin3+$twinTax3;

                        $tripleMarkup3 = getMarkupCost($triple3,$tplMarkup,$markupType);
                        $triple3 = $triple3+$tripleMarkup3;
                        if($taxType == 2){
                            $tripleTax3 = getMarkupCost($tripleMarkup3,$gstTax,$gstType);
                        }else{
                            $tripleTax3 = getMarkupCost($triple3,$gstTax,$gstType);
                        }
                        $triple3 = $triple3+$tripleTax3;
                        
                        $quadBedMarkup3 = getMarkupCost($quad3,$quadMarkup3,$markupType);
                        $quad3 = $quad3+$quadBedMarkup3;
                        if($taxType == 2){
                            $quadTax3 = getMarkupCost($quadBedMarkup3,$gstTax,$gstType);
                        }else{
                            $quadTax3 = getMarkupCost($quad3,$gstTax,$gstType);
                        }
                        $quad3 = $quad3+$quadTax3;
                        
                        $sixBedMarkup3 = getMarkupCost($sixBed3,$sixMarkup3,$markupType);
                        $sixBed3 = $sixBed3+$sixBedMarkup3;
                        if($taxType == 2){
                            $sixBedTax3 = getMarkupCost($sixBedMarkup3,$gstTax,$gstType);
                        }else{
                            $sixBedTax3 = getMarkupCost($sixBed3,$gstTax,$gstType);
                        }
                        $sixBed3 = $sixBed3+$sixBedTax3;
                        
                        $eightBedMarkup3 = getMarkupCost($eightBed3,$eightMarkup3,$markupType);
                        $eightBed3 = $eightBed3+$eightBedMarkup3;
                        if($taxType == 2){
                            $eightBedTax3 = getMarkupCost($eightBedMarkup3,$gstTax,$gstType);
                        }else{
                            $eightBedTax3 = getMarkupCost($eightBed3,$gstTax,$gstType);
                        }
                        $eightBed3 = $eightBed3+$eightBedTax3;
                        
                        $tenBedMarkup3 = getMarkupCost($tenBed3,$tenMarkup3,$markupType);
                        $tenBed3 = $tenBed3+$tenBedMarkup3;
                        if($taxType == 2){
                            $tenBedTax3 = getMarkupCost($tenBedMarkup3,$gstTax,$gstType);
                        }else{
                            $tenBedTax3 = getMarkupCost($tenBed3,$gstTax,$gstType);
                        }
                        $tenBed3 = $tenBed3+$tenBedTax3;
                        
                        $teenBedMarkup3 = getMarkupCost($teenBed3,$teenMarkup3,$markupType);
                        $teenBed3 = $teenBed3+$teenBedMarkup3;
                        if($taxType == 2){
                            $teenBedTax3 = getMarkupCost($teenBedMarkup3,$gstTax,$gstType);
                        }else{
                            $teenBedTax3 = getMarkupCost($teenBed3,$gstTax,$gstType);
                        }
                        $teenBed3 = $teenBed3+$teenBedTax3;
                        
                        $extraBedAMarkup3 = getMarkupCost($extraBedA3,$exMarkup,$markupType);
                        $extraBedA3 = $extraBedA3+$extraBedAMarkup3;
                        if($taxType == 2){
                            $extraBedATax3 = getMarkupCost($extraBedAMarkup3,$gstTax,$gstType);
                        }else{
                            $extraBedATax3 = getMarkupCost($extraBedA3,$gstTax,$gstType);
                        }
                        $extraBedA3 = $extraBedA3+$extraBedATax3;

                        $extraBedCMarkup3 = getMarkupCost($extraBedC3,$cwbMarkup,$markupType);
                        $extraBedC3 = $extraBedC3+$extraBedCMarkup3;
                        if($taxType == 2){
                            $extraBedCTax3 = getMarkupCost($extraBedCMarkup3,$gstTax,$gstType);
                        }else{
                            $extraBedCTax3 = getMarkupCost($extraBedC3,$gstTax,$gstType);
                        }
                        $extraBedC3 = $extraBedC3+$extraBedCTax3;

                        $extraNBedCMarkup3 = getMarkupCost($extraNBedC3,$cnbMarkup,$markupType);
                        $extraNBedC3 = $extraNBedC3+$extraNBedCMarkup3;
                        if($taxType == 2){
                            $extraNBedCTax3 = getMarkupCost($extraNBedCMarkup3,$gstTax,$gstType);
                        }else{
                            $extraNBedCTax3 = getMarkupCost($extraNBedC3,$gstTax,$gstType);
                        }
                        $extraNBedC3 = $extraNBedC3+$extraNBedCTax3;
                  
                        if ($qhotel3['complimentaryBreakfast'] == 1) {
                            $breakfastAMarkup3 = getMarkupCost($breakfastA3,$mealMarkup,$markupType);
                            $breakfastA3 = $breakfastA3+$breakfastAMarkup3;
                            if($taxType == 2){
                                $breakfastATax3 = getMarkupCost($breakfastAMarkup3,$gstTax,$gstType);
                            }else{
                                $breakfastATax3 = getMarkupCost($breakfastA3,$gstTax,$gstType);
                            }
                            $breakfastA3 = $breakfastA3+$breakfastATax3;
                        } 

                        if ($qhotel3['complimentaryLunch'] == 1) {
                            $lunchAMarkup3 = getMarkupCost($lunchA3,$mealMarkup,$markupType);
                            $lunchA3 = $lunchA3+$lunchAMarkup3;
                            if($taxType == 2){
                                $lunchATax3 = getMarkupCost($lunchAMarkup3,$gstTax,$gstType);
                            }else{
                                $lunchATax3 = getMarkupCost($lunchA3,$gstTax,$gstType);
                            }
                            $lunchA3 = $lunchA3+$lunchATax3;
                        } 

                        if ($qhotel3['complimentaryDinner'] == 1) {
                            $dinnerA3Markup = getMarkupCost($dinnerA3,$mealMarkup,$markupType);
                            $dinnerA3 = $dinnerA3+$dinnerA3Markup;
                            if($taxType == 2){
                                $dinnerA3Tax = getMarkupCost($dinnerA3Markup,$gstTax,$gstType);
                            }else{
                                $dinnerA3Tax = getMarkupCost($dinnerA3,$gstTax,$gstType);
                            }
                            $dinnerA3 = $dinnerA3+$dinnerA3Tax;
                        } 

                        if ($qhotel3['isChildBreakfast'] == 1) {
                            $breakfastCMarkup3 = getMarkupCost($breakfastC3,$mealMarkup,$markupType);
                            $breakfastC3 = $breakfastC3+$breakfastCMarkup3;
                            if($taxType == 2){
                                $breakfastCTax3 = getMarkupCost($breakfastCMarkup3,$gstTax,$gstType);
                            }else{
                                $breakfastCTax3 = getMarkupCost($breakfastC3,$gstTax,$gstType);
                            }
                            $breakfastC3 = $breakfastC3+$breakfastCTax3;
                        } 

                        if ($qhotel3['isChildLunch'] == 1) {
                            $lunchCMarkup3 = getMarkupCost($lunchC3,$mealMarkup,$markupType);
                            $lunchC3 = $lunchC3+$lunchCMarkup3;
                            if($taxType == 2){
                                $lunchCTax3 = getMarkupCost($lunchCMarkup3,$gstTax,$gstType);
                            }else{
                                $lunchCTax3 = getMarkupCost($lunchC3,$gstTax,$gstType);
                            }
                            $lunchC3 = $lunchC3+$lunchCTax3;
                        } 

                        if ($qhotel3['isChildDinner'] == 1) {
                            $dinnerCMarkup3 = getMarkupCost($dinnerC3,$mealMarkup,$markupType);
                            $dinnerC3 = $dinnerC3+$dinnerCMarkup3;
                            if($taxType == 2){
                                $dinnerCTax3 = getMarkupCost($dinnerCMarkup3,$gstTax,$gstType);
                            }else{
                                $dinnerCTax3 = getMarkupCost($dinnerC3,$gstTax,$gstType);
                            }
                            $dinnerC3 = $dinnerC3+$dinnerCTax3;
                        }
              
                        $HAMarkup3 = getMarkupCost($dayTotalHACost3,$mealMarkup,$markupType);
                        $dayTotalHACost3 = $dayTotalHACost3+$HAMarkup3;
                        if($taxType == 2){
                            $HATax3 = getMarkupCost($HAMarkup3,$gstTax,$gstType);
                        }else{
                            $HATax3 = getMarkupCost($dayTotalHACost3,$gstTax,$gstType);
                        }
                        $dayTotalHACost3 = $dayTotalHACost3+$HATax3;

                    }
                    // end domestice markup and gst calculatino

                   
                    $totalsingle = $totalsingle + $single3;
                    $totaldouble = $totaldouble + $double3;
                    $totaltwin = $totaltwin + $twin3;
                    $totaltriple = $totaltriple + $triple3;
                    $totalquad = $totalquad + $quad3;
                    $totalsixBed = $totalsixBed + $sixBed3;
                    $totaleightBed = $totaleightBed + $eightBed3;
                    $totaltenBed = $totaltenBed + $tenBed3;
                    $totalteenBed = $totalteenBed + $teenBed3;

                    $totalextraBedA = $totalextraBedA + $extraBedA3;
                    $totalextraBedC = $totalextraBedC + $extraBedC3;
                    $totalextraNBedC = $totalextraNBedC + $extraNBedC3;
                    $totalBreakfastA = $totalBreakfastA + $breakfastA3;
                    $totalLunchA = $totalLunchA + $lunchA3;
                    $totalDinnerA = $totalDinnerA + $dinnerA3;
                    $totalBreakfastC = $totalBreakfastC + $breakfastC3;
                    $totalLunchC = $totalLunchC + $lunchC3;
                    $totalDinnerC = $totalDinnerC + $dinnerC3;
                    $totalHACost = $totalHACost + $dayTotalHACost3;

                    
                    $bb3 = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotel3['supplierId'] . '"');
                    $hotelData3 = mysqli_fetch_array($bb3);
                    echo $earlyCheckInHotel =  str_replace(" ", "&nbsp;", stripslashes($hotelData3['hotelName']));
                    // end new code
                ?>
                </td>
                <td align="right"><?php
                if($sglRoom>0){
                    if($single3>0){
                        echo getTwoDecimalNumberFormat($single3).'/'.$singleNoofRoom3; // GUEST RATE
                    }
                }
                ?></td>
                <td align="right"><?php
                if($dblRoomm>0){
                    if($double3>0){
                        echo getTwoDecimalNumberFormat($double3).'/'.$doubleNoofRoom3; // GUEST RATE
                    }
                }
                ?></td>
                <?php if($twinRoom>0){ ?>
                <td align="right"><?php
                    if($twin3>0){
                        echo getTwoDecimalNumberFormat($twin3).'/'.$twinNoofRoom3; 
                    }
                // GUEST RATE
                ?></td>
                <?php } if($tripleRoom>0){ ?>
                <td align="right"><?php
                    if($triple3>0){
                        echo getTwoDecimalNumberFormat($triple3).'/'.$tripleNoofRoom3; 
                    }
                // GUEST RATE
                ?></td>
                <?php } if($quadBedRoom>0){ ?>
                    <td align="right"><?php 
                    if($quad3>0){
                    echo getTwoDecimalNumberFormat($quad3).'/'.$quadNoofRoom3; 
                    }
                // GUEST RATE quad
                ?></td>
                <?php } if($sixBedRoom>0){ ?>
                    <td align="right"><?php
                    if($sixBed3>0){
                    echo getTwoDecimalNumberFormat($sixBed3).'/'.$sixNoofBedRoom3; 
                    }
                // GUEST RATE six   
                ?></td>
                <?php } if($eightBedRoom>0){ ?>
                <td align="right"><?php 
                    if($eightBed3>0){
                        echo getTwoDecimalNumberFormat($eightBed3).'/'.$eightNoofBedRoom3; 
                    }
                // GUEST RATE eight
                ?></td>
                <?php } if($tenBedRoom>0){ ?>
                    <td align="right"><?php 
                    if($tenBed3>0){
                    echo getTwoDecimalNumberFormat($tenBed3).'/'.$tenNoofBedRoom3; 
                    }
                // GUEST RATE ten
                ?></td>
                <?php } if($teenBedRoom>0){ ?>
                    <td align="right"><?php 
                    if($teenBed3>0){
                    echo getTwoDecimalNumberFormat($teenBed3).'/'.$teenNoofRoom3; 
                    }
                // GUEST RATE teen
                ?></td>
                <?php } if($EBedAdult>0){ ?>
                <td align="right"><?php
                    if($extraBedA3>0){
                        echo getTwoDecimalNumberFormat($extraBedA3).'/'.$extraNoofBed3; 
                    }
                // GUEST RATE
                ?></td>
                <?php } if($EBedChild>0){ ?>
                <td align="right"><?php
                    if($extraBedC3>0){
                        echo getTwoDecimalNumberFormat($extraBedC3).'/'.$childwithNoofBed3; 
                    }
                // GUEST RATE
                ?></td>
                <?php } if($NBedChild>0){ ?>
                <td align="right"><?php
                    if($extraNBedC3>0){
                        echo getTwoDecimalNumberFormat($extraNBedC3).'/'.$childwithoutNoofBed3; 
                    }
                    // GUEST RATE
                ?></td>
                <?php } ?> 
                <td align="right"><?php 
                echo getTwoDecimalNumberFormat($breakfastA3); // GUEST RATE
                ?></td>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($lunchA3); // GUEST RATE
                ?></td>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($dinnerA3); // GUEST RATE
                ?></td>
                <td align="right"><?php 
                echo getTwoDecimalNumberFormat($breakfastC3); // GUEST RATE
                ?></td>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($lunchC3); // GUEST RATE
                ?></td>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($dinnerC3); // GUEST RATE
                ?></td>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($dayTotalHACost3); // GUEST RATE
                ?></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>
                <td align="right" ></td>  
                </tr>
                <?php
            } 

        }  
        $day++;
    }
    ?>
    <tr> 
        <td colspan="3" align="right" bgcolor="#deb887"><strong>Total</strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalsingle);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totaldouble);
        ?></strong></td>
        <?php if($twinRoom>0){ ?>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totaltwin); 
        // GUEST RATE
        ?></strong></td>
        <?php } if($tripleRoom>0){ ?>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totaltriple); 
        // GUEST RATE
        ?></strong></td>
        <?php } if($quadBedRoom>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php 
        echo getTwoDecimalNumberFormat($totalquad); 
        // GUEST RATE quad
        ?></strong></td>
        <?php } if($sixBedRoom>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalsixBed); 
        // GUEST RATE six   
        ?></strong></td>
        <?php } if($eightBedRoom>0){ ?>
        <td align="right" bgcolor="#deb887"><strong><?php 
        echo getTwoDecimalNumberFormat($totaleightBed); 
        // GUEST RATE eight
        ?></strong></td>
        <?php } if($tenBedRoom>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php 
        echo getTwoDecimalNumberFormat($totaltenBed); 
        // GUEST RATE ten
        ?></strong></td>
        <?php } if($teenBedRoom>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php 
        echo getTwoDecimalNumberFormat($totalteenBed); 
        // GUEST RATE teen
        ?></strong></td>
        <?php } if($EBedAdult>0){ ?>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalextraBedA); 
        // GUEST RATE
        ?></strong></td>
        <?php } if($EBedChild>0){ ?>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalextraBedC); 
        // GUEST RATE
        ?></strong></td>
        <?php } if($NBedChild>0){ ?>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalextraNBedC); 
        // GUEST RATE
        ?></strong></td>
        <?php } ?> 
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalBreakfastA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalLunchA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalDinnerA); 
        ?></strong></td>

        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalBreakfastC);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalLunchC);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalDinnerC); 
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalHACost);
        $totalmealA = $totalBreakfastA + $totalLunchA + $totalDinnerA + $totalHACost;
        $totalmealC = $totalBreakfastC + $totalLunchC + $totalDinnerC + $totalHACost;
        ?></strong></td>

        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalTransportCost);
        ?></strong></td>

        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalGuideCost);
        ?></strong></td>   

        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalFerryCostA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalFerryCostC);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalFerryCostE);
        ?></strong></td>
 
        <?php
        if ($resultpageQuotation['flightCostType'] == 0) {
        ?>
        <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat($totalflightA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat($totalflightC);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat($totalflightE);
        ?></strong></td>
        <?php
        }
        ?>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totaltrainA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totaltrainC);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totaltrainE);
        ?></strong></td>

        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalentcostA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalentcostC);
        ?></strong></td> 
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalentcostE);
        ?></strong></td> 
        <!-- Sightseeing cols below -->
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalActcostA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalActcostC);
        ?></strong></td> 
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalActcostE);
        ?></strong></td> 
 
        <!-- Additional cols below -->
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalExtraCostA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalExtraCostC);
        ?></strong></td> 
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalExtraCostE);
        ?></strong></td> 
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalExtraCostG);
        ?></strong></td> 

        <!-- Restaurant cols below -->
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalRestaurantCostA);
        ?></strong></td>
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalRestaurantCostC);
        ?></strong></td> 
        <td align="right" bgcolor="#deb887"><strong><?php
        echo getTwoDecimalNumberFormat($totalRestaurantCostE);
        ?></strong></td>  
    </tr>
    <?php 
    if ($isTotalLE == 1) { ?>
    <tr>

        <td colspan="3" align="right" bgcolor="#dec7c7"><strong>Local Escort Total</strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalsingleLE); // LOCAL ESCORT RATE
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totaldoubleLE); // LOCAL ESCORT RATE
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalBreakfastALE);
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalLunchALE);
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalDinnerALE); 
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalHACostALE);
            $totalmealALE = $totalBreakfastALE + $totalLunchALE + $totalDinnerALE + $totalHACostALE;
        ?></strong></td>

        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <?php
        if ($resultpageQuotation['flightCostType'] == 0) {
        ?>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalflightALE);
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <?php
        }
        ?>
        <td align="right" bgcolor="#dec7c7"><strong><?php
        echo getTwoDecimalNumberFormat($totaltrainALE);
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
    </tr>
    <?php
    }
    ?>
    <?php 
    if ($isTotalFE == 1) { ?>
    <tr>
        <td colspan="3" align="right" bgcolor="#d4d5f0"><strong>Foreign Escort Total</strong></td>
        <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat($totalsingleFE); // LOCAL ESCORT RATE
        ?></strong></td>
        <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat($totaldoubleFE); // FOREIGN ESCORT RATE
        ?></strong></td>

        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalBreakfastAFE);
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalLunchAFE);
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalDinnerAFE); 
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong></strong></td>
        <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat($totalHACostAFE);
            $totalmealAFE = $totalBreakfastAFE + $totalLunchAFE + $totalDinnerAFE + $totalHACostAFE;
        ?></strong></td>
        <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
        <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
        <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
        <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
        <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
        <?php
        if ($resultpageQuotation['flightCostType'] == 0) {
        ?>
        <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat($totalflightAFE);
        ?></strong></td>
        <td align="right" bgcolor="#d4d5f0"></td>
        <td align="right" bgcolor="#d4d5f0"></td>
        <?php
        }
        ?>
        <td align="right" bgcolor="#d4d5f0"><strong><?php
        echo getTwoDecimalNumberFormat($totaltrainAFE);
        ?></strong></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
        <td align="right" bgcolor="#dec7c7"></td>
    </tr>
    <?php
    }
    ?> 
</table>
<!-- START PER PAX BLOCK --> 
<br/>
<table width="100%" cellpadding="0" cellspacing="0" >
    <tr>
        <td valign="top" width="40%">
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
        <tr height="18">
            <td height="18" colspan="5" align="center" bgcolor="#F5F5F5" style="font-size:16px;font-weight: 600;">Land Arrangement (Per Pax Cost )</td>
        </tr>
        <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PARTICULARS</strong></td>
            <?php
            $totalPaxFE = $totalPaxLE = $totalpaxA= $totalpaxC = 0;
            $transGuideCostA=$transGuideCostC=$transGuideCostALE=$transGuideCostAFE=0;

            $escortCols = 0;
            if ($paxAdultLE >0) {
                $escortCols = $escortCols + 1;
            }
            if ($paxAdultFE >0 ) {
                $escortCols = $escortCols + 1;
            }
            ?>
            <td align="center" colspan="3" bgcolor="#F5F5F5"><strong><?php if($travelType == 2){ echo "Total Pax (".$paxrange.")"; }else{ echo " Dividing Factor: (".$paxrange.")"; } ?></strong></td>
            <?php  if ($paxAdultLE >0 || $paxAdultFE >0  ) { ?>
            <td align="center" colspan="<?php echo ($escortCols);?>" bgcolor="#F5F5F5"><strong>ESCORTS</strong></td>
            <?php } ?>
        </tr>
        <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong></strong></td>
            <td align="center" bgcolor="#deb887" ><strong>ADULT&nbsp;COST</strong></td>
            <td align="center" bgcolor="#deb887" ><strong>CHILD&nbsp;COST</strong></td>
            <td align="center" bgcolor="#deb887" ><strong>Infant&nbsp;COST</strong></td>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="center" bgcolor="#dec7c7"><strong>LOCAL</strong></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="center" bgcolor="#d4d5f0"><strong>FORIEGN</strong></td>
            <?php } ?>
        </tr>
          <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>RESTAURANTS+B+L+D</strong></td>
            <?php  
            $totalmealA = ($totalmealA + $totalRestaurantCostA/$paxAdult);
            $totalmealC = ($totalmealC + $totalRestaurantCostC/$paxChild);
            // $totalmealE = 0;
            $totalmealE = ($totalRestaurantCostE/$paxInfant);
            $totalmealACostLE = getMarkupCost(($totalmealALE + $totalRestaurantCost),$restaurantCostLE,$restaurantCalTypeLE);
            $totalmealACostFE = getMarkupCost(($totalmealAFE + $totalRestaurantCost),$restaurantCostFE,$restaurantCalTypeFE);
     
            ?>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalmealA); $totalpaxA = $totalpaxA + $totalmealA;?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalmealC); $totalpaxC = $totalpaxC + $totalmealC;?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalmealE); $totalpaxE = $totalpaxE + $totalmealE;?></td>
            <?php
            $totalmealALE = trim($totalmealACostLE);
            $totalmealAFE = trim($totalmealACostFE);
            ?>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalmealALE); $totalPaxLE = $totalPaxLE + $totalmealALE;?></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalmealAFE); $totalPaxFE = $totalPaxFE + $totalmealAFE;?></td>
            <?php } ?>
          </tr>

          <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>TRAIN</strong></td>
            <td align="right" bgcolor="#deb887" ><?php
                echo getTwoDecimalNumberFormat($totaltrainA); 
                $totalpaxA = $totalpaxA + $totaltrainA;

                $totaltrainALE = getMarkupCost($totaltrainALE,$trainCostLE,$trainCalTypeLE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                $totaltrainAFE = getMarkupCost($totaltrainAFE,$trainCostFE,$trainCalTypeFE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                
                ?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totaltrainC); $totalpaxC = $totalpaxC + $totaltrainC;?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totaltrainE); $totalpaxE = $totalpaxE + $totaltrainE;?></td>
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
                
                $totalflightALE = getMarkupCost($totalflightALE,$flightCostLE,$flightCalTypeLE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                $totalflightAFE = getMarkupCost($totalflightAFE,$flightCostFE,$flightCalTypeFE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                ?>
                
            </td>
            <td align="right"  bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalflightC); $totalpaxC = $totalpaxC + $totalflightC;?></td>
            <td align="right"  bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalflightE); $totalpaxE = $totalpaxE + $totalflightE;?></td>
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
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>FERRY</strong></td>
            <td align="right" bgcolor="#deb887" ><?php   
            echo getTwoDecimalNumberFormat($totalFerryCostA);
            $totalpaxA = $totalpaxA + $totalFerryCostA;

            $totalFerryCostLE = getMarkupCost($totalFerryCostA,$ferryCostLE,$ferryCalTypeLE);
            // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
            $totalFerryCostFE = getMarkupCost($totalFerryCostA,$ferryCostFE,$ferryCalTypeFE);
            // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
            ?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalFerryCostC); $totalpaxC = $totalpaxC + $totalFerryCostC;?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalFerryCostE); $totalpaxE = $totalpaxE + $totalFerryCostE;?></td>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat($totalFerryCostLE); $totalPaxLE = $totalPaxLE + $totalFerryCostLE;?></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><?php echo getTwoDecimalNumberFormat($totalFerryCostFE); $totalPaxFE = $totalPaxFE + $totalFerryCostFE;?></td>
            <?php } ?>
          </tr>
          
         
          <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>MONUMENTS</strong></td>
            <td align="right" bgcolor="#deb887" ><?php 
                $totalentcostA = $totalentcostA/$paxAdult;
                $totalentcostC = $totalentcostC/$paxChild;
                $totalentcostE = $totalentcostE/$paxInfant;
                echo getTwoDecimalNumberFormat($totalentcostA); 
                $totalpaxA = $totalpaxA + $totalentcostA;

                $totalentcostALE = getMarkupCost($totalentcostA,$entranceCostLE,$entranceCalTypeLE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                $totalentcostAFE = getMarkupCost($totalentcostA,$entranceCostFE,$entranceCalTypeFE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                ?>
            </td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalentcostC); $totalpaxC = $totalpaxC + $totalentcostC;?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalentcostE); $totalpaxE = $totalpaxE + $totalentcostE;?></td>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalentcostALE);$totalPaxLE = $totalPaxLE + $totalentcostALE;?></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalentcostAFE);$totalPaxFE = $totalPaxFE + $totalentcostAFE;?></td>
            <?php } ?>
          </tr>
           
                <!-- Sightseeing block Below -->
          <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>SIGHTSEEING</strong></td>
            <td align="right" bgcolor="#deb887" ><?php 
                $totalActcostA = $totalActcostA/$paxAdult;
                $totalActcostC = $totalActcostC/$paxChild;
                $totalActcostE = $totalActcostE/$paxInfant;
                echo getTwoDecimalNumberFormat($totalActcostA); 
                $totalpaxA = $totalpaxA + $totalActcostA;

                $totalActcostALE = getMarkupCost($totalActcostA,$activityCostLE,$activityCalTypeLE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                $totalActcostAFE = getMarkupCost($totalActcostA,$activityCostFE,$activityCalTypeFE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                ?>
            </td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalActcostC); $totalpaxC = $totalpaxC + $totalActcostC;?></td>
            <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalActcostE); $totalpaxE = $totalpaxE + $totalActcostE;?></td>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalActcostALE);$totalPaxLE = $totalPaxLE + $totalActcostALE;?></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalActcostAFE);$totalPaxFE = $totalPaxFE + $totalActcostAFE;?></td>
            <?php } ?>
          </tr>
          
            <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ADDITIONALS</strong></td>
            <td align="right" bgcolor="#deb887" ><?php
                $totalAdditionalCostGPP = $totalExtraCostG/$totalPax;

                $totalAdditionalCostA = ($totalExtraCostA/$paxAdult+$totalAdditionalCostGPP);
                $totalAdditionalCostC = ($totalExtraCostC/$paxChild+$totalAdditionalCostGPP);
                $totalAdditionalCostE = ($totalExtraCostE/$paxInfant+$totalAdditionalCostGPP);
                
                echo getTwoDecimalNumberFormat($totalAdditionalCostA);
                $totalpaxA = $totalpaxA + $totalAdditionalCostA;
                
                $totalAdditionalCostLE = getMarkupCost($totalAdditionalCostA,$otherCostLE,$otherCalTypeLE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                $totalAdditionalCostFE = getMarkupCost($totalAdditionalCostA,$otherCostFE,$otherCalTypeFE);
                // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
                ?>
            </td> 
            <td align="right" bgcolor="#deb887" ><?php if($paxChild>0){  echo getTwoDecimalNumberFormat($totalAdditionalCostC); $totalpaxC = $totalpaxC + $totalAdditionalCostC; } ?></td>

            <td align="right" bgcolor="#deb887" ><?php if($paxInfant>0){ echo getTwoDecimalNumberFormat($totalAdditionalCostE); $totalpaxE = $totalpaxE + $totalAdditionalCostE; } ?></td>

            <?php if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalAdditionalCostLE);$totalPaxLE = $totalPaxLE + $totalAdditionalCostLE;?></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalAdditionalCostFE);$totalPaxFE = $totalPaxFE + $totalAdditionalCostFE;?></td>
            <?php } ?>
          </tr>
            <tr height="18">

            <td height="18" colspan="2" align="right" bgcolor="#deb887" style=" font-weight: 800; ">
                <strong>TOTAL LAND ARRANGEMENT COST (&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>&nbsp;)</strong>
            </td>
            <td align="right" bgcolor="#deb887"  style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($totalpaxA);?></td>
            <td align="right" bgcolor="#deb887"  style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($totalpaxC);?></td>
            <td align="right" bgcolor="#deb887"  style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($totalpaxE);?></td>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($totalPaxLE); $totalFOCCost = $totalPaxLE;?></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($totalPaxFE); $totalLOCCost = $totalPaxFE;?></td>
            <?php } ?>
            </tr>

            <tr height="18">
                <td height="18" colspan="<?php echo ($escortCols+5);?>" align="center" bgcolor="#F5F5F5" style="font-size:16px;font-weight: 600;">Transport/Escort Cost (Per Pax Cost )</td>
            </tr>

          <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>TRANSPORT</strong></td>
            <td align="right" bgcolor="#deb887" ><?php  
            // $totalTransportCostA = ($totalTransportCost/$dividingFactor); 
            $totalTransportCostA = 0;
            if(($DF_SGL>0 || $DF_DBL>0 || $DF_TWN>0 || $DF_TPL>0 || $DF_QUAD>0 || $DF_SIX>0 || $DF_EIGHT>0 || $DF_TEN>0 || $DF_ABED>0 || $DF_INF>0) || $queryType==14){
                $totalTransportCostA = ($totalTransportCost/$totalDF);
            } 

            echo getTwoDecimalNumberFormat($totalTransportCostA);
            $transGuideCostA = ($transGuideCostA+$totalTransportCostA);
          
            $totalTransportCostALE = getMarkupCost($totalTransportCostA,$transferCostLE,$transferCalTypeLE);
            // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
            $totalTransportCostAFE = getMarkupCost($totalTransportCostA,$transferCostFE,$transferCalTypeFE);
            // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
            ?></td>

            <td align="right" bgcolor="#deb887" ><?php    
            $totalTransportCostC = 0;
            if($DF_CBED>0){
                $totalTransportCostC = ($totalTransportCost/$totalDF);
            } 
            echo getTwoDecimalNumberFormat($totalTransportCostC); 

            $transGuideCostC = ($transGuideCostC+$totalTransportCostC); 
            
            ?>
            
        </td>   

            <td align="right" bgcolor="#deb887" ><?php    
            $totalTransportCostE = 0;
            if($DF_INF>0){
                $totalTransportCostE = ($totalTransportCost/$totalDF);
            } 
            echo getTwoDecimalNumberFormat($totalTransportCostE);
           
            $transGuideCostE = ($transGuideCostE+$totalTransportCostE); ?></td>
            <?php if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalTransportCostALE); 
            $transGuideCostALE = ($transGuideCostALE+$totalTransportCostALE);?></td>
            <?php } if($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalTransportCostAFE); 
            $transGuideCostAFE = ($transGuideCostAFE+$totalTransportCostAFE);?></td>
            <?php } ?>
          </tr>

          <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>GUIDE</strong></td>
            <td align="right" bgcolor="#deb887" ><?php  
            // $totalGuideCostA = ($totalGuideCost/$dividingFactor); 
            $totalGuideCostA = 0;
            if(($DF_SGL>0 || $DF_DBL>0 || $DF_TWN>0 || $DF_TPL>0 || $DF_QUAD>0 || $DF_SIX>0 || $DF_EIGHT>0 || $DF_TEN>0 || $DF_ABED>0 || $DF_INF>0) || $queryType==14){
                $totalGuideCostA = ($totalGuideCost/$totalDF);
            } 
            echo getTwoDecimalNumberFormat($totalGuideCostA);
            $transGuideCostA = ($transGuideCostA+$totalGuideCostA);

            $totalGuideCostALE = getMarkupCost($totalGuideCostA,$guideCostLE,$guideCalTypeLE);
            // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
            $totalGuideCostAFE = getMarkupCost($totalGuideCostA,$guideCostFE,$guideCalTypeFE);
            // client escort pay 50% then ($tCostPP*50/100)*$paxAdultLE;
            ?></td>
            <td align="right" bgcolor="#deb887" ><?php
            $totalGuideCostC = 0;
            if($DF_CBED>0){
                $totalGuideCostC = ($totalGuideCost/$totalDF);
            } 

            if($DF_ABED>0){
                $transGuideCostAEBed = $transGuideCostA;
            }

            echo getTwoDecimalNumberFormat($totalGuideCostC);
            $transGuideCostC = $transGuideCostC+$totalGuideCostC;
            
            ?>
            </td>  

            <td align="right" bgcolor="#deb887" ><?php
            $totalGuideCostE = 0;
            if($DF_INF>0){
                $totalGuideCostE = ($totalGuideCost/$totalDF);
            } 
            echo getTwoDecimalNumberFormat($totalGuideCostE);
          
            $transGuideCostE = $transGuideCostE+$totalGuideCostE;?></td>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat($totalGuideCostALE);
            $transGuideCostALE = ($transGuideCostALE+$totalGuideCostALE); ?></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat($totalGuideCostAFE); 
            $transGuideCostAFE = ($transGuideCostAFE+$totalGuideCostAFE);  ?></td>
            <?php } ?>
          </tr>

          <tr height="18">
            <td height="18" colspan="2" align="right" bgcolor="#deb887">
                <strong style=" font-weight: 800; ">TOTAL TRANSPORT/ESCORT COST (&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>&nbsp;)</strong>
            </td>
            <td align="right" bgcolor="#deb887" ><strong style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($transGuideCostA);?></strong></td>
            <td align="right" bgcolor="#deb887" ><strong style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($transGuideCostC);?></strong></td>
            <td align="right" bgcolor="#deb887" ><strong style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($transGuideCostE); ?></strong></td>
            <?php  if ($paxAdultLE >0) { ?>
            <td align="right" bgcolor="#dec7c7"><strong style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($transGuideCostALE); $totalFOCCost = $totalPaxLE;?></strong></td>
            <?php } if ($paxAdultFE >0) { ?>
            <td align="right" bgcolor="#d4d5f0"><strong style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat($transGuideCostAFE); $totalLOCCost = $totalPaxFE;?></strong></td>
            <?php } ?>
        </tr>

        </table>

        </td>
         <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td valign="top">
        <?php 
        $grandSingle=$grandDouble=$grandTwin=$grandTriple=$grandQuadBed=$grandSixBed=$grandEightBed=$grandTenBed=$grandTeenBed=$grandHA=$grandAWB=$grandChildWB=$grandChildNB=$grandTotalPaxA=$grandTotalPaxC=0; 

        $grandSingleLE = $grandDoubleLE = $grandSingleFE = $grandDoubleFE = $grandTotalPaxLE = $grandTotalPaxFE = 0;
        $grandTotalTGCost = $grandTotalTGCostALE = $grandTotalTGCostAFE=0;

        // GETTING ADDTIONALS SERVICE TOTAL COST WHICH IS NOT MARKUP APPLY
        $totalExtraNoMarkupG =  0;
        $d212 = GetPageRecord('*', 'quotationExtraMaster', 'quotationId="' . $quotationId . '" and isMarkupApply=1 order by id asc');
        while ($extraCostNoMarkupD = mysqli_fetch_array($d212)) {

            // $ExtraA = getCostWithGSTID_Markup($quotExtraData['adultCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);
            // $ExtraC = getCostWithGSTID_Markup($quotExtraData['childCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);
            // $ExtraE = getCostWithGSTID_Markup($quotExtraData['infantCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);
            // $extragroup = getCostWithGSTID_Markup($quotExtraData['groupCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']);

            if ($extraCostNoMarkupD['costType']==2){
                $totalExtraNoMarkupG  += convert_to_base($extraCostNoMarkupD['currencyValue'],$baseCurrencyVal, $extraCostNoMarkupD['groupCost']);
            }
            if ($extraCostNoMarkupD['costType']==1){
                $totalExtraNoMarkupG  += convert_to_base($extraCostNoMarkupD['currencyValue'],$baseCurrencyVal, ($extraCostNoMarkupD['adultCost']*$extraCostNoMarkupD['adultPax']));
                $totalExtraNoMarkupG  += convert_to_base($extraCostNoMarkupD['currencyValue'],$baseCurrencyVal, $extraCostNoMarkupD['childCost']*$extraCostNoMarkupD['childPax']);
                $totalExtraNoMarkupG  += convert_to_base($extraCostNoMarkupD['currencyValue'],$baseCurrencyVal, $extraCostNoMarkupD['infantCost']*$extraCostNoMarkupD['infantPax']);
            }
        } 
        // echo $totalExtraNoMarkupG;
        ?>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
            <tr height="18">
                <td height="18" colspan="5" align="center" bgcolor="#F5F5F5" style="font-size:16px;font-weight: 600;">Total Tour Cost</td>
            </tr>
            <tr>
            <td align="center" bgcolor="#F5F5F5"><strong>Itinerary&nbsp;Services</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Unit&nbsp;Cost</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Volume&nbsp;Type</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Qty&nbsp;Total</strong></td>
            <td align="center" bgcolor="#F5F5F5"><strong>Total&nbsp;Cost</strong></td>
            </tr>
            <?php if($singleRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Single&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandSingle=$totalsingle; echo getTwoDecimalNumberFormat($grandSingle);?></td>
            </tr>
            <?php }if($doubleRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Double&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandDouble =$totaldouble;  echo getTwoDecimalNumberFormat($grandDouble);?></td>
            </tr>
            <?php }if($twinRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Twin&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandTwin =$totaltwin;  echo getTwoDecimalNumberFormat($grandTwin);?></td>
            </tr>
            <?php }if($tripleRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Triple&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandTriple =$totaltriple;  echo getTwoDecimalNumberFormat($grandTriple); ?></td>
            </tr>
            <?php }if($quadBedRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Quad&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandQuadBed =$totalquad;  echo getTwoDecimalNumberFormat($grandQuadBed); ?></td>
            </tr>
            <?php }if($sixBedRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Six&nbsp;Bed&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandSixBed =$totalsixBed;  echo getTwoDecimalNumberFormat($grandSixBed); ?></td>
            </tr>
            <?php }if($eightBedRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Eight&nbsp;Bed&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandEightBed =$totaleightBed;  echo getTwoDecimalNumberFormat($grandEightBed); ?></td>
            </tr>
            <?php }if($tenBedRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Ten&nbsp;Bed&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandTenBed =$totaltenBed;  echo getTwoDecimalNumberFormat($grandTenBed); ?></td>
            </tr>
            <?php }if($teenBedRoom >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Teen&nbsp;Bed&nbsp;Room</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandTeenBed =$totalteenBed;  echo getTwoDecimalNumberFormat($grandTeenBed); ?></td>
            </tr>
            <?php }if($EBedAdult >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Extra&nbsp;Bed(A)</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandAWB =$totalextraBedA;  echo getTwoDecimalNumberFormat($grandAWB);?></td>
            </tr>
            <?php }if($EBedChild >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Child-With&nbsp;Bed</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandChildWB =$totalextraBedC;  echo getTwoDecimalNumberFormat($grandChildWB);?></td>
            </tr>
            <?php }if($NBedChild >0){ ?>
            <tr>
            <td align="left" colspan="4" bgcolor="#deb887"><strong>Child-No&nbsp;Bed</strong></td>
            <td align="right" bgcolor="#deb887"><?php $grandChildNB =$totalextraNBedC;  echo getTwoDecimalNumberFormat($grandChildNB);?></td>
            </tr>
            <?php } ?>
            <?php if($paxAdult >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Adult)</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpaxA); ?></td>
            <td align="center" bgcolor="#deb887">Pax</td>
            <td align="right" bgcolor="#deb887"><?php echo ($paxAdult); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandTotalPaxA=$totalpaxA*$paxAdult; echo getTwoDecimalNumberFormat($grandTotalPaxA);?></td>
            </tr>
            <?php } if($paxChild >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Child)</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpaxC); ?></td>
            <td align="center" bgcolor="#deb887">Pax</td>
            <td align="right" bgcolor="#deb887"><?php echo ($paxChild); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandTotalPaxC =$totalpaxC*$paxChild; echo getTwoDecimalNumberFormat($grandTotalPaxC);?></td>
            </tr>
            <?php } if($paxInfant >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Infant)</strong></td>
            <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat($totalpaxE); ?></td>
            <td align="center" bgcolor="#deb887">Pax</td>
            <td align="right" bgcolor="#deb887"><?php echo ($paxInfant); ?></td>
            <td align="right" bgcolor="#deb887"><?php $grandTotalPaxE =$totalpaxE*$paxInfant; echo getTwoDecimalNumberFormat($grandTotalPaxE);?></td>
            </tr>
            <?php } ?> 
            <?php if($totalDF >0){ ?>
            <tr>
            <td align="left" bgcolor="#deb887"><strong>Transport/Escort</strong></td>
            <td align="right" bgcolor="#deb887"><?php  
            echo getTwoDecimalNumberFormat($transGuideCostA); ?></td>
            <td align="center" bgcolor="#deb887">D.F.</td>
            <td align="right" bgcolor="#deb887"><?php echo ($totalDF); ?></td>
            <td align="right" bgcolor="#deb887" ><?php $grandTotalTGCost=$transGuideCostA*$totalDF; echo getTwoDecimalNumberFormat($grandTotalTGCost);?></td>
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
                <?php }if($sglRoomFE >0){ ?>
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
                <td align="left" bgcolor="#dec7c7"><strong>Land Arrangement(Local)</strong></td>
                <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat($totalPaxLE); ?></td>
                <td align="center" bgcolor="#dec7c7">Pax</td>
                <td align="right" bgcolor="#dec7c7"><?php echo ($paxAdultLE); ?></td>
                <td align="right" bgcolor="#dec7c7"><?php $grandTotalPaxLE=$totalPaxLE*$paxAdultLE; echo getTwoDecimalNumberFormat($grandTotalPaxLE);?></td>
                </tr> 
                <?php if($paxAdultLE >0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Transport/Escort</strong></td>
                <td align="right" bgcolor="#deb887"><?php  
                echo getTwoDecimalNumberFormat($transGuideCostALE); ?></td>
                <td align="center" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo ($paxAdultLE); ?></td>
                <td align="right" bgcolor="#deb887" ><?php $grandTotalTGCostALE=$transGuideCostALE*$paxAdultLE; echo getTwoDecimalNumberFormat($grandTotalTGCostALE);?></td>
                </tr>
                <?php } ?>
                <?php 
            }
            
            if($totalPaxFE >0 && $paxAdultFE>0){ ?>
                <tr>
                <td align="left" bgcolor="#d4d5f0"><strong>Land Arrangement(Foriegn)</strong></td>
                <td align="right" bgcolor="#d4d5f0"><?php echo getTwoDecimalNumberFormat($totalPaxFE); ?></td>
                <td align="center"bgcolor="#d4d5f0">Pax</td>
                <td align="right" bgcolor="#d4d5f0"><?php echo ($paxAdultFE); ?></td>
                <td align="right" bgcolor="#d4d5f0"><?php $grandTotalPaxFE=$totalPaxFE*$paxAdultFE; echo getTwoDecimalNumberFormat($grandTotalPaxFE);?></td>
                </tr>   
                <?php if($paxAdultFE >0){ ?>
                <tr>
                <td align="left" bgcolor="#deb887"><strong>Transport/Escort</strong></td>
                <td align="right" bgcolor="#deb887"><?php 
                echo getTwoDecimalNumberFormat($transGuideCostAFE); ?></td>
                <td align="center" bgcolor="#deb887">Pax</td>
                <td align="right" bgcolor="#deb887"><?php echo ($paxAdultFE); ?></td>
                <td align="right" bgcolor="#deb887" ><?php $grandTotalTGCostAFE=$transGuideCostAFE*$paxAdultFE; echo getTwoDecimalNumberFormat($grandTotalTGCostAFE);?></td>
                </tr>
                <?php } ?> 
                <?php  
            }
            ?>
            <tr>
            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Cost&nbsp;of the Trip (<?php echo getCurrencyName($baseCurrencyId); ?>) </strong></td>
            <td align="right"  style=" font-weight: 800; "><?php 
                // echo $grandTotalTGCost;
                // TOTAL COST WITH ESCORT AND ALL MONUMENTS
                $supplierCost = $grandTotalCost = $grandSingle+$grandDouble+$grandTwin+$grandTriple+$grandQuadBed+$grandSixBed+$grandEightBed+$grandTenBed+$grandTeenBed+$grandHA+$grandAWB+$grandChildWB+$grandChildNB+$grandTotalPaxA+$grandTotalPaxC+$grandTotalPaxE+$grandTotalTGCost+$grandSingleLE+$grandDoubleLE+$grandSingleFE+$grandDoubleFE+$grandTotalPaxLE+$grandTotalTGCostALE+$grandTotalPaxFE+$grandTotalTGCostAFE;
                echo round($grandTotalCost);
                ?> 
            </td> 
            </tr>
            <?php  
            
            if ($serviceMarkupMain > 0 && $isUni_Mark == 1 && $isSer_Mark == 0 ) { 
                $serviceMarkupMainLable='';
                if ($financeresult['markupSerType'] == '1') {
                    $serviceMarkupMainLable='(+) MarkUp ('.$serviceMarkupMain.'';
                }
                if ($financeresult['markupSerType'] == '2') {
                    $serviceMarkupMainLable='(+) Service Charge ('.$serviceMarkupMain.'';
                }
                if($markupTypeMain == 1){
                    $serviceMarkupMainLable  .= '%)';
                    $serviceMarkupMain2 = $serviceMarkupMain;
                }else{
                    
                    $serviceMarkupMainLable  .= 'Flat) Per Pax For '.$totalPaxACI.'pax';
                    $serviceMarkupMain2 = $serviceMarkupMain*$totalPaxACI;
                }

                $grandTotalMarkupCost = getMarkupCost($grandTotalCost, $serviceMarkupMain2, $markupTypeMain);
                $grandTotalCost = $grandTotalCost + $grandTotalMarkupCost;
                ?> 
                <tr>
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupMainLable;?></strong></td>
                    <td align="right" ><?php echo round($grandTotalMarkupCost);?></td> 
                </tr>
                <tr>
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Markup (<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                    <td align="right" style=" font-weight: 800; "><?php echo round($grandTotalCost);?></td> 
                </tr>
                <?php 
            } 

            if ($discount>0) {
                if ($discountType == '1') {
                    $discountLable  = '(-) Discount ('.$discount.'%)';
                    $discount2 = $discount;
                }else{
                    $discountLable  = '(-) Discount ('.$discount.'Flat) Per Pax For '.$totalPaxDiscount.'pax)';
                    $discount2 = $discount*$totalPaxDiscount;
                }   
                
                $grandTotalDiscountCost = getMarkupCost($grandTotalCost, $discount2, $discountType);
                $grandTotalCost = $grandTotalCost - $grandTotalDiscountCost;
                ?> 
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $discountLable; ?></strong></td>
                <td align="right" ><?php echo round($grandTotalDiscountCost);?></td> 
                </tr>
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Discount &nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                <td align="right" ><?php echo round($grandTotalCost);?></td> 
                </tr>
                <?php 
            }
            ?>
            <?php 
            if($totalExtraNoMarkupG>0){ 
                $grandTotalCost=$grandTotalCost+$totalExtraNoMarkupG;
                ?>
            <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>(+) Miscellaneous Cost</strong></td>
                <td align="right" ><?php echo getTwoDecimalNumberFormat($totalExtraNoMarkupG);?></td> 
            </tr>
            <?php } ?>
            <?php 
            if ($isUni_Mark == 1 && $isSer_Mark == 0  && ($serviceTax>0 || $tcsTax>0)) {
                // if ($serviceTax>0 || $tcsTax>0) {
                if ($serviceTax>0) {
                    if ($financeresult['taxType'] == '1') {
                        $serviceMarkupLable  = '(+) GST ('.$serviceTax.'%)';
                    }
                    if ($financeresult['taxType'] == '2') {
                        $serviceMarkupLable  = '(+) VAT ('.$serviceTax.'%)';
                    }
                }
                $taxType = 1; 
                if ($tcsTax>0){ 
                    $serviceTCSLable  = '(+) TCS ('.$tcsTax.'%)';
                }
                // echo ($taxType == 1) ? '&nbsp;(%)' : '&nbsp;(Flat)';
                $grandTotalServiceTaxCost = getMarkupCost($grandTotalCost, $serviceTax, $taxType, $serviceTaxDivident);

                $grandTotalTCSCost = getMarkupCost($grandTotalCost, $tcsTax, $taxType);

                $grandTotalCost = $grandTotalCost + $grandTotalServiceTaxCost + $grandTotalTCSCost;
                if($serviceTax>0){ ?>
                    <tr>
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupLable;?></strong></td>
                    <td align="right" ><?php echo round($grandTotalServiceTaxCost);?></td> 
                    </tr>
                    <?php 
                }
                if ($tcsTax>0){ ?>
                    <tr>  
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceTCSLable;?></strong></td>

                    <td align="right" ><?php echo round($grandTotalTCSCost);?></td> 
                    </tr>
                  <?php 
                } ?>
                <tr>
                <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Tour&nbsp;Cost&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                <td align="right" style=" font-weight: 800; "><?php echo  round($grandTotalCost); ?></td> 
                </tr>
                <?php 
            } 
        

            if($newCurr!=$baseCurrencyId){ ?>
            <tr>
            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Tour&nbsp;Cost&nbsp;(In <?php echo getCurrencyName($newCurr); ?>)</strong></td>
            <td align="right"  style=" font-weight: 800; "><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$grandTotalCost); ?></td> 
            </tr>
            <?php } ?>
        </table>  

        <br>
        <strong style="font-size:12px;text-transform: uppercase;">Per Person Basis Cost</strong>
        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
            <?php 
           
            // Per pax basis cost
           
            $ppCostONSingleBasis = ($totalsingle/$singleRoom)+$totalpaxA+$transGuideCostA;
            $ppCostONDoubleBasis = ($totaldouble/($doubleRoom*2))+$totalpaxA+$transGuideCostA;
            $ppCostONTwinBasis = ($totaltwin/($twinRoom*2))+$totalpaxA+$transGuideCostA;
            $ppCostOnTripleBasis = ($totaltriple/($tripleRoom*3))+$totalpaxA+$transGuideCostA;
            $ppCostOnQuadBasis = ($totalquad/($quadBedRoom*4))+$totalpaxA+$transGuideCostA;
            $ppCostOnSixBasis = ($totalsixBed/($sixBedRoom*6))+$totalpaxA+$transGuideCostA;
            $ppCostOnEightBasis = ($totaleightBed/($eightBedRoom*8))+$totalpaxA+$transGuideCostA;
            $ppCostOnTenBasis = ($totaltenBed/($tenBedRoom*10))+$totalpaxA+$transGuideCostA;
        
            $ppCostOnExtraBedABasis = (($totalextraBedA/$EBedAdult)+$totalpaxA+$transGuideCostAEBed);

            $pcCostOnTeenBasis = ($totalteenBed/$teenBedRoom)+$totalpaxC+$transGuideCostC;
            $pcCostOnExtraBedCBasis = (($totalextraBedC/$EBedChild)+$totalpaxC+$transGuideCostC);
            $pcCostOnExtraNBedCBasis = (($totalextraNBedC/$NBedChild)+$totalpaxC+$transGuideCostC);
            $peCostBasis = ($totalpaxE+$transGuideCostE);// +$transGuideCostE
            
            $markupTypeMain2 = $markupTypeMain;
            $serviceTax2 = $serviceTax;
            if($isUni_Mark == 0 && $isSer_Mark==1){
                $serviceMarkupMain=0;
                $markupTypeMain2 = 0;
            }

            ?>

            <tr>
            <td align="left" bgcolor="#F5F5F5" ><strong>Occupancy</strong></td>
            <td align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost</strong></td> 
            </tr>
            <?php
            if($queryType==14){
                ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Adult&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo $ppCostOnAdultBasis = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$grandTotalCost)/$totalDF);  ?>
            </td> 
            </tr>
            <?php if($paxChild>0){?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Child&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo $ppCostOnChildBasis = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$grandTotalCost)/$totalDF);  ?>
            </td> 
            </tr>
            <?php } if($paxInfant>0){ ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Infant&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo $ppCostOnInfantBasis = round(getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$grandTotalCost)/$totalDF);  ?>
            </td> 
            </tr>
                <?php
            }

            }else{
            if ($ppCostONSingleBasis>0 && $singleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Single&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostONSingleBasis".$val} = getPerPersonBasisCost($ppCostONSingleBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident);  ?>
            </td> 
            </tr>
            <?php } if($ppCostONDoubleBasis>0 && $doubleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Double&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostONDoubleBasis".$val} = getPerPersonBasisCost($ppCostONDoubleBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php } if($ppCostONTwinBasis>0 && $twinRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Twin&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostONTwinBasis".$val} = getPerPersonBasisCost($ppCostONTwinBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr> 
            <?php } if($ppCostOnTripleBasis>0 && $tripleRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Triple&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostOnTripleBasis".$val} = getPerPersonBasisCost($ppCostOnTripleBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php }if($ppCostOnQuadBasis>0 && $quadBedRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Quad&nbsp;Room&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostOnQuadBasis".$val} = getPerPersonBasisCost($ppCostOnQuadBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php }if($ppCostOnSixBasis>0 && $sixBedRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Six&nbsp;Bed&nbsp;Room&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostOnSixBasis".$val} = getPerPersonBasisCost($ppCostOnSixBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php }if($ppCostOnEightBasis>0 && $eightBedRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Eight&nbsp;Bed&nbsp;Room&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostOnEightBasis".$val} = getPerPersonBasisCost($ppCostOnEightBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php }if($ppCostOnTenBasis>0 && $tenBedRoom>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Ten&nbsp;Bed&nbsp;Room&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostOnTenBasis".$val} = getPerPersonBasisCost($ppCostOnTenBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php } if($ppCostOnExtraBedABasis>0 && $EBedAdult>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Adult&nbsp;Cost&nbsp;On&nbsp;ExtraBed&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"ppCostOnExtraBedABasis".$val} = getPerPersonBasisCost($ppCostOnExtraBedABasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php }if($pcCostOnTeenBasis>0 && $teenBedRoom>0) { ?>
            <tr> 
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;On&nbsp;Teen&nbsp;Bed&nbsp;Room&nbsp;Basis</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"pcCostOnTeenBasis".$val} = getPerPersonBasisCost($pcCostOnTeenBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php } if($pcCostOnExtraBedCBasis>0 && $EBedChild>0) { ?>
            <tr> 
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;(WithBed)</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"pcCostOnExtraBedCBasis".$val} = getPerPersonBasisCost($pcCostOnExtraBedCBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php } if($pcCostOnExtraNBedCBasis>0 && $NBedChild>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;(WithoutBed)</td>
            <td align="right" style=" font-weight: 800; "><?php echo ${"pcCostOnExtraNBedCBasis".$val} = getPerPersonBasisCost($pcCostOnExtraNBedCBasis,$serviceMarkupMain,$markupTypeMain2,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php } if($paxInfant>0) { ?>
            <tr>
            <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Infant&nbsp;Cost</td>
            <td align="right" style=" font-weight: 800; "><?php
            if($DF_INF>0){
                $serviceMarkupMainE=$serviceMarkupMain;
                $markupTypeMainE=$markupTypeMain2;
            }else{
                $serviceMarkupMainE=0;
                $markupTypeMainE=0;
            }
            echo ${"peCostBasis".$val} = getPerPersonBasisCost($peCostBasis,$serviceMarkupMainE,$markupTypeMainE,$discount,$discountType,$serviceTax2,$isUni_Mark,$tcsTax,$serviceTaxDivident); ?></td> 
            </tr>
            <?php } 
            }
            ?>
        </table>
        <?php 


        $clientCost = ${"proposalCost".$val} = $grandTotalCost;
        // $nameinv = 'totalCompanyCost="'.getTwoDecimalNumberFormat($supplierCost).'",totalQuotCost="'.$clientCost.'",totalMarkupCost="'.$grandTotalMarkupCost.'",totalDiscountCost="'.$grandTotalDiscountCost.'",totalServiceTaxCost="'.$grandTotalServiceTaxCost.'",totalTCSCost="'.$grandTotalTCSCost.'",sglBasisCost="'.$ppCostONSingleBasis.'",dblBasisCost="'.$ppCostONDoubleBasis.'",twinCost="'.$ppCostONTwinBasis.'",tplBasisCost="'.$ppCostOnTripleBasis.'",quadBasisCost="'.$ppCostOnQuadBasis.'",sixBedBasisCost="'.$ppCostOnSixBasis.'",eightBedBasisCost="'.$ppCostOnEightBasis.'",tenBedBasisCost="'.$ppCostOnTenBasis.'",extraAdultCost="'.$ppCostOnExtraBedABasis.'",CWBCost="'.$pcCostOnExtraBedCBasis.'",CNBCost="'.$pcCostOnExtraNBedCBasis.'"';
        // updatelisting(_QUOTATION_MASTER_,$nameinv,'id="'.$quotationId.'"');

        ?>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td valign="top">
        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
            <tr height="18">
                <td height="18" colspan="5" align="center" bgcolor="#F5F5F5" style="font-size:16px;font-weight: 600;">General Information</td>
            </tr>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Adult&nbsp;Pax</strong></td>
            <td align="right" ><?php echo $paxAdult; ?></td> 
            </tr>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Child&nbsp;Pax</strong></td>
            <td align="right" ><?php echo $paxChild; ?></td> 
            </tr>   
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Infant&nbsp;Pax</strong></td>
            <td align="right" ><?php echo $paxInfant; ?></td> 
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
            <?php } if( $twinRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Twin&nbsp;Room</strong></td>
            <td align="right" ><?php echo $twinRoom; ?></td> 
            </tr>
            <?php } if( $tripleRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Triple&nbsp;Room</strong></td>
            <td align="right" ><?php echo $tripleRoom; ?></td> 
            </tr>
            <?php } if( $quadBedRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>Quad&nbsp;Room</strong></td>
            <td align="right" ><?php echo $quadBedRoom; ?></td> 
            </tr>
            <?php } if( $sixBedRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>SixBEd&nbsp;Room</strong></td>
            <td align="right" ><?php echo $sixBedRoom; ?></td> 
            </tr>
            <?php } if( $eightBedRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>EightBed&nbsp;Room</strong></td>
            <td align="right" ><?php echo $eightBedRoom; ?></td> 
            </tr>
            <?php } if( $tenBedRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>TenBed&nbsp;Room</strong></td>
            <td align="right" ><?php echo $tenBedRoom; ?></td> 
            </tr>
            <?php } if( $teenBedRoom >0){ ?>
            <tr>
            <td align="right" bgcolor="#F5F5F5" ><strong>TeenBed&nbsp;Room</strong></td>
            <td align="right" ><?php echo $teenBedRoom; ?></td> 
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
            if ($discountType == 1) {
                echo'Discount(%)';
            }else{
                echo'Discount(Flat(PP))';
            } 
            ?>
            </strong></td>
            <td align="right" ><?php echo $discount; ?></td> 
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
<!-- BREAKUP COST FOR DOMESTIC --> 
<table width="100%" cellpadding="0" cellspacing="0" >
    <tr>
    <td align="left" width="60%" >
        <?php
        $groupSlabBSql = "";
        $groupSlabBSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc limit 1');
        if (mysqli_num_rows($groupSlabBSql)>0) {
        while($groupSlabBD = mysqli_fetch_array($groupSlabBSql)){
            $paxAdultBLE = $groupSlabBD['localEscort'];
            $paxAdultBFE = $groupSlabBD['foreignEscort'];

            $DF_SGLB = clean($defaultSlabData['DF_SGL']);
            $DF_DBLB = clean($defaultSlabData['DF_DBL']);
            $DF_TPLB = clean($defaultSlabData['DF_TPL']);
            $DF_ABEDB = clean($defaultSlabData['DF_ABED']);
            $DF_CBEDB = clean($defaultSlabData['DF_CBED']);
            if($queryType==14){
                $totalDFB = ($defaultSlabData['adult']+$defaultSlabData['child']+$defaultSlabData['infant']);
            }else{
                $totalDFB = ($DF_SGL+$DF_DBL+$DF_TPL+$DF_ABED+$DF_CBED);
            }
           

            $esQBLE = "";
            $esQBLE = GetPageRecord('*', 'quotationFOCRates',' 1 and slabId="'.$groupSlabBD['id'].'" and focType="LE" and quotationId="'.$quotationId.'"');
            if (mysqli_num_rows($esQBLE)>0 && $paxAdultBLE>0) {
                $escortDataBLE = mysqli_fetch_array($esQBLE);
                $sglRoomBLE = $escortDataBLE['sglNORoom'];
                $dblRoomBLE = $escortDataBLE['dblNORoom'];
                // cost discount
                $focTypeBLE="LE";
                $hotelBLE=$escortDataBLE['hotelCost'];
                $guideBLE=$escortDataBLE['guideCost'];
                $activityBLE=$escortDataBLE['activityCost'];
                $entranceBLE=$escortDataBLE['entranceCost'];
                $transferBLE=$escortDataBLE['transferCost'];
                $ferryBLE=$escortDataBLE['ferryCost'];
                $trainBLE=$escortDataBLE['trainCost'];
                $flightBLE=$escortDataBLE['flightCost'];
                $restaurantBLE=$escortDataBLE['restaurantCost'];
                $otherBLE=$escortDataBLE['otherCost'];

                $hotelCalTypeBLE=$escortDataBLE['hotelCalType'];
                $guideCalTypeBLE=$escortDataBLE['guideCalType'];
                $activityCalTypeBLE=$escortDataBLE['activityCalType'];
                $entranceCalTypeBLE=$escortDataBLE['entranceCalType'];
                $transferCalTypeBLE=$escortDataBLE['transferCalType'];
                $ferryCalTypeBLE=$escortDataBLE['ferryCalType'];
                $trainCalTypeBLE=$escortDataBLE['trainCalType'];
                $flightCalTypeBLE=$escortDataBLE['flightCalType'];
                $restaurantCalTypeBLE=$escortDataBLE['restaurantCalType'];
                $otherCalTypeBLE=$escortDataBLE['otherCalType'];
            }
            $esQBFE = "";
            $esQBFE = GetPageRecord('*', 'quotationFOCRates', ' 1 and slabId="'.$slabId.'" and focType="FE" and quotationId="'.$quotationId.'"');
            if (mysqli_num_rows($esQBFE)>0 && $paxAdultBFE>0) {
                $escortDataBFE = mysqli_fetch_array($esQBFE);
                $sglRoomBFE = $escortDataBFE['sglNORoom'];
                $dblRoomBFE = $escortDataBFE['dblNORoom'];

                // cost discount
                $focTypeBFE="FE";
                $hotelBFE=$escortDataBFE['hotelCost'];
                $guideBFE=$escortDataBFE['guideCost'];
                $activityBFE=$escortDataBFE['activityCost'];
                $entranceBFE=$escortDataBFE['entranceCost'];
                $transferBFE=$escortDataBFE['transferCost'];
                $ferryBFE=$escortDataBFE['ferryCost'];
                $trainBFE=$escortDataBFE['trainCost'];
                $flightBFE=$escortDataBFE['flightCost'];
                $restaurantBFE=$escortDataBFE['restaurantCost'];
                $otherBFE=$escortDataBFE['otherCost'];

                $hotelCalTypeBFE=$escortDataBFE['hotelCalType'];
                $guideCalTypeBFE=$escortDataBFE['guideCalType'];
                $activityCalTypeBFE=$escortDataBFE['activityCalType'];
                $entranceCalTypeBFE=$escortDataBFE['entranceCalType'];
                $transferCalTypeBFE=$escortDataBFE['transferCalType'];
                $ferryCalTypeBFE=$escortDataBFE['ferryCalType'];
                $trainCalTypeBFE=$escortDataBFE['trainCalType'];
                $flightCalTypeBFE=$escortDataBFE['flightCalType'];
                $restaurantCalTypeBFE=$escortDataBFE['restaurantCalType'];
                $otherCalTypeBFE=$escortDataBFE['otherCalType'];
            }
            ?>
            <strong>Break-up&nbsp;Cost | <?php if($travelType == 2){ echo "Total Pax (".$paxrange.")"; }else{ echo " Dividing Factor: (".$paxrange.")"; } ?></strong>
            <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000" style="font-size: 12px;" >
              <thead>
                <tr>
                  <th width="5%" align="left" bgcolor="#F5F5F5"><strong>Date</strong></th>
                  <th width="5%" align="left" bgcolor="#F5F5F5"><strong>Type</strong></th>
                  <th width="65%" align="left" bgcolor="#F5F5F5"><strong>Service&nbsp;Name</strong></th>
                  <th width="5%" align="right" bgcolor="#F5F5F5"><strong>Service&nbsp;Cost</strong></th>
                  <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                  <th width="5%" align="right" bgcolor="#F5F5F5"><strong>MarkUp&nbsp;Amount</strong></th>
                  <th width="5%" align="right" bgcolor="#F5F5F5"><strong>Tax&nbsp;Amount</strong></th>
                  <?php } ?>
                  <th width="5%" align="right" bgcolor="#F5F5F5"><strong>Total&nbsp;Cost</strong></th>
                </tr>
              </thead>
              <tbody><?php

                    $totalpaxDF = $paxAdult+$DF_CBED+$DF_INF;
                  $grandTotalServiceCost=$grandServiceCost=$grandServiceMarkup=$grandServiceGst=0;
                  $qItiQuery=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" order by startDate asc');
                  while($qItData=mysqli_fetch_array($qItiQuery)){
                    $serviceType = $qItData['serviceType'];
                    $serviceId = $qItData['serviceId'];
                    $serviceDate = $qItData['startDate'];
                    $uniq_Id = $qItData['id'];
                   
                    
                    if($serviceType=='hotel'){
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and isHotelSupplement!=1  and isRoomSupplement!=1 and supplierId="'.$serviceId.'" and fromDate="'.$serviceDate.'" '.$multihotelQuery.' '.$hotelTypeQuery.' ');
                      while($hotelQuotData=mysqli_fetch_array($c)){
                        // hotel data
                        $serviceCost=$serviceMarkup=$serviceGst=0; 
                        $singleRoom=$doubleRoom=$twinRoom=$tripleRoom=$quadBedRoom=$sixBedRoom=$eightBedRoom=$tenBedRoom=$teenBedRoom=$EBedAdult=$EBedChild=$NBedChild=0;
                        
 
                        $singleRoom = $hotelQuotData['singleNoofRoom'];
                        $doubleRoom = $hotelQuotData['doubleNoofRoom'];
                        $twinRoom = $hotelQuotData['twinNoofRoom'];
                        $tripleRoom = $hotelQuotData['tripleNoofRoom'];
                        $quadBedRoom = $hotelQuotData['quadNoofRoom'];
                        $sixBedRoom = $hotelQuotData['sixNoofRoom'];
                        $eightBedRoom = $hotelQuotData['eightNoofRoom'];
                        $tenBedRoom = $hotelQuotData['tenNoofRoom'];
                        $teenBedRoom = $hotelQuotData['teenNoofRoom'];
                        $EBedAdult = $hotelQuotData['extraNoofBed'];
                        $EBedChild = $hotelQuotData['childwithNoofBed'];
                        $NBedChild = $hotelQuotData['childwithoutNoofBed'];

                        $d='';
                        $d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');
                        $hotelData=mysqli_fetch_array($d);
                        
                        if($hotelQuotData['isGuestType']==1 || ($hotelQuotData['isLocalEscort']==1 && $paxAdultBLE>0) || ($hotelQuotData['isForeignEscort']==1 && $paxAdultBFE>0)){

                            $markupType = $hotelQuotData['markupType'];
                            $currencyValue = $hotelQuotData['currencyValue'];
                            $sglMarkup = $dblMarkup = $twinMarkup = $tplMarkup = $quadMarkup = $cwbMarkup = $cnbMarkup = $exMarkup = 
                            $mealMarkup = $gstTax = 0;
                           
                            // if domestic service wise markup
                            if($isSer_Mark == 1 && $isUni_Mark == 0){
                                $sglMarkup = $hotelQuotData['sglMarkup'];
                                $dblMarkup = $hotelQuotData['dblMarkup'];
                                $twinMarkup = $hotelQuotData['twinMarkup'];
                                $tplMarkup = $hotelQuotData['tplMarkup'];
                                $quadMarkup = $hotelQuotData['quadMarkup'];
                                $cwbMarkup = $hotelQuotData['cwbMarkup'];
                                $cnbMarkup = $hotelQuotData['cnbMarkup'];
                                $exMarkup = $hotelQuotData['exMarkup'];
                                $mealMarkup = $hotelQuotData['mealMarkup'];
                                $gstTax = getGstValueById($hotelQuotData['roomGST']);
                            }
                            $gstType = 1;
                            $taxType = $hotelQuotData['taxType'];
                            $hotelLableB = '';    
                            if($hotelQuotData['isEarlyCheckin']==1){
                                $hotelLableB .= 'Early CheckIn - ';
                                if($hotelQuotData['isGuestType']==1){
                                    $hotelLableB .= ' Guest,';
                                    
                                    $singleB=$doubleB=$twinB=$tripleB=$quadBedB=$sixBedB=$eightBedB=$tenBedB=$teenBedB=$extraBedAB=$extraBedCB=$breakfastAB=$lunchAB=$dinnerAB=$breakfastCB=$lunchCB=$dinnerCB=0;
                                    if($singleRoom>0){
                                        $singleB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['singleoccupancy']);
                                        $serviceCost = $serviceCost+($singleB*$singleRoom); // ServiceCost**********************
                                        $singleBMarkup = getMarkupCost($singleB,$sglMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($singleBMarkup*$singleRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $singleBTax = getMarkupCost($singleBMarkup,$gstTax,$gstType);
                                        }else{
                                            $singleBAndMarkup = $singleB+$singleBMarkup;
                                            $singleBTax = getMarkupCost($singleBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($singleBTax*$singleRoom); // Service Gst**********************
                                    }

                                    if($doubleRoom>0){
                                        $doubleB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['doubleoccupancy']);
                                        $serviceCost = $serviceCost+($doubleB*$doubleRoom); // ServiceCost**********************
                                        $doubleBMarkup = getMarkupCost($doubleB,$dblMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($doubleBMarkup*$doubleRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $doubleBTax = getMarkupCost($doubleBMarkup,$gstTax,$gstType);
                                        }else{
                                            $doubleBAndMarkup = $doubleB+$doubleBMarkup;
                                            $doubleBTax = getMarkupCost($doubleBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($doubleBTax*$doubleRoom); // Service Gst**********************
                                    }

                                    if($twinRoom>0){
                                        $twinB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['twinoccupancy']);
                                        $serviceCost = $serviceCost+($twinB*$twinRoom); // ServiceCost**********************
                                        $twinBMarkup = getMarkupCost($twinB,$twinMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($twinBMarkup*$twinRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $twinBTax = getMarkupCost($twinBMarkup,$gstTax,$gstType);
                                        }else{
                                            $twinBAndMarkup = $twinB+$twinBMarkup;
                                            $twinBTax = getMarkupCost($twinBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($twinBTax*$twinRoom); // Service Gst**********************
                                    }

                                    if($tripleRoom>0){
                                        $tripleB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['tripleoccupancy']);
                                        $serviceCost = $serviceCost+($tripleB*$tripleRoom); // ServiceCost**********************
                                        $tripleBMarkup = getMarkupCost($tripleB,$tplMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($tripleBMarkup*$tripleRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $tripleBTax = getMarkupCost($tripleBMarkup,$gstTax,$gstType);
                                        }else{
                                            $tripleBAndMarkup = $tripleB+$tripleBMarkup;
                                            $tripleBTax = getMarkupCost($tripleBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($tripleBTax*$tripleRoom); // Service Gst**********************
                                    }

                                    if($quadBedRoom>0){
                                        $quadBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['quadRoom']);
                                        $serviceCost = $serviceCost+($quadBedB*$quadBedRoom); // ServiceCost**********************
                                        $quadBedBMarkup = getMarkupCost($quadBedB,$quadMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($quadBedBMarkup*$quadBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $quadBedBTax = getMarkupCost($quadBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $quadBedBAndMarkup = $quadBedB+$quadBedBMarkup;
                                            $quadBedBTax = getMarkupCost($quadBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($quadBedBTax*$quadBedRoom); // Service Gst**********************
                                    } 
                                   
                                    if($sixBedRoom>0){
                                        $sixBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['sixBedRoom']);
                                        $serviceCost = $serviceCost+($sixBedB*$sixBedRoom); // ServiceCost**********************
                                        $sixBedBMarkup = getMarkupCost($sixBedB,$sixMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($sixBedBMarkup*$sixBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $sixBedBTax = getMarkupCost($sixBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $sixBedBAndMarkup = $sixBedB+$sixBedBMarkup;
                                            $sixBedBTax = getMarkupCost($sixBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($sixBedBTax*$sixBedRoom); // Service Gst**********************
                                    }

                                    if($eightBedRoom>0){
                                        $eightBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['eightBedRoom']);
                                        $serviceCost = $serviceCost+($eightBedB*$eightBedRoom); // ServiceCost**********************
                                        $eightBedBMarkup = getMarkupCost($eightBedB,$eightMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($eightBedBMarkup*$eightBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $eightBedBTax = getMarkupCost($eightBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $eightBedBAndMarkup = $eightBedB+$eightBedBMarkup;
                                            $eightBedBTax = getMarkupCost($eightBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($eightBedBTax*$eightBedRoom); // Service Gst**********************
                                    }

                                    if($tenBedRoom>0){
                                        $tenBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['tenBedRoom']);
                                        $serviceCost = $serviceCost+($tenBedB*$tenBedRoom); // ServiceCost**********************
                                        $tenBedBMarkup = getMarkupCost($tenBedB,$quadMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($tenBedBMarkup*$tenBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $tenBedBTax = getMarkupCost($tenBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $tenBedBAndMarkup = $tenBedB+$tenBedBMarkup;
                                            $tenBedBTax = getMarkupCost($tenBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($tenBedBTax*$tenBedRoom); // Service Gst**********************
                                    }

                                    if($teenBedRoom>0){
                                        $teenBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['teenRoom']);
                                        $serviceCost = $serviceCost+($teenBedB*$teenBedRoom); // ServiceCost**********************
                                        $teenBedBMarkup = getMarkupCost($teenBedB,$quadMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($teenBedBMarkup*$teenBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $teenBedBTax = getMarkupCost($teenBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $teenBedBAndMarkup = $teenBedB+$teenBedBMarkup;
                                            $teenBedBTax = getMarkupCost($teenBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($teenBedBTax*$teenBedRoom); // Service Gst**********************
                                    }
                                    
                                    if($EBedAdult>0){ 
                                        $extraBedAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['extraBed']);
                                        $serviceCost = $serviceCost+($extraBedAB*$EBedAdult); // ServiceCost**********************
                                        $extraBedABMarkup = getMarkupCost($extraBedAB,$exMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($extraBedABMarkup*$EBedAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $extraBedABTax = getMarkupCost($extraBedABMarkup,$gstTax,$gstType);
                                        }else{
                                            $extraBedABAndMarkup = $extraBedAB+$extraBedABMarkup;
                                            $extraBedABTax = getMarkupCost($extraBedABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($extraBedABTax*$EBedAdult); // Service Gst**********************
                                    } 
                                    
                                    if($EBedChild>0){ 
                                        $extraBedCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childwithbed']);
                                        $serviceCost = $serviceCost+($extraBedCB*$EBedChild); // ServiceCost**********************
                                        $extraBedCBMarkup = getMarkupCost($extraBedCB,$cwbMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($extraBedCBMarkup*$EBedChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $extraBedCBTax = getMarkupCost($extraBedCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $extraBedCBAndMarkup = $extraBedCB+$extraBedCBMarkup;
                                            $extraBedCBTax = getMarkupCost($extraBedCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($extraBedCBTax*$EBedChild); // Service Gst**********************
                                    } 

                                    if($NBedChild>0){ 
                                        $extraNBedCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childwithoutbed']);
                                        $serviceCost = $serviceCost+($extraNBedCB*$NBedChild); // ServiceCost**********************
                                        $extraNBedCBMarkup = getMarkupCost($extraNBedCB,$cnbMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($extraNBedCBMarkup*$NBedChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $extraNBedCBTax = getMarkupCost($extraNBedCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $extraNBedCBAndMarkup = $extraNBedCB+$extraNBedCBMarkup;
                                            $extraNBedCBTax = getMarkupCost($extraNBedCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($extraNBedCBTax*$NBedChild); // Service Gst**********************
                                    } 

                                    if($hotelQuotData['complimentaryBreakfast'] == 1 && $hotelQuotData['breakfast']>0){
                                        $breakfastAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['breakfast']);

                                        $serviceCost = $serviceCost+($breakfastAB*$paxAdult); // ServiceCost**********************
                                        $breakfastABMarkup = getMarkupCost($breakfastAB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastABMarkup*$paxAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastABTax = getMarkupCost($breakfastABMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastABAndMarkup = $breakfastAB+$breakfastABMarkup;
                                            $breakfastABTax = getMarkupCost($breakfastABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastABTax*$paxAdult); // Service Gst**********************
                                    } 

                                    if($hotelQuotData['complimentaryLunch'] == 1 && $hotelQuotData['lunch']>0){
                                        $lunchAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['lunch']);

                                        $serviceCost = $serviceCost+($lunchAB*$paxAdult); // ServiceCost**********************
                                        $lunchABMarkup = getMarkupCost($lunchAB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchABMarkup*$paxAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchABTax = getMarkupCost($lunchABMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchABAndMarkup = $lunchAB+$lunchABMarkup;
                                            $lunchABTax = getMarkupCost($lunchABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchABTax*$paxAdult); // Service Gst**********************
                                    }

                                    if($hotelQuotData['complimentaryDinner'] == 1 && $hotelQuotData['dinner']>0){
                                        $dinnerAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['dinner']);

                                        $serviceCost = $serviceCost+($dinnerAB*$paxAdult); // ServiceCost**********************
                                        $dinnerABMarkup = getMarkupCost($dinnerAB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerABMarkup*$paxAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerABTax = getMarkupCost($dinnerABMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerABAndMarkup = $dinnerAB+$dinnerABMarkup;
                                            $dinnerABTax = getMarkupCost($dinnerABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerABTax*$paxAdult); // Service Gst**********************
                                    }

                                    if($hotelQuotData['isChildBreakfast'] == 1 && $hotelQuotData['childBreakfast']>0){
                                        $breakfastCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childBreakfast']);

                                        $serviceCost = $serviceCost+($breakfastCB*$paxChild); // ServiceCost**********************
                                        $breakfastCBMarkup = getMarkupCost($breakfastCB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastCBMarkup*$paxChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastCBTax = getMarkupCost($breakfastCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastCBAndMarkup = $breakfastCB+$breakfastCBMarkup;
                                            $breakfastCBTax = getMarkupCost($breakfastCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastCBTax*$paxChild); // Service Gst**********************
                                    } 

                                    if($hotelQuotData['isChildLunch'] == 1 && $hotelQuotData['childLunch']>0){
                                        $lunchCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childLunch']);

                                        $serviceCost = $serviceCost+($lunchCB*$paxChild); // ServiceCost**********************
                                        $lunchCBMarkup = getMarkupCost($lunchCB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchCBMarkup*$paxChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchCBTax = getMarkupCost($lunchCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchCBAndMarkup = $lunchCB+$lunchCBMarkup;
                                            $lunchCBTax = getMarkupCost($lunchCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchCBTax*$paxChild); // Service Gst**********************
                                    }

                                    if($hotelQuotData['isChildDinner'] == 1 && $hotelQuotData['childDinner']>0){
                                        $dinnerCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childDinner']);

                                        $serviceCost = $serviceCost+($dinnerCB*$paxChild); // ServiceCost**********************
                                        $dinnerCBMarkup = getMarkupCost($dinnerCB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerCBMarkup*$paxChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerCBTax = getMarkupCost($dinnerCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerCBAndMarkup = $dinnerCB+$dinnerCBMarkup;
                                            $dinnerCBTax = getMarkupCost($dinnerCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerCBTax*$paxChild); // Service Gst**********************
                                    }
                                    
                                    $dB = '';
                                    $dB = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$hotelQuotData['id'].'" and fromDate="' . $serviceDate . '" order by id asc');
                                    while ($qHAdditionalDataB = mysqli_fetch_array($dB)) {
                                        if ($qHAdditionalDataB['costType']==2) {
                                            $additionalCost = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal, $qHAdditionalDataB['additionalCost']);
                                            $perPaxCostB = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                                        } else {
                                            $perPaxCostB = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal, $qHAdditionalDataB['additionalCost']);
                                        }
                                        $dayTotalHACostB = ($dayTotalHACostB + trim($perPaxCostB));
                                    } 

                                    if($dayTotalHACostB>0){  
                                        $serviceCost = $serviceCost+($dayTotalHACostB*$totalPax); // ServiceCost**********************
                                        $dayTotalHACostBMarkup = getMarkupCost($dayTotalHACostB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dayTotalHACostBMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dayTotalHACostBTax = getMarkupCost($dayTotalHACostBMarkup,$gstTax,$gstType);
                                        }else{
                                            $dayTotalHACostBAndMarkup = $dayTotalHACostB+$dayTotalHACostBMarkup;
                                            $dayTotalHACostBTax = getMarkupCost($dayTotalHACostBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dayTotalHACostBTax*$totalPax); // Service Gst**********************
                                    }

                                }

                                if($hotelQuotData['isLocalEscort']==1 && $paxAdultBLE>0){
                                    $hotelLableB .= ' L.Escort,';

                                    $singleBLE=$doubleBLE=$breakfastABLE=$lunchBLE=$dinnerBLE=0;
                                    if($sglRoomBLE>0){
                                        $singleBLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['singleoccupancy']),$hotelBLE,$hotelCalTypeBLE);
                                        $singleBLE = ($singleBLE);
                                        $serviceCost = $serviceCost+($singleBLE*$sglRoomBLE); // ServiceCost**********************
                                        $singleBLEMarkup = getMarkupCost($singleBLE,$sglMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($singleBLEMarkup*$sglRoomBLE); // Service Markup**********************
                                        if($taxType == 2){
                                            $singleBLETax = getMarkupCost($singleBLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $singleBLEAndMarkup = $singleBLE+$singleBLEMarkup;
                                            $singleBLETax = getMarkupCost($singleBLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($singleBLETax*$sglRoomBLE); // Service Gst**********************
                                    }

                                    if($dblRoomBLE>0){
                                        $doubleBLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['doubleoccupancy']),$hotelBLE,$hotelCalTypeBLE);
                                        $doubleBLE = ($doubleBLE);
                                        $serviceCost = $serviceCost+($doubleBLE*$dblRoomBLE); // ServiceCost**********************
                                        $doubleBLEMarkup = getMarkupCost($doubleBLE,$dblMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($doubleBLEMarkup*$dblRoomBLE); // Service Markup**********************
                                        if($taxType == 2){
                                            $doubleBLETax = getMarkupCost($doubleBLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $doubleBLEAndMarkup = $doubleBLE+$doubleBLEMarkup;
                                            $doubleBLETax = getMarkupCost($doubleBLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($doubleBLETax*$dblRoomBLE); // Service Gst**********************

                                    }

                                    if($hotelQuotData['complimentaryBreakfast'] == 1 && $hotelQuotData['breakfast']>0){
                                        $breakfastABLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['breakfast']),$restaurantBLE,$restaurantCalTypeBLE); 

                                        $serviceCost = $serviceCost+($breakfastABLE*$totalPax); // ServiceCost**********************
                                        $breakfastABLEMarkup = getMarkupCost($breakfastABLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastABLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastABLETax = getMarkupCost($breakfastABLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastABLEAndMarkup = $breakfastABLE+$breakfastABLEMarkup;
                                            $breakfastABLETax = getMarkupCost($breakfastABLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastABLETax*$totalPax); // Service Gst**********************
                                    }
                     
                                    if($hotelQuotData['complimentaryLunch'] == 1 && $hotelQuotData['lunch']>0){
                                        $lunchABLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['lunch']),$restaurantBLE,$restaurantCalTypeBLE);

                                        $serviceCost = $serviceCost+($lunchABLE*$totalPax); // ServiceCost**********************
                                        $lunchABLEMarkup = getMarkupCost($lunchABLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchABLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchABLETax = getMarkupCost($lunchABLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchABLEAndMarkup = $lunchABLE+$lunchABLEMarkup;
                                            $lunchABLETax = getMarkupCost($lunchABLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchABLETax*$totalPax); // Service Gst**********************
                                    }

                                    if($hotelQuotData['complimentaryDinner'] == 1 && $hotelQuotData['dinner']>0){
                                        $dinnerABLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['dinner']),$restaurantBLE,$restaurantCalTypeBLE);

                                        $serviceCost = $serviceCost+($dinnerABLE*$totalPax); // ServiceCost**********************
                                        $dinnerABLEMarkup = getMarkupCost($dinnerABLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerABLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerABLETax = getMarkupCost($dinnerABLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerABLEAndMarkup = $dinnerABLE+$dinnerABLEMarkup;
                                            $dinnerABLETax = getMarkupCost($dinnerABLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerABLETax*$totalPax); // Service Gst**********************
                                    }

                                    $dB = '';
                                    $dB = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$hotelQuotData['id'].'" and fromDate="' . $serviceDate . '" order by id asc');
                                    while ($qHAdditionalDataB = mysqli_fetch_array($dB)) {
                                        if ($qHAdditionalDataB['costType']==2) {
                                            $additionalCost = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal, $qHAdditionalDataB['additionalCost']);
                                            $perPaxCostB = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                                        } else {
                                            $perPaxCostB = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal, $qHAdditionalDataB['additionalCost']);
                                        }
                                        $dayTotalHACostB = ($dayTotalHACostB + trim($perPaxCostB));
                                    } 
                                    if($dayTotalHACostB>0){
                                        $dayTotalHACostBLE = getMarkupCost($dayTotalHACostB,$restaurantBLE,$restaurantCalTypeBLE);

                                        $serviceCost = $serviceCost+($dayTotalHACostBLE*$totalPax); // ServiceCost**********************
                                        $dayTotalHACostBLEMarkup = getMarkupCost($dayTotalHACostBLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dayTotalHACostBLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dayTotalHACostBLETax = getMarkupCost($dayTotalHACostBLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dayTotalHACostBLEAndMarkup = $dayTotalHACostBLE+$dayTotalHACostBLEMarkup;
                                            $dayTotalHACostBLETax = getMarkupCost($dayTotalHACostBLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dayTotalHACostBLETax*$totalPax); // Service Gst**********************
                                    }    

                                }
                                if($hotelQuotData['isForeignEscort']==1 && $paxAdultBFE>0){
                                    $hotelLableB .= ' F.Escort,';
                                    $singleBFE=$doubleBFE=$breakfastABFE=$lunchABFE=$dinnerABFE=0;
                                    if($sglRoomBFE>0){
                                        $singleBFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['singleoccupancy']),$hotelBFE,$hotelCalTypeBFE);
                                        $singleBFE = ($singleBFE);
                                        $serviceCost = $serviceCost+($singleBFE*$sglRoomBFE); // ServiceCost**********************
                                        $singleBFEMarkup = getMarkupCost($singleBFE,$sglMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($singleBFEMarkup*$sglRoomBFE); // Service Markup**********************
                                        if($taxType == 2){
                                            $singleBFETax = getMarkupCost($singleBFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $singleBFEAndMarkup = $singleBFE+$singleBFEMarkup;
                                            $singleBFETax = getMarkupCost($singleBFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($singleBFETax*$sglRoomBFE); // Service Gst**********************
                                    }

                                    if($dblRoomBFE>0){
                                        $doubleBFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['doubleoccupancy']),$hotelBFE,$hotelCalTypeBFE);
                                        $doubleBFE = ($doubleBFE);
                                        $serviceCost = $serviceCost+($doubleBFE*$dblRoomBFE); // ServiceCost**********************
                                        $doubleBFEMarkup = getMarkupCost($doubleBFE,$dblMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($doubleBFEMarkup*$dblRoomBFE); // Service Markup**********************
                                        if($taxType == 2){
                                            $doubleBFETax = getMarkupCost($doubleBFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $doubleBFEAndMarkup = $doubleBFE+$doubleBFEMarkup;
                                            $doubleBFETax = getMarkupCost($doubleBFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($doubleBFETax*$dblRoomBFE); // Service Gst**********************

                                    }

                                    
                                    if($hotelQuotData['complimentaryBreakfast'] == 1 && $hotelQuotData['breakfast']>0){
                                        $breakfastABFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['breakfast']),$restaurantBFE,$restaurantCalTypeBFE); 

                                        $serviceCost = $serviceCost+($breakfastABFE*$totalPax); // ServiceCost**********************
                                        $breakfastABFEMarkup = getMarkupCost($breakfastABFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastABFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastABFETax = getMarkupCost($breakfastABFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastABFEAndMarkup = $breakfastABFE+$breakfastABFEMarkup;
                                            $breakfastABFETax = getMarkupCost($breakfastABFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastABFETax*$totalPax); // Service Gst**********************
                                    }
                     
                                    if($hotelQuotData['complimentaryLunch'] == 1 && $hotelQuotData['lunch']>0){
                                        $lunchABFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['lunch']),$restaurantBFE,$restaurantCalTypeBFE);

                                        $serviceCost = $serviceCost+($lunchABFE*$totalPax); // ServiceCost**********************
                                        $lunchABFEMarkup = getMarkupCost($lunchABFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchABFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchABFETax = getMarkupCost($lunchABFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchABFEAndMarkup = $lunchABFE+$lunchABFEMarkup;
                                            $lunchABFETax = getMarkupCost($lunchABFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchABFETax*$totalPax); // Service Gst**********************
                                    }

                                    if($hotelQuotData['complimentaryDinner'] == 1 && $hotelQuotData['dinner']>0){
                                        $dinnerABFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['dinner']),$restaurantBFE,$restaurantCalTypeBFE);

                                        $serviceCost = $serviceCost+($dinnerABFE*$totalPax); // ServiceCost**********************
                                        $dinnerABFEMarkup = getMarkupCost($dinnerABFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerABFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerABFETax = getMarkupCost($dinnerABFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerABFEAndMarkup = $dinnerABFE+$dinnerABFEMarkup;
                                            $dinnerABFETax = getMarkupCost($dinnerABFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerABFETax*$totalPax); // Service Gst**********************
                                    }

                                    $dB = '';
                                    $dB = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$hotelQuotData['id'].'" and fromDate="' . $serviceDate . '" order by id asc');
                                    while ($qHAdditionalDataB = mysqli_fetch_array($dB)) {
                                        if ($qHAdditionalDataB['costType']==2) {
                                            $additionalCost = convert_to_base($qHAdditionalDataB['currencyValue'],$baseCurrencyVal,$qHAdditionalDataB['additionalCost']);
                                            $perPaxCostB = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                                        } else {
                                            $perPaxCostB = convert_to_base($qHAdditionalDataB['currencyValue'],$baseCurrencyVal,$qHAdditionalDataB['additionalCost']);
                                        }
                                        $dayTotalHACostB = ($dayTotalHACostB + trim($perPaxCostB));
                                    } 
                                    if($dayTotalHACostB>0){
                                        $dayTotalHACostBFE = getMarkupCost($dayTotalHACostB,$restaurantBFE,$restaurantCalTypeBFE);

                                        $serviceCost = $serviceCost+($dayTotalHACostBFE*$totalPax); // ServiceCost**********************
                                        $dayTotalHACostBFEMarkup = getMarkupCost($dayTotalHACostBFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dayTotalHACostBFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dayTotalHACostBFETax = getMarkupCost($dayTotalHACostBFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dayTotalHACostBFEAndMarkup = $dayTotalHACostBFE+$dayTotalHACostBFEMarkup;
                                            $dayTotalHACostBFETax = getMarkupCost($dayTotalHACostBFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dayTotalHACostBFETax*$totalPax); // Service Gst**********************
                                    } 
                 
                                }
                            }else{
                                if($hotelQuotData['isGuestType']==1){
                                    $hotelLableB .= ' Guest,';
                                    
                                    $singleB=$doubleB=$twinB=$tripleB=$quadBedB=$sixBedB=$eightBedB=$tenBedB=$teenBedB=$extraBedAB=$extraBedCB=$breakfastAB=$lunchAB=$dinnerAB=$breakfastCB=$lunchCB=$dinnerCB=0;
                                    if($singleRoom>0){
                                        $singleB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['singleoccupancy']);
                                        $serviceCost = $serviceCost+($singleB*$singleRoom); // ServiceCost**********************
                                        $singleBMarkup = getMarkupCost($singleB,$sglMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($singleBMarkup*$singleRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $singleBTax = getMarkupCost($singleBMarkup,$gstTax,$gstType);
                                        }else{
                                            $singleBAndMarkup = $singleB+$singleBMarkup;
                                            $singleBTax = getMarkupCost($singleBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($singleBTax*$singleRoom); // Service Gst**********************
                                    }

                                    if($doubleRoom>0){
                                        $doubleB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['doubleoccupancy']);
                                        $serviceCost = $serviceCost+($doubleB*$doubleRoom); // ServiceCost**********************
                                        $doubleBMarkup = getMarkupCost($doubleB,$dblMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($doubleBMarkup*$doubleRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $doubleBTax = getMarkupCost($doubleBMarkup,$gstTax,$gstType);
                                        }else{
                                            $doubleBAndMarkup = $doubleB+$doubleBMarkup;
                                            $doubleBTax = getMarkupCost($doubleBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($doubleBTax*$doubleRoom); // Service Gst**********************
                                        // echo $serviceMarkup;
                                    }

                                    if($twinRoom>0){
                                        $twinB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['twinoccupancy']);
                                        $serviceCost = $serviceCost+($twinB*$twinRoom); // ServiceCost**********************
                                        $twinBMarkup = getMarkupCost($twinB,$twinMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($twinBMarkup*$twinRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $twinBTax = getMarkupCost($twinBMarkup,$gstTax,$gstType);
                                        }else{
                                            $twinBAndMarkup = $twinB+$twinBMarkup;
                                            $twinBTax = getMarkupCost($twinBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($twinBTax*$twinRoom); // Service Gst**********************
                                    }

                                    if($tripleRoom>0){
                                        $tripleB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['tripleoccupancy']);
                                        $serviceCost = $serviceCost+($tripleB*$tripleRoom); // ServiceCost**********************
                                        $tripleBMarkup = getMarkupCost($tripleB,$tplMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($tripleBMarkup*$tripleRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $tripleBTax = getMarkupCost($tripleBMarkup,$gstTax,$gstType);
                                        }else{
                                            $tripleBAndMarkup = $tripleB+$tripleBMarkup;
                                            $tripleBTax = getMarkupCost($tripleBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($tripleBTax*$tripleRoom); // Service Gst**********************
                                    }

                                    if($quadBedRoom>0){
                                        $quadBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['quadRoom']);
                                        $serviceCost = $serviceCost+($quadBedB*$quadBedRoom); // ServiceCost**********************
                                        $quadBedBMarkup = getMarkupCost($quadBedB,$quadMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($quadBedBMarkup*$quadBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $quadBedBTax = getMarkupCost($quadBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $quadBedBAndMarkup = $quadBedB+$quadBedBMarkup;
                                            $quadBedBTax = getMarkupCost($quadBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($quadBedBTax*$quadBedRoom); // Service Gst**********************
                                    } 
                                   
                                    if($sixBedRoom>0){
                                        $sixBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['sixBedRoom']);
                                        $serviceCost = $serviceCost+($sixBedB*$sixBedRoom); // ServiceCost**********************
                                        $sixBedBMarkup = getMarkupCost($sixBedB,$sixMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($sixBedBMarkup*$sixBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $sixBedBTax = getMarkupCost($sixBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $sixBedBAndMarkup = $sixBedB+$sixBedBMarkup;
                                            $sixBedBTax = getMarkupCost($sixBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($sixBedBTax*$sixBedRoom); // Service Gst**********************
                                    }

                                    if($eightBedRoom>0){
                                        $eightBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['eightBedRoom']);
                                        $serviceCost = $serviceCost+($eightBedB*$eightBedRoom); // ServiceCost**********************
                                        $eightBedBMarkup = getMarkupCost($eightBedB,$eightMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($eightBedBMarkup*$eightBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $eightBedBTax = getMarkupCost($eightBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $eightBedBAndMarkup = $eightBedB+$eightBedBMarkup;
                                            $eightBedBTax = getMarkupCost($eightBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($eightBedBTax*$eightBedRoom); // Service Gst**********************
                                    }

                                    if($tenBedRoom>0){
                                        $tenBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['tenBedRoom']);
                                        $serviceCost = $serviceCost+($tenBedB*$tenBedRoom); // ServiceCost**********************
                                        $tenBedBMarkup = getMarkupCost($tenBedB,$quadMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($tenBedBMarkup*$tenBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $tenBedBTax = getMarkupCost($tenBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $tenBedBAndMarkup = $tenBedB+$tenBedBMarkup;
                                            $tenBedBTax = getMarkupCost($tenBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($tenBedBTax*$tenBedRoom); // Service Gst**********************
                                    }

                                    if($teenBedRoom>0){
                                        $teenBedB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['teenRoom']);
                                        $serviceCost = $serviceCost+($teenBedB*$teenBedRoom); // ServiceCost**********************
                                        $teenBedBMarkup = getMarkupCost($teenBedB,$quadMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($teenBedBMarkup*$teenBedRoom); // Service Markup**********************
                                        if($taxType == 2){
                                            $teenBedBTax = getMarkupCost($teenBedBMarkup,$gstTax,$gstType);
                                        }else{
                                            $teenBedBAndMarkup = $teenBedB+$teenBedBMarkup;
                                            $teenBedBTax = getMarkupCost($teenBedBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($teenBedBTax*$teenBedRoom); // Service Gst**********************
                                    } 
                                    
                                    if($EBedAdult>0){ 
                                       $extraBedAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['extraBed']);
                                        $serviceCost = $serviceCost+($extraBedAB*$EBedAdult); // ServiceCost**********************
                                        $extraBedABMarkup = getMarkupCost($extraBedAB,$exMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($extraBedABMarkup*$EBedAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $extraBedABTax = getMarkupCost($extraBedABMarkup,$gstTax,$gstType);
                                        }else{
                                            $extraBedABAndMarkup = $extraBedAB+$extraBedABMarkup;
                                            $extraBedABTax = getMarkupCost($extraBedABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($extraBedABTax*$EBedAdult); // Service Gst**********************
                                    } 
                                    
                                    if($EBedChild>0){ 
                                        $extraBedCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childwithbed']);
                                        $serviceCost = $serviceCost+($extraBedCB*$EBedChild); // ServiceCost**********************
                                        $extraBedCBMarkup = getMarkupCost($extraBedCB,$cwbMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($extraBedCBMarkup*$EBedChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $extraBedCBTax = getMarkupCost($extraBedCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $extraBedCBAndMarkup = $extraBedCB+$extraBedCBMarkup;
                                            $extraBedCBTax = getMarkupCost($extraBedCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($extraBedCBTax*$EBedChild); // Service Gst**********************
                                    } 

                                    if($NBedChild>0){ 
                                        $extraNBedCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childwithoutbed']);
                                        $serviceCost = $serviceCost+($extraNBedCB*$NBedChild); // ServiceCost**********************
                                        $extraNBedCBMarkup = getMarkupCost($extraNBedCB,$cnbMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($extraNBedCBMarkup*$NBedChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $extraNBedCBTax = getMarkupCost($extraNBedCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $extraNBedCBAndMarkup = $extraNBedCB+$extraNBedCBMarkup;
                                            $extraNBedCBTax = getMarkupCost($extraNBedCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($extraNBedCBTax*$NBedChild); // Service Gst**********************
                                    } 

                                    if($hotelQuotData['complimentaryBreakfast'] == 1 && $hotelQuotData['breakfast']>0){
                                        $breakfastAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['breakfast']);

                                        $serviceCost = $serviceCost+($breakfastAB*$paxAdult); // ServiceCost**********************
                                        $breakfastABMarkup = getMarkupCost($breakfastAB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastABMarkup*$paxAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastABTax = getMarkupCost($breakfastABMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastABAndMarkup = $breakfastAB+$breakfastABMarkup;
                                            $breakfastABTax = getMarkupCost($breakfastABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastABTax*$paxAdult); // Service Gst**********************
                                    } 

                                    if($hotelQuotData['complimentaryLunch'] == 1 && $hotelQuotData['lunch']>0){
                                        $lunchAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['lunch']);

                                        $serviceCost = $serviceCost+($lunchAB*$paxAdult); // ServiceCost**********************
                                        $lunchABMarkup = getMarkupCost($lunchAB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchABMarkup*$paxAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchABTax = getMarkupCost($lunchABMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchABAndMarkup = $lunchAB+$lunchABMarkup;
                                            $lunchABTax = getMarkupCost($lunchABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchABTax*$paxAdult); // Service Gst**********************
                                    }

                                    if($hotelQuotData['complimentaryDinner'] == 1 && $hotelQuotData['dinner']>0){
                                        $dinnerAB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['dinner']);

                                        $serviceCost = $serviceCost+($dinnerAB*$paxAdult); // ServiceCost**********************
                                        $dinnerABMarkup = getMarkupCost($dinnerAB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerABMarkup*$paxAdult); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerABTax = getMarkupCost($dinnerABMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerABAndMarkup = $dinnerAB+$dinnerABMarkup;
                                            $dinnerABTax = getMarkupCost($dinnerABAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerABTax*$paxAdult); // Service Gst**********************
                                    }

                                    if($hotelQuotData['isChildBreakfast'] == 1 && $hotelQuotData['childBreakfast']>0){
                                        $breakfastCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childBreakfast']);

                                        $serviceCost = $serviceCost+($breakfastCB*$paxChild); // ServiceCost**********************
                                        $breakfastCBMarkup = getMarkupCost($breakfastCB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastCBMarkup*$paxChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastCBTax = getMarkupCost($breakfastCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastCBAndMarkup = $breakfastCB+$breakfastCBMarkup;
                                            $breakfastCBTax = getMarkupCost($breakfastCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastCBTax*$paxChild); // Service Gst**********************
                                    } 

                                    if($hotelQuotData['isChildLunch'] == 1 && $hotelQuotData['childLunch']>0){
                                        $lunchCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childLunch']);

                                        $serviceCost = $serviceCost+($lunchCB*$paxChild); // ServiceCost**********************
                                        $lunchCBMarkup = getMarkupCost($lunchCB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchCBMarkup*$paxChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchCBTax = getMarkupCost($lunchCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchCBAndMarkup = $lunchCB+$lunchCBMarkup;
                                            $lunchCBTax = getMarkupCost($lunchCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchCBTax*$paxChild); // Service Gst**********************
                                    }

                                    if($hotelQuotData['isChildDinner'] == 1 && $hotelQuotData['childDinner']>0){
                                        $dinnerCB = convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['childDinner']);

                                        $serviceCost = $serviceCost+($dinnerCB*$paxChild); // ServiceCost**********************
                                        $dinnerCBMarkup = getMarkupCost($dinnerCB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerCBMarkup*$paxChild); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerCBTax = getMarkupCost($dinnerCBMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerCBAndMarkup = $dinnerCB+$dinnerCBMarkup;
                                            $dinnerCBTax = getMarkupCost($dinnerCBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerCBTax*$paxChild); // Service Gst**********************
                                    }
                                    
                                    $dB = '';
                                    $dB = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$hotelQuotData['id'].'" and fromDate="' . $serviceDate . '" order by id asc');
                                    while ($qHAdditionalDataB = mysqli_fetch_array($dB)) {
                                        if ($qHAdditionalDataB['costType']==2) {
                                            $additionalCost = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal, $qHAdditionalDataB['additionalCost']);
                                            $perPaxCostB = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                                        } else {
                                            $perPaxCostB = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal, $qHAdditionalDataB['additionalCost']);
                                        }
                                        $dayTotalHACostB = ($dayTotalHACostB + trim($perPaxCostB));
                                    } 
                                    if($dayTotalHACostB>0){  
                                        $serviceCost = $serviceCost+($dayTotalHACostB*$totalPax); // ServiceCost**********************
                                        $dayTotalHACostBMarkup = getMarkupCost($dayTotalHACostB,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dayTotalHACostBMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dayTotalHACostBTax = getMarkupCost($dayTotalHACostBMarkup,$gstTax,$gstType);
                                        }else{
                                            $dayTotalHACostBAndMarkup = $dayTotalHACostB+$dayTotalHACostBMarkup;
                                            $dayTotalHACostBTax = getMarkupCost($dayTotalHACostBAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dayTotalHACostBTax*$totalPax); // Service Gst**********************
                                    }
                                }
                                if($hotelQuotData['isLocalEscort']==1 && $paxAdultBLE>0){
                                    $hotelLableB .= ' L.Escort,';

                                    $singleBLE=$doubleBLE=$breakfastABLE=$lunchABLE=$dinnerABLE=0;
                                    if($sglRoomBLE>0){
                                        $singleBLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['singleoccupancy']),$hotelBLE,$hotelCalTypeBLE);
                                        $singleBLE = ($singleBLE);
                                        $serviceCost = $serviceCost+($singleBLE*$sglRoomBLE); // ServiceCost**********************
                                        $singleBLEMarkup = getMarkupCost($singleBLE,$sglMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($singleBLEMarkup*$sglRoomBLE); // Service Markup**********************
                                        if($taxType == 2){
                                            $singleBLETax = getMarkupCost($singleBLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $singleBLEAndMarkup = $singleBLE+$singleBLEMarkup;
                                            $singleBLETax = getMarkupCost($singleBLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($singleBLETax*$sglRoomBLE); // Service Gst**********************
                                    }

                                    if($dblRoomBLE>0){
                                        $doubleBLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['doubleoccupancy']),$hotelBLE,$hotelCalTypeBLE);
                                        $doubleBLE = ($doubleBLE);
                                        $serviceCost = $serviceCost+($doubleBLE*$dblRoomBLE); // ServiceCost**********************
                                        $doubleBLEMarkup = getMarkupCost($doubleBLE,$dblMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($doubleBLEMarkup*$dblRoomBLE); // Service Markup**********************
                                        if($taxType == 2){
                                            $doubleBLETax = getMarkupCost($doubleBLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $doubleBLEAndMarkup = $doubleBLE+$doubleBLEMarkup;
                                            $doubleBLETax = getMarkupCost($doubleBLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($doubleBLETax*$dblRoomBLE); // Service Gst**********************

                                    }

                                    if($hotelQuotData['complimentaryBreakfast'] == 1 && $hotelQuotData['breakfast']>0){
                                        $breakfastABLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['breakfast']),$restaurantBLE,$restaurantCalTypeBLE); 

                                        $serviceCost = $serviceCost+($breakfastABLE*$totalPax); // ServiceCost**********************
                                        $breakfastABLEMarkup = getMarkupCost($breakfastABLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastABLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastABLETax = getMarkupCost($breakfastABLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastABLEAndMarkup = $breakfastABLE+$breakfastABLEMarkup;
                                            $breakfastABLETax = getMarkupCost($breakfastABLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastABLETax*$totalPax); // Service Gst**********************
                                    }
                     
                                    if($hotelQuotData['complimentaryLunch'] == 1 && $hotelQuotData['lunch']>0){
                                        $lunchABLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['lunch']),$restaurantBLE,$restaurantCalTypeBLE);

                                        $serviceCost = $serviceCost+($lunchABLE*$totalPax); // ServiceCost**********************
                                        $lunchABLEMarkup = getMarkupCost($lunchABLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchABLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchABLETax = getMarkupCost($lunchABLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchABLEAndMarkup = $lunchABLE+$lunchABLEMarkup;
                                            $lunchABLETax = getMarkupCost($lunchABLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchABLETax*$totalPax); // Service Gst**********************
                                    }

                                    if($hotelQuotData['complimentaryDinner'] == 1 && $hotelQuotData['dinner']>0){
                                        $dinnerABLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['dinner']),$restaurantBLE,$restaurantCalTypeBLE);

                                        $serviceCost = $serviceCost+($dinnerABLE*$totalPax); // ServiceCost**********************
                                        $dinnerABLEMarkup = getMarkupCost($dinnerABLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerABLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerABLETax = getMarkupCost($dinnerABLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerABLEAndMarkup = $dinnerABLE+$dinnerABLEMarkup;
                                            $dinnerABLETax = getMarkupCost($dinnerABLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerABLETax*$totalPax); // Service Gst**********************
                                    }

                                    $dB = '';
                                    $dB = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$hotelQuotData['id'].'" and fromDate="' . $serviceDate . '" order by id asc');
                                    while ($qHAdditionalDataB = mysqli_fetch_array($dB)) {
                                        if ($qHAdditionalDataB['costType']==2) {
                                            $additionalCost = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal,$qHAdditionalDataB['additionalCost']);
                                            $perPaxCostB = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                                        } else {
                                            $perPaxCostB = convert_to_base($qHAdditionalDataB['currencyValue'], $baseCurrencyVal,$qHAdditionalDataB['additionalCost']);
                                        }
                                        $dayTotalHACostB = ($dayTotalHACostB + trim($perPaxCostB));
                                    } 
                                    if($dayTotalHACostB>0){
                                        $dayTotalHACostBLE = getMarkupCost($dayTotalHACostB,$restaurantBLE,$restaurantCalTypeBLE);

                                        $serviceCost = $serviceCost+($dayTotalHACostBLE*$totalPax); // ServiceCost**********************
                                        $dayTotalHACostBLEMarkup = getMarkupCost($dayTotalHACostBLE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dayTotalHACostBLEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dayTotalHACostBLETax = getMarkupCost($dayTotalHACostBLEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dayTotalHACostBLEAndMarkup = $dayTotalHACostBLE+$dayTotalHACostBLEMarkup;
                                            $dayTotalHACostBLETax = getMarkupCost($dayTotalHACostBLEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dayTotalHACostBLETax*$totalPax); // Service Gst**********************
                                    }  
                                }
                                if($hotelQuotData['isForeignEscort']==1 && $paxAdultBFE>0){
                                    $hotelLableB .= ' F.Escort,';
                                    $singleBFE=$doubleBFE=$breakfastABFE=$lunchABFE=$dinnerABFE=0;
                                    if($sglRoomBFE>0){
                                        $singleBFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['singleoccupancy']),$hotelBFE,$hotelCalTypeBFE);
                                        $singleBFE = ($singleBFE);
                                        $serviceCost = $serviceCost+($singleBFE*$sglRoomBFE); // ServiceCost**********************
                                        $singleBFEMarkup = getMarkupCost($singleBFE,$sglMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($singleBFEMarkup*$sglRoomBFE); // Service Markup**********************
                                        if($taxType == 2){
                                            $singleBFETax = getMarkupCost($singleBFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $singleBFEAndMarkup = $singleBFE+$singleBFEMarkup;
                                            $singleBFETax = getMarkupCost($singleBFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($singleBFETax*$sglRoomBFE); // Service Gst**********************
                                    }

                                    if($dblRoomBFE>0){
                                        $doubleBFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['doubleoccupancy']),$hotelBFE,$hotelCalTypeBFE);
                                        $doubleBFE = ($doubleBFE);
                                        $serviceCost = $serviceCost+($doubleBFE*$dblRoomBFE); // ServiceCost**********************
                                        $doubleBFEMarkup = getMarkupCost($doubleBFE,$dblMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($doubleBFEMarkup*$dblRoomBFE); // Service Markup**********************
                                        if($taxType == 2){
                                            $doubleBFETax = getMarkupCost($doubleBFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $doubleBFEAndMarkup = $doubleBFE+$doubleBFEMarkup;
                                            $doubleBFETax = getMarkupCost($doubleBFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($doubleBFETax*$dblRoomBFE); // Service Gst**********************

                                    }

                                    if($hotelQuotData['complimentaryBreakfast'] == 1 && $hotelQuotData['breakfast']>0){
                                        $breakfastABFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['breakfast']),$restaurantBFE,$restaurantCalTypeBFE); 

                                        $serviceCost = $serviceCost+($breakfastABFE*$totalPax); // ServiceCost**********************
                                        $breakfastABFEMarkup = getMarkupCost($breakfastABFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($breakfastABFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $breakfastABFETax = getMarkupCost($breakfastABFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $breakfastABFEAndMarkup = $breakfastABFE+$breakfastABFEMarkup;
                                            $breakfastABFETax = getMarkupCost($breakfastABFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($breakfastABFETax*$totalPax); // Service Gst**********************
                                    }
                     
                                    if($hotelQuotData['complimentaryLunch'] == 1 && $hotelQuotData['lunch']>0){
                                        $lunchABFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['lunch']),$restaurantBFE,$restaurantCalTypeBFE);

                                        $serviceCost = $serviceCost+($lunchABFE*$totalPax); // ServiceCost**********************
                                        $lunchABFEMarkup = getMarkupCost($lunchABFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($lunchABFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $lunchABFETax = getMarkupCost($lunchABFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $lunchABFEAndMarkup = $lunchABFE+$lunchABFEMarkup;
                                            $lunchABFETax = getMarkupCost($lunchABFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($lunchABFETax*$totalPax); // Service Gst**********************
                                    }

                                    if($hotelQuotData['complimentaryDinner'] == 1 && $hotelQuotData['dinner']>0){
                                        $dinnerABFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$hotelQuotData['dinner']),$restaurantBFE,$restaurantCalTypeBFE);

                                        $serviceCost = $serviceCost+($dinnerABFE*$totalPax); // ServiceCost**********************
                                        $dinnerABFEMarkup = getMarkupCost($dinnerABFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dinnerABFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dinnerABFETax = getMarkupCost($dinnerABFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dinnerABFEAndMarkup = $dinnerABFE+$dinnerABFEMarkup;
                                            $dinnerABFETax = getMarkupCost($dinnerABFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dinnerABFETax*$totalPax); // Service Gst**********************
                                    }
                                    $dB = '';
                                    $dB = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$hotelQuotData['id'].'" and fromDate="' . $serviceDate . '" order by id asc');
                                    while ($qHAdditionalDataB = mysqli_fetch_array($dB)) {
                                        if ($qHAdditionalDataB['costType']==2) {
                                            // $currencyValue,$baseCurrencyVal,
                                            $additionalCost = convert_to_base($qHAdditionalDataB['currencyId'],$qHAdditionalDataB['currencyValue'], $qHAdditionalDataB['additionalCost']);
                                            $perPaxCostB = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                                        } else {
                                            $perPaxCostB = convert_to_base($qHAdditionalDataB['currencyId'],$qHAdditionalDataB['currencyValue'], $qHAdditionalDataB['additionalCost']);
                                        }
                                        $dayTotalHACostB = ($dayTotalHACostB + trim($perPaxCostB));
                                    } 
                                    if($dayTotalHACostB>0){
                                        $dayTotalHACostBFE = getMarkupCost($dayTotalHACostB,$restaurantBFE,$restaurantCalTypeBFE);

                                        $serviceCost = $serviceCost+($dayTotalHACostBFE*$totalPax); // ServiceCost**********************
                                        $dayTotalHACostBFEMarkup = getMarkupCost($dayTotalHACostBFE,$mealMarkup,$markupType);
                                        $serviceMarkup = $serviceMarkup+($dayTotalHACostBFEMarkup*$totalPax); // Service Markup**********************
                                        if($taxType == 2){
                                            $dayTotalHACostBFETax = getMarkupCost($dayTotalHACostBFEMarkup,$gstTax,$gstType);
                                        }else{
                                            $dayTotalHACostBFEAndMarkup = $dayTotalHACostBFE+$dayTotalHACostBFEMarkup;
                                            $dayTotalHACostBFETax = getMarkupCost($dayTotalHACostBFEAndMarkup,$gstTax,$gstType);
                                        }
                                        $serviceGst = $serviceGst+($dayTotalHACostBFETax*$totalPax); // Service Gst**********************
                                    }  
                                }
                            }
                            // for last column for this row
                            $totalServiceCost =  trim($serviceCost+$serviceMarkup+$serviceGst);
                            
                            // for last final row
                            $grandServiceCost = $grandServiceCost+$serviceCost;
                            $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                            $grandServiceGst = $grandServiceGst+$serviceGst;
                            // end final row var
                            $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost);
                            ?>
                            <tr id="selectedcon<?php echo $uniq_Id; ?>">
                              <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($hotelQuotData['fromDate']));?></div></td>
                              <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                              <td><?php echo rtrim($hotelLableB,',').' | '.ucfirst($hotelData['hotelName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($hotelQuotData['destinationId']);  ?>&nbsp;)</td>
                              <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                              <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                              <td align="right"><?php //if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;<?php echo getTwoDecimalNumberFormat($serviceMarkup); ?></td>
                              <td align="right">
                                <?php  echo trim($gstTax).'%&nbsp;';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                              <?php } ?>
                              <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                            </tr>
                            <?php
                        }
                      }
                    }
                    if($serviceType=='transfer' || $serviceType=='transportation'){
                      
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'" and totalPax = "' . $groupSlabBD['id'] . '"');
                      while($transferQuotData=mysqli_fetch_array($c)){
                        // hotel data
                        $d='';
                        $d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$transferQuotData['transferNameId'].'"');
                        $transferData=mysqli_fetch_array($d);
                        
                        $vehicleCost=$serviceCostWGSTMP=$serviceCost=$serviceGst=$serviceMarkup=0;

                        $markupCost = $gstTax = 0;
                        // if domestic service wise markup
                        if($isSer_Mark == 1 && $isUni_Mark == 0){
                            $markupCost = $transferQuotData['markupCost'];
                            $gstTax = getGstValueById($transferQuotData['gstTax']);
                        }
                        $markupType = $transferQuotData['markupType'];
                        $currencyValue = $transferQuotData['currencyValue'];
                        $gstType = 1;
                        $taxType = $transferQuotData['taxType'];

                        if($transferQuotData['transferType'] == 1){
                            $vehicleCost = ($transferQuotData['adultCost']*$paxAdult)+($transferQuotData['childCost']*$paxChild)+($transferQuotData['infantCost']*$paxInfant);
                        }else{
                            if($transferQuotData['costType'] == 3){ 
                                $vehicleCost = ($transferQuotData['vehicleCost'] * $transferQuotData['noOfVehicles'] * $transferQuotData['distance']);
                            }else{ 
                                 $vehicleCost = ($transferQuotData['vehicleCost'] * $transferQuotData['noOfVehicles']);
                            } 

                        }

                        $vehicleCost = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($vehicleCost,$transferQuotData['gstTax'],$transferQuotData['markupCost'],$transferQuotData['markupType']));
                        // total markup
                        $vehicleCostMarkup = getMarkupCost($vehicleCost,$markupCost,$markupType);

                        if($markupType==1){
                            $serviceMarkup = $vehicleCostMarkup;
                        }else{
                            if($transferQuotData['transferType'] == 1){
                                $vehicleCostMarkup = $vehicleCostMarkup*$totalDFACI;
                            }else{
                                $vehicleCostMarkup = $vehicleCostMarkup*$transferQuotData['noOfVehicles'];
                            }
                            
                            $serviceMarkup = $vehicleCostMarkup;
                        }

                        //$serviceMarkup = $serviceMarkup+($vehicleCostMarkup*$totalpaxDF); // Service Markup**********************
                        
                        // tax on total
                        if($taxType == 2){
                            $vehicleCostTax = getMarkupCost($serviceMarkup,$gstTax,$gstType);
                        }else{
                            $vehicleCostAndMarkup = $vehicleCost+$serviceMarkup;
                            $vehicleCostTax = getMarkupCost($vehicleCostAndMarkup,$gstTax,$gstType);
                        }
                        $serviceGst = ($serviceGst+$vehicleCostTax); // Service Gst**********************
                        
                        // per person cost 
                        $vehicleCostPPWGSTMP = (($vehicleCost+$serviceMarkup+$vehicleCostTax)/$totalDFB); 
                        $vehicleCostPP = ($vehicleCost/$totalDFB); 
                        
                        // cost for guest
                        if($totalPax>0){
                            $serviceCostWGSTMP = $serviceCostWGSTMP+($vehicleCostPPWGSTMP*$totalDFB); // ServiceCost**********************
                            $serviceCost = $serviceCost+($vehicleCostPP*$totalDFB); // ServiceCost**********************
                        }
                        
                        // cost for le
                        if($paxAdultBLE>0){
                            $vehicleCostPPWGSTMPLE = getMarkupCost($vehicleCostPPWGSTMP,$transferBLE,$transferCalTypeBLE);
                            $serviceCostWGSTMP = $serviceCostWGSTMP+($vehicleCostPPWGSTMPLE*$paxAdultBLE); // ServiceCost**********************

                            $vehicleCostPPLE = getMarkupCost($vehicleCostPP,$transferBLE,$transferCalTypeBLE);
                            $serviceCost = $serviceCost+($vehicleCostPPLE*$paxAdultBLE); // ServiceCost**********************
                        }
                        
                        // cost for FE
                        if($paxAdultBFE>0){
                            $vehicleCostPPWGSTMPFE = getMarkupCost($vehicleCostPPWGSTMP,$transferBFE,$transferCalTypeBFE);
                            $serviceCostWGSTMP = $serviceCostWGSTMP+($vehicleCostPPWGSTMPFE*$paxAdultBFE); // ServiceCost**********************

                            $vehicleCostPPFE = getMarkupCost($vehicleCostPP,$transferBFE,$transferCalTypeBFE);
                            $serviceCost = $serviceCost+($vehicleCostPPFE*$paxAdultBFE); // ServiceCost**********************
                        }
                        // echo $serviceCost;
                        // for last column for this row
                        // for last final row
                        $grandServiceCost = $grandServiceCost+$serviceCost;
                        $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                        $grandServiceGst = $grandServiceGst+$serviceGst;
                        // end final row var
                        $grandTotalServiceCost = trim($grandTotalServiceCost+$serviceCostWGSTMP);

                        ?>
                        <tr id="selectedcon<?php echo $uniq_Id; ?>">
                          <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($transferQuotData['fromDate']));?></div></td>
                          <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                          <td><?php echo ucfirst($transferData['transferName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($transferQuotData['destinationId']);  ?>&nbsp;)</td>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                          <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                          <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkup); ?></td>
                          <td align="right">
                            <?php  echo trim($gstTax).'% ';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                          <?php } ?>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCostWGSTMP); ?></td>
                        </tr>
                        <?php
                      }
                    } 

                    if($serviceType=='entrance'){
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
                      while($entranceQuotData=mysqli_fetch_array($c)){
                        // hotel data
                        $d='';
                        $d=GetPageRecord('*','packageBuilderEntranceMaster',' id="'.$entranceQuotData['entranceNameId'].'"');
                        $entranceData=mysqli_fetch_array($d);
                        
                        $entranceCost=$entCostAB=$entCostCB=$entCostEB=$serviceMarkupEnt=$serviceGst=0;
                        $adultPaxE = $entranceQuotData['adultPax'];
                        $childPaxE = $entranceQuotData['childPax'];
                        $infantPaxE = $entranceQuotData['infantPax'];
                        $totalPaxE = $adultPaxE+$childPaxE;

                        $markupCost = $gstTax = $serviceCost=0;
                        // if domestic service wise markup
                        if($isSer_Mark == 1 && $isUni_Mark == 0){
                            $markupCost = $entranceQuotData['markupCost'];
                            $gstTax = getGstValueById($entranceQuotData['gstTax']);
                        }
                        if($entranceQuotData['transferType']!=2){
                            $markupTypeEnt = $entranceQuotData['markupType'];
                            $markupCostEnt = $entranceQuotData['markupCost'];
                        }
                      
                        $currencyValue = $entranceQuotData['currencyValue'];
                        $gstType = 1;
                        $taxType = $entranceQuotData['taxType'];

                        if($totalPaxE>0){
                            if($entranceQuotData['transferType'] == 1){
                                $entCostAB = convert_to_base($currencyValue,$baseCurrencyVal,trim($entranceQuotData['ticketAdultCost']+$entranceQuotData['adultCost']+$entranceQuotData['repCost']));            
                            }else{
                                $entMarkupCostAA = convert_to_base($currencyValue,$baseCurrencyVal,trim(($entranceQuotData['vehicleCost']*$entranceQuotData['noOfVehicles'])));

                                $entMarkupCostA = getMarkupCost($entMarkupCostAA,$entranceQuotData['markupCost'],$entranceQuotData['markupType']);
                                $entVehicleCostA = $entMarkupCostAA+$entMarkupCostA;
                                $entCostAB = convert_to_base($currencyValue,$baseCurrencyVal,trim($entranceQuotData['ticketAdultCost']))+($entVehicleCostA/$totalPaxE)+$entranceQuotData['repCost'];
                            }
                            $entCostAB = getCostWithGSTID_Markup($entCostAB,$entranceQuotData['gstTax'],$markupCostEnt,$markupTypeEnt);
                        }

                        if($paxChild>0){
                            if($entranceQuotData['transferType'] == 1){
                                $entCostCB = convert_to_base($currencyValue,$baseCurrencyVal,trim($entranceQuotData['ticketchildCost']+$entranceQuotData['childCost']+$entranceQuotData['repCost']));            
                            }else{

                                $entMarkupCostCC = convert_to_base($currencyValue,$baseCurrencyVal,trim(($entranceQuotData['vehicleCost']*$entranceQuotData['noOfVehicles'])));

                                $entMarkupCostC = getMarkupCost($entMarkupCostCC,$entranceQuotData['markupCost'],$entranceQuotData['markupType']);
                                $entVehicleCostC = $entMarkupCostCC+$entMarkupCostC;

                               $entCostCB = convert_to_base($currencyValue,$baseCurrencyVal,trim($entranceQuotData['ticketchildCost']))+($entVehicleCostC/$totalPaxE)+$entranceQuotData['repCost'];
                            }
                            $entCostCB = getCostWithGSTID_Markup($entCostCB,$entranceQuotData['gstTax'],$markupCostEnt,$markupTypeEnt);
                        }
                        if($paxInfant>0){
                            if($entranceQuotData['transferType'] == 1){
                                $entCostEB = convert_to_base($currencyValue,$baseCurrencyVal,trim($entranceQuotData['ticketinfantCost']+$entranceQuotData['infantCost']+$entranceQuotData['repCost']));            
                            }else{
                                $entCostEB = convert_to_base($currencyValue,$baseCurrencyVal,trim(($entranceQuotData['ticketinfantCost']+($entVehicleCostE*$entranceQuotData['noOfVehicles'])/$totalPaxE)+$entranceQuotData['repCost']));
                            }

                            $entCostEB = getCostWithGSTID_Markup($entCostEB,$entranceQuotData['gstTax'],$markupCostEnt,$markupTypeEnt);
                        }

                        if($entCostAB>0){
                            $entranceCostA = ($entCostAB);
                            $serviceCost = $serviceCost+($entranceCostA*$adultPaxE); // ServiceCost**********************
                            $entranceCostAMarkup = getMarkupCost($entranceCostA,$markupCost,$markupType);
                            $serviceMarkupEnt = $serviceMarkupEnt+($entranceCostAMarkup*$adultPaxE); // Service Markup**********************
                            if($taxType == 2){
                                $entranceCostATax = getMarkupCost($entranceCostAMarkup,$gstTax,$gstType);
                            }else{
                                $entranceCostAAndMarkup = $entranceCostA+$entranceCostAMarkup;
                                $entranceCostATax = getMarkupCost($entranceCostAAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($entranceCostATax*$adultPaxE); // Service Gst**********************
                        }
                        if($entCostCB>0 ){
                            $entranceCostC = ($entCostCB);
                            $serviceCost = $serviceCost+($entranceCostC*$childPaxE); // ServiceCost**********************
                            $entranceCostCMarkup = getMarkupCost($entranceCostC,$markupCost,$markupType);
                            $serviceMarkupEnt = $serviceMarkupEnt+($entranceCostCMarkup*$childPaxE); // Service Markup**********************
                            if($taxType == 2){
                                $entranceCostCTax = getMarkupCost($entranceCostCMarkup,$gstTax,$gstType);
                            }else{
                                $entranceCostCAndMarkup = $entranceCostC+$entranceCostCMarkup;
                                $entranceCostCTax = getMarkupCost($entranceCostCAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($entranceCostCTax*$childPaxE); // Service Gst**********************
                        } 
                        if($entCostEB>0 ){
                            $entranceCostE = ($entCostEB);
                            $serviceCost = $serviceCost+($entranceCostE*$infantPaxE); // ServiceCost**********************
                            $entranceCostEMarkup = getMarkupCost($entranceCostE,$markupCost,$markupType);
                            $serviceMarkupEnt = $serviceMarkupEnt+($entranceCostEMarkup*$infantPaxE); // Service Markup**********************
                            if($taxType == 2){
                                $entranceCostETax = getMarkupCost($entranceCostEMarkup,$gstTax,$gstType);
                            }else{
                                $entranceCostEAndMarkup = $entranceCostE+$entranceCostEMarkup;
                                $entranceCostETax = getMarkupCost($entranceCostEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($entranceCostETax*$infantPaxE); // Service Gst**********************
                        }
                        if($paxAdultBLE>0){ 
                            $entranceCostALE = getMarkupCost($entCostAB,$entranceBLE,$entranceCalTypeBLE);
                            $entranceCostALE = $entranceCostALE;
                            $serviceCost = $serviceCost+($entranceCostALE*$paxAdultBLE); // ServiceCost**********************
                            $entranceCostALEMarkup = getMarkupCost($entranceCostALE,$markupCost,$markupType);
                            $serviceMarkupEnt = $serviceMarkupEnt+($entranceCostALEMarkup*$paxAdultBLE); // Service Markup**********************
                            if($taxType == 2){
                                $entranceCostALETax = getMarkupCost($entranceCostALEMarkup,$gstTax,$gstType);
                            }else{
                                $entranceCostALEAndMarkup = $entranceCostALE+$entranceCostALEMarkup;
                                $entranceCostALETax = getMarkupCost($entranceCostALEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($entranceCostALETax*$paxAdultBLE); // Service Gst**********************
                        }

                        if($paxAdultBFE>0){
                            $entranceCostAFE = getMarkupCost($entCostAB,$entranceBFE,$entranceCalTypeBFE);
                            $entranceCostAFE = $entranceCostAFE;
                            $serviceCost = $serviceCost+($entranceCostAFE*$paxAdultBFE); // ServiceCost**********************
                            $entranceCostAFEMarkup = getMarkupCost($entranceCostAFE,$markupCost,$markupType);
                            $serviceMarkupEnt = $serviceMarkupEnt+($entranceCostAFEMarkup*$paxAdultBFE); // Service Markup**********************
                            if($taxType == 2){
                                $entranceCostAFETax = getMarkupCost($entranceCostAFEMarkup,$gstTax,$gstType);
                            }else{
                                $entranceCostAFEAndMarkup = $entranceCostAFE+$entranceCostAFEMarkup;
                                $entranceCostAFETax = getMarkupCost($entranceCostAFEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($entranceCostAFETax*$paxAdultBFE); // Service Gst**********************
                        }

                        // for last column for this row
                        $totalServiceCost =  trim($serviceCost+$serviceMarkupEnt+$serviceGst);
                        
                        // for last final row
                        $grandServiceCost = $grandServiceCost+$serviceCost;
                        $grandServiceMarkup = $grandServiceMarkup+$serviceMarkupEnt;
                        $grandServiceGst = $grandServiceGst+$serviceGst;
                        // end final row var
                        $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost);

                        ?>
                        <tr id="selectedcon<?php echo $uniq_Id; ?>">
                          <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($entranceQuotData['fromDate']));?></div></td>
                          <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                          <td><?php echo ucfirst($entranceData['entranceName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($entranceQuotData['destinationId']);  ?>&nbsp;)</td>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                          <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                          <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkupEnt); ?></td>
                          <td align="right">
                            <?php  echo trim($gstTax).'% ';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                          <?php } ?>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                        </tr>
                        <?php
                      }
                    }

                    if($serviceType=='ferry'){
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
                      while($ferryQuotData=mysqli_fetch_array($c)){
                        // hotel data
                        $d='';
                        $d=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$ferryQuotData['ferryNameId'].'"');
                        $ferryData=mysqli_fetch_array($d);
                        
                        $ferryCost=$serviceCost=$serviceMarkup=$serviceGst=0;

                        $markupCost = $gstTax = 0;
                        // if domestic service wise markup
                        if($isSer_Mark == 1 && $isUni_Mark == 0){
                            $markupCost = $ferryQuotData['markupCost'];
                            $gstTax = getGstValueById($ferryQuotData['gstTax']);
                        }

                        $markupType = $ferryQuotData['markupType'];
                        $currencyValue = $ferryQuotData['currencyValue'];
                        $gstType = 1;
                        $taxType = $ferryQuotData['taxType'];

                        if($ferryQuotData['adultCost']>0){ 
                            $ferryCostAA = convert_to_base($currencyValue,$baseCurrencyVal,trim($ferryQuotData['adultCost']+$ferryQuotData['miscCost']));
                            $ferryCostA = getCostWithGSTID_Markup($ferryCostAA,$ferryQuotData['gstTax'],$ferryQuotData['markupCost'],$ferryQuotData['markupType']);
                            $serviceCost = $serviceCost+($ferryCostA*$paxAdult); // ServiceCost**********************
                            $ferryCostAMarkup = getMarkupCost($ferryCostA,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($ferryCostAMarkup*$paxAdult); // Service Markup**********************
                            if($taxType == 2){
                                $ferryCostATax = getMarkupCost($ferryCostAMarkup,$gstTax,$gstType);
                            }else{
                                $ferryCostAAndMarkup = $ferryCostA+$ferryCostAMarkup;
                                $ferryCostATax = getMarkupCost($ferryCostAAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($ferryCostATax*$paxAdult); // Service Gst**********************
                        }
                        if($ferryQuotData['childCost']>0 ){ 
                            $ferryCostCC = convert_to_base($currencyValue,$baseCurrencyVal,trim($ferryQuotData['childCost']+$ferryQuotData['processingfee']+$ferryQuotData['miscCost']));
                            $ferryCostC = getCostWithGSTID_Markup($ferryCostCC,$ferryQuotData['gstTax'],$ferryQuotData['markupCost'],$ferryQuotData['markupType']);
                            $serviceCost = $serviceCost+($ferryCostC*$paxChild); // ServiceCost**********************
                            $ferryCostCMarkup = getMarkupCost($ferryCostC,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($ferryCostCMarkup*$paxChild); // Service Markup**********************
                            if($taxType == 2){
                                $ferryCostCTax = getMarkupCost($ferryCostCMarkup,$gstTax,$gstType);
                            }else{
                                $ferryCostCAndMarkup = $ferryCostC+$ferryCostCMarkup;
                                $ferryCostCTax = getMarkupCost($ferryCostCAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($ferryCostCTax*$paxChild); // Service Gst**********************
                        }
                        if($ferryQuotData['infantCost']>0 ){ 
                            $ferryCostEE = convert_to_base($currencyValue,$baseCurrencyVal,trim($ferryQuotData['infantCost']+$ferryQuotData['processingfee']+$ferryQuotData['miscCost']));
                            $ferryCostE = getCostWithGSTID_Markup($ferryCostEE,$ferryQuotData['gstTax'],$ferryQuotData['markupCost'],$ferryQuotData['markupType']);
                            $serviceCost = $serviceCost+($ferryCostE*$paxInfant); // ServiceCost**********************
                            $ferryCostEMarkup = getMarkupCost($ferryCostE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($ferryCostEMarkup*$paxInfant); // Service Markup**********************
                            if($taxType == 2){
                                $ferryCostETax = getMarkupCost($ferryCostEMarkup,$gstTax,$gstType);
                            }else{
                                $ferryCostEAndMarkup = $ferryCostE+$ferryCostEMarkup;
                                $ferryCostETax = getMarkupCost($ferryCostEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($ferryCostETax*$paxInfant); // Service Gst**********************
                        }
                        if($paxAdultBLE>0){
                            $ferryCostLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,trim($ferryQuotData['adultCost']+$ferryQuotData['processingfee']+$ferryQuotData['miscCost'])),$ferryBLE,$ferryCalTypeBLE); 
                            $serviceCost = $serviceCost+($ferryCostLE*$paxAdultBLE); // ServiceCost**********************
                            $ferryCostLEMarkup = getMarkupCost($ferryCostLE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($ferryCostLEMarkup*$paxAdultBLE); // Service Markup**********************
                            if($taxType == 2){
                                $ferryCostLETax = getMarkupCost($ferryCostLEMarkup,$gstTax,$gstType);
                            }else{
                                $ferryCostLEAndMarkup = $ferryCostLE+$ferryCostLEMarkup;
                                $ferryCostLETax = getMarkupCost($ferryCostLEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($ferryCostLETax*$paxAdultBLE); // Service Gst**********************
                        }

                        if($paxAdultBFE>0){
                            $ferryCostFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,trim($ferryQuotData['adultCost']+$ferryQuotData['processingfee']+$ferryQuotData['miscCost'])),$ferryBFE,$ferryCalTypeBFE);
                            $serviceCost = $serviceCost+($ferryCostFE*$paxAdultBFE); // ServiceCost**********************
                            $ferryCostFEMarkup = getMarkupCost($ferryCostFE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($ferryCostFEMarkup*$paxAdultBFE); // Service Markup**********************
                            if($taxType == 2){
                                $ferryCostFETax = getMarkupCost($ferryCostFEMarkup,$gstTax,$gstType);
                            }else{
                                $ferryCostFEAndMarkup = $ferryCostFE+$ferryCostFEMarkup;
                                $ferryCostFETax = getMarkupCost($ferryCostFEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($ferryCostFETax*$paxAdultBFE); // Service Gst**********************
                        }

                        // for last column for this row
                        $totalServiceCost =  trim($serviceCost+$serviceMarkup+$serviceGst);
                        
                        // for last final row
                        $grandServiceCost = $grandServiceCost+$serviceCost;
                        $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                        $grandServiceGst = $grandServiceGst+$serviceGst;
                        // end final row var
                        $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost);

                        ?>
                        <tr id="selectedcon<?php echo $uniq_Id; ?>">
                          <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($ferryQuotData['fromDate']));?></div></td>
                          <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                          <td><?php echo ucfirst($ferryData['name']);?>&nbsp;(&nbsp;<?php echo $hcity=getDestination($ferryQuotData['destinationId']);?>&nbsp;)</td>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                          <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                          <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkup); ?></td>
                          <td align="right">
                            <?php  echo trim($gstTax).'% ';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                          <?php } ?>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                        </tr>
                        <?php
                      }
                    }

                    // Activity block below
                    if($serviceType=='activity'){
                        $e='';
                       
                        $e=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
                        while($activityQuotData=mysqli_fetch_array($e)){
                          // hotel data
                          $d='';
                          $d=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.$activityQuotData['otherActivityName'].'"');
                          $activityData=mysqli_fetch_array($d);
                          
                          $adultPaxA = $activityQuotData['adultPax'];
                          $childPaxA = $activityQuotData['childPax'];
                          $infantPaxA = $activityQuotData['infantPax'];
                          $totalPaxA = $adultPaxA+$childPaxA;

                          $activityCost=$actCostAB=$actCostCB=$actCostEB=$serviceCost=$serviceGst=0;
                          $serviceMarkupAct=0;
  
                          $markupCost = $gstTax = 0;
                          // if domestic service wise markup
                          if($isSer_Mark == 1 && $isUni_Mark == 0){
                              $markupCost = $activityQuotData['markupCost'];
                              $gstTax = getGstValueById($activityQuotData['gstTax']);
                          }
                          if($activityQuotData['transferType']!=2){
                            $markupTypeEnt = $activityQuotData['markupType'];
                            $markupCostEnt = $activityQuotData['markupCost'];
                          }
                          
                          $currencyValue = $activityQuotData['currencyValue'];
                          $gstType = 1;
                          $taxType = $activityQuotData['taxType'];
                       
                          if($adultPaxA>0){
                              if($activityQuotData['transferType'] == 1){
                                  $actCostAB = convert_to_base($currencyValue,$baseCurrencyVal,trim($activityQuotData['ticketAdultCost']+$activityQuotData['adultCost']+$activityQuotData['repCost']));            
                              }else{
                                $actCostAA = convert_to_base($currencyValue,$baseCurrencyVal,($activityQuotData['vehicleCost']*$activityQuotData['noOfVehicles']));
                                   $actMarkupCostA = getMarkupCost($actCostAA,$activityQuotData['markupCost'],$activityQuotData['markupType']);
                                   $actVehiclecost = $actCostAA+$actMarkupCostA;
                                  $actCostAB = convert_to_base($currencyValue,$baseCurrencyVal,trim($activityQuotData['ticketAdultCost']))+($actVehiclecost/$totalPaxA)+$activityQuotData['repCost'];
                              }
                              $actCostAB = getCostWithGSTID_Markup($actCostAB,$activityQuotData['gstTax'],$markupCostEnt,$markupTypeEnt);
                          }

                       

                          if($childPaxA>0){
                              if($activityQuotData['transferType'] == 1){
                                  $actCostCB = convert_to_base($currencyValue,$baseCurrencyVal,trim($activityQuotData['ticketchildCost']+$activityQuotData['childCost']+$activityQuotData['repCost']));            
                              }else{

                                $actCostCC = convert_to_base($currencyValue,$baseCurrencyVal,($activityQuotData['vehicleCost']*$activityQuotData['noOfVehicles']));
                                $actMarkupCostC = getMarkupCost($actCostCC,$activityQuotData['markupCost'],$activityQuotData['markupType']);
                                $actVehiclecostC = $actCostCC+$actMarkupCostC;


                                  $actCostCB = convert_to_base($currencyValue,$baseCurrencyVal,trim($activityQuotData['ticketchildCost']))+($actVehiclecostC/$totalPaxA)+$activityQuotData['repCost'];
                              }
                            $actCostCB = getCostWithGSTID_Markup($actCostCB,$activityQuotData['gstTax'],$markupCostEnt,$markupTypeEnt);
                          }
                          if($infantPaxA>0){
                              if($activityQuotData['transferType'] == 1){
                                  $actCostEB = convert_to_base($currencyValue,$baseCurrencyVal,trim($activityQuotData['ticketinfantCost']+$activityQuotData['infantCost']+$activityQuotData['repCost']));            
                              }else{
                                  $actCostEB = convert_to_base($currencyValue,$baseCurrencyVal,trim(($activityQuotData['ticketinfantCost']+($actVehiclecostE*$activityQuotData['noOfVehicles'])/$totalPaxA)+$activityQuotData['repCost']));
                              }

                              $actCostEB = getCostWithGSTID_Markup($actCostEB,$activityQuotData['gstTax'],$markupCostEnt,$markupTypeEnt);
                          }
  
                          if($actCostAB>0){
                              $activityCostA = ($actCostAB);
                              $serviceCost = $serviceCost+($activityCostA*$adultPaxA); // ServiceCost**********************
                              $activityCostAMarkup = getMarkupCost($activityCostA,$markupCost,$markupType);
                              $serviceMarkupAct = $serviceMarkupAct+($activityCostAMarkup*$adultPaxA); // Service Markup**********************
                              if($taxType == 2){
                                  $activityCostATax = getMarkupCost($activityCostAMarkup,$gstTax,$gstType);
                              }else{
                                  $activityCostAAndMarkup = $activityCostA+$activityCostAMarkup;
                                  $activityCostATax = getMarkupCost($activityCostAAndMarkup,$gstTax,$gstType);
                              }
                              $serviceGst = $serviceGst+($activityCostATax*$adultPaxA); // Service Gst**********************
                          }
                          if($actCostCB>0 ){
                              $activityCostC = ($actCostCB);
                              $serviceCost = $serviceCost+($activityCostC*$childPaxA); // ServiceCost**********************
                              $activityCostCMarkup = getMarkupCost($activityCostC,$markupCost,$markupType);
                              $serviceMarkupAct = $serviceMarkupAct+($activityCostCMarkup*$childPaxA); // Service Markup**********************
                              if($taxType == 2){
                                  $activityCostCTax = getMarkupCost($activityCostCMarkup,$gstTax,$gstType);
                              }else{
                                  $activityCostCAndMarkup = $activityCostC+$activityCostCMarkup;
                                  $activityCostCTax = getMarkupCost($activityCostCAndMarkup,$gstTax,$gstType);
                              }
                              $serviceGst = $serviceGst+($activityCostCTax*$childPaxA); // Service Gst**********************
                          } 
                          if($actCostEB>0 ){
                              $activityCostE = ($actCostEB);
                              $serviceCost = $serviceCost+($activityCostE*$infantPaxA); // ServiceCost**********************
                              $activityCostEMarkup = getMarkupCost($activityCostE,$markupCost,$markupType);
                              $serviceMarkupAct = $serviceMarkupAct+($activityCostEMarkup*$infantPaxA); // Service Markup**********************
                              if($taxType == 2){
                                  $activityCostETax = getMarkupCost($activityCostEMarkup,$gstTax,$gstType);
                              }else{
                                  $activityCostEAndMarkup = $activityCostE;
                                  $activityCostETax = getMarkupCost($activityCostEAndMarkup,$gstTax,$gstType);
                              }
                              $serviceGst = $serviceGst+($activityCostETax*$infantPaxA); // Service Gst**********************
                          }
                        //   if($paxAdultBLE>0){ 
                        //       $activityCostALE = getMarkupCost($actCostAB,$activityBLE,$activityCalTypeBLE);
                        //       $activityCostALE = $activityCostALE;
                        //       $serviceCost = $serviceCost+($activityCostALE*$paxAdultBLE); // ServiceCost**********************
                        //       $activityCostALEMarkup = getMarkupCost($activityCostALE,$markupCost,$markupType);
                        //       $serviceMarkupAct = $serviceMarkupAct+($activityCostALEMarkup*$paxAdultBLE); // Service Markup**********************
                        //       if($taxType == 2){
                        //           $activityCostALETax = getMarkupCost($activityCostALEMarkup,$gstTax,$gstType);
                        //       }else{
                        //           $activityCostALEAndMarkup = $activityCostALE+$activityCostALEMarkup;
                        //           $activityCostALETax = getMarkupCost($activityCostALEAndMarkup,$gstTax,$gstType);
                        //       }
                        //       $serviceGst = $serviceGst+($activityCostALETax*$paxAdultBLE); // Service Gst**********************
                        //   }
  
                        //   if($paxAdultBFE>0){
                        //       $activityCostAFE = getMarkupCost($actCostAB,$activityBFE,$activityCalTypeBFE);
                        //       $activityCostAFE = $activityCostAFE;
                        //       $serviceCost = $serviceCost+($activityCostAFE*$paxAdultBFE); // ServiceCost**********************
                        //       $activityCostAFEMarkup = getMarkupCost($activityCostAFE,$markupCost,$markupType);
                        //       $serviceMarkupAct = $serviceMarkupAct+($activityCostAFEMarkup*$paxAdultBFE); // Service Markup**********************
                        //       if($taxType == 2){
                        //           $activityCostAFETax = getMarkupCost($activityCostAFEMarkup,$gstTax,$gstType);
                        //       }else{
                        //           $activityCostAFEAndMarkup = $activityCostAFE+$activityCostAFEMarkup;
                        //           $activityCostAFETax = getMarkupCost($activityCostAFEAndMarkup,$gstTax,$gstType);
                        //       }
                        //       $serviceGst = $serviceGst+($entranceCostAFETax*$paxAdultBFE); // Service Gst**********************
                        //   }
  
                          // for last column for this row
                          $totalServiceCost =  trim($serviceCost+$serviceMarkupAct+$serviceGst);
                          
                          // for last final row
                          $grandServiceCost = $grandServiceCost+$serviceCost;
                          $grandServiceMarkup = $grandServiceMarkup+$serviceMarkupAct;
                          $grandServiceGst = $grandServiceGst+$serviceGst;
                          // end final row var
                          $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost);
  
                          ?>
                          <tr id="selectedcon<?php echo $uniq_Id; ?>">
                            <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($activityQuotData['fromDate']));?></div></td>
                            <td><div style="width:80px;"><?php echo 'Sightseeing'; ?></div></td>
                            <td><?php echo ucfirst($activityData['otherActivityName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($activityQuotData['otherActivityCity']);  ?>&nbsp;)</td>
                            <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                            <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                            <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkupAct); ?></td>
                            <td align="right">
                              <?php  echo trim($gstTax).'% ';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                            <?php } ?>
                            <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                          </tr>
                          <?php
                        }
                      }

                    if($serviceType=='train'){
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
                      while($trainQuotData=mysqli_fetch_array($c)){
                        // hotel data
                        $d='';
                        $d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$trainQuotData['trainId'].'"');
                        $trainData=mysqli_fetch_array($d);
                        
                        $trainCostB=$serviceCost=$serviceMarkup=$serviceGst=0;
                        $markupCost = $gstTax = 0;
                        // if domestic service wise markup
                        if($isSer_Mark == 1 && $isUni_Mark == 0){
                            $markupCost = $trainQuotData['markupCost'];
                            $gstTax = getGstValueById($trainQuotData['gstTax']);
                        }

                        $markupType = $trainQuotData['markupType'];
                        $currencyValue = $trainQuotData['currencyValue'];
                        $gstType = 1;
                        $taxType = $trainQuotData['taxType'];
                        $trainLableB = '';
                        $trainLableB .= ' Guest,';
                        if( $trainQuotData['adultCost']>0 && $trainQuotData['isGuestType']==1 ){
                            $trainCostBA = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($trainQuotData['adultCost'],$trainQuotData['gstTax'],$trainQuotData['markupCost'],$trainQuotData['markupType']));
                            $serviceCost = $serviceCost+($trainCostBA*$paxAdult); // ServiceCost**********************
                            $trainCostBAMarkup = getMarkupCost($trainCostBA,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($trainCostBAMarkup*$paxAdult); // Service Markup**********************
                            if($taxType == 2){
                                $trainCostBATax = getMarkupCost($trainCostBAMarkup,$gstTax,$gstType);
                            }else{
                                $trainCostBAAndMarkup = $trainCostBA+$trainCostBAMarkup;
                                $trainCostBATax = getMarkupCost($trainCostBAAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($trainCostBATax*$paxAdult); // Service Gst**********************
                        }
                        if( $trainQuotData['childCost']>0 && $trainQuotData['isGuestType']==1 ){
                            $trainCostBC = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($trainQuotData['childCost'],$trainQuotData['gstTax'],$trainQuotData['markupCost'],$trainQuotData['markupType']));
                           
                            $serviceCost = $serviceCost+($trainCostBC*$paxChild); // ServiceCost**********************
                            $trainCostBCMarkup = getMarkupCost($trainCostBC,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($trainCostBCMarkup*$paxChild); // Service Markup**********************
                            if($taxType == 2){
                                $trainCostBCTax = getMarkupCost($trainCostBCMarkup,$gstTax,$gstType);
                            }else{
                                $trainCostBCAndMarkup = $trainCostBC+$trainCostBCMarkup;
                                $trainCostBCTax = getMarkupCost($trainCostBCAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($trainCostBCTax*$paxChild); // Service Gst**********************
                        }
                        if( $trainQuotData['infantCost']>0 && $trainQuotData['isGuestType']==1 ){
                            $trainCostBE = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($trainQuotData['infantCost'],$trainQuotData['gstTax'],$trainQuotData['markupCost'],$trainQuotData['markupType']));
                            $serviceCost = $serviceCost+($trainCostBE*$paxInfant); // ServiceCost**********************
                            $trainCostBEMarkup = getMarkupCost($trainCostBE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($trainCostBEMarkup*$paxInfant); // Service Markup**********************
                            if($taxType == 2){
                                $trainCostBETax = getMarkupCost($trainCostBEMarkup,$gstTax,$gstType);
                            }else{
                                $trainCostBEAndMarkup = $trainCostBE+$trainCostBEMarkup;
                                $trainCostBETax = getMarkupCost($trainCostBEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($trainCostBETax*$paxInfant); // Service Gst**********************
                        }
                        if($paxAdultBLE>0 && $trainQuotData['isLocalEscort']==1){
                            $trainLableB .= ' L.Escort,';
                            $trainCostBLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$trainQuotData['adultCost']),$trainBLE,$trainCalTypeBLE);
                            $serviceCost = $serviceCost+($trainCostBLE*$paxAdultBLE); // ServiceCost**********************
                            $trainCostBLEMarkup = getMarkupCost($trainCostBLE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($trainCostBLEMarkup*$paxAdultBLE); // Service Markup**********************
                            if($taxType == 2){
                                $trainCostBLETax = getMarkupCost($trainCostBLEMarkup,$gstTax,$gstType);
                            }else{
                                $trainCostBLEAndMarkup = $trainCostBLE+$trainCostBLEMarkup;
                                $trainCostBLETax = getMarkupCost($trainCostBLEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($trainCostBLETax*$paxAdultBLE); // Service Gst**********************
                        } 
                        if($paxAdultBFE>0 && $trainQuotData['isForeignEscort']==1){
                            $trainLableB .= ' F.Escort,';
                            $trainCostBFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$trainQuotData['adultCost']),$trainBFE,$trainCalTypeBFE);
                            $serviceCost = $serviceCost+($trainCostBFE*$paxAdultBFE); // ServiceCost**********************
                            $trainCostBFEMarkup = getMarkupCost($trainCostBFE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($trainCostBFEMarkup*$paxAdultBFE); // Service Markup**********************
                            if($taxType == 2){
                                $trainCostBFETax = getMarkupCost($trainCostBFEMarkup,$gstTax,$gstType);
                            }else{
                                $trainCostBFEAndMarkup = $trainCostBFE+$trainCostBFEMarkup;
                                $trainCostBFETax = getMarkupCost($trainCostBFEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($trainCostBFETax*$paxAdultBFE); // Service Gst**********************
                        }

                         // for last column for this row
                        $totalServiceCost = trim($serviceCost+$serviceMarkup+$serviceGst);
                        
                        // for last final row
                        $grandServiceCost = $grandServiceCost+$serviceCost;
                        $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                        $grandServiceGst = $grandServiceGst+$serviceGst;
                        // end final row var
                        $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost); 

                        ?>
                        <tr id="selectedcon<?php echo $uniq_Id; ?>">
                          <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($trainQuotData['fromDate']));?></div></td>
                          <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                          <td><?php echo rtrim($trainLableB,',').' | '.ucfirst($trainData['trainName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($trainQuotData['destinationId']);  ?>&nbsp;)</td>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                          <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                          <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkup); ?></td>
                          <td align="right">
                            <?php  echo trim($gstTax).'% ';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                          <?php } ?>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                        </tr>
                        <?php
                      }
                    }
                    if($serviceType=='flight' && $resultpageQuotation['flightCostType']==0){
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
                      while($flightQuotData=mysqli_fetch_array($c)){
                        // hotel data
                        $d='';
                        $d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$flightQuotData['flightId'].'"');
                        $flightData=mysqli_fetch_array($d);
                        
                        $flightCostB=$serviceCost=$serviceMarkup=$serviceGst=0;
                        $markupCost = $gstTax = 0;
                        // if domestic service wise markup
                        if($isSer_Mark == 1 && $isUni_Mark == 0){
                            $markupCost = $flightQuotData['markupCost'];
                            $gstTax = getGstValueById($flightQuotData['gstTax']);
                        }

                        $markupType = $flightQuotData['markupType'];
                        $currencyValue = $flightQuotData['currencyValue'];
                        $gstType = 1;
                        $taxType = $flightQuotData['taxType'];

                        $flightLableB = '';

                        if( $flightQuotData['adultCost']>0 && $flightQuotData['isGuestType']==1 ){
                            $flightLableB = ' Guest,';
                            $flightCostBA = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($flightQuotData['adultCost'],$flightQuotData['gstTax'],$flightQuotData['markupCost'],$flightQuotData['markupType']));

                            $serviceCost = $serviceCost+($flightCostBA*$paxAdult); // ServiceCost**********************
                            $flightCostBAMarkup = getMarkupCost($flightCostBA,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($flightCostBAMarkup*$paxAdult); // Service Markup**********************
                            if($taxType == 2){
                                $flightCostBATax = getMarkupCost($flightCostBAMarkup,$gstTax,$gstType);
                            }else{
                                $flightCostBAAndMarkup = $flightCostBA+$flightCostBAMarkup;
                                $flightCostBATax = getMarkupCost($flightCostBAAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($flightCostBATax*$paxAdult); // Service Gst**********************
                        }
                        if( $flightQuotData['childCost']>0 && $flightQuotData['isGuestType']==1 ){
                            $flightLableB = ' Guest,';
                            $flightCostBC = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($flightQuotData['childCost'],$flightQuotData['gstTax'],$flightQuotData['markupCost'],$flightQuotData['markupType']));
                           
                            $serviceCost = $serviceCost+($flightCostBC*$paxChild); // ServiceCost**********************
                            $flightCostBCMarkup = getMarkupCost($flightCostBC,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($flightCostBCMarkup*$paxChild); // Service Markup**********************
                            if($taxType == 2){
                                $flightCostBCTax = getMarkupCost($flightCostBCMarkup,$gstTax,$gstType);
                            }else{
                                $flightCostBCAndMarkup = $flightCostBC+$flightCostBCMarkup;
                                $flightCostBCTax = getMarkupCost($flightCostBCAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($flightCostBCTax*$paxChild); // Service Gst**********************
                        }
                        if( $flightQuotData['infantCost']>0 && $flightQuotData['isGuestType']==1 ){
                            $flightLableB = ' Guest,';
                            $flightCostBE = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($flightQuotData['infantCost'],$flightQuotData['gstTax'],$flightQuotData['markupCost'],$flightQuotData['markupType']));
                           
                            $serviceCost = $serviceCost+($flightCostBE*$paxInfant); // ServiceCost**********************
                            $flightCostBEMarkup = getMarkupCost($flightCostBE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($flightCostBEMarkup*$paxInfant); // Service Markup**********************
                            if($taxType == 2){
                                $flightCostBETax = getMarkupCost($flightCostBEMarkup,$gstTax,$gstType);
                            }else{
                                $flightCostBEAndMarkup = $flightCostBE+$flightCostBEMarkup;
                                $flightCostBETax = getMarkupCost($flightCostBEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($flightCostBETax*$paxInfant); // Service Gst**********************
                        }

                        if($paxAdultBLE>0 && $flightQuotData['isLocalEscort']==1){
                            $flightLableB .= ' L.Escort,';
                            $flightCostBLE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$flightQuotData['adultCost']),$flightBLE,$flightCalTypeBLE);
                            $serviceCost = $serviceCost+($flightCostBLE*$paxAdultBLE); // ServiceCost**********************
                            $flightCostBLEMarkup = getMarkupCost($flightCostBLE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($flightCostBLEMarkup*$paxAdultBLE); // Service Markup**********************
                            if($taxType == 2){
                                $flightCostBLETax = getMarkupCost($flightCostBLEMarkup,$gstTax,$gstType);
                            }else{
                                $flightCostBLEAndMarkup = $flightCostBLE+$flightCostBLEMarkup;
                                $flightCostBLETax = getMarkupCost($flightCostBLEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($flightCostBLETax*$paxAdultBLE); // Service Gst**********************
                        }

                        if($paxAdultBFE>0 && $flightQuotData['isForeignEscort']==1){
                            $flightLableB .= ' F.Escort,';
                            $flightCostBFE = getMarkupCost(convert_to_base($currencyValue,$baseCurrencyVal,$flightQuotData['adultCost']),$flightBFE,$flightCalTypeBFE);
                            $serviceCost = $serviceCost+($flightCostBFE*$paxAdultBFE); // ServiceCost**********************
                            $flightCostBFEMarkup = getMarkupCost($flightCostBFE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($flightCostBFEMarkup*$paxAdultBFE); // Service Markup**********************
                            if($taxType == 2){
                                $flightCostBFETax = getMarkupCost($flightCostBFEMarkup,$gstTax,$gstType);
                            }else{
                                $flightCostBFEAndMarkup = $flightCostBFE+$flightCostBFEMarkup;
                                $flightCostBFETax = getMarkupCost($flightCostBFEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($flightCostBFETax*$paxAdultBFE); // Service Gst**********************
                        }

                         // for last column for this row
                        $totalServiceCost = trim($serviceCost+$serviceMarkup+$serviceGst);
                        
                        // for last final row
                        $grandServiceCost = $grandServiceCost+$serviceCost;
                        $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                        $grandServiceGst = $grandServiceGst+$serviceGst;
                        // end final row var
                        $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost);

                        ?>

                        <tr id="selectedcon<?php echo $uniq_Id; ?>">
                          <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($flightQuotData['fromDate']));?></div></td>
                          <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                          <td><?php echo rtrim($flightLableB,',').' | '.ucfirst($flightData['flightName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($flightQuotData['destinationId']);  ?>&nbsp;)</td>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                          <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                          <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkup); ?></td>
                          <td align="right">
                            <?php  echo trim($gstTax).'% ';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                          <?php } ?>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                        </tr>
                        <?php
                      }
                    }
                    if($serviceType=='guide'){
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'" and serviceType=0 and isGuestType=1 and slabId = "' . $groupSlabBD['id'] . '"');
                      while($guideQuotData=mysqli_fetch_array($c)){
                        // hotel data
                        $d='';
                        $d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$guideQuotData['guideId'].'"');
                        $guideData=mysqli_fetch_array($d);
                        
                        $guideCostBPP=$guideCostB=$serviceCostWGSTMP=$serviceCost=$serviceGst=$serviceMarkup=0;

                        $markupCost = $gstTax = 0;
                        // if domestic service wise markup
                        if($isSer_Mark == 1 && $isUni_Mark == 0){
                            $markupCost = $guideQuotData['markupCost'];
                            $gstTax = getGstValueById($guideQuotData['gstTax']);
                        }

                        $markupType = $guideQuotData['markupType'];
                        $currencyValue = $guideQuotData['currencyValue'];
                        $gstType = 1;
                        $taxType = $guideQuotData['taxType'];
                        // $guideCostBPP = trim($guideQuotData['price']/$totalDFB);

                        // ******************************************
                       
                        $guideCostB = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($guideQuotData['price'],$guideQuotData['gstTax'],$guideQuotData['markupCost'],$guideQuotData['markupType']));
                        // total markup
                        $guideCostBMarkup = getMarkupCost($guideCostB,$markupCost,$markupType);

                        if($markupType==1){
                            $serviceMarkup = $guideCostBMarkup;
                        }else{
                            $guideCostBMarkup = $guideCostBMarkup*$totalDFACI;
                            $serviceMarkup = $guideCostBMarkup;
                        }

                        //$serviceMarkup = ($guideCostBMarkup*$totalpaxDF); // Service Markup**********************

                        // tax on total
                        if($taxType == 2){
                            $guideCostBTax = getMarkupCost($serviceMarkup,$gstTax,$gstType);
                        }else{
                            $guideCostBAndMarkup = $guideCostB+$serviceMarkup;
                            $guideCostBTax = getMarkupCost($guideCostBAndMarkup,$gstTax,$gstType);
                        }
                        $serviceGst = ($guideCostBTax*$totalpaxDF); // Service Gst**********************

                        // per person cost 
                        $guideCostBPPWGSTMP = (($guideCostB+$serviceMarkup+$guideCostBTax)/$totalDFB); 
                        $guideCostBPP = ($guideCostB/$totalDFB); 
                        
                        // cost for guest
                        if($totalPax>0){
                            $serviceCostWGSTMP = $serviceCostWGSTMP+($guideCostBPPWGSTMP*$totalDFB); // ServiceCost**********************
                            $serviceCost = $serviceCost+($guideCostBPP*$totalDFB); // ServiceCost**********************
                        }

                        // cost for le
                        if($paxAdultBLE>0){
                            $guideCostBPPWGSTMPLE = getMarkupCost($guideCostBPPWGSTMP,$guideBLE,$guideCalTypeBLE);
                            $serviceCostWGSTMP = $serviceCostWGSTMP+($guideCostBPPWGSTMPLE*$paxAdultBLE); // ServiceCost**********************

                            $guideCostBPPLE = getMarkupCost($guideCostBPP,$guideBLE,$guideCalTypeBLE);
                            $serviceCost = $serviceCost+($guideCostBPPLE*$paxAdultBLE); // ServiceCost**********************
                        }

                        // cost for FE
                        if($paxAdultBFE>0){
                            $guideCostBPPWGSTMPFE = getMarkupCost($guideCostBPPWGSTMP,$guideBFE,$guideCalTypeBFE);
                            $serviceCostWGSTMP = $serviceCostWGSTMP+($guideCostBPPWGSTMPFE*$paxAdultBFE); // ServiceCost**********************

                            $guideCostBPPFE = getMarkupCost($guideCostBPP,$guideBFE,$guideCalTypeBFE);
                            $serviceCost = $serviceCost+($guideCostBPPFE*$paxAdultBFE); // ServiceCost**********************
                        }

                        // for last column for this row 
                        
                        // for last final row
                        $grandServiceCost = $grandServiceCost+$serviceCost;
                        $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                        $grandServiceGst = $grandServiceGst+$serviceGst;
                        // end final row var
                        $grandTotalServiceCost = trim($grandTotalServiceCost+$serviceCostWGSTMP);

                        ?>
                        <tr id="selectedcon<?php echo $uniq_Id; ?>">
                          <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($guideQuotData['fromDate']));?></div></td>
                          <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                          <td><?php echo ucfirst($guideData['name']); ?>&nbsp;(&nbsp;<?php echo getDestination($guideQuotData['destinationId']);  ?>&nbsp;)</td>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                          <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                          <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkup); ?></td>
                          <td align="right">
                            <?php  echo trim($gstTax).'% ';?><?php //if($taxType==1){ echo 'onTotal&nbsp;Cost'; }else{ echo 'onMarkup&nbsp;Only'; }  ?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                          <?php } ?>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCostWGSTMP); ?></td>
                        </tr>
                        <?php
                      }
                    } 
                    if($serviceType=='mealplan'){
                      $c='';
                      $c=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
                      while($mealplanQuotData=mysqli_fetch_array($c)){
                        $mealCostA=$mealCostC=$mealCostE=$serviceCost=$serviceMarkup=$serviceGst=0;
                        
                        $markupCost = $gstTax = 0;
                        // if domestic service wise markup
                        if($isSer_Mark == 1 && $isUni_Mark == 0){
                            $markupCost = $mealplanQuotData['markupCost'];
                            $gstTax = getGstValueById($mealplanQuotData['gstTax']);
                        }

                        $markupType = $mealplanQuotData['markupType'];
                        $currencyValue = $mealplanQuotData['currencyValue'];
                        $gstType = 1;
                        $taxType = $mealplanQuotData['taxType'];

                        $mealCostA = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($mealplanQuotData['adultCost'],$mealplanQuotData['gstTax'],$mealplanQuotData['markupCost'],$mealplanQuotData['markupType']));
                        $mealCostC = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($mealplanQuotData['childCost'],$mealplanQuotData['gstTax'],$mealplanQuotData['markupCost'],$mealplanQuotData['markupType']));
                        $mealCostE = convert_to_base($currencyValue,$baseCurrencyVal,getCostWithGSTID_Markup($mealplanQuotData['infantCost'],$mealplanQuotData['gstTax'],$mealplanQuotData['markupCost'],$mealplanQuotData['markupType']));
                        
                        if($mealCostA>0){
                            $serviceCost = $serviceCost+($mealCostA*($paxAdult)); // ServiceCost**********************
                            $mealCostAMarkup = getMarkupCost($mealCostA,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($mealCostAMarkup*($paxAdult)); // Service Markup**********************
                            if($taxType == 2){
                                $mealCostATax = getMarkupCost($mealCostAMarkup,$gstTax,$gstType);
                            }else{
                                $mealCostAAndMarkup = $mealCostA+$mealCostAMarkup;
                                $mealCostATax = getMarkupCost($mealCostAAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($mealCostATax*($paxAdult)); // Service Gst**********************
                        }

                        if($mealCostC>0){
                            $serviceCost = $serviceCost+($mealCostC*($paxChild)); // ServiceCost**********************
                            $mealCostCMarkup = getMarkupCost($mealCostC,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($mealCostCMarkup*($paxChild)); // Service Markup**********************
                            if($taxType == 2){
                                $mealCostCTax = getMarkupCost($mealCostCMarkup,$gstTax,$gstType);
                            }else{
                                $mealCostCAndMarkup = $mealCostC+$mealCostCMarkup;
                                $mealCostCTax = getMarkupCost($mealCostCAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($mealCostCTax*($paxChild)); // Service Gst**********************
                        }
                        if($mealCostE>0){
                            $serviceCost = $serviceCost+($mealCostE*$paxInfant); // ServiceCost**********************
                            $mealCostEMarkup = getMarkupCost($mealCostE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($mealCostEMarkup*$paxInfant); // Service Markup**********************
                            if($taxType == 2){
                                $mealCostETax = getMarkupCost($mealCostEMarkup,$gstTax,$gstType);
                            }else{
                                $mealCostEAndMarkup = $mealCostE+$mealCostEMarkup;
                                $mealCostETax = getMarkupCost($mealCostEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($mealCostETax*$paxInfant); // Service Gst**********************
                        }
                        if($paxAdultBLE>0){
                            $mealCostBPPLE = getMarkupCost($mealCostA,$restaurantBLE,$restaurantCalTypeBLE);
                            $serviceCost = $serviceCost+($mealCostBPPLE*$paxAdultBLE); // ServiceCost**********************
                            $mealCostBLEMarkup = getMarkupCost($mealCostBPPLE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($mealCostBLEMarkup*$paxAdultBLE); // Service Markup**********************
                            if($taxType == 2){
                                $mealCostBLETax = getMarkupCost($mealCostBLEMarkup,$gstTax,$gstType);
                            }else{
                                $mealCostBLEAndMarkup = $mealCostBPPLE+$mealCostBLEMarkup;
                                $mealCostBLETax = getMarkupCost($mealCostBLEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($mealCostBLETax*$paxAdultBLE); // Service Gst**********************
                        }

                        if($paxAdultBFE>0){
                            $mealCostBPPFE = getMarkupCost($mealCostA,$restaurantBFE,$restaurantCalTypeBFE);
                            $serviceCost = $serviceCost+($mealCostBPPFE*$paxAdultBFE); // ServiceCost**********************
                            $mealCostBFEMarkup = getMarkupCost($mealCostBPPFE,$markupCost,$markupType);
                            $serviceMarkup = $serviceMarkup+($mealCostBFEMarkup*$paxAdultBFE); // Service Markup**********************
                            if($taxType == 2){
                                $mealCostBFETax = getMarkupCost($mealCostBFEMarkup,$gstTax,$gstType);
                            }else{
                                $mealCostBFEAndMarkup = $mealCostBPPFE+$mealCostBFEMarkup;
                                $mealCostBFETax = getMarkupCost($mealCostBFEAndMarkup,$gstTax,$gstType);
                            }
                            $serviceGst = $serviceGst+($mealCostBFETax*$paxAdultBFE); // Service Gst**********************
                        }

                         // for last column for this row
                        $totalServiceCost = trim($serviceCost+$serviceMarkup+$serviceGst);
                        
                        // for last final row
                        $grandServiceCost = $grandServiceCost+$serviceCost;
                        $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                        $grandServiceGst = $grandServiceGst+$serviceGst;
                        // end final row var
                        $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost);
                        ?>
                        <tr id="selectedcon<?php echo $uniq_Id; ?>">
                          <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($mealplanQuotData['fromDate']));?></div></td>
                          <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                          <td><?php echo ucfirst($mealplanQuotData['mealPlanName']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($mealplanQuotData['destinationId']);  ?>&nbsp;)</td>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                          <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                          <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkup); ?></td>
                          <td align="right">
                            <?php  echo trim($gstTax).'% ';?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                          <?php } ?>
                          <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                        </tr>
                        <?php
                      }
                    }
                    if($serviceType=='additional'){

                        $totalServiceCost = $totalDayExtraA = $totalDayExtraC = $totalDayExtraE = $totalDayExtraG = 0;

                        $d21=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$quotationId.'" and id="'.$serviceId.'"');
                        while ($quotExtraData = mysqli_fetch_array($d21)) {

                            $extraCostA=$extraCostC=$extraCostE=$extraCostG=$serviceCost=$serviceMarkup=$serviceGst=0;
 
                            $markupCost = $quotExtraData['markupCost'];
                            $markupType = $quotExtraData['markupType'];
                            $gstTax = getGstValueById($quotExtraData['gstTax']);
                            $gstType = 1;
                            $taxType = $quotExtraData['taxType'];

                            $adultPaxAD = $quotExtraData['adultPax'];
                            $childPaxAD = $quotExtraData['childPax'];
                            $infantPaxAD = $quotExtraData['infantPax'];
                            $totalPaxAD = $adultPaxAD+$childPaxAD+$infantPaxAD;

                            if ($quotExtraData['costType']==2){
                                $totalDayExtraG = convert_to_base($quotExtraData['currencyValue'],$baseCurrencyVal, getCostWithGSTID_Markup($quotExtraData['groupCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']));
                                
                            }else {
                                $totalDayExtraA = convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup($quotExtraData['adultCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']));
                                $totalDayExtraC = convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup($quotExtraData['childCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']));
                                $totalDayExtraE = convert_to_base($quotExtraData['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup($quotExtraData['infantCost'],$quotExtraData['gstTax'],$quotExtraData['markupCost'],$quotExtraData['markupType']));
                            }
                            // A
                            if($totalDayExtraA>0 && $adultPaxAD>0){
                                $serviceCost = $serviceCost+($totalDayExtraA*$adultPaxAD); // ServiceCost**********************
                                //$totalDayExtraAMarkup = getMarkupCost($totalDayExtraA,$markupCost,$markupType);
                                //$serviceMarkup = $serviceMarkup+($totalDayExtraAMarkup*$adultPaxAD); // Service Markup**********************
                                if($taxType == 2){
                                    $totalDayExtraATax = getMarkupCost($totalDayExtraAMarkup,$gstTax,$gstType);
                                }else{
                                    $totalDayExtraAAndMarkup = $totalDayExtraA+$totalDayExtraAMarkup;
                                    $totalDayExtraATax = getMarkupCost($totalDayExtraAAndMarkup,$gstTax,$gstType);
                                }
                               $serviceGst = $serviceGst+($totalDayExtraATax*$adultPaxAD); // Service Gst**********************
                                                           
                            }
                            // C
                            if($totalDayExtraC>0 && $childPaxAD>0){
                                $serviceCost = $serviceCost+($totalDayExtraC*$childPaxAD); // ServiceCost**********************
                               // $totalDayExtraCMarkup = getMarkupCost($totalDayExtraC,$markupCost,$markupType);
                               // $serviceMarkup = $serviceMarkup+($totalDayExtraCMarkup*$childPaxAD); // Service Markup**********************
                                if($taxType == 2){
                                    $totalDayExtraCTax = getMarkupCost($totalDayExtraCMarkup,$gstTax,$gstType);
                                }else{
                                    $totalDayExtraCAndMarkup = $totalDayExtraC+$totalDayExtraCMarkup;
                                    $totalDayExtraCTax = getMarkupCost($totalDayExtraCAndMarkup,$gstTax,$gstType);
                                }
                               $serviceGst = $serviceGst+($totalDayExtraCTax*$childPaxAD); // Service Gst**********************
                            }
                            // E
                            if($totalDayExtraE>0 && $infantPaxAD>0){
                                $serviceCost = $serviceCost+($totalDayExtraE*$infantPaxAD); // ServiceCost**********************
                                //$totalDayExtraEMarkup = getMarkupCost($totalDayExtraE,$markupCost,$markupType);
                                //$serviceMarkup = $serviceMarkup+($totalDayExtraEMarkup*$infantPaxAD); // Service Markup**********************
                                if($taxType == 2){
                                    $totalDayExtraETax = getMarkupCost($totalDayExtraEMarkup,$gstTax,$gstType);
                                }else{
                                    $totalDayExtraEAndMarkup = $totalDayExtraE+$totalDayExtraEMarkup;
                                    $totalDayExtraETax = getMarkupCost($totalDayExtraEAndMarkup,$gstTax,$gstType);
                                }
                               $serviceGst = $serviceGst+($totalDayExtraETax*$infantPaxAD); // Service Gst**********************
                            }
                            // G
                            if($totalDayExtraG>0){
                                $serviceCost = $serviceCost+($totalDayExtraG); // ServiceCost**********************
                                $totalDayExtraGMarkup = getMarkupCost($totalDayExtraG,$markupCost,$markupType);
                                $serviceMarkup = $serviceMarkup+($totalDayExtraGMarkup); // Service Markup**********************
                                if($taxType == 2){
                                    $totalDayExtraGTax = getMarkupCost($totalDayExtraGMarkup,$gstTax,$gstType);
                                }else{
                                    $totalDayExtraGAndMarkup = $totalDayExtraG+$totalDayExtraGMarkup;
                                    $totalDayExtraGTax = getMarkupCost($totalDayExtraGAndMarkup,$gstTax,$gstType);
                                }
                                $serviceGst = $serviceGst+($totalDayExtraGTax); // Service Gst**********************
                                                           
                            }  
                            // for last column for this row
                            $totalServiceCost = trim($serviceCost+$serviceMarkup+$serviceGst);
                            // for last final row
                            $grandServiceCost = $grandServiceCost+$serviceCost;
                            $grandServiceMarkup = $grandServiceMarkup+$serviceMarkup;
                            $grandServiceGst = $grandServiceGst+$serviceGst;
                            // end final row var
                            $grandTotalServiceCost = trim($grandTotalServiceCost+$totalServiceCost);
                            ?>
                            <tr id="selectedcon<?php echo $uniq_Id; ?>">
                              <td><div style="width:70px;"><?php echo date('d-m-Y',strtotime($quotExtraData['fromDate']));?></div></td>
                              <td><div style="width:80px;"><?php echo ucfirst($serviceType); ?></div></td>
                              <td><?php echo ucfirst($quotExtraData['name']); ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($quotExtraData['destinationId']);  ?>&nbsp;)</td>
                              <td align="right"><?php echo getTwoDecimalNumberFormat($serviceCost); ?></td>
                              <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                              <td align="right"><?php if($markupType==1){ echo $markupCost.'%'; }else{ echo 'FLAT'.$markupCost; } ?>&nbsp;|&nbsp;<?php echo trim($serviceMarkup); ?></td>
                              <td align="right">
                                <?php  echo trim($gstTax).'% ';?>&nbsp;|&nbsp;<?php echo getTwoDecimalNumberFormat($serviceGst); ?></td>
                              <?php } ?>
                              <td align="right"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
                            </tr>
                            <?php
                      }
                    }
                    // end quoation itinerary loop
                  }
                  ?>
                <tr >
                  <td colspan="3" align="right" bgcolor="#F5F5F5"><strong>Total Cost</strong></td>
                  <td align="right" bgcolor="#F5F5F5"><strong><?php echo getTwoDecimalNumberFormat($grandServiceCost); ?></strong></td>
                  <?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>
                  <td align="right" bgcolor="#F5F5F5"><strong><?php echo getTwoDecimalNumberFormat($grandServiceMarkup); ?></strong></td>
                  <td align="right" bgcolor="#F5F5F5"><strong><?php echo getTwoDecimalNumberFormat($grandServiceGst); ?></strong></td>
                  <?php } ?>
                  <td align="right" bgcolor="#F5F5F5"><strong><?php echo getTwoDecimalNumberFormat($grandTotalServiceCost); ?></strong></td>
                </tr>
                <tr >
                  <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right"><strong>Cost&nbsp;of the Trip (<?php echo getCurrencyName($baseCurrencyId); ?>) </strong></td>
                  <td align="right" bgcolor="#F5F5F5"><strong><?php echo $grandTotalServiceCost = round(getTwoDecimalNumberFormat($grandTotalServiceCost)); ?></strong></td>
                </tr>
                <?php  
                
                $supplierCostB = getTwoDecimalNumberFormat($grandServiceCost);
                if($isUni_Mark == 0 && $isSer_Mark == 1) {
                    // if taken service wise markup 
                    $grandTotalMarkupCostB = getTwoDecimalNumberFormat($grandServiceMarkup);
                    $grandTotalServiceTaxCostB = 0;
                    $grandTotalDiscountCostB = 0;
                    $grandTotalTCSCostB = 0;
                }
                if ($serviceMarkupMain > 0 && $isUni_Mark == 1 && $isSer_Mark == 0) { 
                    $serviceMarkupLable='';
                    if ($financeresult['markupSerType'] == '1') {
                        $serviceMarkupLable='(+) MarkUp ('.$serviceMarkupMain.'';
                    }
                    if ($financeresult['markupSerType'] == '2') {
                        $serviceMarkupLable='(+) Service Charge ('.$serviceMarkupMain.'';
                    }
                    if($markupTypeMain == 1){
                        $serviceMarkupLable  .= '%)';
                        $serviceMarkup2 = $serviceMarkupMain;
                    }else{
                        $serviceMarkupLable  .= 'Flat) Per Pax For '.$totalPaxACI.'pax';
                        $serviceMarkup2 = $serviceMarkupMain*$totalPaxACI;
                    }

                    $grandTotalMarkupCostB = getMarkupCost($grandTotalServiceCost, $serviceMarkup2, $markupTypeMain);
                    $grandTotalServiceCost = $grandTotalServiceCost + $grandTotalMarkupCostB;
 
                    ?> 
                    <tr>
                        <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupLable;?></strong></td>
                        <td align="right" ><?php echo round($grandTotalMarkupCostB);?></td> 
                    </tr>
                    <tr>
                        <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Markup (<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                        <td align="right" style=" font-weight: 800; "><?php echo round($grandTotalServiceCost);?></td> 
                    </tr>
                    <?php 
                } 
                if ($discount>0) { 
                    
                    if ($discountType == '1') {
                        $discountLable  = '(-) Discount ('.$discount.'%)';
                        $discount2 = $discount;
                    }else{
                        $discountLable  = '(-) Discount ('.$discount.'Flat) Per Pax For '.$totalPaxDiscount.'pax)';
                        $discount2 = $discount*$totalPaxDiscount;
                    }   
                    
                    $grandTotalDiscountCostB = getMarkupCost($grandTotalServiceCost, $discount2, $discountType);
                    $grandTotalServiceCost = $grandTotalServiceCost - $grandTotalDiscountCostB;
                    ?> 
                    <tr>
                    <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right"  ><strong><?php echo $discountLable; ?></strong></td>
                    <td align="right" bgcolor="#F5F5F5"><?php echo round($grandTotalDiscountCostB);?></td> 
                    </tr>
                    <tr>
                    <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right"  ><strong>Grand Total&nbsp;Cost With Discount &nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                    <td align="right" bgcolor="#F5F5F5"><?php echo round($grandTotalServiceCost);?></td> 
                    </tr>
                    <?php 
                }  
                ?>
                <?php 
                if($totalExtraNoMarkupG>0){ 
                    $grandTotalServiceCost=$grandTotalServiceCost+$totalExtraNoMarkupG;
                    ?>
                <tr>
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>(+) Miscellaneous Cost</strong></td>
                    <td align="right" ><?php echo getTwoDecimalNumberFormat($totalExtraNoMarkupG);?></td> 
                </tr>
                <?php } ?>
                <?php 
                if (($serviceTax>0 || $tcsTax>0)  && $isUni_Mark == 1 && $isSer_Mark == 0) {
                    if ($serviceTax>0) {
                        if ($financeresult['taxType'] == '1') {
                            $serviceMarkupLable  = '(+) GST ('.$serviceTax.'%)';
                        }
                        if ($financeresult['taxType'] == '2') {
                            $serviceMarkupLable  = '(+) VAT ('.$serviceTax.'%)';
                        }
                    }
                    $taxType = 1; 
                    if ($tcsTax>0){ 
                        $serviceTCSLable  = '(+) TCS ('.$tcsTax.'%)';
                    }
                    // echo ($taxType == 1) ? '&nbsp;(%)' : '&nbsp;(Flat)';
                    $grandTotalServiceTaxCostB = getMarkupCost($grandTotalServiceCost, $serviceTax, $taxType, $serviceTaxDivident);

                    $grandTotalTCSCostB = getMarkupCost($grandTotalServiceCost, $tcsTax, $taxType);

                    $grandTotalServiceCost = $grandTotalServiceCost + $grandTotalServiceTaxCostB + $grandTotalTCSCostB; 


                    if($serviceTax>0){ ?>
                        <tr>
                        <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupLable;?></strong></td>
                        <td align="right" ><?php echo round($grandTotalServiceTaxCostB);?></td> 
                        </tr>
                        <?php 
                    }
                    if ($tcsTax>0){ ?>
                        <tr>  
                        <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceTCSLable;?></strong></td>
                        <td align="right" ><?php echo round($grandTotalTCSCostB);?></td> 
                        </tr>
                      <?php 
                    } ?>
                    <tr>
                        <td colspan="<?php if($isSer_Mark == 1 && $isUni_Mark == 0){ ?>6<?php }else{ ?>4<?php } ?>" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Tour&nbsp;Cost&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                        <td align="right" style=" font-weight: 800; "><?php echo  round($grandTotalServiceCost); ?></td> 
                    </tr>
                    <?php 

                } 

                $clientCostB = $grandTotalServiceCost;
                $grandTotalServiceTaxCostB = getTwoDecimalNumberFormat($grandTotalServiceTaxCostB+$grandServiceGst);
                // Break-up Cost | Total Pax (2) 
                
                if(is_nan(${"ppCostONSingleBasis".$val})) { ${"ppCostONSingleBasis".$val} = 0; }       
                if(is_nan(${"ppCostONDoubleBasis".$val})) { ${"ppCostONDoubleBasis".$val} = 0; }       
                if(is_nan(${"ppCostONTwinBasis".$val})) { ${"ppCostONTwinBasis".$val} = 0; }       
                if(is_nan(${"ppCostOnTripleBasis".$val})) { ${"ppCostOnTripleBasis".$val} = 0; }       
                if(is_nan(${"ppCostOnQuadBasis".$val})) { ${"ppCostOnQuadBasis".$val} = 0; }       
                if(is_nan(${"ppCostOnSixBasis".$val})) { ${"ppCostOnSixBasis".$val} = 0; }       
                if(is_nan(${"ppCostOnEightBasis".$val})) { ${"ppCostOnEightBasis".$val} = 0; }       
                if(is_nan(${"ppCostOnTenBasis".$val})) { ${"ppCostOnTenBasis".$val} = 0; }       
                if(is_nan(${"ppCostOnExtraBedABasis".$val})) { ${"ppCostOnExtraBedABasis".$val} = 0; }       
                if(is_nan(${"pcCostOnExtraBedCBasis".$val})) { ${"pcCostOnExtraBedCBasis".$val} = 0; }       
                if(is_nan(${"pcCostOnExtraNBedCBasis".$val})) { ${"pcCostOnExtraNBedCBasis".$val} = 0; }       
                
                $nameinv = 'totalCompanyCost="'.$supplierCostB.'",totalQuotCost="'.$clientCostB.'",totalMarkupCost="'.$grandTotalMarkupCostB.'",totalDiscountCost="'.$grandTotalDiscountCostB.'",totalServiceTaxCost="'.$grandTotalServiceTaxCostB.'",totalTCSCost="'.$grandTotalTCSCostB.'",sglBasisCost="'.${"ppCostONSingleBasis".$val}.'",dblBasisCost="'.${"ppCostONDoubleBasis".$val}.'",twinCost="'.${"ppCostONTwinBasis".$val}.'",tplBasisCost="'.$ppCostOnTripleBasis.'",quadBasisCost="'.${"ppCostOnQuadBasis".$val}.'",sixBedBasisCost="'.${"ppCostOnSixBasis".$val}.'",eightBedBasisCost="'.${"ppCostOnEightBasis".$val}.'",tenBedBasisCost="'.${"ppCostOnTenBasis".$val}.'",extraAdultCost="'.${"ppCostOnExtraBedABasis".$val}.'",CWBCost="'.${"pcCostOnExtraBedCBasis".$val}.'",CNBCost="'.${"pcCostOnExtraNBedCBasis".$val}.'"';
                updatelisting(_QUOTATION_MASTER_,$nameinv,'id="'.$quotationId.'"');

                ?> 
              </tbody>
            </table>
            <?php 

            
        }
        } 
        ?>
    </td>
    <td>&nbsp;</td>
    </tr>
</table>    

<!-- END MAIN MIDDLE BLOCK -->
<?php 
if($resultpageQuotation['quotationType']==1){ 
$suppRoomQuery=$checkSuppHQuery="";
$suppRoomQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and isRoomSupplement=1 ');
$checkSuppHQuery=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and isHotelSupplement=1 ');
if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0 ){
?>
<table width="100%">
<tr>
<td width="60%">
<div style="text-align:left; font-size:22px; margin-bottom:10px; margin-top:10px;"><strong>Hotel/Room&nbsp;Supplement</strong>(Per-Person)</div>
</td>
</tr>
<tr>  
<td width="60%">
<?php 
$queryId = $resultpageQuotation['queryId'];
$quotationId= $resultpageQuotation['id'];
$_REQUEST['parts'] = 'hotelSupplement';
include('PreviewFiles/proposal_parts.php');
?>
</td> 
</tr> 
</table>
<?php } } ?>
<div style="overflow:hidden; margin-top:20px;<?php if(!isset($_REQUEST['finalcategory']) && !isset($_REQUEST['quotationId'])){ ?>display:none;<?php } ?>">
    <table border="0" align="right" cellpadding="5" cellspacing="0">
        <tbody>
            <tr>
                <td> 
                    <input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();"> 
                </td>
            </tr>
        </tbody>
    </table>
</div>

    
</div>
<?php } ?>