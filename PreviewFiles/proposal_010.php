<style>
	@media print{
		.proposalHeader{
			margin-top: 30px !important;
		}
	} 
	/* hotel main sec css started  */
	.HotelSecMain{
		/* background-color: red; */
	}

	.mainHotelSecTable{
		border:1px solid black;
  		border-collapse: collapse;
	}
	.hTH{
		border:1px solid black;
  		border-collapse: collapse;
	}

	/* table, th, td {
  border:1px solid black;
  border-collapse: collapse;
} */
	/* hotel main sec css Ended */
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
    	<table  width="100%" border="0" cellpadding="10" cellspacing="0" class="proposalHeader" style="display: none;">
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

	<table width="100%" border="0" cellpadding="10" cellspacing="0" style="display: none;">
		<tr><td align="center" colspan="2"><h3>Text Proposal</h3></td></tr>
		<!-- <tr>
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
		</tr> -->
	</table>
	<!-- <BR> -->
	<?php		
	// New quotation days starts ------------------------------
		$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 
		?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px; display:none;">&nbsp;&nbsp;<?php echo date('l',strtotime($dayDate));?> <?php echo date('j M Y',strtotime($dayDate));?></td></tr></table> 
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" style="display: none;">
			<tr><td>
			<div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-weight: normal;font-size: 14px;"><?php
					if(strlen($QueryDaysData['title'])>1) { 
						// echo "<strong>".urldecode(strip($QueryDaysData['title']))."</strong><br>"; 
					
					} 
					// $html = trim(urldecode(strip($QueryDaysData['description'])));
					if($html!=''){
						// $html = str_replace('<p>&nbsp;</p>', '', $html);
						// = html_tidy('</p>', $html);
						// echo  html_tidy($html);
					}
					// services list
					$cnt1 = 1;
					$itiQuery1 = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'"  and dayId="'.$dayId.'" order by srn asc';
					$itineryDay1=GetPageRecord('*','quotationItinerary',$itiQuery1);  
					$totolDays1 = mysqli_num_rows($itineryDay1);
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
		<!-- <td colspan="2" align="center"><strong>End of the tour</strong></td> -->
	</tr>
	</table>
	
	<?php 
	
	$_REQUEST['parts'] = "normalValueAddedServices";
	include('proposal_parts.php');
	
	?>	

	<!-- <br />	  -->
	<table width="100%" cellpadding="20" cellspacing="0">
		<tr>
			<!-- <td align="center"><img src="<?php echo $fullurl; ?>images/end-of-tour.png" width="780"  height="40" /></td> -->
		</tr>
	</table>
	<!-- <br />  -->
	<?php 
	}
	
	$num=1;
	$totalHotel = 0;
	$sorting3='';
	$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
	if(mysqli_num_rows($b1)>0){
	?>
		<!-- <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="">&nbsp;&nbsp;eeHOTELS PROPOSED</td></tr></table>  --> 
		<table width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc" >
		<tr>
		<td> 
			<?php 

			// GST DATA 
			$gstType = $resultpageQuotation['gstType'];
			if ($resultpageQuotation['serviceTax']>0) {
			    $serviceTax = $resultpageQuotation['serviceTax'];
			} else {
			    $serviceTax = 0;
			}

			if($resultpageQuotation['tcs']>0){
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

			// DISCOUNT DATA
			$discountType = $resultpageQuotation['discountType'];
			$discount = $resultpageQuotation['discount'];


			$c12='';
			$c12=GetPageRecord('*','quotationServiceMarkup',' quotationId="'.$resultpageQuotation['id'].'"'); 
			$serviceMarkupD = mysqli_fetch_array($c12); 
			if($isUni_Mark == 0 && $isSer_Mark == 1 ){  
				$hotelM = $serviceMarkuD['hotel'];
			    $hotelMarkupType = $serviceMarkuD['hotelMarkupType'];
			    $transferM = $serviceMarkuD['transfer'];
			    $transferMarkupType = $serviceMarkuD['transferMarkupType'];
			    $trainM = $serviceMarkuD['train'];
			    $trainMarkupType = $serviceMarkuD['trainMarkupType'];
			    $flightM = $serviceMarkuD['flight'];
			    $flightMarkupType = $serviceMarkuD['flightMarkupType'];
			    $guideM = $serviceMarkuD['guide'];
			    $guideMarkupType = $serviceMarkuD['guideMarkupType'];
			    $activityM = $serviceMarkuD['activity'];
			    $activityMarkupType = $serviceMarkuD['activityMarkupType'];
			    $entranceM = $serviceMarkuD['entrance'];
			    $entranceMarkupType = $serviceMarkuD['entranceMarkupType'];
			    $restaurantM = $serviceMarkuD['restaurant'];
			    $restaurantMarkupType = $serviceMarkuD['restaurantMarkupType'];
			    $otherM = $serviceMarkuD['other']; 
			    $otherMarkupType = $serviceMarkuD['otherMarkupType']; 
			    $markupType = $resultpageQuotation['markupType'];
			}else{
				$hotelM = $serviceMarkuD['hotel'];
			    $hotelMarkupType = $serviceMarkuD['hotelMarkupType'];
			    $transferM = $serviceMarkuD['transfer'];
			    $transferMarkupType = $serviceMarkuD['transferMarkupType'];
			    $trainM = $serviceMarkuD['train'];
			    $trainMarkupType = $serviceMarkuD['trainMarkupType'];
			    $flightM = $serviceMarkuD['flight'];
			    $flightMarkupType = $serviceMarkuD['flightMarkupType'];
			    $guideM = $serviceMarkuD['guide'];
			    $guideMarkupType = $serviceMarkuD['guideMarkupType'];
			    $activityM = $serviceMarkuD['activity'];
			    $activityMarkupType = $serviceMarkuD['activityMarkupType'];
			    $entranceM = $serviceMarkuD['entrance'];
			    $entranceMarkupType = $serviceMarkuD['entranceMarkupType'];
			    $restaurantM = $serviceMarkuD['restaurant'];
			    $restaurantMarkupType = $serviceMarkuD['restaurantMarkupType'];
			    $otherM = $serviceMarkuD['other']; 
			    $otherMarkupType = $serviceMarkuD['otherMarkupType']; 
			    $markupType = $resultpageQuotation['markupType'];
			}



			$textPropContent = '';
			?> 
			<table width="100%" border="1" align="center" cellpadding="10" cellspacing="0" bordercolor="#ddd" class="borderedTable table-service" style="page-break-inside: always;page-break-after: auto;page-break-before: auto;width: 100%;font-size:14px !important;">
			 	<tr style="padding: 10px 29px !important; color:black;text-align: center;">
				 	
					<!-- <th width="5%" align="center" valign="middle" ><strong>Sr. No.</strong></th> -->
					<th width="20%" align="center" valign="middle" ><strong>Check in - Check out <br>Date</strong></th>
					<th width="15%" align="center" valign="middle" ><strong>Hotel Name</strong></th>
					<!-- <th width="13%" align="center" valign="middle" ><strong>City</strong></th> -->
					<th width="10%" align="center" valign="middle" ><strong>Room Type</strong></th>
					<th width="10%" align="center" valign="middle" ><strong>Meal Plan</strong></th>
					<th width="14%" align="center" valign="middle" ><strong>No. of Rooms</strong></th>
					<th width="20%" align="center" valign="middle" ><strong>Room (<?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>) <br>Per Person </strong></th> 
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

							$TotalRooms = $hotelQuotData['singleNoofRoom']+$hotelQuotData['doubleNoofRoom']+$hotelQuotData['twinNoofRoom']+$hotelQuotData['tripleNoofRoom']+$hotelQuotData['quadNoofRoom']+$hotelQuotData['sixNoofBedRoom']+$hotelQuotData['eightNoofBedRoom']+$hotelQuotData['tenNoofBedRoom'];

							$select12='*';  
							$where12='id="'.$hotelQuotData['roomType'].'"'; 
							$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
							$editresult2=mysqli_fetch_array($rs12);
							$rtype=$editresult2['name'];

							$rs2='';  
							$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotelQuotData['mealPlan'].''); 
							$editresult2=mysqli_fetch_array($rs2);
								if($editresult2['subname']!=''){
								$mealType = clean($editresult2['subname'].' '.$breakfast.'  '.$lunch.' '.$dinner);
							}else{
								$mealType = clean($editresult2['name'].' '.$breakfast.' '.$lunch.' '.$dinner);
							}

							$currencyName = getCurrencyName($hotelQuotData['currencyId']);


							$nofroomText = '';
							$roomWiseRateText = '';
							// No. of Rooms : 03 Single 
							if($hotelQuotData['singleNoofRoom']>0 && $hotelQuotData['singleoccupancy']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['singleNoofRoom']).' Single, ';
							
								$singleoccupancy = getPerPersonBasisCost($hotelQuotData['singleoccupancy'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($singleoccupancy).' net per room per night on Single<br>';
							}
							if($hotelQuotData['doubleNoofRoom']>0 && $hotelQuotData['doubleoccupancy']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['doubleNoofRoom']).' Double, ';
								
								$doubleoccupancy = getPerPersonBasisCost($hotelQuotData['doubleoccupancy'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($doubleoccupancy).' net per room per night on Double<br>';
							}
							if($hotelQuotData['twinNoofRoom']>0 && $hotelQuotData['twinoccupancy']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['twinNoofRoom']).' Twin, ';
								
								$twinoccupancy = getPerPersonBasisCost($hotelQuotData['twinoccupancy'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($twinoccupancy).' net per room per night on Twin<br>';
							}
							if($hotelQuotData['tripleNoofRoom']>0 && $hotelQuotData['tripleoccupancy']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['tripleNoofRoom']).' Triple, ';
								
								$tripleoccupancy = getPerPersonBasisCost($hotelQuotData['tripleoccupancy'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($tripleoccupancy).' net per room per night on Triple<br>';
							}

							if($hotelQuotData['quadNoofRoom']>0 && $hotelQuotData['quadRoom']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['quadNoofRoom']).' Quad Room, ';
								
								$quadRoom = getPerPersonBasisCost($hotelQuotData['quadRoom'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($quadRoom).' net per room per night on Quad Room<br>';
							}

							if($hotelQuotData['sixNoofBedRoom']>0 && $hotelQuotData['sixBedRoom']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['sixNoofBedRoom']).' Six Bed Room, ';
								
								$sixBedRoom = getPerPersonBasisCost($hotelQuotData['sixBedRoom'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($sixBedRoom).' net per room per night on Six Bed Room<br>';
							}

							if($hotelQuotData['eightNoofBedRoom']>0 && $hotelQuotData['eightBedRoom']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['eightNoofBedRoom']).' Eight BedRoom, ';
								
								$eightBedRoom = getPerPersonBasisCost($hotelQuotData['eightBedRoom'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($eightBedRoom).' net per room per night on Eight BedRoom<br>';
							}

							if($hotelQuotData['tenNoofBedRoom']>0 && $hotelQuotData['tenBedRoom']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['tenNoofBedRoom']).' Ten BedRoom, ';
								
								$tenBedRoom = getPerPersonBasisCost($hotelQuotData['tenBedRoom'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($tenBedRoom).' net per room per night on Ten BedRoom<br>';
							}

							if($hotelQuotData['extraNoofBed']>0 && $hotelQuotData['extraBed']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['extraNoofBed']).' Extra Bed Adult, ';
								
								$extraBed = getPerPersonBasisCost($hotelQuotData['extraBed'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($extraBed).' net per room per night on Extra Bed Adult<br>';
							}
							if($hotelQuotData['childwithNoofBed']>0 && $hotelQuotData['childwithbed']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['childwithNoofBed']).' Extra Bed Child, ';
								
								$childwithbed = getPerPersonBasisCost($hotelQuotData['childwithbed'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($childwithbed).' net per room per night on Extra Bed Child<br>';
							}
							if($hotelQuotData['childwithoutNoofBed']>0 && $hotelQuotData['childwithoutbed']>0){
								$nofroomText .= sprintf("%02d", $hotelQuotData['childwithoutNoofBed']).' No Bed Child, ';
								
								$childwithoutbed = getPerPersonBasisCost($hotelQuotData['childwithoutbed'],$hotelM,$hotelMarkupType,$discount,$discountType,$serviceTax,$isUni_Mark,$commissionType,$ISOCommission,$ConsortiaCommission,$ClientCommission,$tcsTax);
								$roomWiseRateText .= '@'.$currencyName.' '.round($childwithoutbed).' net per room per night on No Bed Child<br>';
							}


							// Template
							// Hotel : The Westin Mumbai Garden City
							// Check-in : 23rd Apr. 2024
							// Check-out : 26th Apr. 2024
							// No. of Rooms : 03 Single 
							// Meal Plan :  
							// Rate : 
							// Executive Club Room
							// @Rs.23490/- net per room per night on single.



							// Result developed
							// Hotel : Piccadily Hotel New Delhi Delhi
							// Check-in : 26th Nov 2023
							// Check-out : 26th Nov 2023
							// No. of Rooms : 1 Double, 1 Extra Bed Child, 1 No Bed Child,
							// Meal Plan : Breakfast
							// Rate :
							// Standard Room
							// @INR 4130 net per room per night on single
							// @INR 0 net per room per night on single
							// @INR 0 net per room per night on single



							$textPropContent .= 'Hotel : '.strip($hotelData['hotelName']);
							$textPropContent .= '<br>';
							$textPropContent .= 'Destination : '.getDestination($hotelQuotData['destinationId']);
							$textPropContent .= '<br>';
							$textPropContent .= 'Check-in : '.date('jS M Y',strtotime($sorting3['startDate']));
							$textPropContent .= '<br>';
							$textPropContent .= 'Check-out : '.date('jS M Y',strtotime($sorting3['endDate']));
							$textPropContent .= '<br>';
							$textPropContent .= 'No. of Rooms : '.rtrim($nofroomText,', ');
							$textPropContent .= '<br>';
							$textPropContent .= 'Meal Plan : '.$mealType;
							$textPropContent .= '<br>';
							$textPropContent .= 'Rate : ';
							$textPropContent .= '<br>';
							$textPropContent .= $rtype;
							$textPropContent .= '<br>';
							$textPropContent .= $roomWiseRateText;
							$textPropContent .= '<br>';
  
							?> 
							<tr style="text-align: center;">
							
								<!-- <td><?php echo $num; ?></td> -->
								<td valign="middle">
									<?php 
									echo date('j-M-Y',strtotime($sorting3['startDate'])).'<br> To <br>';
									echo date('j-M-Y',strtotime($sorting3['endDate']. ' + 1 days'));    
									?>
								</td>
								<td valign="middle"><?php echo strip($hotelData['hotelName'])?>
								<br><?php echo getDestination($hotelQuotData['destinationId']); ?> </td>
								<!-- <td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']); ?></td> -->
								<td valign="middle"><?php 
									echo $rtype;
								?></td>
								<td valign="middle">
								<?php 
								// get meal plan
								echo $mealType;
								?>	 
								</td>
								<td valign="middle"><?php echo $TotalRooms;?></td>
								<td valign="middle" style="text-align: justify;">
									<?php 
									if($hotelQuotData['singleNoofRoom']>0){
										echo 'Single - '.round($singleoccupancy).'<br>';
									}
									if($hotelQuotData['doubleNoofRoom']>0){
										echo 'Double - '.round($doubleoccupancy).'<br>';
									}
									if($hotelQuotData['twinNoofRoom']>0){
										echo 'Twin - '.round($twinoccupancy).'<br>';
									}
									if($hotelQuotData['tripleNoofRoom']>0){
										echo 'Triple - '.round($tripleoccupancy).'<br>';
									}
									if($hotelQuotData['quadNoofRoom']>0){
										echo 'Quad Room - '.round($quadRoom).'<br>';
									}
									if($hotelQuotData['sixNoofBedRoom']>0){
										echo 'Six BedRoom - '.round($sixBedRoom).'<br>';
									}
									if($hotelQuotData['eightNoofBedRoom']>0){
										echo 'Eight BedRoom - '.round($eightBedRoom).'<br>';
									}
									if($hotelQuotData['tenNoofBedRoom']>0){
										echo 'Ten BedRoom - '.round($tenBedRoom).'<br>';
									}
									if($hotelQuotData['extraNoofBed']>0){
										echo 'Extra Bed Adult - '.round($extraBed).'<br>';
									}
									if($hotelQuotData['childwithNoofBed']>0){
										echo 'Extra Bed Child - '.round($childwithbed).'<br>';
									}
									if($hotelQuotData['childwithoutNoofBed']>0){
										echo 'No Bed Child - '.round($childwithoutbed).'<br>';
									}
									?>
								</td>



							<!-- <td valign="middle"></td> -->
					  		</tr>
					  		<?php
					  		$textPropContent .= '<br>';
					  	} 
				  	} 
					$num++;
				} ?>
			</table>
		</td>
		</tr>
		</table>
		<?php } ?>
		<br />
		<div class="removeDiv" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr>
					<td align="center">
						<div class="whatsAppSBtn">
							<input type="text" id="clientNumber" placeholder="Enter WhatsApp number" value="<?php echo clean($clinetWhatsappNumber); ?>">
							<button onclick="openWhatsApp()" >
								<span><i class="fa fa-whatsapp" aria-hidden="true" style="color: green;font-size: 20px;"></i> Send  </span>
							</button>
							<p style="font-size:10px;">Note:- Ensure international code without a plus sign and no whitespace in the phone number. Use a plain number format, like 91XXXXXXXXXX.</p>
						</div>
					</td>
				</tr>
			</table>
			<br />
			<br />
			<br />
			<br />
			<div id="table_wa_content" ><?php 
				echo $textPropContent;
			?></div>
		</div>

 		<style type="text/css">
 			#table_wa_content {
		        position: absolute;
		        left: -9999px;
		    }
 			#clientNumber{
		 		padding: 9px;
			    border-radius: 20px;
			    border: 1px solid #9b9696;
			    color: #3a3a3a;
			    width: 170px;
			    margin-bottom: 8px;
 			}
 			.whatsAppSBtn button{
 				padding: 6px 10px;
			    border: 1px solid #9b9696;
			    border-radius: 40px;
 			}

		</style>
	    <script>
	        function openWhatsApp() {
            	// Remove plus sign and spaces
	            var clientNumber = document.getElementById('clientNumber').value;
            	clientNumber = clientNumber.replace(/[+\s]/g, '');

            	var proposalText = document.getElementById('table_wa_content').innerText;
	            // Format the WhatsApp message link with client's number, proposal text, and additional parameters
                var whatsappLink = 'https://wa.me/' + clientNumber + '?text=' + encodeURIComponent(proposalText);
                // var whatsappLink = "https://wa.me/918696554785?text=I'm%20interested%20in%20your%20car%20for%20sale";

	            // Open WhatsApp with the formatted link
	            window.open(whatsappLink, '_blank');
	        }
	    </script>


	<!-- Total Tour Cost and per person basis costs details -->
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px; display: none;">&nbsp;&nbsp;COSTING DETAILS</td></tr></table> 
	<?php 
	$queryId = $resultpageQuotation['queryId'];
	$quotationId= $resultpageQuotation['id'];
	$_REQUEST['parts'] = 'costingDetail';
	// include('proposal_parts.php');
	
	if($resultpageQuotation['queryType']==13){
		$_REQUEST['parts'] = 'multiServicesQuery';
		// include('proposal_parts.php');
	}
	

	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){  ?> 
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;display: none;">&nbsp;&nbsp;AIR FARE SUPPLEMENT</td></tr></table>
	<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc" width="100%">
		<tr>
			<td>
			<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="font-size:14px !important;display: none;">
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
	// include('proposal_parts.php');
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
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;display:none;">&nbsp;&nbsp;ADDITIONAL EXPERIENCES ( SUPPLEMENTS )</td></tr></table>

			<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php
				$queryId = $resultpageQuotation['queryId'];
				$quotationId= $resultpageQuotation['id'];
				$_REQUEST['parts'] = 'additionalSupplement';
				// include('proposal_parts.php');
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
	
	
	// emargency details and bank detail hide
	$_REQUEST['parts'] = 'emeragencyContactDetail';
	// include('proposal_parts.php');
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