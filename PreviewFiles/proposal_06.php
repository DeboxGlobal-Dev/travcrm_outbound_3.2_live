

<style>
		@media print{
			.proposalHeader{
						margin-top: 30px !important;
					}
					*{
						-webkit-print-color-adjust: exact;
					}
					.page-break {
						page-break-before: always;
					}
		}
		.hoverClass{
		
		background: #233A49;
		color: #fff;
		font-size: 12px;
		padding: 5px;
		width: 80px;
		text-align: center;
		border-radius: 7px;
		display: none;
		}
		.hiperlinkcls{
			display: block !important;
		}


		.serviceDesc ul{
			list-style-position: inherit!important;
			padding: 0;
			margin: 20px 0px 0px 20px;
		}

		.fitDesc ul{
			list-style-position: inherit!important;
			padding: 0;
			margin: 10px 0px 0px 20px;
		}
</style>
<div class="main-container" style="width:820px !important; position:relative !important;">
<table width="820">
	<tr>
			<td>

		
		<?php
		// proposal header image ===========
		$rs03='';
		$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="6" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
		$resListing3=mysqli_fetch_array($rs03);
		$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
		if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?><table class="firstpage proposalHeader"  width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0px solid #ccc;">
				<tbody>
					<tr>
						<td align="center" valign="top">
							<img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="770" height="80"  >
						</td>
					</tr>
				</tbody>
			</table><?php
		}
		?>
		<table  width="100%" border="0" cellpadding="15" cellspacing="0" >
		<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" ><tr><td align="center"><?php
					$imagepath = 'upload/'.$resultpageQuotation['propIMGNum6'];
				if($resultpageQuotation['propIMGNum6']!='' && file_exists($imagepath)==true){ ?>
					<img align="center" src="<?php echo $fullurl.'PreviewFiles/'.str_replace(' ','%20',$imagepath); ?>" alt="" width="750" height="500" >
					<?php
				}else{
					$rsb03='';
					$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="6" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="750x500" order by id desc) order by id desc');
					$resListingb3=mysqli_fetch_array($rsb03);
					$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
					if($resListingb3['fileId']!='' && file_exists('../'.$proposalPhotob3)==true){ ?>
						<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>" width="750"  height="500" >
						<?php
					}
				}
					?> 

					</td>
				</tr> 
			</table><br><table  width="100%" border="0" cellpadding="5" cellspacing="0" style="background-color: #fff;">
						<tr>
							<td align="left"><strong>&nbsp;&nbsp;Vivid Proposal</strong></td>
							<td align="right"><strong>Query Id: <?php echo makeQueryId($resultpage['id']);  ?></strong></td>
						</tr>
						<tr >
							<td align="center" colspan="2"><br><br><strong style="font-size: 18px;"><?php echo trim($resultpage['leadPaxName']); ?></strong></td>
						</tr>
						<tr>
							<td align="center" colspan="2">
								
								<strong style="line-height:40px;font-size: 35px;color:#133f6d;text-align: center;"><?php echo substr($quotationSubject, 0, 100); ?>&nbsp;</strong>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><strong style="font-size: 18px;">&nbsp;&nbsp;<?php 
							echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; 
							?>&nbsp;&nbsp;&nbsp;</strong>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2" valign="middle" ><strong style="font-size: 18px;">&nbsp;&nbsp;<?php  
								$rootMapQuery=GetPageRecord('cityId','newQuotationDays',' quotationId="'.$quotationId.'"  group by cityId order by srdate asc'); 
								$numRoots = mysqli_num_rows($rootMapQuery); 
								$cnt = 1; 
								while($rootMapData=mysqli_fetch_array($rootMapQuery)){ 
									echo getDestination($rootMapData['cityId']); 
									if($numRoots > $cnt){ ?> - <?php } 
									$cnt++;
								}
								?>&nbsp;&nbsp;&nbsp;</strong>
							</td>
						</tr>
				</table>
			</td>
			</tr>
		</table>
		<br /><?php
		if($highlightsText!=''){ ?>
				<table width="100%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 10px;">TOUR&nbsp;HIGHLIGHTS</div></th></tr></table>

				<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td>
							<?php
							echo $highlightsText = clean($highlightsText);
						?></td></tr></table><?php 
				} ?><br>
			

	<br>
	<!-- end dynamic hotel star -->
	<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="center" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 10px;">TOUR&nbsp;PROGRAM</div></th></tr></table>
	<br />


	<!-- Hotel details and costing  sec started  -->
	
			<!-- start dynamic hotel star -->
			<table width="100%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 10px;">Itinerary Information</div></th></tr></table>
			<br /><br />
		<?php $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by srn asc,id desc'); 
		if(mysqli_num_rows($b1)>0){
		?>
		<table  width="100%" border="0" cellpadding="15" cellspacing="0" ><tr><td>
		<?php

		if($resultpageQuotation['quotationType']=='2' || $resultpageQuotation['quotationType']=='3'){
			?>
			<!-- new hotel glance code -->
			<table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#ccc" class="borderedTable" >
				
			<thead>
				<tr style="page-break-inside:avoid">
				<th valign="middle" width="15%"	align="left" ><strong>Day</strong></th>
				<th valign="middle" width="10%"	align="left"  ><strong>City</strong></th>
				<?php 
				$resultpageQuotation['hotCategory'];
				$hotCategory2 = explode(',',$resultpageQuotation['hotCategory']);

				if($resultpageQuotation['quotationType']==3){	
						$hotCategory2 = explode(',',$resultpageQuotation['hotelType']);
				}
				$cols = count($hotCategory2);
					$colwidth = 75;

					$starwidth = $colwidth/$cols;
				foreach($hotCategory2 as $val2){
					$rsname1=GetPageRecord('*','hotelCategoryMaster','id="'.$val2.'"');
					$hotelCatData1=mysqli_fetch_array($rsname1);
					$hotelCategory = $hotelCatData1['hotelCategory'].' Star';

					// hotel type
					$rsname11=GetPageRecord('*','hotelTypeMaster','id="'.$val2.'"');
					$hotelCatData11=mysqli_fetch_array($rsname11);
					$hotelCategory11 = $hotelCatData11['name'];

					?>
						<th  align="left" width="<?php echo $starwidth; ?>%" ><strong><?php
						if($hotelCategory>0){
						echo $hotelCategory;
					}else{
						echo $hotelCategory11;
					} 
					
					?></strong></th>
					<?php
				}
				?> 
				</tr>
			</thead>
			<tbody>
		<?php  
		$day=1;
		$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
		while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
			$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
			$dayId = $QueryDaysData['id']; 
			
			?>
			<tr style="page-break-inside:avoid">
				<td valign="middle" align="left"><span><strong><?php echo "Day ".$day; if($dayWise == 1){   ?>  <?php echo date('D', strtotime($dayDate))."<br>"; echo date('j M Y', strtotime($dayDate)); }  ?></strong></span></td>
				<td valign="middle" align="left"><?php echo getDestination($QueryDaysData['cityId']); $destn = getDestination($QueryDaysData['cityId']); ?></td>
				<?php
				$hotCategory3 = explode(',',$resultpageQuotation['hotCategory']);
				if($resultpageQuotation['quotationType']==3){	
					$hotCategory3 = explode(',',$resultpageQuotation['hotelType']);

				}
				foreach($hotCategory3 as $val3){
					?>
					<td  align="left">
					<?php 
					$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and dayId="'.$dayId.'" and serviceType="hotel" order by srn asc,id desc'); 
					while($sorting1=mysqli_fetch_array($b1)){ 
						$orsimilar='';
						if($resultpageQuotation['quotationType']==2){
						 	$where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1  and isRoomSupplement!=1 and supplierId="'.$sorting1['serviceId'].'" and categoryId ="'.$val3.'"';  
						}
							if($resultpageQuotation['quotationType']==3){
								$where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1  and isRoomSupplement!=1 and supplierId="'.$sorting1['serviceId'].'" and hotelTypeId ="'.$val3.'"';  
								$orsimilar = 'or similar';
							}
						$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
						if(mysqli_num_rows($rs22) > 0){
						
							$hotellisting=mysqli_fetch_array($rs22);
				
							$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'" ');  
							$hotelData=mysqli_fetch_array($rs1ee); 
							

							// get star hotel
							$d1=GetPageRecord('*','hotelCategoryMaster',' id="'.$hotelData['hotelCategoryId'].'"');   
							$hCategoryData=mysqli_fetch_array($d1);
							$hotelCategory = $hCategoryData['hotelCategory'];
							$hotelStarCategory='';
							
							for($i=1;$i<=$hotelCategory;$i++){
							
								$hotelStarCategory.='<img src="'.$fullurl.'images/hotelStar.png" alt="" width="20px">';	
							}	
							


							//hotel details
							if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel:"; }?>
							<a class="hiperlinkcls" target="_blank" href="<?php echo $hotelData['url']; ?>"> <?php echo $hotelData['hotelName'];?></a>
							<?php
							
							echo $hotelStarCategory.'<br>';

								$rs1='';
								$rs1=GetPageRecord('*','roomTypeMaster','id='.$hotellisting['roomType'].''); 
								$roomType = mysqli_fetch_assoc($rs1);
								echo $roomType['name'];
								echo '<br>'.$orsimilar;

							$rs2='';  
							$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
							$editresult2=mysqli_fetch_array($rs2);
							?><br><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>
							<?php
							if($hotellisting['complimentaryBreakfast']>0){
								$breakfast = ", Breakfast";
							}else{
								$breakfast = '';
							}

							if($hotellisting['complimentaryLunch']>0){
								$lunch = ", Lunch";
							}else{
								$lunch = '';
							}
							
							if($hotellisting['complimentaryDinner']>0){
								$dinner = ", Dinner";
							}else{
								$dinner = '';
							}
							if($editresult2['subname']!=''){
								echo " Meal - ".clean($editresult2['subname'].' '.$breakfast.'  '.$lunch.' '.$dinner);
							}else{
								echo " Meal - ".clean($editresult2['name'].' '.$breakfast.' '.$lunch.' '.$dinner);
							}
						// }
						}
					}
					?>
					</td>
					<?php
				}
				?> 
			</tr>
			<?php $day++; 
		} ?>
		</tbody> 
		</table>
		<!-- end multiple hotel category code here-->
		<?php
	}else{
		?>
		<table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#ccc"  class="borderedTable">
			<tr>
			<th width="20%" valign="middle" align="left"><strong>Day</strong></th>
			<th width="20%" valign="middle" align="left"><strong>City</strong></th>
			<th width="60%" valign="middle" align="left"><strong>Hotel</strong></th>
			<th width="60%" valign="middle" align="left"><strong>Total&nbsp;Rooms</strong></th>
			<th width="60%" valign="middle" align="left"><strong>Adult/Child</strong></th>
			</tr>
			<?php
			
			$day=1;
			$where22='quotationId="'.$resultpageQuotation['id'].'" and isHotelSupplement!=1  and isRoomSupplement!=1 order by fromDate asc';   
			$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
			if(mysqli_num_rows($rs22) > 0){
				while($hotellisting=mysqli_fetch_array($rs22)){ 
					$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
					$hotelData=mysqli_fetch_array($rs1ee);    
					$dayDate = date('Y-m-d', strtotime($hotellisting['fromDate']));

					$d1=GetPageRecord('*','hotelCategoryMaster',' id="'.$hotelData['hotelCategoryId'].'"');   
					$hCategoryData=mysqli_fetch_array($d1);
					$hotelCategory = $hCategoryData['hotelCategory'];
					$hotelStarCategory='';
				
					for($i=1;$i<=$hotelCategory;$i++){
					
						$hotelStarCategory.='<img src="'.$fullurl.'images/hotelStar.png" alt="" width="20px">';	
					}
					?><tr style="page-break-inside:avoid">
					<td valign="middle"><span><strong><?php echo "Day ".$day; if($dayWise  == 1){ ?>  <?php echo date('D', strtotime($dayDate))."<br>"; echo date('j M Y', strtotime($dayDate)); } ?></strong></span></td>
					<td valign="middle"><?php echo getDestination($hotellisting['destinationId']); $destn = getDestination($hotellisting['destinationId']); ?></td>

					<td valign="middle"><?php 
					// services list
					//hotel details
					if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel: "; }elseif($hotellisting['isEarlyCheckin'] == 1){ echo "Early Checkin Hotel: "; } ?>
					<a class="hiperlinkcls" target="_blank" href="<?php echo $hotelData['url']; ?>"> <?php echo $hotelData['hotelName'];?></a><?php
					echo $hotelStarCategory.'<br>';

					$rs1='';
					$rs1=GetPageRecord('*','roomTypeMaster','id='.$hotellisting['roomType'].''); 
					$roomType = mysqli_fetch_assoc($rs1);
					echo $roomType['name'];
				
					$rs2='';  
					$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
					$editresult2=mysqli_fetch_array($rs2);
					?><br><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>
					<?php
					if($hotellisting['complimentaryBreakfast']>0){
						$breakfast = ", Breakfast";
					}else{
						$breakfast = '';
					}

					if($hotellisting['complimentaryLunch']>0){
						$lunch = ", Lunch";
					}else{
						$lunch = '';
					}
					
					if($hotellisting['complimentaryDinner']>0){
						$dinner = ", Dinner";
					}else{
						$dinner = '';
					}
					if($editresult2['subname']!=''){
						echo " Meal - ".clean($editresult2['subname'].' '.$breakfast.'  '.$lunch.' '.$dinner);
					}else{
						echo " Meal - ".clean($editresult2['name'].' '.$breakfast.' '.$lunch.' '.$dinner);
					}
					?></td>
					<?php 
					$TotalRooms = $hotellisting['singleNoofRoom']+$hotellisting['doubleNoofRoom']+$hotellisting['twinNoofRoom']+$hotellisting['tripleNoofRoom']+$hotellisting['quadNoofRoom']+$hotellisting['sixNoofBedRoom']+$hotellisting['eightNoofBedRoom']+$hotellisting['tenNoofBedRoom'];

					// if($hotellisting['singleNoofRoom']>0){
					// 	$TotalRooms = $hotellisting['singleNoofRoom'];
					// }
					// if($hotellisting['doubleNoofRoom']>0){
					// 	$TotalRooms = $hotellisting['doubleNoofRoom'];
					// }
					// if($hotellisting['twinNoofRoom']>0){
					// 	$TotalRooms = $hotellisting['twinNoofRoom'];
					// }
					// if($hotellisting['tripleNoofRoom']>0){
					// 	$TotalRooms = $hotellisting['tripleNoofRoom'];
					// }
					// if($hotellisting['quadNoofRoom']>0){
					// 	$TotalRooms = $hotellisting['quadNoofRoom'];
					// }
					// if($hotellisting['sixNoofBedRoom']>0){
					// 	$TotalRooms = $hotellisting['sixNoofBedRoom'];
					// }
					// if($hotellisting['eightNoofBedRoom']>0){
					// 	$TotalRooms = $hotellisting['eightNoofBedRoom'];
					// }
					// if($hotellisting['tenNoofBedRoom']>0){
					// 	$TotalRooms = $hotellisting['tenNoofBedRoom'];
					// }
						
					?>
			
					<td align="center"><?php echo $TotalRooms; ?></td>
					<!-- <td align="center"><?php echo $totalRooms; ?></td> -->
					<td align="center"><?php echo $resultpageQuotation['adult']; if($resultpageQuotation['child']>0){ echo '/'.$resultpageQuotation['child'];} ?></td>
					</tr>
					<?php 
					$day++; 
				} 
			} ?> 
		</table>
		<?php
	}
	?>
	</td></tr>
	</table>
	<?php } ?>

	<table width="100%"  border="0" cellpadding="0" cellspacing="0" borderColor="#ccc">
	
	<tr style="page-break-before:auto;">
		<td colspan="2" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left">
			<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable " ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 20px;">COSTING DETAILS</div></th></tr></table> 
		</td>
	</tr>
	<tr>
	<td align="center" valign="top">
		<?php 
		$queryId = $resultpageQuotation['queryId'];
		$quotationId= $resultpageQuotation['id'];
		$_REQUEST['parts'] = 'costingDetail';
		include('proposal_parts.php');
	 	?>
	</td>
	</tr> 	
	</table>
	<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable " style="height: 40px;"><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 20px;"></div></th></tr></table> 
	
	
	<!-- Hotel details and costing sec ended -->





<div class="page-break"></div>
	
	<br />
	<?php		
	//------------------------------



	$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
					
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 

		$a22=GetPageRecord('*','destinationMaster','id="'.$QueryDaysData['cityId'].'" ');
        $destData22=mysqli_fetch_array($a22);

        $destinationImage = '';
        $rs5='';
        $rs5=GetPageRecord('*','imageGallery',' parentId = "'.$destData22['id'].'" and galleryType="destination" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="1080x300" ) order by id desc');
        $resListing5=mysqli_fetch_array($rs5);
        if($resListing5['fileId']!=''){
            $destinationImage2 = geDocFileSrc($resListing5['fileId']);
            if(file_exists('../'.$destinationImage2)==true){
             $destinationImage =  '<tr><td  align="center"><img src="'.$fullurl.str_replace(' ', '%20',$destinationImage2).'" width="770" height="auto" /></td></tr>';
            }
        }
		?>
		<div class="" style=" page-break-inside:avoid;">
				<div style="font-size: 22px!important">&nbsp;&nbsp;<img src="<?php echo $fullurl.'images/icon-map-pointer.png'; ?>" width="35" height="35"  style="vertical-align: bottom;"/>&nbsp;Day&nbsp;<?php echo $day;?>&nbsp; 
				
				<?php 
					if($quotationData['dayWise']!=2){ echo date('d-m-Y D', strtotime($dayDate)); }  
				?>
				
				
				<?php echo trim($destData22['name']); ?> </div>
				<?php if($destinationImage!=''){ ?>
				<table width="100%" border="0" cellpadding="15" cellspacing="0">
				<?php echo $destinationImage;  ?>
				</table>
				<?php } ?>
		</div>
		<table  width="100%" border="0" cellpadding="15" cellspacing="0" ><tr><td><div class="serviceDesc" style="text-align: justify;page-break-inside: auto;"><?php
				if(strlen($QueryDaysData['title'])>1) {
					echo "<strong>".trim(urldecode(strip($QueryDaysData['title'])))."</strong>";
					echo "<br />";
				}

				$html = trim(urldecode(strip($QueryDaysData['description'])));
				if($html!=''){
					// $html = str_replace('<ul>','<p>', $html);
					// $html = str_replace('</ul>','</p>', $html);
					// $html = str_replace('<li>','<p>', $html);
					// $html = str_replace('</li>','</p>', $html);
					// $html = str_replace('<p>&nbsp;</p>', '', $html);
					// $html = str_replace('<p>', '<span>', $html);
					// $html = str_replace('</p>', '</span>', $html);
					echo '<span>'.html_tidy(clean($html)).'</span>';
				}

				// destination INformation
				if(${"destination".trim($destData22['id'])} != 1){
					${"destination".trim($destData22['id'])}=1;

					$destInfo = html_tidy(stripslashes($destData22['description']));

					if($resultpageQuotation['languageId'] != "0"){
						$rs2=GetPageRecord('*','destinationLanguageMaster','destinationId="'.$destData22['id'].'"');  
						$destcheckrow = mysqli_num_rows($rs2);
						$destLanData=mysqli_fetch_array($rs2);
						if($destcheckrow > 0){
							if(strlen(trim($destLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
								$destInfo = html_tidy(stripslashes($destData22['description']));
							}else{
								$destInfo = html_tidy(stripslashes($destLanData['lang_0'.$resultpageQuotation['languageId']])); 
							}
						} else{
							$destInfo = html_tidy(stripslashes($destData22['description']));
						} 
					} else {
						$destInfo = html_tidy(stripslashes($destData22['description']));
					} 


					if($destInfo!=''){
						echo "<p>";
						echo "<strong>".trim($destData22['name'])." - </strong> ";
						echo strip_tags(strip($destInfo));
						echo "</p>";
					}
				} 

			// echo '<p><img src="'.$fullurl.'images/icon-home.png" width="20" height="20" style="vertical-align: bottom;"/>&nbsp;&nbsp;';
			// echo "Overnight stay in the Hotel at ".ucfirst($destData22['name']);
			// echo "<strong>Overnight stay&nbsp;at&nbsp;the&nbsp;Hotel in ".trim($destData22['name'])."</strong></p><br>";

			// services list
			$cnt1 = 1;
			// services list
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and dayId="'.$dayId.'" and startDate="'.$dayDate.'" order by srn asc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){
				if($itineryDayData['serviceType'] == 'hotel' ){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1  and isRoomSupplement!=1 and supplierId="'.$itineryDayData['serviceId'].'" and dayId="'.$itineryDayData['dayId'].'"';   
					$rs22='';
					$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
					if(mysqli_num_rows($rs22) > 0){
					
						while($hotellisting=mysqli_fetch_array($rs22)){  
						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
						$hotelData=mysqli_fetch_array($rs1ee);   
							//hotel details
							echo "<p>";
							?><img src="<?php echo $fullurl.'images/icon-home.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;
							<?php
							echo "<strong>Overnight stay&nbsp;at&nbsp;the&nbsp;Hotel in ".trim($destData22['name'])."</strong></p><br>";
							$rs2='';  
							$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id='.$hotellisting['mealPlan'].''); 
							$editresult2=mysqli_fetch_array($rs2);
							// echo "<p>";
							?><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;
							<?php 
							if($editresult2['subname']!=''){
								echo " Meal - ".clean($editresult2['subname']);
							}else{
								echo " Meal - ".clean($editresult2['name']);
							}
							if($hotelData['hotelDetail']!=''){
								// echo strip(trim($hotelData['hotelDetail']))."<br>";					
							}
							$halists='';
							$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$hotellisting['id'].'" and quotationId="'.$hotellisting['quotationId'].'" '); 
							if(mysqli_num_rows($rs12)>0){
								echo "<p>";
								while ($editresult2=mysqli_fetch_array($rs12)) {
									$halists  .= $editresult2['name'].', ';
								}
							?><img src="<?php echo $fullurl.'images/blogcmsicon.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;
							<?php 
							echo rtrim($halists,', ');
							echo "</p>";
							}
							  
						}
					}
						 
				}
				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc');  
					if(mysqli_num_rows($rs22dd) > 0){
						while($transferlisting=mysqli_fetch_array($rs22dd)){  
							$rs2ss=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
							$transfergdetail=mysqli_fetch_array($rs2ss);   
							//transfer detail

							$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
							$vename=mysqli_fetch_array($rs1aa);



							$vehicleName = $vehicleType = $trnsferType = '';
							if($transferlisting['transferType'] == 2){
								$vehicleName = $vename['model']." | ";
								$vehicleType = getVehicleTypeName($transferlisting['vehicleType'])." | ";
							}
							$trnsferType = ($transferlisting['transferType'] == 1)?'SIC | ':'Private | ';
							 
							echo "<p>";
							?><img src="<?php echo $fullurl.'images/icon-transfer.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;<?php
							echo "<strong>".$trnsferType.$vehicleType.$vehicleName.ucfirst($transfergdetail['transferName'])."</strong></p>";	
							if($transfergdetail['transferDetail']!=''){
								echo "<p>".strip(trim($transfergdetail['transferDetail']))."</p>";					
							}	
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
							
							echo "<p>";
							echo "<b>".$vehicleType.$vehicleName.ucfirst($entranceData['entranceName'])." ".$trnsferType." - </b>";
							if($resultpageQuotation['languageId'] != "0"){
							 	$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');  
								$checkrow = mysqli_num_rows($rs2);
								$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
								if($checkrow > 0){
						        	if(strlen(trim($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						        		echo strip(trim($entranceData['entranceDetail']));
						        	}else{
						        		echo strip(trim($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']])); 
						        	}
						        } else{
									echo strip(trim($entranceData['entranceDetail']));
							    } 
							} else {
								echo strip(trim($entranceData['entranceDetail']));
						    } 
						    echo "</p>";
							//etnrance details here	
						}  
					} 
				}  

				// ferry
				if($itineryDayData['serviceType'] == 'ferry'){  
					$wherent='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc'; 
					$resferry=GetPageRecord('*','quotationFerryMaster',$wherent);  
					if(mysqli_num_rows($resferry) > 0){
						while($ferrylisting=mysqli_fetch_array($resferry)){  
							$rsferr=GetPageRecord('*','ferryPriceMaster','id="'.$ferrylisting['serviceid'].'"');  
							$ferryData=mysqli_fetch_array($rsferr);
							echo "<p>";
							?>
							<img src="<?php echo $fullurl.'images/ferry-default.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;
							<?php
							echo "<strong>".ucfirst(strip($ferryData['name']))." - </strong>".strip($ferryData['information']);
						
							echo "</p>";

						}  
					} 
				}  

				// cruise
				if($itineryDayData['serviceType'] == 'cruise'){  
					$wherent='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc'; 
					$resferry=GetPageRecord('*','quotationCruiseMaster',$wherent);  
					if(mysqli_num_rows($resferry) > 0){
						while($cruiselisting=mysqli_fetch_array($resferry)){  
							$rsferr=GetPageRecord('*','cruiseMaster','id="'.$cruiselisting['serviceId'].'"');  
							$cruiseData=mysqli_fetch_array($rsferr);
							echo "<p>";
							?>
							<img src="<?php echo $fullurl.'images/ferry-default.png'; ?>" width="20" height="20"/>&nbsp;&nbsp;
							<?php
							echo "<strong>".ucfirst(strip($cruiseData['cruiseName']))." - </strong>".strip($cruiseData['otherDetail']);
						
							echo "</p>";

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
						echo "<p>";?>
						<img src="<?php echo $fullurl.'images/additionalimage.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;
						<?php 
						echo  "<b>".strip(ucfirst($additionalQuotData['name'])).' - '."</b>".strip($additionalQuotData['information']);
						echo "</p>";

					}
				}

				if($itineryDayData['serviceType'] == 'mealplan'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$mealplanQuotData=mysqli_fetch_array($b);
						echo "<p>";
						?><img src="<?php echo $fullurl.'images/restaurant.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;<?php
						echo "<b>".strip(ucfirst($mealplanQuotData['mealPlanName']))."</b>"; 
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
						echo "<p>";
						echo "<b>".strip(ucfirst($guideData['name']))."</b>";
						echo "</p>";
					}
				} 
				if($itineryDayData['serviceType'] == 'activity'){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc';   
					$rs22=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){   
						while($activitylisting=mysqli_fetch_array($rs22)){   
							$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id = "'.$activitylisting['otherActivityName'].'" and  status=1');  
							$quotationotherActivityData=mysqli_fetch_array($rs1);  
							
							$transferType = '';
							if($activitylisting['transferType']==1){
								$transferType = 'SIC';
							}elseif($activitylisting['transferType']==2){
								$transferType = 'PVT';
							}elseif($activitylisting['transferType']==3){
								$transferType = 'VIP';
							}elseif($activitylisting['transferType']==4){
								$transferType = 'Ticket Only';
							}

							echo "<p>";
							echo "<b>".ucfirst($quotationotherActivityData['otherActivityName'])." (".$transferType.")</b> - ";
							if($resultpageQuotation['languageId'] != '0'){
							 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"'); 
								$checkrow = mysqli_num_rows($rs2);
								$quotationotherActivityLanData=mysqli_fetch_array($rs2);
								if($checkrow > 0){
						        	if(strlen(trim($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']]))<1){
						        		echo trim(strip($quotationotherActivityData['otherActivityDetail']))."";
						        	}else{
						        		echo trim(strip($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']])).""; 
						        	}
						        } else{
									echo trim(strip($quotationotherActivityData['otherActivityDetail']))."";
							    } 
							} 
						    else{
								echo trim(strip($quotationotherActivityData['otherActivityDetail']))."";
						    }
						    echo "</p>";
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
								$departureTime = "at ".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
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
							echo "<p>";
							?><img src="<?php echo $fullurl.'images/flight-icon.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;<?php
							echo strip(ucfirst($flightData['flightName'])).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass']);
							echo "</p>"; 
							// flight dettail
						 
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
							echo "<p>";
							?>
							<img src="<?php echo $fullurl.'images/train-icon.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;<?php
							echo strip(ucfirst($trainData['trainName'])).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/ '.str_replace('_',' ',$trainQuoteData['trainClass']);
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
	}
	 ?>		
	
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

	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
	?> 
	<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;">AIR FARE SUPPLEMENT</div></th></tr></table>
	<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top">
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
			<tr style="padding: 8px 29px !important;position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="15%" align="left" valign="middle" ><strong>Date</strong></th>
				<th width="18%" align="left" valign="middle" ><strong>Sector</strong></th>
				<th width="15%" valign="middle" align="left" ><strong>Departure<br>Date/Time</strong></th>
				<th width="15%" valign="middle" align="left" ><strong>Arrival<br>Date/Time</strong></th>
				<th width="18%" align="left" valign="middle" ><strong>Class/Baggage</strong></th>
				<th width="13%" align="right" valign="middle" ><strong>Fare</strong></th>
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
						<td align="left" valign="middle"><strong>
						<?php 
						echo date('l, dS F, Y',strtotime($flightQuotData['fromDate']));  
						?></strong></td>
						<td align="left" valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
						<td align="left"><?php if($timeData['departureDate']!=''){ echo date('d-m-Y', strtotime($timeData['departureDate'])).'<br>'.date('H:i:s', strtotime($timeData['departureTime'])); } ?></td> 
						<td align="left"><?php if($timeData['arrivalDate']!=''){ echo date('d-m-Y', strtotime($timeData['arrivalDate'])).'<br>'.date('H:i:s', strtotime($timeData['arrivalTime'])); } ?></td> 
						<td align="left" valign="middle"><?php echo str_replace('_',' ',$flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
						<td align="right" valign="middle"><strong><?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>&nbsp;<?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?>
						</strong></td>
					</tr>
			  <?php 
			} ?>
		  <tr>
		  	<td colspan="5" align="left"><strong>Note:</strong> This is the present airfare and is subject to change and we cannot guarantee the airfare before issuing the flight tickets.</td>
		  </tr>
		</table>
	</td></tr></table>
	<br />
	<?php 
	}  
	

		$_REQUEST['parts'] = "supplementValueAddedServices";
		include('proposal_parts.php');


		$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
		$suppRoomQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isRoomSupplement=1 '); 
		$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and isHotelSupplement=1 '); 

		if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0  ){
			?> 
			<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;">SUPPLEMENT SURVICES</td></tr></table>
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
			<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;">ADDITIONAL EXPERIENCE</div></th></tr></table>
			<table border="0" cellpadding="20" cellspacing="0" width="100%" ><tr><td valign="top"><?php 
				
				$queryId = $resultpageQuotation['queryId'];
				$quotationId= $resultpageQuotation['id'];
				$_REQUEST['parts'] = 'additionalSupplement';
				include('proposal_parts.php');
				?></td></tr></table>
			<?php 
		} 
	// $overviewText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $overviewText));
	// $highlightsText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $highlightsText));
	// $inclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $inclusion));
	// $exclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $exclusion));
	// $tncText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $tncText));
	// $specialText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $specialText));
	?> 
	<br />

	<table border="0" cellpadding="0" cellspacing="0"  width="100%" style="font-size:12px"> 
			<tr> 
				<td style="padding-bottom: 5px !important;"><?php 
				if($overviewText!=''){ ?>
					<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;">TOUR OVERVIEW</div></th></tr></table> 
					<table border="0" cellpadding="20" cellspacing="0" width="100%" >
						<tr>
							<td valign="top" style="font-size: 14px;" ><?php echo html_tidy($overviewText);  ?></td>
						</tr>
					</table>
					<br> 
					<?php 
				}  
				if($inclusion!=''){ ?>
					<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;"><?php echo $inclusionTitle; ?></div></th></tr></table> 
					<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
						<tr>
							<td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy($inclusion);  ?></td>
						</tr>
					</table>
					<br> 
					<?php 
				} 
				if($exclusion!=''){ ?>
					<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;"><?php echo $exclusioinTitle; ?></div></th></tr></table> 
					<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
						<tr>
							<td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy($exclusion);  ?></td>
						</tr>
					</table>
					<br> 
					<?php 
				} 

				if($tncText!=''){ ?>
					<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;"><?php echo $termCTitle; ?></div></th></tr></table> 
					<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
						<tr>
							<td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy($tncText);  ?></td>
						</tr>
					</table>
					<br> 
					<?php 
				} 
				if($specialText!=''){ ?>
					<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;"><?php echo $cancelPTitle; ?></div></th></tr></table> 
					<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
						<tr>
							<td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy($specialText);  ?></td>
						</tr>
					</table>
					<br> 
					<?php 
				} 


				?>

								
					<!--Started Service Upgradation and optional tour -->
					<?php if($serviceupgradationText!=''){ ?> 
						<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" >
							<tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;"><?php echo $serviceUpTitle; ?></div></th></tr>
						</table>
						<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc" style="background: white;">
							<tr><td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy(strip($serviceupgradationText)); ?></td></tr>
						</table>

				<?php }if($optionaltourText!=''){ ?> 
						<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" >
							<tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;"><?php echo $opsTourTitle; ?></div></th></tr>
						</table>
						<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc" style="background: white;">
							<tr><td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy(strip($optionaltourText)); ?></td></tr>
						</table>
					<?php
				} ?>
					
					<!--Ended Service Upgradation and optional tour -->

				<?php


				if($paymentpolicy!=''){ ?>
					<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px!important;padding: 3px 15px;"><?php echo $paymentPTitle; ?></div></th></tr></table> 
					<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
						<tr>
							<td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy($paymentpolicy);  ?></td>
						</tr>
					</table>
					<br> 
					<?php 
				} 
				if($remarks!=''){ ?>
					<table width="100%" border="0" cellpadding="12" cellspacing="0" bordercolor="#ccc" class="borderedTable" ><tr><th  align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><div style="font-size: 18px !important;padding: 3px 15px;"><?php echo $remarksTitle; ?></div></th></tr></table> 
					<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
						<tr>
							<td valign="top" style="font-size: 14px;" class="fitDesc"><?php echo html_tidy($remarks);  ?></td>
						</tr>
					</table>
					<br> 
					<?php 
				}   ?>
				</td>
			</tr>
	</table>
	<?php 

	
		$_REQUEST['parts'] = 'emeragencyContactDetail';
		include('proposal_parts.php');
		
	$selectF= 'footerstatus, footertext';
	$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
    $resultf = mysqli_fetch_assoc($resfooter);
	if($resultf['footerstatus']==1){ ?> 
	<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
	<td align="center"><a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" ><?php if($resultf['footertext']!=''){ echo $resultf['footertext']; }else{ ?> Generated by TravCRM <?php } ?> </a></td></tr></table>
	<?php } ?>

	</td>
	</tr>
</table>
</div>  