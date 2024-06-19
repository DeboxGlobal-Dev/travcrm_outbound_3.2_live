<div class="main-container" style="width: 820px; display: block; margin: 0 auto; position: relative; background-color: #ffffff;">
   	<style type="text/css"> 
		@media print{
		    .main-container,body{
		        background-color: #ffffff !important;
		        margin-top: -30px!important;
		    }
		    div,ul,li,body,button{
				margin: 0;
			    padding: 0;
			    font-size: 14px!important;
			    border: 0;
			    vertical-align: baseline;
			    font-family: 'Roboto', sans-serif;
			}
			.firstpage .docTitle{
				padding: 15px 30px 5px 30px;
			}
			.firstpage .docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid transparent;
			    border-bottom: 53px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    border-right: 40px solid #fff0;
			    border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			}
		}
		div,ul,li,body,button{
			margin: 0;
		    padding: 0;
		    font-size: 14px!important;
		    border: 0;
		    vertical-align: baseline;
		    font-family: 'Roboto', sans-serif;
		}
     	@page {
            margin: 0;
            margin-bottom: 80px;
            margin-top: 50px;
        }
        body{
			color: #3c3a3a;
			font-size: 14px!important;
			font-weight: 400;
			background-color: #cadbec;
			font-family: 'Source Sans Pro', sans-serif;
        }
	   	footer {
            position: fixed; 
            bottom: -80px; 
            left: 0cm; 
			/*background-color: #ff0000;*/
            right: 0cm; 
            height: 80px; 
        }   
        /*end teseting*/
	    
		.main-container{
			width: 820px;
			display: block; 
			margin: 0 auto;
			position: relative; 
			/*border: 0px solid #ffffff;*/
			background-color: #ffffff;
		} 

		.blank_line{
			margin: 5px 0;
			height: 0;
			width: 0;
		}
		.hr_line{
			margin: 30px 0px; 
		} 
		ul {
			list-style: none;
			color: #424244;
			list-style-position: outside;
			padding: 0;
    		margin: 0;
		}
		ul li{
		    margin-bottom: 10px;
		}
		
	    .table-service{
			page-break-inside: avoid;
			page-break-after: auto;
			page-break-before: auto;
	    }
	    .row-service{
	    	page-break-inside: avoid;
	    	page-break-after: auto;
	    	page-break-before: auto;
	    }
	    .row-titleDesc{ 
	    	page-break-inside: auto;
	    	page-break-after: auto;
	    	page-break-before: auto;
	    }
	    .dayTitle{
		    line-height: 22px;
		    font-size: 18px!important;
		    padding: 8px;
		    margin-bottom: 10px;
		    text-align: left;
		    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
	    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    /*color: white;*/
		    /*background-color: #233a49;*/

	    }
	    .serviceTitle{
	      	font-size: 18px!important;
		    line-height: 20px;
		    color: #233a49;
		    font-weight: 700;
	    }
	    .subHeading{
	      	font-size: 15px;
		    line-height: 20px;
		    color: #233a49;
		    font-weight: 700;
	    }
	    .serviceDesc{
	    	text-align: justify;
	    	page-break-inside: auto;
	    	font-size: 14px;
		    padding-bottom: 5px;
		    line-height: 18px;
	    }
	    table{
	    	border-collapse: collapse;
	    }
	    table.borderedTable{
	    	width: 100%;
	    }
	    table.borderedTable th{
	    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
	    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;

	    	/*color: #ffffff;*/
	    	/*background-color: #233a49;*/
	    	text-align: left;
	    	padding: 7px;
	    }
	    .calcostsheet{
	    	display:none;
	    	visibility: hidden;
	    	height: 0;
	    	width: 0;
	    	position: fixed;
	    	left: 0;
	    	top: 0;
	    }
	    .docTitle{
	    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
	    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    /*color: #fff;*/
			/*background-color: #233a49;*/
		    padding: 4px 29px;
		    font-weight: 500;
		    font-size: 18px!important;
		    position: relative;
		    display: inline-block;
		    height: 33px;
		    line-height: 30px;
		}
		.docTitleArrow{
		    position: absolute;
		    right: -33px;
		    top: 0px;
		    height: 0;
		    width: 0;
		    border-left: 0px solid transparent;
		    border-bottom: 41px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    border-right: 33px solid #fff0;
		    border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		}
		.proposalHeader{
			/*margin-top: -50px;*/
			padding: 20px 0px 15px 0px;
	    	border-collapse: separate;
			background-color: #ffffff;
		}
		.proposalHeader img{
			margin-right: 30px;
		}
		/*docBanner*/
		.docBanner{
			position: relative;
		}
		.bannerText{
		    position: absolute;
		    top: 30px;
		    left: 30px;
		    right: 30px;
		    text-align: left;
		    display: block; 
		}
		.bannerText1 {
		    position: absolute;
		    bottom: 15px;
		    left: 30px;
		    right: 30px;
		    text-align: center;
		    display: block;
		    background-color: #233a49cc;
		    padding: 5px;
		}
		.bannerText strong, .bannerText1 strong{
			font-weight: 600;
		}
		.colorSize1{
		    color: #fff;
		    font-size: 27px;
		}
		.colorSize2{
		    font-size: 16px;
		}
		.colorSize3 strong{
			font-size: 18px;
			padding: 0px 5px;
		}
		.text1{
		    font-weight: 500;
		    display: block;
		}
		.text2{
			font-weight: 600;
			display: block;
		}
		.overviewBox{
			padding: 15px 30px 30px 30px;
			padding-bottom: 10px;
			display: block;
			page-break-after: always;
		}
		.overviewBox .serviceTitle{
			padding-bottom: 10px; 
			display: block;
			color: #424244;
		}
		.overviewBox .serviceDesc{
			padding-bottom: 10px;
		    font-size: 14px;
			color: #424244;
			font-weight: 400;
			font-family: 'Source Sans Pro', sans-serif;
		}
		.dayItineraryInfo{
			padding: 30px;
			padding-bottom: 10px;
		    /*background-color: #ccc;*/
		    display: block;
		    position: relative;
		    font-size: 14px;
			color: #424244;
			font-weight: 400;
		    font-family: 'Source Sans Pro', sans-serif;
		}
		.itineraryTitle{
			text-align: justify;
		    page-break-inside: auto;
		    padding-bottom: 20px;
		}
		.itineraryDesc{
			text-align: justify;
		    page-break-inside: auto;
		    padding-bottom: 20px;
		}
	    .text-center{
	    	text-align: center!important;
	    }
	    .valignBottom{

	    }
	    .pd30{
	    	padding: 30px;
	    }
	    .w60{
	    	width: 60%;
	    }
		.imgbox{
			width: 200px;
			height: 130px;
			border-radius: 10px;
			overflow: hidden;
		    border: 1px solid #ffffff;
		    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
		}
		.imgbox img{ 
			object-fit: cover;
		}
	</style>
	<table class="firstpage proposalHeader" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>	
			<td align="center" valign="middle">
				<?php
				// proposal header image ===========
				$rs03='';
				$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="4" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
				$resListing3=mysqli_fetch_array($rs03);
				$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
			    if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?>
				<img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="90%" >
				<?php
			    }
				?>
			</td>
		</tr>
	</table>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center" valign="top">
				<div class="docBanner" style="position: relative;"><?php
					$imagepath = 'upload/'.$resultpageQuotation['propIMGNum4'];
					if($resultpageQuotation['propIMGNum4']!='' && file_exists($imagepath)==true){ ?>
						<img align="center" src="<?php echo $fullurl.'PreviewFiles/'.str_replace(' ','%20',$imagepath); ?>" alt="" width="100%" >
						<?php
					}else{
						$rsb03='';
						$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="4" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" order by id desc) order by id desc');
						$resListingb3=mysqli_fetch_array($rsb03);
						$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
				        if($resListingb3['fileId']!='' && file_exists('../'.$proposalPhotob3)==true){ ?>
							<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>" width="100%"  >
							<?php
				        }
					}
					?> 
					<div class="bannerText1 colorSize1">
						<span class="text1"><?php echo ($resultpageQuotation['night']+1).' DAYS'; ?></span>
						<span class="text2"><?php echo strip($quotationSubject); ?></span> 
					</div>
				</div>
			</td>
		</tr>
	</table>
	<br>
	<table align="center" border="0" cellpadding="0" cellspacing="0" style=" width:820px; background-color: #233a49;" >
	    <tr>
	        <td align="center">
	<div style="color: #fff; background-color: #233a49;font-size: 16px !important;font-weight: 500; font-weight:600; text-align: center; display: block; width:820px; height: 70px;">
	<br>
    <span style="background-color: #233a49;"><?php echo ($resultpageQuotation['night']+1).' DAYS'; ?></span><br>
						<span style="background-color: #233a49;"><?php echo strip($quotationSubject); ?></span> 
						<br>
		</td>			</div>
	 </tr>
	</table>
	    <br>
	<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; width:820px;" >
		<tr>
			<td align="center">
				<div class="docBanner" style="background-color: #f5f5f5;height: 210px !important;">
					<div style="padding: 30px;background-color: #f5f5f5;">
						<table width="100%" border="0" cellpadding="10" cellspacing="0" >
						<tr>
						<td>DESTINATION COVERED<br><strong><?php 
							$locationQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
								while($locationCoverD=mysqli_fetch_array($locationQuery)){
								$locationCovered.= stripslashes(getDestination($locationCoverD['cityId'])).', ';
							}
							echo rtrim($locationCovered,', ');
							?></strong>
						</td>
						<td>DURATION<br>
							<strong><?php 
								echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; 
							?></strong>
						</td>
						<td align="right">TRAVELLERS<br>
							<strong><?php echo ($resultpageQuotation['adult']+$resultpageQuotation['child']); ?> Adults</strong>
						</td>
						</tr> 
						</table>
						<br />
						<br />
						<table width="100%" border="0" cellpadding="10" cellspacing="0" class="colorSize3" >
						<tr>
							<td align="center" colspan="4" valign="middle" ><?php  
								$rootMapQuery=GetPageRecord('cityId','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
								$numRoots = mysqli_num_rows($rootMapQuery); 
								$cnt = 1; 
								$cityId = 0;
								while($rootMapData=mysqli_fetch_array($rootMapQuery)){ 
									if($rootMapData['cityId'] != $cityId ){
										?><strong><?php echo getDestination($rootMapData['cityId']); ?></strong>
							          <?php if($numRoots > $cnt){ ?>
							          <img src="<?php echo $fullurl; ?>images/location-pin.png" height="30" width="30" />
							          <?php } 
										$cityId = $rootMapData['cityId'];
										$cnt++;
									}
								}
							?></td>
						</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<?php if(strlen($overviewText)!=''){ ?>
		<br>
	<div class="serviceTitle docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Tour Overview<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
    <div class="overviewBox">
    	
		<div class="serviceDesc"><?php  
				$overviewText = str_replace('<p>&nbsp;</p>', '', $overviewText);
				$overviewText = str_replace('<p>', '<span>', $overviewText);
				$overviewText = str_replace('</p>', '</span>', $overviewText);
				echo html_tidy(substr($overviewText, 0 ,840));  
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
		<br>
		<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Day <?php echo $day; ?> - <?php echo getDestination($queryDaysData['cityId']); $destn = getDestination($queryDaysData['cityId']); ?><?php if($resultpage['dayWise'] == 1){ ?> | <?php echo date('l d-m-Y', strtotime($dayDate)); } 	?><span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span>
		</div>
		<div class="dayItineraryInfo"><?php 
			if($queryDaysData['title']!=''){ 
				?>
				<div class="itineraryTitle">
					<?php
				echo html_tidy(strip(urldecode($queryDaysData['title'])));
				?>
				</div>
				<?php
			}
			if($queryDaysData['description']!=''){ 
			?>
			<div class="itineraryDesc">
				<?php
				$html = urldecode(strip($queryDaysData['description']));
				$html = str_replace('<p>&nbsp;</p>', '<br />', $html);
				$html = str_replace('<p>', '<div>', $html);
				$html = str_replace('</p>', '</div>', $html);
				echo $html = html_tidy($html);
				?>
				</div>
				<br />
				<br />
			<?php
			}
			// SERVICE LOOP START
			$itiQuery=' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){

				if($itineryDayData['serviceType'] == 'hotel' ){
					$where1='quotationId="'.$queryDaysData['quotationId'].'" and supplementHotelStatus!=1 and id="'.$itineryDayData['serviceId'].'"';   
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
				            $rs2=GetPageRecord('*','imageGallery',' parentId = "'.$hoteldetail['id'].'" and galleryType="hotel" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
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
					<br>
					<div class="hr_line">
						<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
					</div>
					<br>
					<?php 
					}
				}
				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs12=GetPageRecord('*','quotationTransferMaster','quotationId="'.$queryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'" ');   
					if(mysqli_num_rows($rs12) > 0){
						$transferlisting=mysqli_fetch_array($rs12); 
						$rs123=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
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
				            		$tptimgPath = 'packageimages/'.$vename['image'];
				            	if(file_exists('../'.$tptimgPath)==true){
				            		echo '<img src="'.$fullurl.str_replace(' ', '%20',$tptimgPath).'" width="200" height="130">';  
				            	}else{
				            	?>
								<img src="<?php echo $fullurl; ?>images/transferthumbpackage.png" width="200" height="130" />
								<?php
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
								  	<tr>
									 	<td align="left" width="15%" ><strong class="subHeading">Type</strong></td>
									 	<td align="left" width="20%" ><strong class="subHeading">VehicleName</strong></td>
									 	<td align="left" width="25%" ><strong class="subHeading">VehicleType</strong></td> 
								  	</tr>
								  	<tr>
									 	<td align="left" width="15%" >Private</td>
									 	<td align="left" width="20%" ><?php echo  $vename['model']; ?> </td>
									 	<td align="left" width="25%" ><?php  echo getVehicleTypeName($vename['carType']);?></td> 
								  	</tr> 
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
							 	  	 	<th valign="middle" bgcolor="#233a49"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight Name';}if($transferTimelineData['mode']=='train'){ echo 'Train Name';} ?></th> 
							 	  	 	<th valign="center" bgcolor="#233a49"><?php if($transferTimelineData['mode']=='flight'){ echo 'Flight No';}if($transferTimelineData['mode']=='train'){ echo 'Train No';} ?></th>
								 	  	<?php if($transferTimelineData['mode']=='flight'){?>
								 	  	<th valign="center" bgcolor="#233a49">Airport Name</th>
								 	     <?php } ?>
								 	    <th valign="center" bgcolor="#233a49">Arrival From</th> 
								 	  	<th valign="center" bgcolor="#233a49">Arrival Time</th>
								 	  	<th valign="center" bgcolor="#233a49">PickUp Time</th>
								 	  	<th valign="center" bgcolor="#233a49">Drop Time</th>
								 	</tr>
								 	<tr>
							 	  	 	<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightName']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainName']; } ?></td>
							 	  	 	<td><?php if($transferTimelineData['mode']=='flight'){ echo $transferTimelineData['flightNumber']; }if($transferTimelineData['mode']=='train'){ echo $transferTimelineData['trainNumber']; } ?></td>
		            					<?php if($transferTimelineData['mode']=='flight'){ ?>
								 	  	<td><?php echo $transferTimelineData['airportName']; ?></td>
		          						<?php } ?> 
		           						<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
								 	  	<td><?php if(date('Hi',strtotime($transferTimelineData['arrivalTime'])) <> '0530' ){ echo date('Hi',strtotime($transferTimelineData['arrivalTime']))." Hrs"; } ?></td>
									 	<td><?php if(date('Hi',strtotime($transferTimelineData['dropTime'])) <> '0530' ){ echo date('Hi',strtotime($transferTimelineData['dropTime']))." Hrs"; }  ?></td> 
								 	  	<td><?php if(date('Hi',strtotime($transferTimelineData['pickupTime'])) <> '0530' ){ echo date('Hi',strtotime($transferTimelineData['pickupTime']))." Hrs"; } ?></td>
								 	</tr>
								 	<?php if($transferTimelineData['pickupAddress']!=''){?>
								 	<tr>
								 	  	<td colspan="6"><strong>PickUp Address:</strong><br><?php echo $transferTimelineData['pickupAddress']; ?></td>
								 	</tr>
								 	<?php } 
								 	if($transferTimelineData['dropAddress']!=''){ ?>
								 	  <tr>
								 	  	<td colspan="6"><strong>Drop Address:</strong><br><?php echo $transferTimelineData['dropAddress']; ?></td>
								 	  </tr>
								 	<?php } ?>
								 	</table>
								</td>
							</tr>
							<?php } ?>
							<?php 
							if(strlen($transfergdetail['transferDetail']) > 0){  ?>
						 	<tr>
						 		<td colspan="2" align="left"><?php echo clean($transfergdetail['transferDetail']); ?></td>
						 	</tr>
						 	<?php } ?>
							</tbody>
						</table>
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
						<?php 

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
				            $rs3=GetPageRecord('*','imageGallery',' parentId = "'.$enrouteData['id'].'" and galleryType="enroute" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
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
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
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
				            $rs4=GetPageRecord('*','imageGallery',' parentId = "'.$entranceData['id'].'" and galleryType="entrance" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
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
											<td ><strong class="serviceTitle"><?php echo strip($entranceData['entranceName']);  ?></strong></td>
										</tr>
										<tr>
											<td ><div class="serviceDesc"><?php 
												if($resultpageQuotation['languageId'] != "0"){
													$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');
													$checkrow = mysqli_num_rows($rs2);
													$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
													if($checkrow > 0){
														echo strip($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']]);
													} else{
														echo "";
													}
												}
												else{
													echo strip($entranceData['entranceDetail']);
												}
											 ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
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
							<td width="30%" align="left" valign="middle"><div class="imgbox"><?php 
					            $rs5='';
					            $rs5=GetPageRecord('*','imageGallery',' parentId = "'.$activityData['id'].'" and galleryType="activity" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="380x246" ) ');
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
											<td ><div class="serviceDesc"><?php 
											 	// if($resultpageQuotation['languageId'] != "0"){
												 // 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"');  
												 // 	$checkrow = mysqli_num_rows($rs2);
													// $activityLanData=mysqli_fetch_array($rs2);
													// if($checkrow > 0){
													// 	echo strip_tags($activityLanData['lang_0'.$resultpageQuotation['languageId']]); 
											  //       } else{
													// 	echo ""; 
											  //   	} 
											  // 	} else {
													echo strip_tags($activityData['otherActivityDetail']); 
										    	//} ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
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
									echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            	}
				            }else{ 
								echo '<img src="'.$fullurl.'images/hotelthumbpackage.png" width="200" height="130">'; 
				            } 
				          	?></div></td>
							<td width="70%" align="left" valign="middle" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0" >
									<tbody>
										<tr><td><strong>Restaurant</strong></td>
										<td><strong>Meal Type</strong></td>
										</tr>
										<tr>
											
											<td ><strong class="serviceTitle"><?php echo strip($restaurantData['mealPlanName']);  ?></strong></td>
											<td><strong><?php echo $restaurantMeal['name']; ?></strong></td>
										</tr>
										
									</tbody>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
						<?php  
					}
				}


				if($itineryDayData['serviceType'] == 'additional'){  
					$where5='quotationId="'.$queryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id asc';   
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
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
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
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
						<?php 

					}
				}

				if($itineryDayData['serviceType'] == 'flight' ){ 
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
									<tr>
										<td colspan="4" ><strong class="serviceTitle"><?php  echo rtrim($flightTypeLable,',')." Flight ";  echo strip($flightData['flightName']);  ?></strong></td>
									</tr>
									<tr> 
										<td width="20%"><strong>FlightNumber</strong></td> 
										<td width="20%"><strong>FlightClass</strong></td> 
										<td width="30%"><strong>Departure-Arrival</strong></td> 
										<td width="30%"><strong>Departure-Arrival Time</strong></td> 
									</tr> 
									<tr> 
										<td width="20%"><?php echo strip($flightQuoteData['flightNumber']); ?></td> 
										<td width="20%"><?php echo strip($flightQuoteData['flightClass']); ?></td> 
										<td width="30%"><?php echo ucfirst($jfrom).'-'.ucfirst($jto); ?></td> 
										<td width="30%"><?php echo trim($dptTime).'-'.trim($avrTime); ?></td> 
									</tr>
								</table>
							</td>
							</tr>
							</tbody>
						</table>
						<br>
						<div class="hr_line">
							<img src="<?php echo $fullurl; ?>images/seperator.png" width="100%" />
						</div>
						<br>
						<?php 
						
					}
				}
				// END OF SERVICES
			}
			?>
		</div>

		<?php
	$n++; 
	$day++;
	}
	?>
	<br />	
	<br />	
	<div class="dayItineraryInfo ">
		<img src="<?php echo $fullurl; ?>images/end-of-tour.png" width="100%" />
	</div>
	<br /> 
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">HOTEL PROPOSED<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
	<br />
	<div class="table-service pd30" >
		<!-- <div class="serviceTitle">Hotels Proposed</div> -->
		<table width="100%" border="1" cellpadding="8" cellspacing="0" borderColor="#ccc" class="borderedTable table-service">
		 	<tr style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="20%" align="left" valign="middle" ><strong>Dates</strong></th>
				<th width="12%" align="left" valign="middle" ><strong>City</strong></th>
				<th width="27%" align="left" valign="middle" ><strong>Hotel</strong></th>
				<th width="16%" align="left" valign="middle" ><strong>Room Type</strong></th>
	 			<th width="25%" align="left" valign="middle" ><strong>Remarks</strong></th>
			</tr>
			<?php 
			$totalHotel = 0;
			$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
			while($sorting3=mysqli_fetch_array($b1)){  
			
				$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$sorting3['serviceId'].'" and supplementHotelStatus!=1');  
				if(mysqli_num_rows($b) > 0){
					$hotelQuotData=mysqli_fetch_array($b);
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
			} ?>
		</table>
		<!-- Total Tour Cost and per person basis costs details -->
	</div>
	<br>
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">QUOTATION<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
	
		<!-- <div class="serviceTitle">QUOTATION</div> -->
		<?php 
		$queryId = $resultpageQuotation['queryId'];
		$quotationId= $resultpageQuotation['id'];
		$_REQUEST['parts'] = 'costingDetail';
		include('proposal_parts.php');
	 	?>
	<?php 
	if($resultpageQuotation['flightCostType'] == 1){  ?>
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">AIR FARE SUPPLEMENT<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>  
	<div class="table-service pd30" > 
		<!-- <div class="serviceTitle">Air Fare Supplement</div> -->
		<table width="100%" border="1" cellpadding="8" cellspacing="0" class="borderedTable table-service">
			<tr style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="12%" valign="middle" bgcolor="#233a49"><strong>Date</strong></th>
				<th width="19%" valign="middle" bgcolor="#233a49"><strong>Sector</strong></th>
				<th width="30%" valign="middle" bgcolor="#233a49"><strong>Flight/Timings</strong></th>
				<th width="28%" valign="middle" bgcolor="#233a49"><strong>Class/Baggage</strong></th>
				<th width="11%" align="right" valign="middle" bgcolor="#233a49"><strong>Fare</strong></th>
			</tr>
			<?php 
			$totalFlight= 0;
			$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
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
	</div>
	<br>
	<?php 
	}  
 
	$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplementHotelStatus=1 ');
	$checkSuppTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=1 ');

	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0 || mysqli_num_rows($checkSuppTQuery) > 0){
		?>
		<div class="docTitle w60" style="padding: 7px 29px !important; height:30px; font-weight: 500; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">SUPPLEMENT SERVICES<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
		<?php
	}
	// INCLUDE SUPPLEMENT HOTEL AND RATE HERE
	$suppRoomQuery=$checkSuppHQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplementHotelStatus=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0){ ?>
		<div class="table-service pd30" > 
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'hotelSupplement';
			include('proposal_parts.php');
		
			?>
		</div>
		<br>
		<?php 
	}  
	// INCLUDE SUPPLEMENT HOTEL AND RATE HERE
	$checkSuppTQuery="";
	$checkSuppTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=1 ');
	if(mysqli_num_rows($checkSuppTQuery) > 0){ ?>
	<br>
		<div class="table-service pd30" > 
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'transferSupplement';
			include('proposal_parts.php');
			?>
		</div>
		<br>
		<?php 
	}  

	// additional requirment 
	$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.($quotationId).'" group by serviceType order by id asc');
	if( mysqli_num_rows($c12) > 0){ ?>
		<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Additional Experiences (Suppliment)<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
		<div class="table-service pd30" > 
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'additionalSupplement';
			include('proposal_parts.php');
			?>
		</div> 
		<br>
		<?php 
	} 

	?> 

<?php  if($overviewText!=''){ ?> 
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Tour Overview<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($overviewText)); ?></div>
<?php } if($inclusion!=''){ ?> 
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Inclusions<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($inclusion)); ?></div>
<?php } if($exclusion!=''){ ?> 
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Exclusions<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($exclusion)); ?></div>
<?php } if($tncText!=''){ ?> 
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; height:30px; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Terms & Conditions<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($tncText)); ?></div>
<?php } if($specialText!=''){ ?> 
	<div class="docTitle w60" style="padding: 7px 29px !important; font-weight: 500; font-weight: 500; height:30px; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Cancellation Policies<span class="docTitleArrow" style="border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-bottom: 44px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;border-left: 0px solid transparent;border-right: 33px solid #fff0;"></span></div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($specialText)); ?></div>
<?php } ?>
	<br />	
	<br />	
	<?php 
	$selectF= 'footerstatus, footertext';
	$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
    $resultf = mysqli_fetch_assoc($resfooter);
	if($resultf['footerstatus']==1){ ?> 
	<div class="dayItineraryInfo ">
		<a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" >
			<img src="<?php echo $fullurl; ?>images/generated-by-TRAVCRM.png" width="100%" />
		</a>
	</div>
	<?php } ?>

	 
</div>