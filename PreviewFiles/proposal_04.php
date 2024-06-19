<style>
@media print{
	.proposalHeader{
		margin-top: 40px !important;
	}
}
</style> 		
	
<div class="main-container fullwidth" style="position:relative !important;">
<table width="822" class="fullwidth">
	<tr>
		<td>
	<table class="firstpage proposalHeader" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>	
			<td align="left" width="20%" valign="middle" style="display: none;">
				<table width="90%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">&nbsp;Proposal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
			</td>
			
			<td align="center" width="80%" valign="middle"><?php
				// proposal header image ===========
				$rs03='';
				$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="4" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
				$resListing3=mysqli_fetch_array($rs03);
				$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
				if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?>
				<img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>"  width="790" height="100" >
				<?php
				}
				?>
			</td>
		</tr>
	</table>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center" valign="top">
					<div class="docBanner"><?php
						$imagepath = 'upload/'.$resultpageQuotation['propIMGNum4'];
						if($resultpageQuotation['propIMGNum4']!='' && file_exists($imagepath)==true){ ?>
							<img align="center" src="<?php echo $fullurl.'PreviewFiles/'.str_replace(' ','%20',$imagepath); ?>" class="imgwidth" width="600" height="300"  >
							<?php
						}else{
							$rsb03='';
							$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="4" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" ) order by id desc');
							$resListingb3=mysqli_fetch_array($rsb03);
							$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
							if($resListingb3['fileId']!='' && file_exists('../'.$proposalPhotob3)==true){ ?>
								<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>"  class="imgwidth" width="800" height="300" >
								<?php
							}
						}
						?> 
						
					</div>
				<div class="" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;padding: 10px !important;">
						<!-- <span class="text1"><?php echo ($resultpageQuotation['night']+1).' DAYS'; ?></span><br> -->
						<span style="font-size: 22px;text-transform: uppercase;font-weight: 500;"><?php echo strip($quotationSubject); ?></span> 
				</div>
			</td>
		</tr>

	</table>
	<table width="100%" align="center" border="0" cellpadding="15" cellspacing="0" style="background-color:#fbf8f4">
		<tr>
			<td align="left" valign="top">
				Elite Proposal
			</td>
			<td align="right" valign="top">

				QueryID:- <?php if($resultpageQuotation['queryType']==4){ echo makePackageId($resultpage['packageId']); }else{ echo makeQueryId($resultpageQuotation['queryId']); } ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="docBanner" > 
				<table width="90%" border="0" cellpadding="10" cellspacing="0" class=" colorSize2">
				<tr>
					<td width="12%">&nbsp;</td>
					<td align="center" width="25%">Tour Start Date<br>
						<strong><?php 
							echo date('d - m - Y',strtotime($resultpageQuotation['fromDate'])); 
						?></strong>
					</td> 
					<?php 
					
					// echo $queryId;

					$QueryRe=GetPageRecord('queryType','queryMaster',' id="'.$queryId.'" order by id asc'); 
					$queryTypeRes=mysqli_fetch_assoc($QueryRe);
					$queryTypeVal= $queryTypeRes['queryType'];
					
					if($queryTypeVal != 14){					
					?>
					<td align="center" width="25%">DURATION<br>
						<strong><?php 
							echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; 
						?></strong>
					</td>
					<?php } ?>
					<td align="center" width="25%" align="right">TRAVELLERS<br>
						<strong><?php echo ($resultpageQuotation['adult']+$resultpageQuotation['child']+$resultpageQuotation['infant']); ?> Pax</strong>
					</td> 
					<td width="12%">&nbsp;</td>
				</tr> 
				<tr>
				<td colspan="5"></td> 
				</tr> 
				<tr>
					<td colspan="5" align="center">DESTINATION COVERED<br><strong><?php 
						$rootMapQuery=GetPageRecord('cityId','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
						$numRoots = mysqli_num_rows($rootMapQuery); 
						$cnt = 1; 
						$cityId = 0;
						while($rootMapData=mysqli_fetch_array($rootMapQuery)){ 
							if($rootMapData['cityId'] != $cityId ){
								?><strong><?php echo getDestination($rootMapData['cityId']); ?></strong>
					          <?php if($numRoots > $cnt){ ?>
					          <img src="<?php echo $fullurl; ?>images/location-pin.png" height="20" width="20" />
					          <?php } 
								$cityId = $rootMapData['cityId'];
								$cnt++;
							}
						}
						?></strong>
					</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<?php if(strlen($overviewText)!=''){ ?>
	<div class="serviceTitle docTitle w60" style="padding: 7px 30px !important; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Tour Overview<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 47px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
    <div class="overviewBox"  style="padding: 30px 60px !important; ">
		<div class="serviceDesc"><?php  
				$overviewText = str_replace('<p>&nbsp;</p>', '', $overviewText);
				$overviewText = str_replace('<p>', '<span>', $overviewText);
				$overviewText = str_replace('</p>', '</span>', $overviewText);
				echo html_tidy(substr($overviewText, 0 ,1000));  
	 ?></div>
	</div>
	<?php } ?>

    <?php  
	// DAY LOOP START
	$day=1;
	$queryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($queryDaysData=mysqli_fetch_array($queryDaysQuery)){  
		$dayDate = date('Y-m-d',strtotime($queryDaysData['srdate']));
		$dayId = $queryDaysData['id']; 
		?>  
		<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">Day <?php echo $day; ?> - <?php echo getDestination($queryDaysData['cityId']); $destn = getDestination($queryDaysData['cityId']); ?><?php if($resultpage['dayWise'] == 1){ ?> | <?php echo date('l d-m-Y', strtotime($dayDate)); } 	?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>



		<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc" style="display: block;position: relative;font-size: 14px;color: #424244;font-weight: 400;font-family: 'Source Sans Pro', sans-serif;"><tr><td><?php 
			if($queryDaysData['title']!=''){ 
				?>
				<!-- <div class="itineraryTitle"> -->
					<strong>
				<?php
				echo html_tidy(strip(urldecode($queryDaysData['title'])));
				?></strong>
				<!-- </div> -->
				<?php
			}
			if($queryDaysData['description']!=''){ 
			?>
			<!-- <div class="itineraryDesc"> -->
				<?php
				$html = urldecode(strip($queryDaysData['description']));
				// $html = str_replace('<p>&nbsp;</p>', '<br />', $html);
				// $html = str_replace('<p>', '<div>', $html);
				// $html = str_replace('</p>', '</div>', $html);
				echo $html = html_tidy($html);
				?>
				<!-- </div> -->
				<br />
				<br />
			<?php
			}

				// GET THE EARLY CHECKIN HOTEL HERE
				$where10='quotationId="'.$queryDaysData['quotationId'].'" and isHotelSupplement!=1 and isEarlyCheckin=1 and dayId="'.$dayId.'" order by fromDate asc';   
				$rs10=GetPageRecord('*','quotationHotelMaster',$where10);  
				if(mysqli_num_rows($rs10) > 0){
					$hotellisting0=mysqli_fetch_array($rs10); 
					$hotelTypeLable = $isGuest = '';
					if($hotellisting0['isEarlyCheckin']==1){
						$hotelTypeLable = "Early CheckIn";
					} 
					$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting0['supplierId'].'"');  
					$hoteldetail0=mysqli_fetch_array($rs1ee);   
					?>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service hotel">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
							$rs20='';
							$rs20=GetPageRecord('*','imageGallery',' parentId = "'.$hoteldetail0['id'].'" and galleryType="hotel" and deletestatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) order by id desc');
							$resListing20=mysqli_fetch_array($rs20);
							if($resListing20['fileId']!=''){ 
								$hotelImage0 = geDocFileSrc($resListing20['fileId']);
								if(file_exists('../'.$hotelImage0)==true){
									echo '<img src="'.$fullurl.str_replace(' ', '%20',$hotelImage0).'" width="200" height="130">';
								}else{
									echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
								}
							}else{
							  echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
							}
						?></div></td>
						<td width="70%" align="left" valign="middle" >
							<table border="0" cellpadding="5" cellspacing="0" >
								<tbody>
									<tr>
										<td colspan="3"><strong class="serviceTitle"><?php  echo rtrim($hotelTypeLable,',')." Hotel | "; echo strip($hoteldetail0['hotelName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="15%" ><strong class="subHeading">Category</strong></td> 
										<td width="30%" ><strong class="subHeading">Room Type</strong></td> 
										<td width="20%" ><strong class="subHeading">Meal Plan</strong></td> 
									</tr> 
									<tr> 
										<td width="15%" valign="bottom" ><?php 
											 $rs231er0=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail0['hotelCategoryId'].'"');  
											 $hotelCatNam0=mysqli_fetch_array($rs231er0);  
											 echo '<img src="'.$fullurl.'images/hotelStar'.$hotelCatNam0['hotelCategory'].'.png" height="20">';
											 ?>
										</td>
										<td width="30%"><?php 
											$rs23qwe0=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting0['roomType'].'"');  
											$roomtype0=mysqli_fetch_array($rs23qwe0);  
											echo $roomtype0['name'];   
											?></td> 
										 <td width="20%"><?php
										$rssda240=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$hotellisting0['mealPlan'].'"'); 
										$mealplan0=mysqli_fetch_array($rssda240); 
										echo $mealplan0['name'];
										//.'-'.$mealplan0['subname']
										?></td>  
									  </tr>
								</tbody>
							</table>
						</td>
						</tr>
						</tbody>
					</table>
					<div class="hr_line" style="margin: 40px 0px;">
						<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
					</div>
					<?php 
				}
 
			// SERVICE LOOP START
			$itiQuery=' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){

				if($itineryDayData['serviceType'] == 'hotel' ){
					 $where1='quotationId="'.$queryDaysData['quotationId'].'" and isHotelSupplement!=1 and dayId="'.$itineryDayData['dayId'].'" and supplierId="'.$itineryDayData['serviceId'].'"';   
					$rs1=GetPageRecord('*','quotationHotelMaster',$where1);  
					if(mysqli_num_rows($rs1) > 0){
						$hotellisting=mysqli_fetch_array($rs1); 
						$hotelTypeLable = $isGuest = '';
						if($hotellisting['isLocalEscort']==1){
					        $hotelTypeLable .= "Local Escort,";
					        if($hotellisting['isGuestType']==1){
						        $isGuest = "Guest,";
						    } 
					    }
					    if($hotellisting['isForeignEscort']==1){
					        $hotelTypeLable .= "Foreign Escort,";
						    if($hotellisting['isGuestType']==1){
						        $isGuest = "Guest,";
						    } 
					    }
					    if($hotellisting['isGuestType']==1){
					        $hotelTypeLable .= $isGuest;
					    }
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hoteldetail=mysqli_fetch_array($rs1ee);   
					?>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service hotel">
						<tbody><tr class="row-service">
						<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
				            $rs2='';
				            $rs2=GetPageRecord('*','imageGallery',' parentId = "'.$hoteldetail['id'].'" and galleryType="hotel" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" )  order by id desc');
				            $resListing2=mysqli_fetch_array($rs2);
			            	if($resListing2['fileId']!=''){ 
				            	$hotelImage = geDocFileSrc($resListing2['fileId']);
				            	if(file_exists('../'.$hotelImage)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$hotelImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            	}
				            }else{
				              echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            }
						?></div></td>
						<td width="70%" align="left" valign="middle" >
							<table border="0" cellpadding="5" cellspacing="0" >
								<tbody>
									<tr>
										<td colspan="3"><strong class="serviceTitle"><?php  echo rtrim($hotelTypeLable,',')." Hotel | "; echo strip($hoteldetail['hotelName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="15%" ><strong class="subHeading">Category</strong></td> 
										<td width="20%" ><strong class="subHeading">Room Type</strong></td> 
										<td width="30%" ><strong class="subHeading">Meal Plan</strong></td> 
									</tr> 
									<tr> 
										<td width="15%" valign="bottom" ><?php 
										 	$rs231er=GetPageRecord('*','hotelCategoryMaster','id="'.$hoteldetail['hotelCategoryId'].'"');  
										 	$hotelCatNam=mysqli_fetch_array($rs231er);  
										 	echo '<img src="'.$fullurl.'images/starh'.$hotelCatNam['hotelCategory'].'.png" height="20">';
										 	?>
										</td>
										<td width="20%"><?php 
											$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"');  
											$roomtype=mysqli_fetch_array($rs23qwe);  
											echo $roomtype['name'];   
											?></td> 
									 	<td width="30%"><?php
										$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$hotellisting['mealPlan'].'"'); 
										$mealplan=mysqli_fetch_array($rssda24); 
										echo $mealplan['name'];
										//.'-'.$mealplan['subname']
										?></td>  
							  		</tr>
								</tbody>
							</table>
						</td>
						</tr>
						</tbody>
					</table>
					<div class="hr_line" style="margin: 40px 0px;">
						<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
					</div>
					<?php 
					}
				}

				if($itineryDayData['serviceType'] == 'transportation'){ 
					$rs12=GetPageRecord('*','quotationTransferMaster','quotationId="'.$queryDaysData['quotationId'].'" and dayId="'.$queryDaysData['id'].'" and id="'.$itineryDayData['serviceId'].'" and isGuestType=1 and queryId="'.$queryId.'"');   
					if(mysqli_num_rows($rs12) > 0){
						while( $transferlisting=mysqli_fetch_array($rs12)){
						$rs123=GetPageRecord('transferName,transferDetail,id',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs123);

						$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');  
						$vename=mysqli_fetch_array($rs1aa);
						?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service transfer">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><?php   
								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
								$vename=mysqli_fetch_array($rs1aa); 
								?>
								<div class="imgbox">
								<?php 
				            	// $tptimgPath = 'packageimages/'.$vename['image'];
				            	// if(file_exists('../'.$tptimgPath)==true && $vename['image']!=''){
				            	// 	echo '<img src="'.$fullurl.str_replace(' ', '%20',$tptimgPath).'" width="200" height="130">';  
				            	// }else{
					            	?>
									<!-- <img src="<?php echo $fullurl; ?>images/transferthumbpackage.png" width="200" height="130" /> -->
									<?php
				            	//}






								// if($transferlisting['transferType']==1){
								// 	echo '<img src="'.$fullurl.'images/SIC-01.png" width="200" height="130">'; 
								// }else{
								// 	echo '<img src="'.$fullurl.'images/private-01.png" width="200" height="130">'; 
								// }

								if(getVehicleTypeImage($transferlisting['vehicleType'])!=''){ ?>
									<div width="100" align="center">
										<img src="<?php echo $fullurl; ?>packageimages/<?php echo getVehicleTypeImage($transferlisting['vehicleType']); ?>" style="width: 200px;" alt="<?php echo $resultlists['name']; ?>" /> 
									</div>
								<?php }else{
									echo '<img src="'.$fullurl.'images/private-01.png" width="200" height="130">'; 
								} 

					            ?>
									
								</div>
							</td>
							<td width="70%" align="left" valign="middle" >
							   <table width="100%" border="0" cellpadding="5" cellspacing="0" >
								 	<tr>
								 		<td colspan="3" align="left" >
								 			<strong class="serviceTitle"><?php echo ucfirst($transfergdetail['transferName']); ?></strong>
								 		</td>
										</tr>
										<?php if($transferlisting['transferType']==2){  ?>
										<tr>
											<td align="left" width="15%" ><strong class="subHeading">Transfer Type</strong></td>
											<!-- <td align="left" width="20%" ><strong class="subHeading">rrrrqqVehicleName</strong></td> -->
											<td align="left" width="25%" ><strong class="subHeading">VehicleType</strong></td> 
										</tr>
										<tr>
											<td align="left" width="15%" ><?php echo ($transferlisting['transferType']==1)?'SIC':'Private';  ?></td>
											<!-- <td align="left" width="20%" ><?php echo  $vename['model']; ?> </td> -->
											<td align="left" width="20%" ><?php echo getVehicleTypeName($transferlisting['vehicleType']); ?> </td> 
										</tr> 
										<?php }elseif(strlen($transfergdetail['transferDetail']) > 0 && $transferlisting['transferType']==1){ ?>
										<tr>
											<td colspan="3" align="left"><strong class="subHeading">Transfer Type - SIC</strong></td>
										</tr>
										<tr>
											<td colspan="3" align="left"><?php echo stripslashes($transfergdetail['transferDetail']); ?></td>
										</tr>	
								  	<?php } ?>
							   </table>								   
							</td>
							</tr>
							<?php 
						  	$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferlisting['id'].'" and quotationId="'.$transferlisting['quotationId'].'"');
							$transferTimelineData=mysqli_fetch_array($c1);
							if(mysqli_num_rows($c1)>0){


							?>
							<tr class="row-service">
								<td colspan="2" align="left" valign="top" width="100%">
									<table cellpadding="4" border="1" cellspacing="0"  class="borderedTable">
							 	  	<tr>
										<?php if($transferTimelineData['mode']!='Local'){ ?>
											<th valign="middle" bgcolor="#233a49"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight Name';}if($transferTimelineData['mode']=='train'){ echo 'Train Name';} ?></th> 
											<th align="left" bgcolor="#233a49"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight No';}if($transferTimelineData['mode']=='train'){ echo 'Train No';} ?></th>

											<?php } if($transferTimelineData['mode']=='flight'){ ?>
											<th align="left" bgcolor="#233a49">Airport Name</th>
											<?php } if($transferTimelineData['mode']=='Local'){ ?>
											<th align="left" bgcolor="#233a49">Mode</th>
											<!-- <th align="left" bgcolor="#233a49">Type</th> -->
											<th align="left" bgcolor="#233a49">Date</th>
											<?php }else{ ?>
											<th align="left" bgcolor="#233a49">Arrival From</th> 
											<th align="left" bgcolor="#233a49">Arrival Time</th>
											<?php } ?>
											<th align="left" bgcolor="#233a49">PickUp Time</th>
											<th align="left" bgcolor="#233a49">Drop Time</th>
											<th align="left" bgcolor="#233a49">PickUp Address:</th>
											<th align="left" bgcolor="#233a49">Drop Address:</th>
								 	</tr>
								 	<tr>
									 <?php if($transferTimelineData['mode']!='Local'){ ?>
							 	  	 	<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightName']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainName']; } ?></td>
							 	  	 	<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightNumber']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainNumber']; } ?></td>

		            					<?php } if($transferTimelineData['mode']=='flight'){ ?>
								 	  	<td><?php echo $transferTimelineData['airportName']; ?></td>
		          						<?php } if($transferTimelineData['mode']=='Local'){ ?>

		           						<td><?php echo $transferTimelineData['mode']; ?></td>
		           						<!-- <td><?php echo $transferTimelineData['transferType']; ?></td> -->
		           						<td><?php echo date('d-m-Y',strtotime($transferTimelineData['departureDate'])); ?></td>
										<?php }else{ ?>
		           						<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
								 	  	<td><?php if(date('H:i',strtotime($transferTimelineData['arrivalTime'])) <> '0530' ){ echo date('H:i',strtotime($transferTimelineData['arrivalTime']))." Hrs"; } ?></td>
										<?php } ?>
										<td>
											<?php if(date('H:i',strtotime($transferTimelineData['pickupTime']))!='' && date('H:i',strtotime($transferTimelineData['pickupTime']))!='00:00:00' ){ echo date('H:i',strtotime($transferTimelineData['pickupTime']))." Hrs"; } ?>
									</td>

									 	<td><?php if(date('H:i',strtotime($transferTimelineData['dropTime'])) <> '00:00:00' && date('H:i',strtotime($transferTimelineData['dropTime']))!= '' ){ echo date('H:i',strtotime($transferTimelineData['dropTime']))." Hrs"; }  ?>
									</td> 
								 	  	
										   <?php if($transferTimelineData['pickupAddress']!=''){?>
										<td><?php echo $transferTimelineData['pickupAddress']; ?></td>
										<?php } 
								 	if($transferTimelineData['dropAddress']!=''){ ?>
									<td><?php echo $transferTimelineData['dropAddress']; ?></td>
								 	  </tr>
								 	<?php } ?>
								 	</tr>
								 		
								 	</table>
								</td>
							</tr>
							<?php } ?>
							<?php 
							if(strlen($transfergdetail['transferDetail']) > 0 && $transferlisting['transferType']==2){  ?>
						 	<tr>
						 		<td colspan="2" align="left"><br><?php echo stripslashes($transfergdetail['transferDetail']); ?></td>
						 	</tr>
						 	<?php } ?>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 

					}
				}
			}
				
				if($itineryDayData['serviceType'] == 'transfer'){ 
					$rs12=GetPageRecord('*','quotationTransferMaster','quotationId="'.$queryDaysData['quotationId'].'" and dayId="'.$queryDaysData['id'].'" and id="'.$itineryDayData['serviceId'].'" and queryId="'.$queryId.'" ');   
					if(mysqli_num_rows($rs12) > 0){
						while( $transferlisting=mysqli_fetch_array($rs12)){
						$rs123=GetPageRecord('transferName,transferDetail,id',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs123);

						$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');  
						$vename=mysqli_fetch_array($rs1aa);
						?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service transfer">
							<tbody><tr class="row-service">
								<td width="30%" align="left" valign="middle"><?php   
									$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
									$vename=mysqli_fetch_array($rs1aa); 
									?>
									<div class="imgbox">
									<?php 
									// $tptimgPath = 'packageimages/'.$vename['image'];
									// if(file_exists('../'.$tptimgPath)==true && $vename['image']!=''){
									// 	echo '<img src="'.$fullurl.str_replace(' ', '%20',$tptimgPath).'" width="200" height="130">';  
									// }else{
										?>
										<!-- <img src="<?php echo $fullurl; ?>images/transferthumbpackage.png" width="200" height="130" /> -->
										<?php
									//}

									if(getVehicleTypeImage($transferlisting['vehicleType'])!=''){ ?>
										<div width="100" align="center">
											<img src="<?php echo $fullurl; ?>packageimages/<?php echo getVehicleTypeImage($transferlisting['vehicleType']); ?>" style="width: 200px;" alt="<?php echo $resultlists['name']; ?>" /> 
										</div>
									<?php }else{
										echo '<img src="'.$fullurl.'images/private-01.png" width="200" height="130">'; 
									} 






									?>
										
									</div>
								</td>
								<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
										<tr>
											<td colspan="3" align="left" >
												<strong class="serviceTitle"><?php echo ucfirst($transfergdetail['transferName']); ?></strong>
											</td>
										</tr>
										<?php if($transferlisting['transferType']==2){  ?>
										<tr>
											<td align="left" width="15%" ><strong class="subHeading">Transfer Type</strong></td>
											<!-- <td align="left" width="20%" ><strong class="subHeading">rrrrVehicleName</strong></td> -->
											<td align="left" width="25%" ><strong class="subHeading">VehicleType</strong></td> 
										</tr>
										<tr>
											<td align="left" width="15%" ><?php echo ($transferlisting['transferType']==1)?'SIC':'Private';  ?></td>
											<!-- <td align="left" width="20%" ><?php echo  $vename['model']; ?> </td> -->

											<td align="left" width="20%" ><?php echo getVehicleTypeName($transferlisting['vehicleType']); ?> </td>



										</tr> 
										<?php }elseif(strlen($transfergdetail['transferDetail']) > 0 && $transferlisting['transferType']==1){ ?>
										<tr>
											<td colspan="3" align="left"><strong class="subHeading">Transfer Type - SIC</strong></td>
										</tr>
										<tr>
											<td colspan="3" align="left"><?php echo stripslashes($transfergdetail['transferDetail']); ?></td>
										</tr>	
										<?php } ?>
								</table>								   
								</td>
								</tr>
								<?php 
								$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferlisting['id'].'" and quotationId="'.$transferlisting['quotationId'].'"');
								$transferTimelineData=mysqli_fetch_array($c1);
								if(mysqli_num_rows($c1)>0){


							?>
							<tr class="row-service">
								<td colspan="2" align="left" valign="top" width="100%">
									<table cellpadding="4" border="1" cellspacing="0"  class="borderedTable">
							 	  	<tr>
										<?php if($transferTimelineData['mode']!='Local'){ ?>
											<th valign="middle" bgcolor="#233a49"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight Name';}if($transferTimelineData['mode']=='train'){ echo 'Train Name';} ?></th> 
											<th align="left" bgcolor="#233a49"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight No';}if($transferTimelineData['mode']=='train'){ echo 'Train No';} ?></th>

											<?php } if($transferTimelineData['mode']=='flight'){ ?>
											<th align="left" bgcolor="#233a49">Airport Name</th>
											<?php } if($transferTimelineData['mode']=='Local'){ ?>
											<th align="left" bgcolor="#233a49">Mode</th>
											<!-- <th align="left" bgcolor="#233a49">Type</th> -->
											<th align="left" bgcolor="#233a49">Date</th>
											<?php }else{ ?>
											<th align="left" bgcolor="#233a49">Arrival From</th> 
											<th align="left" bgcolor="#233a49">Arrival Time</th>
											<?php } ?>
											<th align="left" bgcolor="#233a49">PickUp Time</th>
											<th align="left" bgcolor="#233a49">Drop Time</th>
											<th align="left" bgcolor="#233a49">PickUp Address:</th>
											<th align="left" bgcolor="#233a49">Drop Address:</th>
								 	</tr>
								 	<tr>
									 <?php if($transferTimelineData['mode']!='Local'){ ?>
											<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightName']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainName']; } ?></td>
											<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightNumber']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainNumber']; } ?></td>

											<?php } if($transferTimelineData['mode']=='flight'){ ?>
											<td><?php echo $transferTimelineData['airportName']; ?></td>
											<?php } if($transferTimelineData['mode']=='Local'){ ?>

											<td><?php echo $transferTimelineData['mode']; ?></td>
											<!-- <td><?php echo $transferTimelineData['transferType']; ?></td> -->
											<td><?php echo date('d-m-Y',strtotime($transferTimelineData['departureDate'])); ?></td>
											<?php }else{ ?>
											<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
											<td><?php if(date('H:i',strtotime($transferTimelineData['arrivalTime'])) <> '0530' ){ echo date('H:i',strtotime($transferTimelineData['arrivalTime']))." Hrs"; } ?></td>
											<?php } ?>
											<td>
												<?php if(date('H:i',strtotime($transferTimelineData['pickupTime']))!='' && date('H:i',strtotime($transferTimelineData['pickupTime']))!='00:00:00' ){ echo date('H:i',strtotime($transferTimelineData['pickupTime']))." Hrs"; } ?>
										</td>

									 	<td><?php if(date('H:i',strtotime($transferTimelineData['dropTime'])) <> '00:00:00' && date('H:i',strtotime($transferTimelineData['dropTime']))!= '' ){ echo date('H:i',strtotime($transferTimelineData['dropTime']))." Hrs"; }  ?>
									</td> 
								 	  	
										   <?php if($transferTimelineData['pickupAddress']!=''){?>
										<td><?php echo $transferTimelineData['pickupAddress']; ?></td>
										<?php } 
								 	if($transferTimelineData['dropAddress']!=''){ ?>
									<td><?php echo $transferTimelineData['dropAddress']; ?></td>
								 	  </tr>
								 	<?php } ?>
								 	</tr>
								 		
								 	</table>
								</td>
							</tr>
							<?php } ?>
							<?php 
							if(strlen($transfergdetail['transferDetail']) > 0 && $transferlisting['transferType']==2){  ?>
						 	<tr>
						 		<td colspan="2" align="left"><br><?php echo stripslashes($transfergdetail['transferDetail']); ?></td>
						 	</tr>
						 	<?php } ?>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 

					}
				}
			}

				if($itineryDayData['serviceType'] == 'enroute'){   
					$where2='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$rs2=GetPageRecord('*','quotationEnrouteMaster',$where2);  
					if(mysqli_num_rows($rs2) > 0){
					 	$enroutelisting=mysqli_fetch_array($rs2);
						$rs1=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id='.$enroutelisting['enrouteId'].'');  
						$enrouteData=mysqli_fetch_array($rs1);    
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
				            $rs3='';
				            $rs3=GetPageRecord('*','imageGallery',' parentId = "'.$enrouteData['id'].'" and galleryType="enroute" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" )  order by id desc');
				            $resListing3=mysqli_fetch_array($rs3);
			            	if($resListing3['fileId']!=''){ 
				            	$enrouteImage = geDocFileSrc($resListing3['fileId']);
				            	if(file_exists('../'.$enrouteImage)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ','%20',$enrouteImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/activity.jpg" width="200" height="130">'; 
				            	}
				            }else{ 
				              echo '<img src="'.$fullurl.'images/activity.jpg" width="200" height="130">'; 
				            } 
				          	?></div></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo ucfirst($enrouteData['enrouteCity']);  ?> | <?php echo strip($enrouteData['enrouteName']);  ?></strong></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php echo strip_tags($enrouteData['enrouteDetail']); ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 


					}
				}

				if($itineryDayData['serviceType'] == 'entrance'){   
					$where3='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc'; 
					$rs3=GetPageRecord('*','quotationEntranceMaster',$where3);  
					if(mysqli_num_rows($rs3) > 0){
						$entrancelisting=mysqli_fetch_array($rs3);
						$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entrancelisting['entranceNameId'].'"');  
						$entranceData=mysqli_fetch_array($rsentn); 
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
				            $rs4='';
				            $rs4=GetPageRecord('*','imageGallery',' parentId = "'.$entranceData['id'].'" and galleryType="entrance" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" )  order by id desc');
				            $resListing4=mysqli_fetch_array($rs4);
			            	if($resListing4['fileId']!=''){ 
				            	$entranceImage = geDocFileSrc($resListing4['fileId']);
				            	if(file_exists('../'.$entranceImage)==true){ 
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$entranceImage).'" width="200" height="130">';
				            	}else{
				            		echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">'; 
				            	}
				            }else{ 
								echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">'; 
				            } 

						
				          	?></div></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr>
											<td colspan="3" ><strong class="serviceTitle"><?php echo strip($entranceData['entranceName']);  ?></strong></td>
										</tr>
										<?php 
										if($entrancelisting['transferType']==1 || $entrancelisting['transferType']==3){  
											?>
											<tr>
											 	<td colspan="3" align="left" ><strong class="subHeading"><?php if($entrancelisting['transferType']==1){ echo "Transfer Type - SIC "; }elseif($entrancelisting['transferType']==3){ echo "Transfer Type - Ticket Only "; } ?></strong></td>
										  	</tr>
											<?php
											if($resultpageQuotation['languageId']!="0"){
											 	$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');  
												$checkrow = mysqli_num_rows($rs2);
												$entranceLangData=mysqli_fetch_array($rs2);
												if($checkrow > 0){
										        	if(strlen(trim($entranceLangData['lang_0'.$resultpageQuotation['languageId']]))<1){
										        		// echo strip($entranceData['entranceDetail'])."";
										        		echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($entranceData['entranceDetail']).'</div></td></tr>';
										        	}else{
										        	    echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($entranceLangData['lang_0'.$resultpageQuotation['languageId']]).'</div></td></tr>';
										        		// echo .""; 
										        	}
										        } else{
												// 	echo strip($entranceData['entranceDetail'])."";
													echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($entranceData['entranceDetail']).'</div></td></tr>';
											    } 
											} else {
											    echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($entranceData['entranceDetail']).'</div></td></tr>';
												// echo strip($entranceData['entranceDetail'])."";
										    } 
									  	}
										if($entrancelisting['transferType']==2){  
											$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$entrancelisting['vehicleId'].'"');  
											$vename=mysqli_fetch_array($rs1aa);
											?>
									  	<tr>
										 	<td align="left" width="15%" ><strong class="subHeading">Transfer Type</strong></td>
										 	<td align="left" width="20%" ><strong class="subHeading">Vehicle Name</strong></td>
										 	<td align="left" width="25%" ><strong class="subHeading">Vehicle Type</strong></td> 
									  	</tr>
									  	<tr>
										 	<td align="left" width="15%" >Private</td>
										 	<td align="left" width="20%" ><?php echo  $vename['model']; ?> </td>
										 	<td align="left" width="25%" ><?php  echo getVehicleTypeName($vename['carType']);?></td> 
									  	</tr> 
									  	<?php } ?>

									</tbody>
								</table>
							</td>
							</tr>
							
							
							</tbody>
						</table>
						<table border="1" width="100%" cellpadding="5" cellspacing="0">
						<?php
						$d = GetPageRecord('*','quotationEntranceTimelineDetails','hotelQuoteId="'.$entrancelisting['id'].'"');
								if(mysqli_num_rows($d)>0){

									?>
									
										<tr style=" background: #4170fb; color:#fff; font-weight:500;"><td>Date</td>
										<th align="left" >Start&nbsp;Time</th>
										<th align="left" >End&nbsp;Time</th>
										<th align="left" >Pickup&nbsp;Time</th>
										<th align="left"  >Drop&nbsp;Time</th>
										<th align="left"  >Pickup&nbsp;Address</th>
										<th align="left" >Drop&nbsp;Address</th>
									</tr>
									<?php while($timeData = mysqli_fetch_assoc($d)){
										if($timeData['pickupTime']!='' && $timeData['pickupTime']!='00:00:00'){
											$pickupTime = date('H:i',strtotime($timeData['pickupTime']));
										}else{
											$pickupTime = '';
										}

										if($timeData['dropTime']!='' && $timeData['dropTime']!='00:00:00'){
											$dropTime = date('H:i',strtotime($timeData['dropTime']));
										}else{
											$dropTime = '';
										}

										if($timeData['startTime']!='' && $timeData['startTime']!='00:00:00'){
											$startTime = date('H:i',strtotime($timeData['startTime']));
										}else{
											$startTime = '';
										}

										if($timeData['endTime']!='' && $timeData['endTime']!='00:00:00'){
											$endTime = date('H:i',strtotime($timeData['endTime']));
										}else{
											$endTime = '';
										}

										if($timeData['departureDate']!='' && $timeData['departureDate']!='0000-00-00'){
											$departureDate = date('d-m-Y',strtotime($timeData['departureDate']));
										}else{
											$departureDate = '';
										}

										
										
										?>
											<tr>
										<td><?php echo $departureDate; ?></td>
										<td><?php echo $startTime; ?></td>
										<td><?php echo $endTime; ?></td>
										<td><?php echo $pickupTime; ?></td>
										<td><?php echo $dropTime; ?></td>
										<td><?php echo $timeData['pickupAddress']; ?></td>
										<td><?php echo $timeData['dropAddress']; ?></td>
									</tr>
									 <?php } ?>
									
									
									<?php
								}
								?>

						
								
						</table>
						<table width="100%" cellpadding="5" cellpadding="0">
							<tr><?php 
								if($entrancelisting['transferType']==2){  

									if($resultpageQuotation['languageId']!="0"){
									 	$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');  
										$checkrow = mysqli_num_rows($rs2);
										$entranceLangData=mysqli_fetch_array($rs2);
										if($checkrow > 0){
								        	if(strlen(trim($entranceLangData['lang_0'.$resultpageQuotation['languageId']]))<1){
								        		echo '<tr><td colspan="5"><div class="serviceDesc">'.strip($entranceData['entranceDetail']).'</div></td></tr>';
								        	}else{
								        		echo '<tr><td colspan="5"><div class="serviceDesc">'.strip($entranceLangData['lang_0'.$resultpageQuotation['languageId']]).'</div></td></tr>';
								        	}
								        } else{
											echo '<tr><td colspan="5"><div class="serviceDesc">'.strip($entranceData['entranceDetail']).'</div></td></tr>';
									    } 
									} else {
										echo '<tr><td colspan="5"><div class="serviceDesc">'.strip($entranceData['entranceDetail']).'</div></td></tr>';
								    } 
							  	}
							  
								?></tr>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php  
					}
				}

				if($itineryDayData['serviceType'] == 'activity'){  
					$where4='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
					$rs4=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where4);  
					if(mysqli_num_rows($rs4) > 0){  
						$activitylisting=mysqli_fetch_array($rs4);    
						$rs41=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id="'.$activitylisting['otherActivityName'].'" and  status=1');  
						$activityData=mysqli_fetch_array($rs41);  

					$c="";
					$c=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$activitylisting['id'].'" and quotationId="'.$activitylisting['quotationId'].'"');

					$activityTime = mysqli_fetch_assoc($c);
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
					            $rs5='';
					            $rs5=GetPageRecord('*','imageGallery',' parentId = "'.$activityData['id'].'" and galleryType="activity" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" )  order by id desc');
					            $resListing5=mysqli_fetch_array($rs5);
				            	if($resListing5['fileId']!=''){ 
					            	$activityImage = geDocFileSrc($resListing5['fileId']);
					            	if(file_exists('../'.$activityImage)==true){
					            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$activityImage).'" width="200" height="130">';  
					            	}else{
					            		echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">';   
					            	}
					            }else{
									
									echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">';   

									
					              
					            } 
					            ?></div>
					        </td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo strip($activityData['otherActivityName']);  ?></strong></td>
										</tr> 

										<tr>
											<td><strong class="subHeading"><?php if($activitylisting['transferType']==1){ echo "Transfer Type - SIC"; }elseif($activitylisting['transferType']==2){ echo "Transfer Type - PVT"; }elseif($activitylisting['transferType']==3){ echo "Transfer Type - VIP"; }elseif($activitylisting['transferType']==4){ echo "Transfer Type - Ticket Only"; }  ?></strong></td>

											
										</tr> 
										<?php
								// echo $resultpageQuotation['languageId'];
										if($resultpageQuotation['languageId']!="0"){
										 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"');  
											$checkrow = mysqli_num_rows($rs2);
											$activityLangData=mysqli_fetch_array($rs2);
											if($checkrow > 0){
									        	if(strlen(trim($activityLangData['lang_0'.$resultpageQuotation['languageId']]))<1){
									        		echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($activityData['otherActivityDetail']).'</div></td></tr>';
									        	}else{
									        		echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($activityLangData['lang_0'.$resultpageQuotation['languageId']]).'</div></td></tr>';
									        	}
									        } else{
												echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($activityData['otherActivityDetail']).'</div></td></tr>';
										    } 
										} else {
											echo '<tr><td colspan="3"><div class="serviceDesc">'.strip($activityData['otherActivityDetail']).'</div></td></tr>';
									    } 
									    ?>


										<!--started  Inclusions / Exclusions & Timing  and Important Note-->
										
										<?php if(($activityData['inclExclTim'])!=''){?>
										<tr>
											<td colspan="3">
												<div class="serviceDesc">
												<h4 style="color: black;">Inclusions / Exclusions & Timing</h4>
													<?php echo	strip($activityData['inclExclTim']);
													?>


												</div>
										</td></tr>
										<?php } ?>

										<?php if(($activityData['impNote'])!=''){?>
											<tr>
											<td colspan="3">
												<div class="serviceDesc">
												<h4 style="color: black;">Important Note</h4>
													<?php echo	strip($activityData['impNote']);
													?>


												</div>
										</td></tr>
										<?php } ?>
										
										<!--Ended  Inclusions / Exclusions & Timing  and Important Note-->
									</tbody>
								</table>
							</td>
							</tr>
						
							
							</tbody>
						</table>
						<?php if(mysqli_num_rows($c)>0){ ?>
						<table align="right" width="70%" cellpadding="5" cellspacing="0" border="1">
							<tbody>
							<tr style=" background: #4170fb; color:#fff; font-weight:500;">
								
								<td><strong>Start&nbsp;Time</strong></td>
								<td><strong>End&nbsp;Time</strong></td>
							</tr>
							<tr>
							
								<td><?php echo $activityTime['startTime'] ?></td>
								<td><?php echo $activityTime['endTime'] ?></td>
							</tr>
							</tbody>
						</table>
						<?php } ?>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php  
					}
				}

				// Restaurant services
				if($itineryDayData['serviceType'] == 'mealplan'){   
					$wherer3='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc'; 
					$rs3=GetPageRecord('*','quotationInboundmealplanmaster',$wherer3);  
					if(mysqli_num_rows($rs3) > 0){
						$restlisting=mysqli_fetch_array($rs3);
						
						$rsrstn=GetPageRecord('*','inboundmealplanmaster','id="'.$restlisting['mealPlanNameId'].'"');  
						$restaurantData=mysqli_fetch_array($rsrstn); 

						$rsmeal=GetPageRecord('*','restaurantsMealPlanMaster','id="'.$restlisting['mealType'].'"');  
						$restaurantMeal=mysqli_fetch_array($rsmeal); 
						
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
				          
				           
			            	if($restaurantData['mealPlanImage']!=''){ 
				            	$restImagepath = 'packageimages/'.$restaurantData['mealPlanImage'];
				            	if(file_exists('../'.$restImagepath)==true){ 
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$restImagepath).'" width="200" height="130">';
				            	}else{
									echo '<img src="'.$fullurl.'images/restaurant.png" width="200" height="130">'; 
				            	}
				            }else{ 
								echo '<img src="'.$fullurl.'images/restaurant.png" width="200" height="130">'; 
				            } 
				          	?></div></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr><td><strong>Restaurant&nbsp;Name</strong></td>
										<td><strong>Meal Type</strong></td>
										</tr>
										<tr>
											
											<td ><strong class="serviceTitle"><?php echo strip($restlisting['mealPlanName']);  ?></strong></td>
											<td><strong><?php echo $restaurantMeal['name']; ?></strong></td>
										</tr>
										
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php  
					}
				}

				// Ferry Service start
				if($itineryDayData['serviceType'] == 'ferry'){  
					$where5='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
					$rs5=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,$where5);  
					if(mysqli_num_rows($rs5) > 0){  
					 	$ferrQuotData=mysqli_fetch_array($rs5);  
						$rs52=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,' id="'.$ferrQuotData['serviceid'].'" ');  
						$ferryData=mysqli_fetch_array($rs52);   
						// code here
						$rs512=GetPageRecord('*','ferryNameMaster',' id="'.$ferrQuotData['ferryNameId'].'" ');  
						$ferryNameData=mysqli_fetch_array($rs512);
						$rs512=GetPageRecord('*','ferryClassMaster',' id="'.$ferrQuotData['ferryClass'].'" ');  
						$ferryClassData=mysqli_fetch_array($rs512);   
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox">
							<?php 
				            		$ferryImagePath = 'packageimages/'.$ferryNameData['image'];
				            	if($ferryNameData['image']!='' && file_exists('../'.$ferryImagePath)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$ferryImagePath).'" width="200" height="130">';  
				            	}else{
				            		echo '<img src="'.$fullurl.'images/ferry-default.png" width="200" height="130">';   
				            	}
					            ?>
					            </div>
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tr>
										<td><strong class="serviceTitle">Ferry&nbsp;Name</strong></td>
										<td><strong class="serviceTitle">Ferry&nbsp;Class</strong></td>
									</tr>
									<tbody>
										<tr>
											<td><?php echo strip($ferryData['name']);  ?></td>
											<td><?php echo strip($ferryClassData['name']);  ?></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php echo html_tidy($ferryData['information']);  ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 

					}
				}
				// Cruise
				if($itineryDayData['serviceType'] == 'cruise'){  
					$where5='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
					$rs6=GetPageRecord('*',_QUOTATION_CRUISE_MASTER_,$where5);  
					if(mysqli_num_rows($rs6) > 0){  
					 	$cruiseQuotData=mysqli_fetch_array($rs6);  
						$rs52=GetPageRecord('*','cruiseMaster',' id="'.$cruiseQuotData['serviceId'].'" ');  
						$cruiseData=mysqli_fetch_array($rs52);   
						// code here
						$rs512=GetPageRecord('*','cabinTypeMaster',' id="'.$cruiseQuotData['cabinTypeId'].'" ');  
						$cruiseCabinData=mysqli_fetch_array($rs512);

						$rsN=GetPageRecord('*','cruiseNameMaster',' id="'.$cruiseQuotData['cruiseNameId'].'" ');  
						$cruiseNameData=mysqli_fetch_array($rsN);
						
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox">
							<?php 
				            		$cruiseImagePath = 'packageimages/'.$cruiseNameData['image'];
				            	if($cruiseNameData['image']!='' && file_exists('../'.$cruiseImagePath)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$cruiseImagePath).'" width="200" height="130">';  
				            	}else{
				            		echo '<img src="'.$fullurl.'images/ferry-default.png" width="200" height="130">';   
				            	}
					            ?>
					            </div>
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tr>
										<td><strong class="serviceTitle">Cruise&nbsp;Name</strong></td>
										<td><strong class="serviceTitle">Cabin&nbsp;Type</strong></td>
										<td><strong class="serviceTitle">Departure&nbsp;Date</strong></td>
									</tr>
									<tbody>
										<tr>
											<td><?php echo strip($cruiseData['cruiseName']);  ?></td>
											<td><?php echo strip($cruiseCabinData['name']);  ?></td>
											<td><?php if($cruiseQuotData['departureDate']!=''){ echo date('d-m-Y',strtotime($cruiseQuotData['departureDate'])); } ?></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php echo html_tidy($ferryData['information']);  ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'additional'){  
					$where5='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" and additionalId in ( select id from extraQuotation where proposalService=1) order by id asc';   
				  
					$rs5=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where5);  
					if(mysqli_num_rows($rs5) > 0){  
					 	$additionalQuotData=mysqli_fetch_array($rs5);  
						$rs51=GetPageRecord('*','extraQuotation',' id="'.$additionalQuotData['additionalId'].'" ');  
						$extraData=mysqli_fetch_array($rs51);   
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox">
							<?php 
				            		$otherimgPath = 'packageimages/'.$extraData['file_extra'];
				            	if(file_exists('../'.$otherimgPath)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$otherimgPath).'" width="200" height="130">';  
				            	}else{
				            		echo '<img src="'.$fullurl.'images/sightseeingthumbpackage.png" width="200" height="130">';   
				            	}
					            ?>
					            </div>
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="0" cellspacing="0" >
									<tbody>
										<tr>
											<td ><strong class="serviceTitle"><?php echo strip($extraData['name']);  ?></strong></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php echo html_tidy($extraData['otherInfo']);  ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'train' ){ 
					$quotTrainSql='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$quotTrainQuery=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$quotTrainSql);  
					if(mysqli_num_rows($quotTrainQuery) > 0){
						$trainQuoteData=mysqli_fetch_array($quotTrainQuery); 
						$trainTypeLable ='';
						if($trainQuoteData['isLocalEscort']==1){
					        $trainTypeLable .= "Local Escort,";
					    }
					    if($trainQuoteData['isForeignEscort']==1){
					        $trainTypeLable .= "Foreign Escort,";
					    }
					    if($trainQuoteData['isGuestType']==1){
					        $trainTypeLable .= "Guest,";
					    } 
						$trainQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
						$trainData=mysqli_fetch_array($trainQuery);  

						$jfrom = getDestination($trainQuoteData['departureFrom']);
						$jto= getDestination($trainQuoteData['arrivalTo']); 

						if(date('Hi',strtotime($trainQuoteData['departureTime'])) <> '0530'){
							$dptTime = "/@".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
						}else{
							$dptTime ='';
						}	
						if(date('Hi',strtotime($trainQuoteData['arrivalTime'])) <> '0530'){
							$avrTime = date('Hi',strtotime($trainQuoteData['arrivalTime']))." Hrs";
						}else{
							$avrTime ='';
						}														
						$journeyType="";
						if($trainQuoteData['journeyType']=='overnight_journey'){ 
							$journeyType = "Overnight"; 
						}else{ 
							$journeyType = "Day"; 
						} 
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service train">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox"><img src="<?php echo $fullurl; ?>images/train.jpg" width="200" height="130" /></div>
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
									<tr>
										<td colspan="5" ><div class="serviceTitle"><?php  echo rtrim($trainTypeLable,',')." Train ";  echo strip($trainData['trainName']);  ?></div></td>
									</tr>
									<tr> 
										<td width="15%" ><strong>Journey&nbsp;Type</strong></td> 
										<td width="20%" ><strong>TrainNumber</strong></td> 
										<td width="15%" ><strong>TrainClass</strong></td> 
										<td width="25%" ><strong>Dept-Arr</strong></td> 
										<td width="25%" ><strong>Dept-Arr&nbsp;Time</strong></td> 
									</tr> 
									<tr> 
										<td width="15%" ><?php echo $journeyType; ?></td> 
										<td width="20%" ><?php echo strip($trainQuoteData['trainNumber']); ?></td> 
										<td width="15%" ><?php echo strip($trainQuoteData['trainClass']); ?></td> 
										<td width="25%" ><?php echo ucfirst($jfrom).'-'.ucfirst($jto); ?></td> 
										<td width="25%" ><?php echo trim($dptTime).'-'.trim($avrTime); ?></td> 
									</tr>
								</table>	
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'flight' && $resultpageQuotation['flightCostType']==0){ 
					$quotFlightSql='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$quotFlightQuery=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$quotFlightSql);  
					if(mysqli_num_rows($quotFlightQuery) > 0){
						$flightQuoteData=mysqli_fetch_array($quotFlightQuery); 
						$flightTypeLable ='';
						if($flightQuoteData['isLocalEscort']==1){
					        $flightTypeLable .= "Local Escort,";
					    }
					    if($flightQuoteData['isForeignEscort']==1){
					        $flightTypeLable .= "Foreign Escort,";
					    }
					    if($flightQuoteData['isGuestType']==1){
					        $flightTypeLable .= "Guest,";
					    } 
						$flightQuery=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData['flightId'].'"');  
						$flightData=mysqli_fetch_array($flightQuery);
						$flightName = $flightData['flightName'];

						$jfrom = getDestination($flightQuoteData['departureFrom']);
						$jto= getDestination($flightQuoteData['arrivalTo']); 

						if(date('Hi',strtotime($flightQuoteData['departureTime'])) <> '0530'){
							$dptTime = "@".date('Hi',strtotime($flightQuoteData['departureTime']));
						}else{
							$dptTime ='';
						}	
						if(date('Hi',strtotime($flightQuoteData['arrivalTime'])) <> '0530'){
							$avrTime = date('Hi',strtotime($flightQuoteData['arrivalTime']))." Hrs";
						}else{
							$avrTime ='';
						}	


						$c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$flightQuoteData['id'].'" and quotationId="'.$flightQuoteData['quotationId'].'" and dayId="'.$flightQuoteData['dayId'].'"');
						$timeData = mysqli_fetch_assoc($c1);

						if($timeData['departureDate']!='' && $timeData['departureDate']!='00-00-00'){
						$departureDate = date('d-m-Y', strtotime($timeData['departureDate']));
						}else{
						$departureDate = '';
						}

						if($timeData['departureTime']!='' && $timeData['departureTime']!='00:00:00'){
						$departureTime = date('H:i:s', strtotime($timeData['departureTime']));
						}else{
						$departureTime = '';
						}

						if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='00-00-00'){
						$arrivalDate = date('d-m-Y', strtotime($timeData['arrivalDate']));
						}else{
						$arrivalDate = '';
						}

						if($timeData['arrivalTime']!='' && $timeData['arrivalTime']!='00:00:00'){
						$arrivalTime = date('H:i:s', strtotime($timeData['arrivalTime']));
						}else{
						$arrivalTime = '';
						}


						// $flightQuery222=GetPageRecord('*','flightTimeLineMaster','flightId="'.$flightQuoteData['flightId'].'"');  
						// $flightData222=mysqli_fetch_array($flightQuery222);
						// $flightvia = $flightData222['via'];
						
						$via = $timeData['via'];


							date('d-m-Y', strtotime($timeData['arrivalDate'])).'<br>'.date('H:i:s', strtotime($timeData['arrivalTime']));
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service flight">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><div class="imgbox">
								<img src="<?php echo $fullurl; ?>images/flight.jpg" width="200" height="130" />
							</div>
							</td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" > 
									<!-- <tr>
										<td colspan="4" ><strong class="serviceTitle"><?php  echo rtrim($flightTypeLable,',')." Flight ";  echo strip($flightData['flightName']);  ?></strong></td>
									</tr> -->
									<tr> 
										<td width="10%"><strong>Flight Number</strong></td> 
										<td width="10%"><strong>Flight Class</strong></td> 
										<td width="30%"><strong>From-To</strong></td> 
										<!--<td width="30%"><strong>Via</strong></td>-->
										<td width="30%"><strong>Departure&nbsp; Date/Time</strong></td>
										<td width="30%"><strong>Arrival&nbsp; Date/Time</strong></td>
									</tr> 
									<tr> 
										<td width="20%"><?php echo strip($flightQuoteData['flightNumber']).'<br>'.$flightName; ?></td> 
										<td width="20%"><?php echo strip($flightQuoteData['flightClass']); ?></td> 
										<td width="40%"><?php echo ucfirst($jfrom).'-'.ucfirst($jto).'<br><b> Via</b> - '.$via; ?></td>
										
										
										<!--<td width="30%"><?php echo $via ?></td>-->
										<td width="30%"><?php echo trim($departureDate).' / '.trim($departureTime); ?></td>
										
										<td width="30%"><?php echo trim($arrivalDate).' / '.trim($arrivalTime); ?></td>
									</tr>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="760" />
						</div>
						<?php 
						
					}
				}
				// END OF SERVICES
			}
			?>
		</td></tr></table>

		<?php
	$n++; 
	$day++;
	}
	?>
	<br />	
	<br />	
	<?php 

	$_REQUEST['parts'] = "normalValueAddedServices";
	include('proposal_parts.php');
	 ?>

	<br />  
	<?php 
	$totalHotel = 0;
	$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
	if(mysqli_num_rows($b1)>0){
	?>
		<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;">
			<div style="font-size: 18px!important;">HOTEL PROPOSED</div>
			<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr>
		</table>
		<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td>
		<table  width="100%"  border="1" cellpadding="8" cellspacing="0" borderColor="#ccc" class="borderedTable table-service">
	 	<tr style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
			<th width="20%" align="left" valign="middle" ><strong>Dates</strong></th>
			<th width="12%" align="left" valign="middle" ><strong>City</strong></th>
			<th width="27%" align="left" valign="middle" ><strong>Hotel</strong></th>
			<th width="16%" align="left" valign="middle" ><strong>Room Type</strong></th>
 			<th width="25%" align="left" valign="middle" ><strong>Remarks</strong></th>
		</tr>
		<?php 
		// $totalHotel = 0;
		// $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
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
				    if($hotelQuotData['isGuestType']==1 && $hotelQuotData['isEarlyCheckin']==1){
				        $hotelTypeLable .= "Guest,";
				    }
					if($hotelQuotData['isGuestType']==1 && $hotelQuotData['isEarlyCheckin']==0){
				        $hotelTypeLable .= "Guest,";
				    }
					if($hotelQuotData['isEarlyCheckin']==1 && $hotelQuotData['isGuestType']==0){
				        $hotelTypeLable .= "Early Check-In,";
				    }

					$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
					$hotelData=mysqli_fetch_array($d);
					
					$start = strtotime($hotelQuotData['fromDate']);
					$end = strtotime($hotelQuotData['toDate']);
					$days_between='';
					$days_between = ceil(abs($end - $start) / 86400);
					?> 
				  	<tr>
						<td valign="middle">
						<?php 
						echo date('j M Y',strtotime($sorting3['startDate']));  
						?>
						</td>
						<td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
						<td valign="middle"><?php echo rtrim($hotelTypeLable,',')." Hotel- ".strip($hotelData['hotelName']);  ?></td>
						<td valign="middle"><?php 
						$select12='*';  
						$where12='id="'.$hotelQuotData['roomType'].'"'; 
						$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
						$editresult2=mysqli_fetch_array($rs12);
						echo $rtype=$editresult2['name'];
						?></td>
						<td valign="middle"></td>
				  	</tr>
				  	<?php 
				}
			} 
		} 
		?>
		</table>
		<!-- Total Tour Cost and per person basis costs details -->
		</td></tr>
		</table>
	<?php } ?>
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">QUOTATION</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
		<?php 
		$queryId = $resultpageQuotation['queryId'];
		$quotationId= $resultpageQuotation['id'];
		$_REQUEST['parts'] = 'costingDetail';
		include('proposal_parts.php');
	 	?>
	<?php 
	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
		?>
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">AIR FARE SUPPLEMENT</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td> 
		<!-- <div class="serviceTitle">Air Fare Supplement</div> -->
		<table border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service">
			<tr style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="12%" valign="middle" bgcolor="#233a49"><strong>Date</strong></th>
				<th width="19%" valign="middle" bgcolor="#233a49"><strong>Sector</strong></th>
				<th width="30%" valign="middle" bgcolor="#233a49"><strong>Flight/Timings</strong></th>
				<th width="28%" valign="middle" bgcolor="#233a49"><strong>Class/Baggage</strong></th>
				<th width="11%" align="right" valign="middle" bgcolor="#233a49"><strong>Fare</strong></th>
			</tr>
			<?php 
			
			while($flightQuotData=mysqli_fetch_array($betet)){ 
	           
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
					<td valign="middle"><div><?php echo getCurrencyName($newCurr); ?>&nbsp;<?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?></div></td>
	 			</tr>
			  <?php 
			} ?>
		  <tr>
		  	<td colspan="5" align="center">Air fares are subject to change at the time of booking</td>
		  </tr>
		</table>
	</td></tr></table>
	<?php 
	}

	

		// visa supplement Cost
		$visa=GetPageRecord('*',_QUOTATION_VISA_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
		if($resultpageQuotation['visaCostType'] == 2 && mysqli_num_rows($visa)>0){ 
		?> 
		<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">VISA SUPPLEMENT</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	
		<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
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
						<td align="right" valign="middle"><?php if($visaQuotData['infantPax']>0){ echo  getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$totaldInfantCost);  ?>&nbsp;<?php if($visaQuotData['infantPax']>0){ echo 'X&nbsp;'.$visaQuotData['infantPax'];} } ?></td>
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
			if($resultpageQuotation['passportCostType'] == 2 && mysqli_num_rows($pass)>0){ 
			?> 
			<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">PASSPORT SUPPLEMENT</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
		
			<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
			<tr>
			<td>
				<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
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
							<td align="right" valign="middle"><?php if($passQuotData['childPax']){ echo getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$passQuotData['childCost']); ?>&nbsp;<?php if($passQuotData['childPax']>0){ echo 'X&nbsp;'.$passQuotData['childPax'];} } ?></td>
							<td align="right" valign="middle"><?php if($passQuotData['infantPax']){ echo  getCurrencyName($newCurr).' '.getChangeCurrencyValue_New($defaultCurr,$quotationId,$passQuotData['infantCost']);  ?>&nbsp;<?php if($passQuotData['infantPax']>0){ echo 'X&nbsp;'.$passQuotData['infantPax'];} } ?></td>
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
			if($resultpageQuotation['insuranceCostType'] == 2 && mysqli_num_rows($insur)>0){ 
			?> 
				<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">INSURANCE SUPPLEMENT</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
		
			<table  width="100%" border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
			<tr>
			<td>
				<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
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



	$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isRoomSupplement=1 '); 
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=1 '); 
	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0  ){
		?>
		<div class="docTitle w60" style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">SUPPLEMENT SERVICES<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 47px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
		<?php
	}
	// INCLUDE SUPPLEMENT HOTEL AND RATE HERE
	$suppRoomQuery=$checkSuppHQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isRoomSupplement=1 ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0){ ?>
		<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td>
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'hotelSupplement';
			include('proposal_parts.php');
			?>
		</td></tr></table>
		<?php 
	}   
	// additional requirment 
	$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.($quotationId).'" group by serviceType order by id asc');
		if( mysqli_num_rows($c12) > 0){ ?>
			<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">ADDITIONAL EXPERIENCES (SUPPLEMENT)</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
			<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td>
				<?php  
				$queryId = $resultpageQuotation['queryId'];
				$quotationId= $resultpageQuotation['id'];
				$_REQUEST['parts'] = 'additionalSupplement';
				include('proposal_parts.php');
				?>
			</td></tr></table>
			<?php 
		} 

	?> 
<!-- <?php  //if($overviewText!=''){ ?> 
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">TOUR OVERVIEW</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php //echo html_tidy(strip($overviewText)); ?></td></tr></table> -->
<?php  if($inclusion!=''){ ?> 
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;"><?php echo $inclusionTitle; ?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($inclusion)); ?></td></tr></table>
<?php } if($exclusion!=''){ ?> 
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;"><?php echo $exclusioinTitle; ?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($exclusion)); ?></td></tr></table>
<?php } if($tncText!=''){ ?> 
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;"><?php echo $termCTitle; ?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($tncText)); ?></td></tr></table>
<?php } if($specialText!=''){ ?>  
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;"><?php echo $cancelPTitle ?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>

	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($specialText)); ?></td></tr></table>
	
	<?php } if($paymentpolicy!=''){ ?>  
	<!-- payments policy started-->
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;"><?php echo $paymentPTitle ?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>

	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($paymentpolicy)); ?></td></tr></table>
<?php } if($remarks!=''){ ?>  
	<!-- Remarks started-->
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;"><?php echo $remarksTitle ?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>

	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($remarks)); ?></td></tr></table>
<?php }

	$_REQUEST['parts'] = 'emeragencyContactDetail';
	include('proposal_parts.php');
?>
	<br />	
	
	<?php 
	$selectF= 'footerstatus, footertext';
	$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
    $resultf = mysqli_fetch_assoc($resfooter);
	if($resultf['footerstatus']==1){ ?> 
	<div style="padding: 30px; padding-bottom: 10px; /* background-color: #ccc; */ display: block; position: relative; font-size: 14px; color: #424244; font-weight: 400; font-family: 'Source Sans Pro', sans-serif;" class="dayItineraryInfo ">
		<a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" >
			<img src="<?php echo $fullurl; ?>images/generated-by-TRAVCRM.png" width="760" />
		</a>
	</div>
	<?php } ?>

	</td>
	</tr>
</table> 
</div>

