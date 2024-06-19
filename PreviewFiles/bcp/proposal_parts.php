<?php 
$select='*';
$where='id="'.$queryId.'"';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
$queryData=mysqli_fetch_array($rs);

$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"');
$quotationData=mysqli_fetch_array($rsp);

$serviceTax = $quotationData['serviceTax'];
$quotationId=$quotationData['id'];
$queryId=$quotationData['queryId'];


$c12='';
$c12=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationData['id'].'"'); 
$serviceMarkupD = mysqli_fetch_array($c12); 

if($quotationData['isUni_Mark'] == 0 && $quotationData['isSer_Mark'] == 1 ){  
    $hotelM = $serviceMarkupD['hotel'];
    $transferM = $serviceMarkupD['transfer'];
    $trainM = $serviceMarkupD['train'];
    $flightM = $serviceMarkupD['flight'];
    $guideM = $serviceMarkupD['guide'];
    $activityM = $serviceMarkupD['activity'];
    $entranceM = $serviceMarkupD['entrance'];
    $restaurantM = $serviceMarkupD['restaurant'];
    $otherM = $serviceMarkupD['other']; 

    $markupType = $serviceMarkupD['markupType']; 
    
}else{
	
    $serviceMarkup = $serviceMarkupD['hotel'];
	$hotelM = $serviceMarkup; 
	$transferM = $serviceMarkup; 
	$trainM = $serviceMarkup; 
	$flightM = $serviceMarkup; 
	$guideM = $serviceMarkup; 
	$activityM = $serviceMarkup; 
	$entranceM = $serviceMarkup;
	$restaurantM = $serviceMarkup;
	$otherM = $serviceMarkup;  

    $markupType = $serviceMarkupD['markupType'];
}

$isUni_Mark = 1;


if($_REQUEST['parts'] == 'hotelSupplement'){
	$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationData['id'].'" ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplementHotelStatus=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0){
		?>
		<div  class='serviceTitle' style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Hotel/Room Supplement</div>
		<table width="100%" border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service"  >
			<tr height="18" style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
			<td colspan="7" align="right">Note: All the Cost is per person with inclusive tax and markup <strong>(In <?php echo getCurrencyName($quotationData['currencyId']); ?>)</strong></td>
			</tr>
			<tr height="18" style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
			<th width="8%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;">Day</th>
			<th width="15%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;">Destination</th>
			<th width="22%" align="center" bgcolor="#133f6d" style="color:#ffffff;">Supplement&nbsp;/ Reduction </th>
			<th width="12%" align="center" bgcolor="#133f6d" style="color:#ffffff;">Single</th>
			<th width="13%" align="center" bgcolor="#133f6d" style="color:#ffffff;">Double</th>
			<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;">Extra&nbsp;Bed<br>(Adult)</th>
			<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;">Extra&nbsp;Bed<br>(Child)</th>
			</tr>
			<?php 
			$day2=1;
			
		    $QueryDaysQuery2=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus=0 order by srdate asc');
			while($suppDaysData=mysqli_fetch_array($QueryDaysQuery2)){  
		 		$dayDate2 = date('Y-m-d', strtotime($suppDaysData['srdate']));
				$dayId2 = $suppDaysData['id'];

				$normalHotelQuery="";
				$normalHotelQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplementHotelStatus!=1 and isGuestType=1 and fromDate="'.$dayDate2.'"');
		 		if(mysqli_num_rows($normalHotelQuery) > 0){

					$normalQuotData=mysqli_fetch_array($normalHotelQuery);

					$normalRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$normalQuotData['roomType'].'"');
					$normalRoomTypeD=mysqli_fetch_array($normalRoomTypeQuery);
					$normalRoomType = trim($normalRoomTypeD['name']);

					$normalMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$normalQuotData['mealPlan'].'"');
					$normalMealPlanD=mysqli_fetch_array($normalMealPlanQuery);
					$normalMealPlan = strtoupper($normalMealPlanD['name']);

					$hotelQuery="";
					$hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$normalQuotData['supplierId'].'" ');
					$hotelData=mysqli_fetch_array($hotelQuery);
					$hotelName = $hotelData['hotelName'];
					
					
					$mainSingle=$mainDouble=$mainEBedA=$mainEBedC=0;

					$mainSingle = ($normalQuotData['singleoccupancy']);
					$mainSingle = getPerPersonBasisCost($mainSingle,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);

					$mainDouble= ($normalQuotData['doubleoccupancy']/2);
					$mainDouble = getPerPersonBasisCost($mainDouble,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);

					$mainEBedA= ($normalQuotData['extraBed']);
					$mainEBedA = getPerPersonBasisCost($mainEBedA,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);

					$mainEBedC= ($normalQuotData['childwithbed']);
					$mainEBedC = getPerPersonBasisCost($mainEBedC,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);

					$suppRoomQuery="";
					$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" and supplierId="'.$normalQuotData['supplierId'].'" ');
					$mainRoomSupp = 0;
					if(mysqli_num_rows($suppRoomQuery) > 0){

						$mainRoomSupp = 1;
						$suppRoomData=mysqli_fetch_array($suppRoomQuery);

						$suppRoomRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$suppRoomData['roomType'].'"');
						$suppRoomRoomTypeD=mysqli_fetch_array($suppRoomRoomTypeQuery);
						$suppRoomRoomType = trim($suppRoomRoomTypeD['name']);

						$suppRoomMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$suppRoomData['mealPlan'].'"');
						$suppRoomMealPlanD=mysqli_fetch_array($suppRoomMealPlanQuery);
						$suppRoomMealPlan = strtoupper($suppRoomMealPlanD['name']);

						$mainRoomSingle=$mainRoomDouble=$mainRoomEBedA=0;

						$mainRoomSingle = ($suppRoomData['singleoccupancy']);
						$mainRoomSingle = getPerPersonBasisCost($mainRoomSingle,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$mainRoomSingle = $mainRoomSingle-$mainSingle;

						$mainRoomDouble= ($suppRoomData['doubleoccupancy']/2);
						$mainRoomDouble = getPerPersonBasisCost($mainRoomDouble,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$mainRoomDouble = $mainRoomDouble-$mainDouble;

						$mainRoomEBedA= ($suppRoomData['extraBed']);
						$mainRoomEBedA = getPerPersonBasisCost($mainRoomEBedA,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$mainRoomEBedA = $mainRoomEBedA-$mainEBedA;

						$mainRoomEBedC= ($suppRoomData['childwithbed']);
						$mainRoomEBedC = getPerPersonBasisCost($mainRoomEBedC,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$mainRoomEBedC = $mainRoomEBedC-$mainEBedC;

						if($mainRoomSingle > 0 && $mainRoomDouble > 0){
							$red_supp = "Upgrade ";
						}else{
							$red_supp = "Reduction ";
						}

						?>
						<tr height="18">
						<td align="center" ><strong>D<?php echo str_pad($day2, 2, '0', STR_PAD_LEFT); ?></strong></td>
						<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
						<td align="left"><?php echo $suppInfo = $red_supp."for '".$hotelName."' '".$suppRoomRoomType."'('".$suppRoomMealPlan."') in place of '".$normalRoomType."'('".$normalMealPlan."') for per night per room."; ?></td>
						<td align="center">
						  <?php  echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomSingle)); ?>
						  </td>
						<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomDouble)); ?></td>
						<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomEBedA)); ?></td>
						<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomEBedC)); ?></td>
						</tr>
						<?php
					}

					
					$suppHotelQuery="";
					$suppHotelQuery=GetPageRecord('*, count(id) as nights','quotationHotelMaster','quotationId="'.$quotationId.'" and fromDate="'.$dayDate2.'" and supplementHotelStatus=1 and isGuestType=0 group by supplierId order by id asc');
					$suppQuotData=mysqli_fetch_array($suppHotelQuery);
					if($suppQuotData['nights'] > 0){

						$nights = $suppQuotData['nights'];

						$hotelQuery2="";
						$hotelQuery2=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$suppQuotData['supplierId'].'" ');
						$hotelData2=mysqli_fetch_array($hotelQuery2);
						$hotelName2 = $hotelData2['hotelName'];

						$suppQuotRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$suppQuotData['roomType'].'"');
						$suppQuotRoomTypeD=mysqli_fetch_array($suppQuotRoomTypeQuery);
						$suppQuotRoomType = trim($suppQuotRoomTypeD['name']);

						$suppQuotMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$suppQuotData['mealPlan'].'"');
						$suppQuotMealPlanD=mysqli_fetch_array($suppQuotMealPlanQuery);
						$suppQuotMealPlan = strtoupper($suppQuotMealPlanD['name']);

						$suppQuotSingle=$suppQuotDouble=$suppQuotEBedA=$suppQuotEBedC=0;

						$suppQuotSingle = ($suppQuotData['singleoccupancy']);
						$suppQuotSingle = getPerPersonBasisCost($suppQuotSingle,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$suppQuotSingle = $suppQuotSingle-$mainSingle;
						
						$suppQuotDouble= ($suppQuotData['doubleoccupancy']/2);
						$suppQuotDouble = getPerPersonBasisCost($suppQuotDouble,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$suppQuotDouble = $suppQuotDouble-$mainDouble;

						$suppQuotEBedA= ($suppQuotData['extraBed']);
						$suppQuotEBedA = getPerPersonBasisCost($suppQuotEBedA,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$suppQuotEBedA = $suppQuotEBedA-$mainEBedA;

						$suppQuotEBedC= ($suppQuotData['childwithbed']);
						$suppQuotEBedC = getPerPersonBasisCost($suppQuotEBedC,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
						$suppQuotEBedC = $suppQuotEBedC-$mainEBedC;

						if($suppQuotSingle > 0 && $suppQuotDouble > 0){
							$red_supp = "Upgrade ";
						}else{
							$red_supp = "Reduction ";
						}

						?>
						<tr height="18">
						<td align="center" ><strong>
					    <?php if($mainRoomSupp!=1){ echo "D".str_pad($day2, 2, '0', STR_PAD_LEFT); } ?>
						  </strong></td>
						<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
						<td align="left"><?php echo $suppInfo = $red_supp."for '".$hotelName2."' '".$suppQuotRoomType."'(".$suppQuotMealPlan.") in place of '".$hotelName."' '".$normalRoomType."'('".$normalMealPlan."') for per night per room."; ?></td>
						<td align="center">
						  <?php
						echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotSingle)); ?>
						  </td>
						<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotDouble)); ?></td>
						<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotEBedA)); ?></td>
						<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotEBedC)); ?></td>
						</tr>
						<?php

						$suppRoomQuery="";
						$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" and supplierId="'.$suppQuotData['supplierId'].'" and dayId="'.$suppDaysData['id'].'"');
						if(mysqli_num_rows($suppRoomQuery) > 0){

							$suppRoomData2=mysqli_fetch_array($suppRoomQuery);

							$suppRoomRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$suppRoomData2['roomType'].'"');
							$suppRoomRoomTypeD=mysqli_fetch_array($suppRoomRoomTypeQuery);
							$suppRoomRoomType = trim($suppRoomRoomTypeD['name']);

							$suppRoomMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$suppRoomData2['mealPlan'].'"');
							$suppRoomMealPlanD=mysqli_fetch_array($suppRoomMealPlanQuery);
							$suppRoomMealPlan = strtoupper($suppRoomMealPlanD['name']);

							$suppRoomSingle=$suppRoomDouble=$suppRoomEBedA=$suppRoomEBedC=0;

							$suppRoomSingle = ($suppRoomData2['singleoccupancy']);
							$suppRoomSingle = getPerPersonBasisCost($suppRoomSingle,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
							$suppRoomSingle = $suppRoomSingle-$suppQuotSingle;
							
							$suppRoomDouble= ($suppRoomData2['doubleoccupancy']/2);
							$suppRoomDouble = getPerPersonBasisCost($suppRoomDouble,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
							$suppRoomDouble = $suppRoomDouble-$suppQuotDouble;
							
							$suppRoomEBedA= ($suppRoomData2['extraBed']);
							$suppRoomEBedA = getPerPersonBasisCost($suppRoomEBedA,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
							$suppRoomEBedA = $suppRoomEBedA-$suppQuotEBedA;
								
							$suppRoomEBedC= ($suppRoomData2['childwithbed']);
							$suppRoomEBedC = getPerPersonBasisCost($suppRoomEBedC,$hotelM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
							$suppRoomEBedC = $suppRoomEBedC-$suppQuotEBedC;
							
							if($suppRoomSingle > 0 && $suppRoomDouble > 0){
								$red_supp = "Upgrade ";
							}else{
								$red_supp = "Reduction ";
							}
							?>
							<tr height="18">
							<td align="center" ><strong>&nbsp;</strong></td>
							<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
							<td align="left"><?php echo $suppInfo = $red_supp."for '".$hotelName2."' '".$suppRoomRoomType."'('".$suppRoomMealPlan."') in place of '".$suppQuotRoomType."'('".$suppQuotMealPlan."') for per night per room."; ?></td>

							<td align="center">
							  <?php
							echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomSingle)); ?>
							  </td>
							<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomDouble)); ?></td>
							<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomEBedA)); ?></td>
							<td align="center"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomEBedC)); ?></td>
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

if($_REQUEST['parts'] == 'transferSupplement'){
	$checkSuppTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=1 and serviceType="transfer" ');
	if(mysqli_num_rows($checkSuppTQuery) > 0){
		?>

		<div class='serviceTitle' style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Transfer Supplement </div>
		<table width="100%" border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service">
			<tr height="18" style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<td colspan="7" align="right">Note: All the Cost with inclusive tax and markup <strong>(In <?php echo getCurrencyName($quotationData['currencyId']); ?>)</strong></td>
			</tr>
			<tr height="18" style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="10%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;">Day</th>
				<th width="15%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;">Destination</th>
				<th width="60%" align="left" bgcolor="#133f6d" style="color:#ffffff;">Supplement&nbsp;/ Reduction </th>
				<th width="15%" align="right" bgcolor="#133f6d" style="color:#ffffff;">Service Cost</th>
			</tr>
			<?php

			$TRFDaysQuery2=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus = 0 order by srdate asc');
			$day2=1;
			while($suppDaysData=mysqli_fetch_array($TRFDaysQuery2)){  
		 		$dayDate2 = date('Y-m-d', strtotime($suppDaysData['srdate']));
				$dayId2 = $suppDaysData['id'];

				$normalTRFQuery="";
				$normalTRFQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=0 and isGuestType=1 and fromDate="'.$dayDate2.'" and serviceType="transfer"');
		 		if(mysqli_num_rows($normalTRFQuery) > 0){

					while($normalQuotData=mysqli_fetch_array($normalTRFQuery)){
			 			
			 			$transferName ='';
						$transportQuery="";
						$transportQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$normalQuotData['transferNameId'].'"');
						$transferData=mysqli_fetch_array($transportQuery);
						$transferName = $transferData['transferName'];
						
						$vehicleModelQuery='';
						$vehicleModelQuery=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$normalQuotData['vehicleModelId'].'"');
						$carData=mysqli_fetch_array($vehicleModelQuery);
						$carType = getVehicleTypeName($carData['carType']); 
						$vehicleName = ($carData['model']); 

						$mainTRFCost=0;
						$mainTRFCost = ($normalQuotData['vehicleCost']);
						$mainTRFCost = getPerPersonBasisCost($mainTRFCost,$transferM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
			  
						$suppHotelQuery="";
						$suppHotelQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and fromDate="'.$dayDate2.'" and isSupTPTType=1 and isGuestType=0 and serviceType="transfer" order by id asc');
						if(mysqli_num_rows($suppHotelQuery) > 0){

							$suppQuotData=mysqli_fetch_array($suppHotelQuery);

							$transportQuery2="";
							$transportQuery2=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$suppQuotData['transferNameId'].'" ');
							$transportData2=mysqli_fetch_array($transportQuery2);
							$transferName2 = $transportData2['transferName'];


							$vmQuery2='';
							$vmQuery2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$suppQuotData['vehicleModelId'].'"');
							$carData2=mysqli_fetch_array($vmQuery2);
							$carType2 = getVehicleTypeName($carData2['carType']); 
							$vehicleName2 = ($carData2['model']); 

							$supTRFCost=0;

							$supTRFCost = ($suppQuotData['vehicleCost']);
							$supTRFCost = getPerPersonBasisCost($supTRFCost,$transferM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
							$diffCost = $supTRFCost-$mainTRFCost;
							
							if($diffCost > 0 ){
								$red_supp = "Upgrade ";
							}else{
								$red_supp = "Reduction ";
							} 
							echo $transferM.'='.$markupType;
							?>
							<tr height="18">
							<td align="center" ><strong>
						    <?php echo "D".str_pad($day2, 2, '0', STR_PAD_LEFT);  ?>
							  </strong></td>
							<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
							<td align="left"><?php echo $red_supp."for ".$transferName2." (".$vehicleName2.") in place of ".$transferName." (".$vehicleName.")."; ?></td>
							<td align="center">
							  <?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$diffCost)); ?>
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

if($_REQUEST['parts'] == 'transferSupplement'){
	$checkSuppT2Query=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=1 and serviceType="transportation" ');
	if(mysqli_num_rows($checkSuppT2Query) > 0){
		?>
		<div class='serviceTitle' style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Transportation Supplement </div>
		<table width="100%" border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service">
			<tr height="18" style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<td colspan="7" align="right">Note: All the Cost with inclusive tax and markup <strong>(In <?php echo getCurrencyName($quotationData['currencyId']); ?>)</strong></td>
			</tr>
			<tr height="18" style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="10%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;">Day</th>
				<th width="15%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;">Destination</th>
				<th width="60%" align="left" bgcolor="#133f6d" style="color:#ffffff;">Supplement&nbsp;/ Reduction </th>
				<th width="15%" align="right" bgcolor="#133f6d" style="color:#ffffff;">Service Cost</th>
			</tr>
			<?php

			$TPTDaysQuery2=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus = 0 order by srdate asc');
			$day2=1;
			while($suppDaysData=mysqli_fetch_array($TPTDaysQuery2)){  
		 		$dayDate2 = date('Y-m-d', strtotime($suppDaysData['srdate']));
				$dayId2 = $suppDaysData['id'];

				$normalTPTQuery="";
				$normalTPTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=0 and isGuestType=1 and fromDate="'.$dayDate2.'" and serviceType="transportation"');
		 		if(mysqli_num_rows($normalTPTQuery) > 0){

					while($normalQuotData=mysqli_fetch_array($normalTPTQuery)){
			 			
			 			$transferName ='';

						$transportQuery="";
						$transportQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$normalQuotData['transferNameId'].'"');
						$transferData=mysqli_fetch_array($transportQuery);
						$transferName = $transferData['transferName'];
						
						$vehicleModelQuery='';
						$vehicleModelQuery=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$normalQuotData['vehicleModelId'].'"');
						$carData=mysqli_fetch_array($vehicleModelQuery);
						$carType = getVehicleTypeName($carData['carType']); 
						$vehicleName = ($carData['model']); 

						$mainTPTCost=0;
						$mainTPTCost = ($normalQuotData['vehicleCost']);
						$mainTPTCost = getPerPersonBasisCost($mainTPTCost,$transferM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark);
			  
						$suppHotelQuery="";
						$suppHotelQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and fromDate="'.$dayDate2.'" and isSupTPTType=1 and isGuestType=0 and serviceType="transportation" order by id asc');
						if(mysqli_num_rows($suppHotelQuery) > 0){

							$suppQuotData=mysqli_fetch_array($suppHotelQuery);

							$transportQuery2="";
							$transportQuery2=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$suppQuotData['transferNameId'].'" ');
							$transportData2=mysqli_fetch_array($transportQuery2);
							$transferName2 = $transportData2['transferName'];


							$vmQuery2='';
							$vmQuery2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$suppQuotData['vehicleModelId'].'"');
							$carData2=mysqli_fetch_array($vmQuery2);
							$carType2 = getVehicleTypeName($carData2['carType']); 
							$vehicleName2 = ($carData2['model']); 

							$supTPTCost=0;

							$supTPTCost = ($suppQuotData['vehicleCost']);
							$supTPTCost = getPerPersonBasisCost($supTPTCost,$transferM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 
							$diffCost = $supTPTCost-$mainTPTCost;
							
							if($diffCost > 0 ){
								$red_supp = "Upgrade ";
							}else{
								$red_supp = "Reduction ";
							} 
							?>
							<tr height="18">
							<td align="center" ><strong>
						    <?php echo "D".str_pad($day2, 2, '0', STR_PAD_LEFT);  ?>
							  </strong></td>
							<td align="center" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
							<td align="left"><?php echo $red_supp."for ".$transferName2." (".$vehicleName2.") in place of ".$transferName." (".$vehicleName.")."; ?></td>
							<td align="center">
							  <?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$diffCost)); ?>
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
		<br>
		<div class='serviceTitle'>Additional Experience </div>
		<table width="100%" border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service">
			<tr height="18" style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th align="left"><strong>Service&nbsp;Type </strong></th>
				<th width="50%" align="left"><strong>Name</strong></th>
				<th align="center"><strong>Adult&nbsp;Cost(PP)</strong></th>
				<th align="center"><strong>Child&nbsp;Cost(PP)</strong></th>
				<th align="center"><strong>Group&nbsp;Cost</strong></th>
			</tr>
			<?php
			while($additionalIdData=mysqli_fetch_array($checkadditionalQuery)){	
					
				if($additionalIdData['serviceType']=='Activity'){
				
					$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
					while($activityData=mysqli_fetch_array($rsAct)){	
						$c121=GetPageRecord('*','packageBuilderotherActivityMaster',' id in ( select otherActivityNameId from dmcotherActivityRate where id="'.$activityData['additionalId'].'" ) order by id asc'); 
						$activityDataName=mysqli_fetch_array($c121);

						$adultCost = $adultCost = $groupCost = 0;
						$adultCost = $activityData['adultCost'];
						$childCost = $activityData['adultCost'];

						$adultCost = getPerPersonBasisCost($adultCost,$activityM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 
						$childCost = getPerPersonBasisCost($childCost,$activityM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 

						?>
						<tr id="addnl<?php echo $activityData['id'];?>">
						 <td width="99" align="left"><?php echo $activityData['serviceType'];?></td>
						<td align="left"><?php echo ucwords($activityDataName['otherActivityName']); ?></td>
						<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td>
						<td width="80" align="center">&nbsp;</td>
						</tr>
						<?php 
					}
				}
				
				
				if($additionalIdData['serviceType']=='Guide'){
					
					$rsAct=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.$quotationId.'" and serviceType="'.$additionalIdData['serviceType'].'" order by id desc'); 
					while($guideData=mysqli_fetch_array($rsAct)){	
						$c121=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id in (select serviceid from dmcGuidePorterRate where id="'.$guideData['additionalId'].'") order by id asc'); 
						$guideDataName=mysqli_fetch_array($c121);

						$adultCost = $adultCost = $groupCost = 0;
						$adultCost = $guideData['adultCost'];
						$childCost = $guideData['adultCost'];
						
						$adultCost = getPerPersonBasisCost($adultCost,$guideM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 
						$childCost = getPerPersonBasisCost($childCost,$guideM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 


						?>
						<tr id="addnl<?php echo $guideData['id'];?>">
						 <td align="left"><?php echo $guideData['serviceType'];?></td>
						<td align="left"><?php echo ucwords($guideDataName['name']);?> </td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
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
							$c121=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entranceData['entranceId'].'"'); 
							$entranceDataName=mysqli_fetch_array($c121);	
						}

						$adultCost = $adultCost = $groupCost = 0;
						$adultCost = $entranceData['adultCost'];
						$childCost = $entranceData['childCost'];
						
						$adultCost = getPerPersonBasisCost($adultCost,$entranceM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 
						$childCost = getPerPersonBasisCost($childCost,$entranceM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 


						?>
						<tr id="addnl<?php echo $entranceData['id'];?>">
						<td width="99" align="left"><?php echo $entranceData['serviceType'];?></td>
						<td width="179" align="left"><?php echo ucwords($entranceDataName['entranceName']);?></td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
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

						$adultCost = $adultCost = $groupCost = 0;
						$adultCost = $restaurntData['adultCost'];
						$childCost = $restaurntData['childCost'];
						
						$adultCost = getPerPersonBasisCost($adultCost,$restaurantM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 
						$childCost = getPerPersonBasisCost($childCost,$restaurantM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 


						?>
						<tr id="addnl<?php echo $restaurntData['id'];?>">
						<td width="80" align="left"><?php echo $restaurntData['serviceType'];?></td>
						<td width="200" align="left"><?php echo ucwords($mealPlanData2['mealPlanName']);?></td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
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


						$adultCost = $adultCost = $groupCost = 0;
						$adultCost = $additionalData2['adultCost'];
						$childCost = $additionalData2['adultCost'];
						$groupCost = $additionalData2['groupCost'];
						
						$adultCost = getPerPersonBasisCost($adultCost,$otherM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 
						$childCost = getPerPersonBasisCost($childCost,$otherM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 
						$groupCost = getPerPersonBasisCost($groupCost,$otherM,$markupType,$discount,$discountType,$serviceTax,$isUni_Mark); 


						?>
						<tr id="addnl<?php echo $additionalData2['id'];?>">
						<td width="80" align="left"><?php echo $additionalData2['serviceType'];?></td>
						<td width="200" align="left"><?php echo ucwords($addislanData2['name']);?></td>
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$adultCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$childCost;?></td> 
						<td width="80" align="center"><?php echo getCurrencyName($baseCurrencyId)." ".$groupCost;?></td>
						</tr>
						<?php 
					}
				}	
			}
			?>
		</table> 
		<br>
		<?php 
	} 
} 
if($_REQUEST['parts'] == 'costingDetailSingleHotelCateogrynotinuse'){
	?>
	<div class="table-service pd30" style="page-break-after: never;"><?php

	    $singleRoom = $defaultSlabData['sglRoom'];
	    $doubleRoom = $defaultSlabData['dblRoom'];
	    $tripleRoom = $defaultSlabData['tplRoom'];
	    $twinRoom  = $defaultSlabData['twinRoom'];
	    $EBedAdult = $defaultSlabData['extraNoofBed'];
	    $EBedChild = $defaultSlabData['childwithNoofBed'];
	    $NBedChild = $defaultSlabData['childwithoutNoofBed'];


		// $singleRoom = $quotationData['sglRoom'];
		// $doubleRoom = $quotationData['dblRoom'];
		// $tripleRoom = $quotationData['tplRoom'];
		// $twinRoom   = $quotationData['twinRoom'];
		// $EBedAdult = $quotationData['extraNoofBed'];
		// $EBedChild = $quotationData['childwithNoofBed'];
		// $NBedChild = $quotationData['childwithoutNoofBed'];

		$conspan = 0;
		if($singleRoom>0){ $conspan=$conspan+1; }
		if($doubleRoom>0 || $tripleRoom>0){ $conspan=$conspan+1; }
		if($tripleRoom>0){ $conspan=$conspan+1; }
		if($EBedAdult>0){ $conspan=$conspan+1; }
		if($EBedChild>0){ $conspan=$conspan+1; }
		if($NBedChild>0){ $conspan=$conspan+1; }
		$colsWidth = 80/$conspan;
		?>
		<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service" style="page-break-after: auto;page-break-before: auto;width: 100%;"> 
			<tr style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="20%" align="right" <?php if($conspan>0){ ?> rowspan="2" <?php } ?> valign="middle"><strong>Total&nbsp;Cost<br>(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></th>
				<?php if($conspan>0){ ?>
				<th width="80%" colspan="<?php echo $conspan; ?>" align="center" valign="middle" ><strong>Per Person Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
				<?php } ?>
			</tr>
			<?php if($conspan>0){ ?>
			<tr style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<?php if($singleRoom>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Single Basis</strong></th>
				<?php } if($doubleRoom>0 || $tripleRoom>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Double Basis</strong></th>
				<?php } if($tripleRoom>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>Triple Basis</strong></th>
				<?php } if($EBedAdult>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>E.Bed(Adult) Basis</strong></th>
				<?php } if($EBedChild>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>CWB Basis</strong></th>
				<?php } if($NBedChild>0){ ?>
				<th width="<?php echo $colsWidth; ?>%" valign="middle"><strong>CNB Basis</strong></th>
				<?php } ?>
			</tr>
			<?php } ?>
			<tr>
				<td valign="middle">
					<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
				</td>
				<?php if($singleRoom>0){ ?>
				<td valign="middle">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
				</td>
				<?php } if($doubleRoom>0 || $tripleRoom>0){ ?>
				<td valign="middle">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
				</td>
				<?php } if($tripleRoom>0){ ?>
				<td valign="middle">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnTripleBasis)); ?>
				</td>
				<?php } if($EBedAdult>0){ ?>
				<td valign="middle">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnExtraBedABasis)); ?>
				</td>
				<?php } if($EBedChild>0){ ?>
				<td valign="middle">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
				</td>
				<?php } if($NBedChild>0){ ?>
				<td valign="middle">
						<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraNBedCBasis)); ?>
				</td>
				<?php } ?>
			</tr>
		</table>
	</div>  
	<br>
	<?php 
}
if($_REQUEST['parts'] == 'costingDetail'){
	?>
	<!-- start Costing table -->
	<div class="table-service pd30">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" align="center" >
			<?php if($resultpageQuotation['quotationType']==2){  ?>
				<table width="100%" border="1" cellspacing="0" cellpadding="6" bordercolor="#ccc" class="borderedTable">
					<?php
					if($resultpage['seasonType'] == 3){
						$colm = 2;
					}else{
						$colm = 1;
					}
					$hotCategory2 = explode(',',$resultpageQuotation['hotCategory']);
					// echo $resultpageQuotation['id'];
					$widttth = count($hotCategory2);
					$widths = 100/($colm*$widttth+1);
					$widths2 = $widths*$widttth;
					$colm1 = ($colm*$widttth+1);
					?>
					<!-- multiple category related prices -->
					<tr bgcolor="#F4F4F4">
						<th colspan="<?php echo $colm1; ?>" align="center" >Price based on selected room basis (In <?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>)</th>
					</tr>
					<tr bgcolor="#F4F4F4">
						<th width="<?php echo $widths; ?>%" rowspan="2"  align="center" >
							No. of Pax
						</th>
						<?php
						for ($i = 1; $i <= $colm; $i++) { 
							if($resultpage['seasonType'] == 1 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  }
							if($resultpage['seasonType'] == 2 && $i == 1){ $seasonPeriod = "01 Oct - 31 March"; }
							if($resultpage['seasonType'] == 3 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  }
							else { $seasonPeriod = date('j M ',strtotime($resultpage['fromDate']))." - ".date('j M Y',strtotime($resultpage['toDate'])); }
							?>
							<th width="<?php echo $widths2; ?>%" colspan="<?php echo count($hotCategory2);?>" align="center">Validity&nbsp;[&nbsp;<?php echo $seasonPeriod; ?>]</th>
							<?php
						}
						?>
					</tr>
					<tr bgcolor="#F4F4F4"> 
						<?php
						for ($i = 1; $i <= $colm; $i++) {
							foreach($hotCategory2 as $val2){
							$rsname1=GetPageRecord('*','hotelCategoryMaster','id="'.$val2.'"');
							$hotelCatData1=mysqli_fetch_array($rsname1);
							$hotelCategory = $hotelCatData1['hotelCategory'].' Star';
							?>
							<th width="<?php echo $widths; ?>%"  align="right"><?php echo $hotelCategory; ?></th>
							<?php
							}
						}
						?>
					</tr>
					<?php
					$rsn=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and country!=0 and status=1 and setDefault= 1');
					$resListingnn=mysqli_fetch_array($rsn);
					if($resListingnn['id'] == '' || $resListingnn['id'] == 0){
						$defaultCurr = 1;
					}else{
						$defaultCurr = $resListingnn['id'];
					}
					if($resultpageQuotation['currencyId'] == '' && $resultpageQuotation['currencyId'] == 0 ){
						$newCurr = $defaultCurr;
					}else{
						$newCurr = $resultpageQuotation['currencyId'];
					}
					
					$slabSql=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1 order by fromRange asc');
					if(mysqli_num_rows($slabSql) > 0){
					while($slabsData=mysqli_fetch_array($slabSql)){
						$slabId = $slabsData['id'];
						if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['fromRange']==0 || $slabsData['toRange']==0){
							$paxrange2 = $slabsData['fromRange'];
						}else{
							$paxrange2 = $slabsData['fromRange']."-".$slabsData['toRange'];
						}
						${"final_cost".$slabId} = 0;
						?>
						<tr>
							<td width="<?php echo $widths; ?>%" align="center" ><strong><?php echo $paxrange2; ?>&nbsp;Pax</strong></td>
							<?php
							for ($i = 1; $i <= $colm; $i++) {
								foreach($hotCategory2 as $val2){
									$slabId11 = $slabId.'C'.$val2;
									${"proposalCost".$slabId11} = (${"proposalCost".$slabId11}+$resultpageQuotation['otherLocationCost']);
									?>
									<td width="<?php echo $widths; ?>%" align="right"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,${"proposalCost".$slabId11}); ?></td>
									<?php 
								}
							} ?>
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
				$singleRoom = $resultpageQuotation['sglRoom'];
				$doubleRoom = $resultpageQuotation['dblRoom'];
				$tripleRoom = $resultpageQuotation['tplRoom'];
				$twinRoom   = $resultpageQuotation['twinRoom'];
				$EBedAdult = $resultpageQuotation['extraNoofBed'];
				$EBedChild = $resultpageQuotation['childwithNoofBed'];
				$NBedChild = $resultpageQuotation['childwithoutNoofBed'];

				$conspan = 0;
				if($singleRoom>0){ $conspan=$conspan+1; }
				if($doubleRoom>0){ $conspan=$conspan+1; }
				if($tripleRoom>0){ $conspan=$conspan+1; }
				if($twinRoom>0){ $conspan=$conspan+1; }
				if($EBedAdult>0){ $conspan=$conspan+1; }
				if($EBedChild>0){ $conspan=$conspan+1; }
				if($NBedChild>0){ $conspan=$conspan+1; }
				$colsWidth = 80/$conspan;
				?> 
				<table border="1" cellpadding="10" cellspacing="0" borderColor="#ccc" class="borderedTable table-service" style="page-break-after: auto;page-break-before: auto;width: 100%;"> 
					<tr style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
						<th width="20%" align="center" <?php if($conspan>0){ ?> rowspan="2" <?php } ?> valign="middle" style=""><strong>Total&nbsp;Cost<br>(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></th>
						<?php if($conspan>0){ ?>
						<th width="80%" colspan="<?php echo $conspan; ?>" align="center" valign="middle" style=""><strong>Per Person Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
						<?php } ?>
					</tr>
					<?php if($conspan>0){ ?>
					<tr style="padding: 8px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
						<?php if($singleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Single Basis</strong></th>
						<?php } if($doubleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Double Basis</strong></th>
						<?php } if($tripleRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Triple Basis</strong></th>
						<?php } if($twinRoom>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>Twin Basis</strong></th>
						<?php } if($EBedAdult>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>E.Bed(Adult) Basis</strong></th>
						<?php } if($EBedChild>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CWB Basis</strong></th>
						<?php } if($NBedChild>0){ ?>
						<th width="<?php echo $colsWidth; ?>%" valign="middle" style=""><strong>CNB Basis</strong></th>
						<?php } ?>
					</tr>
					<?php } ?>
					<tr>
						<td valign="middle">
							<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
						</td>
						<?php if($singleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
						</td>
						<?php } if($doubleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
						</td>
						<?php } if($tripleRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnTripleBasis)); ?>
						</td>
						<?php } if($twinRoom>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
						</td>
						<?php } if($EBedAdult>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostOnExtraBedABasis)); ?>
						</td>
						<?php } if($EBedChild>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
						</td>
						<?php } if($NBedChild>0){ ?>
						<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraNBedCBasis)); ?>
						</td>
						<?php } ?>
					</tr>
					<?php if($quotationData['isSupp_TRR']==0){ ?>
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
	</div>
	<br>
	<!-- end Costing table -->
	<?php
}
?>