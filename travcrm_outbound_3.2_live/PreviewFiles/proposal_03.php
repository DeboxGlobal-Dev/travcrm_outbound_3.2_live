
<style>
	@media print{
		.proposalHeader{
					margin-top: 30px !important;
				}
	}

	@font-face {
		font-family: Cantarell;
		src: url(font/Cantarell-Bold.ttf);
	}
	@font-face {
		font-family: Cantarell-Regular;
		src: url(font/Cantarell-Regular.ttf);
	}
	.proposal_agentName{
		font-family: Cantarell;
	}

	.proposal_topSecMain{
		font-size: 16px;
    	font-family: 'Cantarell-Regular';
	}
	.proposal_topSecMainHead{
		font-size: 18px;
		font-family: Cantarell;
		font-weight: bold;
		font-stretch: condensed;
		color: #302b2bf0;
	}

	.rightBorder{
		border-right: 2px solid #ecd4d4;
	}
	.tableSuggestedSec{
		width:100%;
		text-align: center;
		/* margin-left: 20px; */
		color:black;
		font-size: 18px;
		/* font-weight: bold; */
		font-family: 'Cantarell-Regular';
	}

	.allItineryDetailPro{
		background: hsl(330deg 14.29% 97.25%);
		padding-top: 15px;
		margin-left: 20px;
		margin-right: 20px;
		border-radius: 10px;
	}
	.brleft{
		border-left: 2px solid #d6d2d2;
    	padding-left: 10px;
	}
	.hotePrBor{
		border-right: 2px solid #e1cbcb;
		padding-left: 15px;
		padding-right: 15px;
	}
	.detProp{
		background: hsl(330deg 14.29% 97.25%)!important;
		color: black!important;
		border-bottom:2px solid gainsboro ;
	}
	.detaPremBr{
		border: oldlace;
	}
	.incHeadetPrDet{
		font-size: 18px;
		font-weight: bold;
	}
	.incDecsProDet{
		/* background: hsl(330deg 14.29% 97.25%)!important; */
		padding: 20px 20px;
		margin-top: -15px;
		border-radius: 10px;
	}

	.incDecsProDetDiv{
		background: hsl(330deg 14.29% 97.25%)!important;
		padding: 20px 20px;
		border-radius: 10px;
		margin-top: -15px;
	}

	.iteInfTitle p{
		font-weight: 100!important;
		font-family: 'Cantarell-Regular';
	}

	.serviceTF{
		font-family: Cantarell-Regular;
	}
	.serviceTFHead{
		font-family: 'Cantarell';
	}
	
</style>
<div class="main-container fullwidth" style="position:relative !important;">
	<?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="3" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
    if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?>
	    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="proposalHeader">
		<tbody>
			<tr>
		        <td align="center" valign="top"><img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" class="imgwidth" width="800" height="75" ></td>
			</tr>
		</tbody>
    	</table>
    	<!-- <br> -->
    	<!-- <br> -->
    	<?php
    }
	?>
	<!-- <table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tr><td align="center"><h3>Detailed Proposal</h3></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center" style="font-size:20px;text-align:center;"><strong><?php echo strip($quotationSubject); ?></strong><br></td></tr>
		
		<tr><td align="center" style="text-transform: uppercase;font-size:14px;text-align:center;">
				<strong><?php echo date('dS F',strtotime($resultpageQuotation['fromDate'])).'&nbsp;-&nbsp;'.date('dS F Y',strtotime($resultpageQuotation['toDate']))  ?></strong><br/></td></tr>
	</table> -->
	<!-- <br> -->
	<table border="0" cellpadding="0" cellspacing="0" width="100%" >
		
		<tr>
			<td align="center" style="width: 100%;">
			<?php
				$imagepath = 'upload/'.$resultpageQuotation['propIMGNum3'];
			if($resultpageQuotation['propIMGNum3']!='' && file_exists($imagepath)==true){ ?>
				<img align="center" src="<?php echo $fullurl.'PreviewFiles/'.str_replace(' ','%20',$imagepath); ?>" alt=""  class="imgwidth" width="800" height="300">
				<?php
			}else{
				$rsb03='';
				$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="3" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" order by id desc) order by id desc');
				$resListingb3=mysqli_fetch_array($rsb03);
				$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
		        if($resListingb3['fileId']!='' && file_exists('../'.$proposalPhotob3)==true){ ?>
					<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>"  class="imgwidth" width="800" height="300" >
					<?php
		        }
			}
			?>
		</td>
	</tr>
	</table>




	<!-- Proposal Top Details Sec Started  -->

	<?php 

		$rsQueryD = '';
		$rsQueryD = GetPageRecord('*', _QUERY_MASTER_, 'id="'.$queryId.'"');
		$QueryDeta = mysqli_fetch_array($rsQueryD);
		$queryIdProposal = $QueryDeta['id'];


	// started salse person detail 
		// $result22S= GetPageRecord('*','quotationMaster','id="'.$quotationId.'"');
		// $scheduledData22S = mysqli_fetch_assoc($result22S);
		// $queryIdS = $scheduledData22S['queryId'];

		// 	$result33 = GetPageRecord('*','queryMaster','id="'.$queryIdS.'"');
		// $salesPersonData = mysqli_fetch_assoc($result33);
		// $id = $salesPersonData['id'];
		// $salesPersonName = $salesPersonData['salesassignTo'];
		// $salesPersonId = $salesPersonData['salesPersonId'];
		// $assignTo = $salesPersonData['assignTo'];

		$whereSale='id="'. $QueryDeta['salesPersonId'].'"';  
		$rsSal=GetPageRecord('*',_USER_MASTER_,$whereSale); 
		$resListingSales=mysqli_fetch_array($rsSal);
		$salesPerson=$resListingSales['firstName'].' '.$resListingSales['lastName'];

		$email1=$resListingSales['email'];
		$phone1=$resListingSales['phone'];
	// ended salse person detail
	
	?>

	<table style="width: 100%;text-align: center;font-size: 22px;font-weight: bold;">
		<tr>
			<td ><p class="proposal_agentName">Proposal For : <?php echo showClientTypeUserName($QueryDeta['clientType'], $QueryDeta['companyId']);?></p></td>
		</tr>
	</table>
	<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" style="">
		
		<tr>
			<td colspan="2" align="center" class="docBanner" > 
				<div style="background: hsl(330deg 14.29% 97.25%);border-radius: 10px;height: 180px;    padding-top: 25px;">
				<table width="90%" border="0" cellpadding="10" cellspacing="0" class=" colorSize2">
				<tr>
					
					<td align="center" class="rightBorder" width="25%">
						<span class="proposal_topSecMainHead">Query Id</span><br>
						<span class="proposal_topSecMain"><?php if($resultpageQuotation['queryType']==4){ echo makePackageId($resultpage['packageId']); }else{ echo makeQueryId($resultpageQuotation['queryId']); } ?>
						</span>
					</td> 


					<td  align="center" class="rightBorder" width="25%">
					<span class="proposal_topSecMainHead">Destination <br></span><?php 
						$rootMapQuery=GetPageRecord('cityId','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
						$numRoots = mysqli_num_rows($rootMapQuery); 
						$cnt = 1; 
						$cityId = 0;
						while($rootMapData=mysqli_fetch_array($rootMapQuery)){ 
							if($rootMapData['cityId'] != $cityId ){
								?><span class="proposal_topSecMain"><?php echo getDestination($rootMapData['cityId']); ?></span>
					          <?php if($numRoots > $cnt){ ?>
					          <!-- <img src="<?php echo $fullurl; ?>images/location-pin.png" height="20" width="20" /> -->
							  ,
					          <?php } 
								$cityId = $rootMapData['cityId'];
								$cnt++;
							}
						}
						?></strong>
					</td>

					<td align="center" class="rightBorder" width="25%">
						<span class="proposal_topSecMainHead">Tour Date</span> <br>
						<span class="proposal_topSecMain"><?php 
								echo date('d-M-Y',strtotime($resultpageQuotation['fromDate'])); 
							?></span>
					</td> 
						<?php 
						$QueryRe=GetPageRecord('queryType','queryMaster',' id="'.$queryId.'" order by id asc'); 
						$queryTypeRes=mysqli_fetch_assoc($QueryRe);
						$queryTypeVal= $queryTypeRes['queryType'];
						
						if($queryTypeVal != 14){					
						?>
					<td align="center" width="25%">
						<span class="proposal_topSecMainHead">Duration</span><br>
						<span class="proposal_topSecMain"><?php 
								echo ($resultpageQuotation['night']+1).' Days / '.$resultpageQuotation['night'].' Nights' ; 
							?>
						</span>
					</td>
					<?php } ?>
					
					<td width="12%">&nbsp;</td>
				</tr> 
				<tr>
				<td></td> 
				</tr> 
				<tr>
					<td align="center" width="25%"  class="rightBorder">
						<span class="proposal_topSecMainHead">Lead Pax Name</span><br>
						<span class="proposal_topSecMain"><?php echo trim($QueryDeta['leadPaxName']); ?></span>
					</td> 
					<td align="center" width="25%" class="rightBorder">
						<span class="proposal_topSecMainHead">No. Of Pax</span><br>
						<span class="proposal_topSecMain"><?php echo ($resultpageQuotation['adult']+$resultpageQuotation['child']+$resultpageQuotation['infant']); ?> Pax</span>
					</td> 
					<td align="center" width="25%" >
						<span class="proposal_topSecMainHead">Sales Person</span><br>
						<span class="proposal_topSecMain"><?php echo $salesPerson; ?></span>
					</td> 
					<td align="center" width="25%" >
						<span class="proposal_topSecMainHead">Contact Details</span><br>
						<span class="proposal_topSecMain"><?php echo $phone1; ?></span>
					</td> 
				</tr>
				</table>
				</div>
				
			</td>
		</tr>
	</table>

	<!-- Proposal Top Details Sec Ended  -->









	
	<!-- Tour Overview -->
	<?php if($overviewText!=''){?> 
	<!-- <br> -->
	<div class="serviceDesc  incl" style="text-align: justify;page-break-inside: auto; padding-bottom: 5px;display:none;">
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
		<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;display:none;">&nbsp;&nbsp;TOUR HIGHLIGHTS</td></tr></table>
		<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="display:none;">
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
	?>
<!-- <br> -->
<!-- <br> -->

<!-- main Itinery sec all over Started -->
<div class="allItineryDetailPro">
	<!-- Top header day Suggested itinerary Driving Distance and Overnight  sec Started -->
	<div class="SuggestedSecTop" style="width:95%;margin-left: 20px;background:hsl(330deg 14.29% 97.25%);border-radius: 10px;"> 
		<table class="tableSuggestedSec" style="">
			<tr style="">
				<td style="width:40%;text-align: left;"><span style="position: relative;top: -12px;">DAY</span></td>
				<td style="width:51%;text-align: left;">SUGGESTED <br> ITINERARY</td>
				<td style="width:20%;text-align: left;">DRIVING <br>DISTANCE</td>
				
			</tr>
		</table>
	</div>
	
	<!-- Top header day Suggested itinerary Driving Distance and Overnight  sec Ended -->


	<?php 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
					
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 
		?>	 
		<!-- <br>  -->
		<!-- <table width="25%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable1" ><tr><td align="left" style="font-size: 18px;">&nbsp;&nbsp;<?php echo date('l',strtotime($dayDate));?> <br><?php echo date('j M Y',strtotime($dayDate));?></td></tr></table>  -->

		<table width="25%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" >
			<tr>
				<td align="left" style="position: relative;">
					<div style="font-size: 16px!important;font-family: 'Cantarell';margin-left: 10px;    position: relative; top: 15px;"><strong style="font-weight:700;font-size: 20px;">Day <?php echo $day; ?>:</strong><br> 	<span><?php echo getDestination($queryDaysData['cityId']); $destn = getDestination($queryDaysData['cityId']); ?><?php if($resultpage['dayWise'] == 1){ ?> <?php echo date('D',strtotime($dayDate)).'<br>'; } 	
					if($resultpage['dayWise'] == 1){
					echo date('d M Y',strtotime($dayDate)); } 	?></span>
					</div>
				</td>
			</tr>
		</table>

		<table  width="100%" border="0" cellpadding="20" cellspacing="0" >
		<tr><td>
		<div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-weight: normal;">

		
		<table width="100%" style="margin-top: -85px;font-family: 'Cantarell';">
			<tr>
				<td width="15%" ></td>
				<td class="brleft iteInfTitle" width="45%" style="font-size: 16px;font-family: 'Cantarell';font-weight: 500;">

					<span>
						<?php
						if(strlen($QueryDaysData['title'])>1) { 
							echo urldecode(strip($QueryDaysData['title'])); 
						}
						$html = clean(urldecode(strip($QueryDaysData['description'])));
						if($html!=''){
							echo html_tidy($html);
						}
						?>
					</span>

				</td>
				<td class="brleft" width="20%" style="font-family: 'Cantarell-Regular';"><?php echo urldecode(strip($QueryDaysData['drivingDistance'])); ?></td>
				<td width="20%" class="brleft" style="display:none;"></td>
			</tr>
		</table>

		<?php
			// if(strlen($QueryDaysData['title'])>1) { 
			// 	echo "<strong>".urldecode(strip($QueryDaysData['title']))."</strong><br>"; 
			// } 
			// $html = clean(urldecode(strip($QueryDaysData['description'])));
			// if($html!=''){
			// 	echo html_tidy($html);
			// }

			// services list
			$cnt1 = 1;
			// services list 
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc';
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
							// echo "<strong>Hotel - </strong>Overnight stay&nbsp;at&nbsp;".ucfirst($hotelData['hotelName'])."<br>";
							// echo strip($hotelData['hotelDetail']);	

							?>
							<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;" style="">
								<tr>
									<td style="width: 15%;text-align:center" >

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo ucfirst($hotelData['hotelName']); 
												// echo strip($transfergdetail['transferDetail']); ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<span></span> 
										<!-- <br></span>&</span> -->
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<span></span>
									 </td>
								</tr>
							</table>
						</div>

						<?php 



							// $halists='';
							// $rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$hotellisting['id'].'" and quotationId="'.$hotellisting['quotationId'].'" '); 
							// if(mysqli_num_rows($rs12)>0){
							// 	while ($editresult2=mysqli_fetch_array($rs12)) {
							// 		$halists  .= $editresult2['name'].', ';
							// 	}
							 ?>
							<!-- <img src="<?php echo $fullurl.'images/blogcmsicon.png'; ?>" width="20" height="20"/>&nbsp;&nbsp; -->
							<?php
							// echo rtrim($halists,', ');
							// }	 
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
						
						?>

						<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;text-align:center">

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo ucfirst(strip($transfergdetail['transferName'])); 
												// echo strip($transfergdetail['transferDetail']); ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<!-- <span>3 hr 20 min drive</span>  -->
										<!-- <br></span>&</span> -->
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<!-- <span>Hua Hin</span> -->
									 </td>
								</tr>
							</table>
						</div>
						<?php 
										
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
							

							// echo "<p><strong>Entrance : ".$vehicleType.$vehicleName.ucfirst(strip($entranceData['entranceName'])).$trnsferType." - </strong>";
							?>


							<div style="width: 100%;">
								<table style="width: 100%;">
									<tr>
										<td style="width: 15%;"></td>
										
										<td  style="width: 45%;text-align:center" class="brleft">
											<ul style="text-align: justify;">
												<li class="serviceTF">
													<?php echo ucfirst(strip($entranceData['entranceName'])); 
													// echo strip($transfergdetail['transferDetail']); ?>
												</li>
											</ul>
										</td>
										<td style="width: 20%;" class="brleft"></td>
										<td style="width: 20%;display:none;" class="brleft" ></td>
									</tr>
								</table>
							</div>
							<?php







							// if($resultpageQuotation['languageId'] != "0"){
							//  	$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');  
							// 	$checkrow = mysqli_num_rows($rs2);
							// 	$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
							// 	if($checkrow > 0){
						    //     	if(strlen(trim($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						    //     		echo strip($entranceData['entranceDetail'])."";
						    //     	}else{
						    //     		echo strip($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]).""; 
						    //     	}
						    //     } else{
							// 		echo strip($entranceData['entranceDetail'])."";
							//     } 
							// } else {
							// 	echo strip($entranceData['entranceDetail'])."";
						    // } 
						    // echo "</p>";
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


							?>
							<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;text-align:center">

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo ucfirst($ferryData['name']); 
												 ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<span></span> 
										<!-- <br></span>&</span> -->
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<span></span>
									 </td>
								</tr>
							</table>
						</div>
						<?php

							// echo "<p><strong>Ferry - </strong>".ucfirst($ferryData['name'])."- ";
							// echo strip($ferryData['information']).""; 
							// echo "</p>";
							//etnrance details here	
						}  
					} 
				}  
				if($itineryDayData['serviceType'] == 'additional'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'" and additionalId in ( select id from extraQuotation where proposalService=1) ';						
					$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$additionalQuotData=mysqli_fetch_array($b);
						$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
						$extraData=mysqli_fetch_array($rs1); 

						?>
							<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;text-align:center">

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo strip(ucfirst($extraData['name'])); 
												 ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<span></span> 
										<!-- <br></span>&</span> -->
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<span></span>
									 </td>
								</tr>
							</table>
						</div>
						<?php


						// echo  "<p><strong>Additional - ".strip(ucfirst($extraData['name'])).' - '."</strong>".strip($additionalQuotData['information']);
						// echo "</p>";
					}
				}  
				
				if($itineryDayData['serviceType'] == 'mealplan'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$mealplanQuotData=mysqli_fetch_array($b);

						?>
							<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;text-align:center">

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo strip(ucfirst($mealplanQuotData['mealPlanName'])); 
												 ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<span></span> 
										<!-- <br></span>&</span> -->
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<span></span>
									 </td>
								</tr>
							</table>
						</div>

						<?php 


						// echo  "<p><strong>Restaurant :</strong> ".strip(ucfirst($mealplanQuotData['mealPlanName']));
						// echo "</p>";
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
						
						?>
							<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;text-align:center">

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo strip(ucfirst($guideData['name'])); 
												 ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<span></span> 
										<!-- <br></span>&</span> -->
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<span></span>
									 </td>
								</tr>
							</table>
						</div>
						<?php
						
						// echo "<p><strong>Guide - </strong>".strip(ucfirst($guideData['name']));  
						// echo "</p>";
						 
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
							// echo "<p><strong>Sightseeing : ".ucfirst($quotationotherActivityData['otherActivityName']).$transfertype."</strong>";

							?>

							<div style="width: 100%;">
								<table style="width: 100%;">
									<tr>
										<td style="width: 15%;"></td>
										
										<td  style="width: 45%;text-align:center" class="brleft">
											<ul style="text-align: justify;">
												<li class="serviceTF">
													<?php echo ucfirst($quotationotherActivityData['otherActivityName']); 
													// echo strip($transfergdetail['transferDetail']); ?>
												</li>
											</ul>
										</td>
										<td style="width: 20%;" class="brleft"></td>
										<td style="width: 20%;display:none;" class="brleft"></td>
									</tr>
								</table>
							</div>
							<?php
						
							// if($resultpageQuotation['languageId'] != '0'){
							//  	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"'); 
							// 	$checkrow = mysqli_num_rows($rs2);
							// 	$quotationotherActivityLanData=mysqli_fetch_array($rs2);
							// 	if($checkrow > 0){
						    //     	if(strlen(trim($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						    //     		echo strip($quotationotherActivityData['otherActivityDetail'])."";
						    //     	}else{
						    //     		echo strip($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]).""; 
						    //     	}
						    //     } else{
							// 		echo strip($quotationotherActivityData['otherActivityDetail'])."";
							//     } 
							// } 
						    // else{
							// 	echo strip($quotationotherActivityData['otherActivityDetail'])."";
						    // }
						    // echo "</p>";
							//actvity detail
						}
					} 
				}  
		 
				if($itineryDayData['serviceType'] == 'flight' && $resultpageQuotation['flightCostType']==0){

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



							?>
							<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;text-align:center" >

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo strip(ucfirst($flightData['flightName'])).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass']); 
												 ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<span></span> 
										<!-- <br></span>&</span> -->
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<span></span>
									 </td>
								</tr>
							</table>
						</div>

						<?php 

							// echo "<p><strong>Flight - </strong>".strip(ucfirst($flightData['flightName'])).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass']); 
							// // flight dettail
							// echo "</p>";
						 
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


							?>
							<div class="ServiceSecDetP" style="width: 100%;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;text-align:center" >

									</td>
									<td  style="width: 45%;text-align:center" class="brleft">
										<ul style="text-align: justify;">
											<li class="serviceTF">
												<?php echo strip(ucfirst($trainData['trainName'])).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/ '.str_replace('_',' ',$trainQuoteData['trainClass']); 
												 ?>
											</li>
										</ul>
									</td>
									<td  style="width: 20%;text-align:center" class="brleft">
										<span></span> 
										
									</td>
									<td  style="width: 20%;text-align:center;display:none;" class="brleft">
										<span></span>
									 </td>
								</tr>
							</table>
						</div>

						<?php 



							// echo"<p><strong>Train - </strong>".strip(ucfirst($trainData['trainName'])).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/ '.str_replace('_',' ',$trainQuoteData['trainClass']); 
							// echo "</p>";
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
		<td colspan="2" align="center" class="serviceTFHead"><strong>END OF TOUR</strong></td>
	</tr>
	</table>



	<br />
	<br />

</div>

<!-- main Itinery sec all over Ended -->
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
	<table width="100%" border=0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable serviceTFHead" ><tr><td align="left" style="font-size: 18px;font-weight: bold;font-family: 'Cantarell';">&nbsp;&nbsp;HOTELS PROPOSED</td></tr></table> 
 
	<div class="PROPOSEDHOTELSEC" style="padding: 15px;">

	
	<table width="100%"  border="0" cellpadding="20" cellspacing="0" class="serviceTF" borderColor="#ccc" style="background: hsl(330deg 14.29% 97.25%);border-radius: 10px;">
	<tr>
	<td>
		<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#ddd" style="page-break-after: auto;page-break-before: auto;" class="borderedTable1">
	 	<tr style="padding: 10px 29px !important; background:none;">
			<th width="36%" align="left" valign="middle" style="padding-left: 5px"><strong>Dates</strong></th>
			<th width="16%" align="left" valign="middle" style="padding-left: 15px"><strong>City</strong></th>
			<th width="34%" align="left" valign="middle" style="padding-left: 15px"><strong>Hotel</strong></th>
			<th width="16%" align="left" valign="middle" style="padding-left: 15px;"><strong>Room Type</strong></th>
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
				<td valign="middle" class="hotePrBor" style="padding-left: 5px;"><strong>
				<?php 
				echo date('l, dS F, Y',strtotime($sorting3['startDate']));  
				?></strong>
				</td>
				<td valign="middle" class="hotePrBor"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
				<td valign="middle" class="hotePrBor"><?php echo "Hotel- ".strip($hotelData['hotelName']);  ?></td>
				<td valign="middle" style="padding-left: 15px;"><?php 
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
		<br>
		<?php } ?>
	</td>
	</tr>
	</table>  
	</div>
	<br>
	<!-- Total Tour Cost and per person basis costs details -->
	<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable " ><tr><td align="left" style="font-size: 18px;font-weight: bold;font-family: 'Cantarell';" class="serviceTFHead" style="">&nbsp;&nbsp;COSTING DETAILS</td></tr></table> 
	<?php 
	$queryId = $resultpageQuotation['queryId'];
	$quotationId= $resultpageQuotation['id'];
	$_REQUEST['parts'] = 'costingDetail';
	?>
	<div class="serviceTFHead"><?php 
	include('proposal_parts.php');
	?>
	</div>
	<?php 
	






	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
	?> 
	<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;font-size: 18px;display:none;">&nbsp;&nbsp;AIR FARE SUPPLEMENT</td></tr></table>

	<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="display:none;">
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
	<br/>
	<br>
<?php if($inclusion!=''){ ?>
		<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable serviceTFHead" >
			<tr>
				<td align="left" class="incHeadetPrDet">&nbsp;&nbsp;<?php echo $inclusionTitle ?>
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="20" cellspacing="0" width="100%" class="serviceTF" >
			<tr>
				<td valign="top" class="incDecsProDet">
					<div class="incDecsProDetDiv" 
					style="	background: hsl(330deg 14.29% 97.25%)!important;
							padding: 20px 20px;
							border-radius: 10px;
							margin-top: -15px;">

						<?php echo html_tidy(strip($inclusion)); ?>
					</div>
				</td>
			</tr>
		</table>


<?php } if($exclusion!=''){ ?> 
		<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable serviceTFHead" >
			<tr>
				<td class="incHeadetPrDet" align="left" >&nbsp;&nbsp;<?php echo $exclusioinTitle ?>
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" class="serviceTF">
			<tr>
				<td class="incDecsProDet" valign="top">
					<div class="incDecsProDetDiv"
					style="	background: hsl(330deg 14.29% 97.25%)!important;
							padding: 20px 20px;
							border-radius: 10px;
							margin-top: -15px;">
						<?php echo html_tidy(strip($exclusion)); ?>
					</div>
				</td>
			</tr>
		</table>
<?php } if($tncText!=''){ ?> 
		<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable serviceTFHead" >
			<tr>
				<td class="incHeadetPrDet" align="left" >&nbsp;&nbsp;<?php echo $termCTitle ?>
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" class="serviceTF">
			<tr>
				<td class="incDecsProDet" valign="top">
					<div class="incDecsProDetDiv"
					style="	background: hsl(330deg 14.29% 97.25%)!important;
							padding: 20px 20px;
							border-radius: 10px;
							margin-top: -15px;">
						<?php echo html_tidy(strip($tncText)); ?>
					</div>
				</td>
			</tr>
		</table>
<?php } if($specialText!=''){ ?> 
		<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable serviceTFHead" >
			<tr>
				<td class="incHeadetPrDet" align="left" >&nbsp;&nbsp;<?php echo $cancelPTitle ?>
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" class="serviceTF">
			<tr>
				<td class="incDecsProDet" valign="top">
					<div class="incDecsProDetDiv"
					style="	background: hsl(330deg 14.29% 97.25%)!important;
							padding: 20px 20px;
							border-radius: 10px;
							margin-top: -15px;">	
						<?php echo html_tidy(strip($specialText)); ?>
					</div>
				</td>
			</tr>
		</table>
<?php } if($paymentpolicy!=''){ ?> 
		<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable serviceTFHead" >
			<tr>
				<td class="incHeadetPrDet" align="left" >&nbsp;&nbsp;<?php echo $paymentPTitle ?>
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" class="serviceTF">
			<tr>
				<td class="incDecsProDet" valign="top">
					<div class="incDecsProDetDiv"
					style="	background: hsl(330deg 14.29% 97.25%)!important;
							padding: 20px 20px;
							border-radius: 10px;
							margin-top: -15px;">
						<?php echo html_tidy(strip($paymentpolicy)); ?>
					</div>
				</td>
			</tr>
		</table>
<?php } if($remarks!=''){ ?> 
		<table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#ccc" class="borderedTable serviceTFHead" >
			<tr>
				<td class="incHeadetPrDet" align="left" >&nbsp;&nbsp;<?php echo $remarksTitle ?>
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="20" cellspacing="0" width="100%" class="serviceTF">
			<tr>
				<td class="incDecsProDet" valign="top">
					<div class="incDecsProDetDiv"
					style="	background: hsl(330deg 14.29% 97.25%)!important;
							padding: 20px 20px;
							border-radius: 10px;
							margin-top: -15px;">	
						<?php echo html_tidy(strip($remarks)); ?>
					</div>
				</td>
			</tr>
		</table>
<?php } 


		$_REQUEST['parts'] = 'emeragencyContactDetail';
		// include('proposal_parts.php');
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