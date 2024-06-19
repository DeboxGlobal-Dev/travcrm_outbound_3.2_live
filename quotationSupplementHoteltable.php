<?php 

$select='*';
	$where='id="'.$queryId.'"';
	$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
	$queryData=mysqli_fetch_array($rs);

	$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"');
	$quotationData=mysqli_fetch_array($rsp);
?>

<table width="100%" border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service" >
	<tr height="18">
	<td colspan="13" align="right">Note: All the Cost is per person with inclusive tax and markup<strong>(In <?php echo getCurrencyName($quotationData['currencyId']); ?>)</strong></td>
	</tr>
	<tr height="18">
	<th width="8%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Day</strong></th>
	<th width="15%" height="18" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Destination</strong></th>
	<th width="22%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Supplement&nbsp;/ Reduction </strong></th>
	<th width="12%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Single</strong></th>
	<th width="13%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Double</strong></th>
	<th width="13%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Triple</strong></th>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Extra&nbsp;Bed<br>(Adult)</strong></th>
	<?php if($quotationData['quadNoofRoom']>0){ ?>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Quad&nbsp;Room</strong></th>
	<?php } if($quotationData['teenNoofRoom']>0){ ?>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Teen&nbsp;Room</strong></th>
	<?php } ?>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Extra&nbsp;Bed<br>(Child)</strong></th>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Child&nbsp;No Bed</strong></th>
	<?php if($quotationData['sixNoofBedRoom']>0){ ?>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Six&nbsp;Bed</strong></th>
	<?php } if($quotationData['eightNoofBedRoom']>0){ ?>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Eight&nbsp;Bed</strong></th>
	<?php } if($quotationData['tenNoofBedRoom']>0){ ?>
	<th width="15%" align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Ten&nbsp;Bed</strong></th>
	<?php } ?>
	</tr>
	<?php
	 
	
	$c12=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$quotationData['id'].'"');
	$serviceMarkup = mysqli_fetch_array($c12);
	$hotelM = $serviceMarkup['hotel'];
	$markupType = $serviceMarkup['markupType'];
	
	$quotationId=$quotationData['id'];
	$queryId=$quotationData['queryId'];

	$QueryDaysQuery2=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationData['id'].'" and addstatus = 0 order by srdate asc');
	$day2=1;
	while($suppDaysData=mysqli_fetch_array($QueryDaysQuery2)){  
 		$dayDate2 = date('Y-m-d', strtotime($suppDaysData['srdate']));
		$dayId2 = $suppDaysData['id'];

		$normalHotelQuery="";
		$normalHotelQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement!=1 and isGuestType=1 and fromDate="'.$dayDate2.'"');
 		if(mysqli_num_rows($normalHotelQuery) > 0){

			$normalQuotData=mysqli_fetch_array($normalHotelQuery);

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
			$mainSingle = $mainSingle+getMarkupCost($mainSingle,$hotelM,$markupType);
			$mainSingle = $mainSingle+getMarkupCost($mainSingle,$serviceTax,1);

			$mainDouble= ($normalQuotData['doubleoccupancy']/2);
			$mainDouble = $mainDouble+getMarkupCost($mainDouble,$hotelM,$markupType);
			$mainDouble = $mainDouble+getMarkupCost($mainDouble,$serviceTax,1);

			$mainTriple= ($normalQuotData['tripleoccupancy']/3);
			$mainTriple = $mainTriple+getMarkupCost($mainTriple,$hotelM,$markupType);
			$mainTriple = $mainTriple+getMarkupCost($mainTriple,$serviceTax,1);

			$mainEBedA= ($normalQuotData['extraBed']);
			$mainEBedA = $mainEBedA+getMarkupCost($mainEBedA,$hotelM,$markupType);
			$mainEBedA = $mainEBedA+getMarkupCost($mainEBedA,$serviceTax,1);

			$mainEBedC= ($normalQuotData['childwithbed']);
			$mainEBedC = $mainEBedC+getMarkupCost($mainEBedC,$hotelM,$markupType);
			$mainEBedC = $mainEBedC+getMarkupCost($mainEBedC,$serviceTax,1);

			$mainENBedC= ($normalQuotData['childwithoutbed']);
			$mainENBedC = $mainENBedC+getMarkupCost($mainENBedC,$hotelM,$markupType);
			$mainENBedC = $mainENBedC+getMarkupCost($mainENBedC,$serviceTax,1);

			$quadRoomC= ($normalQuotData['quadRoom']);
			$quadRoomC = $quadRoomC+getMarkupCost($quadRoomC,$hotelM,$markupType);
			$quadRoomC = $quadRoomC+getMarkupCost($quadRoomC,$serviceTax,1);

			$teenRoomC= ($normalQuotData['teenRoom']);
			$teenRoomC = $teenRoomC+getMarkupCost($teenRoomC,$hotelM,$markupType);
			$teenRoomC = $teenRoomC+getMarkupCost($teenRoomC,$serviceTax,1);

			$sixBedRoomC= ($normalQuotData['sixBedRoom']);
			$sixBedRoomC = $sixBedRoomC+getMarkupCost($sixBedRoomC,$hotelM,$markupType);
			$sixBedRoomC = $sixBedRoomC+getMarkupCost($sixBedRoomC,$serviceTax,1);

			$eightBedRoomC= ($normalQuotData['eightBedRoom']);
			$eightBedRoomC = $eightBedRoomC+getMarkupCost($eightBedRoomC,$hotelM,$markupType);
			$eightBedRoomC = $eightBedRoomC+getMarkupCost($eightBedRoomC,$serviceTax,1);

			$tenBedRoomC= ($normalQuotData['tenBedRoom']);
			$tenBedRoomC = $tenBedRoomC+getMarkupCost($tenBedRoomC,$hotelM,$markupType);
			$tenBedRoomC = $tenBedRoomC+getMarkupCost($tenBedRoomC,$serviceTax,1);

			$suppRoomQuery="";
			$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" and supplierId="'.$normalQuotData['supplierId'].'" ');
			$mainRoomSupp = 0;
			if(mysqli_num_rows($suppRoomQuery) > 0){

				$mainRoomSupp = 1;
				$suppRoomData=mysqli_fetch_array($suppRoomQuery);

				$suppRoomRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$suppRoomData['roomType'].'');
				$suppRoomRoomTypeD=mysqli_fetch_array($suppRoomRoomTypeQuery);
				$suppRoomRoomType = trim($suppRoomRoomTypeD['name']);

				$suppRoomMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$suppRoomData['mealPlan'].'');
				$suppRoomMealPlanD=mysqli_fetch_array($suppRoomMealPlanQuery);
				$suppRoomMealPlan = strtoupper($suppRoomMealPlanD['name']);

				$mainRoomSingle=$mainRoomDouble=$mainRoomEBedA=0;
				$mainRoomSingle = ($suppRoomData['singleoccupancy']);
				$mainRoomSingle = $mainRoomSingle+getMarkupCost($mainRoomSingle,$hotelM,$markupType);
				$mainRoomSingle = $mainRoomSingle+getMarkupCost($mainRoomSingle,$serviceTax,1);
				$mainRoomSingle = $mainRoomSingle-$mainSingle;

				$mainRoomDouble= ($suppRoomData['doubleoccupancy']/2);
				$mainRoomDouble = $mainRoomDouble+getMarkupCost($mainRoomDouble,$hotelM,$markupType);
				$mainRoomDouble = $mainRoomDouble+getMarkupCost($mainRoomDouble,$serviceTax,1);
				$mainRoomDouble = $mainRoomDouble-$mainDouble;

				$mainRoomTriple= ($suppRoomData['doubleoccupancy']/3);
				$mainRoomTriple = $mainRoomTriple+getMarkupCost($mainRoomTriple,$hotelM,$markupType);
				$mainRoomTriple = $mainRoomTriple+getMarkupCost($mainRoomTriple,$serviceTax,1);
				$mainRoomTriple = $mainRoomTriple-$mainTriple;

				$mainRoomEBedA= ($suppRoomData['extraBed']);
				$mainRoomEBedA = $mainRoomEBedA+getMarkupCost($mainRoomEBedA,$hotelM,$markupType);
				$mainRoomEBedA = $mainRoomEBedA+getMarkupCost($mainRoomEBedA,$serviceTax,1);
				$mainRoomEBedA = $mainRoomEBedA-$mainEBedA;

				$mainRoomEBedC= ($suppRoomData['childwithbed']);
				$mainRoomEBedC = $mainRoomEBedC+getMarkupCost($mainRoomEBedC,$hotelM,$markupType);
				$mainRoomEBedC = $mainRoomEBedC+getMarkupCost($mainRoomEBedC,$serviceTax,1);
				$mainRoomEBedC = $mainRoomEBedC-$mainEBedC;

				$mainRoomENBedC= ($suppRoomData['childwithoutbed']);
				$mainRoomENBedC = $mainRoomENBedC+getMarkupCost($mainRoomENBedC,$hotelM,$markupType);
				$mainRoomENBedC = $mainRoomENBedC+getMarkupCost($mainRoomENBedC,$serviceTax,1);
				$mainRoomENBedC = $mainRoomENBedC-$mainENBedC;

				$mainQuadRoomC= ($suppRoomData['quadRoom']);
				$mainQuadRoomC = $mainQuadRoomC+getMarkupCost($mainQuadRoomC,$hotelM,$markupType);
				$mainQuadRoomC = $mainQuadRoomC+getMarkupCost($mainQuadRoomC,$serviceTax,1);
				$mainQuadRoomC = $mainQuadRoomC-$quadRoomC;

				$mainTeenRoomC= ($suppRoomData['teenRoom']);
				$mainTeenRoomC = $mainTeenRoomC+getMarkupCost($mainTeenRoomC,$hotelM,$markupType);
				$mainTeenRoomC = $mainTeenRoomC+getMarkupCost($mainTeenRoomC,$serviceTax,1);
				$mainTeenRoomC = $mainTeenRoomC-$teenRoomC;

				$mainsixBedRoomC= ($suppRoomData['sixBedRoom']);
				$mainsixBedRoomC = $mainsixBedRoomC+getMarkupCost($mainsixBedRoomC,$hotelM,$markupType);
				$mainsixBedRoomC = $mainsixBedRoomC+getMarkupCost($mainsixBedRoomC,$serviceTax,1);
				$mainsixBedRoomC = $mainsixBedRoomC-$sixBedRoomC;

				$maineightBedRoomC= ($suppRoomData['eightBedRoom']);
				$maineightBedRoomC = $maineightBedRoomC+getMarkupCost($maineightBedRoomC,$hotelM,$markupType);
				$maineightBedRoomC = $maineightBedRoomC+getMarkupCost($maineightBedRoomC,$serviceTax,1);
				$maineightBedRoomC = $maineightBedRoomC-$eightBedRoomC;

				$maintenBedRoomC= ($suppRoomData['tenBedRoom']);
				$maintenBedRoomC = $maintenBedRoomC+getMarkupCost($maintenBedRoomC,$hotelM,$markupType);
				$maintenBedRoomC = $maintenBedRoomC+getMarkupCost($maintenBedRoomC,$serviceTax,1);
				$maintenBedRoomC = $maintenBedRoomC-$tenBedRoomC;

				if($mainRoomSingle > 0 && $mainRoomDouble > 0){
					$red_supp = "Upgrade ";
				}else{
					$red_supp = "Reduction ";
				}

				?>
				<tr height="18">
				<td align="right" ><strong>D<?php echo str_pad($day2, 2, '0', STR_PAD_LEFT); ?></strong></td>
				<td align="right" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
				<td align="left"><?php echo $suppInfo = $red_supp."for ".$hotelName." '".$suppRoomRoomType."'(".$suppRoomMealPlan.") in place of '".$normalRoomType."'(".$normalMealPlan.") for per night per room."; ?></td>
				<td align="right">
				  <?php  echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomSingle)); ?>
				  </td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomDouble)); ?></td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomTriple)); ?></td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomEBedA)); ?></td>
				<?php if($quotationData['quadNoofRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainQuadRoomC)); ?></td>
				<?php } if($quotationData['teenNoofRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainTeenRoomC)); ?></td>
				<?php } ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomEBedC)); ?></td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainRoomENBedC)); ?></td>
				<?php if($quotationData['sixNoofBedRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$mainsixBedRoomC)); ?></td>
				<?php } if($quotationData['eightNoofBedRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$maineightBedRoomC)); ?></td>
				<?php } if($quotationData['tenNoofBedRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$maintenBedRoomC)); ?></td>
				<?php } ?>
				</tr>
		
				<?php
			}

			$suppHotelQuery="";
			$suppHotelQuery=GetPageRecord('*, count(id) as nights','quotationHotelMaster','quotationId="'.$quotationId.'" and fromDate="'.$dayDate2.'" and isHotelSupplement=1 and isGuestType=0 group by supplierId order by id asc');
			$suppQuotData=mysqli_fetch_array($suppHotelQuery);
			if($suppQuotData['nights'] > 0){

				$nights = $suppQuotData['nights'];

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
				$suppQuotSingle = $suppQuotSingle+getMarkupCost($suppQuotSingle,$hotelM,$markupType);
				$suppQuotSingle = $suppQuotSingle+getMarkupCost($suppQuotSingle,$serviceTax,1);
				$suppQuotSingle = $suppQuotSingle-$mainSingle;
				
				$suppQuotDouble= ($suppQuotData['doubleoccupancy']/2);
				$suppQuotDouble = $suppQuotDouble+getMarkupCost($suppQuotDouble,$hotelM,$markupType);
				$suppQuotDouble = $suppQuotDouble+getMarkupCost($suppQuotDouble,$serviceTax,1);
				$suppQuotDouble = $suppQuotDouble-$mainDouble;

				$suppQuotTriple= ($suppQuotData['tripleoccupancy']/2);
				$suppQuotTriple = $suppQuotTriple+getMarkupCost($suppQuotTriple,$hotelM,$markupType);
				$suppQuotTriple = $suppQuotTriple+getMarkupCost($suppQuotTriple,$serviceTax,1);
				$suppQuotTriple = $suppQuotTriple-$mainTriple;

				$suppQuotEBedA= ($suppQuotData['extraBed']);
				$suppQuotEBedA = $suppQuotEBedA+getMarkupCost($suppQuotEBedA,$hotelM,$markupType);
				$suppQuotEBedA = $suppQuotEBedA+getMarkupCost($suppQuotEBedA,$serviceTax,1);
				$suppQuotEBedA = $suppQuotEBedA-$mainEBedA;

				$suppQuotEBedC= ($suppQuotData['childwithbed']);
				$suppQuotEBedC = $suppQuotEBedC+getMarkupCost($suppQuotEBedC,$hotelM,$markupType);
				$suppQuotEBedC = $suppQuotEBedC+getMarkupCost($suppQuotEBedC,$serviceTax,1);
				$suppQuotEBedC = $suppQuotEBedC-$mainEBedC;

				$suppQuotENBedC= ($suppQuotData['childwithoutbed']);
				$suppQuotENBedC = $suppQuotENBedC+getMarkupCost($suppQuotENBedC,$hotelM,$markupType);
				$suppQuotENBedC = $suppQuotENBedC+getMarkupCost($suppQuotENBedC,$serviceTax,1);
				$suppQuotENBedC = $suppQuotENBedC-$mainENBedC;

				$suppQuotQuadC= ($suppQuotData['quadRoom']);
				$suppQuotQuadC = $suppQuotQuadC+getMarkupCost($suppQuotQuadC,$hotelM,$markupType);
				$suppQuotQuadC = $suppQuotQuadC+getMarkupCost($suppQuotQuadC,$serviceTax,1);
				$suppQuotQuadC = $suppQuotQuadC-$quadRoomC;

				$suppQuotTeenC= ($suppQuotData['teenRoom']);
				$suppQuotTeenC = $suppQuotTeenC+getMarkupCost($suppQuotTeenC,$hotelM,$markupType);
				$suppQuotTeenC = $suppQuotTeenC+getMarkupCost($suppQuotTeenC,$serviceTax,1);
				$suppQuotTeenC = $suppQuotTeenC-$teenRoomC;

				$suppQuotSixC= ($suppQuotData['sixBedRoom']);
				$suppQuotSixC = $suppQuotSixC+getMarkupCost($suppQuotSixC,$hotelM,$markupType);
				$suppQuotSixC = $suppQuotSixC+getMarkupCost($suppQuotSixC,$serviceTax,1);
				$suppQuotSixC = $suppQuotSixC-$sixBedRoomC;

				$suppQuotEightC= ($suppQuotData['eightBedRoom']);
				$suppQuotEightC = $suppQuotEightC+getMarkupCost($suppQuotEightC,$hotelM,$markupType);
				$suppQuotEightC = $suppQuotEightC+getMarkupCost($suppQuotEightC,$serviceTax,1);
				$suppQuotEightC = $suppQuotEightC-$eightBedRoomC;

				$suppQuotTenC= ($suppQuotData['tenBedRoom']);
				$suppQuotTenC = $suppQuotTenC+getMarkupCost($suppQuotTenC,$hotelM,$markupType);
				$suppQuotTenC = $suppQuotTenC+getMarkupCost($suppQuotTenC,$serviceTax,1);
				$suppQuotTenC = $suppQuotTenC-$tenBedRoomC;


				if($suppQuotSingle > 0 && $suppQuotDouble > 0){
					$red_supp = "Upgrade ";
				}else{
					$red_supp = "Reduction ";
				}

				?>
				<tr height="18">
				<td align="right" ><strong>
			    <?php if($mainRoomSupp!=1){ echo "D".str_pad($day2, 2, '0', STR_PAD_LEFT); } ?>
				  </strong></td>
				<td align="right" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
				<td align="left"><?php echo $suppInfo = $red_supp."for ".$hotelName2." '".$suppQuotRoomType."'(".$suppQuotMealPlan.") in place of ".$hotelName." '".$normalRoomType."'(".$normalMealPlan.") for per night per room."; ?></td>
				<td align="right">
				  <?php
				echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotSingle)); ?>
				  </td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotDouble)); ?></td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotTriple)); ?></td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotEBedA)); ?></td>
				<?php if($quotationData['quadNoofRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotQuadC)); ?></td>
				<?php } if($quotationData['teenNoofRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotTeenC)); ?></td>
				<?php } ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotEBedC)); ?></td>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotENBedC)); ?></td>
				<?php if($quotationData['sixNoofBedRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotSixC)); ?></td>
				<?php } if($quotationData['eightNoofBedRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotEightC)); ?></td>
				<?php } if($quotationData['tenNoofBedRoom']>0){ ?>
				<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppQuotTenC)); ?></td>
				<?php } ?>
				</tr>
		
				<?php

				$suppRoomQuery="";
				$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" and supplierId="'.$suppQuotData['supplierId'].'" and dayId="'.$suppDaysData['id'].'"');
				if(mysqli_num_rows($suppRoomQuery) > 0){

					$suppRoomData2=mysqli_fetch_array($suppRoomQuery);

					$suppRoomRoomTypeQuery=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$suppRoomData2['roomType'].'');
					$suppRoomRoomTypeD=mysqli_fetch_array($suppRoomRoomTypeQuery);
					$suppRoomRoomType = trim($suppRoomRoomTypeD['name']);

					$suppRoomMealPlanQuery=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$suppRoomData2['mealPlan'].'');
					$suppRoomMealPlanD=mysqli_fetch_array($suppRoomMealPlanQuery);
					$suppRoomMealPlan = strtoupper($suppRoomMealPlanD['name']);

					$suppRoomSingle=$suppRoomDouble=$suppRoomEBedA=$suppRoomEBedC=0;

					$suppRoomSingle = ($suppRoomData2['singleoccupancy']);
					$suppRoomSingle = $suppRoomSingle+getMarkupCost($suppRoomSingle,$hotelM,$markupType);
					$suppRoomSingle = $suppRoomSingle+getMarkupCost($suppRoomSingle,$serviceTax,1);
					$suppRoomSingle = $suppRoomSingle-$suppQuotSingle;
					
					$suppRoomDouble= ($suppRoomData2['doubleoccupancy']/2);
					$suppRoomDouble = $suppRoomDouble+getMarkupCost($suppRoomDouble,$hotelM,$markupType);
					$suppRoomDouble = $suppRoomDouble+getMarkupCost($suppRoomDouble,$serviceTax,1);
					$suppRoomDouble = $suppRoomDouble-$suppQuotDouble;

					$suppRoomTriple= ($suppRoomData2['tripleoccupancy']/2);
					$suppRoomTriple = $suppRoomTriple+getMarkupCost($suppRoomTriple,$hotelM,$markupType);
					$suppRoomTriple = $suppRoomTriple+getMarkupCost($suppRoomTriple,$serviceTax,1);
					$suppRoomTriple = $suppRoomTriple-$suppQuotTriple;
					
					$suppRoomEBedA= ($suppRoomData2['extraBed']);
					$suppRoomEBedA = $suppRoomEBedA+getMarkupCost($suppRoomEBedA,$hotelM,$markupType);
					$suppRoomEBedA = $suppRoomEBedA+getMarkupCost($suppRoomEBedA,$serviceTax,1);
					$suppRoomEBedA = $suppRoomEBedA-$suppQuotEBedA;
						
					$suppRoomEBedC= ($suppRoomData2['childwithbed']);
					$suppRoomEBedC = $suppRoomEBedC+getMarkupCost($suppRoomEBedC,$hotelM,$markupType);
					$suppRoomEBedC = $suppRoomEBedC+getMarkupCost($suppRoomEBedC,$serviceTax,1);
					$suppRoomEBedC = $suppRoomEBedC-$suppQuotEBedC;

					$suppRoomENBedC= ($suppRoomData2['childwithoutbed']);
					$suppRoomENBedC = $suppRoomENBedC+getMarkupCost($suppRoomENBedC,$hotelM,$markupType);
					$suppRoomENBedC = $suppRoomENBedC+getMarkupCost($suppRoomENBedC,$serviceTax,1);
					$suppRoomENBedC = $suppRoomENBedC-$suppQuotENBedC;

					$suppRoomQuadC= ($suppRoomData2['quadRoom']);
					$suppRoomQuadC = $suppRoomQuadC+getMarkupCost($suppRoomQuadC,$hotelM,$markupType);
					$suppRoomQuadC = $suppRoomQuadC+getMarkupCost($suppRoomQuadC,$serviceTax,1);
					$suppRoomQuadC = $suppRoomQuadC-$suppQuotQuadC;

					$suppRoomTeenC= ($suppRoomData2['teenRoom']);
					$suppRoomTeenC = $suppRoomTeenC+getMarkupCost($suppRoomTeenC,$hotelM,$markupType);
					$suppRoomTeenC = $suppRoomTeenC+getMarkupCost($suppRoomTeenC,$serviceTax,1);
					$suppRoomTeenC = $suppRoomTeenC-$suppQuotTeenC;

					$suppRoomSixC= ($suppRoomData2['sixBedRoom']);
					$suppRoomSixC = $suppRoomSixC+getMarkupCost($suppRoomSixC,$hotelM,$markupType);
					$suppRoomSixC = $suppRoomSixC+getMarkupCost($suppRoomSixC,$serviceTax,1);
					$suppRoomSixC = $suppRoomSixC-$suppQuotSixC;

					$suppRoomEightC= ($suppRoomData2['eightBedRoom']);
					$suppRoomEightC = $suppRoomEightC+getMarkupCost($suppRoomEightC,$hotelM,$markupType);
					$suppRoomEightC = $suppRoomEightC+getMarkupCost($suppRoomEightC,$serviceTax,1);
					$suppRoomEightC = $suppRoomEightC-$suppQuotEightC;

					$suppRoomTenC= ($suppRoomData2['tenBedRoom']);
					$suppRoomTenC = $suppRoomTenC+getMarkupCost($suppRoomTenC,$hotelM,$markupType);
					$suppRoomTenC = $suppRoomTenC+getMarkupCost($suppRoomTenC,$serviceTax,1);
					$suppRoomTenC = $suppRoomTenC-$suppQuotTenC;
					
					if($suppRoomSingle > 0 && $suppRoomDouble > 0){
						$red_supp = "Upgrade ";
					}else{
						$red_supp = "Reduction ";
					}
					?>
					<tr height="18">
					<td align="right" ><strong>&nbsp;</strong></td>
					<td align="right" ><strong><?php echo getDestination($suppDaysData['cityId']);  ?></strong></td>
					<td align="left"><?php echo $suppInfo = $red_supp."for ".$hotelName2." '".$suppRoomRoomType."'(".$suppRoomMealPlan.") in place of '".$suppQuotRoomType."'(".$suppQuotMealPlan.") for per night per room."; ?></td>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomSingle)); ?></td>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomDouble)); ?></td>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomTriple)); ?></td>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomEBedA)); ?></td>
					<?php if($quotationData['quadNoofRoom']>0){ ?>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomQuadC)); ?></td>
					<?php } if($quotationData['teenNoofRoom']>0){ ?>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomTeenC)); ?></td>
					<?php } ?>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomEBedC)); ?></td>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomENBedC)); ?></td>
					<?php if($quotationData['sixNoofBedRoom']>0){ ?>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomSixC)); ?></td>
					<?php } if($quotationData['eightNoofBedRoom']>0){ ?>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomEightC)); ?></td>
					<?php } if($quotationData['tenNoofBedRoom']>0){ ?>
					<td align="right"><?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$suppRoomTenC)); ?></td>
					<?php } ?>
					</tr>
					<?php
				}
			}
		}
		$day2++;
	}
	?>
</table> 