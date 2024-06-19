<style>
	@media print{
		.proposalHeader{
			margin-top: 30px !important;
		}
	}
</style>.
<div class="main-container fullwidth" style="position:relative !important;">
<table class="fullwidth">
	<tr>
		<td>
	<?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="2" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
    if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?> 	
    	<table  width="100%" border="0" cellpadding="10" cellspacing="0" class="proposalHeader">
			<tbody>
				<tr>
					<td align="center" valign="top">
						<img src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhoto3); ?>" width="600" height="75" >
					</td>
				</tr>
			</tbody>
		</table>
		<?php
    }
	?>

	<table width="100%" border="0" cellpadding="10" cellspacing="0" >
		<tr><td align="center" colspan="2"><h3>Brief Proposal</h3></td></tr>
		<tr>
			<td width="50%" rowspan="3" valign="middle" >
				<strong style="padding: 20px 0;font-size:16px;"><?php echo strip($quotationSubject); ?></strong> 
			</td>
			<td width="50%" align="left" style="color:#000; border-left:1px solid #CCC;"><strong style="display:inline-block;">Printed On: <?php echo date('d/m/Y H:i:s a');?></strong></td>
		</tr>
		<tr>
			<td width="50%" align="left"  style="color:#000;border-left:1px solid #CCC;"><strong style="display:inline-block;">Enq. No: <?php echo $quotPreviewId; ?></strong></td>
		</tr>
		<tr>
			<td width="50%" align="left"  style="color:#000;border-left:1px solid #CCC;"><strong style="display:inline-block;">No of Pax: <?php echo $totalPax; ?></strong></td>
		</tr>
	</table>
	<BR>
	<?php		
	// New quotation days starts ------------------------------
		$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 
		?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo date('l',strtotime($dayDate));?> <?php echo date('j M Y',strtotime($dayDate));?></td></tr></table> 
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" >
			<tr><td>
			<div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-weight: normal;font-size: 14px;"><?php
					if(strlen($QueryDaysData['title'])>1) { 
						echo "<strong>".urldecode(strip($QueryDaysData['title']))."</strong><br>"; 
					
					} 
					$html = trim(urldecode(strip($QueryDaysData['description'])));
					if($html!=''){
						// $html = str_replace('<p>&nbsp;</p>', '', $html);
						// = html_tidy('</p>', $html);
						echo  html_tidy($html);
					}
					// services list
					$cnt1 = 1;
					$itiQuery1 = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'"  and dayId="'.$dayId.'" order by srn asc';
					$itineryDay1=GetPageRecord('*','quotationItinerary',$itiQuery1);  
					$totolDays1 = mysqli_num_rows($itineryDay1);
					while($sorting3 = mysqli_fetch_array($itineryDay1)){ 	  
						if($sorting3['serviceType'] == 'hotel' ){
							$where22='quotationId="'.$quotationId.'"  and dayId="'.$dayId.'"  and  supplierId="'.$sorting3['serviceId'].'"';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){ 
								$hotelQouteData=mysqli_fetch_array($rs22); 								
								$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');  
								$hotelData=mysqli_fetch_array($rs1ee); 
								echo "<p>".$cnt1.") <strong>Hotel:</strong> Stay at ".stripslashes($hotelData['hotelName'])."</p>";		
								// if($cnt1 < $totolDays1){ echo "<br />"; }  				
							}	 
						}	
						if($sorting3['serviceType'] == 'flight' && $resultpageQuotation['flightCostType']==0){
							$where22flt1='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"'; 
							$rs22flt1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22flt1);
							if(mysqli_num_rows($rs22flt1) > 0){ 
								$flightQuoteData = mysqli_fetch_array($rs22flt1);
								
								$rs1=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData['flightId'].'"');  
								$flightData=mysqli_fetch_array($rs1);
								
								if(date('H:i',strtotime($flightQuoteData['departureTime'])) <> '05:30'){
									$departureTime = " at ".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
								}else{
									$departureTime ='';
								}	
								if(date('H:i',strtotime($flightQuoteData['arrivalTime'])) <> '05:30'){
									$arrivalTime = date('Hi',strtotime($flightQuoteData['arrivalTime']));
								}else{
									$arrivalTime ='';
								}	 
								
								$jfrom = getDestination($flightQuoteData['departureFrom']);
								$jto= getDestination($flightQuoteData['arrivalTo']); 

								echo "<p>".$cnt1.") <strong>Flight:</strong> ".strip($flightData['flightName']).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass'])."</p>"; 

								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							} 
						}	
						if($sorting3['serviceType'] == 'train' ){ 
							
								$where22='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"'; 
								$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
								if(mysqli_num_rows($rs22) > 0){ 
									$trainQuoteData=mysqli_fetch_array($rs22);

									$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
									$trainData=mysqli_fetch_array($rs1);  

									$journeyType="";
									$jfrom = getDestination($trainQuoteData['departureFrom']);
									$jto= getDestination($trainQuoteData['arrivalTo']);

									if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '05:30'){
									$departureTimet = " at ".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
									}else{
									$departureTimet ='';
									}	
									if(date('H:i',strtotime($trainQuoteData['arrivalTime'])) <> '05:30'){
									$arrivalTimet = date('Hi',strtotime($trainQuoteData['arrivalTime']));
									}else{
									$arrivalTimet = '';
									}


								if($trainQuoteData['journeyType']=='overnight_journey'){ $journeyType="(Overnight)"; }
								else{ $journeyType="(Day)"; }

									echo "<p>".$cnt1.") <strong>Train:</strong> ".strip($trainData['trainName']).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$departureTimet.$arrivalTimet.'/ '.str_replace('_',' ',$trainQuoteData['trainClass'])."</p>"; 

									// if($cnt1 < $totolDays1){ echo "<br />"; }  
								} 	
						}	
						
						if($sorting3['serviceType'] == 'transfer' || $sorting3['serviceType'] == 'transportation'){  
						
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'" ';						
							$b=GetPageRecord('*','quotationTransferMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$transferQuotData=mysqli_fetch_array($b); 
								$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');  
								$transferData=mysqli_fetch_array($rsentn); 

								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferQuotData['vehicleModelId'].'"');
								$vename=mysqli_fetch_array($rs1aa);

								$vehicleName = $vehicleType = $trnsferType = '';
								if($transferQuotData['transferType'] == 2){
									$vehicleName = $vename['model']." | ";
									$vehicleType = getVehicleTypeName($vename['carType'])." | ";
								}
								$trnsferType = ($transferQuotData['transferType'] == 1)?'SIC | ':'Private | ';
								
								echo "<p>".$cnt1.") <strong>".ucfirst($sorting3['serviceType'])." : </strong> ".$trnsferType.$vehicleType.$vehicleName.ucfirst(strip($transferData['transferName']))."</p>";
							}
						}
						if($sorting3['serviceType'] == 'entrance'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*','quotationEntranceMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$entranceQuotData=mysqli_fetch_array($b); 
								$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entranceQuotData['entranceNameId'].'"');  
								$entranceData=mysqli_fetch_array($rsentn); 

								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$entranceQuotData['vehicleId'].'"');
								$vename=mysqli_fetch_array($rs1aa);

								$vehicleName = $vehicleType = $trnsferType = '';
								if($entranceQuotData['transferType'] == 2){
									$vehicleName = $vename['model']." | ";
									$vehicleType = getVehicleTypeName($vename['carType'])." | ";
								}
								
								if($entranceQuotData['transferType']==1){ $trnsferType = " (SIC) "; }elseif($entranceQuotData['transferType']==2){ $trnsferType = " (PVT) "; }elseif($entranceQuotData['transferType']==3){ $trnsferType = " (Ticket Only) "; } 
								
								echo "<p>".$cnt1.") <strong>Entrance : </strong>".$vehicleType.$vehicleName.ucfirst(strip($entranceData['entranceName']))." ".$trnsferType."</p>";
							}
						} 
						if($sorting3['serviceType'] == 'ferry'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$ferryQuotData=mysqli_fetch_array($b); 
								
								$rsentn=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$ferryQuotData['serviceid'].'"');  
								$ferryData=mysqli_fetch_array($rsentn); 
								echo  "<p>".$cnt1.") <strong>Ferry:</strong> ".strip($ferryData['name'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
							}
						}

						if($sorting3['serviceType'] == 'cruise'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_CRUISE_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$cruiseQuotData=mysqli_fetch_array($b); 
								
								$rs52=GetPageRecord('*','cruiseMaster',' id="'.$cruiseQuotData['serviceId'].'" ');  
								$cruiseData=mysqli_fetch_array($rs52);   
								echo  "<p>".$cnt1.") <strong>Cruise:</strong> ".strip($cruiseData['cruiseName'])."</p>";
							}
						}

						if($sorting3['serviceType'] == 'activity'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$activityQuotData=mysqli_fetch_array($b);

								$transferType = '';
							if($activityQuotData['transferType']==1){
								$transferType = '(SIC)';
							}elseif($activityQuotData['transferType']==2){
								$transferType = '(PVT)';
							}elseif($activityQuotData['transferType']==3){
								$transferType = '(VIP)';
							}elseif($activityQuotData['transferType']==4){
								$transferType = '(Ticket Only)';
							}

								$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id ="'.$activityQuotData['otherActivityName'].'"');  
								$activityData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Sightseeing: </strong> ".strip($activityData['otherActivityName'])." ".$transferType."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								//perPaxCost
							}
						} 
						if($sorting3['serviceType'] == 'enroute'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*','quotationEnrouteMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$enrouteQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*','packageBuilderEnrouteMaster',' id ="'.$enrouteQuotData['enrouteId'].'"');  
								$enrouteData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Enroute:</strong> ".strip($enrouteData['enrouteName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								//adultCost
							}
						} 
						if($sorting3['serviceType'] == 'mealplan'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$mealplanQuotData=mysqli_fetch_array($b);
								echo  "<p>".$cnt1.") <strong>Restaurant :</strong> ".strip($mealplanQuotData['mealPlanName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							}
						} 
						if($sorting3['serviceType'] == 'additional'){ 
							
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'" and additionalId in ( select id from extraQuotation where proposalService=1) ';						
							$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$additionalQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
								$extraData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Additional:</strong> ".strip($extraData['name'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							}
						}  
						if($sorting3['serviceType'] == 'guide'){  
							$b=$where2="";		
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'" ';	
							$b=GetPageRecord('*','quotationGuideMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$guideQuotData=mysqli_fetch_array($b);
							 
									$rs5="";  
								$rs5=GetPageRecord('*','tbl_guidesubcatmaster','id="'.$guideQuotData['guideId'].'"'); 
								$guideData=mysqli_fetch_array($rs5); 
								echo  "<p>".$cnt1.") <strong>Guide:</strong> ".strip($guideData['name'])."</p>"; 
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								 
							}
						}
						$cnt1++;
					}
					?>
				</div>
			</td>	
			</tr>
		</table>
		<?php 	 
		$day++; 
	} ?>
	<br />	
	<?php if($resultpageQuotation['queryType']!=13){ ?>
	<table width="100%">
	<tr>
		<td colspan="2" align="center"><strong>End of the tour</strong></td>
	</tr>
	</table>
	<br />
	<br />
	<?php 
	
	$_REQUEST['parts'] = "normalValueAddedServices";
	include('proposal_parts.php');
	
	?>	

	<!-- <br />	  -->
	<table width="100%" cellpadding="20" cellspacing="0">
		<tr>
			<td align="center"><img src="<?php echo $fullurl; ?>images/end-of-tour.png" width="780"  height="40" /></td>
		</tr>
	</table>
	<!-- <br />  -->
	<?php 
	}
	
	$totalHotel = 0;
	$sorting3='';
	$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
	if(mysqli_num_rows($b1)>0){
	?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;HOTELS PROPOSED</td></tr></table> 

		<table width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table width="100%" border="1" align="left" cellpadding="10" cellspacing="0" bordercolor="#ddd" class="borderedTable table-service" style="page-break-inside: always;page-break-after: auto;page-break-before: auto;width: 100%;font-size:14px !important;">
			 	<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th width="25%" align="left" valign="middle" ><strong>Dates</strong></th>
					<th width="20%" align="left" valign="middle" ><strong>City</strong></th>
					<th width="30%" align="left" valign="middle" ><strong>Hotel</strong></th>
					<th width="25%" align="left" valign="middle" ><strong>Room Type</strong></th>
		 			<!-- <th width="17%" align="left" valign="middle" ><strong>Remarks</strong></th> -->
				</tr>
				<?php 
				// $totalHotel = 0;
				// $sorting3='';
				// $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
				while($sorting3=mysqli_fetch_array($b1)){  
				
					$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' supplierId="'.$sorting3['serviceId'].'" and dayId="'.$sorting3['dayId'].'"  and isHotelSupplement!=1 and isRoomSupplement!=1');  
					if(mysqli_num_rows($b) > 0){
						while($hotelQuotData=mysqli_fetch_array($b)){
							$hotelTypeLable = '';
							if($hotelQuotData['isLocalEscort']==1){
						        $hotelTypeLable .= "Local Escort,";
						    }
						    if($hotelQuotData['isForeignEscort']==1){
						        $hotelTypeLable .= "Foreign Escort,";
						    }
						    if($hotelQuotData['isGuestType']==1){
						        // $hotelTypeLable .= "Guest,";
						    }

							$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
							$hotelData=mysqli_fetch_array($d);
							
							$start = strtotime($hotelQuotData['fromDate']);
							$end = strtotime($hotelQuotData['toDate']);
							$days_between='';
							$days_between = ceil(abs($end - $start) / 86400);
							?> 
							<tr>
							<td valign="middle"><strong>
								<?php 
								echo date('j M Y',strtotime($sorting3['startDate']));  
								?></strong>
							</td>
							<td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
						 
							<td valign="middle"><?php echo "Hotel :- ".strip($hotelData['hotelName']).'<br> '.'<a target="_blank" href="'.$hotelData['url'].'">'.$hotelData['url'].'</a>' ; 

								$rtype='';
								$select121='*';  
								 $where121='hotelQuotId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'" '; 
								$rs12=GetPageRecord($select121,'quotationHotelAdditionalMaster',$where121); 
								while ($editresult2=mysqli_fetch_array($rs12)) {
									$rtype  .= $editresult2['name'].', ';
								}
								echo "<br><br>Additionals: ".rtrim($rtype,', ');
								?>
							</td>
							<td valign="middle"><?php 
							$select12='*';  
							$where12='id="'.$hotelQuotData['roomType'].'"'; 
							$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
							$editresult2=mysqli_fetch_array($rs12);
							echo $rtype=$editresult2['name'];
							?></td>
							<!-- <td valign="middle"></td> -->
					  		</tr>
					  		<?php
					  	} 
				  	} 
				} ?>
			</table>
		</td>
		</tr>
		</table>
		<?php } ?>
		<br />

	<!-- Total Tour Cost and per person basis costs details -->
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;COSTING DETAILS</td></tr></table> 
	<?php 
	$queryId = $resultpageQuotation['queryId'];
	$quotationId= $resultpageQuotation['id'];
	$_REQUEST['parts'] = 'costingDetail';
	include('proposal_parts.php');
	
	if($resultpageQuotation['queryType']==13){
		$_REQUEST['parts'] = 'multiServicesQuery';
		include('proposal_parts.php');
	}
	

	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){  ?> 
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;AIR FARE SUPPLEMENT</td></tr></table>
	<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc" width="100%">
		<tr>
			<td>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size:14px !important;" >
				<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
					<th width="15%" valign="middle" bgcolor="#133f6d" style="text-align: left;"><strong>Date</strong></th>
					<th width="17%" valign="middle" bgcolor="#133f6d" style="text-align: left;"><strong>Sector</strong></th>
					<th width="15%" valign="middle" bgcolor="#133f6d" style="text-align: left;"><strong>Departure<br>Date/Time</strong></th>
					<th width="15%" valign="middle" bgcolor="#133f6d" style="text-align: left;"><strong>Arrival<br>Date/Time</strong></th>
					<th width="20%" valign="middle" bgcolor="#133f6d" style="text-align: left;"><strong>Class/Baggage</strong></th>
					<th width="13%" align="right" valign="middle" bgcolor="#133f6d" style="text-align: left;"><strong>Fare</strong></th>
				</tr>
				<?php 
				
				while($flightQuotData=mysqli_fetch_array($betet)){ 
		           
					$d5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');  
					$flightData=mysqli_fetch_array($d5); 

					$departurefrom = getDestination($flightQuotData['departureFrom']);
					$arrivalTo = getDestination($flightQuotData['arrivalTo']);

					$c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$flightQuotData['id'].'" and quotationId="'.$flightQuotData['quotationId'].'" and dayId="'.$flightQuotData['dayId'].'"');
					$timeData = mysqli_fetch_assoc($c1);
					?> 
				  	<tr>
						<td valign="middle"><strong>
						<?php 
						echo date('j M Y',strtotime($flightQuotData['fromDate']));  
						?></strong></td>
						<td valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
						<td align="left"><?php if($timeData['departureDate']!=''){ echo date('d-m-Y', strtotime($timeData['departureDate'])).'<br>'.date('H:i:s', strtotime($timeData['departureTime'])); } ?></td>	
						<td align="left"><?php if($timeData['arrivalDate']!=''){ echo date('d-m-Y', strtotime($timeData['arrivalDate'])).'<br>'.date('H:i:s', strtotime($timeData['arrivalTime'])); } ?></td>		
						<td valign="middle"><?php echo str_replace('_',' ',$flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
						<td valign="middle"><?php echo getCurrencyName($newCurr); ?> <?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?></td>
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
	<?php 
	}  
	if($resultpageQuotation['queryType']!=13){
	$_REQUEST['parts'] = "supplementValueAddedServices";
	include('proposal_parts.php');
	}

 	$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isRoomSupplement=1 '); 
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=1 '); 

	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0  ){
		?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;SUPPLEMENT SERVICES</td></tr></table>
		<?php
	}
	// INCLUDE SUPPLEMENT HOTEL AND RATE HERE
	$suppRoomQuery=$checkSuppHQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isRoomSupplement=1 ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0){ ?>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'hotelSupplement';
			include('proposal_parts.php');
			?></td></tr></table>
		<?php 
	}   

	// additional requirment 
	$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.($quotationId).'" group by serviceType order by id asc');
	if( mysqli_num_rows($c12) > 0){ ?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;ADDITIONAL EXPERIENCES ( SUPPLEMENTS )</td></tr></table>

		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'additionalSupplement';
			include('proposal_parts.php');
			?></td></tr></table> 
		<?php 
	} 
	?>

	<!-- <br /> -->
	<?php  if($overviewText!=''){ ?> 
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;OVERVIEW</td></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($overviewText)); ?></td></tr></table>
	<?php } if($inclusion!=''){ ?>
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo $inclusionTitle; ?></td></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($inclusion)); ?></td></tr></table>
	<?php } if($exclusion!=''){ ?> 
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo $exclusioinTitle; ?></td></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($exclusion)); ?></td></tr></table>
	<?php } if($tncText!=''){ ?> 
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo $termCTitle; ?></td></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($tncText)); ?></td></tr></table>
	<?php } if($specialText!=''){ ?> 
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo $cancelPTitle; ?></td></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($specialText)); ?></td></tr></table>
	<?php } if($paymentpolicy!=''){ ?> 
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo $paymentPTitle; ?></td></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($paymentpolicy)); ?></td></tr></table>
	<?php } if($remarks!=''){ ?> 
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo $remarksTitle; ?></td></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" style="font-size:14px !important;"><tr><td valign="top"><?php echo html_tidy(strip($remarks)); ?></td></tr></table>
	<?php } 
	
	
	$_REQUEST['parts'] = 'emeragencyContactDetail';
	include('proposal_parts.php');
	?>

	<?php 
	$selectF= 'footerstatus, footertext';
	$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
    $resultf = mysqli_fetch_assoc($resfooter);
	if($resultf['footerstatus']==1){ ?> 
	<table width="100%" cellpadding="20" cellspacing="0" border="0" ><tr>
	<td align="center"><a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" ><?php if($resultf['footertext']!=''){ echo $resultf['footertext']; }else{ ?> Generated by TravCRM <?php } ?> </a></td></tr></table>
	<?php } ?>
	

			</td>
		</tr>
	</table>
</div>