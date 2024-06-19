<div class="main-container" >
	<br>
	<style type="text/css"> 
		
		@media print{
		    .main-container,body{
		        background-color: #ffffff !important;
		        margin-top: -30px!important;
		    }
		    div,ul,li,body,button{
				margin: 0;
			    padding: 0;
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
			    border-left: 0px solid #233a4900;
			    border-bottom: 53px solid #233a49;
			    border-right: 40px solid #fff0;
			    border-top: 0px solid #233a49;
			}
		}
		div,ul,li,body,button{
			margin: 0;
		    padding: 0;
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
			font-size: 14px!important;
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
		    font-size: 18px;
		    padding: 8px;
		    margin-bottom: 10px;
		    text-align: left;
		    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
	    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    /*color: white;*/
		    /*background-color: #233a49;*/
	    }
	    .serviceTitle{
	      	font-size: 18px;
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
		    padding: 4px 30px;
		    font-weight: 400;
		    font-size: 18px;
		    position: relative;
		 
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
	<?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="3" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
    if($resListing3['fileId']!='' && file_exists('../'.$proposalPhoto3)==true){ ?>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
    			<tr>
					<td align="center" valign="top"><img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="800" height="80" >
					</td>
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
			$imagepath = 'upload/'.$resultpageQuotation['image'];
			if($resultpageQuotation['image']!='' && file_exists('../'.$imagepath)==true){ ?>
				<img align="center" src="<?php echo $fullurl.'PreviewFiles/'.str_replace(' ','%20',$imagepath); ?>" alt="" width="800" height="300">
				<?php
			}else{
				$rsb03='';
				$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="3" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" order by id desc) order by id desc');
				$resListingb3=mysqli_fetch_array($rsb03);
				$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
		        if($resListingb3['fileId']!='' && file_exists('../'.$proposalPhotob3)==true){ ?>
					<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>" width="800" height="300" >
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
	<div class="docTitle" style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Overview</div>
	<table border="0" cellpadding="20" cellspacing="0"  width="100%"  >
		<tr>
			<td style="padding-bottom: 5px !important;">
			
				<p style="font-size: 14px!important">
				<?php
				$overviewText = str_replace('<p>&nbsp;</p>', '', $overviewText);
				$overviewText = str_replace('<p>', '<span>', $overviewText);
				echo $overviewText = strip_tags(str_replace('</p>', '</span>', $overviewText));
				?>
				</p>
				<!-- <br> -->
			
			</td>
		</tr>
	</table>
	</div>
	<?php } ?>
	<br>
	
	<!-- Tour Highlight -->
	<?php if($highlightsText!=''){ ?>
	<div class="docTitle" style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Tour Highlight</div>
	<table border="0" cellpadding="20" cellspacing="0"  width="100%" >
		<tr>
			<td style="padding-bottom: 5px !important;"> 
				<?php
				$highlightsText = str_replace('<p>&nbsp;</p>', '', $highlightsText);
				$highlightsText = str_replace('<p>', '<span>', $highlightsText);
				echo $highlightsText = str_replace('</p>', '</span>', $highlightsText);
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
		<!-- <br>
		<br> -->
		<div class="docTitle" style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;"><?php echo date('l',strtotime($dayDate));?> <?php echo date('j M Y',strtotime($dayDate));?></div>
		<table  width="100%" border="0" cellpadding="30" cellspacing="0" >
		<tr><td>
		<div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-weight: normal;"><?php
			if(strlen($QueryDaysData['title'])>1) { 
				echo "<strong>".urldecode(strip($QueryDaysData['title']))."</strong><br>"; 
			} 
			$html = clean(urldecode(strip($QueryDaysData['description'])));
			if($html!=''){
				// echo "<p>";
				$html = str_replace('<ul>','<span>', $html);
				$html = str_replace('</ul>','</span>', $html);
				$html = str_replace('<li>','<span>', $html);
				$html = str_replace('</li>','</span>', $html);
				$html = str_replace('<p>&nbsp;</p>', '', $html);
				$html = str_replace('<p>', '<span>', $html);
				echo $html = str_replace('</p>', '</span>', $html);
				// echo "</p>";
			}

			// services list
			$cnt1 = 1;
			// services list 
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc,id desc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
			
				if($itineryDayData['serviceType'] == 'hotel' ){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and supplementHotelStatus!=1 and id="'.$itineryDayData['serviceId'].'"';   
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
						}
					}
						 
				}
				
				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'"  and isGuestType=1 order by id desc');  
					if(mysqli_num_rows($rs22dd) > 0){
						while($transferlisting=mysqli_fetch_array($rs22dd)){  
						$rs2ss=GetPageRecord('transferName',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferlisting['transferNameId'].'"'); 
						$transfergdetail=mysqli_fetch_array($rs2ss);   
						//transfer detail
						echo "<p><strong>Transport - </strong>".ucfirst($transfergdetail['transferName'])."";		
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
							echo "<p ><strong>".ucfirst($entranceData['entranceName'])."- "."</strong>";
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
							$quotationotherActivityData=mysqli_fetch_array($rs1);   
							echo "<p><strong>".ucfirst($quotationotherActivityData['otherActivityName'])."- "."</strong>";
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
	<!-- <br />
	<table border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
	<tr> <td>	
	<div class="serviceTitle" style="text-align: justify;font-size: 16px;padding-bottom: 5px;line-height: 20px;color: #133f6d;font-weight: 700;">* Please note that your itinerary may be subject to change depending on weather conditions, local events, domestic flight/train time changes and cancellations.</div>
		</td></tr>	
	</table> -->
	<br />

	<div class="docTitle" style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Hotels Proposed</div>
	<table width="100%"  border="0" cellpadding="30" cellspacing="0" borderColor="#ccc">
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
			} ?>
		</table>
	</td>
	</tr>
	</table> 
	<br />
	<!-- Total Tour Cost and per person basis costs details -->
	<div class="docTitle" style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Costing Details</div>  
	<?php  
	$queryId = $resultpageQuotation['queryId'];
	$quotationId= $resultpageQuotation['id'];
	$_REQUEST['parts'] = 'costingDetail';
	include('proposal_parts.php');
	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
	?> 
	<div class="docTitle" style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">&nbsp;&nbsp;&nbsp;&nbsp;AIR FARE SUPPLEMENT</div>
	<table  width="100%" border="0" cellpadding="30" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
			<tr style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">
				<th width="20%" valign="middle" bgcolor="#133f6d" ><strong>Date</strong></th>
				<th width="19%" valign="middle" bgcolor="#133f6d" ><strong>Sector</strong></th>
				<th width="25%" valign="middle" bgcolor="#133f6d" ><strong>Flight/Timings</strong></th>
				<th width="18%" valign="middle" bgcolor="#133f6d" ><strong>Class/Baggage</strong></th>
				<th width="13%" align="right" valign="middle" bgcolor="#133f6d" ><strong>Fare</strong></th>
			</tr>
			<?php 
			while($flightQuotData=mysqli_fetch_array($betet)){ 
	           
				$d5=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuotData['flightId'].'"');  
				$flightData=mysqli_fetch_array($d5); 

				$departurefrom = getDestination($flightQuotData['departureFrom']);
				$arrivalTo = getDestination($flightQuotData['arrivalTo']);
				?> 
			  <tr>
					<td valign="middle"><strong>
					<?php 
					echo date('l, dS F, Y',strtotime($flightQuotData['fromDate']));  
					?></strong></td>
					<td valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
					<td valign="middle"><?php echo strip($flightQuotData['flightNumber']);  
					if(!empty($flightQuotData['departureTime']) || !empty($flightQuotData['arrivalTime'])){ echo " at ".date('Hi',strtotime($flightQuotData['departureTime']))."/".date('Hi',strtotime($flightQuotData['arrivalTime']))." Hrs"; }   ?></td>		
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
 

	$suppRoomQuery=$checkSuppHQuery=$checkSuppTQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$quotationId.'" ');
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$quotationId.'" and supplementHotelStatus=1 ');
	$checkSuppTQuery=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$quotationId.'" and isSupTPTType=1 ');

	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0 || mysqli_num_rows($checkSuppTQuery) > 0){
		?>
		<div class="docTitle" style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">SUPPLEMENT SERVICES</div>
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
		<div class="docTitle " style="padding: 10px 29px !important; color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Additional Experiences (Suppliment)</div>
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

	?>
	<!-- <br /> -->
<?php if($inclusion!=''){ ?> 
	<div class="docTitle" style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">INCLUSIONS</div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($inclusion)); ?></div>
<?php } if($exclusion!=''){ ?> 
	<div class="docTitle " style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">EXCLUSIONS</div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($exclusion)); ?></div>
<?php } if($tncText!=''){ ?> 
	<div class="docTitle " style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Terms & Conditions</div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($tncText)); ?></div>
<?php } if($specialText!=''){ ?> 
	<div class="docTitle" style="padding: 7px 29px !important; position: relative;color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;">Cancellation Policies</div>
	<div class="serviceDesc pd30"><?php echo html_tidy(strip($specialText)); ?></div>
<?php } ?>
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