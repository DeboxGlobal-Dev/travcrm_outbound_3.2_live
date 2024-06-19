<?php
include "inc.php";
if($_REQUEST['action']=='loadServices' && $_REQUEST['sType']!=''){
	$sType = $_REQUEST['sType'];
	if($_REQUEST['cityId']!=''){
		$cityIdQuery = ' and destinationId="'.$_REQUEST['cityId'].'"';
		$hotelCityQuery = ' and hotelCity="'.getDestination($_REQUEST['cityId']).'"';
		$otherActivityCityQuery = ' and otherActivityCity="'.getDestination($_REQUEST['cityId']).'"';
		$entranceCityQuery = ' and entranceCity="'.getDestination($_REQUEST['cityId']).'"';
		$enrouteCityQuery = ' and enrouteCity="'.getDestination($_REQUEST['cityId']).'"';
	}

	if ($sType =='hotel') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' 1 and status=1 '.$hotelCityQuery.' order by hotelName asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['hotelName'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}
	if ($sType =='activity') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' 1 and status=1 '.$otherActivityCityQuery.' order by otherActivityName asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['otherActivityName'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}
	if ($sType =='entrance') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' 1 and status=1 '.$entranceCityQuery.' order by entranceName asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['entranceName'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}
	if ($sType =='enroute') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' 1 and status=1 '.$enrouteCityQuery.' order by enrouteName asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['enrouteName'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}
	if ($sType =='transfer') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' status=1 and transferCategory="transfer" '.$cityIdQuery.' order by transferName asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['transferName'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	} 
	if ($sType =='transportation') {
	   	$rows=$rs='';    // and transferCategory="transportation"
		$rs=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' status=1 '.$cityIdQuery.' order by transferName asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['transferName'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}
	if ($sType =='guide') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' 1 and status=1 order by name asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['name'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}
	if ($sType =='restaurant') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,' 1 and status=1 '.$cityIdQuery.' order by mealPlanName asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['mealPlanName'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}
	if ($sType =='additional') {
	   	$rows=$rs='';    
		$rs=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,' 1 and status=1 order by name asc'); 	  
		while($resListing=mysqli_fetch_array($rs)){ 
			$rows .='<option value="'.$resListing['id'].'">'.$resListing['name'].'</option>';
		}
		?>
		<select id="searchServiceId">
			<option value="">Select Service</option>
			<?php echo $rows;  ?>
		</select>
		<?php 
	}

	?>
	<!-- <script src="js/jquery-1.11.3.min.js?id=<?php echo time();?>"></script>   -->
	<script type="text/javascript" src="js/selectize.js"></script>
	<script type="text/javascript">
		// selectize
		$('#searchServiceId').selectize();
	</script>
	<?php 
}

if($_REQUEST['action']=='loadSearchServicesRates' && $_REQUEST['queryId']!='' && $_REQUEST['sType']!='' && $_REQUEST['serviceId']!=''){
	$serviceId = $_REQUEST['serviceId'];
	$cityId = $_REQUEST['cityId'];
	$sType = $_REQUEST['sType'];
	$queryId = $_REQUEST['queryId'];
	$rows=$rs='';    
	$qQuery=GetPageRecord('*',_QUERY_MASTER_,' 1 and id="'.$queryId.'" '); 	  
	$queryData=mysqli_fetch_array($qQuery);

	// $marketId = getQueryMaketType($queryData['id']);
	// $whereMarket = '  and marketType=1';
	$whereMarket = '';
	// if($marketId>0){
		// $whereMarket = ' and marketType="'.$marketId.'"';
	// }

	$fromDate = date('Y-m-d',strtotime($_REQUEST['checkIn']));
	$toDate = date('Y-m-d',strtotime($_REQUEST['checkOut']));
	if($fromDate == $toDate){
		$toDate = date("Y-m-d", strtotime("+1 days", strtotime($toDate))); 
	}


	$paxAdult = ($queryData['adult']);
	$paxChild = ($queryData['child']);
	$totalPax = ($paxAdult + $paxChild);

	$sglRoom = $queryData['sglRoom'];
	$dblRoom = $queryData['dblRoom'];
	$tplRoom = $queryData['tplRoom'];
	$twinRoom   = $queryData['twinRoom'];
	$cwbRoom = $queryData['cwbRoom'];

	if ($sType =='hotel') {

		$objec=date_diff(date_create($fromDate),date_create($toDate));
		if($tnight < 1){
			$tnight = $objec->format("%a");
		}

		$whereRoomType = $whereMealPlan = "";
		if($_REQUEST['roomTypeId']!='' ){
			$whereRoomType .= " and roomType='".$_REQUEST['roomTypeId']."'";
		}

		if($_REQUEST['mealPlanId']!='' ){
			$whereMealPlan .= " and mealPlan='".$_REQUEST['mealPlanId']."'";
		}

		$seasonQuery = "";
		$seasonQuery = " and DATE(fromDate) <= '".$fromDate."' and  DATE(toDate) >= '".$toDate."'";
		$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and companyTypeId=1 ) and supplierId> 0 ';
	   	
	   	$rows=$rs='';    
	
		$hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' 1 and id="'.$serviceId.'" '); 	  
		$hotelData=mysqli_fetch_array($hotelQuery); 
	   	?>
	   	<table class="servicetable" border="1">
		<thead>
			<tr>
			<td align="left">Hotel</td>
			<td align="left">Supplier</td>
			<td align="left">RoomType</td>
			<td align="left">MealPlan</td>
			<td align="left">CheckIn/Checkout(<?php echo $tnight; ?>Nights)</td>
			<td align="right">Total&nbsp;Cost</td>
			<td align="left" colspan="2" width="18%">&nbsp;&nbsp;&nbsp;Action</td>
			</tr>
		</thead>
		<tbody>
	   	<?php
	   	$rateId = $editId = 0;
		$rs=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,' serviceid="'.$serviceId.'" and status=1 '.$whereRoomType.' '.$whereMealPlan.' '.$seasonQuery.' '.$suppliersQuery.''); 	  
		if(mysqli_num_rows($rs)>0){
			while($dmcRateD=mysqli_fetch_array($rs)){ 
				$extraBedACost = $dmcRateD['extraBed']; 
				$extraBedCCost = $dmcRateD['childwithbed']; 
				$rateId = $dmcRateD['id']; 
				$saveRateId = $rateId;

				$rs2=GetPageRecord('*','docketHotelRateMaster',' serviceId="'.$serviceId.'" and status=1 '.$whereRoomType.' '.$whereMealPlan.' '.$seasonQuery.' '.$suppliersQuery.' and rateId="'.$rateId.'" and queryId="'.$queryId.'"'); 	  
				if(mysqli_num_rows($rs2)>0){
					$dmcRateD=mysqli_fetch_array($rs2);
					$extraBedACost = $dmcRateD['extraBedA']; 
					$extraBedCCost = $dmcRateD['extraBedC']; 
					$editId = $dmcRateD['id']; 
					$saveRateId = $editId;
				}


				$rs232='';
		  		$rs232=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$dmcRateD['mealPlan'].'"'); 
		    	$mealplanD=mysqli_fetch_array($rs232);
		    	$mealPlanName = $mealplanD['name'];
		    	$mealPlanId = $mealplanD['id'];

		    	$rs21='';
		  		$rs21=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$dmcRateD['roomType'].'"'); 
		    	$roomTypeD=mysqli_fetch_array($rs21);

		    	$suppQuery="";
				$supname = '';
				$suppQuery=GetPageRecord('name,supplierNumber,id',_SUPPLIERS_MASTER_,'id="'.$dmcRateD['supplierId'].'"'); 
				$suppD=mysqli_fetch_array($suppQuery); 
				if($suppD['id'] > 0){ 
					$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
				} 

				// cost calculation
				$roomGST = $dmcRateD['roomGST'];
				$roomTAC = $dmcRateD['roomTAC'];
				$mealGST = $dmcRateD['mealGST'];
				$markupCost = $dmcRateD['markupCost'];
				$markupType = $dmcRateD['markupType'];

				$singleoccupancy = $dmcRateD['singleoccupancy'];
				$doubleoccupancy = $dmcRateD['doubleoccupancy'];
				$extraBedA = $extraBedACost;
				$extraBedC = $extraBedCCost;
				$lunch = $dmcRateD['lunch'];
				$dinner = $dmcRateD['dinner'];
				$breakfast = $dmcRateD['breakfast'];
				$totalHotelCost = 0;
				if($sglRoom>0){ $totalHotelCost = $totalHotelCost+round($singleoccupancy*$sglRoom); }
				if($dblRoom>0){ $totalHotelCost = $totalHotelCost+round($doubleoccupancy*$dblRoom); }
				if($tplRoom>0){ $totalHotelCost = $totalHotelCost+round(($doubleoccupancy+$extraBedA)*$tplRoom); }
				if($twinRoom>0){ $totalHotelCost = $totalHotelCost+round($doubleoccupancy*$twinRoom); }
				if($cwbRoom>0){ $totalHotelCost = $totalHotelCost+round($extraBedC*$cwbRoom); }

				$totalMealCost = 0;
				if($mealplanD['name'] == 'AP'){
					if($totalPax>0){ $totalMealCost = $totalMealCost+round($breakfast*$totalPax); }
					if($totalPax>0){ $totalMealCost = $totalMealCost+round($lunch*$totalPax); }
					if($totalPax>0){ $totalMealCost = $totalMealCost+round($dinner*$totalPax); }
				}elseif($mealplanD['name'] == 'MAP'){
					if($totalPax>0){ $totalMealCost = $totalMealCost+round($breakfast*$totalPax); }
					if($totalPax>0){ $totalMealCost = $totalMealCost+round($lunch*$totalPax); }
				}elseif($mealplanD['name'] == 'CP'){
					if($totalPax>0){ $totalMealCost = $totalMealCost+round($breakfast*$totalPax); }
				}else{
					$mealPlanName = 'EP';
					$mealPlanId = '0';
				}

				if($tnight>0){ $totalHotelCost = round($totalHotelCost*$tnight); }
				if($tnight>0){ $totalMealCost = round($totalMealCost*$tnight); }

				$hotelCost = getCostWithGST($totalHotelCost,getGstValueById($roomGST),$roomTAC)+getCostWithGST($totalMealCost,getGstValueById($mealGST),0);

				$hotelCost = $hotelCost+getMarkupCost($hotelCost,$markupCost,$markupType);

				?>
				<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
				<td><?php echo strip($hotelData['hotelName']); ?></td>
				<td><?php echo strip($supname); ?></td>
				<td><?php echo strip($roomTypeD['name']); ?></td>
				<td><?php echo strip($mealPlanName); ?></td>
				<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
				<td align="right"><?php echo getCurrencyName($dmcRateD['currencyId']);?> <?php echo getTwoDecimalNumberFormat($hotelCost);?></td>
				<td>
				 
					<button  type="button" class="whitembutton" onclick="addService(<?php echo $serviceId.','.$saveRateId.','.$roomTypeD['id'].','.$mealPlanId.','.$totalHotelCost.','.$totalMealCost.','.$roomGST.','.$mealGST.','.$roomTAC.','.$markupCost.','.$markupType.','.strtotime($fromDate).','.strtotime($toDate);?>);">
						<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select
					</button>
					<button  type="button" class="whitembutton" onclick="docket_alertbox('action=loadDocketHotelBreakupCost&queryId=<?php echo $queryId; ?>&rateId=<?php echo $rateId; ?>&editId=<?php echo $editId; ?>&roomTypeId=<?php echo $roomTypeD['id']; ?>&mealPlanId=<?php echo $mealPlanId; ?>&serviceId=<?php echo $serviceId; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>','900px','auto');" >
						<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Breakup&nbsp;Cost
					</button>
				</td>
				</tr> 
				<?php
			}
		}else{
			$rs2=GetPageRecord('*','docketHotelRateMaster',' serviceId="'.$serviceId.'" and status=1 '.$whereRoomType.' '.$whereMealPlan.' '.$seasonQuery.' '.$suppliersQuery.' and rateId="'.$rateId.'" and queryId="'.$queryId.'"'); 
			if(mysqli_num_rows($rs2)>0){	  
				while($dmcRateD=mysqli_fetch_array($rs2)){ 
					$extraBedACost = $dmcRateD['extraBedA']; 
					$extraBedCCost = $dmcRateD['extraBedC']; 
					$editId = $dmcRateD['id'];  
					$saveRateId = $dmcRateD['id'];  

					$hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' 1 and id="'.$serviceId.'" '); 	  
					$hotelData=mysqli_fetch_array($hotelQuery); 

					$rs232='';
			  		$rs232=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$dmcRateD['mealPlan'].'"'); 
			    	$mealplanD=mysqli_fetch_array($rs232);
			    	$mealPlanName = $mealplanD['name'];
			    	$mealPlanId = $mealplanD['id'];

			    	$rs21='';
			  		$rs21=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$dmcRateD['roomType'].'"'); 
			    	$roomTypeD=mysqli_fetch_array($rs21);

			    	$suppQuery="";
					$supname = '';
					$suppQuery=GetPageRecord('name,supplierNumber,id',_SUPPLIERS_MASTER_,'id="'.$dmcRateD['supplierId'].'"'); 
					$suppD=mysqli_fetch_array($suppQuery); 
					if($suppD['id'] > 0){ 
						$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
					} 

					// cost calculation
					$roomGST = $dmcRateD['roomGST'];
					$roomTAC = $dmcRateD['roomTAC'];
					$mealGST = $dmcRateD['mealGST'];
					$markupCost = $dmcRateD['markupCost'];
					$markupType = $dmcRateD['markupType'];

					$singleoccupancy = $dmcRateD['singleoccupancy'];
					$doubleoccupancy = $dmcRateD['doubleoccupancy'];
					$extraBedA = $extraBedACost;
					$extraBedC = $extraBedCCost;
					$lunch = $dmcRateD['lunch'];
					$dinner = $dmcRateD['dinner'];
					$breakfast = $dmcRateD['breakfast'];
					$totalHotelCost = 0;
					if($sglRoom>0){ $totalHotelCost = $totalHotelCost+round($singleoccupancy*$sglRoom); }
					if($dblRoom>0){ $totalHotelCost = $totalHotelCost+round($doubleoccupancy*$dblRoom); }
					if($tplRoom>0){ $totalHotelCost = $totalHotelCost+round(($doubleoccupancy+$extraBedA)*$tplRoom); }
					if($twinRoom>0){ $totalHotelCost = $totalHotelCost+round($doubleoccupancy*$twinRoom); }
					if($cwbRoom>0){ $totalHotelCost = $totalHotelCost+round($extraBedC*$cwbRoom); }

					$totalMealCost = 0;
					if($mealplanD['name'] == 'AP'){
						if($totalPax>0){ $totalMealCost = $totalMealCost+round($breakfast*$totalPax); }
						if($totalPax>0){ $totalMealCost = $totalMealCost+round($lunch*$totalPax); }
						if($totalPax>0){ $totalMealCost = $totalMealCost+round($dinner*$totalPax); }
					}elseif($mealplanD['name'] == 'MAP'){
						if($totalPax>0){ $totalMealCost = $totalMealCost+round($breakfast*$totalPax); }
						if($totalPax>0){ $totalMealCost = $totalMealCost+round($lunch*$totalPax); }
					}elseif($mealplanD['name'] == 'CP'){
						if($totalPax>0){ $totalMealCost = $totalMealCost+round($breakfast*$totalPax); }
					}else{
						$mealPlanName = 'EP';
						$mealPlanId = '0';
					}

					if($tnight>0){ $totalHotelCost = round($totalHotelCost*$tnight); }
					if($tnight>0){ $totalMealCost = round($totalMealCost*$tnight); }

					$hotelCost = getCostWithGST($totalHotelCost,getGstValueById($roomGST),$roomTAC)+getCostWithGST($totalMealCost,getGstValueById($mealGST),0);

					$hotelCost = $hotelCost+getMarkupCost($hotelCost,$markupCost,$markupType);
					?>
					<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
					<td><?php echo strip($hotelData['hotelName']); ?></td>
					<td><?php echo strip($supname); ?></td>
					<td><?php echo strip($roomTypeD['name']); ?></td>
					<td><?php echo strip($mealPlanName); ?></td>
					<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
					<td align="right"><?php echo getCurrencyName($dmcRateD['currencyId']); ?> <?php echo getTwoDecimalNumberFormat($hotelCost); ?></td>
					<td>
						<button  type="button" class="whitembutton" onclick="addService(<?php echo $serviceId.','.$saveRateId.','.$roomTypeD['id'].','.$mealPlanId.','.$totalHotelCost.','.$totalMealCost.','.$roomGST.','.$mealGST.','.$roomTAC.','.$markupCost.','.$markupType.','.strtotime($fromDate).','.strtotime($toDate);?>);">
							<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select
						</button>

						<button  type="button" class="whitembutton" onclick="docket_alertbox('action=loadDocketHotelBreakupCost&queryId=<?php echo $queryId; ?>&rateId=<?php echo $rateId; ?>&editId=<?php echo $editId; ?>&roomTypeId=<?php echo $roomTypeD['id']; ?>&mealPlanId=<?php echo $mealPlanId; ?>&serviceId=<?php echo $serviceId; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>','900px','auto');" >
							<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Breakup&nbsp;Cost
						</button>
					</td>
					</tr> 
					<?php
				}
			}else{

				$rs232='';
		  		$rs232=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$_REQUEST['mealPlanId'].'"'); 
		    	$mealplanD=mysqli_fetch_array($rs232);
		    	$mealPlanName = $mealplanD['name'];
		    	$mealPlanId = $mealplanD['id'];

		    	$rs21='';
		  		$rs21=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$_REQUEST['roomTypeId'].'"'); 
		    	$roomTypeD=mysqli_fetch_array($rs21);

				?>
				<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
				<td><?php echo strip($hotelData['hotelName']); ?></td>
				<td>&nbsp;</td>
				<td><?php echo strip($roomTypeD['name']); ?></td>
				<td><?php echo strip($mealPlanName); ?></td>
				<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
				<td align="center" style="color:red;"> </td>
				<td colspan="2">
					<div class="editbtnselect" onclick="docket_alertbox('action=loadDocketHotelBreakupCost&queryId=<?php echo $queryId; ?>&rateId=0&editId=0&roomTypeId=<?php echo $roomTypeD['id']; ?>&mealPlanId=<?php echo $mealPlanId; ?>&serviceId=<?php echo $serviceId; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>','900px','auto');" ><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Add&nbsp;Rate</div>
				</td>
				</tr>
				<?php
			}
		}
		?>
		</tbody>
		</table>
		<script type="text/javascript">
		function addService(serviceId,rateId,roomTypeId,mealPlanId,totalHotelCost,totalMealCost,roomGST,mealGST,roomTAC,markupCost,markupType,fromDate,toDate){
		$('#loadserviceSaveBox').load("docket_frmaction.php?action=addServices&cityId=<?php echo $cityId; ?>&sType=<?php echo $sType; ?>&serviceId="+serviceId+"&rateId="+rateId+"&roomTypeId="+roomTypeId+"&mealPlanId="+mealPlanId+"&totalHotelCost="+totalHotelCost+"&totalMealCost="+totalMealCost+"&roomGST="+roomGST+"&mealGST="+mealGST+"&roomTAC="+roomTAC+"&markupCost="+markupCost+"&markupType="+markupType+"&fromDate="+fromDate+"&toDate="+toDate+"&queryId=<?php echo $queryId; ?>");
		}
		</script>
		<div id="loadserviceSaveBox" style="display: none;"></div>
		<?php
	}
	if ($sType =='transportation') {

		$seasonQuery = "";
		$seasonQuery = " and DATE(fromDate) <= '".$fromDate."' and  DATE(toDate) >= '".$toDate."'";
 		$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and ( transferType=5 or transferType=1 ) ) and supplierId> 0 ';
	   	
	   	$rows=$rs='';    
	   	?>
	   	<table class="servicetable" border="1">
		<thead>
			<tr>
			<td align="left">Transport</td>
			<td align="left">Supplier</td>
			<td align="left">Duration</td>
			<td align="right">Total Cost</td>
			<td align="right">Action</td>
			</tr>
		</thead>
		<tbody>
	   	<?php
		$transferQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' 1 and id="'.$serviceId.'" '); 	  
		$transferData=mysqli_fetch_array($transferQuery); 

	   	$rateId = $editId = 0;
		$rs=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,' transferNameId="'.$serviceId.'" and status=1 '.$whereMarket.' '.$seasonQuery.' '.$suppliersQuery.''); 
		if(mysqli_num_rows($rs)>0){	  
			while($dmcRateD=mysqli_fetch_array($rs)){ 

				$rateId = $dmcRateD['id']; 
				$saveRateId = $rateId;

				$rs2=GetPageRecord('*','docketTransportRateMaster',' serviceId="'.$serviceId.'" and status=1 '.$whereMarket.' '.$seasonQuery.' '.$suppliersQuery.' and rateId="'.$rateId.'" and queryId="'.$queryId.'"'); 	  
				if(mysqli_num_rows($rs2)>0){
					$dmcRateD=mysqli_fetch_array($rs2);
					$editId = $dmcRateD['id']; 
					$saveRateId = $editId;
				}
				$gstTax = $dmcRateD['gstTax'];
				$markupCost = $dmcRateD['markupCost'];
				$markupType = $dmcRateD['markupType'];

		    	$suppQuery="";
				$supname = '';
				$suppQuery=GetPageRecord('name,supplierNumber,id',_SUPPLIERS_MASTER_,'id="'.$dmcRateD['supplierId'].'"'); 
				$suppD=mysqli_fetch_array($suppQuery); 
				if($suppD['id'] > 0){ 
					$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
				} 

				// cost calculation
				$vechileCostWOGST = 0;
				$vechileCostWOGST = strip($dmcRateD['vehicleCost'])+strip($dmcRateD['parkingFee'])+strip($dmcRateD['representativeEntryFee'])+strip($dmcRateD['assistance'])+strip($dmcRateD['guideAllowance'])+strip($dmcRateD['interStateAndToll'])+strip($dmcRateD['miscellaneous']); 
				
				$gstValue=getGstValueById($dmcRateD['gstTax']); 
				$vechileCostWGST = round(($vechileCostWOGST*$gstValue/100)+$vechileCostWOGST); 
	  
				?>
				<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
				<td><?php echo strip($transferData['transferName']); ?></td>
				<td><?php echo strip($supname); ?></td>
				<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
				<td align="right"><?php echo getCurrencyName($dmcRateD['currencyId']);?> <?php echo getTwoDecimalNumberFormat($vechileCostWGST);?></td>
				<td>
					<button  type="button" class="whitembutton" onclick="addService(<?php echo $serviceId.','.$saveRateId.','.$vechileCostWOGST.','.$gstTax.','.$markupCost.','.$markupType.','.strtotime($fromDate).','.strtotime($toDate);?>);">
						<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select
					</button>
					<button  type="button" class="whitembutton" onclick="docket_alertbox('action=loadDocketTransportBreakupCost&queryId=<?php echo $queryId; ?>&rateId=<?php echo $rateId; ?>&editId=<?php echo $editId; ?>&serviceId=<?php echo $serviceId; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>','900px','auto');" >
						<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Breakup&nbsp;Cost
					</button>
				</td>
				</tr>
				<?php
			}
		}else{
			$rs2=GetPageRecord('*','docketTransportRateMaster',' serviceId="'.$serviceId.'" and status=1 '.$whereMarket.' '.$seasonQuery.' '.$suppliersQuery.' and rateId="'.$rateId.'" and queryId="'.$queryId.'"'); 	
			if(mysqli_num_rows($rs2)>0){	  
				while($dmcRateD=mysqli_fetch_array($rs2)){ 

					$editId = $dmcRateD['id']; 
					$saveRateId = $editId; 
					$markupCost = $dmcRateD['markupCost'];
					$markupType = $dmcRateD['markupType'];
					$gstTax = $dmcRateD['gstTax'];

			    	$suppQuery="";
					$supname = '';
					$suppQuery=GetPageRecord('name,supplierNumber,id',_SUPPLIERS_MASTER_,'id="'.$dmcRateD['supplierId'].'"'); 
					$suppD=mysqli_fetch_array($suppQuery); 
					if($suppD['id'] > 0){ 
						$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
					} 

					// cost calculation
					$vechileCostWOGST = 0;
					$vechileCostWOGST = strip($dmcRateD['vehicleCost'])+strip($dmcRateD['parkingFee'])+strip($dmcRateD['representativeEntryFee'])+strip($dmcRateD['assistance'])+strip($dmcRateD['guideAllowance'])+strip($dmcRateD['interStateAndToll'])+strip($dmcRateD['miscellaneous']); 
					
					$gstValue=getGstValueById($dmcRateD['gstTax']); 
					$vechileCostWGST = round(($vechileCostWOGST*$gstValue/100)+$vechileCostWOGST); 
		  
					?>
					<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
					<td><?php echo strip($transferData['transferName']); ?></td>
					<td><?php echo strip($supname); ?></td>
					<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
					<td align="right"><?php echo getCurrencyName($dmcRateD['currencyId']);?> <?php echo getTwoDecimalNumberFormat($vechileCostWGST);?></td>
					<td>
						<button  type="button" class="whitembutton" onclick="addService(<?php echo $serviceId.','.$saveRateId.','.$vechileCostWOGST.','.$gstTax.','.$markupCost.','.$markupType.','.strtotime($fromDate).','.strtotime($toDate);?>);">
							<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select
						</button>
						<button  type="button" class="whitembutton" onclick="docket_alertbox('action=loadDocketTransportBreakupCost&queryId=<?php echo $queryId; ?>&rateId=<?php echo $rateId; ?>&editId=<?php echo $editId; ?>&serviceId=<?php echo $serviceId; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>','900px','auto');" >
							<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Breakup&nbsp;Cost
						</button>
					</td>
					</tr>
					<?php
				}
			}else{

				?>
				<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
				<td><?php echo strip($transferData['transferName']); ?></td>
				<td>&nbsp;</td>
				<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
				<td align="center" style="color:red;"> </td>
				<td colspan="2" align="right" >
					<div style="width: 100px" class="editbtnselect" onclick="docket_alertbox('action=loadDocketTransportBreakupCost&queryId=<?php echo $queryId; ?>&rateId=0&editId=0&roomTypeId=<?php echo $roomTypeD['id']; ?>&mealPlanId=<?php echo $mealPlanId; ?>&serviceId=<?php echo $serviceId; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>','900px','auto');" ><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Add&nbsp;Rate</div>
				</td>
				</tr>
				<?php
			}
		}
		?>
		</tbody>
		</table>
		<script type="text/javascript">
		function addService(serviceId,rateId,serviceCost,gstTax,markupCost,markupType,fromDate,toDate){
		$('#loadserviceSaveBox').load("docket_frmaction.php?action=addServices&cityId=<?php echo $cityId; ?>&sType=<?php echo $sType; ?>&serviceId="+serviceId+"&rateId="+rateId+"&serviceCost="+serviceCost+"&gstTax="+gstTax+"&markupCost="+markupCost+"&markupType="+markupType+"&fromDate="+fromDate+"&toDate="+toDate+"&queryId=<?php echo $queryId; ?>");
		}
		</script>
		<div id="loadserviceSaveBox" style="display: none;"></div>
		<?php   
	} 
	if ($sType =='entrance') {

		$seasonQuery = "";
		$seasonQuery = " and DATE(fromDate) <= '".$fromDate."' and  DATE(toDate) >= '".$toDate."'";
 		$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and ( entranceType=4 or entranceType=1 ) ) and supplierId> 0 ';
	   	
	   	$rows=$rs='';    
	   	?>
	   	<table class="servicetable" border="1">
		<thead>
			<tr>
			<td align="left">Entrance Name</td>
			<td align="left">Supplier</td>
			<td align="center">Rate Duration</td>
			<td align="right">Total Cost</td>
			<td align="center">#</td>
			</tr>
		</thead>
		<tbody>
	   	<?php
		$rs=GetPageRecord('*',_DMC_ENTRANCE_RATE_MASTER_,' entranceNameId="'.$serviceId.'" and status=1 '.$whereMarket.' '.$seasonQuery.' '.$suppliersQuery.'');
		while($dmcRateD=mysqli_fetch_array($rs)){

			$entranceQuery=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' 1 and id="'.$serviceId.'" '); 	  
			$entranceData=mysqli_fetch_array($entranceQuery); 

	    	$suppQuery="";
			$supname = '';
			$suppQuery=GetPageRecord('name,supplierNumber,id',_SUPPLIERS_MASTER_,'id="'.$dmcRateD['supplierId'].'"'); 
			$suppD=mysqli_fetch_array($suppQuery); 
			if($suppD['id'] > 0){ 
				$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
			} 
			$GST = 0;
			// cost calculation
			$totalCost = 0;
			$adultCost = strip($dmcRateD['ticketAdultCost']);
			$childCost = strip($dmcRateD['ticketchildCost']);
			$infantCost = strip($dmcRateD['ticketinfantCost']);
			if($paxAdult>0){ $totalCost = $totalCost+round($adultCost*$paxAdult); }
			if($paxChild>0){ $totalCost = $totalCost+round($childCost*$paxChild); }
			if($paxInfant>0){ $totalCost = $totalCost+round($infantCost*$paxInfant); }
			?>
			<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
			<td><?php echo strip($entranceData['entranceName']); ?></td>
			<td><?php echo strip($supname); ?></td>
			<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
			<td><?php echo getCurrencyName($dmcRateD['currencyId']); ?> <?php echo getTwoDecimalNumberFormat($totalCost); ?></td>
			<td><div class="editbtnselect" onclick="addService('<?php echo $dmcRateD['id']; ?>','<?php echo $serviceId; ?>','<?php echo $GST; ?>','<?php echo $totalCost; ?>','<?php echo strtotime($fromDate); ?>','<?php echo strtotime($toDate); ?>');" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		<script type="text/javascript">
		function addService(rateId,serviceId,GST,serviceCost,fromDate,toDate){
		$('#loadserviceSaveBox').load("docket_frmaction.php?action=addServices&cityId=<?php echo $cityId; ?>&sType=<?php echo $sType; ?>&serviceId="+serviceId+"&rateId="+rateId+"&serviceCost="+serviceCost+"&GST="+GST+"&fromDate="+fromDate+"&toDate="+toDate+"&queryId=<?php echo $queryId; ?>");
		}
		</script>	
		<div id="loadserviceSaveBox" style="display: none;"></div>
		<?php    
	}
	if ($sType =='activity') {

		$seasonQuery = "";
		$seasonQuery = " and DATE(fromDate) <= '".$fromDate."' and  DATE(toDate) >= '".$toDate."'";
 		$suppliersQuery = ' and supplierId in ( select id from suppliersMaster where status=1 and deletestatus=0 and ( activityType=3 or activityType=1 ) ) and supplierId> 0 ';
	   	
	   	$rows=$rs='';    
	   	?>
	   	<table class="servicetable" border="1">
		<thead>
			<tr>
			<td align="left">Activity Name</td>
			<td align="left">Supplier</td>
			<td align="center">Rate Duration</td>
			<td align="right">Total Cost</td>
			<td align="center">#</td>
			</tr>
		</thead>
		<tbody>
	   	<?php
		$rs=GetPageRecord('*','dmcotherActivityRate',' serviceId="'.$serviceId.'" and status=1 '.$seasonQuery.' '.$suppliersQuery.' order by maxpax asc ');
		while($dmcRateD=mysqli_fetch_array($rs)){ 

			$activityQuery=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' 1 and id="'.$serviceId.'" '); 	  
			$activityData=mysqli_fetch_array($activityQuery); 

	    	$suppQuery="";
			$supname = '';
			$suppQuery=GetPageRecord('name,supplierNumber,id',_SUPPLIERS_MASTER_,'id="'.$dmcRateD['supplierId'].'"'); 
			$suppD=mysqli_fetch_array($suppQuery); 
			if($suppD['id'] > 0){ 
				$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
			} 
			$GST = 0;
			// cost calculation
			$totalCost = 0;
			$perPaxCost = strip($dmcRateD['perPaxCost']); 
			if($totalPax>0){ $totalCost = $totalCost+round($perPaxCost*$totalPax); }
			?>
			<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
			<td><?php echo strip($activityData['otherActivityName']); ?></td>
			<td><?php echo strip($supname); ?></td>
			<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
			<td><?php echo getCurrencyName($dmcRateD['currencyId']); ?> <?php echo getTwoDecimalNumberFormat($totalCost); ?></td>
			<td><div class="editbtnselect" onclick="addService('<?php echo $dmcRateD['id']; ?>','<?php echo $serviceId; ?>','<?php echo $GST; ?>','<?php echo $totalCost; ?>','<?php echo strtotime($fromDate); ?>','<?php echo strtotime($toDate); ?>');" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		<script type="text/javascript">
		function addService(rateId,serviceId,GST,serviceCost,fromDate,toDate){
		$('#loadserviceSaveBox').load("docket_frmaction.php?action=addServices&cityId=<?php echo $cityId; ?>&sType=<?php echo $sType; ?>&serviceId="+serviceId+"&rateId="+rateId+"&serviceCost="+serviceCost+"&GST="+GST+"&fromDate="+fromDate+"&toDate="+toDate+"&queryId=<?php echo $queryId; ?>");
		}
		</script>
		<div id="loadserviceSaveBox" style="display: none;"></div>
		<?php    
	}
	if ($sType =='restaurant') {
	   	$rows=$rs='';    
	   	?>
	   	<table class="servicetable" border="1">
		<thead>
			<tr>
			<td align="left">Restaurant Name</td>
			<td align="left">Supplier</td>
			<td align="center">Rate Duration</td>
			<td align="right">Total Cost</td>
			<td align="center">#</td>
			</tr>
		</thead>
		<tbody>
	   	<?php
		$rs=GetPageRecord('*',_DMC_RESTAURANT_RATE_MASTER_,' restaurantId="'.$serviceId.'" '); 	  
		while($dmcRateD=mysqli_fetch_array($rs)){ 

			$hotelQuery=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,' 1 and id="'.$serviceId.'" '); 	  
			$entranceData=mysqli_fetch_array($hotelQuery); 

	    	$suppQuery="";
			$supname = '';
			$suppQuery=GetPageRecord('name,supplierNumber,id',_SUPPLIERS_MASTER_,'id="'.$entranceData['supplierNameId'].'"'); 
			$suppD=mysqli_fetch_array($suppQuery); 
			if($suppD['id'] > 0){ 
				$supname = trim($suppD['name']).' - ['.$suppD['supplierNumber'].']';
			} 
			// cost calculation
			$gstValue  = getGstValueById($dmcRateD['RestaurantGST']);
			$totalCostWGST = 0;
			$perPaxCost = strip($dmcRateD['adultCost']);
			if($totalPax>0){ $TperPaxCost = round($perPaxCost*$totalPax); }
			$totalCostWGST = round(($TperPaxCost*$gstValue/100)+$TperPaxCost); 
			?>
			<tr id="rowRate<?php echo $dmcRateD['id']; ?>">
			<td><?php echo strip($entranceData['mealPlanName']); ?></td>
			<td><?php echo strip($supname); ?></td>
			<td><?php echo date('d-m-Y',strtotime($fromDate)).'/'.date('d-m-Y',strtotime($toDate)); ?></td>
			<td><?php echo getCurrencyName($dmcRateD['currencyId']); ?> <?php echo getTwoDecimalNumberFormat($totalCostWGST); ?></td>
			<td><div class="editbtnselect" onclick="addService('<?php echo $dmcRateD['id']; ?>','<?php echo $TperPaxCost; ?>','<?php echo $serviceId; ?>','<?php echo $dmcRateD['RestaurantGST']; ?>','<?php echo strtotime($fromDate); ?>','<?php echo strtotime($toDate); ?>');" ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		<script type="text/javascript">
		function addService(rateId,serviceCost,serviceId,GST,fromDate,toDate){
		$('#loadserviceSaveBox').load("docket_frmaction.php?action=addServices&cityId=<?php echo $cityId; ?>&sType=<?php echo $sType; ?>&serviceId="+serviceId+"&rateId="+rateId+"&serviceCost="+serviceCost+"&GST="+GST+"&fromDate="+fromDate+"&toDate="+toDate+"&queryId=<?php echo $queryId; ?>");
		}
		</script>
		<div id="loadserviceSaveBox" style="display: none;"></div>
		<?php   
	}
}

if($_REQUEST['action']=='loadAddNewServiceRate' && $_REQUEST['queryId']!='' && $_REQUEST['sType']!=''){ 
	$cityId = $_REQUEST['cityId'];
	$sType = $_REQUEST['sType'];
	$queryId = $_REQUEST['queryId'];
	
	$fromDate = date('Y-m-d',strtotime($_REQUEST['checkIn']));
	$toDate = date('Y-m-d',strtotime($_REQUEST['checkOut']));
	if($fromDate == $toDate){
		$toDate = date("Y-m-d", strtotime("+1 days", strtotime($toDate))); 
	} 

	$rows=$rs='';    
	$qQuery=GetPageRecord('*',_QUERY_MASTER_,' 1 and id="'.$queryId.'" '); 	  
	$queryData=mysqli_fetch_array($qQuery); 

	if($sType=='hotel'){
		?>
		<div class="contentclass">
		<h1 style="text-align:left;padding: 10px;background-color: #233a49;color: #fff;">Add New Hotel & Rates</h1>
		<div id="contentbox" class="addeditpagebox docketpagebox">
			<form action="docket_frmaction.php" method="post" name="form_hotelbreakup" target="actoinfrm" id="form_hotelbreakup">
			<input name="ADD_cityId" type="hidden"  value="<?php echo $cityId; ?>">
		   	<input name="ADD_sType" id="ADD_sType" type="hidden" value="<?php echo $sType; ?>"> 
		   	<input name="ADD_queryId" id="ADD_queryId" type="hidden" value="<?php echo $queryId; ?>">
		   	<input name="ADD_seasonType" id="ADD_seasonType" type="hidden" value="<?php echo $queryData['seasonType']; ?>">
		   	<input name="ADD_marketType" id="ADD_marketType" type="hidden" value="<?php echo $queryData['marketType']; ?>">
		   	<input name="action" type="hidden" value="AddNewServiceRate"> 
		   
			<table class="servicetable" border="0"  width="100%" cellpadding="0" cellspacing="0" >
				<tr><td colspan="6"><b>Hotel Detail</b><hr style=" width: 90%; margin: 13px 0 0 0; float: right; "></td></tr>
				<tr>
					<td width="15%"  colspan="3">
						<div class="griddiv ">
							<label>
								<div class="gridlable">Hotel Name</div>
								<input name="ADD_hotelName" id="ADD_hotelName" type="text" class="gridfield" placeholder="Hotel Name" >
							</label>
						</div>
					</td>
					<td width="20%">
						<div class="griddiv"><label>
							<div class="gridlable">Hotel&nbsp;Category<span class="redmind"></span></div>
							<select  name="ADD_hotelCategoryId" class="gridfield" autocomplete="off" displayname="Hotel Category"  >
								<?php
								$rs3='';
								$rs3=GetPageRecord('*','hotelCategoryMaster',' 1 and deletestatus=0 and status=1 order by hotelCategory asc');
								while($hotelCategoryData=mysqli_fetch_array($rs3)){ ?>
								<option value="<?php echo $hotelCategoryData['id'];?>" ><?php echo $hotelCategoryData['hotelCategory']." Star";?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td> 
					<td >	
						<div class="griddiv"><label>
							<div class="gridlable">Hotel&nbsp;Type<span class="redmind"></span></div>
							<select  name="ADD_hotelTypeId" class="gridfield " autocomplete="off"  displayname="Hotel Category"  >
								<?php
								$rs3='';
								$rs3=GetPageRecord('*','hotelTypeMaster',' 1 and deletestatus=0 and status=1 order by name asc');
								while($hotelTypeData=mysqli_fetch_array($rs3)){ ?>
								<option value="<?php echo $hotelTypeData['id'];?>"><?php echo $hotelTypeData['name'];?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>
					<td >	
						<div class="griddiv">
							<label>
								<div class="gridlable">Is Supplier<span class="redmind"></span></div>
								<select  name="ADD_supplier" class="gridfield " autocomplete="off" onchange="showSupplierSelection(this.value)">
									<option value="1">Yes</option>
									<option value="0" selected="selected">No</option>
								</select>
							</label>
						</div>
					</td>

				<!-- 	<td >
						<div class="griddiv ">
							<label>
								<div class="gridlable">Details</div>
								<input name="ADD_detail" type="text" class="gridfield " placeholder="Hotel Details" >
							</label>
						</div>
					</td>  -->
				</tr>
				<tr>
					<td colspan="6"> 
					<table width="100%" border="0" cellspacing="2" cellpadding="0">
					<tbody>
					<tr>
						<td width="70">
							<div class="griddiv">
								<label>
								<div class="gridlable">Division<span class="redmind"></span></div>
								<select name="ADD_division" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division"> 
									<?php  
									$selectd='*';    
									$whered=' deletestatus=0 and status=1 order by name asc';  
									$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
									while($resListingd=mysqli_fetch_array($rsd)){  
									?>
									<option value="<?php echo strip($resListingd['id']); ?>" ><?php echo strip($resListingd['name']); ?></option>
									<?php } ?>
								</select>
								</label>
							</div>
						</td>
						<td width="70">
							<div class="griddiv"><label>
								<div class="gridlable">Contact Person<span class="redmind"></span></div>
								<input name="ADD_contactPerson" type="text" class="gridfield validate" value="" displayname="Contact Person" maxlength="100" placeholder="Contact Person">
								</label>
							</div>
						</td>
						<td width="70">
							<div class="griddiv"><label>
								<div class="gridlable">Designation<span class="redmind"></span></div>
								<input name="ADD_designation" type="text" class="gridfield validate" value="" displayname="Designation" placeholder="Designation">
								</label>
							</div>
						</td>
						<td width="40">
							<div class="griddiv"><label>
								<div class="gridlable">CountryCode<span class="redmind"></span></div>
								<input name="ADD_countryCode" type="text" class="gridfield validate" value="+91" displayname="Country Code" placeholder="+91">
								</label>
							</div>
						</td>
						<td width="80">
							<div class="griddiv"><label>
								<div class="gridlable">Phone<span class="redmind"></span></div>
								<input name="ADD_phone" type="text" class="gridfield validate" value="" displayname="Phone" placeholder="Phone">
								</label>
							</div>
						</td>
						<td width="120">
							<div class="griddiv"><label>
								<div class="gridlable">Email<span class="redmind"></span></div>
								<input name="ADD_email" type="email" class="gridfield validate " value="" displayname="Email" placeholder="Email" required="">
								</label>
							</div>
						</td>
					</tr>
					</tbody>
					</table>
					</td>  
				</tr>
				<tr>
					<td colspan="6"> 
					<table width="100%" border="0" cellspacing="2" cellpadding="0">
						<tbody>
						<tr>
						<td width="100">
							<div class="griddiv"><label>
								<div class="gridlable">Country<span class="redmind"></span></div>
								<select name="ADD_countryId" id="ADD_countryId" class="gridfield validate" displayname="Country" autocomplete="off" onchange="loadstate(this.value);" >
									<option value="0">Select Country</option>
									<?php
									$rs="";
									$rs=GetPageRecord('*',_COUNTRY_MASTER_,' deletestatus=0 and status=1 order by name asc');
									while($countryData=mysqli_fetch_array($rs)){
									?>
									<option value="<?php echo strip($countryData['id']); ?>" <?php if($countryData['name']=='India'){ ?>selected="selected"<?php } ?>><?php echo strip($countryData['name']); ?></option>
									<?php } ?>
								</select></label>
							</div>
						</td>
						<td  width="100">
							<div class="griddiv"><label>
								<div class="gridlable">State</div>
								<select name="ADD_stateId" id="ADD_stateId" class="gridfield" displayname="State" autocomplete="off" onchange="loadcity(this.value);" >
									<?php
									$rs="";
									$rs=GetPageRecord('*',_STATE_MASTER_,' 1 and countryId in ( select id from '._COUNTRY_MASTER_.' where name="India" ) order by name asc');
									while($stateData=mysqli_fetch_array($rs)){
									?>
									<option value="<?php echo strip($stateData['id']); ?>" ><?php echo strip($stateData['name']); ?></option>
									<?php } ?>
								</select></label>
							</div>
						</td>
						<td  width="100">
							<div class="griddiv"><label>
								<div class="gridlable">City</div>
								<select name="ADD_cityMasterId" id="ADD_cityMasterId" class="gridfield" displayname="City" autocomplete="off" >
								</select></label>
							</div>
						</td>
						<td width="60">
							<div class="griddiv"><label>
								<div class="gridlable">Pin Code</div>
								<input name="ADD_pinCode" type="text" class="gridfield validate" displayname="Pin Code" placeholder="Pin Code">
								</label>
							</div>
						</td>
						<td width="80">
							<div class="griddiv"><label>
								<div class="gridlable">GSTN.</div>
								<input name="ADD_gstn" type="text" class="gridfield validate" displayname="GSTN" placeholder="GSTN">
								</label>
							</div>
						</td>
						<td width="120">
							<div class="griddiv"><label>
								<div class="gridlable">Address</div>
								<input name="ADD_address" type="text" class="gridfield validate" displayname="Address" placeholder="Address">
								</label>
							</div>
						</td>
						</tr>
						</tbody>
					</table>
					</td>  
				</tr>
				<tr><td colspan="6"><b>Rate Sheet</b><hr style=" width: 90%; margin: 13px 0 0 0; float: right; "></td></tr>
				<tr>
					<td width="15%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Currency<span class="redmind"></span></div>
							<select class="selectBoxDest" name="ADD_currencyId">
								<option value="">Select Currency</option>
								<?php 
								$rs2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and status=1 order by name asc');
								while($curD=mysqli_fetch_array($rs2)){  
								?><option value="<?php echo strip($curD['id']); ?>" ><?php echo strip($curD['name']); ?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>
					<td width="20%">
						<div class="griddiv ADD_supplierIdBox" >
							<label>
							<div class="gridlable">Supplier Name<span class="redmind"></span></div>
							<select class="selectBoxDest" name="ADD_supplierId" id="ADD_supplierId">
								<option value="">Select Supplier</option>
								<?php 
								$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and status=1 and companyTypeId=1 and name!="" order by name asc'); 
								while($supplierData=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($supplierData['id']); ?>" ><?php echo strip($supplierData['name']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
						<div class="griddiv ADD_supplierIdBox" style="display: none;"><label>
							<div class="gridlable">Supplier Name</div>
							<input name="ADD_supplierIdText" id="ADD_supplierIdText" type="text" class="gridfield "  placeholder="Supplier" readonly>
							</label>
						</div>
					</td> 

					<td width="15%">
						<div class="griddiv " >
							<label>
							<div class="gridlable">Room Type<span class="redmind"></span></div>
							<select class="selectBoxDest" name="ADD_RoomTypeId">
								<option value="">Select Room</option>
								<?php 
								$rs2=GetPageRecord('*',_ROOM_TYPE_MASTER_,' name!="" and deletestatus=0 and status=1 order by name asc'); 
								while($resListing=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($roomTypeId == $resListing['id']){ ?>selected<?php } ?>><?php echo strip($resListing['name']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
					</td>
					<td width="15%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Meal Plan<span class="redmind"></span></div>
							<select class="selectBoxDest" name="ADD_MealPlanId">
								<option value="">Select Meal</option>
								<?php 
								$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,' name!="" and deletestatus=0 and status=1 order by name asc'); 
								while($resListing=mysqli_fetch_array($rs2)){  
								?><option value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['name']); ?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv ">
						<label>
						<div class="gridlable">RoomGst Slab<span class="redmind"></span></div>
						<select class="selectBoxDest" name="ADD_RoomGST">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1 order by gstValue'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" ><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
						<label>
						<div class="gridlable">MealGst Slab<span class="redmind"></span></div>
						<select class="selectBoxDest" name="ADD_mealGST">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Restaurant" and status=1  order by gstValue'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" ><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
						</div>
					</td> 
				</tr>
				<tr>	
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">From Date<span class="redmind"></span></div>
								<input name="ADD_fromDate" type="text" class="gridfield zebraDate calfieldicon" value="<?php echo $fromDate; ?>" placeholder="From Date"  readonly>
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">To Date<span class="redmind"></span></div>
								<input name="ADD_toDate" type="text" class="gridfield zebraDate calfieldicon" value="<?php echo $toDate; ?>" placeholder="To Date" readonly >
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Single<span class="redmind"></span></div>
								<input name="ADD_singleCost" type="text" class="gridfield " onkeyup="numericFilter(this);" placeholder="Single" >
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Double<span class="redmind"></span></div>
								<input name="ADD_doubleCost" type="text" class="gridfield " onkeyup="numericFilter(this);" placeholder="Double" >
							</label>
						</div>
					</td>
				
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ExtraBed(A)<span class="redmind"></span></div>
								<input name="ADD_ExtraBedACost" type="text" class="gridfield " onkeyup="numericFilter(this);" placeholder="extraBedA">
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ExtraBed(C)<span class="redmind"></span></div>
								<input name="ADD_ExtraBedCCost" type="text" class="gridfield " onkeyup="numericFilter(this);" placeholder="extraBedC">
							</label>
						</div>
					</td>  
				</tr>
				<tr>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Breakfast<span class="redmind"></span></div>
								<input name="ADD_breakfastCost" type="text" class="gridfield " onkeyup="numericFilter(this);" placeholder="Breakfast">
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Lunch<span class="redmind"></span></div>
								<input name="ADD_lunchCost" type="text" class="gridfield " onkeyup="numericFilter(this);" placeholder="Lunch">
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Dinner<span class="redmind"></span></div>
								<input name="ADD_dinnerCost" type="text" class="gridfield " onkeyup="numericFilter(this);" placeholder="Dinner">
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
							<div class="gridlable">Markup Type<span class="redmind"></span></div>
							<select class="selectBoxDest" name="ADD_MarkupType">
								<option value="1" <?php if($dmcRateD['markupType'] == 1){ ?>selected<?php } ?>>%</option>
								<option value="2" <?php if($dmcRateD['markupType'] == 2){ ?>selected<?php } ?>>Flat</option>
							</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Markup<span class="redmind"></span></div>
								<input name="ADD_Markup" type="text" class="gridfield " onkeyup="numericFilter(this);"  placeholder="Markup Cost">
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">TAC(%)<span class="redmind"></span></div>
								<input name="ADD_TAC" type="text" class="gridfield " onkeyup="numericFilter(this);"  placeholder="roomTAC">
							</label>
						</div>
					</td>
					
				</tr>
				<tr>
					<td colspan="6">
						<div class="griddiv ">
							<label>
								<div class="gridlable">Remarks(%)<span class="redmind"></span></div>
								<input name="ADD_remarks" type="text" class="gridfield "  placeholder="Remarks">
							</label>
						</div>
					</td>
				</tr>
			</table>
			</form>
			<script type="text/javascript">
				function loadcity(stateId){
					$('#ADD_cityMasterId').load('loadcity.php?id='+stateId);
				}
				function loadstate(countryId){
					$('#ADD_stateId').load('loadstate.php?id='+countryId); 
				}
				function showSupplierSelection(status){
					if(status>0){
						$('#ADD_supplierId').removeClass('validate');
						$('#ADD_supplierIdText').val($('#ADD_hotelName').val());
						$('.ADD_supplierIdBox').toggle();
					}else{
						$('#ADD_supplierId').addClass('validate');
						$('#ADD_supplierIdText').val('');
						$('.ADD_supplierIdBox').toggle();
					}
				}
			</script>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td>
							<input name="addnewuserbtn" type="button" class="bluembutton saveBtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('form_hotelbreakup','saveBtn','0');">
						</td>
						<td style="padding-right:20px;">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="docket_alertboxClose();">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		<?php
	}
	if($sType=='transportation'){
		?>
		<div class="contentclass">
		<h1 style="text-align:left;padding: 10px;background-color: #233a49;color: #fff;">Add New Transport & Rates</h1>
		<div id="contentbox" class="addeditpagebox docketpagebox">
			<form action="docket_frmaction.php" method="post" name="form_hotelbreakup" target="actoinfrm" id="form_hotelbreakup">
			<input name="ADD_cityId" id="ADD_cityId" type="hidden"  value="<?php echo $cityId; ?>">
		   	<input name="ADD_sType" id="ADD_sType" type="hidden" value="<?php echo $sType; ?>"> 
		   	<input name="ADD_queryId" id="ADD_queryId" type="hidden" value="<?php echo $queryId; ?>">
		   	<input name="ADD_transferCategory" id="ADD_transferCategory" type="hidden" value="transportation">
		   	<input name="action" type="hidden" value="AddNewServiceRate"> 

		   	<input name="ADD_fromDate" id="ADD_fromDate" type="hidden" value="<?php echo $fromDate; ?>">
		   	<input name="ADD_toDate" id="ADD_toDate" type="hidden" value="<?php echo $toDate; ?>">

			<table class="servicetable" border="0"  width="100%" cellpadding="0" cellspacing="0" >
				<tr><td colspan="5"><b>Transportation Detail</b><hr style=" width: 82%; margin: 13px 0 0 0; float: right; "></td></tr>
				<tr>
					<td width="15%" colspan="2">
						<div class="griddiv ">
							<label>
								<div class="gridlable">Transportation Name <span class="redmind"></span></div>
								<input name="ADD_transferName" type="text" class="gridfield" id="ADD_transferName" placeholder="Transportation ">
							</label>
						</div>
					</td>
					<td width="20%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Transfer Type<span class="redmind"></span></div>
							<select class="selectBoxDest" id="ADD_transferType" name="ADD_transferType">
								<?php  
								$rs=GetPageRecord('*','transferTypeMaster',' deletestatus=0 and status=1 order by id asc');  
								while($resListing=mysqli_fetch_array($rs)){  
								?> 
								<option value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['name']); ?></option> 
								<?php } ?> 
							</select>
							</label>
						</div>
					</td> 
					<td colspan="2">
						<div class="griddiv ">
							<label>
								<div class="gridlable">Details<span class="redmind"></span></div>
								<input name="ADD_detail" type="text" class="gridfield " id="ADD_detail" >
							</label>
						</div>
					</td>
				</tr>
				<tr><td colspan="5"><b>Rate Sheet</b><hr style=" width: 90%; margin: 13px 0 0 0; float: right; "></td></tr>
				<tr>
					<td width="15%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Currency<span class="redmind"></span></div>
							<select class="selectBoxDest" id="ADD_currencyId" name="ADD_currencyId">
								<option value="">Select Currency</option>
								<?php 
								$rs2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and status=1 order by name asc');
								while($curD=mysqli_fetch_array($rs2)){  
								?><option value="<?php echo strip($curD['id']); ?>" <?php if($dmcRateD['currencyId'] == $curD['id']){ ?>selected<?php } elseif($curD['setDefault']==1){ ?>selected<?php } ?>><?php echo strip($curD['name']); ?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>
					<td width="20%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Supplier Name<span class="redmind"></span></div>
							<select class="selectBoxDest" id="ADD_supplierId" name="ADD_supplierId">
								<option value="">Select Supplier</option>
								<?php 
								$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and status=1 and transferType=5 and name!="" order by name asc'); 
								while($supplierData=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($supplierData['id']); ?>" <?php if($dmcRateD['supplierId'] == $supplierData['id']){ ?>selected<?php } ?>><?php echo strip($supplierData['name']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
					</td> 

					<td width="25%">
						<div class="griddiv " >
							<label>
							<div class="gridlable">Vehicle Name<span class="redmind"></span></div>
							<select class="selectBoxDest" id="ADD_vehicleModelId" name="ADD_vehicleModelId">
								<option value="">Select Room</option>
								<?php 
								$rs2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,' deletestatus=0 and status=1 order by model asc'); 
								while($vehicleD=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($vehicleD['id']); ?>" <?php if($dmcRateD['vehicleModelId'] == $vehicleD['id']){ ?>selected<?php } ?>><?php echo strip($vehicleD['model']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv ">
						<label>
						<div class="gridlable">GST Slab(%)<span class="redmind"></span></div>
						<select class="selectBoxDest" id="ADD_gstTax" name="ADD_gstTax">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1 order by gstValue'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$dmcRateD['gstTax']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
						</div>
					</td>
				
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">VEHICLE COST <span class="redmind"></span></div>
								<input name="ADD_vehicleCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_vehicleCost" value="<?php echo $dmcRateD['vehicleCost']; ?>" >
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">From Date<span class="redmind"></span></div>
								<input name="ADD_fromDate" type="text" class="gridfield zebraDate calfieldicon" value="<?php echo $fromDate; ?>" placeholder="From Date"  readonly>
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">To Date<span class="redmind"></span></div>
								<input name="ADD_toDate" type="text" class="gridfield zebraDate calfieldicon" value="<?php echo $toDate; ?>" placeholder="To Date" readonly >
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">PARKING FEE<span class="redmind"></span></div>
								<input name="ADD_parkingFee" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_parkingFee" value="<?php echo $dmcRateD['parkingFee']; ?>" >
							</label>
						</div>
					</td>
					
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">CAPACITY<span class="redmind"></span></div>
								<input name="ADD_capacity" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_capacity" value="<?php echo $dmcRateD['capacity']; ?>" >
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">EPRESENTATIVE ENTRY FEE<span class="redmind"></span></div>
								<input name="ADD_representativeEntryFee" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_representativeEntryFee" value="<?php echo $dmcRateD['representativeEntryFee']; ?>" >
							</label>
						</div>
					</td> 

				</tr>
				<tr>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ASSISTANCE<span class="redmind"></span></div>
								<input name="ADD_assistance" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_assistance" value="<?php echo $dmcRateD['assistance']; ?>" >
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ADDITIONAL ALLOWANCE<span class="redmind"></span></div>
								<input name="ADD_guideAllowance" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_guideAllowance" value="<?php echo $dmcRateD['guideAllowance']; ?>" >
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">INTER STATE & TOLL<span class="redmind"></span></div>
								<input name="ADD_interStateAndToll" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_interStateAndToll" value="<?php echo $dmcRateD['interStateAndToll']; ?>" >
							</label>
						</div>
					</td> 
				 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">MISC. COST<span class="redmind"></span></div>
								<input name="ADD_miscellaneous" type="text" class="gridfield " onkeyup="numericFilter(this);" id="ADD_miscellaneous" value="<?php echo $dmcRateD['miscellaneous']; ?>" >
							</label>
						</div>
					</td> 

					<td >
						<div class="griddiv ">
							<label>
								<div class="gridlable">Remarks<span class="redmind"></span></div>
								<input name="ADD_remarks" type="text" class="gridfield " id="ADD_remarks" value="<?php echo $remarks; ?>" >
							</label>
						</div>
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td>
							<input name="addnewuserbtn" type="button" class="bluembutton saveBtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('form_hotelbreakup','saveBtn','0');">
						</td>
						<td style="padding-right:20px;">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="docket_alertboxClose();">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		<?php
	}
}

if($_REQUEST['action']=='loadDocketHotelBreakupCost' && $_REQUEST['queryId']!='' && $_REQUEST['serviceId']!=''){

	$rateId = $_REQUEST['rateId']; 
	$editId = $_REQUEST['editId']; 
	$serviceId = $_REQUEST['serviceId'];
	$queryId = $_REQUEST['queryId'];
	$fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
	$toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
	$rsa2s=GetPageRecord('*','docketHotelRateMaster',' serviceId="'.$serviceId.'" and id="'.$editId.'" and queryId="'.$queryId.'" ');  
	if(mysqli_num_rows($rsa2s) > 0){
		//provision to edit rates for this quotations
		$dmcRateD = mysqli_fetch_array($rsa2s);

		$editId = $dmcRateD['id'];
		$rateId = $dmcRateD['rateId'];
		$roomTypeId = $dmcRateD['roomType'];
		$mealPlanId = $dmcRateD['mealPlan'];
		$extraBedA = $dmcRateD['extraBedA'];		
		$extraBedC = $dmcRateD['extraBedC'];	
	}elseif($rateId!=0 && $rateId!=''){
		//provision to add rate from exists dmc rates for this quotation
		$rs1=GetPageRecord('*',_DMC_ROOM_TARIFF_MASTER_,'id="'.$rateId.'"');
		$dmcRateD=mysqli_fetch_array($rs1);

		$rateId = $dmcRateD['id'];
		$editId = 0;
		$roomTypeId = $dmcRateD['roomType'];
		$mealPlanId = $dmcRateD['mealPlan'];		
		$extraBedA = $dmcRateD['extraBed'];		
		$extraBedC = $dmcRateD['childwithbed'];		
	}else{
		//provision to add new rate only for this quotaiton
		$rateId = 0;
		$editId = 0;
		$roomTypeId = $_REQUEST['roomTypeId'];
		$mealPlanId = $_REQUEST['mealPlanId'];
	}

	$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
	$queryData = mysqli_fetch_array($rs1);

	// BKP - Breakup Cost
	$hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' 1 and id ="'.$serviceId.'"'); 
	$hotelData=mysqli_fetch_array($hotelQuery); 

	if($serviceId>0){
		?>
		<div class="contentclass">
		<h1 style="text-align:left;padding: 10px;background-color: #233a49;color: #fff;">Edit Hotel Breakup Cost </h1>
		<div id="contentbox" class="addeditpagebox docketpagebox">
			<form action="docket_frmaction.php" method="post" name="form_hotelbreakup" target="actoinfrm" id="form_hotelbreakup">
			<input name="BKP_editId" id="BKP_editId" type="hidden"  value="<?php echo $editId; ?>">
		   	<input name="BKP_rateId" id="BKP_rateId" type="hidden" value="<?php echo $rateId; ?>">
		   	<input name="BKP_serviceId" id="BKP_serviceId" type="hidden" value="<?php echo $serviceId; ?>">
		   	<input name="BKP_fromDate" id="BKP_fromDate" type="hidden" value="<?php echo $fromDate; ?>">
		   	<input name="BKP_toDate" id="BKP_toDate" type="hidden" value="<?php echo $toDate; ?>">
		   	<input name="BKP_queryId" id="BKP_queryId" type="hidden" value="<?php echo $queryId; ?>">
		   	<input name="BKP_seasonType" id="BKP_seasonType" type="hidden" value="<?php echo $queryData['seasonType']; ?>">
		   	<input name="action" type="hidden" value="loadDocketHotelBreakupCost"> 

			<table class="servicetable" border="0"  width="100%" cellpadding="0" cellspacing="0" >
				<tr>
					<td width="15%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Currency<span class="redmind"></span></div>
							<select class="selectBoxDest validate" id="BKP_currencyId" name="BKP_currencyId">
								<option value="">Select Currency</option>
								<?php 
								$rs2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and status=1 order by name asc');
								while($curD=mysqli_fetch_array($rs2)){  
								?><option value="<?php echo strip($curD['id']); ?>" <?php if($dmcRateD['currencyId'] == $curD['id']){ ?>selected<?php } elseif($curD['setDefault']==1){ ?>selected<?php } ?>><?php echo strip($curD['name']); ?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>
					<td width="20%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Supplier Name<span class="redmind"></span></div>
							<select class="selectBoxDest validate" id="BKP_supplierId" name="BKP_supplierId">
								<option value="">Select Supplier</option>
								<?php 
								$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and status=1 and companyTypeId=1 and name!="" order by name asc'); 
								while($supplierData=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($supplierData['id']); ?>" <?php if($dmcRateD['supplierId'] == $supplierData['id']){ ?>selected<?php } ?>><?php echo strip($supplierData['name']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
					</td> 

					<td width="15%">
						<div class="griddiv " >
							<label>
							<div class="gridlable">Room Type<span class="redmind"></span></div>
							<select class="selectBoxDest validate" id="BKP_RoomTypeId" name="BKP_RoomTypeId">
								<option value="">Select Room</option>
								<?php 
								$rs2=GetPageRecord('*',_ROOM_TYPE_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
								while($resListing=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($roomTypeId == $resListing['id']){ ?>selected<?php } ?>><?php echo strip($resListing['name']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
					</td>
					<td width="15%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Meal Plan<span class="redmind"></span></div>
							<select class="selectBoxDest validate" id="BKP_MealPlanId" name="BKP_MealPlanId">
								<option value="">Select Meal</option>
								<?php 
								$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
								while($resListing=mysqli_fetch_array($rs2)){  
								?><option value="<?php echo strip($resListing['id']); ?>" <?php if($mealPlanId == $resListing['id']){ ?>selected<?php } ?>><?php echo strip($resListing['name']); ?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv ">
						<label>
						<div class="gridlable">RoomGst Slab<span class="redmind"></span></div>
						<select class="selectBoxDest validate" id="BKP_RoomGST" name="BKP_RoomGST">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1 order by gstValue'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$dmcRateD['roomGST']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
						<label>
						<div class="gridlable">MealGst Slab<span class="redmind"></span></div>
						<select class="selectBoxDest validate" id="BKP_mealGST" name="BKP_mealGST">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Restaurant" and status=1  order by gstValue'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$dmcRateD['mealGST']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
						</div>
					</td> 
				</tr>
				<tr>	
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Single</div>
								<input name="BKP_singleCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_singleCost" value="<?php echo $dmcRateD['singleoccupancy']; ?>" >
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Double</div>
								<input name="BKP_doubleCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_doubleCost" value="<?php echo $dmcRateD['doubleoccupancy']; ?>" >
							</label>
						</div>
					</td>
				
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ExtraBed(A)</div>
								<input name="BKP_ExtraBedACost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_ExtraBedACost" value="<?php echo $extraBedA; ?>" >
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ExtraBed(C)</div>
								<input name="BKP_ExtraBedCCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_ExtraBedCCost" value="<?php echo $extraBedC; ?>" >
							</label>
						</div>
					</td> 

					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Breakfast</div>
								<input name="BKP_breakfastCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_breakfastCost" value="<?php echo $dmcRateD['breakfast']; ?>" >
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Lunch</div>
								<input name="BKP_lunchCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_lunchCost" value="<?php echo $dmcRateD['lunch']; ?>" >
							</label>
						</div>
					</td> 
				</tr>
				<tr>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Dinner</div>
								<input name="BKP_dinnerCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_dinnerCost" value="<?php echo $dmcRateD['dinner']; ?>" >
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
							<div class="gridlable">Markup Type</div>
							<select class="selectBoxDest" id="BKP_MarkupType" name="BKP_MarkupType">
								<option value="1" <?php if($dmcRateD['markupType'] == 1){ ?>selected<?php } ?>>%</option>
								<option value="2" <?php if($dmcRateD['markupType'] == 2){ ?>selected<?php } ?>>Flat</option>
							</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">Markup</div>
								<input name="BKP_Markup" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_Markup" value="<?php echo $dmcRateD['markupCost']; ?>" >
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">TAC(%)</div>
								<input name="BKP_TAC" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_TAC" value="<?php echo $dmcRateD['roomTAC']; ?>" >
							</label>
						</div>
					</td>

					<td colspan="2">
						<div class="griddiv ">
							<label>
								<div class="gridlable">Remarks</div>
								<input name="BKP_remarks" type="text" class="gridfield "  id="BKP_remarks" value="<?php echo $dmcRateD['remarks']; ?>" >
							</label>
						</div>
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td>
							<input name="addnewuserbtn" type="button" class="bluembutton saveBtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('form_hotelbreakup','saveBtn','0');">
						</td>
						<td style="padding-right:20px;">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="docket_alertboxClose();">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		<?php
	}else{
		echo "Hotel Id empty";
	}
	
}

if($_REQUEST['action']=='loadDocketTransportBreakupCost' && $_REQUEST['queryId']!='' && $_REQUEST['serviceId']!=''){
	// docketTransportRateMaster
	$rateId = $_REQUEST['rateId']; 
	$editId = $_REQUEST['editId']; 
	$serviceId = $_REQUEST['serviceId'];
	$queryId = $_REQUEST['queryId'];
	$fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
	$toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
	$rsa2s=GetPageRecord('*','docketTransportRateMaster',' serviceId="'.$serviceId.'" and id="'.$editId.'" and queryId="'.$queryId.'" ');  
	if(mysqli_num_rows($rsa2s) > 0){
		//provision to edit rates for this quotations
		$dmcRateD = mysqli_fetch_array($rsa2s);
		$editId = $dmcRateD['id'];
		$rateId = $dmcRateD['rateId'];
		$remarks = $dmcRateD['remarks'];
	}elseif($rateId!=0 && $rateId!=''){
		//provision to add rate from exists dmc rates for this quotation
		$rs1=GetPageRecord('*',_DMC_TRANSFER_RATE_MASTER_,'id="'.$rateId.'"');
		$dmcRateD=mysqli_fetch_array($rs1);

		$rateId = $dmcRateD['id'];
		$editId = 0;
		$remarks = $dmcRateD['detail'];
	}else{
		//provision to add new rate only for this quotaiton
		$rateId = 0;
		$editId = 0;
	}

	$rs1=GetPageRecord('*',_QUERY_MASTER_,' id="'.$queryId.'"'); 
	$queryData = mysqli_fetch_array($rs1);
 
	if($serviceId>0){
		?>
		<div class="contentclass">
		<h1 style="text-align:left;padding: 10px;background-color: #233a49;color: #fff;">Edit Transport Breakup Cost </h1>
		<div id="contentbox" class="addeditpagebox docketpagebox">
			<form action="docket_frmaction.php" method="post" name="form_hotelbreakup" target="actoinfrm" id="form_hotelbreakup">
			<input name="BKP_editId" id="BKP_editId" type="hidden"  value="<?php echo $editId; ?>">
		   	<input name="BKP_rateId" id="BKP_rateId" type="hidden" value="<?php echo $rateId; ?>">
		   	<input name="BKP_serviceId" id="BKP_serviceId" type="hidden" value="<?php echo $serviceId; ?>">
		   	<input name="BKP_fromDate" id="BKP_fromDate" type="hidden" value="<?php echo $fromDate; ?>">
		   	<input name="BKP_toDate" id="BKP_toDate" type="hidden" value="<?php echo $toDate; ?>">
		   	<input name="BKP_queryId" id="BKP_queryId" type="hidden" value="<?php echo $queryId; ?>">
		   	<input name="BKP_transferCategory" id="BKP_transferCategory" type="hidden" value="transportation">
		   	<input name="action" type="hidden" value="loadDocketTransportBreakupCost"> 

			<table class="servicetable" border="0"  width="100%" cellpadding="0" cellspacing="0" >
				<tr>
					<td width="15%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Currency<span class="redmind"></span></div>
							<select class="selectBoxDest" id="BKP_currencyId" name="BKP_currencyId">
								<option value="">Select Currency</option>
								<?php 
								$rs2=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and status=1 order by name asc');
								while($curD=mysqli_fetch_array($rs2)){  
								?><option value="<?php echo strip($curD['id']); ?>" <?php if($dmcRateD['currencyId'] == $curD['id']){ ?>selected<?php } elseif($curD['setDefault']==1){ ?>selected<?php } ?>><?php echo strip($curD['name']); ?></option>
								<?php } ?>
							</select>
							</label>
						</div>
					</td>
					<td width="20%">
						<div class="griddiv ">
							<label>
							<div class="gridlable">Supplier Name<span class="redmind"></span></div>
							<select class="selectBoxDest" id="BKP_supplierId" name="BKP_supplierId">
								<option value="">Select Supplier</option>
								<?php 
								$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' deletestatus=0 and status=1 and transferType=5 and name!="" order by name asc'); 
								while($supplierData=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($supplierData['id']); ?>" <?php if($dmcRateD['supplierId'] == $supplierData['id']){ ?>selected<?php } ?>><?php echo strip($supplierData['name']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
					</td> 

					<td width="25%">
						<div class="griddiv " >
							<label>
							<div class="gridlable">Vehicle Name<span class="redmind"></span></div>
							<select class="selectBoxDest" id="BKP_vehicleModelId" name="BKP_vehicleModelId">
								<option value="">Select Room</option>
								<?php 
								$rs2=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,' deletestatus=0 and status=1 order by model asc'); 
								while($vehicleD=mysqli_fetch_array($rs2)){  
									?>
									<option value="<?php echo strip($vehicleD['id']); ?>" <?php if($dmcRateD['vehicleModelId'] == $vehicleD['id']){ ?>selected<?php } ?>><?php echo strip($vehicleD['model']); ?></option>
									<?php 
								} ?>
							</select>
							</label>
						</div>
					</td>

					<td>
						<div class="griddiv ">
						<label>
						<div class="gridlable">GST Slab(%)<span class="redmind"></span></div>
						<select class="selectBoxDest" id="BKP_gstTax" name="BKP_gstTax">
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Hotel" and status=1 order by gstValue'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){
							?>
							<option value="<?php echo $gstSlabData['id'];?>" <?php if($gstSlabData['id']==$dmcRateD['gstTax']){ ?>selected="selected"<?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
						</div>
					</td>
				
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">VEHICLE COST <span class="redmind"></span></div>
								<input name="BKP_vehicleCost" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_vehicleCost" value="<?php echo $dmcRateD['vehicleCost']; ?>" >
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">PARKING FEE<span class="redmind"></span></div>
								<input name="BKP_parkingFee" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_parkingFee" value="<?php echo $dmcRateD['parkingFee']; ?>" >
							</label>
						</div>
					</td>
					
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">CAPACITY<span class="redmind"></span></div>
								<input name="BKP_capacity" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_capacity" value="<?php echo $dmcRateD['capacity']; ?>" >
							</label>
						</div>
					</td>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">EPRESENTATIVE ENTRY FEE<span class="redmind"></span></div>
								<input name="BKP_representativeEntryFee" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_representativeEntryFee" value="<?php echo $dmcRateD['representativeEntryFee']; ?>" >
							</label>
						</div>
					</td> 

					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ASSISTANCE<span class="redmind"></span></div>
								<input name="BKP_assistance" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_assistance" value="<?php echo $dmcRateD['assistance']; ?>" >
							</label>
						</div>
					</td> 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">ADDITIONAL ALLOWANCE<span class="redmind"></span></div>
								<input name="BKP_guideAllowance" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_guideAllowance" value="<?php echo $dmcRateD['guideAllowance']; ?>" >
							</label>
						</div>
					</td> 
				</tr>
				<tr>
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">INTER STATE & TOLL<span class="redmind"></span></div>
								<input name="BKP_interStateAndToll" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_interStateAndToll" value="<?php echo $dmcRateD['interStateAndToll']; ?>" >
							</label>
						</div>
					</td> 
				 
					<td>
						<div class="griddiv ">
							<label>
								<div class="gridlable">MISC. COST<span class="redmind"></span></div>
								<input name="BKP_miscellaneous" type="text" class="gridfield " onkeyup="numericFilter(this);" id="BKP_miscellaneous" value="<?php echo $dmcRateD['miscellaneous']; ?>" >
							</label>
						</div>
					</td> 

					<td colspan="3">
						<div class="griddiv ">
							<label>
								<div class="gridlable">Remarks<span class="redmind"></span></div>
								<input name="BKP_remarks" type="text" class="gridfield " id="BKP_remarks" value="<?php echo $remarks; ?>" >
							</label>
						</div>
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td>
							<input name="addnewuserbtn" type="button" class="bluembutton saveBtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('form_hotelbreakup','saveBtn','0');">
						</td>
						<td style="padding-right:20px;">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="docket_alertboxClose();">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		<?php
	}else{
		echo "Transportation Id empty";
	}
	
}

if($_REQUEST['action']=='deleteService' && $_REQUEST['id']!='' ){
	?>
	<div class="contentclass">
	<h1 style="text-align:left;padding: 10px;background-color: #233a49;color: #fff;">Are you sure you want to delete this service??</h1>
	<div id="contentbox" class="addeditpagebox docketpagebox">
		<form action="docket_frmaction.php" method="post" name="form_hotelbreakup" target="actoinfrm" id="form_hotelbreakup">
		<input name="DLT_Id" id="DLT_Id" type="hidden"  value="<?php echo $_REQUEST['id']; ?>">
	   	<input name="action" type="hidden" value="deleteService"> 
		</form>
	</div>
	<div id="buttonsbox" style="text-align:center;">
		<table border="0" align="center" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td>
						<input name="addnewuserbtn" type="button" class="bluembutton saveBtn" id="addnewuserbtn" value="    Yes, Delete    " onclick="formValidation('form_hotelbreakup','saveBtn','0');">
					</td>
					<td style="padding-right:20px;">
						<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="docket_alertboxClose();">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	</div>
	<?php
}
?>
