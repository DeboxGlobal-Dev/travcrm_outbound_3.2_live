<?php 
include "inc.php";   

$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');  
$resultpageQuotation=mysqli_fetch_array($rsp);  

$select='*';  
$where='id="'.$resultpageQuotation['queryId'].'"';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 


$totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];
	$quotationId = $resultpageQuotation['id'];  
$queryId = $resultpage['id']; 	

$overviewText=$highlightsText=$inclusion=$exclusion=$tncText=$specialText='';
if($resultpageQuotation['overviewText']!='' || $resultpageQuotation['overviewText']!='undefined'){
	$overviewText=preg_replace('/\\\\/', '',clean($resultpageQuotation['overviewText'])); 
}
if($resultpageQuotation['highlightsText']!='' || $resultpageQuotation['highlightsText']!='undefined'){
	$highlightsText=preg_replace('/\\\\/', '',clean($resultpageQuotation['highlightsText']));
}
if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
	$inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
	$exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
}
if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
	$tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
}
if($resultpageQuotation['specialText']!='' || $resultpageQuotation['specialText']!='undefined'){
	$specialText=preg_replace('/\\\\/', '',clean($resultpageQuotation['specialText']));
}
	
if($resultpageQuotation['quotationSubject']!=''){
	$quotationSubject = preg_replace('/\\\\/', '',clean($resultpageQuotation['quotationSubject']));
}else{
	$quotationSubject = strtoupper(strip($resultpage['subject']));
}
?><!DOCTYPE html>
<html>
<body ><div style="display:none;display:none;visibility: hidden;height: 0;width: 0;position: fixed;left: 0;top: 0;" class="calcostsheet" >
<?php  
if($resultpage['travelType']==2){
	include_once("loadFITCostSheet_domestic.php"); 
}else{
	include_once("loadFITCostSheet.php"); 
}
?>
</div><style type="text/css">
div,p,span,table,td,tr,li,ul,body{
font-family: 'Open Sans', sans-serif;
}
div,p,span,li,ul,body{
font-size: 12px;
color: #323030; 
}
</style>
<div class="main-container" style="font-family: 'Open Sans', sans-serif; width: 100%;font-weight: 300;border: 1px solid #ffffff	;"><?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="3" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
    if($resListing3['fileId']!='' && file_exists($proposalPhoto3)==true){ ?>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
    			<tr>
					<td align="center" valign="top"><img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="620" height="80" >
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
				
				<tr><td align="center" style="text-transform: uppercase;font-size:13px;text-align:center;">
						<strong><?php echo date('dS F',strtotime($resultpageQuotation['fromDate'])).'&nbsp;-&nbsp;'.date('dS F Y',strtotime($resultpageQuotation['toDate']))  ?></strong><br/></td></tr>
			</table>
			<br>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" >
				
				<tr>
					<td align="center" style="width: 100%;">
				<?php
				$imagepath = 'dirfiles/'.$resultpageQuotation['image'];
				if($resultpageQuotation['image']!='' && file_exists($imagepath)==true){ ?>
					<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$imagepath); ?>" alt="" width="620" height="240">
					<?php
				}else{
					$rsb03='';
					$rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="3" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" order by id desc) order by id desc');
					$resListingb3=mysqli_fetch_array($rsb03);
					$proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
			        if($resListingb3['fileId']!='' && file_exists($proposalPhotob3)==true){ ?>
						<img align="center" src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotob3) ?>" width="620" height="240" >
						<?php
			        }
				}
		?>
		</td>
		</tr>
		</table>
		<br>
		<!-- Tour Overview -->
		<?php if($overviewText!=''){?> 
		
		<div class="serviceDesc  incl" style="text-align: justify;page-break-inside: auto;font-size: 12px; padding-bottom: 5px;">
					<div class="dayTitle" style="line-height: 25px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; page-break-inside:avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Overview</div>
		<table border="0" cellpadding="10" cellspacing="0"  width="100%" style="font-size:12px;">
			<tr>
				<td style="padding-bottom: 5px !important;">
				
					<!-- <p style="font-size: 13px!important"> -->
					<?php
					$overviewText = str_replace('<p>&nbsp;</p>', '', $overviewText);
					$overviewText = str_replace('<p>', '<span>', $overviewText);
					echo $overviewText = str_replace('</p>', '</span>', $overviewText);
					?>
					<!-- </p> -->
					<!-- <br> -->
				
				</td>
			</tr>
		</table>
		</div>
		<?php } ?>
		<!-- <br> -->
		
		<!-- Tour Highlight -->
		<?php if($highlightsText!=''){ ?>
		<div class="dayTitle" style="line-height: 25px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; page-break-inside:avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Tour Highlight</div>
		<table border="0" cellpadding="10" cellspacing="0"  width="100%" style="font-size:12px">
			<tr>
				<td style="padding-bottom: 5px !important;">
				
				<!-- <p style="font-size: 13px!important"> -->
					<?php
					$highlightsText = str_replace('<p>&nbsp;</p>', '', $highlightsText);
					$highlightsText = str_replace('<p>', '<span>', $highlightsText);
					echo $highlightsText = str_replace('</p>', '</span>', $highlightsText);
					?>
					<!-- </p> -->
				
				</td>
			</tr>
			
		</table>
		<?php } ?>
	<?php		
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
		<div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; page-break-inside:avoid;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('l',strtotime($dayDate));?> <?php echo date('j M Y',strtotime($dayDate));?></div>
		<table  width="100%" border="0" cellpadding="15" cellspacing="0" >
		<tr><td>
		<div class="serviceDesc" style="text-align: left;page-break-inside: auto;font-size: 13px;padding-bottom: 5px;line-height: 16px;font-weight: normal;"><?php
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
				echo "<br>";
			}

			// services list
			$cnt1 = 1;
			// services list 
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc,id desc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
			
				if($itineryDayData['serviceType'] == 'hotel' ){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$itineryDayData['serviceId'].'"';   
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
							// echo "</p>";
						}
					}
						 
				}
				
				if($itineryDayData['serviceType'] == 'transfer' || $itineryDayData['serviceType'] == 'transportation'){ 
					$rs22dd=GetPageRecord('*','quotationTransferMaster','quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc');  
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
							echo "<p style='font-family: serif;'><strong>".ucfirst($entranceData['entranceName'])."- "."</strong>";
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

	<div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;Hotels Proposed</div>
	<br />
	<table border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" style="page-break-after: auto;page-break-before: auto;width: 100%;" >
		 	<tr>
				<th width="30%" align="left" valign="middle" bgcolor="#133f6d" style="color:#fff;"><strong>Dates</strong></th>
				<th width="16%" align="left" valign="middle" bgcolor="#133f6d" style="color:#fff;"><strong>City</strong></th>
				<th width="34%" align="left" valign="middle" bgcolor="#133f6d" style="color:#fff;"><strong>Hotel</strong></th>
				<th width="20%" align="left" valign="middle" bgcolor="#133f6d" style="color:#fff;"><strong>Room Type</strong></th>
	 			<!-- <th width="13%" align="left" valign="middle" bgcolor="#133f6d" style="color:#fff;"><strong>Remarks</strong></th> -->
			</tr>
			<?php 
			$totalHotel = 0;
			$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="hotel" order by startDate asc'); 
			while($sorting3=mysqli_fetch_array($b1)){  
			
				$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$sorting3['serviceId'].'" and isHotelSupplement!=1');  
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
	<!-- Total Tour Cost and per person basis costs details -->
	<div class="table-service pd30" style="font-size: 12px;font-weight: normal;page-break-after: never;"> 
		<br /><?php
		$singleRoom = $resultpageQuotation['sglRoom'];
		$doubleRoom = $resultpageQuotation['dblRoom'];
		$tripleRoom = $resultpageQuotation['tplRoom'];
		$twinRoom   = $resultpageQuotation['twinRoom'];
		$EBedAdult = $resultpageQuotation['extraNoofBed'];
		$EBedChild = $resultpageQuotation['childwithNoofBed'];
		$NBedChild = $resultpageQuotation['childwithoutNoofBed'];

		$conspan = 0;
		if($singleRoom>0){ $conspan=$conspan+1; }
		if($doubleRoom>0 || $tripleRoom>0){ $conspan=$conspan+1; }
		if($tripleRoom>0){ $conspan=$conspan+1; }
		if($EBedAdult>0){ $conspan=$conspan+1; }
		if($EBedChild>0){ $conspan=$conspan+1; }
		if($NBedChild>0){ $conspan=$conspan+1; }
		$colsWidth = 80/$conspan;
		?> 
		<table width="100%"  border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
			<tr>
				<td>
					<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service" style="page-break-after: auto;page-break-before: auto;width: 100%;">
					<tr>
						<td style="background-color: #133f6d;color: #ffffff;text-align: left; page-break-inside: avoid;"  colspan="<?php echo $conspan+1; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<strong>QUOTATION</strong>  </td>
					</tr>
						<tr>
							<th width="20%" align="right" <?php if($conspan>0){ ?> rowspan="2" <?php } ?> valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Total&nbsp;Cost<br>(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></th>
							<?php if($conspan>0){ ?>
							<th width="80%" colspan="<?php echo $conspan; ?>" align="right" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Per Person Cost(In <?php echo getCurrencyName($newCurr); ?>)</strong></th>
							<?php } ?>
						</tr>
						<?php if($conspan>0){ ?>
						<tr>
							<?php if($singleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Single Basis</strong></th>
							<?php } if($doubleRoom>0 || $tripleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Double Basis</strong></th>
							<?php } if($tripleRoom>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Triple Basis</strong></th>
							<?php } if($EBedAdult>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>E.Bed(Adult) Basis</strong></th>
							<?php } if($EBedChild>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>CWB Basis</strong></th>
							<?php } if($NBedChild>0){ ?>
							<th width="<?php echo $colsWidth; ?>%" valign="middle" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>CNB Basis</strong></th>
							<?php } ?>
						</tr>
						<?php } ?>
						<tr>
							<td valign="middle">
								<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
							</td>
							<?php if($singleRoom>0){ ?>
							<td valign="middle">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
							</td>
							<?php } if($doubleRoom>0 || $tripleRoom>0){ ?>
							<td valign="middle">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
							</td>
							<?php } if($tripleRoom>0){ ?>
							<td valign="middle">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnTripleBasis)); ?>
							</td>
							<?php } if($EBedAdult>0){ ?>
							<td valign="middle">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedABasis)); ?>
							</td>
							<?php } if($EBedChild>0){ ?>
							<td valign="middle">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
							</td>
							<?php } if($NBedChild>0){ ?>
							<td valign="middle">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraNBedCBasis)); ?>
							</td>
							<?php } ?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- <br />  -->
		<!-- <br /> -->
	</div>  
	<?php  

	$totalFlight= 0;
	$betet=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' quotationId="'.$quotationId.'" order by id asc'); 
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){ 
	?> 
	<div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;AIR FARE SUPPLEMENT</div>
	<table border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table border="1" cellpadding="5" width="100%" cellspacing="0" bordercolor="#ddd" class="borderedTable" >
			<tr>
				<th width="20%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Date</strong></th>
				<th width="19%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Sector</strong></th>
				<th width="25%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Flight/Timings</strong></th>
				<th width="18%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Class/Baggage</strong></th>
				<th width="13%" align="right" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Fare</strong></th>
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

	$suppRoomQuery="";
	$suppRoomQuery=GetPageRecord('*','quotationRoomSupplimentMaster','quotationId="'.$resultpageQuotation['id'].'" ');

	$checkSuppHQuery="";
	$checkSuppHQuery=GetPageRecord('*','quotationHotelMaster','quotationId="'.$resultpageQuotation['id'].'" and isHotelSupplement=1 ');
	if(mysqli_num_rows($checkSuppHQuery) > 0 ||  mysqli_num_rows($suppRoomQuery) > 0){
		?>
		<div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;Hotel/Room Supplement</div>
		<table border="0" cellpadding="15" cellspacing="0" borderColor="#ccc">
		<tr>
		<td>
			<?php  
			$queryId = $resultpageQuotation['queryId'];
			$quotationId= $resultpageQuotation['id'];
			include('quotationSupplementHoteltable.php');
			?>
		</td>
		</tr>
		</table>
		<br />	
		<?php 
	} 
	// $overviewText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $overviewText));
	// $highlightsText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $highlightsText));
	// $inclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $inclusion));
	// $exclusion = str_replace('li>', 'div>', str_replace('ul>', 'div>', $exclusion));
	// $tncText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $tncText));
	// $specialText = str_replace('li>', 'div>', str_replace('ul>', 'div>', $specialText));
	?>
	<!-- <br /> -->
	
	<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		
		<tr>
			
			<td style="padding-bottom: 5px !important;">
			
		<?php if($inclusion!=''){ ?> 
		<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>; page-break-inside: avoid;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Inclusions
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($inclusion);  ?>
			</td>
		</tr>
	</table>
	<br><br>
	<?php } if($exclusion!=''){ ?>

		<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>; page-break-inside: avoid;line-height:1;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Exclusions
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($exclusion); ?>
			</td>
		</tr>
	</table>
	<br><br>
	<?php } if($tncText!=''){ ?>
			<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;page-break-inside:avoid;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Terms & Conditions
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($tncText); ?>
			</td>
		</tr>
	</table>
	<br><br>
	<?php }  if($specialText!=''){ ?>
			<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>; page-break-inside:avoid;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Cancellation Policies
			</td>
		</tr>
		<tr>
		<td>
			<?php echo strip($specialText); ?>
			</td>
		</tr>
	</table>
	<?php } ?>
			</td>
		</tr>
	</table>
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
</body>
</html>


