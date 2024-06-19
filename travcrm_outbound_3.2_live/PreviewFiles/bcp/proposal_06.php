<div class="main-container" style="width: 820px; display: block; margin: 0 auto; position: relative; background-color: #ffffff;">
	<style type="text/css"> 
		@media print{
		    .main-container,body{
		        background-color: #ffffff !important;
		        margin-top: -30px!important;
		    }
		    div,body,button {
				margin: 0;
			    padding: 0;
			    border: 0;
			    font: inherit;
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
			    border-left: 0px solid #233a4900;
			    border-bottom: 53px solid #233a49;
			    border-right: 40px solid #fff0;
			    border-top: 0px solid #233a49;
			}
		}
     	@page {
            margin: 0;
            margin-bottom: 80px;
            margin-top: 50px;
        }
        body{
			font-size: 14px;
			color: #3c3a3a;
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
			margin: 40px 0px; 
		} 
		div,ul,li,body,button{
			margin: 0;
		    padding: 0;
		    border: 0;
		    font-size: 14px!important;
		    vertical-align: baseline;
		    font-family: 'Roboto', sans-serif;
		}
		ul {
			/*list-style: none;*/
			color: #424244;
			list-style-position: outside;
			padding-left: 10px;
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
		    font-size: 25px!important;
		    padding: 5px;
		    padding-bottom: 8px;
		    margin-bottom: 10px;
		    text-align: center;
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
	    	padding: 7px;
	    	/*text-align: left;*/
	    	font-weight: 400;
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
		    padding: 8px 29px !important; font-size: 18px!important; position: relative;
		    font-size: 18px!important;
			  position: relative;
		  	 height: 30px;
		    line-height: 30px; 
		}
		.docTitleArrow{
		    position: absolute;
		    right: -33px;
		    top: 0px;
		    height: 0;
		    width: 0;
		    border-left: 0px solid #233a4900;
		    border-bottom: 41px solid #233a49;
		    border-right: 33px solid #fff0;
		    border-top: 0px solid #233a49;
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
			font-size: 22px;
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
			padding: 30px;
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
		    font-size: 16px;
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
		    font-size: 16px;
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
	<?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="6" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
	if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?><table class="firstpage proposalHeader"  width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td align="center" valign="top">
						<img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="90%"  >
					</td>
				</tr>
			</tbody>
		</table><?php
	}
	?><table  width="100%" border="0" cellpadding="15" cellspacing="0" >
	<tr>
	<td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" ><tr><td align="center"><?php
				$imagepath = 'upload/'.$resultpageQuotation['image'];
				if($resultpageQuotation['image']!='' && file_exists('../'.$imagepath)==true){ ?>
					<img align="center" src="<?php echo $fullurl.'PreviewFiles/'.str_replace(' ','%20',$imagepath); ?>" alt="" width="100%" >
					<?php
				}else{
					$rsb03='';
					$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="6" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x750" order by id desc) order by id desc');
					$resListingb3=mysqli_fetch_array($rsb03);
					$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
			        if($resListingb3['fileId']!='' && file_exists('../'.$proposalPhotob3)==true){ ?>
						<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>" width="100%"  >
						<?php
			        }
				}
				?> 

				</td>
			</tr> 
		</table>
		<table border="0" cellpadding="5" cellspacing="0" style="background-color: #fff; width:790px;">
		<tr>
			<td width="30%" align="center"><h3>Vivid Proposal</h3></td>
				
			<td align="right" style="font-size: 15px; width: 48%;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Query Id:</strong></td>
			<td style="font-size: 15px;" align="left"><?php echo makeQueryId($resultpage['id']);  ?></td>
			</tr>
			<tr>
				<td align="center"  colspan="4">
					<strong style="line-height:40px;font-size: 35px;color:#133f6d;text-align: center;">&nbsp;<?php echo substr($quotationSubject, 0, 100); ?>&nbsp;</strong>
				</td>
			</tr>
			<tr><td align="center"  colspan="4">
				<strong style="font-size: 20px;background-color: #ea7031;color: #fff;">&nbsp;<?php 
				echo $resultpageQuotation['night'].' Nights / '.($resultpageQuotation['night']+1).' Days'; 
				?>&nbsp;&nbsp;&nbsp;</strong>
				</td>
			</tr>
			<tr>
				<td align="center"  colspan="4" valign="middle" ><strong style="font-size: 20px;background-color: #ea7031;color: #fff;">&nbsp;&nbsp;&nbsp;<?php  
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
	<div class="docTitle" style="padding: 7px 29px; height:30px; line-height:30px; font-weight:500; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; ">Tour&nbsp;Highlights</div>
	<table width="100%" cellpadding="20" cellspacing="0" border="0" bordercolor="#ccc">
		<tr>
			<td>
				<?php
				echo $highlightsText = clean($highlightsText);
			?></td>
		</tr>
	</table><?php 
	} ?><br>
 
	<!-- start dynamic hotel star -->
	<div class="docTitle" style="padding: 7px 29px; height:30px; font-weight:500; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; age-break-before: never;page-break-inside: avoid;">Proposal <?php if( $resultpage['leadPaxName']!=''){ echo "for ".$resultpage['leadPaxName']; }  ?> At a Glance  </div>
	<table  width="100%" border="0" cellpadding="15" cellspacing="0" ><tr><td>
	<?php
	if($resultpageQuotation['quotationType']==2){
		?>
		<!-- new hotel glance code -->
		<table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#ccc" class="borderedTable" >
		<thead>
		 	<tr style="page-break-inside:avoid">
			<th valign="middle" width="15%"	align="center" ><strong>Day</strong></th>
			<th valign="middle" width="10%"	align="center"  ><strong>City</strong></th>
			<?php 
			$resultpageQuotation['hotCategory'];
			$hotCategory2 = explode(',',$resultpageQuotation['hotCategory']);
		
			$cols = count($hotCategory2);
				$colwidth = 75;

				$starwidth = $colwidth/$cols;
			foreach($hotCategory2 as $val2){
				$rsname1=GetPageRecord('*','hotelCategoryMaster','id="'.$val2.'"');
				$hotelCatData1=mysqli_fetch_array($rsname1);
				$hotelCategory = $hotelCatData1['hotelCategory'].' Star';
				?>
				<th  align="left" width="<?php echo $starwidth; ?>%" ><strong><?php echo $hotelCategory; ?></strong></th>
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
				<td valign="middle" align="center"><span><strong><?php echo "Day ".$day; if($dayWise == 1){   ?>  <?php echo date('D', strtotime($dayDate))."<br>"; echo date('j M Y', strtotime($dayDate)); }  ?></strong></span></td>
				<td valign="middle" align="center"><?php echo getDestination($QueryDaysData['cityId']); $destn = getDestination($QueryDaysData['cityId']); ?></td>
				<?php
				$hotCategory3 = explode(',',$resultpageQuotation['hotCategory']);
				foreach($hotCategory3 as $val3){
					?>
					<td  align="left">
					<?php 
					$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
					while($sorting1=mysqli_fetch_array($b1)){ 
						 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and supplementHotelStatus!=1 and id="'.$sorting1['serviceId'].'" and categoryId ="'.$val3.'"';   
						$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
						if(mysqli_num_rows($rs22) > 0){
							
							while($hotellisting=mysqli_fetch_array($rs22)){ 
								$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'" ');  
								$hotelData=mysqli_fetch_array($rs1ee);   
								//hotel details
								if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel:"; } echo $hotelData['hotelName'];
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
							}
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
			<th width="20%" valign="middle" ><strong>Day</strong></th>
			<th width="20%" valign="middle" ><strong>City</strong></th>
			<th width="60%" valign="middle" ><strong>Hotel</strong></th>
			</tr>
			
			<?php
			$quotationId=$resultpageQuotation['id'];
			$queryId=$resultpageQuotation['queryId']; 
			    
			$day=1;
			$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
			while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
				$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
				$dayId = $QueryDaysData['id']; 
				?><tr style="page-break-inside:avoid">
				<td valign="middle"><span><strong><?php echo "Day ".$day; if($querydata['dayWise'] == 1){ ?>  <?php echo date('D', strtotime($dayDate))."<br>"; echo date('j M Y', strtotime($dayDate)); } ?></strong></span></td>
				<td valign="middle"><?php echo getDestination($QueryDaysData['cityId']); $destn = getDestination($QueryDaysData['cityId']); ?></td>

				<td valign="middle"><?php 
				// services list
				$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
				$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
				while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
				
					if($itineryDayData['serviceType'] == 'hotel' ){
						$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
						while($sorting1=mysqli_fetch_array($b1)){ 
							 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and supplementHotelStatus!=1 and id="'.$sorting1['serviceId'].'"';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){
								
								while($hotellisting=mysqli_fetch_array($rs22)){ 
									$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
									$hotelData=mysqli_fetch_array($rs1ee);   
									//hotel details
									if($hotellisting['escortHotelStatus'] == 1){ echo "Escort Hotel:"; } echo $hotelData['hotelName'];
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
								} 
							}
						}
					} 
					
				}
				?></td>
				</tr>
			<?php $day++; } ?> 
		</table>
		<?php
	}
	?>
	</td></tr>
	</table><br>
	<!-- end dynamic hotel star -->

	<div class="docTitle" style="padding: 7px 29px; height:30px; font-weight:500; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; age-break-inside:avoid; text-align: center;">Tour&nbsp;Program</div>
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
             $destinationImage =  '<tr><td  align="center"><img src="'.$fullurl.str_replace(' ', '%20',$destinationImage2).'" width="790" height="auto" /></td></tr>';
            }
        }
		?><div  style=" page-break-inside:avoid;">
			<div style="font-size: 23px!important">&nbsp;&nbsp;<img src="<?php echo $fullurl.'images/icon-map-pointer.png'; ?>" width="35" height="35"  style="vertical-align: bottom;"/>&nbsp;Day&nbsp;<?php echo $day;?>&nbsp;<?php echo trim($destData22['name']);?> </div>

		<?php if($destinationImage!=''){ ?><br/>
		<table width="100%" border="0" cellpadding="15" cellspacing="0">
		<?php echo $destinationImage;  ?>
		</table>
		<?php } ?>
		</div>
		<table  width="100%" border="0" cellpadding="15" cellspacing="0" ><tr><td><div class="serviceDesc" style="text-align: justify;page-break-inside: auto;"><?php
			if(strlen($QueryDaysData['title'])>1) {
				echo "<strong>".trim(urldecode(strip($QueryDaysData['title'])))." - </strong>";
				echo "<br />";
			}

			$html = trim(urldecode(strip($QueryDaysData['description'])));
			if($html!=''){
			
				$html = str_replace('<ul>','<p>', $html);
				$html = str_replace('</ul>','</p>', $html);
				$html = str_replace('<li>','<p>', $html);
				$html = str_replace('</li>','</p>', $html);
				$html = str_replace('<p>&nbsp;</p>', '', $html);
				// $html = str_replace('<p>', '<span>', $html);
				// $html = str_replace('</p>', '</span>', $html);
				echo html_tidy($html);
				
			}

			// destination INformation
			if(${"destination".trim($destData22['id'])} != 1){
				${"destination".trim($destData22['id'])}=1;

				$destInfo = html_tidy(stripslashes($destData22['description']));
				if($destInfo!=''){
					echo "<p>";
					echo "<strong>".trim($destData22['name'])." - </strong> ";
					echo strip_tags(strip($destInfo));
					// $destInfo = str_replace('<p>&nbsp;</p>', '', $destInfo);
					// $destInfo = str_replace('<p>', '<span>', $destInfo);
					// echo $destInfo = str_replace('</p>', '</span>', $destInfo);

					echo "</p>";
				}
			} 

			echo '<p><img src="'.$fullurl.'images/icon-home.png" width="20" height="20" style="vertical-align: bottom;"/>&nbsp;&nbsp;';
			echo "Overnight stay in the Hotel at ".ucfirst($destData22['name']);
			// echo "<strong>Overnight stay&nbsp;at&nbsp;the&nbsp;Hotel in ".trim($destData22['name'])."</strong></p><br>";


			// services list
			$cnt1 = 1;
			// services list
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc,id desc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){
			
				if($itineryDayData['serviceType'] == 'hotela' ){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and supplementHotelStatus!=1 and id="'.$itineryDayData['serviceId'].'"';   
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
							// echo "</p>";
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
					$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'"  and isGuestType=1 order by id desc');  
					if(mysqli_num_rows($rs22dd) > 0){
						while($transferlisting=mysqli_fetch_array($rs22dd)){  
						$rs2ss=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs2ss);   
						//transfer detail
							echo "<p>";
							?><img src="<?php echo $fullurl.'images/icon-transfer.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;<?php
							echo "<strong>".ucfirst($transfergdetail['transferName'])."</strong></p>";	
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
							echo "<p>";
							echo "<b>".ucfirst($entranceData['entranceName'])." - </b>";
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


				if($itineryDayData['serviceType'] == 'additional'){ 
					$where2='quotationId="'.$quotationId.'" and id="'.$itineryDayData['serviceId'].'"';						
					$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
					if(mysqli_num_rows($b) > 0){
						$additionalQuotData=mysqli_fetch_array($b);
						$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
						$extraData=mysqli_fetch_array($rs1); 
						echo "<p>";?>
						<img src="<?php echo $fullurl.'images/additionalimage.jpg'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;
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
						?><img src="<?php echo $fullurl.'images/icon-meals.png'; ?>" width="20" height="20"  style="vertical-align: bottom;"/>&nbsp;&nbsp;<?php
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
							echo "<p>";
							echo "<b>".ucfirst($quotationotherActivityData['otherActivityName'])."</b> - ";
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
	} ?>		
	<br />
	<table width="100%"  border="0" cellpadding="0" cellspacing="0" borderColor="#ccc">
	<tr>
		<td colspan="2" align="center"><strong>End of the tour</strong></td>
	</tr>
	<tr style="page-break-before:always;">
		<td colspan="2" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left">
			<div class="docTitle" style="padding: 7px 29px; height:30px; font-weight:500; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Costing Details</div></td>
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
	
	<?php 

	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
	?> 
	<br>
	<div class="docTitle" style="padding: 7px 29px; height:30px; font-weight:500 !important; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">AIR FARE SUPPLEMENT</div>
	<table border="0" cellpadding="15" cellspacing="0" borderColor="#ccc" width="100%">
	<tr>
	<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
			<tr style="padding: 8px 29px !important;position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="20%" align="center" valign="middle" ><strong>Date</strong></th>
				<th width="18%" align="center" valign="middle" ><strong>Sector</strong></th>
				<th width="25%" align="center" valign="middle" ><strong>Flight/Timings</strong></th>
				<th width="18%" align="center" valign="middle" ><strong>Class/Baggage</strong></th>
				<th width="19%" align="right" valign="middle" ><strong>Fare</strong></th>
			</tr>
			<?php 
			while($flightQuotData=mysqli_fetch_array($betet)){
	           
				$d5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');  
				$flightData=mysqli_fetch_array($d5); 

				$departurefrom = getDestination($flightQuotData['departureFrom']);
				$arrivalTo = getDestination($flightQuotData['arrivalTo']);
				?> 
			  <tr>
					<td align="center" valign="middle"><strong>
					<?php 
					echo date('l, dS F, Y',strtotime($flightQuotData['fromDate']));  
					?></strong></td>
					<td align="center" valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
					<td align="center" valign="middle"><?php echo strip($flightQuotData['flightNumber']);  
					if(!empty($flightQuotData['departureTime']) || !empty($flightQuotData['arrivalTime'])){ echo " at ".date('Hi',strtotime($flightQuotData['departureTime']))."/".date('Hi',strtotime($flightQuotData['arrivalTime']))." Hrs"; }   ?></td>		
					<td align="center" valign="middle"><?php echo str_replace('_',' ',$flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
					<td align="right" valign="middle"><strong><?php echo getCurrencyName($resultpageQuotation['currencyId']); ?>&nbsp;<?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?>
				       </strong></td>
	 			</tr>
			  <?php 
			} ?>
		  <tr>
		  	<td colspan="5" align="left"><strong>Note:</strong> This is the present airfare and is subject to change and we cannot guarantee the airfare before issuing the flight tickets.</td>
		  </tr>
		</table>
	</td>
	</tr>
	</table> 
	<br />
	<?php 
	}  


	$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplementHotelStatus=1 ');
	$checkSuppTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=1 ');

	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0 || mysqli_num_rows($checkSuppTQuery) > 0){
		?>
		<div class="docTitle" style="padding: 7px 29px;height:30px; font-weight:500 !important; line-height:30px; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; text-align:left!important;font-size: 15px;">Supplement Services</div>
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
		<?php 
	}  
	// INCLUDE SUPPLEMENT HOTEL AND RATE HERE
	$checkSuppTQuery="";
	$checkSuppTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=1 ');
	if(mysqli_num_rows($checkSuppTQuery) > 0){ ?>
		<div class="table-service pd30" > 
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'transferSupplement';
			include('proposal_parts.php');
			?>
		</div>
		<?php 
	}  


	// additional requirment 
	$c12=GetPageRecord('*','quotationAdditionalMaster',' quotationId="'.($quotationId).'" group by serviceType order by id asc');
	if( mysqli_num_rows($c12) > 0){ ?>
		<div class="docTitle " style="padding: 7px 29px; height:30px; font-weight:500 !important; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; text-align:left!important;font-size: 15px;">Additional Experiences</div>
		<div class="table-service pd30" > 
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			$_REQUEST['parts'] = 'additionalSupplement';
			include('proposal_parts.php');
			?>
		</div> 
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
				<table border="0" cellpadding="20" cellspacing="0" width="100%" >
					<tr style="page-break-inside: avoid;">
						<td class="docTitle" style="padding: 7px 29px; font-weight:500 !important; height:30px; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; age-break-inside: avoid;text-align:left!important;font-size: 15px;">Tour Overview</td>
					</tr>
					<tr>
						<td valign="top"><?php echo html_tidy($overviewText);  ?></td>
					</tr>
				</table>
				<br> 
				<?php 
			}  
			if($inclusion!=''){ ?> 
				<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
					<tr style="page-break-inside: avoid;">
						<td class="docTitle" style="padding: 7px 29px; font-weight:500 !important; height:30px; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; age-break-inside: avoid;text-align:left!important;font-size: 15px;">Inclusions</td>
					</tr>
					<tr>
						<td valign="top"><?php echo html_tidy($inclusion);  ?></td>
					</tr>
				</table>
				<br> 
				<?php 
			} 
			if($exclusion!=''){ ?> 
				<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
					<tr style="page-break-inside: avoid;">
						<td class="docTitle" style="padding: 7px 29px; font-weight:500 !important; height:30px; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; age-break-inside: avoid;text-align:left!important;font-size: 15px;">Exclusions</td>
					</tr>
					<tr>
						<td valign="top"><?php echo html_tidy($exclusion);  ?></td>
					</tr>
				</table>
				<br> 
				<?php 
			} 
			if($tncText!=''){ ?> 
				<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
					<tr style="page-break-inside: avoid;">
						<td class="docTitle" style="padding: 7px 29px;height:30px; font-weight:500 !important; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; age-break-inside: avoid;text-align:left!important;font-size: 15px;">Terms & Conditions</td>
					</tr>
					<tr>
						<td valign="top"><?php echo html_tidy($tncText);  ?></td>
					</tr>
				</table>
				<br> 
				<?php 
			} 
			if($specialText!=''){ ?> 
				<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
					<tr style="page-break-inside: avoid;">
						<td class="docTitle" style="padding: 7px 29px;height:30px; font-weight:500 !important; line-height:30px; font-size: 18px!important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>; age-break-inside: avoid;text-align:left!important;font-size: 15px;padding:6px;">Cancellation Policies</td>
					</tr>
					<tr>
						<td valign="top"><?php echo html_tidy($specialText);  ?></td>
					</tr>
				</table>
				<br> 
				<?php 
			}   ?> 
			</td>
		</tr>
	</table>
	<?php 
	$selectF= 'footerstatus, footertext';
	$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
    $resultf = mysqli_fetch_assoc($resfooter);
	if($resultf['footerstatus']==1){ ?> 
	<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
	<td align="center"><a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" ><?php if($resultf['footertext']!=''){ echo $resultf['footertext']; }else{ ?> Generated by TravCRM <?php } ?> </a></td></tr></table>
	<?php } ?>
</div>  