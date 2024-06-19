<?php 
$select='*';
$where='id="'.$queryId.'"';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
$queryData=mysqli_fetch_array($rs);

$travelType = $queryData['travelType'];

$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"');
$quotationData=mysqli_fetch_array($rsp);

$serviceTax = $quotationData['serviceTax'];
$quotationId=$quotationData['id'];
$queryId=$quotationData['queryId'];
 
$moduleType = $queryData['moduleType'];
$paxAdult = ($quotationData['adult']);
$paxChild = ($quotationData['child']);
$paxInfant = ($quotationData['infant']);
$totalPax = ($paxAdult + $paxChild + $paxInfant);
if($totalPax == 0){
    $totalPax =  2;
}

$singleRoom = $quotationData['sglRoom'];
$doubleRoom = $quotationData['dblRoom'];
$tripleRoom = $quotationData['tplRoom'];
$twinRoom   = $quotationData['twinRoom'];
$sixNBedRoom = $quotationData['sixNoofBedRoom'];
$eightNBedRoom = $quotationData['eightNoofBedRoom'];
$tenNBedRoom = $quotationData['tenNoofBedRoom'];
$quadNoofRoom = $quotationData['quadNoofRoom'];
$teenNoofRoom = $quotationData['teenNoofRoom'];
$EBedAdult = $quotationData['extraNoofBed'];
$EBedChild = $quotationData['childwithNoofBed'];
$NBedChild = $quotationData['childwithoutNoofBed'];
$onlyTFS = $quotationData['onlyTFS'];

// SLAB AND ESCORT DETAILS
$defaultSlabSql = "";
$dividingFactor = 2;
$defaultSlabSql = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1 ');
if (mysqli_num_rows($defaultSlabSql)>0) {
    $defaultSlabData = mysqli_fetch_array($defaultSlabSql);
    $dividingFactor = $defaultSlabData['dividingFactor'];
    $slabId = $defaultSlabData['id'];
    $paxAdultLE = $defaultSlabData['localEscort'];
    $paxAdultFE = $defaultSlabData['foreignEscort'];
}


	$res11 = GetPageRecord('isProposalCost,isProposalCostPP','proposalSettingMaster','proposalName!=""');
	$isProposalCostD = mysqli_fetch_assoc($res11);

$c12='';
$c12=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationData['id'].'"'); 
$serviceMarkupD = mysqli_fetch_array($c12); 
  
if($isSer_Mark == 1 && $isUni_Mark == 0){
    $hotelM = $serviceMarkupD['hotel'];
    $hotelMarkupType = $serviceMarkupD['hotelMarkupType'];
    $transferM = $serviceMarkupD['transfer'];
    $transferMarkupType = $serviceMarkupD['transferMarkupType'];
    $ferryM = $serviceMarkupD['ferry'];
    $ferryMarkupType = $serviceMarkupD['ferryMarkupType'];
    $trainM = $serviceMarkupD['train'];
    $trainMarkupType = $serviceMarkupD['trainMarkupType'];
    $flightM = $serviceMarkupD['flight'];
    $flightMarkupType = $serviceMarkupD['flightMarkupType'];
    $guideM = $serviceMarkupD['guide'];
    $guideMarkupType = $serviceMarkupD['guideMarkupType'];
    $activityM = $serviceMarkupD['activity'];
    $activityMarkupType = $serviceMarkupD['activityMarkupType'];
    $entranceM = $serviceMarkupD['entrance'];
    $entranceMarkupType = $serviceMarkupD['entranceMarkupType'];
    $restaurantM = $serviceMarkupD['restaurant'];
    $restaurantMarkupType = $serviceMarkupD['restaurantMarkupType'];
    $otherM = $serviceMarkupD['other']; 
    $otherMarkupType = $serviceMarkupD['otherMarkupType']; 
}else{
	$hotelM = $serviceMarkupD['hotel'];
    $hotelMarkupType = $serviceMarkupD['hotelMarkupType'];
    $transferM = $serviceMarkupD['transfer'];
    $transferMarkupType = $serviceMarkupD['transferMarkupType'];
    $ferryM = $serviceMarkupD['ferry'];
    $ferryMarkupType = $serviceMarkupD['ferryMarkupType'];
    $trainM = $serviceMarkupD['train'];
    $trainMarkupType = $serviceMarkupD['trainMarkupType'];
    $flightM = $serviceMarkupD['flight'];
    $flightMarkupType = $serviceMarkupD['flightMarkupType'];
    $guideM = $serviceMarkupD['guide'];
    $guideMarkupType = $serviceMarkupD['guideMarkupType'];
    $activityM = $serviceMarkupD['activity'];
    $activityMarkupType = $serviceMarkupD['activityMarkupType'];
    $entranceM = $serviceMarkupD['entrance'];
    $entranceMarkupType = $serviceMarkupD['entranceMarkupType'];
    $restaurantM = $serviceMarkupD['restaurant'];
    $restaurantMarkupType = $serviceMarkupD['restaurantMarkupType'];
    $otherM = $serviceMarkupD['other']; 
    $otherMarkupType = $serviceMarkupD['otherMarkupType']; 
} 
$isUni_Mark = 1;


if($_REQUEST['parts'] == 'hotelSupplement'){
	$checkSuppRQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$checkSuppRQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationData['id'].'" and isRoomSupplement=1 and hotelQuoteId>0 ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=1 and hotelQuoteId>0');
	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($checkSuppRQuery) > 0){
		?><table width="100%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td  align="left" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px!important;">Hotel/Room Supplement</td></tr></table>
		<table width="100%" border="1" cellpadding="5" cellspacing="0" class="borderedTable"  >
			<tr height="18" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom-color: #fff;">
			<td colspan="6" align="right">Note: All the Cost is per person with inclusive tax  <strong>(In <?php echo getCurrencyName($quotationData['currencyId']); ?>)</strong></td>
			</tr>
			<tr height="18" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-color: #fff;">
			<th width="8%" height="18" align="center" bgcolor="" style="">Day</th>
			<th width="15%" height="18" align="center" bgcolor="" style="">Destination</th>
			<th align="center" bgcolor="" style="">Supplement&nbsp;/ Reduction </th>
			<th width="10%" align="center" bgcolor="" style="">Single</th>
			<th width="10%" align="center" bgcolor="" style="">Double</th>
			<th width="15%" align="center" bgcolor="" style="">Extra&nbsp;Bed<br>(Adult)</th>
			<!-- <th width="15%" align="center" bgcolor="" style="">Extra&nbsp;Bed<br>(Child)</th> -->
			</tr>
			<?php 
			$day2=1;
			
		    $QueryDaysQuery2=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus=0 order by srdate asc');
			while($suppDaysData=mysqli_fetch_array($QueryDaysQuery2)){  
		 		$dayDate2 = date('Y-m-d', strtotime($suppDaysData['srdate']));
				$dayId2 = $suppDaysData['id'];
				$dayNo = '';
				$normalHotelQuery="";
				$normalHotelQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=0 and isGuestType=1 && isRoomSupplement=0 and fromDate="'.$dayDate2.'"');
		 		if(mysqli_num_rows($normalHotelQuery) > 0){

					while($normalQuotData=mysqli_fetch_array($normalHotelQuery)){

						$normalRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$normalQuotData['roomType'].'');
						$normalRoomTypeD=mysqli_fetch_array($normalRoomTypeQuery);
						$normalRoomType = trim($normalRoomTypeD['name']);

						$normalMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$normalQuotData['mealPlan'].'');
						$normalMealPlanD=mysqli_fetch_array($normalMealPlanQuery);
						$normalMealPlan = strtoupper($normalMealPlanD['name']);

						$hotelQuery="";
						$hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$normalQuotData['supplierId'].'" ');
						$hotelData=mysqli_fetch_array($hotelQuery);
						$hotelName = $hotelData['hotelName'];
						
						
						$mainSingle=$mainDouble=$mainEBedA=$mainEBedC=0;

						$mainSingle = ($normalQuotData['singleoccupancy']);
						$mainSingle = getPerPersonBasisCost($mainSingle,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);

						$mainDouble= ($normalQuotData['doubleoccupancy']/2);
						$mainDouble = getPerPersonBasisCost($mainDouble,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);

						$mainEBedA= ($normalQuotData['extraBed']);
						$mainEBedA = getPerPersonBasisCost($mainEBedA,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);

						$mainEBedC= ($normalQuotData['childwithbed']);
						$mainEBedC = getPerPersonBasisCost($mainEBedC,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);

						$checkSuppRQuery="";
						$checkSuppRQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplierId="'.$normalQuotData['supplierId'].'" and isRoomSupplement=1 and isHotelSupplement=0 and hotelQuoteId="'.$normalQuotData['id'].'" ');
						$mainRoomSupp = 0;
						if(mysqli_num_rows($checkSuppRQuery) > 0){

							$mainRoomSupp = 1;
							while($suppRoomData=mysqli_fetch_array($checkSuppRQuery)){

							$suppRoomRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$suppRoomData['roomType'].'');
							$suppRoomRoomTypeD=mysqli_fetch_array($suppRoomRoomTypeQuery);
							$suppRoomRoomType = trim($suppRoomRoomTypeD['name']);

							$suppRoomMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$suppRoomData['mealPlan'].'');
							$suppRoomMealPlanD=mysqli_fetch_array($suppRoomMealPlanQuery);
							$suppRoomMealPlan = strtoupper($suppRoomMealPlanD['name']);

							$mainRoomSingle=$mainRoomDouble=$mainRoomEBedA=0;

							$mainRoomSingle = ($suppRoomData['singleoccupancy']);
							$mainRoomSingle = getPerPersonBasisCost($mainRoomSingle,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
							$mainRoomSingle = $mainRoomSingle-$mainSingle;

							$mainRoomDouble= ($suppRoomData['doubleoccupancy']/2);
							$mainRoomDouble = getPerPersonBasisCost($mainRoomDouble,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
							$mainRoomDouble = $mainRoomDouble-$mainDouble;

							$mainRoomEBedA= ($suppRoomData['extraBed']);
							$mainRoomEBedA = getPerPersonBasisCost($mainRoomEBedA,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
							$mainRoomEBedA = $mainRoomEBedA-$mainEBedA;

							$mainRoomEBedC= ($suppRoomData['childwithbed']);
							$mainRoomEBedC = getPerPersonBasisCost($mainRoomEBedC,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
							$mainRoomEBedC = $mainRoomEBedC-$mainEBedC;

							if($mainRoomSingle > 0 && $mainRoomDouble > 0){
								$red_supp = "Upgrade ";
							}else{
								$red_supp = "Reduction ";
							}

							$dayNo = str_pad($day2, 2, '0', STR_PAD_LEFT); 
							?>
							<tr height="18">
							<td align="center" ><strong>D<?php echo $dayNo; ?></strong></td>
							<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
							<td align="left"><?php echo $suppInfo = $red_supp."for ".$hotelName." '".$suppRoomRoomType."'(".$suppRoomMealPlan.") in place of '".$normalRoomType."'(".$normalMealPlan.") for per night per room."; ?></td>
							<td align="center">
							  <?php  echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomSingle)); ?>
							  </td>
							<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomDouble)); ?></td>
							<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomEBedA)); ?></td>
							<!-- <td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomEBedC)); ?></td> -->
							</tr>
							<?php
							}
						}


						$suppHotelQuery="";
						$suppHotelQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and fromDate="'.$dayDate2.'" and isHotelSupplement=1 and isGuestType=0 and isRoomSupplement=0 and hotelQuoteId="'.$normalQuotData['id'].'" ');
						//group by supplierId order by id asc
						if(mysqli_num_rows($suppHotelQuery) > 0){
							while($suppQuotData=mysqli_fetch_array($suppHotelQuery)){

								$hotelQuery2="";
								$hotelQuery2=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$suppQuotData['supplierId'].'" ');
								$hotelData2=mysqli_fetch_array($hotelQuery2);
								$hotelName2 = $hotelData2['hotelName'];

								$suppQuotRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$suppQuotData['roomType'].'');
								$suppQuotRoomTypeD=mysqli_fetch_array($suppQuotRoomTypeQuery);
								$suppQuotRoomType = trim($suppQuotRoomTypeD['name']);

								$suppQuotMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$suppQuotData['mealPlan'].'');
								$suppQuotMealPlanD=mysqli_fetch_array($suppQuotMealPlanQuery);
								$suppQuotMealPlan = strtoupper($suppQuotMealPlanD['name']);

								$suppQuotSingle=$suppQuotDouble=$suppQuotEBedA=$suppQuotEBedC=0;

								$suppQuotSingle = ($suppQuotData['singleoccupancy']);
								$suppQuotSingle = getPerPersonBasisCost($suppQuotSingle,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
								$suppQuotSingle = $suppQuotSingle-$mainSingle;
								
								$suppQuotDouble= ($suppQuotData['doubleoccupancy']/2);
								$suppQuotDouble = getPerPersonBasisCost($suppQuotDouble,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
								$suppQuotDouble = $suppQuotDouble-$mainDouble;

								$suppQuotEBedA= ($suppQuotData['extraBed']);
								$suppQuotEBedA = getPerPersonBasisCost($suppQuotEBedA,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
								$suppQuotEBedA = $suppQuotEBedA-$mainEBedA;

								$suppQuotEBedC= ($suppQuotData['childwithbed']);
								$suppQuotEBedC = getPerPersonBasisCost($suppQuotEBedC,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
								$suppQuotEBedC = $suppQuotEBedC-$mainEBedC;

								if($suppQuotSingle > 0 && $suppQuotDouble > 0){
									$red_supp = "Upgrade ";
								}else{
									$red_supp = "Reduction ";
								}

								?>
								<tr height="18">
								<td align="center" ><strong>D<?php echo $dayNo; ?></strong></td>
								<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
								<td align="left"><?php echo $suppInfo = $red_supp."for ".$hotelName2." '".$suppQuotRoomType."'(".$suppQuotMealPlan.") in place of ".$hotelName." '".$normalRoomType."'(".$normalMealPlan.") for per night per room."; ?></td>
								<td align="center">
								  <?php
								echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotSingle); ?>
								  </td>
								<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotDouble); ?></td>
								<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotEBedA); ?></td>
								<!-- <td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotEBedC); ?></td> -->
								</tr>
								<?php
								$suppRoomQuery="";
								$suppRoomQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplierId="'.$suppQuotData['supplierId'].'" and dayId="'.$suppDaysData['id'].'" and isRoomSupplement=1 and isHotelSupplement=0 and hotelQuoteId="'.$suppQuotData['id'].'" ');
								if(mysqli_num_rows($suppRoomQuery) > 0){

									while($suppRoomData2=mysqli_fetch_array($suppRoomQuery)){

										$suppRoomRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$suppRoomData2['roomType'].'');
										$suppRoomRoomTypeD=mysqli_fetch_array($suppRoomRoomTypeQuery);
										$suppRoomRoomType = trim($suppRoomRoomTypeD['name']);

										$suppRoomMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$suppRoomData2['mealPlan'].'');
										$suppRoomMealPlanD=mysqli_fetch_array($suppRoomMealPlanQuery);
										$suppRoomMealPlan = strtoupper($suppRoomMealPlanD['name']);

										$suppRoomSingle=$suppRoomDouble=$suppRoomEBedA=$suppRoomEBedC=0;

										$suppRoomSingle = ($suppRoomData2['singleoccupancy']);
										$suppRoomSingle = getPerPersonBasisCost($suppRoomSingle,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
										$suppRoomSingle = $suppRoomSingle-$suppQuotSingle;
										
										$suppRoomDouble= ($suppRoomData2['doubleoccupancy']/2);
										$suppRoomDouble = getPerPersonBasisCost($suppRoomDouble,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
										$suppRoomDouble = $suppRoomDouble-$suppQuotDouble;
										
										$suppRoomEBedA= ($suppRoomData2['extraBed']);
										$suppRoomEBedA = getPerPersonBasisCost($suppRoomEBedA,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
										$suppRoomEBedA = $suppRoomEBedA-$suppQuotEBedA;
											
										$suppRoomEBedC= ($suppRoomData2['childwithbed']);
										$suppRoomEBedC = getPerPersonBasisCost($suppRoomEBedC,$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
										$suppRoomEBedC = $suppRoomEBedC-$suppQuotEBedC;
										
										if($suppRoomSingle > 0 && $suppRoomDouble > 0){
											$red_supp = "Upgrade ";
										}else{
											$red_supp = "Reduction ";
										}
										?>
										<tr height="18">
										<td align="center" ><strong>D<?php echo $dayNo; ?></strong></td>
										<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
										<td align="left"><?php echo $suppInfo = $red_supp."for ".$hotelName2." '".$suppRoomRoomType."'(".$suppRoomMealPlan.") in place of '".$suppQuotRoomType."'(".$suppQuotMealPlan.") for per night per room."; ?></td>

										<td align="center">
										  <?php
										echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomSingle)); ?>
										  </td>
										<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomDouble)); ?></td>
										<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomEBedA)); ?></td>
										<!-- <td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomEBedC)); ?></td> -->
										</tr>
										<?php
									}
								}
							}
						}
					}
				}
				$day2++;
			}
			?>
		</table> 
		<?php 
	} 
}

// Transfer and transporation supplement
if($_REQUEST['parts'] == 'transferSupplement'){
	$checkSuppTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupplement=1 and (serviceType="transfer" or serviceType="transportation")');
	if(mysqli_num_rows($checkSuppTQuery) > 0){
		?>
		<table width="100%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td  align="left" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px!important;">Transport Supplement</td></tr></table>
		<table width="100%" border="1" cellpadding="5" cellspacing="0" class="borderedTable">
			<tr height="18" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom-color: #fff;">
				<td colspan="4" align="right">Note: All the Cost with inclusive tax and markup <strong>(In <?php echo getCurrencyName($quotationData['currencyId']); ?>)</strong></td>
			</tr>
			
			<tr height="18" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-color: #fff;">
				<th width="10%" height="18" align="center" bgcolor="" style="">Day</th>
				<th width="15%" height="18" align="center" bgcolor="" style="">Destination</th>
				<th width="60%" align="left" bgcolor="" style="">Supplement&nbsp;/ Reduction </th>
				<th width="15%" align="right" bgcolor="" style="">Service Cost</th>
			</tr>
			<?php
			$TRFDaysQuery2=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus = 0 order by srdate asc');
			$day2=1;
			while($suppDaysData=mysqli_fetch_array($TRFDaysQuery2)){  
		 		$dayDate2 = date('Y-m-d', strtotime($suppDaysData['srdate']));
				$dayId2 = $suppDaysData['id'];

				$normalTRFQuery="";
				$normalTRFQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupplement=0 and isGuestType=1 and dayId="'.$dayId2.'"');
		 		if(mysqli_num_rows($normalTRFQuery) > 0){

					while($normalQuotData=mysqli_fetch_array($normalTRFQuery)){
			 			
			 			$transferName ='';
						$transportQuery="";
						$transportQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER_,' id="'.$normalQuotData['transferNameId'].'"');
						$transferData=mysqli_fetch_array($transportQuery);
						$transferName = $transferData['transferName'];
						
						$vehicleModelQuery='';
						$vehicleModelQuery=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$normalQuotData['vehicleModelId'].'"');
						$carData=mysqli_fetch_array($vehicleModelQuery);
						$carType = getVehicleTypeName($carData['carType']); 
						$vehicleName = ($carData['model']); 

						$mainTRFCost=0;
						$mainTRFCost = ($normalQuotData['vehicleCost']);
						$mainTRFCost = getPerPersonBasisCost($mainTRFCost,$transferM,$markupType,0,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
			  
						$suppHotelQuery="";
						$suppHotelQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and dayId="'.$dayId2.'" and isSupplement=1 and transferQuoteId="'.$normalQuotData['id'].'" and serviceType="'.$normalQuotData['serviceType'].'" order by id asc');
						if(mysqli_num_rows($suppHotelQuery) > 0){

							$suppQuotData=mysqli_fetch_array($suppHotelQuery);

							$transportQuery2="";
							$transportQuery2=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER_,' id="'.$suppQuotData['transferNameId'].'" ');
							$transportData2=mysqli_fetch_array($transportQuery2);
							$transferName2 = $transportData2['transferName'];


							$vmQuery2='';
							$vmQuery2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$suppQuotData['vehicleModelId'].'"');
							$carData2=mysqli_fetch_array($vmQuery2);
							$carType2 = getVehicleTypeName($carData2['carType']); 
							$vehicleName2 = ($carData2['model']); 

							$supTRFCost=0;
							$diffCost=0;

							$supTRFCost = ($suppQuotData['vehicleCost']);
							$supTRFCost = getPerPersonBasisCost($supTRFCost,$transferM,$markupType,0,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs);
							$diffCost = $supTRFCost-$mainTRFCost;
							
							if($diffCost > 0 ){
								$red_supp = "Upgrade ";
							}else{
								$red_supp = "Reduction ";
							} 
							$transferM.'='.$markupType;
							?>
							<tr height="18">
							<td align="center" ><strong>
						    <?php echo "D".str_pad($day2, 2, '0', STR_PAD_LEFT);  ?>
							  </strong></td>
							<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
							<td align="left"><?php echo ucfirst($normalQuotData['serviceType']).' - '.$red_supp."for ".$transferName2." (".$vehicleName2.") in place of ".$transferName." (".$vehicleName.")."; ?></td>
							<td align="center">
							  <?php echo (getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$diffCost)); ?>
							</td>
							</tr>
							<?php
						}
					}
				}
				$day2++;
			}
			?>
		</table>
		<?php 
	} 
} 
 
if($_REQUEST['parts'] == 'additionalSupplement'){
	$checkadditionalQuery=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" group by serviceType order by id asc');
	if(mysqli_num_rows($checkadditionalQuery) > 0){
		?>
		<!--<table width="100%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td  align="left" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px!important;">Additional Experience </td></tr></table>-->
		<table width="100%" border="1" cellpadding="8" cellspacing="0" class="borderedTable">
			<tr height="18" style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th align="left"><strong>Service&nbsp;Type </strong></th>
				<th width="50%" align="left"><strong>Name</strong></th>
				<th align="center"><strong>Adult&nbsp;Cost(PP)</strong></th>
				<th align="center"><strong>Child&nbsp;Cost(PC)</strong></th>
				<th align="center"><strong>Infant&nbsp;Cost(PC)</strong></th>
				<th align="center"><strong>Group&nbsp;Cost</strong></th>
			</tr>
			<?php
			while($additionalIdData=mysqli_fetch_array($checkadditionalQuery)){	

				if($additionalIdData['serviceType']=='Activity'){
					
					$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
					while($activityData=mysqli_fetch_array($rsAct)){	
							$c121=GetPageRecord('*','packageBuilderotherActivityMaster',' id in ( select otherActivityNameId from dmcotherActivityRate where id="'.$activityData['additionalId'].'" ) order by id asc'); 
							$activityDataName=mysqli_fetch_array($c121);

							$adultCost = $childCost = $infantCost = $groupCost = 0;
							$adultCost = $activityData['adultCost'];
							$childCost = $activityData['adultCost'];
							$infantCost = $activityData['adultCost'];

							$adultCost = getPerPersonBasisCost($adultCost,$activityM,$activityMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
							$childCost = getPerPersonBasisCost($childCost,$activityM,$activityMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
							$infantCost = getPerPersonBasisCost($infantCost,$activityM,$activityMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 

						?>
						<tr id="addnl<?php echo $activityData['id'];?>">
						 <td width="99" align="left"><?php echo $activityData['serviceType'];?></td>
						<td align="left"><?php echo ucwords($activityDataName['otherActivityName']); ?></td>
						<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td>
						<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$infantCost;?></td>
						<td width="80" align="center">&nbsp;</td>
						</tr>
						<?php 
					}
				}
				
				
				if($additionalIdData['serviceType']=='Guide'){
					
					$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
					while($guideData=mysqli_fetch_array($rsAct)){	
							$c121=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id in (select serviceid from dmcGuidePorterRate where id="'.$guideData['serviceId'].'") order by id asc'); 
							$guideDataName=mysqli_fetch_array($c121);

							$adultCost = $childCost = $infantCost = $groupCost = 0;
							$adultCost = $guideData['adultCost'];
							$childCost = $guideData['adultCost'];
							$infantCost = $guideData['adultCost'];
							
							$adultCost = getPerPersonBasisCost($adultCost,$guideM,$guideMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
							$childCost = getPerPersonBasisCost($childCost,$guideM,$guideMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
							$infantCost = getPerPersonBasisCost($infantCost,$guideM,$guideMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 


						?>
						<tr id="addnl<?php echo $guideData['id'];?>">
						 <td align="left"><?php echo $guideData['serviceType'];?></td>
						<td align="left"><?php echo ucwords($guideDataName['name']);?> </td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$infantCost;?></td> 
						<td width="80" align="center">&nbsp;</td>
						</tr>
						<?php 
					}
				}
				
				if($additionalIdData['serviceType']=='Entrance'){
				
						$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
						while($entranceData=mysqli_fetch_array($rsAct)){

							if($entranceData['additionalId'] != 0){
								$c121=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id in (select entranceNameId from '._DMC_ENTRANCE_RATE_MASTER_.' where id="'.$entranceData['additionalId'].'") order by id asc'); 
								$entranceDataName=mysqli_fetch_array($c121);
							}else{
								$c121=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entranceData['serviceId'].'"'); 
								$entranceDataName=mysqli_fetch_array($c121);	
							}

							$adultCost = $childCost = $infantCost = $groupCost = 0;
							$adultCost = $entranceData['adultCost'];
							$childCost = $entranceData['childCost'];
							$infantCost = $entranceData['infantCost'];
							
							$adultCost = getPerPersonBasisCost($adultCost,$entranceM,$entranceMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
							$childCost = getPerPersonBasisCost($childCost,$entranceM,$entranceMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
							$infantCost = getPerPersonBasisCost($infantCost,$entranceM,$entranceMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 


						?>
						<tr id="addnl<?php echo $entranceData['id'];?>">
						<td width="99" align="left"><?php echo $entranceData['serviceType'];?></td>
						<td width="179" align="left"><?php echo ucwords($entranceDataName['entranceName']);?></td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$infantCost;?></td> 
						<td width="80" align="center">&nbsp;</td>
						</tr>
						<?php 
					}
				}	

				if($additionalIdData['serviceType']=='Restaurant'){
				
					$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
					while($restaurntData=mysqli_fetch_array($rsAct)){
			 			
			 			$mealpQuery='';
						$mealpQuery=GetPageRecord('mealPlanName',_INBOUND_MEALPLAN_MASTER_,' 1 and id in ( select restaurantId from dmcRestaurantsMealPlanRate where 1 and id="'.$restaurntData['additionalId'].'") '); 
						$mealPlanData2=mysqli_fetch_array($mealpQuery);	

						$adultCost = $childCost = $infantCost = $groupCost = 0;
						$adultCost = $restaurntData['adultCost'];
						$childCost = $restaurntData['childCost'];
						$infantCost = $restaurntData['infantCost'];
						
						$adultCost = getPerPersonBasisCost($adultCost,$restaurantM,$restaurantMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
						$childCost = getPerPersonBasisCost($childCost,$restaurantM,$restaurantMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
						$infantCost = getPerPersonBasisCost($infantCost,$restaurantM,$restaurantMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 


						?>
						<tr id="addnl<?php echo $restaurntData['id'];?>">
						<td width="80" align="left"><?php echo $restaurntData['serviceType'];?></td>
						<td width="200" align="left"><?php echo ucwords($mealPlanData2['mealPlanName']);?></td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$infantCost;?></td> 
						<td width="80" align="center">&nbsp;</td>
						</tr>
						<?php 
					}
				}	

				if($additionalIdData['serviceType']=='Additional'){
				
					$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
					while($additionalData2=mysqli_fetch_array($rsAct)){
			 			$addisQuery='';
						$addisQuery=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,' 1 and id="'.$additionalData2['additionalId'].'"'); 
						$addislanData2=mysqli_fetch_array($addisQuery);	


						$adultCost = $childCost = $infantCost = $groupCost = 0;
						$adultCost = $additionalData2['adultCost'];
						$childCost = $additionalData2['adultCost'];
						$infantCost = $additionalData2['adultCost'];
						$groupCost = $additionalData2['groupCost'];
						
						$adultCost = getPerPersonBasisCost($adultCost,$otherM,$otherMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
						$childCost = getPerPersonBasisCost($childCost,$otherM,$otherMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
						$infantCost = getPerPersonBasisCost($infantCost,$otherM,$otherMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 
						$groupCost = getPerPersonBasisCost($groupCost,$otherM,$otherMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcs); 


						?>
						<tr id="addnl<?php echo $additionalData2['id'];?>">
						<td width="80" align="left"><?php echo $additionalData2['serviceType'];?></td>
						<td width="200" align="left"><?php echo ucwords($addislanData2['name']);?></td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$infantCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$groupCost;?></td>
						</tr>
						<?php 
					}
				}	
			}
			?>
		</table> 
		<?php 
	} 
} 
 
if($_REQUEST['parts'] == 'costingDetail'){
	?>
	<!-- start Costing table -->

	<?php if($resultpageQuotation['queryType']==6 || $resultpageQuotation['queryType']==7 || $resultpageQuotation['queryType']==8 || $resultpageQuotation['queryType']==9 || $resultpageQuotation['queryType']==10 || $resultpageQuotation['queryType']==11){
		?>

		<table width="100%" border="0" align="center" cellpadding="20" cellspacing="0">
				<tr>
					<td>
					<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ccc" class="borderedTable" style="font-size: 14px !important;"> 
				
				<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><th colspan="5">Tour Cost</th></tr>
				<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<td align="center"><strong>No. of Pax</strong></td>
					<td align="center"><strong>Total&nbsp;Cost</strong></td>
					<td align="center"><strong>Adult&nbsp;Basis</strong></td>
					<td align="center"><strong>Child&nbsp;Basis</strong></td>
					<td align="center"><strong>Infant&nbsp;Basis</strong></td>
				</tr>
			<tr>
				<?php 
				${"final_cost".$slabId11} =  (${"proposalCost".$slabId11}+$resultpageQuotation['otherLocationCost']);
				  ?>
				  <td align="center"><?php echo $totalPax; ?></td>
				<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,${"final_cost".$slabId11}); ?></td>
				<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$perAdultCostTFS); ?></td>
				<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$perChildCostTFS); ?></td>
				<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$perInfantCostTFS); ?></td>
			</tr>
			</table>
			</td>
			</tr>
		</table>
		<?php

	 }elseif($resultpageQuotation['queryType']==13){
		?>
		<table width="100%" border="0" align="center" cellpadding="20" cellspacing="0">
		<tr>
			<td colspan="2" align="center" >
		<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ccc" class="borderedTable" style="font-size: 14px !important;">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" >
			<th colspan="5" align="center" >Price based on per person basis (In <?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>)</th>
			</tr>
			<tr>
				<th>No.&nbsp;Of&nbsp;Pax</th>
				<th>Total&nbsp;Cost</th>
				<th>Adult&nbsp;Cost</th>
				<th>Child&nbsp;Cost</th>
				<th>Infant&nbsp;Cost</th>
			</tr>
			<?php $finalCost = $resultpageQuotation['totalQuotCost']; ?>
			<tr>
				<td align="center"><?php echo $totalPax; ?></td>
				<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$grandTotalCost); ?></td>
				<td align="center"><?php echo getTwoDecimalNumberFormat($ppCostONAdultBasis); ?></td>
				<td align="center"><?php echo getTwoDecimalNumberFormat($ppCostONChildBasis); ?></td>
				<td align="center"><?php echo getTwoDecimalNumberFormat($ppCostOnInfantBasis); ?></td>
			</tr>
		</table>
			</td>
		</tr>
		</table>
		<br>
		<?php
	 }elseif($resultpageQuotation['queryType']==14){
		?>
		
		<table width="100%" border="0" align="center" cellpadding="20" cellspacing="0">
		<tr>
			<td colspan="2" align="center" >
		<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ccc" class="borderedTable" style="font-size: 14px !important;">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" >
			<th colspan="5" align="center" >Price based on per person basis (In <?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>)</th>
			</tr>
			<tr>
				<th>No.&nbsp;Of&nbsp;Pax</th>
				<th>Total&nbsp;Cost</th>
				<th>Adult&nbsp;Cost</th>
				<th>Child&nbsp;Cost</th>
				<th>Infant&nbsp;Cost</th>
			</tr>
			<?php $finalCost = $resultpageQuotation['totalQuotCost']; ?>
			<tr>
				<td align="center"><?php echo $totalPax; ?></td>
				<td align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$grandTotalCost); ?></td>
				<td align="center"><?php echo getTwoDecimalNumberFormat($ppCostOnAdultBasis); ?></td>
				<td align="center"><?php echo getTwoDecimalNumberFormat($ppCostOnChildBasis); ?></td>
				<td align="center"><?php echo getTwoDecimalNumberFormat($ppCostOnInfantBasis); ?></td>
			</tr>
		</table>
			</td>
		</tr>
		</table>
		<br>
		<?php
	 }else{
		?>
	<table width="100%" border="0" align="center" cellpadding="20" cellspacing="0">
		<tr>
			<td colspan="2" align="center" > 
			<?php 
			if($queryData['travelType']!=2 && $resultpageQuotation['calculationType']<2){  ?>
				<table class="detaPremBr" width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ccc" class="borderedTable" style="font-size: 14px !important;"> 
					<?php
					if($resultpage['seasonType'] == 3){
						$colm = 2;
					}else{
						$colm = 1;
					}

					$conspan = 2;
					if($singleRoom>0){ $conspan=$conspan+1; }
					if($doubleRoom>0){ $conspan=$conspan+1; }
					if($tripleRoom>0){ $conspan=$conspan+1; }
					if($twinRoom>0){ $conspan=$conspan+1; }
					if($sixNBedRoom>0){ $conspan=$conspan+1; }
					if($eightNBedRoom>0){ $conspan=$conspan+1; }
					if($tenNBedRoom>0){ $conspan=$conspan+1; }
					if($quadNoofRoom>0){ $conspan=$conspan+1; }
					if($teenNoofRoom>0){ $conspan=$conspan+1; }
					if($EBedAdult>0){ $conspan=$conspan+1; }
					if($EBedChild>0){ $conspan=$conspan+1; }
					if($NBedChild>0){ $conspan=$conspan+1; }
					if($paxInfant>0){ $conspan=$conspan+1; }
					if($perPersonCostOnTransport>0){ $conspan=$conspan+1; }
					if($perPersonCostOnTrain>0){ $conspan=$conspan+1; }
					if($perPersonCostOnFlight>0){ $conspan=$conspan+1; }
					if($resultpageQuotation['quotationType']==2 || $resultpageQuotation['quotationType']==3){  
					 $conspan=$conspan+1;
					 $conspan=$conspan+1;
					 $conspan=$conspan+1;
					}
					$colsWidth = 100/$conspan;


					if($resultpageQuotation['quotationType']==1){  
						$hotCategory2 = explode(',', 0);
					}elseif($resultpageQuotation['quotationType']==2){
						$hotCategory2 = explode(',',$resultpageQuotation['hotCategory']);
					}elseif($resultpageQuotation['quotationType']==3){  
						$hotelTypeWise = explode(',',$resultpageQuotation['hotelType']);
						$hotCategory2 = explode(',',$resultpageQuotation['hotelType']);
						
					}

					// echo $resultpageQuotation['id'];
					$widttth = count($hotCategory2);
					$widths = 100/($colm*$widttth+1);
					$widths2 = $widths*$widttth;
					$colm1 = ($colm*$widttth+1);
					?>
					<!-- multiple category related prices -->
					<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" >
						<th class="detProp" colspan="<?php echo $colm1+$conspan; ?>" align="center" >Price based on selected room basis (In <?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>)</th>
					</tr>
					<tr class="detProp" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" >
						<?php
						for ($i = 1; $i <= $colm; $i++){
							if(count($hotCategory2)>1){
								if($resultpageQuotation['quotationType']==2 || $resultpageQuotation['quotationType']==3){ 
							?>
							<th class="detProp" width="<?php echo $colsWidth; ?>%" align="center"><strong><?php if($_REQUEST['prop']=="vista"){ echo 'Name'; }else{ if($resultpageQuotation['quotationType']==2){ echo 'Hotel Category'; }else{ echo 'Hotel Type'; } } ?></strong></th>

							<th class="detProp" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" width="<?php echo $colsWidth; ?>%" align="center" ><strong>No. of Pax</strong></th>
							<?php 	if($isProposalCostD['isProposalCost']==1){ ?>
							<th style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" width="<?php echo $colsWidth; ?>%" align="center" ><strong>Total Cost</strong></th>
							
							<?php }
							if($isProposalCostD['isProposalCostPP']==1){
							if($singleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Single Basis (PP)</strong></th>
							<?php } if($doubleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Double Basis (PP)</strong></th>
							<?php } if($twinRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Twin Basis (PP)</strong></th>
							<?php } if($tripleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Triple Basis (PP)</strong></th>
							<?php } if($quadNoofRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Quad Room Basis (PP)</strong></th>
							<?php } if($sixNBedRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Six Bed Basis (PP)</strong></th>
							<?php } if($eightNBedRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Eight Bed Basis (PP)</strong></th>
							<?php } if($tenNBedRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Ten Bed Basis (PP)</strong></th>
							<?php } if($teenNoofRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Teen Room Basis (PP)</strong></th>
							<?php } if($EBedAdult>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>E.Bed(Adult) Basis (PP)</strong></th>
							<?php } if($EBedChild>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CWB Basis (PP)</strong></th>
							<?php } if($NBedChild>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CNB Basis (PP)</strong></th> 
							<?php } if($paxInfant>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Infant Basis (PP)</strong></th> 
							<?php } } 
							}

							}
							else{
								?>
								<th class="detProp" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" width=" <?php echo $colsWidth; ?>%"  align="center" >No. of Pax</th>
								<?php
								if($isProposalCostD['isProposalCost']==1){
								?> 
								<th class="detProp" width="<?php if($resultpageQuotation['quotationType']==2 || $resultpageQuotation['quotationType']==3){  echo $widths2; }else{ echo $colsWidth; } ?>%"   align="center">Total&nbsp;Cost</th>
								<?php }	?>
								<?php 
								if($resultpageQuotation['quotationType']==1){ 
								if($isProposalCostD['isProposalCostPP']==1){ 
									if($singleRoom>0){ ?>
									<th class="detProp" width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Single Basis (PP)</strong></th>
									<?php } if($doubleRoom>0){ ?>
									<th class="detProp"	 width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Double Basis (PP)</strong></th>
									<?php } if($twinRoom>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Twin Basis (PP)</strong></th>
									<?php } if($tripleRoom>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Triple Basis (PP)</strong></th>
									<?php } if($quadNoofRoom>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Quad Room Basis (PP)</strong></th>
									<?php } if($sixNBedRoom>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Six Bed Basis (PP)</strong></th>
									<?php } if($eightNBedRoom>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Eight Bed Basis (PP)</strong></th>
									<?php } if($tenNBedRoom>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Ten Bed Basis (PP)</strong></th>
									<?php } if($teenNoofRoom>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Teen Room Basis (PP)</strong></th>
									<?php } if($EBedAdult>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>E.Bed(Adult) Basis (PP)</strong></th>
									<?php } if($EBedChild>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CWB Basis (PP)</strong></th>
									<?php } if($NBedChild>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CNB Basis (PP)</strong></th>
									<?php } if($paxInfant>0){ ?>
									<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Infant Basis (PP)</strong></th>
									<?php } if($perPersonCostOnTransport>0 && $onlyTFS==1){ ?>
									<th width="" valign="middle"><strong>Transfer Basis Cost (PP)</strong></th>
									<?php } if($perPersonCostOnTrain>0 && $onlyTFS==1){ ?>
									<th width="" valign="middle"><strong>Train Basis Cost (PP)</strong></th>
									<?php } if($perPersonCostOnFlight>0 && $onlyTFS==1){ ?>
									<th width="" valign="middle"><strong>Flight Basis Cost (PP)</strong></th>
									<?php }  }?>
									<?php 
								}  
							}
						}
						?>
					</tr>
					<?php
					if(count($hotCategory2)>1){
						
						?>
						<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" > 
							<?php

								if($resultpageQuotation['currencyId'] == '' && $resultpageQuotation['currencyId'] == 0 ){
									$newCurr = $baseCurrencyId;
								}else{
									$newCurr = $resultpageQuotation['currencyId'];
								}

								

							for ($i = 1; $i <= $colm; $i++) {
								foreach($hotCategory2 as $val2){
								// Hotel Category Wise
								if($resultpageQuotation['quotationType']==2){
								$rsname1=GetPageRecord('*','hotelCategoryMaster','id="'.$val2.'"');
								$hotelCatData1=mysqli_fetch_array($rsname1);
								$hotelCategory = $hotelCatData1['hotelCategory'].' Star';
								}

								// Hotel Type Wise
								if($resultpageQuotation['quotationType']==3){
									$rsname12=GetPageRecord('*','hotelTypeMaster','id="'.$val2.'"');
									$hotelTypeData1=mysqli_fetch_array($rsname12);
									$hotelCategory = $hotelTypeData1['name'];
								}


								$slabSql=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
								if(mysqli_num_rows($slabSql) > 0){
								while($slabsData=mysqli_fetch_array($slabSql)){
									$slabId = $slabsData['id'].'C0';
									if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['fromRange']==0 || $slabsData['toRange']==0){
										$localforeignEscort = $slabsData['localEscort']+$slabsData['foreignEscort'];
										$paxrange2 = $slabsData['fromRange'];
										
									}else{
										$localforeignEscort = $slabsData['localEscort']+$slabsData['foreignEscort'];
										$paxrange2 = $slabsData['fromRange']."-".$slabsData['toRange'];
										
										
										
									}

								?>
							<tr >
						<td width="<?php echo $colsWidth; ?>%"  align="center"><strong><?php if($hotelCatData1['proposalCategory']!='' && $_REQUEST['prop']=="vista"){ echo $hotelCatData1['proposalCategory']; }else{  
							if(strlen($hotelCategory)>0){
								echo $hotelCategory;
							}else{
								echo $hotelCategory11;
							}

							
							
							} ?></strong></td>

						<td width="<?php echo $colsWidth; ?>%" align="center" ><strong><?php echo $paxrange2; echo ($localforeignEscort>0)? '+'.$localforeignEscort:''; ?>&nbsp;Pax</strong></td>
						<?php
						
						 $slabId11 = $slabsData['id'].'C'.$val2;
						${"final_cost".$slabId11} = 0;

						${"final_cost".$slabId11} =  (${"proposalCost".$slabId11}+$resultpageQuotation['otherLocationCost']);
						?>
						<?php if($isProposalCostD['isProposalCost']==1){ ?>
						<td width="<?php echo $colsWidth; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,${"final_cost".$slabId11}); ?></td>

						<?php }
						if($isProposalCostD['isProposalCostPP']==1){ 
						if($singleRoom>0){ ?>
						<td  valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostONSingleBasis".$slabId11})); ?>
						</td>
						<?php } if($doubleRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostONDoubleBasis".$slabId11})); ?>
						</td>
						<?php } if($twinRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostONTwinBasis".$slabId11})); ?>
						</td>
						<?php } if($tripleRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnTripleBasis".$slabId11})); ?>
						</td>
						<?php } if($quadNoofRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnQuadBasis".$slabId11})); ?>
						</td>
						<?php } if($sixNBedRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnSixBasis".$slabId11})); ?>
						</td>
						<?php } if($eightNBedRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnEightBasis".$slabId11})); ?>
						</td>
						<?php } if($tenNBedRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnTenBasis".$slabId11})); ?>
						</td>
						<?php } if($teenNoofRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnTeenBasis".$slabId11})); ?>
						</td>
						<?php } if($EBedAdult>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnExtraBedABasis".$slabId11})); ?>
						</td>
						<?php } if($EBedChild>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"pcCostOnExtraBedCBasis".$slabId11})); ?>
						</td>
						<?php } if($NBedChild>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"pcCostOnExtraNBedCBasis".$slabId11})); ?>
						</td>
						<?php } if($paxInfant>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"peCostBasis".$slabId11})); ?>
						</td>
						<?php }  }?>

					</tr>
						<?php
						}
						}
						}
						}
						?>
						</tr>
						<?php
					}else{
						?>
						<!-- <th width="<?php echo $widths2; ?>%"   align="center">aa</th> -->
						<?php
					}
				  
					if($resultpageQuotation['currencyId'] == '' && $resultpageQuotation['currencyId'] == 0 ){
						$newCurr = $baseCurrencyId;
					}else{
						$newCurr = $resultpageQuotation['currencyId'];
					}
					
					$slabSql=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
					if(mysqli_num_rows($slabSql) > 0){
					while($slabsData=mysqli_fetch_array($slabSql)){
						$slabId = $slabsData['id'].'C0';
						if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['fromRange']==0 || $slabsData['toRange']==0){
							$localforeignEscort = $slabsData['localEscort']+$slabsData['foreignEscort'];
							$paxrange2 = $slabsData['fromRange']; 
							
						}else{
							$localforeignEscort = $slabsData['localEscort']+$slabsData['foreignEscort'];
							
							$paxrange2 = $slabsData['fromRange']."-".$slabsData['toRange']; 

						}
						?>
						<tr class="detProp">
							
							<?php
						

							if($resultpageQuotation['quotationType']==1){
								?>
								<td width="<?php if($resultpageQuotation['quotationType']==2 || $resultpageQuotation['quotationType']==3){  echo $widths; }else{ echo $colsWidth; } ?>%" align="center" ><strong><?php echo $paxrange2; echo ($localforeignEscort>0)? '+'.$localforeignEscort:''; ?>&nbsp;Pax</strong></td>

								<?php
								if($isProposalCostD['isProposalCost']==1){
								?>
								<td valign="middle" align="center">
									<?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,(${"proposalCost".$slabId}+$resultpageQuotation['otherLocationCost'])); ?>
								</td>
								<?php } ?>


								<?php
								
								if($isProposalCostD['isProposalCostPP']==1){ 
								if($singleRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostONSingleBasis".$slabId})); ?>
								</td>
								<?php } if($doubleRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostONDoubleBasis".$slabId})); ?>
								</td>
								<?php } if($twinRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostONTwinBasis".$slabId})); ?>
								</td>
								<?php } if($tripleRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnTripleBasis".$slabId})); ?>
								</td>
								<?php } if($quadNoofRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnQuadBasis".$slabId})); ?>
								</td>
								<?php } if($sixNBedRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnSixBasis".$slabId})); ?>
								</td>
								<?php } if($eightNBedRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnEightBasis".$slabId})); ?>
								</td>
								<?php } if($tenNBedRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnTenBasis".$slabId})); ?>
								</td>
								<?php } if($teenNoofRoom>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnTeenBasis".$slabId})); ?>
								</td>
								<?php } if($EBedAdult>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"ppCostOnExtraBedABasis".$slabId})); ?>
								</td>
								<?php } if($EBedChild>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"pcCostOnExtraBedCBasis".$slabId})); ?>
								</td>
								<?php } if($NBedChild>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"pcCostOnExtraNBedCBasis".$slabId})); ?>
								</td>
								<?php } if($paxInfant>0){ ?>
								<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"peCostBasis".$slabId})); ?>
								</td>
								
								<?php } if($onlyTFS==1 && $perPersonCostOnTransport>0){ ?>
									<td valign="middle" align="center">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"perPersonCostOnTransport".$slabId})); ?>
									</td>
								<?php } if($onlyTFS==1 && $perPersonCostOnTrain){ ?>
									<td valign="middle" align="center">
										<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"perPersonCostOnTrain".$slabId})); ?>
									</td>
								<?php } if($onlyTFS==1 && $perPersonCostOnFlight){ ?>
									<td valign="middle" align="center">
										<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${"perPersonCostOnFlight".$slabId})); ?>
									</td>
								<?php }  }?>
							<?php } ?>
						</tr>
						<?php
					}
					}
					?>
					<?php if($resultpageQuotation['isSupp_TRR'] == 1){ ?>
					<tr>
						<td width="<?php echo $widths; ?>%" align="center" ><strong>Single&nbsp;Suppliment</strong></td>
						<?php
						for ($i = 1; $i <= $colm; $i++) {
						foreach($hotCategory2 as $val2){
						$val2 = $val2.$i;
						${"singleSuppliment" . $val2} = 0;
						$singleSuppliment = ${"singleSuppliment" . $val2};
						?>
						<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$singleSuppliment); ?>&nbsp;<strong><?php echo getCurrencyName($resultpageQuotation['currencyId']); ?></strong></td>
						<?php } } ?>
					</tr>
					<tr>
						<td width="<?php echo $widths; ?>%" align="center" ><strong>Tripple&nbsp;Reduction</strong></td>
						<?php
						for ($i = 1; $i <= $colm; $i++) {
						foreach($hotCategory2 as $val2){
						$val2 = $val2.$i;
						$tripleRateReduction = ${"tripleRateReduction" . $val2};
						?>
						<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$tripleRateReduction); ?>&nbsp;<strong><?php echo getCurrencyName($resultpageQuotation['currencyId']); ?></strong></td>
						<?php } } ?>
					</tr>
					<?php } ?>
				</table>
			<?php }else{
				
				if($resultpage['seasonType'] == 3){
					$colm = 2;
				}else{
					$colm = 1;
				}

				$conspan = 0;
				if($singleRoom>0){ $conspan=$conspan+1; }
				if($doubleRoom>0){ $conspan=$conspan+1; }
				if($tripleRoom>0){ $conspan=$conspan+1; }
				if($twinRoom>0){ $conspan=$conspan+1; }
				if($EBedAdult>0){ $conspan=$conspan+1; }
				if($EBedChild>0){ $conspan=$conspan+1; }
				if($NBedChild>0){ $conspan=$conspan+1; }
				if($paxInfant>0){ $conspan=$conspan+1; }
				if($sixNBedRoom>0){ $conspan=$conspan+1; }
				if($eightNBedRoom>0){ $conspan=$conspan+1; }
				if($tenNBedRoom>0){ $conspan=$conspan+1; }
				if($quadNoofRoom>0){ $conspan=$conspan+1; }
				if($teenNoofRoom>0){ $conspan=$conspan+1; }
				if($perPersonCostOnTransport>0){ $conspan=$conspan+1; }
				if($perPersonCostOnTrain>0){ $conspan=$conspan+1; }
				if($perPersonCostOnFlight>0){ $conspan=$conspan+1; }

				if($resultpageQuotation['quotationType']==2 || $resultpageQuotation['quotationType']==3){  
					$conspan=$conspan+1;
					$conspan=$conspan+1;
					$conspan=$conspan+1;
				   }
				   $colsWidth = 100/$conspan;

	
				   if($resultpageQuotation['quotationType']==1){  
					$hotCategory22 = explode(',', 0);
					}elseif($resultpageQuotation['quotationType']==2){
					$hotCategory22 = explode(',',$resultpageQuotation['hotCategory']);
					}elseif($resultpageQuotation['quotationType']==3){
					 $hotCategory22 = explode(',',$resultpageQuotation['hotelType']);
					}
				   // echo $resultpageQuotation['id'];
				   $widttth = count($hotCategory22);
				   $widths = 100/($colm*$widttth+1);
				   $widths2 = $widths*$widttth;
				   $colm1 = ($colm*$widttth+1);
					$conspan=$conspan+1;
				

				$conspan=$conspan+1;
				$colsWidth = 100/$conspan;
				?> 
				<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable" style="page-break-after: auto;page-break-before: auto;width: 100%; text-align: center; font-size:14px !important;"> 
				<tr><?php if($conspan>0 || $onlyTFS>0){ ?>
					<th width="100%" colspan="<?php echo $conspan; ?>" align="center" valign="middle" style=""><strong>Tour Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
				<?php } ?>
			</tr>	
				<?php if($quotationData['quotationType']==1111){  ?>
				<tr style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				
							
							<th style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" width="<?php echo $colsWidth; ?>%" align="center" ><strong>No. of Pax</strong></th>
							
							<?php 	if($isProposalCostD['isProposalCost']==1){ ?>
							<th style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" width="<?php echo $colsWidth; ?>%" align="center" ><strong>Total Cost</strong></th>
							
							<?php } 
							if($isProposalCostD['isProposalCostPP']==1){
							
							if($singleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Single Basis (PP)</strong></th>
							<?php } if($doubleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Double Basis (PP)</strong></th>
							<?php } if($twinRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Twin Basis (PP)</strong></th>
							<?php } if($tripleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Triple Basis (PP)</strong></th>
							<?php } if($quadNoofRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Quad Room Basis (PP)</strong></th>
							<?php } if($sixNBedRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Six Bed Basis (PP)</strong></th>
							<?php } if($eightNBedRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Eight Bed Basis (PP)</strong></th>
							<?php } if($tenNBedRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Ten Bed Basis (PP)</strong></th>
							<?php } if($teenNoofRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Teen Room Basis (PP)</strong></th>
							<?php } if($EBedAdult>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>E.Bed(Adult) Basis (PP)</strong></th>
							<?php } if($EBedChild>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CWB Basis (PP)</strong></th>
							<?php } if($NBedChild>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CNB Basis (PP)</strong></th> 
							<?php } if($paxInfant>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Infant Basis (PP)</strong></th> 
							<?php } } ?>
						 
					</tr>

					<?php
					} 
					if($quotationData['quotationType']==2 || $quotationData['quotationType']==3 || $quotationData['quotationType']==1){ 
					if($conspan>0 || $onlyTFS>0){ ?> 
					<tr style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<?php if($quotationData['quotationType']==2 || $quotationData['quotationType']==3){ ?> 
					<th width="<?php echo $colsWidth; ?>%" align="center"><strong><?php if($quotationData['quotationType']==2){  echo 'Hotel Category'; }else{ echo 'Hotel Type'; } ?></strong></th>
					<?php } ?>
					<th style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" width=" <?php echo $colsWidth; ?>%"  align="center" ><strong>No. of Pax</strong></th>
					
					<?php
					if($isProposalCostD['isProposalCost']==1){
								?> 
					<th width="<?php if($quotationData['quotationType']==2 || $quotationData['quotationType']==3){  echo $colsWidth; }else{ echo $colsWidth; } ?>%"   align="center">Total&nbsp;Cost</th>
					<?php }	?>
					
						<?php 
						 if($isProposalCostD['isProposalCostPP']==1){ 
						
						if($singleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Single Basis</strong></th>
						<?php } if($doubleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Double Basis</strong></th>
						<?php } if($twinRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Twin Basis</strong></th>
						<?php } if($tripleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Triple Basis</strong></th>
						<?php } if($quadNoofRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Quad&nbsp;Room Basis</strong></th>
						<?php } if($sixNBedRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Six&nbsp;Bed Basis</strong></th>
						<?php } if($eightNBedRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Eight&nbsp;Bed Basis</strong></th>
						<?php } if($tenNBedRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Ten&nbsp;Bed Basis</strong></th>
						<?php } if($EBedAdult>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>EBed(A) Basis</strong></th>
						<?php } if($teenNoofRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Teen Basis</strong></th>
						<?php } if($EBedChild>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CWB Basis</strong></th>
						<?php } if($NBedChild>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CNB Basis</strong></th> 
						<?php } if($paxInfant>0){ ?> 
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Infant Basis</strong></th>
						<?php } if($perPersonCostOnTransport>0 && $onlyTFS==1){ ?>
						<th width="" valign="middle"><strong>Transfer Basis Cost</strong></th>
						<?php } if($perPersonCostOnTrain>0 && $onlyTFS==1){ ?>
						<th width="" valign="middle"><strong>Train Basis Cost</strong></th>
						<?php } if($perPersonCostOnFlight>0 && $onlyTFS==1){ ?>
						<th width="" valign="middle"><strong>Flight Basis Cost</strong></th>
						<?php }  }?>
					</tr>
					<?php } } //}


				if(count($hotCategory22)>0){
					?>
					<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;" > 
						<?php

							if($resultpageQuotation['currencyId'] == '' && $resultpageQuotation['currencyId'] == 0 ){
								$newCurr = $baseCurrencyId;
							}else{
								$newCurr = $resultpageQuotation['currencyId'];
							}
							

					for ($i = 1; $i <= $colm; $i++){
								foreach($hotCategory22 as $val22){
									if($resultpageQuotation['quotationType']==2){
										$rsname1=GetPageRecord('*','hotelCategoryMaster','id="'.$val22.'"');
										$hotelCatData1=mysqli_fetch_array($rsname1);
										$hotelCategory = $hotelCatData1['hotelCategory'].' Star';
										}
		
										// Hotel Type Wise
										if($resultpageQuotation['quotationType']==3){
											$rsname12=GetPageRecord('*','hotelTypeMaster','id="'.$val22.'"');
											$hotelTypeData1=mysqli_fetch_array($rsname12);
											$hotelCategory = $hotelTypeData1['name'];
										}
		

								$slabSql=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
								if(mysqli_num_rows($slabSql) > 0){
								while($slabsData=mysqli_fetch_array($slabSql)){
									$slabId = $slabsData['id'].'C0';
									if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['fromRange']==0 || $slabsData['toRange']==0){
										$localforeignEscort = $slabsData['localEscort']+$slabsData['foreignEscort'];
										$paxrange2 = $slabsData['fromRange'];
										
									}else{
										$localforeignEscort = $slabsData['localEscort']+$slabsData['foreignEscort'];
										$paxrange2 = $slabsData['fromRange']."-".$slabsData['toRange'];
										
										
										
									}

								?>
							<tr>
						<?php if($quotationData['quotationType']==2 || $quotationData['quotationType']==3){ ?> 
						<td width="<?php echo $colsWidth; ?>%"  align="center"><strong><?php echo $hotelCategory; ?></strong></td>
						<?php } ?>
						<td width="<?php echo $colsWidth; ?>%" align="center" ><strong><?php echo  $totalPax; echo ($localforeignEscort>0)? '+'.$localforeignEscort:''; ?>&nbsp;Pax</strong></td>
						<?php
					
						$slabId11 = $slabsData['id'].'C'.$val2;
						${"final_cost".$slabId11} = 0;

						${"final_cost".$slabId11} =  (${"proposalCost".$val22}+$resultpageQuotation['otherLocationCost']);
						?>
						<?php 	if($isProposalCostD['isProposalCost']==1){ ?>
						<td width="<?php echo $colsWidth; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,${"final_cost".$slabId11}); ?></td>
						
						<?php } 
						
						if($isProposalCostD['isProposalCostPP']==1){
						if($singleRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId, ${'ppCostONSingleBasis'.$val22})); ?>
						</td>
						<?php } if($doubleRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostONDoubleBasis'.$val22})); ?>
						</td>
						<?php } if($twinRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostONTwinBasis'.$val22})); ?>
						</td>
						<?php } if($tripleRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostOnTripleBasis'.$val22})); ?>
						</td>
						<?php } if($quadNoofRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostOnQuadBasis'.$val22})); ?>
						</td>
						<?php } if($sixNBedRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostOnSixBasis'.$val22})); ?>
						</td>
						<?php } if($eightNBedRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostOnEightBasis'.$val22})); ?>
						</td>
						<?php } if($tenNBedRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostOnTenBasis'.$val22})); ?>
						</td>

						<?php } if($EBedAdult>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'ppCostOnExtraBedABasis'.$val22})); ?>
						</td>
						<?php } if($teenNoofRoom>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'pcCostOnTeenBasis'.$val22})); ?>
						</td>
						<?php } if($EBedChild>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'pcCostOnExtraBedCBasis'.$val22})); ?>
						</td>
						<?php } if($NBedChild>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'pcCostOnExtraNBedCBasis'.$val22})); ?>
						</td>
						<?php } if($paxInfant>0){ ?>
						<td valign="middle" align="center">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,${'peCostBasis'.$val22})); ?>
						</td>
						<?php } } ?>

					</tr>
						<?php
						} // pax slab while loop
						} // result yes condition
						} //Category wise loop

						} //Cols for loop
						?>
						</tr>
						<?php
					}else{
						
					if($resultpageQuotation['quotationType']==1){
					?>
					<tr >
					<td valign="middle">
							<strong><?php echo $totalPax; ?>&nbsp;Pax</strong>
						</td>
					<?php if($isProposalCostD['isProposalCost']==1){ ?>
						<td valign="middle">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
						</td>
						<?php } ?>
						<?php 
						if($isProposalCostD['isProposalCostPP']==1){
						if($singleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
						</td>
						<?php } if($doubleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
						</td>
						<?php } if($twinRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONTwinBasis)); ?>
						</td>
						<?php } if($tripleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnTripleBasis)); ?>
						</td>
						<?php } if($quadNoofRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnQuadBasis)); ?>
						</td>
						<?php } if($sixNBedRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnSixBasis)); ?>
						</td>

						<?php } if($eightNBedRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnEightBasis)); ?>
						</td>
						<?php } if($tenNBedRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnTenBasis)); ?>
						</td>
						<?php } if($EBedAdult>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnExtraBedABasis)); ?>
						</td>
						<?php } if($teenNoofRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnTeenBasis)); ?>
						</td>
						<?php } if($EBedChild>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
						</td>
						<?php } if($NBedChild>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraNBedCBasis)); ?>
						</td>
						<?php } if($paxInfant>0){ ?>
						<td valign="middle">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$peCostBasis)); ?>
						</td>
						<?php } if($onlyTFS==1 && $perPersonCostOnTransport>0){ ?>
						<td valign="middle">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$perPersonCostOnTransport)); ?>
						</td>
						<?php } if($onlyTFS==1 && $perPersonCostOnTrain){ ?>
						<td valign="middle">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$perPersonCostOnTrain)); ?>
						</td>
						<?php } if($onlyTFS==1 && $perPersonCostOnFlight){ ?>
						<td valign="middle">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$perPersonCostOnFlight)); ?>
						</td>
						<?php }  }?>
					</tr>
					
					<?php } }
					
					if($quotationData['isSupp_TRR']==0){ ?>
					<?php if($SRSCost!=''){ ?>
					<tr>
						<td width="20%" align="left" valign="middle">SRS</td>
						<td width="80%" colspan="<?php echo $conspan; ?>" align="left" valign="middle"><strong><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$SRSCost); ?></strong>&nbsp;Single Room Supplement for Per single room</td>
					</tr>
					<?php } ?>
					<?php if($TRRCost!=''){ ?>
					<tr>
						<td width="20%" align="left"  valign="middle">TRR</td>
						<td width="80%" colspan="<?php echo $conspan; ?>" align="left" valign="middle"><strong><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$TRRCost); ?></strong>&nbsp;Triple Rate Reduction for Per person sharing a triple room</td>
					</tr>
					<?php } ?>
					<?php } ?>
				</table>
				<?php 
				}
			} 
			?>
			</td>
		</tr>
		<!-- <tr>
			<td width="100%"  >
				<table width="100%" align="center">
				<tr>
					<td align="center" style="font-size:10px; color:#999999;"> The taxes and fees component includes - All government taxes
						
						levied for your bookings. Our service fee for booking
						
						and concierge support. All currency conversion charges
						
					wherever applicable </td>
				</tr>

			</table>
		</td>
		</tr> -->
	</table>
	<!-- end Costing table -->
	<?php
}

if($_REQUEST['parts']=='normalValueAddedServices'){


	// visa supplement Cost
	
	$visa=GetPageRecord('*',_QUOTATION_VISA_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['visaCostType'] == 1 && mysqli_num_rows($visa)>0){ 
		// $visa=GetPageRecord('*',_QUOTATION_VISA_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		// if($resultpageQuotation['visaCostType'] == 1 && mysqli_num_rows($visa)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;VISA SERVICE</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th align="left" width="16%" valign="middle" ><strong>Date</strong></th>
					<th align="left" width="13%" valign="middle" ><strong>Country</strong></th>
					<th align="left" width="13%" valign="middle" ><strong>Visa&nbsp;Name</strong></th>
					<th align="left" width="13%" valign="middle" ><strong>Visa&nbsp;Type</strong></th>
					<th align="left" width="15%" valign="middle" ><strong>Validity</strong></th>
					<th align="left" width="15%" valign="middle" ><strong>Entry&nbsp;Type</strong></th>
				</tr>
				<?php 
				while($visaQuotData=mysqli_fetch_array($visa)){
				   
					$d5=GetPageRecord('*',_VISA_TYPE_MASTER_,'id="'.$visaQuotData['visaTypeId'].'"');  
					$visaTypeData=mysqli_fetch_array($d5); 				
					?> 
				  <tr>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d M Y',strtotime($visaQuotData['visaDate']));  
						?></strong></td>
						<td valign="middle"><?php echo strip(getCountryName($visaQuotData['visaCountryId'])); ?></td>
						<td valign="middle"><?php echo strip($visaQuotData['name']); ?></td>
						<td valign="middle"><?php echo strip($visaTypeData['name']); ?></td>		
						<td valign="middle"><?php echo strip($visaQuotData['visaValidity']); ?></td>		
						<td valign="middle"><?php echo ($visaTypeData['entryType']==2)?'Multiple Entry':'Single Entry'; ?></td>		
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		<!-- <br /> -->
		<?php 
		}

	

		
		// Insurance supplement Cost
		// Insurance supplement Cost
		$insur=GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['insuranceCostType'] == 1 && mysqli_num_rows($insur)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;INSURANCE SERVICE</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th align="left" width="18%" valign="middle" ><strong>From&nbsp;Date</strong></th>
					<th align="left" width="18%" valign="middle" ><strong>To&nbsp;Date</strong></th>
					<th align="left" width="14%" valign="middle" ><strong>Country</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Insurance&nbsp;Name</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Insurance&nbsp;Type</strong></th>
				</tr>
				<?php 
				while($insQuotData=mysqli_fetch_array($insur)){
				   
					$d5=GetPageRecord('*',_INSURANCE_TYPE_MASTER_,'id="'.$insQuotData['insuranceTypeId'].'"');  
					$insTypeData=mysqli_fetch_array($d5);
					
					?> 
				  <tr>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d-m-Y',strtotime($insQuotData['insuranceStartDate']));  
						?></strong></td>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d-m-Y',strtotime($insQuotData['insuranceEndDate']));  
						?></strong></td>
						<td valign="middle"><?php echo getCountryName($insQuotData['countryId']); ?></td>
						<td valign="middle"><?php echo strip($insQuotData['name']); ?></td>
						<td valign="middle"><?php echo strip($insTypeData['name']); ?></td>		
						
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		
		<?PHP
		}
		$totalFlight= 0;
		$FLIGHTD=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['flightRequired'] == 2 && mysqli_num_rows($FLIGHTD)>0){ 
		?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;FLIGHT SERVICE</td></tr></table>
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
		<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">

			<th width="12%" valign="middle" bgcolor="#233a49"><strong>Date</strong></th>
			<th width="19%" valign="middle" bgcolor="#233a49"><strong>Sector</strong></th>
			<th width="30%" valign="middle" bgcolor="#233a49"><strong>Flight/Timings</strong></th>
			<th width="28%" valign="middle" bgcolor="#233a49"><strong>Class/Baggage</strong></th>
			<th width="11%" align="right" valign="middle" bgcolor="#233a49"><strong>Adult Cost</strong></th>
			<th width="11%" align="right" valign="middle" bgcolor="#233a49"><strong>Child Cost</strong></th>
			<th width="11%" align="right" valign="middle" bgcolor="#233a49"><strong>Infant Cost</strong></th>
		</tr>
		<?php 

		while($flightQuotData=mysqli_fetch_array($FLIGHTD)){ 
		
			$d5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');  
			$flightData=mysqli_fetch_array($d5); 

			$departurefrom = getDestination($flightQuotData['departureFrom']);
			$arrivalTo = getDestination($flightQuotData['arrivalTo']);
			?> 
		<tr>
				<td valign="middle">
				<?php 
				echo date('j M Y',strtotime($flightQuotData['fromDate']));  
				?></td>
				<td valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
				<td valign="middle"><?php echo strip($flightQuotData['flightNumber']);  
				if(!empty($flightQuotData['departureTime']) || !empty($flightQuotData['arrivalTime'])){ echo "/@".date('Hi',strtotime($flightQuotData['departureTime']))."/".date('Hi',strtotime($flightQuotData['arrivalTime']))." Hrs"; }   ?></td>		
				<td valign="middle"><?php echo strip($flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
				<td valign="middle"><div><?php echo getCurrencyName($newCurr); ?>&nbsp;<?php $flightCostA = ($flightQuotData['adultCost']+$flightQuotData['adultTax']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCostA)); ?></div></td>
				<td valign="middle"><div><?php echo getCurrencyName($newCurr); ?>&nbsp;<?php $flightCostC = ($flightQuotData['childCost']+$flightQuotData['childTax']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCostC)); ?></div></td>
				<td valign="middle"><div><?php echo getCurrencyName($newCurr); ?>&nbsp;<?php $flightCostE = ($flightQuotData['infantCost']+$flightQuotData['infantTax']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCostE)); ?></div></td>
			</tr>
		<?php 
		} ?>
		<tr>
		<td colspan="5" align="center">Air fares are subject to change at the time of booking</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>
		<!-- <br /> -->
		<?php 
		}  

}

if($_REQUEST['parts'] == 'supplementValueAddedServices'){
	// visa supplement Cost
	$visa=GetPageRecord('*',_QUOTATION_VISA_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['visaCostType'] == 0 && mysqli_num_rows($visa)>0){ 
	?> 
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;VISA SUPPLEMENT</td></tr></table>

	<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px;">
			<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="16%" valign="middle" ><strong>Date</strong></th>
				<th width="13%" valign="middle" ><strong>Visa&nbsp;Name</strong></th>
				<th width="13%" valign="middle" ><strong>Visa&nbsp;Type</strong></th>
				<th width="15%" valign="middle" ><strong>Adult&nbsp;Cost</strong></th>
				<th width="15%" valign="middle" ><strong>Child&nbsp;Cost</strong></th>
				<th width="15%" valign="middle" ><strong>Infant&nbsp;Cost</strong></th>
				<th align="right" width="13%" valign="middle" ><strong>Total&nbsp;Cost</strong></th>
			</tr>
			<?php 
			while($visaQuotData=mysqli_fetch_array($visa)){
	           
				$d5=GetPageRecord('*',_VISA_TYPE_MASTER_,'id="'.$visaQuotData['visaTypeId'].'"');  
				$visaTypeData=mysqli_fetch_array($d5); 

				$totaldAdultCost='';
				$totaldChildCost='';
				$totaldInfantCost='';
				$totaldVisaCost='';

				$pFeeA = getMarkupCost($visaQuotData['adultCost'],$visaQuotData['processingFee'],$visaQuotData['markupType']);
				$pFeeC = getMarkupCost($visaQuotData['childCost'],$visaQuotData['processingFee'],$visaQuotData['markupType']);
				$pFeeE = getMarkupCost($visaQuotData['infantCost'],$visaQuotData['processingFee'],$visaQuotData['markupType']);
				$totaldAdultCost = $visaQuotData['adultCost']+$pFeeA;
				$totaldChildCost = $visaQuotData['childCost']+$pFeeC;
				$totaldInfantCost = $visaQuotData['infantCost']+$pFeeE;
				
				$totaldVisaCost = $totaldAdultCost+$totaldChildCost+$totaldInfantCost;
				
				?> 
			  <tr>
					<td valign="middle"><strong>
					<?php 
					echo date('D,d M, Y',strtotime($visaQuotData['fromDate']));  
					?></strong></td>
					<td valign="middle"><?php echo strip($visaQuotData['name']); ?></td>
					<td valign="middle"><?php echo strip($visaTypeData['name']); ?></td>		
					<td align="right" valign="middle"><?php echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldAdultCost); ?>&nbsp;<?php if($visaQuotData['adultPax']>0){ echo 'X&nbsp;'.$visaQuotData['adultPax'];} ?></td>				
					<td align="right" valign="middle"><?php if($visaQuotData['childPax']>0){ echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldChildCost); ?>&nbsp;<?php if($visaQuotData['childPax']>0){ echo 'X&nbsp;'.$visaQuotData['childPax'];} } ?></td>
					<td align="right" valign="middle"><?php if($visaQuotData['infantPax']>0){ echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldInfantCost);  ?>&nbsp;<?php if($visaQuotData['infantPax']>0){ echo 'X&nbsp;'.$visaQuotData['infantPax'];} } ?></td>
					<td align="right" valign="middle"><?php echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldVisaCost) ?></td>
	 			</tr>
			  <?php 
			} ?>
		</table>
	</td>
	</tr>
	</table> 
	<!-- <br /> -->
	<?php 
	}   
	
		// passport supplement Cost
		$pass=GetPageRecord('*',_QUOTATION_PASSPORT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['passportCostType'] == 0 && mysqli_num_rows($pass)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;PASSPORT SUPPLEMENT</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th width="16%" valign="middle" ><strong>Date</strong></th>
					<th width="13%" valign="middle" ><strong>Passport&nbsp;Name</strong></th>
					<th width="13%" valign="middle" ><strong>Passport&nbsp;Type</strong></th>
					<th width="15%" valign="middle" ><strong>Adult&nbsp;Cost</strong></th>
					<th width="15%" valign="middle" ><strong>Child&nbsp;Cost</strong></th>
					<th width="15%" valign="middle" ><strong>Infant&nbsp;Cost</strong></th>
					<th align="right" width="13%" valign="middle" ><strong>Total&nbsp;Cost</strong></th>
				</tr>
				<?php 
				while($passQuotData=mysqli_fetch_array($pass)){
				   
					$d5=GetPageRecord('*',_PASSPORT_TYPE_MASTER_,'id="'.$passQuotData['passportTypeId'].'"');  
					$passTypeData=mysqli_fetch_array($d5); 
	
					$totaldAdultCost='';
					$totaldChildCost='';
					$totaldInfantCost='';
					$totaldPassCost='';
	
					$totaldAdultCost = $passQuotData['adultCost']*$passQuotData['adultPax'];
					$totaldChildCost = $passQuotData['childCost']*$passQuotData['childPax'];
					$totaldInfantCost = $passQuotData['infantCost']*$passQuotData['infantPax'];
					
					$totaldPassCost = $totaldAdultCost+$totaldChildCost+$totaldInfantCost;
					
					?> 
				  <tr>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d M, Y',strtotime($passQuotData['fromDate']));  
						?></strong></td>
						<td valign="middle"><?php echo strip($passQuotData['name']); ?></td>
						<td valign="middle"><?php echo strip($passTypeData['name']); ?></td>		
						<td align="right" valign="middle"><?php echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$passQuotData['adultCost']); ?>&nbsp;<?php if($passQuotData['adultPax']>0){ echo 'X&nbsp;'.$passQuotData['adultPax'];} ?></td>				
						<td align="right" valign="middle"><?php if($passQuotData['childPax']>0){ echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$passQuotData['childCost']); ?>&nbsp;<?php if($passQuotData['childPax']>0){ echo 'X&nbsp;'.$passQuotData['childPax'];} } ?></td>
						<td align="right" valign="middle"><?php if($passQuotData['infantPax']>0){ echo  getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$passQuotData['infantCost']);  ?>&nbsp;<?php if($passQuotData['infantPax']>0){ echo 'X&nbsp;'.$passQuotData['infantPax'];} } ?></td>
						<td align="right" valign="middle"><?php echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldPassCost) ?></td>
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		<!-- <br /> -->
		<?php 
		}  

		
		// Insurance supplement Cost
		$insur=GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['insuranceCostType'] == 0 && mysqli_num_rows($insur)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;INSURANCE SUPPLEMENT</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th width="18%" valign="middle" ><strong>Date</strong></th>
					<th width="11%" valign="middle" ><strong>Insurance&nbsp;Name</strong></th>
					<th width="11%" valign="middle" ><strong>Insurance&nbsp;Type</strong></th>
					<th width="16%" valign="middle" ><strong>Adult&nbsp;Cost</strong></th>
					<th width="16%" valign="middle" ><strong>Child&nbsp;Cost</strong></th>
					<th width="16%" valign="middle" ><strong>Infant&nbsp;Cost</strong></th>
					<th align="right" width="12%" valign="middle" ><strong>Total&nbsp;Cost</strong></th>
				</tr>
				<?php 
				while($insQuotData=mysqli_fetch_array($insur)){
				   
					$d5=GetPageRecord('*',_INSURANCE_TYPE_MASTER_,'id="'.$insQuotData['insuranceTypeId'].'"');  
					$insTypeData=mysqli_fetch_array($d5); 
	
					$totaldAdultCost='';
					$totaldChildCost='';
					$totaldInfantCost='';
					$totaldInsCost='';
	
					$pFeeInA = getMarkupCost($insQuotData['adultCost'],$insQuotData['processingFee'],$insQuotData['markupType']);
					$pFeeInC = getMarkupCost($insQuotData['childCost'],$insQuotData['processingFee'],$insQuotData['markupType']);
					$pFeeInE = getMarkupCost($insQuotData['infantCost'],$insQuotData['processingFee'],$insQuotData['markupType']);
	
					$totaldAdultCost = $insQuotData['adultCost']+$pFeeInA;
					$totaldChildCost = $insQuotData['childCost']+$pFeeInC;
					$totaldInfantCost = $insQuotData['infantCost']+$pFeeInE;
					
					$totaldInsCost = $totaldAdultCost+$totaldChildCost+$totaldInfantCost;
					
					?> 
				  <tr>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d M, Y',strtotime($insQuotData['fromDate']));  
						?></strong></td>
						<td valign="middle"><?php echo strip($insQuotData['name']); ?></td>
						<td valign="middle"><?php echo strip($insTypeData['name']); ?></td>		
						<td align="right" valign="middle"><?php echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldAdultCost); ?>&nbsp;<?php if($insQuotData['adultPax']>0){ echo 'X&nbsp;'.$insQuotData['adultPax'];} ?></td>				
						<td align="right" valign="middle"><?php if($insQuotData['childPax']>0){ echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldChildCost); ?>&nbsp;<?php if($insQuotData['childPax']>0){ echo 'X&nbsp;'.$insQuotData['childPax'];} } ?></td>
						<td align="right" valign="middle"><?php if($insQuotData['infantPax']>0){ echo  getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldInfantCost);  ?>&nbsp;<?php if($insQuotData['infantPax']>0){ echo 'X&nbsp;'.$insQuotData['infantPax'];} } ?></td>
						<td align="right" valign="middle"><?php echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldInsCost) ?></td>
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		<!-- <br /> -->
		<?php 
		}  
	}

	// multiple services Query detail

	if($_REQUEST['parts']=='multiServicesQuery'){


		$visa=GetPageRecord('*',_QUOTATION_VISA_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['visaCostType'] == 1 && mysqli_num_rows($visa)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;VISA SERVICE</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th align="left" width="16%" valign="middle" ><strong>Date</strong></th>
					<th align="left" width="13%" valign="middle" ><strong>Country</strong></th>
					<th align="left" width="13%" valign="middle" ><strong>Visa&nbsp;Name</strong></th>
					<th align="left" width="13%" valign="middle" ><strong>Visa&nbsp;Type</strong></th>
					<th align="left" width="15%" valign="middle" ><strong>Validity</strong></th>
					<th align="left" width="15%" valign="middle" ><strong>Entry&nbsp;Type</strong></th>
				</tr>
				<?php 
				while($visaQuotData=mysqli_fetch_array($visa)){
				   
					$d5=GetPageRecord('*',_VISA_TYPE_MASTER_,'id="'.$visaQuotData['visaTypeId'].'"');  
					$visaTypeData=mysqli_fetch_array($d5); 				
					?> 
				  <tr>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d M Y',strtotime($visaQuotData['visaDate']));  
						?></strong></td>
						<td valign="middle"><?php echo strip(getCountryName($visaQuotData['visaCountryId'])); ?></td>
						<td valign="middle"><?php echo strip($visaQuotData['name']); ?></td>
						<td valign="middle"><?php echo strip($visaTypeData['name']); ?></td>		
						<td valign="middle"><?php echo strip($visaQuotData['visaValidity']); ?></td>		
						<td valign="middle"><?php echo ($visaTypeData['entryType']==2)?'Multiple Entry':'Single Entry'; ?></td>		
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		<!-- <br /> -->
		<?php 
		}
	
		// Insurance supplement Cost
		$insur=GetPageRecord('*',_QUOTATION_INSURANCE_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['insuranceCostType'] == 1 && mysqli_num_rows($insur)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;INSURANCE SERVICE</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th align="left" width="18%" valign="middle" ><strong>From&nbsp;Date</strong></th>
					<th align="left" width="18%" valign="middle" ><strong>To&nbsp;Date</strong></th>
					<th align="left" width="14%" valign="middle" ><strong>Country</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Insurance&nbsp;Name</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Insurance&nbsp;Type</strong></th>
				</tr>
				<?php 
				while($insQuotData=mysqli_fetch_array($insur)){
				   
					$d5=GetPageRecord('*',_INSURANCE_TYPE_MASTER_,'id="'.$insQuotData['insuranceTypeId'].'"');  
					$insTypeData=mysqli_fetch_array($d5);
					
					?> 
				  <tr>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d-m-Y',strtotime($insQuotData['insuranceStartDate']));  
						?></strong></td>
						<td valign="middle"><strong>
						<?php 
						echo date('D,d-m-Y',strtotime($insQuotData['insuranceEndDate']));  
						?></strong></td>
						<td valign="middle"><?php echo getCountryName($insQuotData['countryId']); ?></td>
						<td valign="middle"><?php echo strip($insQuotData['name']); ?></td>
						<td valign="middle"><?php echo strip($insTypeData['name']); ?></td>		
						
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		<!-- <br /> -->
		<?php 
		}  

		// Flight Service Cost
		$insur=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['flightCostType'] == 0 && mysqli_num_rows($insur)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;FLIGHT SERVICE</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<!-- <th align="left" width="14%" valign="middle" ><strong>Date</strong></th> -->
					<th align="left" width="18%" valign="middle" ><strong>From</strong></th>
					<th align="left" width="18%" valign="middle" ><strong>To</strong></th>
					
					<th align="left" width="25%" valign="middle" ><strong>Flight&nbsp;Name</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Flight&nbsp;Class</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Flight&nbsp;Number</strong></th>
				
				</tr>
				<?php 
				while($insQuotData=mysqli_fetch_array($insur)){
				   	
				?> 
				  <tr>
						<!-- <td valign="middle"><strong>
						<?php 
						echo date('D,d-m-Y',strtotime($insQuotData['flightDate']));  
						?></strong></td> -->
						<td valign="middle"><strong>
						<?php echo getDestination($insQuotData['departureFrom']); ?></strong>
						</td>
						<td valign="middle"><strong>
						<?php echo getDestination($insQuotData['arrivalTo']); ?></strong>
						</td>

						<td valign="middle"><?php echo getDocketServiceName($insQuotData['flightId'],'flight'); ?></td>
						<td valign="middle"><?php echo str_replace('_',' ',$insQuotData['flightClass']); ?></td>		
						<td valign="middle"><?php echo strip($insQuotData['flightNumber']); ?></td>		
						
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		<!-- <br /> -->
		<?php 
		}

		// Train Service Cost
		$insur=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['trainRequired'] == 2 && mysqli_num_rows($insur)>0){ 
		?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;TRAIN SERVICE</td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<!-- <th align="left" width="14%" valign="middle" ><strong>Date</strong></th> -->
					<th align="left" width="18%" valign="middle" ><strong>From</strong></th>
					<th align="left" width="18%" valign="middle" ><strong>To</strong></th>
					
					<th align="left" width="25%" valign="middle" ><strong>Train&nbsp;Name</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Train&nbsp;Class</strong></th>
					<th align="left" width="25%" valign="middle" ><strong>Train&nbsp;Number</strong></th>
				
				</tr>
				<?php 
				while($insQuotData=mysqli_fetch_array($insur)){
				   	
				?> 
				  <tr>
						<!-- <td valign="middle"><strong>
						<?php 
						echo date('D,d-m-Y',strtotime($insQuotData['fromDate']));  
						?></strong></td> -->
						<td valign="middle"><strong>
						<?php echo getDestination($insQuotData['departureFrom']); ?></strong>
						</td>
						<td valign="middle"><strong>
						<?php echo getDestination($insQuotData['arrivalTo']); ?></strong>
						</td>

						<td valign="middle"><?php echo getDocketServiceName($insQuotData['trainId'],'train'); ?></td>
						<td valign="middle"><?php echo str_replace('_',' ',$insQuotData['trainClass']); ?></td>		
						<td valign="middle"><?php echo strip($insQuotData['trainNumber']); ?></td>		
						
					 </tr>
				  <?php 
				} ?>
			</table>
		</td>
		</tr>
		</table> 
		<!-- <br /> -->
		<?php 
		}
		

			// Transfer Service Cost
			$insur='';
			$insur=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
			if($resultpageQuotation['transferRequired'] == 2 && mysqli_num_rows($insur)>0){ 
			?> 
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;TRAIN SERVICE</td></tr></table>
		
			<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
			<tr>
			<td>
				<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size: 14px !important;">
					<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
						<th align="left" width="18%" valign="middle" ><strong>Date</strong></th>
						<th align="left" width="13%" valign="middle" ><strong>Destination</strong></th>
						<th align="left" width="25%" valign="middle" ><strong>Transfer&nbsp;Name</strong></th>
						<th align="left" width="14%" valign="middle" ><strong>Type</strong></th>
						
						<th align="left" width="30%" valign="middle" ><strong>Vehicle&nbsp;Type</strong></th>
						<!-- <th align="left" width="25%" valign="middle" ><strong>Train&nbsp;Number</strong></th> -->
					
					</tr>
					<?php 
					while($insQuotData=mysqli_fetch_array($insur)){
						   
					?> 
					  <tr>
							<td valign="middle"><strong>
							<?php 
							echo date('D,d-m-Y',strtotime($insQuotData['fromDate']));  
							?></strong></td>
							<td valign="middle"><strong>
							<?php echo getDestination($insQuotData['destinationId']); ?></strong>
							</td>
							<td valign="middle"><?php echo getDocketServiceName($insQuotData['transferNameId'],'transfer'); ?></td>

							<td valign="middle"><strong>
							<?php echo ($insQuotData['transferType']==1)?'SIC':'PVT'; ?></strong>
							</td>
	
							<td valign="middle"><?php echo getVehicleTypeName($insQuotData['vehicleType']); ?></td>		
							<!-- <td valign="middle"><?php echo strip($insQuotData['trainNumber']); ?></td>		 -->
							
						 </tr>
					  <?php 
					} ?>
				</table>
			</td>
			</tr>
			</table> 
			<!-- <br /> -->
			<?php 
			}
	
	}


// bank detail sec started
if($_REQUEST['parts']=="emeragencyContactDetail"){?>

<?php 


         $getdetail = GetPageRecord('*','bankMaster', 'setDefault="1" and deletestatus=0'); 
        $getbankdetail=mysqli_fetch_array($getdetail);
		$bankid=addslashes($getbankdetail['id']);
        $bankName=addslashes($getbankdetail['bankName']);
        $accountType=addslashes($getbankdetail['accountType']);
        $beneficiaryName=addslashes($getbankdetail['beneficiaryName']);
        $accountNumber=addslashes($getbankdetail['accountNumber']);
        $branchAddress=addslashes($getbankdetail['branchAddress']);
        $branchIFSC=addslashes($getbankdetail['branchIFSC']);
        $branchSwiftCode=addslashes($getbankdetail['branchSwiftCode']);
		$bankupid=addslashes($getbankdetail['bankupid']);
		$qrcodeimage=addslashes($getbankdetail['qrcodeimage']);
		$bydefshowhide=addslashes($getbankdetail['bydefshowhide']);
		
		if($bydefshowhide!=0){

?>
<div class="page-break"></div>
<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="borderedTable">
	<tr style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; font-size: 18px !important;">
	
		<td>Bank Details</td>
	</tr>
	<tr><td>

	
<table width="103%" border="1" align="center" cellpadding="12" cellspacing="0" style="margin-left: -12px;">
	<tr style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
	<th align="left" style="font-size: 14px;">Account Details</th>
	<th align="left" style="font-size: 14px;">SCAN & PAY</th>
	
	</tr>
	
	<tr style="width: 100%;">
		<td align="left" style="width: 70%;">
			<div>  
				<div class="social-media-secs">
				<p style="font-size: 18px;">
					Bank Name : <?php echo $bankName; ?> 
					<br>
					Account No. : <?php echo $accountNumber; ?><br>
					Account Name: <?php echo $beneficiaryName; ?><br>
					IFSC Code: <?php echo $branchIFSC; ?><br>
					Branch: <?php echo $branchAddress; ?><br>
					<b>UPI ID : <?php echo $bankupid; ?></b>
					</p>
				</div>
			</div>
		</td>
		<!-- <td align="left"> -->
			
		<td align="left" style="text-align: center;width: 30%;height: 150px;">

			<div class="qrcodesecpro" style="max-width: 200px;max-height: 150px;">
				<?php if($getbankdetail['qrcodeimage']!=''){ ?><img src="<?php echo $fullurl; ?>/packageimages/<?php echo $qrcodeimage; ?>" style="width: 100%;height: 150px;" /><?php } ?>
			</div>
			
	
		</td>
		<!-- </td> -->
		
	</tr>
	
</table>

</td></tr>

       
        
</table>
<?php } ?>
<br>
<br>

<?php }
// bank detail sec started

// social media links 
if($_REQUEST['parts']=="emeragencyContactDetail"){

	$rsem1 = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,' contactPerson!="" order by id desc');
		$emData1 = mysqli_fetch_assoc($rsem1);
		$showhideval = $emData1['socialmediadtlshow'];
		if($showhideval !=0){
	?>
	<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="borderedTable">
		<tr style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; font-size: 18px !important;">
		
			<td>Click the below icon to check us out in the Social World</td>
		</tr>
		<?php 
			 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
			 while($emData = mysqli_fetch_assoc($rsem)){
		?>
		<tr style="width: 100%;display: flex;height: 100px;">
			<td style="display: flex; width: 24%;">
			
				
				<a target="_blank" href="<?php echo $emData['faceurl']; ?>" style="">
					<img style="width: 50px;height: 50px;position: relative;top: 0px;left: 40px;" src="<?php echo $fullurl; ?>/images/facebook-sm.png">
					<h4 style="position: relative;top: -50%;font-size: 28px;left: 0%;"><?php echo $emData['facename']; ?></h4>
				</a>
				
			</td>
			<td style="display: flex; width: 24%;">
			
				
				<a target="_blank" href="<?php echo $emData['twitterurl']; ?>" style="">
					<img style="width: 50px;height: 50px;position: relative;top: 0px;left: 40px;" src="<?php echo $fullurl; ?>/images/twitter-sm.png">
					<h4 style="position: relative;top: -50%;font-size: 28px;left: 18%;"><?php echo $emData['twittername']; ?></h4>
				</a>
				
			</td>
			<td style="display: flex; width: 24%;">
			
				
				<a target="_blank" href="<?php echo $emData['instaurl']; ?>" style="">
					<img style="width: 50px;height: 50px;position: relative;top: 0px;left: 40px;" src="<?php echo $fullurl; ?>/images/instagram-sm.png">
					<h4 style="position: relative;top: -50%;font-size: 28px;left: 0%;"><?php echo $emData['instaname']; ?></h4>
				</a>
				
			</td>
			<td style="display: flex; width: 24%;">
			
				
				<a target="_blank" href="<?php echo $emData['linkurl']; ?>" style="">
					<img style="width: 50px;height: 50px;position: relative;top: 0px;left: 40px;" src="<?php echo $fullurl; ?>/images/linkedin-sm.png">
					<h4 style="position: relative;top: -50%;font-size: 28px;left: 24%;"><?php echo $emData['linkname']; ?></h4>
				</a>
				
			</td>
			<td style="display: flex; width: 24%;">
			
				
				<a target="_blank" href="<?php echo $emData['youtubeurl']; ?>" style="">
					<img style="width: 50px;height: 50px;position: relative;top: 0px;left: 40px;" src="<?php echo $fullurl; ?>/images/youtube-sm.png">
					<h4 style="position: relative;top: -50%;font-size: 28px;left: 15%;"><?php echo $emData['youtubename']; ?></h4>
				</a>
				
			</td>
		</tr>

		<?php } ?> 
	</table>
	
	<?php
		}
	}
	// social media links sec ended
	

// Emergency Contact Information 


if($_REQUEST['parts']=="emeragencyContactDetail"){

$rsem1 = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,' contactPerson!="" order by id desc');
	$emData1 = mysqli_fetch_assoc($rsem1);
	$showhideval = $emData1['contactdddttl'];
	if($showhideval!=0){
?>
<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="borderedTable">
	<tr style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; font-size: 18px !important;">
	
		<td><?php echo $emData1['emergencyHeading']; ?></td>
	</tr>
	<tr><td>
<table width="103%" border="1" align="center" cellpadding="10" cellspacing="0" style="margin-left: -12px;">

		<tr style="position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
			<th align="left" style="font-size: 14px;">Contact Person Name</th>
			<th align="left" style="font-size: 14px;">Country Code</th>
			<th align="left" style="font-size: 14px;">Mobile Number</th>
			<th align="left" style="font-size: 14px;">Email Address</th>
			<th align="left" style="font-size: 14px;">Available On</th>
		</tr>
	<?php
	 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
	while($emData = mysqli_fetch_assoc($rsem)){
	
	?>

	<tr>
		<td align="left"><?php echo $emData['contactPerson']; ?></td>
		<td align="left"><?php echo $emData['countryCode']; ?></td>
		<td align="left"><?php echo $emData['phone']; ?></td>
		<td align="left"><?php echo $emData['email']; ?></td>
		<td align="left"><?php echo $emData['availableOn']; ?></td>
	</tr>


	<?php } ?>
</table>
</td></tr>
</table>
<?php
	}
}


?>