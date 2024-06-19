<?php 
// FOR USE SAME FILE IN PROPOSALS vivid + Multiple hotel Cateogry
if(isset($_REQUEST['quotationId'])){
    include "inc.php";
    $quotationId = $_REQUEST['quotationId'];

    $rsp = "";
    $rsp = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.$quotationId.'"');
    $resultpageQuotation = mysqli_fetch_array($rsp);

    $rs = '';
    $rs = GetPageRecord('*', _QUERY_MASTER_, 'id="'.($resultpageQuotation['queryId']).'"');
    $resultpage = mysqli_fetch_array($rs);
        
    $quotationId = $resultpageQuotation['id'];
    $queryId = $resultpage['id'];
}

$slabAndRoomType = $resultpageQuotation['slabAndRoomType'];
$is_flight_supp = $resultpageQuotation['flightCostType'];

$paxAdult = ($resultpageQuotation['adult']);
$paxChild = ($resultpageQuotation['child']);
$paxInfant = ($resultpageQuotation['infant']);
$totalPax = ($paxAdult + $paxChild + $paxInfant);
if($totalPax == 0){
    $totalPax =  2;
}

$AdultChildCols = 1;
if($paxChild>0){
    $AdultChildCols = $AdultChildCols+1; 
}
if($paxInfant>0){
    $AdultChildCols = $AdultChildCols+1; 
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

if ($singleRoom<1 && $doubleRoom<1 && $tripleRoom<1 && $sixBedRoom<1 && $eightBedRoom<1 && $tenBedRoom<1 && $quadBedRoom<1){
  $hotelIncluded = 0;
} else {
  $hotelIncluded = 1;
}

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

// CURRENCY DETAILS
if ($resultpageQuotation['currencyId'] == '' && $resultpageQuotation['currencyId'] == 0) {
    $newCurr = $baseCurrencyId;
} else {
    $newCurr = $resultpageQuotation['currencyId'];
}

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

// PRICE SENSITIVITY
$priceSenValue = $resultpageQuotation['priceSenValue'];

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
    $cruise = $serviceMarkuD['cruise'];
    $cruiseMarkupType = $serviceMarkuD['cruiseMarkupType'];
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
    $serviceMarkup = $resultpageQuotation['markup'];
    $markupType = $resultpageQuotation['markupType'];
}

//  Value Added Services Start

$visaCostType = $resultpageQuotation['visaCostType'];
$passportCostType = $resultpageQuotation['passportCostType'];
$insuranceCostType = $resultpageQuotation['insuranceCostType'];

$visaRequired = $resultpageQuotation['visaRequired'];
$insuranceRequired = $resultpageQuotation['insuranceRequired'];
$passportRequired = $resultpageQuotation['passportRequired'];



// END QUOTATION DATA CONTAINERS  

function getFOCCost($focCost,$slabId,$focType,$serviceType,$quotationId){
    $esQLE = "";
    $esQLE=GetPageRecord('*','quotationFOCRates','1 and slabId="'.$slabId.'" and focType="'.$focType.'" and quotationId="'.$quotationId.'"');
    if (mysqli_num_rows($esQLE)>0 ) {
        $escortData = mysqli_fetch_array($esQLE);
        $Cost=$CalType='';
        if($serviceType=='hotel'){
            $Cost=$escortData['hotelCost'];
            $CalType=$escortData['hotelCalType'];
        } 
        if($serviceType=='guide'){
            $Cost=$escortData['guideCost'];
            $CalType=$escortData['guideCalType'];
        } 
        if($serviceType=='activity'){
            $Cost=$escortData['activityCost'];
            $CalType=$escortData['activityCalType'];
        } 
        if($serviceType=='entrance'){
            $Cost=$escortData['entranceCost'];
            $CalType=$escortData['entranceCalType'];
        } 
        if($serviceType=='transfer'){
            $Cost=$escortData['transferCost'];
            $CalType=$escortData['transferCalType'];
        } 
        if($serviceType=='ferry'){
            $Cost=$escortData['ferryCost'];
            $CalType=$escortData['ferryCalType'];
        } 
        if($serviceType=='train'){
            $Cost=$escortData['trainCost'];
            $CalType=$escortData['trainCalType'];
        } 
        if($serviceType=='flight'){
            $Cost=$escortData['flightCost'];
            $CalType=$escortData['flightCalType'];
        } 
        if($serviceType=='restaurant'){
            $Cost=$escortData['restaurantCost'];
            $CalType=$escortData['restaurantCalType'];
        } 
        if($serviceType=='other'){
            $Cost=$escortData['otherCost'];
            $CalType=$escortData['otherCalType'];
        }

        if ($CalType == 1) {
            $newfocCost = ($focCost * $Cost / 100);
        }
        if ($CalType == 2) {
            $newfocCost = $Cost;
        }
        return getTwoDecimalNumberFormat($newfocCost);
    }
}

if(isset($_REQUEST['finalcategory']) && $_REQUEST['finalcategory']==0){
    $hotCategory = explode(',', 0);
    // FOR single hotel Category one costsheet
}

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

foreach($hotCategory as $val){
    $finalcategory = 0;
    $multihotelQuery = $MultiQuotPreview= "";
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

    // When cost sheet preview click show below
    if(!isset($_REQUEST['export']) && isset($_REQUEST['quotationId'])){ ?>
    <h1 style="text-align:left; position:relative;">Cost&nbsp;Sheet&nbsp;|&nbsp;<?php echo $quotPreviewId; ?>
    <a href="loadCostSheet.php?export=yes&quotationId=<?php echo $_REQUEST['quotationId']; ?>&finalcategory=<?php echo $finalcategory; ?>&hotelTypeWise=<?php echo $hotelTypeWise; ?>" style="position:absolute; right:3px; top:2px;">
    <input name="Cancel" type="button" class="whitembutton"  value="Export"  style="background-color: #fff !important; padding: 4px 20px;"></a>
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
                echo getCurrencyName($newCurr);
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
    <?php } 
    ?>    
    <div style="padding-top:10px; margin-top:10px; border-top:1px solid #ccc; <?php if(!isset($_REQUEST['finalcategory']) && !isset($_REQUEST['quotationId'])){ ?>display: none;<?php } ?>" >
        <!-- Cost sheet service list -->
        <div style="text-align:center;font-size: 18px;margin-bottom:10px;"><strong>Cost Sheet Detail</strong></div>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000" style="font-size:12px;">
        <tr>
            <td width="45" align="left" bgcolor="#F5F5F5"><strong>Day/Date</strong></td>
            <td align="left" bgcolor="#F5F5F5"><strong>City </strong></td>
            <td width="93" align="left" bgcolor="#F5F5F5"><strong>Hotels</strong></td>
            <td colspan="<?php echo $hotelRatesCols ?>" align="center" bgcolor="#F5F5F5"><strong>Hotel Rates</strong></td>
            <?php
            if ($is_flight_supp == 0) {
            ?>
            <td width="48" colspan="<?php echo $AdultChildCols; ?>" align="center" bgcolor="#F5F5F5"><strong>Flight</strong></td>
            <?php
            }
            ?>
            <td width="48"  colspan="<?php echo $AdultChildCols; ?>" align="center" bgcolor="#F5F5F5"><strong>Train</strong></td>
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
           
            <?php
            if ($is_flight_supp == 0) {
            ?>
            <!-- below flight cols -->
            <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
            <?php } ?>
            <?php
            }
            ?>
            <!-- Below Train cols -->
            <td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td width="43" align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
            <?php } ?>
        </tr>
    <?php
    // main containers
    ${"totalflightA".$val} = ${"totalflightALE".$val} = ${"totalflightAFE".$val} = ${"totalflightC".$val} = 0;
    ${"totaltrainA".$val} = ${"totaltrainAFE".$val} = ${"totaltrainALE".$val} = ${"totaltrainC".$val} = 0;

    ${"totalsingle".$val}=${"totalsingleLE".$val}=${"totalsingleFE".$val}=${"serviceWiseMarkupCost".$val}=0;
    ${"totaldouble".$val}=${"totaldoubleLE".$val}=${"totaldoubleFE".$val}=0;

    ${"totaltwin".$val}=${"totaltriple".$val}=${"totalquadBed".$val}=${"totalSixBed".$val}=${"totaleightBed".$val}=${"totaltenBed".$val}=${"totalteenBed".$val}=${"totalHA".$val}=${"totalextraBedA".$val}=${"totalextraBedC".$val}=${"totalextraNBedC".$val}=0;

    ${"totalBreakfastC".$val}=${"totalBreakfastA".$val}=${"totalBreakfastALE".$val}=${"totalBreakfastAFE".$val}=0;
    ${"totalLunchC".$val}=${"totalLunchA".$val}=${"totalLunchALE".$val}=${"totalLunchAFE".$val}=0;
    ${"totalDinnerC".$val}=${"totalDinnerA".$val}=${"totalDinnerALE".$val}=${"totalDinnerAFE".$val}=0; 
    //____NEW LOOP________________________________________
    $rsp = GetPageRecord('*', _QUOTATION_MASTER_, ' id="'.$quotationId.'"');
    $quotationData = mysqli_fetch_array($rsp);
    $quotationId = $quotationData['id'];
    $dayH = 1;
    $QueryDaysQuery = GetPageRecord('*','newQuotationDays', 'quotationId="' .$quotationData['id'].'" and addstatus=0 order by srdate asc');
    while ($QueryDaysData = mysqli_fetch_array($QueryDaysQuery)){
        $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
        if ($resultpage['earlyCheckin'] == 1 && $dayH == 1) {
            $dayDate2 = date('Y-m-d', strtotime('-1 day', strtotime($dayDate)));
            $dateQuery = ' and ( fromDate="'.$dayDate2.'" or  fromDate="'.$dayDate.'" )';
        }else{
           $dateQuery = ' and fromDate="'.$dayDate.'" ';
            $dayDate2 = $dayDate;
        }

        $b =""; 
        $rows = 1;
       
        $b = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="'.$quotationId.'" and isHotelSupplement!=1 and isRoomSupplement!=1 and isGuestType=1 '.$dateQuery.' '.$multihotelQuery.' '.$hotelTypeQuery.' order by id asc');  
        if(mysqli_num_rows($b)>1) {
            $rows = mysqli_num_rows($b);
          
        }


        $rowsLE = 0;
        $bLE = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="'.$quotationId.'" and isHotelSupplement!=1 and isRoomSupplement!=1 and isLocalEscort = 1 '.$dateQuery.' '.$multihotelQuery.' '.$hotelTypeQuery.' order by id asc');  
        if(mysqli_num_rows($bLE)>0) {
            $rowsLE = mysqli_num_rows($bLE);
        }

        $rowsFE = 0;
        $bFE = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="'.$quotationId.'" and isHotelSupplement!=1 and isRoomSupplement!=1 and isForeignEscort = 1 '.$dateQuery.' '.$multihotelQuery.' '.$hotelTypeQuery.' order by id asc');  
        if(mysqli_num_rows($bFE)>0) {
            $rowsFE = mysqli_num_rows($bFE);
        }

        $rowsFELE = $rows + $rowsLE + $rowsFE; 
        
        $rowspanFELE = ' rowspan="'.$rowsFELE.'" '; 
        $rowspan = ' rowspan="'.$rows.'" '; 
        ?>
        <tr>
        <td width="118" align="left" <?php echo $rowspanFELE; ?>>D<?php
          echo str_pad($dayH, 2, '0', STR_PAD_LEFT);
          if ($resultpage['dayWise'] == 1) {
              echo " - " . date('d-m-Y', strtotime($dayDate));
          }
          ?>
        </td>
        <td width="94" align="left" <?php echo $rowspanFELE; ?>>
            <?php
          echo getDestination($QueryDaysData['cityId']);
          ?>    
        </td>
        <?php 
        $single=$double=$triple=$extraBedA=$extraBedC=$extraNBedC=$sixBedRoomC=$eightBedRoomC=$tenBedRoomC=$quadRoomC=$teenRoomC=$breakfastA=$lunchA=$dinnerA=$breakfastC=$lunchC=$dinnerC=$dayTotalHACost=0;

        $singleNoRoom=$doubleNoRoom=$tripleNoRoom=$extraBedANoRoom=$extraBedCNoRoom=$extraNBedCNoRoom=$sixBedRoomNoRoom=$eightBedRoomNoRoom=$tenBedRoomNoRoom=$quadRoomNoRoom=$teenRoomNoRoom=$breakfastA=$lunchA=$dinnerA=$breakfastC=$lunchC=$dinnerC=$dayTotalHACost=0;

        $singleLE=$doubleLE=$breakfastALE=$lunchALE=$dinnerALE=0;
        $singleLE3=$doubleLE3=$breakfastALE3=$lunchALE3=$dinnerALE3=0;
        $singleFE=$doubleFE=$breakfastAFE=$lunchAFE=$dinnerAFE=0;
        $singleFE3=$doubleFE3=$breakfastAFE3=$lunchAFE3=$dinnerAFE3=0;
        $samedayCnt = 1;
        if(mysqli_num_rows($b) > 0){
            while($qhotel = mysqli_fetch_array($b)){ 
                
                $singleNoRoom = $qhotel['singleNoofRoom'];
                
                $single = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['singleoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$singleNoRoom));
                //*$singleNoRoom 

                $doubleNoRoom = $qhotel['doubleNoofRoom'];
                $double = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round((getCostWithGSTID_Markup($qhotel['doubleoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$doubleNoRoom)));
                //*$doubleNoRoom 

                $twinNoRoom = $qhotel['twinNoofRoom'];
                $twin = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['twinoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$twinNoRoom));
                //*$twinNoRoom 

                $tripleNoRoom = $qhotel['tripleNoofRoom'];
                $triple = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['tripleoccupancy'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$tripleNoRoom));
                //*$tripleNoRoom 

                $quadRoomNoRoom = $qhotel['quadNoofRoom'];
                $quadRoomC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['quadRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$quadRoomNoRoom));
                //*$quadRoomNoRoom 


                $sixBedRoomNoRoom = $qhotel['sixNoofBedRoom'];
                $sixBedRoomC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['sixBedRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$sixBedRoomNoRoom));
                //*$sixBedRoomNoRoom 


                $eightBedRoomNoRoom = $qhotel['eightNoofBedRoom'];
                $eightBedRoomC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['eightBedRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$eightBedRoomNoRoom));
                //*$eightBedRoomNoRoom 


                $tenBedRoomNoRoom = $qhotel['tenNoofBedRoom'];
                $tenBedRoomC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['tenBedRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$tenBedRoomNoRoom));
                //*$tenBedRoomNoRoom 


                $teenRoomNoRoom = $qhotel['teenNoofRoom'];
                $teenRoomC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['teenRoom'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$teenRoomNoRoom));
                //*$teenRoomNoRoom 

                $extraBedANoRoom = $qhotel['extraNoofBed'];
                $extraBedA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['extraBed'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$extraBedANoRoom));
                //*$extraBedANoRoom 

                $extraBedCNoRoom = $qhotel['childwithNoofBed'];
                $extraBedC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['childwithbed'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$extraBedCNoRoom));
                //*$extraBedCNoRoom 

                $extraNBedCNoRoom = $qhotel['childwithoutNoofBed'];
                $extraNBedC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['childwithoutbed'],$qhotel['roomGST'],$qhotel['markupCost'],$qhotel['markupType'],$qhotel['roomTAC'],$qhotel['TACType'])*$extraNBedCNoRoom));
                //*$extraNBedCNoRoom 
                
                if ($qhotel['complimentaryBreakfast'] == 1){
                    $breakfastA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['breakfast'],$qhotel['mealGST'],0,1,0,0)));
                }
                if ($qhotel['complimentaryLunch'] == 1){
                    $lunchA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['lunch'],$qhotel['mealGST'],0,1,0,0)));
                }
                if ($qhotel['complimentaryDinner'] == 1){
                    $dinnerA = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['dinner'],$qhotel['mealGST'],0,1,0,0)));
                }

                if($qhotel['isChildBreakfast'] == 1) {
                    $breakfastC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['childBreakfast'],$qhotel['mealGST'],0,1,0,0)));
                }
                if($qhotel['isChildLunch'] == 1) {
                    $lunchC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['childLunch'],$qhotel['mealGST'],0,1,0,0)));
                }
                if($qhotel['isChildDinner'] == 1) {
                    $dinnerC = convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, round(getCostWithGSTID_Markup($qhotel['childDinner'],$qhotel['mealGST'],0,1,0,0)));
                }

                $d = '';
                $d = GetPageRecord('*', 'quotationHotelAdditionalMaster', 'quotationId="' . $quotationId . '" and hotelQuotId="'.$qhotel['id'].'" and fromDate="' . $dayDate . '" order by id asc');
                while ($qHAdditionalData = mysqli_fetch_array($d)) {
                    if ($qHAdditionalData['costType']==2) {
                        $additionalCost = convert_to_base($qHAdditionalData['currencyValue'], $baseCurrencyVal, $qHAdditionalData['additionalCost']);
                        $perPaxCost = ($additionalCost /($totalPax+$paxAdultLE+$paxAdultFE));
                    } else {
                        $perPaxCost = convert_to_base($qHAdditionalData['currencyValue'], $baseCurrencyVal, $qHAdditionalData['additionalCost']);
                    }
                    $dayTotalHACost = (trim($perPaxCost));
                } 

                $bb = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotel['supplierId'] . '"');
                $hotelname = mysqli_fetch_array($bb);

                if($samedayCnt<=$rows && $samedayCnt!=1){
                    echo '<tr>';
                }

                echo '<td align="left">';
                echo "Guest:-".stripslashes($hotelname['hotelName']);
                echo '</td>'; 
                ?>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($single);
                if($slabAndRoomType == 2){ echo 'x'.$singleNoRoom; }     
                ?></td> 
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($double);
                if($slabAndRoomType == 2){ echo 'x'.$doubleNoRoom; }     
                ?></td>
                <?php if($twinRoom>0){ ?>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($twin);
                if($slabAndRoomType == 2){ echo 'x'.$twinNoRoom; }   
                ?></td>
                <?php } if($tripleRoom>0){ ?>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($triple);
                if($slabAndRoomType == 2){ echo 'x'.$tripleNoRoom; }     
                ?></td>
                <?php } if($quadBedRoom>0){ ?>
                <td align="right"><?php 
                echo getTwoDecimalNumberFormat($quadRoomC);
                if($slabAndRoomType == 2){ echo 'x'.$quadRoomNoRoom; }   
                ?></td>
                <?php } if($sixBedRoom>0){ ?>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($sixBedRoomC);
                if($slabAndRoomType == 2){ echo 'x'.$sixBedRoomNoRoom; }     
                ?></td>
                <?php } if($eightBedRoom>0){ ?>
                <td align="right"><?php 
                echo getTwoDecimalNumberFormat($eightBedRoomC);
                if($slabAndRoomType == 2){ echo 'x'.$eightBedRoomNoRoom; }   
                ?></td>
                <?php } if($tenBedRoom>0){ ?>
                <td align="right"><?php 
                echo getTwoDecimalNumberFormat($tenBedRoomC);
                if($slabAndRoomType == 2){ echo 'x'.$tenBedRoomNoRoom; }     
                ?></td>
                <?php } if($teenBedRoom>0){ ?>
                <td align="right"><?php 
                echo getTwoDecimalNumberFormat($teenRoomC);
                if($slabAndRoomType == 2){ echo 'x'.$teenRoomNoRoom; }   
                ?></td>
                <?php } if($EBedAdult>0){ ?>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($extraBedA);
                if($slabAndRoomType == 2){ echo 'x'.$extraBedANoRoom; } 
                ?></td>
                <?php } if($EBedChild>0){ ?>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($extraBedC);
                if($slabAndRoomType == 2){ echo 'x'.$extraBedCNoRoom; } 
                ?></td>
                <?php } if($NBedChild>0){ ?>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($extraNBedC);
                if($slabAndRoomType == 2){ echo 'x'.$extraNBedCNoRoom; } 
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
                if($slabAndRoomType == 2){ 
                    // for Multiple RoomType and single Slab - cost should be total
                    ${"totalsingle".$val} = getTwoDecimalNumberFormat(${"totalsingle".$val} + round($single*$singleNoRoom));
                    ${"totaldouble".$val} = getTwoDecimalNumberFormat(${"totaldouble".$val} + round($double*$doubleNoRoom));
                    ${"totaltwin".$val} = getTwoDecimalNumberFormat(${"totaltwin".$val} + round($twin*$twinNoRoom));
                    ${"totaltriple".$val} = getTwoDecimalNumberFormat(${"totaltriple".$val} + round($triple*$tripleNoRoom));
                    ${"totalquadBed".$val} = getTwoDecimalNumberFormat(${"totalquadBed".$val} + round($quadRoomC*$quadRoomNoRoom));
                    ${"totalSixBed".$val} = getTwoDecimalNumberFormat(${"totalSixBed".$val} + round($sixBedRoomC*$sixBedRoomNoRoom));
                    ${"totaleightBed".$val} = getTwoDecimalNumberFormat(${"totaleightBed".$val} + round($eightBedRoomC*$eightBedRoomNoRoom));
                    ${"totaltenBed".$val} = getTwoDecimalNumberFormat(${"totaltenBed".$val} + round($tenBedRoomC*$tenBedRoomNoRoom));
                    ${"totalteenBed".$val} = getTwoDecimalNumberFormat(${"totalteenBed".$val} + round($teenRoomC*$teenRoomNoRoom));


                    ${"totalextraBedA".$val} = getTwoDecimalNumberFormat(${"totalextraBedA".$val} + round($extraBedA*$extraBedANoRoom));
                    ${"totalextraBedC".$val} = getTwoDecimalNumberFormat(${"totalextraBedC".$val} + round($extraBedC*$extraBedCNoRoom));
                    ${"totalextraNBedC".$val} = getTwoDecimalNumberFormat(${"totalextraNBedC".$val} + round($extraNBedC*$extraNBedCNoRoom));
                }else{
                    // for single RoomType and Multiple Slab - cost should be unit wise
                    ${"totalsingle".$val} = getTwoDecimalNumberFormat(${"totalsingle".$val} + $single);
                    ${"totaldouble".$val} = getTwoDecimalNumberFormat(${"totaldouble".$val} + $double);
                    ${"totaltwin".$val} = getTwoDecimalNumberFormat(${"totaltwin".$val} + $twin);
                    ${"totaltriple".$val} = getTwoDecimalNumberFormat(${"totaltriple".$val} + $triple);
                    ${"totalquadBed".$val} = getTwoDecimalNumberFormat(${"totalquadBed".$val} + $quadRoomC);
                    ${"totalSixBed".$val} = getTwoDecimalNumberFormat(${"totalSixBed".$val} + $sixBedRoomC);
                    ${"totaleightBed".$val} = getTwoDecimalNumberFormat(${"totaleightBed".$val} + $eightBedRoomC);
                    ${"totaltenBed".$val} = getTwoDecimalNumberFormat(${"totaltenBed".$val} + $tenBedRoomC);
                    ${"totalteenBed".$val} = getTwoDecimalNumberFormat(${"totalteenBed".$val} + $teenRoomC);

                    ${"totalextraBedA".$val} = getTwoDecimalNumberFormat(${"totalextraBedA".$val} + $extraBedA);
                    ${"totalextraBedC".$val} = getTwoDecimalNumberFormat(${"totalextraBedC".$val} + $extraBedC);
                    ${"totalextraNBedC".$val} = getTwoDecimalNumberFormat(${"totalextraNBedC".$val} + $extraNBedC);
                }

                ${"totalBreakfastA".$val} = getTwoDecimalNumberFormat(${"totalBreakfastA".$val} + trim($breakfastA));
                ${"totalLunchA".$val} = getTwoDecimalNumberFormat(${"totalLunchA".$val} + trim($lunchA));
                ${"totalDinnerA".$val} = getTwoDecimalNumberFormat(${"totalDinnerA".$val} + trim($dinnerA));

                ${"totalBreakfastC".$val} = getTwoDecimalNumberFormat(${"totalBreakfastC".$val} + trim($breakfastC));
                ${"totalLunchC".$val} = getTwoDecimalNumberFormat(${"totalLunchC".$val} + trim($lunchC));
                ${"totalDinnerC".$val} = getTwoDecimalNumberFormat(${"totalDinnerC".$val} + trim($dinnerC));

                ${"totalHA".$val} = ${"totalHA".$val} + $dayTotalHACost;
                // end hotels
                
                if($samedayCnt==1 ){
                    // flights
                    if ($is_flight_supp == 0) {
                    ?>
                    <td align="right" <?php echo $rowspan; ?>><?php
                    $totalflightSamDayA = 0;
                    $totalflightSamDayC = 0;
                    $totalflightSamDayE = 0;
                    $d = GetPageRecord('*', 'quotationFlightMaster', 'quotationId="' . $quotationId . '"  and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
                    while ($flightinfo = mysqli_fetch_array($d)) {
                        $totalflightSamDayA = ($totalflightSamDayA +  convert_to_base($flightinfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($flightinfo['adultCost']*$flightinfo['adultPax']),$flightinfo['gstTax'],$flightinfo['markupCost'],$flightinfo['markupType'])));
                        $totalflightSamDayC = ($totalflightSamDayC +  convert_to_base($flightinfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($flightinfo['childCost']*$flightinfo['childPax']),$flightinfo['gstTax'],$flightinfo['markupCost'],$flightinfo['markupType'])));
                        $totalflightSamDayE = ($totalflightSamDayE +  convert_to_base($flightinfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($flightinfo['infantCost']*$flightinfo['infantPax']),$flightinfo['gstTax'],$flightinfo['markupCost'],$flightinfo['markupType'])));
                    }
                    echo getTwoDecimalNumberFormat($totalflightSamDayA);
                    ${"totalflightA".$val} = (${"totalflightA".$val} + $totalflightSamDayA);
                    ${"totalflightC".$val} = (${"totalflightC".$val} + $totalflightSamDayC);
                    ${"totalflightE".$val} = (${"totalflightE".$val} + $totalflightSamDayE);
                    ?>
                    </td>
                    <?php if($paxChild>0){ ?>
                    <td align="right" <?php echo $rowspan; ?>><?php
                    echo getTwoDecimalNumberFormat($totalflightSamDayC);
                    ?>
                    </td> 
                    <?php } ?>
                    <?php if($paxInfant>0){ ?>
                    <td align="right" <?php echo $rowspan; ?>><?php
                    echo getTwoDecimalNumberFormat($totalflightSamDayE);
                    ?>
                    </td>
                    <?php } ?>
                    <?php
                    }

                    ?>
                    <td align="right" <?php echo $rowspan; ?>><?php
                    $d = "";
                    $totaltrainSameDayA = 0;
                    $totaltrainSameDayC = 0;
                    $totaltrainSameDayE = 0;
                    $d = GetPageRecord('*', 'quotationTrainsMaster', 'quotationId="' . $quotationId . '" and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
                    while ($traininfo = mysqli_fetch_array($d)) {
                        $totaltrainSameDayA = ($totaltrainSameDayA + convert_to_base($traininfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($traininfo['adultCost']*$traininfo['adultPax']),$traininfo['gstTax'],$traininfo['markupCost'],$traininfo['markupType'])));
                        $totaltrainSameDayC = ($totaltrainSameDayC + convert_to_base($traininfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($traininfo['childCost']*$traininfo['childPax']),$traininfo['gstTax'],$traininfo['markupCost'],$traininfo['markupType'])));
                        $totaltrainSameDayE = ($totaltrainSameDayE + convert_to_base($traininfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($traininfo['infantCost']*$traininfo['infantPax']),$traininfo['gstTax'],$traininfo['markupCost'],$traininfo['markupType'])));
                    }
                    echo getTwoDecimalNumberFormat($totaltrainSameDayA);
                    ${"totaltrainA".$val} = (${"totaltrainA".$val} + $totaltrainSameDayA);
                    ${"totaltrainC".$val} = (${"totaltrainC".$val} + $totaltrainSameDayC);
                    ${"totaltrainE".$val} = (${"totaltrainE".$val} + $totaltrainSameDayE);
                    ?>
                    </td>
                    <?php if($paxChild>0){ ?>
                    <td align="right" <?php echo $rowspan; ?>><?php
                    echo getTwoDecimalNumberFormat($totaltrainSameDayC);
                    ?>
                    </td> 
                    <?php } ?>
                    <?php if($paxInfant>0){ ?>
                    <td align="right" <?php echo $rowspan; ?>><?php
                    echo getTwoDecimalNumberFormat($totaltrainSameDayE);
                    ?>
                    </td> 
                    <?php } ?>
                    <?php
                }
                if($samedayCnt<$rows){
                    echo '</tr>';
                }
                $samedayCnt++;
            }
        }else{
            ?>
            <td align="right"></td> 
            <td align="right">0</td> 
            <td align="right">0</td>
             <?php  if($twinRoom>0){ ?>
            <td align="right">0</td>
             <?php } if($tripleRoom>0){ ?>
            <td align="right">0</td>
            <?php } if($quadBedRoom>0){ ?>
                <td align="right">0</td>
            <?php } if($sixBedRoom>0){ ?>
                <td align="right">0</td>
            <?php } if($eightBedRoom>0){ ?>
            <td align="right">0</td>
            <?php } if($tenBedRoom>0){ ?>
                <td align="right">0</td>
            <?php } if($teenBedRoom>0){ ?>
                <td align="right">0</td>
            <?php } if($EBedAdult>0){ ?>
            <td align="right">0</td>
            <?php } if($EBedChild>0){ ?>
            <td align="right">0</td>
            <?php } if($NBedChild>0){ ?>
            <td align="right">0</td>
            <?php } ?>
            <td align="right">0</td>
            <td align="right">0</td>
            <td align="right">0</td>
            <td align="right">0</td>
            <td align="right">0</td>
            <td align="right">0</td>
            <td align="right">0</td>
            <?php
            // flights
            if ($is_flight_supp == 0) {
            ?>
            <td align="right" <?php echo $rowspan; ?>><?php
            $totalflightSamDayA = 0;
            $totalflightSamDayC = 0;
            $totalflightSamDayE = 0;
            $d = GetPageRecord('*', 'quotationFlightMaster', 'quotationId="' . $quotationId . '"  and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
            while ($flightinfo = mysqli_fetch_array($d)) {
            $totalflightSamDayA = ($totalflightSamDayA + convert_to_base($flightinfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($flightinfo['adultCost']*$flightinfo['adultPax']),$flightinfo['gstTax'],$flightinfo['markupCost'],$flightinfo['markupType'])));
            $totalflightSamDayC = ($totalflightSamDayC + convert_to_base($flightinfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($flightinfo['childCost']*$flightinfo['childPax']),$flightinfo['gstTax'],$flightinfo['markupCost'],$flightinfo['markupType'])));
            $totalflightSamDayE = ($totalflightSamDayE + convert_to_base($flightinfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($flightinfo['infantCost']*$flightinfo['infantPax']),$flightinfo['gstTax'],$flightinfo['markupCost'],$flightinfo['markupType'])));
            }
            echo getTwoDecimalNumberFormat($totalflightSamDayA);
            ${"totalflightA".$val} = (${"totalflightA".$val} + $totalflightSamDayA);
            ${"totalflightC".$val} = (${"totalflightC".$val} + $totalflightSamDayC);
            ${"totalflightE".$val} = (${"totalflightE".$val} + $totalflightSamDayE);
            ?>
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" <?php echo $rowspan; ?>><?php
            echo getTwoDecimalNumberFormat($totalflightSamDayC);
            ?>
            </td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" <?php echo $rowspan; ?>><?php
            echo getTwoDecimalNumberFormat($totalflightSamDayE);
            ?>
            </td>
            <?php } ?>
            <?php
            }

            ?>
            <td align="right" <?php echo $rowspan; ?>><?php
            $d = "";
            $totaltrainSameDayA = 0;
            $totaltrainSameDayC = 0;
            $totaltrainSameDayE = 0;
            $d = GetPageRecord('*', 'quotationTrainsMaster', 'quotationId="' . $quotationId . '" and isGuestType=1 and  fromDate="' . $dayDate . '"   order by id asc');
            while ($traininfo = mysqli_fetch_array($d)) {
                $totaltrainSameDayA = ($totaltrainSameDayA + convert_to_base($traininfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($traininfo['adultCost']*$traininfo['adultPax']),$traininfo['gstTax'],$traininfo['markupCost'],$traininfo['markupType'])));
                $totaltrainSameDayC = ($totaltrainSameDayC + convert_to_base($traininfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($traininfo['childCost']*$traininfo['childPax']),$traininfo['gstTax'],$traininfo['markupCost'],$traininfo['markupType'])));
                $totaltrainSameDayE = ($totaltrainSameDayE + convert_to_base($traininfo['currencyValue'], $baseCurrencyVal, getCostWithGSTID_Markup(($traininfo['infantCost']*$traininfo['infantPax']),$traininfo['gstTax'],$traininfo['markupCost'],$traininfo['markupType'])));
            }
            echo getTwoDecimalNumberFormat($totaltrainSameDayA);
            ${"totaltrainA".$val} = (${"totaltrainA".$val} + $totaltrainSameDayA);
            ${"totaltrainC".$val} = (${"totaltrainC".$val} + $totaltrainSameDayC);
            ${"totaltrainE".$val} = (${"totaltrainE".$val} + $totaltrainSameDayE);
            ?>
            </td>

            <?php if($paxChild>0){ ?>
            <td align="right" <?php echo $rowspan; ?>><?php
            echo getTwoDecimalNumberFormat($totaltrainSameDayC);
            ?>
            </td> 
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" <?php echo $rowspan; ?>><?php
            echo getTwoDecimalNumberFormat($totaltrainSameDayE);
            ?>
            </td> 
            <?php } ?>
            <?php

        }

        ?>
        </tr>
        <?php
        // early checkin for guest
        if($dayH == 55645461 && $moduleType != 2){
            $earlyQuery = $earlyCheckInHotel = ""; 
            $earlyQuery = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '"  and isHotelSupplement != 1  and isRoomSupplement != 1 and isGuestType= 1 and fromDate="' . $startdatevar . '" '.$multihotelQuery.' '.$hotelTypeQuery.'  order by id asc');
            // if (mysqli_num_rows($earlyQuery)>0){
              ?>
              <tr>
              <td width="118" align="left"></td>
              <td width="94" align="left"></td>
              <td align="left"><?php
              echo "Guest&nbsp;Early&nbsp;Arrival:-&nbsp;";
              // DATA FROM Early Arrival HOTEL SERVICE 
              if (mysqli_num_rows($earlyQuery)>0 ) {
                  $qhotel3 = mysqli_fetch_array($earlyQuery);

                  $single3 = $qhotel3['singleoccupancy'];
                  $double3 = $qhotel3['doubleoccupancy'];
                  $triple3 = ($qhotel3['doubleoccupancy']+$qhotel3['extraBed']);
                  $extraBedA3 = $qhotel3['extraBed'];
                  $extraBedC3 = $qhotel3['childwithbed'];
                  $extraNBedC3 = $qhotel3['childwithoutbed'];
                  // $breakfast3 = $qhotel3['breakfast'];
                  if ($qhotel3['complimentaryBreakfast'] == 1) {
                      $breakfast3 = $qhotel3['breakfast'];
                  }
                  if ($qhotel3['complimentaryLunch'] == 1) {
                      $lunch3 = $qhotel3['lunch'];
                  } 
                  if ($qhotel3['complimentaryDinner'] == 1) {
                      $dinner3 = $qhotel3['dinner'];
                  } 

                  ${"totalsingle".$val} =getTwoDecimalNumberFormat(${"totalsingle".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($single3)));
                  ${"totaldouble".$val} =getTwoDecimalNumberFormat(${"totaldouble".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($double3)));
                  ${"totaltriple".$val} = getTwoDecimalNumberFormat(${"totaltriple".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($triple3)));
                  ${"totalextraBedA".$val} = (${"totalextraBedA".$val} + convert_to_base($qhotel['currencyValue'], $baseCurrencyVal, trim($extraBedA3)));
                  ${"totalextraBedC".$val} = getTwoDecimalNumberFormat(${"totalextraBedC".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($extraBedC3)));
                  ${"totalextraNBedC".$val} = getTwoDecimalNumberFormat(${"totalextraNBedC".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($extraNBedC3)));
                  ${"totalBreakfast".$val} = getTwoDecimalNumberFormat(${"totalBreakfast".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($breakfast3)));
                  ${"totalLunch".$val} = getTwoDecimalNumberFormat(${"totalLunch".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($lunch3)));
                  ${"totalDinner".$val} = getTwoDecimalNumberFormat(${"totalDinner".$val} + convert_to_base($qhotel3['currencyValue'], $baseCurrencyVal, trim($dinner3)));

                  $bb = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotel3['supplierId'] . '"');
                  $hotelname = mysqli_fetch_array($bb);
                  $earlyCheckInHotel =  str_replace(" ", "&nbsp;", stripslashes($hotelname['hotelName']));
                   
                  echo $earlyCheckInHotel;
              }
           
              ?>
              </td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($single3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($double3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($triple3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($extraBedA3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($extraBedC3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($extraNBedC3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php 
                  echo getTwoDecimalNumberFormat($breakfast3);
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($lunch3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($dinner3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right" ></td>
              <td align="right" ></td>
              <td align="right" ></td> 
              </tr>
              <?php
            // } 

        }
        ?>
        <?php 
        $isDayLE = 0;
        $LEquery = $localEscortHotel = ""; 
        $LEquery = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '" and isHotelSupplement != 1  and isRoomSupplement != 1  and isLocalEscort = 1 and fromDate="' . $dayDate . '"  '.$multihotelQuery.' '.$hotelTypeQuery.'  order by id asc');
        $dflightQ=GetPageRecord('*', 'quotationFlightMaster', 'quotationId="'.$quotationId.'" and isLocalEscort=1 and  fromDate="'.$dayDate.'"');
        $dtrainQuery=GetPageRecord('*','quotationTrainsMaster','quotationId="'.$quotationId.'" and isLocalEscort=1 and fromDate="'.$dayDate.'"'); 
        // check if any local escort service exist.
        if (mysqli_num_rows($LEquery)>0 || ( mysqli_num_rows($dflightQ)>0 && $is_flight_supp==0 ) || mysqli_num_rows($dtrainQuery)>0 ){
              $isDayLE = $isTotalLE = 1;
              ?>
              <tr>
                <!-- <td align="left"></td> -->
                <!-- <td align="left"></td> -->
              <td align="left"><?php
              echo "Local&nbsp;Escort:-&nbsp;";
              // DATA FROM LOCAL ESCORT HOTEL SERVICE 
              if (mysqli_num_rows($LEquery)>0 ) {
                 
                    $qhotelLE = mysqli_fetch_array($LEquery);

                    $singleLE = convert_to_base($qhotelLE['currencyValue'], $baseCurrencyVal, $qhotelLE['singleoccupancy']);
                    $doubleLE = convert_to_base($qhotelLE['currencyValue'], $baseCurrencyVal, $qhotelLE['doubleoccupancy']);

                    // $breakfastLE = $qhotelLE['breakfast'];
                    if ($qhotelLE['complimentaryBreakfast'] == 1) {
                    $breakfastALE = convert_to_base($qhotelLE['currencyValue'],$baseCurrencyVal,$qhotelLE['lunch']);
                    }
                    if ($qhotelLE['complimentaryLunch'] == 1) {
                    $lunchALE = convert_to_base($qhotelLE['currencyValue'],$baseCurrencyVal,$qhotelLE['lunch']);
                    }
                    if ($qhotelLE['complimentaryDinner'] == 1) {
                    $dinnerALE = convert_to_base($qhotelLE['currencyValue'],$baseCurrencyVal,$qhotelLE['dinner']);
                    } 

                    if($slabAndRoomType == 2){   
                        ${"totalsingleLE".$val} =getTwoDecimalNumberFormat(${"totalsingleLE".$val} + trim($singleLE));
                        ${"totaldoubleLE".$val} =getTwoDecimalNumberFormat(${"totaldoubleLE".$val} + trim($doubleLE));
                    }else{
                        ${"totalsingleLE".$val} =getTwoDecimalNumberFormat(${"totalsingleLE".$val} + trim($singleLE));
                        ${"totaldoubleLE".$val} =getTwoDecimalNumberFormat(${"totaldoubleLE".$val} + trim($doubleLE));
                    }
                    
                    ${"totalBreakfastALE".$val} = getTwoDecimalNumberFormat(${"totalBreakfastALE".$val} + trim($breakfastALE));
                    ${"totalLunchALE".$val} = getTwoDecimalNumberFormat(${"totalLunchALE".$val} + trim($lunchALE));
                    ${"totalDinnerALE".$val} = getTwoDecimalNumberFormat(${"totalDinnerALE".$val} + trim($dinnerALE));

                    $bb = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotelLE['supplierId'] . '"');
                    $hotelname = mysqli_fetch_array($bb);
                    $localEscortHotel =  str_replace(" ", "&nbsp;", stripslashes($hotelname['hotelName']));

                    echo $localEscortHotel;
              }
            ?> </td>
            <td align="right"><?php
            if ($isDayLE == 1) {
              echo getTwoDecimalNumberFormat($singleLE); // LOCAL ESCORT RATE
            }
            ?></td>
            <td align="right"><?php
              if ($isDayLE == 1) {
                  echo getTwoDecimalNumberFormat($doubleLE); // LOCAL ESCORT RATE
              }
            ?></td>
            <?php if($tripleRoom>0){ ?>
            <td align="right"></td>
            <?php } if($quadBedRoom>0){ ?>
            <td align="right"></td>
            <?php } if($sixBedRoom>0){ ?>
            <td align="right"></td>
            <?php } if($eightBedRoom>0){ ?>
            <td align="right"></td>
            <?php } if($tenBedRoom>0){ ?>
            <td align="right"></td>
            <?php } if($teenBedRoom>0){ ?>
            <td align="right"></td>
            <?php } if($EBedAdult>0){ ?>
            <td align="right"></td>
            <?php } if($EBedChild>0){ ?>
            <td align="right"></td>
            <?php } if($NBedChild>0){ ?>
            <td align="right"></td>
            <?php } ?>
            <td align="right"><?php 
            echo getTwoDecimalNumberFormat($breakfastALE); // GUEST RATE
            ?></td>
            <td align="right"><?php
            echo getTwoDecimalNumberFormat($lunchALE); // GUEST RATE
            ?></td>
            <td align="right"><?php
            echo getTwoDecimalNumberFormat($dinnerALE); // GUEST RATE
            ?></td> 
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <?php
            if ($is_flight_supp == 0) {
            ?>
            <td align="right" ><?php
              $totalflightSamDayALE = 0; 
              while ($flightDLE = mysqli_fetch_array($dflightQ)) {
                  $totalflightSamDayALE = $totalflightSamDayALE + convert_to_base($flightDLE['currencyValue'],$baseCurrencyVal,trim($flightDLE['adultCost']));
              }
              echo getTwoDecimalNumberFormat($totalflightSamDayALE);
              ${"totalflightALE".$val} = getTwoDecimalNumberFormat(${"totalflightALE".$val} + $totalflightSamDayALE);
              ?>
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" ></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" ></td>
            <?php } ?>

            <?php
            }
            ?>
            <td align="right" ><?php
                $totaltrainSameDayALE = 0;
                while ($trainDLE = mysqli_fetch_array($dtrainQuery)) {
                    $totaltrainSameDayALE = $totaltrainSameDayALE + convert_to_base($trainDLE['currencyValue'],$baseCurrencyVal,trim($trainDLE['adultCost']));

                }
                echo getTwoDecimalNumberFormat($totaltrainSameDayALE);
                ${"totaltrainALE".$val} = getTwoDecimalNumberFormat(${"totaltrainALE".$val} + $totaltrainSameDayALE);
                ?>
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" ></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" ></td>
            <?php } ?>
            </tr>
            <?php
          }

        // early checkin for local escort for series
        if($resultpage['earlyCheckin'] == 1 && $dayH == 1 && $moduleType != 2){
              $earlyQueryLE = $earlyCheckInHotelLE = ""; 
              $earlyQueryLE = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '"  and isHotelSupplement != 1  and isRoomSupplement != 1 and isLocalEscort= 1 and fromDate="' . $startdatevar . '"  '.$multihotelQuery.' '.$hotelTypeQuery.' order by id asc');
              if (mysqli_num_rows($earlyQueryLE)>0){
              ?>
              <tr>
              <td width="118" align="left"></td>
              <td width="94" align="left"></td>
              <td align="left"><?php
              echo "Local&nbsp;Early&nbsp;Arrival:-&nbsp;";
              // DATA FROM Early Arrival HOTEL SERVICE 
              if (mysqli_num_rows($earlyQueryLE)>0 ) {
                  $qhotelLE3 = mysqli_fetch_array($earlyQueryLE);
                  $singleLE3 = convert_to_base($qhotelLE3['currencyValue'],$baseCurrencyVal,trim($qhotelLE3['singleoccupancy']));
                  $doubleLE3 = convert_to_base($qhotelLE3['currencyValue'],$baseCurrencyVal,trim($qhotelLE3['doubleoccupancy']));

                  // $breakfastLE3 = $qhotelLE3['breakfast'];
                  if ($qhotelLE3['complimentaryBreakfast'] == 1) {
                      $breakfastLE3 = convert_to_base($qhotelLE3['currencyValue'],$baseCurrencyVal,trim($qhotelLE3['breakfast']));
                  }
                  if ($qhotelLE3['complimentaryLunch'] == 1) {
                      $lunchLE3 = convert_to_base($qhotelLE3['currencyValue'],$baseCurrencyVal,trim($qhotelLE3['lunch']));
                  } 
                  if ($qhotelLE3['complimentaryDinner'] == 1) {
                      $dinnerLE3 = convert_to_base($qhotelLE3['currencyValue'],$baseCurrencyVal,trim($qhotelLE3['dinner']));
                  } 

                  ${"totalsingleLE".$val} =getTwoDecimalNumberFormat(${"totalsingleLE".$val} + trim($singleLE3));
                  ${"totaldoubleLE".$val} =getTwoDecimalNumberFormat(${"totaldoubleLE".$val} + trim($doubleLE3));
                

                  ${"totalBreakfastLE".$val} = getTwoDecimalNumberFormat(${"totalBreakfastLE".$val} + trim($breakfastLE3));
                  ${"totalLunchLE".$val} = getTwoDecimalNumberFormat(${"totalLunchLE".$val} + trim($lunchLE3));
                  ${"totalDinnerLE".$val} = getTwoDecimalNumberFormat(${"totalDinnerLE".$val} + trim($dinnerLE3));

                  $bb = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotelLE3['supplierId'] . '"');
                  $hotelname = mysqli_fetch_array($bb);
                  $earlyCheckInHotelLE =  str_replace(" ", "&nbsp;", stripslashes($hotelname['hotelName']));
                  echo $earlyCheckInHotelLE;
              }
              ?>
              </td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($singleLE3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($doubleLE3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"><?php 
                  echo getTwoDecimalNumberFormat($breakfastLE3);
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($lunchLE3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"><?php
                  echo getTwoDecimalNumberFormat($dinnerLE3); // LOCAL ESCORT RATE
              ?></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>
              <td align="right"></td>

                <td align="right" ></td>
                <?php if($paxChild>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <td align="right" ></td>
                <?php if($paxChild>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" ></td>
                <?php } ?>
              </tr>
              <?php
          } 
        } 

        // check if any foriegn escort service exist.
        $isDayFE = 0;
        $FEquery = $foreignEscortHotel = $dflightQ = $dtrainQuery = ""; 
        $FEquery = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '" and isHotelSupplement != 1  and isRoomSupplement != 1  and isForeignEscort = 1 and fromDate="' . $dayDate . '" '.$multihotelQuery.' '.$hotelTypeQuery.' ');
        $dflightQ=GetPageRecord('*','quotationFlightMaster','quotationId="'.$quotationId.'" and isForeignEscort = 1 and fromDate="'.$dayDate.'"');
        $dtrainQuery=GetPageRecord('*','quotationTrainsMaster','quotationId="'.$quotationId.'" and isForeignEscort=1 and fromDate="'.$dayDate.'"');
        // check if any local escort service exist.
        if (mysqli_num_rows($FEquery)>0 || ( mysqli_num_rows($dflightQ)>0 && $is_flight_supp ) || mysqli_num_rows($dtrainQuery)>0 ){
              $isDayFE = $isTotalFE = 1;
              ?>
              <tr>
              <!-- <td width="118" align="left"></td> -->
              <!-- <td width="94" align="left"></td> -->
              <td align="left"><?php
              echo "Foreign&nbsp;Escort:-&nbsp;";
              if (mysqli_num_rows($FEquery)>0 ) {

                  $qhotelFE = mysqli_fetch_array($FEquery);
                  $singleFE = convert_to_base($qhotelFE['currencyValue'],$baseCurrencyVal,trim($qhotelFE['singleoccupancy']));
                  $doubleFE = convert_to_base($qhotelFE['currencyValue'],$baseCurrencyVal,trim($qhotelFE['doubleoccupancy']));

                  // $breakfastFE = $qhotelFE['breakfast'];
                  if ($qhotelFE['complimentaryBreakfast'] == 1) {
                      $breakfastAFE = convert_to_base($qhotelFE['currencyValue'],$baseCurrencyVal,trim($qhotelFE['breakfast']));
                  }
                  if ($qhotelFE['complimentaryLunch'] == 1) {
                      $lunchAFE = convert_to_base($qhotelFE['currencyValue'],$baseCurrencyVal,trim($qhotelFE['lunch']));
                  } 
                  if ($qhotelFE['complimentaryDinner'] == 1) {
                      $dinnerAFE = convert_to_base($qhotelFE['currencyValue'],$baseCurrencyVal,trim($qhotelFE['dinner']));
                  } 

                  ${"totalsingleFE".$val} =getTwoDecimalNumberFormat(${"totalsingleFE".$val} + trim($singleFE));
                  ${"totaldoubleFE".$val} =getTwoDecimalNumberFormat(${"totaldoubleFE".$val} + trim($doubleFE));
                  

                  ${"totalBreakfastAFE".$val} = getTwoDecimalNumberFormat(${"totalBreakfastAFE".$val} + trim($breakfastAFE));
                  ${"totalLunchAFE".$val} = getTwoDecimalNumberFormat(${"totalLunchAFE".$val} + trim($lunchAFE));
                  ${"totalDinnerAFE".$val} = getTwoDecimalNumberFormat(${"totalDinnerAFE".$val} + trim($dinnerAFE));
                  
                  $bb = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotelFE['supplierId'] . '"');
                  $hotelname = mysqli_fetch_array($bb);
                  $foreignEscortHotel = str_replace(" ", "&nbsp;", stripslashes($hotelname['hotelName']));
                  echo $foreignEscortHotel;
              } 
           
                ?>
                </td>
                <td align="right"><?php
                if ($isDayFE == 1) {
                echo getTwoDecimalNumberFormat($singleFE); // LOCAL ESCORT RATE
                }
                ?></td>
                <td align="right"><?php
                if ($isDayFE == 1) {
                echo getTwoDecimalNumberFormat($doubleFE); // LOCAL ESCORT RATE
                }
                ?></td> 
                <?php if($twinRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tripleRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($quadBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($sixBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($eightBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($teenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedAdult >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($NBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php } ?> 
                <td align="right"><?php 
                    if ($isDayFE == 1) {
                    echo getTwoDecimalNumberFormat($breakfastAFE);
                    }
                ?></td>
                <td align="right"><?php
                    if ($isDayFE == 1) {
                    echo getTwoDecimalNumberFormat($lunchAFE); // LOCAL ESCORT RATE
                    }
                ?></td>
                <td align="right"><?php
                    if ($isDayFE == 1) {
                    echo getTwoDecimalNumberFormat($dinnerAFE); // LOCAL ESCORT RATE
                    }
                ?></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php
                if ($is_flight_supp == 0) {
                ?>
                <td align="right" ><?php
                  $totalflightSamDayAFE = 0; 
                  $totalflightSamDayCFE = 0;

                  while ($flightDFE = mysqli_fetch_array($dflightQ)) {
                      $totalflightSamDayAFE = $totalflightSamDayAFE + convert_to_base($flightDFE['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($flightDFE['adultCost'],$flightDFE['gstTax'],$flightDFE['markupCost'],$flightDFE['markupType']));
                      $totalflightSamDayCFE = $totalflightSamDayCFE + convert_to_base($flightDFE['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($flightDFE['childCost'],$flightDFE['gstTax'],$flightDFE['markupCost'],$flightDFE['markupType']));

                  }
                  echo getTwoDecimalNumberFormat($totalflightSamDayAFE);
                  ${"totalflightAFE".$val} = getTwoDecimalNumberFormat(${"totalflightAFE".$val} + $totalflightSamDayAFE);
                  ?>
                </td>
                <?php if($paxChild>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <?php
                }
                ?>
                <td align="right" ><?php
                    $totaltrainSameDayAFE = 0;
                    $totaltrainSameDayCFE = 0;
                    while ($trainDFE = mysqli_fetch_array($dtrainQuery)) {
                        $totaltrainSameDayAFE = $totaltrainSameDayAFE + convert_to_base($trainDFE['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($trainDFE['adultCost'],$trainDFE['gstTax'],$trainDFE['markupCost'],$trainDFE['markupType']));
                        $totaltrainSameDayCFE = $totaltrainSameDayCFE + convert_to_base($trainDFE['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($trainDFE['childCost'],$trainDFE['gstTax'],$trainDFE['markupCost'],$trainDFE['markupType']));

                    }
                    echo getTwoDecimalNumberFormat($totaltrainSameDayAFE);
                    ${"totaltrainAFE".$val} = getTwoDecimalNumberFormat(${"totaltrainAFE".$val} + $totaltrainSameDayAFE);
                    ?>
                </td> 
                <?php if($paxChild>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" ></td>
                <?php } ?> 
                </tr>
        <?php
        }

        // early checkin for foriegn escort for series 
        if($resultpage['earlyCheckin'] == 1 && $dayH == 1 && $moduleType != 2){
            $earlyQueryFE = $earlyCheckInHotelFE = ""; 
            $earlyQueryFE = GetPageRecord('*', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $quotationId . '"  and isHotelSupplement != 1  and isRoomSupplement != 1 and isForeignEscort= 1 and fromDate="' . $startdatevar . '" '.$multihotelQuery.' '.$hotelTypeQuery.'  order by id asc');
            if (mysqli_num_rows($earlyQueryFE)>0){
            ?>
                <tr>
                <td width="118" align="left"></td>
                <td width="94" align="left"></td>
                <td align="left"><?php
                echo "Foreign&nbsp;Early&nbsp;Arrival:-&nbsp;";
                // DATA FROM Early Arrival HOTEL SERVICE 
                if (mysqli_num_rows($earlyQueryFE)>0 ) {
                $qhotelFE3 = mysqli_fetch_array($earlyQueryFE);
                $singleFE3 = convert_to_base($qhotelFE3['currencyValue'],$baseCurrencyVal,trim($qhotelFE3['singleoccupancy']));
                $doubleFE3 = convert_to_base($qhotelFE3['currencyValue'],$baseCurrencyVal,trim($qhotelFE3['doubleoccupancy']));

                // $breakfastFE3 = $qhotelFE3['breakfast'];
                if ($qhotelFE3['complimentaryBreakfast'] == 1) {
                $breakfastFE3 = convert_to_base($qhotelFE3['currencyValue'],$baseCurrencyVal,trim($qhotelFE3['breakfast']));
                } 
                if ($qhotelFE3['complimentaryLunch'] == 1) {
                $lunchFE3 = convert_to_base($qhotelFE3['currencyValue'],$baseCurrencyVal,trim($qhotelFE3['lunch']));
                }
                if ($qhotelFE3['complimentaryDinner'] == 1) {
                $dinnerFE3 = convert_to_base($qhotelFE3['currencyValue'],$baseCurrencyVal,trim($qhotelFE3['dinner']));
                } 

                ${"totalsingleFE".$val} =getTwoDecimalNumberFormat(${"totalsingleFE".$val} + trim($singleFE3));
                ${"totaldoubleFE".$val} =getTwoDecimalNumberFormat(${"totaldoubleFE".$val} + trim($doubleFE3));


                ${"totalBreakfastFE".$val} = getTwoDecimalNumberFormat(${"totalBreakfastFE".$val} + trim($breakfastFE3));
                ${"totalLunchFE".$val} = getTwoDecimalNumberFormat(${"totalLunchFE".$val} + trim($lunchFE3));
                ${"totalDinnerFE".$val} = getTwoDecimalNumberFormat(${"totalDinnerFE".$val} + trim($dinnerFE3));

                $bb = GetPageRecord('*', _PACKAGE_BUILDER_HOTEL_MASTER_, 'id="' . $qhotelFE3['supplierId'] . '"');
                $hotelname = mysqli_fetch_array($bb);
                $earlyCheckInHotelFE =  str_replace(" ", "&nbsp;", stripslashes($hotelname['hotelName']));
                echo $earlyCheckInHotelFE;
                }
                ?>
                </td>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($singleFE3); // LOCAL ESCORT RATE
                ?></td>
                <td align="right"><?php
                echo getTwoDecimalNumberFormat($doubleFE3); // LOCAL ESCORT RATE
                ?></td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right"></td> 
                <td align="right"></td> 
                <td align="right"></td> 
                <td align="right"></td> 
                <td align="right"></td> 
                <td align="right"></td> 
                <td align="right"><?php 
                    echo getTwoDecimalNumberFormat($breakfastFE3);
                    ?>
                </td>
                <td align="right"><?php
                    echo getTwoDecimalNumberFormat($lunchFE3); // LOCAL ESCORT RATE
                    ?>
                </td>
                <td align="right"><?php
                    echo getTwoDecimalNumberFormat($dinnerFE3); // LOCAL ESCORT RATE
                    ?>
                </td>
                <td align="right"></td> 
                <td align="right"></td> 
                <td align="right"></td> 
                <td align="right"></td> 

                <td align="right" ></td>
                <?php if($paxChild>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <td align="right" ></td>  
                <?php if($paxChild>0){ ?>
                <td align="right" ></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" ></td>
                <?php } ?>
              </tr>
              <?php
          } 
        } 
        $dayH++;
        }
        ?> 
        <tr>
            <td colspan="3" align="right" bgcolor="#deb887"><strong>Total</strong></td>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalsingle".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaldouble".$val});
            ?></strong></td>
            <?php if($twinRoom >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltwin".$val});
            ?></strong></td>
            <?php }if($tripleRoom >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltriple".$val});
            ?></strong></td>
            <?php }if($quadBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalquadBed".$val});
            ?></strong></td>        
            <?php }if($sixBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalSixBed".$val});
            ?></strong></td>        
            <?php }if($eightBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaleightBed".$val});
            ?></strong></td>        
            <?php }if($tenBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltenBed".$val});
            ?></strong></td>        
            <?php }if($teenBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalteenBed".$val});
            ?></strong></td>        
            <?php }if($EBedAdult >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalextraBedA".$val});
            ?></strong></td>
            <?php }if($EBedChild >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalextraBedC".$val});
            ?></strong></td>
            <?php }if($NBedChild >0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalextraNBedC".$val});
            ?></strong></td>
            <?php } ?> 

            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalBreakfastA".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalLunchA".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalDinnerA".$val});
            ${"totalmealA".$val} = ${"totalBreakfastA".$val} + ${"totalLunchA".$val} + ${"totalDinnerA".$val};
            ?></strong></td>

            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalBreakfastC".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalLunchC".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalDinnerC".$val});
            ${"totalmealC".$val} = ${"totalBreakfastC".$val} + ${"totalLunchC".$val} + ${"totalDinnerC".$val};
            ?></strong></td>

            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalHA".$val});
            ?></strong></td> 

            <?php
            if ($is_flight_supp == 0) { ?>
                <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat(${"totalflightA".$val}); ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat(${"totalflightC".$val}); ?></strong></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat(${"totalflightE".$val}); ?></strong></td>
                <?php } ?>
              <?php
            }
            ?>
            <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat(${"totaltrainA".$val});  ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat(${"totaltrainC".$val}); ?></strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php echo getTwoDecimalNumberFormat(${"totaltrainE".$val}); ?></strong></td>
            <?php } ?>
        </tr>
        <?php 
        if ($isTotalLE == 1) { ?>
            <tr>
            <td colspan="3" align="right" bgcolor="#dec7c7"><strong>Local Escort Total</strong></td>
            <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalsingleLE".$val}); // LOCAL ESCORT RATE
            ?></strong></td>
            <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaldoubleLE".$val}); // LOCAL ESCORT RATE
            ?></strong></td>
            <?php if($twinRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($tripleRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($quadBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($sixBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($eightBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($tenBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($teenBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($EBedAdult >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($EBedChild >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($NBedChild >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php } ?> 
            <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalBreakfastALE".$val});
            ?></strong></td>
            <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalLunchALE".$val});
            ?></strong></td>
            <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalDinnerALE".$val});
            ${"totalmealALE".$val} = ${"totalBreakfastALE".$val} + ${"totalLunchALE".$val} + ${"totalDinnerALE".$val};
            ?></strong></td>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php
            if ($is_flight_supp == 0) {
            ?>
            <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalflightALE".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>

            <?php
            }
            ?>
            <td align="right" bgcolor="#dec7c7"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltrainALE".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>
            </tr>
            <?php
            }
            ?>
            <?php 
            if ($isTotalFE == 1) { ?>
            <tr>
            <td colspan="3" align="right" bgcolor="#d4d5f0"><strong>Foreign Escort Total</strong></td>
            <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalsingleFE".$val}); // LOCAL ESCORT RATE
            ?></strong></td>
            <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaldoubleFE".$val}); // FOREIGN ESCORT RATE
            ?></strong></td>

            <?php if($twinRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($tripleRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($quadBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($sixBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($eightBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($tenBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($teenBedRoom >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($EBedAdult >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($EBedChild >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php }if($NBedChild >0){ ?>
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <?php } ?> 

            <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalBreakfastAFE".$val});
            ?></strong></td>
            <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalLunchAFE".$val});
            ?></strong></td>
            <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalDinnerAFE".$val});
            ${"totalmealAFE".$val} = ${"totalBreakfastAFE".$val} + ${"totalLunchAFE".$val} + ${"totalDinnerAFE".$val};
            ?></strong></td>

            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    
            <td align="right" bgcolor="#d4d5f0"><strong></strong></td>    


            <?php
            if ($is_flight_supp == 0) {
            ?>
            <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalflightAFE".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>
            <?php
            }
            ?>
            <td align="right" bgcolor="#d4d5f0"><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltrainAFE".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#dec7c7"><strong></strong></td>
            <?php } ?>
            </tr>
            <?php
            }

            if($isUni_Mark == 0 && $isSer_Mark == 1) { ?>
            <!-- markup -->
            <tr>
            <td colspan="3" align="right" ><strong><?php
            if ($financeresult['markupSerType'] == '1') {
            echo 'Mark Up';
            }
            if ($financeresult['markupSerType'] == '2') {
            echo "Service Charge";
            }
            ?>&nbsp;<?php
            // echo ($hotelMarkupType == 1) ? '&nbsp;(%)' : '&nbsp;(Flat)';
            ?></strong></td>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>

            <?php if($twinRoom >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($tripleRoom >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($quadBedRoom >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($sixBedRoom >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($eightBedRoom >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($tenBedRoom >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($teenBedRoom >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($EBedAdult >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($EBedChild >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php }if($NBedChild >0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($hotel);
            ?></strong></td>
            <?php } ?> 
 
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td> 

            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td>

            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td> 

            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($other);
            ?></strong></td> 

            <?php
            if ($is_flight_supp == 0) {
            ?>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($flight); ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($flight); ?></strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($flight); ?></strong></td>
            <?php } ?>
            <?php
            }
            ?>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($train); ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($train); ?></strong></td>    
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" ><strong><?php echo getTwoDecimalNumberFormat($train); ?></strong></td>    
            <?php } ?>
            </tr>
            <!-- service charge -->
            <tr>
            <td colspan="3" align="right" bgcolor="#deb887" ><strong><?php
            if ($financeresult['markupSerType'] == '1') {
              echo 'Guest Mark Up';
            }
            if ($financeresult['markupSerType'] == '2') {
              echo "Guest Service Charge";
            }
            ?>&nbsp;Amount</strong></td>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $singleMarkup = getMarkupCost(${"totalsingle".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$singleMarkup;
            ${"totalsingle".$val} = ${"totalsingle".$val} + $singleMarkup;
            ?></strong></td>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $doubleMarkup = getMarkupCost(${"totaldouble".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$doubleMarkup;
            ${"totaldouble".$val} = ${"totaldouble".$val} + $doubleMarkup;
            ?></strong></td>

            <?php if($twinRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $twinMarkup = getMarkupCost(${"totaltwin".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$twinMarkup;
            ${"totaltwin".$val} = ${"totaltwin".$val} + $twinMarkup;
            ?></strong></td>
            <?php }if($tripleRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $tripleMarkup = getMarkupCost(${"totaltriple".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$tripleMarkup;
            ${"totaltriple".$val} = ${"totaltriple".$val} + $tripleMarkup;
            ?></strong></td>
            <?php }if($quadBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $quadMarkup = getMarkupCost(${"totalquadBed".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$quadMarkup;
            ${"totalquadBed".$val} = ${"totalquadBed".$val} + $quadMarkup;
            ?></strong></td>
            <?php }if($sixBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $sixbedMarkup = getMarkupCost(${"totalSixBed".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$sixbedMarkup;
            ${"totalSixBed".$val} = ${"totalSixBed".$val} + $sixbedMarkup;
            ?></strong></td>
            <?php }if($eightBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $eightMarkup = getMarkupCost(${"totaleightBed".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$eightMarkup;
            ${"totaleightBed".$val} = ${"totaleightBed".$val} + $eightMarkup;
            ?></strong></td>
            <?php }if($tenBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $tenMarkup = getMarkupCost(${"totaltenBed".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$tenMarkup;
            ${"totaltenBed".$val} = ${"totaltenBed".$val} + $tenMarkup;
            ?></strong></td>
            <?php }if($teenBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $teenMarkup = getMarkupCost(${"totalteenBed".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$teenMarkup;
            ${"totalteenBed".$val} = ${"totalteenBed".$val} + $teenMarkup;
            ?></strong></td>
            <?php }if($EBedAdult >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $ebedAMarkup = getMarkupCost(${"totalextraBedA".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$ebedAMarkup;
            ${"totalextraBedA".$val} = ${"totalextraBedA".$val} + $ebedAMarkup;
            ?></strong></td>
            <?php }if($EBedChild >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $ebedCMarkup = getMarkupCost(${"totalextraBedC".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$ebedCMarkup;
            ${"totalextraBedC".$val} = ${"totalextraBedC".$val} + $ebedCMarkup;
            ?></strong></td>
            <?php }if($NBedChild >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $eNbedCMarkup = getMarkupCost(${"totalextraNBedC".$val}, $hotel, $hotelMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$eNbedCMarkup;
            ${"totalextraNBedC".$val} = ${"totalextraNBedC".$val} + $eNbedCMarkup;
            ?></strong></td>
            <?php } ?> 

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $breakfastAMarkup = getMarkupCost(${"totalBreakfastA".$val}, $restaurant, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$breakfastAMarkup;
            ${"totalBreakfastA".$val} = ${"totalBreakfastA".$val} + $breakfastAMarkup;
            ?></strong></td>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $lunchAMarkup = getMarkupCost(${"totalLunchA".$val}, $restaurant, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$lunchAMarkup;
            ${"totalLunchA".$val} = ${"totalLunchA".$val} + $lunchAMarkup;
            ?></strong></td>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $dinnerAMarkup = getMarkupCost(${"totalDinnerA".$val}, $restaurant, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$dinnerAMarkup;
            ${"totalDinnerA".$val} = ${"totalDinnerA".$val} + $dinnerAMarkup;
            ?></strong></td> 

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $breakfastCMarkup = getMarkupCost(${"totalBreakfastC".$val}, $restaurant, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$breakfastCMarkup;
            ${"totalBreakfastC".$val} = ${"totalBreakfastC".$val} + $breakfastCMarkup;
            ?></strong></td>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $lunchCMarkup = getMarkupCost(${"totalLunchC".$val}, $restaurant, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$lunchCMarkup;
            ${"totalLunchC".$val} = ${"totalLunchC".$val} + $lunchCMarkup;
            ?></strong></td>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $dinnerCMarkup = getMarkupCost(${"totalDinnerC".$val}, $restaurant, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$dinnerCMarkup;
            ${"totalDinnerC".$val} = ${"totalDinnerC".$val} + $dinnerCMarkup;
            ?></strong></td>  

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $HAMarkup = getMarkupCost(${"totalHA".$val}, $other, $otherMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$HAMarkup;
            ${"totalHA".$val} = ${"totalHA".$val} + $HAMarkup;
            ?></strong></td>   
            <?php
            if ($is_flight_supp == 0) {
              ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
              echo $flightMarkupA = getMarkupCost(${"totalflightA".$val}, $flight, $flightMarkupType);
              ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$flightMarkupA;
              ${"totalflightA".$val} = ${"totalflightA".$val} + $flightMarkupA;
              ?></strong></td>

            <?php if($paxChild>0){ ?>
                <td align="right" bgcolor="#deb887" ><strong><?php
              echo $flightMarkupC = getMarkupCost(${"totalflightC".$val}, $flight, $flightMarkupType);
              ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$flightMarkupC;
              ${"totalflightC".$val} = ${"totalflightC".$val} + $flightMarkupC;
              ?></strong></td>
            <?php } ?>

            <?php if($paxInfant>0){ ?>
                <td align="right" bgcolor="#deb887" ><strong><?php
              echo $flightMarkupE = getMarkupCost(${"totalflightE".$val}, $flight, $flightMarkupType);
              ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$flightMarkupE;
              ${"totalflightE".$val} = ${"totalflightE".$val} + $flightMarkupE;
              ?></strong></td>
            <?php } ?>
             
            <?php
            }
            ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $trainMarkupA = getMarkupCost(${"totaltrainA".$val}, $train, $trainMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$trainMarkupA;
            ${"totaltrainA".$val} = ${"totaltrainA".$val} + $trainMarkupA;
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $trainMarkupC = getMarkupCost(${"totaltrainC".$val}, $train, $trainMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$trainMarkupC;
            ${"totaltrainC".$val} = ${"totaltrainC".$val} + $trainMarkupC;
            ?></strong></td>  
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $trainMarkupE = getMarkupCost(${"totaltrainE".$val}, $train, $trainMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$trainMarkupE;
            ${"totaltrainE".$val} = ${"totaltrainE".$val} + $trainMarkupE;
            ?></strong></td>  
            <?php } ?>
            </tr>
            
            <?php 
            if ($isTotalLE == 1) { ?>
            <tr> 
                <td colspan="3" align="right"  bgcolor="#dec7c7"><strong><?php
                if ($financeresult['markupSerType'] == '1') {
                echo 'Local Escort Mark Up';
                }
                if ($financeresult['markupSerType'] == '2') {
                echo "Local Escort Service Charge";
                }
                ?>&nbsp;Amount</strong></td>

                <td align="right"  bgcolor="#dec7c7"><strong><?php
                // LOCAL ESCORT RATE
                $singleMarkupLE = getMarkupCost(${"totalsingleLE".$val}, $hotel, $hotelMarkupType);
                echo $singleMarkupLE;
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$singleMarkupLE;
                ${"totalsingleLE".$val} = ${"totalsingleLE".$val} + $singleMarkupLE;
                ?></strong></td>

                <td align="right"  bgcolor="#dec7c7"><strong><?php
                // LOCAL ESCORT RATE
                $doubleMarkupLE = getMarkupCost(${"totaldoubleLE".$val}, $hotel, $hotelMarkupType);
                echo $doubleMarkupLE;
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$doubleMarkupLE;
                ${"totaldoubleLE".$val} = ${"totaldoubleLE".$val} + $doubleMarkupLE;
                ?></strong></td>

                <?php if($twinRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tripleRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($quadBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($sixBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($eightBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($teenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedAdult >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($NBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php } ?> 

                <td align="right"  bgcolor="#dec7c7"><strong><?php
                echo $breakfastAMarkupLE = getMarkupCost(${"totalBreakfastALE".$val}, $restaurant, $restaurantMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$breakfastAMarkupLE;
                ${"totalBreakfastALE".$val} = ${"totalBreakfastALE".$val} + $breakfastAMarkupLE;
                ?></strong></td>

                <td align="right"  bgcolor="#dec7c7"><strong><?php
                echo $lunchAMarkupLE = getMarkupCost(${"totalLunchALE".$val}, $restaurant, $restaurantMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$lunchAMarkupLE;
                ${"totalLunchALE".$val} = ${"totalLunchALE".$val} + $lunchAMarkupLE;
                ?></strong></td>

                <td align="right"  bgcolor="#dec7c7"><strong><?php
                echo $dinnerAMarkupLE = getMarkupCost(${"totalDinnerALE".$val}, $restaurant, $restaurantMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$dinnerAMarkupLE;
                ${"totalDinnerALE".$val} = ${"totalDinnerALE".$val} + $dinnerAMarkupLE;
                ?></strong></td> 

                <td align="right"  bgcolor="#dec7c7"><strong></strong></td>
                <td align="right"  bgcolor="#dec7c7"><strong></strong></td>
                <td align="right"  bgcolor="#dec7c7"><strong></strong></td>
                <td align="right"  bgcolor="#dec7c7"><strong></strong></td>
            
                <?php
                if ($is_flight_supp == 0) {
                ?>
                <td align="right" bgcolor="#dec7c7" ><strong><?php
                echo $flightMarkupALE = getMarkupCost(${"totalflightALE".$val}, $flight, $flightMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$flightMarkupALE;
                ${"totalflightALE".$val} = ${"totalflightALE".$val} + $flightMarkupALE;
                ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right"  bgcolor="#dec7c7"></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right"  bgcolor="#dec7c7"></td>
                <?php } ?>
                <?php
                }
                ?>
              
                <td align="right" bgcolor="#dec7c7" ><strong><?php
                echo $trainMarkupALE = getMarkupCost(${"totaltrainALE".$val}, $train, $trainMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$trainMarkupALE;
                ${"totaltrainALE".$val} = ${"totaltrainALE".$val} + $trainMarkupALE;
                ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right"  bgcolor="#dec7c7"></td>  
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right"  bgcolor="#dec7c7"></td>  
                <?php } ?>
            </tr>
            <?php 
            }
            if ($isTotalFE == 1) { ?>
            <tr> 
                <td colspan="3" align="right" bgcolor="#d4d5f0"><strong><?php
                if ($financeresult['markupSerType'] == '1') {
                echo 'Foreign Escort Mark Up';
                }
                if ($financeresult['markupSerType'] == '2') {
                echo "Foreign Escort Service Charge";
                }
                ?>&nbsp;Amount</strong></td>

                <td align="right" bgcolor="#d4d5f0"><strong><?php
                // FOREIGN ESCORT RATE
                $singleMarkupFE = getMarkupCost(${"totalsingleFE".$val}, $hotel, $hotelMarkupType);
                echo $singleMarkupFE;
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$singleMarkupFE;
                ${"totalsingleFE".$val} = ${"totalsingleFE".$val} + $singleMarkupFE;
                ?></strong></td>

                <td align="right" bgcolor="#d4d5f0"><strong><?php
                // FOREIGN ESCORT RATE
                $doubleMarkupFE = getMarkupCost(${"totaldoubleFE".$val}, $hotel, $hotelMarkupType);
                echo $doubleMarkupFE;
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$doubleMarkupFE;
                ${"totaldoubleFE".$val} = ${"totaldoubleFE".$val} + $doubleMarkupFE;
                ?></strong></td>
                <?php if($twinRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tripleRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($quadBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($sixBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($eightBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($teenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedAdult >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($NBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php } ?> 

                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo $breakfastAMarkupFE = getMarkupCost(${"totalBreakfastAFE".$val}, $restaurant, $restaurantMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$breakfastAMarkupFE;
                ${"totalBreakfastAFE".$val} = ${"totalBreakfastAFE".$val} + $breakfastAMarkupFE;
                ?></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo $lunchAMarkupFE = getMarkupCost(${"totalLunchAFE".$val}, $restaurant, $restaurantMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$lunchAMarkupFE;
                ${"totalLunchAFE".$val} = ${"totalLunchAFE".$val} + $lunchAMarkupFE;
                ?></strong></td>

                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo $dinnerAMarkupFE = getMarkupCost(${"totalDinnerAFE".$val}, $restaurant, $restaurantMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$dinnerAMarkupFE;
                ${"totalDinnerAFE".$val} = ${"totalDinnerAFE".$val} + $dinnerAMarkupFE;
                ?></strong></td> 

                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
            
                <?php
                if ($is_flight_supp == 0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><strong><?php
                    echo $flightMarkupAFE = getMarkupCost(${"totalflightAFE".$val}, $flight, $flightMarkupType);
                    ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$flightMarkupAFE;
                    ${"totalflightAFE".$val} = ${"totalflightAFE".$val} + $flightMarkupAFE;
                    ?></strong></td>
                    <?php if($paxChild>0){ ?>
                    <td align="right" bgcolor="#d4d5f0"></td>
                    <?php } ?>
                    <?php if($paxInfant>0){ ?>
                    <td align="right" bgcolor="#d4d5f0"></td>
                    <?php } ?>
                    <?php
                }
                ?> 
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo $trainMarkupAFE = getMarkupCost(${"totaltrainAFE".$val}, $train, $trainMarkupType);
                ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$trainMarkupAFE;
                ${"totaltrainAFE".$val} = ${"totaltrainAFE".$val} + $trainMarkupAFE;
                ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right" bgcolor="#d4d5f0"></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" bgcolor="#d4d5f0"></td>
                <?php } ?>
            </tr>
            <?php } ?>
            <!-- grand total -->
            <tr>
            <td colspan="3" align="right" bgcolor="#deb887" ><strong>Grand&nbsp;Total</strong></td>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalsingle".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaldouble".$val});
            ?></strong></td>  
            <?php if($twinRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltwin".$val});
            ?></strong></td>
            <?php }if($tripleRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltriple".$val});
            ?></strong></td>
            <?php }if($quadBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalquadBed".$val});
            ?></strong></td>
            <?php }if($sixBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalSixBed".$val});
            ?></strong></td>
            <?php }if($eightBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaleightBed".$val});
            ?></strong></td>
            <?php }if($tenBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltenBed".$val});
            ?></strong></td>
            <?php }if($teenBedRoom >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalteenBed".$val});
            ?></strong></td>
            <?php }if($EBedAdult >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalextraBedA".$val});
            ?></strong></td>
            <?php }if($EBedChild >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalextraBedC".$val});
            ?></strong></td>
            <?php }if($NBedChild >0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalextraNBedC".$val});
            ?></strong></td>
            <?php } ?> 
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalBreakfastA".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalLunchA".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalDinnerA".$val});
            ${"totalmealA".$val} = 0;
            ${"totalmealA".$val} = getTwoDecimalNumberFormat(${"totalBreakfastA".$val} + ${"totalLunchA".$val} + ${"totalDinnerA".$val});
            ?></strong></td>  
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalBreakfastC".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalLunchC".$val});
            ?></strong></td>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalDinnerC".$val});
            ${"totalmealC".$val} = 0;
            ${"totalmealC".$val} = getTwoDecimalNumberFormat(${"totalBreakfastC".$val} + ${"totalLunchC".$val} + ${"totalDinnerC".$val});
            ?></strong></td>    
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalHA".$val});
            ?></strong></td>
            <?php
            if ($is_flight_supp == 0) {
            ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalflightA".$val});
            ?></strong></td>

            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalflightC".$val});
            ?></strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalflightE".$val});
            ?></strong></td>
            <?php } ?>
            <?php
            }
            ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltrainA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltrainC".$val});
            ?></strong>
            </td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totaltrainE".$val});
            ?></strong>
            </td>
            <?php } ?>
            </tr>
            <?php 
            if ($isTotalLE == 1) { ?>
                <tr>

                <td colspan="3" align="right" bgcolor="#dec7c7"><strong>Local Escort&nbsp;Grand&nbsp;Total</strong></td>

                <td align="right" bgcolor="#dec7c7"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalsingleLE".$val});
                ?></strong></td>

                <td align="right" bgcolor="#dec7c7"><strong><?php
                echo getTwoDecimalNumberFormat(${"totaldoubleLE".$val});
                ?></strong></td> 
                <?php if($twinRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tripleRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($quadBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($sixBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($eightBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($teenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedAdult >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($NBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php } ?> 
                <td align="right" bgcolor="#dec7c7"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalBreakfastALE".$val});
                ?></strong></td>
                <td align="right" bgcolor="#dec7c7"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalLunchALE".$val});
                ?></strong></td>
                <td align="right" bgcolor="#dec7c7"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalDinnerALE".$val});
                ${"totalmealALE".$val} = 0;
                ${"totalmealALE".$val} = getTwoDecimalNumberFormat(${"totalBreakfastALE".$val} + ${"totalLunchALE".$val} + ${"totalDinnerALE".$val});
                ?></strong></td>    
                <td align="right" bgcolor="#dec7c7"><strong></strong></td>
                <td align="right" bgcolor="#dec7c7"><strong></strong></td>
                <td align="right" bgcolor="#dec7c7"><strong></strong></td>
                <td align="right" bgcolor="#dec7c7"><strong></strong></td> 
                <?php
                if ($is_flight_supp == 0) {
                ?>
                <td align="right" bgcolor="#dec7c7"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalflightALE".$val});
                ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right" bgcolor="#dec7c7"></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" bgcolor="#dec7c7"></td>
                <?php } ?>
                <?php
                }
                ?> 
                <td align="right" bgcolor="#dec7c7"><strong><?php
                echo getTwoDecimalNumberFormat(${"totaltrainALE".$val});
                ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right" bgcolor="#dec7c7"></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" bgcolor="#dec7c7"></td>
                <?php } ?>
                </tr>
                <?php 
            } 
            if ($isTotalFE == 1) { ?>
                <tr>
                <td colspan="3" align="right" bgcolor="#d4d5f0"><strong>Foreign Escort Grand&nbsp;Total</strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                // FOREIGN ESCORT RATE
                echo getTwoDecimalNumberFormat(${"totalsingleFE".$val});
                ?></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo getTwoDecimalNumberFormat(${"totaldoubleFE".$val});
                ?></strong></td> 
                <?php if($twinRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tripleRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($quadBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($sixBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($eightBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($tenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($teenBedRoom >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedAdult >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($EBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php }if($NBedChild >0){ ?>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php } ?> 
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalBreakfastAFE".$val});
                ?></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalLunchAFE".$val});
                ?></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalDinnerAFE".$val});
                ${"totalmealAFE".$val} = 0;
                ${"totalmealAFE".$val} = getTwoDecimalNumberFormat(${"totalBreakfastAFE".$val} + ${"totalLunchAFE".$val} + ${"totalDinnerAFE".$val});
                ?></strong></td>  
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <td align="right" bgcolor="#d4d5f0"><strong></strong></td>
                <?php
                if ($is_flight_supp == 0) {
                ?>
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo getTwoDecimalNumberFormat(${"totalflightAFE".$val});
                ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right" bgcolor="#d4d5f0"></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" bgcolor="#d4d5f0"></td>
                <?php } ?> 
                <?php
                }
                ?>
                <td align="right" bgcolor="#d4d5f0"><strong><?php
                echo getTwoDecimalNumberFormat(${"totaltrainAFE".$val});
                ?></strong></td>
                <?php if($paxChild>0){ ?>
                <td align="right" bgcolor="#d4d5f0"></td>
                <?php } ?>
                <?php if($paxInfant>0){ ?>
                <td align="right" bgcolor="#d4d5f0"></td>
                <?php } ?>
                </tr>
                <?php 
            } 
        }
        ?>
        </table>
        <br>

        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000" style="font-size:12px;">
        <tr>
            <td width="45" align="left" bgcolor="#F5F5F5"><strong>Day/Date</strong></td>
            <td align="left" bgcolor="#F5F5F5"><strong>City </strong></td>
            <?php
            $rsa2 = "";
            $rsa2=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select totalPax from '._QUOTATION_TRANSFER_MASTER_.' where quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 ) and status=1 order by fromRange asc'); 
            if(mysqli_num_rows($rsa2)>0){  
            ?>
            <td align="center" bgcolor="#F5F5F5" colspan="<?php echo mysqli_num_rows($rsa2); ?>"><strong>Transportation</strong></td> 
            <?php 
            } 
            ?>
            <?php
            $rsa21 = "";
            $rsa21=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select slabId from '._QUOTATION_GUIDE_MASTER_.' where quotationId="' . $quotationId . '" and isGuestType=1 ) and status=1 order by fromRange asc'); 
            if(mysqli_num_rows($rsa21)>0){  
            ?>
            <td align="center" bgcolor="#F5F5F5" colspan="<?php echo mysqli_num_rows($rsa21); ?>"><strong></strong></td> 
            <?php 
            }
            ?> 
            <td width="40"  colspan="<?php echo $AdultChildCols; ?>" align="center" bgcolor="#F5F5F5" <?php echo isHideMster('ferryMaster'); ?>><strong>Ferry</strong></td>
            <?php 
            $rsc22 = "";
            $rsc22=GetPageRecord('*','quotationCruiseMaster',' quotationId="'.$quotationId.'" order by id asc'); 
            if(mysqli_num_rows($rsc22)>0){  ?>
            <td width="40"  colspan="<?php echo $AdultChildCols; ?>" align="center" bgcolor="#F5F5F5"><strong>Cruise</strong></td>
            <?php } ?>
            <td width="40"  colspan="<?php echo $AdultChildCols; ?>" align="center" bgcolor="#F5F5F5"><strong>Entrance</strong></td>
            <td width="40"  colspan="<?php echo $AdultChildCols; ?>" align="center" bgcolor="#F5F5F5"><strong>Sightseeing</strong></td>

            <td width="40"  colspan="<?php echo $AdultChildCols; ?>" align="center" bgcolor="#F5F5F5"><strong>Restuarant</strong></td>
            <td width="40"  colspan="<?php echo $AdultChildCols+1; ?>" align="center" bgcolor="#F5F5F5"><strong>Additional</strong></td>

            <td align="center" bgcolor="#F5F5F5" > <strong>Per Pax</strong></td>
        </tr>
        <tr>
            <td width="118" align="left" bgcolor="#F5F5F5">&nbsp;</td>
            <td width="94" align="left" bgcolor="#F5F5F5">&nbsp;</td>
            <?php
            $rsa2 = "";
            $rsa2=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select totalPax from '._QUOTATION_TRANSFER_MASTER_.' where quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 ) and status=1 order by fromRange asc'); 
            if(mysqli_num_rows($rsa2)>0){  
            ?>
            <td align="center" bgcolor="#F5F5F5" colspan="<?php echo mysqli_num_rows($rsa2); ?>"><strong>Transport</strong></td> 
            <?php 
            } 
            ?>
            <?php
            $rsa21 = "";
            $rsa21=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select slabId from '._QUOTATION_GUIDE_MASTER_.' where quotationId="' . $quotationId . '" and isGuestType=1 ) and status=1 order by fromRange asc'); 
            if(mysqli_num_rows($rsa21)>0){  
            ?>
            <td align="center" bgcolor="#F5F5F5" colspan="<?php echo mysqli_num_rows($rsa21); ?>"><strong>Guide</strong></td> 
            <?php 
            } 
            ?>
            
             
            <!-- Below Ferry cols-->
            <td align="right" bgcolor="#F5F5F5" <?php echo isHideMster('ferryMaster'); ?>><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#F5F5F5" <?php echo isHideMster('ferryMaster'); ?>><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#F5F5F5" <?php echo isHideMster('ferryMaster'); ?>><strong>Infant</strong></td>
            <?php } ?>

            <?php 
            $rsc22 = "";
            $rsc22=GetPageRecord('*','quotationCruiseMaster',' quotationId="'.$quotationId.'" order by id asc'); 
            if(mysqli_num_rows($rsc22)>0){  ?>
             <!-- Below Cruise cols-->
             <td align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
            <?php } } ?>

            <!-- Below Entrance cols-->
            <td align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
            <?php } ?>
            <!-- Below Sightseeing cols-->
            <td align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
            <?php } ?>

            <!-- Below Restaurant cols-->
            <td align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
            <?php } ?>
            
            <!-- Below Additional cols-->
            <td align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Infant</strong></td>
            <?php } ?>
            <td align="right" bgcolor="#F5F5F5"><strong>Group</strong></td>

            <!-- per person block -->
            <td align="right" bgcolor="#F5F5F5"><strong>Porter</strong></td>
        </tr>
        <?php
        // main containers
        ${"totalExtra".$val} = ${"totalentcostA".$val} = ${"totalFerryCostA" . $val} = ${"totalCruiseCostA" . $val} = ${"totalFerryCostC" . $val} = ${"totalCruiseCostC" . $val} = ${"totalentcostC".$val} = ${"totalFerryCostE" . $val} = ${"totalCruiseCostE" . $val} = ${"totalentcostE".$val} = ${"totalactcostA" . $val} = ${"totalactcostC" . $val} = ${"totalactcostE" . $val} = ${"transport".$val} = ${"totalPorter".$val} = ${"totalRestaurantCostA".$val} = ${"totalRestaurantCostC".$val} = ${"totalExtraCostPP".$val} = 0;
        $transferCostA =$transferCostC =$transferCostE =0;
        
        //____NEW LOOP________________________________________
        $rsp = GetPageRecord('*', _QUOTATION_MASTER_, ' id="' . $quotationId . '"');
        $quotationData = mysqli_fetch_array($rsp);
        $quotationId = $quotationData['id'];
        $dayL = 1;
        $QueryDaysQuery = GetPageRecord('*', 'newQuotationDays', ' quotationId="' . $quotationData['id'] . '" and addstatus=0 order by srdate asc');
        while ($QueryDaysData = mysqli_fetch_array($QueryDaysQuery)) {
            $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
            ?>
            <tr>
            <td width="118" align="left">D<?php
            echo str_pad($dayL, 2, '0', STR_PAD_LEFT);
            if ($resultpage['dayWise'] == 1) {
            echo " - " . date('d-m-Y', strtotime($dayDate));
            }
            ?>
            </td>
            <td width="94" align="left">
            <?php
            echo getDestination($QueryDaysData['cityId']);
            ?>    
            </td> 
            <?php
            $rsa3 = "";
            $rsa3=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select totalPax from '._QUOTATION_TRANSFER_MASTER_.' where quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 ) and status=1 order by fromRange asc'); 
            while($transferSlabD=mysqli_fetch_array($rsa3)){  
                $slabId3 = $transferSlabD['id'].'C'.$val;
            ?>
            <td align="right">
            <?php
            $totaltransportSameDay=$transferCostA2 = $transferCostC2 = $transferCostE2 = 0;
            $rsa2 = "";
            $rsa2 = GetPageRecord('*', _QUOTATION_TRANSFER_MASTER_, ' quotationId="' . $quotationId . '" and fromDate="' . $dayDate . '" and totalPax = "' . $transferSlabD['id'].'"  and isGuestType=1 and isSupplement=0 order by fromDate asc');
            while ($qTransferData = mysqli_fetch_array($rsa2)) {

                //cost break up info
                if($qTransferData['transferType'] == 1){
                    if($paxAdult>0){
                        $transferCostA2=$transferCostA2+convert_to_base($qTransferData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($qTransferData['adultCost'],$qTransferData['gstTax'],$qTransferData['markupCost'],$qTransferData['markupType'])*$paxAdult));
                    } 
                    if($paxChild>0){
                        $transferCostC2=$transferCostC2+convert_to_base($qTransferData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($qTransferData['childCost'],$qTransferData['gstTax'],$qTransferData['markupCost'],$qTransferData['markupType'])*$paxChild));
                    } 
                    if($paxInfant>0){
                        $transferCostE2=$transferCostE2+convert_to_base($qTransferData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($qTransferData['infantCost'],$qTransferData['gstTax'],$qTransferData['markupCost'],$qTransferData['markupType'])*$paxInfant));
                    }
                }else{
                    if ($qTransferData['costType'] == 3) {
                        $vehicleCost = strip($qTransferData['vehicleCost'])+strip($qTransferData['parkingFee'])+strip($qTransferData['representativeEntryFee'])+strip($qTransferData['assistance'])+strip($qTransferData['guideAllowance'])+strip($qTransferData['interStateAndToll'])+strip($qTransferData['miscellaneous']); 

                        $totaltransportSameDay=$totaltransportSameDay+convert_to_base($qTransferData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($vehicleCost,$qTransferData['gstTax'],$qTransferData['markupCost'],$qTransferData['markupType']) * $qTransferData['noOfVehicles'] * $qTransferData['distance']));
                    }else{ 
                        $vehicleCost = strip($qTransferData['vehicleCost'])+strip($qTransferData['parkingFee'])+strip($qTransferData['representativeEntryFee'])+strip($qTransferData['assistance'])+strip($qTransferData['guideAllowance'])+strip($qTransferData['interStateAndToll'])+strip($qTransferData['miscellaneous']); 

                        $totaltransportSameDay=$totaltransportSameDay+convert_to_base($qTransferData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($vehicleCost,$qTransferData['gstTax'],$qTransferData['markupCost'],$qTransferData['markupType']) * $qTransferData['noOfVehicles']));
                    }

                }
            } 

            ${"transferCostA" . $slabId3} = ${"transferCostA" . $slabId3} + $transferCostA2;
            ${"transferCostC" . $slabId3} = ${"transferCostC" . $slabId3} + $transferCostC2;
            ${"transferCostE" . $slabId3} = ${"transferCostE" . $slabId3} + $transferCostE2;
            ${"transport" . $slabId3} = ${"transport" . $slabId3} + $totaltransportSameDay;
 
            echo getTwoDecimalNumberFormat($totaltransportSameDay+$transferCostA2+$transferCostC2+$transferCostE2);
            ?>
            </td>
            <?php
            } 
            ?>

            <?php
            $rsa3 = "";
            $rsa3=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select slabId from '._QUOTATION_GUIDE_MASTER_.' where quotationId="' . $quotationId . '" and isGuestType=1 ) and status=1 order by fromRange asc'); 
            while($guideSlabD=mysqli_fetch_array($rsa3)){  
                $slabId4 = $guideSlabD['id'].'C'.$val;
                ?>
                <td align="right">
                <?php
                $totalGuideSameDay=0;
                $ddd3 = "";
                $ddd3 = GetPageRecord('*', _QUOTATION_GUIDE_MASTER_, ' quotationId="' . $quotationId . '" and fromDate="' . $dayDate . '" and slabId = "' . $guideSlabD['id'].'" and isGuestType=1 order by fromDate asc');
                while ($qGuideData = mysqli_fetch_array($ddd3)) {
                $guideCost = ($qGuideData['price']+$qGuideData['otherCost']+$qGuideData['languageAllowance'])*$qGuideData['totalDays'];
                $totalGuideSameDay=$totalGuideSameDay+convert_to_base($qGuideData['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($guideCost,$qGuideData['gstTax'],$qGuideData['markupCost'],$qGuideData['markupType']));
                }
                echo getTwoDecimalNumberFormat($totalGuideSameDay);
                ${"totalGuide" . $slabId4} = ${"totalGuide" . $slabId4} + $totalGuideSameDay;
                ?>
                </td>
                <?php
            } 
            ?>
            <td align="right" <?php echo isHideMster('ferryMaster'); ?>><?php
                $totalFerrySameDayA = $totalFerrySameDayC = $totalFerrySameDayE = 0;
                $ddd2 = "";
                $ddd2 = GetPageRecord('*', _QUOTATION_FERRY_MASTER_, ' 1 and fromDate="' . $dayDate . '" and quotationId="' . $quotationId . '" ');
                while ($qFerryData = mysqli_fetch_array($ddd2)) {
                    $totalFerrySameDayA = $totalFerrySameDayA + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup(round(($qFerryData['adultCost']+$qFerryData['processingfee']+$qFerryData['miscCost'])*$qFerryData['adultPax']),$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']));
                    $totalFerrySameDayC = $totalFerrySameDayC + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup(round(($qFerryData['childCost']+$qFerryData['processingfee']+$qFerryData['miscCost'])*$qFerryData['childPax']),$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']));
                    $totalFerrySameDayE = $totalFerrySameDayE + convert_to_base($qFerryData['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup(round(($qFerryData['infantCost']+$qFerryData['processingfee']+$qFerryData['miscCost'])*$qFerryData['infantPax']),$qFerryData['gstTax'],$qFerryData['markupCost'],$qFerryData['markupType']));
                }
                echo getTwoDecimalNumberFormat($totalFerrySameDayA);
                ${"totalFerryCostA" . $val} = ${"totalFerryCostA" . $val} + $totalFerrySameDayA;
                ${"totalFerryCostC" . $val} = ${"totalFerryCostC" . $val} + $totalFerrySameDayC;
                ${"totalFerryCostE" . $val} = ${"totalFerryCostE" . $val} + $totalFerrySameDayE;
                ?>
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" <?php echo isHideMster('ferryMaster'); ?> ><?php
                echo getTwoDecimalNumberFormat($totalFerrySameDayC);
                ?>
            </td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" <?php echo isHideMster('ferryMaster'); ?> ><?php
                echo getTwoDecimalNumberFormat($totalFerrySameDayE);
                ?>
            </td>
            <?php } 
            $rsc22 = "";
            $rsc22=GetPageRecord('*','quotationCruiseMaster',' quotationId="'.$quotationId.'" order by id asc'); 
            if(mysqli_num_rows($rsc22)>0){ 
                ?>
                <td align="right"><?php
                $totalFerrySameDayA = $totalFerrySameDayC = $totalFerrySameDayE = 0;
                $ddd2 = "";
                $ddd2 = GetPageRecord('*', 'quotationCruiseMaster', ' 1 and fromDate="' . $dayDate . '" and quotationId="' . $quotationId . '" ');
                while ($qCruiseData = mysqli_fetch_array($ddd2)) {
                    $totalCruiseSameDayA = $totalCruiseSameDayA + convert_to_base($qCruiseData['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup(round(($qCruiseData['adultCost']+$qCruiseData['processingfee']+$qCruiseData['miscCost'])*$qCruiseData['adultPax']),$qCruiseData['gstTax'],$qCruiseData['markupCost'],$qCruiseData['markupType']));
                    $totalCruiseSameDayC = $totalCruiseSameDayC + convert_to_base($qCruiseData['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup(round(($qCruiseData['childCost']+$qCruiseData['processingfee']+$qCruiseData['miscCost'])*$qCruiseData['childPax']),$qCruiseData['gstTax'],$qCruiseData['markupCost'],$qCruiseData['markupType']));
                    $totalCruiseSameDayE = $totalCruiseSameDayE + convert_to_base($qCruiseData['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup(round(($qCruiseData['infantCost']+$qCruiseData['processingfee']+$qCruiseData['miscCost'])*$qCruiseData['infantPax']),$qCruiseData['gstTax'],$qCruiseData['markupCost'],$qCruiseData['markupType']));
                }
                echo getTwoDecimalNumberFormat($totalCruiseSameDayA);
                ${"totalCruiseCostA" . $val} = ${"totalCruiseCostA" . $val} + $totalCruiseSameDayA;
                ${"totalCruiseCostC" . $val} = ${"totalCruiseCostC" . $val} + $totalCruiseSameDayC;
                ${"totalCruiseCostE" . $val} = ${"totalCruiseCostE" . $val} + $totalCruiseSameDayE;
                ?>
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><?php
                echo getTwoDecimalNumberFormat($totalCruiseSameDayC);
                ?>
            </td>
            <?php } if ($paxInfant>0) { ?>
            <td align="right" ><?php
                echo getTwoDecimalNumberFormat($totalCruiseSameDayE);
                ?>
            </td>
            <?php } } ?>
            
            <td align="right" ><?php
            $totalEntSameDayA = $totalEntSameDayC = $totalEntSameDayE = $entCostA = $entCostC = $entCostE = 0;
            $d = GetPageRecord('*', _QUOTATION_ENTRANCE_MASTER_, 'quotationId="' . $quotationId . '" and  fromDate="' . $dayDate . '"   order by id asc');
            while ($entrouteInfo = mysqli_fetch_array($d)) {

                $qActTotalPax = ($entrouteInfo['adultPax']+$entrouteInfo['childPax']+$entrouteInfo['infantPax']);
                if($entrouteInfo['transferType']!=2){
                    $markupCostEnt = $entrouteInfo['markupCost'];
                    $markupTypeEnt = $entrouteInfo['markupType'];
                }

                if($entrouteInfo['transferType'] == 1){
                    $entCostA = ($entrouteInfo['ticketAdultCost']+$entrouteInfo['adultCost']+$entrouteInfo['repCost']);            
                    $entCostC = ($entrouteInfo['ticketchildCost']+$entrouteInfo['childCost']+$entrouteInfo['repCost']);            
                    $entCostE = ($entrouteInfo['ticketinfantCost']+$entrouteInfo['infantCost']+$entrouteInfo['repCost']);            
                }elseif($entrouteInfo['transferType'] == 2){
                    $entVehicleCostpvt = $entrouteInfo['vehicleCost']*$entrouteInfo['noOfVehicles'];
                    $entMarkupCost = getMarkupCost($entVehicleCostpvt,$entrouteInfo['markupCost'],$entrouteInfo['markupType']);
                    $entVehicleCost = $entVehicleCostpvt+$entMarkupCost;
                    $entCostA = $entrouteInfo['ticketAdultCost']+($entVehicleCost/$qActTotalPax)+$entrouteInfo['repCost'];
                    $entCostC = $entrouteInfo['ticketchildCost']+($entVehicleCost/$qActTotalPax)+$entrouteInfo['repCost'];
                    $entCostE = $entrouteInfo['ticketinfantCost']+($entVehicleCost/$qActTotalPax)+$entrouteInfo['repCost'];
                }else{
                    $entCostA = ($entrouteInfo['ticketAdultCost']);
                    $entCostC = ($entrouteInfo['ticketchildCost']);       
                    $entCostE = ($entrouteInfo['ticketinfantCost']);
                }

                $entCostA=convert_to_base($entrouteInfo['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($entCostA,$entrouteInfo['gstTax'],$markupCostEnt,$markupTypeEnt));
                $entCostC=convert_to_base($entrouteInfo['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($entCostC,$entrouteInfo['gstTax'],$markupCostEnt,$markupTypeEnt));
                $entCostE=convert_to_base($entrouteInfo['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($entCostE,$entrouteInfo['gstTax'],$markupCostEnt,$markupTypeEnt));


                $totalEntSameDayA = $totalEntSameDayA + ($entCostA*$entrouteInfo['adultPax']);
                $totalEntSameDayC = $totalEntSameDayC + ($entCostC*$entrouteInfo['childPax']);
                $totalEntSameDayE = $totalEntSameDayE + ($entCostE*$entrouteInfo['infantPax']);

             }
             
            echo getTwoDecimalNumberFormat($totalEntSameDayA);
            ${"totalentcostA".$val} = (${"totalentcostA".$val} + trim($totalEntSameDayA));
            ${"totalentcostC".$val} = (${"totalentcostC".$val} + trim($totalEntSameDayC));
            ${"totalentcostE".$val} = (${"totalentcostE".$val} + trim($totalEntSameDayE));
            ?>  
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalEntSameDayC); ?></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalEntSameDayE); ?></td>
            <?php } ?>
          <!-- Sightseeing block below -->
            <td align="right" ><?php
            $totalActSameDayA = $totalActSameDayC = $totalActSameDayE = $ActCostA = $ActCostC = $ActCostE = 0;
            $d = GetPageRecord('*','quotationOtherActivitymaster', 'quotationId="'.$quotationId.'" and  fromDate="' .$dayDate. '"   order by id asc');
            while ($activityInfo = mysqli_fetch_array($d)) {
                if($activityInfo['transferType']!=2 && $activityInfo['transferType']!=3){
                    $markupTypeAct = $activityInfo['markupType'];
                    $markupCostAct = $activityInfo['markupCost'];
                }
                

                $qActTotalPax = ($activityInfo['adultPax']+$activityInfo['childPax']+$activityInfo['infantPax']);

                if($activityInfo['transferType'] == 1){
                    $actCostA = ($activityInfo['ticketAdultCost']+$activityInfo['adultCost']+$activityInfo['repCost']);            
                    $actCostC = ($activityInfo['ticketchildCost']+$activityInfo['childCost']+$activityInfo['repCost']);            
                    $actCostE = ($activityInfo['ticketinfantCost']+$activityInfo['infantCost']+$activityInfo['repCost']);            
                }elseif($activityInfo['transferType'] == 2 || $activityInfo['transferType'] == 3){
                    $actVehicleCostpvt = $activityInfo['vehicleCost']*$activityInfo['noOfVehicles'];
                    $actVehicleCost = $actVehicleCostpvt + (getMarkupCost($actVehicleCostpvt,$activityInfo['markupCost'],$activityInfo['markupType']));
                    $actCostA = $activityInfo['ticketAdultCost']+($actVehicleCost/$qActTotalPax)+$activityInfo['repCost'];
                    $actCostC = $activityInfo['ticketchildCost']+($actVehicleCost/$qActTotalPax)+$activityInfo['repCost'];
                    $actCostE = $activityInfo['ticketinfantCost']+($actVehicleCost/$qActTotalPax)+$activityInfo['repCost'];
                }else{
                    $actCostA = ($activityInfo['ticketAdultCost']);
                    $actCostC = ($activityInfo['ticketchildCost']);       
                    $actCostE = ($activityInfo['ticketinfantCost']);
                }

                $actCostA=convert_to_base($activityInfo['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($actCostA,$activityInfo['gstTax'],$markupCostAct,$markupTypeAct));
                $actCostC=convert_to_base($activityInfo['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($actCostC,$activityInfo['gstTax'],$markupCostAct,$markupTypeAct));
                $actCostE=convert_to_base($activityInfo['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($actCostE,$activityInfo['gstTax'],$markupCostAct,$markupTypeAct));


                $totalActSameDayA = $totalActSameDayA + ($actCostA*$activityInfo['adultPax']);
                $totalActSameDayC = $totalActSameDayC + ($actCostC*$activityInfo['childPax']);
                $totalActSameDayE = $totalActSameDayE + ($actCostE*$activityInfo['infantPax']);
                

             }
            echo getTwoDecimalNumberFormat($totalActSameDayA);
            ${"totalactcostA".$val} = (${"totalactcostA".$val} + trim($totalActSameDayA));
            ${"totalactcostC".$val} = (${"totalactcostC".$val} + trim($totalActSameDayC));
            ${"totalactcostE".$val} = (${"totalactcostE".$val} + trim($totalActSameDayE));
            ?>  
            </td> 

            <?php if($paxChild>0){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalActSameDayC); ?></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalActSameDayE); ?></td>
            <?php } ?>

            <td align="right"><?php
            $totalRestCostC = $totalRestCostA= $totalRestCostE= 0;
            $d20 = GetPageRecord('*', 'quotationInboundmealplanmaster', 'quotationId="' . $quotationId . '" and  fromDate="' . $dayDate . '" order by id asc');
            while ($restaurantData = mysqli_fetch_array($d20)){
                $totalRestCostA = $totalRestCostA + convert_to_base($restaurantData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($restaurantData['adultCost'],$restaurantData['gstTax'],$restaurantData['markupCost'],$restaurantData['markupType']))*$restaurantData['adultPax']); 
                $totalRestCostC = $totalRestCostC + convert_to_base($restaurantData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($restaurantData['childCost'],$restaurantData['gstTax'],$restaurantData['markupCost'],$restaurantData['markupType']))*$restaurantData['childPax']);
                $totalRestCostE = $totalRestCostE + convert_to_base($restaurantData['currencyValue'],$baseCurrencyVal,(getCostWithGSTID_Markup($restaurantData['infantCost'],$restaurantData['gstTax'],$restaurantData['markupCost'],$restaurantData['markupType']))*$restaurantData['infantPax']);
            }
            echo getTwoDecimalNumberFormat($totalRestCostA);

            ${"totalRestaurantCostA".$val} = (${"totalRestaurantCostA".$val} + $totalRestCostA);
            ${"totalRestaurantCostC".$val} = (${"totalRestaurantCostC".$val} + $totalRestCostC);
            ${"totalRestaurantCostE".$val} = (${"totalRestaurantCostE".$val} + $totalRestCostE);
            ?>
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalRestCostC); ?></td>
            <?php } ?>
            <?php if($paxInfant>0){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalRestCostE); ?></td>
            <?php } ?>

           <!-- extra additionals cost 2 columns --> 
           <td align="right" ><?php
            $totalExtraSameDayA = 0;
            $totalExtraSameDayC = 0;
            $totalExtraSameDayE = 0;
            $totalExtraSameDayG = 0;
            $d21 = GetPageRecord('*', 'quotationExtraMaster', 'quotationId="' . $quotationId . '" and  fromDate="' . $dayDate . '" and isMarkupApply=0  order by id asc');
            while ($extrainfo1 = mysqli_fetch_array($d21)) {
                if ($extrainfo1['costType']==2){
                    $totalExtraSameDayG = $totalExtraSameDayG + convert_to_base($extrainfo1['currencyValue'],$baseCurrencyVal, $extrainfo1['groupCost']);
                }else {
                    $totalExtraSameDayA = $totalExtraSameDayA + convert_to_base($extrainfo1['currencyValue'], $baseCurrencyVal, ($extrainfo1['adultCost']*$extrainfo1['adultPax']));
                    $totalExtraSameDayC = $totalExtraSameDayC + convert_to_base($extrainfo1['currencyValue'], $baseCurrencyVal, ($extrainfo1['childCost']*$extrainfo1['childPax']));
                    $totalExtraSameDayE = $totalExtraSameDayE + convert_to_base($extrainfo1['currencyValue'], $baseCurrencyVal, ($extrainfo1['infantCost']*$extrainfo1['infantPax']));
                }
                $totalExtraSameDayA = getCostWithGSTID_Markup($totalExtraSameDayA,$extrainfo1['gstTax'],$extrainfo1['markupCost'],$extrainfo1['markupType']);
                $totalExtraSameDayC = getCostWithGSTID_Markup($totalExtraSameDayC,$extrainfo1['gstTax'],$extrainfo1['markupCost'],$extrainfo1['markupType']);
                $totalExtraSameDayE = getCostWithGSTID_Markup($totalExtraSameDayE,$extrainfo1['gstTax'],$extrainfo1['markupCost'],$extrainfo1['markupType']);
                $totalExtraSameDayG = getCostWithGSTID_Markup($totalExtraSameDayG,$extrainfo1['gstTax'],$extrainfo1['markupCost'],$extrainfo1['markupType']);
            }
            echo  getTwoDecimalNumberFormat($totalExtraSameDayA);
            ${"totalExtraA".$val} = (${"totalExtraA".$val} + $totalExtraSameDayA);
            ${"totalExtraC".$val} = (${"totalExtraC".$val} + $totalExtraSameDayC);
            ${"totalExtraE".$val} = (${"totalExtraE".$val} + $totalExtraSameDayE);
            ${"totalExtraG".$val} = (${"totalExtraG".$val} + $totalExtraSameDayG);
            ?>
            </td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalExtraSameDayC); ?></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalExtraSameDayE); ?></td> 
            <?php } ?>
            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalExtraSameDayG); ?></td> 


            <!-- perp ax block -->
            <td align="right" ><?php
            $totalPorterSameDay = 0;
            $d2 = GetPageRecord('*',_QUOTATION_GUIDE_MASTER_, 'quotationId="' . $quotationId . '" and serviceType=1 and  fromDate="' . $dayDate . '" and isGuestType=1   order by id asc');
            while ($finalQuoteGuides = mysqli_fetch_array($d2)) {
                $porterCost = ($finalQuoteGuides['price']+$finalQuoteGuides['otherCost']+$finalQuoteGuides['languageAllowance'])*$finalQuoteGuides['totalDays'];
                $totalPorterSameDay = $totalPorterSameDay + convert_to_base($finalQuoteGuides['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($porterCost,$finalQuoteGuides['gstTax'],$finalQuoteGuides['markupCost'],$finalQuoteGuides['markupType']));
            }
            echo getTwoDecimalNumberFormat($totalPorterSameDay);
            ${"totalPorter".$val} = (${"totalPorter".$val} + $totalPorterSameDay);
            ?>
            </td> 
            </tr>
            <?php
        $dayL++;
        } 
        ?>
        <tr>
            <td colspan="2" align="right" bgcolor="#deb887"><strong>Total</strong></td>
            <?php 
            $rsa3 = "";
            $rsa3=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select totalPax from '._QUOTATION_TRANSFER_MASTER_.' where quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 ) and status=1 order by fromRange asc'); 
            while($transferSlabD=mysqli_fetch_array($rsa3)){
            $slabId5 = $transferSlabD['id'].'C'.$val;  
              ?>
              <td align="right" bgcolor="#deb887"><strong><?php
                echo getTwoDecimalNumberFormat(${"transport" . $slabId5}+${"transferCostA" . $slabId5}+${"transferCostC" . $slabId5}+${"transferCostE" . $slabId5});            
              ?></strong></td>
              <?php
              //totalTransportCost
            } 

            $rsa4 = "";
            $rsa4=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select slabId from '._QUOTATION_GUIDE_MASTER_.' where quotationId="' . $quotationId . '" and isGuestType=1 ) and status=1 order by fromRange asc'); 
            while($guideSlabD=mysqli_fetch_array($rsa4)){  
            $slabId6 = $guideSlabD['id'].'C'.$val; 
              ?>
              <td align="right" bgcolor="#deb887"><strong><?php
              echo getTwoDecimalNumberFormat(${"totalGuide" . $slabId6});
              ?></strong></td>
              <?php
              //totalTransportCost
            } 
            ?> 

            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat(${"totalFerryCostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat(${"totalFerryCostC".$val});
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat(${"totalFerryCostE".$val});
            ?></strong></td>
            <?php } 
             $rsc22 = "";
             $rsc22=GetPageRecord('*','quotationCruiseMaster',' quotationId="'.$quotationId.'" order by id asc'); 
             if(mysqli_num_rows($rsc22)>0){   
            ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalCruiseCostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalCruiseCostC".$val});
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalCruiseCostE".$val});
            ?></strong></td>
            <?php } } ?>  

            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalentcostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalentcostC".$val});
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalentcostE".$val});
            ?></strong></td> 
            <?php } ?>    

            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalactcostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalactcostC".$val});
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalactcostE".$val});
            ?></strong></td> 
            <?php } ?>    

            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalRestaurantCostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalRestaurantCostC".$val});
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalRestaurantCostE".$val});
            ?></strong></td> 
            <?php } ?>     

            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraC".$val});
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraE".$val});
            ?></strong></td> 
            <?php } ?>    
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraG".$val});
            ?></strong></td> 


            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalPorter".$val});
            ?></strong></td>  
           
        </tr>
        <?php  
        
        $transferMarkupA=$transferMarkupC=0;

        if($isUni_Mark == 0 && $isSer_Mark == 1) { ?>
        <!-- markup -->
        <tr>
            <td colspan="2" align="right" ><strong><?php
            if ($financeresult['markupSerType'] == '1') {
            echo 'Mark Up';
            }
            if ($financeresult['markupSerType'] == '2') {
            echo "Service Charge";
            }
            ?>&nbsp;<?php
            // echo ($markupType == 1) ? '&nbsp;(%)' : '&nbsp;(Flat)';
            ?></strong></td>
            
            <?php
            $rsa3 = $slabId7 ="";
            $rsa3=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select totalPax from '._QUOTATION_TRANSFER_MASTER_.' where quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 ) and status=1 order by fromRange asc'); 
            while($transferSlabD=mysqli_fetch_array($rsa3)){  
            $slabId7 = $transferSlabD['id'].'C'.$val; 
            ?>
            <td align="right" ><strong><?php 
            echo getTwoDecimalNumberFormat($transfer);
            ?></strong></td>
            <?php
            //totalTransportCost
            } 
            ?>
            <?php
            $rsa4 = "";
            $rsa4=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select slabId from '._QUOTATION_GUIDE_MASTER_.' where quotationId="' . $quotationId . '" and isGuestType=1 ) and status=1 order by fromRange asc'); 
            while($guideSlabD=mysqli_fetch_array($rsa4)){  
            $slabId8 = $guideSlabD['id'].'C'.$val; 
            ?>
            <td align="right" ><strong><?php 
            echo getTwoDecimalNumberFormat($guide);
            ?></strong></td>
            <?php
            //totalguideCost
            } 
            ?>
            
            <td align="right" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat($ferry);
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat($ferry);
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat($ferry);
            ?></strong></td> 
            <?php }
            
            $rsc22 = "";
            $rsc22=GetPageRecord('*','quotationCruiseMaster',' quotationId="'.$quotationId.'" order by id asc'); 
            if(mysqli_num_rows($rsc22)>0){   
           ?>
           
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($cruise);
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right"><strong><?php
            echo getTwoDecimalNumberFormat($cruise);
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right"><strong><?php
            echo getTwoDecimalNumberFormat($cruise);
            ?></strong></td> 
            <?php } } ?>  


            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($entrance);
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($entrance);
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($entrance);
            ?></strong></td> 
            <?php } ?>    

            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($activity);
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($activity);
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($activity);
            ?></strong></td> 
            <?php } ?>    

            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($restaurant);
            ?></strong></td> 
            <?php } ?>    


            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($other);
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($other);
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($other);
            ?></strong></td> 
            <?php } ?>  
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($other);
            ?></strong></td> 
            <td align="right" ><strong><?php
            echo getTwoDecimalNumberFormat($guide);
            ?></strong></td>  

        </tr>
        <!-- service charge -->
        <tr>
            <td colspan="2" align="right" bgcolor="#deb887" ><strong><?php
            if ($financeresult['markupSerType'] == '1') {
            echo 'Guest Mark Up';
            }
            if ($financeresult['markupSerType'] == '2') {
            echo "Guest Service Charge";
            }
            ?>&nbsp;Amount</strong></td>
            <?php
            $rsa3 = $slabId7 ="";
            $rsa3=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select totalPax from '._QUOTATION_TRANSFER_MASTER_.' where quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 ) and status=1 order by fromRange asc'); 
            while($transferSlabD=mysqli_fetch_array($rsa3)){  
            $slabId7 = $transferSlabD['id'].'C'.$val; 
            ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            //markup for pvt and sic
            ${"transferMarkup" . $slabId7} = getMarkupCost(${"transport" . $slabId7}, $transfer, $transferMarkupType);
            ${"transferMarkupA" . $slabId7} = getMarkupCost(${"transferCostA".$slabId7}, $transfer, $transferMarkupType);
            ${"transferMarkupC" . $slabId7} = getMarkupCost(${"transferCostC".$slabId7}, $transfer, $transferMarkupType);
            ${"transferMarkupE" . $slabId7} = getMarkupCost(${"transferCostE".$slabId7}, $transfer, $transferMarkupType);

            // both markup
            echo $tptpMarkupcost = ${"transferMarkup".$slabId7}+${"transferMarkupA" . $slabId7}+${"transferMarkupC" . $slabId7}+${"transferMarkupE" . $slabId7};
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$tptpMarkupcost;
            // add markup respectivtly
            ${"transport" . $slabId7} = ${"transport" . $slabId7} + ${"transferMarkup" . $slabId7};
            ${"transferCostA" . $slabId7} = ${"transferCostA" . $slabId7} + ${"transferMarkupA" . $slabId7};
            ${"transferCostC" . $slabId7} = ${"transferCostC" . $slabId7} + ${"transferMarkupC" . $slabId7};
            ${"transferCostE" . $slabId7} = ${"transferCostE" . $slabId7} + ${"transferMarkupE" . $slabId7}; 
            ?></strong></td>
            <?php
            //totalTransportCost
            } 
            ?>
            <?php
            $rsa4 = "";
            $rsa4=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select slabId from '._QUOTATION_GUIDE_MASTER_.' where quotationId="' . $quotationId . '" and isGuestType=1 ) and status=1 order by fromRange asc'); 
            while($guideSlabD=mysqli_fetch_array($rsa4)){  
            $slabId8 = $guideSlabD['id'].'C'.$val; 
            ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo ${"guideMarkup" . $slabId8} = getMarkupCost(${"totalGuide" . $slabId8}, $guide, $guideMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+${"guideMarkup" . $slabId8};
            ${"totalGuide" . $slabId8} = ${"totalGuide" . $slabId8} + ${"guideMarkup" . $slabId8};
            ?></strong></td>
            <?php
            //totalguideCost
            } 
            ?> 

            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo $ferryMarkupA = getMarkupCost(${"totalFerryCostA".$val}, $ferry, $ferryMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$ferryMarkupA;
            ${"totalFerryCostA".$val} = ${"totalFerryCostA".$val} + $ferryMarkupA;
            ?></strong></td> 
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo $ferryMarkupC = getMarkupCost(${"totalFerryCostC".$val}, $ferry, $ferryMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$ferryMarkupC;
            ${"totalFerryCostC".$val} = ${"totalFerryCostC".$val} + $ferryMarkupC;
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo $ferryMarkupE = getMarkupCost(${"totalFerryCostE".$val}, $ferry, $ferryMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$ferryMarkupE;
            ${"totalFerryCostE".$val} = ${"totalFerryCostE".$val} + $ferryMarkupE;
            ?></strong></td> 
            <?php } 
            
            $rsc22 = "";
            $rsc22=GetPageRecord('*','quotationCruiseMaster',' quotationId="'.$quotationId.'" order by id asc'); 
            if(mysqli_num_rows($rsc22)>0){   
           ?>
           
            <td align="right" bgcolor="#deb887"><strong><?php
            echo $cruiseMarkupA = getMarkupCost(${"totalCruiseCostA".$val}, $cruise, $cruiseMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$cruiseMarkupA;
            ${"totalCruiseCostA".$val} = ${"totalCruiseCostA".$val} + $cruiseMarkupA;
            ?></strong></td> 
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo $cruiseMarkupC = getMarkupCost(${"totalCruiseCostC".$val}, $cruise, $cruiseMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$cruiseMarkupC;
            ${"totalCruiseCostC".$val} = ${"totalCruiseCostC".$val} + $cruiseMarkupC;
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo $cruiseMarkupE = getMarkupCost(${"totalCruiseCostE".$val}, $cruise, $cruiseMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$cruiseMarkupE;
            ${"totalCruiseCostE".$val} = ${"totalCruiseCostE".$val} + $cruiseMarkupE;
            ?></strong></td> 
            <?php } } ?>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $entranceMarkup = getMarkupCost(${"totalentcostA".$val}, $entrance, $entranceMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$entranceMarkup;
            ${"totalentcostA".$val} = ${"totalentcostA".$val} + $entranceMarkup;
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $entranceMarkup = getMarkupCost(${"totalentcostC".$val}, $entrance, $entranceMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$entranceMarkup;
            ${"totalentcostC".$val} = ${"totalentcostC".$val} + $entranceMarkup;
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $entranceMarkup = getMarkupCost(${"totalentcostE".$val}, $entrance, $entranceMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$entranceMarkup;
            ${"totalentcostE".$val} = ${"totalentcostE".$val} + $entranceMarkup;
            ?></strong></td>
            <?php } ?>    

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo ${"activityMarkup" . $val} = getMarkupCost(${"totalactcostA".$val}, $activity, $activityMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+${"activityMarkup" . $val};
            ${"totalactcostA".$val} = ${"totalactcostA".$val} + ${"activityMarkup" . $val} ;
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo ${"activityMarkup" . $val} = getMarkupCost(${"totalactcostC".$val}, $activity, $activityMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+${"activityMarkup" . $val};
            ${"totalactcostC".$val} = ${"totalactcostC".$val} + ${"activityMarkup" . $val} ;
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo ${"activityMarkup" . $val} = getMarkupCost(${"totalactcostE".$val}, $activity, $activityMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+${"activityMarkup" . $val};
            ${"totalactcostE".$val} = ${"totalactcostE".$val} + ${"activityMarkup" . $val} ;
            ?></strong></td>
            <?php } ?>    

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo ${"restaurantMarkup" . $val} = getMarkupCost(${"totalRestaurantCostA".$val}, $activity, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+${"restaurantMarkup" . $val};
            ${"totalRestaurantCostA".$val} = ${"totalRestaurantCostA".$val} + ${"restaurantMarkup" . $val} ;
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo ${"restaurantMarkup" . $val} = getMarkupCost(${"totalRestaurantCostC".$val}, $activity, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+${"restaurantMarkup" . $val};
            ${"totalRestaurantCostC".$val} = ${"totalRestaurantCostC".$val} + ${"restaurantMarkup" . $val} ;
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo ${"restaurantMarkup" . $val} = getMarkupCost(${"totalRestaurantCostE".$val}, $activity, $restaurantMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+${"restaurantMarkup" . $val};
            ${"totalRestaurantCostE".$val} = ${"totalRestaurantCostE".$val} + ${"restaurantMarkup" . $val} ;
            ?></strong></td>
            <?php } ?>    


            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $textraMarkupA = getMarkupCost(${"totalExtraA".$val}, $other, $otherMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$textraMarkupA;
            ${"totalExtraA".$val} = ${"totalExtraA".$val} + $textraMarkupA; 
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $textraMarkupC = getMarkupCost(${"totalExtraC".$val}, $other, $otherMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$textraMarkupC;
            ${"totalExtraC".$val} = ${"totalExtraC".$val} + $textraMarkupC; 
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $textraMarkupE = getMarkupCost(${"totalExtraE".$val}, $other, $otherMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$textraMarkupE;
            ${"totalExtraE".$val} = ${"totalExtraE".$val} + $textraMarkupE; 
            ?></strong></td>
            <?php } ?>    
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $textraMarkupG = getMarkupCost(${"totalExtraG".$val}, $other, $otherMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$textraMarkupG;
            ${"totalExtraG".$val} = ${"totalExtraG".$val} + $textraMarkupG; 
            ?></strong></td>
                
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo $porterMarkup = getMarkupCost(${"totalPorter".$val}, $guide, $guideMarkupType);
            ${"serviceWiseMarkupCost".$val}=${"serviceWiseMarkupCost".$val}+$porterMarkup;
            ${"totalPorter".$val} = ${"totalPorter".$val} + $porterMarkup;
            ?></strong></td>

          

        </tr>
        <!-- grand total -->
        <tr>
            <td colspan="2" align="right" bgcolor="#deb887" ><strong>Grand&nbsp;Total</strong></td>
            <?php
            $rsa3 = "";
            $rsa3=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select totalPax from '._QUOTATION_TRANSFER_MASTER_.' where quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 ) and status=1 order by fromRange asc'); 
            while($transferSlabD=mysqli_fetch_array($rsa3)){  
            $slabId9 = $transferSlabD['id'].'C'.$val; 
            ?> 
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"transport" . $slabId9}+${"transferCostA" . $slabId9}+${"transferCostC" . $slabId9}+${"transferCostE" . $slabId9});            
            ?></strong></td>
            <?php
            //totalTransportCost
            } 
            ?><?php
            $rsa3 = "";
            $rsa3=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and id in ( select slabId from '._QUOTATION_GUIDE_MASTER_.' where quotationId="' . $quotationId . '" and isGuestType=1 ) and status=1 order by fromRange asc'); 
            while($guideSlabD=mysqli_fetch_array($rsa3)){ 
            $slabId10 = $guideSlabD['id'].'C'.$val;  
            ?> 
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalGuide" . $slabId10});
            ?></strong></td>
            <?php
            //totalTransportCost
            } 
            ?>
           
            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat(${"totalFerryCostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat(${"totalFerryCostC".$val});
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" <?php echo isHideMster('ferryMaster'); ?>><strong><?php
            echo getTwoDecimalNumberFormat(${"totalFerryCostE".$val});
            ?></strong></td>
            <?php } 
            
            $rsc22 = "";
            $rsc22=GetPageRecord('*','quotationCruiseMaster',' quotationId="'.$quotationId.'" order by id asc'); 
            if(mysqli_num_rows($rsc22)>0){   
            ?>  
             <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalCruiseCostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalCruiseCostC".$val});
            ?></strong></td>
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887"><strong><?php
            echo getTwoDecimalNumberFormat(${"totalCruiseCostE".$val});
            ?></strong></td>
            <?php } } ?>  

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalentcostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalentcostC".$val});
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalentcostE".$val});
            ?></strong></td> 
            <?php } ?>    

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalactcostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalactcostC".$val});
            ?></strong></td> 
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalactcostE".$val});
            ?></strong></td> 
            <?php } ?>    

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalRestaurantCostA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalRestaurantCostC".$val});
            ?></strong></td>    
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalRestaurantCostE".$val});
            ?></strong></td> 
            <?php } ?>

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraA".$val});
            ?></strong></td>
            <?php if($paxChild>0){ ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraC".$val});
            ?></strong></td>    
            <?php }if ($paxInfant>0) { ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraE".$val});
            ?></strong></td> 
            <?php } ?>
            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalExtraG".$val});
            ?></strong></td> 

            <td align="right" bgcolor="#deb887" ><strong><?php
            echo getTwoDecimalNumberFormat(${"totalPorter".$val});
            ?></strong></td> 
            </tr>
          <?php  
        }
        ?>
        </table>
        <br>
      

        <!-- START PER PAX BLOCK --> 
        <table width="100%" cellpadding="0" cellspacing="0" >
        <tr>
        <td valign="top" width="50%">

        <!--START PER PERSON COST SLAB WISE -->
        <div style="text-align:center;font-size: 18px;margin: 15px 0;"><strong>Land Arrangement</strong> </div>
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PARTICULARS</strong></td>
                <?php
                $groupSlabPPSql = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){

                    $paxAdult2 = ($groupSlabPPD['adult']);
                    $paxChild2 = ($groupSlabPPD['child']);
                    $paxInfant2 = ($groupSlabPPD['infant']);

                    $totalPax2 = ($paxAdult2 + $paxChild2 + $paxInfant2);

                    if($totalPax2 == 0){
                        $totalPax2 =  3;
                    }
                    
                    $paxAdultLE2 = $groupSlabPPD['localEscort'];
                    $paxAdultFE2 = $groupSlabPPD['foreignEscort'];

                    if($groupSlabPPD['fromRange'] == $groupSlabPPD['toRange']){
                        $groupRangeLable = $groupSlabPPD['fromRange'].'&nbsp;Pax ';
                    }else{
                        $groupRangeLable = $groupSlabPPD['fromRange'].'&nbsp;To&nbsp;'.$groupSlabPPD['toRange'];
                    }
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ${"totalpaxA" . $slabId11} = ${"totalpaxC" . $slabId11} = 0;
                    ${"totalPaxFE" . $slabId11} = ${"totalPaxLE" . $slabId11} = 0;

                    ${"transGuideCostA" . $slabId11} = ${"transGuideCostC" . $slabId11} = 0;
                    ${"transGuideCostAFE" . $slabId11} = ${"transGuideCostALE" . $slabId11} = 0;

                    // make all assigned with 0
                    ${"totalmealLE2".$val} = ${"totalmealFE2".$val} = ${"totalmealApp".$val} = ${"totaltrainApp".$val} = ${"totalFerryCostApp".$val} = ${"totalflightApp".$val} = ${"totalentcostApp".$val} = ${"totalactcostApp".$val} = ${"totalExtraApp".$val} = ${"totalmealCpp".$val} = ${"totaltrainCpp".$val} = ${"totalFerryCostCpp".$val} = ${"totalflightCpp".$val} = ${"totalentcostCpp".$val} = ${"totalactcostCpp".$val} = ${"totalExtraCpp".$val} = ${"totalmealEpp".$val} = ${"totaltrainEpp".$val} = ${"totalFerryCostEpp".$val} = ${"totalflightEpp".$val} = ${"totalentcostEpp".$val} = ${"totalactcostEpp".$val} = ${"totalExtraEpp".$val} = 0;
                    
                    if ($paxAdult2 != 0) {
                        // for Escort
                        ${"totalmealLE2".$val} = (${"totalmealALE".$val} + ${"totalHA".$val} + round(${"totalRestaurantCostA".$val}/$paxAdult2));
                        ${"totalmealFE2".$val} = (${"totalmealAFE".$val} + ${"totalHA".$val} + round(${"totalRestaurantCostA".$val}/$paxAdult2));

                        ${"totalmealApp".$val} = (${"totalmealA".$val} + ${"totalHA".$val} + round(${"totalRestaurantCostA".$val}/$paxAdult2)); 
                        ${"totaltrainApp".$val} = round(${"totaltrainA".$val}/$paxAdult2);
                        ${"totalFerryCostApp".$val} = round(${"totalFerryCostA".$val}/$paxAdult2);
                        ${"totalCruiseCostApp".$val} = round(${"totalCruiseCostA".$val}/$paxAdult2);
                        ${"totalflightApp".$val} = round(${"totalflightA".$val}/$paxAdult2);
                        ${"totalentcostApp".$val} = round(${"totalentcostA".$val}/$paxAdult2);
                        ${"totalactcostApp".$val} = round(${"totalactcostA".$val}/$paxAdult2);
                        ${"totalExtraApp".$val} = round(${"totalExtraA".$val}/$paxAdult2) + round(${"totalExtraG".$val}/$totalPax2);
                    }
                    if ($paxChild2 != 0) {
                        ${"totalmealCpp".$val} = (${"totalmealC".$val} + ${"totalHA".$val} + round(${"totalRestaurantCostC".$val}/$paxChild2)); 
                        ${"totaltrainCpp".$val} = round(${"totaltrainC".$val}/$paxChild2);
                        ${"totalFerryCostCpp".$val} = round(${"totalFerryCostC".$val}/$paxChild2);
                        ${"totalCruiseCostCpp".$val} = round(${"totalCruiseCostC".$val}/$paxChild2);
                        ${"totalflightCpp".$val} = round(${"totalflightC".$val}/$paxChild2);
                        ${"totalentcostCpp".$val} = round(${"totalentcostC".$val}/$paxChild2);
                        ${"totalactcostCpp".$val} = round(${"totalactcostC".$val}/$paxChild2);
                        ${"totalExtraCpp".$val} = round(${"totalExtraC".$val}/$paxChild2) + round(${"totalExtraG".$val}/$totalPax2);   
                    }
                    if ($paxInfant2 != 0) {
                        // meals + restaurant
                        ${"totalmealEpp".$val} = (${"totalmealE".$val} + ${"totalHA".$val} + round(${"totalRestaurantCostE".$val}/$paxInfant2)); 
                        // train
                        ${"totaltrainEpp".$val} = round(${"totaltrainE".$val}/$paxInfant2);
                        // Ferry
                        ${"totalFerryCostEpp".$val} = round(${"totalFerryCostE".$val}/$paxInfant2);
                        //Cruise
                        ${"totalCruiseCostEpp".$val} = round(${"totalCruiseCostE".$val}/$paxInfant2);
                        // flight
                        ${"totalflightEpp".$val} = round(${"totalflightE".$val}/$paxInfant2);
                        // Monument 
                        ${"totalentcostEpp".$val} = round(${"totalentcostE".$val}/$paxInfant2);
                        // Activity 
                        ${"totalactcostEpp".$val} = round(${"totalactcostE".$val}/$paxInfant2);
                        // Additionals 
                        ${"totalExtraEpp".$val} = round(${"totalExtraE".$val}/$paxInfant2) + round(${"totalExtraG".$val}/$totalPax2);   
                    }

                    ?>
                    <td align="center" colspan="<?php echo ($paxAdultLE2+$paxAdultFE2)+3;?>" bgcolor="#F5F5F5"><strong><?php echo $groupRangeLable." ( D.F-".$groupDivideFactor.")"; ?></strong><br><?php echo $paxAdult2.' Adult(s), '.$paxChild2.' Child(s), '.$paxInfant2.' Infant(s) ';  if ($paxAdultLE2 >0) { echo " with Escort"; } ?></td>
                <?php
                }
                }
                ?>
            </tr>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong></strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><strong>ADULT&nbsp;COST</strong></td>
                    <td align="right" bgcolor="#deb887" ><strong>CHILD&nbsp;COST</strong></td>
                    <td align="right" bgcolor="#deb887" ><strong>INFANT&nbsp;COST</strong></td>
                    <?php  if ($paxAdultLE >0 ) { ?>
                    <td align="center" bgcolor="#dec7c7"><strong>LOCAL</strong></td>
                    <?php } if ($paxAdultFE >0 ) { ?>
                    <td align="center" bgcolor="#d4d5f0"><strong>FORIEGN</strong></td>
                    <?php } ?>
                    <?php
                }
                }
                ?>
            </tr>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>MEAL+B+L+D+A</strong></td>
                <?php
                // ${"totalmealApp".$val} = (${"totalmealA".$val} + ${"totalRestaurantCost".$val} + ${"totalHA".$val});
                // ${"totalmealCpp".$val} = (${"totalmealC".$val} + ${"totalRestaurantCost".$val} + ${"totalHA".$val});
                // ${"totalmealEpp".$val} = (${"totalmealE".$val} + ${"totalRestaurantCost".$val} + ${"totalHA".$val});
                // ${"totalmealEpp".$val} = 0;
                // ${"totalmealLE2".$val} = (${"totalmealALE".$val} + ${"totalRestaurantCost".$val} + ${"totalHA".$val});
                // ${"totalmealFE2".$val} = (${"totalmealAFE".$val} + ${"totalRestaurantCost".$val} + ${"totalHA".$val});
                ?>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalmealApp".$val});  ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalmealApp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalmealCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalmealCpp".$val}; ?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalmealEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalmealEpp".$val}; ?></td>
                    <?php
                    ${"totalmealCostLE".$val} = getFOCCost(${"totalmealLE2".$val},$groupSlabPPD['id'],"LE","restaurant",$quotationId);
                    ${"totalmealCostFE".$val} = getFOCCost(${"totalmealFE2".$val},$groupSlabPPD['id'],"FE","restaurant",$quotationId);
                    ?>
                    <?php  if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"totalmealCostLE".$val}); ${"totalPaxLE" . $slabId11} = ${"totalPaxLE" . $slabId11} + ${"totalmealCostLE".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalmealCostFE".$val}); ${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalmealCostFE".$val};?></td>
                    <?php }  
                }
                }
                ?> 
            </tr>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>TRAIN</strong></td> 
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totaltrainApp".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totaltrainApp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totaltrainCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totaltrainCpp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totaltrainEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totaltrainEpp".$val};?></td>
                    <?php
                    ${"totaltrainALE2".$val} = getFOCCost(${"totaltrainALE".$val},$groupSlabPPD['id'],"LE","train",$quotationId);
                    ${"totaltrainAFE2".$val} = getFOCCost(${"totaltrainAFE".$val},$groupSlabPPD['id'],"FE","train",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat(${"totaltrainALE2".$val});${"totalPaxLE" . $slabId11}=${"totalPaxLE" . $slabId11}+${"totaltrainALE2".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totaltrainAFE2".$val}); ${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totaltrainAFE2".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>
            <tr height="18" <?php echo isHideMster('ferryMaster'); ?>>
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>FERRY</strong></td> 
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalFerryCostApp".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalFerryCostApp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalFerryCostCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalFerryCostCpp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalFerryCostEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalFerryCostEpp".$val};?></td>
                    <?php
                    ${"totalFerryCostALE2".$val} = getFOCCost(${"totalFerryCostApp".$val},$groupSlabPPD['id'],"LE","train",$quotationId);
                    ${"totalFerryCostAFE2".$val} = getFOCCost(${"totalFerryCostApp".$val},$groupSlabPPD['id'],"FE","train",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat(${"totalFerryCostALE2".$val});${"totalPaxLE" . $slabId11}=${"totalPaxLE" . $slabId11}+${"totalFerryCostALE2".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalFerryCostAFE2".$val}); ${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalFerryCostAFE2".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>

            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>CRUISE</strong></td> 
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalCruiseCostApp".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalCruiseCostApp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalCruiseCostCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalCruiseCostCpp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalCruiseCostEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalCruiseCostEpp".$val};?></td>
                    <?php
                    ${"totalCruiseCostALE2".$val} = getFOCCost(${"totalCruiseCostApp".$val},$groupSlabPPD['id'],"LE","train",$quotationId);
                    ${"totalCruiseCostAFE2".$val} = getFOCCost(${"totalCruiseCostApp".$val},$groupSlabPPD['id'],"FE","train",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat(${"totalCruiseCostALE2".$val});${"totalPaxLE" . $slabId11}=${"totalPaxLE" . $slabId11}+${"totalCruiseCostALE2".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalCruiseCostAFE2".$val}); ${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalCruiseCostAFE2".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>
            <?php

            if ($is_flight_supp == 0 && $slabAndRoomType == 1) {
            ?>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>FLIGHT</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalflightApp".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalflightApp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalflightCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalflightCpp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalflightEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalflightEpp".$val};?></td>
                    <?php
                    ${"totalflightALE2".$val} = getFOCCost(${"totalflightALE".$val},$groupSlabPPD['id'],"LE","flight",$quotationId);
                    ${"totalflightAFE2".$val} = getFOCCost(${"totalflightAFE".$val},$groupSlabPPD['id'],"FE","flight",$quotationId);

                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"totalflightALE2".$val}); ${"totalPaxLE" . $slabId11} = ${"totalPaxLE" . $slabId11} + ${"totalflightALE2".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalflightAFE2".$val}); ${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalflightAFE2".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>
            <?php
            }
            ?>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PORTER</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalPorter".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalPorter".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalPorter".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalPorter".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalPorter".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalPorter".$val};?></td>
                    <?php
                    ${"totalPorterCostLE".$val} = getFOCCost(${"totalPorter".$val},$groupSlabPPD['id'],"LE","guide",$quotationId);
                    ${"totalPorterCostFE".$val} = getFOCCost(${"totalPorter".$val},$groupSlabPPD['id'],"FE","guide",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"totalPorterCostLE".$val});${"totalPaxLE" . $slabId11} = ${"totalPaxLE" . $slabId11} + ${"totalPorterCostLE".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalPorterCostFE".$val});${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalPorterCostFE".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>MONUMENTS</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalentcostApp".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalentcostApp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalentcostCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalentcostCpp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalentcostEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalentcostEpp".$val};?></td>
                    <?php
                    ${"totalentcostALE".$val} = getFOCCost(${"totalentcostApp".$val},$groupSlabPPD['id'],"LE","entrance",$quotationId);
                    ${"totalentcostAFE".$val} = getFOCCost(${"totalentcostApp".$val},$groupSlabPPD['id'],"FE","entrance",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"totalentcostALE".$val});${"totalPaxLE" . $slabId11} = ${"totalPaxLE" . $slabId11} + ${"totalentcostALE".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalentcostAFE".$val});${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalentcostAFE".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr> 
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>SIC TRANSPORT</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];

                    if($paxAdult>0){ ${"transferCostApp".$slabId11} = (${"transferCostA".$slabId11}/$paxAdult); }
                    if($paxChild>0){ ${"transferCostCpp".$slabId11} = (${"transferCostC".$slabId11}/$paxChild); }
                    if($paxInfant>0){ ${"transferCostEpp".$slabId11} = (${"transferCostE".$slabId11}/$paxInfant); }

                    ?>
                    <td align="right" bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat(${"transferCostApp".$slabId11}); 
                        ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"transferCostApp".$slabId11}; ?></td>
                    <td align="right" bgcolor="#deb887" ><?php
                        echo getTwoDecimalNumberFormat(${"transferCostCpp".$slabId11}); 
                        ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"transferCostCpp".$slabId11}; ?></td>
                    <td align="right" bgcolor="#deb887" ><?php 
                        echo getTwoDecimalNumberFormat(${"transferCostEpp".$slabId11}); 
                        ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"transferCostEpp".$slabId11}; ?></td>
                    <?php
                    ${"transferCostALE".$slabId11} = getFOCCost(${"transferCostApp".$slabId11},$groupSlabPPD['id'],"LE","entrance",$quotationId);
                    ${"transferCostAFE".$slabId11} = getFOCCost(${"transferCostApp".$slabId11},$groupSlabPPD['id'],"FE","entrance",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php 
                        echo getTwoDecimalNumberFormat(${"transferCostALE".$slabId11});
                        ${"totalPaxLE" . $slabId11} = ${"totalPaxLE" . $slabId11} + ${"transferCostALE".$slabId11};
                        ?>
                    </td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php 
                        echo getTwoDecimalNumberFormat(${"transferCostAFE".$slabId11});
                        ${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"transferCostAFE".$slabId11};
                        ?>
                    </td>
                    <?php } 
                }
                }
                ?>
            </tr> 
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>SIGHTSEEING</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalactcostApp".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalactcostApp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalactcostCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalactcostCpp".$val};?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalactcostEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalactcostEpp".$val};?></td>
                    <?php
                    ${"totalactcostALE".$val} = getFOCCost(${"totalactcostApp".$val},$groupSlabPPD['id'],"LE","activity",$quotationId);
                    ${"totalactcostAFE".$val} = getFOCCost(${"totalactcostApp".$val},$groupSlabPPD['id'],"FE","activity",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"totalactcostALE".$val});${"totalPaxLE" . $slabId11} = ${"totalPaxLE" . $slabId11} + ${"totalactcostALE".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalactcostAFE".$val});${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalactcostAFE".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr> 
       
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ADDITIONALS</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalExtraApp".$val}); ${"totalpaxA" . $slabId11} = ${"totalpaxA" . $slabId11} + ${"totalExtraApp".$val};?></td>
                    
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalExtraCpp".$val}); ${"totalpaxC" . $slabId11} = ${"totalpaxC" . $slabId11} + ${"totalExtraCpp".$val};?></td>

                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat(${"totalExtraEpp".$val}); ${"totalpaxE" . $slabId11} = ${"totalpaxE" . $slabId11} + ${"totalExtraEpp".$val};?></td>

                    <?php
               
                    ${"totalAdditionalCostLE".$val} = getFOCCost(${"totalExtraApp".$val},$groupSlabPPD['id'],"LE","other",$quotationId);
                    ${"totalAdditionalCostFE".$val} = getFOCCost(${"totalExtraApp".$val},$groupSlabPPD['id'],"FE","other",$quotationId);
                    if ($paxAdultLE >0) { ?>
                   
                   <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"totalAdditionalCostLE".$val});${"totalPaxLE" . $slabId11} = ${"totalPaxLE" . $slabId11} + ${"totalAdditionalCostLE".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                  
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalAdditionalCostFE".$val});${"totalPaxFE" . $slabId11} = ${"totalPaxFE" . $slabId11} + ${"totalAdditionalCostFE".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5">
                    <strong>TOTAL LAND ARRANGEMENT COST (&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>&nbsp;)</strong>
                </td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    ?>
                    <td align="right" bgcolor="#deb887"  style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"totalpaxA" . $slabId11});?></td>
                    <td align="right" bgcolor="#deb887"  style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"totalpaxC" . $slabId11});?></td>
                    <td align="right" bgcolor="#deb887"  style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"totalpaxE" . $slabId11});?></td>
                    <?php
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"totalPaxLE" . $slabId11}); $totalFOCCost = ${"totalPaxLE" . $slabId11};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"totalPaxFE" . $slabId11}); $totalLOCCost = ${"totalPaxFE" . $slabId11};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>

            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    ?>
                    <td align="right" bgcolor="#deb887" ></td>
                    <td align="right" bgcolor="#deb887" ></td>
                    <td align="right" bgcolor="#deb887" ></td>
                    <?php
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"></td>
                    <?php } if($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"></td>
                    <?php } 
                }
                }
                ?>
            </tr>

            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PRIVATE TRANSPORT</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];

                    $ppTPTCost = (${"transport" . $slabId11}/$groupDivideFactor);

                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($ppTPTCost); 
                    ${"transGuideCostA" . $slabId11} = ${"transGuideCostA" . $slabId11} + $ppTPTCost;?>
                    </td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($ppTPTCost); 
                    ${"transGuideCostC" . $slabId11} = ${"transGuideCostC" . $slabId11} + $ppTPTCost;?></td>

                    <td align="right" bgcolor="#deb887" ><?php getTwoDecimalNumberFormat($ppTPTCost);  echo 0;
                    ${"transGuideCostE" . $slabId11} = ${"transGuideCostE" . $slabId11} + $ppTPTCost;?></td>
                    <?php
                    ${"transportALE2".$val} = getFOCCost($ppTPTCost,$groupSlabPPD['id'],"LE","transfer",$quotationId);
                    ${"transportAFE2".$val} = getFOCCost($ppTPTCost,$groupSlabPPD['id'],"FE","transfer",$quotationId);

                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"transportALE2".$val}); 
                    ${"transGuideCostALE" . $slabId11} = ${"transGuideCostALE" . $slabId11} + ${"transportALE2".$val};?></td>
                    <?php } if($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"transportAFE2".$val}); 
                    ${"transGuideCostAFE" . $slabId11} = ${"transGuideCostAFE" . $slabId11} + ${"transportAFE2".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>GUIDE</strong></td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;
                    $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                    $totalGuideCost2 = (${"totalGuide" . $slabId11}/$groupDivideFactor);
                    ?>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalGuideCost2); 
                    ${"transGuideCostA" . $slabId11} = ${"transGuideCostA" . $slabId11} + $totalGuideCost2;?></td>
                    <td align="right" bgcolor="#deb887" ><?php echo getTwoDecimalNumberFormat($totalGuideCost2); 
                    ${"transGuideCostC" . $slabId11} = ${"transGuideCostC" . $slabId11} + $totalGuideCost2;?></td>
                    <td align="right" bgcolor="#deb887" ><?php getTwoDecimalNumberFormat($totalGuideCost2);  echo 0;
                    ${"transGuideCostE" . $slabId11} = ${"transGuideCostE" . $slabId11} + $totalGuideCost2;?></td>
                    <?php
                    ${"totalGuideALE2".$val} = getFOCCost($totalGuideCost2,$groupSlabPPD['id'],"LE","guide",$quotationId);
                    ${"totalGuideAFE2".$val} = getFOCCost($totalGuideCost2,$groupSlabPPD['id'],"FE","guide",$quotationId);
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7"><?php echo  getTwoDecimalNumberFormat(${"totalGuideALE2".$val}); ${"transGuideCostALE" . $slabId11} = ${"transGuideCostALE" . $slabId11} + ${"totalGuideALE2".$val};?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0"><?php echo  getTwoDecimalNumberFormat(${"totalGuideAFE2".$val}); ${"transGuideCostAFE" . $slabId11} = ${"transGuideCostAFE" . $slabId11} + ${"totalGuideAFE2".$val};?></td>
                    <?php } 
                }
                }
                ?>
            </tr>
            <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5">
                    <strong>TOTAL&nbsp;PRIVATE&nbsp;TRANSPORT/GUIDE&nbsp;COST&nbsp;(&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>&nbsp;)</strong>
                </td>
                <?php
                $groupSlabPPSql = $groupDivideFactor = $groupRange = "";
                $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                if (mysqli_num_rows($groupSlabPPSql)>0) {
                while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                    $paxAdultLE = $groupSlabPPD['localEscort'];
                    $paxAdultFE = $groupSlabPPD['foreignEscort'];
                    $slabId11 = $groupSlabPPD['id'].'C'.$val;

                    $transportGuidecostA = $ppTPTCost+$totalGuideCost2;
                    $transportGuidecostC = $ppTPTCost+$totalGuideCost2;
                    $transportGuidecostE = $ppTPTCost+$totalGuideCost2;
                    // ${"transGuideCostA" . $slabId11}  ${"transGuideCostC" . $slabId11}
                    ?>
                    <td align="right" bgcolor="#deb887" style="font-weight:800;"><?php echo getTwoDecimalNumberFormat($transportGuidecostA);?></td>
                    <td align="right" bgcolor="#deb887" style="font-weight:800;"><?php echo getTwoDecimalNumberFormat($transportGuidecostC);?></td>
                    <td align="right" bgcolor="#deb887" style="font-weight:800;"><?php  getTwoDecimalNumberFormat($transportGuidecostE); echo 0;?></td>
                    <?php
                    if ($paxAdultLE >0) { ?>
                    <td align="right" bgcolor="#dec7c7" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"transGuideCostALE" . $slabId11}); $totalFOCCost = ${"totalPaxLE" . $slabId11 } ?></td>
                    <?php } if ($paxAdultFE >0) { ?>
                    <td align="right" bgcolor="#d4d5f0" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"transGuideCostAFE" . $slabId11}); $totalLOCCost = ${"totalPaxFE" . $slabId11 } ?></td>
                    <?php } 
                }
                }
                ?>
            </tr>

            <!-- <tr height="18">
                <td height="18" colspan="2" align="right" bgcolor="#F5F5F5">
                    <strong>TOTAL VALUE ADDED SERVICES COST (&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>&nbsp;)</strong>
                </td>
               
                    <td align="right" bgcolor="#deb887" style="font-weight:800;"><?php echo getTwoDecimalNumberFormat($VPIPerPaxA);?></td>
                    <td align="right" bgcolor="#deb887"  style=" font-weight: 800; "><?php $totalVPICI = $VPIPerPaxC+$VPIPerPaxI; echo getTwoDecimalNumberFormat($totalVPICI);?></td>
                
            </tr> -->
        </table>
        <!--END PER PERSON COST SLAB WISE -->
        <br>
        <!--START TOTAL TOUR COST SLAB WISE -->
        <table width="100%" cellpadding="0" cellspacing="0" >
            <tr>
            <?php
            // GETTING ADDTIONALS SERVICE TOTAL COST WHICH IS NOT MARKUP APPLY
            ${"totalExtraNoMarkupG".$val} =  0;
            $d212 = GetPageRecord('*', 'quotationExtraMaster', 'quotationId="' . $quotationId . '" and isMarkupApply=1 order by id asc');
            while ($extraCostNoMarkupD = mysqli_fetch_array($d212)) {
                if ($extraCostNoMarkupD['costType']==2 || $extraCostNoMarkupD['isMarkupApply']==1){
                    ${"totalExtraNoMarkupG".$val}  += convert_to_base($extraCostNoMarkupD['currencyValue'],$baseCurrencyVal, $extraCostNoMarkupD['groupCost']);
                }
            } 

            // echo ${"totalExtraNoMarkupG".$val};
            // END NOT MARKUP COST ADDITIONALS SERVICESS

            $rsa22 = "";
            $groupDivideFactor = 0;
            $singleRoom2 = $doubleRoom2 = $twinRoom2 = $tripleRoom2 =  $quadBedRoom2 = $sixBedRoom2 = $eightBedRoom2 = $tenBedRoom2 = $teenBedRoom2 = $EBedChild2 = $NBedChild2 = $EBedAdult2 = 0;
            $rsa22=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1 order by fromRange asc'); 
            while($groupSlabPPD=mysqli_fetch_array($rsa22)){
                $slabId11 = $groupSlabPPD['id'].'C'.$val;

                $singleRoom2 = $groupSlabPPD['sglRoom'];
                $doubleRoom2 = $groupSlabPPD['dblRoom'];
                $twinRoom2   = $groupSlabPPD['twinRoom'];
                $tripleRoom2 = $groupSlabPPD['tplRoom'];
                $quadBedRoom2 = $groupSlabPPD['quadNoofRoom'];
                $sixBedRoom2 = $groupSlabPPD['sixNoofBedRoom'];
                $eightBedRoom2 = $groupSlabPPD['eightNoofBedRoom'];
                $tenBedRoom2 = $groupSlabPPD['tenNoofBedRoom'];
                $teenBedRoom2 = $groupSlabPPD['teenNoofRoom'];
                $EBedChild2 = $groupSlabPPD['childwithNoofBed'];
                $NBedChild2 = $groupSlabPPD['childwithoutNoofBed'];
                $EBedAdult2 = $groupSlabPPD['extraNoofBed'];

                $paxAdult2 = ($groupSlabPPD['adult']);
                $paxChild2 = ($groupSlabPPD['child']);
                $paxInfant2 = ($groupSlabPPD['infant']);
                $totalPax = ($paxAdult2 + $paxChild2);
                if($totalPax == 0){
                    $totalPax =  2;
                }

                $groupDivideFactor = $groupSlabPPD['dividingFactor'];
                $paxAdultLE2 = $groupSlabPPD['localEscort'];
                $paxAdultFE2 = $groupSlabPPD['foreignEscort'];

                $esQLE = "";
                $esQLE = GetPageRecord('*', 'quotationFOCRates',' 1 and slabId="'.$groupSlabPPD['id'].'" and focType="LE" and quotationId="'.$quotationId.'"');
                if (mysqli_num_rows($esQLE)>0 && $paxAdultLE>0) {
                    $escortDataLE = mysqli_fetch_array($esQLE);
                    $sglRoomLE = $escortDataLE['sglNORoom'];
                    $dblRoomLE = $escortDataLE['dblNORoom'];
                }

                $esQFE = "";
                $esQFE = GetPageRecord('*', 'quotationFOCRates',' 1 and slabId="'.$groupSlabPPD['id'].'" and focType="FE" and quotationId="'.$quotationId.'"');
                if (mysqli_num_rows($esQFE)>0 && $paxAdultFE>0) {
                    $escortDataFE = mysqli_fetch_array($esQFE);
                    $sglRoomFE = $escortDataFE['sglNORoom'];
                    $dblRoomFE = $escortDataFE['dblNORoom'];
                }

                ${"clientCost".$slabId11} = ${"proposalCost".$slabId11} = ${"grandTotalCost".$slabId11} = 0;

                ${"grandSingle".$val}=${"grandDouble".$val}=${"grandTwin".$val}=${"grandTriple".$val}=${"grandQuadBed".$val}=${"grandSixBed".$val}=${"grandEightBed".$val}=${"grandTenBed".$val}=${"grandTeenBed".$val}=${"grandHA".$val}=${"grandAWB".$val}=${"grandChildWB".$val}=${"grandChildNB".$val}=0;

                ${"grandTotalPaxA".$slabId11}=${"grandTotalPaxC".$slabId11}=${"grandTotalTGCost".$slabId11}=0; 

                ${"grandSingleLE".$slabId11}=${"grandDoubleLE".$slabId11}=${"grandSingleFE".$slabId11}=${"grandDoubleFE".$slabId11}=0;
                ${"grandTotalPaxLE".$slabId11}=${"grandTotalPaxFE".$slabId11}=${"grandTotalTGCostALE".$slabId11}=${"grandTotalTGCostAFE".$slabId11}=0;

                if($groupSlabPPD['fromRange']==$groupSlabPPD['toRange']){
                $groupRange = $groupSlabPPD['fromRange'].'&nbsp;Pax';
                }else{
                $groupRange = $groupSlabPPD['fromRange'] . '&nbsp;To&nbsp;' . $groupSlabPPD['toRange'];
                }
                ?>
                <td valign="top" >
                <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
                    <tr>
                    <td align="center" colspan="5" bgcolor="#F5F5F5"><div style="text-align:center;font-size: 18px;margin: 15px 0;"><strong>Total Tour Cost(<?php echo $groupRange; ?>)</strong></div></td>
                    </tr>
                    <tr>
                    <td align="center" bgcolor="#F5F5F5"><strong>Itinerary&nbsp;Services</strong></td>
                    <td align="center" bgcolor="#F5F5F5"><strong>Unit&nbsp;Cost</strong></td>
                    <td align="center" bgcolor="#F5F5F5"><strong>Volume&nbsp;Type</strong></td>
                    <td align="center" bgcolor="#F5F5F5"><strong>Qty&nbsp;Total</strong></td>
                    <td align="center" bgcolor="#F5F5F5"><strong>Total&nbsp;Cost</strong></td>
                    </tr> 
                    <?php if($singleRoom2 >0){ ?>
                    <tr >
                    <td align="left" bgcolor="#deb887"><strong>Single&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalsingle".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $singleRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandSingle".$slabId11}=${"totalsingle".$val};                       
                        }else{
                            ${"grandSingle".$slabId11}=${"totalsingle".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandSingle".$slabId11});?></td>
                            
                    </tr>
                    <?php }if($doubleRoom2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Double&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totaldouble".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $doubleRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandDouble".$slabId11} =${"totaldouble".$val}; 
                        }else{
                            ${"grandDouble".$slabId11} =${"totaldouble".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandDouble".$slabId11});?></td>
                            
                    </tr>
                    <?php }if($twinRoom2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Twin&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totaltwin".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $twinRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandTwin".$slabId11} =${"totaltwin".$val}; 
                        }else{
                            ${"grandTwin".$slabId11} =${"totaltwin".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandTwin".$slabId11});?></td>
                            
                    </tr>

                    <?php }if($tripleRoom2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Triple&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totaltriple".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $tripleRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandTriple".$slabId11} =${"totaltriple".$val}; 
                        }else{
                            ${"grandTriple".$slabId11} =${"totaltriple".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandTriple".$slabId11}); ?></td>
                            
                    </tr>
                    <?php }if($quadBedRoom2 >0){ ?>
                    <tr >
                    <td align="left" bgcolor="#deb887"><strong>Quad&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalquadBed".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $quadBedRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandQuadBed".$slabId11}=${"totalquadBed".$val}; 
                        }else{
                            ${"grandQuadBed".$slabId11}=${"totalquadBed".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandQuadBed".$slabId11});?></td>
                            
                    </tr>
                    
                    <?php }if($sixBedRoom2 >0){ ?>
                    <tr >
                    <td align="left" bgcolor="#deb887"><strong>SixBed&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalSixBed".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $sixBedRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandSixBed".$slabId11}=${"totalSixBed".$val}; 
                        }else{
                            ${"grandSixBed".$slabId11}=${"totalSixBed".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandSixBed".$slabId11});?></td>
                            
                    </tr>
                    <?php }if($eightBedRoom2 >0){ ?>
                    <tr >
                    <td align="left" bgcolor="#deb887"><strong>EightBed&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totaleightBed".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $eightBedRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandEightBed".$slabId11}=${"totaleightBed".$val}; 
                        }else{
                            ${"grandEightBed".$slabId11}=${"totaleightBed".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandEightBed".$slabId11});?></td>
                            
                    </tr>
                    <?php }if($tenBedRoom2 >0){ ?>
                    <tr >
                    <td align="left" bgcolor="#deb887"><strong>TenBed&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totaltenBed".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $tenBedRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandTenBed".$slabId11}=${"totaltenBed".$val}; 
                        }else{
                            ${"grandTenBed".$slabId11}=${"totaltenBed".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandTenBed".$slabId11});?></td>
                    </tr>
                    <?php }if($teenBedRoom2 >0){ ?>
                    <tr >
                    <td align="left" bgcolor="#deb887"><strong>TeenBed&nbsp;Room</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalteenBed".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $teenBedRoom2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandTeenBed".$slabId11}=${"totalteenBed".$val}; 
                        }else{
                            ${"grandTeenBed".$slabId11}=${"totalteenBed".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandTeenBed".$slabId11});?>
                    </td>                    
                    </tr>
                    <?php } if($EBedAdult2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Extra&nbsp;Bed(A)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalextraBedA".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $EBedAdult2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandAWB".$slabId11} =${"totalextraBedA".$val}; 
                        }else{
                            ${"grandAWB".$slabId11} =${"totalextraBedA".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandAWB".$slabId11});?>
                    </td>
                    </tr>
                    <?php }if($EBedChild2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Child-With&nbsp;Bed</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalextraBedC".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $EBedChild2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandChildWB".$slabId11} =${"totalextraBedC".$val}; 
                        }else{
                            ${"grandChildWB".$slabId11} =${"totalextraBedC".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandChildWB".$slabId11});?></td>
                    </tr>
                    <?php }if($NBedChild2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Child-No&nbsp;Bed</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalextraNBedC".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"><?php echo ($slabAndRoomType == 1)?'Room':''; ?></td>
                    <td align="center" bgcolor="#deb887"><?php if($slabAndRoomType == 1){ echo $NBedChild2; } ?></td>
                    <td align="right" bgcolor="#deb887"><?php 
                        if($slabAndRoomType == 1){
                            ${"grandChildNB".$slabId11} =${"totalextraNBedC".$val}; 
                        }else{
                            ${"grandChildNB".$slabId11} =${"totalextraNBedC".$val}; 
                        }
                        echo getTwoDecimalNumberFormat(${"grandChildNB".$slabId11});?>
                    </td>
                    </tr>
                    <?php } ?>
                    <?php if($paxAdult2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalpaxA".$slabId11}); ?></td>
                    <td align="center" bgcolor="#deb887">Pax</td>
                    <td align="center" bgcolor="#deb887"><?php echo ($paxAdult2); ?></td>
                    <td align="right" bgcolor="#deb887"><?php ${"grandTotalPaxA".$slabId11}=${"totalpaxA".$slabId11}*$paxAdult2; echo getTwoDecimalNumberFormat(${"grandTotalPaxA".$slabId11});?></td>
                    </tr>
                    <?php } if($paxChild2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Child)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalpaxC".$slabId11}); ?></td>
                    <td align="center" bgcolor="#deb887">Pax</td>
                    <td align="center" bgcolor="#deb887"><?php echo ($paxChild2); ?></td>
                    <td align="right" bgcolor="#deb887"><?php ${"grandTotalPaxC".$slabId11} =${"totalpaxC".$slabId11}*$paxChild2; echo getTwoDecimalNumberFormat(${"grandTotalPaxC".$slabId11});?></td>
                    </tr>
                    <?php }if($paxInfant2 >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Land Arrangement(Infant)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalpaxE".$slabId11}); ?></td>
                    <td align="center" bgcolor="#deb887">Pax</td>
                    <td align="center" bgcolor="#deb887"><?php echo ($paxInfant2); ?></td>
                    <td align="right" bgcolor="#deb887"><?php ${"grandTotalPaxE".$slabId11} =${"totalpaxE".$slabId11}*$paxInfant2;
                    echo getTwoDecimalNumberFormat(${"grandTotalPaxE".$slabId11});?></td>
                    </tr>
                    <?php } ?>
                    <?php if($groupDivideFactor >0 && ${"transGuideCostA".$slabId11}>0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Private Transport/Guide</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"transGuideCostA".$slabId11}); ?></td>
                    <td align="center" bgcolor="#deb887">D.F.</td>
                    <td align="center" bgcolor="#deb887"><?php echo ($groupDivideFactor); ?></td>
                    <td align="right" bgcolor="#deb887" ><?php ${"grandTotalTGCost".$slabId11}=${"transGuideCostA".$slabId11}*$groupDivideFactor; echo getTwoDecimalNumberFormat(${"grandTotalTGCost".$slabId11} );?></td>
                    </tr>
                    <?php } ?>
                    <?php if($slabAndRoomType == 2 && $paxAdult2>0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Flight Arrangement(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalflightA".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"></td>
                    <td align="right" bgcolor="#deb887"></td>
                    <td align="right" bgcolor="#deb887"><?php ${"grandTotalPaxA".$slabId11}=${"totalflightA".$val}; echo getTwoDecimalNumberFormat(${"grandTotalPaxA".$slabId11});?></td>
                    </tr>
                    <?php } if($slabAndRoomType == 2 && $paxChild2>0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Flight Arrangement(Child)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"totalflightC".$val}); ?></td>
                    <td align="center" bgcolor="#deb887"></td>
                    <td align="right" bgcolor="#deb887"></td>
                    <td align="right" bgcolor="#deb887"><?php ${"grandTotalPaxC".$slabId11} =${"totalflightC".$val}; echo getTwoDecimalNumberFormat(${"grandTotalPaxC".$slabId11});?></td>
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
                    <td align="right" bgcolor="#dec7c7"><?php ${"totalsingleLE".$val}=getFOCCost(${"totalsingleLE".$val},$groupSlabPPD['id'],"LE","hotel",$quotationId);
                    echo getTwoDecimalNumberFormat(${"totalsingleLE".$val}); ?></td>
                    <td align="center" bgcolor="#dec7c7">Room</td>
                    <td align="right" bgcolor="#dec7c7"><?php echo ($sglRoomLE); ?></td>
                    <td align="right" bgcolor="#dec7c7"><?php ${"grandSingleLE".$slabId11} =${"totalsingleLE".$val}*$sglRoomLE;echo getTwoDecimalNumberFormat(${"grandSingleLE".$slabId11});?></td>
                    </tr>
                    <?php } if($dblRoomLE >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#dec7c7"><strong>Double&nbsp;Room(Local)</strong></td>
                    <td align="right" bgcolor="#dec7c7"><?php ${"totaldoubleLE".$val} = getFOCCost(${"totaldoubleLE".$val},$groupSlabPPD['id'],"LE","hotel",$quotationId);
                    echo getTwoDecimalNumberFormat(${"totaldoubleLE".$val}); ?></td>
                    <td align="center" bgcolor="#dec7c7">Room</td>
                    <td align="right" bgcolor="#dec7c7"><?php echo ($dblRoomLE); ?></td>
                    <td align="right" bgcolor="#dec7c7"><?php ${"grandDoubleLE".$slabId11} = ${"totaldoubleLE".$val}*$dblRoomLE; 
                    echo getTwoDecimalNumberFormat(${"grandDoubleLE".$slabId11});?></td>
                    </tr>
                    <?php }if($sglRoomFE>0){ ?>
                    <tr>
                    <td align="left" bgcolor="#d4d5f0"><strong>Single&nbsp;Room(Foriegn)</strong></td>
                    <td align="right" bgcolor="#d4d5f0"><?php 
                    ${"totalsingleFE".$val} = getFOCCost(${"totalsingleFE".$val},$groupSlabPPD['id'],"FE","hotel",$quotationId);
                    echo getTwoDecimalNumberFormat(${"totalsingleFE".$val}); ?></td>
                    <td align="center" bgcolor="#d4d5f0">Room</td>
                    <td align="right" bgcolor="#d4d5f0"><?php echo ($sglRoomFE); ?></td>
                    <td align="right" bgcolor="#d4d5f0"><?php ${"grandSingleFE".$slabId11} =${"totalsingleFE".$val}*$sglRoomFE;echo getTwoDecimalNumberFormat(${"grandSingleFE".$slabId11});?></td>
                    </tr>
                    <?php }if($dblRoomFE>0){ ?>
                    <tr>
                    <td align="left" bgcolor="#d4d5f0"><strong>Double&nbsp;Room(Foriegn)</strong></td>
                    <td align="right" bgcolor="#d4d5f0"><?php 
                      ${"totaldoubleFE".$val} = getFOCCost(${"totaldoubleFE".$val},$groupSlabPPD['id'],"FE","hotel",$quotationId);
                      echo getTwoDecimalNumberFormat(${"totaldoubleFE".$val}); ?></td>
                    <td align="center" bgcolor="#d4d5f0">Room</td>
                    <td align="right" bgcolor="#d4d5f0"><?php echo ($dblRoomFE); ?></td>
                    <td align="right" bgcolor="#d4d5f0"><?php ${"grandDoubleFE".$slabId11} =${"totaldoubleFE".$val}*$dblRoomFE; echo getTwoDecimalNumberFormat(${"grandDoubleFE".$slabId11});?></td>
                    </tr>
                    <?php }
                    }
                    if(${"totalPaxLE" . $slabId11} >0 && $paxAdultLE > 0){ ?>
                    <tr>
                    <td align="left" bgcolor="#dec7c7"><strong>Land Arrangement(Local)</strong></td>
                    <td align="right" bgcolor="#dec7c7"><?php echo getTwoDecimalNumberFormat(${"totalPaxLE" . $slabId11}); ?></td>
                    <td align="center" bgcolor="#dec7c7">Pax</td>
                    <td align="right" bgcolor="#dec7c7"><?php echo ($paxAdultLE); ?></td>
                    <td align="right" bgcolor="#dec7c7"><?php ${"grandTotalPaxLE".$slabId11}=${"totalPaxLE" . $slabId11}*$paxAdultLE; echo getTwoDecimalNumberFormat(${"grandTotalPaxLE".$slabId11});?></td>
                    </tr> 
                    <?php if($paxAdultLE >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Transport/Escort(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"transGuideCostALE".$slabId11}); ?></td>
                    <td align="center" bgcolor="#deb887">D.F.</td>
                    <td align="center" bgcolor="#deb887"><?php echo ($paxAdultLE); ?></td>
                    <td align="right" bgcolor="#deb887" ><?php ${"grandTotalTGCostALE".$slabId11}=${"transGuideCostALE".$slabId11}*$paxAdultLE; echo getTwoDecimalNumberFormat(${"grandTotalTGCostALE".$slabId11} );?></td>
                    </tr>
                    <?php } ?>
                    <?php 
                    } 

                    if(${"totalPaxFE" . $slabId11} >0 && $paxAdultFE>0){ ?>
                    <tr>
                    <td align="left" bgcolor="#d4d5f0"><strong>Land Arrangement(Foriegn)</strong></td>
                    <td align="right" bgcolor="#d4d5f0"><?php echo getTwoDecimalNumberFormat(${"totalPaxFE" . $slabId11}); ?></td>
                    <td align="center"bgcolor="#d4d5f0">Pax</td>
                    <td align="right" bgcolor="#d4d5f0"><?php echo ($paxAdultFE); ?></td>
                    <td align="right" bgcolor="#d4d5f0"><?php ${"grandTotalPaxFE".$slabId11}=${"totalPaxFE" . $slabId11}*$paxAdultFE; echo getTwoDecimalNumberFormat(${"grandTotalPaxFE".$slabId11});?></td>
                    </tr>   
                    <?php if($paxAdultFE >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#deb887"><strong>Transport/Escort(Adult)</strong></td>
                    <td align="right" bgcolor="#deb887"><?php echo getTwoDecimalNumberFormat(${"transGuideCostAFE".$slabId11}); ?></td>
                    <td align="center" bgcolor="#deb887">D.F.</td>
                    <td align="center" bgcolor="#deb887"><?php echo ($paxAdultFE); ?></td>
                    <td align="right" bgcolor="#deb887" ><?php ${"grandTotalTGCostAFE".$slabId11}=${"transGuideCostAFE".$slabId11}*$paxAdultFE; echo getTwoDecimalNumberFormat(${"grandTotalTGCostAFE".$slabId11} );?></td>
                    </tr>
                    <?php } 

                    }
                    ?>
                    <tr>
                        <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Cost&nbsp;of the Trip (<?php echo getCurrencyName($baseCurrencyId); ?>) </strong></td>
                        <td align="right"  style=" font-weight: 800; "><?php 
                          // TOTAL COST WITH ESCORT AND ALL MONUMENTS grandTotalPaxE
                          ${"grandTotalCost".$slabId11} = ${"grandSingle".$slabId11}+${"grandDouble".$slabId11}+${"grandTwin".$slabId11}+${"grandTriple".$slabId11}+${"grandQuadBed".$slabId11}+${"grandSixBed".$slabId11}+${"grandEightBed".$slabId11}+${"grandTenBed".$slabId11}+${"grandTeenBed".$slabId11}+${"grandAWB".$slabId11}+${"grandChildWB".$slabId11}+${"grandChildNB".$slabId11}+${"grandTotalPaxA".$slabId11}+${"grandTotalTGCost".$slabId11}+${"grandTotalPaxC".$slabId11}+${"grandTotalPaxE".$slabId11}+${"grandSingleLE".$slabId11}+${"grandDoubleLE".$slabId11}+${"grandSingleFE".$slabId11}+${"grandDoubleFE".$slabId11}+${"grandTotalPaxLE".$slabId11}+${"grandTotalTGCostALE".$slabId11}+${"grandTotalPaxFE".$slabId11}+${"grandTotalTGCostAFE".$slabId11}; 

                          echo ${"supplierCost".$slabId11} = getTwoDecimalNumberFormat(${"grandTotalCost".$slabId11});

                        //   +$totalSaleVisaA+$totalSaleVisaC+$totalSaleVisaE+$totalSalePassportA+$totalSalePassportC+$totalSalePassportE+$totalSaleInsuranceA+$totalSaleInsuranceC+$totalSaleInsuranceE
                          ?> 
                        </td> 
                    </tr>
                    <?php  

                    ${"grandTotalPriceSensitivityCost".$slabId11} = 0;
                    if ($priceSenValue>0){ 
                        $servicePriceSenLable  = '(+) Price Sensitivity ('.$priceSenValue.'%)';
                        ${"grandTotalPriceSensitivityCost".$slabId11} = getMarkupCost(${"grandTotalCost".$slabId11}, $priceSenValue, 1);
                    }

                    if ($serviceMarkup > 0 && $isUni_Mark == 1 && $isSer_Mark == 0) { 
                        $serviceMarkupLable='';
                        if ($financeresult['markupSerType'] == '1') {
                            $serviceMarkupLable='(+) MarkUp ('.$serviceMarkup.'';
                        }
                        if ($financeresult['markupSerType'] == '2') {
                            $serviceMarkupLable='(+) Service Charge ('.$serviceMarkup.'';
                        }
                        if($markupType == 1){
                            $serviceMarkupLable  .= '%)';
                            $serviceMarkup2 = $serviceMarkup;
                            $markupLable = $serviceMarkup.'%';
                        }else{
                            $serviceMarkupLable  .= 'Flat) Per Pax For '.$totalPax.'pax';
                            $serviceMarkup2 = $serviceMarkup*$totalPax;
                            $markupLable = $serviceMarkup.'Flat';
                        }

                        ${"grandTotalMarkupCost".$slabId11} = getMarkupCost(${"grandTotalCost".$slabId11}, $serviceMarkup2, $markupType);

                        ${"grandTotalMarkupCostWPSensitivity".$slabId11} = (${"grandTotalMarkupCost".$slabId11}+${"grandTotalPriceSensitivityCost".$slabId11});

                        ${"grandTotalCostWithMarkup".$slabId11} = ${"grandTotalCost".$slabId11} = ${"grandTotalCost".$slabId11} + ${"grandTotalMarkupCostWPSensitivity".$slabId11};

                        // ${"supplierCost".$slabId11} = ${"grandTotalCost".$slabId11}
                       
                    ?> 
                    <tr>
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupLable;?></strong></td>
                    <td align="right" ><?php echo getTwoDecimalNumberFormat(${"grandTotalMarkupCost".$slabId11});?></td> 
                    </tr>
                    <?php 
                    if ($priceSenValue>0) { ?> 
                        <tr>
                            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $servicePriceSenLable; ?></strong></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"grandTotalPriceSensitivityCost".$slabId11});?></td> 
                        </tr>
                        <tr>
                            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Markup After Price Sensitivity Cost</strong></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"grandTotalMarkupCostWPSensitivity".$slabId11});?></td> 
                        </tr>
                    <?php } ?>
                    <tr>
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Markup (<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                    <td align="right" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"grandTotalCost".$slabId11});?></td> 
                    </tr>
                    <?php } ?>


                    <?php 
                    if ($discount>0) {
                      if ($discountType == '1') {
                          $discountLable='(-) Discount ('.$discount.'%)';
                      }else{
                          $discountLable  = '(-) Discount ('.$discount.'Flat)';
                      } 
                      // echo ($discountType == 1) ? '&nbsp;(%)' : '&nbsp;(Flat)';
                      ${"grandTotalDiscountCost".$slabId11} = getMarkupCost(${"grandTotalCost".$slabId11}, $discount, $discountType);
                      ${"grandTotalCost".$slabId11} = ${"grandTotalCost".$slabId11} - ${"grandTotalDiscountCost".$slabId11};
                      ?> 
                      <tr>
                      <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $discountLable; ?></strong></td>
                      <td align="right" ><?php echo getTwoDecimalNumberFormat(${"grandTotalDiscountCost".$slabId11});?></td> 
                      </tr>
                      <tr>
                      <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Discount &nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                      <td align="right" style=" font-weight: 800; "><?php echo getTwoDecimalNumberFormat(${"grandTotalCost".$slabId11});?></td> 
                      </tr>
                    <?php } ?>
                    <?php 
                    if(${"totalExtraNoMarkupG".$val}>0){ 
                        ${"grandTotalCost".$slabId11}=${"grandTotalCost".$slabId11}+${"totalExtraNoMarkupG".$val};
                        ?>
                    <tr>
                        <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>(+) Miscellaneous Cost</strong></td>
                        <td align="right" ><?php echo getTwoDecimalNumberFormat(${"totalExtraNoMarkupG".$val});?></td> 
                    </tr>
                    <?php } ?>
                    <?php 
                    if ($serviceTax>0 || $tcsTax>0) {
                        if ($serviceTax>0) {
                            if ($financeresult['taxType'] == '1') {
                                $serviceMarkupLable  = '(+) GST ('.$serviceTax.'%)';
                            }
                            if ($financeresult['taxType'] == '2') {
                                $serviceMarkupLable  = '(+) VAT ('.$serviceTax.'%)';
                            }
                        }

                        $taxType = 1; 
                        ${"grandTotalTCSCost".$slabId11} = 0;
                        if ($tcsTax>0){ 
                            $serviceTCSLable  = '(+) TCS ('.$tcsTax.'%)';
                            ${"grandTotalTCSCost".$slabId11} = getMarkupCost(${"grandTotalCost".$slabId11}, $tcsTax, $taxType);
                        }

                        ${"grandTotalServiceTaxCost".$slabId11} = getMarkupCost(${"grandTotalCost".$slabId11}, $serviceTax, $taxType, $serviceTaxDivident);
                        ${"grandTotalCost".$slabId11}=${"grandTotalCost".$slabId11}+${"grandTotalServiceTaxCost".$slabId11}+${"grandTotalTCSCost".$slabId11};

                        if($serviceTax>0){ ?>
                        <tr>
                            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceMarkupLable;?></strong></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"grandTotalServiceTaxCost".$slabId11});?></td> 
                        </tr>
                        <?php } ?>
                        <?php if ($tcsTax>0){ ?>
                        <tr>
                            <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong><?php echo $serviceTCSLable;?></strong></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat(${"grandTotalTCSCost".$slabId11});?></td> 
                        </tr>
                        <?php } ?>
                      <?php 
                    } 
                    ?>
                    
                    <?php 
                    ${"clientCost".$slabId11} = ${"proposalCost".$slabId11} = ${"grandTotalCost".$slabId11};
                    ?>
                    <tr>
                        <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Tour&nbsp;Cost&nbsp;(<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                        <td align="right" style=" font-weight: 800; "><?php echo  getTwoDecimalNumberFormat(${"grandTotalCost".$slabId11}); ?></td> 
                    </tr>
                    <?php if($newCurr!=$baseCurrencyId){ ?>
                    <tr>
                    <td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Tour&nbsp;Cost&nbsp;(In <?php echo getCurrencyName($newCurr); ?>)</strong></td>
                    <td align="right"  style=" font-weight: 800; "><?php echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"grandTotalCost".$slabId11}); ?></td> 
                    </tr> 
                    <?php } ?>
                </table> 
                </td> 
                <?php 
            } 
        ?>
        </tr>
        </table> 
        <!--END TOTAL TOUR COST SLAB WISE -->
        <?php if($resultpageQuotation['visaCostType']==1 || $resultpageQuotation['insuranceCostType']==1){ ?>
            <br>
            <table width="100%" cellpadding="5" border="1" bordercolor="#000000" cellspacing="0" style="font-size: 12px;">
            <tr><th colspan="8">Value Added Services Cost Summary</th></tr>
                <tr>
                    <td><strong>Service&nbsp;Type</strong></td>
                    <td><strong>Purchase&nbsp;Cost</strong></td>
                    <td><strong>Markup</strong></td>
                    <td><strong>Markup&nbsp;Cost</strong></td>
                    <td><strong>Sale&nbsp;Amount</strong></td>
                    <td><strong>Service&nbsp;Tax</strong></td>
                    <td><strong>TCS</strong></td>
                    <td><strong>Final&nbsp;Cost</strong></td>
                </tr>
                <?php
                if ($isUni_Mark == 0 && $isSer_Mark == 1) { 
                        
                        ${"grandTotalMarkupCost".$slabId11} = ${"serviceWiseMarkupCost".$val};

                        ${"grandTotalCostWithMarkup".$slabId11} = ${"supplierCost".$slabId11};
                        
                        
                        if($visaMarkupType==1){
                           $visaMarkup = $visa.'%';
                        }else{
                            $visaMarkup = $visa.'Flat';
                        }

                        if($insuranceMarkupType==1){
                            $insuranceMarkup = $insurance.'%';
                         }else{
                             $insuranceMarkup = $insurance.'Flat';
                         }
                         
                    }else{
                        
                        if($markupType==1){
                            $insuranceMarkup = $serviceMarkup.'%';
                            $visaMarkup = $serviceMarkup.'%';
                         }else{
                             $insuranceMarkup = $serviceMarkup.'Flat';
                             $visaMarkup = $serviceMarkup.'Flat';
                         }
                    }


                    // cost summary calculation
            $visaPurchaseCost=$visaServicePCost=$totalFeeVisa=$visaFinalCost=$visaNonTaxableAMT=$taxApplicable=0;
            if($resultpageQuotation['visaCostType']==1){
            $VR=''; 
            $VR = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            while($getVisaCost = mysqli_fetch_array($VR)){

                $visaAdultPax = $getVisaCost['adultPax'];
                $visaChildPax = $getVisaCost['childPax'];
                $visaInfantPax = $getVisaCost['infantPax'];
                $currencyValue = $getVisaCost['currencyValue'];
    
            $processingFee = $getVisaCost['processingFee'];
            $taxApplicable = $getVisaCost['taxApplicable'];
            $processingFeetype = $getVisaCost['markupType'];
            if($processingFeetype==1){
                $pfeeVlabel = $processingFee.'%';
            }else{
                $pfeeVlabel = $processingFee.' Flat';
            }
            $purchaseVisaApp = convert_to_base($currencyValue, $baseCurrencyVal,($getVisaCost['adultCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));        

            $purchaseVisaCpp = convert_to_base($currencyValue, $baseCurrencyVal,($getVisaCost['childCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));
            $purchaseVisaEpp = convert_to_base($currencyValue, $baseCurrencyVal,($getVisaCost['infantCost']+$getVisaCost['vfsCharges']+$getVisaCost['embassyFee']));   

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

            if($taxApplicable==1){
                   $NonTaxableAMT = $NonTaxableAMT+($visaPurchaseCost+$pFeeVisa);
                }


            $visaServicePCost = $visaServicePCost+$visaPurchaseCost;
            $totalFeeVisa = $totalFeeVisa+$pFeeVisa;
            if($taxApplicable==0){
            $visataxAmount = $visataxAmount + getMarkupCost($pFeeVisa, $serviceTax, 1, $serviceTaxDivident);
            }
            // Adult PP Cost
            if($taxApplicable==0){
                $visataxAmountApp = getMarkupCost($pFeeVisppA, $serviceTax, 1, $serviceTaxDivident);
                $visataxAmountCpp = getMarkupCost($pFeeVisppC, $serviceTax, 1, $serviceTaxDivident);
                $visataxAmountEpp = getMarkupCost($pFeeVisppE, $serviceTax, 1, $serviceTaxDivident);
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
          
            $visatcsAmount = getMarkupCost($totalFeeVisa, $tcsTax, 1);

            $visaFinalCost = $saleVisaCost+$visataxAmount+$visatcsAmount;
            $totalVisaServiceCost = $totalVisaServiceCost + $visaFinalCost;

                
            }
              ${"visaNonTaxableAMT".$slabId11} = $NonTaxableAMT;
            $grandTotalVisaCost = $totalVisaServiceCost;


            
            $purchaseInsuranceApp = $purchaseInsuranceCpp = $purchaseInsuranceEpp=$insuranceServicePCost=$totalpFeeins=0;
            if($resultpageQuotation['insuranceCostType']==1){
                $VR=''; 
                $VR = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
                while($getInsuranceCost = mysqli_fetch_array($VR)){
                    
                    $insProcessingFee = $getInsuranceCost['processingFee'];
                    $insProcessingFeetype = $getInsuranceCost['markupType'];
                    $currencyValue = $getInsuranceCost['currencyValue'];

                    if($insProcessingFeetype==1){
                        $pfeeInlabel = $insProcessingFee.'%';
                    }else{
                        $pfeeInlabel = $insProcessingFee.' Flat';
                    }
              
                    $purchaseInsuranceApp = convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['adultCost']);        
                    $purchaseInsuranceCpp = convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['childCost']);        
                    $purchaseInsuranceEpp = convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['infantCost']);  

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
                
                $instaxAmountApp = getMarkupCost($pFeeInsuranceApp, $serviceTax, 1 ,$serviceTaxDivident);
                $instcsAmountApp = getMarkupCost($pFeeInsuranceApp, $tcsTax, 1);
                $ppCostONAdultBasis = $ppCostONAdultBasis+($purchaseInsuranceApp+$pFeeInsuranceApp+$instaxAmountApp+$instcsAmountApp);
                
                // Child PP Cost
                $pFeeInsuranceCpp = getMarkupCost($purchaseInsuranceCpp,$insProcessingFee,$insProcessingFeetype); 
                
                $instaxAmountCpp = getMarkupCost($pFeeInsuranceCpp, $serviceTax, 1 ,$serviceTaxDivident);
                $instcsAmountCpp = getMarkupCost($pFeeInsuranceCpp, $tcsTax, 1);
                $ppCostONChildBasis = $ppCostONChildBasis+($purchaseInsuranceCpp+$pFeeInsuranceCpp+$instaxAmountCpp+$instcsAmountCpp); 

                // Infant PP Cost
                $pFeeInsuranceEpp = getMarkupCost($purchaseInsuranceEpp,$insProcessingFee,$insProcessingFeetype); 
                
                $instaxAmountEpp = getMarkupCost($pFeeInsuranceEpp, $serviceTax, 1 ,$serviceTaxDivident);
                $instcsAmountEpp = getMarkupCost($pFeeInsuranceEpp, $tcsTax, 1);
                $ppCostOnInfantBasis = $ppCostOnInfantBasis+($purchaseInsuranceEpp+$pFeeInsuranceEpp+$instaxAmountEpp+$instcsAmountEpp); 
                    
                }
                $saleInsuranceCost = $insuranceServicePCost+$totalpFeeins;
                $instaxAmount = getMarkupCost($totalpFeeins, $serviceTax, 1 ,$serviceTaxDivident);
                $instcsAmount = getMarkupCost($totalpFeeins, $tcsTax, 1);
            
                $insuranceFinalCost = $saleInsuranceCost+$instaxAmount+$instcsAmount;
            } 

            $grandTotalInsuranceCost = $insuranceFinalCost;

      
            ?> 
                <tr>
                    <td><strong>Package&nbsp;Cost</strong></td>
                    <td><?php echo getTwoDecimalNumberFormat(${"supplierCost".$slabId11}); ?></td>
                    <td><?php echo $markupLable; ?></td>
                    <td><?php echo getTwoDecimalNumberFormat(${"grandTotalMarkupCost".$slabId11});?></td>
                    <td><?php echo getTwoDecimalNumberFormat(${"grandTotalCostWithMarkup".$slabId11});?></td>
                    <td><?php echo getTwoDecimalNumberFormat(${"grandTotalServiceTaxCost".$slabId11});?></td>
                    <td><?php echo getTwoDecimalNumberFormat(${"grandTotalTCSCost".$slabId11});?></td>
                    <td><?php echo getTwoDecimalNumberFormat(${"grandTotalCost".$slabId11});?></td>
                </tr>
                <?php if($resultpageQuotation['visaCostType']==1){ ?>
                    
                <tr>
                    <td><strong>Visa&nbsp;Cost</strong></td>
                    <td><?php echo getTwoDecimalNumberFormat($visaServicePCost); ?></td>
                    <td><?php echo $pfeeVlabel; ?></td>
                    <td><?php echo getTwoDecimalNumberFormat($totalFeeVisa);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($saleVisaCost);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($visataxAmount);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($visatcsAmount);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($grandTotalVisaCost);?></td>
                </tr>
                <?php } ?>
                <?php if($resultpageQuotation['insuranceCostType']==1){ ?>
                <tr>
                    <td><strong>Insurance&nbsp;Cost</strong></td>
                    <td><?php echo getTwoDecimalNumberFormat($insuranceServicePCost); ?></td>
                    <td><?php echo $pfeeInlabel; ?></td>
                    <td><?php echo getTwoDecimalNumberFormat($totalpFeeins);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($saleInsuranceCost);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($instaxAmount);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($instcsAmount);?></td>
                    <td><?php echo getTwoDecimalNumberFormat($grandTotalInsuranceCost);?></td>
                </tr>
                <?php } 
                
                 ${"grandTotalCost".$slabId11} = ${"grandTotalCost".$slabId11}+$grandTotalInsuranceCost+$grandTotalVisaCost;
                 ${"clientCost".$slabId11} = ${"proposalCost".$slabId11} = ${"grandTotalCost".$slabId11};
                 ${"supplierCost".$slabId11}=${"supplierCost".$slabId11}+$insuranceServicePCost+$visaServicePCost;
                 ${"grandTotalMarkupCost".$slabId11} = ${"grandTotalMarkupCost".$slabId11}+$totalpFeeins+$totalFeeVisa;
                 ${"grandTotalCostWithMarkup".$slabId11} = ${"grandTotalCostWithMarkup".$slabId11}+$saleVisaCost+$saleInsuranceCost;
                 ${"grandTotalServiceTaxCost".$slabId11} = ${"grandTotalServiceTaxCost".$slabId11}+$instaxAmount+$visataxAmount;
                 ${"grandTotalTCSCost".$slabId11} = ${"grandTotalTCSCost".$slabId11}+$instcsAmount+$visatcsAmount;
                ?>
                <tr><td align="right"><Strong>Total</Strong></td>
                <td><strong><?php echo getTwoDecimalNumberFormat(${"supplierCost".$slabId11}); ?></strong></td>
                <td><strong>&nbsp;</strong></td>
                <td><strong><?php echo getTwoDecimalNumberFormat(${"grandTotalMarkupCost".$slabId11}); ?></strong></td>
                <td><strong><?php echo getTwoDecimalNumberFormat(${"grandTotalCostWithMarkup".$slabId11}); ?></strong></td>
                <td><strong><?php echo getTwoDecimalNumberFormat(${"grandTotalServiceTaxCost".$slabId11}); ?></strong></td>
                <td><strong><?php echo getTwoDecimalNumberFormat(${"grandTotalTCSCost".$slabId11}); ?></strong></td>
                <td><strong><?php echo getTwoDecimalNumberFormat(${"grandTotalCost".$slabId11}); ?></strong></td>
                </tr>
            </table>
            <?php } ?>
        <br>

        <?php 
        if($resultpageQuotation['queryType']==6 || $resultpageQuotation['queryType']==7 || $resultpageQuotation['queryType']==8 || $resultpageQuotation['queryType']==9 || $resultpageQuotation['queryType']==10 || $resultpageQuotation['queryType']==11){

            if ($serviceMarkup > 0 && $isUni_Mark == 1 && $isSer_Mark == 0){ 
                ${"paxAdultwMarkup".$slabId11} = getMarkupCost(${"grandTotalPaxA".$slabId11}, $serviceMarkup2, $markupType);
                ${"paxChildwMarkup".$slabId11} = getMarkupCost(${"grandTotalPaxC".$slabId11}, $serviceMarkup2, $markupType);
                ${"paxInfantwMarkup".$slabId11} = getMarkupCost(${"grandTotalPaxE".$slabId11}, $serviceMarkup2, $markupType);

                ${"tansGuidewMarkupcost".$slabId11} = getMarkupCost(${"transGuideCostA".$slabId11}, $serviceMarkup2, $markupType);

                ${"grandTotalPaxA".$slabId11} = ${"paxAdultwMarkup".$slabId11}+${"grandTotalPaxA".$slabId11};
                ${"grandTotalPaxC".$slabId11} = ${"paxChildwMarkup".$slabId11}+${"grandTotalPaxC".$slabId11};
                ${"grandTotalPaxE".$slabId11} = ${"paxInfantwMarkup".$slabId11}+${"grandTotalPaxE".$slabId11};

                ${"transGuideCostA".$slabId11} = ${"tansGuidewMarkupcost".$slabId11}+${"transGuideCostA".$slabId11};
            }
            if($serviceTax>0){
                ${"paxAdultServiceTaxCost".$slabId11} = getMarkupCost(${"grandTotalPaxA".$slabId11}, $serviceTax, $taxType, $serviceTaxDivident);
                ${"paxChildServiceTaxCost".$slabId11} = getMarkupCost(${"grandTotalPaxC".$slabId11}, $serviceTax, $taxType, $serviceTaxDivident);
                ${"paxInfantServiceTaxCost".$slabId11} = getMarkupCost(${"grandTotalPaxE".$slabId11}, $serviceTax, $taxType, $serviceTaxDivident);
                ${"transGuideServiceTaxCost".$slabId11} = getMarkupCost(${"transGuideCostA".$slabId11}, $serviceTax, $taxType, $serviceTaxDivident);
            }

            if($tcsTax>0){
                ${"paxAdulttcsTaxCost".$slabId11} = getMarkupCost(${"grandTotalPaxA".$slabId11}, $tcsTax, $taxType);
                ${"paxChildtcsTaxCost".$slabId11} = getMarkupCost(${"grandTotalPaxC".$slabId11}, $tcsTax, $taxType);
                ${"paxInfanttcsTaxCost".$slabId11} = getMarkupCost(${"grandTotalPaxE".$slabId11}, $tcsTax, $taxType);

               ${"transGuidetcsTaxCost".$slabId11} = getMarkupCost(${"transGuideCostA".$slabId11}, $serviceTax, $taxType, $serviceTaxDivident);
            }

            $grandtotalpaxAdulttfs = ${"paxAdultServiceTaxCost".$slabId11}+${"paxAdulttcsTaxCost".$slabId11}+${"grandTotalPaxA".$slabId11};
            $grandtotalpaxChildtfs = ${"paxChildServiceTaxCost".$slabId11}+${"paxChildtcsTaxCost".$slabId11}+${"grandTotalPaxC".$slabId11};
            $grandtotalpaxInfanttfs = ${"paxInfantServiceTaxCost".$slabId11}+${"paxInfanttcsTaxCost".$slabId11}+${"grandTotalPaxE".$slabId11};

            $grandTotaltransguidetfs = ${"transGuideServiceTaxCost".$slabId11}+${"transGuidetcsTaxCost".$slabId11}+${"transGuideCostA".$slabId11};

            $perAdultCostTFS = $grandtotalpaxAdulttfs/$paxAdult;

            $perChildCostTFS = $grandtotalpaxChildtfs/$paxChild;
            $perInfantCostTFS = $grandtotalpaxInfanttfs/$paxInfant;

            $perAdultCostTFS = $grandTotaltransguidetfs+$perAdultCostTFS;
            $perChildCostTFS = $grandTotaltransguidetfs+$perChildCostTFS;
            ?>
            
            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                 <tr><th colspan="2">PER PAX COST</th></tr>
                <tr>
                    <th align="left">Per Pax</th><th align="left">Cost</th>
                </tr>
                <?php if($paxAdult>0){ ?>
                <tr><td align="left">Per Adult Cost</td>
                <td align="left"><?php echo getTwoDecimalNumberFormat($perAdultCostTFS); ?></td></tr>
                <?php }  if($paxChild>0){?>
                <tr><td align="left">Per Child Cost</td>
                <td align="left"><?php echo getTwoDecimalNumberFormat($perChildCostTFS); ?></td></tr>
                <?php }  if($paxInfant>0){?>
                <tr><td align="left">Per Infant Cost</td>
                <td align="left"><?php echo getTwoDecimalNumberFormat($perInfantCostTFS); ?></td></tr>
                <?php } ?>
            </table>o
            <?php 
        }else{ ?>
            <!--START PER PERSON BASIS COST -->
            <strong style="font-size:12px;text-transform: uppercase;">Per Pax Cost</strong>
            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                <tr>
                    <td align="left" bgcolor="#F5F5F5" ><strong>Occupancy</strong></td>
                    <?php 
                    if($discountType == 2){
                        $discount = $discount/$totalPax;
                    }

                    $groupSlabPPSql = "";
                    $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                    if (mysqli_num_rows($groupSlabPPSql)>0) {
                    while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                         $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        ${"ppCostONSingleBasis".$slabId11}=${"ppCostONDoubleBasis".$slabId11}=${"pcCostOnExtraBedCBasis".$slabId11}=${"ppCostOntripleBasis".$slabId11}=0;
                        if($groupSlabPPD['fromRange'] == $groupSlabPPD['toRange']){
                          $groupRangeLable = $groupSlabPPD['fromRange'].'&nbsp;Pax ';
                        }else{
                          $groupRangeLable = $groupSlabPPD['fromRange'].'&nbsp;To&nbsp;'.$groupSlabPPD['toRange'];
                        }
                        $cols = 1;
                        if($newCurr!=$baseCurrencyId){
                            $cols = 2;
                        }
                        ?>
                        <td align="right" bgcolor="#F5F5F5" colspan="<?php echo $cols; ?>" ><strong>Slab (<?php echo $groupRangeLable; ?>)</strong></td>
                        <?php
                    }
                    }  
                    ?>
                </tr>
                <?php if($singleRoom >0){ ?>


                <tr>
                    <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Single&nbsp;Basis</td>
                    <?php 
                    $groupSlabPPSql = "";
                    $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
                    if (mysqli_num_rows($groupSlabPPSql)>0) {
                    while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $singleRoom2 = $groupSlabPPD['sglRoom'];

                        if($slabAndRoomType == 2 && $singleRoom2>0){
                            ${"ppCostONSingleBasis".$slabId11} = ((${"totalsingle".$val}/$singleRoom2)+${"totalpaxA".$slabId11}+${"transGuideCostA".$slabId11});
                        }else{
                            ${"ppCostONSingleBasis".$slabId11} = ((${"totalsingle".$val}/$singleRoom2)+${"totalpaxA".$slabId11}+${"transGuideCostA".$slabId11});
                        }   
                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostONSingleBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostONSingleBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>'; 
                        if($newCurr!=$baseCurrencyId){ 
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostONSingleBasis".$slabId11});
                            echo '</td>'; 
                        }  
                    }
                    }  
                    ?>
                </tr>
                <?php }if($doubleRoom >0){ ?>
                <tr>
                    <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Double&nbsp;Basis</td>
                      <?php 
                      $groupSlabPPSql = "";
                      $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' .$quotationId.'" and status=1 order by fromRange asc');
                      if (mysqli_num_rows($groupSlabPPSql)>0) {
                      while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                            $slabId11 = $groupSlabPPD['id'].'C'.$val;
                            $doubleRoom2 = $groupSlabPPD['dblRoom'];

                            if($slabAndRoomType == 2 && $doubleRoom2>0){
                                ${"ppCostONDoubleBasis" . $slabId11} = ((${"totaldouble".$val}/($doubleRoom2*2))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                            }else{
                                ${"ppCostONDoubleBasis" . $slabId11} = ((${"totaldouble".$val}/($doubleRoom2*2))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                            }

                            echo '<td align="right" >';
                            echo getCurrencyName($baseCurrencyId).' ';
                            echo ${"ppCostONDoubleBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostONDoubleBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                            echo '</td>';
                            if($newCurr!=$baseCurrencyId){
                                echo '<td align="right" >';
                                echo getCurrencyName($newCurr).' ';  
                                echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostONDoubleBasis".$slabId11});
                                echo '</td>';
                            } 
                      }
                      }  
                    ?>
                </tr>
                <?php }if($twinRoom >0){ ?>
                <tr>
                    <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Twin&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $twinRoom2   = $groupSlabPPD['twinRoom'];
                        if($slabAndRoomType == 2 && $twinRoom2>0){
                            ${"ppCostONTwinBasis" . $slabId11} = ((${"totaltwin".$val}/($twinRoom2*2))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }else{
                            ${"ppCostONTwinBasis" . $slabId11} = ((${"totaltwin".$val}/2)+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }
                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostONTwinBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostONTwinBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostONTwinBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  }  
                    ?>
                </tr>
                <?php }if($tripleRoom >0){ ?>
                <tr>
                <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;triple&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $tripleRoom2 = $groupSlabPPD['tplRoom'];

                        if($slabAndRoomType == 2 && $tripleRoom2>0){
                            ${"ppCostOnTripleBasis" . $slabId11} = ((${"totaltriple".$val}/($tripleRoom2*3))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }else{
                            ${"ppCostOnTripleBasis" . $slabId11} = ((${"totaltriple".$val}/($tripleRoom2*3))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});

                        }
                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostOnTripleBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostOnTripleBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostOnTripleBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
              }  

                  ?>
                </tr><?php }if($quadBedRoom >0){ ?>
                <tr>
                <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;quad&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $quadBedRoom2 = $groupSlabPPD['quadNoofRoom'];

                        if($slabAndRoomType == 2 && $quadBedRoom2>0){
                            ${"ppCostOnQuadBasis" . $slabId11} = ((${"totalquadBed".$val}/($quadBedRoom2*4))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }else{
                            ${"ppCostOnQuadBasis" . $slabId11} = ((${"totalquadBed".$val}/($quadBedRoom2*4))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }
                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostOnQuadBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostOnQuadBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostOnQuadBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  }  
                  ?>
                </tr><?php }if($sixBedRoom >0){ ?>
                <tr>
                <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;SixBed&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $sixBedRoom2 = $groupSlabPPD['sixNoofBedRoom'];

                        if($slabAndRoomType == 2 && $sixBedRoom2>0){
                            ${"ppCostOnSixBasis" . $slabId11} = ((${"totalSixBed".$val}/($sixBedRoom2*6))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }else{
                            ${"ppCostOnSixBasis" . $slabId11} = ((${"totalSixBed".$val}/($sixBedRoom2*6))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }

                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostOnSixBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostOnSixBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostOnSixBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  } 
     
                  ?>
                </tr><?php }if($eightBedRoom >0){ ?>
                <tr>
                <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Eight&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $eightBedRoom2 = $groupSlabPPD['eightNoofBedRoom'];

                        if($slabAndRoomType == 2 && $eightBedRoom2>0){
                            ${"ppCostOnEightBasis" . $slabId11} = ((${"totaleightBed".$val}/($eightBedRoom2*8))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }else{
                            ${"ppCostOnEightBasis" . $slabId11} = ((${"totaleightBed".$val}/($eightBedRoom2*8))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }

                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostOnEightBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostOnEightBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostOnEightBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  }  
                  ?>
                </tr><?php }if($tenBedRoom >0){ ?>
                <tr>
                <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;TenBed&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $tenBedRoom2 = $groupSlabPPD['tenNoofBedRoom'];

                        if($slabAndRoomType == 2 && $tenBedRoom2>0){
                            ${"ppCostOnTenBasis" . $slabId11} = ((${"totaltenBed".$val}/($tenBedRoom2*10))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }else{
                            ${"ppCostOnTenBasis" . $slabId11} = ((${"totaltenBed".$val}/($tenBedRoom2*10))+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }

                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostOnTenBasis".$slabId11} = $ppCostONAdultBasis+getPerPersonBasisCost(${"ppCostOnTenBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostOnTenBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  }  
                  ?>
                </tr><?php }if($teenBedRoom >0){ ?>
                <tr>
                <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;On&nbsp;TeenBed&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $teenBedRoom2 = $groupSlabPPD['teenNoofRoom'];

                        if($slabAndRoomType == 2 && $teenBedRoom2>0){
                            ${"ppCostOnTeenBasis" . $slabId11} = ((${"totalteenBed".$val}/$teenBedRoom2)+${"totalpaxC" . $slabId11}+${"transGuideCostC" . $slabId11});
                        }else{
                            ${"ppCostOnTeenBasis" . $slabId11} = ((${"totalteenBed".$val}/$teenBedRoom2)+${"totalpaxC" . $slabId11}+${"transGuideCostC" . $slabId11});
                        }

                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostOnTeenBasis".$slabId11} = $ppCostONChildBasis+getPerPersonBasisCost(${"ppCostOnTeenBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostOnTeenBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  }  

                  ?>
                </tr>
                <?php } if($EBedAdult >0){ ?>
                <tr>
                <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;ExtraBed(A)&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $EBedAdult2 = $groupSlabPPD['extraNoofBed'];

                        if($slabAndRoomType == 2 && $EBedAdult2>0){
                            ${"ppCostOnExtraBedABasis" . $slabId11} = ((${"totalextraBedA".$val}/$EBedAdult2)+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }else{
                            ${"ppCostOnExtraBedABasis" . $slabId11} = ((${"totalextraBedA".$val}/$EBedAdult2)+${"totalpaxA" . $slabId11}+${"transGuideCostA" . $slabId11});
                        }
                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"ppCostOnExtraBedABasis".$slabId11} = $ppCostONChildBasis+getPerPersonBasisCost(${"ppCostOnExtraBedABasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"ppCostOnExtraBedABasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  }  
                  ?>
                </tr>
               
                <?php } if($EBedChild >0){ ?>
                <tr>
                  <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;On&nbsp;ExtraBed&nbsp;Basis</td>
                  <?php 
                  $groupSlabPPSql = "";
                  $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                  if (mysqli_num_rows($groupSlabPPSql)>0) {
                  while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $EBedChild2 = $groupSlabPPD['childwithNoofBed'];

                        if($slabAndRoomType == 2 && $EBedChild2>0){
                            ${"pcCostOnExtraBedCBasis" . $slabId11} = ((${"totalextraBedC".$val}/$EBedChild2)+${"totalpaxC" . $slabId11}+${"transGuideCostC" . $slabId11});
                        }else{
                            ${"pcCostOnExtraBedCBasis" . $slabId11} = ((${"totalextraBedC".$val}/$EBedChild2)+${"totalpaxC" . $slabId11}+${"transGuideCostC" . $slabId11});
                        }

                        echo '<td align="right" >'; 
                        echo getCurrencyName($baseCurrencyId).' '; 
                        echo ${"pcCostOnExtraBedCBasis".$slabId11} = $ppCostONChildBasis+getPerPersonBasisCost(${"pcCostOnExtraBedCBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"pcCostOnExtraBedCBasis".$slabId11});
                            echo '</td>';
                        } 
                  }
                  }  
                  ?>
                </tr>
                <?php }if($NBedChild >0){ ?>
                    <tr>
                    <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;On&nbsp;WithoutBed&nbsp;Basis</td>
                    <?php 
                    $groupSlabPPSql = "";
                    $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                    if (mysqli_num_rows($groupSlabPPSql)>0) {
                    while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                        $slabId11 = $groupSlabPPD['id'].'C'.$val;
                        $NBedChild2 = $groupSlabPPD['childwithoutNoofBed'];

                        if($slabAndRoomType == 2 && $NBedChild2>0){
                            ${"pcCostOnExtraNBedCBasis" . $slabId11} = ((${"totalextraNBedC".$val}/$NBedChild2)+${"totalpaxC" . $slabId11}+${"transGuideCostC" . $slabId11});
                        }else{
                            ${"pcCostOnExtraNBedCBasis" . $slabId11} = ((${"totalextraNBedC".$val}/$NBedChild2)+${"totalpaxC" . $slabId11}+${"transGuideCostC" . $slabId11});
                        }

                        echo '<td align="right" >';
                        echo getCurrencyName($baseCurrencyId).' ';
                        echo ${"pcCostOnExtraNBedCBasis".$slabId11} = $ppCostONChildBasis+getPerPersonBasisCost(${"pcCostOnExtraNBedCBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                        echo '</td>';
                        if($newCurr!=$baseCurrencyId){
                            echo '<td align="right" >';
                            echo getCurrencyName($newCurr).' ';  
                            echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"pcCostOnExtraNBedCBasis".$slabId11});
                            echo '</td>';
                        } 
                    }
                    }  
                    ?>
                    </tr>
         
                    <?php }if($paxInfant>0){ ?>
                    <tr>
                        <td align="left" bgcolor="#F5F5F5" >Per&nbsp;Infant&nbsp;Cost&nbsp;Basis</td>
                      <?php 
                      $groupSlabPPSql = "";
                      $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId="' . $quotationId . '" and status=1 order by fromRange asc');
                      if (mysqli_num_rows($groupSlabPPSql)>0) {
                      while($groupSlabPPD = mysqli_fetch_array($groupSlabPPSql)){
                          $slabId11 = $groupSlabPPD['id'].'C'.$val;
                          ${"peCostBasis" . $slabId11} = (${"totalpaxE" . $slabId11});
                          echo '<td align="right" >';
                          echo getCurrencyName($baseCurrencyId).' ';
                          echo ${"peCostBasis".$slabId11} = $ppCostOnInfantBasis+getPerPersonBasisCost(${"peCostBasis" . $slabId11},$serviceMarkup,$markupType,$discount,$discountType,$totalServiceTax,$isUni_Mark,'',$serviceTaxDivident);
                          echo '</td>';
                          if($newCurr!=$baseCurrencyId){
                                echo '<td align="right" >';
                                echo getCurrencyName($newCurr).' ';  
                                echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,${"peCostBasis".$slabId11});
                                echo '</td>';
                            } 
                      }
                      }  
                      ?>
                    </tr>
                    <?php 
                } 
                ?>
            </table>
            <br>
            <br>
        <?php } ?>
        <!--END PER PERSON BASIS COST -->
        <?php  
      
        $groupSlabPPSql = "";
        $groupSlabPPSql = GetPageRecord('*', 'totalPaxSlab', ' 1 and quotationId in ( select id from quotationMaster where  id="'.$quotationId.'" and status=1 ) and status=1 order by fromRange asc');
        if (mysqli_num_rows($groupSlabPPSql)>0) {
            $groupSlabPPD = mysqli_fetch_array($groupSlabPPSql);
            $slabId11 = $groupSlabPPD['id'].'C'.$val;
    
            
             $nameinv = 'totalCompanyCost="'.round(${"supplierCost".$slabId11}).'",totalQuotCost="'.${"clientCost".$slabId11}.'",totalMarkupCost="'.${"grandTotalMarkupCost".$slabId11}.'",totalISOCost="'.${"grandTotalISOCost".$slabId11}.'",totalConsortiaCost="'.${"grandTotalConsortiaCost".$slabId11}.'",totalClientCommCost="'.${"grandTotalClientCommCost".$slabId11}.'",totalDiscountCost="'.${"grandTotalDiscountCost".$slabId11}.'",totalServiceTaxCost="'.${"grandTotalServiceTaxCost".$slabId11}.'",totalTCSCost="'.${"grandTotalTCSCost".$slabId11}.'",sglBasisCost="'.${"ppCostONSingleBasis".$slabId11}.'",dblBasisCost="'.${"ppCostONDoubleBasis".$slabId11}.'",twinCost="'.${"ppCostONTwinBasis".$slabId11}.'",tplBasisCost="'.${"ppCostOnTripleBasis".$slabId11}.'",extraAdultCost="'.${"ppCostOnExtraBedABasis".$slabId11}.'",CWBCost="'.${"pcCostOnExtraBedCBasis".$slabId11}.'",CNBCost="'.${"pcCostOnExtraNBedCBasis".$slabId11}.'",nonTaxableAMT="'.${"visaNonTaxableAMT".$slabId11}.'"';

            updatelisting(_QUOTATION_MASTER_,$nameinv,'id="'.$quotationId.'"');
        }
        ?>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td valign="top">
            <!--START GENERAL INFO -->
            <span style="text-align:left;font-size: 18px;margin: 15px 0;    display: inline-block;"><strong>General Information</strong></span>
            <table  border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>Adult&nbsp;Pax</strong></td>
              <td align="center" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $paxAdult; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
              </tr>
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>Child&nbsp;Pax</strong></td>
              <td align="center" ><?php echo $paxChild; ?></td> 
              </tr> 
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>Infant&nbsp;Pax</strong></td>
              <td align="center" ><?php echo $paxInfant; ?></td> 
              </tr> 
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>Local&nbsp;Escort&nbsp;Pax</strong></td>
              <td align="center" ><?php echo $paxAdultLE; ?></td> 
              </tr>
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>Foreign&nbsp;Escort&nbsp;Pax</strong></td>
              <td align="center" ><?php echo $paxAdultFE; ?></td> 
              </tr>
              <tr>
              <td align="center" colspan="2" bgcolor="#F5F5F5" ></td>
              </tr>
                <?php if( $singleRoom >0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>Single&nbsp;Room</strong></td>
                <td align="center" ><?php echo $singleRoom; ?></td> 
                </tr>
                <?php } if( $doubleRoom >0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>Double&nbsp;Room</strong></td>
                <td align="center" ><?php echo $doubleRoom; ?></td> 
                </tr>
                <?php } if( $tripleRoom >0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>triple&nbsp;Room</strong></td>
                <td align="center" ><?php echo $tripleRoom; ?></td> 
                </tr>
                <?php } if( $twinRoom >0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>Twin&nbsp;Room</strong></td>
                <td align="center" ><?php echo $twinRoom; ?></td> 
                </tr>
                <?php } if( $EBedAdult >0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>Extra-Bed(A)</strong></td>
                <td align="center" ><?php echo $EBedAdult; ?></td> 
                </tr>
                <?php } if( $EBedChild >0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>ChildWBed</strong></td>
                <td align="center" ><?php echo $EBedChild; ?></td> 
                </tr>
                <?php } if( $NBedChild >0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>ChildNBed</strong></td>
                <td align="center" ><?php echo $NBedChild; ?></td> 
                </tr>
                <?php } ?>
              <tr>
              <td align="center" colspan="2" bgcolor="#F5F5F5" ></td>
              </tr>
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>
              <?php 
                $serviceMarkupLable='';
                if ($financeresult['markupSerType'] == '1') {
                    $serviceMarkupLable='MarkUp (';
                }
                if ($financeresult['markupSerType'] == '2') {
                    $serviceMarkupLable='Service Charge (';
                }
                $serviceMarkupLable  .= ($markupType == 1) ? '%)' : 'Flat(PP))';
                echo $serviceMarkupLable;

              ?>
              </strong></td>
              <td align="center" ><?php echo $serviceMarkup; ?></td> 
              </tr>
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>
              <?php
              if ($discountType == 1) {
                  echo'Discount(%)';
              }else{
                  echo'Discount(Flat)';
              } 
              ?>
              </strong></td>
              <td align="center" ><?php echo $discount; ?></td> 
              </tr>
              <tr>
                  <td align="center" bgcolor="#F5F5F5" ><strong>Price Sensitivity</strong></td>
                  <td align="center" ><?php echo $priceSenValue; ?></td> 
              </tr>
              <tr>
              <td align="center" bgcolor="#F5F5F5" ><strong>
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
              <td align="center" ><?php echo $serviceTax; ?></td> 
              </tr>
                <?php if($serviceTaxDivident>0){ ?>
                <tr>
                <td align="center" bgcolor="#F5F5F5" ><strong>On Tour Value</strong></td>
                <td align="center" ><?php echo $serviceTaxDivident; ?></td> 
                </tr>
                <?php } ?>
            </table>
            <!--END GENERAL INFOR -->
        </td>
        </tr>
        </table>
        <br>
        <br>
       <!-- Value Added Services per person cost block -->
        <?php 
        $getVisaCost=0;
        $allAdultPaxV=0;
        $allChildPaxV=0;
        $allInfantPaxV=0;
        $adultPaxV=0;

        $childPaxV=0;
        $infantPaxV=0;
        $GrandvisaTotalCostA=0;
        $GrandvisaTotalCostC=0;
        $GrandvisaTotalCostI=0;
        $visaSuppPerPersonCostA=0;
        $visaSuppPerPersonCostC=0;
           
        if($visaCostType==2 && $resultpageQuotation['visaRequired']==2){
            $VR=''; 
            $VR = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            while($getVisaCost = mysqli_fetch_array($VR)){
                

                $adultPaxV = $getVisaCost['adultPax'];
                $childPaxV = $getVisaCost['childPax'];
                $infantPaxV = $getVisaCost['infantPax'];

                $allAdultPaxV = $allAdultPaxV+$adultPaxV;
                $allChildPaxV = $allChildPaxV+$childPaxV;
                $allInfantPaxV = $allInfantPaxV+$infantPaxV;

                $adultVisaCost=convert_to_base($getVisaCost['currencyValue'],$baseCurrencyVal,trim($getVisaCost['adultCost']));
                $childVisaCost=convert_to_base($getVisaCost['currencyValue'],$baseCurrencyVal,trim($getVisaCost['childCost']));
                $infantVisaCost=convert_to_base($getVisaCost['currencyValue'],$baseCurrencyVal,trim($getVisaCost['infantCost']));
                
                $visaTotalCostA = $adultVisaCost*$adultPaxV;
                $visaTotalCostC = $childVisaCost*$childPaxV;
                $visaTotalCostI = $infantVisaCost*$infantPaxV;
           
                $GrandvisaTotalCostA = $GrandvisaTotalCostA+$visaTotalCostA;
                $GrandvisaTotalCostC = $GrandvisaTotalCostC+$visaTotalCostC;
                $GrandvisaTotalCostI = $GrandvisaTotalCostI+$visaTotalCostI;

            }
               
            $visaSuppPerPersonCostA = $GrandvisaTotalCostA/$allAdultPaxV;
            $visaSuppPerPersonCostC = $GrandvisaTotalCostC/$allChildPaxV;
            $visaSuppPerPersonCostI = $GrandvisaTotalCostI/$allInfantPaxV;

            $visaSuppPerPersonCostA = getPerPersonBasisCost($visaSuppPerPersonCostA,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);

            $visaSuppPerPersonCostC = getPerPersonBasisCost($visaSuppPerPersonCostC,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);

            $visaSuppPerPersonCostI = getPerPersonBasisCost($visaSuppPerPersonCostI,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
        }


        $allAdultPaxI=0;
        $allChildPaxI=0;
        $allInfantPaxI=0;
        $insuranceTotalCostA=0;
        $insuranceTotalCostC=0;
        $insuranceTotalCostI=0;
         $GrandinsTotalCostA=0;
         $GrandinsTotalCostC=0;

        if($insuranceCostType==2 && $resultpageQuotation['insuranceRequired']==2){
            $rsI='';
            $rsI = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
            while($getInsuranceCost = mysqli_fetch_array($rsI)) {

                $adultPaxI = $getInsuranceCost['adultPax'];
                $childPaxI = $getInsuranceCost['childPax'];
                $infantPaxI = $getInsuranceCost['infantPax'];

                $allAdultPaxI = $allAdultPaxI+$adultPaxI;
                $allChildPaxI = $allChildPaxI+$childPaxI;
                $allInfantPaxI = $allInfantPaxI+$infantPaxI;

                $adultInsuranceCost=convert_to_base($getInsuranceCost['currencyValue'],$baseCurrencyVal,trim($getInsuranceCost['adultCost']));

                $childInsuranceCost=convert_to_base($getInsuranceCost['currencyValue'],$baseCurrencyVal,trim($getInsuranceCost['childCost']));

                $infantInsuranceCost=convert_to_base($getInsuranceCost['currencyValue'],$baseCurrencyVal,trim($getInsuranceCost['infantCost']));

                $insuranceTotalCostA = $adultInsuranceCost*$adultPaxI;
                $insuranceTotalCostC = $childInsuranceCost*$childPaxI;
                $insuranceTotalCostI = $infantInsuranceCost*$infantPaxI;

                $GrandinsTotalCostA = $GrandinsTotalCostA+$insuranceTotalCostA;
                $GrandinsTotalCostC = $GrandinsTotalCostC+$insuranceTotalCostC;
                $GrandinsTotalCostI = $GrandinsTotalCostI+$insuranceTotalCostI;
           
            }
            

            $insSuppPerPersonCostA = $GrandinsTotalCostA/$allAdultPaxI;
            $insSuppPerPersonCostC = $GrandinsTotalCostC/$allChildPaxI;
            $insSuppPerPersonCostI = $GrandinsTotalCostI/$allInfantPaxI;

           $insSuppPerPersonCostA = getPerPersonBasisCost($insSuppPerPersonCostA,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);

           $insSuppPerPersonCostC = getPerPersonBasisCost($insSuppPerPersonCostC,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
           $insSuppPerPersonCostI = getPerPersonBasisCost($insSuppPerPersonCostI,$serviceMarkup,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
        }

        ?>
        <style>
        .valuaddedtable td{
        font-size: 12px;
        }
        .valuaddedtable{
        margin-top: 20px;
        }
        </style>


        <?php if($visaCostType==2 || $insuranceCostType==2){ ?>

        <table bgcolor="#F5F5F5" border="1" width="40%" cellpadding="5" cellspacing="0" class="valuaddedtable">
        <?php if($allAdultPaxV>0 && $visaCostType==2){ ?>
        <tr><td align="left"><strong>Visa Per Person Cost On Adult Basis</strong></td><td align="right"> <?php echo round($visaSuppPerPersonCostA); ?></td></tr>
        <?php } if($allAdultPaxP>0 && $passportCostType==2){ ?>
        <tr><td align="left"><strong>Passport Per Person Cost On Adult Basis</strong></td><td align="right"> <?php echo round($passSuppPerPersonCostA); ?></td></tr>
        <?php } if($allAdultPaxI>0 && $insuranceCostType==2){ ?>
        <tr><td align="left"><strong>Insurance Per Person Cost On Adult Basis</strong></td><td align="right"> <?php echo round($insSuppPerPersonCostA); ?></td></tr>
        <?php } if($allChildPaxV>0  && $visaCostType==2){ ?>
        <tr><td align="left"><strong>Visa Per Person Cost On Child Basis</strong></td><td align="right"> <?php echo round($visaSuppPerPersonCostC); ?></td></tr>
        <?php } if($allChildPaxP>0 && $passportCostType==2){ ?>
        <tr><td align="left"><strong>Passport Per Person Cost On Child Basis</strong></td><td align="right"> <?php echo round($passSuppPerPersonCostC); ?></td></tr>
        <?php } if($allChildPaxI>0 && $insuranceCostType==2){ ?>
        <tr><td align="left"><strong>Insurance Per Person Cost On Child Basis</strong></td><td align="right"> <?php echo round($insSuppPerPersonCostC); ?></td></tr>
         <?php } if($allInfantPaxV>0  && $visaCostType==2){ ?>
        <tr><td align="left"><strong>Visa Per Person Cost On Infant Basis</strong></td><td align="right"> <?php echo round($visaSuppPerPersonCostI); ?></td></tr>
        <?php } if($allInfantPaxP>0 && $passportCostType==2){ ?>
        <tr><td align="left"><strong>Passport Per Person Cost On Infant Basis</strong></td><td align="right"> <?php echo round($passSuppPerPersonCostI); ?></td></tr>
        <?php } if($allInfantPaxI>0 && $insuranceCostType==2){ ?>
        <tr><td align="left"><strong>Insurance Per Person Cost On Infant Basis</strong></td><td align="right"> <?php echo round($insSuppPerPersonCostI); ?></td></tr>
        <?php } ?>
        </table>
        <br>
        <?php } ?>
            <!-- START PER PAX BLOCK --> 
        <table width="100%" cellpadding="0" cellspacing="0" >
            <tr>
                <td valign="top" width="40%">
                <div style="text-align:left;font-size: 18px;margin: 15px 0;"><strong>Break-up&nbsp;Cost</strong></div>
                <div class="rowm">
                    <?php
                    $totaltransportB = 0;
                    $transportQueryB = ""; 
                    $transportQueryB = GetPageRecord('*', _QUOTATION_TRANSFER_MASTER_, ' quotationId="' . $quotationId . '"  and isGuestType=1 and isSupplement=0 and totalPax in ( select id from totalPaxSlab where status = 1 and quotationId = "' . $quotationId . '" ) order by fromDate asc');
                    if(mysqli_num_rows($transportQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Transport Break-up Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            
                            <?php
                            $cnttpt = 1;
                            while($qTransferDataB = mysqli_fetch_array($transportQueryB)) { 
                                if($cnttpt == 1){ ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" width="10%" ><strong>Date</strong></td>
                                <td align="left" bgcolor="#F5F5F5" width="10%" ><strong>City</strong></td>
                                <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost</strong></td>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost</strong></td>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost</strong></td>
                                <?php if($qTransferDataB['costType'] == 3){  ?>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Per&nbsp;KM&nbsp;Cost</strong></td>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Distance( In KM)</strong></td>
                                <?php }elseif($qTransferDataB['costType'] == 1){  ?>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Per&nbsp;Day&nbsp;Cost</strong></td>
                                <?php }else{ ?>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>vehicle&nbsp;Cost</strong></td>
                                <?php } ?>
                                <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Total&nbsp;Cost</strong></td>
                                </tr>
                                <?php
                                }
                                $c="";  
                                $c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$qTransferDataB['transferNameId'].'"'); 
                                $transferData=mysqli_fetch_array($c);
                                
                                $transportCostB = $adultTransferCostB = $childTransferCostB = $vehicleCostB = $distanceB = 0;
                                
                                if($qTransferDataB['transferType'] == 1){ 
                                    $adultTransferCostB = convert_to_base($qTransferDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qTransferDataB['adultCost'],$qTransferDataB['gstTax'],$qTransferDataB['markupCost'],$qTransferDataB['markupType']));

                                    $childTransferCostB = convert_to_base($qTransferDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qTransferDataB['childCost'],$qTransferDataB['gstTax'],$qTransferDataB['markupCost'],$qTransferDataB['markupType']));
                                    $infantTransferCostB = convert_to_base($qTransferDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qTransferDataB['infantCost'],$qTransferDataB['gstTax'],$qTransferDataB['markupCost'],$qTransferDataB['markupType']));

                                    $transportCostB = ($adultTransferCostB*$paxAdult)+($childTransferCostB*$paxChild)+($infantTransferCostB*$paxInfant);
                                }else{ 
                                    if($qTransferDataB['costType'] == 3){ 

                                        $vehicleCostBB = strip($qTransferDataB['vehicleCost'])+strip($qTransferDataB['parkingFee'])+strip($qTransferDataB['representativeEntryFee'])+strip($qTransferDataB['assistance'])+strip($qTransferDataB['guideAllowance'])+strip($qTransferDataB['interStateAndToll'])+strip($qTransferDataB['miscellaneous']); 

                                        $vehicleCostB = convert_to_base($qTransferDataB['currencyValue'],$baseCurrencyVal,trim(getCostWithGSTID_Markup($vehicleCostBB,$qTransferDataB['gstTax'],$qTransferDataB['markupCost'],$qTransferDataB['markupType'])));
                                        $distanceB = ($qTransferDataB['distance']);
                                        $transportCostB = ($vehicleCostB*$qTransferDataB['noOfVehicles']*$distanceB);
                                    }else{ 
                                        $vehicleCostBB = strip($qTransferDataB['vehicleCost'])+strip($qTransferDataB['parkingFee'])+strip($qTransferDataB['representativeEntryFee'])+strip($qTransferDataB['assistance'])+strip($qTransferDataB['guideAllowance'])+strip($qTransferDataB['interStateAndToll'])+strip($qTransferDataB['miscellaneous']); 

                                        $vehicleCostB = convert_to_base($qTransferDataB['currencyValue'],$baseCurrencyVal,trim(getCostWithGSTID_Markup($vehicleCostBB,$qTransferDataB['gstTax'],$qTransferDataB['markupCost'],$qTransferDataB['markupType'])));

                                        $transportCostB = ($vehicleCostB*$qTransferDataB['noOfVehicles']);
                                        $vehicleType = getVehicleTypeName($qTransferDataB['vehicleType']);
                                    } 

                                } 
                                $totaltransportB=$totaltransportB+$transportCostB;
                                //cost break up info


                                ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($qTransferDataB['fromDate'])); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qTransferDataB['destinationId']); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo ucfirst($qTransferDataB['serviceType']).' | '.ucfirst(strip($transferData['transferName']));  if($qTransferDataB['transferType'] == 2){ echo " | ".$vehicleName.$vehicleType.' for '.$qTransferDataB['noOfVehicles']." Vehicle"; } ?></td>
                                <td align="right" ><?php echo round($adultTransferCostB); ?></td> 
                                <td align="right" ><?php echo round($childTransferCostB); ?></td> 
                                <td align="right" ><?php echo round($infantTransferCostB); ?></td> 
                                <td align="right" ><?php echo round($vehicleCostB,2); ?></td> 
                                <!-- <td align="right" ><?php echo round($distanceB); ?></td>  -->
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($transportCostB); ?></td> 
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Transport Cost</td>
                            <td align="right" ></td> 
                            <td align="right" ></td> 
                            <td align="right" ></td> 
                            <td align="right" ></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($totaltransportB); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                        $cnttpt++;
                    }   

                    $totalGuideCostB = 0;
                    $guideQueryB = ""; 
                    $guideQueryB = GetPageRecord('*',_QUOTATION_GUIDE_MASTER_, ' quotationId="' . $quotationId . '" and isGuestType=1 order by fromDate asc');
                    if(mysqli_num_rows($guideQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Guide Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
                            <td align="right" bgcolor="#F5F5F5" width="15%" ><strong>Service&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            </tr>
                            <?php 
                            while($qGuideDataB = mysqli_fetch_array($guideQueryB)) {
                                $dayDate = $qGuideDataB['fromDate'];
                                $guideCostB = ($qGuideDataB['price']+$qGuideDataB['otherCost']+$qGuideDataB['languageAllowance'])*$qGuideDataB['totalDays'];
                                $price = convert_to_base($qGuideDataB['currencyValue'],$baseCurrencyVal,$guideCostB);

                                $c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$qGuideDataB['guideId'].'"'); 
                                $guideData=mysqli_fetch_array($c);
                               
                                //cost break up info
                                $totalGuideCostB = $totalGuideCostB+$price;
                                 
                                ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qGuideDataB['destinationId']); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo strip($guideData['name']); ?></td>
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($price); ?></td> 
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Guide Cost </td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalGuideCostB); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    }

                    $totalTrainB = 0;
                    $trainQueryB = ""; 
                    $trainQueryB = GetPageRecord('*', 'quotationTrainsMaster', ' quotationId="' . $quotationId . '" order by fromDate asc');
                    if(mysqli_num_rows($trainQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Train Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qTrainDataB = mysqli_fetch_array($trainQueryB)) {
                               
                            $dayDate = $qTrainDataB['fromDate'];
                           
                            $c=GetPageRecord('*','packageBuilderTrainsMaster','id="'.$qTrainDataB['trainId'].'"'); 
                            $trainData=mysqli_fetch_array($c);
                            
                                $trCostAB = getCostWithGSTID_Markup($qTrainDataB['adultCost'],$qTrainDataB['gstTax'],$qTrainDataB['markupCost'],$qTrainDataB['markupType']);
                                $trCostCB = getCostWithGSTID_Markup($qTrainDataB['childCost'],$qTrainDataB['gstTax'],$qTrainDataB['markupCost'],$qTrainDataB['markupType']);
                                $trCostEB = getCostWithGSTID_Markup($qTrainDataB['infantCost'],$qTrainDataB['gstTax'],$qTrainDataB['markupCost'],$qTrainDataB['markupType']);

                                //cost break up info 
                                $trCostAB = convert_to_base($qTrainDataB['currencyValue'],$baseCurrencyVal,$trCostAB);
                                $trCostCB = convert_to_base($qTrainDataB['currencyValue'],$baseCurrencyVal,$trCostCB);
                                $trCostEB = convert_to_base($qTrainDataB['currencyValue'],$baseCurrencyVal,$trCostEB);

                                $totalTrainBA=$totalTrainBA+($trCostAB*$qTrainDataB['adultPax']);
                                $totalTrainBC=$totalTrainBC+($trCostCB*$qTrainDataB['childPax']);
                                $totalTrainBE=$totalTrainBE+($trCostEB*$qTrainDataB['infantPax']);



                            ?>
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qTrainDataB['destinationId']); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo strip($trainData['trainName']); ?></td>

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($trCostAB); ?></td> 
                            <td align="right" ><?php echo ($qTrainDataB['adultPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($trCostAB*$qTrainDataB['adultPax']); ?></td> 

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($trCostCB); ?></td> 
                            <td align="right" ><?php echo ($qTrainDataB['childPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($trCostCB*$qTrainDataB['childPax']); ?></td> 
                            
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($trCostEB); ?></td> 
                            <td align="right" ><?php echo ($qTrainDataB['infantPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($trCostEB*$qTrainDataB['infantPax']); ?></td> 
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Train Cost </td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalTrainBA); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalTrainBC); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalTrainBE); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    }  

                    $totalFlightB = 0;
                    $flightQueryB = ""; 
                    $flightQueryB = GetPageRecord('*', 'quotationFlightMaster', ' quotationId="' . $quotationId . '" order by fromDate asc');
                    if(mysqli_num_rows($flightQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Flight Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service Name</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qFlightDataB = mysqli_fetch_array($flightQueryB)) {
                               
                                $dayDate = $qFlightDataB['fromDate'];
                               
                                $c=GetPageRecord('*','packageBuilderAirlinesMaster','id="'.$qFlightDataB['flightId'].'"'); 
                                $FlightData=mysqli_fetch_array($c);
                                
                                $ftCostAB = getCostWithGSTID_Markup($qFlightDataB['adultCost'],$qFlightDataB['gstTax'],$qFlightDataB['markupCost'],$qFlightDataB['markupType']);
                                $ftCostCB = getCostWithGSTID_Markup($qFlightDataB['childCost'],$qFlightDataB['gstTax'],$qFlightDataB['markupCost'],$qFlightDataB['markupType']);
                                $ftCostEB = getCostWithGSTID_Markup($qFlightDataB['infantCost'],$qFlightDataB['gstTax'],$qFlightDataB['markupCost'],$qFlightDataB['markupType']);

                                //cost break up info 
                                $ftCostAB = convert_to_base($qFlightDataB['currencyValue'],$baseCurrencyVal,$ftCostAB);
                                $ftCostCB = convert_to_base($qFlightDataB['currencyValue'],$baseCurrencyVal,$ftCostCB);
                                $ftCostEB = convert_to_base($qFlightDataB['currencyValue'],$baseCurrencyVal,$ftCostEB);

                                $totalFlightBA=$totalFlightBA+($ftCostAB*$qFlightDataB['adultPax']);
                                $totalFlightBC=$totalFlightBC+($ftCostCB*$qFlightDataB['childPax']);
                                $totalFlightBE=$totalFlightBE+($ftCostEB*$qFlightDataB['infantPax']);

                            ?>
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qFlightDataB['destinationId']); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo strip($FlightData['flightName']); ?></td>

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($ftCostAB); ?></td> 
                            <td align="right" ><?php echo ($qFlightDataB['adultPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($ftCostAB*$qFlightDataB['adultPax']); ?></td> 

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($ftCostCB); ?></td> 
                            <td align="right" ><?php echo ($qFlightDataB['childPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($ftCostCB*$qFlightDataB['childPax']); ?></td> 

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($ftCostEB); ?></td> 
                            <td align="right" ><?php echo ($qFlightDataB['infantPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($ftCostEB*$qFlightDataB['infantPax']); ?></td> 
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Flight Cost</td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalFlightBA); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalFlightBC); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalFlightBE); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    }  

                    $totalActAdultB = 0;
                    $totalActChildB = 0;
                    $totalActInfantB = 0;
                    $actQueryB = ""; 
                    $actQueryB = GetPageRecord('*', 'quotationOtherActivitymaster', 'quotationId="'.$quotationId.'" order by fromDate asc');
                    if(mysqli_num_rows($actQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Sightseeing Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qActivityDataB = mysqli_fetch_array($actQueryB)) {
                            
                            $dayDate = $qActivityDataB['fromDate'];
                            $qActTotalPax = ($qActivityDataB['adultPax']+$qActivityDataB['childPax']+$qActivityDataB['infantPax']);
                            if($qActivityDataB['transferType']!=2 && $qActivityDataB['transferType']!=3){
                               $ActmarkupCost = $qActivityDataB['markupCost'];
                                $ActmarkupType = $qActivityDataB['markupType'];
                            }
                            if($qActivityDataB['transferType'] == 1){
                                $actCostAB = ($qActivityDataB['ticketAdultCost']+$qActivityDataB['adultCost']+$qActivityDataB['repCost']);            
                                $actCostCB = ($qActivityDataB['ticketchildCost']+$qActivityDataB['childCost']+$qActivityDataB['repCost']);            
                                $actCostEB = ($qActivityDataB['ticketinfantCost']+$qActivityDataB['infantCost']+$qActivityDataB['repCost']);            
                            }elseif($qActivityDataB['transferType'] == 2 || $qActivityDataB['transferType'] == 3){
                                $actMarkupCostB = getMarkupCost($qActivityDataB['vehicleCost'],$qActivityDataB['markupCost'],$qActivityDataB['markupType']);
                                $vehicleCostB = $qActivityDataB['vehicleCost']+$actMarkupCostB;
                                $actCostAB = $qActivityDataB['ticketAdultCost']+($vehicleCostB/$qActTotalPax)+$qActivityDataB['repCost'];
                                $actCostCB = $qActivityDataB['ticketchildCost']+($vehicleCostB/$qActTotalPax)+$qActivityDataB['repCost'];
                                $actCostEB = $qActivityDataB['ticketinfantCost']+($vehicleCostB/$qActTotalPax)+$qActivityDataB['repCost'];
                            }else{
                                $actCostAB = ($qActivityDataB['ticketAdultCost']);
                                $actCostCB = ($qActivityDataB['ticketchildCost']);       
                                $actCostEB = ($qActivityDataB['ticketinfantCost']);
                            }

                            $actCostAB=convert_to_base($qActivityDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($actCostAB,$qActivityDataB['gstTax'],$ActmarkupCost,$ActmarkupType));
                            $actCostCB=convert_to_base($qActivityDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($actCostCB,$qActivityDataB['gstTax'],$ActmarkupCost,$ActmarkupType));
                            $actCostEB=convert_to_base($qActivityDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($actCostEB,$qActivityDataB['gstTax'],$ActmarkupCost,$ActmarkupType));


                            $actCostAB2 = ($actCostAB*$qActivityDataB['adultPax']);
                            $actCostCB2 = ($actCostCB*$qActivityDataB['childPax']);
                            $actCostEB2 = ($actCostEB*$qActivityDataB['infantPax']);

                            $e=GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$qActivityDataB['otherActivityName'].'"'); 
                            $activityData=mysqli_fetch_array($e);
                            
                            //cost break up info
                            $totalActAdultB = $totalActAdultB+$actCostAB2;
                            $totalActChildB = $totalActChildB+$actCostCB2;
                            $totalActInfantB = $totalActInfantB+$actCostEB2;

                            ?>
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qActivityDataB['otherActivityCity']); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo strip($activityData['otherActivityName']); ?></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($actCostAB); ?></td> 
                            <td align="right" ><?php echo ($qActivityDataB['adultPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($actCostAB2); ?></td> 

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($actCostCB); ?></td> 
                            <td align="right" ><?php echo ($qActivityDataB['childPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($actCostCB2); ?></td> 

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($actCostEB); ?></td> 
                            <td align="right" ><?php echo ($qActivityDataB['infantPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($actCostEB2); ?></td> 
 
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Sightseeing Cost </td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalActAdultB); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalActChildB); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalActInfantB); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    }  

                    $totalEntAdultB = 0;
                    $totalEntChildB = 0;
                    $totalEntInfantB = 0;
                    $entQueryB = ""; 
                    $entQueryB = GetPageRecord('*', _QUOTATION_ENTRANCE_MASTER_, ' quotationId="' . $quotationId . '" order by fromDate asc');
                    if(mysqli_num_rows($entQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Entrance Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost(In&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost(In&nbsp;<?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qEntranceDataB = mysqli_fetch_array($entQueryB)) {
                            
                                $dayDate = $qEntranceDataB['fromDate'];
                                $qEntTotalPax = ($qEntranceDataB['adultPax']+$qEntranceDataB['childPax']+$qEntranceDataB['infantPax']);
                                if($qEntranceDataB['transferType'] == 1){
                                    $entCostAB = getCostWithGSTID_Markup(($qEntranceDataB['ticketAdultCost']+$qEntranceDataB['adultCost']+$qEntranceDataB['repCost']),$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);            
                                    $entCostCB = getCostWithGSTID_Markup(($qEntranceDataB['ticketchildCost']+$qEntranceDataB['childCost']+$qEntranceDataB['repCost']),$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);            
                                    $entCostEB = getCostWithGSTID_Markup(($qEntranceDataB['ticketinfantCost']+$qEntranceDataB['infantCost']+$qEntranceDataB['repCost']),$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']); 
                                }elseif($qEntranceDataB['transferType'] == 2){

                                    $entCostABA = $qEntranceDataB['ticketAdultCost'];
                                    $entCostABC = $qEntranceDataB['ticketchildCost'];
                                    $entCostABE = $qEntranceDataB['ticketinfantCost'];
                                    
                                    $entCostAB = $entCostABA +$qEntranceDataB['repCost'] + getCostWithGSTID_Markup(($qEntranceDataB['vehicleCost']/$qEntTotalPax),$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);

                                    $entCostCB = $entCostABC+$qEntranceDataB['repCost'] + getCostWithGSTID_Markup(($qEntranceDataB['vehicleCost']/$qEntTotalPax),$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);

                                    $entCostEB = $entCostABE+$qEntranceDataB['repCost'] + getCostWithGSTID_Markup(($qEntranceDataB['vehicleCost']/$qEntTotalPax),$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);
                                }elseif($qEntranceDataB['transferType'] == 3){
                                    $entCostAB = getCostWithGSTID_Markup($qEntranceDataB['ticketAdultCost'],$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);
                                    $entCostCB = getCostWithGSTID_Markup($qEntranceDataB['ticketchildCost'],$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);       
                                    $entCostEB = getCostWithGSTID_Markup($qEntranceDataB['ticketinfantCost'],$qEntranceDataB['gstTax'],$qEntranceDataB['markupCost'],$qEntranceDataB['markupType']);
                                }

                                $entCostAB2=convert_to_base($qEntranceDataB['currencyValue'],$baseCurrencyVal,($entCostAB*$qEntranceDataB['adultPax']));
                                $entCostCB2=convert_to_base($qEntranceDataB['currencyValue'],$baseCurrencyVal,($entCostCB*$qEntranceDataB['childPax']));
                                $entCostEB2=convert_to_base($qEntranceDataB['currencyValue'],$baseCurrencyVal,($entCostEB*$qEntranceDataB['infantPax']));

                                $c=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$qEntranceDataB['entranceNameId'].'"'); 
                                $entranceData=mysqli_fetch_array($c);
                                
                                //cost break up info
                                $totalEntAdultB = $totalEntAdultB+$entCostAB2;
                                $totalEntChildB = $totalEntChildB+$entCostCB2;
                                $totalEntInfantB = $totalEntInfantB+$entCostEB2;

                            ?>
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qEntranceDataB['destinationId']); ?></td>
                            <td align="left" bgcolor="#F5F5F5" ><?php echo strip($entranceData['entranceName']); ?></td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($entCostAB); ?></td> 
                            <td align="right" ><?php echo ($qEntranceDataB['adultPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($entCostAB*$qEntranceDataB['adultPax']); ?></td> 

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($entCostCB); ?></td> 
                            <td align="right" ><?php echo ($qEntranceDataB['childPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($entCostCB*$qEntranceDataB['childPax']); ?></td> 

                            <td align="right" ><?php echo getTwoDecimalNumberFormat($entCostEB); ?></td> 
                            <td align="right" ><?php echo ($qEntranceDataB['infantPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($entCostEB*$qEntranceDataB['infantPax']); ?></td> 
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Entrance Cost </td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalEntAdultB); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalEntChildB); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalEntInfantB); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    }  

                    $totalMealCostB = 0;
                    $mealQueryB = ""; 
                    $mealQueryB = GetPageRecord('*','quotationInboundmealplanmaster', ' quotationId="' . $quotationId . '" order by fromDate asc');
                    if(mysqli_num_rows($mealQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Restaurant Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost<br>(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost<br>(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost<br>(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qMealPlanDataB = mysqli_fetch_array($mealQueryB)) {
                                $dayDate = $qMealPlanDataB['fromDate'];
                                $adultCost = convert_to_base($qMealPlanDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qMealPlanDataB['adultCost'],$qMealPlanDataB['gstTax'],$qMealPlanDataB['markupCost'],$qMealPlanDataB['markupType'])); 
                                $childCost = convert_to_base($qMealPlanDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qMealPlanDataB['childCost'],$qMealPlanDataB['gstTax'],$qMealPlanDataB['markupCost'],$qMealPlanDataB['markupType'])); 
                                $infantCost = convert_to_base($qMealPlanDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qMealPlanDataB['infantCost'],$qMealPlanDataB['gstTax'],$qMealPlanDataB['markupCost'],$qMealPlanDataB['markupType'])); 

                                //cost break up info
                                $totalMealCostAB = $totalMealCostAB+($adultCost*$qMealPlanDataB['adultPax']);
                                $totalMealCostCB = $totalMealCostCB+($childCost*$qMealPlanDataB['childPax']);
                                $totalMealCostEB = $totalMealCostEB+($infantCost*$qMealPlanDataB['infantPax']);
                                
                                ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qMealPlanDataB['destinationId']); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo strip($qMealPlanDataB['mealPlanName']); ?></td>

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($adultCost); ?></td> 
                                <td align="right" ><?php echo ($qMealPlanDataB['adultPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($adultCost*$qMealPlanDataB['adultPax']); ?></td> 

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($childCost); ?></td> 
                                <td align="right" ><?php echo ($qMealPlanDataB['childPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($childCost*$qMealPlanDataB['childPax']); ?></td> 

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($infantCost); ?></td> 
                                <td align="right" ><?php echo ($qMealPlanDataB['infantPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($infantCost*$qMealPlanDataB['infantPax']); ?></td> 
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Restaurant Cost </td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalMealCostAB); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalMealCostCB); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalMealCostEB); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    } 
             
                    $totalAddsCostBA = $totalAddsCostBC = $totalAddsCostBI = 0;              
                    $addisQueryB = ""; 
                    $addisQueryB = GetPageRecord('*','quotationExtraMaster', ' quotationId="' . $quotationId . '" and isMarkupApply=0 order by fromDate asc');
                    if(mysqli_num_rows($addisQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Additionals Break-up Cost/Markup Applied</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost<br>(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost<br>(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost<br>(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qAdditionalDataB = mysqli_fetch_array($addisQueryB)) {
                                $dayDate = $qAdditionalDataB['fromDate'];
                                if ($qAdditionalDataB['costType']==2) {
                                    $groupCost=convert_to_base($qAdditionalDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qAdditionalDataB['groupCost'],$qAdditionalDataB['gstTax'],$qAdditionalDataB['markupCost'],$qAdditionalDataB['markupType']));
                                    $extadultCost=($groupCost/($totalPax+$paxAdultLE+$paxAdultFE));
                                    $extchildCost=($groupCost/($totalPax+$paxAdultLE+$paxAdultFE));
                                    $extinfantCost=($groupCost/($totalPax+$paxAdultLE+$paxAdultFE));
                                    $qAdditionalDataB['adultPax'] = $paxAdult;
                                    $qAdditionalDataB['childPax'] = $paxChild;
                                    $qAdditionalDataB['infantPax'] = $paxInfant;
                                } else {
                                    $extadultCost = convert_to_base($qAdditionalDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qAdditionalDataB['adultCost'],$qAdditionalDataB['gstTax'],$qAdditionalDataB['markupCost'],$qAdditionalDataB['markupType']));

                                    $extchildCost = convert_to_base($qAdditionalDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qAdditionalDataB['childCost'],$qAdditionalDataB['gstTax'],$qAdditionalDataB['markupCost'],$qAdditionalDataB['markupType']));

                                    $extinfantCost = convert_to_base($qAdditionalDataB['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qAdditionalDataB['infantCost'],$qAdditionalDataB['gstTax'],$qAdditionalDataB['markupCost'],$qAdditionalDataB['markupType']));
                                } 

                                //cost break up info
                                $totalAddsCostBA = $totalAddsCostBA+($extadultCost*$qAdditionalDataB['adultPax']);
                                $totalAddsCostBC = $totalAddsCostBC+($extchildCost*$qAdditionalDataB['childPax']);
                                $totalAddsCostBI = $totalAddsCostBI+($extinfantCost*$qAdditionalDataB['infantPax']);
                                 
                                ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qAdditionalDataB['destinationId']); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo strip($qAdditionalDataB['name']); ?></td>
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($extadultCost); ?></td> 
                            <td align="right" ><?php echo ($qAdditionalDataB['adultPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($extadultCost*$qAdditionalDataB['adultPax']); ?></td> 

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($extchildCost); ?></td> 
                            <td align="right" ><?php echo ($qAdditionalDataB['childPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($extchildCost*$qAdditionalDataB['childPax']); ?></td> 
                            
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($extinfantCost); ?></td> 
                            <td align="right" ><?php echo ($qAdditionalDataB['infantPax']); ?></td> 
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($extinfantCost*$qAdditionalDataB['infantPax']); ?></td> 
                                </tr>

                                <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Restaurant Cost </td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalAddsCostBA); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalAddsCostBC); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalAddsCostBI); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    } 

                    $totalAddsCostG2 =  0;              
                    $addisQueryB2 = ""; 
                    $addisQueryB2 = GetPageRecord('*','quotationExtraMaster', ' quotationId="' . $quotationId . '" and isMarkupApply=1 order by fromDate asc');
                    if(mysqli_num_rows($addisQueryB2)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Additionals Break-up Cost/No Markup Applied</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Total&nbsp;Cost<br>(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            </tr>
                            <?php 
                            while($qAdditionalDataB2 = mysqli_fetch_array($addisQueryB2)) {
                                $dayDate = $qAdditionalDataB2['fromDate'];
                                if ($qAdditionalDataB2['costType']==2 && $qAdditionalDataB2['isMarkupApply']==1) {
                                    $groupCost=convert_to_base($qAdditionalDataB2['currencyValue'],$baseCurrencyVal,getCostWithGSTID_Markup($qAdditionalDataB2['groupCost'],$qAdditionalDataB2['gstTax'],$qAdditionalDataB2['markupCost'],$qAdditionalDataB2['markupType']));
                                } else {
                                    $groupCost=0;
                                } 

                                //cost break up info
                                $totalAddsCostG2 = $totalAddsCostG2+$groupCost;
                                 
                                ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qAdditionalDataB2['destinationId']); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo strip($qAdditionalDataB2['name']); ?></td>
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($groupCost); ?></td> 
                                </tr>

                                <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Restaurant Cost </td>
                            <td align="right" ><?php echo getTwoDecimalNumberFormat($totalAddsCostG2); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    } 

                    $totalFerryB = 0;
                    $ferryQueryB = ""; 
                    $ferryQueryB = GetPageRecord('*', 'quotationFerryMaster', ' quotationId="' . $quotationId . '" order by fromDate asc');
                    if(mysqli_num_rows($ferryQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Ferry Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service Name</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qFerryDataB = mysqli_fetch_array($ferryQueryB)) {
                                
                                $dayDate = $qFerryDataB['fromDate'];
                                
                                $rs52=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$qFerryDataB['serviceid'].'" ');  
                                $FerryData=mysqli_fetch_array($rs52); 
                                
                                $frCostAB = getCostWithGSTID_Markup(round($qFerryDataB['adultCost']+$qFerryDataB['processingfee']+$qFerryDataB['miscCost']),$qFerryDataB['gstTax'],$qFerryDataB['markupCost'],$qFerryDataB['markupType']);
                                $frCostCB = getCostWithGSTID_Markup(round($qFerryDataB['childCost']+$qFerryDataB['processingfee']+$qFerryDataB['miscCost']),$qFerryDataB['gstTax'],$qFerryDataB['markupCost'],$qFerryDataB['markupType']);
                               
                                $frCostEB = getCostWithGSTID_Markup(round($qFerryDataB['infantCost']+$qFerryDataB['processingfee']+$qFerryDataB['miscCost']),$qFerryDataB['gstTax'],$qFerryDataB['markupCost'],$qFerryDataB['markupType']);

                                //cost break up info 
                                $frCostAB = convert_to_base($qFerryDataB['currencyValue'],$baseCurrencyVal,$frCostAB);
                                $frCostCB = convert_to_base($qFerryDataB['currencyValue'],$baseCurrencyVal,$frCostCB);
                                $frCostEB = convert_to_base($qFerryDataB['currencyValue'],$baseCurrencyVal,$frCostEB);

                                $totalFerryBA=$totalFerryBA+($frCostAB*$qFerryDataB['adultPax']);
                                $totalFerryBC=$totalFerryBC+($frCostCB*$qFerryDataB['childPax']);
                                $totalFerryBE=$totalFerryBE+($frCostEB*$qFerryDataB['infantPax']);

                                ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qFerryDataB['destinationId']); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo strip($FerryData['name']); ?></td>

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($frCostAB); ?></td> 
                                <td align="right" ><?php echo ($qFerryDataB['adultPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($frCostAB*$qFerryDataB['adultPax']); ?></td> 

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($frCostCB); ?></td> 
                                <td align="right" ><?php echo ($qFerryDataB['childPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($frCostCB*$qFerryDataB['childPax']); ?></td> 

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($frCostEB); ?></td> 
                                <td align="right" ><?php echo ($qFerryDataB['infantPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($frCostEB*$qFerryDataB['infantPax']); ?></td> 
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Ferry Cost</td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalFerryBA); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalFerryBC); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalFerryBE); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    }
              

                    $totalCruiseB = 0;
                    $cruiseQueryB = ""; 
                    $cruiseQueryB = GetPageRecord('*', 'quotationCruiseMaster', ' quotationId="' . $quotationId . '" order by fromDate asc');
                    if(mysqli_num_rows($cruiseQueryB)>0){ 
                        ?>
                        <div class="colm"><br>
                        <strong style="font-size:12px;text-transform: uppercase;">Cruise Break-up Cost</strong>
                        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <tr>
                            <td align="left" bgcolor="#F5F5F5" width="6%" ><strong>Date</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="6%" ><strong>City</strong></td>
                            <td align="left" bgcolor="#F5F5F5" ><strong>Service Name</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Adult&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Adult</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Child&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Child</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            <td align="right" bgcolor="#F5F5F5" width="10%" ><strong>Infant&nbsp;Cost(In <?php echo getCurrencyName($baseCurrencyId); ?>)</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>No.&nbsp;of&nbsp;Infant</strong></td>
                            <td align="left" bgcolor="#F5F5F5" width="5%"><strong>Total&nbsp;Cost</strong></td>

                            </tr>
                            <?php 
                            while($qCruiseDataB = mysqli_fetch_array($cruiseQueryB)) {
                                
                                $dayDate = $qCruiseDataB['fromDate'];
                                
                                $rs52=GetPageRecord('*','cruiseMaster',' id="'.$qCruiseDataB['serviceId'].'" ');  
                                $CruiseData=mysqli_fetch_array($rs52); 
                                
                                $crCostAB = getCostWithGSTID_Markup(round($qCruiseDataB['adultCost']+$qCruiseDataB['processingfee']+$qCruiseDataB['miscCost']),$qCruiseDataB['gstTax'],$qCruiseDataB['markupCost'],$qCruiseDataB['markupType']);
                                $crCostCB = getCostWithGSTID_Markup(round($qCruiseDataB['childCost']+$qCruiseDataB['processingfee']+$qCruiseDataB['miscCost']),$qCruiseDataB['gstTax'],$qCruiseDataB['markupCost'],$qCruiseDataB['markupType']);
                               
                                $crCostEB = getCostWithGSTID_Markup(round($qCruiseDataB['infantCost']+$qCruiseDataB['processingfee']+$qCruiseDataB['miscCost']),$qCruiseDataB['gstTax'],$qCruiseDataB['markupCost'],$qCruiseDataB['markupType']);

                                //cost break up info 
                                $crCostAB = convert_to_base($qCruiseDataB['currencyValue'],$baseCurrencyVal,$crCostAB);
                                $crCostCB = convert_to_base($qCruiseDataB['currencyValue'],$baseCurrencyVal,$crCostCB);
                                $crCostEB = convert_to_base($qCruiseDataB['currencyValue'],$baseCurrencyVal,$crCostEB);

                                $totalCruiseBA=$totalFerryBA+($crCostAB*$qCruiseDataB['adultPax']);
                                $totalCruiseBC=$totalFerryBC+($crCostCB*$qCruiseDataB['childPax']);
                                $totalCruiseBE=$totalFerryBE+($crCostEB*$qCruiseDataB['infantPax']);

                                ?>
                                <tr>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo date('d-m-Y', strtotime($dayDate)); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo getDestination($qCruiseDataB['destinationId']); ?></td>
                                <td align="left" bgcolor="#F5F5F5" ><?php echo strip($CruiseData['cruiseName']); ?></td>

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($crCostAB); ?></td> 
                                <td align="right" ><?php echo ($qCruiseDataB['adultPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($crCostAB*$qCruiseDataB['adultPax']); ?></td> 

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($crCostCB); ?></td> 
                                <td align="right" ><?php echo ($qCruiseDataB['childPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($crCostCB*$qCruiseDataB['childPax']); ?></td> 

                                <td align="right" ><?php echo getTwoDecimalNumberFormat($crCostEB); ?></td> 
                                <td align="right" ><?php echo ($qCruiseDataB['infantPax']); ?></td> 
                                <td align="right" ><?php echo getTwoDecimalNumberFormat($crCostEB*$qCruiseDataB['infantPax']); ?></td> 
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td align="right" bgcolor="#F5F5F5" colspan="3">Total Cruise Cost</td>
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalCruiseBA); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalCruiseBC); ?></td> 
                            <td align="right" colspan="3"><?php echo getTwoDecimalNumberFormat($totalCruiseBE); ?></td> 
                            </tr>
                        </table>
                        </div>
                        <?php 
                    }
                    ?>

                    <!-- value added services cost -->
                    <?php 
                    if($serviceTax>0){
                        $serviceTaxLable = $serviceTax.'%';
                    }
                    $rowSpan='';
                    if($paxAdult>0){
                        $rowSpan = 1;
                    }
                    if($paxChild>0){
                        $rowSpan = $rowSpan+1;
                    }
                    if($paxInfant>0){
                        $rowSpan = $rowSpan+1;
                    }

                    $visaAdultBA=$totalVisaCostBA=$visaChildBC=$totalVisaCostBC=$visaInfantBI=$totalVisaCostBI=0;
                    $totalVisaCostBAPP=$VisaCostBApp=$VisaCostBC=$VisaCostBI=$pPCostWmarkupV=$visaServiceCostNM=0;
                    $totalServiceCostV=$totalServiceTaxV = $totalTCSV=$totalSaleCostVA=$purchanseCostPPV=0;
                    $totalvisaCostA=$totalvisaCostC=$totalvisaCostA=$visaCostNMA=$visaCostNMC=$visaCostNME=0;

                    // visa
                    $vn=''; 
                    $vn = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
                    // insurance
                    $vi=''; 
                    $vi = GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,'quotationId="'.$quotationId.'" order by id asc');

                    if (($visaCostType == 1 || $visaCostType==2 || $insuranceCostType == 1 || $insuranceCostType==2) && (mysqli_num_rows($vi)>0 || mysqli_num_rows($vn)>0)){ ?>
                        <div class="colm" style="width:65%;margin-bottom: 20px;">
                            <strong style="font-size:12px;text-transform: uppercase;">Value Added Services Break-up Cost</strong><br>
                            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
                            <?php 
                            if(mysqli_num_rows($vn)>0){
                                ?>
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
                                $visataxAmountBApp = $saleVisaApp = $totalpurchaseVisaA = $totalvisaMarkupCostA = $totalSaleVisaA = 0;
                                $visaMarkupCostCpp = $saleVisaCpp = $totalpurchaseVisaC = $totalvisaMarkupCostC = $totalSaleVisaC = 0;
                                $visaMarkupCostEpp = $saleVisaEpp = $totalpurchaseVisaE = $totalvisaMarkupCostE = $totalSaleVisaE = 0;
                                $totalserviceCostApp=$totalserviceCostCpp=$totalserviceCostEpp=$totalProcessingFee=0;$grandPurchaseSBCost=$totalVisaServiceCost=$visaFinalCostA=$visaServicePurchaseCost=$getVisaCost=0;
                            
                                $VR=''; 
                                $VR = GetPageRecord('*',_QUOTATION_VISA_MASTER_,'quotationId="'.$quotationId.'" order by id asc');
                                while($getVisaCost = mysqli_fetch_array($VR)){
                                    $visataxAmountBApp=$visataxAmountBCpp=$visataxAmountBEpp=0;
                                    $taxApplicable = $getVisaCost['taxApplicable'];
                                    $visaAdultPax = $getVisaCost['adultPax'];
                                    $visaChildPax = $getVisaCost['childPax'];
                                    $visaInfantPax = $getVisaCost['infantPax'];
                                    $currencyValue = $getVisaCost['currencyValue'];
                                    // vfsCharges embassyFee
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

                                    ?>    
                                    <tr>
                                    <td align="left" rowspan="<?php echo $rowSpan; ?>" bgcolor="#deb887"><strong><?php echo getCountryName($getVisaCost['visaCountryId']) ?></strong></td>
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
                                    <th align="right" colspan="2">Total</th>
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
                               
                            // insurance
                            if(mysqli_num_rows($vi)>0){
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
                                    $currencyValue = $getInsuranceCost['currencyValue'];

                                    $purchaseInsuranceBApp = convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['adultCost']);        
                                    $purchaseInsuranceBCpp = convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['childCost']);        
                                    $purchaseInsuranceBEpp = convert_to_base($currencyValue, $baseCurrencyVal,$getInsuranceCost['infantCost']);  

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
                                    <td align="left" rowspan="<?php echo $rowSpan; ?>" bgcolor="#deb887"><strong><?php echo getCountryName($getInsuranceCost['countryId']) ?></strong></td>
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
                                <th align="right" colspan="2">Total</th>
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
                            ?>
                            </table>
                        </div>
                        <?php 
                    }
                    ?>

                </div>
                <style type="text/css">
                    .rowm{
                    /*  display: inline-flex;*/
                        position: relative;
                        width: 100%;    
                        text-align: left;
                    }
                    .colm{
                        margin-right: 1%;
                        width: 100%;
                        display: inline-block;

                    }
                </style>    
                </td>
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
        <?php }
        
        $supptptQuery="";
        $supptptQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isGuestType=0 and isSupplement=1');
        if(mysqli_num_rows($supptptQuery) > 0 ){
        ?>
        <table width="100%">
        <tr>
            <td width="60%">
            <div style="text-align:left; font-size:22px; margin-bottom:10px; margin-top:10px;">
                <strong>Transfer/Transpotation&nbsp;Supplement</strong>
            </div>
            </td>
        </tr>
        <tr>  
            <td width="60%">
                <?php 
                $queryId = $resultpageQuotation['queryId'];
                $quotationId= $resultpageQuotation['id'];
                $_REQUEST['parts'] = 'transferSupplement';
                include('PreviewFiles/proposal_parts.php');
                ?>
            </td> 
        </tr> 
        </table>
        <?php } 

    } ?>
        <div style="overflow:hidden;margin-top:20px;<?php if(!isset($_REQUEST['finalcategory']) && !isset($_REQUEST['quotationId'])){ ?>display:none;<?php } ?>">
            <table border="0" align="right" cellpadding="5" cellspacing="0">
                <tbody><tr>
                    <td> 
                      <input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();"> 
                    </td>
                </tr>
            </tbody></table>
        </div>
    </div>
    <?php
}
?>