
<style>
	@media print{
		.proposalHeader{
					margin-top: 30px !important;
				}
	}
</style>
<div class="main-container fullwidth" style="position:relative !important;">
	<?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="11" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
    if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?>
	    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="proposalHeader">
		<tbody>
			<tr>
		        <td align="center" valign="top"><img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" class="imgwidth" width="600" height="75" ></td>
			</tr>
		</tbody>
    	</table>
    	<br>
    	<br>
    	<?php
    }
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tr><td align="center"><h3>Detailed Proposal</h3></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center" style="font-size:20px;text-align:center;"><strong><?php echo strip($quotationSubject); ?></strong><br></td></tr>
		
		<tr><td align="center" style="text-transform: uppercase;font-size:14px;text-align:center;">
				<strong><?php echo date('dS F',strtotime($resultpageQuotation['fromDate'])).'&nbsp;-&nbsp;'.date('dS F Y',strtotime($resultpageQuotation['toDate']))  ?></strong><br/></td></tr>
	</table>
	<br>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" >
		
		<tr>
			<td align="center" style="width: 100%;">
			<?php
				$imagepath = 'upload/'.$resultpageQuotation['propIMGNum3'];
			if($resultpageQuotation['propIMGNum3']!='' && file_exists($imagepath)==true){ ?>
				<img align="center" src="<?php echo $fullurl.'PreviewFiles/'.str_replace(' ','%20',$imagepath); ?>" alt=""  class="imgwidth" width="600" height="203">
				<?php
			}else{
				$rsb03='';
				$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="11" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" order by id desc) order by id desc');
				$resListingb3=mysqli_fetch_array($rsb03);
				$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
		        if($resListingb3['fileId']!='' && file_exists('../'.$proposalPhotob3)==true){ ?>
					<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>"  class="imgwidth" width="600" height="203" >
					<?php
		        }
			}
			?>
		</td>
	</tr>
	</table>
	
	<!-- Tour Overview -->
	<?php if($overviewText!=''){?> 
	<br>
	<div class="serviceDesc  incl" style="text-align: justify;page-break-inside: auto; padding-bottom: 5px;">
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;OVERVIEW</td></tr></table>

		<table border="0" cellpadding="20" cellspacing="0"  width="100%"  >
			<tr>
				<td >
					<?php
					$overviewText = str_replace('<p>&nbsp;</p>', '', $overviewText);
					echo $overviewText = html_tidy($overviewText);
					?>
				</td>
			</tr>
		</table>
	</div>
	<?php } ?>
	<!-- Tour Highlight -->
	<?php if($highlightsText!=''){ ?>
		<br>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;TOUR HIGHLIGHTS</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
			<tr>
				<td> 
					<?php
					$highlightsText = str_replace('<p>&nbsp;</p>', '', $highlightsText);
					echo $highlightsText = html_tidy($highlightsText);
					?>  
				</td>
			</tr>
		</table>
	<?php }  	
	//-------
	$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc');
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
					
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 
		?>	 
		<br> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;<?php echo date('l',strtotime($dayDate));?> <?php echo date('j M Y',strtotime($dayDate));?></td></tr></table> 

		<table  width="100%" border="0" cellpadding="20" cellspacing="0" >
		<tr><td>
		<div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-weight: normal;"><?php
			if(strlen($QueryDaysData['title'])>1) { 
				echo "<strong>".urldecode(strip($QueryDaysData['title']))."</strong><br>"; 
			} 
			$html = clean(urldecode(strip($QueryDaysData['description'])));
			if($html!=''){
				// echo "<p>";
				// $html = str_replace('<ul>','<span>', $html);
				// $html = str_replace('</ul>','</span>', $html);
				// $html = str_replace('<li>','<span>', $html);
				// $html = str_replace('</li>','</span>', $html);
				// $html = str_replace('<p>&nbsp;</p>', '', $html);
				// $html = str_replace('<p>', '<span>', $html);
				// = str_replace('</p>', '</span>', $html)
				echo html_tidy($html);
				// echo "</p>";
			}

			// services list
			$cnt1 = 1;
			// services list 
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc,id desc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
			
				if($itineryDayData['serviceType'] == 'hotel' ){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and dayId="'.$itineryDayData['dayId'].'" and isHotelSupplement!=1  and isRoomSupplement!=1 and supplierId="'.$itineryDayData['serviceId'].'"';   
					$rs22='';
					$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
					if(mysqli_num_rows($rs22) > 0){
					
						while($hotellisting=mysqli_fetch_array($rs22)){  
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hotelData=mysqli_fetch_array($rs1ee);   
							//hotel details
							// echo "<p>";
							echo "<strong>Hotel - </strong>Overnight stay&nbsp;at&nbsp;".ucfirst($hotelData['hotelName'])."<br>";
							echo strip($hotelData['hotelDetail']);	
							$halists='';
							$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$hotellisting['id'].'" and quotationId="'.$hotellisting['quotationId'].'" '); 
							if(mysqli_num_rows($rs12)>0){
								while ($editresult2=mysqli_fetch_array($rs12)) {
									$halists  .= $editresult2['name'].', ';
								}
							?><img src="<?php echo $fullurl.'images/blogcmsicon.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;
							<?php 
							echo rtrim($halists,', ');
							}	 
						}
					}
						 
				}
				
				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc');  
					if(mysqli_num_rows($rs22dd) > 0){
						while($transferlisting=mysqli_fetch_array($rs22dd)){  
						$rs2ss=GetPageRecord('transferName,transferDetail',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs2ss);   
						//transfer detail


						$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
						$vename=mysqli_fetch_array($rs1aa);

						$vehicleName = $vehicleType = $trnsferType = '';
						if($transferlisting['transferType'] == 2){
							$vehicleName = $vename['model']." | ";
							$vehicleType = getVehicleTypeName($vename['carType'])." | ";
						}
						$trnsferType = ($transferlisting['transferType'] == 1)?'SIC | ':'Private | ';
						
						echo "<p><strong>".ucfirst($itineryDayData['serviceType'])." : ".$trnsferType.$vehicleType.$vehicleName.ucfirst(strip($transfergdetail['transferName']))." - </strong>";
						echo strip($transfergdetail['transferDetail']);	
						echo "</p>";				
						}  
					} 
				}  
				
				if($itineryDayData['serviceType'] == 'entrance'){  
					$wherent='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc'; 
					$rsent=GetPageRecord('*','quotationEntranceMaster',$wherent);  
					if(mysqli_num_rows($rsent) > 0){
						while($entrancelisting=mysqli_fetch_array($rsent)){  
							$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
							$entranceData=mysqli_fetch_array($rsentn);    

							$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$entrancelisting['vehicleId'].'"');
							$vename=mysqli_fetch_array($rs1aa);

							$vehicleName = $vehicleType = $trnsferType = '';
							if($entrancelisting['transferType'] == 2){
								$vehicleName = $vename['model']." | ";
								$vehicleType = getVehicleTypeName($vename['carType'])." | ";
							}
							// $trnsferType = ($entrancelisting['transferType'] == 1)?'SIC | ':'Private | ';
							 if($entrancelisting['transferType']==1){ $trnsferType = " (SIC) "; }elseif($entrancelisting['transferType']==2){ $trnsferType = " (PVT) "; }elseif($entrancelisting['transferType']==3){ $trnsferType = " (Ticket Only) "; } 
							

							echo "<p><strong>Entrance : ".$vehicleType.$vehicleName.ucfirst(strip($entranceData['entranceName'])).$trnsferType." - </strong>";
							if($resultpageQuotation['languageId'] != "0"){
							 	$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');  
								$checkrow = mysqli_num_rows($rs2);
								$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
								if($checkrow > 0){
						        	if(strlen(trim($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						        		echo strip($entranceData['entranceDetail'])."";
						        	}else{
						        		echo strip($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]).""; 
						        	}
						        } else{
									echo strip($entranceData['entranceDetail'])."";
							    } 
							} else {
								echo strip($entranceData['entranceDetail'])."";
						    } 
						    echo "</p>";
							//etnrance details here	
						}  
					} 
				}   
				if($itineryDayData['serviceType'] == 'ferry'){  
					$wherent='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc'; 
					$rsent=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,$wherent);  
					if(mysqli_num_rows($rsent) > 0){
						while($ferryQuotationD=mysqli_fetch_array($rsent)){  
							$rsentn=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$ferryQuotationD['serviceid'].'"');  
							$ferryData=mysqli_fetch_array($rsentn);  

							echo "<p><strong>Ferry - </strong>".ucfirst($ferryData['name'])."- ";
							echo strip($ferryData['information']).""; 
							echo "</p>";
							//etnrance details here	
						}  
					} 
				}  

				if($itineryDayData['serviceType'] == 'cruise'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_CRUISE_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$cruiseQuotData=mysqli_fetch_array($b); 
						
						$rs52=GetPageRecord('*','cruiseMaster',' id="'.$cruiseQuotData['serviceId'].'" ');  
						$cruiseData=mysqli_fetch_array($rs52);   
						echo  "<p>".$cnt1.") <strong>Cruise:</strong> ".strip($cruiseData['cruiseName'])."</p>";
					}
				}

				if($itineryDayData['serviceType'] == 'additional'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$additionalQuotData=mysqli_fetch_array($b);
						$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
						$extraData=mysqli_fetch_array($rs1); 
						echo  "<p><strong>Additional - ".strip(ucfirst($extraData['name'])).' - '."</strong>".strip($additionalQuotData['information']);
						echo "</p>";
					}
				}  
				
				if($itineryDayData['serviceType'] == 'mealplan'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$mealplanQuotData=mysqli_fetch_array($b);
						echo  "<p><strong>Restaurant :</strong> ".strip(ucfirst($mealplanQuotData['mealPlanName']));
						echo "</p>";
					}
				} 
				if($itineryDayData['serviceType'] == 'guide'){  
					$b=$where2="";		
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'" ';	
					$b=GetPageRecord('*','quotationGuideMaster',$where2); 
					if(mysqli_num_rows($b) > 0){
						$guideQuotData=mysqli_fetch_array($b);
					 
						$rs5="";  
						$rs5=GetPageRecord('*','tbl_guidesubcatmaster','id="'.$guideQuotData['guideId'].'"'); 
						$guideData=mysqli_fetch_array($rs5); 
						echo "<p><strong>Guide - </strong>".strip(ucfirst($guideData['name']));  
						echo "</p>";
						 
					}
				} 
			 
				if($itineryDayData['serviceType'] == 'activity'){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc';

					$rs22=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){   
						while($activitylisting=mysqli_fetch_array($rs22)){   
							$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id = "'.$activitylisting['otherActivityName'].'" and  status=1');  

							if($activitylisting['transferType']==1){ $transfertype =  "(SIC) - "; }elseif($activitylisting['transferType']==2){ $transfertype =  " (PVT) - "; }elseif($activitylisting['transferType']==3){ $transfertype =  " (VIP) - "; }elseif($activitylisting['transferType']==4){ $transfertype =  " (Ticket Only) - "; }


							$quotationotherActivityData=mysqli_fetch_array($rs1);   
							echo "<p><strong>Sightseeing : ".ucfirst($quotationotherActivityData['otherActivityName']).$transfertype."</strong>";
							if($resultpageQuotation['languageId'] != '0'){
							 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"'); 
								$checkrow = mysqli_num_rows($rs2);
								$quotationotherActivityLanData=mysqli_fetch_array($rs2);
								if($checkrow > 0){
						        	if(strlen(trim($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						        		echo strip($quotationotherActivityData['otherActivityDetail'])."";
						        	}else{
						        		echo strip($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]).""; 
						        	}
						        } else{
									echo strip($quotationotherActivityData['otherActivityDetail'])."";
							    } 
							} 
						    else{
								echo strip($quotationotherActivityData['otherActivityDetail'])."";
						    }
						    echo "</p>";
							//actvity detail
						}
					} 
				}  
		 
				if($itineryDayData['serviceType'] == 'flight'){

					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$rs22=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){
						$flightQuoteData=mysqli_fetch_array($rs22); 
							$select1='*';   
							$where1='id="'.$flightQuoteData['flightId'].'"';  
							$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_FLIGHT_MASTER_,$where1);  
							$flightData=mysqli_fetch_array($rs1);  
							
							if(date('H:i',strtotime($flightQuoteData['departureTime'])) <> '05:30'){
								$departureTime = " at ".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
							}else{
								$departureTime ='';
							}	
							if(date('H:i',strtotime($flightQuoteData['arrivalTime'])) <> '05:30'){
								$arrivalTime = date('Hi',strtotime($flightQuoteData['arrivalTime'])).'Hrs';
							}else{
								$arrivalTime ='';
							}		 
							 
							$jfrom = getDestination($flightQuoteData['departureFrom']);
							$jto= getDestination($flightQuoteData['arrivalTo']);

							echo "<p><strong>Flight - </strong>".strip(ucfirst($flightData['flightName'])).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass']); 
							// flight dettail
							echo "</p>";
						 
					} 
				}  
		 
				if($itineryDayData['serviceType'] == 'train'){
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){
						while($trainQuoteData=mysqli_fetch_array($rs22)){  

							$where1='id="'.$trainQuoteData['trainId'].'"';  
							$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,$where1);  
							$trainData=mysqli_fetch_array($rs1);   
							//train details
							
							if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '05:30'){
								$dptTime = " at ".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
							}else{
								$dptTime ='';
							}	
							if(date('H:i',strtotime($trainQuoteData['arrivalTime'])) <> '05:30'){
								$avrTime = date('Hi',strtotime($trainQuoteData['arrivalTime']))."Hrs";
							}else{
								$avrTime ='';
							}		
							$journeyType="";
							$jfrom = getDestination($trainQuoteData['departureFrom']);
							$jto= getDestination($trainQuoteData['arrivalTo']);
							if($trainQuoteData['journeyType']=='overnight_journey'){ $journeyType = "(Overnight)"; }else{ $journeyType = "(Day)"; }

							echo"<p><strong>Train - </strong>".strip(ucfirst($trainData['trainName'])).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/ '.str_replace('_',' ',$trainQuoteData['trainClass']); 
							echo "</p>";
						} 
					} 
				}
				// echo "<br />";
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
	 <?php 
			$totalHotel = 0;
			$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
			if(mysqli_num_rows($b1)>0){
	?>
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;HOTELS PROPOSED</td></tr></table> 
 
	<table width="100%"  border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" style="page-break-after: auto;page-break-before: auto;" class="borderedTable">
	 	<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
			<th width="30%" align="left" valign="middle"><strong>Dates</strong></th>
			<th width="16%" align="left" valign="middle"><strong>City</strong></th>
			<th width="34%" align="left" valign="middle"><strong>Hotel</strong></th>
			<th width="20%" align="left" valign="middle"><strong>Room Type</strong></th>
 			<!-- <th width="13%" align="left" valign="middle"><strong>Remarks</strong></th> -->
		</tr>
		<?php 
		while($sorting3=mysqli_fetch_array($b1)){  
		
			$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' supplierId="'.$sorting3['serviceId'].'" and dayId="'.$sorting3['dayId'].'" and isHotelSupplement!=1 and isRoomSupplement!=1');  
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
			        $hotelTypeLable .= "Guest,";
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
				echo date('l, dS F, Y',strtotime($sorting3['startDate']));  
				?></strong>
				</td>
				<td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
				<td valign="middle"><?php echo "Hotel- ".strip($hotelData['hotelName']);  ?></td>
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
		<?php } ?>
	</td>
	</tr>
	</table>  
	<!-- Total Tour Cost and per person basis costs details -->
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;COSTING DETAILS</td></tr></table> 
	<?php 
	$queryId = $resultpageQuotation['queryId'];
	$quotationId= $resultpageQuotation['id'];
	$_REQUEST['parts'] = 'costingDetail';
	include('proposal_parts.php');
	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
	?> 
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;AIR FARE SUPPLEMENT</td></tr></table>

	<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
			<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="15%" valign="middle" bgcolor="#133f6d" align="left" ><strong>Date</strong></th>
				<th width="19%" valign="middle" bgcolor="#133f6d" align="left" ><strong>Sector</strong></th>
				<th width="15%" valign="middle" bgcolor="#133f6d" align="left" ><strong>Departure<br>Date/Time</strong></th>
				<th width="15%" valign="middle" bgcolor="#133f6d" align="left" ><strong>Arrival<br>Date/Time</strong></th>
				<th width="18%" valign="middle" bgcolor="#133f6d" align="left" ><strong>Class/Baggage</strong></th>
				<th width="13%" align="right" valign="middle" bgcolor="#133f6d"  align="left"><strong>Fare</strong></th>
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
					echo date('l, dS F, Y',strtotime($flightQuotData['fromDate']));  
					?></strong></td>
					<td valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>

					<td align="left"><?php if($timeData['departureDate']!=''){ echo date('d-m-Y', strtotime($timeData['departureDate'])).'<br>'.date('H:i:s', strtotime($timeData['departureTime'])); } ?></td> 
					<td align="left"><?php if($timeData['arrivalDate']!=''){ echo date('d-m-Y', strtotime($timeData['arrivalDate'])).'<br>'.date('H:i:s', strtotime($timeData['arrivalTime'])); } ?></td> 

					<td valign="middle"><?php echo str_replace('_',' ',$flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
					<td valign="middle"><div align="right"><?php echo getCurrencyName($newCurr); ?>&nbsp;<?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?>
				    </div></td>
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
	
	$_REQUEST['parts'] = "supplementValueAddedServices";
	include('proposal_parts.php');


	$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isRoomSupplement=1 '); 
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=1 '); 

	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0 ){
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
			<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;ADDITIONAL EXPERIENCES (SUPPLEMENT)</td></tr></table>
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
<?php if($inclusion!=''){ ?>
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;INCLUSIONS</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php echo html_tidy(strip($inclusion)); ?></td></tr></table>
<?php } if($exclusion!=''){ ?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;EXCLUSIONS</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php echo html_tidy(strip($exclusion)); ?></td></tr></table>
<?php } if($tncText!=''){ ?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;TERMS & CONDITIONS</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php echo html_tidy(strip($tncText)); ?></td></tr></table>
<?php } if($specialText!=''){ ?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;CANCELLATION POLICIES</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php echo html_tidy(strip($specialText)); ?></td></tr></table>
<?php } if($paymentpolicy!=''){ ?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;PAYMENT POLICY</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php echo html_tidy(strip($paymentpolicy)); ?></td></tr></table>
<?php } if($remarks!=''){ ?> 
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;">&nbsp;&nbsp;REMARKS</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php echo html_tidy(strip($remarks)); ?></td></tr></table>
<?php } 


		$_REQUEST['parts'] = 'emeragencyContactDetail';
		include('proposal_parts.php');
?>
	<!-- service seprator img -->
	<?php 
	$selectF= 'footerstatus, footertext';
	$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
    $resultf = mysqli_fetch_assoc($resfooter);
	if($resultf['footerstatus']==1){ ?> 
	<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
	<td align="center"><a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" ><?php if($resultf['footertext']!=''){ echo $resultf['footertext']; }else{ ?> Generated by TravCRM <?php } ?> </a></td></tr></table>
	<?php } ?>
</div>