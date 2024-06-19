<?php
include "inc.php";

$rs=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$_REQUEST['queryId'].'" and id="'.$_REQUEST['quotationId'].'" and status=1 '); 
	$quotationData=mysqli_fetch_array($rs);
	$quotationId = $quotationData['id']; 
	$queryId = $quotationData['queryId']; 
	$totalPax = ($quotationData['adult']+$quotationData['child']+$quotationData['infant']);
	$paxAdult = ($quotationData['adult']);
	$paxChild = ($quotationData['child']); 
	$paxInfant = ($quotationData['infant']);

	$calculationType = $quotationData['calculationType'];
	$costType = $quotationData['costType'];
	$discountType= $quotationData['discountType'];
	$discountTax = $quotationData['discount'];

	$rs=''; 
	$rs=GetPageRecord('*',_QUERY_MASTER_,'id='.$quotationData['queryId'].''); 
	$editresult=mysqli_fetch_array($rs); 

	$queryType = $editresult['queryType'];
if($quotationData['serviceTax'] > 0){ 
	$serviceTax = $quotationData['serviceTax']; 
	$gstLable = "(&nbsp;with&nbsp;GST&nbsp;)"; 
}else{ 
	$serviceTax = 0; 
	$gstLable = ""; 
} 

if($editresult['queryType'] == 4){
	$update = updatelisting('finalQuotSupplierStatus','deletestatus=0,isPackage=1,totalSupplierCost="'.$quotationData['totalCompanyCost'].'"','quotationId="'.$quotationId.'"');
}
// ,supplierId="'.$quotationData['packageSupplier'].'"
if($quotationData['markup'] > 0){ $serviceMarkup = $quotationData['markup']; }else{ $serviceMarkup = 0; } 

// SLAB AND ESCORT DETAILS
$defaultSlabSql = "";
$dfactor = 2;
$defaultSlabSql = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1 ');
if (mysqli_num_rows($defaultSlabSql)>0) {
    $slabsData = mysqli_fetch_array($defaultSlabSql);
    $dfactor = $slabsData['dividingFactor'];
    $slabId = $slabsData['id'];
    $paxAdultLE = $slabsData['localEscort'];
    $paxAdultFE = $slabsData['foreignEscort'];

    $esQLE = "";
    // echo ' 1 and slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"';
    $esQLE = GetPageRecord('*', 'quotationFOCRates',' 1 and slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"');
    if (mysqli_num_rows($esQLE)>0 && $paxAdultLE>0) {
        $escortDataLE = mysqli_fetch_array($esQLE);
        $sglRoomLE = $escortDataLE['sglNORoom'];
        $dblRoomLE = $escortDataLE['dblNORoom'];
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
        $ferryCalTypeLE=$escortDataLE['ferryCalType'];
        $transferCalTypeLE=$escortDataLE['transferCalType'];
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
        $ferryCalTypeFE=$escortDataFE['ferryCalType'];
        $transferCalTypeFE=$escortDataFE['transferCalType'];
        $trainCalTypeFE=$escortDataFE['trainCalType'];
        $flightCalTypeFE=$escortDataFE['flightCalType'];
        $restaurantCalTypeFE=$escortDataFE['restaurantCalType'];
        $otherCalTypeFE=$escortDataFE['otherCalType'];
    }
    if ($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['toRange'] == 0){
        $paxrange = $slabsData['fromRange'];
    }else{
        $paxrange = $slabsData['fromRange'] . '-' . $slabsData['toRange'];
    }
}

$n=1;
?>
<script type="text/javascript">
function setGTCost(sectionId,Cost,divId){
	if(sectionId == 'CompanyCost'){
		$(divId).text(Cost);
	}
	if(sectionId == 'ClientCost'){
		$(divId).text(Cost);
	}
	if(sectionId == 'MarginCost'){
		$(divId).text(Cost);
	}
	if(sectionId == 'pendingCompanyCost'){
		if (Cost<1) { 
			$(divId).text('Paid');
		}else{
			$(divId).text(Cost);
			$(divId).css('color','#CC3300');
		}
	}
	if(sectionId == 'supplierCost'){
		$(divId).text(Cost);
	}
	if(sectionId == 'supplierPen'){
		$(divId).text(Cost);
		$(divId).css('color','#CC3300');
	}
} 
</script>
<div  id="maildataall" style="padding:0px; background-color:#cadbec;">
<?php  
if($quotationData['id']!=''){
	$totalPax = trim($quotationData['adult']+$quotationData['child']+$quotationData['infant']);
	$grandCompanyCostWOGST = 0;
	$grandPendingCost = 0; 
	$currencyId = $quotationData['currencyId'];

	// $suppStatusQuery = ' and manualStatus=3 '; 
	
	$suppStatusQuery = ''; 
	
	// and status=3
	$fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$quotationData['id'].'" and deletestatus=0 and supplierId>0'); 
	if(mysqli_num_rows($fianlSuppQuery)>0 ){
	
	while($supplierStatusData=mysqli_fetch_array($fianlSuppQuery)){
		
		
		$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuote where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" '.$suppStatusQuery.' )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" '.$suppStatusQuery.' )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteCruise where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  '.$suppStatusQuery.' ) or serviceId in ( select id from finalPackWiseRateMaster where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" '.$suppStatusQuery.' ) ) group by startDate order by startDate asc');

		if(mysqli_num_rows($qIQuery2) > 0){
		
				$b="";
	 			$b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$supplierStatusData['supplierId'].'"'); 
				$suppData=mysqli_fetch_array($b);  
			
				?>
				<table width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size:14px;"> 
				<tr>
				<td width="85%" align="left" valign="bottom"  style="padding:0px;" > 
				<div class="boxsupplierpaymentreq" >
				<!-- supplier details -->
				<div class="header"> 
					<table width="100%" cellpadding="0" celspacing="0" border="0"><tr>
						<td align="left" valign="middle"> <strong style="font-size: 16px;color: #2c343f;width: 100%;">Supplier - <?php echo $suppData['name']; ?></strong></td>
						<td align="right" valign="middle" width="300px">
							<div class="serviceActioinBox">
								<input type="button" class="serviceActBtn" value="Upload&nbsp;Document" onclick="alertspopupopen('action=serviceUploadDocument&supplierStatusId=<?php echo $supplierStatusData['id'];?>&quotationId=<?php echo $supplierStatusData['quotationId']; ?>','500px','auto');" > 
								<input type="button" class="serviceActBtn" value="Schedule&nbsp;Payment" onclick="alertspopupopen('action=serviceSchedulePayment&supplierStatusId=<?php echo $supplierStatusData['id'];?>&quotationId=<?php echo $supplierStatusData['quotationId']; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&currencyId=<?php echo $currencyId; ?>','1012px','auto');" >
							</div>
						</td>
						<td align="right" valign="middle"  width="300px">
							<?php 
						
							$totalSupplierCost = $supplierStatusData['totalSupplierCost']; 
							$r3sd=GetPageRecord('sum(amount) as totalpaid','supplierPaymentMaster',' supplierStatusId="'.$supplierStatusData['id'].'" and paymentStatus=1 '); 
							$supplierPaymentData = mysqli_fetch_array($r3sd);
							if($supplierPaymentData['totalpaid']>0){ 
								$PendingCost = ($totalSupplierCost-$supplierPaymentData['totalpaid']); 
							}else{ 
								$PendingCost = $totalSupplierCost; 
							}
							?>
							<div class="costBox" >Pending<br>
								<div id="supplierPendingCostAmt<?php echo($supplierStatusData['id']);?>" style="color:<?php if($totalSupplierCost<$supplierPaymentData['totalpaid']){ echo '#05b105'; }else{ echo '#CC3300'; } ?> "><?php echo round($PendingCost);?></div>
							</div>
							<div class="costBox" >Paid<br>
								<div id="supplierPaidCostAmt<?php echo($supplierStatusData['id']);?>"><?php echo round($supplierPaymentData['totalpaid']);?></div>
							</div> 
							
							<div class="costBox" >Total<br>
								<div id="supplierCompanyCostAmt<?php echo($supplierStatusData['id']);?>"><?php echo round($totalSupplierCost);?></div>
							</div>
							
						</td> 
						</tr>
					</table>
				</div>
			<?php
			$supplierCompanyCostWOGST = 0; 
			if($calculationType<>3){ 
				$select=''; 
				$where=''; 
				$hotelQuery='';
			 	$hotelQuery=GetPageRecord('*','finalQuote',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" group by hotelId order by fromDate asc');
				if(mysqli_num_rows($hotelQuery) > 0){  
					while($finalQuotHotelInfo=mysqli_fetch_array($hotelQuery)){

						if( ($finalQuotHotelInfo['isForeignEscort']==1 && $paxAdultFE>0) || ( $finalQuotHotelInfo['isLocalEscort']==1 && $paxAdultLE>0) ||  $finalQuotHotelInfo['isGuestType']==1 ){
							$hotelTypeLable ="";
							if($finalQuotHotelInfo['isLocalEscort']==1){
						        $hotelTypeLable .= "Local Escort,";
						    }
						    if($finalQuotHotelInfo['isForeignEscort']==1){
						        $hotelTypeLable .= "Foreign Escort,";
						    }
						    if($finalQuotHotelInfo['isGuestType']==1){
						        $hotelTypeLable .= "Guest,";
						    }

							$c="";
							$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$finalQuotHotelInfo['hotelId'].'"'); 
							$hotelData=mysqli_fetch_array($c);  
							$totalServiceCost = $totalServiceClientCost = 0;
			 				?>
						<div class="contentin alignment-ser" style="width: 96%;">
							<div class="inheader"><i class="fa fa-building"></i><?php echo rtrim($hotelTypeLable,',').":- "; echo strip($hotelData['hotelName']);  ?> </div>
							<?php  
							$cnt=1; 
							$select1=''; 
							$where1=''; 
							$hotelQuery1='';
							$select1 = 'id,currencyId,currencyValue,fromDate,roomSingle,roomDouble,roomTriple,roomTwin,roomEBedC,roomENBedC,roomEBedA,quadNoofRoom,teenNoofRoom,sixNoofBedRoom,eightNoofBedRoom,tenNoofBedRoom,roomType,mealPlanId,
									complimentaryBreakfast,complimentaryLunch,complimentaryDinner,isChildDinner,isChildLunch,isChildBreakfast,
									roomSingleCost as tatalSingleCost,					
									roomDoubleCost as tatalDoubleCost,					
									roomTripleCost as tatalTripleCost,					
									roomTwinCost as tatalTwinCost,					
									roomEBedCCost as tatalEBedCCost,					
									roomENBedCCost as tatalENBedCCost,					
									roomEBedACost as tatalEBedACost,					
									quadRoomCost as totalquadRoomCost,					
									teenRoomCost as totalteenRoomCost,					
									sixBedRoomCost as totalsixBedRoomCost,					
									eightBedRoomCost as totaleightBedRoomCost,				
									tenBedRoomCost as totaltenBedRoomCost,				
									breakfast as BreakfastCost,					
									lunch as LunchCost,					
									dinner as DinnerCost,
									childDinner as childDinnerCost,
									childLunch as childLunchCost,
									childBreakfast as childBreakfastCost';

							$where1=' quotationId="'.$finalQuotHotelInfo['quotationId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and hotelId = "'.$finalQuotHotelInfo['hotelId'].'" and isGuestType=1  order by fromDate asc';
							//group by roomType,mealPlanId
						 	$hotelQuery1=GetPageRecord($select1,'finalQuote',$where1);
							while($finalQuoteHotelRate=mysqli_fetch_array($hotelQuery1)){

								// GUEST  VAR ASSIGN AS NULL
								$tatalSingleCost=$tatalDoubleCost=$tatalTripleCost=$tatalTwinCost=$tatalEBedCCost=$tatalENBedCCost=$totalquadRoomCost=$totalteenRoomCost=$totalsixBedRoomCost=$totaleightBedRoomCost=$totaltenBedRoomCost=$LunchCost=$DinnerCost=$BreakfastCost=$childDinnerCost=$childBreakfastCost=$childLunchCost=$totalComplimentaryCost=$isChildDinner=$isChildLunch=$isChildBreakfast=$addHCost=$dayTotalHACost =0; 
								$totalServiceCost =  0;

								// ASSIGN AS VALUE
								$tatalSingleCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tatalSingleCost'])*$finalQuoteHotelRate['roomSingle'];
								$tatalDoubleCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tatalDoubleCost'])*$finalQuoteHotelRate['roomDouble'];
								$tatalTripleCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tatalTripleCost'])*$finalQuoteHotelRate['roomTriple'];
								$tatalTwinCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tatalTwinCost'])*$finalQuoteHotelRate['roomTwin'];
								$tatalEBedCCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tatalEBedCCost'])*$finalQuoteHotelRate['roomEBedC'];
								$tatalENBedCCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tatalENBedCCost'])*$finalQuoteHotelRate['roomENBedC'];
								
								$tatalEBedACost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['tatalEBedACost'])*$finalQuoteHotelRate['roomEBedA'];

								$totalquadRoomCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['totalquadRoomCost'])*$finalQuoteHotelRate['quadNoofRoom'];

								$totalteenRoomCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['totalteenRoomCost'])*$finalQuoteHotelRate['teenNoofRoom'];

								$totalsixBedRoomCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['totalsixBedRoomCost'])*$finalQuoteHotelRate['sixNoofBedRoom'];

								$totaleightBedRoomCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['totaleightBedRoomCost'])*$finalQuoteHotelRate['eightNoofBedRoom'];

								$totaltenBedRoomCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['totaltenBedRoomCost'])*$finalQuoteHotelRate['tenNoofBedRoom'];
								
								if($finalQuoteHotelRate['complimentaryBreakfast'] == 1){
									$BreakfastCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['BreakfastCost']);
								}
								if($finalQuoteHotelRate['complimentaryLunch'] == 1){
									$LunchCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['LunchCost']);
								}
								if($finalQuoteHotelRate['complimentaryDinner'] == 1){
									$DinnerCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['DinnerCost']); 
								}
								if($finalQuoteHotelRate['isChildDinner'] == 1){
									$childDinnerCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childDinnerCost']); 
								}
								if($finalQuoteHotelRate['isChildLunch'] == 1){
									$childLunchCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childLunchCost']); 
								}
								if($finalQuoteHotelRate['isChildBreakfast'] == 1){
									$childBreakfastCost = convert_to_base($finalQuoteHotelRate['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRate['childBreakfastCost']); 
								}
								$aa1 = GetPageRecord('costType,currencyId,fromDate,additionalCost ','finalQuoteHotelAdditional','finalQuotId="'.$finalQuoteHotelRate['id'].'" and quotationId="'.$finalQuotHotelInfo['quotationId'].'"');
								if(mysqli_num_rows($aa1)>0){
									while ($finalHotelAddData = mysqli_fetch_array($aa1)) {
										if ($finalHotelAddData['costType']==2) {
				                            $addHCost2 = convert_to_base($finalHotelAddData['currencyValue'],$baseCurrencyVal,$finalHotelAddData['additionalCost']); 
				                            $addHCost = ($addHCost2 /($totalPax+$paxAdultLE+$paxAdultFE));
				                        } else {
				                            $addHCost = convert_to_base($finalHotelAddData['currencyValue'],$baseCurrencyVal,$finalHotelAddData['additionalCost']); 
				                        }
				                        $dayTotalHACost = ($dayTotalHACost + trim($addHCost));
				                        $isHACost = 1;
				                    }
								}
								$totalComplimentaryCost = ($LunchCost+$DinnerCost+$BreakfastCost+$childDinnerCost+$childLunchCost+$childBreakfastCost+$dayTotalHACost)*$totalPax;

								// ASSIGN AS TOTAL VAL
								$totalServiceCost = round(($tatalSingleCost + $tatalDoubleCost + $tatalTripleCost + $tatalTwinCost + $tatalEBedCCost +$tatalENBedCCost + $tatalEBedACost + $totalquadRoomCost + $totalteenRoomCost+ $totalsixBedRoomCost + $totaleightBedRoomCost + $totaltenBedRoomCost + $totalComplimentaryCost ), 2);
								
								// ASSIGN AS SUPPLIER VALUE
								$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; //without GST and WOMarkup
								$d="";
								$d=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalQuoteHotelRate['roomType'].'"'); 
								$roomTypeData=mysqli_fetch_array($d);
								
								$e="";
								$e=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalQuoteHotelRate['mealPlanId'].'"'); 
								$mealplanData=mysqli_fetch_array($e);

								$fromDate = $finalQuoteHotelRate['fromDate'];
								$totalNights = mysqli_num_rows($hotelQuery1);
								$colspan = $totalNights+1;
								
								if($cnt == 1){ ?>
								<table width="100%" border="1" cellpadding="5" cellspacing="0"  style="font-size:13px;">
								<tr>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;" rowspan="<?php echo $colspan;?>"><strong>Guest</strong></td>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">CheckIn</td>
									<td  bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Room&nbsp;Type</td>
									<td  bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Meal&nbsp;Plan</td>
									<?php if($tatalSingleCost>0){ ?>
									<td width="130" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Single&nbsp;Cost</td>
									<?php } if($tatalDoubleCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Double&nbsp;Cost</td>
									<?php } if($tatalTripleCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Triple&nbsp;Cost</td>
									<?php } if($tatalTwinCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Twin&nbsp;Cost</td>
									<?php } if($tatalEBedACost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">E.Bed(A)&nbsp;Cost</td>
									<?php } if($totalquadRoomCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Quad&nbsp;Cost</td>
									<?php } if($totalteenRoomCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Teen&nbsp;Cost</td>
									<?php }  if($tatalEBedCCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">CWBed&nbsp;Cost</td>
									<?php } if($tatalENBedCCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">CNBed&nbsp;Cost</td>
									<?php } if($totalsixBedRoomCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">SixBed&nbsp;Cost</td>
									<?php } if($totaleightBedRoomCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">EightBed&nbsp;Cost</td>
									<?php } if($totaltenBedRoomCost>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">TenBed&nbsp;Cost</td>
									<?php }  if($finalQuoteHotelRate['complimentaryBreakfast'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Breakfast&nbsp;Cost(A)</td>
									<?php }  if($finalQuoteHotelRate['complimentaryLunch'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Lunch&nbsp;Cost(A)</td>
									<?php }  if($finalQuoteHotelRate['complimentaryDinner'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Dinner&nbsp;Cost(A)</td>
									<?php }  if($finalQuoteHotelRate['isChildBreakfast'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Breakfast&nbsp;Cost(C)</td>
									<?php }  if($finalQuoteHotelRate['isChildLunch'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Lunch&nbsp;Cost(C)</td>
									<?php }  if($finalQuoteHotelRate['isChildDinner'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Dinner&nbsp;Cost(C)</td>
									<?php } if($isHACost>0 ){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Additionals&nbsp;Cost</td>
									<?php }?>
									<td width="180"  align="right" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Total&nbsp;Cost&nbsp;to&nbsp;Company</td>
								</tr>
								<?php } ?>
								<tr>
									<td valign="bottom" ><?php echo date('d-m-Y',strtotime($fromDate));  ?></td>
									<td valign="bottom" ><?php echo $roomTypeData['name']; ?></td>
									<td valign="bottom" > <?php echo $mealplanData['name'];  ?></td>
									<?php if($tatalSingleCost>0 && $finalQuoteHotelRate['roomSingle']>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalSingleCost); ?> x <?php echo $finalQuoteHotelRate['roomSingle']; ?></td>
									<?php } if($tatalDoubleCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalDoubleCost);  ?> x <?php echo  $finalQuoteHotelRate['roomDouble']; ?></td>
									<?php } if($tatalTripleCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalTripleCost); ?> x <?php  echo $finalQuoteHotelRate['roomTriple'];?></td> 
									<?php } if($tatalTwinCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalTwinCost);?> x <?php  echo $finalQuoteHotelRate['roomTwin'];?></td>
									<?php } if($tatalEBedACost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalEBedACost);?> x <?php  echo $finalQuoteHotelRate['roomEBedA'];?></td>
									<?php } if($totalquadRoomCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($totalquadRoomCost);?> x <?php  echo $finalQuoteHotelRate['quadNoofRoom'];?></td>
									<?php } if($totalteenRoomCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($totalteenRoomCost);?> x <?php  echo $finalQuoteHotelRate['teenNoofRoom'];?></td>
									 <?php } if($tatalEBedCCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalEBedCCost);?> x <?php  echo $finalQuoteHotelRate['roomEBedC'];?></td>
									<?php } if($tatalENBedCCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalENBedCCost);?> x <?php  echo $finalQuoteHotelRate['roomENBedC'];?></td>
									<?php } if($totalsixBedRoomCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($totalsixBedRoomCost);?> x <?php  echo $finalQuoteHotelRate['sixNoofBedRoom'];?></td>
									<?php } if($totaleightBedRoomCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($totaleightBedRoomCost);?> x <?php  echo $finalQuoteHotelRate['eightNoofBedRoom'];?></td>
									<?php } if($totaltenBedRoomCost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($totaltenBedRoomCost);?> x <?php  echo $finalQuoteHotelRate['tenNoofBedRoom'];?></td>
									<?php } if($finalQuoteHotelRate['complimentaryBreakfast'] >0 ){ ?>
										<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($BreakfastCost).' x '.$totalPax.'Pax'; ?></td> 
									<?php } if($finalQuoteHotelRate['complimentaryLunch'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($LunchCost).' x '.$totalPax.'Pax'; ?></td>
									<?php } if($finalQuoteHotelRate['complimentaryDinner'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($DinnerCost).' x '.$totalPax.'Pax'; ?></td>
									<?php } if($finalQuoteHotelRate['isChildBreakfast'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($childBreakfastCost).' x '.$totalPax.'Pax'; ?></td>
									<?php } if($finalQuoteHotelRate['isChildLunch'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($childLunchCost).' x '.$totalPax.'Pax'; ?></td>
									<?php } if($finalQuoteHotelRate['isChildDinner'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($childDinnerCost).' x '.$totalPax.'Pax'; ?></td>
									<?php } if($isHACost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($dayTotalHACost).' x '.$totalPax.'Pax'; ?></td>
									<?php }?>
									<td width="180" align="right" valign="bottom"><strong><?php echo $totalServiceCost; ?></strong></td> 
								</tr> 
								<?php
								$cnt++; 
							} 

							$cnt=1;
							$where2=' quotationId="'.$finalQuotHotelInfo['quotationId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and hotelId = "'.$finalQuotHotelInfo['hotelId'].'" and isLocalEscort=1  order by fromDate asc';
						 	$hotelQuery2=GetPageRecord($select1,'finalQuote',$where2);
							while($finalQuoteHotelRateLE=mysqli_fetch_array($hotelQuery2)){
								// LOCAL ESOCRT VAR AS NULL
								$tatalSingleCostLE=$tatalDoubleCostLE=$tatalTripleCostLE=$LunchCostLE=$DinnerCostLE=$BreakfastCostLE=$totalComplimentaryCostLE=$totalServiceCostLE = $addHCostLE = $dayTotalHACostLE =0;
								
								$tatalSingleCostLE = convert_to_base($finalQuoteHotelRateLE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateLE['tatalSingleCost'])*$sglRoomLE; 

								$tatalDoubleCostLE = convert_to_base($finalQuoteHotelRateLE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateLE['tatalDoubleCost'])*$dblRoomLE;
								
								if($finalQuoteHotelRateLE['complimentaryBreakfast'] == 1){
									$BreakfastCostLE = convert_to_base($finalQuoteHotelRateLE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateLE['BreakfastCost']);
								}
								if($finalQuoteHotelRateLE['complimentaryLunch'] == 1){
									$LunchCostLE = convert_to_base($finalQuoteHotelRateLE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateLE['LunchCost']);
								}
								if($finalQuoteHotelRateLE['complimentaryDinner'] == 1){
									$DinnerCostLE = convert_to_base($finalQuoteHotelRateLE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateLE['DinnerCost']); 
								}
								 
								$aa1 = GetPageRecord('currencyId,fromDate,additionalCost ','finalQuoteHotelAdditional','finalQuotId="'.$finalQuoteHotelRateLE['id'].'" and quotationId="'.$finalQuotHotelInfo['quotationId'].'"');
								
								if(mysqli_num_rows($aa1)>0){
									while ($finalHotelAddData = mysqli_fetch_array($aa1)) {
										if ($finalHotelAddData['costType']==2) {
				                            $addHCostLE2 = convert_to_base($finalHotelAddData['currencyValue'],$baseCurrencyVal,$finalHotelAddData['additionalCost']); 
				                            $addHCostLE = ($addHCostLE2 /($totalPax+$paxAdultLE+$paxAdultFE));
				                        } else {
				                            $addHCostLE = convert_to_base($finalHotelAddData['currencyValue'],$baseCurrencyVal,$finalHotelAddData['additionalCost']); 
				                        }
				                        $dayTotalHACostLE = ($dayTotalHACostLE + trim($addHCostLE));
				                        $isHACost = 1;
				                    }
								}
								$totalComplimentaryCostLE = ($LunchCostLE+$DinnerCostLE+$BreakfastCostLE+$dayTotalHACostLE)*$paxAdultLE;


								// GET THE NET COST WITH FOC RATES
								$tatalSingleCostLE = getMarkupCost($tatalSingleCostLE,$hotelCostLE,$hotelCalTypeLE);
								$tatalDoubleCostLE = getMarkupCost($tatalDoubleCostLE,$hotelCostLE,$hotelCalTypeLE);
								$totalComplimentaryCostLE = getMarkupCost($totalComplimentaryCostLE,$hotelCostLE,$hotelCalTypeLE);

								// ASSIGN AS TOTAL VAL
								$totalServiceCostLE = round(($tatalSingleCostLE + $tatalDoubleCostLE + $totalComplimentaryCostLE ), 2);

								// ASSIGN AS SUPPLIER VALUE
								$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCostLE; //without GST and WOMarkup
							
								$d="";
								$d=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalQuoteHotelRateLE['roomType'].'"'); 
								$roomTypeData=mysqli_fetch_array($d);
								
								$e="";
								$e=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalQuoteHotelRateLE['mealPlanId'].'"'); 
								$mealplanData=mysqli_fetch_array($e);

								$fromDate = $finalQuoteHotelRateLE['fromDate'];
								$totalNights = mysqli_num_rows($hotelQuery2);
								$colspan = $totalNights+1;
								
								if($cnt == 1){ ?>
								<table width="100%" border="1" cellpadding="5" cellspacing="0"  style="font-size:13px;">
								<tr>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;" rowspan="<?php echo $colspan;?>"><strong>Local(E)</strong></td>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Night(s)</td>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Room&nbsp;Type</td>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Meal&nbsp;Plan</td>
									<?php if($tatalSingleCostLE>0){ ?>
									<td width="130" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Single&nbsp;Cost</td>
									<?php } if($tatalDoubleCostLE>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Double&nbsp;Cost</td>
									<?php } if($BreakfastCostLE>0  && $finalQuoteHotelRateLE['complimentaryBreakfast'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Breakfast&nbsp;Cost</td>
									<?php }  if($LunchCostLE>0 && $finalQuoteHotelRateLE['complimentaryLunch'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Lunch&nbsp;Cost</td>
									<?php }  if($DinnerCostLE>0 && $finalQuoteHotelRateLE['complimentaryDinner'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Dinner&nbsp;Cost</td>
									<?php } if($isHACost>0 ){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Additionals&nbsp;Cost</td>
									<?php } ?>
									<td width="180"  align="right" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Total&nbsp;Cost&nbsp;to&nbsp;Company</td>
								</tr>
								<?php } ?>
								<tr>
									<td valign="bottom" ><?php  echo date('d-m-Y',strtotime($fromDate));  ?></td>
									<td valign="bottom" ><?php echo $roomTypeData['name']; ?></td>
									<td valign="bottom" > <?php echo $mealplanData['name'];  ?></td>
									<?php if($tatalSingleCostLE>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalSingleCostLE); ?> x <?php echo $sglRoomLE; ?></td>
									<?php } if($tatalDoubleCostLE>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalDoubleCostLE);?> x <?php echo  $dblRoomLE; ?></td>
									<?php } if($BreakfastCostLE>0  && $finalQuoteHotelRateLE['complimentaryBreakfast'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($BreakfastCostLE).' x '.$paxAdultLE.'Pax'; ?></td> 
									<?php } if($LunchCostLE>0 && $finalQuoteHotelRateLE['complimentaryLunch'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($LunchCostLE).' x '.$paxAdultLE.'Pax'; ?></td>
									<?php } if($DinnerCostLE>0 && $finalQuoteHotelRateLE['complimentaryDinner'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($DinnerCostLE).' x '.$paxAdultLE.'Pax'; ?></td>
									<?php } if($isHACost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($addHCostLE).' x '.$totalPax.'Pax'; ?></td>
									<?php } ?>
									<td width="180" align="right" valign="bottom"><strong><?php echo $totalServiceCostLE; ?></strong></td> 
								</tr>
								<?php   
								$cnt++;
							} 

							$cnt=1;
							$where3=' quotationId="'.$finalQuotHotelInfo['quotationId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and hotelId = "'.$finalQuotHotelInfo['hotelId'].'" and isForeignEscort=1  order by fromDate asc';
						 	$hotelQuery3=GetPageRecord($select1,'finalQuote',$where3);
							while($finalQuoteHotelRateFE=mysqli_fetch_array($hotelQuery3)){
								// FORIEGN ESOCRT VAR AS NULL
								$tatalSingleCostFE=$tatalDoubleCostFE=$LunchCostFE=$DinnerCostFE=$BreakfastCostFE=$totalComplimentaryCostFE=$totalServiceCostFE = $addHCostFE = $dayTotalHACostFE = 0;

								$tatalSingleCostFE = convert_to_base($finalQuoteHotelRateFE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateFE['tatalSingleCost'])*$sglRoomFE; 
								$tatalDoubleCostFE = convert_to_base($finalQuoteHotelRateFE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateFE['tatalDoubleCost'])*$dblRoomFE; 
							
								if($finalQuoteHotelRateFE['complimentaryBreakfast'] == 1){
									$BreakfastCostFE = convert_to_base($finalQuoteHotelRateFE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateFE['BreakfastCost']);
								}
								if($finalQuoteHotelRateFE['complimentaryLunch'] == 1){
									$LunchCostFE = convert_to_base($finalQuoteHotelRateFE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateFE['LunchCost']);
								}
								if($finalQuoteHotelRateFE['complimentaryDinner'] == 1){
									$DinnerCostFE = convert_to_base($finalQuoteHotelRateFE['currencyValue'],$baseCurrencyVal,$finalQuoteHotelRateFE['DinnerCost']); 
								}
								$aa1 = GetPageRecord('currencyId,fromDate,additionalCost ','finalQuoteHotelAdditional','finalQuotId="'.$finalQuoteHotelRateLE['id'].'" and quotationId="'.$finalQuotHotelInfo['quotationId'].'"');
								if(mysqli_num_rows($aa1)>0){
									while ($finalHotelAddData = mysqli_fetch_array($aa1)) {
										if ($finalHotelAddData['costType']==2) {
				                            $addHCostFE2 = convert_to_base($finalHotelAddData['currencyValue'],$baseCurrencyVal,$finalHotelAddData['additionalCost']); 
				                            $addHCostFE = ($addHCostFE2 /($totalPax+$paxAdultLE+$paxAdultFE));
				                        } else {
				                            $addHCostFE = convert_to_base($finalHotelAddData['currencyValue'],$baseCurrencyVal,$finalHotelAddData['additionalCost']); 
				                        }
				                        $dayTotalHACostFE = ($dayTotalHACostFE + trim($addHCostFE));
				                        $isHACost = 1;
				                    }
								}

								$totalComplimentaryCostFE = ($LunchCostFE+$DinnerCostFE+$BreakfastCostFE+$dayTotalHACostFE)*$paxAdultFE;

								// GET THE NET COST WITH FOC RATES
								$tatalSingleCostFE = getMarkupCost($tatalSingleCostFE,$hotelCostFE,$hotelCalTypeFE);
								$tatalDoubleCostFE = getMarkupCost($tatalDoubleCostFE,$hotelCostFE,$hotelCalTypeFE);
								$totalComplimentaryCostFE = getMarkupCost($totalComplimentaryCostFE,$hotelCostLE,$hotelCalTypeFE);

								// ASSIGN AS TOTAL VAL
								$totalServiceCostFE = round(($tatalSingleCostFE + $tatalDoubleCostFE + $totalComplimentaryCostFE ), 2);
								// ASSIGN AS SUPPLIER VALUE
								$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCostFE; //without GST and WOMarkup
								
								$d="";
								$d=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalQuoteHotelRateFE['roomType'].'"'); 
								$roomTypeData=mysqli_fetch_array($d);
								
								$e="";
								$e=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalQuoteHotelRateFE['mealPlanId'].'"'); 
								$mealplanData=mysqli_fetch_array($e);

								$totalNights = mysqli_num_rows($hotelQuery3);
								$fromDate = $finalQuoteHotelRateFE['fromDate'];
								$colspan = $totalNights+1;
								
								if($cnt == 1){ ?>
								<table width="100%" border="1" cellpadding="5" cellspacing="0"  style="font-size:13px;">
								<tr>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;" rowspan="<?php echo $colspan;?>"><strong>Foreign(E)</strong></td>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Night(s)</td>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Room&nbsp;Type</td>
									<td bgcolor="#F3F3F3" style="color:#666666; font-size:13px;width: 120px;">Meal&nbsp;Plan</td>
									<?php if($tatalSingleCostFE>0){ ?>
									<td width="130" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Single&nbsp;Cost</td>
									<?php } if($tatalDoubleCostFE>0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Double&nbsp;Cost</td>
									<?php } if($BreakfastCostFE>0  && $finalQuoteHotelRateFE['complimentaryBreakfast'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Breakfast&nbsp;Cost</td>
									<?php }  if($LunchCostFE>0 && $finalQuoteHotelRateFE['complimentaryLunch'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Lunch&nbsp;Cost</td>
									<?php }  if($DinnerCostFE>0 && $finalQuoteHotelRateFE['complimentaryDinner'] >0){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Dinner&nbsp;Cost</td>
									<?php } if($isHACost>0 ){ ?>
									<td width="150" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Additionals&nbsp;Cost</td>
									<?php } ?>
									<td width="180"  align="right" bgcolor="#F3F3F3" style="color:#666666; font-size:13px;">Total&nbsp;Cost&nbsp;to&nbsp;Company</td>
								</tr>
								<?php }  ?>
								<tr>
									<td valign="bottom" ><?php echo date('d-m-Y',strtotime($fromDate));  ?></td>
									<td valign="bottom" ><?php echo $roomTypeData['name']; ?></td>
									<td valign="bottom" > <?php echo $mealplanData['name'];  ?></td>
									<?php if($tatalSingleCostFE>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalSingleCostFE); ?> x <?php echo $sglRoomFE; ?></td>
									<?php } if($tatalDoubleCostFE>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($tatalDoubleCostFE);  ?> x <?php echo  $dblRoomFE; ?></td>
									<?php } if($BreakfastCostFE>0  && $finalQuoteHotelRateFE['complimentaryBreakfast'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($BreakfastCostFE).' x '.$paxAdultFE.'Pax'; ?></td> 
									<?php } if($LunchCostFE>0 && $finalQuoteHotelRateFE['complimentaryLunch'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($LunchCostFE).' x '.$paxAdultFE.'Pax'; ?></td>
									<?php } if($DinnerCostFE>0 && $finalQuoteHotelRateFE['complimentaryDinner'] >0 ){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($DinnerCostFE).' x '.$paxAdultFE.'Pax'; ?></td>
									<?php } if($isHACost>0){ ?>
									<td valign="bottom" ><?php echo getTwoDecimalNumberFormat($addHCostFE).' x '.$totalPax.'Pax'; ?></td>
									<?php } ?>
									<td width="180" align="right" valign="bottom"><strong><?php echo $totalServiceCostFE; ?></strong></td> 
								</tr> 
								<?php 
								$cnt++;
							} 

							?>
						</table>
						</div>
						<?php 
						} 
					}
				}
				?>

				<?php 
				$select=''; 
				$where=''; 
				$transferQuery='';    
				$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" order by fromDate asc '); 
				if(mysqli_num_rows($transferQuery) > 0){
					while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
	 
					if(strtotime($finalQuoteTransfer['fromDate']) == strtotime($finalQuoteTransfer['toDate'])){ 
						$transferDates = date('d M, Y',strtotime($finalQuoteTransfer['fromDate'])); 
					}else{ 
						$transferDates = date('d',strtotime($finalQuoteTransfer['fromDate']))."-".date('d M, Y',strtotime($finalQuoteTransfer['toDate']));
					} 	
					
					$c="";  
					$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTransfer['transferId'].'"'); 
					$transferData=mysqli_fetch_array($c);
					
					$d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteTransfer['vehicleModelId'].'"'); 
					$vehicleData=mysqli_fetch_array($d);
					
					//check if supplier is self
					$vehicleName = $vehicleType = $transferType = '';
					$transportCostC = $adultTransferCostC = $childTransferCostC = $vehicleCostC = $distanceC = 0;
					if($finalQuoteTransfer['transferType'] == 1){ 
				        $adultTransferCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['adultCost']));
				        $childTransferCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['childCost']));
				        $infantTransferCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['infantCost']));
				        $repCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['repCost']));

				        $transportCostC = ($adultTransferCostC*$paxAdult)+($childTransferCostC*$paxChild)+($infantTransferCostC*$paxInfant)+($repCostC*$totalPax);
				    }else{ 
				        $vehicleCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['vehicleCost']));
				        if($finalQuoteTransfer['costType'] == 3){
				        	$distanceC = $finalQuoteTransfer['distance'];
				        	$transportCostC = ($vehicleCostC*$finalQuoteTransfer['noOfVehicles']*$distanceC);
				        }else{
				        	$transportCostC = ($vehicleCostC*$finalQuoteTransfer['noOfVehicles']);
				        }

				        $vehicleName = $vehicleData['model']." | ";
				        $vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
				    } 
					$transferType = ($finalQuoteTransfer['transferType'] == 1)?'SIC':'Private';
					$totalServiceCost = 0; 


					$totalServiceCost = $transportCostC;
					$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 

					?>
					<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Transport - <?php  echo strip($transferData['transferName']);  ?> - <?php  echo $transferDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
							<td width="150" style="color:#666666; font-size:13px;">Transfer&nbsp;Type</td>
							<?php if($finalQuoteTransfer['transferType'] == 1){ ?>
							<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Rep.&nbsp;Cost</td>
							<?php }else{ ?>
								<!-- <td  style="color:#666666; font-size:13px;">Vehicle&nbsp;Name</td> -->
								<td width="150" style="color:#666666; font-size:13px;">Vehicle&nbsp;Cost</td>
							<?php } ?>
							<td width="100" align="right">Total&nbsp;Service&nbsp;Cost</td>
							<td width="100" align="right" valign="bottom"> Cost&nbsp;to&nbsp;Company </td>
						</tr>
						<tr>
							<td valign="bottom"><?php echo $transferType; ?></td>
							<?php if($finalQuoteTransfer['transferType'] == 1){  ?>
							<td width="150" style="color:#666666; font-size:13px;"><?php echo round($adultTransferCostC).' X '.$paxAdult; ?></td>
							<td width="150" style="color:#666666; font-size:13px;"><?php echo round($childTransferCostC).' X '.$paxChild; ?></td>
							<td width="150" style="color:#666666; font-size:13px;"><?php echo round($repCostC).' X '.$totalPax; ?></td>
							<?php }else{ ?>
								<!-- <td valign="bottom"><?php echo $vehicleName.$vehicleType.' for '.$finalQuoteTransfer['noOfVehicles']." Vehicle"; ?></td> -->
								<td width="150" style="color:#666666; font-size:13px;">
									<?php 
									if($finalQuoteTransfer['costType'] == 3){ 
										echo round($vehicleCostC).' X '.$finalQuoteTransfer['noOfVehicles'].' (Vehicles) X '.$finalQuoteTransfer['distance'].' KM';  
									}else{ 
										echo round($vehicleCostC).' X '.$finalQuoteTransfer['noOfVehicles'];
									}  ?>
								</td>
							<?php } ?>

							<td width="150" align="right"  style="color:#666666; font-size:13px;"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
							<td width="150" align="right"  style="color:#666666; font-size:13px;"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
						</tr>
						</table>
					</div>
					<?php
					}
				}
				?>
	 			
				<?php  
				$select=''; 
				$where=''; 
				$entranceQuery='';   	
				$entranceQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
				if(mysqli_num_rows($entranceQuery) > 0){ 
					while($finalQuoteEntD=mysqli_fetch_array($entranceQuery)){
						
						if(strtotime($finalQuoteEntD['fromDate']) == strtotime($finalQuoteEntD['toDate'])){ 
							$entranceDates = date('d M, Y',strtotime($finalQuoteEntD['fromDate'])); 
						}else{ 
							$entranceDates = date('d',strtotime($finalQuoteEntD['fromDate']))."-".date('d M, Y',strtotime($finalQuoteEntD['toDate']));
						} 
	 					//entranceQuotationId
						$c="";
						$c=GetPageRecord('*','quotationEntranceMaster','id="'.$finalQuoteEntD['entranceQuotationId'].'"'); 
						$entranceQuoteData=mysqli_fetch_array($c);	 

						$c="";
						$c=GetPageRecord('*','packageBuilderEntranceMaster','id="'.$finalQuoteEntD['entranceId'].'"'); 
						$entranceData=mysqli_fetch_array($c);

						$d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteEntD['vehicleId'].'"'); 
						$vehicleData=mysqli_fetch_array($d);
						


						$vehicleName = $vehicleType = $transferType = '';
						$entCostC = $adultEntCostA = $childEntCostC = $vehicleCostC = 0;


						$ticketAdultCost = $finalQuoteEntD['ticketAdultCost']; //getCostWithGSTID_Markup($finalQuoteEntD['ticketAdultCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);
						$ticketchildCost = $finalQuoteEntD['ticketchildCost']; //getCostWithGSTID_Markup($finalQuoteEntD['ticketchildCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);
						$ticketinfantCost = $finalQuoteEntD['ticketinfantCost']; //getCostWithGSTID_Markup($finalQuoteEntD['ticketinfantCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);


						$adultCost = $finalQuoteEntD['adultCost']; //getCostWithGSTID_Markup($finalQuoteEntD['adultCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);
						$childCost = $finalQuoteEntD['childCost']; //getCostWithGSTID_Markup($finalQuoteEntD['childCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);
						$infantCost = $finalQuoteEntD['infantCost']; //getCostWithGSTID_Markup($finalQuoteEntD['infantCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);


						$vehicleCost = $finalQuoteEntD['vehicleCost']; //getCostWithGSTID_Markup($finalQuoteEntD['vehicleCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);
						$repCost = $finalQuoteEntD['repCost']; //getCostWithGSTID_Markup($finalQuoteEntD['repCost'],$finalQuoteEntD['gstTax'],$finalQuoteEntD['markupCost'],$finalQuoteEntD['markupType']);


						$ticketAdultCost = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$ticketAdultCost);
					    $ticketchildCost = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$ticketchildCost);
					    $ticketinfantCost = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$ticketinfantCost);


						//check if supplier is self
						if($finalQuoteEntD['transferType'] == 1){ 
					        $adultEntCostA = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$adultCost);
					        $childEntCostC = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$childCost);
					        $infantEntCostC = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$infantCost);
					        $repCostC = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$repCost);

					        $totalEntCostA = round($ticketAdultCost+$adultEntCostA+$repCostC);
							$totalEntCostC = round($ticketchildCost+$childEntCostC+$repCostC);
							$totalEntCostE = round($ticketinfantCost+$infantEntCostC+$repCostC);

					        $entCostC = ($totalEntCostA*$finalQuoteEntD['adultPax'])+($totalEntCostC*$finalQuoteEntD['childPax'])+($totalEntCostE*$finalQuoteEntD['infantPax']);
					    }elseif($finalQuoteEntD['transferType'] == 2 || $finalQuoteEntD['transferType'] == 3){ 
					        $vehicleCostC = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$vehicleCost);
					        $repCostC = convert_to_base($finalQuoteEntD['currencyValue'],$baseCurrencyVal,$repCost);

					        $totalEntCostA = ($ticketAdultCost+($vehicleCostC/($finalQuoteEntD['adultPax']+$finalQuoteEntD['childPax']+$finalQuoteEntD['infantPax']))+$repCostC);
					        $totalEntCostC = ($ticketchildCost+($vehicleCostC/($finalQuoteEntD['adultPax']+$finalQuoteEntD['childPax']+$finalQuoteEntD['infantPax']))+$repCostC);
					        $totalEntCostE = ($ticketinfantCost+($vehicleCostC/($finalQuoteEntD['adultPax']+$finalQuoteEntD['childPax']+$finalQuoteEntD['infantPax']))+$repCostC);

					        $entCostC=($ticketAdultCost*$finalQuoteEntD['adultPax'])+($ticketchildCost*$finalQuoteEntD['childPax'])+($ticketinfantCost*$finalQuoteEntD['infantPax'])+($repCostC*($finalQuoteEntD['adultPax']+$finalQuoteEntD['childPax']+$finalQuoteEntD['infantPax']))+$vehicleCostC;

					        $vehicleName = $vehicleData['model']." | ";
					        $vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
					    } 

						if($finalQuoteEntD['transferType'] == 1){ $transferType = 'SIC ';
						}elseif($finalQuoteEntD['transferType'] == 2){ $transferType = 'Private ';
						}elseif($finalQuoteEntD['transferType'] == 3){ $transferType = 'VIP ';
						}else{ $transferType = 'Ticket Only '; }

						$totalServiceCost = 0; 
						$totalServiceCostLE  = 0; 
						$totalServiceCostFE = 0; 


						$totalServiceCost = $entCostC;
						// ESCORT CAL .
						$totalServiceCostLE = round($totalEntCostA*$paxAdultLE);
						$totalServiceCostFE = round($totalEntCostA*$paxAdultFE);

						// $supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Entrance - <?php  echo ucfirst($entranceData['entranceName']);  ?> - <?php  echo $entranceDates;  ?> | Transfer Type - <?php echo $transferType; ?></div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
							<tr>
								<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Ticket&nbsp;Cost</td>
								<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Ticket&nbsp;Cost</td>
								<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Ticket&nbsp;Cost</td>

								<?php if ($paxAdultLE>0) { ?>
								<td width="150" style="color:#666666; font-size:13px;">LocalEscort&nbsp;Cost</td>
								<?php } if ($paxAdultFE>0) { ?>
								<td width="150" style="color:#666666; font-size:13px;">ForeignEscort&nbsp;Cost</td>
								<?php } ?>

								<?php if($finalQuoteEntD['transferType'] == 1){  ?>
								<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Transfer&nbsp;Cost</td>
								<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Transfer&nbsp;Cost</td>
								<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Transfer&nbsp;Cost</td>
								<td width="150" style="color:#666666; font-size:13px;">Rep.&nbsp;Cost</td>
								<?php }elseif($finalQuoteEntD['transferType'] == 2){ ?>
								<td style="color:#666666; font-size:13px;">Vehicle&nbsp;Name</td>
								<td width="150" style="color:#666666; font-size:13px;">Vehicle&nbsp;Cost</td>
								<?php } ?>

								<td align="right" style="color:#666666; font-size:13px;">Total&nbsp;Service&nbsp;Cost<?php if($paxAdultFE>0 || $paxAdultLE>0){ ?>(Guest + Escort)<?php } ?></td> 
								<td width="180" align="right" style="color:#666666; font-size:13px;">Cost to Company</td>
							</tr>

							<tr> 
								<td width="150"  valign="bottom"><?php echo $ticketAdultCost." x ".$finalQuoteEntD['adultPax'];  ?></td>
								<td width="150"  valign="bottom"><?php echo $ticketchildCost." x ".$finalQuoteEntD['childPax'];  ?></td>
								<td width="150"  valign="bottom"><?php echo $ticketinfantCost." x ".$finalQuoteEntD['infantPax'];  ?></td>
								<?php if ($paxAdultLE>0) { ?>
								<td width="150"  valign="bottom"><?php echo $totalEntCostA." x ".$paxAdultLE;  ?></td>
								<?php } if ($paxAdultFE>0) { ?>
								<td width="150"  valign="bottom"><?php echo $totalEntCostA." x ".$paxAdultFE;  ?></td>
								<?php } ?>

								<?php if($finalQuoteEntD['transferType'] == 1){  ?>
								<td width="150"  valign="bottom"><?php echo $adultEntCostA." x ".$finalQuoteEntD['adultPax'];  ?></td>
								<td width="150"  valign="bottom"><?php echo $childEntCostC." x ".$finalQuoteEntD['childPax'];  ?></td>
								<td width="150"  valign="bottom"><?php echo $infantEntCostC." x ".$finalQuoteEntD['infantPax'];  ?></td>
								<td width="150"  valign="bottom"><?php echo $repCostC." x ".$totalPax;  ?></td>
								<?php }elseif($finalQuoteEntD['transferType'] == 2){ ?>
								<td width="150"  valign="bottom"><?php echo $vehicleName.$vehicleType;  ?></td>
								<td width="150"  valign="bottom"><?php echo $vehicleCostC;  ?></td>
								<?php } ?>
								<td width="150" align="right"  valign="bottom"><?php echo $totalServiceCost = ($totalEntCostA*$finalQuoteEntD['adultPax'])+($totalEntCostC*$finalQuoteEntD['childPax'])+($totalEntCostE*$finalQuoteEntD['infantPax']); 
									if ($paxAdultLE>0 || $paxAdultFE>0) {
										echo "+".round($totalServiceCostLE+$totalServiceCostFE); 
									}	
									$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost + $totalServiceCostLE + $totalServiceCostFE; 
									?>
								</td>
								<td width="150" align="right"  valign="bottom"><?php echo round($totalServiceCost + $totalServiceCostLE + $totalServiceCostFE); ?></td>
							</tr>
						</table>
						</div>
				 		<?php 
					}  
				}

				$select=''; 
				$where=''; 
				$ferryQuery='';   	
				$ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
				if(mysqli_num_rows($ferryQuery) > 0){ 
					while($finalQuoteFerryD=mysqli_fetch_array($ferryQuery)){
						
						if(strtotime($finalQuoteFerryD['fromDate']) == strtotime($finalQuoteFerryD['toDate'])){ 
							$ferryDates = date('d M, Y',strtotime($finalQuoteFerryD['fromDate'])); 
						}else{ 
							$ferryDates = date('d',strtotime($finalQuoteFerryD['fromDate']))."-".date('d M, Y',strtotime($finalQuoteFerryD['toDate']));
						} 
	 					//ferryQuotationId
						$c="";
						$c=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,'id="'.$finalQuoteFerryD['ferryQuotationId'].'"'); 
						$ferryQuoteData=mysqli_fetch_array($c);	 

						$c="";
						$c=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerryD['ferryId'].'"'); 
						$ferryServiceData=mysqli_fetch_array($c);

						$totalServiceCost = 0; 
						$totalServiceCostLE  = 0; 
						$totalServiceCostFE = 0; 

						$adultCost = ($finalQuoteFerryD['adultCost']+$finalQuoteFerryD['processingfee']+$finalQuoteFerryD['miscCost']);
						$childCost = ($finalQuoteFerryD['childCost']+$finalQuoteFerryD['processingfee']+$finalQuoteFerryD['miscCost']);
						$infantCost = ($finalQuoteFerryD['infantCost']+$finalQuoteFerryD['processingfee']+$finalQuoteFerryD['miscCost']);

						// $adultCost = getCostWithGSTID_Markup($adultCost,$finalQuoteFerryD['gstTax'],$finalQuoteFerryD['markupCost'],$finalQuoteFerryD['markupType']);
						// $childCost = getCostWithGSTID_Markup($childCost,$finalQuoteFerryD['gstTax'],$finalQuoteFerryD['markupCost'],$finalQuoteFerryD['markupType']);
						// $infantCost = getCostWithGSTID_Markup($infantCost,$finalQuoteFerryD['gstTax'],$finalQuoteFerryD['markupCost'],$finalQuoteFerryD['markupType']);
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Ferry Service - <?php  echo ucfirst($ferryServiceData['name']);  ?> - <?php  echo $ferryDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
						<td width="300" style="color:#666666; font-size:13px;">Adult&nbsp;Cost(PP)</td>
						<td width="300" style="color:#666666; font-size:13px;">Child&nbsp;Cost(PP)</td>
						<td width="300" style="color:#666666; font-size:13px;">Infant&nbsp;Cost(PP)</td>
						<?php if ($paxAdultLE>0) { ?>
						<td width="150" style="color:#666666; font-size:13px;">LocalEscort&nbsp;Cost(PP)</td>
						<?php } if ($paxAdultFE>0) { ?>
						<td width="150" style="color:#666666; font-size:13px;">ForeignEscort&nbsp;Cost(PP)</td>
						<?php } ?>
						<td align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost<?php if($paxAdultFE>0){ ?>(Guest + Escort)<?php } ?></td> 
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost to Company</td>
						</tr>
						<tr> 
				 		<td width="150"  valign="bottom"><?php echo $adultCost." x ".$finalQuoteFerryD['adultPax'];  ?></td>
				 		<td width="150"  valign="bottom"><?php echo $childCost." x ".$finalQuoteFerryD['childPax'];  ?></td>
				 		<td width="150"  valign="bottom"><?php echo $infantCost." x ".$finalQuoteFerryD['infantPax'];  ?></td>
				 		<?php if ($paxAdultLE>0) { ?>
				 		<td width="150"  valign="bottom"><?php echo $adultCost." x ".$paxAdultLE;  ?></td>
				 		<?php } if ($paxAdultFE>0) { ?>
				 		<td width="150"  valign="bottom"><?php echo $adultCost." x ".$paxAdultFE;  ?></td>
				 		<?php } ?>
						<td align="right" valign="bottom"> 
						<span class="style1">
						<?php
						echo $serviceCost = round($adultCost*$finalQuoteFerryD['adultPax'])+round($childCost*$finalQuoteFerryD['childPax'])+round($infantCost*$finalQuoteFerryD['infantPax']);
						$totalServiceCost = convert_to_base($ferryQuoteData['currencyValue'],$baseCurrencyVal,$serviceCost);

						// ESCORT CAL .
						$totalServiceCostLE = convert_to_base($ferryQuoteData['currencyValue'],$baseCurrencyVal,round($adultCost*$paxAdultLE));
						$totalServiceCostFE = convert_to_base($ferryQuoteData['currencyValue'],$baseCurrencyVal,round($adultCost*$paxAdultFE));

						echo "+".round($totalServiceCostLE+$totalServiceCostFE);

						$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost + $totalServiceCostLE + $totalServiceCostFE; 
						//without GST and WOMarkup
						?></span>
						</td> 
						<td width="180" align="right" valign="bottom"><span><?php echo round($totalServiceCost + $totalServiceCostLE + $totalServiceCostFE); ?></span></td> 
						</tr>
						</table>
						</div>
				 		<?php 
					 }  
				}
				
				$select=''; 
				$where=''; 
				$cruiseQuery='';   
				$cruiseQuery=GetPageRecord('*','finalQuoteCruise',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'"  '.$getNSQuery.' order by fromDate asc '); 
				if(mysqli_num_rows($cruiseQuery) > 0){
					while($finalQuoteCruiseD=mysqli_fetch_array($cruiseQuery)){
 
						if(strtotime($finalQuoteCruiseD['fromDate']) == strtotime($finalQuoteCruiseD['toDate'])){ 
							$crsDates = date('d M, Y',strtotime($finalQuoteCruiseD['fromDate'])); 
						}else{
							$crsDates = date('d',strtotime($finalQuoteCruiseD['fromDate']))."-".date('d M, Y',strtotime($finalQuoteCruiseD['toDate']));
						}
						
						$c=GetPageRecord('*',_CRUISE_MASTER_,'id="'.$finalQuoteCruiseD['cruisePackageId'].'"'); 
						$cruiseData=mysqli_fetch_array($c);	 
	 					
	 					// Final Price
						$cruise_adultCost = $cruise_childCost = $totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 

						$cruise_AdultPax = $finalQuoteCruiseD['adultPax'];
					    $cruise_ChildPax = $finalQuoteCruiseD['childPax'];
					    $cruise_adultCost = convert_to_base($finalQuoteCruiseD['currencyValue'],$baseCurrencyVal,$finalQuoteCruiseD['adultCost']);
					    $cruise_childCost = convert_to_base($finalQuoteCruiseD['currencyValue'],$baseCurrencyVal,$finalQuoteCruiseD['childCost']);

	 					// Quote Price
	 					$cruise_adultCost2 = $cruise_childCost2 = $totalServiceCost2 = $totalServiceCostLE2 = $totalServiceCostFE2 = 0; 

						$cruise_AdultPax2 = $finalQuoteCruiseD['adultPax2'];
					    $cruise_ChildPax2 = $finalQuoteCruiseD['childPax2'];
					    $cruise_adultCost2 = convert_to_base($finalQuoteCruiseD['currencyValue'],$baseCurrencyVal,$finalQuoteCruiseD['adultCost2']);
					    $cruise_childCost2 = convert_to_base($finalQuoteCruiseD['currencyValue'],$baseCurrencyVal,$finalQuoteCruiseD['childCost2']);
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i><?php echo " Cruise: "; echo ucfirst($cruiseData['cruiseName']);  ?> - <?php  echo $crsDates;  ?></div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
						<td width="150"style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
						<td width="150"style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
						<?php if ($paxAdultLE>0) { ?>
						<td width="150" style="color:#666666; font-size:13px;">LocalEscort&nbsp;Cost(PP)</td>
						<?php } if ($paxAdultFE>0) { ?>
						<td width="150" style="color:#666666; font-size:13px;">ForeignEscort&nbsp;Cost(PP)</td>
						<?php } ?>
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>

						<tr>
						<td width="150" valign="bottom"><?php 
							echo $cruise_adultCost; 
							echo 'x'.$cruise_AdultPax;
							 ?>
						</td>
						<td width="150" valign="bottom"><?php 
							echo $cruise_childCost; 
							echo 'x'.$cruise_ChildPax;
							?>
						</td>
						<?php if ($paxAdultLE>0) { ?>
				 		<td width="150"  valign="bottom"><?php 
				 			echo $cruise_adultCost." x ".$paxAdultLE; 
				 			$totalServiceCostLE = round($cruise_adultCost*$paxAdultLE); 
				 			$totalServiceCostLE2 = round($cruise_adultCost2*$paxAdultLE);  
				 			?>
				 		</td>
				 		<?php } if ($paxAdultFE>0) { ?>
				 		<td width="150"  valign="bottom"><?php 
				 			echo $cruise_adultCost." x ".$paxAdultFE;  
				 			$totalServiceCostFE = round($cruise_adultCost*$paxAdultFE); 
							$totalServiceCostFE2 = round($cruise_adultCost2*$paxAdultFE);
				 			?>
				 		</td>
				 		<?php } ?>

						<td align="right" valign="bottom"> <span class="style1">
							<?php 
							echo $totalServiceCost = round($cruise_adultCost*$cruise_AdultPax)+($cruise_childCost*$cruise_ChildPax); 
							$totalServiceCost2 = round($cruise_adultCost2*$cruise_AdultPax2)+($cruise_childCost2*$cruise_ChildPax2); 
							?></span>					
						</td>
						
						<td width="180" align="right" valign="bottom"> 
							<?php 
							//withGST and WOMarkup						
							$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCostLE + $totalServiceCostFE + $totalServiceCost; 
							$supplierCompanyCostWOGST2 = $supplierCompanyCostWOGST2 + $totalServiceCostLE2 + $totalServiceCostFE2 + $totalServiceCost2; 
							?><span  ><?php echo round($totalServiceCostLE + $totalServiceCostFE + $totalServiceCost); ?></span></td> 
						</tr>
						</table>
						</div> 
						<?php  
					} 
				} 

				$select=''; 
				$where=''; 
				$activityQuery='';   	
				$activityQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
				if(mysqli_num_rows($activityQuery) > 0){ 
					while($finalQuoteActivity=mysqli_fetch_array($activityQuery)){
						
						if(strtotime($finalQuoteActivity['fromDate']) == strtotime($finalQuoteActivity['toDate'])){ 
							$activityDates = date('d M, Y',strtotime($finalQuoteActivity['fromDate'])); 
						}else{ 
							$activityDates = date('d',strtotime($finalQuoteActivity['fromDate']))."-".date('d M, Y',strtotime($finalQuoteActivity['toDate']));
						} 
	 					//entranceQuotationId
						$c=GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$finalQuoteActivity['activityId'].'"'); 
						$activityData=mysqli_fetch_array($c);

						$d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteActivity['vehicleId'].'"'); 
						$vehicleData=mysqli_fetch_array($d);
						
						

						$vehicleName = $vehicleType = $transferType = '';
						$actCostC = $adultActCostA = $childActCostC = $vehicleCostC = 0;


						$ticketAdultCost = $finalQuoteActivity['ticketAdultCost']; //getCostWithGSTID_Markup($finalQuoteActivity['ticketAdultCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);
						$ticketchildCost = $finalQuoteActivity['ticketchildCost'] ;//getCostWithGSTID_Markup($finalQuoteActivity['ticketchildCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);
						$ticketinfantCost = $finalQuoteActivity['ticketinfantCost']; //getCostWithGSTID_Markup($finalQuoteActivity['ticketinfantCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);


						$adultCost = $finalQuoteActivity['adultCost'];//getCostWithGSTID_Markup($finalQuoteActivity['adultCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);
						$childCost = $finalQuoteActivity['childCost'];//getCostWithGSTID_Markup($finalQuoteActivity['childCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);
						$infantCost = $finalQuoteActivity['infantCost']; //getCostWithGSTID_Markup($finalQuoteActivity['infantCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);

						$vehicleCost = $finalQuoteActivity['vehicleCost'];//getCostWithGSTID_Markup($finalQuoteActivity['vehicleCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);
						$repCost = $finalQuoteActivity['repCost']; //getCostWithGSTID_Markup($finalQuoteActivity['repCost'],$finalQuoteActivity['gstTax'],$finalQuoteActivity['markupCost'],$finalQuoteActivity['markupType']);



						$ticketAdultCost = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$ticketAdultCost);
					    $ticketchildCost = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$ticketchildCost);
					    $ticketinfantCost = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$ticketinfantCost);

						//check 
						if($finalQuoteActivity['transferType'] == 1){ 
					        $adultActCostA = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$adultCost);
					        $childActCostC = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$childCost);
					        $infantActCostE = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$infantCost);

					        $repCostC = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$repCost);

					        $totalActCostA = round($ticketAdultCost+$adultActCostA+$repCostC);
							$totalActCostC = round($ticketchildCost+$childActCostC+$repCostC);
							$totalActCostE = round($ticketinfantCost+$infantActCostE+$repCostC);

					        $actCostC = ($totalActCostA*$paxAdult)+($totalActCostC*$paxChild)+($totalActCostE*$paxInfant);
					    }
					    if($finalQuoteActivity['transferType'] == 2 || $finalQuoteActivity['transferType'] == 3){ 
					        $vehicleCostC = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$vehicleCost);

					        $repCostC = convert_to_base($finalQuoteActivity['currencyValue'],$baseCurrencyVal,$repCost);


					       	$totalActCostA = ($ticketAdultCost+($vehicleCostC/$totalPax)+$repCostC);
					       	$totalActCostE = ($ticketchildCost+($vehicleCostC/$totalPax)+$repCostC);
					       	$totalActCostC = ($ticketinfantCost+($vehicleCostC/$totalPax)+$repCostC);

					       	$actCostC = ($ticketAdultCost*$paxAdult)+($ticketchildCost*$paxChild)+($ticketinfantCost*$paxInfant)+($repCostC*$totalPax)+$vehicleCostC;

					        $vehicleName = $vehicleData['model']." | ";
					        $vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
					    }else{
					        $totalActCostA = round($ticketAdultCost);
							$totalActCostC = round($ticketchildCost);
							$totalActCostE = round($ticketinfantCost);

					        $actCostC = ($ticketAdultCost*$finalQuoteActivity['adultPax'])+($ticketchildCost*$finalQuoteActivity['childPax'])+($ticketinfantCost*$finalQuoteActivity['infantPax']);
					    }

						if($finalQuoteActivity['transferType'] == 1){
							$transferType = 'SIC';
						}elseif($finalQuoteActivity['transferType'] == 2){
							$transferType = 'PVT';
						}if($finalQuoteActivity['transferType'] == 3){
							$transferType = 'VIP';
						}if($finalQuoteActivity['transferType'] == 4){
							$transferType = 'Ticket Only';
						}

						$totalServiceCost = 0; 
						$totalServiceCostLE  = 0; 
						$totalServiceCostFE = 0; 

						$totalServiceCost = $actCostC;
						// ESCORT CAL .
						$totalServiceCostLE = round($totalActCostA*$paxAdultLE);
						$totalServiceCostFE = round($totalActCostA*$paxAdultFE);

						// $supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Sightseeing - <?php  echo ucfirst($activityData['otherActivityName']);  ?> - <?php  echo $activityDates;  ?> | Transfer Type - <?php echo $transferType; ?></div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
							<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Ticket&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Ticket&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Ticket&nbsp;Cost</td>

							<?php if ($paxAdultLE>0) { ?>
							<td width="150" style="color:#666666; font-size:13px;">LocalEscort&nbsp;Cost</td>
							<?php } if ($paxAdultFE>0) { ?>
							<td width="150" style="color:#666666; font-size:13px;">ForeignEscort&nbsp;Cost</td>
							<?php } ?>

							<?php if($finalQuoteActivity['transferType'] == 1){  ?>
							<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Transfer&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Transfer&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Transfer&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Rep.&nbsp;Cost</td>
							<?php }elseif($finalQuoteActivity['transferType'] == 2 || $finalQuoteActivity['transferType'] == 3){ ?>
							<td style="color:#666666; font-size:13px;">Vehicle&nbsp;Name</td>
							<td width="150" style="color:#666666; font-size:13px;">Vehicle&nbsp;Cost</td>
							<?php } ?>

							<td align="right" style="color:#666666; font-size:13px;">Total&nbsp;Service&nbsp;Cost<?php if($paxAdultFE>0 || $paxAdultLE>0){ ?>(Guest + Escort)<?php } ?></td> 
							<td width="180" align="right" style="color:#666666; font-size:13px;">Cost to Company</td>
						</tr>

						<tr> 
					 		<td width="150"  valign="bottom"><?php echo $ticketAdultCost." x ".$finalQuoteActivity['adultPax'];  ?></td>
					 		<td width="150"  valign="bottom"><?php echo $ticketchildCost." x ".$finalQuoteActivity['childPax'];  ?></td>
					 		<td width="150"  valign="bottom"><?php echo $ticketinfantCost." x ".$finalQuoteActivity['infantPax'];  ?></td>
					 		<?php if ($paxAdultLE>0) { ?>
					 		<td width="150"  valign="bottom"><?php echo $totalEntCostA." x ".$paxAdultLE;  ?></td>
					 		<?php } if ($paxAdultFE>0) { ?>
					 		<td width="150"  valign="bottom"><?php echo $totalEntCostA." x ".$paxAdultFE;  ?></td>
					 		<?php } ?>

					 		<?php if($finalQuoteActivity['transferType'] == 1){  ?>
					 		<td width="150"  valign="bottom"><?php echo $adultActCostA." x ".$finalQuoteActivity['adultPax'];  ?></td>
					 		<td width="150"  valign="bottom"><?php echo $childActCostC." x ".$finalQuoteActivity['childPax'];  ?></td>
					 		<td width="150"  valign="bottom"><?php echo $infantActCostE." x ".$finalQuoteActivity['infantPax'];  ?></td>
					 		<td width="150"  valign="bottom"><?php echo $repCostC." x ".$totalPax;  ?></td>
							<?php }elseif($finalQuoteActivity['transferType'] == 2 || $finalQuoteActivity['transferType'] == 3){ ?>
					 		<td width="150"  valign="bottom"><?php echo $vehicleName.$vehicleType;  ?></td>
					 		<td width="150"  valign="bottom"><?php echo $vehicleCostC;  ?></td>
							<?php } ?>
					 		<td width="150" align="right"  valign="bottom"><?php echo $totalServiceCost; 
					 			if ($paxAdultLE>0 || $paxAdultFE>0) {
					 				echo "+".round($totalServiceCostLE+$totalServiceCostFE); 
					 			}	
								$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost + $totalServiceCostLE + $totalServiceCostFE; 
					 			?>
					 		</td>
					 		<td width="150" align="right"  valign="bottom"><?php echo round($totalServiceCost + $totalServiceCostLE + $totalServiceCostFE); ?></td>
						</tr>
						</table>
						</div>
				 		<?php 
					}  
				}

				$select=''; 
				$where=''; 
				$trainQuery='';   
				$trainQuery=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'"  order by fromDate asc '); 
				if(mysqli_num_rows($trainQuery) > 0){
					while($finalQuoteTrains=mysqli_fetch_array($trainQuery)){
					if( ($finalQuoteTrains['isForeignEscort']==1 && $paxAdultFE>0) || ( $finalQuoteTrains['isLocalEscort']==1 && $paxAdultLE>0) ||  $finalQuoteTrains['isGuestType']==1 ){
						$trainTypeLable ="";
						if($finalQuoteTrains['isLocalEscort']==1){
					        $trainTypeLable .= "Local Escort,";
					    }
					    if($finalQuoteTrains['isForeignEscort']==1){
					        $trainTypeLable .= "Foreign Escort,";
					    }
					    if($finalQuoteTrains['isGuestType']==1){
					        $trainTypeLable .= "Guest,";
					    }

						if(strtotime($finalQuoteTrains['fromDate']) == strtotime($finalQuoteTrains['toDate'])){ 
							$trainDates = date('d M, Y',strtotime($finalQuoteTrains['fromDate'])); 
						}else{
							$trainDates = date('d',strtotime($finalQuoteTrains['fromDate']))."-".date('d M, Y',strtotime($finalQuoteTrains['toDate']));
						}
						
						$c=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$finalQuoteTrains['trainId'].'"'); 
						$trainData=mysqli_fetch_array($c);	 
	 
						$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 

						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i><?php echo rtrim($trainTypeLable,',')." Train: "; echo ucfirst($trainData['trainName']);  ?> - <?php  echo $trainDates;  ?></div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
						<td width="150"style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
						<td width="150"style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
						<td width="150"style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td>
						<?php if($finalQuoteTrains['isLocalEscort']==1){ ?>
						<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost( Local )</td>
						<?php }if($finalQuoteTrains['isForeignEscort']==1){ ?>
						<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost( Foreign )</td>
						<?php } if($finalQuoteTrains['isGuestType']==1){ ?>
						<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost( Guest)</td>
						<?php } ?>
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>

						<tr>
						<td width="150" valign="bottom"><?php 
							$adultCost = convert_to_base($finalQuoteTrains['currencyValue'],$baseCurrencyVal,$finalQuoteTrains['adultCost']); 
							echo $adultCost; //= getCostWithGSTID_Markup($adultCost,$finalQuoteTrains['gstTax'],$finalQuoteTrains['markupCost'],$finalQuoteTrains['markupType']);
							echo 'x'.$finalQuoteTrains['adultPax'];
							?>
						</td>
						<td width="150" valign="bottom"><?php 
							echo $childCost = convert_to_base($finalQuoteTrains['currencyValue'],$baseCurrencyVal,$finalQuoteTrains['childCost']); 
							 //getCostWithGSTID_Markup($childCost,$finalQuoteTrains['gstTax'],$finalQuoteTrains['markupCost'],$finalQuoteTrains['markupType']);
							echo 'x'.$finalQuoteTrains['childPax'];
							?>
						</td>
						<td width="150" valign="bottom"><?php 
							echo $infantCost = convert_to_base($finalQuoteTrains['currencyValue'],$baseCurrencyVal,$finalQuoteTrains['infantCost']); 
							// getCostWithGSTID_Markup($infantCost,$finalQuoteTrains['gstTax'],$finalQuoteTrains['markupCost'],$finalQuoteTrains['markupType']);
							echo 'x'.$finalQuoteTrains['infantPax'];
							?>
						</td>
						<?php if($finalQuoteTrains['isLocalEscort']==1){ ?>
						<td align="right" valign="bottom"> <span class="style1">
							<?php 
							echo $totalServiceCostLE = round($adultCost*$paxAdultLE); 
							?></span>					
						</td>
						<?php }if($finalQuoteTrains['isForeignEscort']==1){ ?>
						<td align="right" valign="bottom"> <span class="style1">
							<?php 
							echo $totalServiceCostFE = round($adultCost*$paxAdultFE); 
							?></span>					
						</td>
						<?php } if($finalQuoteTrains['isGuestType']==1){ ?>
						<td align="right" valign="bottom"> <span class="style1">
							<?php 
							echo $totalServiceCost = round($adultCost*$finalQuoteTrains['adultPax'])+($childCost*$finalQuoteTrains['childPax'])+($infantCost*$finalQuoteTrains['infantPax']); ?></span>
						</td>
						<?php } ?>
						
						<td width="180" align="right" valign="bottom"> 
							<?php 
							//withGST and WOMarkup						
							$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCostLE + $totalServiceCostFE + $totalServiceCost; 
							?><span  ><?php echo round($totalServiceCostLE + $totalServiceCostFE + $totalServiceCost); ?></span></td> 
						</tr>
						</table>
						</div> 
						<?php 
					} 
					} 
				} 

				$select=''; 
				$where=''; 
				$mealPlanQuery='';   
				$mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
				if(mysqli_num_rows($mealPlanQuery) > 0){
				 
					while($finalQuoteMealPlan=mysqli_fetch_array($mealPlanQuery)){
						
						$mealPlanDates = date('d M, Y',strtotime($finalQuoteMealPlan['fromDate'])); 
						$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Restaurant - <?php  echo strip($finalQuoteMealPlan['mealPlanName']);  ?> - <?php  echo $mealPlanDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
							<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
							<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td>
							<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost<?php if($paxAdultLE>0 || $paxAdultFE>0){ ?>(Guest + Escort)<?php } ?></td> 
							<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>
						<tr>
							<td width="150" valign="bottom"><?php 
								echo $adultCost = convert_to_base($finalQuoteMealPlan['currencyValue'],$baseCurrencyVal,$finalQuoteMealPlan['adultCost']); 
								 //$adultCost = getCostWithGSTID_Markup($adultCost,$finalQuoteMealPlan['gstTax'],$finalQuoteMealPlan['markupCost'],$finalQuoteMealPlan['markupType']);
								?>
							</td>
							<td width="150" valign="bottom"><?php 
								echo $childCost = convert_to_base($finalQuoteMealPlan['currencyValue'],$baseCurrencyVal,$finalQuoteMealPlan['childCost']); 
								//echo getCostWithGSTID_Markup($childCost,$finalQuoteMealPlan['gstTax'],$finalQuoteMealPlan['markupCost'],$finalQuoteMealPlan['markupType']);
								?>
							</td>
							<td width="150" valign="bottom"><?php 
								echo $infantCost = convert_to_base($finalQuoteMealPlan['currencyValue'],$baseCurrencyVal,$finalQuoteMealPlan['infantCost']); 
								//echo getCostWithGSTID_Markup($infantCost,$finalQuoteMealPlan['gstTax'],$finalQuoteMealPlan['markupCost'],$finalQuoteMealPlan['markupType']);
								?>
							</td>

							<td align="right" valign="bottom"> <span class="style1">
								<?php 
								echo $totalServiceCost = round(($adultCost*$finalQuoteMealPlan['adultPax'])+($childCost*$finalQuoteMealPlan['childPax'])+($infantCost*$finalQuoteMealPlan['infantPax'])); 
								// ESCORT CAL .
								if($paxAdultLE>0 || $paxAdultFE>0){					
									$totalServiceCostLE = ($adultCost*$paxAdultLE);
									$totalServiceCostFE = ($adultCost*$paxAdultFE);
									echo "+".round($totalServiceCostLE+$totalServiceCostFE);
									$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost+$totalServiceCostLE+$totalServiceCostFE; 
								}else{
									$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
								}
								
								//without GST and WOMarkup
								?></span>					
							</td> 
							<td width="180" align="right" valign="bottom"> <span><?php echo round($totalServiceCost+$totalServiceCostLE+$totalServiceCostFE); ?></span></td> 
						</tr>
						</table>
						</div> 
						<?php 
					}  
				} 

				$select=''; 
				$where=''; 
				$additionalQuery='';   
				$additionalQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
				if(mysqli_num_rows($additionalQuery) > 0){
				 
					while($finalQuoteadditionalD=mysqli_fetch_array($additionalQuery)){
					
						$additionalDates = date('d M, Y',strtotime($finalQuoteadditionalD['fromDate'])); 
						$groupCost = $finalQuoteadditionalD['groupCost'];
						$c=GetPageRecord('*','extraQuotation','id="'.$finalQuoteadditionalD['additionalId'].'"'); 
						$additionalData=mysqli_fetch_array($c);	 

						$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Additional - <?php  echo strip($additionalData['name']);  ?> - <?php  echo $additionalDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
							<?php if($finalQuoteadditionalD['groupCost'] > 0 ){ ?>
							<td  width="150" align="left" style="color:#666666; font-size:13px;">Group&nbsp;Cost</td> 
							<?php }else{ ?>
							<td  width="150" align="left" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td> 
							<td  width="150" align="left" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td> 
							<td  width="150" align="left" style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td> 
							<?php } ?>	
							<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost<?php if($paxAdultFE>0){ ?>(Guest + Escort)<?php } ?></td> 
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>
						<tr> 
							<?php if($finalQuoteadditionalD['groupCost'] > 0 ){ ?>
							<td width="150" valign="bottom"><?php 
								$groupCost = convert_to_base($finalQuoteadditionalD['currencyValue'],$baseCurrencyVal,$finalQuoteadditionalD['groupCost']); 
								echo $groupCost;// = getCostWithGSTID_Markup($groupCost,$finalQuoteadditionalD['gstTax'],$finalQuoteadditionalD['markupCost'],$finalQuoteadditionalD['markupType']);
								// echo 'x'.($finalQuoteadditionalD['adultPax']+$finalQuoteadditionalD['childPax']+$finalQuoteadditionalD['infantPax']);
								?>
							</td>
							<td align="right" valign="bottom"> <span class="style1">
								<?php 
								echo $totalServiceCost = ($groupCost); 
								$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
								?></span>					
							</td>
							<?php }else{ ?>
							<td width="150" valign="bottom"><?php 
								echo $adultCost = convert_to_base($finalQuoteadditionalD['currencyValue'],$baseCurrencyVal,$finalQuoteadditionalD['adultCost']); 
								//echo $adultCost = getCostWithGSTID_Markup($adultCost,$finalQuoteadditionalD['gstTax'],$finalQuoteadditionalD['markupCost'],$finalQuoteadditionalD['markupType']);

								echo 'x'.$finalQuoteadditionalD['adultPax'];
								?>
							</td>
							<td width="150" valign="bottom"><?php 
								echo $childCost = convert_to_base($finalQuoteadditionalD['currencyValue'],$baseCurrencyVal,$finalQuoteadditionalD['childCost']); 
								//echo getCostWithGSTID_Markup($childCost,$finalQuoteadditionalD['gstTax'],$finalQuoteadditionalD['markupCost'],$finalQuoteadditionalD['markupType']);
								echo 'x'.$finalQuoteadditionalD['childPax'];

								?>
							</td>
							<td width="150" valign="bottom"><?php 
								echo $infantCost = convert_to_base($finalQuoteadditionalD['currencyValue'],$baseCurrencyVal,$finalQuoteadditionalD['infantCost']); 
								//echo getCostWithGSTID_Markup($infantCost,$finalQuoteadditionalD['gstTax'],$finalQuoteadditionalD['markupCost'],$finalQuoteadditionalD['markupType']);
								echo 'x'.$finalQuoteadditionalD['infantPax'];
								?>
							</td>
							<td align="right" valign="bottom"> <span class="style1">
								<?php 
								echo $totalServiceCost = ($adultCost*$finalQuoteadditionalD['adultPax'])+($childCost*$finalQuoteadditionalD['childPax'])+($infantCost*$finalQuoteadditionalD['infantPax']); 
									
								if($paxAdultLE>0 || $paxAdultFE>0){					
									$totalServiceCostLE = ($adultCost*$paxAdultLE);
									$totalServiceCostFE = ($adultCost*$paxAdultFE);
									echo "+".round($totalServiceCostLE+$totalServiceCostFE);
									$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost+$totalServiceCostLE+$totalServiceCostFE; 
								}else{
									$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
								}
								?>
								</span>					
							</td>
							<?php } ?> 
							<td width="180" align="right" valign="bottom"><span><?php echo round($totalServiceCost+$totalServiceCostLE+$totalServiceCostFE); ?></span></td> 
						</tr>
						</table>
						</div> 
						<?php 
					}  
				} 

				$select=''; 
				$where=''; 
				$enrouteQuery='';   
				$enrouteQuery=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
				if(mysqli_num_rows($enrouteQuery) > 0){
					
					while($finalQuoteEnroute=mysqli_fetch_array($enrouteQuery)){
					
						$enrouteDates = date('d M, Y',strtotime($finalQuoteEnroute['fromDate'])); 
						
						$c=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id="'.$finalQuoteEnroute['enrouteId'].'"'); 
						$enrouteData=mysqli_fetch_array($c);	

						$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Enroute - <?php  echo strip($enrouteData['enrouteName']);  ?> - <?php  echo $enrouteDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
						<td width="150" style="color:#666666; font-size:13px;">Per&nbsp;Pax&nbsp;Cost</td>
						<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost<?php if($paxAdultFE>0){ ?>(Guest + Escort)<?php } ?></td> 
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>
						<tr>
						<td valign="bottom"><?php  
							echo $adultCost = convert_to_base($finalQuoteEnroute['currencyValue'],$baseCurrencyVal,$finalQuoteEnroute['adultCost']);  
							  ?>
						</td>
						<td align="right" valign="bottom"> <span class="style1">
							<?php 
							echo $totalServiceCost = round($adultCost*$totalPax); 
							// ESCORT CAL .
							$totalServiceCostLE = ($adultCost*$paxAdultLE);
							$totalServiceCostFE = ($adultCost*$paxAdultFE);

							echo "+".round($totalServiceCostLE+$totalServiceCostFE);
							$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost+$totalServiceCostLE+$totalServiceCostFE; 
							//without GST and WOMarkup
							?></span>					
						</td> 
						<td width="180" align="right" valign="bottom"> <span><?php echo round($totalServiceCost+$totalServiceCostLE+$totalServiceCostFE); ?></span></td> 
						</tr>
						</table>
						</div> 
						<?php 
					}  
				} 
				
				$select=''; 
				$where=''; 
				$guideQuery='';   
				$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'" and serviceType=0 and supplierId = "'.$supplierStatusData['supplierId'].'"  order by fromDate asc '); 
				if(mysqli_num_rows($guideQuery) > 0){ 
					while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){

						$ddd3 = "";
			            $ddd3 = GetPageRecord('*', 'dmcGuidePorterRate', ' id="'.$finalQuoteGuides['tariffId'].'"');
			            $guideSlabList = mysqli_fetch_array($ddd3);
			            // get the right rate 
			            $paxRangeArr = explode('_', $guideSlabList['paxRange']);
			            $fromRange = $paxRangeArr[0];
			            $toRange = $paxRangeArr[1];
			            // print_r($paxRangeArr);
			            if($fromRange <= $dfactor  && $dfactor  <= $toRange){
			                $adultCost = convert_to_base($finalQuoteGuides['currencyValue'],$baseCurrencyVal,trim($finalQuoteGuides['adultCost']));
			            }
			            if($guideSlabList['paxRange'] == 0){
			                $adultCost = convert_to_base($finalQuoteGuides['currencyValue'],$baseCurrencyVal,trim($finalQuoteGuides['adultCost']));
			            }

						if(strtotime($finalQuoteGuides['fromDate']) == strtotime($finalQuoteGuides['toDate'])){ 
							$guideDates = date('d M, Y',strtotime($finalQuoteGuides['fromDate'])); 
						}else{
							$guideDates = date('d',strtotime($finalQuoteGuides['fromDate']))."-".date('d M, Y',strtotime($finalQuoteGuides['toDate']));
						}

						$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
						$guideData=mysqli_fetch_array($c);	 

						$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 
						
						
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Guide - <?php echo strip($guideData['name']);  ?> - <?php  echo $guideDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
						<td width="150" style="color:#666666; font-size:13px;">Service&nbsp;Cost</td>
						<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost<?php if($paxAdultFE>0){ ?>(Guest + Escort)<?php } ?></td> 
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>
						<tr>
							<td valign="bottom"><?php   
								echo round($adultCost);
								?>
							</td>
							<td align="right" valign="bottom"> <span class="style1">
								<?php
					 			echo $totalServiceCost = round($adultCost); 
								$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
									//without GST and WOMarkup
								?></span>					
							</td> 
							<td width="180" align="right" valign="bottom"> <span><?php echo round($totalServiceCost); ?></span></td>  
						</tr>
						</table>
						</div> 
						<?php 
					}
				}

				$select=''; 
				$where=''; 
				$guideQuery='';   
				$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'" and serviceType=1 and supplierId = "'.$supplierStatusData['supplierId'].'"  order by fromDate asc '); 
				if(mysqli_num_rows($guideQuery) > 0){ 
					while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){

						
			            $adultCost = convert_to_base($finalQuoteGuides['currencyValue'],$baseCurrencyVal,trim($finalQuoteGuides['adultCost']));

						if(strtotime($finalQuoteGuides['fromDate']) == strtotime($finalQuoteGuides['toDate'])){ 
							$guideDates = date('d M, Y',strtotime($finalQuoteGuides['fromDate'])); 
						}else{
							$guideDates = date('d',strtotime($finalQuoteGuides['fromDate']))."-".date('d M, Y',strtotime($finalQuoteGuides['toDate']));
						}

						$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
						$guideData=mysqli_fetch_array($c);	 

						$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 
						
						
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Porter - <?php echo strip($guideData['name']);  ?> - <?php  echo $guideDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
						<td width="150" style="color:#666666; font-size:13px;">Service&nbsp;Cost</td>
						<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost<?php if($paxAdultFE>0){ ?>(Guest + Escort)<?php } ?></td> 
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>
						<tr>
							<td valign="bottom"><?php   
								echo round($adultCost);
								?>
							</td>
							<td align="right" valign="bottom"> <span class="style1">
								<?php
					 			echo $totalServiceCost = round($adultCost*($totalPax+$paxAdultLE+$paxAdultFE)); 
								$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
									//without GST and WOMarkup
								?></span>					
							</td> 
							<td width="180" align="right" valign="bottom"> <span><?php echo round($totalServiceCost); ?></span></td>  
						</tr>
						</table>
						</div> 
						<?php 
					}
				}
			}else{
				$select=''; 
				$where=''; 
				$fpackQuery='';   
				// echo ' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" ';
				$fpackQuery=GetPageRecord('*','finalPackWiseRateMaster',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" '); 
				if(mysqli_num_rows($fpackQuery) > 0){
				 
					while($fpwmData=mysqli_fetch_array($fpackQuery)){

						$fquoQuery=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$fpwmData['quotationId'].'"'); 
						$fpQuotationData=mysqli_fetch_array($fquoQuery);	 
						if($fpwmData['serviceType']==1){
							$singleRoom = $fpQuotationData['sglRoom'];
							$doubleRoom = $fpQuotationData['dblRoom'];
							$twinRoom   = $fpQuotationData['twinRoom'];
							$tripleRoom = $fpQuotationData['tplRoom'];
							$quadBedRoom = $fpQuotationData['quadNoofRoom'];
							$sixBedRoom = $fpQuotationData['sixNoofBedRoom'];
							$eightBedRoom = $fpQuotationData['eightNoofBedRoom'];
							$tenBedRoom = $fpQuotationData['tenNoofBedRoom'];
							$teenBedRoom = $fpQuotationData['teenNoofRoom'];
							$EBedChild = $fpQuotationData['childwithNoofBed'];
							$NBedChild = $fpQuotationData['childwithoutNoofBed'];
							$EBedAdult = $fpQuotationData['extraNoofBed'];
							$sixNoofBed = $fpQuotationData['sixNoofBedRoom'];
							$eightNoofBed = $fpQuotationData['eightNoofBedRoom'];
							$tenNoofBed = $fpQuotationData['tenNoofBedRoom'];
							$teenNoofBed = $fpQuotationData['teenNoofRoom'];
							$quadNoofBed = $fpQuotationData['quadNoofRoom'];
							$infantNoofBed = $fpQuotationData['infant'];

							$singleBasis = clean($fpwmData['singleBasis']);
							$doubleBasis = clean($fpwmData['doubleBasis']);
							$twinBasis = clean($fpwmData['twinBasis']);
							$tripleBasis = clean($fpwmData['tripleBasis']); 
							$quadBasis = clean($fpwmData['quadBasis']);
							$sixBedBasis = clean($fpwmData['sixBedBasis']);
							$eightBedBasis = clean($fpwmData['eightBedBasis']);
							$tenBedBasis = clean($fpwmData['tenBedBasis']);
							$extraBedABasis = clean($fpwmData['extraBedABasis']);
							$childwithbedBasis = clean($fpwmData['childwithbedBasis']);
							$childwithoutbedBasis = clean($fpwmData['childwithoutbedBasis']);
							$infantBedBasis = clean($fpwmData['infantBedBasis']);
							$teenBedBasis = clean($fpwmData['teenBedBasis']);

						$packageDates = date('d',strtotime($fpQuotationData['fromDate']))."-".date('d M, Y',strtotime($fpQuotationData['toDate']));
						$groupCostPKG=0;
							$adultCostPKG=0;
							$childCostPKG=0;
							$infantCostPKG=0;
						}

						if($fpwmData['serviceType']==2 && $fpwmData['costTypeId']==1){
							$adultCostPKG = clean($fpwmData['adultCost']);
							$childCostPKG = clean($fpwmData['childCost']);
							$infantCostPKG = clean($fpwmData['infantCost']);
							$adultPaxPKG = clean($fpwmData['adultPax']);
							$childPaxPKG = clean($fpwmData['childPax']);
							$infantPaxPKG = clean($fpwmData['infantPax']);
							$groupCostPKG=0;
						}

						if($fpwmData['serviceType']==2 && $fpwmData['costTypeId']==2){
							$groupCostPKG = clean($fpwmData['groupCost']);
							$adultCostPKG=0;
							$childCostPKG=0;
							$infantCostPKG=0;
						}

						$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 
						$totalServiceCost = ($singleBasis*$singleRoom)+($doubleBasis*$doubleRoom*2)+($twinBasis*$twinRoom*2)+($tripleBasis*$tripleRoom*3)+($quadBasis*$quadBedRoom*4)+($extraBedABasis*$EBedAdult)+($childwithbedBasis*$EBedChild)+($childwithoutbedBasis*$NBedChild)+($infantBedBasis*$infantNoofBed)+($adultCostPKG*$adultPaxPKG)+($childCostPKG*$childPaxPKG)+($infantCostPKG*$infantPaxPKG)+($groupCostPKG);
						?> 
						<div class="contentin">
						<div class="inheader"><i class="fa fa-building"></i>Package:<?php echo ucfirst($fpQuotationData['quotationSubject']);  ?> - <?php  echo $fpwmData['serviceName'];  ?>  <?php  //echo $packageDates;  ?> </div>
						<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
						<tr>
						<td width="150" style="color:#666666; font-size:13px;">Package&nbsp;Cost</td>
						<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
						</tr>
						<tr>
						<td valign="bottom"><?php  echo $totalServiceCost ?>
						</td>
						<td width="180" align="right" valign="bottom"> 
							<?php 
							//withGST and WOMarkup						
							$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCostLE + $totalServiceCostFE+$totalServiceCost; 
							//without GST and WOMarkup
							?><span><?php echo round($totalServiceCostLE + $totalServiceCostFE + $totalServiceCost); ?></span></td> 
						</tr>
						</table>
						</div> 
						<?php   
					}
				} 
			}

			// transfer service start 

			$select=''; 
			$where=''; 
			$transferQuery='';    
			$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and isTransferTaken="yes" order by fromDate asc '); 
			if(mysqli_num_rows($transferQuery) > 0){
				while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
 
				if(strtotime($finalQuoteTransfer['fromDate']) == strtotime($finalQuoteTransfer['toDate'])){ 
					$transferDates = date('d M, Y',strtotime($finalQuoteTransfer['fromDate'])); 
				}else{ 
					$transferDates = date('d',strtotime($finalQuoteTransfer['fromDate']))."-".date('d M, Y',strtotime($finalQuoteTransfer['toDate']));
				} 	
				
				$c="";  
				$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTransfer['transferId'].'"'); 
				$transferData=mysqli_fetch_array($c);
				
				$d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteTransfer['vehicleModelId'].'"'); 
				$vehicleData=mysqli_fetch_array($d);
				
				//check if supplier is self
				$vehicleName = $vehicleType = $transferType = '';
				$transportCostC = $adultTransferCostC = $childTransferCostC = $vehicleCostC = $distanceC = 0;
				if($finalQuoteTransfer['transferType'] == 1){ 
			        $adultTransferCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['adultCost']));
			        $childTransferCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['childCost']));
			        $infantTransferCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['infantCost']));
			        $repCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['repCost']));

			        $transportCostC = ($adultTransferCostC*$paxAdult)+($childTransferCostC*$paxChild)+($infantTransferCostC*$paxInfant)+($repCostC*$totalPax);
			    }else{ 

					if ($finalQuoteTransfer['costType'] == 3) {
				        $distanceC = ($finalQuoteTransfer['distance']);
					}

			        $vehicleCostC = convert_to_base($finalQuoteTransfer['currencyValue'],$baseCurrencyVal,trim($finalQuoteTransfer['vehicleCost']));
			        $transportCostC = ($vehicleCostC*$finalQuoteTransfer['noOfVehicles']*$distanceC);

			        $vehicleName = $vehicleData['model']." | ";
			        $vehicleType = getVehicleTypeName($vehicleData['carType'])." | ";
			    } 
				$transferType = ($finalQuoteTransfer['transferType'] == 1)?'SIC':'Private';
				$totalServiceCost = 0; 


				$totalServiceCost = $transportCostC;
				$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 

				?>
				<div class="contentin">
					<div class="inheader"><i class="fa fa-building"></i>Transport - <?php  echo strip($transferData['transferName']);  ?> - <?php  echo $transferDates;  ?> </div>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
					<tr>
						<td width="150" style="color:#666666; font-size:13px;">Transfer&nbsp;Type</td>
						<?php if($finalQuoteTransfer['transferType'] == 1){  ?>
						<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
						<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
						<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td>
						<td width="150" style="color:#666666; font-size:13px;">Rep.&nbsp;Cost</td>
						<?php }else{ ?>
						<!-- <td  style="color:#666666; font-size:13px;">Vehicle&nbsp;Name</td> -->
						<td width="150" style="color:#666666; font-size:13px;">
							<!-- Vehicle&nbsp;Cost -->
							<?php if($finalQuoteTransfer['costType'] == 3){ echo 'Per KM Cost'; }else{ echo 'Vehicle Cost'; }  ?>
						</td>
						<?php } ?>
						<td width="100" align="right">Total&nbsp;Service&nbsp;Cost</td>
						<td width="100" align="right" valign="bottom"> Cost&nbsp;to&nbsp;Company </td>
					</tr>
					<tr>
						<td valign="bottom"><?php echo $transferType; ?></td>
						<?php if($finalQuoteTransfer['transferType'] == 1){  ?>
						<td width="150" style="color:#666666; font-size:13px;"><?php echo round($adultTransferCostC).' X '.$paxAdult; ?></td>
						<td width="150" style="color:#666666; font-size:13px;"><?php echo round($childTransferCostC).' X '.$paxChild; ?></td>
						<td width="150" style="color:#666666; font-size:13px;"><?php echo round($infantTransferCostC).' X '.$paxInfant; ?></td>
						<td width="150" style="color:#666666; font-size:13px;"><?php echo round($repCostC).' X '.$totalPax; ?></td>
						<?php }else{ ?>
							<!-- <td valign="bottom"><?php echo $vehicleName.$vehicleType.' for '.$finalQuoteTransfer['noOfVehicles']." Vehicle"; ?></td> -->
							<td width="150" style="color:#666666; font-size:13px;">
								<?php 
								if($finalQuoteTransfer['costType'] == 3){ 
									echo round($vehicleCostC).' X '.$finalQuoteTransfer['noOfVehicles'].' Vehicle X '.$finalQuoteTransfer['distance'].' KM';  
								}else{ 
									echo round($vehicleCostC).' X '.$finalQuoteTransfer['noOfVehicles']; 
								}  ?>
							</td>
						<?php } ?>

						<td width="150" align="right"  style="color:#666666; font-size:13px;"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
						<td width="150" align="right"  style="color:#666666; font-size:13px;"><?php echo getTwoDecimalNumberFormat($totalServiceCost); ?></td>
					</tr>
					</table>
				</div>
				<?php
				}
			}
			

			// transfer service end
				
			$select=''; 
			$where=''; 
			$flightQuery='';   
			$flightQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'"  order by fromDate asc '); 
			if(mysqli_num_rows($flightQuery) > 0){
			 
				while($finalQuoteFlights=mysqli_fetch_array($flightQuery)){
					if( ($finalQuoteFlights['isForeignEscort']==1 && $paxAdultFE>0) || ( $finalQuoteFlights['isLocalEscort']==1 && $paxAdultLE>0) ||  $finalQuoteFlights['isGuestType']==1 ){
					$flightTypeLable ="";
					if($finalQuoteFlights['isLocalEscort']==1){
				        $flightTypeLable .= "Local Escort,";
				    }
				    if($finalQuoteFlights['isForeignEscort']==1){
				        $flightTypeLable .= "Foreign Escort,";
				    }
				    if($finalQuoteFlights['isGuestType']==1){
				        $flightTypeLable .= "Guest,";
				    }
					if(strtotime($finalQuoteFlights['fromDate']) == strtotime($finalQuoteFlights['toDate'])){ 
						$flightDates = date('d M, Y',strtotime($finalQuoteFlights['fromDate'])); 
					}else{
						$flightDates = date('d',strtotime($finalQuoteFlights['fromDate']))."-".date('d M, Y',strtotime($finalQuoteFlights['toDate']));
					} 
						
					$c=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightId'].'"'); 
					$flightData=mysqli_fetch_array($c);	 

					$totalServiceCost = $totalServiceCostLE = $totalServiceCostFE = 0; 


					?> 
					<div class="contentin">
					<div class="inheader"><i class="fa fa-building"></i><?php echo rtrim($flightTypeLable,',')." Flight: ";  echo ucfirst($flightData['flightName']);  ?> - <?php  echo $flightDates;  ?> </div>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
					<tr>
					<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td>
					<?php if($finalQuoteFlights['isLocalEscort']==1){ ?>
					<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost( Local )</td>
					<?php }if($finalQuoteFlights['isForeignEscort']==1){ ?>
					<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost( Foreign )</td>
					<?php } if($finalQuoteFlights['isGuestType']==1){ ?>
					<td  align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost( Guest)</td>
					<?php } ?> 
					<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
					</tr>
					<tr>
					<td valign="bottom"><?php 
						$adultCost = convert_to_base($finalQuoteFlights['currencyValue'],$baseCurrencyVal,($finalQuoteFlights['adultCost']+$finalQuoteFlights['adultTax']));
						echo $adultCost = $adultCost; 
						echo 'x'.$paxAdult;
						
						?>
					</td>
					<td valign="bottom"><?php 
						$childCost = convert_to_base($finalQuoteFlights['currencyValue'],$baseCurrencyVal,($finalQuoteFlights['childCost']+$finalQuoteFlights['childTax']));
						echo $childCost = $childCost; 
						echo 'x'.$paxChild;
						?>
					</td>
					<td valign="bottom"><?php 
						$infantCost = convert_to_base($finalQuoteFlights['currencyValue'],$baseCurrencyVal,($finalQuoteFlights['infantCost']+$finalQuoteFlights['infantTax']));  
						echo $infantCost = $infantCost; 
						echo 'x'.$paxInfant;
						?>
					</td>

					<?php if($finalQuoteFlights['isLocalEscort']==1){ ?>
					<td align="right" valign="bottom"> <span class="style1">
						<?php 
						echo $totalServiceCostLE = round($adultCost*$paxAdultLE); 
						?></span>					
					</td>
					<?php }if($finalQuoteFlights['isForeignEscort']==1){ ?>
					<td align="right" valign="bottom"> <span class="style1">
						<?php 
						echo $totalServiceCostFE = round(($adultCost)*($paxAdultFE)); 
						?></span>					
					</td>
					<?php } if($finalQuoteFlights['isGuestType']==1){ ?>
					<td align="right" valign="bottom"> <span class="style1">
						<?php 
						echo $totalServiceCost = round($adultCost*$paxAdult)+($childCost*$paxChild)+($infantCost*$paxInfant); 
						?></span>					
					</td>
					<?php } ?>

					<td width="180" align="right" valign="bottom"> 
						<?php 
						//withGST and WOMarkup						
						$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + ($totalServiceCostLE + $totalServiceCostFE + $totalServiceCost); 
						//without GST and WOMarkup
						?><span><?php echo round($totalServiceCostLE + $totalServiceCostFE + $totalServiceCost); ?></span></td> 
					</tr>
					</table>
					</div> 
					<?php 
					}  
				}
			} 

			

			$select=''; 
			$where=''; 
			$visaQuery='';   
			$visaQuery=GetPageRecord('*','finalQuoteVisa',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
			if(mysqli_num_rows($visaQuery) > 0){
	
				while($finalQuoteVisa=mysqli_fetch_array($visaQuery)){
					
					if(strtotime($finalQuoteVisa['fromDate']) == strtotime($finalQuoteVisa['toDate'])){ 
						$visaDates = date('d M, Y',strtotime($finalQuoteVisa['fromDate'])); 
					}else{
						$visaDates = date('d',strtotime($finalQuoteVisa['fromDate']))."-".date('d M, Y',strtotime($finalQuoteVisa['toDate']));
					} 
				
					$totalServiceCost = $totalServiceCostVI=$totalServiceCostVC=$totalServiceCostVA=$totalVAdult
					=$totalVChild=$totalVInfant=0;

					$visaAdultPax = $finalQuoteVisa['adultPax'];
                    $visaChildPax = $finalQuoteVisa['childPax'];
                    $visaInfantPax = $finalQuoteVisa['infantPax'];

					?> 
					<div class="contentin">
					<div class="inheader"><i class="fa fa-building"></i><?php echo 'VISA : ';  echo ucfirst($finalQuoteVisa['name']);  ?> - <?php  echo $visaDates;  ?> </div>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
					<tr>
					<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td>
					<td width="180" align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost</td>
					
					<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
					</tr>
					<tr>
					<td valign="bottom"><?php 

						$purchaseVisaA=$finalQuoteVisa['adultCost']+$finalQuoteVisa['vfsCharges']+$finalQuoteVisa['embassyFee'];        
						$purchaseVisaC=$finalQuoteVisa['childCost']+$finalQuoteVisa['vfsCharges']+$finalQuoteVisa['embassyFee'];        
						$purchaseVisaE=$finalQuoteVisa['infantCost']+$finalQuoteVisa['vfsCharges']+$finalQuoteVisa['embassyFee'];   
						                 
						echo $VadultCost = convert_to_base($finalQuoteVisa['currencyValue'],$baseCurrencyVal,$purchaseVisaA); ?>&nbsp;<?php if($visaAdultPax>0){ echo 'x&nbsp;'.$visaAdultPax; } ?>
					</td>
					<td valign="bottom"><?php 
						echo $VchildCost = convert_to_base($finalQuoteVisa['currencyValue'],$baseCurrencyVal,$purchaseVisaC); ?>&nbsp;<?php if($visaChildPax>0){ echo 'x&nbsp;'.$visaChildPax; } ?>
					</td>
					<td valign="bottom"><?php 
						echo $VinfantCost = convert_to_base($finalQuoteVisa['currencyValue'],$baseCurrencyVal,$purchaseVisaE); ?>&nbsp;<?php if($visaInfantPax>0){ echo 'x&nbsp;'.$visaInfantPax; } ?>
					</td>
					<td width="180" align="right" valign="bottom">
					<?php 
						$totalVAdult = $VadultCost*$visaAdultPax;
						$totalVChild = $VchildCost*$visaChildPax;
						$totalVInfant = $VinfantCost*$visaInfantPax;

						$totalServiceCostVA = $totalServiceCostVA + $totalVAdult;
						$totalServiceCostVC = $totalServiceCostVC + $totalVChild;
						$totalServiceCostVI = $totalServiceCostVI + $totalVInfant;
						$totalServiceCost = $totalServiceCostVI+$totalServiceCostVC+$totalServiceCostVA;
						//withGST and WOMarkup						
						$supplierCompanyCostWOGST = $supplierCompanyCostWOGST + $totalServiceCost; 
						//without GST and WOMarkup
						echo round($totalServiceCost);
						?>
					</td>
					<td width="180" align="right" valign="bottom"> 
					<span><?php echo round($totalServiceCost); ?></span></td> 
					</tr>
					</table>
					</div> 
					<?php 
					//}  
				}
			} 

			$select=''; 
			$where=''; 
			$passportQuery='';   
			$passportQuery=GetPageRecord('*','finalQuotePassport',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
			if(mysqli_num_rows($passportQuery) > 0){
			 
				while($finalQuotePassport=mysqli_fetch_array($passportQuery)){
					
					if(strtotime($finalQuotePassport['fromDate']) == strtotime($finalQuotePassport['toDate'])){ 
						$passportDates = date('d M, Y',strtotime($finalQuotePassport['fromDate'])); 
					}else{
						$passportDates = date('d',strtotime($finalQuotePassport['fromDate']))."-".date('d M, Y',strtotime($finalQuotePassport['toDate']));
					} 
					$Padultpax = $finalQuotePassport['adultPax'];
					$PinfantPax = $finalQuotePassport['infantPax'];
					$PchildPax = $finalQuotePassport['childPax'];
					// $c=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['visaNameId'].'"'); 
					// $flightData=mysqli_fetch_array($c);	 

					$totalServiceCost = $totalServiceCostPA=$totalServiceCostPC=$totalServiceCostPI=$totalPAdult
					=$totalPChild=$totalPInfant=$PadultCost=$PchildCost=$PinfantCost=0;


					?> 
					<div class="contentin">
					<div class="inheader"><i class="fa fa-building"></i><?php echo 'Passport : ';  echo ucfirst($finalQuotePassport['name']);  ?> - <?php  echo $passportDates;  ?> </div>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
					<tr>
					<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td>
					<td width="180" align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost</td>
					
					<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
					</tr>
					<tr>
					<td valign="bottom"><?php 
						echo $PadultCost = convert_to_base($finalQuotePassport['currencyValue'],$baseCurrencyVal,$finalQuotePassport['adultCost']); ?>&nbsp;<?php if($Padultpax>0){ echo 'x&nbsp;'.$Padultpax; } ?>
						
					</td>
					<td valign="bottom"><?php 
						echo $PchildCost = convert_to_base($finalQuotePassport['currencyValue'],$baseCurrencyVal,$finalQuotePassport['childCost']); ?>&nbsp;<?php if($PchildPax>0){ echo 'x&nbsp;'.$PchildPax; } ?>
					</td>
					<td valign="bottom"><?php 
						echo $PinfantCost = convert_to_base($finalQuotePassport['currencyValue'],$baseCurrencyVal,$finalQuotePassport['infantCost']); ?>&nbsp;<?php if($PinfantPax>0){ echo 'x&nbsp;'.$PinfantPax; } ?>
					</td>
					<td width="180" align="right" valign="bottom">
					<?php 
						$totalPAdult = $PadultCost*$Padultpax;
						$totalPChild = $PchildCost*$PchildPax;
						$totalPInfant = $PinfantCost*$PinfantPax;

						$totalServiceCostPA = $totalServiceCostPA + $totalPAdult;
						$totalServiceCostPC = $totalServiceCostPC + $totalPChild;
						$totalServiceCostPI = $totalServiceCostPI + $totalPInfant;
						$totalServiceCost = $totalServiceCostPA+$totalServiceCostPC+$totalServiceCostPI;
						//withGST and WOMarkup						
						$supplierCompanyCostWOGST = $supplierCompanyCostWOGST+ $totalServiceCost; 
						//without GST and WOMarkup
						echo round($totalServiceCost);
						?>
					</td>
					<td width="180" align="right" valign="bottom"> 
					<span><?php echo round($totalServiceCost); ?></span></td> 
					</tr>
					</table>
					</div> 
					<?php 
					//}  
				}
			} 

			$select=''; 
			$where=''; 
			$insuranceQuery='';   
			$insuranceQuery=GetPageRecord('*','finalQuoteInsurance',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
			if(mysqli_num_rows($insuranceQuery) > 0){
			 
				while($finalQuoteInsurance=mysqli_fetch_array($insuranceQuery)){
					
					if(strtotime($finalQuoteInsurance['fromDate']) == strtotime($finalQuoteInsurance['toDate'])){ 
						$insuranceDates = date('d M, Y',strtotime($finalQuoteInsurance['fromDate'])); 
					}else{
						$insuranceDates = date('d',strtotime($finalQuoteInsurance['fromDate']))."-".date('d M, Y',strtotime($finalQuoteInsurance['toDate']));
					} 

					$totalServiceCost = $totalServiceCostIA=$totalServiceCostIC=$totalServiceCostII=$totalIAdult
					=$totalIChild=$totalIInfant=$IadultCost=$IchildCost=$IinfantCost=0;


					?> 
					<div class="contentin">
					<div class="inheader"><i class="fa fa-building"></i><?php echo 'Insurance : ';  echo ucfirst($finalQuoteInsurance['name']);  ?> - <?php  echo $insuranceDates;  ?> </div>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
					<tr>
					<td width="150" style="color:#666666; font-size:13px;">Adult&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Child&nbsp;Cost</td>
					<td width="150" style="color:#666666; font-size:13px;">Infant&nbsp;Cost</td>
					<td width="180" align="right" style="color:#666666; font-size:13px;">Total&nbsp;Cost</td>
					
					<td width="180" align="right" style="color:#666666; font-size:13px;">Cost&nbsp;to&nbsp;Company</td>
					</tr>
					<tr>
					<td valign="bottom"><?php 
						echo $IadultCost = convert_to_base($finalQuoteInsurance['currencyValue'],$baseCurrencyVal,$finalQuoteInsurance['adultCost']); ?>&nbsp;<?php if($paxAdult>0){ echo 'x&nbsp;'.$paxAdult; } ?>
						
					</td>
					<td valign="bottom"><?php 
						echo $IchildCost = convert_to_base($finalQuoteInsurance['currencyValue'],$baseCurrencyVal,$finalQuoteInsurance['childCost']); ?>&nbsp;<?php if($paxChild>0){ echo 'x&nbsp;'.$paxChild; } ?>
					</td>
					<td valign="bottom"><?php 
						echo $IinfantCost = convert_to_base($finalQuoteInsurance['currencyValue'],$baseCurrencyVal,$finalQuoteInsurance['infantCost']); ?>&nbsp;<?php if($paxInfant>0){ echo 'x&nbsp;'.$paxInfant; } ?>
					</td>
					<td width="180" align="right" valign="bottom">
					<?php 
						$totalIAdult = $IadultCost*$paxAdult;
						$totalIChild = $IchildCost*$paxChild;
						$totalIInfant = $IinfantCost*$paxInfant;

						$totalServiceCostIA = $totalServiceCostIA + $totalIAdult;
						$totalServiceCostIC = $totalServiceCostIC + $totalIChild;
						$totalServiceCostII = $totalServiceCostII + $totalIInfant;
						$totalServiceCost = $totalServiceCostIA+$totalServiceCostIC+$totalServiceCostII;
						//withGST and WOMarkup						
						$supplierCompanyCostWOGST = $supplierCompanyCostWOGST+ $totalServiceCost; 
						//without GST and WOMarkup
						echo round($totalServiceCost);
						?>
					</td>
					<td width="180" align="right" valign="bottom"> 
					<span><?php echo round($totalServiceCost); ?></span></td> 
					</tr>
					</table>
					</div> 
					<?php 
					//}  
				}
			}
		
			// samaydin 
			$grandCompanyCostWOGST = $grandCompanyCostWOGST + $supplierCompanyCostWOGST;

			//update supplier total cost 
			updatelisting('finalQuotSupplierStatus','totalSupplierCost="'.$supplierCompanyCostWOGST.'"','id="'.$supplierStatusData['id'].'"');

			// Schedule amount of supplier by default 100%
			$r2='';
			$r2=GetPageRecord('id','supplierSchedulePaymentMaster','supplierStatusId="'.$supplierStatusData['id'].'" and amount!="" and value!=""'); 
			if(mysqli_num_rows($r2) == 0){
				$namevalue ='type=1, value=100, paymentType=2, status=1, dueDate="'.date('Y-m-d').'",amount="'.$supplierCompanyCostWOGST.'", supplierStatusId="'.$supplierStatusData['id'].'",quotationId="'.$quotationId.'"';
				$scheduleId = addlistinggetlastid('supplierSchedulePaymentMaster',$namevalue);  
			}
			// pending amount related code
			$r3sd1=GetPageRecord('sum(amount) as totalpaid','supplierPaymentMaster',' supplierStatusId="'.$supplierStatusData['id'].'" and paymentStatus=1 '); 
			$supplierPaymentData = mysqli_fetch_array($r3sd1);
			$paidAMT = $supplierPaymentData['totalpaid'];
			$totalPendingAMT = $supplierCompanyCostWOGST-$paidAMT;
			if($totalSupplierCost >1){ 
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					setGTCost('supplierCost','<?php echo round($supplierCompanyCostWOGST); ?>','#supplierCompanyCostAmt<?php echo($supplierStatusData['id']);?>');
					setGTCost('supplierPen','<?php echo round($totalPendingAMT); ?>','#supplierPendingCostAmt<?php echo($supplierStatusData['id']);?>');
				});
			</script>	
			<?php } ?>
			</div>
			</td>
			</tr>
			</table>
			<?php	
			
		}	
	}
	}

	$grandClientWithGstCost = $quotationData['totalQuotCost'];
	$grandCompanyCostWOGST = $quotationData['totalCompanyCost'];
	// get the total pending for instant showings
	$rs2=GetPageRecord(' sum(amount) AS totalpaid ','supplierPaymentMaster','1 and quotationId="'.$quotationId.'" and paymentStatus=1'); 
	$supplierPaidData=mysqli_fetch_array($rs2); 
	$totalCompanyPaid = $supplierPaidData['totalpaid'];
	$grandPendingCost = getTwoDecimalNumberFormat($grandCompanyCostWOGST-$totalCompanyPaid);

	$totalMargin = $grandClientWithGstCost-$grandCompanyCostWOGST;
	?>
 	<script type="text/javascript">
		jQuery(document).ready(function($){
			// setGTCost('CompanyCost','<?php echo round($grandCompanyCostWOGST); ?>','#totalCompanyCost');
			//setGTCost('pendingCompanyCost','<?php echo $grandPendingCost; ?>','#totalPending');
			// setGTCost('ClientCost','<?php echo round($grandClientWithGstCost); ?>','#totalClientCost');
			// setGTCost('MarginCost','<?php echo round($totalMargin); ?>','#totalMargin');
		});
	</script>	
	<?php
	// $voucherlastid = updatelisting(_QUOTATION_MASTER_,'totalCompanyCost="'.getTwoDecimalNumberFormat($grandCompanyCostWOGST).'",totalMargin="'.getTwoDecimalNumberFormat($totalMargin).'"',' id="'.$_REQUEST['quotationId'].'"');


} 
?>
</div> 

<style type="text/css">

	.boxsupplierpaymentreq {
	background-color: #fff;
	border: 1px #b5cae0 solid; 
	margin: 0px 0px;
	text-align: left; margin-bottom:20px;
	}
	.boxsupplierpaymentreq .header{
	background-color: #a7bed5;
	color: #6f8ba9;
	padding: 15px;
	font-weight: 500;
	text-transform: uppercase;
	border-bottom: 1px #b5cae085 solid; font-size:12px !important;}
	.boxsupplierpaymentreq .contentin{padding:15px;}
	.boxsupplierpaymentreq .inheader {
	border-bottom: 1px #e8e8e8 solid;
	padding-bottom: 15px;
	padding-top: 9px;
	margin-bottom: 10px;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #333333; position:relative;
	}
	.gstInput{
	width: 46px;
	color: black;
	text-align: center;
	padding: 5px 9px 2px 6px!important;
	}
	.serviceActBtn{
	padding: 4px 6px !important;
    margin-left: 10px;
    outline: 0px;
    font-size: 14px;
    border-radius: 3px;
    font-weight: 500;
    cursor: pointer;
    background-color: #f6fafe;
    color: #2c343f;
    border: 2px #ffffff85 solid;
    box-shadow: 1px 1px 2px #607D8B;
	}
	.boxsupplierpaymentreq .inheader .fa{color: #5ad45e; padding-right:10px;}
	.boxsupplierpaymentreq .margiantotalbox{position:absolute; right:0px; font-size:14px; font-weight:normal;}
	.boxsupplierpaymentreq .margiantotalbox span{ color:#009900; font-weight:600;}


	.style2 {font-weight: bold}
	.costBox{
		float: right;
		transform: scale(1.4);
		text-align: left;
		color: #2c343f;
		padding: 3px 8px;
		height: 24px;
		margin-right: 10%;
		font-size: 11px;
		border-radius: 3px;
		/* border: 1px solid; */
		background-color: #f6fafe;
		box-shadow: 1px 1px 2px #607D8B;
	}
	.alignment-ser{
		width: 1157px;
    	overflow-y: auto;
	}
</style> 