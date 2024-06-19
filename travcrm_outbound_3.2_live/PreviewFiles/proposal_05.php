 
<style>
    @media only screen and (max-width: 600px) {
      .container {
        width: 100% !important;
      }
    }
    @media print{
		.proposalHeader{
			margin-top: 30px !important;
		}
	}
    </style>
<div class="main-container fullwidth" style="position:relative !important;">
<table class="fullwidth" border="1" style="border-color: #233a49;" cellpadding="0" cellspacing="0" >
	<tr>
	<td style="border-color: #233a49;">
	<?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="10" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
    if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ 
        ?><?php
    }
	?>

	 
	<?php		
	// New quotation days starts ------------------------------
	$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 
		?>
		<table width="100%" border="1" style="border-color: #233a49;" cellpadding="10" cellspacing="0" class="borderedTable" ><tr><td style="border-color: #233a49;left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo 'black'; } ?>; font-size: 18px;font-weight: 600;">&nbsp;&nbsp; <?php echo 'Day '.$day.' | '. date('j-F-Y',strtotime($dayDate));?></td></tr></table> 
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" >
			<tr><td style="border-color: #233a49;">
			    <div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-weight: normal;font-size: 14px;"><?php
					
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
						if($sorting3['serviceType'] == 'flight' ){
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
	<br />
	<br />
	<?php  
	$_REQUEST['parts'] = "normalValueAddedServices";
	include('proposal_parts.php');


	$totalHotel = 0;
	$sorting3='';
	$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
	if(mysqli_num_rows($b1)>0){
	?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" style="border-color: #233a49;" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;Hotel Information</td></tr></table> 

		<table width="100%" border="1" cellpadding="20" cellspacing="0" style="border-color: #233a49;">
		<tr>
		<td>
			<table width="100%" border="1" align="left" rules="all" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable table-service" style="page-break-inside: always;page-break-after: auto;page-break-before: auto;width: 100%;font-size:14px !important;border:1px solid #ccc !important;">
			 	<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border:1px solid #ccc !important;">
					<th style="border-color: #233a49;" width="25%" align="left" valign="middle" ><strong>Check In / Check Out Dates</strong></th>
					<th style="border-color: #233a49;" width="20%" align="left" valign="middle" ><strong>City</strong></th>
					<th style="border-color: #233a49;" width="30%" align="left" valign="middle" ><strong>Hotel</strong></th>
					<th style="border-color: #233a49;" width="25%" align="left" valign="middle" ><strong>Room Type</strong></th>
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
							<tr style="">
							<td style="border-color: #233a49;" valign="middle"><strong>
								<?php 
								echo date('j M Y',strtotime($sorting3['startDate']));  
								?></strong>
							</td>
							<td style="border-color: #233a49;" valign="middle"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
						 
							<td style="border-color: #233a49;" valign="middle"><?php echo "Hotel :- ".strip($hotelData['hotelName']).'<br> '.'<a target="_blank" href="'.$hotelData['url'].'">'.$hotelData['url'].'</a>' ; 

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
							<td style="border-color: #233a49;" valign="middle"><?php 
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
	<table width="100%" border="1" cellpadding="10" cellspacing="0" style="border-color: #233a49;" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;Quotation</td></tr></table> 
	<?php 
	$queryId = $resultpageQuotation['queryId'];
	$quotationId= $resultpageQuotation['id'];
	$_REQUEST['parts'] = 'costingDetail';

	if($_REQUEST['parts'] == 'costingDetail'){ ?>


			<table width="100%" border="0" align="center" cellpadding="20" cellspacing="0">
			<tr>
				<td>
				<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#ccc" class="borderedTable" style="font-size: 14px !important;"> 
					<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
						<td align="center"><strong>Currency</strong></td>
						<td align="center"><strong>Single&nbsp;Basis</strong></td>
						<td align="center"><strong>Double&nbsp;Basis</strong></td>
						<td align="center"><strong>Triple&nbsp;Basis</strong></td>
						<td align="center"><strong>Quad&nbsp;Basis</strong></td>
						<td align="center"><strong>ExtraBed(A)</strong></td>
						<td align="center"><strong>ExtraBed(C)</strong></td>
						<td align="center"><strong>Childwithoutbed</strong></td>
						<td align="center"><strong>Infant Basis</strong></td>
					</tr>
					<tr>
						<?php 
						${"final_cost".$slabId11} =  (${"proposalCost".$slabId11}+$resultpageQuotation['otherLocationCost']);
						?>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
					</tr>
			</table>
			</td>
			</tr>
		</table>



 	<?php

		}

	
	
	
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