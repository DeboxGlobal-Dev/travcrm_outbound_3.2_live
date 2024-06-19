<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- links -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="megniteproposal-sec" style="padding: 0px 0%;">
    <div class="meg-pro-inner-sec" style="">
        <!-- started top sec  -->
        <!-- <div class="m-top-logo" style="text-align: center;">
            <img src="De-Box-Header-v4.jpg" style="margin-top: 20px;">
        </div> -->
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
        <!-- ended top sec  -->

        <!-- subject name sec started-->
        <div class="subject-proposal" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;">
            <h2><?php echo substr($quotationSubject, 0, 100); ?></h2>
        </div>
        <!-- subject name ended -->
        <table class="travle-details-tdate" style="margin: 20px 5px;">
            <div class="mg-name-qid">
                <h3 style="font-weight: 100;width: 200px;font-size: 14px;margin-left: 10px;">Magnite Proposal</h3>
                <h3 style="" class="qid-mp">Query ID : <?php echo makeQueryId($resultpage['id']);  ?></h3>
            </div>
               
                <tr class="trav-dt-ss">
                    <td style="font-weight: 800;" width="400">Tour Start Date | <?php 
							echo date('d - m - Y',strtotime($resultpageQuotation['fromDate'])); 
						?></td>
                    <td style="font-weight: 800;" width="500">Duration | <?php echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; ?></td>
                </tr>
        </table>


        
    <?php  
	// DAY LOOP START
	$day=1;
	$queryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($queryDaysData=mysqli_fetch_array($queryDaysQuery)){  
		$dayDate = date('Y-m-d',strtotime($queryDaysData['srdate']));
		$dayId = $queryDaysData['id']; 
		?> 
        
		<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">DAY <?php echo $day; ?> <?php if($resultpage['dayWise'] == 1){ ?> | <?php echo date('d.m.Y', strtotime($dayDate)); } 	?></div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>



		<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc" style="display: block;position: relative;font-size: 14px;color: #424244;font-weight: 400;font-family: 'Source Sans Pro', sans-serif;"><tr><td><?php 
			if($queryDaysData['title']!=''){ 
				?>
				<!-- <div class="itineraryTitle"> -->
					<strong >
				<?php
				echo html_tidy(strip(urldecode($queryDaysData['title'])));
				?></strong>
				<!-- </div> -->
				<?php
			}
			if($queryDaysData['description']!=''){ 
			?>
			<!-- <div class="itineraryDesc"> -->
				
				<div class="dscmgn" style="margin-right: 20px;"> 
					<?php echo $html = urldecode(strip($queryDaysData['description']));?> 
				</div>
				
				<!-- // $html = str_replace('<p>&nbsp;</p>', '<br />', $html);
				// $html = str_replace('<p>', '<div>', $html);
				// $html = str_replace('</p>', '</div>', $html);
				echo $html = html_tidy($html);
				?> -->
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
							$rs20=GetPageRecord('*','imageGallery',' parentId = "'.$hoteldetail0['id'].'" and galleryType="hotel" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
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
					<!-- <div class="hr_line" style="margin: 40px 0px;">
						<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
					</div> -->
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


						// $qhQuery2time='';
						// hotel check in time
						$qhQuery2time=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and fromDate="'.$dayDate.'" order by id asc');
						$qhData2timeh=mysqli_fetch_array($qhQuery2time);

					?>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service hotel">
						<tbody><tr class="row-service">
						
						<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
             			   <div class="trav-dt-ss-mgpr">
								<div class="time-hours" width="200">

								
									<?php  
										$checkinhhh = date('H:i',strtotime($qhData2timeh['checkin']));
										echo $checkinhhh.'Hrs';  ?> </div>

								<div class="desc-mgpro" width="">
								<?php  echo rtrim($hotelTypeLable,',')." Hotel | "; echo strip($hoteldetail['hotelName']);  ?> <br>

								
								<?php  echo strip($hoteldetail['hotelAddress']);  ?> <br>
								<!-- hotel descriptions pending -->
								<?php  echo strip($hoteldetail['hoteldetail']);  ?> <br>
								<!-- <?php  echo strip($qhData2timeh['remark']);  ?> <br> -->

								</div>
							</div>
						</div>


						
						</tr>
						</tbody>
					</table>
					<!-- <div class="hr_line" style="margin: 40px 0px;">
						<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
					</div> -->
					<?php 
					}
				}
				
				

				// hhdhhhhhhhhhhhhhhhhhhh
				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs12=GetPageRecord('*','quotationTransferMaster','quotationId="'.$itineryDayData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'" ');   
					if(mysqli_num_rows($rs12) > 0){
						while($transferlisting=mysqli_fetch_array($rs12)){
						$rs123=GetPageRecord('transferName,transferDetail,id',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs123);

						$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');  
						$vename=mysqli_fetch_array($rs1aa);

						
						$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferlisting['id'].'" and quotationId="'.$transferlisting['quotationId'].'"');
					  $transferTimelineData=mysqli_fetch_array($c1);

						?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service transfer">
							<tbody><tr class="row-service">
							<td width="30%" align="left" valign="middle"><?php   
								$rs1aa=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'id="'.$transferlisting['vehicleModelId'].'"');
								$vename=mysqli_fetch_array($rs1aa); 
								?>
								
							</td>
							<td width="70%" align="left" valign="middle" >
							   <table width="100%" border="0" cellpadding="5" cellspacing="0" >
								 	<tr>
				
							     	</tr>
									<?php if($transferlisting['transferType']==2){  ?>



									<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
										<div class="trav-dt-ss-mgpr">
											<div class="time-hours" width="200"><?php if(date('H:i',strtotime($transferTimelineData['pickupTime'])) <> '000' ){ echo date('H:i',strtotime($transferTimelineData['pickupTime']))." Hrs"; }  ?></div>
											
											<div class="desc-mgpro" width="800">
											<?php echo ucfirst($transfergdetail['transferName']); ?>
											<br>
											<?php echo stripslashes($transfergdetail['transferDetail']); ?>
											</div>
										</div>
									</div>
	
								  	<?php } ?>
							   </table>								   
							</td>
							</tr>
						
						
							<?php 
							if($transferlisting['transferType']==1){  ?>
						 	<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
										<div class="trav-dt-ss-mgpr">
											<div class="time-hours" width="200"><?php if(date('H:i',strtotime($transferTimelineData['pickupTime'])) <> '0000' ){ echo date('H:i',strtotime($transferTimelineData['pickupTime']))." Hrs"; }  ?></div>
											
											<div class="desc-mgpro" width="800">
											<?php echo ucfirst($transfergdetail['transferName']); ?>
											<br>
											<?php echo stripslashes($transfergdetail['transferDetail']); ?>
											</div>
										</div>
									</div>
						 	<?php } ?>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
						<?php 

					}
				}
				}
				// hhhhhhhhhhhhhhhhhhhhhh
				

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
							
							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
								<div class="trav-dt-ss-mgpr">
									<!-- enrout time pending -->
									<div class="time-hours" width="200">Hrs</div>
									<div class="desc-mgpro" width="">
										<?php echo strip($enrouteData['enrouteName']);  ?> <br>
										<?php echo strip_tags($enrouteData['enrouteDetail']); ?>
									</div>
								</div>
							</div>


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
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
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
							<tbody>
							<tr class="row-service">

								<!-- time show -->
								<?php
								$d = GetPageRecord('*','quotationEntranceTimelineDetails','hotelQuoteId="'.$entrancelisting['id'].'"');
								if(mysqli_num_rows($d)>0){

									 while($timeData = mysqli_fetch_assoc($d)){
										if($timeData['pickupTime']!='' && $timeData['pickupTime']!='00:00:00'){
											$pickupTime = date('H:i',strtotime($timeData['pickupTime']));
										}else{
											$pickupTime = '';
										}
										
										}
									}
									?>
									
							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
								<div class="trav-dt-ss-mgpr">
									<?php 
										if($entrancelisting['transferType']==1){ ?>
									
										<div class="time-hours" width="200"> <?php echo $pickupTime; ?> Hrs</div>

										<div class="desc-mgpro" width="">
											<?php echo strip($entranceData['entranceName']);  ?>
											<br>
											<?php echo strip($entranceData['entranceDetail']); ?> 
											</div>
										<?php }?>


										<?php 
										if($entrancelisting['transferType']==2){ ?>
									
									<div class="time-hours" width="200"> <?php echo $pickupTime; ?> Hrs</div>

										<div class="desc-mgpro" width="">
											<?php echo strip($entranceData['entranceName']);  ?>
											<br>
											<?php echo strip($entranceData['entranceDetail']); ?> 
											</div>
										<?php }?>



								</div>
							</div>	
						</table>
						
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
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
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">

							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
								<div class="trav-dt-ss-mgpr">
								<?php
								
									$where4='quotationId="'.$queryDaysData['quotationId'].'" order by id asc';   
									$c="";
									$c=GetPageRecord('*','quotationActivityTimelineDetails',$where4);
									if(mysqli_num_rows($c)>0){
										$activityTimLData=mysqli_fetch_array($c);
										''.$startTime = date('H:i:s', strtotime($activityTimLData['startTime']));
										 "/";
										$endTime = date('H:i:s', strtotime($activityTimLData['endTime']));
									}
							
									    ?>
									
									<!-- activity time not show check pending-->
								
										<div class="time-hours" width="200"> 
											<?php echo $startTime.'Hrs' ?>
											<!-- <?php echo '12:00 Hrs' ?> -->
										</div>

										<div class="desc-mgpro" width="">
											<?php echo strip($activityData['otherActivityName']);  ?>
											<br>
											<?php echo strip($activityData['otherActivityDetail']); ?> 
										</div>
								</div>
							</div>


							
							</tr>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
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
						
							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
								<div class="trav-dt-ss-mgpr">
									<!-- time pending -->
									<div class="time-hours" width="200">Hrs</div>
									<div class="desc-mgpro" width="">
									<?php echo strip($restlisting['mealPlanName']);  ?><br>
								<!-- detail pending -->
									<?php echo strip($restlisting['']);  ?>

									</div>
								</div>
							</div>

							
							</tr>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
						<?php  
					}
				}




				
				// Guide started
				if($itineryDayData['serviceType'] == 'guide'){  
					$where5='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
					$rs5=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,$where5);  
					if(mysqli_num_rows($rs5) > 0){  
					 	$guideQuotData=mysqli_fetch_array($rs5);  
						$rs52=GetPageRecord('*','tbl_guidesubcatmaster',' id="'.$guideQuotData['guideId'].'" ');  
						$guideData=mysqli_fetch_array($rs52);   
						// code here
						// $rs512=GetPageRecord('*','ferryNameMaster',' id="'.$ferrQuotData['ferryNameId'].'" ');  
						// $ferryNameData=mysqli_fetch_array($rs512);   
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							
							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
							<div class="trav-dt-ss-mgpr">
								<!-- added time pendind -->
								<div class="time-hours" width="200">Hrs</div>
								<div class="desc-mgpro" width="">
									<?php echo strip($guideData['name']);  ?> <br>
									<!-- <?php echo html_tidy($guideData['description']);  ?> -->
								</div>
							</div>
							</div>

							</tr>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
						<?php 

					}
				}
				// Guide ended

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
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							
							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
							<div class="trav-dt-ss-mgpr">
								<!-- added time pendind -->
								<div class="time-hours" width="200"><?php echo strip($ferryData['arrivalTime']).' Hrs';  ?></div>
								<div class="desc-mgpro" width="">
									<?php echo strip($ferryData['name']);  ?> <br>
									<?php echo html_tidy($ferryData['information']);  ?>
								</div>
							</div>
							</div>

							</tr>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'additional'){  
					$where5='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'"  and additionalId in ( select id from extraQuotation where proposalService=1) order by id asc';   
					$rs5=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where5);  
					if(mysqli_num_rows($rs5) > 0){  
					 	$additionalQuotData=mysqli_fetch_array($rs5);  
						$rs51=GetPageRecord('*','extraQuotation',' id="'.$additionalQuotData['additionalId'].'" ');  
						$extraData=mysqli_fetch_array($rs51);
						// echo $extraData['id'];
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
							<tbody><tr class="row-service">
							

							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
								<div class="trav-dt-ss-mgpr">
									<div class="time-hours" width="200"> Hrs</div>
									<div class="desc-mgpro" width="">
										<?php echo strip($extraData['name']);  ?><br>
										<?php echo html_tidy($extraData['otherInfo']);  ?>
									</div>
								</div>
							</div>

							</tr>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
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

						if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '0000'){
							$dptTime = date('H:i',strtotime($trainQuoteData['departureTime']));
						}else{
							$dptTime ='';
						}	
						if(date('H:i',strtotime($trainQuoteData['arrivalTime'])) <> '0000'){
							$avrTime = date('H:i',strtotime($trainQuoteData['arrivalTime']))." Hrs";
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

							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
								<div class="trav-dt-ss-mgpr">
									<div class="time-hours" width="200">
									<?php echo trim($dptTime); ?>Hrs</div>
									<div class="desc-mgpro" width="">
									<?php  echo rtrim($trainTypeLable,',')." Train ";  echo strip($trainData['trainName']);  ?>
									<br>
									<!-- details added  -->
									<!-- <?php echo strip($trainData['detail']);  ?> -->
									</div>
								</div>
							</div>
							</tr>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div> -->
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

						$jfrom = getDestination($flightQuoteData['departureFrom']);
						$jto= getDestination($flightQuoteData['arrivalTo']); 

						if(date('H:i',strtotime($flightQuoteData['departureTime'])) <> '0000'){
							$dptTime = "@".date('H:i',strtotime($flightQuoteData['departureTime']));
						}else{
							$dptTime ='';
						}	
						if(date('H:i',strtotime($flightQuoteData['arrivalTime'])) <> '0000'){
							$avrTime = date('H:i',strtotime($flightQuoteData['arrivalTime']))." Hrs";
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

						if($timeData['departureTime']!='' && $timeData['departureTime']!='00:00'){
						$departureTime = date('H:i', strtotime($timeData['departureTime']));
						}else{
						$departureTime = '';
						}

						if($timeData['arrivalDate']!='' && $timeData['arrivalDate']!='00-00-00'){
						$arrivalDate = date('d-m-Y', strtotime($timeData['arrivalDate']));
						}else{
						$arrivalDate = '';
						}

						if($timeData['arrivalTime']!='' && $timeData['arrivalTime']!='00:00'){
						$arrivalTime = date('H:i', strtotime($timeData['arrivalTime']));
						}else{
						$arrivalTime = '';
						}


							date('d-m-Y', strtotime($timeData['arrivalDate'])).'<br>'.date('H:i', strtotime($timeData['arrivalTime']));
						// code here
						?> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service flight">
							<tbody><tr class="row-service">
							

							<div class="servicetimedesc-mgpr" style="padding: 0px 30px">
								<div class="trav-dt-ss-mgpr">
									<div class="time-hours" width="200">

										<?php echo $departureTime.' Hrs'; ?>
									</div>
									<div class="desc-mgpro" width="">
									<?php  echo rtrim($flightTypeLable,',')." Flight ";  echo strip($flightData['flightName']);  ?> <br>
									<!-- details added  -->
									<!-- <?php echo strip($flightData['detail']);  ?> -->

									</div>
								</div>
							</div>


							</tr>
							</tbody>
						</table>
						<!-- <div class="hr_line" style="margin: 40px 0px;">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="760" />
						</div> -->
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



        <!-- inclusion exclusion term and cond. cancellation sec started -->
        <?php  if($inclusion!=''){ ?> 
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">INCLUSIONS</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($inclusion)); ?></td></tr></table>
<?php } if($exclusion!=''){ ?> 
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">EXCLUSIONS</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($exclusion)); ?></td></tr></table>
<?php } if($tncText!=''){ ?> 
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">TERMS & CONDITIONS</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($tncText)); ?></td></tr></table>
<?php } if($specialText!=''){ ?>  
	<table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">CANCELLATION POLICIES</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>

	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($specialText)); ?></td></tr></table>
<?php } if($paymentpolicy!=''){ ?>  
	<!-- payments policy started-->
	<!-- <table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">PAYMENT POLICY</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>

	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($paymentpolicy)); ?></td></tr></table> -->
<?php } if($remarks!=''){ ?>  
	<!-- Remarks started-->
	<!-- <table width="50%" border="1" cellpadding="12" cellspacing="0" bordercolor="#ccc" ><tr><td align="left" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">REMARKS</div><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 46px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></td></tr></table>

	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc"><tr><td><?php echo html_tidy(strip($remarks)); ?></td></tr></table> -->
<?php } ?>

        <!-- inclusion exclusion term and cond. cancellation sec ended -->



        <div class="incexctermcan" >
            <h2 class="incexctermcanh23" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">
                CONTACT INFORMATION
            </h2>
            
        </div>
        <div class="end-of-doc-sec">
            <table class="vaservices-details-tdate" >
              
                <tr class="trav-dt-ss2" style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;position: relative;"><div style="font-size: 18px!important;">
                    <th width="20" style="width: 90px;">Contact Person</th>
                    <th width="20">Mobile Number</th>
                    <th width="20">Email Id</th>
                    <th width="20">Available On</th>
                    
                </tr>

				<?php
					$rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
					while($emData = mysqli_fetch_assoc($rsem)){
					
					?>
                <tr style="text-align: center;height: 40px;">
                    <td class="cnt-pro-m"><?php echo $emData['contactPerson']; ?></td>
                    <td class="cnt-pro-m"><?php echo $emData['phone']; ?></td>
                    <td class="cnt-pro-m"><?php echo $emData['email']; ?></td>
                    <td class="cnt-pro-m"><?php echo $emData['availableOn']; ?></td>
                    
                </tr>
				<?php }?>
                
                
            </table>
        </div>


        </div>
    </section>
     
</body>
</html>